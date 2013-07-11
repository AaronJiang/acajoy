<?php
defined('IN_TS') or die('Access Denied.');

switch($ts){
	
	case "list":
		
		//列表 
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=article&ac=admin&mg=cate&ts=list&page=';
		$lstart = $page*10-10;

		$arrCate = $db->fetch_all_assoc("select * from ".dbprefix."article_cate order by cateid desc limit $lstart, 10");

		$cateNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."article_cate");

		$pageUrl = pagination($cateNum['count(*)'], 10, $page, $url);
		
		include template("admin/cate_list");
		
		break;
		
	case "add":
	
		include template("admin/cate_add");
	
		break;
		
	case "add_do":
	
		$catename = trim($_POST['catename']);
		$cateNum=$new['article']->findCount('article_cate');
		if($cateNum>=10){
		  qiMsg('文章分类数量不得超过10个！');
		  exit;
		}
		$db->query("insert into ".dbprefix."article_cate (`catename`) values ('$catename')");
		
		header("Location: ".SITE_URL.'index.php?app=article&ac=admin&mg=cate&ts=list');
	
		break;
		
	case "edit":
		$cateid = $_GET['cateid'];
		
		$strCate = $db->once_fetch_assoc("select * from ".dbprefix."article_cate where `cateid`='$cateid'");
		
		include template("admin/cate_edit");
		break;
		
	case "edit_do":
		
		$cateid = $_POST['cateid'];
		$catename = trim($_POST['catename']);
		
		$db->query("update ".dbprefix."article_cate set `catename`='$catename' where `cateid`='$cateid'");
		
		qiMsg("修改成功！");
		
		break;
		
	//删除
	case "delete":
		$cateid = intval($_GET['cateid']);
		
		//首先判断本分类下是否有文章

		$isArticle = $new['article']->findCount('article',array(
			'cateid'=>$cateid,
		));
		
		if($isArticle>0){
		
			qiMsg('分类下有文章存在，不允许删除该分类！');
		
		}
		
		$new['article']->delete('article_cate',array(
			'cateid'=>$cateid,
		));

		qiMsg('删除分类成功！');
		
		break;
	
}