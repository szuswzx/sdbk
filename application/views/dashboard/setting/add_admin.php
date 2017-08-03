<div class="rightlabel" id="result">
	<?php echo form_open('dashboard/add_admin',array('id' => 'add_admin')); ?>
	<div class="item">
	<p class="lab">用户名</p>
	<input type="text" id="username" name="username" placeholder="请输入用户名" class="txt">
	<div class="tips">登录和显示的用户名，推荐使用学号</div>
	</div>
	<div class="item"><p class="lab">初始密码</p><input type="password" id="password" name="password" value="123456" class="txt"><div class="tips">默认为123456，可手动制定</div></div>
	<div class="item"><p class="lab">账户等级</p><input type="text" id="rank" name="rank" value="1" class="txt"><div class="tips">默认为1，数字越大权限越多，最多为5.填写超过5默认为5</div></div>
	<input type="hidden" name="ajax" value="ajax">	    	
	</form>
	<div class="btn"><button  id="submit" disabled="disabled" onclick="add_admin()">添加管理员</button></div>
</div>
