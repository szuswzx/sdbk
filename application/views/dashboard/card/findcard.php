<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="./../public/dashboard/findcard.css">
</head>
<body>
<div class="contain">
	<div class="left">
		<p class="inside im" id="inputmsg">录入校园卡</p>
		<p class="inside" id="confirmrtn">确认归还</p>
	</div>
	<div class="formatWrong" id="message"></div>
	<div class="right">
		<div class="rightlabel" id="result">
		<?php echo form_open('dashboard/add_card',array('id' => 'add_card')); ?>
			<div class="item"><p class="lab">学号</p><input type="text" id="studentNo" name="studentNo" class="txt" placeholder="201xxxxxxx">
			<div class="inputTips">10位校园卡号，只能为数字</div></div>
			<div class="item"><p class="lab">失主姓名</p><input type="text" name="studentName" class="txt"></div>
			<div class="item"><p class="lab">归还者姓名</p><input type="text" name="getName" class="txt"></div>
			<div class="item"><p class="lab">备注</p><textarea type="text" name="remark" class="txt" placeholder="在哪拾获，交接地点信息等" rows="10"></textarea></div>
			<input type="hidden" name="ajax" value="ajax">	    	
	    	</form>
    		<div class="btn" style="opacity: 0.5;"><button  id="submit" disabled="disabled" onclick="typein()">信息录入</button></div>
		</div>

	</div>
</div>
</body>
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript" src="./../public/dashboard/findcard.js"></script>
</html>