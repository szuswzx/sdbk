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
.message{
	height: 40px;
}
.formatWrong{
	width: 84%;
	height: 70px;
	border-radius: 5px;
	display: flex;
	justify-content: center;
	align-items: center;
	background-color: rgb(224, 68, 68);
	color: white;
	font-size: 18px;
	display: none;
	float: left;

}
.btn[disabled]{
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
	<div class="formatWrong">请务必输入十位数字</div>
	<div class="right">
		<div class="rightlabel" id="result">
		<?php echo form_open('dashboard/add_card',array('id' => 'add_card')); ?>
			<div class="item"><p class="lab">学号</p><input type="text" id="studentNo" name="studentNo" class="txt" placeholder="201xxxxxxx">
			<div class="inputTips">10位校园卡号，只能为数字</div></div>
			<div class="item"><p class="lab">失主姓名</p><input type="text" name="studentName" class="txt"></div>
			<div class="item"><p class="lab">归还者姓名</p><input type="text" name="getName" class="txt"></div>
			<div class="item"><p class="lab">备注</p><textarea type="text" name="remark" class="txt" placeholder="在哪拾获，交接地点信息等" rows="10"></textarea></div>
			<input type="hidden" name="ajax" value="ajax">
	    	<div id="message"></div >
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
	var stuNo=$studentNo.val();
	var $formatWrong=$('.formatWrong');
	var $submit=$('#submit');
	$confirmrtn.click(function(){
            /*var url = '../dashboard/card/all/data';  
            $.post(url,function(result){  
                $('#result').replaceWith(result);  
            })	*/		
		
		$(".right").load("../dashboard/card");
		$inputmsg.removeClass("im");
		$confirmrtn.addClass("forcon");
	});
	if(stuNo.length!==0||stuNo.length!=null){
			$submit.removeAttr("disabled");	
	}
	function typein(){
		if($submit.hasAttr('disabled')=='disabled'){
			return false;	
		}
		if(stuNo.length()!==10){
			$formatWrong.show('',function(){
				$formatWrong.hide(3000);		
			});
		}
		$.ajax({  
			type: "POST",  
			url:'../dashboard/add_card',  
			data:$('#add_card').serialize(),
			async: false,  //同步等待结果执行返回
			error: function(request) {
				alert("Connection error");  //提示服务器异常
			},  
			success: function(data) {
				//console.log(data);
				 var tbody=window.document.getElementById("message");
				 var str = "";
				// str += data;
				 //tbody.innerHTML = str;
                 //alert(data);			 
				//接收后台返回的结果,应该输出错误提示或者成功提示，同时清空表单，我还没清空表单哦
			}  
        });
	}
	$inputmsg.click(function(){
		$inputmsg.addClass("im");
		$confirmrtn.removeClass("forcon");
		$(".right").load("../dashboard/add_card/add");
	});

});
</script>
</html>