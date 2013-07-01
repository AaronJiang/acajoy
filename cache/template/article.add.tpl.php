<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php doAction('tseditor')?>
<div class="midder">
<div class="mc">

<div class="bbox pd20">

<h1>写文章</h1>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=article&ac=add&ts=do"  enctype="multipart/form-data">
<table>

<?php if($arrCate) { ?>
<tr><th>选择分类：</th><td>
<select name="cateid">
<?php foreach((array)$arrCate as $key=>$item) {?>
<option <?php if($item['cateid']==$cateid) { ?>selected="select"<?php } ?> value="<?php echo $item['cateid'];?>"><?php echo $item['catename'];?></option>
<?php }?>
</select>
</td></tr>
<?php } ?>

<tr><th>标题：</th><td><input style="padding:3px 0;width:600px;" name="title" /></td></tr>
<tr><th valign="top">内容：</th><td><textarea class="editors" style="width:600px;" id="tseditor" name="content"></textarea></td></tr>
<tr><th>标签：</th><td><input style="padding:3px 0;width:300px;" name="tag" /> (多个标签请用英文,号分开)</td></tr>
<tr><th>封面图片：</th><td><input  type="file" name="picfile" /> (仅支持jpg,gif,png)</td></tr>
<tr><th></th><td>
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<button class="btn btn-success" type="submit">发布文章</button></td></tr>
</table>
</form>
</div>
</div>
</div>
<?php include template('footer'); ?>