<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>


<style type="text/css">

.left{
	padding-top: 25px;
	width: 12%;
	display: inline-block;
	float: left;
	margin-left: 20px;
}
.inside{
	height: 30px;
	font-size: 15px;
	padding: 10px 20px;
	cursor: pointer;
}
.whole{
	color: #408ec0;
	border-right: 3px solid #408ec0;
}
.fornotyet{
	color: #408ec0;
	border-right: 3px solid #408ec0;
}
.forfini{
	color: #408ec0;
	border-right: 3px solid #408ec0;
}
.right{
	width: 84%;
    float: left;
    padding-left: 40px;
    padding-top: 30px;
    padding-right: 20px;
}
.input{
	float: right;
	border:1px solid lightgrey;
	margin-left: 10px;
	margin-bottom: 10px;
}
table{
	width: 100%;
	text-align: center;
}
tr{
	height: 40px;
}
tr:hover{
	background-color: rgba(224, 212, 212, 0.17);
}
td{
	border-right: 1px solid white;
}
.page{
	text-align: center;
	height: 40px;
	margin-top: 40px;
	border-radius: 4px;
	
}
.page a,.page span{
	text-decoration: none;
	border: 1px solid lightgrey;
	padding: 5px 7px;
	color: #333;
	cursor: pointer;
}
.page a:hover,.page span:hover{
	background-color: #daa;
}


.editMask{
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,.8);
	z-index: 1005;
	display: none;
}
.edit{
	position: fixed;
	top: 50%;
	left: 50%;
	margin-left: -250px;
	margin-top: -270px;
	width: 500px;
	height: 540px;
	overflow: auto;
	background-color: #fff;
	border-radius: 5px;
	box-shadow: 0 0 20px rgba(0,0,0,.4);
	display: none;

}
.editTitle{
	background-color: #f45757;
	padding: 0 10px;
	color: #fff;
	font-size: 16px;
	line-height: 36px;

}
.close{
	float: right;
	cursor: pointer;
}
.fa{
	display: inline-block;
	font-size: inherit;
	text-rendering: auto;

}
.editBody{
	width: 100%;
	padding: 10px;
	padding-bottom: 20px;
}
.item{
	float: left;
	width: 100%;
	margin-top: 5px;
}
.editleft{
	float: left;
	width: 20%;
	padding: 5px 10px;
	text-align: right;
	color: #f45757;
	font-size: 14px;
}
.editright{
	float: left;
	width: 76%;
	padding: 5px;
	text-align: justify;
	color: #2b2b2b;
	font-size: 14px;
}
[type='text']{
	width: 100%;
	padding: 5px 10px;
	color: #2b2b2b;
	font-size: 14px;
	line-height: 24px;
	border-radius: 3px;
	border: 1px solid #ddd;
}
textarea{
	height: 200px;
	width: 100%;
	resize: none;
}
.replayBtn{
	width: 150px;
	margin:0 auto;
}
button{
	width: 100px;
	height: 32px;
	margin-top: 5px;
	color: #aaa;
	font-size: 14px;
	line-height: 32px;
	background: #f6f6f6;
	border-radius: 3px;

}
.cancel{
	float: right;
	color: #888;
	font-size: 14px;
	line-height: 42px;
	cursor: pointer;

}
</style>
</script>
</head>
<body>

<div class="contain">
	<div class="left">
		<p class="inside whole" id="all">全部事务</p>
		<p class="inside" id="notyet">未回复事务</p>
		<p class="inside" id="finish">已回复事务</p>
	</div>
	<div class="right">
		<button type="submit" class="input" id="search">搜索</button>
		<input type="input" class="input" id="searchContent" placeholder="id、名称、内容、用户" />
		<table>
			<tr style="background-color: rgba(199, 189, 189, 0.16)">
				<td style="width: 15%;">序号</td>
				<td style="max-width:40%;">标题</td>
				<td style="width: 25%;">咨询人</td>
				<td colspan="2" style="width: 10%;">操作</td>
			</tr>
			<tbody id="tbody-result">  
			<?php foreach($issue as $row){?>
			<tr>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['title'];?></td>
				<td><?php echo $row['user'];?></td>
				<td><?php 
				          if($row['replied'] == '0')
							  echo "<button id=".$row['id'].">回复</button>";
					?>
				</td>
				<td class='deleteIssue'><?php echo "<button id=".$row['id'].">删除</button>";?></td>
			</tr>
			<?php }?> 
			</tbody>
		</table>
		<div class="page">
		    <input type="hidden" id="url" value="../dashboard/issue/all/data/">
			<input type="hidden" id="current_page" value="1">
			<span>上一页</span>
			<a>1</a>
			<a>2</a>
			<a>3</a>
			<span>下一页</span>			
		</div>
	</div>
</div>
<div class="editMask">
	<div class="edit">
		<div class="editTitle">
			回复事务<span class="close"><i class="fa fa-times-circle"></i></span>
		</div>
		<div class="editBody">
			<div class="item">
				<div class="editleft">标题</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">事务内容</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">咨询人</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">咨询人学号</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">所在单位</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">联系方式</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">回复部门</div>
				<div class="editright"><input id="asso" type="text"></div>
			</div>
			<div class="item">
				<div class="editleft">回复内容</div>
				<div class="editright"><textarea id="reply" placeholder="回复些什么吧"></textarea></div>
			</div>
			<div class="item">
				<div class="editleft">回复人</div>
				<div class="editright"></div>
			</div>
			<div class="item">
			    <input type="hidden" id="issueId">
				<div class="replayBtn"><button class="submitReply">提交回复</button><span class="cancel">取消</span></div>
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
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
	$(".page").on("click", "a,span", function(evt){        //paging issue
		var url = $("#url").val();
		var current_page = $("#current_page").val();
		var page = $(this)[0].innerHTML;
		if(page == "上一页" && current_page != "1")
			page = current_page*1 - 1*1;
		else if(page == "上一页" && current_page == "1")
			page = current_page*1;
		else if(page == "下一页")
			page = current_page*1 + 1*1;
		
		var searchContent = $("#searchContent").val();
		$.ajax({  
			type: "post",  
			dataType: "json",
			url: url+page,
			data: {keyword:searchContent},
			success: loadIssue,  
			error: function () {  
				alert("服务器异常");
			}  
		});
		$("#current_page").val(page);
	});
	
	var $editMask=$('.editMask');
	var $content=$('.edit');
	var $close=$('.fa');
	$("#tbody-result").on("click", "td", function(evt){     //popup form
		var id = $(this).parent().find("button").attr("id");
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
		var id = $(this).find("button").attr("id");
		var $issue = $(this).parent('tr');
		var r = confirm("确定要删除编号为" + id + "的事务咨询吗？")
		if (r==true)
		{
			//var $formatWrong=$('.formatWrong');
			//var $message=window.document.getElementById("message");
			$.ajax({
				type: "POST",
				url:'../dashboard/delete_issue/'+id,  
				async: false,  //同步等待结果执行返回
				error: function(request) {
					/*$message.innerHTML = '服务器异常';
					$formatWrong.css('background-color','rgb(224, 68, 68)');
					$formatWrong.fadeIn('',function(){
						$formatWrong.fadeOut(3000);
					});*/
				},  
				success: function(data) {
					alert(data);
					/*if(data == 0)
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
					});*/
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
		//var $formatWrong=$('.formatWrong');
		//var $message=window.document.getElementById("message");
		$.ajax({  
			type: "post",
			url: "../dashboard/reply_issue/"+id,
			data:{asso:asso,reply:reply},
			async: false,
			success: function (data) {
				$content.css('display','none');
		        $editMask.css('display','none');
				alert(data);
				/*if(data == 0)
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
				});*/
			},  
			error: function () {  
				/*$message.innerHTML = '服务器异常';
				$formatWrong.css('background-color','rgb(224, 68, 68)');
				$formatWrong.fadeIn('',function(){
					$formatWrong.fadeOut(3000);
				});*/
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
			buttonStr += "<button id=" + json[i].id + ">回复</button>" + "</td>" +
						 "<td class='deleteIssue'>" + "<button id=" + json[i].id + ">删除</button>";
		else if(json[i].replied == '1')
			buttonStr += "</td>" +
						 "<td class='deleteIssue'>" + "<button id=" + json[i].id + ">删除</button>";
		str += "<tr>" +  
			"<td>" + json[i].id + "</td>" +  
			"<td>" + json[i].title + "</td>" +  
			"<td>" + json[i].user + "</td>" +
			"<td>"+ buttonStr +"</td>" +						
			"</tr>";
	}
	tbody.innerHTML = str;
}
</script>

</html>