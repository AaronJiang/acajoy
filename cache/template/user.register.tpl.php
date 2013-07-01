<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php if($TS_APP['options'][isregister]=='2') { ?>
<?php } else { ?>
<script language="javascript">
$(document).ready(function(){
	$(".subform").Validform({
		btnSubmit:"#btnsub", 
		btnReset:".btnreset",
		tiptype:3,
	});
});
function newgdcode(obj,url) {
	obj.src = url+ '&nowtime=' + new Date().getTime();
}
</script>

<?php } ?>

<div class="midder">
<div class="mc">

<div class="bbox pd20 mh400">

<h1>用户注册</h1>

<?php if($TS_APP['options'][isregister]=='2') { ?>
<p>系统升级中，暂时关闭用户注册！</p>
<p><a href="<?php echo SITE_URL;?>">返回首页</a></p>
<?php } else { ?>
<p></p>
<form class="subform" method="POST" action="<?php echo tsurl('user','register',array('ts'=>'do'))?>">

<table class="commtable" width="100%" border="0" cellspacing="0" cellpadding="0">

<?php if($TS_SITE['base']['isinvite']=='1') { ?>
<tr>
<th>
<font color="red">邀请码:</font></th>
<td><input name="invitecode" type="text" /></td>
</tr>
<?php } ?>


<tr>
<th>Email:</th>
<td><input name="email" type="text" datatype="e" ajaxurl="<?php echo SITE_URL;?>index.php?app=user&ac=check&ts=inemail"  /></td>
</tr>
<tr>
<th>密码：</th>
<td><input type="password" name="pwd"  datatype="*6-16"  /></td>
</tr>
<tr>
<th>重复密码：</th>
<td><input type="password" name="repwd"  datatype="*" recheck="pwd" /></td>
</tr>

<tr>
<th>用户名：</th>
<td><input type="text" name="username" datatype="s5-18" ajaxurl="<?php echo SITE_URL;?>index.php?app=user&ac=check&ts=isusername" /></td>
</tr>

<tr><th>验证码：</th><td><input name="authcode" datatype="*" ajaxurl="<?php echo SITE_URL;?>index.php?app=user&ac=check&ts=code" />
 <img src="<?php echo tsurl('user','checkcode')?>" onclick="javascript:newgdcode(this,this.src);" alt="点击刷新验证码" style="cursor:pointer;"/></td>
</tr>

<tr>
<th></th>
<td>
<input type="hidden" name="fuserid" value="<?php echo $fuserid;?>" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<button id="btnsub" class="btn btn-success" type="submit">注册</button>

<a href="<?php echo tsurl('user','login')?>">登陆</a></td>
</tr>

<tr>
<th></th>
<td><?php doAction('user_register_footer')?></td>
</tr>

</table>
</form>
<?php } ?>
</div>

</div>
</div>
<?php include template('footer'); ?>