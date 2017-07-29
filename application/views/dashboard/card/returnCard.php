<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<style type="text/css">
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
	padding-left: 100px;
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
	padding-right: 35px;
}
.forcon{
	border-right: 3px solid #408ec0;
	color: #408ec0;
}
</style>
</head>
<body>
<div class="right" id="result">
	<?php echo form_open('dashboard/add_card',array('id' => 'add_card')); ?>
		<div class="item"><p class="lab">学号</p><input type="text" name="studentNo" class="txt" placeholder="201xxxxxxx">
		<div class="inputTips">10位校园卡号，只能为数字</div></div>
		
		<div class="item"><p class="lab">失主姓名</p><input type="text" name="studentName" class="txt"></div>
		<div class="item"><p class="lab">归还者姓名</p><input type="text" name="getName" class="txt"></div>
		<div class="item"><p class="lab">备注</p><textarea type="text" name="remark" class="txt" placeholder="在哪拾获，交接地点信息等" rows="10"></textarea></div>
		<input type="hidden" name="ajax" value="ajax">
	    <p id="message"></p>
    	<div class="btn"><button  id="submit">信息录入</button></div>
	</div>
</div>
</body>