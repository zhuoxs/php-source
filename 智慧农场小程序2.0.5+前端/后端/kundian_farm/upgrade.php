<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `phone` char(20) NOT NULL COMMENT '联系电话',
  `send_price` float NOT NULL COMMENT '配送费',
  `add_price` float NOT NULL COMMENT '加工费',
  `vet_banner` text NOT NULL COMMENT '兽医页面banner',
  `home_title` char(100) NOT NULL COMMENT '首页标题',
  `sign_integral` float NOT NULL COMMENT '签到获取积分',
  `pay_integral` float NOT NULL COMMENT '支付获取积分',
  `sign_banner` text NOT NULL COMMENT '签到banner',
  `sign_rule` text NOT NULL COMMENT '积分规则',
  `is_open_vet` tinyint(1) NOT NULL COMMENT '是否开启兽医版块',
  `bar_title` char(50) NOT NULL COMMENT '首页顶部标题',
  `farm_name` char(100) NOT NULL COMMENT '农场名称',
  `farm_desc` text NOT NULL COMMENT '农场描述',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_about','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `phone` char(20) NOT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','send_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `send_price` float NOT NULL COMMENT '配送费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','add_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `add_price` float NOT NULL COMMENT '加工费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','vet_banner')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `vet_banner` text NOT NULL COMMENT '兽医页面banner'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','home_title')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `home_title` char(100) NOT NULL COMMENT '首页标题'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','sign_integral')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `sign_integral` float NOT NULL COMMENT '签到获取积分'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','pay_integral')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `pay_integral` float NOT NULL COMMENT '支付获取积分'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','sign_banner')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `sign_banner` text NOT NULL COMMENT '签到banner'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','sign_rule')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `sign_rule` text NOT NULL COMMENT '积分规则'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','is_open_vet')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `is_open_vet` tinyint(1) NOT NULL COMMENT '是否开启兽医版块'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','bar_title')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `bar_title` char(50) NOT NULL COMMENT '首页顶部标题'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','farm_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `farm_name` char(100) NOT NULL COMMENT '农场名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','farm_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   `farm_desc` text NOT NULL COMMENT '农场描述'");}
if(!pdo_fieldexists('ims_cqkundian_farm_about','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_about')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `region` char(100) NOT NULL,
  `address` char(200) NOT NULL,
  `name` char(50) NOT NULL,
  `phone` char(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL COMMENT '1默认 0其他',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_address','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_address')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_address','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_address')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_address','region')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_address')." ADD   `region` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_address','address')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_address')." ADD   `address` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_address','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_address')." ADD   `name` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_address','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_address')." ADD   `phone` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_address')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_address','is_default')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_address')." ADD   `is_default` tinyint(1) NOT NULL COMMENT '1默认 0其他'");}
if(!pdo_fieldexists('ims_cqkundian_farm_address','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_address')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_animal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `animal_name` char(100) NOT NULL COMMENT '动物名称',
  `animal_src` text NOT NULL COMMENT '动物图片',
  `price` float NOT NULL COMMENT '领养价格',
  `price_desc` char(200) NOT NULL COMMENT '价格说明',
  `animal_type` char(50) NOT NULL COMMENT '动物品种',
  `live_rate` float NOT NULL COMMENT '存活率',
  `adopt_desc` text NOT NULL COMMENT '营养价值',
  `mature_period` int(11) NOT NULL COMMENT '成熟期',
  `meat_quality` char(100) NOT NULL COMMENT '肉质',
  `animal_num` char(20) NOT NULL COMMENT '编号',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `animal_slide` text NOT NULL COMMENT '轮播图',
  `is_putaway` tinyint(1) NOT NULL COMMENT '0/下架 1/上架',
  `is_recommend` tinyint(1) NOT NULL COMMENT '0/不推荐1/推荐',
  `is_open_sku` tinyint(1) NOT NULL COMMENT '0/关闭1/开启',
  `animal_desc` char(200) NOT NULL COMMENT '说明',
  `animal_rule` text NOT NULL COMMENT '领养规则',
  `count` int(11) NOT NULL,
  `sale_count` int(11) NOT NULL,
  `live_id` text NOT NULL COMMENT '监控ID',
  `detail_desc` text NOT NULL,
  `gain_desc` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_animal','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','animal_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `animal_name` char(100) NOT NULL COMMENT '动物名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','animal_src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `animal_src` text NOT NULL COMMENT '动物图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `price` float NOT NULL COMMENT '领养价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','price_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `price_desc` char(200) NOT NULL COMMENT '价格说明'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','animal_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `animal_type` char(50) NOT NULL COMMENT '动物品种'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','live_rate')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `live_rate` float NOT NULL COMMENT '存活率'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','adopt_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `adopt_desc` text NOT NULL COMMENT '营养价值'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','mature_period')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `mature_period` int(11) NOT NULL COMMENT '成熟期'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','meat_quality')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `meat_quality` char(100) NOT NULL COMMENT '肉质'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','animal_num')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `animal_num` char(20) NOT NULL COMMENT '编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','animal_slide')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `animal_slide` text NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','is_putaway')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `is_putaway` tinyint(1) NOT NULL COMMENT '0/下架 1/上架'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','is_recommend')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `is_recommend` tinyint(1) NOT NULL COMMENT '0/不推荐1/推荐'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','is_open_sku')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `is_open_sku` tinyint(1) NOT NULL COMMENT '0/关闭1/开启'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','animal_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `animal_desc` char(200) NOT NULL COMMENT '说明'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','animal_rule')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `animal_rule` text NOT NULL COMMENT '领养规则'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','sale_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `sale_count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','live_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `live_id` text NOT NULL COMMENT '监控ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','detail_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `detail_desc` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','gain_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   `gain_desc` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_animal_adopt` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(11) NOT NULL COMMENT '微擎uid',
  `aid` int(11) NOT NULL COMMENT '动物id',
  `create_time` int(11) NOT NULL COMMENT '领养时间',
  `status` tinyint(1) NOT NULL COMMENT '0/未支付 1/待确定 2/l领养成功 3/死亡 4/已成熟 5/已宰杀斌配送',
  `adopt_day` int(11) NOT NULL COMMENT '已喂养天数',
  `predict_ripe` int(11) NOT NULL COMMENT '预计成熟期',
  `uniacid` int(11) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT '订单编号',
  `today_time` int(11) NOT NULL,
  `adopt_number` char(100) NOT NULL,
  `order_number` char(200) NOT NULL,
  `weight` float NOT NULL,
  `sale_price` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `uid` int(11) NOT NULL COMMENT '微擎uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','aid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `aid` int(11) NOT NULL COMMENT '动物id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `create_time` int(11) NOT NULL COMMENT '领养时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/未支付 1/待确定 2/l领养成功 3/死亡 4/已成熟 5/已宰杀斌配送'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','adopt_day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `adopt_day` int(11) NOT NULL COMMENT '已喂养天数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','predict_ripe')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `predict_ripe` int(11) NOT NULL COMMENT '预计成熟期'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `order_id` int(11) NOT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','today_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `today_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','adopt_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `adopt_number` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','order_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `order_number` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','weight')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `weight` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','sale_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   `sale_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_animal_adopt_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txt` text NOT NULL,
  `src` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `adopt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt_status','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt_status')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt_status','txt')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt_status')." ADD   `txt` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt_status','src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt_status')." ADD   `src` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt_status','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt_status')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt_status','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt_status')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt_status','adopt_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt_status')." ADD   `adopt_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_adopt_status','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_adopt_status')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_animal_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` char(30) NOT NULL,
  `uid` int(11) NOT NULL,
  `aid` int(11) NOT NULL COMMENT '动物ID',
  `count` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/未支付1已支付 2/已发货 ',
  `pay_method` char(30) NOT NULL COMMENT '支付方式',
  `pra_price` float NOT NULL COMMENT '实际支付金额',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `uniacid` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL COMMENT '规格ID',
  `body` char(50) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_price` float NOT NULL,
  `username` char(50) NOT NULL,
  `phone` char(20) NOT NULL,
  `uniontid` char(200) NOT NULL,
  `is_price` tinyint(1) NOT NULL,
  `one_price` float NOT NULL,
  `two_price` float NOT NULL,
  `is_recycle` tinyint(1) NOT NULL,
  `pay_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','order_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `order_number` char(30) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','aid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `aid` int(11) NOT NULL COMMENT '动物ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','total_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `total_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/未支付1已支付 2/已发货 '");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','pay_method')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `pay_method` char(30) NOT NULL COMMENT '支付方式'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','pra_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `pra_price` float NOT NULL COMMENT '实际支付金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `spec_id` int(11) NOT NULL COMMENT '规格ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','body')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `body` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','coupon_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `coupon_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','coupon_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `coupon_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','username')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `username` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `phone` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','uniontid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `uniontid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','is_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `is_price` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','one_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `one_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','two_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `two_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','is_recycle')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `is_recycle` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   `pay_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_animal_sku` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `sku_name` char(100) NOT NULL COMMENT 'sku名称',
  `price` float NOT NULL COMMENT '价格',
  `count` int(11) NOT NULL COMMENT '库存',
  `spec_num` char(20) NOT NULL COMMENT '货号',
  `spec_src` text NOT NULL COMMENT '规格图片',
  `aid` int(11) NOT NULL COMMENT '商品id',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_animal_sku','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_sku')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_sku','sku_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_sku')." ADD   `sku_name` char(100) NOT NULL COMMENT 'sku名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_sku','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_sku')." ADD   `price` float NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_sku','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_sku')." ADD   `count` int(11) NOT NULL COMMENT '库存'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_sku','spec_num')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_sku')." ADD   `spec_num` char(20) NOT NULL COMMENT '货号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_sku','spec_src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_sku')." ADD   `spec_src` text NOT NULL COMMENT '规格图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_sku','aid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_sku')." ADD   `aid` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_sku','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_sku')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_sku','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_sku')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_animal_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` char(100) NOT NULL COMMENT '规格名称',
  `aid` int(11) NOT NULL COMMENT '动物id',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec')." ADD   `name` char(100) NOT NULL COMMENT '规格名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec','aid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec')." ADD   `aid` int(11) NOT NULL COMMENT '动物id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_animal_spec_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `spec_id` int(11) NOT NULL COMMENT '规格id',
  `spec_value` char(100) NOT NULL COMMENT '规格值',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec_value')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec_value','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec_value')." ADD   `spec_id` int(11) NOT NULL COMMENT '规格id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec_value','spec_value')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec_value')." ADD   `spec_value` char(100) NOT NULL COMMENT '规格值'");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec_value','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec_value')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_animal_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_animal_spec_value')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT '分类ID',
  `title` char(200) NOT NULL COMMENT '标题',
  `cover` text NOT NULL COMMENT '封面',
  `content` text NOT NULL COMMENT '内容',
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `view_count` int(11) NOT NULL COMMENT '浏览量',
  `is_video` tinyint(1) NOT NULL DEFAULT '0',
  `video_src` text NOT NULL,
  `mode` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_article','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','type_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `type_id` int(11) NOT NULL COMMENT '分类ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','title')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `title` char(200) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `cover` text NOT NULL COMMENT '封面'");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','content')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `content` text NOT NULL COMMENT '内容'");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','view_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `view_count` int(11) NOT NULL COMMENT '浏览量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','is_video')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `is_video` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','video_src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `video_src` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','mode')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   `mode` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_cqkundian_farm_article','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_article_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` char(50) NOT NULL,
  `rank` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_article_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_article_type','type_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article_type')." ADD   `type_name` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_article_type','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article_type')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_article_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article_type')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_article_type','is_default')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article_type')." ADD   `is_default` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_article_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_article_type')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_num` char(200) NOT NULL COMMENT '卡号',
  `card_pwd` char(200) NOT NULL COMMENT '密码',
  `import_time` int(11) NOT NULL COMMENT '导入时间',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `status` tinyint(1) NOT NULL COMMENT '0/未激活 1/已激活 2/已过期',
  `uniacid` int(11) NOT NULL,
  `use_time` int(11) NOT NULL COMMENT '使用时间',
  `expire_time` int(11) NOT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_card','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_card','card_num')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD   `card_num` char(200) NOT NULL COMMENT '卡号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_card','card_pwd')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD   `card_pwd` char(200) NOT NULL COMMENT '密码'");}
if(!pdo_fieldexists('ims_cqkundian_farm_card','import_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD   `import_time` int(11) NOT NULL COMMENT '导入时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_card','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD   `uid` int(11) NOT NULL COMMENT '用户uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_card','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/未激活 1/已激活 2/已过期'");}
if(!pdo_fieldexists('ims_cqkundian_farm_card','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_card','use_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD   `use_time` int(11) NOT NULL COMMENT '使用时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_card','expire_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD   `expire_time` int(11) NOT NULL COMMENT '过期时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_card','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_card')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price` float NOT NULL,
  `goods_name` char(200) NOT NULL,
  `cover` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_cart','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   `goods_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   `price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','goods_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   `goods_name` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   `cover` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   `spec_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_cart','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_cart')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `score` int(11) NOT NULL COMMENT '分数 12345',
  `src` text NOT NULL COMMENT '图片',
  `content` text NOT NULL COMMENT '评论内容',
  `create_time` int(11) NOT NULL COMMENT '评论时间',
  `order_id` int(11) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '用户UId',
  `uniacid` int(11) NOT NULL COMMENT '小程序编号',
  `status` tinyint(1) NOT NULL COMMENT '0 显示 1 隐藏',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_comment','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','score')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   `score` int(11) NOT NULL COMMENT '分数 12345'");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   `src` text NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','content')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   `content` text NOT NULL COMMENT '评论内容'");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   `create_time` int(11) NOT NULL COMMENT '评论时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   `order_id` int(11) NOT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   `uid` int(11) NOT NULL COMMENT '用户UId'");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   `status` tinyint(1) NOT NULL COMMENT '0 显示 1 隐藏'");}
if(!pdo_fieldexists('ims_cqkundian_farm_comment','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_comment')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_name` char(50) NOT NULL COMMENT '设备名称',
  `device_num` char(200) NOT NULL COMMENT '设备号',
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `mac` char(100) NOT NULL,
  `did` char(100) NOT NULL,
  `remark` char(100) NOT NULL,
  `dev_alias` char(100) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_device','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','device_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `device_name` char(50) NOT NULL COMMENT '设备名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','device_num')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `device_num` char(200) NOT NULL COMMENT '设备号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','mac')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `mac` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','did')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `did` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `remark` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','dev_alias')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `dev_alias` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','update_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   `update_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_device','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_device')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_distribution_check` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `username` char(100) NOT NULL COMMENT '用户名',
  `phone` char(20) NOT NULL COMMENT '联系电话',
  `status` tinyint(4) NOT NULL COMMENT '审核状态 0--未审核 1--审核通过 2--拒绝',
  `create_time` int(11) NOT NULL,
  `remark` text NOT NULL COMMENT '商家备注',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_distribution_check','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_distribution_check')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_distribution_check','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_distribution_check')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_distribution_check','username')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_distribution_check')." ADD   `username` char(100) NOT NULL COMMENT '用户名'");}
if(!pdo_fieldexists('ims_cqkundian_farm_distribution_check','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_distribution_check')." ADD   `phone` char(20) NOT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ims_cqkundian_farm_distribution_check','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_distribution_check')." ADD   `status` tinyint(4) NOT NULL COMMENT '审核状态 0--未审核 1--审核通过 2--拒绝'");}
if(!pdo_fieldexists('ims_cqkundian_farm_distribution_check','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_distribution_check')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_distribution_check','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_distribution_check')." ADD   `remark` text NOT NULL COMMENT '商家备注'");}
if(!pdo_fieldexists('ims_cqkundian_farm_distribution_check','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_distribution_check')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_distribution_check','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_distribution_check')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `create_time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_employee','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_employee')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_employee','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_employee')." ADD   `uid` int(11) NOT NULL COMMENT '用户uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_employee','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_employee')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_employee','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_employee')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_employee','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_employee')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_form_id` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `formid` char(200) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `openid` char(200) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_form_id','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_form_id')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_form_id','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_form_id')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_form_id','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_form_id')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_form_id','formid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_form_id')." ADD   `formid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_form_id','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_form_id')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_form_id','openid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_form_id')." ADD   `openid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_form_id','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_form_id')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_form_id','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_form_id')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_freight_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL COMMENT '规则名称',
  `charge_type` int(11) NOT NULL COMMENT '计费方式（1/按重量 2/按件）',
  `first_piece` float NOT NULL COMMENT '首重/件',
  `first_price` float NOT NULL COMMENT '首费（元）',
  `second_piece` float NOT NULL COMMENT '续重/件',
  `second_price` float NOT NULL COMMENT '续费（元）',
  `status` tinyint(1) NOT NULL COMMENT '是否默认 1默认',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD   `name` char(50) NOT NULL COMMENT '规则名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','charge_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD   `charge_type` int(11) NOT NULL COMMENT '计费方式（1/按重量 2/按件）'");}
if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','first_piece')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD   `first_piece` float NOT NULL COMMENT '首重/件'");}
if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','first_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD   `first_price` float NOT NULL COMMENT '首费（元）'");}
if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','second_piece')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD   `second_piece` float NOT NULL COMMENT '续重/件'");}
if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','second_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD   `second_price` float NOT NULL COMMENT '续费（元）'");}
if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD   `status` tinyint(1) NOT NULL COMMENT '是否默认 1默认'");}
if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_freight_rule','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_freight_rule')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_name` char(200) NOT NULL COMMENT '商品名称',
  `cover` text NOT NULL COMMENT '封面图片',
  `goods_desc` text NOT NULL COMMENT '商品简介',
  `goods_slide` text NOT NULL COMMENT '轮播图片',
  `is_put_away` tinyint(1) NOT NULL COMMENT '0/下架 1上架',
  `is_recommend` tinyint(1) NOT NULL COMMENT '0/不推荐 1推荐',
  `type_id` int(11) NOT NULL COMMENT '商品分类',
  `goods_type` tinyint(4) NOT NULL COMMENT '0/普通商品 1/团购商品',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `is_open_sku` tinyint(1) NOT NULL COMMENT '0/无规格 1/有规格',
  `price` float NOT NULL,
  `count` int(11) NOT NULL,
  `sale_count` int(11) NOT NULL,
  `old_price` float NOT NULL,
  `shop_type` tinyint(1) NOT NULL COMMENT '1普通商城2/组团商品 3/积分商城',
  `send_goods_desc` text NOT NULL COMMENT '发货说明',
  `send_price` float NOT NULL COMMENT '配送费',
  `goods_video_src` text NOT NULL COMMENT '视频',
  `trace_id` int(11) NOT NULL COMMENT '配送费',
  `goods_qrcode` text NOT NULL,
  `weight` int(11) NOT NULL,
  `freight` int(11) NOT NULL,
  `piece_free_shipping` int(11) NOT NULL,
  `quota_free_shipping` float NOT NULL,
  `goods_remark` char(200) NOT NULL DEFAULT '',
  `live_id` text NOT NULL COMMENT '监控id',
  `service_id` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_goods','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','goods_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `goods_name` char(200) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `cover` text NOT NULL COMMENT '封面图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','goods_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `goods_desc` text NOT NULL COMMENT '商品简介'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','goods_slide')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `goods_slide` text NOT NULL COMMENT '轮播图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','is_put_away')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `is_put_away` tinyint(1) NOT NULL COMMENT '0/下架 1上架'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','is_recommend')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `is_recommend` tinyint(1) NOT NULL COMMENT '0/不推荐 1推荐'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','type_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `type_id` int(11) NOT NULL COMMENT '商品分类'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','goods_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `goods_type` tinyint(4) NOT NULL COMMENT '0/普通商品 1/团购商品'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','is_open_sku')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `is_open_sku` tinyint(1) NOT NULL COMMENT '0/无规格 1/有规格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','sale_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `sale_count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','old_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `old_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','shop_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `shop_type` tinyint(1) NOT NULL COMMENT '1普通商城2/组团商品 3/积分商城'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','send_goods_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `send_goods_desc` text NOT NULL COMMENT '发货说明'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','send_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `send_price` float NOT NULL COMMENT '配送费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','goods_video_src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `goods_video_src` text NOT NULL COMMENT '视频'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','trace_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `trace_id` int(11) NOT NULL COMMENT '配送费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','goods_qrcode')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `goods_qrcode` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','weight')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `weight` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','freight')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `freight` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','piece_free_shipping')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `piece_free_shipping` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','quota_free_shipping')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `quota_free_shipping` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','goods_remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `goods_remark` char(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','live_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `live_id` text NOT NULL COMMENT '监控id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','service_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   `service_id` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_goods_fumier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trace_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `consommation` char(100) NOT NULL COMMENT '使用用量',
  `name` char(100) NOT NULL COMMENT '肥料名称',
  `area` float NOT NULL COMMENT '使用面积',
  `use_time` int(11) NOT NULL COMMENT '使用时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_goods_fumier','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_fumier')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_fumier','trace_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_fumier')." ADD   `trace_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_fumier','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_fumier')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_fumier','consommation')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_fumier')." ADD   `consommation` char(100) NOT NULL COMMENT '使用用量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_fumier','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_fumier')." ADD   `name` char(100) NOT NULL COMMENT '肥料名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_fumier','area')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_fumier')." ADD   `area` float NOT NULL COMMENT '使用面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_fumier','use_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_fumier')." ADD   `use_time` int(11) NOT NULL COMMENT '使用时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_fumier','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_fumier')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_goods_insec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trace_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `consommation` char(100) NOT NULL COMMENT '使用用量',
  `name` char(100) NOT NULL COMMENT '农药名称',
  `area` float NOT NULL COMMENT '使用面积',
  `use_time` int(11) NOT NULL COMMENT '使用时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_goods_insec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_insec')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_insec','trace_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_insec')." ADD   `trace_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_insec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_insec')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_insec','consommation')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_insec')." ADD   `consommation` char(100) NOT NULL COMMENT '使用用量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_insec','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_insec')." ADD   `name` char(100) NOT NULL COMMENT '农药名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_insec','area')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_insec')." ADD   `area` float NOT NULL COMMENT '使用面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_insec','use_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_insec')." ADD   `use_time` int(11) NOT NULL COMMENT '使用时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_insec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_insec')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_goods_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL COMMENT '服务名称',
  `content` char(200) NOT NULL COMMENT '服务说明',
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `rank` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_goods_service','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_service')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_service','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_service')." ADD   `name` char(50) NOT NULL COMMENT '服务名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_service','content')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_service')." ADD   `content` char(200) NOT NULL COMMENT '服务说明'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_service','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_service')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_service','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_service')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_service','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_service')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_service','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_service')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_goods_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `sku_name` char(100) NOT NULL COMMENT 'sku名称',
  `price` float NOT NULL COMMENT '价格',
  `count` int(11) NOT NULL COMMENT '库存',
  `spec_num` char(20) NOT NULL COMMENT '货号',
  `spec_src` text NOT NULL COMMENT '规格图片',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_goods_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_spec')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_spec','sku_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_spec')." ADD   `sku_name` char(100) NOT NULL COMMENT 'sku名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_spec','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_spec')." ADD   `price` float NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_spec','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_spec')." ADD   `count` int(11) NOT NULL COMMENT '库存'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_spec','spec_num')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_spec')." ADD   `spec_num` char(20) NOT NULL COMMENT '货号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_spec','spec_src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_spec')." ADD   `spec_src` text NOT NULL COMMENT '规格图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_spec','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_spec')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_spec')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_spec')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_goods_trace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trace_id` int(11) NOT NULL,
  `trace_name` char(100) NOT NULL,
  `trace_desc` text NOT NULL,
  `trace_time` int(11) NOT NULL,
  `img` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','trace_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD   `trace_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','trace_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD   `trace_name` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','trace_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD   `trace_desc` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','trace_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD   `trace_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','img')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD   `img` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_goods_trace_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` char(200) NOT NULL COMMENT '分类名称',
  `rank` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace_type','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace_type')." ADD   `name` char(200) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace_type','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace_type')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace_type')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_trace_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_trace_type')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_goods_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type_name` char(50) NOT NULL COMMENT '分类名称',
  `icon` text NOT NULL COMMENT '分类图标',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `status` tinyint(1) NOT NULL COMMENT '0/隐藏 2/显示',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `url_type` tinyint(1) NOT NULL COMMENT '1/普通商城2/组团商城',
  `is_show_integral` tinyint(1) NOT NULL COMMENT '0/不显示1/显示',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','type_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD   `type_name` char(50) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','icon')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD   `icon` text NOT NULL COMMENT '分类图标'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/隐藏 2/显示'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD   `create_time` int(11) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','url_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD   `url_type` tinyint(1) NOT NULL COMMENT '1/普通商城2/组团商城'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','is_show_integral')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD   `is_show_integral` tinyint(1) NOT NULL COMMENT '0/不显示1/显示'");}
if(!pdo_fieldexists('ims_cqkundian_farm_goods_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_goods_type')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `avatarurl` text NOT NULL,
  `nickname` char(30) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/未完成1/已完成',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_group','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group')." ADD   `goods_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group')." ADD   `order_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group','avatarurl')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group')." ADD   `avatarurl` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group','nickname')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group')." ADD   `nickname` char(30) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/未完成1/已完成'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_group_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_name` char(200) NOT NULL COMMENT '商品名称',
  `cover` text NOT NULL COMMENT '封面图片',
  `goods_desc` text NOT NULL COMMENT '商品简介',
  `goods_slide` text NOT NULL COMMENT '轮播图片',
  `is_put_away` tinyint(1) NOT NULL COMMENT '0/下架 1上架',
  `is_recommend` tinyint(1) NOT NULL COMMENT '0/不推荐 1推荐',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `is_open_sku` tinyint(1) NOT NULL COMMENT '0/无规格 1/有规格',
  `price` float NOT NULL,
  `count` int(11) NOT NULL,
  `sale_count` int(11) NOT NULL,
  `old_price` float NOT NULL,
  `send_price` float NOT NULL COMMENT '运费',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','goods_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `goods_name` char(200) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `cover` text NOT NULL COMMENT '封面图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','goods_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `goods_desc` text NOT NULL COMMENT '商品简介'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','goods_slide')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `goods_slide` text NOT NULL COMMENT '轮播图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','is_put_away')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `is_put_away` tinyint(1) NOT NULL COMMENT '0/下架 1上架'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','is_recommend')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `is_recommend` tinyint(1) NOT NULL COMMENT '0/不推荐 1推荐'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','is_open_sku')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `is_open_sku` tinyint(1) NOT NULL COMMENT '0/无规格 1/有规格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','sale_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `sale_count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','old_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `old_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','send_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   `send_price` float NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_group_goods_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `sku_name` char(100) NOT NULL COMMENT 'sku名称',
  `price` float NOT NULL COMMENT '价格',
  `count` int(11) NOT NULL COMMENT '库存',
  `spec_num` char(20) NOT NULL COMMENT '货号',
  `spec_src` text NOT NULL COMMENT '规格图片',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_group_goods_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods_spec')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods_spec','sku_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods_spec')." ADD   `sku_name` char(100) NOT NULL COMMENT 'sku名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods_spec','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods_spec')." ADD   `price` float NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods_spec','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods_spec')." ADD   `count` int(11) NOT NULL COMMENT '库存'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods_spec','spec_num')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods_spec')." ADD   `spec_num` char(20) NOT NULL COMMENT '货号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods_spec','spec_src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods_spec')." ADD   `spec_src` text NOT NULL COMMENT '规格图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods_spec','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods_spec')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods_spec')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_goods_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_goods_spec')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_group_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_number` char(50) NOT NULL,
  `uid` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/待支付 1/待配送 2/配送中 3/已完成 4/申请取消 5/已取消',
  `pay_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `remark` char(200) NOT NULL,
  `name` char(20) NOT NULL,
  `address` char(200) NOT NULL,
  `phone` char(20) NOT NULL,
  `pay_method` char(20) NOT NULL,
  `pra_price` float NOT NULL,
  `send_number` char(30) NOT NULL COMMENT '快递单号',
  `express_company` char(50) NOT NULL COMMENT '快递公司',
  `send_price` float NOT NULL COMMENT '运费',
  `add_price` float NOT NULL COMMENT '加工费',
  `is_add` tinyint(4) NOT NULL COMMENT '0/不加工1/腊肉 2香肠',
  `body` char(200) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_price` float NOT NULL,
  `use_is_delete` tinyint(1) NOT NULL,
  `uniontid` char(200) NOT NULL,
  `is_price` tinyint(1) NOT NULL,
  `one_price` float NOT NULL,
  `two_price` float NOT NULL,
  `is_recycle` tinyint(1) NOT NULL,
  `is_send` tinyint(1) NOT NULL,
  `send_time` int(11) NOT NULL,
  `is_confirm` tinyint(1) NOT NULL,
  `confirm_time` int(11) NOT NULL,
  `apply_delete` tinyint(1) NOT NULL,
  `manager_remark` char(200) NOT NULL,
  `manager_discount` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_group_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','order_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `order_number` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','total_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `total_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/待支付 1/待配送 2/配送中 3/已完成 4/申请取消 5/已取消'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `pay_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `name` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','address')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `address` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `phone` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','pay_method')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `pay_method` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','pra_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `pra_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','send_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `send_number` char(30) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','express_company')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `express_company` char(50) NOT NULL COMMENT '快递公司'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','send_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `send_price` float NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','add_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `add_price` float NOT NULL COMMENT '加工费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','is_add')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `is_add` tinyint(4) NOT NULL COMMENT '0/不加工1/腊肉 2香肠'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','body')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `body` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','coupon_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `coupon_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','coupon_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `coupon_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','use_is_delete')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `use_is_delete` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','uniontid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `uniontid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','is_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `is_price` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','one_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `one_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','two_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `two_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','is_recycle')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `is_recycle` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','is_send')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `is_send` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','send_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `send_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','is_confirm')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `is_confirm` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','confirm_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `confirm_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','apply_delete')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `apply_delete` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','manager_remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `manager_remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','manager_discount')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   `manager_discount` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_group_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `goods_name` char(200) NOT NULL,
  `cover` text NOT NULL,
  `price` float NOT NULL,
  `count` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD   `goods_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD   `order_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','goods_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD   `goods_name` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD   `cover` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD   `price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD   `spec_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_order_detail')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_group_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` char(100) NOT NULL COMMENT '规格名称',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_group_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_spec','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec')." ADD   `name` char(100) NOT NULL COMMENT '规格名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_spec','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_group_spec_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `spec_id` int(11) NOT NULL COMMENT '规格id',
  `spec_value` char(100) NOT NULL COMMENT '规格值',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_group_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec_value')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_spec_value','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec_value')." ADD   `spec_id` int(11) NOT NULL COMMENT '规格id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_spec_value','spec_value')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec_value')." ADD   `spec_value` char(100) NOT NULL COMMENT '规格值'");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_spec_value','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec_value')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_group_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_group_spec_value')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_home_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` char(100) NOT NULL,
  `remark` char(200) NOT NULL,
  `icon` text NOT NULL,
  `rank` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `jump_url` char(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_home_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_set','title')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_set')." ADD   `title` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_set','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_set')." ADD   `remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_set','icon')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_set')." ADD   `icon` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_set','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_set')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_set')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_set','jump_url')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_set')." ADD   `jump_url` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_set')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_home_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type_name` char(20) NOT NULL COMMENT '分类名称',
  `url` char(100) NOT NULL COMMENT '链接地址',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `rank` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '0/不显示 1/显示',
  `icon` text NOT NULL,
  `appid` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_home_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_type','type_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_type')." ADD   `type_name` char(20) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_type','url')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_type')." ADD   `url` char(100) NOT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_type')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_type','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_type')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_type','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_type')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/不显示 1/显示'");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_type','icon')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_type')." ADD   `icon` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_type','appid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_type')." ADD   `appid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_home_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_home_type')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_integral_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_name` char(200) NOT NULL COMMENT '商品名称',
  `cover` text NOT NULL COMMENT '封面图片',
  `goods_desc` text NOT NULL COMMENT '商品简介',
  `goods_slide` text NOT NULL COMMENT '轮播图片',
  `is_put_away` tinyint(1) NOT NULL COMMENT '0/下架 1上架',
  `is_recommend` tinyint(1) NOT NULL COMMENT '0/不推荐 1推荐',
  `type_id` int(11) NOT NULL COMMENT '商品分类',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `is_open_sku` tinyint(1) NOT NULL COMMENT '0/无规格 1/有规格',
  `price` float NOT NULL,
  `count` int(11) NOT NULL,
  `sale_count` int(11) NOT NULL,
  `old_price` float NOT NULL,
  `send_price` float NOT NULL COMMENT '运费',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','goods_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `goods_name` char(200) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `cover` text NOT NULL COMMENT '封面图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','goods_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `goods_desc` text NOT NULL COMMENT '商品简介'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','goods_slide')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `goods_slide` text NOT NULL COMMENT '轮播图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','is_put_away')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `is_put_away` tinyint(1) NOT NULL COMMENT '0/下架 1上架'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','is_recommend')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `is_recommend` tinyint(1) NOT NULL COMMENT '0/不推荐 1推荐'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','type_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `type_id` int(11) NOT NULL COMMENT '商品分类'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','is_open_sku')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `is_open_sku` tinyint(1) NOT NULL COMMENT '0/无规格 1/有规格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','sale_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `sale_count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','old_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `old_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','send_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   `send_price` float NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_integral_goods_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `sku_name` char(100) NOT NULL COMMENT 'sku名称',
  `price` float NOT NULL COMMENT '价格',
  `count` int(11) NOT NULL COMMENT '库存',
  `spec_num` char(20) NOT NULL COMMENT '货号',
  `spec_src` text NOT NULL COMMENT '规格图片',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_spec')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_spec','sku_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_spec')." ADD   `sku_name` char(100) NOT NULL COMMENT 'sku名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_spec','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_spec')." ADD   `price` float NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_spec','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_spec')." ADD   `count` int(11) NOT NULL COMMENT '库存'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_spec','spec_num')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_spec')." ADD   `spec_num` char(20) NOT NULL COMMENT '货号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_spec','spec_src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_spec')." ADD   `spec_src` text NOT NULL COMMENT '规格图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_spec','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_spec')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_spec')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_spec')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_integral_goods_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type_name` char(50) NOT NULL COMMENT '分类名称',
  `icon` text NOT NULL COMMENT '分类图标',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `status` tinyint(1) NOT NULL COMMENT '0/隐藏 2/显示',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_type','type_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_type')." ADD   `type_name` char(50) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_type','icon')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_type')." ADD   `icon` text NOT NULL COMMENT '分类图标'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_type','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_type')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_type')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_type','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_type')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/隐藏 2/显示'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_type','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_type')." ADD   `create_time` int(11) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_goods_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_goods_type')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_integral_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_number` char(50) NOT NULL,
  `uid` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/待支付 1/待配送 2/配送中 3/已完成 4/申请取消 5/已取消',
  `pay_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `remark` char(200) NOT NULL,
  `name` char(20) NOT NULL,
  `address` char(200) NOT NULL,
  `phone` char(20) NOT NULL,
  `pay_method` char(20) NOT NULL,
  `pra_price` float NOT NULL,
  `send_number` char(30) NOT NULL COMMENT '快递单号',
  `express_company` char(50) NOT NULL COMMENT '快递公司',
  `send_price` float NOT NULL COMMENT '运费',
  `body` char(200) NOT NULL,
  `uniontid` char(200) NOT NULL,
  `is_recycle` tinyint(1) NOT NULL,
  `is_send` tinyint(1) NOT NULL,
  `send_time` int(11) NOT NULL,
  `is_confirm` tinyint(1) NOT NULL,
  `confirm_time` int(11) NOT NULL,
  `apply_delete` tinyint(1) NOT NULL,
  `manager_remark` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','order_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `order_number` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','total_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `total_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/待支付 1/待配送 2/配送中 3/已完成 4/申请取消 5/已取消'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `pay_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `name` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','address')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `address` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `phone` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','pay_method')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `pay_method` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','pra_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `pra_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','send_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `send_number` char(30) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','express_company')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `express_company` char(50) NOT NULL COMMENT '快递公司'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','send_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `send_price` float NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','body')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `body` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','uniontid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `uniontid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','is_recycle')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `is_recycle` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','is_send')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `is_send` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','send_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `send_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','is_confirm')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `is_confirm` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','confirm_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `confirm_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','apply_delete')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `apply_delete` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','manager_remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   `manager_remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_integral_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `goods_name` char(200) NOT NULL,
  `cover` text NOT NULL,
  `price` float NOT NULL,
  `count` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD   `goods_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD   `order_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','goods_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD   `goods_name` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD   `cover` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD   `price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD   `spec_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_order_detail')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_integral_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL,
  `score` float NOT NULL COMMENT '积分',
  `create_time` int(11) NOT NULL,
  `score_type` char(100) NOT NULL COMMENT '加减积分',
  `uniacid` int(11) NOT NULL,
  `body` char(100) NOT NULL COMMENT '积分操作',
  `now_score` float NOT NULL COMMENT '操作后积分',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_integral_record','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_record','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_record')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_record','score')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_record')." ADD   `score` float NOT NULL COMMENT '积分'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_record','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_record')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_record','score_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_record')." ADD   `score_type` char(100) NOT NULL COMMENT '加减积分'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_record')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_record','body')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_record')." ADD   `body` char(100) NOT NULL COMMENT '积分操作'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_record','now_score')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_record')." ADD   `now_score` float NOT NULL COMMENT '操作后积分'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_record','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_record')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_integral_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` char(100) NOT NULL COMMENT '规格名称',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec')." ADD   `name` char(100) NOT NULL COMMENT '规格名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_integral_spec_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `spec_id` int(11) NOT NULL COMMENT '规格id',
  `spec_value` char(100) NOT NULL COMMENT '规格值',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec_value')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec_value','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec_value')." ADD   `spec_id` int(11) NOT NULL COMMENT '规格id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec_value','spec_value')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec_value')." ADD   `spec_value` char(100) NOT NULL COMMENT '规格值'");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec_value','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec_value')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_integral_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_integral_spec_value')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT '土地分类ID',
  `all_area` float NOT NULL COMMENT '总面积',
  `area` float NOT NULL COMMENT '以种植面积',
  `residue_area` float NOT NULL COMMENT '剩余面积',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  `cover` text NOT NULL COMMENT '封面',
  `land_name` char(50) NOT NULL COMMENT '土地名称',
  `price` float NOT NULL COMMENT '价格',
  `seed` text NOT NULL COMMENT '可种植的种子',
  `live_id` int(11) NOT NULL COMMENT '监控',
  `land_intro` char(200) NOT NULL DEFAULT '',
  `land_desc` text NOT NULL,
  `device_id` int(11) NOT NULL DEFAULT '0',
  `yun_device_id` text NOT NULL,
  `is_putaway` tinyint(1) NOT NULL,
  `deadline` int(11) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `first_time` int(11) NOT NULL,
  `sow_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_land','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','type_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `type_id` int(11) NOT NULL COMMENT '土地分类ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','all_area')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `all_area` float NOT NULL COMMENT '总面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','area')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `area` float NOT NULL COMMENT '以种植面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','residue_area')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `residue_area` float NOT NULL COMMENT '剩余面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `cover` text NOT NULL COMMENT '封面'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','land_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `land_name` char(50) NOT NULL COMMENT '土地名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `price` float NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','seed')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `seed` text NOT NULL COMMENT '可种植的种子'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','live_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `live_id` int(11) NOT NULL COMMENT '监控'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','land_intro')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `land_intro` char(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','land_desc')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `land_desc` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','device_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `device_id` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','yun_device_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `yun_device_id` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','is_putaway')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `is_putaway` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','deadline')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `deadline` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','delivery_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `delivery_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','first_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `first_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','sow_status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   `sow_status` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land_buy_limit` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `price` float NOT NULL COMMENT '价格',
  `day` int(11) NOT NULL COMMENT '天',
  `uniacid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0/不显示 1/显示',
  `rank` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `alias_name` char(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_land_buy_limit','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_buy_limit')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_buy_limit','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_buy_limit')." ADD   `price` float NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_buy_limit','day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_buy_limit')." ADD   `day` int(11) NOT NULL COMMENT '天'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_buy_limit','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_buy_limit')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_buy_limit','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_buy_limit')." ADD   `status` tinyint(4) NOT NULL COMMENT '0/不显示 1/显示'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_buy_limit','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_buy_limit')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_buy_limit','lid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_buy_limit')." ADD   `lid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_buy_limit','alias_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_buy_limit')." ADD   `alias_name` char(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_buy_limit','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_buy_limit')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land_delivery_cycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `land_id` int(11) NOT NULL COMMENT '土地id',
  `day` int(11) NOT NULL COMMENT '天',
  `rank` int(11) NOT NULL COMMENT '排序',
  `alias` char(50) NOT NULL COMMENT '别名',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='土地配送周期表';

");

if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_cycle','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_cycle')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_cycle','land_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_cycle')." ADD   `land_id` int(11) NOT NULL COMMENT '土地id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_cycle','day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_cycle')." ADD   `day` int(11) NOT NULL COMMENT '天'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_cycle','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_cycle')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_cycle','alias')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_cycle')." ADD   `alias` char(50) NOT NULL COMMENT '别名'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_cycle','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_cycle')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_cycle','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_cycle')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land_delivery_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单编号',
  `delivery_time` int(11) NOT NULL COMMENT '配送时间',
  `status` tinyint(1) NOT NULL COMMENT '状态（0未配送 1已发货 2已收货）',
  `name` char(50) NOT NULL COMMENT '收货人',
  `phone` char(20) NOT NULL COMMENT '联系电话',
  `address` char(200) NOT NULL COMMENT '收货地址',
  `express_no` char(100) NOT NULL COMMENT '快递单号',
  `express_company` char(100) NOT NULL COMMENT '快递公司',
  `uniacid` int(11) NOT NULL,
  `confirm_time` int(11) NOT NULL COMMENT '收货时间',
  `send_time` int(11) NOT NULL COMMENT '发货时间',
  `cycle` int(11) NOT NULL COMMENT '第X期',
  `cycle_number` char(50) NOT NULL COMMENT '每期编号',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `order_id` int(11) NOT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','delivery_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `delivery_time` int(11) NOT NULL COMMENT '配送时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `status` tinyint(1) NOT NULL COMMENT '状态（0未配送 1已发货 2已收货）'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `name` char(50) NOT NULL COMMENT '收货人'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `phone` char(20) NOT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','address')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `address` char(200) NOT NULL COMMENT '收货地址'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','express_no')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `express_no` char(100) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','express_company')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `express_company` char(100) NOT NULL COMMENT '快递公司'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','confirm_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `confirm_time` int(11) NOT NULL COMMENT '收货时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','send_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `send_time` int(11) NOT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','cycle')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `cycle` int(11) NOT NULL COMMENT '第X期'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','cycle_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   `cycle_number` char(50) NOT NULL COMMENT '每期编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_delivery_time','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_delivery_time')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land_mine` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL,
  `lid` int(11) NOT NULL COMMENT '土地ID',
  `count` int(11) NOT NULL COMMENT '数量',
  `day` int(11) NOT NULL COMMENT '天数',
  `exprie_time` int(11) NOT NULL COMMENT '到期时间',
  `create_time` int(11) NOT NULL COMMENT '购买时间',
  `status` tinyint(1) NOT NULL COMMENT '0/未种植 1/已种植 2/到期 ',
  `uniacid` int(11) NOT NULL,
  `send_day` int(11) NOT NULL COMMENT '种植天数',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `web_did` char(200) NOT NULL,
  `watering_update` int(11) NOT NULL,
  `fertilization_update` int(11) NOT NULL,
  `weeding_update` int(11) NOT NULL,
  `insecticide_update` int(11) NOT NULL,
  `weeding_tag` tinyint(1) NOT NULL,
  `insecticide_tag` tinyint(1) NOT NULL,
  `spec_id` int(11) NOT NULL DEFAULT '0',
  `can_seed_count` int(11) NOT NULL,
  `qrcode` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','lid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `lid` int(11) NOT NULL COMMENT '土地ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `count` int(11) NOT NULL COMMENT '数量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `day` int(11) NOT NULL COMMENT '天数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','exprie_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `exprie_time` int(11) NOT NULL COMMENT '到期时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `create_time` int(11) NOT NULL COMMENT '购买时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/未种植 1/已种植 2/到期 '");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','send_day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `send_day` int(11) NOT NULL COMMENT '种植天数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `order_id` int(11) NOT NULL COMMENT '订单ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','web_did')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `web_did` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','watering_update')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `watering_update` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','fertilization_update')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `fertilization_update` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','weeding_update')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `weeding_update` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','insecticide_update')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `insecticide_update` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','weeding_tag')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `weeding_tag` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','insecticide_tag')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `insecticide_tag` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `spec_id` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','can_seed_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `can_seed_count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','qrcode')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   `qrcode` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_mine','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_mine')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land_operation_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `land_id` int(11) NOT NULL COMMENT '土地id',
  `type` int(11) NOT NULL COMMENT '操作类型1/浇水 2/施肥 3/除草 4/杀虫',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `remark` char(200) NOT NULL COMMENT '描述',
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_land_operation_record','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_operation_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_operation_record','land_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_operation_record')." ADD   `land_id` int(11) NOT NULL COMMENT '土地id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_operation_record','type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_operation_record')." ADD   `type` int(11) NOT NULL COMMENT '操作类型1/浇水 2/施肥 3/除草 4/杀虫'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_operation_record','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_operation_record')." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_operation_record','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_operation_record')." ADD   `remark` char(200) NOT NULL COMMENT '描述'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_operation_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_operation_record')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_operation_record','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_operation_record')." ADD   `uid` int(11) NOT NULL COMMENT '用户uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_operation_record','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_operation_record')." ADD   `order_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_operation_record','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_operation_record')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_number` char(50) NOT NULL COMMENT '订单编号',
  `total_price` float NOT NULL COMMENT '订单总价',
  `create_time` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0/未支付 1/已支付',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `pra_price` float NOT NULL COMMENT '实际支付金额',
  `uid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `pay_method` char(50) NOT NULL COMMENT '支付方式',
  `body` char(100) NOT NULL,
  `username` char(50) NOT NULL,
  `phone` char(20) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_price` float NOT NULL,
  `uniontid` char(200) NOT NULL,
  `is_price` tinyint(1) NOT NULL,
  `one_price` float NOT NULL,
  `two_price` float NOT NULL,
  `order_type` tinyint(1) NOT NULL COMMENT '0初始订单 1 续费订单',
  `land_id` int(11) NOT NULL,
  `deadline` int(11) NOT NULL,
  `first_time` int(11) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `complete_time` int(11) NOT NULL,
  `order_expay_time` int(11) NOT NULL,
  `is_cancel` tinyint(1) NOT NULL,
  `is_confirm` tinyint(1) NOT NULL,
  `delivery_day` int(11) NOT NULL,
  `remark` char(200) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `is_refund` tinyint(1) NOT NULL,
  `refund_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_land_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','order_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `order_number` char(50) NOT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','total_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `total_price` float NOT NULL COMMENT '订单总价'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `status` tinyint(4) NOT NULL COMMENT '0/未支付 1/已支付'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `pay_time` int(11) NOT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','pra_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `pra_price` float NOT NULL COMMENT '实际支付金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','pay_method')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `pay_method` char(50) NOT NULL COMMENT '支付方式'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','body')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `body` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','username')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `username` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `phone` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','coupon_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `coupon_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','coupon_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `coupon_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','uniontid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `uniontid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','is_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `is_price` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','one_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `one_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','two_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `two_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','order_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `order_type` tinyint(1) NOT NULL COMMENT '0初始订单 1 续费订单'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','land_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `land_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','deadline')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `deadline` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','first_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `first_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','delivery_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `delivery_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','complete_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `complete_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','order_expay_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `order_expay_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','is_cancel')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `is_cancel` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','is_confirm')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `is_confirm` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','delivery_day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `delivery_day` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `spec_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','is_refund')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `is_refund` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','refund_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   `refund_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `land_price` float NOT NULL COMMENT '土地单价',
  `day_price` float NOT NULL COMMENT '年限价格',
  `land_count` int(11) NOT NULL COMMENT '购买地数量',
  `day` int(11) NOT NULL COMMENT '天数',
  `uniacid` int(11) NOT NULL,
  `lid` int(11) NOT NULL COMMENT '土地编号',
  `land_name` char(100) NOT NULL COMMENT '土地名称',
  `cover` text NOT NULL COMMENT '封面',
  `spec_id` int(11) NOT NULL DEFAULT '0',
  `mine_id` int(11) NOT NULL COMMENT '续费的用户的土地编号  land_mine 中的id',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `order_id` int(11) NOT NULL COMMENT '订单ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','land_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `land_price` float NOT NULL COMMENT '土地单价'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','day_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `day_price` float NOT NULL COMMENT '年限价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','land_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `land_count` int(11) NOT NULL COMMENT '购买地数量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `day` int(11) NOT NULL COMMENT '天数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','lid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `lid` int(11) NOT NULL COMMENT '土地编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','land_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `land_name` char(100) NOT NULL COMMENT '土地名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `cover` text NOT NULL COMMENT '封面'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `spec_id` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','mine_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   `mine_id` int(11) NOT NULL COMMENT '续费的用户的土地编号  land_mine 中的id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_order_detail')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `land_id` int(11) NOT NULL COMMENT '土地id',
  `area` float NOT NULL COMMENT '面积',
  `price` float NOT NULL COMMENT '价格',
  `status` tinyint(1) NOT NULL COMMENT '状态0/未租出 1/已租出',
  `uniacid` int(11) NOT NULL,
  `device_id` int(11) NOT NULL COMMENT '设备id',
  `live_id` int(11) NOT NULL COMMENT '监控',
  `land_num` char(50) NOT NULL COMMENT '规格编号',
  `name` char(20) NOT NULL COMMENT '别名',
  `cost` float NOT NULL COMMENT '价格',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','land_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `land_id` int(11) NOT NULL COMMENT '土地id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','area')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `area` float NOT NULL COMMENT '面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `price` float NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `status` tinyint(1) NOT NULL COMMENT '状态0/未租出 1/已租出'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','device_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `device_id` int(11) NOT NULL COMMENT '设备id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','live_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `live_id` int(11) NOT NULL COMMENT '监控'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','land_num')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `land_num` char(50) NOT NULL COMMENT '规格编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `name` char(20) NOT NULL COMMENT '别名'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','cost')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   `cost` float NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_spec')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_land_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `rank` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `slide` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_land_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_type','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_type')." ADD   `name` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_type','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_type')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_type')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_type','slide')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_type')." ADD   `slide` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_land_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_land_type')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_live` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `src` text NOT NULL COMMENT '直播地址',
  `cover` text NOT NULL COMMENT '封面图片',
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `title` char(200) NOT NULL COMMENT '标题',
  `type_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `live_uid` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_live','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   `src` text NOT NULL COMMENT '直播地址'");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   `cover` text NOT NULL COMMENT '封面图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','title')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   `title` char(200) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','type_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   `type_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   `status` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','store_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   `store_id` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','live_uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   `live_uid` char(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ims_cqkundian_farm_live','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_live_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` char(100) NOT NULL,
  `rank` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_live_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_live_type','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live_type')." ADD   `name` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_live_type','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live_type')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_live_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live_type')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_live_type','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live_type')." ADD   `status` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_live_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_live_type')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_manager_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ikey` char(200) NOT NULL,
  `value` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_manager_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_manager_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_manager_set','ikey')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_manager_set')." ADD   `ikey` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_manager_set','value')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_manager_set')." ADD   `value` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_manager_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_manager_set')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_manager_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_manager_set')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_money_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `body` char(200) NOT NULL COMMENT '说明',
  `do_type` tinyint(1) NOT NULL COMMENT '1/加 2/减',
  `money` float NOT NULL COMMENT '操作金额',
  `uniacid` int(11) NOT NULL COMMENT '小程序唯一id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `balance_money` float NOT NULL COMMENT '余额',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_money_record','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_record','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_record')." ADD   `uid` int(11) NOT NULL COMMENT '用户uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_record','body')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_record')." ADD   `body` char(200) NOT NULL COMMENT '说明'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_record','do_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_record')." ADD   `do_type` tinyint(1) NOT NULL COMMENT '1/加 2/减'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_record','money')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_record')." ADD   `money` float NOT NULL COMMENT '操作金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_record')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序唯一id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_record','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_record')." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_record','balance_money')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_record')." ADD   `balance_money` float NOT NULL COMMENT '余额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_record','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_record')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_money_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `price` float NOT NULL COMMENT '提现金额',
  `status` tinyint(1) NOT NULL COMMENT '0/待审核 1/已打款 2/已拒绝',
  `create_time` int(11) NOT NULL,
  `wx_account` char(200) NOT NULL,
  `name` char(50) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `remark` char(200) NOT NULL,
  `withdraw_time` int(11) NOT NULL,
  `method` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `price` float NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/待审核 1/已打款 2/已拒绝'");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','wx_account')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `wx_account` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `name` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','withdraw_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `withdraw_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','method')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   `method` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_money_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_money_withdraw')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_page_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` char(50) NOT NULL COMMENT '页面名称',
  `page_value` text NOT NULL COMMENT '页面数据',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_page_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_page_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_page_set','page_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_page_set')." ADD   `page_name` char(50) NOT NULL COMMENT '页面名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_page_set','page_value')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_page_set')." ADD   `page_value` text NOT NULL COMMENT '页面数据'");}
if(!pdo_fieldexists('ims_cqkundian_farm_page_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_page_set')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_page_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_page_set')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_perm_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` char(50) NOT NULL COMMENT '角色名称',
  `status` tinyint(1) NOT NULL COMMENT '0禁用 1启用',
  `perms` text NOT NULL COMMENT '权限',
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_perm_role','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_role')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_role','rolename')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_role')." ADD   `rolename` char(50) NOT NULL COMMENT '角色名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_role','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_role')." ADD   `status` tinyint(1) NOT NULL COMMENT '0禁用 1启用'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_role','perms')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_role')." ADD   `perms` text NOT NULL COMMENT '权限'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_role','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_role')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_role','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_role')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_role','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_role')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_perm_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'uid',
  `username` char(50) NOT NULL COMMENT '用户名',
  `password` char(100) NOT NULL COMMENT '密码',
  `realname` char(50) NOT NULL COMMENT '真实姓名',
  `phone` char(20) NOT NULL COMMENT '联系电话',
  `openid` char(200) NOT NULL COMMENT 'openid',
  `role_id` int(11) NOT NULL COMMENT '角色',
  `perms` text NOT NULL COMMENT '权限',
  `status` tinyint(1) NOT NULL COMMENT '0禁用 1启用',
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `uid` int(11) NOT NULL COMMENT 'uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','username')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `username` char(50) NOT NULL COMMENT '用户名'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','password')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `password` char(100) NOT NULL COMMENT '密码'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','realname')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `realname` char(50) NOT NULL COMMENT '真实姓名'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `phone` char(20) NOT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','openid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `openid` char(200) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','role_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `role_id` int(11) NOT NULL COMMENT '角色'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','perms')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `perms` text NOT NULL COMMENT '权限'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `status` tinyint(1) NOT NULL COMMENT '0禁用 1启用'");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_perm_user','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_perm_user')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT '订单编号',
  `land_id` int(11) NOT NULL COMMENT '土地编号',
  `seed_id` int(11) NOT NULL COMMENT '种子id',
  `name` char(100) NOT NULL COMMENT '种子名称',
  `cover` text NOT NULL COMMENT '封面',
  `area` int(11) NOT NULL COMMENT '面积',
  `price` float NOT NULL COMMENT '单价',
  `status` tinyint(1) NOT NULL COMMENT '0未播种 1已播种',
  `plant_time` int(11) NOT NULL COMMENT '种植时间',
  `ripe_time` int(11) NOT NULL COMMENT '预计成熟时间',
  `is_ripe` tinyint(1) NOT NULL COMMENT '0未成熟 1已成熟',
  `uniacid` int(11) NOT NULL,
  `actual_ripe_time` int(11) NOT NULL COMMENT '实际成熟时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_plant','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `order_id` int(11) NOT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','land_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `land_id` int(11) NOT NULL COMMENT '土地编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','seed_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `seed_id` int(11) NOT NULL COMMENT '种子id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `name` char(100) NOT NULL COMMENT '种子名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `cover` text NOT NULL COMMENT '封面'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','area')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `area` int(11) NOT NULL COMMENT '面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `price` float NOT NULL COMMENT '单价'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `status` tinyint(1) NOT NULL COMMENT '0未播种 1已播种'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','plant_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `plant_time` int(11) NOT NULL COMMENT '种植时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','ripe_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `ripe_time` int(11) NOT NULL COMMENT '预计成熟时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','is_ripe')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `is_ripe` tinyint(1) NOT NULL COMMENT '0未成熟 1已成熟'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','actual_ripe_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   `actual_ripe_time` int(11) NOT NULL COMMENT '实际成熟时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plant','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plant')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_play_land_opeartion` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_number` char(50) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `adopt_id` int(11) NOT NULL COMMENT '认养id',
  `is_pay` tinyint(1) NOT NULL COMMENT '0 未支付 1已支付',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `total_price` float NOT NULL COMMENT '订单总价',
  `pra_price` float NOT NULL COMMENT '实际支付金额',
  `is_operation` tinyint(1) NOT NULL COMMENT '0 未操作 1已操作 2已退款',
  `operation_type` tinyint(1) NOT NULL COMMENT '1 施肥 2除草 3 捉虫',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `body` char(200) NOT NULL COMMENT '说明',
  `form_id` char(200) NOT NULL COMMENT '模板消息推送formid',
  `uniontid` char(200) NOT NULL,
  `operation_time` int(11) NOT NULL COMMENT '操作时间',
  `area` int(11) NOT NULL COMMENT '操作面积',
  `did` char(200) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','order_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `order_number` char(50) NOT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `uid` int(11) NOT NULL COMMENT '用户uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','adopt_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `adopt_id` int(11) NOT NULL COMMENT '认养id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','is_pay')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `is_pay` tinyint(1) NOT NULL COMMENT '0 未支付 1已支付'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','pay_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `pay_time` int(11) NOT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','total_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `total_price` float NOT NULL COMMENT '订单总价'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','pra_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `pra_price` float NOT NULL COMMENT '实际支付金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','is_operation')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `is_operation` tinyint(1) NOT NULL COMMENT '0 未操作 1已操作 2已退款'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','operation_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `operation_type` tinyint(1) NOT NULL COMMENT '1 施肥 2除草 3 捉虫'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','body')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `body` char(200) NOT NULL COMMENT '说明'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','form_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `form_id` char(200) NOT NULL COMMENT '模板消息推送formid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','uniontid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `uniontid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','operation_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `operation_time` int(11) NOT NULL COMMENT '操作时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','area')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `area` int(11) NOT NULL COMMENT '操作面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','did')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `did` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   `order_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_plugin_play_land_opeartion','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_plugin_play_land_opeartion')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_print` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `p_sn` char(200) NOT NULL COMMENT '打印机编号',
  `p_key` char(200) NOT NULL COMMENT '打印机key',
  `name` char(50) NOT NULL COMMENT '名称',
  `number` char(100) NOT NULL COMMENT '编号',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_print','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_print')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_print','p_sn')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_print')." ADD   `p_sn` char(200) NOT NULL COMMENT '打印机编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_print','p_key')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_print')." ADD   `p_key` char(200) NOT NULL COMMENT '打印机key'");}
if(!pdo_fieldexists('ims_cqkundian_farm_print','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_print')." ADD   `name` char(50) NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_print','number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_print')." ADD   `number` char(100) NOT NULL COMMENT '编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_print','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_print')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_print','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_print')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_print','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_print')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT '分类id',
  `problem_title` char(200) NOT NULL COMMENT '问题标题',
  `problem_value` text NOT NULL COMMENT '问题答案',
  `create_time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/不显示 1/显示',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_problem','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem','type_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem')." ADD   `type_id` int(11) NOT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem','problem_title')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem')." ADD   `problem_title` char(200) NOT NULL COMMENT '问题标题'");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem','problem_value')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem')." ADD   `problem_value` text NOT NULL COMMENT '问题答案'");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/不显示 1/显示'");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_problem_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` char(50) NOT NULL COMMENT '分类名称',
  `pid` int(11) NOT NULL COMMENT '父分类',
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/关闭 1/开启',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_problem_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem_type','type_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem_type')." ADD   `type_name` char(50) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem_type','pid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem_type')." ADD   `pid` int(11) NOT NULL COMMENT '父分类'");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem_type')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem_type','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem_type')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem_type','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem_type')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/关闭 1/开启'");}
if(!pdo_fieldexists('ims_cqkundian_farm_problem_type','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_problem_type')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_sale_price_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `one_sale_uid` int(11) NOT NULL COMMENT '一级下线uid',
  `remark` char(200) NOT NULL COMMENT '备注',
  `price` float NOT NULL COMMENT '金额',
  `do_type` tinyint(1) NOT NULL COMMENT '1/加 2/减',
  `create_time` int(11) NOT NULL COMMENT '记录时间',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `order_type` tinyint(4) NOT NULL COMMENT '1/普通商城 2/组团商城 3/畜牧 4/土地',
  `order_id` int(11) NOT NULL COMMENT '订单号',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   `uid` int(11) NOT NULL COMMENT '用户uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','one_sale_uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   `one_sale_uid` int(11) NOT NULL COMMENT '一级下线uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   `remark` char(200) NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   `price` float NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','do_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   `do_type` tinyint(1) NOT NULL COMMENT '1/加 2/减'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   `create_time` int(11) NOT NULL COMMENT '记录时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','order_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   `order_type` tinyint(4) NOT NULL COMMENT '1/普通商城 2/组团商城 3/畜牧 4/土地'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   `order_id` int(11) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sale_price_record','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sale_price_record')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_seed_bag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `seed_id` int(11) NOT NULL COMMENT '我的种植id',
  `seed_name` char(200) NOT NULL COMMENT '种子名称',
  `cover` text NOT NULL COMMENT '封面',
  `weight` float NOT NULL COMMENT '重量 kg',
  `sale_price` float NOT NULL COMMENT '卖出单价',
  `count` int(11) NOT NULL COMMENT '面积',
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL COMMENT '放入背包时间',
  `status` tinyint(1) NOT NULL COMMENT '-1,收获中 0 未操作 1已下单配送 2 已卖出',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `uid` int(11) NOT NULL COMMENT '用户uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','seed_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `seed_id` int(11) NOT NULL COMMENT '我的种植id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','seed_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `seed_name` char(200) NOT NULL COMMENT '种子名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `cover` text NOT NULL COMMENT '封面'");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','weight')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `weight` float NOT NULL COMMENT '重量 kg'");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','sale_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `sale_price` float NOT NULL COMMENT '卖出单价'");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `count` int(11) NOT NULL COMMENT '面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `create_time` int(11) NOT NULL COMMENT '放入背包时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   `status` tinyint(1) NOT NULL COMMENT '-1,收获中 0 未操作 1已下单配送 2 已卖出'");}
if(!pdo_fieldexists('ims_cqkundian_farm_seed_bag','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_seed_bag')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `send_name` char(100) NOT NULL COMMENT '种子名称',
  `cover` text NOT NULL COMMENT '封面',
  `send_slide` text NOT NULL COMMENT '轮播图',
  `price` float NOT NULL COMMENT '价格',
  `output` char(100) NOT NULL COMMENT '产量',
  `effect` text NOT NULL COMMENT '作用',
  `send_time` char(100) NOT NULL COMMENT '播种时间',
  `cycle` char(100) NOT NULL COMMENT '生长周期',
  `uniacid` int(11) NOT NULL,
  `is_putaway` tinyint(1) NOT NULL COMMENT '0/下架1/上架',
  `rank` int(11) NOT NULL,
  `low_count` int(11) NOT NULL COMMENT '最低种植面积',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_send','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','send_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `send_name` char(100) NOT NULL COMMENT '种子名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `cover` text NOT NULL COMMENT '封面'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','send_slide')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `send_slide` text NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `price` float NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','output')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `output` char(100) NOT NULL COMMENT '产量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','effect')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `effect` text NOT NULL COMMENT '作用'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','send_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `send_time` char(100) NOT NULL COMMENT '播种时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','cycle')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `cycle` char(100) NOT NULL COMMENT '生长周期'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','is_putaway')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `is_putaway` tinyint(1) NOT NULL COMMENT '0/下架1/上架'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','low_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   `low_count` int(11) NOT NULL COMMENT '最低种植面积'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_send_mine` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT '订单编号',
  `sid` int(11) NOT NULL COMMENT '种子ID',
  `status` tinyint(1) NOT NULL COMMENT '0/带种植 1/已种植 2/已成熟 3/已摘取',
  `day` int(11) NOT NULL COMMENT '种植天数',
  `send_name` char(100) NOT NULL COMMENT '种子名称',
  `count` int(11) NOT NULL COMMENT '数量',
  `uniacid` int(11) NOT NULL,
  `lid` int(11) NOT NULL COMMENT '土地ID',
  `seed_time` int(11) NOT NULL COMMENT '播种时间',
  `expect_time` int(11) NOT NULL COMMENT '预计成熟时间',
  `weight` float NOT NULL,
  `sale_price` float NOT NULL,
  `gain_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `order_id` int(11) NOT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','sid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `sid` int(11) NOT NULL COMMENT '种子ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/带种植 1/已种植 2/已成熟 3/已摘取'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `day` int(11) NOT NULL COMMENT '种植天数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','send_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `send_name` char(100) NOT NULL COMMENT '种子名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `count` int(11) NOT NULL COMMENT '数量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','lid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `lid` int(11) NOT NULL COMMENT '土地ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','seed_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `seed_time` int(11) NOT NULL COMMENT '播种时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','expect_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `expect_time` int(11) NOT NULL COMMENT '预计成熟时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','weight')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `weight` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','sale_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `sale_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','gain_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   `gain_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_mine','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_mine')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_send_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_number` char(50) NOT NULL,
  `uid` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0/未支付 1/已支付',
  `pra_price` float NOT NULL,
  `pay_method` char(100) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `pay_time` int(11) NOT NULL,
  `body` char(100) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_price` float NOT NULL,
  `uniontid` char(200) NOT NULL,
  `mine_land_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_send_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','order_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `order_number` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','total_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `total_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `status` tinyint(4) NOT NULL COMMENT '0/未支付 1/已支付'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','pra_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `pra_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','pay_method')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `pay_method` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `pay_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','body')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `body` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','coupon_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `coupon_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','coupon_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `coupon_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','uniontid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `uniontid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','mine_land_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   `mine_land_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_send_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `price` float NOT NULL,
  `sid` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `send_name` char(100) NOT NULL,
  `cover` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_send_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order_detail')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order_detail','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order_detail')." ADD   `order_id` int(11) NOT NULL COMMENT '订单ID'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order_detail','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order_detail')." ADD   `price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order_detail','sid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order_detail')." ADD   `sid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order_detail','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order_detail')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order_detail','send_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order_detail')." ADD   `send_name` char(100) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order_detail','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order_detail')." ADD   `cover` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order_detail','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order_detail')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_order_detail')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_send_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `lid` int(11) NOT NULL,
  `txt` text NOT NULL,
  `src` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `seed_id` int(11) NOT NULL,
  `plant_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_send_status','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_status')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_status','lid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_status')." ADD   `lid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_status','txt')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_status')." ADD   `txt` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_status','src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_status')." ADD   `src` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_status','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_status')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_status','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_status')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_status','seed_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_status')." ADD   `seed_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_status','plant_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_status')." ADD   `plant_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_send_status','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_send_status')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ikey` char(50) NOT NULL COMMENT 'key',
  `value` text NOT NULL COMMENT '值',
  `uniacid` int(11) NOT NULL COMMENT '11',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_set','ikey')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_set')." ADD   `ikey` char(50) NOT NULL COMMENT 'key'");}
if(!pdo_fieldexists('ims_cqkundian_farm_set','value')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_set')." ADD   `value` text NOT NULL COMMENT '值'");}
if(!pdo_fieldexists('ims_cqkundian_farm_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_set')." ADD   `uniacid` int(11) NOT NULL COMMENT '11'");}
if(!pdo_fieldexists('ims_cqkundian_farm_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_set')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_shop_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_name` char(100) NOT NULL COMMENT '优惠券名称',
  `coupon_type` tinyint(1) NOT NULL COMMENT '1/满减',
  `low_cash_price` float NOT NULL COMMENT '最低消费金额',
  `coupon_price` float NOT NULL COMMENT '优惠金额',
  `expiry_date` tinyint(4) NOT NULL COMMENT '1/n天内有效 2/时间段',
  `expiry_day` int(11) NOT NULL COMMENT '有效天数',
  `begin_time` int(11) NOT NULL COMMENT '优惠券开始时间',
  `end_time` int(11) NOT NULL COMMENT '优惠券结算时间',
  `rank` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/关闭 1/开启',
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `count` int(11) NOT NULL COMMENT '优惠券数量',
  `use_count` int(11) NOT NULL COMMENT '使用数量',
  `type` tinyint(4) NOT NULL COMMENT '1/普通商城 2/组团商城 3/畜牧 4/土地 5/种子',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','coupon_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `coupon_name` char(100) NOT NULL COMMENT '优惠券名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','coupon_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `coupon_type` tinyint(1) NOT NULL COMMENT '1/满减'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','low_cash_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `low_cash_price` float NOT NULL COMMENT '最低消费金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','coupon_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `coupon_price` float NOT NULL COMMENT '优惠金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','expiry_date')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `expiry_date` tinyint(4) NOT NULL COMMENT '1/n天内有效 2/时间段'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','expiry_day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `expiry_day` int(11) NOT NULL COMMENT '有效天数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','begin_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `begin_time` int(11) NOT NULL COMMENT '优惠券开始时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','end_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `end_time` int(11) NOT NULL COMMENT '优惠券结算时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/关闭 1/开启'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `count` int(11) NOT NULL COMMENT '优惠券数量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','use_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `use_count` int(11) NOT NULL COMMENT '使用数量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `type` tinyint(4) NOT NULL COMMENT '1/普通商城 2/组团商城 3/畜牧 4/土地 5/种子'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','is_delete')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   `is_delete` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_coupon','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_coupon')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_shop_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_number` char(50) NOT NULL,
  `uid` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/待支付 1/待配送 2/配送中 3/已完成 4/申请取消 5/已取消',
  `pay_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `remark` char(200) NOT NULL,
  `name` char(20) NOT NULL,
  `address` char(200) NOT NULL,
  `phone` char(20) NOT NULL,
  `pay_method` char(20) NOT NULL,
  `pra_price` float NOT NULL,
  `send_number` char(30) NOT NULL COMMENT '快递单号',
  `express_company` char(50) NOT NULL COMMENT '快递公司',
  `order_type` tinyint(1) NOT NULL COMMENT '0/普通1/组团/2积分3/家畜寄送',
  `send_price` float NOT NULL COMMENT '运费',
  `add_price` float NOT NULL COMMENT '加工费',
  `group_status` tinyint(1) NOT NULL COMMENT '0/待支付 6/组团中 1/待配送 2/配送中 3/已完成 4/申请取消 5/已取消',
  `is_add` tinyint(4) NOT NULL COMMENT '0/不加工1/腊肉 2香肠',
  `body` char(200) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_price` float NOT NULL,
  `use_is_delete` tinyint(1) NOT NULL,
  `uniontid` char(200) NOT NULL,
  `is_price` tinyint(1) NOT NULL,
  `one_price` float NOT NULL,
  `two_price` float NOT NULL,
  `is_recycel` tinyint(1) NOT NULL,
  `is_send` tinyint(1) NOT NULL,
  `send_time` int(11) NOT NULL,
  `is_confirm` tinyint(1) NOT NULL,
  `confirm_time` int(11) NOT NULL,
  `apply_delete` tinyint(1) NOT NULL,
  `manager_remark` char(200) NOT NULL,
  `manager_discount` float NOT NULL,
  `send_method` tinyint(1) NOT NULL,
  `trans_id` char(100) NOT NULL DEFAULT '',
  `is_comment` tinyint(1) NOT NULL DEFAULT '0',
  `offline_qrocde` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','order_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `order_number` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','total_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `total_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/待支付 1/待配送 2/配送中 3/已完成 4/申请取消 5/已取消'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `pay_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `name` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','address')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `address` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `phone` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','pay_method')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `pay_method` char(20) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','pra_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `pra_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','send_number')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `send_number` char(30) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','express_company')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `express_company` char(50) NOT NULL COMMENT '快递公司'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','order_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `order_type` tinyint(1) NOT NULL COMMENT '0/普通1/组团/2积分3/家畜寄送'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','send_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `send_price` float NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','add_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `add_price` float NOT NULL COMMENT '加工费'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','group_status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `group_status` tinyint(1) NOT NULL COMMENT '0/待支付 6/组团中 1/待配送 2/配送中 3/已完成 4/申请取消 5/已取消'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','is_add')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `is_add` tinyint(4) NOT NULL COMMENT '0/不加工1/腊肉 2香肠'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','body')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `body` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','coupon_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `coupon_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','coupon_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `coupon_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','use_is_delete')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `use_is_delete` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','uniontid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `uniontid` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','is_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `is_price` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','one_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `one_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','two_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `two_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','is_recycel')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `is_recycel` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','is_send')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `is_send` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','send_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `send_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','is_confirm')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `is_confirm` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','confirm_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `confirm_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','apply_delete')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `apply_delete` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','manager_remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `manager_remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','manager_discount')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `manager_discount` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','send_method')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `send_method` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','trans_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `trans_id` char(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','is_comment')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `is_comment` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','offline_qrocde')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   `offline_qrocde` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_shop_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `goods_name` char(200) NOT NULL,
  `cover` text NOT NULL,
  `price` float NOT NULL,
  `count` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `add_info` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   `goods_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   `order_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','goods_name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   `goods_name` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','cover')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   `cover` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   `price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   `count` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   `spec_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','add_info')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   `add_info` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_shop_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_shop_order_detail')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(11) NOT NULL,
  `sign_time` int(11) NOT NULL COMMENT '签到时间',
  `uniacid` int(11) NOT NULL,
  `score` int(11) NOT NULL COMMENT '签到获取的积分',
  `year` int(11) NOT NULL COMMENT '年',
  `month` int(11) NOT NULL COMMENT '月',
  `day` int(11) NOT NULL COMMENT '天',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_sign','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sign')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sign','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sign')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_sign','sign_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sign')." ADD   `sign_time` int(11) NOT NULL COMMENT '签到时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sign','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sign')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_sign','score')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sign')." ADD   `score` int(11) NOT NULL COMMENT '签到获取的积分'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sign','year')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sign')." ADD   `year` int(11) NOT NULL COMMENT '年'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sign','month')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sign')." ADD   `month` int(11) NOT NULL COMMENT '月'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sign','day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sign')." ADD   `day` int(11) NOT NULL COMMENT '天'");}
if(!pdo_fieldexists('ims_cqkundian_farm_sign','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_sign')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `slide_src` text NOT NULL COMMENT '轮播图片',
  `slide_type` tinyint(1) NOT NULL COMMENT '1/首页轮播图 2商城 3/积分商城',
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/关闭1/开启',
  `link_type` char(100) NOT NULL COMMENT '链接类型',
  `link_param` char(100) NOT NULL COMMENT 'l链接参数',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_slide','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_slide')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_slide','slide_src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_slide')." ADD   `slide_src` text NOT NULL COMMENT '轮播图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_slide','slide_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_slide')." ADD   `slide_type` tinyint(1) NOT NULL COMMENT '1/首页轮播图 2商城 3/积分商城'");}
if(!pdo_fieldexists('ims_cqkundian_farm_slide','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_slide')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_slide','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_slide')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_slide','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_slide')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/关闭1/开启'");}
if(!pdo_fieldexists('ims_cqkundian_farm_slide','link_type')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_slide')." ADD   `link_type` char(100) NOT NULL COMMENT '链接类型'");}
if(!pdo_fieldexists('ims_cqkundian_farm_slide','link_param')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_slide')." ADD   `link_param` char(100) NOT NULL COMMENT 'l链接参数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_slide','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_slide')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL COMMENT '溯源名称',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `count` int(11) NOT NULL COMMENT '生成数量',
  `pre` char(20) NOT NULL COMMENT '编码前缀',
  `content` text NOT NULL COMMENT '自定义参数',
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL COMMENT '排序',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_source','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_source','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD   `name` char(50) NOT NULL COMMENT '溯源名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD   `count` int(11) NOT NULL COMMENT '生成数量'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source','pre')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD   `pre` char(20) NOT NULL COMMENT '编码前缀'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source','content')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD   `content` text NOT NULL COMMENT '自定义参数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_source','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_source_li` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `source_id` int(11) NOT NULL COMMENT '溯源id',
  `source_code` char(100) NOT NULL COMMENT '溯源编号',
  `status` tinyint(1) NOT NULL COMMENT '0 未售 1 已售',
  `qrcode` text NOT NULL COMMENT '防伪二维码',
  `count` int(11) NOT NULL COMMENT '查看次数',
  `update_time` int(11) NOT NULL COMMENT '最后一次查看时间',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_source_li','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source_li')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source_li','source_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source_li')." ADD   `source_id` int(11) NOT NULL COMMENT '溯源id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source_li','source_code')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source_li')." ADD   `source_code` char(100) NOT NULL COMMENT '溯源编号'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source_li','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source_li')." ADD   `status` tinyint(1) NOT NULL COMMENT '0 未售 1 已售'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source_li','qrcode')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source_li')." ADD   `qrcode` text NOT NULL COMMENT '防伪二维码'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source_li','count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source_li')." ADD   `count` int(11) NOT NULL COMMENT '查看次数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source_li','update_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source_li')." ADD   `update_time` int(11) NOT NULL COMMENT '最后一次查看时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_source_li','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source_li')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_source_li','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_source_li')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` char(100) NOT NULL COMMENT '规格名称',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_spec','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec')." ADD   `name` char(100) NOT NULL COMMENT '规格名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_spec','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_spec','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_spec_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `spec_id` int(11) NOT NULL COMMENT '规格id',
  `spec_value` char(100) NOT NULL COMMENT '规格值',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec_value')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_spec_value','spec_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec_value')." ADD   `spec_id` int(11) NOT NULL COMMENT '规格id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_spec_value','spec_value')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec_value')." ADD   `spec_value` char(100) NOT NULL COMMENT '规格值'");}
if(!pdo_fieldexists('ims_cqkundian_farm_spec_value','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec_value')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_spec_value')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `date` char(50) NOT NULL COMMENT '时间',
  `order_count` int(11) NOT NULL COMMENT '今日订单总数',
  `total_price` float NOT NULL COMMENT '今日成交金额',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_statistics','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_statistics')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_statistics','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_statistics')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_statistics','date')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_statistics')." ADD   `date` char(50) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_statistics','order_count')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_statistics')." ADD   `order_count` int(11) NOT NULL COMMENT '今日订单总数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_statistics','total_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_statistics')." ADD   `total_price` float NOT NULL COMMENT '今日成交金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_statistics','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_statistics')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_tarbar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL COMMENT '导航名称',
  `icon` text NOT NULL COMMENT '图标',
  `select_icon` text NOT NULL COMMENT '选中图标',
  `path` char(100) NOT NULL COMMENT '路径',
  `color` char(50) NOT NULL COMMENT '颜色',
  `select_color` char(50) NOT NULL COMMENT '选中颜色',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD   `name` char(50) NOT NULL COMMENT '导航名称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','icon')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD   `icon` text NOT NULL COMMENT '图标'");}
if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','select_icon')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD   `select_icon` text NOT NULL COMMENT '选中图标'");}
if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','path')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD   `path` char(100) NOT NULL COMMENT '路径'");}
if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','color')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD   `color` char(50) NOT NULL COMMENT '颜色'");}
if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','select_color')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD   `select_color` char(50) NOT NULL COMMENT '选中颜色'");}
if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD   `rank` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_tarbar','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_tarbar')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(11) NOT NULL COMMENT '微擎uid',
  `nickname` char(30) NOT NULL COMMENT '昵称',
  `avatarurl` text NOT NULL COMMENT '头像',
  `phone` char(20) NOT NULL COMMENT '电话',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `address` char(100) NOT NULL COMMENT '地址',
  `openid` char(50) NOT NULL,
  `score` float NOT NULL COMMENT '积分',
  `continue_day` int(11) NOT NULL COMMENT '连续签到天数',
  `is_distributor` tinyint(1) NOT NULL,
  `one_distributor` int(11) NOT NULL,
  `become_time` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `price` float NOT NULL,
  `money` float NOT NULL,
  `share_qrcode` text NOT NULL,
  `truename` char(50) NOT NULL,
  `id_card` char(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_user','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `uid` int(11) NOT NULL COMMENT '微擎uid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','nickname')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `nickname` char(30) NOT NULL COMMENT '昵称'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','avatarurl')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `avatarurl` text NOT NULL COMMENT '头像'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','phone')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `phone` char(20) NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','address')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `address` char(100) NOT NULL COMMENT '地址'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','openid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `openid` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','score')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `score` float NOT NULL COMMENT '积分'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','continue_day')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `continue_day` int(11) NOT NULL COMMENT '连续签到天数'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','is_distributor')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `is_distributor` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','one_distributor')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `one_distributor` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','become_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `become_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','total_price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `total_price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `price` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','money')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `money` float NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','share_qrcode')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `share_qrcode` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','truename')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `truename` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','id_card')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   `id_card` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL COMMENT '优惠券id',
  `create_time` int(11) NOT NULL COMMENT '领取时间',
  `uniacid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0/未使用1/已使用',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_user_coupon','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user_coupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user_coupon','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user_coupon')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user_coupon','cid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user_coupon')." ADD   `cid` int(11) NOT NULL COMMENT '优惠券id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user_coupon','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user_coupon')." ADD   `create_time` int(11) NOT NULL COMMENT '领取时间'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user_coupon')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_user_coupon','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user_coupon')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/未使用1/已使用'");}
if(!pdo_fieldexists('ims_cqkundian_farm_user_coupon','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_user_coupon')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_vet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL COMMENT '名字',
  `head_img` text NOT NULL COMMENT '头像',
  `introduce` text NOT NULL COMMENT '描述',
  `certificate` text NOT NULL COMMENT '证书图片',
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_vet','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_vet','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD   `name` char(50) NOT NULL COMMENT '名字'");}
if(!pdo_fieldexists('ims_cqkundian_farm_vet','head_img')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD   `head_img` text NOT NULL COMMENT '头像'");}
if(!pdo_fieldexists('ims_cqkundian_farm_vet','introduce')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD   `introduce` text NOT NULL COMMENT '描述'");}
if(!pdo_fieldexists('ims_cqkundian_farm_vet','certificate')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD   `certificate` text NOT NULL COMMENT '证书图片'");}
if(!pdo_fieldexists('ims_cqkundian_farm_vet','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_vet','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_vet','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD   `status` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_vet','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_vet','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_vet')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_webapp_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_src` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_webapp_slide','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webapp_slide')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_webapp_slide','slide_src')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webapp_slide')." ADD   `slide_src` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_webapp_slide','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webapp_slide')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_webapp_slide','rank')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webapp_slide')." ADD   `rank` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_webapp_slide','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webapp_slide')." ADD   `status` tinyint(1) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_webapp_slide','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webapp_slide')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_webappset` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ikey` char(200) NOT NULL COMMENT 'key',
  `value` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_webappset','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webappset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_webappset','ikey')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webappset')." ADD   `ikey` char(200) NOT NULL COMMENT 'key'");}
if(!pdo_fieldexists('ims_cqkundian_farm_webappset','value')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webappset')." ADD   `value` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_webappset','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webappset')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_webappset','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_webappset')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `price` float NOT NULL COMMENT '提现金额',
  `status` tinyint(1) NOT NULL COMMENT '0/待审核 1/已打款 2/已拒绝',
  `create_time` int(11) NOT NULL,
  `wx_account` char(200) NOT NULL,
  `name` char(50) NOT NULL,
  `uniacid` tinyint(11) NOT NULL,
  `remark` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','uid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD   `uid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','price')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD   `price` float NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD   `status` tinyint(1) NOT NULL COMMENT '0/待审核 1/已打款 2/已拒绝'");}
if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','create_time')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD   `create_time` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','wx_account')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD   `wx_account` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','name')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD   `name` char(50) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD   `uniacid` tinyint(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','remark')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD   `remark` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_withdraw')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_wx_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `wx_appid` char(100) NOT NULL COMMENT '微信公众号appid',
  `wx_secret` char(200) NOT NULL COMMENT '微信密钥',
  `wx_template_order_id` char(200) NOT NULL COMMENT '订单推送模板（店家）',
  `wx_small_template_id` char(200) NOT NULL COMMENT '订单推送模板',
  `get_openid` text NOT NULL COMMENT '接收推送id',
  `wx_cert` text NOT NULL,
  `wx_key` text NOT NULL,
  `wx_shop_template_id` char(200) NOT NULL COMMENT '订单通知模板消息',
  `longitude` char(100) NOT NULL COMMENT '经度',
  `latitude` char(100) NOT NULL COMMENT '纬度',
  `appcode` char(100) NOT NULL COMMENT 'appcode',
  `is_open_weather` tinyint(1) NOT NULL COMMENT '是否开启天气',
  `wx_cancel_template_id` char(200) NOT NULL COMMENT '订单取消模板id',
  `mini_device_template_id` char(200) NOT NULL,
  `mini_services_template_id` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','wx_appid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `wx_appid` char(100) NOT NULL COMMENT '微信公众号appid'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','wx_secret')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `wx_secret` char(200) NOT NULL COMMENT '微信密钥'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','wx_template_order_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `wx_template_order_id` char(200) NOT NULL COMMENT '订单推送模板（店家）'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','wx_small_template_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `wx_small_template_id` char(200) NOT NULL COMMENT '订单推送模板'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','get_openid')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `get_openid` text NOT NULL COMMENT '接收推送id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','wx_cert')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `wx_cert` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','wx_key')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `wx_key` text NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','wx_shop_template_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `wx_shop_template_id` char(200) NOT NULL COMMENT '订单通知模板消息'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','longitude')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `longitude` char(100) NOT NULL COMMENT '经度'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','latitude')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `latitude` char(100) NOT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','appcode')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `appcode` char(100) NOT NULL COMMENT 'appcode'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','is_open_weather')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `is_open_weather` tinyint(1) NOT NULL COMMENT '是否开启天气'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','wx_cancel_template_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `wx_cancel_template_id` char(200) NOT NULL COMMENT '订单取消模板id'");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','mini_device_template_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `mini_device_template_id` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','mini_services_template_id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   `mini_services_template_id` char(200) NOT NULL");}
if(!pdo_fieldexists('ims_cqkundian_farm_wx_set','id')) {pdo_query("ALTER TABLE ".tablename('ims_cqkundian_farm_wx_set')." ADD   PRIMARY KEY (`id`)");}
