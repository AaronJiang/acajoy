<?php
/*
 * callback返回页面
*
* @ silenceper@gmail.com
*   2012_09_26
* */
defined('IN_TS') or die('Access Denied.');

//callback返回  没有  $_SESSION['wb_uid'] 表示未授权
if(!$_SESSION['wb_uid']){
	qiMsg('请先使用weibo登入！',$button='点击返回>>',$url=SITE_URL.'index.php?app=pubs&ac=plugin&plugin=weibo&in=login', $isAutoGo=true);
}

require_once("config.php");
include_once( 'saetv2.ex.class.php' );
$c = new SaeTClientV2( $_SESSION['wb_akey']  , $_SESSION['wb_skey']  , $_SESSION['wb_token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$arr = $c->show_user_by_id( $uid);//根据ID获取用户等基本信

//debug
//echo '<pre>';
//var_dump($arr);exit;
//echo '</pre>';

$title = "新浪微博帐号登录信息完善";

include 'html/userinfo.html';
