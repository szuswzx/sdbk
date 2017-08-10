<?php
class Board_model extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
	  $this->load->database();
	  $this->app_id = $this->config->item('app_id');
	  $this->app_secret = $this->config->item('app_secret');
	  $this->template_id = $this->config->item('board_template_id');
	}
	
	//从校内网抓取公文通同时更新数据
	public function fetchlist()
	{
		$source = $this->httpGet('http://www1.szu.edu.cn/board/');
		$source = preg_replace('/\s{2,}|\r|\n/', '', iconv('GBK', 'UTF-8', $source));

		// 获取列表区域的HTML代码
		$listAreaPattern = '/<table border="0" cellpadding=3 style="border-collapse: collapse" width="98%">(.+)<\/table>/';
		preg_match($listAreaPattern, $source, $listArea);
		$listArea = $listArea[1];

		// 获取每行数据
		$listsPattern = '/<tr [bgcolor=#FFFFFF]*><td align="center">.*<\/td><td align="center" style="font-size: 9pt">.*<\/td><td align="center" style="font-size: 9pt">.*<\/td><td>.*<\/td><td align="center">.*<\/td><td align="center" style="font-size: 9pt">.*<\/td><\/tr>/U';
		preg_match_all($listsPattern, $listArea, $lists);
		$lists = $lists[0];

		// 解析每行数据
		$items = array();
		foreach ($lists as $list) {
			$item = array();

			// 获取类别
			preg_match('/<a href="\?infotype=[^"]*">(.*)<\/a>/U', $list, $temp);
			$item['type'] = $temp[1];
			// 获取部门
			preg_match('/<a href=# onclick="[^"]*">(.*)<\/a>/U', $list, $temp);
			$item['department'] = $temp[1];
			// 获取aid和标题
			preg_match('/<a target=_blank href="view.asp\?id=(\d{6})" class=fontcolor3>(.*)<\/a>/U', $list, $temp);
			$item['aid'] = $temp[1];
			$item['title'] = str_replace('·', '', strip_tags($temp[2]));
			// 是否置顶
			$item['fixed'] = preg_match('/置顶/', $list) ? 1 : 0;
			// 是否有附件
			$item['attachment'] = preg_match('/attach.gif/', $list) ? 1 : 0;
			// 更新日期
			preg_match('/(\d{4}-\d{1,2}-\d{1,2})/', $list, $temp);
			$item['date'] = $temp[1];

			// 获取最后更新时间
			// $detailPageSrc = file_get_contents('http://cie.szu.edu.cn/antennas/sdbk/proxy.php?url=http://www1.szu.edu.cn/board/view.asp?id=' . $aid, false, $context);
			$detailPageSrc = $this->httpGet('http://www1.szu.edu.cn/board/view.asp?id=' . $item['aid']);
			$detailPageSrc = iconv('GBK', 'UTF-8', $detailPageSrc);

			$fetchedLastEdit = preg_match('/更新于(\d{4}-\d{1,2}-\d{1,2}\s+\d{1,2}:\d{1,2}:\d{1,2})/', $detailPageSrc, $lastEdit);

			if ($fetchedLastEdit) {
				$item['lastedit'] = $lastEdit[1];
			} else {
				$item['lastedit'] = '';
			}

			array_push($items, $item);
		}

		$items = array_reverse($items);

		$log = array(
			'insert' => 0,
			'update' => 0,
			'jump' => 0,
			'changelist' => array()
		);
		//先取消所有置顶
		$field = array('fixed' => 0);
		$options = array('fixed' => 1);
		$this->db->set($field);
		$this->db->where($options);
		$this->db->update('sdbk_board');
		
		for ($i = 0; $i < count($items); $i++) {
			$aid = $items[$i]['aid'];

			//$isSaved = $db->get_one('sdbk_board', array('aid' => $aid));
			//根据aid获取数据库公文通
			$this->db->where(array('aid' => $aid));
			$query = $this->db->get('sdbk_board');
			$isSaved = $query->row_array();

			if ($isSaved) {
				if ($isSaved['lastedit'] == $items[$i]['lastedit'] && $items[$i]['fixed'] != 1) {
					$log['jump']++;
					continue;
				} else if ($items[$i]['lastedit'] == "") {
					$log['jump']++;
					continue;
				}
				$items[$i]['fetchtime'] = time() + $i;
				$this->db->where(array('aid' => $aid));
				$this->db->delete('sdbk_board');
				
				$this->db->insert('sdbk_board', $items[$i]);
				if ($items[$i]['fixed'] != 1) {
					$log['update']++;
					array_push($log['changelist'], $items[$i]);
				} else {
					$log['jump']++;
				}
			} else {
				$items[$i]['fetchtime'] = time() + $i;
				$this->db->insert('sdbk_board', $items[$i]);
				$log['insert']++;
				array_push($log['changelist'], $items[$i]);
			}
			
		}
		return $log;
	}
	
	//对绑定了公文通提醒的用户推送最新的公文通提醒通知
	public function push_board($fetchBoard, $access_token)
	{
		if ($fetchBoard['insert'] + $fetchBoard['update'] == 0) {
			return 0;
		}

		$this->load->library('weixin', $config = array('AppId' => $this->app_id, 'AppSecret' => $this->app_secret));//220测试
		$this->template_id = 'hvsefOHltcPW0fMhNj_8jwqEMUQtr9Zs_JX90sYrIQA';
		//获取需要推送的用户名单
		$query = $this->db->where(array('bind' => 1))->get('sdbk_board_bind');
		$board_user = $query->result_array();

		foreach ($fetchBoard['changelist'] as $item) {
			$templeurl = base_url("board/fetch_article/"). $item['aid'];
			$textPic = array(
				'first' => array('value'=> '有新的公文通！\n\n' . $item['title'], 'color'=> '#F45757'),
				'keyword1' => array('value'=> '深圳大学', 'color'=> '#333'),
				'keyword2' => array('value'=> $item['department'], 'color'=> '#333'),
				'keyword3' => array('value'=> $item['lastedit'], 'color'=> '#333'),
				'keyword4' => array('value'=> "详情请点击此条通知", 'color'=> '#333'),
				'remark' => array('value'=> '', 'color'=> '#bbbbbb'),
			);
			
			//根据绑定的userid获取openid
			foreach($board_user as $row)
			{
				$options = array('userid' => $row['userid']);
				$query = $this->db->where($options)->get('sdbk_user');
				$user = $query->row_array();
				//$this->weixin->pushtemple($access_token, $user['openid'], $this->template_id, $templeurl, $textPic);
			}
			$this->weixin->pushtemple($access_token, 'oNjPnw-AuKkwq7yYbcSwn9uZzrf8', $this->template_id, $templeurl, $textPic);
		}
		return 1;
	}
	
	//输出公文通列表
	public function get_board_list($page = 1, $options = array())
	{
		$startRow = ($page - 1) * 20;

		$this->db->where($options);
		$this->db->order_by('fetchtime', 'DESC');
		$this->db->limit(20, $startRow);
		$query = $this->db->get('sdbk_board');
		$board = $query->result_array();

		return $board;
	}
	
	//根据标题模糊查找公文通
	public function search_board($page = 1)
	{
		$keyword = $this->input->post('keyword');
		$keyword = $this->security->xss_clean($keyword);
		if($keyword != '')
		{
			$startRow = ($page - 1) * 20;

			$this->db->or_like('title', $keyword);
			$this->db->order_by('fetchtime', 'DESC');
			$this->db->limit(20, $startRow);
			$query = $this->db->get('sdbk_board');
			$board = $query->result_array();
		}
		else
			$board = array();
		
		return $board;
	}
	
	public function fetch_article($aid = 0)
	{
		$source = $this->httpGet('http://www1.szu.edu.cn/board/view.asp?id=' . $aid);
		$source = preg_replace('/\s{2,}|\r|\n/', '', iconv('GBK', 'UTF-8', $source));

		preg_match('/(\d{4}-\d{1,2}-\d{1,2}\s+\d{1,2}:\d{1,2}:\d{1,2}).+/', $source, $lastEdit);

		$this->db->where(array('aid' => $aid));
		$query = $this->db->get('sdbk_board_article');
		$isSaved = $query->row_array();

		if (count($isSaved) != 0 && $isSaved['lastedit'] == $lastEdit[1]) {
			return $isSaved;
		} else {
			$article = array();
			$article['aid'] = $aid;

			// 获取文章区域
			$artilcleAreaPattern = '/<table border="0" cellspacing="0" cellpadding=4 style="border-collapse: collapse" width="85%"(.+)<\/table>/';
			
			preg_match($artilcleAreaPattern, $source, $articleArea);
			$articleArea = $articleArea[1];

			// 获取标题
			preg_match('/<td class=fontcolor3 align=center height="60">(.*)<\/td>/U', $articleArea, $temp);
			$article['title'] = preg_replace('/^\s+|\s+$|　+/', '', strip_tags($temp[1]));
			// 获取部门和发布时间
			preg_match('/<td align=center height=30 style="font-size: 9pt">(.*)<\/td>/U', $articleArea, $temp);
			$temp = explode('　', strip_tags($temp[1]));
			$article['department'] = $temp[0];
			$article['releasetime'] = $temp[1];
			// 获取文章
			preg_match_all('/<tr>(.*)<\/tr>/U', $articleArea, $temp);
			$article['article'] = $temp[1][2];
			$article['article'] = preg_replace('/\s+style="[^"]+"/', '', $article['article']);
			$article['article'] = preg_replace('/\s+width="[^"]+|width=\d+/', '', $article['article']);
			$article['article'] = preg_replace('/\s+lang="[^"]+"/', '', $article['article']);
			$article['article'] = preg_replace('/\s+lang=[^>]+/', '', $article['article']);
			$article['article'] = preg_replace('/\s+href="mailto:[^"]+"/', '', $article['article']);
			$article['article'] = preg_replace('/<SPAN><\\SPAN>/', '', $article['article']);
			$article['article'] = preg_replace('/<SPAN>(.*)<\/SPAN>/U', '$1', $article['article']);
			$article['article'] = preg_replace('/\/board\/uploadfiles\//U', 'http://www1.szu.edu.cn/board/uploadfiles/', $article['article']);
			$article['article'] = str_replace('<?xml:namespace prefix = o ns = "urn:schemas-microsoft-com:office:office" />', '', $article['article']);
			// 获取附件
			$attExisted = preg_match_all('/<a href=uploadfiles\/.* target=_blank>.*<\/a>/U', $articleArea, $temp);
			if ($attExisted) {
				$attrs = array();
				foreach ($temp[0] as $attr) {
					$a = array();

					preg_match('/<a href=uploadfiles\/(.*) target=_blank>(.*)<\/a>/U', $attr, $atemp);

					$a['url'] = 'http://www1.szu.edu.cn/board/uploadfiles/' . $atemp[1];
					$a['name'] = str_replace('·', '', $atemp[2]);

					array_push($attrs, $a);
				}
				$article['attachment'] = base64_encode(json_encode($attrs));
			} else {
				$article['attachment'] = base64_encode(json_encode(array()));
			}

			$article['lastedit'] = $lastEdit[1];

			if ($isSaved) {
				$article['count'] = $isSaved['count'];
				$this->db->set($article);
				$this->db->where(array('aid' => $aid));
				$this->db->update('sdbk_board_article');
			} else {
				$article['count'] = 0;
				$this->db->insert('sdbk_board_article', $article);
			}
			return $article;
		}
	}
	
	function httpGet ($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, 'http://cie.szu.edu.cn/antennas/sdbk/proxy1.php?url='.urlencode($url));
		$request = curl_exec($curl);
		curl_close($curl);
		return $request;
	}
	
}