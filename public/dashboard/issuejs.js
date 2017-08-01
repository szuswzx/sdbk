$("document").ready(function(){
	var $all=$('#all');
	var $notyet=$('#notyet');
	var $finish=$('#finish');
	$("#notyet").on("click",function(){
		$all.removeClass('whole');
		$notyet.addClass('fornotyet');
		$finish.removeClass('forfini');
		$.ajax({  
			type: "post",  
			dataType: "json",  
			url: "../dashboard/issue/notyet/data/1",    
			success: loadIssue,
			error: function () {  
				alert("服务器异常");
			}  
		});
		$('#url').val('../dashboard/issue/notyet/data/');
		$("#current_page").val('1');
	});
	$("#finish").on("click",function(){
		$all.removeClass('whole');
		$finish.addClass('forfini');
		$notyet.removeClass('fornotyet'); 
		$.ajax({  
			type: "post",  
			dataType: "json",  
			url: "../dashboard/issue/finish/data/1",    
			success: loadIssue,  
			error: function () {  
				alert("服务器异常");  
			}  
		});
		$('#url').val('../dashboard/issue/finish/data/');
		$("#current_page").val('1');
	});
	$("#all").on("click",function(){
		$all.addClass('whole');
		$notyet.removeClass('fornotyet');
		$finish.removeClass('forfini');
		$.ajax({  
			type: "post",  
			dataType: "json",
			url: "../dashboard/issue/all/data/1",
			success: loadIssue,  
			error: function () {  
				alert("服务器异常");  
			}  
		});
		$('#url').val('../dashboard/issue/all/data/');
		$("#current_page").val('1');
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
				alert("服务器异常");
			}  
		});	
		$('#url').val('../dashboard/search_issue/');
		$("#current_page").val('1');
	});
	// $(".page").on("click", "a,span", function(evt){        //paging issue
	// 	var url = $("#url").val();
	// 	var current_page = $("#current_page").val();
	// 	var page = $(this)[0].innerHTML;
	// 	if(page == "上一页" && current_page != "1")
	// 		page = current_page*1 - 1*1;
	// 	else if(page == "上一页" && current_page == "1")
	// 		page = current_page*1;
	// 	else if(page == "下一页")
	// 		page = current_page*1 + 1*1;
		
	// 	var searchContent = $("#searchContent").val();
	// 	$.ajax({  
	// 		type: "post",  
	// 		dataType: "json",
	// 		url: url+page,
	// 		data: {keyword:searchContent},
	// 		success: loadIssue,  
	// 		error: function () {  
	// 			alert("服务器异常");
	// 		}  
	// 	});
	// 	$("#current_page").val(page);
	// });

	$('.getMore').on('click',function(){  // 点击获取更多
		$('tbody').append("<tr><td>1</td></tr>");
	});
	
	var $editMask=$('.editMask');
	var $content=$('.edit');
	var $close=$('.fa');
	$("#tbody-result").on("click", "td", function(evt){     //popup form
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
				
			},  
			error: function () {  
				alert("查询失败");  
			}  
		});
		$editMask.fadeIn('slow');
		$content.fadeIn('slow');
		evt.preventDefault();

	});
    $("#tbody-result").on("click", ".deleteIssue", function(evt){   //delete issue
		var id = $(this).find("p").attr("id");
		var $issue = $(this).parent('tr');
		var r = confirm("确定要删除编号为" + id + "的事务咨询吗？")
		if (r==true)
		{
			var $formatWrong=$('.formatWrong');
			var $message=window.document.getElementById("message");
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
					// alert(data);
					if(data == 0)
					{
						$message.innerHTML = '事务删除失败！';
						$formatWrong.css('background-color','rgb(224, 68, 68)');
					}
					else if(data == 1)
					{
						$message.innerHTML = '事务删除成功！';
						$formatWrong.css('background-color','rgb(68, 249, 68)');
					}
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});
					$issue.remove();
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
		var $formatWrong=$('.formatWrong');
		var $message=window.document.getElementById("message");
		$.ajax({  
			type: "post",
			url: "../dashboard/reply_issue/"+id,
			data:{asso:asso,reply:reply},
			async: false,
			success: function (data) {
				$content.css('display','none');
		        $editMask.css('display','none');
				alert(data);
				if(data == 0)
				{
					$message.innerHTML = '事务回复失败！';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
				}
				else if(data == 1)
				{
					$message.innerHTML = '事务回复成功！';
					$formatWrong.css('background-color','rgb(68, 249, 68)');
				}
				else
				{
					$message.innerHTML = '事务回复成功，提醒推送发送失败！';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
				}
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
});
function loadIssue(json) { //load issue
	var tbody=window.document.getElementById("tbody-result"); 
	var str = "";
	for(var i=0;i<json.length;i++)
	{
		var buttonStr = "";
		if(json[i].replied == '0')
			buttonStr += "<p id=" + json[i].id + ">回复</p>" + "</td>" +
						 "<td class='deleteIssue'>" + "<p id=" + json[i].id + ">删除</p>";
		else if(json[i].replied == '1')
			buttonStr += "</td>" +
						 "<td class='deleteIssue'>" + "<p id=" + json[i].id + ">删除</p>";
		str += "<tr>" +  
			"<td>" + json[i].id + "</td>" +  
			"<td>" + json[i].title + "</td>" +  
			"<td>" + json[i].user + "</td>" +
			"<td>"+ buttonStr +"</td>" +						
			"</tr>";
	}
	tbody.innerHTML = str;
}