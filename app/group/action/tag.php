<?php 
defined('IN_TS') or die('Access Denied.');

$name = urldecode(trim($_GET['id']));

$tagid = aac('tag')->getTagId(t($name));

$strTag = $new['group']->find('tag',array(
	'tagid'=>$tagid,
));

$strTag['tagname'] = htmlspecialchars($strTag['tagname']); 

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$url = tsUrl('group','tag',array('id'=>urlencode($name),'page'=>''));

$lstart = $page*30-30;

$arrTagId = $new['group']->findAll('tag_topic_index',array(
	'tagid'=>$tagid,
),null,null,$lstart.',30');

foreach($arrTagId as $item){
	$strTopic = $new['group']->find('group_topics',array(
		'topicid'=>$item['topicid'],
	));
	if($strTopic==''){
		$new['group']->delete('tag_topic_index',array(
			'topicid'=>$item['topicid'],
			'tagid'=>$item['tagid'],
		));
	}
	
	if($strTopic){
		$arrTopics[] = $strTopic;
	}
}

$arrTagIds = $new['group']->findAll('tag_topic_index',array(
	'tagid'=>$tagid,
));
foreach($arrTagIds as $item){
	$strTopic = $new['group']->find('group_topics',array(
		'topicid'=>$item['topicid'],
	));
	if($strTopic==''){
		$new['group']->delete('tag_topic_index',array(
			'topicid'=>$item['topicid'],
			'tagid'=>$item['tagid'],
		));
	}
}

aac('tag')->countObjTag('topic',$tagid);

$topicNum = $new['group']->findCount('tag_topic_index',array(
	'tagid'=>$tagid,
));

$pageUrl = pagination($topicNum, 30, $page, $url);

foreach($arrTopics as $key=>$item){
	$arrTopic[] = $item;
	$arrTopic[$key]['title'] = htmlspecialchars($item['title']);
	$arrTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
	$arrTopic[$key]['group'] = $new['group']->getOneGroup($item['groupid']);
}

//热门tag
$arrTag = $new['group']->findAll('tag',null,'count_topic desc',null,30);

$title = $strTag['tagname'];

include template("tag");