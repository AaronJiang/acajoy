<?php
/**
 * AcaJoy单入口
 * @copyright (c) 2010-3000 AcaJoy All Rights Reserved
 * @author QiuJun
 * @Email:acajoy@qq.com
 */

//定义网站根目录,APP目录,DATA目录，AcaJoy核心目录
define('IN_TS',true);

define('JOYROOT', dirname(__FILE__));
define('JOYAPP', JOYROOT.'/app');
define('JOYDATA',JOYROOT.'/data');
define('JOYCORE', JOYROOT.'/acajoy');
define('JOYINSTALL',JOYROOT.'/install');
define('JOYPLUGIN',JOYROOT.'/plugins');

//装载AcaJoy核心

include 'system/core.php';

unset($GLOBALS);