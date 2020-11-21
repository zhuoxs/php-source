<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_acode` (
  `id` int(11) NOT NULL COMMENT '该id不自动增加',
  `time` varchar(30) NOT NULL COMMENT '时间',
  `code` text NOT NULL COMMENT '码',
  `url` varchar(255) NOT NULL,
  `uncode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_acode','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_acode')." ADD 
  `id` int(11) NOT NULL COMMENT '该id不自动增加'");}
if(!pdo_fieldexists('yzhyk_sun_acode','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_acode')." ADD   `time` varchar(30) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('yzhyk_sun_acode','code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_acode')." ADD   `code` text NOT NULL COMMENT '码'");}
if(!pdo_fieldexists('yzhyk_sun_acode','url')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_acode')." ADD   `url` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `update_time` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_activity','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activity')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_activity','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activity')." ADD   `name` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_activity','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activity')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_activity','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activity')." ADD   `end_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_activity','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activity')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_activity','update_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activity')." ADD   `update_time` int(20) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_activitygoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `limit` int(11) DEFAULT NULL COMMENT '限购数量',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=706 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_activitygoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activitygoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_activitygoods','activity_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activitygoods')." ADD   `activity_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_activitygoods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activitygoods')." ADD   `goods_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_activitygoods','price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activitygoods')." ADD   `price` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_activitygoods','limit')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activitygoods')." ADD   `limit` int(11) DEFAULT NULL COMMENT '限购数量'");}
if(!pdo_fieldexists('yzhyk_sun_activitygoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_activitygoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_admin','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_admin')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_admin','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_admin')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_admin','code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_admin')." ADD   `code` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_admin','password')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_admin')." ADD   `password` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_admin','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_admin')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_appmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `page` varchar(100) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `appmenu_index` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_appmenu','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_appmenu')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_appmenu','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_appmenu')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_appmenu','page')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_appmenu')." ADD   `page` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_appmenu','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_appmenu')." ADD   `pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_appmenu','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_appmenu')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_appmenu','appmenu_index')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_appmenu')." ADD   `appmenu_index` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_bill` (
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

");

if(!pdo_fieldexists('yzhyk_sun_bill','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_bill')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq'");}
if(!pdo_fieldexists('yzhyk_sun_bill','content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_bill')." ADD   `content` varchar(100) DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzhyk_sun_bill','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_bill')." ADD   `time` varchar(50) DEFAULT NULL COMMENT '登录时间'");}
if(!pdo_fieldexists('yzhyk_sun_bill','type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_bill')." ADD   `type` int(1) DEFAULT NULL COMMENT '1、线上支付\r\n2、扫码购\r\n3、商城\r\n4、兑换余额\r\n5、充值'");}
if(!pdo_fieldexists('yzhyk_sun_bill','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_bill')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_bill','balance')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_bill')." ADD   `balance` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_bill','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_bill')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_bill','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_bill')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_button` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_button','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_button')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_button','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_button')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_button','code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_button')." ADD   `code` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_button','memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_button')." ADD   `memo` varchar(100) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_cardlevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_cardlevel','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cardlevel')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_cardlevel','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cardlevel')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cardlevel','note')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cardlevel')." ADD   `note` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cardlevel','discount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cardlevel')." ADD   `discount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cardlevel','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cardlevel')." ADD   `amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cardlevel','price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cardlevel')." ADD   `price` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yzhyk_sun_cardlevel','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cardlevel')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_city','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_city')." ADD 
  `id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_city','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_city')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_city','province_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_city')." ADD   `province_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `key` varchar(50) DEFAULT NULL COMMENT '关键字',
  `value` varchar(250) DEFAULT NULL COMMENT '值',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='配置信息';

");

if(!pdo_fieldexists('yzhyk_sun_config','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_config')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_config','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_config')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_config','key')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_config')." ADD   `key` varchar(50) DEFAULT NULL COMMENT '关键字'");}
if(!pdo_fieldexists('yzhyk_sun_config','value')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_config')." ADD   `value` varchar(250) DEFAULT NULL COMMENT '值'");}
if(!pdo_fieldexists('yzhyk_sun_config','create_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_config')." ADD   `create_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_config','update_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_config')." ADD   `update_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_county` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_county','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_county')." ADD 
  `id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_county','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_county')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_county','city_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_county')." ADD   `city_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_coupon` (
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

");

if(!pdo_fieldexists('yzhyk_sun_coupon','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_coupon','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_coupon','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_coupon','left_num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `left_num` int(11) DEFAULT NULL COMMENT '余量'");}
if(!pdo_fieldexists('yzhyk_sun_coupon','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_coupon','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `end_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_coupon','use_amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `use_amount` int(4) DEFAULT NULL COMMENT '启用金额'");}
if(!pdo_fieldexists('yzhyk_sun_coupon','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `amount` int(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_coupon','isvip')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `isvip` int(4) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_coupon','days')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `days` int(11) DEFAULT NULL COMMENT '有效天数'");}
if(!pdo_fieldexists('yzhyk_sun_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_coupon')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_cut` (
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

");

if(!pdo_fieldexists('yzhyk_sun_cut','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_cut','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cut','storecutgoods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `storecutgoods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cut','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `end_time` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cut','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cut','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cut','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `state` int(1) DEFAULT NULL COMMENT '-1：取消，0：砍价中，1：已完成'");}
if(!pdo_fieldexists('yzhyk_sun_cut','cutgoods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `cutgoods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cut','price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cut','shop_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `shop_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cut','cut_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `cut_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cut','cut_num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cut')." ADD   `cut_num` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_cutgoods` (
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

");

if(!pdo_fieldexists('yzhyk_sun_cutgoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `goods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','pics')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `pics` varchar(400) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','stock')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `stock` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `end_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `content` text CHARACTER SET gbk");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','goods_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `goods_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutgoods','useful_hour')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutgoods')." ADD   `useful_hour` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_cutuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cut_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `cut_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_cutuser','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutuser')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_cutuser','cut_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutuser')." ADD   `cut_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutuser','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutuser')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutuser','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutuser')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutuser','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutuser')." ADD   `time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_cutuser','cut_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_cutuser')." ADD   `cut_price` decimal(10,2) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_distribution_order` (
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

");

if(!pdo_fieldexists('yzhyk_sun_distribution_order','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','ordertype')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `ordertype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类别，1普通，2砍价，3拼团，4抢购，5预约'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','order_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `order_id` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '3级id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','first_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','second_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','third_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','rebate')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `rebate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自购，0否，1是'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `user_id` int(11) NOT NULL COMMENT '购买用户id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','is_delete')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（用来识别是否计入可提现佣金），0未，1删'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_order')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_distribution_promoter` (
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

");

if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `name` varchar(30) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','mobilephone')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `mobilephone` varchar(30) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','allcommission')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `allcommission` decimal(10,2) NOT NULL COMMENT '累计佣金'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','canwithdraw')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `canwithdraw` decimal(10,2) NOT NULL COMMENT '可提现佣金'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','referrer_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `referrer_name` varchar(100) NOT NULL COMMENT '推荐人'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','referrer_uid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `referrer_uid` int(11) NOT NULL COMMENT '推荐人id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','status')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态，0审核中，1通过，2拒绝'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','addtime')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `addtime` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','checktime')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `checktime` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','meno')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `meno` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','form_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id，发模板消息'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','freezemoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现冻结的金额'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','uid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','code_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `code_img` mediumblob NOT NULL COMMENT '小程序码'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_promoter','invitation_code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_promoter')." ADD   `invitation_code` varchar(20) NOT NULL COMMENT '邀请码'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_distribution_set` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_distribution_set','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','status')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销层级,0不开启，1一级，2二级'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','is_buyself')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `is_buyself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销内购，0关闭，1开启'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','lower_condition')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `lower_condition` tinyint(1) NOT NULL DEFAULT '0' COMMENT '成为下线条件，0首次点击链接'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','share_condition')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `share_condition` tinyint(3) NOT NULL DEFAULT '0' COMMENT '成为分销商条件，0无条件但要审核，1申请审核，2不需要审核'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','autoshare')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `autoshare` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费自动成为分销商'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','withdrawtype')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `withdrawtype` varchar(100) NOT NULL COMMENT '提现方式,1微信支付,2支付宝支付,3银行卡支付,4余额支付'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','minwithdraw')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `minwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','daymaxwithdraw')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `daymaxwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','withdrawnotice')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `withdrawnotice` text NOT NULL COMMENT '用户提现须知'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','tpl_wd_arrival')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `tpl_wd_arrival` varchar(255) NOT NULL COMMENT '提现到账模板消息id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','tpl_wd_fail')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `tpl_wd_fail` varchar(255) NOT NULL COMMENT '提现失败模板消息id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','tpl_share_check')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `tpl_share_check` varchar(255) NOT NULL COMMENT '分销审核模板消息id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','application')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `application` text NOT NULL COMMENT '申请协议'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','applybanner')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `applybanner` varchar(255) NOT NULL COMMENT '申请页面banner'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','checkbanner')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `checkbanner` varchar(255) NOT NULL COMMENT '待审核页面banner'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','commissiontype')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `commissiontype` tinyint(3) NOT NULL DEFAULT '1' COMMENT '分销佣金类型，1百分比，2固定金额'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','firstname')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `firstname` varchar(255) NOT NULL COMMENT '一级名称'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','firstmoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','secondname')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `secondname` varchar(255) NOT NULL COMMENT '二级名称'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','secondmoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','withdrawhandingfee')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `withdrawhandingfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','thirdname')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `thirdname` varchar(50) NOT NULL COMMENT '第三级名称'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '第三级佣金'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','postertoppic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `postertoppic` varchar(255) NOT NULL COMMENT '海报图'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','postertoptitle')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `postertoptitle` varchar(200) NOT NULL COMMENT '海报标题'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','is_offline')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `is_offline` tinyint(1) NOT NULL DEFAULT '0' COMMENT '线下付是否开启分销，0关闭，1开启'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_set','dsource')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_set')." ADD   `dsource` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销佣金来源 0 平台 1 商家'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_distribution_withdraw` (
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

");

if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','uname')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `uname` varchar(255) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','account')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `account` varchar(20) NOT NULL COMMENT '提现账号'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','bank')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `bank` varchar(50) NOT NULL COMMENT '所属银行'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','withdrawaltype')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `withdrawaltype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现方式，1微信，2支付宝，3银行卡，4余额'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现状态，0待打款，1已经打款，2拒绝'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `time` int(11) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','mobilephone')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `mobilephone` varchar(30) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','money')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','realmoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','meno')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `meno` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','uid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzhyk_sun_distribution_withdraw','form_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_distribution_withdraw')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_eatvisit_goods` (
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

");

if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','gname')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `gname` varchar(255) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','shopprice')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `shopprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','thumbnail')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `thumbnail` varchar(200) NOT NULL COMMENT '缩略图'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','tid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `tid` int(11) NOT NULL DEFAULT '2' COMMENT '首页推荐，1推荐，2不推荐'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','status')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商品状态，1审核，2通过，3删除'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `content` text NOT NULL COMMENT '商品详情'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','bid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `bid` int(11) NOT NULL COMMENT '店铺id'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `num` int(11) NOT NULL COMMENT '库存'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','allnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `allnum` int(11) NOT NULL COMMENT '总数量，不纳入加减的'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','astime')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `astime` varchar(30) NOT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','antime')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `antime` varchar(30) NOT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','initialdraws')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `initialdraws` int(11) NOT NULL DEFAULT '0' COMMENT '初始抽奖次数'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','shareaddnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `shareaddnum` int(11) NOT NULL DEFAULT '0' COMMENT '分享获取次数'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','sharetitle')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `sharetitle` varchar(255) NOT NULL COMMENT '分销标题'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','shareimg')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `shareimg` varchar(255) NOT NULL COMMENT '分享图'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','storename')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `storename` varchar(255) NOT NULL COMMENT '店铺名'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','is_vip')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `is_vip` int(11) NOT NULL DEFAULT '0' COMMENT '是否会员使用，0不是，1是'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','buynum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `buynum` int(11) NOT NULL COMMENT '购买数参与数'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','viewnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `viewnum` int(11) NOT NULL COMMENT '查看人数'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','sharenum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `sharenum` int(11) NOT NULL COMMENT '分享次数'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','limitnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `limitnum` int(11) NOT NULL COMMENT '限购'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','isshelf')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `isshelf` tinyint(1) NOT NULL COMMENT '是否上架，0下架，1上架'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','sort')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','expirationtime')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `expirationtime` varchar(30) NOT NULL COMMENT '核销过期时间'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','firstprize')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `firstprize` varchar(255) NOT NULL COMMENT '一等奖内容'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','secondprize')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `secondprize` varchar(255) NOT NULL COMMENT '二等奖内容'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','thirdprize')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `thirdprize` varchar(255) NOT NULL COMMENT '三等奖内容'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','fourthprize')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `fourthprize` varchar(255) NOT NULL COMMENT '四等奖内容'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','grandprize')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `grandprize` varchar(255) NOT NULL COMMENT '特等奖内容'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','currentprice')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `currentprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现价'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','firstprobability')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `firstprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一等奖概率'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','secondprobability')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `secondprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二等奖概率'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','thirdprobability')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `thirdprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三等奖概率'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','fourthprobability')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `fourthprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '四等奖概率'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','grandprobability')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `grandprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '特等奖概率'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','virtualnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `virtualnum` int(11) NOT NULL COMMENT '虚拟领取数'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','firstnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `firstnum` int(11) NOT NULL COMMENT '一等奖数量'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','secondnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `secondnum` int(11) NOT NULL COMMENT '二等奖数量'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','thirdnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `thirdnum` int(11) NOT NULL COMMENT '三等奖数量'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','fourthnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `fourthnum` int(11) NOT NULL COMMENT '四等奖数量'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','grandnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `grandnum` int(11) NOT NULL COMMENT '特等奖数量'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','index_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `index_img` varchar(255) NOT NULL COMMENT '首页图'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','usenotice')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `usenotice` text NOT NULL COMMENT '使用须知'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','notwonprize')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `notwonprize` varchar(255) NOT NULL COMMENT '未中奖提示名'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','notwonprobability')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `notwonprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '未中奖概率'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_goods','posterimg')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_goods')." ADD   `posterimg` varchar(255) NOT NULL COMMENT '海报图'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_eatvisit_lotteryrecord` (
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

");

if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','uid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD   `uid` int(11) NOT NULL COMMENT 'uid'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD   `openid` varchar(200) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','gid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD   `gid` int(11) NOT NULL COMMENT '大转盘商品id'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','prize')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD   `prize` text NOT NULL COMMENT '奖品'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','allnum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD   `allnum` int(11) NOT NULL COMMENT '可抽奖次数'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','usenum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD   `usenum` int(11) NOT NULL COMMENT '已使用次数'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','click_user')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD   `click_user` text NOT NULL COMMENT '点击用户id'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_lotteryrecord','awardid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_lotteryrecord')." ADD   `awardid` tinytext NOT NULL COMMENT '保存中奖key'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_eatvisit_order` (
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

");

if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','gid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `gid` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','storeid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `storeid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','gname')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `gname` varchar(255) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','storename')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `storename` varchar(255) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','award')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `award` tinyint(2) NOT NULL DEFAULT '5' COMMENT '奖项，0特等奖，1一等奖，2二等奖，3三等奖，4四等奖，5未等奖'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','prize')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `prize` varchar(255) NOT NULL COMMENT '奖品'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','ordernum')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `ordernum` varchar(200) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','writeoffcode')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `writeoffcode` varchar(200) NOT NULL COMMENT '核销码'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','money')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','status')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，1未使用，2已经使用'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','uid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `uid` int(11) NOT NULL COMMENT 'uid'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','addtime')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `addtime` varchar(30) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','finishtime')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `finishtime` varchar(30) NOT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_order','gimages')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_order')." ADD   `gimages` varchar(255) NOT NULL COMMENT '商品图'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_eatvisit_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `pic` varchar(255) NOT NULL COMMENT '轮播图',
  `tpl_winnotice` varchar(255) NOT NULL COMMENT '中奖通知模板消息',
  `tpl_newnotice` varchar(255) NOT NULL COMMENT '新品通知模板消息',
  `navname` varchar(50) NOT NULL COMMENT '顶部名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_eatvisit_set','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_set','isopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_set')." ADD   `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_set')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_set','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_set')." ADD   `pic` varchar(255) NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_set','tpl_winnotice')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_set')." ADD   `tpl_winnotice` varchar(255) NOT NULL COMMENT '中奖通知模板消息'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_set','tpl_newnotice')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_set')." ADD   `tpl_newnotice` varchar(255) NOT NULL COMMENT '新品通知模板消息'");}
if(!pdo_fieldexists('yzhyk_sun_eatvisit_set','navname')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_eatvisit_set')." ADD   `navname` varchar(50) NOT NULL COMMENT '顶部名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `form_id` varchar(100) DEFAULT NULL,
  `time` int(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_formid','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_formid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_formid','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_formid')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_formid','form_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_formid')." ADD   `form_id` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_formid','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_formid')." ADD   `time` int(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_formid','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_formid')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_goods` (
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

");

if(!pdo_fieldexists('yzhyk_sun_goods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_goods','code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `code` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `name` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','barcode')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `barcode` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','std')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `std` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','class_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `class_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','root_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `root_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','marketprice')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `marketprice` decimal(10,2) DEFAULT NULL COMMENT '市场价'");}
if(!pdo_fieldexists('yzhyk_sun_goods','shopprice')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `shopprice` decimal(10,2) NOT NULL COMMENT '商城价'");}
if(!pdo_fieldexists('yzhyk_sun_goods','content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `content` text");}
if(!pdo_fieldexists('yzhyk_sun_goods','isdel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `isdel` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_goods','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','pics')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `pics` varchar(1000) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','index')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `index` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goods','isappointment')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `isappointment` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_goods','distribution_open')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启'");}
if(!pdo_fieldexists('yzhyk_sun_goods','distribution_commissiontype')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0百分比，1固定金额'");}
if(!pdo_fieldexists('yzhyk_sun_goods','firstmoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('yzhyk_sun_goods','secondmoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('yzhyk_sun_goods','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goods')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_goodsclass` (
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

");

if(!pdo_fieldexists('yzhyk_sun_goodsclass','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goodsclass')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_goodsclass','code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goodsclass')." ADD   `code` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goodsclass','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goodsclass')." ADD   `name` text NOT NULL COMMENT '家政名称'");}
if(!pdo_fieldexists('yzhyk_sun_goodsclass','root_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goodsclass')." ADD   `root_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goodsclass','level')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goodsclass')." ADD   `level` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_goodsclass','isdel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goodsclass')." ADD   `isdel` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_goodsclass','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goodsclass')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_goodsclass','index')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_goodsclass')." ADD   `index` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_group` (
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

");

if(!pdo_fieldexists('yzhyk_sun_group','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_group')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_group','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_group')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_group','storegroupgoods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_group')." ADD   `storegroupgoods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_group','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_group')." ADD   `end_time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_group','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_group')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_group','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_group')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_group','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_group')." ADD   `state` int(1) DEFAULT NULL COMMENT '-1：取消，0：拼团中，1：已完成'");}
if(!pdo_fieldexists('yzhyk_sun_group','groupgoods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_group')." ADD   `groupgoods_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_groupgoods` (
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

");

if(!pdo_fieldexists('yzhyk_sun_groupgoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `goods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','pics')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `pics` varchar(400) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','stock')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `stock` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `end_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `content` text CHARACTER SET gbk");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','goods_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `goods_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupgoods','useful_hour')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupgoods')." ADD   `useful_hour` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_grouporder` (
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

");

if(!pdo_fieldexists('yzhyk_sun_grouporder','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','pay_amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `pay_amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','pay_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `pay_type` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','pay_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `pay_time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','isdel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `isdel` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `state` int(4) DEFAULT NULL COMMENT '-10、已删除\r\n10、待支付\r\n20、待发货\r\n30、待收货\r\n40、已完成\r\n50、已取消\r\n'");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','distribution_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `distribution_type` int(4) DEFAULT NULL COMMENT '0、配送1、自提'");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','province')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `province` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','city')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `city` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','county')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `county` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','distribution_fee')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `distribution_fee` int(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','take_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `take_time` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','take_tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `take_tel` varchar(12) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `memo` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','take_address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `take_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','order_number')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `order_number` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `coupon_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `goods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','goods_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `goods_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','goods_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `goods_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','goods_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `goods_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_grouporder','group_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_grouporder')." ADD   `group_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_groupuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `state` int(4) DEFAULT NULL COMMENT '-1：取消，0：进行中',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_groupuser','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupuser')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_groupuser','group_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupuser')." ADD   `group_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupuser','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupuser')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_groupuser','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupuser')." ADD   `state` int(4) DEFAULT NULL COMMENT '-1：取消，0：进行中'");}
if(!pdo_fieldexists('yzhyk_sun_groupuser','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_groupuser')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_integral` (
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

");

if(!pdo_fieldexists('yzhyk_sun_integral','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_integral')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq'");}
if(!pdo_fieldexists('yzhyk_sun_integral','content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_integral')." ADD   `content` varchar(100) DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzhyk_sun_integral','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_integral')." ADD   `time` varchar(50) DEFAULT NULL COMMENT '登录时间'");}
if(!pdo_fieldexists('yzhyk_sun_integral','type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_integral')." ADD   `type` int(1) DEFAULT NULL COMMENT '1、线上支付\r\n2、扫码购\r\n3、商城\r\n4、兑换余额'");}
if(!pdo_fieldexists('yzhyk_sun_integral','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_integral')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_integral','integral')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_integral')." ADD   `integral` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_integral','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_integral')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_integral','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_integral')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_membercard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `days` int(10) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_membercard','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercard')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_membercard','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercard')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_membercard','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercard')." ADD   `amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_membercard','days')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercard')." ADD   `days` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_membercard','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercard')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_membercardrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membercard_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `recharge_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_membercardrecord','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercardrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_membercardrecord','membercard_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercardrecord')." ADD   `membercard_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_membercardrecord','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercardrecord')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_membercardrecord','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercardrecord')." ADD   `time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_membercardrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercardrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_membercardrecord','recharge_code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_membercardrecord')." ADD   `recharge_code` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_menu` (
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

");

if(!pdo_fieldexists('yzhyk_sun_menu','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_menu','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_menu','menu_do')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD   `menu_do` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_menu','menu_op')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD   `menu_op` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_menu','prams')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD   `prams` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_menu','menu_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD   `menu_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_menu','memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD   `memo` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_menu','icon')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD   `icon` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_menu','code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD   `code` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_menu','menu_index')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menu')." ADD   `menu_index` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_menubutton` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `button_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_menubutton','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menubutton')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_menubutton','menu_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menubutton')." ADD   `menu_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_menubutton','button_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_menubutton')." ADD   `button_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_order` (
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

");

if(!pdo_fieldexists('yzhyk_sun_order','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_order','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','pay_amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `pay_amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','pay_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `pay_type` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `pay_time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','isdel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `isdel` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `state` int(4) DEFAULT NULL COMMENT '-10、已删除\r\n10、待支付\r\n20、待发货\r\n30、待收货\r\n40、已完成\r\n50、已取消\r\n'");}
if(!pdo_fieldexists('yzhyk_sun_order','distribution_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `distribution_type` int(4) DEFAULT NULL COMMENT '0、配送1、自提'");}
if(!pdo_fieldexists('yzhyk_sun_order','province')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `province` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','city')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `city` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','county')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `county` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','distribution_fee')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `distribution_fee` int(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','take_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `take_time` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','take_tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `take_tel` varchar(12) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `memo` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('yzhyk_sun_order','take_address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `take_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','order_number')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `order_number` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `coupon_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','istui')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `istui` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_order','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `out_trade_no` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `out_refund_no` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_order','order_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `order_type` int(5) DEFAULT '1' COMMENT '1：商城订单，2：团购，3：砍价'");}
if(!pdo_fieldexists('yzhyk_sun_order','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('yzhyk_sun_order','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('yzhyk_sun_order','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_order')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_orderapp` (
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

");

if(!pdo_fieldexists('yzhyk_sun_orderapp','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','pay_amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `pay_amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','pay_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `pay_type` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','pay_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `pay_time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','isdel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `isdel` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','gid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `state` int(4) DEFAULT NULL COMMENT '-10、已删除\r\n10、待支付\r\n20、待核销\r\n30、已核销\r\n40、已取消\r\n'");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','distribution_fee')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `distribution_fee` int(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','take_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `take_time` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','take_tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `take_tel` varchar(12) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `memo` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','take_address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `take_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','order_number')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `order_number` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `coupon_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('yzhyk_sun_orderapp','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderapp')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_orderappgoods` (
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

");

if(!pdo_fieldexists('yzhyk_sun_orderappgoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderappgoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_orderappgoods','order_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderappgoods')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderappgoods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderappgoods')." ADD   `goods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderappgoods','goods_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderappgoods')." ADD   `goods_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderappgoods','goods_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderappgoods')." ADD   `goods_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderappgoods','goods_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderappgoods')." ADD   `goods_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderappgoods','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderappgoods')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderappgoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderappgoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_ordergoods` (
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

");

if(!pdo_fieldexists('yzhyk_sun_ordergoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_ordergoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_ordergoods','order_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_ordergoods')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_ordergoods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_ordergoods')." ADD   `goods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_ordergoods','goods_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_ordergoods')." ADD   `goods_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_ordergoods','goods_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_ordergoods')." ADD   `goods_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_ordergoods','goods_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_ordergoods')." ADD   `goods_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_ordergoods','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_ordergoods')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_ordergoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_ordergoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_orderonline` (
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

");

if(!pdo_fieldexists('yzhyk_sun_orderonline','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','pay_amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `pay_amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','pay_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `pay_type` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `coupon_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','pay_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `pay_time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderonline','pay_state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderonline')." ADD   `pay_state` int(4) DEFAULT '0' COMMENT '0待支付，1已支付'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_orderscan` (
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

");

if(!pdo_fieldexists('yzhyk_sun_orderscan','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','pay_amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `pay_amount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','pay_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `pay_type` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `time` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','isdel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `isdel` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','order_number')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `order_number` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `coupon_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscan','is_out')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscan')." ADD   `is_out` int(2) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_orderscangoods` (
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

");

if(!pdo_fieldexists('yzhyk_sun_orderscangoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscangoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_orderscangoods','orderscan_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscangoods')." ADD   `orderscan_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscangoods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscangoods')." ADD   `goods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscangoods','goods_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscangoods')." ADD   `goods_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscangoods','goods_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscangoods')." ADD   `goods_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscangoods','goods_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscangoods')." ADD   `goods_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscangoods','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscangoods')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_orderscangoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_orderscangoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_payrecord` (
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

");

if(!pdo_fieldexists('yzhyk_sun_payrecord','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `memo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','source_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `source_type` varchar(50) DEFAULT NULL COMMENT '支付类型：orderonline'");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','source_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `source_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','pay_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `pay_type` varchar(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','pay_money')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `pay_money` decimal(15,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','pay_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `pay_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','xml')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `xml` text");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','back_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `back_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','no')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `no` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_payrecord','create_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_payrecord')." ADD   `create_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_address` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','phone')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `phone` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','province')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `province` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','city')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `city` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','zip')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `zip` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','postalcode')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `postalcode` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','default')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '默认地址'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','lottery')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `lottery` tinyint(4) NOT NULL DEFAULT '0' COMMENT '抽奖收货地址'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_address','edit_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_address')." ADD   `edit_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_article` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','icon')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `icon` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','show_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `show_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '首页展示类型 1竖向 2横向'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','url')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','file_path')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `file_path` varchar(255) DEFAULT NULL COMMENT '音频'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','read_num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `state` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','show_index')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在首页'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','show_task')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `show_task` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在任务'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','publish_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `publish_time` int(11) DEFAULT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','tg_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `tg_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','jj_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `jj_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_article','icon_vertical')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_article')." ADD   `icon_vertical` varchar(255) DEFAULT NULL COMMENT '竖向图标'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_bargainrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `bargain_openid` varchar(60) DEFAULT NULL COMMENT '砍价用户',
  `bargain_score` int(11) DEFAULT NULL COMMENT '砍价积分',
  `add_time` int(11) DEFAULT NULL COMMENT '砍价时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价记录';

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_bargainrecord','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_bargainrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_bargainrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_bargainrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_bargainrecord','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_bargainrecord')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_bargainrecord','gid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_bargainrecord')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_bargainrecord','bargain_openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_bargainrecord')." ADD   `bargain_openid` varchar(60) DEFAULT NULL COMMENT '砍价用户'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_bargainrecord','bargain_score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_bargainrecord')." ADD   `bargain_score` int(11) DEFAULT NULL COMMENT '砍价积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_bargainrecord','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_bargainrecord')." ADD   `add_time` int(11) DEFAULT NULL COMMENT '砍价时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_customize` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2营销案图标 3底部图标'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '标题名称'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '图标图片'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','clickago_icon')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `clickago_icon` varchar(200) DEFAULT NULL COMMENT '点击前图标'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','clickafter_icon')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `clickafter_icon` varchar(200) DEFAULT NULL COMMENT '点击后图标'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','url_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `url_type` tinyint(4) DEFAULT NULL COMMENT '链接类型 1基本 2商品分类'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','url')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `url` varchar(200) DEFAULT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','url_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `url_name` varchar(50) DEFAULT NULL COMMENT '链接名称'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','sort')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `sort` tinyint(4) DEFAULT NULL COMMENT '排序 越大越前'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_customize','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_customize')." ADD   `store_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_goods` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','lid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `lid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1积分商品 2抽奖商品'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `title` varchar(200) DEFAULT NULL COMMENT '商品名'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '展示图'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','lb_pics')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `lb_pics` text COMMENT '轮播图'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `price` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '价值'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT '价值总积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','bargain_score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '可砍积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','min_score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `min_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最小积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','max_score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `max_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最大积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '库存'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','sale_num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `sale_num` int(11) NOT NULL DEFAULT '0' COMMENT '已兑换'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `begin_time` int(11) DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `end_time` int(11) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_goods','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_goods')." ADD   `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_lotteryprize` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型  1积分商城物品 2积分 3谢谢参与'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','gid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT 'type为1时 使用'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT 'type为2时使用'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `pic` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','rate')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `rate` int(11) NOT NULL DEFAULT '0' COMMENT '中奖概率'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '奖品数量'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','zj_num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `zj_num` int(11) NOT NULL DEFAULT '0' COMMENT '中奖数量'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_lotteryprize','edit_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_lotteryprize')." ADD   `edit_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_order` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','lid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `lid` int(11) NOT NULL DEFAULT '0' COMMENT '1积分商城订单 2抽奖订单'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','orderformid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `orderformid` varchar(60) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','gid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '数量'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','order_score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `order_score` int(11) NOT NULL DEFAULT '0' COMMENT '消费的积分(兑换的积分)'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','bargain_score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '砍价多少积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','pay_status')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '兑换状态 支付状态 1支付兑换'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','order_status')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未兑换  1已支付(待发货) 3完成'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `pay_time` int(11) DEFAULT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','wc_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `wc_time` int(11) DEFAULT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','fahuo_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `fahuo_time` int(11) DEFAULT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','phone')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `phone` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','province')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `province` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','city')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `city` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','zip')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `zip` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `address` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','postalcode')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `postalcode` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','express_delivery')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `express_delivery` varchar(60) DEFAULT NULL COMMENT '物流公司'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','express_no')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `express_no` varchar(60) DEFAULT NULL COMMENT '物流单号'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','remark')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `remark` varchar(200) DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','lottery_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `lottery_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型1积分商品实物 2积分 '");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_order','lotteryprize_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_order')." ADD   `lotteryprize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_readrecord` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_readrecord','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_readrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_readrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_readrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_readrecord','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_readrecord')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_readrecord','type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_readrecord')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '类型 1文章阅读记录  2文章马克记录 3邀请阅读记录 4邀请新用户记录'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_readrecord','article_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_readrecord')." ADD   `article_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_readrecord','date')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_readrecord')." ADD   `date` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_readrecord','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_readrecord')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_readrecord','invited_openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_readrecord')." ADD   `invited_openid` varchar(60) DEFAULT NULL COMMENT '邀请用户'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_readrecord','is_mark')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_readrecord')." ADD   `is_mark` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1收藏 0取消收藏'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_system` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','appid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `appid` varchar(100) NOT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `appsecret` varchar(200) NOT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','mchid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `mchid` varchar(20) NOT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','url_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `url_name` varchar(20) NOT NULL COMMENT '网址名称'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','details')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `details` text NOT NULL COMMENT '关于我们'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `url_logo` varchar(100) NOT NULL COMMENT '网址logo'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `bq_name` varchar(50) NOT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','link_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `link_name` varchar(30) NOT NULL COMMENT '网站名称'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `link_logo` varchar(100) NOT NULL COMMENT '网站logo'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','support')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `support` varchar(20) NOT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `bq_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `fontcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','color')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `color` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tz_appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tz_name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','pt_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `pt_name` varchar(30) NOT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tz_audit')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tz_audit` int(11) NOT NULL COMMENT '帖子审核1.是 2否'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','sj_audit')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `sj_audit` int(11) NOT NULL COMMENT '商家审核1.是 2否'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','mapkey')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `mapkey` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','gd_key')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `gd_key` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','hb_sxf')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `hb_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tx_money')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tx_sxf')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tx_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tx_details')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tx_details` text NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','rz_xuz')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `rz_xuz` text NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','ft_xuz')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `ft_xuz` text NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','fx_money')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `fx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_hhr')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_hhr` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_hbfl')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_hbfl` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_zx')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_zx` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_car')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_car` int(4) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','pc_xuz')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `pc_xuz` text NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','pc_money')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `pc_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_sjrz')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_sjrz` int(4) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_pcfw')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_pcfw` int(4) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','total_num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `total_num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_goods')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_goods` int(4) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `apiclient_cert` text NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `apiclient_key` text NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_openzx')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_openzx` int(4) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_hyset')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_hyset` int(4) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_tzopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_tzopen` int(4) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_pageopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_pageopen` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','cityname')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_tel` int(4) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tx_mode')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tx_mode` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','many_city')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `many_city` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tx_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tx_type` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_hbzf')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_hbzf` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','hb_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `hb_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tz_num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tz_num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `client_ip` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','hb_content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `hb_content` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_vipcardopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_vipcardopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_jkopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_jkopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `address` varchar(150) DEFAULT NULL COMMENT '店铺地址'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','sj_ruzhu')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `sj_ruzhu` int(5) DEFAULT NULL COMMENT '0为关闭1为开启'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_kanjiaopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_kanjiaopen` int(4) DEFAULT '0' COMMENT '0关闭1开启'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','bargain_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `bargain_price` varchar(10) DEFAULT NULL COMMENT '每次砍价的%'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','sign')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `sign` varchar(12) DEFAULT NULL COMMENT '本店招牌自定义'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','bargain_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `bargain_title` varchar(15) DEFAULT NULL COMMENT '砍价分享标题'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_pintuanopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_pintuanopen` int(4) DEFAULT NULL COMMENT '2为关闭1为开启'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','refund')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `refund` int(4) DEFAULT '1' COMMENT '1为买家申请2为自动退款'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','refund_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `refund_time` int(4) DEFAULT '0' COMMENT '自动退款时间 1为24；2为48；3为72；4为活动结束；5为不退款'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','groups_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `groups_title` varchar(45) DEFAULT NULL COMMENT '拼团分享标题'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','mask')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `mask` int(2) DEFAULT '1' COMMENT '0不显示1显示'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','announcement')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `announcement` varchar(60) DEFAULT NULL COMMENT '首页公告'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','shopmsg_status')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `shopmsg_status` tinyint(1) DEFAULT NULL COMMENT '欢迎语开关'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','shopmsg')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `shopmsg` varchar(60) DEFAULT NULL COMMENT '欢迎语'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','shopmsg2')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `shopmsg2` varchar(60) DEFAULT NULL COMMENT '问题咨询'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','shopmsg_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `shopmsg_img` varchar(200) DEFAULT NULL COMMENT '欢迎头像'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_yuyueopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_yuyueopen` int(4) DEFAULT NULL COMMENT '开启预约 1开启 2禁用'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','yuyue_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `yuyue_title` varchar(60) DEFAULT NULL COMMENT '预约分享标题'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_haowuopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_haowuopen` int(4) DEFAULT NULL COMMENT '开启好物'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','haowu_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `haowu_title` varchar(60) DEFAULT NULL COMMENT '好物分享标题'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_couponopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_couponopen` int(4) DEFAULT NULL COMMENT '开启优惠券 1开启 2禁用'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','coupon_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `coupon_title` varchar(60) DEFAULT NULL COMMENT '分享优惠券标题'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','coupon_banner')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `coupon_banner` varchar(200) DEFAULT NULL COMMENT '优惠券banner'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_gywmopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_gywmopen` int(4) DEFAULT NULL COMMENT '开启关于我们'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','gywm_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `gywm_title` varchar(60) DEFAULT NULL COMMENT '分享关于我们标题'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_xianshigouopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_xianshigouopen` int(4) DEFAULT NULL COMMENT '开启限时购 1开启 '");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','xianshigou_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `xianshigou_title` varchar(60) DEFAULT NULL COMMENT '分享限时购标题'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_shareopen')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_shareopen` int(4) DEFAULT NULL COMMENT '开启分享 1开启'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','share_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `share_title` varchar(60) DEFAULT NULL COMMENT '分享分享标题'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','customer_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `customer_time` varchar(30) DEFAULT NULL COMMENT '客服时间'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','provide')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `provide` varchar(255) DEFAULT NULL COMMENT '基础服务'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','shop_banner')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `shop_banner` text COMMENT '商店banner'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','shop_details')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `shop_details` text COMMENT '商店介绍'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','gywm_banner')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `gywm_banner` varchar(200) DEFAULT NULL COMMENT '关于我们banner'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','shopdes')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `shopdes` text COMMENT '商店介绍 详情'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','shopdes_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `shopdes_img` text COMMENT '商店介绍图'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','distribution')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','ziti_address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `ziti_address` varchar(200) DEFAULT NULL COMMENT '商家自提地址'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','ddmd_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `ddmd_img` varchar(100) DEFAULT NULL COMMENT '到店买单头像'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','ddmd_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `ddmd_title` varchar(100) DEFAULT NULL COMMENT '到店买单商户名称'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','hx_openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `hx_openid` text COMMENT '核销人员openid'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','tag')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `tag` varchar(200) DEFAULT NULL COMMENT '店铺标签'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_by')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_by` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否全店包邮'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_xxpf')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_xxpf` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否先行赔付'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_qtwy')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_qtwy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否七天无忧退款退货'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','yuyue_sort')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `yuyue_sort` int(11) NOT NULL DEFAULT '0' COMMENT '预约 首页推荐排序'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','haowu_sort')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `haowu_sort` int(11) NOT NULL DEFAULT '0' COMMENT '好物 首页推荐排序'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','groups_sort')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `groups_sort` int(11) NOT NULL DEFAULT '0' COMMENT '拼团 首页推荐排序'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','bargain_sort')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `bargain_sort` int(11) NOT NULL DEFAULT '0' COMMENT '砍价 首页推荐排序'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','xianshigou_sort')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `xianshigou_sort` int(11) NOT NULL DEFAULT '0' COMMENT '限时购首页推荐 排序'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','share_sort')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `share_sort` int(11) NOT NULL DEFAULT '0' COMMENT '分享首页推荐排序'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','xinpin_sort')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `xinpin_sort` int(11) NOT NULL DEFAULT '0' COMMENT '新品 首页推荐排序'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','index_adv_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `index_adv_img` varchar(100) DEFAULT NULL COMMENT '首页广告图'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_adv')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_adv` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启首页广告 1开启'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','share_rule')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `share_rule` text COMMENT '分享金规则'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','groups_rule')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `groups_rule` text COMMENT '拼团规则说明'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','coordinates')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `coordinates` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','longitude')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `longitude` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','latitude')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `latitude` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','index_title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `index_title` varchar(60) DEFAULT NULL COMMENT '首页自定义标题'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','hz_tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `hz_tel` varchar(60) DEFAULT NULL COMMENT '首页合作电话'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','jszc_img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `jszc_img` varchar(200) DEFAULT NULL COMMENT '技术支持头像'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','jszc_tdcp')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `jszc_tdcp` varchar(200) DEFAULT NULL COMMENT '首页技术支持团队出品'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','index_layout')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `index_layout` text COMMENT '首页布局'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_layout')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_layout` tinyint(4) DEFAULT '0' COMMENT '首页布局开关 1开'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_techzhichi')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_techzhichi` tinyint(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','store_open')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `store_open` tinyint(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','lottery_score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `lottery_score` int(11) NOT NULL DEFAULT '0' COMMENT '抽奖消费积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','lottery_rule')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `lottery_rule` text COMMENT '抽奖规则'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','aboutus')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `aboutus` text COMMENT '关于我们'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_system','is_show')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_system')." ADD   `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 '");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_task` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_task','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_task')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_task','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_task')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_task','type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_task')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '任务类型 1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖 6马克 7邀请好友'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_task','title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_task')." ADD   `title` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_task','icon')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_task')." ADD   `icon` varchar(250) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_task','task_num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_task')." ADD   `task_num` int(11) NOT NULL DEFAULT '1' COMMENT '任务数'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_task','score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_task')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT '积分完成一个任务得到积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_task','task_score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_task')." ADD   `task_score` int(11) NOT NULL DEFAULT '0' COMMENT '任务页面显示积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_task','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_task')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_taskrecord` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `openid` varchar(60) DEFAULT NULL COMMENT '用户openid(获得积分的用户)'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖(增加) 6马克 7邀请新用户 8兑换积分商品 9积分抽奖(消耗) 10抽奖中奖积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','task_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `task_id` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','sign')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT '获得积分'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','date')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `date` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','article_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `article_id` int(11) DEFAULT NULL COMMENT '文章id 阅读和邀请看文章使用 马克'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','beinvited_openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `beinvited_openid` varchar(60) DEFAULT NULL COMMENT '被邀请用户openid 邀请看文章使用 、好友砍积分使用、新用户'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `goods_id` int(11) DEFAULT NULL COMMENT '商品id 砍价积分商品使用 '");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskrecord','prize_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskrecord')." ADD   `prize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_plugin_scoretask_taskset` (
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

");

if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskset','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskset','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskset')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskset','task_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskset')." ADD   `task_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskset','task_type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskset')." ADD   `task_type` tinyint(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskset','title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskset')." ADD   `title` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskset','score')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskset')." ADD   `score` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskset','icon')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskset')." ADD   `icon` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_plugin_scoretask_taskset','add_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_plugin_scoretask_taskset')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_province` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_province','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_province')." ADD 
  `id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_province','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_province')." ADD   `name` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` int(5) DEFAULT NULL,
  `give_money` int(5) DEFAULT NULL,
  `used` int(1) DEFAULT '1',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_recharge','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_recharge')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_recharge','money')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_recharge')." ADD   `money` int(5) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_recharge','give_money')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_recharge')." ADD   `give_money` int(5) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_recharge','used')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_recharge')." ADD   `used` int(1) DEFAULT '1'");}
if(!pdo_fieldexists('yzhyk_sun_recharge','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_recharge')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_rechargecode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recharge_code` varchar(255) DEFAULT NULL,
  `membercard_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_rechargecode','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_rechargecode')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_rechargecode','recharge_code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_rechargecode')." ADD   `recharge_code` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_rechargecode','membercard_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_rechargecode')." ADD   `membercard_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_rechargecode','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_rechargecode')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_role','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_role')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_role','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_role')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_role','memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_role')." ADD   `memo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_role','role_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_role')." ADD   `role_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_role','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_role')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_roleauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `button_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=339 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_roleauth','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_roleauth')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_roleauth','role_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_roleauth')." ADD   `role_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_roleauth','menu_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_roleauth')." ADD   `menu_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_roleauth','button_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_roleauth')." ADD   `button_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_roleauth','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_roleauth')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_searchrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) DEFAULT NULL,
  `search` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_searchrecord','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_searchrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_searchrecord','keyword')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_searchrecord')." ADD   `keyword` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_searchrecord','search')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_searchrecord')." ADD   `search` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_searchrecord','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_searchrecord')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_searchrecord','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_searchrecord')." ADD   `time` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_searchrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_searchrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_sms` (
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

");

if(!pdo_fieldexists('yzhyk_sun_sms','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_sms','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_sms','appkey')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `appkey` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_sms','is_open')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `is_open` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzhyk_sun_sms','smstype')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `smstype` tinyint(2) NOT NULL DEFAULT '1' COMMENT '短信类型，1为253，3为大鱼'");}
if(!pdo_fieldexists('yzhyk_sun_sms','ytx_apiaccount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `ytx_apiaccount` varchar(50) NOT NULL COMMENT '253短信账号'");}
if(!pdo_fieldexists('yzhyk_sun_sms','ytx_apipass')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `ytx_apipass` varchar(50) NOT NULL COMMENT '253短信密码'");}
if(!pdo_fieldexists('yzhyk_sun_sms','ytx_apiurl')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `ytx_apiurl` varchar(50) NOT NULL COMMENT '253短信地址'");}
if(!pdo_fieldexists('yzhyk_sun_sms','ytx_order')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `ytx_order` varchar(255) NOT NULL COMMENT '云通信订单消息提醒'");}
if(!pdo_fieldexists('yzhyk_sun_sms','ytx_orderrefund')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `ytx_orderrefund` varchar(255) NOT NULL COMMENT '云通信退款订单消息提醒'");}
if(!pdo_fieldexists('yzhyk_sun_sms','aly_accesskeyid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `aly_accesskeyid` varchar(255) NOT NULL COMMENT '阿里大鱼 accessKeyId'");}
if(!pdo_fieldexists('yzhyk_sun_sms','aly_accesskeysecret')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `aly_accesskeysecret` varchar(255) NOT NULL COMMENT '阿里大鱼 AccessKeySecret'");}
if(!pdo_fieldexists('yzhyk_sun_sms','aly_order')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `aly_order` varchar(255) NOT NULL COMMENT '阿里大鱼 订单模板'");}
if(!pdo_fieldexists('yzhyk_sun_sms','aly_orderrefund')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `aly_orderrefund` varchar(255) NOT NULL COMMENT '阿里大鱼 退款模板'");}
if(!pdo_fieldexists('yzhyk_sun_sms','aly_sign')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `aly_sign` varchar(100) NOT NULL COMMENT '签名'");}
if(!pdo_fieldexists('yzhyk_sun_sms','dy_code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_sms')." ADD   `dy_code` varchar(100) NOT NULL COMMENT '大鱼短信验证'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_store` (
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

");

if(!pdo_fieldexists('yzhyk_sun_store','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD 
  `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','isdel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `isdel` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_store','tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `tel` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_store','code')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `code` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','latitude')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('yzhyk_sun_store','longitude')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('yzhyk_sun_store','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','province_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `province_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','city_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `city_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','county_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `county_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','feie_user')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `feie_user` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','feie_ukey')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `feie_ukey` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','feie_sn')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `feie_sn` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','dingtalk_token')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `dingtalk_token` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','dispatch_detail')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `dispatch_detail` varchar(200) DEFAULT '' COMMENT '配送时间描述'");}
if(!pdo_fieldexists('yzhyk_sun_store','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `user_id` int(11) DEFAULT NULL COMMENT '到账id'");}
if(!pdo_fieldexists('yzhyk_sun_store','user_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `user_name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_store','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT '到账微信openid'");}
if(!pdo_fieldexists('yzhyk_sun_store','balance')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_store')." ADD   `balance` decimal(10,2) DEFAULT '0.00' COMMENT '余额'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_storeactivity` (
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

");

if(!pdo_fieldexists('yzhyk_sun_storeactivity','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivity')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_storeactivity','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivity')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivity','activity_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivity')." ADD   `activity_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivity','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivity')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivity','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivity')." ADD   `name` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivity','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivity')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivity','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivity')." ADD   `end_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivity','update_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivity')." ADD   `update_time` int(20) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_storeactivitygoods` (
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

");

if(!pdo_fieldexists('yzhyk_sun_storeactivitygoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivitygoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_storeactivitygoods','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivitygoods')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivitygoods','stock')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivitygoods')." ADD   `stock` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivitygoods','activity_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivitygoods')." ADD   `activity_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivitygoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivitygoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivitygoods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivitygoods')." ADD   `goods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivitygoods','price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivitygoods')." ADD   `price` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storeactivitygoods','limit')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivitygoods')." ADD   `limit` int(11) DEFAULT NULL COMMENT '限购数量'");}
if(!pdo_fieldexists('yzhyk_sun_storeactivitygoods','storeactivity_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storeactivitygoods')." ADD   `storeactivity_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_storebill` (
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

");

if(!pdo_fieldexists('yzhyk_sun_storebill','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storebill')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq'");}
if(!pdo_fieldexists('yzhyk_sun_storebill','content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storebill')." ADD   `content` varchar(100) DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzhyk_sun_storebill','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storebill')." ADD   `time` varchar(50) DEFAULT NULL COMMENT '登录时间'");}
if(!pdo_fieldexists('yzhyk_sun_storebill','type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storebill')." ADD   `type` int(1) DEFAULT NULL COMMENT '1、线上支付\r\n2、扫码购\r\n3、商城\r\n6、门店提现'");}
if(!pdo_fieldexists('yzhyk_sun_storebill','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storebill')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storebill','balance')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storebill')." ADD   `balance` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storebill','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storebill')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storebill','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storebill')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_storecoupon` (
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

");

if(!pdo_fieldexists('yzhyk_sun_storecoupon','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','left_num')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `left_num` int(11) DEFAULT NULL COMMENT '余量'");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `end_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','use_amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `use_amount` int(4) DEFAULT NULL COMMENT '启用金额'");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `amount` int(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','days')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `days` int(11) DEFAULT NULL COMMENT '有效天数'");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecoupon','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecoupon')." ADD   `coupon_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_storecutgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `is_hot` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  `cutgoods_id` int(11) DEFAULT NULL,
  `stock` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_storecutgoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecutgoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_storecutgoods','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecutgoods')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecutgoods','is_hot')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecutgoods')." ADD   `is_hot` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_storecutgoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecutgoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecutgoods','cutgoods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecutgoods')." ADD   `cutgoods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storecutgoods','stock')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storecutgoods')." ADD   `stock` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_storegoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `shop_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `ishot` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=724 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_storegoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_storegoods','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegoods')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storegoods','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegoods')." ADD   `goods_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storegoods','shop_price')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegoods')." ADD   `shop_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storegoods','stock')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegoods')." ADD   `stock` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storegoods','ishot')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegoods')." ADD   `ishot` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_storegoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_storegroupgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `is_hot` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  `groupgoods_id` int(11) DEFAULT NULL,
  `stock` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_storegroupgoods','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegroupgoods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_storegroupgoods','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegroupgoods')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storegroupgoods','is_hot')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegroupgoods')." ADD   `is_hot` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_storegroupgoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegroupgoods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storegroupgoods','groupgoods_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegroupgoods')." ADD   `groupgoods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storegroupgoods','stock')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storegroupgoods')." ADD   `stock` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_storetakerecord` (
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

");

if(!pdo_fieldexists('yzhyk_sun_storetakerecord','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_storetakerecord','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storetakerecord','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD   `time` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storetakerecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storetakerecord','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storetakerecord','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD   `state` int(4) DEFAULT '1' COMMENT '-3失败，-2拒绝，1待审核，2待打款，3完成'");}
if(!pdo_fieldexists('yzhyk_sun_storetakerecord','fail_reason')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD   `fail_reason` varchar(100) DEFAULT NULL COMMENT '失败原因'");}
if(!pdo_fieldexists('yzhyk_sun_storetakerecord','balance')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD   `balance` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_storetakerecord','paycommission')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金'");}
if(!pdo_fieldexists('yzhyk_sun_storetakerecord','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_storetakerecord')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_system` (
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

");

if(!pdo_fieldexists('yzhyk_sun_system','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('yzhyk_sun_system','appid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `appid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('yzhyk_sun_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `appsecret` varchar(200) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('yzhyk_sun_system','mchid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `mchid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('yzhyk_sun_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `wxkey` varchar(250) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('yzhyk_sun_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','url_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `url_name` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '网址名称'");}
if(!pdo_fieldexists('yzhyk_sun_system','details')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `details` text COMMENT '关于我们'");}
if(!pdo_fieldexists('yzhyk_sun_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `url_logo` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '网址logo'");}
if(!pdo_fieldexists('yzhyk_sun_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `bq_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('yzhyk_sun_system','link_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `link_name` varchar(30) DEFAULT NULL COMMENT '网站名称'");}
if(!pdo_fieldexists('yzhyk_sun_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `link_logo` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '网站logo'");}
if(!pdo_fieldexists('yzhyk_sun_system','support')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `support` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('yzhyk_sun_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `bq_logo` varchar(100) CHARACTER SET latin1 DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','color')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `color` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '颜色'");}
if(!pdo_fieldexists('yzhyk_sun_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `tz_appid` varchar(50) CHARACTER SET latin1 DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `tz_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','pt_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `pt_name` varchar(100) DEFAULT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('yzhyk_sun_system','tz_audit')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `tz_audit` int(11) DEFAULT NULL COMMENT '帖子审核1.是 2否'");}
if(!pdo_fieldexists('yzhyk_sun_system','sj_audit')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `sj_audit` int(11) DEFAULT NULL COMMENT '商家审核1.是 2否'");}
if(!pdo_fieldexists('yzhyk_sun_system','cityname')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `cityname` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','mail')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `mail` varchar(100) CHARACTER SET latin1 DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `tel` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `pic` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `client_ip` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `apiclient_key` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `apiclient_cert` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `fontcolor` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','postage_base')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `postage_base` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','postage_county')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `postage_county` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','postage_city')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `postage_city` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','postage_province')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `postage_province` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','integral1')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `integral1` int(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','integral2')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `integral2` int(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','integral3')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `integral3` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','card_pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `card_pic` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','team_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `team_name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','team_tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `team_tel` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','team_logo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `team_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','min_amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `min_amount` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','activity_memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `activity_memo` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','activity_pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `activity_pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','activity_pic2')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `activity_pic2` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','app_fcolor')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `app_fcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','app_bcolor')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `app_bcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','app_tbcolor')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `app_tbcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','app_tfcolor')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `app_tfcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','app_tsfcolor')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `app_tsfcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','discount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `discount` decimal(5,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','ad_show')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `ad_show` varchar(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','ad_link')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `ad_link` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','ad_value')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `ad_value` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','ad_pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `ad_pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','ad_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `ad_name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','template_id_buy')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `template_id_buy` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','template_id_sale')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `template_id_sale` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','recharge_memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `recharge_memo` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','recharge_pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `recharge_pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','team_show')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `team_show` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_system','member_charge')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `member_charge` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','member_upgrade')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `member_upgrade` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_system','group_pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `group_pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','group_pic2')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `group_pic2` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','cut_pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `cut_pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','cut_pic2')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `cut_pic2` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','member_memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `member_memo` varchar(255) DEFAULT NULL COMMENT '会员等级说明'");}
if(!pdo_fieldexists('yzhyk_sun_system','withdraw_switch')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `withdraw_switch` int(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','withdraw_min')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `withdraw_min` decimal(15,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','withdraw_noapplymoney')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `withdraw_noapplymoney` decimal(15,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','withdraw_wechatrate')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `withdraw_wechatrate` decimal(15,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','withdraw_platformrate')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `withdraw_platformrate` decimal(15,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','withdraw_content')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `withdraw_content` text");}
if(!pdo_fieldexists('yzhyk_sun_system','developkey')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `developkey` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','bghead')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `bghead` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','is_start')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `is_start` int(2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_system','phone_switch')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   `phone_switch` int(2) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_system','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_system')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_tab` (
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

");

if(!pdo_fieldexists('yzhyk_sun_tab','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_tab')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_tab','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_tab')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_tab','title')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_tab')." ADD   `title` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_tab','page')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_tab')." ADD   `page` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_tab','pic')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_tab')." ADD   `pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_tab','pic_s')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_tab')." ADD   `pic_s` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_tab','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_tab')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_tab','tab_index')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_tab')." ADD   `tab_index` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_task` (
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

");

if(!pdo_fieldexists('yzhyk_sun_task','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_task','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_task','type')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `type` varchar(100) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('yzhyk_sun_task','create_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `create_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_task','update_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `update_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_task','memo')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `memo` varchar(255) DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzhyk_sun_task','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用'");}
if(!pdo_fieldexists('yzhyk_sun_task','level')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `level` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('yzhyk_sun_task','value')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `value` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_task','execute_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `execute_time` int(11) DEFAULT NULL COMMENT '预计执行时间'");}
if(!pdo_fieldexists('yzhyk_sun_task','execute_times')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_task')." ADD   `execute_times` int(11) DEFAULT '0' COMMENT '尝试执行次数'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_user` (
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

");

if(!pdo_fieldexists('yzhyk_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq'");}
if(!pdo_fieldexists('yzhyk_sun_user','openid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzhyk_sun_user','img')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `img` varchar(200) DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('yzhyk_sun_user','time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `time` varchar(50) DEFAULT NULL COMMENT '登录时间'");}
if(!pdo_fieldexists('yzhyk_sun_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','money')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `money` decimal(11,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yzhyk_sun_user','user_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `user_name` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','tel')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `tel` varchar(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','user_address')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `user_address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','commission')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `commission` decimal(11,0) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','state')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `state` int(4) DEFAULT '1'");}
if(!pdo_fieldexists('yzhyk_sun_user','attention')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `attention` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','fans')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `fans` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','collection')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `collection` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','latitude')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `latitude` decimal(15,8) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('yzhyk_sun_user','longitude')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `longitude` decimal(15,8) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('yzhyk_sun_user','birthday')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `birthday` varchar(40) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','gender')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `gender` int(1) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','email')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `email` varchar(40) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','integral')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `integral` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','integral1')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `integral1` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','balance')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `balance` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','admin_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `admin_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','level_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `level_id` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_user','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `amount` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yzhyk_sun_user','isbuy')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `isbuy` int(2) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_user','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `end_time` varchar(50) DEFAULT NULL COMMENT '会员过期时间'");}
if(!pdo_fieldexists('yzhyk_sun_user','parents_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `parents_id` int(11) NOT NULL COMMENT '上级id'");}
if(!pdo_fieldexists('yzhyk_sun_user','parents_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `parents_name` varchar(255) NOT NULL COMMENT '上级名称'");}
if(!pdo_fieldexists('yzhyk_sun_user','spare_parents_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `spare_parents_id` int(11) NOT NULL COMMENT '备用上级id'");}
if(!pdo_fieldexists('yzhyk_sun_user','spare_parents_name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   `spare_parents_name` varchar(255) NOT NULL COMMENT '备用上级用户名'");}
if(!pdo_fieldexists('yzhyk_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_user')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_usercoupon` (
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

");

if(!pdo_fieldexists('yzhyk_sun_usercoupon','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','name')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `begin_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','end_time')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `end_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','use_amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `use_amount` int(4) DEFAULT NULL COMMENT '启用金额'");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','amount')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `amount` int(4) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','is_used')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `is_used` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `coupon_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','storecoupon_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `storecoupon_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_usercoupon','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_usercoupon')." ADD   `store_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzhyk_sun_userrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzhyk_sun_userrole','id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_userrole')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzhyk_sun_userrole','user_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_userrole')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_userrole','role_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_userrole')." ADD   `role_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_userrole','store_id')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_userrole')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzhyk_sun_userrole','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzhyk_sun_userrole')." ADD   `uniacid` int(11) DEFAULT NULL");}
