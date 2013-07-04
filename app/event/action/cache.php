<?php
defined('IN_TS') or die('Access Denied.');

$arrTypes['list'] = $db->fetch_all_assoc("select * from ".dbprefix."app_event_type");
$arrTypes['count'] = $db->once_fetch_assoc("select SUM(count_event) as allevent from ".dbprefix."app_event_type");
			
//生成缓存文件
AppCacheWrite($arrTypes,'event','types.php');