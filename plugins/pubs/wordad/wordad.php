<?php
defined('IN_TS') or die('Access Denied.');
//统计代码
function wordad(){
echo '<style>
	.wordad{ background: none repeat scroll 0 0 #EAEAEA;border: 1px solid #DDDDDD;margin-bottom: 10px;overflow: hidden;padding:5px;}
	.wordad ul{}
	.wordad ul li{width:225px;float:left;margin:2px 5px;}
	</style>';
	$arrData = fileRead('plugins/pubs/wordad/data.php');
	echo '<div class="wordad"><ul>';
	foreach($arrData as $key=>$item){
		echo '<li><a target="_blank" href="'.$item['url'].'">'.$item['title'].'</a></li>';
	}
	echo '</ul></div><div class="clear"></div>';
}
addAction('wordad','wordad');