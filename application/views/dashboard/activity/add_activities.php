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
				<input type="text" id="studentNo" name="studentNo" class="txt" placeholder="中英文或下划线">
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
				<input type="text" id="studentNo" name="studentNo" class="txt">
				<div class="inputTips">只能为数字，0表示不限制
				</div>
			</div>
			<div class="underline"></div>
			<div class="item ps">PS：默认会保存学生的所有信息</div>


			<div class="containMsg">
				<div class="addMsg" style="display: none;">
					<div class="item" >
						<p class="lab">字段<span class="number"></span></p>
						<input type="text" class="txt" placeholder="字段的名称，不可放空">
					</div>
					<div class="item" >
						<p class="lab del">删除</p>
						<input type="text" class="txt" placeholder="默认值，可放空">
					</div>
				</div>
			</div>


			<button class="addParam">添加字段</button>
			<div class="btn">
				<button disabled="disabled">发布活动</button>
			</div>
		</div>

	</div>
</div>
</body>
<script type="text/javascript">
$(function(){
	var $addAct = $('#addAct');
	var $adminAct = $('#adminAct');
	var $startTime = $('#startTime');
	var $endTime = $('#endTime');
	var $addParam = $('.addParam');
	var $addMsgTpl = $('.addMsg');
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
		var i;
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


    $startTime.datetimepicker({
    	lang:'zh'
    });
    $endTime.datetimepicker({
    	language:'zh-CN'
    });

    
});

</script>
</html>