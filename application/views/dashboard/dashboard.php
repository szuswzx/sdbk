<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" /> -->
<meta name="renderer" content="webkit">
<title>控制台-深大百科</title>
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
 <span class="dash">深大百科控制台 > </span><span class="dash" id="dashPart">控制台</span>
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
      <a href="" class="user dropdown-toggle" data-toggle="dropdown"><?php echo $account;?><b class="caret"></b> 
      </a>
      <ul class="dropdown-menu" style="min-width: 100%">
        <li id="setting"><a href="#">账户设置</a></li>
          <li><a href="<?php echo site_url("dashboard/logout");?>">退出账户</a></li>
      </ul>
   </li>
 </ul>
 </a>
 </div>
</div>

<div class="sild">
 <div class="out">
  <div class="inner" id="sdbkUser">
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
   <input id="Rank" type="hidden" value="<?php echo $rank;?>">
   <div class="solve" id="issues">
     <i class="fa fa-envelope"></i>事务 
   </div>
   <div class="solve" id="activity">
     <i class="fa fa-cutlery"></i>活动管理
   </div>
   <div class="solve" id="sdbkMenu">
     <i class="fa fa-cog"></i>菜单管理 
   </div>
   <div class="solve" id="findcard">
     <i class="fa fa-credit-card" ></i>校园卡找回
   </div>
   <div class="solve" id="unbind">
     <i class="fa fa-chain-broken"></i>校园卡解绑 
   </div>
   <div class="solve" id="boardpush">
     <i class="fa fa-thumb-tack"></i>公文通提醒
   </div>
   <div class="solve" id="settings">
     <i class="fa fa-cogs"></i>设置
   </div>
</div>

</body>
 <script type="text/javascript">
jQuery(function () {
    $('#menu-trigger').on("click",function () {
		if($('#Rank').val()*1 < 5*1)
			$("#activity").hide();
        if ($('.dLeft').hasClass('mobile-menu-left')) {
            $('.dLeft').removeClass('mobile-menu-left');
            $('.head, .sild, .footer').removeClass('mobile-left');
        } else {
            
            $('.head, .sild, .footer').addClass('mobile-left');
            $('.dLeft').addClass('mobile-menu-left');
        }
    });
    $("#sdbkUser").on("click",function(){
      $(".sild").load("../dashboard/find_user",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('校园卡解绑');
      });
    });	
    $("#issue").on("click",function(){
      $(".sild").load("../dashboard/issue",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('事务');
      });
    });
    $("#issues").on("click",function(){
      $(".sild").load("../dashboard/issue",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('事务');
      });
    });
    $("#setting").on("click",function(){
      $(".sild").load("../dashboard/setting",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('设置');
      });
    });
    $("#settings").on("click",function(){
      $(".sild").load("../dashboard/setting",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('设置');
      });
    });
    $("#findcard").on("click",function(){
      $(".sild").load("../dashboard/add_card",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('校园卡找回');
      });
    });
    $("#activity").on("click",function(){
      $(".sild").load("../dashboard/add_activity",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('活动管理');
      });
    });
	$("#unbind").on("click",function(){
      $(".sild").load("../dashboard/find_user",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('校园卡解绑');
      });
    });
	$("#boardpush").on("click",function(){
      $(".sild").load("../dashboard/board_user",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('公文通提醒');
      });
    });
	$("#sdbkMenu").on("click",function(){
      $(".sild").load("../dashboard/menu",function(){
        $('.head, .sild').removeClass('mobile-left');
        $('.dLeft').removeClass('mobile-menu-left');
		$('#dashPart').html('菜单管理');
      });
    });   
});

</script>
</html>