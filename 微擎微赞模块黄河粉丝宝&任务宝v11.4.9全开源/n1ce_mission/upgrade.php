<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_allnumber` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned DEFAULT '0',
  `uniacid` int(10) unsigned NOT NULL,
  `from_user` varchar(100) NOT NULL,
  `allnumber` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_new_allnum` (`uniacid`,`rid`,`from_user`)
) ENGINE=MyISAM AUTO_INCREMENT=3587 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_allnumber','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_allnumber')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_allnumber','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_allnumber')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_allnumber','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_allnumber')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_allnumber','from_user')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_allnumber')." ADD   `from_user` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_allnumber','allnumber')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_allnumber')." ADD   `allnumber` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_allnumber','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_allnumber')." ADD   `createtime` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_allnumber','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_allnumber')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_antilog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `check_sign` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `check_sign` (`check_sign`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_antilog','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_antilog')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_antilog','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_antilog')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_antilog','check_sign')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_antilog')." ADD   `check_sign` varchar(200) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_antilog','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_antilog')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_blacklist` (
  `from_user` varchar(50) NOT NULL DEFAULT '',
  `uniacid` int(10) unsigned NOT NULL,
  `access_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`from_user`,`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_blacklist','from_user')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_blacklist')." ADD 
  `from_user` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_blacklist','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_blacklist')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_blacklist','access_time')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_blacklist')." ADD   `access_time` int(10) unsigned NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `rid` int(10) NOT NULL DEFAULT '0',
  `codeid` int(10) NOT NULL DEFAULT '0',
  `code` varchar(16) NOT NULL DEFAULT '',
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_code','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_code')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_code','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_code')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_code','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_code')." ADD   `rid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_code','codeid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_code')." ADD   `codeid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_code','code')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_code')." ADD   `code` varchar(16) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_code','status')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_code')." ADD   `status` tinyint(1) DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `realname` varchar(50) DEFAULT '',
  `mobile` varchar(200) DEFAULT '',
  `ex_name` varchar(200) DEFAULT '',
  `ex_num` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_express','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_express')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_express','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_express')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_express','realname')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_express')." ADD   `realname` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_express','mobile')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_express')." ADD   `mobile` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_express','ex_name')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_express')." ADD   `ex_name` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_express','ex_num')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_express')." ADD   `ex_num` varchar(200) DEFAULT ''");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `rid` int(10) unsigned DEFAULT '0',
  `from_user` varchar(100) NOT NULL,
  `unionid` varchar(100) NOT NULL,
  `bropenid` varchar(100) NOT NULL,
  `upopenid` varchar(100) NOT NULL,
  `nickname` varchar(50) DEFAULT '0',
  `headimgurl` varchar(500) DEFAULT '',
  `sceneid` int(11) DEFAULT '0',
  `ticketid` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `miss_num` int(10) DEFAULT '0',
  `createtime` varchar(50) DEFAULT NULL,
  `updatetime` varchar(50) DEFAULT '0',
  `money` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `from_user` (`from_user`)
) ENGINE=MyISAM AUTO_INCREMENT=7450 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_fans','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_fans','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_fans','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_fans','from_user')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `from_user` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_fans','unionid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `unionid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_fans','bropenid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `bropenid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_fans','upopenid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `upopenid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_fans','nickname')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `nickname` varchar(50) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_fans','headimgurl')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `headimgurl` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_fans','sceneid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `sceneid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_fans','ticketid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `ticketid` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_fans','url')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `url` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_fans','status')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `status` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_fans','miss_num')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `miss_num` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_fans','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `createtime` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_fans','updatetime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `updatetime` varchar(50) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_fans','money')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   `money` varchar(50) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_fans','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_fans')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_flog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `follower` varchar(100) NOT NULL,
  `leaderid` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT '2',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_flog','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_flog')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_flog','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_flog')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_flog','follower')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_flog')." ADD   `follower` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_flog','leaderid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_flog')." ADD   `leaderid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_flog','status')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_flog')." ADD   `status` tinyint(1) DEFAULT '2'");}
if(!pdo_fieldexists('n1ce_mission_flog','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_flog')." ADD   `createtime` int(10) unsigned NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_follow` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned DEFAULT '0',
  `leader` varchar(100) NOT NULL,
  `follower` varchar(100) NOT NULL,
  `createtime` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_new_follow` (`uniacid`,`rid`,`follower`)
) ENGINE=MyISAM AUTO_INCREMENT=13085 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_follow','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_follow')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_follow','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_follow')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_follow','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_follow')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_follow','leader')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_follow')." ADD   `leader` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_follow','follower')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_follow')." ADD   `follower` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_follow','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_follow')." ADD   `createtime` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_follow','status')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_follow')." ADD   `status` int(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_follow','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_follow')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_goods` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `goods_img` text,
  `markert_price` int(10) DEFAULT '0',
  `get_price` int(10) DEFAULT '0',
  `postage` int(10) DEFAULT '0',
  `goods_desc` text,
  `createtime` int(10) DEFAULT '0',
  `quality` int(10) unsigned NOT NULL DEFAULT '0',
  `goodstype` int(1) unsigned NOT NULL DEFAULT '1',
  `usecode` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_goods','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_goods','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_goods','title')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `title` varchar(200) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_goods','goods_img')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `goods_img` text");}
if(!pdo_fieldexists('n1ce_mission_goods','markert_price')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `markert_price` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_goods','get_price')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `get_price` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_goods','postage')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `postage` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_goods','goods_desc')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `goods_desc` text");}
if(!pdo_fieldexists('n1ce_mission_goods','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `createtime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_goods','quality')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `quality` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_goods','goodstype')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `goodstype` int(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_goods','usecode')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_goods')." ADD   `usecode` varchar(100) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned DEFAULT '0',
  `from_user` varchar(100) NOT NULL,
  `brrow_openid` varchar(100) NOT NULL,
  `nickname` varchar(50) DEFAULT '0',
  `headimgurl` varchar(500) DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `createtime` int(10) NOT NULL,
  `unionid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_new_member` (`uniacid`,`rid`,`from_user`),
  KEY `idx_new_brrow` (`uniacid`,`rid`,`brrow_openid`)
) ENGINE=MyISAM AUTO_INCREMENT=4718 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_member','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_member','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_member','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_member','from_user')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   `from_user` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_member','brrow_openid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   `brrow_openid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_member','nickname')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   `nickname` varchar(50) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_member','headimgurl')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   `headimgurl` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_member','status')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   `status` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_member','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   `createtime` int(10) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_member','unionid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   `unionid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_member','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('n1ce_mission_member','idx_new_member')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_member')." ADD   KEY `idx_new_member` (`uniacid`,`rid`,`from_user`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_msgid` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned DEFAULT '0',
  `check_sign` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `check_sign` (`check_sign`)
) ENGINE=MyISAM AUTO_INCREMENT=9450 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_msgid','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_msgid')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_msgid','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_msgid')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_msgid','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_msgid')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_msgid','check_sign')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_msgid')." ADD   `check_sign` varchar(200) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_msgid','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_msgid')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned DEFAULT '0',
  `gid` int(10) NOT NULL DEFAULT '0',
  `from_user` varchar(64) NOT NULL DEFAULT '',
  `nickname` varchar(64) NOT NULL DEFAULT '',
  `realname` varchar(64) NOT NULL DEFAULT '',
  `mobile` varchar(64) NOT NULL DEFAULT '',
  `residedist` varchar(64) NOT NULL DEFAULT '',
  `headimgurl` varchar(500) DEFAULT '',
  `sign` varchar(200) NOT NULL,
  `time` int(10) DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sign` (`sign`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_order','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_order','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_order','gid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `gid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_order','from_user')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `from_user` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_order','nickname')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `nickname` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_order','realname')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `realname` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_order','mobile')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `mobile` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_order','residedist')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `residedist` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_order','headimgurl')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `headimgurl` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_order','sign')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `sign` varchar(200) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_order','time')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `time` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_order','status')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   `status` tinyint(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('n1ce_mission_order','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_orderlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned DEFAULT '0',
  `gid` int(10) NOT NULL DEFAULT '0',
  `from_user` varchar(64) NOT NULL DEFAULT '',
  `nickname` varchar(64) NOT NULL DEFAULT '',
  `realname` varchar(64) NOT NULL DEFAULT '',
  `mobile` varchar(64) NOT NULL DEFAULT '',
  `residedist` varchar(64) NOT NULL DEFAULT '',
  `headimgurl` varchar(500) DEFAULT '',
  `tid` varchar(200) DEFAULT '',
  `fee` int(10) DEFAULT '0',
  `sign` varchar(200) NOT NULL,
  `time` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sign` (`sign`),
  UNIQUE KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_orderlog','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_orderlog','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_orderlog','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_orderlog','gid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `gid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_orderlog','from_user')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `from_user` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_orderlog','nickname')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `nickname` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_orderlog','realname')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `realname` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_orderlog','mobile')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `mobile` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_orderlog','residedist')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `residedist` varchar(64) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_orderlog','headimgurl')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `headimgurl` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_orderlog','tid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `tid` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_orderlog','fee')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `fee` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_orderlog','sign')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `sign` varchar(200) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_orderlog','time')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   `time` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_orderlog','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('n1ce_mission_orderlog','sign')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_orderlog')." ADD   UNIQUE KEY `sign` (`sign`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT '0',
  `rid` int(10) NOT NULL DEFAULT '0',
  `prizesum` int(10) unsigned NOT NULL DEFAULT '0',
  `miss_num` int(10) DEFAULT '0',
  `prize_name` varchar(50) DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `min_money` varchar(16) DEFAULT '',
  `max_money` varchar(16) DEFAULT '',
  `cardid` varchar(100) DEFAULT '',
  `lable` varchar(100) DEFAULT '',
  `total_num` int(10) unsigned NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT '',
  `txt` varchar(255) DEFAULT '',
  `credit` int(10) NOT NULL DEFAULT '0',
  `time` varchar(32) NOT NULL DEFAULT '1',
  `gid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_new_prize` (`uniacid`,`rid`,`miss_num`)
) ENGINE=MyISAM AUTO_INCREMENT=234 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_prize','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_prize','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `uniacid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_prize','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `rid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_prize','prizesum')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `prizesum` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_prize','miss_num')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `miss_num` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_prize','prize_name')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `prize_name` varchar(50) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_prize','type')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `type` tinyint(4) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_prize','min_money')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `min_money` varchar(16) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_prize','max_money')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `max_money` varchar(16) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_prize','cardid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `cardid` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_prize','lable')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `lable` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_prize','total_num')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `total_num` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_prize','url')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `url` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_prize','txt')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `txt` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_prize','credit')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `credit` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_prize','time')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `time` varchar(32) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_prize','gid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   `gid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_prize','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_prize')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_qrlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned DEFAULT '0',
  `scene_id` varchar(50) NOT NULL,
  `qr_url` varchar(1024) NOT NULL,
  `media_id` varchar(1024) NOT NULL,
  `createtime` int(11) NOT NULL,
  `from_user` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_new_qrlog` (`uniacid`,`rid`,`from_user`)
) ENGINE=MyISAM AUTO_INCREMENT=3664 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_qrlog','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_qrlog')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_qrlog','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_qrlog')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_qrlog','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_qrlog')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_qrlog','scene_id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_qrlog')." ADD   `scene_id` varchar(50) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_qrlog','qr_url')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_qrlog')." ADD   `qr_url` varchar(1024) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_qrlog','media_id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_qrlog')." ADD   `media_id` varchar(1024) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_qrlog','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_qrlog')." ADD   `createtime` int(11) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_qrlog','from_user')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_qrlog')." ADD   `from_user` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_qrlog','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_qrlog')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `data` text,
  `bg` varchar(500) DEFAULT '',
  `temp_join` varchar(200) DEFAULT '',
  `remark_on` varchar(500) DEFAULT '',
  `remark_end` varchar(500) DEFAULT '',
  `first_info` varchar(500) DEFAULT NULL,
  `miss_wait` varchar(500) DEFAULT NULL,
  `starttime` int(10) DEFAULT '0',
  `endtime` int(10) DEFAULT '0',
  `miss_start` varchar(500) DEFAULT NULL,
  `miss_cut` varchar(500) DEFAULT NULL,
  `miss_end` varchar(500) DEFAULT NULL,
  `miss_sub` varchar(500) DEFAULT NULL,
  `miss_resub` varchar(500) DEFAULT NULL,
  `miss_back` varchar(500) DEFAULT NULL,
  `miss_finish` varchar(500) DEFAULT NULL,
  `miss_youzan` varchar(500) DEFAULT NULL,
  `miss_lucky` varchar(500) DEFAULT NULL,
  `xzlx` int(1) NOT NULL DEFAULT '0',
  `fans_limit` int(1) NOT NULL DEFAULT '0',
  `area` text NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '0',
  `tagid` int(10) NOT NULL,
  `createtime` varchar(16) NOT NULL DEFAULT '1',
  `posttype` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `more_bg` text,
  `temp_code` varchar(500) DEFAULT NULL,
  `expire` varchar(50) DEFAULT NULL,
  `isred` int(1) NOT NULL DEFAULT '1',
  `isall` int(1) NOT NULL DEFAULT '1',
  `img_type` int(1) NOT NULL DEFAULT '0',
  `quality` int(10) NOT NULL DEFAULT '75',
  `first_action` varchar(500) DEFAULT NULL,
  `again` int(1) NOT NULL DEFAULT '0',
  `sub_post` int(1) NOT NULL DEFAULT '0',
  `limit_sex` varchar(100) DEFAULT NULL,
  `limit_join` varchar(500) DEFAULT NULL,
  `get_fans` varchar(500) DEFAULT NULL,
  `tips` varchar(500) DEFAULT NULL,
  `copyright` varchar(100) DEFAULT NULL,
  `rank_num` int(10) NOT NULL DEFAULT '50',
  `msgtype` int(1) NOT NULL DEFAULT '1',
  `next_scan` int(1) NOT NULL DEFAULT '1',
  `next_step` varchar(500) DEFAULT NULL,
  `limit_scan` varchar(500) DEFAULT NULL,
  `limit_error` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`,`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_reply','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_reply','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `rid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','data')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `data` text");}
if(!pdo_fieldexists('n1ce_mission_reply','bg')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `bg` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_reply','temp_join')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `temp_join` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_reply','remark_on')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `remark_on` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_reply','remark_end')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `remark_end` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_reply','first_info')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `first_info` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_wait')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_wait` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','starttime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `starttime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','endtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `endtime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_start')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_start` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_cut')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_cut` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_end')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_end` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_sub')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_sub` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_resub')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_resub` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_back')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_back` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_finish')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_finish` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_youzan')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_youzan` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','miss_lucky')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `miss_lucky` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','xzlx')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `xzlx` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','fans_limit')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `fans_limit` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','area')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `area` text NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','sex')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `sex` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','tagid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `tagid` int(10) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `createtime` varchar(16) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_reply','posttype')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `posttype` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','status')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `status` int(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_reply','more_bg')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `more_bg` text");}
if(!pdo_fieldexists('n1ce_mission_reply','temp_code')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `temp_code` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','expire')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `expire` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','isred')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `isred` int(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_reply','isall')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `isall` int(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_reply','img_type')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `img_type` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','quality')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `quality` int(10) NOT NULL DEFAULT '75'");}
if(!pdo_fieldexists('n1ce_mission_reply','first_action')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `first_action` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','again')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `again` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','sub_post')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `sub_post` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_reply','limit_sex')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `limit_sex` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','limit_join')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `limit_join` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','get_fans')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `get_fans` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','tips')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `tips` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','copyright')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `copyright` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','rank_num')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `rank_num` int(10) NOT NULL DEFAULT '50'");}
if(!pdo_fieldexists('n1ce_mission_reply','msgtype')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `msgtype` int(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_reply','next_scan')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `next_scan` int(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_reply','next_step')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `next_step` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','limit_scan')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `limit_scan` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('n1ce_mission_reply','limit_error')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_reply')." ADD   `limit_error` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_scene_id` (
  `uniacid` int(10) unsigned NOT NULL,
  `scene_id` int(10) NOT NULL,
  PRIMARY KEY (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_scene_id','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_scene_id')." ADD 
  `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_scene_id','scene_id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_scene_id')." ADD   `scene_id` int(10) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_subfollow` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned DEFAULT '0',
  `leader` varchar(100) NOT NULL,
  `brrow_openid` varchar(100) NOT NULL,
  `f_unionid` varchar(100) NOT NULL,
  `createtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_new_subfollow` (`uniacid`,`rid`,`brrow_openid`),
  KEY `idx_new_subunionid` (`uniacid`,`rid`,`f_unionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_subfollow','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_subfollow')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_subfollow','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_subfollow')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_subfollow','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_subfollow')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_subfollow','leader')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_subfollow')." ADD   `leader` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_subfollow','brrow_openid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_subfollow')." ADD   `brrow_openid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_subfollow','f_unionid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_subfollow')." ADD   `f_unionid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_subfollow','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_subfollow')." ADD   `createtime` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_subfollow','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_subfollow')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('n1ce_mission_subfollow','idx_new_subfollow')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_subfollow')." ADD   KEY `idx_new_subfollow` (`uniacid`,`rid`,`brrow_openid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `access_token` varchar(200) DEFAULT '',
  `expires_in` int(11) DEFAULT '0',
  `token_type` varchar(32) DEFAULT '',
  `scope` varchar(200) DEFAULT '',
  `refresh_token` varchar(200) DEFAULT '',
  `createtime` varchar(16) DEFAULT '',
  `endtime` varchar(16) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_token','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_token')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_token','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_token')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_token','access_token')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_token')." ADD   `access_token` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_token','expires_in')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_token')." ADD   `expires_in` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_token','token_type')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_token')." ADD   `token_type` varchar(32) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_token','scope')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_token')." ADD   `scope` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_token','refresh_token')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_token')." ADD   `refresh_token` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_token','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_token')." ADD   `createtime` varchar(16) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_token','endtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_token')." ADD   `endtime` varchar(16) DEFAULT ''");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_unsub` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned DEFAULT '0',
  `un_tips` varchar(500) NOT NULL,
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_unsub','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_unsub')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_unsub','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_unsub')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_unsub','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_unsub')." ADD   `rid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_unsub','un_tips')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_unsub')." ADD   `un_tips` varchar(500) NOT NULL");}
if(!pdo_fieldexists('n1ce_mission_unsub','createtime')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_unsub')." ADD   `createtime` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_n1ce_mission_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) NOT NULL DEFAULT '0',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `openid` varchar(64) NOT NULL DEFAULT '1',
  `brrow_openid` varchar(64) NOT NULL DEFAULT '1',
  `allnumber` int(10) DEFAULT '0',
  `nickname` varchar(64) NOT NULL DEFAULT '1',
  `money` varchar(16) NOT NULL DEFAULT '0',
  `headimgurl` varchar(500) DEFAULT '',
  `time` varchar(16) NOT NULL DEFAULT '1',
  `code` varchar(100) NOT NULL DEFAULT '0',
  `check_sign` varchar(200) NOT NULL DEFAULT 'abc',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `check_sign` (`check_sign`)
) ENGINE=MyISAM AUTO_INCREMENT=3135 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('n1ce_mission_user','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('n1ce_mission_user','rid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `rid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_user','openid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `openid` varchar(64) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_user','brrow_openid')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `brrow_openid` varchar(64) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_user','allnumber')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `allnumber` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_user','nickname')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `nickname` varchar(64) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_user','money')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `money` varchar(16) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_user','headimgurl')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `headimgurl` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('n1ce_mission_user','time')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `time` varchar(16) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('n1ce_mission_user','code')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `code` varchar(100) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_user','check_sign')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `check_sign` varchar(200) NOT NULL DEFAULT 'abc'");}
if(!pdo_fieldexists('n1ce_mission_user','type')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `type` tinyint(4) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_user','status')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   `status` tinyint(4) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('n1ce_mission_user','id')) {pdo_query("ALTER TABLE ".tablename('n1ce_mission_user')." ADD   PRIMARY KEY (`id`)");}
