<?php 
class Card extends CI_Controller
{ 
    public $userinfo = array();
	public function __construct(){

	    parent::__construct();
		$this->load->model('dashboard/card_model');
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		//$this->_check_user('card');	  
	}  
	public function index(){		  
		list($data['card'], $page_num) = $this->card_model->get_card(1);
		$this->load->view('card/search',$data);
	}
	
	public function add_card($page = 'form')
	{
		if($page == 'form')
			$this->load->view('card/pickup');
		else
		{
			$data['res'] = $this->card_model->add_card_without_sendmsg();
			$this->load->view('card/result',$data);
		}
	}
	
	public function card_detail($id)
	{
		list($data['card'], $page_num) = $this->card_model->get_card(1, array('id' => $id));
		$this->load->view('card/message',$data);
	}
	
	public function search_card()
	{
		list($data['card'], $page_num)= $this->card_model->search_card_by_keyword(1);
		$this->load->view('card/search',$data);
	}
	
	private function _check_user($pro){
		
		if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) {
			if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) {
				  header("Location: http://www.szuswzx.com/passport/?redirect_uri=".urlencode("http://www.szuswzx.com/sdbk/".$pro));
				  exit();
			  }
		      $openid = $_COOKIE["openid"];
		      $this->userinfo = $this->user_model->get_user($openid);
		      if ($this->userinfo['studentNo'] == 0) {
				  header("Location: http://www.szuswzx.com/passport/?redirect_uri=".urlencode("http://www.szuswzx.com/sdbk/".$pro));
				  exit();
		      }
		  } else {
			  header("Location: http://www.szuswzx.com/passport/?redirect_uri=".urlencode("http://www.szuswzx.com/sdbk/".$pro));
			  exit();
		  }
	  }
}



