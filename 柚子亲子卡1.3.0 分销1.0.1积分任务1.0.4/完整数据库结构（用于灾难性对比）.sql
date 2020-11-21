/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : root

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-24 03:32:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_account
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_account`;
CREATE TABLE `ims_yzqzk_sun_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` varchar(1000) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `from_user` varchar(100) NOT NULL,
  `accountname` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pay_account` varchar(200) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `role` tinyint(1) unsigned NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL,
  `lastip` varchar(15) NOT NULL,
  `areaid` int(10) NOT NULL,
  `is_admin_order` tinyint(1) unsigned NOT NULL,
  `is_notice_order` tinyint(1) unsigned NOT NULL,
  `is_notice_queue` tinyint(1) unsigned NOT NULL,
  `is_notice_service` tinyint(1) unsigned NOT NULL,
  `is_notice_boss` tinyint(1) NOT NULL,
  `remark` varchar(1000) NOT NULL,
  `lat` decimal(18,10) NOT NULL,
  `lng` decimal(18,10) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_acode
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_acode`;
CREATE TABLE `ims_yzqzk_sun_acode` (
  `id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL,
  `code` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `uncode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_activationcode
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_activationcode`;
CREATE TABLE `ims_yzqzk_sun_activationcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `code` varchar(60) DEFAULT NULL,
  `num` int(11) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  `use_time` int(11) DEFAULT NULL,
  `is_use` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_active
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_active`;
CREATE TABLE `ims_yzqzk_sun_active` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `subtitle` varchar(45) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `createtime` int(13) unsigned NOT NULL,
  `content` text NOT NULL,
  `sort` int(10) DEFAULT NULL,
  `antime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hits` int(10) DEFAULT NULL,
  `status` tinyint(10) DEFAULT NULL,
  `astime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `thumb` varchar(200) DEFAULT NULL,
  `num` int(10) DEFAULT NULL,
  `sharenum` int(11) DEFAULT NULL,
  `thumb_url` text,
  `part_num` varchar(15) DEFAULT NULL,
  `share_plus` varchar(15) DEFAULT NULL,
  `new_partnum` varchar(15) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `storeinfo` varchar(200) DEFAULT NULL,
  `showindex` int(11) DEFAULT NULL,
  `active_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_activerecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_activerecord`;
CREATE TABLE `ims_yzqzk_sun_activerecord` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `pid` int(10) DEFAULT NULL,
  `num` int(10) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_activity
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_activity`;
CREATE TABLE `ims_yzqzk_sun_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `bm_begin_time` int(11) DEFAULT NULL,
  `bm_end_time` int(11) DEFAULT NULL,
  `hdbegintime` varchar(60) DEFAULT NULL,
  `hdendtime` varchar(60) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `lb_pics` text,
  `tag` varchar(200) DEFAULT NULL,
  `common_price` decimal(10,2) NOT NULL,
  `qzk_price` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `sale_num` int(11) NOT NULL,
  `qzk_status` tinyint(4) NOT NULL,
  `age_limit` varchar(100) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `info` text,
  `content` text,
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  `tg_time` int(11) DEFAULT NULL,
  `jj_time` int(11) DEFAULT NULL,
  `show_index` tinyint(4) NOT NULL,
  `gkfl_status` tinyint(4) NOT NULL,
  `money_rate` int(11) NOT NULL,
  `score_rate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_activity_category
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_activity_category`;
CREATE TABLE `ims_yzqzk_sun_activity_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `icons` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_ad
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_ad`;
CREATE TABLE `ims_yzqzk_sun_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `src` varchar(100) NOT NULL,
  `orderby` int(11) NOT NULL,
  `xcx_name` varchar(20) NOT NULL,
  `appid` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `wb_src` varchar(300) NOT NULL,
  `state` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_address
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_address`;
CREATE TABLE `ims_yzqzk_sun_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consignee` varchar(45) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` text NOT NULL,
  `stree` text NOT NULL,
  `uid` text NOT NULL,
  `isdefault` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_announcement
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_announcement`;
CREATE TABLE `ims_yzqzk_sun_announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `show_index` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_area
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_area`;
CREATE TABLE `ims_yzqzk_sun_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(50) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_baby
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_baby`;
CREATE TABLE `ims_yzqzk_sun_baby` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `sex` varchar(4) DEFAULT NULL,
  `birth` varchar(20) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_banner`;
CREATE TABLE `ims_yzqzk_sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(45) NOT NULL,
  `lb_imgs` varchar(500) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `url_type` tinyint(4) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_baowen
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_baowen`;
CREATE TABLE `ims_yzqzk_sun_baowen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xml` text,
  `out_trade_no` varchar(60) DEFAULT NULL,
  `transaction_id` varchar(60) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `out_trade_no` (`out_trade_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_bargain
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_bargain`;
CREATE TABLE `ims_yzqzk_sun_bargain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(100) DEFAULT NULL,
  `marketprice` varchar(45) DEFAULT NULL,
  `selftime` varchar(100) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `details` text,
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `starttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `shopprice` varchar(45) DEFAULT NULL,
  `endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `num` int(11) DEFAULT NULL,
  `content` text,
  `showindex` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_car
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_car`;
CREATE TABLE `ims_yzqzk_sun_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start_place` varchar(100) NOT NULL,
  `end_place` varchar(100) NOT NULL,
  `start_time` varchar(30) NOT NULL,
  `num` int(4) NOT NULL,
  `link_name` varchar(30) NOT NULL,
  `link_tel` varchar(20) NOT NULL,
  `typename` varchar(30) NOT NULL,
  `other` varchar(300) NOT NULL,
  `time` int(11) NOT NULL,
  `sh_time` int(11) NOT NULL,
  `top_id` int(11) NOT NULL,
  `top` int(4) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `state` int(4) NOT NULL,
  `tj_place` varchar(300) NOT NULL,
  `hw_wet` varchar(10) NOT NULL,
  `star_lat` varchar(20) NOT NULL,
  `star_lng` varchar(20) NOT NULL,
  `end_lat` varchar(20) NOT NULL,
  `end_lng` varchar(20) NOT NULL,
  `is_open` int(4) NOT NULL,
  `start_time2` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_car_my_tag
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_car_my_tag`;
CREATE TABLE `ims_yzqzk_sun_car_my_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_car_tag
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_car_tag`;
CREATE TABLE `ims_yzqzk_sun_car_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(30) NOT NULL,
  `tagname` varchar(30) NOT NULL,
  `uniacid` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_car_top
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_car_top`;
CREATE TABLE `ims_yzqzk_sun_car_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_carpaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_carpaylog`;
CREATE TABLE `ims_yzqzk_sun_carpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(44) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_comments
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_comments`;
CREATE TABLE `ims_yzqzk_sun_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL,
  `details` varchar(200) NOT NULL,
  `time` varchar(20) NOT NULL,
  `reply` varchar(200) NOT NULL,
  `hf_time` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `score` decimal(10,1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_commission_withdrawal
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_commission_withdrawal`;
CREATE TABLE `ims_yzqzk_sun_commission_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `sh_time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `account` varchar(100) NOT NULL,
  `tx_cost` decimal(10,2) NOT NULL,
  `sj_cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_coupon`;
CREATE TABLE `ims_yzqzk_sun_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL,
  `sign` tinyint(1) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `m_price` int(10) NOT NULL,
  `mj_price` int(10) NOT NULL,
  `expiry_day` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `yl_num` int(11) NOT NULL,
  `show_index` tinyint(4) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  `info` text,
  `remark` text,
  `is_vip` tinyint(4) NOT NULL,
  `is_punch` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_coupon_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_coupon_order`;
CREATE TABLE `ims_yzqzk_sun_coupon_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `pid` int(10) DEFAULT NULL,
  `uid` int(10) DEFAULT NULL,
  `cid` int(10) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `status` tinyint(10) DEFAULT NULL,
  `num` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_customize
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_customize`;
CREATE TABLE `ims_yzqzk_sun_customize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `clickago_icon` varchar(200) DEFAULT NULL,
  `clickafter_icon` varchar(200) DEFAULT NULL,
  `url_type` tinyint(4) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `url_name` varchar(50) DEFAULT NULL,
  `sort` tinyint(4) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_distribution
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_distribution`;
CREATE TABLE `ims_yzqzk_sun_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_tel` varchar(20) NOT NULL,
  `state` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_distribution_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_distribution_order`;
CREATE TABLE `ims_yzqzk_sun_distribution_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordertype` tinyint(3) NOT NULL,
  `order_id` int(11) NOT NULL,
  `parent_id_1` int(11) NOT NULL,
  `parent_id_2` int(11) NOT NULL,
  `parent_id_3` int(11) NOT NULL,
  `first_price` decimal(10,2) NOT NULL,
  `second_price` decimal(10,2) NOT NULL,
  `third_price` decimal(10,2) NOT NULL,
  `rebate` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_distribution_promoter
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_distribution_promoter`;
CREATE TABLE `ims_yzqzk_sun_distribution_promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `mobilephone` varchar(30) NOT NULL,
  `allcommission` decimal(10,2) NOT NULL,
  `canwithdraw` decimal(10,2) NOT NULL,
  `referrer_name` varchar(100) NOT NULL,
  `referrer_uid` int(11) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `addtime` int(11) NOT NULL,
  `checktime` int(11) NOT NULL,
  `meno` text NOT NULL,
  `form_id` varchar(50) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `freezemoney` decimal(10,2) NOT NULL,
  `uid` int(11) NOT NULL,
  `code_img` mediumblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_distribution_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_distribution_set`;
CREATE TABLE `ims_yzqzk_sun_distribution_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) NOT NULL,
  `is_buyself` tinyint(1) NOT NULL,
  `lower_condition` tinyint(1) NOT NULL,
  `share_condition` tinyint(3) NOT NULL,
  `autoshare` decimal(10,2) NOT NULL,
  `withdrawtype` varchar(100) NOT NULL,
  `minwithdraw` decimal(10,2) NOT NULL,
  `daymaxwithdraw` decimal(10,2) NOT NULL,
  `withdrawnotice` text NOT NULL,
  `tpl_wd_arrival` varchar(255) NOT NULL,
  `tpl_wd_fail` varchar(255) NOT NULL,
  `tpl_share_check` varchar(255) NOT NULL,
  `application` text NOT NULL,
  `applybanner` varchar(255) NOT NULL,
  `checkbanner` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `commissiontype` tinyint(3) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `firstmoney` decimal(10,2) NOT NULL,
  `secondname` varchar(255) NOT NULL,
  `secondmoney` decimal(10,2) NOT NULL,
  `withdrawhandingfee` decimal(10,2) NOT NULL,
  `thirdname` varchar(50) NOT NULL,
  `thirdmoney` decimal(10,2) NOT NULL,
  `postertoppic` varchar(255) NOT NULL,
  `postertoptitle` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_distribution_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_distribution_withdraw`;
CREATE TABLE `ims_yzqzk_sun_distribution_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `account` varchar(20) NOT NULL,
  `withdrawaltype` tinyint(3) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `time` int(11) NOT NULL,
  `mobilephone` varchar(30) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `realmoney` decimal(10,2) NOT NULL,
  `ratesmoney` decimal(10,2) NOT NULL,
  `meno` text NOT NULL,
  `uid` int(11) NOT NULL,
  `form_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_dynamic
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_dynamic`;
CREATE TABLE `ims_yzqzk_sun_dynamic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `head_img` varchar(100) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `content` text,
  `imgs` text,
  `gid` int(11) NOT NULL,
  `is_status` tinyint(4) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_dynamic_collection
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_dynamic_collection`;
CREATE TABLE `ims_yzqzk_sun_dynamic_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `dynamic_id` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `headimg` varchar(200) DEFAULT NULL,
  `is_status` tinyint(4) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_dynamic_comment
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_dynamic_comment`;
CREATE TABLE `ims_yzqzk_sun_dynamic_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `dynamic_id` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `content` text,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_earnings
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_earnings`;
CREATE TABLE `ims_yzqzk_sun_earnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `son_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_fabuset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_fabuset`;
CREATE TABLE `ims_yzqzk_sun_fabuset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(5) DEFAULT NULL,
  `price` varchar(15) DEFAULT NULL,
  `uniacid` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_fx
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_fx`;
CREATE TABLE `ims_yzqzk_sun_fx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `zf_user_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_fxset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_fxset`;
CREATE TABLE `ims_yzqzk_sun_fxset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fx_details` text NOT NULL,
  `tx_details` text NOT NULL,
  `is_fx` int(11) NOT NULL,
  `is_ej` int(11) NOT NULL,
  `tx_rate` int(11) NOT NULL,
  `commission` varchar(10) NOT NULL,
  `commission2` varchar(10) NOT NULL,
  `tx_money` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `img2` varchar(100) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL,
  `instructions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_fxuser
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_fxuser`;
CREATE TABLE `ims_yzqzk_sun_fxuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fx_user` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_gift
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_gift`;
CREATE TABLE `ims_yzqzk_sun_gift` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `sort` int(10) DEFAULT NULL,
  `hits` int(10) DEFAULT NULL,
  `status` tinyint(10) DEFAULT NULL,
  `thumb` varchar(200) DEFAULT NULL,
  `thumb2` varchar(200) DEFAULT NULL,
  `pid` int(10) DEFAULT NULL,
  `rate` mediumint(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_gift_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_gift_order`;
CREATE TABLE `ims_yzqzk_sun_gift_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `pid` int(10) DEFAULT NULL,
  `uid` varchar(100) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `status` tinyint(10) DEFAULT NULL,
  `consignee` varchar(45) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `note` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_goods`;
CREATE TABLE `ims_yzqzk_sun_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `goods_volume` varchar(45) NOT NULL,
  `sales_num` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `lid` tinyint(4) NOT NULL,
  `goods_name` varchar(100) NOT NULL,
  `goods_num` int(11) NOT NULL,
  `goods_price` decimal(10,2) NOT NULL,
  `pintuan_price` decimal(10,2) NOT NULL,
  `kanjia_price` decimal(10,2) NOT NULL,
  `qianggou_price` decimal(10,2) NOT NULL,
  `share_price` decimal(10,2) NOT NULL,
  `second_price` decimal(10,2) NOT NULL,
  `kanjia_percent` int(11) NOT NULL,
  `goods_cost` decimal(10,2) NOT NULL,
  `type_id` int(11) NOT NULL,
  `freight` decimal(10,2) NOT NULL,
  `delivery` varchar(500) NOT NULL,
  `quality` int(4) NOT NULL,
  `free` int(4) NOT NULL,
  `all_day` int(4) NOT NULL,
  `service` int(4) NOT NULL,
  `refund` int(4) NOT NULL,
  `weeks` int(4) NOT NULL,
  `lb_imgs` varchar(500) NOT NULL,
  `imgs` varchar(500) NOT NULL,
  `time` int(11) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `goods_details` text NOT NULL,
  `state` int(4) NOT NULL,
  `num` int(11) NOT NULL,
  `pintuan_num` int(11) NOT NULL,
  `sy_num` int(11) NOT NULL,
  `is_show` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `spec_name` varchar(45) NOT NULL,
  `spec_value` varchar(200) NOT NULL,
  `spec_names` varchar(45) NOT NULL,
  `spec_values` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `title_dec` varchar(200) DEFAULT NULL,
  `haowuimg` varchar(200) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `haowu_info` text,
  `video` text,
  `show_index` tinyint(1) DEFAULT NULL,
  `show_recommend` tinyint(1) DEFAULT NULL,
  `show_columns` tinyint(1) DEFAULT NULL,
  `start_time` int(10) DEFAULT NULL,
  `end_time` int(10) DEFAULT NULL,
  `pin_hours` int(11) NOT NULL,
  `content` text,
  `is_deliver` tinyint(4) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `related_gid` int(11) DEFAULT NULL,
  `distribution_open` tinyint(1) NOT NULL,
  `distribution_commissiontype` tinyint(1) NOT NULL,
  `firstmoney` decimal(10,2) NOT NULL,
  `secondmoney` decimal(10,2) NOT NULL,
  `thirdmoney` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_goods_spec
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_goods_spec`;
CREATE TABLE `ims_yzqzk_sun_goods_spec` (
  `spec_value` varchar(45) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spec_name` varchar(100) NOT NULL,
  `sort` int(4) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_groups
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_groups`;
CREATE TABLE `ims_yzqzk_sun_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(100) DEFAULT NULL,
  `marketprice` decimal(10,2) DEFAULT NULL,
  `selftime` varchar(100) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `details` text,
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `starttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `shopprice` decimal(10,2) DEFAULT NULL,
  `endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `num` int(11) DEFAULT NULL,
  `pintuan_num` int(11) DEFAULT NULL,
  `content` text,
  `groups_num` int(11) DEFAULT NULL,
  `is_deliver` int(2) DEFAULT NULL,
  `showindex` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_hblq
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_hblq`;
CREATE TABLE `ims_yzqzk_sun_hblq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tz_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_help
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_help`;
CREATE TABLE `ims_yzqzk_sun_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL,
  `answer` text NOT NULL,
  `sort` int(4) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_hotcity
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_hotcity`;
CREATE TABLE `ims_yzqzk_sun_hotcity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cityname` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_hxstaff
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_hxstaff`;
CREATE TABLE `ims_yzqzk_sun_hxstaff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_information
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_information`;
CREATE TABLE `ims_yzqzk_sun_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `details` text NOT NULL,
  `img` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_tel` varchar(20) NOT NULL,
  `hot` int(11) NOT NULL,
  `top` int(11) NOT NULL,
  `givelike` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `type2_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL,
  `sh_time` int(11) NOT NULL,
  `top_type` int(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `hb_money` decimal(10,2) NOT NULL,
  `hb_num` int(11) NOT NULL,
  `hb_type` int(11) NOT NULL,
  `hb_keyword` varchar(20) NOT NULL,
  `hb_random` int(11) NOT NULL,
  `hong` text NOT NULL,
  `store_id` int(11) NOT NULL,
  `del` int(11) NOT NULL,
  `user_img2` varchar(100) NOT NULL,
  `dq_time` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `hbfx_num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_label
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_label`;
CREATE TABLE `ims_yzqzk_sun_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_name` varchar(20) NOT NULL,
  `type2_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_like
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_like`;
CREATE TABLE `ims_yzqzk_sun_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `zx_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_mercapdetails
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_mercapdetails`;
CREATE TABLE `ims_yzqzk_sun_mercapdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `store_name` varchar(100) DEFAULT NULL,
  `mcd_type` tinyint(4) NOT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `sign` tinyint(4) NOT NULL,
  `mcd_memo` text,
  `money` decimal(10,2) NOT NULL,
  `realmoney` decimal(10,2) NOT NULL,
  `paycommission` decimal(10,2) NOT NULL,
  `ratesmoney` decimal(10,2) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `wd_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_mylabel
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_mylabel`;
CREATE TABLE `ims_yzqzk_sun_mylabel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` int(11) NOT NULL,
  `information_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_news`;
CREATE TABLE `ims_yzqzk_sun_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `state` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_order`;
CREATE TABLE `ims_yzqzk_sun_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `orderformid` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `order_amount` decimal(10,2) NOT NULL,
  `good_total_price` decimal(10,2) NOT NULL,
  `good_total_num` int(11) NOT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `baby_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `sincetype` tinyint(4) NOT NULL,
  `distribution` decimal(10,2) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_price` decimal(10,2) NOT NULL,
  `order_lid` tinyint(4) DEFAULT NULL,
  `qzk_type` tinyint(4) DEFAULT NULL,
  `pay_type` tinyint(4) DEFAULT NULL,
  `pay_status` tinyint(4) NOT NULL,
  `pay_time` int(11) DEFAULT NULL,
  `order_status` tinyint(4) NOT NULL,
  `queren_time` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `prepay_id` varchar(60) DEFAULT NULL,
  `qrcode_path` varchar(100) DEFAULT NULL,
  `hx_openid` varchar(60) DEFAULT NULL,
  `hx_time` int(11) DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL,
  `cancel_time` int(11) DEFAULT NULL,
  `del_time` int(11) DEFAULT NULL,
  `store_id` tinyint(4) NOT NULL,
  `storelimit_id` int(11) DEFAULT NULL,
  `parent_id_1` int(11) NOT NULL,
  `parent_id_2` int(11) NOT NULL,
  `parent_id_3` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_order_detail`;
CREATE TABLE `ims_yzqzk_sun_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `common_price` decimal(10,2) NOT NULL,
  `qzk_price` decimal(10,2) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `num` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_order_detail1
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_order_detail1`;
CREATE TABLE `ims_yzqzk_sun_order_detail1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `uniacid` int(11) NOT NULL,
  `uid` varchar(60) NOT NULL,
  `gid` int(11) DEFAULT NULL,
  `gname` varchar(60) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `combine` varchar(100) DEFAULT NULL,
  `spec_value` varchar(30) DEFAULT NULL,
  `spec_value1` varchar(30) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `is_pingjia` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_order1
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_order1`;
CREATE TABLE `ims_yzqzk_sun_order1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` text NOT NULL,
  `store_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `time` int(11) NOT NULL,
  `pay_time` int(11) NOT NULL,
  `complete_time` int(11) NOT NULL,
  `fh_time` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `order_num` varchar(20) NOT NULL,
  `good_id` varchar(45) NOT NULL,
  `good_name` varchar(200) NOT NULL,
  `good_img` varchar(400) NOT NULL,
  `good_money` varchar(100) NOT NULL,
  `out_trade_no` varchar(50) NOT NULL,
  `good_spec` varchar(200) NOT NULL,
  `del` int(11) NOT NULL,
  `del2` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `freight` decimal(10,2) NOT NULL,
  `note` varchar(100) NOT NULL,
  `good_num` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_order2
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_order2`;
CREATE TABLE `ims_yzqzk_sun_order2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` varchar(60) NOT NULL,
  `cid` tinyint(4) NOT NULL,
  `crid` varchar(255) DEFAULT NULL,
  `orderformid` varchar(50) DEFAULT NULL,
  `order_lid` tinyint(4) DEFAULT NULL,
  `pin_buy_type` tinyint(4) NOT NULL,
  `pin_mch_id` int(11) NOT NULL,
  `pin_order_id` int(11) NOT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `order_amount` decimal(10,2) NOT NULL,
  `good_total_price` decimal(10,2) NOT NULL,
  `good_total_num` int(11) NOT NULL,
  `sincetype` tinyint(4) NOT NULL,
  `distribution` decimal(10,2) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_price` decimal(10,2) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `postalcode` varchar(20) DEFAULT NULL,
  `province` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `zip` varchar(30) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `ziti_phone` varchar(60) DEFAULT NULL,
  `yuyue_name` varchar(60) DEFAULT NULL,
  `yuyue_phone` varchar(30) DEFAULT NULL,
  `yuyue_time` varchar(60) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `add_time` int(11) NOT NULL,
  `pay_time` int(11) DEFAULT NULL,
  `pay_status` tinyint(4) NOT NULL,
  `order_status` tinyint(4) NOT NULL,
  `fahuo_time` int(11) DEFAULT NULL,
  `queren_time` int(11) DEFAULT NULL,
  `cancel_time` int(11) DEFAULT NULL,
  `refund_application_status` tinyint(4) NOT NULL,
  `refund_status` tinyint(4) NOT NULL,
  `refund_time` int(11) DEFAULT NULL,
  `tuikuanformid` varchar(50) DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL,
  `del_time` int(11) DEFAULT NULL,
  `is_pingjia` tinyint(4) NOT NULL,
  `share_deduction` decimal(10,2) NOT NULL,
  `prepay_id` varchar(60) DEFAULT NULL,
  `qrcode_path` varchar(100) DEFAULT NULL,
  `hx_openid` varchar(60) DEFAULT NULL,
  `hx_time` int(11) DEFAULT NULL,
  `express_delivery` varchar(60) DEFAULT NULL,
  `express_orderformid` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_paylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_paylog`;
CREATE TABLE `ims_yzqzk_sun_paylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `note` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_pingjia
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_pingjia`;
CREATE TABLE `ims_yzqzk_sun_pingjia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` varchar(60) DEFAULT NULL,
  `order_id` int(60) DEFAULT NULL,
  `order_detail_id` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `imgs` text,
  `content` text,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_platform
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_platform`;
CREATE TABLE `ims_yzqzk_sun_platform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `total_realmoney` decimal(10,2) NOT NULL,
  `total_paycommission` decimal(10,2) NOT NULL,
  `total_ratesmoney` decimal(10,2) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_address
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_address`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `province` varchar(60) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `zip` varchar(60) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `postalcode` varchar(20) DEFAULT NULL,
  `default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '默认地址',
  `lottery` tinyint(4) NOT NULL DEFAULT '0' COMMENT '抽奖收货地址',
  `add_time` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='地址';

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_article
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_article`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `show_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '首页展示类型 1竖向 2横向',
  `url` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL COMMENT '音频',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数',
  `state` tinyint(4) DEFAULT '0',
  `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在首页',
  `show_task` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在任务',
  `publish_time` int(11) DEFAULT NULL COMMENT '发布时间',
  `add_time` int(11) DEFAULT NULL,
  `tg_time` int(11) DEFAULT NULL,
  `jj_time` int(11) DEFAULT NULL,
  `icon_vertical` varchar(255) DEFAULT NULL COMMENT '竖向图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_bargainrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_bargainrecord`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_bargainrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `bargain_openid` varchar(60) DEFAULT NULL COMMENT '砍价用户',
  `bargain_score` int(11) DEFAULT NULL COMMENT '砍价积分',
  `add_time` int(11) DEFAULT NULL COMMENT '砍价时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='砍价记录';

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_customize
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_customize`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_customize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2营销案图标 3底部图标',
  `title` varchar(255) DEFAULT NULL COMMENT '标题名称',
  `pic` varchar(200) DEFAULT NULL COMMENT '图标图片',
  `clickago_icon` varchar(200) DEFAULT NULL COMMENT '点击前图标',
  `clickafter_icon` varchar(200) DEFAULT NULL COMMENT '点击后图标',
  `url_type` tinyint(4) DEFAULT NULL COMMENT '链接类型 1基本 2商品分类',
  `url` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `url_name` varchar(50) DEFAULT NULL COMMENT '链接名称',
  `sort` tinyint(4) DEFAULT NULL COMMENT '排序 越大越前',
  `add_time` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='自定义';

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_goods`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `lid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1积分商品 2抽奖商品',
  `title` varchar(200) DEFAULT NULL COMMENT '商品名',
  `pic` varchar(200) DEFAULT NULL COMMENT '展示图',
  `lb_pics` text COMMENT '轮播图',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '价值',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '价值总积分',
  `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '可砍积分',
  `min_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最小积分',
  `max_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最大积分',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `sale_num` int(11) NOT NULL DEFAULT '0' COMMENT '已兑换',
  `begin_time` int(11) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `content` text COMMENT '详情',
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='积分商城商品表';

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_lotteryprize
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_lotteryprize`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_lotteryprize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型  1积分商城物品 2积分 3谢谢参与',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT 'type为1时 使用',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT 'type为2时使用',
  `pic` varchar(200) DEFAULT NULL,
  `rate` int(11) NOT NULL DEFAULT '0' COMMENT '中奖概率',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '奖品数量',
  `zj_num` int(11) NOT NULL DEFAULT '0' COMMENT '中奖数量',
  `add_time` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='奖品';

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_order`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `lid` int(11) NOT NULL DEFAULT '0' COMMENT '1积分商城订单 2抽奖订单',
  `openid` varchar(60) DEFAULT NULL,
  `orderformid` varchar(60) DEFAULT NULL COMMENT '订单号',
  `gid` int(11) DEFAULT NULL,
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `order_score` int(11) NOT NULL DEFAULT '0' COMMENT '消费的积分(兑换的积分)',
  `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '砍价多少积分',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '兑换状态 支付状态 1支付兑换',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未兑换  1已支付(待发货) 3完成',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `wc_time` int(11) DEFAULT NULL COMMENT '完成时间',
  `fahuo_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `add_time` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `province` varchar(60) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `zip` varchar(60) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `postalcode` varchar(20) DEFAULT NULL,
  `express_delivery` varchar(60) DEFAULT NULL COMMENT '物流公司',
  `express_no` varchar(60) DEFAULT NULL COMMENT '物流单号',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `lottery_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型1积分商品实物 2积分 ',
  `lotteryprize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_readrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_readrecord`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_readrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '类型 1文章阅读记录  2文章马克记录 3邀请阅读记录 4邀请新用户记录',
  `article_id` int(11) DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `invited_openid` varchar(60) DEFAULT NULL COMMENT '邀请用户',
  `is_mark` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1收藏 0取消收藏',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COMMENT='阅读记录';

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_system`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(100) NOT NULL COMMENT 'appid',
  `appsecret` varchar(200) NOT NULL COMMENT 'appsecret',
  `mchid` varchar(20) NOT NULL COMMENT '商户号',
  `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥',
  `uniacid` varchar(50) NOT NULL,
  `url_name` varchar(20) NOT NULL COMMENT '网址名称',
  `details` text NOT NULL COMMENT '关于我们',
  `url_logo` varchar(100) NOT NULL COMMENT '网址logo',
  `bq_name` varchar(50) NOT NULL COMMENT '版权名称',
  `link_name` varchar(30) NOT NULL COMMENT '网站名称',
  `link_logo` varchar(100) NOT NULL COMMENT '网站logo',
  `support` varchar(20) NOT NULL COMMENT '技术支持',
  `bq_logo` varchar(100) NOT NULL,
  `fontcolor` varchar(20) DEFAULT NULL,
  `color` varchar(20) NOT NULL,
  `tz_appid` varchar(30) NOT NULL,
  `tz_name` varchar(30) NOT NULL,
  `pt_name` varchar(30) NOT NULL COMMENT '平台名称',
  `tz_audit` int(11) NOT NULL COMMENT '帖子审核1.是 2否',
  `sj_audit` int(11) NOT NULL COMMENT '商家审核1.是 2否',
  `mapkey` varchar(200) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `gd_key` varchar(100) NOT NULL,
  `hb_sxf` int(11) NOT NULL,
  `tx_money` decimal(10,2) NOT NULL,
  `tx_sxf` int(11) NOT NULL,
  `tx_details` text NOT NULL,
  `rz_xuz` text NOT NULL,
  `ft_xuz` text NOT NULL,
  `fx_money` decimal(10,2) NOT NULL,
  `is_hhr` int(4) NOT NULL DEFAULT '2',
  `is_hbfl` int(4) NOT NULL DEFAULT '2',
  `is_zx` int(4) NOT NULL DEFAULT '2',
  `is_car` int(4) NOT NULL,
  `pc_xuz` text NOT NULL,
  `pc_money` decimal(10,2) NOT NULL,
  `is_sjrz` int(4) NOT NULL,
  `is_pcfw` int(4) NOT NULL,
  `total_num` int(11) NOT NULL,
  `is_goods` int(4) NOT NULL,
  `apiclient_cert` text NOT NULL,
  `apiclient_key` text NOT NULL,
  `is_openzx` int(4) NOT NULL,
  `is_hyset` int(4) NOT NULL,
  `is_tzopen` int(4) NOT NULL,
  `is_pageopen` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `is_tel` int(4) NOT NULL,
  `tx_mode` int(4) NOT NULL DEFAULT '1',
  `many_city` int(4) NOT NULL DEFAULT '2',
  `tx_type` int(4) NOT NULL DEFAULT '2',
  `is_hbzf` int(4) NOT NULL DEFAULT '1',
  `hb_img` varchar(100) NOT NULL,
  `tz_num` int(11) NOT NULL,
  `client_ip` varchar(30) NOT NULL,
  `hb_content` varchar(100) NOT NULL,
  `is_vipcardopen` int(4) NOT NULL DEFAULT '1',
  `is_jkopen` int(4) NOT NULL DEFAULT '1',
  `address` varchar(150) DEFAULT NULL COMMENT '店铺地址',
  `sj_ruzhu` int(5) DEFAULT NULL COMMENT '0为关闭1为开启',
  `is_kanjiaopen` int(4) DEFAULT '0' COMMENT '0关闭1开启',
  `bargain_price` varchar(10) DEFAULT NULL COMMENT '每次砍价的%',
  `sign` varchar(12) DEFAULT NULL COMMENT '本店招牌自定义',
  `bargain_title` varchar(15) DEFAULT NULL COMMENT '砍价分享标题',
  `is_pintuanopen` int(4) DEFAULT NULL COMMENT '2为关闭1为开启',
  `refund` int(4) DEFAULT '1' COMMENT '1为买家申请2为自动退款',
  `refund_time` int(4) DEFAULT '0' COMMENT '自动退款时间 1为24；2为48；3为72；4为活动结束；5为不退款',
  `groups_title` varchar(45) DEFAULT NULL COMMENT '拼团分享标题',
  `mask` int(2) DEFAULT '1' COMMENT '0不显示1显示',
  `announcement` varchar(60) DEFAULT NULL COMMENT '首页公告',
  `shopmsg_status` tinyint(1) DEFAULT NULL COMMENT '欢迎语开关',
  `shopmsg` varchar(60) DEFAULT NULL COMMENT '欢迎语',
  `shopmsg2` varchar(60) DEFAULT NULL COMMENT '问题咨询',
  `shopmsg_img` varchar(200) DEFAULT NULL COMMENT '欢迎头像',
  `is_yuyueopen` int(4) DEFAULT NULL COMMENT '开启预约 1开启 2禁用',
  `yuyue_title` varchar(60) DEFAULT NULL COMMENT '预约分享标题',
  `is_haowuopen` int(4) DEFAULT NULL COMMENT '开启好物',
  `haowu_title` varchar(60) DEFAULT NULL COMMENT '好物分享标题',
  `is_couponopen` int(4) DEFAULT NULL COMMENT '开启优惠券 1开启 2禁用',
  `coupon_title` varchar(60) DEFAULT NULL COMMENT '分享优惠券标题',
  `coupon_banner` varchar(200) DEFAULT NULL COMMENT '优惠券banner',
  `is_gywmopen` int(4) DEFAULT NULL COMMENT '开启关于我们',
  `gywm_title` varchar(60) DEFAULT NULL COMMENT '分享关于我们标题',
  `is_xianshigouopen` int(4) DEFAULT NULL COMMENT '开启限时购 1开启 ',
  `xianshigou_title` varchar(60) DEFAULT NULL COMMENT '分享限时购标题',
  `is_shareopen` int(4) DEFAULT NULL COMMENT '开启分享 1开启',
  `share_title` varchar(60) DEFAULT NULL COMMENT '分享分享标题',
  `customer_time` varchar(30) DEFAULT NULL COMMENT '客服时间',
  `provide` varchar(255) DEFAULT NULL COMMENT '基础服务',
  `shop_banner` text COMMENT '商店banner',
  `shop_details` text COMMENT '商店介绍',
  `gywm_banner` varchar(200) DEFAULT NULL COMMENT '关于我们banner',
  `shopdes` text COMMENT '商店介绍 详情',
  `shopdes_img` text COMMENT '商店介绍图',
  `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费',
  `ziti_address` varchar(200) DEFAULT NULL COMMENT '商家自提地址',
  `ddmd_img` varchar(100) DEFAULT NULL COMMENT '到店买单头像',
  `ddmd_title` varchar(100) DEFAULT NULL COMMENT '到店买单商户名称',
  `hx_openid` text COMMENT '核销人员openid',
  `tag` varchar(200) DEFAULT NULL COMMENT '店铺标签',
  `is_by` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否全店包邮',
  `is_xxpf` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否先行赔付',
  `is_qtwy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否七天无忧退款退货',
  `yuyue_sort` int(11) NOT NULL DEFAULT '0' COMMENT '预约 首页推荐排序',
  `haowu_sort` int(11) NOT NULL DEFAULT '0' COMMENT '好物 首页推荐排序',
  `groups_sort` int(11) NOT NULL DEFAULT '0' COMMENT '拼团 首页推荐排序',
  `bargain_sort` int(11) NOT NULL DEFAULT '0' COMMENT '砍价 首页推荐排序',
  `xianshigou_sort` int(11) NOT NULL DEFAULT '0' COMMENT '限时购首页推荐 排序',
  `share_sort` int(11) NOT NULL DEFAULT '0' COMMENT '分享首页推荐排序',
  `xinpin_sort` int(11) NOT NULL DEFAULT '0' COMMENT '新品 首页推荐排序',
  `index_adv_img` varchar(100) DEFAULT NULL COMMENT '首页广告图',
  `is_adv` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启首页广告 1开启',
  `share_rule` text COMMENT '分享金规则',
  `groups_rule` text COMMENT '拼团规则说明',
  `coordinates` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `index_title` varchar(60) DEFAULT NULL COMMENT '首页自定义标题',
  `hz_tel` varchar(60) DEFAULT NULL COMMENT '首页合作电话',
  `jszc_img` varchar(200) DEFAULT NULL COMMENT '技术支持头像',
  `jszc_tdcp` varchar(200) DEFAULT NULL COMMENT '首页技术支持团队出品',
  `index_layout` text COMMENT '首页布局',
  `is_layout` tinyint(4) DEFAULT '0' COMMENT '首页布局开关 1开',
  `is_techzhichi` tinyint(4) NOT NULL DEFAULT '1',
  `store_open` tinyint(4) NOT NULL DEFAULT '1',
  `lottery_score` int(11) NOT NULL DEFAULT '0' COMMENT '抽奖消费积分',
  `lottery_rule` text COMMENT '抽奖规则',
  `aboutus` text COMMENT '关于我们',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_task
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_task`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '任务类型 1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖 6马克 7邀请好友',
  `title` varchar(60) DEFAULT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `task_num` int(11) NOT NULL DEFAULT '1' COMMENT '任务数',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '积分完成一个任务得到积分',
  `task_score` int(11) NOT NULL DEFAULT '0' COMMENT '任务页面显示积分',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='任务表';

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_taskrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_taskrecord`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_taskrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL COMMENT '用户openid(获得积分的用户)',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖(增加) 6马克 7邀请新用户 8兑换积分商品 9积分抽奖(消耗) 10抽奖中奖积分',
  `task_id` int(11) NOT NULL DEFAULT '0',
  `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '获得积分',
  `date` varchar(20) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL COMMENT '文章id 阅读和邀请看文章使用 马克',
  `beinvited_openid` varchar(60) DEFAULT NULL COMMENT '被邀请用户openid 邀请看文章使用 、好友砍积分使用、新用户',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品id 砍价积分商品使用 ',
  `prize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8 COMMENT='任务积分记录表 ';

-- ----------------------------
-- Table structure for ims_yzqzk_sun_plugin_scoretask_taskset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_plugin_scoretask_taskset`;
CREATE TABLE `ims_yzqzk_sun_plugin_scoretask_taskset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `task_type` tinyint(4) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='任务积分设置';

-- ----------------------------
-- Table structure for ims_yzqzk_sun_privilege_identifier
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_privilege_identifier`;
CREATE TABLE `ims_yzqzk_sun_privilege_identifier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_punch
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_punch`;
CREATE TABLE `ims_yzqzk_sun_punch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `remark` text,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_punch_prize
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_punch_prize`;
CREATE TABLE `ims_yzqzk_sun_punch_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `punch_id` int(11) DEFAULT NULL,
  `task_day_id` tinyint(4) NOT NULL,
  `prize_day` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_punch_receive_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_punch_receive_record`;
CREATE TABLE `ims_yzqzk_sun_punch_receive_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `prize_id` int(11) DEFAULT NULL,
  `day_num` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `user_coupon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_punch_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_punch_record`;
CREATE TABLE `ims_yzqzk_sun_punch_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `month` varchar(10) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `punch_date` varchar(20) DEFAULT NULL,
  `punch_diary` text,
  `punch_pic` text,
  `coupon_id` int(11) NOT NULL,
  `user_coupon_id` int(11) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_punch_task
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_punch_task`;
CREATE TABLE `ims_yzqzk_sun_punch_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `punch_id` int(11) DEFAULT NULL,
  `task_day_id` tinyint(4) DEFAULT NULL,
  `baby_id` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `content` text,
  `pic` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `add_time_d` varchar(20) DEFAULT NULL,
  `task_num` int(11) DEFAULT NULL,
  `wc_num` int(11) NOT NULL,
  `is_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_settings
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_settings`;
CREATE TABLE `ims_yzqzk_sun_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `background` varchar(200) DEFAULT NULL,
  `weblogo` varchar(200) DEFAULT NULL,
  `kkxf_background` varchar(200) DEFAULT NULL,
  `privilege` text,
  `rule` text,
  `old_price` decimal(10,2) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  `privilege_title` varchar(100) DEFAULT NULL,
  `privilege_info` varchar(100) DEFAULT NULL,
  `bg` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_share
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_share`;
CREATE TABLE `ims_yzqzk_sun_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_shop_car
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_shop_car`;
CREATE TABLE `ims_yzqzk_sun_shop_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `combine` varchar(110) NOT NULL,
  `spec_value` varchar(30) NOT NULL,
  `spec_value1` varchar(30) NOT NULL,
  `gname` varchar(55) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `pic` varchar(110) NOT NULL,
  `uid` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_sms
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_sms`;
CREATE TABLE `ims_yzqzk_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(100) NOT NULL,
  `tpl_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL,
  `tid1` varchar(50) NOT NULL,
  `tid2` varchar(50) NOT NULL,
  `tid3` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_spec_value
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_spec_value`;
CREATE TABLE `ims_yzqzk_sun_spec_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_store
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_store`;
CREATE TABLE `ims_yzqzk_sun_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_name` varchar(100) DEFAULT NULL,
  `tel` varchar(60) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  `rz_time` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `syrq` varchar(100) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `coordinates` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `starttime` varchar(20) DEFAULT NULL,
  `endtime` varchar(20) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `content` text,
  `pic` varchar(200) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `rz_end_time` int(11) DEFAULT NULL,
  `rz_status` tinyint(4) NOT NULL,
  `pay_status` tinyint(4) NOT NULL,
  `storelimit_id` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `ptcc_rate` float(11,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_store_active
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_store_active`;
CREATE TABLE `ims_yzqzk_sun_store_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) DEFAULT NULL,
  `store_name` varchar(45) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `dq_time` int(15) DEFAULT NULL,
  `time_type` int(11) DEFAULT NULL,
  `active_type` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `uniacid` int(45) DEFAULT NULL,
  `time_over` int(15) DEFAULT NULL,
  `rz_time` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_store_category
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_store_category`;
CREATE TABLE `ims_yzqzk_sun_store_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_store_district
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_store_district`;
CREATE TABLE `ims_yzqzk_sun_store_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_store_rz_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_store_rz_record`;
CREATE TABLE `ims_yzqzk_sun_store_rz_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `begin_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `storelimit_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_store_wallet
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_store_wallet`;
CREATE TABLE `ims_yzqzk_sun_store_wallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `note` varchar(20) NOT NULL,
  `type` int(11) NOT NULL,
  `time` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_store1
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_store1`;
CREATE TABLE `ims_yzqzk_sun_store1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `store_name` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `announcement` varchar(100) NOT NULL,
  `storetype_id` int(11) NOT NULL,
  `storetype2_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `yy_time` varchar(50) NOT NULL,
  `keyword` varchar(50) NOT NULL,
  `skzf` int(11) NOT NULL,
  `wifi` int(11) NOT NULL,
  `mftc` int(11) NOT NULL,
  `jzxy` int(11) NOT NULL,
  `tgbj` int(11) NOT NULL,
  `sfxx` int(11) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `weixin_logo` varchar(100) NOT NULL,
  `ad` text NOT NULL,
  `state` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `password` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `coordinates` varchar(50) NOT NULL,
  `views` int(11) NOT NULL,
  `score` decimal(10,1) NOT NULL,
  `type` int(11) NOT NULL,
  `sh_time` int(11) NOT NULL,
  `time_over` int(11) NOT NULL,
  `img` text NOT NULL,
  `vr_link` text NOT NULL,
  `num` int(11) NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `wallet` decimal(10,2) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `dq_time` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `fx_num` int(11) NOT NULL,
  `ewm_logo` varchar(100) NOT NULL,
  `is_top` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_storein
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_storein`;
CREATE TABLE `ims_yzqzk_sun_storein` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_storelimit
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_storelimit`;
CREATE TABLE `ims_yzqzk_sun_storelimit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lt_id` int(11) NOT NULL,
  `lt_name` varchar(30) NOT NULL,
  `lt_day` int(5) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `sort` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_storepaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_storepaylog`;
CREATE TABLE `ims_yzqzk_sun_storepaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_storetype
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_storetype`;
CREATE TABLE `ims_yzqzk_sun_storetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL,
  `img` varchar(100) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_storetype2
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_storetype2`;
CREATE TABLE `ims_yzqzk_sun_storetype2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `type_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `state` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_story
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_story`;
CREATE TABLE `ims_yzqzk_sun_story` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `pic_bg` varchar(200) DEFAULT NULL,
  `pic_open` varchar(200) DEFAULT NULL,
  `file_path` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `is_album` tinyint(4) NOT NULL,
  `show_index` tinyint(4) NOT NULL,
  `show_st` tinyint(4) NOT NULL,
  `is_vip` tinyint(4) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `tg_time` int(11) DEFAULT NULL,
  `jj_time` int(11) DEFAULT NULL,
  `access_num` int(11) NOT NULL,
  `duration` varchar(30) DEFAULT NULL,
  `file_link` varchar(250) DEFAULT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_story_album
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_story_album`;
CREATE TABLE `ims_yzqzk_sun_story_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `banner` varchar(200) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `show_index` tinyint(4) NOT NULL,
  `show_st` tinyint(4) NOT NULL,
  `is_vip` tinyint(4) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  `access_num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_story_category
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_story_category`;
CREATE TABLE `ims_yzqzk_sun_story_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_story_collection
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_story_collection`;
CREATE TABLE `ims_yzqzk_sun_story_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `story_id` int(11) DEFAULT NULL,
  `collect_status` tinyint(4) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_system`;
CREATE TABLE `ims_yzqzk_sun_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(100) NOT NULL,
  `appsecret` varchar(200) NOT NULL,
  `mchid` varchar(20) NOT NULL,
  `wxkey` varchar(100) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `url_name` varchar(20) NOT NULL,
  `details` text NOT NULL,
  `url_logo` varchar(100) NOT NULL,
  `bq_name` varchar(50) NOT NULL,
  `link_name` varchar(30) NOT NULL,
  `link_logo` varchar(100) NOT NULL,
  `support` varchar(20) NOT NULL,
  `bq_logo` varchar(100) NOT NULL,
  `fontcolor` varchar(20) DEFAULT NULL,
  `color` varchar(20) NOT NULL,
  `tz_appid` varchar(30) NOT NULL,
  `tz_name` varchar(30) NOT NULL,
  `pt_name` varchar(30) NOT NULL,
  `tz_audit` int(11) NOT NULL,
  `sj_audit` int(11) NOT NULL,
  `mapkey` varchar(200) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `gd_key` varchar(100) NOT NULL,
  `hb_sxf` int(11) NOT NULL,
  `tx_money` decimal(10,2) NOT NULL,
  `tx_sxf` int(11) NOT NULL,
  `tx_details` text NOT NULL,
  `rz_xuz` text NOT NULL,
  `ft_xuz` text NOT NULL,
  `fx_money` decimal(10,2) NOT NULL,
  `is_hhr` int(4) NOT NULL,
  `is_hbfl` int(4) NOT NULL,
  `is_zx` int(4) NOT NULL,
  `is_car` int(4) NOT NULL,
  `pc_xuz` text NOT NULL,
  `pc_money` decimal(10,2) NOT NULL,
  `is_sjrz` int(4) NOT NULL,
  `is_pcfw` int(4) NOT NULL,
  `total_num` int(11) NOT NULL,
  `is_goods` int(4) NOT NULL,
  `apiclient_cert` text NOT NULL,
  `apiclient_key` text NOT NULL,
  `is_openzx` int(4) NOT NULL,
  `is_hyset` int(4) NOT NULL,
  `is_tzopen` int(4) NOT NULL,
  `is_pageopen` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `is_tel` int(4) NOT NULL,
  `tx_mode` int(4) NOT NULL,
  `many_city` int(4) NOT NULL,
  `tx_type` int(4) NOT NULL,
  `is_hbzf` int(4) NOT NULL,
  `hb_img` varchar(100) NOT NULL,
  `tz_num` int(11) NOT NULL,
  `client_ip` varchar(30) NOT NULL,
  `hb_content` varchar(100) NOT NULL,
  `is_vipcardopen` int(4) NOT NULL,
  `is_jkopen` int(4) NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `sj_ruzhu` int(5) DEFAULT NULL,
  `is_kanjiaopen` int(4) DEFAULT NULL,
  `bargain_price` varchar(10) DEFAULT NULL,
  `sign` varchar(12) DEFAULT NULL,
  `bargain_title` varchar(15) DEFAULT NULL,
  `is_pintuanopen` int(4) DEFAULT NULL,
  `refund` int(4) DEFAULT NULL,
  `refund_time` int(4) DEFAULT NULL,
  `groups_title` varchar(45) DEFAULT NULL,
  `mask` int(2) DEFAULT NULL,
  `announcement` varchar(60) DEFAULT NULL,
  `shopmsg_status` tinyint(1) DEFAULT NULL,
  `shopmsg` varchar(60) DEFAULT NULL,
  `shopmsg2` varchar(60) DEFAULT NULL,
  `shopmsg_img` varchar(200) DEFAULT NULL,
  `is_yuyueopen` int(4) DEFAULT NULL,
  `yuyue_title` varchar(60) DEFAULT NULL,
  `is_haowuopen` int(4) DEFAULT NULL,
  `haowu_title` varchar(60) DEFAULT NULL,
  `is_couponopen` int(4) DEFAULT NULL,
  `coupon_title` varchar(60) DEFAULT NULL,
  `coupon_banner` varchar(200) DEFAULT NULL,
  `is_gywmopen` int(4) DEFAULT NULL,
  `gywm_title` varchar(60) DEFAULT NULL,
  `is_xianshigouopen` int(4) DEFAULT NULL,
  `xianshigou_title` varchar(60) DEFAULT NULL,
  `is_shareopen` int(4) DEFAULT NULL,
  `share_title` varchar(60) DEFAULT NULL,
  `customer_time` varchar(30) DEFAULT NULL,
  `provide` varchar(255) DEFAULT NULL,
  `shop_banner` text,
  `shop_details` text,
  `gywm_banner` varchar(200) DEFAULT NULL,
  `shopdes` text,
  `shopdes_img` text,
  `distribution` decimal(10,2) NOT NULL,
  `ziti_address` varchar(200) DEFAULT NULL,
  `ddmd_img` varchar(100) DEFAULT NULL,
  `ddmd_title` varchar(100) DEFAULT NULL,
  `hx_openid` text,
  `tag` varchar(200) DEFAULT NULL,
  `is_by` tinyint(4) NOT NULL,
  `is_xxpf` tinyint(4) NOT NULL,
  `is_qtwy` tinyint(4) NOT NULL,
  `yuyue_sort` int(11) NOT NULL,
  `haowu_sort` int(11) NOT NULL,
  `groups_sort` int(11) NOT NULL,
  `bargain_sort` int(11) NOT NULL,
  `xianshigou_sort` int(11) NOT NULL,
  `share_sort` int(11) NOT NULL,
  `xinpin_sort` int(11) NOT NULL,
  `index_adv_img` varchar(100) DEFAULT NULL,
  `is_adv` tinyint(4) NOT NULL,
  `share_rule` text,
  `groups_rule` text,
  `coordinates` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `index_title` varchar(60) DEFAULT NULL,
  `hz_tel` varchar(60) DEFAULT NULL,
  `jszc_img` varchar(200) DEFAULT NULL,
  `jszc_tdcp` varchar(200) DEFAULT NULL,
  `index_layout` text,
  `is_layout` tinyint(4) DEFAULT NULL,
  `is_techzhichi` tinyint(4) NOT NULL,
  `store_open` tinyint(4) NOT NULL,
  `map_key` varchar(60) DEFAULT NULL,
  `money_rate` int(11) NOT NULL,
  `score_rate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_tab
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_tab`;
CREATE TABLE `ims_yzqzk_sun_tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `index` varchar(10) DEFAULT NULL,
  `indeximg` varchar(200) DEFAULT NULL,
  `indeximgs` varchar(200) DEFAULT NULL,
  `store` varchar(10) DEFAULT NULL,
  `storeimg` varchar(200) DEFAULT NULL,
  `storeimgs` varchar(200) DEFAULT NULL,
  `dynamic` varchar(10) DEFAULT NULL,
  `dynamicimg` varchar(200) DEFAULT NULL,
  `dynamicimgs` varchar(200) DEFAULT NULL,
  `dynamic_status` tinyint(1) DEFAULT NULL,
  `dynamic_banner` varchar(255) DEFAULT NULL,
  `cart` varchar(10) DEFAULT NULL,
  `cartimg` varchar(200) DEFAULT NULL,
  `cartimgs` varchar(200) DEFAULT NULL,
  `mine` varchar(10) DEFAULT NULL,
  `mineimg` varchar(200) DEFAULT NULL,
  `mineimgs` varchar(200) DEFAULT NULL,
  `fontcolor` varchar(10) DEFAULT NULL,
  `fontcolored` varchar(10) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_top
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_top`;
CREATE TABLE `ims_yzqzk_sun_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_type`;
CREATE TABLE `ims_yzqzk_sun_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL,
  `img` varchar(100) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_type2
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_type2`;
CREATE TABLE `ims_yzqzk_sun_type2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `type_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `state` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_tzpaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_tzpaylog`;
CREATE TABLE `ims_yzqzk_sun_tzpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tz_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user`;
CREATE TABLE `ims_yzqzk_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL,
  `img` varchar(200) NOT NULL,
  `time` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_tel` varchar(20) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `commission` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL,
  `end_time` int(11) DEFAULT NULL,
  `is_vip` tinyint(4) NOT NULL,
  `names` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `address_detail` varchar(100) DEFAULT NULL,
  `baby_id` int(11) DEFAULT NULL,
  `parents_id` int(11) DEFAULT NULL,
  `parents_name` varchar(255) DEFAULT NULL,
  `telphone` varchar(60) DEFAULT NULL,
  `integral` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_active
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_active`;
CREATE TABLE `ims_yzqzk_sun_user_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` varchar(100) NOT NULL,
  `num` int(11) DEFAULT NULL,
  `img` varchar(150) DEFAULT NULL,
  `jikanum` int(11) DEFAULT NULL,
  `active_id` int(11) DEFAULT NULL,
  `kapian_id` int(11) DEFAULT NULL,
  `sharenum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_bargain
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_bargain`;
CREATE TABLE `ims_yzqzk_sun_user_bargain` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL,
  `gid` int(11) DEFAULT NULL,
  `mch_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `price_ago` decimal(11,2) NOT NULL,
  `prices` decimal(11,2) NOT NULL,
  `kanjias` decimal(11,2) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  `prices_current` decimal(11,2) NOT NULL,
  `kanjias_current` decimal(11,2) NOT NULL,
  `lowest_price` decimal(11,2) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_coupon`;
CREATE TABLE `ims_yzqzk_sun_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` varchar(60) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) NOT NULL,
  `title` varchar(60) DEFAULT NULL,
  `sign` tinyint(4) NOT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `m_price` int(10) NOT NULL,
  `mj_price` int(10) NOT NULL,
  `lq_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `source` tinyint(1) NOT NULL,
  `is_use` tinyint(4) NOT NULL,
  `use_time` int(11) DEFAULT NULL,
  `orderformid` varchar(30) DEFAULT NULL,
  `qrcode_path` varchar(100) DEFAULT NULL,
  `hx_openid` varchar(60) DEFAULT NULL,
  `hx_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_groups
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_groups`;
CREATE TABLE `ims_yzqzk_sun_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mch_id` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `openid` varchar(100) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `num` int(11) NOT NULL,
  `buynum` int(11) NOT NULL,
  `refund_num` int(11) NOT NULL,
  `end_time` int(11) DEFAULT NULL,
  `xml` text,
  `out_refund_no` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_money_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_money_record`;
CREATE TABLE `ims_yzqzk_sun_user_money_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `sign` tinyint(4) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `user_share_record_id` int(11) DEFAULT NULL,
  `level` tinyint(4) NOT NULL,
  `orderformid` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_share
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_share`;
CREATE TABLE `ims_yzqzk_sun_user_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `gid` int(11) NOT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `p_openid` varchar(60) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_share_access_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_share_access_record`;
CREATE TABLE `ims_yzqzk_sun_user_share_access_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `head_img` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_share_goods_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_share_goods_record`;
CREATE TABLE `ims_yzqzk_sun_user_share_goods_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `acc_openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_share_join
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_share_join`;
CREATE TABLE `ims_yzqzk_sun_user_share_join` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_share_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_share_record`;
CREATE TABLE `ims_yzqzk_sun_user_share_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `first_openid` varchar(60) DEFAULT NULL,
  `first_money` decimal(10,2) NOT NULL,
  `second_openid` varchar(60) DEFAULT NULL,
  `second_money` decimal(10,2) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_user_vipcard
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_user_vipcard`;
CREATE TABLE `ims_yzqzk_sun_user_vipcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` text NOT NULL,
  `vipcard_id` int(11) NOT NULL,
  `card_number` varchar(45) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_userformid
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_userformid`;
CREATE TABLE `ims_yzqzk_sun_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `form_id` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_userinfo`;
CREATE TABLE `ims_yzqzk_sun_userinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` varchar(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `tel` varchar(60) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `status` tinyint(10) DEFAULT NULL,
  `nickName` varchar(60) DEFAULT NULL,
  `avatarUrl` varchar(200) DEFAULT NULL,
  `fromuid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_vip_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_vip_record`;
CREATE TABLE `ims_yzqzk_sun_vip_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `begin_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  `activationcode_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_vipcard
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_vipcard`;
CREATE TABLE `ims_yzqzk_sun_vipcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `img` varchar(100) NOT NULL,
  `price` varchar(45) NOT NULL,
  `desc` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `discount` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_withdraw`;
CREATE TABLE `ims_yzqzk_sun_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `wd_type` tinyint(4) DEFAULT NULL,
  `wd_account` varchar(100) DEFAULT NULL,
  `wd_name` varchar(255) DEFAULT NULL,
  `wd_phone` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `realmoney` decimal(10,2) NOT NULL,
  `paycommission` decimal(10,2) NOT NULL,
  `ratesmoney` decimal(10,2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `store_name` varchar(100) DEFAULT NULL,
  `baowen` text,
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  `is_state` tinyint(4) NOT NULL,
  `err_code` varchar(50) DEFAULT NULL,
  `err_code_des` varchar(200) DEFAULT NULL,
  `tx_time` int(11) DEFAULT NULL,
  `request_time` int(11) DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL,
  `review_time` int(11) DEFAULT NULL,
  `return_status` tinyint(4) NOT NULL,
  `return_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_withdraw_baowen
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_withdraw_baowen`;
CREATE TABLE `ims_yzqzk_sun_withdraw_baowen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `baowen` text,
  `wd_id` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `request_data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_withdrawal
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_withdrawal`;
CREATE TABLE `ims_yzqzk_sun_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `sh_time` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `tx_cost` decimal(10,2) NOT NULL,
  `sj_cost` decimal(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `method` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_withdrawset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_withdrawset`;
CREATE TABLE `ims_yzqzk_sun_withdrawset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `wd_type` varchar(255) NOT NULL,
  `min_money` decimal(10,2) NOT NULL,
  `avoidmoney` decimal(10,2) NOT NULL,
  `is_open` tinyint(4) NOT NULL,
  `cms_rates` float NOT NULL,
  `wd_wxrates` float NOT NULL,
  `wd_content` text,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_yellowpaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_yellowpaylog`;
CREATE TABLE `ims_yzqzk_sun_yellowpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hy_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_yellowset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_yellowset`;
CREATE TABLE `ims_yzqzk_sun_yellowset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_yellowstore
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_yellowstore`;
CREATE TABLE `ims_yzqzk_sun_yellowstore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_address` varchar(200) NOT NULL,
  `type_id` int(11) NOT NULL,
  `link_tel` varchar(20) NOT NULL,
  `sort` int(11) NOT NULL,
  `rz_time` int(11) NOT NULL,
  `sh_time` int(11) NOT NULL,
  `state` int(4) NOT NULL,
  `rz_type` int(4) NOT NULL,
  `time_over` int(4) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `coordinates` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `imgs` varchar(500) NOT NULL,
  `views` int(11) NOT NULL,
  `tel2` varchar(20) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `dq_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_yingxiao
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_yingxiao`;
CREATE TABLE `ims_yzqzk_sun_yingxiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yuyue` varchar(45) DEFAULT NULL,
  `yyimg` varchar(150) DEFAULT NULL,
  `haowu` varchar(45) DEFAULT NULL,
  `hwimg` varchar(150) DEFAULT NULL,
  `youhuiquan` varchar(45) DEFAULT NULL,
  `yhqimg` varchar(150) DEFAULT NULL,
  `guanyuwomen` varchar(45) DEFAULT NULL,
  `gywmimg` varchar(150) DEFAULT NULL,
  `pintuan` varchar(45) DEFAULT NULL,
  `ptimg` varchar(150) DEFAULT NULL,
  `kanjia` varchar(45) DEFAULT NULL,
  `kjimg` varchar(150) DEFAULT NULL,
  `xianshigou` varchar(45) DEFAULT NULL,
  `xsgimg` varchar(150) DEFAULT NULL,
  `fenxiang` varchar(45) DEFAULT NULL,
  `fximg` varchar(150) DEFAULT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_yjset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_yjset`;
CREATE TABLE `ims_yzqzk_sun_yjset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(4) NOT NULL,
  `typer` varchar(10) NOT NULL,
  `sjper` varchar(10) NOT NULL,
  `hyper` varchar(10) NOT NULL,
  `pcper` varchar(10) NOT NULL,
  `tzper` varchar(10) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_yjtx
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_yjtx`;
CREATE TABLE `ims_yzqzk_sun_yjtx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `tx_type` int(4) NOT NULL,
  `tx_cost` decimal(10,2) NOT NULL,
  `status` int(4) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `cerated_time` datetime NOT NULL,
  `sj_cost` decimal(10,2) NOT NULL,
  `account` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `sx_cost` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `is_del` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_zx
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_zx`;
CREATE TABLE `ims_yzqzk_sun_zx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  `yd_num` int(11) NOT NULL,
  `pl_num` int(11) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `imgs` text NOT NULL,
  `state` int(4) NOT NULL,
  `sh_time` datetime NOT NULL,
  `type` int(4) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `jianjie` varchar(50) DEFAULT NULL,
  `indeximg` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_zx_assess
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_zx_assess`;
CREATE TABLE `ims_yzqzk_sun_zx_assess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zx_id` int(4) NOT NULL,
  `score` int(11) NOT NULL,
  `content` text NOT NULL,
  `img` varchar(500) NOT NULL,
  `cerated_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `status` int(4) NOT NULL,
  `reply` text NOT NULL,
  `reply_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_zx_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_zx_type`;
CREATE TABLE `ims_yzqzk_sun_zx_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `sort` int(4) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzqzk_sun_zx_zj
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzqzk_sun_zx_zj`;
CREATE TABLE `ims_yzqzk_sun_zx_zj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zx_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
