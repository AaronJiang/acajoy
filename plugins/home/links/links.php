<?php
defined('IN_TS') or die('Access Denied.'); 
//友情连接插件

function links_html(){
	$arrLink = fileRead('plugins/home/links/data.php');
	
	echo '<div class="clear"></div>';
	echo '<div class="bbox pd10">';
	echo '<div class="btitle">友情链接</div>';
	echo '<div class="links">';
	foreach($arrLink as $item){
		echo '<a target="_blank" href="'.$item['linkurl'].'">'.$item['linkname'].'</a> '; 
	}
	echo '</div></div>';
}

addAction('home_index_footer','links_html');