<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style type="text/css">



.right{
	width: 84%;
    float: left;
    padding-left: 40px;
    padding-top: 30px;
    padding-right: 20px;
}
table{
	width: 100%;

}
tr{
	height: 40px;
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
.input{
	float: right;
	border:1px solid lightgrey;
	margin-left: 10px;
	margin-bottom: 10px;
}
</style>
</script>
</head>
<body>


	<div class="right">
		<button type="submit" class="input" id="">搜索</button>
		<input type="input" class="input"  placeholder="id、名称、内容、用户" />
		<table>
			<tr style="background-color: rgba(199, 189, 189, 0.16)">
				<td>序号</td>
				<td>标题</td>
				<td>咨询人</td>
				<td>操作</td>
			</tr>
			<tr>
				<td>这里是已回复</td>
				<td>哈哈哈</td>
				<td>呜呜呜</td>
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


</html>