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
			<!-- <button class="manage">管理</button> -->
		</div>
		
	</nav>

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


<script type="text/javascript">
	$(function(){
		var $box = $('.box');

		$('.manage').on('click','li',function(){
			if($(this).attr('class') != 'addMenu')
			{
				var mid = $(this).attr('id');
				var name = $(this).find('a').html();
				$.ajax({
					type: 'post',
					url: '../dashboard/menu/get_by_id/'+mid,
					dataType: "json",
					async: false,
					success: function(json){
						$box.find('#Name').val(name);
						$box.find("#Type").val(json['type']);
						$box.find('#Url').val(json['url']);
						$box.find('#Key').val(json['key']);
						$box.find('#Title').val(json['title']);
						$box.find('#Description').val(json['description']);
						$box.find('#submitUrl').val('../dashboard/menu/update/'+mid);
						$box.find('#deleteUrl').val('../dashboard/menu/delete/'+mid);
					},
					error: function () {  
						// $message.innerHTML = '服务器异常';
						// $formatWrong.css('background-color','rgb(224, 68, 68)');
						// $formatWrong.fadeIn('',function(){
							// $formatWrong.fadeOut(3000);
						// });
					}
				});			
				$box.show();
				$box.find('.menuLevel').text('一级菜单-('+name+')');
			}
			else if($(this).attr('class') == 'addMenu')
			{
				$('#menuForm')[0].reset();
				var mid = $(this).attr('id');
				$box.find('#submitUrl').val('../dashboard/menu/add/'+mid);
				$box.find('#deleteUrl').val('');				
				$box.show();
				$box.find('.menuLevel').html('一级菜单-(添加菜单)<br><h5>添加一级菜单请输入任意url作为暂时设置</h5>');				
			}
		});

		$('.js-level_2').on('click','li',function(){
			if($(this).attr('class') != 'addMenu')
			{
				var mid = $(this).attr('id');
				var name = $(this).find('a').html();
				$.ajax({
					type: 'post',
					url: '../dashboard/menu/get_by_id/'+mid,
					dataType: "json",
					async: false,
					success: function(json){
						$box.find('#Name').val(name);
						//$box.find("#Type option[value='"+json['type']+"']").attr("selected", true);
						$box.find("#Type").val(json['type']);
						$box.find('#Url').val(json['url']);
						$box.find('#Key').val(json['key']);
						$box.find('#Title').val(json['title']);
						$box.find('#Description').val(json['description']);
						$box.find('#submitUrl').val('../dashboard/menu/update/'+mid);
						$box.find('#deleteUrl').val('../dashboard/menu/delete/'+mid);						
					},
					error: function () {  
						// $message.innerHTML = '服务器异常';
						// $formatWrong.css('background-color','rgb(224, 68, 68)');
						// $formatWrong.fadeIn('',function(){
							// $formatWrong.fadeOut(3000);
						// });
					}
				});			
				$box.show();
				$box.find('.menuLevel').text('二级菜单-('+name+')');
			}
			else if($(this).attr('class') == 'addMenu')
			{
				$('#menuForm')[0].reset();
				var mid = $(this).attr('id');
				$box.find('#submitUrl').val('../dashboard/menu/add/'+mid);
				$box.find('#deleteUrl').val('');
				$box.show();
				$box.find('.menuLevel').text('二级菜单-(添加菜单)');				
			}				
		});
		
		$box.on('click','.submit',function(){               //提交表单更新或者插入菜单
			var url = $box.find('#submitUrl').val();
			var formData = new FormData();
			formData.append("img",$box.find("#img")[0].files[0]);
			formData.append('name',$box.find('#Name').val());
			formData.append('type',$box.find('#Type').val());
			formData.append('url',$box.find('#Url').val());
			formData.append('key',$box.find('#Key').val());
			formData.append('title',$box.find('#Title').val());
			formData.append('description',$box.find('#Description').val());
			
			$.ajax({
				type: "POST",  
				url: url,  
				data: formData,
				// 告诉jQuery不要去处理发送的数据
				processData : false, 
				// 告诉jQuery不要去设置Content-Type请求头
				contentType : false,
				async: false,  //同步等待结果执行返回  
				success: function(data) {
					alert(data);
					$("#sdbkMenu").trigger('click');
				},
				error: function(request) {
					/*$message.innerHTML = '服务器异常';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});*/
				}				
			});
		});
		
		$box.on('click','.delete',function(){              //删除菜单
			var url = $box.find('#deleteUrl').val();
			var name = $box.find('#Name').val();
			var r = confirm("确定要删除--" + name + "--菜单吗？")
			if (r==true)
			{
				$.ajax({
					type: "POST",  
					url: url,
					async: false,  //同步等待结果执行返回  
					success: function(data) {
						alert(data);
						$("#sdbkMenu").trigger('click');
					},
					error: function(request) {
						/*$message.innerHTML = '服务器异常';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
						$formatWrong.fadeIn('',function(){
							$formatWrong.fadeOut(3000);
						});*/
					}				
				});
			}
			else
			{}
		});
	});
</script>
</html>