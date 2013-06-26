<?php 
defined('IN_TS') or die('Access Denied.'); 
//推荐小组
function recommendgroup(){
	
	$arrRecommendGroup = aac('group')->getRecommendGroup('12');
	
	echo '<div class="bbox pd10">';
	echo '<div class="btitle">推荐小组</div>';
	
	foreach($arrRecommendGroup as $key=>$item){
	echo '<div class="sub-item">
	<div class="pic">
	<a href="'.tsUrl('group','show',array('id'=>$item[groupid])).'">
	<img src="'.$item['icon_48'].'" alt="'.$item['groupname'].'" title="'.$item['groupname'].'" />
	</a>
	</div>
	<div class="info">
	<a href="'.tsUrl('group','show',array('id'=>$item[groupid])).'">'.$item['groupname'].'</a> ('.$item['count_user'].')             
	<p>'.cututf8(t($item['groupdesc']),0,50).'</p>
	</div>
	</div>';
	}

	echo '</div>';
	
}

function recommendgroup_css(){

	echo '<link href="'.SITE_URL.'plugins/home/recommendgroup/images/style.css" rel="stylesheet" type="text/css" />';

}

addAction('home_index_left','recommendgroup');
addAction('pub_header_top','recommendgroup_css');