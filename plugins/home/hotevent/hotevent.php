<?php 
defined('IN_TS') or die('Access Denied.'); 
function hotevent(){
	
	$arrHotEvents = aac('event')->getHotEvents();
	
	include template('hotevent','hotevent');
	
}

addAction('home_index_right','hotevent');