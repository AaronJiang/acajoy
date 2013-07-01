<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<!--main-->
<div class="midder">

<div class="mc">

<div class="bbox pd20 mh400">

<?php include template('set_menu'); ?>

<?php if(intval($strUser['isverify'])==0 && intval($TS_SITE['base']['isverify'])==1) { ?>
<div class="alert">提示：你必须通过Email验证才可以正常使用本社区</div>
<?php } ?>
<?php if($strUser['isverify']==1) { ?>
您已经通过Email验证！
<?php } else { ?>
Email：<input type="email" disabled value="<?php echo $strUser['email'];?>" /> <a class="btn" href="<?php echo tsurl('user','verify',array(ts=>post))?>">开始认证</a>  <a href="<?php echo tsurl('user','set',array('ts'=>'email'))?>">Email不对吗？去更换帐号</a>
<?php } ?>
</div>


</div>
</div>

<?php include template('footer'); ?>
