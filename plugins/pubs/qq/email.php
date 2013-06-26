<?php
defined('IN_TS') or die('Access Denied.');
require_once("config.php");
require_once("utils.php");

function get_user_info()
{
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $_SESSION['access_token']
        . "&oauth_consumer_key=" . $_SESSION["appid"]
        . "&openid=" . $_SESSION["openid"]
        . "&format=json";

    $info = get_url_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}

//获取用户基本资料
$arr = get_user_info();

//email验证页
switch($ts){
	case "":
		$email = $_GET['email'];
		
		$isemail = $new['pubs']->findCount('user',array(
			'email'=>$email,
		));
		
		if($isemail > 0){
		
			$title = "绑定QQ帐号";
			include "html/email.html";
		
		}else{
			header("Location: ".SITE_URL."index.php");
		}
		break;
		
	//执行
	case "do":
		$email = trim($_POST['email']);
		$pwd = trim($_POST['pwd']);
		
		$strUser = $new['pubs']->find('user',array(
			'email'=>$email,
		));
		
		if($pwd == ''){
			qiMsg("密码不能为空！");
		}elseif($strUser['pwd'] != md5($strUser['salt'].$pwd)){
			qiMsg("密码输入有误！");
		}else{
		
			//绑定帐号
			$new['pubs']->create('user_open',array(
				'userid'=>$strUser['userid'],
				'sitename'=>'qq',
				'openid' => $_SESSION['openid'],
				'access_token'=>$_SESSION['access_token'],
			));
		
			$userData = $new['pubs']->find('user_info',array(
				'email'=>$email,
			));
			
			//发送系统消息(恭喜注册成功)
			$userid = $userData['userid'];
			$username = $userData['username'];
			
			$msg_userid = '0';
			$msg_touserid = $userid;
			$msg_content = '亲爱的 '.$username.' ：<br />恭喜你成功绑定QQ登录信息。<br />现在你除了可以用Email登录，同时还可以使用QQ登录！<br />感谢你对ThinkSAAS的支持！';
			aac('message',$db)->sendmsg($msg_userid,$msg_touserid,$msg_content);
			
			$_SESSION['tsuser']	= $userData;
		
			header("Location: ".SITE_URL);
			
		}
		
		break;
}