<?php 
defined('IN_TS') or die('Access Denied.'); 
//休闲篇
function relaxarea_html(){
	
	
	echo '<div class="bbox">';
	echo '<h2>休闲篇</h2>';
	echo '</div>';
	
}

addAction('home_index_left','relaxarea_html');

