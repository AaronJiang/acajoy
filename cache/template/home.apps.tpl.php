<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<style>
.apps{}
.apps ul{}
.apps ul li{float:left;width:200px;border:solid 1px #CCCCCC;margin:10px;padding:5px;height:60px;}
</style>

<div class="midder">
<div class="mc">

<div class="bbox pd10">
<h1>APP应用</h2>
<div class="apps">
<ul>

<?php foreach((array)$arrApp as $key=>$item) {?>
<li>
<img align="absmiddle" src="<?php echo SITE_URL;?>app/<?php echo $item['name'];?>/icon.png" /> <strong><a href="<?php echo tsurl($item['name'])?>"><?php echo $item['about']['name'];?></a></strong>(<?php echo $item['name'];?>)
<br />
<?php echo $item['about']['desc'];?>
</li>
<?php }?>
</ul>
</div>

</div>

</div>
</div>

<?php include template('footer'); ?>