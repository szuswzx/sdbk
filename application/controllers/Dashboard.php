<?php
  class Dashboard extends CI_Controller
  {
	  private $userinfo = array();
	  public function __construct()
	  {
		  parent::__construct();
		  $this->load->model('dashboard/dashboard_admin_model');
		  $this->load->model('dashboard/log_model');
		  $this->load->helper('url_helper');
          $this->userinfo = array();
		  $this->_check_login();		  
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
	  
	  //控制台首页
	  public function first_page()
	  {
		  $data = $this->dashboard_admin_model->get_datalist();
		  $data['account'] = $this->userinfo['username'];
		  $data['rank'] = $this->userinfo['rank'];
		  $this->load->view('dashboard/dashboard',$data);
	  }
	  
	  //校园卡解绑
	  public function find_user($page = 'page')
	  {
		  $this->load->model('user_model');
		 
		  if($page == 'page')
			  $this->load->view('dashboard/unbind/find_user');
		  else
		  {
			  $data['user'] = $this->user_model->get_user_by_studentNo();
			  echo json_encode($data['user']);
		  }
	  }
	  
	  public function unbind($userid = 0)
	  {
		  $this->load->model('user_model');
		  
		  $res = $this->user_model->unbind($userid);
		  $this->log_model->save_log($this->userinfo['username'], "解绑了用户".$userid."的校园卡");
		  if($res >= 1)
			  echo "success";
		  else
			  echo "failed";
	  }
	  
	  //绑定用户推送新公文通
	  public function board_user($page = 'page')
	  {
		  $this->load->model('user_model');
		 
		  if($page == 'page')
			  $this->load->view('dashboard/board/board_bind_user');
		  else if($page == 'page2')
			  $this->load->view('dashboard/board/return_board_user');
		  else
		  {
			  $data['user'] = $this->user_model->get_user_by_studentNo();
			  echo json_encode($data['user']);
		  }
	  }
	  
	  public function board_bind_list()
	  {
		  $this->load->model('board/board_bind_model');
		  
		  $data['bind_user'] = $this->board_bind_model->get_bind_user();
		  $this->load->view('dashboard/board/board_bind_list', $data);
	  }
	  
	  public function bind_board_push($userid = 0)
	  {
		  $this->load->model('board/board_bind_model');
		  
		  $res = $this->board_bind_model->bind_board_push($userid);
		  $this->log_model->save_log($this->userinfo['username'], "为".$userid."用户绑定了公文通提醒推送");
		  echo $res;
	  }
	  
	  public function unbind_board_push($userid = 0)
	  {
		  $this->load->model('board/board_bind_model');
		  
		  $res = $this->board_bind_model->unbind_board_push($userid);
		  $this->log_model->save_log($this->userinfo['username'], "为".$userid."用户解除了公文通提醒推送");
		  echo $res;
	  }
	  
	  //活动发布
	  public function activity()
	  {
		  $this->load->model('dashboard/activity_model');

		  if($this->userinfo['rank'] >= 5)
		  {
		  	  $data['activities'] = $this->activity_model->get_activity();
			  $this->load->view('dashboard/activity/manage_activity', $data);
		  }
		  else
		  {
			  echo '权限不足';
		  }
	  }
	  
	  public function delete_activity($id = 0)
	  {
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
		  $this->load->model('dashboard/activity_model');
		  $this->load->model('wechat_model');

		  if($this->userinfo['rank'] >= 5)
		  {
			  $access_token = $this->wechat_model->get_access_token();
		  	  $this->activity_model->push_activity($id, $access_token);
			  $this->log_model->save_log($this->userinfo['username'], "发送了活动消息模板：".$this->input->post('keyword1'));
		  }
		  else
		  {
			  echo '权限不足';
		  }
	  }
	  
	  public function add_activity($out = 'all')
	  {
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
		  $this->log_model->save_log($this->userinfo['username'], "导出了id为".$id."的活动报名名单");
	  }
	  
	  //校园卡找回
      public function card($type = 'all', $out = 'page', $page = 1)
	  {
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
		  $this->load->model('dashboard/issue_model');
		  $issue = $this->issue_model->get_issue_by_id($id);
		  
		  $issue = $this->security->xss_clean($issue);
		  echo json_encode($issue);
	  }
	  
	  public function search_issue($page = 1)
	  {
		  $this->load->model('dashboard/issue_model');
		  list($issue, $page_sum) = $this->issue_model->get_issue_by_keyword($page);
		  
		  $data['issue'] = $issue;
		  $data['page_sum'] = $page_sum;
		  $data = $this->security->xss_clean($data);
		  echo json_encode($issue);
	  }
	  
	  public function delete_issue($id = 0)
	  {
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
	  public function menu($slug = 'all', $mid = 0)
	  {
		  $this->load->model('dashboard/menu_model');
		  $this->load->model('wechat_model');		  


		  if($slug == 'all')		  //0表示显示所有菜单
		  {
			  $this->load->helper('form');
			  $menu = $this->menu_model->get_menu(array(), array('mid', 'previous', 'name'));
			  //获得一级菜单
			  foreach($menu as $row)
			  {
				  if($row['previous'] == 0)
				  {
					  $first[] = $row;
				  }
			  }
			  //获得二级菜单
			  $i = 0;
			  foreach($first as $first_menu)
			  {
				  $sub_menu[$i] = array();
				  foreach($menu as $row)
				  {
					  if($row['previous'] == $first_menu['mid'])
					  {
						  $sub_menu[$i][] = $row;
					  }
				  }
				  $i++;
			  }
			  $menudata['first_menu'] = $first;
			  $menudata['sub_menu'] = $sub_menu;
			  $this->load->view('dashboard/menu/menuTest', $menudata);
		  }
		  else if($slug == 'get_by_id')
		  {
			  $menu = $this->menu_model->get_menu(array('mid' => $mid));
			  if($menu)
				  $menu = $menu[0];
			  echo json_encode($menu);
		  }
		  else if($slug == 'add')     //1表示添加菜单，mid传进来的值是添加的菜单的previous
		  {
			  $this->load->helper('form');
			  $this->load->library('form_validation');
			  //获取access_token
			  $access_token = $this->wechat_model->get_access_token();			  
			  
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
				  echo validation_errors();
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
					  }
					  else
					  {
						  $img = array('upload_data' => $this->upload->data());
						  $data['picurl'] = $this->menu_model->upload_img($img['upload_data']['full_path'], $access_token);
						  $menudata = $this->menu_model->myinsert_menu($mid, $data, $access_token);
					  }
				  }
				  else
				  {
					  $menudata = $this->menu_model->myinsert_menu($mid, $data, $access_token);
				  }
				  $this->log_model->save_log($this->userinfo['username'], "添加了".$data['name']."菜单");
				  if($menudata['error'] == 0)
					  echo "success";
				  else
					  echo $menudata['error_message'];
                  //$this->load->view('dashboard/menu/all_menu', $menudata);				  
			  }	
		  }
		  else if($slug == 'delete')  //2表示删除菜单
		  {
			  //获取access_token
			  $access_token = $this->wechat_model->get_access_token();			  
			  $menudata = $this->menu_model->mydelete_menu($mid,$access_token);
			  $this->log_model->save_log($this->userinfo['username'], "删除了id为".$mid."菜单");
			  if($menudata['error'] == 0)
				  echo "success";
			  else
				  echo $menudata['error_message'];
			  //$this->load->view('dashboard/menu/all_menu', $menudata);
		  }
		  else if($slug == 'update')  //3表示更新当前存在菜单
		  {
			  $this->load->helper('form');
			  $this->load->library('form_validation');
			  //获取access_token
			  $access_token = $this->wechat_model->get_access_token();			  
			  
			  $data['mid'] = $mid;
			  $data['menudata'] = $this->menu_model->get_menu(array('mid' => $mid));
			  if(count($data['menudata']) == 0)//菜单不存在
			  {
				  $menudata['error'] = '1';
				  $menudata['error_message'] = '更新失败，该菜单项不存在哦！';
				  echo $menudata['error_message'];
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
					  echo validation_errors();
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
							  
							  /*$menudata['error'] = '1';
							  $menudata['error_message'] = '图片上传失败，图文消息的图片必须是jpg和png格式且最大1M:'.$this->upload->display_errors();*/
							  $menudata = $this->menu_model->myupdate_menu($mid, $data, $access_token);							  
						  }
						  else
						  {
							  $img = array('upload_data' => $this->upload->data());
							  $data['picurl'] = $this->menu_model->upload_img($img['upload_data']['full_path'], $access_token);
							  $menudata = $this->menu_model->myupdate_menu($mid, $data, $access_token);
						  }
					  }
					  else
					  {
						  $menudata = $this->menu_model->myupdate_menu($mid, $data, $access_token);
					  }					  
					  $this->log_model->save_log($this->userinfo['username'], "更新了id为".$mid."菜单");					  
					  //$this->load->view('dashboard/menu/all_menu', $menudata);
					  if($menudata['error'] == 0)
						  echo "success";
					  else
						  echo $menudata['error_message'];
				  }				  
			  }				  
		  }
	  }
	  
	  public function keywords($keyword = '')
	  {
		  $this->load->model('dashboard/wechat_keyword_model');
		  
		  $data['keyword'] = $this->wechat_keyword_model->get_keyword($keyword, 1);
		  $this->load->view('dashboard/keyword/success', $data);
	  }
	  
	  public function delete_keyword($id = 0)
	  {
		  $this->load->model('dashboard/wechat_keyword_model');
		  
		  $res = $this->wechat_keyword_model->delete_keyword($id);
		  echo $res;
	  }
	  
	  public function add_keyword()
	  {
		  $this->load->model('dashboard/wechat_keyword_model');
		  
		  $res = $this->wechat_keyword_model->add_keyword();
		  echo $res;
	  }
	  
	  public function update_keyword($id = 0)
	  {
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
		  $this->load->library('session');
		  //setcookie('uuid', '', time() - 3600);
		  $this->session->unset_userdata('uuid');
		  header("location:".site_url("dashboard/index"));
		  exit();
	  }
	  
	  public function fresh()
	  {
		  $this->load->model('wechat_model');
		  $access_token = $this->wechat_model->fresh_access_token();
		  echo $access_token;
	  }
	  	  
	  //登录检测
	  private function _check_login()
	  {
		$this->load->helper('url');
		$this->load->library('session');
		$uuid = $this->session->userdata('uuid');
		if(current_url() != site_url('dashboard/index')){
			if ($uuid)
			{
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
			  //setcookie('uuid', $res['uuid'], time() + 3600);
			  return TRUE;
		  }
	  }
	  
  }
//end