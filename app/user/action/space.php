<?php
defined('IN_TS') or die('Access Denied.');

//用户空间
include 'userinfo.php';


//动态
$arrFeeds = $new['user']->findAll('feed',array(
	'userid'=>$strUser['userid'],
),'addtime desc',null,'20');

foreach($arrFeeds as $key=>$item){

	$arrFeed[] = $item;
	$arrFeed[$key]['app'] = aac('feed')->find($item['apptable'],array(
		$item['appkey']=>$item['appid'],
	));
	$arrFeed[$key]['app']['title'] = htmlspecialchars($arrFeed[$key]['app']['title']);
	//$arrFeed[$key]['app']['content'] = aac('feed')->hview($arrFeed[$key]['app']['content']);

	if($item['commentid']){
		$arrFeed[$key]['comment'] = aac('feed')->find($item['commenttable'],array(
			$item['commentkey']=>$item['commentid'],
		),'content');
		//$arrFeed[$key]['comment']['content'] = aac('feed')->hview($arrFeed[$key]['comment']['content']);
	}
	$arrFeed[$key]['user'] = aac('user')->getOneUser($item['userid']);

}


//留言
$arrGuests = $new['user']->findAll('user_gb',array(
	'touserid'=>$strUser['userid'],
),'addtime desc',null,10);

foreach($arrGuests as $key=>$item){
	$arrGuest[] = $item;
	$arrGuest[$key]['user']=$new['user']->getOneUser($item['userid']);
}

$title = $strUser['username'];
include template("space");
