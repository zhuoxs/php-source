<?php
pdo_query("
DROP TABLE IF EXISTS `ims_sqtg_sun_acode`;
CREATE TABLE `ims_sqtg_sun_acode` (
  `id` int(11) NOT NULL,
  `code` text COMMENT '随机码',
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='软件授权码';
DROP TABLE IF EXISTS `ims_sqtg_sun_ad`;
CREATE TABLE `ims_sqtg_sun_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `url` varchar(200) DEFAULT NULL COMMENT '链接',
  `pic` varchar(200) DEFAULT NULL COMMENT '图片',
  `index` int(4) NOT NULL DEFAULT '1' COMMENT '排序',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `type` int(4) DEFAULT NULL COMMENT '广告类型：1、首页轮播图，2、首页中部广告',
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用',
  `store_id` int(11) DEFAULT '0' COMMENT '商家id',
  `link_type` int(1) DEFAULT '1' COMMENT '1.内链 2.外部小程序 3.客服消息',
  `appid` varchar(100) DEFAULT NULL COMMENT '外部小程序APPID',
  `path` varchar(200) DEFAULT NULL COMMENT '外部小程序链接地址',
  `param` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='广告';
DROP TABLE IF EXISTS `ims_sqtg_sun_admin`;
CREATE TABLE `ims_sqtg_sun_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `uniacid` int(11) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL COMMENT '头像',
  `name` varchar(100) DEFAULT NULL COMMENT '昵称',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  `login_time` int(20) DEFAULT NULL,
  `store_id` int(11) DEFAULT '0' COMMENT '门店id',
  `code` varchar(100) DEFAULT NULL COMMENT '账号',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `state` int(4) DEFAULT '0' COMMENT '状态：1启用 0禁用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理员账号';
DROP TABLE IF EXISTS `ims_sqtg_sun_announcement`;
CREATE TABLE `ims_sqtg_sun_announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '启用状态1启用',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='公告管理';
DROP TABLE IF EXISTS `ims_sqtg_sun_baowen`;
CREATE TABLE `ims_sqtg_sun_baowen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xml` text,
  `out_trade_no` varchar(60) DEFAULT NULL,
  `transaction_id` varchar(60) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `out_trade_no` (`out_trade_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='支付报文';
DROP TABLE IF EXISTS `ims_sqtg_sun_cart`;
CREATE TABLE `ims_sqtg_sun_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '商品数量',
  `attr_ids` varchar(250) NOT NULL DEFAULT '0' COMMENT '规格ids',
  `create_time` int(11) DEFAULT '0',
  `leader_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT '0',
  `attr_names` varchar(250) NOT NULL DEFAULT '' COMMENT '规格ids',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='购物车';
DROP TABLE IF EXISTS `ims_sqtg_sun_category`;
CREATE TABLE `ims_sqtg_sun_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL COMMENT '名称',
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用状态',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `index` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='类别管理';
DROP TABLE IF EXISTS `ims_sqtg_sun_config`;
CREATE TABLE `ims_sqtg_sun_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `key` varchar(50) DEFAULT NULL COMMENT '关键字',
  `value` text COMMENT '值',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='配置信息';
DROP TABLE IF EXISTS `ims_sqtg_sun_coupon`;
CREATE TABLE `ims_sqtg_sun_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '优惠券名称',
  `begin_time` int(11) DEFAULT NULL COMMENT '活动开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '活动结束时间',
  `use_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单笔满多少金额',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '满减金额',
  `days` int(11) NOT NULL DEFAULT '1' COMMENT '领取后有效天数',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '总量',
  `left_num` int(11) NOT NULL DEFAULT '0' COMMENT '剩余数量',
  `create_time` int(11) DEFAULT NULL,
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '状态 1开启 2关闭',
  `info` text COMMENT '使用说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='优惠券';
DROP TABLE IF EXISTS `ims_sqtg_sun_customize`;
CREATE TABLE `ims_sqtg_sun_customize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2菜单图标 3底部图标',
  `title` varchar(255) DEFAULT NULL COMMENT '标题名称',
  `pic` varchar(200) DEFAULT NULL COMMENT '图标图片',
  `clickago_icon` varchar(200) DEFAULT NULL COMMENT '点击前图标',
  `clickafter_icon` varchar(200) DEFAULT NULL COMMENT '点击后图标',
  `link_type` tinyint(1) DEFAULT '1' COMMENT '1.内链 2.外部小程序 3.客服消息',
  `url_type` tinyint(4) DEFAULT NULL COMMENT '链接类型 1基本 2商品分类',
  `url` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `url_typeid` int(11) DEFAULT '0' COMMENT '链接带参数',
  `url_name` varchar(50) DEFAULT NULL COMMENT '链接名称',
  `appid` varchar(100) DEFAULT NULL COMMENT '外部小程序APPID',
  `path` varchar(200) DEFAULT NULL COMMENT '外部小程序链接地址',
  `sort` int(5) NOT NULL DEFAULT '0' COMMENT '排序 越大越前',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='自定义信息包含菜单底部菜单轮播图也适用';
DROP TABLE IF EXISTS `ims_sqtg_sun_delivery`;
CREATE TABLE `ims_sqtg_sun_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `state` int(4) NOT NULL DEFAULT '0' COMMENT '是否已经支付 1启用',
  `delivery_fee` decimal(10,2) DEFAULT '0.00' COMMENT '配送费',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='运费合并详情表';
DROP TABLE IF EXISTS `ims_sqtg_sun_deliveryorder`;
CREATE TABLE `ims_sqtg_sun_deliveryorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `leader_id` int(11) DEFAULT NULL,
  `order_no` varchar(60) DEFAULT NULL COMMENT '订单号',
  `create_time` int(11) DEFAULT NULL,
  `confirm_time` int(11) DEFAULT NULL COMMENT '确认收货时间完成时间',
  `state` int(4) NOT NULL DEFAULT '3' COMMENT '1待支付 2待配送 3待收货 4待自提 5已完成 6已取消',
  `store_id` int(11) NOT NULL DEFAULT '0',
  `detail` text,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配送单';
DROP TABLE IF EXISTS `ims_sqtg_sun_deliveryordergoods`;
CREATE TABLE `ims_sqtg_sun_deliveryordergoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品id',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `attr_ids` varchar(250) DEFAULT NULL COMMENT '商品规格',
  `attr_names` varchar(250) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `state` int(4) DEFAULT '3' COMMENT '1待支付 2待配送 3待收货 4待自提 5已完成 6已取消',
  `leader_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `receive_num` int(11) DEFAULT '0' COMMENT '团长收货数量',
  `update_time` int(11) DEFAULT NULL,
  `batch_no` varchar(100) DEFAULT '' COMMENT '批次',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配送单商品列表';
DROP TABLE IF EXISTS `ims_sqtg_sun_dingtalk`;
CREATE TABLE `ims_sqtg_sun_dingtalk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `token` varchar(100) DEFAULT NULL,
  `is_open` tinyint(4) NOT NULL DEFAULT '0',
  `content` varchar(255) DEFAULT NULL COMMENT '下订单提醒',
  `contentrefund` varchar(255) DEFAULT NULL COMMENT '退款申请提醒',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `pincontent` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_distribution`;
CREATE TABLE `ims_sqtg_sun_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `uniacid` int(11) DEFAULT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称',
  `parent_id` int(11) DEFAULT '0' COMMENT '上级分销id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  `check_state` int(11) DEFAULT '1' COMMENT '审核状态：1未审核 2审核成功 3审核失败',
  `fail_reason` varchar(255) DEFAULT NULL COMMENT '审核失败原因',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `money` decimal(15,2) DEFAULT '0.00' COMMENT '可提现佣金',
  `money_old` decimal(15,2) DEFAULT '0.00' COMMENT '已提现佣金',
  `money_future` decimal(15,2) DEFAULT '0.00' COMMENT '未结算佣金',
  `amount` decimal(15,2) DEFAULT '0.00' COMMENT '佣金总额',
  `amount_order` decimal(15,2) DEFAULT '0.00' COMMENT '订单总金额',
  `invite_code` varchar(50) DEFAULT '' COMMENT '邀请码',
  `money_ing` decimal(15,2) DEFAULT '0.00' COMMENT '提现中佣金',
  `check_time` int(11) DEFAULT '0' COMMENT '审核通过时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_distributionrecord`;
CREATE TABLE `ims_sqtg_sun_distributionrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rate` decimal(15,2) DEFAULT '0.00' COMMENT '分佣比例',
  `amount` decimal(15,2) DEFAULT '0.00' COMMENT '订单金额',
  `money` decimal(15,2) DEFAULT '0.00' COMMENT '分佣金额',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `goods_id` int(11) DEFAULT NULL,
  `level` int(4) DEFAULT NULL,
  `state` int(4) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门店（提货点）';
DROP TABLE IF EXISTS `ims_sqtg_sun_distributionwithdraw`;
CREATE TABLE `ims_sqtg_sun_distributionwithdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现全额',
  `wd_type` tinyint(4) DEFAULT NULL COMMENT '提现方式 1微信',
  `wd_account` varchar(100) DEFAULT NULL COMMENT '提现账号',
  `wd_name` varchar(255) DEFAULT NULL COMMENT '提现姓名',
  `wd_phone` varchar(255) DEFAULT NULL COMMENT '提现手机号',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提现状态 1成功 2失败',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `distribution_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商id',
  `baowen` text COMMENT '提现报文',
  `create_time` int(11) DEFAULT NULL COMMENT '申请时间',
  `check_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1待审核 2审核通过 3审核失败',
  `err_code` varchar(50) DEFAULT NULL COMMENT '提现错误码',
  `fail_reason` varchar(200) DEFAULT NULL COMMENT '失败原因',
  `tx_time` int(11) DEFAULT NULL COMMENT '提现时间',
  `check_time` int(11) DEFAULT NULL COMMENT '审核时间',
  `no` varchar(50) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_formid`;
CREATE TABLE `ims_sqtg_sun_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `form_id` varchar(50) DEFAULT NULL,
  `time` int(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=269 DEFAULT CHARSET=utf8 COMMENT='表单id';
DROP TABLE IF EXISTS `ims_sqtg_sun_goods`;
CREATE TABLE `ims_sqtg_sun_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `name` varchar(100) DEFAULT NULL COMMENT '商品名称',
  `unit` varchar(10) NOT NULL DEFAULT '个' COMMENT '单位',
  `weight` varchar(20) NOT NULL DEFAULT '0.00' COMMENT '重量',
  `index` int(11) NOT NULL DEFAULT '0' COMMENT '排序 从大到小',
  `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)',
  `pics` text COMMENT '商品轮播图',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本价',
  `original_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品原价展示使用',
  `details` text NOT NULL COMMENT '商品详细',
  `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `sales_num` int(11) NOT NULL DEFAULT '0' COMMENT '销量 销量支付完成',
  `virtual_num` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟销量',
  `use_attr` int(4) NOT NULL DEFAULT '0' COMMENT '1使用规格',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用状态',
  `is_hot` int(4) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `check_state` int(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `fail_reason` varchar(255) DEFAULT NULL,
  `begin_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `check_time` int(11) DEFAULT NULL COMMENT '审核时间',
  `leader_draw_type` int(4) DEFAULT '0',
  `leader_draw_rate` decimal(10,2) DEFAULT NULL,
  `leader_draw_money` decimal(10,2) DEFAULT NULL,
  `batch_no` varchar(100) DEFAULT '' COMMENT '批次',
  `send_time` int(11) NOT NULL,
  `receive_time` int(11) NOT NULL,
  `limit` int(11) DEFAULT '0' COMMENT '限购',
  `delivery_single` int(4) DEFAULT '0' COMMENT '单独配送',
  `delivery_fee` decimal(10,2) DEFAULT '0.00' COMMENT '配送费',
  `delivery_fee_type` int(4) DEFAULT '0',
  `customer_tag` varchar(50) DEFAULT '' COMMENT '自定义标签',
  `mandatory` int(1) NOT NULL DEFAULT '0' COMMENT '强制团长上架',
  `is_show` int(4) DEFAULT '1',
  `home_pic` varchar(200) DEFAULT NULL,
  `is_upload_zny` int(4) DEFAULT '0',
  `zny_goods_id` int(11) DEFAULT NULL,
  `upload_zny_goods_id` int(11) DEFAULT '0' COMMENT '导入的商品id',
  `img_details` text,
  `less` int(11) unsigned DEFAULT '0',
  `video` varchar(200) DEFAULT NULL COMMENT '视频地址',
  `style_pic` varchar(200) DEFAULT NULL COMMENT '(封面图2)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='商品表';
DROP TABLE IF EXISTS `ims_sqtg_sun_goodsattr`;
CREATE TABLE `ims_sqtg_sun_goodsattr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格名称',
  `goods_id` int(11) DEFAULT NULL,
  `goodsattrgroup_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格表';
DROP TABLE IF EXISTS `ims_sqtg_sun_goodsattrgroup`;
CREATE TABLE `ims_sqtg_sun_goodsattrgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格分组名称',
  `goods_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格分组表';
DROP TABLE IF EXISTS `ims_sqtg_sun_goodsattrsetting`;
CREATE TABLE `ims_sqtg_sun_goodsattrsetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `key` varchar(250) DEFAULT NULL COMMENT '规格名称列表',
  `attr_ids` varchar(250) NOT NULL DEFAULT '' COMMENT '规格ids',
  `goods_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '单价',
  `weight` double(10,2) DEFAULT '0.00' COMMENT '重量',
  `code` varchar(50) DEFAULT '' COMMENT '编码',
  `pic` varchar(255) DEFAULT '' COMMENT '封面图',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格设置表';
DROP TABLE IF EXISTS `ims_sqtg_sun_leader`;
CREATE TABLE `ims_sqtg_sun_leader` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `tel` varchar(60) DEFAULT '' COMMENT '电话',
  `community` varchar(100) DEFAULT NULL COMMENT '小区名称',
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `longitude` varchar(20) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(20) DEFAULT NULL COMMENT '纬度',
  `user_id` int(11) DEFAULT '0' COMMENT '申请人id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `check_state` int(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `check_time` int(11) DEFAULT NULL,
  `fail_reason` varchar(255) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `workday` varchar(20) DEFAULT '' COMMENT '工作日',
  `dingtalk_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='社区团长';
DROP TABLE IF EXISTS `ims_sqtg_sun_leaderbill`;
CREATE TABLE `ims_sqtg_sun_leaderbill` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `content` varchar(100) DEFAULT NULL COMMENT '说明',
  `create_time` varchar(50) DEFAULT NULL,
  `leader_id` int(11) DEFAULT NULL,
  `money` decimal(15,2) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='社区团长账单（分佣）';
DROP TABLE IF EXISTS `ims_sqtg_sun_leadergoods`;
CREATE TABLE `ims_sqtg_sun_leadergoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `create_time` int(11) DEFAULT NULL,
  `leader_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='社区团长商品表';
DROP TABLE IF EXISTS `ims_sqtg_sun_leaderpingoods`;
CREATE TABLE `ims_sqtg_sun_leaderpingoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `create_time` int(11) DEFAULT NULL,
  `leader_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='社区团长拼团商品表';
DROP TABLE IF EXISTS `ims_sqtg_sun_leaderuser`;
CREATE TABLE `ims_sqtg_sun_leaderuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `create_time` int(11) DEFAULT NULL,
  `leader_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='社区团长核销员';
DROP TABLE IF EXISTS `ims_sqtg_sun_leaderwithdraw`;
CREATE TABLE `ims_sqtg_sun_leaderwithdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现全额',
  `wd_type` tinyint(4) DEFAULT NULL COMMENT '提现方式 1微信',
  `wd_account` varchar(100) DEFAULT NULL COMMENT '提现账号',
  `wd_name` varchar(255) DEFAULT NULL COMMENT '提现姓名',
  `wd_phone` varchar(255) DEFAULT NULL COMMENT '提现手机号',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提现状态 1成功 2失败',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `leader_id` int(11) NOT NULL DEFAULT '0' COMMENT '团长id',
  `baowen` text COMMENT '提现报文',
  `create_time` int(11) DEFAULT NULL COMMENT '申请时间',
  `check_state` int(4) NOT NULL DEFAULT '1' COMMENT '1待审核 2审核通过 3审核失败',
  `err_code` varchar(50) DEFAULT NULL COMMENT '提现错误码',
  `fail_reason` varchar(200) DEFAULT NULL COMMENT '失败原因',
  `tx_time` int(11) DEFAULT NULL COMMENT '提现时间',
  `check_time` int(11) DEFAULT NULL COMMENT '审核时间',
  `no` varchar(50) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_menu`;
CREATE TABLE `ims_sqtg_sun_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '菜单名称',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  `memo` varchar(200) DEFAULT NULL COMMENT '备注',
  `index` int(10) DEFAULT NULL COMMENT '排序',
  `menugroup_id` int(11) DEFAULT NULL COMMENT '分组id',
  `control` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `menu_id` int(11) DEFAULT '0',
  `state` tinyint(1) DEFAULT '1' COMMENT '1.启用 0.禁用',
  `store_show` int(4) DEFAULT '1' COMMENT '商户后台是否显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=810 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_menugroup`;
CREATE TABLE `ims_sqtg_sun_menugroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '菜单分组名称',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  `memo` varchar(200) DEFAULT NULL COMMENT '备注',
  `index` int(10) DEFAULT NULL COMMENT '排序',
  `state` tinyint(1) DEFAULT '1' COMMENT '1.启用 0.禁用',
  `store_show` int(4) DEFAULT '1' COMMENT '商户后台是否显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=669 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_mercapdetails`;
CREATE TABLE `ims_sqtg_sun_mercapdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL COMMENT '商家id',
  `store_name` varchar(100) DEFAULT NULL COMMENT '商家名称',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '方式 1普通订单 2拼团 3秒杀',
  `mcd_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现方式 1订单收入 2微信提现 3审核失败退款',
  `openid` varchar(30) DEFAULT NULL COMMENT '订单收入支付的openid|提现给的openid',
  `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少',
  `mcd_memo` text COMMENT '相关详细信息',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '全额 订单收入全额 提现全额',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现支付给平台佣金',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费',
  `order_id` int(11) DEFAULT NULL COMMENT '订单收入id',
  `wd_id` int(11) DEFAULT NULL COMMENT '提现id',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1成功 2失败 提现可能会失败',
  `add_time` int(11) DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `now_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前余额',
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商家资金明细';
DROP TABLE IF EXISTS `ims_sqtg_sun_order`;
CREATE TABLE `ims_sqtg_sun_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `leader_id` int(11) DEFAULT NULL,
  `order_no` varchar(60) DEFAULT NULL COMMENT '订单号',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `coupon_money` decimal(15,2) DEFAULT NULL COMMENT '优惠券金额',
  `usercoupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用优惠券id',
  `pay_state` int(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1已支付 ',
  `pay_amount` decimal(15,2) DEFAULT NULL COMMENT '支付总金额',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `create_time` int(11) DEFAULT NULL,
  `confirm_time` int(11) DEFAULT NULL COMMENT '确认收货时间完成时间',
  `cancel_time` int(11) DEFAULT NULL COMMENT '订单取消时间',
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1待支付 2待配送 3待自提 4已完成 5已取消',
  `is_delete` int(4) NOT NULL DEFAULT '0' COMMENT '1 删除',
  `update_time` int(11) DEFAULT NULL,
  `share_amount` decimal(15,2) DEFAULT '0.00' COMMENT '分润：团长提成，分销提成',
  `delivery_type` int(4) DEFAULT '1' COMMENT '配送方式 1：自提，2：配送',
  `receive_name` varchar(50) DEFAULT NULL,
  `receive_tel` varchar(20) DEFAULT NULL,
  `receive_address` varchar(255) DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT '0.00' COMMENT '配送费',
  `delivery_fee_arr` text COMMENT '合并运费详情',
  `merge` int(4) NOT NULL DEFAULT '0' COMMENT '0未开启合并 1开启合并',
  `comment` text,
  `pay_type` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='订单信息';
DROP TABLE IF EXISTS `ims_sqtg_sun_ordergoods`;
CREATE TABLE `ims_sqtg_sun_ordergoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品id',
  `goods_name` varchar(60) DEFAULT NULL COMMENT '商品名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `attr_ids` varchar(250) DEFAULT NULL COMMENT '商品规格',
  `attr_names` varchar(250) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL COMMENT '图片',
  `create_time` int(11) DEFAULT NULL,
  `state` int(4) DEFAULT '1' COMMENT '1待支付 2待配送 3',
  `leader_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `coupon_money` decimal(15,2) DEFAULT NULL COMMENT '优惠券金额',
  `pay_amount` decimal(15,2) DEFAULT NULL COMMENT '支付总金额',
  `is_delete` int(4) NOT NULL DEFAULT '0' COMMENT '1 删除',
  `share_amount` decimal(15,2) DEFAULT '0.00' COMMENT '分润：团长提成，分销提成',
  `batch_no` varchar(100) DEFAULT '' COMMENT '批次',
  `distribution_money` decimal(15,2) DEFAULT '0.00' COMMENT '分佣总金额',
  `check_state` int(4) NOT NULL DEFAULT '0' COMMENT '1未审核 2审核成功 3审核失败',
  `check_time` int(11) DEFAULT NULL,
  `apply_time` int(11) DEFAULT NULL,
  `fail_reason` varchar(255) DEFAULT NULL,
  `refund_no` varchar(60) DEFAULT NULL COMMENT '退款订单号',
  `delivery_type` int(4) DEFAULT '1' COMMENT '配送方式 1：自提，2：配送',
  `receive_name` varchar(50) DEFAULT NULL,
  `receive_tel` varchar(20) DEFAULT NULL,
  `receive_address` varchar(255) DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT '0.00' COMMENT '配送费',
  `merge` int(4) NOT NULL DEFAULT '0' COMMENT '0未开启合并 1开启合并',
  `del` tinyint(1) NOT NULL DEFAULT '0',
  `pay_type` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_payrecord`;
CREATE TABLE `ims_sqtg_sun_payrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `source_type` varchar(50) DEFAULT NULL COMMENT '支付类型：orderonline',
  `source_id` int(11) DEFAULT NULL,
  `pay_money` decimal(15,2) DEFAULT NULL,
  `pay_time` int(11) DEFAULT NULL,
  `callback_xml` text,
  `callback_time` int(11) DEFAULT NULL,
  `no` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `openid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_pinclassify`;
CREATE TABLE `ims_sqtg_sun_pinclassify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL COMMENT '分类名称',
  `sort` int(5) DEFAULT '0',
  `state` tinyint(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `is_del` int(1) DEFAULT '0' COMMENT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='拼团分类表';
DROP TABLE IF EXISTS `ims_sqtg_sun_pingoods`;
CREATE TABLE `ims_sqtg_sun_pingoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT '0',
  `cid` int(11) DEFAULT '0' COMMENT '商品分类id',
  `name` varchar(100) DEFAULT NULL COMMENT '商品名称',
  `unit` varchar(10) DEFAULT '个' COMMENT '单位',
  `weight` double(10,2) DEFAULT '0.00' COMMENT '重量',
  `sort` int(11) DEFAULT '0' COMMENT '排序 从大到小',
  `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)',
  `pics` text COMMENT '商品轮播图',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '单购价',
  `pin_price` decimal(10,2) DEFAULT '0.00' COMMENT '拼购价',
  `original_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价展示使用',
  `details` text COMMENT '商品详细',
  `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)',
  `postagerules_id` int(11) DEFAULT NULL COMMENT '运费模板id',
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `sales_num` int(11) DEFAULT '0' COMMENT '销量 销量支付完成',
  `sales_xnnum` int(11) DEFAULT '0' COMMENT '虚拟销量',
  `use_attr` int(4) DEFAULT '0' COMMENT '1使用规格',
  `attr` longtext COMMENT '规格库存和价格',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `state` int(4) DEFAULT '1' COMMENT '1启用状态',
  `is_hot` int(4) DEFAULT '0' COMMENT '是否推荐',
  `check_state` int(4) DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `fail_reason` varchar(255) DEFAULT NULL,
  `is_ladder` tinyint(1) DEFAULT '0' COMMENT '1开启阶梯团',
  `ladder_info` text,
  `limit_num` int(11) DEFAULT '0' COMMENT '单次购买数量',
  `limit_times` int(11) DEFAULT '0' COMMENT '购买次数限制',
  `group_num` int(11) DEFAULT '0' COMMENT '实际成团数',
  `group_xnnum` int(11) DEFAULT '0' COMMENT '虚拟成团数',
  `sendtype` tinyint(1) DEFAULT '1' COMMENT '1.到店 2.物流',
  `need_num` int(1) DEFAULT '2' COMMENT '开团人数',
  `is_group_coupon` tinyint(1) DEFAULT '0' COMMENT '1开启团长优惠',
  `coupon_money` decimal(10,2) DEFAULT '0.00' COMMENT '团长优惠金额',
  `coupon_discount` int(11) DEFAULT '0' COMMENT '团长优惠折扣',
  `group_time` int(11) DEFAULT '0' COMMENT '组团限时',
  `pay_time` int(11) DEFAULT '0' COMMENT '付款限时',
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `is_stock` tinyint(1) DEFAULT '0' COMMENT '1.限时库存',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1.删除',
  `is_alonepay` tinyint(1) DEFAULT '1' COMMENT '0关闭单购',
  `mandatory` tinyint(1) DEFAULT '0' COMMENT '1强制上架 0默认',
  `leader_draw_type` int(4) DEFAULT '0',
  `leader_draw_rate` decimal(10,2) DEFAULT NULL,
  `leader_draw_money` decimal(10,2) DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT '0.00' COMMENT '配送费',
  `home_pic` varchar(200) DEFAULT NULL,
  `check_time` int(11) DEFAULT '0' COMMENT '审核通过时间',
  `delivery_fee_type` int(4) DEFAULT '0',
  `delivery_single` int(4) DEFAULT '0' COMMENT '单独配送',
  `video` varchar(200) DEFAULT NULL COMMENT '视频地址',
  `img_details` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品表';
DROP TABLE IF EXISTS `ims_sqtg_sun_pingoodsattr`;
CREATE TABLE `ims_sqtg_sun_pingoodsattr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格名称',
  `goods_id` int(11) DEFAULT NULL,
  `goodsattrgroup_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品规格表';
DROP TABLE IF EXISTS `ims_sqtg_sun_pingoodsattrgroup`;
CREATE TABLE `ims_sqtg_sun_pingoodsattrgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格分组名称',
  `goods_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品规格分组表';
DROP TABLE IF EXISTS `ims_sqtg_sun_pingoodsattrsetting`;
CREATE TABLE `ims_sqtg_sun_pingoodsattrsetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `key` varchar(250) DEFAULT NULL COMMENT '规格名称列表',
  `attr_ids` varchar(250) NOT NULL DEFAULT '' COMMENT '规格ids',
  `goods_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '单购价',
  `weight` double(10,2) DEFAULT '0.00' COMMENT '重量',
  `code` varchar(50) DEFAULT '' COMMENT '编码',
  `pic` varchar(255) DEFAULT '' COMMENT '封面图',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `pin_price` decimal(10,2) DEFAULT '0.00' COMMENT '拼团价',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品规格设置表';
DROP TABLE IF EXISTS `ims_sqtg_sun_pinheads`;
CREATE TABLE `ims_sqtg_sun_pinheads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupnum` int(11) DEFAULT '0' COMMENT '成团人数',
  `groupmoney` decimal(10,2) DEFAULT '0.00' COMMENT '成团价钱',
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `ladder_id` int(11) DEFAULT '0' COMMENT '阶梯团id',
  `status` tinyint(1) DEFAULT '0' COMMENT '1.开团成功 2.拼团成功 3.拼团失败',
  `oid` int(11) DEFAULT NULL,
  `expire_time` int(11) DEFAULT '0' COMMENT '到期时间',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='团长表';
DROP TABLE IF EXISTS `ims_sqtg_sun_pinladder`;
CREATE TABLE `ims_sqtg_sun_pinladder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL,
  `groupnum` int(11) DEFAULT '2' COMMENT '组团人数',
  `groupmoney` decimal(10,2) DEFAULT '0.00' COMMENT '组团价格',
  `create_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='阶梯团规则表';
DROP TABLE IF EXISTS `ims_sqtg_sun_pinorder`;
CREATE TABLE `ims_sqtg_sun_pinorder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `heads_id` int(11) DEFAULT '0' COMMENT '团id',
  `leader_id` int(11) DEFAULT NULL,
  `is_head` tinyint(1) DEFAULT '0' COMMENT '1.团长',
  `order_num` varchar(50) DEFAULT NULL COMMENT '订单号',
  `store_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `out_trade_no` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `attr_ids` varchar(255) DEFAULT NULL,
  `attr_list` varchar(255) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额(含运费）',
  `sincetype` tinyint(1) DEFAULT '1' COMMENT '配送方式 1快递 2到店自提',
  `distribution` decimal(10,2) DEFAULT '0.00' COMMENT '运费',
  `num` int(11) DEFAULT '1' COMMENT '购买数量',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '单价',
  `name` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `express_delivery` varchar(50) DEFAULT NULL COMMENT '快递公司',
  `express_orderformid` varchar(50) DEFAULT NULL COMMENT '快递单号',
  `create_time` int(11) DEFAULT NULL,
  `is_pay` tinyint(1) DEFAULT '0' COMMENT '1.已付款',
  `pay_type` tinyint(1) DEFAULT '1' COMMENT '1.微信支付 2.零钱支付',
  `pay_time` int(11) DEFAULT NULL,
  `use_num` int(11) DEFAULT '0' COMMENT '核销份数',
  `use_time` int(11) DEFAULT NULL,
  `qrcode` varchar(100) DEFAULT NULL COMMENT '核销码',
  `order_status` tinyint(1) DEFAULT '0' COMMENT '0.未付款 1.已付款 ',
  `prepay_id` varchar(200) DEFAULT NULL,
  `expire_time` int(11) DEFAULT '0' COMMENT '支付过期时间',
  `coupon_money` decimal(10,2) DEFAULT '0.00' COMMENT '优惠金额',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1.已删除(过期未支付)',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '0.删除(订单列表不显示）',
  `shop_id` int(11) DEFAULT '0' COMMENT '门店id',
  `is_refund` tinyint(1) DEFAULT '0' COMMENT '1退款成功 2退款失败',
  `refund_time` int(11) DEFAULT '0' COMMENT '退款时间',
  `refund_num` varchar(50) DEFAULT '0' COMMENT '退款单号',
  `update_time` int(11) DEFAULT NULL,
  `send_time` int(11) DEFAULT '0' COMMENT '发货时间',
  `group_time` int(11) DEFAULT '0' COMMENT '成团时间',
  `finish_time` int(11) DEFAULT '0' COMMENT '完成时间',
  `is_comment` tinyint(1) DEFAULT '0' COMMENT '1.已经评论',
  `share_amount` decimal(15,2) DEFAULT '0.00' COMMENT '分润：团长提成，分销提成',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='订单表';
DROP TABLE IF EXISTS `ims_sqtg_sun_pinrefund`;
CREATE TABLE `ims_sqtg_sun_pinrefund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `oid` int(11) DEFAULT NULL COMMENT '订单id',
  `heads_id` int(11) DEFAULT NULL,
  `refund_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款方式 1微信退款 2余额退款',
  `order_refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1仅退款',
  `refund_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `create_time` int(11) DEFAULT NULL,
  `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1退款成功 2退款失败',
  `refund_time` tinyint(11) DEFAULT NULL COMMENT '退款时间',
  `err_code` varchar(200) DEFAULT NULL COMMENT '退款失败错误码',
  `err_code_dec` varchar(200) DEFAULT NULL COMMENT '错误信息',
  `xml` text COMMENT '退款报文',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='拼团退款记录表';
DROP TABLE IF EXISTS `ims_sqtg_sun_pluginkey`;
CREATE TABLE `ims_sqtg_sun_pluginkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_id` int(11) DEFAULT NULL,
  `key` varchar(60) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '插件名',
  `value` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='插件key';
DROP TABLE IF EXISTS `ims_sqtg_sun_printing`;
CREATE TABLE `ims_sqtg_sun_printing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1飞蛾打印',
  `sn` varchar(20) DEFAULT NULL,
  `key` varchar(60) DEFAULT NULL,
  `user` varchar(60) DEFAULT NULL,
  `is_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1开启 2关闭',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='打印配置飞蛾';
DROP TABLE IF EXISTS `ims_sqtg_sun_prints`;
CREATE TABLE `ims_sqtg_sun_prints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(60) DEFAULT NULL COMMENT '打印机名称',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '打印机类型 1飞蛾',
  `user` varchar(60) DEFAULT NULL COMMENT '飞蛾 账号',
  `ukey` varchar(60) DEFAULT NULL COMMENT '飞蛾key',
  `sn` varchar(60) DEFAULT NULL COMMENT '打印机编号',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='打印机';
DROP TABLE IF EXISTS `ims_sqtg_sun_printset`;
CREATE TABLE `ims_sqtg_sun_printset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `prints_id` int(11) NOT NULL DEFAULT '0' COMMENT '打印机id',
  `print_type` varchar(60) DEFAULT '1' COMMENT '打印方式 1下单打印 2付款打印 3确认收货打印 1,2,3',
  `print_merch` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1多商户打印',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_recharge`;
CREATE TABLE `ims_sqtg_sun_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `recharge_lowest` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低充值金额',
  `details` text COMMENT '充值活动',
  `create_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='充值金额配置';
DROP TABLE IF EXISTS `ims_sqtg_sun_rechargerecord`;
CREATE TABLE `ims_sqtg_sun_rechargerecord` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '充值总金额（含赠送）',
  `send_money` decimal(10,2) DEFAULT '0.00' COMMENT '赠送金额',
  `out_trade_no` varchar(100) DEFAULT NULL COMMENT '订单号',
  `transaction_id` varchar(100) DEFAULT NULL COMMENT '支付号',
  `create_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `update_time` int(11) DEFAULT NULL COMMENT '到账时间',
  `uniacid` int(11) DEFAULT NULL,
  `prepay_id` varchar(200) DEFAULT NULL,
  `state` int(1) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='充值记录表';
DROP TABLE IF EXISTS `ims_sqtg_sun_robot`;
CREATE TABLE `ims_sqtg_sun_robot` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `img` varchar(200) DEFAULT NULL COMMENT '头像',
  `uniacid` int(11) DEFAULT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `name` varchar(101) CHARACTER SET utf8mb4 DEFAULT NULL,
  `birthday` varchar(40) DEFAULT NULL COMMENT '生日',
  `gender` int(1) DEFAULT '0' COMMENT '性别',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
DROP TABLE IF EXISTS `ims_sqtg_sun_sms`;
CREATE TABLE `ims_sqtg_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(100) DEFAULT NULL,
  `tpl_id` int(11) DEFAULT NULL,
  `uniacid` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_open` int(11) DEFAULT '2',
  `tid1` varchar(50) DEFAULT NULL,
  `tid2` varchar(50) DEFAULT NULL,
  `tid3` varchar(50) DEFAULT NULL,
  `order_tplid` int(11) DEFAULT NULL COMMENT '聚合-订单提醒id',
  `order_refund_tplid` int(11) DEFAULT NULL COMMENT '聚合-订单退款提醒id',
  `smstype` tinyint(2) DEFAULT '1' COMMENT '短信类型，1为253，2为聚合',
  `ytx_apiaccount` varchar(50) DEFAULT NULL COMMENT '253短信账号',
  `ytx_apipass` varchar(50) DEFAULT NULL COMMENT '253短信密码',
  `ytx_apiurl` varchar(50) DEFAULT NULL COMMENT '253短信地址',
  `ytx_order` varchar(255) DEFAULT NULL COMMENT '云通信订单消息提醒',
  `ytx_orderrefund` varchar(255) DEFAULT NULL COMMENT '云通信退款订单消息提醒',
  `tid4` varchar(50) DEFAULT NULL COMMENT '开奖模板',
  `aly_accesskeyid` varchar(255) DEFAULT NULL COMMENT '阿里大鱼 accessKeyId',
  `aly_accesskeysecret` varchar(255) DEFAULT NULL COMMENT '阿里大鱼 AccessKeySecret',
  `aly_order` varchar(255) DEFAULT NULL COMMENT '阿里大鱼 订单模板',
  `aly_orderrefund` varchar(255) DEFAULT NULL COMMENT '阿里大鱼 退款模板',
  `aly_sign` varchar(100) DEFAULT NULL COMMENT '签名',
  `xiaoshentui` varchar(255) DEFAULT NULL COMMENT '小神推',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_store`;
CREATE TABLE `ims_sqtg_sun_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `tel` varchar(60) DEFAULT '' COMMENT '商家电话',
  `address` varchar(200) DEFAULT NULL COMMENT '商家地址',
  `check_state` int(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `check_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(20) DEFAULT NULL COMMENT '纬度',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商家余额',
  `user_id` int(11) DEFAULT '0' COMMENT '申请人id',
  `fail_reason` varchar(255) DEFAULT NULL,
  `distance` int(11) DEFAULT NULL,
  `leader_draw_type` int(4) DEFAULT '0',
  `leader_draw_rate` decimal(10,2) DEFAULT NULL,
  `leader_draw_money` decimal(10,2) DEFAULT NULL,
  `draw_rate` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家(门店)';
DROP TABLE IF EXISTS `ims_sqtg_sun_storeleader`;
CREATE TABLE `ims_sqtg_sun_storeleader` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `leader_id` int(11) DEFAULT '0',
  `store_id` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商家团长（配送）';
DROP TABLE IF EXISTS `ims_sqtg_sun_storeuser`;
CREATE TABLE `ims_sqtg_sun_storeuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用',
  `store_id` int(11) DEFAULT '0' COMMENT '商家id',
  `user_id` int(11) DEFAULT '0' COMMENT '商家id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户用户';
DROP TABLE IF EXISTS `ims_sqtg_sun_suspension`;
CREATE TABLE `ims_sqtg_sun_suspension` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT '1' COMMENT '是否开启 1开启 0关闭',
  `show_index` tinyint(1) DEFAULT '1' COMMENT '1.只在首页显示 0.全部显示',
  `tel_icon` varchar(200) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `tel_open` tinyint(1) DEFAULT '1' COMMENT '1.一键拨号开启 0.关闭',
  `customer_service_open` tinyint(1) DEFAULT '1' COMMENT '1.客服图标开启 0.关闭',
  `customer_service_icon` varchar(200) DEFAULT NULL,
  `wxapp_open` tinyint(1) DEFAULT '1' COMMENT '1.开启外链 0.关闭',
  `wxapp_icon` varchar(200) DEFAULT NULL,
  `wxapp_appid` varchar(100) DEFAULT NULL,
  `wxapp_path` varchar(200) DEFAULT NULL COMMENT '外部小程序页面地址',
  `show_style` tinyint(1) DEFAULT '1' COMMENT '1.点击收起 0.显示全部',
  `back_icon` varchar(200) DEFAULT NULL COMMENT '回到首页图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='悬浮图标';
DROP TABLE IF EXISTS `ims_sqtg_sun_system`;
CREATE TABLE `ims_sqtg_sun_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `appid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appid',
  `appsecret` varchar(200) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appsecret',
  `mchid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户号',
  `wxkey` varchar(250) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户秘钥',
  `uniacid` int(11) DEFAULT NULL,
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  `apiclient_cert` text COMMENT '支付密钥退款发红包提现使用',
  `apiclient_key` text COMMENT '支付密钥退款发红包提现使用',
  `pt_name` varchar(30) DEFAULT NULL COMMENT '平台名称',
  `index_title` varchar(60) DEFAULT NULL COMMENT '首页自定义标题',
  `ht_title` varchar(60) DEFAULT NULL COMMENT '后台顶部自定义标题',
  `tel` varchar(20) DEFAULT NULL COMMENT '客服联系电话',
  `fontcolor` varchar(20) DEFAULT '#000000' COMMENT '平台顶部文字颜色(只有黑白)',
  `top_color` varchar(20) DEFAULT NULL COMMENT '平台顶部风格颜色',
  `bottom_color` varchar(20) DEFAULT NULL COMMENT '平台底部风格颜色',
  `jszc_show` int(4) NOT NULL DEFAULT '0' COMMENT '技术支持开关 1开 2关',
  `jszc_tel` varchar(20) DEFAULT NULL COMMENT '技术支持-电话',
  `jszc_img` varchar(200) DEFAULT NULL COMMENT '技术支持-头像',
  `jszc_name` varchar(50) DEFAULT NULL COMMENT '技术支持-团队名称',
  `receipt_num` int(11) NOT NULL DEFAULT '10' COMMENT '收货时间(从发货到自动确认收货的时间)',
  `after_sale_num` int(11) NOT NULL DEFAULT '7' COMMENT '售后时间',
  `send_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '发货方式 1快递或自提 2仅快递 3仅自提',
  `integral_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '积分开启状态 1开启',
  `integral_rate1` int(11) NOT NULL DEFAULT '1' COMMENT '积分比例商家比例 ',
  `integral_rate2` int(11) NOT NULL DEFAULT '1' COMMENT '积分比例赠送积分比例 当integral_rate1为1 integral_rate2为2时消费1元获得2积分',
  `is_open_member` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启会员功能 1开启',
  `member_info` text COMMENT '会员须知',
  `bottom_fontcolor_a` varchar(20) DEFAULT NULL COMMENT '底部导航文字选中前颜色',
  `bottom_fontcolor_b` varchar(20) DEFAULT NULL COMMENT '底部导航文字选中后颜色',
  `menu_fontcolor_a` varchar(20) DEFAULT NULL COMMENT '菜单图标文字选中前颜色',
  `menu_fontcolor_b` varchar(20) DEFAULT NULL COMMENT '菜单图标文字选中后颜色',
  `personcenter_color_b` varchar(20) DEFAULT NULL COMMENT '个人中心顶部背景',
  `showorderset` text COMMENT '展示订单设置',
  `showgw` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示福利群',
  `wg_title` varchar(100) DEFAULT NULL COMMENT '福利群名称',
  `wg_img` varchar(255) DEFAULT NULL COMMENT '福利群logo',
  `wg_keyword` varchar(255) DEFAULT NULL COMMENT '福利群加群关键字',
  `wg_directions` varchar(255) DEFAULT NULL COMMENT '福利群说明',
  `wg_addicon` varchar(255) DEFAULT NULL COMMENT '加群图标',
  `pt_pic` varchar(100) DEFAULT NULL COMMENT '平台名称',
  `bottom_cart_color_a` varchar(20) DEFAULT NULL COMMENT '底部导航购物车提示前景色',
  `bottom_cart_color_b` varchar(20) DEFAULT NULL COMMENT '底部导航购物车提示背景色',
  `map_key` varchar(100) DEFAULT NULL COMMENT '腾讯地图key',
  `goods_pic_b` varchar(100) DEFAULT NULL COMMENT '商品海报背景图',
  `theme_color_b` varchar(20) DEFAULT NULL COMMENT '主题背景',
  `delivery_type` int(4) NOT NULL DEFAULT '0' COMMENT '配送方式',
  `qt_appkey` varchar(50) DEFAULT NULL,
  `qt_isopen` int(4) DEFAULT '0',
  `zny_apid` varchar(100) DEFAULT NULL,
  `zny_apikey` varchar(100) DEFAULT NULL,
  `zny_auth` int(11) DEFAULT '0' COMMENT '1.供应商 2.会员',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_task`;
CREATE TABLE `ims_sqtg_sun_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL COMMENT '标题',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用',
  `level` int(11) DEFAULT '1',
  `value` varchar(255) DEFAULT NULL,
  `execute_time` int(11) DEFAULT NULL COMMENT '预计执行时间',
  `execute_times` int(11) DEFAULT '0' COMMENT '尝试执行次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='广告';
DROP TABLE IF EXISTS `ims_sqtg_sun_template`;
CREATE TABLE `ims_sqtg_sun_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `tid1` varchar(50) DEFAULT NULL COMMENT '支付通知',
  `tid2` varchar(50) DEFAULT NULL COMMENT '订单取消',
  `tid3` varchar(50) DEFAULT NULL COMMENT '发货通知',
  `tid4` varchar(50) DEFAULT NULL COMMENT '退款通知',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='模板消息';
DROP TABLE IF EXISTS `ims_sqtg_sun_templatecontent`;
CREATE TABLE `ims_sqtg_sun_templatecontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL COMMENT '任务id',
  `touser` varchar(30) DEFAULT NULL COMMENT '接受者',
  `template_id` varchar(60) DEFAULT NULL COMMENT '模板id',
  `page` varchar(200) DEFAULT NULL COMMENT '跳转页面',
  `form_id` varchar(60) DEFAULT NULL,
  `data` text,
  `create_time` int(11) DEFAULT NULL,
  `result` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模板内容信息';
DROP TABLE IF EXISTS `ims_sqtg_sun_user`;
CREATE TABLE `ims_sqtg_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `openid` varchar(100) DEFAULT NULL COMMENT 'openid',
  `img` varchar(200) DEFAULT NULL COMMENT '头像',
  `uniacid` int(11) DEFAULT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `name` varchar(101) CHARACTER SET utf8mb4 DEFAULT NULL,
  `birthday` varchar(40) DEFAULT NULL COMMENT '生日',
  `gender` int(1) DEFAULT '0' COMMENT '性别',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  `login_time` int(20) DEFAULT NULL,
  `share_user_id` int(11) DEFAULT '0' COMMENT '分享人id',
  `last_share_user_id` int(11) DEFAULT '0' COMMENT '最后分享人',
  `first_share_user_id` int(11) DEFAULT '0' COMMENT '最早推荐人id',
  `memberconf_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级id',
  `discount` decimal(10,1) DEFAULT '0.0' COMMENT '开启vip会员折扣',
  `vip_cardnum` varchar(20) DEFAULT NULL,
  `vip_endtime` int(11) DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户充值余额',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_userbalancerecord`;
CREATE TABLE `ims_sqtg_sun_userbalancerecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `sign` tinyint(4) DEFAULT NULL COMMENT ' 1.充值 2.支付 3.退款 4.后台操作 5.商户入驻费用 6.开卡返现',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注：商品名称、充值内容之类',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额（充值含赠送）',
  `send_money` decimal(10,2) DEFAULT '0.00' COMMENT '充值赠送的金额',
  `now_balance` decimal(10,2) DEFAULT '0.00' COMMENT '当前余额',
  `title` varchar(100) DEFAULT NULL COMMENT '名称',
  `create_time` int(11) DEFAULT NULL,
  `order_id` int(60) DEFAULT NULL COMMENT '订单id',
  `order_num` varchar(200) DEFAULT NULL COMMENT '订单号',
  `order_sign` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单标识 1普通订单 2合并订单',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='余额变动记录';
DROP TABLE IF EXISTS `ims_sqtg_sun_usercode`;
CREATE TABLE `ims_sqtg_sun_usercode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL COMMENT '随机码',
  `end_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户随机码';
DROP TABLE IF EXISTS `ims_sqtg_sun_usercoupon`;
CREATE TABLE `ims_sqtg_sun_usercoupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `create_time` int(11) DEFAULT NULL COMMENT '领取时间',
  `end_time` int(11) DEFAULT NULL COMMENT '过期时间',
  `state` int(4) NOT NULL DEFAULT '0' COMMENT '1未使用，2已使用',
  `use_time` int(11) DEFAULT NULL COMMENT '使用时间',
  `name` varchar(100) DEFAULT NULL COMMENT '优惠券名称',
  `info` text COMMENT '使用说明',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '满减金额',
  `use_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单笔满多少金额',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户优惠券';
DROP TABLE IF EXISTS `ims_sqtg_sun_vipcard`;
CREATE TABLE `ims_sqtg_sun_vipcard` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  `day` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `state` tinyint(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `salenum` int(11) DEFAULT '0' COMMENT '已售数量',
  `moneyback` decimal(10,2) DEFAULT '0.00' COMMENT '返现',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
DROP TABLE IF EXISTS `ims_sqtg_sun_withdraw`;
CREATE TABLE `ims_sqtg_sun_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL COMMENT '提现openid',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现全额',
  `wd_type` tinyint(4) DEFAULT NULL COMMENT '提现方式 1微信',
  `wd_account` varchar(100) DEFAULT NULL COMMENT '提现账号',
  `wd_name` varchar(255) DEFAULT NULL COMMENT '提现姓名',
  `wd_phone` varchar(255) DEFAULT NULL COMMENT '提现手机号',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提现状态 1成功 2失败',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `store_name` varchar(100) DEFAULT NULL COMMENT '商家名称',
  `baowen` text COMMENT '提现报文',
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败',
  `is_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0不需要审核 1需要审核',
  `err_code` varchar(50) DEFAULT NULL COMMENT '提现错误码',
  `err_code_des` varchar(200) DEFAULT NULL COMMENT '失败原因',
  `tx_time` int(11) DEFAULT NULL COMMENT '提现时间',
  `request_time` int(11) DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `review_time` int(11) DEFAULT NULL COMMENT '审核时间',
  `return_status` tinyint(4) NOT NULL DEFAULT '0',
  `return_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sqtg_sun_withdrawbaowen`;
CREATE TABLE `ims_sqtg_sun_withdrawbaowen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `baowen` text,
  `wd_id` int(11) DEFAULT NULL COMMENT '提现id',
  `add_time` int(11) DEFAULT NULL,
  `request_data` text COMMENT '请求数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现报文';
DROP TABLE IF EXISTS `ims_sqtg_sun_withdrawset`;
CREATE TABLE `ims_sqtg_sun_withdrawset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `wd_type` varchar(255) NOT NULL DEFAULT '1' COMMENT '提现方式 1微信提现',
  `min_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额',
  `avoidmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额',
  `is_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现开关 1开 2关',
  `cms_rates` float NOT NULL DEFAULT '0' COMMENT '平台抽成比率',
  `wd_wxrates` float NOT NULL DEFAULT '0' COMMENT '微信提现手续费费率',
  `wd_content` text COMMENT '提现须知',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现设置';





DROP TABLE IF EXISTS `ims_sqtg_sun_menu`;
CREATE TABLE `ims_sqtg_sun_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '菜单名称',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  `memo` varchar(200) DEFAULT NULL COMMENT '备注',
  `index` int(10) DEFAULT NULL COMMENT '排序',
  `menugroup_id` int(11) DEFAULT NULL COMMENT '分组id',
  `control` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `menu_id` int(11) DEFAULT '0',
  `state` tinyint(1) DEFAULT '1' COMMENT '1.启用 0.禁用',
  `store_show` int(4) DEFAULT '1' COMMENT '商户后台是否显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=810 DEFAULT CHARSET=utf8;

INSERT INTO `ims_sqtg_sun_menu` VALUES ('660', '人员管理', '1534122942', '1537319632', '', '0', '0', 'cadmin', 'index', 'fa fa-user', '692', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('661', '门店管理', '1534122949', '1535103597', '', '0', '660', '', '', 'fa fa-dashboard', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('662', '用户列表', '1534122959', '1535103616', '', '0', '659', 'cuser', 'index', 'fa fa-archive', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('664', '小程序配置', '1534142208', '1548231359', '', '0', '657', 'csystem', 'smallapp', 'fa fa-asterisk', '670', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('668', '版权设置', '1535334477', '1548231538', '', '6', '657', 'csystem', 'team', 'fa fa-external-link', '669', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('669', '系统设置', '1535335730', '1535335801', '', '0', '657', '', '', 'fa fa-cog', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('670', '小程序设置', '1535335948', '1535336021', '', '0', '657', '', '', 'fa fa-dot-circle-o', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('671', '模板消息', '1535337543', '1548232516', '', '10', '0', 'Ctemplate', 'setting', 'fa fa-external-link', '670', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('672', '广告管理', '1535338932', '1536135152', '', '0', '661', 'Cad', 'index', 'fa fa-desktop', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('673', '基础设置', '1535354563', '1535703336', '', '0', '0', 'csystem', 'platform', 'fa fa-external-link', '669', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('674', '商品分类', '1535426753', '1548232657', '', '10', '653', 'ccategory', 'index', 'fa fa-bars', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('675', '公告管理', '1535440902', '1535440902', '', '0', '661', 'cannouncement', 'index', 'fa fa-bullhorn', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('677', '优惠券', '1535687870', '1548232622', '', '10', '662', 'ccoupon', 'index', 'fa fa-file', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('678', '商品列表', '1535697093', '1548232665', '', '20', '653', 'cgoods', 'index', 'fa fa-medkit', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('680', '菜单图标', '1536199266', '1537406864', '', '1', '657', 'Ccoustomize', 'menuicon', 'fa fa-external-link', '670', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('681', '底部导航图标', '1536215282', '1548232552', '', '6', '0', 'Ccoustomize', 'navicon', 'fa fa-external-link', '670', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('690', '样式设置', '1537165353', '1548232506', '', '5', '0', 'Csystem', 'appstyle', 'fa fa-external-link', '670', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('691', '任务设置', '1537282772', '1548232286', '', '6', '0', 'Ctask', 'index', 'fa fa-external-link', '669', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('696', '应用', '1538018583', '1538018583', '', '0', '664', 'Cinstall', 'index', 'fa fa-certificate', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('697', '商户列表', '1538032551', '1538188191', '', '10', '0', 'Cstore', 'index', 'fa fa-bank', '698', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('698', '商户管理', '1538188121', '1538188121', '', '0', '663', '', '', 'fa fa-external-link', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('699', '账号管理', '1538190886', '1538190886', '', '15', '0', 'Cadmin', 'index2', 'fa fa-external-link', '698', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('700', '悬浮图标', '1538204806', '1548232581', '', '8', '657', 'Csuspension', 'edit', 'fa fa-external-link', '670', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('701', '商户设置', '1538214011', '1538214011', '', '0', '0', 'Cstore', 'setting', 'fa fa-certificate', '698', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('706', '商品审核', '1539227144', '1539227144', '', '20', '0', 'Cgoods', 'index2', 'fa fa-external-link', '698', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('708', '提现设置', '1539401196', '1539401196', '', '40', '663', 'cwithdrawset', 'config', 'fa fa-cog', '698', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('709', '提现列表', '1539401402', '1539401402', '', '50', '663', 'cwithdraw', 'index', 'fa fa-file-text-o', '698', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('710', '商家资金明细', '1539401486', '1539401486', '', '30', '663', 'cmercapdetails', 'index', 'fa fa-bank', '698', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('714', '分销管理', '1539680952', '1539680952', '', '0', '663', '', '', 'fa fa-group', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('715', '分销商', '1539681010', '1539681010', '', '0', '0', 'Cdistribution', 'index', 'fa fa-external-link', '714', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('716', '分销设置', '1539681336', '1539681336', '', '0', '0', 'Cdistribution', 'setting', 'fa fa-external-link', '714', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('722', '分销订单', '1540452152', '1540452152', '', '0', '0', 'Cdistributionorder', 'index', 'fa fa-external-link', '714', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('726', '提现设置', '1540521308', '1540521308', '', '0', '0', 'Cdistribution', 'withdrawsetting', 'fa fa-external-link', '714', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('727', '提现列表', '1540605919', '1540605919', '', '0', '0', 'Cdistributionwithdraw', 'index', 'fa fa-external-link', '714', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('739', '打印机管理', '1541403618', '1548231511', '', '5', '657', 'cprints', 'index', 'fa fa-external-link', '669', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('740', '打印设置', '1541403670', '1548231505', '', '4', '657', 'cprints', 'set', 'fa fa-external-link', '669', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('742', '短信设置', '1541640320', '1548231494', '', '1', '657', 'csms', 'set', 'fa fa-file-sound-o', '669', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('745', '钉钉机器人设置', '1541666536', '1548232300', '', '5', '657', 'Cdingtalk', 'set', 'fa fa-child', '669', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('746', '展示订单设置', '1542101230', '1547431981', '', '5', '658', 'Corderset', 'set', 'fa fa-file-o', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('747', '福利群设置', '1542244558', '1548232533', '', '30', '657', 'Cwelfaregroup', 'set', 'fa fa-cny', '670', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('748', '团长列表', '1542606898', '1542606898', '', '10', '666', 'Cleader', 'index', 'fa fa-building', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('749', '配送范围(团长）', '1542869599', '1543305155', '', '15', '666', 'Cstoreleader', 'index', 'fa fa-external-link', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('750', '提现设置', '1542874731', '1542874731', '', '40', '666', 'Cleader', 'withdrawsetting', 'fa fa-external-link', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('751', '提现列表', '1542874812', '1542874812', '', '50', '666', 'Cleaderwithdraw', 'index', 'fa fa-external-link', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('752', '配送单', '1543027013', '1543027013', '', '0', '658', 'Cdeliveryorder', 'index', 'fa fa-archive', '0', '0', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('753', '团长设置', '1543287647', '1543287647', '', '0', '666', 'Cleader', 'setting', 'fa fa-asterisk', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('754', '订单管理', '1543557820', '1547431941', '', '1', '658', 'Cordergoods', 'index', 'fa fa-tasks', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('755', '团长订单明细', '1543562563', '1547431975', '', '4', '658', 'Cordergoods', 'index2', 'fa fa-child', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('757', '优惠券设置', '1543989260', '1543989260', '', '0', '662', 'Ccoupon', 'setting', 'fa fa-cog', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('758', '团长核销员', '1544497986', '1544497986', '', '30', '666', 'Cleaderuser', 'index', 'fa fa-child', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('759', '退款订单列表', '1546595017', '1547431968', '', '3', '658', 'Cordergoods', 'index4', 'fa fa-history', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('760', '采购统计表', '1547108106', '1547108106', '', '0', '658', 'Cordergoods', 'index5', 'fa fa-bell', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('761', '配送统计表', '1547109427', '1547431957', '', '2', '658', 'Cordergoods', 'index6', 'fa fa-bar-chart-o', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('762', '分类设置', '1548052434', '1548053662', '', '0', '653', 'ccategory', 'setting', 'fa fa-arrows', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('763', '团长账单', '1548063603', '1548063603', '', '20', '666', 'Cleaderbill', 'index', 'fa fa-bar-chart-o', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('764', '页面链接', '1548402359', '1548402359', '', '0', '657', 'csystem', 'page', 'fa fa-building', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('771', '机器人管理', '1552379277', '1552379277', '', '0', '653', 'crobot', 'index', 'fa fa-child', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('772', '拼团管理', '1540797468', '1540797468', '', '6', '663', '', '', 'fa fa-cubes', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('773', '分类列表', '1540797566', '1540797566', '', '0', '663', 'Cpinclassify', 'index', 'fa fa-external-link', '772', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('774', '商品列表', '1540801448', '1540801448', '', '1', '663', 'Cpingoods', 'index', 'fa fa-external-link', '772', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('775', '拼团设置', '1541139381', '1541139381', '', '3', '663', 'Cpingoods', 'pinset', 'fa fa-external-link', '772', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('776', '订单列表', '1541555004', '1541555004', '', '3', '663', 'Cpingoods', 'orderlist', 'fa fa-external-link', '772', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('777', '商品审核', '1541659321', '1541659321', '', '5', '664', 'Cpingoods', 'checks', 'fa fa-external-link', '772', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('800', '参数配置', '1558320071', '1558320071', '', '1', '667', 'Csystem', 'apiset', 'fa fa-asterisk', '0', '1', '0');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('801', '挚能云商品', '1558320171', '1558320171', '', '2', '667', 'Cgoods', 'znygoods', 'fa fa-paper-plane', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('802', '普通商品采购统计', '1562806562', null, '', '0', '0', 'cordergoods', 'index5', '', '760', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('803', '拼团商品采购统计', '1562806562', null, '', '0', '0', 'cpingoods', 'purchase', '', '760', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('804', '普通商品配送统计表', '1562806562', null, '', '0', '0', 'cordergoods', 'index6', '', '761', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('805', '拼团商品配送统计表', '1562806562', null, '', '0', '0', 'cpingoods', 'delivery', '', '761', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('806', '普通商品团长账单', '1562806562', null, '', '0', '0', 'Cleaderbill', 'index', '', '763', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('807', '拼团商品团长账单', '1562806562', null, '', '0', '0', 'Cleaderbill', 'indexpin', '', '763', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('808', '普通商品明细', '1562806562', null, '', '0', '0', 'Cordergoods', 'index2', '', '755', '1', '1');
INSERT INTO `ims_sqtg_sun_menu` VALUES ('809', '拼团商品明细', '1562806562', null, '', '0', '0', 'Cpingoods', 'leaderOrder', '', '755', '1', '1');

DROP TABLE IF EXISTS `ims_sqtg_sun_menugroup`;
CREATE TABLE `ims_sqtg_sun_menugroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '菜单分组名称',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  `memo` varchar(200) DEFAULT NULL COMMENT '备注',
  `index` int(10) DEFAULT NULL COMMENT '排序',
  `state` tinyint(1) DEFAULT '1' COMMENT '1.启用 0.禁用',
  `store_show` int(4) DEFAULT '1' COMMENT '商户后台是否显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=669 DEFAULT CHARSET=utf8;

INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('653', '商品管理', '1533880310', '1535103145', '', '3', '1', '1');
INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('657', '基础设置', '1535102854', '1537409654', '', '0', '1', '1');
INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('658', '订单管理', '1535102881', '1535102881', '', '4', '1', '1');
INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('659', '用户管理', '1535102902', '1535102902', '', '6', '1', '0');
INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('661', '内容管理', '1535102934', '1535102934', '', '10', '1', '0');
INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('662', '营销管理', '1535102946', '1535102946', '', '20', '1', '0');
INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('663', '应用专区', '1535102984', '1535102984', '', '30', '1', '1');
INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('666', '团长管理', '1542606828', '1542606853', '', '27', '1', '1');
INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('667', '云供销管理', '1558319780', '1558319780', '', '40', '1', '1');
INSERT INTO `ims_sqtg_sun_menugroup` VALUES ('668', '财务管理', '1558319780', '1558319780', '', '31', '1', '0');




");