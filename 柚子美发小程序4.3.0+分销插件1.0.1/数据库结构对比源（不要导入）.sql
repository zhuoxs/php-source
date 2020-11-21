/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-06-06 23:38:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_ymmf_sun_account
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_account`;
CREATE TABLE `ims_ymmf_sun_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` varchar(1000) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `from_user` varchar(100) NOT NULL DEFAULT '',
  `accountname` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `salt` varchar(10) NOT NULL DEFAULT '',
  `pwd` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pay_account` varchar(200) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态',
  `role` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:店长,2:店员',
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(15) NOT NULL,
  `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_boss` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `cityname` varchar(50) NOT NULL COMMENT '城市名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_ad
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_ad`;
CREATE TABLE `ims_ymmf_sun_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '轮播图标题',
  `logo` varchar(200) NOT NULL COMMENT '图片',
  `status` int(11) NOT NULL COMMENT '1.开启  2.关闭',
  `src` varchar(100) NOT NULL COMMENT '链接',
  `orderby` int(11) NOT NULL COMMENT '排序',
  `xcx_name` varchar(20) NOT NULL,
  `appid` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `type` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `wb_src` varchar(300) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_adminstore
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_adminstore`;
CREATE TABLE `ims_ymmf_sun_adminstore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `store_name` varchar(45) DEFAULT NULL COMMENT '店长名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_appionorder
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_appionorder`;
CREATE TABLE `ims_ymmf_sun_appionorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `user_id` varchar(120) NOT NULL,
  `money` varchar(80) NOT NULL,
  `tel` varchar(80) NOT NULL,
  `good_num` int(11) NOT NULL,
  `appiontime` text NOT NULL,
  `hair_id` int(11) NOT NULL,
  `remark` text,
  `pname` varchar(255) NOT NULL,
  `user_name` varchar(120) NOT NULL,
  `isdefault` int(11) NOT NULL COMMENT '是否完成订单',
  `addtime` datetime NOT NULL,
  `number` varchar(45) DEFAULT NULL COMMENT '订单号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_ymmf_sun_area
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_area`;
CREATE TABLE `ims_ymmf_sun_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(50) NOT NULL COMMENT '区域名称',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_banner`;
CREATE TABLE `ims_ymmf_sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(45) NOT NULL,
  `lb_imgs` varchar(500) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `bname1` varchar(120) DEFAULT NULL,
  `bname2` varchar(120) DEFAULT NULL,
  `bname3` varchar(120) DEFAULT NULL,
  `lb_imgs1` varchar(500) DEFAULT NULL,
  `lb_imgs2` varchar(500) DEFAULT NULL,
  `lb_imgs3` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_branch
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_branch`;
CREATE TABLE `ims_ymmf_sun_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `stutes` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `lng` varchar(45) DEFAULT NULL,
  `lat` varchar(45) DEFAULT NULL,
  `logo` varchar(120) DEFAULT NULL,
  `user` varchar(40) DEFAULT NULL COMMENT '登录账号',
  `key` varchar(40) DEFAULT NULL COMMENT '秘钥',
  `sn` varchar(10) DEFAULT NULL COMMENT '编码',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额，不减少',
  `frozenamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现金额',
  `bind_uid` varchar(255) DEFAULT NULL COMMENT '绑定的用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_build_switch
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_build_switch`;
CREATE TABLE `ims_ymmf_sun_build_switch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(80) DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_buildhair
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_buildhair`;
CREATE TABLE `ims_ymmf_sun_buildhair` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `build_id` int(11) DEFAULT NULL COMMENT '分店id',
  `hair_id` int(11) DEFAULT NULL COMMENT '技师id',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_business_account
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_business_account`;
CREATE TABLE `ims_ymmf_sun_business_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `account` varchar(255) NOT NULL COMMENT '账户',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `username` varchar(255) DEFAULT NULL COMMENT '商家后台显示的用户名,默认为微信名',
  `img` varchar(255) DEFAULT NULL COMMENT '商家后台用户头像,默认为微信头像',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商家后台账户表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_car
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_car`;
CREATE TABLE `ims_ymmf_sun_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `start_place` varchar(100) NOT NULL COMMENT '出发地',
  `end_place` varchar(100) NOT NULL COMMENT '目的地',
  `start_time` varchar(30) NOT NULL COMMENT '出发时间',
  `num` int(4) NOT NULL COMMENT '乘车人数/可乘人数',
  `link_name` varchar(30) NOT NULL COMMENT '联系人',
  `link_tel` varchar(20) NOT NULL COMMENT '联系电话',
  `typename` varchar(30) NOT NULL COMMENT '分类名称',
  `other` varchar(300) NOT NULL COMMENT '补充',
  `time` int(11) NOT NULL COMMENT '发布时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `top_id` int(11) NOT NULL COMMENT '置顶ID',
  `top` int(4) NOT NULL COMMENT '是否置顶,1,是,2否',
  `uniacid` varchar(50) NOT NULL,
  `state` int(4) NOT NULL COMMENT '1待审核,2通过，3拒绝',
  `tj_place` varchar(300) NOT NULL COMMENT '途经地',
  `hw_wet` varchar(10) NOT NULL COMMENT '货物重量',
  `star_lat` varchar(20) NOT NULL COMMENT '出发地维度',
  `star_lng` varchar(20) NOT NULL COMMENT '出发地经度',
  `end_lat` varchar(20) NOT NULL COMMENT '目的地维度',
  `end_lng` varchar(20) NOT NULL COMMENT '目的地经度',
  `is_open` int(4) NOT NULL,
  `start_time2` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼车';

-- ----------------------------
-- Table structure for ims_ymmf_sun_car_my_tag
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_car_my_tag`;
CREATE TABLE `ims_ymmf_sun_car_my_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL COMMENT '标签id',
  `car_id` int(11) NOT NULL COMMENT '拼车ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_car_tag
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_car_tag`;
CREATE TABLE `ims_ymmf_sun_car_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(30) NOT NULL COMMENT '分类名称',
  `tagname` varchar(30) NOT NULL COMMENT '标签名称',
  `uniacid` varchar(11) NOT NULL COMMENT '50',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_car_top
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_car_top`;
CREATE TABLE `ims_ymmf_sun_car_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月',
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼车置顶';

-- ----------------------------
-- Table structure for ims_ymmf_sun_carpaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_carpaylog`;
CREATE TABLE `ims_ymmf_sun_carpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(44) NOT NULL COMMENT '拼车id',
  `money` decimal(10,2) NOT NULL COMMENT '钱',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼车支付记录表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_comments
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_comments`;
CREATE TABLE `ims_ymmf_sun_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL COMMENT '帖子id',
  `details` varchar(200) NOT NULL COMMENT '评论详情',
  `time` varchar(20) NOT NULL COMMENT '时间',
  `reply` varchar(200) NOT NULL COMMENT '回复详情',
  `hf_time` varchar(20) NOT NULL COMMENT '回复时间',
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `score` decimal(10,1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_commission_withdrawal
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_commission_withdrawal`;
CREATE TABLE `ims_ymmf_sun_commission_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1.支付宝2.银行卡',
  `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝',
  `time` int(11) NOT NULL COMMENT '申请时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `uniacid` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `account` varchar(100) NOT NULL,
  `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额',
  `sj_cost` decimal(10,2) NOT NULL COMMENT '实际到账金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金提现';

-- ----------------------------
-- Table structure for ims_ymmf_sun_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_coupon`;
CREATE TABLE `ims_ymmf_sun_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '优惠券名称，展示用',
  `type` tinyint(3) unsigned NOT NULL COMMENT '优惠券类型（1:折扣 2:代金 ）',
  `astime` date DEFAULT NULL COMMENT '活动开始时间',
  `antime` date DEFAULT NULL COMMENT '活动结束时间',
  `expiryDate` int(10) unsigned DEFAULT NULL COMMENT '领取后，使用有效期',
  `allowance` int(10) unsigned DEFAULT NULL COMMENT '余量',
  `total` int(10) unsigned DEFAULT NULL COMMENT '总量',
  `val` varchar(255) DEFAULT NULL COMMENT '功能',
  `exchange` tinyint(3) unsigned DEFAULT NULL COMMENT '积分兑换',
  `scene` tinyint(4) unsigned DEFAULT NULL COMMENT '场景（1:充值赠送，2:买单赠送）',
  `state` int(11) DEFAULT NULL COMMENT '是否首页显示（2:不显示 1:显示）',
  `showIndex` int(11) NOT NULL DEFAULT '0',
  `selftime` varchar(45) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `build_id` varchar(80) DEFAULT NULL COMMENT '门店id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_distribution
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_distribution`;
CREATE TABLE `ims_ymmf_sun_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_tel` varchar(20) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销申请';

-- ----------------------------
-- Table structure for ims_ymmf_sun_earnings
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_earnings`;
CREATE TABLE `ims_ymmf_sun_earnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `son_id` int(11) NOT NULL COMMENT '下线',
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金收益表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_fx
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_fx`;
CREATE TABLE `ims_ymmf_sun_fx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `zf_user_id` int(11) NOT NULL COMMENT '转发人ID',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `time` int(11) NOT NULL COMMENT '时间戳',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_fxset
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_fxset`;
CREATE TABLE `ims_ymmf_sun_fxset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fx_details` text NOT NULL COMMENT '分销商申请协议',
  `tx_details` text NOT NULL COMMENT '佣金提现协议',
  `is_fx` int(11) NOT NULL COMMENT '1.开启分销审核2.不开启',
  `is_ej` int(11) NOT NULL COMMENT '是否开启二级分销1.是2.否',
  `tx_rate` int(11) NOT NULL COMMENT '提现手续费',
  `commission` varchar(10) NOT NULL COMMENT '一级佣金',
  `commission2` varchar(10) NOT NULL COMMENT '二级佣金',
  `tx_money` int(11) NOT NULL COMMENT '提现门槛',
  `img` varchar(100) NOT NULL COMMENT '分销中心图片',
  `img2` varchar(100) NOT NULL COMMENT '申请分销图片',
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '1' COMMENT '1.开启2关闭',
  `instructions` text NOT NULL COMMENT '分销商说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_fxuser
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_fxuser`;
CREATE TABLE `ims_ymmf_sun_fxuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '一级分销',
  `fx_user` int(11) NOT NULL COMMENT '二级分销',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_gallery
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_gallery`;
CREATE TABLE `ims_ymmf_sun_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `galname` varchar(255) NOT NULL,
  `imgs` text NOT NULL,
  `hair_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_ymmf_sun_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_goods`;
CREATE TABLE `ims_ymmf_sun_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `goods_volume` varchar(45) NOT NULL COMMENT '商家ID',
  `spec_id` int(11) NOT NULL COMMENT '主规格ID',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `goods_num` int(11) NOT NULL COMMENT '商品数量',
  `goods_price` decimal(10,2) NOT NULL,
  `goods_cost` decimal(10,2) NOT NULL,
  `type_id` int(11) NOT NULL,
  `freight` decimal(10,2) NOT NULL COMMENT '运费',
  `delivery` varchar(500) NOT NULL COMMENT '关于发货',
  `quality` int(4) NOT NULL COMMENT '正品1是,0否',
  `free` int(4) NOT NULL COMMENT '包邮1是,0否',
  `all_day` int(4) NOT NULL COMMENT '24小时发货1是,0否',
  `service` int(4) NOT NULL COMMENT '售后服务1是,0否',
  `refund` int(4) NOT NULL COMMENT '极速退款1是,0否',
  `weeks` int(4) NOT NULL COMMENT '7天包邮1是，0否',
  `lb_imgs` varchar(500) NOT NULL COMMENT '轮播图',
  `imgs` varchar(500) NOT NULL COMMENT '商品介绍图',
  `time` int(11) NOT NULL COMMENT '时间',
  `uniacid` varchar(50) NOT NULL,
  `goods_details` text NOT NULL COMMENT '商品详细',
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1待审核,2通过，3拒绝',
  `sy_num` int(11) NOT NULL COMMENT '剩余数量',
  `is_show` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `spec_name` varchar(45) NOT NULL,
  `spec_value` varchar(200) NOT NULL,
  `survey` text NOT NULL,
  `zs_imgs` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_goods_spec
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_goods_spec`;
CREATE TABLE `ims_ymmf_sun_goods_spec` (
  `spec_value` varchar(45) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spec_name` varchar(100) NOT NULL COMMENT '规格名称',
  `sort` int(4) NOT NULL COMMENT '排序',
  `uniacid` varchar(50) NOT NULL COMMENT '50',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_hairers
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_hairers`;
CREATE TABLE `ims_ymmf_sun_hairers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hair_name` varchar(255) NOT NULL,
  `logo` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `num` int(11) DEFAULT NULL,
  `state` int(11) NOT NULL,
  `cate` varchar(120) NOT NULL COMMENT '类别',
  `appoint` int(11) NOT NULL DEFAULT '0' COMMENT '预约数',
  `star` varchar(45) DEFAULT NULL COMMENT '星级',
  `life` varchar(45) DEFAULT NULL COMMENT '年限',
  `praise` varchar(45) DEFAULT NULL COMMENT '好评率',
  `background` text,
  `appmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `account` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `addtime` varchar(20) DEFAULT NULL,
  `yylogo` varchar(200) NOT NULL COMMENT '预约logo',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_ymmf_sun_hblq
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_hblq`;
CREATE TABLE `ims_ymmf_sun_hblq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `tz_id` int(11) NOT NULL COMMENT '帖子ID',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `time` int(11) NOT NULL COMMENT '时间戳',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包领取表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_help
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_help`;
CREATE TABLE `ims_ymmf_sun_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL COMMENT '标题',
  `answer` text NOT NULL COMMENT '回答',
  `sort` int(4) NOT NULL COMMENT '排序',
  `uniacid` varchar(50) NOT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_hotcity
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_hotcity`;
CREATE TABLE `ims_ymmf_sun_hotcity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cityname` varchar(50) NOT NULL COMMENT '城市名称',
  `time` int(11) NOT NULL COMMENT '创建时间',
  `uniacid` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_in
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_in`;
CREATE TABLE `ims_ymmf_sun_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1.一天2.半年3.一年',
  `money` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_information
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_information`;
CREATE TABLE `ims_ymmf_sun_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `details` text NOT NULL COMMENT '内容',
  `img` text NOT NULL COMMENT '图片',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `user_name` varchar(20) NOT NULL COMMENT '联系人',
  `user_tel` varchar(20) NOT NULL COMMENT '电话',
  `hot` int(11) NOT NULL COMMENT '1.热门 2.不热门',
  `top` int(11) NOT NULL COMMENT '1.置顶 2.不置顶',
  `givelike` int(11) NOT NULL COMMENT '点赞数',
  `views` int(11) NOT NULL COMMENT '浏览量',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `type2_id` int(11) NOT NULL COMMENT '分类二id',
  `type_id` int(11) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.待审核 2.通过3拒绝',
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL COMMENT '发布时间',
  `sh_time` int(11) NOT NULL,
  `top_type` int(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `hb_money` decimal(10,2) NOT NULL,
  `hb_num` int(11) NOT NULL,
  `hb_type` int(11) NOT NULL,
  `hb_keyword` varchar(20) NOT NULL,
  `hb_random` int(11) NOT NULL,
  `hong` text NOT NULL,
  `store_id` int(11) NOT NULL,
  `del` int(11) NOT NULL DEFAULT '2',
  `user_img2` varchar(100) NOT NULL,
  `dq_time` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `hbfx_num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_kanjia_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_kanjia_banner`;
CREATE TABLE `ims_ymmf_sun_kanjia_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(45) NOT NULL,
  `lb_imgs` varchar(500) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_kjorder
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_kjorder`;
CREATE TABLE `ims_ymmf_sun_kjorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) DEFAULT NULL,
  `detailInfo` varchar(200) DEFAULT NULL,
  `telNumber` varchar(100) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `time` varchar(150) DEFAULT NULL,
  `openid` varchar(150) DEFAULT NULL,
  `countyName` varchar(150) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `addtime` varchar(100) DEFAULT NULL,
  `cityName` varchar(100) DEFAULT NULL,
  `provinceName` varchar(150) DEFAULT NULL,
  `text` text,
  `hair_id` int(11) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL COMMENT '门店id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `out_trade_no` varchar(255) NOT NULL COMMENT '外部单号',
  `notify_msg` text NOT NULL COMMENT '回调报文',
  `pay_type` int(5) DEFAULT NULL COMMENT '支付方式，1微信，2余额',
  `refund_status` int(5) DEFAULT NULL COMMENT '退款状态，0未退款，1申请退款，2部分退款，3拒绝退款，4失败，5成功',
  `finish_time` varchar(30) NOT NULL COMMENT '完成时间',
  `refund_time` varchar(30) NOT NULL COMMENT '退款时间',
  `refund_no` varchar(50) NOT NULL COMMENT '退款单号',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信交易订单号',
  `gid` int(11) DEFAULT '0' COMMENT '商品id',
  `pay_time` varchar(30) NOT NULL COMMENT '付款时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_kjorderlist
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_kjorderlist`;
CREATE TABLE `ims_ymmf_sun_kjorderlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `openid` varbinary(100) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `createTime` varchar(100) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_label
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_label`;
CREATE TABLE `ims_ymmf_sun_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_name` varchar(20) NOT NULL,
  `type2_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_like
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_like`;
CREATE TABLE `ims_ymmf_sun_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL COMMENT '帖子id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `zx_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_maidan
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_maidan`;
CREATE TABLE `ims_ymmf_sun_maidan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `addtime` varchar(20) DEFAULT NULL,
  `price` varchar(20) DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL,
  `openid` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_ymmf_sun_mercapdetails
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_mercapdetails`;
CREATE TABLE `ims_ymmf_sun_mercapdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL COMMENT '商家id',
  `branchname` varchar(100) NOT NULL COMMENT '商家名称',
  `mcd_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型，1订单收入，2提现，3线下收款（线下收入直接打进商家账号，这里只是一个记录）',
  `mcd_memo` text NOT NULL COMMENT '订单收入等具体信息',
  `addtime` int(11) NOT NULL COMMENT '时间',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现的时候，支付的佣金',
  `uniacid` int(11) NOT NULL COMMENT '11',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态，1成功，2不成功',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `wd_id` int(11) NOT NULL DEFAULT '0' COMMENT '提现id',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `out_trade_no` varchar(255) NOT NULL COMMENT '外部订单号',
  `openid` varchar(255) NOT NULL COMMENT '线下付款人openid',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用',
  `sub_mch_id` varchar(255) NOT NULL COMMENT '子商户号id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=273 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_ymmf_sun_money
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_money`;
CREATE TABLE `ims_ymmf_sun_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `recharge` decimal(50,2) DEFAULT NULL,
  `youhui` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_mylabel
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_mylabel`;
CREATE TABLE `ims_ymmf_sun_mylabel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` int(11) NOT NULL,
  `information_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_nav
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_nav`;
CREATE TABLE `ims_ymmf_sun_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `url_type` int(10) NOT NULL DEFAULT '0' COMMENT '链接类型',
  `url` varchar(255) NOT NULL COMMENT '跳转地址',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(10) NOT NULL DEFAULT '255' COMMENT '排序',
  `position` tinyint(3) DEFAULT '0' COMMENT '位置，1营销导航，2底部导航',
  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示，1显示，0不显示',
  `pic` varchar(255) NOT NULL COMMENT '展示图',
  `un_pic` varchar(255) DEFAULT NULL COMMENT '未选中图',
  `url_id` int(11) DEFAULT NULL COMMENT '参数 id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_new_bargain
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_new_bargain`;
CREATE TABLE `ims_ymmf_sun_new_bargain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(100) DEFAULT NULL,
  `marketprice` decimal(11,2) DEFAULT NULL COMMENT '原价',
  `shopprice` decimal(11,2) DEFAULT NULL,
  `selftime` int(11) DEFAULT NULL COMMENT '时间',
  `pic` varchar(200) DEFAULT NULL COMMENT '图片',
  `content` text,
  `cid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `starttime` timestamp NULL DEFAULT NULL,
  `endtime` timestamp NULL DEFAULT NULL,
  `num` int(11) unsigned DEFAULT NULL,
  `hair_id` varchar(255) DEFAULT NULL COMMENT '技师di',
  `build_id` varchar(255) DEFAULT NULL COMMENT '门店id',
  `hbpic` varchar(200) DEFAULT NULL COMMENT '海报商品图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_news`;
CREATE TABLE `ims_ymmf_sun_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '公告标题',
  `details` text NOT NULL COMMENT '公告详情',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `state` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_order`;
CREATE TABLE `ims_ymmf_sun_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(80) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL COMMENT '金额',
  `user_name` varchar(20) DEFAULT NULL COMMENT '联系人',
  `address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `tel` varchar(20) DEFAULT NULL COMMENT '电话',
  `time` int(11) DEFAULT NULL COMMENT '下单时间',
  `pay_time` datetime DEFAULT NULL,
  `complete_time` int(11) DEFAULT NULL,
  `fh_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `state` int(11) DEFAULT NULL COMMENT '1.待付款 2.待发货3.待确认4.已完成5.退款中6.已退款7.退款拒绝',
  `order_num` varchar(20) DEFAULT NULL COMMENT '订单号',
  `good_id` int(11) DEFAULT NULL,
  `good_name` text,
  `good_img` varchar(100) DEFAULT NULL,
  `good_money` decimal(10,2) DEFAULT NULL,
  `out_trade_no` varchar(50) DEFAULT NULL,
  `good_spec` varchar(200) DEFAULT NULL COMMENT '商品规格',
  `del` int(11) DEFAULT NULL COMMENT '用户删除1是  2否 ',
  `del2` int(11) DEFAULT NULL COMMENT '商家删除1.是2.否',
  `uniacid` int(11) DEFAULT NULL,
  `freight` decimal(10,2) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `good_num` int(11) DEFAULT NULL,
  `appiontime` text COMMENT '预约时间',
  `hair_id` int(11) DEFAULT NULL COMMENT '发型师对应id',
  `remark` text,
  `pname` text COMMENT '选择服务类型',
  `isdefault` int(11) DEFAULT NULL COMMENT '是否完成',
  `addtime` datetime DEFAULT NULL,
  `build_id` int(11) DEFAULT NULL COMMENT '门店id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `notify_msg` text NOT NULL COMMENT '回调报文',
  `pay_type` int(5) DEFAULT NULL COMMENT '支付方式，1微信，2余额',
  `refund_status` int(5) DEFAULT NULL COMMENT '退款状态，0未退款，1申请退款，2部分退款，3拒绝退款，4失败，5成功',
  `finish_time` varchar(30) NOT NULL COMMENT '完成时间',
  `refund_time` varchar(30) NOT NULL COMMENT '退款时间',
  `refund_no` varchar(50) NOT NULL COMMENT '退款单号',
  `ordertype` int(2) DEFAULT NULL COMMENT '订单类型，1服务订单',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信交易订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_orderlost
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_orderlost`;
CREATE TABLE `ims_ymmf_sun_orderlost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  `oid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_paylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_paylog`;
CREATE TABLE `ims_ymmf_sun_paylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL COMMENT '外键id(商家,帖子,黄页,拼车)',
  `money` decimal(10,2) NOT NULL COMMENT '钱',
  `time` datetime NOT NULL COMMENT '时间',
  `uniacid` varchar(50) NOT NULL COMMENT '50',
  `note` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付记录表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_printing
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_printing`;
CREATE TABLE `ims_ymmf_sun_printing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sn` varchar(9) DEFAULT NULL COMMENT '编码',
  `key` varchar(20) DEFAULT NULL COMMENT '生成的ukey',
  `user` varchar(45) DEFAULT NULL COMMENT '登录账号',
  `is_open` int(11) DEFAULT NULL COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_recharges
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_recharges`;
CREATE TABLE `ims_ymmf_sun_recharges` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(120) DEFAULT NULL,
  `r_img` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `r_time` varchar(45) DEFAULT NULL,
  `r_money` int(120) DEFAULT NULL,
  `openid` varchar(80) DEFAULT NULL,
  `details_name` varchar(50) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_ymmf_sun_service
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_service`;
CREATE TABLE `ims_ymmf_sun_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(255) NOT NULL COMMENT '关联的项目name',
  `price` varchar(45) NOT NULL,
  `hair_id` int(11) NOT NULL,
  `hair_name` varchar(255) CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `goods_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_ymmf_sun_share
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_share`;
CREATE TABLE `ims_ymmf_sun_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL COMMENT '帖子id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_sms
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_sms`;
CREATE TABLE `ims_ymmf_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(100) NOT NULL,
  `tpl_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '2',
  `tid1` varchar(50) NOT NULL,
  `tid2` varchar(50) NOT NULL,
  `tid3` varchar(50) NOT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `qitui` text NOT NULL COMMENT '奇推信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_spec_value
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_spec_value`;
CREATE TABLE `ims_ymmf_sun_spec_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `spec_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `num` int(11) NOT NULL COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_store
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_store`;
CREATE TABLE `ims_ymmf_sun_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `store_name` varchar(50) NOT NULL COMMENT '商家名称',
  `address` varchar(200) NOT NULL COMMENT '商家地址',
  `announcement` varchar(100) NOT NULL COMMENT '公告',
  `storetype_id` int(11) NOT NULL COMMENT '主行业分类id',
  `storetype2_id` int(11) NOT NULL COMMENT '商家子分类id',
  `area_id` int(11) NOT NULL COMMENT '区域id',
  `yy_time` varchar(50) NOT NULL COMMENT '营业时间',
  `keyword` varchar(50) NOT NULL COMMENT '关键字',
  `skzf` int(11) NOT NULL COMMENT '1.是 2否(刷卡支付)',
  `wifi` int(11) NOT NULL COMMENT '1.是 2否',
  `mftc` int(11) NOT NULL COMMENT '1.是 2否(免费停车)',
  `jzxy` int(11) NOT NULL COMMENT '1.是 2否(禁止吸烟)',
  `tgbj` int(11) NOT NULL COMMENT '1.是 2否(提供包间)',
  `sfxx` int(11) NOT NULL COMMENT '1.是 2否(沙发休闲)',
  `tel` varchar(20) NOT NULL COMMENT '手机号',
  `logo` varchar(100) NOT NULL,
  `weixin_logo` varchar(100) NOT NULL,
  `ad` text NOT NULL COMMENT '轮播图',
  `state` int(11) NOT NULL COMMENT '1.待审核2通过3拒绝',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `password` varchar(100) NOT NULL COMMENT '核销密码',
  `details` text NOT NULL COMMENT '商家简介',
  `uniacid` int(11) NOT NULL,
  `coordinates` varchar(50) NOT NULL,
  `views` int(11) NOT NULL,
  `score` decimal(10,1) NOT NULL,
  `type` int(11) NOT NULL,
  `sh_time` int(11) NOT NULL,
  `time_over` int(11) NOT NULL,
  `img` text NOT NULL,
  `vr_link` text NOT NULL,
  `num` int(11) NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `wallet` decimal(10,2) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `dq_time` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `fx_num` int(11) NOT NULL,
  `ewm_logo` varchar(100) NOT NULL,
  `is_top` int(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_store_wallet
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_store_wallet`;
CREATE TABLE `ims_ymmf_sun_store_wallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `note` varchar(20) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1加2减',
  `time` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家钱包明细';

-- ----------------------------
-- Table structure for ims_ymmf_sun_storepaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_storepaylog`;
CREATE TABLE `ims_ymmf_sun_storepaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '商家ID',
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家入驻支付记录表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_storetype
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_storetype`;
CREATE TABLE `ims_ymmf_sun_storetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL COMMENT '分类名称',
  `img` varchar(100) NOT NULL COMMENT '分类图片',
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL COMMENT '排序',
  `money` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_storetype2
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_storetype2`;
CREATE TABLE `ims_ymmf_sun_storetype2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `type_id` int(11) NOT NULL COMMENT '主分类id',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_system`;
CREATE TABLE `ims_ymmf_sun_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(100) NOT NULL COMMENT 'appid',
  `appsecret` varchar(200) NOT NULL COMMENT 'appsecret',
  `mchid` varchar(20) NOT NULL COMMENT '商户号',
  `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥',
  `uniacid` varchar(50) NOT NULL,
  `url_name` varchar(20) NOT NULL COMMENT '网址名称',
  `details` text NOT NULL COMMENT '关于我们',
  `url_logo` varchar(100) NOT NULL COMMENT '网址logo',
  `bq_name` varchar(50) NOT NULL COMMENT '版权名称',
  `link_name` varchar(30) NOT NULL COMMENT '网站名称',
  `link_logo` varchar(100) NOT NULL COMMENT '网站logo',
  `support` varchar(20) NOT NULL COMMENT '技术支持',
  `bq_logo` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `tz_appid` varchar(30) NOT NULL,
  `tz_name` varchar(30) NOT NULL,
  `pt_name` varchar(30) NOT NULL COMMENT '平台名称',
  `tz_audit` int(11) NOT NULL COMMENT '帖子审核1.是 2否',
  `sj_audit` int(11) NOT NULL COMMENT '商家审核1.是 2否',
  `mapkey` varchar(200) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `gd_key` varchar(100) NOT NULL,
  `hb_sxf` int(11) NOT NULL,
  `tx_money` decimal(10,2) NOT NULL,
  `tx_sxf` int(11) NOT NULL,
  `tx_details` text NOT NULL,
  `rz_xuz` text NOT NULL,
  `ft_xuz` text NOT NULL,
  `fx_money` decimal(10,2) NOT NULL,
  `is_hhr` int(4) NOT NULL DEFAULT '2',
  `is_hbfl` int(4) NOT NULL DEFAULT '2',
  `is_zx` int(4) NOT NULL DEFAULT '2',
  `is_car` int(4) NOT NULL,
  `pc_xuz` text NOT NULL,
  `pc_money` decimal(10,2) NOT NULL,
  `is_sjrz` int(4) NOT NULL,
  `is_pcfw` int(4) NOT NULL,
  `total_num` int(11) NOT NULL,
  `is_goods` int(4) NOT NULL,
  `apiclient_cert` text NOT NULL,
  `apiclient_key` text NOT NULL,
  `is_openzx` int(4) NOT NULL,
  `is_hyset` int(4) NOT NULL,
  `is_tzopen` int(4) NOT NULL,
  `is_pageopen` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `is_tel` int(4) NOT NULL,
  `tx_mode` int(4) NOT NULL DEFAULT '1',
  `many_city` int(4) NOT NULL DEFAULT '2',
  `tx_type` int(4) NOT NULL DEFAULT '2',
  `is_hbzf` int(4) NOT NULL DEFAULT '1',
  `hb_img` varchar(100) NOT NULL,
  `tz_num` int(11) NOT NULL,
  `client_ip` varchar(30) NOT NULL,
  `hb_content` varchar(100) NOT NULL,
  `appionmoney` decimal(10,2) DEFAULT NULL COMMENT '预约金额',
  `fontcolor` varchar(255) DEFAULT NULL,
  `is_bargainopen` int(2) DEFAULT NULL,
  `bargain_price` varchar(11) DEFAULT NULL,
  `share_title` varchar(45) DEFAULT NULL,
  `js_font` varchar(80) DEFAULT NULL,
  `js_logo` varchar(120) DEFAULT NULL,
  `js_tel` varchar(20) DEFAULT NULL,
  `zhou_font` varchar(120) DEFAULT NULL,
  `guo_font` varchar(120) DEFAULT NULL,
  `chu_font` varchar(120) DEFAULT NULL,
  `qian_font` varchar(120) DEFAULT NULL,
  `zhoubian` varchar(120) DEFAULT NULL,
  `guonei` varchar(120) DEFAULT NULL,
  `chujing` varchar(120) DEFAULT NULL,
  `qianzheng` varchar(120) DEFAULT NULL,
  `user_background` varchar(120) DEFAULT NULL COMMENT '我的页面背景图',
  `survey` text COMMENT '会员说明',
  `vip_open` int(1) DEFAULT NULL COMMENT '是否开启会员',
  `poster_img` varchar(120) DEFAULT NULL COMMENT '海报图片',
  `poster_font` varchar(120) DEFAULT NULL COMMENT '海报文字',
  `qqkey` varchar(50) NOT NULL DEFAULT '0' COMMENT '腾讯地图key',
  `goodspicbg` varchar(100) NOT NULL COMMENT '商品海报背景图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_tab
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_tab`;
CREATE TABLE `ims_ymmf_sun_tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `index` varchar(10) DEFAULT NULL COMMENT '首页文字',
  `indeximg` varchar(200) DEFAULT NULL,
  `indeximgs` varchar(200) DEFAULT NULL COMMENT '首页图标',
  `coupon` varchar(10) DEFAULT NULL COMMENT '优惠券',
  `couponimg` varchar(200) DEFAULT NULL,
  `couponimgs` varchar(200) DEFAULT NULL,
  `fans` varchar(10) DEFAULT NULL,
  `fansimg` varchar(200) DEFAULT NULL,
  `fansimgs` varchar(200) DEFAULT NULL,
  `mine` varchar(10) DEFAULT NULL,
  `mineimg` varchar(200) DEFAULT NULL,
  `mineimgs` varchar(200) DEFAULT NULL,
  `fontcolor` varchar(10) DEFAULT NULL,
  `fontcolored` varchar(10) DEFAULT NULL COMMENT '点击后字体颜色',
  `uniacid` int(11) DEFAULT NULL,
  `find` varchar(255) DEFAULT NULL,
  `findimg` varchar(200) DEFAULT NULL,
  `findimgs` varchar(200) DEFAULT NULL,
  `is_fbopen` int(1) DEFAULT '0' COMMENT '0为关闭发布，1为开启',
  `is_shopen` int(1) DEFAULT '0' COMMENT '0为关闭动态审核,1为开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_top
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_top`;
CREATE TABLE `ims_ymmf_sun_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月',
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_type`;
CREATE TABLE `ims_ymmf_sun_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL COMMENT '分类名称',
  `img` varchar(100) NOT NULL COMMENT '分类图片',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `num` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_type2
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_type2`;
CREATE TABLE `ims_ymmf_sun_type2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '分类名称',
  `type_id` int(11) NOT NULL COMMENT '主分类id',
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_tzpaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_tzpaylog`;
CREATE TABLE `ims_ymmf_sun_tzpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tz_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='帖子支付记录表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_user`;
CREATE TABLE `ims_ymmf_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL COMMENT 'openid',
  `img` varchar(200) NOT NULL COMMENT '头像',
  `time` varchar(20) NOT NULL COMMENT '注册时间',
  `name` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `user_name` varchar(20) DEFAULT NULL,
  `user_tel` varchar(20) DEFAULT NULL,
  `user_address` varchar(200) DEFAULT NULL,
  `commission` decimal(10,2) DEFAULT NULL,
  `state` int(4) DEFAULT '1',
  `telphone` varchar(20) NOT NULL COMMENT '手机号码',
  `parents_id` int(11) NOT NULL COMMENT '上级id',
  `parents_name` varchar(255) NOT NULL COMMENT '上级名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_user_bargain
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_user_bargain`;
CREATE TABLE `ims_ymmf_sun_user_bargain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `mch_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `price` decimal(10,2) unsigned DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `kanjia` decimal(10,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_user_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_user_coupon`;
CREATE TABLE `ims_ymmf_sun_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `counp_id` int(11) NOT NULL,
  `addtime` varchar(45) NOT NULL,
  `uid` varchar(80) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_ymmf_sun_userformid
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_userformid`;
CREATE TABLE `ims_ymmf_sun_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='formid表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_uservip
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_uservip`;
CREATE TABLE `ims_ymmf_sun_uservip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `vip_id` int(11) DEFAULT NULL COMMENT '会员id',
  `openid` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_vip_ka
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_vip_ka`;
CREATE TABLE `ims_ymmf_sun_vip_ka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vip_name` varchar(120) DEFAULT NULL COMMENT '会员卡名称',
  `discount` decimal(10,2) DEFAULT NULL COMMENT '折扣',
  `consumption` int(11) DEFAULT NULL COMMENT '消费金额',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_visitor
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_visitor`;
CREATE TABLE `ims_ymmf_sun_visitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_winindex
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_winindex`;
CREATE TABLE `ims_ymmf_sun_winindex` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL,
  `path1` varchar(45) DEFAULT NULL,
  `path2` varchar(45) DEFAULT NULL,
  `path3` varchar(45) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `is_open` int(1) NOT NULL DEFAULT '0' COMMENT '0为关闭，1为开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_withdraw`;
CREATE TABLE `ims_ymmf_sun_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL COMMENT '提现用户oppenid',
  `money` decimal(10,2) NOT NULL COMMENT '提现金额',
  `wd_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '提现方式，1微信，2支付宝，3银行账号',
  `wd_account` varchar(100) NOT NULL COMMENT '提现账号',
  `wd_name` varchar(50) NOT NULL COMMENT '提现名字',
  `wd_phone` varchar(50) NOT NULL COMMENT '提现联系方式',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0审核中，1通过审核，2拒绝提现，3自动打款',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '需要支付佣金',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `branchname` varchar(100) NOT NULL COMMENT '提现商家名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_ymmf_sun_withdrawal
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_withdrawal`;
CREATE TABLE `ims_ymmf_sun_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL COMMENT '真实姓名',
  `username` varchar(100) NOT NULL COMMENT '账号',
  `type` int(11) NOT NULL COMMENT '1支付宝 2.微信 3.银行',
  `time` int(11) NOT NULL COMMENT '申请时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `state` int(11) NOT NULL COMMENT '1.待审核 2.通过  3.拒绝',
  `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额',
  `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `uniacid` int(11) NOT NULL,
  `method` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_withdrawset
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_withdrawset`;
CREATE TABLE `ims_ymmf_sun_withdrawset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wd_type` varchar(50) NOT NULL DEFAULT '1' COMMENT '（1,2,3）提现方式，1微信支付，2支付宝，3银行打款',
  `min_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额',
  `avoidmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额，可直接提现金额',
  `wd_content` text NOT NULL COMMENT '提现须知',
  `cms_rates` float NOT NULL DEFAULT '0' COMMENT '平台佣金比率',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '提现开关，2关，1开',
  `wd_wxrates` float NOT NULL DEFAULT '0' COMMENT '微信提现手续费',
  `wd_alipayrates` float NOT NULL DEFAULT '0' COMMENT '支付宝提现手续费',
  `wd_bankrates` float NOT NULL DEFAULT '0' COMMENT '银行卡提现手续费',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_ymmf_sun_yellowpaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_yellowpaylog`;
CREATE TABLE `ims_ymmf_sun_yellowpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hy_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='黄页支付记录表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_yellowset
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_yellowset`;
CREATE TABLE `ims_ymmf_sun_yellowset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL COMMENT '入住天数',
  `money` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='黄页设置表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_yellowstore
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_yellowstore`;
CREATE TABLE `ims_ymmf_sun_yellowstore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `logo` varchar(200) NOT NULL COMMENT 'logo图片',
  `company_name` varchar(100) NOT NULL COMMENT '公司名称',
  `company_address` varchar(200) NOT NULL COMMENT '公司地址',
  `type_id` int(11) NOT NULL COMMENT '二级分类',
  `link_tel` varchar(20) NOT NULL COMMENT '联系电话',
  `sort` int(11) NOT NULL COMMENT '排序',
  `rz_time` int(11) NOT NULL COMMENT '入住时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `state` int(4) NOT NULL COMMENT '1待,2通过,3拒绝',
  `rz_type` int(4) NOT NULL COMMENT '入驻类型',
  `time_over` int(4) NOT NULL COMMENT '1到期,2没到期',
  `uniacid` varchar(50) NOT NULL,
  `coordinates` varchar(50) NOT NULL COMMENT '坐标',
  `content` text NOT NULL COMMENT '简介',
  `imgs` varchar(500) NOT NULL COMMENT '多图',
  `views` int(11) NOT NULL,
  `tel2` varchar(20) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `dq_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_yjset
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_yjset`;
CREATE TABLE `ims_ymmf_sun_yjset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(4) NOT NULL DEFAULT '1' COMMENT '1统一模式,2分开模式',
  `typer` varchar(10) NOT NULL COMMENT '统一比例',
  `sjper` varchar(10) NOT NULL COMMENT '商家比例',
  `hyper` varchar(10) NOT NULL COMMENT '黄页比例',
  `pcper` varchar(10) NOT NULL COMMENT '拼车比例',
  `tzper` varchar(10) NOT NULL COMMENT '帖子比例',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金比例表';

-- ----------------------------
-- Table structure for ims_ymmf_sun_yjtx
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_yjtx`;
CREATE TABLE `ims_ymmf_sun_yjtx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL COMMENT '账号id',
  `tx_type` int(4) NOT NULL COMMENT '提现方式 1,支付宝,2微信,3银联',
  `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额',
  `status` int(4) NOT NULL COMMENT '状态 1申请,2通过,3拒绝',
  `uniacid` varchar(50) NOT NULL,
  `cerated_time` datetime NOT NULL COMMENT '日期',
  `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额',
  `account` varchar(30) NOT NULL COMMENT '账户',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `sx_cost` decimal(10,2) NOT NULL COMMENT '手续费',
  `time` datetime NOT NULL COMMENT '审核时间',
  `is_del` int(4) NOT NULL DEFAULT '1' COMMENT '1正常,2删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_zx
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_zx`;
CREATE TABLE `ims_ymmf_sun_zx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT '分类ID',
  `user_id` int(11) NOT NULL COMMENT '发布人ID',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `time` datetime NOT NULL,
  `yd_num` int(11) NOT NULL COMMENT '阅读数量',
  `pl_num` int(11) NOT NULL COMMENT '评论数量',
  `uniacid` varchar(50) NOT NULL,
  `imgs` text NOT NULL COMMENT '图片',
  `state` int(4) NOT NULL,
  `sh_time` datetime NOT NULL,
  `type` int(4) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_zx_assess
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_zx_assess`;
CREATE TABLE `ims_ymmf_sun_zx_assess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zx_id` int(4) NOT NULL,
  `score` int(11) NOT NULL,
  `content` text NOT NULL,
  `img` varchar(500) NOT NULL,
  `cerated_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `status` int(4) NOT NULL,
  `reply` text NOT NULL,
  `reply_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_zx_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_zx_type`;
CREATE TABLE `ims_ymmf_sun_zx_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL COMMENT '分类名称',
  `icon` varchar(100) NOT NULL COMMENT '图标',
  `sort` int(4) NOT NULL COMMENT '排序',
  `time` datetime NOT NULL COMMENT '时间',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_ymmf_sun_zx_zj
-- ----------------------------
DROP TABLE IF EXISTS `ims_ymmf_sun_zx_zj`;
CREATE TABLE `ims_ymmf_sun_zx_zj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zx_id` int(11) NOT NULL COMMENT '资讯ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `uniacid` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资讯足迹';
