<?php
  class Card_model extends CI_Model
  {
	  public function __construct()
	  {
		  parent::__construct();
		  $this->load->database();
		  $this->app_id = $this->config->item('app_id');
		  $this->app_secret = $this->config->item('app_secret');
		  $this->template_id = $this->config->item('card_template_id');
	  }
	  
	  public function get_user($options = array(), $field = '*')
	  {
		  $this->db->select($field);
		  $this->db->where($options);
		  $query= $this->db->get('sdbk_user');
		  return $query->row_array();
	  }
	  
	  public function insert($options = array())
	  {
		  $this->db->insert('sdbk_card', $options);
		  return $this->db->affected_rows();
	  }
	  
	  public function get_card($page, $options = array())
	  {
		  $field = array('id', 'studentNo', 'studentName', 'getName', 'isReturn', 'cardphone', 'cardplace', 'remark', 'time');
		  $startRow = ($page - 1) * 20;
		  
		  $this->db->select($field);
		  $this->db->where($options);
		  $this->db->order_by('id', 'DESC');
		  $this->db->limit(20, $startRow);
		  $query = $this->db->get('sdbk_card');
		  $card = $query->result_array();
		  
		  //获取当前搜索结果的总数
		  $this->db->where($options);
		  $sum = $this->db->count_all_results('sdbk_card');
		  $page_sum = (int)($sum / 20) + 1;
		  
		  return array($card, $page_sum);		  
	  }
	  
	  public function add_card($access_token = '')
	  {
		  $data = array(
			  'studentNo' => $this->input->post('studentNo'),
			  'studentName' => $this->input->post('studentName'),
			  'getName' => $this->input->post('getName'),
			  'remark' => $this->input->post('remark'),
			  'time' => date("Y-m-d")
		  );
		  $data = $this->security->xss_clean($data);
		  $insert = $this->insert($data);
		  
		  if($insert == 1)
		  {
			  $user = $this->get_user($options = array('studentNo' => $data['studentNo']));
			  $this->load->library('weixin', $config = array('AppId' => $this->app_id, 'AppSecret' => $this->app_secret));//220测试
			  $templeurl = ''.$id;//记得写上
			  $textPic = array(
				  'first' => array('value'=> $user['studentName'].'，你的校园卡被捡到啦！\n请到事务中心领取你的校园卡 <(￣▽￣)>', 'color'=> '#df4848'),
				  'PickedTime' => array('value'=> date("Y-m-d", time()), 'color'=> '#408ec0'),
				  'CardType' => array('value'=> '校园卡号'),
				  'CardNum' => array('value'=> $user['icAccount'], 'color'=> '#333'),
				  'PickerName' => array('value'=> $data['getName'], 'color'=> '#333'),
				  'remark' => array('value'=> '\n如有问题，请联系事务君（微信号：szushiwujun）', 'color'=> '#bbbbbb'),
			  );
			  $result = $this->weixin->pushtemple($access_token, $user['openid'], $this->template_id, $templeurl, $textPic);
			  $result = json_decode($result, true);
			  if($result['errcode'] == 0 && $result['errmsg'] == 'ok')
				  return 1;
			  else
				  return 2;
		  }
		  else
			  return 0;
	  }
	  
	  public function delete_card($id = 0)
	  {
		  $options = array('id' => $id);
		  $this->db->where($options);
		  $this->db->delete('sdbk_card');
		  return $this->db->affected_rows();
	  }
	  
	  public function return_card($id = 0, $access_token = '')
	  {
		  $options = array('id' => $id);
		  $field = array('isreturn' => 1);
		  $this->db->set($field);
		  $this->db->where($options);
		  $this->db->update('sdbk_card');
		  $update = $this->db->affected_rows();
		  
		  if($update == 1)
		  {
			  list($card, $page_num) = $this->get_card(1, $options);
			  $card = $card[0];
			  $user = $this->get_user($options = array('studentNo' => $card['studentNo']));
			  $this->load->library('weixin', $config = array('AppId' => $this->app_id, 'AppSecret' => $this->app_secret));//220测试
			  $templeurl = ''.$id;//记得写上
              $textPic = array(
                  'first' => array('value'=> $user['studentName'].'，你的校园卡已经归还给你啦！', 'color'=> '#df4848'),
                  'PickedTime' => array('value'=> date("Y-m-d", time()), 'color'=> '#408ec0'),
                  'CardType' => array('value'=> '校园卡号', 'color'=> '#333'),
                  'CardNum' => array('value'=> $user['icAccount'], 'color'=> '#333'),
                  'PickerName' => array('value'=> $card['getName'], 'color'=> '#333'),
                  'remark' => array('value'=> '\n如果校园卡不是你本人拿走或有任何问题，请联系事务君（微信号：szushiwujun）', 'color'=> '#bbbbbb'),
              );
			  $result = $this->weixin->pushtemple($access_token, $user['openid'], $this->template_id, $templeurl, $textPic);
			  $result = json_decode($result, true);
			  if($result['errcode'] == 0 && $result['errmsg'] == 'ok')
				  return array(1, $card['studentNo']);
			  else
				  return array(2, $card['studentNo']);
		  }
		  else
			  return array(0, $card['studentNo']);
	  }
	  
	  public function search_card_by_keyword($page = 1)
	  {
		  $keyword = $this->input->post('keyword');
		  $keyword = $this->security->xss_clean($keyword);
		  $field = array('id', 'studentNo', 'studentName', 'getName', 'isReturn', 'remark');
		  $startRow = ($page - 1) * 20;
		  
		  //根据学生姓名，学号，拾获人，备注模糊查找
		  $this->db->select($field);
		  $this->db->or_like('studentName', $keyword);
		  $this->db->or_like('studentNo', $keyword);
		  $this->db->or_like('getName', $keyword);
		  $this->db->or_like('remark', $keyword);
		  $this->db->or_like('id', $keyword);
		  $this->db->order_by('id', 'DESC');
		  $this->db->limit(20, $startRow);
		  $query = $this->db->get('sdbk_card');
		  $card = $query->result_array();
		  
		  $this->db->or_like('studentName', $keyword);
		  $this->db->or_like('studentNo', $keyword);
		  $this->db->or_like('getName', $keyword);
		  $this->db->or_like('remark', $keyword);
		  $this->db->or_like('id', $keyword);
		  $sum = $this->db->count_all_results('sdbk_card');
		  $page_sum = (int)($sum / 20) + 1;
		  
		  return array($card, $page_sum);
	  }
	  
	  public function add_card_without_sendmsg()
	  {
		  $data = array(
			  'studentNo' => $this->input->post('cardnumber'),
			  'studentName' => $this->input->post('cardowner'),
			  'getName' => $this->input->post('getName'),
			  'remark' => $this->input->post('cardremark'),
			  'time' => date("Y-m-d"),
			  'cardphone' => $this->input->post('cardphone'),
			  'cardplace' => $this->input->post('cardplace')
		  );
		  $data = $this->security->xss_clean($data);
		  $insert = $this->insert($data);
		  return $insert;
	  }
	  	 
  }