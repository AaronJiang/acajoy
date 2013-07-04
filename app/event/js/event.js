//参加或者感感兴趣
function userDoWish(eventid,status){
	$.ajax({
		type: "POST",
		url: "index.php?app=event&ac=do&ts=dowish",
		data: "eventid="+eventid+"&status="+status,
		beforeSend:function(){
		},
		success:function(result){
			if(result == '0'){
				ymPrompt.alert({message:'请登录后再进行操作^_^',title:'提示'});
			}else if(result == '1'){
				ymPrompt.alert({message:'你已经参加该活动^_^',title:'提示'});
			}else if(result == '2'){
				ymPrompt.alert({message:'参加活动成功^_^',title:'提示'});
				setTimeout(function(){ymPrompt.close()},2000);
				window.location.reload(true); 
			}
		}
	});
}

//取消参加活动
function cancelEvent(eventid,userid){
	if(confirm("确定不参加吗?")){
	$.ajax({
		type: "POST",
		url: "index.php?app=event&ac=do&ts=cancel",
		data: "eventid="+eventid+"&userid="+userid,
		beforeSend:function(){
		},
		success:function(result){
			if(result == '1'){
				ymPrompt.alert({message:'取消参加活动成功^_^',title:'提示'});
				setTimeout(function(){ymPrompt.close()},2000);
				window.location.reload(true); 
			}
		}
	});
	}
}

//参加活动
function doEvent(eventid,userid){
	$.ajax({
		type: "POST",
		url: "index.php?app=event&ac=do&ts=do",
		data: "eventid="+eventid+"&userid="+userid,
		beforeSend:function(){
		},
		success:function(result){
			if(result == '1'){
				ymPrompt.alert({message:'参加活动成功^_^',title:'提示'});
				setTimeout(function(){ymPrompt.close()},2000);
				window.location.reload(true); 
			}
		}
	});
}