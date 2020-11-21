<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `linkurl` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL COMMENT '位置',
  `agent_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_ad','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_ad')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_ad','name')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_ad')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_ad','linkurl')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_ad')." ADD   `linkurl` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_ad','thumb')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_ad')." ADD   `thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_ad','position')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_ad')." ADD   `position` int(11) DEFAULT NULL COMMENT '位置'");}
if(!pdo_fieldexists('liuer_mcar_ad','agent_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_ad')." ADD   `agent_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_ad','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_ad')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_ad','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_ad')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_ad','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_ad')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_agent` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `auto_level` int(11) DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `linkurl` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `sort` int(11) DEFAULT '1',
  `status` int(11) DEFAULT '9',
  `is_show` int(11) DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_agent','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_agent','name')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_agent','auto_level')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `auto_level` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_agent','address')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_agent','latitude')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `latitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_agent','longitude')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `longitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_agent','mobile')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `mobile` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_agent','linkurl')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `linkurl` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_agent','thumb')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图'");}
if(!pdo_fieldexists('liuer_mcar_agent','sort')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `sort` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('liuer_mcar_agent','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_agent','is_show')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `is_show` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('liuer_mcar_agent','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_agent','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_agent')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `linkurl` varchar(255) DEFAULT NULL,
  `agent_id` int(11) DEFAULT '0',
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_category','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_category')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_category','name')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_category')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_category','icon')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_category')." ADD   `icon` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_category','linkurl')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_category')." ADD   `linkurl` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_category','agent_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_category')." ADD   `agent_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_category','sort')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_category')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_category','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_category')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_category','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_category')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_category','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_category')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_codes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) unsigned DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `log_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_codes','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_codes','no')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes')." ADD   `no` int(11) unsigned DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes','code')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes')." ADD   `code` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes','log_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes')." ADD   `log_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes','agent_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes')." ADD   `agent_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_codes','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes','updated_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes')." ADD   `updated_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_codes_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ordersn` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_codes_log','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes_log')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_codes_log','ordersn')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes_log')." ADD   `ordersn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes_log','count')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes_log')." ADD   `count` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes_log','agent_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes_log')." ADD   `agent_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes_log','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes_log')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_codes_log','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes_log')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes_log','created_by')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes_log')." ADD   `created_by` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_codes_log','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_codes_log')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `log_id` int(11) DEFAULT NULL,
  `star` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `from_openid` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `to_openid` varchar(255) DEFAULT '',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_feedback','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_feedback','log_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD   `log_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_feedback','star')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD   `star` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_feedback','title')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_feedback','content')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD   `content` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_feedback','from_openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD   `from_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_feedback','user_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_feedback','to_openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD   `to_openid` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('liuer_mcar_feedback','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_feedback','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_feedback')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_fenxiao` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_fenxiao','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_fenxiao','name')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao')." ADD   `name` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_fenxiao','price')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao')." ADD   `price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_fenxiao','endtime')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao')." ADD   `endtime` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_fenxiao','remark')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao')." ADD   `remark` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_fenxiao','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_fenxiao','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_fenxiao','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_fenxiao_rel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(11) DEFAULT NULL,
  `is_type` int(11) DEFAULT '1' COMMENT '1为商品 2为会员',
  `percent` int(11) DEFAULT NULL COMMENT '比例',
  `fx_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_fenxiao_rel','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao_rel')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_fenxiao_rel','good_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao_rel')." ADD   `good_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_fenxiao_rel','is_type')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao_rel')." ADD   `is_type` int(11) DEFAULT '1' COMMENT '1为商品 2为会员'");}
if(!pdo_fieldexists('liuer_mcar_fenxiao_rel','percent')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao_rel')." ADD   `percent` int(11) DEFAULT NULL COMMENT '比例'");}
if(!pdo_fieldexists('liuer_mcar_fenxiao_rel','fx_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao_rel')." ADD   `fx_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_fenxiao_rel','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao_rel')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_fenxiao_rel','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao_rel')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_fenxiao_rel','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_fenxiao_rel')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL COMMENT '库存',
  `desc` varchar(255) DEFAULT NULL,
  `content` text COMMENT '详情',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `cat_id` int(11) DEFAULT NULL COMMENT '分类id',
  `agent_id` int(11) DEFAULT '0',
  `is_fx` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_goods','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_goods','title')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_goods','thumb')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_goods','price')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_goods','stock')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `stock` int(11) DEFAULT NULL COMMENT '库存'");}
if(!pdo_fieldexists('liuer_mcar_goods','desc')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `desc` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_goods','content')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('liuer_mcar_goods','sort')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `sort` int(11) DEFAULT NULL COMMENT '排序'");}
if(!pdo_fieldexists('liuer_mcar_goods','cat_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `cat_id` int(11) DEFAULT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('liuer_mcar_goods','agent_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `agent_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_goods','is_fx')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `is_fx` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_goods','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_goods','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_goods','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_goods')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `is_fx` int(11) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT '持续天数',
  `private_minute` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_group','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_group','name')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `name` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_group','price')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_group','is_fx')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `is_fx` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_group','remark')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `remark` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_group','duration')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `duration` int(11) DEFAULT NULL COMMENT '持续天数'");}
if(!pdo_fieldexists('liuer_mcar_group','private_minute')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `private_minute` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_group','sort')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_group','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_group','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_group','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_group')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_help` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `content` text,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT '0',
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_help','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_help','title')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_help','source')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `source` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_help','author')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `author` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_help','content')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `content` text");}
if(!pdo_fieldexists('liuer_mcar_help','sort')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_help','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_help','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_help','updated_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `updated_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_help','agent_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `agent_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_help','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_help')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `icon_hover` varchar(255) DEFAULT NULL,
  `linkurl` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_menu','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_menu','name')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_menu','color')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `color` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_menu','icon')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `icon` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_menu','icon_hover')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `icon_hover` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_menu','linkurl')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `linkurl` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_menu','sort')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_menu','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_menu','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_menu','agent_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `agent_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_menu','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_menu')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `log_id` int(11) DEFAULT NULL,
  `star` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `from_openid` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `to_openid` varchar(255) DEFAULT '',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_message','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_message','log_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD   `log_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_message','star')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD   `star` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_message','title')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_message','content')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD   `content` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_message','from_openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD   `from_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_message','user_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_message','to_openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD   `to_openid` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('liuer_mcar_message','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_message','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_message')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_movelogs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_openid` varchar(255) DEFAULT NULL,
  `to_openid` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `chepaihao` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `code_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `unique` varchar(255) DEFAULT NULL,
  `way` int(11) DEFAULT NULL,
  `isread` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '9' COMMENT '9未处理 10已处理',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_movelogs','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_movelogs','from_openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `from_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','to_openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `to_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','user_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','chepaihao')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `chepaihao` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','remark')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `remark` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','code_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `code_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','address')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','latitude')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `latitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','longitude')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `longitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','unique')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `unique` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','way')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `way` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','isread')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `isread` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_movelogs','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `status` int(11) DEFAULT '9' COMMENT '9未处理 10已处理'");}
if(!pdo_fieldexists('liuer_mcar_movelogs','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','updated_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `updated_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_movelogs','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_movelogs')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ordersn` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `truename` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `shipping_name` varchar(255) DEFAULT NULL COMMENT '快递公司',
  `shipping_no` varchar(255) DEFAULT NULL COMMENT '快递单号',
  `shipping_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `good_id` int(11) DEFAULT NULL,
  `good_name` varchar(255) DEFAULT NULL,
  `good_number` int(11) DEFAULT '1',
  `buyer_message` varchar(255) DEFAULT NULL,
  `order_type` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_order','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_order','ordersn')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `ordersn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','price')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','truename')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `truename` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','mobile')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `mobile` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','address')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `status` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_order','shipping_name')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `shipping_name` varchar(255) DEFAULT NULL COMMENT '快递公司'");}
if(!pdo_fieldexists('liuer_mcar_order','shipping_no')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `shipping_no` varchar(255) DEFAULT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('liuer_mcar_order','shipping_time')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `shipping_time` int(11) DEFAULT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('liuer_mcar_order','good_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `good_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','good_name')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `good_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','good_number')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `good_number` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('liuer_mcar_order','buyer_message')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `buyer_message` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','order_type')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `order_type` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','user_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','updated_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `updated_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_order','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_order')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone_no` varchar(255) DEFAULT NULL,
  `pool_key` varchar(255) DEFAULT NULL,
  `sub_id` varchar(255) DEFAULT NULL,
  `call_time` varchar(255) DEFAULT NULL,
  `peer_no` varchar(255) DEFAULT NULL,
  `release_dir` varchar(255) DEFAULT NULL,
  `ring_time` varchar(255) DEFAULT NULL,
  `call_id` varchar(255) DEFAULT NULL,
  `start_time` varchar(255) DEFAULT NULL,
  `fid` varchar(255) DEFAULT NULL,
  `partner_key` varchar(255) DEFAULT NULL,
  `out_id` varchar(255) DEFAULT NULL,
  `release_time` varchar(255) DEFAULT NULL,
  `free_ring_time` varchar(255) DEFAULT NULL,
  `control_type` varchar(255) DEFAULT NULL,
  `release_cause` varchar(255) DEFAULT NULL,
  `control_msg` varchar(255) DEFAULT NULL,
  `secret_no` varchar(255) DEFAULT NULL,
  `call_out_time` varchar(255) DEFAULT NULL,
  `call_type` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `called_display_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_queue','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_queue','phone_no')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `phone_no` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','pool_key')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `pool_key` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','sub_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `sub_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','call_time')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `call_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','peer_no')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `peer_no` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','release_dir')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `release_dir` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','ring_time')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `ring_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','call_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `call_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','start_time')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `start_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','fid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `fid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','partner_key')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `partner_key` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','out_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `out_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','release_time')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `release_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','free_ring_time')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `free_ring_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','control_type')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `control_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','release_cause')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `release_cause` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','control_msg')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `control_msg` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','secret_no')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `secret_no` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','call_out_time')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `call_out_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','call_type')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `call_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_queue','called_display_no')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_queue')." ADD   `called_display_no` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_sms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '9' COMMENT '9正常 0为过期',
  `openid` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `virtual` int(11) DEFAULT '0',
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_sms','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_sms')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_sms','mobile')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_sms')." ADD   `mobile` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_sms','code')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_sms')." ADD   `code` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_sms','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_sms')." ADD   `status` int(11) DEFAULT '9' COMMENT '9正常 0为过期'");}
if(!pdo_fieldexists('liuer_mcar_sms','openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_sms')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_sms','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_sms')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_sms','virtual')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_sms')." ADD   `virtual` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_sms','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_sms')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `chepaihao` varchar(255) DEFAULT NULL COMMENT '车牌号',
  `mobile` varchar(255) DEFAULT NULL COMMENT '手机号',
  `openid` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9' COMMENT '状态',
  `code_id` int(11) DEFAULT NULL COMMENT 'codes表',
  `count` int(11) DEFAULT '1' COMMENT '绑定次数',
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_users','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_users')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_users','chepaihao')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_users')." ADD   `chepaihao` varchar(255) DEFAULT NULL COMMENT '车牌号'");}
if(!pdo_fieldexists('liuer_mcar_users','mobile')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_users')." ADD   `mobile` varchar(255) DEFAULT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('liuer_mcar_users','openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_users')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_users','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_users')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_users','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_users')." ADD   `status` int(11) DEFAULT '9' COMMENT '状态'");}
if(!pdo_fieldexists('liuer_mcar_users','code_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_users')." ADD   `code_id` int(11) DEFAULT NULL COMMENT 'codes表'");}
if(!pdo_fieldexists('liuer_mcar_users','count')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_users')." ADD   `count` int(11) DEFAULT '1' COMMENT '绑定次数'");}
if(!pdo_fieldexists('liuer_mcar_users','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_users')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_vip` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT '0' COMMENT '所属会员组',
  `fx_id` int(11) DEFAULT '0',
  `expire_time` int(11) DEFAULT NULL COMMENT '到期时间',
  `openid` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `is_private` int(11) DEFAULT '0',
  `private_minute` int(11) DEFAULT NULL,
  `is_saorao` int(11) DEFAULT '0' COMMENT '是否开启免打扰',
  `starttime` varchar(255) DEFAULT NULL COMMENT '开启时间',
  `endtime` varchar(255) DEFAULT NULL COMMENT '结束时间',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `synctime` int(11) DEFAULT NULL,
  `generate` int(11) DEFAULT '0',
  `pid` int(11) DEFAULT '0',
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_vip','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_vip','gid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `gid` int(11) DEFAULT '0' COMMENT '所属会员组'");}
if(!pdo_fieldexists('liuer_mcar_vip','fx_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `fx_id` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_vip','expire_time')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `expire_time` int(11) DEFAULT NULL COMMENT '到期时间'");}
if(!pdo_fieldexists('liuer_mcar_vip','openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_vip','uid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_vip','is_private')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `is_private` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_vip','private_minute')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `private_minute` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_vip','is_saorao')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `is_saorao` int(11) DEFAULT '0' COMMENT '是否开启免打扰'");}
if(!pdo_fieldexists('liuer_mcar_vip','starttime')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `starttime` varchar(255) DEFAULT NULL COMMENT '开启时间'");}
if(!pdo_fieldexists('liuer_mcar_vip','endtime')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `endtime` varchar(255) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('liuer_mcar_vip','latitude')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `latitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_vip','longitude')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `longitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_vip','synctime')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `synctime` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_vip','generate')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `generate` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_vip','pid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `pid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_vip','sort')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_vip','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_vip','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_vip','updated_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `updated_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_vip','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_vip')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_virtuals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `log_id` int(11) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `secret_no` varchar(255) DEFAULT NULL,
  `subsid` varchar(255) DEFAULT NULL,
  `from_openid` varchar(255) DEFAULT NULL,
  `to_openid` varchar(255) DEFAULT NULL,
  `platform` int(11) DEFAULT '1',
  `is_use` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '9',
  `created_at` int(11) DEFAULT NULL,
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_virtuals','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_virtuals','log_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `log_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_virtuals','mobile')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `mobile` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_virtuals','user_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_virtuals','secret_no')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `secret_no` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_virtuals','subsid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `subsid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_virtuals','from_openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `from_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_virtuals','to_openid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `to_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_virtuals','platform')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `platform` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('liuer_mcar_virtuals','is_use')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `is_use` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_virtuals','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `status` int(11) DEFAULT '9'");}
if(!pdo_fieldexists('liuer_mcar_virtuals','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_virtuals','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_virtuals')." ADD   `weid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_liuer_mcar_yongjin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `fuid` int(11) DEFAULT NULL,
  `mark` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '1' COMMENT '1商品 2是会员',
  `order_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `weid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('liuer_mcar_yongjin','id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('liuer_mcar_yongjin','uid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_yongjin','fuid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `fuid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_yongjin','mark')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `mark` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_yongjin','type')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `type` int(11) DEFAULT '1' COMMENT '1商品 2是会员'");}
if(!pdo_fieldexists('liuer_mcar_yongjin','order_id')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_yongjin','money')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `money` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_yongjin','created_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `created_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_yongjin','updated_at')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `updated_at` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('liuer_mcar_yongjin','status')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `status` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('liuer_mcar_yongjin','weid')) {pdo_query("ALTER TABLE ".tablename('liuer_mcar_yongjin')." ADD   `weid` int(11) DEFAULT NULL");}
