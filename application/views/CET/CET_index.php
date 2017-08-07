<!DOCTYPE html>
<html>
<head> 
	<title>CET</title>
</head>
<body>
		
	<form action="<?php echo site_url('cet/send')  ?>" method="POST" enctype="multipart/form-data">
	<!-- 用POST方法传参到send函数 -->
		<tr>
			<td colspan="10">查找</td>
			</tr><hr>
		
			<td>学号</td>
			<td>
			
			<input 

			type="text" 

			name="id"  

			value="<?php echo set_value('id') ?>" />
			
			<?php echo form_error('id', '<span>', '</span>')?>
			</td>
		</tr>
		<tr>
			<td colspan="10"><input type="submit" class="input_button"></td>
		</tr>

		</table>
	</form>
</body>
</html>