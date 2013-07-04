	//显示和隐藏
	function viewcontent(){
		$("#displaycontent").toggle();
		$("#displaytitle").hide();
	}
	//显示和隐藏
	function closecontent(){
		$("#displaycontent").hide();
		$("#displaytitle").toggle();
	}
	
//加入小组Ajax
function joinGroup(groupid){
	$.ajax({
		type: "POST",
		url: "index.php?app=group&ac=do&ts=joingroup",
		data: "&groupid=" + groupid,
		beforeSend: function(){},
		success: function(result){
			if(result == '0'){
				ymPrompt.alert({message:'<br>请登陆后再加入小组^_^',title:'提示'});
			}else if(result == '1'){
				ymPrompt.alert({message:'<br>你已经加入该小组，请不要再次加入^_^',title:'提示'});
			}else if(result == '2'){
				ymPrompt.alert({message:'<br>加入小组成功^_^',title:'提示'});setTimeout(function(){ymPrompt.close()},2000);
				window.location.reload(true); 
			}
		}
	});
}

//退出小组Ajax
function exitGroup(groupid){
	if(confirm("确定退出吗?")){
		$.ajax({
			type: "POST",
			url: "index.php?app=group&ac=do&ts=exitgroup",
			data: "&groupid=" + groupid,
			beforeSend: function(){},
			success: function(result){
				if(result == '0'){
					ymPrompt.alert({message:'<br>组长责任重于泰山，请为你的会员负责到底哦^_^',title:'提示'});setTimeout(function(){ymPrompt.close()},2000);
					
				}else if(result == '1'){
					ymPrompt.alert({message:'<br>退出小组成功^_^',title:'提示'});setTimeout(function(){ymPrompt.close()},2000);
					window.location.reload(true); 
				}
			}
		});
	}
}

//进入发帖页面
function newTopic(groupid,shapeid){
	$.ajax({
		type: "POST",
		url: "index.php?app=group&ac=new_topic",
		data: "&groupid=" + groupid,
		beforeSend: function(){},
		success: function(result){
			if(result == '0'){
				ymPrompt.alert({message:'<br>未登陆不能发帖子^_^',title:'提示'});
			}else if(result == '1'){
				ymPrompt.alert({message:'<br>坏蛋加笨蛋的你是永远不能得逞滴^_^',title:'提示'});setTimeout(function(){ymPrompt.close()},2000);
			}else if(result == '2'){
				ymPrompt.alert({message:'<br>不是本小组成员不能发帖子^_^',title:'提示'});
			}else if(result == '3'){
				ymPrompt.alert({message:'<br>本小组仅限组长和管理员发帖，会员可以评论^_^',title:'提示'});setTimeout(function(){ymPrompt.close()},2000);
			}else{
				window.location.href = "index.php?app=group&ac=new_topic&groupid="+groupid+"&shapeid="+shapeid;
			}
		}
	});
}

//添加小组分类索引
function addgroupcateindex(groupid,cateid){
	$.ajax({
		type: "POST",
		url: "index.php?app=group&ac=do&ts=addgroupcateindex",
		data: "&groupid=" + groupid+"&cateid="+cateid,
		beforeSend: function(){},
		success: function(result){
			if(result == '0'){
				ymPrompt.alert({message:'<br>添加分类成功!',title:'提示'});setTimeout(function(){ymPrompt.close()},2000);
				window.location.href = "index.php?app=group&ac=edit_group&groupid="+groupid+"&ts=cate";
			}else if(result == '1'){
				ymPrompt.alert({message:'<br>出现异常，请报告管理员!',title:'提示'});setTimeout(function(){ymPrompt.close()},2000);
			}
		}
	});
}

//获取帖子的附件
function getAttachByTopicId(topicid){
	$.ajax({
		type: "GET",
		url:  "index.php?app=group&ac=topic_attach&ts=topic_attach_list&topicid="+topicid,
		success: function(msg){
			$('#showAttach').html(msg);
		}
	});
}

//删除帖子评论
function comment_del(topicid,commentid){
	
	if(confirm("确定删除吗?")){
		$.ajax({
			type: "POST",
			url: "index.php?app=group&ac=do&ts=comment_del",
			data: "topicid="+topicid+"&commentid="+commentid,
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

//删除帖子
function topic_del(groupid,topicid){
	
	if(confirm("确定删除吗?")){
		$.ajax({
			type: "POST",
			url: "index.php?app=group&ac=do&ts=topic_del",
			data: "groupid="+groupid+"&topicid="+topicid,
			beforeSend:function(){
			},
			success:function(result){
				if(result == '0'){
					alert('删除成功！');
					window.location.href('index.php?app=group&ac=group&groupid='+groupid);
				}
			}
		});
	}
	
}

//收藏帖子
function topic_collect(topicid){
	$.ajax({
		type: "POST",
		url: "index.php?app=group&ac=do&ts=topic_collect",
		data: "topicid="+topicid,
		beforeSend:function(){
		},
		success:function(result){
			if(result == '0'){
				ymPrompt.alert({message:'<br>请登陆后再收藏帖子^_^',title:'提示'});
			}else if(result == '1'){
				ymPrompt.alert({message:'<br>自己不能收藏自己的帖子哦^_^',title:'提示'});
			}else if(result == '2'){
				ymPrompt.alert({message:'<br>你已经收藏过本帖啦，请不要再次收藏^_^',title:'提示'});
			}else if(result == '3'){
				ymPrompt.alert({message:'<br>恭喜您，帖子收藏成功^_^',title:'提示'});
				topic_collect_user(topicid);
			}
		}
	});
}

//谁收藏了这篇帖子
function topic_collect_user(topicid){
	$.ajax({
		type: "GET",
		url:  "index.php?app=group&ac=topic_collect_user&ts=ajax&topicid="+topicid,
		success: function(msg){
			$('#collects').html(msg);
		}
	});
}

//置顶帖子
function topic_istop(topicid,istop){

	if(istop=='1'){
		var ismsg= '置顶';
	}else if(istop=='0'){
		var ismsg='取消置顶';
	}

	$.ajax({
		type: "POST",
		url: "index.php?app=group&ac=do&ts=topic_istop",
		data: "topicid="+topicid+"&istop="+istop,
		beforeSend:function(){
		},
		success:function(result){
			if(result == '0'){
				ymPrompt.alert({message:'<br>'+ismsg+'成功^_^',title:'提示'});
				window.location.reload(true);
			}
		}
	});
}

//是否垃圾回收
function topic_isshow(topicid,isshow){

	if(isshow=='1'){
		var ismsg= '隐藏';
	}else if(isshow=='0'){
		var ismsg='显示';
	}

	$.ajax({
		type: "POST",
		url: "index.php?app=group&ac=do&ts=topic_isshow",
		data: "topicid="+topicid+"&isshow="+isshow,
		beforeSend:function(){
		},
		success:function(result){
			if(result == '0'){
				ymPrompt.alert({message:'<br>'+ismsg+'成功^_^',title:'提示'});
				window.location.reload(true);
			}
		}
	});
}

//插入图片
function insertImg(photoid){
	tb_remove();
	insertAtCursor(document.getElementById('editor_content'),'[photo='+photoid+']');
}
//插入表情
function insertExpress(expressid){
	//tb_remove();
	insertAtCursor(document.getElementById('editor_content'),expressid);
}
//插入外部图片 
function insertImgs(imgurl){
	tb_remove();
	insertAtCursor(document.getElementById('editor_content'),'[img]'+imgurl+'[/img]');
}
//插入网络视频 
function insertFlash(flashurl){
	tb_remove();
	insertAtCursor(document.getElementById('editor_content'),'[flash]'+flashurl+'[/flash]');
}
//插入网络音乐 
function insertMusic(musicurl){
	tb_remove();
	insertAtCursor(document.getElementById('editor_content'),'[music]'+musicurl+'[/music]');
}

//插入网络链接
function insertLink(linkurl){
	tb_remove();
	insertAtCursor(document.getElementById('editor_content'),'[url]'+linkurl+'[/url]');
}


// 在光标处插入字符串 
// myField 文本框对象 
// 要插入的值 
function insertAtCursor(myField, myValue) 
{ 
	//IE support 
	if (document.selection) { 
		myField.focus(); 
		sel = document.selection.createRange(); 
		sel.text = myValue; 
		sel.select(); 
	} 
	//MOZILLA/NETSCAPE support 
	else if (myField.selectionStart || myField.selectionStart == '0') { 
		var startPos = myField.selectionStart; 
		var endPos = myField.selectionEnd; 
		// save scrollTop before insert 
		var restoreTop = myField.scrollTop; 
		myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos,myField.value.length); 
		if (restoreTop > 0) { 
			// restore previous scrollTop 
			myField.scrollTop = restoreTop; 
		} 
		myField.focus(); 
		myField.selectionStart = startPos + myValue.length; 
		myField.selectionEnd = startPos + myValue.length; 
	} else { 
		myField.value += myValue; 
		myField.focus(); 
	} 
} 