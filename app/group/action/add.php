<?php
defined('IN_TS') or die('Access Denied.');

// 用户是否登录
$userid = aac('user') -> isLogin();

switch ($ts) {
	//发布帖子
	case "":

		$groupid = intval($_GET['id']); 
		// 小组数目
		$groupNum = $new['group']->findCount('group',array(
			'groupid'=>$groupid,
		));

		if ($groupNum == 0) {
			header("Location: " . SITE_URL);
			exit;
		}

		// 小组会员
		$isGroupUser = $new['group']->findCount('group_users',array(
			'userid'=>$userid,
			'groupid'=>$groupid,
		));

		$strGroup = $new['group']->find('group',array(
			'groupid'=>$groupid,
		));
		$strGroup['groupname'] = htmlspecialchars($strGroup['groupname']);
		
		if($strGroup['isaudit']==1){
			tsNotice('小组还未审核通过，不允许发帖！');
		}
		
		// 允许小组成员发帖
		if ($strGroup['ispost'] == 0 && $isGroupUser == 0 && $userid != $strGroup['userid']) {
			tsNotice("本小组只允许小组成员发贴，请加入小组后再发帖！");
		} 
		// 不允许小组成员发帖
		if ($strGroup['ispost'] == 1 && $userid != $strGroup['userid']) {
			tsNotice("本小组只允许小组组长发帖！");
		} 
		// 帖子类型
		$arrGroupType = $new['group']->findAll('group_topics_type',array(
			'groupid'=>$strGroup['groupid'],
		));

		$title = '发布帖子'; 
		// 包含模版
		include template("add");

		break; 
		
	// 执行发布帖子
	case "do":
	
		if($_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
	
        $groupid = intval($_POST['groupid']);
		$title = tsClean($_POST['title']);
		$content = tsClean($_POST['content']);
		$typeid = intval($_POST['typeid']);
		$tag = tsClean($_POST['tag']);
		
		//判断一下Title是否重复
		$isTitle = $new['group']->findCount('group_topics',array(
			'title'=>$title,
		));
		
		if($isTitle > 0){
			tsNotice('有重复标题出现哦^_^');
		}
		
		//小组
		$strGroup = $new['group']->find('group',array(
			'groupid'=>$groupid,
		)); 
		
		if($strGroup['isaudit']==1){
			tsNotice('小组还未审核通过，不允许发帖！');
		}
		
		if($TS_USER['user']['isadmin']==0){
			aac('system')->antiWord($title);
			aac('system')->antiWord($content);
			aac('system')->antiWord($tag);
		}
	
		$iscomment = intval($_POST['iscomment']);
		
		//帖子是否需要审核
		if($strGroup['ispostaudit']==1){
			$isaudit=1;
		}else{
			$isaudit=0;
		}
		
		if($title == '' || $content == ''){
			tsNotice('没有任何内容是不允许你通过滴^_^');
		}
		
		
		/*********************/
		//防止用户发布重复内容，调出用户上一次发表的内容
		$strPreTopic = $new['group']->find('group_topics',array(
			'userid'=>$userid,
		),'topicid,title,addtime','addtime desc');
		
		//print_r($strPreTopic);exit;
		
		//发帖间隔时间
		$IntervalTime = time()-$strPreTopic['addtime'];
		//if($strPreTopic && $IntervalTime<3600){
		if($strPreTopic){
			similar_text($strPreTopic['title'], $title, $percent);
			if($percent>=40){
				$new['group']->update('group_topics',array(
					'topicid'=>$strPreTopic['topicid'],
				),array(
					'isaudit'=>1,
				));
				$isaudit=1;
			}
		}
		/********************/
		

		$topicid = $new['group']->create('group_topics',array(
			'groupid' => $groupid,
			'typeid' => $typeid,
			'userid' => $userid,
			'title' => $title,
			'content' => $content,
			'iscomment' => $iscomment,
			'isaudit'=>$isaudit,
			'addtime' => time(),
			'uptime' => time(),
		));

		//更新未审核的帖子
		if($isaudit == 1){
			$new['group']->countTopicAudit($groupid);
		}
		
		//统计发帖数
		$countUserTopic = $new['group']->findCount('group_topics',array(
			'userid'=>$userid,
		));
		
		
		$new['group']->update('user_info',array(
			'userid'=>$userid,
		),array(
			'count_topic'=>$countUserTopic,
		));
	
		//处理@用户名
		if (preg_match_all('/@/', $content, $at)) {
			preg_match_all("/@(.+?)([\s|:]|$)/is", $content, $matches);

			$unames = $matches[1];

			$ns = "'" . implode("','", $unames) . "'";

			$csql = "username IN($ns)";

			if ($unames) {
			
				$query = $db -> fetch_all_assoc("select userid,username from " . dbprefix . "user_info where $csql");

				foreach($query as $v) {
					$content = str_replace('@' . $v['username'] . '', '[@' . $v['username'] . ':' . $v['userid'] . ']', $content);
					$msg_content = '我在帖子中提到了你<br />去看看：' . tsUrl('group', 'topic', array('id' => $topicid));
					aac('message') -> sendmsg($userid, $v['userid'], $msg_content);
				} 
				$new['group'] -> update('group_topics',array(
					'topicid' => $topicid
				),array(
					'content' => $content
				));
			} 
		}
		
		// 统计帖子类型
		if ($typeid) {			
			$topicTypeNum = $new['group']->findCount('group_topics',array(
				'typeid'=>$typeid,
			));
			
			$new['group']->update('group_topics_type',array(
				'typeid'=>$typeid,
			),array(
				'count_topic'=>$topicTypeNum,
			));
			
		} 
		
		// 上传帖子图片开始
		$arrUpload = tsUpload($_FILES['picfile'], $topicid, 'group', array('jpg', 'gif', 'png','jpeg'));
		if ($arrUpload) {
			$new['group'] -> update('group_topics', array(
					'topicid' => $topicid,
			), array(
					'path' => $arrUpload['path'],
					'photo' => $arrUpload['url'],
			));
		}
		// 上传帖子图片结束
		
		// 处理标签
		aac('tag') -> addTag('topic', 'topicid', $topicid, $tag); 
		// 统计小组下帖子数并更新
		$count_topic = $new['group']->findCount('group_topics',array(
			'groupid'=>$groupid,
		));
		
		// 统计今天发布帖子数
		$today_start = strtotime(date('Y-m-d 00:00:00'));
		$today_end = strtotime(date('Y-m-d 23:59:59'));
		
		$count_topic_today = $new['group']->findCount('group_topics',"`groupid`='$groupid' and `addtime`='$today_start'");

		$new['group']->update('group',array(
			'groupid'=>$groupid,
		),array(
			'count_topic'=>$count_topic,
			'count_topic_today'=>$count_topic_today,
			'uptime'=>time(),
		));
		
		// 积分记录
		aac('user')->addScore($userid,'发帖','5');
		
		//动态
		aac('feed')->add($userid,'group','topic',$topicid,'group_topics','topicid','发布了','帖子','group_topics_comments','commentid');
		
		
		header("Location: " . tsUrl('group', 'topic', array('id' => $topicid)));
		break; 

} 
