<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '小程序名称',
  `covers_img` varchar(100) DEFAULT NULL COMMENT '首页封面',
  `logo` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '预约价格',
  `phone` varchar(11) DEFAULT NULL COMMENT '客服电话',
  `service_name` varchar(100) DEFAULT NULL COMMENT '服务名称',
  `enter_title` varchar(30) DEFAULT NULL COMMENT '入驻标题',
  `enter_status` tinyint(4) DEFAULT '1' COMMENT '是否开启入驻',
  `auto_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启自由接单 1 开启 0 未开启',
  `points` decimal(5,4) DEFAULT '0.0060' COMMENT '手续费比例 0.006',
  `full_num` int(11) DEFAULT '3' COMMENT '参与竞标满标人数设置默认3人',
  `tip` varchar(255) DEFAULT NULL COMMENT '预约提示',
  `qq_map_key` varchar(255) DEFAULT NULL COMMENT '腾讯地图key',
  `type_num` tinyint(4) DEFAULT '3' COMMENT '可选技能数量',
  `min_cash` decimal(10,2) DEFAULT '1.00' COMMENT '最低提现金额',
  `notify_rule` tinyint(2) DEFAULT '0' COMMENT '通知类型 1-分类 2-距离 3-分类和距离',
  `distance` decimal(10,2) DEFAULT NULL COMMENT '距离 公里',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master','id')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master','name')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '小程序名称'");}
if(!pdo_fieldexists('ox_master','covers_img')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `covers_img` varchar(100) DEFAULT NULL COMMENT '首页封面'");}
if(!pdo_fieldexists('ox_master','logo')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `logo` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master','address')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master','price')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `price` decimal(10,2) DEFAULT '0.00' COMMENT '预约价格'");}
if(!pdo_fieldexists('ox_master','phone')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `phone` varchar(11) DEFAULT NULL COMMENT '客服电话'");}
if(!pdo_fieldexists('ox_master','service_name')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `service_name` varchar(100) DEFAULT NULL COMMENT '服务名称'");}
if(!pdo_fieldexists('ox_master','enter_title')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `enter_title` varchar(30) DEFAULT NULL COMMENT '入驻标题'");}
if(!pdo_fieldexists('ox_master','enter_status')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `enter_status` tinyint(4) DEFAULT '1' COMMENT '是否开启入驻'");}
if(!pdo_fieldexists('ox_master','auto_status')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `auto_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启自由接单 1 开启 0 未开启'");}
if(!pdo_fieldexists('ox_master','points')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `points` decimal(5,4) DEFAULT '0.0060' COMMENT '手续费比例 0.006'");}
if(!pdo_fieldexists('ox_master','full_num')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `full_num` int(11) DEFAULT '3' COMMENT '参与竞标满标人数设置默认3人'");}
if(!pdo_fieldexists('ox_master','tip')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `tip` varchar(255) DEFAULT NULL COMMENT '预约提示'");}
if(!pdo_fieldexists('ox_master','qq_map_key')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `qq_map_key` varchar(255) DEFAULT NULL COMMENT '腾讯地图key'");}
if(!pdo_fieldexists('ox_master','type_num')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `type_num` tinyint(4) DEFAULT '3' COMMENT '可选技能数量'");}
if(!pdo_fieldexists('ox_master','min_cash')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `min_cash` decimal(10,2) DEFAULT '1.00' COMMENT '最低提现金额'");}
if(!pdo_fieldexists('ox_master','notify_rule')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `notify_rule` tinyint(2) DEFAULT '0' COMMENT '通知类型 1-分类 2-距离 3-分类和距离'");}
if(!pdo_fieldexists('ox_master','distance')) {pdo_query("ALTER TABLE ".tablename('ox_master')." ADD   `distance` decimal(10,2) DEFAULT NULL COMMENT '距离 公里'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_appraise` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `uid` int(10) DEFAULT NULL COMMENT '评价人id',
  `reapir_uid` int(10) DEFAULT NULL COMMENT '师傅id',
  `order_id` int(10) NOT NULL COMMENT '订单id',
  `formid` varchar(50) DEFAULT NULL,
  `detail` text COMMENT '评价内容',
  `level` tinyint(4) DEFAULT NULL COMMENT '评价星数',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`,`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_appraise','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_appraise')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_appraise','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_appraise')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_appraise','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_appraise')." ADD   `uid` int(10) DEFAULT NULL COMMENT '评价人id'");}
if(!pdo_fieldexists('ox_master_appraise','reapir_uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_appraise')." ADD   `reapir_uid` int(10) DEFAULT NULL COMMENT '师傅id'");}
if(!pdo_fieldexists('ox_master_appraise','order_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_appraise')." ADD   `order_id` int(10) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('ox_master_appraise','formid')) {pdo_query("ALTER TABLE ".tablename('ox_master_appraise')." ADD   `formid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_appraise','detail')) {pdo_query("ALTER TABLE ".tablename('ox_master_appraise')." ADD   `detail` text COMMENT '评价内容'");}
if(!pdo_fieldexists('ox_master_appraise','level')) {pdo_query("ALTER TABLE ".tablename('ox_master_appraise')." ADD   `level` tinyint(4) DEFAULT NULL COMMENT '评价星数'");}
if(!pdo_fieldexists('ox_master_appraise','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_appraise')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_banner` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(10) DEFAULT NULL COMMENT '小程序id',
  `img` varchar(100) DEFAULT NULL COMMENT '图片地址',
  `sort` int(10) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_banner','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_banner')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_master_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_banner')." ADD   `uniacid` int(10) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_banner','img')) {pdo_query("ALTER TABLE ".tablename('ox_master_banner')." ADD   `img` varchar(100) DEFAULT NULL COMMENT '图片地址'");}
if(!pdo_fieldexists('ox_master_banner','sort')) {pdo_query("ALTER TABLE ".tablename('ox_master_banner')." ADD   `sort` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_banner','type')) {pdo_query("ALTER TABLE ".tablename('ox_master_banner')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '类型'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_bidding` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `reapir_uid` int(11) NOT NULL COMMENT '师傅id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `price` decimal(20,2) NOT NULL COMMENT '竞标价格',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0，流标，1,竞标中，2，已中标，3，放弃竞标',
  `create_time` int(11) DEFAULT NULL COMMENT '竞标创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_bidding','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_bidding')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_master_bidding','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_bidding')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_bidding','reapir_uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_bidding')." ADD   `reapir_uid` int(11) NOT NULL COMMENT '师傅id'");}
if(!pdo_fieldexists('ox_master_bidding','order_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_bidding')." ADD   `order_id` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('ox_master_bidding','price')) {pdo_query("ALTER TABLE ".tablename('ox_master_bidding')." ADD   `price` decimal(20,2) NOT NULL COMMENT '竞标价格'");}
if(!pdo_fieldexists('ox_master_bidding','status')) {pdo_query("ALTER TABLE ".tablename('ox_master_bidding')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0，流标，1,竞标中，2，已中标，3，放弃竞标'");}
if(!pdo_fieldexists('ox_master_bidding','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_bidding')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '竞标创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_black` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺id',
  `uniacid` int(10) NOT NULL COMMENT '小程序id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `create_time` int(11) unsigned DEFAULT '0' COMMENT '创建时间',
  `black_time` int(11) unsigned DEFAULT '0' COMMENT '封号到期时间 0标识永久封号',
  `reject` varchar(255) DEFAULT NULL COMMENT '加入原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='用户黑名单表';

");

if(!pdo_fieldexists('ox_master_black','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_black')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺id'");}
if(!pdo_fieldexists('ox_master_black','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_black')." ADD   `uniacid` int(10) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_black','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_black')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ox_master_black','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_black')." ADD   `create_time` int(11) unsigned DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_master_black','black_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_black')." ADD   `black_time` int(11) unsigned DEFAULT '0' COMMENT '封号到期时间 0标识永久封号'");}
if(!pdo_fieldexists('ox_master_black','reject')) {pdo_query("ALTER TABLE ".tablename('ox_master_black')." ADD   `reject` varchar(255) DEFAULT NULL COMMENT '加入原因'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_code` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `appid` varchar(20) DEFAULT NULL,
  `appkey` varchar(50) DEFAULT NULL,
  `sign` varchar(50) DEFAULT NULL COMMENT '签名',
  `status` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_code','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_code')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_code','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_code')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_code','appid')) {pdo_query("ALTER TABLE ".tablename('ox_master_code')." ADD   `appid` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_code','appkey')) {pdo_query("ALTER TABLE ".tablename('ox_master_code')." ADD   `appkey` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_code','sign')) {pdo_query("ALTER TABLE ".tablename('ox_master_code')." ADD   `sign` varchar(50) DEFAULT NULL COMMENT '签名'");}
if(!pdo_fieldexists('ox_master_code','status')) {pdo_query("ALTER TABLE ".tablename('ox_master_code')." ADD   `status` tinyint(4) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_code_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT ' 1 验证码',
  `templateId` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_code_config','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_code_config')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_code_config','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_code_config')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_code_config','type')) {pdo_query("ALTER TABLE ".tablename('ox_master_code_config')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT ' 1 验证码'");}
if(!pdo_fieldexists('ox_master_code_config','templateId')) {pdo_query("ALTER TABLE ".tablename('ox_master_code_config')." ADD   `templateId` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_code_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uniacid` int(10) DEFAULT NULL COMMENT '小程序id',
  `code` int(10) DEFAULT NULL COMMENT '验证码',
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_code_log','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_code_log')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ox_master_code_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_code_log')." ADD   `uniacid` int(10) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_code_log','code')) {pdo_query("ALTER TABLE ".tablename('ox_master_code_log')." ADD   `code` int(10) DEFAULT NULL COMMENT '验证码'");}
if(!pdo_fieldexists('ox_master_code_log','phone')) {pdo_query("ALTER TABLE ".tablename('ox_master_code_log')." ADD   `phone` varchar(11) DEFAULT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('ox_master_code_log','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_code_log')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_finance` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '财务id',
  `uniacid` int(10) NOT NULL COMMENT '小程序id',
  `pay_sn` varchar(20) NOT NULL COMMENT '支付编号',
  `order_id` int(10) NOT NULL COMMENT '订单id',
  `pay_type` tinyint(4) NOT NULL COMMENT '支付类型',
  `title` varchar(50) NOT NULL COMMENT '支付标题',
  `account` decimal(10,2) NOT NULL COMMENT '支付金额',
  `uid` int(10) NOT NULL COMMENT '用户id',
  `status` tinyint(4) DEFAULT NULL COMMENT ' 0 未支付 1 已支付 2 已退款',
  `type` int(11) NOT NULL COMMENT '类型',
  `create_time` int(11) NOT NULL COMMENT '支付时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ox_master_finance','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '财务id'");}
if(!pdo_fieldexists('ox_master_finance','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `uniacid` int(10) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_finance','pay_sn')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `pay_sn` varchar(20) NOT NULL COMMENT '支付编号'");}
if(!pdo_fieldexists('ox_master_finance','order_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `order_id` int(10) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('ox_master_finance','pay_type')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `pay_type` tinyint(4) NOT NULL COMMENT '支付类型'");}
if(!pdo_fieldexists('ox_master_finance','title')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `title` varchar(50) NOT NULL COMMENT '支付标题'");}
if(!pdo_fieldexists('ox_master_finance','account')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `account` decimal(10,2) NOT NULL COMMENT '支付金额'");}
if(!pdo_fieldexists('ox_master_finance','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `uid` int(10) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ox_master_finance','status')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `status` tinyint(4) DEFAULT NULL COMMENT ' 0 未支付 1 已支付 2 已退款'");}
if(!pdo_fieldexists('ox_master_finance','type')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `type` int(11) NOT NULL COMMENT '类型'");}
if(!pdo_fieldexists('ox_master_finance','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_finance')." ADD   `create_time` int(11) NOT NULL COMMENT '支付时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_formid` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `form_id` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '使用状态，0未使用 1已使用',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=830 DEFAULT CHARSET=utf8 COMMENT='from_id 记录表';

");

if(!pdo_fieldexists('ox_master_formid','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_formid')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_formid','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_formid')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_formid','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_formid')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_formid','form_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_formid')." ADD   `form_id` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_formid','status')) {pdo_query("ALTER TABLE ".tablename('ox_master_formid')." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '使用状态，0未使用 1已使用'");}
if(!pdo_fieldexists('ox_master_formid','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_formid')." ADD   `create_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `order_id` int(11) DEFAULT NULL COMMENT '汽车id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `img_patch` text COMMENT '图片地址',
  `type` tinyint(2) DEFAULT NULL COMMENT '图片类型 1 订单图片 2 店铺详情',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `sort` varchar(10) NOT NULL COMMENT '排序',
  `store_id` int(10) NOT NULL COMMENT '店铺id',
  PRIMARY KEY (`id`,`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_image','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_image')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片id'");}
if(!pdo_fieldexists('ox_master_image','order_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_image')." ADD   `order_id` int(11) DEFAULT NULL COMMENT '汽车id'");}
if(!pdo_fieldexists('ox_master_image','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_image')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_image','img_patch')) {pdo_query("ALTER TABLE ".tablename('ox_master_image')." ADD   `img_patch` text COMMENT '图片地址'");}
if(!pdo_fieldexists('ox_master_image','type')) {pdo_query("ALTER TABLE ".tablename('ox_master_image')." ADD   `type` tinyint(2) DEFAULT NULL COMMENT '图片类型 1 订单图片 2 店铺详情'");}
if(!pdo_fieldexists('ox_master_image','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_image')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_master_image','sort')) {pdo_query("ALTER TABLE ".tablename('ox_master_image')." ADD   `sort` varchar(10) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ox_master_image','store_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_image')." ADD   `store_id` int(10) NOT NULL COMMENT '店铺id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(10) NOT NULL COMMENT '小程序id',
  `content` varchar(50) NOT NULL COMMENT '消息模版id',
  `type` tinyint(4) NOT NULL COMMENT '1 注册通知 2 接单通知',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_message','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_message')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_master_message','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_message')." ADD   `uniacid` int(10) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_message','content')) {pdo_query("ALTER TABLE ".tablename('ox_master_message')." ADD   `content` varchar(50) NOT NULL COMMENT '消息模版id'");}
if(!pdo_fieldexists('ox_master_message','type')) {pdo_query("ALTER TABLE ".tablename('ox_master_message')." ADD   `type` tinyint(4) NOT NULL COMMENT '1 注册通知 2 接单通知'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '资金变动用户',
  `from_uid` int(11) DEFAULT '0' COMMENT '资金变动来源用户（非主字段可不填）',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '变动金额',
  `lock_money` decimal(10,2) DEFAULT '0.00' COMMENT '变动锁定金额',
  `type` tinyint(4) DEFAULT '0' COMMENT '0接单 1完工 2提现 3到账 4驳回提现',
  `desc` varchar(100) DEFAULT NULL COMMENT '描述',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `from_id` int(11) DEFAULT '0' COMMENT '来源id 订单id或提现表id',
  `from_table` varchar(100) DEFAULT NULL COMMENT '来源表名，不带ims_',
  `last_money` decimal(10,2) DEFAULT '0.00' COMMENT '最终余额',
  `last_lock_money` decimal(10,2) DEFAULT '0.00' COMMENT '最终锁定余额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=473 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_money_log','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_money_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_money_log','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `uid` int(11) DEFAULT NULL COMMENT '资金变动用户'");}
if(!pdo_fieldexists('ox_master_money_log','from_uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `from_uid` int(11) DEFAULT '0' COMMENT '资金变动来源用户（非主字段可不填）'");}
if(!pdo_fieldexists('ox_master_money_log','money')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '变动金额'");}
if(!pdo_fieldexists('ox_master_money_log','lock_money')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `lock_money` decimal(10,2) DEFAULT '0.00' COMMENT '变动锁定金额'");}
if(!pdo_fieldexists('ox_master_money_log','type')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `type` tinyint(4) DEFAULT '0' COMMENT '0接单 1完工 2提现 3到账 4驳回提现'");}
if(!pdo_fieldexists('ox_master_money_log','desc')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `desc` varchar(100) DEFAULT NULL COMMENT '描述'");}
if(!pdo_fieldexists('ox_master_money_log','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_master_money_log','from_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `from_id` int(11) DEFAULT '0' COMMENT '来源id 订单id或提现表id'");}
if(!pdo_fieldexists('ox_master_money_log','from_table')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `from_table` varchar(100) DEFAULT NULL COMMENT '来源表名，不带ims_'");}
if(!pdo_fieldexists('ox_master_money_log','last_money')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `last_money` decimal(10,2) DEFAULT '0.00' COMMENT '最终余额'");}
if(!pdo_fieldexists('ox_master_money_log','last_lock_money')) {pdo_query("ALTER TABLE ".tablename('ox_master_money_log')." ADD   `last_lock_money` decimal(10,2) DEFAULT '0.00' COMMENT '最终锁定余额'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `type_name` varchar(20) DEFAULT NULL COMMENT '维修类型',
  `formid` varchar(50) DEFAULT NULL COMMENT '模板消息id',
  `uid` int(10) DEFAULT NULL COMMENT '报修人id',
  `repair_uid` int(10) DEFAULT NULL COMMENT '师傅id',
  `mapy` decimal(10,4) DEFAULT NULL COMMENT '经纬度',
  `mapx` decimal(10,4) DEFAULT NULL COMMENT '经纬度',
  `o_sn` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `sure_o_sn` varchar(50) DEFAULT NULL COMMENT '竞标支付订单编号',
  `address` varchar(200) DEFAULT NULL COMMENT '维修地址',
  `address_detail` varchar(200) DEFAULT NULL COMMENT '详细地址',
  `name` varchar(20) DEFAULT NULL COMMENT '联系人姓名',
  `phone` varchar(11) DEFAULT NULL COMMENT '联系电话',
  `remark` text COMMENT '故障描述',
  `money` decimal(10,2) DEFAULT NULL COMMENT '保证金',
  `sure_price` decimal(10,2) DEFAULT NULL COMMENT '竞标确认价格',
  `status` tinyint(4) DEFAULT NULL COMMENT '0 未接单 1 已接单 2 已取消(流拍) 3 已完成  4，申请退款，5，退款成功',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 0 未支付 1 已支付',
  `bid_num` int(10) NOT NULL DEFAULT '0' COMMENT '竞标人数',
  `img_patch` varchar(100) DEFAULT NULL COMMENT '故障主图',
  `go_time` int(10) DEFAULT NULL COMMENT '预约上门时间',
  `taking_time` int(10) DEFAULT NULL COMMENT '接单时间',
  `end_time` int(10) DEFAULT NULL COMMENT '完成时间',
  `appraise` tinyint(4) DEFAULT NULL COMMENT '0 未评价 1 已评价',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `district` varchar(20) DEFAULT NULL COMMENT '区',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_order','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_order','type_name')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `type_name` varchar(20) DEFAULT NULL COMMENT '维修类型'");}
if(!pdo_fieldexists('ox_master_order','formid')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `formid` varchar(50) DEFAULT NULL COMMENT '模板消息id'");}
if(!pdo_fieldexists('ox_master_order','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `uid` int(10) DEFAULT NULL COMMENT '报修人id'");}
if(!pdo_fieldexists('ox_master_order','repair_uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `repair_uid` int(10) DEFAULT NULL COMMENT '师傅id'");}
if(!pdo_fieldexists('ox_master_order','mapy')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `mapy` decimal(10,4) DEFAULT NULL COMMENT '经纬度'");}
if(!pdo_fieldexists('ox_master_order','mapx')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `mapx` decimal(10,4) DEFAULT NULL COMMENT '经纬度'");}
if(!pdo_fieldexists('ox_master_order','o_sn')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `o_sn` varchar(50) DEFAULT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ox_master_order','sure_o_sn')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `sure_o_sn` varchar(50) DEFAULT NULL COMMENT '竞标支付订单编号'");}
if(!pdo_fieldexists('ox_master_order','address')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `address` varchar(200) DEFAULT NULL COMMENT '维修地址'");}
if(!pdo_fieldexists('ox_master_order','address_detail')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `address_detail` varchar(200) DEFAULT NULL COMMENT '详细地址'");}
if(!pdo_fieldexists('ox_master_order','name')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `name` varchar(20) DEFAULT NULL COMMENT '联系人姓名'");}
if(!pdo_fieldexists('ox_master_order','phone')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `phone` varchar(11) DEFAULT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ox_master_order','remark')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `remark` text COMMENT '故障描述'");}
if(!pdo_fieldexists('ox_master_order','money')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '保证金'");}
if(!pdo_fieldexists('ox_master_order','sure_price')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `sure_price` decimal(10,2) DEFAULT NULL COMMENT '竞标确认价格'");}
if(!pdo_fieldexists('ox_master_order','status')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `status` tinyint(4) DEFAULT NULL COMMENT '0 未接单 1 已接单 2 已取消(流拍) 3 已完成  4，申请退款，5，退款成功'");}
if(!pdo_fieldexists('ox_master_order','pay_status')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 0 未支付 1 已支付'");}
if(!pdo_fieldexists('ox_master_order','bid_num')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `bid_num` int(10) NOT NULL DEFAULT '0' COMMENT '竞标人数'");}
if(!pdo_fieldexists('ox_master_order','img_patch')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `img_patch` varchar(100) DEFAULT NULL COMMENT '故障主图'");}
if(!pdo_fieldexists('ox_master_order','go_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `go_time` int(10) DEFAULT NULL COMMENT '预约上门时间'");}
if(!pdo_fieldexists('ox_master_order','taking_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `taking_time` int(10) DEFAULT NULL COMMENT '接单时间'");}
if(!pdo_fieldexists('ox_master_order','end_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `end_time` int(10) DEFAULT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('ox_master_order','appraise')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `appraise` tinyint(4) DEFAULT NULL COMMENT '0 未评价 1 已评价'");}
if(!pdo_fieldexists('ox_master_order','province')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `province` varchar(20) DEFAULT NULL COMMENT '省'");}
if(!pdo_fieldexists('ox_master_order','city')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `city` varchar(20) DEFAULT NULL COMMENT '市'");}
if(!pdo_fieldexists('ox_master_order','district')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `district` varchar(20) DEFAULT NULL COMMENT '区'");}
if(!pdo_fieldexists('ox_master_order','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_order')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_refund` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `uid` int(11) NOT NULL COMMENT '申请人uid',
  `rid` int(11) NOT NULL COMMENT '维修师傅id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `price` decimal(12,2) NOT NULL COMMENT '退款金额',
  `status` tinyint(1) DEFAULT NULL COMMENT '1,申请退款，2，同意退款，3，拒绝退款，4，退款成功',
  `create_time` int(11) DEFAULT NULL COMMENT 't退款时间',
  `reason` text COMMENT '退款原因',
  `refund_describe` text COMMENT '拒绝退款原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_refund','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_refund','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_refund','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD   `uid` int(11) NOT NULL COMMENT '申请人uid'");}
if(!pdo_fieldexists('ox_master_refund','rid')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD   `rid` int(11) NOT NULL COMMENT '维修师傅id'");}
if(!pdo_fieldexists('ox_master_refund','order_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD   `order_id` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('ox_master_refund','price')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD   `price` decimal(12,2) NOT NULL COMMENT '退款金额'");}
if(!pdo_fieldexists('ox_master_refund','status')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD   `status` tinyint(1) DEFAULT NULL COMMENT '1,申请退款，2，同意退款，3，拒绝退款，4，退款成功'");}
if(!pdo_fieldexists('ox_master_refund','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD   `create_time` int(11) DEFAULT NULL COMMENT 't退款时间'");}
if(!pdo_fieldexists('ox_master_refund','reason')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD   `reason` text COMMENT '退款原因'");}
if(!pdo_fieldexists('ox_master_refund','refund_describe')) {pdo_query("ALTER TABLE ".tablename('ox_master_refund')." ADD   `refund_describe` text COMMENT '拒绝退款原因'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_sms_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `send_account` text NOT NULL COMMENT '发送账号',
  `records_type` int(11) NOT NULL DEFAULT '0' COMMENT '记录类型  1订单通知',
  `notice_content` text NOT NULL COMMENT '发送内容',
  `send_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发送状态， 1发送成功  2发送失败',
  `send_message` varchar(255) NOT NULL DEFAULT '' COMMENT '发送返回结果',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='通知记录';

");

if(!pdo_fieldexists('ox_master_sms_records','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_records')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_sms_records','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_records')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_sms_records','send_account')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_records')." ADD   `send_account` text NOT NULL COMMENT '发送账号'");}
if(!pdo_fieldexists('ox_master_sms_records','records_type')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_records')." ADD   `records_type` int(11) NOT NULL DEFAULT '0' COMMENT '记录类型  1订单通知'");}
if(!pdo_fieldexists('ox_master_sms_records','notice_content')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_records')." ADD   `notice_content` text NOT NULL COMMENT '发送内容'");}
if(!pdo_fieldexists('ox_master_sms_records','send_status')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_records')." ADD   `send_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发送状态， 1发送成功  2发送失败'");}
if(!pdo_fieldexists('ox_master_sms_records','send_message')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_records')." ADD   `send_message` varchar(255) NOT NULL DEFAULT '' COMMENT '发送返回结果'");}
if(!pdo_fieldexists('ox_master_sms_records','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_records')." ADD   `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_sms_template` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '模板id',
  `uniacid` int(11) DEFAULT '0',
  `template_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名称',
  `template_code` varchar(50) NOT NULL DEFAULT '' COMMENT '模板编号',
  `template_title` varchar(50) NOT NULL DEFAULT '' COMMENT '模板id',
  `template_content` text NOT NULL COMMENT '模板内容',
  `is_enable` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`template_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='短信模版设置';

");

if(!pdo_fieldexists('ox_master_sms_template','template_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_template')." ADD 
  `template_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '模板id'");}
if(!pdo_fieldexists('ox_master_sms_template','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_template')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('ox_master_sms_template','template_name')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_template')." ADD   `template_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名称'");}
if(!pdo_fieldexists('ox_master_sms_template','template_code')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_template')." ADD   `template_code` varchar(50) NOT NULL DEFAULT '' COMMENT '模板编号'");}
if(!pdo_fieldexists('ox_master_sms_template','template_title')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_template')." ADD   `template_title` varchar(50) NOT NULL DEFAULT '' COMMENT '模板id'");}
if(!pdo_fieldexists('ox_master_sms_template','template_content')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_template')." ADD   `template_content` text NOT NULL COMMENT '模板内容'");}
if(!pdo_fieldexists('ox_master_sms_template','is_enable')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_template')." ADD   `is_enable` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启'");}
if(!pdo_fieldexists('ox_master_sms_template','update_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_sms_template')." ADD   `update_time` int(11) DEFAULT '0' COMMENT '更新时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_store` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺id',
  `uniacid` int(10) NOT NULL COMMENT '小程序id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `type_name` varchar(255) DEFAULT NULL COMMENT '服务类型',
  `type_id` varchar(60) DEFAULT NULL COMMENT '服务类型id',
  `wechat_qrcode` varchar(100) NOT NULL COMMENT '店铺客服微信二维码',
  `cover` varchar(100) NOT NULL COMMENT '店铺封面',
  `age` tinyint(4) DEFAULT '0' COMMENT '年龄',
  `sex` tinyint(4) DEFAULT NULL COMMENT '性别 1 男 2 女',
  `name` varchar(50) NOT NULL COMMENT '师傅姓名',
  `address` varchar(50) DEFAULT NULL COMMENT '店铺地址',
  `address_detail` varchar(50) DEFAULT NULL COMMENT '详细地址',
  `detail` text COMMENT '师傅个人描述',
  `phone` varchar(20) NOT NULL COMMENT '服务电话',
  `mapx` decimal(10,6) DEFAULT NULL COMMENT '经纬度',
  `mapy` decimal(10,6) DEFAULT NULL COMMENT '经纬度',
  `isoff` tinyint(4) DEFAULT NULL COMMENT '是否休息 0 休息中 1 营业中',
  `formid` varchar(50) DEFAULT NULL COMMENT '注册消息模板id',
  `status` tinyint(4) DEFAULT NULL COMMENT '0 未审核 1 已审核 2 已拒绝',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '账户资金',
  `lock_money` decimal(10,2) DEFAULT '0.00' COMMENT '锁定的账户资金',
  `black` int(11) unsigned DEFAULT '0' COMMENT '黑名单用户-后台删除 非0即为黑',
  `reject` varchar(255) DEFAULT NULL COMMENT '拒绝原因',
  `province` varchar(50) DEFAULT NULL COMMENT '省',
  `city` varchar(50) DEFAULT NULL COMMENT '市',
  `district` varchar(50) DEFAULT NULL COMMENT '区县',
  `remark` varchar(255) DEFAULT NULL COMMENT '后台设置备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='店铺详情表';

");

if(!pdo_fieldexists('ox_master_store','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺id'");}
if(!pdo_fieldexists('ox_master_store','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `uniacid` int(10) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_store','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ox_master_store','type_name')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `type_name` varchar(255) DEFAULT NULL COMMENT '服务类型'");}
if(!pdo_fieldexists('ox_master_store','type_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `type_id` varchar(60) DEFAULT NULL COMMENT '服务类型id'");}
if(!pdo_fieldexists('ox_master_store','wechat_qrcode')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `wechat_qrcode` varchar(100) NOT NULL COMMENT '店铺客服微信二维码'");}
if(!pdo_fieldexists('ox_master_store','cover')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `cover` varchar(100) NOT NULL COMMENT '店铺封面'");}
if(!pdo_fieldexists('ox_master_store','age')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `age` tinyint(4) DEFAULT '0' COMMENT '年龄'");}
if(!pdo_fieldexists('ox_master_store','sex')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `sex` tinyint(4) DEFAULT NULL COMMENT '性别 1 男 2 女'");}
if(!pdo_fieldexists('ox_master_store','name')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `name` varchar(50) NOT NULL COMMENT '师傅姓名'");}
if(!pdo_fieldexists('ox_master_store','address')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `address` varchar(50) DEFAULT NULL COMMENT '店铺地址'");}
if(!pdo_fieldexists('ox_master_store','address_detail')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `address_detail` varchar(50) DEFAULT NULL COMMENT '详细地址'");}
if(!pdo_fieldexists('ox_master_store','detail')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `detail` text COMMENT '师傅个人描述'");}
if(!pdo_fieldexists('ox_master_store','phone')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `phone` varchar(20) NOT NULL COMMENT '服务电话'");}
if(!pdo_fieldexists('ox_master_store','mapx')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `mapx` decimal(10,6) DEFAULT NULL COMMENT '经纬度'");}
if(!pdo_fieldexists('ox_master_store','mapy')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `mapy` decimal(10,6) DEFAULT NULL COMMENT '经纬度'");}
if(!pdo_fieldexists('ox_master_store','isoff')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `isoff` tinyint(4) DEFAULT NULL COMMENT '是否休息 0 休息中 1 营业中'");}
if(!pdo_fieldexists('ox_master_store','formid')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `formid` varchar(50) DEFAULT NULL COMMENT '注册消息模板id'");}
if(!pdo_fieldexists('ox_master_store','status')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `status` tinyint(4) DEFAULT NULL COMMENT '0 未审核 1 已审核 2 已拒绝'");}
if(!pdo_fieldexists('ox_master_store','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_master_store','money')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '账户资金'");}
if(!pdo_fieldexists('ox_master_store','lock_money')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `lock_money` decimal(10,2) DEFAULT '0.00' COMMENT '锁定的账户资金'");}
if(!pdo_fieldexists('ox_master_store','black')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `black` int(11) unsigned DEFAULT '0' COMMENT '黑名单用户-后台删除 非0即为黑'");}
if(!pdo_fieldexists('ox_master_store','reject')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `reject` varchar(255) DEFAULT NULL COMMENT '拒绝原因'");}
if(!pdo_fieldexists('ox_master_store','province')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `province` varchar(50) DEFAULT NULL COMMENT '省'");}
if(!pdo_fieldexists('ox_master_store','city')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `city` varchar(50) DEFAULT NULL COMMENT '市'");}
if(!pdo_fieldexists('ox_master_store','district')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `district` varchar(50) DEFAULT NULL COMMENT '区县'");}
if(!pdo_fieldexists('ox_master_store','remark')) {pdo_query("ALTER TABLE ".tablename('ox_master_store')." ADD   `remark` varchar(255) DEFAULT NULL COMMENT '后台设置备注'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_suggest` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(10) DEFAULT NULL COMMENT '小程序id',
  `content` text COMMENT '反馈内容',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='意见反馈';

");

if(!pdo_fieldexists('ox_master_suggest','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_suggest')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_suggest','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_suggest')." ADD   `uid` int(10) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ox_master_suggest','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_suggest')." ADD   `uniacid` int(10) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_master_suggest','content')) {pdo_query("ALTER TABLE ".tablename('ox_master_suggest')." ADD   `content` text COMMENT '反馈内容'");}
if(!pdo_fieldexists('ox_master_suggest','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_suggest')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_take_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '资金变动用户',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `money` decimal(10,2) DEFAULT NULL COMMENT '提现金额',
  `arrival_money` decimal(10,2) DEFAULT NULL COMMENT '实际到账金额',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态 0未审核 1已通过 2已驳回',
  `outTradeNo` varchar(50) DEFAULT NULL COMMENT '提现单号',
  `order_describe` varchar(255) DEFAULT NULL COMMENT '订单驳回原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='提现';

");

if(!pdo_fieldexists('ox_master_take_log','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_take_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_take_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_take_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_take_log','uid')) {pdo_query("ALTER TABLE ".tablename('ox_master_take_log')." ADD   `uid` int(11) DEFAULT NULL COMMENT '资金变动用户'");}
if(!pdo_fieldexists('ox_master_take_log','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_take_log')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_master_take_log','money')) {pdo_query("ALTER TABLE ".tablename('ox_master_take_log')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('ox_master_take_log','arrival_money')) {pdo_query("ALTER TABLE ".tablename('ox_master_take_log')." ADD   `arrival_money` decimal(10,2) DEFAULT NULL COMMENT '实际到账金额'");}
if(!pdo_fieldexists('ox_master_take_log','status')) {pdo_query("ALTER TABLE ".tablename('ox_master_take_log')." ADD   `status` tinyint(4) DEFAULT '0' COMMENT '状态 0未审核 1已通过 2已驳回'");}
if(!pdo_fieldexists('ox_master_take_log','outTradeNo')) {pdo_query("ALTER TABLE ".tablename('ox_master_take_log')." ADD   `outTradeNo` varchar(50) DEFAULT NULL COMMENT '提现单号'");}
if(!pdo_fieldexists('ox_master_take_log','order_describe')) {pdo_query("ALTER TABLE ".tablename('ox_master_take_log')." ADD   `order_describe` varchar(255) DEFAULT NULL COMMENT '订单驳回原因'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '产品分类id',
  `name` varchar(20) DEFAULT NULL COMMENT '分类名称',
  `title` varchar(100) DEFAULT NULL COMMENT '分类副标题',
  `sort` tinyint(2) DEFAULT NULL COMMENT '排序',
  `uniacid` int(11) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL COMMENT '分类图片',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `class_level` int(11) DEFAULT '0' COMMENT '分类基本 0：一级分类 1 二级分类',
  `parent_id` int(11) DEFAULT '0' COMMENT '上级分类id',
  `show_num` int(11) DEFAULT '0' COMMENT '首页显示二级分类的个数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_type','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '产品分类id'");}
if(!pdo_fieldexists('ox_master_type','name')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD   `name` varchar(20) DEFAULT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ox_master_type','title')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD   `title` varchar(100) DEFAULT NULL COMMENT '分类副标题'");}
if(!pdo_fieldexists('ox_master_type','sort')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD   `sort` tinyint(2) DEFAULT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ox_master_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_type','img')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD   `img` varchar(100) DEFAULT NULL COMMENT '分类图片'");}
if(!pdo_fieldexists('ox_master_type','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_master_type','class_level')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD   `class_level` int(11) DEFAULT '0' COMMENT '分类基本 0：一级分类 1 二级分类'");}
if(!pdo_fieldexists('ox_master_type','parent_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD   `parent_id` int(11) DEFAULT '0' COMMENT '上级分类id'");}
if(!pdo_fieldexists('ox_master_type','show_num')) {pdo_query("ALTER TABLE ".tablename('ox_master_type')." ADD   `show_num` int(11) DEFAULT '0' COMMENT '首页显示二级分类的个数'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_uniform` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `appid` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT '0 关闭 1 开启',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_uniform','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_uniform','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_uniform','appid')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform')." ADD   `appid` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_uniform','status')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform')." ADD   `status` tinyint(4) DEFAULT '0' COMMENT '0 关闭 1 开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_uniform_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `appid` varchar(50) DEFAULT NULL,
  `template_id` varchar(50) DEFAULT NULL,
  `first` varchar(50) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_uniform_template','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform_template')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_uniform_template','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform_template')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_uniform_template','appid')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform_template')." ADD   `appid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_uniform_template','template_id')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform_template')." ADD   `template_id` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_uniform_template','first')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform_template')." ADD   `first` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_uniform_template','remark')) {pdo_query("ALTER TABLE ".tablename('ox_master_uniform_template')." ADD   `remark` varchar(50) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_unipush` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `appid` varchar(50) DEFAULT NULL,
  `appkey` varchar(50) DEFAULT NULL,
  `mastersecret` varchar(50) DEFAULT NULL,
  `appsecret` varchar(50) DEFAULT NULL COMMENT '签名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_unipush','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_unipush')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_unipush','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_unipush')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_unipush','appid')) {pdo_query("ALTER TABLE ".tablename('ox_master_unipush')." ADD   `appid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_unipush','appkey')) {pdo_query("ALTER TABLE ".tablename('ox_master_unipush')." ADD   `appkey` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_unipush','mastersecret')) {pdo_query("ALTER TABLE ".tablename('ox_master_unipush')." ADD   `mastersecret` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_unipush','appsecret')) {pdo_query("ALTER TABLE ".tablename('ox_master_unipush')." ADD   `appsecret` varchar(50) DEFAULT NULL COMMENT '签名'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_master_view` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL COMMENT '标题',
  `content` text,
  `sort` tinyint(4) DEFAULT NULL COMMENT ' 排序',
  `type` tinyint(4) DEFAULT NULL COMMENT ' 1 关于我们 2 操作指南',
  `create_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_master_view','id')) {pdo_query("ALTER TABLE ".tablename('ox_master_view')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_master_view','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_master_view')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_master_view','title')) {pdo_query("ALTER TABLE ".tablename('ox_master_view')." ADD   `title` varchar(20) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ox_master_view','content')) {pdo_query("ALTER TABLE ".tablename('ox_master_view')." ADD   `content` text");}
if(!pdo_fieldexists('ox_master_view','sort')) {pdo_query("ALTER TABLE ".tablename('ox_master_view')." ADD   `sort` tinyint(4) DEFAULT NULL COMMENT ' 排序'");}
if(!pdo_fieldexists('ox_master_view','type')) {pdo_query("ALTER TABLE ".tablename('ox_master_view')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT ' 1 关于我们 2 操作指南'");}
if(!pdo_fieldexists('ox_master_view','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_master_view')." ADD   `create_time` int(10) DEFAULT NULL");}
