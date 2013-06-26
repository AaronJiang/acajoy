<?php  
defined('IN_TS') or die('Access Denied.');

switch($ts){

	case "":
		$userid = aac('user')->isLogin();
		
		$albumid = intval($_GET['albumid']);
		
		if($albumid == 0){
			tsNotice('非法操作！');
		}
		
		$isAlbum=$new['attach']->findCount('attach_album',array(
			'userid'=>$userid,
			'albumid'=>$albumid,
		));
		
		if($isAlbum==0){
			tsNotice('非法操作！');
		}
		
		if($new['attach']->isAlbum($albumid)==false){
			tsNotice('非法操作！');
		}
		
		$title = '上传资料';
		include template('upload');
		break;
		
	case "do":
		
		$userid = intval($_GET['userid']);
		$albumid = intval($_GET['albumid']);
		if($userid=='0' || $albumid == 0){
			echo '00000';
			exit;
		}
		
		$attachid = $new['attach']->create('attach',array(
			'userid'	=> $userid,
			'albumid'=>$albumid,
			'addtime'	=> date('Y-m-d H:i:s'),
		));
		
		//上传
		$arrUpload = tsUpload($_FILES['Filedata'],$attachid,'attach',array('jpg','gif','png','rar','zip','doc','ppt','txt'));
		
		if($arrUpload){

			$new['attach']->update('attach',array(
				'attachid'=>$attachid,
			),array(
				'attachname'=>$arrUpload['name'],
				'attachtype'=>$arrUpload['type'],
				'attachurl'=>$arrUpload['url'],
				'attachsize'=>$arrUpload['size'],
			));
			
		}
		
		echo $attachid;
		
		break;

}