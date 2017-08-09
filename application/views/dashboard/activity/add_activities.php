<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./../public/dashboard/activities.css">
<link rel="stylesheet" href="../public/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">

</head>
<body>
<div class="contain">
	<div class="left">
		<p class="inside im" id="addAct">添加活动</p>
		<p class="inside" id="adminAct">管理活动</p>
	</div>
	<div class="formatWrong" id="message"></div>
	<div class="right">
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

	</div>
</div>
<div class="editMask">
	<div class="edit">
		<div class="editTitle">
			发送模板<span class="close"><i class="fa fa-times-circle"></i></span>
		</div>
		<div class="editBody">
			<div class="item">
				<div class="editleft">活动名称</div>
				<div class="editright"><input id="actName" type="text"></div>
			</div>
			<div class="item">
				<div class="editleft">活动时间</div>
				<div class="editright"><input id="actTime" type="text" placeholder="活动举办时间"></div>
			</div>
			<div class="item">
				<div class="editleft">活动地点</div>
				<div class="editright"><input id="actSpace" type="text" placeholder="活动举办地点"></div>
			</div>
			<div class="item">
				<div class="editleft">备注</div>
				<div class="editright"><input id="remark" type="text" placeholder="模板消息推送中的备注"></div>
			</div>
			<div class="item">
				<div class="editleft">选中学生</div>
				<div class="editright"><textarea id="student" type="text" placeholder="选中的学生的学号，多个学生用英文的逗号分隔开，如：2014150001,2014150002（全部选中请填写为英文小写的all）"></textarea></div>
			</div>			
			<div class="item">
				<input type="hidden" id="actId">
				<div class="replayBtn"><button class="submitReply">发送</button><span class="cancel">取消</span></div>
			</div>
		</div>
	</div>
</div>
<div class="_editMask">
	<div class="_edit">
		<div class="_editTitle">
			链接<span class="close"><i class="fa fa-times-circle"></i></span>
		</div>
		<div class="editImg">
			<img src="" >
		</div>
		<div class="footer">
		</div>
	</div>
</div>
</body>
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../public/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="./../public/dashboard/activitiesJS.js"></script>
</html>