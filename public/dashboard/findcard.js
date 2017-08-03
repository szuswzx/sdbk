$("document").ready(function(){
	var $inputmsg=$('#inputmsg');
	var $confirmrtn=$('#confirmrtn');
	var $studentNo=$('#studentNo');
	var $submit=$('#submit');
	var $formatWrong=$('.formatWrong');
	var $message=window.document.getElementById("message");
	
	$confirmrtn.click(function(){
		$(".right").load("../dashboard/card");
		$inputmsg.removeClass("im");
		$confirmrtn.addClass("forcon");
	});
	$(".right").on("input", '#studentNo', function(evt){
	  var $submit=$('#submit');
	  if($(this).val().trim().length == 10){
		$submit.removeAttr("disabled");
	  }else{
		$submit.prop("disabled","disabled");
	  }
	});
	$(".right").on("click", "table button", function(evt){    //return card
		var $formatWrong=$('.formatWrong');
		var $message=window.document.getElementById("message");		
		var id = $(this).attr("id");
		var r = confirm("确定要归还编号为" + id + "的校园卡吗？")
		if (r==true)
		{
			$.ajax({
				type: "POST",  
				url:'../dashboard/return_card/'+id,  
				async: false,  //同步等待结果执行返回
				error: function() {
					$(window).scrollTop(0);
					$message.innerHTML = '服务器异常';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				},  
				success: function(data) {
					if(data == 0)
					{
						$message.innerHTML = '归还记录修改失败！';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
					}
					else if(data == 1)
					{
						$message.innerHTML = '归还记录修改成功！';
						$formatWrong.css('background-color','rgb(68, 249, 68)');
					}
					else
					{
						$message.innerHTML = '归还记录修改成功，归还提醒推送发送失败！';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
					}
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
					$(window).scrollTop(0);
					$(".right").load("../dashboard/card");
					$inputmsg.removeClass("im");
					$confirmrtn.addClass("forcon");
				}  
			});
		}
		else
		{
			
		}
	});
	$(".right").on("click", "#search", function(evt){    //search card
		var searchContent = $("#searchContent").val();
		$(".right").load("../dashboard/search_card", {keyword: searchContent},function(){
			$("#searchContent").val(searchContent);
			$("#current_page").val('1');
			$("#url").val('../dashboard/search_card/data/');
		});		
	});
	$('.right').on('click', '.getMore',function(){  // 点击获取更多
		var url = $("#url").val();
		var current_page = $("#current_page").val();
		var searchContent = $("#searchContent").val();
		current_page = current_page*1+1*1;
		$.ajax({
			type: "post",  
			dataType: "json",
			url: url+current_page,
			data: {keyword:searchContent},
			success: function(json) { //load issue
				var str = "";
				for(var i=0;i<json.length;i++)
				{
					var buttonStr = "";
					if(json[i].isReturn == '0')
						buttonStr += "<button class='btn' id=" + json[i].id + " ><i class='fa fa-check-square'></i>确认归还</button>";
					str += "<tr>" +  
						"<td>" + json[i].id + "</td>" +  
						"<td>" + json[i].studentNo + "</td>" +  
						"<td>" + json[i].studentName + "</td>" +
						"<td>" + json[i].getName + "</td>" +
						"<td>"+ buttonStr +"</td>" +						
						"</tr>";
				}
				$('tbody').append(str);
				$("#current_page").val(current_page);
				if(json.length == 0)  //not more
				{
					$(window).scrollTop(0);
					$message.innerHTML = '没有更多啦！';
					$formatWrong.css('background-color','rgb(68, 249, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				}
			},
			error: function () {
				$(window).scrollTop(0);
				$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			}  
		});
	});
	$inputmsg.click(function(){
		$inputmsg.addClass("im");
		$confirmrtn.removeClass("forcon");
		$(".right").load("../dashboard/add_card/add");
	});

});
function typein(){
	var $form=$('#add_card');
	var $formatWrong=$('.formatWrong');
	var $message=window.document.getElementById("message");
	
	$.ajax({  
		type: "POST",  
		url:'../dashboard/add_card',  
		data:$('#add_card').serialize(),
		async: false,  //同步等待结果执行返回
		error: function(request) {
			$message.innerHTML = '服务器异常';
			$formatWrong.css('background-color','rgb(224, 68, 68)');
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
		},  
		success: function(data) {			
			if(data == 0)
			{
				$message.innerHTML = '添加校园卡丢失记录失败！';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
			}
			else if(data == 1)
			{
				$message.innerHTML = '添加校园卡丢失记录成功！';
				$formatWrong.css('background-color','rgb(68, 249, 68)');
				$form[0].reset();
			}
			else
			{
				$message.innerHTML = '添加校园卡丢失记录成功，丢卡提醒推送发送失败！';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$form[0].reset();
			}
			$formatWrong.fadeIn('',function(){
				$formatWrong.fadeOut(3000);
			});
		}  
	});
}