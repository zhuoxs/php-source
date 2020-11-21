<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ss_active` (
  `active_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `active_name` varchar(255) NOT NULL DEFAULT '',
  `cover_id` int(11) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `active_time` int(11) unsigned NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL DEFAULT '',
  `people` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`active_id`),
  KEY `user_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ss_active','active_id')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD 
  `active_id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ss_active','active_name')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `active_name` varchar(255) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ss_active','cover_id')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `cover_id` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active','description')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `description` text NOT NULL");}
if(!pdo_fieldexists('ss_active','active_time')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `active_time` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active','address')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `address` varchar(255) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ss_active','people')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `people` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active','user_id')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `user_id` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active','wxapp_id')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active','create_time')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `create_time` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active','update_time')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   `update_time` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active','active_id')) {pdo_query("ALTER TABLE ".tablename('ss_active')." ADD   PRIMARY KEY (`active_id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ss_active_enroll` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `active_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL DEFAULT '',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `active_user` (`active_id`,`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ss_active_enroll','id')) {pdo_query("ALTER TABLE ".tablename('ss_active_enroll')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ss_active_enroll','active_id')) {pdo_query("ALTER TABLE ".tablename('ss_active_enroll')." ADD   `active_id` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active_enroll','user_id')) {pdo_query("ALTER TABLE ".tablename('ss_active_enroll')." ADD   `user_id` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active_enroll','wxapp_id')) {pdo_query("ALTER TABLE ".tablename('ss_active_enroll')." ADD   `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active_enroll','message')) {pdo_query("ALTER TABLE ".tablename('ss_active_enroll')." ADD   `message` varchar(255) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ss_active_enroll','create_time')) {pdo_query("ALTER TABLE ".tablename('ss_active_enroll')." ADD   `create_time` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active_enroll','update_time')) {pdo_query("ALTER TABLE ".tablename('ss_active_enroll')." ADD   `update_time` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ss_active_enroll','id')) {pdo_query("ALTER TABLE ".tablename('ss_active_enroll')." ADD   PRIMARY KEY (`id`)");}
