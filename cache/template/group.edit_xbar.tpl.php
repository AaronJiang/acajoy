<?php defined('IN_TS') or die('Access Denied.'); ?><div class="tabnav">
<ul>
<li <?php if($ts=="base") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('group','edit',array('groupid'=>$strGroup['groupid'],'ts'=>'base'))?>">基本信息</a></li>

<li <?php if($ts=="icon") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('group','edit',array('groupid'=>$strGroup['groupid'],'ts'=>'icon'))?>">小组图标</a></li>

<li <?php if($ts=="type") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('group','edit',array('groupid'=>$strGroup['groupid'],'ts'=>'type'))?>">帖子分类</a></li>

<li <?php if($ts=="cate") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('group','edit',array('groupid'=>$strGroup['groupid'],'ts'=>'cate'))?>">小组分类</a></li>

</ul>
</div>