<?php
defined('IN_TS') or die('Access Denied.');
/**
 *
 * @copyright (c) AcaJoy All Rights Reserved
 *            @Email:acajoy@qq.com
 *            @site:www.acajoy.cn
 */
error_reporting(E_ALL & ~ E_NOTICE & ~ E_WARNING);

@set_magic_quotes_runtime(0);

ini_set('display_errors', 'on'); // 正式环境关闭错误输出

ini_set('session.cookie_path', '/');

// ini_set('session.save_path', JOYROOT.'/cache/sessions');

// 核心配置文件 $TS_CF 系统配置变量
$TS_CF = include 'system/config.php';

// 加载基础函数
include 'tsFunction.php';

// 开始处理url路由，支持APP二级域名
if ($TS_CF['subdomain']) {
    ini_set("session.cookie_domain", '.' . $TS_CF['subdomain']['domain']);
    
    // APP独立域名支持
    if (array_search($_SERVER['HTTP_HOST'], $TS_CF['appdomain'])) {
        reurlsubdomain();
    } else {
        $arrHost = explode('.', $_SERVER['HTTP_HOST']);
        if ($arrHost[0] == 'www') {
            reurl();
        } else {
            reurlsubdomain();
        }
    }
} else {
    reurl();
}

// 数据库存储SESSION 还有点问题，暂时不要开启
if ($TS_CF['session']) {
    include 'tsSession.php';
    ini_set('session.save_handler', 'user');
    session_set_save_handler(array(
            'tsSession',
            'open'
    ), array(
            'tsSession',
            'close'
    ), array(
            'tsSession',
            'read'
    ), array(
            'tsSession',
            'write'
    ), array(
            'tsSession',
            'destroy'
    ), array(
            'tsSession',
            'gc'
    ));
}

session_start();

// 启动Memcache
if ($TS_CF['memcache'] && extension_loaded('memcache')) {
    Memcache::connect($TS_CF['memcache']['host'], $TS_CF['memcache']['port']);
}

// 加密用户操作
if (! isset($_SESSION['token'])) {
    $_SESSION['token'] = sha1(uniqid(mt_rand(), TRUE));
}

// echo $_SESSION['token'];

// 前台用户基本数据,$TS_USER数组
$TS_USER = array(
        'user' => isset($_SESSION['tsuser']) ? $_SESSION['tsuser'] : '',
        'admin' => isset($_SESSION['tsadmin']) ? $_SESSION['tsadmin'] : ''
);

// 记录日志
if ($TS_CF['logs']) {
    // 打印用户日志记录
    userlog($_POST, intval($TS_USER['user']['userid']));
    userlog($_GET, intval($TS_USER['user']['userid']));
}

// 系统Url参数变量
// APP专用
$app = isset($_GET['app']) ? $_GET['app'] : 'home';

// APP二级域名支持，同时继续支持url原生写法
if ($TS_CF['subdomain'] && $app == 'home') {
    
    // APP独立域名支持
    $app = array_search($_SERVER['HTTP_HOST'], $TS_CF['appdomain']);
    
    if ($app == '') {
        // 二级域名支持
        $arrHost = explode('.', $_SERVER['HTTP_HOST']);
        $app = $arrHost['0'];
        if ($app == 'www') {
            $app = 'home';
        }
    }
}

// Action专用
$ac = isset($_GET['ac']) ? $_GET['ac'] : 'index';
// 安装
$install = isset($_GET['install']) ? $_GET['install'] : 'index';
// AcaJoy专用
$ts = isset($_GET['ts']) ? $_GET['ts'] : '';
// Admin管理专用
$mg = isset($_GET['mg']) ? $_GET['mg'] : 'index';
// Api专用
$api = isset($_GET['api']) ? $_GET['api'] : 'index';
// plugin专用
$plugin = isset($_GET['plugin']) ? $_GET['plugin'] : '';
// plugin专用
$in = isset($_GET['in']) ? $_GET['in'] : '';

// 皮肤
$tstheme = isset($_COOKIE['tsTheme']) ? $_COOKIE['tsTheme'] : 'sample';

tsgpc('app', 'string');
tsgpc('ac', 'string');
tsgpc('install', 'string');
tsgpc('ts', 'string');
tsgpc('mg', 'string');
tsgpc('api', 'string');
tsgpc('plugin', 'string');
tsgpc('in', 'string');

// 处理html编码
header('Content-Type: text/html; charset=UTF-8');

// 安装配置文件，数据库配置判断
if (! is_file('data/config.inc.php')) {
    include 'install/index.php';
    exit();
}

// 数据库配置文件
include 'data/config.inc.php';

// 加载APP配置文件
if (is_file('app/' . $app . '/class.' . $app . '.php')) {
    include 'app/' . $app . '/config.php';
    
    // 连接数据库
    include 'sql/' . $TS_DB['sql'] . '.php';
    $db = new MySql($TS_DB);
    
    // 加载APP数据库操作类并建立对象
    include 'tsApp.php';
    
    include 'app/' . $app . '/class.' . $app . '.php';
    $new[$app] = new $app($db);
} else {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    echo 'No APP 404 Page！';
    exit();
}

// 除去加载内核运行时间统计开始
$time_start = getmicrotime();

// 装载APP应用
include 'app.php';