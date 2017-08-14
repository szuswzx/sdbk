<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">

<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="./../public/dashboard/unbind_user.css">
</head>
<body>

<div class="contain">
	<div class="left">
		<p class="inside im" id="">校园卡解绑</p>
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
<script type="text/javascript" src="./../public/dashboard/unbind_user.js"></script>
</html>