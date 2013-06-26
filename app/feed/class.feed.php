<?php
defined('IN_TS') or die('Access Denied.');
class feed extends tsApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	/*
	 * 添加feed
	 * $userid 用户ID
	 * $appname APP目录名称
	 * $appaction APP action名称
	 * $appid   
	 * $apptable  表名
	 * $appkey   自增ID字段名称
	 * $action   动作
	 * $actionname 动作名称
	 * $commenttable  评论表
	 * $commentkey  自增评论ID
	 */
	public function add($userid,$appname,$appaction,$appid,$apptable,$appkey,$action,$actionname,$commenttable,$commentkey,$commentid=0){
	
		$this->create('feed',array(
			'userid'=>$userid,
			'appname'=>$appname,
			'appaction'=>$appaction,
			'appid'=>$appid,
			'apptable'=>$apptable,
			'appkey'=>$appkey,
			'action'=>$action,
			'actionname'=>$actionname,
			'commenttable'=>$commenttable,
			'commentkey'=>$commentkey,
			'commentid'=>$commentid,
			'addtime'=>time(),
		));
		
	}
	
	//删除feed
	public function del($appid,$apptable){
		
		$this->delete('feed',array(
		
			'appid'=>$appid,
			'apptable'=>$apptable,
		
		));
		
		return true;
		
	}
	
	//通过feed添加评论
	public function comment($userid,$content,$feedid){
	
		
	
	}
	
	public function hview($content){
	
		$content = cututf8($content,0,100);
		
		//匹配用户
		preg_match_all('/\[(userid)=(\d+)\]/is', $content, $userids);
		foreach ($userids[2] as $item) {
			$strUser = $this->find('user_info',array(
				'userid'=>$item,
			));
			$content = str_replace("[userid={$item}]",'<a href="'.tsUrl('user','space',array('id'=>$strUser['userid'])).'">@'.$strUser['username'].'</a>', $content);
		}
		
	//匹配本地图片
	preg_match_all('/\[(photo)=(\d+)\]/is', $content, $photos);
	foreach ($photos[2] as $item) {
		$strPhoto = $this->find('photo',array(
			'photoid'=>$item,
		));
		$content = str_replace("[photo={$item}]",'<p><a href="'.SITE_URL.'uploadfile/photo/'.$strPhoto['photourl'].'" target="_blank"><img class="thumbnail" src="'.SITE_URL.tsXimg($strPhoto['photourl'],'photo','200','',$strPhoto['path']).'" /></a></p>', $content);
	}
		
		return $content;
	
	}
	
	
	//析构函数
	public function __destruct(){
		
	}
	
}