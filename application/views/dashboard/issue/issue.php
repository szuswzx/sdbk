<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">

<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="./../public/dashboard/issue.css">
</head>
<body>

<div class="contain">
	<div class="left">
		<p class="inside whole" id="all">全部事务</p>
		<p class="inside" id="notyet">未回复事务</p>
		<p class="inside" id="finish">已回复事务</p>
	</div>
	<div class="formatWrong" id="message"></div>
	<div class="right">
		<button type="submit" class="input" id="search">搜索</button>
		<input type="input" class="input" id="searchContent" placeholder="id、名称、内容、用户" />
		<table>
			<tr style="background-color: rgba(199, 189, 189, 0.16)">
				<td style="width: 15%;">序号</td>
				<td style="max-width:30%;">标题</td>
				<td style="width: 15%;">咨询人</td>
				<td colspan="2" style="width: 20%;">操作</td>
			</tr>
			<tbody id="tbody-result">  
			<?php foreach($issue as $row){?>
			<tr>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['title'];?></td>
				<td><?php echo $row['user'];?></td>
				<td>
					<div class="replyBtn"><?php 
					          if($row['replied'] == '0')
								  echo "<p id=".$row['id']."><i class='fa fa-trash' style='margin-right: 5px'></i>回复</p>";
						?>
					</div>
					<div class="deleteBtn"><?php echo "<p class='delBtn' id=".$row['id']."><i class='fa fa-trash' style='margin-right: 5px'></i>删除</p>";?>
						
					</div>
				</td>
			</tr>
				<?php }?> 
				
			</tbody>
		</table>
		<input type="hidden" id="url" value="../dashboard/issue/all/data/">
		<input type="hidden" id="current_page" value="1">
		<div class="getMore">点击获取更多</div>
	</div>
</div>
<div class="editMask">
	<div class="edit">
		<div class="editTitle">
			回复事务<span class="close"><i class="fa fa-times-circle"></i></span>
		</div>
		<div class="editBody">
			<div class="item">
				<div class="editleft">标题</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">事务内容</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">咨询人</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">咨询人学号</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">所在单位</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">联系方式</div>
				<div class="editright"></div>
			</div>
			<div class="item">
				<div class="editleft">回复部门</div>
				<div class="editright"><input id="asso" type="text"></div>
			</div>
			<div class="item">
				<div class="editleft">回复内容</div>
				<div class="editright"><textarea id="reply" placeholder="回复些什么吧"></textarea></div>
			</div>
			<div class="item">
				<div class="editleft">回复人</div>
				<div class="editright"></div>
			</div>
			<div class="item">
			    <input type="hidden" id="issueId">
				<div class="replayBtn"><button class="submitReply">提交回复</button><span class="cancel">取消</span></div>
			</div>
		</div>
	</div>
</div>
</body>
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="./../public/dashboard/issuejs.js"></script>

</html>