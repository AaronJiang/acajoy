<?php 
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){

	//添加评论
	case "do":
		if($_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
		
		$topicid	= intval($_POST['topicid']);
		$content	= tsClean($_POST['content']);
		
		//过滤内容开始
		if($TS_USER['user']['isadmin']==1){
			aac('system')->antiWord($content);
		}
		//过滤内容结束
		
		if($content==''){
			tsNotice('没有任何内容是不允许你通过滴^_^');
		}else{
			$commentid = $new['group']->create('group_topics_comments',array(
				'topicid'	=> $topicid,
				'userid'	=> $userid,
				'content'	=> $content,
				'addtime'=> time(),
			));
			
			//计算该ID的页数
			$page_count = $new['group']->findCount('group_topics_comments',"`topicid`='$topicid' and `commentid`<'$commentid'");
			
			$page=ceil(($page_count+1)/15);
			
			if (preg_match_all('/@/', $content, $at))
			{
				preg_match_all("/@(.+?)([\s|:]|$)/is", $content, $matches);

				$unames = $matches[1];

				$ns = "'" . implode("','", $unames) . "'";

				$csql = "username IN($ns)";

				if ($unames){
					$query = $new['group']->findAll('user_info',$csql,'userid,username');
					foreach($query as $v){
						$content = str_replace('@' . $v['username'] . '', '[@' . $v['username'] . ':' . $v['userid'] . ']', $content);
						$msg_content = '我在帖子中提到了你<br />去看看：' . tsUrl('group', 'topic', array('id' => $topicid,'page'=>$page."#l_".$commentid));
						aac('message')->sendmsg($userid, $v['userid'], $msg_content);
				     }
				
					$new['group']->update('group_topics_comments', array(
						'commentid' => $commentid,
					), array(
						'content' => $content,
					));
				} 
		
			}
			
			//统计评论数
			$count_comment = $new['group']->findCount('group_topics_comments',array(
				'topicid'=>$topicid,
			));
			
			//更新帖子最后回应时间和评论数			
			$new['group']->update('group_topics',array(
				'topicid'=>$topicid,
			),array(
				'count_comment'=>$count_comment,
				'uptime'=>time(),
			));
			
			//积分记录			
			aac('user')->addScore($userid,'回帖','1');
			
			//发送系统消息(通知楼主有人回复他的帖子啦)			
			$strTopic = $new['group']->find('group_topics',array(
				'topicid'=>$topicid,
			));
			
			if($strTopic['userid'] != $TS_USER['user']['userid']){
			
				$msg_userid = '0';
				$msg_touserid = $strTopic['userid'];
				$msg_content = '你的帖子：《'.$strTopic['title'].'》新增一条评论，快去看看给个回复吧^_^ <br />'
											.tsUrl('group','topic',array('id'=>$topicid));
				aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
				
			}
			
			//动态
			aac('feed')->add($userid,'group','topic',$topicid,'group_topics','topicid','评论了','帖子','group_topics_comments','commentid',$commentid);
			
			header("Location: ".tsUrl('group','topic',array('id'=>$topicid)));
		}	
	
		break;
		
	//删除评论
	case "delete":
		
		if($_GET['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
		
		$commentid = intval($_GET['commentid']);
		
		$strComment = $new['group']->find('group_topics_comments',array(
			'commentid'=>$commentid,
		));
		
		$strTopic = $new['group']->find('group_topics',array(
			'topicid'=>$strComment['topicid'],
		));
		
		$strGroup = $new['group']->find('group',array(
			'groupid'=>$strTopic['groupid'],
		));
		
		if($strTopic['userid']==$userid || $strGroup['userid']==$userid || $TS_USER['user']['isadmin']==1 || $strComment['userid']==$userid){
			
			$new['group']->delComment($commentid);
			
			//统计评论数
			$count_comment = $new['group']->findCount('group_topics_comments',array(
				'topicid'=>$strTopic['topicid'],
			));
			
			//更新帖子最后回应时间和评论数			
			$new['group']->update('group_topics',array(
				'topicid'=>$strTopic['topicid'],
			),array(
				'count_comment'=>$count_comment,
			));
			
			// 扣除用户相应的积分，删除评论扣2分
			aac('user')->delScore($strComment['userid'],'删除帖子评论',2);
			
			
			
		}
		
		//跳转回到帖子页
		header("Location: ".tsUrl('group','topic',array('id'=>$strComment['topicid'])));
		
		break;

}