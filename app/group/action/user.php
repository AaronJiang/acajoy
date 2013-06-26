<?php
defined('IN_TS') or die('Access Denied.');
//小组成员

switch($ts){
	
	//小组成员首页
	case "":
	
		$groupid = intval($_GET['id']);

		//判断是否存在这个群组
		$strGroup = $new['group']->getOneGroup($groupid);
		if($strGroup == '') {
			header("HTTP/1.1 404 Not Found");
			header("Status: 404 Not Found");
			$title = '404';
			include pubTemplate("404");
			exit;
		}

		//小组组长信息
		$leaderId = $strGroup['userid'];

		$strLeader = aac('user')->getOneUser($leaderId);

		//管理员信息
		$strAdmin = $db->fetch_all_assoc("select userid,isadmin from ".dbprefix."group_users where `groupid`='$groupid' and `isadmin`='1' and `isfounder`='0'");

		if(is_array($strAdmin)){
			foreach($strAdmin as $key=>$item){
				$arrAdmin[] = aac('user')->getOneUser($item['userid']);
				$arrAdmin[$key]['isadmin'] = $item['isadmin'];
			}
		}

		//小组会员分页

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

		$url = tsUrl('group','group_user',array('groupid'=>$groupid,'page'=>''));


		$lstart = $page*40-40;

		//普通用户
		$groupUserNum = $new['group']->findCount('group_users',array(
			
			'groupid'=>$groupid,
			'isadmin'=>0,
			'isfounder'=>0,
		
		));

		$groupUser = $db->fetch_all_assoc("select userid,isadmin from ".dbprefix."group_users where `groupid`='$groupid' and `isadmin`='0' and `isfounder`='0' order by userid desc limit $lstart,40");

		if(is_array($groupUser)){
			foreach($groupUser as $key=>$item){
				$arrGroupUser[] = aac('user')->getOneUser($item['userid']);
				$arrGroupUser[$key]['isadmin'] = $item['isadmin'];
			}
		}

		$pageUrl = pagination($groupUserNum, 40, $page, $url,$TS_URL['suffix']);

		if($page > '1'){
			$titlepage = " - 第".$page."页";
		}else{
			$titlepage='';
		}

		$title = $strGroup['groupname'].'成员'.$titlepage;

		include template("user");
		
		break;
		
	//管理员 
	case "manager":
		exit;
		aac('user')->isLogin();
		
		$groupid = intval($_GET['groupid']);
		$userid= intval($_GET['userid']);
		
		$strGroup = $new['group']->find('group',array(
			'groupid'=>$groupid,
		));
		
		if($strGroup['groupid'] == $groupid){
		
			$strGroupUser = $new['group']->find('group_users',array(
				'userid'=>$userid,
				'groupid'=>$groupid,
			));
			
			if($strGroup['userid'] != $userid){
			
			
				if($strGroupUser['isadmin']==1){
				
					$new['group']->update('group_users',array(
						'userid'=>$userid,
						'groupid'=>$groupid,
					),array(
					
						'isadmin'=>0,
					
					));
				
				}elseif($strGroupUser['isadmin']==0){
				
					$new['group']->update('group_users',array(
						'userid'=>$userid,
						'groupid'=>$groupid,
					),array(
					
						'isadmin'=>1,
					
					));
				
				}
			
			
			}
			
			
			tsNotice('操作成功！');
		
		}
	
		break;
	
	//删除成员
	
}