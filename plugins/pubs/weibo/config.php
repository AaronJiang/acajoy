<?php
defined('IN_TS') or die('Access Denied.');
if (defined("QQDEBUG") && QQDEBUG)
{
    //@ini_set("error_reporting", E_ALL);
    @ini_set("display_errors", TRUE);
}
/*
 * 将微博key 及callback存放在session中
 * */

//读取数据
$arr_weibvo = include_once 'data.php';
//存放在session中
$_SESSION["wb_akey"]    = $arr_weibvo['wb_akey']; 

$_SESSION["wb_skey"]   = $arr_weibvo['wb_skey']; 

$_SESSION["wb_callback"] = $arr_weibvo['siteurl']."index.php?app=pubs&ac=plugin&plugin=weibo&in=callback";
