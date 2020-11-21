<?php
pdo_query("

CREATE TABLE IF NOT EXISTS `bg_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` longtext COMMENT '内容',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0为关闭，1为开启',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容表';

CREATE TABLE IF NOT EXISTS `bg_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '绑定的微信用户id，user表',
  `parent_id` int(11) DEFAULT NULL COMMENT '上级id（创造者id）',
  `role_id` int(11) DEFAULT NULL COMMENT '用户角色id',
  `name` varchar(30) DEFAULT NULL COMMENT '管理员名称',
  `real_name` varchar(65) DEFAULT NULL COMMENT '姓名',
  `password` char(32) DEFAULT NULL COMMENT '管理员密码',
  `phone` char(11) DEFAULT NULL COMMENT '手机号码',
  `email` varchar(60) DEFAULT NULL COMMENT '邮箱',
  `desc` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0为停用，1为启用，默认1',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bg_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL COMMENT '所属规格组id',
  `attr_name` varchar(255) DEFAULT NULL COMMENT '规格名称',
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否默认，0否（默认），1是',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是，默认0',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品规格属性表';

CREATE TABLE IF NOT EXISTS `bg_attr_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL COMMENT '规格组名称',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是，默认0',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品规格组表';

CREATE TABLE IF NOT EXISTS `bg_attr_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL COMMENT '商品id',
  `key` varchar(255) DEFAULT NULL COMMENT '规格键值(attr表id)',
  `image` longtext COMMENT '图片',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `setting` longtext COMMENT '规格下的多个会员价，会员折扣，会员等级，会员id（json）',
  `weight` float DEFAULT NULL COMMENT '重量',
  `no` varchar(255) DEFAULT NULL COMMENT '货号',
  `bar_code` varchar(255) DEFAULT NULL COMMENT '条形码',
  `qrcode` varchar(255) DEFAULT NULL COMMENT '二维码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bg_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `img_id` int(11) DEFAULT NULL COMMENT '图片id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型，1banner图，2导航diy图',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否启用，0否，1是',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0为否，1是',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='轮播图表';

CREATE TABLE IF NOT EXISTS `bg_bottom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `detail` longtext COMMENT '菜单详细',
  `status` tinyint(4) DEFAULT '1' COMMENT '是否开启，0为否，默认1是允许',
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='底部菜单';

CREATE TABLE IF NOT EXISTS `bg_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `product_id` int(11) DEFAULT NULL COMMENT '商品id',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '商品数量',
  `attr_id_list` longtext COMMENT '规格',
  `is_checked` tinyint(4) DEFAULT '0' COMMENT '是否选中，0否，1是',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `is_delete` (`is_delete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车';

CREATE TABLE IF NOT EXISTS `bg_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0' COMMENT '上级分类id，0为一级',
  `img_id` int(11) DEFAULT NULL COMMENT '图片id,关联image表',
  `name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `icon` longtext COMMENT '图标',
  `image` longtext COMMENT '分类大图',
  `link` longtext COMMENT '大图链接',
  `detail` longtext COMMENT '链接详情',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在热销榜单，0否，1是',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0为关闭，1为开启',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是，默认0',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品分类表';

CREATE TABLE IF NOT EXISTS `bg_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `product_id` int(11) DEFAULT NULL COMMENT '商品id',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏商品表';

CREATE TABLE IF NOT EXISTS `bg_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `product_id` int(11) DEFAULT NULL COMMENT '所评论的产品id',
  `attr_id_list` longtext COMMENT '规格',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `score` int(11) NOT NULL DEFAULT '5' COMMENT '评价分数，1到5',
  `avatar` longtext COMMENT '预设用户头像',
  `nickname` varchar(255) DEFAULT NULL COMMENT '预设用户名',
  `image` longtext COMMENT '多图片',
  `reply` longtext COMMENT '商家回复',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '显示，0为否，1为是',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表';

CREATE TABLE IF NOT EXISTS `bg_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `cate_id` int(11) DEFAULT NULL COMMENT '分类id',
  `content` longtext COMMENT '内容',
  `image` longtext COMMENT '图片（json）',
  `is_sift` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否精选，0否，1是',
  `likes` int(11) DEFAULT '0' COMMENT '点赞',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0为关闭，1为开启',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容表';

CREATE TABLE IF NOT EXISTS `bg_content_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT '父级id',
  `name` varchar(655) DEFAULT NULL COMMENT '名称',
  `style` tinyint(4) NOT NULL DEFAULT '1' COMMENT '样式，1左小图，2右小图，3下三图，4下二图，5下大图',
  `child_style` tinyint(4) NOT NULL DEFAULT '1' COMMENT '子分类样式，1普通模式，2侧栏模式',
  `display` longtext COMMENT '显示元素，1发布时间，2浏览量',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公告分类';

CREATE TABLE IF NOT EXISTS `bg_content_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `content_id` int(11) DEFAULT NULL COMMENT '文章id',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏文章表';

CREATE TABLE IF NOT EXISTS `bg_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '优惠券名字',
  `remark` longtext COMMENT '描述',
  `type` tinyint(4) DEFAULT NULL COMMENT '发放类型 1满减券，2折扣券， 3代金券 4新用户注册',
  `price` decimal(10,2) DEFAULT NULL COMMENT '优金券金额',
  `min_price` decimal(10,2) DEFAULT NULL COMMENT '最低消费金额',
  `sub_price` decimal(10,2) DEFAULT NULL COMMENT '优惠金额',
  `discount` decimal(3,1) DEFAULT NULL COMMENT '折扣率',
  `apply` tinyint(4) NOT NULL DEFAULT '0' COMMENT '适用类型，0为通用，1为指定分类，2为指定商品',
  `cate_id` longtext COMMENT 'apply为1时(指定分类下)',
  `product_id` longtext COMMENT 'apply为2时(指定商品)',
  `is_longtime` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是不长期有效，0为否，1为是，默认0',
  `is_join` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否加入领券中心，0否，1是',
  `receive_limit` int(11) DEFAULT '-1' COMMENT '每人领取数量，-1为不限制',
  `sum` int(11) NOT NULL DEFAULT '-1' COMMENT '可领取总数，-1为不限制',
  `send_num` int(11) DEFAULT '0' COMMENT '已领取数量',
  `use_num` int(11) DEFAULT '0' COMMENT '已使用数量',
  `expire_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '过期类型，1指定有效期，2领取后N天过期',
  `start_time` int(11) DEFAULT NULL COMMENT '有效期开始时间（is_longtime为0时）',
  `end_time` int(11) DEFAULT NULL COMMENT '有效期结束时间（is_longtime为0时）',
  `days` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '过期天数',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否有效，0为否，1为是，默认1',
  `create_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券表';

CREATE TABLE IF NOT EXISTS `bg_cube` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `images` longtext COMMENT 'json,图片src，跳转链接',
  `style` tinyint(4) NOT NULL DEFAULT '1' COMMENT '样式标识,默认1',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态，0为关闭，1为开启',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片魔方';

CREATE TABLE IF NOT EXISTS `bg_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `delivery_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '配送方式，1商家自配送',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `coordinates` longtext COMMENT '配送范围坐标（json）',
  `kind` tinyint(4) NOT NULL DEFAULT '1' COMMENT '配送区域设置，1不同距离不同配送费',
  `min_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低配送费',
  `first_km` float DEFAULT NULL COMMENT '首距离',
  `first_price` decimal(10,2) DEFAULT '0.00' COMMENT '首费用',
  `second_km` float DEFAULT NULL COMMENT '续距离',
  `second_price` decimal(10,2) DEFAULT '0.00' COMMENT '续费用',
  `is_timing` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启定时达，0为否，1为是',
  `time` longtext COMMENT '时间段',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '时段细分类型，1半小时，2小时，3上午下午晚上（12:00和18:00为分界点），4天',
  `advance` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否提前预约自提，0无需提前，1提前x天，2提前x小时，3提前x分钟',
  `advance_time` int(11) UNSIGNED DEFAULT NULL COMMENT '提前预约自提具体时间，与advance对应',
  `booking_time` int(11) DEFAULT '1' COMMENT '最长预约天数',
  `delivery_area` longtext COMMENT '配送范围',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否启用，0否，1是',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配送设置';

CREATE TABLE IF NOT EXISTS `bg_email_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `smtp` varchar(50) DEFAULT NULL COMMENT 'smtp',
  `port` int(11) DEFAULT NULL COMMENT '端口',
  `sender` varchar(255) DEFAULT NULL COMMENT '发件人邮箱',
  `code` varchar(255) DEFAULT NULL COMMENT '授权码',
  `name` varchar(255) DEFAULT NULL COMMENT '发件平台名称',
  `address` longtext COMMENT '收件人邮箱',
  `switch` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开关，0为关，1为开，默认0',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邮箱配置表';

CREATE TABLE IF NOT EXISTS `bg_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(255) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT '100',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '数据类型：kdniao=快递鸟',
  `is_delete` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='快递公司';

CREATE TABLE IF NOT EXISTS `bg_footprint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1是产品，2是文章',
  `product_id` int(11) DEFAULT NULL COMMENT '产品id，type为1时',
  `content_id` int(11) DEFAULT NULL COMMENT '文章id，type为2时',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是',
  `last_time` int(11) DEFAULT NULL COMMENT '最近一次浏览时间',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='足迹列表';

CREATE TABLE IF NOT EXISTS `bg_freight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `detail` longtext COMMENT '规则详细',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '计费方式，1计重，2计件',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0关闭，1开启',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '是否删除，0否，1是',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bg_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` longtext COMMENT '内容',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0为关闭，1为开启',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容表';

CREATE TABLE IF NOT EXISTS `bg_home` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `detail` longtext COMMENT 'diy详细内容json',
  `list` longtext COMMENT 'diy排序记录json',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否启用，0否，1是',
  `is_home` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为主页，0否，1是',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bg_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `uniacid` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL COMMENT '路径',
  `from` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0来自本地，1 来自公网 ',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片表';

CREATE TABLE IF NOT EXISTS `bg_integral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型，1购买商品',
  `money` decimal(10,2) NOT NULL DEFAULT '1.00' COMMENT '多少元获得多少积分',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '每1元获得的积分',
  `limit` tinyint(4) NOT NULL DEFAULT '1' COMMENT '上限，1无上限，',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分规则表';

CREATE TABLE IF NOT EXISTS `bg_integral_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `integral_id` int(11) DEFAULT NULL COMMENT '积分规则id',
  `admin_id` int(11) DEFAULT NULL COMMENT '管理员id',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '积分类型，1增加，2消耗',
  `kind` tinyint(4) NOT NULL DEFAULT '1' COMMENT '操作类型，1管理操作，2下单积分兑换时消耗或取消订单时积分返还操作，3购买商品',
  `integral` int(11) DEFAULT NULL COMMENT '积分',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分明细';

CREATE TABLE IF NOT EXISTS `bg_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型，1订单消息，2售后订单，3系统消息，4其他',
  `is_read` tinyint(4) DEFAULT '0' COMMENT '是否已读，0否，1是，默认0',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息列表';

CREATE TABLE IF NOT EXISTS `bg_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL COMMENT '父级节点id',
  `node_name` varchar(155) DEFAULT NULL COMMENT '节点名称',
  `control_name` varchar(155) DEFAULT NULL COMMENT '控制器名',
  `action_name` varchar(155) DEFAULT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否菜单显示 0不是1是',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '等级',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `bg_nodes` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT '父级节点id',
  `node_name` varchar(155) DEFAULT NULL COMMENT '节点名称',
  `control_name` varchar(155) DEFAULT NULL COMMENT '控制器名',
  `action_name` varchar(155) DEFAULT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否菜单显示 0不是1是',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '等级',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `bg_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL COMMENT '分类id',
  `title` varchar(655) DEFAULT NULL COMMENT '标题',
  `content` longtext COMMENT '内容',
  `link` longtext COMMENT '链接',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公告表';

CREATE TABLE IF NOT EXISTS `bg_notice_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT '父级id',
  `name` varchar(655) DEFAULT NULL COMMENT '名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公告分类';

CREATE TABLE IF NOT EXISTS `bg_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '1' COMMENT '门店id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `order_no` varchar(65) DEFAULT NULL COMMENT '订单号',
  `old_order_no` varchar(65) DEFAULT NULL COMMENT '最原始订单号',
  `is_union` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否是合并订单的子订单',
  `order_union_id` int(11) NOT NULL DEFAULT '0' COMMENT '合并订单的id',
  `total_count` int(11) DEFAULT NULL COMMENT '总数量',
  `userinfo` longtext COMMENT '用户信息',
  `city` varchar(65) DEFAULT NULL COMMENT '下单地址所在市',
  `snap_name` varchar(255) DEFAULT NULL COMMENT '订单快照名称',
  `products` longtext COMMENT '所有商品id（json）',
  `snap_img` varchar(655) DEFAULT NULL COMMENT '订单快照图片',
  `snap_info` longtext COMMENT '订单快照信息',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总额',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付款（不含运费）',
  `o_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付款（含运费、配送费）',
  `is_change` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否改价，0否，1是',
  `change_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '涨减价（负为减）',
  `before_change` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '改价前的价格',
  `express_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `express` varchar(255) DEFAULT NULL COMMENT '物流公司',
  `express_no` varchar(255) DEFAULT NULL COMMENT '物流单号',
  `order_type` tinyint(4) DEFAULT NULL COMMENT '订单类型，1快递，2同城配送，3自提',
  `pick_time` varchar(255) DEFAULT NULL COMMENT '提货时间',
  `pick_info` longtext COMMENT '提货信息（json）',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `delivery_time` varchar(255) DEFAULT NULL COMMENT '送达时间',
  `delivery_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费',
  `is_send` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已发货，0否，1是',
  `send_type` tinyint(4) DEFAULT NULL COMMENT '发货方式，1快递，2无需物流,3商家配送',
  `send_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `is_confirm` smallint(1) NOT NULL DEFAULT '0' COMMENT '确认收货状态：0=未确认，1=已确认收货',
  `confirm_time` int(11) DEFAULT NULL COMMENT '确认收货时间',
  `is_comment` smallint(1) NOT NULL DEFAULT '0' COMMENT '是否已评价：0=未评价，1=已评价',
  `content` longtext,
  `coupon_id` int(11) DEFAULT NULL COMMENT '优惠券id',
  `coupon_price` decimal(10,2) DEFAULT '0.00' COMMENT '优惠价格',
  `coupon_discount` float DEFAULT NULL,
  `refund_content` longtext COMMENT '退款理由',
  `is_refund` tinyint(4) DEFAULT '0' COMMENT '是否申请退款，0否，1是',
  `is_integral` tinyint(4) DEFAULT '0' COMMENT '是否使用积分：0为否，1为是',
  `integral` longtext COMMENT '积分使用',
  `discount` decimal(11,2) DEFAULT NULL COMMENT '积分抵扣金额',
  `words` longtext COMMENT '商家留言',
  `seller_comments` text COMMENT '商家备注',
  `pay_type` tinyint(4) DEFAULT '1' COMMENT '支付方式（1微信支付2余额支付，3支付宝，4银行卡，5其他）',
  `source` tinyint(4) NOT NULL DEFAULT '1' COMMENT '来源，1微信，2百度，3支付宝，4其他',
  `is_price` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已结算佣金，0否，1是',
  `parent_id` int(11) DEFAULT NULL COMMENT '上级id',
  `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '上级佣金',
  `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '上上级佣金',
  `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '上上上级佣金',
  `remark` varchar(655) DEFAULT NULL COMMENT '备注',
  `clerk_id` int(11) DEFAULT NULL COMMENT '核销员id',
  `clerk_time` int(11) DEFAULT NULL COMMENT '核销时间',
  `clerk_code` longtext COMMENT '核销码',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  `message` varchar(655) DEFAULT NULL COMMENT '买家留言',
  `status` tinyint(4) DEFAULT '0' COMMENT '支付状态，0待支付，1已支付，2待收货，3已完成，4退款，5退货退款',
  `is_cancel` smallint(1) NOT NULL DEFAULT '0' COMMENT '是否取消',
  `cancel_time` int(11) DEFAULT NULL COMMENT '取消时间',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1为已删除，0为否',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

CREATE TABLE IF NOT EXISTS `bg_order_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL COMMENT '退货 换货地址id',
  `product_id` int(11) DEFAULT NULL COMMENT '商品id',
  `attr_id_list` varchar(255) DEFAULT NULL COMMENT '多规格',
  `order_no` varchar(255) DEFAULT NULL COMMENT '原订单单号',
  `refund_order_no` varchar(255) DEFAULT NULL COMMENT '售后订单号',
  `type` smallint(6) NOT NULL DEFAULT '1' COMMENT '售后类型：1=退货退款，2=换货',
  `refund_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `refund_address` varchar(655) DEFAULT NULL COMMENT '退货地址',
  `userinfo` longtext COMMENT '用户信息',
  `city` varchar(50) DEFAULT NULL COMMENT '用户下单城市',
  `snap_info` longtext COMMENT '订单商品快照信息',
  `confirm_time` int(11) DEFAULT NULL COMMENT '原订单确认收货时间',
  `remark` varchar(500) DEFAULT NULL COMMENT '退款说明',
  `image` longtext COMMENT '凭证图片列表：json格式',
  `refuse_remark` varchar(500) DEFAULT NULL COMMENT '拒绝退换货原因',
  `refuse_time` int(11) DEFAULT NULL COMMENT '拒绝时间',
  `is_user_send` smallint(1) NOT NULL DEFAULT '0' COMMENT '用户已发货：0=未发货，1=已发货',
  `user_send_time` int(11) DEFAULT NULL COMMENT '用户发货时间',
  `user_send_express` varchar(32) DEFAULT NULL COMMENT '用户发货快递公司',
  `user_send_express_no` varchar(32) DEFAULT NULL COMMENT '用户发货快递单号',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  `agree_time` int(11) DEFAULT NULL COMMENT '同意申请时间',
  `agree_refund_time` int(11) DEFAULT NULL COMMENT '同意退款时间',
  `status` smallint(1) NOT NULL DEFAULT '0' COMMENT '状态：0=待商家处理，1=同意申请，2=已同意退货退款且已退款，3=已拒绝退货退款',
  `is_delete` smallint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `is_delete` (`is_delete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='售后订单';

CREATE TABLE IF NOT EXISTS `bg_order_union` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `snap_name` varchar(255) DEFAULT NULL COMMENT '订单快照名称',
  `o_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付总金额',
  `order_id_list` longtext COMMENT '子订单id列表',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态（0待支付（默认）1已支付',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是，默认0',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='多商家下的合并订单';

CREATE TABLE IF NOT EXISTS `bg_pick_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(65) DEFAULT NULL COMMENT '城市名',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自提点所属城市';

CREATE TABLE IF NOT EXISTS `bg_pick_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `is_dayoff` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否休息，0否，1是',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `tel` varchar(55) DEFAULT NULL COMMENT '电话',
  `city_id` int(11) DEFAULT NULL COMMENT '所属自提城市',
  `city` varchar(65) DEFAULT NULL COMMENT '城市',
  `address` longtext COMMENT '地址',
  `business_time` longtext COMMENT '营业时间（json）',
  `is_pick` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否需要买家选择自提时间，0否，1是',
  `pick_time` longtext COMMENT '自提时间段和日期（json）',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '时段细分类型，1半小时，2小时，3上午下午晚上（12:00和18:00为分界点），4天',
  `advance` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否提前预约自提，0无需提前，1提前x天，2提前x小时，3提前x分钟',
  `advance_time` int(11) UNSIGNED DEFAULT NULL COMMENT '提前预约自提具体时间，与advance对应',
  `booking_time` int(11) UNSIGNED DEFAULT '1' COMMENT '最长预约天数',
  `image` longtext COMMENT '图片',
  `remark` longtext COMMENT '备注',
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否默认，0否，1是',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，1开启，0关闭',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自提点列表';

CREATE TABLE IF NOT EXISTS `bg_platform_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '小程序名称',
  `logo` longtext COMMENT 'logo',
  `tel` varchar(50) DEFAULT NULL COMMENT '电话',
  `phone` varchar(50) DEFAULT NULL COMMENT '负责人手机号',
  `confirm_time` int(11) UNSIGNED DEFAULT '0' COMMENT '自动确认收货时间',
  `after_time` int(11) UNSIGNED DEFAULT '0' COMMENT '售后期，天数',
  `order_time` int(11) UNSIGNED DEFAULT '0' COMMENT '未支付订单过期时间（分钟）',
  `deduction` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '多少积分抵扣1元',
  `cate_type` tinyint(4) DEFAULT '4' COMMENT '分类样式',
  `is_token` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否强制授权，0否，1是',
  `is_pick` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启上门自提，0否，1是',
  `is_delivery` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启商家同城配送，0否，1是',
  `is_express` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否开启快递发货，0否，1是',
  `is_promise` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启服务承诺，0否，1是',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `summary` longtext COMMENT '描述',
  `vip_image` longtext COMMENT '会员背景图片',
  `vip_remark` longtext COMMENT '会员权益',
  `appid` varchar(255) DEFAULT NULL COMMENT '小程序appid',
  `app_secret` varchar(255) DEFAULT NULL COMMENT '小程序密钥',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '商户号id',
  `mch_key` varchar(255) DEFAULT NULL COMMENT '商户号密钥',
  `cert_pem` longtext COMMENT '微信支付证书cert',
  `key_pem` longtext COMMENT '微信支付证书key',
  `kdniao_mch_id` varchar(255) DEFAULT NULL COMMENT '快递鸟商户id',
  `kdniao_app_key` varchar(255) DEFAULT NULL COMMENT '快递鸟appkey',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='平台微信配置表';

CREATE TABLE IF NOT EXISTS `bg_poster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `image` longtext COMMENT '图片',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `type` varchar(255) NOT NULL DEFAULT '0' COMMENT '类型，1.自定义入口（首页），2.预约（首页），3.立即抢购（首页），4.优惠先抢（首页），5.自定义入口（个人中心页）',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0为关闭，1为开启',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='海报表';

CREATE TABLE IF NOT EXISTS `bg_printer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `type` varchar(255) DEFAULT NULL COMMENT '类型',
  `setting` longtext COMMENT '设置',
  `apply` tinyint(4) DEFAULT '1' COMMENT '打印类型，1全部商品，2指定分类',
  `cate_id` longtext COMMENT '指定分类时的分类id',
  `way` longtext COMMENT '订单打印方式',
  `width` tinyint(4) NOT NULL DEFAULT '1' COMMENT '纸宽，1，58mm',
  `page` tinyint(4) NOT NULL DEFAULT '1' COMMENT '打印页数',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='打印机列表';

CREATE TABLE IF NOT EXISTS `bg_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL COMMENT '分类id',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商品类型，1普通商品，2打赏商品',
  `name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '售价',
  `o_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价(只作展示)',
  `vip_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员价',
  `thumb` longtext COMMENT '缩略图',
  `image` longtext COMMENT '多图片',
  `summary` longtext COMMENT '描述',
  `content` longtext COMMENT '详情',
  `spec` longtext COMMENT '规格参数',
  `after` longtext COMMENT '包装售后',
  `promise` longtext COMMENT '服务承诺',
  `video_type` tinyint(4) DEFAULT '1' COMMENT '视频选择方式，0选择本地，1粘贴地址',
  `video_url` longtext COMMENT '视频链接',
  `video_id` int(11) DEFAULT NULL COMMENT '视频id',
  `unit` varchar(255) DEFAULT NULL COMMENT '单位',
  `is_attr` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否使用规格，0为否，1为是，默认0',
  `setting` longtext COMMENT '不使用多规格，多个会员价，会员折扣，会员等级，会员id（json）',
  `weight_group` tinyint(4) NOT NULL DEFAULT '0' COMMENT '物流重量方式，0所有规格统一，1分别设置',
  `weight_num` float DEFAULT NULL COMMENT '统一重量的数值',
  `weight` float DEFAULT NULL COMMENT '单规格的重量',
  `no` varchar(255) DEFAULT NULL COMMENT '货号',
  `bar_code` varchar(255) DEFAULT NULL COMMENT '条形码',
  `tag` longtext COMMENT '标签json',
  `send_type` varchar(50) DEFAULT NULL COMMENT '发货方式，1快递、同城配送、自提，2同城配送，3自提 (json)',
  `service` longtext COMMENT '商品服务选项',
  `full_cut` longtext COMMENT '满减',
  `is_integral` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否积分抵扣，0否，1是',
  `integral` longtext COMMENT '积分设置',
  `is_limit` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否限制用户购买数量，0否，1是',
  `limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '限制数量',
  `quick_buy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否加入快速购买：0否，1是，默认0',
  `hot_cakes` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否加入热销：0否，1是，默认0',
  `member_discount` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否参与会员折扣，0不参与，1参与，默认1',
  `rebate` decimal(10,2) DEFAULT NULL COMMENT '自购返利',
  `stock` int(11) UNSIGNED DEFAULT NULL COMMENT '库存量',
  `total_stock` int(11) NOT NULL DEFAULT '0' COMMENT '总的库存',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `sales` int(11) DEFAULT '0' COMMENT '虚拟购买量',
  `is_unify` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否统一运费，0否，1是',
  `unify_express` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '统一运费',
  `freight_id` int(11) DEFAULT NULL COMMENT '运费模板id',
  `is_today` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否今日上新，0否，1是',
  `is_recommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为你推荐，0否，1是',
  `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否会员精选，0为否，1是',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0为下架，1为上架，默认1',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是，默认0',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表';

CREATE TABLE IF NOT EXISTS `bg_promise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `icon` longtext COMMENT '图标',
  `content` longtext COMMENT '内容',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：0为停用，1为启用，默认1',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='服务承诺';

CREATE TABLE IF NOT EXISTS `bg_public_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '小程序名称',
  `logo` longtext COMMENT 'logo',
  `tel` varchar(50) DEFAULT NULL COMMENT '电话',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `summary` longtext COMMENT '描述',
  `appid` varchar(255) DEFAULT NULL COMMENT '公众号appid',
  `app_secret` varchar(255) DEFAULT NULL COMMENT '公众号密钥',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '商户号id',
  `mch_key` varchar(255) DEFAULT NULL COMMENT '商户号密钥',
  `cert_pem` longtext COMMENT '微信支付证书cert',
  `key_pem` longtext COMMENT '微信支付证书key',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信公众号配置表';

CREATE TABLE IF NOT EXISTS `bg_public_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `tpl_id` varchar(255) DEFAULT NULL COMMENT '模板编号',
  `tpl` longtext COMMENT '模板id',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公众号模板消息配置';

CREATE TABLE IF NOT EXISTS `bg_public_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户微信openid',
  `nickname` varchar(255) DEFAULT NULL COMMENT '微信名称',
  `avatar` longtext COMMENT '头像',
  `update_time` int(11) DEFAULT NULL COMMENT '最近授权时间',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公众号用户表';

CREATE TABLE IF NOT EXISTS `bg_refund_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` longtext,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0为关闭，1为开启',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退货地址';

CREATE TABLE IF NOT EXISTS `bg_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `role_name` varchar(155) DEFAULT NULL COMMENT '角色名称',
  `rule` longtext COMMENT '权限节点',
  `remark` varchar(655) DEFAULT NULL COMMENT '描述',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限角色表';

CREATE TABLE IF NOT EXISTS `bg_salesman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `level` tinyint(4) DEFAULT '3' COMMENT '现在的用户等级',
  `old_level` tinyint(4) DEFAULT NULL COMMENT '原来的用户等级（当前用户不是业务员时的等级）',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='业务员表';

CREATE TABLE IF NOT EXISTS `bg_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '申请人用户id',
  `parent_id` int(11) DEFAULT NULL COMMENT '上级id',
  `name` varchar(65) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(55) DEFAULT NULL COMMENT '手机号码',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '审核状态，0审核中，1审核通过，2审核不通过，3已取消分销商资格',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销申请表';

CREATE TABLE IF NOT EXISTS `bg_share_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '分销商名称',
  `switch` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开关，0为关，1为开，默认0',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分销层级，1级，2级，3级',
  `withdraw_type` longtext COMMENT '提现方式(json)，1微信，2支付，3银行卡，4余额支付',
  `min_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度',
  `day_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限',
  `rate` float NOT NULL DEFAULT '0' COMMENT '费率',
  `image` longtext COMMENT '背景图片/推广海报图',
  `poster` longtext COMMENT '分销海报设置详情',
  `scale_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分销佣金类型，1固定金额，2百分比',
  `first_scale` float DEFAULT NULL COMMENT '一级分销商比例',
  `second_scale` float DEFAULT NULL COMMENT '二级分销商比例',
  `third_scale` float DEFAULT NULL COMMENT '三级分销商佣比例',
  `subordinate_condition` tinyint(4) NOT NULL DEFAULT '1' COMMENT '成为下线条件,1首次点击分享链接，2首次下单，3首次付款',
  `distributor_condition` tinyint(4) DEFAULT '1' COMMENT '成为分销商条件，1申请即通过，2申请需审核，3消费次数，4消费金额',
  `condition` float NOT NULL DEFAULT '0' COMMENT '消费次数或消费金额',
  `is_self` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分销商内购，0否，1是',
  `notice` longtext COMMENT '用户须知',
  `agree` longtext COMMENT '申请协议',
  `apply_image` longtext COMMENT '申请页面背景图',
  `check_image` longtext COMMENT '待审核页面背景图',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销设置表';

CREATE TABLE IF NOT EXISTS `bg_sms_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `key_id` varchar(255) DEFAULT NULL COMMENT '阿里云AccessKeyId ',
  `key_secret` varchar(255) DEFAULT NULL COMMENT '阿里云AccessKeySecret',
  `tpl_sign` varchar(255) DEFAULT NULL COMMENT '模板签名',
  `tpl_name` varchar(255) DEFAULT NULL COMMENT '模板名称',
  `tpl_code` varchar(255) DEFAULT NULL COMMENT '模板ID',
  `tpl_var` varchar(255) DEFAULT NULL COMMENT '模板变量',
  `refund_tpl_name` varchar(255) DEFAULT NULL COMMENT '订单退款模板名称',
  `refund_tpl_id` varchar(255) DEFAULT NULL COMMENT '订单退款模板ID',
  `number` longtext COMMENT '接收短信手机号',
  `switch` tinyint(4) DEFAULT '0' COMMENT '开关，0为关，1为开，默认0',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信配置表';

CREATE TABLE IF NOT EXISTS `bg_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL COMMENT '轮播图id，对应banner表',
  `type_id` int(11) DEFAULT NULL COMMENT '类型id，对应类型表',
  `img_id` int(11) DEFAULT NULL COMMENT '图片id,关联image表',
  `name` varchar(65) NOT NULL COMMENT '名称',
  `boss` varchar(50) DEFAULT NULL COMMENT '负责人',
  `total_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总的余额',
  `can_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现余额',
  `have_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现金额',
  `area` varchar(255) NOT NULL COMMENT '所属区域',
  `support` longtext COMMENT '商家支持(设置)',
  `note` varchar(255) NOT NULL COMMENT '备注',
  `logo` longtext COMMENT 'logo',
  `license` longtext COMMENT '营业执照',
  `tel` varchar(255) NOT NULL COMMENT '电话',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `detail` varchar(655) DEFAULT NULL COMMENT '详细地址',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `time` varchar(255) DEFAULT NULL COMMENT '营业时间',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '洗剪吹价格',
  `notice` longtext COMMENT '公告',
  `invite_code` varchar(255) DEFAULT NULL COMMENT '邀请码',
  `pay_qrcode` varchar(255) NOT NULL COMMENT '店铺小程序二维码',
  `app_qrcode` varchar(255) NOT NULL COMMENT '店铺小程序收款二维码',
  `nav` varchar(255) NOT NULL COMMENT '导航信息（json）',
  `footer_nav` varchar(255) NOT NULL COMMENT '底部导航图标',
  `img_cube` varchar(255) NOT NULL COMMENT '图片魔方',
  `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否会员卡，0否，1是',
  `is_pay` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否余额支付,0为否，1为是，默认0',
  `is_integral` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否积分,0为否，1为是，默认0',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0为关闭，1为审核中，2审核通过，3审核失败',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否默认，0否，1是（默认）',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店表';

CREATE TABLE IF NOT EXISTS `bg_store_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL COMMENT 'store对应id',
  `banner_id` int(11) DEFAULT NULL COMMENT 'store对应的banner id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bg_store_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` longtext,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='店铺评价表';

CREATE TABLE IF NOT EXISTS `bg_store_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id，关联user表',
  `store_id` int(11) DEFAULT NULL COMMENT '所属门店id',
  `time` longtext COMMENT '时间json,（开始时间start_time，结束时间end_time，到店预约人数arrive，上门预约人数visit，提前预约时间forward，状态status）',
  `week` varchar(50) DEFAULT NULL COMMENT '星期',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0为关闭，1为开启',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店可预约时间表';

CREATE TABLE IF NOT EXISTS `bg_store_type` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(65) DEFAULT NULL COMMENT '名称',
  `other` varchar(255) DEFAULT NULL COMMENT '其他',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店类型表';

CREATE TABLE IF NOT EXISTS `bg_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL COMMENT '角色id',
  `store_id` int(11) NOT NULL DEFAULT '1' COMMENT '门店id',
  `openid` varchar(50) DEFAULT NULL COMMENT '用户微信标识',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `official_id` int(11) DEFAULT NULL COMMENT '公众号用户id',
  `name` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `nickname` varchar(255) DEFAULT NULL COMMENT '微信名称',
  `avatar` longtext COMMENT '头像',
  `sex` varchar(10) DEFAULT NULL COMMENT '性别',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号',
  `qr_code` longtext COMMENT '推广海报',
  `weixin` varchar(255) DEFAULT NULL COMMENT '微信号',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分,1元 = 1积分',
  `birthday` varchar(255) DEFAULT NULL COMMENT '生日',
  `vip_id` int(11) DEFAULT NULL COMMENT '会员卡id',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '等级，对应会员表中的level',
  `total_money` decimal(10,2) DEFAULT '0.00' COMMENT '累计消费',
  `total_share_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总的佣金',
  `share_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现佣金',
  `is_distributor` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否分销商 0不是， 1是， 2申请中',
  `distributor_time` int(11) DEFAULT NULL COMMENT '成为分销商时间',
  `bind_time` int(11) DEFAULT NULL COMMENT '绑定上级时间',
  `parent_user_id` int(11) DEFAULT NULL COMMENT '即将成为父级的id',
  `is_clerk` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否核销员，0否，1是',
  `clerk_time` int(11) DEFAULT NULL COMMENT '加入核销时间',
  `clerk_remark` varchar(655) DEFAULT NULL COMMENT '核销员备注',
  `is_mobile` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为手机管理员，0否，1是',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是',
  `access_time` int(11) DEFAULT NULL COMMENT '最近一次访问时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

CREATE TABLE IF NOT EXISTS `bg_user_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '1' COMMENT '门店id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `create_time` int(11) DEFAULT NULL COMMENT '访问时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户每天首次访问';

CREATE TABLE IF NOT EXISTS `bg_user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(50) DEFAULT NULL COMMENT '联系方式',
  `content` varchar(655) DEFAULT NULL COMMENT '内容',
  `province` varchar(50) DEFAULT NULL COMMENT '省',
  `city` varchar(50) DEFAULT NULL COMMENT '市',
  `country` varchar(50) DEFAULT NULL COMMENT '区',
  `detail` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `is_default` tinyint(4) DEFAULT '0' COMMENT '是否为默认地址0为否，1为是',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1为已删除，0为否',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bg_user_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `store_id` int(11) DEFAULT NULL COMMENT '店铺id',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `update_time` int(11) DEFAULT NULL COMMENT '最近一次充值时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户余额';

CREATE TABLE IF NOT EXISTS `bg_user_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` smallint(1) NOT NULL DEFAULT '0' COMMENT '支付方式 0--微信支付  1--支付宝  2--银行卡  3--余额',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `order_no` varchar(255) DEFAULT NULL COMMENT '订单号',
  `pay_time` int(11) DEFAULT NULL COMMENT '付款时间',
  `mobile` varchar(255) DEFAULT NULL COMMENT '支付宝账号',
  `name` varchar(255) DEFAULT NULL COMMENT '支付宝姓名',
  `bank_name` varchar(30) DEFAULT NULL COMMENT '开户行名称',
  `pay_type` int(11) DEFAULT '0' COMMENT '打款方式 0--之前未统计的 1--微信自动打款 2--手动打款',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '申请状态 0--申请中 1--确认申请 2--已打款 3--驳回  5--余额通过',
  `is_delete` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL COMMENT '提交时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现订单表';

CREATE TABLE IF NOT EXISTS `bg_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `coupon_id` int(11) DEFAULT NULL COMMENT '优惠券id',
  `receive_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '领取类型 0平台发放, 1自动发放, 2领券中心领取',
  `coupon_auto_send_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否自动发关，0为否，1为是，默认0',
  `start_time` int(11) DEFAULT NULL COMMENT '有效期开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '有效期结束时间',
  `is_use` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否使用，0为否，1为是，默认0',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否有效，1为是，0为否，默认1',
  `create_time` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户优惠券表';

CREATE TABLE IF NOT EXISTS `bg_user_money_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计消费',
  `integral` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '获得积分数',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户已过售后期订单获得积分，累计消费金额明细';

CREATE TABLE IF NOT EXISTS `bg_user_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户员工id',
  `service_id` int(11) DEFAULT NULL COMMENT '可服务项目id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='员工和服务关联表';

CREATE TABLE IF NOT EXISTS `bg_user_share_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `user_id` int(11) DEFAULT NULL COMMENT '下单用户ID',
  `parent_id` int(11) DEFAULT NULL COMMENT '上级id，获得佣金用户id',
  `source` int(11) DEFAULT '1' COMMENT '佣金来源 1,一级分销 2,二级分销 3,三级分销',
  `money` decimal(10,2) DEFAULT NULL COMMENT '金额',
  `is_settle` tinyint(4) DEFAULT '0' COMMENT '是否已结算到用户的可提现佣金，0否，1是',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '是否删除，0否，1是',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户佣金明细表';

CREATE TABLE IF NOT EXISTS `bg_user_vip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `vip_id` int(11) DEFAULT NULL COMMENT '对应会员卡id',
  `start_time` int(11) DEFAULT NULL COMMENT '生效时间',
  `end_time` int(11) DEFAULT NULL COMMENT '失效时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '是否有效，0为否，1为是，默认0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `bg_user_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `title` varchar(65) DEFAULT NULL COMMENT '标题',
  `content` longtext COMMENT '内容',
  `image` longtext COMMENT '多图片',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户作品表';

CREATE TABLE IF NOT EXISTS `bg_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `thumb` longtext COMMENT '封面图',
  `url` varchar(255) DEFAULT NULL COMMENT '路径',
  `size` float DEFAULT NULL COMMENT '大小',
  `from` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0来自本地，1 来自公网 ',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片表';

CREATE TABLE IF NOT EXISTS `bg_vip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '名称',
  `level` tinyint(4) DEFAULT NULL COMMENT '数字越大等级越高，会员满足条件等级从低到高自动升级',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '升级条件，累计完成订单金额满多少元',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `discount` float NOT NULL DEFAULT '1' COMMENT '享受折扣（请输入0.1~1之间的数字）',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型，1背景色，2背景图',
  `image` longtext CHARACTER SET utf8 COMMENT '背景图片',
  `color` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '背景色',
  `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0关闭，1开启',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='会员卡表';

CREATE TABLE IF NOT EXISTS `bg_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `account` varchar(50) DEFAULT NULL COMMENT '提现人账号',
  `bank` varchar(65) DEFAULT NULL COMMENT '开户行',
  `name` varchar(50) DEFAULT NULL COMMENT '提现人姓名',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '申请金额',
  `rate` float DEFAULT NULL COMMENT '费率',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '到账金额',
  `withdraw_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现种类，1微信，2支付宝,3银行卡，4余额支付',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态，0待打款，1已打款，2拒绝',
  `pay_time` int(11) DEFAULT NULL COMMENT '付款时间',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现列表';

CREATE TABLE IF NOT EXISTS `bg_wx_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `tpl_id` varchar(55) DEFAULT NULL COMMENT 'ID',
  `tpl` longtext COMMENT '模板id',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信模板消息id';
  
 ");