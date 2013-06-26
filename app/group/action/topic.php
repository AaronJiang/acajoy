<?php
defined('IN_TS') or die('Access Denied.');

switch ($ts){

	//帖子页
	case "":
	
		if(!$_GET['id']){
			header("HTTP/1.1 404 Not Found");
			header("Status: 404 Not Found");
			$title = '404';
			include pubTemplate("404");
			exit;
		}
		
		$topicid = intval($_GET['id']);
		
		$strTopic = $new['group']->find('group_topics',array(
			'topicid'=>$topicid,
		));
		$strTopic['title'] = htmlspecialchars($strTopic['title']);
		$strTopic['content'] = nl2br($strTopic['content']);
		
		if($strTopic['title']==''){
			header("HTTP/1.1 404 Not Found");
			header("Status: 404 Not Found");
			$title = '404';
			include pubTemplate("404");
			exit;
		}
		
		//帖子审核 
		if($strTopic['isaudit']==1){
			tsNotice('帖子审核中......');
		}
		
		// 帖子分类
		if ($strTopic['typeid'] != '0')
		{
			$strTopic['type'] = $new['group']->find('group_topics_type', array(
				'typeid' => $strTopic['typeid'],
			));
		} 
		// 小组
		$strGroup = $new['group']->find('group', array(
			'groupid' => $strTopic['groupid'],
		));

		$strTopic['content'] = preg_replace("/\[@(.*)\:(.*)]/U","<a href='".tsUrl('user','space',array('id'=>'$2'))." ' rel=\"face\" uid=\"$2\"'>@$1</a>",$strTopic['content']);
		
		// 补贴列表
		$arrAfter = $new['group']->topicAfter($strTopic['topicid']);

		foreach($arrAfter as $key => $item)
		{
			$strTopic['after'][] = $item;
			$strTopic['after'][$key]['content'] = $item['content'];
		} 
		// 判断会员是否加入该小组
		$groupid = intval($strGroup['groupid']);
		$userid = intval($TS_USER['user']['userid']);

		$isGroupUser = $new['group']->findCount('group_users', array('userid' => $userid,
				'groupid' => $groupid,
				)); 
		// 判断用户是否回复帖子
		$isComment = $new['group']->findCount('group_topics_comments', array('userid' => $userid,
				'topicid' => $strTopic['topicid'],
				)); 
		// 最新帖子
		$newTopic = $new['group']->newTopic($strTopic['groupid'], 10); 
		// 浏览方式
		if ($strGroup['isopen'] == '1' && $isGroupUser == '0')
		{
			$title = $strTopic['title'];
			include template("topic_isopen");
		}
		else
		{ 
			// 上一篇帖子
			$upTopic = $new['group']->find('group_topics', 'topicid<' . $topicid . ' and groupid=' . $groupid, 'topicid,title','addtime desc'); 
			if($upTopic['title']){
				$upTopic['title']=htmlspecialchars($upTopic['title']);
			}
			// 下一篇帖子
			$downTopic = $new['group']->find('group_topics', 'topicid>' . $topicid . ' and groupid=' . $groupid, 'topicid,title','addtime asc'); 
			if($downTopic['title']){
				$downTopic['title']=htmlspecialchars($downTopic['title']);
			}
			// 帖子标签
			$strTopic['tags'] = aac('tag')->getObjTagByObjid('topic', 'topicid', $topicid);
			$strTopic['user'] = aac('user')->getOneUser($strTopic['userid']);
			
			$title = $strTopic['title']; 
			// 评论列表开始
			$sc = isset($_GET['sc']) ? $_GET['sc'] : 'asc';

			$page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
			// 倒序asc
			if ($sc == 'desc')
			{
				$url = tsUrl('group', 'topic', array('id' => $topicid, 'sc' => $sc, 'page' => ''));
			}
			else
			{
				$url = tsUrl('group', 'topic', array('id' => $topicid, 'page' => ''));
			}

			$lstart = $page * 15-15;
			
			$arrComment = $new['group']->findAll('group_topics_comments',array(
				'topicid'=>$topicid,
			),'addtime '.$sc,null,$lstart.',15');
			
			foreach($arrComment as $key => $item)
			{
				$arrTopicComment[] = $item;
				$arrTopicComment[$key]['l'] = (($page-1) * 15) + $key + 1;
				$arrTopicComment[$key]['user'] = aac('user')->getOneUser($item['userid']);

				$arrTopicComment[$key]['content'] = preg_replace("/\[@(.*)\:(.*)]/U","<a href='".tsUrl('user','space',array('id'=>'$2'))." ' rel=\"face\" uid=\"$2\"'>@$1</a>",$arrTopicComment[$key]['content']);	
				
				$arrTopicComment[$key]['recomment'] = $new['group']->recomment($item['referid']);
			}
			
			$commentNum = $new['group']->findCount('group_topics_comments',array(
				'topicid'=>$strTopic['topicid'],
			));

			$pageUrl = pagination($commentNum, 15, $page, $url); 
			// 评论列表结束
			// 判断会员是否加入该小组
			
			$isGroupUser = 0;
			$strGroupUser = array();
			if(intval($TS_USER['user']['userid'])){
				$isGroupUser = $new['group']->findCount('group_users',array(
					'userid'=>intval($TS_USER['user']['userid']),
					'groupid'=>$strTopic['groupid'],
				));
				
				$strGroupUser = $new['group']->find('group_users',array(
					'userid'=>intval($TS_USER['user']['userid']),
					'groupid'=>$strTopic['groupid'],
				));
				
			}
			
			//7天内的热门帖子
			$arrHotTopic = $new['group']->getHotTopic(7);
			
			include template('topic'); 
			
			// 增加浏览次数
			$new['group']->update('group_topics', array(
				'topicid' => $strTopic['topicid'],
			), array(
				'count_view' => $strTopic['count_view'] + 1,
			));
		}
		
		break; 
	
	// 全部帖子
	case "list":
		$page = isset($_GET['page']) ? $_GET['page'] : '1';
		$url = tsUrl('group', 'topic', array('ts' => 'list', 'page' => ''));
		$lstart = $page * 20-20;

		$arrTopics = $new['group']->findAll('group_topics', null, 'topicid desc', null, $lstart . ',20');

		foreach($arrTopics as $key => $item)
		{
			$arrTopic[] = $item;
			$arrTopic[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = $new['group']->getOneGroup($item['groupid']);
			$arrTopic[$key]['title'] = htmlspecialchars($item['title']);
			$arrTopic[$key]['content'] = cututf8($item['content'], 0, 200);
		}

		$topicNum = $new['group']->findCount('group_topics');

		$pageUrl = pagination($topicNum, 20, $page, $url); 
		// 热门帖子
		$arrHotTopics = $new['group']->findAll('group_topics', null, 'count_comment desc', 'groupid,topicid,title,count_comment', 10);
		foreach($arrHotTopics as $key => $item)
		{
			$arrHotTopic[] = $item;
			$arrHotTopic[$key]['group'] = $new['group']->getOneGroup($item['groupid']);
		}

		if ($page > 1)
		{
			$title = '最新帖子 - 第' . $page . '页';
		}
		else
		{
			$title = '最新帖子';
		}

		include template('topic_list');
		break;
}
