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
<div class="editMask">
	<div class="edit">
		<div class="editTitle">
			回复事务<span class="close"><i class="fa fa-times-circle"></i></span>
		</div>
		<div class="editBody">
			<div class="item">
				<div class="editleft">活动名称</div>
				<div class="editright"><input id="actName" type="text"></div>
			</div>
			<div class="item">
				<div class="editleft">活动时间</div>
				<div class="editright"><input id="actTime" type="text" placeholder="活动举办时间"></div>
			</div>
			<div class="item">
				<div class="editleft">活动地点</div>
				<div class="editright"><input id="actSpace" type="text" placeholder="活动举办地点"></div>
			</div>
			<div class="item">
				<div class="editleft">备注</div>
				<div class="editright"><input id="remark" type="text" placeholder="模板消息推送中的备注"></div>
			</div>
			<div class="item">
				<div class="editleft">选中学生</div>
				<div class="editright"><textarea id="student" type="text" placeholder="选中的学生的学号，多个学生用英文的逗号分隔开，如：2014150001,2014150002（全部选中请填写为英文小写的all）"></textarea></div>
			</div>			
			<div class="item">
				<input type="hidden" id="actId">
				<div class="replayBtn"><button class="submitReply">发送</button><span class="cancel">取消</span></div>
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
		$('.btn').css('opacity','1');
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

	var $editMask=$('.editMask');
	var $content=$('.edit');
	var $close=$('.fa');

	$('.right').on('click','.sendMsg',function(evt){              //tbody也是后来在加载进来的，所以要用right，right是一直都在的
	    var id = $(this).parent().parent().find('#ID').html();
		var name = $(this).parent().parent().find('#NAME').html();
		$('#actName').val(name);
		$('#actId').val(id);
		$editMask.fadeIn('slow');
		$content.fadeIn('slow');
		evt.preventDefault();
	});
	
	$('.submitReply').on('click',function(){  //push activity
		var actName = $('#actName').val();
		var actTime = $('#actTime').val();
		var actSpace = $('#actSpace').val();
		var remark = $('#remark').val();
		var student = $('#student').val();
		var id = $('#actId').val();

		$.ajax({  
			type: "post",
			url: "../dashboard/push_activity/"+id,
			data:{
				keyword1:actName,
				keyword2:actTime,
				keyword3:actSpace,
				remark:remark,
				markstu:student
			},
			async: true,
			beforeSend: function (){
				$('#actName').val("");
				$('#actTime').val("");
				$('#actSpace').val("");
				$('#remark').val("");
				$('#student').val("");
				$('#actId').val("");
				$(window).scrollTop(0);
				$content.css('display','none');
		        $editMask.css('display','none');
				$message.innerHTML = '模板消息正在发送，请耐心等候，请留意结果反馈！';
				$formatWrong.css('background-color','rgb(68, 249, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			},
			error: function () {
				$(window).scrollTop(0);				
				$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			}  
		});
	});

	$close.click(function(){
		$content.css('display','none');
		$editMask.css('display','none');
	});	
	$('.cancel').click(function(){
		$content.css('display','none');
		$editMask.css('display','none');
	});
	
	$('.right').on('click','.export',function(evt){   //export activity_record data
		var id = $(this).parent().parent().find('#ID').html();
		window.location.href="../dashboard/export_activity/"+id;
	});
	
	$('.right').on('click','.delAct',function(evt){   //del activity
	    var id = $(this).parent().parent().find('#ID').html();
		var r = confirm("确定要删除编号为" + id + "的活动吗？")
		if (r==true)
		{
			$.ajax({  
				type: "post",
				url: "../dashboard/delete_activity/"+id,
				async: false,
				success: function (data){
					$(window).scrollTop(0);
					if(data == 1)
					{
						$message.innerHTML = '活动删除成功！';
						$formatWrong.css('background-color','rgb(68, 249, 68)');
					}
					else
					{
						$message.innerHTML = '活动删除失败！';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
					}
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
					$adminAct.trigger('click');
				},
				error: function () { 
					$(window).scrollTop(0);
					$message.innerHTML = '服务器异常';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				}  
			});
		}
		else
		{}
	});

});

</script>
</html>