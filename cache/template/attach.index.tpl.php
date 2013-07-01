<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<div class="midder">
<div class="mc">

<div class="bbox pd10 mh500">

<?php include template('menu'); ?>


<div class="albumlist">

<ul>
<?php foreach((array)$arrAlbum as $key=>$item) {?>
<li>
<div>
<h2><a href="<?php echo tsurl('attach','album',array('id'=>$item['albumid']))?>"><?php echo $item['title'];?></a></h2>
<p><?php echo $item['user']['username'];?>创建于<?php echo $item['addtime'];?></p>
<p>已上传<?php echo $item['count_attach'];?>个资料</p>
</div>
</li>
<?php }?>
</ul>

</div>

<div class="clear"></div>

</div>

</div>
</div>

<?php include template('footer'); ?>