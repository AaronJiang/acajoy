<?php
defined('IN_TS') or die('Access Denied.');

function rating_set_html ()
{
    include template('rating_set', 'rating'); 
}

function rating_get_html ()
{
	include template('rating_get','rating');
}

function rating_javascript()
{
    echo <<<EOF
    <script type="text/javascript" src="/plugins/article/rating/assets/jquery.rateit.min.js"></script>
EOF;
}

function rating_css()
{
	echo <<<EOF
    <link type="text/css" rel="stylesheet" href="/plugins/article/rating/assets/rateit.css"/>
EOF;
}

addAction('aritcle_rating_set', 'rating_set_html');
addAction('aritcle_rating_get', 'rating_get_html');
addAction('pub_footer', 'rating_javascript'); //load rating js in footer
addAction('pub_header_top', 'rating_css');