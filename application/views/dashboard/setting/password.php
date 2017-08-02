<div class="rightlabel" id="result">
	<?php echo form_open('dashboard/setting'); ?>
	<div class="item"><p class="lab">原密码</p><input type="password" name="oldPwd" class="txt"></div>
	<div class="item"><p class="lab">新密码</p><input type="password" name="newPwd" class="txt"></div>
	<div class="item"><p class="lab">确认密码</p><input type="password" name="Pwd" class="txt"></div>
	<input type="hidden" name="ajax" value="ajax">	    	
	</form>
	<div class="btn"><button  id="submit" disabled="disabled" onclick="typein()">修改密码</button></div>
</div>
