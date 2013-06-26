<?php
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	case "set":
		$arrLink = fileRead('plugins/home/links/data.php');
		
		include 'edit_set.html';
		break;
		
	case "do":
		$arrLinkName = $_POST['linkname'];
		$arrLinkUrl = $_POST['linkurl'];
		
		foreach($arrLinkName as $key=>$item){
			$linkname = trim($item);
			$linkurl = trim($arrLinkUrl[$key]);
			if($linkname && $linkurl){
				$arrLink[] = array(
					'linkname'	=> $linkname,
					'linkurl'	=> $linkurl,
				);
			}
			
		}
		
		fileWrite('data.php','plugins/home/links',$arrLink);
		
		header('Location: '.SITE_URL.'index.php?app=home&ac=plugin&plugin=links&in=edit&ts=set');
		break;
}