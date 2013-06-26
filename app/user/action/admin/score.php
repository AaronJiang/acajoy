<?php 
defined('IN_TS') or die('Access Denied.');
//积分设置
switch($ts){

	case "list":
	
		$arrScore = $new['user']->findAll('user_score');
		
		include template('admin/score_list');
		break;
		
	case "adddo":
	
		$scorekey = trim($_POST['scorekey']);
		$scorename = trim($_POST['scorename']);
		$score = intval($_POST['score']);
		
		$new['user']->create('user_score',array(
			'scorekey'=>$scorekey,
			'scorename'=>$scorename,
			'score'=>$score,
		));
		
		header('Location: '.SITE_URL.'index.php?app=user&ac=admin&mg=score&ts=list');
	
		break;
		
	case "editdo":
	
		$scoreid = intval($_POST['scoreid']);
		$score = intval($_POST['score']);
		
		$new['user']->update('user_soce',array(
			'scoreid'=>$scoreid,
		),array(
			'score'=>$score,
		));
		
		header('Location: '.SITE_URL.'index.php?app=user&ac=admin&mg=score&ts=list');
	
		break;

}