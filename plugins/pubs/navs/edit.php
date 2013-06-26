<?php 
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	case "set":
		$arrNav = fileRead('plugins/pubs/navs/data.php');
		
		include 'edit_set.html';
		break;
		
	case "do":
		$arrNavName = $_POST['navname'];
		$arrNavUrl = $_POST['navurl'];
		
		foreach($arrNavName as $key=>$item){
			$navname = trim($item);
			$navurl = trim($arrNavUrl[$key]);
			if($navname && $navurl){
				$arrNav[] = array(
					'navname'	=> $navname,
					'navurl'	=> $navurl,
				);
			}
			
		}
		
		fileWrite('data.php','plugins/pubs/navs',$arrNav);
		
		header('Location: '.SITE_URL.'index.php?app=pubs&ac=plugin&plugin=navs&in=edit&ts=set');
		break;
}