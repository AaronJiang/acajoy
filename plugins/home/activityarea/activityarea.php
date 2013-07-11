<?php 
defined('IN_TS') or die('Access Denied.'); 
//活动篇
function activityarea_html(){
	
	
	echo '<div class="bbox">';
	echo '<h2><a href="/event">活动篇</a></h2>';
	echo '</div>';
	
}

addAction('home_index_left','activityarea_html');

