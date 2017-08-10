<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>

<table>
	<tr style="background-color: rgba(199, 189, 189, 0.16)">
		<td style="width: 12%;">ID</td>
		<td style="max-width:18%;">学号</td>
		<td style="width: 20%;">姓名</td>
		<td style="width: 20%;">卡号</td>
		<td colspan="2" style="width: 20%;">操作</td>
	</tr>
	<?php foreach($bind_user as $row){?>
	<tr>
		<td id='userid'><?php echo $row['userid'];?></td>
		<td><?php echo $row['studentNo'];?></td>
		<td><?php echo $row['studentName'];?></td>
		<td><?php echo $row['icAccount'];?></td>
		<td class="unbind"><p>不再推送</p></td>
	</tr>
	<?php }?>
</table>

