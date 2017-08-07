<table>
	<tr style="background-color: rgba(199, 189, 189, 0.16)">
		<td style="width: 20%;">序号</td>
		<td style="width: 50%;">活动名称</td>
		<td colspan="2" style="width: 20%;">操作</td>
	</tr>
	<?php foreach($activities as $row){?>
	<tr>
		<td><?php echo $row['id'];?></td>
		<td><?php echo $row['name'];?></td>
		<td>
			<p class="link">显示连接</p>
			<p class="sendMsg">发送消息模板</p>
			<p class="export">导出数据</p>
			<p class="del">删除</p>
		</td>
	</tr>
	<?php }?>
</table>