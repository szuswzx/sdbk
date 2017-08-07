<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class SC_model extends CI_Model{ 
	 

	public function __construct()
	{
	  	parent::__construct();
		$this->load->database();
	}
	public function find($studentNo)
	{
		$this->db->where(array('studentNo' => $studentNo));
		$query = $this->db->get('sdbk_xuefei')->row_array();//自己弄的一个表
		return $query;	
	}
}