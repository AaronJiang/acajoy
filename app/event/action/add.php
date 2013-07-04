<?php
defined('IN_TS') or die('Access Denied.');

$userid = intval($TS_USER['user']['userid']);

if($userid =='0') header("Location: index.php");

$groupid = isset($_GET['groupid']) ? $_GET['groupid'] : '0';

//活动类型
$arrType = $db->fetch_all_assoc("select * from ".dbprefix."app_event_type");

//获取常驻地
$strUser = $db->once_fetch_assoc("select * from ".dbprefix."app_user_info where userid='$userid'");
if($strUser['provinceid'] != '0' || $strUser['cityid'] != '0' || $strUser['areaid'] != '0'){
	$strUser['province'] = $db->once_fetch_assoc("select * from ".dbprefix."app_location_province where provinceid = '".$strUser['provinceid']."'");
	$strUser['city'] = $db->once_fetch_assoc("select * from ".dbprefix."app_location_city where cityid = '".$strUser['cityid']."'");
	
	$arrArea = $db->fetch_all_assoc("select * from ".dbprefix."app_location_area where cityid='".$strUser['cityid']."'");

}else{
	qiMsg("你还没有填写常居地，不能发布活动！");
}

$title = '发布活动';
include template("add");