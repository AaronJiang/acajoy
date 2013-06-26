<?php
/*
 * 登入页
*
* @ silenceper@gmail.com
*   2012_09_26
* */
defined('IN_TS') or die('Access Denied.');
require_once("config.php");

include_once( 'saetv2.ex.class.php' );
//根据wb_akey  wb_skey 生成请求页面
$o = new SaeTOAuthV2($_SESSION['wb_akey'] , $_SESSION['wb_skey'] );
$code_url = $o->getAuthorizeURL( $_SESSION['wb_callback'] );
header("location:$code_url");
