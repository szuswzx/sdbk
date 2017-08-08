<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8>
		<base href="<?php  echo base_url();?>"/> 
		<meta name=viewport content="width=device-width,initial-scale=1,user-scalable=no">
		<title>校园卡丢失查询 - 深大百科</title>
		<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
		<link rel="stylesheet" type='text/css' href="./public/card/search.css">
	</head>
	<body>
		<p class="pStyle">
			校园卡丢失查询
		</p>
		<div class="sStyle">
			<form method="post" action="<?php echo site_url("card/search_card")?>">
				<input class="searchbar" type="text" name="keyword" placeholder="请输入你的学号"></input>
				<input class="searchbtn" type="submit" value="搜索"></input>
			</form>
		</div>
		<div class="rStyle">
			<span class="para1">捡到校园卡的请戳这里-----> </span>
			<a href="<?php echo site_url('card/add_card');?>" class="para2">拾获校园卡登记</a>
		</div>

		<table>
			<tr>
				<td>时间</td>
				<td>卡号</td>
				<td>详情</td>
			</tr>
			<?php foreach($card as $row){?>
			<tr>
				<td><?php echo $row['time'];?></td>
				<td><?php echo $row['studentNo'];?></td>
				<td><a href="<?php echo site_url('card/card_detail/').$row['id'];?>">详细信息</a></td>
			</tr>
			<?php }?>
		</table>		
	</body>
</html>


