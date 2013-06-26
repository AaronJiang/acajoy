<?php 
defined('IN_TS') or die('Access Denied.');

$upapp = trim($_POST['upapp']);
$upversion = trim($_POST['upversion']);

//先删除旧文件
unlink('upgrade/'.$upapp.'.zip');

//拼接出要下载的远程文件
$upfile = 'http://up.thinksaas.cn/'.$upapp.'/'.$upversion.'/'.$upapp.'.zip';

/*第一步：多线程下载zip压缩文件*/
$urls=array(
	$upfile,
	$upfile,
	$upfile,
);
$save_to='upgrade/';

$mh=curl_multi_init();
foreach($urls as $i=>$url){
	$g=$save_to.basename($url);
	if(!is_file($g)){
		$conn[$i]=curl_init($url);
		$fp[$i]=fopen($g,"w");
		curl_setopt($conn[$i],CURLOPT_USERAGENT,"Mozilla/4.0(compatible; MSIE 7.0; Windows NT 6.0)");
		curl_setopt($conn[$i],CURLOPT_FILE,$fp[$i]);
		curl_setopt($conn[$i],CURLOPT_HEADER ,0);
		curl_setopt($conn[$i],CURLOPT_CONNECTTIMEOUT,60);
		curl_multi_add_handle($mh,$conn[$i]);
	}
}
do{
	$n=curl_multi_exec($mh,$active);
}while($active);
foreach($urls as $i=>$url){
	curl_multi_remove_handle($mh,$conn[$i]);
	curl_close($conn[$i]);
	fclose($fp[$i]);
}
curl_multi_close($mh);

chmod('upgrade/'.$upapp.'.zip',0777);

/*第二步：下载完之后开始解压覆盖原有文件*/
if($upapp=='thinksaas'){
	$extract = $upapp;
}else{
	$extract = 'app/'.$upapp;
}

//检测目录是否可写
if(iswriteable($extract)==0){
	echo 2;exit;
}

include 'thinksaas/pclzip.lib.php';
$archive = new PclZip('upgrade/'.$upapp.'.zip');
if ($archive->extract(PCLZIP_OPT_PATH, $extract,PCLZIP_OPT_REPLACE_NEWER) == 0) {
	//die("Error : ".$archive->errorInfo(true));
	
	echo 0;exit;
	
}else{
	unlink('upgrade/'.$upapp.'.zip');
}

/*第三步：升级数据库*/
if($upapp!='thinksaas'){
	if(is_file('app/'.$upapp.'/upgrade.sql')){
		$sqlFile = file_get_contents('app/'.$upapp.'/upgrade.sql');
		$sqlFile = str_replace('ts_',dbprefix,$sqlFile);
		$arrSql = explode('--------------------',$sqlFile);
		foreach($arrSql as $item){
			$item = trim($item);
			if ($item){
				$db->query($item);
			}
		}
	}
}

//升级成功
echo 1;exit;