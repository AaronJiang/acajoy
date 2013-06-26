<?php
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	case "set":
		$code = fileRead('plugins/pubs/feedback/data.php');
		$code = stripslashes($code);
		
		include 'edit_set.html';
		break;
		
	case "do":
		$code = $_POST['code'];
		
		fileWrite('data.php','plugins/pubs/feedback',$code);
		
		header('Location: '.SITE_URL.'index.php?app=pubs&ac=plugin&plugin=feedback&in=edit&ts=set');
		break;
}