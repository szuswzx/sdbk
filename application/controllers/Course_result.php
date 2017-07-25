<?php
  class Course_result extends CI_Controller
  {
	  public $userinfo = array();
	  public function __construct()
	  {
		  parent::__construct();
		  $this->load->model('course_model');
		  $this->load->model('user_model');
		  $this->_check_user();
	  }
	  
	  public function index()
	  {
		  $studentNo = $this->userinfo['studentNo'];
		  $data['examRes'] = $this->course_model->get_courses($studentNo);
		  $data['userinfo'] = $this->userinfo;
		  
		  $this->load->view('courses/view',$data);

	  }
	  
	  private function _check_user()
	  {
		  if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) {
			  if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) {
				  header("Location: http://www.szuswzx.com/passport/?redirect_uri=".urlencode("http://www.szuswzx.com/sdbk/course_result"));
				  exit();
			  }
		      $openid = $_COOKIE["openid"];
		      $this->userinfo = $this->user_model->get_user($openid);
		      if ($this->userinfo['studentNo'] == 0) {
				  header("Location: http://www.szuswzx.com/passport/?redirect_uri=".urlencode("http://www.szuswzx.com/sdbk/course_result"));
				  exit();
		      }
		  } else {
			  header("Location: http://www.szuswzx.com/passport/?redirect_uri=".urlencode("http://www.szuswzx.com/sdbk/course_result"));
			  exit();
		  }
	  }
	  
  }
//end