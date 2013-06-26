<?php 
defined('IN_TS') or die('Access Denied.');
/*
 *QQ登录插件
 *By QiuJun 2011-07-28
 */

//登录
function qq_login_html(){
	echo '<a href="'.SITE_URL.'index.php?app=pubs&ac=plugin&plugin=qq&in=login"><img align="absmiddle" src="'.SITE_URL.'plugins/pubs/qq/images/login.png"></a>';
}

addAction('user_login_footer', 'qq_login_html');