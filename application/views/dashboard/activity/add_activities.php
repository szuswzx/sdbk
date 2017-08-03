<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
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
	text-align: center;
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
.txt .startTime{
	background-color: lightgrey;

}
.txt .time:hover{
	background-color: red;
}
.underline{
	width: 100%;
	color: lightgrey;
	padding:0 20px; 
}
.addParam{
	width: 100%;
	height: 40px;
	margin-top: 5px;
	color: #aaa;
	font-size: 14px;
	line-height: 32px;
	border-radius: 3px;
	background: #fff;
	cursor: pointer;
	border: 2px dashed #ddd;
}
.btn{
	width: 100%;
	padding-left: 100px;
}
</style>

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
				<div class="txt time">
					请选择时间
				</div>
			</div>
			<div class="item">
				<p class="lab">结束时间</p>
				<div class="txt time">
					请选择时间
				</div>
			</div>
			<div class="item">
				<p class="lab">限制人数</p>
				<input type="text" id="studentNo" name="studentNo" class="txt">
				<div class="inputTips">只能为数字，0表示不限制
				</div>
			</div>
			<div class="underline"></div>
			<div class="item">PS：默认会保存学生的所有信息</div>
			<button class="addParam">添加字段</button>
			<div class="btn">
				<button disabled="disabled">发布活动</button>
			</div>
		</div>

	</div>
</div>
</body>
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
$(function(){
	var $addAct = $('#addAct');
	var $adminAct = $('#adminAct');

	$addAct.on('click',function(){
		$addAct.addClass('im');
		$adminAct.removeClass('im');
	});


	$adminAct.on('click',function(){
		$adminAct.addClass('im');
		$addAct.removeClass('im');
	})

})
</script>
</html>