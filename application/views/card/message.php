<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8>
		<meta name=viewport content="width=device-width,initial-scale=1,user-scalable=no">
		<title>校园卡拾获详细信息 - 深大百科</title>
		<link href="./../../public/card/details.css" type='text/css' rel="stylesheet">
	</head>
	<body>
		<p class="para">详细信息</p>
		<div style="text-align: right; width:100%;">
		<table>
		<?php foreach($card as $row){?>
		<tr>
			<td class="text2"><span class="font1">卡号:</span></td>
			<td class="text1"><?php echo $row['studentNo'];?></td>
		</tr>
		<tr>
			<td class="text2"><span class="font1">姓名:</span></td>
			<td class="text1"><?php echo $row['studentName'];?></td>
		</tr>
		<tr>
			<td class="text2"><span class="font1">联系方式:</span></td>
			<td class="text1"><?php echo $row['cardphone'];?></td>
		</tr>
		<tr>
			<td class="text2"><span class="font1">拾获地点:</span></td>
			<td class="text1"><?php echo $row['cardplace'];?></td>
		</tr>
		<tr>
			<td class="text2"><span class="font1">备注:</span></td>
			<td class="text1"><?php echo $row['remark'];?></td>
		</tr>
		<?php }?>
		</table>
		</div>
	</body>