<html>
<head>
<title>添加管理员</title>
</head>
<body>
<?php echo form_open('dashboard/add_admin'); ?>
<h5>用户名</h5>
<input placeholder="请输入用户名" type="text" name="username" value="" size="50" />
<h5>初始密码</h5>
<input placeholder="请输入密码" type="password" name="password" value="123456" size="50" />
<h5>权限等级</h5>
<input placeholder="权限" type="text" name="rank" value="1" size="50" />
<p><?php echo validation_errors(); ?></p>
<div><input type="submit" value="Submit" /></div>
</form>
</body>
</html>