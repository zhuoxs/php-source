-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 �?09 �?13 �?12:30
-- 服务器版本: 5.5.53
-- PHP 版本: 5.6.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `root`
--

-- --------------------------------------------------------

--
-- 表的结构 `mac_actor`
--

CREATE TABLE IF NOT EXISTS `mac_actor` (
  `actor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `actor_name` varchar(255) NOT NULL DEFAULT '',
  `actor_en` varchar(255) NOT NULL DEFAULT '',
  `actor_alias` varchar(255) NOT NULL DEFAULT '',
  `actor_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actor_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actor_letter` char(1) NOT NULL DEFAULT '',
  `actor_sex` char(1) NOT NULL DEFAULT '',
  `actor_color` varchar(6) NOT NULL DEFAULT '',
  `actor_pic` varchar(255) NOT NULL DEFAULT '',
  `actor_blurb` varchar(255) NOT NULL DEFAULT '',
  `actor_remarks` varchar(100) NOT NULL DEFAULT '',
  `actor_area` varchar(20) NOT NULL DEFAULT '',
  `actor_height` varchar(10) NOT NULL DEFAULT '',
  `actor_weight` varchar(10) NOT NULL DEFAULT '',
  `actor_birthday` varchar(10) NOT NULL DEFAULT '',
  `actor_birtharea` varchar(20) NOT NULL DEFAULT '',
  `actor_blood` varchar(10) NOT NULL DEFAULT '',
  `actor_starsign` varchar(10) NOT NULL DEFAULT '',
  `actor_school` varchar(20) NOT NULL DEFAULT '',
  `actor_works` varchar(255) NOT NULL DEFAULT '',
  `actor_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actor_time` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `actor_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_score_num` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `actor_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_tpl` varchar(30) NOT NULL DEFAULT '',
  `actor_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `actor_content` text NOT NULL,
  PRIMARY KEY (`actor_id`),
  KEY `actor_name` (`actor_name`) USING BTREE,
  KEY `actor_en` (`actor_en`) USING BTREE,
  KEY `actor_letter` (`actor_letter`) USING BTREE,
  KEY `actor_level` (`actor_level`) USING BTREE,
  KEY `actor_time` (`actor_time`) USING BTREE,
  KEY `actor_time_add` (`actor_time_add`) USING BTREE,
  KEY `actor_sex` (`actor_sex`),
  KEY `actor_area` (`actor_area`),
  KEY `actor_up` (`actor_up`),
  KEY `actor_down` (`actor_down`),
  KEY `actor_score` (`actor_score`),
  KEY `actor_score_all` (`actor_score_all`),
  KEY `actor_score_num` (`actor_score_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_admin`
--

CREATE TABLE IF NOT EXISTS `mac_admin` (
  `admin_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(30) NOT NULL DEFAULT '',
  `admin_pwd` char(32) NOT NULL DEFAULT '',
  `admin_random` char(32) NOT NULL DEFAULT '',
  `admin_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `admin_auth` text NOT NULL,
  `admin_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_login_num` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_last_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`),
  KEY `admin_name` (`admin_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `mac_admin`
--

INSERT INTO `mac_admin` (`admin_id`, `admin_name`, `admin_pwd`, `admin_random`, `admin_status`, `admin_auth`, `admin_login_time`, `admin_login_ip`, `admin_login_num`, `admin_last_login_time`, `admin_last_login_ip`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '9cd536af2c0aa81a52599b08e44e4fa4', 1, ',index/welcome,', 1568377506, 0, 28, 1566400160, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mac_art`
--

CREATE TABLE IF NOT EXISTS `mac_art` (
  `art_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_id_1` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `art_name` varchar(255) NOT NULL DEFAULT '',
  `art_sub` varchar(255) NOT NULL DEFAULT '',
  `art_en` varchar(255) NOT NULL DEFAULT '',
  `art_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_letter` char(1) NOT NULL DEFAULT '',
  `art_color` varchar(6) NOT NULL DEFAULT '',
  `art_from` varchar(30) NOT NULL DEFAULT '',
  `art_author` varchar(30) NOT NULL DEFAULT '',
  `art_tag` varchar(100) NOT NULL DEFAULT '',
  `art_class` varchar(255) NOT NULL DEFAULT '',
  `art_pic` varchar(255) NOT NULL DEFAULT '',
  `art_pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `art_pic_slide` varchar(255) NOT NULL DEFAULT '',
  `art_blurb` varchar(255) NOT NULL DEFAULT '',
  `art_remarks` varchar(100) NOT NULL DEFAULT '',
  `art_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `art_tpl` varchar(30) NOT NULL DEFAULT '',
  `art_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_time` int(10) unsigned NOT NULL DEFAULT '0',
  `art_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `art_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `art_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `art_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `art_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_score_num` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `art_rel_art` varchar(255) NOT NULL DEFAULT '',
  `art_rel_vod` varchar(255) NOT NULL DEFAULT '',
  `art_title` mediumtext NOT NULL,
  `art_note` mediumtext NOT NULL,
  `art_content` mediumtext NOT NULL,
  `art_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `art_points_detail` smallint(6) unsigned NOT NULL DEFAULT '0',
  `art_pwd` varchar(10) NOT NULL DEFAULT '',
  `art_pwd_url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`art_id`),
  KEY `type_id` (`type_id`) USING BTREE,
  KEY `type_id_1` (`type_id_1`) USING BTREE,
  KEY `art_level` (`art_level`) USING BTREE,
  KEY `art_hits` (`art_hits`) USING BTREE,
  KEY `art_time` (`art_time`) USING BTREE,
  KEY `art_letter` (`art_letter`) USING BTREE,
  KEY `art_down` (`art_down`) USING BTREE,
  KEY `art_up` (`art_up`) USING BTREE,
  KEY `art_tag` (`art_tag`) USING BTREE,
  KEY `art_name` (`art_name`) USING BTREE,
  KEY `art_enname` (`art_en`) USING BTREE,
  KEY `art_hits_day` (`art_hits_day`) USING BTREE,
  KEY `art_hits_week` (`art_hits_week`) USING BTREE,
  KEY `art_hits_month` (`art_hits_month`) USING BTREE,
  KEY `art_time_add` (`art_time_add`) USING BTREE,
  KEY `art_time_make` (`art_time_make`) USING BTREE,
  KEY `art_lock` (`art_lock`),
  KEY `art_score` (`art_score`),
  KEY `art_score_all` (`art_score_all`),
  KEY `art_score_num` (`art_score_num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `mac_art`
--

INSERT INTO `mac_art` (`art_id`, `type_id`, `type_id_1`, `group_id`, `art_name`, `art_sub`, `art_en`, `art_status`, `art_letter`, `art_color`, `art_from`, `art_author`, `art_tag`, `art_class`, `art_pic`, `art_pic_thumb`, `art_pic_slide`, `art_blurb`, `art_remarks`, `art_jumpurl`, `art_tpl`, `art_level`, `art_lock`, `art_up`, `art_down`, `art_hits`, `art_hits_day`, `art_hits_week`, `art_hits_month`, `art_time`, `art_time_add`, `art_time_hits`, `art_time_make`, `art_score`, `art_score_all`, `art_score_num`, `art_rel_art`, `art_rel_vod`, `art_title`, `art_note`, `art_content`, `art_points`, `art_points_detail`, `art_pwd`, `art_pwd_url`) VALUES
(1, 9, 0, 0, '最新网红主播套图 编码：1', '', 'zuixinwanghongzhubotaotubianma1', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/8681b0ae312f7ad5a6be661ea2dffa1c.jpg', '', '', '', '', '', '', 0, 0, 948, 60, 6113, 1, 1, 1, 1542955486, 1541211605, 1566214795, 0, '9.0', 40, 8, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(2, 9, 0, 0, '最新网红主播套图 编码：2', '', 'zuixinwanghongzhubotaotubianma2', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/525bdba336f9e440eff8c8631b026bcb.jpg', '', '', '', '', '', '', 0, 0, 506, 115, 1833, 1, 1, 1, 1542955607, 1541211826, 1564355250, 0, '10.0', 804, 92, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(3, 9, 0, 0, '最新网红主播套图 编码：3', '', 'zuixinwanghongzhubotaotubianma3', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/23bb3239a1fe1e5ab352928785784288.jpg', '', '', '', '', '', '', 0, 0, 425, 869, 2187, 1, 1, 1, 1542955687, 1541212279, 1564355313, 0, '4.0', 85, 30, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(4, 9, 0, 0, '最新网红主播套图 编码：4', '', 'zuixinwanghongzhubotaotubianma4', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/95b540c03ce90624dc98171c864c319d.jpg', '', '', '', '', '', '', 0, 0, 634, 362, 7730, 1, 1, 1, 1542955705, 1541212388, 1564355192, 0, '5.0', 586, 80, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(5, 9, 0, 0, '最新网红主播套图 编码：5', '', 'zuixinwanghongzhubotaotubianma5', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg', '', '', '', '', '', '', 0, 0, 442, 425, 4972, 1, 1, 1, 1542955725, 1541212426, 1564355193, 0, '1.0', 805, 78, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(6, 9, 0, 0, '最新网红主播套图 编码：6', '', 'zuixinwanghongzhubotaotubianma6', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/4a050035b77d27d3e604588596f148c1.jpg', '', '', '', '', '', '', 0, 0, 92, 237, 8866, 1, 1, 2, 1542955743, 1541212540, 1566275636, 0, '3.0', 524, 55, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(7, 9, 0, 0, '最新网红主播套图 编码：7', '', 'zuixinwanghongzhubotaotubianma7', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/0a170473e5c5b5c2a2f2a2271e757eb6.jpg', '', '', '', '', '', '', 0, 0, 807, 996, 4330, 1, 1, 1, 1542955761, 1541212583, 1564355253, 0, '2.0', 266, 3, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(8, 9, 0, 0, '最新网红主播套图 编码：8', '', 'zuixinwanghongzhubotaotubianma8', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/587e2310256ffd4546fa610445b09793.jpg', '', '', '', '', '', '', 0, 0, 492, 586, 8471, 1, 1, 2, 1542955782, 1541212632, 1566108909, 0, '7.0', 6, 77, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(9, 9, 0, 0, '最新网红主播套图 编码：9', '', 'zuixinwanghongzhubotaotubianma9', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/28d3d95052159cf9182c237ed20bf26a.jpg', '', '', '', '', '', '', 0, 0, 401, 761, 9245, 1, 1, 1, 1542955803, 1541212745, 1565159750, 0, '7.0', 27, 17, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(10, 9, 0, 0, '最新网红主播套图 编码：10', '', 'zuixinwanghongzhubotaotubianma10', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/9eb153f1ece6a49343bb9d7c72a47d78.jpg', '', '', '', '', '', '', 0, 0, 52, 721, 8111, 1, 1, 1, 1542955820, 1541212785, 1564355299, 0, '2.0', 10, 96, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(11, 9, 0, 0, '最新网红主播套图 编码：11', '', 'zuixinwanghongzhubotaotubianma11', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/c2ed02ee07f38bf34079bc06d8ebc6c0.jpg', '', '', '', '', '', '', 0, 0, 88, 48, 8707, 1, 1, 1, 1542955837, 1541212827, 1566099905, 0, '7.0', 178, 70, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(12, 9, 0, 0, '最新网红主播套图 编码：12', '', 'zuixinwanghongzhubotaotubianma12', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/e6d36b38af78b676599365694a7cd107.jpg', '', '', '', '', '', '', 0, 0, 599, 447, 6310, 1, 2, 4, 1542955857, 1541212862, 1566275626, 0, '2.0', 287, 9, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(13, 9, 0, 0, '最新网红主播套图 编码：13', '', 'zuixinwanghongzhubotaotubianma13', 1, 'Z', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/9b9be57010de6242838725444cc30a10.jpg', '', '', '', '', '', '', 0, 0, 983, 565, 4110, 1, 1, 5, 1542955876, 1541212913, 1566102011, 0, '10.0', 972, 67, '', '', '', '', '<p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/67027483c727ce4e8443fcb76291de8b.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/368adbdc4b2999f40197ff1d339ef5c2.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b06f6acbfa366f0c7de99d9940e521.jpg"/></p><p><img src="http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/78b749cc154e27adf7d7c7c982dc22cf.jpg"/></p>', 0, 0, '', ''),
(16, 22, 21, 0, '两颗心的距离', '', 'liangkexindejuli', 1, 'L', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/e6d36b38af78b676599365694a7cd107.jpg', '', '', '楔子  我们离婚吧　　夜，静得悄无声息。　　蔺韶华哄睡了将满周岁的儿子，步出房门。　　女主人尚未归来。　　仰头望了眼墙上的钟，时针不知不觉间已悄悄攀过12。　　为自己倒了杯水，静坐', '佚名', '', '', 0, 0, 0, 0, 6, 5, 5, 5, 1553066957, 1553065894, 1564355759, 0, '0.0', 0, 0, '', '', '第1页$$$第2页$$$第3页', '1$$$2$$$3', '<p>楔子&nbsp;&nbsp;我们离婚吧<br/><br/>　　夜，静得悄无声息。<br/><br/>　　蔺韶华哄睡了将满周岁的儿子，步出房门。<br/><br/>　　女主人尚未归来。<br/><br/>　　仰头望了眼墙上的钟，时针不知不觉间已悄悄攀过12。<br/><br/>　　为自己倒了杯水，静坐在沙发上，顺手打开电视，一台又一台漫无目的地跳转，也没真想看什么，不过是让屋里有点声音。<br/><br/>　　今天，是一年一度的金马盛事，几乎转到哪，都有相关报导，谁携着谁走红毯、众女星的妆容礼服配件大评比、颁奖典礼的精华播报、本届最大赢家……<br/><br/>　　而，无疑的，最抢版面的话题人物，莫过于她——<br/><br/>　　丁又宁。<br/><br/>　　出道六年首度入围，强敌环伺下，打败从影三十余年的戏精前辈、以及拿过三座金马、实力不容小觑的前任影后，强势封后。<br/><br/>　　几乎转到哪一台，都有她的身影。<br/><br/>　　一袭削肩的黑色晚宴服，巧妙露出白皙美背，收腰处将腰身纤盈曲线尽显，冷艳、优雅、高贵，她看起来，美得几乎连他都不舍得移开目光。<br/><br/>　　主持人访问时，笑称：“这身材哪像是生过一个孩子的妈呀！”<br/><br/>　　与她一同走红毯的，是这部让两人双双入围金马名单的男主角秦锐。<br/><br/>　　这是一部民初谍匪片，名日“绝色”。说实话，题材本身并不吃香，却硬是在男女主角的合作无间、默契满点下，冲出了三亿票房，蔺韶华自己都悄悄去看过，甚至不得不对两人所激出的火花所折服，莫怪乎影评人言一这男女主角，换掉谁都不对，两人的每一幕对手戏所产生的化学变化，无论是勾引、调情、谍对谍攻防战、转折纠结的内心戏处理，一举手一投足、每一个眼波流转，尽皆风情，他们，演活了“绝色”。<br/><br/>　　今天她能打败实力坚强的对手，可以说意外，却又不意外，她的胜出，实至名归。<br/><br/>　　凭着“绝色”一剧，两人双双称帝封后，堪称本届最大赢家。<br/><br/>　　她在受奖时，感性地说了这么几句：“我拍这部片时，几乎大半年没回家，老公一句抱怨都没有。我很感谢我的家人全心的支持我，他们是我最有力的后盾，这个奖，是他们的。我想告诉他们一我很抱歉，还有，谢谢你们。”<br/><br/>　　蔺韶华敛眸，掩去深瞳一抹意味不明的幽寂流光。<br/><br/>　　关了电视，回到主卧，躺上床，睁着眼，仍无睡意。<br/><br/>　　她今晚，应该不会太早回来。典礼过后，还有庆功宴。<br/><br/>　　翻了个身，拉拢被子，床头钟短针即将抵达3的数字，一阵细微声响传来，他睁开眼，望向出现在开启门扉旁，那道微醺身影。<br/><br/>　　那个，今夜最风光的女人，艳冠群芳、集所有目光焦点与掌声喝采于一身的新科影后。<br/><br/>　　他未语，静默地，凝视着那从萤光幕里走出来，伫立眼前的丽影。<br/><br/>　　真实的她。<br/><br/>　　却令他觉得一无比虚幻。<br/><br/>　　夫妻，本该是最亲密、无所不谈的伴侣，他与她一竟只能相顾无言。<br/><br/>　　何等凉寂，何等无奈。<br/><br/>　　她一会儿，她掀了掀唇，微哑的嗓，轻弱地吐出一句——<br/><br/>　　“我们，离婚吧。”<br/><br/>　　第一章&nbsp;&nbsp;江湖救急(1)<br/><br/>　　五月里，盛夏酷暑几乎要将人给烤熟，蔺韶华一步出办公大楼，迎面而来的热气让他几乎要后悔地缩回脚，转身窝进凉爽的办公室内。<br/><br/>　　“蔺先生，请等一下。”后头传来大楼管理员的叫唤，他本能停步，后方也正要出去的女子没来得及煞住步伐，险些一头撞上。<br/><br/>　　他下意识伸手，稳住对方。<br/><br/>　　那人戴着口罩，并刻意压低帽缘，将头垂得更低，但仍辨识得出，是名女子。<br/><br/>　　直觉，就是会让人下意识想多瞧几眼。<br/><br/>　　大楼管理员在这时赶上，递出一份文件，适时将他的注意力拉回。“有您的挂号信。”<br/><br/>　　“好的，谢谢。”他接过文件，在签收簿上签完名，转身离去。<br/><br/>　　女子偏头，玩味地瞧他一眼，扬唇。<br/><br/>　　想了想，随后跟上前去。<br/><br/>　　当蔺韶华留意到，方才那名差点与他撞在一块的女子尾随而来，他停步，不解地回眸，问：“有事吗？”<br/><br/>　　“没事啊！”她迅速端出一脸的纯真无害，只不过口罩掩住了大半张脸，没能充分发挥出那张据说目前为止打遍天下无敌手，还没人能成功招架的甜姊儿笑靥的威力，空负精湛演技。<br/><br/>　　蔺韶华没理会，步行至人行道上，见她又跟过来，不禁拧眉。<br/><br/>　　“小姐——”<br/><br/>　　“好啦，其实是有一点点、点点、非常小点的小事。”她举起拇指与食指，比出极小、再缩更小的间距。<br/><br/>　　“什么事？”<br/><br/>　　“这说来还真有点小尴尬——”女子深吸一口气，拿下口罩、以及那副几乎遮住半张脸的太阳眼镜，露出清美颜。<br/><br/>　　等不到下文，蔺韶华一脸“然后咧”的表情。<br/><br/>　　“你不知道我是谁？”女子微讶。这倒奇了，男人神情文风不动，眉毛都没挑动一根。<br/><br/>　　“我该知道吗？”<br/><br/>　　好久没遇到这种反应了，感觉一好微妙。<br/><br/>　　美眸一转，微讶过后，轻笑出声。“没什么。”<br/><br/>　　顿了顿，食指搔搔头，再启口时，语带些微窘意。“那个……我是要说，刚刚出门时太匆忙，忘记带钱包，恳请江湖救急，借个两百块搭车如何？”<br/><br/>　　蔺韶华正欲张口，女子忽然勾住他臂弯，顺势往他身旁靠，让道给路过的行人，同时不着痕迹藉由他掩去大半张脸。<br/><br/>　　他不禁蹙眉。这女人也太自来熟了吧？<br/><br/>　　拨开攀上的柔荑。“我没说不借，不用这样。”<br/><br/>　　“啊？”他这是想到哪去了？<br/><br/>　　由皮夹内抽出两张百元钞，递去后，没多说便举步离开。<br/><br/>　　“欸，等等、等等！你还没告诉我，你住哪？钱要怎么还你？”<br/><br/>　　“不用。”<br/><br/>　　“这怎么可以——”<br/><br/>　　蔺韶华停住，回瞪她一眼。“别再跟过来。”<br/><br/>　　被臭脸了。<br/><br/>　　既然人家都对她不假辞色了，她倒也识相，自己摸摸鼻子，移步往路口走去，见他一眼扫来，她连忙举起右手，这回可真是扎扎实实的无辜了。<br/><br/>　　“我没有跟着你喔，我也要等车。”还往旁边挪一步，以表清白。<br/><br/>　　蔺韶华见她站在公车站牌下，心想她应该是要等公车，伸手招了计程车，报上地址，打开车门，见门外那人张着水汪汪的大眼，很讨好地问：“那个——方便顺道让我搭个顺风车吗？”<br/><br/>　　“不方便。”想都没想，无情地当着她的面关上车门。<br/><br/>　　“……”小气巴啦。又不是故意缠着他，就刚好同路嘛，省钱又节能减碳，哪里不好？<br/><br/>　　眼巴巴看着车身驶离，她闷闷地戴回墨镜，认命伸手招下一辆计程车。<br/><br/>　　“爹地——”<br/><br/>　　没回应。<br/><br/>　　“爹、地——”声音放得更软、更水、更甜，好巴结、好可怜地再喊，只求对方回眸眷顾她一眼。<br/><br/>　　依旧无动于衷。<br/><br/>　　“爹地、爹地、爹地、爹——地——”尾声拉长长，仿效幼时的鹦鹉式叫法，一心一意地喊着她的发音练习，仿佛全天下再也没有比练好这词汇更重要的事了，仰望的目光，永远是最闪亮。<br/><br/>　　每当祭出这招，对方通常撑不了多久就会败下阵来。<br/><br/>　　这人人眼中的铁血硬汉，在她面前，其实比豆腐还软，好捏得很。<br/><br/>　　严君临翻页的手顿了顿，签完名，合上公文夹，顺手抓起桌上的布套面纸盒扔去。<br/><br/>　　“闭嘴。”都几岁了，还装什么可爱！<br/><br/>　　稳稳接住面纸盒，玉人儿一脸被嫌弃的伤心欲绝。“我要跟叔说，你家暴我。”<br/><br/>　　“家、暴？”最好装了布套的面纸盒砸得出伤来！<br/><br/>　　严君临眯眼，阴沉沉地望去，随时准备“如卿所愿”，坐实她的指控。<br/><br/>　　丁又宁机警地退开一大步。爹地很少体罚她，从小到大，五根手指都数不满，但、是！真惹他发起怒来，那可不是闹着玩的，爹地打人很痛很痛、哭爹喊娘的痛呀！<br/><br/>　　Uncle前两天已经偷偷给她通风报信，要她这阵子闪着点，爹地对她不太爽，不要自己找死往枪口上撞。<br/><br/>　　她本来已经避三天了，心想怒火应该已经消得差不多。要不是身无分文，离她最近的只有爹地公司，她的身分又不方便搭乘大众运输工具，两百块能到的只有这里，否则她还真不想自己找骂挨。</p>$$$<p>来的时候，见他爱理不搭的，就知道风暴还没过去。<br/><br/>　　“爹地啊，你还在生气喔？”她挨靠过去，扯扯对方袖口。<br/><br/>　　“你也知道我在生气？”他家里倒是养了好大一只老鼠啊，专咬他的布袋。<br/><br/>　　丁又宁干笑。“我这也是逼不得已啊，你知道的，人在江湖身不由已嘛——”<br/><br/>　　“身不由已？谁逼你脱衣卖肉了？”他是少她吃还是少她穿了？再不给她点颜色瞧瞧，她还当家里没大人，哪天真给他拍三级片去了！<br/><br/>　　“什么脱衣卖肉！这是艺术、艺术！艺术是无价的，你明白吗？我这叫为艺术牺牲！”她义正辞严、一本正经地纠正。<br/><br/>　　“嗯哼。”完全意味不明的哼应。<br/><br/>　　“说良心话，拍出来的效果，你觉得有很淫秽？低俗？不堪入目？有丢你的脸，低级到想把我吊起来毒打？”<br/><br/>　　倒没有。<br/><br/>　　严格来说，严君临只是利用这次机会，给她一点警醒，要她别忘了形，迷失在纸醉金迷的圈子里，遗忘最初那个纯真美好的自己。<br/><br/>　　“爹地，我知道你在担心什么。你放心，我会挑剧本，不好的戏，给我再高的价码我都不会演，会让爹地生气的事，我绝对不会做。”<br/><br/>　　她知道严君临的底线在哪里，也绝对不会去踩。<br/><br/>　　“我记得自己答应你的事。我会乖乖的、不变坏。”<br/><br/>　　严君临静了静，她一会儿，才道：“你没让我丢脸。”<br/><br/>　　他一直都不觉得，养这个女儿有让他丢什么脸，宁宁，是他的骄傲。<br/><br/>　　知道宁宁是他养女的人并不多，宁宁稍大些就不常来公司走动，识得她的也就这层楼几个高阶主管，高中毕业去瑞士读书，回来后走入演艺圈，模样与清新稚气的国、高中小女生已有一段差距。<br/><br/>　　对外，她从来不说、甚至是有些刻意避讳去提他们的关系。<br/><br/>　　后来玩票性地走入演艺圈，误打误撞成名后，更是鲜少来公司走动，他知道，宁宁是担心自己的工作环境，会为他带来困扰。<br/><br/>　　他是生意人，不喜面对镜头，更讨厌被狗仔追着问花边、绯闻、八卦，数年前与向怀秀那段，差点闹上社会版，着实让他烦扰了一阵子。<br/><br/>　　她不容易风平浪静，逐渐被世人所遗忘，他安于现下宁馨平和的小日子。宁宁也懂，总是避免因为自己的关系，让家被媒体追着跑。<br/><br/>　　他家的女孩，打小就乖巧、贴心，懂事到让他有些心疼。<br/><br/>　　第一章&nbsp;&nbsp;江湖救急(2)<br/><br/>　　严君临不擅于太温软的言司，叹了叹，就仅是抬手，摸摸她的头。<br/><br/>　　丁又宁笑开脸。“和好了？”<br/><br/>　　大老爷赏她两颗白果子。“一旁玩沙去。”<br/><br/>　　于是，丁小宁小朋友，哼着小曲儿到一旁愉快翻杂志去了，还自动自发替自己冲了杯咖啡，完全当自己家的自在。<br/><br/>　　泡完咖啡回来的路上，经过财务经理办公室，见着迎面而出的身影，不由“噫”了声。<br/><br/>　　“怎么又是你。”对方蹙眉。<br/><br/>　　她也想问。丁又宁啼笑皆非，直觉道：“我没跟踪你喔！”<br/><br/>　　赶快先澄清。<br/><br/>　　“我没这样想。”蔺韶华神色缓了缓。<br/><br/>　　严氏企业顶楼的高阶主管办公室，也不是她想跟踪就能随随便便上得来的。<br/><br/>　　“你在这里上班？”<br/><br/>　　我为什么要告诉你？<br/><br/>　　蔺韶华本能欲答，临出口前又觉口气太冲，硬生生改回：“不是。”<br/><br/>　　“啊，对了，你等我一下，一下下就好，先别走喔。”未待他回应，丁又宁快步离开。<br/><br/>　　一回来，开口便道：“爹地给我钱——”<br/><br/>　　严君临看向朝他伸来的纤纤玉手，抬眸讽道：“丁又宁，你还真孝顺啊，在外头就只学会了如何啃老？”<br/><br/>　　啃得真坦然。<br/><br/>　　“爹地本钱雄厚，我啃不干啦。”丁又宁干笑。“刚刚跟路人借钱来坐车投靠你，我要还他钱。”<br/><br/>　　“你可以再迷糊一点没关系！”严君临没好气道，一边从挂在椅背上的西装外套内抽出皮夹扔给她。<br/><br/>　　丁又宁收了打赏，一溜烟又跑回去找蔺韶华。<br/><br/>　　“感恩尊下仗义，施以援手，两百块大洋双手奉还。”前阵子一部古装戏刚杀青，时空还没调回来。<br/><br/>　　轻快俏皮的调性、再搭配招牌甜笑，一般人少有不买帐，偏偏眼前这个好像是例外，只觉轻佻浮夸，漠然收回纸钞。<br/><br/>　　“欸，你是不是很讨厌我？”丁又宁又不是傻的，多少还有点知觉神经，知道这男人对她好感度极低——<br/><br/>　　不，更正确来说，是能不熟就多不熟，排斥意味浓厚。<br/><br/>　　蔺韶华意味不明地瞥她一眼。“重要吗？”反正是不会往来的人。<br/><br/>　　是不顶重要啦，她也没自恋到觉得全世界都该喜欢她，但，没有理由被厌斥，滋味总不会太美妙。<br/><br/>　　“欸，我跟这里的老板关系还不错，需不需要我帮你说一声，让你比较好做事？”既然不是这里的员工，应该就是合作对象之类的，她很努力想释出善意，表示友好，这样能挽回一点点低迷的人气值吗？<br/><br/>　　能在这层楼随意晃荡，且自由进出总经理办公室，可想而知“关系”有多好了。<br/><br/>　　蔺韶华凛容。“不需要，谢谢。”他靠的是实力，不是关系。<br/><br/>　　完全不领情，转身，走人。<br/><br/>　　应该……厌恶感再更上一层楼了。她很有自觉。<br/><br/>　　碰了一鼻子灰，丁又宁又一脸挫折地返回总经理办公室。<br/><br/>　　“爹地——”她好幽怨地喊。<br/><br/>　　严君临在忙，没理她。<br/><br/>　　从小就是这样，大人在忙时，她就很乖地闪到边边自己找乐子，虽然有时还是会觉得寂寞，更小的时候不懂事，童言无忌，还跟爹地说：“不然你跟叔生一个妹妹陪我？”<br/><br/>　　现在想想，简直蠢毙了。<br/><br/>　　严君临审完一份急件，抬眸投去上瞥。<br/><br/>　　“我有这么顾人怨吗？”她抓紧时间，行使发言权。<br/><br/>　　真的，她刚刚很努力回想，把遇到那男人之后的每一个细节都回想过一遍，还是想不出自己哪里言行失当，让一个初识的人，明显厌斥她。<br/><br/>　　她觉得，对方是好人，面冷心善的那种，虽然一另很想离她愈远愈好的模样，听到她有困难，仍停下脚步，施以援手。<br/><br/>　　当然，这也不是代表他百分之百就是上好人，一切都只是她的直觉罢了，而她的直觉，向来很准。<br/><br/>　　所以她就更不懂了，自己究竟是哪里得罪了他？她有很认真在检讨自己，但——目前为止，还没检讨出个所以然来。<br/><br/>　　严君临没回她，于是她又认分地自己安静玩手指。待手边的急务处理完毕，收拾桌面与她一同下楼，开小差，喝一上午茶。<br/><br/>　　“大老板公然跷班，真的可以吗？”她打趣道。<br/><br/>　　严君临不冷不热地扫她一眼，某人倒很懂得适时卖乖，笑意甜甜地挽上他手臂。“知道爹地疼我。”不然他哪有吃下午茶的习惯呀，忙起来没忘记吃正餐就不错了。<br/><br/>　　电梯开启时，她不忘谨慎地戴回口罩与墨镜，免得不慎被狗仔拍到，目光扫视周遭，见那男人还没走，正在与员工确认资料，朝她望了一眼，又收回视线，她也没多此一举上前去打招呼。<br/><br/>　　严君临忽道：“我第一眼，也很不喜欢你表叔。”<br/><br/>　　“咦？”慢了半拍，才领悟到他是在回答她稍早的问题。<br/><br/>　　有这回事？都没听叔讲过。可就算是这样，现在还不是爱叔爱得死去活来。<br/><br/>　　“不了解你的人，难免会因为自身因素、外在因素，而产生一些错误的认知与偏见，你永远想不明白自己哪里招人嫌，也不需要刻意去想明白，因为那不是你的问题。”<br/><br/>　　“那你后来，是怎么扭转对叔的偏见？”<br/><br/>　　“因为理解。能够理解你的人，自然便懂，不能理解的，也不必强求，就当无缘。”重要的不是别人怎么看她，而是她自己是一个什么样的人，莫失本心，这才是最重要的。<br/><br/>　　只要，她一直都这么美好，那么，外人理不理解、喜不喜欢她，就纯粹是缘分问题。<br/><br/>　　“嗯，我明白的，爹地。”<br/><br/>　　“要我去说吗？”<br/><br/>　　“啊？”现在话题跳到哪了？<br/><br/>　　“他是我们公司委托的会计师，名字我得去查一下。”上一期的财报是他做的，名字只大略扫过一眼，日理万机的大老板没在记这个的。</p>$$$<p>丁又宁失笑。“爹地，你以为我想干么？”<br/><br/>　　严君临挑眉，一副“难道你没想干么吗”的表情。<br/><br/>　　知女莫若父，他几曾看宁宁介意过旁人的观感？身处演艺圈，招黑的机会可多得去了。<br/><br/>　　“好啦，我承认我以前见过他，但他好像忘记了。”还忘得一干二净。她表情有些闷。<br/><br/>　　“他是欠了你情还是欠了你钱？”还非得记住她不行？<br/><br/>　　“当然是欠钱罗！”半真半假地戏谑道。“我现在身无分文，超穷的！”<br/><br/>　　最好是。<br/><br/>　　“借据拿来，我帮你讨。”<br/><br/>　　“谢了。”丁又宁顺势将手搭上那伸来的掌，慢悠悠地笑回——<br/><br/>　　“我自己的债，自己讨。”<br/><br/>　　第二章&nbsp;&nbsp;树洞(1)<br/><br/>　　俗话说，不是冤家不聚头，验证在他们身上，还真是半点不差。<br/><br/>　　为了替新戏宣传，丁又宁近来勤跑通告。这时期综艺圈的形态有些病态，多以整治艺人为乐，砸派、水球、整人、吞虫、恐怖箱……什么都来，艺人被整得愈惨愈狼狈，观众愈爱看，而，丁又宁无法免俗的，也遇上那么几个。<br/><br/>　　说来也还好，她家经纪人会挑通告，太变态的不会让她去受委屈，她上一个节目是摸恐怖箱，其实早猜出里头是鳗鱼，但为了综艺效果，又不能表现得太淡定，还得适时配合着面露惊恐。<br/><br/>　　今天录棚外节目，与某知名大卖场借场地拍摄，每组艺人各自寻找路人搭档，游戏规则是限时内随意挑选卖场内二十样商品，总金额相等于制作组所规定的数字即过关，奖励是自己所挑选的物品，还有三分钟可为新戏宣传。当然，未过关就是砸派处分。<br/><br/>　　比起上一个被整得花容失色，回来直哭着说再也不上这个节目的小师妹，她还有过关的奖励规则，人性化多了，没什么可抱怨的。<br/><br/>　　适逢假日，卖场内人潮颇多，虽清了场方便录影，但围观群众还是挺可观，她一眼便望见人墙外围那道熟悉的身影。<br/><br/>　　大家都往内围挤，那男人被堵住去路，思考该如何绕道的当口，被她叫了住。<br/><br/>　　蔺韶华听她说明原委，本欲推拒，她抢在前头说：“拜托、拜托，不要让我被砸派。我会过敏，上次被砸派，皮肤起红疹一个礼拜无法见人。”<br/><br/>　　这么惨？<br/><br/>　　她恳求的表情摆得太真诚I蔺韶华到了嘴边的推拒言词，反倒说不出口。<br/><br/>　　好半晌，吐出一句：“我不能保证。”世事没有绝对。<br/><br/>　　意思是，答应了。<br/><br/>　　她笑开脸。“我相信你！”<br/><br/>　　蔺韶华心下一动，瞥视她。<br/><br/>　　其实，她也没多大把握，主持人赛前作简单访谈，问她为什么选他，她说：“我相信自己的眼光。”真的，就只是选了，就全心地相信他可以，择人不疑，疑人不择，如此罢了，真要说还有什么，或许一也因为他全身所散发的沉稳气场，令她安心。<br/><br/>　　短短三分钟的赛程，他表现得无比镇定，至少比起其他队的兵荒马乱、慌不择路，他看起来冷静多了，有条有理地出声指示她拿些什么东西。<br/><br/>　　游戏终止，他们完成任务归来，节目组——加总完品项金额。倒数十秒公布结果前的访谈，主持人问她紧不紧张结果？<br/><br/>　　她笑回：“听天由命罗！”<br/><br/>　　读秒完，结果公布的瞬间一万派齐飞。<br/><br/>　　蔺韶华有一秒的错愕，旋即，未加思索地移身护住她。<br/><br/>　　他被砸很惨。<br/><br/>　　主持人笑称：“看来你的眼光精准度还要再加强喔！”<br/><br/>　　录影结束后，他们在后台清理，蔺韶华灾情太惨，换了工作人员替他准备的干净衣物，正努力清理满头满脸残余的白色卖状物，她倒还好，只漉到部分飞散开来的残渣。<br/><br/>　　“那个一谢谢你。”<br/><br/>　　“不用谢，我并没有帮到你什么。”<br/><br/>　　丁又宁停下擦拭的动作，侧首瞧他。“你挑的商品，其实一毛钱都没有误差，对吧？”<br/><br/>　　蔺韶华动作一滞，又继续往耳后擦拭。“何以见得？”<br/><br/>　　严格来说，他们并不算认识，但她却能毫不犹豫，用那样坚定的语气说：我相信你！<br/><br/>　　那一瞬间的笑，很明亮。<br/><br/>　　“因为你的表情很错愕，显然这结果不在意料中。”爹地只说他是会计师，但并不代表会计师一定要精通心算，她只是碰碰运气，而显然的，他心算能力应是极佳。<br/><br/>　　“你不用介意，他们打一开始就决定要砸我派了，今天不管你表现多好，结果仍会是这样，不是你的问题。”见他蹙眉，她笑回：“你不知道作节目的生态呀，这种黑箱作业，司空见惯。”反正后制时，画面剪接一下，他们究竟有没有金额误差，谁看得出来？<br/><br/>　　“你得罪了谁吗？”不然人家为什么非要砸她？<br/><br/>　　丁又宁噗哧一声，笑了。“你真的很实心眼耶。”<br/><br/>　　她自信地选择了他当搭档，他一路冷静沉着一毫无意外完成任务了结束。<br/><br/>　　瞧，多无趣，多没哏？<br/><br/>　　节目要爆点、要高潮呀，她是今天的主要来宾，画面以及做哏多半会在她身上，她甚至可以预料到她被砸派的画面会被剪接成节目重点预告。<br/><br/>　　“对就是对，错就是错。”作节目连最基本的诚信都没有，如此迂回作假，把观众当傻子，他实在不能苟同。<br/><br/>　　丁又宁审视他的神情。“我猜，你应该不是讨厌我，是讨厌我的职业，对吧？”<br/><br/>　　也就是说，他一开始，就认出她是谁，才会退避三舍。<br/><br/>　　蔺韶华未语。<br/><br/>　　她猜对了，他真的不是讨厌她，他厌斥的，是她所属的环境。<br/><br/>　　“看来我又帮你找到一个讨厌演艺圈的理由了。”<br/><br/>　　他张了张口。“其实……”也没那么讨厌。<br/><br/>　　“好吧，我知道了。”至少，明白不是自己太顾人怨。<br/><br/>　　她知道什么？<br/><br/>　　补完妆，工作人员来唤她，要她过去讨谕下一段节目的录制，忙完再回来时，没看到蔺韶华的人，问工作人员，说是打理好便自行离开。<br/><br/>　　“他有没有留话给我？”<br/><br/>　　“没有啊，要说什么？”<br/><br/>　　“没有啊……”她重复低吟。<br/><br/>　　那日之后，约莫又过了一个礼拜I蔺韶华几乎已将此事忘记，午后，一名娇客的到访，又为他平静的生活掀起小小波澜。<br/><br/>　　“蔺哥、蔺哥，外面有人找你——”<br/><br/>　　女孩冲进来，不知是兴奋抑或奔跑所致，颊腮泛起两朵红晕。<br/><br/>　　“找我就找我，慌张什么？”又不是没被找过，会来事务所的十有八九是客户。<br/><br/>　　看出他在想什么，吕薇霓回：“不是客户喔！”<br/><br/>　　“嗯？”<br/><br/>　　“是个大美人昵。”见他神色未变，吕薇霓无趣地低哝：“就知道！再漂亮的大美女，到了你眼前也只剩木头一块。不过这次真的比较特别，人家好歹也是当红的大明星，你多少拿出一点点热情来好不好？别让她太没面子。”<br/><br/>　　大明星？他大概猜到是谁了。<br/><br/>　　跟他有过交集的大明星，也不过就这么一位。<br/><br/>　　搁下手边的工作，起身前去查看时，吕薇霓忙道：“可以帮我跟她要一张签名照吗？我超喜欢她的！”<br/><br/>　　蔺韶华回头瞪她，吕薇霓双手合十，摆出乞求姿态，水眸闪亮亮，以唇语无声道：拜、托！<br/><br/>　　他当没看到，无情地转身走人。<br/><br/>　　走出办公室，事务所内人心浮动，大伙已被娇客的到来扰乱一池春水，无心工作。<br/><br/>　　人被请进接待室，身边围绕着一群不该在这里的闲杂人等，这个问她茶会不会太烫？那个问她咖啡喝不喝得惯？接着说你这次的古装扮相超美……<br/><br/>　　而那厢，则是发挥巨星风范，带着笑耐心聆听、优雅亲民。<br/><br/>　　他怎么不知道他们事务所原来有这么多名接待？<br/><br/>　　“小张，你茂全的的季报做好了吗？显铭，你手上那份对不上来的损益表数据，跟他们确认过了没？还有阿伟——”不等一一点名，其余人很有危机意识，立即快闪。<br/><br/>　　清完场，望向那笑吟吟喝咖啡的来客。<br/><br/>　　“你来这做什么？”<br/><br/>　　啧！又板起一张脸了，要不是在他员工身上有修补不少残破的自信心，还真会被他打击到。<br/><br/>　　“送东西来给你。”<br/><br/>　　指指搁在桌上那一大箱物品，蔺韶华打开纸箱，是那天录节目，他所挑拣的商品。</p>', 0, 0, '', '');
INSERT INTO `mac_art` (`art_id`, `type_id`, `type_id_1`, `group_id`, `art_name`, `art_sub`, `art_en`, `art_status`, `art_letter`, `art_color`, `art_from`, `art_author`, `art_tag`, `art_class`, `art_pic`, `art_pic_thumb`, `art_pic_slide`, `art_blurb`, `art_remarks`, `art_jumpurl`, `art_tpl`, `art_level`, `art_lock`, `art_up`, `art_down`, `art_hits`, `art_hits_day`, `art_hits_week`, `art_hits_month`, `art_time`, `art_time_add`, `art_time_hits`, `art_time_make`, `art_score`, `art_score_all`, `art_score_num`, `art_rel_art`, `art_rel_vod`, `art_title`, `art_note`, `art_content`, `art_points`, `art_points_detail`, `art_pwd`, `art_pwd_url`) VALUES
(17, 22, 21, 0, '美女不认帐', '', 'meinvburenzhang', 1, 'M', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/4a050035b77d27d3e604588596f148c1.jpg', '', '', 'ＹＡ！ＹＡ！她终于“提早”毕业了！今天是她在大学生涯里的最后一天，她再也不必忍受非得每天早上从温暖的被窝爬起来的痛苦，就为了赶第一堂魔鬼教授的课。　　从今天起，她自由了！可是！她在心里暗暗的叹口气，她', '佚名', '', '', 0, 0, 0, 0, 5, 1, 1, 2, 1553066969, 1553066497, 1566099835, 0, '0.0', 0, 0, '', '', '第1页$$$第2页$$$第3页', '1$$$2$$$3', '<p>ＹＡ！ＹＡ！她终于“提早”毕业了！今天是她在大学生涯里的最后一天，她再也不必忍受非得每天早上从温暖的被窝爬起来的痛苦，就为了赶第一堂魔鬼教授的课。<br/><br/>　　从今天起，她自由了！可是！她在心里暗暗的叹口气，她的毕业证书需要在两年后才能取得，谁叫冰雪聪明的她只以两年的时间就把四年的大学给修完，所以接下来的两年，她得好好思考，找个事情做，填充她空白的日子。<br/><br/>　　在认真思考后，她下了个决定！老爸承诺过她，只要她满二十岁，就不再限制她做任何事，就算彻夜不归，也不会阻止她了，所以她现在就要跟几位姐妹淘去夜店钓帅哥。<br/><br/>　　她出身于黑道世家，但是她不曾来过夜店，就连大声欢唱的场所，她也没踏进过，因为家里就设有大型的卡拉ＯＫ，设备恐怕比店家的还先进，实在是不需要花钱往外跑。<br/><br/>　　跟着几位几姐妹淘踏进夜店后，不需要十分钟，姐妹淘各寻得猎物，唯独她，冷场的坐在吧台，真是差别待遇。<br/><br/>　　先前也有好几名帅哥走过来与她搭讪，当她抬眼迎视，帅哥们个个像是看到鬼，立即打退堂鼓。<br/><br/>　　起初她还存在困惑，后来她猛然了解，全是因为她颈间这条项链，她老爸是纵横于黑白两道，能点水成冰、呼风唤雨的幕后主使者，威风的很，只要是有长眼睛的，看见她颈上所戴的项链，还有谁敢惹她，又不是不要命了。<br/><br/>　　所以呢？就算她落单，走在夜里，保证绝对的安全。<br/><br/>　　话说回来，她颈上所带的项链可说是她的保命符，这可是大有来历，这条项链是老爸送给老妈的定情之物，当初老爸为了追求老妈，可是吃了好几个闭门羹呢！<br/><br/>　　一名娇小甜美的女人，被堂堂的一名黑道老大看上，这是无比光荣的事，但老妈就是不领这个情，据说倒追老爸的女人也是不计其数，反正老爸最后是将老妈娶进门了，但这段追妻事件在道上倒是造成极大的轰动，也验证老爸不屈不饶的精神，就像打不死的蟑螂。<br/><br/>　　只是昨天晚上，老爸不知道做错了什么事，竟将美丽又大方的老妈给惹毛了，可怜的老爸，现在一定在客厅跪算盘赔罪。<br/><br/>　　可怜的黑道老大，既无法干下不法的勾当，只能想尽办法把不合法转为合法下，就连缴税也要诚实，这全归功于善良的老妈，温柔又大方的老妈最讨厌的就是不法勾当，所以老爸绝对不碰毒品，至于贩卖军火嘛……她就不得而知了。<br/><br/>　　没有帅哥敢来搭讪，心情郁郁的娃娃坐在吧台上，手里端着酒精饮料，看着姐妹淘们在舞池解放自己，大方接受异性的挑逗，然后成双成对的相邀上楼，做爱最爱做的事，这一幕，看在她眼里是既羡慕又妒忌。<br/><br/>　　罢了罢了，自己是什么身份，又有哪几个不要命的敢来招惹她，她自己最清楚。<br/><br/>　　放下酒杯，向酒保买单后便离开这种愈来愈无趣的场所，就在她走出酒吧，四台显眼的黑色轿车就停在对面，不入眼都难。<br/><br/>　　她正感疑惑之际，前后左右分别迎来四位人高马大的大汉，团团将她围住，用膝盖想也知道来者不善。<br/><br/>　　“小姐，请您上车。”娃娃听着对方用怪怪的腔调跟她说话，就知道对方是谁了，故意站着三七步，跩跩地回答，“如果我说不呢？”四名大汉刻不容缓的上前，意图相当明显。<br/><br/>　　娃娃见状，立即拍开其中一只朝她而来的大掌，怒斥，“放肆！我是你能碰的吗？”<br/><br/>　　四名大汉面面相觑，既不敢得罪她，又不能违背主人的意思，着实为难。<br/><br/>　　娃娃往后退一步，机伶的左右张望，想找机会逃脱。<br/><br/>　　“小姐，请您上车，朴先生在等你。”<br/><br/>　　娃娃双眼一翻，她就知道自己注定栽在这个男人手里，可是她又不甘心，凭什么自己要受他控制。<br/><br/>　　“朴先生说如果小姐不上车，那他会亲自下车来接您。”<br/><br/>　　娃娃听了之后，圆眸怒目，一脸咬牙切齿的表情。<br/><br/>　　“请小姐上车吧。”这一次是逃不掉了，伸头一刀，缩头也是一刀，娃娃抬起胸膛，反正她天不怕地不怕，她就不信对方敢把她碎尸万段，“我自己会走。”<br/><br/>　　“小姐，请。”娃娃来到黑色轿车，其中一名大汉要帮她开车门，还被她瞪了一眼，她从不需要别人帮她开车门，她又不是残废。<br/><br/>　　☆☆☆<br/><br/>　　娃娃自个儿打开车门，坐了进去，还很用力的把车门给甩上，然后挑衅地抬起下巴，对着坐在车内，一脸酷样的男人道：“说！你找我做什么？”<br/><br/>　　在她坐上车，司机便听从命令，缓缓往前驶，车子的平稳度连娃娃都没发觉，她现在的专注力全应付在朴熙军身上。朴熙军摘下脸上的墨镜，对娃娃露出淡淡的微笑，“恭禧你不需要再去学校了，接下来等领毕业证书就好了。”<br/><br/>　　“谢谢。”娃娃斜眼地瞧着他，不太相信他只是单纯的向她恭贺。<br/><br/>　　“接下来有想要考硕士了？有理想中的学校吗？”他关心的道。<br/><br/>　　“我不需要考硕士，自然会有学校找上我。”并非她自傲，以她优异的成绩，各大名校抢着要呢！<br/><br/>　　他知道她所言不假，她的确是个成绩优异的学生，课本上的知识，她几乎都装进脑袋里了。<br/><br/>　　“如果只是来跟我祝贺，我已经收到了，没有其它的事的话，那就拜拜了。”她记得他现在应该还在日本，怎么会出现在台湾？待会一定要拿笔记本出来瞧个仔细，看看是那里记错了。<br/><br/>　　“看你的样子，似乎不太欢迎我来看你。”笑眸里隐藏可怕冰点，令人不畏而寒。<br/><br/>　　“这……”娃娃机伶的打个冷颤，要不是看在他跟老爸有交情的份上，又与她沾上那么一丁点儿关系，她才不想接近他呢！只要跟他相处一秒，她就觉得浑身不对劲。<br/><br/>　　“嗯？”低沉的嗓音，带有那么点威胁。<br/><br/>　　“事情不是你想的那样嘛！”娃娃见风转舵，主动偎了过去，还露出最甜美的笑容，并且挽着他的手臂，水眸揪着他看，“你应该知道今天是人家二十岁生日吧！”<br/><br/>　　“二十岁生日？”她用力点头，她就知道他不会忘记这样重大的日子。<br/><br/>　　☆☆☆<br/><br/>　　若非她提醒，他险些就忘了今天是她的生日，以往她的生日都是有他陪伴的，这次也是一样。<br/><br/>　　“好嘛！你就让人家去嘛！我会早点回家的。”她看出他的正陷入沉思，或许他会答应也说不定。<br/><br/>　　“二十岁日是个很特别的日子。”他很赞同她的话。<br/><br/>　　“所以在这种重要的日子里，人家想和朋友去庆祝庆祝嘛！”她把下巴靠在他肩上，秋眸荡漾，小嘴微噘，“你不会不允许吧？”<br/><br/>　　朴熙军微笑，但，不语。<br/><br/>　　“别这样嘛！”她使出撒娇的功力，“二十岁的生日，一生才一次，你就让人家去嘛！”<br/><br/>　　“如果我说不呢？”<br/><br/>　　他的笑容有点欠扁，心高气傲的娃娃差点就出手了，但，她忍了下来，脸上又是堆满笑容，“亲爱的，你好讨厌喔！”<br/><br/>　　“你不就是讨厌我吗？”堆满笑容的娃娃顿时僵着脸，骂暗这个男人真没情趣，非要把场面搞得这么冷吗？<br/><br/>　　“你干嘛这么说嘛！”她放开他的手臂，委屈的道，装无辜她最会了。<br/><br/>　　“娃娃。”他覆上住她的手，沉稳的道：“我们的婚约是你自己选择的，我有给你时间考虑，你仍坚持你的选择，既然你选择了我，就不要后悔，现在才想退出，我是不可能答应你的。”<br/><br/>　　“我又没这么说。”她马上反驳，虽然事实上如他所言，一点也不假，但她也不能表现出来。<br/><br/>　　“有没有你心里最清楚。”<br/><br/>　　“我没有！”她死鸭子嘴硬。他揪了她一眼，没答话。<br/><br/>　　“喂！姓朴的，你不要太过份了，想跟我解除婚约就说一声，我又不会缠着你不放。”她是很想与他解除婚约，但死要面子的她偏不说，只能以行动表示，要是说出来了，那多没面子。</p>$$$<p>“我不会跟你解除婚约。”<br/><br/>　　“那你是什么意思！”她就是要跟他吵，吵到他自愿跟她解除婚约，那她就松口气了。<br/><br/>　　“娃娃，为什么我们就不能好好的谈一谈。”对她，他可是相当纵容，但耐性有限。<br/><br/>　　“我又没怎样！”他看了她一眼，最后只是叹了口气，无言。<br/><br/>　　“你！”娃娃鼓足双颊，她最讨厌他用这种态度对她，好似她只会无理取闹，可是事后想想，她好像真的在无理取闹。<br/><br/>　　娃娃非常泄气的坐在一旁，当初硬要他与她订婚确实为难了他，但他也没拒绝，现在想还给他自由，他却又不要，真搞不懂他。<br/><br/>　　“娃娃。”他轻唤她，再度牵起她的手。<br/><br/>　　“干嘛！”像是他的身上染有不冶之病，怕被感染，娃娃立即抽回她的手。<br/><br/>　　“我要回国了。”他不介意她的态度，反而深邃的凝视着她，好比在离别前，凝视最心爱的女人，想把她的容颜给记下。<br/><br/>　　“回国？”水眸充满疑惑，“你不是今天才抵达台湾？又要去哪里？”<br/><br/>　　“我要回韩国。”<br/><br/>　　“回韩国？”<br/><br/>　　“我母亲稍早通知我，说我祖父大寿，要我马上赶回去。”她差点忘了朴熙军的家族是很奇怪的，他的血统很复杂，祖父是韩国人，祖母是英国人，而父亲是台湾人，但母亲却是日本人，这到底是怎样的一个家族，而他又该是哪一国人，她也搞不清楚。<br/><br/>　　“你没有什么话要对我说吗？”他沉哑又带点磁性的嗓音，简直在诱惑她。<br/><br/>　　“就祝你一路顺风吧！”这是她唯一能想到的祝福。<br/><br/>　　“娃娃。”他带着几乎让人察觉不到的叹息声轻唤她的名。<br/><br/>　　“干嘛啦！”被他这声撩人呼唤，她都快坐不住了，整个人就像做了亏心事，恨不得逃离他远远的，害她不得不提高音量，掩饰自己的心虚。<br/><br/>　　“你怎么了？”他突然觉得她的举动很好笑，似别扭、又似躲避他，无形中流露出女孩子家的娇气，于是他主动靠近她一些，“是不是哪里不舒服？”<br/><br/>　　“才没有！”娃娃反驳的同时，挪动了臀部，与他保持距离。<br/><br/>　　朴熙军凝视她，淡笑不语。<br/><br/>　　“你看什么看！”最讨厌他那种既温柔，又欲要将她看穿的眸光，好像她在打什么主意，他都能轻而易举知道。他仍旧摇头轻笑。娃娃轻哼！把脸摆往另一旁。<br/><br/>　　她向来是什么人都不怕的，之前有人以色色的眼光看她，结果被她教训得跟猪头没两样，但相同的情况，只要遇上朴熙军，被他那种眸光给凝视住，她那股教训人的气势就会莫名消失，连双手都不知道要摆放在那儿，有够窘的！<br/><br/>　　朴熙军瞧了穿在她身上的衣服，娃娃装搭配白色窄裙，浪漫可爱，他不得不赞叹，“你这样的打扮，真可爱。”娃娃翻翻白眼，她已经二十岁了，应该说她漂亮，而不是可爱。<br/><br/>　　罢了！反正他是个外国人，能把中文说得这么流利，已经非常不简单了。<br/><br/>　　“那真是谢谢你的赞美了。”娃娃假假的对他一笑。<br/><br/>　　“为了庆祝你毕业，我有礼物要送给你，不知道你喜不喜欢？”<br/><br/>　　“要是我看不上眼，我可是会退还给你。”她的标准可是很高的。<br/><br/>　　“要是你不喜欢，丢掉也无所谓。”<br/><br/>　　第1章(2)<br/><br/>　　娃娃看他说得这么真诚，勉强接受，她伸出手，一副女王的态度，“拿来我看看。”<br/><br/>　　有礼物岂可不接受的道理，这是她的名言。<br/><br/>　　朴熙军并未拿出礼物，反而俯身，撩拨她额上的浏海，然后在她头上不足微道的小纸片，动作显示两人的亲昵，“沾到脏东西了。”娃娃瞪着他手上的那小纸片，心里实为不高兴，他是故意看她笑话吗？打从她坐进车人，他早该取下。<br/><br/>　　“这个，送给你。”朴熙军从西装口袋里取出一份精美的礼物，放到她手上。<br/><br/>　　“小气！”她非但不答谢，还骂道，但不收白不收。<br/><br/>　　☆☆☆<br/><br/>　　“不满意吗？”没错！她非常不满意。<br/><br/>　　“毕业礼物跟生日礼物怎么能算在一起，至少要准备两项才够诚意。”她指着手上的礼物叫道。<br/><br/>　　“是我疏忽了，我会补给你。”<br/><br/>　　“哪有人生日过了才再送礼物的，没诚意。”她就是刁钻，但见他眸光一黯，再不机伶的人也会自保，“不过看在你时间不足的份上，放你一马，下次记得补我了。”说穿了，她还是要礼物。<br/><br/>　　“你不打开来看看吗？”娃娃对这份礼物其实没什么太大的兴趣，心里这里头除了女生饰品，她倒想不出他会送什么东西给她。<br/><br/>　　当她以很不礼貌的动作拆开礼物，她微微惊讶，里面可是限量发行的巧克力，全球只有一百份，这下子，她真的不得不佩服他的巧思了。<br/><br/>　　“满意吗？”娃娃撇撇嘴，就算满意，她也不能说出来，“勉强可以接受。”她拿了一块丢进嘴里，她就是无法抗拒这种甜甜的滋味。<br/><br/>　　“好吃吗？”<br/><br/>　　“还不错。”她又拿了一块巧克力送进嘴里，甜而不腻，符合她的口味。<br/><br/>　　“你喜欢就好。”<br/><br/>　　“对了，你几点要飞回韩国？”别说她不关心他，至少她有问。<br/><br/>　　“明天早上的飞机。”<br/><br/>　　“这么匆忙！”她差点被巧克力给噎到。<br/><br/>　　“嗯。”<br/><br/>　　“既然这样的话……”她转动灵巧的水眸，又是甜甜的一笑，“那我不担误你时间了，谢谢你的礼物，我要走了，你也赶快回家休息吧。”<br/><br/>　　时间也差不多了，她也该闪人了，里头只放了四颗巧克力，剩下两颗带回去孝敬老爸老妈。<br/><br/>　　“这么急着想离开我吗？”他倾身，握住她欲开车门的手，轻松的阻止她离去。<br/><br/>　　娃娃侧颜，警觉性的看着他脸上的微笑，笑里藏刀用在他身上，最适合不过了。<br/><br/>　　“这么急着想离开我？”黑瞳隐约透露出恐怖。<br/><br/>　　“不、不是啦！我是怕你过度操劳嘛！”她在强颜欢笑，“你一下飞机，连休息都没有就来找我，你瞧你……”她指着他的眉宇，“你明明就很累了，黑眼圈都出来了，所以你还是赶快回家睡觉吧！”<br/><br/>　　“娃娃。”<br/><br/>　　“我在这啊。”她几乎是颤抖抖的回答。<br/><br/>　　“你真令人头痛。”他又靠近她一些，只差没有将她完全拥在怀里。<br/><br/>　　“不会啊，我的头不会痛啊！”说话就说话，有需要这么靠近她吗？他的胸膛几乎要贴住她的背，她可以感觉到从他身上的温度，那种感觉真叫人恐惧。<br/><br/>　　“别跟我这么疏远，我只是来跟你道声恭禧而已。”<br/><br/>　　“你已经祝贺完毕了。”在某些事上，她可是很容易心满意足的，所谓礼轻情义重，就算是口头上的一句小小恭禧，她也会很开心的。<br/><br/>　　“以我们的关系，我的祝贺不会只是这样。”他意有所指。<br/><br/>　　“你的礼物我已经收到了，这样就行了，谢谢你的好意啦！”他不急，她可是很急！她可是巴不得他赶快消失在她面前。<br/><br/>　　“娃娃，我们……”知道他要说什么，娃娃迅速抽回被他握在掌心上的的手，同时往车门旁移动，就为了拉开两人之间的距离。<br/><br/>　　“娃娃？”在深情的眸光底处透露着一丝恐惧。<br/><br/>　　“其实你不用担心我啦！我刚刚打电话给我老爸了，待会儿我老爸就会来接我，你还是赶你的飞机要紧吧！”她开始语无伦次了。<br/><br/>　　真是恐怖到极点，她最害怕他那种眼神了，她好想捂住双眼，假装自己什么都看不见。<br/><br/>　　“娃娃，说谎鼻子会变长，你不知道吗？”他带着溺爱的语意，轻捏她的鼻子。<br/><br/>　　“我才没有说谎，我老爸他真的会来接我。”她拍开他的手，揉着自己的鼻子，她就知道他是故意的，下手这么重，不用照镜子也知道她的鼻头被他捏红了。<br/><br/>　　朴熙军压低头颅，亲密地抵住她的额际，闭上多情的眸光，语意里充满宠溺，“你骗不了我的。”<br/><br/>　　他比她的父母还了解她，也只有他能制得住她，这是她父亲亲口对他所言。<br/><br/>　　“我是说真的！”娃娃气闷极了，又想对她毛手毛脚，她立即将双手抵在他的胸口，想推开他，熟料，他那精锐的眸光一迸裂，着实将她吓愣，定在原地，让她连说话的音量都变小了，“……我老爸真的会来接我……”</p>$$$<p>“你父亲不会来了。”他决定戳破她的谎言。<br/><br/>　　“你又知道了。”气势矮人一截，她连说话都像个小媳妇，嚅嚅的道。<br/><br/>　　“我已向你父亲通过电话，我确信他不会来接你。”他很享受与她单独在一块的时间，两人世界。<br/><br/>　　娃娃十足的泄气，原来他有报备过的，不过当务之急的是想办法让朴熙军离开她身上。<br/><br/>　　“喂。”她伸出食指，轻戳他的胸膛，轻声的唤他。<br/><br/>　　“嗯？”他凑在她颈间，嗅着从她身上传来的清新味道，他非常喜欢。<br/><br/>　　“你可不可以别这么靠近我？男女授受不亲，这句话你没听过吗？”属于他的味道，浓烈地从他身上散发出来，他明明就没有擦古龙水，但就是会造成她呼吸困难，再这样下去，她会缺氧而死。<br/><br/>　　男女授受不亲？这句话只想让他仰头大笑，这句话应该是用在他身上才对，当初她用尽心计，甚至以坦诚相见的计策，迫使他不得不与她订婚。当然，他对她也有情爱存在，所以他并未拒绝这桩婚约，但她那种令人抓不住的顽皮个性，让他愈想牢牢抓住她，她就愈想脱逃，导致他不得不像只野兽，紧咬口中的猎物，就怕被她脱逃。<br/><br/>　　☆☆☆<br/><br/>　　“你、你不要这样，很可怕耶！”老是盯着她看，总有一天，她会被吓死的。<br/><br/>　　“我跟你是什么关系，你最清楚。”他轻抚她雪白的颈子，细嫩的肌肤，真令人爱不释手。<br/><br/>　　“虽……虽然是那种关系，你也不需要靠这么近嘛！”她好有压力耶！<br/><br/>　　“你不喜欢我这样靠近你吗？嗯？”他故意凑在她的颈间，伸出湿润的舌尖，在她颈间舔着，像是品尝美味的食物，悠缓且带着一抹挑逗，“我记得你以前最喜欢我这样对你，你说过，你喜欢的。”<br/><br/>　　热气呼在她的细颈，那是一种很奇怪的感觉，如果可以的话，她想叫他停止，只是在她想开口时，她的唇被他堵上了。<br/><br/>　　一种醉心的索物即将开始。被帅哥亲吻是每个人梦寐以求的，除了朴熙军，但她若是扁嘴，杜绝他将舌头探入，他真的会用强的，到时候就会演变成一发不可收拾，又狂野的索吻了，某些时候她并不讨厌他的亲吻，反倒是他的温柔会让她掉进浓情至化不开的亲昵，就像要把心掏出来似的。<br/><br/>　　辗转又缠绵的吻总是特别久，久到娃娃发出闷吟的抗议声，但这些声音全被他吞下肚，换得更深初的吻。好不容易，他停止吻她，她才有机会开口：“其实你算得上是我老爸最重要的客人，而我跟你只是一种美丽的误会，你最清楚不过了。”<br/><br/>　　“美丽的误会？”朴熙军从喉咙里发出不认同的轻笑，“没有交集会让你对我产生兴趣？”<br/><br/>　　娃娃想反驳，小嘴才张开，就被他的话活活给堵住，找不到任何一句来反击。<br/><br/>　　“敢在我酒里下药，甚至把我带上床。”他对她大胆行径可是相当佩服，“要不是我全力配合，你会达到目的吗？”<br/><br/>　　娃娃再度被击得无话可说，她又怎么会知道一般的***，迷不了朴熙军，况且任何人见到美丽的事物都会想接近，连她也不例外嘛！直到她见识到他残酷的另一面，他在她心中的完美形象，如同裂掉的镜子，片片掉落在地，她可不想成为他底下的残酷受害者。<br/><br/>　　“别跟我拗脾气，我只是想看看你而已。”他的眸光有着无此尽的柔情，大掌万分怜惜的抚上她的脸蛋，缓慢且沉哑地道：“只是看看你而已。”<br/><br/>　　“现在你已经看到了。”她不得不承认他是个很有魅力的男人，只可惜，她认清了一点，他始终不是她的菜。<br/><br/>　　“我是已经看到你了，但，这不够。”他再次欺压她，笑容也挂回他的脸上，这次有着危险的意味。<br/><br/>　　“你想做什么？”她绷紧全身，一个冷血惯性的人可不代表在最后关头，他会大发慈悲。<br/><br/>　　“你是装傻，还是在逃避？”他温柔地抬起她的下颚，与他直视，沉哑的询问声简直要撞进她的心里深处。<br/><br/>　　“我不知道你在说什么啦！”娃娃心慌慌地回避他炽热的眸光。<br/><br/>　　朴熙军眸光一暗，看不出是失望，还是生气。“娃娃。”他轻唤她的名。<br/><br/>　　“我还小，什么事都不知道，不要老是找上我嘛！”救命呀！谁来救救她呀！<br/><br/>　　娃娃开始耍赖了。这个时候，二十岁对她来说，已不具任何意义，因为她只想装成什么都不懂的稚龄儿童。这次朴熙军眸光不只是灰暗，还隐约透露着恐怖，在不言语的气氛之下，娃娃可以感觉他的身上正流窜着强势的气流，逐渐形成凶猛霸道的龙卷风，她再不逃离的话，就要粉身碎骨了。<br/><br/>　　娃娃努力堆起笑容，推开他的举动却是惶惶不安，逃命要紧！在她试图打开车门，这才发现，车门怎么打不开了！糟糕！大难临头窜入娃娃的脑海里，身后又传来冷冰冰的嗓音，直让她头皮发麻。<br/><br/>　　“我答应你父亲，当你满二十岁时，我会来接你，而你也承诺我，你会等到那天的来临，我浪费了这么久的时间等你，换来的竟是你一昧的想要逃离我。”他冷冷的道。<br/><br/>　　娃娃背着他，小脸皱成一团，当初她可是怀着少女的梦想，打从心里希望自己成为他的女人，谁知道围绕在他身边的女人多得像苍蝇一样，赶也赶不走，她是个有洁癖的人，这样的男人，她宁可不要。<br/><br/>　　“娃娃，你说，我该如何处置你？”<br/><br/>　　“有吗？呵呵！我怎么记不起来。”娃娃仍旧装傻，双手也正努力该怎么把车门打开。<br/><br/>　　“否认是吗？”娃娃全身僵硬，身后那一道柔和的嗓音藏着要她好看的意思，凉意顿时窜上脊椎，在她机伶的打个冷颤，背部即被温厚的胸膛给贴着，没有她想要的安全感与温暖，只有颤栗的恐惧，她的心跳狂乱加速，要是让他知道她从一开始就只是在跟他打游击战，尸骨无存恐怕会是她的写照。<br/><br/>　　在无可退路，前方又有敌军等她受死的情况下，只好抱着投诚的心态，向敌方求饶，朴熙军一直是疼爱她的，她相信只要她搂着他的手臂，向他撒娇，他会饶她一命的。<br/><br/>　　但幻想总是跟现实有所误差，当她作好心理准备，堆起甜甜的假笑容，想向他求饶时，昂硕的体格却压低下来，强的低气压笼罩她全身，再怎么笨的人也知道朴熙军在发怒。<br/><br/>　　此刻的她早就把求饶抛到脑后，用最原始的方法，开口大喊救命，他却直接堵住她的唇，后脑勺也被他的大掌给固定住，不请自来的舌尖狠狠地缠住她，再熟悉不过的淡淡烟草味渗入她的口中。<br/><br/>　　她瞠大眼，愣了两秒，在听见他得意的笑容，她才恍然得知自己被强吻了，被强迫的感觉真的很不好，尤其是被强吻。<br/><br/>　　娃娃用尽所有的力气，在他身上又槌又打的，却只换得他更强硬的钳制，贴在她背后的大掌，一使力，原本陷入皮椅的娇柔身躯，被揉进如墙铜般的胸膛里，这几乎要让她喘不过气，而剩下的巧克力被撒在车底板。好浪费啊！限量发行的。<br/><br/></p><p><br/></p><p>　　这绝对是法国式的接吻！<br/><br/>　　朴熙军就像要吞掉她似的，用尽所有吸吮啃咬的方式，吻得她的双唇发麻又紧紧缠住她的舌头不放，好像原本是属于她身上的一部份，已经变成是他的所有物，不再是她的了。<br/><br/>　　“唔……”这场唇舌交战似乎没有尽头，她努力闪躲他的攻势，他却像牛皮糖一样，紧黏着她不放，连让她开口说话的机会都没有，当她好不容易可以发出声音求饶，又被霸道的他强行吞没。<br/><br/>　　她的双手不停的挥动，仅以残余呜咽声作为抗议，不满足的他又堵得她发不出声音，捶打他的双手也转由紧抓住他的后衣领不放。<br/><br/>　　娃娃圆眸瞪大，他分明是要堵死她，只要听见她还有能力发出声音，他猛烈的攻势是一波接着一波，导致她只要寻得一丝空隙，她一定是张大嘴巴呼吸，避免缺氧，却让他吻得更狂、更烈。</p>', 0, 0, '', ''),
(18, 22, 21, 0, '离婚恋人', '', 'lihunlianren', 1, 'L', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/664e45dba98e7dc0fb39ff72da26eb5c.jpg', '', '', '看着鲜红的血从雪白的大腿流下，然后滴落在浴室的地板上，　　她顿时感到全身无力，又惊又怕地抱着自己的肚子……　　当五年前的痛楚回忆，如排山倒海般袭来时，金荷蓁再也忍不住，　　用力推开眼前这个令无数女性疯', '佚名', '', '', 0, 0, 0, 0, 5, 1, 2, 1, 1553066982, 1553066671, 1564640154, 0, '0.0', 0, 0, '', '', '', '', '<p>看着鲜红的血从雪白的大腿流下，然后滴落在浴室的地板上，<br/>　　她顿时感到全身无力，又惊又怕地抱着自己的肚子……<br/>　　当五年前的痛楚回忆，如排山倒海般袭来时，金荷蓁再也忍不住，<br/>　　用力推开眼前这个令无数女性疯狂的亚洲巨星──权玄宽，<br/>　　柔美的小脸上，写满了“生人勿近”的坚毅与果决。<br/>　　没错，在她尝尽孤寂、无助，甚至是未出生的小孩时……<br/>　　她就决定划清两人的关系，从此不想再与他有任何的瓜葛。<br/>　　但是，他却想都没想地就抓住她，<br/>　　因为再度的相遇，让原本以为结束的缘分在刹那间被牵起，<br/>　　当初为了自己的前途，他牺牲了她，<br/>　　而如今，在他踏上成功的颠峰时，他终于尝到苦果──<br/>　　尽管拥有了全世界，但失去了最爱的人，心是空的。<br/>　　他认为这是上天给他的旨意，他不愿再放过她，<br/>　　这一次，他决定不择手段地追回她……</p>', 0, 0, '', ''),
(19, 22, 21, 0, '医家小才女', '', 'yijiaxiaocainv', 1, 'Y', '', '', '', '', '', 'http://vhd101v10.ymyuanma.com/upload/vod/20181121-1/8681b0ae312f7ad5a6be661ea2dffa1c.jpg', '', '', '穿到古代成了苏映宁，人人见了她都要赞一声可爱聪慧，她是爹娘和三个哥哥的掌中宝，不只有医术这个正经本事傍身，丹青的造诣更是惊人，画美男写真和风景图替她赚进不少银子，偏偏这样有滋有味的简单生活被貌美的敬国', '佚名', '', '', 0, 0, 0, 0, 18, 1, 1, 2, 1553066994, 1553066734, 1564943652, 0, '0.0', 0, 0, '', '', '', '', '<p>穿到古代成了苏映宁，人人见了她都要赞一声可爱聪慧，<br/>她是爹娘和三个哥哥的掌中宝，不只有医术这个正经本事傍身，<br/>丹青的造诣更是惊人，画美男写真和风景图替她赚进不少银子，<br/>偏偏这样有滋有味的简单生活被貌美的敬国公世子给打破了，<br/>他不但打探她的隐私，甚至从她那「单蠢」的三哥哥下手，将她拐去京城，<br/>果然跟权贵人家有牵连准没好事，生活处处有危险，<br/>又是遇见刺客伤人，连她暂住的宅子也被火烧，<br/>不过这些意外也让她看到了他的真心，他总是第一时间关心她的安危，<br/>摸清她的喜好讨她欢心，连她最爱的家人他都替他们想好了往后的安排，<br/>老实说她对他动了心，但她仍有所顾虑，像是两人的身分差距……</p>', 0, 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `mac_card`
--

CREATE TABLE IF NOT EXISTS `mac_card` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_no` varchar(16) NOT NULL DEFAULT '',
  `card_pwd` varchar(8) NOT NULL DEFAULT '',
  `card_money` smallint(6) unsigned NOT NULL DEFAULT '0',
  `card_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `card_use_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `card_sale_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `card_add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `card_use_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`card_id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `card_add_time` (`card_add_time`) USING BTREE,
  KEY `card_use_time` (`card_use_time`) USING BTREE,
  KEY `card_no` (`card_no`),
  KEY `card_pwd` (`card_pwd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_cash`
--

CREATE TABLE IF NOT EXISTS `mac_cash` (
  `cash_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cash_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cash_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `cash_money` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `cash_bank_name` varchar(60) NOT NULL DEFAULT '',
  `cash_bank_no` varchar(30) NOT NULL DEFAULT '',
  `cash_payee_name` varchar(30) NOT NULL DEFAULT '',
  `cash_time` int(10) unsigned NOT NULL DEFAULT '0',
  `cash_time_audit` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cash_id`),
  KEY `user_id` (`user_id`),
  KEY `cash_status` (`cash_status`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_cj_content`
--

CREATE TABLE IF NOT EXISTS `mac_cj_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nodeid` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `url` char(255) NOT NULL,
  `title` char(100) NOT NULL,
  `data` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nodeid` (`nodeid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_cj_history`
--

CREATE TABLE IF NOT EXISTS `mac_cj_history` (
  `md5` char(32) NOT NULL,
  PRIMARY KEY (`md5`),
  KEY `md5` (`md5`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mac_cj_node`
--

CREATE TABLE IF NOT EXISTS `mac_cj_node` (
  `nodeid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `lastdate` int(10) unsigned NOT NULL DEFAULT '0',
  `sourcecharset` varchar(8) NOT NULL,
  `sourcetype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `urlpage` text NOT NULL,
  `pagesize_start` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pagesize_end` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `page_base` char(255) NOT NULL,
  `par_num` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `url_contain` char(100) NOT NULL,
  `url_except` char(100) NOT NULL,
  `url_start` char(100) NOT NULL DEFAULT '',
  `url_end` char(100) NOT NULL DEFAULT '',
  `title_rule` char(100) NOT NULL,
  `title_html_rule` text NOT NULL,
  `type_rule` char(100) NOT NULL,
  `type_html_rule` text NOT NULL,
  `content_rule` char(100) NOT NULL,
  `content_html_rule` text NOT NULL,
  `content_page_start` char(100) NOT NULL,
  `content_page_end` char(100) NOT NULL,
  `content_page_rule` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content_page` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content_nextpage` char(100) NOT NULL,
  `down_attachment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `watermark` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `coll_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `customize_config` text NOT NULL,
  `program_config` text NOT NULL,
  `mid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`nodeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_collect`
--

CREATE TABLE IF NOT EXISTS `mac_collect` (
  `collect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collect_name` varchar(30) NOT NULL DEFAULT '',
  `collect_url` varchar(255) NOT NULL DEFAULT '',
  `collect_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `collect_mid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `collect_appid` varchar(30) NOT NULL DEFAULT '',
  `collect_appkey` varchar(30) NOT NULL DEFAULT '',
  `collect_param` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`collect_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_comment`
--

CREATE TABLE IF NOT EXISTS `mac_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_mid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `comment_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `comment_name` varchar(60) NOT NULL DEFAULT '',
  `comment_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_time` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_content` varchar(255) NOT NULL DEFAULT '',
  `comment_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_reply` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_report` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `comment_mid` (`comment_mid`) USING BTREE,
  KEY `comment_rid` (`comment_rid`) USING BTREE,
  KEY `comment_time` (`comment_time`) USING BTREE,
  KEY `comment_pid` (`comment_pid`),
  KEY `user_id` (`user_id`),
  KEY `comment_reply` (`comment_reply`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_gbook`
--

CREATE TABLE IF NOT EXISTS `mac_gbook` (
  `gbook_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gbook_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `gbook_name` varchar(60) NOT NULL DEFAULT '',
  `gbook_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_time` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_reply_time` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_content` varchar(255) NOT NULL DEFAULT '',
  `gbook_reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`gbook_id`),
  KEY `gbook_rid` (`gbook_rid`) USING BTREE,
  KEY `gbook_time` (`gbook_time`) USING BTREE,
  KEY `gbook_reply_time` (`gbook_reply_time`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `gbook_reply` (`gbook_reply`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_group`
--

CREATE TABLE IF NOT EXISTS `mac_group` (
  `group_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(30) NOT NULL DEFAULT '',
  `group_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `group_type` varchar(255) NOT NULL DEFAULT '',
  `group_popedom` text NOT NULL,
  `group_points_day` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_points_week` smallint(6) NOT NULL DEFAULT '0',
  `group_points_month` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_points_year` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_points_free` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`),
  KEY `group_status` (`group_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `mac_group`
--

INSERT INTO `mac_group` (`group_id`, `group_name`, `group_status`, `group_type`, `group_popedom`, `group_points_day`, `group_points_week`, `group_points_month`, `group_points_year`, `group_points_free`) VALUES
(1, '游客', 1, ',1,2,3,4,5,6,7,8,20,9,10,11,12,13,21,22,23,24,25,', '{"1":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"2":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"3":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"4":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"5":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"6":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"7":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"8":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"20":{"1":"1","2":"2"},"9":{"1":"1","2":"2"},"10":{"1":"1","2":"2"},"11":{"1":"1","2":"2"},"12":{"1":"1","2":"2"},"13":{"1":"1","2":"2"},"21":{"1":"1","2":"2"},"22":{"1":"1","2":"2"},"23":{"1":"1","2":"2"},"24":{"1":"1","2":"2"},"25":{"1":"1","2":"2"}}', 0, 0, 0, 0, 0),
(2, '默认会员', 1, ',1,2,3,4,5,6,7,8,20,9,10,11,12,13,21,22,23,24,25,', '{"1":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"2":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"3":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"4":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"5":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"6":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"7":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"8":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"20":{"1":"1","2":"2"},"9":{"1":"1","2":"2"},"10":{"1":"1","2":"2"},"11":{"1":"1","2":"2"},"12":{"1":"1","2":"2"},"13":{"1":"1","2":"2"},"21":{"1":"1","2":"2"},"22":{"1":"1","2":"2"},"23":{"1":"1","2":"2"},"24":{"1":"1","2":"2"},"25":{"1":"1","2":"2"}}', 0, 0, 0, 0, 0),
(3, 'VIP会员', 1, ',1,2,3,4,5,6,7,8,20,9,10,11,12,13,21,22,23,24,25,', '{"1":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"2":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"3":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"4":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"5":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"6":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"7":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"8":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"20":{"1":"1","2":"2"},"9":{"1":"1","2":"2"},"10":{"1":"1","2":"2"},"11":{"1":"1","2":"2"},"12":{"1":"1","2":"2"},"13":{"1":"1","2":"2"},"21":{"1":"1","2":"2"},"22":{"1":"1","2":"2"},"23":{"1":"1","2":"2"},"24":{"1":"1","2":"2"},"25":{"1":"1","2":"2"}}', 10, 70, 300, 3600, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mac_link`
--

CREATE TABLE IF NOT EXISTS `mac_link` (
  `link_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `link_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_name` varchar(60) NOT NULL DEFAULT '',
  `link_sort` smallint(6) NOT NULL DEFAULT '0',
  `link_add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `link_time` int(10) unsigned NOT NULL DEFAULT '0',
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_logo` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_sort` (`link_sort`) USING BTREE,
  KEY `link_type` (`link_type`) USING BTREE,
  KEY `link_add_time` (`link_add_time`),
  KEY `link_time` (`link_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `mac_link`
--

INSERT INTO `mac_link` (`link_id`, `link_type`, `link_name`, `link_sort`, `link_add_time`, `link_time`, `link_url`, `link_logo`) VALUES
(2, 0, '景宏源码', 0, 1563688002, 1563688002, 'https://jsui.cn', '');

-- --------------------------------------------------------

--
-- 表的结构 `mac_msg`
--

CREATE TABLE IF NOT EXISTS `mac_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `msg_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `msg_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `msg_to` varchar(30) NOT NULL DEFAULT '',
  `msg_code` varchar(10) NOT NULL DEFAULT '',
  `msg_content` varchar(255) NOT NULL DEFAULT '',
  `msg_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `msg_code` (`msg_code`),
  KEY `msg_time` (`msg_time`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_order`
--

CREATE TABLE IF NOT EXISTS `mac_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `order_code` varchar(30) NOT NULL DEFAULT '',
  `order_price` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `order_time` int(10) unsigned NOT NULL DEFAULT '0',
  `order_points` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `order_pay_type` varchar(10) NOT NULL DEFAULT '',
  `order_pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  `order_remarks` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`order_id`),
  KEY `order_code` (`order_code`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `order_time` (`order_time`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `mac_order`
--

INSERT INTO `mac_order` (`order_id`, `user_id`, `order_status`, `order_code`, `order_price`, `order_time`, `order_points`, `order_pay_type`, `order_pay_time`, `order_remarks`) VALUES
(1, 3, 0, 'PAY20190717000925232705', '10.00', 1563293365, 10, '', 0, ''),
(2, 6, 0, 'PAY20190724100823628297', '10.00', 1563934103, 10, '', 0, ''),
(3, 8, 0, 'PAY20190727212010478015', '10.00', 1564233610, 10, '', 0, ''),
(4, 10, 0, 'PAY20190730170513344571', '10.00', 1564477513, 10, '', 0, ''),
(5, 10, 0, 'PAY20190730170555806456', '10.00', 1564477555, 10, '', 0, ''),
(6, 11, 0, 'PAY20190802032634329548', '10.00', 1564687594, 10, '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `mac_plog`
--

CREATE TABLE IF NOT EXISTS `mac_plog` (
  `plog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_1` int(10) NOT NULL DEFAULT '0',
  `plog_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `plog_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `plog_time` int(10) unsigned NOT NULL DEFAULT '0',
  `plog_remarks` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`plog_id`),
  KEY `user_id` (`user_id`),
  KEY `plog_type` (`plog_type`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `mac_plog`
--

INSERT INTO `mac_plog` (`plog_id`, `user_id`, `user_id_1`, `plog_type`, `plog_points`, `plog_time`, `plog_remarks`) VALUES
(1, 10, 0, 7, 10, 1564477461, '');

-- --------------------------------------------------------

--
-- 表的结构 `mac_role`
--

CREATE TABLE IF NOT EXISTS `mac_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `role_name` varchar(255) NOT NULL DEFAULT '',
  `role_en` varchar(255) NOT NULL DEFAULT '',
  `role_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_letter` char(1) NOT NULL DEFAULT '',
  `role_color` varchar(6) NOT NULL DEFAULT '',
  `role_actor` varchar(255) NOT NULL DEFAULT '',
  `role_remarks` varchar(100) NOT NULL DEFAULT '',
  `role_pic` varchar(255) NOT NULL DEFAULT '',
  `role_sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `role_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_time` int(10) unsigned NOT NULL DEFAULT '0',
  `role_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `role_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `role_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `role_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `role_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_score_num` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `role_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_tpl` varchar(30) NOT NULL DEFAULT '',
  `role_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `role_content` text NOT NULL,
  PRIMARY KEY (`role_id`),
  KEY `role_rid` (`role_rid`),
  KEY `role_name` (`role_name`),
  KEY `role_en` (`role_en`),
  KEY `role_letter` (`role_letter`),
  KEY `role_actor` (`role_actor`),
  KEY `role_level` (`role_level`),
  KEY `role_time` (`role_time`),
  KEY `role_time_add` (`role_time_add`),
  KEY `role_score` (`role_score`),
  KEY `role_score_all` (`role_score_all`),
  KEY `role_score_num` (`role_score_num`),
  KEY `role_up` (`role_up`),
  KEY `role_down` (`role_down`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_topic`
--

CREATE TABLE IF NOT EXISTS `mac_topic` (
  `topic_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `topic_name` varchar(255) NOT NULL DEFAULT '',
  `topic_en` varchar(255) NOT NULL DEFAULT '',
  `topic_sub` varchar(255) NOT NULL DEFAULT '',
  `topic_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `topic_sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `topic_letter` char(1) NOT NULL DEFAULT '',
  `topic_color` varchar(6) NOT NULL DEFAULT '',
  `topic_tpl` varchar(30) NOT NULL DEFAULT '',
  `topic_type` varchar(255) NOT NULL DEFAULT '',
  `topic_pic` varchar(255) NOT NULL DEFAULT '',
  `topic_pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `topic_pic_slide` varchar(255) NOT NULL DEFAULT '',
  `topic_key` varchar(255) NOT NULL DEFAULT '',
  `topic_des` varchar(255) NOT NULL DEFAULT '',
  `topic_title` varchar(255) NOT NULL DEFAULT '',
  `topic_blurb` varchar(255) NOT NULL DEFAULT '',
  `topic_remarks` varchar(100) NOT NULL DEFAULT '',
  `topic_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `topic_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `topic_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_score_num` smallint(6) unsigned NOT NULL DEFAULT '0',
  `topic_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_time` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_tag` varchar(255) NOT NULL DEFAULT '',
  `topic_rel_vod` text,
  `topic_rel_art` text,
  `topic_content` text,
  `topic_extend` text,
  PRIMARY KEY (`topic_id`),
  KEY `topic_sort` (`topic_sort`) USING BTREE,
  KEY `topic_level` (`topic_level`) USING BTREE,
  KEY `topic_score` (`topic_score`) USING BTREE,
  KEY `topic_score_all` (`topic_score_all`) USING BTREE,
  KEY `topic_score_num` (`topic_score_num`) USING BTREE,
  KEY `topic_hits` (`topic_hits`) USING BTREE,
  KEY `topic_hits_day` (`topic_hits_day`) USING BTREE,
  KEY `topic_hits_week` (`topic_hits_week`) USING BTREE,
  KEY `topic_hits_month` (`topic_hits_month`) USING BTREE,
  KEY `topic_time_add` (`topic_time_add`) USING BTREE,
  KEY `topic_time` (`topic_time`) USING BTREE,
  KEY `topic_time_hits` (`topic_time_hits`) USING BTREE,
  KEY `topic_name` (`topic_name`),
  KEY `topic_en` (`topic_en`),
  KEY `topic_up` (`topic_up`),
  KEY `topic_down` (`topic_down`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `mac_topic`
--

INSERT INTO `mac_topic` (`topic_id`, `topic_name`, `topic_en`, `topic_sub`, `topic_status`, `topic_sort`, `topic_letter`, `topic_color`, `topic_tpl`, `topic_type`, `topic_pic`, `topic_pic_thumb`, `topic_pic_slide`, `topic_key`, `topic_des`, `topic_title`, `topic_blurb`, `topic_remarks`, `topic_level`, `topic_up`, `topic_down`, `topic_score`, `topic_score_all`, `topic_score_num`, `topic_hits`, `topic_hits_day`, `topic_hits_week`, `topic_hits_month`, `topic_time`, `topic_time_add`, `topic_time_hits`, `topic_time_make`, `topic_tag`, `topic_rel_vod`, `topic_rel_art`, `topic_content`, `topic_extend`) VALUES
(1, '学生', 'mingxinzhubo', '', 1, 0, '', '', 'detail.html', '', 'upload/topic/20190715-1/91781c14f2f1c406e22b87dc3605c29e.jpg', '', '', '', '', '', '', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1563679653, 1541159283, 0, 0, '学生', '', '', '', ''),
(2, '御女', 'wanghongzhubo', '', 1, 0, '', '', 'detail.html', '', 'upload/topic/20190715-1/ae67d2bf8404888d660fee5eb214f73e.jpg', '', '', '', '', '', '', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1563679704, 1541161900, 0, 0, '御女', '', '', '', ''),
(3, '中文', 'meinvzhubo', '', 1, 0, '', '', 'detail.html', '', 'upload/topic/20190715-1/3fff42f00649bd6c19f874865149bc2c.jpg', '', '', '', '', '', '', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1563679750, 1541162430, 0, 0, '中文', '', '', '', ''),
(4, '欧美', 'youxizhubo', '', 1, 0, '', '', 'detail.html', '', 'upload/topic/20190715-1/3684a90a5807717dba8be010c3299c00.jpg', '', '', '', '', '', '', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1563679780, 1541163244, 0, 0, '欧美', '', '', '', ''),
(5, 'VIP专区', 'vipzhuanqu', '', 1, 0, '', '', 'detail.html', '', 'upload/topic/20190715-1/e7e2976a278711b4b8902579453ec3ea.jpg', '', '', '', '', '', '', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1563679817, 1541163279, 0, 0, 'VIP专区', '', '', '', ''),
(6, '国产', 'remenzhubo', '', 1, 0, '', '', 'detail.html', '', 'upload/topic/20190715-1/904927c240eb2a56dfb61904c2efddcc.jpg', '', '', '', '', '', '', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1563679852, 1541163715, 0, 0, '国产', '', '', '', ''),
(7, '日韩', 'changgezhubo', '', 1, 0, '', '', 'detail.html', '', 'upload/topic/20190715-1/13ce602ffd58ad8183dc2e9c2db119c7.jpg', '', '', '', '', '', '', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1563679875, 1541164644, 0, 0, '日韩', '', '', '', ''),
(8, '亚洲', 'shishangzhubo', '', 1, 0, '', '', 'detail.html', '', 'upload/topic/20190715-1/51000081c981ce41388ab5432a90e05b.jpg', '', '', '', '', '', '', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1563679899, 1541165920, 0, 0, '亚洲', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `mac_type`
--

CREATE TABLE IF NOT EXISTS `mac_type` (
  `type_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(60) NOT NULL DEFAULT '',
  `type_en` varchar(60) NOT NULL DEFAULT '',
  `type_sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_mid` smallint(6) unsigned NOT NULL DEFAULT '1',
  `type_pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `type_tpl` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_list` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_detail` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_play` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_down` varchar(30) NOT NULL DEFAULT '',
  `type_key` varchar(255) NOT NULL DEFAULT '',
  `type_des` varchar(255) NOT NULL DEFAULT '',
  `type_title` varchar(255) NOT NULL DEFAULT '',
  `type_union` varchar(255) NOT NULL DEFAULT '',
  `type_extend` text,
  PRIMARY KEY (`type_id`),
  KEY `type_sort` (`type_sort`) USING BTREE,
  KEY `type_pid` (`type_pid`) USING BTREE,
  KEY `type_name` (`type_name`),
  KEY `type_en` (`type_en`),
  KEY `type_mid` (`type_mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `mac_type`
--

INSERT INTO `mac_type` (`type_id`, `type_name`, `type_en`, `type_sort`, `type_mid`, `type_pid`, `type_status`, `type_tpl`, `type_tpl_list`, `type_tpl_detail`, `type_tpl_play`, `type_tpl_down`, `type_key`, `type_des`, `type_title`, `type_union`, `type_extend`) VALUES
(1, '亚洲', 'mingxing', 1, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '亚洲', '亚洲', '亚洲', '', '{"class":"\\u559c\\u5267,\\u7231\\u60c5,\\u6050\\u6016,\\u52a8\\u4f5c,\\u79d1\\u5e7b,\\u5267\\u60c5,\\u6218\\u4e89,\\u8b66\\u532a,\\u72af\\u7f6a,\\u52a8\\u753b,\\u5947\\u5e7b,\\u6b66\\u4fa0,\\u5192\\u9669,\\u67aa\\u6218,\\u6050\\u6016,\\u60ac\\u7591,\\u60ca\\u609a,\\u7ecf\\u5178,\\u9752\\u6625,\\u6587\\u827a,\\u5fae\\u7535\\u5f71,\\u53e4\\u88c5,\\u5386\\u53f2,\\u8fd0\\u52a8,\\u519c\\u6751,\\u513f\\u7ae5,\\u7f51\\u7edc\\u7535\\u5f71","area":"\\u5927\\u9646,\\u9999\\u6e2f,\\u53f0\\u6e7e,\\u7f8e\\u56fd,\\u6cd5\\u56fd,\\u82f1\\u56fd,\\u65e5\\u672c,\\u97e9\\u56fd,\\u5fb7\\u56fd,\\u6cf0\\u56fd,\\u5370\\u5ea6,\\u610f\\u5927\\u5229,\\u897f\\u73ed\\u7259,\\u52a0\\u62ff\\u5927,\\u5176\\u4ed6","lang":"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u6cd5\\u8bed,\\u5fb7\\u8bed,\\u5176\\u5b83","year":"2018,2017,2016,2015,2014,2013,2012,2011,2010","star":"\\u738b\\u5b9d\\u5f3a,\\u9ec4\\u6e24,\\u5468\\u8fc5,\\u5468\\u51ac\\u96e8,\\u8303\\u51b0\\u51b0,\\u9648\\u5b66\\u51ac,\\u9648\\u4f1f\\u9706,\\u90ed\\u91c7\\u6d01,\\u9093\\u8d85,\\u6210\\u9f99,\\u845b\\u4f18,\\u6797\\u6b63\\u82f1,\\u5f20\\u5bb6\\u8f89,\\u6881\\u671d\\u4f1f,\\u5f90\\u5ce5,\\u90d1\\u607a,\\u5434\\u5f66\\u7956,\\u5218\\u5fb7\\u534e,\\u5468\\u661f\\u9a70,\\u6797\\u9752\\u971e,\\u5468\\u6da6\\u53d1,\\u674e\\u8fde\\u6770,\\u7504\\u5b50\\u4e39,\\u53e4\\u5929\\u4e50,\\u6d2a\\u91d1\\u5b9d,\\u59da\\u6668,\\u502a\\u59ae,\\u9ec4\\u6653\\u660e,\\u5f6d\\u4e8e\\u664f,\\u6c64\\u552f,\\u9648\\u5c0f\\u6625","director":"\\u51af\\u5c0f\\u521a,\\u5f20\\u827a\\u8c0b,\\u5434\\u5b87\\u68ee,\\u9648\\u51ef\\u6b4c,\\u5f90\\u514b,\\u738b\\u5bb6\\u536b,\\u59dc\\u6587,\\u5468\\u661f\\u9a70,\\u674e\\u5b89","state":"\\u6b63\\u7247,\\u9884\\u544a\\u7247,\\u82b1\\u7d6e","version":"\\u9ad8\\u6e05\\u7248,\\u5267\\u573a\\u7248,\\u62a2\\u5148\\u7248,OVA,TV,\\u5f71\\u9662\\u7248"}'),
(2, '日韩', 'wanghong', 2, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '网红主播', '网红主播', '网红主播', '', '{"class":"\\u53e4\\u88c5,\\u6218\\u4e89,\\u9752\\u6625\\u5076\\u50cf,\\u559c\\u5267,\\u5bb6\\u5ead,\\u72af\\u7f6a,\\u52a8\\u4f5c,\\u5947\\u5e7b,\\u5267\\u60c5,\\u5386\\u53f2,\\u7ecf\\u5178,\\u4e61\\u6751,\\u60c5\\u666f,\\u5546\\u6218,\\u7f51\\u5267,\\u5176\\u4ed6","area":"\\u5185\\u5730,\\u97e9\\u56fd,\\u9999\\u6e2f,\\u53f0\\u6e7e,\\u65e5\\u672c,\\u7f8e\\u56fd,\\u6cf0\\u56fd,\\u82f1\\u56fd,\\u65b0\\u52a0\\u5761,\\u5176\\u4ed6","lang":"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u5176\\u5b83","year":"2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2006,2005,2004","star":"\\u738b\\u5b9d\\u5f3a,\\u80e1\\u6b4c,\\u970d\\u5efa\\u534e,\\u8d75\\u4e3d\\u9896,\\u5218\\u6d9b,\\u5218\\u8bd7\\u8bd7,\\u9648\\u4f1f\\u9706,\\u5434\\u5947\\u9686,\\u9646\\u6bc5,\\u5510\\u5ae3,\\u5173\\u6653\\u5f64,\\u5b59\\u4fea,\\u674e\\u6613\\u5cf0,\\u5f20\\u7ff0,\\u674e\\u6668,\\u8303\\u51b0\\u51b0,\\u6797\\u5fc3\\u5982,\\u6587\\u7ae0,\\u9a6c\\u4f0a\\u740d,\\u4f5f\\u5927\\u4e3a,\\u5b59\\u7ea2\\u96f7,\\u9648\\u5efa\\u658c,\\u674e\\u5c0f\\u7490","director":"\\u5f20\\u7eaa\\u4e2d,\\u674e\\u5c11\\u7ea2,\\u5218\\u6c5f,\\u5b54\\u7b19,\\u5f20\\u9ece,\\u5eb7\\u6d2a\\u96f7,\\u9ad8\\u5e0c\\u5e0c,\\u80e1\\u73ab,\\u8d75\\u5b9d\\u521a,\\u90d1\\u6653\\u9f99","state":"\\u6b63\\u7247,\\u9884\\u544a\\u7247,\\u82b1\\u7d6e","version":"\\u9ad8\\u6e05\\u7248,\\u5267\\u573a\\u7248,\\u62a2\\u5148\\u7248,OVA,TV,\\u5f71\\u9662\\u7248"}'),
(3, '国产', 'meinv', 3, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '美女主播', '美女主播', '美女主播', '', '{"class":"\\u9009\\u79c0,\\u60c5\\u611f,\\u8bbf\\u8c08,\\u64ad\\u62a5,\\u65c5\\u6e38,\\u97f3\\u4e50,\\u7f8e\\u98df,\\u7eaa\\u5b9e,\\u66f2\\u827a,\\u751f\\u6d3b,\\u6e38\\u620f\\u4e92\\u52a8,\\u8d22\\u7ecf,\\u6c42\\u804c","area":"\\u5185\\u5730,\\u6e2f\\u53f0,\\u65e5\\u97e9,\\u6b27\\u7f8e","lang":"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u5176\\u5b83","year":"2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2007,2006,2005,2004","star":"\\u4f55\\u7085,\\u6c6a\\u6db5,\\u8c22\\u5a1c,\\u5468\\u7acb\\u6ce2,\\u9648\\u9c81\\u8c6b,\\u5b5f\\u975e,\\u674e\\u9759,\\u6731\\u519b,\\u6731\\u4e39,\\u534e\\u5c11,\\u90ed\\u5fb7\\u7eb2,\\u6768\\u6f9c","director":"","state":"","version":""}'),
(4, '欧美', 'youxi', 4, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '游戏主播', '游戏主播', '游戏主播', '', '{"class":"\\u60c5\\u611f,\\u79d1\\u5e7b,\\u70ed\\u8840,\\u63a8\\u7406,\\u641e\\u7b11,\\u5192\\u9669,\\u841d\\u8389,\\u6821\\u56ed,\\u52a8\\u4f5c,\\u673a\\u6218,\\u8fd0\\u52a8,\\u6218\\u4e89,\\u5c11\\u5e74,\\u5c11\\u5973,\\u793e\\u4f1a,\\u539f\\u521b,\\u4eb2\\u5b50,\\u76ca\\u667a,\\u52b1\\u5fd7,\\u5176\\u4ed6","area":"\\u56fd\\u4ea7,\\u65e5\\u672c,\\u6b27\\u7f8e,\\u5176\\u4ed6","lang":"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u5176\\u5b83","year":"2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2007,2006,2005,2004","star":"","director":"","state":"","version":"TV\\u7248,\\u7535\\u5f71\\u7248,OVA\\u7248,\\u771f\\u4eba\\u7248"}'),
(5, '中文', 'remen', 5, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '热门主播', '热门主播', '热门主播', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(7, '御女', 'shishangzhubo', 7, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '时尚主播', '时尚主播', '时尚主播', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(6, 'VIP专区', 'changgezhubo', 6, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '唱歌主播', '唱歌主播', '唱歌主播', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(8, '学生', 'vip', 8, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', 'VIP专区', 'VIP专区', 'VIP专区', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(9, '性感', 'mingxingtu', 1, 2, 20, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '明星主播图', '明星主播图', '明星主播图', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(10, '清纯', 'wanghongtu', 2, 2, 20, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '网红主播图', '网红主播图', '网红主播图', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(11, '少女', 'meinvtu', 3, 2, 20, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '美女主播图', '美女主播图', '美女主播图', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(12, '萝莉', 'youxitu', 4, 2, 20, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '游戏主播图', '游戏主播图', '游戏主播图', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(13, '熟女', 'changgezhubotu', 5, 2, 20, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '唱歌主播图', '唱歌主播图', '唱歌主播图', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(20, '图片', 'tupian', 9, 2, 0, 1, 'type.html', 'show.html', 'detail.html', '', '', '', '', '', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(21, '小说', 'xiaoshuo', 10, 2, 0, 1, 'xstype.html', 'show.html', 'xsdetail.html', '', '', '', '', '', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(22, '言情小说', 'yanqingxiaoshuo', 1, 2, 21, 1, 'xstype.html', 'show.html', 'xsdetail.html', '', '', '', '', '', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(23, 'YY小说', 'YYxiaoshuo', 2, 2, 21, 1, 'xstype.html', 'show.html', 'xsdetail.html', '', '', '', '', '', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(24, '同人小说', 'tongrenxiaoshuo', 3, 2, 21, 1, 'xstype.html', 'show.html', 'xsdetail.html', '', '', '', '', '', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}'),
(25, '轻小说', 'qingxiaoshuo', 4, 2, 21, 1, 'xstype.html', 'show.html', 'xsdetail.html', '', '', '', '', '', '', '{"class":"","area":"","lang":"","year":"","star":"","director":"","state":"","version":""}');

-- --------------------------------------------------------

--
-- 表的结构 `mac_ulog`
--

CREATE TABLE IF NOT EXISTS `mac_ulog` (
  `ulog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ulog_mid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ulog_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ulog_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `ulog_sid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ulog_nid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `ulog_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `ulog_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ulog_id`),
  KEY `user_id` (`user_id`),
  KEY `ulog_mid` (`ulog_mid`),
  KEY `ulog_type` (`ulog_type`),
  KEY `ulog_rid` (`ulog_rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `mac_ulog`
--

INSERT INTO `mac_ulog` (`ulog_id`, `user_id`, `ulog_mid`, `ulog_type`, `ulog_rid`, `ulog_sid`, `ulog_nid`, `ulog_points`, `ulog_time`) VALUES
(1, 1, 1, 4, 4, 1, 1, 0, 1563195299),
(2, 1, 1, 4, 7, 1, 1, 0, 1563196729),
(3, 1, 1, 4, 5, 1, 1, 0, 1563197920),
(4, 1, 1, 4, 2, 1, 1, 0, 1563197934),
(5, 3, 1, 4, 2, 1, 1, 0, 1563336617),
(6, 3, 1, 4, 5, 1, 1, 0, 1563336803),
(7, 5, 1, 4, 305, 1, 1, 0, 1563709296),
(8, 5, 1, 4, 309, 1, 1, 0, 1563709776),
(9, 6, 1, 4, 309, 1, 1, 0, 1563934131),
(10, 7, 1, 4, 310, 1, 1, 0, 1564148700),
(11, 7, 1, 4, 309, 1, 1, 0, 1564148840),
(12, 7, 2, 1, 12, 0, 0, 0, 1564148868),
(13, 7, 2, 2, 12, 0, 0, 0, 1564148871),
(14, 7, 1, 4, 301, 1, 1, 0, 1564149138),
(15, 9, 2, 1, 13, 0, 0, 0, 1564433573),
(16, 9, 2, 1, 12, 0, 0, 0, 1564433605),
(17, 10, 1, 4, 309, 1, 1, 0, 1564477364),
(18, 10, 1, 2, 309, 0, 0, 0, 1564477367),
(19, 10, 2, 1, 13, 0, 0, 0, 1564477591),
(20, 11, 1, 4, 301, 1, 1, 0, 1564687475),
(21, 11, 1, 4, 302, 1, 1, 0, 1564687563),
(22, 13, 1, 4, 302, 1, 1, 0, 1565160419),
(23, 14, 1, 4, 305, 1, 1, 0, 1565164589),
(24, 15, 1, 4, 309, 1, 1, 0, 1566051734),
(25, 15, 1, 4, 310, 1, 1, 0, 1566051765),
(26, 16, 2, 1, 12, 0, 0, 0, 1566275626),
(27, 16, 2, 1, 6, 0, 0, 0, 1566275636),
(28, 1, 1, 4, 310, 1, 1, 0, 1568377664);

-- --------------------------------------------------------

--
-- 表的结构 `mac_user`
--

CREATE TABLE IF NOT EXISTS `mac_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(30) NOT NULL DEFAULT '',
  `user_pwd` varchar(32) NOT NULL DEFAULT '',
  `user_nick_name` varchar(30) NOT NULL DEFAULT '',
  `user_qq` varchar(16) NOT NULL DEFAULT '',
  `user_email` varchar(30) NOT NULL DEFAULT '',
  `user_phone` varchar(16) NOT NULL DEFAULT '',
  `user_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_portrait` varchar(100) NOT NULL DEFAULT '',
  `user_portrait_thumb` varchar(100) NOT NULL DEFAULT '',
  `user_openid_qq` varchar(40) NOT NULL DEFAULT '',
  `user_openid_weixin` varchar(40) NOT NULL DEFAULT '',
  `user_question` varchar(255) NOT NULL DEFAULT '',
  `user_answer` varchar(255) NOT NULL DEFAULT '',
  `user_points` int(10) unsigned NOT NULL DEFAULT '0',
  `user_points_froze` int(10) unsigned NOT NULL DEFAULT '0',
  `user_reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_reg_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `user_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `user_last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_last_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `user_login_num` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_extend` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_random` varchar(32) NOT NULL DEFAULT '',
  `user_end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `user_pid_2` int(10) unsigned NOT NULL DEFAULT '0',
  `user_pid_3` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `type_id` (`group_id`) USING BTREE,
  KEY `user_name` (`user_name`),
  KEY `user_reg_time` (`user_reg_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `mac_user`
--

INSERT INTO `mac_user` (`user_id`, `group_id`, `user_name`, `user_pwd`, `user_nick_name`, `user_qq`, `user_email`, `user_phone`, `user_status`, `user_portrait`, `user_portrait_thumb`, `user_openid_qq`, `user_openid_weixin`, `user_question`, `user_answer`, `user_points`, `user_points_froze`, `user_reg_time`, `user_reg_ip`, `user_login_time`, `user_login_ip`, `user_last_login_time`, `user_last_login_ip`, `user_login_num`, `user_extend`, `user_random`, `user_end_time`, `user_pid`, `user_pid_2`, `user_pid_3`) VALUES
(1, 3, 'qweqwe111', '48bc82bf3a51c6735f3e6432f14c2e28', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1563192196, 607132401, 1568377600, 0, 1563192196, 607132401, 2, 0, 'a253e5a3bb07623788e3032bfa3aec63', 1577836800, 0, 0, 0),
(2, 2, 'qweqwe222', '56cfc0922dcd66f447ffcf2c33f0b782', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1563239580, 0, 1563239580, 0, 0, 0, 1, 0, 'a08a58e080c37d52a605d55887f5ab5e', 0, 0, 0, 0),
(3, 2, '123456', '202cb962ac59075b964b07152d234b70', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1563293350, 2059369727, 1563336504, 2059369727, 1563294126, 2059369727, 3, 0, '34f30da3f4f80a6e475eaa2eb02800e6', 0, 0, 0, 0),
(4, 2, '123123', '4297f44b13955235245b2497399d7a93', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1563679241, 0, 1563688381, 0, 1563679241, 0, 2, 0, '7357eee22a4d6fcf12b6d71cc08189e7', 0, 0, 0, 0),
(5, 2, '123456sss9', '2e027463d5b44e3419fc421354862b18', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1563709287, 1919179086, 1563709287, 1919179086, 0, 0, 1, 0, 'cfd7d6e47d99b2ee87b2de8f4352838f', 0, 0, 0, 0),
(6, 2, 'asdfgh', 'b99ebc247cef6bac3e9118c34dc34503', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1563934082, 0, 1563934082, 0, 0, 0, 1, 0, '009b14bf61ba28754ab77e4647a24795', 0, 0, 0, 0),
(7, 2, 'jiajuhuen', '7570f1d13525e37248f4d3a4fb432b4d', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1564148361, 1919183851, 1564148361, 1919183851, 0, 0, 1, 0, '9a8f1fcc82354faa416ab7143a537640', 0, 0, 0, 0),
(8, 2, '664461', 'cffe5f7f586a86bae93f7254cbbd8f5b', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1564233569, 236716440, 1564233569, 236716440, 0, 0, 1, 0, '167bea1bf0821b618d7c88206f96d76a', 0, 0, 0, 0),
(9, 2, 'laishilin', '18da820b7b7b21ac91d1bc1f361002b0', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1564433520, 1964959897, 1564433520, 1964959897, 0, 0, 1, 0, 'e75439eda76893b3d041a73c23013ee1', 0, 0, 0, 0),
(10, 3, 'qweasd', '07ebde94cab72d3f77410c5cfe6ce989', '', '', '', '', 1, '', '', '', '', '', '', 0, 0, 1564477319, 1901538718, 1564477319, 1901538718, 0, 0, 1, 0, '45cc6aeb64d82955fcdbc0d5748e674d', 1564563861, 0, 0, 0),
(11, 2, 'qazwsx', '76419c58730d9f35de7ac538c2fd6737', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1564687448, 1020408614, 1564687546, 1020408614, 1564687448, 1020408614, 2, 0, '4dcd8fc8821c9e074f547dbf9338cb25', 0, 0, 0, 0),
(12, 2, '1990xfw', 'b206e95a4384298962649e58dc7b39d4', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1565092407, 0, 1565092407, 0, 0, 0, 1, 0, 'd20e7aa7f31a428921f54751e9deeb90', 0, 0, 0, 0),
(13, 2, 'lixunhuan', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1565160209, 1949482259, 1565160209, 1949482259, 0, 0, 1, 0, 'e358a33fcd5e7a9b8711d38ce2755c5c', 0, 0, 0, 0),
(14, 2, '123321', 'c8837b23ff8aaa8a2dde915473ce0991', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1565164473, 0, 1565164473, 0, 0, 0, 1, 0, '0320068933c3c10db3d9b7f1ae212cda', 0, 0, 0, 0),
(15, 2, '13799286367', '4297f44b13955235245b2497399d7a93', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1566051716, 0, 1566051716, 0, 0, 0, 1, 0, '6727671247ab6bf3a3aa4cd197fd33d0', 0, 0, 0, 0),
(16, 2, 'wcyts01', '1bbd886460827015e5d605ed44252251', '', '', '', '', 1, '', '', '', '', '', '', 10, 0, 1566275598, 0, 1566275598, 0, 0, 0, 1, 0, '4fdfeb9fb54b369226f2a38aed751da5', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mac_visit`
--

CREATE TABLE IF NOT EXISTS `mac_visit` (
  `visit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT '0',
  `visit_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `visit_ly` varchar(100) NOT NULL DEFAULT '',
  `visit_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`visit_id`),
  KEY `user_id` (`user_id`),
  KEY `visit_time` (`visit_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mac_vod`
--

CREATE TABLE IF NOT EXISTS `mac_vod` (
  `vod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` smallint(6) NOT NULL DEFAULT '0',
  `type_id_1` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_name` varchar(255) NOT NULL DEFAULT '',
  `vod_sub` varchar(255) NOT NULL DEFAULT '',
  `vod_en` varchar(255) NOT NULL DEFAULT '',
  `vod_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_letter` char(1) NOT NULL DEFAULT '',
  `vod_color` varchar(6) NOT NULL DEFAULT '',
  `vod_tag` varchar(100) NOT NULL DEFAULT '',
  `vod_class` varchar(255) NOT NULL DEFAULT '',
  `vod_pic` varchar(255) NOT NULL DEFAULT '',
  `vod_pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `vod_pic_slide` varchar(255) NOT NULL DEFAULT '',
  `vod_actor` varchar(255) NOT NULL DEFAULT '',
  `vod_director` varchar(255) NOT NULL DEFAULT '',
  `vod_writer` varchar(100) NOT NULL DEFAULT '',
  `vod_behind` varchar(100) NOT NULL DEFAULT '',
  `vod_blurb` varchar(255) NOT NULL DEFAULT '',
  `vod_remarks` varchar(100) NOT NULL DEFAULT '',
  `vod_pubdate` varchar(100) NOT NULL DEFAULT '',
  `vod_total` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_serial` varchar(20) NOT NULL DEFAULT '0',
  `vod_tv` varchar(30) NOT NULL DEFAULT '',
  `vod_weekday` varchar(30) NOT NULL DEFAULT '',
  `vod_area` varchar(20) NOT NULL DEFAULT '',
  `vod_lang` varchar(10) NOT NULL DEFAULT '',
  `vod_year` varchar(10) NOT NULL DEFAULT '',
  `vod_version` varchar(30) NOT NULL DEFAULT '',
  `vod_state` varchar(30) NOT NULL DEFAULT '',
  `vod_author` varchar(60) NOT NULL DEFAULT '',
  `vod_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `vod_tpl` varchar(30) NOT NULL DEFAULT '',
  `vod_tpl_play` varchar(30) NOT NULL DEFAULT '',
  `vod_tpl_down` varchar(30) NOT NULL DEFAULT '',
  `vod_isend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_points_play` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_points_down` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_duration` varchar(10) NOT NULL DEFAULT '',
  `vod_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `vod_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_score_num` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `vod_time` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_trysee` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_douban_id` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_douban_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `vod_reurl` varchar(255) NOT NULL DEFAULT '',
  `vod_rel_vod` varchar(255) NOT NULL DEFAULT '',
  `vod_rel_art` varchar(255) NOT NULL DEFAULT '',
  `vod_content` text NOT NULL,
  `vod_play_from` varchar(255) NOT NULL DEFAULT '',
  `vod_play_server` varchar(255) NOT NULL DEFAULT '',
  `vod_play_note` varchar(255) NOT NULL DEFAULT '',
  `vod_play_url` mediumtext NOT NULL,
  `vod_down_from` varchar(255) NOT NULL DEFAULT '',
  `vod_down_server` varchar(255) NOT NULL DEFAULT '',
  `vod_down_note` varchar(255) NOT NULL DEFAULT '',
  `vod_down_url` mediumtext NOT NULL,
  `vod_pwd` varchar(10) NOT NULL DEFAULT '',
  `vod_pwd_url` varchar(255) NOT NULL DEFAULT '',
  `vod_pwd_play` varchar(10) NOT NULL DEFAULT '',
  `vod_pwd_play_url` varchar(255) NOT NULL DEFAULT '',
  `vod_pwd_down` varchar(10) NOT NULL DEFAULT '',
  `vod_pwd_down_url` varchar(255) NOT NULL DEFAULT '',
  `vod_copyright` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vod_id`),
  KEY `type_id` (`type_id`) USING BTREE,
  KEY `type_id_1` (`type_id_1`) USING BTREE,
  KEY `vod_level` (`vod_level`) USING BTREE,
  KEY `vod_hits` (`vod_hits`) USING BTREE,
  KEY `vod_letter` (`vod_letter`) USING BTREE,
  KEY `vod_name` (`vod_name`) USING BTREE,
  KEY `vod_year` (`vod_year`) USING BTREE,
  KEY `vod_area` (`vod_area`) USING BTREE,
  KEY `vod_lang` (`vod_lang`) USING BTREE,
  KEY `vod_tag` (`vod_tag`) USING BTREE,
  KEY `vod_class` (`vod_class`) USING BTREE,
  KEY `vod_lock` (`vod_lock`) USING BTREE,
  KEY `vod_up` (`vod_up`) USING BTREE,
  KEY `vod_down` (`vod_down`) USING BTREE,
  KEY `vod_en` (`vod_en`) USING BTREE,
  KEY `vod_hits_day` (`vod_hits_day`) USING BTREE,
  KEY `vod_hits_week` (`vod_hits_week`) USING BTREE,
  KEY `vod_hits_month` (`vod_hits_month`) USING BTREE,
  KEY `vod_points_play` (`vod_points_play`) USING BTREE,
  KEY `vod_points_down` (`vod_points_down`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE,
  KEY `vod_time_add` (`vod_time_add`) USING BTREE,
  KEY `vod_time` (`vod_time`) USING BTREE,
  KEY `vod_time_make` (`vod_time_make`) USING BTREE,
  KEY `vod_actor` (`vod_actor`) USING BTREE,
  KEY `vod_director` (`vod_director`) USING BTREE,
  KEY `vod_score_all` (`vod_score_all`) USING BTREE,
  KEY `vod_score_num` (`vod_score_num`) USING BTREE,
  KEY `vod_total` (`vod_total`) USING BTREE,
  KEY `vod_score` (`vod_score`) USING BTREE,
  KEY `vod_version` (`vod_version`),
  KEY `vod_state` (`vod_state`),
  KEY `vod_isend` (`vod_isend`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=319 ;

--
-- 转存表中的数据 `mac_vod`
--

INSERT INTO `mac_vod` (`vod_id`, `type_id`, `type_id_1`, `group_id`, `vod_name`, `vod_sub`, `vod_en`, `vod_status`, `vod_letter`, `vod_color`, `vod_tag`, `vod_class`, `vod_pic`, `vod_pic_thumb`, `vod_pic_slide`, `vod_actor`, `vod_director`, `vod_writer`, `vod_behind`, `vod_blurb`, `vod_remarks`, `vod_pubdate`, `vod_total`, `vod_serial`, `vod_tv`, `vod_weekday`, `vod_area`, `vod_lang`, `vod_year`, `vod_version`, `vod_state`, `vod_author`, `vod_jumpurl`, `vod_tpl`, `vod_tpl_play`, `vod_tpl_down`, `vod_isend`, `vod_lock`, `vod_level`, `vod_points_play`, `vod_points_down`, `vod_hits`, `vod_hits_day`, `vod_hits_week`, `vod_hits_month`, `vod_duration`, `vod_up`, `vod_down`, `vod_score`, `vod_score_all`, `vod_score_num`, `vod_time`, `vod_time_add`, `vod_time_hits`, `vod_time_make`, `vod_trysee`, `vod_douban_id`, `vod_douban_score`, `vod_reurl`, `vod_rel_vod`, `vod_rel_art`, `vod_content`, `vod_play_from`, `vod_play_server`, `vod_play_note`, `vod_play_url`, `vod_down_from`, `vod_down_server`, `vod_down_note`, `vod_down_url`, `vod_pwd`, `vod_pwd_url`, `vod_pwd_play`, `vod_pwd_play_url`, `vod_pwd_down`, `vod_pwd_down_url`, `vod_copyright`, `vod_points`) VALUES
(301, 2, 0, 0, '韩国美女热舞759', '', 'hanguomeinvrewu759', 1, 'H', '', '', '美女视频秀', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547861697.png', '', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547861697.png', '', '', '', '', '', 'BD高清', '', 0, '0', '', '', '韩国', '', '2017', '', '', '', '', '', '', '', 1, 0, 0, 0, 0, 427, 1, 5, 10, '', 783, 420, '6.0', 2856, 476, 1563688263, 1563687658, 1566208931, 0, 0, 0, '0.0', '', '', '', '', 'yjm3u8', 'no', '', 'BD高清$https://yong.yongjiu6.com/20171129/JMpMaCZZ/index.m3u8', '', '', '', '', '', '', '', '', '', '', 0, 0),
(302, 2, 0, 0, '韩国美女热舞758', '', 'hanguomeinvrewu758', 1, 'H', '', '', '美女视频秀', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547861857.png', '', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547861857.png', '', '', '', '', '', 'BD高清', '', 0, '0', '', '', '韩国', '', '2017', '', '', '', '', '', '', '', 1, 0, 9, 0, 0, 873, 1, 6, 26, '', 594, 975, '8.0', 3160, 395, 1563688271, 1563687658, 1566399377, 0, 0, 0, '0.0', '', '', '', '', 'yjm3u8', 'no', '', 'BD高清$https://yong.yongjiu6.com/20171129/76uMHdpr/index.m3u8', '', '', '', '', '', '', '', '', '', '', 0, 0),
(303, 2, 0, 0, '韩国美女热舞756', '', 'hanguomeinvrewu756', 1, 'H', '', '', '美女视频秀', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547861919.png', '', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547861919.png', '', '', '', '', '', 'BD高清', '', 0, '0', '', '', '韩国', '', '2017', '', '', '', '', '', '', '', 1, 0, 9, 0, 0, 328, 1, 4, 13, '', 969, 466, '7.0', 2303, 329, 1563688277, 1563687658, 1566279209, 0, 0, 0, '0.0', '', '', '', '', 'yjm3u8', 'no', '', 'BD高清$https://yong.yongjiu6.com/20171129/vpxRb1Vj/index.m3u8', '', '', '', '', '', '', '', '', '', '', 0, 0),
(309, 2, 0, 0, '韩国美女热舞755', '', 'hanguomeinvrewu755', 1, 'H', '', '', '美女视频秀', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547862069.png', '', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547862069.png', '', '', '', '', '', 'BD高清', '', 0, '0', '', '', '韩国', '', '2017', '', '', '', '', '', '', '', 1, 0, 9, 0, 0, 1084, 4, 16, 40, '', 772, 306, '6.0', 3924, 654, 1563688366, 1563687716, 1566396227, 0, 0, 0, '0.0', '', '', '', '', 'yjm3u8', 'no', '', 'BD高清$https://yong.yongjiu6.com/20171129/lAU4hym5/index.m3u8', '', '', '', '', '', '', '', '', '', '', 0, 0),
(310, 2, 0, 0, '韩国美女热舞751', '', 'hanguomeinvrewu751', 1, 'H', '', '', '美女视频秀', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547862228.png', '', 'https://img.yongjiu7.com/upload/vod/2019-01-19/201901191547862228.png', '', '', '', '', '', 'BD高清', '', 0, '0', '', '', '韩国', '', '2017', '', '', '', '', '', '', '', 1, 0, 9, 0, 0, 972, 1, 1, 1, '', 9, 689, '10.0', 760, 76, 1563688311, 1563687836, 1568377663, 0, 0, 0, '0.0', '', '', '', '', 'yjm3u8', 'no', '', 'BD高清$https://yong.yongjiu6.com/20171129/JQn8UVvO/index.m3u8', '', '', '', '', '', '', '', '', '', '', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
