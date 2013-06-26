<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<div class="midder">

<div class="mc">

<div class="cleft" style="position: relative;">
<div class="bbox pd10 mh500">
<h1><a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid']))?>"><?php echo $strGroup['groupname'];?></a> </h1>
<div class="clear"></div>
<div class="box">

<div class="box_content">


<div class="topictype">
<ul>
<li <?php if($typeid=="0") { ?>class="on"<?php } ?>><a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid']))?>"><span>全部</span></a></li>
<?php foreach((array)$arrTopicType as $key=>$item) {?>
<li <?php if($typeid==$item['typeid']) { ?>class="on"<?php } ?>><a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid'],typeid=>$item['typeid']))?>"><span><?php echo $item['typename'];?></span></a></li>
<?php }?>
</ul>
</div>
<div class="clear"></div>



<div class="topic_list">
<ul>

<?php foreach((array)$arrTopic as $key=>$item) {?>
<li>
<div class="userimg">
<a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>" rel="face" uid="<?php echo $item['user']['userid'];?>"><img src="<?php echo $item['user'][face];?>" width="32" height="32" alt="<?php echo $item['user']['username'];?>" title="<?php echo $item['user']['username'];?>" /></a>
</div>

<div class="topic_title">
<div class="title">
<?php if($item['typeid'] != 0) { ?><a href="<?php echo tsurl('group','show',array('id'=>$item['groupid'],typeid=>$item['typeid']))?>">[<?php echo $item['typename'];?>]</a><?php } ?>

<?php if($item['appkey'] != 'group' && $item['appkey']!='') { ?>
<a target="_blank" style="color:#999999;font-size: 12px;margin-right: 5px;" class="titles-type" href="<?php echo SITE_URL;?><?php echo tsUrl($item['appkey'])?>">[<?php echo $item['appname'];?>]</a>
<a title="<?php echo $item['title'];?>" href="<?php echo SITE_URL;?><?php echo tsUrl($item['appkey'],$item['appaction'],array('id'=>$item['appid']))?>"><?php echo $item['title'];?></a>
<?php } else { ?>
<a title="<?php echo $item['title'];?>" href="<?php echo tsurl('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a>
<?php } ?>

<?php if($item['istop']=='1') { ?>
<img src="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/headtopic_1.gif" title="[置顶]" alt="[置顶]" /> 
<?php } ?> 

<?php if($item['isposts'] == '1') { ?>
<img src="<?php echo SITE_URL;?>public/images/posts.gif" title="[精华]" alt="[精华]" />
<?php } ?>
<?php if($item['postby']==1) { ?><a href="<?php echo tsurl('home','phone')?>"><img align="absmiddle" alt="通过Iphone手机端发布" title="通过Iphone手机端发布" src="<?php echo SITE_URL;?>public/images/ios.jpg" /></a><?php } ?>

</div>
<div class="topic_info">
<span style="float:left;">
<?php echo getTime($item['uptime'],time())?>
</span>

<span style="float:right;">
<a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>"  rel="face" uid="<?php echo $item['user']['userid'];?>"><?php echo $item['user'][username];?></a>

<?php if($item['count_comment']>0) { ?><a class="rank" style="color:#FFFFFF;" href="<?php echo tsurl('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['count_comment'];?></a><?php } ?>
</span>
</div>
</div>
<div class="clear"></div>
</li>	
<?php }?>

</ul>
</div>


<div class="page"><?php echo $pageUrl;?></div>

</div>
</div>


<div style="position: absolute;right: 20px;;top: 10px;"><a class="btn btn-success" href="<?php echo tsurl('group','add',array('id'=>$strGroup['groupid']))?>">发布帖子</a></div>

</div>
</div>


<div class="cright">

<div class="facebox bbox pd10">
<div class="face">
<a href=""  ><img title="<?php echo $strGroup['groupname'];?>" alt="<?php echo $strGroup['groupname'];?>" src="<?php echo $strGroup['icon_48'];?>" width="48"></a>
</div>

<div class="info">
<h3><a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid']))?>"><?php echo $strGroup['groupname'];?></a></h3>
<div>
<?php if($isGroupUser > 0 && $TS_USER['user'][userid] != $strGroup['userid']) { ?>
<span class="fleft mr5 color-gray">我是这个小组的<?php echo $strGroup['role_user'];?> <a class="j a_confirm_link" href="<?php echo tsurl('group','do',array('ts'=>'exit','groupid'=>$strGroup['groupid']))?>" style="margin-left: 6px;">&gt;退出</a></span>
<?php } elseif ($isGroupUser > 0 && $TS_USER['user'][userid] == $strGroup['userid']) { ?>
<span class="fleft mr5 color-gray">我是这个小组的<?php echo $strGroup['role_leader'];?></span>
<?php } elseif ($strGroup['joinway'] == '0') { ?>
<span><a class="btn btn-mini" href="<?php echo tsurl('group','do',array('ts'=>'join','groupid'=>$strGroup['groupid']))?>">加入</a></span>

<?php } else { ?>
<span class="fright">本小组禁止加入</span>
<?php } ?>
</div>
</div>

<div class="clear"></div>

<ul class="other">
<li class="br"><span class="fs14"><a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid']))?>"><?php echo $strGroup['count_topic'];?></a></span><br />帖子</li>
<li><span class="fs14"><a href=""><?php echo $strGroup['count_user'];?></a></span><br />成员</li>
</ul>

</div>

<div class="bbox pd10">

<p class="c9">
创建于 <?php echo date('Y-m-d',$strGroup['addtime'])?> 
组长：<a href="<?php echo tsurl('user','space',array('id'=>$strLeader['userid']))?>"  rel="face" uid="<?php echo $strLeader['userid'];?>"><?php echo $strLeader['username'];?></a>
</p>
<p><?php echo $strGroup['groupdesc'];?></p>
<p><?php echo $strGroup['groupname'];?>小组网址：<br /><a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid']))?>"><?php echo tsurl('group','show',array('id'=>$strGroup['groupid']))?></a></p>
</div>


<div class="bbox pd10">
<div class="btitle">小组成员</div>
<?php foreach((array)$arrGroupUser as $key=>$item) {?>
<dl class="obu">
<dt><a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>" rel="face" uid="<?php echo $item['userid'];?>"><img class="m_sub_img" src="<?php echo $item['face'];?>" width="48" height="48" alt="<?php echo $item['username'];?>" title="<?php echo $item['username'];?>" /></a></dt>
<dd><?php echo $item['username'];?></dd>
</dl>
<?php }?>
</div>


<div class="bbox pd10">

<?php if($strGroup['joinway']==1 && $strGroup['userid'] == $TS_USER['user']['userid']) { ?>
<p>
<form method="post" action="<?php echo tsurl('group','do',array('ts'=>'invite'))?>">
<input type="text" name="userid" value="" /> 
<input type="hidden" name="groupid" value="<?php echo $strGroup['groupid'];?>" />

<button class="btn btn-success" type="submit">邀请</button>

</p>
</form>
<?php } ?>

<?php if($TS_USER['user'][userid] == $strGroup['userid'] || $TS_USER['user']['isadmin']=='1') { ?>
<p class="pl2">&gt; <a href="<?php echo tsurl('group','edit',array(groupid=>$strGroup['groupid'],ts=>base))?>">小组设置</a></p>

<p class="pl2">&gt; <a href="<?php echo tsurl('group','audit',array('groupid'=>$strGroup['groupid']))?>">帖子审核</a>(<?php echo $strGroup['count_topic_audit'];?>)</p>

<p class="pl2">&gt; <a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid'],'isshow'=>'1'))?>">回收站</a>(<?php echo $strGroup['recoverynum'];?>)</p>

<?php } ?>

<p class="pl2">&gt; <a href="<?php echo tsurl('group','user',array('id'=>$strGroup['groupid']))?>">小组成员</a>(<?php echo $strGroup['count_user'];?>)</p>

<div class="clear"></div>

<p class="pl"><span class="feed"><a href="<?php echo tsurl('group','rss',array(groupid=>$strGroup['groupid']))?>">feed: rss 2.0</a></span></p>

</div>

<div class="clear"></div>
<!--广告位-->
<?php doAction('gobad','300')?>

</div>
</div>
</div>

<?php include template('footer'); ?>