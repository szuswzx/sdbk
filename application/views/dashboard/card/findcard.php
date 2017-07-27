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
	text-align: center;
}
.inside{
	height: 30px;
	font-size: 15px;
	padding: 10px 20px;
}
.right{
	width: 60%;
    float: left;
    padding-left: 40px;
    padding-top: 30px;
    padding-right: 20px;
}
.lab{
	font-size: 15px;
	text-align: right;
	width: 18%;
	padding: 0px 10px;
	float: left;
	line-height: 36px;
}
.item{
	width: 100%;
	
	float: left;
	margin-top: 5px;
	margin-bottom: 10px;
}
.txt{
	width: 76%;
	float: left;
	margin-left:10px;
	padding:5px;
	text-align: justify;
	font-size: 14px;
	border: 1px solid lightgrey;
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
.im{
	border-right: 3px solid #408ec0;
	color: #408ec0;
}
.inputTips{
	float: right;
	color: #888;
	font-size: 14px;
	line-height: 20px;
	padding-right: 20px;

}
.forcon{
	border-right: 3px solid #408ec0;
	color: #408ec0;
}
</style>
</head>
<body>
<div class="contain">
	<div class="left">
		<p class="inside im" id="inputmsg">录入校园卡</p>
		<p class="inside" id="confirmrtn">确认归还</p>
	</div>
	<div class="right">
		<div class="item"><p class="lab">学号</p><input type="text" name="oldPwd" class="txt" placeholder="201xxxxxxx">
		<div class="inputTips">10位校园卡号，只能为数字</div></div>
		
		<div class="item"><p class="lab">失主姓名</p><input type="text" name="newPwd" class="txt"></div>
		<div class="item"><p class="lab">归还者姓名</p><input type="text" name="Pwd" class="txt"></div>
		<div class="btn"></div>
	</div>
</div>
</body>
<script type="text/javascript">
$("document").ready(function(){
	$("#confirmrtn").click(function(){
		$(".right").load("confirmrtn.php");
		$("#inputmsg").removeClass("im");
		$("#confirmrtn").addClass("forcon");
	});
	$("#inputmsg").click(function(){
		$(".contain").load("findcard.php");
	});
});
</script>
</html>