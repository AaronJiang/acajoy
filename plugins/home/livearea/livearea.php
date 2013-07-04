<?php 
defined('IN_TS') or die('Access Denied.'); 
//生活篇
function livearea_html(){
    //纷呈校园
    $arrArticles_school = aac('article')->getRecommendArticle(1);  
    $article_school = get_article_userrate($arrArticles_school);
     
    //远方的家
    $arrArticles_hometown = aac('article')->getRecommendArticle(2);
    $article_hometown = get_article_userrate($arrArticles_hometown);
    
    //旅游季
    $arrArticles_travel = aac('article')->getRecommendArticle(3);
    $article_travel = get_article_userrate($arrArticles_travel);
    
    include template('livearea','livearea');
	
}

function get_article_userrate($articles)
{
    foreach($articles as $key=>$item){
    	$arrArticle[] = $item;
    	$arrArticle[$key]['user'] = aac('user')->getOneUser($item['userid']);
    	$arrArticle[$key]['rate'] = aac('article')->getAverageRate($item['articleid']);
    }
    return $arrArticle;
}

function livearea_javascript()
{
	echo <<<EOF
    <script type="text/javascript" src="/plugins/article/rating/assets/jquery.rateit.min.js"></script>
EOF;
}

function livearea_css()
{
	echo <<<EOF
    <link type="text/css" rel="stylesheet" href="/plugins/article/rating/assets/rateit.css"/>
EOF;
}


addAction('home_index_left','livearea_html');
addAction('pub_footer', 'livearea_javascript');
addAction('pub_header_top', 'livearea_css');
