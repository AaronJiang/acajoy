<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<div class="midder">
<div class="mc">
<div class="bbox pd10 mh400">

<h1>社区动态</h1>

<div class="feedlist">
<ul>
<?php foreach((array)$arrFeed as $key=>$item) {?>
<li>
<div class="photo">
<a href="<?php echo tsurl('user','space',array('id'=>$item['user']['userid']))?>"><img src="<?php echo $item['user']['face'];?>" width="32" height="32" title="<?php echo $item['user']['username'];?>" alt="<?php echo $item['user']['username'];?>" /></a>
</div>
<div class="info">
<p class="action"><a href="<?php echo tsurl('user','space',array('id'=>$item['user']['userid']))?>"><?php echo $item['user']['username'];?></a> <?php echo $item['action'];?><?php echo $item['actionname'];?> 

<?php if($item['app']['title']) { ?>
<a href="<?php echo tsurl($item['appname'],$item['appaction'],array('id'=>$item['appid']))?>"><?php echo $item['app']['title'];?></a>
<?php } else { ?>
<a href="<?php echo tsurl($item['appname'],$item['appaction'],array('id'=>$item['appid']))?>">
<?php echo $item['app']['content'];?>
</a>
<?php } ?>

</p>

<?php if($item['comment']) { ?>
<p class="content"><?php echo $item['comment']['content'];?></p>
<?php } else { ?>
<p class="content"><?php echo $item['app']['content'];?></p>
<?php } ?>

<p>
<span class="time"><?php echo getTime($item['addtime'],time())?></span>
<span class="tocomment"><a href="javascript:void('0');" onclick="showcomment('<?php echo $item['feedid'];?>')">评论(<?php echo $item['app']['count_comment'];?>)</a>  

<?php if($TS_USER['user']['isadmin']==1) { ?>
<a href="<?php echo tsurl('feed','delete',array('feedid'=>$item['feedid']))?>">删除</a>
<?php } ?>

</span>
</p>

<div class="clear"></div>
<p id="commentshow<?php echo $item['feedid'];?>"></p>

</div>
</li>
<?php }?>
</ul>
</div>

<div class="clear"></div>
<div class="page"><?php echo $pageUrl;?></div>
</div>



</div>
</div>

<?php include template('footer'); ?>