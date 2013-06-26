<?php
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	case "set":
		$code = fileRead('plugins/pubs/gobad/data.php');
		
		include 'edit_set.html';
		break;
		
	case "do":
		$code = $_POST['code'];
		
		fileWrite('data.php','plugins/pubs/gobad',$code);
		
		header('Location: '.SITE_URL.'index.php?app=pubs&ac=plugin&plugin=gobad&in=edit&ts=set');
		break;
}