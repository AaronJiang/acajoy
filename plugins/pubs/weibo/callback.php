<?php
/*
 *	 新浪微博回调页面
 *
 * Email: silenceper@gmail.com
 * Site: www.zzblo.com
 *
 * */
defined('IN_TS') or die('Access Denied.'); 

include_once( 'saetv2.ex.class.php' );
$o = new SaeTOAuthV2($_SESSION['wb_akey'] , $_SESSION['wb_skey'] );
function get_access_token($o){

	//通过返回的code获取 access_token
	if (isset($_REQUEST['code'])) {
		$keys = array();
		$keys['code'] = $_REQUEST['code'];
		$keys['redirect_uri'] = $_SESSION['wb_callback'];
		try {
			$wb_token = $o->getAccessToken( 'code', $keys ) ;
		} catch (OAuthException $e) {
		}

		/*DEBUG 
		var_dump($wb_token);  
	
		array(4) {
		["access_token"]=>
		string(32) "2.00gmtoqB1U554C1abd36a6b3LchN4B"
		["remind_in"]=>
		string(6) "104348"
		["expires_in"]=>
		int(104348)
		["uid"]=>
		string(10) "1696633142"	
	}

	*/

		return $wb_token;
	}
}


//将access_token存放在session中
$wb_token=get_access_token($o);

$_SESSION['wb_token']=$wb_token;
//根据wb_token 获取 uid 
$c = new SaeTClientV2( $_SESSION['wb_akey']  , $_SESSION['wb_skey']  , $_SESSION['wb_token']['access_token'] );

//存放uid的数组
$uid=$c->get_uid();

//将uid存放在session中
$_SESSION['wb_uid']=$uid['uid'];

//根据uid在数组库中查找oid

$wb_uid = $new['pubs']->findCount('user_open',array(
	'sitename'=>'weibo',
	'openid'=>$_SESSION['wb_uid'],
));

//在数据库中查找到了uid  说明用户的 可以使用微博登入  否则注册
if($wb_uid > 0){
		$strOpen = $new['pubs']->find('user_open',array(
		'sitename'=>'weibo',
		'openid'=>$_SESSION['wb_uid'],
	));
	
	$update=$new['pubs']->update('user_open',array(
			'sitename'=>'weibo',
			'openid'=>$_SESSION['wb_uid'],
		),
		array(
			'access_token'=>$_SESSION['wb_token']['access_token'],
		)
	);
	if(false===$update){
		qiMsg("登入失败请与系统管理员联系");
	}
	
	//更新数据库结束  
	
	$userData = $new['pubs']->find('user_info',array(
		'userid'=>$strOpen['userid'],
	),'userid,username,areaid,path,face,count_score,isadmin,uptime');
	
	$_SESSION['tsuser']	= $userData;
	header("Location: ".SITE_URL);

/*
 * }if($_SESSION['tsuser']){
	//账号绑定
	header("Location: ".SITE_URL."index.php?app=pubs&ac=plugin&plugin=weibo&in=binding");
 * 
 */
	
}else{
	//新用户登入
	header("Location: ".SITE_URL."index.php?app=pubs&ac=plugin&plugin=weibo&in=userinfo");
}
