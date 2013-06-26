<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div class="midder">

<div class="mc">

<div class="cleft">

<div class="bbox pd10 mh500">

<?php include template('menu'); ?>

<div class="btitle">动态</div>
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

</p>

<div class="clear"></div>
<p id="commentshow<?php echo $item['feedid'];?>"></p>

</div>
</li>
<?php }?>
</ul>
</div>

<div class="btitle">留言板</div>
<?php if(intval($TS_USER['user']['userid']) >0 && intval($TS_USER['user']['userid']) != $strUser['userid']) { ?>
<div class="guest">
<img src="<?php echo SITE_URL;?>public/images/user_normal.jpg" />
<form method="post" action="<?php echo SITE_URL;?>index.php?app=user&ac=guestbook&ts=do">
<textarea style="width:100%;height: 50px;margin-bottom: 5px;" name="content"></textarea>
<div class="clear"></div>
<input type="hidden" name="touserid" value="<?php echo $strUser['userid'];?>" />
<button class="btn btn-success" type="submit">添加留言</button>
</form>
</div>
<?php } ?>
<div class="clear"></div>

<div id="reguest" style="display:none;">
<form method="post" action="<?php echo SITE_URL;?>index.php?app=user&ac=guestbook&ts=redo">
<textarea name="content"></textarea>
<input id="touserid" type="hidden" name="touserid" value="0" />
<input id="reid" type="hidden" name="reid" value="0" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="回复" />
</form>
</div>

<div class="glist">
<ul>

<?php foreach((array)$arrGuest as $key=>$item) {?>
<li>
<a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>" rel="face" uid="<?php echo $item['user']['userid'];?>">
<img src="<?php echo $item['user']['face'];?>" alt="<?php echo $item['user']['username'];?>" width="48" height="48" /></a>
<div style="width:520px;">
<p><a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>"  rel="face" uid="<?php echo $item['user']['userid'];?>"><?php echo $item['user']['username'];?></a> <?php echo $item['addtime'];?></p>
<?php echo nl2br(htmlspecialchars($item['content']))?>
<p style="text-align:right">
<?php if(intval($TS_USER['user']['userid'] == $strUser['userid'])) { ?>
<a href="#reguest" onclick="reguest('<?php echo $item['userid'];?>','<?php echo $item['id'];?>')">回复</a> <a href="<?php echo tsurl('user','guestbook',array('ts'=>'delete','gbid'=>$item['id']))?>" onclick="return confirm('确定删除?')">删除</a>
<?php } ?>
</p>

</div>
</li>
<?php }?>
</ul>
</div>

</div>
</div>

<div class="cright">
<?php include template('userinfo'); ?>
</div>

</div>
</div>
<?php include template('footer'); ?>