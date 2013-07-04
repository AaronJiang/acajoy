<?php
defined('IN_TS') or die('Access Denied.');
$eventid = intval($_GET['eventid']);

//活动信息
$strEvent = $new['event']->getEventByEventid($eventid);

$strEvent['user'] = simpleUser($strEvent['userid']);

$strEvent['content'] = hview($strEvent['content']);

//匹配本地图片
preg_match_all('/\[(photo)=(\d+)\]/is', $strEvent['content'], $photos);
foreach ($photos[2] as $item) {
	$strEvent['content'] = str_replace("[photo={$item}]",'<img src="'.getPhotoById($item).'" title="'.$strEvent['title'].$item.'" />', $strEvent['content']);
}

//匹配表情
preg_match_all('/\[(360):(\d+)\]/is', $strEvent['content'], $expression_topic);
foreach ($expression_topic[2] as $item) {
	$strEvent['content'] = str_replace("[360:{$item}]",'<img src="data/expression/'.$item.'.gif" />', $strEvent['content']);
}

$strEvent['content'] = ubb($strEvent['content']);

//wishdo
if($TS_USER['user']['userid'] != ''){
	$isEventUser = $db->once_num_rows("select * from ".dbprefix."app_event_users where eventid='".$strEvent['eventid']."' and userid='".$TS_USER['user']['userid']."'");
	$strEventUser = $db->once_fetch_assoc("select * from ".dbprefix."app_event_users where eventid='".$strEvent['eventid']."' and userid='".$TS_USER['user']['userid']."'");
}


//组织者
$arrOrganizers= $db->fetch_all_assoc("select userid from ".dbprefix."app_event_users where eventid='".$strEvent['eventid']."' and isorganizer='1'");
if(is_array($arrOrganizers)){
	foreach($arrOrganizers as $item){
		$arrOrganizer[] = simpleUser($item['userid']);
	}
}

//参加这个活动的成员
$arrDoUsers = $db->fetch_all_assoc("select userid from ".dbprefix."app_event_users where eventid='".$strEvent['eventid']."' and status='0' order by addtime limit 24");
if(is_array($arrDoUsers)){
	foreach($arrDoUsers as $item){
		$arrDoUser[] = aac('user',$db)->getOneUserByUserid($item['userid']);
	}
}

//对这个活动感兴趣的人
$arrWishUsers = $db->fetch_all_assoc("select userid from ".dbprefix."app_event_users where eventid='".$strEvent['eventid']."' and status='1' order by addtime limit 12");
if(is_array($arrWishUsers)){
	foreach($arrWishUsers as $item){
		$arrWishUser[] = aac('user',$db)->getOneUserByUserid($item['userid']);
	}
}

//哪些小组正在分享这个活动
$arrGroups = $db->fetch_all_assoc("select groupid from ".dbprefix."app_event_group_index where eventid='$eventid'");
if(is_array($arrGroups)){
	foreach($arrGroups as $item){
		$arrGroup[] = aac('group',$db)->getOneGroup($item['groupid']);
	}
}


//评论

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//URL
//if($TS_APP['options']['isrewrite']=='0'){
	//$url = $TS_URL['show'].$eventid.'&page=';
	$url = "index.php?app=event&ac=show&eventid=".$strEvent['eventid']."&page=";
//}else{
	//$url = $TS_URL['show'].$eventid.'-';
//}

$arrContentComment = $new['event']->getEventComment($page,5,$eventid);

if(is_array($arrContentComment)){
	foreach($arrContentComment as $key=>$item){
		$arrEventComment[] = $item;
		
		//$arrEventComment[$key]['content'] = hview(preg_replace($pattern, '<a rel="nofollow" target="_blank" href="\1\2">\1\2</a>', $item['content']));
		
		//匹配图片
		preg_match_all('/\[(photo)=(\d+)\]/is', $arrEventComment[$key]['content'], $photos);
		foreach ($photos[2] as $pitem) {
			$arrEventComment[$key]['content'] = str_replace("[photo={$pitem}]",'<img src="'.getPhotoById($pitem).'" />', $arrEventComment[$key]['content']);
		}

		//匹配表情
		preg_match_all('/\[(360):(\d+)\]/is', $arrEventComment[$key]['content'], $expression_comment);
		foreach ($expression_comment[2] as $sitem) {
			$arrEventComment[$key]['content'] = str_replace("[360:{$sitem}]",'<img src="data/expression/'.$sitem.'.gif" />', $arrEventComment[$key]['content']);
		}
		
		$arrEventComment[$key]['content'] = ubb($arrEventComment[$key]['content']);

	}
}

$eventCommentNum = $new['event']->getEventCommentNum('eventid',$eventid);

$pageUrl = pagination($eventCommentNum, 5, $page, $url,$TS_URL['suffix']);

$title = $strEvent['title'];
include template("show");

function simpleUser($userid){
	global $db;
	$userData = $db->once_fetch_assoc("select userid,username from ".dbprefix."app_user_info where userid='$userid'");
	return $userData;
}
function getPhotoById($photoid){
	global $db;
	$strPhoto = $db->once_fetch_assoc("select * from ".dbprefix."app_photo where photoid='$photoid'");
	
	return $strPhoto['photourl'];
}