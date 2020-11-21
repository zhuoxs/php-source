<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `score` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `uuid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `types` varchar(20) NOT NULL,
  `sid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_score','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_score','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','orderid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `orderid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','uid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','type')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `type` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','score')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `score` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','message')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `message` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','creattime')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `creattime` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','uuid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `uuid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','pid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `pid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','types')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `types` varchar(20) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score','sid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD   `sid` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `catepic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_score_cate','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_cate')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_score_cate','num')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_cate')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_cate','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_cate')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_cate','name')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_cate')." ADD   `name` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_cate','catepic')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_cate')." ADD   `catepic` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score_get` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `descp` varchar(255) NOT NULL COMMENT '简介',
  `score` float NOT NULL DEFAULT '0' COMMENT '积分数',
  `link` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `flag` int(1) NOT NULL COMMENT '0不开启 1开启',
  `fixed` int(2) DEFAULT NULL COMMENT '系统自动添加的几条',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='积分获取规则表';

");

if(!pdo_fieldexists('sudu8_page_score_get','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_get')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_score_get','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_get')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_get','title')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_get')." ADD   `title` varchar(255) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('sudu8_page_score_get','descp')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_get')." ADD   `descp` varchar(255) NOT NULL COMMENT '简介'");}
if(!pdo_fieldexists('sudu8_page_score_get','score')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_get')." ADD   `score` float NOT NULL DEFAULT '0' COMMENT '积分数'");}
if(!pdo_fieldexists('sudu8_page_score_get','link')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_get')." ADD   `link` varchar(255) NOT NULL DEFAULT '' COMMENT '链接'");}
if(!pdo_fieldexists('sudu8_page_score_get','flag')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_get')." ADD   `flag` int(1) NOT NULL COMMENT '0不开启 1开启'");}
if(!pdo_fieldexists('sudu8_page_score_get','fixed')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_get')." ADD   `fixed` int(2) DEFAULT NULL COMMENT '系统自动添加的几条'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `num` varchar(11) NOT NULL,
  `creattime` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  `custime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_score_order','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_score_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','order_id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `order_id` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','uid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','openid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `openid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','pid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `pid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','thumb')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `thumb` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','product')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `product` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','price')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `price` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','num')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `num` varchar(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','creattime')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `creattime` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_order','flag')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `flag` int(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('sudu8_page_score_order','custime')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_order')." ADD   `custime` int(11) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `hits` int(11) NOT NULL,
  `sale_num` int(11) NOT NULL,
  `buy_type` varchar(255) NOT NULL DEFAULT '兑换',
  `thumb` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `desk` varchar(255) NOT NULL,
  `product_txt` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `market_price` varchar(255) NOT NULL,
  `pro_kc` int(11) NOT NULL DEFAULT '-1',
  `sale_tnum` int(22) NOT NULL DEFAULT '0',
  `labels` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('sudu8_page_score_shop','id')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('sudu8_page_score_shop','uniacid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','num')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','title')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `title` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','cid')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `cid` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','hits')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `hits` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','sale_num')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `sale_num` int(11) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','buy_type')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `buy_type` varchar(255) NOT NULL DEFAULT '兑换'");}
if(!pdo_fieldexists('sudu8_page_score_shop','thumb')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `thumb` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','text')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `text` text NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','desk')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `desk` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','product_txt')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `product_txt` text NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','price')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `price` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','market_price')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `market_price` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','pro_kc')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `pro_kc` int(11) NOT NULL DEFAULT '-1'");}
if(!pdo_fieldexists('sudu8_page_score_shop','sale_tnum')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `sale_tnum` int(22) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('sudu8_page_score_shop','labels')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `labels` varchar(255) NOT NULL");}
if(!pdo_fieldexists('sudu8_page_score_shop','flag')) {pdo_query("ALTER TABLE ".tablename('sudu8_page_score_shop')." ADD   `flag` int(1) NOT NULL DEFAULT '1'");}
