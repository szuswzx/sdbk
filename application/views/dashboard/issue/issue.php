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
		<button type="submit" class="input" id="">搜索</button>
		<input type="input" class="input"  placeholder="id、名称、内容、用户" />
		<table>
			<tr style="background-color: rgba(199, 189, 189, 0.16)">
				<td style="width: 15%;">序号</td>
				<td style="max-width:40%;">标题</td>
				<td style="width: 25%;">咨询人</td>
				<td style="width: 10%;">操作</td>
			</tr>
			<tbody id="tbody-result">  
			<?php foreach($issue as $row){?>
			<tr>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['title'];?></td>
				<td><?php echo $row['user'];?></td>
				<td><?php 
						  if($row['replied'] == '1')
							  echo "<button id=".$row['id'].">删除</button>";
						  else if($row['replied'] == '0')
							  echo "<button id=".$row['id'].">回复</button>"."<button id=".$row['id'].">删除</button>";
					?>
				</td>
			</tr>
			<?php }?> 
			</tbody>
		</table>
		<div class="page">
			<span>上一页</span>
			<a href="#">1</a>
			<a href="#">2</a>
			<a href="#">3</a>
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
				<div class="editright"><input type="text"></div>
			</div>
			<div class="item">
				<div class="editleft">回复内容</div>
				<div class="editright"><textarea placeholder="回复些什么吧"></textarea></div>
			</div>
			<div class="item">
				<div class="editleft">回复人</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="replayBtn"><button>提交回复</button><span class="cancel">取消</span></div>
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
			var tbody=window.document.getElementById("tbody-result");  
			$.ajax({  
				type: "post",  
				dataType: "json",  
				url: "../dashboard/issue/notyet/data/1",    
				success: function (json) {
					var str = "";
					for(var i=0;i<json.length;i++)
					{  
						str += "<tr>" +  
							"<td>" + json[i].id + "</td>" +  
							"<td>" + json[i].title + "</td>" +  
							"<td>" + json[i].user + "</td>" +
							"<td>" +
							"<button id=" + json[i].id + ">回复</button>" +
							"<button id=" + json[i].id + ">删除</button>" +
							"</td>" +						
							"</tr>";
					}
                    tbody.innerHTML = str;
				},  
				error: function () {  
					alert("查询失败")  
				}  
            });
		});
		$("#finish").on("click",function(){
			$all.removeClass('whole');
			$finish.addClass('forfini');
			$notyet.removeClass('fornotyet');
			var tbody=window.document.getElementById("tbody-result");  
			$.ajax({  
				type: "post",  
				dataType: "json",  
				url: "../dashboard/issue/finish/data/1",    
				success: function (json) {
					var str = "";
					for(var i=0;i<json.length;i++)
					{  
						str += "<tr>" +  
							"<td>" + json[i].id + "</td>" +  
							"<td>" + json[i].title + "</td>" +  
							"<td>" + json[i].user + "</td>" +
							"<td>" +
							"<button id=" + json[i].id + ">删除</button>" +
							"</td>" +						
							"</tr>";
					}
                    tbody.innerHTML = str;
				},  
				error: function () {  
					alert("查询失败")  
				}  
            });
		});
		$("#all").on("click",function(){
			$all.addClass('whole');
			$notyet.removeClass('fornotyet');
			$finish.removeClass('forfini');
			var tbody=window.document.getElementById("tbody-result");  
			$.ajax({  
				type: "post",  
				dataType: "json",  
				url: "../dashboard/issue/all/data/1",
				success: function (json) {
					var str = "";
					for(var i=0;i<json.length;i++)
					{
						var buttonStr = "";
						if(json[i].replied == '0')
							buttonStr += "<button id=" + json[i].id + ">回复</button>" +
							             "<button id=" + json[i].id + ">删除</button>";
						else if(json[i].replied == '1')
							buttonStr += "<button id=" + json[i].id + ">删除</button>";
						str += "<tr>" +  
							"<td>" + json[i].id + "</td>" +  
							"<td>" + json[i].title + "</td>" +  
							"<td>" + json[i].user + "</td>" +
							"<td>"+ buttonStr +"</td>" +						
							"</tr>";
					}
                    tbody.innerHTML = str;
				},  
				error: function () {  
					alert("查询失败")  
				}  
            });
		});
		var $editMask=$('.editMask');
		var $content=$('.edit');
		var $close=$('.fa');
		$('td').click(function(evt){
			$editMask.fadeIn('slow');
			$content.fadeIn('slow');
			evt.preventDefault();

		});
		$close.click(function(){
			$content.css('display','none');
			$editMask.css('display','none');
		});
	});
</script>

</html>