<?php 

defined('IN_TS') or die('Access Denied.');

$userid = aac('user')->isLogin();

$groupid = intval($_GET['groupid']);

$strGroup = $new['group']->find('group',array(
	'groupid'=>$groupid,
));

if($strGroup['userid']!=$userid || $TS_USER['user']['isadmin']!=1){
	header('Location: '.SITE_URL);
	exit;
}

switch($ts){

	case "":

		$arrTopic = $new['group']->findAll('group_topics',array(
			'groupid'=>$groupid,
			'isaudit'=>1,
		));

		$title = '审核帖子';
		include template('audit');
	
		break;
		
	//执行审核
	case "do":
		
		$topicid = intval($_GET['topicid']);
		
		$new['group']->update('group_topics',array(
			'topicid'=>$topicid,
		),array(
			'isaudit'=>'0',
		));
		
		$new['group']->countTopicAudit($groupid);
		
		tsNotice('审核成功！');
		
		break;
		
	//删除审核
	case "delete":
		$topicid = intval($_GET['topicid']);
		
		$new['group']->delTopic($topicid);
		
		tsNotice('删除成功！');
		
		break;

}