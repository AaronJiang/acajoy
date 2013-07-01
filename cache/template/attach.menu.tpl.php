<?php defined('IN_TS') or die('Access Denied.'); ?><div class="clear"></div>
<div class="tabnav">
<ul>
<li <?php if($ac=='index') { ?>class="select"<?php } ?>><a href="<?php echo tsurl('attach')?>">最新资料库</a></li>
<li <?php if($ac=='create') { ?>class="select"<?php } ?>><a href="<?php echo tsurl('attach','create')?>">+创建新资料库</a></li>
</ul>
</div>
<div class="clear"></div>