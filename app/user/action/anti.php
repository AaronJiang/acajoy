<?php 
defined('IN_TS') or die('Access Denied.');

$userid = intval($TS_USER['user']['userid']);

if($userid){
	//过滤用户IP
	$tsSystemAntiIp = aac('system')->antiIp();
	if($tsSystemAntiIp){
		if(in_array(getIp(),$tsSystemAntiIp)){
			aac('user')->logout();
		}
	}
	
	//过滤用户
	$tsSystemAntiUser = aac('system')->antiUser();
	if($tsSystemAntiUser){
		if(in_array($userid,$tsSystemAntiUser)){
			aac('user')->logout();
		}
	}
	
	echo 1;
	
}else{
	echo 0;
}