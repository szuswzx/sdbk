<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<title></title>
<style type="text/css">
.inside{
	height: 30px;
	font-size: 15px;
	padding: 10px 20px;
}
.rightcon{
	width: 100%;
    float: left;
    padding-left: 20px;
    padding-right: 20px;
}
table{
	width: 100%;
	text-align: center;
}
tr{
	height: 45px;	
}
td{
	border-right: 1px solid white;
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
	<div class="rightcon">
		<button type="submit" class="input" id="">搜索</button>
		<input type="input" class="input"  placeholder="id、名称、内容、用户" />
		<table>
			<tr style="background-color: rgba(199, 189, 189, 0.16)">
				<td style="width: 10%">序号</td>
				<td style="width: 15%">学号</td>
				<td style="width: 10%">失主</td>
				<td style="width: 30%">归还者</td>
				<td style="width: 25%">操作</td>
			</tr>
			<?php foreach($card as $row){?>
			<tr>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['studentNo'];?></td>
				<td><?php echo $row['studentName'];?></td>
				<td><?php echo $row['getName'];?></td>
				<td><?php 
						if($row['isReturn'] == '0')
							 echo "<button style='background-color:pink' id=".$row['id']." >确认归还</button>";
					?>
				</td>
			</tr>
			<?php }?> 
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