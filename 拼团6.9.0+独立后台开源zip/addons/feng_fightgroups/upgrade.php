<?php
if(!pdo_fieldexists('tg_order', 'goodsprice')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `goodsprice` VARCHAR( 45 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'pay_price')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `pay_price` VARCHAR( 45 ) NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'freight')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `freight` VARCHAR( 45 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'yunfei_id')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `yunfei_id` int( 11 )  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'is_discount')) {
  pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `is_discount` int( 11 )  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'credits')) {
  pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `credits` int( 11 )  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'credits')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `credits` int( 11 )  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'is_usecard')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `is_usecard` int( 11 )  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'is_hexiao')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `is_hexiao` int( 2 )  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'hexiao_id')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `hexiao_id` VARCHAR( 225 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'is_hexiao')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `is_hexiao` int( 2 )  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'hexiaoma')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `hexiaoma` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'veropenid')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `veropenid` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'is_share')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `is_share` int(2)  NOT NULL;");
}

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_dispatch')." (  
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `dispatchname` varchar(50) DEFAULT '',
  `dispatchtype` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `firstprice` decimal(10,2) DEFAULT '0.00',
  `secondprice` decimal(10,2) DEFAULT '0.00',
  `firstweight` int(11) DEFAULT '0',
  `secondweight` int(11) DEFAULT '0',
  `express` varchar(250) DEFAULT '',
  `areas` text,
  `carriers` text,
  `enabled` int(11) DEFAULT '0',
  `merchantid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_member')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL COMMENT '公众账号id',
  `openid` varchar(100) NOT NULL COMMENT '微信会员openID',
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `tag` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_arealimit')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  `arealimitname` varchar(56) NOT NULL,
  `areas` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_saler')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storeid` varchar(225) DEFAULT '',
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(255) DEFAULT '',
  `nickname` varchar(145) NOT NULL,
  `avatar` varchar(225) NOT NULL,
  `status` tinyint(3) DEFAULT '0',
  `merchantid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_storeid` (`storeid`),
  KEY `idx_uniacid` (`uniacid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_store')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `storename` varchar(255) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `tel` varchar(255) DEFAULT '',
  `lat` varchar(255) DEFAULT '',
  `lng` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '0',
  `merchantid` int(11) DEFAULT '0',
  `createtime` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

//4.0
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_merchant')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(145) NOT NULL,
  `logo` varchar(225) NOT NULL,
  `industry` varchar(45) NOT NULL,
  `address` varchar(115) NOT NULL,
  `linkman_name` varchar(145) NOT NULL,
  `linkman_mobile` varchar(145) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `createtime` varchar(115) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `detail` varchar(1222) NOT NULL,
  `salenum` int(11) NOT NULL COMMENT '商家销量',
  `open` int(11) NOT NULL COMMENT '是否分配商家权限',
  `uname` varchar(45) NOT NULL,
  `password` varchar(145) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_goods_option')." (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_spec')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `displaytype` tinyint(3) unsigned NOT NULL,
  `content` text NOT NULL,
  `goodsid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `merchantid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_spec_item')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `specid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `show` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_specid` (`specid`),
  KEY `indx_show` (`show`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_merchant_account')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchantid` int(11) NOT NULL COMMENT '商家ID',
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '操作员id',
  `amount` decimal(10,2) NOT NULL COMMENT '交易总金额',
  `updatetime` varchar(45) NOT NULL COMMENT '上次结算时间',
  `no_money` decimal(10,2) NOT NULL COMMENT '目前未结算金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_merchant_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchantid` int(11) NOT NULL COMMENT '商家id',
  `money` varchar(45) NOT NULL COMMENT '本次结算金额',
  `uid` int(11) NOT NULL COMMENT '操作员id',
  `createtime` varchar(45) NOT NULL COMMENT '结算时间',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");

if(!pdo_fieldexists('tg_goods', 'group_level')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `group_level` VARCHAR( 1000 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'group_level_status')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `group_level_status` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `merchantid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'hasoption')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `hasoption` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'share_title')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `share_title` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'share_image')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `share_image` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'share_desc')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `share_desc` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'one_limit')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `one_limit` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'many_limit')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `many_limit` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'firstdiscount')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `firstdiscount` DECIMAL( 10, 2 ) NOT NULL;");
}
if(!pdo_fieldexists('tg_group', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." ADD `merchantid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_group', 'price')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." ADD `price` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_merchant', 'uname')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `uname` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_merchant', 'password')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `password` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_merchant', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `uid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_merchant', 'open')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `open` int(2)  NOT NULL;");
}
if(!pdo_fieldexists('tg_merchant', 'messageopenid')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `messageopenid` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_merchant', 'openid')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `openid` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_merchant', 'goodsnum')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `goodsnum` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `merchantid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'optionid')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `optionid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'optionname')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `optionname` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_refund_record', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_refund_record')." ADD `merchantid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_saler', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_saler')." ADD `merchantid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_store', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_store')." ADD `merchantid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_dispatch', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_dispatch')." ADD `merchantid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'allsalenum')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `allsalenum` int(11) ;");
}
if(!pdo_fieldexists('tg_goods', 'falsenum')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `falsenum` int(11) ;");
}
if(!pdo_fieldexists('tg_merchant', 'allsalenum')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `allsalenum` int(11) ;");
}
if(!pdo_fieldexists('tg_merchant', 'falsenum')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `falsenum` int(11) ;");
}
/*4.5*/
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_user_role')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchantid` int(11) NOT NULL,
  `nodes` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");

if(!pdo_fieldexists('tg_goods', 'category_childid')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `category_childid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'category_parentid')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `category_parentid` int(11)  NOT NULL;");
}
if(pdo_fieldexists('tg_group', 'price')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." modify column price varchar(11);");

}
/*4.6*/
if(!pdo_fieldexists('tg_order', 'issettlement')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `issettlement` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'message')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `message`  TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '代付留言';");
}
if(!pdo_fieldexists('tg_order', 'ordertype')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `ordertype` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'othername')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `othername`  VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_merchant', 'percent')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `percent` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}


/*5.0*/
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_puv')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(45) NOT NULL,
  `pv` varchar(20) DEFAULT NULL COMMENT '总浏览人次',
  `uv` varchar(50) NOT NULL COMMENT '总浏览人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=411 DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_puv_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(45) NOT NULL,
  `openid` varchar(145) NOT NULL,
  `goodsid` int(11) NOT NULL COMMENT '商品id',
  `createtime` varchar(120) DEFAULT NULL COMMENT '访问时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_credit_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(245) NOT NULL,
  `num` varchar(30) NOT NULL,
  `createtime` varchar(145) NOT NULL,
  `transid` varchar(145) NOT NULL,
  `status` int(11) NOT NULL,
  `paytype` int(2) NOT NULL COMMENT '1微信2后台',
  `ordersn` varchar(145) NOT NULL,
  `type` int(2) NOT NULL COMMENT '1积分2余额',
  `remark` varchar(145) NOT NULL,
  `table` tinyint(4) DEFAULT NULL COMMENT '1微擎2tg',
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_user_node')." (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(300) NOT NULL,
  `do` varchar(255) NOT NULL,
  `ac` varchar(32) DEFAULT NULL,
  `op` varchar(32) DEFAULT NULL,
  `ac_id` int(11) DEFAULT NULL,
  `do_id` int(6) unsigned NOT NULL,
  `remark` varchar(255) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`do_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_setting')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `key` varchar(200) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_delivery_price')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `province` varchar(12) NOT NULL,
  `city` varchar(12) NOT NULL,
  `district` varchar(12) NOT NULL,
  `first_weight` varchar(20) NOT NULL,
  `first_fee` varchar(20) NOT NULL,
  `additional_weight` varchar(20) NOT NULL,
  `additional_fee` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`template_id`),
  KEY `district` (`province`,`city`,`district`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_delivery_template')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `region` longtext NOT NULL,
  `data` longtext NOT NULL,
  `updatetime` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_helpbuy')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(45) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_coupon')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_template_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `cash` varchar(20) NOT NULL,
  `is_at_least` tinyint(3) unsigned NOT NULL,
  `at_least` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `use_time` int(10) unsigned NOT NULL,
  `openid` varchar(100) NOT NULL,
  `uniacid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_coupon_template')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '优惠券名称',
  `value` varchar(50) NOT NULL COMMENT '最小面值',
  `value_to` varchar(50) NOT NULL COMMENT '最大面值',
  `is_random` tinyint(3) unsigned NOT NULL COMMENT '是否随机',
  `is_at_least` tinyint(3) unsigned NOT NULL COMMENT '是否存在最低消费',
  `at_least` varchar(20) NOT NULL COMMENT '最低消费',
  `is_sync_weixin` tinyint(11) unsigned NOT NULL,
  `user_level` tinyint(11) unsigned DEFAULT NULL,
  `quota` tinyint(10) unsigned NOT NULL COMMENT '领取限制',
  `start_time` int(10) unsigned NOT NULL COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL COMMENT '结束时间',
  `fans_tag` int(10) unsigned NOT NULL,
  `expire_notice` tinyint(4) unsigned NOT NULL,
  `is_share` tinyint(3) unsigned NOT NULL,
  `range_type` tinyint(3) unsigned NOT NULL,
  `is_forbid_preference` tinyint(3) unsigned NOT NULL,
  `description` varchar(255) NOT NULL COMMENT '描述',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `enable` tinyint(3) unsigned NOT NULL COMMENT '优惠券状态，1正常',
  `total` int(10) unsigned NOT NULL COMMENT '优惠券总量',
  `quantity_issue` int(10) unsigned NOT NULL,
  `quantity_used` int(10) unsigned NOT NULL COMMENT '已使用数量',
  `uid` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

if(pdo_fieldexists('tg_category', 'weid')) {
  pdo_query("ALTER TABLE".tablename('tg_category')."change weid uniacid  int(11) not null;");
}
if(pdo_fieldexists('tg_adv', 'weid')) {
  pdo_query("ALTER TABLE".tablename('tg_adv')."change weid uniacid  int(11) not null;");
}
if(pdo_fieldexists('tg_spec', 'weid')) {
  pdo_query("ALTER TABLE".tablename('tg_spec')."change weid uniacid  int(11) not null;");
}
if(pdo_fieldexists('tg_spec_item', 'weid')) {
  pdo_query("ALTER TABLE".tablename('tg_spec_item')."change weid uniacid  int(11) not null;");
}

if(!pdo_fieldexists('tg_goods', 'pv')) {
  pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `pv` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'uv')) {
  pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `uv` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'successtime')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `successtime`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'adminremark')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `adminremark`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'discount_fee')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `discount_fee`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'first_fee')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `first_fee`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'couponid')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `couponid`  int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'bdeltime')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `bdeltime`  int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_group', 'successtime')) {
  pdo_query("ALTER TABLE ".tablename('tg_group')." ADD `successtime`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
}
if(!pdo_fieldexists('tg_member', 'uid')) {
  pdo_query("ALTER TABLE ".tablename('tg_member')." ADD `uid`  int(11) NOT NULL;");
}
/*5.0.4*/
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_oplog')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `describe` varchar(225) DEFAULT NULL COMMENT '',
  `view_url` varchar(225) DEFAULT NULL COMMENT '',
  `ip` varchar(32) DEFAULT NULL COMMENT 'IP',
  `data` varchar(1024) DEFAULT NULL COMMENT '',
  `createtime` varchar(32) DEFAULT NULL COMMENT '',
  `user` varchar(32) DEFAULT NULL COMMENT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

if(!pdo_fieldexists('tg_member', 'credit1')) {
  pdo_query("ALTER TABLE ".tablename('tg_member')." ADD `credit1`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_member', 'credit2')) {
  pdo_query("ALTER TABLE ".tablename('tg_member')." ADD `credit2`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_member', 'address')) {
  pdo_query("ALTER TABLE ".tablename('tg_member')." ADD `address`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_member', 'realname')) {
  pdo_query("ALTER TABLE ".tablename('tg_member')." ADD `realname`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_member', 'mobile')) {
  pdo_query("ALTER TABLE ".tablename('tg_member')." ADD `mobile`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_goods', 'unit')) {
  pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `unit`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
/*5.0.7*/
if(!pdo_fieldexists('tg_goods', 'goodstab')) {
  pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `goodstab`  VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_coupon', 'openid')) {
  pdo_query("ALTER TABLE ".tablename('tg_coupon')." ADD `openid`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_coupon', 'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('tg_coupon')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_coupon_template', 'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('tg_coupon_template')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'helpbuy_opneid')) {
  pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `helpbuy_opneid`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_page')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  `html` longtext NOT NULL,
  `click_pv` varchar(10) NOT NULL,
  `click_uv` varchar(10) NOT NULL,
  `enter_pv` varchar(10) NOT NULL,
  `enter_uv` varchar(10) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

/*5.1.4*/
if(pdo_fieldexists('tg_user_node', 'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('tg_user_node')." DROP COLUMN `uniacid`;");
  pdo_query("truncate table ".tablename('tg_user_node'));
  pdo_query("insert into ".tablename('tg_user_node')."(`id`,`name`,`url`,`do`,`ac`,`op`,`ac_id`,`do_id`,`remark`,`displayorder`,`level`,`status`) values
  ('97','店铺设置','','store','setting','copyright','96','95','','0','3','2'),
  ('96','店铺设置','','store','setting','','0','95','','0','2','2'),
  ('95','店铺','','store','','','0','0','','0','1','2'),
  ('89','设置商品属性','','goods','goods','setgoodsproperty','84','83','','0','3','2'),
  ('88','批量设置','','goods','goods','batch','84','83','','0','3','2'),
  ('87','上下架/售罄/删除/彻底删除','','goods','goods','single_op','84','83','','0','3','2'),
  ('86','新增/修改商品','','goods','goods','post','84','83','','0','3','2'),
  ('85','商品列表','','goods','goods','display','84','83','','0','3','2'),
  ('84','商品管理','','goods','goods','','0','83','','0','2','2'),
  ('83','商品','','goods','','','0','0','','0','1','2'),
  ('106','退款','','order','fetch','refund','60','48','','0','3','2'),
  ('105','取消发货','','order','fetch','cancelsend','60','48','','0','3','2'),
  ('104','发货','','order','fetch','confirmsend','60','48','','0','3','2'),
  ('103','确认付款','','order','fetch','confrimpay','60','48','','0','3','2'),
  ('102','导出','','order','group','output','98','48','','0','3','2'),
  ('101','后台核销','','order','group','autogroup','98','48','','0','3','2'),
  ('100','团详情','','order','group','group_detail','98','48','','0','3','2'),
  ('99','订单列表','','order','group','all','98','48','','0','3','2'),
  ('98','团管理','','order','group','','0','48','','0','2','2'),
  ('82','订单详情','','order','refund','initsync','80','48','','0','3','2'),
  ('81','订单列表','','order','refund','display','80','48','','0','3','2'),
  ('80','批量退款','','order','refund','','0','48','','0','2','2'),
  ('79','导入订单','','order','import','import','76','48','','0','3','2'),
  ('78','导出订单','','order','import','output','76','48','','0','3','2'),
  ('77','发货列表','','order','import','display','76','48','','0','3','2'),
  ('76','批量发货','','order','import','','0','48','','0','2','2'),
  ('75','删除','','order','delivery','delete','71','48','','0','3','2'),
  ('74','是否启用','','order','delivery','editstatus','71','48','','0','3','2'),
  ('73','新增/编辑','','order','delivery','post','71','48','','0','3','2'),
  ('72','配送列表','','order','delivery','display','71','48','','0','3','2'),
  ('71','运费模板','','order','delivery','','0','48','','0','2','2'),
  ('64','导出','','order','fetch','output','60','48','','0','3','2'),
  ('63','后台核销','','order','fetch','confirm','60','48','','0','3','2'),
  ('62','订单详情','','order','fetch','detail','60','48','','0','3','2'),
  ('61','订单列表','','order','fetch','display','60','48','','0','3','2'),
  ('60','自提订单','','order','fetch','','0','48','','0','2','2'),
  ('59','退款','','order','order','refund','49','48','','0','3','2'),
  ('58','取消发货','','order','order','cancelsend','49','48','','0','3','2'),
  ('57','发货','','order','order','confirmsend','49','48','','0','3','2'),
  ('56','确认付款','','order','order','confrimpay','49','48','','0','3','2'),
  ('55','修改收货地址','','order','order','address','49','48','','0','3','2'),
  ('54','卖家备注','','order','order','remark','49','48','','0','3','2'),
  ('53','导出','','order','order','output','49','48','','0','3','2'),
  ('52','订单详情','','order','order','detail','49','48','','0','3','2'),
  ('51','订单列表','','order','order','received','49','48','','0','3','2'),
  ('50','订单概况','','order','order','summary','49','48','','0','3','2'),
  ('49','订单管理','','order','order','','0','48','','0','2','2'),
  ('48','订单','','order','','','0','0','','0','1','2'),
  ('113','概要统计','','data','home_data','display','112','34','','0','3','2'),
  ('112','概要统计','','data','home_data','','0','34','','0','2','2'),
  ('40','退款日志','','data','refund_log','display','39','34','','0','3','2'),
  ('39','退款日志','','data','refund_log','','0','34','','0','2','2'),
  ('38','订单统计','','data','order_data','display','37','34','','0','3','2'),
  ('37','订单统计','','data','order_data','','0','34','','0','2','2'),
  ('36','商品统计','','data','goods_data','display','35','34','','0','3','2'),
  ('35','商品统计','','data','goods_data','','0','34','','0','2','2'),
  ('34','数据中心','','data','','','0','0','','0','1','2'),
  ('111','插件列表','','application','plugins','list','110','1','','0','3','2'),
  ('110','插件列表','','application','plugins','','0','1','','0','2','2'),
  ('33','选择商品','','application','ladder','ajax','29','1','','0','3','2'),
  ('32','编辑阶梯团','','application','ladder','edit','29','1','','0','3','2'),
  ('31','新建阶梯团','','application','ladder','create','29','1','','0','3','2'),
  ('30','阶梯团列表','','application','ladder','list','29','1','','0','3','2'),
  ('29','阶梯团','','application','ladder','','0','1','','0','2','2'),
  ('17','选择门店','','application','bdelete','selectstore','12','1','','0','3','2'),
  ('16','选择粉丝','','application','bdelete','selectsaler','12','1','','0','3','2'),
  ('15','核销员','','application','bdelete','saler','12','1','','0','3','2'),
  ('14','门店管理','','application','bdelete','store','12','1','','0','3','2'),
  ('13','核销入口','','application','bdelete','hx_entry','12','1','','0','3','2'),
  ('12','核销管理','','application','bdelete','','0','1','','0','2','2'),
  ('1','应用与营销','','application','','','0','0','','0','1','2'),
  
  ('114','商家中心','','application','merchant','','0','1','','0','2','2');
  ");
}
if(!pdo_fieldexists('tg_delivery_template', 'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('tg_delivery_template')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_delivery_template', 'merchantid')) {
  pdo_query("ALTER TABLE ".tablename('tg_delivery_template')." ADD `merchantid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_user_role', 'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('tg_user_role')." ADD `uniacid` int(11) NOT NULL;");
}
/*5.2.1*/
if(!pdo_fieldexists('tg_goods', 'op_one_limit')) {
  pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `op_one_limit` int(11) NOT NULL;");
}
/*5.2.3*/
if(!pdo_fieldexists('tg_merchant_record', 'orderno')) {
  pdo_query("ALTER TABLE ".tablename('tg_merchant_record')." ADD `orderno`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_merchant_record', 'commission')) {
  pdo_query("ALTER TABLE ".tablename('tg_merchant_record')." ADD `commission`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_merchant_record', 'percent')) {
  pdo_query("ALTER TABLE ".tablename('tg_merchant_record')." ADD `percent`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
if(!pdo_fieldexists('tg_goods_option', 'stock')) {
  pdo_query("ALTER TABLE ".tablename('tg_goods_option')." ADD `stock`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci ;");
}
/*5.3*/
pdo_query("CREATE TABLE IF NOT EXISTS  ".tablename('tg_nav')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `uniacid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");

pdo_query(" CREATE TABLE IF NOT EXISTS ".tablename('tg_notice')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `enabled` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");

pdo_query(" CREATE TABLE IF NOT EXISTS ".tablename('tg_banner')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `uniacid` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");
/*5.3.1*/
if(!pdo_fieldexists('tg_goods', 'first_free')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `first_free` int(11)  NOT NULL;");
}

/*5.4*/
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_scratch')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL COMMENT '活动名称',
  `starttime` varchar(32) DEFAULT NULL COMMENT '开始时间',
  `endtime` varchar(32) DEFAULT NULL COMMENT '结束时间',
  `detail` varchar(145) DEFAULT NULL COMMENT '说明',
  `use_credits` varchar(32) DEFAULT NULL COMMENT '需花费积分',
  `get_credits` varchar(32) DEFAULT NULL COMMENT '得到积分',
  `join_times` int(11) DEFAULT NULL COMMENT '参与次数',
  `winning_rate` varchar(32) DEFAULT NULL COMMENT '中奖率',
  `prize` varchar(1024) DEFAULT NULL COMMENT '奖品',
  `uniacid` int(11) DEFAULT NULL,
  `only_others` int(11) DEFAULT NULL COMMENT '1为只送积分给未中奖人',
  `status` int(11) DEFAULT NULL COMMENT '1开启',
  `alert_logo` varchar(145) DEFAULT NULL COMMENT '弹出的抽奖提示图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_scratch_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(145) NOT NULL COMMENT '参与人openid',
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `type` varchar(45) DEFAULT NULL COMMENT '活动类型',
  `status` int(11) DEFAULT NULL COMMENT '2待领取3已领取',
  `prize` varchar(445) DEFAULT NULL COMMENT '奖品详情',
  `createtime` varchar(145) DEFAULT NULL COMMENT '参与时间',
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_gift')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(145) DEFAULT NULL COMMENT '活动名称',
  `uniacid` int(11) NOT NULL,
  `goodsid` int(11) NOT NULL COMMENT '商品id',
  `starttime` varchar(145) DEFAULT NULL COMMENT '活动开启时间',
  `endtime` varchar(145) DEFAULT NULL COMMENT '活动结束时间',
  `gettime` int(11) DEFAULT NULL COMMENT '有效领取时间',
  `times` int(11) DEFAULT NULL COMMENT '领取次数',
  `sendnum` int(11) DEFAULT NULL COMMENT '赠送数量',
  `getnum` int(11) DEFAULT NULL COMMENT '领取数量',
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_lottery')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(145) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `goodsid` int(11) DEFAULT NULL,
  `starttime` varchar(145) DEFAULT NULL,
  `endtime` varchar(145) DEFAULT NULL,
  `first_num` int(11) DEFAULT NULL,
  `second_num` int(11) DEFAULT NULL,
  `third_num` int(11) DEFAULT NULL,
  `forth_num` int(11) DEFAULT NULL,
  `createtime` varchar(145) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

if(!pdo_fieldexists('tg_goods', 'give_coupon_id')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `give_coupon_id` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'give_gift_id')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `give_gift_id` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'giftid')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `giftid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'getcouponid')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `getcouponid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_group', 'lottery_id')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." ADD `lottery_id` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_merchant_record', 'get_money')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant_record')." ADD `get_money` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci;");
}
if(!pdo_fieldexists('tg_order', 'storeid')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `storeid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'first_free')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `first_free` int(11)  NOT NULL;");
}
$allorder = pdo_fetchall("select id,orderno from".tablename('tg_order')."where pay_type = 2 and transid = ''");
if(!empty($allorder)){
	foreach ($allorder as $key => $value) {
    	$paylog = pdo_fetch("select tag from".tablename('core_paylog')."where tid = '{$value['orderno']}' and status = 1");
    	$paylog = unserialize($paylog['tag']);
    	pdo_update('tg_order',array('transid' => $paylog['transaction_id']),array('id' => $value['id']));
  	}
}
/*抽奖团*/
if(!pdo_fieldexists('tg_lottery', 'fk_goodsid')) {
	pdo_query("DROP TABLE IF EXISTS ".tablename('tg_lottery')."");
	pdo_query("CREATE TABLE IF NOT EXISTS  ".tablename('tg_lottery')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `gname` varchar(145) DEFAULT NULL,
	  `uniacid` int(11) DEFAULT NULL,
	  `status` int(11) DEFAULT NULL COMMENT '1进行2未开始3已结束4暂停',
	  `prize` varchar(445) DEFAULT NULL,
	  `createtime` varchar(145) DEFAULT NULL,
	  `fk_goodsid` int(11) DEFAULT NULL COMMENT '商品ID',
	  `num` int(11) DEFAULT NULL COMMENT '奖品数量',
	  `displayorder` int(11) DEFAULT NULL COMMENT '排序',
	  `lprice` decimal(10,2) DEFAULT NULL COMMENT '抽奖价',
	  `gprice` decimal(10,2) DEFAULT NULL COMMENT '团购价',
	  `groupnum` int(11) DEFAULT NULL COMMENT '团人数',
	  `starttime` varchar(145) DEFAULT NULL COMMENT '开始时间',
	  `endtime` varchar(145) DEFAULT NULL COMMENT '结束时间',
	  `dostatus` int(11) DEFAULT '0' COMMENT '1已抽奖',
	  `one_limit` int(11) DEFAULT NULL COMMENT '1单人可购买多次2不可',
	  `gdetaile` text COMMENT '图文详情',
	  `gimg` varchar(145) DEFAULT NULL,
	  `num2` int(11) DEFAULT NULL COMMENT '二等奖品数',
	  `num3` int(11) DEFAULT NULL COMMENT '三等数量',
	  `imgs` varchar(225) DEFAULT NULL COMMENT '图集',
	  `gdesc` text COMMENT '规则简介',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
}
if(!pdo_fieldexists('tg_group', 'lottery_id')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." ADD `lottery_id` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_group', 'iflottery')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." ADD `iflottery` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_group', 'lottery_status')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." ADD `lottery_status` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'lottery_status')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `lottery_status` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_order', 'lotteryid')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `lotteryid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_puv_record', 'status')) {
	pdo_query("ALTER TABLE ".tablename('tg_puv_record')." ADD `status` int(11)  NOT NULL;");
}
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_waittask')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `value` varchar(145) DEFAULT NULL,
  `key` varchar(145) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

/*缓存更新*/
if(!pdo_fieldexists('tg_goods', 'paysuccess')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `paysuccess` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '支付成功详情';");
}
if(!pdo_fieldexists('tg_goods', 'atlas')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `atlas` varchar(445) DEFAULT NULL COMMENT '图集';");
}

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_marketing')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `fk_goodsid` int(11) DEFAULT NULL COMMENT '外键goodsid',
  `type` int(11) DEFAULT NULL COMMENT '1满减2包邮3抵扣',
  `value` text COMMENT '设置的值',
  PRIMARY KEY (`id`),
  KEY `goodsidd` (`fk_goodsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品的营销';");

pdo_query("CREATE TABLE  IF NOT EXISTS ".tablename('tg_merchant_money_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `merchantid` int(11) DEFAULT NULL COMMENT '商家ID',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '变动金额',
  `createtime` varchar(145) DEFAULT NULL COMMENT '变动时间',
  `orderid` int(11) DEFAULT NULL COMMENT '订单ID',
  `type` int(11) DEFAULT NULL COMMENT '1支付成功2发货成功成为可结算金额3取消发货4商家结算5退款',
  `detail` text COMMENT '详情',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家金额记录';");

if(!pdo_fieldexists('tg_lottery', 'nogetmessage')) {
	pdo_query("ALTER TABLE ".tablename('tg_lottery')." ADD `nogetmessage` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_lottery', 'pattern')) {
	pdo_query("ALTER TABLE ".tablename('tg_lottery')." ADD `pattern` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_puv_record', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_puv_record')." ADD `merchantid` int(11)  NOT NULL;");
}
if(!pdo_fieldexists('tg_puv', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_puv')." ADD `merchantid` int(11)  NOT NULL;");
}
if(pdo_fieldexists('tg_goods', 'atlas')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." MODIFY `atlas` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '图集';");
}
if(!pdo_fieldexists('tg_order', 'marketing')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." add `marketing` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '图集';");
}
if(!pdo_fieldexists('tg_goods', 'g_type')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `g_type` int(2) NOT NULL DEFAULT 1 COMMENT '商品类型';");
}
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_credit1rechargerecord')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(245) NOT NULL,
  `num` varchar(100) NOT NULL COMMENT '充值金额',
  `createtime` varchar(145) NOT NULL,
  `transid` varchar(145) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0充值失败1充值成功',
  `paytype` int(2) NOT NULL,
  `orderno` varchar(145) NOT NULL COMMENT '订单号',
  `type` int(2) NOT NULL COMMENT '0充值并消费1仅充值3积分兑换',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

if(!pdo_fieldexists('tg_member', 'appopenid')) {
	pdo_query("ALTER TABLE ".tablename('tg_member')."  add `appopenid` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci;");
}
if(!pdo_fieldexists('tg_member', 'unionid')) {
	pdo_query("ALTER TABLE ".tablename('tg_member')."  add `unionid` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci;");
}
if(!pdo_fieldexists('tg_goods', 'repeatjoin')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `repeatjoin` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'visible_level')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `visible_level` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_group', 'endnum')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." add `endnum` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_banner', 'visible_level')) {
	pdo_query("ALTER TABLE ".tablename('tg_banner')." add `visible_level` int(11) NOT NULL;");
}

if(!pdo_fieldexists('tg_merchant', 'tag')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." add `tag` text");
}
if(!pdo_fieldexists('tg_goods_param', 'tagcontent')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods_param')." add `tagcontent` text");
}
if(!pdo_fieldexists('tg_goods', 'goodscode')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `goodscode` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci;");
}
if(!pdo_fieldexists('tg_category', 'visible_level')) {
	pdo_query("ALTER TABLE ".tablename('tg_category')." add `visible_level` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'visible_level')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `visible_level` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci;");
}
if(!pdo_fieldexists('tg_goods', 'category_parentid_top')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `category_parentid_top` int(11) NOT NULL;");
}
//定制地址数据表更新字段 2016-10-19
if(!pdo_fieldexists('tg_address', 'wlname')) {
	pdo_query("ALTER TABLE ".tablename('tg_address')." add `wlname` VARCHAR(32);");
}
if(!pdo_fieldexists('tg_address', 'wltel')) {
	pdo_query("ALTER TABLE ".tablename('tg_address')." add `wltel` VARCHAR(32);");
}
if(!pdo_fieldexists('tg_address', 'enterprise_name')) {
	pdo_query("ALTER TABLE ".tablename('tg_address')." add `enterprise_name` VARCHAR(255) NOT NULL;");
}
if(!pdo_fieldexists('tg_address', 'branch_name')) {
	pdo_query("ALTER TABLE ".tablename('tg_address')." add `branch_name` VARCHAR(255);");
}
//拼团有礼
if(!pdo_fieldexists('tg_goods', 'redbag')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `redbag` text;");
}else{
    pdo_query("ALTER TABLE".tablename('tg_goods')." modify column  redbag  text;");
}

if(!pdo_fieldexists('tg_goods', 'balance')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `balance` INT(11);");
}
if(pdo_fieldexists('tg_goods', 'hexiao_id')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." modify column hexiao_id text;");
}
if(!pdo_fieldexists('tg_goods', 'hexiaolimittime')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `hexiaolimittime` VARCHAR(145);");
}
//多商家字段
if(!pdo_fieldexists('tg_merchant', 'lng')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." add `lng` VARCHAR(145);");
}
if(!pdo_fieldexists('tg_merchant', 'lat')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." add `lat` VARCHAR(145);");
}
if(!pdo_fieldexists('tg_merchant_record', 'type')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant_record')." add `type` int(11);");
}
if(!pdo_fieldexists('tg_merchant_record', 'updatetime')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant_record')." add `updatetime` VARCHAR(145);");
}
if(!pdo_fieldexists('tg_merchant_record', 'status')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant_record')." add `status` int(11);");
}

//1.0.9更新字段
if(!pdo_fieldexists('tg_merchant_account', 'no_money_doing')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant_account')." add `no_money_doing` decimal(10,2) NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'comment')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `comment` INT(11);");
}

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_comment')." (
`id` int(11) NOT NULL AUTO_INCREMENT,
`goodsid` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`openid` varchar(300) NOT NULL,
`title` varchar(200) NOT NULL,
`detail` varchar(1000) NOT NULL,
`createtime` varchar(145) NOT NULL COMMENT '晒单时间',
`status` int(11) NOT NULL COMMENT '1待审核2通过3未通过',
`goodstitle` varchar(145) NOT NULL,
`thumbs` varchar(2048) NOT NULL COMMENT '图集',
`type` int(11) NOT NULL COMMENT '0:表示晒单；1：表示言论',
`speechcount` int(11) NOT NULL COMMENT '评论条数',
`count` int(11) NOT NULL COMMENT '被赞次数',
`praise` text NOT NULL COMMENT '赞的人',
`sid` int(11) DEFAULT NULL COMMENT '商家ID',
`mid` int(11) DEFAULT NULL COMMENT '会员ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('tg_discuss')." (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动排序',
`openid` varchar(445) NOT NULL COMMENT '评论者openid',
`content` varchar(225) NOT NULL COMMENT '评论类容',
`parentid` int(11) NOT NULL COMMENT '晒单或者讨论id',
`status` int(11) NOT NULL COMMENT '状态',
`createtime` varchar(32) NOT NULL COMMENT '创建时间',
`uniacid` int(11) NOT NULL COMMENT '公众号id',
`commentid` int(11) DEFAULT NULL,
`goodsid` int(11) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表'");
//黑--锐--源--码--社区bbs.---heirui---.cn
if(!pdo_fieldexists('tg_discuss', 'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('tg_discuss')." add `merchantid` INT(11) DEFAULT 0;");
}
if(!pdo_fieldexists('tg_goods', 'prize')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `prize` INT(11) DEFAULT 0;");
}
if(!pdo_fieldexists('tg_category', 'open')) {
	pdo_query("ALTER TABLE ".tablename('tg_category')." add `open` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_goods', 'share_group')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `share_group` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_goods', 'hexiaolimittimetype')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `hexiaolimittimetype` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_goods', 'share_image_group')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `share_image_group` varchar(445);");
}
if(!pdo_fieldexists('tg_goods', 'share_title_group')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `share_title_group` varchar(445);");
}
if(!pdo_fieldexists('tg_goods', 'share_desc_group')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `share_desc_group` text;");
}

//参团提醒
if(!pdo_fieldexists('tg_goods', 'lacktimetip')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." add `lacktimetip` decimal(10,2) DEFAULT '0.00' COMMENT '剩余小时';");
}
if(!pdo_fieldexists('tg_group', 'lacktimetip')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." add `lacktimetip` decimal(10,2) DEFAULT '0.00' COMMENT '剩余小时';");
}
if(!pdo_fieldexists('tg_group', 'iftip')) {
	pdo_query("ALTER TABLE ".tablename('tg_group')." add `iftip`  int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_lottery', 'ceshi')) {
	pdo_query("ALTER TABLE ".tablename('tg_lottery')." add `ceshi`  int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_user_node','flag')){
	pdo_query("truncate table".tablename('tg_lottery'));
	pdo_query("ALTER TABLE ".tablename('tg_user_node')." add `flag`  int(11) DEFAULT '0';");
}
//2017.5.4
if(!pdo_fieldexists('tg_store', 'storehours')) {
	pdo_query("ALTER TABLE ".tablename('tg_store')." ADD `storehours` VARCHAR(100);");
}
//2017.5.11
if(!pdo_fieldexists('tg_goods', 'is_own')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `is_own` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_merchant', 'kefuimg')) {
	pdo_query("ALTER TABLE ".tablename('tg_merchant')." ADD `kefuimg` VARCHAR(225);");
}
//2017.5.26
if(!pdo_fieldexists('tg_goods', 'noticetime')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `noticetime` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_order', 'limitnotice')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `limitnotice` int(11) DEFAULT '0';");
}
//2017.6.13
if(!pdo_fieldexists('tg_goods', 'is_norefund')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `is_norefund` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_goods', 'stockstatus')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `stockstatus` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_goods', 'forcegroup')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `forcegroup` int(11) DEFAULT '0';");
}
//2017.6.23
if(!pdo_fieldexists('tg_order', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `uid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_order', 'mid')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `mid` int(11) DEFAULT '0';");
}
//2017.6.29
if(!pdo_fieldexists('tg_discuss', 'star')) {
	pdo_query("ALTER TABLE ".tablename('tg_discuss')." ADD `star` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('tg_discuss', 'orderid')) {
	pdo_query("ALTER TABLE ".tablename('tg_discuss')." ADD `orderid` int(11) DEFAULT '0';");
}
//2017.7.3
if(!pdo_fieldexists('tg_discuss', 'storereply')) {
	pdo_query("ALTER TABLE ".tablename('tg_discuss')." ADD `storereply` VARCHAR(445);");
}
//2017.7.17
if(!pdo_fieldexists('tg_goods', 'norefundnotice')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `norefundnotice` int(11) DEFAULT '0';");
}
//2017.7.20
if(!pdo_fieldexists('tg_coupon_template', 'goodsid')) {
	pdo_query("ALTER TABLE ".tablename('tg_coupon_template')." ADD `goodsid` int(11) DEFAULT '0';");
} 
//2017.7.21
if(!pdo_fieldexists('tg_goods', 'givecouponid')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `givecouponid` int(11) DEFAULT '0';");
} 
//2017.08.19
if(pdo_fieldexists('tg_goods_option', 'costprice')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods_option')." modify column `costprice` varchar(50) NOT NULL;");
}
//2017.10.30
if(pdo_fieldexists('tg_order', 'failrefund')) {
	pdo_query("ALTER TABLE ".tablename('tg_order')." ADD `failrefund` int(11) DEFAULT '0';");
}
//2018.05.16
if(!pdo_fieldexists('tg_goods', 'ispresell')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `ispresell` tinyint(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'preselltimestart')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `preselltimestart` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'preselltimeend')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `preselltimeend` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'presellsendtype')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `presellsendtype` tinyint(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'presellsendstatrttime')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `presellsendstatrttime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('tg_goods', 'presellsendtime')) {
	pdo_query("ALTER TABLE ".tablename('tg_goods')." ADD `presellsendtime` int(11) NOT NULL;");
}
