<?php
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	case "set":
		$arrData = fileRead('plugins/home/slide/data.php');
		
		include 'edit_set.html';
		break;
		
	case "do":
		$arrTitle = $_POST['title'];
		$arrUrl = $_POST['url'];
		$arrImg = $_POST['img'];
		
		foreach($arrTitle as $key=>$item){
			$title = trim($item);
			$url = trim($arrUrl[$key]);
			$img = trim($arrImg[$key]);
			if($title && $url && $img){
				$arrData[] = array(
					'title'	=> $title,
					'url'	=> $url,
					'img'	=> $img,
				);
			}
			
		}
		
		fileWrite('data.php','plugins/home/slide',$arrData);
		
		header('Location: '.SITE_URL.'index.php?app=home&ac=plugin&plugin=slide&in=edit&ts=set');
		break;
}