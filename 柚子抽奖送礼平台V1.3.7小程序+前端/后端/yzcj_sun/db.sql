/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : weiqing

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-06-13 18:33:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ims_yzcj_sun_ad`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_ad`;
CREATE TABLE `ims_yzcj_sun_ad` (
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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_ad
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_addnews`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_addnews`;
CREATE TABLE `ims_yzcj_sun_addnews` (
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
-- Records of ims_yzcj_sun_addnews
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_address`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_address`;
CREATE TABLE `ims_yzcj_sun_address` (
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_address
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_audit`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_audit`;
CREATE TABLE `ims_yzcj_sun_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_audit
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_balance`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_balance`;
CREATE TABLE `ims_yzcj_sun_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) DEFAULT NULL,
  `money` decimal(11,2) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '状态，是否处理，0未处理',
  `wx` varchar(50) DEFAULT NULL COMMENT '微信号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_balance
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_banner`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_banner`;
CREATE TABLE `ims_yzcj_sun_banner` (
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of ims_yzcj_sun_banner
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_goods`;
CREATE TABLE `ims_yzcj_sun_goods` (
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
  `lottery` varchar(200) DEFAULT NULL,
  `zuid` int(11) DEFAULT NULL COMMENT '指定人中奖ID',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='点击 ';

-- ----------------------------
-- Records of ims_yzcj_sun_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_help`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_help`;
CREATE TABLE `ims_yzcj_sun_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `answer` varchar(200) DEFAULT NULL COMMENT '回答',
  `uniacid` int(11) DEFAULT NULL COMMENT '模块名',
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_help
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_in`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_in`;
CREATE TABLE `ims_yzcj_sun_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(11) DEFAULT NULL COMMENT '期限',
  `money` varchar(50) DEFAULT NULL COMMENT '价格',
  `uniacid` int(11) DEFAULT NULL COMMENT '模块名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_in
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_money`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_money`;
CREATE TABLE `ims_yzcj_sun_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `recharge` decimal(50,2) DEFAULT NULL,
  `youhui` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_money
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_order`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_order`;
CREATE TABLE `ims_yzcj_sun_order` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` varchar(50) NOT NULL COMMENT '订单号',
  `status` varchar(255) DEFAULT '1' COMMENT '1 待开奖，2中奖，3没有中奖',
  `time` varchar(150) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `adid` int(100) DEFAULT NULL COMMENT '地址表id',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_order
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_setting`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_setting`;
CREATE TABLE `ims_yzcj_sun_setting` (
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
-- Records of ims_yzcj_sun_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_sms`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_sms`;
CREATE TABLE `ims_yzcj_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(100) NOT NULL,
  `tpl_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '2',
  `tid1` varchar(50) NOT NULL,
  `tid2` varchar(50) NOT NULL,
  `tid3` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_sms
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_sponsorship`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_sponsorship`;
CREATE TABLE `ims_yzcj_sun_sponsorship` (
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
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_sponsorship
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_sponsortext`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_sponsortext`;
CREATE TABLE `ims_yzcj_sun_sponsortext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_sponsortext
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_support`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_support`;
CREATE TABLE `ims_yzcj_sun_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '团队名称',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `logo` varchar(255) DEFAULT NULL COMMENT 'LOGO',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_support
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_system`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_system`;
CREATE TABLE `ims_yzcj_sun_system` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_system
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_user`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_user`;
CREATE TABLE `ims_yzcj_sun_user` (
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
  `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_yzcj_sun_user
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_userformid`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_userformid`;
CREATE TABLE `ims_yzcj_sun_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  `gid` int(11) DEFAULT NULL COMMENT '关联的项目id',
  `state` int(11) DEFAULT NULL COMMENT '发起用户为1，参与用户为2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='formid表';

-- ----------------------------
-- Records of ims_yzcj_sun_userformid
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_yzcj_sun_withdrawal`
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzcj_sun_withdrawal`;
CREATE TABLE `ims_yzcj_sun_withdrawal` (
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
-- Records of ims_yzcj_sun_withdrawal
-- ----------------------------
