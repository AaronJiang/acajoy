<?php
defined('IN_TS') or die('Access Denied.');

function ueditor(){
		echo '<script>window.UEDITOR_HOME_URL = "'.SITE_URL.'plugins/pubs/ueditor/";</script>';
		echo '<script type="text/javascript" charset="utf-8" src="'.SITE_URL.'plugins/pubs/ueditor/editor_config.js"></script>
		<script type="text/javascript" charset="utf-8" src="'.SITE_URL.'plugins/pubs/ueditor/editor_all.js"></script><script type="text/javascript" charset="utf-8" src="'.SITE_URL.'plugins/pubs/ueditor/load.js"></script>';
	
}

if($_SESSION['tsuser']){
	addAction('tseditor','ueditor');
}