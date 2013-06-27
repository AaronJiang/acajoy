<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<!--main-->
<div class="midder">
<div class="mc">

<div class="bbox pd20 mh400">

<h1>用户登陆</h1>

<div class="alert">如果您在网吧或者非个人电脑，建议设置Cookie有效期为 即时，以保证账户安全</div>

<div style="margin-left:125px;">
<form method="POST" action="<?php echo tsurl('user','login',array('ts'=>'do'))?>">
<table>
<tr><td>Email：<br /><input  type="text" name="email" /></td></tr>
<tr><td>密码：<br /><input  type="password" name="pwd" /></td></tr>

<tr>
<td>
Cookie有效期<br />
<select name="cktime">
		<option value="31536000">一年</option>
		<option value="2592000">一月</option>
		<option value="86400">一天</option>
		<option value="3600">一小时</option>
		<option value="0">即时</option>
	</select>
</td></tr>

<tr><td>
<input type="hidden" name="jump" value="<?php echo $jump;?>" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<button class="btn btn-success" type="submit">登陆</button> 
<br />
<a href="<?php echo tsurl('user','register')?>">还没有注册？</a> | <a href="<?php echo tsurl('user','forgetpwd')?>">忘记密码？</a></td></tr>
</table>
</form>

<div>
<?php doAction('user_login_footer')?>
</div>

</div>

</div>

</div>
</div>
<?php include template('footer'); ?>