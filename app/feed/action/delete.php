<?php 
defined('IN_TS') or die('Access Denied.');

$userid = aac('user')->isLogin();

$feedid = intval($_GET['feedid']);

if($TS_USER['user']['isadmin']==1){

	$new['feed']->delete('feed',array(
		'feedid'=>$feedid,
	));

}

tsNotice('动态删除成功！');