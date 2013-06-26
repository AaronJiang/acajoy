<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){

	case "show":
	
		$feedid = intval($_GET['feedid']);

		$strFeed = $new['feed']->find('feed',array(
			'feedid'=>$feedid,
		));
		
		$arrComments = $new['feed']->findAll($strFeed['commenttable'],array(
			$strFeed['appkey']=>$strFeed['appid'],
		),'addtime desc',null,5);
		
		foreach($arrComments as $key=>$item){
		
			$arrComment[] = $item;
			$arrComment[$key]['user'] = aac('user')->getOneUser($item['userid']);
		
		}
		
		
		include template('comment_show');
		
		break;
		
	case "add":
	
		$userid = intval($TS_USER['user']['userid']);
		
		if($userid==0){
			echo 0;exit;
		}
		
		$feedid = intval($_POST['feedid']);
		
		$content = tsClean($_POST['content']);
		
		if($content == ''){
			echo 1;exit;
		}
		
		$strFeed = $new['feed']->find('feed',array(
			'feedid'=>$feedid,
		));
		
		if($strFeed['commentid']){
		
			$strComment = $new['feed']->find($strFeed['commenttable'],array(
				$strFeed['commentkey']=>$strFeed['commentid'],
			),'userid');
			
			$content = '[userid='.$strComment['userid'].']'.$content;
			
			//通知
			aac('message')->sendmsg($userid, $strComment['userid'], '我在'.$strFeed['actionname'].'中提到了你<br />去看看：' . tsUrl($strFeed['appname'], $strFeed['appaction'], array('id' => $strFeed['appid'])));
		
		}
		
		$commentid = $new['feed']->create($strFeed['commenttable'],array(
		
			'userid'=>$userid,
			$strFeed['appkey']=>$strFeed['appid'],
			'content'=>$content,
			'addtime'=>time(),
		
		));
		
		//通知
		$strApp = $new['feed']->find($strFeed['apptable'],array(
			$strFeed['appkey']=>$strFeed['appid'],
		),'userid,title,content');
		
		if($userid != $strApp['userid']){
			aac('message')->sendmsg(0,$strApp['userid'],'你的'.$strFeed['actionname'].'《'.$strApp['title'].'》新增一条评论，快去看看给个回复吧^_^ <br />'.tsUrl($strFeed['appname'],$strFeed['appaction'],array('id'=>$strFeed['appid'])));
		}
		
		//动态
		aac('feed')->add($userid,$strFeed['appname'],$strFeed['appaction'],$strFeed['appid'],$strFeed['apptable'],$strFeed['appkey'],'评论了',$strFeed['actionname'],$strFeed['commenttable'],$strFeed['commentkey'],$commentid);
		
		//统计
		$count_comment = $new['feed']->findCount($strFeed['commenttable'],array(
			$strFeed['appkey']=>$strFeed['appid'],
		));
		
		$new['feed']->update($strFeed['apptable'],array(
			$strFeed['appkey']=>$strFeed['appid'],
		),array(
			'count_comment'=>$count_comment,
		));
		
		echo 2;exit;
	
		break;

}