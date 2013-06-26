<?php 
defined('IN_TS') or die('Access Denied.'); 

function signuser(){
	$arrUser = aac('user')->getHotUser(16);
	echo '<div class="bbox pd10">';
	echo '<div class="btitle">最新签到用户</div>';
	echo '<div class="facelist"><ul>';
	foreach($arrUser as $key=>$item){
		echo '<li><a href="'.tsUrl('user','space',array('id'=>$item['userid'])).'"><img src="'.$item['face'].'" alt="'.$item['username'].'" width="48" height="48" /></a><div><a href="'.tsUrl('user','space',array('id'=>$item['userid'])).'">'.$item['username'].'</a></div></li>';
	}
	echo '</ul></div></div>';
}

addAction('home_index_left','signuser');