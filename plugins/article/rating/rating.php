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

addAction('aritcle_rating_set', 'rating_set_html');
addAction('aritcle_rating_get', 'rating_get_html');
addAction('pub_footer', 'rating_javascript'); //load rating js in footer