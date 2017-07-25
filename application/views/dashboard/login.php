<!DOCTYPE html>
<html>
<head>
<title>控制台-深大百科</title>
<meta charset="utf-8">
<style type="text/css">
.wrap{
	height: 320px;
	width: 300px;
	background-color: #fff;
	position: absolute;
	top: 50%;
	left: 50%;
	margin-left: -150px;
	margin-top: -160px;
	padding:10px 20px;
	border-radius: 5px;
	box-shadow: 0 3px 5px rgba(0,0,0,.2);
}
.headtitle{
	color: #555;
	line-height: 60px;
	text-align: center;
}
/*.inputname{
	width: 100%;
	padding: 10px;
	height: 65px;

}
.input{
	width: 100%;
	height: 40px;
	padding: 10px 0;
	font-size: 16px;
	line-height: 20px;
	color: #333;
	border-bottom: 1px solid #ddd;

}
.forinput{
	position: relative;
	width: 100%;
	height: 2px;
	margin-top: -2px;
	background-color: #408ec0;

}
.lable{
	position: relative;
	top: -30px;
	color: #bbb;
	font-size: 16px;
	pointer-events: none;
	display: block;
}*/
.btn{
	width: 100%;
	padding: 10px;
	margin:10px 0;
	height: 56px;
	overflow: hidden;
}
button{
	width: 100%;
	height: 36px;
	border-radius: 20px;
	font-size: 15px;
	color: #fff;
	line-height: 36px;
	background-color: #408ec0;
	overflow: hidden;
}
.inputname{
	height: 50px;
	padding: 10px;
}
.input{
	width: 100%;
	border: 1px solid white;
	height: 40px;
	line-height: 10px;
	font-size: 16px;

}
.under{
	border-bottom: 1px solid lightgrey;
	width: 100%;
}
</style>
</head>
<body>

 <div class="wrap">
	<h1 class="headtitle">深大百科</h1>
	<?php echo form_open('dashboard/index'); ?>
	<div class="inputname">
		<input class="input" type="input" name="username" placeholder="用户名" />
		<div class="under"></div>
	</div>
	<div class="inputname">
		<input class="input" type="password" name="password" placeholder="密码" />
		<div class="under"></div>
	<p><?php echo validation_errors(); ?></p>
	<div class="btn" id="">
		<button type="submit">登录</button>
	</div>
	</form>
 </div>

</body>
</html>