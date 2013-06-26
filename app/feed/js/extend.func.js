function showcomment(feedid){
	
	$.get(siteUrl+'index.php?app=feed&ac=comment&ts=show',{'feedid':feedid},function(rs){
	
		$("#commentshow"+feedid).html(rs)
	
	})
	
}

function hidecomment(feedid){
	$("#commentshow"+feedid).html('')
}


function tocomment(feedid){

	var content = $("#fcontent").val();

	if(content == ''){
		art.dialog({
			content : '评论内容不能为空！',
			time : 1000
		});
		return false;
	}
	
	$.post(siteUrl+'index.php?app=feed&ac=comment&ts=add',{'feedid':feedid,'content':content},function(rs){
		if(rs==0){
			art.dialog({
				content : '请登陆后再评论！',
				time : 1000
			})
		}else if(rs==1){
			art.dialog({
				content : '评论内容不能为空！',
				time : 1000
			})
		}else if(rs==2){
		
			showcomment(feedid)
		
		}
	})

}