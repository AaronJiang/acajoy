-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 07 月 25 日 05:54
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `thinksaas`
--

-- --------------------------------------------------------

--
-- 表的结构 `ts_app_event`
--

CREATE TABLE IF NOT EXISTS `ts_app_event` (
  `eventid` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `typeid` int(11) NOT NULL DEFAULT '0' COMMENT '活动类型ID',
  `title` varchar(120) NOT NULL DEFAULT '' COMMENT '活动标题',
  `content` text NOT NULL COMMENT '活动内容',
  `time_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `time_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `poster` varchar(400) NOT NULL DEFAULT '' COMMENT '海报',
  `provinceid` int(11) NOT NULL DEFAULT '0' COMMENT '省份ID',
  `cityid` int(1) NOT NULL DEFAULT '0' COMMENT '城市ID',
  `areaid` int(11) NOT NULL DEFAULT '0' COMMENT '县区ID',
  `address` varchar(120) NOT NULL DEFAULT '' COMMENT '详细地址',
  `count_userdo` int(11) NOT NULL DEFAULT '0' COMMENT '统计参加的',
  `count_userwish` int(11) NOT NULL DEFAULT '0' COMMENT '统计感兴趣的',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`eventid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='活动' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ts_app_event_comment`
--

CREATE TABLE IF NOT EXISTS `ts_app_event_comment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `referid` int(11) NOT NULL DEFAULT '0',
  `eventid` int(11) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` text NOT NULL COMMENT '回复内容',
  `addtime` int(11) DEFAULT '0' COMMENT '回复时间',
  PRIMARY KEY (`commentid`),
  KEY `eventid` (`eventid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='话题回复/评论' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ts_app_event_comment`
--


-- --------------------------------------------------------

--
-- 表的结构 `ts_app_event_group_index`
--

CREATE TABLE IF NOT EXISTS `ts_app_event_group_index` (
  `eventid` int(11) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  UNIQUE KEY `eventid_2` (`eventid`,`groupid`),
  KEY `eventid` (`eventid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='活动小组索引表';

-- --------------------------------------------------------

--
-- 表的结构 `ts_app_event_type`
--

CREATE TABLE IF NOT EXISTS `ts_app_event_type` (
  `typeid` int(11) NOT NULL AUTO_INCREMENT COMMENT '类型ID',
  `typename` varchar(64) NOT NULL DEFAULT '' COMMENT '类型名称',
  `count_event` int(11) NOT NULL DEFAULT '0' COMMENT '统计活动',
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='话题类型' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `ts_app_event_type`
--

INSERT INTO `ts_app_event_type` (`typeid`, `typename`, `count_event`) VALUES
(1, '音乐/演出', 3),
(2, '展览', 0),
(3, '电影', 0),
(4, '讲座/沙龙', 1),
(5, '戏剧/曲艺', 0),
(6, '生活/聚会', 2),
(7, '体育', 0),
(8, '旅行', 0),
(9, '公益', 0),
(10, '其他', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ts_app_event_users`
--

CREATE TABLE IF NOT EXISTS `ts_app_event_users` (
  `eventid` int(11) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0加入，1感兴趣',
  `isorganizer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是组织者:0不是1是',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  KEY `eventid` (`eventid`,`status`),
  KEY `userid` (`userid`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='活动用户';