$(function(){
	var $all=$('#all');
	var $notyet=$('#notyet');
	var $finish=$('#finish');
	var $formatWrong=$('.formatWrong');
	var $message=window.document.getElementById("message");
	
	$("#notyet").on("click",function(){
		$all.removeClass('im');
		$notyet.addClass('im');
		$finish.removeClass('im');
		$.ajax({  
			type: "post",  
			dataType: "json",  
			url: "../dashboard/issue/notyet/data/1",    
			success: loadIssue,
			error: function () {  
				$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			}  
		});
		$('#url').val('../dashboard/issue/notyet/data/');
		$("#current_page").val('1');
		$("#searchContent").val('');
	});
	$("#finish").on("click",function(){
		$all.removeClass('im');
		$finish.addClass('im');
		$notyet.removeClass('im'); 
		$.ajax({  
			type: "post",  
			dataType: "json",  
			url: "../dashboard/issue/finish/data/1",    
			success: loadIssue,  
			error: function () {  
				$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			}  
		});
		$('#url').val('../dashboard/issue/finish/data/');
		$("#current_page").val('1');
		$("#searchContent").val('');
	});
	$("#all").on("click",function(){
		$all.addClass('im');
		$notyet.removeClass('im');
		$finish.removeClass('im');
		$.ajax({  
			type: "post",  
			dataType: "json",
			url: "../dashboard/issue/all/data/1",
			success: loadIssue,  
			error: function () {  
				$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			}  
		});
		$('#url').val('../dashboard/issue/all/data/');
		$("#current_page").val('1');
		$("#searchContent").val('');
	});

	$("#search").on("click", function(evt){  //search issue
		var searchContent = $("#searchContent").val();
		$.ajax({  
			type: "post",  
			dataType: "json",
			url: "../dashboard/search_issue",
			data: {keyword:searchContent},
			success: loadIssue,  
			error: function () {  
				$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
			}  
		});	
		$('#url').val('../dashboard/search_issue/');
		$("#current_page").val('1');
	});

	$('.getMore').on('click',function(){  // 点击获取更多
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
					if(json[i].replied == '0')
						buttonStr += "<div class='hold'><p class='replyBtn' style='display:inline-block;cursor:pointer;padding-right:8px;' id=" + json[i].id + "><i class='fa fa-trash' style='margin-right: 5px'></i>回复</p>" +
									  "<p class='delBtn' style=';cursor: pointer;' id=" + json[i].id + "><i class='fa fa-trash' style='margin-right: 5px;'></i>删除</p></div>";
					else if(json[i].replied == '1')
						buttonStr += "<div class='hold'>" + "<p class='delBtn' style=';cursor: pointer;' id=" + json[i].id + "><i class='fa fa-trash' style='margin-right: 5px;'></i>删除</p></div>";
					str += "<tr>" +  
						"<td>" + json[i].id + "</td>" +  
						"<td>" + json[i].title + "</td>" +  
						"<td>" + json[i].user + "</td>" +
						"<td class='deleteIssue'>"+ buttonStr +"</td>" +						
						"</tr>";
				}
				$('#tbody-result').append(str);
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
	


	var $editMask=$('.editMask');
	var $content=$('.edit');
	var $close=$('.fa');

	$("#tbody-result").on("click", "td ,td .replyBtn", function(evt){     //popup form
		var id = $(this).parent().find("p").attr("id");
		if($(this).attr("class") == "deleteIssue")
		{
			$(this).off();
			return false;
		}
		$.ajax({  
			type: "post",  
			dataType: "json",
			url: "../dashboard/issue_by_id/"+id,
			success: function (json) {
				$(".item").each(function(){
					var left = $(this).find(".editleft").html();
					var $right = $(this).find(".editright");
					if(left == "标题")
						$right.html(json['title']);
					else if(left == "事务内容")
						$right.html(json['content']);
					else if(left == "咨询人")
						$right.html(json['studentName']);
					else if(left == "咨询人学号")
						$right.html(json['studentNo']);
					else if(left == "所在单位")
						$right.html(json['org']);
					else if(left == "联系方式")
						$right.html(json['phone']);
					else if(left == "回复部门")
						$right.find('input').val(json['asso']);
					else if(left == "回复内容")
						$right.find('textarea').val(json['reply']);
					else if(left == "回复人")
						$right.html(json['responder']);
				});
				$('#issueId').val(id);
				$editMask.fadeIn('slow');
				$content.fadeIn('slow');
				evt.preventDefault();
				
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

    $("#tbody-result").on("click", ".delBtn", function(evt){   //delete issue
		var id = $(this).attr("id");
		var $issue = $(this).parent('.hold').parent('.deleteIssue').parent('tr');
		var r = confirm("确定要删除编号为" + id + "的事务咨询吗？")
		if (r==true)
		{
			$.ajax({
				type: "POST",
				url:'../dashboard/delete_issue/'+id,  
				async: false,  //同步等待结果执行返回
				error: function(request) {
					$message.innerHTML = '服务器异常';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				},  
				success: function(data) {
					$(window).scrollTop(0);
					if(data == 1)
					{
						$message.innerHTML = '事务删除成功！';
						$formatWrong.css('background-color','rgb(68, 249, 68)');
						$issue.remove();
					}
					else
					{
						$message.innerHTML = '事务删除失败！';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
					}
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
				}  
			});
		}
		else
		{
		}
	});		
	
	$close.click(function(){
		$content.css('display','none');
		$editMask.css('display','none');
	});	
	$('.cancel').click(function(){
		$content.css('display','none');
		$editMask.css('display','none');
	});

	$('.submitReply').on('click',function(){  //reply issue
		var id = $(this).parent().prev('input').val();
		var asso = $('#asso').val();
		var reply = $('#reply').val();
		$.ajax({  
			type: "post",
			url: "../dashboard/reply_issue/"+id,
			data:{asso:asso,reply:reply},
			async: false,
			success: function (data) {
				$(window).scrollTop(0);
				$content.css('display','none');
		        $editMask.css('display','none');
				if(data == 2)
				{
					$message.innerHTML = '事务回复成功，提醒推送发送失败！';
					$formatWrong.css('background-color','rgb(224, 68, 68)');					
				}
				else if(data == 1)
				{
					$message.innerHTML = '事务回复成功！';
					$formatWrong.css('background-color','rgb(68, 249, 68)');
				}
				else
				{
					$message.innerHTML = '事务回复失败！';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
				}

				if($all.attr('class') == 'inside im')    //事务回复后，刷新页面
					$all.trigger('click');
				else if($notyet.attr('class') == 'inside im')
					$notyet.trigger('click');
				
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});
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

function loadIssue(json) { //load issue
	var tbody=window.document.getElementById("tbody-result"); 
	var str = "";
	for(var i=0;i<json.length;i++)
	{
		var buttonStr = "";
		if(json[i].replied == '0')
			buttonStr += "<div class='hold'><p class='replyBtn' style='display:inline-block;cursor:pointer;padding-right:8px;' id=" + json[i].id + "><i class='fa fa-trash' style='margin-right: 5px'></i>回复</p>" +
						  "<p class='delBtn' style=';cursor: pointer;' id=" + json[i].id + "><i class='fa fa-trash' style='margin-right: 5px;'></i>删除</p></div>";
		else if(json[i].replied == '1')
			buttonStr += "<div class='hold'>" + "<p class='delBtn' style=';cursor: pointer;' id=" + json[i].id + "><i class='fa fa-trash' style='margin-right: 5px;'></i>删除</p></div>";
			str += "<tr>" +   
			"<td>" + json[i].id + "</td>" +  
			"<td>" + json[i].title + "</td>" +  
			"<td>" + json[i].user + "</td>" +
			"<td class='deleteIssue'>"+ buttonStr +"</td>" +						
			"</tr>";
	}
	tbody.innerHTML = str;
}
});