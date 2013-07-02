<?php
defined('IN_TS') or die('Access Denied.'); 

function weather_html(){
	$arrLink = fileRead('plugins/home/weather/data.php');
	$html = <<<EOF
	<div class="bbox pd10">
	<iframe width="420" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=2"></iframe>	
	</div>
	<div class="clear"></div>
	
EOF;
	echo $html;
}

addAction('home_index_right','weather_html');