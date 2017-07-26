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
	width: 15%;
	font-size: 20px;
	display: inline-block;
	float: left;
	height: 40px;
	text-align: center;
}
.inside{
	height: 30px;
	font-size: 15px;
	padding: 10px 20px;
}
.right{
	width: 50%;
    float: left;
    padding-left: 40px;
    padding-top: 30px;
    padding-right: 20px;
}
.lab{
	font-size: 15px;
	text-align: right;
	width: 20%;
	padding: 0px 10px;
	float: left;
	line-height: 36px;
}
.right{
	width: 84%;
    float: left;
    padding-left: 40px;
    padding-top: 30px;
    padding-right: 20px;
}

table{
	width: 100%;
	border:1px solid lightgrey;
}
tr{
	height: 40px;

	border-bottom: 1px solid lightgrey;
}
td{
	width: 20%;	
	border-right: 1px solid lightgrey;
}
#inputmsg{
	color: black;
	border: 1px solid white;
}
#confirmrtn{
	border-right: 3px solid #408ec0;
	color: #408ec0;
}
.input{
	float: right;
	border:1px solid lightgrey;
	margin-left: 10px;
	margin-bottom: 10px;
}
.page{
	text-align: center;
	height: 40px;
	margin-top: 40px;
	border-radius: 4px;
	
}
.page a,.page span{
	text-decoration: none;
	border: 1px solid lightgrey;
	padding: 5px 7px;
	color: #333;
	cursor: pointer;
}
.page a:hover,.page span:hover{
	background-color: #daa;
}
</style>
</head>
<body>
<div class="contain">
	<div class="left">
		<p class="inside" id="inputmsg">录入校园卡</p>
		<p class="inside" id="confirmrtn">确认归还</p>
	</div>
	<div class="right">
		<button type="submit" class="input" id="">搜索</button>
		<input type="input" class="input"  placeholder="id、名称、内容、用户" />
		<table>
			<tr style="background-color: lightgrey">
				<td>序号</td>
				<td>学号</td>
				<td>失主</td>
				<td>归还者</td>
				<td>操作</td>
			</tr>
			<tr>
				<td>222</td>
				<td>哈哈哈</td>
				<td>呜呜呜</td>
				<td>操作</td>
				<td>操作</td>
			</tr>
		</table>
		<div class="page">
			<span>上一页</span>
			<a href="#">1</a>
			<a href="#">2</a>
			<a href="#">3</a>
			<span>下一页</span>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
$("document").ready(function(){
	$("#inputmsg").click(function(){
		$(".contain").load("findcard.php");
	});
});
	// $("document").ready(function(){
	// 	$("input").click(function(){
	// 		$("input").css("border","1px solid red");
	// 	});
	// });
</script>
</html>