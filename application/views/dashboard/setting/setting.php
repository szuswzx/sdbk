<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="./../public/dashboard/settingCSS.css">
</head>
<body>
<div class="contain">
	<div class="left">
		<p class="inside im" id="changePass">修改密码</p>
		<p class="inside" id="addAdmin">添加学生</p>
		<p class="inside" id="manageAdmin">管理学生</p>
		<p class="inside" id="Log">日志中心</p>
	</div>
	<div class="formatWrong" id="message"></div>
	<div class="right">
		<div class="rightlabel" id="result">
			<?php echo form_open('dashboard/setting',array('id' => 'change_pass')); ?>
			<div class="item"><p class="lab">原密码</p><input type="password" id="oldPwd" name="oldPwd" class="txt"></div>
			<div class="item"><p class="lab">新密码</p><input type="password" id="newPwd" name="newPwd" class="txt"></div>
			<div class="item"><p class="lab">确认密码</p><input type="password" id="Pwd" name="Pwd" class="txt"></div>
			<input type="hidden" name="ajax" value="ajax">	    	
	    	</form>
    		<div class="btn"><button  id="submit" disabled="disabled" onclick="change_password()">修改密码</button></div>
		</div>
	</div>
</div>
</body>
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript" src="./../public/dashboard/settingJS.js"></script>
</html>