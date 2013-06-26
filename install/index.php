<?php
defined('IN_TS') or die('Access Denied.'); 
/*
 *AcaJoy 安装程序
 * @copyright (c) 2010-3000 AcaJoy All Rights Reserved
 * @Email:acajoy@qq.com
 */

//安装文件的IMG，CSS文件
$skins	= 'data/install/skins/';

//进入正题
$title = 'AcaJoy安装程序';

require_once 'action/'.$install.'.php';