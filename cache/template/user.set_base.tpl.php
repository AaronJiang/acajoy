<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div class="midder">
<div class="mc">

<div class="bbox pd20">

<?php include template('set_menu'); ?>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=user&ac=do&ts=setbase">
<table width="100%">
<tr><th>用户名：</th><td><input name="username" value="<?php echo $strUser['username'];?>"  /></td></tr>

<tr><th>性别：</th><td>

<input <?php if($strUser['sex']=='0') { ?>checked="select"<?php } ?> name="sex" type="radio" value="0" />保密 
<input <?php if($strUser['sex']=='1') { ?>checked="select"<?php } ?> name="sex" type="radio" value="1" />男
<input <?php if($strUser['sex']=='2') { ?>checked="select"<?php } ?> name="sex" type="radio" value="2" />女

</td></tr>

<tr><th>电话：</th><td><input name="phone" value="<?php echo $strUser['phone'];?>"  /></td></tr>

<tr><th>博客：</th><td><input name="blog" value="<?php echo $strUser['blog'];?>"  /></td></tr>

<tr><th valign="top">自我介绍：</th><td><textarea style="height:100px;" name="about"><?php echo $strUser['about'];?></textarea></td></tr>

<tr><th valign="top">签名：</th><td>
<textarea style="height:100px;" name="signed"><?php echo $strUser['signed'];?></textarea>
</td></tr>

<tr><th></th><td>

<button class="btn btn-success" type="submit">修改</button>

</td></tr>

</table>
</div>

</div>
</div>
<?php include template('footer'); ?>