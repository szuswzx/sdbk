<?php
  class Issue_model extends CI_Model
  {
	  public function __construct()
	  {
		  parent::__construct();
		  $this->load->database();
		  $this->app_id = $this->config->item('app_id');
		  $this->app_secret = $this->config->item('app_secret');
		  $this->template_id = $this->config->item('issue_template_id');
	  }
	  
	  public function get_user($options = array(), $field = '*')
	  {
		  $this->db->select($field);
		  $this->db->where($options);
		  $query= $this->db->get('sdbk_user');
		  return $query->row_array();
	  }

      public function get_issue($page, $options = array())
	  {
		  $field = array('id', 'title', 'userid', 'replied');
		  $startRow = ($page - 1) * 20;
		  
		  $this->db->select($field);
		  $this->db->where($options);
		  $this->db->order_by('id', 'DESC');
		  $this->db->limit(20, $startRow);
		  $query = $this->db->get('sdbk_issue');
		  $issue = $query->result_array();
		  
		  //获取当前搜索结果的总数
		  $this->db->where($options);
		  $sum = $this->db->count_all_results('sdbk_issue');
		  
		  foreach($issue as $key => $value)
		  {
			  $user = $this->get_user($options = array('userid' => $issue[$key]['userid']), $field = 'nickname');
			  $issue[$key]['user'] = $user['nickname'];
		  }
		  
		  $page_sum = (int)($sum / 20) + 1;
		  
		  return array($issue, $page_sum);
	  }
	  
	  public function get_issue_by_id($id = 0)  //根据id获取事务和学生信息（提交事务的学生）
	  {
		  $field = array('id', 'title', 'content', 'userid', 'reply', 'responder', 'asso');
		  $options = array('id' => $id);
		  
		  $this->db->select($field);
		  $this->db->where($options);
		  $query = $this->db->get('sdbk_issue');
		  $issue = $query->row_array();
		  		  
		  if($issue)
		  {
			  $user = array();
			  $user = $this->get_user($options = array('userid' => $issue['userid']), $field = array('openid', 'studentName', 'studentNo', 'org', 'phone'));		  
		      $issue = array_merge($issue, $user);
		  }
		  else
			  $issue = array();
		  return $issue;
	  }
	  
	  public function get_issue_by_keyword($page = 1)//根据关键词查找事务
	  {
		  $keyword = $this->input->post('keyword');
		  $keyword = $this->security->xss_clean($keyword);
		  $field = array('id', 'title', 'userid');		  
		  $startRow = ($page - 1) * 20;
		  
		  //根据id，标题，正文，回复模糊查找
		  $this->db->select($field);
		  $this->db->or_like('id', $keyword);
		  $this->db->or_like('title', $keyword);
		  $this->db->or_like('content', $keyword);
		  $this->db->or_like('reply', $keyword);
		  $this->db->order_by('submitTime', 'DESC');
		  $this->db->limit(20, $startRow);
		  $query = $this->db->get('sdbk_issue');
		  $issue = $query->result_array();
		  
		  //获取当前搜索结果的总数
		  $this->db->or_like('id', $keyword);
		  $this->db->or_like('title', $keyword);
		  $this->db->or_like('content', $keyword);
		  $this->db->or_like('reply', $keyword);
		  $sum = $this->db->count_all_results('sdbk_issue');
		  
		  foreach($issue as $key => $value)
		  {
			  $user = $this->get_user($options = array('userid' => $issue[$key]['userid']), $field = 'nickname');
			  $issue[$key]['user'] = $user['nickname'];
		  }

		  $page_sum = (int)($sum / 20) + 1;
		  
		  return array($issue, $page_sum);
	  }
	  
	  public function delete_issue_by_id($id = 0)
	  {
		  $options = array('id' => $id);
		  $this->db->where($options);
		  $this->db->delete('sdbk_issue');
		  return $this->db->affected_rows();
	  }
	  
	  public function reply_issue($id = 0, $field = array())
	  {		  
		  $options = array('id' => $id);
		  $this->db->set($field);
		  $this->db->where($options);
		  $this->db->update('sdbk_issue');
		  $update = $this->db->affected_rows();

		  if($update == 1)
		  {
			  $issue = $this->get_issue_by_id($id);
			  $this->load->library('weixin', $config = array('AppId' => $this->app_id, 'AppSecret' => $this->app_secret));//220测试
		      $token = $this->weixin->getToken();
		      $token = json_decode($token, true);
			  $templeurl = ''.$id;//记得写上
			  $textPic = array(
				  'first' => array('value'=> '您咨询的事务有回复啦！\n', 'color'=> '#df4848'),
				  'keyword1' => array('value'=> $issue['title'], 'color'=> '#408ec0'),
				  'keyword2' => array('value'=> date("Y-m-d h:i:s", time()).'\n回复概况：'.mb_substr(strip_tags($issue['reply']), 0, 32, 'utf-8'), 'color'=> '#333'),
				  'remark' => array('value'=> '\n如有问题，请联系事务君（微信号：szushiwujun）', 'color'=> '#bbbbbb'),
			  );
			  $result = $this->weixin->pushtemple($token['access_token'], $issue['openid'], $this->template_id, $templeurl, $textPic);
			  $result = json_decode($result, true);
			  if($result['errcode'] == 0 && $result['errmsg'] == 'ok')
				  return TRUE;
			  else
				  return FALSE;		  
		  }
		  else		  
			  return FALSE;
	  }	   		  	  
  }