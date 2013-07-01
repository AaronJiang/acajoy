<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div class="midder">
<?php include template('menu'); ?>

<div class="mb10"> <a class="btn mr10" href="<?php echo SITE_URL;?>index.php?app=system&ac=sql&ts=export">点击备份数据库</a>  <a class="btn mr10" href="<?php echo SITE_URL;?>index.php?app=system&ac=sql&ts=optimize">点击优化数据库</a></div>

<table>
<tr class="old"><td>数据库备份文件</td><td>操作</td></tr>
<?php foreach((array)$arrSqlFile as $key=>$item) {?>
<tr><td><?php echo $item;?></td><td><a href="<?php echo SITE_URL;?>index.php?app=system&ac=sql&ts=import&sql=<?php echo $item;?>">恢复(导入)</a>   |  <a href="<?php echo SITE_URL;?>index.php?app=system&ac=sql&ts=delete&sql=<?php echo $item;?>">删除(谨慎)</a></td></tr>
<?php }?>
</table>

</div>
<?php include template('footer'); ?>