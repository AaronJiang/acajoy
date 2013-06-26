<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php doAction('tseditor')?>
<div class="midder">

<div class="mc">

<div class="bbox pd10">

<?php include template('edit_xbar'); ?>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=do&ts=edit_base">
<table align="center" style="width:100%;">
    <tbody>
	<tr><td valign="top" width="100">名称：</td>
    <td><input type="text" style="width:500px;" value="<?php echo $strGroup['groupname'];?>" name="groupname"><br><br></td></tr>
    <tr><td valign="top">介绍：</td>
    <td><textarea style="width:510px;" name="groupdesc" id="tseditor-mt"><?php echo $strGroup['groupdesc'];?></textarea><br><br></td></tr>
	
	<tr><td>加入方式：</td><td><input <?php if($strGroup['joinway']=='0') { ?>checked="select"<?php } ?> name="joinway" type="radio" value="0" />自由加入(开放小组) <input <?php if($strGroup['joinway']=='1') { ?>checked="select"<?php } ?>  name="joinway" type="radio" value="1" />禁止加入(私密小组)</td></tr>
	

	<tr><td>发帖方式：</td><td><input <?php if($strGroup['ispost']=='0') { ?>checked="select"<?php } ?> type="radio" name="ispost" value="0" />允许会员发帖 <input <?php if($strGroup['ispost']=='1') { ?>checked="select"<?php } ?> type="radio" name="ispost" value="1" />不允许会员发帖</td></tr>
	
	
	<tr><td>浏览权限：</td><td><input <?php if($strGroup['isopen']=='0') { ?>checked="select"<?php } ?> type="radio" name="isopen" value="0" />完全开放 <input <?php if($strGroup['isopen']=='1') { ?>checked="select"<?php } ?> type="radio" name="isopen" value="1" />仅组员</td></tr>
	
	<tr><td>发帖审核：</td><td><input <?php if($strGroup['ispostaudit']=='1') { ?>checked="select"<?php } ?> type="radio" name="ispostaudit" value="1" />审核 <input <?php if($strGroup['ispostaudit']=='0') { ?>checked="select"<?php } ?> type="radio" name="ispostaudit" value="0" />不审核</td></tr>
	
	
    <tr><td></td><td><br>
	
	<input type="hidden" name="groupid" value="<?php echo $strGroup['groupid'];?>" />
	
	 <button class="btn btn-success" type="submit">更新设置</button>  <a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid']))?>">返回</a>
	 
    </td></tr></tbody></table>
</form>

</div>

</div>

</div>
<?php include template('footer'); ?>