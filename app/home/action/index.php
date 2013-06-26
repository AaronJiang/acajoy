<?php
defined('IN_TS') or die('Access Denied.');

//首页

//if($_GET){
	//header('Location: '.SITE_URL);
//}

$title = $TS_SITE['base']['site_subtitle'];

include template("index");
/*
if($TS_USER['user'] == ''){

	if($_GET){
		header('Location: '.SITE_URL);
	}
	
	$title = $TS_SITE['base']['site_subtitle'];

	include template("index");
	
}else{
	
	$userid = aac('user')->isLogin();
	
	$strUser = aac('user')->getOneUser($userid);

	$strUser['rolename'] = aac('user')->getRole($strUser['count_score']);
	
	
	//关注的用户的各种动态
	
	//判断用户是否有关注的小组,用户,标签
	$isFollowGroup = $new['home']->findCount('group_users',array(
		'userid'=>$userid,
	));
	$isFollowUser = $new['home']->findCount('user_follow',array(
		'userid'=>$userid,
	));
	
	//没有关注就推荐
	if($isFollowGroup == 0){
		//推荐小组
		$arrGroup = $new['home']->findAll('group',array(
			'isrecommend'=>1,
		));
	}
	
	if($isFollowUser == 0){
		//推荐用户
		$arrUser = $new['home']->findAll('user_info',array(
			'isrecommend'=>1,
		));
	}
	
	$title = '我关注的';
	include template('my');
	
}
*/