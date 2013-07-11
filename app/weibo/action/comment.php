<?php
defined('IN_TS') or die('Access Denied.');

switch($ts){

	case "":

		if($_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}

		//用户是否登录
		$userid = aac('user')->isLogin();
		$weiboid = intval($_POST['weiboid']);
		$touserid = intval($_POST['touserid']);
		$content = t($_POST['content']);

		if($content == ''){
			tsNotice('内容不能为空');
		}

		if($TS_USER['user']['isadmin']==0){
			//过滤内容开始
			aac('system')->antiWord($content);
			//过滤内容结束
		}

		$commentid = $new['weibo']->create('weibo_comment',array(
			'userid'=>$userid,
			'touserid'=>$touserid,
			'weiboid'=>$weiboid,
			'content'=>$content,
			'addtime'=>date('Y-m-d H:i:s'),
		));

		//计算评论总数
		$commentNum = $new['weibo']->findCount('weibo_comment',array(
			'weiboid'=>$weiboid,
		));

		$new['weibo']->update('weibo',array(
			'weiboid'=>$weiboid,
		),array(
			'count_comment'=>$commentNum,
		));

		header("Location: ".tsUrl('weibo','show',array('id'=>$weiboid)));
		
		break;
		
	//删除评论
	case "delete":
		if($TS_USER['user']['isadmin']==1){
			$commentid = intval($_GET['commentid']);
			
			$new['weibo']->delete('weibo_comment',array('commentid'=>$commentid));
			
			tsNotice('删除成功！');
			
		}
		break;

}