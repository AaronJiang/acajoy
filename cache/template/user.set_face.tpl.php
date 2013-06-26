<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<style>
.dface{overflow: hidden;}
.dface li{float:left;}
.dface li img{border:solid 1px #999999;margin-right:10px;}

</style>

<!--main-->
<div class="midder">
<div class="mc">

<div class="bbox pd20">

<?php include template('set_menu'); ?>

<?php if($TS_SITE['base']['isface']=='1' && $strUser['face'] == SITE_URL.'public/images/user_normal.jpg') { ?>
<div class="alert">提示：你需要上传头像才可以正常使用网站！</div>
<?php } ?>

<h2>当前头像</h2>
<div>
<img alt="<?php echo $TS_USER['uname'];?>" src="<?php echo $strUser['face'];?>?v=<?php echo rand();?>" width="60" />
<?php if($strUser['path']) { ?><a href="<?php echo tsurl('user','set',array('ts'=>'cut'))?>">裁切头像</a><?php } ?>
</div>

<h2>选择本地头像</h2>

<form method="post" action="<?php echo tsUrl('user','set',array(ts=>facedo));?>"  enctype="multipart/form-data">
<input type="file" name="picfile" /><input class="btn" type="submit" value="上传头像" />
</form>

<h2>选择系统预置头像</h2>
<div>
<form method="post" action="<?php echo SITE_URL;?>index.php?app=user&ac=do&ts=face">
<ul class="dface">
<?php foreach((array)$arrFace as $key=>$item) {?>
<li>
<img src="<?php echo SITE_URL;?>uploadfile/user/face/<?php echo $item;?>" width="60" />
<br />
<input type="radio" name="face" value="<?php echo intval($item)?>" />
</li>
<?php }?>
</ul>
<button class="btn btn-success" type="submit">使用头像</button>
</form>
</div>
</div>


</div>
</div>

<?php include template('footer'); ?>