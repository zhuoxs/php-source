<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `q_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_ad','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_ad')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_ad','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_ad')." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_ad','title')) {pdo_query("ALTER TABLE ".tablename('beta_car_ad')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_ad','link')) {pdo_query("ALTER TABLE ".tablename('beta_car_ad')." ADD   `link` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_ad','img')) {pdo_query("ALTER TABLE ".tablename('beta_car_ad')." ADD   `img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_ad','q_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_ad')." ADD   `q_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_alicall_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_no` varchar(11) DEFAULT NULL,
  `peer_no` varchar(32) DEFAULT NULL,
  `sub_id` varchar(32) DEFAULT '0' COMMENT '0收入1支出',
  `call_time` varchar(32) DEFAULT '0',
  `release_time` varchar(32) DEFAULT NULL,
  `yinsi_type` int(1) DEFAULT NULL,
  `taocan_name` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `taocan_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_alicall_log','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_alicall_log','phone_no')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `phone_no` varchar(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_alicall_log','peer_no')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `peer_no` varchar(32) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_alicall_log','sub_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `sub_id` varchar(32) DEFAULT '0' COMMENT '0收入1支出'");}
if(!pdo_fieldexists('beta_car_alicall_log','call_time')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `call_time` varchar(32) DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_alicall_log','release_time')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `release_time` varchar(32) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_alicall_log','yinsi_type')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `yinsi_type` int(1) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_alicall_log','taocan_name')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `taocan_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_alicall_log','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_alicall_log','user_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_alicall_log','type')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `type` int(1) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_alicall_log','taocan_time')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `taocan_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_alicall_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_alicall_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_axnbind` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sub_id` varchar(50) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `bind_status` int(1) DEFAULT '0',
  `type` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_axnbind','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_axnbind')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_axnbind','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_axnbind')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_axnbind','user_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_axnbind')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_axnbind','sub_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_axnbind')." ADD   `sub_id` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_axnbind','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_axnbind')." ADD   `time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_axnbind','bind_status')) {pdo_query("ALTER TABLE ".tablename('beta_car_axnbind')." ADD   `bind_status` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_axnbind','type')) {pdo_query("ALTER TABLE ".tablename('beta_car_axnbind')." ADD   `type` int(1) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `car` varchar(8) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `time` int(11) NOT NULL,
  `sn` varchar(32) NOT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `engineno` varchar(255) DEFAULT NULL,
  `classno` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=REDUNDANT;

");

if(!pdo_fieldexists('beta_car_car','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_car','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('beta_car_car','car')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `car` varchar(8) NOT NULL");}
if(!pdo_fieldexists('beta_car_car','mobile')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `mobile` varchar(11) NOT NULL");}
if(!pdo_fieldexists('beta_car_car','openid')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `openid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('beta_car_car','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `time` int(11) NOT NULL");}
if(!pdo_fieldexists('beta_car_car','sn')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `sn` varchar(32) NOT NULL");}
if(!pdo_fieldexists('beta_car_car','qrcode')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `qrcode` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_car','engineno')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `engineno` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_car','classno')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `classno` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_car','city')) {pdo_query("ALTER TABLE ".tablename('beta_car_car')." ADD   `city` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_car_axnbind` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sub_id` varchar(50) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_car_axnbind','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_car_axnbind')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_car_axnbind','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_car_axnbind')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_car_axnbind','user_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_car_axnbind')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_car_axnbind','sub_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_car_axnbind')." ADD   `sub_id` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_car_axnbind','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_car_axnbind')." ADD   `time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_cash_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `tid` varchar(50) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `cash` float(9,2) DEFAULT '0.00',
  `type` int(1) DEFAULT '0' COMMENT '0申请，1同意，2拒绝',
  `note` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_cash_log','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_cash_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_cash_log','userid')) {pdo_query("ALTER TABLE ".tablename('beta_car_cash_log')." ADD   `userid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_cash_log','tid')) {pdo_query("ALTER TABLE ".tablename('beta_car_cash_log')." ADD   `tid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_cash_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_cash_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_cash_log','cash')) {pdo_query("ALTER TABLE ".tablename('beta_car_cash_log')." ADD   `cash` float(9,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('beta_car_cash_log','type')) {pdo_query("ALTER TABLE ".tablename('beta_car_cash_log')." ADD   `type` int(1) DEFAULT '0' COMMENT '0申请，1同意，2拒绝'");}
if(!pdo_fieldexists('beta_car_cash_log','note')) {pdo_query("ALTER TABLE ".tablename('beta_car_cash_log')." ADD   `note` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_cash_log','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_cash_log')." ADD   `time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_hexiao_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `s_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_hexiao_log','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_hexiao_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_hexiao_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_hexiao_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_hexiao_log','s_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_hexiao_log')." ADD   `s_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_hexiao_log','user_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_hexiao_log')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_hexiao_log','card_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_hexiao_log')." ADD   `card_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_hexiao_log','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_hexiao_log')." ADD   `time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_nullqrcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sn` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `tid` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `q_id` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=501 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('beta_car_nullqrcode','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_nullqrcode','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode','sn')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode')." ADD   `sn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode','url')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode')." ADD   `url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode','tid')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode')." ADD   `tid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode','status')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode')." ADD   `status` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_nullqrcode','q_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode')." ADD   `q_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode','note')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode')." ADD   `note` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_nullqrcode_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `tid` varchar(255) DEFAULT NULL,
  `count` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `q_id` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('beta_car_nullqrcode_log','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_nullqrcode_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode_log','tid')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode_log')." ADD   `tid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode_log','count')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode_log')." ADD   `count` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode_log','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode_log')." ADD   `time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode_log','q_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode_log')." ADD   `q_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_nullqrcode_log','note')) {pdo_query("ALTER TABLE ".tablename('beta_car_nullqrcode_log')." ADD   `note` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `userName` varchar(20) DEFAULT NULL,
  `telNumber` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `expresn` varchar(30) DEFAULT NULL COMMENT '快递编号',
  `exprename` varchar(30) DEFAULT NULL COMMENT '快递公司',
  `status` int(1) DEFAULT '0' COMMENT '0待支付1支付成功2已发货',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_order','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_order','order_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `order_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_order','userid')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `userid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_order','userName')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `userName` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_order','telNumber')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `telNumber` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_order','address')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_order','addtime')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `addtime` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_order','expresn')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `expresn` varchar(30) DEFAULT NULL COMMENT '快递编号'");}
if(!pdo_fieldexists('beta_car_order','exprename')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `exprename` varchar(30) DEFAULT NULL COMMENT '快递公司'");}
if(!pdo_fieldexists('beta_car_order','status')) {pdo_query("ALTER TABLE ".tablename('beta_car_order')." ADD   `status` int(1) DEFAULT '0' COMMENT '0待支付1支付成功2已发货'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('beta_car_pay','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_pay')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_pay','user_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_pay')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_pay','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_pay')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_pay','order_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_pay')." ADD   `order_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_pay','type')) {pdo_query("ALTER TABLE ".tablename('beta_car_pay')." ADD   `type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_pay','sn')) {pdo_query("ALTER TABLE ".tablename('beta_car_pay')." ADD   `sn` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_qudao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_qudao','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_qudao')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_qudao','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_qudao')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_qudao','name')) {pdo_query("ALTER TABLE ".tablename('beta_car_qudao')." ADD   `name` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_seller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `data` longtext,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_seller','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_seller','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_seller','data')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller')." ADD   `data` longtext");}
if(!pdo_fieldexists('beta_car_seller','user_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller')." ADD   `user_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_seller_add` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_seller_add','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_add')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_seller_add','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_add')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_seller_add','name')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_add')." ADD   `name` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_seller_add','tel')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_add')." ADD   `tel` varchar(20) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_seller_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `s_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `money` float(9,0) DEFAULT NULL,
  `desc` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_seller_card','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_card')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_seller_card','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_card')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_seller_card','s_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_card')." ADD   `s_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_seller_card','name')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_card')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_seller_card','money')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_card')." ADD   `money` float(9,0) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_seller_card','desc')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_card')." ADD   `desc` text");}
if(!pdo_fieldexists('beta_car_seller_card','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_seller_card')." ADD   `time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `template_id` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `car_set` int(1) DEFAULT '0',
  `user_set` int(1) DEFAULT '0',
  `shop` float(9,2) DEFAULT '0.00',
  `yinhao_set` int(1) DEFAULT '0',
  `accessKey_id` varchar(255) DEFAULT NULL,
  `accessKey_secret` varchar(255) DEFAULT NULL,
  `fckey` varchar(255) DEFAULT NULL,
  `wx_header` varchar(255) DEFAULT '亲爱的智能挪车用户，您收到一条挪车请求，请尽快查看车辆，谢谢！',
  `wx_footer` varchar(255) DEFAULT '感谢您使用智能挪车，谢谢',
  `fenxiang_title` varchar(255) DEFAULT NULL,
  `fenxiang_dec` varchar(255) DEFAULT NULL,
  `fenxiang_img` varchar(255) DEFAULT NULL,
  `wx_time` int(11) DEFAULT '60',
  `tel_time` int(11) DEFAULT '10',
  `shop_img` varchar(255) DEFAULT NULL,
  `sms_set` int(1) DEFAULT '0',
  `sms_sid` varchar(32) DEFAULT NULL,
  `sms_token` varchar(32) DEFAULT NULL,
  `sms_appid` varchar(32) DEFAULT NULL,
  `sms_templateid` int(11) DEFAULT NULL,
  `seller_set` int(1) DEFAULT '1',
  `qrcode_set` int(1) DEFAULT '1',
  `mapkey` varchar(255) DEFAULT NULL,
  `yinsi_type` int(1) DEFAULT NULL,
  `yinsi_des` text,
  `sms_type` int(1) DEFAULT '1',
  `smssignname` varchar(50) DEFAULT NULL,
  `ali_templateid` varchar(50) DEFAULT NULL,
  `yinsi` int(1) DEFAULT '0',
  `hwappkey` varchar(100) DEFAULT NULL,
  `hwappsecret` varchar(100) DEFAULT NULL,
  `hwstoptime` int(3) DEFAULT '0',
  `audio` varchar(50) DEFAULT NULL,
  `carhead` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_setting','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_setting','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('beta_car_setting','site_name')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `site_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','template_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `template_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','img')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','car_set')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `car_set` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_setting','user_set')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `user_set` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_setting','shop')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `shop` float(9,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('beta_car_setting','yinhao_set')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `yinhao_set` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_setting','accessKey_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `accessKey_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','accessKey_secret')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `accessKey_secret` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','fckey')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `fckey` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','wx_header')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `wx_header` varchar(255) DEFAULT '亲爱的智能挪车用户，您收到一条挪车请求，请尽快查看车辆，谢谢！'");}
if(!pdo_fieldexists('beta_car_setting','wx_footer')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `wx_footer` varchar(255) DEFAULT '感谢您使用智能挪车，谢谢'");}
if(!pdo_fieldexists('beta_car_setting','fenxiang_title')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `fenxiang_title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','fenxiang_dec')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `fenxiang_dec` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','fenxiang_img')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `fenxiang_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','wx_time')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `wx_time` int(11) DEFAULT '60'");}
if(!pdo_fieldexists('beta_car_setting','tel_time')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `tel_time` int(11) DEFAULT '10'");}
if(!pdo_fieldexists('beta_car_setting','shop_img')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `shop_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','sms_set')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `sms_set` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_setting','sms_sid')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `sms_sid` varchar(32) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','sms_token')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `sms_token` varchar(32) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','sms_appid')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `sms_appid` varchar(32) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','sms_templateid')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `sms_templateid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','seller_set')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `seller_set` int(1) DEFAULT '1'");}
if(!pdo_fieldexists('beta_car_setting','qrcode_set')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `qrcode_set` int(1) DEFAULT '1'");}
if(!pdo_fieldexists('beta_car_setting','mapkey')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `mapkey` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','yinsi_type')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `yinsi_type` int(1) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','yinsi_des')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `yinsi_des` text");}
if(!pdo_fieldexists('beta_car_setting','sms_type')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `sms_type` int(1) DEFAULT '1'");}
if(!pdo_fieldexists('beta_car_setting','smssignname')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `smssignname` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','ali_templateid')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `ali_templateid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','yinsi')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `yinsi` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_setting','hwappkey')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `hwappkey` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','hwappsecret')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `hwappsecret` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','hwstoptime')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `hwstoptime` int(3) DEFAULT '0'");}
if(!pdo_fieldexists('beta_car_setting','audio')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `audio` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_setting','carhead')) {pdo_query("ALTER TABLE ".tablename('beta_car_setting')." ADD   `carhead` varchar(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_unisetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `cash` int(3) DEFAULT '50',
  `tixian` float(9,2) DEFAULT '0.00',
  `time` int(11) DEFAULT NULL,
  `fw_set` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_unisetting','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_unisetting')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_unisetting','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_unisetting')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_unisetting','cash')) {pdo_query("ALTER TABLE ".tablename('beta_car_unisetting')." ADD   `cash` int(3) DEFAULT '50'");}
if(!pdo_fieldexists('beta_car_unisetting','tixian')) {pdo_query("ALTER TABLE ".tablename('beta_car_unisetting')." ADD   `tixian` float(9,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('beta_car_unisetting','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_unisetting')." ADD   `time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_unisetting','fw_set')) {pdo_query("ALTER TABLE ".tablename('beta_car_unisetting')." ADD   `fw_set` int(1) DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `data` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_url','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_url')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_url','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_url')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_url','data')) {pdo_query("ALTER TABLE ".tablename('beta_car_url')." ADD   `data` longtext");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `headimg` varchar(255) DEFAULT NULL,
  `wx_set` int(1) DEFAULT '1',
  `phone_set` int(1) DEFAULT '1',
  `wx_img` varchar(255) DEFAULT NULL,
  `cash` float(9,2) DEFAULT '0.00',
  `re_cash` float(9,2) DEFAULT '0.00',
  `reid` int(11) DEFAULT NULL,
  `bindtime` int(11) DEFAULT NULL,
  `bindnum` varchar(30) DEFAULT NULL,
  `remain_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('beta_car_user','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user','openid')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user','nickname')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `nickname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user','headimg')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `headimg` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user','wx_set')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `wx_set` int(1) DEFAULT '1'");}
if(!pdo_fieldexists('beta_car_user','phone_set')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `phone_set` int(1) DEFAULT '1'");}
if(!pdo_fieldexists('beta_car_user','wx_img')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `wx_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user','cash')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `cash` float(9,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('beta_car_user','re_cash')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `re_cash` float(9,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('beta_car_user','reid')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `reid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user','bindtime')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `bindtime` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user','bindnum')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `bindnum` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user','remain_time')) {pdo_query("ALTER TABLE ".tablename('beta_car_user')." ADD   `remain_time` int(11) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_user_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `time` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `hexiao_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_user_card','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_card')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_user_card','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_card')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user_card','user_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_card')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user_card','card_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_card')." ADD   `card_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user_card','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_card')." ADD   `time` int(1) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user_card','status')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_card')." ADD   `status` int(1) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user_card','hexiao_time')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_card')." ADD   `hexiao_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT '0' COMMENT '0收入1支出',
  `money` float(9,2) DEFAULT '0.00',
  `note` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_user_log','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_user_log','userid')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_log')." ADD   `userid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user_log','type')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_log')." ADD   `type` int(1) DEFAULT '0' COMMENT '0收入1支出'");}
if(!pdo_fieldexists('beta_car_user_log','money')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_log')." ADD   `money` float(9,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('beta_car_user_log','note')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_log')." ADD   `note` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_user_log','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_user_log')." ADD   `time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_wzcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `code` varchar(32) DEFAULT NULL,
  `tid` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=502 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('beta_car_wzcode','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_wzcode','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzcode','code')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode')." ADD   `code` varchar(32) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzcode','tid')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode')." ADD   `tid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzcode','status')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode')." ADD   `status` int(1) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_wzcode_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `tid` varchar(255) DEFAULT NULL,
  `count` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('beta_car_wzcode_log','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_wzcode_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzcode_log','tid')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode_log')." ADD   `tid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzcode_log','count')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode_log')." ADD   `count` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzcode_log','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzcode_log')." ADD   `time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_wzlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sn` varchar(255) DEFAULT NULL,
  `data` longtext,
  `archiveno` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT '是否推送',
  `wztime` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_wzlog','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzlog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_wzlog','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzlog')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzlog','sn')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzlog')." ADD   `sn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzlog','data')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzlog')." ADD   `data` longtext");}
if(!pdo_fieldexists('beta_car_wzlog','archiveno')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzlog')." ADD   `archiveno` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzlog','status')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzlog')." ADD   `status` int(1) DEFAULT '0' COMMENT '是否推送'");}
if(!pdo_fieldexists('beta_car_wzlog','wztime')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzlog')." ADD   `wztime` int(1) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_wzts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sn` varchar(255) DEFAULT NULL,
  `paytime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT '0：未支付 1支付成功 2过期',
  `next_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_wzts','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzts')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_wzts','order_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzts')." ADD   `order_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzts','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzts')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzts','user_id')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzts')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzts','sn')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzts')." ADD   `sn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzts','paytime')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzts')." ADD   `paytime` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzts','endtime')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzts')." ADD   `endtime` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_wzts','status')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzts')." ADD   `status` int(1) DEFAULT '0' COMMENT '0：未支付 1支付成功 2过期'");}
if(!pdo_fieldexists('beta_car_wzts','next_time')) {pdo_query("ALTER TABLE ".tablename('beta_car_wzts')." ADD   `next_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_yinsi_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `remain_time` int(11) DEFAULT NULL,
  `money` float(11,2) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('beta_car_yinsi_shop','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_yinsi_shop')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_yinsi_shop','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_yinsi_shop')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_yinsi_shop','name')) {pdo_query("ALTER TABLE ".tablename('beta_car_yinsi_shop')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_yinsi_shop','remain_time')) {pdo_query("ALTER TABLE ".tablename('beta_car_yinsi_shop')." ADD   `remain_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_yinsi_shop','money')) {pdo_query("ALTER TABLE ".tablename('beta_car_yinsi_shop')." ADD   `money` float(11,2) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_yinsi_shop','time')) {pdo_query("ALTER TABLE ".tablename('beta_car_yinsi_shop')." ADD   `time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_beta_car_zengzhi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `weizhang` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('beta_car_zengzhi','id')) {pdo_query("ALTER TABLE ".tablename('beta_car_zengzhi')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('beta_car_zengzhi','uniacid')) {pdo_query("ALTER TABLE ".tablename('beta_car_zengzhi')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('beta_car_zengzhi','weizhang')) {pdo_query("ALTER TABLE ".tablename('beta_car_zengzhi')." ADD   `weizhang` longtext");}
