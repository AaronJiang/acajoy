<?php 
defined('IN_TS') or die('Access Denied.');
require_once 'system/tsLcs.php';
$lcs = new tsLcs();

$lcs->getSimilar("字符串一","字符串二");