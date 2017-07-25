<html>
<head>
<title>更新菜单</title>
</head>
<body>
<?php echo form_open_multipart('dashboard/menu/3/'.$mid); ?>
<h5>名称</h5>
<input type="text" name="name" value="<?php echo $menudata['0']['name']; ?>" size="50" />
<h5>类型</h5>
    <select name="type">
	    <option value="">一级菜单</option>
        <option value="view">页面跳转事件（必须填写url）</option>
        <option value="click">点击响应事件（必须填写key）</option>
    </select>
<h5>链接</h5>
<input type="text" name="url" value="<?php echo $menudata['0']['url']; ?>" size="50" />
<h5>Key</h5>
<input type="text" name="key" value="<?php echo $menudata['0']['key']; ?>" size="50" />
<h5>图文消息标题</h5>
<input type="text" name="title" value="<?php echo $menudata['0']['title']; ?>" size="50" />
<h5>图文消息描述</h5>
<input type="text" name="description" value=""<?php echo $menudata['0']['description']; ?> size="50" />
<h5>图文消息图片</h5>
<input type="file" name="img" value="" size="50" />
<p><?php echo validation_errors(); ?></p>
<div><input type="submit" value="Submit" /></div>
</form>
</body>
</html>