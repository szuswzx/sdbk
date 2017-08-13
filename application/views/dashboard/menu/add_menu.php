<html>
<head>
<title>添加菜单</title>
</head>
<body>
<!-- <?php echo form_open_multipart('dashboard/menu/add/'.$mid); ?> -->
<h5>名称</h5>
<input placeholder="请输入菜单名称" type="text" name="name" value="" size="50" />
<h5>类型</h5>
    <select name="type">
	    <option value="">一级菜单</option>
        <option value="view">页面跳转事件（必须填写url）</option>
        <option value="click">点击响应事件（必须填写key）</option>
    </select>
<h5>链接</h5>
<input placeholder="格式为：http://......." type="text" name="url" value="" size="50" />
<h5>Key</h5>
<input placeholder="请输入key值" type="text" name="key" value="" size="50" />
<h5>图文消息标题</h5>
<input placeholder="请输入标题" type="text" name="title" value="" size="50" />
<h5>图文消息描述</h5>
<input placeholder="请输入描述" type="text" name="description" value="" size="50" />
<h5>图文消息图片</h5>
<input type="file" name="img" value="" size="50" />
<!-- <p><?php echo validation_errors(); ?></p> -->
<div><input type="submit" value="Submit" /></div>
</form>
</body>
</html>