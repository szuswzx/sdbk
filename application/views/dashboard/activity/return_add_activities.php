<div class="rightlabel" id="result">
	<div class="item">
		<p class="lab">活动名称</p>
		<input type="text" id="name" name="name" class="txt" placeholder="中英文或下划线">
	</div>
	<div class="item">
		<p class="lab">开始时间</p>
		<input class="txt time" id="startTime" placeholder="请选择时间">
			
	</div>
	<div class="item">
		<p class="lab">结束时间</p>
		<input class="txt time" id="endTime" placeholder="请选择时间">
			
	</div>
	
		<!-- <div class="item" >
			<p class="lab">开始时间</p>
				<input type='text' class="txt time" id='datetimepicker4' placeholder="请选择时间">     
		</div> -->

	<!-- <div class="item">
		<p class="lab">结束时间</p>
		<div class="txt time" id="endTime">
			请选择时间
		</div>
	</div> -->

	<div class="item">
		<p class="lab">限制人数</p>
		<input type="text" id="limit" name="limit" value="0" class="txt">
		<div class="inputTips">只能为数字，0表示不限制
		</div>
	</div>
	<div class="underline"></div>
	<div class="item ps">PS：默认会保存学生的所有信息</div>


	<div class="containMsg">
		<div class="addMsg" style="display: none;">
			<div class="item" >
				<p class="lab">字段<span class="number"></span></p>
				<input type="text" class="txt" id="parameters" placeholder="字段的名称，不可放空">
			</div>
			<div class="item" >
				<p class="lab del">删除</p>
				<input type="text" class="txt" id="value" placeholder="默认值，可放空">
			</div>
		</div>
	</div>


	<button class="addParam">添加字段</button>
	<div class="btn">
		<button id="submit" disabled="disabled">发布活动</button>
	</div>
</div>