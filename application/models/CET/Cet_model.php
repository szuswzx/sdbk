<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Cet_model extends CI_Model{
	  

	public function __construct()
	  {
	  	parent::__construct();
		$this->load->database();
	  }
	public function find($studentNo)
	{
		$this->db->where(array('studentNo' => $studentNo));
		$query = $this->db->get('sdbk_cet_zkz')->row_array();
		return $query;	
	}

}