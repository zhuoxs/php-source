<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_address` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `latitude` decimal(10,4) DEFAULT NULL COMMENT 'mapx',
  `longitude` decimal(11,4) DEFAULT NULL COMMENT 'mapy',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `district` varchar(20) DEFAULT NULL COMMENT '区/县',
  `name` varchar(20) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(11) DEFAULT NULL COMMENT '联系方式',
  `address` varchar(50) DEFAULT NULL COMMENT '服务地址',
  `address_detail` varchar(50) DEFAULT NULL COMMENT '详细地址',
  `default` tinyint(4) DEFAULT NULL COMMENT '1 是默认',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_address','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_address','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `uid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_address','latitude')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `latitude` decimal(10,4) DEFAULT NULL COMMENT 'mapx'");}
if(!pdo_fieldexists('ox_reclaim_address','longitude')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `longitude` decimal(11,4) DEFAULT NULL COMMENT 'mapy'");}
if(!pdo_fieldexists('ox_reclaim_address','province')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `province` varchar(20) DEFAULT NULL COMMENT '省'");}
if(!pdo_fieldexists('ox_reclaim_address','city')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `city` varchar(20) DEFAULT NULL COMMENT '市'");}
if(!pdo_fieldexists('ox_reclaim_address','district')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `district` varchar(20) DEFAULT NULL COMMENT '区/县'");}
if(!pdo_fieldexists('ox_reclaim_address','name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `name` varchar(20) DEFAULT NULL COMMENT '联系人'");}
if(!pdo_fieldexists('ox_reclaim_address','phone')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `phone` varchar(11) DEFAULT NULL COMMENT '联系方式'");}
if(!pdo_fieldexists('ox_reclaim_address','address')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `address` varchar(50) DEFAULT NULL COMMENT '服务地址'");}
if(!pdo_fieldexists('ox_reclaim_address','address_detail')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `address_detail` varchar(50) DEFAULT NULL COMMENT '详细地址'");}
if(!pdo_fieldexists('ox_reclaim_address','default')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `default` tinyint(4) DEFAULT NULL COMMENT '1 是默认'");}
if(!pdo_fieldexists('ox_reclaim_address','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_address')." ADD   `create_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_banner` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(10) DEFAULT NULL COMMENT '小程序id',
  `img` varchar(100) DEFAULT NULL COMMENT '图片地址',
  `url` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

");

if(!pdo_fieldexists('ox_reclaim_banner','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_banner')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reclaim_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_banner')." ADD   `uniacid` int(10) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reclaim_banner','img')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_banner')." ADD   `img` varchar(100) DEFAULT NULL COMMENT '图片地址'");}
if(!pdo_fieldexists('ox_reclaim_banner','url')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_banner')." ADD   `url` varchar(255) DEFAULT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('ox_reclaim_banner','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_banner')." ADD   `sort` int(10) DEFAULT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ox_reclaim_banner','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_banner')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_city` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '开通城市id',
  `uniacid` int(10) DEFAULT NULL COMMENT '小程序id',
  `province` varchar(20) DEFAULT NULL COMMENT '省份名称',
  `city_name` varchar(20) DEFAULT NULL COMMENT '城市名称',
  `status` tinyint(4) DEFAULT '0' COMMENT '开通状态 0 未开通 1 已开通',
  `create_time` int(10) DEFAULT NULL COMMENT '申请时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

");

if(!pdo_fieldexists('ox_reclaim_city','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_city')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '开通城市id'");}
if(!pdo_fieldexists('ox_reclaim_city','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_city')." ADD   `uniacid` int(10) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reclaim_city','province')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_city')." ADD   `province` varchar(20) DEFAULT NULL COMMENT '省份名称'");}
if(!pdo_fieldexists('ox_reclaim_city','city_name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_city')." ADD   `city_name` varchar(20) DEFAULT NULL COMMENT '城市名称'");}
if(!pdo_fieldexists('ox_reclaim_city','status')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_city')." ADD   `status` tinyint(4) DEFAULT '0' COMMENT '开通状态 0 未开通 1 已开通'");}
if(!pdo_fieldexists('ox_reclaim_city','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_city')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '申请时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_cycle` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `uid` int(10) DEFAULT NULL,
  `order_id` int(10) DEFAULT NULL COMMENT '订单id',
  `account` decimal(10,2) DEFAULT NULL COMMENT '订单金额',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `admin_uid` int(11) unsigned DEFAULT NULL COMMENT '操作员id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_cycle','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_cycle')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_cycle','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_cycle')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_cycle','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_cycle')." ADD   `uid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_cycle','order_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_cycle')." ADD   `order_id` int(10) DEFAULT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('ox_reclaim_cycle','account')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_cycle')." ADD   `account` decimal(10,2) DEFAULT NULL COMMENT '订单金额'");}
if(!pdo_fieldexists('ox_reclaim_cycle','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_cycle')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reclaim_cycle','admin_uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_cycle')." ADD   `admin_uid` int(11) unsigned DEFAULT NULL COMMENT '操作员id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_formid` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `form_id` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '使用状态，0未使用 1已使用',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=751 DEFAULT CHARSET=utf8 COMMENT='from_id 记录表';

");

if(!pdo_fieldexists('ox_reclaim_formid','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_formid')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_formid','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_formid')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_formid','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_formid')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_formid','form_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_formid')." ADD   `form_id` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_formid','status')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_formid')." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '使用状态，0未使用 1已使用'");}
if(!pdo_fieldexists('ox_reclaim_formid','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_formid')." ADD   `create_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_goods` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(10) DEFAULT NULL COMMENT '小程序id',
  `title` varchar(255) DEFAULT NULL COMMENT '短标题',
  `name` varchar(255) DEFAULT NULL COMMENT '长标题',
  `img` varchar(255) DEFAULT NULL COMMENT '主图',
  `integral` int(10) unsigned DEFAULT NULL COMMENT '所需积分',
  `price` decimal(10,2) DEFAULT NULL COMMENT '所需余额',
  `list_price` decimal(10,2) DEFAULT NULL COMMENT '市场价',
  `details` text COMMENT '详情',
  `num` int(10) DEFAULT '0' COMMENT '数量',
  `state` tinyint(4) DEFAULT '1' COMMENT '1 正常  2下架 3售罄',
  `del_time` int(10) unsigned DEFAULT '0' COMMENT '0正常 大于0已删除',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `sort` tinyint(4) DEFAULT '0' COMMENT '排序 由大到小',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

");

if(!pdo_fieldexists('ox_reclaim_goods','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reclaim_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `uniacid` int(10) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reclaim_goods','title')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '短标题'");}
if(!pdo_fieldexists('ox_reclaim_goods','name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '长标题'");}
if(!pdo_fieldexists('ox_reclaim_goods','img')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `img` varchar(255) DEFAULT NULL COMMENT '主图'");}
if(!pdo_fieldexists('ox_reclaim_goods','integral')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `integral` int(10) unsigned DEFAULT NULL COMMENT '所需积分'");}
if(!pdo_fieldexists('ox_reclaim_goods','price')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `price` decimal(10,2) DEFAULT NULL COMMENT '所需余额'");}
if(!pdo_fieldexists('ox_reclaim_goods','list_price')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `list_price` decimal(10,2) DEFAULT NULL COMMENT '市场价'");}
if(!pdo_fieldexists('ox_reclaim_goods','details')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `details` text COMMENT '详情'");}
if(!pdo_fieldexists('ox_reclaim_goods','num')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `num` int(10) DEFAULT '0' COMMENT '数量'");}
if(!pdo_fieldexists('ox_reclaim_goods','state')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `state` tinyint(4) DEFAULT '1' COMMENT '1 正常  2下架 3售罄'");}
if(!pdo_fieldexists('ox_reclaim_goods','del_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `del_time` int(10) unsigned DEFAULT '0' COMMENT '0正常 大于0已删除'");}
if(!pdo_fieldexists('ox_reclaim_goods','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reclaim_goods','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_goods')." ADD   `sort` tinyint(4) DEFAULT '0' COMMENT '排序 由大到小'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `order_id` int(11) DEFAULT NULL COMMENT '汽车id',
  `img` text COMMENT '图片地址',
  `type` tinyint(2) DEFAULT NULL COMMENT '图片类型 1 订单图片',
  `sort` varchar(10) NOT NULL COMMENT '排序',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=555 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_image','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_image')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片id'");}
if(!pdo_fieldexists('ox_reclaim_image','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_image')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reclaim_image','order_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_image')." ADD   `order_id` int(11) DEFAULT NULL COMMENT '汽车id'");}
if(!pdo_fieldexists('ox_reclaim_image','img')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_image')." ADD   `img` text COMMENT '图片地址'");}
if(!pdo_fieldexists('ox_reclaim_image','type')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_image')." ADD   `type` tinyint(2) DEFAULT NULL COMMENT '图片类型 1 订单图片'");}
if(!pdo_fieldexists('ox_reclaim_image','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_image')." ADD   `sort` varchar(10) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ox_reclaim_image','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_image')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `title` varchar(100) DEFAULT NULL COMMENT '小程序标题',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `logo` varchar(255) DEFAULT NULL COMMENT 'logo',
  `appid` varchar(50) DEFAULT NULL COMMENT '公众号appid',
  `about` text COMMENT '联系我们',
  `one_type` tinyint(4) DEFAULT '1' COMMENT '一键预约类型 0 默认 1跳转页面 2跳转小程序 3关闭',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ox_reclaim_info','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_info')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reclaim_info','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_info')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reclaim_info','title')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_info')." ADD   `title` varchar(100) DEFAULT NULL COMMENT '小程序标题'");}
if(!pdo_fieldexists('ox_reclaim_info','phone')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_info')." ADD   `phone` varchar(20) DEFAULT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ox_reclaim_info','logo')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_info')." ADD   `logo` varchar(255) DEFAULT NULL COMMENT 'logo'");}
if(!pdo_fieldexists('ox_reclaim_info','appid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_info')." ADD   `appid` varchar(50) DEFAULT NULL COMMENT '公众号appid'");}
if(!pdo_fieldexists('ox_reclaim_info','about')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_info')." ADD   `about` text COMMENT '联系我们'");}
if(!pdo_fieldexists('ox_reclaim_info','one_type')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_info')." ADD   `one_type` tinyint(4) DEFAULT '1' COMMENT '一键预约类型 0 默认 1跳转页面 2跳转小程序 3关闭'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺id',
  `uniacid` int(10) NOT NULL COMMENT '小程序id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `nickname` varchar(60) DEFAULT NULL COMMENT '会员昵称',
  `phone` varchar(15) DEFAULT NULL COMMENT '手机号',
  `black` int(11) unsigned DEFAULT '0' COMMENT '黑名单用户-后台删除 非0即为黑',
  `reject` varchar(255) DEFAULT NULL COMMENT '拒绝原因',
  `ali_id` varchar(20) DEFAULT NULL COMMENT '支付宝账号',
  `wx_id` varchar(20) DEFAULT NULL COMMENT '微信账号',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '余额',
  `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `jiedan` tinyint(4) DEFAULT '0' COMMENT '接单人员 0不是 1是',
  `integral` int(11) unsigned DEFAULT '0' COMMENT '积分',
  `name` varchar(255) DEFAULT NULL COMMENT '接单人姓名',
  `ali_name` varchar(50) DEFAULT NULL COMMENT '支付宝姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='会员';

");

if(!pdo_fieldexists('ox_reclaim_member','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺id'");}
if(!pdo_fieldexists('ox_reclaim_member','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `uniacid` int(10) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reclaim_member','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ox_reclaim_member','avatar')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `avatar` varchar(255) DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('ox_reclaim_member','nickname')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `nickname` varchar(60) DEFAULT NULL COMMENT '会员昵称'");}
if(!pdo_fieldexists('ox_reclaim_member','phone')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `phone` varchar(15) DEFAULT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('ox_reclaim_member','black')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `black` int(11) unsigned DEFAULT '0' COMMENT '黑名单用户-后台删除 非0即为黑'");}
if(!pdo_fieldexists('ox_reclaim_member','reject')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `reject` varchar(255) DEFAULT NULL COMMENT '拒绝原因'");}
if(!pdo_fieldexists('ox_reclaim_member','ali_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `ali_id` varchar(20) DEFAULT NULL COMMENT '支付宝账号'");}
if(!pdo_fieldexists('ox_reclaim_member','wx_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `wx_id` varchar(20) DEFAULT NULL COMMENT '微信账号'");}
if(!pdo_fieldexists('ox_reclaim_member','money')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '余额'");}
if(!pdo_fieldexists('ox_reclaim_member','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reclaim_member','jiedan')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `jiedan` tinyint(4) DEFAULT '0' COMMENT '接单人员 0不是 1是'");}
if(!pdo_fieldexists('ox_reclaim_member','integral')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `integral` int(11) unsigned DEFAULT '0' COMMENT '积分'");}
if(!pdo_fieldexists('ox_reclaim_member','name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '接单人姓名'");}
if(!pdo_fieldexists('ox_reclaim_member','ali_name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_member')." ADD   `ali_name` varchar(50) DEFAULT NULL COMMENT '支付宝姓名'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '资金变动用户',
  `from_uid` int(11) DEFAULT '0' COMMENT '资金变动来源用户（非主字段可不填）',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '变动金额',
  `type` tinyint(4) DEFAULT '0' COMMENT '0订单 1完工 2提现 3驳回提现',
  `desc` varchar(100) DEFAULT NULL COMMENT '描述',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `from_id` int(11) DEFAULT '0' COMMENT '来源id 订单id或提现表id',
  `from_table` varchar(100) DEFAULT NULL COMMENT '来源表名，不带ims_',
  `last_money` decimal(10,2) DEFAULT '0.00' COMMENT '最终余额',
  `integral` int(10) NOT NULL DEFAULT '0',
  `last_integral` int(10) DEFAULT NULL COMMENT '积分余额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_money_log','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_money_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_money_log','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `uid` int(11) DEFAULT NULL COMMENT '资金变动用户'");}
if(!pdo_fieldexists('ox_reclaim_money_log','from_uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `from_uid` int(11) DEFAULT '0' COMMENT '资金变动来源用户（非主字段可不填）'");}
if(!pdo_fieldexists('ox_reclaim_money_log','money')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '变动金额'");}
if(!pdo_fieldexists('ox_reclaim_money_log','type')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `type` tinyint(4) DEFAULT '0' COMMENT '0订单 1完工 2提现 3驳回提现'");}
if(!pdo_fieldexists('ox_reclaim_money_log','desc')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `desc` varchar(100) DEFAULT NULL COMMENT '描述'");}
if(!pdo_fieldexists('ox_reclaim_money_log','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reclaim_money_log','from_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `from_id` int(11) DEFAULT '0' COMMENT '来源id 订单id或提现表id'");}
if(!pdo_fieldexists('ox_reclaim_money_log','from_table')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `from_table` varchar(100) DEFAULT NULL COMMENT '来源表名，不带ims_'");}
if(!pdo_fieldexists('ox_reclaim_money_log','last_money')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `last_money` decimal(10,2) DEFAULT '0.00' COMMENT '最终余额'");}
if(!pdo_fieldexists('ox_reclaim_money_log','integral')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `integral` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ox_reclaim_money_log','last_integral')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_money_log')." ADD   `last_integral` int(10) DEFAULT NULL COMMENT '积分余额'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `type_name` varchar(20) DEFAULT NULL COMMENT '回收类型',
  `formid` varchar(50) DEFAULT NULL COMMENT '模板消息id',
  `uid` int(10) DEFAULT NULL COMMENT '报修人id',
  `longitude` decimal(10,4) DEFAULT NULL COMMENT '经度',
  `latitude` decimal(10,4) DEFAULT NULL COMMENT '纬度',
  `o_sn` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `pay_sn` varchar(50) DEFAULT NULL COMMENT '竞标支付订单编号',
  `address` varchar(200) DEFAULT NULL COMMENT '维修地址',
  `address_detail` varchar(200) DEFAULT NULL COMMENT '详细地址',
  `name` varchar(20) DEFAULT NULL COMMENT '联系人姓名',
  `phone` varchar(11) DEFAULT NULL COMMENT '联系电话',
  `remark` text COMMENT '回收描述',
  `status` tinyint(4) DEFAULT NULL COMMENT '0 未接单 1 已接单 2 已取消 3 已完成 ',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 0 未支付 1 已支付',
  `cycle` int(11) DEFAULT '0' COMMENT '周期（天）',
  `go_time` int(10) DEFAULT NULL COMMENT '预约上门时间',
  `end_time` int(10) DEFAULT NULL COMMENT '完成时间',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `district` varchar(20) DEFAULT NULL COMMENT '区',
  `amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `last_time` int(11) DEFAULT '0' COMMENT '上一次回收时间',
  `admin_uid` int(11) unsigned DEFAULT '0' COMMENT '操作员id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_order','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_order','type_name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `type_name` varchar(20) DEFAULT NULL COMMENT '回收类型'");}
if(!pdo_fieldexists('ox_reclaim_order','formid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `formid` varchar(50) DEFAULT NULL COMMENT '模板消息id'");}
if(!pdo_fieldexists('ox_reclaim_order','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `uid` int(10) DEFAULT NULL COMMENT '报修人id'");}
if(!pdo_fieldexists('ox_reclaim_order','longitude')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `longitude` decimal(10,4) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('ox_reclaim_order','latitude')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `latitude` decimal(10,4) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('ox_reclaim_order','o_sn')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `o_sn` varchar(50) DEFAULT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ox_reclaim_order','pay_sn')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `pay_sn` varchar(50) DEFAULT NULL COMMENT '竞标支付订单编号'");}
if(!pdo_fieldexists('ox_reclaim_order','address')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `address` varchar(200) DEFAULT NULL COMMENT '维修地址'");}
if(!pdo_fieldexists('ox_reclaim_order','address_detail')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `address_detail` varchar(200) DEFAULT NULL COMMENT '详细地址'");}
if(!pdo_fieldexists('ox_reclaim_order','name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `name` varchar(20) DEFAULT NULL COMMENT '联系人姓名'");}
if(!pdo_fieldexists('ox_reclaim_order','phone')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `phone` varchar(11) DEFAULT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ox_reclaim_order','remark')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `remark` text COMMENT '回收描述'");}
if(!pdo_fieldexists('ox_reclaim_order','status')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `status` tinyint(4) DEFAULT NULL COMMENT '0 未接单 1 已接单 2 已取消 3 已完成 '");}
if(!pdo_fieldexists('ox_reclaim_order','pay_status')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 0 未支付 1 已支付'");}
if(!pdo_fieldexists('ox_reclaim_order','cycle')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `cycle` int(11) DEFAULT '0' COMMENT '周期（天）'");}
if(!pdo_fieldexists('ox_reclaim_order','go_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `go_time` int(10) DEFAULT NULL COMMENT '预约上门时间'");}
if(!pdo_fieldexists('ox_reclaim_order','end_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `end_time` int(10) DEFAULT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('ox_reclaim_order','province')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `province` varchar(20) DEFAULT NULL COMMENT '省'");}
if(!pdo_fieldexists('ox_reclaim_order','city')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `city` varchar(20) DEFAULT NULL COMMENT '市'");}
if(!pdo_fieldexists('ox_reclaim_order','district')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `district` varchar(20) DEFAULT NULL COMMENT '区'");}
if(!pdo_fieldexists('ox_reclaim_order','amount')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额'");}
if(!pdo_fieldexists('ox_reclaim_order','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reclaim_order','last_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `last_time` int(11) DEFAULT '0' COMMENT '上一次回收时间'");}
if(!pdo_fieldexists('ox_reclaim_order','admin_uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order')." ADD   `admin_uid` int(11) unsigned DEFAULT '0' COMMENT '操作员id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_order_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `pay_uid` int(10) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `o_sn` varchar(50) DEFAULT NULL,
  `account` decimal(10,2) DEFAULT NULL COMMENT '支付金额',
  `integral` int(10) DEFAULT NULL COMMENT '积分',
  `create_time` int(10) DEFAULT NULL,
  `pay_type` tinyint(4) DEFAULT '0' COMMENT '支付类型 0线上 1线下',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_order_pay','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order_pay')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_order_pay','order_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order_pay')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_order_pay','pay_uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order_pay')." ADD   `pay_uid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_order_pay','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order_pay')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_order_pay','o_sn')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order_pay')." ADD   `o_sn` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_order_pay','account')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order_pay')." ADD   `account` decimal(10,2) DEFAULT NULL COMMENT '支付金额'");}
if(!pdo_fieldexists('ox_reclaim_order_pay','integral')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order_pay')." ADD   `integral` int(10) DEFAULT NULL COMMENT '积分'");}
if(!pdo_fieldexists('ox_reclaim_order_pay','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order_pay')." ADD   `create_time` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_order_pay','pay_type')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_order_pay')." ADD   `pay_type` tinyint(4) DEFAULT '0' COMMENT '支付类型 0线上 1线下'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(10) DEFAULT NULL COMMENT '小程序id',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `name` varchar(255) DEFAULT NULL COMMENT '描述',
  `img` varchar(100) DEFAULT NULL COMMENT '图片地址',
  `pages` varchar(100) DEFAULT NULL COMMENT '页面路径',
  `appid` varchar(50) DEFAULT NULL COMMENT '跳转小程序id',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

");

if(!pdo_fieldexists('ox_reclaim_pages','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_pages')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reclaim_pages','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_pages')." ADD   `uniacid` int(10) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reclaim_pages','title')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_pages')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ox_reclaim_pages','name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_pages')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '描述'");}
if(!pdo_fieldexists('ox_reclaim_pages','img')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_pages')." ADD   `img` varchar(100) DEFAULT NULL COMMENT '图片地址'");}
if(!pdo_fieldexists('ox_reclaim_pages','pages')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_pages')." ADD   `pages` varchar(100) DEFAULT NULL COMMENT '页面路径'");}
if(!pdo_fieldexists('ox_reclaim_pages','appid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_pages')." ADD   `appid` varchar(50) DEFAULT NULL COMMENT '跳转小程序id'");}
if(!pdo_fieldexists('ox_reclaim_pages','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_pages')." ADD   `sort` int(10) DEFAULT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ox_reclaim_pages','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_pages')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_rule` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL COMMENT '要求标题',
  `img` varchar(100) DEFAULT NULL COMMENT '要求配图',
  `sort` tinyint(2) DEFAULT NULL COMMENT '排序',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_rule','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_rule')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_rule','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_rule')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_rule','title')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_rule')." ADD   `title` varchar(100) DEFAULT NULL COMMENT '要求标题'");}
if(!pdo_fieldexists('ox_reclaim_rule','img')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_rule')." ADD   `img` varchar(100) DEFAULT NULL COMMENT '要求配图'");}
if(!pdo_fieldexists('ox_reclaim_rule','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_rule')." ADD   `sort` tinyint(2) DEFAULT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ox_reclaim_rule','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_rule')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_shop_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `open` tinyint(4) DEFAULT '0' COMMENT '开关 0关闭 1开启',
  `pic` varchar(255) DEFAULT NULL COMMENT '头部背景图',
  `xiangou` tinyint(4) unsigned DEFAULT '0' COMMENT '每人单一商品限购数 0不限',
  `earn` text COMMENT '赚取积分文案',
  `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ox_reclaim_shop_info','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_info')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reclaim_shop_info','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_info')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reclaim_shop_info','open')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_info')." ADD   `open` tinyint(4) DEFAULT '0' COMMENT '开关 0关闭 1开启'");}
if(!pdo_fieldexists('ox_reclaim_shop_info','pic')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_info')." ADD   `pic` varchar(255) DEFAULT NULL COMMENT '头部背景图'");}
if(!pdo_fieldexists('ox_reclaim_shop_info','xiangou')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_info')." ADD   `xiangou` tinyint(4) unsigned DEFAULT '0' COMMENT '每人单一商品限购数 0不限'");}
if(!pdo_fieldexists('ox_reclaim_shop_info','earn')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_info')." ADD   `earn` text COMMENT '赚取积分文案'");}
if(!pdo_fieldexists('ox_reclaim_shop_info','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_info')." ADD   `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_shop_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `uid` int(10) DEFAULT NULL COMMENT '会员uid',
  `o_sn` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `name` varchar(20) DEFAULT NULL COMMENT '联系人姓名',
  `phone` varchar(11) DEFAULT NULL COMMENT '联系电话',
  `status` tinyint(4) DEFAULT NULL COMMENT '0 未支付 1 已支付 2 已发货 3 已完成 ',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品id',
  `integral` int(11) DEFAULT NULL COMMENT '积分',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `fahuo_time` int(11) unsigned DEFAULT NULL COMMENT '发货时间',
  `end_time` int(11) unsigned DEFAULT NULL COMMENT '完成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=380 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_shop_order','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_shop_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_shop_order','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `uid` int(10) DEFAULT NULL COMMENT '会员uid'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','o_sn')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `o_sn` varchar(50) DEFAULT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','address')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `address` varchar(200) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `name` varchar(20) DEFAULT NULL COMMENT '联系人姓名'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','phone')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `phone` varchar(11) DEFAULT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','status')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `status` tinyint(4) DEFAULT NULL COMMENT '0 未支付 1 已支付 2 已发货 3 已完成 '");}
if(!pdo_fieldexists('ox_reclaim_shop_order','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','goods_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `goods_id` int(11) DEFAULT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','integral')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `integral` int(11) DEFAULT NULL COMMENT '积分'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','price')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `price` decimal(10,2) DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','title')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','img')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `img` varchar(255) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','fahuo_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `fahuo_time` int(11) unsigned DEFAULT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('ox_reclaim_shop_order','end_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_shop_order')." ADD   `end_time` int(11) unsigned DEFAULT NULL COMMENT '完成时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_take_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '资金变动用户',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `money` decimal(10,2) DEFAULT NULL COMMENT '提现金额',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态 0未审核 1已通过 2已驳回',
  `describe` varchar(255) DEFAULT NULL COMMENT '订单驳回原因',
  `type` tinyint(4) DEFAULT NULL COMMENT '提现类型 1支付宝 2微信',
  `num` varchar(50) DEFAULT NULL COMMENT '提现账号',
  `admin_uid` int(11) unsigned DEFAULT '0' COMMENT '操作员',
  `name` varchar(50) DEFAULT NULL COMMENT '支付宝姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='机构提现表';

");

if(!pdo_fieldexists('ox_reclaim_take_log','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_take_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_take_log','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `uid` int(11) DEFAULT NULL COMMENT '资金变动用户'");}
if(!pdo_fieldexists('ox_reclaim_take_log','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reclaim_take_log','money')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('ox_reclaim_take_log','status')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `status` tinyint(4) DEFAULT '0' COMMENT '状态 0未审核 1已通过 2已驳回'");}
if(!pdo_fieldexists('ox_reclaim_take_log','describe')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `describe` varchar(255) DEFAULT NULL COMMENT '订单驳回原因'");}
if(!pdo_fieldexists('ox_reclaim_take_log','type')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '提现类型 1支付宝 2微信'");}
if(!pdo_fieldexists('ox_reclaim_take_log','num')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `num` varchar(50) DEFAULT NULL COMMENT '提现账号'");}
if(!pdo_fieldexists('ox_reclaim_take_log','admin_uid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `admin_uid` int(11) unsigned DEFAULT '0' COMMENT '操作员'");}
if(!pdo_fieldexists('ox_reclaim_take_log','name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_take_log')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '支付宝姓名'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '产品分类id',
  `name` varchar(20) DEFAULT NULL COMMENT '分类名称',
  `title` varchar(100) DEFAULT NULL COMMENT '分类副标题',
  `sort` tinyint(2) DEFAULT NULL COMMENT '排序',
  `uniacid` int(11) DEFAULT NULL,
  `content` text COMMENT '价格说明',
  `img` varchar(100) DEFAULT NULL COMMENT '分类图片',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `class_level` int(11) DEFAULT '0' COMMENT '分类基本 0：一级分类 1 二级分类',
  `parent_id` int(11) DEFAULT '0' COMMENT '上级分类id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_type','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '产品分类id'");}
if(!pdo_fieldexists('ox_reclaim_type','name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD   `name` varchar(20) DEFAULT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('ox_reclaim_type','title')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD   `title` varchar(100) DEFAULT NULL COMMENT '分类副标题'");}
if(!pdo_fieldexists('ox_reclaim_type','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD   `sort` tinyint(2) DEFAULT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ox_reclaim_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_type','content')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD   `content` text COMMENT '价格说明'");}
if(!pdo_fieldexists('ox_reclaim_type','img')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD   `img` varchar(100) DEFAULT NULL COMMENT '分类图片'");}
if(!pdo_fieldexists('ox_reclaim_type','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reclaim_type','class_level')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD   `class_level` int(11) DEFAULT '0' COMMENT '分类基本 0：一级分类 1 二级分类'");}
if(!pdo_fieldexists('ox_reclaim_type','parent_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type')." ADD   `parent_id` int(11) DEFAULT '0' COMMENT '上级分类id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_type_price` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `type_id` int(10) DEFAULT NULL COMMENT '分类id',
  `type_name` varchar(20) DEFAULT NULL COMMENT '名称',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `sort` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_type_price','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type_price')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_type_price','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type_price')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_type_price','type_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type_price')." ADD   `type_id` int(10) DEFAULT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('ox_reclaim_type_price','type_name')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type_price')." ADD   `type_name` varchar(20) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('ox_reclaim_type_price','price')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type_price')." ADD   `price` decimal(10,2) DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ox_reclaim_type_price','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_type_price')." ADD   `sort` tinyint(4) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_uniform_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `template_id` varchar(50) DEFAULT NULL,
  `first` varchar(50) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT ' 1 新订单通知 2 提现通知 3小程序提现',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_uniform_template','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_uniform_template')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_uniform_template','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_uniform_template')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_uniform_template','template_id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_uniform_template')." ADD   `template_id` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_uniform_template','first')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_uniform_template')." ADD   `first` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_uniform_template','remark')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_uniform_template')." ADD   `remark` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_uniform_template','type')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_uniform_template')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT ' 1 新订单通知 2 提现通知 3小程序提现'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reclaim_view` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL COMMENT '标题',
  `content` text,
  `sort` tinyint(4) DEFAULT NULL COMMENT ' 排序',
  `type` tinyint(4) DEFAULT NULL COMMENT ' 1 关于我们 2 操作指南',
  `create_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reclaim_view','id')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_view')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reclaim_view','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_view')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reclaim_view','title')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_view')." ADD   `title` varchar(20) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ox_reclaim_view','content')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_view')." ADD   `content` text");}
if(!pdo_fieldexists('ox_reclaim_view','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_view')." ADD   `sort` tinyint(4) DEFAULT NULL COMMENT ' 排序'");}
if(!pdo_fieldexists('ox_reclaim_view','type')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_view')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT ' 1 关于我们 2 操作指南'");}
if(!pdo_fieldexists('ox_reclaim_view','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reclaim_view')." ADD   `create_time` int(10) DEFAULT NULL");}
