<?php
  class Dashboard_admin_model extends CI_Model
  {
	  public function __construct()
	  {
		  $this->load->database();
	  }
	  
	  public function get_admin($options = array())
	  {
		  $query = $this->db->get_where('sdbk_admin', $options);
		  return $query->row_array();
	  }
	  
	  public function get_all_admin($keyword = '')
	  {
		  $field = array('uid', 'username', 'rank');
		  $this->db->select($field);
		  $this->db->or_like('uid', $keyword);
		  $this->db->or_like('username', $keyword);
		  $this->db->order_by('rank', 'DESC');
		  $query = $this->db->get('sdbk_admin');
		  return $query->result_array();
	  }
	  
	  public function add_admin()
	  {
		  $username = $this->input->post('username');
		  $password = $this->input->post('password');
		  $rank = $this->input->post('rank');
		  $admin = $this->get_admin($options = array('username' => $username));
		  if(count($admin) >= 1)
			  return '该用户已经存在';
		  else
		  {
			  $uuid = $this->getuuid();
			  $uuid = substr($uuid, 1, 36);
			  $admin = array(
				  'uuid' => $uuid,
				  'username' => $username,
				  'password' => sha1($password.$uuid),
				  'rank' => $rank
			  );
			  $this->db->insert('sdbk_admin', $admin);
			  $insert = $this->db->affected_rows();
			  if($insert == 1)
				  return 'success';
			  else
				  return 'failed';
		  }
	  }
	  
	  public function delete_admin($uid = 0)
	  {
		  $options = array('uid' => $uid);
		  $admin = $this->get_admin($options);
		  $this->db->where($options);
		  $this->db->delete('sdbk_admin');
		  return array($this->db->affected_rows(), $admin['username']);
	  }
	  
	  public function reset_password($uid = 0)
	  {
		  $options = array('uid' => $uid);
		  $admin = $this->get_admin($options);
		  $field = array('password' => sha1('123456'.$admin['uuid']));
		  $this->db->set($field);
		  $this->db->where($options);
		  $this->db->update('sdbk_admin');
		  return array($this->db->affected_rows(), $admin['username']);
	  }
	  
	  public function change_password($options)
	  {
		  $oldpass = $this->input->post('oldPwd');
		  $newpass = $this->input->post('newPwd');
		  $newpass1 = $this->input->post('Pwd');
		  $admin = $this->get_admin($options);
		  if (sha1($oldpass.$admin['uuid']) != $admin['password'])
			  return '原密码错误';
		  else if($newpass != $newpass1)
			  return '两次新密码输入不相同';
		  else
		  {
			  $field = array('password' => sha1($newpass.$admin['uuid']));
			  $this->db->set($field);
			  $this->db->where($options);
			  $this->db->update('sdbk_admin');
			  $update = $this->db->affected_rows();
			  
			  if($update == 1)
				  return 'success';
			  else
				  return 'failed';
		  }
	  }
	  
	  public function get_datalist()
	  {
		  $query1 = $this->db->get('sdbk_user');
		  $datalist['usercount'] = $query1->num_rows();		  
		  $query1->free_result();
		  
		  $query2 = $this->db->get('sdbk_apps');
		  $datalist['appcount'] = $query2->num_rows();
		  $query2->free_result();
		  
		  $query3 = $this->db->get('sdbk_issue');
		  $datalist['issuecount'] = $query3->num_rows();
		  $query3->free_result();
		  
		  $query4 = $this->db->get('sdbk_room_bind');
		  $datalist['roomcount'] = $query4->num_rows();
		  $query4->free_result();
		  return $datalist;
	  }
	  
	  //通过随机数生成uuid
	  function getuuid ()
	  {
		  if( function_exists('com_create_guid') )
		  {
			  return com_create_guid();
		  }
		  else 
		  {
			  mt_srand( (double)microtime() * 10000 );    // optional for php 4.2.0 and up.
			  $charid = strtoupper( md5(uniqid(rand(), true)) );
			  $hyphen = chr( 45 );
			  $uuid = chr(123)
			      . substr( $charid, 0, 8 ) . $hyphen
				  . substr( $charid, 8, 4 ) . $hyphen
				  . substr( $charid, 12, 4 ) . $hyphen
				  . substr( $charid, 16, 4 ) . $hyphen
				  . substr( $charid, 20, 12 )
				  . chr(125);
			  return $uuid;
		  }
      }
  }