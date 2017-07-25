<?php
  class Menu_model extends CI_Model
  {
	  public function __construct()
	  {
		  parent::__construct();
		  $this->load->database();
		  $this->app_id = $this->config->item('app_id');
		  $this->app_secret = $this->config->item('app_secret');
	  }
	  
	  public function insert($options = array())
	  {
		  $this->db->insert('sdbk_menu', $options);
		  return $this->db->affected_rows();
	  }
	  
	  public function get_menu($options = array(), $field = '*')
	  {
		  $this->db->select($field);
		  $this->db->where($options);
		  $query= $this->db->get('sdbk_menu');
		  return $query->result_array();;
	  }
	  
	  public function get_menu_num($options = array())
	  {
		  $this->db->where($options);
		  $query = $this->db->get('sdbk_menu');
		  $menu_num = $query->num_rows();
		  return $menu_num;
	  }
	  
	  public function delete_menu($options = array())
	  {
		  $this->db->delete('sdbk_menu', $options);
		  return $this->db->affected_rows();
	  }
	  
	  public function update_menu($options = array(), $field = array())
	  {
		  $this->db->set($field);
		  $this->db->where($options);
		  $this->db->update('sdbk_menu');
		  return $this->db->affected_rows();
	  }
	  
	  public function myinsert_menu($mid,$data)
	  {
		  //一级菜单不能超过三个，二级菜单不能超过五个
		  $success = 0;
		  $button = $this->get_menu($options = array('previous' => $mid));
		  $previous_button = $this->get_menu($options = array('mid' => $mid));
		  if(($mid == '0' && count($button) < 3) || ($mid != '0' && count($button) < 5 && count($previous_button) != 0))   //如果添加的菜单不存在上级菜单也不是一级菜单(previous=0)，孤立菜单不允许添加
			  $success = 1;
		  if($success == 1)
		  {
			  //开启手动事务，微信端未响应的时候回滚
			  $this->db->trans_strict(FALSE);
		      $this->db->trans_begin();
			  
			  $res = $this->insert($data);
			  if($res == 1)
			  {	  
				  $result = $this->_update_menu();			  
				  if($result['errcode'] == 0 && $result['errmsg'] == 'ok')
				  {
					  $this->db->trans_commit();
					  $menudata['error'] = '0';
				  }
				  else
				  {
                      $this->db->trans_rollback();					  
					  $menudata['error'] = '1';
					  $menudata['error_message'] = "添加失败，微信端未响应";
				  }
			  }
			  else
			  {
				  $this->db->trans_rollback();
				  $menudata['error'] = '1';
				  $menudata['error_message'] = "服务器异常，添加失败！";
			  }
		  }
		  else
		  {
			  $menudata['error'] = '1';
			  $menudata['error_message'] = "添加失败，一级菜单只能有3个，二级菜单只能有5个哦，请检查一下吧下=_=";
		  }
		  $menudata['menudata'] = $this->get_menu();
		  return $menudata;
	  }
	  
	  public function mydelete_menu($mid)
	  {
		  //开启手动事务
		  $this->db->trans_strict(FALSE);
		  $this->db->trans_begin();
		  
		  //直接删除了一级菜单，其下所有二级菜单都会删除
		  $button = $this->get_menu($options = array('mid' => $mid));		  
		  $sub_button_num = $this->get_menu_num($options = array('previous' => $mid));
		  if(count($button) != 0 && $button['0']['previous'] == '0')
			  $res1 = $this->delete_menu($options = array('previous' => $mid));
		  else
			  $res1 = 0;
		  $res = $this->delete_menu($options = array('mid' => $mid));
		  if(($res + $res1) == (1 + $sub_button_num))
		  {
			  $result = $this->_update_menu();			  
			  if($result['errcode'] == 0 && $result['errmsg'] == 'ok')
			  {
				  $this->db->trans_commit();
				  $menudata['error'] = '0';
			  }
			  else
			  {	
                  $this->db->trans_rollback();
				  $menudata['error'] = '1';
				  $menudata['error_message'] = "删除失败，微信端未响应";
			  }			  
		  }
		  else
		  {
			  $this->db->trans_rollback();
			  $menudata['error'] = '1';
			  $menudata['error_message'] = "删除失败";
		  }
		  $menudata['menudata'] = $this->get_menu();
		  return $menudata;
	  }
	  
	  public function myupdate_menu($mid, $data)
	  {
		  //开启手动事务
		  $this->db->trans_strict(FALSE);
		  $this->db->trans_begin();
		  
		  $res = $this->update_menu(array('mid' => $mid), $data);
		  if($res == 1)
		  {
			  $result = $this->_update_menu();
			  if($result['errcode'] == 0 && $result['errmsg'] == 'ok')
			  {
				  $this->db->trans_commit();
				  $menudata['error'] = '0';
			  }
			  else
			  {				  
				  $this->db->trans_rollback();
				  $menudata['error'] = '1';
				  $menudata['error_message'] = "更新失败，微信端未响应";
			  }	
		  }
		  else
		  {
			  $this->db->trans_rollback();
			  $menudata['error'] = '1';
			  $menudata['error_message'] = '更新失败';
		  }
		  $menudata['menudata'] = $this->get_menu();
		  return $menudata;
	  }
	  
	  //上传图文消息的图片获取图片url
	  public function upload_img($filename)
	  {
		  $this->load->library('weixin', $config = array('AppId' => $this->app_id, 'AppSecret' => $this->app_secret));//220测试
		  $token = $this->weixin->getToken();
		  $token = json_decode($token, true);
		  $url = $this->weixin->uploadImgUrl($token['access_token'], $filename);
		  return $url;
	  }
	  
	  //通过接口更新微信端公众号菜单，每天可以对菜单进行更新1000次
	  private function _update_menu()
	  {
		  //获取一级菜单
		  $button = $this->get_menu($options = array('previous' => '0'));
		  //获取二级菜单
		  $sub_button = array();
		  $menuJson = array();
		  foreach($button as $row)
		  {
			  $sub_button[] = $this->get_menu($options = array('previous' => $row['mid']), $field = 'type,name,url,key');
		  }
		  //生成菜单json
		  $i = 0;
		  foreach($button as $row)
		  {
			  if(empty($sub_button[$i]))
				  $menuJson['button'][] = array('type' => $row['type'], 'name' => $row['name'], 'url' => $row['url'], 'key' => $row['key']);
			  else
				  $menuJson['button'][] = array('name' => $row['name'], 'sub_button' => $sub_button[$i]);
			  $i++;
		  }					  

		  $this->arrayRecursive($menuJson, 'urlencode', true);
		  $jsonString = urldecode(json_encode($menuJson));

		  $this->load->library('weixin', $config = array('AppId' => $this->app_id, 'AppSecret' => $this->app_secret));//220测试
		  $token = $this->weixin->getToken();
		  $token = json_decode($token, true);
		  $result = json_decode($this->weixin->menuSet($token["access_token"], $jsonString), true);
		  //$result = array('errcode' => '100000','errmsg' =>'nook');
		  return $result;
					  
	  }
	  
	 /**************************************************************
     *
     *  使用特定function对数组中所有元素做处理
     *  @param  string  &$array     要处理的字符串
     *  @param  string  $function   要执行的函数
     *  @return boolean $apply_to_keys_also     是否也应用到key上
     *  @access public
     *
     *************************************************************/
	  public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
	  {
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }
            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
      }
  }