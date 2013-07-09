<?php
defined('IN_TS') or die('Access Denied.');

$eventid = intval($_GET['id']);

//活动信息
$strEvent = $new['event']->find('event',array(
	'eventid'=>$eventid,
));

$strEvent['title'] = htmlspecialchars($strEvent['title']);
$strEvent['address'] = htmlspecialchars($strEvent['address']);
$strEvent['content'] = trim($strEvent['content']);
$strEvent['coordinate'] = htmlspecialchars($strEvent['coordinate']);

$strEvent['user'] = aac('user')->getOneUser($strEvent['userid']);

$strEvent['type'] = $new['event']->find('event_type',array(
	
	'typeid'=>$strEvent['typeid'],

));

//wishdo
$isEventUser = 0;
if($TS_USER['user']['userid']){
	
	$userid = $TS_USER['user']['userid'];
	
	$isEventUser = $new['event']->findCount('event_users',array(
	
		'eventid'=>$strEvent['eventid'],
		'userid'=>$userid,
	
	));
	
}


//组织者
$arrOrganizers = $new['event']->findAll('event_users',array(
	'eventid'=>$strEvent['eventid'],
	'isorganizer'=>1,
));
foreach($arrOrganizers as $item){
	$arrOrganizer[] = aac('user')->getOneUser($item['userid']);
}


//参加这个活动的成员
$arrDoUsers = $new['event']->findAll('event_users',array(
	'eventid'=>$strEvent['eventid'],
	'status'=>0,
),'addtime desc');

foreach($arrDoUsers as $item){
	$arrDoUser[] = aac('user')->getOneUser($item['userid']);
}


//对这个活动感兴趣的人
$arrWishUsers = $new['event']->findAll('event_users',array(
	'eventid'=>$strEvent['eventid'],
	'status'=>1,
),'addtime desc');

foreach($arrWishUsers as $item){
	$arrWishUser[] = aac('user')->getOneUser($item['userid']);
}


//评论

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$url = tsUrl('event','show',array('id'=>$eventid,'page'=>''));

$lstart = $page*10-10;

$arrComments = $new['event']->findAll('event_comment',array(
	'eventid'=>$strEvent['eventid'],
),'addtime desc',null,$lstart.',10');

foreach($arrComments as $key=>$item){
	$arrComment[] = $item;
	$arrComment[$key]['user'] = aac('user')->getOneUser($item['userid']);
}

$commentNum = $new['event']->findCount('event_comment',array(
	'eventid'=>$strEvent['eventid'],
));

$pageUrl = pagination($commentNum, 10, $page, $url);

$title = $strEvent['title'];
include template("show");