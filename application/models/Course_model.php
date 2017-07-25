<?php
  class Course_model extends CI_Model
  {
	  public function __construct()
	  {
		  $this->load->database();
	  }
	  
	  public function get_courses($studentNo)
	  {
		  $this->db->where(array('studentNo' => $studentNo));
		  $query = $this->db->get('sdbk_xuanke1');
		  return $query->result_array();
	  }
  }