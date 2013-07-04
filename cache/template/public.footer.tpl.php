<?php defined('IN_TS') or die('Access Denied.'); ?><div class="footer">
<div>
<a href="http://www.acajoy.cn/home/phone/">手机客户端</a>  | 
<a href="<?php echo tsurl('home','info',array('key'=>'about'))?>">关于我们</a> | <a href="<?php echo tsurl('home','info',array('key'=>'contact'))?>">联系我们</a> | <a href="<?php echo tsurl('home','info',array('key'=>'agreement'))?>">用户条款</a> | <a href="<?php echo tsurl('home','info',array('key'=>'privacy'))?>">隐私申明</a>
 | <a href="<?php echo tsurl('home','info',array('key'=>'job'))?>">加入我们</a>
</div>
Powered by <a target="_blank" class="softname" href="<?php echo $TS_CF['info'][url];?>"><?php echo $TS_CF['info'][name];?></a> <?php echo $TS_CF['info'][version];?> Copyright ©  <?php echo $TS_CF['info'][year];?> <a target="_blank" href="<?php echo $TS_CF['info']['copyurl'];?>"><?php echo $TS_CF['info']['copyright'];?></a> <?php echo $TS_SITE['base'][site_icp];?><br /><span style="font-size:0.83em;">Processed in <?php echo $runTime;?> second(s)</span></div>
<?php if(intval($TS_USER['user']['userid'])) { ?>
<script src="<?php echo SITE_URL;?>public/js/imbox/imbox.js" type="text/javascript"></script>
<script>
var siteUid=<?php echo intval($TS_USER['user']['userid'])?>; //网站用户ID
evdata(siteUid);
</script>
<?php } ?>
<link href="<?php echo SITE_URL;?>public/js/artDialog/skins/simple.css" rel="stylesheet" />
<script src="<?php echo SITE_URL;?>public/js/artDialog/artDialog.min.js"></script>
<script src="<?php echo SITE_URL;?>public/js/artDialog/artDialog.plugins.min.js"></script>
<script src="<?php echo SITE_URL;?>public/js/common.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL;?>public/js/bootstrap.min.js" type="text/javascript"></script>
<?php doAction('pub_footer')?>
</body>
</html>
<?php if($TS_SITE['base'][isgzip]==1) { ?><?php ob_end_flush();?><?php } ?>