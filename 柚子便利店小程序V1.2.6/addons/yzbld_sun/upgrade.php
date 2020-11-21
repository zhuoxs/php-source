<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_activity_goods` (
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

");

if(!pdo_fieldexists('yzbld_sun_activity_goods','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_activity_goods','activity_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD   `activity_type` int(10) unsigned NOT NULL COMMENT '活动类型;1:限时抢购,2:每日秒杀'");}
if(!pdo_fieldexists('yzbld_sun_activity_goods','activity_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD   `activity_id` int(10) unsigned NOT NULL COMMENT '活动id'");}
if(!pdo_fieldexists('yzbld_sun_activity_goods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD   `goods_id` int(10) unsigned NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('yzbld_sun_activity_goods','price')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD   `price` decimal(8,2) NOT NULL COMMENT '活动价'");}
if(!pdo_fieldexists('yzbld_sun_activity_goods','limited')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD   `limited` int(11) NOT NULL DEFAULT '0' COMMENT '限购数量'");}
if(!pdo_fieldexists('yzbld_sun_activity_goods','buy_num')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD   `buy_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '已抢购的数量,秒杀有多个值'");}
if(!pdo_fieldexists('yzbld_sun_activity_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_activity_goods','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_activity_goods','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_activity_goods')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='公告';

");

if(!pdo_fieldexists('yzbld_sun_announcements','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_announcements')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_announcements','title')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_announcements')." ADD   `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL");}
if(!pdo_fieldexists('yzbld_sun_announcements','order')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_announcements')." ADD   `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzbld_sun_announcements','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_announcements')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?'");}
if(!pdo_fieldexists('yzbld_sun_announcements','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_announcements')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_announcements','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_announcements')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_announcements','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_announcements')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_banners` (
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

");

if(!pdo_fieldexists('yzbld_sun_banners','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_banners','title')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD   `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('yzbld_sun_banners','main_image')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD   `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzbld_sun_banners','action_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD   `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品'");}
if(!pdo_fieldexists('yzbld_sun_banners','action')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD   `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接'");}
if(!pdo_fieldexists('yzbld_sun_banners','order')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD   `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzbld_sun_banners','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?'");}
if(!pdo_fieldexists('yzbld_sun_banners','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_banners','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_banners','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_banners')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_bottom_tabs` (
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

");

if(!pdo_fieldexists('yzbld_sun_bottom_tabs','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','title')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','icon')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图标'");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','select_icon')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `select_icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '点击后图标'");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','select_color')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `select_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '点击后字体颜色'");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','action_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品'");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','action')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接'");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','order')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?'");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_bottom_tabs','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_bottom_tabs')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '市名',
  `province_id` int(10) unsigned NOT NULL COMMENT '省份id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6591 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地址-市';

");

if(!pdo_fieldexists('yzbld_sun_cities','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_cities')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_cities','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_cities')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '市名'");}
if(!pdo_fieldexists('yzbld_sun_cities','province_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_cities')." ADD   `province_id` int(10) unsigned NOT NULL COMMENT '省份id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_counties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '区县名',
  `city_id` int(10) unsigned NOT NULL COMMENT '市id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=659007 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地址-区县';

");

if(!pdo_fieldexists('yzbld_sun_counties','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_counties')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_counties','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_counties')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '区县名'");}
if(!pdo_fieldexists('yzbld_sun_counties','city_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_counties')." ADD   `city_id` int(10) unsigned NOT NULL COMMENT '市id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_coupons` (
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

");

if(!pdo_fieldexists('yzbld_sun_coupons','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_coupons','store_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `store_id` int(10) unsigned NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('yzbld_sun_coupons','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('yzbld_sun_coupons','total')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `total` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '总量'");}
if(!pdo_fieldexists('yzbld_sun_coupons','amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `amount` int(11) NOT NULL COMMENT '优惠券金额'");}
if(!pdo_fieldexists('yzbld_sun_coupons','use_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `use_amount` int(11) NOT NULL COMMENT '启用金额'");}
if(!pdo_fieldexists('yzbld_sun_coupons','begin_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `begin_at` timestamp NULL DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('yzbld_sun_coupons','end_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `end_at` timestamp NULL DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('yzbld_sun_coupons','days')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `days` int(11) NOT NULL COMMENT '有效天数'");}
if(!pdo_fieldexists('yzbld_sun_coupons','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `is_enable` tinyint(1) NOT NULL COMMENT '启用?'");}
if(!pdo_fieldexists('yzbld_sun_coupons','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_coupons','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_coupons','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_coupons')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_dis_amount_logs` (
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

");

if(!pdo_fieldexists('yzbld_sun_dis_amount_logs','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_amount_logs')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_dis_amount_logs','dis_user_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_amount_logs')." ADD   `dis_user_id` int(10) unsigned NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzbld_sun_dis_amount_logs','type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_amount_logs')." ADD   `type` int(11) NOT NULL DEFAULT '0' COMMENT '类型'");}
if(!pdo_fieldexists('yzbld_sun_dis_amount_logs','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_amount_logs')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名目'");}
if(!pdo_fieldexists('yzbld_sun_dis_amount_logs','amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_amount_logs')." ADD   `amount` decimal(8,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('yzbld_sun_dis_amount_logs','remark')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_amount_logs')." ADD   `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzbld_sun_dis_amount_logs','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_amount_logs')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_dis_amount_logs','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_amount_logs')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_dis_amount_logs','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_amount_logs')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_dis_banners` (
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

");

if(!pdo_fieldexists('yzbld_sun_dis_banners','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_dis_banners','title')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD   `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('yzbld_sun_dis_banners','main_image')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD   `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzbld_sun_dis_banners','action_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD   `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品'");}
if(!pdo_fieldexists('yzbld_sun_dis_banners','action')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD   `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接'");}
if(!pdo_fieldexists('yzbld_sun_dis_banners','order')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD   `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzbld_sun_dis_banners','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?'");}
if(!pdo_fieldexists('yzbld_sun_dis_banners','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_dis_banners','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_dis_banners','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_banners')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_dis_orders` (
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

");

if(!pdo_fieldexists('yzbld_sun_dis_orders','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','store_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `store_id` int(10) unsigned NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','order_sn')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `order_sn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','dis_user_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `dis_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '配送员;0表示未有配送员接单'");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','dis_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `dis_amount` decimal(8,2) NOT NULL COMMENT '配送费'");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','receive_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `receive_at` timestamp NULL DEFAULT NULL COMMENT '接单时间'");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','finish_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `finish_at` timestamp NULL DEFAULT NULL COMMENT '配送完成时间'");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','status')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `status` int(11) NOT NULL DEFAULT '10' COMMENT '状态;-20:已取消-10:已删除;10:未接单;20:已接单;30:配送完成'");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','remark')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_dis_orders','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_orders')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_dis_withdraws` (
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

");

if(!pdo_fieldexists('yzbld_sun_dis_withdraws','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','user_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `user_id` int(10) unsigned NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','openid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `openid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `amount` decimal(8,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','poundage')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `poundage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手续费'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','commission')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `commission` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '平台抽成'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','true_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `true_amount` decimal(8,2) NOT NULL COMMENT '实际到帐金额'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','phone')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','transaction_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '交易号'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','status')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','remark')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_dis_withdraws','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_dis_withdraws')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_distributions` (
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

");

if(!pdo_fieldexists('yzbld_sun_distributions','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_distributions')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_distributions','start')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_distributions')." ADD   `start` int(11) NOT NULL COMMENT '距离范围'");}
if(!pdo_fieldexists('yzbld_sun_distributions','end')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_distributions')." ADD   `end` int(11) NOT NULL COMMENT '距离范围'");}
if(!pdo_fieldexists('yzbld_sun_distributions','cost')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_distributions')." ADD   `cost` decimal(8,2) NOT NULL COMMENT '配送费'");}
if(!pdo_fieldexists('yzbld_sun_distributions','remark')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_distributions')." ADD   `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzbld_sun_distributions','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_distributions')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_distributions','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_distributions')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_distributions','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_distributions')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_goods` (
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

");

if(!pdo_fieldexists('yzbld_sun_goods','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_goods','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('yzbld_sun_goods','goods_class_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `goods_class_id` int(10) unsigned NOT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('yzbld_sun_goods','code')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '编号'");}
if(!pdo_fieldexists('yzbld_sun_goods','barcode')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `barcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '条形码'");}
if(!pdo_fieldexists('yzbld_sun_goods','specification')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `specification` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规格'");}
if(!pdo_fieldexists('yzbld_sun_goods','shop_price')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `shop_price` decimal(8,2) NOT NULL COMMENT '商城价'");}
if(!pdo_fieldexists('yzbld_sun_goods','main_image')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主图'");}
if(!pdo_fieldexists('yzbld_sun_goods','images')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `images` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '轮播图'");}
if(!pdo_fieldexists('yzbld_sun_goods','content')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `content` text COLLATE utf8mb4_unicode_ci COMMENT '详情'");}
if(!pdo_fieldexists('yzbld_sun_goods','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用'");}
if(!pdo_fieldexists('yzbld_sun_goods','order')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzbld_sun_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_goods','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_goods','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_goods_classes` (
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

");

if(!pdo_fieldexists('yzbld_sun_goods_classes','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods_classes')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_goods_classes','title')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods_classes')." ADD   `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('yzbld_sun_goods_classes','remark')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods_classes')." ADD   `remark` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注'");}
if(!pdo_fieldexists('yzbld_sun_goods_classes','parent_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods_classes')." ADD   `parent_id` int(11) NOT NULL COMMENT '父id'");}
if(!pdo_fieldexists('yzbld_sun_goods_classes','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods_classes')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用'");}
if(!pdo_fieldexists('yzbld_sun_goods_classes','order')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods_classes')." ADD   `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzbld_sun_goods_classes','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods_classes')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_goods_classes','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods_classes')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_goods_classes','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_goods_classes')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_limit_time_activities` (
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

");

if(!pdo_fieldexists('yzbld_sun_limit_time_activities','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','store_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `store_id` int(10) unsigned NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活动名称'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','main_image')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `main_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '主图'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','images')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `images` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '轮播图'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','remark')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','status')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '投放?'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','time_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `time_type` int(11) NOT NULL DEFAULT '0' COMMENT '活动时间类型'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','begin_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `begin_at` timestamp NULL DEFAULT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','end_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `end_at` timestamp NULL DEFAULT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','user_limit')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `user_limit` int(11) NOT NULL COMMENT '每个用户每件商品限购量'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_limit_time_activities','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_limit_time_activities')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_navs` (
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

");

if(!pdo_fieldexists('yzbld_sun_navs','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_navs','title')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD   `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('yzbld_sun_navs','icon')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD   `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图标'");}
if(!pdo_fieldexists('yzbld_sun_navs','action_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD   `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品'");}
if(!pdo_fieldexists('yzbld_sun_navs','action')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD   `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接'");}
if(!pdo_fieldexists('yzbld_sun_navs','order')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD   `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzbld_sun_navs','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?'");}
if(!pdo_fieldexists('yzbld_sun_navs','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_navs','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_navs','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_navs')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_order_goods` (
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

");

if(!pdo_fieldexists('yzbld_sun_order_goods','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_order_goods','order_sn')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `order_sn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('yzbld_sun_order_goods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `goods_id` int(10) unsigned NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('yzbld_sun_order_goods','goods_name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `goods_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('yzbld_sun_order_goods','goods_price')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `goods_price` decimal(8,2) NOT NULL COMMENT '购买价'");}
if(!pdo_fieldexists('yzbld_sun_order_goods','buy_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `buy_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '购买方式:限抢,秒杀'");}
if(!pdo_fieldexists('yzbld_sun_order_goods','src')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `src` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品图片'");}
if(!pdo_fieldexists('yzbld_sun_order_goods','num')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `num` int(11) NOT NULL COMMENT '数量'");}
if(!pdo_fieldexists('yzbld_sun_order_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_order_goods','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_order_goods','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_order_goods','store_goods_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `store_goods_id` int(10) unsigned NOT NULL COMMENT '商家商品id'");}
if(!pdo_fieldexists('yzbld_sun_order_goods','activity_goods_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_order_goods')." ADD   `activity_goods_id` int(10) unsigned NOT NULL COMMENT '活动商品id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_orders` (
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

");

if(!pdo_fieldexists('yzbld_sun_orders','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_orders','sn')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `sn` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('yzbld_sun_orders','user_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `user_id` int(10) unsigned NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzbld_sun_orders','store_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `store_id` int(10) unsigned NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('yzbld_sun_orders','amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `amount` decimal(8,2) NOT NULL COMMENT '总金额'");}
if(!pdo_fieldexists('yzbld_sun_orders','pay_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `pay_amount` decimal(8,2) NOT NULL COMMENT '支付金额'");}
if(!pdo_fieldexists('yzbld_sun_orders','pay_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `pay_type` int(11) NOT NULL COMMENT '支付方式;0表示微信支付,1表示余额支付'");}
if(!pdo_fieldexists('yzbld_sun_orders','pay_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `pay_at` timestamp NULL DEFAULT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('yzbld_sun_orders','distribution_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `distribution_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '配送费'");}
if(!pdo_fieldexists('yzbld_sun_orders','is_del')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否软删除'");}
if(!pdo_fieldexists('yzbld_sun_orders','status')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `status` int(11) NOT NULL COMMENT '状态;-10:已删除;10:待支付;20:待发货;30:待收货;40:已完成;50:已取消;'");}
if(!pdo_fieldexists('yzbld_sun_orders','distribution_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `distribution_type` int(11) NOT NULL COMMENT '配送方式;0:送货上门;1:自提'");}
if(!pdo_fieldexists('yzbld_sun_orders','address')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `address` text COLLATE utf8mb4_unicode_ci COMMENT 'json格式;保存送货地址'");}
if(!pdo_fieldexists('yzbld_sun_orders','take_time')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `take_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '上门自提时间'");}
if(!pdo_fieldexists('yzbld_sun_orders','take_tel')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `take_tel` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '上门自提电话'");}
if(!pdo_fieldexists('yzbld_sun_orders','latitude')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('yzbld_sun_orders','longitude')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('yzbld_sun_orders','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id,0表示未使用优惠券'");}
if(!pdo_fieldexists('yzbld_sun_orders','remark')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `remark` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注'");}
if(!pdo_fieldexists('yzbld_sun_orders','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_orders','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_orders','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_orders','verify_sn')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `verify_sn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '核销码'");}
if(!pdo_fieldexists('yzbld_sun_orders','form_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_orders')." ADD   `form_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板消息form_id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_provinces` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '省名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地址-省份';

");

if(!pdo_fieldexists('yzbld_sun_provinces','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_provinces')." ADD 
  `id` int(10) unsigned NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_recharge_logs` (
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

");

if(!pdo_fieldexists('yzbld_sun_recharge_logs','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','user_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `user_id` int(10) unsigned NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','openid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `openid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户openid'");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `amount` decimal(8,2) NOT NULL COMMENT '充值金额'");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','gift')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `gift` decimal(8,2) NOT NULL COMMENT '赠送金额'");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','pay_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `pay_amount` decimal(8,2) NOT NULL COMMENT '支付金额'");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','pay_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `pay_at` timestamp NULL DEFAULT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','state')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态,0:未支付,1:已支付'");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','remark')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `remark` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_recharge_logs','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharge_logs')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_recharges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `money` int(11) NOT NULL COMMENT '充值金额',
  `gift` int(11) NOT NULL COMMENT '赠送金额',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='充值赠送方案';

");

if(!pdo_fieldexists('yzbld_sun_recharges','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharges')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_recharges','money')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharges')." ADD   `money` int(11) NOT NULL COMMENT '充值金额'");}
if(!pdo_fieldexists('yzbld_sun_recharges','gift')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharges')." ADD   `gift` int(11) NOT NULL COMMENT '赠送金额'");}
if(!pdo_fieldexists('yzbld_sun_recharges','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharges')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用'");}
if(!pdo_fieldexists('yzbld_sun_recharges','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharges')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_recharges','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharges')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_recharges','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_recharges')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_sec_kill_activities` (
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

");

if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','store_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `store_id` int(10) unsigned NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活动名称'");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','remark')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','status')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '投放?'");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','time_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `time_type` int(11) NOT NULL DEFAULT '0' COMMENT '活动时间类型'");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','begin_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `begin_at` timestamp NULL DEFAULT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','end_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `end_at` timestamp NULL DEFAULT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','times')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `times` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用24位的字符串表示每时的状态'");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_sec_kill_activities','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_sec_kill_activities')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_store_goods` (
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

");

if(!pdo_fieldexists('yzbld_sun_store_goods','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_store_goods','store_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD   `store_id` int(10) unsigned NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('yzbld_sun_store_goods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD   `goods_id` int(10) unsigned NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('yzbld_sun_store_goods','shop_price')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD   `shop_price` decimal(8,2) NOT NULL COMMENT '在该门店的商城价'");}
if(!pdo_fieldexists('yzbld_sun_store_goods','is_new')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD   `is_new` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否新品'");}
if(!pdo_fieldexists('yzbld_sun_store_goods','order')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD   `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzbld_sun_store_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_store_goods','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_store_goods','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_store_goods','stock')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_goods')." ADD   `stock` int(11) NOT NULL DEFAULT '-1' COMMENT '库存,-1表示不限'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_store_images` (
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

");

if(!pdo_fieldexists('yzbld_sun_store_images','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_store_images','title')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('yzbld_sun_store_images','main_image')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzbld_sun_store_images','action_type')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `action_type` int(11) NOT NULL DEFAULT '0' COMMENT '链接类型;0表示基本;1表示商品'");}
if(!pdo_fieldexists('yzbld_sun_store_images','action')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接'");}
if(!pdo_fieldexists('yzbld_sun_store_images','order')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzbld_sun_store_images','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用?'");}
if(!pdo_fieldexists('yzbld_sun_store_images','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_store_images','store_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `store_id` int(10) unsigned NOT NULL COMMENT '店铺id'");}
if(!pdo_fieldexists('yzbld_sun_store_images','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_store_images','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_store_images')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_stores` (
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

");

if(!pdo_fieldexists('yzbld_sun_stores','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_stores','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('yzbld_sun_stores','phone')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '电话'");}
if(!pdo_fieldexists('yzbld_sun_stores','address')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址'");}
if(!pdo_fieldexists('yzbld_sun_stores','email')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱'");}
if(!pdo_fieldexists('yzbld_sun_stores','province_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `province_id` int(10) unsigned NOT NULL COMMENT '省'");}
if(!pdo_fieldexists('yzbld_sun_stores','city_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `city_id` int(10) unsigned NOT NULL COMMENT '市'");}
if(!pdo_fieldexists('yzbld_sun_stores','county_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `county_id` int(10) unsigned NOT NULL COMMENT '区县'");}
if(!pdo_fieldexists('yzbld_sun_stores','latitude')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('yzbld_sun_stores','longitude')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('yzbld_sun_stores','main_image')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '封面图'");}
if(!pdo_fieldexists('yzbld_sun_stores','content')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `content` text COLLATE utf8mb4_unicode_ci COMMENT '详情'");}
if(!pdo_fieldexists('yzbld_sun_stores','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用'");}
if(!pdo_fieldexists('yzbld_sun_stores','dis_amount_limit')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `dis_amount_limit` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '免配送费的消费金额'");}
if(!pdo_fieldexists('yzbld_sun_stores','min_consume')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `min_consume` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '最小消费金额'");}
if(!pdo_fieldexists('yzbld_sun_stores','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_stores','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_stores','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_stores','enable_printer')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `enable_printer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '启用打印功能?'");}
if(!pdo_fieldexists('yzbld_sun_stores','printer_user')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `printer_user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '飞鹅云后台注册账号'");}
if(!pdo_fieldexists('yzbld_sun_stores','printer_ukey')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `printer_ukey` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '飞鹅云注册账号后生成的UKEY'");}
if(!pdo_fieldexists('yzbld_sun_stores','printer_sn')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `printer_sn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '打印机编号'");}
if(!pdo_fieldexists('yzbld_sun_stores','open_start')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `open_start` timestamp NULL DEFAULT NULL COMMENT '营业时间-开始时间'");}
if(!pdo_fieldexists('yzbld_sun_stores','open_end')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `open_end` timestamp NULL DEFAULT NULL COMMENT '营业时间-结束时间'");}
if(!pdo_fieldexists('yzbld_sun_stores','auto_dis')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `auto_dis` tinyint(1) NOT NULL DEFAULT '0' COMMENT '自动外派配送'");}
if(!pdo_fieldexists('yzbld_sun_stores','min_dist_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_stores')." ADD   `min_dist_amount` int(10) NOT NULL DEFAULT '0' COMMENT '自动外派最低配送费'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_system_infos` (
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

");

if(!pdo_fieldexists('yzbld_sun_system_infos','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_system_infos','appid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `appid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小程序appid'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','appsecret')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `appsecret` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小程序appsecret'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','mchid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `mchid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','wxkey')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `wxkey` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户号密钥'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','tech_title')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `tech_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '技术支持名称'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','tech_phone')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `tech_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '技术支持电话'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','tech_img')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `tech_img` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '技术支持图标'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','tech_is_show')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `tech_is_show` int(11) NOT NULL COMMENT '技术支持是否显示'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_system_infos','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_system_infos','key_pem')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `key_pem` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'apiclient_key.pem'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','cert_pem')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `cert_pem` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'apiclient_cert.pem'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','access_token')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `access_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'access_token'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','msg_template')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `msg_template` text COLLATE utf8mb4_unicode_ci COMMENT '小程序模板消息'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','sms')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `sms` text COLLATE utf8mb4_unicode_ci COMMENT '短信配置信息json'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','storage')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `storage` text COLLATE utf8mb4_unicode_ci COMMENT '远程附件json'");}
if(!pdo_fieldexists('yzbld_sun_system_infos','map_key')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_system_infos')." ADD   `map_key` text COLLATE utf8mb4_unicode_ci COMMENT '腾讯地图key'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_user_coupons` (
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

");

if(!pdo_fieldexists('yzbld_sun_user_coupons','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `amount` int(11) NOT NULL COMMENT '优惠券金额'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','use_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `use_amount` int(11) NOT NULL COMMENT '启用金额'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','begin_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `begin_at` timestamp NULL DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','end_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `end_at` timestamp NULL DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','is_used')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `is_used` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已使用'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','user_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `user_id` int(10) unsigned NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `coupon_id` int(10) unsigned NOT NULL COMMENT '优惠券id'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','store_id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `store_id` int(10) unsigned NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_user_coupons','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_user_coupons')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_users` (
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

");

if(!pdo_fieldexists('yzbld_sun_users','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_users','name')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('yzbld_sun_users','email')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱'");}
if(!pdo_fieldexists('yzbld_sun_users','phone')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('yzbld_sun_users','avatar')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('yzbld_sun_users','gender')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '性别'");}
if(!pdo_fieldexists('yzbld_sun_users','openid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `openid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzbld_sun_users','amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '余额'");}
if(!pdo_fieldexists('yzbld_sun_users','latitude')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('yzbld_sun_users','longitude')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('yzbld_sun_users','session_key')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `session_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '小程序session_key'");}
if(!pdo_fieldexists('yzbld_sun_users','is_distribution')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `is_distribution` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为配货员'");}
if(!pdo_fieldexists('yzbld_sun_users','is_admin')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为管理员'");}
if(!pdo_fieldexists('yzbld_sun_users','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_users','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_users','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_users','dis_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_users')." ADD   `dis_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '配送员专属帐户'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzbld_sun_withdraw_settings` (
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='提现设置';

");

if(!pdo_fieldexists('yzbld_sun_withdraw_settings','id')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzbld_sun_withdraw_settings','is_enable')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD   `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '启用'");}
if(!pdo_fieldexists('yzbld_sun_withdraw_settings','min_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD   `min_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额'");}
if(!pdo_fieldexists('yzbld_sun_withdraw_settings','no_verify_amount')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD   `no_verify_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额'");}
if(!pdo_fieldexists('yzbld_sun_withdraw_settings','poundage')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD   `poundage` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '微信提现手续费费率,单位:%'");}
if(!pdo_fieldexists('yzbld_sun_withdraw_settings','commission')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD   `commission` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '平台抽成比率,单位:%'");}
if(!pdo_fieldexists('yzbld_sun_withdraw_settings','rule')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD   `rule` text COLLATE utf8mb4_unicode_ci COMMENT '提现须知'");}
if(!pdo_fieldexists('yzbld_sun_withdraw_settings','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD   `uniacid` int(10) unsigned NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzbld_sun_withdraw_settings','created_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD   `created_at` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzbld_sun_withdraw_settings','updated_at')) {pdo_query("ALTER TABLE ".tablename('yzbld_sun_withdraw_settings')." ADD   `updated_at` timestamp NULL DEFAULT NULL");}
