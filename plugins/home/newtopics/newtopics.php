<?php 
defined('IN_TS') or die('Access Denied.'); 

function newtopics(){

	//最新帖子	
	$arrNewTopics = aac('group')->findAll('group_topics',"`isshow`='0'  and `isaudit`='0'",'uptime desc',null,50);
	
	$arrTopics = aac('group')->findAll('group_topics',"`isaudit`='0' group by userid",'uptime desc',null,50);
	
	foreach($arrTopics as $key=>$item){
		foreach($arrNewTopics as $nkey=>$nitem){
			if($item['topicid']!=$nitem['topicid'] && $item['userid']==$nitem['userid']){
				if(count($arrTopics[$key]['topic'])<8){
					$arrTopics[$key]['topic'][] = $nitem;
				}
			}
		}
	}
	
	foreach($arrTopics as $key=>$item){
	
			$arrTopic[] = $item;
			$arrTopic[$key]['title']=htmlspecialchars($item['title']);
			$arrTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = aac('group')->getOneGroup($item['groupid']);
		
	}
	
	//print_r($arrTopic);
	
	include template('newtopics','newtopics');
	
}

function newtopics_css(){

	echo '<link href="'.SITE_URL.'plugins/home/newtopics/style.css" rel="stylesheet" type="text/css" />';

}

addAction('home_index_left','newtopics');
addAction('pub_header_top','newtopics_css');