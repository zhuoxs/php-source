<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_account` (
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
  `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `cityname` varchar(50) NOT NULL COMMENT '城市名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_account','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_account','weid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('ymmf_sun_account','storeid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `storeid` varchar(1000) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_account','uid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `uid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ymmf_sun_account','from_user')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `from_user` varchar(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ymmf_sun_account','accountname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `accountname` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ymmf_sun_account','password')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `password` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ymmf_sun_account','salt')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `salt` varchar(10) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ymmf_sun_account','pwd')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `pwd` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_account','mobile')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `mobile` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_account','email')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `email` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_account','username')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `username` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_account','pay_account')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `pay_account` varchar(200) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_account','displayorder')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_account','dateline')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ymmf_sun_account','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态'");}
if(!pdo_fieldexists('ymmf_sun_account','role')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `role` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:店长,2:店员'");}
if(!pdo_fieldexists('ymmf_sun_account','lastvisit')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `lastvisit` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ymmf_sun_account','lastip')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `lastip` varchar(15) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_account','areaid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id'");}
if(!pdo_fieldexists('ymmf_sun_account','is_admin_order')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ymmf_sun_account','is_notice_order')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ymmf_sun_account','is_notice_queue')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ymmf_sun_account','is_notice_service')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ymmf_sun_account','is_notice_boss')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `is_notice_boss` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ymmf_sun_account','remark')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注'");}
if(!pdo_fieldexists('ymmf_sun_account','lat')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('ymmf_sun_account','lng')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
if(!pdo_fieldexists('ymmf_sun_account','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_account')." ADD   `cityname` varchar(50) NOT NULL COMMENT '城市名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '轮播图标题',
  `logo` varchar(200) NOT NULL COMMENT '图片',
  `status` int(11) NOT NULL COMMENT '1.开启  2.关闭',
  `src` varchar(100) NOT NULL COMMENT '链接',
  `orderby` int(11) NOT NULL COMMENT '排序',
  `xcx_name` varchar(20) NOT NULL,
  `appid` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `type` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `wb_src` varchar(300) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_ad','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_ad','title')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `title` varchar(50) NOT NULL COMMENT '轮播图标题'");}
if(!pdo_fieldexists('ymmf_sun_ad','logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `logo` varchar(200) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('ymmf_sun_ad','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `status` int(11) NOT NULL COMMENT '1.开启  2.关闭'");}
if(!pdo_fieldexists('ymmf_sun_ad','src')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `src` varchar(100) NOT NULL COMMENT '链接'");}
if(!pdo_fieldexists('ymmf_sun_ad','orderby')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `orderby` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_ad','xcx_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `xcx_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_ad','appid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `appid` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_ad','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ymmf_sun_ad','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `type` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_ad','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_ad','wb_src')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `wb_src` varchar(300) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_ad','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_ad')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_adminstore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `store_name` varchar(45) DEFAULT NULL COMMENT '店长名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_adminstore','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_adminstore')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_adminstore','account')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_adminstore')." ADD   `account` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_adminstore','password')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_adminstore')." ADD   `password` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_adminstore','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_adminstore')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_adminstore','build_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_adminstore')." ADD   `build_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_adminstore','mobile')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_adminstore')." ADD   `mobile` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_adminstore','store_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_adminstore')." ADD   `store_name` varchar(45) DEFAULT NULL COMMENT '店长名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_appionorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `user_id` varchar(120) NOT NULL,
  `money` varchar(80) NOT NULL,
  `tel` varchar(80) NOT NULL,
  `good_num` int(11) NOT NULL,
  `appiontime` text NOT NULL,
  `hair_id` int(11) NOT NULL,
  `remark` text,
  `pname` varchar(255) NOT NULL,
  `user_name` varchar(120) NOT NULL,
  `isdefault` int(11) NOT NULL COMMENT '是否完成订单',
  `addtime` datetime NOT NULL,
  `number` varchar(45) DEFAULT NULL COMMENT '订单号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk;

");

if(!pdo_fieldexists('ymmf_sun_appionorder','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_appionorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `user_id` varchar(120) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `money` varchar(80) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `tel` varchar(80) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','good_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `good_num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','appiontime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `appiontime` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','hair_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `hair_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','remark')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `remark` text");}
if(!pdo_fieldexists('ymmf_sun_appionorder','pname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `pname` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','user_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `user_name` varchar(120) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','isdefault')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `isdefault` int(11) NOT NULL COMMENT '是否完成订单'");}
if(!pdo_fieldexists('ymmf_sun_appionorder','addtime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `addtime` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_appionorder','number')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_appionorder')." ADD   `number` varchar(45) DEFAULT NULL COMMENT '订单号'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(50) NOT NULL COMMENT '区域名称',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_area','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_area')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_area','area_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_area')." ADD   `area_name` varchar(50) NOT NULL COMMENT '区域名称'");}
if(!pdo_fieldexists('ymmf_sun_area','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_area')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_area','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_area')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(45) NOT NULL,
  `lb_imgs` varchar(500) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `bname1` varchar(120) DEFAULT NULL,
  `bname2` varchar(120) DEFAULT NULL,
  `bname3` varchar(120) DEFAULT NULL,
  `lb_imgs1` varchar(500) DEFAULT NULL,
  `lb_imgs2` varchar(500) DEFAULT NULL,
  `lb_imgs3` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_banner','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_banner','bname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD   `bname` varchar(45) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_banner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD   `lb_imgs` varchar(500) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_banner','bname1')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD   `bname1` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_banner','bname2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD   `bname2` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_banner','bname3')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD   `bname3` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_banner','lb_imgs1')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD   `lb_imgs1` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_banner','lb_imgs2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD   `lb_imgs2` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_banner','lb_imgs3')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_banner')." ADD   `lb_imgs3` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `stutes` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `lng` varchar(45) DEFAULT NULL,
  `lat` varchar(45) DEFAULT NULL,
  `logo` varchar(120) DEFAULT NULL,
  `user` varchar(40) DEFAULT NULL COMMENT '登录账号',
  `key` varchar(40) DEFAULT NULL COMMENT '秘钥',
  `sn` varchar(10) DEFAULT NULL COMMENT '编码',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额，不减少',
  `frozenamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现金额',
  `bind_uid` varchar(255) DEFAULT NULL COMMENT '绑定的用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_branch','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_branch','name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_branch','stutes')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `stutes` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_branch','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_branch','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_branch','address')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `address` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_branch','phone')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `phone` varchar(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_branch','lng')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `lng` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_branch','lat')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `lat` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_branch','logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `logo` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_branch','user')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `user` varchar(40) DEFAULT NULL COMMENT '登录账号'");}
if(!pdo_fieldexists('ymmf_sun_branch','key')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `key` varchar(40) DEFAULT NULL COMMENT '秘钥'");}
if(!pdo_fieldexists('ymmf_sun_branch','sn')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `sn` varchar(10) DEFAULT NULL COMMENT '编码'");}
if(!pdo_fieldexists('ymmf_sun_branch','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额，不减少'");}
if(!pdo_fieldexists('ymmf_sun_branch','frozenamount')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `frozenamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额'");}
if(!pdo_fieldexists('ymmf_sun_branch','amount')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现金额'");}
if(!pdo_fieldexists('ymmf_sun_branch','bind_uid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_branch')." ADD   `bind_uid` varchar(255) DEFAULT NULL COMMENT '绑定的用户id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_build_switch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(80) DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_build_switch','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_build_switch')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_build_switch','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_build_switch')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_build_switch','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_build_switch')." ADD   `openid` varchar(80) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_build_switch','build_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_build_switch')." ADD   `build_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_buildhair` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `build_id` int(11) DEFAULT NULL COMMENT '分店id',
  `hair_id` int(11) DEFAULT NULL COMMENT '技师id',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_buildhair','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_buildhair')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_buildhair','build_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_buildhair')." ADD   `build_id` int(11) DEFAULT NULL COMMENT '分店id'");}
if(!pdo_fieldexists('ymmf_sun_buildhair','hair_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_buildhair')." ADD   `hair_id` int(11) DEFAULT NULL COMMENT '技师id'");}
if(!pdo_fieldexists('ymmf_sun_buildhair','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_buildhair')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_business_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `account` varchar(255) NOT NULL COMMENT '账户',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `username` varchar(255) DEFAULT NULL COMMENT '商家后台显示的用户名,默认为微信名',
  `img` varchar(255) DEFAULT NULL COMMENT '商家后台用户头像,默认为微信头像',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商家后台账户表';

");

if(!pdo_fieldexists('ymmf_sun_business_account','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_business_account')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_business_account','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_business_account')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_business_account','account')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_business_account')." ADD   `account` varchar(255) NOT NULL COMMENT '账户'");}
if(!pdo_fieldexists('ymmf_sun_business_account','password')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_business_account')." ADD   `password` varchar(255) NOT NULL COMMENT '密码'");}
if(!pdo_fieldexists('ymmf_sun_business_account','username')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_business_account')." ADD   `username` varchar(255) DEFAULT NULL COMMENT '商家后台显示的用户名,默认为微信名'");}
if(!pdo_fieldexists('ymmf_sun_business_account','img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_business_account')." ADD   `img` varchar(255) DEFAULT NULL COMMENT '商家后台用户头像,默认为微信头像'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `start_place` varchar(100) NOT NULL COMMENT '出发地',
  `end_place` varchar(100) NOT NULL COMMENT '目的地',
  `start_time` varchar(30) NOT NULL COMMENT '出发时间',
  `num` int(4) NOT NULL COMMENT '乘车人数/可乘人数',
  `link_name` varchar(30) NOT NULL COMMENT '联系人',
  `link_tel` varchar(20) NOT NULL COMMENT '联系电话',
  `typename` varchar(30) NOT NULL COMMENT '分类名称',
  `other` varchar(300) NOT NULL COMMENT '补充',
  `time` int(11) NOT NULL COMMENT '发布时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `top_id` int(11) NOT NULL COMMENT '置顶ID',
  `top` int(4) NOT NULL COMMENT '是否置顶,1,是,2否',
  `uniacid` varchar(50) NOT NULL,
  `state` int(4) NOT NULL COMMENT '1待审核,2通过，3拒绝',
  `tj_place` varchar(300) NOT NULL COMMENT '途经地',
  `hw_wet` varchar(10) NOT NULL COMMENT '货物重量',
  `star_lat` varchar(20) NOT NULL COMMENT '出发地维度',
  `star_lng` varchar(20) NOT NULL COMMENT '出发地经度',
  `end_lat` varchar(20) NOT NULL COMMENT '目的地维度',
  `end_lng` varchar(20) NOT NULL COMMENT '目的地经度',
  `is_open` int(4) NOT NULL,
  `start_time2` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼车';

");

if(!pdo_fieldexists('ymmf_sun_car','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_car','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ymmf_sun_car','start_place')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `start_place` varchar(100) NOT NULL COMMENT '出发地'");}
if(!pdo_fieldexists('ymmf_sun_car','end_place')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `end_place` varchar(100) NOT NULL COMMENT '目的地'");}
if(!pdo_fieldexists('ymmf_sun_car','start_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `start_time` varchar(30) NOT NULL COMMENT '出发时间'");}
if(!pdo_fieldexists('ymmf_sun_car','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `num` int(4) NOT NULL COMMENT '乘车人数/可乘人数'");}
if(!pdo_fieldexists('ymmf_sun_car','link_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `link_name` varchar(30) NOT NULL COMMENT '联系人'");}
if(!pdo_fieldexists('ymmf_sun_car','link_tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `link_tel` varchar(20) NOT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ymmf_sun_car','typename')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `typename` varchar(30) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ymmf_sun_car','other')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `other` varchar(300) NOT NULL COMMENT '补充'");}
if(!pdo_fieldexists('ymmf_sun_car','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `time` int(11) NOT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('ymmf_sun_car','sh_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('ymmf_sun_car','top_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `top_id` int(11) NOT NULL COMMENT '置顶ID'");}
if(!pdo_fieldexists('ymmf_sun_car','top')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `top` int(4) NOT NULL COMMENT '是否置顶,1,是,2否'");}
if(!pdo_fieldexists('ymmf_sun_car','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_car','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `state` int(4) NOT NULL COMMENT '1待审核,2通过，3拒绝'");}
if(!pdo_fieldexists('ymmf_sun_car','tj_place')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `tj_place` varchar(300) NOT NULL COMMENT '途经地'");}
if(!pdo_fieldexists('ymmf_sun_car','hw_wet')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `hw_wet` varchar(10) NOT NULL COMMENT '货物重量'");}
if(!pdo_fieldexists('ymmf_sun_car','star_lat')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `star_lat` varchar(20) NOT NULL COMMENT '出发地维度'");}
if(!pdo_fieldexists('ymmf_sun_car','star_lng')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `star_lng` varchar(20) NOT NULL COMMENT '出发地经度'");}
if(!pdo_fieldexists('ymmf_sun_car','end_lat')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `end_lat` varchar(20) NOT NULL COMMENT '目的地维度'");}
if(!pdo_fieldexists('ymmf_sun_car','end_lng')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `end_lng` varchar(20) NOT NULL COMMENT '目的地经度'");}
if(!pdo_fieldexists('ymmf_sun_car','is_open')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `is_open` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_car','start_time2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `start_time2` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_car','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car')." ADD   `cityname` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_car_my_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL COMMENT '标签id',
  `car_id` int(11) NOT NULL COMMENT '拼车ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_car_my_tag','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_my_tag')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_car_my_tag','tag_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_my_tag')." ADD   `tag_id` int(11) NOT NULL COMMENT '标签id'");}
if(!pdo_fieldexists('ymmf_sun_car_my_tag','car_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_my_tag')." ADD   `car_id` int(11) NOT NULL COMMENT '拼车ID'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_car_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(30) NOT NULL COMMENT '分类名称',
  `tagname` varchar(30) NOT NULL COMMENT '标签名称',
  `uniacid` varchar(11) NOT NULL COMMENT '50',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_car_tag','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_tag')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_car_tag','typename')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_tag')." ADD   `typename` varchar(30) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ymmf_sun_car_tag','tagname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_tag')." ADD   `tagname` varchar(30) NOT NULL COMMENT '标签名称'");}
if(!pdo_fieldexists('ymmf_sun_car_tag','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_tag')." ADD   `uniacid` varchar(11) NOT NULL COMMENT '50'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_car_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月',
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼车置顶';

");

if(!pdo_fieldexists('ymmf_sun_car_top','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_top')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_car_top','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_top')." ADD   `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月'");}
if(!pdo_fieldexists('ymmf_sun_car_top','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_top')." ADD   `money` decimal(10,2) NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ymmf_sun_car_top','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_top')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_car_top','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_car_top')." ADD   `num` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_carpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(44) NOT NULL COMMENT '拼车id',
  `money` decimal(10,2) NOT NULL COMMENT '钱',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼车支付记录表';

");

if(!pdo_fieldexists('ymmf_sun_carpaylog','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_carpaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_carpaylog','car_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_carpaylog')." ADD   `car_id` int(44) NOT NULL COMMENT '拼车id'");}
if(!pdo_fieldexists('ymmf_sun_carpaylog','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_carpaylog')." ADD   `money` decimal(10,2) NOT NULL COMMENT '钱'");}
if(!pdo_fieldexists('ymmf_sun_carpaylog','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_carpaylog')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_carpaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_carpaylog')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL COMMENT '帖子id',
  `details` varchar(200) NOT NULL COMMENT '评论详情',
  `time` varchar(20) NOT NULL COMMENT '时间',
  `reply` varchar(200) NOT NULL COMMENT '回复详情',
  `hf_time` varchar(20) NOT NULL COMMENT '回复时间',
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `score` decimal(10,1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_comments','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_comments')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_comments','information_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_comments')." ADD   `information_id` int(11) NOT NULL COMMENT '帖子id'");}
if(!pdo_fieldexists('ymmf_sun_comments','details')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_comments')." ADD   `details` varchar(200) NOT NULL COMMENT '评论详情'");}
if(!pdo_fieldexists('ymmf_sun_comments','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_comments')." ADD   `time` varchar(20) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('ymmf_sun_comments','reply')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_comments')." ADD   `reply` varchar(200) NOT NULL COMMENT '回复详情'");}
if(!pdo_fieldexists('ymmf_sun_comments','hf_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_comments')." ADD   `hf_time` varchar(20) NOT NULL COMMENT '回复时间'");}
if(!pdo_fieldexists('ymmf_sun_comments','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_comments')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_comments','store_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_comments')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_comments','score')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_comments')." ADD   `score` decimal(10,1) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_commission_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1.支付宝2.银行卡',
  `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝',
  `time` int(11) NOT NULL COMMENT '申请时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `uniacid` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `account` varchar(100) NOT NULL,
  `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额',
  `sj_cost` decimal(10,2) NOT NULL COMMENT '实际到账金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金提现';

");

if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `type` int(11) NOT NULL COMMENT '1.支付宝2.银行卡'");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝'");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `time` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','sh_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','user_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `user_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','account')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `account` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','tx_cost')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('ymmf_sun_commission_withdrawal','sj_cost')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_commission_withdrawal')." ADD   `sj_cost` decimal(10,2) NOT NULL COMMENT '实际到账金额'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '优惠券名称，展示用',
  `type` tinyint(3) unsigned NOT NULL COMMENT '优惠券类型（1:折扣 2:代金 ）',
  `astime` date DEFAULT NULL COMMENT '活动开始时间',
  `antime` date DEFAULT NULL COMMENT '活动结束时间',
  `expiryDate` int(10) unsigned DEFAULT NULL COMMENT '领取后，使用有效期',
  `allowance` int(10) unsigned DEFAULT NULL COMMENT '余量',
  `total` int(10) unsigned DEFAULT NULL COMMENT '总量',
  `val` varchar(255) DEFAULT NULL COMMENT '功能',
  `exchange` tinyint(3) unsigned DEFAULT NULL COMMENT '积分兑换',
  `scene` tinyint(4) unsigned DEFAULT NULL COMMENT '场景（1:充值赠送，2:买单赠送）',
  `state` int(11) DEFAULT NULL COMMENT '是否首页显示（2:不显示 1:显示）',
  `showIndex` int(11) NOT NULL DEFAULT '0',
  `selftime` varchar(45) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `build_id` varchar(80) DEFAULT NULL COMMENT '门店id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_coupon','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_coupon','weid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_coupon','title')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `title` varchar(255) NOT NULL COMMENT '优惠券名称，展示用'");}
if(!pdo_fieldexists('ymmf_sun_coupon','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `type` tinyint(3) unsigned NOT NULL COMMENT '优惠券类型（1:折扣 2:代金 ）'");}
if(!pdo_fieldexists('ymmf_sun_coupon','astime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `astime` date DEFAULT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('ymmf_sun_coupon','antime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `antime` date DEFAULT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('ymmf_sun_coupon','expiryDate')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `expiryDate` int(10) unsigned DEFAULT NULL COMMENT '领取后，使用有效期'");}
if(!pdo_fieldexists('ymmf_sun_coupon','allowance')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `allowance` int(10) unsigned DEFAULT NULL COMMENT '余量'");}
if(!pdo_fieldexists('ymmf_sun_coupon','total')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `total` int(10) unsigned DEFAULT NULL COMMENT '总量'");}
if(!pdo_fieldexists('ymmf_sun_coupon','val')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `val` varchar(255) DEFAULT NULL COMMENT '功能'");}
if(!pdo_fieldexists('ymmf_sun_coupon','exchange')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `exchange` tinyint(3) unsigned DEFAULT NULL COMMENT '积分兑换'");}
if(!pdo_fieldexists('ymmf_sun_coupon','scene')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `scene` tinyint(4) unsigned DEFAULT NULL COMMENT '场景（1:充值赠送，2:买单赠送）'");}
if(!pdo_fieldexists('ymmf_sun_coupon','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `state` int(11) DEFAULT NULL COMMENT '是否首页显示（2:不显示 1:显示）'");}
if(!pdo_fieldexists('ymmf_sun_coupon','showIndex')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `showIndex` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ymmf_sun_coupon','selftime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `selftime` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_coupon','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `status` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_coupon','build_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_coupon')." ADD   `build_id` varchar(80) DEFAULT NULL COMMENT '门店id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_tel` varchar(20) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销申请';

");

if(!pdo_fieldexists('ymmf_sun_distribution','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_distribution')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_distribution','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_distribution')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_distribution','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_distribution')." ADD   `time` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_distribution','user_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_distribution')." ADD   `user_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_distribution','user_tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_distribution')." ADD   `user_tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_distribution','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_distribution')." ADD   `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝'");}
if(!pdo_fieldexists('ymmf_sun_distribution','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_distribution')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_earnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `son_id` int(11) NOT NULL COMMENT '下线',
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金收益表';

");

if(!pdo_fieldexists('ymmf_sun_earnings','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_earnings')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_earnings','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_earnings')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_earnings','son_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_earnings')." ADD   `son_id` int(11) NOT NULL COMMENT '下线'");}
if(!pdo_fieldexists('ymmf_sun_earnings','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_earnings')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_earnings','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_earnings')." ADD   `time` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_earnings','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_earnings')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_fx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `zf_user_id` int(11) NOT NULL COMMENT '转发人ID',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `time` int(11) NOT NULL COMMENT '时间戳',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销表';

");

if(!pdo_fieldexists('ymmf_sun_fx','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fx')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_fx','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fx')." ADD   `user_id` int(11) NOT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('ymmf_sun_fx','zf_user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fx')." ADD   `zf_user_id` int(11) NOT NULL COMMENT '转发人ID'");}
if(!pdo_fieldexists('ymmf_sun_fx','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fx')." ADD   `money` decimal(10,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('ymmf_sun_fx','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fx')." ADD   `time` int(11) NOT NULL COMMENT '时间戳'");}
if(!pdo_fieldexists('ymmf_sun_fx','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fx')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_fxset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fx_details` text NOT NULL COMMENT '分销商申请协议',
  `tx_details` text NOT NULL COMMENT '佣金提现协议',
  `is_fx` int(11) NOT NULL COMMENT '1.开启分销审核2.不开启',
  `is_ej` int(11) NOT NULL COMMENT '是否开启二级分销1.是2.否',
  `tx_rate` int(11) NOT NULL COMMENT '提现手续费',
  `commission` varchar(10) NOT NULL COMMENT '一级佣金',
  `commission2` varchar(10) NOT NULL COMMENT '二级佣金',
  `tx_money` int(11) NOT NULL COMMENT '提现门槛',
  `img` varchar(100) NOT NULL COMMENT '分销中心图片',
  `img2` varchar(100) NOT NULL COMMENT '申请分销图片',
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '1' COMMENT '1.开启2关闭',
  `instructions` text NOT NULL COMMENT '分销商说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_fxset','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_fxset','fx_details')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `fx_details` text NOT NULL COMMENT '分销商申请协议'");}
if(!pdo_fieldexists('ymmf_sun_fxset','tx_details')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `tx_details` text NOT NULL COMMENT '佣金提现协议'");}
if(!pdo_fieldexists('ymmf_sun_fxset','is_fx')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `is_fx` int(11) NOT NULL COMMENT '1.开启分销审核2.不开启'");}
if(!pdo_fieldexists('ymmf_sun_fxset','is_ej')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `is_ej` int(11) NOT NULL COMMENT '是否开启二级分销1.是2.否'");}
if(!pdo_fieldexists('ymmf_sun_fxset','tx_rate')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `tx_rate` int(11) NOT NULL COMMENT '提现手续费'");}
if(!pdo_fieldexists('ymmf_sun_fxset','commission')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `commission` varchar(10) NOT NULL COMMENT '一级佣金'");}
if(!pdo_fieldexists('ymmf_sun_fxset','commission2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `commission2` varchar(10) NOT NULL COMMENT '二级佣金'");}
if(!pdo_fieldexists('ymmf_sun_fxset','tx_money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `tx_money` int(11) NOT NULL COMMENT '提现门槛'");}
if(!pdo_fieldexists('ymmf_sun_fxset','img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `img` varchar(100) NOT NULL COMMENT '分销中心图片'");}
if(!pdo_fieldexists('ymmf_sun_fxset','img2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `img2` varchar(100) NOT NULL COMMENT '申请分销图片'");}
if(!pdo_fieldexists('ymmf_sun_fxset','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_fxset','is_open')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `is_open` int(11) NOT NULL DEFAULT '1' COMMENT '1.开启2关闭'");}
if(!pdo_fieldexists('ymmf_sun_fxset','instructions')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxset')." ADD   `instructions` text NOT NULL COMMENT '分销商说明'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_fxuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '一级分销',
  `fx_user` int(11) NOT NULL COMMENT '二级分销',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_fxuser','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxuser')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_fxuser','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxuser')." ADD   `user_id` int(11) NOT NULL COMMENT '一级分销'");}
if(!pdo_fieldexists('ymmf_sun_fxuser','fx_user')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxuser')." ADD   `fx_user` int(11) NOT NULL COMMENT '二级分销'");}
if(!pdo_fieldexists('ymmf_sun_fxuser','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_fxuser')." ADD   `time` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `galname` varchar(255) NOT NULL,
  `imgs` text NOT NULL,
  `hair_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=gbk;

");

if(!pdo_fieldexists('ymmf_sun_gallery','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_gallery')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_gallery','galname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_gallery')." ADD   `galname` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_gallery','imgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_gallery')." ADD   `imgs` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_gallery','hair_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_gallery')." ADD   `hair_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_gallery','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_gallery')." ADD   `state` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_gallery','addtime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_gallery')." ADD   `addtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_gallery','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_gallery')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `goods_volume` varchar(45) NOT NULL COMMENT '商家ID',
  `spec_id` int(11) NOT NULL COMMENT '主规格ID',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `goods_num` int(11) NOT NULL COMMENT '商品数量',
  `goods_price` decimal(10,2) NOT NULL,
  `goods_cost` decimal(10,2) NOT NULL,
  `type_id` int(11) NOT NULL,
  `freight` decimal(10,2) NOT NULL COMMENT '运费',
  `delivery` varchar(500) NOT NULL COMMENT '关于发货',
  `quality` int(4) NOT NULL COMMENT '正品1是,0否',
  `free` int(4) NOT NULL COMMENT '包邮1是,0否',
  `all_day` int(4) NOT NULL COMMENT '24小时发货1是,0否',
  `service` int(4) NOT NULL COMMENT '售后服务1是,0否',
  `refund` int(4) NOT NULL COMMENT '极速退款1是,0否',
  `weeks` int(4) NOT NULL COMMENT '7天包邮1是，0否',
  `lb_imgs` varchar(500) NOT NULL COMMENT '轮播图',
  `imgs` varchar(500) NOT NULL COMMENT '商品介绍图',
  `time` int(11) NOT NULL COMMENT '时间',
  `uniacid` varchar(50) NOT NULL,
  `goods_details` text NOT NULL COMMENT '商品详细',
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1待审核,2通过，3拒绝',
  `sy_num` int(11) NOT NULL COMMENT '剩余数量',
  `is_show` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `spec_name` varchar(45) NOT NULL,
  `spec_value` varchar(200) NOT NULL,
  `survey` text NOT NULL,
  `zs_imgs` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT='商品表';

");

if(!pdo_fieldexists('ymmf_sun_goods','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_goods','store_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','goods_volume')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `goods_volume` varchar(45) NOT NULL COMMENT '商家ID'");}
if(!pdo_fieldexists('ymmf_sun_goods','spec_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `spec_id` int(11) NOT NULL COMMENT '主规格ID'");}
if(!pdo_fieldexists('ymmf_sun_goods','goods_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `goods_name` varchar(100) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('ymmf_sun_goods','goods_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `goods_num` int(11) NOT NULL COMMENT '商品数量'");}
if(!pdo_fieldexists('ymmf_sun_goods','goods_price')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `goods_price` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','goods_cost')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `goods_cost` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','type_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `type_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','freight')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `freight` decimal(10,2) NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('ymmf_sun_goods','delivery')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `delivery` varchar(500) NOT NULL COMMENT '关于发货'");}
if(!pdo_fieldexists('ymmf_sun_goods','quality')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `quality` int(4) NOT NULL COMMENT '正品1是,0否'");}
if(!pdo_fieldexists('ymmf_sun_goods','free')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `free` int(4) NOT NULL COMMENT '包邮1是,0否'");}
if(!pdo_fieldexists('ymmf_sun_goods','all_day')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `all_day` int(4) NOT NULL COMMENT '24小时发货1是,0否'");}
if(!pdo_fieldexists('ymmf_sun_goods','service')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `service` int(4) NOT NULL COMMENT '售后服务1是,0否'");}
if(!pdo_fieldexists('ymmf_sun_goods','refund')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `refund` int(4) NOT NULL COMMENT '极速退款1是,0否'");}
if(!pdo_fieldexists('ymmf_sun_goods','weeks')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `weeks` int(4) NOT NULL COMMENT '7天包邮1是，0否'");}
if(!pdo_fieldexists('ymmf_sun_goods','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `lb_imgs` varchar(500) NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('ymmf_sun_goods','imgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `imgs` varchar(500) NOT NULL COMMENT '商品介绍图'");}
if(!pdo_fieldexists('ymmf_sun_goods','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `time` int(11) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('ymmf_sun_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','goods_details')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `goods_details` text NOT NULL COMMENT '商品详细'");}
if(!pdo_fieldexists('ymmf_sun_goods','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `state` int(4) NOT NULL DEFAULT '1' COMMENT '1待审核,2通过，3拒绝'");}
if(!pdo_fieldexists('ymmf_sun_goods','sy_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `sy_num` int(11) NOT NULL COMMENT '剩余数量'");}
if(!pdo_fieldexists('ymmf_sun_goods','is_show')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `is_show` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','sales')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `sales` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','spec_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `spec_name` varchar(45) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','spec_value')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `spec_value` varchar(200) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','survey')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `survey` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods','zs_imgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods')." ADD   `zs_imgs` text NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_goods_spec` (
  `spec_value` varchar(45) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spec_name` varchar(100) NOT NULL COMMENT '规格名称',
  `sort` int(4) NOT NULL COMMENT '排序',
  `uniacid` varchar(50) NOT NULL COMMENT '50',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格表';

");

if(!pdo_fieldexists('ymmf_sun_goods_spec','spec_value')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods_spec')." ADD 
  `spec_value` varchar(45) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_goods_spec','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods_spec')." ADD   `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_goods_spec','spec_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods_spec')." ADD   `spec_name` varchar(100) NOT NULL COMMENT '规格名称'");}
if(!pdo_fieldexists('ymmf_sun_goods_spec','sort')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods_spec')." ADD   `sort` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_goods_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_goods_spec')." ADD   `uniacid` varchar(50) NOT NULL COMMENT '50'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_hairers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hair_name` varchar(255) NOT NULL,
  `logo` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `num` int(11) DEFAULT NULL,
  `state` int(11) NOT NULL,
  `cate` varchar(120) NOT NULL COMMENT '类别',
  `appoint` int(11) NOT NULL DEFAULT '0' COMMENT '预约数',
  `star` varchar(45) DEFAULT NULL COMMENT '星级',
  `life` varchar(45) DEFAULT NULL COMMENT '年限',
  `praise` varchar(45) DEFAULT NULL COMMENT '好评率',
  `background` text,
  `appmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `account` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `addtime` varchar(20) DEFAULT NULL,
  `yylogo` varchar(200) NOT NULL COMMENT '预约logo',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=gbk;

");

if(!pdo_fieldexists('ymmf_sun_hairers','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_hairers','hair_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `hair_name` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_hairers','logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `logo` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_hairers','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_hairers','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_hairers','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `state` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_hairers','cate')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `cate` varchar(120) NOT NULL COMMENT '类别'");}
if(!pdo_fieldexists('ymmf_sun_hairers','appoint')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `appoint` int(11) NOT NULL DEFAULT '0' COMMENT '预约数'");}
if(!pdo_fieldexists('ymmf_sun_hairers','star')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `star` varchar(45) DEFAULT NULL COMMENT '星级'");}
if(!pdo_fieldexists('ymmf_sun_hairers','life')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `life` varchar(45) DEFAULT NULL COMMENT '年限'");}
if(!pdo_fieldexists('ymmf_sun_hairers','praise')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `praise` varchar(45) DEFAULT NULL COMMENT '好评率'");}
if(!pdo_fieldexists('ymmf_sun_hairers','background')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `background` text");}
if(!pdo_fieldexists('ymmf_sun_hairers','appmoney')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `appmoney` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('ymmf_sun_hairers','account')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `account` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_hairers','password')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `password` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_hairers','mobile')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `mobile` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_hairers','addtime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `addtime` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_hairers','yylogo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hairers')." ADD   `yylogo` varchar(200) NOT NULL COMMENT '预约logo'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_hblq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `tz_id` int(11) NOT NULL COMMENT '帖子ID',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `time` int(11) NOT NULL COMMENT '时间戳',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包领取表';

");

if(!pdo_fieldexists('ymmf_sun_hblq','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hblq')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_hblq','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hblq')." ADD   `user_id` int(11) NOT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('ymmf_sun_hblq','tz_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hblq')." ADD   `tz_id` int(11) NOT NULL COMMENT '帖子ID'");}
if(!pdo_fieldexists('ymmf_sun_hblq','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hblq')." ADD   `money` decimal(10,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('ymmf_sun_hblq','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hblq')." ADD   `time` int(11) NOT NULL COMMENT '时间戳'");}
if(!pdo_fieldexists('ymmf_sun_hblq','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hblq')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL COMMENT '标题',
  `answer` text NOT NULL COMMENT '回答',
  `sort` int(4) NOT NULL COMMENT '排序',
  `uniacid` varchar(50) NOT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_help','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_help')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_help','question')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_help')." ADD   `question` varchar(200) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ymmf_sun_help','answer')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_help')." ADD   `answer` text NOT NULL COMMENT '回答'");}
if(!pdo_fieldexists('ymmf_sun_help','sort')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_help')." ADD   `sort` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_help','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_help')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_help','created_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_help')." ADD   `created_time` datetime NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_hotcity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cityname` varchar(50) NOT NULL COMMENT '城市名称',
  `time` int(11) NOT NULL COMMENT '创建时间',
  `uniacid` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_hotcity','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hotcity')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_hotcity','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hotcity')." ADD   `cityname` varchar(50) NOT NULL COMMENT '城市名称'");}
if(!pdo_fieldexists('ymmf_sun_hotcity','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hotcity')." ADD   `time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ymmf_sun_hotcity','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hotcity')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_hotcity','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_hotcity')." ADD   `user_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1.一天2.半年3.一年',
  `money` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_in','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_in')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_in','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_in')." ADD   `type` int(11) NOT NULL COMMENT '1.一天2.半年3.一年'");}
if(!pdo_fieldexists('ymmf_sun_in','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_in')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_in','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_in')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_in','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_in')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `details` text NOT NULL COMMENT '内容',
  `img` text NOT NULL COMMENT '图片',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `user_name` varchar(20) NOT NULL COMMENT '联系人',
  `user_tel` varchar(20) NOT NULL COMMENT '电话',
  `hot` int(11) NOT NULL COMMENT '1.热门 2.不热门',
  `top` int(11) NOT NULL COMMENT '1.置顶 2.不置顶',
  `givelike` int(11) NOT NULL COMMENT '点赞数',
  `views` int(11) NOT NULL COMMENT '浏览量',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `type2_id` int(11) NOT NULL COMMENT '分类二id',
  `type_id` int(11) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.待审核 2.通过3拒绝',
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL COMMENT '发布时间',
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
  `del` int(11) NOT NULL DEFAULT '2',
  `user_img2` varchar(100) NOT NULL,
  `dq_time` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `hbfx_num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_information','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_information','details')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `details` text NOT NULL COMMENT '内容'");}
if(!pdo_fieldexists('ymmf_sun_information','img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `img` text NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('ymmf_sun_information','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ymmf_sun_information','user_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `user_name` varchar(20) NOT NULL COMMENT '联系人'");}
if(!pdo_fieldexists('ymmf_sun_information','user_tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `user_tel` varchar(20) NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('ymmf_sun_information','hot')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `hot` int(11) NOT NULL COMMENT '1.热门 2.不热门'");}
if(!pdo_fieldexists('ymmf_sun_information','top')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `top` int(11) NOT NULL COMMENT '1.置顶 2.不置顶'");}
if(!pdo_fieldexists('ymmf_sun_information','givelike')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `givelike` int(11) NOT NULL COMMENT '点赞数'");}
if(!pdo_fieldexists('ymmf_sun_information','views')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `views` int(11) NOT NULL COMMENT '浏览量'");}
if(!pdo_fieldexists('ymmf_sun_information','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ymmf_sun_information','type2_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `type2_id` int(11) NOT NULL COMMENT '分类二id'");}
if(!pdo_fieldexists('ymmf_sun_information','type_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `type_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `state` int(11) NOT NULL COMMENT '1.待审核 2.通过3拒绝'");}
if(!pdo_fieldexists('ymmf_sun_information','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `time` int(11) NOT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('ymmf_sun_information','sh_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `sh_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','top_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `top_type` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','address')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `address` varchar(500) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','hb_money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `hb_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','hb_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `hb_num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','hb_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `hb_type` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','hb_keyword')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `hb_keyword` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','hb_random')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `hb_random` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','hong')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `hong` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','store_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','del')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `del` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ymmf_sun_information','user_img2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `user_img2` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','dq_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `dq_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_information','hbfx_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_information')." ADD   `hbfx_num` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_kanjia_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(45) NOT NULL,
  `lb_imgs` varchar(500) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_kanjia_banner','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kanjia_banner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_kanjia_banner','bname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kanjia_banner')." ADD   `bname` varchar(45) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_kanjia_banner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kanjia_banner')." ADD   `lb_imgs` varchar(500) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_kanjia_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kanjia_banner')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_kjorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) DEFAULT NULL,
  `detailInfo` varchar(200) DEFAULT NULL,
  `telNumber` varchar(100) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `time` varchar(150) DEFAULT NULL,
  `openid` varchar(150) DEFAULT NULL,
  `countyName` varchar(150) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `addtime` varchar(100) DEFAULT NULL,
  `cityName` varchar(100) DEFAULT NULL,
  `provinceName` varchar(150) DEFAULT NULL,
  `text` text,
  `hair_id` int(11) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL COMMENT '门店id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `out_trade_no` varchar(255) NOT NULL COMMENT '外部单号',
  `notify_msg` text NOT NULL COMMENT '回调报文',
  `pay_type` int(5) DEFAULT NULL COMMENT '支付方式，1微信，2余额',
  `refund_status` int(5) DEFAULT NULL COMMENT '退款状态，0未退款，1申请退款，2部分退款，3拒绝退款，4失败，5成功',
  `finish_time` varchar(30) NOT NULL COMMENT '完成时间',
  `refund_time` varchar(30) NOT NULL COMMENT '退款时间',
  `refund_no` varchar(50) NOT NULL COMMENT '退款单号',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信交易订单号',
  `gid` int(11) DEFAULT '0' COMMENT '商品id',
  `pay_time` varchar(30) NOT NULL COMMENT '付款时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_kjorder','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_kjorder','orderNum')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `orderNum` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','detailInfo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `detailInfo` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','telNumber')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `telNumber` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `money` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `status` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `time` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `openid` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','countyName')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `countyName` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `name` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','addtime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `addtime` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','cityName')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `cityName` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','provinceName')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `provinceName` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','text')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `text` text");}
if(!pdo_fieldexists('ymmf_sun_kjorder','hair_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `hair_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `type` int(2) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorder','build_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `build_id` int(11) DEFAULT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `out_trade_no` varchar(255) NOT NULL COMMENT '外部单号'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','notify_msg')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `notify_msg` text NOT NULL COMMENT '回调报文'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','pay_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `pay_type` int(5) DEFAULT NULL COMMENT '支付方式，1微信，2余额'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','refund_status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `refund_status` int(5) DEFAULT NULL COMMENT '退款状态，0未退款，1申请退款，2部分退款，3拒绝退款，4失败，5成功'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','finish_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `finish_time` varchar(30) NOT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','refund_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `refund_time` varchar(30) NOT NULL COMMENT '退款时间'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','refund_no')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `refund_no` varchar(50) NOT NULL COMMENT '退款单号'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','transaction_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信交易订单号'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','gid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `gid` int(11) DEFAULT '0' COMMENT '商品id'");}
if(!pdo_fieldexists('ymmf_sun_kjorder','pay_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorder')." ADD   `pay_time` varchar(30) NOT NULL COMMENT '付款时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_kjorderlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `openid` varbinary(100) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `createTime` varchar(100) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_kjorderlist','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorderlist')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_kjorderlist','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorderlist')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorderlist','oid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorderlist')." ADD   `oid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorderlist','order_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorderlist')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorderlist','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorderlist')." ADD   `openid` varbinary(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorderlist','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorderlist')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorderlist','createTime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorderlist')." ADD   `createTime` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_kjorderlist','gid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_kjorderlist')." ADD   `gid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_name` varchar(20) NOT NULL,
  `type2_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_label','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_label')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_label','label_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_label')." ADD   `label_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_label','type2_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_label')." ADD   `type2_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL COMMENT '帖子id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `zx_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_like','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_like')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_like','information_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_like')." ADD   `information_id` int(11) NOT NULL COMMENT '帖子id'");}
if(!pdo_fieldexists('ymmf_sun_like','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_like')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ymmf_sun_like','zx_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_like')." ADD   `zx_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_maidan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `addtime` varchar(20) DEFAULT NULL,
  `price` varchar(20) DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL,
  `openid` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=gbk;

");

if(!pdo_fieldexists('ymmf_sun_maidan','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_maidan')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_maidan','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_maidan')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_maidan','addtime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_maidan')." ADD   `addtime` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_maidan','price')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_maidan')." ADD   `price` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_maidan','build_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_maidan')." ADD   `build_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_maidan','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_maidan')." ADD   `openid` varchar(80) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_mercapdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL COMMENT '商家id',
  `branchname` varchar(100) NOT NULL COMMENT '商家名称',
  `mcd_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型，1订单收入，2提现，3线下收款（线下收入直接打进商家账号，这里只是一个记录）',
  `mcd_memo` text NOT NULL COMMENT '订单收入等具体信息',
  `addtime` int(11) NOT NULL COMMENT '时间',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现的时候，支付的佣金',
  `uniacid` int(11) NOT NULL COMMENT '11',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态，1成功，2不成功',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `wd_id` int(11) NOT NULL DEFAULT '0' COMMENT '提现id',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `out_trade_no` varchar(255) NOT NULL COMMENT '外部订单号',
  `openid` varchar(255) NOT NULL COMMENT '线下付款人openid',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用',
  `sub_mch_id` varchar(255) NOT NULL COMMENT '子商户号id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=273 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ymmf_sun_mercapdetails','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','bid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','branchname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `branchname` varchar(100) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','mcd_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `mcd_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型，1订单收入，2提现，3线下收款（线下收入直接打进商家账号，这里只是一个记录）'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','mcd_memo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `mcd_memo` text NOT NULL COMMENT '订单收入等具体信息'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','addtime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `addtime` int(11) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','paycommission')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现的时候，支付的佣金'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `uniacid` int(11) NOT NULL COMMENT '11'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态，1成功，2不成功'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','order_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','wd_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `wd_id` int(11) NOT NULL DEFAULT '0' COMMENT '提现id'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `out_trade_no` varchar(255) NOT NULL COMMENT '外部订单号'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `openid` varchar(255) NOT NULL COMMENT '线下付款人openid'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用'");}
if(!pdo_fieldexists('ymmf_sun_mercapdetails','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mercapdetails')." ADD   `sub_mch_id` varchar(255) NOT NULL COMMENT '子商户号id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `recharge` decimal(50,2) DEFAULT NULL,
  `youhui` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_money','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_money')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_money','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_money')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_money','recharge')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_money')." ADD   `recharge` decimal(50,2) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_money','youhui')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_money')." ADD   `youhui` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_money','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_money')." ADD   `status` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_mylabel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` int(11) NOT NULL,
  `information_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_mylabel','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mylabel')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_mylabel','label_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mylabel')." ADD   `label_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_mylabel','information_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_mylabel')." ADD   `information_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `url_type` int(10) NOT NULL DEFAULT '0' COMMENT '链接类型',
  `url` varchar(255) NOT NULL COMMENT '跳转地址',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(10) NOT NULL DEFAULT '255' COMMENT '排序',
  `position` tinyint(3) DEFAULT '0' COMMENT '位置，1营销导航，2底部导航',
  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示，1显示，0不显示',
  `pic` varchar(255) NOT NULL COMMENT '展示图',
  `un_pic` varchar(255) DEFAULT NULL COMMENT '未选中图',
  `url_id` int(11) DEFAULT NULL COMMENT '参数 id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_nav','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_nav','title')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `title` varchar(200) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ymmf_sun_nav','url_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `url_type` int(10) NOT NULL DEFAULT '0' COMMENT '链接类型'");}
if(!pdo_fieldexists('ymmf_sun_nav','url')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `url` varchar(255) NOT NULL COMMENT '跳转地址'");}
if(!pdo_fieldexists('ymmf_sun_nav','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('ymmf_sun_nav','sort')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `sort` int(10) NOT NULL DEFAULT '255' COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_nav','position')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `position` tinyint(3) DEFAULT '0' COMMENT '位置，1营销导航，2底部导航'");}
if(!pdo_fieldexists('ymmf_sun_nav','isshow')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示，1显示，0不显示'");}
if(!pdo_fieldexists('ymmf_sun_nav','pic')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `pic` varchar(255) NOT NULL COMMENT '展示图'");}
if(!pdo_fieldexists('ymmf_sun_nav','un_pic')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `un_pic` varchar(255) DEFAULT NULL COMMENT '未选中图'");}
if(!pdo_fieldexists('ymmf_sun_nav','url_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_nav')." ADD   `url_id` int(11) DEFAULT NULL COMMENT '参数 id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_new_bargain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(100) DEFAULT NULL,
  `marketprice` decimal(11,2) DEFAULT NULL COMMENT '原价',
  `shopprice` decimal(11,2) DEFAULT NULL,
  `selftime` int(11) DEFAULT NULL COMMENT '时间',
  `pic` varchar(200) DEFAULT NULL COMMENT '图片',
  `content` text,
  `cid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `starttime` timestamp NULL DEFAULT NULL,
  `endtime` timestamp NULL DEFAULT NULL,
  `num` int(11) unsigned DEFAULT NULL,
  `hair_id` varchar(255) DEFAULT NULL COMMENT '技师di',
  `build_id` varchar(255) DEFAULT NULL COMMENT '门店id',
  `hbpic` varchar(200) DEFAULT NULL COMMENT '海报商品图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_new_bargain','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','gname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `gname` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','marketprice')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `marketprice` decimal(11,2) DEFAULT NULL COMMENT '原价'");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','shopprice')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `shopprice` decimal(11,2) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','selftime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `selftime` int(11) DEFAULT NULL COMMENT '时间'");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','pic')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','content')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `content` text");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','cid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `cid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','starttime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `starttime` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','endtime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `endtime` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `num` int(11) unsigned DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','hair_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `hair_id` varchar(255) DEFAULT NULL COMMENT '技师di'");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','build_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `build_id` varchar(255) DEFAULT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('ymmf_sun_new_bargain','hbpic')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_new_bargain')." ADD   `hbpic` varchar(200) DEFAULT NULL COMMENT '海报商品图片'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '公告标题',
  `details` text NOT NULL COMMENT '公告详情',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `state` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_news','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_news','title')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD   `title` varchar(50) NOT NULL COMMENT '公告标题'");}
if(!pdo_fieldexists('ymmf_sun_news','details')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD   `details` text NOT NULL COMMENT '公告详情'");}
if(!pdo_fieldexists('ymmf_sun_news','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_news','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_news','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD   `time` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_news','img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD   `img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_news','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD   `state` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_news','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD   `type` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_news','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_news')." ADD   `cityname` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(80) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL COMMENT '金额',
  `user_name` varchar(20) DEFAULT NULL COMMENT '联系人',
  `address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `tel` varchar(20) DEFAULT NULL COMMENT '电话',
  `time` int(11) DEFAULT NULL COMMENT '下单时间',
  `pay_time` datetime DEFAULT NULL,
  `complete_time` int(11) DEFAULT NULL,
  `fh_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `state` int(11) DEFAULT NULL COMMENT '1.待付款 2.待发货3.待确认4.已完成5.退款中6.已退款7.退款拒绝',
  `order_num` varchar(20) DEFAULT NULL COMMENT '订单号',
  `good_id` int(11) DEFAULT NULL,
  `good_name` text,
  `good_img` varchar(100) DEFAULT NULL,
  `good_money` decimal(10,2) DEFAULT NULL,
  `out_trade_no` varchar(50) DEFAULT NULL,
  `good_spec` varchar(200) DEFAULT NULL COMMENT '商品规格',
  `del` int(11) DEFAULT NULL COMMENT '用户删除1是  2否 ',
  `del2` int(11) DEFAULT NULL COMMENT '商家删除1.是2.否',
  `uniacid` int(11) DEFAULT NULL,
  `freight` decimal(10,2) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `good_num` int(11) DEFAULT NULL,
  `appiontime` text COMMENT '预约时间',
  `hair_id` int(11) DEFAULT NULL COMMENT '发型师对应id',
  `remark` text,
  `pname` text COMMENT '选择服务类型',
  `isdefault` int(11) DEFAULT NULL COMMENT '是否完成',
  `addtime` datetime DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL COMMENT '门店id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `notify_msg` text NOT NULL COMMENT '回调报文',
  `pay_type` int(5) DEFAULT NULL COMMENT '支付方式，1微信，2余额',
  `refund_status` int(5) DEFAULT NULL COMMENT '退款状态，0未退款，1申请退款，2部分退款，3拒绝退款，4失败，5成功',
  `finish_time` varchar(30) NOT NULL COMMENT '完成时间',
  `refund_time` varchar(30) NOT NULL COMMENT '退款时间',
  `refund_no` varchar(50) NOT NULL COMMENT '退款单号',
  `ordertype` int(2) DEFAULT NULL COMMENT '订单类型，1服务订单',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信交易订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

");

if(!pdo_fieldexists('ymmf_sun_order','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_order','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `user_id` varchar(80) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','store_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '金额'");}
if(!pdo_fieldexists('ymmf_sun_order','user_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `user_name` varchar(20) DEFAULT NULL COMMENT '联系人'");}
if(!pdo_fieldexists('ymmf_sun_order','address')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `address` varchar(200) DEFAULT NULL COMMENT '联系地址'");}
if(!pdo_fieldexists('ymmf_sun_order','tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `tel` varchar(20) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('ymmf_sun_order','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `time` int(11) DEFAULT NULL COMMENT '下单时间'");}
if(!pdo_fieldexists('ymmf_sun_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `pay_time` datetime DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','complete_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `complete_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','fh_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `fh_time` int(11) DEFAULT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('ymmf_sun_order','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `state` int(11) DEFAULT NULL COMMENT '1.待付款 2.待发货3.待确认4.已完成5.退款中6.已退款7.退款拒绝'");}
if(!pdo_fieldexists('ymmf_sun_order','order_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `order_num` varchar(20) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('ymmf_sun_order','good_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `good_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','good_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `good_name` text");}
if(!pdo_fieldexists('ymmf_sun_order','good_img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `good_img` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','good_money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `good_money` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `out_trade_no` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','good_spec')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `good_spec` varchar(200) DEFAULT NULL COMMENT '商品规格'");}
if(!pdo_fieldexists('ymmf_sun_order','del')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `del` int(11) DEFAULT NULL COMMENT '用户删除1是  2否 '");}
if(!pdo_fieldexists('ymmf_sun_order','del2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `del2` int(11) DEFAULT NULL COMMENT '商家删除1.是2.否'");}
if(!pdo_fieldexists('ymmf_sun_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','freight')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `freight` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','note')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `note` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','good_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `good_num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','appiontime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `appiontime` text COMMENT '预约时间'");}
if(!pdo_fieldexists('ymmf_sun_order','hair_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `hair_id` int(11) DEFAULT NULL COMMENT '发型师对应id'");}
if(!pdo_fieldexists('ymmf_sun_order','remark')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `remark` text");}
if(!pdo_fieldexists('ymmf_sun_order','pname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `pname` text COMMENT '选择服务类型'");}
if(!pdo_fieldexists('ymmf_sun_order','isdefault')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `isdefault` int(11) DEFAULT NULL COMMENT '是否完成'");}
if(!pdo_fieldexists('ymmf_sun_order','addtime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `addtime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_order','build_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `build_id` int(11) DEFAULT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('ymmf_sun_order','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('ymmf_sun_order','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('ymmf_sun_order','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
if(!pdo_fieldexists('ymmf_sun_order','notify_msg')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `notify_msg` text NOT NULL COMMENT '回调报文'");}
if(!pdo_fieldexists('ymmf_sun_order','pay_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `pay_type` int(5) DEFAULT NULL COMMENT '支付方式，1微信，2余额'");}
if(!pdo_fieldexists('ymmf_sun_order','refund_status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `refund_status` int(5) DEFAULT NULL COMMENT '退款状态，0未退款，1申请退款，2部分退款，3拒绝退款，4失败，5成功'");}
if(!pdo_fieldexists('ymmf_sun_order','finish_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `finish_time` varchar(30) NOT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('ymmf_sun_order','refund_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `refund_time` varchar(30) NOT NULL COMMENT '退款时间'");}
if(!pdo_fieldexists('ymmf_sun_order','refund_no')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `refund_no` varchar(50) NOT NULL COMMENT '退款单号'");}
if(!pdo_fieldexists('ymmf_sun_order','ordertype')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `ordertype` int(2) DEFAULT NULL COMMENT '订单类型，1服务订单'");}
if(!pdo_fieldexists('ymmf_sun_order','transaction_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_order')." ADD   `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信交易订单号'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_orderlost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  `oid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_orderlost','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_orderlost')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_orderlost','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_orderlost')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_orderlost','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_orderlost')." ADD   `time` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_orderlost','oid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_orderlost')." ADD   `oid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_paylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL COMMENT '外键id(商家,帖子,黄页,拼车)',
  `money` decimal(10,2) NOT NULL COMMENT '钱',
  `time` datetime NOT NULL COMMENT '时间',
  `uniacid` varchar(50) NOT NULL COMMENT '50',
  `note` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付记录表';

");

if(!pdo_fieldexists('ymmf_sun_paylog','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_paylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_paylog','fid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_paylog')." ADD   `fid` int(11) NOT NULL COMMENT '外键id(商家,帖子,黄页,拼车)'");}
if(!pdo_fieldexists('ymmf_sun_paylog','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_paylog')." ADD   `money` decimal(10,2) NOT NULL COMMENT '钱'");}
if(!pdo_fieldexists('ymmf_sun_paylog','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_paylog')." ADD   `time` datetime NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('ymmf_sun_paylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_paylog')." ADD   `uniacid` varchar(50) NOT NULL COMMENT '50'");}
if(!pdo_fieldexists('ymmf_sun_paylog','note')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_paylog')." ADD   `note` varchar(100) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_printing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sn` varchar(9) DEFAULT NULL COMMENT '编码',
  `key` varchar(20) DEFAULT NULL COMMENT '生成的ukey',
  `user` varchar(45) DEFAULT NULL COMMENT '登录账号',
  `is_open` int(11) DEFAULT NULL COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_printing','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_printing')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_printing','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_printing')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_printing','sn')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_printing')." ADD   `sn` varchar(9) DEFAULT NULL COMMENT '编码'");}
if(!pdo_fieldexists('ymmf_sun_printing','key')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_printing')." ADD   `key` varchar(20) DEFAULT NULL COMMENT '生成的ukey'");}
if(!pdo_fieldexists('ymmf_sun_printing','user')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_printing')." ADD   `user` varchar(45) DEFAULT NULL COMMENT '登录账号'");}
if(!pdo_fieldexists('ymmf_sun_printing','is_open')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_printing')." ADD   `is_open` int(11) DEFAULT NULL COMMENT '是否开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_recharges` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(120) DEFAULT NULL,
  `r_img` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `r_time` varchar(45) DEFAULT NULL,
  `r_money` int(120) DEFAULT NULL,
  `openid` varchar(80) DEFAULT NULL,
  `details_name` varchar(50) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk;

");

if(!pdo_fieldexists('ymmf_sun_recharges','rid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_recharges')." ADD 
  `rid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_recharges','r_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_recharges')." ADD   `r_name` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_recharges','r_img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_recharges')." ADD   `r_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_recharges','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_recharges')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_recharges','r_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_recharges')." ADD   `r_time` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_recharges','r_money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_recharges')." ADD   `r_money` int(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_recharges','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_recharges')." ADD   `openid` varchar(80) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_recharges','details_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_recharges')." ADD   `details_name` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(255) NOT NULL COMMENT '关联的项目name',
  `price` varchar(45) NOT NULL,
  `hair_id` int(11) NOT NULL,
  `hair_name` varchar(255) CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `goods_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=gbk;

");

if(!pdo_fieldexists('ymmf_sun_service','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_service')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_service','option')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_service')." ADD   `option` varchar(255) NOT NULL COMMENT '关联的项目name'");}
if(!pdo_fieldexists('ymmf_sun_service','price')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_service')." ADD   `price` varchar(45) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_service','hair_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_service')." ADD   `hair_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_service','hair_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_service')." ADD   `hair_name` varchar(255) CHARACTER SET gbk COLLATE gbk_bin NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_service','goods_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_service')." ADD   `goods_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_service','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_service')." ADD   `state` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_service','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_service')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL COMMENT '帖子id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_share','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_share')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_share','information_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_share')." ADD   `information_id` int(11) NOT NULL COMMENT '帖子id'");}
if(!pdo_fieldexists('ymmf_sun_share','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_share')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ymmf_sun_share','store_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_share')." ADD   `store_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(100) NOT NULL,
  `tpl_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '2',
  `tid1` varchar(50) NOT NULL,
  `tid2` varchar(50) NOT NULL,
  `tid3` varchar(50) NOT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `qitui` text NOT NULL COMMENT '奇推信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_sms','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_sms','appkey')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD   `appkey` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_sms','tpl_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD   `tpl_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_sms','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_sms','is_open')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD   `is_open` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ymmf_sun_sms','tid1')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD   `tid1` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_sms','tid2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD   `tid2` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_sms','tid3')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD   `tid3` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_sms','mobile')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD   `mobile` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_sms','qitui')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_sms')." ADD   `qitui` text NOT NULL COMMENT '奇推信息'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_spec_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `spec_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `num` int(11) NOT NULL COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_spec_value')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_spec_value','goods_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_spec_value')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品ID'");}
if(!pdo_fieldexists('ymmf_sun_spec_value','spec_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_spec_value')." ADD   `spec_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_spec_value','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_spec_value')." ADD   `money` decimal(10,2) NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ymmf_sun_spec_value','name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_spec_value')." ADD   `name` varchar(50) NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('ymmf_sun_spec_value','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_spec_value')." ADD   `num` int(11) NOT NULL COMMENT '数量'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `store_name` varchar(50) NOT NULL COMMENT '商家名称',
  `address` varchar(200) NOT NULL COMMENT '商家地址',
  `announcement` varchar(100) NOT NULL COMMENT '公告',
  `storetype_id` int(11) NOT NULL COMMENT '主行业分类id',
  `storetype2_id` int(11) NOT NULL COMMENT '商家子分类id',
  `area_id` int(11) NOT NULL COMMENT '区域id',
  `yy_time` varchar(50) NOT NULL COMMENT '营业时间',
  `keyword` varchar(50) NOT NULL COMMENT '关键字',
  `skzf` int(11) NOT NULL COMMENT '1.是 2否(刷卡支付)',
  `wifi` int(11) NOT NULL COMMENT '1.是 2否',
  `mftc` int(11) NOT NULL COMMENT '1.是 2否(免费停车)',
  `jzxy` int(11) NOT NULL COMMENT '1.是 2否(禁止吸烟)',
  `tgbj` int(11) NOT NULL COMMENT '1.是 2否(提供包间)',
  `sfxx` int(11) NOT NULL COMMENT '1.是 2否(沙发休闲)',
  `tel` varchar(20) NOT NULL COMMENT '手机号',
  `logo` varchar(100) NOT NULL,
  `weixin_logo` varchar(100) NOT NULL,
  `ad` text NOT NULL COMMENT '轮播图',
  `state` int(11) NOT NULL COMMENT '1.待审核2通过3拒绝',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `password` varchar(100) NOT NULL COMMENT '核销密码',
  `details` text NOT NULL COMMENT '商家简介',
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
  `is_top` int(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_store','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_store','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ymmf_sun_store','store_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `store_name` varchar(50) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('ymmf_sun_store','address')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `address` varchar(200) NOT NULL COMMENT '商家地址'");}
if(!pdo_fieldexists('ymmf_sun_store','announcement')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `announcement` varchar(100) NOT NULL COMMENT '公告'");}
if(!pdo_fieldexists('ymmf_sun_store','storetype_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `storetype_id` int(11) NOT NULL COMMENT '主行业分类id'");}
if(!pdo_fieldexists('ymmf_sun_store','storetype2_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `storetype2_id` int(11) NOT NULL COMMENT '商家子分类id'");}
if(!pdo_fieldexists('ymmf_sun_store','area_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `area_id` int(11) NOT NULL COMMENT '区域id'");}
if(!pdo_fieldexists('ymmf_sun_store','yy_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `yy_time` varchar(50) NOT NULL COMMENT '营业时间'");}
if(!pdo_fieldexists('ymmf_sun_store','keyword')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `keyword` varchar(50) NOT NULL COMMENT '关键字'");}
if(!pdo_fieldexists('ymmf_sun_store','skzf')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `skzf` int(11) NOT NULL COMMENT '1.是 2否(刷卡支付)'");}
if(!pdo_fieldexists('ymmf_sun_store','wifi')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `wifi` int(11) NOT NULL COMMENT '1.是 2否'");}
if(!pdo_fieldexists('ymmf_sun_store','mftc')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `mftc` int(11) NOT NULL COMMENT '1.是 2否(免费停车)'");}
if(!pdo_fieldexists('ymmf_sun_store','jzxy')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `jzxy` int(11) NOT NULL COMMENT '1.是 2否(禁止吸烟)'");}
if(!pdo_fieldexists('ymmf_sun_store','tgbj')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `tgbj` int(11) NOT NULL COMMENT '1.是 2否(提供包间)'");}
if(!pdo_fieldexists('ymmf_sun_store','sfxx')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `sfxx` int(11) NOT NULL COMMENT '1.是 2否(沙发休闲)'");}
if(!pdo_fieldexists('ymmf_sun_store','tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `tel` varchar(20) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('ymmf_sun_store','logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','weixin_logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `weixin_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','ad')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `ad` text NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('ymmf_sun_store','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `state` int(11) NOT NULL COMMENT '1.待审核2通过3拒绝'");}
if(!pdo_fieldexists('ymmf_sun_store','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `money` decimal(10,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('ymmf_sun_store','password')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `password` varchar(100) NOT NULL COMMENT '核销密码'");}
if(!pdo_fieldexists('ymmf_sun_store','details')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `details` text NOT NULL COMMENT '商家简介'");}
if(!pdo_fieldexists('ymmf_sun_store','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','coordinates')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `coordinates` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','views')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `views` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','score')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `score` decimal(10,1) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `type` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','sh_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `sh_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','time_over')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `time_over` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `img` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','vr_link')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `vr_link` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','start_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `start_time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','end_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `end_time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','wallet')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `wallet` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','user_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `user_name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','pwd')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `pwd` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','dq_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `dq_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','fx_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `fx_num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','ewm_logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `ewm_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store','is_top')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store')." ADD   `is_top` int(4) NOT NULL DEFAULT '2'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_store_wallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `note` varchar(20) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1加2减',
  `time` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家钱包明细';

");

if(!pdo_fieldexists('ymmf_sun_store_wallet','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store_wallet')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_store_wallet','store_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store_wallet')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store_wallet','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store_wallet')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store_wallet','note')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store_wallet')." ADD   `note` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_store_wallet','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store_wallet')." ADD   `type` int(11) NOT NULL COMMENT '1加2减'");}
if(!pdo_fieldexists('ymmf_sun_store_wallet','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_store_wallet')." ADD   `time` varchar(20) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_storepaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '商家ID',
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家入驻支付记录表';

");

if(!pdo_fieldexists('ymmf_sun_storepaylog','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storepaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_storepaylog','store_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storepaylog')." ADD   `store_id` int(11) NOT NULL COMMENT '商家ID'");}
if(!pdo_fieldexists('ymmf_sun_storepaylog','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storepaylog')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_storepaylog','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storepaylog')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_storepaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storepaylog')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_storetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL COMMENT '分类名称',
  `img` varchar(100) NOT NULL COMMENT '分类图片',
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL COMMENT '排序',
  `money` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_storetype','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_storetype','type_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype')." ADD   `type_name` varchar(20) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ymmf_sun_storetype','img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype')." ADD   `img` varchar(100) NOT NULL COMMENT '分类图片'");}
if(!pdo_fieldexists('ymmf_sun_storetype','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_storetype','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_storetype','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_storetype','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_storetype2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `type_id` int(11) NOT NULL COMMENT '主分类id',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_storetype2','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype2')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_storetype2','name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype2')." ADD   `name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_storetype2','type_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype2')." ADD   `type_id` int(11) NOT NULL COMMENT '主分类id'");}
if(!pdo_fieldexists('ymmf_sun_storetype2','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype2')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_storetype2','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype2')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_storetype2','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_storetype2')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_system` (
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
  `appionmoney` decimal(10,2) DEFAULT NULL COMMENT '预约金额',
  `fontcolor` varchar(255) DEFAULT NULL,
  `is_bargainopen` int(2) DEFAULT NULL,
  `bargain_price` varchar(11) DEFAULT NULL,
  `share_title` varchar(45) DEFAULT NULL,
  `js_font` varchar(80) DEFAULT NULL,
  `js_logo` varchar(120) DEFAULT NULL,
  `js_tel` varchar(20) DEFAULT NULL,
  `zhou_font` varchar(120) DEFAULT NULL,
  `guo_font` varchar(120) DEFAULT NULL,
  `chu_font` varchar(120) DEFAULT NULL,
  `qian_font` varchar(120) DEFAULT NULL,
  `zhoubian` varchar(120) DEFAULT NULL,
  `guonei` varchar(120) DEFAULT NULL,
  `chujing` varchar(120) DEFAULT NULL,
  `qianzheng` varchar(120) DEFAULT NULL,
  `user_background` varchar(120) DEFAULT NULL COMMENT '我的页面背景图',
  `survey` text COMMENT '会员说明',
  `vip_open` int(1) DEFAULT NULL COMMENT '是否开启会员',
  `poster_img` varchar(120) DEFAULT NULL COMMENT '海报图片',
  `poster_font` varchar(120) DEFAULT NULL COMMENT '海报文字',
  `qqkey` varchar(50) NOT NULL DEFAULT '0' COMMENT '腾讯地图key',
  `goodspicbg` varchar(100) NOT NULL COMMENT '商品海报背景图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_system','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_system','appid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `appid` varchar(100) NOT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('ymmf_sun_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `appsecret` varchar(200) NOT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('ymmf_sun_system','mchid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `mchid` varchar(20) NOT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('ymmf_sun_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('ymmf_sun_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','url_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `url_name` varchar(20) NOT NULL COMMENT '网址名称'");}
if(!pdo_fieldexists('ymmf_sun_system','details')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `details` text NOT NULL COMMENT '关于我们'");}
if(!pdo_fieldexists('ymmf_sun_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `url_logo` varchar(100) NOT NULL COMMENT '网址logo'");}
if(!pdo_fieldexists('ymmf_sun_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `bq_name` varchar(50) NOT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('ymmf_sun_system','link_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `link_name` varchar(30) NOT NULL COMMENT '网站名称'");}
if(!pdo_fieldexists('ymmf_sun_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `link_logo` varchar(100) NOT NULL COMMENT '网站logo'");}
if(!pdo_fieldexists('ymmf_sun_system','support')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `support` varchar(20) NOT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('ymmf_sun_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `bq_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','color')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `color` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tz_appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tz_name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','pt_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `pt_name` varchar(30) NOT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('ymmf_sun_system','tz_audit')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tz_audit` int(11) NOT NULL COMMENT '帖子审核1.是 2否'");}
if(!pdo_fieldexists('ymmf_sun_system','sj_audit')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `sj_audit` int(11) NOT NULL COMMENT '商家审核1.是 2否'");}
if(!pdo_fieldexists('ymmf_sun_system','mapkey')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `mapkey` varchar(200) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','gd_key')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `gd_key` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','hb_sxf')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `hb_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','tx_money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','tx_sxf')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tx_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','tx_details')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tx_details` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','rz_xuz')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `rz_xuz` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','ft_xuz')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `ft_xuz` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','fx_money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `fx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_hhr')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_hhr` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ymmf_sun_system','is_hbfl')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_hbfl` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ymmf_sun_system','is_zx')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_zx` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ymmf_sun_system','is_car')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_car` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','pc_xuz')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `pc_xuz` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','pc_money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `pc_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_sjrz')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_sjrz` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_pcfw')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_pcfw` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','total_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `total_num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_goods')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_goods` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `apiclient_cert` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `apiclient_key` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_openzx')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_openzx` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_hyset')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_hyset` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_tzopen')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_tzopen` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_pageopen')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_pageopen` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_tel` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','tx_mode')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tx_mode` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ymmf_sun_system','many_city')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `many_city` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ymmf_sun_system','tx_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tx_type` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ymmf_sun_system','is_hbzf')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_hbzf` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ymmf_sun_system','hb_img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `hb_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','tz_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `tz_num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `client_ip` varchar(30) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','hb_content')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `hb_content` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','appionmoney')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `appionmoney` decimal(10,2) DEFAULT NULL COMMENT '预约金额'");}
if(!pdo_fieldexists('ymmf_sun_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `fontcolor` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','is_bargainopen')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `is_bargainopen` int(2) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','bargain_price')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `bargain_price` varchar(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','share_title')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `share_title` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','js_font')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `js_font` varchar(80) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','js_logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `js_logo` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','js_tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `js_tel` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','zhou_font')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `zhou_font` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','guo_font')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `guo_font` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','chu_font')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `chu_font` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','qian_font')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `qian_font` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','zhoubian')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `zhoubian` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','guonei')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `guonei` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','chujing')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `chujing` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','qianzheng')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `qianzheng` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_system','user_background')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `user_background` varchar(120) DEFAULT NULL COMMENT '我的页面背景图'");}
if(!pdo_fieldexists('ymmf_sun_system','survey')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `survey` text COMMENT '会员说明'");}
if(!pdo_fieldexists('ymmf_sun_system','vip_open')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `vip_open` int(1) DEFAULT NULL COMMENT '是否开启会员'");}
if(!pdo_fieldexists('ymmf_sun_system','poster_img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `poster_img` varchar(120) DEFAULT NULL COMMENT '海报图片'");}
if(!pdo_fieldexists('ymmf_sun_system','poster_font')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `poster_font` varchar(120) DEFAULT NULL COMMENT '海报文字'");}
if(!pdo_fieldexists('ymmf_sun_system','qqkey')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `qqkey` varchar(50) NOT NULL DEFAULT '0' COMMENT '腾讯地图key'");}
if(!pdo_fieldexists('ymmf_sun_system','goodspicbg')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_system')." ADD   `goodspicbg` varchar(100) NOT NULL COMMENT '商品海报背景图'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `index` varchar(10) DEFAULT NULL COMMENT '首页文字',
  `indeximg` varchar(200) DEFAULT NULL,
  `indeximgs` varchar(200) DEFAULT NULL COMMENT '首页图标',
  `coupon` varchar(10) DEFAULT NULL COMMENT '优惠券',
  `couponimg` varchar(200) DEFAULT NULL,
  `couponimgs` varchar(200) DEFAULT NULL,
  `fans` varchar(10) DEFAULT NULL,
  `fansimg` varchar(200) DEFAULT NULL,
  `fansimgs` varchar(200) DEFAULT NULL,
  `mine` varchar(10) DEFAULT NULL,
  `mineimg` varchar(200) DEFAULT NULL,
  `mineimgs` varchar(200) DEFAULT NULL,
  `fontcolor` varchar(10) DEFAULT NULL,
  `fontcolored` varchar(10) DEFAULT NULL COMMENT '点击后字体颜色',
  `uniacid` int(11) DEFAULT NULL,
  `find` varchar(255) DEFAULT NULL,
  `findimg` varchar(200) DEFAULT NULL,
  `findimgs` varchar(200) DEFAULT NULL,
  `is_fbopen` int(1) DEFAULT '0' COMMENT '0为关闭发布，1为开启',
  `is_shopen` int(1) DEFAULT '0' COMMENT '0为关闭动态审核,1为开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_tab','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_tab','index')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `index` varchar(10) DEFAULT NULL COMMENT '首页文字'");}
if(!pdo_fieldexists('ymmf_sun_tab','indeximg')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `indeximg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','indeximgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `indeximgs` varchar(200) DEFAULT NULL COMMENT '首页图标'");}
if(!pdo_fieldexists('ymmf_sun_tab','coupon')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `coupon` varchar(10) DEFAULT NULL COMMENT '优惠券'");}
if(!pdo_fieldexists('ymmf_sun_tab','couponimg')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `couponimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','couponimgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `couponimgs` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','fans')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `fans` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','fansimg')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `fansimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','fansimgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `fansimgs` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','mine')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `mine` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','mineimg')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `mineimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','mineimgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `mineimgs` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','fontcolor')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `fontcolor` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','fontcolored')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `fontcolored` varchar(10) DEFAULT NULL COMMENT '点击后字体颜色'");}
if(!pdo_fieldexists('ymmf_sun_tab','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','find')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `find` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','findimg')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `findimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','findimgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `findimgs` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_tab','is_fbopen')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `is_fbopen` int(1) DEFAULT '0' COMMENT '0为关闭发布，1为开启'");}
if(!pdo_fieldexists('ymmf_sun_tab','is_shopen')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tab')." ADD   `is_shopen` int(1) DEFAULT '0' COMMENT '0为关闭动态审核,1为开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月',
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_top','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_top')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_top','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_top')." ADD   `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月'");}
if(!pdo_fieldexists('ymmf_sun_top','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_top')." ADD   `money` decimal(10,2) NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ymmf_sun_top','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_top')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_top','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_top')." ADD   `num` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL COMMENT '分类名称',
  `img` varchar(100) NOT NULL COMMENT '分类图片',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `num` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_type','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_type','type_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type')." ADD   `type_name` varchar(20) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ymmf_sun_type','img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type')." ADD   `img` varchar(100) NOT NULL COMMENT '分类图片'");}
if(!pdo_fieldexists('ymmf_sun_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ymmf_sun_type','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_type','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_type','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_type2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '分类名称',
  `type_id` int(11) NOT NULL COMMENT '主分类id',
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_type2','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type2')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_type2','name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type2')." ADD   `name` varchar(20) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ymmf_sun_type2','type_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type2')." ADD   `type_id` int(11) NOT NULL COMMENT '主分类id'");}
if(!pdo_fieldexists('ymmf_sun_type2','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type2')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_type2','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type2')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_type2','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_type2')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_tzpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tz_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='帖子支付记录表';

");

if(!pdo_fieldexists('ymmf_sun_tzpaylog','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tzpaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_tzpaylog','tz_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tzpaylog')." ADD   `tz_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_tzpaylog','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tzpaylog')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_tzpaylog','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tzpaylog')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_tzpaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_tzpaylog')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL COMMENT 'openid',
  `img` varchar(200) NOT NULL COMMENT '头像',
  `time` varchar(20) NOT NULL COMMENT '注册时间',
  `name` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `user_name` varchar(20) DEFAULT NULL,
  `user_tel` varchar(20) DEFAULT NULL,
  `user_address` varchar(200) DEFAULT NULL,
  `commission` decimal(10,2) DEFAULT NULL,
  `state` int(4) DEFAULT '1',
  `telphone` varchar(20) NOT NULL COMMENT '手机号码',
  `parents_id` int(11) NOT NULL COMMENT '上级id',
  `parents_name` varchar(255) NOT NULL COMMENT '上级名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_user','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `openid` varchar(100) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('ymmf_sun_user','img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `img` varchar(200) NOT NULL COMMENT '头像'");}
if(!pdo_fieldexists('ymmf_sun_user','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `time` varchar(20) NOT NULL COMMENT '注册时间'");}
if(!pdo_fieldexists('ymmf_sun_user','name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_user','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('ymmf_sun_user','user_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `user_name` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user','user_tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `user_tel` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user','user_address')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `user_address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user','commission')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `commission` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `state` int(4) DEFAULT '1'");}
if(!pdo_fieldexists('ymmf_sun_user','telphone')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `telphone` varchar(20) NOT NULL COMMENT '手机号码'");}
if(!pdo_fieldexists('ymmf_sun_user','parents_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `parents_id` int(11) NOT NULL COMMENT '上级id'");}
if(!pdo_fieldexists('ymmf_sun_user','parents_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user')." ADD   `parents_name` varchar(255) NOT NULL COMMENT '上级名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_user_bargain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `mch_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `price` decimal(10,2) unsigned DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `kanjia` decimal(10,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_user_bargain','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_bargain')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_user_bargain','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_bargain')." ADD   `openid` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_bargain','gid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_bargain')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_bargain','mch_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_bargain')." ADD   `mch_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_bargain','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_bargain')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_bargain','price')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_bargain')." ADD   `price` decimal(10,2) unsigned DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_bargain','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_bargain')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_bargain','add_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_bargain')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_bargain','kanjia')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_bargain')." ADD   `kanjia` decimal(10,2) unsigned DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `counp_id` int(11) NOT NULL,
  `addtime` varchar(45) NOT NULL,
  `uid` varchar(80) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=gbk;

");

if(!pdo_fieldexists('ymmf_sun_user_coupon','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_coupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_user_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_coupon')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_coupon','counp_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_coupon')." ADD   `counp_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_coupon','addtime')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_coupon')." ADD   `addtime` varchar(45) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_coupon','uid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_coupon')." ADD   `uid` varchar(80) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_user_coupon','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_user_coupon')." ADD   `status` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='formid表';

");

if(!pdo_fieldexists('ymmf_sun_userformid','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_userformid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_userformid','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_userformid')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ymmf_sun_userformid','form_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_userformid')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id'");}
if(!pdo_fieldexists('ymmf_sun_userformid','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_userformid')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_userformid','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_userformid')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_userformid','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_userformid')." ADD   `openid` varchar(50) NOT NULL COMMENT 'openid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_uservip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `vip_id` int(11) DEFAULT NULL COMMENT '会员id',
  `openid` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_uservip','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_uservip')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_uservip','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_uservip')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_uservip','vip_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_uservip')." ADD   `vip_id` int(11) DEFAULT NULL COMMENT '会员id'");}
if(!pdo_fieldexists('ymmf_sun_uservip','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_uservip')." ADD   `openid` varchar(80) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_vip_ka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vip_name` varchar(120) DEFAULT NULL COMMENT '会员卡名称',
  `discount` decimal(10,2) DEFAULT NULL COMMENT '折扣',
  `consumption` int(11) DEFAULT NULL COMMENT '消费金额',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_vip_ka','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_vip_ka')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_vip_ka','vip_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_vip_ka')." ADD   `vip_name` varchar(120) DEFAULT NULL COMMENT '会员卡名称'");}
if(!pdo_fieldexists('ymmf_sun_vip_ka','discount')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_vip_ka')." ADD   `discount` decimal(10,2) DEFAULT NULL COMMENT '折扣'");}
if(!pdo_fieldexists('ymmf_sun_vip_ka','consumption')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_vip_ka')." ADD   `consumption` int(11) DEFAULT NULL COMMENT '消费金额'");}
if(!pdo_fieldexists('ymmf_sun_vip_ka','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_vip_ka')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_visitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_visitor','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_visitor')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_visitor','uid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_visitor')." ADD   `uid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_visitor','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_visitor')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_visitor','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_visitor')." ADD   `time` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_winindex` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL,
  `path1` varchar(45) DEFAULT NULL,
  `path2` varchar(45) DEFAULT NULL,
  `path3` varchar(45) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `is_open` int(1) NOT NULL DEFAULT '0' COMMENT '0为关闭，1为开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_winindex','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_winindex')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_winindex','img1')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_winindex')." ADD   `img1` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_winindex','img2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_winindex')." ADD   `img2` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_winindex','img3')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_winindex')." ADD   `img3` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_winindex','path1')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_winindex')." ADD   `path1` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_winindex','path2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_winindex')." ADD   `path2` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_winindex','path3')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_winindex')." ADD   `path3` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_winindex','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_winindex')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ymmf_sun_winindex','is_open')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_winindex')." ADD   `is_open` int(1) NOT NULL DEFAULT '0' COMMENT '0为关闭，1为开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL COMMENT '提现用户oppenid',
  `money` decimal(10,2) NOT NULL COMMENT '提现金额',
  `wd_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '提现方式，1微信，2支付宝，3银行账号',
  `wd_account` varchar(100) NOT NULL COMMENT '提现账号',
  `wd_name` varchar(50) NOT NULL COMMENT '提现名字',
  `wd_phone` varchar(50) NOT NULL COMMENT '提现联系方式',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0审核中，1通过审核，2拒绝提现，3自动打款',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '需要支付佣金',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `branchname` varchar(100) NOT NULL COMMENT '提现商家名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ymmf_sun_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_withdraw','openid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `openid` varchar(200) NOT NULL COMMENT '提现用户oppenid'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `money` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','wd_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `wd_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '提现方式，1微信，2支付宝，3银行账号'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','wd_account')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `wd_account` varchar(100) NOT NULL COMMENT '提现账号'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','wd_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `wd_name` varchar(50) NOT NULL COMMENT '提现名字'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','wd_phone')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `wd_phone` varchar(50) NOT NULL COMMENT '提现联系方式'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0审核中，1通过审核，2拒绝提现，3自动打款'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','realmoney')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','paycommission')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '需要支付佣金'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','bid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id'");}
if(!pdo_fieldexists('ymmf_sun_withdraw','branchname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdraw')." ADD   `branchname` varchar(100) NOT NULL COMMENT '提现商家名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL COMMENT '真实姓名',
  `username` varchar(100) NOT NULL COMMENT '账号',
  `type` int(11) NOT NULL COMMENT '1支付宝 2.微信 3.银行',
  `time` int(11) NOT NULL COMMENT '申请时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `state` int(11) NOT NULL COMMENT '1.待审核 2.通过  3.拒绝',
  `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额',
  `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `uniacid` int(11) NOT NULL,
  `method` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_withdrawal','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `name` varchar(10) NOT NULL COMMENT '真实姓名'");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','username')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `username` varchar(100) NOT NULL COMMENT '账号'");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `type` int(11) NOT NULL COMMENT '1支付宝 2.微信 3.银行'");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `time` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','sh_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `state` int(11) NOT NULL COMMENT '1.待审核 2.通过  3.拒绝'");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','tx_cost')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','sj_cost')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额'");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','method')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `method` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_withdrawal','store_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawal')." ADD   `store_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_withdrawset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wd_type` varchar(50) NOT NULL DEFAULT '1' COMMENT '（1,2,3）提现方式，1微信支付，2支付宝，3银行打款',
  `min_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额',
  `avoidmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额，可直接提现金额',
  `wd_content` text NOT NULL COMMENT '提现须知',
  `cms_rates` float NOT NULL DEFAULT '0' COMMENT '平台佣金比率',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '提现开关，2关，1开',
  `wd_wxrates` float NOT NULL DEFAULT '0' COMMENT '微信提现手续费',
  `wd_alipayrates` float NOT NULL DEFAULT '0' COMMENT '支付宝提现手续费',
  `wd_bankrates` float NOT NULL DEFAULT '0' COMMENT '银行卡提现手续费',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ymmf_sun_withdrawset','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','wd_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `wd_type` varchar(50) NOT NULL DEFAULT '1' COMMENT '（1,2,3）提现方式，1微信支付，2支付宝，3银行打款'");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','min_money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `min_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额'");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','avoidmoney')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `avoidmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额，可直接提现金额'");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','wd_content')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `wd_content` text NOT NULL COMMENT '提现须知'");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','cms_rates')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `cms_rates` float NOT NULL DEFAULT '0' COMMENT '平台佣金比率'");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','is_open')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '提现开关，2关，1开'");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','wd_wxrates')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `wd_wxrates` float NOT NULL DEFAULT '0' COMMENT '微信提现手续费'");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','wd_alipayrates')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `wd_alipayrates` float NOT NULL DEFAULT '0' COMMENT '支付宝提现手续费'");}
if(!pdo_fieldexists('ymmf_sun_withdrawset','wd_bankrates')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_withdrawset')." ADD   `wd_bankrates` float NOT NULL DEFAULT '0' COMMENT '银行卡提现手续费'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_yellowpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hy_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='黄页支付记录表';

");

if(!pdo_fieldexists('ymmf_sun_yellowpaylog','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowpaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_yellowpaylog','hy_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowpaylog')." ADD   `hy_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowpaylog','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowpaylog')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowpaylog','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowpaylog')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowpaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowpaylog')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_yellowset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL COMMENT '入住天数',
  `money` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='黄页设置表';

");

if(!pdo_fieldexists('ymmf_sun_yellowset','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_yellowset','days')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowset')." ADD   `days` int(11) NOT NULL COMMENT '入住天数'");}
if(!pdo_fieldexists('ymmf_sun_yellowset','money')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowset')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowset','num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowset')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowset','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowset')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_yellowstore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `logo` varchar(200) NOT NULL COMMENT 'logo图片',
  `company_name` varchar(100) NOT NULL COMMENT '公司名称',
  `company_address` varchar(200) NOT NULL COMMENT '公司地址',
  `type_id` int(11) NOT NULL COMMENT '二级分类',
  `link_tel` varchar(20) NOT NULL COMMENT '联系电话',
  `sort` int(11) NOT NULL COMMENT '排序',
  `rz_time` int(11) NOT NULL COMMENT '入住时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `state` int(4) NOT NULL COMMENT '1待,2通过,3拒绝',
  `rz_type` int(4) NOT NULL COMMENT '入驻类型',
  `time_over` int(4) NOT NULL COMMENT '1到期,2没到期',
  `uniacid` varchar(50) NOT NULL,
  `coordinates` varchar(50) NOT NULL COMMENT '坐标',
  `content` text NOT NULL COMMENT '简介',
  `imgs` varchar(500) NOT NULL COMMENT '多图',
  `views` int(11) NOT NULL,
  `tel2` varchar(20) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `dq_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_yellowstore','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','logo')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `logo` varchar(200) NOT NULL COMMENT 'logo图片'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','company_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `company_name` varchar(100) NOT NULL COMMENT '公司名称'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','company_address')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `company_address` varchar(200) NOT NULL COMMENT '公司地址'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','type_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `type_id` int(11) NOT NULL COMMENT '二级分类'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','link_tel')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `link_tel` varchar(20) NOT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','sort')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `sort` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','rz_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `rz_time` int(11) NOT NULL COMMENT '入住时间'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','sh_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `state` int(4) NOT NULL COMMENT '1待,2通过,3拒绝'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','rz_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `rz_type` int(4) NOT NULL COMMENT '入驻类型'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','time_over')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `time_over` int(4) NOT NULL COMMENT '1到期,2没到期'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','coordinates')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `coordinates` varchar(50) NOT NULL COMMENT '坐标'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','content')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `content` text NOT NULL COMMENT '简介'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','imgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `imgs` varchar(500) NOT NULL COMMENT '多图'");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','views')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `views` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','tel2')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `tel2` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yellowstore','dq_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yellowstore')." ADD   `dq_time` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_yjset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(4) NOT NULL DEFAULT '1' COMMENT '1统一模式,2分开模式',
  `typer` varchar(10) NOT NULL COMMENT '统一比例',
  `sjper` varchar(10) NOT NULL COMMENT '商家比例',
  `hyper` varchar(10) NOT NULL COMMENT '黄页比例',
  `pcper` varchar(10) NOT NULL COMMENT '拼车比例',
  `tzper` varchar(10) NOT NULL COMMENT '帖子比例',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金比例表';

");

if(!pdo_fieldexists('ymmf_sun_yjset','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_yjset','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjset')." ADD   `type` int(4) NOT NULL DEFAULT '1' COMMENT '1统一模式,2分开模式'");}
if(!pdo_fieldexists('ymmf_sun_yjset','typer')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjset')." ADD   `typer` varchar(10) NOT NULL COMMENT '统一比例'");}
if(!pdo_fieldexists('ymmf_sun_yjset','sjper')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjset')." ADD   `sjper` varchar(10) NOT NULL COMMENT '商家比例'");}
if(!pdo_fieldexists('ymmf_sun_yjset','hyper')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjset')." ADD   `hyper` varchar(10) NOT NULL COMMENT '黄页比例'");}
if(!pdo_fieldexists('ymmf_sun_yjset','pcper')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjset')." ADD   `pcper` varchar(10) NOT NULL COMMENT '拼车比例'");}
if(!pdo_fieldexists('ymmf_sun_yjset','tzper')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjset')." ADD   `tzper` varchar(10) NOT NULL COMMENT '帖子比例'");}
if(!pdo_fieldexists('ymmf_sun_yjset','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjset')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_yjtx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL COMMENT '账号id',
  `tx_type` int(4) NOT NULL COMMENT '提现方式 1,支付宝,2微信,3银联',
  `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额',
  `status` int(4) NOT NULL COMMENT '状态 1申请,2通过,3拒绝',
  `uniacid` varchar(50) NOT NULL,
  `cerated_time` datetime NOT NULL COMMENT '日期',
  `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额',
  `account` varchar(30) NOT NULL COMMENT '账户',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `sx_cost` decimal(10,2) NOT NULL COMMENT '手续费',
  `time` datetime NOT NULL COMMENT '审核时间',
  `is_del` int(4) NOT NULL DEFAULT '1' COMMENT '1正常,2删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_yjtx','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_yjtx','account_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `account_id` int(11) NOT NULL COMMENT '账号id'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','tx_type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `tx_type` int(4) NOT NULL COMMENT '提现方式 1,支付宝,2微信,3银联'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','tx_cost')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `status` int(4) NOT NULL COMMENT '状态 1申请,2通过,3拒绝'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_yjtx','cerated_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `cerated_time` datetime NOT NULL COMMENT '日期'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','sj_cost')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','account')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `account` varchar(30) NOT NULL COMMENT '账户'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `name` varchar(30) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','sx_cost')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `sx_cost` decimal(10,2) NOT NULL COMMENT '手续费'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `time` datetime NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('ymmf_sun_yjtx','is_del')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_yjtx')." ADD   `is_del` int(4) NOT NULL DEFAULT '1' COMMENT '1正常,2删除'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_zx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT '分类ID',
  `user_id` int(11) NOT NULL COMMENT '发布人ID',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `time` datetime NOT NULL,
  `yd_num` int(11) NOT NULL COMMENT '阅读数量',
  `pl_num` int(11) NOT NULL COMMENT '评论数量',
  `uniacid` varchar(50) NOT NULL,
  `imgs` text NOT NULL COMMENT '图片',
  `state` int(4) NOT NULL,
  `sh_time` datetime NOT NULL,
  `type` int(4) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_zx','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_zx','type_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `type_id` int(11) NOT NULL COMMENT '分类ID'");}
if(!pdo_fieldexists('ymmf_sun_zx','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `user_id` int(11) NOT NULL COMMENT '发布人ID'");}
if(!pdo_fieldexists('ymmf_sun_zx','title')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `title` varchar(200) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ymmf_sun_zx','content')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `content` text NOT NULL COMMENT '内容'");}
if(!pdo_fieldexists('ymmf_sun_zx','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx','yd_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `yd_num` int(11) NOT NULL COMMENT '阅读数量'");}
if(!pdo_fieldexists('ymmf_sun_zx','pl_num')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `pl_num` int(11) NOT NULL COMMENT '评论数量'");}
if(!pdo_fieldexists('ymmf_sun_zx','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx','imgs')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `imgs` text NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('ymmf_sun_zx','state')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `state` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx','sh_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `sh_time` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx','type')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `type` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx','cityname')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx')." ADD   `cityname` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_zx_assess` (
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

");

if(!pdo_fieldexists('ymmf_sun_zx_assess','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','zx_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `zx_id` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','score')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `score` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','content')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `content` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','img')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `img` varchar(500) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','cerated_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `cerated_time` datetime NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','status')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `status` int(4) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','reply')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `reply` text NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_assess','reply_time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_assess')." ADD   `reply_time` datetime NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_zx_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL COMMENT '分类名称',
  `icon` varchar(100) NOT NULL COMMENT '图标',
  `sort` int(4) NOT NULL COMMENT '排序',
  `time` datetime NOT NULL COMMENT '时间',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymmf_sun_zx_type','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_zx_type','type_name')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_type')." ADD   `type_name` varchar(100) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ymmf_sun_zx_type','icon')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_type')." ADD   `icon` varchar(100) NOT NULL COMMENT '图标'");}
if(!pdo_fieldexists('ymmf_sun_zx_type','sort')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_type')." ADD   `sort` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ymmf_sun_zx_type','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_type')." ADD   `time` datetime NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('ymmf_sun_zx_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_type')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymmf_sun_zx_zj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zx_id` int(11) NOT NULL COMMENT '资讯ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `uniacid` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资讯足迹';

");

if(!pdo_fieldexists('ymmf_sun_zx_zj','id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_zj')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymmf_sun_zx_zj','zx_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_zj')." ADD   `zx_id` int(11) NOT NULL COMMENT '资讯ID'");}
if(!pdo_fieldexists('ymmf_sun_zx_zj','user_id')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_zj')." ADD   `user_id` int(11) NOT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('ymmf_sun_zx_zj','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_zj')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ymmf_sun_zx_zj','time')) {pdo_query("ALTER TABLE ".tablename('ymmf_sun_zx_zj')." ADD   `time` int(11) NOT NULL");}
