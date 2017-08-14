	$(function(){
		var $box = $('.box');
		var $formatWrong = $('.formatWrong');
		var $message=window.document.getElementById("message");

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
						$message.innerHTML = '服务器异常';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
						$formatWrong.fadeIn('',function(){
							$formatWrong.fadeOut(3000);
						});
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
						$message.innerHTML = '服务器异常';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
						$formatWrong.fadeIn('',function(){
							$formatWrong.fadeOut(3000);
						});
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
					// alert(data);
					$message.innerHTML = data;
					$formatWrong.css('background-color','rgb(68, 249, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
					var timer = setTimeout(function(){
						$("#sdbkMenu").trigger('click');
					},3000);
				
				},
				error: function(request) {
					$message.innerHTML = '服务器异常';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
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
						// alert(data);
						$message.innerHTML = data;
						$formatWrong.css('background-color','rgb(68, 249, 68)');
						$formatWrong.fadeIn('',function(){
							$formatWrong.fadeOut(3000);
						});
						var timer = setTimeout(function(){
							$("#sdbkMenu").trigger('click');
						},3000);
					
					},
					error: function(request) {
						$message.innerHTML = '服务器异常';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
						$formatWrong.fadeIn('',function(){
							$formatWrong.fadeOut(3000);
						});
					}				
				});
			}
			else
			{}
		});
	});
