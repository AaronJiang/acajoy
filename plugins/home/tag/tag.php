<?php 
defined('IN_TS') or die('Access Denied.'); 

function tag(){
	//最新标签
	$arrTag = aac('tag')->findAll('tag',null,'count_topic desc',null,30);

	echo '<div class="bbox pd10">';
	echo '<div class="btitle">热门标签<div class="right"><a href="'.tsUrl('group','tags').'">更多</a></div></div>';
	echo '<div class="tags">';
	foreach($arrTag as $key=>$item){
		echo '<a href="'.tsUrl('group','tag',array('id'=>urlencode($item['tagname']))).'">'.$item['tagname'].'</a>';
	}
	echo '</div></div>';
	
}

addAction('home_index_left','tag');