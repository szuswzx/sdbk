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
	margin: 0;
}
.header{
	text-align: center;
	padding: 30px;
	width: 100%;
	font-size: 22px;
	background-color: #408ec0;
	color: #fff;
}
.rtn_btn{
	width: 100px;
	background-color: #408ec0;
	display: inline-block;
	cursor: pointer;
}
.header .cate{
	color: rgba(0,0,0,.54);
	font-size: 12px;
	color: rgba(224, 207, 207, 0.75);

}
.article{
	width: 90%;
	margin:20px auto;
	background-color: #fff;
	padding: 20px;
	font-size: 16px;
	border-radius: 5px;
	box-shadow: 1px 3px 3px rgba(0,0,0,.2),0 0 3px rgba(0,0,0,.2) inset;
	justify-content: center;
}
.act_p{
	line-height: 2em;
	color: #655757;
}
.atc_right{
	text-align: right;
	font-size: 15px;
	color: #655757;
}
.ex_file{
	width: 90%;
	margin-top: 10px;
	background: #fff;
	box-shadow: 1px 3px 3px rgba(0,0,0,.2),0 0 3px rgba(0,0,0,.2) inset;
	padding: 20px;
	margin: auto;

}
.ex_file_msg{
	border-bottom: 1px solid lightgrey;
	padding: 10px;
	color: rgb(138, 130, 130);
}
.footer{
	width: 100%;
	text-align: center;
	font-size: 12px;
	color: #ccc;
	text-shadow: 0 1px 0 #fff;
	margin: 20px;
}
</style>

</head>
<body>

<div class="header">
	<div class="rtn_btn"><i class="fa fa-mail-reply"></i></div>
	<?php echo $article['title'];?>
	<div class="cate">
			<p><?php echo $article['department']." | ".$article['releasetime'];?></p>
	</div>
</div>
	<div class="article">
		<p class="act_p"><?php echo $article['article'];?></p>
	</div>
	</div>	
	<?php if($attachment)
	{
		echo "<div class='ex_file'>";
		echo "<p class='ex_file_msg'>附件：</p>";
		foreach($attachment as $row)
		{
			echo "<p class='ex_file_msg'><a href='".$row['url']."'>".$row['name']."</a></p>";
		}
		echo "</div>";
	}?>
	<div class="footer">
		<p>深大百科</p>
	</div>	
</body>
 <script type="text/javascript">
jQuery(function () {
	$('.rtn_btn').on('click',function(){
		window.location.href="../board_list";
	});		
});
</script>
</html>