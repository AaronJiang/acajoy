<?php defined('IN_TS') or die('Access Denied.'); ?><div class="bbox pd10">
<div class="btitle">最新文章</div>
<div class="commlist">
<ul>
<?php foreach((array)$arrArticle as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo htmlspecialchars($item['title'])?></a></li>
<?php }?>
</ul>
</div>
</div>