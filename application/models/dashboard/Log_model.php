<?php
class Log_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_log()
	{
		$this->db->order_by('id', 'DESC');
		$this->db->limit(100);
		$query = $this->db->get('sdbk_log');
		$log = $query->result_array();
		
		return $log;
	}
	
	public function save_log($username = '', $log)
	{
		$data = array(
		      'user' => $username,
			  'log' => $log,
			  'time' => time()
		  );
		$data = $this->security->xss_clean($data);
		$this->db->insert('sdbk_log', $data);
	}
}