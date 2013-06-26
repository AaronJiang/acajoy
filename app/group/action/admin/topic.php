<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	
	case "list":
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=group&ac=admin&mg=topic&ts=list&page=';
		$lstart = $page*10-10;
		
		$arrTopic = $new['group']->findAll('group_topics',null,'addtime desc',null,$lstart.',10');
		
		$topicNum = $new['group']->findCount('group_topics');
		
		$pageUrl = pagination($topicNum, 10, $page, $url);

		include template("admin/topic_list");
		
		break;
		
	case "delete":
		$topicid = intval($_GET['topicid']);
		
		$strTopic = $new['group']->delTopic($topicid);

		qiMsg('删除成功');
		break;
	
	//帖子审核
	case "isaudit":
	
		$topicid = intval($_GET['topicid']);
		
		$strTopic = $new['group']->find('group_topics',array(
			'topicid'=>$topicid,
		));
		
		if($strTopic['isaudit']==0){
			$new['group']->update('group_topics',array(
				'topicid'=>$topicid,
			),array(
				'isaudit'=>1,
			));
		}
		
		if($strTopic['isaudit']==1){
			$new['group']->update('group_topics',array(
				'topicid'=>$topicid,
			),array(
				'isaudit'=>0,
			));
		}
		
		qiMsg('操作成功！');
	
		break;
		
}