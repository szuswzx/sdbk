<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<title></title>
<style type="text/css">
.left{
	padding:5px;
	margin-top: 20px;
	width: 15%;
	font-size: 20px;
	display: inline-block;
	float: left;
	height: 40px;
	border-right: 3px solid #408ec0;
	color: #408ec0;
	text-align: center;
}
.right{
	width: 50%;
    float: left;
    padding-left: 40px;
    padding-top: 30px;
    padding-right: 20px;
}
.lab{
	font-size: 15px;
	text-align: right;
	width: 20%;
	padding: 0px 10px;
	float: left;
	line-height: 36px;
}
.item{
	width: 100%;
	float: left;
	margin-top: 5px;
}
.txt{
	width: 76%;
	float: left;
	margin-left:10px;
	padding:5px;
	text-align: justify;
	font-size: 14px;
	border: 1px solid grey;
	border-radius: 3px;

}
.item>input:hover{
	border: 1px solid #408ec0;
}
.btn{
	width: 100%;
	float: left;
	margin:0 auto;
}
</style>
</head>
<body>
<div class="contain">
	<div class="left">
		<p>修改密码</p>
	</div>
	<div class="right">
	  <?php echo form_open('dashboard/setting'); ?>
		<div class="item"><p class="lab">原密码</p><input type="password" name="oldPwd" class="txt"></div>
		<div class="item"><p class="lab">新密码</p><input type="password" name="newPwd" class="txt"></div>
		<div class="item"><p class="lab">确认密码</p><input type="password" name="Pwd" class="txt"></div>
		<p><?php echo validation_errors(); ?></p>
		<div class="btn"><input  type="submit" value="修改密码" class=""/></div>
	</div>
</div>
</body>
<script type="text/javascript">
	// $("document").ready(function(){
	// 	$("input").click(function(){
	// 		$("input").css("border","1px solid red");
	// 	});
	// });
</script>
</html>