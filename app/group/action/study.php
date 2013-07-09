<?php 
defined('IN_TS') or die('Access Denied.');

$cateid = 7;
		$strCate = $new['group']->find('group_cates',array(
			'cateid'=>$cateid,
		));
	
		
		$arrCate = $new['group']->findAll('group_cates',array(
			'referid'=>$cateid,
		));
		
		
		//分类下小组
		$page = isset($_GET['page']) ? $_GET['page'] : '1';
		$url = tsUrl('group','cate',array('ts'=>'2','page'=>''));
		$lstart = $page*20-20;
		$arrGroup = $new['group']->findAll('group',array(
			'cateid'=>$cateid,
		),null,null,$lstart.',20');
		$groupNum = $new['group']->findCount('group',array(
			'cateid'=>$cateid,
		));
		$pageUrl = pagination($groupNum, 20, $page, $url);

		
		
		
		$title = $strCate['catename'];
		include template('cate2');

