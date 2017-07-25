<?php
  class User_model extends CI_Model
  {
	  public function __construct()
	  {
		  $this->load->database();
	  }
	  
	  public function get_user($openid)
	  {
		  $query = $this->db->get_where('sdbk_user', array('openid' => $openid));
		  return $query->row_array();
	  }
  }