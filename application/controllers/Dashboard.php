<?php
  class Dashboard extends CI_Controller
  {
	  public $userinfo = array();
	  public function __construct()
	  {
		  parent::__construct();
		  $this->load->model('dashboard/dashboard_admin_model');
		  $this->load->model('dashboard/log_model');
		  $this->load->helper('url_helper');
          $this->userinfo = array();  
	  }
	  
	  // 登录
	  public function index()
      {		  
		  $this->load->helper('form');
		  $this->load->library('form_validation');		  
		  
		  $config = array(
		      array(
			      'field' => 'username',
				  'label' => '用户名',
				  'rules' => 'required',
				  'errors' => array('required' => '用户名不能为空')
			  ),
			  array(
			      'field' => 'password',
				  'label' => '密码',
				  'rules' => 'required|callback_check_password',
				  'errors' => array('required' => '密码不能为空')
			  )
		  );
		  $this->form_validation->set_rules($config);
		  
		  if($this->form_validation->run() == FALSE)
		  {
			  $this->load->view('dashboard/login');
		  }
		  else
		  {
			  header("location:".site_url("dashboard/first_page"));
		  }
	  }
	  
	  public function first_page()
	  {
		  //$this->_check_login();
		  $data = $this->dashboard_admin_model->get_datalist();
		  $this->load->view('dashboard/dashboard',$data);
	  }
	  
	  //校园卡解绑
	  public function find_user($page = 'page', $studentNo)
	  {
		  //$this->_check_login();
		  $this->load->model('user_model');
		  
		  $data['user'] = $this->user_model->get_user_by_studentNo($studentNo);
		  if($page == 'page')
			  $this->load->view('dashboard/unbind/find_user',$data);
		  else
			  echo json_encode($data['user']);
	  }
	  
	  public function unbind($userid)
	  {
		  //$this->_check_login();
		  $this->load->model('user_model');
		  
		  $res = $this->user_model->unbind($userid);
		  if($res >= 1)
			  echo "success";
		  else
			  echo "failed";
	  }
	  
	  //绑定用户推送新公文通
	  public function push_board()
	  {
		  $this->load->model('wechat_model');
		  echo $this->wechat_model->get_access_token();		  
	  }
	  
	  //活动发布
	  public function activity()
	  {
		  $this->_check_login();
		  $this->load->model('dashboard/activity_model');

		  if($this->userinfo['rank'] >= 5)
		  {
		  	  $data['activity'] = $this->activity_model->get_activity();
			  $this->load->view('dashboard/activity/manage_activity', $data);
		  }
		  else
		  {
			  echo '权限不足';
		  }
	  }
	  
	  public function delete_activity($id = 0)
	  {
		  $this->_check_login();
		  $this->load->model('dashboard/activity_model');

		  if($this->userinfo['rank'] >= 5)
		  {
		  	  $res = $this->activity_model->delete_activity($id);
			  if($res == 1)
				  $this->log_model->save_log($this->userinfo['username'], "删除了活动：".$id);
			  echo $res;
		  }
		  else
		  {
			  echo '权限不足';
		  }
	  }
	  
	  public function push_activity($id = 0)
	  {
		  $this->_check_login();
		  $this->load->model('dashboard/activity_model');
		  $this->load->model('wechat_model');

		  if($this->userinfo['rank'] >= 5)
		  {
			  $access_token = $this->wechat_model->get_access_token();
		  	  $res = $this->activity_model->push_activity($id, $access_token);			  
			  echo $res;
		  }
		  else
		  {
			  echo '权限不足';
		  }
	  }
	  
	  public function add_activity($out = 'all')
	  {
		  $this->_check_login();
		  $this->load->model('dashboard/activity_model');
		  if($this->input->post('ajax') != 'ajax')
		  {
			  if($out == 'all')
				  $this->load->view('dashboard/activity/add_activities');
			  else
				  $this->load->view('dashboard/activity/return_add_activities');
		  }
		  else
		  {
			  $res = $this->activity_model->add_activity();
			  if($res == 1)
				  $this->log_model->save_log($this->userinfo['username'], "添加了活动：".$this->input->post('name'));
			  echo $res;
		  }
	  }
	  
	  public function export_activity($id)
	  {
		  //$this->_check_login();
		  $this->load->model('dashboard/activity_model');
		  $this->output->set_header('Content-Type: application/vnd.ms-excel');
		  $this->output->set_header('Content-Disposition: attachment; filename=export-'.time().'.xls');
		  $this->output->set_header('Pragma: no-cache');
		  $this->output->set_header('Expires: 0');
		  
          list($excelTitle, $excelData) = $this->activity_model->export_activity($id);
	      $data1 = iconv('utf-8', 'gbk', implode("\t", $excelTitle)). "\n";
		  $this->output->append_output($data1);

		  foreach ($excelData as $value) 
		  {
			  $data2 = iconv('utf-8', 'gbk', implode("\t", $value)). "\n";
			  $this->output->append_output($data2);
		  }
		  
	  }
	  
	  //校园卡找回
      public function card($type = 'all', $out = 'page', $page = 1)
	  {
		  //$this->_check_login();
		  $this->load->model('dashboard/card_model');
		  if($this->input->post('page') != '')
			  $page = $this->input->post('page');
		  if($type == 'all')      //type = 0代表全部拾卡记录
			  list($card_list, $page_num) = $this->card_model->get_card($page);
		  else if($type == 'isreturn')  //type = 1代表已经归还的拾卡记录
			  list($card_list, $page_num) = $this->card_model->get_card($page, $options = array('isreturn' => '1'));
		  else if($type == 'notreturn')
			  list($card_list, $page_num) = $this->card_model->get_card($page, $options = array('isreturn' => '0'));
		  else 
		  {
			  $card_list = array();
			  $page_num = 0;
		  }
		  
		  
		  $data['card'] = $card_list;
		  $data['page_num'] = $page_num;
		  $data = $this->security->xss_clean($data);
		  if($out == 'page')
			  $this->load->view('dashboard/card/confirmrtn', $data);
		  else
			  echo json_encode($card_list);
	  }
	  
	  public function add_card($page = 'first')
	  {
		  $this->_check_login();
		  $this->load->model('dashboard/card_model');
		  $this->load->model('wechat_model');
		  $this->load->helper('form');
		  $this->load->library('form_validation');
		  $config = array(		  
			  array(
				    'field' => 'studentNo',
					'label' => '学号',
					'rules' => "required",
					'errors' => array('required' => '学号必须正确填写')
				)
		  );
		  $this->form_validation->set_rules($config);
			  
		  if($this->form_validation->run() == FALSE)
		  {
			  if($this->input->post('ajax') == 'ajax')
				  echo 0;
			  else if($page == 'first')
				  $this->load->view('dashboard/card/findcard');
			  else
				  $this->load->view('dashboard/card/returnCard');
		  }
		  else
		  {

			  $access_token = $this->wechat_model->get_access_token();
			  $res = $this->card_model->add_card($access_token);
			  if($res == 1 || $res == 2)
				  $this->log_model->save_log($this->userinfo['username'], "添加了学号为".$this->input->post('studentNo')."的校园卡丢失信息");
			  echo $res;
		  }
	  }
	  
	  public function delete_card($id = 0)
	  {
		  //$this->_check_login();
		  if($this->userinfo['rank'] >= 5)
		  {
			  $this->load->model('dashboard/card_model');
			  $success = $this->card_model->delete_card($id);
			  if($success == 1)
				  echo "success";
			  else
				  echo "false";
		  }
		  else
			  echo "权限不足";
	  }
	  
	  public function return_card($id = 0)
	  {
		  $this->_check_login();
		  $this->load->model('dashboard/card_model');
		  $this->load->model('wechat_model');
		  $access_token = $this->wechat_model->get_access_token();
		  list($res, $studentNo) = $this->card_model->return_card($id, $access_token);
		  if($res == 1 || $res == 2)
			  $this->log_model->save_log($this->userinfo['username'], "归还了学号为".$studentNo."的校园卡");
		  echo $res;
	  }
	  
	  public function search_card($out = 'page', $page = 1)
	  {
		  //$this->_check_login();
		  $this->load->model('dashboard/card_model');
		  
		  if($this->input->post('page') != '')
			  $page = $this->input->post('page');
		  list($card_list, $page_num)= $this->card_model->search_card_by_keyword($page);
		  $data['card'] = $card_list;
		  $data['page_num'] = $page_num;
		  $data = $this->security->xss_clean($data);
		  
		  if($out == 'page')
			  $this->load->view('dashboard/card/confirmrtn', $data);
		  else
			  echo json_encode($card_list);
	  }
	  
	  //事务咨询
	  public function issue($type = 'all', $out = 'page', $page = 1)
	  {
		$this->_check_login();
		$this->load->model('dashboard/issue_model');
		
		if($type == 'all')          //type = 0代表返回全部事务
			list($issue, $page_sum) = $this->issue_model->get_issue($page);
		else if($type == 'notyet')     //type = 1代表返回未回复事务
			list($issue, $page_sum) = $this->issue_model->get_issue($page, $options = array('replied' => '0'));
		else if($type == 'finish')     //type = 2代表返回已经回复事务
			list($issue, $page_sum) = $this->issue_model->get_issue($page, $options = array('replied' => '1'));
		else
		{			
			$issue = array();
			$page_sum = 0;
		}
		
		$data['issue'] = $issue;
		$data['page_sum'] = $page_sum;
		$data = $this->security->xss_clean($data);
		if($out == 'page')
			$this->load->view('dashboard/issue/issue', $data);
	    else
		    echo json_encode($data['issue']);
	  }
	  
	  public function issue_by_id($id = 0)
	  {
		  //$this->_check_login();
		  $this->load->model('dashboard/issue_model');
		  $issue = $this->issue_model->get_issue_by_id($id);
		  
		  $issue = $this->security->xss_clean($issue);
		  echo json_encode($issue);
	  }
	  
	  public function search_issue($page = 1)
	  {
		  //$this->_check_login();
		  $this->load->model('dashboard/issue_model');
		  list($issue, $page_sum) = $this->issue_model->get_issue_by_keyword($page);
		  
		  $data['issue'] = $issue;
		  $data['page_sum'] = $page_sum;
		  $data = $this->security->xss_clean($data);
		  echo json_encode($issue);
	  }
	  
	  public function delete_issue($id = 0)
	  {
		  $this->_check_login();
		  $this->load->model('dashboard/issue_model');
		  $success = $this->issue_model->delete_issue_by_id($id);
		  $this->log_model->save_log($this->userinfo['username'], "删除了id为".$id."的事务");
		  if($success == 1)
			  echo 1;
		  else
			  echo 0;
	  }
	  
	  public function reply_issue($id = 0)
	  {
		  $this->_check_login();
		  $this->load->model('dashboard/issue_model');
		  $this->load->model('wechat_model');
		  $issue = array(
			  'replied' => 1,
			  'asso' => $this->input->post('asso'),
			  'reply' => $this->input->post('reply'),
			  'responder' => $this->userinfo['username'],
			  'replyTime' => time()
		  );

		  $access_token = $this->wechat_model->get_access_token();
		  $res = $this->issue_model->reply_issue($id, $issue, $access_token);
		  $this->log_model->save_log($this->userinfo['username'], "回复了id为".$id."事务：".$issue['reply']);
		  echo $res;
	  }
	  
	  //菜单设计
	  public function menu($slug = 0, $mid = 0)
	  {
		  //$this->_check_login();
		  $this->load->model('menu_model');

		  if($slug == 0)		  //0表示显示所有菜单
		  {
			  $menudata['menudata'] = $this->menu_model->get_menu();
			  $this->load->view('dashboard/menu/all_menu', $menudata);
		  }
		  else if($slug == 1)     //1表示添加菜单，mid传进来的值是添加的菜单的previous
		  {
			  $this->load->helper('form');
			  $this->load->library('form_validation');		  
			  
			  $data['mid'] = $mid;
			  $config = array(
				  array(
					  'field' => 'name',
					  'label' => '菜单名称',
					  'rules' => "required|callback_check_menu_name[$mid]",
					  'errors' => array('required' => '菜单名称不能为空')
				    )
			  );
			  $this->form_validation->set_rules($config);
			  
			  if($this->form_validation->run() == FALSE)
			  {
				  $this->load->view('dashboard/menu/add_menu', $data);
			  }
			  else
			  {
				  $data = array(
				      'previous' => $mid,
					  'name' => $this->input->post('name'),
					  'type' => $this->input->post('type'),
					  'url' => $this->input->post('url'),
					  'key' => $this->input->post('key'),
					  'title' => $this->input->post('title'),
					  'description' => $this->input->post('description')
					);
				  //添加点击跳转事件，需要上传图文消息图片
				  if($data['type'] == 'click')
				  {
					  $config['upload_path'] = './public/menu/news';
					  $config['file_name'] = time();
					  $config['allowed_types'] = 'jpg|png';
					  $config['max_size'] = 1024;
					  
					  $this->load->library('upload', $config);
					  if ( ! $this->upload->do_upload('img'))
				      {
						  $menudata['error'] = '1';
						  $menudata['error_message'] = '图片上传失败，图文消息的图片必须是jpg和png格式且最大1M！';
						  $menudata['menudata'] = $this->menu_model->get_menu();					  
					  }
					  else
					  {
						  $img = array('upload_data' => $this->upload->data());
						  $data['picurl'] = $this->menu_model->upload_img($img['upload_data']['full_path']);
						  $menudata = $this->menu_model->myinsert_menu($mid, $data);
					  }
				  }
				  else
				  {
					  $menudata = $this->menu_model->myinsert_menu($mid, $data);
				  }
                  $this->load->view('dashboard/menu/all_menu', $menudata);
			  }	
		  }
		  else if($slug == 2)  //2表示删除菜单
		  {			  
			  $menudata = $this->menu_model->mydelete_menu($mid);
			  $this->load->view('dashboard/menu/all_menu', $menudata);
		  }
		  else if($slug == 3)  //3表示更新当前存在菜单
		  {
			  $this->load->helper('form');
			  $this->load->library('form_validation');
			  
			  $data['mid'] = $mid;
			  $data['menudata'] = $this->menu_model->get_menu(array('mid' => $mid));
			  if(count($data['menudata']) == 0)//菜单不存在
			  {
				  $menudata['menudata'] = $this->menu_model->get_menu();
				  $menudata['error'] = '1';
				  $menudata['error_message'] = '更新失败，该菜单项不存在哦！';
			      $this->load->view('dashboard/menu/all_menu', $menudata);
			  }
			  else
			  {
				  $config = array(
					  array(
						  'field' => 'name',
						  'label' => '菜单名称',
						  'rules' => 'required|callback_check_menu_name['.$data['menudata']['0']['previous'].']',
						  'errors' => array('required' => '菜单名称不能为空')
					  )
				  );
				  $this->form_validation->set_rules($config);
				  
				  if($this->form_validation->run() == FALSE)
				  {
					  $this->load->view('dashboard/menu/update_menu', $data);
				  }
				  else
				  {
					  $data = array(
						  'name' => $this->input->post('name'),
						  'type' => $this->input->post('type'),
						  'url' => $this->input->post('url'),
						  'key' => $this->input->post('key'),
						  'title' => $this->input->post('title'),
					      'description' => $this->input->post('description')
						);
					  //添加点击跳转事件，需要上传图文消息图片
					  if($data['type'] == 'click')
					  {
						  $config['upload_path'] = './public/menu/news';
						  $config['file_name'] = time();
						  $config['allowed_types'] = 'jpg|png';
						  $config['max_size'] = 1024;
						  
						  $this->load->library('upload', $config);
						  if ( ! $this->upload->do_upload('img'))
						  {
							  
							  $menudata['error'] = '1';
							  $menudata['error_message'] = '图片上传失败，图文消息的图片必须是jpg和png格式且最大1M:'.$this->upload->display_errors();
							  $menudata['menudata'] = $this->menu_model->get_menu();					  
						  }
						  else
						  {
							  $img = array('upload_data' => $this->upload->data());
							  $data['picurl'] = $this->menu_model->upload_img($img['upload_data']['full_path']);
							  $menudata = $this->menu_model->myupdate_menu($mid, $data);
						  }
					  }
					  else
					  {
						  $menudata = $this->menu_model->myupdate_menu($mid, $data);
					  }
					  
					  //$menudata = $this->menu_model->myupdate_menu($mid, $data);
					  $this->load->view('dashboard/menu/all_menu', $menudata);
				  }
			  }				  
		  }
	  }
	  
	  public function keywords($keyword = '')
	  {
		  //$this->_check_login();
		  $this->load->model('dashboard/wechat_keyword_model');
		  
		  $data['keyword'] = $this->wechat_keyword_model->get_keyword($keyword, 1);
		  $this->load->view('dashboard/keyword/success', $data);
	  }
	  
	  public function delete_keyword($id = 0)
	  {
		  //$this->_check_login();
		  $this->load->model('dashboard/wechat_keyword_model');
		  
		  $res = $this->wechat_keyword_model->delete_keyword($id);
		  echo $res;
	  }
	  
	  public function add_keyword()
	  {
		  //$this->_check_login();
		  $this->load->model('dashboard/wechat_keyword_model');
		  
		  $res = $this->wechat_keyword_model->add_keyword();
		  echo $res;		  
	  }
	  
	  public function update_keyword($id = 0)
	  {
		  //$this->_check_login();
		  $this->load->model('dashboard/wechat_keyword_model');
		  
		  $res = $this->wechat_keyword_model->update_keyword($id);
		  echo $res;
	  }
	  
	  //一级菜单长度不超过16个字节，二级不超过60个字节
	  public function check_menu_name($name, $previous)
	  {
		  if($previous == '0' && mb_strlen($name,'iso-8859-1') > 16)
		  {
			  $this->form_validation->set_message('check_menu_name', '菜单名称过长，一级菜单最多5个汉字');
			  return FALSE;
		  }
		  else if($previous != '0' && mb_strlen($name,'iso-8859-1') > 60)
		  {
			  $this->form_validation->set_message('check_menu_name', '菜单名称过长，二级菜单最多20个汉字');
			  return FALSE;
		  }
		  return TRUE;
	  }
		  
	  //设置
	  public function setting($page = 'setting')
	  {
		  $this->_check_login();
		  $this->load->helper('form');
		  
		  if($this->input->post('ajax') != 'ajax')
		  {
			  if($page == 'setting')
				  $this->load->view('dashboard/setting/setting');
		      else
				  $this->load->view('dashboard/setting/password');
		  }
		  else
		  {		  
			  $res = $this->dashboard_admin_model->change_password($options = array('uuid' => $this->userinfo['uuid']));
			  if($res == 'success')
				  $this->log_model->save_log($this->userinfo['username'], "修改了密码");
		      echo $res;
		  }	  
	  }
	  
	  public function add_admin()
	  {
		  $this->_check_login();
		  $this->load->helper('form');
		  
		  if($this->userinfo['rank'] >= 5)
		  {
			  if($this->input->post('ajax') != 'ajax')
			  {
				  $this->load->view('dashboard/setting/add_admin');
			  }
			  else
			  {
					  $res = $this->dashboard_admin_model->add_admin();
					  if($res == 'success')
						  $this->log_model->save_log($this->userinfo['username'], "添加了用户名为".$this->input->post('username')."的管理员");
					  echo $res;
			  }	
		  }
	      else
			  echo '权限不足';
	  }
	  
	  public function get_all_admin($keyword = '')
	  {
		  $this->_check_login();
		  if($this->userinfo['rank'] >= 5)
		  {			  
			  $data['admin'] = $this->dashboard_admin_model->get_all_admin($keyword);
			  $this->load->view('dashboard/setting/manage_admin', $data);
		  }
          else
              echo '权限不足';			  
	  }
	  
	  public function delete_admin($uid = 0)
	  {
		  $this->_check_login();
		  if($this->userinfo['rank'] >= 5)
		  {			  
			  list($res, $username) = $this->dashboard_admin_model->delete_admin($uid);
			  if($res == 1)
				  $this->log_model->save_log($this->userinfo['username'], "删除了用户名为".$username."的管理员");
			  echo $res;
		  }
          else
              echo '权限不足';
	  }
	  
	  public function reset_password($uid = 0)
	  {
		  $this->_check_login();
		  if($this->userinfo['rank'] >= 5)
		  {			  
			  list($res, $username) = $this->dashboard_admin_model->reset_password($uid);
			  if($res == 1)
				  $this->log_model->save_log($this->userinfo['username'], "重置了用户名为".$username."的管理员密码");
			  echo $res;
		  }
          else
              echo '权限不足';
	  }
	  
	  public function dashboard_log()
	  {
		  $this->_check_login();
		  if($this->userinfo['rank'] >= 5)
		  {
			  $data['log'] = $this->log_model->get_log();
			  $data = $this->security->xss_clean($data);
			  $this->load->view('dashboard/setting/log', $data);
		  }
		  else
			  echo '权限不足';
	  }
	  
	  public function logout()
	  {
		  setcookie('uuid', '', time() - 3600);
		  header("location:".site_url("dashboard/index"));
		  exit();
	  }
	  	  
	  //登录检测
	  private function _check_login()
	  {
		$this->load->library('session');
		$uuid = $this->session->userdata('uuid');
		if (isset($_COOKIE['uuid']) && ($uuid == $_COOKIE['uuid'])) 
		{
			$uuid = $_COOKIE['uuid'];
			$this->userinfo = $this->dashboard_admin_model->get_admin(array('uuid' => $uuid));
			if (!$this->userinfo)
			{
				header("location:".site_url("dashboard/index"));
				exit();
			}
		} 
		else 
		{
			header("location:".site_url("dashboard/index"));
			exit();
		}
	  }
	  
	  //用户验证回调函数
	  public function check_password($password)
	  {
		  $this->load->library('session');
		  
		  $username = $this->input->post('username');
		  $res = $this->dashboard_admin_model->get_admin(array('username' => $username));
		  if (sha1($password.$res['uuid']) != $res['password'])
		  {
			  $this->form_validation->set_message('check_password', '用户名或者密码错误');
			  return FALSE;
		  } 
		  else 
		  {
			  $this->session->set_userdata('uuid', $res['uuid']);
			  setcookie('uuid', $res['uuid'], time() + 3600);
			  return TRUE;
		  }
	  }
	  
  }
//end