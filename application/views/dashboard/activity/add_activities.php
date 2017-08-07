<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./../public/dashboard/activities.css">
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="../public/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
<script src="../public/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>

</head>
<body>
<div class="contain">
	<div class="left">
		<p class="inside im" id="addAct">添加活动</p>
		<p class="inside" id="adminAct">管理活动</p>
	</div>
	<div class="formatWrong" id="message"></div>
	<div class="right">
		<div class="rightlabel" id="result">
			<div class="item">
				<p class="lab">活动名称</p>
				<input type="text" id="name" name="name" class="txt" placeholder="中英文或下划线">
			</div>
			<div class="item">
				<p class="lab">开始时间</p>
				<input class="txt time" id="startTime" placeholder="请选择时间">
					
			</div>
			<div class="item">
				<p class="lab">结束时间</p>
				<input class="txt time" id="endTime" placeholder="请选择时间">
					
			</div>
			
			    <!-- <div class="item" >
					<p class="lab">开始时间</p>
			            <input type='text' class="txt time" id='datetimepicker4' placeholder="请选择时间">     
			    </div> -->

			<!-- <div class="item">
				<p class="lab">结束时间</p>
				<div class="txt time" id="endTime">
					请选择时间
				</div>
			</div> -->

			<div class="item">
				<p class="lab">限制人数</p>
				<input type="text" id="limit" name="limit" value="0" class="txt">
				<div class="inputTips">只能为数字，0表示不限制
				</div>
			</div>
			<div class="underline"></div>
			<div class="item ps">PS：默认会保存学生的所有信息</div>


			<div class="containMsg">
				<div class="addMsg" style="display: none;">
					<div class="item" >
						<p class="lab">字段<span class="number"></span></p>
						<input type="text" class="txt" id="parameters" placeholder="字段的名称，不可放空">
					</div>
					<div class="item" >
						<p class="lab del">删除</p>
						<input type="text" class="txt" id="value" placeholder="默认值，可放空">
					</div>
				</div>
			</div>


			<button class="addParam">添加字段</button>
			<div class="btn">
				<button id="submit" disabled="disabled">发布活动</button>
			</div>
		</div>

	</div>
</div>
</body>
<script type="text/javascript">
$(function(){
	var $addAct = $('#addAct');
	var $adminAct = $('#adminAct');
	var $addParam = $('.addParam');
	var $addMsgTpl = $('.addMsg');
	var $formatWrong=$('.formatWrong');
	var $message=window.document.getElementById("message");
	var k = 1;

	function showMsg(k){
		var addMsg = $addMsgTpl.clone();
		var num = addMsg.find('.number');
		addMsg.show();
		$('.containMsg').append(addMsg);
		num.text(k);	
	}

	$('.right').on('click', '.addParam', function(){
		showMsg(k);
		k++;
	});
	
	$('.right').on('click', '.del', function(){      //因为del是后来添加进去的，所以要用一个已经存在且一直存在的父辈right去绑定子辈del	
		var $del_msg = $(this).parent().parent();
		var $nextNum = $del_msg.nextAll('.addMsg').find('.number');
		var i = 0;
		$nextNum.each(function(){
			$(this).text($(this).html()*1-1*1);
			i = $(this).html();
		});
		k = i*1 + 1*1;
		$del_msg.remove();
	});

	$addAct.on('click',function(){
		$('.right').load('../dashboard/add_activity/add');
		$addAct.addClass('im');
		$adminAct.removeClass('im');
		k = 1;
	});
	$adminAct.on('click',function(){
		$('.right').load('../dashboard/activity');
		$adminAct.addClass('im');
		$addAct.removeClass('im');
    });


    //$startTime.datetimepicker({
	$('.right').on('focus', '#startTime', function(){    //这里日历的样式有点怪，顶部应该有个左右的箭头之类的，是不是css文件没对
		$(this).datetimepicker({
    	lang:'zh'
		});
    });
    //$endTime.datetimepicker({
	$('.right').on('focus', '#endTime', function(){
		$(this).datetimepicker({
    	language:'zh-CN'
		});
    });

	$(".right").on("focus change input", "#name,#startTime,#endTime,#limit", function(evt){    //button disabled 当全部输入不为空且limit为数字的时候移除disabled
	  var $submit=$('#submit');
	  if($.isNumeric($('#limit').val().trim()) && $('#name').val().trim().length != 0 && $('#startTime').val().trim().length != 0 && $('#endTime').val().trim().length != 0 && $('#limit').val().trim().length != 0){
		$submit.removeAttr("disabled");
	  }else{
		$submit.prop("disabled","disabled");
	  } 
	});
	
	$('.right').on('click', '#submit', function(){
		var name = $('#name').val();
		var startTime = $('#startTime').val();
		var endTime = $('#endTime').val();
		var limit = $('#limit').val();
		var param = new Array();
		var ajax = "ajax";
		var i = 0;
		$('.addMsg').each(function(){
			if($(this).attr('style') != "display: none;")
			{				
				param[i] = {name:$(this).find('#parameters').val(), value:$(this).find('#value').val()};
				i++;
			}
		});
		$.ajax({  
			type: "post",
			url: "../dashboard/add_activity/add",
			data:{
				name:name,
				startTime:startTime,
				endTime:endTime,
				limit:limit,
				parameters:param,
				ajax:ajax
			},
			async: false,
			success: function (data) {
				if(data == 1)
				{
					$message.innerHTML = '添加活动成功！';
					$formatWrong.css('background-color','rgb(68, 249, 68)');
					$('#addAct').trigger('click');
				}
				else if(data == 'time_error')
				{
					$message.innerHTML = '开始时间不能大于结束时间';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
				}
				else
				{
					$message.innerHTML = '添加活动失败！';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
				}
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			},  
			error: function () {  
				$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			}  
		});
	});
});

</script>
</html>