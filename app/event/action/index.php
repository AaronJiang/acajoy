<?php 
defined('IN_TS') or die('Access Denied.');
//调出活动类型 
// $arrEventType = AppCacheRead('event','types.php');

//一周热门
$arrEvents = $db->fetch_all_assoc("select eventid from ".dbprefix."app_event order by count_userdo desc limit 7");
foreach($arrEvents as $item){
	$arrEvent[] = $new['event']->getEventByEventid($item['eventid']);
}

//活动小组
$arrEventGroup = $db->fetch_all_assoc("select groupid from ".dbprefix."app_event_group_index group by groupid");

if(is_array($arrEventGroup)){
	foreach($arrEventGroup as $item){
		$arrGroup[] = aac('group',$db)->getOneGroup($item['groupid']);
	}
}

$title = '首页';
include template("index");