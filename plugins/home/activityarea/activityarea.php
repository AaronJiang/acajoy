<?php
defined('IN_TS') or die('Access Denied.');
// 活动篇
function activityarea_html ()
{
    $events = aac('event')->getRecommendArticleEvent();
    foreach ($events as $key => $item) {
        $arrEvents[] = $item;
        $arrEvents[$key]['user'] = aac('user')->getOneUser($item['userid']);
        $arrEvents[$key]['count_userwish'] = aac('event')->findCount('event_users', 
                array(
                        'eventid' => $item['eventid'],
                        'status' => 1
                ));
        $arrEvents[$key]['count_userdo'] = aac('event')->findCount('event_users', 
                array(
                        'eventid' => $item['eventid'],
                        'status' => 0
                ));
       
    }
    
    include template('activityarea', 'activityarea');
}

addAction('home_index_left', 'activityarea_html');

