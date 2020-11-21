<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` varchar(1000) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `from_user` varchar(100) NOT NULL DEFAULT '',
  `accountname` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `salt` varchar(10) NOT NULL DEFAULT '',
  `pwd` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pay_account` varchar(200) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态',
  `role` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:店长,2:店员',
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(15) NOT NULL,
  `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_boss` tinyint(1) NOT NULL DEFAULT '0',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_account','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_account','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_account','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `storeid` varchar(1000) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_account','uid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `uid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_account','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `from_user` varchar(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_account','accountname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `accountname` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_account','password')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `password` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_account','salt')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `salt` varchar(10) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_account','pwd')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `pwd` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_account','mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `mobile` varchar(20) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_account','email')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `email` varchar(20) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_account','username')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `username` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_account','pay_account')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `pay_account` varchar(200) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_account','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_account','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_account','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_account','role')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `role` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:店长,2:店员'");}
if(!pdo_fieldexists('weisrc_dish_account','lastvisit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `lastvisit` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_account','lastip')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `lastip` varchar(15) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_account','areaid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id'");}
if(!pdo_fieldexists('weisrc_dish_account','is_admin_order')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_account','is_notice_order')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_account','is_notice_queue')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_account','is_notice_service')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_account','is_notice_boss')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `is_notice_boss` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_account','lat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('weisrc_dish_account','lng')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
if(!pdo_fieldexists('weisrc_dish_account','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注'");}
if(!pdo_fieldexists('weisrc_dish_account','schoolid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_account')." ADD   `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `thumb` varchar(500) NOT NULL DEFAULT '',
  `position` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:首页,2:商家页',
  `starttime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `dateline` int(10) unsigned NOT NULL,
  `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_ad','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_ad','uniacid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_ad','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `title` varchar(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_ad','url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `url` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_ad','thumb')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `thumb` varchar(500) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_ad','position')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `position` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:首页,2:商家页'");}
if(!pdo_fieldexists('weisrc_dish_ad','starttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `starttime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_ad','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_ad','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `displayorder` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_ad','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示'");}
if(!pdo_fieldexists('weisrc_dish_ad','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `dateline` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_ad','schoolid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_ad')." ADD   `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `realname` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `address` varchar(300) NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_address','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_address')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_address','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_address')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_address','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_address')." ADD   `from_user` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_address','realname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_address')." ADD   `realname` varchar(20) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_address','mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_address')." ADD   `mobile` varchar(11) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_address','address')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_address')." ADD   `address` varchar(300) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_address','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_address')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '区域名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_area','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_area')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_area','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_area')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_area','name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_area')." ADD   `name` varchar(50) NOT NULL COMMENT '区域名称'");}
if(!pdo_fieldexists('weisrc_dish_area','parentid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_area')." ADD   `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级'");}
if(!pdo_fieldexists('weisrc_dish_area','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_area')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_area','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_area')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_area','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_area')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_area','schoolid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_area')." ADD   `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_blacklist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(100) DEFAULT '' COMMENT '用户ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_openid` (`from_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_blacklist','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_blacklist')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_blacklist','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_blacklist')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_blacklist','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_blacklist')." ADD   `from_user` varchar(100) DEFAULT '' COMMENT '用户ID'");}
if(!pdo_fieldexists('weisrc_dish_blacklist','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_blacklist')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_blacklist','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_blacklist')." ADD   `dateline` int(10) DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('weisrc_dish_blacklist','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_blacklist')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_businesslog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL,
  `dining_mode` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型1店内2外卖3预定4快餐',
  `business_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '申请金额',
  `charges` decimal(10,2) DEFAULT '0.00' COMMENT '手续费',
  `successprice` decimal(10,2) DEFAULT '0.00' COMMENT '到帐金额',
  `haveprice` decimal(10,2) DEFAULT '0.00' COMMENT '已申请总金额',
  `totalprice` decimal(10,2) DEFAULT '0.00' COMMENT '当时可总金额',
  `trade_no` varchar(200) DEFAULT '0',
  `payment_no` varchar(200) DEFAULT '0',
  `result` varchar(1000) DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `handletime` int(10) DEFAULT '0' COMMENT '处理时间',
  `dateline` int(10) DEFAULT '0',
  `reason` varchar(1000) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_businesslog','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_businesslog','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','uid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `uid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_businesslog','dining_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `dining_mode` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型1店内2外卖3预定4快餐'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','business_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `business_type` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `price` decimal(10,2) DEFAULT '0.00' COMMENT '申请金额'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','charges')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `charges` decimal(10,2) DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','successprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `successprice` decimal(10,2) DEFAULT '0.00' COMMENT '到帐金额'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','haveprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `haveprice` decimal(10,2) DEFAULT '0.00' COMMENT '已申请总金额'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','totalprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `totalprice` decimal(10,2) DEFAULT '0.00' COMMENT '当时可总金额'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','trade_no')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `trade_no` varchar(200) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','payment_no')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `payment_no` varchar(200) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','result')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `result` varchar(1000) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','handletime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `handletime` int(10) DEFAULT '0' COMMENT '处理时间'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `dateline` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_businesslog','reason')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_businesslog')." ADD   `reason` varchar(1000) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_card` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `storeid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL DEFAULT '',
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `cardpre` varchar(10) NOT NULL DEFAULT '',
  `cardno` int(10) NOT NULL DEFAULT '0' COMMENT '会员卡号',
  `cardnumber` varchar(50) NOT NULL DEFAULT '',
  `headimgurl` varchar(500) NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '' COMMENT '登录密码',
  `coin` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `balance_score` int(10) NOT NULL DEFAULT '0' COMMENT '剩余积分',
  `total_score` int(10) NOT NULL DEFAULT '0' COMMENT '总积分',
  `spend_score` int(10) NOT NULL DEFAULT '0' COMMENT '消费积分',
  `sign_score` int(10) NOT NULL DEFAULT '0' COMMENT '签到积分',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总消费金额',
  `carnumber` varchar(100) NOT NULL DEFAULT '' COMMENT '车牌号码',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `updatetime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `lasttime` int(10) NOT NULL DEFAULT '0' COMMENT '到期时间',
  `dateline` int(10) NOT NULL DEFAULT '0' COMMENT '领卡时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_card','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_card','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_card','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `from_user` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_card','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_card','uid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id'");}
if(!pdo_fieldexists('weisrc_dish_card','cardpre')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `cardpre` varchar(10) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_card','cardno')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `cardno` int(10) NOT NULL DEFAULT '0' COMMENT '会员卡号'");}
if(!pdo_fieldexists('weisrc_dish_card','cardnumber')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `cardnumber` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_card','headimgurl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `headimgurl` varchar(500) NOT NULL DEFAULT '' COMMENT '头像'");}
if(!pdo_fieldexists('weisrc_dish_card','nickname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `nickname` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_card','password')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `password` varchar(200) NOT NULL DEFAULT '' COMMENT '登录密码'");}
if(!pdo_fieldexists('weisrc_dish_card','coin')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `coin` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '余额'");}
if(!pdo_fieldexists('weisrc_dish_card','balance_score')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `balance_score` int(10) NOT NULL DEFAULT '0' COMMENT '剩余积分'");}
if(!pdo_fieldexists('weisrc_dish_card','total_score')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `total_score` int(10) NOT NULL DEFAULT '0' COMMENT '总积分'");}
if(!pdo_fieldexists('weisrc_dish_card','spend_score')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `spend_score` int(10) NOT NULL DEFAULT '0' COMMENT '消费积分'");}
if(!pdo_fieldexists('weisrc_dish_card','sign_score')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `sign_score` int(10) NOT NULL DEFAULT '0' COMMENT '签到积分'");}
if(!pdo_fieldexists('weisrc_dish_card','money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总消费金额'");}
if(!pdo_fieldexists('weisrc_dish_card','carnumber')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `carnumber` varchar(100) NOT NULL DEFAULT '' COMMENT '车牌号码'");}
if(!pdo_fieldexists('weisrc_dish_card','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_card','updatetime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `updatetime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间'");}
if(!pdo_fieldexists('weisrc_dish_card','lasttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `lasttime` int(10) NOT NULL DEFAULT '0' COMMENT '到期时间'");}
if(!pdo_fieldexists('weisrc_dish_card','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_card')." ADD   `dateline` int(10) NOT NULL DEFAULT '0' COMMENT '领卡时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_cardlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `from_user` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL COMMENT '标题',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '业务类型-用户充值:1,消费:2',
  `operationtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '积分操作类型 增加:1  扣除:0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `remark` text NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_cardlog','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardlog')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_cardlog','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardlog')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_cardlog','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardlog')." ADD   `from_user` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cardlog','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardlog')." ADD   `title` varchar(200) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('weisrc_dish_cardlog','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardlog')." ADD   `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '业务类型-用户充值:1,消费:2'");}
if(!pdo_fieldexists('weisrc_dish_cardlog','operationtype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardlog')." ADD   `operationtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '积分操作类型 增加:1  扣除:0'");}
if(!pdo_fieldexists('weisrc_dish_cardlog','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardlog')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额'");}
if(!pdo_fieldexists('weisrc_dish_cardlog','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardlog')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cardlog','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardlog')." ADD   `remark` text NOT NULL COMMENT '备注'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_cardprice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `storeid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '',
  `daycount` int(10) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `icon` tinyint(1) NOT NULL DEFAULT '1',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '网址',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_cardprice','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprice')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_cardprice','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprice')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_cardprice','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprice')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cardprice','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprice')." ADD   `title` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_cardprice','daycount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprice')." ADD   `daycount` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cardprice','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprice')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_cardprice','icon')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprice')." ADD   `icon` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_cardprice','url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprice')." ADD   `url` varchar(500) NOT NULL DEFAULT '' COMMENT '网址'");}
if(!pdo_fieldexists('weisrc_dish_cardprice','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprice')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_cardprivilege` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `storeid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '特权名称',
  `desc` varchar(100) NOT NULL DEFAULT '' COMMENT '特权名称',
  `icon` tinyint(1) NOT NULL DEFAULT '1',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '网址',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_cardprivilege','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprivilege')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_cardprivilege','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprivilege')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_cardprivilege','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprivilege')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cardprivilege','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprivilege')." ADD   `title` varchar(50) NOT NULL DEFAULT '' COMMENT '特权名称'");}
if(!pdo_fieldexists('weisrc_dish_cardprivilege','desc')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprivilege')." ADD   `desc` varchar(100) NOT NULL DEFAULT '' COMMENT '特权名称'");}
if(!pdo_fieldexists('weisrc_dish_cardprivilege','icon')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprivilege')." ADD   `icon` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_cardprivilege','url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprivilege')." ADD   `url` varchar(500) NOT NULL DEFAULT '' COMMENT '网址'");}
if(!pdo_fieldexists('weisrc_dish_cardprivilege','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardprivilege')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_cardsetting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `title` varchar(200) NOT NULL DEFAULT '',
  `rule` text NOT NULL,
  `opencardcredit` int(10) NOT NULL DEFAULT '0' COMMENT '开卡奖励消费积分',
  `sendcredit` int(10) NOT NULL DEFAULT '0' COMMENT '推荐用户奖励消费积分',
  `startmoney` int(10) NOT NULL DEFAULT '0' COMMENT '多少金额可能抵扣',
  `maxcredit` int(10) NOT NULL DEFAULT '0' COMMENT '每次消费最多可以使用几个积分',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0' COMMENT '领卡时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_cardsetting','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_cardsetting','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_cardsetting','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD   `title` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_cardsetting','rule')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD   `rule` text NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cardsetting','opencardcredit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD   `opencardcredit` int(10) NOT NULL DEFAULT '0' COMMENT '开卡奖励消费积分'");}
if(!pdo_fieldexists('weisrc_dish_cardsetting','sendcredit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD   `sendcredit` int(10) NOT NULL DEFAULT '0' COMMENT '推荐用户奖励消费积分'");}
if(!pdo_fieldexists('weisrc_dish_cardsetting','startmoney')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD   `startmoney` int(10) NOT NULL DEFAULT '0' COMMENT '多少金额可能抵扣'");}
if(!pdo_fieldexists('weisrc_dish_cardsetting','maxcredit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD   `maxcredit` int(10) NOT NULL DEFAULT '0' COMMENT '每次消费最多可以使用几个积分'");}
if(!pdo_fieldexists('weisrc_dish_cardsetting','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cardsetting','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cardsetting')." ADD   `dateline` int(10) NOT NULL DEFAULT '0' COMMENT '领卡时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `goodsid` int(11) NOT NULL,
  `optionid` varchar(200) DEFAULT '',
  `optionname` varchar(200) DEFAULT '',
  `goodstype` tinyint(1) NOT NULL DEFAULT '1',
  `price` varchar(10) NOT NULL,
  `packvalue` varchar(10) NOT NULL DEFAULT '0' COMMENT '打包费',
  `from_user` varchar(50) NOT NULL,
  `total` int(10) unsigned NOT NULL,
  `tableid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_cart','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_cart','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cart','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cart','goodsid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `goodsid` int(11) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cart','optionid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `optionid` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_cart','optionname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `optionname` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_cart','goodstype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `goodstype` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_cart','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `price` varchar(10) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cart','packvalue')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `packvalue` varchar(10) NOT NULL DEFAULT '0' COMMENT '打包费'");}
if(!pdo_fieldexists('weisrc_dish_cart','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `from_user` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cart','total')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `total` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_cart','tableid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `tableid` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cart','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cart')." ADD   `dateline` int(10) DEFAULT '0' COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_cashlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `from_user` varchar(200) DEFAULT '',
  `logtype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '日志类型1佣金2配送佣金',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型1微信2余额',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '申请金额',
  `charges` decimal(10,2) DEFAULT '0.00' COMMENT '手续费',
  `successprice` decimal(10,2) DEFAULT '0.00' COMMENT '到帐金额',
  `totalprice` decimal(10,2) DEFAULT '0.00' COMMENT '余额',
  `trade_no` varchar(200) DEFAULT '0',
  `payment_no` varchar(200) DEFAULT '0',
  `remark` varchar(1000) DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `handletime` int(10) DEFAULT '0' COMMENT '处理时间',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_cashlog','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_cashlog','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `from_user` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_cashlog','logtype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `logtype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '日志类型1佣金2配送佣金'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型1微信2余额'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `price` decimal(10,2) DEFAULT '0.00' COMMENT '申请金额'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','charges')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `charges` decimal(10,2) DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','successprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `successprice` decimal(10,2) DEFAULT '0.00' COMMENT '到帐金额'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','totalprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `totalprice` decimal(10,2) DEFAULT '0.00' COMMENT '余额'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','trade_no')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `trade_no` varchar(200) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','payment_no')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `payment_no` varchar(200) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `remark` varchar(1000) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','handletime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `handletime` int(10) DEFAULT '0' COMMENT '处理时间'");}
if(!pdo_fieldexists('weisrc_dish_cashlog','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_cashlog')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店id',
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `rebate` decimal(5,2) NOT NULL DEFAULT '10.00' COMMENT '打折费率',
  `is_discount` int(2) NOT NULL DEFAULT '0' COMMENT '是否开启打折',
  `is_meal` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否店内点餐',
  `is_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否外卖订餐',
  `is_snack` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持快餐',
  `is_reservation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持预定',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `savewinetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_category','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_category','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店id'");}
if(!pdo_fieldexists('weisrc_dish_category','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_category','name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `name` varchar(50) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('weisrc_dish_category','parentid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级'");}
if(!pdo_fieldexists('weisrc_dish_category','rebate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `rebate` decimal(5,2) NOT NULL DEFAULT '10.00' COMMENT '打折费率'");}
if(!pdo_fieldexists('weisrc_dish_category','is_discount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `is_discount` int(2) NOT NULL DEFAULT '0' COMMENT '是否开启打折'");}
if(!pdo_fieldexists('weisrc_dish_category','is_meal')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `is_meal` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否店内点餐'");}
if(!pdo_fieldexists('weisrc_dish_category','is_delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `is_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否外卖订餐'");}
if(!pdo_fieldexists('weisrc_dish_category','is_snack')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `is_snack` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持快餐'");}
if(!pdo_fieldexists('weisrc_dish_category','is_reservation')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `is_reservation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持预定'");}
if(!pdo_fieldexists('weisrc_dish_category','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_category','enabled')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启'");}
if(!pdo_fieldexists('weisrc_dish_category','savewinetime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_category')." ADD   `savewinetime` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_checkuser` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `from_user` varchar(100) DEFAULT '' COMMENT '用户ID',
  `is_check` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_openid` (`from_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_checkuser','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_checkuser')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_checkuser','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_checkuser')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_checkuser','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_checkuser')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_checkuser','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_checkuser')." ADD   `from_user` varchar(100) DEFAULT '' COMMENT '用户ID'");}
if(!pdo_fieldexists('weisrc_dish_checkuser','is_check')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_checkuser')." ADD   `is_check` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_checkuser','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_checkuser')." ADD   `dateline` int(10) DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('weisrc_dish_checkuser','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_checkuser')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_collection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_collection','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_collection')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_collection','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_collection')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_collection','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_collection')." ADD   `from_user` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_collection','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_collection')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_collection','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_collection')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_commission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned DEFAULT '0',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号',
  `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `agentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级编号',
  `ordersn` varchar(100) DEFAULT '',
  `from_user` varchar(100) DEFAULT '' COMMENT '购买者openid',
  `price` decimal(10,2) DEFAULT '0.00',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_commission','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_commission','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `weid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_commission','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号'");}
if(!pdo_fieldexists('weisrc_dish_commission','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号'");}
if(!pdo_fieldexists('weisrc_dish_commission','agentid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `agentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级编号'");}
if(!pdo_fieldexists('weisrc_dish_commission','ordersn')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `ordersn` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_commission','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `from_user` varchar(100) DEFAULT '' COMMENT '购买者openid'");}
if(!pdo_fieldexists('weisrc_dish_commission','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `price` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_commission','level')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别'");}
if(!pdo_fieldexists('weisrc_dish_commission','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_commission','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_commission')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_coupon` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id',
  `levelid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '所属人群',
  `title` varchar(50) NOT NULL COMMENT '优惠券名称',
  `thumb` varchar(500) NOT NULL DEFAULT '' COMMENT '图片',
  `attr_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '属性 1=普通券 2=营销券',
  `ruletype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=不限 2=首单',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '优惠券类型 1=优惠券 2=代金券 3=礼品券 4=积分兑换',
  `gmoney` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `dmoney` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '抵用金额',
  `dcredit` int(10) NOT NULL DEFAULT '0',
  `goodsids` varchar(1000) NOT NULL DEFAULT '0' COMMENT '商品',
  `content` text NOT NULL COMMENT '详细内容',
  `totalcount` int(10) NOT NULL DEFAULT '0' COMMENT '发放总数',
  `usercount` int(10) NOT NULL DEFAULT '0' COMMENT '每人领取张数',
  `ticket_ty` tinyint(1) NOT NULL DEFAULT '0' COMMENT '积分兑换优惠券类型 1=优惠券2=代金券3=礼品券',
  `ticket_id` int(10) NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `needscore` int(10) NOT NULL DEFAULT '0' COMMENT '兑换需要积分',
  `starttime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `is_meal` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否店内点餐',
  `is_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否外卖订餐',
  `is_snack` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持快餐',
  `is_reservation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持预定',
  `is_shouyin` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持收银',
  `displayorder` tinyint(4) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_coupon','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_coupon','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_coupon','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id'");}
if(!pdo_fieldexists('weisrc_dish_coupon','levelid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `levelid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '所属人群'");}
if(!pdo_fieldexists('weisrc_dish_coupon','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `title` varchar(50) NOT NULL COMMENT '优惠券名称'");}
if(!pdo_fieldexists('weisrc_dish_coupon','thumb')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `thumb` varchar(500) NOT NULL DEFAULT '' COMMENT '图片'");}
if(!pdo_fieldexists('weisrc_dish_coupon','attr_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `attr_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '属性 1=普通券 2=营销券'");}
if(!pdo_fieldexists('weisrc_dish_coupon','ruletype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `ruletype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=不限 2=首单'");}
if(!pdo_fieldexists('weisrc_dish_coupon','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '优惠券类型 1=优惠券 2=代金券 3=礼品券 4=积分兑换'");}
if(!pdo_fieldexists('weisrc_dish_coupon','gmoney')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `gmoney` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额'");}
if(!pdo_fieldexists('weisrc_dish_coupon','dmoney')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `dmoney` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '抵用金额'");}
if(!pdo_fieldexists('weisrc_dish_coupon','dcredit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `dcredit` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_coupon','goodsids')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `goodsids` varchar(1000) NOT NULL DEFAULT '0' COMMENT '商品'");}
if(!pdo_fieldexists('weisrc_dish_coupon','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `content` text NOT NULL COMMENT '详细内容'");}
if(!pdo_fieldexists('weisrc_dish_coupon','totalcount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `totalcount` int(10) NOT NULL DEFAULT '0' COMMENT '发放总数'");}
if(!pdo_fieldexists('weisrc_dish_coupon','usercount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `usercount` int(10) NOT NULL DEFAULT '0' COMMENT '每人领取张数'");}
if(!pdo_fieldexists('weisrc_dish_coupon','ticket_ty')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `ticket_ty` tinyint(1) NOT NULL DEFAULT '0' COMMENT '积分兑换优惠券类型 1=优惠券2=代金券3=礼品券'");}
if(!pdo_fieldexists('weisrc_dish_coupon','ticket_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `ticket_id` int(10) NOT NULL DEFAULT '0' COMMENT '优惠券id'");}
if(!pdo_fieldexists('weisrc_dish_coupon','needscore')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `needscore` int(10) NOT NULL DEFAULT '0' COMMENT '兑换需要积分'");}
if(!pdo_fieldexists('weisrc_dish_coupon','starttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `starttime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_coupon','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_coupon','is_meal')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `is_meal` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否店内点餐'");}
if(!pdo_fieldexists('weisrc_dish_coupon','is_delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `is_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否外卖订餐'");}
if(!pdo_fieldexists('weisrc_dish_coupon','is_snack')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `is_snack` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持快餐'");}
if(!pdo_fieldexists('weisrc_dish_coupon','is_reservation')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `is_reservation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持预定'");}
if(!pdo_fieldexists('weisrc_dish_coupon','is_shouyin')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `is_shouyin` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持收银'");}
if(!pdo_fieldexists('weisrc_dish_coupon','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `displayorder` tinyint(4) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_coupon','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_coupon')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_credits_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(100) DEFAULT '',
  `credittype` varchar(100) DEFAULT '' COMMENT '积分类型',
  `num` decimal(10,2) DEFAULT '0.00',
  `operator` varchar(100) DEFAULT '',
  `remark` varchar(1000) DEFAULT NULL COMMENT '内容',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_credits_record','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_credits_record')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_credits_record','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_credits_record')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_credits_record','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_credits_record')." ADD   `from_user` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_credits_record','credittype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_credits_record')." ADD   `credittype` varchar(100) DEFAULT '' COMMENT '积分类型'");}
if(!pdo_fieldexists('weisrc_dish_credits_record','num')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_credits_record')." ADD   `num` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_credits_record','operator')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_credits_record')." ADD   `operator` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_credits_record','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_credits_record')." ADD   `remark` varchar(1000) DEFAULT NULL COMMENT '内容'");}
if(!pdo_fieldexists('weisrc_dish_credits_record','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_credits_record')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_delivery_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id',
  `orderid` int(10) NOT NULL DEFAULT '0' COMMENT '订单id',
  `delivery_id` int(10) NOT NULL DEFAULT '0' COMMENT '配送员id',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_delivery_record','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_delivery_record')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_delivery_record','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_delivery_record')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_delivery_record','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_delivery_record')." ADD   `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id'");}
if(!pdo_fieldexists('weisrc_dish_delivery_record','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_delivery_record')." ADD   `orderid` int(10) NOT NULL DEFAULT '0' COMMENT '订单id'");}
if(!pdo_fieldexists('weisrc_dish_delivery_record','delivery_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_delivery_record')." ADD   `delivery_id` int(10) NOT NULL DEFAULT '0' COMMENT '配送员id'");}
if(!pdo_fieldexists('weisrc_dish_delivery_record','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_delivery_record')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_delivery_record','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_delivery_record')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_delivery_record','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_delivery_record')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_deliveryarea` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属门店',
  `title` varchar(50) NOT NULL COMMENT '区域名称',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_deliveryarea','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliveryarea')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_deliveryarea','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliveryarea')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_deliveryarea','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliveryarea')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属门店'");}
if(!pdo_fieldexists('weisrc_dish_deliveryarea','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliveryarea')." ADD   `title` varchar(50) NOT NULL COMMENT '区域名称'");}
if(!pdo_fieldexists('weisrc_dish_deliveryarea','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliveryarea')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_deliveryarea','lat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliveryarea')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('weisrc_dish_deliveryarea','lng')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliveryarea')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
if(!pdo_fieldexists('weisrc_dish_deliveryarea','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliveryarea')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_deliveryarea','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliveryarea')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_deliverytime` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `begintime` varchar(20) DEFAULT '09:00' COMMENT '开始时间',
  `endtime` varchar(20) DEFAULT '18:00' COMMENT '结束时间',
  `price` decimal(10,2) DEFAULT '0.00',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_deliverytime','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliverytime')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_deliverytime','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliverytime')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_deliverytime','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliverytime')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_deliverytime','begintime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliverytime')." ADD   `begintime` varchar(20) DEFAULT '09:00' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_deliverytime','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliverytime')." ADD   `endtime` varchar(20) DEFAULT '18:00' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_deliverytime','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliverytime')." ADD   `price` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_deliverytime','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_deliverytime')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_dispatcharea` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属门店',
  `title` varchar(50) NOT NULL COMMENT '区域名称',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_dispatcharea','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_dispatcharea')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_dispatcharea','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_dispatcharea')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_dispatcharea','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_dispatcharea')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属门店'");}
if(!pdo_fieldexists('weisrc_dish_dispatcharea','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_dispatcharea')." ADD   `title` varchar(50) NOT NULL COMMENT '区域名称'");}
if(!pdo_fieldexists('weisrc_dish_dispatcharea','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_dispatcharea')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_dispatcharea','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_dispatcharea')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_dispatcharea','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_dispatcharea')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_distance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `begindistance` int(10) unsigned NOT NULL,
  `enddistance` int(10) unsigned NOT NULL,
  `sendingprice` decimal(10,2) DEFAULT '0.00' COMMENT '起送价格',
  `dispatchprice` decimal(10,2) DEFAULT '0.00',
  `freeprice` decimal(10,2) DEFAULT '0.00',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_distance','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_distance')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_distance','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_distance')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_distance','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_distance')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_distance','begindistance')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_distance')." ADD   `begindistance` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_distance','enddistance')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_distance')." ADD   `enddistance` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_distance','sendingprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_distance')." ADD   `sendingprice` decimal(10,2) DEFAULT '0.00' COMMENT '起送价格'");}
if(!pdo_fieldexists('weisrc_dish_distance','dispatchprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_distance')." ADD   `dispatchprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_distance','freeprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_distance')." ADD   `freeprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_distance','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_distance')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_email_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `email_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启邮箱提醒',
  `email_host` varchar(50) DEFAULT '' COMMENT '邮箱服务器',
  `email_send` varchar(100) DEFAULT '' COMMENT '商户发送邮件邮箱',
  `email_pwd` varchar(20) DEFAULT '' COMMENT '邮箱密码',
  `email_user` varchar(100) DEFAULT '' COMMENT '发信人名称',
  `email` varchar(100) DEFAULT '' COMMENT '商户接收邮件邮箱',
  `email_business_tpl` varchar(200) DEFAULT '' COMMENT '商户接收内容模板',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_email_setting','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_email_setting','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_email_setting','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_email_setting','email_enable')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `email_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启邮箱提醒'");}
if(!pdo_fieldexists('weisrc_dish_email_setting','email_host')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `email_host` varchar(50) DEFAULT '' COMMENT '邮箱服务器'");}
if(!pdo_fieldexists('weisrc_dish_email_setting','email_send')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `email_send` varchar(100) DEFAULT '' COMMENT '商户发送邮件邮箱'");}
if(!pdo_fieldexists('weisrc_dish_email_setting','email_pwd')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `email_pwd` varchar(20) DEFAULT '' COMMENT '邮箱密码'");}
if(!pdo_fieldexists('weisrc_dish_email_setting','email_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `email_user` varchar(100) DEFAULT '' COMMENT '发信人名称'");}
if(!pdo_fieldexists('weisrc_dish_email_setting','email')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `email` varchar(100) DEFAULT '' COMMENT '商户接收邮件邮箱'");}
if(!pdo_fieldexists('weisrc_dish_email_setting','email_business_tpl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `email_business_tpl` varchar(200) DEFAULT '' COMMENT '商户接收内容模板'");}
if(!pdo_fieldexists('weisrc_dish_email_setting','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_email_setting')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `weid` int(11) DEFAULT '0',
  `storeid` int(11) DEFAULT '0',
  `agentid` int(11) DEFAULT '0',
  `agentid2` int(11) DEFAULT '0',
  `agentid3` int(11) DEFAULT '0',
  `is_commission` tinyint(1) DEFAULT '1',
  `commission_price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `delivery_price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `from_user` varchar(50) DEFAULT '' COMMENT '用户ID',
  `nickname` varchar(50) DEFAULT '',
  `scene_str` varchar(500) DEFAULT '',
  `headimgurl` varchar(500) DEFAULT '',
  `username` varchar(50) DEFAULT '',
  `mobile` varchar(50) DEFAULT '',
  `address` varchar(200) DEFAULT '',
  `storeids` text COMMENT '门店',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '性别',
  `country` varchar(50) DEFAULT '',
  `province` varchar(50) DEFAULT '',
  `city` varchar(50) DEFAULT '',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `totalprice` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '交易总金额',
  `avgprice` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '平均金额',
  `totalcount` int(10) DEFAULT '0' COMMENT '交易次数',
  `paytime` int(10) DEFAULT '0' COMMENT '上次交易时间',
  `status` tinyint(1) DEFAULT '1',
  `noticetime` int(10) DEFAULT '0',
  `lastsendtime` int(10) DEFAULT '0',
  `lasttime` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  `sceneid` int(11) DEFAULT NULL,
  `ticketid` varchar(200) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `is_check` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_fans','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_fans','uid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `uid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `storeid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','agentid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `agentid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','agentid2')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `agentid2` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','agentid3')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `agentid3` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','is_commission')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `is_commission` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_fans','commission_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `commission_price` decimal(18,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_fans','delivery_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `delivery_price` decimal(18,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_fans','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `from_user` varchar(50) DEFAULT '' COMMENT '用户ID'");}
if(!pdo_fieldexists('weisrc_dish_fans','nickname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `nickname` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_fans','scene_str')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `scene_str` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_fans','headimgurl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `headimgurl` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_fans','username')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `username` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_fans','mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `mobile` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_fans','address')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `address` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_fans','storeids')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `storeids` text COMMENT '门店'");}
if(!pdo_fieldexists('weisrc_dish_fans','sex')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `sex` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '性别'");}
if(!pdo_fieldexists('weisrc_dish_fans','country')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `country` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_fans','province')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `province` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_fans','city')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `city` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_fans','lat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('weisrc_dish_fans','lng')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
if(!pdo_fieldexists('weisrc_dish_fans','totalprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `totalprice` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '交易总金额'");}
if(!pdo_fieldexists('weisrc_dish_fans','avgprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `avgprice` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '平均金额'");}
if(!pdo_fieldexists('weisrc_dish_fans','totalcount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `totalcount` int(10) DEFAULT '0' COMMENT '交易次数'");}
if(!pdo_fieldexists('weisrc_dish_fans','paytime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `paytime` int(10) DEFAULT '0' COMMENT '上次交易时间'");}
if(!pdo_fieldexists('weisrc_dish_fans','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `status` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_fans','noticetime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `noticetime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','lastsendtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `lastsendtime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','lasttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `lasttime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `dateline` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','sceneid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `sceneid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_fans','ticketid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `ticketid` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_fans','url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `url` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_fans','is_check')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   `is_check` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fans','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fans')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned DEFAULT '0',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号',
  `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `from_user` varchar(100) DEFAULT '',
  `star` tinyint(1) NOT NULL DEFAULT '5' COMMENT '等级',
  `content` varchar(500) DEFAULT '' COMMENT '内容',
  `replycontent` varchar(500) DEFAULT '' COMMENT '回复内容',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_feedback','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_feedback','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `weid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_feedback','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号'");}
if(!pdo_fieldexists('weisrc_dish_feedback','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号'");}
if(!pdo_fieldexists('weisrc_dish_feedback','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `from_user` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_feedback','star')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `star` tinyint(1) NOT NULL DEFAULT '5' COMMENT '等级'");}
if(!pdo_fieldexists('weisrc_dish_feedback','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `content` varchar(500) DEFAULT '' COMMENT '内容'");}
if(!pdo_fieldexists('weisrc_dish_feedback','replycontent')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `replycontent` varchar(500) DEFAULT '' COMMENT '回复内容'");}
if(!pdo_fieldexists('weisrc_dish_feedback','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `displayorder` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_feedback','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_feedback','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_feedback')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_fengniao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `orderid` int(11) DEFAULT '0',
  `open_order_code` varchar(200) DEFAULT '' COMMENT '蜂鸟配送开放平台返回的订单号',
  `partner_order_code` varchar(200) DEFAULT '' COMMENT '商户自己的订单号',
  `order_status` int(11) DEFAULT '0' COMMENT '状态码',
  `push_time` int(11) DEFAULT '0' COMMENT '状态推送时间(毫秒)',
  `carrier_driver_name` varchar(200) DEFAULT '' COMMENT '蜂鸟配送员姓名',
  `carrier_driver_phone` varchar(200) DEFAULT '' COMMENT '蜂鸟配送员电话',
  `description` varchar(200) DEFAULT '' COMMENT '描述信息',
  `address` varchar(200) DEFAULT '' COMMENT '定点次日达服务独有的字段: 微仓地址',
  `latitude` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '定点次日达服务独有的字段: 微仓纬度',
  `longitude` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '定点次日达服务独有的字段: 微仓经度',
  `cancel_reason` int(11) DEFAULT '0' COMMENT '订单取消原因. 1:用户取消, 2:商家取消',
  `error_code` varchar(200) DEFAULT '' COMMENT '错误编码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_fengniao','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_fengniao','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_fengniao','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_fengniao','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `orderid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','open_order_code')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `open_order_code` varchar(200) DEFAULT '' COMMENT '蜂鸟配送开放平台返回的订单号'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','partner_order_code')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `partner_order_code` varchar(200) DEFAULT '' COMMENT '商户自己的订单号'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','order_status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `order_status` int(11) DEFAULT '0' COMMENT '状态码'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','push_time')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `push_time` int(11) DEFAULT '0' COMMENT '状态推送时间(毫秒)'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','carrier_driver_name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `carrier_driver_name` varchar(200) DEFAULT '' COMMENT '蜂鸟配送员姓名'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','carrier_driver_phone')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `carrier_driver_phone` varchar(200) DEFAULT '' COMMENT '蜂鸟配送员电话'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','description')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `description` varchar(200) DEFAULT '' COMMENT '描述信息'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','address')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `address` varchar(200) DEFAULT '' COMMENT '定点次日达服务独有的字段: 微仓地址'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','latitude')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `latitude` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '定点次日达服务独有的字段: 微仓纬度'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','longitude')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `longitude` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '定点次日达服务独有的字段: 微仓经度'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','cancel_reason')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `cancel_reason` int(11) DEFAULT '0' COMMENT '订单取消原因. 1:用户取消, 2:商家取消'");}
if(!pdo_fieldexists('weisrc_dish_fengniao','error_code')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_fengniao')." ADD   `error_code` varchar(200) DEFAULT '' COMMENT '错误编码'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `storeid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL COMMENT '公众号id',
  `labelid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '打印标签',
  `pcate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类',
  `ccate` int(10) unsigned NOT NULL DEFAULT '0',
  `startcount` int(10) unsigned NOT NULL DEFAULT '1',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `thumb` varchar(500) NOT NULL DEFAULT '',
  `unitname` varchar(20) NOT NULL DEFAULT '份' COMMENT '单位',
  `description` varchar(1000) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text,
  `week` varchar(100) NOT NULL DEFAULT '1,2,3,4,5,6,0' COMMENT '星期',
  `taste` varchar(1000) NOT NULL DEFAULT '' COMMENT '口味',
  `isspecial` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `isoptions` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `marketprice` varchar(10) NOT NULL DEFAULT '' COMMENT '现价',
  `memberprice` varchar(10) NOT NULL DEFAULT '' COMMENT '会员价',
  `productprice` varchar(10) NOT NULL DEFAULT '' COMMENT '原价',
  `packvalue` varchar(10) NOT NULL DEFAULT '0' COMMENT '打包费',
  `delivery_commission_money` decimal(10,2) DEFAULT '0.00',
  `commission_money1` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `commission_money2` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `counts` int(10) NOT NULL DEFAULT '-1' COMMENT '今日库存',
  `today_counts` int(10) NOT NULL DEFAULT '0' COMMENT '今日销售量',
  `lasttime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总销量',
  `isshow_sales` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `credit` int(10) NOT NULL DEFAULT '0' COMMENT '奖励积分',
  `subcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被点次数',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `istime` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `begintime` varchar(20) DEFAULT '00:00' COMMENT '开始时间',
  `endtime` varchar(20) DEFAULT '23:59' COMMENT '结束时间',
  `startdate` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `enddate` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `dateline` int(10) unsigned NOT NULL,
  `endcount` int(10) unsigned NOT NULL DEFAULT '0',
  `freecount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_goods','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_goods','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_goods','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `weid` int(10) unsigned NOT NULL COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_goods','labelid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `labelid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '打印标签'");}
if(!pdo_fieldexists('weisrc_dish_goods','pcate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `pcate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类'");}
if(!pdo_fieldexists('weisrc_dish_goods','ccate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `ccate` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods','startcount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `startcount` int(10) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_goods','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称'");}
if(!pdo_fieldexists('weisrc_dish_goods','thumb')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `thumb` varchar(500) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_goods','unitname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `unitname` varchar(20) NOT NULL DEFAULT '份' COMMENT '单位'");}
if(!pdo_fieldexists('weisrc_dish_goods','description')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `description` varchar(1000) NOT NULL DEFAULT '' COMMENT '描述'");}
if(!pdo_fieldexists('weisrc_dish_goods','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `content` text");}
if(!pdo_fieldexists('weisrc_dish_goods','week')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `week` varchar(100) NOT NULL DEFAULT '1,2,3,4,5,6,0' COMMENT '星期'");}
if(!pdo_fieldexists('weisrc_dish_goods','taste')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `taste` varchar(1000) NOT NULL DEFAULT '' COMMENT '口味'");}
if(!pdo_fieldexists('weisrc_dish_goods','isspecial')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `isspecial` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_goods','isoptions')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `isoptions` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods','marketprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `marketprice` varchar(10) NOT NULL DEFAULT '' COMMENT '现价'");}
if(!pdo_fieldexists('weisrc_dish_goods','memberprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `memberprice` varchar(10) NOT NULL DEFAULT '' COMMENT '会员价'");}
if(!pdo_fieldexists('weisrc_dish_goods','productprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `productprice` varchar(10) NOT NULL DEFAULT '' COMMENT '原价'");}
if(!pdo_fieldexists('weisrc_dish_goods','packvalue')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `packvalue` varchar(10) NOT NULL DEFAULT '0' COMMENT '打包费'");}
if(!pdo_fieldexists('weisrc_dish_goods','delivery_commission_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `delivery_commission_money` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_goods','commission_money1')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `commission_money1` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('weisrc_dish_goods','commission_money2')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `commission_money2` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('weisrc_dish_goods','counts')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `counts` int(10) NOT NULL DEFAULT '-1' COMMENT '今日库存'");}
if(!pdo_fieldexists('weisrc_dish_goods','today_counts')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `today_counts` int(10) NOT NULL DEFAULT '0' COMMENT '今日销售量'");}
if(!pdo_fieldexists('weisrc_dish_goods','lasttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `lasttime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间'");}
if(!pdo_fieldexists('weisrc_dish_goods','sales')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总销量'");}
if(!pdo_fieldexists('weisrc_dish_goods','isshow_sales')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `isshow_sales` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_goods','credit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `credit` int(10) NOT NULL DEFAULT '0' COMMENT '奖励积分'");}
if(!pdo_fieldexists('weisrc_dish_goods','subcount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `subcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被点次数'");}
if(!pdo_fieldexists('weisrc_dish_goods','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_goods','recommend')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐'");}
if(!pdo_fieldexists('weisrc_dish_goods','deleted')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `displayorder` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods','istime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `istime` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods','begintime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `begintime` varchar(20) DEFAULT '00:00' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_goods','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `endtime` varchar(20) DEFAULT '23:59' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_goods','startdate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `startdate` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_goods','enddate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `enddate` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_goods','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `dateline` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_goods','endcount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `endcount` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods','freecount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods')." ADD   `freecount` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_goods_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) DEFAULT '0',
  `start` varchar(50) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `price` decimal(10,2) DEFAULT '0.00',
  `stock` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `specs` text,
  `type` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_goods_option','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_goods_option','goodsid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD   `goodsid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods_option','start')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD   `start` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_goods_option','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD   `title` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_goods_option','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD   `price` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_goods_option','stock')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD   `stock` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods_option','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods_option','specs')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD   `specs` text");}
if(!pdo_fieldexists('weisrc_dish_goods_option','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD   `type` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_goods_option','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_goods_option')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_intelligent` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店id',
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` int(10) NOT NULL DEFAULT '0' COMMENT '适用人数',
  `content` varchar(1000) NOT NULL DEFAULT '' COMMENT '商品',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '商品',
  `thumb` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_intelligent','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_intelligent')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_intelligent','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_intelligent')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店id'");}
if(!pdo_fieldexists('weisrc_dish_intelligent','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_intelligent')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_intelligent','name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_intelligent')." ADD   `name` int(10) NOT NULL DEFAULT '0' COMMENT '适用人数'");}
if(!pdo_fieldexists('weisrc_dish_intelligent','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_intelligent')." ADD   `content` varchar(1000) NOT NULL DEFAULT '' COMMENT '商品'");}
if(!pdo_fieldexists('weisrc_dish_intelligent','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_intelligent')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_intelligent','enabled')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_intelligent')." ADD   `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启'");}
if(!pdo_fieldexists('weisrc_dish_intelligent','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_intelligent')." ADD   `title` varchar(200) NOT NULL DEFAULT '' COMMENT '商品'");}
if(!pdo_fieldexists('weisrc_dish_intelligent','thumb')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_intelligent')." ADD   `thumb` varchar(500) NOT NULL DEFAULT ''");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_mealtime` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `begintime` varchar(20) DEFAULT '09:00' COMMENT '开始时间',
  `endtime` varchar(20) DEFAULT '18:00' COMMENT '结束时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_mealtime','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_mealtime')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_mealtime','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_mealtime')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_mealtime','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_mealtime')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_mealtime','begintime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_mealtime')." ADD   `begintime` varchar(20) DEFAULT '09:00' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_mealtime','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_mealtime')." ADD   `endtime` varchar(20) DEFAULT '18:00' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_mealtime','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_mealtime')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启'");}
if(!pdo_fieldexists('weisrc_dish_mealtime','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_mealtime')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_nave` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `type` int(10) NOT NULL DEFAULT '-1' COMMENT '链接类型 -1:自定义 1:首页2:门店3:菜单列表4:我的菜单',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '导航名称',
  `link` varchar(200) NOT NULL DEFAULT '' COMMENT '导航链接',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_nave','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_nave')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_nave','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_nave')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_nave','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_nave')." ADD   `type` int(10) NOT NULL DEFAULT '-1' COMMENT '链接类型 -1:自定义 1:首页2:门店3:菜单列表4:我的菜单'");}
if(!pdo_fieldexists('weisrc_dish_nave','name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_nave')." ADD   `name` varchar(50) NOT NULL DEFAULT '' COMMENT '导航名称'");}
if(!pdo_fieldexists('weisrc_dish_nave','link')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_nave')." ADD   `link` varchar(200) NOT NULL DEFAULT '' COMMENT '导航链接'");}
if(!pdo_fieldexists('weisrc_dish_nave','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_nave')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_nave','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_nave')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '名称',
  `content` text,
  `url` varchar(1000) DEFAULT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启',
  `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_notice','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_notice','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_notice','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice')." ADD   `title` varchar(200) NOT NULL DEFAULT '' COMMENT '名称'");}
if(!pdo_fieldexists('weisrc_dish_notice','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice')." ADD   `content` text");}
if(!pdo_fieldexists('weisrc_dish_notice','url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice')." ADD   `url` varchar(1000) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_notice','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_notice','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启'");}
if(!pdo_fieldexists('weisrc_dish_notice','schoolid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice')." ADD   `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_notice_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `noticeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `from_user` varchar(50) NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_notice_log','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice_log')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_notice_log','noticeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice_log')." ADD   `noticeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_notice_log','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice_log')." ADD   `from_user` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_notice_log','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_notice_log')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL COMMENT '公众号id',
  `storeid` int(10) unsigned NOT NULL COMMENT '门店id',
  `couponid` int(10) unsigned NOT NULL DEFAULT '0',
  `rechargeid` int(10) NOT NULL DEFAULT '0',
  `quicknum` varchar(30) NOT NULL DEFAULT '0001',
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(30) NOT NULL COMMENT '订单号',
  `totalnum` tinyint(4) DEFAULT NULL COMMENT '总数量',
  `totalprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价格',
  `tea_money` decimal(10,2) DEFAULT '0.00',
  `refund_price` decimal(10,2) DEFAULT '0.00',
  `service_money` decimal(10,2) DEFAULT '0.00',
  `discount_money` decimal(10,2) DEFAULT '0.00',
  `one_order_getprice` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '每单提现手续费',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1取消状态，0普通状态，1为确认付款方式，2为成功',
  `ispay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0,1,2',
  `ismerge` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否合并的单子',
  `paytype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1余额，2微信支付，3到付',
  `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `address` varchar(250) NOT NULL DEFAULT '' COMMENT '地址',
  `tel` varchar(50) NOT NULL DEFAULT '' COMMENT '联系电话',
  `meal_time` varchar(50) NOT NULL DEFAULT '' COMMENT '就餐时间',
  `counts` tinyint(4) DEFAULT '0' COMMENT '预订人数',
  `seat_type` tinyint(1) DEFAULT '0' COMMENT '位置类型1大厅2包间',
  `carports` tinyint(3) DEFAULT '0' COMMENT '车位',
  `delivery_id` int(10) NOT NULL DEFAULT '0' COMMENT '配送员id',
  `delivery_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `deliveryareaid` int(10) NOT NULL DEFAULT '0' COMMENT '配送点id',
  `delivery_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '佣金',
  `goodsprice` decimal(10,2) DEFAULT '0.00',
  `dispatchprice` decimal(10,2) DEFAULT '0.00',
  `packvalue` varchar(10) NOT NULL DEFAULT '0' COMMENT '打包费',
  `dining_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用餐类型 1:到店 2:外卖',
  `is_append` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否加单',
  `append_dish` tinyint(2) NOT NULL DEFAULT '0' COMMENT '加菜',
  `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `reply` varchar(1000) NOT NULL DEFAULT '' COMMENT '回复',
  `paydetail` varchar(1000) NOT NULL DEFAULT '' COMMENT '消费详细信息',
  `credit` varchar(10) NOT NULL DEFAULT '0' COMMENT '赠送积分',
  `tables` varchar(10) NOT NULL DEFAULT '' COMMENT '桌号',
  `tablezonesid` varchar(10) NOT NULL DEFAULT '' COMMENT '桌台类别',
  `print_sta` tinyint(1) DEFAULT '-1' COMMENT '打印状态',
  `sign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '-1拒绝，0未处理，1已处理',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `isfinish` tinyint(1) NOT NULL DEFAULT '0',
  `isemail` tinyint(1) NOT NULL DEFAULT '0',
  `ischeckfans` tinyint(1) NOT NULL DEFAULT '0',
  `issms` tinyint(1) NOT NULL DEFAULT '0',
  `istpl` tinyint(1) NOT NULL DEFAULT '0',
  `delivery_notice` tinyint(1) NOT NULL DEFAULT '0',
  `isfeedback` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否留言',
  `isvip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员',
  `finishtime` int(10) DEFAULT '0' COMMENT '完成时间',
  `confirmtime` int(10) DEFAULT '0' COMMENT '确认时间',
  `paytime` int(10) DEFAULT '0' COMMENT '付款时间',
  `isprint` tinyint(1) NOT NULL DEFAULT '0',
  `delivery_finish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已配送时间',
  `newlimitprice` varchar(500) NOT NULL DEFAULT '',
  `oldlimitprice` varchar(500) NOT NULL DEFAULT '',
  `newlimitpricevalue` varchar(10) NOT NULL DEFAULT '',
  `oldlimitpricevalue` varchar(10) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `isfengniao` tinyint(1) NOT NULL DEFAULT '0',
  `oldtotalprice` varchar(10) NOT NULL COMMENT '原总金额',
  `is_sys_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '平台配送',
  `floor_money` decimal(10,2) DEFAULT '0.00',
  `delivery_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '配送模式',
  `daycount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_order','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_order','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `weid` int(10) unsigned NOT NULL COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_order','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `storeid` int(10) unsigned NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('weisrc_dish_order','couponid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `couponid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','rechargeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `rechargeid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','quicknum')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `quicknum` varchar(30) NOT NULL DEFAULT '0001'");}
if(!pdo_fieldexists('weisrc_dish_order','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `from_user` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_order','ordersn')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `ordersn` varchar(30) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('weisrc_dish_order','totalnum')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `totalnum` tinyint(4) DEFAULT NULL COMMENT '总数量'");}
if(!pdo_fieldexists('weisrc_dish_order','totalprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `totalprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价格'");}
if(!pdo_fieldexists('weisrc_dish_order','tea_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `tea_money` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_order','refund_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `refund_price` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_order','service_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `service_money` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_order','discount_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `discount_money` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_order','one_order_getprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `one_order_getprice` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '每单提现手续费'");}
if(!pdo_fieldexists('weisrc_dish_order','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1取消状态，0普通状态，1为确认付款方式，2为成功'");}
if(!pdo_fieldexists('weisrc_dish_order','ispay')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `ispay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0,1,2'");}
if(!pdo_fieldexists('weisrc_dish_order','ismerge')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `ismerge` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否合并的单子'");}
if(!pdo_fieldexists('weisrc_dish_order','paytype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `paytype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1余额，2微信支付，3到付'");}
if(!pdo_fieldexists('weisrc_dish_order','transid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号'");}
if(!pdo_fieldexists('weisrc_dish_order','username')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名'");}
if(!pdo_fieldexists('weisrc_dish_order','address')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `address` varchar(250) NOT NULL DEFAULT '' COMMENT '地址'");}
if(!pdo_fieldexists('weisrc_dish_order','tel')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `tel` varchar(50) NOT NULL DEFAULT '' COMMENT '联系电话'");}
if(!pdo_fieldexists('weisrc_dish_order','meal_time')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `meal_time` varchar(50) NOT NULL DEFAULT '' COMMENT '就餐时间'");}
if(!pdo_fieldexists('weisrc_dish_order','counts')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `counts` tinyint(4) DEFAULT '0' COMMENT '预订人数'");}
if(!pdo_fieldexists('weisrc_dish_order','seat_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `seat_type` tinyint(1) DEFAULT '0' COMMENT '位置类型1大厅2包间'");}
if(!pdo_fieldexists('weisrc_dish_order','carports')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `carports` tinyint(3) DEFAULT '0' COMMENT '车位'");}
if(!pdo_fieldexists('weisrc_dish_order','delivery_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `delivery_id` int(10) NOT NULL DEFAULT '0' COMMENT '配送员id'");}
if(!pdo_fieldexists('weisrc_dish_order','delivery_status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `delivery_status` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','deliveryareaid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `deliveryareaid` int(10) NOT NULL DEFAULT '0' COMMENT '配送点id'");}
if(!pdo_fieldexists('weisrc_dish_order','delivery_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `delivery_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '佣金'");}
if(!pdo_fieldexists('weisrc_dish_order','goodsprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `goodsprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_order','dispatchprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `dispatchprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_order','packvalue')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `packvalue` varchar(10) NOT NULL DEFAULT '0' COMMENT '打包费'");}
if(!pdo_fieldexists('weisrc_dish_order','dining_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `dining_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用餐类型 1:到店 2:外卖'");}
if(!pdo_fieldexists('weisrc_dish_order','is_append')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `is_append` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否加单'");}
if(!pdo_fieldexists('weisrc_dish_order','append_dish')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `append_dish` tinyint(2) NOT NULL DEFAULT '0' COMMENT '加菜'");}
if(!pdo_fieldexists('weisrc_dish_order','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注'");}
if(!pdo_fieldexists('weisrc_dish_order','reply')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `reply` varchar(1000) NOT NULL DEFAULT '' COMMENT '回复'");}
if(!pdo_fieldexists('weisrc_dish_order','paydetail')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `paydetail` varchar(1000) NOT NULL DEFAULT '' COMMENT '消费详细信息'");}
if(!pdo_fieldexists('weisrc_dish_order','credit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `credit` varchar(10) NOT NULL DEFAULT '0' COMMENT '赠送积分'");}
if(!pdo_fieldexists('weisrc_dish_order','tables')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `tables` varchar(10) NOT NULL DEFAULT '' COMMENT '桌号'");}
if(!pdo_fieldexists('weisrc_dish_order','tablezonesid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `tablezonesid` varchar(10) NOT NULL DEFAULT '' COMMENT '桌台类别'");}
if(!pdo_fieldexists('weisrc_dish_order','print_sta')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `print_sta` tinyint(1) DEFAULT '-1' COMMENT '打印状态'");}
if(!pdo_fieldexists('weisrc_dish_order','sign')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `sign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '-1拒绝，0未处理，1已处理'");}
if(!pdo_fieldexists('weisrc_dish_order','lat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('weisrc_dish_order','lng')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
if(!pdo_fieldexists('weisrc_dish_order','isfinish')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `isfinish` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','isemail')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `isemail` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','ischeckfans')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `ischeckfans` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','issms')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `issms` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','istpl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `istpl` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','delivery_notice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `delivery_notice` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','isfeedback')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `isfeedback` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否留言'");}
if(!pdo_fieldexists('weisrc_dish_order','isvip')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `isvip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员'");}
if(!pdo_fieldexists('weisrc_dish_order','finishtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `finishtime` int(10) DEFAULT '0' COMMENT '完成时间'");}
if(!pdo_fieldexists('weisrc_dish_order','confirmtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `confirmtime` int(10) DEFAULT '0' COMMENT '确认时间'");}
if(!pdo_fieldexists('weisrc_dish_order','paytime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `paytime` int(10) DEFAULT '0' COMMENT '付款时间'");}
if(!pdo_fieldexists('weisrc_dish_order','isprint')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `isprint` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','delivery_finish_time')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `delivery_finish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已配送时间'");}
if(!pdo_fieldexists('weisrc_dish_order','newlimitprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `newlimitprice` varchar(500) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_order','oldlimitprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `oldlimitprice` varchar(500) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_order','newlimitpricevalue')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `newlimitpricevalue` varchar(10) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_order','oldlimitpricevalue')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `oldlimitpricevalue` varchar(10) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_order','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','isfengniao')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `isfengniao` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_order','oldtotalprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `oldtotalprice` varchar(10) NOT NULL COMMENT '原总金额'");}
if(!pdo_fieldexists('weisrc_dish_order','is_sys_delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `is_sys_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '平台配送'");}
if(!pdo_fieldexists('weisrc_dish_order','floor_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `floor_money` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_order','delivery_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `delivery_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '配送模式'");}
if(!pdo_fieldexists('weisrc_dish_order','daycount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order')." ADD   `daycount` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `goodsid` int(10) unsigned NOT NULL,
  `optionid` varchar(200) DEFAULT '',
  `optionname` varchar(200) DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `total` int(10) unsigned NOT NULL DEFAULT '1',
  `dateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_order_goods','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_order_goods','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_order_goods','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_order_goods','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD   `orderid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_order_goods','goodsid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD   `goodsid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_order_goods','optionid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD   `optionid` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_order_goods','optionname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD   `optionname` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_order_goods','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格'");}
if(!pdo_fieldexists('weisrc_dish_order_goods','total')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD   `total` int(10) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_order_goods','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_goods')." ADD   `dateline` int(10) unsigned NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_order_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号',
  `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `content` varchar(1000) DEFAULT NULL COMMENT '内容',
  `fromtype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '来源',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_order_log','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_log')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_order_log','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_log')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_order_log','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_log')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号'");}
if(!pdo_fieldexists('weisrc_dish_order_log','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_log')." ADD   `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号'");}
if(!pdo_fieldexists('weisrc_dish_order_log','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_log')." ADD   `content` varchar(1000) DEFAULT NULL COMMENT '内容'");}
if(!pdo_fieldexists('weisrc_dish_order_log','fromtype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_log')." ADD   `fromtype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '来源'");}
if(!pdo_fieldexists('weisrc_dish_order_log','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_log')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_order_log','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_order_log')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `styleid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `pictitle` varchar(100) NOT NULL DEFAULT '',
  `picurl` varchar(200) NOT NULL DEFAULT '',
  `picimage` varchar(500) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL,
  `nowprice` varchar(50) NOT NULL DEFAULT '',
  `oldprice` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_pic','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_pic')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_pic','styleid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_pic')." ADD   `styleid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_pic','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_pic')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_pic','pictitle')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_pic')." ADD   `pictitle` varchar(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_pic','picurl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_pic')." ADD   `picurl` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_pic','picimage')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_pic')." ADD   `picimage` varchar(500) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_pic','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_pic')." ADD   `dateline` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_pic','nowprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_pic')." ADD   `nowprice` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_pic','oldprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_pic')." ADD   `oldprice` varchar(50) NOT NULL DEFAULT ''");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_poster` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `keywords` varchar(50) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `data` text,
  `bg` varchar(500) DEFAULT '',
  `miss_font` varchar(50) DEFAULT NULL,
  `first_info` varchar(200) DEFAULT NULL,
  `miss_wait` varchar(200) DEFAULT NULL,
  `starttime` int(10) DEFAULT '0',
  `endtime` int(10) DEFAULT '0',
  `miss_start` varchar(200) DEFAULT NULL,
  `miss_end` varchar(200) DEFAULT NULL,
  `miss_sub` varchar(200) DEFAULT NULL,
  `miss_resub` varchar(200) DEFAULT NULL,
  `miss_temp` varchar(200) DEFAULT NULL,
  `miss_back` varchar(200) DEFAULT NULL,
  `miss_finish` varchar(200) DEFAULT NULL,
  `miss_youzan` varchar(200) DEFAULT NULL,
  `miss_cj` varchar(200) DEFAULT NULL,
  `stitle` text,
  `sthumb` text,
  `sdesc` text,
  `surl` text,
  `miss_name` varchar(50) DEFAULT '',
  `xzlx` int(1) NOT NULL DEFAULT '0',
  `fans_limit` int(1) NOT NULL DEFAULT '0',
  `area` text NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '0',
  `iptype` int(1) NOT NULL DEFAULT '0',
  `posttype` int(1) NOT NULL DEFAULT '0',
  `miss_num` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_poster','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_poster','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','keywords')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `keywords` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_poster','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `title` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_poster','data')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `data` text");}
if(!pdo_fieldexists('weisrc_dish_poster','bg')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `bg` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_font')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_font` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','first_info')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `first_info` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_wait')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_wait` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','starttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `starttime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `endtime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_start')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_start` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_end')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_end` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_sub')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_sub` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_resub')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_resub` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_temp')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_temp` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_back')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_back` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_finish')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_finish` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_youzan')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_youzan` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_cj')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_cj` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','stitle')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `stitle` text");}
if(!pdo_fieldexists('weisrc_dish_poster','sthumb')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `sthumb` text");}
if(!pdo_fieldexists('weisrc_dish_poster','sdesc')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `sdesc` text");}
if(!pdo_fieldexists('weisrc_dish_poster','surl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `surl` text");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_name` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_poster','xzlx')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `xzlx` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','fans_limit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `fans_limit` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','area')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `area` text NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_poster','sex')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `sex` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','iptype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `iptype` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','posttype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `posttype` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','miss_num')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `miss_num` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   `dateline` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_poster','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_poster')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_print_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `print_type` varchar(50) NOT NULL COMMENT '打印机类型',
  `print_usr` varchar(50) DEFAULT '',
  `orderid` int(10) unsigned NOT NULL DEFAULT '0',
  `goodsid` int(10) unsigned NOT NULL DEFAULT '0',
  `optionid` varchar(200) DEFAULT '',
  `optionname` varchar(200) DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已打印',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_print_goods','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_print_goods','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_print_goods','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_print_goods','print_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `print_type` varchar(50) NOT NULL COMMENT '打印机类型'");}
if(!pdo_fieldexists('weisrc_dish_print_goods','print_usr')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `print_usr` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_print_goods','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `orderid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_print_goods','goodsid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `goodsid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_print_goods','optionid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `optionid` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_print_goods','optionname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `optionname` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_print_goods','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_print_goods','total')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `total` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_print_goods','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_print_goods','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_goods')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已打印'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_print_label` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店id',
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `title` varchar(50) NOT NULL COMMENT '标签名称',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_print_label','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_label')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_print_label','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_label')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店id'");}
if(!pdo_fieldexists('weisrc_dish_print_label','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_label')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_print_label','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_label')." ADD   `title` varchar(50) NOT NULL COMMENT '标签名称'");}
if(!pdo_fieldexists('weisrc_dish_print_label','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_label')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_print_label','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_label')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_print_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `print_usr` varchar(50) DEFAULT '',
  `print_status` tinyint(1) DEFAULT '-1',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_print_order','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_order')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_print_order','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_order')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_print_order','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_order')." ADD   `orderid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_print_order','print_usr')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_order')." ADD   `print_usr` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_print_order','print_status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_order')." ADD   `print_status` tinyint(1) DEFAULT '-1'");}
if(!pdo_fieldexists('weisrc_dish_print_order','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_order')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_print_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `title` varchar(200) DEFAULT '',
  `print_status` tinyint(1) NOT NULL,
  `type` varchar(50) DEFAULT 'hongxin',
  `position_type` tinyint(1) DEFAULT '1',
  `yilian_type` tinyint(1) DEFAULT '1',
  `api_key` varchar(100) DEFAULT '' COMMENT 'api密钥',
  `member_code` varchar(100) DEFAULT '' COMMENT '商户代码',
  `feyin_key` varchar(100) DEFAULT '' COMMENT 'api密钥',
  `print_type` tinyint(1) NOT NULL,
  `print_usr` varchar(50) DEFAULT '',
  `print_nums` tinyint(3) DEFAULT '1',
  `print_top` varchar(40) DEFAULT '',
  `print_bottom` varchar(40) DEFAULT '',
  `is_print_all` tinyint(1) NOT NULL DEFAULT '1',
  `is_meal` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否店内点餐',
  `is_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否外卖订餐',
  `is_snack` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持快餐',
  `is_reservation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持预定',
  `is_shouyin` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持收银',
  `api_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '打印机api类型',
  `print_label` varchar(500) DEFAULT '0',
  `print_goodstype` varchar(500) DEFAULT '0',
  `qrcode_status` tinyint(1) NOT NULL DEFAULT '0',
  `qrcode_url` varchar(200) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `is_nums` tinyint(1) NOT NULL DEFAULT '0' COMMENT '每个商品打印一次',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_print_setting','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_print_setting','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_print_setting','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_print_setting','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `title` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_print_setting','print_status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `print_status` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_print_setting','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `type` varchar(50) DEFAULT 'hongxin'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','position_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `position_type` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','yilian_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `yilian_type` tinyint(1) DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','api_key')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `api_key` varchar(100) DEFAULT '' COMMENT 'api密钥'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','member_code')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `member_code` varchar(100) DEFAULT '' COMMENT '商户代码'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','feyin_key')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `feyin_key` varchar(100) DEFAULT '' COMMENT 'api密钥'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','print_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `print_type` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_print_setting','print_usr')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `print_usr` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_print_setting','print_nums')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `print_nums` tinyint(3) DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','print_top')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `print_top` varchar(40) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_print_setting','print_bottom')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `print_bottom` varchar(40) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_print_setting','is_print_all')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `is_print_all` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','is_meal')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `is_meal` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否店内点餐'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','is_delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `is_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否外卖订餐'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','is_snack')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `is_snack` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持快餐'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','is_reservation')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `is_reservation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持预定'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','is_shouyin')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `is_shouyin` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支持收银'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','api_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `api_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '打印机api类型'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','print_label')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `print_label` varchar(500) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','print_goodstype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `print_goodstype` varchar(500) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','qrcode_status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `qrcode_status` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','qrcode_url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `qrcode_url` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_print_setting','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `dateline` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_print_setting','is_nums')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_print_setting')." ADD   `is_nums` tinyint(1) NOT NULL DEFAULT '0' COMMENT '每个商品打印一次'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_queue_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `queueid` int(10) unsigned NOT NULL DEFAULT '0',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `from_user` varchar(200) NOT NULL DEFAULT '',
  `num` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `usercount` int(10) unsigned NOT NULL DEFAULT '0',
  `isnotify` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_queue_order','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_queue_order','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_queue_order','queueid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `queueid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_queue_order','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_queue_order','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `from_user` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_queue_order','num')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `num` varchar(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_queue_order','mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `mobile` varchar(30) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_queue_order','usercount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `usercount` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_queue_order','isnotify')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `isnotify` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_queue_order','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_queue_order','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_order')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_queue_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `limit_num` int(10) unsigned NOT NULL DEFAULT '0',
  `prefix` varchar(50) NOT NULL,
  `starttime` varchar(50) NOT NULL DEFAULT '00:00' COMMENT '开始时间',
  `endtime` varchar(50) NOT NULL DEFAULT '23:59' COMMENT '结束时间',
  `notify_number` int(10) NOT NULL DEFAULT '0' COMMENT '通知人数',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_queue_setting','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `title` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','limit_num')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `limit_num` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','prefix')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `prefix` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','starttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `starttime` varchar(50) NOT NULL DEFAULT '00:00' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `endtime` varchar(50) NOT NULL DEFAULT '23:59' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','notify_number')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `notify_number` int(10) NOT NULL DEFAULT '0' COMMENT '通知人数'");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_queue_setting','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_queue_setting')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_recharge` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id',
  `title` varchar(200) NOT NULL COMMENT '活动名称',
  `recharge_value` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值多少',
  `give_value` int(10) NOT NULL DEFAULT '0' COMMENT '赠送多少',
  `total` int(10) NOT NULL DEFAULT '0' COMMENT '几期',
  `starttime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `content` text NOT NULL,
  `displayorder` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_recharge','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_recharge','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_recharge','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id'");}
if(!pdo_fieldexists('weisrc_dish_recharge','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `title` varchar(200) NOT NULL COMMENT '活动名称'");}
if(!pdo_fieldexists('weisrc_dish_recharge','recharge_value')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `recharge_value` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值多少'");}
if(!pdo_fieldexists('weisrc_dish_recharge','give_value')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `give_value` int(10) NOT NULL DEFAULT '0' COMMENT '赠送多少'");}
if(!pdo_fieldexists('weisrc_dish_recharge','total')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `total` int(10) NOT NULL DEFAULT '0' COMMENT '几期'");}
if(!pdo_fieldexists('weisrc_dish_recharge','starttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `starttime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_recharge','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_recharge','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `content` text NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_recharge','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `displayorder` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_recharge','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_recharge','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_recharge_record` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rechargeid` int(10) NOT NULL DEFAULT '0',
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `from_user` varchar(100) DEFAULT '',
  `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id',
  `orderid` int(10) NOT NULL DEFAULT '0' COMMENT '订单id',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `displayorder` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `remark` text NOT NULL COMMENT '备注',
  `givetime` int(10) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_recharge_record','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','rechargeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `rechargeid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `from_user` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `orderid` int(10) NOT NULL DEFAULT '0' COMMENT '订单id'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `displayorder` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `remark` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','givetime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `givetime` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_recharge_record','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_recharge_record')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_refund_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_user` varchar(50) NOT NULL,
  `remark` varchar(1000) NOT NULL DEFAULT '0' COMMENT '退款备注',
  `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商户订单号',
  `transaction_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '微信订单号',
  `out_refund_no` varchar(50) NOT NULL DEFAULT '0' COMMENT '微信订单号',
  `refund_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '微信退款单号',
  `total_fee` varchar(50) NOT NULL DEFAULT '0' COMMENT '订单总金额',
  `refund_fee` varchar(50) NOT NULL DEFAULT '0' COMMENT '微信退款单号',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `err_code_des` varchar(200) NOT NULL DEFAULT '0' COMMENT '错误代码描述',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_refund_log','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_refund_log','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `from_user` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_refund_log','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `remark` varchar(1000) NOT NULL DEFAULT '0' COMMENT '退款备注'");}
if(!pdo_fieldexists('weisrc_dish_refund_log','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商户订单号'");}
if(!pdo_fieldexists('weisrc_dish_refund_log','transaction_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `transaction_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '微信订单号'");}
if(!pdo_fieldexists('weisrc_dish_refund_log','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `out_refund_no` varchar(50) NOT NULL DEFAULT '0' COMMENT '微信订单号'");}
if(!pdo_fieldexists('weisrc_dish_refund_log','refund_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `refund_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '微信退款单号'");}
if(!pdo_fieldexists('weisrc_dish_refund_log','total_fee')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `total_fee` varchar(50) NOT NULL DEFAULT '0' COMMENT '订单总金额'");}
if(!pdo_fieldexists('weisrc_dish_refund_log','refund_fee')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `refund_fee` varchar(50) NOT NULL DEFAULT '0' COMMENT '微信退款单号'");}
if(!pdo_fieldexists('weisrc_dish_refund_log','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_refund_log','err_code_des')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `err_code_des` varchar(200) NOT NULL DEFAULT '0' COMMENT '错误代码描述'");}
if(!pdo_fieldexists('weisrc_dish_refund_log','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_refund_log')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '入口类型',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入口门店',
  `description` varchar(1000) NOT NULL DEFAULT '',
  `picture` varchar(255) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期',
  PRIMARY KEY (`id`),
  KEY `idx_rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_reply','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_reply','rid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD   `rid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_reply','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_reply','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD   `title` varchar(255) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_reply','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD   `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '入口类型'");}
if(!pdo_fieldexists('weisrc_dish_reply','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入口门店'");}
if(!pdo_fieldexists('weisrc_dish_reply','description')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD   `description` varchar(1000) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_reply','picture')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD   `picture` varchar(255) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_reply','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期'");}
if(!pdo_fieldexists('weisrc_dish_reply','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reply')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_reservation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店',
  `tablezonesid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '餐桌类型id',
  `time` varchar(200) NOT NULL DEFAULT '' COMMENT '预定时间',
  `label` varchar(50) NOT NULL DEFAULT '' COMMENT '标签',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_reservation','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reservation')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_reservation','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reservation')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_reservation','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reservation')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店'");}
if(!pdo_fieldexists('weisrc_dish_reservation','tablezonesid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reservation')." ADD   `tablezonesid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '餐桌类型id'");}
if(!pdo_fieldexists('weisrc_dish_reservation','time')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reservation')." ADD   `time` varchar(200) NOT NULL DEFAULT '' COMMENT '预定时间'");}
if(!pdo_fieldexists('weisrc_dish_reservation','label')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reservation')." ADD   `label` varchar(50) NOT NULL DEFAULT '' COMMENT '标签'");}
if(!pdo_fieldexists('weisrc_dish_reservation','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reservation')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_reservation','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_reservation')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_savewine_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `savewineid` int(10) unsigned NOT NULL,
  `goodsid` int(10) unsigned NOT NULL,
  `total` int(10) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `dateline` int(10) unsigned NOT NULL,
  `savetime` int(10) unsigned NOT NULL DEFAULT '0',
  `takeouttime` int(10) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_savewine_goods','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','savewineid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `savewineid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','goodsid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `goodsid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','total')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `total` int(10) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `dateline` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','savetime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `savetime` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','takeouttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `takeouttime` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_savewine_goods','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_goods')." ADD   `remark` varchar(100) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_savewine_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号',
  `from_user` varchar(100) DEFAULT '',
  `savenumber` varchar(100) NOT NULL DEFAULT '' COMMENT '存酒卡号',
  `title` varchar(200) DEFAULT NULL COMMENT '物品名称',
  `username` varchar(100) DEFAULT NULL COMMENT '用户姓名',
  `tel` varchar(30) DEFAULT NULL COMMENT '联系电话',
  `remark` text NOT NULL COMMENT '备注',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `takeouttime` int(10) unsigned NOT NULL DEFAULT '0',
  `savetime` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `tablesid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_savewine_log','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `from_user` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','savenumber')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `savenumber` varchar(100) NOT NULL DEFAULT '' COMMENT '存酒卡号'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `title` varchar(200) DEFAULT NULL COMMENT '物品名称'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','username')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `username` varchar(100) DEFAULT NULL COMMENT '用户姓名'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','tel')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `tel` varchar(30) DEFAULT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `remark` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `displayorder` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','takeouttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `takeouttime` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','savetime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `savetime` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_savewine_log','tablesid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_log')." ADD   `tablesid` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_savewine_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号',
  `savewineid` int(10) unsigned NOT NULL DEFAULT '0',
  `goodsid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `total` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `type` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_savewine_record','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_record')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_savewine_record','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_record')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_savewine_record','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_record')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号'");}
if(!pdo_fieldexists('weisrc_dish_savewine_record','savewineid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_record')." ADD   `savewineid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_savewine_record','goodsid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_record')." ADD   `goodsid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号'");}
if(!pdo_fieldexists('weisrc_dish_savewine_record','total')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_record')." ADD   `total` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_savewine_record','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_record')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_savewine_record','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_savewine_record')." ADD   `type` int(10) unsigned NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_school` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `title` varchar(50) NOT NULL COMMENT '区域名称',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_school','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_school')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_school','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_school')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_school','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_school')." ADD   `title` varchar(50) NOT NULL COMMENT '区域名称'");}
if(!pdo_fieldexists('weisrc_dish_school','lat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_school')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('weisrc_dish_school','lng')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_school')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
if(!pdo_fieldexists('weisrc_dish_school','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_school')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_school','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_school')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_school','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_school')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_service_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号',
  `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `from_user` varchar(100) DEFAULT '',
  `content` varchar(1000) DEFAULT NULL COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '4' COMMENT '订单:1,服务员:2,打包:3,消息:4',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_service_log','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_service_log')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_service_log','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_service_log')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_service_log','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_service_log')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号'");}
if(!pdo_fieldexists('weisrc_dish_service_log','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_service_log')." ADD   `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号'");}
if(!pdo_fieldexists('weisrc_dish_service_log','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_service_log')." ADD   `from_user` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_service_log','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_service_log')." ADD   `content` varchar(1000) DEFAULT NULL COMMENT '内容'");}
if(!pdo_fieldexists('weisrc_dish_service_log','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_service_log')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_service_log','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_service_log')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_service_log','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_service_log')." ADD   `type` tinyint(1) NOT NULL DEFAULT '4' COMMENT '订单:1,服务员:2,打包:3,消息:4'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(50) DEFAULT '' COMMENT '网站名称',
  `thumb` varchar(200) DEFAULT '' COMMENT '背景图',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `mode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '模式',
  `is_notice` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '开启提醒',
  `entrance_type` tinyint(1) unsigned NOT NULL COMMENT '入口类型1:首页2门店列表3商品列表4我的菜单',
  `entrance_storeid` tinyint(1) unsigned NOT NULL COMMENT '入口门店id',
  `order_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订餐开启',
  `dining_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用餐类型 1:到店 2:外卖',
  `istplnotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否模版通知',
  `tpltype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '模版行业类型',
  `tplneworder` varchar(200) DEFAULT '' COMMENT '模板id',
  `tplnewqueue` varchar(200) DEFAULT '' COMMENT '模板id',
  `tploperator` varchar(200) DEFAULT '' COMMENT '模板id',
  `tplmission` varchar(200) DEFAULT '' COMMENT '模板id',
  `tplcoupon` varchar(200) DEFAULT '' COMMENT '模板id',
  `fengniao_appid` varchar(200) DEFAULT '',
  `fengniao_key` varchar(200) DEFAULT '',
  `tplboss` varchar(200) NOT NULL DEFAULT '',
  `tplapplynotice` varchar(200) NOT NULL DEFAULT '',
  `link_card_name` varchar(100) DEFAULT '',
  `link_card` varchar(500) DEFAULT '',
  `link_sign_name` varchar(100) DEFAULT '',
  `link_sign` varchar(500) DEFAULT '',
  `searchword` varchar(1000) DEFAULT '' COMMENT '搜索关键字',
  `tpluser` text COMMENT '通知用户',
  `sms_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启短信提醒',
  `sms_username` varchar(20) DEFAULT '' COMMENT '平台帐号',
  `sms_pwd` varchar(20) DEFAULT '' COMMENT '平台密码',
  `sms_mobile` varchar(20) DEFAULT '' COMMENT '商户接收短信手机',
  `email_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启邮箱提醒',
  `email_host` varchar(50) DEFAULT '' COMMENT '邮箱服务器',
  `email_send` varchar(100) DEFAULT '' COMMENT '商户发送邮件邮箱',
  `email_pwd` varchar(20) DEFAULT '' COMMENT '邮箱密码',
  `email_user` varchar(100) DEFAULT '' COMMENT '发信人名称',
  `email` varchar(100) DEFAULT '' COMMENT '平台接收邮件邮箱',
  `getcash_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最低提现金额',
  `fee_rate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现费率',
  `one_order_getprice` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '每单提现手续费',
  `fee_min` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额',
  `fee_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最高金额',
  `is_open_price` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '开启提现',
  `is_commission` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启分销',
  `commission_keywords` varchar(200) DEFAULT '',
  `table_cover` varchar(500) DEFAULT '',
  `table_desc` varchar(200) DEFAULT '',
  `commission_level` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分销级别',
  `commission_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分销模式',
  `commission_money_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '佣金模式',
  `commission1_rate_max` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金费率',
  `commission1_value_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额',
  `commission2_rate_max` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金费率',
  `commission2_value_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额',
  `commission3_rate_max` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金费率',
  `commission3_value_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额',
  `commission_settlement` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '佣金结算方式',
  `is_verify_mobile` tinyint(1) NOT NULL DEFAULT '0',
  `credit_mode` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:商品积分;2订单金额计算',
  `fengniao_mode` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:正式启用;2:调试阶段',
  `payx_credit` int(10) NOT NULL DEFAULT '0' COMMENT '消费一元积分',
  `dayu_appkey` varchar(200) DEFAULT '',
  `dayu_secretkey` varchar(200) DEFAULT '',
  `dayu_verify_code` varchar(200) DEFAULT '',
  `dayu_sign` varchar(200) DEFAULT '',
  `delivery_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '配送通知模式',
  `delivery_commission_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '配送佣金模式',
  `delivery_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '佣金',
  `delivery_cash_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现最低金额',
  `delivery_rate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金费率',
  `delivery_order_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '配送订单数量限制',
  `delivery_auto_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自动推送配送员时间设置',
  `delivery_finish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自动完成已配送订单',
  `link_recharge` varchar(500) DEFAULT '',
  `link_recharge_name` varchar(100) DEFAULT '',
  `wechat` tinyint(1) NOT NULL DEFAULT '1',
  `alipay` tinyint(1) NOT NULL DEFAULT '1',
  `credit` tinyint(1) NOT NULL DEFAULT '1',
  `delivery` tinyint(1) NOT NULL DEFAULT '1',
  `is_speaker` tinyint(1) NOT NULL DEFAULT '1',
  `is_show_virtual` tinyint(1) NOT NULL DEFAULT '0',
  `is_auto_address` tinyint(1) NOT NULL DEFAULT '0',
  `is_show_home` tinyint(1) NOT NULL DEFAULT '1',
  `is_operator_pwd` tinyint(1) NOT NULL DEFAULT '0',
  `is_contain_delivery` tinyint(1) NOT NULL DEFAULT '1',
  `is_auto_commission` tinyint(1) NOT NULL DEFAULT '0',
  `auto_commission_coin` int(10) NOT NULL DEFAULT '0',
  `tiptype` tinyint(1) NOT NULL DEFAULT '1',
  `tipbtn` tinyint(1) NOT NULL DEFAULT '1',
  `tipqrcode` varchar(500) DEFAULT '',
  `kefuqrcode` varchar(500) DEFAULT '',
  `operator_pwd` varchar(50) DEFAULT '',
  `apiclient_cert` tinyint(1) NOT NULL DEFAULT '0',
  `apiclient_key` tinyint(1) NOT NULL DEFAULT '0',
  `rootca` tinyint(1) NOT NULL DEFAULT '0',
  `share_title` varchar(200) DEFAULT '',
  `share_desc` varchar(300) DEFAULT '',
  `share_image` varchar(500) DEFAULT '',
  `follow_url` varchar(500) DEFAULT '',
  `follow_title` varchar(500) DEFAULT '',
  `follow_desc` varchar(500) DEFAULT '',
  `follow_logo` varchar(500) DEFAULT '',
  `site_logo` varchar(500) DEFAULT '',
  `isneedfollow` tinyint(1) DEFAULT '0',
  `statistics` text NOT NULL,
  `visit` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  `style_base` varchar(20) NOT NULL DEFAULT '',
  `style_list_btn1` varchar(20) NOT NULL DEFAULT '',
  `style_list_btn2` varchar(20) NOT NULL DEFAULT '',
  `style_list_btn3` varchar(20) NOT NULL DEFAULT '',
  `style_list_base` varchar(20) NOT NULL DEFAULT '',
  `is_show_toutiao` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_show_visit` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `auth_mode` tinyint(1) NOT NULL DEFAULT '1',
  `is_check_user` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户是否需要审核',
  `is_school` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_quick_money` tinyint(1) NOT NULL DEFAULT '0' COMMENT '提现周期',
  `is_yunzhong` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_setting','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_setting','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_setting','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `title` varchar(50) DEFAULT '' COMMENT '网站名称'");}
if(!pdo_fieldexists('weisrc_dish_setting','thumb')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `thumb` varchar(200) DEFAULT '' COMMENT '背景图'");}
if(!pdo_fieldexists('weisrc_dish_setting','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `mode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '模式'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_notice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_notice` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '开启提醒'");}
if(!pdo_fieldexists('weisrc_dish_setting','entrance_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `entrance_type` tinyint(1) unsigned NOT NULL COMMENT '入口类型1:首页2门店列表3商品列表4我的菜单'");}
if(!pdo_fieldexists('weisrc_dish_setting','entrance_storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `entrance_storeid` tinyint(1) unsigned NOT NULL COMMENT '入口门店id'");}
if(!pdo_fieldexists('weisrc_dish_setting','order_enable')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `order_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订餐开启'");}
if(!pdo_fieldexists('weisrc_dish_setting','dining_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `dining_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用餐类型 1:到店 2:外卖'");}
if(!pdo_fieldexists('weisrc_dish_setting','istplnotice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `istplnotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否模版通知'");}
if(!pdo_fieldexists('weisrc_dish_setting','tpltype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tpltype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '模版行业类型'");}
if(!pdo_fieldexists('weisrc_dish_setting','tplneworder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tplneworder` varchar(200) DEFAULT '' COMMENT '模板id'");}
if(!pdo_fieldexists('weisrc_dish_setting','tplnewqueue')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tplnewqueue` varchar(200) DEFAULT '' COMMENT '模板id'");}
if(!pdo_fieldexists('weisrc_dish_setting','tploperator')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tploperator` varchar(200) DEFAULT '' COMMENT '模板id'");}
if(!pdo_fieldexists('weisrc_dish_setting','tplmission')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tplmission` varchar(200) DEFAULT '' COMMENT '模板id'");}
if(!pdo_fieldexists('weisrc_dish_setting','tplcoupon')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tplcoupon` varchar(200) DEFAULT '' COMMENT '模板id'");}
if(!pdo_fieldexists('weisrc_dish_setting','fengniao_appid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `fengniao_appid` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','fengniao_key')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `fengniao_key` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','tplboss')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tplboss` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','tplapplynotice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tplapplynotice` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','link_card_name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `link_card_name` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','link_card')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `link_card` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','link_sign_name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `link_sign_name` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','link_sign')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `link_sign` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','searchword')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `searchword` varchar(1000) DEFAULT '' COMMENT '搜索关键字'");}
if(!pdo_fieldexists('weisrc_dish_setting','tpluser')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tpluser` text COMMENT '通知用户'");}
if(!pdo_fieldexists('weisrc_dish_setting','sms_enable')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `sms_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启短信提醒'");}
if(!pdo_fieldexists('weisrc_dish_setting','sms_username')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `sms_username` varchar(20) DEFAULT '' COMMENT '平台帐号'");}
if(!pdo_fieldexists('weisrc_dish_setting','sms_pwd')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `sms_pwd` varchar(20) DEFAULT '' COMMENT '平台密码'");}
if(!pdo_fieldexists('weisrc_dish_setting','sms_mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `sms_mobile` varchar(20) DEFAULT '' COMMENT '商户接收短信手机'");}
if(!pdo_fieldexists('weisrc_dish_setting','email_enable')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `email_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启邮箱提醒'");}
if(!pdo_fieldexists('weisrc_dish_setting','email_host')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `email_host` varchar(50) DEFAULT '' COMMENT '邮箱服务器'");}
if(!pdo_fieldexists('weisrc_dish_setting','email_send')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `email_send` varchar(100) DEFAULT '' COMMENT '商户发送邮件邮箱'");}
if(!pdo_fieldexists('weisrc_dish_setting','email_pwd')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `email_pwd` varchar(20) DEFAULT '' COMMENT '邮箱密码'");}
if(!pdo_fieldexists('weisrc_dish_setting','email_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `email_user` varchar(100) DEFAULT '' COMMENT '发信人名称'");}
if(!pdo_fieldexists('weisrc_dish_setting','email')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `email` varchar(100) DEFAULT '' COMMENT '平台接收邮件邮箱'");}
if(!pdo_fieldexists('weisrc_dish_setting','getcash_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `getcash_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最低提现金额'");}
if(!pdo_fieldexists('weisrc_dish_setting','fee_rate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `fee_rate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现费率'");}
if(!pdo_fieldexists('weisrc_dish_setting','one_order_getprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `one_order_getprice` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '每单提现手续费'");}
if(!pdo_fieldexists('weisrc_dish_setting','fee_min')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `fee_min` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额'");}
if(!pdo_fieldexists('weisrc_dish_setting','fee_max')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `fee_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最高金额'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_open_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_open_price` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '开启提现'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_commission')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_commission` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启分销'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission_keywords')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission_keywords` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','table_cover')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `table_cover` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','table_desc')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `table_desc` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','commission_level')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission_level` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分销级别'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分销模式'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission_money_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission_money_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '佣金模式'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission1_rate_max')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission1_rate_max` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金费率'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission1_value_max')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission1_value_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission2_rate_max')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission2_rate_max` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金费率'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission2_value_max')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission2_value_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission3_rate_max')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission3_rate_max` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金费率'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission3_value_max')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission3_value_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额'");}
if(!pdo_fieldexists('weisrc_dish_setting','commission_settlement')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `commission_settlement` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '佣金结算方式'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_verify_mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_verify_mobile` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','credit_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `credit_mode` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:商品积分;2订单金额计算'");}
if(!pdo_fieldexists('weisrc_dish_setting','fengniao_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `fengniao_mode` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:正式启用;2:调试阶段'");}
if(!pdo_fieldexists('weisrc_dish_setting','payx_credit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `payx_credit` int(10) NOT NULL DEFAULT '0' COMMENT '消费一元积分'");}
if(!pdo_fieldexists('weisrc_dish_setting','dayu_appkey')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `dayu_appkey` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','dayu_secretkey')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `dayu_secretkey` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','dayu_verify_code')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `dayu_verify_code` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','dayu_sign')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `dayu_sign` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','delivery_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `delivery_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '配送通知模式'");}
if(!pdo_fieldexists('weisrc_dish_setting','delivery_commission_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `delivery_commission_mode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '配送佣金模式'");}
if(!pdo_fieldexists('weisrc_dish_setting','delivery_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `delivery_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '佣金'");}
if(!pdo_fieldexists('weisrc_dish_setting','delivery_cash_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `delivery_cash_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现最低金额'");}
if(!pdo_fieldexists('weisrc_dish_setting','delivery_rate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `delivery_rate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '佣金费率'");}
if(!pdo_fieldexists('weisrc_dish_setting','delivery_order_max')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `delivery_order_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '配送订单数量限制'");}
if(!pdo_fieldexists('weisrc_dish_setting','delivery_auto_time')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `delivery_auto_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自动推送配送员时间设置'");}
if(!pdo_fieldexists('weisrc_dish_setting','delivery_finish_time')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `delivery_finish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自动完成已配送订单'");}
if(!pdo_fieldexists('weisrc_dish_setting','link_recharge')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `link_recharge` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','link_recharge_name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `link_recharge_name` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','wechat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `wechat` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','alipay')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `alipay` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','credit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `credit` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `delivery` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_speaker')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_speaker` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_show_virtual')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_show_virtual` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_auto_address')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_auto_address` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_show_home')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_show_home` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_operator_pwd')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_operator_pwd` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_contain_delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_contain_delivery` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_auto_commission')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_auto_commission` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','auto_commission_coin')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `auto_commission_coin` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','tiptype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tiptype` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','tipbtn')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tipbtn` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','tipqrcode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `tipqrcode` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','kefuqrcode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `kefuqrcode` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','operator_pwd')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `operator_pwd` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `apiclient_cert` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `apiclient_key` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','rootca')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `rootca` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','share_title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `share_title` varchar(200) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','share_desc')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `share_desc` varchar(300) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','share_image')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `share_image` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','follow_url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `follow_url` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','follow_title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `follow_title` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','follow_desc')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `follow_desc` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','follow_logo')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `follow_logo` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','site_logo')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `site_logo` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','isneedfollow')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `isneedfollow` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','statistics')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `statistics` text NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_setting','visit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `visit` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `dateline` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','style_base')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `style_base` varchar(20) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','style_list_btn1')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `style_list_btn1` varchar(20) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','style_list_btn2')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `style_list_btn2` varchar(20) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','style_list_btn3')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `style_list_btn3` varchar(20) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','style_list_base')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `style_list_base` varchar(20) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_setting','is_show_toutiao')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_show_toutiao` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_show_visit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_show_visit` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','auth_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `auth_mode` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_check_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_check_user` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户是否需要审核'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_school')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_school` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_quick_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_quick_money` tinyint(1) NOT NULL DEFAULT '0' COMMENT '提现周期'");}
if(!pdo_fieldexists('weisrc_dish_setting','is_yunzhong')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_setting')." ADD   `is_yunzhong` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_sms_checkcode` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(100) DEFAULT '' COMMENT '用户ID',
  `mobile` varchar(30) DEFAULT '' COMMENT '手机',
  `checkcode` varchar(100) DEFAULT '' COMMENT '验证码',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态 0未使用1已使用',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_sms_checkcode','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_checkcode')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_sms_checkcode','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_checkcode')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_sms_checkcode','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_checkcode')." ADD   `from_user` varchar(100) DEFAULT '' COMMENT '用户ID'");}
if(!pdo_fieldexists('weisrc_dish_sms_checkcode','mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_checkcode')." ADD   `mobile` varchar(30) DEFAULT '' COMMENT '手机'");}
if(!pdo_fieldexists('weisrc_dish_sms_checkcode','checkcode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_checkcode')." ADD   `checkcode` varchar(100) DEFAULT '' COMMENT '验证码'");}
if(!pdo_fieldexists('weisrc_dish_sms_checkcode','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_checkcode')." ADD   `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态 0未使用1已使用'");}
if(!pdo_fieldexists('weisrc_dish_sms_checkcode','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_checkcode')." ADD   `dateline` int(10) DEFAULT '0' COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_sms_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `sms_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启短信提醒',
  `sms_verify_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启短信验证提醒',
  `sms_username` varchar(20) DEFAULT '' COMMENT '平台帐号',
  `sms_pwd` varchar(20) DEFAULT '' COMMENT '平台密码',
  `sms_mobile` varchar(20) DEFAULT '' COMMENT '商户接收短信手机',
  `sms_verify_tpl` varchar(120) DEFAULT '' COMMENT '验证短信模板',
  `sms_business_tpl` varchar(120) DEFAULT '' COMMENT '商户短信模板',
  `sms_user_tpl` varchar(120) DEFAULT '' COMMENT '用户短信模板',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_sms_setting','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','sms_enable')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `sms_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启短信提醒'");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','sms_verify_enable')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `sms_verify_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启短信验证提醒'");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','sms_username')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `sms_username` varchar(20) DEFAULT '' COMMENT '平台帐号'");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','sms_pwd')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `sms_pwd` varchar(20) DEFAULT '' COMMENT '平台密码'");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','sms_mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `sms_mobile` varchar(20) DEFAULT '' COMMENT '商户接收短信手机'");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','sms_verify_tpl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `sms_verify_tpl` varchar(120) DEFAULT '' COMMENT '验证短信模板'");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','sms_business_tpl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `sms_business_tpl` varchar(120) DEFAULT '' COMMENT '商户短信模板'");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','sms_user_tpl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `sms_user_tpl` varchar(120) DEFAULT '' COMMENT '用户短信模板'");}
if(!pdo_fieldexists('weisrc_dish_sms_setting','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sms_setting')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_sncode` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `couponid` int(10) NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id',
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `from_user` varchar(100) NOT NULL COMMENT 'openid',
  `title` varchar(40) NOT NULL,
  `sncode` varchar(100) NOT NULL COMMENT 'sn码',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1优惠券2代金券3礼品券',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示 用户删除时更新',
  `winningtime` int(10) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `usetime` int(10) NOT NULL DEFAULT '0' COMMENT '使用时间',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_sncode','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_sncode','couponid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `couponid` int(10) NOT NULL DEFAULT '0' COMMENT '优惠券id'");}
if(!pdo_fieldexists('weisrc_dish_sncode','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `storeid` int(10) NOT NULL DEFAULT '0' COMMENT '门店id'");}
if(!pdo_fieldexists('weisrc_dish_sncode','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_sncode','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `from_user` varchar(100) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('weisrc_dish_sncode','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `title` varchar(40) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_sncode','sncode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `sncode` varchar(100) NOT NULL COMMENT 'sn码'");}
if(!pdo_fieldexists('weisrc_dish_sncode','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1优惠券2代金券3礼品券'");}
if(!pdo_fieldexists('weisrc_dish_sncode','money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额'");}
if(!pdo_fieldexists('weisrc_dish_sncode','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_sncode','isshow')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示 用户删除时更新'");}
if(!pdo_fieldexists('weisrc_dish_sncode','winningtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `winningtime` int(10) NOT NULL DEFAULT '0' COMMENT '生成时间'");}
if(!pdo_fieldexists('weisrc_dish_sncode','usetime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `usetime` int(10) NOT NULL DEFAULT '0' COMMENT '使用时间'");}
if(!pdo_fieldexists('weisrc_dish_sncode','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_sncode')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_store_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `storeid` int(10) unsigned NOT NULL,
  `order_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订餐开启',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_store_setting','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_store_setting')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_store_setting','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_store_setting')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_store_setting','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_store_setting')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_store_setting','order_enable')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_store_setting')." ADD   `order_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订餐开启'");}
if(!pdo_fieldexists('weisrc_dish_store_setting','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_store_setting')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_storecard` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `storeid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL DEFAULT '',
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `cardpre` varchar(10) NOT NULL DEFAULT '',
  `cardno` int(10) NOT NULL DEFAULT '0' COMMENT '会员卡号',
  `cardnumber` varchar(50) NOT NULL DEFAULT '',
  `headimgurl` varchar(500) NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '' COMMENT '登录密码',
  `coin` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `balance_score` int(10) NOT NULL DEFAULT '0' COMMENT '剩余积分',
  `total_score` int(10) NOT NULL DEFAULT '0' COMMENT '总积分',
  `spend_score` int(10) NOT NULL DEFAULT '0' COMMENT '消费积分',
  `sign_score` int(10) NOT NULL DEFAULT '0' COMMENT '签到积分',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总消费金额',
  `carnumber` varchar(100) NOT NULL DEFAULT '' COMMENT '车牌号码',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `updatetime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `lasttime` int(10) NOT NULL DEFAULT '0' COMMENT '到期时间',
  `dateline` int(10) NOT NULL DEFAULT '0' COMMENT '领卡时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_storecard','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_storecard','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_storecard','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `from_user` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_storecard','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_storecard','uid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id'");}
if(!pdo_fieldexists('weisrc_dish_storecard','cardpre')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `cardpre` varchar(10) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_storecard','cardno')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `cardno` int(10) NOT NULL DEFAULT '0' COMMENT '会员卡号'");}
if(!pdo_fieldexists('weisrc_dish_storecard','cardnumber')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `cardnumber` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_storecard','headimgurl')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `headimgurl` varchar(500) NOT NULL DEFAULT '' COMMENT '头像'");}
if(!pdo_fieldexists('weisrc_dish_storecard','nickname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `nickname` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_storecard','password')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `password` varchar(200) NOT NULL DEFAULT '' COMMENT '登录密码'");}
if(!pdo_fieldexists('weisrc_dish_storecard','coin')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `coin` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '余额'");}
if(!pdo_fieldexists('weisrc_dish_storecard','balance_score')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `balance_score` int(10) NOT NULL DEFAULT '0' COMMENT '剩余积分'");}
if(!pdo_fieldexists('weisrc_dish_storecard','total_score')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `total_score` int(10) NOT NULL DEFAULT '0' COMMENT '总积分'");}
if(!pdo_fieldexists('weisrc_dish_storecard','spend_score')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `spend_score` int(10) NOT NULL DEFAULT '0' COMMENT '消费积分'");}
if(!pdo_fieldexists('weisrc_dish_storecard','sign_score')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `sign_score` int(10) NOT NULL DEFAULT '0' COMMENT '签到积分'");}
if(!pdo_fieldexists('weisrc_dish_storecard','money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总消费金额'");}
if(!pdo_fieldexists('weisrc_dish_storecard','carnumber')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `carnumber` varchar(100) NOT NULL DEFAULT '' COMMENT '车牌号码'");}
if(!pdo_fieldexists('weisrc_dish_storecard','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_storecard','updatetime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `updatetime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间'");}
if(!pdo_fieldexists('weisrc_dish_storecard','lasttime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `lasttime` int(10) NOT NULL DEFAULT '0' COMMENT '到期时间'");}
if(!pdo_fieldexists('weisrc_dish_storecard','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecard')." ADD   `dateline` int(10) NOT NULL DEFAULT '0' COMMENT '领卡时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_storecardlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `storeid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL COMMENT '标题',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '业务类型-用户充值:1,消费:2',
  `operationtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '积分操作类型 增加:1  扣除:0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `remark` text NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_storecardlog','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_storecardlog','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_storecardlog','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_storecardlog','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD   `from_user` varchar(50) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_storecardlog','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD   `title` varchar(200) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('weisrc_dish_storecardlog','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD   `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '业务类型-用户充值:1,消费:2'");}
if(!pdo_fieldexists('weisrc_dish_storecardlog','operationtype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD   `operationtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '积分操作类型 增加:1  扣除:0'");}
if(!pdo_fieldexists('weisrc_dish_storecardlog','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额'");}
if(!pdo_fieldexists('weisrc_dish_storecardlog','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_storecardlog','remark')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardlog')." ADD   `remark` text NOT NULL COMMENT '备注'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_storecardprice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `storeid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '',
  `daycount` int(10) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `icon` tinyint(1) NOT NULL DEFAULT '1',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '网址',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_storecardprice','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprice')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_storecardprice','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprice')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_storecardprice','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprice')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_storecardprice','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprice')." ADD   `title` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_storecardprice','daycount')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprice')." ADD   `daycount` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_storecardprice','price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprice')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_storecardprice','icon')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprice')." ADD   `icon` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_storecardprice','url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprice')." ADD   `url` varchar(500) NOT NULL DEFAULT '' COMMENT '网址'");}
if(!pdo_fieldexists('weisrc_dish_storecardprice','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprice')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_storecardprivilege` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `storeid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '特权名称',
  `desc` varchar(100) NOT NULL DEFAULT '' COMMENT '特权名称',
  `icon` tinyint(1) NOT NULL DEFAULT '1',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '网址',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_storecardprivilege','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprivilege')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_storecardprivilege','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprivilege')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_storecardprivilege','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprivilege')." ADD   `storeid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_storecardprivilege','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprivilege')." ADD   `title` varchar(50) NOT NULL DEFAULT '' COMMENT '特权名称'");}
if(!pdo_fieldexists('weisrc_dish_storecardprivilege','desc')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprivilege')." ADD   `desc` varchar(100) NOT NULL DEFAULT '' COMMENT '特权名称'");}
if(!pdo_fieldexists('weisrc_dish_storecardprivilege','icon')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprivilege')." ADD   `icon` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_storecardprivilege','url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprivilege')." ADD   `url` varchar(500) NOT NULL DEFAULT '' COMMENT '网址'");}
if(!pdo_fieldexists('weisrc_dish_storecardprivilege','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_storecardprivilege')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_stores` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `from_user` varchar(200) NOT NULL DEFAULT '',
  `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `typeid` int(10) NOT NULL DEFAULT '0' COMMENT '商家类型',
  `default_jump` tinyint(2) NOT NULL DEFAULT '1' COMMENT '默认类型',
  `default_jump_url` varchar(500) NOT NULL DEFAULT '' COMMENT '默认链接',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `logo` varchar(500) NOT NULL DEFAULT '' COMMENT '商家logo',
  `info` varchar(1000) NOT NULL DEFAULT '' COMMENT '简短描述',
  `content` text NOT NULL COMMENT '简介',
  `thumbs` text NOT NULL,
  `announce` varchar(1000) NOT NULL DEFAULT '' COMMENT '公告通知',
  `listinfo` varchar(1000) NOT NULL DEFAULT '用餐高峰期请提前下单！',
  `reservation_announce` varchar(1000) NOT NULL DEFAULT '' COMMENT '预定公告',
  `remarkinfo` varchar(1000) DEFAULT '可输入口味偏好要求(选填)',
  `tel` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `address` varchar(200) DEFAULT '' COMMENT '地址',
  `qq` varchar(20) DEFAULT '',
  `weixin` varchar(20) DEFAULT '',
  `place` varchar(200) NOT NULL DEFAULT '',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `password` varchar(20) NOT NULL DEFAULT '' COMMENT '登录密码',
  `hours` varchar(200) NOT NULL DEFAULT '' COMMENT '营业时间',
  `recharging_password` varchar(20) NOT NULL DEFAULT '' COMMENT '充值密码',
  `thumb_url` varchar(1000) DEFAULT NULL,
  `enable_wifi` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有wifi',
  `enable_card` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否能刷卡',
  `enable_room` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有包厢',
  `enable_park` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有停车',
  `is_locktables` tinyint(1) NOT NULL DEFAULT '0',
  `is_dispatcharea` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送区域',
  `is_brand` tinyint(1) NOT NULL DEFAULT '0' COMMENT '品牌商家',
  `is_meal_pay_confirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '店内点餐在线支付是否需要确认',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '搜索页显示',
  `is_rest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否休息中',
  `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在手机端显示',
  `is_list` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否在列表显示',
  `is_sms` tinyint(1) NOT NULL DEFAULT '0',
  `is_hour` tinyint(1) NOT NULL DEFAULT '0',
  `is_add_dish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否加菜',
  `is_newlimitprice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '新顾客满减',
  `is_oldlimitprice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '老顾客满减',
  `is_add_order` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否加单',
  `is_meal` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否店内点餐',
  `is_delivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否外卖订餐',
  `is_snack` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持快餐',
  `is_reservation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持预定',
  `is_queue` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持排队',
  `is_intelligent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持套餐',
  `is_savewine` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持寄存',
  `is_shouyin` tinyint(1) NOT NULL DEFAULT '0',
  `is_fengniao` tinyint(1) NOT NULL DEFAULT '0',
  `is_operator1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持呼叫服务员',
  `is_operator2` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持打包',
  `is_business` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持子商户支付',
  `business_id` int(10) NOT NULL DEFAULT '0' COMMENT '子商户活动ID',
  `is_bank_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持银行支付',
  `is_delivery_distance` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持配送距离',
  `is_delivery_time` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否特殊时间价格',
  `is_jxkj_unipay` int(1) DEFAULT '0',
  `jxkj_pay_id` int(10) DEFAULT '0',
  `jxkj_pay_name` varchar(50) NOT NULL DEFAULT '万融收银',
  `bank_pay_id` int(10) NOT NULL DEFAULT '0' COMMENT '银行活动ID',
  `is_default_givecredit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '默认1,自定义2',
  `givecredit` int(10) NOT NULL DEFAULT '0',
  `is_vtiny_bankpay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持银行支付',
  `vtiny_bankpay_id` int(10) NOT NULL DEFAULT '0' COMMENT '银行活动ID',
  `vtiny_bankpay_url` varchar(500) NOT NULL DEFAULT '' COMMENT '链接',
  `is_auto_confirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自动确认订单',
  `is_order_autoconfirm` tinyint(1) NOT NULL DEFAULT '0',
  `notice_space_time` int(10) DEFAULT '300',
  `coupon_title1` varchar(100) NOT NULL DEFAULT '' COMMENT '优惠名称',
  `coupon_link1` varchar(200) NOT NULL DEFAULT '' COMMENT '优惠链接',
  `coupon_title2` varchar(100) NOT NULL DEFAULT '' COMMENT '优惠名称',
  `coupon_link2` varchar(200) NOT NULL DEFAULT '' COMMENT '优惠链接',
  `coupon_title3` varchar(100) NOT NULL DEFAULT '' COMMENT '优惠名称',
  `coupon_link3` varchar(200) NOT NULL DEFAULT '' COMMENT '优惠链接',
  `btn_reservation` varchar(100) NOT NULL DEFAULT '预定' COMMENT '预定按钮',
  `btn_eat` varchar(100) NOT NULL DEFAULT '点菜' COMMENT '点菜按钮',
  `btn_delivery` varchar(100) NOT NULL DEFAULT '外卖' COMMENT '外卖按钮',
  `btn_snack` varchar(100) NOT NULL DEFAULT '快餐' COMMENT '快餐按钮',
  `btn_queue` varchar(100) NOT NULL DEFAULT '排队' COMMENT '排队按钮',
  `btn_intelligent` varchar(100) NOT NULL DEFAULT '套餐' COMMENT '套餐按钮',
  `btn_shouyin` varchar(100) NOT NULL DEFAULT '收银',
  `is_reservation_dish` tinyint(1) NOT NULL DEFAULT '1',
  `reservation_days` int(10) NOT NULL DEFAULT '7' COMMENT '预订天数',
  `kefu_qrcode` varchar(500) NOT NULL DEFAULT '',
  `begintime` varchar(20) DEFAULT '09:00' COMMENT '开始时间',
  `endtime` varchar(20) DEFAULT '18:00' COMMENT '结束时间',
  `begintime1` varchar(20) DEFAULT '09:00' COMMENT '开始时间',
  `endtime1` varchar(20) DEFAULT '18:00' COMMENT '结束时间',
  `begintime2` varchar(20) DEFAULT '09:00' COMMENT '开始时间',
  `endtime2` varchar(20) DEFAULT '18:00' COMMENT '结束时间',
  `delivery_isnot_today` tinyint(1) NOT NULL DEFAULT '0',
  `delivery_within_days` int(10) NOT NULL DEFAULT '0' COMMENT '允许提前几天点外卖',
  `delivery_radius` decimal(18,1) NOT NULL DEFAULT '0.0' COMMENT '半径',
  `not_in_delivery_radius` tinyint(1) NOT NULL DEFAULT '1' COMMENT '在配送半径之外是否允许下单',
  `sendingprice` varchar(10) NOT NULL DEFAULT '' COMMENT '起送价格',
  `dispatchprice` decimal(10,2) DEFAULT '0.00',
  `freeprice` decimal(10,2) DEFAULT '0.00',
  `consume` varchar(20) NOT NULL COMMENT '人均消费',
  `wechat` tinyint(1) NOT NULL DEFAULT '1',
  `alipay` tinyint(1) NOT NULL DEFAULT '1',
  `credit` tinyint(1) NOT NULL DEFAULT '1',
  `is_speaker` tinyint(1) NOT NULL DEFAULT '1',
  `delivery` tinyint(1) NOT NULL DEFAULT '1',
  `is_reservation_today` tinyint(1) NOT NULL DEFAULT '1',
  `reservation_tip` varchar(200) NOT NULL DEFAULT '请输入备注，人数口味等等（可不填）',
  `reservation_wechat` tinyint(1) NOT NULL DEFAULT '1',
  `reservation_alipay` tinyint(1) NOT NULL DEFAULT '1',
  `reservation_credit` tinyint(1) NOT NULL DEFAULT '1',
  `reservation_delivery` tinyint(1) NOT NULL DEFAULT '1',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `screen_mode` tinyint(1) NOT NULL DEFAULT '1',
  `screen_title` varchar(200) NOT NULL DEFAULT '',
  `screen_bg` varchar(500) NOT NULL DEFAULT '',
  `screen_bottom` varchar(200) NOT NULL DEFAULT '',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `updatetime` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `business_type` tinyint(1) NOT NULL DEFAULT '0',
  `business_mobile` varchar(30) NOT NULL DEFAULT '',
  `business_openid` varchar(200) NOT NULL DEFAULT '',
  `business_username` varchar(200) NOT NULL DEFAULT '',
  `business_alipay` varchar(200) NOT NULL DEFAULT '',
  `business_wechat` varchar(200) NOT NULL DEFAULT '',
  `is_ld_wxserver` tinyint(1) DEFAULT NULL,
  `ld_wxserver_url` varchar(255) DEFAULT NULL,
  `is_default_rate` tinyint(1) NOT NULL DEFAULT '1' COMMENT '默认1,自定义2',
  `getcash_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最低提现金额',
  `fee_rate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现费率',
  `fee_min` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额',
  `fee_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最高金额',
  `is_tea_money` tinyint(1) NOT NULL DEFAULT '0',
  `tea_money` decimal(10,2) DEFAULT '0.00',
  `tea_tip` varchar(200) NOT NULL DEFAULT '',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_delivery_nowtime` tinyint(1) NOT NULL DEFAULT '1',
  `is_jueqi_ymf` tinyint(1) NOT NULL DEFAULT '0',
  `jueqi_host` varchar(200) NOT NULL DEFAULT '',
  `jueqi_customerId` varchar(200) NOT NULL DEFAULT '',
  `jueqi_secret` varchar(200) NOT NULL DEFAULT '',
  `is_order_tip` tinyint(1) NOT NULL DEFAULT '0',
  `default_user_count` int(10) unsigned NOT NULL DEFAULT '5' COMMENT '默认的用餐人数',
  `btn_coupon_type` tinyint(1) NOT NULL DEFAULT '0',
  `btn_coupon_url` varchar(500) NOT NULL DEFAULT '',
  `btn_coupon_id` int(10) unsigned NOT NULL DEFAULT '0',
  `btn_coupon_price` varchar(50) NOT NULL DEFAULT '15元',
  `btn_coupon_title` varchar(50) NOT NULL DEFAULT '商家优惠券',
  `btn_coupon_desc` varchar(50) NOT NULL DEFAULT '消费满100元可用',
  `is_check_user` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否用户审核',
  `is_fengniao_area` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用蜂鸟配送区域',
  `is_sys_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '平台配送',
  `is_floor_money` tinyint(1) NOT NULL DEFAULT '0',
  `floor_money` decimal(10,2) DEFAULT '0.00',
  `floor_tip` varchar(200) NOT NULL DEFAULT '',
  `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id',
  `brandname` varchar(20) DEFAULT '品牌',
  `is_delivery_mode1` tinyint(1) NOT NULL DEFAULT '1',
  `is_delivery_mode2` tinyint(1) NOT NULL DEFAULT '1',
  `is_more_meal` tinyint(1) NOT NULL DEFAULT '1',
  `card_title` varchar(50) DEFAULT '',
  `card_rule` text NOT NULL,
  `is_card` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_stores','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_stores','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_stores','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `from_user` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','areaid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id'");}
if(!pdo_fieldexists('weisrc_dish_stores','typeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `typeid` int(10) NOT NULL DEFAULT '0' COMMENT '商家类型'");}
if(!pdo_fieldexists('weisrc_dish_stores','default_jump')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `default_jump` tinyint(2) NOT NULL DEFAULT '1' COMMENT '默认类型'");}
if(!pdo_fieldexists('weisrc_dish_stores','default_jump_url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `default_jump_url` varchar(500) NOT NULL DEFAULT '' COMMENT '默认链接'");}
if(!pdo_fieldexists('weisrc_dish_stores','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `title` varchar(50) NOT NULL DEFAULT '' COMMENT '名称'");}
if(!pdo_fieldexists('weisrc_dish_stores','logo')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `logo` varchar(500) NOT NULL DEFAULT '' COMMENT '商家logo'");}
if(!pdo_fieldexists('weisrc_dish_stores','info')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `info` varchar(1000) NOT NULL DEFAULT '' COMMENT '简短描述'");}
if(!pdo_fieldexists('weisrc_dish_stores','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `content` text NOT NULL COMMENT '简介'");}
if(!pdo_fieldexists('weisrc_dish_stores','thumbs')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `thumbs` text NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_stores','announce')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `announce` varchar(1000) NOT NULL DEFAULT '' COMMENT '公告通知'");}
if(!pdo_fieldexists('weisrc_dish_stores','listinfo')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `listinfo` varchar(1000) NOT NULL DEFAULT '用餐高峰期请提前下单！'");}
if(!pdo_fieldexists('weisrc_dish_stores','reservation_announce')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `reservation_announce` varchar(1000) NOT NULL DEFAULT '' COMMENT '预定公告'");}
if(!pdo_fieldexists('weisrc_dish_stores','remarkinfo')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `remarkinfo` varchar(1000) DEFAULT '可输入口味偏好要求(选填)'");}
if(!pdo_fieldexists('weisrc_dish_stores','tel')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `tel` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话'");}
if(!pdo_fieldexists('weisrc_dish_stores','address')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `address` varchar(200) DEFAULT '' COMMENT '地址'");}
if(!pdo_fieldexists('weisrc_dish_stores','qq')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `qq` varchar(20) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','weixin')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `weixin` varchar(20) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','place')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `place` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','lat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('weisrc_dish_stores','lng')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
if(!pdo_fieldexists('weisrc_dish_stores','password')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `password` varchar(20) NOT NULL DEFAULT '' COMMENT '登录密码'");}
if(!pdo_fieldexists('weisrc_dish_stores','hours')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `hours` varchar(200) NOT NULL DEFAULT '' COMMENT '营业时间'");}
if(!pdo_fieldexists('weisrc_dish_stores','recharging_password')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `recharging_password` varchar(20) NOT NULL DEFAULT '' COMMENT '充值密码'");}
if(!pdo_fieldexists('weisrc_dish_stores','thumb_url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `thumb_url` varchar(1000) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_stores','enable_wifi')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `enable_wifi` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有wifi'");}
if(!pdo_fieldexists('weisrc_dish_stores','enable_card')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `enable_card` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否能刷卡'");}
if(!pdo_fieldexists('weisrc_dish_stores','enable_room')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `enable_room` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有包厢'");}
if(!pdo_fieldexists('weisrc_dish_stores','enable_park')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `enable_park` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有停车'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_locktables')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_locktables` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_dispatcharea')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_dispatcharea` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送区域'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_brand')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_brand` tinyint(1) NOT NULL DEFAULT '0' COMMENT '品牌商家'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_meal_pay_confirm')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_meal_pay_confirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '店内点餐在线支付是否需要确认'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_hot')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '搜索页显示'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_rest')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_rest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否休息中'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_show')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在手机端显示'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_list')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_list` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否在列表显示'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_sms')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_sms` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_hour')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_hour` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_add_dish')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_add_dish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否加菜'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_newlimitprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_newlimitprice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '新顾客满减'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_oldlimitprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_oldlimitprice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '老顾客满减'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_add_order')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_add_order` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否加单'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_meal')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_meal` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否店内点餐'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_delivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否外卖订餐'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_snack')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_snack` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持快餐'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_reservation')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_reservation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持预定'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_queue')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_queue` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持排队'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_intelligent')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_intelligent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持套餐'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_savewine')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_savewine` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持寄存'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_shouyin')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_shouyin` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_fengniao')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_fengniao` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_operator1')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_operator1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持呼叫服务员'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_operator2')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_operator2` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持打包'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_business')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_business` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持子商户支付'");}
if(!pdo_fieldexists('weisrc_dish_stores','business_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `business_id` int(10) NOT NULL DEFAULT '0' COMMENT '子商户活动ID'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_bank_pay')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_bank_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持银行支付'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_delivery_distance')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_delivery_distance` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持配送距离'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_delivery_time')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_delivery_time` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否特殊时间价格'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_jxkj_unipay')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_jxkj_unipay` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','jxkj_pay_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `jxkj_pay_id` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','jxkj_pay_name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `jxkj_pay_name` varchar(50) NOT NULL DEFAULT '万融收银'");}
if(!pdo_fieldexists('weisrc_dish_stores','bank_pay_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `bank_pay_id` int(10) NOT NULL DEFAULT '0' COMMENT '银行活动ID'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_default_givecredit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_default_givecredit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '默认1,自定义2'");}
if(!pdo_fieldexists('weisrc_dish_stores','givecredit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `givecredit` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_vtiny_bankpay')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_vtiny_bankpay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持银行支付'");}
if(!pdo_fieldexists('weisrc_dish_stores','vtiny_bankpay_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `vtiny_bankpay_id` int(10) NOT NULL DEFAULT '0' COMMENT '银行活动ID'");}
if(!pdo_fieldexists('weisrc_dish_stores','vtiny_bankpay_url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `vtiny_bankpay_url` varchar(500) NOT NULL DEFAULT '' COMMENT '链接'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_auto_confirm')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_auto_confirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自动确认订单'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_order_autoconfirm')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_order_autoconfirm` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','notice_space_time')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `notice_space_time` int(10) DEFAULT '300'");}
if(!pdo_fieldexists('weisrc_dish_stores','coupon_title1')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `coupon_title1` varchar(100) NOT NULL DEFAULT '' COMMENT '优惠名称'");}
if(!pdo_fieldexists('weisrc_dish_stores','coupon_link1')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `coupon_link1` varchar(200) NOT NULL DEFAULT '' COMMENT '优惠链接'");}
if(!pdo_fieldexists('weisrc_dish_stores','coupon_title2')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `coupon_title2` varchar(100) NOT NULL DEFAULT '' COMMENT '优惠名称'");}
if(!pdo_fieldexists('weisrc_dish_stores','coupon_link2')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `coupon_link2` varchar(200) NOT NULL DEFAULT '' COMMENT '优惠链接'");}
if(!pdo_fieldexists('weisrc_dish_stores','coupon_title3')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `coupon_title3` varchar(100) NOT NULL DEFAULT '' COMMENT '优惠名称'");}
if(!pdo_fieldexists('weisrc_dish_stores','coupon_link3')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `coupon_link3` varchar(200) NOT NULL DEFAULT '' COMMENT '优惠链接'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_reservation')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_reservation` varchar(100) NOT NULL DEFAULT '预定' COMMENT '预定按钮'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_eat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_eat` varchar(100) NOT NULL DEFAULT '点菜' COMMENT '点菜按钮'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_delivery` varchar(100) NOT NULL DEFAULT '外卖' COMMENT '外卖按钮'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_snack')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_snack` varchar(100) NOT NULL DEFAULT '快餐' COMMENT '快餐按钮'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_queue')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_queue` varchar(100) NOT NULL DEFAULT '排队' COMMENT '排队按钮'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_intelligent')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_intelligent` varchar(100) NOT NULL DEFAULT '套餐' COMMENT '套餐按钮'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_shouyin')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_shouyin` varchar(100) NOT NULL DEFAULT '收银'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_reservation_dish')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_reservation_dish` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','reservation_days')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `reservation_days` int(10) NOT NULL DEFAULT '7' COMMENT '预订天数'");}
if(!pdo_fieldexists('weisrc_dish_stores','kefu_qrcode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `kefu_qrcode` varchar(500) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','begintime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `begintime` varchar(20) DEFAULT '09:00' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_stores','endtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `endtime` varchar(20) DEFAULT '18:00' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_stores','begintime1')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `begintime1` varchar(20) DEFAULT '09:00' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_stores','endtime1')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `endtime1` varchar(20) DEFAULT '18:00' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_stores','begintime2')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `begintime2` varchar(20) DEFAULT '09:00' COMMENT '开始时间'");}
if(!pdo_fieldexists('weisrc_dish_stores','endtime2')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `endtime2` varchar(20) DEFAULT '18:00' COMMENT '结束时间'");}
if(!pdo_fieldexists('weisrc_dish_stores','delivery_isnot_today')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `delivery_isnot_today` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','delivery_within_days')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `delivery_within_days` int(10) NOT NULL DEFAULT '0' COMMENT '允许提前几天点外卖'");}
if(!pdo_fieldexists('weisrc_dish_stores','delivery_radius')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `delivery_radius` decimal(18,1) NOT NULL DEFAULT '0.0' COMMENT '半径'");}
if(!pdo_fieldexists('weisrc_dish_stores','not_in_delivery_radius')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `not_in_delivery_radius` tinyint(1) NOT NULL DEFAULT '1' COMMENT '在配送半径之外是否允许下单'");}
if(!pdo_fieldexists('weisrc_dish_stores','sendingprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `sendingprice` varchar(10) NOT NULL DEFAULT '' COMMENT '起送价格'");}
if(!pdo_fieldexists('weisrc_dish_stores','dispatchprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `dispatchprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_stores','freeprice')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `freeprice` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_stores','consume')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `consume` varchar(20) NOT NULL COMMENT '人均消费'");}
if(!pdo_fieldexists('weisrc_dish_stores','wechat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `wechat` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','alipay')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `alipay` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','credit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `credit` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_speaker')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_speaker` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `delivery` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_reservation_today')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_reservation_today` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','reservation_tip')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `reservation_tip` varchar(200) NOT NULL DEFAULT '请输入备注，人数口味等等（可不填）'");}
if(!pdo_fieldexists('weisrc_dish_stores','reservation_wechat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `reservation_wechat` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','reservation_alipay')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `reservation_alipay` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','reservation_credit')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `reservation_credit` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','reservation_delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `reservation_delivery` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','level')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别'");}
if(!pdo_fieldexists('weisrc_dish_stores','screen_mode')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `screen_mode` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','screen_title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `screen_title` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','screen_bg')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `screen_bg` varchar(500) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','screen_bottom')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `screen_bottom` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `displayorder` tinyint(3) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','updatetime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `updatetime` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','business_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `business_type` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','business_mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `business_mobile` varchar(30) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','business_openid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `business_openid` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','business_username')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `business_username` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','business_alipay')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `business_alipay` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','business_wechat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `business_wechat` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','is_ld_wxserver')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_ld_wxserver` tinyint(1) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_stores','ld_wxserver_url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `ld_wxserver_url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('weisrc_dish_stores','is_default_rate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_default_rate` tinyint(1) NOT NULL DEFAULT '1' COMMENT '默认1,自定义2'");}
if(!pdo_fieldexists('weisrc_dish_stores','getcash_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `getcash_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最低提现金额'");}
if(!pdo_fieldexists('weisrc_dish_stores','fee_rate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `fee_rate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现费率'");}
if(!pdo_fieldexists('weisrc_dish_stores','fee_min')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `fee_min` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最低金额'");}
if(!pdo_fieldexists('weisrc_dish_stores','fee_max')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `fee_max` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现手续费最高金额'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_tea_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_tea_money` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','tea_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `tea_money` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_stores','tea_tip')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `tea_tip` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','deleted')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_delivery_nowtime')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_delivery_nowtime` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_jueqi_ymf')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_jueqi_ymf` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','jueqi_host')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `jueqi_host` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','jueqi_customerId')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `jueqi_customerId` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','jueqi_secret')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `jueqi_secret` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','is_order_tip')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_order_tip` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','default_user_count')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `default_user_count` int(10) unsigned NOT NULL DEFAULT '5' COMMENT '默认的用餐人数'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_coupon_type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_coupon_type` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_coupon_url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_coupon_url` varchar(500) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_coupon_id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_coupon_id` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_coupon_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_coupon_price` varchar(50) NOT NULL DEFAULT '15元'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_coupon_title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_coupon_title` varchar(50) NOT NULL DEFAULT '商家优惠券'");}
if(!pdo_fieldexists('weisrc_dish_stores','btn_coupon_desc')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `btn_coupon_desc` varchar(50) NOT NULL DEFAULT '消费满100元可用'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_check_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_check_user` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否用户审核'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_fengniao_area')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_fengniao_area` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用蜂鸟配送区域'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_sys_delivery')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_sys_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '平台配送'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_floor_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_floor_money` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_stores','floor_money')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `floor_money` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_stores','floor_tip')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `floor_tip` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','schoolid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id'");}
if(!pdo_fieldexists('weisrc_dish_stores','brandname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `brandname` varchar(20) DEFAULT '品牌'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_delivery_mode1')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_delivery_mode1` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_delivery_mode2')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_delivery_mode2` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','is_more_meal')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_more_meal` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_stores','card_title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `card_title` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_stores','card_rule')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `card_rule` text NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_stores','is_card')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_stores')." ADD   `is_card` tinyint(1) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_style` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `title` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `slidetype` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_style','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_style')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_style','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_style')." ADD   `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('weisrc_dish_style','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_style')." ADD   `title` varchar(100) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_style','type')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_style')." ADD   `type` varchar(100) NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_style','slidetype')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_style')." ADD   `slidetype` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_style','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_style')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_style','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_style')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_style','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_style')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `print_label` int(4) NOT NULL DEFAULT '0',
  `tablezonesid` int(10) unsigned NOT NULL DEFAULT '0',
  `scene_str` varchar(500) DEFAULT '',
  `thumb` varchar(500) NOT NULL DEFAULT '' COMMENT '图片',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '名字(桌台号)',
  `url` varchar(500) NOT NULL DEFAULT '',
  `user_count` int(10) NOT NULL DEFAULT '0' COMMENT '可供就餐人数',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_tables','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_tables','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_tables','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tables','print_label')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `print_label` int(4) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tables','tablezonesid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `tablezonesid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tables','scene_str')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `scene_str` varchar(500) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_tables','thumb')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `thumb` varchar(500) NOT NULL DEFAULT '' COMMENT '图片'");}
if(!pdo_fieldexists('weisrc_dish_tables','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `title` varchar(200) NOT NULL DEFAULT '' COMMENT '名字(桌台号)'");}
if(!pdo_fieldexists('weisrc_dish_tables','url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `url` varchar(500) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_tables','user_count')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `user_count` int(10) NOT NULL DEFAULT '0' COMMENT '可供就餐人数'");}
if(!pdo_fieldexists('weisrc_dish_tables','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_tables','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tables','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_tables_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `tablesid` int(10) unsigned NOT NULL DEFAULT '0',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `from_user` varchar(200) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_tables_order','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables_order')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_tables_order','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables_order')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_tables_order','tablesid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables_order')." ADD   `tablesid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tables_order','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables_order')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tables_order','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables_order')." ADD   `from_user` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_tables_order','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tables_order')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_tablezones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `limit_price` int(10) unsigned NOT NULL DEFAULT '0',
  `reservation_price` int(10) unsigned NOT NULL DEFAULT '0',
  `table_count` int(10) NOT NULL DEFAULT '0' COMMENT '餐桌数量',
  `service_rate` decimal(10,2) DEFAULT '0.00',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_tablezones','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_tablezones','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_tablezones','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tablezones','title')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `title` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_tablezones','limit_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `limit_price` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tablezones','reservation_price')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `reservation_price` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tablezones','table_count')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `table_count` int(10) NOT NULL DEFAULT '0' COMMENT '餐桌数量'");}
if(!pdo_fieldexists('weisrc_dish_tablezones','service_rate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `service_rate` decimal(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('weisrc_dish_tablezones','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_tablezones','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tablezones','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tablezones')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL DEFAULT '0',
  `template_name` varchar(50) NOT NULL DEFAULT 'style1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_template','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_template')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_template','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_template')." ADD   `weid` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_template','template_name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_template')." ADD   `template_name` varchar(50) NOT NULL DEFAULT 'style1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_tpl_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned DEFAULT '0',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号',
  `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `ordersn` varchar(100) DEFAULT '',
  `from_user` varchar(100) DEFAULT '' COMMENT '接收者openid',
  `content` varchar(1000) DEFAULT '' COMMENT '内容',
  `result` varchar(200) DEFAULT '' COMMENT '内容结果',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_tpl_log','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tpl_log')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_tpl_log','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tpl_log')." ADD   `weid` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_tpl_log','storeid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tpl_log')." ADD   `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店编号'");}
if(!pdo_fieldexists('weisrc_dish_tpl_log','orderid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tpl_log')." ADD   `orderid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号'");}
if(!pdo_fieldexists('weisrc_dish_tpl_log','ordersn')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tpl_log')." ADD   `ordersn` varchar(100) DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_tpl_log','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tpl_log')." ADD   `from_user` varchar(100) DEFAULT '' COMMENT '接收者openid'");}
if(!pdo_fieldexists('weisrc_dish_tpl_log','content')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tpl_log')." ADD   `content` varchar(1000) DEFAULT '' COMMENT '内容'");}
if(!pdo_fieldexists('weisrc_dish_tpl_log','result')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tpl_log')." ADD   `result` varchar(200) DEFAULT '' COMMENT '内容结果'");}
if(!pdo_fieldexists('weisrc_dish_tpl_log','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_tpl_log')." ADD   `dateline` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '类型名称',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '链接',
  `thumb` varchar(500) NOT NULL DEFAULT '' COMMENT '图片',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_type','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_type','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('weisrc_dish_type','name')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD   `name` varchar(50) NOT NULL COMMENT '类型名称'");}
if(!pdo_fieldexists('weisrc_dish_type','url')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD   `url` varchar(200) NOT NULL DEFAULT '' COMMENT '链接'");}
if(!pdo_fieldexists('weisrc_dish_type','thumb')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD   `thumb` varchar(500) NOT NULL DEFAULT '' COMMENT '图片'");}
if(!pdo_fieldexists('weisrc_dish_type','parentid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD   `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级'");}
if(!pdo_fieldexists('weisrc_dish_type','displayorder')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('weisrc_dish_type','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_type','status')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('weisrc_dish_type','schoolid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_type')." ADD   `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '学校id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_weisrc_dish_useraddress` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL DEFAULT '',
  `realname` varchar(20) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `address` varchar(300) NOT NULL DEFAULT '',
  `doorplate` varchar(300) NOT NULL DEFAULT '',
  `gender` tinyint(1) NOT NULL DEFAULT '1',
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('weisrc_dish_useraddress','id')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('weisrc_dish_useraddress','weid')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('weisrc_dish_useraddress','from_user')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `from_user` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_useraddress','realname')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `realname` varchar(20) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_useraddress','mobile')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `mobile` varchar(20) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_useraddress','address')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `address` varchar(300) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_useraddress','doorplate')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `doorplate` varchar(300) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('weisrc_dish_useraddress','gender')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `gender` tinyint(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('weisrc_dish_useraddress','isdefault')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `isdefault` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('weisrc_dish_useraddress','lat')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('weisrc_dish_useraddress','lng')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
if(!pdo_fieldexists('weisrc_dish_useraddress','dateline')) {pdo_query("ALTER TABLE ".tablename('weisrc_dish_useraddress')." ADD   `dateline` int(10) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yz_weisrc_dish_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `buyer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recommend_id` int(11) DEFAULT NULL,
  `recommend_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_sn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `goods_price` decimal(8,2) DEFAULT NULL,
  `goods_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

");

if(!pdo_fieldexists('yz_weisrc_dish_order','id')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yz_weisrc_dish_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `uniacid` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yz_weisrc_dish_order','order_id')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','uid')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','buyer_name')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `buyer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','recommend_id')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `recommend_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','recommend_name')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `recommend_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','order_sn')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `order_sn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','price')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `price` decimal(8,2) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','goods_price')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `goods_price` decimal(8,2) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','goods_total')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `goods_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','status')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','order_type')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `order_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','shipping_address')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','store_address')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `store_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','created_at')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_order','updated_at')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_order')." ADD   `updated_at` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yz_weisrc_dish_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL,
  `is_open` int(11) DEFAULT NULL,
  `settlememt_day` int(11) DEFAULT NULL,
  `plugins` text COLLATE utf8mb4_unicode_ci,
  `member_award_point` text COLLATE utf8mb4_unicode_ci,
  `profit` text COLLATE utf8mb4_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

");

if(!pdo_fieldexists('yz_weisrc_dish_setting','id')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yz_weisrc_dish_setting','goods_id')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD   `goods_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_setting','is_open')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD   `is_open` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_setting','settlememt_day')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD   `settlememt_day` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_setting','plugins')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD   `plugins` text COLLATE utf8mb4_unicode_ci");}
if(!pdo_fieldexists('yz_weisrc_dish_setting','member_award_point')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD   `member_award_point` text COLLATE utf8mb4_unicode_ci");}
if(!pdo_fieldexists('yz_weisrc_dish_setting','profit')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD   `profit` text COLLATE utf8mb4_unicode_ci");}
if(!pdo_fieldexists('yz_weisrc_dish_setting','created_at')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_setting','updated_at')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD   `updated_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yz_weisrc_dish_setting','uniacid')) {pdo_query("ALTER TABLE ".tablename('yz_weisrc_dish_setting')." ADD   `uniacid` int(11) NOT NULL DEFAULT '0'");}
