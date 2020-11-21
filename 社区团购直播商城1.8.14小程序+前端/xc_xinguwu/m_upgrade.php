<?php
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_address` (
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

CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_autonum` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`num` int(11) DEFAULT NULL DEFAULT '0',
`keyval` varchar(20) DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `uniacid` (`uniacid`,`keyval`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_feature` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(50) NOT NULL COMMENT '属性名',
`value` varchar(500) DEFAULT NULL COMMENT '特征值',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_specialclass` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL DEFAULT '0',
`name` varchar(50) NOT NULL COMMENT '专题名称',
`status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
`sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_sport_friend` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`openid` varchar(40) DEFAULT NULL,
`uniacid` int(11) NOT NULL DEFAULT '0',
`avatarurl` varchar(255) NOT NULL,
PRIMARY KEY (`id`),
KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_sport_step_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`num` int(11) NOT NULL DEFAULT '0' COMMENT '步数',
`date` date DEFAULT NULL COMMENT '日期',
`createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建日期',
`uniacid` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_xc_xinguwu_supplier_statistics` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) DEFAULT NULL,
`openid` varchar(40) NOT NULL COMMENT '用户标识',
`good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
`attrs` text DEFAULT NULL COMMENT '属性内容',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
if(pdo_tableexists('xc_xinguwu_address')) {
	if(!pdo_fieldexists('xc_xinguwu_address',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_address')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_address')) {
	if(!pdo_fieldexists('xc_xinguwu_address',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_address')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_address')) {
	if(!pdo_fieldexists('xc_xinguwu_address',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_address')." ADD `name` varchar(50) NOT NULL COMMENT '姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_address')) {
	if(!pdo_fieldexists('xc_xinguwu_address',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_address')." ADD `phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_address')) {
	if(!pdo_fieldexists('xc_xinguwu_address',  'region')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_address')." ADD `region` varchar(50) NOT NULL COMMENT '省市区';");
	}	
}
if(pdo_tableexists('xc_xinguwu_address')) {
	if(!pdo_fieldexists('xc_xinguwu_address',  'detail')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_address')." ADD `detail` varchar(255) NOT NULL COMMENT '地址详情';");
	}	
}
if(pdo_tableexists('xc_xinguwu_address')) {
	if(!pdo_fieldexists('xc_xinguwu_address',  'ison')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_address')." ADD `ison` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否设为默认地址';");
	}	
}
if(pdo_tableexists('xc_xinguwu_address')) {
	if(!pdo_fieldexists('xc_xinguwu_address',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_address')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_autonum')) {
	if(!pdo_fieldexists('xc_xinguwu_autonum',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_autonum')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_autonum')) {
	if(!pdo_fieldexists('xc_xinguwu_autonum',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_autonum')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_autonum')) {
	if(!pdo_fieldexists('xc_xinguwu_autonum',  'num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_autonum')." ADD `num` int(11) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_autonum')) {
	if(!pdo_fieldexists('xc_xinguwu_autonum',  'keyval')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_autonum')." ADD `keyval` varchar(20) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'good_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'attr_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `attr_name` varchar(50) NOT NULL COMMENT '属性名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'floor_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `floor_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '底价';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'bargain_range')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `bargain_range` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价范围';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'time_range')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `time_range` int(11) NOT NULL DEFAULT '0' COMMENT '时间限制(分)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'good_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `good_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品显示价格';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'good_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `good_name` varchar(255) NOT NULL COMMENT '商品名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'number')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `number` int(11) NOT NULL DEFAULT '0' COMMENT '砍价人数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'limit_num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '数量限制';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'isindex')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain',  'share')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain')." ADD `share` varchar(500) NOT NULL COMMENT '分享内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'bargain_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `bargain_id` int(11) NOT NULL DEFAULT '0' COMMENT '砍价列表id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'new_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `new_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前的价格';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态(1进行中,2已砍至低价,3已失效,4已交易)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `avatarurl` varchar(255) NOT NULL COMMENT '头像';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `nickname` varchar(255) NOT NULL COMMENT '昵称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self',  'endtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self')." ADD `endtime` datetime DEFAULT NULL COMMENT '结束时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self_log')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self_log',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self_log')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self_log')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self_log',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self_log')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self_log')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self_log',  'bargain_self_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self_log')." ADD `bargain_self_id` int(11) NOT NULL DEFAULT '0' COMMENT '发起砍价id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self_log')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self_log',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self_log')." ADD `nickname` varchar(255) NOT NULL COMMENT '昵称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self_log')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self_log',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self_log')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self_log')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self_log',  'cut_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self_log')." ADD `cut_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '帮砍的金额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self_log')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self_log',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self_log')." ADD `avatarurl` varchar(255) NOT NULL COMMENT '头像';");
	}	
}
if(pdo_tableexists('xc_xinguwu_bargain_self_log')) {
	if(!pdo_fieldexists('xc_xinguwu_bargain_self_log',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_bargain_self_log')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_brokerage_order')) {
	if(!pdo_fieldexists('xc_xinguwu_brokerage_order',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_brokerage_order')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_brokerage_order')) {
	if(!pdo_fieldexists('xc_xinguwu_brokerage_order',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_brokerage_order')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_brokerage_order')) {
	if(!pdo_fieldexists('xc_xinguwu_brokerage_order',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_brokerage_order')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_brokerage_order')) {
	if(!pdo_fieldexists('xc_xinguwu_brokerage_order',  'order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_brokerage_order')." ADD `order` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_brokerage_order')) {
	if(!pdo_fieldexists('xc_xinguwu_brokerage_order',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_brokerage_order')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_brokerage_order')) {
	if(!pdo_fieldexists('xc_xinguwu_brokerage_order',  'order_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_brokerage_order')." ADD `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单价格';");
	}	
}
if(pdo_tableexists('xc_xinguwu_brokerage_order')) {
	if(!pdo_fieldexists('xc_xinguwu_brokerage_order',  'get_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_brokerage_order')." ADD `get_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返佣';");
	}	
}
if(pdo_tableexists('xc_xinguwu_brokerage_order')) {
	if(!pdo_fieldexists('xc_xinguwu_brokerage_order',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_brokerage_order')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态1已付款2已完成';");
	}	
}
if(pdo_tableexists('xc_xinguwu_brokerage_order')) {
	if(!pdo_fieldexists('xc_xinguwu_brokerage_order',  'isoff')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_brokerage_order')." ADD `isoff` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否已失效';");
	}	
}
if(pdo_tableexists('xc_xinguwu_category')) {
	if(!pdo_fieldexists('xc_xinguwu_category',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_category')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_category')) {
	if(!pdo_fieldexists('xc_xinguwu_category',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_category')." ADD `name` varchar(50) NOT NULL COMMENT '类别名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_category')) {
	if(!pdo_fieldexists('xc_xinguwu_category',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_category')." ADD `uniacid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_category')) {
	if(!pdo_fieldexists('xc_xinguwu_category',  'father_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_category')." ADD `father_id` int(11) NOT NULL DEFAULT '0' COMMENT '父id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_category')) {
	if(!pdo_fieldexists('xc_xinguwu_category',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_category')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_category')) {
	if(!pdo_fieldexists('xc_xinguwu_category',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_category')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_category')) {
	if(!pdo_fieldexists('xc_xinguwu_category',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_category')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_category')) {
	if(!pdo_fieldexists('xc_xinguwu_category',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_category')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_category')) {
	if(!pdo_fieldexists('xc_xinguwu_category',  'feature')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_category')." ADD `feature` int(11) NOT NULL DEFAULT '0' COMMENT '规格 id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态1正常2申请-1关闭';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'title')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `title` varchar(255) NOT NULL COMMENT '社团名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `name` varchar(255) NOT NULL COMMENT '姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `phone` varchar(11) DEFAULT NULL COMMENT '联系方式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'region')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `region` varchar(50) NOT NULL COMMENT '省市区';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'detail')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `detail` varchar(255) NOT NULL COMMENT '详细地址';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'longitude')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `longitude` varchar(255) NOT NULL COMMENT '经度';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'latitude')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `latitude` varchar(255) NOT NULL COMMENT '纬度';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改日志';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'totalbrokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `totalbrokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'number')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `number` int(11) NOT NULL DEFAULT '0' COMMENT '成交单数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'avatar')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `avatar` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `remark` varchar(255) NOT NULL COMMENT '备注(服务时间)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club')) {
	if(!pdo_fieldexists('xc_xinguwu_club',  'formid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club')." ADD `formid` text DEFAULT NULL COMMENT '模版消息id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `uniacid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'type')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1收入-1支出';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `remark` varchar(255) NOT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'fee')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'now_brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `now_brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动之后的佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态2申请';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `avatarurl` varchar(255) NOT NULL COMMENT '头像';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `nickname` varchar(255) NOT NULL COMMENT '昵称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `order` varchar(20) NOT NULL COMMENT '单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'deposit_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `deposit_time` datetime DEFAULT NULL COMMENT '提现时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_brokerage')) {
	if(!pdo_fieldexists('xc_xinguwu_club_brokerage',  'alipay')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_brokerage')." ADD `alipay` varchar(50) NOT NULL COMMENT '支付宝账号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'type')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1几日达';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `name` varchar(50) NOT NULL COMMENT '名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'tip')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `tip` varchar(50) NOT NULL COMMENT '说明';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `modifytime` varchar(50) NOT NULL COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'start')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `start` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_label')) {
	if(!pdo_fieldexists('xc_xinguwu_club_label',  'end')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_label')." ADD `end` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `name` varchar(255) NOT NULL COMMENT '姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `phone` varchar(11) NOT NULL COMMENT '联系方式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'region')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `region` varchar(50) NOT NULL COMMENT '地址';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成交佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'number')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `number` int(11) NOT NULL DEFAULT '0' COMMENT '消费单数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'detail')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `detail` varchar(255) NOT NULL COMMENT '地址详情';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_member')) {
	if(!pdo_fieldexists('xc_xinguwu_club_member',  'club_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_member')." ADD `club_id` int(11) NOT NULL DEFAULT '0' COMMENT '团长id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics',  'brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics')." ADD `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics',  'number')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics')." ADD `number` int(11) NOT NULL DEFAULT '0' COMMENT '成交单数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics',  'date')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics')." ADD `date` date DEFAULT NULL COMMENT '日期';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics',  'club_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics')." ADD `club_id` int(11) NOT NULL DEFAULT '0' COMMENT '社团id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'club_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `club_id` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'good_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `good_name` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'good_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `good_id` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `num` int(11) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'date')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `date` date DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `img` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_day')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_day',  'brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_day')." ADD `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'club_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `club_id` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'good_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `good_name` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'good_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `good_id` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'date')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `date` date DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `num` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `img` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_month')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_month',  'brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_month')." ADD `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_total')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_total',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_total')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_total')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_total',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_total')." ADD `uniacid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_total')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_total',  'club_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_total')." ADD `club_id` int(11) NOT NULL DEFAULT '0' COMMENT '社团id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_total')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_total',  'good_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_total')." ADD `good_name` varchar(255) NOT NULL COMMENT '商品名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_total')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_total',  'num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_total')." ADD `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_total')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_total',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_total')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_total')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_total',  'good_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_total')." ADD `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_total')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_total',  'img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_total')." ADD `img` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_total')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_total',  'brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_total')." ADD `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'club_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `club_id` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'good_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `good_name` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'good_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `good_id` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'date')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `date` date DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `num` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `img` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_club_statistics_week')) {
	if(!pdo_fieldexists('xc_xinguwu_club_statistics_week',  'brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_club_statistics_week')." ADD `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'order_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'good_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'text')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `text` varchar(255) NOT NULL COMMENT '文本';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'imgs')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `imgs` text DEFAULT NULL COMMENT '图集';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'anonymity')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `anonymity` tinyint(3) NOT NULL DEFAULT '0' COMMENT '匿名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'goodcom')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `goodcom` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1非常差2差3一般4好5非常好';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'service_attitude')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `service_attitude` int(11) NOT NULL DEFAULT '0' COMMENT '服务态度';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'logistics_speed')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `logistics_speed` tinyint(3) NOT NULL DEFAULT '0' COMMENT '发货速度';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'reply')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `reply` varchar(255) NOT NULL COMMENT '商家回复';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `nickname` varchar(255) NOT NULL COMMENT '昵称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_comment')) {
	if(!pdo_fieldexists('xc_xinguwu_comment',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_comment')." ADD `avatarurl` varchar(255) NOT NULL COMMENT '头像';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `order` bigint(20) NOT NULL DEFAULT '0' COMMENT '商户订单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'amount')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'desc')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `desc` varchar(255) NOT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'payment_no')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `payment_no` varchar(50) NOT NULL COMMENT '微信订单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'payment_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `payment_time` datetime DEFAULT NULL COMMENT '微信支付时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'wechat')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `wechat` varchar(255) NOT NULL COMMENT '微信号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `name` varchar(255) NOT NULL COMMENT '真实姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_deposit_log')) {
	if(!pdo_fieldexists('xc_xinguwu_deposit_log',  'alipay')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_deposit_log')." ADD `alipay` varchar(50) NOT NULL COMMENT '支付宝账号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `name` varchar(255) NOT NULL COMMENT '姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'wechat')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `wechat` varchar(255) NOT NULL COMMENT '微信号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '我的佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'brokerage_yet')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `brokerage_yet` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'order_num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `order_num` int(11) NOT NULL DEFAULT '0' COMMENT '分销订单数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'log_num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `log_num` int(11) NOT NULL DEFAULT '0' COMMENT '提现记录数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'team_num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `team_num` int(11) NOT NULL DEFAULT '0' COMMENT '团队数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'brokerage_total')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `brokerage_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_distribution')) {
	if(!pdo_fieldexists('xc_xinguwu_distribution',  'formid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_distribution')." ADD `formid` text DEFAULT NULL COMMENT '模版消息id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_feature')) {
	if(!pdo_fieldexists('xc_xinguwu_feature',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_feature')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_feature')) {
	if(!pdo_fieldexists('xc_xinguwu_feature',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_feature')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_feature')) {
	if(!pdo_fieldexists('xc_xinguwu_feature',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_feature')." ADD `name` varchar(50) NOT NULL COMMENT '属性名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_feature')) {
	if(!pdo_fieldexists('xc_xinguwu_feature',  'value')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_feature')." ADD `value` varchar(500) DEFAULT NULL COMMENT '特征值';");
	}	
}
if(pdo_tableexists('xc_xinguwu_feature')) {
	if(!pdo_fieldexists('xc_xinguwu_feature',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_feature')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_flashsale')) {
	if(!pdo_fieldexists('xc_xinguwu_flashsale',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_flashsale')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_flashsale')) {
	if(!pdo_fieldexists('xc_xinguwu_flashsale',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_flashsale')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_flashsale')) {
	if(!pdo_fieldexists('xc_xinguwu_flashsale',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_flashsale')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_flashsale')) {
	if(!pdo_fieldexists('xc_xinguwu_flashsale',  'date_start')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_flashsale')." ADD `date_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_flashsale')) {
	if(!pdo_fieldexists('xc_xinguwu_flashsale',  'date_end')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_flashsale')." ADD `date_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_flashsale')) {
	if(!pdo_fieldexists('xc_xinguwu_flashsale',  'contents')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_flashsale')." ADD `contents` longtext DEFAULT NULL COMMENT '内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_flashsale')) {
	if(!pdo_fieldexists('xc_xinguwu_flashsale',  'good_ids')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_flashsale')." ADD `good_ids` varchar(1000) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_flashsale')) {
	if(!pdo_fieldexists('xc_xinguwu_flashsale',  'isindex')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_flashsale')." ADD `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示 (单选)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `name` varchar(100) NOT NULL COMMENT '商品名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `cid` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'bimg')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `bimg` varchar(255) NOT NULL COMMENT '商品图片  方图';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'simg')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `simg` varchar(255) NOT NULL COMMENT '商品图片   长图';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'number')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `number` int(11) NOT NULL DEFAULT '0' COMMENT '销售量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商品状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'contents')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `contents` longtext DEFAULT NULL COMMENT '商品详情';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'attrs')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `attrs` text DEFAULT NULL COMMENT '商品属性';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'prices')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `prices` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格(显示用途)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'unit')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `unit` varchar(10) NOT NULL COMMENT '单位';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `modifytime` datetime DEFAULT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'attr_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `attr_name` varchar(50) NOT NULL COMMENT '属性名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'imgs')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `imgs` text NOT NULL COMMENT '商品图集';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'oprice')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `oprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价(仅用于显示)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'weight')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `weight` int(11) NOT NULL DEFAULT '0' COMMENT '商品重量(g)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'video')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `video` varchar(255) NOT NULL COMMENT '视频地址';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'is_flash')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `is_flash` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否抢购';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'flash_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `flash_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '抢购id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'param')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `param` text DEFAULT NULL COMMENT '商品参数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'share')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `share` varchar(500) NOT NULL COMMENT '分享设置';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'isindex')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '所值佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'brokerage_two')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `brokerage_two` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'brokerage_there')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `brokerage_there` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级级佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'club_brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `club_brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团长佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'arrive')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `arrive` int(11) NOT NULL DEFAULT '0' COMMENT '几日达标签id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'presell')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `presell` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '预售';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'presell_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `presell_time` date DEFAULT NULL COMMENT '预售时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'supplier')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `supplier` varchar(255) NOT NULL COMMENT '供应商id集合';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'content')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `content` longtext DEFAULT NULL COMMENT '内容(手机管理端添加)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'vprice')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `vprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员折扣';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'tagsids')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `tagsids` varchar(1000) NOT NULL COMMENT '标签';");
	}	
}
if(pdo_tableexists('xc_xinguwu_goods')) {
	if(!pdo_fieldexists('xc_xinguwu_goods',  'ecid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_goods')." ADD `ecid` int(11) DEFAULT NULL DEFAULT '1' COMMENT '1 pc -1手机';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `order` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'list')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `list` text DEFAULT NULL COMMENT '订单信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'detail')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `detail` varchar(255) NOT NULL COMMENT '地址信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'paytype')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `paytype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式1余额2微信3抵扣4线下';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单状态1未付款2待发货3已发货4已收货';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'paytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `paytime` datetime DEFAULT NULL COMMENT '支付时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额(含邮费)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `remark` varchar(255) NOT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'totalnum')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `totalnum` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'payid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `payid` varchar(100) NOT NULL COMMENT '用于发送模板消息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'pay_wechat')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `pay_wechat` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '微信支付';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'pay_balance')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `pay_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额支付';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'delive_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `delive_time` datetime DEFAULT NULL COMMENT '发货时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `name` varchar(50) NOT NULL COMMENT '姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'region')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `region` varchar(255) NOT NULL COMMENT '省市区';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'express')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `express` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递费用';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'order_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'express_number')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `express_number` varchar(255) NOT NULL COMMENT '快递单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'express_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `express_name` varchar(50) NOT NULL COMMENT '快递名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'value')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `value` varchar(500) NOT NULL COMMENT '信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'score')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'formid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `formid` varchar(255) NOT NULL COMMENT '用于发送模板消息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'express_code')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `express_code` varchar(50) NOT NULL COMMENT '快递公司编码';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'group_status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `group_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '团状态 1组团中2成功-1失败';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_order')) {
	if(!pdo_fieldexists('xc_xinguwu_group_order',  'out_refund_no')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_order')." ADD `out_refund_no` varchar(100) NOT NULL COMMENT '商户退款单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'group_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购列表id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'join_num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `join_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '参团人数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'scale')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `scale` tinyint(3) NOT NULL DEFAULT '0' COMMENT '拼团规模';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `avatarurl` varchar(255) NOT NULL COMMENT '头像';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `nickname` varchar(255) NOT NULL COMMENT '名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_sponsor')) {
	if(!pdo_fieldexists('xc_xinguwu_group_sponsor',  'endtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_sponsor')." ADD `endtime` datetime DEFAULT NULL COMMENT '结束时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `avatarurl` varchar(255) NOT NULL COMMENT '头像';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `nickname` varchar(255) NOT NULL COMMENT '昵称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'group_sponsor_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `group_sponsor_id` int(11) NOT NULL DEFAULT '0' COMMENT '发起id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态(1组团中2组团成功 -1 失败)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `order` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'ishost')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `ishost` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否团主';");
	}	
}
if(pdo_tableexists('xc_xinguwu_group_tuxedo')) {
	if(!pdo_fieldexists('xc_xinguwu_group_tuxedo',  'group_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_group_tuxedo')." ADD `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购列表id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'good_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'good_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `good_name` varchar(255) NOT NULL COMMENT '商品名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `cid` int(11) NOT NULL DEFAULT '0' COMMENT '分类';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'old_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `old_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'show_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `show_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '展示价';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'limit_num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '限购数量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'group_num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `group_num` int(11) NOT NULL DEFAULT '0' COMMENT '已开团数量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'pattern')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `pattern` tinyint(3) NOT NULL DEFAULT '0' COMMENT '开团模式 1普通2阶梯';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'attr')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `attr` text DEFAULT NULL COMMENT '属性';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `modifytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'duration')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `duration` int(11) NOT NULL DEFAULT '0' COMMENT '持续时间分钟';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'tries')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `tries` tinyint(3) NOT NULL DEFAULT '0' COMMENT '购买次数限制';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'deadline')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `deadline` datetime DEFAULT NULL COMMENT '活动截止时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_groupbuy')) {
	if(!pdo_fieldexists('xc_xinguwu_groupbuy',  'isindex')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_groupbuy')." ADD `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示';");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `name` varchar(50) NOT NULL COMMENT '类别名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'imgurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `imgurl` varchar(500) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'itype')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `itype` int(11) DEFAULT NULL COMMENT '1产品，2固定链接';");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'url')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `url` varchar(500) DEFAULT NULL COMMENT '链接';");
	}	
}
if(pdo_tableexists('xc_xinguwu_label')) {
	if(!pdo_fieldexists('xc_xinguwu_label',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_label')." ADD `cid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_labelclass')) {
	if(!pdo_fieldexists('xc_xinguwu_labelclass',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_labelclass')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_labelclass')) {
	if(!pdo_fieldexists('xc_xinguwu_labelclass',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_labelclass')." ADD `name` varchar(50) NOT NULL COMMENT '类别名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_labelclass')) {
	if(!pdo_fieldexists('xc_xinguwu_labelclass',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_labelclass')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_labelclass')) {
	if(!pdo_fieldexists('xc_xinguwu_labelclass',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_labelclass')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_labelclass')) {
	if(!pdo_fieldexists('xc_xinguwu_labelclass',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_labelclass')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_labelclass')) {
	if(!pdo_fieldexists('xc_xinguwu_labelclass',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_labelclass')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_labelclass')) {
	if(!pdo_fieldexists('xc_xinguwu_labelclass',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_labelclass')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'title')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `title` varchar(255) NOT NULL COMMENT '房间标题';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'stream')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `stream` varchar(20) DEFAULT NULL COMMENT '流名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'pusher')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `pusher` varchar(255) NOT NULL COMMENT '推流地址';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'player')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `player` varchar(255) NOT NULL COMMENT '播放地址';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `img` varchar(255) NOT NULL COMMENT '图片';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'contents')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `contents` text NOT NULL COMMENT '内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'isplay')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `isplay` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '1播放中-1空闲';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `name` varchar(255) NOT NULL COMMENT '使用者姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'start_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `start_time` datetime DEFAULT NULL COMMENT '开始直播时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'end_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `end_time` datetime DEFAULT NULL COMMENT '结束直播时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'number')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `number` int(11) NOT NULL DEFAULT '0' COMMENT '观看人数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'groupid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `groupid` varchar(255) NOT NULL COMMENT '群组id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'errmsg')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `errmsg` varchar(255) NOT NULL COMMENT '回调信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live')) {
	if(!pdo_fieldexists('xc_xinguwu_live',  'goods')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live')." ADD `goods` varchar(255) NOT NULL COMMENT '商品ID集合';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dialog')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dialog',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dialog')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dialog')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dialog',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dialog')." ADD `uniacid` int(11) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dialog')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dialog',  'live_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dialog')." ADD `live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间ID';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dialog')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dialog',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dialog')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dialog')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dialog',  'fromAccountNick')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dialog')." ADD `fromAccountNick` varchar(255) DEFAULT NULL COMMENT '昵称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dialog')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dialog',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dialog')." ADD `avatarurl` varchar(255) NOT NULL COMMENT '头像';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dialog')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dialog',  'content')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dialog')." ADD `content` varchar(255) NOT NULL COMMENT '内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dialog')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dialog',  'type')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dialog')." ADD `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '类型';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dynamic')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dynamic',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dynamic')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dynamic')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dynamic',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dynamic')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dynamic')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dynamic',  'live_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dynamic')." ADD `live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dynamic')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dynamic',  'contents')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dynamic')." ADD `contents` text DEFAULT NULL COMMENT '内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dynamic')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dynamic',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dynamic')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_dynamic')) {
	if(!pdo_fieldexists('xc_xinguwu_live_dynamic',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_dynamic')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_focus')) {
	if(!pdo_fieldexists('xc_xinguwu_live_focus',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_focus')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_focus')) {
	if(!pdo_fieldexists('xc_xinguwu_live_focus',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_focus')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_focus')) {
	if(!pdo_fieldexists('xc_xinguwu_live_focus',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_focus')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_focus')) {
	if(!pdo_fieldexists('xc_xinguwu_live_focus',  'live_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_focus')." ADD `live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_focus')) {
	if(!pdo_fieldexists('xc_xinguwu_live_focus',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_focus')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_focus')) {
	if(!pdo_fieldexists('xc_xinguwu_live_focus',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_focus')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'live_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `live_id` int(11) NOT NULL DEFAULT '0' COMMENT '直播间id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'video_url')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `video_url` varchar(255) NOT NULL COMMENT '回放地址';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'file_size')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `file_size` varchar(50) NOT NULL DEFAULT '0' COMMENT '大小 (字节)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'file_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `file_id` varchar(100) NOT NULL COMMENT '点播file id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'file_format')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `file_format` varchar(10) NOT NULL COMMENT '文件格式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'duration')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `duration` int(11) NOT NULL DEFAULT '0' COMMENT '推流时长(秒)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `img` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'title')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `title` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `nickname` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `avatarurl` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'contents')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `contents` text DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_live_playback')) {
	if(!pdo_fieldexists('xc_xinguwu_live_playback',  'isshow')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_live_playback')." ADD `isshow` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '显示';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `nickname` varchar(255) NOT NULL COMMENT '昵称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `avatarurl` varchar(255) NOT NULL COMMENT '头像';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'gender')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `gender` tinyint(3) NOT NULL DEFAULT '0' COMMENT '性别';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'totalamount')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `totalamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总共充值';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'amount')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现有余额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'exp')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `exp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '经验';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'score')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'totalscore')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `totalscore` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '历史总积分';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'remarks')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `remarks` varchar(255) NOT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'level')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `level` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '等级(-1表示没有等级';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'one')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `one` varchar(40) NOT NULL DEFAULT '0' COMMENT '一级';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'two')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `two` varchar(40) NOT NULL DEFAULT '0' COMMENT '二级';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'there')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `there` varchar(40) NOT NULL DEFAULT '0' COMMENT '三级';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'garder')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `garder` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销等级';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'one_order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `one_order` int(11) NOT NULL DEFAULT '0' COMMENT '一级贡献订单';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'two_order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `two_order` int(11) NOT NULL DEFAULT '0' COMMENT '二级贡献订单';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'there_order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `there_order` int(11) NOT NULL DEFAULT '0' COMMENT '三级贡献订单';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'one_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `one_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级贡献佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'two_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `two_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级贡献佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'there_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `there_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级贡献佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'is_distributor')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `is_distributor` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '是否为分销商';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'date')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `date` date DEFAULT NULL COMMENT '登录日志';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'admin')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `admin` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '客服人员1是-1不是';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'admin1')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `admin1` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '员工';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'admin2')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `admin2` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '管理员';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `name` varchar(255) NOT NULL COMMENT '姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `phone` varchar(20) NOT NULL DEFAULT '0' COMMENT '联系方式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'sig')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `sig` varchar(500) NOT NULL COMMENT '云通信签名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'sig_endtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `sig_endtime` datetime DEFAULT NULL COMMENT '签名过期时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'is_club')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `is_club` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '团长';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'coin')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `coin` int(11) NOT NULL DEFAULT '0' COMMENT '动力币';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'totalstep')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `totalstep` int(11) NOT NULL DEFAULT '0' COMMENT '总步数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'sport_remind')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `sport_remind` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '运动提醒';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'totalcoin')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `totalcoin` int(11) NOT NULL DEFAULT '0' COMMENT '总动力币';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'reach')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `reach` int(11) NOT NULL DEFAULT '0' COMMENT '达标次数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'attend')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `attend` int(11) NOT NULL DEFAULT '0' COMMENT '参加次数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'sport_avatars')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `sport_avatars` int(11) NOT NULL DEFAULT '0' COMMENT '好友个数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'is_supplier')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `is_supplier` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '供应商';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member')) {
	if(!pdo_fieldexists('xc_xinguwu_member',  'pow')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member')." ADD `pow` int(11) NOT NULL DEFAULT '0' COMMENT '调试';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT '模块';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'costsamount')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `costsamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动金额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'surplusamount')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `surplusamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余金额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'remarks')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `remarks` varchar(255) DEFAULT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'itype')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `itype` int(11) DEFAULT NULL DEFAULT '1' COMMENT '1收入，-1为支出';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `cid` int(11) DEFAULT NULL DEFAULT '1' COMMENT '1 用户操作 2管理员操作';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_amount_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_amount_log',  'opusername')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_amount_log')." ADD `opusername` varchar(255) DEFAULT NULL COMMENT '操作人';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '交易时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'costsexp')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `costsexp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '获取经验';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'surplusexp')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `surplusexp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现在经验';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'remarks')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `remarks` varchar(255) NOT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'itype')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `itype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1+ ;-1 -';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1用户操作2管理员操作';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_exp_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_exp_log',  'opusername')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_exp_log')." ADD `opusername` varchar(255) NOT NULL COMMENT '操作人';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'costscore')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `costscore` decimal(10,2) DEFAULT NULL DEFAULT '0.00' COMMENT '消费积分';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'surplusscore')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `surplusscore` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余积分';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'remarks')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `remarks` varchar(255) NOT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'itype')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `itype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1积分收入,-1积分支出';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1用户操作2管理员操作';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'opusername')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `opusername` varchar(255) NOT NULL COMMENT '操作人';");
	}	
}
if(pdo_tableexists('xc_xinguwu_member_score_log')) {
	if(!pdo_fieldexists('xc_xinguwu_member_score_log',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_member_score_log')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_moban_user')) {
	if(!pdo_fieldexists('xc_xinguwu_moban_user',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_moban_user')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_moban_user')) {
	if(!pdo_fieldexists('xc_xinguwu_moban_user',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_moban_user')." ADD `uniacid` int(11) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_moban_user')) {
	if(!pdo_fieldexists('xc_xinguwu_moban_user',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_moban_user')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_moban_user')) {
	if(!pdo_fieldexists('xc_xinguwu_moban_user',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_moban_user')." ADD `nickname` varchar(255) NOT NULL COMMENT '昵称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_moban_user')) {
	if(!pdo_fieldexists('xc_xinguwu_moban_user',  'headimgurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_moban_user')." ADD `headimgurl` varchar(255) NOT NULL COMMENT '头像';");
	}	
}
if(pdo_tableexists('xc_xinguwu_moban_user')) {
	if(!pdo_fieldexists('xc_xinguwu_moban_user',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_moban_user')." ADD `status` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_moban_user')) {
	if(!pdo_fieldexists('xc_xinguwu_moban_user',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_moban_user')." ADD `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期';");
	}	
}
if(pdo_tableexists('xc_xinguwu_moban_user')) {
	if(!pdo_fieldexists('xc_xinguwu_moban_user',  'ident')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_moban_user')." ADD `ident` varchar(50) NOT NULL COMMENT '标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_mycard')) {
	if(!pdo_fieldexists('xc_xinguwu_mycard',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_mycard')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_mycard')) {
	if(!pdo_fieldexists('xc_xinguwu_mycard',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_mycard')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_mycard')) {
	if(!pdo_fieldexists('xc_xinguwu_mycard',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_mycard')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_mycard')) {
	if(!pdo_fieldexists('xc_xinguwu_mycard',  'voucherid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_mycard')." ADD `voucherid` int(11) NOT NULL DEFAULT '0' COMMENT '卡券id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_mycard')) {
	if(!pdo_fieldexists('xc_xinguwu_mycard',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_mycard')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '领取时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_mycard')) {
	if(!pdo_fieldexists('xc_xinguwu_mycard',  'usetime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_mycard')." ADD `usetime` datetime DEFAULT NULL COMMENT '使用时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_mycard')) {
	if(!pdo_fieldexists('xc_xinguwu_mycard',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_mycard')." ADD `remark` varchar(100) NOT NULL COMMENT '卡券使用备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_mycard')) {
	if(!pdo_fieldexists('xc_xinguwu_mycard',  'voucherstatus')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_mycard')." ADD `voucherstatus` tinyint(3) NOT NULL DEFAULT '0' COMMENT '卡券状态(1未使用,2已使用,3已过期)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online')) {
	if(!pdo_fieldexists('xc_xinguwu_online',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_online')) {
	if(!pdo_fieldexists('xc_xinguwu_online',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online')) {
	if(!pdo_fieldexists('xc_xinguwu_online',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online')) {
	if(!pdo_fieldexists('xc_xinguwu_online',  'member')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online')." ADD `member` int(11) NOT NULL DEFAULT '0' COMMENT '未读条数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online')) {
	if(!pdo_fieldexists('xc_xinguwu_online',  'type')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '类型';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online')) {
	if(!pdo_fieldexists('xc_xinguwu_online',  'content')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online')." ADD `content` longtext DEFAULT NULL COMMENT '内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online')) {
	if(!pdo_fieldexists('xc_xinguwu_online',  'updatetime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online')." ADD `updatetime` varchar(50) DEFAULT NULL COMMENT '更新时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online')) {
	if(!pdo_fieldexists('xc_xinguwu_online',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online_log')) {
	if(!pdo_fieldexists('xc_xinguwu_online_log',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online_log')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_online_log')) {
	if(!pdo_fieldexists('xc_xinguwu_online_log',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online_log')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online_log')) {
	if(!pdo_fieldexists('xc_xinguwu_online_log',  'pid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online_log')." ADD `pid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online_log')) {
	if(!pdo_fieldexists('xc_xinguwu_online_log',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online_log')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online_log')) {
	if(!pdo_fieldexists('xc_xinguwu_online_log',  'type')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online_log')." ADD `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1文本2图片';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online_log')) {
	if(!pdo_fieldexists('xc_xinguwu_online_log',  'content')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online_log')." ADD `content` longtext DEFAULT NULL COMMENT '内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online_log')) {
	if(!pdo_fieldexists('xc_xinguwu_online_log',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online_log')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_online_log')) {
	if(!pdo_fieldexists('xc_xinguwu_online_log',  'duty')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_online_log')." ADD `duty` tinyint(3) NOT NULL DEFAULT '1' COMMENT '身份1客户 2客服';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `openid` varchar(40) NOT NULL COMMENT '用户id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'unionid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `unionid` varchar(64) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `order` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'list')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `list` text DEFAULT NULL COMMENT '订单信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'detail')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `detail` varchar(255) NOT NULL COMMENT '地址信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'paytype')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `paytype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式1余额2微信3余额不足微信抵扣4线下支付';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1 正常订单 2 积分订单4砍价6抢购';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单状态1未付款2待发货3待收货4退款5完成';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'paytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `paytime` datetime DEFAULT NULL COMMENT '支付时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额(实付金额)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'order_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额(不含邮费)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'express')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `express` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递费用';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `remark` varchar(255) NOT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'totalnum')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `totalnum` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'refund')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `refund` tinyint(3) NOT NULL DEFAULT '0' COMMENT '退款状态(1申请2成功3拒绝)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'refund_value')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `refund_value` varchar(500) NOT NULL COMMENT '退款内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'payid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `payid` varchar(255) NOT NULL COMMENT '用于发送模板消息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'pay_wechat')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `pay_wechat` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '通过微信支付的金额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'pay_balance')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `pay_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '通过余额支付的金额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'myvoucher')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `myvoucher` int(11) NOT NULL DEFAULT '0' COMMENT '我的卡 id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'deliver_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `deliver_time` datetime DEFAULT NULL COMMENT '发货时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'score')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '赠送的积分数(所需的积分数)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'refuse')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `refuse` varchar(500) NOT NULL COMMENT '拒绝退款理由';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'exp')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `exp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '获得的经验';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `phone` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'region')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `region` varchar(255) NOT NULL COMMENT '地址(省市区)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'module')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `module` varchar(255) DEFAULT NULL COMMENT '用户支付回调验证(废弃)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `name` varchar(255) NOT NULL COMMENT '收货人姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'express_number')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `express_number` varchar(20) NOT NULL COMMENT '快递单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'express_name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `express_name` varchar(255) NOT NULL COMMENT '快递公司名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'remind')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `remind` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提醒发货';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'formid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `formid` varchar(255) NOT NULL COMMENT '表单id用于发送模板消息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'express_code')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `express_code` varchar(50) NOT NULL COMMENT '快递公司编码';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'value')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `value` text NOT NULL COMMENT '信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'group_status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `group_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '团购状态 1组团中 2组团成功 -1组团失败';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'out_refund_no')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `out_refund_no` varchar(100) NOT NULL COMMENT '商户退款单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'vendor_remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `vendor_remark` varchar(255) NOT NULL COMMENT '卖家备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'out_refund_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `out_refund_time` datetime DEFAULT NULL COMMENT '退款成功时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'refund_error_msg')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `refund_error_msg` varchar(255) NOT NULL COMMENT '退款错误回调信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'community_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `community_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团点优惠';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'community_brokerage')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `community_brokerage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '社区团佣金';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'club_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `club_id` int(11) NOT NULL DEFAULT '0' COMMENT '团长id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'hex')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `hex` varchar(50) NOT NULL COMMENT '核销码';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'hex_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `hex_time` datetime DEFAULT NULL COMMENT '核销时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'is_community')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `is_community` tinyint(3) NOT NULL DEFAULT '0' COMMENT '社区团';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'community_status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `community_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '自提状态1待自提2已取货';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'comment')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `comment` tinyint(3) DEFAULT NULL COMMENT '评价';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'pid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `pid` int(11) NOT NULL DEFAULT '0' COMMENT '针对限购产品';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'expires')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `expires` int(11) NOT NULL DEFAULT '0' COMMENT '失效时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'activityid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `activityid` int(11) NOT NULL DEFAULT '0' COMMENT '活动id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_order')) {
	if(!pdo_fieldexists('xc_xinguwu_order',  'num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_order')." ADD `num` int(11) NOT NULL DEFAULT '0' COMMENT '主要针对 活动团购，限制抢购';");
	}	
}
if(pdo_tableexists('xc_xinguwu_other')) {
	if(!pdo_fieldexists('xc_xinguwu_other',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_other')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_other')) {
	if(!pdo_fieldexists('xc_xinguwu_other',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_other')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_other')) {
	if(!pdo_fieldexists('xc_xinguwu_other',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_other')." ADD `name` varchar(50) NOT NULL COMMENT '名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_other')) {
	if(!pdo_fieldexists('xc_xinguwu_other',  'contents')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_other')." ADD `contents` longtext DEFAULT NULL COMMENT '内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_other')) {
	if(!pdo_fieldexists('xc_xinguwu_other',  'keyval')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_other')." ADD `keyval` varchar(20) NOT NULL COMMENT '关键字';");
	}	
}
if(pdo_tableexists('xc_xinguwu_other')) {
	if(!pdo_fieldexists('xc_xinguwu_other',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_other')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_other')) {
	if(!pdo_fieldexists('xc_xinguwu_other',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_other')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_other')) {
	if(!pdo_fieldexists('xc_xinguwu_other',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_other')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_other')) {
	if(!pdo_fieldexists('xc_xinguwu_other',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_other')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'fee')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'score')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'exp')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `exp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '经验';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'tid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `tid` varchar(255) NOT NULL COMMENT '单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'payid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `payid` varchar(100) NOT NULL COMMENT '用于模板消息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'paytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `paytime` datetime DEFAULT NULL COMMENT '支付时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `cid` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1用户2管理员';");
	}	
}
if(pdo_tableexists('xc_xinguwu_recharge')) {
	if(!pdo_fieldexists('xc_xinguwu_recharge',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_recharge')." ADD `remark` text DEFAULT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `name` varchar(100) DEFAULT NULL COMMENT '商品名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `img` varchar(255) DEFAULT NULL COMMENT '商品图片';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'integral')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `integral` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '所需积分';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'inventory')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `inventory` int(11) NOT NULL DEFAULT '0' COMMENT '库存';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'recommend')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `recommend` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否推荐';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'hot')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `hot` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否热门';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商品状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'bag')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `bag` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否包邮';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'weight')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `weight` int(11) DEFAULT NULL COMMENT '重量(g)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_shop')) {
	if(!pdo_fieldexists('xc_xinguwu_shop',  'price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_shop')." ADD `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '所需金额';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `name` varchar(255) NOT NULL COMMENT '专题名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `img` varchar(255) NOT NULL COMMENT '展示图片';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'about')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `about` varchar(255) NOT NULL COMMENT '摘要';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'video_type')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `video_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '视频模式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'video')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `video` varchar(255) NOT NULL COMMENT '视频地址';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'contents')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `contents` longtext DEFAULT NULL COMMENT '内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `cid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'ready')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `ready` int(11) NOT NULL DEFAULT '0' COMMENT '阅读量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'like')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `like` int(11) NOT NULL DEFAULT '0' COMMENT '点赞量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'isindex')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'poster')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `poster` varchar(255) NOT NULL COMMENT '视频封面';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'ad_img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `ad_img` varchar(255) NOT NULL COMMENT '广告图片';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'ad_link')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `ad_link` varchar(255) NOT NULL COMMENT '广告跳转地址';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special')) {
	if(!pdo_fieldexists('xc_xinguwu_special',  'recom')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special')." ADD `recom` varchar(255) NOT NULL COMMENT '推荐商品';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special_like')) {
	if(!pdo_fieldexists('xc_xinguwu_special_like',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special_like')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_special_like')) {
	if(!pdo_fieldexists('xc_xinguwu_special_like',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special_like')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special_like')) {
	if(!pdo_fieldexists('xc_xinguwu_special_like',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special_like')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special_like')) {
	if(!pdo_fieldexists('xc_xinguwu_special_like',  'special_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special_like')." ADD `special_id` int(11) NOT NULL DEFAULT '0' COMMENT '专题id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special_like')) {
	if(!pdo_fieldexists('xc_xinguwu_special_like',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special_like')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_special_like')) {
	if(!pdo_fieldexists('xc_xinguwu_special_like',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_special_like')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1已点赞 -1 已取消点赞';");
	}	
}
if(pdo_tableexists('xc_xinguwu_specialclass')) {
	if(!pdo_fieldexists('xc_xinguwu_specialclass',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_specialclass')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_specialclass')) {
	if(!pdo_fieldexists('xc_xinguwu_specialclass',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_specialclass')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_specialclass')) {
	if(!pdo_fieldexists('xc_xinguwu_specialclass',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_specialclass')." ADD `name` varchar(50) NOT NULL COMMENT '专题名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_specialclass')) {
	if(!pdo_fieldexists('xc_xinguwu_specialclass',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_specialclass')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_specialclass')) {
	if(!pdo_fieldexists('xc_xinguwu_specialclass',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_specialclass')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_specialclass')) {
	if(!pdo_fieldexists('xc_xinguwu_specialclass',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_specialclass')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'step')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `step` int(11) NOT NULL DEFAULT '0' COMMENT '步数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'ticket')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `ticket` int(11) NOT NULL DEFAULT '0' COMMENT '门票';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'award')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `award` int(11) NOT NULL DEFAULT '0' COMMENT '奖励';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改日志';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'title')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `title` varchar(50) NOT NULL COMMENT '标题';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'start_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `start_time` datetime DEFAULT NULL COMMENT '开始时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'end_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `end_time` datetime DEFAULT NULL COMMENT '结束时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'join_num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `join_num` int(11) NOT NULL DEFAULT '0' COMMENT '参加人数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall',  'finish_num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall')." ADD `finish_num` int(11) DEFAULT NULL DEFAULT '0' COMMENT '完成人数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall_log',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall_log')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall_log',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall_log')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall_log',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall_log')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall_log',  'chall_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall_log')." ADD `chall_id` int(11) NOT NULL DEFAULT '0' COMMENT '挑战项目id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall_log',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall_log')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall_log',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall_log')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1进行中2已提交3超时';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall_log',  'submission_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall_log')." ADD `submission_time` datetime DEFAULT NULL COMMENT '提交时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_chall_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_chall_log',  'value')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_chall_log')." ADD `value` varchar(500) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_coin_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_coin_log',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_coin_log')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_coin_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_coin_log',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_coin_log')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_coin_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_coin_log',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_coin_log')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_coin_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_coin_log',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_coin_log')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_coin_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_coin_log',  'fee')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_coin_log')." ADD `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '改变数值';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_coin_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_coin_log',  'title')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_coin_log')." ADD `title` varchar(255) NOT NULL COMMENT '标题';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_coin_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_coin_log',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_coin_log')." ADD `remark` varchar(255) NOT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_friend')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_friend',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_friend')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_friend')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_friend',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_friend')." ADD `openid` varchar(40) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_friend')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_friend',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_friend')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_friend')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_friend',  'avatarurl')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_friend')." ADD `avatarurl` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `name` varchar(255) DEFAULT NULL COMMENT '商品名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'img')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `img` varchar(255) NOT NULL COMMENT '图片';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'imgs')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `imgs` text DEFAULT NULL COMMENT '图集';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'coin')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `coin` int(11) NOT NULL DEFAULT '0' COMMENT '动力币';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'o_price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `o_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'price')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'price';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'cashed')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `cashed` int(11) NOT NULL DEFAULT '0' COMMENT '已兑数量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'stock')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'type')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '取货模式 1快递2自提';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'contents')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `contents` longtext DEFAULT NULL COMMENT '内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改日志';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'sorts')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `sorts` int(11) NOT NULL DEFAULT '0' COMMENT '排序';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_good')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_good',  'isindex')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_good')." ADD `isindex` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '首页显示';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'order')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `order` varchar(20) NOT NULL COMMENT '订单号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'list')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `list` text NOT NULL COMMENT '商品信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'coin')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `coin` int(11) NOT NULL DEFAULT '0' COMMENT '动力币';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态1待发货2已发货3已完成4待核销';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'type')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '模式1快递2自提';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `name` varchar(255) NOT NULL COMMENT '姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `phone` varchar(20) DEFAULT NULL COMMENT '联系方式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'region')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `region` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'detail')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `detail` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'sport_good_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `sport_good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'sure_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `sure_time` datetime DEFAULT NULL COMMENT '确认时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_order')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_order',  'deliver_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_order')." ADD `deliver_time` datetime DEFAULT NULL COMMENT '发货时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_step_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_step_log',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_step_log')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_step_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_step_log',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_step_log')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_step_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_step_log',  'num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_step_log')." ADD `num` int(11) NOT NULL DEFAULT '0' COMMENT '步数';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_step_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_step_log',  'date')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_step_log')." ADD `date` date DEFAULT NULL COMMENT '日期';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_step_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_step_log',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_step_log')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建日期';");
	}	
}
if(pdo_tableexists('xc_xinguwu_sport_step_log')) {
	if(!pdo_fieldexists('xc_xinguwu_sport_step_log',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_sport_step_log')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `name` varchar(20) NOT NULL COMMENT '姓名';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `phone` varchar(20) NOT NULL COMMENT '联系方式';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'wechat')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `wechat` varchar(100) NOT NULL COMMENT '微信号';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'apply')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `apply` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1正常2申请3不通过';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'apply_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `apply_time` varchar(50) NOT NULL COMMENT '审核时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'formid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `formid` text DEFAULT NULL COMMENT '模版消息id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier')." ADD `remark` text DEFAULT NULL COMMENT '备注';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_order')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_order',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_order')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_order')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_order',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_order')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_order')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_order',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_order')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_order')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_order',  'list')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_order')." ADD `list` longtext DEFAULT NULL COMMENT '订单内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_order')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_order',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_order')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_order')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_order',  'deliver_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_order')." ADD `deliver_time` varchar(50) NOT NULL COMMENT '发货时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_order')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_order',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_order')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_order')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_order',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_order')." ADD `remark` varchar(255) NOT NULL COMMENT '备注信息';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_order')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_order',  'settlement_time')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_order')." ADD `settlement_time` varchar(50) NOT NULL COMMENT '结算时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_staff')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_staff',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_staff')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_staff')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_staff',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_staff')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_staff')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_staff',  'supplier_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_staff')." ADD `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_staff')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_staff',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_staff')." ADD `name` varchar(10) NOT NULL COMMENT '员工名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_staff')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_staff',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_staff')." ADD `phone` varchar(11) NOT NULL COMMENT '员工号码';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_staff')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_staff',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_staff')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态 1 正常 2 申请中';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_staff')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_staff',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_staff')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_statistics',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_statistics')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_statistics',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_statistics')." ADD `uniacid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_statistics',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_statistics')." ADD `openid` varchar(40) NOT NULL COMMENT '用户标识';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_statistics',  'good_id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_statistics')." ADD `good_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id';");
	}	
}
if(pdo_tableexists('xc_xinguwu_supplier_statistics')) {
	if(!pdo_fieldexists('xc_xinguwu_supplier_statistics',  'attrs')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_supplier_statistics')." ADD `attrs` text DEFAULT NULL COMMENT '属性内容';");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `name` varchar(20) DEFAULT NULL COMMENT '名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'ex')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `ex` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '升级经验';");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'discount')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `discount` decimal(10,2) NOT NULL DEFAULT '10.00' COMMENT '折扣';");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `status` tinyint(3) DEFAULT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建';");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `modifytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'icon')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `icon` varchar(255) NOT NULL COMMENT '图标';");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'color')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `color` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_vip')) {
	if(!pdo_fieldexists('xc_xinguwu_vip',  'colorend')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_vip')." ADD `colorend` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'id')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `cid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '卡券类别1满减2抵用3折扣';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'num')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'discount')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `discount` decimal(2,1) NOT NULL DEFAULT '0.0' COMMENT '折扣';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'replace')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `replace` int(11) NOT NULL DEFAULT '0' COMMENT '抵用';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'reduce')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `reduce` int(11) NOT NULL DEFAULT '0' COMMENT '减免';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'full')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `full` int(11) NOT NULL DEFAULT '0' COMMENT '满';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'status')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'numlimit')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `numlimit` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否数量限制(-1不限制;1限制)';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'modifytime')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `modifytime` datetime DEFAULT NULL COMMENT '修改时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'date_start')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `date_start` date NOT NULL DEFAULT '0000-00-00' COMMENT '开始时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'date_end')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `date_end` date NOT NULL DEFAULT '0000-00-00' COMMENT '结束时间';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'explain')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `explain` varchar(255) NOT NULL COMMENT '使用说明';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'name')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `name` varchar(50) NOT NULL COMMENT '卡券名称';");
	}	
}
if(pdo_tableexists('xc_xinguwu_voucher')) {
	if(!pdo_fieldexists('xc_xinguwu_voucher',  'open')) {
		pdo_query("ALTER TABLE ".tablename('xc_xinguwu_voucher')." ADD `open` tinyint(3) NOT NULL DEFAULT '1' COMMENT '公开发行';");
	}	
}
