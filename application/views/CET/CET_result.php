<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link href="../public/css/common.min.css" rel="stylesheet">
    <title>四六级准考证查询 - 深大百科</title>
	<style>
		html,body{
			background: #f0f0f0;
		}
		header{
			background: rgb(33, 197, 242);
			color: #fffaff;
			width:100%;
			padding-top:20px;
			padding-left:20px;
			font-size:16px;
		}
		header h1{
			margin-top:0px;
			line-height:76px;
			font-size:30px;
			text-align:center;
			padding-bottom: 30px;
		}
		footer{
			text-align: center;
			color: #999;
			font-size: 12px;
			padding-top: 15px;
		}
	</style> 
</head>
<body> 
	<header>
		<p><b><?php echo $cet['studentName'] ?></b> 同学，</p>
		<p style="padding: 20px 20px">你的四级/六级准考证号为：</p>
		<h1><?php echo $cet['cetzkz'] ?></h1>

	</header>
	<footer>
		学生事务服务中心</br>官方微信 深大快讯</br>
		<img src="./public/images/shendakuaixun.jpg" height="90px" width="90px">
		</br>
		（长按二维码识别）
	</footer>

</body>
</html>