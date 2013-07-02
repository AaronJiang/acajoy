<?php 
defined('IN_TS') or die('Access Denied.'); 
//休闲篇
function relaxarea_html(){
	
	
	echo '<div class="bbox pd10">';
	echo '<div class="btitle">休闲篇</div>';
	echo '</div>';
	
}

addAction('home_index_left','relaxarea_html');

