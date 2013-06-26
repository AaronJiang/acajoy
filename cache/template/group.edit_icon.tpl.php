<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div class="midder">

<div class="mc">

<div class="bbox pd10 mh400">

<?php include template('edit_xbar'); ?>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=do&ts=groupicon" enctype="multipart/form-data" >
<table style="clear: both;">
<tbody>
<tr>
<td valign="top">
     <img align="left" alt="<?php echo $strGroup['groupname'];?>" title="<?php echo $strGroup['groupname'];?>" valign="middle" src="<?php echo SITE_URL;?><?php if($strGroup['groupicon']) { ?><?php echo tsXimg($strGroup['groupicon'],'group','48','48',$strGroup['path'])?><?php } else { ?>public/images/group.jpg<?php } ?>" class="pil"></td>
     <td><div class="m">从你的电脑上选择图像文件：(仅支持jpg，gif，png格式图片)</div><br>
      <input type="file" name="picfile">
	  
<input type="hidden" name="groupid" value="<?php echo $strGroup['groupid'];?>" />
<input type="submit" value="上传照片" />
	  
    </td>
</tr></tbody></table>
</form>

</div>

</div>

</div>
<?php include template('footer'); ?>