<html>
<head>
<title>添加校园卡</title>
</head>
<body>
<?php echo form_open('dashboard/add_card'); ?>
<h5>学号</h5>
<input placeholder="201xxxxxxx" type="text" name="studentNo" value="" size="50" />
<h5>失主姓名</h5>
<input type="text" name="studentName" value="" size="50" />
<h5>拾获者姓名</h5>
<input type="text" name="getName" value="" size="50" />
<h5>备注</h5>
<input placeholder="在哪拾获，交接地点信息等" type="text" name="remark" value="" size="50" />
<p><?php echo validation_errors(); ?></p>
<div><input type="submit" value="Submit" /></div>
</form>
</body>
</html>