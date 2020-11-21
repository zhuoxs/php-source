/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-09 13:12:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_acode
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_acode`;
CREATE TABLE `ims_yzhyk_sun_acode` (
  `id` int(11) NOT NULL COMMENT '该id不自动增加',
  `time` varchar(30) NOT NULL COMMENT '时间',
  `code` text NOT NULL COMMENT '码',
  `url` varchar(255) NOT NULL,
  `uncode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_activity
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_activity`;
CREATE TABLE `ims_yzhyk_sun_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `update_time` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_activitygoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_activitygoods`;
CREATE TABLE `ims_yzhyk_sun_activitygoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `limit` int(11) DEFAULT NULL COMMENT '限购数量',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=706 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_admin
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_admin`;
CREATE TABLE `ims_yzhyk_sun_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_appmenu
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_appmenu`;
CREATE TABLE `ims_yzhyk_sun_appmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `page` varchar(100) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `appmenu_index` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_bill
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_bill`;
CREATE TABLE `ims_yzhyk_sun_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `content` varchar(100) DEFAULT NULL COMMENT 'openid',
  `time` varchar(50) DEFAULT NULL COMMENT '登录时间',
  `type` int(1) DEFAULT NULL COMMENT '1、线上支付\r\n2、扫码购\r\n3、商城\r\n4、兑换余额\r\n5、充值',
  `user_id` int(11) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=924 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_button
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_button`;
CREATE TABLE `ims_yzhyk_sun_button` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_cardlevel
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_cardlevel`;
CREATE TABLE `ims_yzhyk_sun_cardlevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_city
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_city`;
CREATE TABLE `ims_yzhyk_sun_city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_config
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_config`;
CREATE TABLE `ims_yzhyk_sun_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `key` varchar(50) DEFAULT NULL COMMENT '关键字',
  `value` varchar(250) DEFAULT NULL COMMENT '值',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='配置信息';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_county
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_county`;
CREATE TABLE `ims_yzhyk_sun_county` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_coupon`;
CREATE TABLE `ims_yzhyk_sun_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `left_num` int(11) DEFAULT NULL COMMENT '余量',
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `use_amount` int(4) DEFAULT NULL COMMENT '启用金额',
  `amount` int(4) DEFAULT NULL,
  `isvip` int(4) DEFAULT '0',
  `days` int(11) DEFAULT NULL COMMENT '有效天数',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_cut
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_cut`;
CREATE TABLE `ims_yzhyk_sun_cut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `storecutgoods_id` int(11) DEFAULT NULL,
  `end_time` varchar(50) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `state` int(1) DEFAULT NULL COMMENT '-1：取消，0：砍价中，1：已完成',
  `cutgoods_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `shop_price` decimal(10,2) DEFAULT NULL,
  `cut_price` decimal(10,2) DEFAULT NULL,
  `cut_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_cutgoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_cutgoods`;
CREATE TABLE `ims_yzhyk_sun_cutgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `pics` varchar(400) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `content` text CHARACTER SET gbk,
  `uniacid` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `useful_hour` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_cutuser
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_cutuser`;
CREATE TABLE `ims_yzhyk_sun_cutuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cut_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `cut_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_distribution_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_distribution_order`;
CREATE TABLE `ims_yzhyk_sun_distribution_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ordertype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类别，1普通，2砍价，3拼团，4抢购，5预约',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '3级id',
  `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  `rebate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自购，0否，1是',
  `user_id` int(11) NOT NULL COMMENT '购买用户id',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（用来识别是否计入可提现佣金），0未，1删',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_distribution_promoter
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_distribution_promoter`;
CREATE TABLE `ims_yzhyk_sun_distribution_promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `mobilephone` varchar(30) NOT NULL COMMENT '手机号',
  `allcommission` decimal(10,2) NOT NULL COMMENT '累计佣金',
  `canwithdraw` decimal(10,2) NOT NULL COMMENT '可提现佣金',
  `referrer_name` varchar(100) NOT NULL COMMENT '推荐人',
  `referrer_uid` int(11) NOT NULL COMMENT '推荐人id',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态，0审核中，1通过，2拒绝',
  `addtime` int(11) NOT NULL COMMENT '申请时间',
  `checktime` int(11) NOT NULL COMMENT '审核时间',
  `meno` text NOT NULL COMMENT '备注',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id，发模板消息',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现冻结的金额',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `code_img` mediumblob NOT NULL COMMENT '小程序码',
  `invitation_code` varchar(20) NOT NULL COMMENT '邀请码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_distribution_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_distribution_set`;
CREATE TABLE `ims_yzhyk_sun_distribution_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销层级,0不开启，1一级，2二级',
  `is_buyself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销内购，0关闭，1开启',
  `lower_condition` tinyint(1) NOT NULL DEFAULT '0' COMMENT '成为下线条件，0首次点击链接',
  `share_condition` tinyint(3) NOT NULL DEFAULT '0' COMMENT '成为分销商条件，0无条件但要审核，1申请审核，2不需要审核',
  `autoshare` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费自动成为分销商',
  `withdrawtype` varchar(100) NOT NULL COMMENT '提现方式,1微信支付,2支付宝支付,3银行卡支付,4余额支付',
  `minwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度',
  `daymaxwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限',
  `withdrawnotice` text NOT NULL COMMENT '用户提现须知',
  `tpl_wd_arrival` varchar(255) NOT NULL COMMENT '提现到账模板消息id',
  `tpl_wd_fail` varchar(255) NOT NULL COMMENT '提现失败模板消息id',
  `tpl_share_check` varchar(255) NOT NULL COMMENT '分销审核模板消息id',
  `application` text NOT NULL COMMENT '申请协议',
  `applybanner` varchar(255) NOT NULL COMMENT '申请页面banner',
  `checkbanner` varchar(255) NOT NULL COMMENT '待审核页面banner',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `commissiontype` tinyint(3) NOT NULL DEFAULT '1' COMMENT '分销佣金类型，1百分比，2固定金额',
  `firstname` varchar(255) NOT NULL COMMENT '一级名称',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额',
  `secondname` varchar(255) NOT NULL COMMENT '二级名称',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额',
  `withdrawhandingfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费',
  `thirdname` varchar(50) NOT NULL COMMENT '第三级名称',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '第三级佣金',
  `postertoppic` varchar(255) NOT NULL COMMENT '海报图',
  `postertoptitle` varchar(200) NOT NULL COMMENT '海报标题',
  `is_offline` tinyint(1) NOT NULL DEFAULT '0' COMMENT '线下付是否开启分销，0关闭，1开启',
  `dsource` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销佣金来源 0 平台 1 商家',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_distribution_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_distribution_withdraw`;
CREATE TABLE `ims_yzhyk_sun_distribution_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `uname` varchar(255) NOT NULL COMMENT '姓名',
  `account` varchar(20) NOT NULL COMMENT '提现账号',
  `bank` varchar(50) NOT NULL COMMENT '所属银行',
  `withdrawaltype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现方式，1微信，2支付宝，3银行卡，4余额',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现状态，0待打款，1已经打款，2拒绝',
  `time` int(11) NOT NULL COMMENT '时间',
  `mobilephone` varchar(30) NOT NULL COMMENT '手机号',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `meno` text NOT NULL COMMENT '备注',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_eatvisit_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_eatvisit_goods`;
CREATE TABLE `ims_yzhyk_sun_eatvisit_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(255) NOT NULL COMMENT '商品名称',
  `shopprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `thumbnail` varchar(200) NOT NULL COMMENT '缩略图',
  `tid` int(11) NOT NULL DEFAULT '2' COMMENT '首页推荐，1推荐，2不推荐',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商品状态，1审核，2通过，3删除',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `content` text NOT NULL COMMENT '商品详情',
  `bid` int(11) NOT NULL COMMENT '店铺id',
  `num` int(11) NOT NULL COMMENT '库存',
  `allnum` int(11) NOT NULL COMMENT '总数量，不纳入加减的',
  `astime` varchar(30) NOT NULL COMMENT '活动开始时间',
  `antime` varchar(30) NOT NULL COMMENT '活动结束时间',
  `initialdraws` int(11) NOT NULL DEFAULT '0' COMMENT '初始抽奖次数',
  `shareaddnum` int(11) NOT NULL DEFAULT '0' COMMENT '分享获取次数',
  `sharetitle` varchar(255) NOT NULL COMMENT '分销标题',
  `shareimg` varchar(255) NOT NULL COMMENT '分享图',
  `storename` varchar(255) NOT NULL COMMENT '店铺名',
  `is_vip` int(11) NOT NULL DEFAULT '0' COMMENT '是否会员使用，0不是，1是',
  `buynum` int(11) NOT NULL COMMENT '购买数参与数',
  `viewnum` int(11) NOT NULL COMMENT '查看人数',
  `sharenum` int(11) NOT NULL COMMENT '分享次数',
  `limitnum` int(11) NOT NULL COMMENT '限购',
  `isshelf` tinyint(1) NOT NULL COMMENT '是否上架，0下架，1上架',
  `sort` int(5) NOT NULL COMMENT '排序',
  `expirationtime` varchar(30) NOT NULL COMMENT '核销过期时间',
  `firstprize` varchar(255) NOT NULL COMMENT '一等奖内容',
  `secondprize` varchar(255) NOT NULL COMMENT '二等奖内容',
  `thirdprize` varchar(255) NOT NULL COMMENT '三等奖内容',
  `fourthprize` varchar(255) NOT NULL COMMENT '四等奖内容',
  `grandprize` varchar(255) NOT NULL COMMENT '特等奖内容',
  `currentprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现价',
  `firstprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一等奖概率',
  `secondprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二等奖概率',
  `thirdprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三等奖概率',
  `fourthprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '四等奖概率',
  `grandprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '特等奖概率',
  `virtualnum` int(11) NOT NULL COMMENT '虚拟领取数',
  `firstnum` int(11) NOT NULL COMMENT '一等奖数量',
  `secondnum` int(11) NOT NULL COMMENT '二等奖数量',
  `thirdnum` int(11) NOT NULL COMMENT '三等奖数量',
  `fourthnum` int(11) NOT NULL COMMENT '四等奖数量',
  `grandnum` int(11) NOT NULL COMMENT '特等奖数量',
  `index_img` varchar(255) NOT NULL COMMENT '首页图',
  `usenotice` text NOT NULL COMMENT '使用须知',
  `notwonprize` varchar(255) NOT NULL COMMENT '未中奖提示名',
  `notwonprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '未中奖概率',
  `posterimg` varchar(255) NOT NULL COMMENT '海报图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_eatvisit_lotteryrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_eatvisit_lotteryrecord`;
CREATE TABLE `ims_yzhyk_sun_eatvisit_lotteryrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'uid',
  `openid` varchar(200) NOT NULL COMMENT 'openid',
  `gid` int(11) NOT NULL COMMENT '大转盘商品id',
  `prize` text NOT NULL COMMENT '奖品',
  `allnum` int(11) NOT NULL COMMENT '可抽奖次数',
  `usenum` int(11) NOT NULL COMMENT '已使用次数',
  `click_user` text NOT NULL COMMENT '点击用户id',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `awardid` tinytext NOT NULL COMMENT '保存中奖key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_eatvisit_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_eatvisit_order`;
CREATE TABLE `ims_yzhyk_sun_eatvisit_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `storeid` int(11) NOT NULL COMMENT '商家id',
  `gname` varchar(255) NOT NULL COMMENT '商品名称',
  `storename` varchar(255) NOT NULL COMMENT '商家名称',
  `award` tinyint(2) NOT NULL DEFAULT '5' COMMENT '奖项，0特等奖，1一等奖，2二等奖，3三等奖，4四等奖，5未等奖',
  `prize` varchar(255) NOT NULL COMMENT '奖品',
  `ordernum` varchar(200) NOT NULL COMMENT '订单号',
  `writeoffcode` varchar(200) NOT NULL COMMENT '核销码',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，1未使用，2已经使用',
  `uid` int(11) NOT NULL COMMENT 'uid',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `addtime` varchar(30) NOT NULL COMMENT '添加时间',
  `finishtime` varchar(30) NOT NULL COMMENT '完成时间',
  `gimages` varchar(255) NOT NULL COMMENT '商品图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_eatvisit_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_eatvisit_set`;
CREATE TABLE `ims_yzhyk_sun_eatvisit_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `pic` varchar(255) NOT NULL COMMENT '轮播图',
  `tpl_winnotice` varchar(255) NOT NULL COMMENT '中奖通知模板消息',
  `tpl_newnotice` varchar(255) NOT NULL COMMENT '新品通知模板消息',
  `navname` varchar(50) NOT NULL COMMENT '顶部名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_formid
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_formid`;
CREATE TABLE `ims_yzhyk_sun_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `form_id` varchar(100) DEFAULT NULL,
  `time` int(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_goods`;
CREATE TABLE `ims_yzhyk_sun_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `barcode` varchar(20) DEFAULT NULL,
  `std` varchar(20) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `root_id` int(11) DEFAULT NULL,
  `marketprice` decimal(10,2) DEFAULT NULL COMMENT '市场价',
  `shopprice` decimal(10,2) NOT NULL COMMENT '商城价',
  `content` text,
  `isdel` int(1) DEFAULT '0',
  `pic` varchar(100) DEFAULT NULL,
  `pics` varchar(1000) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `index` int(11) DEFAULT NULL,
  `isappointment` int(11) DEFAULT '0',
  `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启',
  `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0百分比，1固定金额',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=gbk COMMENT='点击 ';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_goodsclass
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_goodsclass`;
CREATE TABLE `ims_yzhyk_sun_goodsclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `name` text NOT NULL COMMENT '家政名称',
  `root_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT '0',
  `isdel` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  `index` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=gbk COMMENT='点击 ';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_group
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_group`;
CREATE TABLE `ims_yzhyk_sun_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `storegroupgoods_id` int(11) DEFAULT NULL,
  `end_time` varchar(100) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `state` int(1) DEFAULT NULL COMMENT '-1：取消，0：拼团中，1：已完成',
  `groupgoods_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_groupgoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_groupgoods`;
CREATE TABLE `ims_yzhyk_sun_groupgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `pics` varchar(400) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `content` text CHARACTER SET gbk,
  `uniacid` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `useful_hour` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_grouporder
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_grouporder`;
CREATE TABLE `ims_yzhyk_sun_grouporder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `pay_amount` decimal(10,2) DEFAULT NULL,
  `pay_type` varchar(20) DEFAULT NULL,
  `pay_time` varchar(20) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `isdel` int(11) DEFAULT NULL,
  `state` int(4) DEFAULT NULL COMMENT '-10、已删除\r\n10、待支付\r\n20、待发货\r\n30、待收货\r\n40、已完成\r\n50、已取消\r\n',
  `distribution_type` int(4) DEFAULT NULL COMMENT '0、配送1、自提',
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `distribution_fee` int(4) DEFAULT NULL,
  `take_time` varchar(30) DEFAULT NULL,
  `take_tel` varchar(12) DEFAULT NULL,
  `memo` varchar(100) DEFAULT '',
  `take_address` varchar(255) DEFAULT NULL,
  `order_number` varchar(30) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `goods_img` varchar(255) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10398 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_groupuser
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_groupuser`;
CREATE TABLE `ims_yzhyk_sun_groupuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `state` int(4) DEFAULT NULL COMMENT '-1：取消，0：进行中',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_integral
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_integral`;
CREATE TABLE `ims_yzhyk_sun_integral` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `content` varchar(100) DEFAULT NULL COMMENT 'openid',
  `time` varchar(50) DEFAULT NULL COMMENT '登录时间',
  `type` int(1) DEFAULT NULL COMMENT '1、线上支付\r\n2、扫码购\r\n3、商城\r\n4、兑换余额',
  `user_id` int(11) DEFAULT NULL,
  `integral` varchar(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=877 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_membercard
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_membercard`;
CREATE TABLE `ims_yzhyk_sun_membercard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `days` int(10) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_membercardrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_membercardrecord`;
CREATE TABLE `ims_yzhyk_sun_membercardrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membercard_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `recharge_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_menu
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_menu`;
CREATE TABLE `ims_yzhyk_sun_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `menu_do` varchar(50) DEFAULT NULL,
  `menu_op` varchar(50) DEFAULT NULL,
  `prams` varchar(100) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `menu_index` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_menubutton
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_menubutton`;
CREATE TABLE `ims_yzhyk_sun_menubutton` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `button_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_order`;
CREATE TABLE `ims_yzhyk_sun_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `pay_amount` decimal(10,2) DEFAULT NULL,
  `pay_type` varchar(20) DEFAULT NULL,
  `pay_time` varchar(20) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `isdel` int(11) DEFAULT NULL,
  `state` int(4) DEFAULT NULL COMMENT '-10、已删除\r\n10、待支付\r\n20、待发货\r\n30、待收货\r\n40、已完成\r\n50、已取消\r\n',
  `distribution_type` int(4) DEFAULT NULL COMMENT '0、配送1、自提',
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `distribution_fee` int(4) DEFAULT NULL,
  `take_time` varchar(30) DEFAULT NULL,
  `take_tel` varchar(12) DEFAULT NULL,
  `memo` varchar(100) DEFAULT '',
  `take_address` varchar(255) DEFAULT NULL,
  `order_number` varchar(30) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `istui` int(11) DEFAULT '0',
  `out_trade_no` varchar(50) DEFAULT NULL,
  `out_refund_no` varchar(50) DEFAULT NULL,
  `order_type` int(5) DEFAULT '1' COMMENT '1：商城订单，2：团购，3：砍价',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10483 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_orderapp
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_orderapp`;
CREATE TABLE `ims_yzhyk_sun_orderapp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `pay_amount` decimal(10,2) DEFAULT NULL,
  `pay_type` varchar(20) DEFAULT NULL,
  `pay_time` varchar(20) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `isdel` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `state` int(4) DEFAULT NULL COMMENT '-10、已删除\r\n10、待支付\r\n20、待核销\r\n30、已核销\r\n40、已取消\r\n',
  `distribution_fee` int(4) DEFAULT NULL,
  `take_time` varchar(30) DEFAULT NULL,
  `take_tel` varchar(12) DEFAULT NULL,
  `memo` varchar(100) DEFAULT '',
  `take_address` varchar(255) DEFAULT NULL,
  `order_number` varchar(30) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_orderappgoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_orderappgoods`;
CREATE TABLE `ims_yzhyk_sun_orderappgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `goods_img` varchar(255) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_ordergoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_ordergoods`;
CREATE TABLE `ims_yzhyk_sun_ordergoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `goods_img` varchar(255) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_orderonline
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_orderonline`;
CREATE TABLE `ims_yzhyk_sun_orderonline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `pay_amount` decimal(10,2) DEFAULT NULL,
  `pay_type` varchar(20) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `pay_time` varchar(20) DEFAULT NULL,
  `pay_state` int(4) DEFAULT '0' COMMENT '0待支付，1已支付',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_orderscan
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_orderscan`;
CREATE TABLE `ims_yzhyk_sun_orderscan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `pay_amount` decimal(10,2) DEFAULT NULL,
  `pay_type` varchar(20) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `isdel` int(11) DEFAULT NULL,
  `order_number` varchar(30) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `is_out` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_orderscangoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_orderscangoods`;
CREATE TABLE `ims_yzhyk_sun_orderscangoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderscan_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `goods_img` varchar(255) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_payrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_payrecord`;
CREATE TABLE `ims_yzhyk_sun_payrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memo` varchar(100) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `source_type` varchar(50) DEFAULT NULL COMMENT '支付类型：orderonline',
  `source_id` int(11) DEFAULT NULL,
  `pay_type` varchar(11) DEFAULT NULL,
  `pay_money` decimal(15,2) DEFAULT NULL,
  `pay_time` int(11) DEFAULT NULL,
  `xml` text,
  `back_time` int(11) DEFAULT NULL,
  `no` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_address
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_address`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_address` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地址';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_article
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_article`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_article` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_bargainrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_bargainrecord`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_bargainrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `bargain_openid` varchar(60) DEFAULT NULL COMMENT '砍价用户',
  `bargain_score` int(11) DEFAULT NULL COMMENT '砍价积分',
  `add_time` int(11) DEFAULT NULL COMMENT '砍价时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价记录';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_customize
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_customize`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_customize` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自定义';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_goods`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_goods` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分商城商品表';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_lotteryprize
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_lotteryprize`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_lotteryprize` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='奖品';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_order`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_order` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_readrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_readrecord`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_readrecord` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='阅读记录';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_system`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_system` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_task
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_task`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_task` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务表';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_taskrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_taskrecord`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_taskrecord` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务积分记录表 ';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_plugin_scoretask_taskset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_plugin_scoretask_taskset`;
CREATE TABLE `ims_yzhyk_sun_plugin_scoretask_taskset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `task_type` tinyint(4) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务积分设置';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_province
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_province`;
CREATE TABLE `ims_yzhyk_sun_province` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_recharge
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_recharge`;
CREATE TABLE `ims_yzhyk_sun_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` int(5) DEFAULT NULL,
  `give_money` int(5) DEFAULT NULL,
  `used` int(1) DEFAULT '1',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_rechargecode
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_rechargecode`;
CREATE TABLE `ims_yzhyk_sun_rechargecode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recharge_code` varchar(255) DEFAULT NULL,
  `membercard_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_role
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_role`;
CREATE TABLE `ims_yzhyk_sun_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_roleauth
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_roleauth`;
CREATE TABLE `ims_yzhyk_sun_roleauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `button_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=339 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_searchrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_searchrecord`;
CREATE TABLE `ims_yzhyk_sun_searchrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) DEFAULT NULL,
  `search` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_sms
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_sms`;
CREATE TABLE `ims_yzhyk_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `appkey` varchar(100) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '2',
  `smstype` tinyint(2) NOT NULL DEFAULT '1' COMMENT '短信类型，1为253，3为大鱼',
  `ytx_apiaccount` varchar(50) NOT NULL COMMENT '253短信账号',
  `ytx_apipass` varchar(50) NOT NULL COMMENT '253短信密码',
  `ytx_apiurl` varchar(50) NOT NULL COMMENT '253短信地址',
  `ytx_order` varchar(255) NOT NULL COMMENT '云通信订单消息提醒',
  `ytx_orderrefund` varchar(255) NOT NULL COMMENT '云通信退款订单消息提醒',
  `aly_accesskeyid` varchar(255) NOT NULL COMMENT '阿里大鱼 accessKeyId',
  `aly_accesskeysecret` varchar(255) NOT NULL COMMENT '阿里大鱼 AccessKeySecret',
  `aly_order` varchar(255) NOT NULL COMMENT '阿里大鱼 订单模板',
  `aly_orderrefund` varchar(255) NOT NULL COMMENT '阿里大鱼 退款模板',
  `aly_sign` varchar(100) NOT NULL COMMENT '签名',
  `dy_code` varchar(100) NOT NULL COMMENT '大鱼短信验证',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_store
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_store`;
CREATE TABLE `ims_yzhyk_sun_store` (
  `name` varchar(50) DEFAULT NULL,
  `isdel` int(1) DEFAULT '0',
  `tel` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) DEFAULT NULL,
  `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度',
  `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度',
  `pic` varchar(100) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `county_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `feie_user` varchar(50) DEFAULT NULL,
  `feie_ukey` varchar(50) DEFAULT NULL,
  `feie_sn` varchar(50) DEFAULT NULL,
  `dingtalk_token` varchar(200) DEFAULT NULL,
  `dispatch_detail` varchar(200) DEFAULT '' COMMENT '配送时间描述',
  `user_id` int(11) DEFAULT NULL COMMENT '到账id',
  `user_name` varchar(100) DEFAULT NULL,
  `openid` varchar(100) DEFAULT NULL COMMENT '到账微信openid',
  `balance` decimal(10,2) DEFAULT '0.00' COMMENT '余额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_storeactivity
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_storeactivity`;
CREATE TABLE `ims_yzhyk_sun_storeactivity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `update_time` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_storeactivitygoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_storeactivitygoods`;
CREATE TABLE `ims_yzhyk_sun_storeactivitygoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `stock` int(10) DEFAULT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `limit` int(11) DEFAULT NULL COMMENT '限购数量',
  `storeactivity_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_storebill
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_storebill`;
CREATE TABLE `ims_yzhyk_sun_storebill` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `content` varchar(100) DEFAULT NULL COMMENT 'openid',
  `time` varchar(50) DEFAULT NULL COMMENT '登录时间',
  `type` int(1) DEFAULT NULL COMMENT '1、线上支付\r\n2、扫码购\r\n3、商城\r\n6、门店提现',
  `store_id` int(11) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_storecoupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_storecoupon`;
CREATE TABLE `ims_yzhyk_sun_storecoupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `left_num` int(11) DEFAULT NULL COMMENT '余量',
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `use_amount` int(4) DEFAULT NULL COMMENT '启用金额',
  `amount` int(4) DEFAULT NULL,
  `days` int(11) DEFAULT NULL COMMENT '有效天数',
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_storecutgoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_storecutgoods`;
CREATE TABLE `ims_yzhyk_sun_storecutgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `is_hot` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  `cutgoods_id` int(11) DEFAULT NULL,
  `stock` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_storegoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_storegoods`;
CREATE TABLE `ims_yzhyk_sun_storegoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `shop_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `ishot` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=724 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_storegroupgoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_storegroupgoods`;
CREATE TABLE `ims_yzhyk_sun_storegroupgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `is_hot` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  `groupgoods_id` int(11) DEFAULT NULL,
  `stock` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_storetakerecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_storetakerecord`;
CREATE TABLE `ims_yzhyk_sun_storetakerecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `state` int(4) DEFAULT '1' COMMENT '-3失败，-2拒绝，1待审核，2待打款，3完成',
  `fail_reason` varchar(100) DEFAULT NULL COMMENT '失败原因',
  `balance` varchar(255) DEFAULT NULL,
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_system`;
CREATE TABLE `ims_yzhyk_sun_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `appid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appid',
  `appsecret` varchar(200) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appsecret',
  `mchid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户号',
  `wxkey` varchar(250) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户秘钥',
  `uniacid` int(11) DEFAULT NULL,
  `url_name` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '网址名称',
  `details` text COMMENT '关于我们',
  `url_logo` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '网址logo',
  `bq_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL COMMENT '版权名称',
  `link_name` varchar(30) DEFAULT NULL COMMENT '网站名称',
  `link_logo` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '网站logo',
  `support` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '技术支持',
  `bq_logo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `color` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '颜色',
  `tz_appid` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `tz_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `pt_name` varchar(100) DEFAULT NULL COMMENT '平台名称',
  `tz_audit` int(11) DEFAULT NULL COMMENT '帖子审核1.是 2否',
  `sj_audit` int(11) DEFAULT NULL COMMENT '商家审核1.是 2否',
  `cityname` varchar(20) DEFAULT NULL,
  `mail` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `client_ip` varchar(100) DEFAULT NULL,
  `apiclient_key` varchar(100) DEFAULT NULL,
  `apiclient_cert` varchar(100) DEFAULT NULL,
  `fontcolor` varchar(100) DEFAULT NULL,
  `postage_base` int(11) DEFAULT NULL,
  `postage_county` int(11) DEFAULT NULL,
  `postage_city` int(11) DEFAULT NULL,
  `postage_province` int(11) DEFAULT NULL,
  `integral1` int(4) DEFAULT NULL,
  `integral2` int(4) DEFAULT NULL,
  `integral3` int(11) DEFAULT NULL,
  `card_pic` varchar(200) DEFAULT NULL,
  `team_name` varchar(50) DEFAULT NULL,
  `team_tel` varchar(20) DEFAULT NULL,
  `team_logo` varchar(100) DEFAULT NULL,
  `min_amount` int(11) DEFAULT NULL,
  `activity_memo` varchar(20) DEFAULT NULL,
  `activity_pic` varchar(100) DEFAULT NULL,
  `activity_pic2` varchar(100) DEFAULT NULL,
  `app_fcolor` varchar(20) DEFAULT NULL,
  `app_bcolor` varchar(20) DEFAULT NULL,
  `app_tbcolor` varchar(20) DEFAULT NULL,
  `app_tfcolor` varchar(20) DEFAULT NULL,
  `app_tsfcolor` varchar(20) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  `ad_show` varchar(11) DEFAULT NULL,
  `ad_link` varchar(100) DEFAULT NULL,
  `ad_value` varchar(10) DEFAULT NULL,
  `ad_pic` varchar(100) DEFAULT NULL,
  `ad_name` varchar(100) DEFAULT NULL,
  `template_id_buy` varchar(100) DEFAULT NULL,
  `template_id_sale` varchar(100) DEFAULT NULL,
  `recharge_memo` varchar(255) DEFAULT NULL,
  `recharge_pic` varchar(100) DEFAULT NULL,
  `team_show` int(10) DEFAULT '0',
  `member_charge` int(10) DEFAULT NULL,
  `member_upgrade` int(10) DEFAULT '0',
  `group_pic` varchar(100) DEFAULT NULL,
  `group_pic2` varchar(100) DEFAULT NULL,
  `cut_pic` varchar(100) DEFAULT NULL,
  `cut_pic2` varchar(100) DEFAULT NULL,
  `member_memo` varchar(255) DEFAULT NULL COMMENT '会员等级说明',
  `withdraw_switch` int(4) DEFAULT NULL,
  `withdraw_min` decimal(15,2) DEFAULT NULL,
  `withdraw_noapplymoney` decimal(15,2) DEFAULT NULL,
  `withdraw_wechatrate` decimal(15,2) DEFAULT NULL,
  `withdraw_platformrate` decimal(15,2) DEFAULT NULL,
  `withdraw_content` text,
  `developkey` varchar(500) DEFAULT NULL,
  `bghead` varchar(200) DEFAULT NULL,
  `is_start` int(2) DEFAULT NULL,
  `phone_switch` int(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_tab
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_tab`;
CREATE TABLE `ims_yzhyk_sun_tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `page` varchar(100) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `pic_s` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `tab_index` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_task
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_task`;
CREATE TABLE `ims_yzhyk_sun_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL COMMENT '标题',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用',
  `level` int(11) DEFAULT '1',
  `value` varchar(255) DEFAULT NULL,
  `execute_time` int(11) DEFAULT NULL COMMENT '预计执行时间',
  `execute_times` int(11) DEFAULT '0' COMMENT '尝试执行次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='任务';

-- ----------------------------
-- Table structure for ims_yzhyk_sun_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_user`;
CREATE TABLE `ims_yzhyk_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `openid` varchar(100) DEFAULT NULL COMMENT 'openid',
  `img` varchar(200) DEFAULT NULL COMMENT '头像',
  `time` varchar(50) DEFAULT NULL COMMENT '登录时间',
  `uniacid` int(11) DEFAULT NULL,
  `money` decimal(11,2) DEFAULT '0.00',
  `user_name` varchar(30) DEFAULT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `user_address` varchar(200) DEFAULT NULL,
  `commission` decimal(11,0) DEFAULT NULL,
  `state` int(4) DEFAULT '1',
  `attention` varchar(255) DEFAULT NULL,
  `fans` varchar(255) DEFAULT NULL,
  `collection` varchar(255) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度',
  `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度',
  `birthday` varchar(40) DEFAULT NULL,
  `gender` int(1) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `integral` int(10) DEFAULT NULL,
  `integral1` int(10) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `level_id` int(10) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT '0.00',
  `isbuy` int(2) DEFAULT '0',
  `end_time` varchar(50) DEFAULT NULL COMMENT '会员过期时间',
  `parents_id` int(11) NOT NULL COMMENT '上级id',
  `parents_name` varchar(255) NOT NULL COMMENT '上级名称',
  `spare_parents_id` int(11) NOT NULL COMMENT '备用上级id',
  `spare_parents_name` varchar(255) NOT NULL COMMENT '备用上级用户名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_usercoupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_usercoupon`;
CREATE TABLE `ims_yzhyk_sun_usercoupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `use_amount` int(4) DEFAULT NULL COMMENT '启用金额',
  `amount` int(4) DEFAULT NULL,
  `is_used` int(1) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `storecoupon_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzhyk_sun_userrole
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzhyk_sun_userrole`;
CREATE TABLE `ims_yzhyk_sun_userrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
