<?php 
	defined('IN_TS') or die('Access Denied.');
	$typeid = $_GET['typeid'];
	//调出活动类型 
	$arrEventType = AppCacheRead('event','types.php');
	
	//调出类型下面的活动 
	$arrEvents = $db->fetch_all_assoc("select eventid from ".dbprefix."app_event where typeid='$typeid'");
	if(is_array($arrEvents)){
		foreach($arrEvents as $item){
			$arrEvent[] = $new['event']->getEventByEventid($item['eventid']);
		}
	}
	
	$title = $arrEventType['list'][$typeid-1]['typename'];
	include template("type");