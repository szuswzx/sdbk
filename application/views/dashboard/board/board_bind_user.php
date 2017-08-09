<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">

<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="./../public/dashboard/findcard.css"><!-- 这里我只是临时用下这个css，到时候去掉 -->
<style type="text/css">
table{
	width: 90%;
	margin:0 auto;
	padding-top: 30px;
	text-align: center;
}
tr{
	height: 40px;
	border-bottom: 2px solid white;
}
tr:hover{
	background-color: rgba(224, 212, 212, 0.17);
}
td{
	border-right: 1px solid white;
}
</style>
</head>
<body>

<div class="contain">
	<div class="left">
		<p class="inside im" id="all">公文通提醒</p>
	</div>
	<div class="formatWrong" id="message"></div>
	<div class="right">
		<button type="submit" class="input" id="search">搜索</button>
		<input type="input" class="input" id="searchContent" placeholder="学号" />
		<table>
			<tr style="background-color: rgba(199, 189, 189, 0.16)">
				<td style="width: 12%;">ID</td>
				<td style="max-width:18%;">学号</td>
				<td style="width: 20%;">姓名</td>
				<td style="width: 20%;">卡号</td>
				<td colspan="2" style="width: 20%;">操作</td>
			</tr>
			<tbody id="result"> 
				 
			</tbody>
		</table>
	</div>
</div>
</body>
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
jQuery(function () {
});

</script>
</html>