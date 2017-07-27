<?php
class Wechat_keyword_model extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
	  $this->load->database();
	}
	
	public function get_keyword($keyword, $all = 0)//all = 0代表输出的是一行结果,1代表输出行结果数组
	{
		$k = $this->input->post('keyword');
		if($k != '')
			$keyword = $k;
		$this->db->or_like('keyword', $keyword);
		$this->db->order_by('weight', 'DESC');
		$query = $this->db->get('wechat_keywords');
		if($all == 0)
			return $query->row_array();
		else
			return $query->result_array();
	}
	
	public function delete_keyword($id = 0)
	{
		$options = array('id' => $id);
		$this->db->where($options);
		$this->db->delete('wechat_keywords');
		$delete = $this->db->affected_rows();
		if($delete == 1)
			return 'success';
		else
			return 'failed';
	}
	
	public function add_keyword()
	{
		$data = array(
			'type' => $this->input->post('type'),
			'keyword' => $this->input->post('keyword'),
			'replyType' => $this->input->post('replyType'),
			'reply' => $this->input->post('reply'),
			'weight' => $this->input->post('weight')
		);
		
		$insert = $this->db->insert('wechat_keywords', $data);
		if($insert == 1)
			return 'success';
		else
			return 'failed';
	}
	
	public function update_keyword($id = 0)
	{
		$field = array(
			'type' => $this->input->post('type'),
			'keyword' => $this->input->post('keyword'),
			'replyType' => $this->input->post('replyType'),
			'reply' => $this->input->post('reply'),
			'weight' => $this->input->post('weight')
		);
        $options = array('id' => $id);
		$this->db->set($field);
		$this->db->where($options);
		$this->db->update('wechat_keywords');
		$update = $this->db->affected_rows();
		
		if($update == 1)
			return 'success';
		else
			return 'failed';
	}
	
}