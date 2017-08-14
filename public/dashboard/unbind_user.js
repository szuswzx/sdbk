jQuery(function () {
	var $formatWrong=$('.formatWrong');
	var $message=window.document.getElementById("message");
	$("#search").on("click", function(evt){
		var searchContent = $("#searchContent").val();
		$.ajax({  
			type: "post",
			url: "../dashboard/find_user/data",
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
						"<td class='unbindCard'>"+ "<p class='un'><i class='fa fa-chain-broken' style='margin-right: 5px'></i>解绑</p>" +"</td>" +						
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
	$(".right").on("click", '.unbindCard', function(evt){
		var userid = $(this).parent().find('#userid').html();
		var card = $(this).parent();
		var r = confirm("确定要解绑id为为" + userid + "的用户吗？")
		if (r==true)
		{
			$.ajax({  
				type: "post",
				url: "../dashboard/unbind/"+userid,
				success: function (data) {
					if(data == 'success')
					{
						card.remove();
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
