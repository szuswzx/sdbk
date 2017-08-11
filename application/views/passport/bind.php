<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>深大百科通行证-深大百科</title>
<link href="http://sdkx.qiniudn.com/res/css/common.min.css" rel="stylesheet">
<link href="<?php echo base_url("public/passport/css/index.css");?>" rel="stylesheet">
</head>
<body>
<div class="mainContainer">
	<div class="title">
		<h1>深大百科通行证</h1>
	</div>
	<div class="headimg">
		<img src="<?php echo $userinfo['headimgurl'];?>">
	</div>
	<div class="nickname">
		<p>欢迎你，<?php echo $userinfo['nickname'];?></p>
	</div>
	<div class="loginBtn">
		<p>要使用深大百科功能，您<br />需要将您的校园卡和深大百科通行证进行绑定。<br /><font color="#F45757">请点击下面的按钮绑定校园卡。</font></p>
		<a href="https://auth.szu.edu.cn/cas.aspx/login?service=http://swzx.szu.edu.cn/sdbk" class="btn">点击绑定校园卡</a>
	</div>
	<div style="clear:both"></div>
</div>
</body>
</html>