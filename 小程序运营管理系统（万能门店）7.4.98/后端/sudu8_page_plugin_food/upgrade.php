<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pcid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `counts` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `true_price` varchar(255) NOT NULL,
  `descimg` varchar(255) DEFAULT NULL,
  `desccon` varchar(255) DEFAULT NULL,
  `labels` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  `unit` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_food','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_food','num')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','cid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `cid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','pcid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `pcid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','title')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `title` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','thumb')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `thumb` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','counts')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `counts` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','price')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `price` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','true_price')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `true_price` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','descimg')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `descimg` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('sudu8_page_food','desccon')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `desccon` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('sudu8_page_food','labels')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `labels` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food','flag')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `flag` int(1) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('sudu8_page_food','unit')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food')." ADD   `unit` char(10) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `dateline` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_food_cate','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_cate')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_food_cate','num')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_cate')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_cate','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_cate')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_cate','title')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_cate')." ADD   `title` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_cate','dateline')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_cate')." ADD   `dateline` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_cate','flag')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_cate')." ADD   `flag` int(1) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `usertel` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `usertime` varchar(255) NOT NULL,
  `userbeiz` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `val` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  `zh` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_food_order','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_food_order','order_id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `order_id` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','username')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `username` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','usertel')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `usertel` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','address')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `address` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','usertime')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `usertime` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','userbeiz')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `userbeiz` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','uid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','openid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `openid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','val')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `val` text NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','price')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `price` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','creattime')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `creattime` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_order','flag')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `flag` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('sudu8_page_food_order','zh')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_order')." ADD   `zh` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_printer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL COMMENT '打印机名称',
  `title` varchar(255) NOT NULL COMMENT '头部标题',
  `models` varchar(255) NOT NULL COMMENT '打印机类型',
  `status` int(1) NOT NULL DEFAULT '2' COMMENT '1开启  2不开启',
  `nid` varchar(255) NOT NULL COMMENT '打印机终端号',
  `nkey` varchar(255) NOT NULL COMMENT '终端号秘钥',
  `uid` varchar(255) NOT NULL COMMENT '用户id',
  `apikey` varchar(255) NOT NULL COMMENT '秘钥',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_food_printer','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_food_printer','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `uniacid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_printer','pname')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `pname` varchar(255) NOT NULL COMMENT '打印机名称'");}
if(!pdo_fieldexists('sudu8_page_food_printer','title')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `title` varchar(255) NOT NULL COMMENT '头部标题'");}
if(!pdo_fieldexists('sudu8_page_food_printer','models')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `models` varchar(255) NOT NULL COMMENT '打印机类型'");}
if(!pdo_fieldexists('sudu8_page_food_printer','status')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `status` int(1) NOT NULL DEFAULT '2' COMMENT '1开启  2不开启'");}
if(!pdo_fieldexists('sudu8_page_food_printer','nid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `nid` varchar(255) NOT NULL COMMENT '打印机终端号'");}
if(!pdo_fieldexists('sudu8_page_food_printer','nkey')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `nkey` varchar(255) NOT NULL COMMENT '终端号秘钥'");}
if(!pdo_fieldexists('sudu8_page_food_printer','uid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `uid` varchar(255) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('sudu8_page_food_printer','apikey')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `apikey` varchar(255) NOT NULL COMMENT '秘钥'");}
if(!pdo_fieldexists('sudu8_page_food_printer','createtime')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_printer')." ADD   `createtime` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_sj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thumb` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `times` varchar(255) NOT NULL,
  `fuwu` varchar(255) NOT NULL,
  `qita` varchar(255) NOT NULL,
  `usname` int(1) NOT NULL DEFAULT '0',
  `ustel` int(1) NOT NULL DEFAULT '0',
  `usadd` int(1) NOT NULL DEFAULT '0',
  `usdate` int(1) NOT NULL DEFAULT '0',
  `ustime` int(1) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `tags` varchar(100) NOT NULL,
  `notice` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_food_sj','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_food_sj','thumb')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `thumb` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_sj','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_sj','names')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `names` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_sj','times')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `times` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_sj','fuwu')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `fuwu` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_sj','qita')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `qita` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_sj','usname')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `usname` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('sudu8_page_food_sj','ustel')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `ustel` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('sudu8_page_food_sj','usadd')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `usadd` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('sudu8_page_food_sj','usdate')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `usdate` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('sudu8_page_food_sj','ustime')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `ustime` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('sudu8_page_food_sj','score')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `score` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('sudu8_page_food_sj','phone')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `phone` varchar(15) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_sj','address')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `address` varchar(100) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_sj','tags')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `tags` varchar(100) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_sj','notice')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_sj')." ADD   `notice` varchar(200) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `tnum` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_food_tables','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_tables')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_food_tables','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_tables')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_tables','tnum')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_tables')." ADD   `tnum` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_tables','title')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_tables')." ADD   `title` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_food_tables','thumb')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_food_tables')." ADD   `thumb` varchar(255) NOT NULL");}
