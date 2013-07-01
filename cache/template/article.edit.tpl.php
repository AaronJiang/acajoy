<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php doAction('tseditor')?>
<div class="midder">
<div class="mc">

<div class="bbox pd10">
<h1>修改文章</h1>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=article&ac=edit&ts=do"  enctype="multipart/form-data">
<table>

<?php if($arrCate) { ?>
<tr><th>选择分类：</th><td>
<select name="cateid">
<?php foreach((array)$arrCate as $key=>$item) {?>
<option <?php if($item['cateid']==$strArticle['cateid']) { ?>selected="select"<?php } ?> value="<?php echo $item['cateid'];?>"><?php echo $item['catename'];?></option>
<?php }?>
</select>
</td></tr>
<?php } ?>

<tr><th>标题：</th><td><input style="padding:3px 0;width:600px;" name="title" value="<?php echo $strArticle['title'];?>" /></td></tr>
<tr><th valign="top">内容：</th><td><textarea id="tseditor" name="content"><?php echo $strArticle['content'];?></textarea></td></tr>

<tr><th>封面图片：</th><td>

<?php if($strArticle['photo']) { ?>
<img src="<?php echo SITE_URL;?><?php echo tsXimg($strArticle['photo'],'article',180,'140',$strArticle['path'],1)?>?v=<?php echo rand();?>" />
<br />
<?php } ?>

<input  type="file" name="picfile" /> (仅支持jpg,gif,png)</td></tr>

<tr><th></th><td>
<input type="hidden" name="articleid" value="<?php echo $articleid;?>" />
<button class="btn btn-success" type="submit">修改文章</button>  

<a href="<?php echo tsurl('article','show',array('id'=>$strArticle['articleid']))?>">返回</a>
</td></tr>
</table>
</form>
</div>
</div>
</div>
<?php include template('footer'); ?>