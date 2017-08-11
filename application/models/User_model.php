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

	public function get_user_by_studentNo()
	{
		$studentNo = $this->input->post('studentNo');
		$field = array('userid', 'nickname', 'studentNo', 'icAccount', 'studentName');
		$options = array('studentNo' => $studentNo);
		$this->db->select($field);
		$this->db->where($options);
		$query = $this->db->get('sdbk_user');
		return $query->result_array();
	}
	
	public function get_users($options)
	{
		$this->db->where($options);
		$query = $this->db->get('sdbk_user');
		return $query->result_array();
	}
	
	public function insert_user($data)
	{
		$this->db->insert('sdbk_user', $data);
		return $this->db->affected_rows();
	}
	
	public function update_user($field, $options)
	{
		$this->db->set($field);
		$this->db->where($options);
		$this->db->update('sdbk_user');
		return $this->db->affected_rows();
	}

	public function unbind($userid)
	{
		$field = array('studentNo' => 0, 'icAccount' => 0);
		$options = array('userid' => $userid);
		$this->db->set($field);
		$this->db->where($options);
		$this->db->update('sdbk_user');
		return $this->db->affected_rows();
	}
}