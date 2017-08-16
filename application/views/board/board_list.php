<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<title>公文通-深大百科</title>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">  
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style type="text/css">
*{
	padding: 0;
	margin:0;
	text-decoration: none;
}
#menu-trigger {
     display:block; 
     font-size: 20px;
     /*padding:0 20px;*/
     z-index:99999999; 
     display: inline-block;
     height:80px;
     line-height: 80px;
     cursor: pointer;
  }
.head {
     width:100%;
     height:80px;
     background:rgba(38, 181, 199, 0.85); 

 }
 .faBox{
 	width: 80px;
 	height:80px;
 	float: left;
 }
 .fa{
     width: 80px;
     height: 80px;
     padding:30px;
     color: #fff;
     font-size: 20px;
     display: inline-block;
     cursor: pointer;
 }	
 .dash{
 	color: #fff;
 	text-decoration: none;
 }
 .floa{
 	float: right;
 }
 .search{
 	display: inline-block;
 }
 .load{
 	display: inline-block;
 }

.content{
	width: 100%;
	
}
.content .board_item{
	width: 100%;
	/*height: 120px;*/
	text-align: center;
	padding: 20px 20px;
	border-bottom: 1px solid #ddd;
	position: relative;
}
.content .board_item .board_text{
	font-size: 20px;

}
.content .board_item .board_text .top{
	color: red;
}
.content .board_item .board_footer{
	display: flex;	
	justify-content: space-between;
	color: rgba(158, 158, 158, 0.77);
}

 .mask{
 	position: fixed;
 	left: 0;
 	top: 0;
 	width: 100%;
 	height: 100%;
 	background-color: rgba(158, 158, 158, 0.51);
 	z-index: 2;
 }
 .slid{
 	position: absolute;
 	left: 0;
 	top: 0;
 	width: 30%;
 	height: 100%;
 	background-color: #fff;
 	padding-top: 30px;
 }
 .slid .item{
 	width: 100%;
 	height: 60px;
 	border-bottom: 1px solid #ddd;
 	padding: 10px;
 	text-align: center;
 	line-height: 60px;
 	font-size: 15px;
 	color: #3085c7;
 	cursor: pointer;
 }
.ex_slid{
	position: absolute;
	left: 30%;
	top: 0;
	width: 70%;
	height: 100%;
	background-color: rgba(158, 158, 158, 0.51);
}
.search_in{
	position: fixed;
	left: 0;top: 0;
	width: 100%;
	height: 80px;
	background-color: #fff;
	z-index: 99;
}
.bg{
	background-color: rgba(38, 181, 199, 0.85);
	width: 100%;
	height: 80px;
	padding: 20px;
}
.keyWord{
	width: 100%;
	height: 100%;
	border-radius: 5px;
	background-color: #fff;
}
</style>

</head>
<body>
<div class="contain">

	<div class="head">
		<div id="menu-trigger">
			<div class="faBox">
				<i class="fa fa-bars"></i>
			</div>
			<span class="dash">公文通</span>
		</div>
		<div class="floa">
			<div class="search"><i class="fa fa-search"></i></div>
			<div class="load"><i class="fa fa-refresh"></i></div>
		</div>	
	</div>

	<div class="content">
	    <?php foreach($fixed_board as $row){?>
		<div id="<?php echo $row['aid'];?>" class="board_item">
			<div class="board_text">
				<span class="top">【置顶】</span><?php echo $row['title']?>
			</div>
			<div class="board_footer">
				<div><?php echo $row['type']."|".$row['department']?></div>
				<div><?php echo $row['date']?></div>
			</div>
		</div>
		<?php }?>
	    <?php foreach($board as $row){?>
		<div id="<?php echo $row['aid'];?>" class="board_item">
			<div class="board_text">
				<?php echo $row['title']?>
			</div>
			<div class="board_footer">
				<div><?php echo $row['type']."|".$row['department']?></div>
				<div><?php echo $row['date']?></div>
			</div>
		</div>
		<?php }?>
	</div>
</div>
<div class="mask" id="mask" style="display: none;">
	<div class="slid">
		<div class="item">全部消息</div>
		<div class="item">教学教务</div>
		<div class="item">学术研究</div>
		<div class="item">行政通知</div>
		<div class="item">学生工作</div>
		<div class="item">校园生活</div>
	</div>
	<div class="ex_slid"></div>
</div>

<div class="search_in" style="display: none;">
	<div class="bg">
		<input class="keyWord" type="text" placeholder="标题关键词">
	</div>
</div>
</body>
<script type="text/javascript">
$(function(){
    var type = "全部";
	var page = 2;
	var getMoreUrl = getMoreUrl = 'board_list/data/';
	var keyword = "";
	
	$('#menu-trigger').click(function(){
		$('.mask').show();
	});
	$('.ex_slid').on('click',function(){
		$('.mask').hide();
	});
	
	$('.load').on('click',function(){      //refresh
		window.location.href="board_list";
	});		
	
	$('.mask').on('click', '.item',function(){      //load by type
		type = $(this).html();
		page = 2;
		getMoreUrl = 'board_list/data/';
		if(type == "全部消息")
			type = "全部";
		else if(type == "教学教务")
			type = "教务";
		else if(type == "学术研究")
			type = "学术";
		else if(type == "行政通知")
			type = "行政";
		else if(type == "学生工作")
			type = "学工";
		else if(type == "校园生活")
			type = "校园";
		
		$.ajax({
			type: 'post',
			url: 'board_list/data',
			data: {type:type},
			dataType : 'json',
			beforeSend: function(){
				//$('.loading').show();         //增加一个正在加载的div,弹出
			},
			success: loadboard,
			error: function() {
				alert('error');
            },
			complete: function(){
				//$('.loading').hide();         //隐藏一个正在加载的div
			}
		});
		$('.mask').hide();
	});

	$('.search').on('click',function(){    //search board
		$('.search_in').show();
		$('.content').empty();
		getMoreUrl = 'search_board/';
	});
	$('.keyWord').on('input', function(){
		keyword = $('.keyWord').val();
		page = 2;
		$.ajax({
			type: 'post',
			url: 'search_board',
			data: {keyword:keyword},
			dataType : 'json',
			beforeSend: function(){
				//$('.loading').show();         //增加一个正在加载的div,弹出
			},
			success: loadboard,
			error: function() {
				alert('error');
            },
			complete: function(){
				//$('.loading').hide();         //隐藏一个正在加载的div
			}
		});
	});
	
	$('.content').on('click', '.board_item', function(){   
		var aid = $(this).attr('id');
		window.location.href="fetch_article/"+aid;
	});	
	
	$(window).scroll(function () {  //下拉加载更多
		if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
			$.ajax({
				type: 'post',
				url: getMoreUrl+page,
				data: {type:type,keyword:keyword},
				dataType : 'json',
				beforeSend: function(){
					//$('.loading').show();         //增加一个正在加载的div,弹出
				},
				success: function(json){
					var str = "";
					for(var i=0;i<json.length;i++)
					{
						str += "<div id="+json[i]['aid']+" class='board_item'>"+
									"<div class='board_text'>"+json[i]['title']+"</div>"+
									"<div class='board_footer'>"+
									"<div>"+json[i]['type']+"|"+json[i]['department']+"</div>"+
									"<div>"+json[i]['date']+"</div>"+
									"</div>"+
							   "</div>";					
					}
					if(json.length != 0)
						page++;
					$('.content').append(str);
				},
				error: function() {
					alert('error');
				},
				complete: function(){
					//$('.loading').hide();         //隐藏一个正在加载的div
				}
			});			
		}
	});
	function loadboard(json){
		$('.content').empty();
		var fixed_str = "";
		var str = "";
		for(var i=0;i<json.length;i++)
		{
			if(json[i]['fixed'] == '1')
			{
				fixed_str += "<div id="+json[i]['aid']+" class='board_item'>"+
							"<div class='board_text'><span class='top'>【置顶】</span>"+json[i]['title']+"</div>"+
							"<div class='board_footer'>"+
							"<div>"+json[i]['type']+"|"+json[i]['department']+"</div>"+
							"<div>"+json[i]['date']+"</div>"+
							"</div>"+
					   "</div>";
			}
			else
			{
				str += "<div id="+json[i]['aid']+" class='board_item'>"+
							"<div class='board_text'>"+json[i]['title']+"</div>"+
							"<div class='board_footer'>"+
							"<div>"+json[i]['type']+"|"+json[i]['department']+"</div>"+
							"<div>"+json[i]['date']+"</div>"+
							"</div>"+
					   "</div>";
			}						
		}
		$('.content').append(fixed_str);
		$('.content').append(str);
	}
});	
</script>
</html>