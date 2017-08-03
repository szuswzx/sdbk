<div class="rightlabel" id="result">
	<?php echo form_open('dashboard/setting',array('id' => 'change_pass')); ?>
	<div class="item"><p class="lab">原密码</p><input type="password" id="oldPwd" name="oldPwd" class="txt"></div>
	<div class="item"><p class="lab">新密码</p><input type="password" id="newPwd" name="newPwd" class="txt"></div>
	<div class="item"><p class="lab">确认密码</p><input type="password" id="Pwd" name="Pwd" class="txt"></div>
	<input type="hidden" name="ajax" value="ajax">	    	
	</form>
	<div class="btn"><button  id="submit" disabled="disabled" onclick="change_password()">修改密码</button></div>
</div>
