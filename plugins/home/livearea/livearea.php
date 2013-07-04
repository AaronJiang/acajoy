<?php 
defined('IN_TS') or die('Access Denied.'); 
//生活篇
function livearea_html(){
    $arrArticles = aac('article')->findAll('article',array('isaudit'=>0),'addtime desc',null,3);  
    foreach($arrArticles as $key=>$item){
    	$arrArticle[] = $item;
    	$arrArticle[$key]['user'] = aac('user')->getOneUser($item['userid']);
    	$arrArticle[$key]['rate'] = aac('article')->getAverageRate($item['articleid']);
    }  
    include template('livearea','livearea');
	
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
