<?php
defined('IN_TS') or die('Access Denied.');
$articleid = intval($_POST['id']);
$score = trim($_POST['value']);

switch ($ts) {
    case "get":
        $return = array(
        		'error' => 0,
        		'score' => $score
        );
        
        $rate = $new['article']->find(
                'article_rate', 
                array('articleid' => $articleid), 
                'ROUND(AVG(score),1) AS average, count(articleid) AS count'
        );
        if ($rate) {
            $return['score']['average'] = $rate['average'];
            $return['score']['count'] = $rate['count'];
            
        } else {
            $return['error'] = 1;
        }
        
        echo json_encode($return);
        break;
    
    case "set":
        $return = array(
                'error' => 5,
                'score' => $score
        );
        
        if (isset($articleid)) {
            
            $commentNum = $new['article']->findCount('article_rate', 
                    array(
                            'articleid' => $articleid,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'addtime' => date('Y-m-d')
                    ));
            
            if ($commentNum > 0) {
                $return['error'] = 1;
                $return['msg'] = '抱歉, 您今天已经投过票了，明天再投吧';
            } else {
                $new['article']->create('article_rate', 
                        array(
                                'articleid' => $articleid,
                                'score' => $score,
                                'ip' => $_SERVER['REMOTE_ADDR'],
                                'addtime' => date('Y-m-d')
                        ));
                $return['msg'] = '投票成功，感谢您的参与';
            }
        }
        echo json_encode($return);
        break;
    
    default:
        break;
}

