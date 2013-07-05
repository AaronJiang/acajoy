<?php defined('IN_TS') or die('Access Denied.'); ?><div class="retopic">
<h3>推荐阅读帖子</h3>
<ul>
<?php foreach((array)$arrTopic as $key=>$item) {?>
<li><a href="<?php echo tsurl('group','topic',array('id'=>$item['topicid']))?>"><?php echo cututf8(t($item['title']),0,20,false)?></a></li>
<?php }?>
</ul>
</div>