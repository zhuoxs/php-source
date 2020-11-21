<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_yztc_sun_accessrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户访问记录';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_acode` (
  `id` int(11) NOT NULL,
  `code` text COMMENT '随机码',
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='软件授权码';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` int(5) DEFAULT '1' COMMENT '1.普通商品 2.抢购 3.优惠券',
  `cat_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT NULL COMMENT '原价',
  `sale_price` decimal(10,2) DEFAULT NULL,
  `vip_price` decimal(10,2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `check_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '审核状态 1未审核 2审核通过 3审核失败',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.启用',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `url` varchar(200) DEFAULT NULL COMMENT '链接',
  `pic` varchar(200) DEFAULT NULL COMMENT '图片',
  `sort` int(4) NOT NULL DEFAULT '1' COMMENT '排序',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `type` int(4) DEFAULT NULL COMMENT '广告类型：1、首页轮播图，2、首页中部广告 3抢购轮播图 4集市轮播图',
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用',
  `store_id` int(11) DEFAULT '0' COMMENT '商家id',
  `link_type` int(1) DEFAULT '1' COMMENT '1.内链 2.外部小程序 3.客服消息',
  `appid` varchar(100) DEFAULT NULL COMMENT '外部小程序APPID',
  `path` varchar(200) DEFAULT NULL COMMENT '外部小程序链接地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='广告';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `uniacid` int(11) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL COMMENT '头像',
  `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  `login_time` int(20) DEFAULT NULL,
  `store_id` int(11) DEFAULT '0' COMMENT '门店id',
  `code` varchar(100) DEFAULT NULL COMMENT '账号',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `state` int(4) DEFAULT '0' COMMENT '状态：1启用 0禁用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理员账号';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1首页公告',
  `title` varchar(100) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '启用状态1启用',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公告管理';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_baowen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xml` text,
  `out_trade_no` varchar(60) DEFAULT NULL,
  `transaction_id` varchar(60) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `out_trade_no` (`out_trade_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='支付报文';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_browserecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1商品浏览记录',
  `user_id` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='浏览记录';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类别类型 1正常商品分类 2快速购买类别',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级(上一级)分类id',
  `name` varchar(60) DEFAULT NULL COMMENT '名称',
  `icon` varchar(250) DEFAULT NULL COMMENT '分类图标',
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用状态',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 1删除',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `index` int(11) DEFAULT NULL,
  `is_hot` int(4) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `level` int(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='类别管理';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `citycode` varchar(255) NOT NULL,
  `adcode` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL COMMENT '经度',
  `lat` varchar(255) NOT NULL COMMENT '纬度',
  `level` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3264 DEFAULT CHARSET=utf8 COMMENT='全国省市';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '收藏类型 1门店',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店id type=1使用',
  `is_collection` tinyint(4) NOT NULL DEFAULT '1' COMMENT '收藏状态 1收藏 0取消收藏',
  `collect_time` int(11) DEFAULT NULL COMMENT '收藏时间',
  `cancel_time` int(11) DEFAULT NULL COMMENT '取消时间',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏信息表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` varchar(60) DEFAULT NULL,
  `order_id` int(60) DEFAULT NULL,
  `order_detail_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `imgs` text,
  `content` text,
  `create_time` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1.普通商品 2.抢购',
  `anonymous` tinyint(1) DEFAULT '0' COMMENT '1.匿名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单评价';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_commonorder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(100) DEFAULT NULL,
  `num` int(11) DEFAULT '0',
  `store_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单总额',
  `type` int(5) DEFAULT '1' COMMENT '1.普通商品 2.抢购 3.优惠券 4.拼团',
  `goods_id` int(11) DEFAULT '0' COMMENT '对应商品id',
  `create_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_status` int(11) DEFAULT '10' COMMENT '50申请售后 51 已退款 52 退款失败 53 拒绝退款 ',
  `update_time` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公共订单表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `key` varchar(50) DEFAULT NULL COMMENT '关键字',
  `value` text COMMENT '值',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='配置信息';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `pic` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `full` varchar(10) COLLATE utf8mb4_bin DEFAULT '0' COMMENT '满多少可用',
  `day` int(11) DEFAULT '0' COMMENT '领取后几天过期',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '到期时间',
  `gettype` tinyint(1) DEFAULT '1' COMMENT '1.付费领取 2.转发领取 3.免费领取',
  `getmoney` decimal(10,2) DEFAULT '0.00' COMMENT '领取金额',
  `num` int(11) DEFAULT '0' COMMENT '0.不限量',
  `sales_num_virtua` int(11) DEFAULT '0' COMMENT '虚拟领取数',
  `sales_num` int(11) DEFAULT '0',
  `instructions` text COLLATE utf8mb4_bin COMMENT '使用说明',
  `create_time` int(11) DEFAULT NULL,
  `is_recommend` tinyint(1) DEFAULT '0' COMMENT '1.推荐',
  `uniacid` int(11) DEFAULT NULL,
  `state` tinyint(1) DEFAULT '1',
  `lng` varchar(10) COLLATE utf8mb4_bin DEFAULT '0',
  `lat` varchar(10) COLLATE utf8mb4_bin DEFAULT '0',
  `pics` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '轮播图',
  `read_num` int(11) DEFAULT '0',
  `read_num_virtual` int(11) DEFAULT '0',
  `only_vip` tinyint(1) DEFAULT '0' COMMENT '1.仅会员使用',
  `use_starttime` int(11) DEFAULT NULL,
  `use_startday` int(11) DEFAULT NULL,
  `limit_num` int(11) DEFAULT '0' COMMENT '每人限领',
  `is_del` tinyint(1) DEFAULT '0',
  `show_index` tinyint(1) DEFAULT '0',
  `is_activity` tinyint(1) DEFAULT '0',
  `check_status` int(11) DEFAULT '2' COMMENT '1.未审核',
  `indexpic` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `posterpic` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='卡券表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_couponget` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_no` varchar(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `gettype` int(1) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `write_off_status` tinyint(1) DEFAULT '0',
  `write_off_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `out_trade_no` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `help_uid` int(11) DEFAULT NULL,
  `prepay_id` varchar(200) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_customize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2菜单图标 3底部图标 4分类信息 5商家',
  `title` varchar(255) DEFAULT NULL COMMENT '标题名称',
  `pic` varchar(200) DEFAULT NULL COMMENT '图标图片',
  `clickago_icon` varchar(200) DEFAULT NULL COMMENT '点击前图标',
  `clickafter_icon` varchar(200) DEFAULT NULL COMMENT '点击后图标',
  `link_type` tinyint(1) DEFAULT '1' COMMENT '1.内链 2.外部小程序 3.客服消息 4同城分类信息',
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='自定义信息包含菜单底部菜单轮播图也适用';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_dingtalk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `token` varchar(100) DEFAULT NULL,
  `is_open` tinyint(4) NOT NULL DEFAULT '0',
  `content` varchar(255) DEFAULT NULL COMMENT '下订单提醒',
  `contentrefund` varchar(255) DEFAULT NULL COMMENT '退款申请提醒',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_distributionmercapdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `promoter_id` int(11) DEFAULT NULL COMMENT '合伙人(分销商)id',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '方式 1普通商品 2抢购商品 3拼团商品 4会员卡 5提现',
  `mcd_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现方式 1分销订单收入 2微信提现 3审核失败退款 5提现失败收入',
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
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `now_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前余额(处理后获取的当前余额)',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合伙人分销佣金明细';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_distributionorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单类别 1普通商品 2抢购商品 3拼团商品 4会员卡',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) DEFAULT NULL,
  `parents_id_1` int(11) NOT NULL DEFAULT '0' COMMENT '一级id',
  `parents_id_2` int(11) NOT NULL DEFAULT '0' COMMENT '二级id',
  `parents_id_3` int(11) NOT NULL DEFAULT '0' COMMENT '三级id',
  `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  `rebate` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否自购',
  `create_time` int(11) DEFAULT NULL,
  `is_del` tinyint(4) NOT NULL DEFAULT '0',
  `settle_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '结算状态 1已结算',
  `finish_time` int(11) DEFAULT NULL COMMENT '核销完成时间',
  `settle_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '结算方式 1平台 2商家',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_distributionpromoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `condition_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成为分销商方式 1无条件 2申请 3消费金额（设置消费金额达到多少）、4购买商品（选择商品）、5成为会员',
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `allcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计佣金',
  `canwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现佣金',
  `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现冻结金额',
  `referrer_name` varchar(60) DEFAULT NULL COMMENT '推荐人',
  `referrer_uid` int(11) DEFAULT NULL COMMENT '推荐人id',
  `check_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1未审核 2审核通过 3审核失败',
  `check_time` int(11) DEFAULT NULL COMMENT '审核时间',
  `fail_reason` varchar(200) DEFAULT NULL COMMENT '审核失败原因',
  `form_id` varchar(50) DEFAULT NULL COMMENT '模板消息',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_distributionset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分销层级 0不开启 1一级 2二级 3三级',
  `inapp_buy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分销内购 1开启',
  `lower_condition` tinyint(4) NOT NULL DEFAULT '1' COMMENT '成为下线条件 1首次点击分销链接 2首次购买(付款)',
  `distribution_condition` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成为分销商条件 1无条件 2申请 3消费金额（设置消费金额达到多少）、4购买商品（选择商品）、5成为会员',
  `consumption_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额 当distribution_condition=3生效',
  `first_name` varchar(200) DEFAULT NULL,
  `second_name` varchar(200) DEFAULT NULL,
  `third_name` varchar(200) DEFAULT NULL,
  `is_check` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否需要审核 1需要 0不需要',
  `store_setting` tinyint(4) NOT NULL DEFAULT '0' COMMENT '商家是否可设置分销 1该商家总体佣金和单商品佣金 0平台',
  `withhold` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分销佣金扣款 1平台 2商家',
  `join_module` varchar(100) NOT NULL DEFAULT '1,2,3,4' COMMENT '参与分销模块 中间用逗号隔开 1普通商品 2抢购商品 3拼团商品 4会员卡',
  `withdraw_type` varchar(100) NOT NULL DEFAULT '1' COMMENT '提现方式 1微信 2支付宝 3银行卡 4余额 中间用逗号隔开',
  `min_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度',
  `withdraw_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费',
  `daymax_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限',
  `pass_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额(多少以内免审）',
  `user_notice` text COMMENT '用户协议',
  `withdraw_notice` text COMMENT '提现须知',
  `application` text COMMENT '申请协议',
  `commissiontype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分销佣金类型 1百分比 2固定金额',
  `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额',
  `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额',
  `third_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级金额',
  `create_time` int(11) DEFAULT NULL,
  `banner` varchar(200) DEFAULT NULL COMMENT 'banner',
  `exclusive_rights` text COMMENT '专属权利',
  `poster_title` varchar(60) DEFAULT NULL COMMENT '海报标题',
  `poster_pic` varchar(200) DEFAULT NULL COMMENT '海报图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_distributionwithdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `promoter_id` int(11) DEFAULT NULL,
  `openid` varchar(100) DEFAULT NULL COMMENT '提现openid',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现全额',
  `wd_type` tinyint(4) DEFAULT NULL COMMENT '提现方式 1微信',
  `wd_account` varchar(100) DEFAULT NULL COMMENT '提现账号',
  `wd_name` varchar(255) DEFAULT NULL COMMENT '提现姓名',
  `wd_phone` varchar(255) DEFAULT NULL COMMENT '提现手机号',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提现状态 1成功 2失败',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `baowen` text COMMENT '提现报文',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败',
  `is_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0不需要审核 1需要审核',
  `err_code` varchar(50) DEFAULT NULL COMMENT '提现错误码',
  `err_code_des` varchar(200) DEFAULT NULL COMMENT '失败原因',
  `tx_time` int(11) DEFAULT NULL COMMENT '提现时间',
  `request_time` int(11) DEFAULT NULL,
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `review_time` int(11) DEFAULT NULL COMMENT '审核时间',
  `return_status` tinyint(4) NOT NULL DEFAULT '0',
  `return_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `citycode` varchar(255) NOT NULL,
  `adcode` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL COMMENT '经度',
  `lat` varchar(255) NOT NULL COMMENT '纬度',
  `level` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='全国省市';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `form_id` varchar(20) DEFAULT NULL,
  `time` int(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单id';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_freesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT '0',
  `cat_id` int(11) DEFAULT '0' COMMENT '商品分类id',
  `name` varchar(100) DEFAULT NULL COMMENT '商品名称',
  `unit` varchar(10) DEFAULT '个' COMMENT '单位',
  `weight` double(10,2) DEFAULT '0.00' COMMENT '重量',
  `sort` int(11) DEFAULT '0' COMMENT '排序 从大到小',
  `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)',
  `pics` text COMMENT '商品轮播图',
  `sales_price` decimal(10,2) DEFAULT '0.00',
  `original_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价展示使用',
  `details` text COMMENT '商品详细',
  `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)',
  `postagerules_id` int(11) DEFAULT NULL COMMENT '运费模板id',
  `sales_num` int(11) DEFAULT '0' COMMENT '销量 销量支付完成',
  `sales_num_virtual` int(11) DEFAULT '0' COMMENT '虚拟销量',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `state` int(4) DEFAULT '1' COMMENT '1启用状态',
  `is_recommend` int(4) DEFAULT '0' COMMENT '是否推荐',
  `check_status` int(4) DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `fail_reason` varchar(255) DEFAULT NULL,
  `sendtype` tinyint(1) DEFAULT '1' COMMENT '1.到店 2.物流',
  `only_vip` tinyint(1) DEFAULT '0' COMMENT '1.仅限vip',
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `lottery_time` int(11) DEFAULT NULL,
  `expire_time` int(11) DEFAULT NULL,
  `read_num` int(11) DEFAULT '0',
  `read_num_virtual` int(11) DEFAULT '0',
  `is_del` tinyint(1) DEFAULT '0',
  `allnum` int(11) DEFAULT '0' COMMENT '总份数',
  `is_activity` tinyint(1) DEFAULT '0' COMMENT '1.添加到活动列表',
  `indexpic` varchar(100) DEFAULT NULL,
  `share_num` int(11) DEFAULT '0' COMMENT '转发获得抽奖码次数',
  `auto_lottery` int(1) DEFAULT '1' COMMENT '1.自动开奖 2.手动 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='免单商品表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_freesheetcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `lottery_code` varchar(100) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `lottery_status` int(1) DEFAULT '0',
  `order_id` int(11) DEFAULT NULL,
  `help_uid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='免单抽奖码';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_freesheetorder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `create_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `out_trade_no` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `lottery_status` tinyint(1) DEFAULT '0' COMMENT '0.未开奖 1.为中奖 2.已中奖',
  `write_off_time` int(11) DEFAULT NULL,
  `order_no` varchar(100) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='免单订单表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `goods_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商品营销类别 1普通商品 2预约商品',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `name` varchar(100) DEFAULT NULL COMMENT '商品名称',
  `unit` varchar(10) NOT NULL DEFAULT '个' COMMENT '单位',
  `weight` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '重量',
  `index` int(11) NOT NULL DEFAULT '0' COMMENT '排序 从大到小',
  `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)',
  `indexpic` varchar(200) DEFAULT NULL,
  `pics` text COMMENT '商品轮播图',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价',
  `vip_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本价',
  `original_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品原价展示使用',
  `is_quick` int(4) NOT NULL DEFAULT '0' COMMENT '1添加到快速购买',
  `details` text NOT NULL COMMENT '商品详细',
  `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)',
  `postagerules_id` int(11) DEFAULT NULL COMMENT '运费模板id',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `sales_num` int(11) NOT NULL DEFAULT '0' COMMENT '销量 销量支付完成',
  `sales_num_virtual` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟销量',
  `use_attr` int(4) NOT NULL DEFAULT '0' COMMENT '1使用规格',
  `attr` longtext COMMENT '规格库存和价格',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用状态',
  `is_recommend` int(4) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `platform_cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '平台商品分类id',
  `check_status` int(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `fail_reason` varchar(255) DEFAULT NULL,
  `only_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '仅限会员购买 1',
  `only_num` int(11) NOT NULL DEFAULT '0' COMMENT '会员免费几单',
  `common_num` int(11) NOT NULL DEFAULT '0' COMMENT '普通用户免费几单',
  `limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '限购单数',
  `end_time` int(11) DEFAULT NULL,
  `expir_time` int(11) DEFAULT NULL COMMENT '核销过期时间',
  `is_support_refund` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否支持退款  0不支持 1支持',
  `is_activity` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否添加到活动列表',
  `expire_time` int(11) DEFAULT '0' COMMENT '最后核销时间',
  `distribution_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启单独分销',
  `commissiontype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1百分比',
  `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额',
  `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额',
  `third_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级金额',
  `posterpic` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_goodsattr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格名称',
  `goods_id` int(11) DEFAULT NULL,
  `goodsattrgroup_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_goodsattrgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格分组名称',
  `goods_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格分组表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_goodsattrsetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `key` varchar(250) DEFAULT NULL COMMENT '规格名称列表',
  `attr_ids` varchar(250) NOT NULL DEFAULT '' COMMENT '规格ids',
  `goods_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `vip_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员价',
  `weight` double(10,2) DEFAULT '0.00' COMMENT '重量',
  `code` varchar(50) DEFAULT '' COMMENT '编码',
  `pic` varchar(255) DEFAULT '' COMMENT '封面图',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格设置表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `topcat_id` int(11) DEFAULT NULL COMMENT '最顶级分类id',
  `cat_id` int(11) DEFAULT NULL COMMENT '分类id',
  `content` text COMMENT '内容',
  `pic` text COMMENT '发布图片',
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `area_adcode` varchar(30) DEFAULT NULL COMMENT '区域编码',
  `lng` varchar(20) DEFAULT NULL COMMENT '经度',
  `lat` varchar(20) DEFAULT NULL COMMENT '纬度',
  `topping_time` int(11) NOT NULL DEFAULT '0' COMMENT '置顶时间',
  `need_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否需要审核',
  `check_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '审核状态 1未审核 2审核成功 3审核失败',
  `check_time` int(11) DEFAULT NULL,
  `fail_reason` varchar(100) DEFAULT NULL COMMENT '失败原因',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `citycode` varchar(60) DEFAULT NULL,
  `adcode` varchar(60) DEFAULT NULL,
  `sort_id` int(11) NOT NULL DEFAULT '0' COMMENT '置顶排序id',
  `top_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '置顶状态 1置顶',
  `top_id` int(11) NOT NULL DEFAULT '0' COMMENT '置顶收费id',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1支付成功(top_id>0生效)',
  `record_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单记录id',
  `popularity_num` int(11) NOT NULL DEFAULT '0' COMMENT '人气',
  `pageviews_num` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `is_del` tinyint(4) NOT NULL DEFAULT '0',
  `posting_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '发帖收的费用',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示 1显示(当要收费时 没有支付就不显示)',
  `pay_status_posting` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态(针对发帖)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8 COMMENT='帖子';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_infobrowselike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1浏览记录 2收藏',
  `info_id` int(11) NOT NULL DEFAULT '0' COMMENT '帖子id',
  `collect_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1收藏 2取消收藏',
  `collect_time` int(11) DEFAULT NULL COMMENT '收藏时间',
  `cancel_time` int(11) DEFAULT NULL COMMENT '取消时间 ',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=707 DEFAULT CHARSET=utf8 COMMENT='帖子收藏点赞记录表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_infocategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1信息类 ',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级',
  `name` varchar(60) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `is_del` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `index` int(11) NOT NULL DEFAULT '255' COMMENT '从小到大',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='帖子分类';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_infocomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '评论或者回复用户',
  `to_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '被回复的用户',
  `info_id` int(11) NOT NULL DEFAULT '0' COMMENT '帖子id',
  `top_comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '最顶级评论id',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复记录id',
  `content` text COMMENT '评论内容',
  `comment_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '评论类型 1评论 2回复',
  `create_time` int(11) DEFAULT NULL,
  `is_del` tinyint(4) NOT NULL DEFAULT '0',
  `check_status` tinyint(4) NOT NULL DEFAULT '1',
  `check_time` int(11) DEFAULT NULL,
  `fail_reason` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='帖子评论表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_inforefund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL COMMENT '置顶记录订单id',
  `types` tinyint(4) NOT NULL DEFAULT '1' COMMENT '退款种类 1置顶退款',
  `refund_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款方式 1微信退款',
  `order_refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1仅退款',
  `refund_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `create_time` int(11) DEFAULT NULL,
  `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1退款成功 2退款失败',
  `refund_time` tinyint(11) DEFAULT NULL COMMENT '退款时间',
  `err_code` varchar(200) DEFAULT NULL COMMENT '退款失败错误码',
  `err_code_dec` varchar(200) DEFAULT NULL COMMENT '错误信息',
  `xml` text COMMENT '退款报文',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='置顶退款记录表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_infosettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `disclaimer` text COMMENT '免责声明',
  `release_notice` text COMMENT '发布须知',
  `is_check` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否需要审核 1需要 0不需要',
  `create_time` int(11) DEFAULT NULL,
  `national_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1全国版',
  `post_address` tinyint(4) NOT NULL DEFAULT '1' COMMENT '发帖地址 1开启 0关闭不显示发帖地址',
  `post_nearby` tinyint(4) NOT NULL DEFAULT '0' COMMENT '帖子附近 1开启信息列表附近排序',
  `post_browse` int(11) NOT NULL DEFAULT '0' COMMENT '帖子浏览数',
  `post_num` int(11) NOT NULL DEFAULT '0' COMMENT '每天发帖限制数量',
  `comment_check` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评论审核开关 1需要',
  `word_filtering` longtext COMMENT '词语过滤',
  `posting_fee_switch` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发帖收费开关 1收费',
  `posting_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每条帖子收费金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='帖子相关配置信息';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_infosort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '1帖子信息排序值',
  `sort` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='排序值(主要用来计算)';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_infotop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `day_num` int(11) NOT NULL DEFAULT '1' COMMENT '天数',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='置顶收费配置';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_infotoprecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `info_id` int(11) DEFAULT NULL COMMENT '帖子id',
  `user_id` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `top_id` int(11) NOT NULL DEFAULT '0' COMMENT '置顶收费id',
  `day_num` int(11) NOT NULL DEFAULT '0' COMMENT '置顶天数',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `order_no` varchar(60) DEFAULT NULL,
  `out_trade_no` varchar(60) DEFAULT NULL,
  `transaction_id` varchar(60) DEFAULT NULL,
  `pay_status` tinyint(4) NOT NULL DEFAULT '0',
  `pay_time` int(11) DEFAULT NULL,
  `use_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '使用状态 1已使用',
  `need_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否需要审核 1需要',
  `check_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '审核状态 1未审核 2审核成功 3审核失败',
  `check_time` int(11) DEFAULT NULL,
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未付款 1已付款待审核 2已付款审核成功 3已付款审核失败(退款) ',
  `refund_status` tinyint(4) DEFAULT '0' COMMENT '退款状态 0处理中 1退款成功 2退款失败(当order_status=3退款生效)',
  `refund_time` int(11) DEFAULT NULL,
  `refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='帖子置顶记录';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_integralcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(60) DEFAULT NULL COMMENT '名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '启用状态 1启用',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分商品类别';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_integralconf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `is_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否开启1开启',
  `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `address` varchar(250) DEFAULT NULL COMMENT '自提地址',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT '0.00' COMMENT '消费金额',
  `score` int(11) DEFAULT '0' COMMENT '可得积分',
  `rule` text COMMENT '积分规则',
  `banner` text COMMENT '轮播图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分商城配置';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_integralgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL COMMENT '分类id',
  `name` varchar(200) DEFAULT NULL COMMENT '积分商品名称',
  `cover` varchar(200) DEFAULT NULL COMMENT '缩略图',
  `pics` text COMMENT '商品图或轮播图',
  `intergral` int(11) NOT NULL DEFAULT '0' COMMENT '价值积分',
  `sales_numxn` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟销量',
  `sales_num` int(11) NOT NULL DEFAULT '0' COMMENT '销量',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `create_time` int(11) DEFAULT NULL,
  `state` tinyint(1) DEFAULT '1' COMMENT '1.启用',
  `details` text COMMENT '商品详情',
  `unit` varchar(10) DEFAULT NULL COMMENT '单位',
  `weight` varchar(10) DEFAULT NULL COMMENT '重量',
  `update_time` int(11) DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '1' COMMENT '0.已删除',
  `postagerules_id` int(11) DEFAULT '0' COMMENT '运费模板id',
  `limit_buy` int(11) DEFAULT '0' COMMENT '每人限购数量',
  `num_type` tinyint(1) DEFAULT '1' COMMENT '1.下单减库存 2.兑换成功减库存',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分商品';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_integralorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `out_trade_no` varchar(60) DEFAULT NULL COMMENT '订单号',
  `transaction_id` varchar(60) DEFAULT NULL COMMENT '微信单号',
  `goods_id` int(11) DEFAULT NULL COMMENT '积分商品id',
  `spec_name` varchar(60) DEFAULT NULL COMMENT '规格名',
  `spec_value` varchar(60) DEFAULT NULL COMMENT '规格值',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额(包含运费)',
  `total_integral` int(11) NOT NULL DEFAULT '0' COMMENT '总兑换的积分',
  `total_num` int(11) NOT NULL DEFAULT '0' COMMENT '兑换数量',
  `sincetype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '配送方式 1快递 2到店自提',
  `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `name` varchar(60) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(60) DEFAULT NULL COMMENT '手机',
  `province` varchar(30) DEFAULT NULL COMMENT '省份',
  `city` varchar(30) DEFAULT NULL COMMENT '市',
  `area` varchar(30) DEFAULT NULL COMMENT '区县',
  `address` varchar(250) DEFAULT NULL COMMENT '收货地址 配送方式快递是使用',
  `remark` varchar(250) DEFAULT NULL COMMENT '留言',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1已支付',
  `dh_time` int(11) DEFAULT NULL COMMENT '积分兑换时间(下单时间)',
  `pay_time` int(11) DEFAULT NULL COMMENT '运费支付时间',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0未付款 1待发货  2待确认收货 3已完成',
  `fahuo_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `queren_time` int(11) DEFAULT NULL COMMENT '完成时间(确认收货时间)',
  `express_delivery` varchar(60) DEFAULT NULL COMMENT '快递',
  `express_orderformid` varchar(60) DEFAULT NULL COMMENT '快递单号',
  `prepay_id` varchar(100) DEFAULT NULL,
  `pay_type` tinyint(1) DEFAULT '0' COMMENT '1.微信支付 2.余额支付',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '0.删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分订单表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_integralrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL DEFAULT '1' COMMENT '商品id',
  `create_time` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT '0' COMMENT '积分',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `type` tinyint(1) DEFAULT NULL COMMENT '1.购买返积分 2.积分商城消费',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分记录表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_menu` (
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
) ENGINE=InnoDB AUTO_INCREMENT=777 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_menugroup` (
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
) ENGINE=InnoDB AUTO_INCREMENT=668 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_mercapdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL COMMENT '商家id',
  `store_name` varchar(100) DEFAULT NULL COMMENT '商家名称',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '方式 1 普通订单 2抢购 3优惠券 4分销(扣除)',
  `mcd_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现方式 1订单收入 2微信提现 3审核失败退款 4核销订单完成收入(之前兼容的) 5提现失败收入 6分销扣款',
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家资金明细';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_openvip` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(1) DEFAULT '1' COMMENT '1.购买会员 2.激活码激活',
  `create_time` int(11) DEFAULT NULL,
  `setid` int(11) DEFAULT NULL COMMENT '开卡的id',
  `day` int(11) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT '0.00',
  `out_trade_no` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `share_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL COMMENT '用户openid',
  `order_lid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单类别 1普通订单 2预约订单',
  `cid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '下单方式 0直接下单 1购物车下单',
  `order_no` varchar(60) DEFAULT NULL COMMENT '订单号',
  `out_trade_no` varchar(60) DEFAULT NULL,
  `transaction_id` varchar(60) DEFAULT NULL COMMENT '微信单号',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总费用(包含运费)',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额(实际支付金额)(扣去优惠券金额获取其他方式的优惠)',
  `goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总金额',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '商品总数量',
  `delivery_type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '配送方式 1送货上门(快递) 2到店消费',
  `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `user_coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用优惠券id',
  `coupon_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券优惠金额',
  `discount` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '会员折扣',
  `discount_total_goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '折扣后商品金额',
  `pay_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '支付方式 1微信支付 2余额支付',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1已支付 ',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `create_time` int(11) DEFAULT NULL,
  `express_delivery` varchar(60) DEFAULT NULL COMMENT '物流快递公司',
  `express_no` varchar(60) DEFAULT NULL COMMENT '快递单号',
  `send_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `confirm_time` int(11) DEFAULT NULL COMMENT '确认收货时间完成时间',
  `cancel_time` int(11) DEFAULT NULL COMMENT '订单取消时间',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态  10待支付 20待发货(待核销)  30待确认收货(待核销) 40待评价 60已完成  5取消订单 ',
  `refund_application_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款申请状态 1已申请退款',
  `refund_application_time` int(11) DEFAULT NULL COMMENT '退款申请时间',
  `review_status` tinyint(4) DEFAULT '0' COMMENT '退款审核状态 1审核通过 2审核失败',
  `review_time` int(11) DEFAULT NULL COMMENT '审核时间',
  `review_reason` text COMMENT '审核原因',
  `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款状态 0处理中 1退款成功 2退款失败(当order_status=5生效)',
  `refund_time` int(11) DEFAULT NULL COMMENT '退款时间',
  `refund_no` varchar(60) DEFAULT NULL COMMENT '退款订单号',
  `cancel_refund_time` int(11) DEFAULT NULL COMMENT '取消退款时间',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 0未删除 1 用户删除 2商家删除',
  `is_evaluation` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否评价 1已评价',
  `name` varchar(60) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(60) DEFAULT NULL COMMENT '手机',
  `province` varchar(30) DEFAULT NULL COMMENT '省',
  `city` varchar(30) DEFAULT NULL COMMENT '市',
  `district` varchar(60) DEFAULT NULL COMMENT '区',
  `town` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL COMMENT '详细地址',
  `postalcode` varchar(30) DEFAULT NULL COMMENT '邮编',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `prepay_id` varchar(60) DEFAULT NULL COMMENT '消息模板',
  `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1已删除',
  `del_time` int(11) DEFAULT NULL,
  `shipping_time` int(11) DEFAULT NULL,
  `finish_time` int(11) DEFAULT NULL,
  `distribution_money` decimal(15,2) DEFAULT '0.00' COMMENT '分佣总金额',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id(活动id)',
  `is_free` tinyint(4) DEFAULT '0' COMMENT '1会员免单',
  `free_num` int(11) NOT NULL DEFAULT '0' COMMENT '免费单数',
  `write_off_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '核销状态 0未核销 1部分核销 2全部核销',
  `write_off_num` int(11) NOT NULL DEFAULT '0' COMMENT '已核销数量',
  `write_off_time` int(11) DEFAULT '0',
  `after_sale` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否申请售后 1申请',
  `share_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '通过分享用户id下单',
  `tuikuanformid` varchar(60) DEFAULT NULL,
  `book_name` varchar(60) DEFAULT NULL,
  `book_phone` varchar(60) DEFAULT NULL,
  `book_time` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单信息';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_orderdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `user_id` int(11) DEFAULT NULL,
  `openid` varchar(60) NOT NULL COMMENT '用户openid',
  `gid` int(11) DEFAULT NULL COMMENT '商品id',
  `gname` varchar(60) DEFAULT NULL COMMENT '商品名称',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `attr_ids` varchar(250) DEFAULT NULL COMMENT '商品规格',
  `attr_list` varchar(250) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL COMMENT '图片',
  `create_time` int(11) DEFAULT NULL,
  `is_evaluation` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否评价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_orderrefund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
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
  `order_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单类型 1普通订单 2抢购订单 3拼团订单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退款记录表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_panic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT '0',
  `cat_id` int(11) DEFAULT '0' COMMENT '商品分类id',
  `name` varchar(100) DEFAULT NULL COMMENT '商品名称',
  `unit` varchar(10) DEFAULT '个' COMMENT '单位',
  `weight` double(10,2) DEFAULT '0.00' COMMENT '重量',
  `sort` int(11) DEFAULT '0' COMMENT '排序 从大到小',
  `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)',
  `pics` text COMMENT '商品轮播图',
  `panic_price` decimal(10,2) DEFAULT '0.00' COMMENT '抢购价',
  `original_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价展示使用',
  `details` text COMMENT '商品详细',
  `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)',
  `postagerules_id` decimal(11,2) DEFAULT NULL COMMENT '运费模板id',
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `is_stock` tinyint(1) DEFAULT '0',
  `sales_num` int(11) DEFAULT '0' COMMENT '销量 销量支付完成',
  `sales_num_virtual` int(11) DEFAULT '0' COMMENT '虚拟销量',
  `use_attr` int(4) DEFAULT '0' COMMENT '1使用规格',
  `attr` longtext COMMENT '规格库存和价格',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `state` int(4) DEFAULT '1' COMMENT '1启用状态',
  `is_recommend` int(4) DEFAULT '0' COMMENT '是否推荐',
  `check_status` int(4) DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `fail_reason` varchar(255) DEFAULT NULL,
  `single_limit_times` int(11) DEFAULT '1',
  `limit_num` int(11) DEFAULT '0' COMMENT '购买次数限制',
  `sendtype` varchar(100) DEFAULT '1' COMMENT '1.到店 2.物流',
  `only_vip` tinyint(1) DEFAULT '0' COMMENT '1.仅限vip',
  `vip_price` decimal(10,2) DEFAULT '0.00',
  `vip_free` tinyint(1) DEFAULT '0' COMMENT '1.会员免单',
  `free_num` int(11) DEFAULT '0' COMMENT '免单次数',
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `expire_time` int(11) DEFAULT NULL,
  `read_num` int(11) DEFAULT '0',
  `read_num_virtual` int(11) DEFAULT '0',
  `is_del` tinyint(1) DEFAULT '0',
  `cancel_order` int(11) DEFAULT '5',
  `allnum` int(11) DEFAULT '0' COMMENT '总份数',
  `is_support_refund` tinyint(1) DEFAULT '1' COMMENT '0.不支持退款',
  `is_activity` tinyint(1) DEFAULT '0' COMMENT '1.添加到活动列表',
  `indexpic` varchar(100) DEFAULT NULL,
  `is_ladder` tinyint(1) DEFAULT '0',
  `ladder_info` text,
  `distribution_open` tinyint(4) NOT NULL DEFAULT '0',
  `commissiontype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1百分比',
  `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额',
  `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额',
  `third_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级金额',
  `posterpic` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='抢购商品表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_panicattr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格名称',
  `goods_id` int(11) DEFAULT NULL,
  `goodsattrgroup_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_panicattrgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格分组名称',
  `goods_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格分组表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_panicattrsetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `key` varchar(250) DEFAULT NULL COMMENT '规格名称列表',
  `attr_ids` varchar(250) NOT NULL DEFAULT '' COMMENT '规格ids',
  `goods_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `vip_price` decimal(10,2) DEFAULT '0.00' COMMENT '会员价',
  `weight` double(10,2) DEFAULT '0.00' COMMENT '重量',
  `code` varchar(50) DEFAULT '' COMMENT '编码',
  `pic` varchar(255) DEFAULT '' COMMENT '封面图',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `panic_price` decimal(10,2) DEFAULT '0.00' COMMENT '抢购价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格设置表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_panicladder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `panic_num` int(11) DEFAULT NULL,
  `panic_price` decimal(10,2) DEFAULT NULL,
  `vip_price` decimal(10,2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='阶梯购';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_panicorder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `store_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `out_trade_no` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `attr_ids` varchar(255) DEFAULT NULL,
  `attr_list` varchar(255) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额（含运费）',
  `sincetype` tinyint(1) DEFAULT '1' COMMENT '配送方式 1到店  2.快递',
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
  `pay_type` tinyint(1) DEFAULT '0' COMMENT '1.微信支付 2.零钱支付',
  `pay_time` int(11) DEFAULT NULL,
  `write_off_status` tinyint(1) DEFAULT '0',
  `write_off_num` int(11) DEFAULT '0' COMMENT '核销份数',
  `write_off_time` int(11) DEFAULT NULL,
  `order_status` tinyint(1) DEFAULT '10',
  `prepay_id` varchar(200) DEFAULT NULL,
  `expire_time` int(11) DEFAULT '0' COMMENT '支付过期时间',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1.已删除(过期未支付)',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '0.删除（订单列表不显示）',
  `refund_status` tinyint(1) DEFAULT '0' COMMENT '2退款成功 3退款失败 4.拒绝退款',
  `refund_time` int(11) DEFAULT '0' COMMENT '退款时间',
  `refund_no` varchar(50) DEFAULT '0' COMMENT '退款单号',
  `update_time` int(11) DEFAULT NULL,
  `finish_time` int(11) DEFAULT '0' COMMENT '完成时间',
  `is_vip` tinyint(1) DEFAULT '0',
  `use_attr` tinyint(1) DEFAULT '0',
  `is_free` tinyint(1) DEFAULT '0' COMMENT '1免单',
  `after_sale` int(1) DEFAULT '0',
  `fail_reason` varchar(255) DEFAULT NULL COMMENT '拒绝退款原因',
  `err_code_dec` varchar(255) DEFAULT NULL,
  `share_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抢购订单表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_panicrefund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `refund_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款方式 1微信退款 2余额退款',
  `refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1仅退款',
  `refund_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `create_time` int(11) DEFAULT NULL,
  `refund_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '2退款成功 3退款失败 4.拒绝退款',
  `refund_time` int(11) DEFAULT NULL COMMENT '退款时间',
  `err_code` varchar(200) DEFAULT NULL COMMENT '退款失败错误码',
  `err_code_dec` varchar(200) DEFAULT NULL COMMENT '错误信息',
  `xml` text COMMENT '退款报文',
  `update_time` int(11) DEFAULT NULL,
  `fail_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退款记录表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_pingoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT '0',
  `cat_id` int(11) DEFAULT '0' COMMENT '商品分类id',
  `name` varchar(100) DEFAULT NULL COMMENT '商品名称',
  `unit` varchar(10) DEFAULT '个' COMMENT '单位',
  `weight` double(10,2) DEFAULT '0.00' COMMENT '重量',
  `sort` int(11) DEFAULT '0' COMMENT '排序 从大到小',
  `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)',
  `pics` text COMMENT '商品轮播图',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '单购价',
  `pin_price` decimal(10,2) DEFAULT '0.00' COMMENT '拼购价',
  `vip_price` decimal(10,2) DEFAULT '0.00',
  `alonepay_vip_price` decimal(10,2) DEFAULT '0.00' COMMENT '会员单购价',
  `original_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价展示使用',
  `details` text COMMENT '商品详细',
  `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)',
  `postagerules_id` decimal(11,2) DEFAULT NULL COMMENT '运费模板id',
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `sales_num` int(11) DEFAULT '0' COMMENT '销量 销量支付完成',
  `sales_num_virtual` int(11) DEFAULT '0' COMMENT '虚拟销量',
  `use_attr` int(4) DEFAULT '0' COMMENT '1使用规格',
  `attr` longtext COMMENT '规格库存和价格',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `expire_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `state` int(4) DEFAULT '1' COMMENT '1启用状态',
  `is_recommend` int(4) DEFAULT '0' COMMENT '是否推荐',
  `check_status` int(4) DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `fail_reason` varchar(255) DEFAULT NULL,
  `is_ladder` tinyint(1) DEFAULT '0' COMMENT '1开启阶梯团',
  `ladder_info` text,
  `limit_num` int(11) DEFAULT '0' COMMENT '单次购买数量',
  `limit_times` int(11) DEFAULT '0' COMMENT '购买次数限制',
  `group_num` int(11) DEFAULT '0' COMMENT '实际成团数',
  `group_num_virtual` int(11) DEFAULT '0' COMMENT '虚拟成团数',
  `sendtype` varchar(10) DEFAULT '1' COMMENT '1.到店 2.物流',
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
  `is_activity` tinyint(1) DEFAULT '0' COMMENT '1加入活动列表',
  `is_support_refund` tinyint(1) DEFAULT '0',
  `distribution_open` tinyint(4) NOT NULL DEFAULT '0',
  `commissiontype` tinyint(4) NOT NULL DEFAULT '1',
  `first_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `second_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `third_money` decimal(10,2) NOT NULL,
  `posterpic` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_pingoodsattr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格名称',
  `goods_id` int(11) DEFAULT NULL,
  `goodsattrgroup_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_pingoodsattrgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '规格分组名称',
  `goods_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格分组表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_pingoodsattrsetting` (
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
  `vip_price` decimal(10,2) DEFAULT '0.00',
  `alonepay_vip_price` decimal(10,2) DEFAULT '0.00' COMMENT '会员单购价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格设置表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_pinheads` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团长表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_pinladder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL,
  `groupnum` int(11) DEFAULT '2' COMMENT '组团人数',
  `groupmoney` decimal(10,2) DEFAULT '0.00' COMMENT '组团价格',
  `vip_groupmoney` decimal(10,2) DEFAULT '0.00',
  `create_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='阶梯团规则表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_pinorder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `store_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `out_trade_no` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `attr_ids` varchar(255) DEFAULT NULL,
  `attr_list` varchar(255) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额（含运费）',
  `sincetype` tinyint(1) DEFAULT '1' COMMENT '配送方式 1到店 ',
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
  `pay_type` tinyint(1) DEFAULT '0' COMMENT '1.微信支付 2.零钱支付',
  `pay_time` int(11) DEFAULT NULL,
  `write_off_status` tinyint(1) DEFAULT '0',
  `write_off_num` int(11) DEFAULT '0' COMMENT '核销份数',
  `write_off_time` int(11) DEFAULT NULL,
  `order_status` tinyint(1) DEFAULT '10',
  `prepay_id` varchar(200) DEFAULT NULL,
  `expire_time` int(11) DEFAULT '0' COMMENT '支付过期时间',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1.已删除(过期未支付)',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '0.删除（订单列表不显示）',
  `refund_status` tinyint(1) DEFAULT '0' COMMENT '2退款成功 3退款失败 4.拒绝退款',
  `refund_time` int(11) DEFAULT '0' COMMENT '退款时间',
  `refund_no` varchar(50) DEFAULT '0' COMMENT '退款单号',
  `update_time` int(11) DEFAULT NULL,
  `finish_time` int(11) DEFAULT '0' COMMENT '完成时间',
  `is_vip` tinyint(1) DEFAULT '0',
  `use_attr` tinyint(1) DEFAULT '0',
  `is_free` tinyint(1) DEFAULT '0' COMMENT '1免单',
  `after_sale` int(1) DEFAULT '0',
  `fail_reason` varchar(255) DEFAULT NULL COMMENT '拒绝退款原因',
  `err_code_dec` varchar(255) DEFAULT NULL,
  `is_head` tinyint(1) DEFAULT '0' COMMENT '1.团长',
  `coupon_money` decimal(10,2) DEFAULT '0.00' COMMENT '优惠金额',
  `heads_id` int(11) DEFAULT NULL,
  `group_time` int(11) DEFAULT NULL,
  `share_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享用户id',
  `send_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抢购订单表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_pinrefund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `heads_id` int(11) DEFAULT NULL,
  `refund_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款方式 1微信退款 2余额退款',
  `order_refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1仅退款',
  `refund_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `create_time` int(11) DEFAULT NULL,
  `refund_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.申请退款2退款成功 3退款失败 4.拒绝退款',
  `refund_time` tinyint(11) DEFAULT NULL COMMENT '退款时间',
  `err_code` varchar(200) DEFAULT NULL COMMENT '退款失败错误码',
  `err_code_dec` varchar(200) DEFAULT NULL COMMENT '错误信息',
  `xml` text COMMENT '退款报文',
  `update_time` int(11) DEFAULT NULL,
  `fail_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼团退款记录表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_postagerules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店 0为自营',
  `name` varchar(100) DEFAULT NULL COMMENT '规则名称',
  `detail` longtext NOT NULL COMMENT '规则详细',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '是否启用：0=否，1=是',
  `is_delete` smallint(1) NOT NULL DEFAULT '0',
  `type` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '计费方式【1=>按件计费、2=>按重计费】',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='运费规则';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_prints` (
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
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_printset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `prints_id` int(11) NOT NULL DEFAULT '0' COMMENT '打印机id',
  `print_type` varchar(60) NOT NULL DEFAULT '1' COMMENT '打印方式 1下单打印 2付款打印 3确认收货打印 1,2,3',
  `print_merch` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1多商户打印',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `recharge_lowest` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低充值金额',
  `details` text COMMENT '充值活动',
  `create_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值金额配置';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_rechargerecord` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '充值总金额（含赠送）',
  `send_money` decimal(10,2) DEFAULT '0.00' COMMENT '赠送金额',
  `out_trade_no` varchar(100) DEFAULT NULL COMMENT '订单号',
  `transaction_id` varchar(100) DEFAULT NULL COMMENT '支付号',
  `create_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `uniacid` int(11) DEFAULT NULL,
  `prepay_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值记录表';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(100) NOT NULL,
  `tpl_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_open` int(11) NOT NULL DEFAULT '2',
  `tid1` varchar(50) NOT NULL,
  `tid2` varchar(50) NOT NULL,
  `tid3` varchar(50) NOT NULL,
  `order_tplid` int(11) NOT NULL COMMENT '聚合-订单提醒id',
  `order_refund_tplid` int(11) NOT NULL COMMENT '聚合-订单退款提醒id',
  `smstype` tinyint(2) NOT NULL DEFAULT '1' COMMENT '短信类型，1为253，2为聚合',
  `ytx_apiaccount` varchar(50) NOT NULL COMMENT '253短信账号',
  `ytx_apipass` varchar(50) NOT NULL COMMENT '253短信密码',
  `ytx_apiurl` varchar(50) NOT NULL COMMENT '253短信地址',
  `ytx_order` varchar(255) NOT NULL COMMENT '云通信订单消息提醒',
  `ytx_orderrefund` varchar(255) NOT NULL COMMENT '云通信退款订单消息提醒',
  `tid4` varchar(50) DEFAULT NULL COMMENT '开奖模板',
  `aly_accesskeyid` varchar(255) NOT NULL COMMENT '阿里大鱼 accessKeyId',
  `aly_accesskeysecret` varchar(255) NOT NULL COMMENT '阿里大鱼 AccessKeySecret',
  `aly_order` varchar(255) NOT NULL COMMENT '阿里大鱼 订单模板',
  `aly_orderrefund` varchar(255) NOT NULL COMMENT '阿里大鱼 退款模板',
  `aly_sign` varchar(100) NOT NULL COMMENT '签名',
  `xiaoshentui` varchar(255) NOT NULL COMMENT '小神推',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '门店名称',
  `tel` varchar(60) DEFAULT '' COMMENT '商家电话',
  `phone` varchar(60) DEFAULT NULL COMMENT '通知电话',
  `address` varchar(200) DEFAULT NULL COMMENT '商家地址',
  `check_status` int(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `create_time` int(11) DEFAULT NULL,
  `rz_time` int(11) DEFAULT NULL COMMENT '当前入驻时间为审核通过的时间',
  `review_time` int(11) DEFAULT NULL COMMENT '审核时间',
  `coordinates` varchar(30) DEFAULT NULL COMMENT '经纬度',
  `lng` varchar(20) DEFAULT NULL COMMENT '经度',
  `lat` varchar(20) DEFAULT NULL COMMENT '纬度',
  `content` text COMMENT '详情',
  `pic` varchar(200) DEFAULT NULL COMMENT '封面图',
  `openid` varchar(30) DEFAULT NULL COMMENT '商家openid',
  `ptcc_rate` float(11,0) NOT NULL DEFAULT '0' COMMENT '平台抽成比例 1代表1%',
  `is_del` int(4) NOT NULL DEFAULT '0',
  `show_index` int(4) NOT NULL DEFAULT '0' COMMENT '首页推荐',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商家余额',
  `update_time` int(11) DEFAULT NULL,
  `pic_bg` varchar(200) DEFAULT NULL COMMENT '背景图',
  `wechat_number` varchar(60) DEFAULT '' COMMENT '微信号',
  `goods_count` int(11) DEFAULT '0' COMMENT '商品数量',
  `sale_count` int(11) DEFAULT '0' COMMENT '已售商品数量',
  `end_time` int(11) DEFAULT NULL COMMENT '过期时间',
  `details` text COMMENT '商铺描述-卖什么东西',
  `contact` varchar(60) DEFAULT '' COMMENT '联系人',
  `user_id` int(11) DEFAULT '0' COMMENT '申请人id',
  `fail_reason` varchar(255) DEFAULT NULL,
  `popularity` int(11) NOT NULL DEFAULT '0' COMMENT '人气值',
  `logo` varchar(255) DEFAULT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `district_id` int(11) NOT NULL DEFAULT '0' COMMENT '商圈id',
  `is_recommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐 1推荐 集市推荐显示',
  `business_range` varchar(100) DEFAULT NULL COMMENT '营业时间',
  `per_consumption` varchar(10) DEFAULT NULL COMMENT '人均消费',
  `storeopen_id` int(11) DEFAULT NULL COMMENT '开通申请入驻id',
  `sort` int(11) NOT NULL DEFAULT '0',
  `distribution_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启分销 1开启',
  `commissiontype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1百分比  2固定金额',
  `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额',
  `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额',
  `third_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级金额',
  `star` int(11) NOT NULL DEFAULT '1' COMMENT '星级',
  `service` varchar(255) DEFAULT NULL COMMENT '服务设施',
  `quality_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '品质商家',
  `icon` varchar(200) DEFAULT NULL COMMENT '首页菜单图标',
  `banner` text COMMENT '详情页banner',
  `posterpic` varchar(200) DEFAULT NULL COMMENT '海报图',
  `store_wechat` varchar(200) DEFAULT NULL COMMENT '商家微信图',
  `detail_qrcode` varchar(200) DEFAULT NULL COMMENT '详情二维码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='商家(门店)';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_storecategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级(上一级)分类id',
  `name` varchar(60) DEFAULT NULL COMMENT '名称',
  `icon` varchar(250) DEFAULT NULL COMMENT '分类图标',
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用状态',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 1删除',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='商户类别';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_storedistrict` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商圈';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_storeopen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1申请入驻 2续费',
  `order_no` varchar(60) DEFAULT NULL,
  `transaction_id` varchar(60) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `contact` varchar(30) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `pay_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1微信支付 2余额支付 3免费',
  `lng` varchar(20) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1支付',
  `pay_time` int(11) DEFAULT NULL,
  `reason` varchar(200) DEFAULT NULL COMMENT '失败原因',
  `review_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败',
  `refund_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '充值id',
  `day_num` int(11) NOT NULL DEFAULT '0' COMMENT '天数',
  `refund_apply_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款申请 审核失败 1退款申请',
  `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1退款成功 2退款失败',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='开通入驻';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_storerecharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `days` int(10) NOT NULL DEFAULT '0' COMMENT '天数',
  `price` decimal(15,2) DEFAULT NULL COMMENT '充值活动',
  `create_time` int(11) DEFAULT NULL,
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='充值金额配置';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_storeuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用',
  `store_id` int(11) DEFAULT '0' COMMENT '商家id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户用户';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_system` (
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
  `top_color` varchar(20) DEFAULT '#ffffff' COMMENT '平台顶部风格颜色',
  `bottom_color` varchar(20) DEFAULT '#ffffff' COMMENT '平台底部风格颜色',
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
  `map_key` varchar(60) DEFAULT NULL COMMENT '腾讯地图key',
  `ak` varchar(60) DEFAULT NULL COMMENT '百度地图key(天气)',
  `poster_goods` varchar(200) DEFAULT NULL COMMENT '商品海报',
  `show_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1功能 2圈子 3商家',
  `weather_icon` varchar(200) DEFAULT NULL COMMENT '天气图标',
  `showcheck` tinyint(4) NOT NULL DEFAULT '0' COMMENT '过审开关 1开启',
  `version` varchar(100) DEFAULT NULL,
  `mine_bg` varchar(200) DEFAULT NULL COMMENT '我的背景',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_task` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `tid1` varchar(50) DEFAULT NULL COMMENT '支付通知',
  `tid2` varchar(50) DEFAULT NULL COMMENT '订单取消',
  `tid3` varchar(50) DEFAULT NULL COMMENT '发货通知',
  `tid4` varchar(50) DEFAULT NULL COMMENT '退款通知',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='模板消息';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` varchar(100) DEFAULT NULL COMMENT 'openid',
  `avatar` varchar(200) DEFAULT NULL COMMENT '头像',
  `uniacid` int(11) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `nickname` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称',
  `birthday` varchar(40) DEFAULT NULL COMMENT '生日',
  `gender` int(1) DEFAULT '0' COMMENT '性别',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `create_time` int(20) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) DEFAULT NULL COMMENT '修改时间',
  `login_time` int(20) DEFAULT NULL,
  `login_ip` varchar(50) DEFAULT NULL,
  `integral` int(10) NOT NULL DEFAULT '0' COMMENT '总积分',
  `now_integral` int(11) DEFAULT '0' COMMENT '现有积分',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户充值余额',
  `is_member` int(4) DEFAULT '0',
  `total_consume` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计消费金额',
  `memberconf_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级id',
  `discount` decimal(10,1) DEFAULT '0.0' COMMENT '开启vip会员折扣',
  `share_user_id` int(11) DEFAULT '0' COMMENT '分享人id',
  `last_share_user_id` int(11) DEFAULT NULL,
  `first_share_user_id` int(11) DEFAULT NULL COMMENT '最早推荐人id',
  `vip_cardnum` varchar(20) DEFAULT NULL,
  `vip_endtime` int(11) DEFAULT NULL,
  `parents_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销上级id',
  `parents_name` varchar(60) DEFAULT NULL COMMENT '分销上级名称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=897 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_userbalancerecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `sign` tinyint(4) DEFAULT NULL COMMENT '1充值 2支付',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注：商品名称、充值内容之类',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额（充值含赠送）',
  `send_money` decimal(10,2) DEFAULT '0.00' COMMENT '充值赠送的金额',
  `now_balance` decimal(10,2) DEFAULT '0.00' COMMENT '当前余额',
  `title` varchar(100) DEFAULT NULL COMMENT '名称',
  `create_time` int(11) DEFAULT NULL,
  `order_id` int(60) DEFAULT NULL COMMENT '订单id',
  `order_num` varchar(200) DEFAULT NULL COMMENT '订单号',
  `order_sign` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单标识 1普通订单 2合并订单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='余额变动记录';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_userprivilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '255',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员特权';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_vipcard` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_vipcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL DEFAULT '',
  `isuse` tinyint(1) DEFAULT '0',
  `usetime` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `state` int(1) DEFAULT '1',
  `user_id` int(11) DEFAULT '0' COMMENT '使用人',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_withdraw` (
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
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_withdrawbaowen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 商家提现报文信息记录 1合伙人提现报文记录',
  `openid` varchar(30) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `baowen` text,
  `wd_id` int(11) DEFAULT NULL COMMENT '提现id',
  `add_time` int(11) DEFAULT NULL,
  `request_data` text COMMENT '请求数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现报文';
CREATE TABLE IF NOT EXISTS `ims_yztc_sun_withdrawset` (
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
";
pdo_run($sql);
if(!pdo_fieldexists("yztc_sun_accessrecord", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_accessrecord")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_accessrecord", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_accessrecord")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_accessrecord", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_accessrecord")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_accessrecord", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_accessrecord")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_accessrecord", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_accessrecord")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_acode", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_acode")." ADD   `id` int(11) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_acode", "code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_acode")." ADD   `code` text COMMENT '随机码';");
}
if(!pdo_fieldexists("yztc_sun_acode", "time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_acode")." ADD   `time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_activity", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `type` int(5) DEFAULT '1' COMMENT '1.普通商品 2.抢购 3.优惠券';");
}
if(!pdo_fieldexists("yztc_sun_activity", "cat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `cat_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `name` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "start_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `start_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `end_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "original_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `original_price` decimal(10,2) DEFAULT NULL COMMENT '原价';");
}
if(!pdo_fieldexists("yztc_sun_activity", "sale_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `sale_price` decimal(10,2) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `vip_price` decimal(10,2) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `pic` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_activity", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `check_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '审核状态 1未审核 2审核通过 3审核失败';");
}
if(!pdo_fieldexists("yztc_sun_activity", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.启用';");
}
if(!pdo_fieldexists("yztc_sun_activity", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_activity")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_ad", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_ad", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_ad", "title")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `title` varchar(100) DEFAULT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("yztc_sun_ad", "url")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `url` varchar(200) DEFAULT NULL COMMENT '链接';");
}
if(!pdo_fieldexists("yztc_sun_ad", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '图片';");
}
if(!pdo_fieldexists("yztc_sun_ad", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `sort` int(4) NOT NULL DEFAULT '1' COMMENT '排序';");
}
if(!pdo_fieldexists("yztc_sun_ad", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_ad", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_ad", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `type` int(4) DEFAULT NULL COMMENT '广告类型：1、首页轮播图，2、首页中部广告 3抢购轮播图 4集市轮播图';");
}
if(!pdo_fieldexists("yztc_sun_ad", "memo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `memo` varchar(255) DEFAULT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("yztc_sun_ad", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用';");
}
if(!pdo_fieldexists("yztc_sun_ad", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `store_id` int(11) DEFAULT '0' COMMENT '商家id';");
}
if(!pdo_fieldexists("yztc_sun_ad", "link_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `link_type` int(1) DEFAULT '1' COMMENT '1.内链 2.外部小程序 3.客服消息';");
}
if(!pdo_fieldexists("yztc_sun_ad", "appid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `appid` varchar(100) DEFAULT NULL COMMENT '外部小程序APPID';");
}
if(!pdo_fieldexists("yztc_sun_ad", "path")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_ad")." ADD   `path` varchar(200) DEFAULT NULL COMMENT '外部小程序链接地址';");
}
if(!pdo_fieldexists("yztc_sun_admin", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq';");
}
if(!pdo_fieldexists("yztc_sun_admin", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_admin", "img")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `img` varchar(200) DEFAULT NULL COMMENT '头像';");
}
if(!pdo_fieldexists("yztc_sun_admin", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称';");
}
if(!pdo_fieldexists("yztc_sun_admin", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `create_time` int(20) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("yztc_sun_admin", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `update_time` int(20) DEFAULT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists("yztc_sun_admin", "login_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `login_time` int(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_admin", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `store_id` int(11) DEFAULT '0' COMMENT '门店id';");
}
if(!pdo_fieldexists("yztc_sun_admin", "code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `code` varchar(100) DEFAULT NULL COMMENT '账号';");
}
if(!pdo_fieldexists("yztc_sun_admin", "password")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `password` varchar(100) DEFAULT NULL COMMENT '密码';");
}
if(!pdo_fieldexists("yztc_sun_admin", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   `state` int(4) DEFAULT '0' COMMENT '状态：1启用 0禁用';");
}
if(!pdo_fieldexists("yztc_sun_admin", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_admin")." ADD   UNIQUE KEY `id` (`id`) USING BTREE;");
}
if(!pdo_fieldexists("yztc_sun_announcement", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_announcement")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_announcement", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_announcement")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_announcement", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_announcement")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_announcement", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_announcement")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1首页公告';");
}
if(!pdo_fieldexists("yztc_sun_announcement", "title")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_announcement")." ADD   `title` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_announcement", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_announcement")." ADD   `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '启用状态1启用';");
}
if(!pdo_fieldexists("yztc_sun_announcement", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_announcement")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_announcement", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_announcement")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_baowen", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_baowen")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_baowen", "xml")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_baowen")." ADD   `xml` text;");
}
if(!pdo_fieldexists("yztc_sun_baowen", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_baowen")." ADD   `out_trade_no` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_baowen", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_baowen")." ADD   `transaction_id` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_baowen", "add_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_baowen")." ADD   `add_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_baowen", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_baowen")." ADD   KEY `out_trade_no` (`out_trade_no`) USING BTREE;");
}
if(!pdo_fieldexists("yztc_sun_browserecord", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_browserecord")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_browserecord", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_browserecord")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_browserecord", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_browserecord")." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1商品浏览记录';");
}
if(!pdo_fieldexists("yztc_sun_browserecord", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_browserecord")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_browserecord", "gid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_browserecord")." ADD   `gid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_browserecord", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_browserecord")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_browserecord", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_browserecord")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_category", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_category", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_category", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_category", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类别类型 1正常商品分类 2快速购买类别';");
}
if(!pdo_fieldexists("yztc_sun_category", "parent_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级(上一级)分类id';");
}
if(!pdo_fieldexists("yztc_sun_category", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `name` varchar(60) DEFAULT NULL COMMENT '名称';");
}
if(!pdo_fieldexists("yztc_sun_category", "icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `icon` varchar(250) DEFAULT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("yztc_sun_category", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用状态';");
}
if(!pdo_fieldexists("yztc_sun_category", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 1删除';");
}
if(!pdo_fieldexists("yztc_sun_category", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_category", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_category", "delete_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `delete_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_category", "index")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `index` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_category", "is_hot")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `is_hot` int(4) NOT NULL DEFAULT '0' COMMENT '是否推荐';");
}
if(!pdo_fieldexists("yztc_sun_category", "level")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_category")." ADD   `level` int(4) DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_city", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_city")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_city", "parent_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_city")." ADD   `parent_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_city", "citycode")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_city")." ADD   `citycode` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_city", "adcode")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_city")." ADD   `adcode` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_city", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_city")." ADD   `name` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_city", "lng")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_city")." ADD   `lng` varchar(255) NOT NULL COMMENT '经度';");
}
if(!pdo_fieldexists("yztc_sun_city", "lat")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_city")." ADD   `lat` varchar(255) NOT NULL COMMENT '纬度';");
}
if(!pdo_fieldexists("yztc_sun_city", "level")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_city")." ADD   `level` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_collection", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_collection")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_collection", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_collection")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_collection", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_collection")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_collection", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_collection")." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '收藏类型 1门店';");
}
if(!pdo_fieldexists("yztc_sun_collection", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_collection")." ADD   `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店id type=1使用';");
}
if(!pdo_fieldexists("yztc_sun_collection", "is_collection")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_collection")." ADD   `is_collection` tinyint(4) NOT NULL DEFAULT '1' COMMENT '收藏状态 1收藏 0取消收藏';");
}
if(!pdo_fieldexists("yztc_sun_collection", "collect_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_collection")." ADD   `collect_time` int(11) DEFAULT NULL COMMENT '收藏时间';");
}
if(!pdo_fieldexists("yztc_sun_collection", "cancel_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_collection")." ADD   `cancel_time` int(11) DEFAULT NULL COMMENT '取消时间';");
}
if(!pdo_fieldexists("yztc_sun_collection", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_collection")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_comment", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_comment", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_comment", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `user_id` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_comment", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `order_id` int(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_comment", "order_detail_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `order_detail_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_comment", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_comment", "stars")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `stars` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_comment", "imgs")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `imgs` text;");
}
if(!pdo_fieldexists("yztc_sun_comment", "content")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `content` text;");
}
if(!pdo_fieldexists("yztc_sun_comment", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_comment", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `type` tinyint(1) DEFAULT '1' COMMENT '1.普通商品 2.抢购';");
}
if(!pdo_fieldexists("yztc_sun_comment", "anonymous")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_comment")." ADD   `anonymous` tinyint(1) DEFAULT '0' COMMENT '1.匿名';");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "order_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `order_no` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `num` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "order_amount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单总额';");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `type` int(5) DEFAULT '1' COMMENT '1.普通商品 2.抢购 3.优惠券 4.拼团';");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `goods_id` int(11) DEFAULT '0' COMMENT '对应商品id';");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `order_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "order_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `order_status` int(11) DEFAULT '10' COMMENT '50申请售后 51 已退款 52 退款失败 53 拒绝退款 ';");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_commonorder", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_commonorder")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_config", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_config")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_config", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_config")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_config", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_config")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_config", "key")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_config")." ADD   `key` varchar(50) DEFAULT NULL COMMENT '关键字';");
}
if(!pdo_fieldexists("yztc_sun_config", "value")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_config")." ADD   `value` text COMMENT '值';");
}
if(!pdo_fieldexists("yztc_sun_config", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_config")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_config", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_config")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `pic` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "full")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `full` varchar(10) COLLATE utf8mb4_bin DEFAULT '0' COMMENT '满多少可用';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "day")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `day` int(11) DEFAULT '0' COMMENT '领取后几天过期';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '到期时间';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "gettype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `gettype` tinyint(1) DEFAULT '1' COMMENT '1.付费领取 2.转发领取 3.免费领取';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "getmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `getmoney` decimal(10,2) DEFAULT '0.00' COMMENT '领取金额';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `num` int(11) DEFAULT '0' COMMENT '0.不限量';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "sales_num_virtua")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `sales_num_virtua` int(11) DEFAULT '0' COMMENT '虚拟领取数';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "sales_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `sales_num` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "instructions")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `instructions` text COLLATE utf8mb4_bin COMMENT '使用说明';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "is_recommend")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `is_recommend` tinyint(1) DEFAULT '0' COMMENT '1.推荐';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `state` tinyint(1) DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "lng")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `lng` varchar(10) COLLATE utf8mb4_bin DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "lat")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `lat` varchar(10) COLLATE utf8mb4_bin DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "pics")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `pics` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '轮播图';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "read_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `read_num` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "read_num_virtual")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `read_num_virtual` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "only_vip")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `only_vip` tinyint(1) DEFAULT '0' COMMENT '1.仅会员使用';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "use_starttime")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `use_starttime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "use_startday")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `use_startday` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "limit_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `limit_num` int(11) DEFAULT '0' COMMENT '每人限领';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `is_del` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "show_index")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `show_index` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "is_activity")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `is_activity` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `check_status` int(11) DEFAULT '2' COMMENT '1.未审核';");
}
if(!pdo_fieldexists("yztc_sun_coupon", "indexpic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `indexpic` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "posterpic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `posterpic` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_coupon", "original_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_coupon")." ADD   `original_price` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_couponget", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "cid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `cid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "order_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `order_no` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "gettype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `gettype` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `money` decimal(10,2) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "write_off_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `write_off_status` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_couponget", "write_off_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `write_off_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `out_trade_no` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `transaction_id` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `end_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "help_uid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `help_uid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "prepay_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `prepay_id` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_couponget", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_couponget")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_customize", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_customize", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_customize", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_customize", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2菜单图标 3底部图标 4分类信息 5商家';");
}
if(!pdo_fieldexists("yztc_sun_customize", "title")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `title` varchar(255) DEFAULT NULL COMMENT '标题名称';");
}
if(!pdo_fieldexists("yztc_sun_customize", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '图标图片';");
}
if(!pdo_fieldexists("yztc_sun_customize", "clickago_icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `clickago_icon` varchar(200) DEFAULT NULL COMMENT '点击前图标';");
}
if(!pdo_fieldexists("yztc_sun_customize", "clickafter_icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `clickafter_icon` varchar(200) DEFAULT NULL COMMENT '点击后图标';");
}
if(!pdo_fieldexists("yztc_sun_customize", "link_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `link_type` tinyint(1) DEFAULT '1' COMMENT '1.内链 2.外部小程序 3.客服消息 4同城分类信息';");
}
if(!pdo_fieldexists("yztc_sun_customize", "url_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `url_type` tinyint(4) DEFAULT NULL COMMENT '链接类型 1基本 2商品分类';");
}
if(!pdo_fieldexists("yztc_sun_customize", "url")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `url` varchar(200) DEFAULT NULL COMMENT '链接地址';");
}
if(!pdo_fieldexists("yztc_sun_customize", "url_typeid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `url_typeid` int(11) DEFAULT '0' COMMENT '链接带参数';");
}
if(!pdo_fieldexists("yztc_sun_customize", "url_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `url_name` varchar(50) DEFAULT NULL COMMENT '链接名称';");
}
if(!pdo_fieldexists("yztc_sun_customize", "appid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `appid` varchar(100) DEFAULT NULL COMMENT '外部小程序APPID';");
}
if(!pdo_fieldexists("yztc_sun_customize", "path")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `path` varchar(200) DEFAULT NULL COMMENT '外部小程序链接地址';");
}
if(!pdo_fieldexists("yztc_sun_customize", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `sort` int(5) NOT NULL DEFAULT '0' COMMENT '排序 越大越前';");
}
if(!pdo_fieldexists("yztc_sun_customize", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用';");
}
if(!pdo_fieldexists("yztc_sun_customize", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_customize")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_dingtalk", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_dingtalk")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_dingtalk", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_dingtalk")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_dingtalk", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_dingtalk")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_dingtalk", "token")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_dingtalk")." ADD   `token` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_dingtalk", "is_open")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_dingtalk")." ADD   `is_open` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_dingtalk", "content")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_dingtalk")." ADD   `content` varchar(255) DEFAULT NULL COMMENT '下订单提醒';");
}
if(!pdo_fieldexists("yztc_sun_dingtalk", "contentrefund")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_dingtalk")." ADD   `contentrefund` varchar(255) DEFAULT NULL COMMENT '退款申请提醒';");
}
if(!pdo_fieldexists("yztc_sun_dingtalk", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_dingtalk")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_dingtalk", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_dingtalk")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `user_id` int(11) DEFAULT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "promoter_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `promoter_id` int(11) DEFAULT NULL COMMENT '合伙人(分销商)id';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '方式 1普通商品 2抢购商品 3拼团商品 4会员卡 5提现';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "mcd_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `mcd_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现方式 1分销订单收入 2微信提现 3审核失败退款 5提现失败收入';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `openid` varchar(30) DEFAULT NULL COMMENT '订单收入支付的openid|提现给的openid';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "sign")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "mcd_memo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `mcd_memo` text COMMENT '相关详细信息';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '全额 订单收入全额 提现全额';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "realmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "paycommission")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现支付给平台佣金';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "ratesmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `order_id` int(11) DEFAULT NULL COMMENT '订单收入id';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "wd_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `wd_id` int(11) DEFAULT NULL COMMENT '提现id';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1成功 2失败 提现可能会失败';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "now_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `now_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前余额(处理后获取的当前余额)';");
}
if(!pdo_fieldexists("yztc_sun_distributionmercapdetails", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionmercapdetails")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单类别 1普通商品 2抢购商品 3拼团商品 4会员卡';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `user_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `order_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "parents_id_1")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `parents_id_1` int(11) NOT NULL DEFAULT '0' COMMENT '一级id';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "parents_id_2")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `parents_id_2` int(11) NOT NULL DEFAULT '0' COMMENT '二级id';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "parents_id_3")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `parents_id_3` int(11) NOT NULL DEFAULT '0' COMMENT '三级id';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "first_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "second_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "third_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "rebate")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `rebate` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否自购';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `is_del` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "settle_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `settle_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '结算状态 1已结算';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "finish_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `finish_time` int(11) DEFAULT NULL COMMENT '核销完成时间';");
}
if(!pdo_fieldexists("yztc_sun_distributionorder", "settle_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionorder")." ADD   `settle_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '结算方式 1平台 2商家';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "condition_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `condition_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成为分销商方式 1无条件 2申请 3消费金额（设置消费金额达到多少）、4购买商品（选择商品）、5成为会员';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `name` varchar(30) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `phone` varchar(30) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "allcommission")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `allcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计佣金';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "canwithdraw")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `canwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现佣金';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "freezemoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现冻结金额';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "referrer_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `referrer_name` varchar(60) DEFAULT NULL COMMENT '推荐人';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "referrer_uid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `referrer_uid` int(11) DEFAULT NULL COMMENT '推荐人id';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `check_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1未审核 2审核通过 3审核失败';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "check_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `check_time` int(11) DEFAULT NULL COMMENT '审核时间';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `fail_reason` varchar(200) DEFAULT NULL COMMENT '审核失败原因';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "form_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `form_id` varchar(50) DEFAULT NULL COMMENT '模板消息';");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionpromoter", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionpromoter")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "level")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分销层级 0不开启 1一级 2二级 3三级';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "inapp_buy")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `inapp_buy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分销内购 1开启';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "lower_condition")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `lower_condition` tinyint(4) NOT NULL DEFAULT '1' COMMENT '成为下线条件 1首次点击分销链接 2首次购买(付款)';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "distribution_condition")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `distribution_condition` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成为分销商条件 1无条件 2申请 3消费金额（设置消费金额达到多少）、4购买商品（选择商品）、5成为会员';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "consumption_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `consumption_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额 当distribution_condition=3生效';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "first_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `first_name` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "second_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `second_name` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "third_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `third_name` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "is_check")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `is_check` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否需要审核 1需要 0不需要';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "store_setting")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `store_setting` tinyint(4) NOT NULL DEFAULT '0' COMMENT '商家是否可设置分销 1该商家总体佣金和单商品佣金 0平台';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "withhold")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `withhold` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分销佣金扣款 1平台 2商家';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "join_module")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `join_module` varchar(100) NOT NULL DEFAULT '1,2,3,4' COMMENT '参与分销模块 中间用逗号隔开 1普通商品 2抢购商品 3拼团商品 4会员卡';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "withdraw_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `withdraw_type` varchar(100) NOT NULL DEFAULT '1' COMMENT '提现方式 1微信 2支付宝 3银行卡 4余额 中间用逗号隔开';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "min_withdraw")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `min_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "withdraw_fee")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `withdraw_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "daymax_withdraw")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `daymax_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "pass_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `pass_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额(多少以内免审）';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "user_notice")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `user_notice` text COMMENT '用户协议';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "withdraw_notice")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `withdraw_notice` text COMMENT '提现须知';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "application")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `application` text COMMENT '申请协议';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "commissiontype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `commissiontype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分销佣金类型 1百分比 2固定金额';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "first_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "second_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "third_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `third_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级金额';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "banner")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `banner` varchar(200) DEFAULT NULL COMMENT 'banner';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "exclusive_rights")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `exclusive_rights` text COMMENT '专属权利';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "poster_title")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `poster_title` varchar(60) DEFAULT NULL COMMENT '海报标题';");
}
if(!pdo_fieldexists("yztc_sun_distributionset", "poster_pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionset")." ADD   `poster_pic` varchar(200) DEFAULT NULL COMMENT '海报图片';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "promoter_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `promoter_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `openid` varchar(100) DEFAULT NULL COMMENT '提现openid';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现全额';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "wd_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `wd_type` tinyint(4) DEFAULT NULL COMMENT '提现方式 1微信';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "wd_account")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `wd_account` varchar(100) DEFAULT NULL COMMENT '提现账号';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "wd_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `wd_name` varchar(255) DEFAULT NULL COMMENT '提现姓名';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "wd_phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `wd_phone` varchar(255) DEFAULT NULL COMMENT '提现手机号';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提现状态 1成功 2失败';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "realmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "paycommission")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "ratesmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "baowen")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `baowen` text COMMENT '提现报文';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "is_state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `is_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0不需要审核 1需要审核';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "err_code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `err_code` varchar(50) DEFAULT NULL COMMENT '提现错误码';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "err_code_des")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `err_code_des` varchar(200) DEFAULT NULL COMMENT '失败原因';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "tx_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `tx_time` int(11) DEFAULT NULL COMMENT '提现时间';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "request_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `request_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "review_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `review_time` int(11) DEFAULT NULL COMMENT '审核时间';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "return_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `return_status` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "return_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `return_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_distributionwithdraw", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_distributionwithdraw")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_district", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_district")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_district", "parent_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_district")." ADD   `parent_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_district", "citycode")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_district")." ADD   `citycode` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_district", "adcode")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_district")." ADD   `adcode` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_district", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_district")." ADD   `name` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_district", "lng")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_district")." ADD   `lng` varchar(255) NOT NULL COMMENT '经度';");
}
if(!pdo_fieldexists("yztc_sun_district", "lat")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_district")." ADD   `lat` varchar(255) NOT NULL COMMENT '纬度';");
}
if(!pdo_fieldexists("yztc_sun_district", "level")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_district")." ADD   `level` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_formid", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_formid")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_formid", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_formid")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_formid", "form_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_formid")." ADD   `form_id` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_formid", "time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_formid")." ADD   `time` int(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_formid", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_formid")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `store_id` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "cat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `cat_id` int(11) DEFAULT '0' COMMENT '商品分类id';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '商品名称';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "unit")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `unit` varchar(10) DEFAULT '个' COMMENT '单位';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "weight")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `weight` double(10,2) DEFAULT '0.00' COMMENT '重量';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序 从大到小';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "pics")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `pics` text COMMENT '商品轮播图';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "sales_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `sales_price` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "original_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `original_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价展示使用';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "details")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `details` text COMMENT '商品详细';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "service")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "postagerules_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `postagerules_id` int(11) DEFAULT NULL COMMENT '运费模板id';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "sales_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `sales_num` int(11) DEFAULT '0' COMMENT '销量 销量支付完成';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "sales_num_virtual")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `sales_num_virtual` int(11) DEFAULT '0' COMMENT '虚拟销量';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `update_time` int(11) DEFAULT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `state` int(4) DEFAULT '1' COMMENT '1启用状态';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "is_recommend")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `is_recommend` int(4) DEFAULT '0' COMMENT '是否推荐';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `check_status` int(4) DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `fail_reason` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "sendtype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `sendtype` tinyint(1) DEFAULT '1' COMMENT '1.到店 2.物流';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "only_vip")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `only_vip` tinyint(1) DEFAULT '0' COMMENT '1.仅限vip';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "start_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `start_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `end_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "lottery_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `lottery_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "expire_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `expire_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "read_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `read_num` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "read_num_virtual")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `read_num_virtual` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `is_del` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "allnum")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `allnum` int(11) DEFAULT '0' COMMENT '总份数';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "is_activity")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `is_activity` tinyint(1) DEFAULT '0' COMMENT '1.添加到活动列表';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "indexpic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `indexpic` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "share_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `share_num` int(11) DEFAULT '0' COMMENT '转发获得抽奖码次数';");
}
if(!pdo_fieldexists("yztc_sun_freesheet", "auto_lottery")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheet")." ADD   `auto_lottery` int(1) DEFAULT '1' COMMENT '1.自动开奖 2.手动 ';");
}
if(!pdo_fieldexists("yztc_sun_freesheetcode", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetcode")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_freesheetcode", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetcode")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetcode", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetcode")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetcode", "lottery_code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetcode")." ADD   `lottery_code` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetcode", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetcode")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetcode", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetcode")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetcode", "lottery_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetcode")." ADD   `lottery_status` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_freesheetcode", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetcode")." ADD   `order_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetcode", "help_uid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetcode")." ADD   `help_uid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `out_trade_no` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `transaction_id` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "lottery_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `lottery_status` tinyint(1) DEFAULT '0' COMMENT '0.未开奖 1.为中奖 2.已中奖';");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "write_off_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `write_off_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "order_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `order_no` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "tel")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `tel` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_freesheetorder", "remark")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_freesheetorder")." ADD   `remark` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goods", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_goods", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goods", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_goods", "goods_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `goods_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商品营销类别 1普通商品 2预约商品';");
}
if(!pdo_fieldexists("yztc_sun_goods", "cat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类id';");
}
if(!pdo_fieldexists("yztc_sun_goods", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '商品名称';");
}
if(!pdo_fieldexists("yztc_sun_goods", "unit")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `unit` varchar(10) NOT NULL DEFAULT '个' COMMENT '单位';");
}
if(!pdo_fieldexists("yztc_sun_goods", "weight")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `weight` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '重量';");
}
if(!pdo_fieldexists("yztc_sun_goods", "index")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `index` int(11) NOT NULL DEFAULT '0' COMMENT '排序 从大到小';");
}
if(!pdo_fieldexists("yztc_sun_goods", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)';");
}
if(!pdo_fieldexists("yztc_sun_goods", "indexpic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `indexpic` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goods", "pics")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `pics` text COMMENT '商品轮播图';");
}
if(!pdo_fieldexists("yztc_sun_goods", "price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价';");
}
if(!pdo_fieldexists("yztc_sun_goods", "vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `vip_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员价';");
}
if(!pdo_fieldexists("yztc_sun_goods", "cost_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本价';");
}
if(!pdo_fieldexists("yztc_sun_goods", "original_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `original_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品原价展示使用';");
}
if(!pdo_fieldexists("yztc_sun_goods", "is_quick")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `is_quick` int(4) NOT NULL DEFAULT '0' COMMENT '1添加到快速购买';");
}
if(!pdo_fieldexists("yztc_sun_goods", "details")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `details` text NOT NULL COMMENT '商品详细';");
}
if(!pdo_fieldexists("yztc_sun_goods", "service")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)';");
}
if(!pdo_fieldexists("yztc_sun_goods", "postagerules_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `postagerules_id` int(11) DEFAULT NULL COMMENT '运费模板id';");
}
if(!pdo_fieldexists("yztc_sun_goods", "stock")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存';");
}
if(!pdo_fieldexists("yztc_sun_goods", "sales_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `sales_num` int(11) NOT NULL DEFAULT '0' COMMENT '销量 销量支付完成';");
}
if(!pdo_fieldexists("yztc_sun_goods", "sales_num_virtual")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `sales_num_virtual` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟销量';");
}
if(!pdo_fieldexists("yztc_sun_goods", "use_attr")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `use_attr` int(4) NOT NULL DEFAULT '0' COMMENT '1使用规格';");
}
if(!pdo_fieldexists("yztc_sun_goods", "attr")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `attr` longtext COMMENT '规格库存和价格';");
}
if(!pdo_fieldexists("yztc_sun_goods", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("yztc_sun_goods", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `update_time` int(11) NOT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists("yztc_sun_goods", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用状态';");
}
if(!pdo_fieldexists("yztc_sun_goods", "is_recommend")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `is_recommend` int(4) NOT NULL DEFAULT '0' COMMENT '是否推荐';");
}
if(!pdo_fieldexists("yztc_sun_goods", "platform_cat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `platform_cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '平台商品分类id';");
}
if(!pdo_fieldexists("yztc_sun_goods", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `check_status` int(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败';");
}
if(!pdo_fieldexists("yztc_sun_goods", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `fail_reason` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goods", "only_vip")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `only_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '仅限会员购买 1';");
}
if(!pdo_fieldexists("yztc_sun_goods", "only_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `only_num` int(11) NOT NULL DEFAULT '0' COMMENT '会员免费几单';");
}
if(!pdo_fieldexists("yztc_sun_goods", "common_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `common_num` int(11) NOT NULL DEFAULT '0' COMMENT '普通用户免费几单';");
}
if(!pdo_fieldexists("yztc_sun_goods", "limit_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '限购单数';");
}
if(!pdo_fieldexists("yztc_sun_goods", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `end_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goods", "expir_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `expir_time` int(11) DEFAULT NULL COMMENT '核销过期时间';");
}
if(!pdo_fieldexists("yztc_sun_goods", "is_support_refund")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `is_support_refund` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否支持退款  0不支持 1支持';");
}
if(!pdo_fieldexists("yztc_sun_goods", "is_activity")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `is_activity` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否添加到活动列表';");
}
if(!pdo_fieldexists("yztc_sun_goods", "expire_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `expire_time` int(11) DEFAULT '0' COMMENT '最后核销时间';");
}
if(!pdo_fieldexists("yztc_sun_goods", "distribution_open")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `distribution_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启单独分销';");
}
if(!pdo_fieldexists("yztc_sun_goods", "commissiontype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `commissiontype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1百分比';");
}
if(!pdo_fieldexists("yztc_sun_goods", "first_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额';");
}
if(!pdo_fieldexists("yztc_sun_goods", "second_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额';");
}
if(!pdo_fieldexists("yztc_sun_goods", "third_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `third_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级金额';");
}
if(!pdo_fieldexists("yztc_sun_goods", "posterpic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goods")." ADD   `posterpic` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattr", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattr")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_goodsattr", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattr")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattr", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattr")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '规格名称';");
}
if(!pdo_fieldexists("yztc_sun_goodsattr", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattr")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattr", "goodsattrgroup_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattr")." ADD   `goodsattrgroup_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattr", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattr")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattr", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattr")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrgroup", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrgroup")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrgroup", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrgroup")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrgroup", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrgroup")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '规格分组名称';");
}
if(!pdo_fieldexists("yztc_sun_goodsattrgroup", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrgroup")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrgroup", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrgroup")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrgroup", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrgroup")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "key")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `key` varchar(250) DEFAULT NULL COMMENT '规格名称列表';");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "attr_ids")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `attr_ids` varchar(250) NOT NULL DEFAULT '' COMMENT '规格ids';");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "stock")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `stock` int(11) DEFAULT '0' COMMENT '库存';");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价';");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `vip_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员价';");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "weight")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `weight` double(10,2) DEFAULT '0.00' COMMENT '重量';");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `code` varchar(50) DEFAULT '' COMMENT '编码';");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `pic` varchar(255) DEFAULT '' COMMENT '封面图';");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_goodsattrsetting", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_goodsattrsetting")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_info", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "topcat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `topcat_id` int(11) DEFAULT NULL COMMENT '最顶级分类id';");
}
if(!pdo_fieldexists("yztc_sun_info", "cat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `cat_id` int(11) DEFAULT NULL COMMENT '分类id';");
}
if(!pdo_fieldexists("yztc_sun_info", "content")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `content` text COMMENT '内容';");
}
if(!pdo_fieldexists("yztc_sun_info", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `pic` text COMMENT '发布图片';");
}
if(!pdo_fieldexists("yztc_sun_info", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `name` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `phone` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "address")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `address` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "area_adcode")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `area_adcode` varchar(30) DEFAULT NULL COMMENT '区域编码';");
}
if(!pdo_fieldexists("yztc_sun_info", "lng")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `lng` varchar(20) DEFAULT NULL COMMENT '经度';");
}
if(!pdo_fieldexists("yztc_sun_info", "lat")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `lat` varchar(20) DEFAULT NULL COMMENT '纬度';");
}
if(!pdo_fieldexists("yztc_sun_info", "topping_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `topping_time` int(11) NOT NULL DEFAULT '0' COMMENT '置顶时间';");
}
if(!pdo_fieldexists("yztc_sun_info", "need_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `need_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否需要审核';");
}
if(!pdo_fieldexists("yztc_sun_info", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `check_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '审核状态 1未审核 2审核成功 3审核失败';");
}
if(!pdo_fieldexists("yztc_sun_info", "check_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `check_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `fail_reason` varchar(100) DEFAULT NULL COMMENT '失败原因';");
}
if(!pdo_fieldexists("yztc_sun_info", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "citycode")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `citycode` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "adcode")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `adcode` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_info", "sort_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `sort_id` int(11) NOT NULL DEFAULT '0' COMMENT '置顶排序id';");
}
if(!pdo_fieldexists("yztc_sun_info", "top_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `top_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '置顶状态 1置顶';");
}
if(!pdo_fieldexists("yztc_sun_info", "top_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `top_id` int(11) NOT NULL DEFAULT '0' COMMENT '置顶收费id';");
}
if(!pdo_fieldexists("yztc_sun_info", "pay_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1支付成功(top_id>0生效)';");
}
if(!pdo_fieldexists("yztc_sun_info", "record_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `record_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单记录id';");
}
if(!pdo_fieldexists("yztc_sun_info", "popularity_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `popularity_num` int(11) NOT NULL DEFAULT '0' COMMENT '人气';");
}
if(!pdo_fieldexists("yztc_sun_info", "pageviews_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `pageviews_num` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量';");
}
if(!pdo_fieldexists("yztc_sun_info", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `is_del` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_info", "posting_fee")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `posting_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '发帖收的费用';");
}
if(!pdo_fieldexists("yztc_sun_info", "is_show")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示 1显示(当要收费时 没有支付就不显示)';");
}
if(!pdo_fieldexists("yztc_sun_info", "pay_status_posting")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_info")." ADD   `pay_status_posting` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态(针对发帖)';");
}
if(!pdo_fieldexists("yztc_sun_infobrowselike", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infobrowselike")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_infobrowselike", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infobrowselike")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infobrowselike", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infobrowselike")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infobrowselike", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infobrowselike")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1浏览记录 2收藏';");
}
if(!pdo_fieldexists("yztc_sun_infobrowselike", "info_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infobrowselike")." ADD   `info_id` int(11) NOT NULL DEFAULT '0' COMMENT '帖子id';");
}
if(!pdo_fieldexists("yztc_sun_infobrowselike", "collect_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infobrowselike")." ADD   `collect_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1收藏 2取消收藏';");
}
if(!pdo_fieldexists("yztc_sun_infobrowselike", "collect_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infobrowselike")." ADD   `collect_time` int(11) DEFAULT NULL COMMENT '收藏时间';");
}
if(!pdo_fieldexists("yztc_sun_infobrowselike", "cancel_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infobrowselike")." ADD   `cancel_time` int(11) DEFAULT NULL COMMENT '取消时间 ';");
}
if(!pdo_fieldexists("yztc_sun_infobrowselike", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infobrowselike")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1信息类 ';");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "parent_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级';");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `name` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `icon` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `state` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `is_del` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "delete_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `delete_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "index")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `index` int(11) NOT NULL DEFAULT '255' COMMENT '从小到大';");
}
if(!pdo_fieldexists("yztc_sun_infocategory", "level")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocategory")." ADD   `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1级';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `user_id` int(11) DEFAULT NULL COMMENT '评论或者回复用户';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "to_user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `to_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '被回复的用户';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "info_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `info_id` int(11) NOT NULL DEFAULT '0' COMMENT '帖子id';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "top_comment_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `top_comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '最顶级评论id';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "comment_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复记录id';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "content")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `content` text COMMENT '评论内容';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "comment_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `comment_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '评论类型 1评论 2回复';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `is_del` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `check_status` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "check_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `check_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infocomment", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infocomment")." ADD   `fail_reason` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "record_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `record_id` int(11) DEFAULT NULL COMMENT '置顶记录订单id';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "types")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `types` tinyint(4) NOT NULL DEFAULT '1' COMMENT '退款种类 1置顶退款';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "refund_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `refund_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款方式 1微信退款';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "order_refund_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `order_refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1仅退款';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "refund_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `refund_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "refund_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1退款成功 2退款失败';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `refund_time` tinyint(11) DEFAULT NULL COMMENT '退款时间';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "err_code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `err_code` varchar(200) DEFAULT NULL COMMENT '退款失败错误码';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "err_code_dec")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `err_code_dec` varchar(200) DEFAULT NULL COMMENT '错误信息';");
}
if(!pdo_fieldexists("yztc_sun_inforefund", "xml")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_inforefund")." ADD   `xml` text COMMENT '退款报文';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "disclaimer")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `disclaimer` text COMMENT '免责声明';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "release_notice")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `release_notice` text COMMENT '发布须知';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "is_check")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `is_check` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否需要审核 1需要 0不需要';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "national_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `national_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1全国版';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "post_address")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `post_address` tinyint(4) NOT NULL DEFAULT '1' COMMENT '发帖地址 1开启 0关闭不显示发帖地址';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "post_nearby")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `post_nearby` tinyint(4) NOT NULL DEFAULT '0' COMMENT '帖子附近 1开启信息列表附近排序';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "post_browse")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `post_browse` int(11) NOT NULL DEFAULT '0' COMMENT '帖子浏览数';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "post_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `post_num` int(11) NOT NULL DEFAULT '0' COMMENT '每天发帖限制数量';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "comment_check")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `comment_check` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评论审核开关 1需要';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "word_filtering")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `word_filtering` longtext COMMENT '词语过滤';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "posting_fee_switch")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `posting_fee_switch` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发帖收费开关 1收费';");
}
if(!pdo_fieldexists("yztc_sun_infosettings", "posting_fee")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosettings")." ADD   `posting_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每条帖子收费金额';");
}
if(!pdo_fieldexists("yztc_sun_infosort", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosort")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_infosort", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosort")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infosort", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosort")." ADD   `type` int(11) NOT NULL DEFAULT '0' COMMENT '1帖子信息排序值';");
}
if(!pdo_fieldexists("yztc_sun_infosort", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosort")." ADD   `sort` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_infosort", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infosort")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotop", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotop")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_infotop", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotop")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotop", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotop")." ADD   `name` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotop", "day_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotop")." ADD   `day_num` int(11) NOT NULL DEFAULT '1' COMMENT '天数';");
}
if(!pdo_fieldexists("yztc_sun_infotop", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotop")." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_infotop", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotop")." ADD   `state` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_infotop", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotop")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotop", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotop")." ADD   `sort` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "info_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `info_id` int(11) DEFAULT NULL COMMENT '帖子id';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `openid` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "top_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `top_id` int(11) NOT NULL DEFAULT '0' COMMENT '置顶收费id';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "day_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `day_num` int(11) NOT NULL DEFAULT '0' COMMENT '置顶天数';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "order_amount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "order_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `order_no` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `out_trade_no` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `transaction_id` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "pay_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "pay_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `pay_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "use_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `use_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '使用状态 1已使用';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "need_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `need_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否需要审核 1需要';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `check_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '审核状态 1未审核 2审核成功 3审核失败';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "check_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `check_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "order_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未付款 1已付款待审核 2已付款审核成功 3已付款审核失败(退款) ';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "refund_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `refund_status` tinyint(4) DEFAULT '0' COMMENT '退款状态 0处理中 1退款成功 2退款失败(当order_status=3退款生效)';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `refund_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "refund_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号';");
}
if(!pdo_fieldexists("yztc_sun_infotoprecord", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_infotoprecord")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralcategory", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralcategory")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_integralcategory", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralcategory")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralcategory", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralcategory")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_integralcategory", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralcategory")." ADD   `name` varchar(60) DEFAULT NULL COMMENT '名称';");
}
if(!pdo_fieldexists("yztc_sun_integralcategory", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralcategory")." ADD   `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists("yztc_sun_integralcategory", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralcategory")." ADD   `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '启用状态 1启用';");
}
if(!pdo_fieldexists("yztc_sun_integralcategory", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralcategory")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralcategory", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralcategory")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralcategory", "icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralcategory")." ADD   `icon` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "is_open")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `is_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否开启1开启';");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "distribution")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费';");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "address")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `address` varchar(250) DEFAULT NULL COMMENT '自提地址';");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "cost")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `cost` decimal(10,2) DEFAULT '0.00' COMMENT '消费金额';");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "score")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `score` int(11) DEFAULT '0' COMMENT '可得积分';");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "rule")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `rule` text COMMENT '积分规则';");
}
if(!pdo_fieldexists("yztc_sun_integralconf", "banner")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralconf")." ADD   `banner` text COMMENT '轮播图';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "cat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `cat_id` int(11) DEFAULT NULL COMMENT '分类id';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `name` varchar(200) DEFAULT NULL COMMENT '积分商品名称';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "cover")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `cover` varchar(200) DEFAULT NULL COMMENT '缩略图';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "pics")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `pics` text COMMENT '商品图或轮播图';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "intergral")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `intergral` int(11) NOT NULL DEFAULT '0' COMMENT '价值积分';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "sales_numxn")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `sales_numxn` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟销量';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "sales_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `sales_num` int(11) NOT NULL DEFAULT '0' COMMENT '销量';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '库存';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `state` tinyint(1) DEFAULT '1' COMMENT '1.启用';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "details")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `details` text COMMENT '商品详情';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "unit")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `unit` varchar(10) DEFAULT NULL COMMENT '单位';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "weight")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `weight` varchar(10) DEFAULT NULL COMMENT '重量';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `is_del` tinyint(1) DEFAULT '1' COMMENT '0.已删除';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "postagerules_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `postagerules_id` int(11) DEFAULT '0' COMMENT '运费模板id';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "limit_buy")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `limit_buy` int(11) DEFAULT '0' COMMENT '每人限购数量';");
}
if(!pdo_fieldexists("yztc_sun_integralgoods", "num_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralgoods")." ADD   `num_type` tinyint(1) DEFAULT '1' COMMENT '1.下单减库存 2.兑换成功减库存';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `out_trade_no` varchar(60) DEFAULT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `transaction_id` varchar(60) DEFAULT NULL COMMENT '微信单号';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `goods_id` int(11) DEFAULT NULL COMMENT '积分商品id';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "spec_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `spec_name` varchar(60) DEFAULT NULL COMMENT '规格名';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "spec_value")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `spec_value` varchar(60) DEFAULT NULL COMMENT '规格值';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "order_amount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额(包含运费)';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "total_integral")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `total_integral` int(11) NOT NULL DEFAULT '0' COMMENT '总兑换的积分';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "total_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `total_num` int(11) NOT NULL DEFAULT '0' COMMENT '兑换数量';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "sincetype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `sincetype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '配送方式 1快递 2到店自提';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "distribution")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `name` varchar(60) DEFAULT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `phone` varchar(60) DEFAULT NULL COMMENT '手机';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "province")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `province` varchar(30) DEFAULT NULL COMMENT '省份';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "city")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `city` varchar(30) DEFAULT NULL COMMENT '市';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "area")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `area` varchar(30) DEFAULT NULL COMMENT '区县';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "address")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `address` varchar(250) DEFAULT NULL COMMENT '收货地址 配送方式快递是使用';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "remark")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `remark` varchar(250) DEFAULT NULL COMMENT '留言';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "pay_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1已支付';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "dh_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `dh_time` int(11) DEFAULT NULL COMMENT '积分兑换时间(下单时间)';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "pay_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `pay_time` int(11) DEFAULT NULL COMMENT '运费支付时间';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "order_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0未付款 1待发货  2待确认收货 3已完成';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "fahuo_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `fahuo_time` int(11) DEFAULT NULL COMMENT '发货时间';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "queren_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `queren_time` int(11) DEFAULT NULL COMMENT '完成时间(确认收货时间)';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "express_delivery")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `express_delivery` varchar(60) DEFAULT NULL COMMENT '快递';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "express_orderformid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `express_orderformid` varchar(60) DEFAULT NULL COMMENT '快递单号';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "prepay_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `prepay_id` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "pay_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `pay_type` tinyint(1) DEFAULT '0' COMMENT '1.微信支付 2.余额支付';");
}
if(!pdo_fieldexists("yztc_sun_integralorder", "is_show")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralorder")." ADD   `is_show` tinyint(1) DEFAULT '1' COMMENT '0.删除';");
}
if(!pdo_fieldexists("yztc_sun_integralrecord", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralrecord")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_integralrecord", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralrecord")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralrecord", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralrecord")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_integralrecord", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralrecord")." ADD   `goods_id` int(11) NOT NULL DEFAULT '1' COMMENT '商品id';");
}
if(!pdo_fieldexists("yztc_sun_integralrecord", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralrecord")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_integralrecord", "score")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralrecord")." ADD   `score` int(11) DEFAULT '0' COMMENT '积分';");
}
if(!pdo_fieldexists("yztc_sun_integralrecord", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralrecord")." ADD   `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id';");
}
if(!pdo_fieldexists("yztc_sun_integralrecord", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_integralrecord")." ADD   `type` tinyint(1) DEFAULT NULL COMMENT '1.购买返积分 2.积分商城消费';");
}
if(!pdo_fieldexists("yztc_sun_menu", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_menu", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `name` varchar(50) DEFAULT NULL COMMENT '菜单名称';");
}
if(!pdo_fieldexists("yztc_sun_menu", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `create_time` int(20) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("yztc_sun_menu", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `update_time` int(20) DEFAULT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists("yztc_sun_menu", "memo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `memo` varchar(200) DEFAULT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("yztc_sun_menu", "index")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `index` int(10) DEFAULT NULL COMMENT '排序';");
}
if(!pdo_fieldexists("yztc_sun_menu", "menugroup_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `menugroup_id` int(11) DEFAULT NULL COMMENT '分组id';");
}
if(!pdo_fieldexists("yztc_sun_menu", "control")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `control` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_menu", "action")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `action` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_menu", "icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `icon` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_menu", "menu_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `menu_id` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_menu", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `state` tinyint(1) DEFAULT '1' COMMENT '1.启用 0.禁用';");
}
if(!pdo_fieldexists("yztc_sun_menu", "store_show")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   `store_show` int(4) DEFAULT '1' COMMENT '商户后台是否显示';");
}
if(!pdo_fieldexists("yztc_sun_menu", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menu")." ADD   UNIQUE KEY `id` (`id`) USING BTREE;");
}
if(!pdo_fieldexists("yztc_sun_menugroup", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menugroup")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_menugroup", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menugroup")." ADD   `name` varchar(50) DEFAULT NULL COMMENT '菜单分组名称';");
}
if(!pdo_fieldexists("yztc_sun_menugroup", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menugroup")." ADD   `create_time` int(20) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("yztc_sun_menugroup", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menugroup")." ADD   `update_time` int(20) DEFAULT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists("yztc_sun_menugroup", "memo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menugroup")." ADD   `memo` varchar(200) DEFAULT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("yztc_sun_menugroup", "index")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menugroup")." ADD   `index` int(10) DEFAULT NULL COMMENT '排序';");
}
if(!pdo_fieldexists("yztc_sun_menugroup", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menugroup")." ADD   `state` tinyint(1) DEFAULT '1' COMMENT '1.启用 0.禁用';");
}
if(!pdo_fieldexists("yztc_sun_menugroup", "store_show")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menugroup")." ADD   `store_show` int(4) DEFAULT '1' COMMENT '商户后台是否显示';");
}
if(!pdo_fieldexists("yztc_sun_menugroup", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_menugroup")." ADD   UNIQUE KEY `id` (`id`) USING BTREE;");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `store_id` int(11) DEFAULT NULL COMMENT '商家id';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "store_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `store_name` varchar(100) DEFAULT NULL COMMENT '商家名称';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '方式 1 普通订单 2抢购 3优惠券 4分销(扣除)';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "mcd_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `mcd_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现方式 1订单收入 2微信提现 3审核失败退款 4核销订单完成收入(之前兼容的) 5提现失败收入 6分销扣款';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `openid` varchar(30) DEFAULT NULL COMMENT '订单收入支付的openid|提现给的openid';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "sign")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "mcd_memo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `mcd_memo` text COMMENT '相关详细信息';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '全额 订单收入全额 提现全额';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "realmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "paycommission")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现支付给平台佣金';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "ratesmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `order_id` int(11) DEFAULT NULL COMMENT '订单收入id';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "wd_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `wd_id` int(11) DEFAULT NULL COMMENT '提现id';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1成功 2失败 提现可能会失败';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "add_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `add_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "del_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "now_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `now_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前余额';");
}
if(!pdo_fieldexists("yztc_sun_mercapdetails", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_mercapdetails")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `type` int(1) DEFAULT '1' COMMENT '1.购买会员 2.激活码激活';");
}
if(!pdo_fieldexists("yztc_sun_openvip", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "setid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `setid` int(11) DEFAULT NULL COMMENT '开卡的id';");
}
if(!pdo_fieldexists("yztc_sun_openvip", "day")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `day` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `code` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `name` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `money` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_openvip", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `out_trade_no` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `transaction_id` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_openvip", "share_user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_openvip")." ADD   `share_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享用户id';");
}
if(!pdo_fieldexists("yztc_sun_order", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_order", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_order", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `openid` varchar(30) DEFAULT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("yztc_sun_order", "order_lid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `order_lid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单类别 1普通订单 2预约订单';");
}
if(!pdo_fieldexists("yztc_sun_order", "cid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `cid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '下单方式 0直接下单 1购物车下单';");
}
if(!pdo_fieldexists("yztc_sun_order", "order_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `order_no` varchar(60) DEFAULT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists("yztc_sun_order", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `out_trade_no` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `transaction_id` varchar(60) DEFAULT NULL COMMENT '微信单号';");
}
if(!pdo_fieldexists("yztc_sun_order", "total_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总费用(包含运费)';");
}
if(!pdo_fieldexists("yztc_sun_order", "order_amount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额(实际支付金额)(扣去优惠券金额获取其他方式的优惠)';");
}
if(!pdo_fieldexists("yztc_sun_order", "goods_amount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总金额';");
}
if(!pdo_fieldexists("yztc_sun_order", "num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '商品总数量';");
}
if(!pdo_fieldexists("yztc_sun_order", "delivery_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `delivery_type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '配送方式 1送货上门(快递) 2到店消费';");
}
if(!pdo_fieldexists("yztc_sun_order", "distribution")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费';");
}
if(!pdo_fieldexists("yztc_sun_order", "user_coupon_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `user_coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用优惠券id';");
}
if(!pdo_fieldexists("yztc_sun_order", "coupon_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `coupon_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券优惠金额';");
}
if(!pdo_fieldexists("yztc_sun_order", "discount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `discount` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '会员折扣';");
}
if(!pdo_fieldexists("yztc_sun_order", "discount_total_goods_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `discount_total_goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '折扣后商品金额';");
}
if(!pdo_fieldexists("yztc_sun_order", "pay_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `pay_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '支付方式 1微信支付 2余额支付';");
}
if(!pdo_fieldexists("yztc_sun_order", "pay_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1已支付 ';");
}
if(!pdo_fieldexists("yztc_sun_order", "pay_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `pay_time` int(11) DEFAULT NULL COMMENT '支付时间';");
}
if(!pdo_fieldexists("yztc_sun_order", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "express_delivery")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `express_delivery` varchar(60) DEFAULT NULL COMMENT '物流快递公司';");
}
if(!pdo_fieldexists("yztc_sun_order", "express_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `express_no` varchar(60) DEFAULT NULL COMMENT '快递单号';");
}
if(!pdo_fieldexists("yztc_sun_order", "send_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `send_time` int(11) DEFAULT NULL COMMENT '发货时间';");
}
if(!pdo_fieldexists("yztc_sun_order", "confirm_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `confirm_time` int(11) DEFAULT NULL COMMENT '确认收货时间完成时间';");
}
if(!pdo_fieldexists("yztc_sun_order", "cancel_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `cancel_time` int(11) DEFAULT NULL COMMENT '订单取消时间';");
}
if(!pdo_fieldexists("yztc_sun_order", "order_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态  10待支付 20待发货(待核销)  30待确认收货(待核销) 40待评价 60已完成  5取消订单 ';");
}
if(!pdo_fieldexists("yztc_sun_order", "refund_application_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `refund_application_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款申请状态 1已申请退款';");
}
if(!pdo_fieldexists("yztc_sun_order", "refund_application_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `refund_application_time` int(11) DEFAULT NULL COMMENT '退款申请时间';");
}
if(!pdo_fieldexists("yztc_sun_order", "review_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `review_status` tinyint(4) DEFAULT '0' COMMENT '退款审核状态 1审核通过 2审核失败';");
}
if(!pdo_fieldexists("yztc_sun_order", "review_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `review_time` int(11) DEFAULT NULL COMMENT '审核时间';");
}
if(!pdo_fieldexists("yztc_sun_order", "review_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `review_reason` text COMMENT '审核原因';");
}
if(!pdo_fieldexists("yztc_sun_order", "refund_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款状态 0处理中 1退款成功 2退款失败(当order_status=5生效)';");
}
if(!pdo_fieldexists("yztc_sun_order", "refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `refund_time` int(11) DEFAULT NULL COMMENT '退款时间';");
}
if(!pdo_fieldexists("yztc_sun_order", "refund_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `refund_no` varchar(60) DEFAULT NULL COMMENT '退款订单号';");
}
if(!pdo_fieldexists("yztc_sun_order", "cancel_refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `cancel_refund_time` int(11) DEFAULT NULL COMMENT '取消退款时间';");
}
if(!pdo_fieldexists("yztc_sun_order", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 0未删除 1 用户删除 2商家删除';");
}
if(!pdo_fieldexists("yztc_sun_order", "is_evaluation")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `is_evaluation` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否评价 1已评价';");
}
if(!pdo_fieldexists("yztc_sun_order", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `name` varchar(60) DEFAULT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("yztc_sun_order", "phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `phone` varchar(60) DEFAULT NULL COMMENT '手机';");
}
if(!pdo_fieldexists("yztc_sun_order", "province")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `province` varchar(30) DEFAULT NULL COMMENT '省';");
}
if(!pdo_fieldexists("yztc_sun_order", "city")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `city` varchar(30) DEFAULT NULL COMMENT '市';");
}
if(!pdo_fieldexists("yztc_sun_order", "district")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `district` varchar(60) DEFAULT NULL COMMENT '区';");
}
if(!pdo_fieldexists("yztc_sun_order", "town")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `town` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "address")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `address` varchar(200) DEFAULT NULL COMMENT '详细地址';");
}
if(!pdo_fieldexists("yztc_sun_order", "postalcode")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `postalcode` varchar(30) DEFAULT NULL COMMENT '邮编';");
}
if(!pdo_fieldexists("yztc_sun_order", "remark")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `remark` varchar(200) DEFAULT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("yztc_sun_order", "prepay_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `prepay_id` varchar(60) DEFAULT NULL COMMENT '消息模板';");
}
if(!pdo_fieldexists("yztc_sun_order", "del_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1已删除';");
}
if(!pdo_fieldexists("yztc_sun_order", "del_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `del_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "shipping_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `shipping_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "finish_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `finish_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "distribution_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `distribution_money` decimal(15,2) DEFAULT '0.00' COMMENT '分佣总金额';");
}
if(!pdo_fieldexists("yztc_sun_order", "gid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id(活动id)';");
}
if(!pdo_fieldexists("yztc_sun_order", "is_free")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `is_free` tinyint(4) DEFAULT '0' COMMENT '1会员免单';");
}
if(!pdo_fieldexists("yztc_sun_order", "free_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `free_num` int(11) NOT NULL DEFAULT '0' COMMENT '免费单数';");
}
if(!pdo_fieldexists("yztc_sun_order", "write_off_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `write_off_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '核销状态 0未核销 1部分核销 2全部核销';");
}
if(!pdo_fieldexists("yztc_sun_order", "write_off_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `write_off_num` int(11) NOT NULL DEFAULT '0' COMMENT '已核销数量';");
}
if(!pdo_fieldexists("yztc_sun_order", "write_off_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `write_off_time` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_order", "after_sale")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `after_sale` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否申请售后 1申请';");
}
if(!pdo_fieldexists("yztc_sun_order", "share_user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `share_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '通过分享用户id下单';");
}
if(!pdo_fieldexists("yztc_sun_order", "tuikuanformid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `tuikuanformid` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "book_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `book_name` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "book_phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `book_phone` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_order", "book_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_order")." ADD   `book_time` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `order_id` int(11) DEFAULT NULL COMMENT '订单id';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `openid` varchar(60) NOT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "gid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `gid` int(11) DEFAULT NULL COMMENT '商品id';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "gname")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `gname` varchar(60) DEFAULT NULL COMMENT '商品名称';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "unit_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "total_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "attr_ids")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `attr_ids` varchar(250) DEFAULT NULL COMMENT '商品规格';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "attr_list")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `attr_list` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `pic` varchar(100) DEFAULT NULL COMMENT '图片';");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_orderdetail", "is_evaluation")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderdetail")." ADD   `is_evaluation` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否评价';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `order_id` int(11) DEFAULT NULL COMMENT '订单id';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "refund_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `refund_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款方式 1微信退款 2余额退款';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "order_refund_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `order_refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1仅退款';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "refund_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `refund_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "refund_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1退款成功 2退款失败';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `refund_time` tinyint(11) DEFAULT NULL COMMENT '退款时间';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "err_code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `err_code` varchar(200) DEFAULT NULL COMMENT '退款失败错误码';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "err_code_dec")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `err_code_dec` varchar(200) DEFAULT NULL COMMENT '错误信息';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "xml")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `xml` text COMMENT '退款报文';");
}
if(!pdo_fieldexists("yztc_sun_orderrefund", "order_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_orderrefund")." ADD   `order_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单类型 1普通订单 2抢购订单 3拼团订单';");
}
if(!pdo_fieldexists("yztc_sun_panic", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_panic", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panic", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `store_id` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panic", "cat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `cat_id` int(11) DEFAULT '0' COMMENT '商品分类id';");
}
if(!pdo_fieldexists("yztc_sun_panic", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '商品名称';");
}
if(!pdo_fieldexists("yztc_sun_panic", "unit")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `unit` varchar(10) DEFAULT '个' COMMENT '单位';");
}
if(!pdo_fieldexists("yztc_sun_panic", "weight")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `weight` double(10,2) DEFAULT '0.00' COMMENT '重量';");
}
if(!pdo_fieldexists("yztc_sun_panic", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序 从大到小';");
}
if(!pdo_fieldexists("yztc_sun_panic", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)';");
}
if(!pdo_fieldexists("yztc_sun_panic", "pics")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `pics` text COMMENT '商品轮播图';");
}
if(!pdo_fieldexists("yztc_sun_panic", "panic_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `panic_price` decimal(10,2) DEFAULT '0.00' COMMENT '抢购价';");
}
if(!pdo_fieldexists("yztc_sun_panic", "original_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `original_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价展示使用';");
}
if(!pdo_fieldexists("yztc_sun_panic", "details")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `details` text COMMENT '商品详细';");
}
if(!pdo_fieldexists("yztc_sun_panic", "service")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)';");
}
if(!pdo_fieldexists("yztc_sun_panic", "postagerules_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `postagerules_id` decimal(11,2) DEFAULT NULL COMMENT '运费模板id';");
}
if(!pdo_fieldexists("yztc_sun_panic", "stock")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `stock` int(11) DEFAULT '0' COMMENT '库存';");
}
if(!pdo_fieldexists("yztc_sun_panic", "is_stock")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `is_stock` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panic", "sales_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `sales_num` int(11) DEFAULT '0' COMMENT '销量 销量支付完成';");
}
if(!pdo_fieldexists("yztc_sun_panic", "sales_num_virtual")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `sales_num_virtual` int(11) DEFAULT '0' COMMENT '虚拟销量';");
}
if(!pdo_fieldexists("yztc_sun_panic", "use_attr")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `use_attr` int(4) DEFAULT '0' COMMENT '1使用规格';");
}
if(!pdo_fieldexists("yztc_sun_panic", "attr")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `attr` longtext COMMENT '规格库存和价格';");
}
if(!pdo_fieldexists("yztc_sun_panic", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("yztc_sun_panic", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `update_time` int(11) DEFAULT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists("yztc_sun_panic", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `state` int(4) DEFAULT '1' COMMENT '1启用状态';");
}
if(!pdo_fieldexists("yztc_sun_panic", "is_recommend")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `is_recommend` int(4) DEFAULT '0' COMMENT '是否推荐';");
}
if(!pdo_fieldexists("yztc_sun_panic", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `check_status` int(4) DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败';");
}
if(!pdo_fieldexists("yztc_sun_panic", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `fail_reason` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panic", "single_limit_times")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `single_limit_times` int(11) DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_panic", "limit_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `limit_num` int(11) DEFAULT '0' COMMENT '购买次数限制';");
}
if(!pdo_fieldexists("yztc_sun_panic", "sendtype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `sendtype` varchar(100) DEFAULT '1' COMMENT '1.到店 2.物流';");
}
if(!pdo_fieldexists("yztc_sun_panic", "only_vip")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `only_vip` tinyint(1) DEFAULT '0' COMMENT '1.仅限vip';");
}
if(!pdo_fieldexists("yztc_sun_panic", "vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `vip_price` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_panic", "vip_free")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `vip_free` tinyint(1) DEFAULT '0' COMMENT '1.会员免单';");
}
if(!pdo_fieldexists("yztc_sun_panic", "free_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `free_num` int(11) DEFAULT '0' COMMENT '免单次数';");
}
if(!pdo_fieldexists("yztc_sun_panic", "start_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `start_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panic", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `end_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panic", "expire_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `expire_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panic", "read_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `read_num` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panic", "read_num_virtual")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `read_num_virtual` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panic", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `is_del` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panic", "cancel_order")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `cancel_order` int(11) DEFAULT '5';");
}
if(!pdo_fieldexists("yztc_sun_panic", "allnum")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `allnum` int(11) DEFAULT '0' COMMENT '总份数';");
}
if(!pdo_fieldexists("yztc_sun_panic", "is_support_refund")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `is_support_refund` tinyint(1) DEFAULT '1' COMMENT '0.不支持退款';");
}
if(!pdo_fieldexists("yztc_sun_panic", "is_activity")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `is_activity` tinyint(1) DEFAULT '0' COMMENT '1.添加到活动列表';");
}
if(!pdo_fieldexists("yztc_sun_panic", "indexpic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `indexpic` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panic", "is_ladder")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `is_ladder` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panic", "ladder_info")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `ladder_info` text;");
}
if(!pdo_fieldexists("yztc_sun_panic", "distribution_open")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `distribution_open` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panic", "commissiontype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `commissiontype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1百分比';");
}
if(!pdo_fieldexists("yztc_sun_panic", "first_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额';");
}
if(!pdo_fieldexists("yztc_sun_panic", "second_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额';");
}
if(!pdo_fieldexists("yztc_sun_panic", "third_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `third_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级金额';");
}
if(!pdo_fieldexists("yztc_sun_panic", "posterpic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panic")." ADD   `posterpic` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattr", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattr")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_panicattr", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattr")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattr", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattr")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '规格名称';");
}
if(!pdo_fieldexists("yztc_sun_panicattr", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattr")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattr", "goodsattrgroup_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattr")." ADD   `goodsattrgroup_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattr", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattr")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattr", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattr")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattrgroup", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrgroup")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_panicattrgroup", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrgroup")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattrgroup", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrgroup")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '规格分组名称';");
}
if(!pdo_fieldexists("yztc_sun_panicattrgroup", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrgroup")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattrgroup", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrgroup")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattrgroup", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrgroup")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "key")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `key` varchar(250) DEFAULT NULL COMMENT '规格名称列表';");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "attr_ids")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `attr_ids` varchar(250) NOT NULL DEFAULT '' COMMENT '规格ids';");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "stock")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `stock` int(11) DEFAULT '0' COMMENT '库存';");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `vip_price` decimal(10,2) DEFAULT '0.00' COMMENT '会员价';");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "weight")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `weight` double(10,2) DEFAULT '0.00' COMMENT '重量';");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `code` varchar(50) DEFAULT '' COMMENT '编码';");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `pic` varchar(255) DEFAULT '' COMMENT '封面图';");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicattrsetting", "panic_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicattrsetting")." ADD   `panic_price` decimal(10,2) DEFAULT '0.00' COMMENT '抢购价';");
}
if(!pdo_fieldexists("yztc_sun_panicladder", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicladder")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_panicladder", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicladder")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicladder", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicladder")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicladder", "panic_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicladder")." ADD   `panic_num` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicladder", "panic_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicladder")." ADD   `panic_price` decimal(10,2) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicladder", "vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicladder")." ADD   `vip_price` decimal(10,2) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicladder", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicladder")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "order_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `order_no` varchar(50) DEFAULT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `out_trade_no` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `transaction_id` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "pid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `pid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "attr_ids")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `attr_ids` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "attr_list")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `attr_list` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "order_amount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额（含运费）';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "sincetype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `sincetype` tinyint(1) DEFAULT '1' COMMENT '配送方式 1到店  2.快递';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "distribution")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `distribution` decimal(10,2) DEFAULT '0.00' COMMENT '运费';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `num` int(11) DEFAULT '1' COMMENT '购买数量';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '单价';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `name` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `phone` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "province")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `province` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "city")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `city` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "area")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `area` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "address")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `address` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "remark")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `remark` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "express_delivery")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `express_delivery` varchar(50) DEFAULT NULL COMMENT '快递公司';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "express_orderformid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `express_orderformid` varchar(50) DEFAULT NULL COMMENT '快递单号';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "is_pay")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `is_pay` tinyint(1) DEFAULT '0' COMMENT '1.已付款';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "pay_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `pay_type` tinyint(1) DEFAULT '0' COMMENT '1.微信支付 2.零钱支付';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "pay_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `pay_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "write_off_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `write_off_status` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "write_off_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `write_off_num` int(11) DEFAULT '0' COMMENT '核销份数';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "write_off_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `write_off_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "order_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `order_status` tinyint(1) DEFAULT '10';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "prepay_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `prepay_id` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "expire_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `expire_time` int(11) DEFAULT '0' COMMENT '支付过期时间';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `is_del` tinyint(1) DEFAULT '0' COMMENT '1.已删除(过期未支付)';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "is_show")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `is_show` tinyint(1) DEFAULT '1' COMMENT '0.删除（订单列表不显示）';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "refund_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `refund_status` tinyint(1) DEFAULT '0' COMMENT '2退款成功 3退款失败 4.拒绝退款';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `refund_time` int(11) DEFAULT '0' COMMENT '退款时间';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "refund_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `refund_no` varchar(50) DEFAULT '0' COMMENT '退款单号';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "finish_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `finish_time` int(11) DEFAULT '0' COMMENT '完成时间';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "is_vip")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `is_vip` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "use_attr")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `use_attr` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "is_free")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `is_free` tinyint(1) DEFAULT '0' COMMENT '1免单';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "after_sale")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `after_sale` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `fail_reason` varchar(255) DEFAULT NULL COMMENT '拒绝退款原因';");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "err_code_dec")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `err_code_dec` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicorder", "share_user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicorder")." ADD   `share_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享用户id';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `order_id` int(11) DEFAULT NULL COMMENT '订单id';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "refund_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `refund_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款方式 1微信退款 2余额退款';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "refund_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1仅退款';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "refund_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `refund_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "refund_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `refund_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '2退款成功 3退款失败 4.拒绝退款';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `refund_time` int(11) DEFAULT NULL COMMENT '退款时间';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "err_code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `err_code` varchar(200) DEFAULT NULL COMMENT '退款失败错误码';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "err_code_dec")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `err_code_dec` varchar(200) DEFAULT NULL COMMENT '错误信息';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "xml")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `xml` text COMMENT '退款报文';");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_panicrefund", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_panicrefund")." ADD   `fail_reason` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `store_id` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "cat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `cat_id` int(11) DEFAULT '0' COMMENT '商品分类id';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '商品名称';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "unit")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `unit` varchar(10) DEFAULT '个' COMMENT '单位';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "weight")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `weight` double(10,2) DEFAULT '0.00' COMMENT '重量';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序 从大到小';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '商品缩略图(封面图)';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "pics")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `pics` text COMMENT '商品轮播图';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `price` decimal(10,2) DEFAULT '0.00' COMMENT '单购价';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "pin_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `pin_price` decimal(10,2) DEFAULT '0.00' COMMENT '拼购价';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `vip_price` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "alonepay_vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `alonepay_vip_price` decimal(10,2) DEFAULT '0.00' COMMENT '会员单购价';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "original_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `original_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价展示使用';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "details")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `details` text COMMENT '商品详细';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "service")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `service` varchar(200) DEFAULT NULL COMMENT '服务内容(正品保障)';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "postagerules_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `postagerules_id` decimal(11,2) DEFAULT NULL COMMENT '运费模板id';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "stock")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `stock` int(11) DEFAULT '0' COMMENT '库存';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "sales_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `sales_num` int(11) DEFAULT '0' COMMENT '销量 销量支付完成';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "sales_num_virtual")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `sales_num_virtual` int(11) DEFAULT '0' COMMENT '虚拟销量';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "use_attr")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `use_attr` int(4) DEFAULT '0' COMMENT '1使用规格';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "attr")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `attr` longtext COMMENT '规格库存和价格';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "expire_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `expire_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `update_time` int(11) DEFAULT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `state` int(4) DEFAULT '1' COMMENT '1启用状态';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "is_recommend")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `is_recommend` int(4) DEFAULT '0' COMMENT '是否推荐';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `check_status` int(4) DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `fail_reason` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "is_ladder")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `is_ladder` tinyint(1) DEFAULT '0' COMMENT '1开启阶梯团';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "ladder_info")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `ladder_info` text;");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "limit_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `limit_num` int(11) DEFAULT '0' COMMENT '单次购买数量';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "limit_times")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `limit_times` int(11) DEFAULT '0' COMMENT '购买次数限制';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "group_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `group_num` int(11) DEFAULT '0' COMMENT '实际成团数';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "group_num_virtual")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `group_num_virtual` int(11) DEFAULT '0' COMMENT '虚拟成团数';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "sendtype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `sendtype` varchar(10) DEFAULT '1' COMMENT '1.到店 2.物流';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "need_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `need_num` int(1) DEFAULT '2' COMMENT '开团人数';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "is_group_coupon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `is_group_coupon` tinyint(1) DEFAULT '0' COMMENT '1开启团长优惠';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "coupon_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `coupon_money` decimal(10,2) DEFAULT '0.00' COMMENT '团长优惠金额';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "coupon_discount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `coupon_discount` int(11) DEFAULT '0' COMMENT '团长优惠折扣';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "group_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `group_time` int(11) DEFAULT '0' COMMENT '组团限时';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "pay_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `pay_time` int(11) DEFAULT '0' COMMENT '付款限时';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "start_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `start_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `end_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "is_stock")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `is_stock` tinyint(1) DEFAULT '0' COMMENT '1.限时库存';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `is_del` tinyint(1) DEFAULT '0' COMMENT '1.删除';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "is_alonepay")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `is_alonepay` tinyint(1) DEFAULT '1' COMMENT '0关闭单购';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "is_activity")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `is_activity` tinyint(1) DEFAULT '0' COMMENT '1加入活动列表';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "is_support_refund")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `is_support_refund` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "distribution_open")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `distribution_open` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "commissiontype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `commissiontype` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "first_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `first_money` decimal(10,2) NOT NULL DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "second_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `second_money` decimal(10,2) NOT NULL DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "third_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `third_money` decimal(10,2) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoods", "posterpic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoods")." ADD   `posterpic` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattr", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattr")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattr", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattr")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattr", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattr")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '规格名称';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattr", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattr")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattr", "goodsattrgroup_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattr")." ADD   `goodsattrgroup_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattr", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattr")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattr", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattr")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrgroup", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrgroup")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrgroup", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrgroup")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrgroup", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrgroup")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '规格分组名称';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrgroup", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrgroup")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrgroup", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrgroup")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrgroup", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrgroup")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `uniacid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "key")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `key` varchar(250) DEFAULT NULL COMMENT '规格名称列表';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "attr_ids")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `attr_ids` varchar(250) NOT NULL DEFAULT '' COMMENT '规格ids';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "stock")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `stock` int(11) DEFAULT '0' COMMENT '库存';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `price` decimal(10,2) DEFAULT '0.00' COMMENT '单购价';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "weight")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `weight` double(10,2) DEFAULT '0.00' COMMENT '重量';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `code` varchar(50) DEFAULT '' COMMENT '编码';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `pic` varchar(255) DEFAULT '' COMMENT '封面图';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "pin_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `pin_price` decimal(10,2) DEFAULT '0.00' COMMENT '拼团价';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `vip_price` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_pingoodsattrsetting", "alonepay_vip_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pingoodsattrsetting")." ADD   `alonepay_vip_price` decimal(10,2) DEFAULT '0.00' COMMENT '会员单购价';");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "groupnum")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `groupnum` int(11) DEFAULT '0' COMMENT '成团人数';");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "groupmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `groupmoney` decimal(10,2) DEFAULT '0.00' COMMENT '成团价钱';");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "ladder_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `ladder_id` int(11) DEFAULT '0' COMMENT '阶梯团id';");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `status` tinyint(1) DEFAULT '0' COMMENT '1.开团成功 2.拼团成功 3.拼团失败';");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "oid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `oid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "expire_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `expire_time` int(11) DEFAULT '0' COMMENT '到期时间';");
}
if(!pdo_fieldexists("yztc_sun_pinheads", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinheads")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinladder", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinladder")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_pinladder", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinladder")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinladder", "groupnum")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinladder")." ADD   `groupnum` int(11) DEFAULT '2' COMMENT '组团人数';");
}
if(!pdo_fieldexists("yztc_sun_pinladder", "groupmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinladder")." ADD   `groupmoney` decimal(10,2) DEFAULT '0.00' COMMENT '组团价格';");
}
if(!pdo_fieldexists("yztc_sun_pinladder", "vip_groupmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinladder")." ADD   `vip_groupmoney` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_pinladder", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinladder")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinladder", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinladder")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "order_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `order_no` varchar(50) DEFAULT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `out_trade_no` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `transaction_id` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "goods_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `goods_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "attr_ids")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `attr_ids` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "attr_list")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `attr_list` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "order_amount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额（含运费）';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "sincetype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `sincetype` tinyint(1) DEFAULT '1' COMMENT '配送方式 1到店 ';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "distribution")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `distribution` decimal(10,2) DEFAULT '0.00' COMMENT '运费';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `num` int(11) DEFAULT '1' COMMENT '购买数量';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '单价';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `name` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `phone` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "province")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `province` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "city")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `city` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "area")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `area` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "address")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `address` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "remark")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `remark` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "express_delivery")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `express_delivery` varchar(50) DEFAULT NULL COMMENT '快递公司';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "express_orderformid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `express_orderformid` varchar(50) DEFAULT NULL COMMENT '快递单号';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "is_pay")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `is_pay` tinyint(1) DEFAULT '0' COMMENT '1.已付款';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "pay_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `pay_type` tinyint(1) DEFAULT '0' COMMENT '1.微信支付 2.零钱支付';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "pay_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `pay_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "write_off_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `write_off_status` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "write_off_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `write_off_num` int(11) DEFAULT '0' COMMENT '核销份数';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "write_off_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `write_off_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "order_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `order_status` tinyint(1) DEFAULT '10';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "prepay_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `prepay_id` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "expire_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `expire_time` int(11) DEFAULT '0' COMMENT '支付过期时间';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `is_del` tinyint(1) DEFAULT '0' COMMENT '1.已删除(过期未支付)';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "is_show")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `is_show` tinyint(1) DEFAULT '1' COMMENT '0.删除（订单列表不显示）';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "refund_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `refund_status` tinyint(1) DEFAULT '0' COMMENT '2退款成功 3退款失败 4.拒绝退款';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `refund_time` int(11) DEFAULT '0' COMMENT '退款时间';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "refund_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `refund_no` varchar(50) DEFAULT '0' COMMENT '退款单号';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "finish_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `finish_time` int(11) DEFAULT '0' COMMENT '完成时间';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "is_vip")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `is_vip` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "use_attr")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `use_attr` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "is_free")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `is_free` tinyint(1) DEFAULT '0' COMMENT '1免单';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "after_sale")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `after_sale` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `fail_reason` varchar(255) DEFAULT NULL COMMENT '拒绝退款原因';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "err_code_dec")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `err_code_dec` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "is_head")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `is_head` tinyint(1) DEFAULT '0' COMMENT '1.团长';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "coupon_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `coupon_money` decimal(10,2) DEFAULT '0.00' COMMENT '优惠金额';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "heads_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `heads_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "group_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `group_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "share_user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `share_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享用户id';");
}
if(!pdo_fieldexists("yztc_sun_pinorder", "send_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinorder")." ADD   `send_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `order_id` int(11) DEFAULT NULL COMMENT '订单id';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "heads_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `heads_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "refund_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `refund_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款方式 1微信退款 2余额退款';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "order_refund_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `order_refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1仅退款';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "refund_price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `refund_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "refund_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `refund_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.申请退款2退款成功 3退款失败 4.拒绝退款';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `refund_time` tinyint(11) DEFAULT NULL COMMENT '退款时间';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "err_code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `err_code` varchar(200) DEFAULT NULL COMMENT '退款失败错误码';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "err_code_dec")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `err_code_dec` varchar(200) DEFAULT NULL COMMENT '错误信息';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "xml")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `xml` text COMMENT '退款报文';");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_pinrefund", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_pinrefund")." ADD   `fail_reason` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店 0为自营';");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '规则名称';");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "detail")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `detail` longtext NOT NULL COMMENT '规则详细';");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `state` int(1) NOT NULL DEFAULT '0' COMMENT '是否启用：0=否，1=是';");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "is_delete")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `is_delete` smallint(1) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `type` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '计费方式【1=>按件计费、2=>按重计费】';");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `update_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_postagerules", "memo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_postagerules")." ADD   `memo` varchar(255) DEFAULT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("yztc_sun_prints", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_prints")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_prints", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_prints")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_prints", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_prints")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_prints", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_prints")." ADD   `name` varchar(60) DEFAULT NULL COMMENT '打印机名称';");
}
if(!pdo_fieldexists("yztc_sun_prints", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_prints")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '打印机类型 1飞蛾';");
}
if(!pdo_fieldexists("yztc_sun_prints", "user")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_prints")." ADD   `user` varchar(60) DEFAULT NULL COMMENT '飞蛾 账号';");
}
if(!pdo_fieldexists("yztc_sun_prints", "ukey")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_prints")." ADD   `ukey` varchar(60) DEFAULT NULL COMMENT '飞蛾key';");
}
if(!pdo_fieldexists("yztc_sun_prints", "sn")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_prints")." ADD   `sn` varchar(60) DEFAULT NULL COMMENT '打印机编号';");
}
if(!pdo_fieldexists("yztc_sun_prints", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_prints")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_printset", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_printset")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_printset", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_printset")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_printset", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_printset")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_printset", "prints_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_printset")." ADD   `prints_id` int(11) NOT NULL DEFAULT '0' COMMENT '打印机id';");
}
if(!pdo_fieldexists("yztc_sun_printset", "print_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_printset")." ADD   `print_type` varchar(60) NOT NULL DEFAULT '1' COMMENT '打印方式 1下单打印 2付款打印 3确认收货打印 1,2,3';");
}
if(!pdo_fieldexists("yztc_sun_printset", "print_merch")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_printset")." ADD   `print_merch` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1多商户打印';");
}
if(!pdo_fieldexists("yztc_sun_printset", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_printset")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_recharge", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_recharge")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_recharge", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_recharge")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_recharge", "recharge_lowest")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_recharge")." ADD   `recharge_lowest` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低充值金额';");
}
if(!pdo_fieldexists("yztc_sun_recharge", "details")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_recharge")." ADD   `details` text COMMENT '充值活动';");
}
if(!pdo_fieldexists("yztc_sun_recharge", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_recharge")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_recharge", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_recharge")." ADD   `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1启用';");
}
if(!pdo_fieldexists("yztc_sun_rechargerecord", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_rechargerecord")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_rechargerecord", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_rechargerecord")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_rechargerecord", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_rechargerecord")." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '充值总金额（含赠送）';");
}
if(!pdo_fieldexists("yztc_sun_rechargerecord", "send_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_rechargerecord")." ADD   `send_money` decimal(10,2) DEFAULT '0.00' COMMENT '赠送金额';");
}
if(!pdo_fieldexists("yztc_sun_rechargerecord", "out_trade_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_rechargerecord")." ADD   `out_trade_no` varchar(100) DEFAULT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists("yztc_sun_rechargerecord", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_rechargerecord")." ADD   `transaction_id` varchar(100) DEFAULT NULL COMMENT '支付号';");
}
if(!pdo_fieldexists("yztc_sun_rechargerecord", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_rechargerecord")." ADD   `create_time` int(11) DEFAULT NULL COMMENT '支付时间';");
}
if(!pdo_fieldexists("yztc_sun_rechargerecord", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_rechargerecord")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_rechargerecord", "prepay_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_rechargerecord")." ADD   `prepay_id` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_sms", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_sms", "appkey")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `appkey` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_sms", "tpl_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `tpl_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_sms", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_sms", "phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `phone` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_sms", "is_open")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `is_open` int(11) NOT NULL DEFAULT '2';");
}
if(!pdo_fieldexists("yztc_sun_sms", "tid1")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `tid1` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_sms", "tid2")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `tid2` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_sms", "tid3")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `tid3` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_sms", "order_tplid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `order_tplid` int(11) NOT NULL COMMENT '聚合-订单提醒id';");
}
if(!pdo_fieldexists("yztc_sun_sms", "order_refund_tplid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `order_refund_tplid` int(11) NOT NULL COMMENT '聚合-订单退款提醒id';");
}
if(!pdo_fieldexists("yztc_sun_sms", "smstype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `smstype` tinyint(2) NOT NULL DEFAULT '1' COMMENT '短信类型，1为253，2为聚合';");
}
if(!pdo_fieldexists("yztc_sun_sms", "ytx_apiaccount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `ytx_apiaccount` varchar(50) NOT NULL COMMENT '253短信账号';");
}
if(!pdo_fieldexists("yztc_sun_sms", "ytx_apipass")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `ytx_apipass` varchar(50) NOT NULL COMMENT '253短信密码';");
}
if(!pdo_fieldexists("yztc_sun_sms", "ytx_apiurl")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `ytx_apiurl` varchar(50) NOT NULL COMMENT '253短信地址';");
}
if(!pdo_fieldexists("yztc_sun_sms", "ytx_order")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `ytx_order` varchar(255) NOT NULL COMMENT '云通信订单消息提醒';");
}
if(!pdo_fieldexists("yztc_sun_sms", "ytx_orderrefund")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `ytx_orderrefund` varchar(255) NOT NULL COMMENT '云通信退款订单消息提醒';");
}
if(!pdo_fieldexists("yztc_sun_sms", "tid4")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `tid4` varchar(50) DEFAULT NULL COMMENT '开奖模板';");
}
if(!pdo_fieldexists("yztc_sun_sms", "aly_accesskeyid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `aly_accesskeyid` varchar(255) NOT NULL COMMENT '阿里大鱼 accessKeyId';");
}
if(!pdo_fieldexists("yztc_sun_sms", "aly_accesskeysecret")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `aly_accesskeysecret` varchar(255) NOT NULL COMMENT '阿里大鱼 AccessKeySecret';");
}
if(!pdo_fieldexists("yztc_sun_sms", "aly_order")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `aly_order` varchar(255) NOT NULL COMMENT '阿里大鱼 订单模板';");
}
if(!pdo_fieldexists("yztc_sun_sms", "aly_orderrefund")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `aly_orderrefund` varchar(255) NOT NULL COMMENT '阿里大鱼 退款模板';");
}
if(!pdo_fieldexists("yztc_sun_sms", "aly_sign")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `aly_sign` varchar(100) NOT NULL COMMENT '签名';");
}
if(!pdo_fieldexists("yztc_sun_sms", "xiaoshentui")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_sms")." ADD   `xiaoshentui` varchar(255) NOT NULL COMMENT '小神推';");
}
if(!pdo_fieldexists("yztc_sun_store", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_store", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_store", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '门店名称';");
}
if(!pdo_fieldexists("yztc_sun_store", "tel")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `tel` varchar(60) DEFAULT '' COMMENT '商家电话';");
}
if(!pdo_fieldexists("yztc_sun_store", "phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `phone` varchar(60) DEFAULT NULL COMMENT '通知电话';");
}
if(!pdo_fieldexists("yztc_sun_store", "address")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `address` varchar(200) DEFAULT NULL COMMENT '商家地址';");
}
if(!pdo_fieldexists("yztc_sun_store", "check_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `check_status` int(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败';");
}
if(!pdo_fieldexists("yztc_sun_store", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_store", "rz_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `rz_time` int(11) DEFAULT NULL COMMENT '当前入驻时间为审核通过的时间';");
}
if(!pdo_fieldexists("yztc_sun_store", "review_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `review_time` int(11) DEFAULT NULL COMMENT '审核时间';");
}
if(!pdo_fieldexists("yztc_sun_store", "coordinates")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `coordinates` varchar(30) DEFAULT NULL COMMENT '经纬度';");
}
if(!pdo_fieldexists("yztc_sun_store", "lng")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `lng` varchar(20) DEFAULT NULL COMMENT '经度';");
}
if(!pdo_fieldexists("yztc_sun_store", "lat")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `lat` varchar(20) DEFAULT NULL COMMENT '纬度';");
}
if(!pdo_fieldexists("yztc_sun_store", "content")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `content` text COMMENT '详情';");
}
if(!pdo_fieldexists("yztc_sun_store", "pic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '封面图';");
}
if(!pdo_fieldexists("yztc_sun_store", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `openid` varchar(30) DEFAULT NULL COMMENT '商家openid';");
}
if(!pdo_fieldexists("yztc_sun_store", "ptcc_rate")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `ptcc_rate` float(11,0) NOT NULL DEFAULT '0' COMMENT '平台抽成比例 1代表1%';");
}
if(!pdo_fieldexists("yztc_sun_store", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `is_del` int(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_store", "show_index")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `show_index` int(4) NOT NULL DEFAULT '0' COMMENT '首页推荐';");
}
if(!pdo_fieldexists("yztc_sun_store", "balance")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商家余额';");
}
if(!pdo_fieldexists("yztc_sun_store", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_store", "pic_bg")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `pic_bg` varchar(200) DEFAULT NULL COMMENT '背景图';");
}
if(!pdo_fieldexists("yztc_sun_store", "wechat_number")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `wechat_number` varchar(60) DEFAULT '' COMMENT '微信号';");
}
if(!pdo_fieldexists("yztc_sun_store", "goods_count")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `goods_count` int(11) DEFAULT '0' COMMENT '商品数量';");
}
if(!pdo_fieldexists("yztc_sun_store", "sale_count")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `sale_count` int(11) DEFAULT '0' COMMENT '已售商品数量';");
}
if(!pdo_fieldexists("yztc_sun_store", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `end_time` int(11) DEFAULT NULL COMMENT '过期时间';");
}
if(!pdo_fieldexists("yztc_sun_store", "details")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `details` text COMMENT '商铺描述-卖什么东西';");
}
if(!pdo_fieldexists("yztc_sun_store", "contact")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `contact` varchar(60) DEFAULT '' COMMENT '联系人';");
}
if(!pdo_fieldexists("yztc_sun_store", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `user_id` int(11) DEFAULT '0' COMMENT '申请人id';");
}
if(!pdo_fieldexists("yztc_sun_store", "fail_reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `fail_reason` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_store", "popularity")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `popularity` int(11) NOT NULL DEFAULT '0' COMMENT '人气值';");
}
if(!pdo_fieldexists("yztc_sun_store", "logo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `logo` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_store", "cat_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id';");
}
if(!pdo_fieldexists("yztc_sun_store", "district_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `district_id` int(11) NOT NULL DEFAULT '0' COMMENT '商圈id';");
}
if(!pdo_fieldexists("yztc_sun_store", "is_recommend")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `is_recommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐 1推荐 集市推荐显示';");
}
if(!pdo_fieldexists("yztc_sun_store", "business_range")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `business_range` varchar(100) DEFAULT NULL COMMENT '营业时间';");
}
if(!pdo_fieldexists("yztc_sun_store", "per_consumption")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `per_consumption` varchar(10) DEFAULT NULL COMMENT '人均消费';");
}
if(!pdo_fieldexists("yztc_sun_store", "storeopen_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `storeopen_id` int(11) DEFAULT NULL COMMENT '开通申请入驻id';");
}
if(!pdo_fieldexists("yztc_sun_store", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `sort` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_store", "distribution_open")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `distribution_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启分销 1开启';");
}
if(!pdo_fieldexists("yztc_sun_store", "commissiontype")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `commissiontype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1百分比  2固定金额';");
}
if(!pdo_fieldexists("yztc_sun_store", "first_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额';");
}
if(!pdo_fieldexists("yztc_sun_store", "second_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额';");
}
if(!pdo_fieldexists("yztc_sun_store", "third_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `third_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级金额';");
}
if(!pdo_fieldexists("yztc_sun_store", "star")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `star` int(11) NOT NULL DEFAULT '1' COMMENT '星级';");
}
if(!pdo_fieldexists("yztc_sun_store", "service")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `service` varchar(255) DEFAULT NULL COMMENT '服务设施';");
}
if(!pdo_fieldexists("yztc_sun_store", "quality_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `quality_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '品质商家';");
}
if(!pdo_fieldexists("yztc_sun_store", "icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `icon` varchar(200) DEFAULT NULL COMMENT '首页菜单图标';");
}
if(!pdo_fieldexists("yztc_sun_store", "banner")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `banner` text COMMENT '详情页banner';");
}
if(!pdo_fieldexists("yztc_sun_store", "posterpic")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `posterpic` varchar(200) DEFAULT NULL COMMENT '海报图';");
}
if(!pdo_fieldexists("yztc_sun_store", "store_wechat")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `store_wechat` varchar(200) DEFAULT NULL COMMENT '商家微信图';");
}
if(!pdo_fieldexists("yztc_sun_store", "detail_qrcode")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_store")." ADD   `detail_qrcode` varchar(200) DEFAULT NULL COMMENT '详情二维码';");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "parent_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级(上一级)分类id';");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `name` varchar(60) DEFAULT NULL COMMENT '名称';");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `icon` varchar(250) DEFAULT NULL COMMENT '分类图标';");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用状态';");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "is_del")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 1删除';");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "delete_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `delete_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storecategory", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storecategory")." ADD   `sort` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storedistrict", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storedistrict")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_storedistrict", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storedistrict")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storedistrict", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storedistrict")." ADD   `name` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storedistrict", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storedistrict")." ADD   `state` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_storedistrict", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storedistrict")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storedistrict", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storedistrict")." ADD   `sort` int(11) NOT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1申请入驻 2续费';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "order_no")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `order_no` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "transaction_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `transaction_id` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `name` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "contact")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `contact` varchar(30) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "tel")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `tel` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "pay_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `pay_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1微信支付 2余额支付 3免费';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "lng")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `lng` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "lat")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `lat` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "logo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `logo` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "pay_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1支付';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "pay_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `pay_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "reason")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `reason` varchar(200) DEFAULT NULL COMMENT '失败原因';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "review_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `review_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "refund_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `refund_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "cid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `cid` int(11) NOT NULL DEFAULT '0' COMMENT '充值id';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "day_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `day_num` int(11) NOT NULL DEFAULT '0' COMMENT '天数';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "refund_apply_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `refund_apply_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退款申请 审核失败 1退款申请';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "refund_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1退款成功 2退款失败';");
}
if(!pdo_fieldexists("yztc_sun_storeopen", "price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeopen")." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00';");
}
if(!pdo_fieldexists("yztc_sun_storerecharge", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storerecharge")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_storerecharge", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storerecharge")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storerecharge", "days")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storerecharge")." ADD   `days` int(10) NOT NULL DEFAULT '0' COMMENT '天数';");
}
if(!pdo_fieldexists("yztc_sun_storerecharge", "price")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storerecharge")." ADD   `price` decimal(15,2) DEFAULT NULL COMMENT '充值活动';");
}
if(!pdo_fieldexists("yztc_sun_storerecharge", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storerecharge")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storerecharge", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storerecharge")." ADD   `state` int(4) NOT NULL DEFAULT '1' COMMENT '1启用';");
}
if(!pdo_fieldexists("yztc_sun_storerecharge", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storerecharge")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeuser", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeuser")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_storeuser", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeuser")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeuser", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeuser")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeuser", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeuser")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_storeuser", "memo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeuser")." ADD   `memo` varchar(255) DEFAULT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("yztc_sun_storeuser", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeuser")." ADD   `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用';");
}
if(!pdo_fieldexists("yztc_sun_storeuser", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeuser")." ADD   `store_id` int(11) DEFAULT '0' COMMENT '商家id';");
}
if(!pdo_fieldexists("yztc_sun_storeuser", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_storeuser")." ADD   `user_id` int(11) DEFAULT '0' COMMENT '用户id';");
}
if(!pdo_fieldexists("yztc_sun_system", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("yztc_sun_system", "appid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `appid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appid';");
}
if(!pdo_fieldexists("yztc_sun_system", "appsecret")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `appsecret` varchar(200) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appsecret';");
}
if(!pdo_fieldexists("yztc_sun_system", "mchid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `mchid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户号';");
}
if(!pdo_fieldexists("yztc_sun_system", "wxkey")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `wxkey` varchar(250) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户秘钥';");
}
if(!pdo_fieldexists("yztc_sun_system", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_system", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `create_time` int(20) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("yztc_sun_system", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `update_time` int(20) DEFAULT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists("yztc_sun_system", "apiclient_cert")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `apiclient_cert` text COMMENT '支付密钥退款发红包提现使用';");
}
if(!pdo_fieldexists("yztc_sun_system", "apiclient_key")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `apiclient_key` text COMMENT '支付密钥退款发红包提现使用';");
}
if(!pdo_fieldexists("yztc_sun_system", "pt_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `pt_name` varchar(30) DEFAULT NULL COMMENT '平台名称';");
}
if(!pdo_fieldexists("yztc_sun_system", "index_title")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `index_title` varchar(60) DEFAULT NULL COMMENT '首页自定义标题';");
}
if(!pdo_fieldexists("yztc_sun_system", "ht_title")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `ht_title` varchar(60) DEFAULT NULL COMMENT '后台顶部自定义标题';");
}
if(!pdo_fieldexists("yztc_sun_system", "tel")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `tel` varchar(20) DEFAULT NULL COMMENT '客服联系电话';");
}
if(!pdo_fieldexists("yztc_sun_system", "fontcolor")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `fontcolor` varchar(20) DEFAULT '#000000' COMMENT '平台顶部文字颜色(只有黑白)';");
}
if(!pdo_fieldexists("yztc_sun_system", "top_color")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `top_color` varchar(20) DEFAULT '#ffffff' COMMENT '平台顶部风格颜色';");
}
if(!pdo_fieldexists("yztc_sun_system", "bottom_color")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `bottom_color` varchar(20) DEFAULT '#ffffff' COMMENT '平台底部风格颜色';");
}
if(!pdo_fieldexists("yztc_sun_system", "jszc_show")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `jszc_show` int(4) NOT NULL DEFAULT '0' COMMENT '技术支持开关 1开 2关';");
}
if(!pdo_fieldexists("yztc_sun_system", "jszc_tel")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `jszc_tel` varchar(20) DEFAULT NULL COMMENT '技术支持-电话';");
}
if(!pdo_fieldexists("yztc_sun_system", "jszc_img")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `jszc_img` varchar(200) DEFAULT NULL COMMENT '技术支持-头像';");
}
if(!pdo_fieldexists("yztc_sun_system", "jszc_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `jszc_name` varchar(50) DEFAULT NULL COMMENT '技术支持-团队名称';");
}
if(!pdo_fieldexists("yztc_sun_system", "receipt_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `receipt_num` int(11) NOT NULL DEFAULT '10' COMMENT '收货时间(从发货到自动确认收货的时间)';");
}
if(!pdo_fieldexists("yztc_sun_system", "after_sale_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `after_sale_num` int(11) NOT NULL DEFAULT '7' COMMENT '售后时间';");
}
if(!pdo_fieldexists("yztc_sun_system", "send_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `send_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '发货方式 1快递或自提 2仅快递 3仅自提';");
}
if(!pdo_fieldexists("yztc_sun_system", "integral_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `integral_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '积分开启状态 1开启';");
}
if(!pdo_fieldexists("yztc_sun_system", "integral_rate1")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `integral_rate1` int(11) NOT NULL DEFAULT '1' COMMENT '积分比例商家比例 ';");
}
if(!pdo_fieldexists("yztc_sun_system", "integral_rate2")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `integral_rate2` int(11) NOT NULL DEFAULT '1' COMMENT '积分比例赠送积分比例 当integral_rate1为1 integral_rate2为2时消费1元获得2积分';");
}
if(!pdo_fieldexists("yztc_sun_system", "is_open_member")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `is_open_member` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启会员功能 1开启';");
}
if(!pdo_fieldexists("yztc_sun_system", "member_info")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `member_info` text COMMENT '会员须知';");
}
if(!pdo_fieldexists("yztc_sun_system", "bottom_fontcolor_a")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `bottom_fontcolor_a` varchar(20) DEFAULT NULL COMMENT '底部导航文字选中前颜色';");
}
if(!pdo_fieldexists("yztc_sun_system", "bottom_fontcolor_b")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `bottom_fontcolor_b` varchar(20) DEFAULT NULL COMMENT '底部导航文字选中后颜色';");
}
if(!pdo_fieldexists("yztc_sun_system", "menu_fontcolor_a")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `menu_fontcolor_a` varchar(20) DEFAULT NULL COMMENT '菜单图标文字选中前颜色';");
}
if(!pdo_fieldexists("yztc_sun_system", "menu_fontcolor_b")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `menu_fontcolor_b` varchar(20) DEFAULT NULL COMMENT '菜单图标文字选中后颜色';");
}
if(!pdo_fieldexists("yztc_sun_system", "personcenter_color_b")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `personcenter_color_b` varchar(20) DEFAULT NULL COMMENT '个人中心顶部背景';");
}
if(!pdo_fieldexists("yztc_sun_system", "map_key")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `map_key` varchar(60) DEFAULT NULL COMMENT '腾讯地图key';");
}
if(!pdo_fieldexists("yztc_sun_system", "ak")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `ak` varchar(60) DEFAULT NULL COMMENT '百度地图key(天气)';");
}
if(!pdo_fieldexists("yztc_sun_system", "poster_goods")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `poster_goods` varchar(200) DEFAULT NULL COMMENT '商品海报';");
}
if(!pdo_fieldexists("yztc_sun_system", "show_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `show_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1功能 2圈子 3商家';");
}
if(!pdo_fieldexists("yztc_sun_system", "weather_icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `weather_icon` varchar(200) DEFAULT NULL COMMENT '天气图标';");
}
if(!pdo_fieldexists("yztc_sun_system", "showcheck")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `showcheck` tinyint(4) NOT NULL DEFAULT '0' COMMENT '过审开关 1开启';");
}
if(!pdo_fieldexists("yztc_sun_system", "version")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `version` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_system", "mine_bg")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   `mine_bg` varchar(200) DEFAULT NULL COMMENT '我的背景';");
}
if(!pdo_fieldexists("yztc_sun_system", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_system")." ADD   UNIQUE KEY `id` (`id`) USING BTREE;");
}
if(!pdo_fieldexists("yztc_sun_task", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_task", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_task", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `type` varchar(100) DEFAULT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("yztc_sun_task", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_task", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_task", "memo")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `memo` varchar(255) DEFAULT NULL COMMENT '备注';");
}
if(!pdo_fieldexists("yztc_sun_task", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `state` int(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用';");
}
if(!pdo_fieldexists("yztc_sun_task", "level")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `level` int(11) DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_task", "value")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `value` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_task", "execute_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `execute_time` int(11) DEFAULT NULL COMMENT '预计执行时间';");
}
if(!pdo_fieldexists("yztc_sun_task", "execute_times")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_task")." ADD   `execute_times` int(11) DEFAULT '0' COMMENT '尝试执行次数';");
}
if(!pdo_fieldexists("yztc_sun_template", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_template")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_template", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_template")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_template", "tid1")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_template")." ADD   `tid1` varchar(50) DEFAULT NULL COMMENT '支付通知';");
}
if(!pdo_fieldexists("yztc_sun_template", "tid2")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_template")." ADD   `tid2` varchar(50) DEFAULT NULL COMMENT '订单取消';");
}
if(!pdo_fieldexists("yztc_sun_template", "tid3")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_template")." ADD   `tid3` varchar(50) DEFAULT NULL COMMENT '发货通知';");
}
if(!pdo_fieldexists("yztc_sun_template", "tid4")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_template")." ADD   `tid4` varchar(50) DEFAULT NULL COMMENT '退款通知';");
}
if(!pdo_fieldexists("yztc_sun_template", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_template")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_template", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_template")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_user", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("yztc_sun_user", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `openid` varchar(100) DEFAULT NULL COMMENT 'openid';");
}
if(!pdo_fieldexists("yztc_sun_user", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `avatar` varchar(200) DEFAULT NULL COMMENT '头像';");
}
if(!pdo_fieldexists("yztc_sun_user", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_user", "tel")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `tel` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_user", "address")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `address` varchar(200) DEFAULT NULL COMMENT '地址';");
}
if(!pdo_fieldexists("yztc_sun_user", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `nickname` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称';");
}
if(!pdo_fieldexists("yztc_sun_user", "birthday")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `birthday` varchar(40) DEFAULT NULL COMMENT '生日';");
}
if(!pdo_fieldexists("yztc_sun_user", "gender")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `gender` int(1) DEFAULT '0' COMMENT '性别';");
}
if(!pdo_fieldexists("yztc_sun_user", "email")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `email` varchar(40) DEFAULT NULL COMMENT '邮箱';");
}
if(!pdo_fieldexists("yztc_sun_user", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `create_time` int(20) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists("yztc_sun_user", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `update_time` int(20) DEFAULT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists("yztc_sun_user", "login_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `login_time` int(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_user", "login_ip")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `login_ip` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_user", "integral")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `integral` int(10) NOT NULL DEFAULT '0' COMMENT '总积分';");
}
if(!pdo_fieldexists("yztc_sun_user", "now_integral")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `now_integral` int(11) DEFAULT '0' COMMENT '现有积分';");
}
if(!pdo_fieldexists("yztc_sun_user", "balance")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户充值余额';");
}
if(!pdo_fieldexists("yztc_sun_user", "is_member")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `is_member` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_user", "total_consume")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `total_consume` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计消费金额';");
}
if(!pdo_fieldexists("yztc_sun_user", "memberconf_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `memberconf_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级id';");
}
if(!pdo_fieldexists("yztc_sun_user", "discount")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `discount` decimal(10,1) DEFAULT '0.0' COMMENT '开启vip会员折扣';");
}
if(!pdo_fieldexists("yztc_sun_user", "share_user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `share_user_id` int(11) DEFAULT '0' COMMENT '分享人id';");
}
if(!pdo_fieldexists("yztc_sun_user", "last_share_user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `last_share_user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_user", "first_share_user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `first_share_user_id` int(11) DEFAULT NULL COMMENT '最早推荐人id';");
}
if(!pdo_fieldexists("yztc_sun_user", "vip_cardnum")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `vip_cardnum` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_user", "vip_endtime")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `vip_endtime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_user", "parents_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `parents_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销上级id';");
}
if(!pdo_fieldexists("yztc_sun_user", "parents_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   `parents_name` varchar(60) DEFAULT NULL COMMENT '分销上级名称';");
}
if(!pdo_fieldexists("yztc_sun_user", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_user")." ADD   UNIQUE KEY `id` (`id`) USING BTREE;");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `user_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `store_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "sign")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `sign` tinyint(4) DEFAULT NULL COMMENT '1充值 2支付';");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "remark")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `remark` varchar(200) DEFAULT NULL COMMENT '备注：商品名称、充值内容之类';");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额（充值含赠送）';");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "send_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `send_money` decimal(10,2) DEFAULT '0.00' COMMENT '充值赠送的金额';");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "now_balance")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `now_balance` decimal(10,2) DEFAULT '0.00' COMMENT '当前余额';");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "title")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `title` varchar(100) DEFAULT NULL COMMENT '名称';");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "order_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `order_id` int(60) DEFAULT NULL COMMENT '订单id';");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "order_num")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `order_num` varchar(200) DEFAULT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists("yztc_sun_userbalancerecord", "order_sign")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userbalancerecord")." ADD   `order_sign` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单标识 1普通订单 2合并订单';");
}
if(!pdo_fieldexists("yztc_sun_userprivilege", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userprivilege")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_userprivilege", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userprivilege")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_userprivilege", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userprivilege")." ADD   `name` varchar(60) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_userprivilege", "icon")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userprivilege")." ADD   `icon` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_userprivilege", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userprivilege")." ADD   `state` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_userprivilege", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userprivilege")." ADD   `sort` int(11) NOT NULL DEFAULT '255';");
}
if(!pdo_fieldexists("yztc_sun_userprivilege", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_userprivilege")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `name` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "sort")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `sort` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "day")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `day` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `money` decimal(10,2) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `state` tinyint(1) DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "stock")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `stock` int(11) DEFAULT '0' COMMENT '库存';");
}
if(!pdo_fieldexists("yztc_sun_vipcard", "salenum")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcard")." ADD   `salenum` int(11) DEFAULT '0' COMMENT '已售数量';");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `code` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "isuse")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `isuse` tinyint(1) DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "usetime")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `usetime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "create_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `create_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "day")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `day` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `state` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `user_id` int(11) DEFAULT '0' COMMENT '使用人';");
}
if(!pdo_fieldexists("yztc_sun_vipcode", "update_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_vipcode")." ADD   `update_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `openid` varchar(255) DEFAULT NULL COMMENT '提现openid';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现全额';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "wd_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `wd_type` tinyint(4) DEFAULT NULL COMMENT '提现方式 1微信';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "wd_account")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `wd_account` varchar(100) DEFAULT NULL COMMENT '提现账号';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "wd_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `wd_name` varchar(255) DEFAULT NULL COMMENT '提现姓名';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "wd_phone")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `wd_phone` varchar(255) DEFAULT NULL COMMENT '提现手机号';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提现状态 1成功 2失败';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "realmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "paycommission")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "ratesmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "store_name")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `store_name` varchar(100) DEFAULT NULL COMMENT '商家名称';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "baowen")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `baowen` text COMMENT '提现报文';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "add_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `add_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "is_state")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `is_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0不需要审核 1需要审核';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "err_code")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `err_code` varchar(50) DEFAULT NULL COMMENT '提现错误码';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "err_code_des")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `err_code_des` varchar(200) DEFAULT NULL COMMENT '失败原因';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "tx_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `tx_time` int(11) DEFAULT NULL COMMENT '提现时间';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "request_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `request_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "del_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "review_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `review_time` int(11) DEFAULT NULL COMMENT '审核时间';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "return_status")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `return_status` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("yztc_sun_withdraw", "return_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdraw")." ADD   `return_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 商家提现报文信息记录 1合伙人提现报文记录';");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "openid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `openid` varchar(30) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "store_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `store_id` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额';");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "baowen")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `baowen` text;");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "wd_id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `wd_id` int(11) DEFAULT NULL COMMENT '提现id';");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "add_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `add_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdrawbaowen", "request_data")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawbaowen")." ADD   `request_data` text COMMENT '请求数据';");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "id")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "wd_type")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `wd_type` varchar(255) NOT NULL DEFAULT '1' COMMENT '提现方式 1微信提现';");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "min_money")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `min_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额';");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "avoidmoney")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `avoidmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额';");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "is_open")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `is_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现开关 1开 2关';");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "cms_rates")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `cms_rates` float NOT NULL DEFAULT '0' COMMENT '平台抽成比率';");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "wd_wxrates")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `wd_wxrates` float NOT NULL DEFAULT '0' COMMENT '微信提现手续费费率';");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "wd_content")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `wd_content` text COMMENT '提现须知';");
}
if(!pdo_fieldexists("yztc_sun_withdrawset", "add_time")) {
 pdo_query("ALTER TABLE ".tablename("yztc_sun_withdrawset")." ADD   `add_time` int(11) DEFAULT NULL;");
}

 ?>