<?php
pdo_query("DROP TABLE IF EXISTS `ims_xc_xinguwu_address`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_address` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(50) NOT NULL COMMENT '姓名',
`phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
`region` varchar(50) NOT NULL COMMENT '省市区',
`detail` varchar(255) NOT NULL COMMENT '地址详情',
`ison` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否设为默认地址',
`openid` varchar(40) NOT NULL COMMENT '用户id',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_autonum`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_autonum` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`num` int(11) DEFAULT NULL DEFAULT '0',
`keyval` varchar(20) DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `uniacid` (`uniacid`,`keyval`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_bargain`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_bargain` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
`attr_name` varchar(50) NOT NULL COMMENT '属性名称',
`floor_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '底价',
`bargain_range` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价范围',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`time_range` int(11) NOT NULL DEFAULT '0' COMMENT '时间限制(分)',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`good_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品显示价格',
`good_name` varchar(255) NOT NULL COMMENT '商品名称',
`number` int(11) NOT NULL DEFAULT '0' COMMENT '砍价人数',
`limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '数量限制',
`isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示',
`share` varchar(500) NOT NULL COMMENT '分享内容',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_bargain_self`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_bargain_self` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`bargain_id` int(11) NOT NULL DEFAULT '0' COMMENT '砍价列表id',
`new_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前的价格',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态(1进行中,2已砍至低价,3已失效,4已交易)',
`avatarurl` varchar(255) NOT NULL COMMENT '头像',
`nickname` varchar(255) NOT NULL COMMENT '昵称',
`endtime` datetime DEFAULT NULL COMMENT '结束时间',
PRIMARY KEY (`id`),
KEY `openid` (`openid`,`bargain_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_bargain_self_log`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_bargain_self_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`bargain_self_id` int(11) NOT NULL DEFAULT '0' COMMENT '发起砍价id',
`nickname` varchar(255) NOT NULL COMMENT '昵称',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`cut_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '帮砍的金额',
`avatarurl` varchar(255) NOT NULL COMMENT '头像',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
PRIMARY KEY (`id`),
KEY `bargain_self_id` (`bargain_self_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_brokerage_order`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_brokerage_order` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`order` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单价格',
`get_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返佣',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态1已付款2已完成',
`isoff` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否已失效',
PRIMARY KEY (`id`),
KEY `openid` (`openid`),
KEY `order` (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_category`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_category` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL COMMENT '类别名称',
`uniacid` int(11) DEFAULT NULL,
`father_id` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`modifytime` datetime DEFAULT NULL COMMENT '修改时间',
`feature` int(11) NOT NULL DEFAULT '0' COMMENT '规格 id',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_club`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_club` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态1正常2申请-1关闭',
`title` varchar(255) NOT NULL COMMENT '社团名称',
`name` varchar(255) NOT NULL COMMENT '姓名',
`phone` varchar(11) DEFAULT NULL COMMENT '联系方式',
`region` varchar(50) NOT NULL COMMENT '省市区',
`detail` varchar(255) NOT NULL COMMENT '详细地址',
`longitude` varchar(255) NOT NULL COMMENT '经度',
`latitude` varchar(255) NOT NULL COMMENT '纬度',
`modifytime` datetime DEFAULT NULL COMMENT '修改日志',
`brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金',
`totalbrokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金',
`number` int(11) NOT NULL DEFAULT '0' COMMENT '成交单数',
`avatar` varchar(255) DEFAULT NULL,
`remark` varchar(255) NOT NULL COMMENT '备注(服务时间)',
`formid` text DEFAULT NULL COMMENT '模版消息id',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_club_brokerage`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_club_brokerage` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) DEFAULT NULL,
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1收入-1支出',
`remark` varchar(255) NOT NULL COMMENT '备注',
`fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动',
`now_brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动之后的佣金',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态2申请',
`avatarurl` varchar(255) NOT NULL COMMENT '头像',
`nickname` varchar(255) NOT NULL COMMENT '昵称',
`order` varchar(20) NOT NULL COMMENT '单号',
`deposit_time` datetime DEFAULT NULL COMMENT '提现时间',
`alipay` varchar(50) NOT NULL COMMENT '支付宝账号',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_club_label`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_club_label` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1几日达',
`name` varchar(50) NOT NULL COMMENT '名称',
`tip` varchar(50) NOT NULL COMMENT '说明',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`modifytime` varchar(50) NOT NULL COMMENT '修改时间',
`start` int(11) NOT NULL DEFAULT '0',
`end` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_club_member`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_club_member` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`name` varchar(255) NOT NULL COMMENT '姓名',
`phone` varchar(11) NOT NULL COMMENT '联系方式',
`region` varchar(50) NOT NULL COMMENT '地址',
`brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成交佣金',
`number` int(11) NOT NULL DEFAULT '0' COMMENT '消费单数',
`detail` varchar(255) NOT NULL COMMENT '地址详情',
`club_id` int(11) NOT NULL DEFAULT '0' COMMENT '团长id',
PRIMARY KEY (`id`),
KEY `club_id` (`club_id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_club_statistics`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_club_statistics` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金',
`number` int(11) NOT NULL DEFAULT '0' COMMENT '成交单数',
`date` date DEFAULT NULL COMMENT '日期',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`club_id` int(11) NOT NULL DEFAULT '0' COMMENT '社团id',
PRIMARY KEY (`id`),
KEY `club_id` (`club_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_club_statistics_day`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_club_statistics_day` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`club_id` int(11) NOT NULL DEFAULT '0',
`good_name` varchar(255) NOT NULL,
`good_id` int(11) NOT NULL DEFAULT '0',
`num` int(11) DEFAULT NULL DEFAULT '0',
`date` date DEFAULT NULL,
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`img` varchar(255) DEFAULT NULL,
`brokerage` decimal(10,2) NOT NULL DEFAULT '0.00',
PRIMARY KEY (`id`),
KEY `club_id` (`club_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_club_statistics_month`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_club_statistics_month` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`club_id` int(11) NOT NULL DEFAULT '0',
`good_name` varchar(255) NOT NULL,
`good_id` int(11) NOT NULL DEFAULT '0',
`date` date DEFAULT NULL,
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`num` int(11) NOT NULL DEFAULT '0',
`img` varchar(255) DEFAULT NULL,
`brokerage` decimal(10,2) NOT NULL DEFAULT '0.00',
PRIMARY KEY (`id`),
KEY `club_id` (`club_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_club_statistics_total`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_club_statistics_total` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) DEFAULT NULL,
`club_id` int(11) NOT NULL DEFAULT '0' COMMENT '社团id',
`good_name` varchar(255) NOT NULL COMMENT '商品名称',
`num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
`img` varchar(255) DEFAULT NULL,
`brokerage` decimal(10,2) NOT NULL DEFAULT '0.00',
PRIMARY KEY (`id`),
KEY `club_id` (`club_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_club_statistics_week`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_club_statistics_week` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`club_id` int(11) NOT NULL DEFAULT '0',
`good_name` varchar(255) NOT NULL,
`good_id` int(11) NOT NULL DEFAULT '0',
`date` date DEFAULT NULL,
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`num` int(11) NOT NULL DEFAULT '0',
`img` varchar(255) DEFAULT NULL,
`brokerage` decimal(10,2) NOT NULL DEFAULT '0.00',
PRIMARY KEY (`id`),
KEY `club_id` (`club_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_comment`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_comment` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
`good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
`text` varchar(255) NOT NULL COMMENT '文本',
`imgs` text DEFAULT NULL COMMENT '图集',
`anonymity` tinyint(3) NOT NULL DEFAULT '0' COMMENT '匿名',
`goodcom` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1非常差2差3一般4好5非常好',
`service_attitude` int(11) NOT NULL DEFAULT '0' COMMENT '服务态度',
`logistics_speed` tinyint(3) NOT NULL DEFAULT '0' COMMENT '发货速度',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`reply` varchar(255) NOT NULL COMMENT '商家回复',
`nickname` varchar(255) NOT NULL COMMENT '昵称',
`avatarurl` varchar(255) NOT NULL COMMENT '头像',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_deposit_log`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_deposit_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`order` bigint(20) NOT NULL DEFAULT '0' COMMENT '商户订单号',
`amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
`desc` varchar(255) NOT NULL COMMENT '备注',
`payment_no` varchar(50) NOT NULL COMMENT '微信订单号',
`payment_time` datetime DEFAULT NULL COMMENT '微信支付时间',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`wechat` varchar(255) NOT NULL COMMENT '微信号',
`name` varchar(255) NOT NULL COMMENT '真实姓名',
`alipay` varchar(50) NOT NULL COMMENT '支付宝账号',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_distribution`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_distribution` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`name` varchar(255) NOT NULL COMMENT '姓名',
`wechat` varchar(255) NOT NULL COMMENT '微信号',
`phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '我的佣金',
`brokerage_yet` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现佣金',
`order_num` int(11) NOT NULL DEFAULT '0' COMMENT '分销订单数',
`log_num` int(11) NOT NULL DEFAULT '0' COMMENT '提现记录数',
`team_num` int(11) NOT NULL DEFAULT '0' COMMENT '团队数',
`brokerage_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计佣金',
`formid` text DEFAULT NULL COMMENT '模版消息id',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_feature`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_feature` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(50) NOT NULL COMMENT '属性名',
`value` varchar(500) DEFAULT NULL COMMENT '特征值',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_flashsale`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_flashsale` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`date_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
`date_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
`contents` longtext DEFAULT NULL COMMENT '内容',
`good_ids` varchar(1000) DEFAULT NULL,
`isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示 (单选)',
PRIMARY KEY (`id`),
KEY `date_start` (`date_start`,`date_end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_goods`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_goods` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(100) NOT NULL COMMENT '商品名称',
`cid` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类',
`bimg` varchar(255) NOT NULL COMMENT '商品图片  方图',
`simg` varchar(255) NOT NULL COMMENT '商品图片   长图',
`number` int(11) NOT NULL DEFAULT '0' COMMENT '销售量',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商品状态',
`contents` longtext DEFAULT NULL COMMENT '商品详情',
`attrs` text DEFAULT NULL COMMENT '商品属性',
`prices` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格(显示用途)',
`unit` varchar(10) NOT NULL COMMENT '单位',
`modifytime` datetime DEFAULT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
`attr_name` varchar(50) NOT NULL COMMENT '属性名称',
`imgs` text NOT NULL COMMENT '商品图集',
`oprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价(仅用于显示)',
`weight` int(11) NOT NULL DEFAULT '0' COMMENT '商品重量(g)',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`video` varchar(255) NOT NULL COMMENT '视频地址',
`is_flash` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否抢购',
`flash_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '抢购id',
`param` text DEFAULT NULL COMMENT '商品参数',
`share` varchar(500) NOT NULL COMMENT '分享设置',
`isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示',
`brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '所值佣金',
`brokerage_two` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
`brokerage_there` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级级佣金',
`club_brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团长佣金',
`arrive` int(11) NOT NULL DEFAULT '0' COMMENT '几日达标签id',
`presell` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '预售',
`presell_time` date DEFAULT NULL COMMENT '预售时间',
`supplier` varchar(255) NOT NULL COMMENT '供应商id集合',
`content` longtext DEFAULT NULL COMMENT '内容(手机管理端添加)',
`vprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员折扣',
`tagsids` varchar(1000) NOT NULL COMMENT '标签',
`ecid` int(11) DEFAULT NULL DEFAULT '1' COMMENT '1 pc -1手机',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_group_order`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_group_order` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`order` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号',
`list` text DEFAULT NULL COMMENT '订单信息',
`detail` varchar(255) NOT NULL COMMENT '地址信息',
`paytype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式1余额2微信3抵扣4线下',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单状态1未付款2待发货3已发货4已收货',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`paytime` datetime DEFAULT NULL COMMENT '支付时间',
`price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额(含邮费)',
`remark` varchar(255) NOT NULL COMMENT '备注',
`totalnum` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
`payid` varchar(100) NOT NULL COMMENT '用于发送模板消息',
`pay_wechat` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '微信支付',
`pay_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额支付',
`delive_time` datetime DEFAULT NULL COMMENT '发货时间',
`name` varchar(50) NOT NULL COMMENT '姓名',
`phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
`region` varchar(255) NOT NULL COMMENT '省市区',
`express` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递费用',
`order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
`express_number` varchar(255) NOT NULL COMMENT '快递单号',
`express_name` varchar(50) NOT NULL COMMENT '快递名称',
`value` varchar(500) NOT NULL COMMENT '信息',
`score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
`formid` varchar(255) NOT NULL COMMENT '用于发送模板消息',
`express_code` varchar(50) NOT NULL COMMENT '快递公司编码',
`group_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '团状态 1组团中2成功-1失败',
`out_refund_no` varchar(100) NOT NULL COMMENT '商户退款单号',
PRIMARY KEY (`id`),
KEY `openid` (`openid`,`order`),
KEY `order` (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_group_sponsor`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_group_sponsor` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`group_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购列表id',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`join_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '参团人数',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`scale` tinyint(3) NOT NULL DEFAULT '0' COMMENT '拼团规模',
`avatarurl` varchar(255) NOT NULL COMMENT '头像',
`nickname` varchar(255) NOT NULL COMMENT '名称',
`endtime` datetime DEFAULT NULL COMMENT '结束时间',
PRIMARY KEY (`id`),
KEY `openid` (`openid`),
KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_group_tuxedo`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_group_tuxedo` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`avatarurl` varchar(255) NOT NULL COMMENT '头像',
`nickname` varchar(255) NOT NULL COMMENT '昵称',
`group_sponsor_id` int(11) NOT NULL DEFAULT '0' COMMENT '发起id',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态(1组团中2组团成功 -1 失败)',
`order` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单号',
`ishost` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否团主',
`group_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购列表id',
PRIMARY KEY (`id`),
KEY `openid` (`openid`),
KEY `group_sponsor_id` (`group_sponsor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_groupbuy`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_groupbuy` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
`good_name` varchar(255) NOT NULL COMMENT '商品名称',
`cid` int(11) NOT NULL DEFAULT '0' COMMENT '分类',
`old_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
`show_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '展示价',
`limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '限购数量',
`group_num` int(11) NOT NULL DEFAULT '0' COMMENT '已开团数量',
`pattern` tinyint(3) NOT NULL DEFAULT '0' COMMENT '开团模式 1普通2阶梯',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`attr` text DEFAULT NULL COMMENT '属性',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`modifytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
`duration` int(11) NOT NULL DEFAULT '0' COMMENT '持续时间分钟',
`tries` tinyint(3) NOT NULL DEFAULT '0' COMMENT '购买次数限制',
`deadline` datetime DEFAULT NULL COMMENT '活动截止时间',
`isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示',
PRIMARY KEY (`id`),
KEY `good_id` (`good_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_label`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_label` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL COMMENT '类别名称',
`uniacid` int(11) NOT NULL DEFAULT '0',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`modifytime` datetime DEFAULT NULL COMMENT '修改时间',
`imgurl` varchar(500) DEFAULT NULL,
`itype` int(11) DEFAULT NULL COMMENT '1产品，2固定链接',
`url` varchar(500) DEFAULT NULL COMMENT '链接',
`cid` int(11) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_labelclass`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_labelclass` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL COMMENT '类别名称',
`uniacid` int(11) NOT NULL DEFAULT '0',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`modifytime` datetime DEFAULT NULL COMMENT '修改时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_live`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_live` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`title` varchar(255) NOT NULL COMMENT '房间标题',
`stream` varchar(20) DEFAULT NULL COMMENT '流名称',
`pusher` varchar(255) NOT NULL COMMENT '推流地址',
`player` varchar(255) NOT NULL COMMENT '播放地址',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`img` varchar(255) NOT NULL COMMENT '图片',
`contents` text NOT NULL COMMENT '内容',
`isplay` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '1播放中-1空闲',
`name` varchar(255) NOT NULL COMMENT '使用者姓名',
`modifytime` datetime DEFAULT NULL COMMENT '修改时间',
`start_time` datetime DEFAULT NULL COMMENT '开始直播时间',
`end_time` datetime DEFAULT NULL COMMENT '结束直播时间',
`number` int(11) NOT NULL DEFAULT '0' COMMENT '观看人数',
`groupid` varchar(255) NOT NULL COMMENT '群组id',
`errmsg` varchar(255) NOT NULL COMMENT '回调信息',
`goods` varchar(255) NOT NULL COMMENT '商品ID集合',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_live_dialog`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_live_dialog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) DEFAULT NULL DEFAULT '0',
`live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间ID',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`fromAccountNick` varchar(255) DEFAULT NULL COMMENT '昵称',
`avatarurl` varchar(255) NOT NULL COMMENT '头像',
`content` varchar(255) NOT NULL COMMENT '内容',
`type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_live_dynamic`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_live_dynamic` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间id',
`contents` text DEFAULT NULL COMMENT '内容',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
PRIMARY KEY (`id`),
KEY `live_id` (`live_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_live_focus`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_live_focus` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间id',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
PRIMARY KEY (`id`),
KEY `openid` (`openid`),
KEY `live_id` (`live_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_live_playback`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_live_playback` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间id',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`video_url` varchar(255) NOT NULL COMMENT '回放地址',
`file_size` varchar(50) NOT NULL DEFAULT '0' COMMENT '大小 (字节)',
`file_id` varchar(100) NOT NULL COMMENT '点播file id',
`file_format` varchar(10) NOT NULL COMMENT '文件格式',
`duration` int(11) NOT NULL DEFAULT '0' COMMENT '推流时长(秒)',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`img` varchar(255) DEFAULT NULL,
`title` varchar(255) DEFAULT NULL,
`nickname` varchar(255) DEFAULT NULL,
`avatarurl` varchar(255) DEFAULT NULL,
`contents` text DEFAULT NULL,
`isshow` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '显示',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_member`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_member` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`nickname` varchar(255) NOT NULL COMMENT '昵称',
`avatarurl` varchar(255) NOT NULL COMMENT '头像',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`gender` tinyint(3) NOT NULL DEFAULT '0' COMMENT '性别',
`totalamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总共充值',
`amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现有余额',
`exp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '经验',
`score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
`totalscore` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '历史总积分',
`remarks` varchar(255) NOT NULL COMMENT '备注',
`modifytime` datetime DEFAULT NULL COMMENT '修改时间',
`level` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '等级(-1表示没有等级',
`one` varchar(40) NOT NULL DEFAULT '0' COMMENT '一级',
`two` varchar(40) NOT NULL DEFAULT '0' COMMENT '二级',
`there` varchar(40) NOT NULL DEFAULT '0' COMMENT '三级',
`garder` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销等级',
`one_order` int(11) NOT NULL DEFAULT '0' COMMENT '一级贡献订单',
`two_order` int(11) NOT NULL DEFAULT '0' COMMENT '二级贡献订单',
`there_order` int(11) NOT NULL DEFAULT '0' COMMENT '三级贡献订单',
`one_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级贡献佣金',
`two_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级贡献佣金',
`there_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级贡献佣金',
`is_distributor` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否为分销商',
`date` date DEFAULT NULL COMMENT '登录日志',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`admin` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '客服人员1是-1不是',
`admin1` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '员工',
`admin2` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '管理员',
`name` varchar(255) NOT NULL COMMENT '姓名',
`phone` varchar(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
`sig` varchar(500) NOT NULL COMMENT '云通信签名',
`sig_endtime` datetime DEFAULT NULL COMMENT '签名过期时间',
`is_club` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '团长',
`coin` int(11) NOT NULL DEFAULT '0' COMMENT '动力币',
`totalstep` int(11) NOT NULL DEFAULT '0' COMMENT '总步数',
`sport_remind` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '运动提醒',
`totalcoin` int(11) NOT NULL DEFAULT '0' COMMENT '总动力币',
`reach` int(11) NOT NULL DEFAULT '0' COMMENT '达标次数',
`attend` int(11) NOT NULL DEFAULT '0' COMMENT '参加次数',
`sport_avatars` int(11) NOT NULL DEFAULT '0' COMMENT '好友个数',
`is_supplier` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '供应商',
`pow` int(11) NOT NULL DEFAULT '0' COMMENT '调试',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_member_amount_log`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_member_amount_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0' COMMENT '模块',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`costsamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动金额',
`surplusamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余金额',
`remarks` varchar(255) DEFAULT NULL COMMENT '备注',
`itype` int(11) DEFAULT NULL DEFAULT '1' COMMENT '1收入，-1为支出',
`cid` int(11) DEFAULT NULL DEFAULT '1' COMMENT '1 用户操作 2管理员操作',
`opusername` varchar(255) DEFAULT NULL COMMENT '操作人',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_member_exp_log`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_member_exp_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '交易时间',
`costsexp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '获取经验',
`surplusexp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现在经验',
`remarks` varchar(255) NOT NULL COMMENT '备注',
`itype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1+ ;-1 -',
`cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1用户操作2管理员操作',
`opusername` varchar(255) NOT NULL COMMENT '操作人',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_member_score_log`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_member_score_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`costscore` decimal(10,2) DEFAULT NULL DEFAULT '0.00' COMMENT '消费积分',
`surplusscore` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余积分',
`remarks` varchar(255) NOT NULL COMMENT '备注',
`itype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1积分收入,-1积分支出',
`cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1用户操作2管理员操作',
`opusername` varchar(255) NOT NULL COMMENT '操作人',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_moban_user`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_moban_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) DEFAULT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`nickname` varchar(255) NOT NULL COMMENT '昵称',
`headimgurl` varchar(255) NOT NULL COMMENT '头像',
`status` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '状态',
`createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期',
`ident` varchar(50) NOT NULL COMMENT '标识',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_mycard`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_mycard` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`voucherid` int(11) NOT NULL DEFAULT '0' COMMENT '卡券id',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '领取时间',
`usetime` datetime DEFAULT NULL COMMENT '使用时间',
`remark` varchar(100) NOT NULL COMMENT '卡券使用备注',
`voucherstatus` tinyint(3) NOT NULL DEFAULT '0' COMMENT '卡券状态(1未使用,2已使用,3已过期)',
PRIMARY KEY (`id`),
KEY `openid` (`openid`,`voucherid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_online`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_online` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`member` int(11) NOT NULL DEFAULT '0' COMMENT '未读条数',
`type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
`content` longtext DEFAULT NULL COMMENT '内容',
`updatetime` varchar(50) DEFAULT NULL COMMENT '更新时间',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
PRIMARY KEY (`id`),
KEY `uniacid` (`uniacid`,`createtime`,`member`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_online_log`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_online_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`pid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1文本2图片',
`content` longtext DEFAULT NULL COMMENT '内容',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`duty` tinyint(3) NOT NULL DEFAULT '1' COMMENT '身份1客户 2客服',
PRIMARY KEY (`id`),
KEY `uniacid` (`uniacid`,`type`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_order`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_order` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户id',
`unionid` varchar(64) NOT NULL COMMENT '用户标识',
`order` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单号',
`list` text DEFAULT NULL COMMENT '订单信息',
`detail` varchar(255) NOT NULL COMMENT '地址信息',
`paytype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式1余额2微信3余额不足微信抵扣4线下支付',
`cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1 正常订单 2 积分订单4砍价6抢购',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单状态1未付款2待发货3待收货4退款5完成',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`paytime` datetime DEFAULT NULL COMMENT '支付时间',
`price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额(实付金额)',
`order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额(不含邮费)',
`express` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递费用',
`remark` varchar(255) NOT NULL COMMENT '备注',
`totalnum` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
`refund` tinyint(3) NOT NULL DEFAULT '0' COMMENT '退款状态(1申请2成功3拒绝)',
`refund_value` varchar(500) NOT NULL COMMENT '退款内容',
`payid` varchar(255) NOT NULL COMMENT '用于发送模板消息',
`pay_wechat` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '通过微信支付的金额',
`pay_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '通过余额支付的金额',
`myvoucher` int(11) NOT NULL DEFAULT '0' COMMENT '我的卡 id',
`deliver_time` datetime DEFAULT NULL COMMENT '发货时间',
`score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '赠送的积分数(所需的积分数)',
`refuse` varchar(500) NOT NULL COMMENT '拒绝退款理由',
`exp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '获得的经验',
`phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
`region` varchar(255) NOT NULL COMMENT '地址(省市区)',
`module` varchar(255) DEFAULT NULL COMMENT '用户支付回调验证(废弃)',
`name` varchar(255) NOT NULL COMMENT '收货人姓名',
`express_number` varchar(20) NOT NULL COMMENT '快递单号',
`express_name` varchar(255) NOT NULL COMMENT '快递公司名称',
`remind` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提醒发货',
`formid` varchar(255) NOT NULL COMMENT '表单id用于发送模板消息',
`express_code` varchar(50) NOT NULL COMMENT '快递公司编码',
`value` text NOT NULL COMMENT '信息',
`group_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '团购状态 1组团中 2组团成功 -1组团失败',
`out_refund_no` varchar(100) NOT NULL COMMENT '商户退款单号',
`vendor_remark` varchar(255) NOT NULL COMMENT '卖家备注',
`out_refund_time` datetime DEFAULT NULL COMMENT '退款成功时间',
`refund_error_msg` varchar(255) NOT NULL COMMENT '退款错误回调信息',
`community_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团点优惠',
`community_brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '社区团佣金',
`club_id` int(11) NOT NULL DEFAULT '0' COMMENT '团长id',
`hex` varchar(50) NOT NULL COMMENT '核销码',
`hex_time` datetime DEFAULT NULL COMMENT '核销时间',
`is_community` tinyint(3) NOT NULL DEFAULT '0' COMMENT '社区团',
`community_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '自提状态1待自提2已取货',
`comment` tinyint(3) DEFAULT NULL COMMENT '评价',
`pid` int(11) NOT NULL DEFAULT '0' COMMENT '针对限购产品',
`expires` int(11) NOT NULL DEFAULT '0' COMMENT '失效时间',
`activityid` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
`num` int(11) NOT NULL DEFAULT '0' COMMENT '主要针对 活动团购，限制抢购',
PRIMARY KEY (`id`),
KEY `openid` (`openid`,`order`),
KEY `order` (`order`),
KEY `club_id` (`club_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_other`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_other` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(50) NOT NULL COMMENT '名称',
`contents` longtext DEFAULT NULL COMMENT '内容',
`keyval` varchar(20) NOT NULL COMMENT '关键字',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`modifytime` datetime DEFAULT NULL COMMENT '修改时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_recharge`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_recharge` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
`score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
`exp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '经验',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1',
`tid` varchar(255) NOT NULL COMMENT '单号',
`payid` varchar(100) NOT NULL COMMENT '用于模板消息',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`paytime` datetime DEFAULT NULL COMMENT '支付时间',
`cid` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1用户2管理员',
`remark` text DEFAULT NULL COMMENT '备注',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_shop`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_shop` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(100) DEFAULT NULL COMMENT '商品名称',
`img` varchar(255) DEFAULT NULL COMMENT '商品图片',
`integral` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '所需积分',
`inventory` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
`recommend` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否推荐',
`hot` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否热门',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商品状态',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`bag` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否包邮',
`weight` int(11) DEFAULT NULL COMMENT '重量(g)',
`price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '所需金额',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_special`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_special` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(255) NOT NULL COMMENT '专题名称',
`img` varchar(255) NOT NULL COMMENT '展示图片',
`about` varchar(255) NOT NULL COMMENT '摘要',
`video_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '视频模式',
`video` varchar(255) NOT NULL COMMENT '视频地址',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`contents` longtext DEFAULT NULL COMMENT '内容',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`modifytime` datetime DEFAULT NULL COMMENT '修改时间',
`cid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
`ready` int(11) NOT NULL DEFAULT '0' COMMENT '阅读量',
`like` int(11) NOT NULL DEFAULT '0' COMMENT '点赞量',
`isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示',
`poster` varchar(255) NOT NULL COMMENT '视频封面',
`ad_img` varchar(255) NOT NULL COMMENT '广告图片',
`ad_link` varchar(255) NOT NULL COMMENT '广告跳转地址',
`recom` varchar(255) NOT NULL COMMENT '推荐商品',
PRIMARY KEY (`id`),
KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_special_like`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_special_like` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`special_id` int(11) NOT NULL DEFAULT '0' COMMENT '专题id',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1已点赞 -1 已取消点赞',
PRIMARY KEY (`id`),
KEY `openid` (`openid`,`special_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_specialclass`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_specialclass` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(50) NOT NULL COMMENT '专题名称',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_sport_chall`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_sport_chall` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`step` int(11) NOT NULL DEFAULT '0' COMMENT '步数',
`ticket` int(11) NOT NULL DEFAULT '0' COMMENT '门票',
`award` int(11) NOT NULL DEFAULT '0' COMMENT '奖励',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`modifytime` datetime DEFAULT NULL COMMENT '修改日志',
`title` varchar(50) NOT NULL COMMENT '标题',
`start_time` datetime DEFAULT NULL COMMENT '开始时间',
`end_time` datetime DEFAULT NULL COMMENT '结束时间',
`join_num` int(11) NOT NULL DEFAULT '0' COMMENT '参加人数',
`finish_num` int(11) DEFAULT NULL DEFAULT '0' COMMENT '完成人数',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_sport_chall_log`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_sport_chall_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`chall_id` int(11) NOT NULL DEFAULT '0' COMMENT '挑战项目id',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1进行中2已提交3超时',
`submission_time` datetime DEFAULT NULL COMMENT '提交时间',
`value` varchar(500) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `chall_id` (`chall_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_sport_coin_log`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_sport_coin_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '改变数值',
`title` varchar(255) NOT NULL COMMENT '标题',
`remark` varchar(255) NOT NULL COMMENT '备注',
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_sport_friend`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_sport_friend` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`openid` varchar(40) DEFAULT NULL,
`uniacid` int(11) NOT NULL DEFAULT '0',
`avatarurl` varchar(255) NOT NULL,
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_sport_good`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_sport_good` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(255) DEFAULT NULL COMMENT '商品名称',
`img` varchar(255) NOT NULL COMMENT '图片',
`imgs` text DEFAULT NULL COMMENT '图集',
`coin` int(11) NOT NULL DEFAULT '0' COMMENT '动力币',
`o_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
`price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'price',
`cashed` int(11) NOT NULL DEFAULT '0' COMMENT '已兑数量',
`stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
`type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '取货模式 1快递2自提',
`contents` longtext DEFAULT NULL COMMENT '内容',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`modifytime` datetime DEFAULT NULL COMMENT '修改日志',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_sport_order`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_sport_order` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`order` varchar(20) NOT NULL COMMENT '订单号',
`list` text NOT NULL COMMENT '商品信息',
`coin` int(11) NOT NULL DEFAULT '0' COMMENT '动力币',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态1待发货2已发货3已完成4待核销',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '模式1快递2自提',
`name` varchar(255) NOT NULL COMMENT '姓名',
`phone` varchar(20) DEFAULT NULL COMMENT '联系方式',
`region` varchar(255) NOT NULL,
`detail` varchar(255) NOT NULL,
`sport_good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
`sure_time` datetime DEFAULT NULL COMMENT '确认时间',
`deliver_time` datetime DEFAULT NULL COMMENT '发货时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_sport_step_log`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_sport_step_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`num` int(11) NOT NULL DEFAULT '0' COMMENT '步数',
`date` date DEFAULT NULL COMMENT '日期',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建日期',
`uniacid` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_supplier`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_supplier` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`name` varchar(20) NOT NULL COMMENT '姓名',
`phone` varchar(20) NOT NULL COMMENT '联系方式',
`wechat` varchar(100) NOT NULL COMMENT '微信号',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`apply` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1正常2申请3不通过',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`apply_time` varchar(50) NOT NULL COMMENT '审核时间',
`formid` text DEFAULT NULL COMMENT '模版消息id',
`remark` text DEFAULT NULL COMMENT '备注',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_supplier_order`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_supplier_order` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`list` longtext DEFAULT NULL COMMENT '订单内容',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`deliver_time` varchar(50) NOT NULL COMMENT '发货时间',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`remark` varchar(255) NOT NULL COMMENT '备注信息',
`settlement_time` varchar(50) NOT NULL COMMENT '结算时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_supplier_staff`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_supplier_staff` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商id',
`name` varchar(10) NOT NULL COMMENT '员工名称',
`phone` varchar(11) NOT NULL COMMENT '员工号码',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态 1 正常 2 申请中',
`uniacid` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_supplier_statistics`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_supplier_statistics` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) DEFAULT NULL,
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
`attrs` text DEFAULT NULL COMMENT '属性内容',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_vip`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_vip` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(20) DEFAULT NULL COMMENT '名称',
`ex` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '升级经验',
`discount` decimal(10,2) NOT NULL DEFAULT '10.00' COMMENT '折扣',
`status` tinyint(3) DEFAULT NULL DEFAULT '1' COMMENT '状态',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建',
`modifytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
`icon` varchar(255) NOT NULL COMMENT '图标',
`color` varchar(10) NOT NULL,
`colorend` varchar(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_xc_xinguwu_voucher`;
CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_voucher` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '卡券类别1满减2抵用3折扣',
`num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
`discount` decimal(2,1) NOT NULL DEFAULT '0.0' COMMENT '折扣',
`replace` int(11) NOT NULL DEFAULT '0' COMMENT '抵用',
`reduce` int(11) NOT NULL DEFAULT '0' COMMENT '减免',
`full` int(11) NOT NULL DEFAULT '0' COMMENT '满',
`status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
`numlimit` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否数量限制(-1不限制;1限制)',
`modifytime` datetime DEFAULT NULL COMMENT '修改时间',
`date_start` date NOT NULL DEFAULT '0000-00-00' COMMENT '开始时间',
`date_end` date NOT NULL DEFAULT '0000-00-00' COMMENT '结束时间',
`explain` varchar(255) NOT NULL COMMENT '使用说明',
`name` varchar(50) NOT NULL COMMENT '卡券名称',
`open` tinyint(3) NOT NULL DEFAULT '1' COMMENT '公开发行',
PRIMARY KEY (`id`),
KEY `date_end` (`date_end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");
