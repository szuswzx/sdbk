<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Bootstrap 实例 - 默认的导航栏</title>
<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style type="text/css">
.navbar{
	width: 90%;
	margin:50px auto;
}
.navbar-header{
	width: 100px;
	font-weight: bold;
	color: black;
	
}
.navbar-header .navbar-brand{
	cursor: text;
}
.dropdown{
	width: 180px;
	text-align: center;
}
.dropdown:hover{
	background-color: #e7e7e7;
}
.dropdown-menu li a{
	width: 178px;
	text-align: center;
	cursor: pointer;
}
.dropdown-menu li.addMenu a{
	font-weight: bold;
	color: rgba(230, 77, 77, 0.9);
}
.nav .manage>a{
	font-weight: bold;
	font-size: 15px;
}
.content{
	width: 90%;
	margin:auto;
	height: auto;
	margin-bottom: 30px;
}
.rightlabel{
	width: 80%;
	height: 480px;
	
}

.item{
	width: 100%;
	
	float: left;
	margin-top: 5px;
	margin-bottom: 10px;
}
.lab{
	font-size: 15px;
	text-align: right;
	width: 20%;
	padding: 0px 10px;
	float: left;
	line-height: 36px;
}
.txt{
	width: 75%;
	float: left;
	margin-left:10px;
	padding:5px;
	margin-right: 20px;
	/*text-align: justify;*/
	font-size: 14px;
	border: 1px solid lightgrey;
	border-radius: 3px;

}
.flieTxt{
	width: 76%;
	float: left;
	margin-left:10px;
	padding:5px;
	font-size: 14px;
	border-radius: 3px;
}
.btns{
	width: 80%;
	float: right;
	margin-left:10px;
	padding:5px;
	margin-right: 20px;
	font-size: 14px;
	border-radius: 3px;
	display: flex;
	justify-content: space-around;
}
.btns .submit,.btns .add,.btns .delete{
	width: 80px;
	height: 30px;
	border-radius: 3px;
	background-color: #efdddd;
}
.menuLevel{
	width: 90%;
	margin:auto;
	font-size: 20px;
	font-weight: bold;
	text-align: center;
	margin: 20px;
}
.line{
	width: 100%;
	border-bottom: 1px solid #ddd;
	margin: 20px 0;
}
</style>
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
					<li class="dropdown js-level_2">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							常用查询1
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#">公文通</a></li>
							<li class="divider"></li>
							<li><a href="#">电费查询</a></li>
							<li class="divider"></li>
							<li><a href="#">课程表查询</a></li>
							<li class="divider"></li>
							<li class="addMenu"><a href="#">添加菜单</a></li>
						</ul>
					</li>
					<li class="dropdown js-level_2">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							常用查询2
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#">排课查询</a></li>
							<li class="divider"></li>
							<li><a href="#">事务咨询</a></li>
							<li class="divider"></li>
							<li><a href="#">校园卡找回</a></li>
							<li class="divider"></li>
							<li class="addMenu"><a href="#">添加菜单</a></li>
						</ul>
					</li>
					<li class="dropdown js-level_2">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							常用查询3
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#">测试测试</a></li>
							<li class="divider"></li>
							<li><a href="#">blabla</a></li>
							<li class="divider"></li>
							<li><a href="#">hahah</a></li>
							<li class="divider"></li>
							<li class="addMenu"><a href="#">添加菜单</a></li>
						</ul>
					</li>
					<li class="dropdown manage">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							管理一级菜单
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li id="menu1"><a href="#">常用查询1</a></li>
							<li class="divider"></li>
							<li id="menu2"><a href="#">常用查询2</a></li>
							<li class="divider"></li>
							<li id="menu3"><a href="#">常用查询3</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- <button class="manage">管理</button> -->
		</div>
		
	</nav>

	<div class="box" style="display: none;">
		<div class="menuLevel">一级菜单信息-(getMenuName)</div>
		<div class="content" ">
			
			<div class="rightlabel" id="result">
				<div class="item">
					<p class="lab">名称</p>
					<input type="text" name="name" value="" size="50" class="txt" placeholder="请输入菜单名称">
				</div>
				<div class="item">
					<p class="lab">类型</p>
					<select name="type" class="txt">
					    <option value="">一级菜单</option>
				        <option value="view">页面跳转事件（必须填写url）</option>
				        <option value="click">点击响应事件（必须填写key）</option>
				    </select>
				</div>
				<div class="item">
					<p class="lab">链接</p>
					<input type="text" name="url" value="" size="50" class="txt" placeholder="格式为：http://......">
				</div>
				<div class="item">
					<p class="lab">Key</p>
					<input type="text" name="key" value="" size="50" class="txt" placeholder="请输入key值">
				</div>
				<div class="item">
					<p class="lab">图文消息标题</p>
					<input type="text" name="title" value="" size="50" class="txt" placeholder="请输入标题">
				</div>
				<div class="item">
					<p class="lab">图文消息描述</p>
					<input type="text" name="description" value="" size="50" class="txt" placeholder="请输入描述">
				</div>
				<div class="item">
					<p class="lab">图文消息图片</p>
					<input type="file" name="img" value="" size="50" class="flieTxt" >
				</div>
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


<script type="text/javascript">
	$(function(){
		var $box = $('.box');

		$('.manage').on('click','#menu1',function(){
			$box.show();
			$box.find('.menuLevel').text('一级菜单-(getMenuName)')
		})
		$('.manage').on('click','#menu2',function(){
			$box.show();
			$box.find('.menuLevel').text('一级菜单-(getMenuName)')
		})
		$('.manage').on('click','#menu3',function(){
			$box.show();
			$box.find('.menuLevel').text('一级菜单-(getMenuName)')
		})


		$('.js-level_2').on('click','.addMenu',function(){
			$box.show();
			$box.find('.menuLevel').text('二级菜单-(getMenuName)')
		})
		$('.js-level_2').on('click','li',function(){
			$box.show();
			$box.find('.menuLevel').text('二级菜单-(getMenuName)')
		})
	})
</script>
</html>