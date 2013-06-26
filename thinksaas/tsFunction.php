<?php
defined('IN_TS') or die('Access Denied.');
/*
 * ThinkSAAS core function
 * @copyright (c) ThinkSAAS All Rights Reserved
 * @code by QiuJun
 * @Email:thinksaas@qq.com
 * @TIME:2010-12-18
 */

//AutoAppClass
function aac($app){
	global $db;
	$path = THINKAPP.'/'.$app.'/';
	if(!class_exists($app)){
		require_once $path.'class.'.$app.'.php';
	}
	if(!class_exists($app)){
		return false;
	}
	$obj = new $app($db);
	return $obj;
	
	unset($db);
	
}

// 二维数组的根据不同键值来排序。 第一个参数是二位数组名，第二个是依据键，第三个是升序还是降序，默认是升序
// 添加时间：2013.3.5 星期二 原毛毛
function array_sort($arr,$keys,$type='asc'){ 
	$keysvalue = $new_array = array();
	foreach ($arr as $k=>$v){
		$keysvalue[$k] = $v[$keys];
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $arr[$k];
	}
	return $new_array; 
} 


//ThinkSAAS Notice
function tsNotice($notice,$button='点击返回',$url='javascript:history.back(-1);',$isAutoGo=false){
	global $app;
	global $TS_SITE;
	global $TS_APP;
	global $site_theme;
	global $skin;
	global $TS_USER;
	global $TS_CF;
	global $runTime;

	$title = '提示：';

	include pubTemplate('notice');

	exit;
}

 
//系统消息
 
function qiMsg($msg,$button='点击返回>>',$url='javascript:history.back(-1);', $isAutoGo=false){
	echo 
<<<EOT
<html>
<head>
EOT;
	if($isAutoGo){
		echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
	}
	echo 
<<<EOT
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ThinkSAAS 提示</title>
<style type="text/css">
<!--
body {
font-family: Arial;
font-size: 12px;
line-height:150%;
text-align:center;
}
a{color:#555555;}
.main {
width:500px;
background-color:#FFFFFF;
font-size: 12px;
color: #666666;
margin:100px auto 0;
list-style:none;
padding:20px;
}
.main p {
line-height: 18px;
margin: 5px 20px;
font-size:14px;
}
-->
</style>
</head>
<body>
<div class="main">
<p>$msg</p>
<p><a href="$url">$button</a></p>
</div>
</body>
</html>
EOT;
	exit;
}


/*
 * 分页函数
 *
 * @param int $count 条目总数
 * @param int $perlogs 每页显示条数目
 * @param int $page 当前页码
 * @param string $url 页码的地址
 * @return unknown
 */
 
function pagination($count,$perlogs,$page,$url,$suffix=''){

	global $TS_SITE;
	
	$urlset = $TS_SITE['base']['site_urltype'];
	if($urlset == 3){
		$suffix = '.html';
	}elseif($urlset == 7){
		$suffix = '/';
	}

	$pnums = @ceil($count / $perlogs);
	$re = '';
	for ($i = $page-5;$i <= $page+5 && $i <= $pnums; $i++){
		if ($i > 0){
			if ($i == $page){
				$re .= ' <span class="current">'.$i.'</span> ';
			} else {
				$re .= '<a href="'.$url.$i.$suffix.'">'.$i.'</a>';
			}
		}
	}
	if ($page > 6) $re = '<a href="'.$url.'1'.$suffix.'" title="首页">&laquo;</a> ...'.$re;
	if ($page + 5 < $pnums) $re .= '... <a href="'.$url.$pnums.$suffix.'" title="尾页">&raquo;</a>';
	if ($pnums <= 1) $re = '';
	return $re;
}

//验证Email

function valid_email($email){
	if(preg_match('/^[A-Za-z0-9]+([._\-\+]*[A-Za-z0-9]+)*@([A-Za-z0-9-]+\.)+[A-Za-z0-9]+$/', $email)){
		return true;
	}else{
		return false;
	}
} 

//处理时间的函数
 
function getTime($btime, $etime){

	if ($btime < $etime) {
		$stime = $btime;
		$endtime = $etime;
	}else {
		$stime = $etime;
		$endtime = $btime;
	}
	$timec = $endtime - $stime;
	$days = intval($timec / 86400);
	$rtime = $timec % 86400;
	$hours = intval($rtime / 3600);
	$rtime = $rtime % 3600;
	$mins = intval($rtime / 60);
	$secs = $rtime % 60;
	if($days>=1){
		return $days.' 天前';
	}
	if($hours>=1){
		return $hours.' 小时前';
	}

	if($mins>=1){
		return $mins.' 分钟前';
	}
	if($secs>=1){
		return $secs.' 秒前';
	}
 
}

//获取用户IP
 
function getIp(){

	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')){
		$PHP_IP = getenv('HTTP_CLIENT_IP');
	}elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')){
		$PHP_IP = getenv('HTTP_X_FORWARDED_FOR');
	}elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')){
		$PHP_IP = getenv('REMOTE_ADDR');
	}elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')){
		$PHP_IP = $_SERVER['REMOTE_ADDR'];
	}
	preg_match("/[\d\.]{7,15}/", $PHP_IP, $ipmatches);
	$PHP_IP = $ipmatches[0] ? $ipmatches[0] : 'unknown';
	return $PHP_IP;
}

//纯文本输入
function t($text){
	$text=preg_replace('/\[.*?\]/is','',$text); 
	$text = cleanJs ( $text );
	//彻底过滤空格BY QINIAO
	$text = preg_replace('/\s(?=\s)/', '', $text);
	$text = preg_replace('/[\n\r\t]/', ' ', $text);
	$text = str_replace ( '  ', ' ', $text );
	$text = str_replace ( ' ', '', $text );
	$text = str_replace ( '&nbsp;', '', $text );
	$text = str_replace ( '&', '', $text );
	$text = str_replace ( '=', '', $text );
	$text = str_replace ( '-', '', $text );
	$text = str_replace ( '#', '', $text );
	$text = str_replace ( '%', '', $text );
	$text = str_replace ( '!', '', $text );
	$text = str_replace ( '@', '', $text );
	$text = str_replace ( '^', '', $text );
	$text = str_replace ( '*', '', $text );
	$text = str_replace ( 'amp;', '', $text );
	
	$text = strip_tags ( $text );
	$text = htmlspecialchars ( $text );
	$text = str_replace ( "'", "", $text );
	return $text;
}

//输入安全的html，针对存入数据库中的数据进行的过滤和转义
 
function h($text){
	$text = trim ( $text );
	$text = htmlspecialchars ( $text );
	$text = addslashes ( $text );
	return $text;
}

//utf-8截取
function cututf8($string, $start = 0,$sublen,$append=true){
	$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
	preg_match_all($pa, $string, $t_string);
	if(count($t_string[0]) - $start > $sublen && $append==true){
		return join('', array_slice($t_string[0], $start, $sublen))."...";
	}else{
		return join('', array_slice($t_string[0], $start, $sublen));
	}
}

//utf-8截取过渡
function getsubstrutf8($string, $start = 0,$sublen,$append=true){
	return cututf8($string, $start = 0,$sublen,$append=true);
}

//计算时间
function getmicrotime(){ 
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
}

/*写入文件，支持Memcache缓存
 @By QiuJun 2011-12-10
 @$file 缓存文件
 @$dir 缓存目录
 @$data 内容
 */
function fileWrite($file,$dir,$data,$isphp=1){
	
	global $TS_CF,$TS_MC;
	
	$dfile = $dir.'/'.$file;
	
	//支持memcache
	if($TS_CF['memcache'] && extension_loaded('memcache')){
		$TS_MC->delete(md5($dfile));
		$TS_MC->set(md5($dfile),$data,0,172800);
	}

	//同时保存文件
	!is_dir($dir)?mkdir($dir,0777):'';
	if(is_file($dfile)) unlink($dfile);
	if($isphp == 1){
		$data = "<?php\ndefined('IN_TS') or die('Access Denied.');\nreturn ".var_export($data,true).";";
	}
	
	file_put_contents($dfile,$data);
	
	return true;
}

/*
 *读取文件 支持Memcache缓存
 *$dfile 文件
 */
function fileRead($dfile){
	global $TS_CF,$TS_MC;
	//支持memcache
	if($TS_CF['memcache'] && extension_loaded('memcache')){
	
		if($TS_MC->get(md5($dfile))){
			return $TS_MC->get(md5($dfile));
		}else{
			if(is_file($dfile)) return include $dfile;
		}
	
	}else{
	
		if(is_file($dfile)) return include $dfile;
	
	}

}

//把数组转换为,号分割的字符串
function array_to_str($arr) {
	$str = '';
	$count = 1;
	if(is_array($arr)){
		foreach ($arr as $a) {
			if ($count==1) {
				$str .= $a;
			} else {
				$str .= ','.$a;
			}
				$count++;
		}
	}
	return $str;
}


//生成随机数(1数字,0字母数字组合)
function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
	$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}

/*
 *封装一个采集函数
 *@ $url 网址
 *@ $proxy 代理
 *@ $timeout 跳出时间
 */

function getHtmlByCurl($url,$proxy,$timeout){
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_PROXY, $proxy);
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	return $file_contents;
}

//计算文件大小
function format_bytes($size) {    
	$units = array(' B', ' KB', ' MB', ' GB', ' TB');    
	for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;    
	return round($size, 2).$units[$i];
}

//object2array 对象转数组
function object2array($array){
	if(is_object($array)){
		$array = (array)$array;
	}
	if(is_array($array)){
		foreach($array as $key=>$value){
			$array[$key] = object2array($value);
		}
	}
	return $array;
}

/*此处开始借用moophp的模板代码*/	

/**
* 写文件
* @param string $file - 需要写入的文件，系统的绝对路径加文件名
* @param string $content - 需要写入的内容
* @param string $mod - 写入模式，默认为w
* @param boolean $exit - 不能写入是否中断程序，默认为中断
* @return boolean 返回是否写入成功
*/
function isWriteFile($file, $content, $mod = 'w', $exit = TRUE) {
if(!@$fp = @fopen($file, $mod)) {
	if($exit) {
		exit('ThinkSAAS File :<br>'.$file.'<br>Have no access to write!');
	} else {
		return false;
	}
} else {
	@flock($fp, 2);
	@fwrite($fp, $content);
	@fclose($fp);
	return true;
}
}

//创建目录
function makedir($dir) {
return is_dir($dir) or (makedir(dirname($dir)) and mkdir($dir, 0777)); 
}

/**
* 加载模板
* @param string $file - 模板文件名
* @return string 返回编译后模板的系统绝对路径
* @param array $self 自定义路径，必须是数组格式
*/
function template($file,$plugin='',$self='') {
	global $app;
	
	if($plugin){
	$tplfile = 'plugins/'.$app.'/'.$plugin.'/'.$file.'.html';
	$objfile = 'cache/template/'.$plugin.'.'.$file.'.tpl.php';
	}else if($self){
	 foreach($self as $v){
	  $tplfile.=$v.'/';
	  $cache=$v.'_';
	 }
	 $tplfile = $tplfile.$file.'.html';
	 $objfile = 'cache/template/self/'.$self[3].'.'.$file.'.tpl.php';
	}else{
	$tplfile = 'app/'.$app.'/html/'.$file.'.html';
	$objfile = 'cache/template/'.$app.'.'.$file.'.tpl.php';	
	}
	
	if(@filemtime($tplfile) > @filemtime($objfile)) {
		//note 加载模板类文件
		require_once 'thinksaas/tsTemplate.php';
		$T = new tsTemplate();
		
		$T->complie($tplfile, $objfile);
		
	}
	
	return $objfile;
	unset($app);
}

//加载公用html模板文件 
function pubTemplate($file) {
$tplfile = 'public/html/'.$file.'.html';
$objfile = 'cache/template/public.'.$file.'.tpl.php';

if(@filemtime($tplfile) > @filemtime($objfile)) {
	//note 加载模板类文件
	
	require_once 'thinksaas/tsTemplate.php';
	$T = new tsTemplate();
	
	$T->complie($tplfile, $objfile);
}

return $objfile;
}

//针对app各个的插件部分，修改自Emlog
/**
* 该函数在插件中调用,挂载插件函数到预留的钩子上
*
* @param string $hook
* @param string $actionFunc
* @return boolearn
*/
function addAction($hook, $actionFunc){
	global $tsHooks;
	if (!@in_array($actionFunc, $tsHooks[$hook])){
		$tsHooks[$hook][] = $actionFunc;
	}

	return true;
}

/**
* 执行挂在钩子上的函数,支持多参数 eg:doAction('post_comment', $author, $email, $url, $comment);
*
* @param string $hook
*/
function doAction($hook){
	global $tsHooks,$TS_CF;
	$args = array_slice(func_get_args(), 1);
	if (isset($tsHooks[$hook])){
		foreach ($tsHooks[$hook] as $function){
			$string = call_user_func_array($function, $args);
		}
	}
	
	if($TS_CF['hook']) var_dump($hook);
	
}

function createFolders($path)  {  
	//递归创建  
	if (!file_exists($path)){  
		createFolders(dirname($path));//取得最后一个文件夹的全路径返回开始的地方  
		mkdir($path, 0777);  
	}  
}

//删除文件夹和文件夹下所有的文件
function delDir($dir=''){
	if (empty($dir)){
		$dir = rtrim(RUNTIME_PATH,'/');
	}
	if (substr($dir,-1) == '/'){
		$dir = rtrim($dir,'/');
	}
	if (!file_exists($dir)) return true;
	if (!is_dir($dir) || is_link($dir)) return @unlink($dir);
	foreach (scandir($dir) as $item) {
		if ($item == '.' || $item == '..') continue;
		if (!delDir($dir . "/" . $item)) {
			@chmod($dir . "/" . $item, 0777);
			if (!delDir($dir . "/" . $item)) return false;
		};
	}
	return @rmdir($dir);
}

//获取带http的网站域名 BY QIUJUN
function getHttpUrl(){
	$arrUri = explode('index.php',$_SERVER['REQUEST_URI']);
	$site_url = 'http://'.$_SERVER['HTTP_HOST'].$arrUri[0];
	return $site_url;
}

// 10位MD5值
function md10($str=''){
	return substr(md5($str),10,10);
}

/*
 * ThinkSAAS专用图片截图函数
 * $file：数据库里的图片url
 * $app：app名称
 * $w：缩略图片宽度
 * $h：缩略图片高度
 * $c:1裁切,0不裁切
 */
function tsXimg($file, $app , $w, $h,$path='',$c='0'){

	if(!$file) { return;}
	
	$info = explode('.',$file);
	
	$name = md10($file).'_'.$w.'_'.$h.'.'.$info[1];
	
	if($path==''){
		$cpath = 'cache/'.$app.'/'.$w.'/'.$name;
	}else{
		$cpath = 'cache/'.$app.'/'.$path.'/'.$w.'/'.$name;
	}
	
	
	if(!is_file($cpath)){
		createFolders('cache/'.$app.'/'.$path.'/'.$w);
		$dest = 'uploadfile/'.$app.'/'.$file;
		$arrImg = getimagesize($dest);
		if($arrImg[0] <= $w){
			copy($dest,$cpath);
		}else{
			require_once 'thinksaas/tsImage.php';
			$resizeimage = new tsImage("$dest", $w, $h, $c,"$cpath");
		}
	}
	return $cpath;
}

/*
 * TS专用删除缓存图片
 * $file：数据库里的图片url
 * $app：app名称
 * $w：缩略图片宽度
 * $h：缩略图片高度
 */
function tsDimg($file,$app,$w,$h,$path){
	$info = explode('.',$file);
	$name = md10($file).'_'.$w.'_'.$h.'.'.$info[1];
	unlink('cache/'.$app.'/'.$path.'/'.$w.'/'.$name);
	return true;
}

//gzip压缩输出
function ob_gzip($content) { 
	if( !headers_sent() && extension_loaded("zlib") && strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip")) {
		//$content = gzencode($content." \n//此页已压缩",9); 
		$content = gzencode($content,9); 
		header("Content-Encoding: gzip"); 
		header("Vary: Accept-Encoding");
		header("Content-Length: ".strlen($content));
	}
	return $content; 
}


/* tsUrl()  By QIUJUN
 * tsUrl提供至少4种的url展示方式
 * (1)index.php?app=group&ac=topic&topicid=1 //标准默认模式
 * (2)index.php/group/topic/topicid-1   //path_info模式
 * (3)group-topic-topicid-1.html   //rewrite模式1
 * (4)group/topic/topicid-1   //rewrite模式2
 */
function tsUrl($app,$ac='',$params=array()){
	global $TS_CF;
	global $TS_SITE;
	$urlset = $TS_SITE['base']['site_urltype'];
	
	if($urlset==1){
		foreach($params as $k=>$v){
			$str .= '&'.$k.'='.$v;
		}
		if($ac==''){
			$ac = '';
		}else{
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				$ac='?ac='.$ac;
			}else{
				$ac='&ac='.$ac;
			}
		}
		if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
			$url = 'index.php'.$ac.$str;
		}else{
			$url = 'index.php?app='.$app.$ac.$str;
		}
	}elseif($urlset == 2){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'-'.$v;
		}
		if($ac==''){
			$ac='';
		}else{
			$ac='/'.$ac;
		}
		
		if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
			$url = 'index.php'.$ac.$str;
		}else{
			$url = 'index.php/'.$app.$ac.$str;
		}
	}elseif($urlset == 3){
		foreach($params as $k=>$v){
			$str .= '-'.$k.'-'.$v;
		}
		
		if($ac==''){
			$ac='';
		}else{
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				$ac=$ac;
			}else{
				$ac='-'.$ac;
			}
		}
		
		$page = strpos($str,'page');
		
		if($page){
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				$url = $ac.$str;
			}else{
				$url = $app.$ac.$str;
			}
		}else{
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				$url = $ac.$str.'.html';
			}else{
				$url = $app.$ac.$str.'.html';
			}
			
		}
		
	}elseif($urlset == 4){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'-'.$v;
		}		
		if($ac==''){
			$ac='';
		}else{
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				$ac=$ac;
			}else{
				$ac='/'.$ac;
			}
			
		}
		if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
			$url = $ac.$str;
		}else{
			$url = $app.$ac.$str;
		}
		
	}elseif($urlset == 5){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'/'.$v;
		}
		$str=str_replace('/id','',$str);	
		if($ac==''){
			$ac='';
		}else{
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				$ac=$ac;
			}else{
				$ac='/'.$ac;
			}
			
		}
		if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
			$url = $ac.$str;
		}else{
			$url = $app.$ac.$str;
		}
		
	}elseif($urlset == 6){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'/'.$v;
		}
		
		if($ac==''){
			$ac='';
		}else{
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				$ac=$ac;
			}else{
				$ac='/'.$ac;
			}
		}
		if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
			$url = $ac.$str;
		}else{
			$url = $app.$ac.$str;
		}
		
	}elseif($urlset == 7){
		foreach($params as $k=>$v){
			$str .= '/'.$k.'/'.$v;
		}
		$str=str_replace('/id','',$str);
		if($ac==''){
			$ac='';
		}else{
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				$ac=$ac;
			}else{
				$ac='/'.$ac;
			}
			
		}
		
		$page = strpos($str,'page');
		
		if($page){
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				$url = $ac.$str;
			}else{
				$url = $app.$ac.$str;
			}
			
		}else{
			if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app']) || $TS_CF['appdomain'][$app]){
				if($ac==''){
					$url = '';
				}else{
					$url = $ac.$str.'/';
				}
				
			}else{
				$url = $app.$ac.$str.'/';
			}
		}
		
	}
	if($TS_CF['subdomain'] && in_array($app,$TS_CF['subdomain']['app'])){
		return 'http://'.$app.'.'.$TS_CF['subdomain']['domain'].'/'.$url;
	}elseif($TS_CF['appdomain'][$app]){
		return 'http://'.$TS_CF['appdomain'][$app].'/'.$url;
	}else{
		return SITE_URL.$url;
	}
}

//reurl BY QIUJUN 2011-10-23

function reurl(){

	$options = fileRead('data/system_options.php');	
	$scriptName = explode('index.php',$_SERVER['SCRIPT_NAME']);
	$rurl = substr($_SERVER['REQUEST_URI'], strlen($scriptName[0]));
	
	if(strpos($rurl,'?')==false){
	
		if(preg_match('/index.php/i',$rurl)){
			$rurl = str_replace('index.php','',$rurl);
			$rurl = substr($rurl, 1);			
			$params = $rurl;
		}else{
			$params = $rurl;
		}
		
		
		if($rurl){
			
			if($options['site_urltype']==3){
			//http://localhost/group-topic-id-1.html
				$params = explode('.', $params);
				
				$params = explode('-', $params[0]);
			
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;break;
						default:
							
							if($v) $kv[] = $v;
							
							break;
					}
				}
				
				$ck = count($kv)/2;
				
				if($ck>=2){
					$arrKv = array_chunk($kv,$ck);
					foreach($arrKv as $key=>$item){
						$_GET[$item[0]] = $item[1];
					}
				}elseif($ck==1){
					$_GET[$kv[0]] = $kv[1];
				}else{
					
				}
				
			}elseif($options['site_urltype']==4){
			//http://localhost/group/topic/id-1
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;break;
						default:
							$kv = explode('-', $v);
							
							if(count($kv)>1){
								$_GET[$kv[0]] = $kv[1];
							}else{
								$_GET['params'.$p] = $kv[0];
							}
							break;
					}
				}
			
			}elseif($options['site_urltype']==5){
			//http://localhost/group/topic/1
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;
							if(empty($_GET['ac'])) $_GET['ac']='index';
							break;
						case 2:	
							if(((int) $v)>0){
								$_GET['id']=$v;
								break;
							}
							//处理TAG
							if($_GET['ac']=='tag'){
								$_GET['id']=$v;
								break;
							}
							
						default:
							$_GET[$v]=$params[$p+1];
							break;
					}
				}
			
			}elseif($options['site_urltype']==6){
			//http://localhost/group/topic/id/1
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;break;
						default:
							$_GET[$v]=$params[$p+1];
							break;
					}
				}
			}elseif($options['site_urltype']==7){
			//http://localhost/group/topic/1/
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;
							if(empty($_GET['ac'])) $_GET['ac']='index';
							break;
						case 2:	
							if(((int) $v)>0){
								$_GET['id']=$v;
								break;
							}
							//处理TAG
							if($_GET['ac']=='tag'){
								$_GET['id']=$v;
								break;
							}
							
						default:
							$_GET[$v]=$params[$p+1];
							break;
					}
				}
				
			}else{
			
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['app']=$v;break;
						case 1:$_GET['ac']=$v;break;
						default:
							$kv = explode('-', $v);
							if(count($kv)>1){
								$_GET[$kv[0]] = $kv[1];
							}else{
								$_GET['params'.$p] = $kv[0];
							}
							break;
					}
				}
			
			}
			
		}
	}
}

//辅助APP二级域名
function reurlsubdomain(){

	$options = fileRead('data/system_options.php');	
	$scriptName = explode('index.php',$_SERVER['SCRIPT_NAME']);
	$rurl = substr($_SERVER['REQUEST_URI'], strlen($scriptName[0]));
	
	if(strpos($rurl,'?')==false){
	
		if(preg_match('/index.php/i',$rurl)){
			$rurl = str_replace('index.php','',$rurl);
			$rurl = substr($rurl, 1);			
			$params = $rurl;
		}else{
			$params = $rurl;
		}
		
		
		if($rurl){
			
			if($options['site_urltype']==3){
			//http://group.thinksaas.cn/topic-id-1.html
				$params = explode('.', $params);
				
				$params = explode('-', $params[0]);
			
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['ac']=$v;break;
						default:
							
							if($v) $kv[] = $v;
							
							break;
					}
				}
				
				$ck = count($kv)/2;
				
				if($ck>=2){
					$arrKv = array_chunk($kv,$ck);
					foreach($arrKv as $key=>$item){
						$_GET[$item[0]] = $item[1];
					}
				}elseif($ck==1){
					$_GET[$kv[0]] = $kv[1];
				}else{
					
				}
				
			}elseif($options['site_urltype']==4){
			//http://group.thinksaas.cn/topic/id-1
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['ac']=$v;break;
						default:
							$kv = explode('-', $v);
							
							if(count($kv)>1){
								$_GET[$kv[0]] = $kv[1];
							}else{
								$_GET['params'.$p] = $kv[0];
							}
							break;
					}
				}
			
			}elseif($options['site_urltype']==5){
			//http://group.thinksaas.cn/topic/1
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['ac']=$v;
							if(empty($_GET['ac'])) $_GET['ac']='index';
							break;
						case 1:	
							if(((int) $v)>0){
								$_GET['id']=$v;
								break;
							}
						default:
							$_GET[$v]=$params[$p+1];
							break;
					}
				}
			
			}elseif($options['site_urltype']==6){
			//http://group.thinksaas.cn/topic/id/1
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['ac']=$v;break;
						default:
							$_GET[$v]=$params[$p+1];
							break;
					}
				}
			}elseif($options['site_urltype']==7){
			//http://group.thinksaas.cn/topic/1/
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['ac']=$v;
							if(empty($_GET['ac'])) $_GET['ac']='index';
							break;
						case 1:	
							if(((int) $v)>0){
								$_GET['id']=$v;
								break;
							}
						default:
							$_GET[$v]=$params[$p+1];
							break;
					}
				}
				
			}else{
			
				$params = explode('/', $params);
				
				foreach( $params as $p => $v ){
					switch($p){
						case 0:$_GET['ac']=$v;break;
						default:
							$kv = explode('-', $v);
							if(count($kv)>1){
								$_GET[$kv[0]] = $kv[1];
							}else{
								$_GET['params'.$p] = $kv[0];
							}
							break;
					}
				}
			
			}
			
		}
	}
}

//检测目录是否可写1可写，0不可写
function iswriteable($file){
	if(is_dir($file)){
		$dir=$file;
		if($fp = fopen("$dir/test.txt", 'w')) {
			fclose($fp);
			unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}else{
		if($fp = fopen($file, 'a+')) {
			fclose($fp);
			$writeable = 1;
		}else {
			$writeable = 0;
		}
	}
	return $writeable;
}

//删除目录下文件
function delDirFile($dir){
	$arrFiles = dirList($dir,'files');
	foreach($arrFiles as $item){
		unlink($dir.'/'.$item);
	}
}

/*
 * ThinkSAAS专用上传函数 
 * $file 要上传的文件 如$_FILES['photo']
 * $projectid 上传针对的项目id  如$userid
 * $dir 上传到目录  如 user
 * $uptypes 上传类型，数组 array('jpg','png','gif')
 *
 * 返回数组：array('name'=>'','path'=>'','url'=>'','path'=>'','size'=>'')
 */
function tsUpload($files,$projectid,$dir,$uptypes){
		
	if ($files['size']>0) {
		
		$menu2=intval($projectid/1000);
		
		$menu1=intval($menu2/1000);
		
		$path = $menu1.'/'.$menu2;
		
		$dest_dir='uploadfile/'.$dir.'/'.$path;
		
		createFolders($dest_dir);
		
		$arrType = explode('.',strtolower($files['name'])); //转小写一下
		
		$type = array_pop($arrType);
		
		if (in_array($type,$uptypes)) {
			
			$name = $projectid.'.'.$type;
			
			$dest=$dest_dir.'/'.$name;
			
			//先删除
			unlink($dest);
			//后上传
			move_uploaded_file($files['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			
			chmod($dest, 0777);
			
			$filesize=filesize($dest);
			if(intval($filesize) > 0){
				return array(
					'name'=>$files['name'],
					'path'=>$path,
					'url'=>$path.'/'.$name,
					'type'=>$type,
					'size'=>$files['size'],
				);
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}
}

//扫描目录
function tsScanDir($dir,$isDir=null){

	if($isDir == null){
		$dirs = array_filter(glob($dir.'/'.'*'), 'is_dir');
	}else{
		$dirs = array_filter(glob($dir.'/'.'*'), 'is_file');
	}
	
	foreach($dirs as $key=>$item){
		$y=explode('/',$item);
		$arrDirs[] = array_pop($y);
	}
	
	return $arrDirs;
	
}

//删除目录下所有文件
function rmrf($dir) {
    foreach (glob($dir) as $file) {
        if (is_dir($file)) { 
            rmrf("$file/*");
            rmdir($file);
        } else {
            unlink($file);
        }
    }
}

//内容url解析
function urlcontent($content){
	$pattern='/(http:\/\/|https:\/\/|ftp:\/\/)([\w:\/\.\?=&-_#]+)/is';
	$content = preg_replace($pattern, '<a rel="nofollow" target="_blank" href="\1\2">\1\2</a>', $content);
	return $content;
}

//反序列化为UTF-8
function mb_unserialize($serial_str) {
	$serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
	$serial_str= str_replace("\r", "", $serial_str);      
	return unserialize($serial_str);
}

//反序列化为ASC
function asc_unserialize($serial_str) {
	$serial_str = preg_replace('!s:(\d+):"(.*?)";!se', '"s:".strlen("$2").":\"$2\";"', $serial_str );
	$serial_str= str_replace("\r", "", $serial_str);      
	return unserialize($serial_str);
}


//二进制上传
function tsXupload($projectid,$dir,$type){

	$menu2=intval($projectid/1000);
	$menu1=intval($menu2/1000);
	$path = $menu1.'/'.$menu2;
	$dest_dir='uploadfile/'.$dir.'/'.$path;
	createFolders($dest_dir);
	
	$name = $projectid.'.'.$type;//要生成的图片名字
	
	$dest=$dest_dir.'/'.$name;
	
	//先删除
	unlink($dest);

	$xmlstr =  $GLOBALS[HTTP_RAW_POST_DATA];
	if(empty($xmlstr)) $xmlstr = file_get_contents('php://input');
	$jpg = $xmlstr;//得到post过来的二进制原始数据
	$file = fopen($dest,"w");//打开文件准备写入
	fwrite($file,$jpg);//写入
	fclose($file);//关闭
	
	chmod($dest, 0777);
	
	return array(
		'name'=>$name,
		'path'=>$path,
		'url'=>$path.'/'.$name,
		'type'=>$type,
	);
	
}

//记录日志
function logging($file,$data){
	!is_dir('logs')?mkdir('logs',0777):'';
	$dfile = 'logs/'.$file;
	
	$filesize=abs(filesize($dfile));
	
	//文件重命名
	if($filesize>1024000){
		rename($dfile,$dfile.date('His'));
	}
	
	$fd = fopen($dfile, "a+"); 
	fputs($fd, $data); 
	fclose($fd); 
}


//记录用户日志
function userlog(&$array,$userid){
	if (is_array($array)) {        
		foreach ($array as $key => $value) {             
			if (!is_array($value)) {    
				$data = "UserId:".$userid."\n";
				$data .= "IP:".getIp()."\n";
				$data .= "TIME:".date('Y-m-d H:i:s')."\n";
				$data .= "URL:".$_SERVER['REQUEST_URI']."\n";
				$data .= "DATA:".$data."\n";
				$data .= "--------------------------------------\n";
				logging(date('Ymd').'-'.$userid.'.txt',$data);
			} else {
				userlog($array[$key]);
			}        
		}
	} 
}

/**
* 为变量或者数组添加转义
* @param string $value - 字符串或者数组变量
* @return array
*/
function tsadds($value){
	return $value = is_array($value) ? array_map('tsadds', $value) : addslashes($value);
}

/**
* 获取GPC变量。对于type为integer的变量强制转化为数字型
* @param string $key - 权限表达式
* @param string $type - integer 数字类型；string 字符串类型；array 数组类型
* @param string $var - R $REQUEST变量；G $GET变量；P $POST变量；C $COOKIE变量
* @return string 返回经过过滤或者初始化的GPC变量
*/
function tsgpc($key, $type = 'integer', $var = 'R') {
	switch($var) {
		case 'G': $var = &$_GET; break;
		case 'P': $var = &$_POST; break;
		case 'C': $var = &$_COOKIE; break;
		case 'R': $var = &$_REQUEST; break;
	}
	switch($type) {
		case 'integer':
			$return = isset($var[$key]) ? intval($var[$key]) : 0;
			break;
		case 'string':
			$return = isset($var[$key]) ? $var[$key] : NULL;
			break;
		case 'array':
			$return = isset($var[$key]) ? $var[$key] : array();
			break;
		default:
			$return = isset($var[$key]) ? intval($var[$key]) : 0;
	}
	return $return;
}

//过滤脚本代码
function cleanJs($text){
	$text = trim ( $text );
	$text = stripslashes ( $text );
	//完全过滤注释
	$text = preg_replace ( '/<!--?.*-->/', '', $text ); 
	//完全过滤动态代码
	$text = preg_replace ( '/<\?|\?>/', '', $text );
	//完全过滤js
	$text = preg_replace ( '/<script?.*\/script>/', '', $text );
	//过滤多余html
	$text = preg_replace ( '/<\/?(html|head|meta|link|base|body|title|style|script|form|iframe|frame|frameset)[^><]*>/i', '', $text );
	//过滤on事件lang js
	while ( preg_match ( '/(<[^><]+)(lang|onfinish|onmouse|onexit|onerror|onclick|onkey|onload|onchange|onfocus|onblur)[^><]+/i', $text, $mat ) ){
		$text = str_replace ( $mat [0], $mat [1], $text );
	}
	while ( preg_match ( '/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $text, $mat ) ){
		$text = str_replace ( $mat [0], $mat [1] . $mat [3], $text );
	}
	return $text;
}

//输入安全过滤
function tsClean($text){
	$text = cleanJs($text);
	return $text;
}