<?php defined('IN_TS') or die('Access Denied.'); ?><div class="tabnav">
<ul>
<li <?php if($ac=='space') { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','space',array('id'=>$strUser['userid']))?>">首页</a></li>
<li <?php if($ac=='topic') { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','topic',array('id'=>$strUser['userid']))?>">帖子</a></li>
<li <?php if($ac=='group') { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','group',array('id'=>$strUser['userid']))?>">小组</a></li>
<li <?php if($ac=='guestbook') { ?>class="select"<?php } ?>><a href="<?php echo tsurl('user','guestbook',array('id'=>$strUser['userid']))?>">留言</a></li>
</ul>
</div>
