<?php
/*
 * 插件编辑
*
* @ silenceper@gmail.com
*   2012_09_26
* */
defined('IN_TS') or die('Access Denied.');
switch($ts){
	case "set":
		$arrData = fileRead('plugins/pubs/weibo/data.php');
		
		include 'html/edit.html';
		break;
		
	case "do":
		$wb_akey = trim($_POST['wb_akey']);
		$wb_skey = trim($_POST['wb_skey']);
		$siteurl = $_POST['siteurl'];
		
		$arrData = array(
			'wb_akey' => $wb_akey,
			'wb_skey'	=>$wb_skey,
			'siteurl'	=> $siteurl,
		);
		
		fileWrite('data.php','plugins/pubs/weibo',$arrData);
		
		header('Location: '.SITE_URL.'index.php?app=pubs&ac=plugin&plugin=weibo&in=edit&ts=set');
		break;
}
