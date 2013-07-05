<?php
defined('IN_TS') or die('Access Denied.');
// 学习篇
function studyarea_html ()
{
    $arrHotTopics = aac('group')->findAll('group_topics', 
            array(
                    'istop' => '1'
            ), 'addtime desc', null, 4);
    include template('studyarea', 'studyarea');
}

addAction('home_index_left', 'studyarea_html');

