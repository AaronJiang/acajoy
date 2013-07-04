<?php
	defined('IN_TS') or die('Access Denied.');
	$eventid = intval($_GET['eventid']);
	
	$userid = $TS_USER['user']['userid'];
	
	//活动信息
	$strEvent = $new['event']->getSimpleEvent($eventid);
	
	switch($ts){
		//基本信息
		case "base":
			//活动类型
			$arrType = $db->fetch_all_assoc("select * from ".dbprefix."app_event_type");

			//获取常驻地
			$strUser = $db->once_fetch_assoc("select * from ".dbprefix."app_user_info where userid='$userid'");
			
			$strUser['province'] = $db->once_fetch_assoc("select * from ".dbprefix."app_location_province where provinceid = '".$strUser['provinceid']."'");
			$strUser['city'] = $db->once_fetch_assoc("select * from ".dbprefix."app_location_city where cityid = '".$strUser['cityid']."'");

			$arrArea = $db->fetch_all_assoc("select * from ".dbprefix."app_location_area where cityid='".$strUser['cityid']."'");
			
			$title = '编辑活动信息';
			include template("edit_base");
			break;
		
		//活动封面 
		case "poster":
			$title = '编辑活动封面';
			include template("edit_poster");
			
			
			break;
			
		//活动组织者 
	}
	

	