<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
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
<script type="text/javascript">
$("document").ready(function(){
	var $changePass=$('#changePass');
	var $addAdmin=$('#addAdmin');
	var $manageAdmin=$('#manageAdmin');
	var $Log=$('#Log');
	
	$addAdmin.click(function(){
		$(".right").load("../dashboard/add_admin");
		$changePass.removeClass("im");
		$manageAdmin.removeClass("im");
		$Log.removeClass("im");
		$addAdmin.addClass("im");
	});
	$changePass.click(function(){
		$changePass.addClass("im");
		$addAdmin.removeClass("im");
		$Log.removeClass("im");
		$manageAdmin.removeClass("im");
		$(".right").load("../dashboard/setting/changePass");
	});   
	$manageAdmin.click(function(){
		$manageAdmin.addClass("im");
		$addAdmin.removeClass("im");
		$changePass.removeClass("im");
		$Log.removeClass("im");
		$(".right").load("../dashboard/get_all_admin");
	});
	$Log.click(function(){
		$Log.addClass("im");
		$manageAdmin.removeClass("im");
		$changePass.removeClass("im");
		$addAdmin.removeClass("im");
		$(".right").load("...");
	});
	//看这里！！，有4个左侧栏，我只做了两个，你完善下，一个管理学生url是"../dashboard/setting/changePass",显示的页面写在manage_admin.php里面，
	//就是一个单纯的表格，输出学生，详情看localhost/dashboard
	
	$(".right").on("input", "#oldPwd,#newPwd,#Pwd", function(evt){    //button disabled	  
	  var $submit=$('#submit');
	  if($('#oldPwd').val().trim().length != 0 && $('#newPwd').val().trim().length != 0 && $('#Pwd').val().trim().length != 0){
		$submit.removeAttr("disabled");
	  }else{
		$submit.prop("disabled","disabled");
	  } 
	});
	$(".right").on("input", "#username,#password,#rank", function(evt){    //button disabled	  
	  var $submit=$('#submit');
	  if($('#username').val().trim().length != 0 && $('#password').val().trim().length != 0 && $('#rank').val().trim().length != 0){
		$submit.removeAttr("disabled");
	  }else{
		$submit.prop("disabled","disabled");
	  } 
	});	
});
function change_password(){
	var $form=$('#change_pass');
	var $formatWrong=$('.formatWrong');
	var $message=window.document.getElementById("message");
	
	$.ajax({  
		type: "POST",
		url: '../dashboard/setting',  
		data: $form.serialize(),
		async: false,  //同步等待结果执行返回
		error: function(request) {
			$message.innerHTML = '服务器异常';
			$formatWrong.css('background-color','rgb(224, 68, 68)');
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
		},  
		success: function(data) {
			if(data == 'failed')
			{
				$message.innerHTML = '修改密码失败！';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$form[0].reset();
			}
			else if(data == 'success')
			{
				$message.innerHTML = '修改密码成功！';
				$formatWrong.css('background-color','rgb(68, 249, 68)');
				$form[0].reset();
			}
			else
			{
				$message.innerHTML = data;
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$form[0].reset();
			}
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
			$('#changePass').trigger('click');
		}  
	});
}
function add_admin(){
	var $form=$('#add_admin');
	var $formatWrong=$('.formatWrong');
	var $message=window.document.getElementById("message");
	
	$.ajax({  
		type: "POST",
		url: '../dashboard/add_admin',  
		data: $form.serialize(),
		async: false,  //同步等待结果执行返回
		error: function(request) {
			$message.innerHTML = '服务器异常';
			$formatWrong.css('background-color','rgb(224, 68, 68)');
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
		},  
		success: function(data) {
			if(data == 'failed')
			{
				$message.innerHTML = '添加管理员失败！';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$form[0].reset();
			}
			else if(data == 'success')
			{
				$message.innerHTML = '添加管理员成功！';
				$formatWrong.css('background-color','rgb(68, 249, 68)');
				$form[0].reset();
			}
			else
			{
				$message.innerHTML = data;
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$form[0].reset();
			}
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
			$('#addAdmin').trigger('click');
		}  
	});
}
</script>
</html>