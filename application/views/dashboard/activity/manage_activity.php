<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>

<table>
	<tr style="background-color: rgba(199, 189, 189, 0.16)">
		<td style="width: 15%;">序号</td>
		<td style="width: 45%;">活动名称</td>
		<td colspan="2" style="width: 30%;">操作</td>
	</tr>
	<tbody id="tbody-result">
		<?php foreach($activities as $row){?>
		<tr>
			<td id="ID"><?php echo $row['id'];?></td>
			<td id="NAME"><?php echo $row['name'];?></td>
			<td>
				<p class="link"><i class='fa fa-qrcode' style='margin-right: 5px'></i>显示连接</p>
				<p class="sendMsg"><i class='fa fa-paper-plane' style='margin-right: 5px'></i>发送消息模板</p>
				<p class="export"><i class='fa fa-mail-reply' style='margin-right: 5px'></i>导出数据</p>
				<p class="delAct"><i class='fa fa-trash' style='margin-right: 5px'></i>删除</p>
			</td>
		</tr>
		<?php }?>
	</tbody>
</table>

