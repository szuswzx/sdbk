$("document").ready(function(){
	var $changePass=$('#changePass');
	var $addAdmin=$('#addAdmin');
	var $manageAdmin=$('#manageAdmin');
	var $Log=$('#Log');
	var $formatWrong=$('.formatWrong');
	var $message=window.document.getElementById("message");
	
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
		$(".right").load("../dashboard/dashboard_log");
	});
	
	$(".right").on("input", "#oldPwd,#newPwd,#Pwd", function(evt){    //button disabled	for changepass
	  var $submit=$('#submit');
	  if($('#oldPwd').val().trim().length != 0 && $('#newPwd').val().trim().length != 0 && $('#Pwd').val().trim().length != 0){
		$submit.removeAttr("disabled");
	  }else{
		$submit.prop("disabled","disabled");
	  } 
	});
	$(".right").on("input", "#username,#password,#rank", function(evt){    //button disabled for add admin  
	  var $submit=$('#submit');
	  if($('#username').val().trim().length != 0 && $('#password').val().trim().length != 0 && $('#rank').val().trim().length != 0){
		$submit.removeAttr("disabled");
	  }else{
		$submit.prop("disabled","disabled");
	  } 
	});
	
	$(".right").on("click", ".resetBtn", function(){
		var uid = $(this).attr("id");
		var r = confirm("确定要重置编号为" + uid + "的管理员密码吗？")
		if (r==true)
		{
			$.ajax({
				type: "POST",
				url:'../dashboard/reset_password/'+uid,
				async: false,  //同步等待结果执行返回
				error: function(request) {
					$message.innerHTML = '服务器异常';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				},  
				success: function(data) {
					$(window).scrollTop(0);
					if(data == 1)
					{
						$message.innerHTML = '重置密码成功！';
						$formatWrong.css('background-color','rgb(68, 249, 68)');
					}
					else if(data == 0)
					{
						$message.innerHTML = '重置密码失败！';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
					}
					else
					{
						$message.innerHTML = data;
						$formatWrong.css('background-color','rgb(224, 68, 68)');
					}
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				}  
			});
		}
		else
		{
		}		
	});
	
	$(".right").on("click", ".delBtn", function(){
		var uid = $(this).attr("id");
		var r = confirm("确定要删除编号为" + uid + "的管理员吗？")
		if (r==true)
		{
			$.ajax({
				type: "POST",
				url:'../dashboard/delete_admin/'+uid,
				async: false,  //同步等待结果执行返回
				error: function(request) {
					$message.innerHTML = '服务器异常';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				},  
				success: function(data) {
					$(window).scrollTop(0);
					if(data == 1)
					{
						$message.innerHTML = '删除管理员成功！';
						$formatWrong.css('background-color','rgb(68, 249, 68)');
					}
					else if(data == 0)
					{
						$message.innerHTML = '删除管理员失败！';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
					}
					else
					{
						$message.innerHTML = data;
						$formatWrong.css('background-color','rgb(224, 68, 68)');
					}
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				},
                complete: function(msg) {
					$manageAdmin.trigger("click");
				}				
			});
		}
		else
		{
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
			}
			else if(data == 'success')
			{
				$message.innerHTML = '修改密码成功！';
				$formatWrong.css('background-color','rgb(68, 249, 68)');
			}
			else
			{
				$message.innerHTML = data;
				$formatWrong.css('background-color','rgb(224, 68, 68)');
			}
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
		},
        complete: function(msg) {
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
			}
			else if(data == 'success')
			{
				$message.innerHTML = '添加管理员成功！';
				$formatWrong.css('background-color','rgb(68, 249, 68)');
			}
			else
			{
				$message.innerHTML = data;
				$formatWrong.css('background-color','rgb(224, 68, 68)');
			}
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
		},
        complete: function(msg) {
			$('#addAdmin').trigger('click');
		}  
	});
}