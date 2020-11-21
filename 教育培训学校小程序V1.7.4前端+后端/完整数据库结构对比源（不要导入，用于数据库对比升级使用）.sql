
DROP TABLE IF EXISTS `ims_xc_train_active`;
CREATE TABLE `ims_xc_train_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `simg` varchar(255) DEFAULT NULL COMMENT '顶部图片',
  `bimg` varchar(255) DEFAULT NULL COMMENT '奖品图片',
  `prize` varchar(255) DEFAULT NULL COMMENT '奖品名称',
  `share` int(11) DEFAULT NULL COMMENT '分享次数',
  `content` longtext COMMENT '活动规则',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `start_time` varchar(50) DEFAULT NULL COMMENT '开始时间',
  `end_time` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `link` varchar(255) DEFAULT NULL COMMENT '外链接',
  `total` int(11) DEFAULT '0' COMMENT '数量',
  `share_img` varchar(255) DEFAULT NULL COMMENT '分享图片',
  `is_total` int(11) DEFAULT '0' COMMENT '已集齐数量',
  `share_type` int(11) DEFAULT '1' COMMENT '分享类型（1分享2分享点击）',
  `type` int(11) DEFAULT '1' COMMENT '类型（1集卡2刮刮卡）',
  `list` longtext COMMENT '奖品',
  `gua_img` varchar(255) DEFAULT NULL COMMENT '刮刮卡图片',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠活动';

-- ----------------------------
-- Table structure for ims_xc_train_address
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_address`;
CREATE TABLE `ims_xc_train_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号',
  `sex` int(11) DEFAULT '1' COMMENT '性别',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `latitude` decimal(10,7) DEFAULT NULL COMMENT '经度',
  `longitude` decimal(10,7) DEFAULT NULL COMMENT '纬度',
  `content` longtext COMMENT '详情',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`openid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地址';

-- ----------------------------
-- Table structure for ims_xc_train_apply
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_apply`;
CREATE TABLE `ims_xc_train_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '电话',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1审核中1审核通过2失败3失败已阅）',
  `createtime` datetime DEFAULT NULL COMMENT '申请时间',
  `applytime` datetime DEFAULT NULL COMMENT '处理时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`,`applytime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='审核';

-- ----------------------------
-- Table structure for ims_xc_train_article
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_article`;
CREATE TABLE `ims_xc_train_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext COMMENT '详情',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT NULL COMMENT '类型（1普通文章2优惠活动文章）',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `btn` varchar(255) DEFAULT NULL COMMENT '按钮文字',
  `link_type` int(11) DEFAULT '1' COMMENT '模式',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章';

-- ----------------------------
-- Table structure for ims_xc_train_audio
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_audio`;
CREATE TABLE `ims_xc_train_audio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '标题',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格',
  `member` int(11) DEFAULT NULL COMMENT '集数',
  `sold` int(11) DEFAULT '0' COMMENT '销售数',
  `mark` int(11) DEFAULT '0' COMMENT '收藏人数',
  `code` varchar(255) DEFAULT NULL COMMENT '二维码',
  `content` longtext COMMENT '详情',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`cid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='音频';

-- ----------------------------
-- Table structure for ims_xc_train_audio_item
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_audio_item`;
CREATE TABLE `ims_xc_train_audio_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `audio` varchar(255) DEFAULT NULL COMMENT '音频',
  `click` int(11) DEFAULT '0' COMMENT '点击数',
  `try` int(11) DEFAULT '-1' COMMENT '试听',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='音频';

-- ----------------------------
-- Table structure for ims_xc_train_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_banner`;
CREATE TABLE `ims_xc_train_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `bimg` varchar(255) DEFAULT NULL COMMENT '图片',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='轮播图';

-- ----------------------------
-- Table structure for ims_xc_train_config
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_config`;
CREATE TABLE `ims_xc_train_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `xkey` varchar(50) DEFAULT NULL COMMENT '关键字',
  `content` longtext COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`xkey`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='配置';

-- ----------------------------
-- Table structure for ims_xc_train_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_coupon`;
CREATE TABLE `ims_xc_train_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '优惠价格',
  `condition` varchar(50) DEFAULT NULL COMMENT '满足条件',
  `times` longtext COMMENT '有效期',
  `total` int(11) DEFAULT '-1' COMMENT '总量',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='优惠券';

-- ----------------------------
-- Table structure for ims_xc_train_cut
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_cut`;
CREATE TABLE `ims_xc_train_cut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `mark` varchar(255) DEFAULT NULL COMMENT '标记',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `is_member` int(11) DEFAULT '0' COMMENT '已有人数',
  `member` int(11) DEFAULT NULL COMMENT '人数',
  `join_member` int(11) DEFAULT '0' COMMENT '参与人数',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `cut_price` decimal(10,2) DEFAULT NULL COMMENT '最低价',
  `max_price` decimal(10,2) DEFAULT NULL COMMENT '砍价区间',
  `min_price` decimal(10,2) DEFAULT NULL COMMENT '砍价区间',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `link` text COMMENT '虚拟人数',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价';

-- ----------------------------
-- Table structure for ims_xc_train_cut_log
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_cut_log`;
CREATE TABLE `ims_xc_train_cut_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL COMMENT '砍去的价格',
  `cut_openid` varchar(50) DEFAULT NULL COMMENT '帮砍的用户id',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`cid`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价记录';

-- ----------------------------
-- Table structure for ims_xc_train_cut_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_cut_order`;
CREATE TABLE `ims_xc_train_cut_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `is_min` int(11) DEFAULT '-1' COMMENT '最低价',
  `status` int(11) DEFAULT '-1' COMMENT '购买状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`is_min`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价订单';

-- ----------------------------
-- Table structure for ims_xc_train_discuss
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_discuss`;
CREATE TABLE `ims_xc_train_discuss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `content` longtext COMMENT '详情',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1课程2视频）',
  `reply_status` int(11) DEFAULT '-1' COMMENT '回复状态',
  `reply_content` longtext COMMENT '回复内容',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论';

-- ----------------------------
-- Table structure for ims_xc_train_group
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_group`;
CREATE TABLE `ims_xc_train_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '团长',
  `service` int(11) DEFAULT NULL COMMENT '产品id',
  `is_member` int(11) DEFAULT '0' COMMENT '已有人数',
  `member` int(11) DEFAULT NULL COMMENT '所需人数',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '开团时间',
  `failtime` datetime DEFAULT NULL COMMENT '结束时间',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1拼团中1拼团成功2已失败）',
  `group` longtext COMMENT '团成员',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`,`failtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购';

-- ----------------------------
-- Table structure for ims_xc_train_group_service
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_group_service`;
CREATE TABLE `ims_xc_train_group_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `service` int(11) DEFAULT NULL COMMENT '课程id',
  `member_on` int(11) DEFAULT '0' COMMENT '已有人数',
  `member` int(11) DEFAULT '0' COMMENT '人数',
  `group_price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `failtime` datetime DEFAULT NULL COMMENT '失败时间',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1拼团中1成功2失败）',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购课程';

-- ----------------------------
-- Table structure for ims_xc_train_gua
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_gua`;
CREATE TABLE `ims_xc_train_gua` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `bimg` varchar(255) DEFAULT NULL COMMENT '图片',
  `times` int(11) DEFAULT NULL COMMENT '概率',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='奖品';

-- ----------------------------
-- Table structure for ims_xc_train_history
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_history`;
CREATE TABLE `ims_xc_train_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `pid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '状态',
  `createtime` datetime DEFAULT NULL COMMENT '时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1音频2视频）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='历史';

-- ----------------------------
-- Table structure for ims_xc_train_line
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_line`;
CREATE TABLE `ims_xc_train_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `simg` varchar(255) DEFAULT NULL COMMENT '图片',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `click` int(11) DEFAULT '0' COMMENT '浏览量',
  `video` longtext COMMENT '视频',
  `audio` longtext COMMENT '音频',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `content` longtext COMMENT '详情',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='礼包';

-- ----------------------------
-- Table structure for ims_xc_train_line_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_line_order`;
CREATE TABLE `ims_xc_train_line_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `line` int(11) DEFAULT NULL COMMENT '礼包id',
  `type` int(11) DEFAULT NULL COMMENT '类型（1视频2音频）',
  `pid` int(11) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`type`,`pid`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购买记录';

-- ----------------------------
-- Table structure for ims_xc_train_login_log
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_login_log`;
CREATE TABLE `ims_xc_train_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL COMMENT '用户id',
  `plan_date` varchar(50) DEFAULT NULL COMMENT '日期',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志';

-- ----------------------------
-- Table structure for ims_xc_train_mall
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_mall`;
CREATE TABLE `ims_xc_train_mall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `title` varchar(255) DEFAULT NULL COMMENT '副标题',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `bimg` longtext,
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `format` longtext COMMENT '多规格',
  `sold` int(11) DEFAULT '0',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `content` longtext COMMENT '详情',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1无2团购3限时抢购）',
  `start_time` varchar(50) DEFAULT NULL COMMENT '开始时间',
  `end_time` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `group_member` int(11) DEFAULT NULL COMMENT '团购人数',
  `group_fail` int(11) DEFAULT NULL COMMENT '团购失败时间',
  `index` int(11) DEFAULT '-1' COMMENT '首页显示',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商城';

-- ----------------------------
-- Table structure for ims_xc_train_mark
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_mark`;
CREATE TABLE `ims_xc_train_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `pid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` datetime DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏';

-- ----------------------------
-- Table structure for ims_xc_train_moban_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_moban_user`;
CREATE TABLE `ims_xc_train_moban_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `nickname` varchar(500) DEFAULT NULL COMMENT '呢称',
  `status` int(11) DEFAULT '-1' COMMENT '-1未使用  1已使用',
  `createtime` int(11) DEFAULT NULL COMMENT '发布日期',
  `ident` varchar(50) DEFAULT NULL COMMENT '标识',
  `headimgurl` varchar(500) DEFAULT NULL COMMENT '头像',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='绑定模版消息用户';

-- ----------------------------
-- Table structure for ims_xc_train_nav
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_nav`;
CREATE TABLE `ims_xc_train_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `simg` varchar(255) DEFAULT NULL COMMENT '图片',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1链接2客服）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自定义导航';

-- ----------------------------
-- Table structure for ims_xc_train_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_news`;
CREATE TABLE `ims_xc_train_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `short_info` longtext COMMENT '简介',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `index` int(11) DEFAULT '-1' COMMENT '首页显示',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新闻';

-- ----------------------------
-- Table structure for ims_xc_train_online
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_online`;
CREATE TABLE `ims_xc_train_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `member` int(11) DEFAULT NULL COMMENT '未读条数',
  `type` int(11) DEFAULT NULL COMMENT '类型',
  `content` longtext COMMENT '内容',
  `updatetime` varchar(50) DEFAULT NULL COMMENT '更新时间',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`createtime`,`member`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客服';

-- ----------------------------
-- Table structure for ims_xc_train_online_log
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_online_log`;
CREATE TABLE `ims_xc_train_online_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '发送者用户id',
  `type` int(11) DEFAULT NULL COMMENT '类型1文本2图片',
  `content` longtext COMMENT '内容',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `duty` int(11) DEFAULT '1' COMMENT '身份1客户2客服',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`type`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客服记录';

-- ----------------------------
-- Table structure for ims_xc_train_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_order`;
CREATE TABLE `ims_xc_train_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `wx_out_trade_no` varchar(50) DEFAULT NULL COMMENT '微信订单号',
  `pid` int(11) DEFAULT NULL COMMENT '开课id',
  `order_type` int(11) DEFAULT NULL COMMENT '订单类型（1报名2预约）',
  `total` int(11) DEFAULT '0' COMMENT '数量',
  `amount` varchar(50) DEFAULT NULL COMMENT '金额',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '电话',
  `status` int(11) DEFAULT '-1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `form_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `mobile2` varchar(50) DEFAULT NULL COMMENT '备用电话',
  `o_amount` varchar(50) DEFAULT NULL COMMENT '实付金额',
  `coupon_id` int(11) DEFAULT NULL COMMENT '优惠券id',
  `coupon_price` varchar(50) DEFAULT NULL COMMENT '优惠金额',
  `use` int(11) DEFAULT '-1' COMMENT '使用状态',
  `content` longtext COMMENT '备注',
  `store` int(11) DEFAULT NULL COMMENT '校区',
  `can_use` int(11) DEFAULT '1' COMMENT '核销次数',
  `is_use` int(11) DEFAULT '0' COMMENT '已核销次数',
  `use_time` longtext COMMENT '核销时间',
  `cut_status` int(11) DEFAULT '-1' COMMENT '砍价',
  `userinfo` longtext COMMENT '用户信息',
  `format` varchar(255) DEFAULT NULL COMMENT '规格',
  `order_status` int(11) DEFAULT '-1' COMMENT '-1未发货1未收货2完成',
  `tui_status` int(11) DEFAULT '-1' COMMENT '退款状态（-1未退款1退款）',
  `tui_content` longtext COMMENT '退款原因',
  `mall_type` int(11) DEFAULT '1' COMMENT '商城订单类型（1无2团购3限时）',
  `group_id` int(11) DEFAULT NULL COMMENT '团购id',
  `group_status` int(11) DEFAULT '-1' COMMENT '团购状态（-1拼团中1成功2失败）',
  `tui` varchar(255) DEFAULT NULL COMMENT '推荐人',
  `share_one_openid` varchar(50) DEFAULT NULL COMMENT '一级分销用户',
  `share_one_fee` varchar(50) DEFAULT NULL COMMENT '一级分销佣金',
  `share_two_openid` varchar(50) DEFAULT NULL COMMENT '二级分销用户',
  `share_two_fee` varchar(50) DEFAULT NULL COMMENT '二级分销佣金',
  `share_three_openid` varchar(50) DEFAULT NULL COMMENT '三级分销用户',
  `share_three_fee` varchar(50) DEFAULT NULL COMMENT '三级分销佣金',
  `line_name` varchar(50) DEFAULT NULL COMMENT '礼包名称',
  `line_img` varchar(255) DEFAULT NULL COMMENT '礼包图片',
  `line_data` longtext COMMENT '礼包数据',
  `pei_type` int(11) DEFAULT '1' COMMENT '配送方式（1商家配送2自提）',
  `fee` varchar(50) DEFAULT NULL COMMENT '运费',
  `sign` longtext,
  `group_member` int(11) DEFAULT NULL COMMENT '团购人数',
  `group_price` varchar(50) DEFAULT NULL COMMENT '团购价格',
  `group_end` datetime DEFAULT NULL COMMENT '团购结束时间',
  `group_data` longtext COMMENT '团购数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单';

-- ----------------------------
-- Table structure for ims_xc_train_prize
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_prize`;
CREATE TABLE `ims_xc_train_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `cid` int(11) DEFAULT NULL COMMENT '活动id',
  `status` int(11) DEFAULT '-1' COMMENT '状态',
  `use` int(11) DEFAULT '-1' COMMENT '使用状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `opengid` longtext COMMENT '分享的群id',
  `usetime` varchar(50) DEFAULT NULL COMMENT '使用时间',
  `prizetime` varchar(50) DEFAULT NULL COMMENT '获奖时间',
  `prize` varchar(50) DEFAULT NULL COMMENT '奖品',
  `type` int(11) DEFAULT '1',
  `pid` int(11) DEFAULT NULL COMMENT '奖品id',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`use`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='奖品记录';

-- ----------------------------
-- Table structure for ims_xc_train_school
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_school`;
CREATE TABLE `ims_xc_train_school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `simg` varchar(255) DEFAULT NULL COMMENT '图标',
  `mobile` varchar(50) DEFAULT NULL COMMENT '电话',
  `address` longtext COMMENT '地址',
  `map` longtext COMMENT '定位',
  `teacher` longtext COMMENT '教师',
  `plan_date` varchar(50) DEFAULT NULL COMMENT '营业时间',
  `content` longtext COMMENT '详情',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `longitude` decimal(10,7) DEFAULT NULL COMMENT '经度',
  `latitude` decimal(10,7) DEFAULT NULL COMMENT '纬度',
  `sms` varchar(50) DEFAULT NULL COMMENT '接收短信',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分校';

-- ----------------------------
-- Table structure for ims_xc_train_service
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_service`;
CREATE TABLE `ims_xc_train_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `bimg` varchar(255) DEFAULT NULL COMMENT '封面',
  `xueqi` varchar(50) DEFAULT NULL COMMENT '学期',
  `keshi` varchar(50) DEFAULT NULL COMMENT '课时',
  `price` varchar(50) DEFAULT NULL COMMENT '学费',
  `content` longtext COMMENT '课程内容',
  `teacher` longtext COMMENT '任课教师',
  `discuss` int(11) DEFAULT '0' COMMENT '评论数',
  `zan` int(11) DEFAULT '0' COMMENT '点赞数',
  `click` int(11) DEFAULT '0' COMMENT '浏览量',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `index` int(11) DEFAULT '-1' COMMENT '首页显示',
  `tui` int(11) DEFAULT '-1' COMMENT '推荐',
  `can_use` int(11) DEFAULT '1' COMMENT '核销次数',
  `content2` longtext COMMENT '内容2',
  `content_type` int(11) DEFAULT '1' COMMENT '课程模式',
  `code` varchar(255) DEFAULT NULL COMMENT '二维码',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`,`index`,`tui`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='列表';

-- ----------------------------
-- Table structure for ims_xc_train_service_class
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_service_class`;
CREATE TABLE `ims_xc_train_service_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1课程2名师）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='分类';

-- ----------------------------
-- Table structure for ims_xc_train_service_group
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_service_group`;
CREATE TABLE `ims_xc_train_service_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL COMMENT '课程',
  `mark` varchar(50) DEFAULT NULL COMMENT '标识',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `bimg` longtext COMMENT '轮播图',
  `price` varchar(50) DEFAULT NULL COMMENT '原价',
  `format` longtext COMMENT '规格',
  `sold` int(11) DEFAULT '0' COMMENT '已团',
  `group_times` int(11) DEFAULT NULL COMMENT '团购时间',
  `member_on` int(11) DEFAULT '0' COMMENT '已有人数',
  `member` int(11) DEFAULT '0' COMMENT '人数',
  `end_time` datetime DEFAULT NULL COMMENT '截止时间',
  `click` int(11) DEFAULT '0' COMMENT '点击量',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `content` longtext COMMENT '详情',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购';

-- ----------------------------
-- Table structure for ims_xc_train_service_team
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_service_team`;
CREATE TABLE `ims_xc_train_service_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `mark` varchar(50) DEFAULT NULL COMMENT '标识',
  `start_time` varchar(50) DEFAULT NULL COMMENT '开课时间',
  `end_time` varchar(50) DEFAULT NULL COMMENT '截止时间',
  `least_member` int(11) DEFAULT NULL COMMENT '最少人数',
  `more_member` int(11) DEFAULT NULL COMMENT '最多人数',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `member` int(11) DEFAULT '0' COMMENT '已有人数',
  `type` int(11) DEFAULT '1' COMMENT '类型',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课程';

-- ----------------------------
-- Table structure for ims_xc_train_share_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_share_order`;
CREATE TABLE `ims_xc_train_share_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `type` int(11) DEFAULT NULL COMMENT '分销等级',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '佣金',
  `order_amount` decimal(10,2) DEFAULT NULL COMMENT '订单金额',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1待结算1已结算2失效）',
  `share` varchar(50) DEFAULT NULL COMMENT '分销用户id',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金订单';

-- ----------------------------
-- Table structure for ims_xc_train_share_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_share_withdraw`;
CREATE TABLE `ims_xc_train_share_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `type` int(11) DEFAULT NULL COMMENT '提现方式（1微信2支付宝）',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '提现金额',
  `username` varchar(50) DEFAULT NULL COMMENT '账号',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号',
  `code` varchar(255) DEFAULT NULL COMMENT '收款码',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1待处理1成功2失败）',
  `createtime` datetime DEFAULT NULL COMMENT '申请时间',
  `applytime` datetime DEFAULT NULL COMMENT '处理时间',
  `fee` decimal(10,2) DEFAULT '0.00' COMMENT '手续费',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`type`,`out_trade_no`,`status`,`createtime`,`applytime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销提现';

-- ----------------------------
-- Table structure for ims_xc_train_teacher
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_teacher`;
CREATE TABLE `ims_xc_train_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名字',
  `simg` varchar(255) DEFAULT NULL COMMENT '头像',
  `task` varchar(255) DEFAULT NULL COMMENT '职称',
  `short_info` longtext COMMENT '简介',
  `pclass` longtext COMMENT '负责课程',
  `students` int(11) DEFAULT '0' COMMENT '学员数',
  `zan` int(11) DEFAULT '0' COMMENT '点赞数',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `content_type` int(11) DEFAULT '1' COMMENT '课程模式',
  `content2` longtext COMMENT '内容2',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='名师';

-- ----------------------------
-- Table structure for ims_xc_train_teacher_log
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_teacher_log`;
CREATE TABLE `ims_xc_train_teacher_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `tid` int(11) DEFAULT NULL COMMENT '名师id',
  `status` int(11) DEFAULT NULL COMMENT '状态（1学员2点赞）',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='名师记录';

-- ----------------------------
-- Table structure for ims_xc_train_user_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_user_coupon`;
CREATE TABLE `ims_xc_train_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL COMMENT '优惠券id',
  `status` int(11) DEFAULT '-1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户优惠券';

-- ----------------------------
-- Table structure for ims_xc_train_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_userinfo`;
CREATE TABLE `ims_xc_train_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `nick` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `shop` int(11) DEFAULT '-1' COMMENT '管理中心绑定',
  `shop_id` int(11) DEFAULT NULL COMMENT '分校id',
  `share` varchar(50) DEFAULT NULL COMMENT '推荐人',
  `share_fee` decimal(10,2) DEFAULT '0.00' COMMENT '佣金',
  `share_code` varchar(255) DEFAULT NULL COMMENT '分销二维码',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='用户信息';

-- ----------------------------
-- Table structure for ims_xc_train_video
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_video`;
CREATE TABLE `ims_xc_train_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `video` varchar(255) DEFAULT NULL COMMENT '视频',
  `bimg` varchar(255) DEFAULT NULL COMMENT '封面',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `teacher_id` int(11) DEFAULT NULL COMMENT '主讲教师',
  `teacher_name` varchar(50) DEFAULT NULL COMMENT '教师姓名',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型',
  `vid` varchar(50) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `click` int(11) DEFAULT '0' COMMENT '人气',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='视频';

-- ----------------------------
-- Table structure for ims_xc_train_video_class
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_video_class`;
CREATE TABLE `ims_xc_train_video_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1视频2音频）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='视频分来';

-- ----------------------------
-- Table structure for ims_xc_train_zan
-- ----------------------------
DROP TABLE IF EXISTS `ims_xc_train_zan`;
CREATE TABLE `ims_xc_train_zan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL COMMENT '课程',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1课程2礼包）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`cid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='点赞记录';
