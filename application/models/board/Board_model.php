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
	
	public function fetchlist()
	{
		$source = httpGet('http://www1.szu.edu.cn/board/');
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
				//$db->delete('sdbk_board', array('aid' => $aid));
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
				//$db->insert('sdbk_board', $items[$i]);
				$this->db->insert('sdbk_board', $items[$i]);
				$log['insert']++;
				array_push($log['changelist'], $items[$i]);
			}
			
		}
		return $log;
	}
	
	public function push_board($fetchBoard)
	{
		/*if ($fetchBoard['insert'] + $fetchBoard['update'] == 0) {
			exit();
		}

		$template_id = 'GubOb2rVk10m-qbu0cjicpgqcKoZljyi2aqQoQCaHhY';

		global $token;
		global $obj;

		foreach ($fetchBoard['changelist'] as $item) {
			//$templeurl = 'http://www.szuswzx.com/board/id=' . $item['aid'];
			$templeurl = 'http://www.szuswzx.com/board/#!/article/' . $item['aid'];
			$textPic = array(
				'first' => array('value'=> '有新的公文通！\n\n' . $item['title'], 'color'=> '#F45757'),
				'keyword1' => array('value'=> '深圳大学', 'color'=> '#333'),
				'keyword2' => array('value'=> $item['department'], 'color'=> '#333'),
				'keyword3' => array('value'=> $item['lastedit'], 'color'=> '#333'),
				'keyword4' => array('value'=> substr(strip_tags($item['article']), 0, 30), 'color'=> '#333'),
				'remark' => array('value'=> '', 'color'=> '#bbbbbb'),
			);
			$obj->pushtemple($token['access_token'], 'ohHvIjoJeahJQ_e1svpDIv2YAlS4', $template_id, $templeurl, $textPic);
			$obj->pushtemple($token['access_token'], 'ohHvIjmSs7vc2jx6xzxwozfl_bdk', $template_id, $templeurl, $textPic);
			//$obj->pushtemple($token['access_token'], 'ohHvIjk5Oh7dU8BE0vYd3Pe1HnHs', $template_id, $templeurl, $textPic);
			
		}*/
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