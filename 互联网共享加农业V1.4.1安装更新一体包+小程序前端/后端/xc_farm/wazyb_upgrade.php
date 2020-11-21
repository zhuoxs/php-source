<?php 
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_farm_active` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`name` varchar(50)    COMMENT '标题',
`bimg` varchar(255)    COMMENT '封面',
`price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '费用',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '人数',
`is_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已报名人数',
`member_max` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '每单限人数',
`active_start` datetime()    COMMENT '活动开始时间',
`active_end` datetime()    COMMENT '活动结束时间',
`sign_start` datetime()    COMMENT '报名开始时间',
`sign_end` datetime()    COMMENT '报名结束时间',
`mobile` varchar(50)    COMMENT '手机号',
`address` varchar(255)    COMMENT '地址',
`longitude` decimal(10,7)    COMMENT '经度',
`latitude` decimal(10,7)    COMMENT '纬度',
`content` longtext()    COMMENT '详情',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`partner` varchar(50)    COMMENT '合作商',
`partner_price` varchar(50)    COMMENT '平台佣金',
`share_title` varchar(255)    COMMENT '分享标题',
`share_img` varchar(255)    COMMENT '分享图片',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_address` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`openid` varchar(50)    COMMENT '用户id',
`name` varchar(50)    COMMENT '姓名',
`mobile` varchar(50)    COMMENT '手机号',
`sex` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '性别',
`address` varchar(255)    COMMENT '地址',
`latitude` decimal(10,7)    COMMENT '经度',
`longitude` decimal(10,7)    COMMENT '纬度',
`content` longtext()    COMMENT '详情',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_app` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`title` varchar(50)    COMMENT '标题',
`type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型',
`content` longtext()    COMMENT '详情',
`info` longtext()    COMMENT '简介',
`bimg` varchar(255)    COMMENT '图片',
`detail` longtext()    COMMENT '图文',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`sub_title` varchar(50)    COMMENT '小标题',
`position` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '位置（1左2右）',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_app_nav` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`name` varchar(50)    COMMENT '名称',
`cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '关联内容',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_apply` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '用户id',
`type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '1项目合作2经销采购',
`type2` int(11)  DEFAULT NULL DEFAULT '0',
`cname` varchar(255)    COMMENT '企业名称',
`address` varchar(255)    COMMENT '地址',
`coname` varchar(50)    COMMENT '法人',
`name` varchar(50)    COMMENT '联系人',
`mobile` varchar(50)    COMMENT '联系电话',
`content` longtext()    COMMENT '业务',
`cmobile` varchar(50)    COMMENT '企业电话',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`map` longtext()    COMMENT '定位',
`imgs` longtext()    COMMENT '图片',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态',
`invite_code` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '邀请码',
`service` longtext()    COMMENT '服务项目',
`service_format` longtext()    COMMENT '服务项目格式化',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_apply_class` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`name` varchar(50)    COMMENT '名称',
`type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型（1企业类型2合作类型）',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`color` varchar(50)    COMMENT '背景颜色',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_article` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`title` varchar(255),
`type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型（1外链接2小程序）',
`content` longtext()    COMMENT '详情',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_banner` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`name` varchar(50)    COMMENT '名称',
`bimg` varchar(255)    COMMENT '图片',
`link` varchar(255)    COMMENT '链接',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_cf` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`title` varchar(255)    COMMENT '标题',
`subtitle` varchar(255)    COMMENT '副标题',
`bimg` varchar(255)    COMMENT '封面',
`price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格',
`type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型（1众筹2认养3租用）',
`funds` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '资金',
`is_funds` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '已筹集资金',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量',
`is_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已售',
`discuss` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '评论数',
`mobile` varchar(50)    COMMENT '联系方式',
`name` varchar(255)    COMMENT '责任人',
`time_start` datetime()    COMMENT '开始时间',
`time_end` datetime()    COMMENT '结束时间',
`info` longtext()    COMMENT '项目信息',
`content` longtext()    COMMENT '详情',
`video_live` longtext()    COMMENT '视频直播',
`graphic_live` longtext()    COMMENT '图文直播',
`income` longtext()    COMMENT '收益',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`index` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '首页显示',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`use_start` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '使用时间',
`use_end` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '使用时间',
`end_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '结束处理（-1未处理1手动成功2退款）',
`fen_status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '分销功能',
`fen_ju_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '分销局部佣金',
`fen_one` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '一级佣金',
`fen_two` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '分销二级',
`fen_three` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '三级分销',
`fen_one2` decimal(10,2)    COMMENT '二级佣金',
`fen_two2` decimal(10,2)    COMMENT '二级佣金',
`fen_three2` decimal(10,2)    COMMENT '二级佣金',
`share_title` varchar(255)    COMMENT '分享标题',
`share_img` varchar(255)    COMMENT '分享图片',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_cf_card` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '用户id',
`out_trade_no` varchar(50)    COMMENT '订单',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`service_name` varchar(255)    COMMENT '产品名称',
`format` varchar(50)    COMMENT '规格',
`format_index` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '规格',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量',
`time_start` datetime()    COMMENT '使用时间',
`time_end` datetime()    COMMENT '使用时间',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态（-1未使用1已使用）',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`type2` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型（1众筹2认养3租用）',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_config` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`xkey` varchar(50)    COMMENT '关键字',
`content` longtext()    COMMENT '内容',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_count` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`format` varchar(50),
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '销量',
`createtime` datetime()    COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_coupon` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`name` varchar(50)    COMMENT '名称',
`price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '优惠价格',
`condition` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '满足价格',
`time_start` datetime()    COMMENT '有效期',
`time_end` datetime()    COMMENT '有效期',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_coupon_log` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`openid` varchar(50)    COMMENT '用户id',
`cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '优惠券id',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_cut` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '用户id',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`format_index` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '规格',
`price` decimal(10,2)    COMMENT '价格',
`min_price` decimal(10,2)    COMMENT '最低价格',
`o_price` decimal(10,2)    COMMENT '原价',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '1最小价格',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_cut_log` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '用户id',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`price` decimal(10,2)    COMMENT '砍去的价格',
`cut_openid` varchar(50)    COMMENT '砍的用户id',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_discuss` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`openid` varchar(50)    COMMENT '用户id',
`type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '1产品评价2众筹评价3新闻评价',
`pid` int(11)  DEFAULT NULL DEFAULT '0',
`content` longtext()    COMMENT '内容',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`bimg` longtext()    COMMENT '图片',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_group` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '团长',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`is_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已有人数',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '所需人数',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '开团时间',
`failtime` datetime()    COMMENT '结束时间',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态（-1拼团中1拼团成功2已失败）',
`group` longtext()    COMMENT '团成员',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_land` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`name` varchar(50)    COMMENT '名称',
`cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '分类',
`simg` varchar(255)    COMMENT '封面',
`bimg` longtext()    COMMENT '图片',
`member_on` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已种植土地',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '土地',
`seed_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '每份土地可种种子数',
`seed_list` longtext()    COMMENT '可中的种子',
`seed_id` longtext()    COMMENT '播种id',
`fail_date` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '失败时间',
`video` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '直播',
`content` longtext()    COMMENT '详情',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` datetime()    COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_land_group` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '团长',
`land` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '土地',
`seed` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '种子',
`member_on` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已种种子',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '种子',
`group` longtext()    COMMENT '团成员',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态-1拼种种1成功2失败',
`createtime` datetime()    COMMENT '添加时间',
`failtime` datetime()    COMMENT '失败时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_live` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`name` varchar(50)    COMMENT '名称',
`cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '分类',
`bimg` varchar(255)    COMMENT '封面',
`link` varchar(255)    COMMENT '链接',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型',
`video` varchar(255)    COMMENT '链接',
`vid` varchar(50),
`content` longtext()    COMMENT '详情',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_live_class` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`name` varchar(50)    COMMENT '名称',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_log` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '用户id',
`plan_date` varchar(50)    COMMENT '日期',
`createtime` datetime()    COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_moban_user` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50),
`nickname` varchar(500)    COMMENT '呢称',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '-1未使用  1已使用',
`createtime` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '发布日期',
`ident` varchar(50)    COMMENT '标识',
`headimgurl` varchar(500)    COMMENT '头像',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_nav` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`name` varchar(50)    COMMENT '名称',
`bimg` varchar(255)    COMMENT '图片',
`link` varchar(255)    COMMENT '链接',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_news` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`title` varchar(255)    COMMENT '标题',
`bimg` varchar(255)    COMMENT '封面',
`click` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '浏览数',
`zan` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '点赞数',
`discuss` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '评论数',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '关联产品',
`service_name` varchar(50)    COMMENT '产品名称',
`content` longtext()    COMMENT '详情',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_online` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '用户id',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '未读条数',
`type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型',
`content` longtext()    COMMENT '内容',
`updatetime` varchar(50)    COMMENT '更新时间',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_online_log` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`pid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '发送者用户id',
`type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型1文本2图片',
`content` longtext()    COMMENT '内容',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`duty` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '身份1客户2客服',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_order` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`openid` varchar(50)    COMMENT '用户id',
`out_trade_no` varchar(50)    COMMENT '订单号',
`wx_out_trade_no` varchar(50)    COMMENT '商户订单号',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`services` longtext()    COMMENT '项目',
`service_name` varchar(255)    COMMENT '产品名称',
`format` varchar(255)    COMMENT '规格',
`format_index` int(11)  DEFAULT NULL DEFAULT '-1',
`price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '单价',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量',
`is_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '核销次数',
`amount` decimal(10,2)    COMMENT '应付款',
`o_amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '实付款',
`order_type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '订单类型（1活动报名2众筹3产品）',
`type2` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '众筹（1众筹2租用3认养）产品（1单买2团购3砍价4限时5兑换）',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态',
`order_status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '1待发货2待收货3待评价4已完成',
`name` varchar(50)    COMMENT '姓名',
`mobile` varchar(50)    COMMENT '手机',
`address` longtext()    COMMENT '地址',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`form_id` varchar(255),
`content` longtext()    COMMENT '备注',
`income` longtext()    COMMENT '收益',
`coupon` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '优惠券id',
`coupon_price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '优惠价格',
`cf_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '-1筹集中1已完成2已退款',
`cf_card` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '兑换券',
`group` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '团id',
`group_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '团状态',
`fen_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '未分销',
`fen_openid` varchar(50)    COMMENT '分销用户',
`fen_price` decimal(10,2)    COMMENT '分销金额',
`partner_price` decimal(10,2)    COMMENT '平台佣金',
`fen_openid2` varchar(50)    COMMENT '二级分销',
`fen_price2` decimal(10,2)    COMMENT '二级分销金额',
`callback1` longtext()    COMMENT '打印1回调',
`callback2` longtext()    COMMENT '打印2',
`topic` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '专题id',
`topic_price` varchar(50)    COMMENT '折扣',
`plan_date` varchar(50)    COMMENT '预约时间',
`tui_content` longtext()    COMMENT '退款理由',
`pin_name` varchar(50)    COMMENT '拼团名称',
`pin_simg` varchar(255)    COMMENT '拼团图片',
`transaction_id` varchar(255)    COMMENT '微信订单号',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_pin` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`name` varchar(50)    COMMENT '名称',
`cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '分类',
`simg` varchar(255)    COMMENT '封面',
`price` decimal(10,2)    COMMENT '价格',
`tag` longtext()    COMMENT '标签',
`bimg` longtext()    COMMENT '图片',
`sold` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已拼',
`discuss` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '评论数',
`content` longtext()    COMMENT '详情',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` datetime()    COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_pin_group` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`pid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`start_time` datetime()    COMMENT '开始时间',
`end_time` datetime()    COMMENT '结束时间',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '总数',
`member_on` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已拼数量',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '-1拼购中1拼购成功2拼购失败',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`content` longtext()    COMMENT '拼购内容',
`createtime` datetime()    COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_pin_group_detail` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`pid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`gid` int(11)  DEFAULT NULL DEFAULT '0',
`name` varchar(50)    COMMENT '名称',
`simg` varchar(255)    COMMENT '图片',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量',
`member_on` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已出售数量',
`price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格',
`weight` varchar(50)    COMMENT '分量',
`createtime` datetime()    COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_seed` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`name` varchar(50)    COMMENT '名称',
`cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '分类',
`simg` varchar(255)    COMMENT '封面',
`plan_date` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '生长周期',
`weight` varchar(255)    COMMENT '分量',
`price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格',
`income` longtext()    COMMENT '收益',
`dui_date` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '兑换周期',
`content` longtext()    COMMENT '详情',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` datetime()    COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_service` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`name` varchar(50)    COMMENT '名称',
`subtitle` varchar(255)    COMMENT '副标题',
`cid` int(11)  DEFAULT NULL DEFAULT '0',
`simg` varchar(255)    COMMENT '封面',
`bimg` longtext()    COMMENT '产品图片',
`discuss` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '评论人数',
`sold` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已售人数',
`price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格',
`o_price` varchar(50)    COMMENT '原价',
`type` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '类型（-1无1团购2砍价3限时抢购）',
`format` longtext()    COMMENT '多规格',
`time_start` datetime()    COMMENT '开始时间',
`time_end` datetime()    COMMENT '结束时间',
`cut_min` decimal(10,2)    COMMENT '砍价区间',
`cut_max` decimal(10,2)    COMMENT '砍价区间',
`group_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '团购人数',
`group_times` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '团购失败时间',
`group_status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '团购时单购状态',
`group_sold` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已团',
`content` longtext()    COMMENT '详情',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`index` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '首页显示',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`partner` varchar(50)    COMMENT '合作商',
`graphic_live` longtext()    COMMENT '图文直播',
`code` varchar(255)    COMMENT '二维码',
`video_live` longtext()    COMMENT '视频直播',
`fen_status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '分销功能',
`fen_ju_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '分销局部佣金',
`fen_one` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '一级佣金',
`fen_two` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '分销二级',
`fen_three` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '三级分销',
`partner_price` varchar(50)    COMMENT '平台佣金',
`fen_one2` decimal(10,2)    COMMENT '二级佣金',
`fen_two2` decimal(10,2)    COMMENT '二级佣金',
`fen_three2` decimal(10,2)    COMMENT '二级佣金',
`share_title` varchar(255)    COMMENT '分享标题',
`share_img` varchar(255)    COMMENT '分享图片',
`kucun` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '库存',
`yid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '云id',
`uid` int(11)  DEFAULT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_service_class` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`name` varchar(50)    COMMENT '名称',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型（1产品2拼购）',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_service_fen` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '用户id',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_shop` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(50)    COMMENT '用户id',
`pid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`format` varchar(255)    COMMENT '格式',
`format_index` int(11)  DEFAULT NULL DEFAULT '-1',
`price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_store_order` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(255),
`openid` varchar(50)    COMMENT '用户id',
`title` varchar(255)    COMMENT '标题',
`plan_date` varchar(50)    COMMENT '日期',
`type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型（1收入2提现）',
`out_trade_no` varchar(50)    COMMENT '订单号',
`amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '金额',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`username` varchar(50)    COMMENT '账号',
`bank` varchar(50)    COMMENT '开户行',
`name` varchar(50)    COMMENT '实名',
`order_type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '提现方式（1支付宝2银行卡）',
`admin` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '1合作商2分销商',
`fen_level` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '分销分级',
`fen_openid` varchar(50)    COMMENT '分销用户',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_topic` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`name` varchar(50)    COMMENT '名称',
`bimg` longtext()    COMMENT '图片',
`start_time` datetime()    COMMENT '开始时间',
`end_time` datetime()    COMMENT '结束时间',
`price` decimal(10,2)    COMMENT '价格',
`service` longtext()    COMMENT '产品详情',
`member` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '限购人数',
`sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`kucun` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '库存',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_trace` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`service_name` varchar(255)    COMMENT '产品名称',
`video` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '直播id',
`video_name` varchar(255)    COMMENT '直播名称',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态（-1待出售1已出售）',
`info` longtext()    COMMENT '自定义参数',
`member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '总数',
`code_start` varchar(50)    COMMENT '编码开头',
`code_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '随机位数',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_trace_code` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`code` varchar(50)    COMMENT '编码',
`pid` int(11)  DEFAULT NULL DEFAULT '0',
`service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id',
`service_name` varchar(255)    COMMENT '产品名称',
`video` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '直播id',
`video_name` varchar(255)    COMMENT '直播名称',
`status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态（-1待出售1已出售）',
`info` longtext()    COMMENT '自定义参数',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_userinfo` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` int(11)  DEFAULT NULL DEFAULT '0',
`openid` varchar(255)    COMMENT '用户id',
`avatar` varchar(255),
`nick` varchar(255),
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
`admin` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '经销商',
`partner` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '合作商',
`admin2` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '管理员',
`name` varchar(50)    COMMENT '姓名',
`mobile` varchar(50)    COMMENT '手机号',
`password` varchar(50)    COMMENT '密码',
`bind` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '绑定',
`logo` varchar(255)    COMMENT 'logo',
`back` varchar(255)    COMMENT '背景图片',
`store_code` varchar(255)    COMMENT '店铺二维码',
`store_amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '店铺收入',
`fen` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '分销商',
`fen_click` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '店铺点击量',
`fen_amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '分销收入',
`fen_all_amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '分销总收入',
`fen_back` varchar(255)    COMMENT '分销商背景',
`fen_logo` varchar(255)    COMMENT '分销商logo',
`fen_code` varchar(255)    COMMENT '分销二维码',
`fen_openid` varchar(50)    COMMENT '分销用户id',
`invite_code` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '邀请码',
`fen_code2` varchar(255)    COMMENT '分销二维码2',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_xc_farm_zan` (
`id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT,
`uniacid` varchar(50),
`openid` varchar(50)    COMMENT '用户id',
`pid` int(11)  DEFAULT NULL DEFAULT '0',
`status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`createtime` timestamp()  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `name` varchar(50)    COMMENT '标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `bimg` varchar(255)    COMMENT '封面';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '费用';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '人数';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'is_member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `is_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已报名人数';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'member_max')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `member_max` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '每单限人数';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'active_start')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `active_start` datetime(11)    COMMENT '活动开始时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'active_end')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `active_end` datetime(11)    COMMENT '活动结束时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'sign_start')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `sign_start` datetime(11)    COMMENT '报名开始时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'sign_end')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `sign_end` datetime(11)    COMMENT '报名结束时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `mobile` varchar(50)    COMMENT '手机号';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'address')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `address` varchar(255)    COMMENT '地址';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'longitude')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `longitude` decimal(10,7)    COMMENT '经度';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'latitude')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `latitude` decimal(10,7)    COMMENT '纬度';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `content` longtext(10,7)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'partner')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `partner` varchar(50)    COMMENT '合作商';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'partner_price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `partner_price` varchar(50)    COMMENT '平台佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'share_title')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `share_title` varchar(255)    COMMENT '分享标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_active')) {
 if(!pdo_fieldexists('ims_xc_farm_active',  'share_img')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_active')." ADD `share_img` varchar(255)    COMMENT '分享图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `name` varchar(50)    COMMENT '姓名';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `mobile` varchar(50)    COMMENT '手机号';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'sex')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `sex` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '性别';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'address')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `address` varchar(255)    COMMENT '地址';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'latitude')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `latitude` decimal(10,7)    COMMENT '经度';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'longitude')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `longitude` decimal(10,7)    COMMENT '纬度';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `content` longtext(10,7)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_address')) {
 if(!pdo_fieldexists('ims_xc_farm_address',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_address')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'title')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `title` varchar(50)    COMMENT '标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `content` longtext(11)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'info')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `info` longtext(11)    COMMENT '简介';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `bimg` varchar(255)    COMMENT '图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'detail')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `detail` longtext(255)    COMMENT '图文';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'sub_title')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `sub_title` varchar(50)    COMMENT '小标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_app')) {
 if(!pdo_fieldexists('ims_xc_farm_app',  'position')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app')." ADD `position` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '位置（1左2右）';");
 }
}
if(pdo_tableexists('ims_xc_farm_app_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_app_nav',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app_nav')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_app_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_app_nav',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app_nav')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_app_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_app_nav',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app_nav')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_app_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_app_nav',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app_nav')." ADD `cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '关联内容';");
 }
}
if(pdo_tableexists('ims_xc_farm_app_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_app_nav',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app_nav')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_app_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_app_nav',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app_nav')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_app_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_app_nav',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_app_nav')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '1项目合作2经销采购';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'type2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `type2` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'cname')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `cname` varchar(255)    COMMENT '企业名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'address')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `address` varchar(255)    COMMENT '地址';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'coname')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `coname` varchar(50)    COMMENT '法人';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `name` varchar(50)    COMMENT '联系人';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `mobile` varchar(50)    COMMENT '联系电话';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `content` longtext(50)    COMMENT '业务';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'cmobile')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `cmobile` varchar(50)    COMMENT '企业电话';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `createtime` timestamp(50)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'map')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `map` longtext(50)    COMMENT '定位';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'imgs')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `imgs` longtext(50)    COMMENT '图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'invite_code')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `invite_code` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '邀请码';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `service` longtext(11)    COMMENT '服务项目';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply')) {
 if(!pdo_fieldexists('ims_xc_farm_apply',  'service_format')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply')." ADD `service_format` longtext(11)    COMMENT '服务项目格式化';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply_class')) {
 if(!pdo_fieldexists('ims_xc_farm_apply_class',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply_class')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_apply_class')) {
 if(!pdo_fieldexists('ims_xc_farm_apply_class',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply_class')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply_class')) {
 if(!pdo_fieldexists('ims_xc_farm_apply_class',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply_class')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply_class')) {
 if(!pdo_fieldexists('ims_xc_farm_apply_class',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply_class')." ADD `type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型（1企业类型2合作类型）';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply_class')) {
 if(!pdo_fieldexists('ims_xc_farm_apply_class',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply_class')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply_class')) {
 if(!pdo_fieldexists('ims_xc_farm_apply_class',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply_class')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply_class')) {
 if(!pdo_fieldexists('ims_xc_farm_apply_class',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply_class')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_apply_class')) {
 if(!pdo_fieldexists('ims_xc_farm_apply_class',  'color')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_apply_class')." ADD `color` varchar(50)    COMMENT '背景颜色';");
 }
}
if(pdo_tableexists('ims_xc_farm_article')) {
 if(!pdo_fieldexists('ims_xc_farm_article',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_article')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_article')) {
 if(!pdo_fieldexists('ims_xc_farm_article',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_article')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_article')) {
 if(!pdo_fieldexists('ims_xc_farm_article',  'title')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_article')." ADD `title` varchar(255);");
 }
}
if(pdo_tableexists('ims_xc_farm_article')) {
 if(!pdo_fieldexists('ims_xc_farm_article',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_article')." ADD `type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型（1外链接2小程序）';");
 }
}
if(pdo_tableexists('ims_xc_farm_article')) {
 if(!pdo_fieldexists('ims_xc_farm_article',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_article')." ADD `content` longtext(11)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_article')) {
 if(!pdo_fieldexists('ims_xc_farm_article',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_article')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_banner')) {
 if(!pdo_fieldexists('ims_xc_farm_banner',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_banner')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_banner')) {
 if(!pdo_fieldexists('ims_xc_farm_banner',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_banner')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_banner')) {
 if(!pdo_fieldexists('ims_xc_farm_banner',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_banner')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_banner')) {
 if(!pdo_fieldexists('ims_xc_farm_banner',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_banner')." ADD `bimg` varchar(255)    COMMENT '图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_banner')) {
 if(!pdo_fieldexists('ims_xc_farm_banner',  'link')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_banner')." ADD `link` varchar(255)    COMMENT '链接';");
 }
}
if(pdo_tableexists('ims_xc_farm_banner')) {
 if(!pdo_fieldexists('ims_xc_farm_banner',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_banner')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_banner')) {
 if(!pdo_fieldexists('ims_xc_farm_banner',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_banner')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_banner')) {
 if(!pdo_fieldexists('ims_xc_farm_banner',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_banner')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'title')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `title` varchar(255)    COMMENT '标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'subtitle')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `subtitle` varchar(255)    COMMENT '副标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `bimg` varchar(255)    COMMENT '封面';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型（1众筹2认养3租用）';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'funds')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `funds` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '资金';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'is_funds')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `is_funds` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '已筹集资金';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'is_member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `is_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已售';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'discuss')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `discuss` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '评论数';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `mobile` varchar(50)    COMMENT '联系方式';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `name` varchar(255)    COMMENT '责任人';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'time_start')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `time_start` datetime(255)    COMMENT '开始时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'time_end')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `time_end` datetime(255)    COMMENT '结束时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'info')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `info` longtext(255)    COMMENT '项目信息';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `content` longtext(255)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'video_live')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `video_live` longtext(255)    COMMENT '视频直播';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'graphic_live')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `graphic_live` longtext(255)    COMMENT '图文直播';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'income')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `income` longtext(255)    COMMENT '收益';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'index')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `index` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '首页显示';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'use_start')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `use_start` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '使用时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'use_end')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `use_end` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '使用时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'end_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `end_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '结束处理（-1未处理1手动成功2退款）';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'fen_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `fen_status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '分销功能';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'fen_ju_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `fen_ju_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '分销局部佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'fen_one')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `fen_one` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '一级佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'fen_two')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `fen_two` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '分销二级';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'fen_three')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `fen_three` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '三级分销';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'fen_one2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `fen_one2` decimal(10,2)    COMMENT '二级佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'fen_two2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `fen_two2` decimal(10,2)    COMMENT '二级佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'fen_three2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `fen_three2` decimal(10,2)    COMMENT '二级佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'share_title')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `share_title` varchar(255)    COMMENT '分享标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf')) {
 if(!pdo_fieldexists('ims_xc_farm_cf',  'share_img')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf')." ADD `share_img` varchar(255)    COMMENT '分享图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'out_trade_no')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `out_trade_no` varchar(50)    COMMENT '订单';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'service_name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `service_name` varchar(255)    COMMENT '产品名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'format')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `format` varchar(50)    COMMENT '规格';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'format_index')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `format_index` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '规格';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'time_start')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `time_start` datetime(11)    COMMENT '使用时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'time_end')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `time_end` datetime(11)    COMMENT '使用时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态（-1未使用1已使用）';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cf_card')) {
 if(!pdo_fieldexists('ims_xc_farm_cf_card',  'type2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cf_card')." ADD `type2` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型（1众筹2认养3租用）';");
 }
}
if(pdo_tableexists('ims_xc_farm_config')) {
 if(!pdo_fieldexists('ims_xc_farm_config',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_config')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_config')) {
 if(!pdo_fieldexists('ims_xc_farm_config',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_config')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_config')) {
 if(!pdo_fieldexists('ims_xc_farm_config',  'xkey')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_config')." ADD `xkey` varchar(50)    COMMENT '关键字';");
 }
}
if(pdo_tableexists('ims_xc_farm_config')) {
 if(!pdo_fieldexists('ims_xc_farm_config',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_config')." ADD `content` longtext(50)    COMMENT '内容';");
 }
}
if(pdo_tableexists('ims_xc_farm_count')) {
 if(!pdo_fieldexists('ims_xc_farm_count',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_count')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_count')) {
 if(!pdo_fieldexists('ims_xc_farm_count',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_count')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_count')) {
 if(!pdo_fieldexists('ims_xc_farm_count',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_count')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_count')) {
 if(!pdo_fieldexists('ims_xc_farm_count',  'format')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_count')." ADD `format` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_count')) {
 if(!pdo_fieldexists('ims_xc_farm_count',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_count')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '销量';");
 }
}
if(pdo_tableexists('ims_xc_farm_count')) {
 if(!pdo_fieldexists('ims_xc_farm_count',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_count')." ADD `createtime` datetime(11)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '优惠价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'condition')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `condition` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '满足价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'time_start')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `time_start` datetime(10,2)    COMMENT '有效期';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'time_end')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `time_end` datetime(10,2)    COMMENT '有效期';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon_log')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon_log',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon_log')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon_log')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon_log',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon_log')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon_log')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon_log',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon_log')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon_log')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon_log',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon_log')." ADD `cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '优惠券id';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon_log')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon_log',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon_log')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_coupon_log')) {
 if(!pdo_fieldexists('ims_xc_farm_coupon_log',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_coupon_log')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'format_index')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `format_index` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '规格';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `price` decimal(10,2)    COMMENT '价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'min_price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `min_price` decimal(10,2)    COMMENT '最低价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'o_price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `o_price` decimal(10,2)    COMMENT '原价';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '1最小价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut')) {
 if(!pdo_fieldexists('ims_xc_farm_cut',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut_log')) {
 if(!pdo_fieldexists('ims_xc_farm_cut_log',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut_log')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_cut_log')) {
 if(!pdo_fieldexists('ims_xc_farm_cut_log',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut_log')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut_log')) {
 if(!pdo_fieldexists('ims_xc_farm_cut_log',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut_log')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut_log')) {
 if(!pdo_fieldexists('ims_xc_farm_cut_log',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut_log')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut_log')) {
 if(!pdo_fieldexists('ims_xc_farm_cut_log',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut_log')." ADD `price` decimal(10,2)    COMMENT '砍去的价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut_log')) {
 if(!pdo_fieldexists('ims_xc_farm_cut_log',  'cut_openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut_log')." ADD `cut_openid` varchar(50)    COMMENT '砍的用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_cut_log')) {
 if(!pdo_fieldexists('ims_xc_farm_cut_log',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_cut_log')." ADD `createtime` timestamp(50)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_discuss')) {
 if(!pdo_fieldexists('ims_xc_farm_discuss',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_discuss')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_discuss')) {
 if(!pdo_fieldexists('ims_xc_farm_discuss',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_discuss')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_discuss')) {
 if(!pdo_fieldexists('ims_xc_farm_discuss',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_discuss')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_discuss')) {
 if(!pdo_fieldexists('ims_xc_farm_discuss',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_discuss')." ADD `type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '1产品评价2众筹评价3新闻评价';");
 }
}
if(pdo_tableexists('ims_xc_farm_discuss')) {
 if(!pdo_fieldexists('ims_xc_farm_discuss',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_discuss')." ADD `pid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_discuss')) {
 if(!pdo_fieldexists('ims_xc_farm_discuss',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_discuss')." ADD `content` longtext(11)    COMMENT '内容';");
 }
}
if(pdo_tableexists('ims_xc_farm_discuss')) {
 if(!pdo_fieldexists('ims_xc_farm_discuss',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_discuss')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_discuss')) {
 if(!pdo_fieldexists('ims_xc_farm_discuss',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_discuss')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_discuss')) {
 if(!pdo_fieldexists('ims_xc_farm_discuss',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_discuss')." ADD `bimg` longtext(11)    COMMENT '图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `openid` varchar(50)    COMMENT '团长';");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'is_member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `is_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已有人数';");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '所需人数';");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '开团时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'failtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `failtime` datetime(11)    COMMENT '结束时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态（-1拼团中1拼团成功2已失败）';");
 }
}
if(pdo_tableexists('ims_xc_farm_group')) {
 if(!pdo_fieldexists('ims_xc_farm_group',  'group')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_group')." ADD `group` longtext(11)    COMMENT '团成员';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '分类';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'simg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `simg` varchar(255)    COMMENT '封面';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `bimg` longtext(255)    COMMENT '图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'member_on')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `member_on` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已种植土地';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '土地';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'seed_member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `seed_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '每份土地可种种子数';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'seed_list')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `seed_list` longtext(11)    COMMENT '可中的种子';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'seed_id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `seed_id` longtext(11)    COMMENT '播种id';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'fail_date')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `fail_date` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '失败时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'video')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `video` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '直播';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `content` longtext(11)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_land')) {
 if(!pdo_fieldexists('ims_xc_farm_land',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land')." ADD `createtime` datetime(11)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `openid` varchar(50)    COMMENT '团长';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'land')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `land` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '土地';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'seed')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `seed` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '种子';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'member_on')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `member_on` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已种种子';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '种子';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'group')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `group` longtext(11)    COMMENT '团成员';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态-1拼种种1成功2失败';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `createtime` datetime(11)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_land_group')) {
 if(!pdo_fieldexists('ims_xc_farm_land_group',  'failtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_land_group')." ADD `failtime` datetime(11)    COMMENT '失败时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '分类';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `bimg` varchar(255)    COMMENT '封面';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'link')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `link` varchar(255)    COMMENT '链接';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'video')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `video` varchar(255)    COMMENT '链接';");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'vid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `vid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_live')) {
 if(!pdo_fieldexists('ims_xc_farm_live',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live')." ADD `content` longtext(50)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_live_class')) {
 if(!pdo_fieldexists('ims_xc_farm_live_class',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live_class')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_live_class')) {
 if(!pdo_fieldexists('ims_xc_farm_live_class',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live_class')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_live_class')) {
 if(!pdo_fieldexists('ims_xc_farm_live_class',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live_class')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_live_class')) {
 if(!pdo_fieldexists('ims_xc_farm_live_class',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live_class')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_live_class')) {
 if(!pdo_fieldexists('ims_xc_farm_live_class',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live_class')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_live_class')) {
 if(!pdo_fieldexists('ims_xc_farm_live_class',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_live_class')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_log')) {
 if(!pdo_fieldexists('ims_xc_farm_log',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_log')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_log')) {
 if(!pdo_fieldexists('ims_xc_farm_log',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_log')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_log')) {
 if(!pdo_fieldexists('ims_xc_farm_log',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_log')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_log')) {
 if(!pdo_fieldexists('ims_xc_farm_log',  'plan_date')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_log')." ADD `plan_date` varchar(50)    COMMENT '日期';");
 }
}
if(pdo_tableexists('ims_xc_farm_log')) {
 if(!pdo_fieldexists('ims_xc_farm_log',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_log')." ADD `createtime` datetime(50)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_moban_user')) {
 if(!pdo_fieldexists('ims_xc_farm_moban_user',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_moban_user')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_moban_user')) {
 if(!pdo_fieldexists('ims_xc_farm_moban_user',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_moban_user')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_moban_user')) {
 if(!pdo_fieldexists('ims_xc_farm_moban_user',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_moban_user')." ADD `openid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_moban_user')) {
 if(!pdo_fieldexists('ims_xc_farm_moban_user',  'nickname')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_moban_user')." ADD `nickname` varchar(500)    COMMENT '呢称';");
 }
}
if(pdo_tableexists('ims_xc_farm_moban_user')) {
 if(!pdo_fieldexists('ims_xc_farm_moban_user',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_moban_user')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '-1未使用  1已使用';");
 }
}
if(pdo_tableexists('ims_xc_farm_moban_user')) {
 if(!pdo_fieldexists('ims_xc_farm_moban_user',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_moban_user')." ADD `createtime` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '发布日期';");
 }
}
if(pdo_tableexists('ims_xc_farm_moban_user')) {
 if(!pdo_fieldexists('ims_xc_farm_moban_user',  'ident')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_moban_user')." ADD `ident` varchar(50)    COMMENT '标识';");
 }
}
if(pdo_tableexists('ims_xc_farm_moban_user')) {
 if(!pdo_fieldexists('ims_xc_farm_moban_user',  'headimgurl')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_moban_user')." ADD `headimgurl` varchar(500)    COMMENT '头像';");
 }
}
if(pdo_tableexists('ims_xc_farm_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_nav',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_nav')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_nav',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_nav')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_nav',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_nav')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_nav',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_nav')." ADD `bimg` varchar(255)    COMMENT '图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_nav',  'link')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_nav')." ADD `link` varchar(255)    COMMENT '链接';");
 }
}
if(pdo_tableexists('ims_xc_farm_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_nav',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_nav')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_nav',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_nav')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_nav')) {
 if(!pdo_fieldexists('ims_xc_farm_nav',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_nav')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'title')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `title` varchar(255)    COMMENT '标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `bimg` varchar(255)    COMMENT '封面';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'click')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `click` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '浏览数';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'zan')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `zan` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '点赞数';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'discuss')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `discuss` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '评论数';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '关联产品';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'service_name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `service_name` varchar(50)    COMMENT '产品名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `content` longtext(50)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_news')) {
 if(!pdo_fieldexists('ims_xc_farm_news',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_news')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_online')) {
 if(!pdo_fieldexists('ims_xc_farm_online',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_online')) {
 if(!pdo_fieldexists('ims_xc_farm_online',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_online')) {
 if(!pdo_fieldexists('ims_xc_farm_online',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_online')) {
 if(!pdo_fieldexists('ims_xc_farm_online',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '未读条数';");
 }
}
if(pdo_tableexists('ims_xc_farm_online')) {
 if(!pdo_fieldexists('ims_xc_farm_online',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online')." ADD `type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型';");
 }
}
if(pdo_tableexists('ims_xc_farm_online')) {
 if(!pdo_fieldexists('ims_xc_farm_online',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online')." ADD `content` longtext(11)    COMMENT '内容';");
 }
}
if(pdo_tableexists('ims_xc_farm_online')) {
 if(!pdo_fieldexists('ims_xc_farm_online',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online')." ADD `updatetime` varchar(50)    COMMENT '更新时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_online')) {
 if(!pdo_fieldexists('ims_xc_farm_online',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online')." ADD `createtime` timestamp(50)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_online_log')) {
 if(!pdo_fieldexists('ims_xc_farm_online_log',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online_log')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_online_log')) {
 if(!pdo_fieldexists('ims_xc_farm_online_log',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online_log')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_online_log')) {
 if(!pdo_fieldexists('ims_xc_farm_online_log',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online_log')." ADD `pid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_online_log')) {
 if(!pdo_fieldexists('ims_xc_farm_online_log',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online_log')." ADD `openid` varchar(50)    COMMENT '发送者用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_online_log')) {
 if(!pdo_fieldexists('ims_xc_farm_online_log',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online_log')." ADD `type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '类型1文本2图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_online_log')) {
 if(!pdo_fieldexists('ims_xc_farm_online_log',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online_log')." ADD `content` longtext(11)    COMMENT '内容';");
 }
}
if(pdo_tableexists('ims_xc_farm_online_log')) {
 if(!pdo_fieldexists('ims_xc_farm_online_log',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online_log')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_online_log')) {
 if(!pdo_fieldexists('ims_xc_farm_online_log',  'duty')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_online_log')." ADD `duty` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '身份1客户2客服';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'out_trade_no')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `out_trade_no` varchar(50)    COMMENT '订单号';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'wx_out_trade_no')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `wx_out_trade_no` varchar(50)    COMMENT '商户订单号';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'services')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `services` longtext(11)    COMMENT '项目';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'service_name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `service_name` varchar(255)    COMMENT '产品名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'format')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `format` varchar(255)    COMMENT '规格';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'format_index')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `format_index` int(11)  DEFAULT NULL DEFAULT '-1';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '单价';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'is_member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `is_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '核销次数';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `amount` decimal(10,2)    COMMENT '应付款';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'o_amount')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `o_amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '实付款';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'order_type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `order_type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '订单类型（1活动报名2众筹3产品）';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'type2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `type2` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '众筹（1众筹2租用3认养）产品（1单买2团购3砍价4限时5兑换）';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'order_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `order_status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '1待发货2待收货3待评价4已完成';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `name` varchar(50)    COMMENT '姓名';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `mobile` varchar(50)    COMMENT '手机';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'address')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `address` longtext(50)    COMMENT '地址';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `createtime` timestamp(50)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'form_id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `form_id` varchar(255);");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `content` longtext(255)    COMMENT '备注';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'income')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `income` longtext(255)    COMMENT '收益';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'coupon')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `coupon` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '优惠券id';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'coupon_price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `coupon_price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '优惠价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'cf_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `cf_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '-1筹集中1已完成2已退款';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'cf_card')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `cf_card` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '兑换券';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'group')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `group` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '团id';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'group_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `group_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '团状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'fen_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `fen_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '未分销';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'fen_openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `fen_openid` varchar(50)    COMMENT '分销用户';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'fen_price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `fen_price` decimal(10,2)    COMMENT '分销金额';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'partner_price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `partner_price` decimal(10,2)    COMMENT '平台佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'fen_openid2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `fen_openid2` varchar(50)    COMMENT '二级分销';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'fen_price2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `fen_price2` decimal(10,2)    COMMENT '二级分销金额';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'callback1')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `callback1` longtext(10,2)    COMMENT '打印1回调';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'callback2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `callback2` longtext(10,2)    COMMENT '打印2';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'topic')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `topic` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '专题id';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'topic_price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `topic_price` varchar(50)    COMMENT '折扣';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'plan_date')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `plan_date` varchar(50)    COMMENT '预约时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'tui_content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `tui_content` longtext(50)    COMMENT '退款理由';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'pin_name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `pin_name` varchar(50)    COMMENT '拼团名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'pin_simg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `pin_simg` varchar(255)    COMMENT '拼团图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_order')) {
 if(!pdo_fieldexists('ims_xc_farm_order',  'transaction_id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_order')." ADD `transaction_id` varchar(255)    COMMENT '微信订单号';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '分类';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'simg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `simg` varchar(255)    COMMENT '封面';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `price` decimal(10,2)    COMMENT '价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'tag')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `tag` longtext(10,2)    COMMENT '标签';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `bimg` longtext(10,2)    COMMENT '图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'sold')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `sold` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已拼';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'discuss')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `discuss` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '评论数';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `content` longtext(11)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin')) {
 if(!pdo_fieldexists('ims_xc_farm_pin',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin')." ADD `createtime` datetime(11)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `pid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'start_time')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `start_time` datetime(11)    COMMENT '开始时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `end_time` datetime(11)    COMMENT '结束时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '总数';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'member_on')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `member_on` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已拼数量';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '-1拼购中1拼购成功2拼购失败';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `content` longtext(11)    COMMENT '拼购内容';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group')." ADD `createtime` datetime(11)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `pid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'gid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `gid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'simg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `simg` varchar(255)    COMMENT '图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'member_on')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `member_on` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已出售数量';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'weight')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `weight` varchar(50)    COMMENT '分量';");
 }
}
if(pdo_tableexists('ims_xc_farm_pin_group_detail')) {
 if(!pdo_fieldexists('ims_xc_farm_pin_group_detail',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_pin_group_detail')." ADD `createtime` datetime(50)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `cid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '分类';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'simg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `simg` varchar(255)    COMMENT '封面';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'plan_date')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `plan_date` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '生长周期';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'weight')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `weight` varchar(255)    COMMENT '分量';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'income')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `income` longtext(10,2)    COMMENT '收益';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'dui_date')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `dui_date` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '兑换周期';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `content` longtext(11)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_seed')) {
 if(!pdo_fieldexists('ims_xc_farm_seed',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_seed')." ADD `createtime` datetime(11)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'subtitle')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `subtitle` varchar(255)    COMMENT '副标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `cid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'simg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `simg` varchar(255)    COMMENT '封面';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `bimg` longtext(255)    COMMENT '产品图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'discuss')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `discuss` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '评论人数';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'sold')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `sold` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已售人数';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'o_price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `o_price` varchar(50)    COMMENT '原价';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `type` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '类型（-1无1团购2砍价3限时抢购）';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'format')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `format` longtext(11)    COMMENT '多规格';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'time_start')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `time_start` datetime(11)    COMMENT '开始时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'time_end')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `time_end` datetime(11)    COMMENT '结束时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'cut_min')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `cut_min` decimal(10,2)    COMMENT '砍价区间';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'cut_max')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `cut_max` decimal(10,2)    COMMENT '砍价区间';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'group_member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `group_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '团购人数';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'group_times')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `group_times` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '团购失败时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'group_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `group_status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '团购时单购状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'group_sold')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `group_sold` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '已团';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'content')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `content` longtext(11)    COMMENT '详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'index')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `index` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '首页显示';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'partner')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `partner` varchar(50)    COMMENT '合作商';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'graphic_live')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `graphic_live` longtext(50)    COMMENT '图文直播';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'code')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `code` varchar(255)    COMMENT '二维码';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'video_live')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `video_live` longtext(255)    COMMENT '视频直播';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'fen_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `fen_status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '分销功能';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'fen_ju_status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `fen_ju_status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '分销局部佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'fen_one')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `fen_one` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '一级佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'fen_two')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `fen_two` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '分销二级';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'fen_three')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `fen_three` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '三级分销';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'partner_price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `partner_price` varchar(50)    COMMENT '平台佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'fen_one2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `fen_one2` decimal(10,2)    COMMENT '二级佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'fen_two2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `fen_two2` decimal(10,2)    COMMENT '二级佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'fen_three2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `fen_three2` decimal(10,2)    COMMENT '二级佣金';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'share_title')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `share_title` varchar(255)    COMMENT '分享标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'share_img')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `share_img` varchar(255)    COMMENT '分享图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'kucun')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `kucun` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '库存';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'yid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `yid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '云id';");
 }
}
if(pdo_tableexists('ims_xc_farm_service')) {
 if(!pdo_fieldexists('ims_xc_farm_service',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service')." ADD `uid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_class')) {
 if(!pdo_fieldexists('ims_xc_farm_service_class',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_class')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_service_class')) {
 if(!pdo_fieldexists('ims_xc_farm_service_class',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_class')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_service_class')) {
 if(!pdo_fieldexists('ims_xc_farm_service_class',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_class')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_class')) {
 if(!pdo_fieldexists('ims_xc_farm_service_class',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_class')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_class')) {
 if(!pdo_fieldexists('ims_xc_farm_service_class',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_class')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_class')) {
 if(!pdo_fieldexists('ims_xc_farm_service_class',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_class')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_class')) {
 if(!pdo_fieldexists('ims_xc_farm_service_class',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_class')." ADD `type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型（1产品2拼购）';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_fen')) {
 if(!pdo_fieldexists('ims_xc_farm_service_fen',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_fen')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_service_fen')) {
 if(!pdo_fieldexists('ims_xc_farm_service_fen',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_fen')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_fen')) {
 if(!pdo_fieldexists('ims_xc_farm_service_fen',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_fen')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_fen')) {
 if(!pdo_fieldexists('ims_xc_farm_service_fen',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_fen')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_fen')) {
 if(!pdo_fieldexists('ims_xc_farm_service_fen',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_fen')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_service_fen')) {
 if(!pdo_fieldexists('ims_xc_farm_service_fen',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_service_fen')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `pid` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'format')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `format` varchar(255)    COMMENT '格式';");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'format_index')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `format_index` int(11)  DEFAULT NULL DEFAULT '-1';");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `price` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '数量';");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_shop')) {
 if(!pdo_fieldexists('ims_xc_farm_shop',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_shop')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `uniacid` varchar(255);");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'title')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `title` varchar(255)    COMMENT '标题';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'plan_date')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `plan_date` varchar(50)    COMMENT '日期';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `type` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '类型（1收入2提现）';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'out_trade_no')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `out_trade_no` varchar(50)    COMMENT '订单号';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '金额';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'username')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `username` varchar(50)    COMMENT '账号';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'bank')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `bank` varchar(50)    COMMENT '开户行';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `name` varchar(50)    COMMENT '实名';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'order_type')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `order_type` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '提现方式（1支付宝2银行卡）';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'admin')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `admin` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '1合作商2分销商';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'fen_level')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `fen_level` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '分销分级';");
 }
}
if(pdo_tableexists('ims_xc_farm_store_order')) {
 if(!pdo_fieldexists('ims_xc_farm_store_order',  'fen_openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_store_order')." ADD `fen_openid` varchar(50)    COMMENT '分销用户';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `name` varchar(50)    COMMENT '名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'bimg')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `bimg` longtext(50)    COMMENT '图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'start_time')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `start_time` datetime(50)    COMMENT '开始时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `end_time` datetime(50)    COMMENT '结束时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'price')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `price` decimal(10,2)    COMMENT '价格';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `service` longtext(10,2)    COMMENT '产品详情';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `member` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '限购人数';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `sort` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '排序';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_topic')) {
 if(!pdo_fieldexists('ims_xc_farm_topic',  'kucun')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_topic')." ADD `kucun` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '库存';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'service_name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `service_name` varchar(255)    COMMENT '产品名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'video')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `video` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '直播id';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'video_name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `video_name` varchar(255)    COMMENT '直播名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态（-1待出售1已出售）';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'info')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `info` longtext(11)    COMMENT '自定义参数';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '总数';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'code_start')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `code_start` varchar(50)    COMMENT '编码开头';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'code_member')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `code_member` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '随机位数';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace')) {
 if(!pdo_fieldexists('ims_xc_farm_trace',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'code')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `code` varchar(50)    COMMENT '编码';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `pid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'service')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `service` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '产品id';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'service_name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `service_name` varchar(255)    COMMENT '产品名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'video')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `video` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '直播id';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'video_name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `video_name` varchar(255)    COMMENT '直播名称';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `status` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '状态（-1待出售1已出售）';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'info')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `info` longtext(11)    COMMENT '自定义参数';");
 }
}
if(pdo_tableexists('ims_xc_farm_trace_code')) {
 if(!pdo_fieldexists('ims_xc_farm_trace_code',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_trace_code')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `uniacid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `openid` varchar(255)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'avatar')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `avatar` varchar(255);");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'nick')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `nick` varchar(255);");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `createtime` timestamp(255)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'admin')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `admin` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '经销商';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'partner')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `partner` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '合作商';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'admin2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `admin2` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '管理员';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'name')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `name` varchar(50)    COMMENT '姓名';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `mobile` varchar(50)    COMMENT '手机号';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'password')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `password` varchar(50)    COMMENT '密码';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'bind')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `bind` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '绑定';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'logo')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `logo` varchar(255)    COMMENT 'logo';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'back')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `back` varchar(255)    COMMENT '背景图片';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'store_code')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `store_code` varchar(255)    COMMENT '店铺二维码';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'store_amount')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `store_amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '店铺收入';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'fen')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `fen` int(11)  DEFAULT NULL DEFAULT '-1'  COMMENT '分销商';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'fen_click')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `fen_click` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '店铺点击量';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'fen_amount')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `fen_amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '分销收入';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'fen_all_amount')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `fen_all_amount` decimal(10,2)  DEFAULT NULL DEFAULT '0.00'  COMMENT '分销总收入';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'fen_back')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `fen_back` varchar(255)    COMMENT '分销商背景';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'fen_logo')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `fen_logo` varchar(255)    COMMENT '分销商logo';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'fen_code')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `fen_code` varchar(255)    COMMENT '分销二维码';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'fen_openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `fen_openid` varchar(50)    COMMENT '分销用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'invite_code')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `invite_code` int(11)  DEFAULT NULL DEFAULT '0'  COMMENT '邀请码';");
 }
}
if(pdo_tableexists('ims_xc_farm_userinfo')) {
 if(!pdo_fieldexists('ims_xc_farm_userinfo',  'fen_code2')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_userinfo')." ADD `fen_code2` varchar(255)    COMMENT '分销二维码2';");
 }
}
if(pdo_tableexists('ims_xc_farm_zan')) {
 if(!pdo_fieldexists('ims_xc_farm_zan',  'id')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_zan')." ADD `id` int(11) NOT NULL DEFAULT NULL DEFAULT '0' AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('ims_xc_farm_zan')) {
 if(!pdo_fieldexists('ims_xc_farm_zan',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_zan')." ADD `uniacid` varchar(50);");
 }
}
if(pdo_tableexists('ims_xc_farm_zan')) {
 if(!pdo_fieldexists('ims_xc_farm_zan',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_zan')." ADD `openid` varchar(50)    COMMENT '用户id';");
 }
}
if(pdo_tableexists('ims_xc_farm_zan')) {
 if(!pdo_fieldexists('ims_xc_farm_zan',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_zan')." ADD `pid` int(11)  DEFAULT NULL DEFAULT '0';");
 }
}
if(pdo_tableexists('ims_xc_farm_zan')) {
 if(!pdo_fieldexists('ims_xc_farm_zan',  'status')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_zan')." ADD `status` int(11)  DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('ims_xc_farm_zan')) {
 if(!pdo_fieldexists('ims_xc_farm_zan',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('ims_xc_farm_zan')." ADD `createtime` timestamp(11)  DEFAULT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '添加时间';");
 }
}
