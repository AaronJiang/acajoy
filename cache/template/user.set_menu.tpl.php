<?php defined('IN_TS') or die('Access Denied.'); ?><div class="tabnav">
<ul>
<li <?php if($ts=="base") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','set',array(ts=>base))?>">基本信息</a></li>
<li <?php if($ts=="face") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','set',array(ts=>face))?>">会员头像</a></li>
<li <?php if($ts=="pwd") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','set',array(ts=>pwd))?>">修改密码</a></li>

<li <?php if($ts=="email") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','set',array(ts=>email))?>">修改帐号</a></li>

<li <?php if($ts=="city") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','set',array(ts=>city))?>">常居地</a></li>

<li <?php if($ac=='verify') { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','verify')?>">用户验证<a/></li>

<li <?php if($ts=="tag") { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','set',array(ts=>tag))?>">个人标签</a></li>
</ul>
</div>