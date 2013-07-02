<?php 
defined('IN_TS') or die('Access Denied.'); 
//学习篇
function studyarea_html(){
	
	
	echo '<div class="bbox pd10">';
	echo '<div class="btitle">学习篇</div>';
	echo '</div>';
	
}

addAction('home_index_left','studyarea_html');

