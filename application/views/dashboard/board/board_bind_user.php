<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">

<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="./../public/dashboard/boardCSS.css">
</head>
<body>

<div class="contain">
	<div class="left">
		<p class="inside im" id="bind">公文通提醒绑定</p>
		<p class="inside" id="bindList">公文通推送列表</p>
	</div>
	<div class="formatWrong" id="message"></div>
	<div class="right">
		<button type="submit" class="input" id="search">搜索</button>
		<input type="input" class="input" id="searchContent" placeholder="搜索用户进行绑定" />
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
	var $bind = $('#bind');
	var $bindList = $('#bindList');
	var $formatWrong=$('.formatWrong');
	var $message=window.document.getElementById("message");
	
	$bind.on('click',function(){
		$('.right').load('../dashboard/board_user/page2');
		$bind.addClass('im');
		$bindList.removeClass('im');
	});
	$bindList.on('click',function(){
		$('.right').load('../dashboard/board_bind_list');
		$bindList.addClass('im');
		$bind.removeClass('im');
	});
	
	$(".right").on("click", '#search',function(evt){
		var searchContent = $("#searchContent").val();
		$.ajax({  
			type: "post",
			url: "../dashboard/board_user/data",
			dataType : 'json',
			data: {studentNo:searchContent},
			success: function (json) {
				var tbody=window.document.getElementById("result"); 
				var str = "";
				for(var i=0;i<json.length;i++)
				{
					str += "<tr>" +   
						"<td id='userid'>" + json[i].userid + "</td>" +  
						"<td>" + json[i].studentNo + "</td>" +  
						"<td>" + json[i].studentName + "</td>" +
						"<td>" + json[i].icAccount + "</td>" +
						"<td class='push_bind'>"+ "<p>提醒绑定</p>" +"</td>" +						
						"</tr>";
				}
				if(json.length == 0)
				{
					$message.innerHTML = '没有此用户';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				}
				tbody.innerHTML = str;
			},
			error: function () {  
				$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			}  
		});
	});
	$(".right").on("click", '.push_bind', function(evt){
		var userid = $(this).parent().find('#userid').html();
		var r = confirm("确定要在公文通更新时，给id为" + userid + "的用户推送公文通吗？")
		if (r==true)
		{
			$.ajax({  
				type: "post",
				url: "../dashboard/bind_board_push/"+userid,
				success: function (data) {
					if(data == 1)
					{
						$message.innerHTML = '绑定成功！';
						$formatWrong.css('background-color','rgb(68, 249, 68)');
						$formatWrong.fadeIn('',function(){
							$formatWrong.fadeOut(3000);
						});						
					}
					else
					{
						$message.innerHTML = '该用户已经绑定过了！';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
						$formatWrong.fadeIn('',function(){
							$formatWrong.fadeOut(3000);
						});
					}
					
				},
				error: function () {
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
	
	$(".right").on("click", '.unbind', function(evt){
		var userid = $(this).parent().find('#userid').html();
		var user = $(this).parent();
		var r = confirm("确定不再给id为" + userid + "的用户推送公文通吗？")
		if (r==true)
		{
			$.ajax({  
				type: "post",
				url: "../dashboard/unbind_board_push/"+userid,
				success: function (data) {
					if(data == 1)
					{
						user.remove();
						$message.innerHTML = '解绑成功！';
						$formatWrong.css('background-color','rgb(68, 249, 68)');
						$formatWrong.fadeIn('',function(){
							$formatWrong.fadeOut(3000);
						});						
					}
					else
					{
						$message.innerHTML = '解绑失败！';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
						$formatWrong.fadeIn('',function(){
							$formatWrong.fadeOut(3000);
						});
					}
					
				},
				error: function () {
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

</script>
</html>