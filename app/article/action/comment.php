<?php 
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){

	case "do":
	
		if($_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
	
		$articleid = intval($_POST['articleid']);
		$content = tsClean($_POST['content']);
		
		if($content == '') tsNotice("内容不能为空！");
		
		//过滤内容开始
		aac('system')->antiWord($content);
		//过滤内容结束
		
		$new['article']->create('article_comment',array(
		
			'articleid'=>$articleid,
			'userid'=>$userid,
			'content'=>$content,
			'addtime'=>time(),
		
		));
		
		header("Location: ".tsUrl('article','show',array('id'=>$articleid)));
		
		break;
		
	case "delete":
	
		$commentid = intval($_GET['commentid']);
		
		$strComment = $new['article']->find('article_comment',array(
			'commentid'=>$commentid,
		));
		
		$strArticle = $new['article']->find('article',array(
			'articleid'=>$strComment['articleid'],
		));
		
		if($userid == $strArticle['userid'] || $TS_USER['user']['isadmin']==1){
		
			$new['article']->delete('article_comment',array(
			
				'commentid'=>$commentid,
			
			));
			
			tsNotice('删除成功');
		
		}else{
		
			tsNotice('非法操作');
		
		}
	
		break;
}