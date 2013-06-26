<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div class="midder">
<div class="mc">

<div class="cleft">

<div class="bbox pd10 mh400">
<div class="clist">
<ul>
<?php foreach((array)$arrArticle as $key=>$item) {?>
<li>
<?php if($item['photo']) { ?>
<a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>">
<img style="float:left;" src="<?php echo SITE_URL;?><?php echo tsXimg($item['photo'],'article',180,140,$item['path'],'1')?>" />
</a>
<?php } ?>

<h2><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo htmlspecialchars($item['title'])?></a></h2>
<span><a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>"><?php echo $item['user'][username];?></a> 发表于 <?php echo $item['addtime'];?></span>

<p><?php echo $item['content'];?> (<a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>">查看全文</a>)</p>

<div class="cate tar">来自：<a href="<?php echo tsurl('article','cate',array('id'=>$item['cate']['cateid']))?>"><?php echo $item['cate']['catename'];?></a>  (<?php echo $item['count_recommend'];?>)推荐  (<?php echo $item['count_comment'];?>)评论</div>
<div class="clear"></div>
</li>
<?php }?>
</ul>
</div>

<div class="page"><?php echo $pageUrl;?></div>

</div>
</div>

<div class="cright">

<div class="bbox pd10">
<a class="btn" href="<?php echo tsurl('article','add')?>">写文章</a>
</div>

<div class="bbox pd10">
<div class="btitle">文章分类</div>

<div class="catelist">
<ul>
<?php foreach((array)$arrCate as $key=>$item) {?>
<li><a <?php if($strCate['cateid']==$item['cateid']) { ?>class="on"<?php } ?> href="<?php echo tsurl('article','cate',array('id'=>$item['cateid']))?>"><?php echo $item['catename'];?></a></li>
<?php }?>
</ul>
</div>

</div>

<div class="bbox pd10">
<div class="btitle">推荐阅读</div>

<div class="commlist">
<ul>
<?php foreach((array)$arrRecommend as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo $item['title'];?></a></li>
<?php }?>
</ul>
</div>

</div>

<div class="bbox pd10">
<div class="btitle">一周热门</div>

<div class="commlist">
<ul>
<?php foreach((array)$arrHot7 as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo $item['title'];?></a></li>
<?php }?>
</ul>
</div>

</div>

<div class="bbox pd10">
<div class="btitle">一月热门</div>

<div class="commlist">
<ul>
<?php foreach((array)$arrHot30 as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo $item['title'];?></a></li>
<?php }?>
</ul>
</div>

</div>


<div class="clear"></div>
<!--广告位-->
<?php doAction('gobad','300')?>

</div>
</div>
</div>

<?php include template('footer'); ?>