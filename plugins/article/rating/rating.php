<?php
defined('IN_TS') or die('Access Denied.');

function rating_set_html ()
{
    echo <<<EOF
    <link type="text/css" rel="stylesheet" href="/plugins/article/rating/assets/rateit.css"/>
    <b>你的评分</b> : <div class="rateit" data-rateit-value="0" data-rateit-resetable="false" articleid="123"> </div> 
    <span id="rate_response"></span>
    <script>
     // set tooltip value       
     $(".tar .rateit").bind('over', function (event,value) { $(this).attr('title', value); });       
     $('.tar .rateit').bind('rated reset', function (e) {
         var ri = $(this);
 
         //if the use pressed reset, it will get value: 0 (to be compatible with the HTML range control), we could check if e.type == 'reset', and then set the value to  null .
         var value = ri.rateit('value');
         var articleid = ri.data('articleid'); // if the product id was in some hidden field: ri.closest('li').find('input[name="productid"]').val()
 
         //maybe we want to disable voting?
         ri.rateit('readonly', true);
         $.ajax({
             url: siteUrl+'index.php?app=article&ac=rate&ts=set',
             data: { id: articleid, value: value }, //our data
             type: 'POST',
             success: function (data) {
                 $('#rate_response').html(data);
             }
         });
     });
    </script>
EOF;
    
//     include template('rating','rating_set');
}

function rating_get_html ()
{
    echo <<<EOF
    <link type="text/css" rel="stylesheet" href="/plugins/article/rating/assets/rateit.css"/>
    <div class="rateit" data-rateit-value="2.5" data-rateit-ispreset="true" data-rateit-readonly="true"></div><span class="rateit_score">2.5</span> (34944人评分)
EOF;
// 	include template('rating','rating_get');
}

function rating_javascript()
{
    echo <<<EOF
    <script type="text/javascript" src="/plugins/article/rating/assets/jquery.rateit.min.js"></script>
EOF;
}

addAction('aritcle_rating_set', 'rating_set_html');
addAction('aritcle_rating_get', 'rating_get_html');
addAction('pub_footer', 'rating_javascript');