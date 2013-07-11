<?php 
defined('IN_TS') or die('Access Denied.'); 
//就业篇
function jobarea_html(){
	
	
	echo '<div class="bbox">';
	echo '<h2>就业篇</h2>';
	echo '</div>';
	
}

addAction('home_index_left','jobarea_html');

