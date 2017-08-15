<!DOCTYPE html>
<html>
<head>
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
	height: 100%;
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
		<div class="board_item">
			<div class="board_text">
				<span class="top">【置顶】</span>这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通
			</div>
			<div class="board_footer">
				<div>学术|科学技术部</div>
				<div>2017-8-15</div>
			</div>
		</div>
		<div class="board_item">
			<div class="board_text">
				<span class="top">【置顶】</span>这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通
			</div>
		</div>
		<div class="board_item">
			<div class="board_text">
				<span class="top">【置顶】</span>这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通这是第一条公文通
			</div>
		</div>
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

	$('#menu-trigger').click(function(){
		$('.mask').show();
	})
	$('.ex_slid').on('click',function(){
		$('.mask').hide();
	})

	$('.search').on('click',function(){
		$('.search_in').show();
	})

})
	
</script>
</html>