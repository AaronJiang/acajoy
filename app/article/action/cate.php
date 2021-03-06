<?php  
defined('IN_TS') or die('Access Denied.');

$cateid = intval($_GET['id']);
$strCate = $new['article']->getOneCate($cateid);

//列表 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$url = tsUrl('article','cate',array('id'=>$cateid,'page'=>''));
$lstart = $page*10-10;

$arrArticles = $new['article']->findAll('article',array(
	'cateid'=>$cateid,
	'isaudit'=>0,
),'addtime desc',null,$lstart.',10');

$articleNum = $new['article']->findCount('article',array(
	'cateid'=>$cateid,
	'isaudit'=>0,

));

$pageUrl = pagination($articleNum, 10, $page, $url);

foreach ($arrArticles as $key => $item) {
    $arrArticle[] = $item;
    $arrArticle[$key]['content'] = cututf8(t($item['content']), 0, 150);
    $arrArticle[$key]['user'] = aac('user')->getOneUser($item['userid']);
    $arrArticle[$key]['rate'] = $new['article']->getAverageRate($item['articleid']);
}

//推荐阅读
$arrRecommend = $new['article']->getRecommendArticle();

//一周热门
$arrHot7 = $new['article']->getHotArticle(7,$strCate['cateid']);
//一月热门
$arrHot30 = $new['article']->getHotArticle(30,$strCate['cateid']);

$title = $strCate['catename'];

//SEO优化
$sitekey = $strCate['catename'];
$sitedesc = $strCate['catename'].' - 文章';

//当前位置
$arrLocal = array(
	array(
		'title'=>'首页',
		'url'=>SITE_URL,
	),
	array(
		'title'=>'文章',
		'url'=>tsUrl('article'),
	),
	array(
		'title'=>$strCate['catename'],
		'url'=>tsUrl('article','cate',array('id'=>$strCate['cateid'])),
	),
);

include template('cate');