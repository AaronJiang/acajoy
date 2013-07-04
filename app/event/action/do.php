<?php
defined('IN_TS') or die('Access Denied.');
	function createFolders($path)  {  
		//递归创建  
		if (!file_exists($path)){  
			createFolders(dirname($path));//取得最后一个文件夹的全路径返回开始的地方  
			mkdir($path, 0777);  
		}  
	} 

	switch($ts){
	
		//发布活动
		case "add":
			$userid = intval($TS_USER['user']['userid']);
			$title = t($_POST['title']);
			$typeid = $_POST['typeid'];
			$time_start = $_POST['time_start'];
			$time_end = $_POST['time_end'];
			$provinceid = $_POST['provinceid'];
			$cityid = $_POST['cityid'];
			$areaid = $_POST['areaid'];
			$address = $_POST['address'];
			$content = h($_POST['content']);
			$groupid = $_POST['groupid'];
			
			if($userid == '0' || $title=='' || $time_end <=$time_start || $address=='' || $content==''){
				qiMsg("活动信息不符合要求！");
			}
			
			$eventData = array(
				'userid'	=> $userid,
				'title'	=> $title,
				'typeid' => $typeid,
				'time_start'	=> $time_start,
				'time_end'	=> $time_end,
				'provinceid'	=> $provinceid,
				'cityid'	=> $cityid,
				'areaid'	=> $areaid,
				'address'	=> $address,
				'content' => $content,
				'groupid' => $groupid,
			);
			
			$eventid = $db->insertArr($eventData,'app_event');
			
			//更新统计活动
			$eventNum = $db->once_num_rows("select * from ".dbprefix."app_event where typeid='$typeid'");
			$db->query("update ".dbprefix."app_event_type set `count_event`='$eventNum' where typeid='$typeid'");
			
			$arrTypes['list'] = $db->fetch_all_assoc("select * from ".dbprefix."app_event_type");
			$arrTypes['count'] = $db->once_fetch_assoc("select SUM(count_event) as allevent from ".dbprefix."app_event_type");
			
			//生成缓存文件
			AppCacheWrite($arrTypes,'event','types.php');
			
			header("Location: index.php?app=event&ac=show&eventid=".$eventid);
			
			break;
	
		//参加或者感兴趣活动
		case "dowish":
			$userid = $TS_USER['user']['userid'];
			$eventid = $_POST['eventid'];
			$status = $_POST['status'];
			
			$userNum = $db->once_num_rows("select * from ".dbprefix."app_event_users where eventid='$eventid' and userid='$userid'");
			
			if($userid == ''){
				echo '0';return false;
			}elseif($userNum > '0'){
				echo '1';
			}else{
				$db->query("insert into ".dbprefix."app_event_users (`eventid`,`userid`,`status`,`addtime`) values ('$eventid','$userid','$status','".time()."')");
				//统计一下参加的
				$userDoNum = $db->once_num_rows("select * from ".dbprefix."app_event_users where eventid='$eventid' and status='0'");
				//统计感兴趣的
				$userWishNum = $db->once_num_rows("select * from ".dbprefix."app_event_users where eventid='$eventid' and status='1'");
				
				$db->query("update ".dbprefix."app_event set `count_userdo`='$userDoNum',`count_userwish`='$userWishNum' where eventid='$eventid'");
				
				echo '2';
			}
			
			break;
			
		//取消参加活动
		case "cancel":
			
			$eventid = $_POST['eventid'];
			$userid	= $_POST['userid'];
			
			$db->query("delete from ".dbprefix."app_event_users where eventid='$eventid' and userid='$userid'");
			//统计一下参加的
			$userDoNum = $db->once_num_rows("select * from ".dbprefix."app_event_users where eventid='$eventid' and status='0'");
			//统计感兴趣的
			$userWishNum = $db->once_num_rows("select * from ".dbprefix."app_event_users where eventid='$eventid' and status='1'");
			
			$db->query("update ".dbprefix."app_event set `count_userdo`='$userDoNum',`count_userwish`='$userWishNum' where eventid='$eventid'");
			
			echo '1';
			
			break;
			
		//参加活动
		case "do":
			$eventid = $_POST['eventid'];
			$userid	= $_POST['userid'];
			$db->query("update ".dbprefix."app_event_users set `status`='0' where eventid='$eventid' and userid='$userid'");
			
			//统计一下参加的
			$userDoNum = $db->once_num_rows("select * from ".dbprefix."app_event_users where eventid='$eventid' and status='0'");
			//统计感兴趣的
			$userWishNum = $db->once_num_rows("select * from ".dbprefix."app_event_users where eventid='$eventid' and status='1'");
			
			$db->query("update ".dbprefix."app_event set `count_userdo`='$userDoNum',`count_userwish`='$userWishNum' where eventid='$eventid'");
			
			echo '1';
			
			break;
		
		//修改活动海报执行
		case "poster":
		
			$eventid = intval($_POST['eventid']);
			
			//处理目录存储方式
			$menu = substr($eventid,0,1);
			
			$uptypes = array( 
				'image/jpg',
				'image/jpeg',
				'image/png',
				'image/pjpeg',
				'image/gif',
				'image/bmp',
				'image/x-png',
			);
				
			if(isset($_FILES['picfile'])){
			
				$f=$_FILES['picfile'];
				
				if(empty($f['name'])){
				
					qiMsg("图片不能为空");
					
				}elseif ($f['name']){
					if (!in_array($_FILES['picfile']['type'],$uptypes)) {
						qiMsg("你上传的头像图片类型不正确，系统仅支持 jpg,gif,png 格式的图片,点击确认返回！");
					}
				} 		
				
				$dest_dir='data/uploadfile/event/'.$menu.'/'.$eventid;
				
				createFolders($dest_dir);
				
				//原图
				
				$fileInfo=pathinfo($f['name']);
				$extension=$fileInfo['extension'];
				
				$dest=$dest_dir.'/'.$eventid.'_0.'.$extension;
				
				$dest50=$dest_dir.'/'.$eventid."_50.".$extension;
				$dest75=$dest_dir.'/'.$eventid."_75.".$extension;
				$dest100=$dest_dir.'/'.$eventid."_100.".$extension;
				
				$poster = $eventid."_100.".$extension;
				
				move_uploaded_file($f['tmp_name'],iconv("UTF-8","gb2312",$dest));
				chmod($dest, 0755);
				
				require_once THINKSAAS.'/class.tsImg.php';
				
				$resizeimage = new tsImg("$dest", "50", "50", "1","$dest50");
				$resizeimage = new tsImg("$dest", "75", "75", "1","$dest75");
				$resizeimage = new tsImg("$dest", "100", "200", "0","$dest100");

				
				//更新小组头像
				$db->query("update ".dbprefix."app_event set `poster`='$poster' where eventid='$eventid'");

				header("Location: index.php?app=event&ac=edit&ts=poster&eventid=".$eventid);
				
			}
			
			break;
			
		//编辑执行
		case "edit":
			//发布
			$eventid = $_POST['eventid'];
			$title = $_POST['title'];
			$typeid = $_POST['typeid'];
			$time_start = $_POST['time_start'];
			$time_end = $_POST['time_end'];
			$areaid = $_POST['areaid'];
			$address = $_POST['address'];
			$content = $_POST['content'];
			
			$eventData = array(
				'typeid' => $typeid,
				'title'	=> $title,
				'time_start'	=> $time_start,
				'time_end'	=> $time_end,
				'areaid'	=> $areaid,
				'address'	=> $address,
				'content'	=> $content,
			);
			
			$db->updateArr($eventData,"app_event","where eventid='$eventid'");
			
			header("Location: index.php?app=event&ac=show&eventid=".$eventid);
			
			break;
			
		//添加评论 
		case "comment":
			$eventid	= intval($_POST['eventid']);
			$content	= h($_POST['content']);
			
			if($TS_USER['user'] == ''){
				qiMsg('请登陆后再发表内容^_^','点击登陆','index.php?app=user&ac=login');
			}elseif(empty($content)){
				qiMsg('没有任何内容是不允许你通过滴^_^');
			}else{
				$arrData	= array(
					'eventid'			=> $eventid,
					'userid'			=> $TS_USER['user']['userid'],
					'content'	=> $content,
					'addtime'		=> time()
				);
				
				$commentid = $db->insertArr($arrData,'app_event_comment');
				
				
				//发送系统消息(通知活动组织者有人回复他的活动啦)
				$strEvent = $db->once_fetch_assoc("select * from ".dbprefix."app_event where eventid='$eventid'");
				if($strEvent['userid'] != $TS_USER['user']['userid']){

					$msg_userid = '0';
					$msg_touserid = $strEvent['userid'];
					$msg_content = '你的活动：《'.$strEvent['title'].'》新增一条评论，快去看看给个回复吧^_^ <br />'
												.$TS_SITE['base']['site_url'].'index.php?app=event&ac=show&eventid='.$eventid;
					aac('message',$db)->sendmsg($msg_userid,$msg_touserid,$msg_content);
				
				}
				
				header("Location: index.php?app=event&ac=show&eventid=".$eventid);
				
			}	
			break;
			
	}