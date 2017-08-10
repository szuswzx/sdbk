<?php
class Board_bind_model extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
	  $this->load->database();
	}
	
	public function get_bind_user()
	{
		$query = $this->db->where(array('bind' => 1))->get('sdbk_board_bind');
		$bind = $query->result_array();
		foreach($bind as $row)
		{
			$options = array('userid' => $row['userid']);
			$field = array('userid', 'nickname', 'studentNo', 'icAccount', 'studentName');
			$query1 = $this->db->select($field)->where($options)->get('sdbk_user');
			$user[] = $query1->row_array();
		}
		return $user;
	}
	
	//绑定公文通提醒
	public function bind_board_push($userid)
	{
		$query = $this->db->where(array('userid' => $userid))->get('sdbk_board_bind');
		$bind = $query->row_array();
		if(!$bind)
		{
			$data = array('userid' => $userid, 'bind' => 1);
			$insert = $this->db->insert('sdbk_board_bind', $data);
			return $insert;
		}
		else
		{
			return 0;
		}
	}
	
	//解绑
	public function unbind_board_push($userid)
	{
		$this->db->where(array('userid' => $userid))->delete('sdbk_board_bind');
		return $this->db->affected_rows();
	}
		
}