<?php
class Activity_model extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
	  $this->load->database();
	  $this->app_id = $this->config->item('app_id');
	  $this->app_secret = $this->config->item('app_secret');
	  $this->template_id = $this->config->item('activity_template_id');
	}
	
	public function add_activity()
	{
		$activity = array(
			'name' => $this->input->post('name'),
			'startTime' => $this->input->post('startTime'),
			'endTime' => $this->input->post('endTime'),
			'param' => $this->input->post('parameters'),
			'limit' => $this->input->post('limit')
		);
		$activity['startTime'] = strtotime($activity['startTime']);
		$activity['endTime'] = strtotime($activity['endTime']);
		$activity['param'] = json_encode($activity['param'], JSON_UNESCAPED_UNICODE);
		if($activity['param'] == 'null')
			$activity['param'] = json_encode(array());
		//判断开始时间不能大于结束时间
		if($activity['startTime'] < $activity['endTime'])
			$insert = $this->db->insert('sdbk_activity', $activity);
		else
			$insert = "time_error";
		return $insert;
	}
	
	public function get_activity($options = array(), $field = array())
	{
		$this->db->select($field);
		$this->db->where($options);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('sdbk_activity');
		$activity = $query->result_array();
		return $activity;
	}
	
	public function delete_activity($id = 0)
	{
		$options = array('id' => $id);
		$this->db->where($options);
		$this->db->delete('sdbk_activity');
		$delete = $this->db->affected_rows();
		if($delete == 1)
		{
			$options = array('aid' => $id);
			$this->db->where($options);
			$this->db->delete('sdbk_activity_record');
			$delete = $this->db->affected_rows();
			return 1;
		}
		else
			return 0;
		
	}
	
	public function push_activity($id, $access_token)
	{
		$data = array(
		    'keyword1' => $this->input->post('keyword1'),
			'keyword2' => $this->input->post('keyword2'),
			'keyword3' => $this->input->post('keyword3'),
			'remark' => $this->input->post('remark'),
			'markstu' => $this->input->post('markstu')			
		);
		
		$textPic = array(
            'first' => array('value'=> '恭喜你报名成功！\n', 'color'=> '#F45757'),
            'keyword1' => array('value'=> $data['keyword1'], 'color'=> '#2b2b2b'),
            'keyword2' => array('value'=> $data['keyword2'], 'color'=> '#2b2b2b'),
            'keyword3' => array('value'=> $data['keyword3'], 'color'=> '#2b2b2b'),
            'remark' => array('value'=> $data['remark'].'\n如有问题，请联系事务君（微信号：szushiwujun）', 'color'=> '#bbbbbb')
        );
		
		$templeurl = ''.$id;
		$this->load->library('weixin', $config = array('AppId' => $this->app_id, 'AppSecret' => $this->app_secret));//220测试
		
		$openids = array();
		$apply_num = 0;
		if($data['markstu'] == 'all')    //向全部报名用户发送报名成功消息
		{
			$field = array('uid');
			$options = array('aid' => $id);
			$this->db->select($field);
			$this->db->where($options);
			$query = $this->db->get('sdbk_activity_record');
			$list = $query->result_array();

			foreach($list as $row)
			{
				$options = array('userid' => $row['uid']);
				$this->db->where($options);
				$query1 = $this->db->get('sdbk_user');
			    $user = $query1->row_array();
				$openids[$apply_num] = $user['openid'];
				$apply_num++;
			}
		}
		else if($data['markstu'] != 'all')   //向部分用户发送报名成功消息
		{
            $spliceOpenid = str_replace( '，', ',', $data['markstu']);
            $spliceOpenid = explode(',', $spliceOpenid);
            for ($i = 0; $i < count($spliceOpenid); $i++) 
			{
                $options = array('studentNo' => $spliceOpenid[$i]);
                $this->db->where($options);
				$query2 = $this->db->get('sdbk_user');
			    $user = $query2->row_array();
				$openids[$i] = $user['openid'];
            }
		}

		$success_push = 0;
		$failed_push = 0;		
		foreach($openids as $user)        //更新sdbk_activity_record
		{
			$options = array('openid' => $user);
			$this->db->select(array('userid'));
			$this->db->where($options);
			$query3 = $this->db->get('sdbk_user');
			$uid = $query3->row_array();
			
			
			$field = array('mark' => '1');
			$options = array('uid' => $uid['userid']);
			$this->db->set($field);
			$this->db->where($options);
			$this->db->update('sdbk_activity_record');
			$update = $this->db->affected_rows();
			if($update == 1)
			{				
				$result = $this->weixin->pushtemple($access_token, $user, $this->template_id, $templeurl, $textPic);
			    $result = json_decode($result, true);
			    if($result['errcode'] == 0 && $result['errmsg'] == 'ok')
					$success_push++;
			    else
				{
                    $failed_push++;	
				}					
			}
			else
				$failed_push++;
		}
		//发送结果反馈
		$user = 'oNjPnw-AuKkwq7yYbcSwn9uZzrf8';
		$this->template_id = 'La9vLNUXEhieeXmuoPXk1RsqqczkGPqQuVb_zsQpIds';
		$templeurl = '';
		$data['result'] = '成功:'.$success_push.'   失败:'.$failed_push;
		$textPic1 = array(
            'first' => array('value'=> $data['result'].'\n', 'color'=> '#F45757'),
            'keyword1' => array('value'=> $data['keyword1'], 'color'=> '#2b2b2b'),
            'keyword2' => array('value'=> $data['keyword2'], 'color'=> '#2b2b2b'),
            'keyword3' => array('value'=> $data['keyword3'], 'color'=> '#2b2b2b'),
            'remark' => array('value'=> $data['remark'].'\n如有问题，请联系事务君（微信号：szushiwujun）', 'color'=> '#bbbbbb')
        );
		$this->weixin->pushtemple($access_token, $user, $this->template_id, $templeurl, $textPic1);
		return 0;
	}
	
	public function export_activity($id = 0)
	{
		$query = $this->db->query('select `sdbk_user`.`studentName`,`sdbk_user`.`studentNo`,`sdbk_user`.`sex`,`sdbk_user`.`org`,`sdbk_activity_record`.`param` from `sdbk_activity_record` left join `sdbk_user` on `sdbk_activity_record`.`uid` = `sdbk_user`.`userid` where `sdbk_activity_record`.`aid` = '.$id);
		$data = $query->result_array();
		
		if(count($data) === 0)
			return array(array(), array());
		
		foreach($data as $key => $value)
		{
			$data[$key]['param'] = json_decode($data[$key]['param'], true);
		}
		
		$excelTitle = array();
		$excelData = array();
		for ($i = 0; $i < count($data); $i++) 
		{
			if ($i == 0) 
			{
				foreach ($data[0] as $key => $value) 
				{
					if ($key == 'param') 
					{
						foreach ($value as $key1 => $value1) 
						{
							array_push($excelTitle, $value1['name']);
						}
					} else {
						array_push($excelTitle, $key);
					}
				}
			}
			$excelData[$i] = array();
			foreach ($data[$i] as $key => $value) 
			{
				if ($key == 'param') 
				{
					foreach ($value as $key1 => $value1) 
					{
						array_push($excelData[$i], $value1['value']);
					}
				} else 
				{
					array_push($excelData[$i], $value);
				}
			}
		}
		
		return array($excelTitle, $excelData);
	}
}