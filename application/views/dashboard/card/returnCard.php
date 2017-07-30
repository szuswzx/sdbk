<div class="rightlabel" id="result">
<?php echo form_open('dashboard/add_card',array('id' => 'add_card')); ?>
	<div class="item"><p class="lab">学号</p><input type="text" id="studentNo" name="studentNo" class="txt" placeholder="201xxxxxxx">
	<div class="inputTips">10位校园卡号，只能为数字</div></div>
	<div class="item"><p class="lab">失主姓名</p><input type="text" name="studentName" class="txt"></div>
	<div class="item"><p class="lab">归还者姓名</p><input type="text" name="getName" class="txt"></div>
	<div class="item"><p class="lab">备注</p><textarea type="text" name="remark" class="txt" placeholder="在哪拾获，交接地点信息等" rows="10"></textarea></div>
	<input type="hidden" name="ajax" value="ajax">
	</form>
	<div class="btn"><button  id="submit" disabled="disabled" onclick="typein()">信息录入</button></div>
</div>