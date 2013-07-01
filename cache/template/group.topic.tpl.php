<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php doAction('tseditor')?>
<div class="midder">
<div class="mc">

<div class="cleft">
<div class="bbox pd010">
<h1><?php if($strTopic['typeid'] !='0') { ?><a href="<?php echo tsurl('group','show',array('id'=>$strTopic['groupid'],typeid=>$strTopic['typeid']))?>">[<?php echo $strTopic['type'][typename];?>]</a><?php } ?><?php echo $strTopic['title'];?> <?php if($strTopic['postby']==1) { ?><a href="<?php echo tsurl('home','phone')?>"><img align="absmiddle" alt="通过Iphone手机端发布" title="通过Iphone手机端发布" src="<?php echo SITE_URL;?>public/images/ios.jpg" /></a><?php } ?></h1>

<?php if($page == '1') { ?>

<div class="topic-content">
<div class="topic-doc">
<div class="topic-view">

<?php if($strTopic['after']) { ?>
<ul class="title2">
<?php foreach((array)$strTopic['after'] as $key=>$item) {?>
<?php if($item['title']) { ?>
<li><a href="#title<?php echo $item['id'];?>"><?php echo $item['title'];?></a></li>
<?php } ?>
<?php }?>
</ul>
<?php } ?>
<?php echo $strTopic['content'];?>
</div>

<?php if($TS_USER['user'][userid] == $strTopic['userid'] || $TS_USER['user'][userid]==$strGroup['userid'] ||$strGroupUser['isadmin']=="1" || $TS_USER['user'][isadmin]=="1") { ?>
<p class="btool">
<?php if($TS_USER['user'][userid]==$strGroup['userid'] ||$strGroupUser['isadmin']=="1" || $TS_USER['user'][isadmin]=="1") { ?>

<a href="javascript:void('0');" onclick="topicAudit('<?php echo $strTopic['topicid'];?>');"><?php if($strTopic['isaudit']=='1') { ?>审核<?php } else { ?>取消审核<?php } ?></a> 

<a href="<?php echo SITE_URL;?>index.php?app=group&ac=do&ts=topic_istop&topicid=<?php echo $strTopic['topicid'];?>"><?php if($strTopic['istop']=='0') { ?>置顶<?php } else { ?>取消置顶<?php } ?></a> 

<a href="<?php echo SITE_URL;?>index.php?app=group&ac=do&ts=isposts&topicid=<?php echo $strTopic['topicid'];?>"><?php if($strTopic['isposts']==0) { ?>精华<?php } else { ?>取消精华<?php } ?></a>

<a href="<?php echo SITE_URL;?>index.php?app=group&ac=topicmove&topicid=<?php echo $strTopic['topicid'];?>">移动</a>

<?php } ?>
<a href="<?php echo SITE_URL;?>index.php?app=group&ac=topicedit&topicid=<?php echo $strTopic['topicid'];?>">编辑</a> 
<a href="<?php echo SITE_URL;?>index.php?app=group&ac=do&ts=deltopic&topicid=<?php echo $strTopic['topicid'];?>&token=<?php echo $_SESSION['token'];?>" onClick="return confirm('确定删除吗?')">删除</a>

</p>
<?php } ?>


<?php foreach((array)$strTopic['after'] as $key=>$item) {?>
<?php if($item['title']) { ?>
<h4><a name="title<?php echo $item['id'];?>"></a><?php echo $item['title'];?></h4>
<?php } ?>
<div class="after-view">
<?php echo $item['content'];?>
<?php if($item['userid'] == $TS_USER['user']['userid'] || $TS_USER['user']['isadmin']==1) { ?>
<br />
<p class="btool">
<a href="<?php echo tsurl('group','after',array('ts'=>'edit','aid'=>$item['id']))?>">编辑</a>
<a href="<?php echo tsurl('group','after',array('ts'=>'delete','aid'=>$item['id']))?>" onClick="return confirm('确定删除吗？')">删除</a>
 <a href="<?php echo tsurl('group','after',array('ts'=>'up','afterid'=>$item['id']))?>" onClick="return confirm('确定上移?')">上移</a>
<a href="<?php echo tsurl('group','after',array('ts'=>'down','afterid'=>$item['id']))?>" onClick="return confirm('确定下移?')">下移</a> 
</p>
<?php } ?>
</div>
<?php }?>
<div class="clear"></div>
<?php if($strTopic['userid'] == $TS_USER['user']['userid'] || $TS_USER['user']['isadmin']==1) { ?>
<p class="bltool">
<a href="<?php echo tsurl('group','after',array('topicid'=>$strTopic['topicid']))?>">补贴</a>
</p>
<?php } ?>
</div>
</div>
<div class="clear"></div>

<div class="tar c9 pd100">
<?php echo date('Y-m-d H:i:s',$strTopic['addtime'])?> 
来自：<a href="<?php echo tsurl('user','space',array('id'=>$strTopic['userid']))?>"><?php echo $strTopic['user'][username];?></a>
</div>

<div class="tar">
<a class="btn" href="javascript:void('0');" onclick="taoalbum('<?php echo $strTopic['topicid'];?>')">淘贴</a> 
<a id="topiclove" class="btn" href="javascript:void('0');" onclick="loveTopic('<?php echo $strTopic['topicid'];?>')"><?php echo $strTopic['count_love'];?>喜欢</a>
<a class="btn" href=""><?php echo $strTopic['count_comment'];?>评论</a>
</div>

<div class="clear"></div>


<div class="tags">
<?php foreach((array)$strTopic['tags'] as $key=>$item) {?>
<a rel="tag" title="" class="post-tag" href="<?php echo tsurl('group','tag',array('id'=>urlencode($item['tagname'])))?>"><?php echo $item['tagname'];?></a>
<?php }?>

</div>
<div class="clear"></div>

<div class="pd100">
<?php if($upTopic) { ?>上一帖子：<a href="<?php echo tsurl('group','topic',array('id'=>$upTopic['topicid']))?>"><?php echo $upTopic['title'];?></a><?php } ?>

<?php if($downTopic) { ?><br />下一帖子：<a href="<?php echo tsurl('group','topic',array('id'=>$downTopic['topicid']))?>"><?php echo $downTopic['title'];?></a><?php } ?>
</div>
<?php } ?>

<div class="clear"></div>
<?php doAction('group_topic_footer')?>

<div class="btitle pd100">用户评论(<?php echo $strTopic['count_comment'];?>)</div>

<?php if($page == '1') { ?>
<div style="text-align:right;">
<?php if($sc=='asc') { ?>
<a href="<?php echo tsurl('group','topic',array('id'=>$topicid,'sc'=>'desc'))?>" rel="nofollow">倒序阅读</a>
<?php } else { ?>
<a rel="nofollow" href="<?php echo tsurl('group','topic',array('id'=>$topicid))?>">正序阅读</a>
<?php } ?>
</div>

<?php } ?>

<ul class="comment">
<?php if(is_array($arrTopicComment)) { ?>
<?php foreach((array)$arrTopicComment as $key=>$item) {?>
<li class="clearfix" id="l_<?php echo $item['commentid'];?>">
<div class="user-face">
<a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>" rel="face" uid="<?php echo $item['user'][userid];?>"><img title="<?php echo $item['user'][username];?>" alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>" width="48" /></a>
</div>
<div class="reply-doc">
<h4><?php echo date('Y-m-d H:i:s',$item['addtime'])?>
	<a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>" rel="face" uid="<?php echo $item['user'][userid];?>" style="margin-left:5px; margin-right:5px;"><?php echo $item['user'][username];?></a>
    <i><?php echo $item[l];?>#</i>
</h4>


<?php if($item['referid'] !='0') { ?>
<div class="recomment"><a href="<?php echo tsurl('user','space',array('id'=>$item['recomment'][user][userid]))?>"><img src="<?php echo $item['recomment'][user][face];?>" width="24" align="absmiddle"></a> <strong><a href="<?php echo tsurl('user','space',array('id'=>$item['recomment'][user][userid]))?>" rel="face" uid="<?php echo $item['recomment'][user][userid];?>"><?php echo $item['recomment'][user][username];?></a></strong>：<?php echo $item['recomment'][content];?></div>
<?php } ?>
<p>
<?php echo $item['content'];?>
</p>

<p class="btool">
<?php if($isGroupUser != '0') { ?>
<span><a href="javascript:void(0)"  onclick="commentOpen(<?php echo $item['commentid'];?>,<?php echo $item['topicid'];?>)">回复</a></span>
<?php } ?>

<?php if($TS_USER['user'][userid] == $strGroup['userid'] || $TS_USER['user'][userid] == $item['userid'] || $strGroupUser['isadmin']==1 || $TS_USER['user'][isadmin]==1) { ?>
<span><a class="j a_confirm_link" href="<?php echo SITE_URL;?>index.php?app=group&ac=comment&ts=delete&commentid=<?php echo $item['commentid'];?>&token=<?php echo $_SESSION['token'];?>" rel="nofollow" onClick="return confirm('确定删除吗?')">删除</a>
</span>
<?php } ?>
</p>


<div id="rcomment_<?php echo $item['commentid'];?>" style="display:none">
<textarea style="width:90%;height:60px;font-size:14px;" id="recontent_<?php echo $item['commentid'];?>" type="text" onKeyDown="keyRecomment(<?php echo $item['commentid'];?>,<?php echo $item['topicid'];?>,event)"></textarea>

<p><a class="btn" href="javascript:void(0);" onClick="recomment(<?php echo $item['commentid'];?>,<?php echo $item['topicid'];?>)" id="recomm_btn_<?php echo $item['commentid'];?>">提交</a> <a href="javascript:void('0');" onclick="commentOpen(<?php echo $item['commentid'];?>,<?php echo $item['topicid'];?>)">取消</a></p>
</div>
</div>
<div class="clear"></div>
</li>
<?php }?>
<?php } ?>
</ul>

<div class="page"><?php echo $pageUrl;?></div>

<div class="btitle">添加评论</div>
<div>


<?php if(intval($TS_USER['user'][userid])==0) { ?>
<div class="tac pd20">
<a href="<?php echo tsurl('user','login')?>">登陆</a> | <a href="<?php echo tsurl('user','register')?>">注册</a>
</div>
<?php } elseif ($isGroupUser == 0) { ?>
<div class="tac pd20">
不是本组成员不能回应此贴哦
</div>
<?php } elseif ($strTopic['iscomment'] == 1 && $strTopic['userid'] != $TS_USER['user'][userid]) { ?>
<div class="tac pd20">
本帖除作者外不允许任何人评论
</div>
<?php } elseif ($strTopic['isclose']=='1') { ?>
<div class="tac pd20">
该帖子已被关闭，无法评论
</div>
<?php } else { ?>
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=comment&ts=do" enctype="multipart/form-data">
<textarea style="width:100%;" id="tseditor-mini" name="content"></textarea>
<p>
<input type="hidden" name="topicid" value="<?php echo $strTopic['topicid'];?>" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<button class="btn btn-success" type="submit">提交评论</button></p>
</form>
<?php } ?>

</div>
</div>
</div>

<div class="cright">

<div class="bbox pd10">
	
	<div class="fs14">><a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid']))?>">返回<?php echo $strGroup['groupname'];?></a></div>
	
</div>

<div class="facebox bbox pd10">
<div class="face">
<a href="<?php echo tsurl('user','space',array('id'=>$strTopic['user'][userid]))?>"><img title="<?php echo $strTopic['user'][username];?>" alt="<?php echo $strTopic['user'][username];?>" src="<?php echo $strTopic['user'][face];?>" width="48"></a>
</div>

<div class="info">
<h3><a href="<?php echo tsurl('user','space',array('id'=>$strTopic['user'][userid]))?>"><?php echo $strTopic['user'][username];?></a></h3>
<div><a class="btn btn-mini" href="javascript:void('0')" onclick="follow('<?php echo $strTopic['user']['userid'];?>');">关注</a></div>
</div>
</div>

<div class="bbox pd10">
<div class="btitle">最新帖子</div>
<div class="commlist">
<ul>
<?php foreach((array)$newTopic as $key=>$item) {?>
<li>
<?php if($item['appkey'] != 'group' && $item['appkey']!='') { ?>
<a target="_blank" style="color:#999999;font-size: 12px;margin-right: 5px;" class="titles-type" href="<?php echo SITE_URL;?><?php echo tsUrl($item['appkey'])?>">[<?php echo $item['appname'];?>]</a>
<a title="<?php echo $item['title'];?>" href="<?php echo SITE_URL;?><?php echo tsUrl($item['appkey'],$item['appaction'],array('id'=>$item['askid']))?>"><?php echo $item['title'];?></a>
<?php } else { ?>
<a title="<?php echo $item['title'];?>" href="<?php echo tsurl('group','topic',array('id'=>$item['topicid']))?>"><?php echo cututf8($item['title'],0,25)?></a> 
<?php } ?>

</li>
<?php }?>
</ul>
</div>
</div>

<div class="bbox pd10">
<div class="btitle">热门帖子</div>

<div class="commlist">
<ul>
<?php foreach((array)$arrHotTopic as $key=>$item) {?>
<li><a href="<?php echo tsurl('group','topic',array('id'=>$item['topicid']))?>"><?php echo $item['title'];?></a></li>
<?php }?>
</ul>
</div>

</div>


<div class="bbox pd10">
<div class="btitle">喜欢这个帖子的用户</div>
<script>topic_collect_user('<?php echo $strTopic['topicid'];?>')</script>
<div id="collects">
<div style="padding:10px;text-align:center;"><img src="<?php echo SITE_URL;?>public/images/loading.gif" />加载中......</div>
</div>
</div>

<div class="clear"></div>
<!--广告位-->
<?php doAction('gobad','300')?>
</div>

</div>
</div>
<?php include template('footer'); ?>