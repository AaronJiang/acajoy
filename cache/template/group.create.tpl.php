<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php doAction('tseditor')?>
<script>
$(document).ready(function() {

//选择一级区域
$('#cateid').change(function(){
	$("#select2").html('<img src="'+siteUrl+'public/images/loading.gif" />');
	var cateid = $(this).children('option:selected').val();  //弹出select的值
	
	if(cateid==0){
		$("#select2").html('');
		$("#select3").html('');
	}else{
		$("#select3").html('');
		$.ajax({
			type: "GET",
			url:  "<?php echo SITE_URL;?>index.php?app=group&ac=cate&ts=two&cateid="+cateid,
			success: function(msg){
				$("#select2").html(msg);
				
				//选择二级区域
				$('#cateid2').change(function(){
					$("#select3").html('<img src="'+siteUrl+'public/images/loading.gif" />');
					var cateid2 = $(this).children('option:selected').val();  //弹出select的值
					
					if(cateid2 == 0){
						$("#select3").html('');
					}else{
					
						//ajax
						$.ajax({
							type: "GET",
							url:  "<?php echo SITE_URL;?>index.php?app=group&ac=cate&ts=three&cateid2="+cateid2,
							success: function(msg){
								$('#select3').html(msg);
							}
						});
					
					}

				});
				
			}
		});
	
	}
	
});

});
</script>

<div class="midder">
<div class="mc">
<div class="bbox pd20">
<h1>申请创建小组</h1>
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=create&ts=do"  enctype="multipart/form-data">
<table width="100%">
<tbody>
<tr><td valign="top">名称*</td>
<td><input type="text" style="width:500px;" name="groupname"><br><br></td></tr>

<tr><td valign="top">介绍*</td>
<td><textarea style="width:510px;" id="tseditor-mt" name="groupdesc"></textarea><br><br></td></tr>

<tr>
<td>图标：</td>
<td><input type="file" name="picfile"> 仅支持jpg，gif，png格式图片</td>
</tr>

<tr>
<td>分类：</td>
<td>

<select id="cateid" name="cateid">
<option value="0">请选择分类</option>
<?php foreach((array)$arrCate as $key=>$item) {?>
<option value="<?php echo $item['cateid'];?>"><?php echo $item['catename'];?></option>
<?php }?>
</select>

<span id="select2"></span>
<span id="select3"></span>


</td>
</tr>

<tr><td></td><td>
<br><br>
<input type="checkbox" name="grp_agreement" value="1" checked />我已认真阅读并同意<a href="">《社区指导原则》</a>和<a href="">《免责声明》</a>
<br><br>
</td>
</tr>

<tr><td></td><td>
<button class="btn btn-success" type="submit">创建小组</button>
</td></tr></tbody>
</table>
</form>
</div>
</div>

</div>
<?php include template('footer'); ?>