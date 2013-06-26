function sendweibo(){
	var content = $("#weibocontent").val();
	$.post(siteUrl+'index.php?app=weibo&ac=ajax&ts=add',{'content':content},function(rs){
		if(rs==0){
			art.dialog({
				content : '请登陆后再发布微博说！',
				time : 1000
			});
		}else if(rs==1){
			art.dialog({
				content : '发布内容不能为空！',
				time : 1000
			});
		}else if(rs==2){
			
			var content = $("#weibocontent").val('');
			weibolist();
		
		}
	});
}

function weibolist(){
	$.get(siteUrl+'index.php?app=weibo&ac=ajax&ts=list',function(rs){
		$("#weibolist").html(rs);
	})
}