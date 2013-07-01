<?php
defined('IN_TS') or die('Access Denied.'); 

function weather_html(){
	$arrLink = fileRead('plugins/home/weather/data.php');
	$html = <<<EOF
	<div class="bbox pd10">weather</div>
	<div class="clear"></div>
EOF;
	echo $html;
}

addAction('home_index_right','weather_html');