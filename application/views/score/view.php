<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>成绩查询 - 深大百科</title>
    <link href="./public/score/css/common.min.css" rel="stylesheet">
    <link href="./public/score/css/index.css" rel="stylesheet">
</head>
<body>
    <header>
        <p><?php echo $userinfo['studentName']; ?> 同学，你本学期的绩点是：</p>
        <h1><?php echo $point; ?></h1>
        <p class="encourage">下学期再接再厉哦！</p>
    </header>
    <button class="generateBtn" onclick="window.location.href='<?php echo base_url('/score/create_scoreimg');?>'">保存成绩单为图片</button>
    <div class="list">
        <?php foreach ($scoreList as $item):
            $DJCJcss = str_replace('+', 'P', $item['DJCJ']);
        ?>
            <div class="item <?php echo $DJCJcss ?>">
                <div class="itemInfo">
                    <p>课程名：<?php echo $item['KCMC'] ?></p>
                    <p>课程号：<?php echo $item['KCH'] ?></p>
                    <p>学分：<?php echo $item['XF'] ?></p>
                    <p>课程类别：<?php echo $item['KCLB_A'] ?></p>
                    <?php if ($item['SFXX'] && $studentNo > 2015000000): ?>
                        <p>培养方案认定类别：<?php echo $item['SFXX'] ?></p>
                    <?php endif ?>
                </div>
                <div class="itemGrade">
                    <h1><?php echo $item['DJCJ'] ?></h1>
                </div>
                <div style="clear:both"></div>
            </div>
        <?php endforeach ?>
    </div>
    <footer>
        <p>以上数据由教务部提供，仅供参考</p>
	    <p>若有变化，请以教务部网站公布为准</p>
	    <p>查询请进入“深大快讯”底部菜单</p>
	    <p><img src="./public/images/shendakuaixun.jpg" width="100px"></p>
    </footer>
</body>
</html>