<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.box{
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: #f8f8f8;
		}
		.success{
			position: absolute;
			top: 50%;
			left: 50%;
			width: 100%;
			height: 80px;
			margin-top: -40px;
			margin-left: -50%;
			text-align: center;
			font-size: 20px;
		}
		button{
			width: 80px;
			border-radius: 5px;
			background-color: rgba(99, 192, 234, 0.85);
			height: 30px;
			line-height: 30px;
			margin: 10px;
		}
	</style>
</head>
<body>
<div class="box">
	<div class="success">
		<div>提交成功</div>
		<a href="<?php echo base_url('card/index');?>"><button>返回</button></a>
	</div>
	<div class="fail">
		<div>提交失败，请重新提交</div>
		<a href=""><button>返回</button></a>
	</div>
</div>
</body>
</html>