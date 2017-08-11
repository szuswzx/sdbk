<?php 
class Board extends CI_Controller
{ 
    public $userinfo = array();
	public function __construct(){

	    parent::__construct();
		$this->load->model('board/board_model');
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		// $this->_check_user('board');	  
	}  
	
	public function fetchlist()
	{
		//刷新公文通列表
		$log = $this->board_model->fetchlist();
		//推送公文通更新提醒
		$this->load->model('wechat_model');
		$access_token = $this->wechat_model->get_access_token();
		$this->board_model->push_board($log, $access_token);
		$data['log'] = $log;
		$this->load->view('board/success',$data);
		
	}
	
	public function board_list($type = 'all', $out = 'page', $page = 1)
	{
		if($type == 'all')
		{
			$data['board'] = $this->board_model->get_board_list($page, array('fixed' => '0'));
			$data['fixed_board'] = $this->board_model->get_board_list($page, array('fixed' => '1'));//置顶的公文通
			if($out == 'page')
				$this->load->view('board/board_list',$data);
			else
				echo json_encode($data['board']);
		}
		else
		{
			$board = $this->board_model->get_board_list($page, array('fixed' => '0', 'type' => str_replace('\'', '', $type)));
		}
	}
	
	public function search_board($page = 1)
	{
		$data['board'] = $this->board_model->search_board($page);
		echo json_encode($data['board']);
	}
	
	public function fetch_article($aid = 0)
	{
		$article = $this->board_model->fetch_article($aid);
		print_r($article);
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



