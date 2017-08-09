<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8>
		<meta name=viewport content="width=device-width,initial-scale=1,user-scalable=no">
		<title>校园卡拾获上报 - 深大百科</title>
		<link href="./../public/card/pickup.css" type='text/css' rel="stylesheet">
	</head>
	<body>
		<p class="para">校园卡拾获上报</p>
		
		<form method="post" action="<?php echo site_url("add_card/add")?>">
		<table>
		<tr>
			<td class="text2"><font class="font1">卡号:</font></td>
			<td class="text1"><input class="input1" type="text" name="cardnumber" ></input></td>
		</tr>
		<tr>
			<td class="text2"><font class="font1">失主姓名:</font></td>
			<td class="text1"><input class="input1" type="text" name="cardowner"></input></td>
		</tr>
		<tr>
			<td class="text2"><font class="font1">拾取者姓名:</font></td>
			<td class="text1"><input class="input1" type="text" name="cardfinder"></input></td>
		</tr>
		<tr>
			<td class="text2"><font class="font1">联系方式:</font></td>
			<td class="text1"><input class="input1" type="text" name="cardphone" placeholder="请留下你的手机号或微信号"></input></td>
		</tr>
		<tr>
			<td class="text2"><font class="font1">拾获地点:</font></td>
			<td class="text1"><input class="input1" type="text" name="cardplace"></input></td>
		</tr>
		<tr>
			<td class="text2"><font class="font1">备注:</font></td>
			<td class="text1"><input class="input1" type="text" name="cardremark"></input></td>
		</tr>
		</table>
		<button class="button1" type="button" name="button1" onclick="this.form.submit()">提交</button>
		</form>
	</body>