/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-09 13:12:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_mzhk_sun_acbanner
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_acbanner`;
CREATE TABLE `ims_mzhk_sun_acbanner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lb_imgs` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `lb_imgs1` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `lb_imgs2` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `lb_imgs3` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `bname` varchar(110) CHARACTER SET utf8 DEFAULT NULL,
  `bname1` varchar(110) CHARACTER SET utf8 DEFAULT NULL,
  `bname2` varchar(110) CHARACTER SET utf8 DEFAULT NULL,
  `bname3` varchar(110) CHARACTER SET utf8 DEFAULT NULL,
  `lb_imgs4` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '免单banner图',
  `bname4` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '免单banner名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_mzhk_sun_acode
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_acode`;
CREATE TABLE `ims_mzhk_sun_acode` (
  `id` int(11) NOT NULL COMMENT '该id不自动增加',
  `time` varchar(30) NOT NULL COMMENT '时间',
  `code` text NOT NULL COMMENT '码',
  `url` varchar(255) NOT NULL,
  `uncode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_active
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_active`;
CREATE TABLE `ims_mzhk_sun_active` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id',
  `subtitle` varchar(45) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `createtime` int(13) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `content` text NOT NULL COMMENT '文章内容',
  `sort` int(10) DEFAULT '0',
  `antime` timestamp NULL DEFAULT NULL,
  `hits` int(10) DEFAULT '0',
  `status` tinyint(10) DEFAULT '0' COMMENT '0审核中1审核通过',
  `astime` timestamp NULL DEFAULT NULL,
  `thumb` varchar(200) DEFAULT NULL,
  `num` int(10) DEFAULT '0',
  `sharenum` int(11) DEFAULT NULL COMMENT '每天可分享次数',
  `thumb_url` text,
  `part_num` varchar(15) DEFAULT '0' COMMENT '参与人数',
  `share_plus` varchar(15) DEFAULT '1' COMMENT '分享之后可得的次数',
  `new_partnum` varchar(15) DEFAULT NULL COMMENT '初始虚拟参与人数',
  `user_id` varchar(100) DEFAULT NULL COMMENT '用户ID',
  `storeinfo` varchar(200) DEFAULT NULL COMMENT '店铺信息',
  `showindex` int(11) DEFAULT NULL COMMENT '0不显示1显示',
  `active_num` int(11) DEFAULT NULL COMMENT '活动商品数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_area
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_area`;
CREATE TABLE `ims_mzhk_sun_area` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sort` int(10) NOT NULL COMMENT '排序',
  `name` varchar(50) NOT NULL COMMENT '商圈名称',
  `status` tinyint(10) NOT NULL DEFAULT '0' COMMENT '显示状态 0 不显示 1 显示',
  `time` varchar(100) NOT NULL COMMENT '添加时间',
  `uniacid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_banner`;
CREATE TABLE `ims_mzhk_sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(200) CHARACTER SET utf8 NOT NULL,
  `url` varchar(300) CHARACTER SET utf8 NOT NULL COMMENT 'banner名字',
  `lb_imgs` varchar(500) CHARACTER SET utf8 NOT NULL COMMENT 'banner图片',
  `uniacid` int(11) NOT NULL,
  `bname1` varchar(200) CHARACTER SET utf8 NOT NULL,
  `bname2` varchar(200) CHARACTER SET utf8 NOT NULL,
  `bname3` varchar(200) CHARACTER SET utf8 NOT NULL,
  `lb_imgs1` varchar(500) CHARACTER SET utf8 NOT NULL,
  `lb_imgs2` varchar(500) CHARACTER SET utf8 NOT NULL,
  `lb_imgs3` varchar(500) CHARACTER SET utf8 NOT NULL,
  `url1` varchar(300) CHARACTER SET utf8 NOT NULL,
  `url2` varchar(300) CHARACTER SET utf8 NOT NULL,
  `url3` varchar(300) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_mzhk_sun_benefit
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_benefit`;
CREATE TABLE `ims_mzhk_sun_benefit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `benefit_name` varchar(50) NOT NULL COMMENT '权益名称',
  `benefit_img` varchar(100) NOT NULL COMMENT '权益图标',
  `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态 0 隐藏 1 显示',
  `addtime` varchar(100) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_brand
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_brand`;
CREATE TABLE `ims_mzhk_sun_brand` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(120) NOT NULL COMMENT '品牌名称',
  `logo` text NOT NULL,
  `content` text COMMENT '品牌描述',
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL COMMENT '电话',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `img` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `feature` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `deliveryfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费',
  `deliverytime` varchar(20) NOT NULL COMMENT '配送时间',
  `deliveryaway` float NOT NULL DEFAULT '0' COMMENT '配送距离',
  `in_openid` varchar(255) NOT NULL COMMENT '入驻时提交信息的微信openid',
  `bind_openid` varchar(255) DEFAULT NULL COMMENT '绑定的openid',
  `loginname` varchar(50) DEFAULT NULL COMMENT '登陆名',
  `loginpassword` varchar(50) DEFAULT NULL COMMENT '登陆密码',
  `uname` varchar(50) NOT NULL COMMENT '联系人',
  `starttime` varchar(30) DEFAULT NULL COMMENT '营业时间，开始',
  `endtime` varchar(30) DEFAULT NULL COMMENT '营业时间，结束',
  `coordinates` varchar(50) DEFAULT NULL COMMENT '经纬度',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `lt_id` int(11) NOT NULL DEFAULT '0' COMMENT '入驻周期id',
  `lt_day` int(11) NOT NULL DEFAULT '0' COMMENT '入驻周期时间',
  `settleintime` int(11) NOT NULL DEFAULT '0' COMMENT '入驻开始时间，用于缴费',
  `paytime` int(11) NOT NULL DEFAULT '0' COMMENT '入驻缴费完成时间',
  `facility` varchar(50) NOT NULL DEFAULT '0' COMMENT '设施id，用，号分隔',
  `store_id` int(11) NOT NULL COMMENT '分类id',
  `store_name` varchar(100) NOT NULL COMMENT '分类名称',
  `totalamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `frozenamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `commission` float NOT NULL DEFAULT '0' COMMENT '佣金比例',
  `memdiscount` float NOT NULL DEFAULT '0' COMMENT '会员折扣，线下付款',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶',
  `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序',
  `enable_printer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0关闭，1开启打印机',
  `backups_printer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否打印2份 0 否 1 是',
  `printer_user` varchar(255) NOT NULL COMMENT '飞蛾打印机账号',
  `printer_ukey` varchar(255) NOT NULL COMMENT '飞蛾打印机ukey',
  `printer_sn` varchar(255) NOT NULL COMMENT '飞蛾打印机编码',
  `aid` int(10) NOT NULL COMMENT '商圈id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `codeimg` varchar(100) NOT NULL COMMENT '小程序码',
  `codeimgsrc` varchar(200) NOT NULL COMMENT '小程序码路劲',
  `brand_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关闭商家 0 否 1 是',
  `time_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否营业时间内经营 0 否 1 是',
  `open_payment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用线下付 0 关闭 1启用',
  `cimg` varchar(255) DEFAULT NULL COMMENT '商家详情导航图',
  `is_delivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送 0 关闭 1启用',
  `delivery_start` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '起配费',
  `delivery_free` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免配费',
  `delivery_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费',
  `delivery_distance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送范围',
  `group` text COMMENT '配送设置',
  `sub_mch_id` varchar(200) NOT NULL COMMENT '商家子账户',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_brandpaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_brandpaylog`;
CREATE TABLE `ims_mzhk_sun_brandpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未完成支付，1已经支付',
  `paytime` int(11) NOT NULL COMMENT '支付时间',
  `out_trade_no` varchar(50) NOT NULL COMMENT '外部订单号',
  `openid` varchar(200) NOT NULL COMMENT '支付的openid',
  `uniacid` int(11) NOT NULL COMMENT '应用id',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_cardcollect
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_cardcollect`;
CREATE TABLE `ims_mzhk_sun_cardcollect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_str_id` text NOT NULL COMMENT '收集的卡片id列表',
  `card_img` varchar(200) NOT NULL COMMENT '卡片图',
  `openid` varchar(200) NOT NULL COMMENT 'openid',
  `gid` int(11) NOT NULL COMMENT '活动id',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `allnum` int(11) NOT NULL DEFAULT '0' COMMENT '总次数',
  `usednum` int(11) NOT NULL DEFAULT '0' COMMENT '已使用次数',
  `endtime` int(11) NOT NULL COMMENT '活动结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_cardorder
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_cardorder`;
CREATE TABLE `ims_mzhk_sun_cardorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `openid` varchar(200) NOT NULL COMMENT 'openid',
  `gid` int(11) NOT NULL COMMENT '集卡活动id',
  `addtime` int(11) NOT NULL COMMENT '集成时间',
  `ordernum` varchar(50) NOT NULL COMMENT '编号',
  `detailinfo` varchar(100) NOT NULL COMMENT '地址',
  `telnumber` varchar(30) NOT NULL COMMENT '电话',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0未发货，1已发货，2已领取',
  `countyname` varchar(20) NOT NULL COMMENT '区域',
  `provincename` varchar(20) NOT NULL COMMENT '省份',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `cityname` varchar(20) NOT NULL COMMENT '城市',
  `shiptime` int(11) NOT NULL COMMENT '发货时间',
  `endtime` int(11) NOT NULL COMMENT '活动结束时间',
  `gname` varchar(200) NOT NULL COMMENT '商品名称',
  `sincetype` varchar(100) NOT NULL DEFAULT '0' COMMENT '发货类型',
  `time` varchar(100) NOT NULL,
  `uremark` varchar(100) NOT NULL COMMENT '备注',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款',
  `goodsimg` varchar(200) NOT NULL COMMENT '商品图',
  `bid` int(11) NOT NULL COMMENT '商家id',
  `bname` int(11) NOT NULL COMMENT '商家名称',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `deliveryfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费',
  `out_trade_no` varchar(100) NOT NULL COMMENT '外部订单号',
  `shipnum` varchar(50) NOT NULL COMMENT '快递单号',
  `shipname` varchar(50) NOT NULL COMMENT '快递名称',
  `finishtime` int(11) NOT NULL COMMENT '结束时间',
  `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号',
  `expirationtime` int(11) NOT NULL COMMENT '核销过期时间',
  `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_cardshare
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_cardshare`;
CREATE TABLE `ims_mzhk_sun_cardshare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `addtime` int(11) NOT NULL COMMENT '分享时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1成功，0失败',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `gid` int(11) NOT NULL COMMENT 'gid',
  `openid` varchar(200) NOT NULL COMMENT 'openid',
  `num` int(11) NOT NULL COMMENT '当天分享次数',
  `click_user_str` text NOT NULL COMMENT '点击人，用英文逗号隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_catebanner
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_catebanner`;
CREATE TABLE `ims_mzhk_sun_catebanner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT '分类轮播图名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '所属栏目id',
  `img` varchar(100) NOT NULL COMMENT '图片',
  `link` int(11) NOT NULL DEFAULT '0' COMMENT '链接',
  `pop_urltxt` int(11) NOT NULL DEFAULT '0' COMMENT '相关 id',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态 0 隐藏 1 显示',
  `time` varchar(50) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_circle
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_circle`;
CREATE TABLE `ims_mzhk_sun_circle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `content` text NOT NULL COMMENT '圈子内容',
  `img` text NOT NULL COMMENT '图片',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `commentnum` int(11) NOT NULL COMMENT '评论数',
  `likenum` int(11) NOT NULL COMMENT '点赞数',
  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `oid` int(11) NOT NULL DEFAULT '0' COMMENT '评论关联订单id',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '评论关联商品id',
  `star` int(11) NOT NULL DEFAULT '0' COMMENT '评论星级',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '首页推荐 0 不推荐 1 推荐',
  `isdeshow` int(11) NOT NULL DEFAULT '1' COMMENT '是否详情页显示 0 不显示 1 显示',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_circlecomment
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_circlecomment`;
CREATE TABLE `ims_mzhk_sun_circlecomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `cid` int(11) NOT NULL COMMENT '圈子id',
  `content` text NOT NULL COMMENT '评论内容',
  `uname` varchar(255) NOT NULL COMMENT '评论人姓名',
  `uid` int(11) NOT NULL COMMENT '评论人id',
  `uimg` varchar(255) NOT NULL COMMENT '评论人头像',
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_circlelike
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_circlelike`;
CREATE TABLE `ims_mzhk_sun_circlelike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'uid',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `cid` int(11) NOT NULL COMMENT '圈子id',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uimg` varchar(255) NOT NULL COMMENT '用户头像',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_city
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_city`;
CREATE TABLE `ims_mzhk_sun_city` (
  `id` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL COMMENT '用户openid',
  `province` varchar(50) NOT NULL COMMENT '省',
  `city` varchar(50) NOT NULL COMMENT '市',
  `district` varchar(50) NOT NULL COMMENT '县',
  `uniacid` int(11) NOT NULL,
  `lat` varchar(255) NOT NULL COMMENT '纬度',
  `lng` varchar(255) NOT NULL COMMENT '经度'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_coupon`;
CREATE TABLE `ims_mzhk_sun_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) NOT NULL COMMENT '优惠券名称，展示用',
  `type` tinyint(3) unsigned DEFAULT NULL COMMENT '优惠券类型（1:折扣 2:满减 3;赠送）',
  `astime` timestamp NULL DEFAULT NULL COMMENT '活动开始时间',
  `antime` timestamp NULL DEFAULT NULL COMMENT '活动结束时间',
  `expiryDate` int(10) unsigned DEFAULT NULL COMMENT '领取后，使用有效期',
  `allowance` int(10) unsigned DEFAULT NULL COMMENT '余量',
  `total` int(10) unsigned DEFAULT NULL COMMENT '总量',
  `val` int(25) DEFAULT NULL COMMENT '功能',
  `showIndex` tinyint(4) DEFAULT NULL COMMENT '是否首页显示（0:不显示 1:显示）',
  `uniacid` int(11) DEFAULT NULL,
  `vab` int(11) DEFAULT NULL COMMENT '满减',
  `state` int(11) DEFAULT '1',
  `bid` varchar(50) DEFAULT NULL COMMENT '商店id',
  `remarks` varchar(50) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `mj` int(11) DEFAULT NULL,
  `md` int(11) DEFAULT NULL,
  `is_counp` int(11) DEFAULT '1',
  `isvip` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否会员领取，1会员，0非会员',
  `content` text NOT NULL COMMENT '优惠券详情',
  `img` varchar(200) NOT NULL COMMENT '图片',
  `isdelete` int(11) NOT NULL DEFAULT '0' COMMENT '是否删除，软删除',
  `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `currentprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现价',
  `cid` int(11) NOT NULL COMMENT '分类id',
  `money_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认支付金额比例',
  `score_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认兑换积分比例',
  `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启',
  `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1百分比，2固定金额',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  `img_details` varchar(400) NOT NULL COMMENT '商家发布商品详情图',
  `brelease` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否商家发布商品 0 不是 1 是',
  `selftime` varchar(200) DEFAULT NULL COMMENT '加入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_couponcate
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_couponcate`;
CREATE TABLE `ims_mzhk_sun_couponcate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `catename` varchar(255) NOT NULL COMMENT '分类名称',
  `sort` int(5) NOT NULL COMMENT '排序',
  `cateimg` varchar(255) NOT NULL COMMENT '分类图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_cuthelp
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_cuthelp`;
CREATE TABLE `ims_mzhk_sun_cuthelp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL COMMENT '帮砍人openid',
  `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT 'uniacid',
  `username` varchar(100) NOT NULL COMMENT '帮砍人名称',
  `cs_id` int(11) NOT NULL DEFAULT '0' COMMENT '砍主id',
  `isself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0帮砍，1自砍',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `nowprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前价格',
  `cutprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍掉价格',
  `addtime` int(11) NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_cutself
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_cutself`;
CREATE TABLE `ims_mzhk_sun_cutself` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL COMMENT '砍价openid',
  `username` varchar(50) NOT NULL COMMENT '砍价用户名',
  `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT 'uniacid',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `shopprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `nowprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前价格',
  `lavenum` int(11) NOT NULL COMMENT '剩余人数',
  `allnum` int(11) NOT NULL DEFAULT '0' COMMENT '总次数',
  `lowprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低价格',
  `addtime` int(11) NOT NULL COMMENT '时间',
  `is_buy` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否已经下单，0未下单，1已经下单',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_deliveryorder
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_deliveryorder`;
CREATE TABLE `ims_mzhk_sun_deliveryorder` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) NOT NULL COMMENT '订单号',
  `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址',
  `telNumber` varchar(100) DEFAULT NULL COMMENT '电话',
  `money` decimal(10,2) DEFAULT NULL COMMENT '总价',
  `status` varchar(255) DEFAULT '2' COMMENT '1 取消订单，2待支付，3待配送，4配送中，5已完成',
  `openid` varchar(150) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(11) DEFAULT NULL,
  `countyName` varchar(150) DEFAULT NULL COMMENT '区域',
  `provinceName` varchar(150) DEFAULT NULL COMMENT '省份',
  `name` varchar(100) DEFAULT NULL COMMENT '名字',
  `addtime` varchar(100) DEFAULT NULL COMMENT '加入的时间',
  `cityName` varchar(100) DEFAULT NULL COMMENT '城市',
  `uremark` varchar(100) DEFAULT NULL,
  `sincetype` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `paytime` int(11) NOT NULL COMMENT '付款时间',
  `out_trade_no` varchar(100) NOT NULL COMMENT '外部订单号',
  `ordertype` tinyint(1) NOT NULL COMMENT '类型，待用',
  `deliveryfee` decimal(10,2) NOT NULL COMMENT '配送费',
  `bid` int(11) NOT NULL COMMENT '商家id',
  `bname` varchar(100) NOT NULL COMMENT '商家名称',
  `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款',
  `shipnum` varchar(50) NOT NULL COMMENT '快递单号',
  `shipname` varchar(50) NOT NULL COMMENT '快递名称',
  `shiptime` int(11) NOT NULL COMMENT '发货时间',
  `finishtime` int(11) NOT NULL COMMENT '结束时间',
  `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号',
  `expirationtime` int(11) NOT NULL COMMENT '核销过期时间',
  `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用',
  `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id',
  `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额',
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台',
  `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id',
  `returnsign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买会员赠送标识 0 非赠送 1 赠送',
  `viplogid` int(11) NOT NULL DEFAULT '0' COMMENT '会员订单id',
  `vipid` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_deliveryorderdetail
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_deliveryorderdetail`;
CREATE TABLE `ims_mzhk_sun_deliveryorderdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) NOT NULL COMMENT '购物车订单号',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `pic` varchar(100) NOT NULL COMMENT '商品图片',
  `gname` varchar(100) NOT NULL COMMENT '商品名称',
  `num` int(11) NOT NULL COMMENT '件数',
  `price` decimal(10,2) NOT NULL COMMENT '商品单价',
  `vipprice` decimal(10,2) NOT NULL COMMENT '商品会员价',
  `lid` int(1) NOT NULL COMMENT '商品类型，1普通，5抢购',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_distribution_fission_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_distribution_fission_goods`;
CREATE TABLE `ims_mzhk_sun_distribution_fission_goods` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `fission_name` varchar(200) NOT NULL COMMENT '活动名称',
  `bid` int(10) NOT NULL COMMENT '所属商家',
  `start_time` varchar(100) NOT NULL COMMENT '活动开始时间',
  `end_time` varchar(100) NOT NULL COMMENT '活动结束时间',
  `writeoff_time` varchar(100) NOT NULL COMMENT '核销过期时间',
  `explain_use` varchar(200) NOT NULL COMMENT '使用说明',
  `explain_discount` varchar(200) NOT NULL COMMENT '使用优惠说明',
  `explain_activation` varchar(200) NOT NULL COMMENT '激活优惠说明',
  `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序',
  `rec_index` int(11) NOT NULL DEFAULT '0' COMMENT '是否推荐到首页 0 否 1 是',
  `is_upper` int(11) NOT NULL DEFAULT '0' COMMENT '是否上架 0 否 1 是',
  `pic` varchar(200) NOT NULL COMMENT '缩略图',
  `content` text NOT NULL COMMENT '活动详情',
  `nums_activation` int(11) NOT NULL DEFAULT '5' COMMENT '激活人数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_distribution_fission_help
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_distribution_fission_help`;
CREATE TABLE `ims_mzhk_sun_distribution_fission_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT '推荐订单id',
  `openid` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '推荐人id',
  `addtime` varchar(100) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_distribution_fission_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_distribution_fission_order`;
CREATE TABLE `ims_mzhk_sun_distribution_fission_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `fname` varchar(200) NOT NULL COMMENT '列表券名称',
  `stime` varchar(100) NOT NULL COMMENT '开始时间',
  `etime` varchar(100) NOT NULL COMMENT '结束时间',
  `wtime` varchar(100) NOT NULL COMMENT '核销时间',
  `explain` varchar(200) NOT NULL COMMENT '使用说明',
  `discount` varchar(200) NOT NULL COMMENT '优惠说明',
  `fid` int(11) NOT NULL COMMENT '裂变券id',
  `bid` int(11) NOT NULL COMMENT '门店id',
  `openid` varchar(100) NOT NULL COMMENT '用户openid',
  `is_activation` int(11) NOT NULL DEFAULT '0' COMMENT '是否激活 0 未激活  1 已激活',
  `atime` varchar(100) NOT NULL DEFAULT '0' COMMENT '激活时间',
  `addtime` varchar(100) NOT NULL COMMENT '领取时间',
  `give_num` int(11) NOT NULL DEFAULT '5' COMMENT '可赠送数',
  `wfstatus` int(11) NOT NULL DEFAULT '0' COMMENT '核销状态 0 未核销 1 已核销',
  `wftime` varchar(100) NOT NULL COMMENT '核销时间',
  `wfcode` varchar(100) CHARACTER SET utf8mb4 NOT NULL COMMENT '核销码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_distribution_fission_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_distribution_fission_set`;
CREATE TABLE `ims_mzhk_sun_distribution_fission_set` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `open_fission` int(10) NOT NULL DEFAULT '0' COMMENT '是否开启裂变券 0 不开启 1 开启',
  `list_banner` varchar(100) NOT NULL COMMENT '列表banner图',
  `icon_user` varchar(100) NOT NULL COMMENT '可使用图标',
  `icon_activation` varchar(100) NOT NULL COMMENT '待激活图标',
  `icon_give` varchar(100) NOT NULL COMMENT '可赠送图标',
  `detailbanner` varchar(100) NOT NULL COMMENT '详情顶部背景图',
  `index_name` varchar(50) NOT NULL COMMENT '首页展示名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_distribution_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_distribution_order`;
CREATE TABLE `ims_mzhk_sun_distribution_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ordertype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类别，1普通，2砍价，3拼团，4抢购，5预约',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '3级id',
  `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  `rebate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自购，0否，1是',
  `user_id` int(11) NOT NULL COMMENT '购买用户id',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（用来识别是否计入可提现佣金），0未，1删',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_distribution_promoter
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_distribution_promoter`;
CREATE TABLE `ims_mzhk_sun_distribution_promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `mobilephone` varchar(30) NOT NULL COMMENT '手机号',
  `allcommission` decimal(10,2) NOT NULL COMMENT '累计佣金',
  `canwithdraw` decimal(10,2) NOT NULL COMMENT '可提现佣金',
  `referrer_name` varchar(100) NOT NULL COMMENT '推荐人',
  `referrer_uid` int(11) NOT NULL COMMENT '推荐人id',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态，0审核中，1通过，2拒绝',
  `addtime` int(11) NOT NULL COMMENT '申请时间',
  `checktime` int(11) NOT NULL COMMENT '审核时间',
  `meno` text NOT NULL COMMENT '备注',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id，发模板消息',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现冻结的金额',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `code_img` mediumblob NOT NULL COMMENT '小程序码',
  `invitation_code` varchar(20) NOT NULL COMMENT '邀请码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_distribution_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_distribution_set`;
CREATE TABLE `ims_mzhk_sun_distribution_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销层级,0不开启，1一级，2二级',
  `is_buyself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销内购，0关闭，1开启',
  `lower_condition` tinyint(1) NOT NULL DEFAULT '0' COMMENT '成为下线条件，0首次点击链接',
  `share_condition` tinyint(3) NOT NULL DEFAULT '0' COMMENT '成为分销商条件，0无条件但要审核，1申请审核，2不需要审核',
  `autoshare` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费自动成为分销商',
  `withdrawtype` varchar(100) NOT NULL COMMENT '提现方式,1微信支付,2支付宝支付,3银行卡支付,4余额支付',
  `minwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度',
  `daymaxwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限',
  `withdrawnotice` text NOT NULL COMMENT '用户提现须知',
  `tpl_wd_arrival` varchar(255) NOT NULL COMMENT '提现到账模板消息id',
  `tpl_wd_fail` varchar(255) NOT NULL COMMENT '提现失败模板消息id',
  `tpl_share_check` varchar(255) NOT NULL COMMENT '分销审核模板消息id',
  `application` text NOT NULL COMMENT '申请协议',
  `applybanner` varchar(255) NOT NULL COMMENT '申请页面banner',
  `checkbanner` varchar(255) NOT NULL COMMENT '待审核页面banner',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `commissiontype` tinyint(3) NOT NULL DEFAULT '1' COMMENT '分销佣金类型，1百分比，2固定金额',
  `firstname` varchar(255) NOT NULL COMMENT '一级名称',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额',
  `secondname` varchar(255) NOT NULL COMMENT '二级名称',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额',
  `withdrawhandingfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费',
  `thirdname` varchar(50) NOT NULL COMMENT '第三级名称',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '第三级佣金',
  `postertoppic` varchar(255) NOT NULL COMMENT '海报图',
  `postertoptitle` varchar(200) NOT NULL COMMENT '海报标题',
  `is_offline` tinyint(1) NOT NULL DEFAULT '0' COMMENT '线下付是否开启分销，0关闭，1开启',
  `dsource` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销佣金来源 0 平台 1 商家',
  `hbtourl` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销海报跳转，0分销中心，1首页',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_distribution_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_distribution_withdraw`;
CREATE TABLE `ims_mzhk_sun_distribution_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `uname` varchar(255) NOT NULL COMMENT '姓名',
  `account` varchar(20) NOT NULL COMMENT '提现账号',
  `withdrawaltype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现方式，1微信，2支付宝，3银行卡，4余额',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现状态，0待打款，1已经打款，2拒绝',
  `time` int(11) NOT NULL COMMENT '时间',
  `mobilephone` varchar(30) NOT NULL COMMENT '手机号',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `meno` text NOT NULL COMMENT '备注',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `bankname` varchar(100) NOT NULL COMMENT '银行名称',
  `fbankname` varchar(100) NOT NULL COMMENT '支行名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_district
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_district`;
CREATE TABLE `ims_mzhk_sun_district` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `citycode` varchar(255) NOT NULL,
  `adcode` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL COMMENT '经度',
  `lat` varchar(255) NOT NULL COMMENT '纬度',
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='全国省市';

-- ----------------------------
-- Table structure for ims_mzhk_sun_eatvisit_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_eatvisit_goods`;
CREATE TABLE `ims_mzhk_sun_eatvisit_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(255) NOT NULL COMMENT '商品名称',
  `shopprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `thumbnail` varchar(200) NOT NULL COMMENT '缩略图',
  `tid` int(11) NOT NULL DEFAULT '2' COMMENT '首页推荐，1推荐，2不推荐',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商品状态，1审核，2通过，3删除',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `content` text NOT NULL COMMENT '商品详情',
  `bid` int(11) NOT NULL COMMENT '店铺id',
  `num` int(11) NOT NULL COMMENT '库存',
  `allnum` int(11) NOT NULL COMMENT '总数量，不纳入加减的',
  `astime` varchar(30) NOT NULL COMMENT '活动开始时间',
  `antime` varchar(30) NOT NULL COMMENT '活动结束时间',
  `initialdraws` int(11) NOT NULL DEFAULT '0' COMMENT '初始抽奖次数',
  `shareaddnum` int(11) NOT NULL DEFAULT '0' COMMENT '分享获取次数',
  `sharetitle` varchar(255) NOT NULL COMMENT '分销标题',
  `shareimg` varchar(255) NOT NULL COMMENT '分享图',
  `storename` varchar(255) NOT NULL COMMENT '店铺名',
  `is_vip` int(11) NOT NULL DEFAULT '0' COMMENT '是否会员使用，0不是，1是',
  `buynum` int(11) NOT NULL COMMENT '购买数参与数',
  `viewnum` int(11) NOT NULL COMMENT '查看人数',
  `sharenum` int(11) NOT NULL COMMENT '分享次数',
  `limitnum` int(11) NOT NULL COMMENT '限购',
  `isshelf` tinyint(1) NOT NULL COMMENT '是否上架，0下架，1上架',
  `sort` int(5) NOT NULL COMMENT '排序',
  `expirationtime` varchar(30) NOT NULL COMMENT '核销过期时间',
  `firstprize` varchar(255) NOT NULL COMMENT '一等奖内容',
  `secondprize` varchar(255) NOT NULL COMMENT '二等奖内容',
  `thirdprize` varchar(255) NOT NULL COMMENT '三等奖内容',
  `fourthprize` varchar(255) NOT NULL COMMENT '四等奖内容',
  `grandprize` varchar(255) NOT NULL COMMENT '特等奖内容',
  `currentprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现价',
  `firstprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一等奖概率',
  `secondprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二等奖概率',
  `thirdprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三等奖概率',
  `fourthprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '四等奖概率',
  `grandprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '特等奖概率',
  `virtualnum` int(11) NOT NULL COMMENT '虚拟领取数',
  `firstnum` int(11) NOT NULL COMMENT '一等奖数量',
  `secondnum` int(11) NOT NULL COMMENT '二等奖数量',
  `thirdnum` int(11) NOT NULL COMMENT '三等奖数量',
  `fourthnum` int(11) NOT NULL COMMENT '四等奖数量',
  `grandnum` int(11) NOT NULL COMMENT '特等奖数量',
  `index_img` varchar(255) NOT NULL COMMENT '首页图',
  `usenotice` text NOT NULL COMMENT '使用须知',
  `notwonprize` varchar(255) NOT NULL COMMENT '未中奖提示名',
  `notwonprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '未中奖概率',
  `posterimg` varchar(255) NOT NULL COMMENT '海报图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_eatvisit_lotteryrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_eatvisit_lotteryrecord`;
CREATE TABLE `ims_mzhk_sun_eatvisit_lotteryrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'uid',
  `openid` varchar(200) NOT NULL COMMENT 'openid',
  `gid` int(11) NOT NULL COMMENT '吃探商品id',
  `prize` text NOT NULL COMMENT '奖品',
  `allnum` int(11) NOT NULL COMMENT '可抽奖次数',
  `usenum` int(11) NOT NULL COMMENT '已使用次数',
  `click_user` text NOT NULL COMMENT '点击用户id',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `awardid` tinytext NOT NULL COMMENT '保存中奖key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_eatvisit_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_eatvisit_order`;
CREATE TABLE `ims_mzhk_sun_eatvisit_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `storeid` int(11) NOT NULL COMMENT '商家id',
  `gname` varchar(255) NOT NULL COMMENT '商品名称',
  `storename` varchar(255) NOT NULL COMMENT '商家名称',
  `award` tinyint(2) NOT NULL DEFAULT '5' COMMENT '奖项，0特等奖，1一等奖，2二等奖，3三等奖，4四等奖，5未等奖',
  `prize` varchar(255) NOT NULL COMMENT '奖品',
  `ordernum` varchar(200) NOT NULL COMMENT '订单号',
  `writeoffcode` varchar(200) NOT NULL COMMENT '核销码',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，1未使用，2已经使用',
  `uid` int(11) NOT NULL COMMENT 'uid',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `addtime` varchar(30) NOT NULL COMMENT '添加时间',
  `finishtime` varchar(30) NOT NULL COMMENT '完成时间',
  `gimages` varchar(255) NOT NULL COMMENT '商品图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_eatvisit_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_eatvisit_set`;
CREATE TABLE `ims_mzhk_sun_eatvisit_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `pic` varchar(255) NOT NULL COMMENT '轮播图',
  `tpl_winnotice` varchar(255) NOT NULL COMMENT '中奖通知模板消息',
  `tpl_newnotice` varchar(255) NOT NULL COMMENT '新品通知模板消息',
  `navname` varchar(50) NOT NULL COMMENT '顶部名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_evaluate
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_evaluate`;
CREATE TABLE `ims_mzhk_sun_evaluate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `time` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `xingxing` varchar(7) DEFAULT NULL,
  `content` text,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_gift
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_gift`;
CREATE TABLE `ims_mzhk_sun_gift` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id',
  `title` varchar(200) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `content` text NOT NULL COMMENT '文章内容',
  `sort` int(10) DEFAULT '0',
  `pic` varchar(200) DEFAULT NULL,
  `gid` int(11) DEFAULT '0' COMMENT '商品id',
  `gname` varchar(200) DEFAULT NULL COMMENT '商品名称',
  `probability` float NOT NULL DEFAULT '0' COMMENT '概率',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_goods`;
CREATE TABLE `ims_mzhk_sun_goods` (
  `gid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `gname` text NOT NULL COMMENT '商品名称',
  `kjprice` decimal(10,2) DEFAULT NULL COMMENT '砍价的价格',
  `shopprice` decimal(10,2) DEFAULT NULL COMMENT '原价',
  `selftime` varchar(200) DEFAULT NULL COMMENT '加入时间',
  `pic` varchar(200) DEFAULT NULL COMMENT '封面图',
  `probably` text COMMENT '备注',
  `tid` int(11) DEFAULT NULL COMMENT '商品是否推荐，1推荐，2不推荐',
  `status` int(11) DEFAULT NULL COMMENT '商品状态，1为审核，2审核通过，3删除',
  `uniacid` int(11) DEFAULT NULL,
  `content` text COMMENT '商品详情',
  `lid` int(11) DEFAULT NULL COMMENT '商品类别id 1.为普通，2位砍价，3位拼团，4为集卡，5是抢购',
  `bid` int(11) DEFAULT NULL COMMENT '店铺id',
  `num` int(11) DEFAULT NULL,
  `ptprice` decimal(10,2) DEFAULT NULL COMMENT '拼团价格',
  `astime` varchar(30) DEFAULT NULL COMMENT '活动开始时间',
  `antime` varchar(30) DEFAULT NULL COMMENT '活动结束时间',
  `ptnum` int(11) DEFAULT NULL COMMENT '拼团活动人数量',
  `lb_imgs` varchar(400) DEFAULT NULL COMMENT '轮播图',
  `qgprice` decimal(10,2) DEFAULT NULL COMMENT '抢购',
  `charnum` int(11) DEFAULT NULL,
  `charaddnum` int(11) NOT NULL,
  `biaoti` varchar(300) NOT NULL,
  `kjbfb` float NOT NULL DEFAULT '20' COMMENT '砍价百分比',
  `is_ptopen` int(11) NOT NULL DEFAULT '1',
  `is_kjopen` int(11) NOT NULL DEFAULT '1',
  `is_jkopen` int(11) NOT NULL DEFAULT '1',
  `is_qgopen` int(11) NOT NULL DEFAULT '1',
  `is_hyopen` int(11) NOT NULL DEFAULT '1',
  `bname` varchar(50) NOT NULL COMMENT '店铺名称',
  `initialtimes` int(11) NOT NULL COMMENT '初始抽奖次数',
  `is_vip` tinyint(1) NOT NULL COMMENT '是否会员，0非会员，1会员',
  `buynum` int(11) NOT NULL COMMENT '已购买数量',
  `viewnum` int(11) NOT NULL COMMENT '查看人数',
  `sharenum` int(11) NOT NULL COMMENT '分享次数',
  `cutnum` int(11) NOT NULL COMMENT '可参与砍价人数',
  `ship_type` varchar(10) NOT NULL DEFAULT '1' COMMENT '配送方式，1到店消费，2送货上门，3快递',
  `ship_delivery_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '送货上门-配送费',
  `ship_delivery_time` varchar(30) NOT NULL COMMENT '送货上门-配送时间',
  `ship_delivery_way` float NOT NULL DEFAULT '1' COMMENT '送货上门-配送距离',
  `ship_express_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递-快递费',
  `limitnum` int(11) NOT NULL DEFAULT '0' COMMENT '限购数量',
  `isshelf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否上架，0下架，1上架',
  `limittime` float NOT NULL DEFAULT '0' COMMENT '参团时限',
  `sort` int(5) NOT NULL DEFAULT '255' COMMENT '排序',
  `expirationtime` int(11) NOT NULL DEFAULT '0' COMMENT '核销过期时间',
  `stocktype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0下单减库存，1付款减库存',
  `lotterytime` int(11) NOT NULL COMMENT '开奖时间',
  `winway` tinyint(2) NOT NULL DEFAULT '0' COMMENT '开奖方式，0自动，1手动',
  `islottery` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否已经开奖，0否，1是',
  `lotterytype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '开奖条件，0按时间，1按人数',
  `lotterynum` int(11) NOT NULL COMMENT '开奖人数',
  `index_img` varchar(255) DEFAULT NULL COMMENT '首页展示图',
  `code_img` mediumblob NOT NULL COMMENT '小程序码',
  `vipprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员价格',
  `mustlowprice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '砍价，0不用砍到底价，1必须砍到低价才能购买',
  `canrefund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0可以退款，1不能退款',
  `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启',
  `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1百分比，2固定金额',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  `cateid` int(10) DEFAULT NULL COMMENT '分类id',
  `index3_img` varchar(255) DEFAULT NULL COMMENT '风格3首页展示图',
  `money_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认支付金额比例',
  `score_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认兑换积分比例',
  `kjsection_open` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启砍价区间 0 否 1 是',
  `sctionpnum1` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间1人数范围',
  `sctionpnum11` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间1人数范围',
  `sctionpnum2` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间2人数范围',
  `sctionpnum22` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间2人数范围',
  `sctionpnum3` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间3人数范围',
  `sctionpnum33` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间3人数范围',
  `sctionmoney1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价区间1砍价价格',
  `sctionmoney2` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价区间2砍价价格',
  `sctionmoney3` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价区间3砍价价格',
  `open_num` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启每日砍价次数 0 否 1 是',
  `day_num` int(11) NOT NULL DEFAULT '0' COMMENT '每日砍价次数',
  `open_friend` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启每日帮同一好友砍价次数 0 否 1 是',
  `friend_num` int(11) NOT NULL DEFAULT '0' COMMENT '帮同一好友砍价次数',
  `isjoin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否参与返利 0 不参与 1 参与',
  `rebate_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启商家返利 0否 1是',
  `rebatetype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '返利类型 1百分比 2固定金额',
  `rebatemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返利金额',
  `ordernum` int(11) NOT NULL DEFAULT '0' COMMENT '多少单后开始返利',
  `ptshopprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '普通商品原价',
  `fseenum` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟查看人数',
  `fsharenum` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟分享人数',
  `fjoinnum` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟参与人数',
  `recdetail` int(11) NOT NULL DEFAULT '0' COMMENT '商品是否推荐到详情页，0不推荐，1推荐',
  `img_details` varchar(400) NOT NULL COMMENT '商家发布商品详情图',
  `brelease` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否商家发布商品 0 不是 1 是',
  `iscj` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否绑定抽奖 0 不是 1 是',
  `cjid` int(11) NOT NULL COMMENT '抽奖ID',
  `is_delivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送 0 关闭 1启用',
  `is_delivery_limit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送限购 0 关闭 1启用',
  `delivery_limit` int(11) NOT NULL DEFAULT '0' COMMENT '配送限购数量',
  `zid` int(11) DEFAULT '0' COMMENT '挚能云商品id',
  `recvipbuy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐到会员购买页 0不推荐 1推荐',
  `media_id` varchar(100) NOT NULL COMMENT '小程序卡片媒体id',
  `media_id_time` varchar(30) DEFAULT NULL COMMENT '小程序上传临时媒体图时间',
  `wechat_media_img` varchar(255) DEFAULT NULL COMMENT '小程序卡片需要的图',
  `reccloud` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐到云店 0不推荐 1推荐',
  `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金占比',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COMMENT='商品 ';

-- ----------------------------
-- Table structure for ims_mzhk_sun_goodscate
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_goodscate`;
CREATE TABLE `ims_mzhk_sun_goodscate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `cateexplain` varchar(100) NOT NULL COMMENT '分类说明',
  `status` int(10) NOT NULL DEFAULT '0' COMMENT '状态 0 不显示  1 显示',
  `time` varchar(100) NOT NULL COMMENT '添加时间',
  `cateimg` varchar(100) NOT NULL COMMENT '分类图片',
  `uniacid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_hyorder
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_hyorder`;
CREATE TABLE `ims_mzhk_sun_hyorder` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) NOT NULL COMMENT '订单号',
  `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址',
  `telNumber` varchar(100) DEFAULT NULL COMMENT '电话',
  `money` decimal(10,2) DEFAULT NULL COMMENT '总价',
  `status` varchar(255) DEFAULT '0' COMMENT '1 取消订单，2待支付，3已支付，4待收货，5已完成',
  `openid` varchar(150) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(11) DEFAULT NULL,
  `countyName` varchar(150) DEFAULT NULL COMMENT '区域',
  `provinceName` varchar(150) DEFAULT NULL COMMENT '省份',
  `name` varchar(100) DEFAULT NULL COMMENT '名字',
  `addtime` varchar(100) DEFAULT NULL COMMENT '加入的时间',
  `cityName` varchar(100) DEFAULT NULL COMMENT '城市',
  `uremark` varchar(100) DEFAULT NULL,
  `sincetype` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `paytime` int(11) NOT NULL COMMENT '付款时间',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `gname` varchar(100) NOT NULL COMMENT '商品名称',
  `num` int(11) NOT NULL COMMENT '件数',
  `out_trade_no` varchar(100) NOT NULL COMMENT '外部订单号',
  `ordertype` tinyint(1) NOT NULL COMMENT '类型，待用',
  `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费',
  `goodsimg` varchar(200) NOT NULL COMMENT '商品图',
  `bid` int(11) NOT NULL COMMENT '商家id',
  `bname` varchar(100) NOT NULL COMMENT '商家名称',
  `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款',
  `shipnum` varchar(50) NOT NULL COMMENT '快递单号',
  `shipname` varchar(50) NOT NULL COMMENT '快递名称',
  `shiptime` int(11) NOT NULL COMMENT '发货时间',
  `finishtime` int(11) NOT NULL COMMENT '结束时间',
  `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号',
  `expirationtime` int(11) NOT NULL DEFAULT '0' COMMENT '核销过期时间',
  `islottery` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0未开奖，1中奖，2未中奖',
  `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付',
  `lottery_code` varchar(100) NOT NULL COMMENT '抽奖码',
  `click_openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '分享点击者openid',
  PRIMARY KEY (`oid`),
  KEY `oid` (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_kanjia
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_kanjia`;
CREATE TABLE `ims_mzhk_sun_kanjia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL COMMENT '用户id',
  `gid` int(11) DEFAULT NULL COMMENT '砍价商品id',
  `mch_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `kanjia` decimal(11,0) NOT NULL,
  `price1` decimal(10,2) NOT NULL,
  `kanjia1` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_kjorder
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_kjorder`;
CREATE TABLE `ims_mzhk_sun_kjorder` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) NOT NULL COMMENT '订单号',
  `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址',
  `telNumber` varchar(100) DEFAULT NULL COMMENT '电话',
  `money` decimal(10,2) DEFAULT NULL COMMENT '总价',
  `status` tinyint(2) DEFAULT '2' COMMENT '1 取消订单，2待支付，3待发货，4已支付，5已完成',
  `openid` varchar(150) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(11) DEFAULT NULL,
  `countyName` varchar(150) DEFAULT NULL COMMENT '区域',
  `provinceName` varchar(150) DEFAULT NULL COMMENT '省份',
  `name` varchar(100) DEFAULT NULL COMMENT '名字',
  `addtime` int(11) DEFAULT '0' COMMENT '加入的时间',
  `cityName` varchar(100) DEFAULT NULL COMMENT '城市',
  `uremark` varchar(100) DEFAULT NULL,
  `sincetype` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `paytime` int(11) NOT NULL COMMENT '付款时间',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `gname` varchar(200) NOT NULL COMMENT '商品名称',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '购买数量',
  `out_trade_no` varchar(200) DEFAULT NULL COMMENT '外部订单id',
  `ordertype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型，0普通，1抢购，2拼团，3砍价',
  `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费',
  `goodsimg` varchar(200) NOT NULL COMMENT '商品图',
  `bid` int(11) NOT NULL COMMENT '商家id',
  `bname` varchar(100) NOT NULL COMMENT '商家名称',
  `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款',
  `shipnum` varchar(50) NOT NULL COMMENT '快递单号',
  `shipname` varchar(50) NOT NULL COMMENT '快递名称',
  `shiptime` int(11) NOT NULL COMMENT '发货时间',
  `finishtime` int(11) NOT NULL COMMENT '结束时间',
  `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号',
  `expirationtime` int(11) NOT NULL COMMENT '核销过期时间',
  `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用',
  `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id',
  `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额',
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台',
  `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id',
  `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0非套餐，1套餐',
  `packageid` int(11) NOT NULL COMMENT '套餐ID',
  `packageoid` int(11) NOT NULL COMMENT '套餐订单ID',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_member_brand
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_member_brand`;
CREATE TABLE `ims_mzhk_sun_member_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL COMMENT '商家ID',
  `bname` varchar(50) NOT NULL COMMENT '商家名称',
  `img` varchar(100) NOT NULL COMMENT '商家主图',
  `tid` int(11) NOT NULL COMMENT '分类ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1审核，2通过，3删除',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(5) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_member_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_member_goods`;
CREATE TABLE `ims_mzhk_sun_member_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `price` decimal(11,2) NOT NULL COMMENT '价值',
  `img` varchar(200) NOT NULL COMMENT '图片',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1审核，2通过，3删除',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `allcancel` int(11) NOT NULL COMMENT '总核销限制次数',
  `yearcancel` int(11) NOT NULL COMMENT '每人每年核销限制次数',
  `daycancel` int(11) NOT NULL COMMENT '每人每天核销限制次数',
  `content` text NOT NULL COMMENT '商品详情',
  `bid` int(11) NOT NULL COMMENT '店铺id',
  `bname` varchar(50) NOT NULL COMMENT '店铺名',
  `starttime` varchar(20) NOT NULL COMMENT '开始时间',
  `endtime` varchar(20) NOT NULL COMMENT '结束时间',
  `sort` int(5) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_member_num
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_member_num`;
CREATE TABLE `ims_mzhk_sun_member_num` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `phone` varchar(20) NOT NULL COMMENT '会员电话',
  `time` varchar(20) NOT NULL COMMENT '发送时间',
  `num` int(11) NOT NULL COMMENT '验证码',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_member_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_member_order`;
CREATE TABLE `ims_mzhk_sun_member_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `gid` int(11) NOT NULL COMMENT '权益id',
  `bid` int(11) NOT NULL COMMENT '商家id',
  `gname` varchar(255) NOT NULL COMMENT '权益名称',
  `bname` varchar(255) NOT NULL COMMENT '商家名称',
  `uname` varchar(255) NOT NULL COMMENT '用户名称',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `time` varchar(20) NOT NULL COMMENT '核销时间',
  `uid` int(11) NOT NULL COMMENT 'uid',
  `ische` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为未撤销，0为已撤销',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_member_record
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_member_record`;
CREATE TABLE `ims_mzhk_sun_member_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `phone` varchar(20) NOT NULL COMMENT '会员电话',
  `name` varchar(20) NOT NULL COMMENT '会员名字',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_member_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_member_set`;
CREATE TABLE `ims_mzhk_sun_member_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `ismsg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `isname` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `isrecord` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `time` int(11) NOT NULL DEFAULT '20' COMMENT 'time',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `pic` varchar(255) NOT NULL COMMENT '轮播图',
  `navname` varchar(50) NOT NULL DEFAULT '会员权益' COMMENT '顶部名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_member_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_member_type`;
CREATE TABLE `ims_mzhk_sun_member_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '商品名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1审核，2通过，3删除',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(5) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_mercapdetails
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_mercapdetails`;
CREATE TABLE `ims_mzhk_sun_mercapdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL COMMENT '商家id',
  `bname` varchar(100) NOT NULL COMMENT '商家名称',
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
  `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_order`;
CREATE TABLE `ims_mzhk_sun_order` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) NOT NULL COMMENT '订单号',
  `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址',
  `telNumber` varchar(100) DEFAULT NULL COMMENT '电话',
  `money` decimal(10,2) DEFAULT NULL COMMENT '总价',
  `status` varchar(255) DEFAULT '2' COMMENT '1 取消订单，2待支付，3待发货，4已支付，5已完成',
  `openid` varchar(150) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(11) DEFAULT NULL,
  `countyName` varchar(150) DEFAULT NULL COMMENT '区域',
  `provinceName` varchar(150) DEFAULT NULL COMMENT '省份',
  `name` varchar(100) DEFAULT NULL COMMENT '名字',
  `addtime` varchar(100) DEFAULT NULL COMMENT '加入的时间',
  `cityName` varchar(100) DEFAULT NULL COMMENT '城市',
  `uremark` varchar(100) DEFAULT NULL,
  `sincetype` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `paytime` int(11) NOT NULL COMMENT '付款时间',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `gname` varchar(100) NOT NULL COMMENT '商品名称',
  `num` int(11) NOT NULL COMMENT '件数',
  `out_trade_no` varchar(100) NOT NULL COMMENT '外部订单号',
  `ordertype` tinyint(1) NOT NULL COMMENT '类型，待用',
  `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费',
  `goodsimg` varchar(200) NOT NULL COMMENT '商品图',
  `bid` int(11) NOT NULL COMMENT '商家id',
  `bname` varchar(100) NOT NULL COMMENT '商家名称',
  `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款',
  `shipnum` varchar(50) NOT NULL COMMENT '快递单号',
  `shipname` varchar(50) NOT NULL COMMENT '快递名称',
  `shiptime` int(11) NOT NULL COMMENT '发货时间',
  `finishtime` int(11) NOT NULL COMMENT '结束时间',
  `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号',
  `expirationtime` int(11) NOT NULL COMMENT '核销过期时间',
  `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `haswrittenoffnum` int(11) NOT NULL COMMENT '已核销数',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用',
  `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id',
  `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额',
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台',
  `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id',
  `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0非套餐，1套餐',
  `packageoid` int(11) NOT NULL COMMENT '套餐订单ID',
  `packageid` int(11) NOT NULL COMMENT '套餐ID',
  `returnsign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买会员赠送标识 0 非赠送 1 赠送',
  `viplogid` int(11) NOT NULL DEFAULT '0' COMMENT '会员订单id',
  `vipid` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金',
  `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金',
  `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金',
  `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '云店佣金',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_package_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_package_goods`;
CREATE TABLE `ims_mzhk_sun_package_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `showprice` decimal(11,2) NOT NULL COMMENT '价值',
  `price` decimal(11,2) NOT NULL COMMENT '价格',
  `pic` text NOT NULL COMMENT '轮播图',
  `img` varchar(200) NOT NULL COMMENT '图片',
  `poster` varchar(200) NOT NULL COMMENT '海报图',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1显示，2隐藏',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `limit` int(11) NOT NULL COMMENT '限购',
  `limitnum` int(11) NOT NULL COMMENT '库存',
  `starttime` varchar(20) NOT NULL COMMENT '开始时间',
  `endtime` varchar(20) NOT NULL COMMENT '结束时间',
  `type` int(11) NOT NULL COMMENT '分类id',
  `is_vip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否会员，1是，0不是',
  `stocktype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0下单减库存，1付款减库存',
  `vipprice` decimal(11,2) NOT NULL COMMENT '会员价格',
  `sort` int(5) NOT NULL COMMENT '排序',
  `ship_type` varchar(10) NOT NULL DEFAULT '1' COMMENT '配送方式，1到店消费，2送货上门，3快递',
  `ship_delivery_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '送货上门-配送费',
  `ship_delivery_time` varchar(30) NOT NULL COMMENT '送货上门-配送时间',
  `ship_delivery_way` float NOT NULL DEFAULT '1' COMMENT '送货上门-配送距离',
  `ship_express_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递-快递费',
  `content` text NOT NULL COMMENT '套餐详情',
  `detail` text NOT NULL COMMENT '购买须知',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_package_goodstwo
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_package_goodstwo`;
CREATE TABLE `ims_mzhk_sun_package_goodstwo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '套餐包ID',
  `gid` int(11) NOT NULL COMMENT '商品ID',
  `lid` int(11) NOT NULL COMMENT '1普通，2砍价，3拼团，5抢购',
  `gname` varchar(20) NOT NULL COMMENT '商品名称',
  `price` decimal(11,2) NOT NULL COMMENT '核销价格',
  `img` varchar(200) NOT NULL COMMENT '图片',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1显示，2隐藏',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(5) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_package_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_package_order`;
CREATE TABLE `ims_mzhk_sun_package_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `ordernum` varchar(100) NOT NULL COMMENT '订单号',
  `pid` int(11) NOT NULL COMMENT '套餐包id',
  `pname` varchar(255) NOT NULL COMMENT '套餐包名称',
  `price` decimal(11,2) NOT NULL COMMENT '支付价钱',
  `uname` varchar(255) NOT NULL COMMENT '用户名称',
  `paytype` varchar(20) NOT NULL COMMENT '支付方式 1 微信支付 2 余额支付',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `addtime` varchar(20) NOT NULL COMMENT '下单时间',
  `paytime` varchar(20) NOT NULL COMMENT '支付时间',
  `canceltime` varchar(20) NOT NULL COMMENT '核销时间',
  `uid` int(11) NOT NULL COMMENT 'uid',
  `telNumber` varchar(20) NOT NULL COMMENT '电话',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，0已取消，1未支付，2已支付，3待收货，4已完成',
  `out_trade_no` varchar(100) NOT NULL COMMENT '支付外部订单号',
  `out_refund_no` varchar(100) NOT NULL COMMENT '退款外部订单号',
  `isrefund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款，3拒绝退款',
  `cityname` varchar(20) NOT NULL COMMENT '城市',
  `countyname` varchar(20) NOT NULL COMMENT '区域',
  `provincename` varchar(20) NOT NULL COMMENT '省份',
  `detailinfo` varchar(100) NOT NULL COMMENT '地址',
  `uremark` varchar(100) NOT NULL COMMENT '备注',
  `name` varchar(20) NOT NULL COMMENT '用户名',
  `sincetype` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_package_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_package_set`;
CREATE TABLE `ims_mzhk_sun_package_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `navname` varchar(50) NOT NULL DEFAULT '套餐包' COMMENT '顶部名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_package_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_package_type`;
CREATE TABLE `ims_mzhk_sun_package_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `twoname` varchar(50) NOT NULL COMMENT '分类简介',
  `color` varchar(50) NOT NULL COMMENT '背景颜色',
  `font_color` varchar(50) NOT NULL COMMENT '字体颜色',
  `img` varchar(255) NOT NULL COMMENT '缩略图',
  `pic` text NOT NULL COMMENT '轮播图',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1显示，2隐藏',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(5) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_ad
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_ad`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COMMENT '广告标题',
  `logo` varchar(100) DEFAULT NULL COMMENT '图片',
  `url` varchar(100) DEFAULT NULL COMMENT '外部链接',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `time` varchar(50) DEFAULT NULL COMMENT '时间',
  `uniacid` int(11) DEFAULT NULL COMMENT '模块名',
  `type` int(11) DEFAULT NULL COMMENT '类型',
  `state` int(11) DEFAULT NULL COMMENT '跳转路径选择',
  `src` varchar(100) DEFAULT NULL COMMENT '内部链接',
  `xcx_name` varchar(20) DEFAULT NULL COMMENT '关联小程序',
  `appid` varchar(100) DEFAULT NULL COMMENT '关联小程序appid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_addnews
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_addnews`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_addnews` (
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
-- Table structure for ims_mzhk_sun_plugin_lottery_address
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_address`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_address` (
  `adid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '收货人',
  `telNumber` varchar(30) NOT NULL COMMENT '收件人号码',
  `countyName` varchar(100) NOT NULL COMMENT '区',
  `detailAddr` varchar(100) NOT NULL COMMENT '详细地址',
  `isDefault` varchar(11) DEFAULT '0',
  `uid` varchar(55) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `provinceName` varchar(100) NOT NULL COMMENT '省',
  `cityName` varchar(100) NOT NULL COMMENT '市',
  `postalCode` int(11) DEFAULT NULL COMMENT '邮政编码',
  `detailInfo` varchar(100) DEFAULT NULL COMMENT '详细情况',
  `oid` int(11) DEFAULT NULL COMMENT '关联订单',
  PRIMARY KEY (`adid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_audit
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_audit`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_balance
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_balance`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) DEFAULT NULL,
  `money` decimal(11,2) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '状态，是否处理，0未处理',
  `wx` varchar(50) DEFAULT NULL COMMENT '微信号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_banner`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(200) CHARACTER SET utf8 NOT NULL,
  `url` varchar(300) NOT NULL COMMENT '文章图片',
  `lb_imgs` varchar(500) NOT NULL COMMENT '文章那个内容',
  `uniacid` int(11) NOT NULL,
  `bname1` varchar(200) NOT NULL,
  `bname2` varchar(200) NOT NULL,
  `bname3` varchar(200) NOT NULL,
  `lb_imgs1` varchar(500) CHARACTER SET utf8 NOT NULL,
  `lb_imgs2` varchar(500) NOT NULL,
  `lb_imgs3` varchar(500) NOT NULL,
  `url1` varchar(300) NOT NULL,
  `url2` varchar(300) NOT NULL,
  `url3` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_circle
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_circle`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_circle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `content` text COMMENT '文章内容',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发布时间',
  `img` text COMMENT '图片',
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `uname` varchar(20) DEFAULT NULL,
  `uphone` varchar(20) DEFAULT NULL,
  `addr` varchar(200) DEFAULT NULL,
  `longitude` varchar(200) DEFAULT NULL,
  `latitude` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_circle_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ims_mzhk_sun_plugin_lottery_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_code
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_code`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `invuid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_content
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_content`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(200) DEFAULT NULL COMMENT '评论内容',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cid` int(11) DEFAULT NULL COMMENT '所评论的文章ID',
  `uid` int(11) DEFAULT NULL COMMENT '评论用户',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `uid` (`uid`),
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_content_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `ims_mzhk_sun_plugin_lottery_circle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_content_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `ims_mzhk_sun_plugin_lottery_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_daily
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_daily`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_daily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_daily_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `ims_mzhk_sun_plugin_lottery_gifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_gifts
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_gifts`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_gifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(50) DEFAULT NULL COMMENT '礼物名',
  `lottery` varchar(200) DEFAULT NULL COMMENT '简介',
  `price` decimal(11,2) DEFAULT NULL COMMENT '价钱',
  `content` text COMMENT '详情',
  `uniacid` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` int(11) DEFAULT NULL COMMENT '类型',
  `status` int(11) DEFAULT NULL COMMENT '状态',
  `pic` text COMMENT '图片',
  `sid` int(11) DEFAULT '0',
  `count` int(11) DEFAULT NULL COMMENT '库存',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_giftsbanner
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_giftsbanner`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_giftsbanner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(200) CHARACTER SET utf8 NOT NULL,
  `url` varchar(300) NOT NULL COMMENT '文章图片',
  `lb_imgs` varchar(500) NOT NULL COMMENT '文章那个内容',
  `uniacid` int(11) NOT NULL,
  `bname1` varchar(200) NOT NULL,
  `bname2` varchar(200) NOT NULL,
  `bname3` varchar(200) NOT NULL,
  `lb_imgs1` varchar(500) CHARACTER SET utf8 NOT NULL,
  `lb_imgs2` varchar(500) NOT NULL,
  `lb_imgs3` varchar(500) NOT NULL,
  `url1` varchar(300) NOT NULL,
  `url2` varchar(300) NOT NULL,
  `url3` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_goods`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_goods` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `gname` text CHARACTER SET gbk COMMENT '抽奖名称/红包金额',
  `count` varchar(45) CHARACTER SET gbk DEFAULT NULL COMMENT '数量',
  `selftime` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '加入时间',
  `pic` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '封面图',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `sid` int(11) DEFAULT NULL COMMENT '赞助商id',
  `cid` int(11) DEFAULT NULL COMMENT '抽奖类型',
  `status` int(11) DEFAULT '2' COMMENT '抽奖状态',
  `uniacid` int(11) DEFAULT NULL,
  `condition` int(11) DEFAULT NULL COMMENT '开奖条件，0为按时间，1按人数，2手动，3现场',
  `accurate` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '开奖条件，填写准确时间，人数',
  `endtime` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '结束时间',
  `lottery` text,
  `zuid` int(11) DEFAULT NULL COMMENT '指定人中奖ID',
  `giftId` int(11) DEFAULT NULL COMMENT '关联礼物ID',
  `code_img` mediumblob COMMENT '小程序码二进制',
  `img` text,
  `paidprice` decimal(11,2) DEFAULT NULL COMMENT '付费抽奖费用',
  `password` varchar(50) DEFAULT NULL COMMENT '参与口令',
  `group` int(11) DEFAULT NULL COMMENT '组团抽奖人数',
  `codenum` int(11) DEFAULT NULL COMMENT '抽奖码总数',
  `codemost` int(11) DEFAULT NULL COMMENT '每人可获取最多数量',
  `codecount` int(11) DEFAULT NULL COMMENT '须分享几次获取一个抽奖码',
  `codeway` int(2) DEFAULT NULL,
  `onename` varchar(50) DEFAULT NULL COMMENT '一等奖名称',
  `onenum` int(11) DEFAULT NULL COMMENT '一等奖数量',
  `twoname` varchar(50) DEFAULT NULL COMMENT '二等奖名称',
  `twonum` int(11) DEFAULT NULL COMMENT '二等奖数量',
  `threename` varchar(50) DEFAULT NULL COMMENT '三等奖名称',
  `threenum` int(11) DEFAULT NULL COMMENT '三等奖数量',
  `state` int(2) DEFAULT NULL COMMENT '高级抽奖类型，1为付费，2为口令，3为组团，4为抽奖码',
  `one` int(2) DEFAULT NULL COMMENT '1为开启一二三等奖，2为不开启',
  `isbuy` int(2) DEFAULT '2' COMMENT '1购买商品后才可抽奖，2为皆可',
  `isshow` int(2) DEFAULT '0' COMMENT '1展示，2不展示',
  `showbrand` varchar(200) DEFAULT NULL COMMENT '商家ID',
  PRIMARY KEY (`gid`),
  KEY `giftId` (`giftId`),
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_goods_ibfk_1` FOREIGN KEY (`giftId`) REFERENCES `ims_mzhk_sun_plugin_lottery_gifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='点击 ';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_goodsdaily
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_goodsdaily`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_goodsdaily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_goodsdaily_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `ims_mzhk_sun_plugin_lottery_goods` (`gid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_goodslottery
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_goodslottery`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_goodslottery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `gid` int(11) NOT NULL COMMENT '黑卡商品ID',
  `ggid` int(11) NOT NULL COMMENT '黑卡大抽奖商品ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_goodspi
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_goodspi`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_goodspi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_group
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_group`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `invuid` int(11) DEFAULT NULL COMMENT '团长ID',
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_help
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_help`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `answer` varchar(200) DEFAULT NULL COMMENT '回答',
  `uniacid` int(11) DEFAULT NULL COMMENT '模块名',
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_in
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_in`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(11) DEFAULT NULL COMMENT '期限',
  `money` varchar(50) DEFAULT NULL COMMENT '价格',
  `uniacid` int(11) DEFAULT NULL COMMENT '模块名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_money
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_money`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `recharge` decimal(50,2) DEFAULT NULL,
  `youhui` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_order`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_order` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) NOT NULL COMMENT '订单号',
  `status` varchar(255) DEFAULT '1' COMMENT '1 待开奖，2中奖，3没有中奖',
  `time` varchar(150) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `adid` int(100) DEFAULT NULL COMMENT '地址表id',
  `state` int(11) DEFAULT '1' COMMENT '是否已转赠',
  `type` int(11) DEFAULT NULL COMMENT '1为付费，2为口令，3为组团，4为抽奖码',
  `one` int(2) DEFAULT NULL COMMENT '0非，1为一等奖，2为二等奖，3为三等奖',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_praise
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_praise`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_praise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL COMMENT '点赞文章的ID',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `uid` (`uid`),
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_praise_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ims_mzhk_sun_plugin_lottery_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_praise_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `ims_mzhk_sun_plugin_lottery_circle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_selectedtype
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_selectedtype`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_selectedtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tname` varchar(45) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `img` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_settab
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_settab`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_settab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `imgs` varchar(100) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '2底部，1首页',
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_setting
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_setting`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `appid` varchar(255) NOT NULL,
  `appsecret` varchar(255) DEFAULT NULL,
  `mch_id` varchar(255) DEFAULT NULL,
  `key` varchar(512) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `recharge_btn` varchar(255) DEFAULT NULL,
  `recharge_img` varchar(255) DEFAULT NULL,
  `register_img` varchar(255) DEFAULT NULL,
  `is_sms` tinyint(3) unsigned DEFAULT '0',
  `sms_info` varchar(255) DEFAULT NULL,
  `is_printer` tinyint(3) unsigned DEFAULT '0',
  `copyright` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_sms
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_sms`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(100) NOT NULL,
  `tpl_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '2',
  `tid1` varchar(50) NOT NULL,
  `tid2` varchar(50) NOT NULL,
  `tid3` varchar(50) NOT NULL,
  `qitui` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_sponsorship
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_sponsorship`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_sponsorship` (
  `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT '赞助商id',
  `sname` text COMMENT '赞助商名',
  `synopsis` text COMMENT '简介',
  `content` text COMMENT '详情',
  `address` text COMMENT '地址',
  `phone` text,
  `wx` text COMMENT '联系人微信号',
  `logo` varchar(200) DEFAULT NULL COMMENT 'LOGO',
  `ewm_logo` varchar(200) DEFAULT NULL COMMENT '二维码',
  `time` varchar(200) DEFAULT NULL COMMENT '添加时间',
  `day` int(11) DEFAULT NULL COMMENT '天数',
  `endtime` varchar(200) DEFAULT NULL COMMENT '结束时间',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '关联用户ID',
  `pwd` varchar(50) DEFAULT NULL COMMENT '后台登录密码',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_sponsortext
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_sponsortext`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_sponsortext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_support
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_support`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '团队名称',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `logo` varchar(255) DEFAULT NULL COMMENT 'LOGO',
  `uniacid` int(11) DEFAULT NULL,
  `condition` int(11) DEFAULT NULL COMMENT '联系方式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_system`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_system` (
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
  `fontcolor` varchar(20) DEFAULT NULL,
  `color` varchar(20) NOT NULL,
  `tz_appid` varchar(30) NOT NULL,
  `tz_name` varchar(30) NOT NULL,
  `pt_name` varchar(30) NOT NULL COMMENT '平台名称',
  `tz_audit` int(11) NOT NULL DEFAULT '0' COMMENT '红包手续费',
  `sj_audit` int(11) NOT NULL COMMENT '商家审核0.是 1否',
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
  `is_sjrz` int(4) NOT NULL DEFAULT '2',
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
  `is_vipcardopen` int(4) NOT NULL DEFAULT '1',
  `is_jkopen` int(4) NOT NULL DEFAULT '1',
  `address` varchar(150) DEFAULT NULL COMMENT '店铺地址',
  `sj_ruzhu` int(5) DEFAULT NULL COMMENT '0为关闭1为开启',
  `is_kanjiaopen` int(4) DEFAULT '0' COMMENT '0关闭1开启',
  `bargain_price` varchar(10) DEFAULT NULL COMMENT '每次砍价的%',
  `sign` varchar(12) DEFAULT NULL COMMENT '本店招牌自定义',
  `bargain_title` varchar(15) DEFAULT NULL COMMENT '砍价分享标题',
  `is_pintuanopen` int(4) DEFAULT NULL COMMENT '2为关闭1为开启',
  `refund` int(4) DEFAULT '1' COMMENT '1为买家申请2为自动退款',
  `refund_time` int(4) DEFAULT '0' COMMENT '自动退款时间 1为24；2为48；3为72；4为活动结束；5为不退款',
  `groups_title` varchar(45) DEFAULT NULL COMMENT '拼团分享标题',
  `mask` int(2) DEFAULT '1' COMMENT '0不显示1显示',
  `is_couponopen` int(4) DEFAULT '2' COMMENT '1为开启2为关闭',
  `support_font` varchar(25) DEFAULT NULL,
  `support_logo` varchar(255) DEFAULT NULL,
  `support_tel` varchar(40) DEFAULT NULL,
  `psopen` int(2) DEFAULT '0',
  `is_open_pop` int(2) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL,
  `auto_logo` varchar(100) DEFAULT NULL,
  `manu_logo` varchar(100) DEFAULT NULL,
  `gift_logo` varchar(100) DEFAULT NULL,
  `auto_logo1` varchar(100) DEFAULT NULL,
  `manu_logo1` varchar(100) DEFAULT NULL,
  `cj_name` varchar(20) DEFAULT NULL,
  `dt_name` varchar(20) DEFAULT NULL,
  `cj_logo` varchar(100) DEFAULT NULL,
  `cjzt` varchar(100) DEFAULT NULL,
  `dt_logo` varchar(100) DEFAULT NULL,
  `discount` decimal(11,2) DEFAULT NULL,
  `paidprice` decimal(11,2) DEFAULT NULL COMMENT '付费抽奖价格',
  `passwordprice` decimal(11,2) DEFAULT NULL COMMENT '口令抽奖价格',
  `growpprice` decimal(11,2) DEFAULT NULL COMMENT '组团抽奖价格',
  `codeprice` decimal(11,2) DEFAULT NULL COMMENT '抽奖码价格',
  `oneprice` decimal(11,2) DEFAULT NULL COMMENT '抽奖码价格',
  `senior` int(2) DEFAULT NULL COMMENT '高级抽奖开关',
  `instructions` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_type`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL COMMENT '类型',
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `url` int(11) DEFAULT NULL,
  `img` varchar(500) DEFAULT NULL,
  `url2` int(11) DEFAULT NULL,
  `img2` varchar(500) DEFAULT NULL,
  `url3` int(11) DEFAULT NULL,
  `img3` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_user`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` varchar(100) DEFAULT NULL COMMENT 'openid',
  `img` varchar(200) DEFAULT NULL COMMENT '头像',
  `time` datetime DEFAULT NULL COMMENT '登录时间',
  `uniacid` int(11) DEFAULT NULL,
  `money` decimal(11,2) DEFAULT '0.00',
  `user_name` varchar(30) DEFAULT NULL,
  `user_tel` int(11) DEFAULT NULL,
  `user_address` varchar(200) DEFAULT NULL,
  `commission` decimal(11,0) DEFAULT NULL,
  `state` int(4) DEFAULT '1',
  `attention` varchar(255) DEFAULT NULL,
  `fans` varchar(255) DEFAULT NULL,
  `collection` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_userformid
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_userformid`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  `gid` int(11) DEFAULT NULL COMMENT '关联的项目id',
  `state` int(11) DEFAULT NULL COMMENT '发起用户为1，参与用户为2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='formid表';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_lottery_withdrawal
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_lottery_withdrawal`;
CREATE TABLE `ims_mzhk_sun_plugin_lottery_withdrawal` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_address
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_address`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `province` varchar(60) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `zip` varchar(60) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `postalcode` varchar(20) DEFAULT NULL,
  `default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '默认地址',
  `lottery` tinyint(4) NOT NULL DEFAULT '0' COMMENT '抽奖收货地址',
  `add_time` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='地址';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_article
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_article`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `icon_vertical` varchar(255) DEFAULT NULL COMMENT '竖向图标',
  `show_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '首页展示类型 1竖向 2横向',
  `url` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL COMMENT '音频',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数',
  `state` tinyint(4) DEFAULT '0',
  `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在首页',
  `show_task` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在任务',
  `publish_time` int(11) DEFAULT NULL COMMENT '发布时间',
  `add_time` int(11) DEFAULT NULL,
  `tg_time` int(11) DEFAULT NULL,
  `jj_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_bargainrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_bargainrecord`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_bargainrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `bargain_openid` varchar(60) DEFAULT NULL COMMENT '砍价用户',
  `bargain_score` int(11) DEFAULT NULL COMMENT '砍价积分',
  `add_time` int(11) DEFAULT NULL COMMENT '砍价时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价记录';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_customize
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_customize`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_customize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2营销案图标 3底部图标',
  `title` varchar(255) DEFAULT NULL COMMENT '标题名称',
  `pic` varchar(200) DEFAULT NULL COMMENT '图标图片',
  `clickago_icon` varchar(200) DEFAULT NULL COMMENT '点击前图标',
  `clickafter_icon` varchar(200) DEFAULT NULL COMMENT '点击后图标',
  `url_type` tinyint(4) DEFAULT NULL COMMENT '链接类型 1基本 2商品分类',
  `url` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `url_name` varchar(50) DEFAULT NULL COMMENT '链接名称',
  `sort` tinyint(4) DEFAULT NULL COMMENT '排序 越大越前',
  `add_time` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='自定义';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_goods`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `lid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1积分商品 2抽奖商品',
  `title` varchar(200) DEFAULT NULL COMMENT '商品名',
  `pic` varchar(200) DEFAULT NULL COMMENT '展示图',
  `lb_pics` text COMMENT '轮播图',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '价值',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '价值总积分',
  `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '可砍积分',
  `min_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最小积分',
  `max_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最大积分',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `sale_num` int(11) NOT NULL DEFAULT '0' COMMENT '已兑换',
  `begin_time` int(11) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `content` text COMMENT '详情',
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='积分商城商品表';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_lotteryprize
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_lotteryprize`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_lotteryprize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型  1积分商城物品 2积分 3谢谢参与',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT 'type为1时 使用',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT 'type为2时使用',
  `pic` varchar(200) DEFAULT NULL,
  `rate` int(11) NOT NULL DEFAULT '0' COMMENT '中奖概率',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '奖品数量',
  `zj_num` int(11) NOT NULL DEFAULT '0' COMMENT '中奖数量',
  `add_time` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='奖品';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_order`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `lid` int(11) NOT NULL DEFAULT '0' COMMENT '1积分商城订单 2抽奖订单',
  `openid` varchar(60) DEFAULT NULL,
  `orderformid` varchar(60) DEFAULT NULL COMMENT '订单号',
  `gid` int(11) DEFAULT NULL,
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `order_score` int(11) NOT NULL DEFAULT '0' COMMENT '消费的积分(兑换的积分)',
  `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '砍价多少积分',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '兑换状态 支付状态 1支付兑换',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未兑换  1已支付(待发货) 3完成',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `wc_time` int(11) DEFAULT NULL COMMENT '完成时间',
  `fahuo_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `add_time` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `province` varchar(60) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `zip` varchar(60) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `postalcode` varchar(20) DEFAULT NULL,
  `express_delivery` varchar(60) DEFAULT NULL COMMENT '物流公司',
  `express_no` varchar(60) DEFAULT NULL COMMENT '物流单号',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `lottery_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型1积分商品实物 2积分 ',
  `lotteryprize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_readrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_readrecord`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_readrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '类型 1文章阅读记录  2文章马克记录 3邀请阅读记录 4邀请新用户记录',
  `article_id` int(11) DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `invited_openid` varchar(60) DEFAULT NULL COMMENT '邀请用户',
  `is_mark` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1收藏 0取消收藏',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='阅读记录';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_system`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_system` (
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
  `fontcolor` varchar(20) DEFAULT NULL,
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
  `is_vipcardopen` int(4) NOT NULL DEFAULT '1',
  `is_jkopen` int(4) NOT NULL DEFAULT '1',
  `address` varchar(150) DEFAULT NULL COMMENT '店铺地址',
  `sj_ruzhu` int(5) DEFAULT NULL COMMENT '0为关闭1为开启',
  `is_kanjiaopen` int(4) DEFAULT '0' COMMENT '0关闭1开启',
  `bargain_price` varchar(10) DEFAULT NULL COMMENT '每次砍价的%',
  `sign` varchar(12) DEFAULT NULL COMMENT '本店招牌自定义',
  `bargain_title` varchar(15) DEFAULT NULL COMMENT '砍价分享标题',
  `is_pintuanopen` int(4) DEFAULT NULL COMMENT '2为关闭1为开启',
  `refund` int(4) DEFAULT '1' COMMENT '1为买家申请2为自动退款',
  `refund_time` int(4) DEFAULT '0' COMMENT '自动退款时间 1为24；2为48；3为72；4为活动结束；5为不退款',
  `groups_title` varchar(45) DEFAULT NULL COMMENT '拼团分享标题',
  `mask` int(2) DEFAULT '1' COMMENT '0不显示1显示',
  `announcement` varchar(60) DEFAULT NULL COMMENT '首页公告',
  `shopmsg_status` tinyint(1) DEFAULT NULL COMMENT '欢迎语开关',
  `shopmsg` varchar(60) DEFAULT NULL COMMENT '欢迎语',
  `shopmsg2` varchar(60) DEFAULT NULL COMMENT '问题咨询',
  `shopmsg_img` varchar(200) DEFAULT NULL COMMENT '欢迎头像',
  `is_yuyueopen` int(4) DEFAULT NULL COMMENT '开启预约 1开启 2禁用',
  `yuyue_title` varchar(60) DEFAULT NULL COMMENT '预约分享标题',
  `is_haowuopen` int(4) DEFAULT NULL COMMENT '开启好物',
  `haowu_title` varchar(60) DEFAULT NULL COMMENT '好物分享标题',
  `is_couponopen` int(4) DEFAULT NULL COMMENT '开启优惠券 1开启 2禁用',
  `coupon_title` varchar(60) DEFAULT NULL COMMENT '分享优惠券标题',
  `coupon_banner` varchar(200) DEFAULT NULL COMMENT '优惠券banner',
  `is_gywmopen` int(4) DEFAULT NULL COMMENT '开启关于我们',
  `gywm_title` varchar(60) DEFAULT NULL COMMENT '分享关于我们标题',
  `is_xianshigouopen` int(4) DEFAULT NULL COMMENT '开启限时购 1开启 ',
  `xianshigou_title` varchar(60) DEFAULT NULL COMMENT '分享限时购标题',
  `is_shareopen` int(4) DEFAULT NULL COMMENT '开启分享 1开启',
  `share_title` varchar(60) DEFAULT NULL COMMENT '分享分享标题',
  `customer_time` varchar(30) DEFAULT NULL COMMENT '客服时间',
  `provide` varchar(255) DEFAULT NULL COMMENT '基础服务',
  `shop_banner` text COMMENT '商店banner',
  `shop_details` text COMMENT '商店介绍',
  `gywm_banner` varchar(200) DEFAULT NULL COMMENT '关于我们banner',
  `shopdes` text COMMENT '商店介绍 详情',
  `shopdes_img` text COMMENT '商店介绍图',
  `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费',
  `ziti_address` varchar(200) DEFAULT NULL COMMENT '商家自提地址',
  `ddmd_img` varchar(100) DEFAULT NULL COMMENT '到店买单头像',
  `ddmd_title` varchar(100) DEFAULT NULL COMMENT '到店买单商户名称',
  `hx_openid` text COMMENT '核销人员openid',
  `tag` varchar(200) DEFAULT NULL COMMENT '店铺标签',
  `is_by` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否全店包邮',
  `is_xxpf` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否先行赔付',
  `is_qtwy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否七天无忧退款退货',
  `yuyue_sort` int(11) NOT NULL DEFAULT '0' COMMENT '预约 首页推荐排序',
  `haowu_sort` int(11) NOT NULL DEFAULT '0' COMMENT '好物 首页推荐排序',
  `groups_sort` int(11) NOT NULL DEFAULT '0' COMMENT '拼团 首页推荐排序',
  `bargain_sort` int(11) NOT NULL DEFAULT '0' COMMENT '砍价 首页推荐排序',
  `xianshigou_sort` int(11) NOT NULL DEFAULT '0' COMMENT '限时购首页推荐 排序',
  `share_sort` int(11) NOT NULL DEFAULT '0' COMMENT '分享首页推荐排序',
  `xinpin_sort` int(11) NOT NULL DEFAULT '0' COMMENT '新品 首页推荐排序',
  `index_adv_img` varchar(100) DEFAULT NULL COMMENT '首页广告图',
  `is_adv` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启首页广告 1开启',
  `share_rule` text COMMENT '分享金规则',
  `groups_rule` text COMMENT '拼团规则说明',
  `coordinates` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `index_title` varchar(60) DEFAULT NULL COMMENT '首页自定义标题',
  `hz_tel` varchar(60) DEFAULT NULL COMMENT '首页合作电话',
  `jszc_img` varchar(200) DEFAULT NULL COMMENT '技术支持头像',
  `jszc_tdcp` varchar(200) DEFAULT NULL COMMENT '首页技术支持团队出品',
  `index_layout` text COMMENT '首页布局',
  `is_layout` tinyint(4) DEFAULT '0' COMMENT '首页布局开关 1开',
  `is_techzhichi` tinyint(4) NOT NULL DEFAULT '1',
  `store_open` tinyint(4) NOT NULL DEFAULT '1',
  `lottery_score` int(11) NOT NULL DEFAULT '0' COMMENT '抽奖消费积分',
  `lottery_rule` text COMMENT '抽奖规则',
  `aboutus` text COMMENT '关于我们',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_task
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_task`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '任务类型 1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖 6马克 7邀请好友',
  `title` varchar(60) DEFAULT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `task_num` int(11) NOT NULL DEFAULT '1' COMMENT '任务数',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '积分完成一个任务得到积分',
  `task_score` int(11) NOT NULL DEFAULT '0' COMMENT '任务页面显示积分',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='任务表';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_taskrecord
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_taskrecord`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_taskrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL COMMENT '用户openid(获得积分的用户)',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖(增加) 6马克 7邀请新用户 8兑换积分商品 9积分抽奖(消耗) 10抽奖中奖积分',
  `task_id` int(11) NOT NULL DEFAULT '0',
  `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '获得积分',
  `date` varchar(20) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL COMMENT '文章id 阅读和邀请看文章使用 马克',
  `beinvited_openid` varchar(60) DEFAULT NULL COMMENT '被邀请用户openid 邀请看文章使用 、好友砍积分使用、新用户',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品id 砍价积分商品使用 ',
  `prize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='任务积分记录表 ';

-- ----------------------------
-- Table structure for ims_mzhk_sun_plugin_scoretask_taskset
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_plugin_scoretask_taskset`;
CREATE TABLE `ims_mzhk_sun_plugin_scoretask_taskset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `task_type` tinyint(4) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='任务积分设置';

-- ----------------------------
-- Table structure for ims_mzhk_sun_popbanner
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_popbanner`;
CREATE TABLE `ims_mzhk_sun_popbanner` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pop_title` varchar(50) NOT NULL COMMENT '弹窗名称',
  `pop_urltype` tinyint(2) NOT NULL DEFAULT '1' COMMENT '弹窗链接类别',
  `pop_urltxt` int(11) NOT NULL COMMENT '相关 id',
  `pop_img` varchar(200) NOT NULL COMMENT '弹窗图',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(11) NOT NULL COMMENT '排序',
  `position` int(5) NOT NULL DEFAULT '1' COMMENT '1弹窗，2首页轮播（默认主题），3砍价列表，4集卡列表，5抢购列表，6拼团列表，7免单列表，8营销图标，9底部导航，10广告1（主题2），10广告2（主题2）',
  `unselectimg` varchar(255) DEFAULT NULL COMMENT '未选中图标',
  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1显示，0不显示',
  `vice_pop_title` varchar(100) NOT NULL COMMENT '副标题，用于主题4',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_ptgroups
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_ptgroups`;
CREATE TABLE `ims_mzhk_sun_ptgroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupordernum` varchar(50) NOT NULL COMMENT '团单号，非订单号',
  `detailinfo` varchar(200) DEFAULT NULL COMMENT '地址',
  `telnumber` varchar(100) DEFAULT NULL COMMENT '电话',
  `money` decimal(10,2) DEFAULT NULL COMMENT '总价',
  `status` tinyint(2) DEFAULT '2' COMMENT '1 取消订单，2待支付，3已支付，4待发货，5已完成',
  `openid` varchar(150) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(11) DEFAULT NULL,
  `countyname` varchar(150) DEFAULT NULL COMMENT '区域',
  `provincename` varchar(150) DEFAULT NULL COMMENT '省份',
  `name` varchar(100) DEFAULT NULL COMMENT '名字',
  `addtime` int(11) DEFAULT NULL COMMENT '加入的时间',
  `cityname` varchar(100) DEFAULT NULL COMMENT '城市',
  `uremark` varchar(100) DEFAULT NULL,
  `sincetype` varchar(100) DEFAULT NULL,
  `paytime` int(11) DEFAULT '0' COMMENT '付款时间',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `gname` varchar(200) NOT NULL COMMENT '商品名称',
  `is_lead` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否团长，1是，0不是',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `shiptime` int(11) NOT NULL COMMENT '发货时间',
  `out_trade_no` varchar(100) DEFAULT NULL COMMENT '外部订单号',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型，0拼团，1单独购买',
  `endtime` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '数量为1',
  `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费',
  `isrefund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款',
  `goodsimg` varchar(200) NOT NULL COMMENT '商品图',
  `bid` int(11) NOT NULL COMMENT '商家id',
  `bname` varchar(100) NOT NULL COMMENT '商家名称',
  `shipnum` varchar(50) NOT NULL COMMENT '快递单号',
  `shipname` varchar(50) NOT NULL COMMENT '快递名称',
  `finishtime` int(11) NOT NULL COMMENT '结束时间',
  `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号',
  `expirationtime` int(11) NOT NULL COMMENT '核销过期时间',
  `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用',
  `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id',
  `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额',
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台',
  `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id',
  `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0非套餐，1套餐',
  `packageoid` int(11) NOT NULL COMMENT '套餐订单ID',
  `packageid` int(11) NOT NULL COMMENT '套餐ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_ptorders
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_ptorders`;
CREATE TABLE `ims_mzhk_sun_ptorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '拼团id',
  `gid` int(11) DEFAULT NULL COMMENT '商品的id',
  `openid` varchar(100) DEFAULT NULL COMMENT '团长用户的id',
  `addtime` int(11) DEFAULT NULL COMMENT '生成时间',
  `uniacid` int(11) DEFAULT NULL,
  `is_ok` tinyint(2) DEFAULT '0' COMMENT '是否成功拼团，1成功，0未成功，2取消关闭',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '拼团价格',
  `buynum` int(11) NOT NULL DEFAULT '0' COMMENT '拼团人数，实际购买人数',
  `ordernum` varchar(100) NOT NULL COMMENT '拼团总单号',
  `gname` varchar(200) NOT NULL COMMENT '商品名称',
  `peoplenum` int(11) NOT NULL DEFAULT '0' COMMENT '参与该团人数，包括未付款',
  `groupuser_id` varchar(100) DEFAULT NULL COMMENT '成功参与拼团会员id',
  `groupuser_img` text COMMENT '成功参与拼团会员头像',
  `endtime` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `neednum` int(11) NOT NULL DEFAULT '0' COMMENT '需要人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_qgformid
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_qgformid`;
CREATE TABLE `ims_mzhk_sun_qgformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `gid` int(11) NOT NULL COMMENT '开抢提醒商品id',
  `formId` varchar(100) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `addtime` varchar(100) NOT NULL COMMENT '添加时间',
  `open_tips` int(11) NOT NULL DEFAULT '0' COMMENT '开启抢购提醒 0 不开启 1 已开启',
  `istips` int(11) NOT NULL DEFAULT '0' COMMENT '是否已提醒 0 未提醒 1 已提醒',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_qgorder
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_qgorder`;
CREATE TABLE `ims_mzhk_sun_qgorder` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) NOT NULL COMMENT '订单号',
  `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址',
  `telNumber` varchar(100) DEFAULT NULL COMMENT '电话',
  `money` decimal(10,2) DEFAULT NULL COMMENT '总价',
  `status` tinyint(2) DEFAULT '2' COMMENT '1 取消订单，2待支付，3待发货，4已支付，5已完成',
  `openid` varchar(150) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(11) DEFAULT NULL,
  `countyName` varchar(150) DEFAULT NULL COMMENT '区域',
  `provinceName` varchar(150) DEFAULT NULL COMMENT '省份',
  `name` varchar(100) DEFAULT NULL COMMENT '名字',
  `addtime` int(11) DEFAULT '0' COMMENT '加入的时间',
  `cityName` varchar(100) DEFAULT NULL COMMENT '城市',
  `uremark` varchar(100) DEFAULT NULL,
  `sincetype` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `paytime` int(11) NOT NULL COMMENT '付款时间',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `gname` varchar(200) NOT NULL COMMENT '商品名称',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '购买数量',
  `out_trade_no` varchar(200) DEFAULT NULL COMMENT '外部订单id',
  `ordertype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型，0普通，1抢购，2拼团，3砍价',
  `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费',
  `goodsimg` varchar(200) NOT NULL COMMENT '商品图',
  `bid` int(11) NOT NULL COMMENT '商家id',
  `bname` varchar(200) NOT NULL COMMENT '商家名称',
  `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款',
  `shipname` varchar(50) NOT NULL COMMENT '快递名称',
  `shipnum` varchar(50) NOT NULL COMMENT '快递单号',
  `shiptime` int(11) NOT NULL COMMENT '发货时间',
  `finishtime` int(11) NOT NULL COMMENT '结束时间',
  `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号',
  `expirationtime` int(11) NOT NULL COMMENT '核销过期时间',
  `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `haswrittenoffnum` int(11) NOT NULL COMMENT '已核销数',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用',
  `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id',
  `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额',
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台',
  `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id',
  `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0非套餐，1套餐',
  `packageoid` int(11) NOT NULL COMMENT '套餐订单ID',
  `packageid` int(11) NOT NULL COMMENT '套餐ID',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_qgorderlist
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_qgorderlist`;
CREATE TABLE `ims_mzhk_sun_qgorderlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `openid` varbinary(100) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `createTime` varchar(100) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_rebate
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_rebate`;
CREATE TABLE `ims_mzhk_sun_rebate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `rebatetype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '返利形式 1 百分比 2 固定金额',
  `rebatemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返利金额',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '订单类型 1普通 2砍价 3拼团 5抢购',
  `oid` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否结算 0 否 1 结算',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_rechargecard
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_rechargecard`;
CREATE TABLE `ims_mzhk_sun_rechargecard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '给个标题好查看',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `lessmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0不启用，1启用',
  `sort` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_rechargelogo
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_rechargelogo`;
CREATE TABLE `ims_mzhk_sun_rechargelogo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `rc_id` int(11) NOT NULL COMMENT '充值卡id',
  `uniacid` int(11) NOT NULL COMMENT '应用id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `addmoney` decimal(10,2) NOT NULL COMMENT '充值卡赠送的金额',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `rtype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0普通充值，1充值卡，2购买会员，3订单付款，4订单退款,5分销提现，6购买优惠券',
  `out_trade_no` varchar(200) NOT NULL COMMENT '外部订单号',
  `memo` text NOT NULL COMMENT '备注',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `returnsign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买会员赠送标识 0 非赠送 1 赠送',
  `viplogid` int(11) NOT NULL DEFAULT '0' COMMENT '会员订单id',
  `vipid` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_redpacket_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_redpacket_goods`;
CREATE TABLE `ims_mzhk_sun_redpacket_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `rname` varchar(100) NOT NULL,
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `allowmoney` int(11) NOT NULL DEFAULT '0',
  `snum` int(11) NOT NULL DEFAULT '0',
  `gnum` tinyint(1) NOT NULL DEFAULT '0',
  `rec` tinyint(1) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `rday` int(11) NOT NULL DEFAULT '1',
  `application` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '255',
  `addtime` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `sharenum` int(11) NOT NULL DEFAULT '1',
  `goodsapplication` tinyint(1) NOT NULL DEFAULT '0',
  `umoneytype` int(11) NOT NULL DEFAULT '0',
  `unionmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_redpacket_relation
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_redpacket_relation`;
CREATE TABLE `ims_mzhk_sun_redpacket_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `application` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `lid` int(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_redpacket_relation2
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_redpacket_relation2`;
CREATE TABLE `ims_mzhk_sun_redpacket_relation2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `goodsapplication` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `lid` int(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_redpacket_relation3
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_redpacket_relation3`;
CREATE TABLE `ims_mzhk_sun_redpacket_relation3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `rid` int(11) NOT NULL DEFAULT '0',
  `bid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_redpacket_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_redpacket_set`;
CREATE TABLE `ims_mzhk_sun_redpacket_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `open_redpacket` tinyint(1) NOT NULL DEFAULT '0',
  `explain` varchar(100) NOT NULL,
  `open_redpacket1` tinyint(1) NOT NULL DEFAULT '0',
  `open_redpacket2` tinyint(1) NOT NULL DEFAULT '0',
  `open_redpacket3` tinyint(1) NOT NULL DEFAULT '0',
  `open_redpacket4` tinyint(1) NOT NULL DEFAULT '0',
  `explain1` text NOT NULL,
  `explain2` text NOT NULL,
  `source` tinyint(1) NOT NULL DEFAULT '0',
  `usource` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_redpacket_union
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_redpacket_union`;
CREATE TABLE `ims_mzhk_sun_redpacket_union` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `ustime` varchar(50) NOT NULL,
  `uetime` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) DEFAULT '255',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_redpacket_urelation
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_redpacket_urelation`;
CREATE TABLE `ims_mzhk_sun_redpacket_urelation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `addtime` varchar(100) NOT NULL,
  `gnum` tinyint(1) NOT NULL DEFAULT '0',
  `oid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_redpacket_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_redpacket_user`;
CREATE TABLE `ims_mzhk_sun_redpacket_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `rname` varchar(100) NOT NULL,
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addtime` varchar(100) NOT NULL,
  `overtime` varchar(100) NOT NULL,
  `allowmoney` int(11) NOT NULL DEFAULT '0',
  `gnum` tinyint(1) NOT NULL DEFAULT '0',
  `rid` int(11) NOT NULL DEFAULT '0',
  `bid` int(11) NOT NULL DEFAULT '0',
  `fbid` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `isuse` tinyint(1) NOT NULL DEFAULT '0',
  `usetime` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `oid` int(11) NOT NULL DEFAULT '0',
  `lid` int(11) NOT NULL DEFAULT '0',
  `orid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `umoneytype` int(11) NOT NULL DEFAULT '0',
  `unionmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_sms
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_sms`;
CREATE TABLE `ims_mzhk_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(100) NOT NULL,
  `tpl_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
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
  `jh_code` varchar(100) NOT NULL COMMENT '聚合短信验证',
  `dy_code` varchar(100) NOT NULL COMMENT '大鱼短信验证',
  `xiaoshentui` varchar(255) NOT NULL COMMENT '小神推',
  `qitui` text NOT NULL COMMENT '奇推信息',
  `tid5` varchar(50) DEFAULT NULL COMMENT '开抢提醒',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_specialtopic
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_specialtopic`;
CREATE TABLE `ims_mzhk_sun_specialtopic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `seenum` int(11) NOT NULL COMMENT '查看数量',
  `commentnum` int(11) NOT NULL COMMENT '评论数量',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `introduction` varchar(255) NOT NULL COMMENT '简介',
  `likenum` int(11) NOT NULL COMMENT '点赞数',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(5) NOT NULL DEFAULT '255' COMMENT '排序',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶，0不置顶，1置顶',
  `img` varchar(255) NOT NULL COMMENT '缩略图片',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `bid` int(11) NOT NULL COMMENT '门店id',
  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1显示，0不显示',
  `state` int(11) NOT NULL DEFAULT '1' COMMENT '列表显示 图片为1，视频为2',
  `video_img` varchar(100) NOT NULL COMMENT '视频封面图',
  `video` varchar(200) NOT NULL COMMENT '列表视频',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_stlike
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_stlike`;
CREATE TABLE `ims_mzhk_sun_stlike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `addtime` int(11) NOT NULL COMMENT '点赞时间',
  `stid` int(11) NOT NULL COMMENT '专题id',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_storecate
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_storecate`;
CREATE TABLE `ims_mzhk_sun_storecate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL COMMENT '店铺分类名称',
  `store_img` varchar(200) NOT NULL COMMENT '店铺分类图',
  `sort` int(5) NOT NULL COMMENT '排序',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_storefacility
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_storefacility`;
CREATE TABLE `ims_mzhk_sun_storefacility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(50) NOT NULL COMMENT '设施名称',
  `selectedimg` varchar(200) NOT NULL COMMENT '选中图',
  `unselectedimg` varchar(200) NOT NULL COMMENT '未选中图',
  `sort` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_storelimit
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_storelimit`;
CREATE TABLE `ims_mzhk_sun_storelimit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lt_id` int(11) NOT NULL DEFAULT '0' COMMENT '入驻期限类别id',
  `lt_name` varchar(30) NOT NULL COMMENT '入驻期限类别名称',
  `lt_day` int(5) NOT NULL COMMENT '入驻期限类别天数',
  `uniacid` int(11) NOT NULL COMMENT '应用id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '入驻价格',
  `sort` int(5) NOT NULL COMMENT '排序',
  `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启',
  `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1百分比，2固定金额',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_storelimittype
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_storelimittype`;
CREATE TABLE `ims_mzhk_sun_storelimittype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lt_name` varchar(50) NOT NULL COMMENT '期限名',
  `lt_day` int(5) NOT NULL COMMENT '期限天数',
  `uniacid` int(11) NOT NULL COMMENT '应用id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_subcard_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_subcard_goods`;
CREATE TABLE `ims_mzhk_sun_subcard_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `bid` int(11) NOT NULL DEFAULT '0',
  `cateid` int(11) NOT NULL DEFAULT '0',
  `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subcardprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `num` int(11) NOT NULL DEFAULT '0',
  `virtualnum` int(11) NOT NULL DEFAULT '0',
  `stocktype` int(11) NOT NULL DEFAULT '0',
  `canrefund` int(11) NOT NULL DEFAULT '0',
  `limitnum` int(11) NOT NULL DEFAULT '0',
  `tid` int(11) NOT NULL DEFAULT '0',
  `is_vip` int(11) NOT NULL DEFAULT '0',
  `vipprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `astime` varchar(100) NOT NULL,
  `antime` varchar(100) NOT NULL,
  `expirationtime` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '255',
  `index_img` varchar(100) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `index3_img` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `daynum` int(11) NOT NULL DEFAULT '0',
  `monthnum` int(11) NOT NULL DEFAULT '0',
  `minnum` int(11) NOT NULL DEFAULT '0',
  `maxnum` int(11) NOT NULL DEFAULT '0',
  `months` int(11) NOT NULL DEFAULT '0',
  `writenums` int(11) NOT NULL DEFAULT '0',
  `firstwnums` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `addtime` varchar(100) NOT NULL,
  `lb_imgs` varchar(200) NOT NULL,
  `buynum` int(11) NOT NULL DEFAULT '0',
  `pnums` int(11) NOT NULL DEFAULT '0',
  `pname` varchar(50) NOT NULL,
  `distribution_open` tinyint(1) NOT NULL DEFAULT '0',
  `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gcateid` int(11) NOT NULL DEFAULT '0',
  `lid` int(11) NOT NULL DEFAULT '12',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_subcard_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_subcard_order`;
CREATE TABLE `ims_mzhk_sun_subcard_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `ordernum` varchar(100) NOT NULL,
  `telnumber` varchar(50) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '2',
  `openid` varchar(100) NOT NULL,
  `addtime` varchar(100) NOT NULL,
  `gid` int(11) NOT NULL DEFAULT '0',
  `gname` varchar(200) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '0',
  `goodsimg` varchar(100) NOT NULL,
  `bid` int(11) NOT NULL DEFAULT '0',
  `expirationtime` varchar(100) NOT NULL,
  `paytype` varchar(100) NOT NULL COMMENT '֧',
  `cateid` int(11) NOT NULL DEFAULT '0',
  `paytime` varchar(100) NOT NULL,
  `out_trade_no` varchar(100) NOT NULL COMMENT '֧',
  `out_refund_no` varchar(100) NOT NULL,
  `isrefund` tinyint(1) NOT NULL DEFAULT '0',
  `haswrittenoffnum` int(11) NOT NULL DEFAULT '0',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0',
  `sub_mch_id` varchar(255) NOT NULL,
  `subcardprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vipprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pnums` int(11) NOT NULL DEFAULT '0',
  `finishtime` varchar(100) NOT NULL,
  `bname` varchar(100) NOT NULL,
  `uremark` varchar(100) NOT NULL,
  `parent_id_1` int(11) NOT NULL,
  `parent_id_2` int(11) NOT NULL,
  `parent_id_3` int(11) NOT NULL,
  `rid` int(11) NOT NULL DEFAULT '0',
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `source` tinyint(1) NOT NULL DEFAULT '0',
  `fbid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_subcard_scate
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_subcard_scate`;
CREATE TABLE `ims_mzhk_sun_subcard_scate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `scatename` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '255',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_subcard_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_subcard_set`;
CREATE TABLE `ims_mzhk_sun_subcard_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `opensubcard` tinyint(1) NOT NULL DEFAULT '0',
  `listimgs` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_system`;
CREATE TABLE `ims_mzhk_sun_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `appid` varchar(100) DEFAULT NULL COMMENT 'appid',
  `appsecret` varchar(200) DEFAULT NULL COMMENT 'appsecret',
  `mchid` varchar(100) DEFAULT NULL COMMENT '商户号',
  `wxkey` varchar(250) DEFAULT NULL COMMENT '商户秘钥',
  `uniacid` int(11) DEFAULT NULL,
  `url_name` varchar(20) DEFAULT NULL COMMENT '网址名称',
  `details` text COMMENT '关于我们',
  `url_logo` varchar(100) DEFAULT NULL COMMENT '网址logo',
  `bq_name` varchar(50) DEFAULT NULL COMMENT '版权名称',
  `link_name` varchar(30) DEFAULT NULL COMMENT '网站名称',
  `link_logo` varchar(100) DEFAULT NULL COMMENT '网站logo',
  `support` varchar(20) DEFAULT NULL COMMENT '技术支持',
  `bq_logo` varchar(100) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL COMMENT '颜色',
  `tz_appid` varchar(50) DEFAULT NULL,
  `tz_name` varchar(50) DEFAULT NULL,
  `pt_name` varchar(100) DEFAULT NULL COMMENT '平台名称',
  `tz_audit` int(11) DEFAULT NULL COMMENT '帖子审核1.是 2否',
  `sj_audit` int(11) DEFAULT NULL COMMENT '商家审核1.是 2否',
  `cityname` varchar(20) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `client_ip` varchar(100) DEFAULT NULL,
  `apiclient_key` varchar(100) DEFAULT NULL,
  `apiclient_cert` varchar(100) DEFAULT NULL,
  `fontcolor` varchar(100) DEFAULT NULL,
  `ptnum` int(11) DEFAULT NULL,
  `hk_logo` varchar(150) DEFAULT NULL,
  `hk_tubiao` varchar(150) DEFAULT NULL,
  `store_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1开启，0关闭，默认开启',
  `store_in_notice` text NOT NULL COMMENT '商家入驻须知',
  `tech_title` varchar(50) NOT NULL COMMENT '技术支持名称',
  `tech_img` varchar(100) NOT NULL COMMENT '技术支持logo',
  `tech_phone` varchar(50) NOT NULL COMMENT '技术支持电话',
  `is_show_tech` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不显示，1显示',
  `is_open_pop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0关闭首页弹窗，1开启首页弹窗',
  `hk_bgimg` varchar(100) DEFAULT NULL COMMENT '黑卡背景图',
  `hk_namecolor` varchar(20) DEFAULT NULL COMMENT '黑卡名称颜色',
  `showcheck` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1过审页面，0正常页面',
  `wxappletscode` varchar(200) NOT NULL COMMENT '小程序码',
  `tab_navdata` text NOT NULL COMMENT '底部菜单数据',
  `hk_userrules` text NOT NULL COMMENT '黑卡会员规则',
  `version` varchar(30) NOT NULL COMMENT '小程序版本号',
  `wg_title` varchar(255) DEFAULT NULL COMMENT '福利群标题',
  `wg_directions` varchar(255) DEFAULT NULL COMMENT '福利群说明',
  `wg_img` varchar(255) DEFAULT NULL COMMENT '福利群图标',
  `wg_keyword` varchar(255) DEFAULT NULL COMMENT '福利群加群关键字',
  `showgw` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否显示，0不显示，1显示',
  `wg_addicon` varchar(255) DEFAULT NULL COMMENT '福利群加群关键字',
  `is_open_circle` tinyint(1) NOT NULL DEFAULT '0' COMMENT '圈子0不审核，1审核',
  `hometheme` tinyint(5) NOT NULL DEFAULT '0' COMMENT '首页主题',
  `is_homeshow_circle` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否在首页显示，1显示，0不显示',
  `offlinefee` float NOT NULL DEFAULT '0' COMMENT '线下付款手续费',
  `home_circle_name` varchar(255) NOT NULL DEFAULT '晒单啦' COMMENT '风格2首页显示晒单内容',
  `store_in_name` varchar(255) NOT NULL DEFAULT '商家入驻' COMMENT '商家入驻名',
  `hk_mytitle` varchar(255) NOT NULL COMMENT '我的页面黑卡营销标题（我的页面风格2）',
  `hk_mybgimg` varchar(255) NOT NULL COMMENT '我的页面黑卡背景图（我的页面风格2）',
  `mytheme` tinyint(5) NOT NULL DEFAULT '0' COMMENT '我的页面主题设置',
  `loginimg` varchar(255) NOT NULL COMMENT '商家后台登陆logo',
  `isopen_recharge` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0关闭，1开启',
  `isany_money_recharge` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0关闭，1开启',
  `showorderset` text NOT NULL COMMENT '展示订单设置',
  `openblackcard` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启黑卡，1开启，0不开启',
  `developkey` varchar(100) NOT NULL COMMENT '腾讯地图key',
  `openaddress` int(10) NOT NULL DEFAULT '0' COMMENT '是否开启区域 0 否  1 是',
  `opencity` int(10) NOT NULL DEFAULT '0' COMMENT '是否定位到市 0 否  1 是',
  `opentel` int(10) NOT NULL DEFAULT '0' COMMENT '是否开启手机号码授权 0 否  1 是',
  `code_type` int(11) NOT NULL DEFAULT '0' COMMENT '获取抽奖码方式 0 不开启 1 分享点击获取 2 分享购买获取',
  `open_num` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启每日砍价次数 0 否 1 是',
  `day_num` int(11) NOT NULL DEFAULT '0' COMMENT '每日砍价次数',
  `open_friend` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启每日帮同一好友砍价次数 0 否 1 是',
  `friend_num` int(11) NOT NULL DEFAULT '0' COMMENT '帮同一好友砍价次数',
  `money_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认支付金额比例',
  `score_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认兑换积分比例',
  `goodspicbg` varchar(100) NOT NULL COMMENT '商品海报背景图',
  `buyvipset` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启微信支付到余额 0 否 1 是',
  `isbusiness` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示工商信息 0 否 1 是',
  `license` text NOT NULL COMMENT '营业执照',
  `icplicense` text NOT NULL COMMENT 'ICP许可证',
  `agreement` text NOT NULL COMMENT '服务协议',
  `policy` text NOT NULL COMMENT '隐私政策',
  `wxcode_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商家收款启用小程序码 0 否 1 是',
  `allow_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许商家自己开启关店和打烊',
  `firstorder_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启首购减 0 否 1 是',
  `firstorder` tinyint(1) NOT NULL DEFAULT '1' COMMENT '首购减类型 1 百分比 2 固定金额',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额',
  `rebate_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启商家返利 0否 1是',
  `rebatetype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '返利类型 1百分比 2固定金额',
  `rebatemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返利金额',
  `ordernum` int(11) NOT NULL DEFAULT '0' COMMENT '多少单后开始返利',
  `grebate_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商品参与返利 0 部分商品 1 全部商品',
  `open_payment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用线下付 0 关闭 1启用',
  `myicon` varchar(100) NOT NULL COMMENT '普通订单图标',
  `mypticon` varchar(100) NOT NULL COMMENT '我的拼团图标',
  `mykjicon` varchar(100) NOT NULL COMMENT '砍价订单图标',
  `myjkicon` varchar(100) NOT NULL COMMENT '集卡订单图标',
  `myqgicon` varchar(100) NOT NULL COMMENT '抢购订单图标',
  `mymdicon` varchar(100) NOT NULL COMMENT '我的免单图标',
  `myyhqicon` varchar(100) NOT NULL COMMENT '我的优惠券图标',
  `mycticon` varchar(100) NOT NULL COMMENT '我的吃探图标',
  `myfxicon` varchar(100) NOT NULL COMMENT '分销中心图标',
  `myjficon` varchar(100) NOT NULL COMMENT '积分任务图标',
  `mylbqicon` varchar(100) NOT NULL COMMENT '裂变券图标',
  `myhbicon` varchar(100) NOT NULL COMMENT '福袋图标',
  `myckicon` varchar(100) NOT NULL COMMENT '次卡图标',
  `myckicon2` varchar(100) NOT NULL COMMENT '次卡订单图标',
  `myqyicon` varchar(100) NOT NULL COMMENT '权益图标',
  `myqyicon2` varchar(100) NOT NULL COMMENT '权益订单图标',
  `mytcicon` varchar(100) NOT NULL COMMENT '套餐图标',
  `mytcicon2` varchar(100) NOT NULL COMMENT '套餐订单图标',
  `mycjicon` varchar(100) NOT NULL COMMENT '抽奖图标',
  `mycjicon2` varchar(100) NOT NULL COMMENT '抽奖订单图标',
  `mypsicon` varchar(100) NOT NULL COMMENT '配送订单图标',
  `subheading` varchar(100) NOT NULL COMMENT '主题4首页副标题',
  `topbg` varchar(20) NOT NULL COMMENT '主题4顶部背景色',
  `mytext` varchar(50) NOT NULL COMMENT '普通订单文字',
  `mypttext` varchar(50) NOT NULL COMMENT '我的拼团文字',
  `mykjtext` varchar(50) NOT NULL COMMENT '砍价订单文字',
  `myjktext` varchar(50) NOT NULL COMMENT '集卡订单文字',
  `myqgtext` varchar(50) NOT NULL COMMENT '抢购订单文字',
  `mymdtext` varchar(50) NOT NULL COMMENT '我的免单文字',
  `myyhqtext` varchar(50) NOT NULL COMMENT '我的优惠券文字',
  `mycttext` varchar(50) NOT NULL COMMENT '我的吃探文字',
  `myfxtext` varchar(50) NOT NULL COMMENT '分销中心文字',
  `myjftext` varchar(50) NOT NULL COMMENT '积分任务文字',
  `mylbqtext` varchar(50) NOT NULL COMMENT '裂变券文字',
  `myhbtext` varchar(50) NOT NULL COMMENT '福袋文字',
  `mycktext` varchar(50) NOT NULL COMMENT '次卡文字',
  `mycktext2` varchar(50) NOT NULL COMMENT '次卡订单文字',
  `myqytext` varchar(50) NOT NULL COMMENT '权益文字',
  `myqytext2` varchar(50) NOT NULL COMMENT '权益订单文字',
  `mytctext` varchar(50) NOT NULL COMMENT '套餐文字',
  `mytctext2` varchar(50) NOT NULL COMMENT '套餐订单文字',
  `mycjtext` varchar(50) NOT NULL COMMENT '抽奖文字',
  `mycjtext2` varchar(50) NOT NULL COMMENT '抽奖订单文字',
  `mypstext` varchar(50) NOT NULL COMMENT '配送订单文字',
  `openvirtual` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启虚拟数 0 不开启 1 开启',
  `snum` int(11) NOT NULL DEFAULT '0' COMMENT '满多少星级显示',
  `hk_mytopimg` varchar(255) NOT NULL COMMENT '我的页面顶部背景图（我的页面风格2）',
  `opennotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '主题3专题标题显示，1开启，0不开启',
  `opennotime` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示时间未开始商品 0 关闭 1 开启',
  `ispnumber` tinyint(1) NOT NULL DEFAULT '0' COMMENT '海报小程序码是否使用公众号二维码 0否，1是',
  `opensearch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '主题4首页是否显示搜索栏',
  `openrelease` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许商家自己发布商品 0 不允许 1 允许',
  `openexamine` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商家自己发布商品是否需要审核 0 不审核 1 审核',
  `is_show_tel` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示技术支持电话',
  `writeofftype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '核销时间类型 0 固定 1 动态',
  `myzsicon` varchar(100) NOT NULL COMMENT '我的赠送图标',
  `myzstext` varchar(50) NOT NULL COMMENT '我的赠送文字',
  `is_delivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送 0 关闭 1启用',
  `cappid` varchar(100) NOT NULL COMMENT '挚能云appid',
  `cappsecret` varchar(100) NOT NULL COMMENT '挚能云appsecret',
  `vipbcolor` varchar(50) NOT NULL COMMENT '购买会员页顶部背景色',
  `vip_bimg` varchar(100) NOT NULL COMMENT '购买会员页顶部背景图',
  `opennavtype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '首页顶部导航显示 0单行 1多行',
  `catetopbg` varchar(50) NOT NULL COMMENT '分类页颜色',
  `server_appid` varchar(255) NOT NULL COMMENT '微信分配的公众账号ID',
  `server_sub_mch_id` varchar(100) NOT NULL COMMENT '微信支付分配的子商户号',
  `is_open_server` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启服务商角色，1开启，0不开启',
  `is_open_server_submch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '启用商家子商户号，0不启用，1启用',
  `server_apiclient_cert` varchar(200) NOT NULL COMMENT '服务商证书',
  `server_apiclient_key` varchar(200) NOT NULL COMMENT '服务商证书key',
  `server_mchid` varchar(100) NOT NULL COMMENT '服务商商户号',
  `server_wxkey` varchar(255) NOT NULL COMMENT '服务商商户秘钥',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_tbbanner
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_tbbanner`;
CREATE TABLE `ims_mzhk_sun_tbbanner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lb_imgs` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `lb_imgs1` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `lb_imgs2` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `lb_imgs3` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `bname` varchar(110) CHARACTER SET utf8 DEFAULT NULL,
  `bname1` varchar(110) CHARACTER SET utf8 DEFAULT NULL,
  `bname2` varchar(110) CHARACTER SET utf8 DEFAULT NULL,
  `bname3` varchar(110) CHARACTER SET utf8 DEFAULT NULL,
  `lb_imgs4` varchar(200) CHARACTER SET utf8 NOT NULL,
  `bname4` varchar(110) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_mzhk_sun_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_user`;
CREATE TABLE `ims_mzhk_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `openid` varchar(100) DEFAULT NULL COMMENT 'openid',
  `img` varchar(200) DEFAULT NULL COMMENT '头像',
  `time` varchar(50) DEFAULT NULL COMMENT '登录时间',
  `uniacid` int(11) DEFAULT NULL,
  `money` decimal(11,2) DEFAULT '0.00',
  `name` varchar(101) CHARACTER SET utf8mb4 DEFAULT NULL,
  `uname` varchar(100) DEFAULT NULL,
  `addtime` varchar(50) DEFAULT NULL COMMENT '会员的添加的时间',
  `viptype` int(11) DEFAULT '0' COMMENT '会员登记',
  `endtime` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `telphone` varchar(20) NOT NULL COMMENT '手机号码',
  `parents_id` int(11) NOT NULL COMMENT '上级id',
  `parents_name` varchar(255) NOT NULL COMMENT '上级名称',
  `isvisit` int(11) DEFAULT '0' COMMENT '是否拉黑 0 否 1 是',
  `isnum` int(11) DEFAULT '0' COMMENT '是否验证 0 否 1 是',
  `isuname` int(11) DEFAULT '0' COMMENT '是否验证姓名 0 否 1 是',
  `spare_parents_id` int(11) NOT NULL COMMENT '备用上级id',
  `spare_parents_name` varchar(255) NOT NULL COMMENT '备用上级用户名',
  `integral` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM AUTO_INCREMENT=449 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_user_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_user_coupon`;
CREATE TABLE `ims_mzhk_sun_user_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(100) NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `vab` int(11) DEFAULT NULL COMMENT '优惠券名称，展示用',
  `type` tinyint(3) unsigned DEFAULT NULL COMMENT '优惠券类型（1:折扣 2:代金券）',
  `val` int(11) DEFAULT NULL COMMENT '功能',
  `createTime` varchar(50) DEFAULT NULL COMMENT '领取时间',
  `limitTime` varchar(50) DEFAULT NULL COMMENT '使用截止时间',
  `isUsed` tinyint(3) DEFAULT '0' COMMENT '是否使用',
  `useTime` varchar(50) DEFAULT '0' COMMENT '使用时间',
  `from` int(11) DEFAULT NULL COMMENT '优惠券来源（0:用户领取 1:充值赠送 2:支付赠送）',
  `uniacid` int(11) DEFAULT NULL,
  `out_trade_no` varchar(255) NOT NULL COMMENT '外部订单id',
  `ispay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支付',
  `paytype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0免费，1微信，2余额',
  `paytime` int(11) NOT NULL COMMENT '付款时间',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `fromuser` varchar(255) NOT NULL COMMENT '从哪来',
  `firstuser` varchar(255) NOT NULL COMMENT '第一个拥有优惠券的人',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用',
  `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  `returnsign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买会员赠送标识 0 非赠送 1 赠送',
  `viplogid` int(11) NOT NULL DEFAULT '0' COMMENT '会员订单id',
  `vipid` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_userformid
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_userformid`;
CREATE TABLE `ims_mzhk_sun_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='formid表';

-- ----------------------------
-- Table structure for ims_mzhk_sun_vcate
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_vcate`;
CREATE TABLE `ims_mzhk_sun_vcate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `vcatename` varchar(50) NOT NULL COMMENT '虚拟分类名称',
  `addtime` varchar(100) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_vip
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_vip`;
CREATE TABLE `ims_mzhk_sun_vip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '标题，展示用',
  `day` int(10) unsigned DEFAULT NULL COMMENT '时间',
  `price` decimal(10,2) unsigned DEFAULT NULL COMMENT '价格',
  `jihuoma` varchar(30) DEFAULT '0' COMMENT '激活码',
  `time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `prefix` varchar(50) NOT NULL COMMENT '前缀',
  `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启',
  `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1百分比，2固定金额',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  `money_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认支付金额比例',
  `score_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认兑换积分比例',
  `buyvipset` int(11) NOT NULL DEFAULT '0' COMMENT '购买会员福利 0 不开启 1 返还到余额 2 赠送优惠券 3 赠送普通商品',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '赠送优惠券id',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '赠送普通商品id',
  `returnmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返还金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_vipcode
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_vipcode`;
CREATE TABLE `ims_mzhk_sun_vipcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vipid` int(11) NOT NULL COMMENT 'vip种类id',
  `vc_code` varchar(100) NOT NULL COMMENT 'vip激活码',
  `vc_isuse` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未使用，1已使用',
  `vc_starttime` datetime NOT NULL COMMENT '使用开始时间',
  `vc_endtime` datetime NOT NULL COMMENT '过期时间',
  `uid` int(11) NOT NULL COMMENT '激活的用户id',
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员卡价格',
  `viptitle` varchar(100) NOT NULL COMMENT 'vip名称',
  `vipday` int(11) NOT NULL COMMENT '激活天数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_vippaylog
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_vippaylog`;
CREATE TABLE `ims_mzhk_sun_vippaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vipid` int(11) NOT NULL COMMENT '激活码类别id',
  `viptitle` varchar(50) NOT NULL COMMENT 'vip类别名称',
  `uniacid` int(11) NOT NULL COMMENT '标识id',
  `activetype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '激活类别，0激活码激活，1线上购买激活',
  `vc_code` varchar(100) NOT NULL COMMENT '激活码',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '激活时间',
  `openid` varchar(200) NOT NULL COMMENT 'openid',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员卡价格',
  `vipday` int(11) NOT NULL COMMENT 'vip天数',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '三级id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_virtualdata
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_virtualdata`;
CREATE TABLE `ims_mzhk_sun_virtualdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `usernum` int(11) NOT NULL DEFAULT '0' COMMENT '用户数',
  `goodsnum` int(11) NOT NULL DEFAULT '0' COMMENT '订单数',
  `vtime` varchar(100) NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_wechat_menus
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_wechat_menus`;
CREATE TABLE `ims_mzhk_sun_wechat_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `menuid` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `sex` tinyint(3) unsigned NOT NULL,
  `group_id` int(10) NOT NULL,
  `client_platform_type` tinyint(3) unsigned NOT NULL,
  `area` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `isdeleted` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `menuid` (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_mzhk_sun_wechat_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_wechat_set`;
CREATE TABLE `ims_mzhk_sun_wechat_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `wechat_appid` varchar(100) NOT NULL COMMENT '公众号appid',
  `wechat_appsecret` varchar(255) NOT NULL COMMENT '公众号appsecret',
  `wechat_token` varchar(255) NOT NULL COMMENT '令牌(Token)',
  `wechat_aeskey` varchar(255) NOT NULL COMMENT 'EncodingAESKey',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1开启，0关闭',
  `backcontent` varchar(255) NOT NULL COMMENT '公众号回复的内容，前面部分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_withdraw`;
CREATE TABLE `ims_mzhk_sun_withdraw` (
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
  `bname` varchar(100) NOT NULL COMMENT '提现商家名称',
  `wd_bankname` varchar(100) NOT NULL COMMENT '提现银行名称',
  `wd_fbankname` varchar(100) NOT NULL COMMENT '提现分行名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_withdrawset
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_withdrawset`;
CREATE TABLE `ims_mzhk_sun_withdrawset` (
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_write
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_write`;
CREATE TABLE `ims_mzhk_sun_write` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) NOT NULL COMMENT '订单id',
  `bid` int(11) NOT NULL COMMENT '商家id',
  `finishtime` varchar(50) NOT NULL DEFAULT '0' COMMENT '核销时间',
  `money` varchar(50) NOT NULL DEFAULT '0' COMMENT '核销金额',
  `haswrittenoffnum` int(11) NOT NULL DEFAULT '0' COMMENT '核销数',
  `ordertype` int(11) NOT NULL DEFAULT '0' COMMENT '订单类型 0 普通订单 1 抢购订单',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_wxappjump
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_wxappjump`;
CREATE TABLE `ims_mzhk_sun_wxappjump` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '跳转的小程序名',
  `pic` varchar(255) NOT NULL COMMENT '小程序图标',
  `appid` varchar(100) NOT NULL COMMENT '小程序appid',
  `path` varchar(255) NOT NULL COMMENT '跳转到的小程序页面',
  `position` tinyint(3) NOT NULL COMMENT '当前小程序点击位置',
  `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `addtime` int(11) NOT NULL COMMENT '增加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_mzhk_sun_youhui
-- ----------------------------
DROP TABLE IF EXISTS `ims_mzhk_sun_youhui`;
CREATE TABLE `ims_mzhk_sun_youhui` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
