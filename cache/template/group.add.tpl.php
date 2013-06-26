<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php doAction('tseditor')?>

<div class="midder">
<div class="mc">
<div class="bbox pd20">

<h1>[<?php echo $strGroup['groupname'];?>]发布帖子</h1>

<?php if($isGroupUser == '0') { ?>
<div style="font-size:14px;padding-top:50px;text-align:center;">不好意思，你不是本组成员不能发表帖子，请加入后再发帖</div>
<?php } else { ?>
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=add&ts=do" onsubmit="return newTopicFrom(this)"  enctype="multipart/form-data">


<table width="100%">
<tbody>
<tr><td width="50">标题:</td>
<td><input style="padding:3px 0;width:600px;" type="text" name="title" /></td></tr>	

<?php if($arrGroupType) { ?>
<tr><td height="30">类型:</td><td>
<select name="typeid">
<option value="0">选择类型</option>
<?php foreach((array)$arrGroupType as $key=>$item) {?>
<option value="<?php echo $item['typeid'];?>"><?php echo $item['typename'];?></option>
<?php }?>
</select></td></tr>
<?php } ?>


<tr>
<td valign="top">
内容:
</td><td>
<textarea style="width:100%" type="text" id="tseditor" name="content"></textarea>

</td></tr>

<tr><td>标签:</td><td><input style="width:250px;" type="text" name="tag" /> (多个标签请用,号分割)</td></tr>

<tr><td>评论:</td><td><input type="radio" checked="select" name="iscomment" value="0" />允许 <input type="radio" name="iscomment" value="1" />不允许</td>
</tr>

<tr><td></td><td>
<input type="hidden" name="groupid" value="<?php echo $strGroup['groupid'];?>" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<button class="btn btn-success" type="submit">提交</button>

<a href="<?php echo tsurl('group','show',array('id'=>$strGroup['groupid']))?>" id="back">返回</a>
</td></tr>

</tbody>
</table>	

</form>
<?php } ?>
</div>


</div>
</div>
<?php include template('footer'); ?>