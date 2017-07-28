<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style type="text/css">

.left{
	padding-top: 25px;
	width: 15%;
	display: inline-block;
	float: left;
}
.inside{
	height: 30px;
	font-size: 15px;
	padding: 10px 20px;
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
	border:1px solid lightgrey;
}
tr{
	height: 40px;
	border-bottom: 1px solid lightgrey;
}
td{
	width: 25%;	
	border-right: 1px solid lightgrey;
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
</style>
</script>
</head>
<body>

<div class="contain">
	<div class="left">
		<p class="inside whole" id="all">全部事务</p>
		<p class="inside not" id="notyet">未回复事务</p>
		<p class="inside fini" id="finish">已回复事务</p>
	</div>
	<div class="right">
		<button type="submit" class="input" id="">搜索</button>
		<input type="input" class="input"  placeholder="id、名称、内容、用户" />
		<table>
			<tr style="background-color: lightgrey">
				<td>序号</td>
				<td>标题</td>
				<td>咨询人</td>
				<td>操作</td>
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
</body>
<script type="text/javascript">
	$("document").ready(function(){
		$("#notyet").on("click",function(){
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
	});
</script>

</html>