<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php doAction('tseditor')?>
<div class="midder">
<div class="mc">


<div class="cleft">

<div class="bbox pd10">
<h1><?php echo htmlspecialchars($strArticle['title'])?></h1>
<?php if($strArticle['tags']) { ?>
<div class="tags">
<?php foreach((array)$strArticle['tags'] as $key=>$item) {?>
<a href="#"><?php echo $item['tagname'];?></a>
<?php }?>
</div>
<div class="clear"></div>
<?php } ?>

<div class="tar c9">
<div style="float:left"><?php doAction('aritcle_rating_get')?></div>
<a href="<?php echo tsurl('user','space',array('id'=>$strArticle['user'][userid]))?>"><?php echo $strArticle['user'][username];?></a> 发表于 <?php echo $strArticle['addtime'];?>
</div>

<div class="fs14 lh30">
<?php echo $strArticle['content'];?>
</div>

<div class="tar">
<div style="float:left">
<?php doAction('aritcle_rating_set')?>
</div>
<a class="btn" href="javascript:void('0');" onclick="recommend('<?php echo $strArticle['articleid'];?>');"><?php echo $strArticle['count_recommend'];?>推荐</a>
<a class="btn" href=""><?php echo $strArticle['count_comment'];?>评论</a>
</div>
<div class="tar pd100">
<!-- JiaThis Button BEGIN -->
<div class="jiathis_style_24x24">
	<a class="jiathis_button_qzone"></a>
	<a class="jiathis_button_tsina"></a>
	<a class="jiathis_button_tqq"></a>
	<a class="jiathis_button_renren"></a>
	<a class="jiathis_button_kaixin001"></a>
	<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
	<a class="jiathis_counter_style"></a>
</div>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1372661040626900" charset="utf-8"></script>
<!-- JiaThis Button END -->
<?php if($TS_USER['user'][isadmin]==1) { ?>
<a href="<?php echo SITE_URL;?>index.php?app=article&ac=edit&articleid=<?php echo $strArticle['articleid'];?>">修改</a> 
<a href="<?php echo SITE_URL;?>index.php?app=article&ac=delete&articleid=<?php echo $strArticle['articleid'];?>">删除</a>
<?php } ?>
</div>
<br>

<div class="clear"></div>

<div class="btitle">推荐阅读</div>

<div class="commlist">

<ul>
<?php foreach((array)$arrArticle as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo htmlspecialchars($item['title'])?></a> <?php echo $item['addtime'];?></li>
<?php }?>
</ul>

</div>

<div class="btitle pd100">你的回应</div>

<ul class="comment">
<?php foreach((array)$arrComment as $key=>$item) {?>
<li class="clearfix">
<div class="user-face">
<a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>"><img title="<?php echo $item['user'][username];?>" alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>"></a>
</div>
<div class="reply-doc">
<h4>
<?php echo date('Y-m-d H:i:s',$item['addtime'])?> 
<a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>"><?php echo $item['user'][username];?></a>
</h4>
<p><?php echo $item['content'];?></p>
<?php if($TS_USER['user'][userid] == $strArticle['userid'] || $TS_USER['user']['isadmin']==1) { ?>
<div class="group_banned">
<span><a class="j a_confirm_link" href="<?php echo SITE_URL;?>index.php?app=article&ac=comment&ts=delete&commentid=<?php echo $item['commentid'];?>" rel="nofollow">删除</a>
</span>
</div>
<?php } ?>
</div>
</li>
<?php }?>
</ul>

<div class="page"><?php echo $pageUrl;?></div>

<div class="btitle">你的回复</div>
<div>
<?php if(intval($TS_USER['user'][userid])==0) { ?>
<div class="pd20 tac"><a href="<?php echo tsurl('user','login')?>">登录</a> | <a href="<?php echo tsurl('user','register')?>">注册</a></div>
<?php } else { ?>
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=article&ac=comment&ts=do" onSubmit="return submitonce(this)" id="formMini">
<textarea style="width:100%;" id="tseditor-mini" name="content"></textarea>
<p>
<input type="hidden" name="articleid" value="<?php echo $strArticle['articleid'];?>" />

<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />

<button class="btn btn-success" type="submit">回复</button>
</p>
</form>
<?php } ?>
</div>

</div>
</div>

<div class="cright">

<div class="bbox pd10">
<div class="btitle">生活篇</div>

<div class="catelist">
<ul>
<?php foreach((array)$arrCate as $key=>$item) {?>
<li><a <?php if($strCate['cateid']==$item['cateid']) { ?>class="on"<?php } ?> href="<?php echo tsurl('article','cate',array('id'=>$item['cateid']))?>"><?php echo $item['catename'];?></a></li>
<?php }?>
</ul>
</div>

</div>

<div class="facebox bbox pd10">
<div class="face">
<a href="<?php echo tsurl('user','space',array('id'=>$strArticle['user'][userid]))?>" rel="face" uid="<?php echo $strArticle['user'][userid];?>"><img title="<?php echo $strArticle['user'][username];?>" alt="<?php echo $strArticle['user'][username];?>" src="<?php echo $strArticle['user'][face];?>" width="48"></a>
</div>

<div class="info">
<h3><a href="<?php echo tsurl('user','space',array('id'=>$strArticle['user'][userid]))?>"><?php echo $strArticle['user'][username];?></a></h3>
<div><a class="btn btn-mini" href="javascript:void('0')" onclick="follow('<?php echo $strArticle['user']['userid'];?>');">关注</a></div>
</div>
</div>

<div class="bbox pd10">
<div class="btitle">一周热门</div>

<div class="commlist">
<ul>
<?php foreach((array)$arrHot7 as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo $item['title'];?></a></li>
<?php }?>
</ul>
</div>

</div>

<div class="bbox pd10">
<div class="btitle">一月热门</div>

<div class="commlist">
<ul>
<?php foreach((array)$arrHot30 as $key=>$item) {?>
<li><a href="<?php echo tsurl('article','show',array('id'=>$item['articleid']))?>"><?php echo $item['title'];?></a></li>
<?php }?>
</ul>
</div>

</div>

<div class="clear"></div>
<!--广告位-->
<?php doAction('gobad','300')?>
</div>

</div>
</div>
<?php include template('footer'); ?>