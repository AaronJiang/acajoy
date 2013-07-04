//删除小组
function group_del(groupid){
	
	if(confirm("确定删除吗?")){
		$.ajax({
			type: "POST",
			url: "index.php?app=group&ac=admin&mg=group&ts=del",
			data: "groupid="+groupid,
			beforeSend:function(){
			},
			success:function(result){
				if(result == '0'){
					alert('删除成功！');
					window.location.reload(true); 
				}
			}
		});
	}
	
}

//话题显示和隐藏
function topicisshow(topicid,isshow){
	$.ajax({
		type: "POST",
		url: "index.php?app=group&ac=admin&mg=topic&ts=isshow",
		data: "topicid="+topicid+'&isshow='+isshow,
		beforeSend:function(){
		},
		success:function(result){
			if(result == '0'){
				window.location.reload(true); 
			}
		}
	});
}

//删除帖子 
function deltopic(topicid){
	if(confirm("确定删除吗?")){
		$.ajax({
			type: "POST",
			url: "index.php?app=group&ac=admin&mg=topic&ts=del",
			data: "topicid="+topicid,
			beforeSend:function(){
			},
			success:function(result){
				if(result == '1'){
					alert('删除成功！');
					window.location.reload(true); 
				}
			}
		});
	}
}