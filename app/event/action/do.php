<?php
defined('IN_TS') or die('Access Denied.');
switch($ts){

	//参加或者感兴趣活动
	case "dowish":
		$userid = intval($TS_USER['user']['userid']);
		
		if($userid == 0) {
			echo 0;exit;
		}
		
		$eventid = intval($_POST['eventid']);
		
		//0加入1感兴趣
		$status = intval($_POST['status']);

		$userNum = $new['event']->findCount('event_users',array(
		
			'eventid'=>$eventid,
			'userid'=>$userid,
		
		));
		
		if($userNum>0){
			echo 1;exit;
		}
		
		$new['event']->create('event_users',array(
			'eventid'=>$eventid,
			'userid'=>$userid,
			'status'=>$status,
			'addtime'=>time(),
		));
		
		//统计一下参加的
		$userDoNum = $new['event']->findCount('event_users',array(
			'eventid'=>$eventid,
			'status'=>0,
		));
		
		//统计感兴趣的
		$userWishNum = $new['event']->findCount('event_users',array(
			'eventid'=>$eventid,
			'status'=>1,
		));
		
		$new['event']->update('event',array(
			'eventid'=>$eventid,
		),array(
			'count_userdo'=>$userDoNum,
			'count_userwish'=>$userWishNum
		));
		
		//event
		$strEvent = $new['event']->find('event',array(
			'eventid'=>$eventid,
		));
		
		echo '2';
		
		break;
		
	//取消参加活动
	case "cancel":
		$userid = intval($TS_USER['user']['userid']);
		
		if($userid == 0) {
			echo 0;exit;
		}
		
		$eventid = intval($_POST['eventid']);
		
		$new['event']->delete('event_users',array(
		
			'eventid'=>$eventid,
			'userid'=>$userid,
		
		));
		
		//统计一下参加的
		$userDoNum = $new['event']->findCount('event_users',array(
			'eventid'=>$eventid,
			'status'=>0,
		));
		
		//统计感兴趣的
		$userWishNum = $new['event']->findCount('event_users',array(
			'eventid'=>$eventid,
			'status'=>1,
		));
		
		$new['event']->update('event',array(
			'eventid'=>$eventid,
		),array(
			'count_userdo'=>$userDoNum,
			'count_userwish'=>$userWishNum
		));
		
		echo '1';
		
		break;
		
	//参加活动
	case "do":
	
		$userid = intval($TS_USER['user']['userid']);
		
		if($userid == 0) {
			echo 0;exit;
		}
		
		$eventid = intval($_POST['eventid']);
		
		$new['event']->update('event_users',array(
			'eventid'=>$eventid,
			'userid'=>$userid,
		),array(
			'status'=>0,
		));
		
		//统计一下参加的
		$userDoNum = $new['event']->findCount('event_users',array(
			'eventid'=>$eventid,
			'status'=>0,
		));
		
		//统计感兴趣的
		$userWishNum = $new['event']->findCount('event_users',array(
			'eventid'=>$eventid,
			'status'=>1,
		));
		
		$new['event']->update('event',array(
			'eventid'=>$eventid,
		),array(
			'count_userdo'=>$userDoNum,
			'count_userwish'=>$userWishNum
		));
		
		echo '1';
		
		break;
		
}
