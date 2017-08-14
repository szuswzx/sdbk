<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Bootstrap 实例 - 默认的导航栏</title>

<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="./../public/dashboard/menuCss.css">
</head>
<body>
<div class="contain">

	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">菜单栏</a>
			</div>
			<div>
				<ul class="nav navbar-nav">
				
					<?php
					$i = 0;
					foreach($first_menu as $row){
					?>
						<li class="dropdown js-level_2">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php echo $row['name'];?>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
							<?php
							foreach($sub_menu[$i] as $sub)
							{
							?>
								<li id="<?php echo $sub['mid'];?>"><a href="#"><?php echo $sub['name'];?></a></li>
								<li class="divider"></li>
							<?php
							}
							$i++;
							?>
								<li id="<?php echo $row['mid'];?>" class="addMenu"><a href="#">添加菜单</a></li>
							</ul>
						</li>
					<?php 
					}
					?>
					<li class="dropdown manage">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							管理一级菜单
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						<?php foreach($first_menu as $row)
						{
						?>
							<li id="<?php echo $row['mid'];?>"><a href="#"><?php echo $row['name'];?></a></li>
							<li class="divider"></li>
						<?php
						}
						?>
							<li id="0" class="addMenu"><a href="#">添加菜单</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		
	</nav>

	<div class="formatWrong" id="message"></div>

	<div class="box" style="display: none;">
		<div class="menuLevel">一级菜单信息-(getMenuName)</div>
		<div class="content">
			
			<div class="rightlabel" id="result">
			<?php echo form_open_multipart('dashboard/menu/add/', array('id' => 'menuForm')); ?>
				<div class="item">
					<p class="lab">名称</p>
					<input type="text" id="Name" name="name" value="" size="50" class="txt" placeholder="">
				</div>
				<div class="item">
					<p class="lab">类型</p>
					<select id="Type" name="type" class="txt">
				        <option value="view">页面跳转事件（必须填写链接）</option>
				        <option value="click">点击响应事件（必须填写key）</option>
				    </select>
				</div>
				<div class="item">
					<p class="lab">链接</p>
					<input type="text" id="Url" name="url" value="" size="50" class="txt" placeholder="格式为：http://......">
				</div>
				<div class="item">
					<p class="lab">Key</p>
					<input type="text" id="Key" name="key" value="" size="50" class="txt" placeholder="请输入key值(英文)">
				</div>
				<div class="item">
					<p class="lab">图文消息标题</p>
					<input type="text" id="Title" name="title" value="" size="50" class="txt" placeholder="">
				</div>
				<div class="item">
					<p class="lab">图文消息描述</p>
					<input type="text" id="Description" name="description" value="" size="50" class="txt" placeholder="">
				</div>
				<div class="item">
					<p class="lab">图文消息图片</p>
					<input type="file" id="img" name="img" value="" size="50" class="flieTxt" >
				</div>
				<input type="hidden" id="submitUrl">
				<input type="hidden" id="deleteUrl">
			</form>
				<div class="btns">
					<button type="submit" class="submit">确定</button>
					<button class="delete">删除</button>
				</div>
				
			</div>
			<div class="line"></div>
		</div>
	</div>
</div>
</body>

<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript" src="./../public/dashboard/menuJS.js"></script>

</html>