<?php
  class News_model extends CI_Model{
	  
	  public function __construct()
	  {
		  $this->load->database();
	  }
	  
	  public function get_news($slug = FALSE)
	  {
		  if($slug === FALSE)
		  {
			  $query = $this->db->get('news');
			  return $query->result_array();
		  }
		  
		  $query = $this->db->get_where('news', array('slug' => $slug));
		  return $query->row_array();
	  }
	  
	  public function set_news()
	  {
		  $this->load->helper('url');
		  $slug = url_title($this->input->post('title'), 'dash', TRUE);
		  $data = array(
		  'title' => $this->input->post('title'),
		  'slug' => $slug,
		  'text' => $this->input->post('text')
		  );
		  $i=0;
		  $this->db->trans_strict(FALSE);
		  $this->db->trans_begin();
		  
		  $this->db->insert('news', $data);
          $news1 = $this->get_news($slug);			  
		  if($i == 0){
		  $this->db->trans_rollback();
		  }
		  else
		  {
			   $this->db->trans_commit();
		  }
		  return 1;
	  }
  }
?>