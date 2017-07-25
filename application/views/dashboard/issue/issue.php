<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
	$.ajax([cache:false;])
</script>

<style type="text/css">

.left{
	padding-top: 25px;
	width: 15%;
	display: inline-block;
	float: left;
}
.inside{
	height: 30px;
	font-size: 15px;
	padding: 10px 20px;
}
#all{
	color: #408ec0;
	border-right: 3px solid #408ec0;
}
.right{
	width: 84%;
    float: left;
    padding-left: 40px;
    padding-top: 30px;
    padding-right: 20px;
}
.input{
	float: right;
	border:1px solid lightgrey;
	margin-left: 10px;
	margin-bottom: 10px;
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
	width: 25%;	
	border-right: 1px solid lightgrey;
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
</script>
</head>
<body>

<div class="contain">
	<div class="left">
		<p class="inside" id="all">全部事务</p>
		<p class="inside" id="notyet">未回复事务</p>
		<p class="inside" id="finish">已回复事务</p>
	</div>
	<div class="right">
	<button type="submit" class="input" id="">搜索</button>
	<input type="input" class="input"  placeholder="id、名称、内容、用户" />
		<table>
			<tr style="background-color: lightgrey">
				<td>序号</td>
				<td>标题</td>
				<td>咨询人</td>
				<td>操作</td>
			</tr>
			
			 <?php foreach($issue as $row){?>
			<tr>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['title'];?></td>
				<td><?php echo $row['user'];?></td>
				<td>删除</td>
			</tr>
			<?php }?> 
		</table>
		<div class="page">
			<span>上一页</span>
			<a href="#">1</a>
			<a href="http://localhost/sdbk/dashboard/issue/2">2</a>
			<a href="#">3</a>
			<a href="#"><?php echo $page_sum;?></a>
			<span>下一页</span>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
	$("document").ready(function(){
		$("#notyet").on("click",function(){
			$(".contain").load("notyetIssues.php");
		});
		$("#finish").on("click",function(){
			$(".contain").load("finished.php");
		});
	});
</script>

</html>