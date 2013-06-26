//前端安全过滤
$.get(siteUrl+'index.php?app=user&ac=anti',function(rs){})

//Input提示
$(function(){
	$('[fs]').inputDefault();
});

//搜索 
function searchon(){
	$("#searchto").click();
}

//加关注
function follow(userid){
	$.getJSON(siteUrl+'index.php?app=user&ac=follow&ts=do',{'userid':userid},function(json){
		if(json.status==0){
			art.dialog({
				content : json.msg,
				time : 1000
			});
		}else if(json.status==1){
			art.dialog({
				content : json.msg,
				time : 1000
			});
		}else if(json.status==2){
			art.dialog({
				content : json.msg,
				time : 1000
			});
			window.location.reload()
		}
	})
}

//取消关注
function unfollow(userid){
	$.getJSON(siteUrl+'index.php?app=user&ac=follow&ts=un',{'userid':userid},function(json){
		if(json.status==0){
			art.dialog({
				content : json.msg,
				time : 1000
			});
		}else if(json.status==1){
			art.dialog({
				content : json.msg,
				time : 1000
			});
			window.location.reload()
		}
	})
}

/*视频弹出或隐藏播放*/
function showVideo(id,url)
{
	 if($('#play_'+id).is(":hidden")){
		  $('#swf_'+id).html('<object width="500" height="420" id="swf_'+id+'"><param name="allowscriptaccess" value="always"></param><param name="wmode" value="window"></param><param name="movie" value="'+url+'"></param><embed src="'+url+'" width="500" height="420" allowscriptaccess="always" wmode="window" type="application/x-shockwave-flash"></embed></object>')
		  $('#play_'+id).show();
	 }else{
		$('#swf_'+id).find('object').remove();
		$('#play_'+id).hide();
	 }
	$('#img_'+id).toggle();
}