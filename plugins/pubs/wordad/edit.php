<?php
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	//编辑
	case "set":
		$arrData = fileRead('plugins/pubs/wordad/data.php');
		include 'edit.html';
		break;
	//执行编辑
	case "do":
		$arrTitle = $_POST['title'];
		$arrUrl = $_POST['url'];
		foreach($arrTitle as $key=>$item){
			$title = trim($item);
			$url = trim($arrUrl[$key]);
			if($title && $url){
				$arrData[] = array(
					'title'	=> $title,
					'url'	=> $url,
				);
			}
		}
		
		fileWrite('data.php','plugins/pubs/wordad',$arrData);
		
		header('Location: '.SITE_URL.'index.php?app=pubs&ac=plugin&plugin=wordad&in=edit&ts=set');
		break;
}