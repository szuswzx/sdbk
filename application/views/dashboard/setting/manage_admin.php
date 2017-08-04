<button type="submit" class="input" id="search">搜索</button>
<input type="input" class="input" id="searchContent" placeholder="id、用户名" />
<table>
	<tr style="background-color: rgba(199, 189, 189, 0.16)">
		<td style="width: 15%;">序号</td>
		<td style="max-width:30%;">等级</td>
		<td style="width: 15%;">用户名</td>
		<td colspan="2" style="width: 20%;">操作</td>
	</tr>
	<?php foreach($admin as $row){?>
	<tr>
		<td><?php echo $row['uid'];?></td>
		<td><?php echo $row['rank'];?></td>
		<td><?php echo $row['username'];?></td>
		<td><?php 
		          if($row['rank'] < 5)
					  echo "<p class='resetBtn' style='display:inline-block;float:left;cursor: pointer;' id=".$row['uid']."><i class='fa fa-trash' style='margin-right: 5px'></i>重置密码</p>"
				           . "<p class='delBtn' style=';cursor: pointer;' id=".$row['uid']."><i class='fa fa-trash' style='margin-right: 5px'></i>删除</p>";
				  else
					  echo '权限不足';
		    ?>
		</td>
	</tr>
	<?php }?>
</table>