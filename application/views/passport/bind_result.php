<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>深大百科通行证-深大百科</title>
<link href="http://sdkx.qiniudn.com/res/css/common.min.css" rel="stylesheet">
<link href="//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url("public/passport/css/cas.css");?>" rel="stylesheet">
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
        <p>欢迎回来，<?php echo $userinfo['nickname'];?></p>
    </div>
    <div class="loginStatus">
        <?php
            if ($status == 1){
                echo '<p class="s"><i class="fa fa-check-square-o"> 校园卡绑定成功！</i><br />您可以关闭本页面，接下来事务中心提供的官方查询无需重复登录。</p>';
            } elseif ($status == 2) {
                echo '<p class="f"><i class="fa fa-exclamation-triangle"> 校园卡绑定失败</i><br />该校园卡已经绑定过微信账号了！</p>'; 
            } else {
                echo '<p class="f"><i class="fa fa-exclamation-triangle"> 校园卡绑定失败</i><br />可能是服务器错误，您可以关闭页面重新尝试登录。</p>'; 

 
            }
        ?>
    </div>
</div>
</body>
</html>