/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-09 13:11:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_yzbld_sun_activity_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_activity_goods`;
CREATE TABLE `ims_yzbld_sun_activity_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_type` int(10) unsigned NOT NULL COMMENT '活动类型;1:限时抢购,2:每日秒杀',
  `activity_id` int(10) unsigned NOT NULL COMMENT '活动id',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `price` decimal(8,2) NOT NULL COMMENT '活动价',
  `limited` int(11) NOT NULL DEFAULT '0' COMMENT '限购数量',
  `buy_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '已抢购的数量,秒杀有多个值',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='参与活动的商品';

-- ----------------------------
-- Table structure for ims_yzbld_sun_announcements
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_announcements`;
CREATE TABLE `ims_yzbld_sun_announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='公告';

-- ----------------------------
-- Table structure for ims_yzbld_sun_banners
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_banners`;
CREATE TABLE `ims_yzbld_sun_banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片',
  `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品',
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='轮播图';

-- ----------------------------
-- Table structure for ims_yzbld_sun_bottom_tabs
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_bottom_tabs`;
CREATE TABLE `ims_yzbld_sun_bottom_tabs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图标',
  `select_icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '点击后图标',
  `select_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '点击后字体颜色',
  `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品',
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='底部菜单';

-- ----------------------------
-- Table structure for ims_yzbld_sun_cities
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_cities`;
CREATE TABLE `ims_yzbld_sun_cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '市名',
  `province_id` int(10) unsigned NOT NULL COMMENT '省份id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6591 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地址-市';

-- ----------------------------
-- Table structure for ims_yzbld_sun_counties
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_counties`;
CREATE TABLE `ims_yzbld_sun_counties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '区县名',
  `city_id` int(10) unsigned NOT NULL COMMENT '市id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=659007 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地址-区县';

-- ----------------------------
-- Table structure for ims_yzbld_sun_coupons
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_coupons`;
CREATE TABLE `ims_yzbld_sun_coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL COMMENT '门店id',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `total` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '总量',
  `amount` int(11) NOT NULL COMMENT '优惠券金额',
  `use_amount` int(11) NOT NULL COMMENT '启用金额',
  `begin_at` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `end_at` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `days` int(11) NOT NULL COMMENT '有效天数',
  `is_enable` tinyint(1) NOT NULL COMMENT '启用?',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='优惠券';

-- ----------------------------
-- Table structure for ims_yzbld_sun_dis_amount_logs
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_dis_amount_logs`;
CREATE TABLE `ims_yzbld_sun_dis_amount_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dis_user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名目',
  `amount` decimal(8,2) NOT NULL COMMENT '金额',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配送员资金明细';

-- ----------------------------
-- Table structure for ims_yzbld_sun_dis_banners
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_dis_banners`;
CREATE TABLE `ims_yzbld_sun_dis_banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片',
  `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品',
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配送页面banner';

-- ----------------------------
-- Table structure for ims_yzbld_sun_dis_orders
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_dis_orders`;
CREATE TABLE `ims_yzbld_sun_dis_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL COMMENT '门店id',
  `order_sn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `dis_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '配送员;0表示未有配送员接单',
  `dis_amount` decimal(8,2) NOT NULL COMMENT '配送费',
  `receive_at` timestamp NULL DEFAULT NULL COMMENT '接单时间',
  `finish_at` timestamp NULL DEFAULT NULL COMMENT '配送完成时间',
  `status` int(11) NOT NULL DEFAULT '10' COMMENT '状态;-20:已取消-10:已删除;10:未接单;20:已接单;30:配送完成',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配送订单';

-- ----------------------------
-- Table structure for ims_yzbld_sun_dis_withdraws
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_dis_withdraws`;
CREATE TABLE `ims_yzbld_sun_dis_withdraws` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `openid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'openid',
  `amount` decimal(8,2) NOT NULL COMMENT '提现金额',
  `poundage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手续费',
  `commission` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '平台抽成',
  `true_amount` decimal(8,2) NOT NULL COMMENT '实际到帐金额',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '电话',
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '交易号',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配送员提现';

-- ----------------------------
-- Table structure for ims_yzbld_sun_distributions
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_distributions`;
CREATE TABLE `ims_yzbld_sun_distributions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start` int(11) NOT NULL COMMENT '距离范围',
  `end` int(11) NOT NULL COMMENT '距离范围',
  `cost` decimal(8,2) NOT NULL COMMENT '配送费',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配送费';

-- ----------------------------
-- Table structure for ims_yzbld_sun_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_goods`;
CREATE TABLE `ims_yzbld_sun_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `goods_class_id` int(10) unsigned NOT NULL COMMENT '分类id',
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '编号',
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '条形码',
  `specification` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规格',
  `shop_price` decimal(8,2) NOT NULL COMMENT '商城价',
  `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主图',
  `images` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '轮播图',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '详情',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品';

-- ----------------------------
-- Table structure for ims_yzbld_sun_goods_classes
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_goods_classes`;
CREATE TABLE `ims_yzbld_sun_goods_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `parent_id` int(11) NOT NULL COMMENT '父id',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品分类';

-- ----------------------------
-- Table structure for ims_yzbld_sun_limit_time_activities
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_limit_time_activities`;
CREATE TABLE `ims_yzbld_sun_limit_time_activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL COMMENT '门店id',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活动名称',
  `main_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '主图',
  `images` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '轮播图',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '投放?',
  `time_type` int(11) NOT NULL DEFAULT '0' COMMENT '活动时间类型',
  `begin_at` timestamp NULL DEFAULT NULL COMMENT '活动开始时间',
  `end_at` timestamp NULL DEFAULT NULL COMMENT '活动结束时间',
  `user_limit` int(11) NOT NULL COMMENT '每个用户每件商品限购量',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='限时抢购';

-- ----------------------------
-- Table structure for ims_yzbld_sun_navs
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_navs`;
CREATE TABLE `ims_yzbld_sun_navs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图标',
  `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品',
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='导航';

-- ----------------------------
-- Table structure for ims_yzbld_sun_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_order_goods`;
CREATE TABLE `ims_yzbld_sun_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `goods_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名称',
  `goods_price` decimal(8,2) NOT NULL COMMENT '购买价',
  `buy_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '购买方式:限抢,秒杀',
  `src` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品图片',
  `num` int(11) NOT NULL COMMENT '数量',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `store_goods_id` int(10) unsigned NOT NULL COMMENT '商家商品id',
  `activity_goods_id` int(10) unsigned NOT NULL COMMENT '活动商品id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for ims_yzbld_sun_orders
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_orders`;
CREATE TABLE `ims_yzbld_sun_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sn` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `store_id` int(10) unsigned NOT NULL COMMENT '门店id',
  `amount` decimal(8,2) NOT NULL COMMENT '总金额',
  `pay_amount` decimal(8,2) NOT NULL COMMENT '支付金额',
  `pay_type` int(11) NOT NULL COMMENT '支付方式;0表示微信支付,1表示余额支付',
  `pay_at` timestamp NULL DEFAULT NULL COMMENT '支付时间',
  `distribution_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '配送费',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否软删除',
  `status` int(11) NOT NULL COMMENT '状态;-10:已删除;10:待支付;20:待发货;30:待收货;40:已完成;50:已取消;',
  `distribution_type` int(11) NOT NULL COMMENT '配送方式;0:送货上门;1:自提',
  `address` text COLLATE utf8mb4_unicode_ci COMMENT 'json格式;保存送货地址',
  `take_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '上门自提时间',
  `take_tel` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '上门自提电话',
  `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度',
  `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id,0表示未使用优惠券',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verify_sn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '核销码',
  `form_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板消息form_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for ims_yzbld_sun_provinces
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_provinces`;
CREATE TABLE `ims_yzbld_sun_provinces` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '省名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地址-省份';

-- ----------------------------
-- Table structure for ims_yzbld_sun_recharge_logs
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_recharge_logs`;
CREATE TABLE `ims_yzbld_sun_recharge_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `openid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户openid',
  `amount` decimal(8,2) NOT NULL COMMENT '充值金额',
  `gift` decimal(8,2) NOT NULL COMMENT '赠送金额',
  `pay_amount` decimal(8,2) NOT NULL COMMENT '支付金额',
  `pay_at` timestamp NULL DEFAULT NULL COMMENT '支付时间',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态,0:未支付,1:已支付',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '备注',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='充值记录';

-- ----------------------------
-- Table structure for ims_yzbld_sun_recharges
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_recharges`;
CREATE TABLE `ims_yzbld_sun_recharges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `money` int(11) NOT NULL COMMENT '充值金额',
  `gift` int(11) NOT NULL COMMENT '赠送金额',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='充值赠送方案';

-- ----------------------------
-- Table structure for ims_yzbld_sun_sec_kill_activities
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_sec_kill_activities`;
CREATE TABLE `ims_yzbld_sun_sec_kill_activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL COMMENT '门店id',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活动名称',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '投放?',
  `time_type` int(11) NOT NULL DEFAULT '0' COMMENT '活动时间类型',
  `begin_at` timestamp NULL DEFAULT NULL COMMENT '活动开始时间',
  `end_at` timestamp NULL DEFAULT NULL COMMENT '活动结束时间',
  `times` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用24位的字符串表示每时的状态',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='每日秒杀';

-- ----------------------------
-- Table structure for ims_yzbld_sun_store_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_store_goods`;
CREATE TABLE `ims_yzbld_sun_store_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL COMMENT '门店id',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `shop_price` decimal(8,2) NOT NULL COMMENT '在该门店的商城价',
  `is_new` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否新品',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '-1' COMMENT '库存,-1表示不限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='门店商品';

-- ----------------------------
-- Table structure for ims_yzbld_sun_store_images
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_store_images`;
CREATE TABLE `ims_yzbld_sun_store_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片',
  `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品',
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='轮播图';

-- ----------------------------
-- Table structure for ims_yzbld_sun_stores
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_stores`;
CREATE TABLE `ims_yzbld_sun_stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '电话',
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `province_id` int(10) unsigned NOT NULL COMMENT '省',
  `city_id` int(10) unsigned NOT NULL COMMENT '市',
  `county_id` int(10) unsigned NOT NULL COMMENT '区县',
  `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度',
  `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度',
  `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '封面图',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '详情',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用',
  `dis_amount_limit` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '免配送费的消费金额',
  `min_consume` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '最小消费金额',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `enable_printer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '启用打印功能?',
  `printer_user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '飞鹅云后台注册账号',
  `printer_ukey` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '飞鹅云注册账号后生成的UKEY',
  `printer_sn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '打印机编号',
  `open_start` timestamp NULL DEFAULT NULL COMMENT '营业时间-开始时间',
  `open_end` timestamp NULL DEFAULT NULL COMMENT '营业时间-结束时间',
  `auto_dis` tinyint(1) NOT NULL DEFAULT '0' COMMENT '自动外派配送',
  `min_dist_amount` int(10) NOT NULL DEFAULT '0' COMMENT '自动外派最低配送费',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='门店';

-- ----------------------------
-- Table structure for ims_yzbld_sun_system_infos
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_system_infos`;
CREATE TABLE `ims_yzbld_sun_system_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小程序appid',
  `appsecret` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小程序appsecret',
  `mchid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户号',
  `wxkey` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户号密钥',
  `tech_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '技术支持名称',
  `tech_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '技术支持电话',
  `tech_img` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '技术支持图标',
  `tech_is_show` int(11) NOT NULL COMMENT '技术支持是否显示',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `key_pem` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'apiclient_key.pem',
  `cert_pem` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'apiclient_cert.pem',
  `access_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'access_token',
  `msg_template` text COLLATE utf8mb4_unicode_ci COMMENT '小程序模板消息',
  `sms` text COLLATE utf8mb4_unicode_ci COMMENT '短信配置信息json',
  `storage` text COLLATE utf8mb4_unicode_ci COMMENT '远程附件json',
  `map_key` text COLLATE utf8mb4_unicode_ci COMMENT '腾讯地图key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for ims_yzbld_sun_user_coupons
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_user_coupons`;
CREATE TABLE `ims_yzbld_sun_user_coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `amount` int(11) NOT NULL COMMENT '优惠券金额',
  `use_amount` int(11) NOT NULL COMMENT '启用金额',
  `begin_at` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `end_at` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `is_used` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已使用',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `coupon_id` int(10) unsigned NOT NULL COMMENT '优惠券id',
  `store_id` int(10) unsigned NOT NULL COMMENT '门店id',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会员优惠券';

-- ----------------------------
-- Table structure for ims_yzbld_sun_users
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_users`;
CREATE TABLE `ims_yzbld_sun_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像',
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '性别',
  `openid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'openid',
  `amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度',
  `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度',
  `session_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '小程序session_key',
  `is_distribution` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为配货员',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为管理员',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dis_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '配送员专属帐户',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会员';

-- ----------------------------
-- Table structure for ims_yzbld_sun_withdraw_settings
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzbld_sun_withdraw_settings`;
CREATE TABLE `ims_yzbld_sun_withdraw_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '启用',
  `min_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额',
  `no_verify_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额',
  `poundage` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '微信提现手续费费率,单位:%',
  `commission` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '平台抽成比率,单位:%',
  `rule` text COLLATE utf8mb4_unicode_ci COMMENT '提现须知',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='提现设置';
