<?php
	/*
	 *包含数据库配置文件
	 */
	require_once JOYDATA."/config.inc.php";
	
	$TS_APP['options']['appname'] = '活动';
	
	$skin = 'default';
	
	//其他配置信息
	$TS_NOIMG['group']['48']	= 'data/uploadfile/group/default/002.gif';
	$TS_NOIMG['user']['48'] 	= 'data/uploadfile/user/default/noavatar.gif';
	$TS_NOIMG['user']['95'] 	= 'data/uploadfile/user/default/upload_photo.gif';
	
	//URL REWRITE
	
	if($TS_APP['options']['isrewrite']=='0'):
	$TS_URL['group'] = 'index.php?app=group&ac=group&groupid=';
	$TS_URL['group_user'] = 'index.php?app=group&ac=group_user&groupid=';
	$TS_URL['group_topic'] = 'index.php?app=group&ac=group_topic&groupid=';
	$TS_URL['topic'] = 'index.php?app=group&ac=topic&topicid=';
	$TS_URL['cate'] = 'index.php?app=group&ac=cate&cateid=';
	$TS_URL['rss'] = 'index.php?app=group&ac=rss&groupid=';
	$TS_URL['suffix'] = '';
	else:
	$TS_URL['group'] = 'group-';
	$TS_URL['group_user'] = 'g-user-';
	$TS_URL['group_topic'] = 'g-topic-';
	$TS_URL['topic'] = 'topic-';
	$TS_URL['cate'] = 'cate-';
	$TS_URL['rss'] = 'rss-';
	$TS_URL['suffix'] = '.html';
	endif;