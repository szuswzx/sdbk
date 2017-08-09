<?php 
class Board extends CI_Controller
{ 
    public $userinfo = array( 'studentNo'=>'2014150319');
	public function __construct(){

	    parent::__construct();
		$this->load->model('board/board_model');
		$this->load->model('user_model');
		// $this->_check_user('board');	  
	}  
	public function index()
	{		  
		
	}
	
	public function fetchlist()
	{
		//刷新公文通列表
		$log = $this->board_model->fetchlist();
		//推送公文通更新提醒
		$this->board_model->push_board($log);
		header('Content-type: application/json');
        echo json_encode($log);
		
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



