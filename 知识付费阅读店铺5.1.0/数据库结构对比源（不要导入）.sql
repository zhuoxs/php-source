/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-01 13:33:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_article
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_article`;
CREATE TABLE `ims_ypuk_ffyd_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` varchar(50) DEFAULT 'text',
  `price` float(10,2) DEFAULT '0.00',
  `catid` int(10) NOT NULL,
  `thumb` text,
  `recommend` int(1) DEFAULT '0',
  `intro` varchar(1000) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  `viewnum` int(10) DEFAULT '0',
  `favnum` int(10) DEFAULT '0',
  `viewnum_min` int(10) NOT NULL DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `sort` int(3) DEFAULT '999',
  `copytext` text NOT NULL,
  `distribution_commission` varchar(100) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_audio_content
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_audio_content`;
CREATE TABLE `ims_ypuk_ffyd_audio_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `audio` text NOT NULL,
  `preview_audio` text NOT NULL,
  `text` text NOT NULL,
  `audiotime` varchar(50) DEFAULT '00.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_category
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_category`;
CREATE TABLE `ims_ypuk_ffyd_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目id',
  `weid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_comment
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_comment`;
CREATE TABLE `ims_ypuk_ffyd_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `articleid` int(10) NOT NULL,
  `content` text NOT NULL,
  `createtime` varchar(100) NOT NULL,
  `status` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_distribution_userbind
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_distribution_userbind`;
CREATE TABLE `ims_ypuk_ffyd_distribution_userbind` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `createtime` int(10) DEFAULT '0',
  `weid` int(10) NOT NULL,
  `topuid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_favlog
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_favlog`;
CREATE TABLE `ims_ypuk_ffyd_favlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_formid
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_formid`;
CREATE TABLE `ims_ypuk_ffyd_formid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `openid` varchar(200) DEFAULT NULL,
  `formid` varchar(255) NOT NULL,
  `aid` varchar(50) NOT NULL,
  `createtime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_package
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_package`;
CREATE TABLE `ims_ypuk_ffyd_package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `intro` text NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `price` float(10,2) DEFAULT '0.00',
  `status` int(1) DEFAULT '1',
  `buynum` int(10) DEFAULT '0',
  `buynum_min` int(10) DEFAULT '0',
  `recommend` int(1) DEFAULT '0',
  `createtime` varchar(255) NOT NULL,
  `distribution_commission` varchar(100) DEFAULT '0',
  `sort` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_package_bind
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_package_bind`;
CREATE TABLE `ims_ypuk_ffyd_package_bind` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `articleid` int(10) NOT NULL,
  `sort` int(3) DEFAULT '999',
  `createtime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_package_code
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_package_code`;
CREATE TABLE `ims_ypuk_ffyd_package_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `codeaccount` varchar(255) NOT NULL,
  `codepwd` varchar(255) NOT NULL,
  `createtime` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT '0未使用 1已使用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_package_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_package_record`;
CREATE TABLE `ims_ypuk_ffyd_package_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `weid` int(10) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_pdf_content
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_pdf_content`;
CREATE TABLE `ims_ypuk_ffyd_pdf_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `pdffile` varchar(260) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_pic_content
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_pic_content`;
CREATE TABLE `ims_ypuk_ffyd_pic_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `piclist` text NOT NULL,
  `preview_number` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_record`;
CREATE TABLE `ims_ypuk_ffyd_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `articleid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `weid` int(10) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_setting
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_setting`;
CREATE TABLE `ims_ypuk_ffyd_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `rooturl` varchar(200) DEFAULT NULL,
  `openkefu` int(1) DEFAULT '0',
  `kefutype` int(1) DEFAULT '0',
  `navtype` int(1) DEFAULT '1',
  `kefuqr` varchar(255) NOT NULL,
  `success_template_id` varchar(255) NOT NULL,
  `swiper` text NOT NULL,
  `index_new_text` varchar(255) NOT NULL,
  `index_view_text` varchar(255) NOT NULL,
  `opendistribution` int(1) DEFAULT '0',
  `user_withdraw_open` int(1) DEFAULT '0',
  `user_withdraw_charge` varchar(100) DEFAULT '0.006',
  `user_withdraw_type` int(1) DEFAULT '0',
  `help_examine_open` int(1) DEFAULT '0',
  `help_examine_index` text NOT NULL,
  `help_examine_package` text NOT NULL,
  `help_examine_my` text NOT NULL,
  `openposter` int(1) DEFAULT '0' COMMENT '0关闭 1开启',
  `poster_bg` text NOT NULL,
  `open_package_activation` int(1) DEFAULT '0' COMMENT '0关闭 1开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_text_content
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_text_content`;
CREATE TABLE `ims_ypuk_ffyd_text_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `text` text NOT NULL,
  `preview_text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_userwithdraw
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_userwithdraw`;
CREATE TABLE `ims_ypuk_ffyd_userwithdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `weid` int(10) NOT NULL,
  `status` int(1) DEFAULT '0',
  `charged_price` float(10,2) DEFAULT NULL,
  `withdraw_price` float(10,2) DEFAULT NULL,
  `allprice` float(10,2) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_video_content
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_video_content`;
CREATE TABLE `ims_ypuk_ffyd_video_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `video` text NOT NULL,
  `videotype` int(1) DEFAULT '0',
  `videopic` varchar(260) NOT NULL,
  `text` text NOT NULL,
  `preview_time` int(10) NOT NULL DEFAULT '6',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_vip
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_vip`;
CREATE TABLE `ims_ypuk_ffyd_vip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `vipid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `endtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ypuk_ffyd_vipgroup
-- ----------------------------
DROP TABLE IF EXISTS `ims_ypuk_ffyd_vipgroup`;
CREATE TABLE `ims_ypuk_ffyd_vipgroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `type` int(2) DEFAULT '1',
  `discount` varchar(10) DEFAULT '1',
  `validity` int(10) NOT NULL,
  `distribution_commission` varchar(100) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
