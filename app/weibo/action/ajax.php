<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
		
	case "add":
		
		$userid = intval($TS_USER['user']['userid']);

		if($userid==0){
			echo 0;exit;
		}

		$content = t($_POST['content']);

		if($content == ''){
			echo 1;exit;
		}
		
		if($TS_USER['user']['isadmin']==0){
			//过滤内容开始
			aac('system')->antiWord($content);
			//过滤内容结束
			//$isaudit = 1;
		}
			
		$weiboid = $new['weibo']->create('weibo',array(
			'userid'=>$userid,
			'content'=>$content,
			'addtime'=>date('Y-m-d H:i:s'),
			'uptime'=>date('Y-m-d H:i:s'),
		));
		
		//动态
		aac('feed')->add($userid,'weibo','show',$weiboid,'weibo','weiboid','发布','微博','weibo_comment','commentid');
		
		echo 2;exit;
		
		break;
		
	case "list":
	
		$arrWeibo = aac('weibo')->findAll('weibo',null,'addtime desc',null,10);
		foreach($arrWeibo as $key=>$item){
			$arrWeibo[$key]['user'] = aac('user')->getOneUser($item['userid']);
		}
		
		include template('ajax_list');
	
		break;
	
}