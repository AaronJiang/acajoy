<?php defined('IN_TS') or die('Access Denied.'); ?><div class="photoalbumlist bbox pd10">
<div class="btitle">推荐相册
<div class="right"><a href="<?php echo tsurl('photo')?>">更多</a></div>
</div>
<ul>
<?php foreach((array)$arrAlbum as $key=>$item) {?>
<li>
<div><a href="<?php echo tsurl('photo','album',array(ts=>photo,albumid=>$item['albumid']))?>" class="album_photo"><img src="<?php if($item['albumface'] == '') { ?><?php echo SITE_URL;?>app/photo/skins/default/photo_album.png<?php } else { ?><?php echo SITE_URL;?><?php echo tsXimg($item['albumface'],'photo',170,'170',$item['path'],1)?><?php } ?>" width="170" height="170" alt="<?php echo $item['albumname'];?>" /></a>
</div>
<div class="info">
<p><?php echo $item['albumname'];?></p>
<p><?php echo $item['count_photo'];?>张图片</p>
</div>
</li>
<?php }?>
</ul>
</div>