<?php 
defined('IN_TS') or die('Access Denied.');
//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){
		
	case "do":
	
		if($_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
	
		$content = t($_POST['content']);
		
		if($content == '') {
			tsNotice('内容不能为空');
		}
		
		$isaudit = 0;
		
		if($TS_USER['user']['isadmin']==0){
			//过滤内容开始
			aac('system')->antiWord($content);
			//过滤内容结束
		}
			
		$weiboid = $new['weibo']->create('weibo',array(
			'userid'=>$userid,
			'content'=>$content,
			'isaudit'=>$isaudit,
			'addtime'=>date('Y-m-d H:i:s'),
			'uptime'=>date('Y-m-d H:i:s'),
		));
		
		//动态
		aac('feed')->add($userid,'weibo','show',$weiboid,'weibo','weiboid','发布','微博','weibo_comment','commentid');
		
		header("Location: ".tsurl('weibo','show',array('id'=>$weiboid)));
		exit;
	
		break;
	
}