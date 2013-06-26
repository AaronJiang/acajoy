<?php 
defined('IN_TS') or die('Access Denied.');

class group extends tsApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//获取一个小组
	function getOneGroup($groupid){	
		$strGroup=$this->find('group',array(
			'groupid'=>$groupid,
		));
		
		$strGroup['groupname'] = htmlspecialchars($strGroup['groupname']);
		
		if($strGroup['groupicon'] == ''){
			$strGroup['icon_48'] = SITE_URL.'public/images/group.jpg';
			$strGroup['icon_16'] = SITE_URL.'public/images/group.jpg';
		}else{
			$strGroup['icon_48'] = SITE_URL.tsXimg($strGroup['groupicon'],'group',48,48,$strGroup['path'],1);
			$strGroup['icon_16'] = SITE_URL.tsXimg($strGroup['groupicon'],'group',16,16,$strGroup['path'],1);
		}
		
		return $strGroup;

	}
	
	/*
	 *获取小组全部内容列表
	 */

	function getGroupContent($page = 1, $prePageNum,$groupid){
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$arrGroupContent	= $this->db->fetch_all_assoc("select * from ".dbprefix."group_topics where groupid='$groupid' order by addtime desc $limit");
		return $arrGroupContent;
	}
	
	//获取推荐的小组
	function getRecommendGroup($num){
		$arrRecommendGroups = $this->db->fetch_all_assoc("select groupid from ".dbprefix."group where isrecommend='1' limit $num");
		
		$arrRecommendGroup = array();
		
		if(is_array($arrRecommendGroups)){
			foreach($arrRecommendGroups as $item){
				$arrRecommendGroup[] = $this->getOneGroup($item['groupid']);
			}
		}
		return $arrRecommendGroup;
	}
	
	//获取最新创建的小组
	function getNewGroup($num){
		$arrNewGroups = $this->db->fetch_all_assoc("select groupid from ".dbprefix."group where `isaudit`='0' order by addtime desc limit $num");
		if(is_array($arrNewGroups)){
			foreach($arrNewGroups as $item){
				$arrNewGroup[] = $this->getOneGroup($item['groupid']);
			}
		}
		return $arrNewGroup;
	}
	
	
	/*
	 *获取小组全部内容数
	 */
	
	function getGroupContentNum($virtue, $setvirtue){
		$where = 'where '.$virtue.'='.$setvirtue.'';
		$sql = "SELECT * FROM ".dbprefix."group_topics $where";
		$groupContentNum = $this->db->once_num_rows($sql);
		return $groupContentNum;
	}
	
	/*
	 *获取内容
	 */
	 
	function getOneGroupContent($topicid){
		$strGroupContent = $this->db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid=$topicid");
		return $strGroupContent;
	}
	
	//Refer二级循环，三级循环暂时免谈
	function recomment($referid){
		$strComment = $this->db->once_fetch_assoc("select * from ".dbprefix."group_topics_comments where commentid='$referid'");
		$strComment['user'] = aac('user')->getOneUser($strComment['userid']);
		return $strComment;
	}

	
	//是否存在帖子 
	public function isTopic($topicid){
		
		$isTopic = $this->findCount('group_topics',array(
			'topicid'=>$topicid,
		));
		
		if($isTopic > 0){
		
			return true;
		
		}else{
			
			return false;
			
		}
		
	}
	
	//获取一条帖子 
	public function getOneTopic($topicid){
			
		$strTopic = $this->find('group_topics',array(
			'topicid'=>$topicid,
		));
		
		$strTopic['title'] = htmlspecialchars($strTopic['title']);
		
		return $strTopic;
		
	}
	
	//判断是否存在小组
	function isGroup($groupid){
		
		$isGroup = $this->findCount('group',array(
			'groupid'=>$groupid,
		));
		
		if($isGroup > 0){
			return true;
		}else{
			return false;
		}
	}
	
	//获取小组最新帖子 
	function newTopic($groupid=null,$limit){
	
		$conditions = null;
		if($groupid) $conditions = array('groupid'=>$groupid,'isshow'=>0);
		$arrTopics = aac('group')->findAll('group_topics',$conditions,'addtime desc',null,$limit);
		
		foreach($arrTopics as $key=>$item){
		
			$arrTopic[] = $item;
			$arrTopic[$key]['title'] = htmlspecialchars($item['title']);
			
		}
		
		return $arrTopic;
	
	}
	
	//获取话题补贴
	public function topicAfter($topicid){
	
		$arrAfter = null;
		
		$arrAfters = $this->findAll('group_topics_add',array(
			'topicid'=>$topicid,
		));
		
		foreach($arrAfters as $key=>$item){
			$arrAfter[] = $item;
			$arrAfter[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrAfter[$key]['title']=htmlspecialchars(stripslashes($item['title']));

		}
		
		return $arrAfter;
	
	}
	
	//删除帖子
	public function delTopic($topicid){

		$strTopic = $this->find('group_topics',array(
			'topicid'=>$topicid,
		));

		$this->delete('group_topics',array('topicid'=>$topicid));
		$this->delete('group_topics_comments',array('topicid'=>$topicid));
		$this->delete('tag_topic_index',array('topicid'=>$topicid));
		$this->delete('group_topics_collects',array('topicid'=>$topicid));
		
		//删除图片
		if($strTopic['photo']){
			unlink('uploadfile/topic/'.$strTopic['photo']);
		}
		//删除文件
		if($strTopic['attach']){
			unlink('uploadfile/topic/'.$strTopic['attach']);
		}
		
		//删除话题补贴
		$this->delTopicAfter($topicid);
		
		$this->delTopicComment($topicid);
		
		$this->countTopic($strTopic['groupid']);
		
		return true;
		
	}
	
	//删除话题补贴
	public function delTopicAfter($topicid){
		$arrAfter = $this->findAll('group_topics_add',array(
			'topicid'=>$topicid,
		));
		
		foreach($arrAfter as $item){
			if($item['photo']){
				unlink('uploadfile/after/'.$item['photo']);
			}
			if($item['attach']){
				unlink('uploadfile/after/'.$item['attach']);
			}
		}
		
		$this->delete('group_topics_add',array(
			'topicid'=>$topicid,
		));
		
		return true;
		
	}
	
	//删除补贴
	public function delAfter($id){
		$strAfter = $this->find('group_topics_add',array(
			'id'=>$id,
		));
		
		//删除图片
		if($strAfter['photo']){
			unlink('uploadfile/after/'.$strAfter['photo']);
		}
		//删除文件
		if($strAfter['attach']){
			unlink('uploadfile/after/'.$strAfter['attach']);
		}
		
		$this->delete('group_topics_add',array(
			'id'=>$id,
		));
		
		return true;
	}
	
	//删除话题评论
	public function delTopicComment($topicid){
		$arrComment = $this->findAll('group_topics_comments',array(
			'topicid'=>$topicid,
		));
		
		foreach($arrComment as $item){
			$this->delComment($item['commentid']);
		}
		
		return true;
		
	}
	
	//删除评论
	public function delComment($commentid){
		$strComment = $this->find('group_topics_comments',array(
			'commentid'=>$commentid,
		));
		
		//删除图片
		if($strComment['photo']){
			unlink('uploadfile/comment/'.$strComment['photo']);
		}
		//删除文件
		if($strComment['attach']){
			unlink('uploadfile/comment/'.$strComment['attach']);
		}
		
		$this->delete('group_topics_comments',array(
			'commentid'=>$commentid,
		));
		
		return true;
		
	}
	
	//热门帖子：一天1
	public function hotTopics($day,$num=10){
	
		$startTime = time()-($day*3600*60);
		$endTime = time();
		
		$arrTopic = $this->findAll('group_topics',"`addtime`>'$startTime' and `addtime` < '$endTime' and `isshow`='0' and `isaudit`='0'",'count_comment desc',null,$num);
		
		return $arrTopic;
		
	}
	
	//推荐喜欢的帖子
	public function loveTopic($topicId,$userNum){
		$strLike['num'] = $this->findCount('group_topics_collects',array(
			'topicid'=>$topicId,
		));
		
		$strLike['topic']=$this->find('group_topics',array(
			'topicid'=>$topicId,
		));
		
		$likeUsers = $this->findAll('group_topics_collects',array(
			'topicid'=>$topicId,
		),'addtime desc',null,$userNum);
		
		foreach($likeUsers as $key=>$item){
			$strLike['user'][]=aac('user')->getOneUser($item['userid']);
		}
		
		return $strLike;
	}
	
	/*
	 * 小组针对其他APP发帖内容结合的接口
	 * $groupid  小组ID
	 * $userid     用户ID
	 * $appkey    app目录名称，例如：group
	 * $appname  APP名称  例如：小组
	 * $appaction  APP控制器  例如：topic
	 * $appid    APP控制器针对的内容id   例如：123
	 * $title    内容标题
	 */
	public function appPost($groupid,$userid,$appkey,$appname,$appaction,$appid,$title){
		if($groupid && $userid && $appkey && $appname && $appid && $title){
			$this->create('group_topics',array(
				'groupid'=>$groupid,
				'userid'=>$userid,
				'appkey'=>$appkey,
				'appname'=>$appname,
				'appaction'=>$appaction,
				'appid'=>$appid,
				'title'=>$title,
				'addtime'=>time(),
				'uptime'=>time(),
			));
		}
	}
	
	//删除小组中针对其他APP发帖内容结合的接口
	public function delappPost($appkey,$appid){
		if($appkey && $appid){
			$this->delete('group_topics',array(
					'appkey'=>$appkey,
					'appid'=>$appid
			));
		}
	}

	
	/*
	 * 统计小组里需要审核的帖子数目，并更新到小组
	 */
	public function countTopicAudit($groupid){
		$count_topic_audit = $this->findCount('group_topics',array(
			'groupid'=>$groupid,
			'isaudit'=>'1',
		));
		
		$this->update('group',array(
			'groupid'=>$groupid,
		),array(
			'count_topic_audit'=>$count_topic_audit,
		));
		
	}
	
	/*
	 * 统计小组里的话题并更新到小组
	 */
	public function countTopic($groupid){
		$count_topic = $this->findCount('group_topics',array(
			'groupid'=>$groupid,
		));
		
		$this->update('group',array(
			'groupid'=>$groupid,
		),array(
			'count_topic'=>$count_topic,
		));
		
	}
	
	/*
	 * 删除帖子
	 */
	public function deleteTopic($topicid){
		
	}
	
	/*
	 * 删除小组
	 */
	public function deletegroup($groupid){
	
		//删除
	
	}
	
	//热门帖子,1天，7天，30天
	public function getHotTopic($day){
		$startTime = time()-($day*3600*60);
		
		$endTime = time();
		
		$arr = "`addtime`>'$startTime' and `count_view`>'0' and `addtime`<'$endTime'";
		
		$arrTopic = $this->findAll('group_topics',$arr,'addtime desc','topicid,title',10);
		foreach($arrTopic as $key=>$item){
			$arrTopic[$key]['title']=htmlspecialchars($item['title']);
		}
		
		return $arrTopic;
		
	}
	
	
	//析构函数
	public function __destruct(){
		
	}
	
}