<?php
defined('IN_TS') or die('Access Denied.');

//列表 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$url = tsUrl('article','index',array('page'=>''));
$lstart = $page*10-10;

$arrArticles = $db->fetch_all_assoc("
        select a.*, ROUND(AVG(r.score), 1) as rate_average, count(r.score) as rate_count 
        from ".dbprefix."article as a, ".dbprefix."article_rate as r
        where a.isaudit='0'
        and a.articleid = r.articleid 
        group by articleid
        order by addtime desc 
        limit $lstart, 10"
);

$articleNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."article where `isaudit`='0'");

$pageUrl = pagination($articleNum['count(*)'], 10, $page, $url);

foreach($arrArticles as $key=>$item){
	$arrArticle[] = $item;
	$arrArticle[$key]['content'] = cututf8(t($item['content']),0,100);
	$arrArticle[$key]['user'] = aac('user')->getOneUser($item['userid']);
	$arrArticle[$key]['cate'] = $new['article']->getOneCate($item['cateid']);
}

//推荐阅读
$arrRecommend = $new['article']->getRecommendArticle();

//一周热门
$arrHot7 = $new['article']->getHotArticle(7);
//一月热门
$arrHot30 = $new['article']->getHotArticle(30);


$title = '文章';

include template('index');