<?php 
defined('IN_TS') or die('Access Denied.');
/*
 * 微博登入插件
 *
 * @ silenceper@gmail.com
 *   2012_09_26
 * */
function weibo_login_html(){
	echo '<br/><a href="'.SITE_URL.'index.php?app=pubs&ac=plugin&plugin=weibo&in=login"><img style="margin-top:20px;" align="absmiddle" src="'.SITE_URL.'plugins/pubs/weibo/images/weibo_login.png"></a>';
}

addAction('user_login_footer', 'weibo_login_html');
addAction('user_register_footer', 'weibo_login_html');