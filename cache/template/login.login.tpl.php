<?php defined('IN_TS') or die('Access Denied.'); ?><?php if($TS_USER['user']['userid']) { ?>

<div class="facebox bbox pd10">
<div class="face">
<a href="<?php echo tsurl('user','space',array('id'=>$strUser['userid']))?>"><img title="<?php echo $strUser['username'];?>" alt="<?php echo $strUser['username'];?>" src="<?php echo $strUser['face'];?>" width="48"></a>
</div>

<div class="info">
<h3><a href="<?php echo tsurl('user','space',array('id'=>$strUser['userid']))?>"><?php echo $strUser['username'];?></a></h3>
<div>

<?php if($strUser['userid']==$TS_USER['user']['userid']) { ?>
<a class="btn btn-mini" href="<?php echo tsurl('user','space',array('id'=>$strUser['userid']))?>">我的空间</a>
<?php } else { ?>
<a class="btn btn-mini"  href="javascript:void('0')" onclick="follow('<?php echo $strUser['userid'];?>');">关注</a>
<?php } ?>

</div>
</div>

<div class="clear"></div>

<ul class="other">
<li class="br"><span class="fs14"><a href="<?php echo tsurl('user','group',array('id'=>$strUser['userid']))?>"><?php echo $strUser['count_group'];?></a></span><br />小组</li>
<li class="br"><span class="fs14"><a href="<?php echo tsurl('user','topic',array('id'=>$strUser['userid']))?>"><?php echo $strUser['count_topic'];?></a></span><br />帖子</li>
<li class="br"><span class="fs14"><a href="<?php echo tsurl('user','score',array('id'=>$strUser['userid']))?>"><?php echo $strUser['count_score'];?></a></span><br />积分</li>
<li class="br"><span class="fs14"><a href="<?php echo tsurl('user','followed',array('id'=>$strUser['userid']))?>"><?php echo $strUser['count_followed'];?></a></span><br />粉丝</li>
<li><span class="fs14"><a href="<?php echo tsurl('user','follow',array('id'=>$strUser['userid']))?>"><?php echo $strUser['count_follow'];?></a></span><br />关注</li>
</ul>

<div class="clear"></div>

<div class="fmore">

<a href="<?php echo tsurl('user','verify')?>">
<?php if($strUser['isverify']==1) { ?>
<img src="<?php echo SITE_URL;?>public/images/rz1.gif" alt="认证用户" title="认证用户" align="absmiddle" />
<?php } else { ?>
<img src="<?php echo SITE_URL;?>public/images/rz2.gif" alt="未认证用户" title="未认证用户" align="absmiddle" />
<?php } ?>
</a>
<br />
角色：<a href="<?php echo tsurl('user','role')?>"><?php echo $strUser['rolename'];?></a>

</div>

</div>


<?php } else { ?>
<div class="bbox login">
<form action="<?php echo tsurl('user','login',array('ts'=>'do'))?>" method="post">
<fieldset>
<legend>登录</legend>
<div class="item">
<label>Email:</label>
<br />
<input type="email" name="email">
</div>
<div class="item">
<label>密码：</label>
<br />
<input type="password" class="text" name="pwd">
</div>

<div class="item1">
<input type="hidden" name="cktime" value="2592000" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<button type="submit" class="btn btn-success">登录</button> 
<a href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=qq&in=login"><img align="absmiddle" src="<?php echo SITE_URL;?>plugins/pubs/qq/images/Connect_logo_6.png" alt="QQ登陆" /></a>

<a href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=weibo&in=login"><img align="absmiddle" src="<?php echo SITE_URL;?>plugins/pubs/weibo/images/16x16.png" alt="微博登陆" /></a>
 <a href="<?php echo tsurl('user','forgetpwd')?>">忘记密码</a>
</div>
</fieldset>
</form>
</div>
<?php } ?>