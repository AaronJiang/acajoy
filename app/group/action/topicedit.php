<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){
	
	//编辑帖子
	case "":
		$topicid = intval($_GET['topicid']);

		if($topicid == 0){
			header("Location: ".SITE_URL);
			exit;
		}
		
		$topicNum = $new['group']->findCount('group_topics',array(
			'topicid'=>$topicid,
		));

		if($topicNum==0){
			header("Location: ".SITE_URL);
			exit;
		}
		
		$strTopic = $new['group']->find('group_topics',array(
			'topicid'=>$topicid,
		));
		$strTopic['title'] = htmlspecialchars($strTopic['title']);
		
		$strGroup = $new['group']->find('group',array(
			'groupid'=>$strTopic['groupid'],
		));

		if($strTopic['userid'] == $userid || $strGroup['userid']==$userid || $TS_USER['user']['isadmin']==1){
			$arrGroupType = $new['group']->findAll('group_topics_type',array(
				'groupid'=>$strGroup['groupid'],
			));
			
			//找出TAG
			$arrTags = aac('tag')->getObjTagByObjid('topic', 'topicid', $topicid);
			foreach($arrTags as $key=>$item){
				$arrTag[] = $item['tagname'];
			}
			$strTopic['tag'] = array_to_str($arrTag);
			
			$title = '编辑帖子';
			include template("topic_edit");
			
		}else{

			header("Location: ".SITE_URL);
			exit;

		}
		break;
		
	//编辑帖子执行	
	case "do":
	
		if($_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
	
		$topicid = intval($_POST['topicid']);
		$title = trim($_POST['title']);
		$typeid = empty($_POST['typeid'])?0:$_POST['typeid'];
		$content = cleanJs($_POST['content']);
		
		$iscomment = $_POST['iscomment'];
		
		if($topicid == '' || $title=='' || $content=='') tsNotice("都不能为空的哦!");
		
		
		if($TS_USER['user']['isadmin']==0){
		
			//过滤内容开始
			aac('system')->antiWord($title);
			aac('system')->antiWord($content);
			//过滤内容结束
		
		}
		
		$strTopic = $new['group']->find('group_topics',array(
			'topicid'=>$topicid,
		));
		
		$strGroup = $new['group']->find('group',array(
			'groupid'=>$strTopic['groupid'],
		));
		
		if($strTopic['userid']==$userid || $strGroup['userid']==$userid || $TS_USER['user']['isadmin']==1){

			$new['group']->update('group_topics',array(
				'topicid'=>$topicid,
			),array(
				'typeid' => $typeid,
				'title' => $title,
				'content' => $content,
				'iscomment' => $iscomment,
			));
			
			//处理标签
			$tag = trim($_POST['tag']);
			if($tag){
				aac('tag')->delIndextag('topic','topicid',$topicid);
				aac('tag') -> addTag('topic', 'topicid', $topicid, $tag); 
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
					
				tsDimg($arrUpload['url'],'group','180','140',$arrUpload['path']);
					
			}
			// 上传帖子图片结束
			
			header("Location: ".tsUrl('group','topic',array('id'=>$topicid)));
			
		}else{
			header("Location: ".SITE_URL);
			exit;
		}
		break;

}