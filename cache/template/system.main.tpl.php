<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<script src="public/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$.getJSON("http://www.acajoy.cn/index.php?app=notice&ac=new&callback=?", 
	function(data){
		$.each(data, function(i,item){
			$("#admindex_msg table").append("<tr><td width='100'>"+item.time+"</td><td><a href=\""+item.url+"\" target=\"_blank\">"+item.title+"</a></td></tr>");
		});
	});   
});
function upgradeClick(upapp,upversion){
	$("#upgrade").html('<img src="<?php echo SITE_URL;?>public/images/loading.gif" />不要关闭本窗口，升级进行中...');
	$.post('<?php echo SITE_URL;?>index.php?app=system&ac=upgrade',{'upapp':upapp,'upversion':upversion},function(rs){
		if(rs==0){
			alert('升级失败！');
			window.location.reload()
		}else if(rs==2){
			alert('升级文件目录不可写：\r\n1、请手动将根目录下acajoy目录以及acajoy下所有目录和文件都设置为777权限\r\n2、然后再点击升级\r\n3、升级成功后再将根目录下acajoy目录以及acajoy下所有目录和文件都设置为755权限');
			window.location.reload()
		}else if(rs==1){
			alert('升级成功！');
			window.location.reload()
		}
	})
}

//升级
function isupdate(upapp,version){
	$.getJSON("http://www.acajoy.cn/index.php?app=upcenter&ac=update&upapp="+upapp+"&version="+version+"&callback=?", function(response){
		if(response != ''){
			$('#upgrade').html('发现新版本：'+response.upversion+' <a  href="javascript:void(0);" onclick="upgradeClick(\''+upapp+'\',\''+response.upversion+'\')"><font color="red">[自动升级]</font></a> <a target="_blank" href="http://www.acajoy.cn/index.php?app=upcenter&ac=log&upapp='+upapp+'&version='+version+'">[手动升级]</a> <a target="_blank" href="http://www.acajoy.cn/index.php?app=upcenter&ac=log&upapp='+upapp+'&version='+version+'">[日志]</a>');
		}
		
	});   
}
isupdate('acajoy','<?php echo $TS_CF['info'][version];?>');
</script>

<style>
.fbox{float:left;width:45%;margin-right:10px;}
</style>

<div class="midder">

<div class="fbox">
<h2>目录权限</h2>
<table>
<tr><td width="100">cache目录</td><td><?php if(iswriteable('cache')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
<tr><td>data目录</td><td><?php if(iswriteable('data')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
<tr><td>plugins目录</td><td><?php if(iswriteable('plugins')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
<tr><td>uploadfile目录</td><td><?php if(iswriteable('uploadfile')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
</table>
</div>

<div class="fbox">
<h2>软件信息</h2>
<table>
<tr><td width="100">系统支持：</td><td><?php echo $TS_CF['info'][name];?></td></tr>
<tr><td>程序版本：</td><td><?php echo $TS_CF['info'][version];?>  <span id="upgrade"></span></td></tr>
<tr><td>联系方式：</td><td><?php echo $TS_CF['info'][email];?></td></tr>
<tr><td>官方网址：</td><td><a href="<?php echo $TS_CF['info'][url];?>" target='_blank'><?php echo $TS_CF['info'][url];?></a></td></tr>
</table>
</div>

<div class="fbox"> 
<h2>服务器信息</h2>
<table>
    <tr><td width="100">服务器软件：</td><td><?php echo $systemInfo['server'];?></td></tr>
    <tr><td>操作系统：</td><td><?php echo $systemInfo['phpos'];?></td></tr>
    <tr><td>PHP版本：</td><td><?php echo $systemInfo['phpversion'];?></td></tr>
    <tr><td>MySQL版本：</td><td><?php echo $systemInfo['mysql'];?></td></tr>
    <tr><td>物理路径：</td><td><?php echo $_SERVER['DOCUMENT_ROOT'];?></td></tr>
	 <tr><td>附件上传限制：</td><td><?php echo $systemInfo['upload'];?></td></tr>
    <tr><td>图像处理：</td><td><?php echo $systemInfo['gd'];?> </td></tr>
    <tr><td>语言：</td><td><?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE'];?></td></tr>
    <tr><td>gzip压缩：</td><td><?php echo $_SERVER['HTTP_ACCEPT_ENCODING'];?></td></tr>
</table>
</div>

<div class="fbox" id="admindex_msg">
<h2>ThinkSAAS官方消息</h2>
<table>

</table>
</div>

</div>
<?php include template('footer'); ?>