<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<link type="text/css" rel="stylesheet" href="/plugins/article/rating/assets/rateit.css"/>
<div class="midder">
<div class="mc">
<div class="bbox mh400">
<?php include template('menu'); ?>
<div class="bc">
<div class="cleft">
<div class="clist">
<ul>
<?php foreach((array)$arrArticle as $key=>$item) {?>
<li>
<?php if($item['photo']) { ?>
<a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>">
<img style="float:left;" src="<?php echo tsXimg($item['photo'],'article',180,140,$item['path'],'1')?>" />
</a>
<?php } ?>

<div><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo htmlspecialchars($item['title'])?></a></div>
<span><a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>"><?php echo $item['user'][username];?></a> 发表于 <?php echo $item['addtime'];?></span>

<p><?php echo $item['content'];?> (<a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>">查看全文</a>)</p>

<div class="cate tar">
<div class="rateit average_socre" data-rateit-value="<?php echo $item['rate'][average];?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
<span id="rateit_score"><?php echo $item['rate_average'];?></span> (<span id="rateit_count"><?php echo $item['rate'][count];?></span>人评分) &nbsp;&nbsp;
来自：<a href="<?php echo tsurl('article','cate',array('id'=>$item['cate']['cateid']))?>"><?php echo $item['cate']['catename'];?></a>  (<?php echo $item['count_recommend'];?>)推荐  (<?php echo $item['count_comment'];?>)评论
</div>
<div class="clear"></div>
</li>
<?php }?>
</ul>
</div>

<div class="page"><?php echo $pageUrl;?></div>
</div>

<div style="float:right;margin-right:190px;margin-bottom:10px;">
<a class="btn btn-success" href="<?php echo tsurl('article','add')?>">写文章</a>
</div>

<div class="rbox">
<h2>推荐阅读</h2>
<div class="commlist">
<ul>
<?php foreach((array)$arrRecommend as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo $item['title'];?></a></li>
<?php }?>
</ul>
</div>


<h2>一周热门</h2>
<div class="commlist">
<ul>
<?php foreach((array)$arrHot7 as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo $item['title'];?></a></li>
<?php }?>
</ul>
</div>
<h2>一月热门</h2>

<div class="commlist">
<ul>
<?php foreach((array)$arrHot30 as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo $item['title'];?></a></li>
<?php }?>
</ul>
</div>


</div>



</div>

</div>


</div>
<script type="text/javascript" src="/plugins/article/rating/assets/jquery.rateit.min.js"></script>
<?php include template('footer'); ?>