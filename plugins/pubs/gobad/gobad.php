<?php
defined('IN_TS') or die('Access Denied.');
//统计代码
function gobad($w){

	$code = fileRead('plugins/pubs/gobad/data.php');
	echo '<div class="bbox pd10">';
	echo stripslashes($code[$w]);
	echo '</div>';
}

addAction('gobad','gobad');