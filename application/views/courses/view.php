<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>选课结果-深大百科</title>
<link href="./public/css/common.min.css" rel="stylesheet">
<link href="http://cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
<link href="./public/css/index.css" rel="stylesheet">
</head>
<body>
<div class="header">
	<div class="headimg">
		<img src="<?php echo $userinfo['headimgurl'] ?>">
	</div>
	<div class="userinfo">
		<h1><?php echo $userinfo['studentName'] ?></h1>
		<p>学号：<?php echo $userinfo['studentNo'] ?></p>
	</div>
</div>
<div class="header-bg">
	<img src="./public/images/1.jpg">
</div>
<?php
	if (count($examRes) == 0) {
?>
<div class="examPlan Emp">
	<p class="empty">暂无您的选课信息</p>
</div>
<?php
	} else {
		$i = 0;
		$score = 0;
		while ($i < count($examRes)) {
			$score += $examRes[$i]['score'];
			$i++;
		}	
?>
<a href="javascript:void(0);" class="creatImgBtn"> 共 <?php echo $score ?> 学分</a>
<div class="mainContent">
<?php
	for ($j=0; $j < count($examRes); $j++) {
?>
	<div class="examPlan">
		<div class="examTime">
			<p><?php echo $examRes[$j]['className'] ?></p>
		</div>
		<div class="examInfo">
			<p><i class="fa fa-tag title"> 课程号：</i><?php echo $examRes[$j]['classNo'] ?></p>
			<p><i class="fa fa-clock-o title"> 学分：</i><?php echo $examRes[$j]['score'] ?></p>
		</div>
	</div>
	<?php
		}
	}
	?>
</div>
<div class="footer">
	<p>以上数据由教务部提供，仅供参考</p>
	<p>若有变化，请以教务部网站公布为准</p>
	<p>查询请进入“深大快讯”底部菜单</p>
	<p><img src="./public/images/shendakuaixun.jpg" width="100px"></p>
</div>
</body>
</html>