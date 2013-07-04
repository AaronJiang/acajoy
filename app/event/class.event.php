<?php
class event extends tsApp{

	var $db;

	function event($dbhandle){
		$this->db = $dbhandle;
	}
	
	//通过topicid获取活动基本信息
	function getEventByEventid($eventid){
		$strEvent = $this->db->once_fetch_assoc("select * from ".dbprefix."app_event where eventid='$eventid'");
		
		//用户 
		$strEvent['user'] = $this->db->once_fetch_assoc("select * from ".dbprefix."app_user_info where userid='".$strEvent['userid']."'");
		
		//封面
		if($strEvent['poster']==''){
			$strEvent['poster'] = 'data/uploadfile/event/event_dft.jpg';
			$strEvent['poster_50'] = 'data/uploadfile/event/event_dft.jpg';
			$strEvent['poster_75'] = 'data/uploadfile/event/event_dft.jpg';
			$strEvent['poster_100'] = 'data/uploadfile/event/event_dft.jpg';
		}else{
			$fileInfo=pathinfo(THINKROOT.'/'.$strEvent['poster']);
			$extension=$fileInfo['extension'];
			
			$eventid = $strEvent['eventid'];
			$menu = substr($eventid,0,1);
			$dest_dir='data/uploadfile/event/'.$menu.'/'.$eventid;
			
			$strEvent['poster_50'] = $dest_dir.'/'.$eventid."_50.".$extension;
			$strEvent['poster_75'] = $dest_dir.'/'.$eventid."_75.".$extension;
			$strEvent['poster'] = $dest_dir.'/'.$strEvent['poster'];
			
		}
		
		//时间
		$weekarray=array("周日","周一","周二","周三","周四","周五","周六");  
		
		$strEvent['time_start'] = date('Y',strtotime($strEvent['time_start'])).'年'.date('m',strtotime($strEvent['time_start'])).'月'.date('d',strtotime($strEvent['time_start'])).'日 '.$weekarray[date("w",strtotime($strEvent['time_start']))].' '.date('H:i',strtotime($strEvent['time_start']));
		
		$strEvent['time_end'] = date('Y',strtotime($strEvent['time_end'])).'年'.date('m',strtotime($strEvent['time_end'])).'月'.date('d',strtotime($strEvent['time_end'])).'日 '.$weekarray[date("w",strtotime($strEvent['time_end']))].' '.date('H:i',strtotime($strEvent['time_end']));
		
		//地点
		$strEvent['province'] = $this->db->once_fetch_assoc("select * from ".dbprefix."app_location_province where provinceid = '".$strEvent['provinceid']."'");
		$strEvent['city'] = $this->db->once_fetch_assoc("select * from ".dbprefix."app_location_city where cityid = '".$strEvent['cityid']."'");
		$strEvent['area'] = $this->db->once_fetch_assoc("select * from ".dbprefix."app_location_area where areaid = '".$strEvent['areaid']."'");
		
		//活动类型
		$strEvent['type'] = $this->db->once_fetch_assoc("select * from ".dbprefix."app_event_type where typeid='".$strEvent['typeid']."'");
		
		return $strEvent;
	}
	
	//
	function getSimpleEvent($eventid){
		$strEvent = $this->db->once_fetch_assoc("select * from ".dbprefix."app_event where eventid='$eventid'");
		
		//用户 
		$strEvent['user'] = $this->db->once_fetch_assoc("select * from ".dbprefix."app_user_info where userid='".$strEvent['userid']."'");
		
		//封面
		if($strEvent['poster']==''){
			$strEvent['poster'] = 'data/uploadfile/event/event_dft.jpg';
		}else{
			$fileInfo=pathinfo(THINKROOT.'/'.$strEvent['poster']);
			$extension=$fileInfo['extension'];
			
			$eventid = $strEvent['eventid'];
			$menu = substr($eventid,0,1);
			$dest_dir='data/uploadfile/event/'.$menu.'/'.$eventid;

			$strEvent['poster'] = $dest_dir.'/'.$strEvent['poster'];
			
		}
		
		return $strEvent;
	}

	
	/*
	 *获取内容评论列表
	 */
	
	function getEventComment($page = 1, $prePageNum,$eventid){
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$arrGroupContentComment	= $this->db->fetch_all_array("select * from ".dbprefix."app_event_comment where eventid='$eventid' order by addtime desc $limit");
		
		if(is_array($arrGroupContentComment)){
			foreach($arrGroupContentComment as $key=>$item){
				//$arrGroupContentComment[$key]['user'] = $this->getUserData($item['userid']);
				$arrGroupContentComment[$key]['user'] = aac('user',$this->db)->getOneUserByUserid($item['userid']);
				$arrGroupContentComment[$key]['content'] = hview($item['content']);
			}
		}
		
		return $arrGroupContentComment;
	}
	
	/*
	 *获取内容评论列表数
	 */
	
	function getEventCommentNum($virtue, $setvirtue){
		$where = 'where '.$virtue.'='.$setvirtue.'';
		$res = $this->db->query("SELECT * FROM ".dbprefix."app_event_comment $where" );
		$groupContentCommentNum = $this->db->num_rows($res);
		return $groupContentCommentNum;
	}
	
	//获取活动小组
	function getGroup($groupid){
		$strGroup = $this->db->once_fetch_assoc("select * from ".dbprefix."app_group where groupid='$groupid'");
		if($strGroup['groupicon'] == ''){
			$strGroup['groupicon'] = 'data/uploadfile/group/default/default.gif';
		}
		return $strGroup;
	}
}