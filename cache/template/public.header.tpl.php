<?php defined('IN_TS') or die('Access Denied.'); ?><?php if($TS_SITE['base'][isgzip]==1) { ?><?php ob_start('ob_gzip');?><?php } ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="all" />
<meta name="author" content="<?php echo $TS_CF['info'][email];?>" />
<meta name="Copyright" content="<?php echo $TS_CF['info'][name];?>" />
<title><?php if($app=='home' && $ac=='index') { ?><?php echo $TS_SITE['base'][site_title];?> - <?php echo $title;?><?php } elseif ($app!='home' && $ac=='index') { ?><?php echo $TS_APP['options'][appname];?> - <?php echo $TS_SITE['base'][site_title];?><?php } else { ?><?php echo $title;?> - <?php echo $TS_SITE['base'][site_title];?><?php } ?>
</title>
<?php if($app=='home' && $ac=='index') { ?>
<meta name="keywords" content="<?php echo $TS_SITE['base'][site_key];?>" /> 
<meta name="description" content="<?php echo $TS_SITE['base'][site_desc];?>" /> 
<?php } else { ?>

<?php } ?>
<link rel="shortcut icon" href="<?php echo SITE_URL;?>favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>theme/sample/base.css" />
<?php if(is_file('theme/'.$tstheme.'/style.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>theme/<?php echo $tstheme;?>/style.css" id="tsTheme" />
<?php } ?>
<?php if(is_file('app/'.$app.'/skins/'.$skin.'/style.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/style.css">
<?php } ?>
<script>
var siteUrl = '<?php echo SITE_URL;?>'; //网站网址
</script>
<script src="<?php echo SITE_URL;?>public/js/jquery-1.7.1.min.js" type="text/javascript"></script>

<script src="<?php echo SITE_URL;?>public/js/jquery.inputDefault.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/validform/Validform_v5.3.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>public/js/validform/css/style.css" />

<?php if(is_file('app/'.$app.'/js/extend.func.js')) { ?>
<script src="<?php echo SITE_URL;?>app/<?php echo $app;?>/js/extend.func.js" type="text/javascript"></script>
<?php } ?>
<?php doAction('pub_header_top')?>
</head>
<body>
<div class="header">
<div class="hc">
<div class="left">
<a class="logo" href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>"></a></div>
<div class="nav">
<ul>
<li><a href="<?php echo SITE_URL;?>">首页</a></li>
<?php doAction('pub_header_nav')?>
<li><a href="<?php echo tsurl('group','explore')?>">随便看看</a></li>
</ul>
</div>

<div class="right">
<?php if($TS_USER['user'] == '') { ?>
<a href="<?php echo tsurl('user','register')?>"><img class="fimg" src="<?php echo SITE_URL;?>public/images/user_normal.jpg" width="24" height="24" align="absmiddle" alt="欢迎" /></a> 欢迎
<br />
<a href="<?php echo tsurl('user','login')?>">登陆</a> | <a href="<?php echo tsurl('user','register')?>">注册</a>
<?php } else { ?>
<a href="<?php echo tsurl('user','space',array('id'=>$TS_USER['user'][userid]))?>">
<img class="fimg" src="<?php if($TS_USER['user'][face]=="") { ?><?php echo SITE_URL;?>public/images/user_normal.jpg<?php } else { ?><?php echo SITE_URL;?><?php echo tsXimg($TS_USER['user'][face],'user','24','24',$TS_USER['user'][path],'1')?><?php } ?>" width="24" align="absmiddle" alt="<?php echo $TS_USER['user']['username'];?>" /> 
</a>
<a href="<?php echo tsurl('user','space',array('id'=>$TS_USER['user'][userid]))?>"><?php echo $TS_USER['user'][username];?></a>   |  <a href="<?php echo tsurl('user','set',array(ts=>base))?>" >设置</a> | <span id="newmsg"></span> <a href="<?php echo tsurl('message','my')?>">消息</a>
<br>


<?php if($TS_SITE['base']['isinvite']=='1') { ?>
  <a href="<?php echo tsurl('user','invite')?>">邀请</a> |   
<?php } ?>
 
  <a href="<?php echo tsurl('user','login',array(ts=>out))?>">退出</a>
<?php } ?>

| <a href="<?php echo tsurl('home','theme')?>">换肤</a>

<?php if($TS_USER['user']['isadmin']=='1') { ?>
|  <a target="_blank" href="<?php echo SITE_URL;?>index.php?app=system">管理</a>
<?php } ?>

</div>
<div class="search">
<form method="GET" action="<?php echo SITE_URL;?>index.php">
<input type="hidden" name="app" value="search" />
<input type="hidden" name="ac" value="s" />
<div class="search_input">
<input id="searchkw" name="kw" value="" fs="小组|话题|用户" />
</div>
<a onclick="searchon()" style="background-position: -157px 0px;">搜索</a>
<span style="display:none;"><input id="searchto" type="submit" value="搜索" /></span>
</form>
</div>

</div>
</div>
<?php if(is_array($TS_SITE['appnav']) && $TS_SITE['appnav'][$app] !='') { ?>
<div class="appnav">
<ul>
<?php foreach((array)$TS_SITE['appnav'] as $key=>$item) {?>
<li <?php if($app==$key) { ?>class="select"<?php } ?>><a href="<?php echo tsurl($key)?>"><?php echo $item;?></a>
</li>
<?php }?>
<li><a href="<?php echo tsurl('home','apps')?>">更多</a></li>
</ul>
</div>
<?php } ?>