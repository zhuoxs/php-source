/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-07-18 13:12:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_yzzc_sun_active
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_active`;
CREATE TABLE `ims_yzzc_sun_active` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id',
  `pic` varchar(110) NOT NULL COMMENT '活动图片',
  `title` varchar(50) CHARACTER SET utf8mb4 NOT NULL COMMENT '活动标题',
  `content` text CHARACTER SET utf8mb4 NOT NULL COMMENT '活动内容',
  `acttime` varchar(120) NOT NULL COMMENT '活动时间',
  `createtime` varchar(120) NOT NULL COMMENT '发布时间',
  `details` text CHARACTER SET utf8mb4 NOT NULL,
  `uniacid` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1.显示 2.下架',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzzc_sun_addnews
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_addnews`;
CREATE TABLE `ims_yzzc_sun_addnews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) NOT NULL COMMENT '标题，展示用',
  `left` int(10) unsigned NOT NULL,
  `state` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1显示，2为关闭',
  `uniacid` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '类型',
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzzc_sun_adpic
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_adpic`;
CREATE TABLE `ims_yzzc_sun_adpic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_type` tinyint(1) DEFAULT '0' COMMENT '0.不跳转1.车型2门店3活动',
  `link_typeid` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `ad_pic` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `title` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='首页弹窗广告';

-- ----------------------------
-- Table structure for ims_yzzc_sun_allrule
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_allrule`;
CREATE TABLE `ims_yzzc_sun_allrule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8mb4 NOT NULL COMMENT '使用规则',
  `selftime` datetime DEFAULT NULL COMMENT '存入时间',
  `uniacid` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT '0' COMMENT '1.租车券2.会员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_banner`;
CREATE TABLE `ims_yzzc_sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(100) DEFAULT NULL COMMENT '轮播名称',
  `url` varchar(300) DEFAULT NULL COMMENT '轮播链接',
  `lb_imgs` varchar(500) DEFAULT NULL COMMENT '首页轮播图片',
  `uniacid` int(11) NOT NULL,
  `new_banner` varchar(200) DEFAULT NULL COMMENT '新手指导',
  `rules_banner` varchar(200) DEFAULT NULL COMMENT '服务规则轮播图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='首页轮播表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_branch
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_branch`;
CREATE TABLE `ims_yzzc_sun_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '店铺名称',
  `uniacid` int(11) NOT NULL,
  `province` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `lng` varchar(50) DEFAULT NULL COMMENT '经度',
  `lat` varchar(50) DEFAULT NULL COMMENT '纬度',
  `ranges` int(5) DEFAULT '0' COMMENT '送车上门范围 0.不送车上门 ',
  `business_hours` varchar(50) DEFAULT NULL COMMENT '营业时间',
  `service_tel` varchar(20) DEFAULT NULL COMMENT '服务热线',
  `shop_tel` varchar(20) DEFAULT NULL COMMENT '门店电话',
  `createtime` varchar(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT '1' COMMENT '1.显示',
  `pic` varchar(500) DEFAULT NULL COMMENT '门店照片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='门店表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_branch_admin
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_branch_admin`;
CREATE TABLE `ims_yzzc_sun_branch_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `auth` tinyint(1) DEFAULT '1' COMMENT '1.超级管理员 2.核销员',
  `uniacid` int(11) DEFAULT NULL,
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='门店管理员表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_car
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_car`;
CREATE TABLE `ims_yzzc_sun_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT '门店id',
  `mileage` int(11) NOT NULL COMMENT '里程',
  `name` varchar(50) NOT NULL COMMENT '车辆名称',
  `cartype` varchar(50) NOT NULL COMMENT '车辆类型，如轿车、SUV等等',
  `carnum` varchar(20) DEFAULT NULL COMMENT '车牌号',
  `color` varchar(10) NOT NULL COMMENT '颜色',
  `structure` int(1) DEFAULT '1' COMMENT '车身结构 1.两厢 2.三厢',
  `grarbox` int(1) NOT NULL DEFAULT '1' COMMENT '变速箱1.手动2.自动',
  `displacement` varchar(10) DEFAULT NULL COMMENT '汽车排量',
  `num` int(2) NOT NULL COMMENT '过户次数',
  `pic` varchar(200) NOT NULL COMMENT '封面图',
  `imgs` text NOT NULL COMMENT '轮播图',
  `phone` varchar(20) NOT NULL COMMENT '预约电话',
  `content` text NOT NULL COMMENT '车辆简介',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '首付',
  `monthmoney` decimal(10,2) DEFAULT '0.00' COMMENT '月供',
  `guidemoney` decimal(10,2) DEFAULT '0.00' COMMENT '官方指导价',
  `carbrand` int(11) DEFAULT NULL COMMENT '汽车品牌',
  `carcity` int(11) DEFAULT NULL COMMENT '所在城市',
  `rec` tinyint(1) DEFAULT '1' COMMENT '是否推荐到首页 1.推荐 2.不推荐',
  `createtime` varchar(50) DEFAULT NULL,
  `registrationtime` varchar(50) DEFAULT NULL COMMENT '上牌时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '1.待审核 2.已审核',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1已删除',
  `sort` int(11) DEFAULT '255',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='二手车表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_carbrand
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_carbrand`;
CREATE TABLE `ims_yzzc_sun_carbrand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `zimu` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '首字母',
  `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '品牌名称',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Table structure for ims_yzzc_sun_carcity
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_carcity`;
CREATE TABLE `ims_yzzc_sun_carcity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `zimu` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '首字母',
  `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '城市名称',
  `rec` tinyint(2) DEFAULT '2' COMMENT '1热门',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Table structure for ims_yzzc_sun_cartype
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_cartype`;
CREATE TABLE `ims_yzzc_sun_cartype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '分类名称',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Table structure for ims_yzzc_sun_city
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_city`;
CREATE TABLE `ims_yzzc_sun_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) DEFAULT NULL,
  `name` varchar(15) DEFAULT NULL,
  `fullname` varchar(20) DEFAULT NULL,
  `pinyin` varchar(25) DEFAULT NULL,
  `lat` varchar(30) DEFAULT NULL,
  `lng` varchar(30) DEFAULT NULL,
  `pcode` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ims_yzzc_sun_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_coupon`;
CREATE TABLE `ims_yzzc_sun_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) NOT NULL COMMENT '优惠券名称，展示用',
  `type` tinyint(1) unsigned DEFAULT '1' COMMENT '1.租车券 2.优惠券',
  `start_time` varchar(11) DEFAULT NULL COMMENT '活动开始时间',
  `end_time` varchar(11) DEFAULT NULL COMMENT '活动结束时间',
  `total` int(10) unsigned DEFAULT '0' COMMENT '总量 0.不限量发放',
  `getnum` int(11) DEFAULT '0' COMMENT '已领数量',
  `score` int(11) unsigned DEFAULT NULL COMMENT '积分兑换',
  `status` tinyint(4) DEFAULT '1' COMMENT '是否首页显示（0:不显示 1:显示）',
  `uniacid` int(11) DEFAULT NULL,
  `full` int(11) DEFAULT NULL COMMENT '满多少',
  `money` int(11) DEFAULT '0' COMMENT '金额',
  `limit` tinyint(1) DEFAULT '1' COMMENT '领取限制：1不限 2.转发',
  `createtime` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzzc_sun_coupon_get
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_coupon_get`;
CREATE TABLE `ims_yzzc_sun_coupon_get` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `isuse` tinyint(1) DEFAULT '0' COMMENT '0.未使用 1.已使用',
  `usetime` varchar(11) COLLATE utf8mb4_bin DEFAULT '0' COMMENT '使用时间',
  `uniacid` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT '1' COMMENT '1.租车券2.优惠券',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='优惠券领取记录表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_goods`;
CREATE TABLE `ims_yzzc_sun_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT '门店id',
  `name` varchar(50) NOT NULL COMMENT '车辆名称',
  `carnum` varchar(20) DEFAULT NULL COMMENT '车牌号',
  `colour` varchar(10) NOT NULL COMMENT '颜色',
  `structure` int(1) DEFAULT '1' COMMENT '车身结构 1.两厢 2.三厢',
  `grarbox` int(1) NOT NULL DEFAULT '1' COMMENT '变速箱1.手动2.自动',
  `displacement` varchar(10) DEFAULT NULL COMMENT '汽车排量',
  `num` int(2) NOT NULL COMMENT '核载人数',
  `pic` varchar(200) NOT NULL COMMENT '封面图',
  `content` text NOT NULL COMMENT '车辆简介',
  `moneytype` tinyint(1) DEFAULT '1' COMMENT '租金类型 1.日租2周租3月租4年租',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '租金',
  `cartype` int(11) DEFAULT NULL COMMENT '汽车类型',
  `fee` decimal(10,2) DEFAULT '0.00' COMMENT '手续费',
  `service_fee` decimal(10,2) DEFAULT '0.00' COMMENT '服务费',
  `zx_service_fee` decimal(10,2) DEFAULT '0.00' COMMENT '尊享服务费',
  `rec` tinyint(1) DEFAULT '1' COMMENT '是否推荐到首页 1.推荐 2.不推荐',
  `hot` tinyint(1) DEFAULT '1' COMMENT '1.热门',
  `createtime` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1.空闲 2.已租 3.下架',
  `act_money` decimal(10,2) DEFAULT '0.00' COMMENT '活动价格',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1已删除',
  `subscribe_duration` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COMMENT='车型表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_integral_log
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_integral_log`;
CREATE TABLE `ims_yzzc_sun_integral_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `type` int(1) DEFAULT '1' COMMENT '1.签到 2.兑换租车券3.消费得积分4.租车抵现',
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='积分明细表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_integralset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_integralset`;
CREATE TABLE `ims_yzzc_sun_integralset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sign` int(11) DEFAULT '0' COMMENT '签到得积分',
  `full` int(11) DEFAULT '0' COMMENT '消费满多少钱',
  `cost_score` int(11) DEFAULT '0' COMMENT '消费满多少钱得到积分',
  `use_money` int(11) DEFAULT '0' COMMENT '抵多少现金',
  `use_score` int(11) DEFAULT '0' COMMENT '多少积分可以抵多少钱',
  `uniacid` int(11) DEFAULT NULL,
  `selftime` varchar(20) DEFAULT NULL,
  `rule` text COMMENT '积分规则',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分设置表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_level
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_level`;
CREATE TABLE `ims_yzzc_sun_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(10) DEFAULT '0' COMMENT '签到得积分',
  `level_img` varchar(200) DEFAULT '0' COMMENT '消费满多少钱',
  `level_score` int(11) DEFAULT '0' COMMENT '会员积分',
  `level_privileges` tinyint(1) DEFAULT '1' COMMENT '1无特权2免收服务费3延长还车',
  `delay` int(20) DEFAULT '0' COMMENT '延长还车时间',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='会员等级设置表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_logoset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_logoset`;
CREATE TABLE `ims_yzzc_sun_logoset` (
  `uniacid` int(11) NOT NULL,
  `logo_name_one` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_name_one` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_img_one` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_one` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_a` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '选中图标',
  `logo_name_two` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_name_two` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_img_two` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_two` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_b` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_name_three` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_name_three` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_img_three` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_three` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_c` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_name_four` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_name_four` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_img_four` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_four` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_d` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `doorname` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `doorlottery` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `shopname` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `shoplottery` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='营销功能图标设置表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_member
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_member`;
CREATE TABLE `ims_yzzc_sun_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member` varchar(20) NOT NULL COMMENT '会员等级',
  `integral` int(11) NOT NULL COMMENT '会员等级积分',
  `states` int(1) NOT NULL DEFAULT '1' COMMENT '状态 1.待审核 2.已通过 3.已拒绝',
  `uniacid` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=REDUNDANT;

-- ----------------------------
-- Table structure for ims_yzzc_sun_msg_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_msg_set`;
CREATE TABLE `ims_yzzc_sun_msg_set` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `open` tinyint(1) DEFAULT '1' COMMENT '1开启 0关闭',
  `type` tinyint(1) DEFAULT '1' COMMENT '1.253 2.大鱼',
  `api_account` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `api_psw` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `buy_template` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '购买成功模板',
  `uniacid` int(11) DEFAULT NULL,
  `dayu_signname` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '大鱼-短信签名',
  `dayu_templatecode` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '大鱼-模板id',
  `dayu_accesskey` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  `dayu_accesskeysecret` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='短信配置表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_new
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_new`;
CREATE TABLE `ims_yzzc_sun_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` varchar(120) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL COMMENT '标题1',
  `content` text COMMENT '内容1',
  `selftime` datetime DEFAULT NULL COMMENT '存入时间',
  `uniacid` int(11) DEFAULT NULL,
  `sort` tinyint(1) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='新手指导表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_order`;
CREATE TABLE `ims_yzzc_sun_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL COMMENT '车辆id',
  `gettype` tinyint(1) DEFAULT '1' COMMENT '1门店自取2.送车上门',
  `type` tinyint(1) DEFAULT '1' COMMENT '1.短租订单 2.长租订单',
  `typeid` int(11) DEFAULT '0' COMMENT '长租订单的类型id',
  `start_time` varchar(11) DEFAULT NULL COMMENT '取车时间',
  `end_time` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '还车时间',
  `start_shop` int(11) DEFAULT NULL COMMENT '取车门店id',
  `end_shop` int(11) DEFAULT NULL COMMENT '还车门店id',
  `day` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `createtime` varchar(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1待支付 2.已支付 3.已取车4.已取消',
  `membertype` tinyint(1) DEFAULT '1' COMMENT '会员类型 1.无特权 2.免服务费 3.延迟还车',
  `delay` int(3) DEFAULT '0' COMMENT '延迟还车',
  `integral_money` varchar(10) DEFAULT '0' COMMENT '积分抵现',
  `integral` int(10) DEFAULT '0' COMMENT '使用积分',
  `money` decimal(10,2) DEFAULT NULL COMMENT '单价',
  `total_money` decimal(10,2) DEFAULT NULL COMMENT '总价',
  `prepay_money` decimal(10,2) DEFAULT '0.00' COMMENT '预付金额',
  `fee` decimal(10,2) DEFAULT '0.00' COMMENT '手续费',
  `service_fee` decimal(10,2) DEFAULT '0.00' COMMENT '服务费',
  `zx_service_fee` decimal(10,2) DEFAULT '0.00' COMMENT '尊享服务费',
  `open_zx_service` tinyint(1) DEFAULT '0' COMMENT '0.不使用 1.使用尊享服务',
  `coupon_money` decimal(10,2) DEFAULT '0.00' COMMENT '券金额',
  `coupon` int(11) DEFAULT '0' COMMENT '券id',
  `ispay` tinyint(1) DEFAULT '0',
  `paytime` varchar(11) CHARACTER SET utf8 DEFAULT '0' COMMENT '支付时间',
  `isuse` tinyint(1) DEFAULT '0',
  `usetime` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `out_trade_no` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
  `transid` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
  `ordernum` varchar(35) DEFAULT NULL COMMENT '订单编号',
  `username` varchar(10) DEFAULT NULL COMMENT '取车姓名',
  `tel` varchar(20) DEFAULT NULL COMMENT '取车电话',
  `prepay_id` varchar(200) DEFAULT NULL COMMENT '支付成功后的prepay_id',
  `active` tinyint(1) DEFAULT '0' COMMENT '1.活动',
  `display` int(1) DEFAULT '1' COMMENT '0.删除订单',
  `return_time` varchar(11) DEFAULT NULL COMMENT '还车时间',
  `carnum` varchar(20) DEFAULT NULL COMMENT '车牌号',
  `istui` tinyint(1) DEFAULT '0',
  `out_refund_no` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COMMENT='租车订单表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_order_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_order_set`;
CREATE TABLE `ims_yzzc_sun_order_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `know` text COMMENT '取车须知',
  `rule` text COMMENT '订单说明',
  `long_prepay` varchar(11) DEFAULT '0' COMMENT '长租订单预付金额 0.全款',
  `short_prepay` varchar(11) DEFAULT '0' COMMENT '短租订单预付金额',
  `service_desc` text COMMENT '基础服务费说明',
  `zx_service_desc` text COMMENT '尊享服务费说明',
  `getcar_desc` text COMMENT '取车证件说明',
  `tuimoney` int(11) DEFAULT '50',
  `istui` int(11) DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ims_yzzc_sun_ordertime
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_ordertime`;
CREATE TABLE `ims_yzzc_sun_ordertime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `carnum` varchar(20) DEFAULT NULL COMMENT '车牌号',
  `start_time` varchar(11) DEFAULT NULL COMMENT '取车时间',
  `end_time` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '还车时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '0.已完成1待支付 2.已支付 3.已取车4.已取消',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ims_yzzc_sun_rule
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_rule`;
CREATE TABLE `ims_yzzc_sun_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` varchar(110) CHARACTER SET utf8 DEFAULT NULL COMMENT '服务规则图片',
  `title` varchar(30) DEFAULT NULL COMMENT '规则名称',
  `content` text COMMENT '规则详情',
  `sort` int(1) DEFAULT '0' COMMENT '排序',
  `selftime` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='服务规则表';

-- ----------------------------
-- Table structure for ims_yzzc_sun_signlog
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_signlog`;
CREATE TABLE `ims_yzzc_sun_signlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT '0' COMMENT '签到得积分',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Table structure for ims_yzzc_sun_specprice
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_specprice`;
CREATE TABLE `ims_yzzc_sun_specprice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id',
  `spec` varchar(100) NOT NULL COMMENT '活动时间',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '活动价格',
  `uniacid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzzc_sun_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_system`;
CREATE TABLE `ims_yzzc_sun_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `appid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appid',
  `appsecret` varchar(200) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appsecret',
  `mchid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户号',
  `wxkey` varchar(250) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户秘钥',
  `uniacid` int(11) DEFAULT NULL,
  `color` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '颜色',
  `address` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sup_logo` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '技术支持logo',
  `sup_name` varchar(50) DEFAULT NULL COMMENT '技术支持名称',
  `sup_tel` varchar(20) DEFAULT NULL COMMENT '技术支持电话',
  `ad_pic` tinyint(1) DEFAULT '1' COMMENT '1.开启首页弹窗广告图0.关闭',
  `client_ip` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `apiclient_key` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `apiclient_cert` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `fontcolor` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `token` varchar(300) DEFAULT NULL,
  `token_expires_in` int(11) DEFAULT NULL COMMENT 'token的过期时间',
  `order_template_id` varchar(300) DEFAULT NULL COMMENT '预约成功模板id',
  `top_font_color` varchar(50) DEFAULT '#000000' COMMENT '顶部字体颜色',
  `top_color` varchar(50) DEFAULT '#fff' COMMENT '顶部风格颜色',
  `foot_font_color_one` varchar(50) DEFAULT '#333' COMMENT '底部文字选中前',
  `foot_color` varchar(50) DEFAULT '#fff' COMMENT '底部风格颜色',
  `foot_font_color_two` varchar(50) DEFAULT '#ffb62b' COMMENT '底部文字选中后',
  `ht_title` varchar(100) DEFAULT NULL,
  `ht_logo` varchar(200) DEFAULT NULL,
  `open_fj` tinyint(1) DEFAULT '1' COMMENT '1.开启附近门店 0.关闭',
  `index_haibao_pic` varchar(200) DEFAULT NULL COMMENT '首页生成海报广告图',
  `map_key` varchar(200) DEFAULT NULL,
  `open_ys` tinyint(1) DEFAULT '1' COMMENT '样式切换',
  `is_open_car` tinyint(1) DEFAULT '0' COMMENT '二手车开关',
  `findtime` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ims_yzzc_sun_taocan
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_taocan`;
CREATE TABLE `ims_yzzc_sun_taocan` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id',
  `type` tinyint(1) NOT NULL COMMENT '1.工作日2.周末3.周租4.月租5.年租',
  `day` int(5) NOT NULL COMMENT '天数',
  `money` varchar(10) CHARACTER SET utf8mb4 NOT NULL COMMENT '省多少钱',
  `createtime` varchar(11) NOT NULL COMMENT '发布时间',
  `uniacid` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1.显示 2.下架',
  `name` varchar(30) DEFAULT NULL COMMENT '套餐名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzzc_sun_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_user`;
CREATE TABLE `ims_yzzc_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `openid` varchar(100) DEFAULT NULL COMMENT 'openid',
  `headimg` varchar(200) DEFAULT NULL COMMENT '头像',
  `time` varchar(50) DEFAULT NULL COMMENT '创建时间',
  `uniacid` int(11) DEFAULT NULL,
  `user_name` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `user_tel` int(11) DEFAULT NULL,
  `user_address` varchar(200) DEFAULT NULL,
  `all_integral` int(11) DEFAULT '0' COMMENT '总积分',
  `now_integral` int(11) DEFAULT '0' COMMENT '现有积分',
  `isadmin` tinyint(1) DEFAULT '0' COMMENT '1.管理员',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzzc_sun_usercity
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_usercity`;
CREATE TABLE `ims_yzzc_sun_usercity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `time` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Table structure for ims_yzzc_sun_we
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzzc_sun_we`;
CREATE TABLE `ims_yzzc_sun_we` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关于我们id',
  `pic` varchar(120) DEFAULT NULL COMMENT '图片',
  `name` varchar(100) NOT NULL COMMENT '第一个标题',
  `content` text NOT NULL COMMENT '第一个内容',
  `tel` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) NOT NULL DEFAULT '',
  `selftime` datetime DEFAULT NULL COMMENT '存入时间',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='关于我们';
