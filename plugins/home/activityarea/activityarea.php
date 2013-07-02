<?php 
defined('IN_TS') or die('Access Denied.'); 
//活动篇
function activityarea_html(){
	
	
	echo '<div class="bbox pd10">';
	echo '<div class="btitle">活动篇</div>';
	echo '</div>';
	
}

addAction('home_index_left','activityarea_html');

