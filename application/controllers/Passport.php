<?php 
class Passport extends CI_Controller
{ 
	public function __construct(){

	    parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');  
		$this->app_id = $this->config->item('app_id');
		$this->app_secret = $this->config->item('app_secret');
		$this->template_id = $this->config->item('passport_template_id');
	}
	
	public function index()
	{
		$thisPageUri = base_url("passport/index");
		$redirect_uri = $this->input->get('redirect_uri', TRUE);
		$state = $this->input->get('state', TRUE);
		$code = $this->input->get('code', TRUE);
		
		//记录回跳页面的cookie
		if($redirect_uri)
		{
			setcookie("redirect_uri", $_GET['redirect_uri'], time()+3600, '/', 'www.szuswzx.com');
		}
		
		if($state)
		{
			switch ($state)
			{
				case 'checkuser':
				{
					if ($code)
					{
						$json = json_decode($this->http_get('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->app_id.'&secret='.$this->app_secret.'&code='.$code.'&grant_type=authorization_code'), true);
						$openid = $json['openid'];
						//$userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
						$userinfo = $this->user_model->get_user($openid);
						if (count($userinfo) == 0) {   //用户第一次使用百科功能,请求用户授权,保存用户信息
							header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->app_id.'&redirect_uri='.$thisPageUri.'&response_type=code&scope=snsapi_userinfo&state=login#wechat_redirect');
						}
						setcookie("openid", $openid, time() + 3600, '/', 'www.szuswzx.com');
						setcookie("secret", md5($openid), time() + 3600, '/', 'www.szuswzx.com');
					} 
					else 
					{
						header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->app_id.'&redirect_uri='.$thisPageUri.'&response_type=code&scope=snsapi_base&state=checkuser#wechat_redirect');
					}
					break;
				}
				case 'login':  //用户注册
				{
					if ($code) 
					{
						$json = json_decode($this->http_get('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->app_id.'&secret='.$this->app_secret.'&code='.$code.'&grant_type=authorization_code'),true);
						$openid = $json['openid'];
						$access_token = $json['access_token'];
						$userinfo = json_decode($this->http_get('https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN'),true);
						if (isset($userinfo['errcode'])) 
						{
							echo $userinfo['errcode'];
							exit;
						}
						$nickname = str_replace('\'', '', $userinfo['nickname']);
						$sex = $userinfo['sex'];
						$province = $userinfo['province'];
						$city = $userinfo['city'];
						$country = $userinfo['country'];
						$headimgurl = $userinfo['headimgurl'];
						$unionid = isset($userinfo['unionid']) ? $userinfo['unionid'] : '';
						$time = time();
						$in = array(
							'openid' => $openid,
							'nickname' => $nickname,
							'province' => $province,
							'city' => $city,
							'country' => $country,
							'headimgurl' => $headimgurl,
							'unionid' => $unionid,
							'time' => $time
						);
						//$done = $Mysql->Insert('sdbk_user','openid,nickname,province,city,country,headimgurl,unionid,time',"'$openid','$nickname','$province','$city','$country','$headimgurl','$unionid','$time'");
						$this->user_model->insert_user($in);
						setcookie('openid', $openid, time() + 3600, '/', 'www.szuswzx.com');
						setcookie('secret', md5($openid), time() + 3600, '/', 'www.szuswzx.com');
						header('Location: '.$thisPageUri);
					} 
					else 
					{
						echo "2";
					}
					break;
				}
			}
		}
		
		if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) 
		{
			if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) 
			{
				header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->app_id.'&redirect_uri='.$thisPageUri.'&response_type=code&scope=snsapi_base&state=checkuser#wechat_redirect');
			}
			$openid = $_COOKIE["openid"];
			//$userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
			$userinfo = $this->user_model->get_user($openid);
		} 
		else 
		{
			header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->app_id.'&redirect_uri='.$thisPageUri.'&response_type=code&scope=snsapi_base&state=checkuser#wechat_redirect');
		}
		
		//用户已经将校园卡绑定
		if ($userinfo['studentNo'] != 0) 
		{
			header('Location: '.base_url("passport/bind").'?ticket=LOGIN');
		}
		
		if ($userinfo['nickname'] == null)
		{
			setcookie('openid', '', time() - 3600);
			setcookie('secret', '', time() - 3600);
		}
		
		//用户已经注册，但是尚未将校园卡绑定
		$data['userinfo'] = $userinfo;
		$this->load->view('passport/bind', $data);
	}
	
	//将微信号与校园卡绑定
	public function bind()
	{
		$thisPageUri = base_url("passport/index");
		$ticket = $this->input->get('ticket', TRUE);
		
		$status = 0;
		$userinfo = array();
		if(isset($_COOKIE['openid']))			
		{
			$openid = $_COOKIE['openid'];
			//$userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
			$userinfo = $this->user_model->get_user($openid);
			if(!$userinfo)
			{
				echo 'error';
				exit();
			}
		} 
		else 
		{
			header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->app_id.'&redirect_uri='.$thisPageUri.'&response_type=code&scope=snsapi_userinfo&state=login#wechat_redirect');
			exit();
		}

		if($ticket)
		{
			if ($userinfo['studentNo'] == 0)
			{
				$CASserver = 'https://auth.szu.edu.cn/cas.aspx/';      //深圳大学统一身份认证URL**不能修改**
				$ReturnURL = 'http://swzx.szu.edu.cn/sdbk';   //用户认证后跳回到您的网站，根据实际情况修改
				$URL = $CASserver . 'serviceValidate?ticket=' . $ticket . '&service='. $ReturnURL;
				$test = file_get_contents($URL);
				$userinfo['status'] = 1;
				$userinfo['data']['studentName']= $this->RegexLog($test, "PName");                 //姓名
				$userinfo['data']['org']= $this->RegexLog($test, "OrgName");                       //单位
				$userinfo['data']['sex']= $this->RegexLog($test, "SexName");                       //性别
				$userinfo['data']['studentNo']= $this->RegexLog($test, "StudentNo");               //学号
				$userinfo['data']['icAccount']= $this->RegexLog($test, "ICAccount");               //校园卡号
				// $userinfo['data']['personalId']= $this->RegexLog($test, "personalid");             //身份证号
				$userinfo['data']['phone']= $this->RegexLog($test, "mobile");

				$cdt = array('openid' => $userinfo['openid']);
				$cdt1 = array('icAccount' => $userinfo['data']['icAccount']);

				$isBind = $this->user_model->get_users($cdt1);

				if ($isBind)
				{
					$status = 2;
				} 
				else 
				{
					//$updating = $db->update('sdbk_user', $userinfo['data'], $cdt);
					$updating = $this->user_model->update_user($userinfo['data'], $cdt);
					if ($updating != 0) 
					{
					    $this->load->model('wechat_model');
						$access_token = $this->wechat_model->get_access_token();
						$this->load->library('weixin', $config = array('AppId' => $this->app_id, 'AppSecret' => $this->app_secret));
						$templeurl = $thisPageUri;						
						$textPic = array(
							'first' => array('value'=> '您已经成功将'.$userinfo['data']['studentName'].'的校园卡与深大百科通行证绑定！\n', 'color'=> '#df4848'),
							'keyword1' => array('value'=> $userinfo['data']['icAccount'], 'color'=> '#408ec0'),
							'keyword2' => array('value'=> date("Y-m-d h:i:s", time()), 'color'=> '#333'),
							'remark' => array('value'=> '\n如果不是本人操作，请联系事务君（微信号：szushiwujun）取消绑定。', 'color'=> '#bbbbbb'),
						);
						$this->weixin->pushtemple($access_token, $userinfo['openid'], $this->template_id, $templeurl, $textPic);
						
						if (isset($_COOKIE['redirect_uri'])) 
						{
							$redirect_uri = urldecode($_COOKIE['redirect_uri']);
							setcookie('redirect_uri', '', time() - 3600);
							header('Location: '.$redirect_uri);
							exit();
						}
						$status = 1;
					} 
					else 
					{
						$status = 0;
					}
				}
			} 
			else 
			{
				if (isset($_COOKIE['redirect_uri'])) 
				{
					$redirect_uri = urldecode($_COOKIE['redirect_uri']);
					setcookie('redirect_uri', '', time() - 3600);
					header('Location: '.$redirect_uri);
					exit();
				}
				$status = 1;
			}
		}  
		else 
		{
			header("Location: ".$thisPageUri);
			exit();
		}
		
		//显示绑定结果
		$data = array();
		$data['userinfo']['headimgurl'] = $userinfo['headimgurl'];
		$data['userinfo']['nickname'] = $userinfo['nickname'];
		$data['status'] = $status;
		$this->load->view('passport/bind_result',$data);
	}
	
	function http_get($url)
	{
		$oCurl = curl_init();
		if(stripos($url,"https://") !== FALSE) {
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"]) == 200) {
			return $sContent;
		} else {
			return false;
		}
	}
	
	function RegexLog($xmlString, $subStr)
	{
		preg_match('/<cas:'.$subStr.'>(.*)<\/cas:'.$subStr.'>/i', $xmlString, $matches);
		return $matches[1];
	}
}



