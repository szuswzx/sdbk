<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<title>公文通-深大百科</title>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">  
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="./../public/board/board.css">

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
	<div class="searchHeaderContain">
		<div class="searchIcon">
			<i class="fa fa-mail-reply"></i>
		</div>
		<div class="searchInput">
			<input class="keyWord" type="text" placeholder="标题关键词">
		</div>
	</div>	
</div>
<div class="search_item">
</div>
</body>
</body>
<script type="text/javascript" src="./../public/board/boardJS.js">

</script>
</html>