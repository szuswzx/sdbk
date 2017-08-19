$(function(){
    var type = "全部";
	var page = 2;
	var getMoreUrl = getMoreUrl = 'board_list/data/';
	var keyword = "";
	
	$('#menu-trigger').click(function(){
		$('.mask').fadeIn();
		$('.slid').addClass('slid_in');
		$('.ex_slid').addClass('ex_slid_out');
	});
	$('.ex_slid').on('click',function(){
		$('.slid').removeClass('slid_in');
		$('.ex_slid').removeClass('ex_slid_out');
			$('.mask').fadeOut();
		
	});
	

	$('.load').on('click',function(){      //refresh
		window.location.href="board_list";
	});		
	
	$('.mask').on('click', '.item',function(){      //load by type
		type = $(this).html();
		page = 2;
		getMoreUrl = 'board_list/data/';
		if(type == "全部消息")
			type = "全部";
		else if(type == "教学教务")
			type = "教务";
		else if(type == "学术研究")
			type = "学术";
		else if(type == "行政通知")
			type = "行政";
		else if(type == "学生工作")
			type = "学工";
		else if(type == "校园生活")
			type = "校园";
		
		$.ajax({
			type: 'post',
			url: 'board_list/data',
			data: {type:type},
			dataType : 'json',
			beforeSend: function(){
				//$('.loading').show();         //增加一个正在加载的div,弹出
			},
			success: loadboard,
			error: function() {
				alert('error');
            },
			complete: function(){
				//$('.loading').hide();         //隐藏一个正在加载的div
			}
		});
		$('.mask').hide();
	});

	$('.search').on('click',function(){    //search board
		$('.contain').hide();
		// $('.search_in').show();
		$('.wrap').show();
		$('.content').empty();
		getMoreUrl = 'search_board/';
	});
	// $('.keyWord').on('input', function(){
	// 	keyword = $('.keyWord').val();
	// 	page = 2;
	// 	$.ajax({
	// 		type: 'post',
	// 		url: 'search_board',
	// 		data: {keyword:keyword},
	// 		dataType : 'json',
	// 		beforeSend: function(){
	// 			//$('.loading').show();         //增加一个正在加载的div,弹出
	// 		},
	// 		success: loadboard,
	// 		error: function() {
	// 			alert('error');
 //            },
	// 		complete: function(){
	// 			// $('.loading').hide();         //隐藏一个正在加载的div
	// 		}
	// 	});
	// });


	// function show(str){
	// 	// keyword = $('.keyWord').val();
	// 	page = 2;
	// 	$.ajax({
	// 		type: 'post',
	// 		url: 'search_board',
	// 		data: {str:keyword},
	// 		dataType : 'json',
	// 		beforeSend: function(){
	// 			//$('.loading').show();         //增加一个正在加载的div,弹出
	// 		},
	// 		success: loadboard,
	// 		error: function() {
	// 			alert('error');
 //            },
	// 		complete: function(){
	// 			// $('.loading').hide();         //隐藏一个正在加载的div
	// 		}
	// 	});
	// }


	$('.searchIcon').on('click',function(){    //search_return_btn
		window.location.reload();
	})


	$('.content').on('click', '.board_item', function(){   
		var aid = $(this).attr('id');
		window.location.href="fetch_article/"+aid;
	});	
	
	$(window).scroll(function () {  //下拉加载更多
		if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
			$.ajax({
				type: 'post',
				url: getMoreUrl+page,
				data: {type:type,keyword:keyword},
				dataType : 'json',
				beforeSend: function(){
					//$('.loading').show();         //增加一个正在加载的div,弹出
				},
				success: function(json){
					var str = "";
					for(var i=0;i<json.length;i++)
					{
						str += "<div id="+json[i]['aid']+" class='board_item'>"+
									"<div class='board_text'>"+json[i]['title']+"</div>"+
									"<div class='board_footer'>"+
									"<div>"+json[i]['type']+"|"+json[i]['department']+"</div>"+
									"<div>"+json[i]['date']+"</div>"+
									"</div>"+
							   "</div>";					
					}
					if(json.length != 0)
						page++;
					$('.content').append(str);
				},
				error: function() {
					alert('error');
				},
				complete: function(){
					//$('.loading').hide();         //隐藏一个正在加载的div
				}
			});			
		}
	});
	function loadboard(json){
		$('.content').empty();
		var fixed_str = "";
		var str = "";
		for(var i=0;i<json.length;i++)
		{
			if(json[i]['fixed'] == '1')
			{
				fixed_str += "<div id="+json[i]['aid']+" class='board_item'>"+
							"<div class='board_text'><span class='top'>【置顶】</span>"+json[i]['title']+"</div>"+
							"<div class='board_footer'>"+
							"<div>"+json[i]['type']+"|"+json[i]['department']+"</div>"+
							"<div>"+json[i]['date']+"</div>"+
							"</div>"+
					   "</div>";
			}
			else
			{
				str += "<div id="+json[i]['aid']+" class='board_item'>"+
							"<div class='board_text'>"+json[i]['title']+"</div>"+
							"<div class='board_footer'>"+
							"<div>"+json[i]['type']+"|"+json[i]['department']+"</div>"+
							"<div>"+json[i]['date']+"</div>"+
							"</div>"+
					   "</div>";
			}						
		}
		$('.content').append(fixed_str);
		$('.content').append(str);
	}
});	