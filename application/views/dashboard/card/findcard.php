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
	width: 12%;
	font-size: 20px;
	display: inline-block;
	float: left;
	height: 40px;
	text-align: center;
	margin-left: 20px;
}
.inside{
	height: 30px;
	font-size: 15px;
	padding: 10px 20px;
	cursor: pointer;
}
.right{
	width: 84%;
    float: left;
    padding-left: 40px;
    padding-top: 30px;
    padding-right: 20px;
}
.rightlabel{
	width: 68%;
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

.formatWrong{
	width: 84%;
	height:40px;
	border-radius: 5px;
	text-align: center;
	color: white;
	font-size: 18px;
	float: left;
	display: none;
	line-height: 40px;

}
button[disabled]{
	cursor: not-allowed;
	opacity: 50%;
}
</style>
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
    		<div class="btn"><button  id="submit" disabled="disabled" onclick="typein()">信息录入</button></div>
		</div>

	</div>
</div>
</body>
<script type="text/javascript">
$("document").ready(function(){
	var $inputmsg=$('#inputmsg');
	var $confirmrtn=$('#confirmrtn');
	var $studentNo=$('#studentNo');
	var $submit=$('#submit');
	
	$confirmrtn.click(function(){
		$(".right").load("../dashboard/card");
		$inputmsg.removeClass("im");
		$confirmrtn.addClass("forcon");
	});
	$(".right").on("input", '#studentNo', function(evt){
	  var $submit=$('#submit');
	  if($(this).val().trim().length == 10){
		$submit.removeAttr("disabled");
	  }else{
		$submit.prop("disabled","disabled");
	  }
	});
	$(".right").on("click", "table button", function(evt){
		var $formatWrong=$('.formatWrong');
		var $form=$('#add_card');
		var $message=window.document.getElementById("message");		
		var id = $(this).attr("id");
		
		$.ajax({
			type: "POST",  
			url:'../dashboard/return_card/'+id,  
			async: false,  //同步等待结果执行返回
			error: function(request) {
				$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			},  
			success: function(data) {
				if(data == 0)
				{
					$message.innerHTML = '归还记录修改失败！';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
				}
				else if(data == 1)
				{
					$message.innerHTML = '归还记录修改成功！';
					$formatWrong.css('background-color','rgb(68, 249, 68)');
				}
				else
				{
					$message.innerHTML = '归还记录修改成功，归还提醒推送发送失败！';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
				}
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
				$(".right").load("../dashboard/card");
				$inputmsg.removeClass("im");
				$confirmrtn.addClass("forcon");
			}  
		});
	});
	$(".right").on("click", "#search", function(evt){
		var searchContent = $("#searchContent").val();
		$(".right").load("../dashboard/search_card", {keyword: searchContent},function(){
			$("#searchContent").val(searchContent);
		});		
	});
	$(".right").on("click", "a", function(evt){
		var uri = $("#uri").val();
		var page = $(this)[0].innerHTML;
		var searchContent = $("#searchContent").val();
		$(".right").load("../"+uri, {page:page,keyword: searchContent},function(){
			$("#searchContent").val(searchContent);
		});
	});
	$inputmsg.click(function(){
		$inputmsg.addClass("im");
		$confirmrtn.removeClass("forcon");
		$(".right").load("../dashboard/add_card/add");
	});

});
function typein(){
	var $formatWrong=$('.formatWrong');
	var $form=$('#add_card');
	var $message=window.document.getElementById("message");
	
	$.ajax({  
		type: "POST",  
		url:'../dashboard/add_card',  
		data:$('#add_card').serialize(),
		async: false,  //同步等待结果执行返回
		error: function(request) {
			$message.innerHTML = '服务器异常';
			$formatWrong.css('background-color','rgb(224, 68, 68)');
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
		},  
		success: function(data) {			
			if(data == 0)
			{
				$message.innerHTML = '添加校园卡丢失记录失败！';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
			}
			else if(data == 1)
			{
				$message.innerHTML = '添加校园卡丢失记录成功！';
				$formatWrong.css('background-color','rgb(68, 249, 68)');
				$form[0].reset();
			}
			else
			{
				$message.innerHTML = '添加校园卡丢失记录成功，丢卡提醒推送发送失败！';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$form[0].reset();
			}
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
		}  
	});
}
</script>
</html>