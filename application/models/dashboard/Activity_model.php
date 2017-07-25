<?php
  class Activity_model extends CI_Model
  {
	  public function __construct()
	  {
		  parent::__construct();
		  $this->load->database();
	  }
	  
	  public function insert($options = array())
	  {
		  $this->db->insert('sdbk_menu', $options);
		  return $this->db->affected_rows();
	  }
	  
	  public function get_menu($options = array(), $field = '*')
	  {
		  $this->db->select($field);
		  $this->db->where($options);
		  $query= $this->db->get('sdbk_menu');
		  return $query->result_array();;
	  }
	  
	  public function get_menu_num($options = array())
	  {
		  $this->db->where($options);
		  $query = $this->db->get('sdbk_menu');
		  $menu_num = $query->num_rows();
		  return $menu_num;
	  }
	  
	  public function delete_menu($options = array())
	  {
		  $this->db->delete('sdbk_menu', $options);
		  return $this->db->affected_rows();
	  }
	  
	  public function update_menu($options = array(), $field = array())
	  {
		  $this->db->set($field);
		  $this->db->where($options);
		  $this->db->update('sdbk_menu');
		  return $this->db->affected_rows();
	  }	 	  
  }