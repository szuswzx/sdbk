<html>
    <head>
	    <title>深大百科菜单</title> 
	</head>
	<body>
<?php
if(isset($error) && $error =='1')
{
	echo $error_message."<br>";//弹窗？？？？？？？
}
else if(isset($error) && $error =='0')
{
	echo "菜单操作更新成功，微信端菜单更新会有点延迟哦，请耐心等候<br>";
}
$i=0;
foreach ($menudata as $row)
{
if($row['previous'] == 0)
{
	$first[$i] = $row;
	$i++;
}
}
for($j = 0;$j < $i;$j++)
{
echo $first[$j]['name'];
?>
<p><a href="<?php echo site_url('dashboard/menu/1/'.$first[$j]['mid']); ?>">添加菜单</a></p>
<?php
foreach ($menudata as $row)
{
if($row['previous'] == $first[$j]['mid']){
echo $row['name'];
echo $row['url']."<br>";
}
}
echo "<br>";
}
?>

        <em>&copy; 2017</em>
    </body>
</html>
