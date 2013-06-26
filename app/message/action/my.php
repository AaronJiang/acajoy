<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

$arrToUsers = $db->fetch_all_assoc("select userid from ".dbprefix."message where userid > '0' and touserid='$userid' group by userid order by addtime desc");

if(is_array($arrToUsers)){
	foreach($arrToUsers as $key=>$item){
		$arrToUser[] = $item;
		$arrToUser[$key]['user'] = aac('user')->getOneUser($item['userid']);
		$arrToUser[$key]['count'] = $new['message']->findCount('message',array(
			'touserid'=>$userid,
			'userid'=>$item['userid'],
			'isread'=>0,
		));
		
	}
}

//统计系统消息
$systemNum = $new['message']->findCount('message',array(
	'userid'=>0,
	'touserid'=>$userid,
	'isread'=>0,
));

$title = '我的消息盒子';

include template("my");