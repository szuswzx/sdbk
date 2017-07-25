<?php
  class Score extends CI_Controller
  {
	  public $userinfo = array();
	  public function __construct()
	  {
		  parent::__construct();
		  $this->load->model('score_model');
		  $this->load->model('user_model');
		  $this->load->helper('url_helper');
		  $this->_check_user('score');             //参数为该控制器的名称
	  }
	  
	  public function index()                      //正常输出成绩单
	  {
		  $studentNo = $this->userinfo['studentNo'];
		  list($data['scoreList'], $data['point']) = $this->score_model->get_score($studentNo);
		  $data['userinfo'] = $this->userinfo;
		  
		  $this->load->view('score/view', $data);

	  }
	  
	  public function create_scoreimg()              //创建成绩单图片
	  {
		  $this->load->view('score/save_scoreimg');
	  }
	  
	  public function save_scoreimg()                //生成图片
	  {
		  $studentNo = $this->userinfo['studentNo'];
		  list($scoreList, $point) = $this->score_model->get_score($studentNo);
		  $data['userinfo'] = $this->userinfo;
		  
		  $item = $scoreList[0];
		  $width = 640;
		  if ($item['SFXX'] && $studentNo > 2015000000) {
		      $height = count($scoreList) * 260 + 590;
		  } else {
		      $height = count($scoreList) * 220 + 590;
		  }


		  $image = imagecreatetruecolor($width, $height);
		  $imageHeader = imagecreatetruecolor($width, 400);
		  imageantialias($image, true);
		  imageantialias($imageHeader, true);

		  // 定义颜色
		  $bgColor = imagecolorallocate($image, 255, 255, 255); // 背景色
		  $headerBgColor = imagecolorallocate($image, 255, 95, 90); // 背景色
		  $normalColor = imagecolorallocate($image, 22, 5, 7); // 正常暗色
		  $normalColorLight = imagecolorallocate($image, 255, 255, 255); // 正常亮色
		  $pointColor = imagecolorallocate($image, 0xff, 0xf0, 0x00); // 绩点字体颜色
		  $footerColor = imagecolorallocate($image, 0xaa, 0xaa, 0xaa); // 底部字体颜色
		  // 等级颜色
		  $gradeColor = array(
		      null => imagecolorallocate($image, 0x00, 0x00, 0x00),
		      'AP' => imagecolorallocate($image, 0xEC, 0x30, 0x30),
		      'A' => imagecolorallocate($image, 0xff, 0x5F, 0x5A),
		      'BP' => imagecolorallocate($image, 0x76, 0x4A, 0xD5),
		      'B' => imagecolorallocate($image, 0x4A, 0x8F, 0xD5),
		      'CP' => imagecolorallocate($image, 0xff, 0x7A, 0x06),
		      'C' => imagecolorallocate($image, 0xff, 0xA2, 0x00),
		      'D' => imagecolorallocate($image, 0x22, 0x9C, 0x3C),
		      'F' => imagecolorallocate($image, 0x4C, 0x4C, 0x4C)
		  );

		  // 定义字体
		  $pointFont = "./public/score/font/p.ttf"; // 绩点用的字体
		  $normalFont = "./public/score/font/shsn.ttf"; // 正常字体

		  // 填充背景色
		  imagefill($image, 0, 0, $bgColor);
		  imagefill($imageHeader, 0, 0, $headerBgColor);

		  // 加上头部
		  imagecopy($image, $imageHeader, 0, 0, 0, 0, 640, 400);

		  // 头部的话
		  imagettftext($image, 22, 0, 40, 80, $normalColorLight, $normalFont, $this->userinfo['studentName'].' 同学，你本学期的绩点是：');
		  imagettftext($image, 28, 0, 160, 340, $normalColorLight, $normalFont, '下学期再接再厉哦！');

		  // 加上绩点
		  imagettftext($image, 100, 0, 190, 235, $pointColor, $pointFont, $point);


		  // 输出成绩
		  $i = 0;
		  $thisLeft = 0;
		  $thisRight = 0;
		  $thisTop = 0;
		  $thisBottom = 0;
		  foreach ($scoreList as $item) {
		      $thisLeft = 20;
		      $thisRight = 620;
		      if ($item['SFXX'] && $studentNo > 2015000000) {
		          $thisTop = $i * 260 + 420;
		          $thisBottom = ($i + 1) * 260 + 400;
		      } else {
		          $thisTop = $i * 220 + 420;
		          $thisBottom = ($i + 1) * 220 + 400;
		      }

		      //ImageRectangleWithRoundedCorners($image, $thisLeft, $thisTop, $thisRight, $thisBottom, 10, $gradeColor[str_replace('+', 'P', $item['DJCJ'])]);
			  $x1 = $thisLeft;
			  $y1 = $thisTop;
			  $x2 = $thisRight;
			  $y2 = $thisBottom; 
			  $radius = 10; 
			  $color = $gradeColor[trim(str_replace('+', 'P', $item['DJCJ']))];
			  
			  imagefilledrectangle($image, $x1+$radius, $y1, $x2-$radius, $y2, $color);
		      imagefilledrectangle($image, $x1, $y1+$radius, $x2, $y2-$radius, $color);
		      // draw circled corners
		      imagefilledellipse($image, $x1+$radius, $y1+$radius, $radius*2, $radius*2, $color);
		      imagefilledellipse($image, $x2-$radius, $y1+$radius, $radius*2, $radius*2, $color);
		      imagefilledellipse($image, $x1+$radius, $y2-$radius, $radius*2, $radius*2, $color);
		      imagefilledellipse($image, $x2-$radius, $y2-$radius, $radius*2, $radius*2, $color);

		      imagettftext($image, 20, 0, $thisLeft + 20, $thisTop + 50, $normalColorLight, $normalFont, '课程名：' . substr($item['KCMC'], 0, 33));
		      imagettftext($image, 20, 0, $thisLeft + 20, $thisTop + 90, $normalColorLight, $normalFont, '课程号：' . $item['KCH']);
		      imagettftext($image, 20, 0, $thisLeft + 20, $thisTop + 130, $normalColorLight, $normalFont, '学分：' . $item['XF']);
		      imagettftext($image, 20, 0, $thisLeft + 20, $thisTop + 170, $normalColorLight, $normalFont, '课程类别：' . $item['KCLB_A']);

		      if ($item['SFXX'] && $studentNo > 2015000000) {
		          imagettftext($image, 20, 0, $thisLeft + 20, $thisTop + 210, $normalColorLight, $normalFont, '培养方案认定类别：' . $item['SFXX']);
		      }

		      if ($item['SFXX'] && $studentNo > 2015000000) {
		          if (strlen($item['DJCJ']) == 2) {
		              imagettftext($image, 80, 0, $thisLeft + 440, $thisTop + 160, $normalColorLight, $normalFont, $item['DJCJ']);
		          } else {
		              imagettftext($image, 80, 0, $thisLeft + 470, $thisTop + 160, $normalColorLight, $normalFont, $item['DJCJ']);
		          }
		      } else {
		          if (strlen($item['DJCJ']) == 2) {
		              imagettftext($image, 80, 0, $thisLeft + 440, $thisTop + 140, $normalColorLight, $normalFont, $item['DJCJ']);
		          } else {
		              imagettftext($image, 80, 0, $thisLeft + 470, $thisTop + 140, $normalColorLight, $normalFont, $item['DJCJ']);
		          }
		      }
    
		      $i++;
		  }

		  // 输出Footer
		  imagettftext($image, 18, 0, 150, $thisBottom + 60, $footerColor, $normalFont, '以上数据由教务部提供，仅供参考');
		  imagettftext($image, 18, 0, 140, $thisBottom + 100, $footerColor, $normalFont, '若有变化，请以教务部网站公布为准');
		  imagettftext($image, 18, 0, 70, $thisBottom + 140, $footerColor, $normalFont, '深圳大学学生事务服务中心 · 深大百科 权威发布');

		  // 输出全图
          header("Content-Type: image/jpeg");
		  imagejpeg($image, NULL, 20);

		  imagedestroy($image);
		  imagedestroy($imageHeader);		  
		  		  
	  }
	  
	  private function _check_user($pro)
	  {
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
//end