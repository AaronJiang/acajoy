<?php 
//环境配置文件
return array(
	
	//Memcache配置
	'memcache'=>array(
		//'host' => '127.0.0.1',
		//'port' => 11211,
	),
	
	//是否开启显示插件钩子
	'hook'=>false, 
	
	//是否开启数据库存取session  暂时还有点问题预留
	'session'=>false,   
	
	//是否开启系统日志记录功能，日志存放在根目录下logs目录下
	'logs'=>false,  
	
	//是否支持app二级域名访问，比如小组group支持group.acajoy.cn域名访问
	//不开启请留空数组，开启写域名，比如acajoy.cn
	'subdomain'=>array(
		//'domain'=>'thinkpaas.com', //域名
		//'app'=>array('group','user'), //开启子域的APP
	), 
	
	//APP独立域名支持
	'appdomain'=>array(
		//'photo'=>'www.thinkphotos.com', //www.thinkphotos.com
	),
	
	//数据库配置
	'db'=>array(
		'sql'=>'mysql',
		'host'=>'localhost',
		'port'=>'3306',
		'user'=>'root',
		'pwd'=>'',
		'name'=>'acajoy',
		'pre'=>'ts_',
	)
	
	
);