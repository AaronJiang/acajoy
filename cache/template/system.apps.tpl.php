<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<script src="public/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script>
//升级
function isupdate(upapp,version){
	$.getJSON("http://www.acajoy.cn/index.php?app=upcenter&ac=update&upapp="+upapp+"&version="+version+"&callback=?", function(response){
		if(response != ''){
			$('#'+upapp).html('发现新版本：'+response.upversion+' <a  href="javascript:void(0);" onclick="upgradeClick(\''+upapp+'\',\''+response.upversion+'\')"><font color="red">[自动升级]</font></a> <a target="_blank" href="http://www.acajoy.cn/index.php?app=upcenter&ac=log&upapp='+upapp+'&version='+version+'">[手动升级]</a> <a target="_blank" href="http://www.acajoy.cn/index.php?app=upcenter&ac=log&upapp='+upapp+'&version='+version+'">[日志]</a>');
		}
		
	});   
}

function upgradeClick(upapp,upversion){
	$('#'+upapp).html('<img src="<?php echo SITE_URL;?>public/images/loading.gif" />不要关闭本窗口，升级进行中...');
	$.post('<?php echo SITE_URL;?>index.php?app=system&ac=upgrade',{'upapp':upapp,'upversion':upversion},function(rs){
		if(rs==0){
			alert('升级失败！');
			window.location.reload()
		}else if(rs==2){
			alert('升级文件目录不可写：\r\n1、请手动将根目录下app/'+upapp+'目录以及app/'+upapp+'下所有目录和文件都设置为777权限\r\n2、然后再点击升级\r\n3、升级成功后再将根目录下app/'+upapp+'目录以及app/'+upapp+'下所有目录和文件都设置为755权限');
			window.location.reload()
		}else if(rs==1){
			alert('升级成功！');
			window.location.reload()
		}
	})
}

//设为导航
function isappnav(appkey,appname){
	$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=apps&ts=appnav",
		data:"&appkey="+appkey+"&appname="+appname,
		beforeSend:function(){},
		success:function(result){
			if(result == '1'){
				window.location.reload(true); 
			}
		}
	})
}

//取消导航
function unisappnav(appkey){
	$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=apps&ts=unappnav",
		data:"&appkey="+appkey,
		beforeSend:function(){},
		success:function(result){
			if(result == '1'){
				window.location.reload(true); 
			}
		}
	})
}

</script>


<div class="midder">

<h2>APP管理</h2>

<div class="tabnav">
<ul>
<li class="select"><a href="index.php?app=system&ac=apps&ts=list">APP列表</a></li>
</ul>
</div>

<table width="100%" cellpadding="0" cellspacing="0">
<tr class="old">
<td width="150">APP名称</td>
<td>版本</td>
<td>介绍</td>
<td>作者</td>
<td>管理</td>
<td>操作</td>
</tr>
<?php foreach((array)$arrApp as $keys=>$item) {?>
<tr class="odd">
<td><img src="app/<?php echo $item['name'];?>/icon.png" title="<?php echo $item;?>" align="absmiddle" />
<?php echo $item['about'][name];?>(<?php echo $item['name'];?>)</td>
<td><?php echo $item['about'][version];?> <span id="<?php echo $item['name'];?>"></span>
<script>isupdate('<?php echo $item['name'];?>','<?php echo $item['about'][version];?>')</script>
</td>
<td><?php echo $item['about'][desc];?></td>
<td><?php echo $item['about'][author];?></td>
<td>
<?php if($item['about'][isoption] == '1' && $item['about'][isinstall]=='1') { ?><a href="index.php?app=<?php echo $item['name'];?>&ac=admin&mg=options">[管理]</a><?php } ?> 
</td>
<td>
<?php if($item['about'][isappnav] == '1' && $TS_SITE['appnav'][$item['name']] == '') { ?><a href="javascript:void('0');" onclick="isappnav('<?php echo $item['name'];?>','<?php echo $item['about'][name];?>');">[导航]</a><?php } ?>

<?php if($item['about'][isappnav] == '1' && $TS_SITE['appnav'][$item['name']] != '') { ?><a href="javascript:void('0');" onclick="unisappnav('<?php echo $item['name'];?>');">[取消导航]</a><?php } ?>
</td>
</tr>
<?php }?>
</table>

</div>

<?php include template('footer'); ?>