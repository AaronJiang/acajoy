<?php 
defined('IN_TS') or die('Access Denied.'); 
//就业篇
function jobarea_html(){
	
	
	echo '<div class="bbox pd10">';
	echo '<div class="btitle">就业篇</div>';
	echo '</div>';
	
}

addAction('home_index_left','jobarea_html');

