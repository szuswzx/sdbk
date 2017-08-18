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
		$this->load->model('board/board_bind_model');
		//刷新公文通列表
		$log = $this->board_model->fetchlist();
		//推送公文通更新提醒
		/*$this->load->model('wechat_model');
		$access_token = $this->wechat_model->get_access_token();
		//获取需要推送的用户
		$board_user = $this->board_bind_model->get_bind_user();
		$this->board_model->push_board($log, $board_user, $access_token);*/
		echo json_encode($log);
		
	}
	
	public function board_list($out = 'page', $page = 1)
	{
		$type = $this->input->post('type');
		if(!$type || $type == "全部")
		{
			$data['board'] = $this->board_model->get_board_list($page, array('fixed' => '0'));
			$data['fixed_board'] = $this->board_model->get_board_list($page, array('fixed' => '1'));//置顶的公文通
			if($out == 'page')
				$this->load->view('board/board_list',$data);
			else
				echo json_encode(array_merge($data['fixed_board'],$data['board']));
		}
		else
		{
			$data['board'] = $this->board_model->get_board_list($page, array('type' => str_replace('\'', '', $type)));
			echo json_encode($data['board']);
		}
	}
	
	public function search_board($page = 1)
	{
		$data['board'] = $this->board_model->search_board($page);
		echo json_encode($data['board']);
	}
	
	public function fetch_article($aid = 0)
	{
		$data['article'] = $this->board_model->fetch_article($aid);
		$data['attachment'] = json_decode(base64_decode($data['article']['attachment']),true);
		//print_r($data['attachment']);exit();
		//print_r($article);
		$this->load->view('board/boardIndex', $data);
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



