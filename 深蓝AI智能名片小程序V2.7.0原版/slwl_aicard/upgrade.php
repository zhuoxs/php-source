<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_adact` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `subtitle` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `detail` text,
  `out_thumb` varchar(255) DEFAULT '',
  `out_link` varchar(255) DEFAULT '',
  `enabled` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_adact','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_adact','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_adact','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_adact','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_adact','subtitle')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `subtitle` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_adact','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_adact','detail')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `detail` text");}
if(!pdo_fieldexists('slwl_aicard_adact','out_thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `out_thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_adact','out_link')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `out_link` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_adact','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `enabled` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_adact','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adact')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_adgroup` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `setting_name` varchar(100) DEFAULT '',
  `setting_value` longtext,
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_adgroup','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adgroup')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_adgroup','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adgroup')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_adgroup','setting_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adgroup')." ADD   `setting_name` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_adgroup','setting_value')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adgroup')." ADD   `setting_value` longtext");}
if(!pdo_fieldexists('slwl_aicard_adgroup','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_adgroup')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_card` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT '',
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `nick_name` varchar(255) DEFAULT '',
  `last_name` varchar(255) DEFAULT '',
  `middle_name` varchar(255) DEFAULT '',
  `first_name` varchar(255) DEFAULT '',
  `honour` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `mobile` varchar(50) DEFAULT '',
  `mobile_show` varchar(50) DEFAULT '',
  `email` varchar(255) DEFAULT '',
  `other_attr` text,
  `attr` text,
  `view` bigint(20) DEFAULT '0',
  `like` bigint(20) DEFAULT '0',
  `relay` bigint(20) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `pic_show` tinyint(4) DEFAULT '0',
  `pic_title` varchar(255) DEFAULT '',
  `pic_content` text,
  `isdefault` tinyint(4) DEFAULT '0',
  `enabled` tinyint(4) DEFAULT '0',
  `ai_ctrl_enabled` tinyint(4) DEFAULT '1',
  `boss_ctrl_enabled` tinyint(4) DEFAULT '0',
  `qrcode` varchar(255) DEFAULT '',
  `card_style` varchar(255) DEFAULT 'standard',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  `join_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_card','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_card','userid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `userid` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_card','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','nick_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `nick_name` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','last_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `last_name` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','middle_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `middle_name` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','first_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `first_name` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','honour')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `honour` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','mobile')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `mobile` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','mobile_show')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `mobile_show` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','email')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `email` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','other_attr')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `other_attr` text");}
if(!pdo_fieldexists('slwl_aicard_card','attr')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `attr` text");}
if(!pdo_fieldexists('slwl_aicard_card','view')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `view` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_card','like')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `like` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_card','relay')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `relay` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_card','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_card','pic_show')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `pic_show` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_card','pic_title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `pic_title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','pic_content')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `pic_content` text");}
if(!pdo_fieldexists('slwl_aicard_card','isdefault')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `isdefault` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_card','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_card','ai_ctrl_enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `ai_ctrl_enabled` tinyint(4) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_card','boss_ctrl_enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `boss_ctrl_enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_card','qrcode')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `qrcode` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_card','card_style')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `card_style` varchar(255) DEFAULT 'standard'");}
if(!pdo_fieldexists('slwl_aicard_card','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_card','join_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card')." ADD   `join_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_card_goods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `card_id` bigint(20) DEFAULT NULL,
  `good_id` bigint(20) DEFAULT NULL,
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_card_goods','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card_goods')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_card_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card_goods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_card_goods','card_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card_goods')." ADD   `card_id` bigint(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_card_goods','good_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card_goods')." ADD   `good_id` bigint(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_card_goods','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_card_goods')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_commission` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT '0',
  `id_com_1` int(11) DEFAULT '0',
  `id_com_2` int(11) DEFAULT '0',
  `id_com_3` int(11) DEFAULT '0',
  `status` tinyint(4) DEFAULT '0',
  `create_time` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('slwl_aicard_commission','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_commission','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_commission','id_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission')." ADD   `id_user` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission','id_com_1')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission')." ADD   `id_com_1` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission','id_com_2')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission')." ADD   `id_com_2` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission','id_com_3')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission')." ADD   `id_com_3` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission')." ADD   `status` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission','create_time')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission')." ADD   `create_time` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_commission_brokerage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT '0',
  `money` int(11) DEFAULT '0',
  `money_withdraw` int(11) DEFAULT '0',
  `money_total` int(11) DEFAULT '0',
  `create_time` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('slwl_aicard_commission_brokerage','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage','id_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage')." ADD   `id_user` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage','money')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage')." ADD   `money` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage','money_withdraw')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage')." ADD   `money_withdraw` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage','money_total')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage')." ADD   `money_total` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage','create_time')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage')." ADD   `create_time` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_commission_brokerage_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT '0',
  `money` int(11) DEFAULT '0',
  `status` tinyint(4) DEFAULT '0',
  `mark` text,
  `create_time` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('slwl_aicard_commission_brokerage_log','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage_log')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage_log','id_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage_log')." ADD   `id_user` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage_log','money')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage_log')." ADD   `money` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage_log','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage_log')." ADD   `status` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage_log','mark')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage_log')." ADD   `mark` text");}
if(!pdo_fieldexists('slwl_aicard_commission_brokerage_log','create_time')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_brokerage_log')." ADD   `create_time` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_commission_order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT '0',
  `id_order` int(11) DEFAULT '0',
  `id_order_user` int(11) DEFAULT '0',
  `money` int(11) DEFAULT '0',
  `type` varchar(255) DEFAULT '',
  `status` tinyint(4) DEFAULT '0',
  `rebate` text,
  `create_time` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('slwl_aicard_commission_order','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_commission_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_commission_order','id_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD   `id_user` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_order','id_order')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD   `id_order` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_order','id_order_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD   `id_order_user` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_order','money')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD   `money` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_order','type')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD   `type` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_commission_order','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD   `status` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_order','rebate')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD   `rebate` text");}
if(!pdo_fieldexists('slwl_aicard_commission_order','create_time')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_order')." ADD   `create_time` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_commission_settle_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT '0',
  `money_order` int(11) DEFAULT '0',
  `money_brokerage` int(11) DEFAULT '0',
  `id_order` int(11) DEFAULT '0',
  `info` text,
  `create_time` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('slwl_aicard_commission_settle_log','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_settle_log')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_commission_settle_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_settle_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_commission_settle_log','id_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_settle_log')." ADD   `id_user` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_settle_log','money_order')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_settle_log')." ADD   `money_order` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_settle_log','money_brokerage')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_settle_log')." ADD   `money_brokerage` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_settle_log','id_order')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_settle_log')." ADD   `id_order` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_commission_settle_log','info')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_settle_log')." ADD   `info` text");}
if(!pdo_fieldexists('slwl_aicard_commission_settle_log','create_time')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_commission_settle_log')." ADD   `create_time` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_custom_poster` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_custom_poster','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_custom_poster')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_custom_poster','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_custom_poster')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_custom_poster','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_custom_poster')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_custom_poster','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_custom_poster')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_custom_poster','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_custom_poster')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_custom_poster','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_custom_poster')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_custom_poster','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_custom_poster')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_dept` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `name` varchar(100) DEFAULT '',
  `enabled` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_dept','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dept')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_dept','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dept')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dept','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dept')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dept','name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dept')." ADD   `name` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dept','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dept')." ADD   `enabled` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dept','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dept')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_dynamic_act` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `dy_type` int(11) DEFAULT '0',
  `title` varchar(200) DEFAULT '',
  `subtitle` varchar(500) DEFAULT '',
  `like_count` bigint(20) DEFAULT '0',
  `thumb` varchar(500) DEFAULT '',
  `detail` text,
  `createtime` int(11) DEFAULT NULL,
  `enabled` int(11) DEFAULT '0',
  `out_thumb` varchar(255) DEFAULT '',
  `out_link` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_dynamic_act','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','dy_type')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `dy_type` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `title` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','subtitle')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `subtitle` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','like_count')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `like_count` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `thumb` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','detail')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `detail` text");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','createtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `createtime` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `enabled` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','out_thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `out_thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','out_link')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `out_link` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_act','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_act')." ADD   `addtime` datetime DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_dynamic_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` bigint(20) DEFAULT NULL,
  `nicename` text,
  `openid` varchar(100) DEFAULT '',
  `unionid` varchar(100) DEFAULT '',
  `dy_id` bigint(20) DEFAULT NULL,
  `content` varchar(255) DEFAULT '',
  `status` tinyint(4) DEFAULT '0',
  `enabled` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_dynamic_comment','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','user_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `user_id` bigint(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','nicename')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `nicename` text");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','openid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `openid` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','unionid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `unionid` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','dy_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `dy_id` bigint(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','content')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `content` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `status` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dynamic_comment','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_comment')." ADD   `addtime` datetime DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_dynamic_islike` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` bigint(20) DEFAULT NULL,
  `nicename` text,
  `openid` varchar(100) DEFAULT '',
  `unionid` varchar(100) DEFAULT '',
  `dy_id` bigint(20) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=332 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_dynamic_islike','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_islike')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_dynamic_islike','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_islike')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_dynamic_islike','user_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_islike')." ADD   `user_id` bigint(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_dynamic_islike','nicename')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_islike')." ADD   `nicename` text");}
if(!pdo_fieldexists('slwl_aicard_dynamic_islike','openid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_islike')." ADD   `openid` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_islike','unionid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_islike')." ADD   `unionid` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_dynamic_islike','dy_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_islike')." ADD   `dy_id` bigint(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_dynamic_islike','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_dynamic_islike')." ADD   `addtime` datetime DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_formid` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT '0',
  `openid` varchar(100) DEFAULT '',
  `unionid` varchar(100) DEFAULT '',
  `form_id` varchar(255) DEFAULT '',
  `op_code` varchar(100) DEFAULT '',
  `op_text` varchar(255) DEFAULT '',
  `status` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83679 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_formid','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_formid','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_formid','user_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD   `user_id` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_formid','openid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD   `openid` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_formid','unionid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD   `unionid` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_formid','form_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD   `form_id` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_formid','op_code')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD   `op_code` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_formid','op_text')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD   `op_text` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_formid','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD   `status` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_formid','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_formid')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_impression` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `enabled` tinyint(4) DEFAULT '0',
  `like_count` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('slwl_aicard_impression','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_impression','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_impression','card_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression')." ADD   `card_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_impression','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_impression','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_impression','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_impression','like_count')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression')." ADD   `like_count` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_impression','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_impression_like` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `card_id` int(11) DEFAULT '0',
  `impression_id` int(11) DEFAULT '0',
  `islike` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=436 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('slwl_aicard_impression_like','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression_like')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_impression_like','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression_like')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_impression_like','user_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression_like')." ADD   `user_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_impression_like','card_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression_like')." ADD   `card_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_impression_like','impression_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression_like')." ADD   `impression_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_impression_like','islike')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression_like')." ADD   `islike` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_impression_like','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_impression_like')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_like` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `islike` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1644 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='点赞专用';

");

if(!pdo_fieldexists('slwl_aicard_like','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_like')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_like','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_like')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_like','user_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_like')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_like','card_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_like')." ADD   `card_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_like','islike')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_like')." ADD   `islike` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_like','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_like')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_mod_wxapp` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `page_url` varchar(255) DEFAULT '',
  `appid` varchar(255) DEFAULT '',
  `page_page` varchar(255) DEFAULT '',
  `enabled` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_mod_wxapp','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mod_wxapp')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_mod_wxapp','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mod_wxapp')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_mod_wxapp','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mod_wxapp')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_mod_wxapp','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mod_wxapp')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_mod_wxapp','page_url')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mod_wxapp')." ADD   `page_url` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_mod_wxapp','appid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mod_wxapp')." ADD   `appid` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_mod_wxapp','page_page')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mod_wxapp')." ADD   `page_page` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_mod_wxapp','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mod_wxapp')." ADD   `enabled` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_mod_wxapp','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mod_wxapp')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_mycard` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `source_id` int(11) DEFAULT '0',
  `source_name` varchar(255) DEFAULT '',
  `source_text` varchar(255) DEFAULT '',
  `enabled` tinyint(4) DEFAULT '1',
  `displayorder` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8088 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_mycard','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_mycard','user_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD   `user_id` bigint(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_mycard','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_mycard','card_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD   `card_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_mycard','source_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD   `source_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_mycard','source_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD   `source_name` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_mycard','source_text')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD   `source_text` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_mycard','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD   `enabled` tinyint(4) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_mycard','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_mycard','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_mycard')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_myuser` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `card_id` bigint(20) DEFAULT NULL,
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5412 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_myuser','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_myuser')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_myuser','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_myuser')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_myuser','user_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_myuser')." ADD   `user_id` bigint(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_myuser','card_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_myuser')." ADD   `card_id` bigint(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_myuser','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_myuser')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_oplogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `op_domain` varchar(255) DEFAULT '',
  `op_user` varchar(255) DEFAULT '',
  `op_type` varchar(255) DEFAULT '',
  `op_txt` text,
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111525 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_oplogs','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_oplogs')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_oplogs','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_oplogs')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_oplogs','op_domain')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_oplogs')." ADD   `op_domain` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_oplogs','op_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_oplogs')." ADD   `op_user` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_oplogs','op_type')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_oplogs')." ADD   `op_type` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_oplogs','op_txt')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_oplogs')." ADD   `op_txt` text");}
if(!pdo_fieldexists('slwl_aicard_oplogs','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_oplogs')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_product_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `title` varchar(200) DEFAULT '',
  `subtitle` varchar(200) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` tinyint(4) DEFAULT '0',
  `enabled` tinyint(4) DEFAULT '0',
  `detail` text,
  `out_thumb` varchar(255) DEFAULT '',
  `out_link` varchar(255) DEFAULT '',
  `createtime` datetime DEFAULT '2000-01-01 00:00:00',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_product_list','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_product_list','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_product_list','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `title` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_product_list','subtitle')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `subtitle` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_product_list','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_product_list','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `displayorder` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_product_list','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_product_list','detail')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `detail` text");}
if(!pdo_fieldexists('slwl_aicard_product_list','out_thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `out_thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_product_list','out_link')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `out_link` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_product_list','createtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `createtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_product_list','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_product_list')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `setting_name` varchar(100) DEFAULT '',
  `setting_value` longtext,
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_settings','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_settings')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_settings','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_settings')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_settings','setting_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_settings')." ADD   `setting_name` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_settings','setting_value')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_settings')." ADD   `setting_value` longtext");}
if(!pdo_fieldexists('slwl_aicard_settings','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_settings')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `uid` varchar(50) NOT NULL,
  `realname` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `area` varchar(30) NOT NULL,
  `address` varchar(300) NOT NULL,
  `isdefault` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_address','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_address','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_address','uid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `uid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_address','realname')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `realname` varchar(20) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_address','mobile')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `mobile` varchar(11) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_address','province')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `province` varchar(30) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_address','city')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `city` varchar(30) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_address','area')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `area` varchar(30) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_address','address')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `address` varchar(300) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_address','isdefault')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `isdefault` tinyint(3) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_address','deleted')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_address')." ADD   `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_adsp` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` tinyint(4) DEFAULT '0',
  `page_url` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_adsp','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adsp')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_adsp','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adsp')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_adsp','name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adsp')." ADD   `name` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_adsp','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adsp')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_adsp','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adsp')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_adsp','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adsp')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_adsp','page_url')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adsp')." ADD   `page_url` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_adsp','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adsp')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_adv` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `advname` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `enabled` tinyint(4) DEFAULT '0',
  `page_url` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_adv','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adv')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_adv','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adv')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_adv','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adv')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_adv','advname')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adv')." ADD   `advname` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_adv','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adv')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_adv','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adv')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_adv','page_url')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adv')." ADD   `page_url` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_adv','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_adv')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_brand` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `name` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `thumb_brand` varchar(255) DEFAULT '',
  `intro` varchar(1000) DEFAULT '',
  `enabled` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_brand','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_brand')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_brand','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_brand')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_brand','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_brand')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_brand','name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_brand')." ADD   `name` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_brand','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_brand')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_brand','thumb_brand')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_brand')." ADD   `thumb_brand` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_brand','intro')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_brand')." ADD   `intro` varchar(1000) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_brand','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_brand')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_brand','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_brand')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `goodsid` int(11) NOT NULL,
  `goodstype` tinyint(1) DEFAULT '1',
  `from_user` varchar(50) DEFAULT NULL,
  `total` int(10) unsigned NOT NULL,
  `optionid` int(10) DEFAULT '0',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  `optionname` text,
  `checked` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_openid` (`from_user`)
) ENGINE=InnoDB AUTO_INCREMENT=423 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_cart','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   `goodsid` int(11) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','goodstype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   `goodstype` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','from_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   `from_user` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','total')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   `total` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','optionid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   `optionid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','marketprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   `marketprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','optionname')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   `optionname` text");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','checked')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   `checked` tinyint(4) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_shop_cart','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_cart')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `isrecommand` int(10) DEFAULT '0',
  `adthumb` varchar(255) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_category','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_category','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_category','name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD   `name` varchar(50) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_category','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD   `thumb` varchar(255) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_category','parentid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD   `parentid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_category','isrecommand')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD   `isrecommand` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_category','adthumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD   `adthumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_category','description')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD   `description` varchar(500) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_category','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_category','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_category')." ADD   `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `from_user` varchar(50) DEFAULT NULL,
  `goods_id` int(11) DEFAULT '0',
  `smeta` longtext,
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_collect','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_collect')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_collect','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_collect')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_collect','from_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_collect')." ADD   `from_user` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_collect','goods_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_collect')." ADD   `goods_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_collect','smeta')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_collect')." ADD   `smeta` longtext");}
if(!pdo_fieldexists('slwl_aicard_shop_collect','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_collect')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_dispatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `dispatchname` varchar(50) DEFAULT '',
  `dispatchtype` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `firstprice` decimal(10,2) DEFAULT '0.00',
  `secondprice` decimal(10,2) DEFAULT '0.00',
  `firstweight` int(11) DEFAULT '0',
  `secondweight` int(11) DEFAULT '0',
  `express` int(11) DEFAULT '0',
  `description` text,
  `enabled` int(11) NOT NULL DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_dispatch','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','dispatchname')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `dispatchname` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','dispatchtype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `dispatchtype` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','firstprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `firstprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','secondprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `secondprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','firstweight')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `firstweight` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','secondweight')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `secondweight` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','express')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `express` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','description')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `description` text");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `enabled` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('slwl_aicard_shop_dispatch','indx_weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_dispatch')." ADD   KEY `indx_weid` (`weid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `express_name` varchar(50) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `express_price` varchar(10) DEFAULT '',
  `express_area` varchar(100) DEFAULT '',
  `express_url` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_express','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_express','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_express','express_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD   `express_name` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_express','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_express','express_price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD   `express_price` varchar(10) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_express','express_area')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD   `express_area` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_express','express_url')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD   `express_url` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_express','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_shop_express','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('slwl_aicard_shop_express','indx_weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_express')." ADD   KEY `indx_weid` (`weid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `brandid` int(11) DEFAULT '0',
  `pcate` int(10) unsigned NOT NULL DEFAULT '0',
  `ccate` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `intro` varchar(100) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `unit` varchar(5) NOT NULL DEFAULT '',
  `description` varchar(1000) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `goodssn` varchar(50) NOT NULL DEFAULT '',
  `productsn` varchar(50) NOT NULL DEFAULT '',
  `marketprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `productprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `costprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` int(10) unsigned NOT NULL DEFAULT '0',
  `totalcnf` int(11) DEFAULT '0',
  `sales` int(10) unsigned NOT NULL DEFAULT '0',
  `spec` varchar(5000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `maxbuy` int(11) DEFAULT '0',
  `usermaxbuy` int(10) unsigned NOT NULL DEFAULT '0',
  `hasoption` int(11) DEFAULT '0',
  `dispatch` int(11) DEFAULT '0',
  `thumb_url` text,
  `isnew` int(11) DEFAULT '0',
  `ishot` int(11) DEFAULT '0',
  `isdiscount` int(11) DEFAULT '0',
  `isrecommand` int(11) DEFAULT '0',
  `istime` int(11) DEFAULT '0',
  `timestart` int(11) DEFAULT '0',
  `timeend` int(11) DEFAULT '0',
  `isfreeshopping` tinyint(4) DEFAULT '0',
  `viewcount` int(11) DEFAULT '0',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `param` text,
  `addtime` datetime DEFAULT '0200-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_goods','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','brandid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `brandid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','pcate')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `pcate` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','ccate')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `ccate` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','type')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `type` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `displayorder` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `title` varchar(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','intro')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `intro` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','unit')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `unit` varchar(5) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','description')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `description` varchar(1000) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','content')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `content` text NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','goodssn')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `goodssn` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','productsn')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `productsn` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','marketprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `marketprice` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','productprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `productprice` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','costprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `costprice` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','originalprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','total')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `total` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','totalcnf')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `totalcnf` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','sales')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `sales` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','spec')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `spec` varchar(5000) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','createtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `createtime` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','weight')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `weight` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','credit')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `credit` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','maxbuy')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `maxbuy` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','usermaxbuy')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `usermaxbuy` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','hasoption')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `hasoption` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','dispatch')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `dispatch` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','thumb_url')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `thumb_url` text");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','isnew')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `isnew` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','ishot')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `ishot` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','isdiscount')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `isdiscount` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','isrecommand')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `isrecommand` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','istime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `istime` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','timestart')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `timestart` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','timeend')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `timeend` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','isfreeshopping')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `isfreeshopping` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','viewcount')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `viewcount` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','deleted')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','param')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `param` text");}
if(!pdo_fieldexists('slwl_aicard_shop_goods','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods')." ADD   `addtime` datetime DEFAULT '0200-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_goods_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `thumb` varchar(60) DEFAULT '',
  `productprice` decimal(10,2) DEFAULT '0.00',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  `costprice` decimal(10,2) DEFAULT '0.00',
  `stock` int(11) DEFAULT '0',
  `weight` decimal(10,2) DEFAULT '0.00',
  `displayorder` int(11) DEFAULT '0',
  `specs` text,
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodsid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_goods_option','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `goodsid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `title` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `thumb` varchar(60) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','productprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `productprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','marketprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `marketprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','costprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `costprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','stock')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `stock` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','weight')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `weight` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','specs')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   `specs` text");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_option','indx_goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_option')." ADD   KEY `indx_goodsid` (`goodsid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_goods_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `value` text,
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodsid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_goods_param','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_param')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_param','goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_param')." ADD   `goodsid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_param','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_param')." ADD   `title` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_param','value')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_param')." ADD   `value` text");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_param','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_param')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_param','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_param')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('slwl_aicard_shop_goods_param','indx_goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_goods_param')." ADD   KEY `indx_goodsid` (`goodsid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(20) DEFAULT NULL,
  `price` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `sendtype` tinyint(1) unsigned NOT NULL,
  `paytype` tinyint(1) unsigned DEFAULT '0',
  `transid` varchar(30) DEFAULT '0',
  `goodstype` tinyint(1) unsigned DEFAULT '1',
  `remark` varchar(1000) NOT NULL DEFAULT '',
  `addressid` int(10) unsigned DEFAULT NULL,
  `address` varchar(1024) NOT NULL DEFAULT '',
  `expresscom` varchar(30) DEFAULT '',
  `expresssn` varchar(50) DEFAULT '',
  `express` varchar(200) DEFAULT '',
  `goodsprice` decimal(10,2) DEFAULT '0.00',
  `dispatchprice` decimal(10,2) DEFAULT '0.00',
  `dispatch` int(10) DEFAULT '0',
  `paydetail` varchar(255) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_order','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_order','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order','from_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `from_user` varchar(50) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order','ordersn')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `ordersn` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order','price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `price` varchar(10) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `status` tinyint(4) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_order','sendtype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `sendtype` tinyint(1) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order','paytype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `paytype` tinyint(1) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_order','transid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `transid` varchar(30) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_order','goodstype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `goodstype` tinyint(1) unsigned DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_shop_order','remark')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `remark` varchar(1000) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_order','addressid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `addressid` int(10) unsigned DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order','address')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `address` varchar(1024) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_order','expresscom')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `expresscom` varchar(30) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_order','expresssn')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `expresssn` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_order','express')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `express` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_order','goodsprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `goodsprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_order','dispatchprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `dispatchprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_order','dispatch')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `dispatch` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_order','paydetail')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `paydetail` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order','createtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order')." ADD   `createtime` int(10) unsigned NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `brandid` int(11) DEFAULT '0',
  `orderid` int(10) unsigned NOT NULL,
  `goodsid` int(10) unsigned NOT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `total` int(10) unsigned NOT NULL DEFAULT '1',
  `optionid` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  `optionname` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_order_goods','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_order_goods','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order_goods','brandid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD   `brandid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_order_goods','orderid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD   `orderid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order_goods','goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD   `goodsid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order_goods','price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD   `price` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('slwl_aicard_shop_order_goods','total')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD   `total` int(10) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_shop_order_goods','optionid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD   `optionid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_order_goods','createtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD   `createtime` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_order_goods','optionname')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_order_goods')." ADD   `optionname` text");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_printers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `printer_name_cn` varchar(100) DEFAULT '',
  `printer_name` varchar(100) DEFAULT '',
  `printer_value` longtext,
  `enabled` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_printers','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_printers')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_printers','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_printers')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_printers','printer_name_cn')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_printers')." ADD   `printer_name_cn` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_printers','printer_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_printers')." ADD   `printer_name` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_printers','printer_value')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_printers')." ADD   `printer_value` longtext");}
if(!pdo_fieldexists('slwl_aicard_shop_printers','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_printers')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_printers','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_printers')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_sale` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `name` varchar(50) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `enough` int(11) DEFAULT '0',
  `timelimit` tinyint(4) DEFAULT '0',
  `timedays1` varchar(50) DEFAULT '',
  `timedays2` varchar(255) DEFAULT '',
  `backtype` tinyint(4) DEFAULT '0',
  `backmoney` int(11) DEFAULT '0',
  `discount` decimal(10,2) DEFAULT NULL,
  `flbackmoney` int(11) DEFAULT NULL,
  `backwhen` tinyint(4) DEFAULT '0',
  `total` int(11) DEFAULT '-1',
  `receive` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_sale','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `name` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','enough')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `enough` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','timelimit')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `timelimit` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','timedays1')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `timedays1` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','timedays2')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `timedays2` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','backtype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `backtype` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','backmoney')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `backmoney` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','discount')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `discount` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','flbackmoney')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `flbackmoney` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','backwhen')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `backwhen` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','total')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `total` int(11) DEFAULT '-1'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','receive')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `receive` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `enabled` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_sale_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `user` int(11) DEFAULT '0',
  `saleid` int(11) DEFAULT '0',
  `gettime` datetime DEFAULT '2000-01-01 00:00:00',
  `isdefault` tinyint(4) DEFAULT '0',
  `status` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_sale_user','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale_user')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_sale_user','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale_user')." ADD   `weid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_sale_user','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale_user')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale_user','user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale_user')." ADD   `user` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale_user','saleid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale_user')." ADD   `saleid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale_user','gettime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale_user')." ADD   `gettime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale_user','isdefault')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale_user')." ADD   `isdefault` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale_user','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale_user')." ADD   `status` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_sale_user','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_sale_user')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_shop_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `displaytype` tinyint(3) DEFAULT NULL,
  `content` text,
  `goodsid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_shop_spec','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_spec')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_shop_spec','weid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_spec')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_spec','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_spec')." ADD   `title` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_spec','description')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_spec')." ADD   `description` varchar(1000) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_spec','displaytype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_spec')." ADD   `displaytype` tinyint(3) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_shop_spec','content')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_spec')." ADD   `content` text");}
if(!pdo_fieldexists('slwl_aicard_shop_spec','goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_spec')." ADD   `goodsid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_spec','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_spec')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_shop_spec','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_shop_spec')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `realname` varchar(100) DEFAULT '',
  `mobile` varchar(50) DEFAULT '',
  `province` varchar(50) DEFAULT '',
  `city` varchar(50) DEFAULT '',
  `area` varchar(50) DEFAULT '',
  `address` varchar(300) DEFAULT '',
  `isdefault` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_address','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_address','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_address','uid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `uid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_address','realname')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `realname` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_address','mobile')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `mobile` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_address','province')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `province` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_address','city')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `city` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_address','area')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `area` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_address','address')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `address` varchar(300) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_address','isdefault')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `isdefault` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_address','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_address')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_adsp` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` tinyint(4) DEFAULT '0',
  `page_url` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_adsp','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adsp')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_adsp','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adsp')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_adsp','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adsp')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_adsp','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adsp')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_adsp','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adsp')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_adsp','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adsp')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_adsp','page_url')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adsp')." ADD   `page_url` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_adsp','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adsp')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_adv` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `enabled` tinyint(4) DEFAULT '0',
  `page_url` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_adv','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adv')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_adv','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adv')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_adv','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adv')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_adv','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adv')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_adv','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adv')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_adv','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adv')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_adv','page_url')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adv')." ADD   `page_url` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_adv','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_adv')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_brand` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `thumb_brand` varchar(255) DEFAULT '',
  `intro` varchar(1000) DEFAULT '',
  `enabled` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_brand','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_brand')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_brand','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_brand')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_brand','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_brand')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_brand','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_brand')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_brand','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_brand')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_brand','thumb_brand')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_brand')." ADD   `thumb_brand` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_brand','intro')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_brand')." ADD   `intro` varchar(1000) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_brand','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_brand')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_brand','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_brand')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `from_user` varchar(50) DEFAULT NULL,
  `goodsid` int(11) DEFAULT NULL,
  `goodstype` tinyint(1) DEFAULT '1',
  `count` int(11) DEFAULT '1',
  `price` int(11) DEFAULT '0',
  `option_id` int(11) DEFAULT '0',
  `option` text,
  `checked` tinyint(4) DEFAULT '1',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_openid` (`from_user`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_cart','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_cart','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_cart','from_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `from_user` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_cart','goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `goodsid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_cart','goodstype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `goodstype` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_store_cart','count')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `count` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_store_cart','price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `price` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_cart','option_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `option_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_cart','option')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `option` text");}
if(!pdo_fieldexists('slwl_aicard_store_cart','checked')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `checked` tinyint(4) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_store_cart','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_store_cart','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_cart')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT '0',
  `displayorder` tinyint(4) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `parentid` int(10) DEFAULT '0',
  `isrecommand` int(10) DEFAULT '0',
  `adthumb` varchar(255) DEFAULT '',
  `intro` varchar(500) DEFAULT '',
  `enabled` tinyint(4) DEFAULT '1',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_category','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_category','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `uniacid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_category','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `displayorder` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_category','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_category','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_category','parentid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `parentid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_category','isrecommand')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `isrecommand` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_category','adthumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `adthumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_category','intro')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `intro` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_category','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `enabled` tinyint(4) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_store_category','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_category')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `from_user` varchar(50) DEFAULT NULL,
  `goodsid` int(11) DEFAULT '0',
  `smeta` text,
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_collect','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_collect')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_collect','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_collect')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_collect','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_collect')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_collect','from_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_collect')." ADD   `from_user` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_collect','goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_collect')." ADD   `goodsid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_collect','smeta')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_collect')." ADD   `smeta` text");}
if(!pdo_fieldexists('slwl_aicard_store_collect','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_collect')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `displayorder` int(10) DEFAULT '0',
  `brandid` int(11) DEFAULT '0',
  `pcate` int(10) DEFAULT '0',
  `ccate` int(10) DEFAULT '0',
  `title` varchar(100) DEFAULT '',
  `intro` varchar(100) DEFAULT '',
  `thumbs` text,
  `thumb` varchar(255) DEFAULT '',
  `unit` varchar(30) DEFAULT '',
  `goodsn` varchar(255) DEFAULT '',
  `barcode` varchar(255) DEFAULT '',
  `content` text,
  `marketprice` int(11) DEFAULT '0',
  `productprice` int(11) DEFAULT '0',
  `inventory` int(10) DEFAULT '0',
  `inventory_status` tinyint(4) DEFAULT '0',
  `sales` int(10) DEFAULT '0',
  `param` text,
  `spec` text,
  `spec_status` tinyint(11) DEFAULT '0',
  `isnew` int(11) DEFAULT '0',
  `ishot` int(11) DEFAULT '0',
  `isrecommand` int(11) DEFAULT '0',
  `istime` int(11) DEFAULT '0',
  `timestart` datetime DEFAULT '2000-01-01 00:00:00',
  `timeend` datetime DEFAULT '2000-01-01 00:00:00',
  `viewcount` bigint(20) DEFAULT '0',
  `deleted` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  `price` int(11) DEFAULT '0',
  `original_price` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_goods','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_goods','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `enabled` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `displayorder` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','brandid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `brandid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','pcate')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `pcate` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','ccate')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `ccate` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `title` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods','intro')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `intro` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods','thumbs')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `thumbs` text");}
if(!pdo_fieldexists('slwl_aicard_store_goods','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods','unit')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `unit` varchar(30) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods','goodsn')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `goodsn` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods','barcode')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `barcode` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods','content')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `content` text");}
if(!pdo_fieldexists('slwl_aicard_store_goods','marketprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `marketprice` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','productprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `productprice` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','inventory')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `inventory` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','inventory_status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `inventory_status` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','sales')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `sales` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','param')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `param` text");}
if(!pdo_fieldexists('slwl_aicard_store_goods','spec')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `spec` text");}
if(!pdo_fieldexists('slwl_aicard_store_goods','spec_status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `spec_status` tinyint(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','isnew')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `isnew` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','ishot')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `ishot` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','isrecommand')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `isrecommand` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','istime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `istime` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','timestart')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `timestart` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','timeend')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `timeend` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','viewcount')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `viewcount` bigint(20) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','deleted')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `deleted` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `price` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods','original_price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods')." ADD   `original_price` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_goods_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `goodid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `marketprice` int(11) DEFAULT '0',
  `productprice` int(11) DEFAULT '0',
  `inventory` int(11) DEFAULT '0',
  `goodsn` varchar(255) DEFAULT '',
  `barcode` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  `assemble` varchar(255) DEFAULT '',
  `assemble_json` text,
  `price` int(11) DEFAULT '0',
  `original_price` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_goods_option','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','goodid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `goodid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','marketprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `marketprice` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','productprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `productprice` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','inventory')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `inventory` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','goodsn')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `goodsn` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','barcode')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `barcode` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','assemble')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `assemble` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','assemble_json')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `assemble_json` text");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `price` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','original_price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   `original_price` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('slwl_aicard_store_goods_option','indx_goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_goods_option')." ADD   KEY `indx_goodsid` (`goodid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `from_user` int(11) DEFAULT NULL,
  `ordersn` varchar(255) DEFAULT '',
  `price` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `paytype` tinyint(4) DEFAULT '0',
  `address` text,
  `goods` text,
  `coupon` text,
  `discount_money` int(11) DEFAULT '0',
  `goods_first_id` int(11) DEFAULT '0',
  `goods_first_marketprice` int(11) DEFAULT '0',
  `total` int(11) DEFAULT '0',
  `mark` text,
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  `goods_first_price` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_order','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_order','from_user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `from_user` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_order','ordersn')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `ordersn` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_order','price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `price` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_order','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `status` tinyint(4) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_store_order','paytype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `paytype` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order','address')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `address` text");}
if(!pdo_fieldexists('slwl_aicard_store_order','goods')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `goods` text");}
if(!pdo_fieldexists('slwl_aicard_store_order','coupon')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `coupon` text");}
if(!pdo_fieldexists('slwl_aicard_store_order','discount_money')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `discount_money` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order','goods_first_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `goods_first_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order','goods_first_marketprice')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `goods_first_marketprice` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order','total')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `total` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order','mark')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `mark` text");}
if(!pdo_fieldexists('slwl_aicard_store_order','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_store_order','goods_first_price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order')." ADD   `goods_first_price` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `brandid` int(11) DEFAULT '0',
  `orderid` int(11) DEFAULT '0',
  `goodsid` int(11) DEFAULT '0',
  `price` int(11) DEFAULT '0',
  `total` int(11) DEFAULT '0',
  `option_id` int(11) DEFAULT '0',
  `option` text,
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_order_goods','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_order_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_order_goods','brandid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD   `brandid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order_goods','orderid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD   `orderid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order_goods','goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD   `goodsid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order_goods','price')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD   `price` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order_goods','total')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD   `total` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order_goods','option_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD   `option_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_order_goods','option')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD   `option` text");}
if(!pdo_fieldexists('slwl_aicard_store_order_goods','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_order_goods')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_printers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `printer_name_cn` varchar(100) DEFAULT '',
  `printer_name` varchar(100) DEFAULT '',
  `printer_value` longtext,
  `enabled` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_printers','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_printers')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_printers','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_printers')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_printers','printer_name_cn')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_printers')." ADD   `printer_name_cn` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_printers','printer_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_printers')." ADD   `printer_name` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_printers','printer_value')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_printers')." ADD   `printer_value` longtext");}
if(!pdo_fieldexists('slwl_aicard_store_printers','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_printers')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_printers','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_printers')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_sale` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `intro` varchar(500) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `enough` int(11) DEFAULT '0',
  `timelimit` tinyint(4) DEFAULT '0',
  `timedays1` varchar(255) DEFAULT '',
  `timedays2` varchar(255) DEFAULT '',
  `backtype` tinyint(4) DEFAULT '0',
  `backmoney` int(11) DEFAULT '0',
  `discount` int(11) DEFAULT '0',
  `flbackmoney` int(11) DEFAULT NULL,
  `backwhen` tinyint(4) DEFAULT '0',
  `total` int(11) DEFAULT '0',
  `receive` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_sale','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_sale','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_sale','intro')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `intro` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_sale','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_sale','enough')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `enough` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','timelimit')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `timelimit` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','timedays1')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `timedays1` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_sale','timedays2')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `timedays2` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_sale','backtype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `backtype` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','backmoney')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `backmoney` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','discount')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `discount` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','flbackmoney')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `flbackmoney` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_sale','backwhen')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `backwhen` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','total')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `total` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','receive')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `receive` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `enabled` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_sale_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `user` int(11) DEFAULT '0',
  `saleid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `option_value` text,
  `time_start` datetime DEFAULT '2000-01-01 00:00:00',
  `time_end` datetime DEFAULT '2000-01-01 00:00:00',
  `status` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_sale_user','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','user')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `user` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','saleid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `saleid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','option_value')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `option_value` text");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','time_start')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `time_start` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','time_end')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `time_end` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','status')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `status` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_sale_user','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_sale_user')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_store_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `displaytype` tinyint(3) DEFAULT NULL,
  `content` text,
  `goodsid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_store_spec','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_spec')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_store_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_spec')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_spec','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_spec')." ADD   `title` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_spec','description')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_spec')." ADD   `description` varchar(1000) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_spec','displaytype')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_spec')." ADD   `displaytype` tinyint(3) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_store_spec','content')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_spec')." ADD   `content` text");}
if(!pdo_fieldexists('slwl_aicard_store_spec','goodsid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_spec')." ADD   `goodsid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_spec','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_spec')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_store_spec','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_store_spec')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_tipswx` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `template_base_id` varchar(255) DEFAULT '',
  `template_base_title` varchar(255) DEFAULT '',
  `template_id` varchar(255) DEFAULT '',
  `template_type` tinyint(4) DEFAULT '0',
  `mark` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_tipswx','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_tipswx')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_tipswx','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_tipswx')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_tipswx','template_base_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_tipswx')." ADD   `template_base_id` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_tipswx','template_base_title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_tipswx')." ADD   `template_base_title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_tipswx','template_id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_tipswx')." ADD   `template_id` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_tipswx','template_type')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_tipswx')." ADD   `template_type` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_tipswx','mark')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_tipswx')." ADD   `mark` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_tipswx','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_tipswx')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT '',
  `unionid` varchar(255) DEFAULT '',
  `mobile` varchar(50) DEFAULT '',
  `source_cardid` varchar(255) DEFAULT '',
  `source_name` varchar(255) DEFAULT '',
  `source_txt` varchar(255) DEFAULT '',
  `nicename` varchar(255) DEFAULT '',
  `avatar` varchar(255) DEFAULT '',
  `city` varchar(255) DEFAULT '',
  `gender` tinyint(4) DEFAULT '0',
  `province` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  `mark` text,
  `last_time` datetime DEFAULT '2000-01-01 00:00:00',
  `real_name` varchar(255) DEFAULT '',
  `id_label` text,
  `balance` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7544 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_users','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_users','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_users','openid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `openid` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','unionid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `unionid` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','mobile')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `mobile` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','source_cardid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `source_cardid` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','source_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `source_name` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','source_txt')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `source_txt` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','nicename')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `nicename` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','avatar')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `avatar` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','city')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `city` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','gender')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `gender` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_users','province')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `province` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_users','mark')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `mark` text");}
if(!pdo_fieldexists('slwl_aicard_users','last_time')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `last_time` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_users','real_name')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `real_name` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users','id_label')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `id_label` text");}
if(!pdo_fieldexists('slwl_aicard_users','balance')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users')." ADD   `balance` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_users_label` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `subtitle` text,
  `thumb` varchar(255) DEFAULT '',
  `enabled` tinyint(4) DEFAULT '0',
  `delete` tinyint(4) DEFAULT '0',
  `create_time` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('slwl_aicard_users_label','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users_label')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_users_label','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users_label')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_users_label','sort')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users_label')." ADD   `sort` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_users_label','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users_label')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users_label','subtitle')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users_label')." ADD   `subtitle` text");}
if(!pdo_fieldexists('slwl_aicard_users_label','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users_label')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_users_label','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users_label')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_users_label','delete')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users_label')." ADD   `delete` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_users_label','create_time')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_users_label')." ADD   `create_time` datetime DEFAULT '2000-01-01 00:00:00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_website_act_news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `termid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `subtitle` varchar(500) DEFAULT '',
  `thumb` varchar(500) DEFAULT '',
  `enabled` int(11) DEFAULT '0',
  `detail` text,
  `createtime` int(11) DEFAULT NULL,
  `out_thumb` varchar(255) DEFAULT '',
  `out_link` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_website_act_news','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','termid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `termid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','title')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `title` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','subtitle')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `subtitle` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `thumb` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `enabled` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','detail')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `detail` text");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','createtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `createtime` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','out_thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `out_thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','out_link')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `out_link` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_act_news','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_news')." ADD   `addtime` datetime DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_website_act_term` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `termname` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `click_type` tinyint(4) DEFAULT '1',
  `isrecommand` tinyint(4) DEFAULT '0',
  `enabled` tinyint(4) DEFAULT '0',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  `list_style` varchar(255) DEFAULT 'non-image',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_website_act_term','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_website_act_term','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_website_act_term','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_website_act_term','termname')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD   `termname` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_act_term','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_act_term','click_type')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD   `click_type` tinyint(4) DEFAULT '1'");}
if(!pdo_fieldexists('slwl_aicard_website_act_term','isrecommand')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD   `isrecommand` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_website_act_term','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_website_act_term','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
if(!pdo_fieldexists('slwl_aicard_website_act_term','list_style')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_act_term')." ADD   `list_style` varchar(255) DEFAULT 'non-image'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_slwl_aicard_website_adv` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `advname` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` tinyint(4) DEFAULT '0',
  `page_url` varchar(255) DEFAULT '',
  `addtime` datetime DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('slwl_aicard_website_adv','id')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_adv')." ADD 
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('slwl_aicard_website_adv','uniacid')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_adv')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('slwl_aicard_website_adv','advname')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_adv')." ADD   `advname` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_adv','thumb')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_adv')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_adv','displayorder')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_adv')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_website_adv','enabled')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_adv')." ADD   `enabled` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('slwl_aicard_website_adv','page_url')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_adv')." ADD   `page_url` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('slwl_aicard_website_adv','addtime')) {pdo_query("ALTER TABLE ".tablename('slwl_aicard_website_adv')." ADD   `addtime` datetime DEFAULT '2000-01-01 00:00:00'");}
