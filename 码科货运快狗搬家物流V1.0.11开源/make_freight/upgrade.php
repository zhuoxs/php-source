<?php 
pdo_query("CREATE TABLE IF NOT EXISTS `ims_freight_about` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`company` varchar(20) NOT NULL   COMMENT '公司名称',
`img_url` varchar(255) NOT NULL   COMMENT '图片',
`versions` varchar(20) NOT NULL   COMMENT '版本号',
`phone` char(11) NOT NULL   COMMENT '联系电话',
`work_time` varchar(30) NOT NULL   COMMENT '工作时间',
`email` varchar(20) NOT NULL   COMMENT '邮箱',
`wechat` varchar(50) NOT NULL   COMMENT '微信公众号',
`uniacid` int(11) NOT NULL,
`update_time` int(11) NOT NULL   COMMENT '更新时间',
`create_time` int(11) NOT NULL   COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_admin` (
`id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID',
`username` varchar(20) NOT NULL   COMMENT '用户名',
`nickname` varchar(50) NOT NULL   COMMENT '昵称',
`password` varchar(32) NOT NULL   COMMENT '密码',
`salt` varchar(30) NOT NULL   COMMENT '密码盐',
`avatar` varchar(100) NOT NULL   COMMENT '头像',
`email` varchar(100) NOT NULL   COMMENT '电子邮箱',
`loginfailure` tinyint(1) NOT NULL   COMMENT '失败次数',
`logintime` int(10)    COMMENT '登录时间',
`uniacid` int(10)    COMMENT 'uniacid',
`createtime` int(10)    COMMENT '创建时间',
`updatetime` int(10)    COMMENT '更新时间',
`token` varchar(59) NOT NULL   COMMENT 'Session标识',
`status` varchar(30) NOT NULL DEFAULT NULL DEFAULT 'normal'  COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_admin_log` (
`id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID',
`admin_id` int(10) NOT NULL   COMMENT '管理员ID',
`username` varchar(30) NOT NULL   COMMENT '管理员名字',
`url` varchar(1500) NOT NULL   COMMENT '操作页面',
`title` varchar(100) NOT NULL   COMMENT '日志标题',
`content` text() NOT NULL   COMMENT '内容',
`ip` varchar(50) NOT NULL   COMMENT 'IP',
`useragent` varchar(255) NOT NULL   COMMENT 'User-Agent',
`createtime` int(10)    COMMENT '操作时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_amount_detail` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`driver_id` int(11) NOT NULL,
`amount` decimal(10,2) NOT NULL   COMMENT '金额',
`type` tinyint(1) NOT NULL   COMMENT '1=加，2=减',
`title` varchar(20) NOT NULL   COMMENT '标题',
`create_time` int(11) NOT NULL   COMMENT '添加时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_attachment` (
`id` int(20) NOT NULL  AUTO_INCREMENT COMMENT 'ID',
`admin_id` int(10) NOT NULL   COMMENT '管理员ID',
`user_id` int(10) NOT NULL   COMMENT '会员ID',
`url` varchar(255) NOT NULL   COMMENT '物理路径',
`imagewidth` varchar(30) NOT NULL   COMMENT '宽度',
`imageheight` varchar(30) NOT NULL   COMMENT '高度',
`imagetype` varchar(30) NOT NULL   COMMENT '图片类型',
`imageframes` int(10) NOT NULL   COMMENT '图片帧数',
`filesize` int(10) NOT NULL   COMMENT '文件大小',
`mimetype` varchar(100) NOT NULL   COMMENT 'mime类型',
`extparam` varchar(255) NOT NULL   COMMENT '透传数据',
`createtime` int(10)    COMMENT '创建日期',
`updatetime` int(10)    COMMENT '更新时间',
`uploadtime` int(10)    COMMENT '上传时间',
`storage` varchar(100) NOT NULL DEFAULT NULL DEFAULT 'local'  COMMENT '存储位置',
`sha1` varchar(40) NOT NULL   COMMENT '文件 sha1编码',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_auth_group` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`pid` int(10) NOT NULL   COMMENT '父组别',
`name` varchar(100) NOT NULL   COMMENT '组名',
`rules` text() NOT NULL   COMMENT '规则ID',
`createtime` int(10)    COMMENT '创建时间',
`updatetime` int(10)    COMMENT '更新时间',
`status` varchar(30) NOT NULL   COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_auth_group_access` (
`uid` int(10) NOT NULL   COMMENT '会员ID',
`group_id` int(10) NOT NULL   COMMENT '级别ID',
PRIMARY KEY (``)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_auth_rule` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`type` enum('menu','file') NOT NULL DEFAULT NULL DEFAULT 'file'  COMMENT 'menu为菜单,file为权限节点',
`pid` int(10) NOT NULL   COMMENT '父ID',
`name` varchar(100) NOT NULL   COMMENT '规则名称',
`title` varchar(50) NOT NULL   COMMENT '规则名称',
`icon` varchar(50) NOT NULL   COMMENT '图标',
`condition` varchar(255) NOT NULL   COMMENT '条件',
`remark` varchar(255) NOT NULL   COMMENT '备注',
`ismenu` tinyint(1) NOT NULL   COMMENT '是否为菜单',
`createtime` int(10)    COMMENT '创建时间',
`updatetime` int(10)    COMMENT '更新时间',
`weigh` int(10) NOT NULL   COMMENT '权重',
`status` varchar(30) NOT NULL   COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_banner` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`url` varchar(100)    COMMENT '跳转链接',
`appid` varchar(30)    COMMENT '跳转链接',
`type` tinyint(4) NOT NULL   COMMENT '轮播图片',
`app_url` varchar(30)    COMMENT '轮播图片',
`image` varchar(255) NOT NULL   COMMENT '轮播图片',
`sort` int(11) NOT NULL   COMMENT '排序',
`show_switch` tinyint(4) NOT NULL   COMMENT '是否显示',
`create_time` int(11) NOT NULL   COMMENT '添加时间',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_cates` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`title` varchar(255) NOT NULL   COMMENT '分类名称',
`icon` varchar(255) NOT NULL   COMMENT '分类图标',
`type` tinyint(4) NOT NULL   COMMENT '类型:1=问题分类，2=网点分类',
`status` enum('0','1') NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '状态',
`sort` int(11) NOT NULL,
`create_time` int(11) NOT NULL   COMMENT '添加时间',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_command` (
`id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID',
`type` varchar(30) NOT NULL   COMMENT '类型',
`params` varchar(1500) NOT NULL   COMMENT '参数',
`command` varchar(1500) NOT NULL   COMMENT '命令',
`content` text()    COMMENT '返回结果',
`executetime` int(10) NOT NULL   COMMENT '执行时间',
`createtime` int(10) NOT NULL   COMMENT '创建时间',
`updatetime` int(10) NOT NULL   COMMENT '更新时间',
`status` enum('successed','failured') NOT NULL DEFAULT NULL DEFAULT 'failured'  COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_config` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`name` varchar(30) NOT NULL   COMMENT '变量名',
`value` text() NOT NULL   COMMENT '变量值',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_counter` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`city_id` int(11) NOT NULL   COMMENT '所属分类',
`name` varchar(30) NOT NULL   COMMENT '营业点名称',
`address` varchar(255) NOT NULL   COMMENT '营业点地址',
`phone` char(11) NOT NULL   COMMENT '联系电话',
`uniacid` int(11) NOT NULL,
`create_time` int(11) NOT NULL   COMMENT '添加时间',
`update_time` int(11) NOT NULL   COMMENT '更新时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_coupon` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`name` varchar(100) NOT NULL   COMMENT '优惠券名称',
`code` varchar(100) NOT NULL   COMMENT '兑换码',
`amount` int(11) NOT NULL   COMMENT '数量',
`price` decimal(10,2) NOT NULL   COMMENT '金额',
`start_time` int(11) NOT NULL   COMMENT '开始时间',
`end_time` int(11) NOT NULL   COMMENT '结束时间',
`is_show_switch` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '是否显示',
`createtime` int(11) NOT NULL   COMMENT '创建时间',
`use_limit` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '使用门槛',
`sort` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`updatetime` char(10) NOT NULL,
`desc` varchar(20) NOT NULL   COMMENT '简述',
`get_number` int(11) NOT NULL   COMMENT '领取数量',
`over_time` int(10) NOT NULL   COMMENT '过期时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_driver` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`nick_name` varchar(11) NOT NULL   COMMENT '微信昵称',
`open_id` varchar(50) NOT NULL,
`driver_name` varchar(10) NOT NULL   COMMENT '姓名',
`driver_phone` char(11) NOT NULL   COMMENT '联系号码',
`driver_IDcard` char(18) NOT NULL   COMMENT '身份证号',
`plate_number` varchar(10) NOT NULL   COMMENT '车牌号',
`front_IDcard_image` varchar(255) NOT NULL   COMMENT '正面身份证照',
`contrary_IDcard_image` varchar(255) NOT NULL   COMMENT '背面身份证照',
`driving_license` varchar(255) NOT NULL   COMMENT '驾驶证',
`car_image` varchar(255) NOT NULL   COMMENT '车身照',
`photo` varchar(255) NOT NULL   COMMENT '个人照片',
`drivers_license` varchar(255) NOT NULL   COMMENT '行驶证',
`drivers_license_copy` varchar(255) NOT NULL   COMMENT '行驶证副本',
`create_time` int(11) NOT NULL   COMMENT '创建时间',
`update_time` int(11) NOT NULL   COMMENT '更新时间',
`status` tinyint(1) NOT NULL   COMMENT '状态:0=审核中,1=审核通过,2=审核失败',
`uniacid` int(11) NOT NULL,
`car_id` int(11) NOT NULL   COMMENT '车型',
`flank_car_image` varchar(255) NOT NULL   COMMENT '侧面车身照',
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_driver_cancel_order` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_id` int(11) NOT NULL,
`driver_id` int(11) NOT NULL,
`create_time` int(11) NOT NULL   COMMENT '取消时间',
`order_number` varchar(50) NOT NULL   COMMENT '取消的订单号',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_driver_info` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`driver_id` int(11) NOT NULL,
`latitude` double(10,6) NOT NULL   COMMENT '维度',
`longitude` double(10,6) NOT NULL   COMMENT '经度',
`statef` tinyint(1) NOT NULL   COMMENT '状态:1=接单，2=不听单,3=禁止接单',
`address` varchar(255) NOT NULL   COMMENT '听单地址',
`balance` decimal(10,2) NOT NULL   COMMENT '余额',
`service_mark` float(10,1) NOT NULL DEFAULT NULL DEFAULT '5.0'  COMMENT '服务分数',
`service_number` int(11) NOT NULL,
`cancel_number` int(11) NOT NULL   COMMENT '取消订单次数',
`uniacid` int(11) NOT NULL,
`count_km` double(8,2) NOT NULL   COMMENT '配送总行程',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_driver_order` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`driver_id` int(11) NOT NULL   COMMENT '司机ID',
`order_id` int(11) NOT NULL   COMMENT '订单ID',
`create_time` int(11) NOT NULL   COMMENT '接单时间',
`end_time` int(11) NOT NULL   COMMENT '送达时间',
`picture` varchar(255) NOT NULL   COMMENT '货物照片',
`get_cargo_time` int(11) NOT NULL   COMMENT '取货时间',
`order_time` int(11) NOT NULL   COMMENT '订单总共花费时间',
`latitude` double(10,6) NOT NULL,
`longitude` double(10,6) NOT NULL,
`deduct_price` decimal(10,2) NOT NULL   COMMENT '平台扣取费用',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_driver_update_car` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`driver_id` int(11) NOT NULL,
`car_id` int(11) NOT NULL,
`plate_number` varchar(20) NOT NULL   COMMENT '车牌号',
`flank_car_image` varchar(255) NOT NULL   COMMENT '车神侧面照',
`car_image` varchar(255) NOT NULL   COMMENT '车神正面照',
`drivers_license` varchar(255) NOT NULL   COMMENT '行驶证',
`drivers_license_copy` varchar(255) NOT NULL   COMMENT '行驶证副本',
`uniacid` int(11) NOT NULL,
`create_time` char(10) NOT NULL   COMMENT '创建时间',
`update_time` char(10) NOT NULL   COMMENT '修改时间',
`status` enum('0','1','2') NOT NULL   COMMENT '状态:0=待审核,1=审核通过,2=审核失败',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_faq` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`name` varchar(30) NOT NULL   COMMENT '问题名',
`content` varchar(255) NOT NULL   COMMENT '解答内容',
`sort` int(10) NOT NULL   COMMENT '排序',
`uniacid` int(11) NOT NULL,
`create_time` int(10) NOT NULL   COMMENT '添加时间',
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_feedback` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`uid` int(11) NOT NULL,
`name` varchar(255) NOT NULL   COMMENT '问题类型',
`content` varchar(255) NOT NULL   COMMENT '反馈内容',
`images` varchar(500) NOT NULL   COMMENT '反馈图片',
`status` enum('0','1') NOT NULL   COMMENT '状态:0=未处理,1=已处理',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`contact` varchar(20) NOT NULL   COMMENT '联系方式',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_order` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_number` varchar(50) NOT NULL   COMMENT '订单号',
`place_dispatch` varchar(255) NOT NULL   COMMENT '发货地',
`place_dispatch_detail` varchar(255) NOT NULL   COMMENT '发货地详情',
`place_receipt` varchar(255) NOT NULL   COMMENT '收货地',
`place_receipt_detail` varchar(255)    COMMENT '收货地详情',
`shipper_name` varchar(20) NOT NULL   COMMENT '发货人',
`shipper_phone` char(11) NOT NULL   COMMENT '发货人手机号',
`consignee` varchar(255) NOT NULL   COMMENT '收货人',
`consignee_phone` char(11) NOT NULL   COMMENT '收货人电话',
`appointment_time` varchar(50) NOT NULL   COMMENT '预约时间',
`remark` varchar(255) NOT NULL   COMMENT '备注',
`real_price` decimal(10,2) NOT NULL   COMMENT '实际价格',
`price` decimal(10,2) NOT NULL   COMMENT '订单价格',
`discount_price` decimal(10,2) NOT NULL   COMMENT '优惠价',
`user_coupon_id` int(10) NOT NULL   COMMENT '优惠券中间表ID',
`distance` double(7,2) NOT NULL   COMMENT '运送距离',
`car_id` int(11) NOT NULL   COMMENT '车辆ID',
`car_name` varchar(50) NOT NULL   COMMENT '配送车名字',
`start_price` decimal(10,2) NOT NULL   COMMENT '起步价',
`start_km` int(11) NOT NULL   COMMENT '起步里程',
`beyond` decimal(10,2) NOT NULL   COMMENT '超出起步里程价格',
`start_lat` varchar(255) NOT NULL   COMMENT '发货地纬度',
`start_lot` varchar(255) NOT NULL   COMMENT '发货地经度',
`end_lat` varchar(255) NOT NULL   COMMENT '收货地纬度',
`end_lot` varchar(255) NOT NULL   COMMENT '收地经度',
`status` enum('1','2','3','4','5','6','7','8') NOT NULL DEFAULT NULL DEFAULT '7'  COMMENT '订单状态:1=待接单,2=待取货,3=运输中,4=待评价,5=已完成,6=已取消,7=待付款，',
`type` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '类型:1=同城,2=跨城预约',
`uid` int(11) NOT NULL   COMMENT '用户ID',
`uniacid` int(11) NOT NULL,
`bulk` varchar(255) NOT NULL   COMMENT '物品体积',
`goods_name` varchar(255) NOT NULL   COMMENT '物品名称',
`create_time` int(11) NOT NULL   COMMENT '下单时间',
`update_time` int(11) NOT NULL   COMMENT '修改时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_score` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`score` int(11) NOT NULL   COMMENT '总评价',
`score1` int(11) NOT NULL,
`score2` int(11) NOT NULL,
`order_id` int(11) NOT NULL,
`driver_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`suggest` varchar(50) NOT NULL   COMMENT '建议',
`create_time` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_user_coupon` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`coupon_id` int(11) NOT NULL   COMMENT '优惠券ID',
`user_id` int(11) NOT NULL   COMMENT '用户ID',
`uniacid` int(11) NOT NULL,
`price` decimal(10,2) NOT NULL   COMMENT '优惠价格',
`use_limit` decimal(10,2) NOT NULL   COMMENT '使用门槛',
`title` varchar(20) NOT NULL   COMMENT '优惠券名称',
`desc` varchar(50) NOT NULL   COMMENT '优惠券简介',
`create_time` int(11) NOT NULL   COMMENT '领取时间',
`status` tinyint(4) NOT NULL   COMMENT '状态:0=未使用,1=使用,2=已过期',
`end_time` int(10) NOT NULL   COMMENT '过期时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_user_formid` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL   COMMENT '骑手id',
`open_id` varchar(32) NOT NULL   COMMENT '骑手openid',
`form_id` varchar(32) NOT NULL   COMMENT '服务通知formid',
`expire_time` int(10) NOT NULL   COMMENT '过期时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_users` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`nick_name` varchar(50) NOT NULL   COMMENT '用户昵称',
`avatar` varchar(255) NOT NULL   COMMENT '头像',
`open_id` varchar(50) NOT NULL   COMMENT 'open_id',
`gender` tinyint(4) NOT NULL   COMMENT '性别:1=男,2=女',
`grade` tinyint(4) NOT NULL   COMMENT '等级:1=普通会员,2=会员',
`phone` char(11) NOT NULL   COMMENT '手机号',
`real_name` varchar(20) NOT NULL   COMMENT '真实姓名',
`amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '消费金额',
`create_time` int(10) NOT NULL   COMMENT '创建时间',
`update_time` int(11) NOT NULL,
`last_time` int(10) NOT NULL   COMMENT '最近登录时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_vehicle` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`title` varchar(50) NOT NULL   COMMENT '车辆名称',
`load_capacity` varchar(10) NOT NULL,
`length` varchar(6) NOT NULL,
`width` varchar(6) NOT NULL,
`height` varchar(6) NOT NULL,
`icon` varchar(255) NOT NULL   COMMENT '车辆图标',
`s_icon` varchar(255) NOT NULL   COMMENT '选中图标',
`image` varchar(255) NOT NULL   COMMENT '车辆图片',
`starting_price` decimal(10,2) NOT NULL   COMMENT '起步价',
`starting_km` int(11) NOT NULL   COMMENT '起步里程',
`beyond_price` decimal(11,2) NOT NULL   COMMENT '超出起步价格',
`status` tinyint(4) NOT NULL   COMMENT '状态：0=显示，1=隐藏',
`create_time` int(11) NOT NULL   COMMENT '添加时间',
`update_time` int(11) NOT NULL   COMMENT '修改时间',
`uniacid` int(11) NOT NULL,
`sort` int(10) NOT NULL   COMMENT '排序',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_freight_withdrawal` (
`id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'id',
`order_number` varchar(255) NOT NULL   COMMENT '提现单号',
`driver_id` int(11) NOT NULL,
`title` varchar(255) NOT NULL   COMMENT '内容',
`open_id` varchar(30) NOT NULL,
`amount` decimal(10,2) NOT NULL   COMMENT '提现金额',
`status` enum('0','1') NOT NULL   COMMENT '状态:0=待打款,1=已打款',
`uniacid` int(10) NOT NULL,
`create_time` int(11) NOT NULL   COMMENT '提现时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'company')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `company` varchar(20) NOT NULL   COMMENT '公司名称';");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'img_url')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `img_url` varchar(255) NOT NULL   COMMENT '图片';");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'versions')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `versions` varchar(20) NOT NULL   COMMENT '版本号';");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `phone` char(11) NOT NULL   COMMENT '联系电话';");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'work_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `work_time` varchar(30) NOT NULL   COMMENT '工作时间';");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'email')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `email` varchar(20) NOT NULL   COMMENT '邮箱';");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'wechat')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `wechat` varchar(50) NOT NULL   COMMENT '微信公众号';");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `update_time` int(11) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('freight_about')) {
 if(!pdo_fieldexists('freight_about',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_about')." ADD `create_time` int(11) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'username')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `username` varchar(20) NOT NULL   COMMENT '用户名';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'nickname')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `nickname` varchar(50) NOT NULL   COMMENT '昵称';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'password')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `password` varchar(32) NOT NULL   COMMENT '密码';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'salt')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `salt` varchar(30) NOT NULL   COMMENT '密码盐';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'avatar')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `avatar` varchar(100) NOT NULL   COMMENT '头像';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'email')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `email` varchar(100) NOT NULL   COMMENT '电子邮箱';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'loginfailure')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `loginfailure` tinyint(1) NOT NULL   COMMENT '失败次数';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'logintime')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `logintime` int(10)    COMMENT '登录时间';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `uniacid` int(10)    COMMENT 'uniacid';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `createtime` int(10)    COMMENT '创建时间';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `updatetime` int(10)    COMMENT '更新时间';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'token')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `token` varchar(59) NOT NULL   COMMENT 'Session标识';");
 }
}
if(pdo_tableexists('freight_admin')) {
 if(!pdo_fieldexists('freight_admin',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin')." ADD `status` varchar(30) NOT NULL DEFAULT NULL DEFAULT 'normal'  COMMENT '状态';");
 }
}
if(pdo_tableexists('freight_admin_log')) {
 if(!pdo_fieldexists('freight_admin_log',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin_log')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID';");
 }
}
if(pdo_tableexists('freight_admin_log')) {
 if(!pdo_fieldexists('freight_admin_log',  'admin_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin_log')." ADD `admin_id` int(10) NOT NULL   COMMENT '管理员ID';");
 }
}
if(pdo_tableexists('freight_admin_log')) {
 if(!pdo_fieldexists('freight_admin_log',  'username')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin_log')." ADD `username` varchar(30) NOT NULL   COMMENT '管理员名字';");
 }
}
if(pdo_tableexists('freight_admin_log')) {
 if(!pdo_fieldexists('freight_admin_log',  'url')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin_log')." ADD `url` varchar(1500) NOT NULL   COMMENT '操作页面';");
 }
}
if(pdo_tableexists('freight_admin_log')) {
 if(!pdo_fieldexists('freight_admin_log',  'title')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin_log')." ADD `title` varchar(100) NOT NULL   COMMENT '日志标题';");
 }
}
if(pdo_tableexists('freight_admin_log')) {
 if(!pdo_fieldexists('freight_admin_log',  'content')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin_log')." ADD `content` text() NOT NULL   COMMENT '内容';");
 }
}
if(pdo_tableexists('freight_admin_log')) {
 if(!pdo_fieldexists('freight_admin_log',  'ip')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin_log')." ADD `ip` varchar(50) NOT NULL   COMMENT 'IP';");
 }
}
if(pdo_tableexists('freight_admin_log')) {
 if(!pdo_fieldexists('freight_admin_log',  'useragent')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin_log')." ADD `useragent` varchar(255) NOT NULL   COMMENT 'User-Agent';");
 }
}
if(pdo_tableexists('freight_admin_log')) {
 if(!pdo_fieldexists('freight_admin_log',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('freight_admin_log')." ADD `createtime` int(10)    COMMENT '操作时间';");
 }
}
if(pdo_tableexists('freight_amount_detail')) {
 if(!pdo_fieldexists('freight_amount_detail',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_amount_detail')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_amount_detail')) {
 if(!pdo_fieldexists('freight_amount_detail',  'driver_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_amount_detail')." ADD `driver_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_amount_detail')) {
 if(!pdo_fieldexists('freight_amount_detail',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('freight_amount_detail')." ADD `amount` decimal(10,2) NOT NULL   COMMENT '金额';");
 }
}
if(pdo_tableexists('freight_amount_detail')) {
 if(!pdo_fieldexists('freight_amount_detail',  'type')) {
  pdo_query("ALTER TABLE ".tablename('freight_amount_detail')." ADD `type` tinyint(1) NOT NULL   COMMENT '1=加，2=减';");
 }
}
if(pdo_tableexists('freight_amount_detail')) {
 if(!pdo_fieldexists('freight_amount_detail',  'title')) {
  pdo_query("ALTER TABLE ".tablename('freight_amount_detail')." ADD `title` varchar(20) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('freight_amount_detail')) {
 if(!pdo_fieldexists('freight_amount_detail',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_amount_detail')." ADD `create_time` int(11) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('freight_amount_detail')) {
 if(!pdo_fieldexists('freight_amount_detail',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_amount_detail')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `id` int(20) NOT NULL  AUTO_INCREMENT COMMENT 'ID';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'admin_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `admin_id` int(10) NOT NULL   COMMENT '管理员ID';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `user_id` int(10) NOT NULL   COMMENT '会员ID';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'url')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `url` varchar(255) NOT NULL   COMMENT '物理路径';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'imagewidth')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `imagewidth` varchar(30) NOT NULL   COMMENT '宽度';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'imageheight')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `imageheight` varchar(30) NOT NULL   COMMENT '高度';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'imagetype')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `imagetype` varchar(30) NOT NULL   COMMENT '图片类型';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'imageframes')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `imageframes` int(10) NOT NULL   COMMENT '图片帧数';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'filesize')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `filesize` int(10) NOT NULL   COMMENT '文件大小';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'mimetype')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `mimetype` varchar(100) NOT NULL   COMMENT 'mime类型';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'extparam')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `extparam` varchar(255) NOT NULL   COMMENT '透传数据';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `createtime` int(10)    COMMENT '创建日期';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `updatetime` int(10)    COMMENT '更新时间';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'uploadtime')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `uploadtime` int(10)    COMMENT '上传时间';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'storage')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `storage` varchar(100) NOT NULL DEFAULT NULL DEFAULT 'local'  COMMENT '存储位置';");
 }
}
if(pdo_tableexists('freight_attachment')) {
 if(!pdo_fieldexists('freight_attachment',  'sha1')) {
  pdo_query("ALTER TABLE ".tablename('freight_attachment')." ADD `sha1` varchar(40) NOT NULL   COMMENT '文件 sha1编码';");
 }
}
if(pdo_tableexists('freight_auth_group')) {
 if(!pdo_fieldexists('freight_auth_group',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_group')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_auth_group')) {
 if(!pdo_fieldexists('freight_auth_group',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_group')." ADD `pid` int(10) NOT NULL   COMMENT '父组别';");
 }
}
if(pdo_tableexists('freight_auth_group')) {
 if(!pdo_fieldexists('freight_auth_group',  'name')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_group')." ADD `name` varchar(100) NOT NULL   COMMENT '组名';");
 }
}
if(pdo_tableexists('freight_auth_group')) {
 if(!pdo_fieldexists('freight_auth_group',  'rules')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_group')." ADD `rules` text() NOT NULL   COMMENT '规则ID';");
 }
}
if(pdo_tableexists('freight_auth_group')) {
 if(!pdo_fieldexists('freight_auth_group',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_group')." ADD `createtime` int(10)    COMMENT '创建时间';");
 }
}
if(pdo_tableexists('freight_auth_group')) {
 if(!pdo_fieldexists('freight_auth_group',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_group')." ADD `updatetime` int(10)    COMMENT '更新时间';");
 }
}
if(pdo_tableexists('freight_auth_group')) {
 if(!pdo_fieldexists('freight_auth_group',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_group')." ADD `status` varchar(30) NOT NULL   COMMENT '状态';");
 }
}
if(pdo_tableexists('freight_auth_group_access')) {
 if(!pdo_fieldexists('freight_auth_group_access',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_group_access')." ADD `uid` int(10) NOT NULL   COMMENT '会员ID';");
 }
}
if(pdo_tableexists('freight_auth_group_access')) {
 if(!pdo_fieldexists('freight_auth_group_access',  'group_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_group_access')." ADD `group_id` int(10) NOT NULL   COMMENT '级别ID';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'type')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `type` enum('menu','file') NOT NULL DEFAULT NULL DEFAULT 'file'  COMMENT 'menu为菜单,file为权限节点';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `pid` int(10) NOT NULL   COMMENT '父ID';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'name')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `name` varchar(100) NOT NULL   COMMENT '规则名称';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'title')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `title` varchar(50) NOT NULL   COMMENT '规则名称';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'icon')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `icon` varchar(50) NOT NULL   COMMENT '图标';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'condition')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `condition` varchar(255) NOT NULL   COMMENT '条件';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `remark` varchar(255) NOT NULL   COMMENT '备注';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'ismenu')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `ismenu` tinyint(1) NOT NULL   COMMENT '是否为菜单';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `createtime` int(10)    COMMENT '创建时间';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `updatetime` int(10)    COMMENT '更新时间';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'weigh')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `weigh` int(10) NOT NULL   COMMENT '权重';");
 }
}
if(pdo_tableexists('freight_auth_rule')) {
 if(!pdo_fieldexists('freight_auth_rule',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_auth_rule')." ADD `status` varchar(30) NOT NULL   COMMENT '状态';");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'url')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `url` varchar(100)    COMMENT '跳转链接';");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'appid')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `appid` varchar(30)    COMMENT '跳转链接';");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'type')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `type` tinyint(4) NOT NULL   COMMENT '轮播图片';");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'app_url')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `app_url` varchar(30)    COMMENT '轮播图片';");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'image')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `image` varchar(255) NOT NULL   COMMENT '轮播图片';");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `sort` int(11) NOT NULL   COMMENT '排序';");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'show_switch')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `show_switch` tinyint(4) NOT NULL   COMMENT '是否显示';");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `create_time` int(11) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('freight_banner')) {
 if(!pdo_fieldexists('freight_banner',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_banner')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_cates')) {
 if(!pdo_fieldexists('freight_cates',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_cates')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_cates')) {
 if(!pdo_fieldexists('freight_cates',  'title')) {
  pdo_query("ALTER TABLE ".tablename('freight_cates')." ADD `title` varchar(255) NOT NULL   COMMENT '分类名称';");
 }
}
if(pdo_tableexists('freight_cates')) {
 if(!pdo_fieldexists('freight_cates',  'icon')) {
  pdo_query("ALTER TABLE ".tablename('freight_cates')." ADD `icon` varchar(255) NOT NULL   COMMENT '分类图标';");
 }
}
if(pdo_tableexists('freight_cates')) {
 if(!pdo_fieldexists('freight_cates',  'type')) {
  pdo_query("ALTER TABLE ".tablename('freight_cates')." ADD `type` tinyint(4) NOT NULL   COMMENT '类型:1=问题分类，2=网点分类';");
 }
}
if(pdo_tableexists('freight_cates')) {
 if(!pdo_fieldexists('freight_cates',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_cates')." ADD `status` enum('0','1') NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '状态';");
 }
}
if(pdo_tableexists('freight_cates')) {
 if(!pdo_fieldexists('freight_cates',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('freight_cates')." ADD `sort` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_cates')) {
 if(!pdo_fieldexists('freight_cates',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_cates')." ADD `create_time` int(11) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('freight_cates')) {
 if(!pdo_fieldexists('freight_cates',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_cates')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_command')) {
 if(!pdo_fieldexists('freight_command',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_command')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID';");
 }
}
if(pdo_tableexists('freight_command')) {
 if(!pdo_fieldexists('freight_command',  'type')) {
  pdo_query("ALTER TABLE ".tablename('freight_command')." ADD `type` varchar(30) NOT NULL   COMMENT '类型';");
 }
}
if(pdo_tableexists('freight_command')) {
 if(!pdo_fieldexists('freight_command',  'params')) {
  pdo_query("ALTER TABLE ".tablename('freight_command')." ADD `params` varchar(1500) NOT NULL   COMMENT '参数';");
 }
}
if(pdo_tableexists('freight_command')) {
 if(!pdo_fieldexists('freight_command',  'command')) {
  pdo_query("ALTER TABLE ".tablename('freight_command')." ADD `command` varchar(1500) NOT NULL   COMMENT '命令';");
 }
}
if(pdo_tableexists('freight_command')) {
 if(!pdo_fieldexists('freight_command',  'content')) {
  pdo_query("ALTER TABLE ".tablename('freight_command')." ADD `content` text()    COMMENT '返回结果';");
 }
}
if(pdo_tableexists('freight_command')) {
 if(!pdo_fieldexists('freight_command',  'executetime')) {
  pdo_query("ALTER TABLE ".tablename('freight_command')." ADD `executetime` int(10) NOT NULL   COMMENT '执行时间';");
 }
}
if(pdo_tableexists('freight_command')) {
 if(!pdo_fieldexists('freight_command',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('freight_command')." ADD `createtime` int(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('freight_command')) {
 if(!pdo_fieldexists('freight_command',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('freight_command')." ADD `updatetime` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('freight_command')) {
 if(!pdo_fieldexists('freight_command',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_command')." ADD `status` enum('successed','failured') NOT NULL DEFAULT NULL DEFAULT 'failured'  COMMENT '状态';");
 }
}
if(pdo_tableexists('freight_config')) {
 if(!pdo_fieldexists('freight_config',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_config')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_config')) {
 if(!pdo_fieldexists('freight_config',  'name')) {
  pdo_query("ALTER TABLE ".tablename('freight_config')." ADD `name` varchar(30) NOT NULL   COMMENT '变量名';");
 }
}
if(pdo_tableexists('freight_config')) {
 if(!pdo_fieldexists('freight_config',  'value')) {
  pdo_query("ALTER TABLE ".tablename('freight_config')." ADD `value` text() NOT NULL   COMMENT '变量值';");
 }
}
if(pdo_tableexists('freight_config')) {
 if(!pdo_fieldexists('freight_config',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_config')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_counter')) {
 if(!pdo_fieldexists('freight_counter',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_counter')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_counter')) {
 if(!pdo_fieldexists('freight_counter',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_counter')." ADD `city_id` int(11) NOT NULL   COMMENT '所属分类';");
 }
}
if(pdo_tableexists('freight_counter')) {
 if(!pdo_fieldexists('freight_counter',  'name')) {
  pdo_query("ALTER TABLE ".tablename('freight_counter')." ADD `name` varchar(30) NOT NULL   COMMENT '营业点名称';");
 }
}
if(pdo_tableexists('freight_counter')) {
 if(!pdo_fieldexists('freight_counter',  'address')) {
  pdo_query("ALTER TABLE ".tablename('freight_counter')." ADD `address` varchar(255) NOT NULL   COMMENT '营业点地址';");
 }
}
if(pdo_tableexists('freight_counter')) {
 if(!pdo_fieldexists('freight_counter',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('freight_counter')." ADD `phone` char(11) NOT NULL   COMMENT '联系电话';");
 }
}
if(pdo_tableexists('freight_counter')) {
 if(!pdo_fieldexists('freight_counter',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_counter')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_counter')) {
 if(!pdo_fieldexists('freight_counter',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_counter')." ADD `create_time` int(11) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('freight_counter')) {
 if(!pdo_fieldexists('freight_counter',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_counter')." ADD `update_time` int(11) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'name')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `name` varchar(100) NOT NULL   COMMENT '优惠券名称';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'code')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `code` varchar(100) NOT NULL   COMMENT '兑换码';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `amount` int(11) NOT NULL   COMMENT '数量';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'price')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `price` decimal(10,2) NOT NULL   COMMENT '金额';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'start_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `start_time` int(11) NOT NULL   COMMENT '开始时间';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `end_time` int(11) NOT NULL   COMMENT '结束时间';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'is_show_switch')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `is_show_switch` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '是否显示';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `createtime` int(11) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'use_limit')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `use_limit` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '使用门槛';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `sort` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `updatetime` char(10) NOT NULL;");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'desc')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `desc` varchar(20) NOT NULL   COMMENT '简述';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'get_number')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `get_number` int(11) NOT NULL   COMMENT '领取数量';");
 }
}
if(pdo_tableexists('freight_coupon')) {
 if(!pdo_fieldexists('freight_coupon',  'over_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_coupon')." ADD `over_time` int(10) NOT NULL   COMMENT '过期时间';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'nick_name')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `nick_name` varchar(11) NOT NULL   COMMENT '微信昵称';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'open_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `open_id` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'driver_name')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `driver_name` varchar(10) NOT NULL   COMMENT '姓名';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'driver_phone')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `driver_phone` char(11) NOT NULL   COMMENT '联系号码';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'driver_IDcard')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `driver_IDcard` char(18) NOT NULL   COMMENT '身份证号';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'plate_number')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `plate_number` varchar(10) NOT NULL   COMMENT '车牌号';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'front_IDcard_image')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `front_IDcard_image` varchar(255) NOT NULL   COMMENT '正面身份证照';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'contrary_IDcard_image')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `contrary_IDcard_image` varchar(255) NOT NULL   COMMENT '背面身份证照';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'driving_license')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `driving_license` varchar(255) NOT NULL   COMMENT '驾驶证';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'car_image')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `car_image` varchar(255) NOT NULL   COMMENT '车身照';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'photo')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `photo` varchar(255) NOT NULL   COMMENT '个人照片';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'drivers_license')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `drivers_license` varchar(255) NOT NULL   COMMENT '行驶证';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'drivers_license_copy')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `drivers_license_copy` varchar(255) NOT NULL   COMMENT '行驶证副本';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `create_time` int(11) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `update_time` int(11) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `status` tinyint(1) NOT NULL   COMMENT '状态:0=审核中,1=审核通过,2=审核失败';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'car_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `car_id` int(11) NOT NULL   COMMENT '车型';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'flank_car_image')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `flank_car_image` varchar(255) NOT NULL   COMMENT '侧面车身照';");
 }
}
if(pdo_tableexists('freight_driver')) {
 if(!pdo_fieldexists('freight_driver',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver')." ADD `user_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_cancel_order')) {
 if(!pdo_fieldexists('freight_driver_cancel_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_cancel_order')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_driver_cancel_order')) {
 if(!pdo_fieldexists('freight_driver_cancel_order',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_cancel_order')." ADD `order_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_cancel_order')) {
 if(!pdo_fieldexists('freight_driver_cancel_order',  'driver_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_cancel_order')." ADD `driver_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_cancel_order')) {
 if(!pdo_fieldexists('freight_driver_cancel_order',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_cancel_order')." ADD `create_time` int(11) NOT NULL   COMMENT '取消时间';");
 }
}
if(pdo_tableexists('freight_driver_cancel_order')) {
 if(!pdo_fieldexists('freight_driver_cancel_order',  'order_number')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_cancel_order')." ADD `order_number` varchar(50) NOT NULL   COMMENT '取消的订单号';");
 }
}
if(pdo_tableexists('freight_driver_cancel_order')) {
 if(!pdo_fieldexists('freight_driver_cancel_order',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_cancel_order')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'driver_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `driver_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'latitude')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `latitude` double(10,6) NOT NULL   COMMENT '维度';");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'longitude')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `longitude` double(10,6) NOT NULL   COMMENT '经度';");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'statef')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `statef` tinyint(1) NOT NULL   COMMENT '状态:1=接单，2=不听单,3=禁止接单';");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'address')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `address` varchar(255) NOT NULL   COMMENT '听单地址';");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'balance')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `balance` decimal(10,2) NOT NULL   COMMENT '余额';");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'service_mark')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `service_mark` float(10,1) NOT NULL DEFAULT NULL DEFAULT '5.0'  COMMENT '服务分数';");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'service_number')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `service_number` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'cancel_number')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `cancel_number` int(11) NOT NULL   COMMENT '取消订单次数';");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_info')) {
 if(!pdo_fieldexists('freight_driver_info',  'count_km')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_info')." ADD `count_km` double(8,2) NOT NULL   COMMENT '配送总行程';");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'driver_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `driver_id` int(11) NOT NULL   COMMENT '司机ID';");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `order_id` int(11) NOT NULL   COMMENT '订单ID';");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `create_time` int(11) NOT NULL   COMMENT '接单时间';");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `end_time` int(11) NOT NULL   COMMENT '送达时间';");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'picture')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `picture` varchar(255) NOT NULL   COMMENT '货物照片';");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'get_cargo_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `get_cargo_time` int(11) NOT NULL   COMMENT '取货时间';");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'order_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `order_time` int(11) NOT NULL   COMMENT '订单总共花费时间';");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'latitude')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `latitude` double(10,6) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'longitude')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `longitude` double(10,6) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'deduct_price')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `deduct_price` decimal(10,2) NOT NULL   COMMENT '平台扣取费用';");
 }
}
if(pdo_tableexists('freight_driver_order')) {
 if(!pdo_fieldexists('freight_driver_order',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_order')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'driver_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `driver_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'car_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `car_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'plate_number')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `plate_number` varchar(20) NOT NULL   COMMENT '车牌号';");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'flank_car_image')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `flank_car_image` varchar(255) NOT NULL   COMMENT '车神侧面照';");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'car_image')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `car_image` varchar(255) NOT NULL   COMMENT '车神正面照';");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'drivers_license')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `drivers_license` varchar(255) NOT NULL   COMMENT '行驶证';");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'drivers_license_copy')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `drivers_license_copy` varchar(255) NOT NULL   COMMENT '行驶证副本';");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `create_time` char(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `update_time` char(10) NOT NULL   COMMENT '修改时间';");
 }
}
if(pdo_tableexists('freight_driver_update_car')) {
 if(!pdo_fieldexists('freight_driver_update_car',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_driver_update_car')." ADD `status` enum('0','1','2') NOT NULL   COMMENT '状态:0=待审核,1=审核通过,2=审核失败';");
 }
}
if(pdo_tableexists('freight_faq')) {
 if(!pdo_fieldexists('freight_faq',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_faq')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_faq')) {
 if(!pdo_fieldexists('freight_faq',  'name')) {
  pdo_query("ALTER TABLE ".tablename('freight_faq')." ADD `name` varchar(30) NOT NULL   COMMENT '问题名';");
 }
}
if(pdo_tableexists('freight_faq')) {
 if(!pdo_fieldexists('freight_faq',  'content')) {
  pdo_query("ALTER TABLE ".tablename('freight_faq')." ADD `content` varchar(255) NOT NULL   COMMENT '解答内容';");
 }
}
if(pdo_tableexists('freight_faq')) {
 if(!pdo_fieldexists('freight_faq',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('freight_faq')." ADD `sort` int(10) NOT NULL   COMMENT '排序';");
 }
}
if(pdo_tableexists('freight_faq')) {
 if(!pdo_fieldexists('freight_faq',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_faq')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_faq')) {
 if(!pdo_fieldexists('freight_faq',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_faq')." ADD `create_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('freight_faq')) {
 if(!pdo_fieldexists('freight_faq',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_faq')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `uid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'name')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `name` varchar(255) NOT NULL   COMMENT '问题类型';");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'content')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `content` varchar(255) NOT NULL   COMMENT '反馈内容';");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'images')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `images` varchar(500) NOT NULL   COMMENT '反馈图片';");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `status` enum('0','1') NOT NULL   COMMENT '状态:0=未处理,1=已处理';");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `create_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_feedback')) {
 if(!pdo_fieldexists('freight_feedback',  'contact')) {
  pdo_query("ALTER TABLE ".tablename('freight_feedback')." ADD `contact` varchar(20) NOT NULL   COMMENT '联系方式';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'order_number')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `order_number` varchar(50) NOT NULL   COMMENT '订单号';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'place_dispatch')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `place_dispatch` varchar(255) NOT NULL   COMMENT '发货地';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'place_dispatch_detail')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `place_dispatch_detail` varchar(255) NOT NULL   COMMENT '发货地详情';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'place_receipt')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `place_receipt` varchar(255) NOT NULL   COMMENT '收货地';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'place_receipt_detail')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `place_receipt_detail` varchar(255)    COMMENT '收货地详情';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'shipper_name')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `shipper_name` varchar(20) NOT NULL   COMMENT '发货人';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'shipper_phone')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `shipper_phone` char(11) NOT NULL   COMMENT '发货人手机号';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'consignee')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `consignee` varchar(255) NOT NULL   COMMENT '收货人';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'consignee_phone')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `consignee_phone` char(11) NOT NULL   COMMENT '收货人电话';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'appointment_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `appointment_time` varchar(50) NOT NULL   COMMENT '预约时间';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `remark` varchar(255) NOT NULL   COMMENT '备注';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'real_price')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `real_price` decimal(10,2) NOT NULL   COMMENT '实际价格';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'price')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `price` decimal(10,2) NOT NULL   COMMENT '订单价格';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'discount_price')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `discount_price` decimal(10,2) NOT NULL   COMMENT '优惠价';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'user_coupon_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `user_coupon_id` int(10) NOT NULL   COMMENT '优惠券中间表ID';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'distance')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `distance` double(7,2) NOT NULL   COMMENT '运送距离';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'car_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `car_id` int(11) NOT NULL   COMMENT '车辆ID';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'car_name')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `car_name` varchar(50) NOT NULL   COMMENT '配送车名字';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'start_price')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `start_price` decimal(10,2) NOT NULL   COMMENT '起步价';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'start_km')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `start_km` int(11) NOT NULL   COMMENT '起步里程';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'beyond')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `beyond` decimal(10,2) NOT NULL   COMMENT '超出起步里程价格';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'start_lat')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `start_lat` varchar(255) NOT NULL   COMMENT '发货地纬度';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'start_lot')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `start_lot` varchar(255) NOT NULL   COMMENT '发货地经度';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'end_lat')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `end_lat` varchar(255) NOT NULL   COMMENT '收货地纬度';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'end_lot')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `end_lot` varchar(255) NOT NULL   COMMENT '收地经度';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `status` enum('1','2','3','4','5','6','7','8') NOT NULL DEFAULT NULL DEFAULT '7'  COMMENT '订单状态:1=待接单,2=待取货,3=运输中,4=待评价,5=已完成,6=已取消,7=待付款，';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'type')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `type` tinyint(4) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '类型:1=同城,2=跨城预约';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `uid` int(11) NOT NULL   COMMENT '用户ID';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'bulk')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `bulk` varchar(255) NOT NULL   COMMENT '物品体积';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'goods_name')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `goods_name` varchar(255) NOT NULL   COMMENT '物品名称';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `create_time` int(11) NOT NULL   COMMENT '下单时间';");
 }
}
if(pdo_tableexists('freight_order')) {
 if(!pdo_fieldexists('freight_order',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_order')." ADD `update_time` int(11) NOT NULL   COMMENT '修改时间';");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'score')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `score` int(11) NOT NULL   COMMENT '总评价';");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'score1')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `score1` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'score2')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `score2` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `order_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'driver_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `driver_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `user_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'suggest')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `suggest` varchar(50) NOT NULL   COMMENT '建议';");
 }
}
if(pdo_tableexists('freight_score')) {
 if(!pdo_fieldexists('freight_score',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_score')." ADD `create_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'coupon_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `coupon_id` int(11) NOT NULL   COMMENT '优惠券ID';");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `user_id` int(11) NOT NULL   COMMENT '用户ID';");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'price')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `price` decimal(10,2) NOT NULL   COMMENT '优惠价格';");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'use_limit')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `use_limit` decimal(10,2) NOT NULL   COMMENT '使用门槛';");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'title')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `title` varchar(20) NOT NULL   COMMENT '优惠券名称';");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'desc')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `desc` varchar(50) NOT NULL   COMMENT '优惠券简介';");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `create_time` int(11) NOT NULL   COMMENT '领取时间';");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `status` tinyint(4) NOT NULL   COMMENT '状态:0=未使用,1=使用,2=已过期';");
 }
}
if(pdo_tableexists('freight_user_coupon')) {
 if(!pdo_fieldexists('freight_user_coupon',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_coupon')." ADD `end_time` int(10) NOT NULL   COMMENT '过期时间';");
 }
}
if(pdo_tableexists('freight_user_formid')) {
 if(!pdo_fieldexists('freight_user_formid',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_formid')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_user_formid')) {
 if(!pdo_fieldexists('freight_user_formid',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_formid')." ADD `user_id` int(10) NOT NULL   COMMENT '骑手id';");
 }
}
if(pdo_tableexists('freight_user_formid')) {
 if(!pdo_fieldexists('freight_user_formid',  'open_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_formid')." ADD `open_id` varchar(32) NOT NULL   COMMENT '骑手openid';");
 }
}
if(pdo_tableexists('freight_user_formid')) {
 if(!pdo_fieldexists('freight_user_formid',  'form_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_formid')." ADD `form_id` varchar(32) NOT NULL   COMMENT '服务通知formid';");
 }
}
if(pdo_tableexists('freight_user_formid')) {
 if(!pdo_fieldexists('freight_user_formid',  'expire_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_formid')." ADD `expire_time` int(10) NOT NULL   COMMENT '过期时间';");
 }
}
if(pdo_tableexists('freight_user_formid')) {
 if(!pdo_fieldexists('freight_user_formid',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_user_formid')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'nick_name')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `nick_name` varchar(50) NOT NULL   COMMENT '用户昵称';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'avatar')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `avatar` varchar(255) NOT NULL   COMMENT '头像';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'open_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `open_id` varchar(50) NOT NULL   COMMENT 'open_id';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'gender')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `gender` tinyint(4) NOT NULL   COMMENT '性别:1=男,2=女';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'grade')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `grade` tinyint(4) NOT NULL   COMMENT '等级:1=普通会员,2=会员';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `phone` char(11) NOT NULL   COMMENT '手机号';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'real_name')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `real_name` varchar(20) NOT NULL   COMMENT '真实姓名';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '消费金额';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `create_time` int(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `update_time` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'last_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `last_time` int(10) NOT NULL   COMMENT '最近登录时间';");
 }
}
if(pdo_tableexists('freight_users')) {
 if(!pdo_fieldexists('freight_users',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_users')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'title')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `title` varchar(50) NOT NULL   COMMENT '车辆名称';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'load_capacity')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `load_capacity` varchar(10) NOT NULL;");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'length')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `length` varchar(6) NOT NULL;");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'width')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `width` varchar(6) NOT NULL;");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'height')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `height` varchar(6) NOT NULL;");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'icon')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `icon` varchar(255) NOT NULL   COMMENT '车辆图标';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  's_icon')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `s_icon` varchar(255) NOT NULL   COMMENT '选中图标';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'image')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `image` varchar(255) NOT NULL   COMMENT '车辆图片';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'starting_price')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `starting_price` decimal(10,2) NOT NULL   COMMENT '起步价';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'starting_km')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `starting_km` int(11) NOT NULL   COMMENT '起步里程';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'beyond_price')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `beyond_price` decimal(11,2) NOT NULL   COMMENT '超出起步价格';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `status` tinyint(4) NOT NULL   COMMENT '状态：0=显示，1=隐藏';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `create_time` int(11) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `update_time` int(11) NOT NULL   COMMENT '修改时间';");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_vehicle')) {
 if(!pdo_fieldexists('freight_vehicle',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('freight_vehicle')." ADD `sort` int(10) NOT NULL   COMMENT '排序';");
 }
}
if(pdo_tableexists('freight_withdrawal')) {
 if(!pdo_fieldexists('freight_withdrawal',  'id')) {
  pdo_query("ALTER TABLE ".tablename('freight_withdrawal')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'id';");
 }
}
if(pdo_tableexists('freight_withdrawal')) {
 if(!pdo_fieldexists('freight_withdrawal',  'order_number')) {
  pdo_query("ALTER TABLE ".tablename('freight_withdrawal')." ADD `order_number` varchar(255) NOT NULL   COMMENT '提现单号';");
 }
}
if(pdo_tableexists('freight_withdrawal')) {
 if(!pdo_fieldexists('freight_withdrawal',  'driver_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_withdrawal')." ADD `driver_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('freight_withdrawal')) {
 if(!pdo_fieldexists('freight_withdrawal',  'title')) {
  pdo_query("ALTER TABLE ".tablename('freight_withdrawal')." ADD `title` varchar(255) NOT NULL   COMMENT '内容';");
 }
}
if(pdo_tableexists('freight_withdrawal')) {
 if(!pdo_fieldexists('freight_withdrawal',  'open_id')) {
  pdo_query("ALTER TABLE ".tablename('freight_withdrawal')." ADD `open_id` varchar(30) NOT NULL;");
 }
}
if(pdo_tableexists('freight_withdrawal')) {
 if(!pdo_fieldexists('freight_withdrawal',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('freight_withdrawal')." ADD `amount` decimal(10,2) NOT NULL   COMMENT '提现金额';");
 }
}
if(pdo_tableexists('freight_withdrawal')) {
 if(!pdo_fieldexists('freight_withdrawal',  'status')) {
  pdo_query("ALTER TABLE ".tablename('freight_withdrawal')." ADD `status` enum('0','1') NOT NULL   COMMENT '状态:0=待打款,1=已打款';");
 }
}
if(pdo_tableexists('freight_withdrawal')) {
 if(!pdo_fieldexists('freight_withdrawal',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('freight_withdrawal')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('freight_withdrawal')) {
 if(!pdo_fieldexists('freight_withdrawal',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('freight_withdrawal')." ADD `create_time` int(11) NOT NULL   COMMENT '提现时间';");
 }
}
