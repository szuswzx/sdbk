<?php
class Wechat_model extends CI_Model
{
	public function __construct()
	{
	  $this->load->database();
	  $this->app_id = $this->config->item('app_id');
	  $this->app_secret = $this->config->item('app_secret');
	}

	public function get_access_token()
	{
		$field = array('access_token', 'get_time');
		$options = array('appid' => $this->app_id);
		$this->db->select($field);
		$this->db->where($options);
		$query = $this->db->get('sdbk_wechat');
		$result = $query->row_array();
		if(count($result) !=0 && strtotime(date('y-m-d h:i:s', $result['get_time']))+7100 > strtotime(date('y-m-d h:i:s')))
			return $result['access_token'];
		else if(count($result) !=0 && strtotime(date('y-m-d h:i:s', $result['get_time']))+7100 <= strtotime(date('y-m-d h:i:s')))
			return $this->fresh_access_token();
		else 
			return '';
			
	}
	
	public function fresh_access_token()
	{
		//通过接口获取access_token
		$this->load->library('weixin', $config = array('AppId' => $this->app_id, 'AppSecret' => $this->app_secret));//220测试
		$token = $this->weixin->getToken();
		$token = json_decode($token, true);
		//更新数据库的access_token
		$field = array('access_token' => $token['access_token'], 'get_time' => time());
		$options = array('appid' => $this->app_id);
		$this->db->set($field);
		$this->db->where($options);
		$this->db->update('sdbk_wechat');
		return $token['access_token'];
	}
}