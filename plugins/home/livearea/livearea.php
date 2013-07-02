<?php 
defined('IN_TS') or die('Access Denied.'); 
//生活篇
function livearea_html(){
	
	
	echo '<div class="bbox pd10">';
	echo '<div class="btitle">生活篇</div>';
	echo '</div>';
	
}

addAction('home_index_left','livearea_html');

