<?php
 
class Cet extends CI_Controller
{ 
    public $userinfo = array( 'studentNo'=>'2014150319');
	public function __construct(){

	    parent::__construct();
		$this->load->model('CET/cet_model');
		$this->load->model('user_model');
		// $this->_check_user('cet');	  
	}  
	public function index(){		  

		$studentNo = $this->userinfo['studentNo'];

		$query['cet']=$this->cet_model->find($studentNo);

		$this->load->view('CET/CET_result',$query);
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



