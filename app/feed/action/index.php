<?php
defined('IN_TS') or die('Access Denied.');

$page = isset($_GET['page']) ? $_GET['page'] : '1';
$url = tsUrl('feed','index',array('page'=>''));
$lstart = $page*20-20;

$arrFeeds = $new['feed']->findAll('feed',null,'addtime desc',null,$lstart.',20');

$feedNum = $new['feed']->findCount('feed');

$pageUrl = pagination($feedNum, 20, $page, $url);

if($page > 1){
	$title = '社区动态 - 第'.$page.'页';
}else{
	$title = '社区动态';
}

foreach($arrFeeds as $key=>$item){

	$arrFeed[] = $item;
	$arrFeed[$key]['app'] = $new['feed']->find($item['apptable'],array(
		$item['appkey']=>$item['appid'],
	));
	$arrFeed[$key]['app']['title'] = htmlspecialchars($arrFeed[$key]['app']['title']);
	//$arrFeed[$key]['app']['content'] = $new['feed']->hview($arrFeed[$key]['app']['content']);

	if($item['commentid']){
		$arrFeed[$key]['comment'] = $new['feed']->find($item['commenttable'],array(
			$item['commentkey']=>$item['commentid'],
		),'content');
		//$arrFeed[$key]['comment']['content'] = $new['feed']->hview($arrFeed[$key]['comment']['content']);
	}
	$arrFeed[$key]['user'] = aac('user')->getOneUser($item['userid']);

}

//社区精华帖
$arrPosts = $new['feed']->findAll('group_topics',array(
	'isposts'=>1,
),'uptime desc',null,15);

$title = '社区动态';
include template('index');