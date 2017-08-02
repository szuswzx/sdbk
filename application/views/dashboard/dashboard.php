<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<meta name="renderer" content="webkit">
<title>深大控制台</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>

<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">  
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="./../public/dashboard/dashcss.css">
</head>
<body>
<div class="head">
 <a id="menu-trigger" href="javascript:void(0)">
 <i class="fa fa-bars"></i>
 <a id="menu-trigger" href=""><i class="fa fa-home"></i></a>
 <span class="dash">深大百科控制台 > 控制台</span>
 <div class="floa">
  <a id="menu-trigger" href=""><i class="fa fa-bug"></i></a>
  <ul class="nav navbar-nav">
   <li class="dropdown">
      <a href="" class="user dropdown-toggle" data-toggle="dropdown">我的消息<b class="caret"></b> 
      </a>
      <ul class="dropdown-menu" style="min-width: 100%">
          <li><a href="#"><i class="fa fa-envelope"></i>暂无消息</a></li>
      </ul>
   </li>
 </ul>

 <ul class="nav navbar-nav">
   <li class="dropdown">
      <a href="" class="user dropdown-toggle" data-toggle="dropdown">账户<b class="caret"></b> 
      </a>
      <ul class="dropdown-menu" style="min-width: 100%">
        <li id="setting"><a href="#">账户设置</a></li>
          <li><a href="#">退出账户</a></li>
      </ul>
   </li>
 </ul>
 </a>
 </div>
</div>

<div class="sild">
 <div class="out">
  <div class="inner" href="www.baidu.com">
     <p class="top"><?php echo $usercount;?></p>
     <p class="bottom">总用户/人</p>
   </div>
   <div class="inner">
     <p class="top"><?php echo $appcount;?></p>
     <p class="bottom">总应用/个</p>
   </div>
   <div class="inner" id="issue">
     <p class="top"><?php echo $issuecount;?></p>
     <p class="bottom">总事务/个</p>
   </div>
   <div class="inner">
     <p class="top"><?php echo $roomcount;?></p>
     <p class="bottom">电费提醒/个订阅</p>
   </div>
  </div>
</div>

<div class="dLeft" style="background-image: url(../public/images/dashboard_bg.jpg)">
   <div class="menuheader">
     <h2>深大百科</h2>
     <p>dashboard</p>
   </div>
   <div class="solve" id="issues">
     <i class="fa fa-envelope"></i>事务 
   </div>
   <div class="solve" id="findcard">
     <i class="fa fa-credit-card" ></i>校园卡找回
   </div>
   <div class="solve" id="settings">
     <i class="fa fa-cogs"></i>设置
   </div>
</div>

</body>
 <script type="text/javascript">
jQuery(function () {
    $('#menu-trigger').on("click",function () {
        if ($('.dLeft').hasClass('mobile-menu-left')) {
            $('.dLeft').removeClass('mobile-menu-left');
            $('.head, .sild, .footer').removeClass('mobile-left');
        } else {
            
            $('.head, .sild, .footer').addClass('mobile-left');
            $('.dLeft').addClass('mobile-menu-left');
        }
    });
    $("#issue").on("click",function(){
      $(".sild").load("../dashboard/issue",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
      });
    });
    $("#issues").on("click",function(){
      $(".sild").load("../dashboard/issue",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
      });
	   $('.head, .sild').removeClass('mobile-left');
       $('.dLeft').removeClass('mobile-menu-left');
    });
    $("#setting").on("click",function(){
      $(".sild").load("../dashboard/setting",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
      });
    });
    $("#settings").on("click",function(){
      $(".sild").load("../dashboard/setting",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
      });
    });
      $("#findcard").on("click",function(){
      $(".sild").load("../dashboard/add_card",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
      });
    });
    // $(".dropdown-menu").on("mouseover",function(){
    //      $(".user").css("background-color","white");
    // });
    // $(".dropdown-menu").on("mouseout",function(){
    //      $(".user").css("background-color","#f8f8f8");
    // });
});

</script>
</html>