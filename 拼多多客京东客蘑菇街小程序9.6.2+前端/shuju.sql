/*
Navicat MySQL Data Transfer

Source Server         : yanshi
Source Server Version : 50557
Source Host           : 122.114.120.200:3306
Source Database       : yanshi

Target Server Type    : MYSQL
Target Server Version : 50557
File Encoding         : 65001

Date: 2019-08-20 04:24:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ims_hc_ad`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_ad`;
CREATE TABLE `ims_hc_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `appid` varchar(50) NOT NULL,
  `path` varchar(200) NOT NULL,
  `desc` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_ad
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_bonus`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_bonus`;
CREATE TABLE `ims_hc_bonus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` char(10) NOT NULL,
  `dealtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_bonus
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_address`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_address`;
CREATE TABLE `ims_hc_credit_shopping_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `realname` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `area` varchar(30) NOT NULL,
  `address` varchar(300) NOT NULL,
  `isdefault` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_address
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_adv`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_adv`;
CREATE TABLE `ims_hc_credit_shopping_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_enabled` (`enabled`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_adv
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_bi`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_bi`;
CREATE TABLE `ims_hc_credit_shopping_bi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `mid` int(10) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `headimg` varchar(255) DEFAULT NULL,
  `bi` decimal(10,2) DEFAULT NULL,
  `createtime` varchar(255) DEFAULT NULL,
  `updatetime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_bi
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_bi_log`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_bi_log`;
CREATE TABLE `ims_hc_credit_shopping_bi_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `bid` int(10) DEFAULT NULL,
  `mid` int(10) DEFAULT NULL,
  `bi` int(10) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '2表示人民币购买，3表示积分兑换',
  `createtime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_bi_log
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_cart`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_cart`;
CREATE TABLE `ims_hc_credit_shopping_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `goodsid` int(11) NOT NULL,
  `goodstype` tinyint(1) NOT NULL DEFAULT '1',
  `from_user` varchar(50) NOT NULL,
  `total` int(10) unsigned NOT NULL,
  `optionid` int(10) DEFAULT '0',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `idx_openid` (`from_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_category`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_category`;
CREATE TABLE `ims_hc_credit_shopping_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `thumb` varchar(255) NOT NULL COMMENT '分类图片',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `isrecommand` int(10) DEFAULT '0',
  `description` varchar(500) NOT NULL COMMENT '分类介绍',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_category
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_dispatch`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_dispatch`;
CREATE TABLE `ims_hc_credit_shopping_dispatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `dispatchname` varchar(50) DEFAULT '',
  `dispatchtype` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `firstprice` decimal(10,2) DEFAULT '0.00',
  `secondprice` decimal(10,2) DEFAULT '0.00',
  `firstweight` int(11) DEFAULT '0',
  `secondweight` int(11) DEFAULT '0',
  `express` int(11) DEFAULT '0',
  `description` text,
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_dispatch
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_feedback`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_feedback`;
CREATE TABLE `ims_hc_credit_shopping_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1为维权，2为告擎',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0未解决，1用户同意，2用户拒绝',
  `feedbackid` varchar(30) NOT NULL COMMENT '投诉单号',
  `transid` varchar(30) NOT NULL COMMENT '订单号',
  `reason` varchar(1000) NOT NULL COMMENT '理由',
  `solution` varchar(1000) NOT NULL COMMENT '期待解决方案',
  `remark` varchar(1000) NOT NULL COMMENT '备注',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_weid` (`weid`),
  KEY `idx_feedbackid` (`feedbackid`),
  KEY `idx_createtime` (`createtime`),
  KEY `idx_transid` (`transid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_goods`;
CREATE TABLE `ims_hc_credit_shopping_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `pcate` int(10) unsigned NOT NULL DEFAULT '0',
  `ccate` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1为实体，2为虚拟',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `unit` varchar(5) NOT NULL DEFAULT '',
  `description` varchar(1000) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `goodssn` varchar(50) NOT NULL DEFAULT '',
  `productsn` varchar(50) NOT NULL DEFAULT '',
  `marketprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `productprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `costprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `total` int(10) NOT NULL DEFAULT '0',
  `totalcnf` int(11) DEFAULT '0' COMMENT '0 拍下减库存 1 付款减库存 2 永久不减',
  `sales` int(10) unsigned NOT NULL DEFAULT '0',
  `spec` varchar(5000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit` int(11) DEFAULT '0',
  `maxbuy` int(11) DEFAULT '0',
  `hasoption` int(11) DEFAULT '0',
  `dispatch` int(11) DEFAULT '0',
  `thumb_url` text,
  `isnew` int(11) DEFAULT '0',
  `ishot` int(11) DEFAULT '0',
  `isdiscount` int(11) DEFAULT '0',
  `isrecommand` int(11) DEFAULT '0',
  `istime` int(11) DEFAULT '0',
  `timestart` int(11) DEFAULT '0',
  `timeend` int(11) DEFAULT '0',
  `viewcount` int(11) DEFAULT '0',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stock_total` int(10) DEFAULT NULL COMMENT '库存总量',
  `ticket_total` int(10) DEFAULT '0' COMMENT '已购买的商品数量',
  `goods_status` tinyint(1) DEFAULT '0' COMMENT '当已购买商品数量等于库存数量时为1，否则为0',
  `ticket` varchar(255) DEFAULT NULL,
  `ticket_time` varchar(20) DEFAULT NULL,
  `ticket_nickname` varchar(255) DEFAULT NULL,
  `usermaxbuy` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_goods_option`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_goods_option`;
CREATE TABLE `ims_hc_credit_shopping_goods_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `thumb` varchar(60) DEFAULT '',
  `productprice` decimal(10,2) DEFAULT '0.00',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  `costprice` decimal(10,2) DEFAULT '0.00',
  `stock` int(11) DEFAULT '0',
  `weight` decimal(10,2) DEFAULT '0.00',
  `displayorder` int(11) DEFAULT '0',
  `specs` text,
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodsid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_goods_option
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_goods_param`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_goods_param`;
CREATE TABLE `ims_hc_credit_shopping_goods_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `value` text,
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodsid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_goods_param
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_member`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_member`;
CREATE TABLE `ims_hc_credit_shopping_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `headimg` varchar(255) DEFAULT NULL,
  `createtime` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_member
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_order`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_order`;
CREATE TABLE `ims_hc_credit_shopping_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1取消状态，0普通状态，1为已付款，2为已发货，3为成功',
  `sendtype` tinyint(1) unsigned NOT NULL COMMENT '1为快递，2为自提',
  `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付',
  `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
  `goodstype` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remark` varchar(1000) NOT NULL DEFAULT '',
  `addressid` int(10) unsigned NOT NULL,
  `expresscom` varchar(30) NOT NULL DEFAULT '',
  `expresssn` varchar(50) NOT NULL DEFAULT '',
  `express` varchar(200) NOT NULL DEFAULT '',
  `goodsprice` decimal(10,2) DEFAULT '0.00',
  `dispatchprice` decimal(10,2) DEFAULT '0.00',
  `dispatch` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_order
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_order_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_order_goods`;
CREATE TABLE `ims_hc_credit_shopping_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `goodsid` int(10) unsigned NOT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `total` int(10) unsigned NOT NULL DEFAULT '1',
  `optionid` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  `optionname` text,
  `from_user` varchar(255) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_order_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_product`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_product`;
CREATE TABLE `ims_hc_credit_shopping_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goodsid` int(11) NOT NULL,
  `productsn` varchar(50) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `marketprice` decimal(10,0) unsigned NOT NULL,
  `productprice` decimal(10,0) unsigned NOT NULL,
  `total` int(11) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `spec` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_goodsid` (`goodsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_product
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_shai`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_shai`;
CREATE TABLE `ims_hc_credit_shopping_shai` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT NULL,
  `goodsid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `content` text,
  `img` varchar(255) DEFAULT NULL,
  `createtime` varchar(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_shai
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_spec`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_spec`;
CREATE TABLE `ims_hc_credit_shopping_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `displaytype` tinyint(3) unsigned NOT NULL,
  `content` text NOT NULL,
  `goodsid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_spec
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_spec_item`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_spec_item`;
CREATE TABLE `ims_hc_credit_shopping_spec_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `specid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `show` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_specid` (`specid`),
  KEY `indx_show` (`show`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_spec_item
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_credit_shopping_ticket`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_credit_shopping_ticket`;
CREATE TABLE `ims_hc_credit_shopping_ticket` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `memberid` int(10) DEFAULT NULL,
  `createtime` varchar(255) DEFAULT NULL,
  `orderid` int(10) DEFAULT NULL,
  `goodsid` varchar(255) DEFAULT NULL,
  `ticket` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_credit_shopping_ticket
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_dan`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_dan`;
CREATE TABLE `ims_hc_dan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `dan_id` int(11) NOT NULL,
  `season` tinyint(3) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `thumb` varchar(100) DEFAULT NULL,
  `win_star` tinyint(3) DEFAULT '0',
  `use_gold` int(11) DEFAULT '0',
  `win_gold` int(11) DEFAULT '0',
  `quesids` text NOT NULL,
  `reward` int(11) NOT NULL DEFAULT '0',
  `winexp` int(11) NOT NULL,
  `failexp` int(11) NOT NULL,
  `rewardnum` tinyint(3) NOT NULL DEFAULT '0',
  `border` varchar(200) NOT NULL,
  `createtime` char(10) DEFAULT NULL,
  `robot` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1开启',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_dan
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_formid`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_formid`;
CREATE TABLE `ims_hc_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `formid` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_formid
-- ----------------------------
INSERT INTO `ims_hc_formid` VALUES ('1', '1000', '1', '', '0');

-- ----------------------------
-- Table structure for `ims_hc_grade`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_grade`;
CREATE TABLE `ims_hc_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `levelno` int(11) NOT NULL,
  `levelname` varchar(20) NOT NULL,
  `levelexp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_grade
-- ----------------------------
INSERT INTO `ims_hc_grade` VALUES ('1', '1000', '1', '1', '1');
INSERT INTO `ims_hc_grade` VALUES ('2', '1000', '2', '2', '2');

-- ----------------------------
-- Table structure for `ims_hc_highguess_images`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_highguess_images`;
CREATE TABLE `ims_hc_highguess_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `wid` int(10) unsigned NOT NULL COMMENT '词条ID',
  `rid` int(10) unsigned NOT NULL,
  `mid` int(10) unsigned NOT NULL COMMENT '会员ID',
  `image` varchar(255) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_highguess_images
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_highguess_member`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_highguess_member`;
CREATE TABLE `ims_hc_highguess_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) DEFAULT NULL,
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `avatar` varchar(255) DEFAULT NULL,
  `realname` varchar(50) NOT NULL DEFAULT '',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_highguess_member
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_highguess_reply`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_highguess_reply`;
CREATE TABLE `ims_hc_highguess_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `description` text,
  `sharetitle` varchar(255) DEFAULT NULL,
  `sharecover` varchar(255) DEFAULT NULL,
  `sharedescription` text,
  `gzurl` varchar(255) DEFAULT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_highguess_reply
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_highguess_selectlog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_highguess_selectlog`;
CREATE TABLE `ims_hc_highguess_selectlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `wid` int(10) unsigned NOT NULL,
  `imgid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) DEFAULT NULL,
  `realname` varchar(50) NOT NULL DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  `word` varchar(20) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_highguess_selectlog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_highguess_words`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_highguess_words`;
CREATE TABLE `ims_hc_highguess_words` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `word` varchar(20) DEFAULT NULL,
  `words` varchar(100) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `isopen` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_highguess_words
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_order`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_order`;
CREATE TABLE `ims_hc_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `pid` int(11) DEFAULT '0',
  `ordersn` varchar(30) DEFAULT '',
  `formId` varchar(50) DEFAULT '',
  `fee` decimal(11,2) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `paystatus` tinyint(1) NOT NULL DEFAULT '0',
  `paytime` char(10) NOT NULL,
  `transid` varchar(50) DEFAULT '',
  `createtime` int(10) DEFAULT '0',
  `package` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_order
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_pk_log`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_pk_log`;
CREATE TABLE `ims_hc_pk_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `usegold` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `expe` int(11) NOT NULL,
  `scoreplus` int(11) NOT NULL,
  `goldplus` int(11) NOT NULL,
  `expeplus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_pk_log
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_pk_question`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_pk_question`;
CREATE TABLE `ims_hc_pk_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `answer` char(1) NOT NULL,
  `plus` int(5) DEFAULT '0',
  `score` int(5) DEFAULT '0',
  `min` int(11) NOT NULL,
  `right` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_pk_question
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_pk_record`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_pk_record`;
CREATE TABLE `ims_hc_pk_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `dan` int(11) NOT NULL,
  `userid_one` int(11) DEFAULT NULL,
  `userid_two` int(11) DEFAULT NULL,
  `userone_score` int(11) DEFAULT '0',
  `usertwo_score` int(11) DEFAULT '0',
  `questions` text NOT NULL,
  `status1` tinyint(1) NOT NULL DEFAULT '0',
  `status2` tinyint(1) NOT NULL DEFAULT '0',
  `createtime` char(10) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0' COMMENT '1好友对战',
  `leave` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1加入2开始3离开',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_pk_record
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_prop`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_prop`;
CREATE TABLE `ims_hc_prop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `thumb` varchar(200) DEFAULT NULL,
  `usethumb` varchar(200) NOT NULL,
  `newthumb` varchar(200) NOT NULL,
  `cc` int(4) NOT NULL DEFAULT '0',
  `sj` int(4) NOT NULL DEFAULT '0',
  `jb` int(4) NOT NULL DEFAULT '0',
  `jy` int(4) NOT NULL DEFAULT '0',
  `jf` int(11) NOT NULL,
  `give` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(50) NOT NULL,
  `price` decimal(11,2) DEFAULT '0.00',
  `type` tinyint(1) DEFAULT '0' COMMENT '默认普通物品',
  `shop` tinyint(1) NOT NULL DEFAULT '0',
  `dan` tinyint(1) NOT NULL,
  `randnum` tinyint(4) NOT NULL,
  `desc` varchar(200) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '50',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_prop
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_question`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_question`;
CREATE TABLE `ims_hc_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `question` varchar(100) DEFAULT NULL,
  `answer_a` varchar(100) DEFAULT NULL,
  `answer_b` varchar(100) DEFAULT NULL,
  `answer_c` varchar(100) NOT NULL,
  `answer_d` varchar(100) DEFAULT NULL,
  `easy` char(1) DEFAULT NULL,
  `answer` char(1) DEFAULT NULL,
  `createtime` char(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_question
-- ----------------------------
INSERT INTO `ims_hc_question` VALUES ('1', '1000', '2', '哪个肉好吃？', '天鹅', '娃娃鱼', '孔雀', '丹顶鹤', '1', 'A', '1559044087');
INSERT INTO `ims_hc_question` VALUES ('2', '1000', '2', '哪个好点着？', '酒精', '煤气', '汽油', '柴油', '1', 'B', '1559044087');

-- ----------------------------
-- Table structure for `ims_hc_question_type`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_question_type`;
CREATE TABLE `ims_hc_question_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `thumbs` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `upgrade` text NOT NULL,
  `desc1` varchar(200) NOT NULL,
  `desc2` varchar(200) NOT NULL,
  `createtime` char(10) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_question_type
-- ----------------------------
INSERT INTO `ims_hc_question_type` VALUES ('1', '1000', 'http://yanshi.suyituike.cn/addons/hc_answer/upload/201902201413546500.png', '11', '0', '', '11111', '1111', '1550643240', '1');
INSERT INTO `ims_hc_question_type` VALUES ('2', '1000', 'http://yanshi.suyituike.cn/addons/hc_answer/upload/201902201426417350.jpeg', '电脑', '1', '', '121', '2131', '1550644004', '1');

-- ----------------------------
-- Table structure for `ims_hc_season`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_season`;
CREATE TABLE `ims_hc_season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `no` int(11) NOT NULL DEFAULT '1',
  `name` varchar(20) NOT NULL,
  `starttime` char(10) NOT NULL,
  `endtime` char(10) NOT NULL,
  `createtime` char(10) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_season
-- ----------------------------
INSERT INTO `ims_hc_season` VALUES ('1', '1000', '1', '1', '1558493366', '1559270940', '1558493370', '0');

-- ----------------------------
-- Table structure for `ims_hc_setting`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_setting`;
CREATE TABLE `ims_hc_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `index` text NOT NULL,
  `basic` text NOT NULL,
  `ques` text NOT NULL,
  `follow` text NOT NULL,
  `forward` text NOT NULL,
  `notice` text NOT NULL,
  `sign` text NOT NULL,
  `tpl` text NOT NULL,
  `active` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_setting
-- ----------------------------
INSERT INTO `ims_hc_setting` VALUES ('1', '1000', '{\"0\":{\"img\":\"images\\/145\\/2019\\/03\\/oNw0m54zwtzwHhOhVRHVW5h5v0Mmn0.png\",\"link\":\"..\\/pages\\/goods\\/goods\",\"url\":\"\"},\"1\":{\"img\":\"images\\/145\\/2019\\/05\\/ENQtRzuQEXgLe9BQ9GLQbQtZx9qD9g.jpg\",\"link\":\"\",\"url\":\"\"},\"2\":{\"img\":\"\",\"link\":\"\",\"url\":\"\"},\"6\":{\"img\":\"\",\"link\":\"\",\"url\":\"\"},\"7\":{\"img\":\"\",\"link\":\"\",\"url\":\"\"},\"8\":{\"img\":\"\",\"link\":\"\",\"url\":\"\"},\"3\":{\"img\":\"images\\/145\\/2019\\/03\\/oNw0m54zwtzwHhOhVRHVW5h5v0Mmn0.png\",\"link\":\"..\\/passLevel\\/passLevel\",\"url\":\"\"},\"4\":{\"img\":\"images\\/145\\/2019\\/05\\/ENQtRzuQEXgLe9BQ9GLQbQtZx9qD9g.jpg\",\"link\":\"\",\"url\":\"\"},\"5\":{\"img\":\"\",\"link\":\"\",\"url\":\"\"},\"9\":{\"img\":\"\",\"link\":\"\",\"url\":\"\"},\"10\":{\"img\":\"\",\"link\":\"\",\"url\":\"\"},\"11\":{\"img\":\"\",\"link\":\"\",\"url\":\"\"}}', '{\"title\":\"\\u6d4b\\u8bd5\",\"contact\":\"\\u6d4b\\u8bd5\",\"worldtext\":\"\\u6d4b\\u8bd5\",\"firstgift\":\"\",\"loginimg\":\"\",\"answerimg\":\"\",\"shareimg\":\"\",\"indextopimg\":\"images\\/145\\/2019\\/05\\/ENQtRzuQEXgLe9BQ9GLQbQtZx9qD9g.jpg\",\"dantopimg\":\"\",\"knowledgetopimg\":\"\",\"matchingimg\":\"\",\"matchedimg\":\"\",\"indexbgm\":\"\",\"rankbgm\":\"\",\"kfinto\":\"\",\"wxgzhimg\":\"\",\"version\":\"\",\"maincolor\":\"\",\"fontcolor\":\"\",\"nicknamecolor\":\"\",\"goldbgcolor\":\"\",\"goldfontcolor\":\"\",\"jdbarcolor\":\"\",\"tabfontcolor\":\"\",\"rankbgcolor\":\"\",\"listbgcolor\":\"\",\"ansscorebarcolor\":\"\",\"ansscorebarbgcolor\":\"\",\"ansleftcolor\":\"\",\"ansrightcolor\":\"\",\"zssleftcolor\":\"\",\"zssrightcolor\":\"\",\"seasonbgimg\":\"\",\"anssuccessimg\":\"\",\"ansdrawimg\":\"\",\"owninfoimg\":\"\",\"ownpowerimg\":\"\",\"ownmoneyimg\":\"\",\"danintoimg\":\"\",\"inviteimg\":\"\",\"giveupimg\":\"\",\"gdbarimg\":\"\",\"starlevelimg\":\"\",\"avatarleftimg\":\"\",\"avatarrightimg\":\"\",\"pplineimg\":\"\",\"doublescoreimg\":\"\",\"questypeimg\":\"\",\"ranknumimg\":\"\",\"ownpowershareimg\":\"\",\"expeimg\":\"\",\"goldimg\":\"\"}', '{\"rebotrate\":\"\",\"match\":\"\",\"times\":\"\",\"descbgm\":\"\",\"secscore\":\"\",\"maxscore\":\"\",\"lastscore\":\"\",\"titlecolor\":\"\",\"quesnum\":\"\",\"rightmp3\":\"\",\"errormp3\":\"\"}', '{\"title\":\"\",\"img\":\"\",\"desc\":\"\",\"url\":\"\"}', '{\"title\":\"\",\"img\":\"\"}', '{\"switch\":\"1\",\"title\":\"\\u6d4b\\u8bd5\",\"content\":\"\\u4ece\"}', '[\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '{\"tk\":\"\",\"pk\":\"\",\"act\":\"\",\"red\":\"\"}', '{\"activename\":\"\",\"entry\":\"\",\"click\":\"\",\"reachimg\":\"\",\"reachtext\":\"\",\"unreachimg\":\"\",\"unreachtext\":\"\",\"truemoney\":\"\",\"money\":\"\",\"truepeople\":\"\",\"maxxnnum\":\"\",\"people\":\"\",\"xnnumstart\":\"\",\"moneytime\":\"\"}');

-- ----------------------------
-- Table structure for `ims_hc_shenhe`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_shenhe`;
CREATE TABLE `ims_hc_shenhe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `stact` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_shenhe
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_user`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user`;
CREATE TABLE `ims_hc_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `sessionkey` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `createtime` char(10) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  `robot` char(1) NOT NULL DEFAULT '0',
  `inans` char(1) NOT NULL DEFAULT '0',
  `border` varchar(100) NOT NULL,
  `moneycode` varchar(200) NOT NULL,
  `unionid` varchar(50) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user
-- ----------------------------
INSERT INTO `ims_hc_user` VALUES ('1', '1000', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erqiaY9Nw6dUtYF44CicN1GIEmBMFNx62icBhKhYReb5lQkfwojjOLGX598SZ9ta9UsnMshRE74BC87A/132', '荣林天下', 'ovD0V0TrYqLC5U1EIhvh7SQm9-M0', 'ZLflOteizJ811VxYNVD8og==', '1', '山东', '滨州', '中国', '1558492891', '1', '0', '0', '', '', '');

-- ----------------------------
-- Table structure for `ims_hc_user_cate`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_cate`;
CREATE TABLE `ims_hc_user_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `tid` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `plus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_cate
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_user_catelog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_catelog`;
CREATE TABLE `ims_hc_user_catelog` (
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `before` int(11) NOT NULL,
  `now` int(11) NOT NULL,
  `book` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `createtime` char(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_catelog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_user_forward`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_forward`;
CREATE TABLE `ims_hc_user_forward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `openGId` varchar(30) NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_forward
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_user_friends`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_friends`;
CREATE TABLE `ims_hc_user_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_friends
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_user_gold`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_gold`;
CREATE TABLE `ims_hc_user_gold` (
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0加1减',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0答题1分享',
  `addtime` char(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_gold
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_user_history`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_history`;
CREATE TABLE `ims_hc_user_history` (
  `uid` int(11) DEFAULT '0',
  `weid` int(11) DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(3) DEFAULT '1',
  `expe` int(11) DEFAULT '0',
  `dan` int(11) DEFAULT '1',
  `star` int(11) DEFAULT '0',
  `winrate` varchar(10) DEFAULT '0',
  `totalnum` int(11) DEFAULT '0',
  `winnum` int(11) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_history
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hc_user_info`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_info`;
CREATE TABLE `ims_hc_user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `weid` int(11) DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(3) DEFAULT '1',
  `expe` int(11) DEFAULT '0',
  `maxexpe` int(11) DEFAULT '0',
  `dan` int(11) DEFAULT '1',
  `star` int(11) DEFAULT '0',
  `gold` int(11) DEFAULT '0',
  `winrate` varchar(10) DEFAULT '0',
  `totalnum` int(11) DEFAULT '0',
  `winnum` int(11) DEFAULT '0',
  `jbtime` char(10) NOT NULL,
  `jbnum` int(11) NOT NULL,
  `jytime` char(10) NOT NULL,
  `jynum` int(11) NOT NULL,
  `jfnum` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_info
-- ----------------------------
INSERT INTO `ims_hc_user_info` VALUES ('1', '1', '1000', '0', '1', '0', '0', '1', '0', '0', '0', '0', '0', '', '0', '', '0', '0');

-- ----------------------------
-- Table structure for `ims_hc_user_prop`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_prop`;
CREATE TABLE `ims_hc_user_prop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `uid` int(11) NOT NULL,
  `pid` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0',
  `usenum` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_prop
-- ----------------------------
INSERT INTO `ims_hc_user_prop` VALUES ('1', '1000', '1', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `ims_hc_user_proplog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_proplog`;
CREATE TABLE `ims_hc_user_proplog` (
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `type` char(1) DEFAULT NULL COMMENT '1签到2充值3系统赠送4使用5开宝箱',
  `top` int(11) NOT NULL,
  `num` int(11) DEFAULT NULL,
  `createtime` char(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_proplog
-- ----------------------------
INSERT INTO `ims_hc_user_proplog` VALUES ('1000', '1', '0', '1', '0', '0', '1558492895');

-- ----------------------------
-- Table structure for `ims_hc_user_sign`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hc_user_sign`;
CREATE TABLE `ims_hc_user_sign` (
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `date` char(10) NOT NULL,
  `signtime` char(10) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hc_user_sign
-- ----------------------------
INSERT INTO `ims_hc_user_sign` VALUES ('1000', '1', '0', '1558454400', '1558492895', '0');

-- ----------------------------
-- Table structure for `ims_hcdoudou_address`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_address`;
CREATE TABLE `ims_hcdoudou_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `address` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`),
  KEY `weid` (`weid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_address
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_cash`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_cash`;
CREATE TABLE `ims_hcdoudou_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `transid` varchar(20) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `createtime` char(10) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `weid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_cash
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_checkgoods`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_checkgoods`;
CREATE TABLE `ims_hcdoudou_checkgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `model` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `thumb` varchar(300) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_checkgoods
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_commission`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_commission`;
CREATE TABLE `ims_hcdoudou_commission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `trade_no` varchar(30) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rate` int(11) NOT NULL,
  `profit` decimal(10,2) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `sort` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `freeze` tinyint(1) NOT NULL DEFAULT '0',
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_commission
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_goods`;
CREATE TABLE `ims_hcdoudou_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `model` varchar(200) NOT NULL,
  `storeprice` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `thumb` varchar(300) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_guan`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_guan`;
CREATE TABLE `ims_hcdoudou_guan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) NOT NULL,
  `weid` int(11) NOT NULL,
  `loadpic` varchar(300) NOT NULL,
  `rollpic` varchar(300) NOT NULL,
  `proppic` varchar(300) NOT NULL,
  `gamebgm` varchar(300) NOT NULL,
  `passbgm` varchar(300) NOT NULL,
  `losebgm` varchar(300) NOT NULL,
  `times` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_guan
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_nexus`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_nexus`;
CREATE TABLE `ims_hcdoudou_nexus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pppid` int(11) NOT NULL,
  `ppid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`),
  KEY `pppid` (`pppid`),
  KEY `ppid` (`ppid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_nexus
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_notice`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_notice`;
CREATE TABLE `ims_hcdoudou_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `content` text NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_order`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_order`;
CREATE TABLE `ims_hcdoudou_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `gid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `openid` varchar(30) NOT NULL,
  `title` varchar(300) NOT NULL,
  `trade_no` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `level` tinyint(1) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0' COMMENT '1中奖2未中奖',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `passtime` char(10) NOT NULL,
  `expresn` varchar(30) DEFAULT NULL COMMENT '快递编号',
  `expretime` char(10) NOT NULL,
  `createtime` char(10) DEFAULT NULL,
  `isdelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`),
  KEY `uid` (`uid`),
  KEY `trade_no` (`trade_no`),
  KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_order
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_paylog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_paylog`;
CREATE TABLE `ims_hcdoudou_paylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(30) NOT NULL,
  `trade_no` varchar(18) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `total_fee` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `createtime` char(10) NOT NULL,
  `paytime` char(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `weid` (`weid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_paylog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_setting`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_setting`;
CREATE TABLE `ims_hcdoudou_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `only` varchar(20) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `only` (`only`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_upgrade`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_upgrade`;
CREATE TABLE `ims_hcdoudou_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `trade_no` varchar(20) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `createtime` char(10) NOT NULL,
  `paytime` char(10) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `weid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_upgrade
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcdoudou_users`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcdoudou_users`;
CREATE TABLE `ims_hcdoudou_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `createtime` char(10) DEFAULT NULL,
  `sessionkey` varchar(50) NOT NULL,
  `unionid` varchar(50) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  `level` int(1) DEFAULT '1',
  `promo_code` varchar(300) NOT NULL,
  `receipt_code` varchar(300) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`),
  KEY `weid` (`weid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcdoudou_users
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_activ`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_activ`;
CREATE TABLE `ims_hcgroup_activ` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `actno` varchar(28) NOT NULL,
  `acttype` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1一分拼',
  `goods_id` int(11) NOT NULL,
  `start_time` char(10) NOT NULL,
  `end_time` char(10) NOT NULL,
  `user_ids` text NOT NULL,
  `luck_user_id` int(11) NOT NULL,
  `luck_order_id` int(11) NOT NULL,
  `luck_time` char(10) NOT NULL,
  `neednum` int(11) NOT NULL DEFAULT '0',
  `currnum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_activ
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_adv`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_adv`;
CREATE TABLE `ims_hcgroup_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_adv
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_goods`;
CREATE TABLE `ims_hcgroup_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pcate` int(11) DEFAULT NULL COMMENT '一级分类',
  `ccate` int(11) DEFAULT NULL COMMENT '二级分类',
  `nav_pcate` tinyint(4) NOT NULL COMMENT '导航一级分类',
  `nav_ccate` tinyint(4) NOT NULL COMMENT '导航2级分类',
  `theme` varchar(100) NOT NULL COMMENT '主题',
  `type` tinyint(1) DEFAULT NULL COMMENT '类型',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态1上架2下架',
  `displayorder` int(11) DEFAULT '0' COMMENT '排序',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `thumb` varchar(255) DEFAULT NULL COMMENT '首页图片',
  `unit` varchar(5) DEFAULT NULL COMMENT '单位',
  `description` varchar(1000) DEFAULT NULL COMMENT '商品简介',
  `content` text COMMENT '商品详情',
  `goodssn` varchar(50) DEFAULT NULL COMMENT '编号',
  `groupprice` decimal(10,2) DEFAULT '0.00' COMMENT '团购价',
  `singleprice` decimal(10,2) DEFAULT '0.00' COMMENT '单买价',
  `marketprice` decimal(10,2) DEFAULT '0.00' COMMENT '市场价',
  `peoplenumber` tinyint(3) DEFAULT '0' COMMENT '起团人数',
  `timelimit` int(11) DEFAULT '0' COMMENT '团购限时',
  `timelimittime` datetime NOT NULL COMMENT '限时截止日期',
  `hotstyle` tinyint(1) NOT NULL COMMENT '特价爆款',
  `headdiscount` tinyint(1) DEFAULT '0' COMMENT '团长优惠1优惠',
  `headdiscountprice` decimal(10,2) DEFAULT '0.00' COMMENT '团长优惠金额',
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `sales_num` int(11) DEFAULT '0' COMMENT '销量',
  `void_num` int(11) DEFAULT '0' COMMENT '虚拟销量',
  `groupbuy_limit` int(11) DEFAULT '0' COMMENT '团购单次购买上限',
  `singlebuy_limit` int(11) DEFAULT '0' COMMENT '单买单词购买上限',
  `totalbuy_limit` int(11) DEFAULT '0' COMMENT '购买总数量上限',
  `free_shipping` tinyint(1) DEFAULT '0' COMMENT '1包邮',
  `postage` decimal(10,2) DEFAULT NULL COMMENT '邮费',
  `hasoption` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1启用规格',
  `is_rec` tinyint(1) NOT NULL,
  `is_hot` tinyint(1) NOT NULL,
  `is_new` tinyint(1) NOT NULL,
  `createtime` char(10) NOT NULL,
  `is_luck` char(1) NOT NULL,
  `luckdrawprice` decimal(10,2) NOT NULL,
  `luckdrawcon` int(11) NOT NULL,
  `actno` varchar(28) NOT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_goods_category`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_goods_category`;
CREATE TABLE `ims_hcgroup_goods_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `parentid` int(11) DEFAULT '0' COMMENT '上级ID',
  `name` varchar(50) DEFAULT NULL COMMENT '分类标题',
  `thumb` varchar(255) DEFAULT NULL COMMENT '图片',
  `displayorder` tinyint(3) unsigned DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) DEFAULT '1' COMMENT '是否显示',
  `isrecommand` tinyint(3) DEFAULT '0' COMMENT '是否推荐1',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_displayorder` (`displayorder`),
  KEY `idx_enabled` (`enabled`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_goods_category
-- ----------------------------
INSERT INTO `ims_hcgroup_goods_category` VALUES ('75', '89', '0', '111', null, '0', '1', '0');
INSERT INTO `ims_hcgroup_goods_category` VALUES ('76', '89', '75', '222', null, '0', '1', '0');

-- ----------------------------
-- Table structure for `ims_hcgroup_goods_spec`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_goods_spec`;
CREATE TABLE `ims_hcgroup_goods_spec` (
  `spec_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `spec_number` varchar(15) NOT NULL,
  `goods_id` int(11) DEFAULT NULL COMMENT '商品ID',
  `spec_title` varchar(100) DEFAULT NULL COMMENT '规格名称',
  `spec_item` text NOT NULL COMMENT '规格项',
  PRIMARY KEY (`spec_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_goods_spec
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_goods_spec_item`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_goods_spec_item`;
CREATE TABLE `ims_hcgroup_goods_spec_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `goods_id` int(11) NOT NULL,
  `option_id` varchar(100) DEFAULT NULL COMMENT '规格项编号',
  `option_title` varchar(100) DEFAULT NULL COMMENT '规格项',
  `option_marketprice` decimal(10,2) DEFAULT NULL COMMENT '团购价',
  `option_productprice` decimal(10,2) NOT NULL COMMENT '单买价',
  `option_costprice` decimal(10,2) NOT NULL COMMENT '市场价',
  `option_stock` int(11) NOT NULL COMMENT '库存',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_goods_spec_item
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_group`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_group`;
CREATE TABLE `ims_hcgroup_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL,
  `goods_name` varchar(255) NOT NULL DEFAULT '',
  `buynum` int(11) NOT NULL COMMENT '已买人数',
  `neednum` int(11) NOT NULL COMMENT '总需人数',
  `shipped` int(11) NOT NULL COMMENT '已发货数量',
  `starttime` char(10) NOT NULL COMMENT '开团时间',
  `endtime` char(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1团购中2成功3失败',
  `actno` varchar(28) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_enabled` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3015 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_group
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_hotsearch`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_hotsearch`;
CREATE TABLE `ims_hcgroup_hotsearch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_hotsearch
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_member`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_member`;
CREATE TABLE `ims_hcgroup_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(50) DEFAULT '',
  `realname` varchar(20) DEFAULT '',
  `mobile` varchar(11) DEFAULT '',
  `content` text,
  `createtime` int(10) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `nickname` varchar(255) DEFAULT '',
  `birthday` varchar(255) DEFAULT '',
  `gender` tinyint(3) DEFAULT '0',
  `avatar` varchar(255) DEFAULT '',
  `country` varchar(255) DEFAULT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_openid` (`openid`),
  KEY `idx_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_member
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_member_address`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_member_address`;
CREATE TABLE `ims_hcgroup_member_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `realname` varchar(20) DEFAULT '',
  `mobile` varchar(11) DEFAULT '',
  `province` varchar(30) DEFAULT '',
  `city` varchar(30) DEFAULT '',
  `area` varchar(30) DEFAULT '',
  `address` varchar(300) DEFAULT '',
  `isdefault` tinyint(1) DEFAULT '0',
  `zipcode` varchar(255) DEFAULT '',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_isdefault` (`isdefault`),
  KEY `idx_deleted` (`deleted`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_member_address
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_nav`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_nav`;
CREATE TABLE `ims_hcgroup_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `parentid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '0',
  `tpl` varchar(50) NOT NULL COMMENT '模板类型',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_nav
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_notice`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_notice`;
CREATE TABLE `ims_hcgroup_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `enabled` tinyint(3) NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_order`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_order`;
CREATE TABLE `ims_hcgroup_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `user_id` varchar(45) NOT NULL,
  `orderno` varchar(45) NOT NULL,
  `groupid` int(11) DEFAULT NULL,
  `paytime` int(11) DEFAULT NULL,
  `unit_price` decimal(11,2) DEFAULT '0.00',
  `number` int(11) DEFAULT NULL COMMENT '购买数量',
  `status` int(9) DEFAULT '1' COMMENT '1待支付2已支付代发货3已发货，待收货4收货,已完成5待退款6已退款7已取消',
  `isshare` char(1) NOT NULL DEFAULT '0',
  `addressid` int(11) DEFAULT '0',
  `goods_id` int(11) DEFAULT NULL,
  `option_id` varchar(500) DEFAULT NULL COMMENT '规格项ID',
  `option_title` varchar(500) DEFAULT NULL COMMENT '规格项名称',
  `ishead` tinyint(1) DEFAULT '0' COMMENT '1团长',
  `discount` decimal(10,2) DEFAULT '0.00',
  `fact_amount` decimal(10,2) DEFAULT NULL COMMENT '实际支付金额',
  `starttime` int(11) DEFAULT NULL,
  `canceltime` int(11) DEFAULT '0',
  `endtime` int(45) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `finishtime` int(11) DEFAULT '0',
  `refundid` int(11) DEFAULT '0',
  `refundstate` tinyint(2) DEFAULT '0',
  `refundtime` int(11) DEFAULT '0',
  `express` varchar(45) DEFAULT NULL,
  `expresscom` varchar(100) DEFAULT NULL,
  `expresssn` varchar(45) DEFAULT NULL,
  `sendtime` int(45) DEFAULT '0',
  `isdelete` char(1) NOT NULL DEFAULT '0' COMMENT '1删除订单',
  `remark` varchar(255) DEFAULT NULL COMMENT '买家备注',
  `sremark` varchar(2000) NOT NULL COMMENT '发货备注',
  `deletetime` char(10) NOT NULL COMMENT '订单删除时间',
  `iscomment` char(1) NOT NULL DEFAULT '0' COMMENT '1已评价',
  `package` varchar(50) NOT NULL COMMENT '微信支付返回',
  `actno` varchar(28) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_order
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_order_comment`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_order_comment`;
CREATE TABLE `ims_hcgroup_order_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `orderid` int(11) DEFAULT '0',
  `goodsid` int(11) DEFAULT '0',
  `openid` varchar(50) DEFAULT '',
  `nickname` varchar(50) DEFAULT '',
  `headimgurl` varchar(255) DEFAULT '',
  `level` tinyint(3) DEFAULT '0' COMMENT '1好2中3差',
  `desc_score` tinyint(1) NOT NULL,
  `express_score` tinyint(1) NOT NULL,
  `serve_score` tinyint(1) NOT NULL,
  `content` varchar(255) DEFAULT '',
  `images` text,
  `createtime` int(11) DEFAULT '0',
  `deleted` tinyint(3) DEFAULT '0',
  `append_content` varchar(255) DEFAULT '',
  `append_images` text,
  `reply_content` varchar(255) DEFAULT '',
  `reply_images` text,
  `append_reply_content` varchar(255) DEFAULT '',
  `append_reply_images` text,
  `istop` tinyint(3) DEFAULT '0',
  `checked` tinyint(3) NOT NULL DEFAULT '0',
  `replychecked` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_goodsid` (`goodsid`),
  KEY `idx_openid` (`openid`),
  KEY `idx_createtime` (`createtime`),
  KEY `idx_orderid` (`orderid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_order_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_order_refund`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_order_refund`;
CREATE TABLE `ims_hcgroup_order_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `mobile` varchar(11) NOT NULL COMMENT '联系电话',
  `orderid` int(11) NOT NULL DEFAULT '0',
  `refundno` varchar(45) NOT NULL DEFAULT '0',
  `refundstatus` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0未退1已退2撤销3驳回',
  `refundtype` varchar(50) NOT NULL COMMENT '退款类型',
  `shipstatus` varchar(10) NOT NULL COMMENT '收货状态',
  `content` varchar(500) NOT NULL COMMENT '退款说明',
  `reason` varchar(100) NOT NULL COMMENT '退款原因',
  `paytime` char(10) NOT NULL COMMENT '支付时间',
  `paymoney` decimal(11,2) NOT NULL COMMENT '实付金额',
  `refundtime` varchar(45) NOT NULL,
  `refundmoney` decimal(10,2) NOT NULL COMMENT '退款金额',
  `images` varchar(500) NOT NULL COMMENT '退款凭证，',
  `applyprice` decimal(11,2) NOT NULL COMMENT '申请退款金额',
  `applytime` char(10) NOT NULL COMMENT '申请退款时间',
  `reject_reason` varchar(500) NOT NULL COMMENT '驳回理由',
  `reject_remark` varchar(1000) NOT NULL COMMENT '驳回备注',
  `reject_time` char(10) NOT NULL COMMENT '驳回时间',
  `cancel_time` char(10) NOT NULL COMMENT '用户撤销时间',
  `cancel_remark` varchar(100) NOT NULL COMMENT '用户撤销备注',
  `backtime` char(10) NOT NULL COMMENT '到账时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `refundno` (`refundno`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_order_refund
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_paylog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_paylog`;
CREATE TABLE `ims_hcgroup_paylog` (
  `plid` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `openid` varchar(40) NOT NULL,
  `tid` varchar(64) NOT NULL,
  `credit` int(10) NOT NULL DEFAULT '0',
  `creditmoney` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `module` varchar(50) NOT NULL,
  `tag` varchar(2000) NOT NULL,
  `is_usecard` tinyint(3) unsigned NOT NULL,
  `card_type` tinyint(3) unsigned NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `card_fee` decimal(10,2) unsigned NOT NULL,
  `encrypt_code` varchar(100) NOT NULL,
  `uniontid` varchar(50) NOT NULL,
  PRIMARY KEY (`plid`),
  KEY `idx_openid` (`openid`),
  KEY `idx_tid` (`tid`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `uniontid` (`uniontid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_paylog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcgroup_set`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcgroup_set`;
CREATE TABLE `ims_hcgroup_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `shop_name` varchar(100) DEFAULT NULL COMMENT '商城名称',
  `share_title` varchar(100) NOT NULL,
  `shop_logo` varchar(200) DEFAULT NULL COMMENT '商城logo',
  `telnumber` varchar(20) NOT NULL COMMENT '联系方式',
  `copyright` varchar(100) DEFAULT NULL COMMENT '版权',
  `desc` text COMMENT '描述',
  `autosign` char(1) DEFAULT '5' COMMENT '自动确认收货时间',
  `autosign_status` char(1) NOT NULL DEFAULT '0' COMMENT '1开启',
  `autorefund` tinyint(4) DEFAULT '3' COMMENT '自动退款时间',
  `autorefund_status` char(1) NOT NULL DEFAULT '0' COMMENT '1开启',
  `autocancel` tinyint(4) DEFAULT '1' COMMENT '自动取消订单时间',
  `autocancel_status` char(1) NOT NULL DEFAULT '0' COMMENT '1开启',
  `cert` text COMMENT '商户支付证书',
  `key` text COMMENT '支付证书私钥',
  `rootca` text COMMENT 'rootca证书',
  `tpl_msg` varchar(2000) NOT NULL COMMENT '模板消息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcgroup_set
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_adv`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_adv`;
CREATE TABLE `ims_hcpdd_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `jump` int(11) NOT NULL DEFAULT '1',
  `xcxpath` varchar(255) NOT NULL,
  `xcxappid` varchar(255) NOT NULL,
  `diypic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_adv
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_allorder`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_allorder`;
CREATE TABLE `ims_hcpdd_allorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_sn` varchar(255) DEFAULT NULL,
  `goods_id` int(20) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_thumbnail_url` varchar(255) DEFAULT NULL,
  `goods_quantity` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `order_amount` varchar(255) DEFAULT NULL,
  `order_create_time` varchar(255) DEFAULT NULL,
  `order_settle_time` varchar(255) DEFAULT NULL,
  `order_verify_time` varchar(255) DEFAULT NULL,
  `order_receive_time` varchar(255) DEFAULT NULL,
  `order_pay_time` varchar(255) DEFAULT NULL,
  `promotion_rate` varchar(255) DEFAULT NULL,
  `promotion_amount` varchar(255) DEFAULT NULL,
  `batch_no` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `order_status_desc` varchar(255) DEFAULT NULL,
  `verify_time` varchar(255) DEFAULT NULL,
  `order_group_success_time` varchar(255) DEFAULT NULL,
  `order_modify_at` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `auth_duo_id` varchar(255) DEFAULT NULL,
  `custom_parameters` varchar(255) DEFAULT NULL,
  `p_id` varchar(255) DEFAULT NULL,
  `duo_coupon_amount` varchar(255) NOT NULL,
  `zs_duo_id` varchar(100) NOT NULL,
  `match_channel` varchar(200) NOT NULL,
  `fafang` int(11) DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败',
  `cfafang` int(11) NOT NULL COMMENT '0 没有上级抽佣1 已发放上级佣金',
  `order_id` varchar(100) NOT NULL,
  `commission` varchar(10) NOT NULL,
  `is_daili` int(11) NOT NULL,
  `cpa_new` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_sn` (`order_sn`),
  KEY `uniacid` (`uniacid`),
  KEY `p_id` (`p_id`),
  KEY `order_status` (`order_status`)
) ENGINE=MyISAM AUTO_INCREMENT=407 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_allorder
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_allorders`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_allorders`;
CREATE TABLE `ims_hcpdd_allorders` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `order_sn` varchar(255) DEFAULT NULL,
  `goods_id` int(20) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_thumbnail_url` varchar(255) DEFAULT NULL,
  `goods_quantity` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `order_amount` varchar(255) DEFAULT NULL,
  `order_create_time` varchar(255) DEFAULT NULL,
  `order_settle_time` varchar(255) DEFAULT NULL,
  `order_verify_time` varchar(255) DEFAULT NULL,
  `order_receive_time` varchar(255) DEFAULT NULL,
  `order_pay_time` varchar(255) DEFAULT NULL,
  `promotion_rate` varchar(255) DEFAULT NULL,
  `promotion_amount` varchar(255) DEFAULT NULL,
  `batch_no` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `order_status_desc` varchar(255) DEFAULT NULL,
  `verify_time` varchar(255) DEFAULT NULL,
  `order_group_success_time` varchar(255) DEFAULT NULL,
  `order_modify_at` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `auth_duo_id` varchar(255) DEFAULT NULL,
  `custom_parameters` varchar(255) DEFAULT NULL,
  `p_id` varchar(255) DEFAULT NULL,
  `duo_coupon_amount` varchar(255) NOT NULL,
  `zs_duo_id` varchar(100) NOT NULL,
  `match_channel` varchar(200) NOT NULL,
  `fafang` int(11) DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败',
  `cfafang` int(11) NOT NULL COMMENT '0 没有上级抽佣1 已发放上级佣金'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_allorders
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_collect`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_collect`;
CREATE TABLE `ims_hcpdd_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `goods_id` varchar(255) NOT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `now_price` varchar(255) DEFAULT NULL,
  `coupon_discount` varchar(255) DEFAULT NULL,
  `goods_thumbnail_url` varchar(255) DEFAULT NULL,
  `itemUrl` varchar(200) NOT NULL,
  `skuId` varchar(200) NOT NULL,
  `parameter` int(11) NOT NULL,
  `sold_quantity` varchar(255) NOT NULL,
  `couponUrl` varchar(200) NOT NULL,
  `materialUrl` varchar(200) NOT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_collect
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_copy`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_copy`;
CREATE TABLE `ims_hcpdd_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `copy_img` varchar(255) DEFAULT NULL,
  `copy_type` int(11) DEFAULT '1' COMMENT '1商品推荐2素材营销3新手必发',
  `copy_goodsid` varchar(20) DEFAULT NULL,
  `copy_text` varchar(5500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `createtime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`uniacid`,`copy_type`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_copy
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_cset`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_cset`;
CREATE TABLE `ims_hcpdd_cset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invite_agreement` varchar(255) NOT NULL COMMENT '邀请好友规则',
  `tx_details` text NOT NULL COMMENT '佣金提现协议',
  `is_shoufei` int(11) NOT NULL COMMENT '1.收费0.免费',
  `fx_level` int(11) NOT NULL COMMENT '分销层级0.不开启分销1.一级2.二级3.三级',
  `tx_rate` int(11) NOT NULL COMMENT '提现手续费',
  `commission1` varchar(10) NOT NULL COMMENT '一级佣金',
  `commission2` varchar(10) NOT NULL COMMENT '二级佣金',
  `commission3` varchar(10) NOT NULL COMMENT '三级佣金',
  `zongjian_commission1` varchar(10) NOT NULL,
  `zongjian_commission2` varchar(10) NOT NULL,
  `zongjian_commission3` varchar(10) NOT NULL,
  `tx_money` int(11) NOT NULL COMMENT '提现门槛',
  `uniacid` int(11) NOT NULL,
  `dailifei` decimal(10,2) NOT NULL COMMENT '代理费',
  `zongjianfei` decimal(10,2) NOT NULL,
  `agreement` varchar(255) NOT NULL COMMENT '申请代理规则',
  `zongjian_agreement` varchar(255) NOT NULL COMMENT '升级运营总监规则',
  `daili` varchar(255) NOT NULL DEFAULT '代理',
  `yunyingzongjian` varchar(255) NOT NULL DEFAULT '运营总监',
  `yongjin` varchar(255) NOT NULL DEFAULT '佣金',
  `yiji` varchar(255) NOT NULL DEFAULT '一级',
  `erji` varchar(255) NOT NULL DEFAULT '二级',
  `sanji` varchar(255) NOT NULL DEFAULT '三级',
  `invite_title` varchar(255) NOT NULL,
  `invite_pic` varchar(255) NOT NULL,
  `invite_bg` varchar(255) NOT NULL COMMENT '背景',
  `guize_bg` varchar(255) NOT NULL,
  `inviteposter1` varchar(255) NOT NULL,
  `inviteposter2` varchar(255) NOT NULL,
  `inviteposter3` varchar(255) NOT NULL,
  `dailisum` int(11) NOT NULL COMMENT '升级代理人数',
  `zongjiansum` int(11) NOT NULL COMMENT '升级总监人数',
  `shengdaili` varchar(100) NOT NULL,
  `shengzongjian` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_cset
-- ----------------------------
INSERT INTO `ims_hcpdd_cset` VALUES ('2', '', '', '1', '2', '0', '', '', '', '', '', '', '0', '178', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '0', '', '');
INSERT INTO `ims_hcpdd_cset` VALUES ('3', '阿斯蒂芬阿什顿发斯蒂芬阿飞按时', '', '0', '3', '0', '20', '20', '20', '10', '10', '10', '0', '31', '0.00', '0.00', '阿斯蒂芬', '阿斯蒂芬 阿斯蒂芬', '', '', '', '', '', '', '暗室逢灯按时', '', '', '', '', '', '', '0', '50', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shengdaili.png', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shengzongjian.png');

-- ----------------------------
-- Table structure for `ims_hcpdd_ctixian`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_ctixian`;
CREATE TABLE `ims_hcpdd_ctixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `tel` varchar(20) NOT NULL COMMENT '手机号',
  `truename` varchar(20) NOT NULL COMMENT '姓名',
  `weixin` varchar(20) NOT NULL COMMENT '微信号',
  `payment_time` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `son_uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_ctixian
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_finishorders`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_finishorders`;
CREATE TABLE `ims_hcpdd_finishorders` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `order_sn` varchar(255) DEFAULT NULL,
  `goods_id` int(20) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_thumbnail_url` varchar(255) DEFAULT NULL,
  `goods_quantity` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `order_amount` varchar(255) DEFAULT NULL,
  `order_create_time` varchar(255) DEFAULT NULL,
  `order_settle_time` varchar(255) DEFAULT NULL,
  `order_verify_time` varchar(255) DEFAULT NULL,
  `order_receive_time` varchar(255) DEFAULT NULL,
  `order_pay_time` varchar(255) DEFAULT NULL,
  `promotion_rate` varchar(255) DEFAULT NULL,
  `promotion_amount` varchar(255) DEFAULT NULL,
  `batch_no` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `order_status_desc` varchar(255) DEFAULT NULL,
  `verify_time` varchar(255) DEFAULT NULL,
  `order_group_success_time` varchar(255) DEFAULT NULL,
  `order_modify_at` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `auth_duo_id` varchar(255) DEFAULT NULL,
  `custom_parameters` varchar(255) DEFAULT NULL,
  `p_id` varchar(255) DEFAULT NULL,
  `fafang` int(11) DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败',
  `zs_duo_id` varchar(200) NOT NULL,
  `duo_coupon_amount` varchar(200) NOT NULL,
  `match_channel` varchar(100) NOT NULL,
  `cfafang` int(11) NOT NULL COMMENT '0 没有上级抽佣1 已发放上级佣金',
  `order_id` varchar(100) NOT NULL,
  `commission` varchar(10) NOT NULL,
  `is_daili` int(11) NOT NULL,
  `cpa_new` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`order_sn`,`fafang`)
) ENGINE=MyISAM AUTO_INCREMENT=584 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_finishorders
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_formid`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_formid`;
CREATE TABLE `ims_hcpdd_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `formid` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2764 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_formid
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_hblog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_hblog`;
CREATE TABLE `ims_hcpdd_hblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hongbaotime` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0未转发1已转发',
  `s_time` varchar(255) NOT NULL COMMENT '领取红包时间戳',
  `e_time` varchar(255) NOT NULL COMMENT '红包结束时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_hblog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_history`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_history`;
CREATE TABLE `ims_hcpdd_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `sotime` varchar(255) NOT NULL COMMENT '搜索时间',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7671 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_history
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_hongbao`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_hongbao`;
CREATE TABLE `ims_hcpdd_hongbao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `is_open` int(11) DEFAULT NULL,
  `open_bg` varchar(255) DEFAULT NULL,
  `firstmoney` int(11) DEFAULT NULL,
  `zhuanfamoney` int(11) DEFAULT NULL,
  `shareinfo` varchar(255) NOT NULL,
  `sharetitle` varchar(255) NOT NULL,
  `fenxiangtitle` varchar(255) NOT NULL,
  `fenxiangpic` varchar(255) NOT NULL,
  `hb_day` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_hongbao
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_jdcommission`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_jdcommission`;
CREATE TABLE `ims_hcpdd_jdcommission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `positionId` varchar(100) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `orderId` varchar(100) DEFAULT NULL,
  `fee` varchar(10) DEFAULT NULL,
  `fx_commission` decimal(10,3) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `goodsname` varchar(255) DEFAULT NULL,
  `fx_rate` varchar(20) DEFAULT NULL,
  `is_daili` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_jdcommission
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_jdorders`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_jdorders`;
CREATE TABLE `ims_hcpdd_jdorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `ext1` varchar(100) DEFAULT NULL,
  `finishTime` varchar(100) DEFAULT NULL,
  `orderEmt` varchar(100) DEFAULT NULL,
  `orderId` varchar(100) NOT NULL,
  `orderTime` varchar(100) DEFAULT NULL,
  `parentId` varchar(100) DEFAULT NULL,
  `payMonth` varchar(100) DEFAULT NULL,
  `plus` varchar(100) DEFAULT NULL,
  `popId` varchar(100) DEFAULT NULL,
  `skuList` varchar(5000) DEFAULT NULL,
  `unionId` varchar(100) DEFAULT NULL,
  `validCode` varchar(100) DEFAULT NULL COMMENT '订单状态',
  `positionId` varchar(100) DEFAULT NULL COMMENT '京东推广位',
  `commission` varchar(10) NOT NULL COMMENT '佣金',
  `is_daili` int(11) NOT NULL,
  `fafang` int(11) NOT NULL,
  PRIMARY KEY (`id`,`orderId`),
  KEY `uniacid` (`uniacid`,`validCode`,`positionId`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_jdorders
-- ----------------------------
INSERT INTO `ims_hcpdd_jdorders` VALUES ('1', '57', '1001312562', '0', '2', '95000771780', '1557499364000', '0', '0', '0', '10000167', '[{\"actualCosPrice\":0,\"actualFee\":0,\"cid1\":16750,\"cid2\":16755,\"cid3\":16806,\"commissionRate\":15,\"estimateCosPrice\":13.9,\"estimateFee\":1.88,\"ext1\":\"1001312562\",\"finalRate\":90,\"frozenSkuNum\":0,\"payMonth\":0,\"pid\":\"\",\"popId\":10000167,\"positionId\":1806227272,\"price\":17.9,\"siteId\":0,\"skuId\":31514722095,\"skuName\":\"\\u8212\\u5ba2\\u9632\\u86c0\\u56fa\\u9f7f\\u7259\\u818f140g*2+\\u9632\\u86c0\\u4eae\\u767d\\u7259\\u818f120g*1\\uff08\\u9001\\u7259\\u52371\\u76d2\\uff09\\u5305\\u90ae \\u8ba2\\u5355\\u91cf\\u8fc7\\u5927\\u5982\\u65e0\\u6cd5\\u4e0b\\u5355\\u8bf7\\u5237\\u65b0\",\"skuNum\":1,\"skuReturnNum\":0,\"subSideRate\":90,\"subUnionId\":\"\",\"subsidyRate\":0,\"traceType\":2,\"unionAlias\":\"\",\"unionTag\":\"00000100\",\"unionTrafficGroup\":4,\"validCode\":16}]', '1000577982', '16', '1806227272', '0', '0', '0');

-- ----------------------------
-- Table structure for `ims_hcpdd_kouhonglog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_kouhonglog`;
CREATE TABLE `ims_hcpdd_kouhonglog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `createtime` varchar(20) DEFAULT NULL,
  `createday` varchar(20) DEFAULT NULL,
  `goods_id` varchar(20) DEFAULT NULL,
  `invite_id` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0挑战失败1挑战成功',
  `cishu` int(20) DEFAULT '0' COMMENT '0挑战零次没挑战直接邀请好友1直接开始挑战2满足条件后挑战第二次',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_kouhonglog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_message`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_message`;
CREATE TABLE `ims_hcpdd_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `msgid` varchar(255) DEFAULT NULL,
  `keyword1` varchar(255) DEFAULT NULL,
  `keyword2` varchar(255) DEFAULT NULL,
  `keyword3` varchar(255) DEFAULT NULL,
  `hongbao_msgid` varchar(255) NOT NULL,
  `fenxiao_msgid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_message
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_mogucommission`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_mogucommission`;
CREATE TABLE `ims_hcpdd_mogucommission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `groupId` varchar(100) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `orderNo` varchar(100) DEFAULT NULL,
  `fee` varchar(10) DEFAULT NULL,
  `fx_commission` decimal(10,3) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `goodsname` varchar(255) DEFAULT NULL,
  `fx_rate` varchar(20) DEFAULT NULL,
  `is_daili` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_mogucommission
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_moguorders`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_moguorders`;
CREATE TABLE `ims_hcpdd_moguorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `orderNo` varchar(20) NOT NULL,
  `sysExpense` varchar(20) DEFAULT NULL,
  `groupId` varchar(20) DEFAULT NULL,
  `orderStatus` varchar(10) DEFAULT NULL,
  `preExpense` varchar(20) DEFAULT NULL,
  `updateTime` varchar(20) DEFAULT NULL,
  `expense` varchar(20) DEFAULT NULL,
  `paymentType` varchar(20) DEFAULT NULL,
  `products` varchar(2000) DEFAULT NULL,
  `feedback` varchar(20) DEFAULT NULL,
  `orderTime` varchar(20) DEFAULT NULL,
  `createdDate` varchar(20) DEFAULT NULL,
  `price` varchar(10) DEFAULT NULL,
  `chargeDate` varchar(20) DEFAULT NULL,
  `paymentStatus` varchar(20) DEFAULT NULL,
  `fafang` int(11) NOT NULL,
  `commission` varchar(10) NOT NULL,
  `is_daili` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `orderNo` (`orderNo`),
  KEY `orderStatus` (`groupId`,`orderStatus`,`paymentStatus`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_moguorders
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_moneyrate`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_moneyrate`;
CREATE TABLE `ims_hcpdd_moneyrate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `moneyrate` float DEFAULT NULL,
  `daili_moneyrate` float DEFAULT NULL,
  `zongjian_moneyrate` float DEFAULT NULL,
  `edittime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_moneyrate
-- ----------------------------
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('17', '31', '0', '0', '0', '1552882165');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('18', '31', '0', '0', '0', '1552982940');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('19', '178', '0', '0', '0', '1553185470');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('20', '31', '0', '0', '0', '1553678846');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('21', '1', '0', '0', '0', '1553852117');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('22', '31', '0', '0', '0', '1554644433');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('23', '31', '0', '0', '0', '1554825272');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('24', '31', '0', '0', '0', '1554828728');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('25', '31', '0', '0', '0', '1554896984');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('26', '31', '0', '0', '0', '1554955913');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('27', '31', '0', '0', '0', '1554972521');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('28', '31', '0', '0', '0', '1555325718');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('29', '31', '0', '0', '0', '1555418817');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('30', '31', '0', '0', '0', '1555670747');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('31', '31', '0', '0', '0', '1555924349');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('32', '31', '0', '0', '0', '1556085575');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('33', '31', '0', '0', '0', '1556293017');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('34', '31', '0', '0', '0', '1557104437');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('35', '89', '0', '0', '0', '1557646471');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('36', '31', '1', '1', '1', '1557710488');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('37', '31', '1', '1', '1', '1557918836');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('38', '31', '1', '1', '1', '1557919538');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('39', '31', '1', '1', '1', '1558361493');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('40', '31', '1', '1', '1', '1558631797');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('41', '31', '1', '1', '1', '1558685810');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('42', '31', '1', '1', '1', '1558685833');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('43', '31', '1', '1', '1', '1558685837');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('44', '31', '1', '1', '1', '1558792682');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('45', '31', '1', '1', '1', '1558793434');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('46', '31', '1', '1', '1', '1559632507');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('47', '1', '0', '0', '0', '1559648801');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('48', '31', '1', '1', '1', '1559736525');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('49', '31', '1', '1', '1', '1560157600');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('50', '31', '1', '1', '1', '1561134352');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('51', '31', '1', '1', '1', '1561134805');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('52', '31', '1', '1', '1', '1561170012');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('53', '31', '1', '1', '1', '1561283651');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('54', '31', '1', '1', '1', '1561299746');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('55', '31', '1', '1', '1', '1561299885');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('56', '31', '1', '1', '1', '1562575674');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('57', '31', '1', '1', '1', '1564223166');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('58', '31', '1', '1', '1', '1564389051');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('59', '31', '1', '1', '1', '1564450232');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('60', '31', '0.1', '0.2', '0.3', '1564450256');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('61', '31', '0.1', '0.2', '0.3', '1564450260');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('62', '31', '0.1', '0.2', '0.3', '1565273984');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('63', '18', '0', '0', '0', '1565531999');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('64', '18', '0', '0', '0', '1565532005');
INSERT INTO `ims_hcpdd_moneyrate` VALUES ('65', '31', '0.1', '0.2', '0.3', '1566122262');

-- ----------------------------
-- Table structure for `ims_hcpdd_nav`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_nav`;
CREATE TABLE `ims_hcpdd_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `parentid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cateid` int(10) NOT NULL,
  `icon` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '0',
  `tpl` varchar(50) NOT NULL COMMENT '模板类型',
  `jump` int(11) NOT NULL,
  `jdcateid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_nav
-- ----------------------------
INSERT INTO `ims_hcpdd_nav` VALUES ('19', '178', '0', '美食', '6398', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/meishi.png', '', '1', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('20', '178', '0', '母婴', '14966', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/muying.png', '', '2', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('21', '178', '0', '水果', '8172', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuiguo.png', '', '3', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('22', '178', '0', '女装', '210', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/nvzhuang.png', '', '4', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('23', '178', '0', '百货', '16989', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/baihuo.png', '', '5', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('24', '178', '0', '美妆', '1464', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/meizhuang.png', '', '6', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('25', '178', '0', '电器', '6128', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/dianqi.png', '', '7', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('26', '178', '0', '男装', '239', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/nanzhuang.png', '', '8', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('27', '178', '0', '家纺', '9319', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiafang.png', '', '9', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('28', '178', '0', '鞋包', '11686', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/xiebao.png', '', '10', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('29', '178', '0', '运动', '11685', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/yundong.png', '', '11', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('30', '178', '0', '文具', '2629', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/wenju.png', '', '12', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('31', '178', '0', '汽车', '7639', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/qiche.png', '', '13', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('32', '178', '0', '家装', '9318', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiazhuang.png', '', '14', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('33', '178', '0', '办公', '2603', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/bangong.png', '', '15', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('34', '178', '0', '数码', '2933', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuma.png', '', '16', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('85', '31', '0', '办公', '2603', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/bangong.png', '', '15', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('84', '31', '0', '家装', '9318', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiazhuang.png', '', '14', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('83', '31', '0', '汽车', '7639', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/qiche.png', '', '13', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('82', '31', '0', '文具', '2629', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/wenju.png', '', '12', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('81', '31', '0', '运动', '11685', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/yundong.png', '', '11', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('80', '31', '0', '鞋包', '11686', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/xiebao.png', '', '10', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('79', '31', '0', '家纺', '9319', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiafang.png', '', '9', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('78', '31', '0', '男装', '239', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/nanzhuang.png', '', '8', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('77', '31', '0', '电器', '6128', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/dianqi.png', '', '7', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('76', '31', '0', '美妆', '1464', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/meizhuang.png', '', '6', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('75', '31', '0', '百货', '16989', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/baihuo.png', '', '5', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('74', '31', '0', '女装', '210', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/nvzhuang.png', '', '4', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('73', '31', '0', '水果', '8172', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuiguo.png', '', '3', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('72', '31', '0', '母婴', '14966', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/muying.png', '', '2', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('71', '31', '0', '美食', '6398', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/meishi.png', '', '1', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('51', '1', '0', '美食', '6398', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/meishi.png', '', '1', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('52', '1', '0', '母婴', '14966', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/muying.png', '', '2', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('53', '1', '0', '水果', '8172', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuiguo.png', '', '3', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('54', '1', '0', '女装', '210', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/nvzhuang.png', '', '4', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('55', '1', '0', '百货', '16989', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/baihuo.png', '', '5', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('56', '1', '0', '美妆', '1464', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/meizhuang.png', '', '6', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('57', '1', '0', '电器', '6128', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/dianqi.png', '', '7', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('58', '1', '0', '男装', '239', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/nanzhuang.png', '', '8', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('59', '1', '0', '家纺', '9319', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiafang.png', '', '9', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('60', '1', '0', '鞋包', '11686', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/xiebao.png', '', '10', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('61', '1', '0', '运动', '11685', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/yundong.png', '', '11', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('62', '1', '0', '文具', '2629', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/wenju.png', '', '12', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('63', '1', '0', '汽车', '7639', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/qiche.png', '', '13', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('64', '1', '0', '家装', '9318', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiazhuang.png', '', '14', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('65', '1', '0', '办公', '2603', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/bangong.png', '', '15', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('66', '1', '0', '数码', '2933', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuma.png', '', '16', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('67', '1', '0', '发圈', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/faquan.png', '', '17', '1', '', '1', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('68', '1', '0', '代理', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/daili.png', '', '18', '1', '', '2', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('69', '1', '0', '红包树', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/hongbaoshu.png', '', '19', '1', '', '3', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('70', '1', '0', '领红包', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/hongbao.png', '', '20', '1', '', '4', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('86', '31', '0', '数码', '2933', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuma.png', '', '16', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('87', '31', '0', '发圈', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/faquan.png', '', '17', '1', '', '1', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('88', '31', '0', '代理', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/daili.png', '', '18', '1', '', '2', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('89', '31', '0', '红包树', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/hongbaoshu.png', '', '19', '1', '', '3', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('90', '31', '0', '领红包', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/hongbao.png', '', '20', '1', '', '4', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('91', '31', '0', '美食', '6398', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/meishi.png', '', '1', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('92', '31', '0', '母婴', '14966', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/muying.png', '', '2', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('93', '31', '0', '水果', '8172', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuiguo.png', '', '3', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('94', '31', '0', '女装', '210', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/nvzhuang.png', '', '4', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('95', '31', '0', '百货', '16989', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/baihuo.png', '', '5', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('96', '31', '0', '美妆', '1464', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/meizhuang.png', '', '6', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('97', '31', '0', '电器', '6128', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/dianqi.png', '', '7', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('98', '31', '0', '男装', '239', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/nanzhuang.png', '', '8', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('99', '31', '0', '家纺', '9319', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiafang.png', '', '9', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('100', '31', '0', '鞋包', '11686', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/xiebao.png', '', '10', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('101', '31', '0', '运动', '11685', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/yundong.png', '', '11', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('102', '31', '0', '文具', '2629', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/wenju.png', '', '12', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('103', '31', '0', '汽车', '7639', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/qiche.png', '', '13', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('104', '31', '0', '家装', '9318', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiazhuang.png', '', '14', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('105', '31', '0', '办公', '2603', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/bangong.png', '', '15', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('106', '31', '0', '数码', '2933', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuma.png', '', '16', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('107', '31', '0', '发圈', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/faquan.png', '', '17', '1', '', '1', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('108', '31', '0', '代理', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/daili.png', '', '18', '1', '', '2', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('109', '31', '0', '红包树', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/hongbaoshu.png', '', '19', '1', '', '3', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('110', '31', '0', '领红包', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/hongbao.png', '', '20', '1', '', '4', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('111', '31', '0', '美食', '6398', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/meishi.png', '', '1', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('112', '31', '0', '母婴', '14966', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/muying.png', '', '2', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('113', '31', '0', '水果', '8172', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuiguo.png', '', '3', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('114', '31', '0', '女装', '210', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/nvzhuang.png', '', '4', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('115', '31', '0', '百货', '16989', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/baihuo.png', '', '5', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('116', '31', '0', '美妆', '1464', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/meizhuang.png', '', '6', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('117', '31', '0', '电器', '6128', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/dianqi.png', '', '7', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('118', '31', '0', '男装', '239', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/nanzhuang.png', '', '8', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('119', '31', '0', '家纺', '9319', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiafang.png', '', '9', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('120', '31', '0', '鞋包', '11686', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/xiebao.png', '', '10', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('121', '31', '0', '运动', '11685', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/yundong.png', '', '11', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('122', '31', '0', '文具', '2629', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/wenju.png', '', '12', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('123', '31', '0', '汽车', '7639', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/qiche.png', '', '13', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('124', '31', '0', '家装', '9318', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/jiazhuang.png', '', '14', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('125', '31', '0', '办公', '2603', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/bangong.png', '', '15', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('126', '31', '0', '数码', '2933', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/shuma.png', '', '16', '1', '', '0', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('127', '31', '0', '发圈', '0', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/faquan.png', '', '17', '1', '', '1', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('128', '31', '0', '代理', '0', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/daili.png', '', '18', '1', '', '2', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('129', '31', '0', '红包树', '0', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/hongbaoshu.png', '', '19', '1', '', '3', '0');
INSERT INTO `ims_hcpdd_nav` VALUES ('130', '31', '0', '领红包', '0', 'https://yanshi.suyituike.cn/addons/hc_pdd/template/img/hongbao.png', '', '20', '1', '', '4', '0');

-- ----------------------------
-- Table structure for `ims_hcpdd_notice`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_notice`;
CREATE TABLE `ims_hcpdd_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `enabled` tinyint(3) NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_noticeuser`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_noticeuser`;
CREATE TABLE `ims_hcpdd_noticeuser` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `notice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_noticeuser
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_orders`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_orders`;
CREATE TABLE `ims_hcpdd_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `ordersn` varchar(30) DEFAULT '',
  `fid` int(11) DEFAULT NULL COMMENT '0升级代理订单1升级总监订单',
  `fee` decimal(11,2) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `paystatus` tinyint(1) NOT NULL DEFAULT '0',
  `paytime` char(10) NOT NULL,
  `transid` varchar(50) DEFAULT '',
  `createtime` int(10) DEFAULT '0',
  `package` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_orders
-- ----------------------------
INSERT INTO `ims_hcpdd_orders` VALUES ('27', '31', '2459', '', '0', '0.00', '0', '0', '1564450312', '', '0', '');

-- ----------------------------
-- Table structure for `ims_hcpdd_pddcommission`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_pddcommission`;
CREATE TABLE `ims_hcpdd_pddcommission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pid` varchar(100) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `order_sn` varchar(100) DEFAULT NULL,
  `fee` varchar(10) DEFAULT NULL,
  `fx_commission` decimal(10,3) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `goodsname` varchar(255) DEFAULT NULL,
  `fx_rate` varchar(20) DEFAULT NULL,
  `is_daili` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_pddcommission
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_set`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_set`;
CREATE TABLE `ims_hcpdd_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `client_id` varchar(100) DEFAULT NULL COMMENT 'client_id',
  `client_secret` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL COMMENT '联系人',
  `contact_qr` varchar(200) NOT NULL COMMENT '联系二维码',
  `share_icon` varchar(200) NOT NULL COMMENT '分享图标',
  `bg_pic` varchar(200) NOT NULL COMMENT '个人中心头部背景',
  `head_color` varchar(20) NOT NULL,
  `search_color` varchar(20) NOT NULL COMMENT '搜索框颜色',
  `tixianb_color` varchar(20) NOT NULL COMMENT '提现按钮颜色',
  `tixiant_color` varchar(20) NOT NULL COMMENT '提现字体颜色',
  `moneyrate` float NOT NULL DEFAULT '1' COMMENT '用户佣金比例',
  `title` varchar(100) NOT NULL,
  `share` varchar(100) NOT NULL,
  `self` varchar(100) NOT NULL,
  `loginbg` varchar(200) NOT NULL,
  `enable` int(10) NOT NULL,
  `shenhe` int(10) NOT NULL,
  `sohead` varchar(100) NOT NULL,
  `sobg` varchar(100) NOT NULL,
  `is_index` int(10) NOT NULL COMMENT '1显示0不显示',
  `zongjian_moneyrate` float NOT NULL DEFAULT '1' COMMENT '总监佣金比',
  `daili_moneyrate` float NOT NULL DEFAULT '1',
  `sharecolor` varchar(255) NOT NULL COMMENT '商品详情分享赚按钮',
  `selfcolor` varchar(255) NOT NULL COMMENT '商品详情自省买按钮',
  `contactway` int(10) NOT NULL DEFAULT '0',
  `huiyuan` varchar(255) NOT NULL DEFAULT '会员',
  `indextitle` varchar(255) NOT NULL,
  `indexpic` varchar(255) NOT NULL,
  `wtype` int(11) NOT NULL DEFAULT '1' COMMENT '1支付宝0企业微信',
  `tx_money` float(10,2) NOT NULL DEFAULT '10.00' COMMENT '提现门槛',
  `tx_intro` varchar(255) NOT NULL COMMENT '提现说明',
  `zzappid` varchar(255) NOT NULL COMMENT '中转小程序appid',
  `zeroshare` varchar(255) NOT NULL,
  `zerobuy` varchar(255) NOT NULL,
  `getmobile` int(11) NOT NULL,
  `version` varchar(255) NOT NULL COMMENT '版本号',
  `top` varchar(255) NOT NULL,
  `goodtop` varchar(255) NOT NULL,
  `copy_writer` varchar(255) NOT NULL,
  `copy_headpic` varchar(255) NOT NULL,
  `sptj` varchar(50) NOT NULL,
  `scyx` varchar(50) NOT NULL,
  `xsbf` varchar(50) NOT NULL,
  `is_tree` int(11) NOT NULL,
  `min_treemoney` decimal(10,2) NOT NULL,
  `max_treemoney` decimal(10,2) NOT NULL,
  `min_treetxmoney` decimal(10,2) NOT NULL,
  `tree_pic` varchar(255) NOT NULL,
  `treesharepic` varchar(255) NOT NULL,
  `treesharetitle` varchar(255) NOT NULL,
  `treeadultid` varchar(50) NOT NULL,
  `treewith_pic` varchar(200) NOT NULL,
  `treeinfo` varchar(200) NOT NULL,
  `app_key` varchar(50) NOT NULL,
  `app_secret` varchar(50) NOT NULL,
  `access_token` varchar(50) NOT NULL,
  `mogurate` varchar(10) NOT NULL,
  `mogudailirate` varchar(10) NOT NULL,
  `moguzongjianrate` varchar(10) NOT NULL,
  `uid` varchar(20) NOT NULL COMMENT '蘑菇街uid',
  `is_mogu` int(11) NOT NULL DEFAULT '0',
  `tree_pic2` varchar(60) NOT NULL,
  `tuijian_type` int(11) NOT NULL,
  `is_jd` int(11) NOT NULL,
  `unionId` varchar(50) NOT NULL,
  `jdappkey` varchar(50) NOT NULL,
  `jdsecretkey` varchar(50) NOT NULL,
  `siteid` varchar(50) NOT NULL,
  `jdkey` varchar(100) NOT NULL,
  `jdrate` varchar(10) NOT NULL,
  `jddailirate` varchar(10) NOT NULL,
  `jdzongjianrate` varchar(10) NOT NULL,
  `is_kouhong` int(11) NOT NULL DEFAULT '1',
  `kouhong_pic` varchar(60) NOT NULL,
  `kouhong_sharetitle` varchar(100) NOT NULL,
  `kouhong_sharepic` varchar(60) NOT NULL,
  `kouhong_ids` varchar(200) NOT NULL,
  `kouhong_color` varchar(100) NOT NULL,
  `pddsobg` varchar(60) NOT NULL,
  `jdsobg` varchar(60) NOT NULL,
  `treeposter` varchar(100) NOT NULL,
  `tree_way` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_set
-- ----------------------------
INSERT INTO `ims_hcpdd_set` VALUES ('2', '178', '', '', '', '', '', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/centertop.png', '', '', '', '', '1', '', '', '', '', '0', '1', '', '', '0', '1', '1', '', '', '0', '会员', '', '', '1', '10.00', '', '', '', '', '0', '', '', '', '', '', '', '', '', '0', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '1', '1', '1001275072', '', '', '454651728474560', 'ece3b6ab1c8b87a71a82812e96dcf9e3beb38d3e6961e93ea76514b198867c5b3fff1c34758899c8', '', '', '', '1', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ims_hcpdd_set` VALUES ('3', null, null, '', null, '', '', '', '', '', '', '', '1', '', '', '', '', '0', '0', '', '', '0', '1', '1', '', '', '0', '会员', '', '', '1', '10.00', '', '', '', '', '0', '5.0', '', '', '', '', '', '', '', '0', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0', '0', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ims_hcpdd_set` VALUES ('4', '31', '15409c535df94bfb88345835793b3c8a', 'e76ada3f9579f057af830266570b8239d12ec9be', '', '', '', '', '', '', '', '', '0.1', '', '分享赚', '自省买', '', '0', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/sohead.png', '', '1', '0.3', '0.2', '#4e0c0c', '#700606', '0', '会员', '', '', '1', '10.00', '', '', '', '', '0', '11', '', '', '', '', '', '', '', '0', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0', '0', '', '', '', '', '', '0.3', '0.5', '0.7', '1', '', '', '', '', '', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/pddsob', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jdsobg', '', '0');
INSERT INTO `ims_hcpdd_set` VALUES ('5', '57', '', '', null, '', '', '', '', '', '', '', '1', '', '', '', '', '0', '0', '', '', '0', '1', '1', '', '', '0', '会员', '', '', '1', '10.00', '', '', '', '', '0', '', '', '', '', '', '', '', '', '0', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0', '1', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '0');

-- ----------------------------
-- Table structure for `ims_hcpdd_shenhe`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_shenhe`;
CREATE TABLE `ims_hcpdd_shenhe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `stact` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `time` int(225) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_shenhe
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_shenheset`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_shenheset`;
CREATE TABLE `ims_hcpdd_shenheset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `goodsname1` varchar(255) NOT NULL DEFAULT '防滑挂钩家用小衣夹',
  `goodsname2` varchar(255) NOT NULL DEFAULT '多功能魔术伸缩晾衣服撑子',
  `goodsname3` varchar(255) NOT NULL DEFAULT '旅行收纳袋套装',
  `goodsname4` varchar(255) NOT NULL DEFAULT '旅行出差收纳袋4件套',
  `goodsname5` varchar(255) NOT NULL DEFAULT '旅行出差收纳袋4件套',
  `goodsname6` varchar(255) NOT NULL DEFAULT '海澜之家翻领PU皮夹克',
  `goodsname7` varchar(255) NOT NULL DEFAULT '学生港风休闲男士工装衣服',
  `goodsname8` varchar(255) NOT NULL DEFAULT '连衣裙2018秋冬新款',
  `goodsname9` varchar(255) NOT NULL DEFAULT '冬新款韩版修身V领雪纺衫',
  `goodsprice1` varchar(255) NOT NULL DEFAULT '19.9',
  `goodsprice2` varchar(255) NOT NULL DEFAULT '19.8',
  `goodsprice3` varchar(255) NOT NULL DEFAULT '88.8',
  `goodsprice4` varchar(255) NOT NULL DEFAULT '28.0',
  `goodsprice5` varchar(255) NOT NULL DEFAULT '149.0',
  `goodsprice6` varchar(255) NOT NULL DEFAULT '598.0',
  `goodsprice7` varchar(255) NOT NULL DEFAULT '128.0',
  `goodsprice8` varchar(255) NOT NULL DEFAULT '218.0',
  `goodsprice9` varchar(255) NOT NULL DEFAULT '149.0',
  `goodspic1` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n7/jfs/t22591/202/1901797918/139187/aefd9b42/5b6d3200Nefaaa468.jpg',
  `goodspic2` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n7/jfs/t16468/159/2189574984/239282/984fc307/5a97918eN4fdc42ff.jpg',
  `goodspic3` varchar(255) NOT NULL DEFAULT 'https://img10.360buyimg.com/n7/jfs/t19804/96/552338809/399239/366eac09/5afe5b44Ne946460b.jpg',
  `goodspic4` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n7/jfs/t19753/2/1230514607/107872/c01438cf/5ac310e9N78833b0f.jpg',
  `goodspic5` varchar(255) NOT NULL DEFAULT 'https://img11.360buyimg.com/n8/jfs/t26218/256/979754907/566598/c866583f/5bbef96aN5cd4cf7f.jpg',
  `goodspic6` varchar(255) NOT NULL DEFAULT 'https://img12.360buyimg.com/n8/jfs/t25039/362/848582219/364460/f8f9d832/5b7e8e7aN848e7e03.jpg',
  `goodspic7` varchar(255) NOT NULL DEFAULT 'https://img11.360buyimg.com/n8/jfs/t24982/277/1718337506/358352/1a9cc537/5bb9a59cN7388d8dd.jpg',
  `goodspic8` varchar(255) NOT NULL DEFAULT 'https://img10.360buyimg.com/n8/jfs/t1/7666/21/7609/396183/5be3a141E4631c62c/d3c82b7f2ac01055.jpg',
  `goodspic9` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n8/jfs/t1/4982/19/13210/407501/5bd7e9b6Efd5d85d9/133ae50abc56063c.jpg',
  `banner1` varchar(255) NOT NULL DEFAULT 'https://we10.66bbn.com/attachment/images/25/2018/11/Tn6II1stG5IN6NIFn6IwNIPCaasTPf.png',
  `banner2` varchar(255) NOT NULL DEFAULT 'https://we10.66bbn.com/attachment/images/25/2018/11/IA6p6cxGgqaP3l6a5K6aC3cZPcCg3l.png',
  `banner3` varchar(255) NOT NULL DEFAULT 'https://we10.66bbn.com/attachment/images/25/2018/11/E94VF65Elw0ks417zh1d934Ie1w437.png',
  `notice` varchar(255) NOT NULL DEFAULT '本程序商品仅做展示使用，喜欢的商品请到店购买',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_shenheset
-- ----------------------------
INSERT INTO `ims_hcpdd_shenheset` VALUES ('2', '31', '防滑挂钩家用小衣夹', '多功能魔术伸缩晾衣服撑子', '旅行收纳袋套装', '旅行出差收纳袋4件套', '旅行出差收纳袋4件套', '海澜之家翻领PU皮夹克', '学生港风休闲男士工装衣服', '连衣裙2018秋冬新款', '冬新款韩版修身V领雪纺衫', '19.9', '19.8', '88.8', '28.0', '149.0', '598.0', '128.0', '218.0', '149.0', 'https://img13.360buyimg.com/n7/jfs/t22591/202/1901797918/139187/aefd9b42/5b6d3200Nefaaa468.jpg', 'https://img13.360buyimg.com/n7/jfs/t16468/159/2189574984/239282/984fc307/5a97918eN4fdc42ff.jpg', 'https://img10.360buyimg.com/n7/jfs/t19804/96/552338809/399239/366eac09/5afe5b44Ne946460b.jpg', 'https://img13.360buyimg.com/n7/jfs/t19753/2/1230514607/107872/c01438cf/5ac310e9N78833b0f.jpg', 'https://img11.360buyimg.com/n8/jfs/t26218/256/979754907/566598/c866583f/5bbef96aN5cd4cf7f.jpg', 'https://img12.360buyimg.com/n8/jfs/t25039/362/848582219/364460/f8f9d832/5b7e8e7aN848e7e03.jpg', 'https://img11.360buyimg.com/n8/jfs/t24982/277/1718337506/358352/1a9cc537/5bb9a59cN7388d8dd.jpg', 'https://img10.360buyimg.com/n8/jfs/t1/7666/21/7609/396183/5be3a141E4631c62c/d3c82b7f2ac01055.jpg', 'https://img13.360buyimg.com/n8/jfs/t1/4982/19/13210/407501/5bd7e9b6Efd5d85d9/133ae50abc56063c.jpg', 'https://we10.66bbn.com/attachment/images/25/2018/11/Tn6II1stG5IN6NIFn6IwNIPCaasTPf.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/IA6p6cxGgqaP3l6a5K6aC3cZPcCg3l.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/E94VF65Elw0ks417zh1d934Ie1w437.png', '本程序商品仅做展示使用，喜欢的商品请到店购买');
INSERT INTO `ims_hcpdd_shenheset` VALUES ('3', '178', '防滑挂钩家用小衣夹', '多功能魔术伸缩晾衣服撑子', '旅行收纳袋套装', '旅行出差收纳袋4件套', '旅行出差收纳袋4件套', '海澜之家翻领PU皮夹克', '学生港风休闲男士工装衣服', '连衣裙2018秋冬新款', '冬新款韩版修身V领雪纺衫', '19.9', '19.8', '88.8', '28.0', '149.0', '598.0', '128.0', '218.0', '149.0', 'https://img13.360buyimg.com/n7/jfs/t22591/202/1901797918/139187/aefd9b42/5b6d3200Nefaaa468.jpg', 'https://img13.360buyimg.com/n7/jfs/t16468/159/2189574984/239282/984fc307/5a97918eN4fdc42ff.jpg', 'https://img10.360buyimg.com/n7/jfs/t19804/96/552338809/399239/366eac09/5afe5b44Ne946460b.jpg', 'https://img13.360buyimg.com/n7/jfs/t19753/2/1230514607/107872/c01438cf/5ac310e9N78833b0f.jpg', 'https://img11.360buyimg.com/n8/jfs/t26218/256/979754907/566598/c866583f/5bbef96aN5cd4cf7f.jpg', 'https://img12.360buyimg.com/n8/jfs/t25039/362/848582219/364460/f8f9d832/5b7e8e7aN848e7e03.jpg', 'https://img11.360buyimg.com/n8/jfs/t24982/277/1718337506/358352/1a9cc537/5bb9a59cN7388d8dd.jpg', 'https://img10.360buyimg.com/n8/jfs/t1/7666/21/7609/396183/5be3a141E4631c62c/d3c82b7f2ac01055.jpg', 'https://img13.360buyimg.com/n8/jfs/t1/4982/19/13210/407501/5bd7e9b6Efd5d85d9/133ae50abc56063c.jpg', 'https://we10.66bbn.com/attachment/images/25/2018/11/Tn6II1stG5IN6NIFn6IwNIPCaasTPf.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/IA6p6cxGgqaP3l6a5K6aC3cZPcCg3l.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/E94VF65Elw0ks417zh1d934Ie1w437.png', '本程序商品仅做展示使用，喜欢的商品请到店购买');
INSERT INTO `ims_hcpdd_shenheset` VALUES ('4', '89', '防滑挂钩家用小衣夹', '多功能魔术伸缩晾衣服撑子', '旅行收纳袋套装', '旅行出差收纳袋4件套', '旅行出差收纳袋4件套', '海澜之家翻领PU皮夹克', '学生港风休闲男士工装衣服', '连衣裙2018秋冬新款', '冬新款韩版修身V领雪纺衫', '19.9', '19.8', '88.8', '28.0', '149.0', '598.0', '128.0', '218.0', '149.0', 'https://img13.360buyimg.com/n7/jfs/t22591/202/1901797918/139187/aefd9b42/5b6d3200Nefaaa468.jpg', 'https://img13.360buyimg.com/n7/jfs/t16468/159/2189574984/239282/984fc307/5a97918eN4fdc42ff.jpg', 'https://img10.360buyimg.com/n7/jfs/t19804/96/552338809/399239/366eac09/5afe5b44Ne946460b.jpg', 'https://img13.360buyimg.com/n7/jfs/t19753/2/1230514607/107872/c01438cf/5ac310e9N78833b0f.jpg', 'https://img11.360buyimg.com/n8/jfs/t26218/256/979754907/566598/c866583f/5bbef96aN5cd4cf7f.jpg', 'https://img12.360buyimg.com/n8/jfs/t25039/362/848582219/364460/f8f9d832/5b7e8e7aN848e7e03.jpg', 'https://img11.360buyimg.com/n8/jfs/t24982/277/1718337506/358352/1a9cc537/5bb9a59cN7388d8dd.jpg', 'https://img10.360buyimg.com/n8/jfs/t1/7666/21/7609/396183/5be3a141E4631c62c/d3c82b7f2ac01055.jpg', 'https://img13.360buyimg.com/n8/jfs/t1/4982/19/13210/407501/5bd7e9b6Efd5d85d9/133ae50abc56063c.jpg', 'https://we10.66bbn.com/attachment/images/25/2018/11/Tn6II1stG5IN6NIFn6IwNIPCaasTPf.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/IA6p6cxGgqaP3l6a5K6aC3cZPcCg3l.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/E94VF65Elw0ks417zh1d934Ie1w437.png', '本程序商品仅做展示使用，喜欢的商品请到店购买');
INSERT INTO `ims_hcpdd_shenheset` VALUES ('5', '1', '防滑挂钩家用小衣夹', '多功能魔术伸缩晾衣服撑子', '旅行收纳袋套装', '旅行出差收纳袋4件套', '旅行出差收纳袋4件套', '海澜之家翻领PU皮夹克', '学生港风休闲男士工装衣服', '连衣裙2018秋冬新款', '冬新款韩版修身V领雪纺衫', '19.9', '19.8', '88.8', '28.0', '149.0', '598.0', '128.0', '218.0', '149.0', 'https://img13.360buyimg.com/n7/jfs/t22591/202/1901797918/139187/aefd9b42/5b6d3200Nefaaa468.jpg', 'https://img13.360buyimg.com/n7/jfs/t16468/159/2189574984/239282/984fc307/5a97918eN4fdc42ff.jpg', 'https://img10.360buyimg.com/n7/jfs/t19804/96/552338809/399239/366eac09/5afe5b44Ne946460b.jpg', 'https://img13.360buyimg.com/n7/jfs/t19753/2/1230514607/107872/c01438cf/5ac310e9N78833b0f.jpg', 'https://img11.360buyimg.com/n8/jfs/t26218/256/979754907/566598/c866583f/5bbef96aN5cd4cf7f.jpg', 'https://img12.360buyimg.com/n8/jfs/t25039/362/848582219/364460/f8f9d832/5b7e8e7aN848e7e03.jpg', 'https://img11.360buyimg.com/n8/jfs/t24982/277/1718337506/358352/1a9cc537/5bb9a59cN7388d8dd.jpg', 'https://img10.360buyimg.com/n8/jfs/t1/7666/21/7609/396183/5be3a141E4631c62c/d3c82b7f2ac01055.jpg', 'https://img13.360buyimg.com/n8/jfs/t1/4982/19/13210/407501/5bd7e9b6Efd5d85d9/133ae50abc56063c.jpg', 'https://we10.66bbn.com/attachment/images/25/2018/11/Tn6II1stG5IN6NIFn6IwNIPCaasTPf.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/IA6p6cxGgqaP3l6a5K6aC3cZPcCg3l.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/E94VF65Elw0ks417zh1d934Ie1w437.png', '本程序商品仅做展示使用，喜欢的商品请到店购买');
INSERT INTO `ims_hcpdd_shenheset` VALUES ('6', '18', '防滑挂钩家用小衣夹', '多功能魔术伸缩晾衣服撑子', '旅行收纳袋套装', '旅行出差收纳袋4件套', '旅行出差收纳袋4件套', '海澜之家翻领PU皮夹克', '学生港风休闲男士工装衣服', '连衣裙2018秋冬新款', '冬新款韩版修身V领雪纺衫', '19.9', '19.8', '88.8', '28.0', '149.0', '598.0', '128.0', '218.0', '149.0', 'https://img13.360buyimg.com/n7/jfs/t22591/202/1901797918/139187/aefd9b42/5b6d3200Nefaaa468.jpg', 'https://img13.360buyimg.com/n7/jfs/t16468/159/2189574984/239282/984fc307/5a97918eN4fdc42ff.jpg', 'https://img10.360buyimg.com/n7/jfs/t19804/96/552338809/399239/366eac09/5afe5b44Ne946460b.jpg', 'https://img13.360buyimg.com/n7/jfs/t19753/2/1230514607/107872/c01438cf/5ac310e9N78833b0f.jpg', 'https://img11.360buyimg.com/n8/jfs/t26218/256/979754907/566598/c866583f/5bbef96aN5cd4cf7f.jpg', 'https://img12.360buyimg.com/n8/jfs/t25039/362/848582219/364460/f8f9d832/5b7e8e7aN848e7e03.jpg', 'https://img11.360buyimg.com/n8/jfs/t24982/277/1718337506/358352/1a9cc537/5bb9a59cN7388d8dd.jpg', 'https://img10.360buyimg.com/n8/jfs/t1/7666/21/7609/396183/5be3a141E4631c62c/d3c82b7f2ac01055.jpg', 'https://img13.360buyimg.com/n8/jfs/t1/4982/19/13210/407501/5bd7e9b6Efd5d85d9/133ae50abc56063c.jpg', 'https://we10.66bbn.com/attachment/images/25/2018/11/Tn6II1stG5IN6NIFn6IwNIPCaasTPf.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/IA6p6cxGgqaP3l6a5K6aC3cZPcCg3l.png', 'https://we10.66bbn.com/attachment/images/25/2018/11/E94VF65Elw0ks417zh1d934Ie1w437.png', '本程序商品仅做展示使用，喜欢的商品请到店购买');

-- ----------------------------
-- Table structure for `ims_hcpdd_show`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_show`;
CREATE TABLE `ims_hcpdd_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `show1` varchar(100) DEFAULT NULL,
  `show2` varchar(100) DEFAULT NULL,
  `show3` varchar(100) DEFAULT NULL,
  `show4` varchar(100) DEFAULT NULL,
  `show5` varchar(100) DEFAULT NULL,
  `rexiao1` varchar(60) NOT NULL,
  `rexiao2` varchar(60) NOT NULL,
  `baoyou1` varchar(60) NOT NULL,
  `baoyou2` varchar(60) NOT NULL,
  `youhui1` varchar(60) NOT NULL,
  `youhui2` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_show
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_son`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_son`;
CREATE TABLE `ims_hcpdd_son` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `son_uniacid` int(11) DEFAULT NULL,
  `son_pid` varchar(255) DEFAULT NULL,
  `son_rate` varchar(255) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `finishmoney` decimal(10,2) NOT NULL,
  `waitmoney` decimal(10,2) NOT NULL,
  `son_gid` varchar(100) NOT NULL,
  `son_positionId` varchar(100) NOT NULL,
  `beizhu` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_son
-- ----------------------------
INSERT INTO `ims_hcpdd_son` VALUES ('1', '31', '178', '', '0.8', '0.00', '0.00', '0.00', '', '', '');

-- ----------------------------
-- Table structure for `ims_hcpdd_theme`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_theme`;
CREATE TABLE `ims_hcpdd_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `goods` varchar(1000) DEFAULT NULL,
  `mainpic` varchar(100) DEFAULT NULL,
  `enabled` int(11) DEFAULT NULL,
  `jump` int(11) NOT NULL DEFAULT '1',
  `zhuti_color` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_theme
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_tixian`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_tixian`;
CREATE TABLE `ims_hcpdd_tixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `tel` varchar(20) NOT NULL COMMENT '手机号',
  `truename` varchar(20) NOT NULL COMMENT '姓名',
  `weixin` varchar(20) NOT NULL COMMENT '微信号',
  `payment_time` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_tixian
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_token`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_token`;
CREATE TABLE `ims_hcpdd_token` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `access_token` varchar(200) DEFAULT NULL,
  `expires_in` int(20) DEFAULT NULL,
  `refresh_token` varchar(200) DEFAULT NULL,
  `owner_id` varchar(20) DEFAULT NULL,
  `owner_name` varchar(50) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `update_time` int(20) DEFAULT NULL,
  `create_time` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_token
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_treelog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_treelog`;
CREATE TABLE `ims_hcpdd_treelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hbmoney` decimal(10,2) DEFAULT NULL,
  `son_id` int(11) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `hb_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`uniacid`,`user_id`,`son_id`,`hb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_treelog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_treewith`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_treewith`;
CREATE TABLE `ims_hcpdd_treewith` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `add_time` varchar(255) DEFAULT NULL,
  `pay_time` varchar(255) DEFAULT NULL,
  `partner_trade_no` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `nick_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_treewith
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_treewithzfb`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_treewithzfb`;
CREATE TABLE `ims_hcpdd_treewithzfb` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `tel` varchar(20) NOT NULL,
  `zhifubao` varchar(50) NOT NULL,
  `truename` varchar(20) NOT NULL,
  `money` decimal(11,2) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `paytime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_treewithzfb
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpdd_tuijian`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_tuijian`;
CREATE TABLE `ims_hcpdd_tuijian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `displayorder` varchar(20) DEFAULT NULL,
  `jump` int(11) DEFAULT NULL,
  `toppic` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title2` varchar(255) DEFAULT NULL,
  `titlecolor` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_tuijian
-- ----------------------------
INSERT INTO `ims_hcpdd_tuijian` VALUES ('1', '178', '1', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/all.jpg', '全部', '猜你喜欢', '#cc0000');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('2', '178', '2', '1', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/mogu.jpg', '蘑菇街', '美丽女装', '#fa8ac1');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('3', '178', '3', '2', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/baokuan.jpg', '爆品', '今日爆款', '#434343');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('4', '178', '4', '3', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/gaoyong.jpg', '高佣', '好卖好赚', '#ff9900');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('5', '178', '5', '4', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/99.jpg', '9.9包邮', '限时优惠', '#93c47d');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('6', '178', '6', '5', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/pinpai.jpg', '品牌优惠', '知名品牌', '#3d85c6');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('7', '178', '7', '6', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/paihang.jpg', '排行榜', '实时更新', '#9900ff');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('8', '178', '8', '7', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jd.jpg', '京东爆品', '就要省钱', '#ff0000');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('9', '89', '1', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/all.jpg', '全部', '猜你喜欢', '#cc0000');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('10', '89', '2', '1', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/mogu.jpg', '蘑菇街', '美丽女装', '#fa8ac1');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('11', '89', '3', '2', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/baokuan.jpg', '爆品', '今日爆款', '#434343');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('12', '89', '4', '3', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/gaoyong.jpg', '高佣', '好卖好赚', '#ff9900');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('13', '89', '5', '4', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/99.jpg', '9.9包邮', '限时优惠', '#93c47d');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('14', '89', '6', '5', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/pinpai.jpg', '品牌优惠', '知名品牌', '#3d85c6');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('15', '89', '7', '6', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/paihang.jpg', '排行榜', '实时更新', '#9900ff');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('16', '89', '8', '7', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jd.jpg', '京东爆品', '就要省钱', '#ff0000');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('17', '31', '1', '0', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/all.jpg', '全部', '猜你喜欢', '#cc0000');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('18', '31', '2', '1', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/mogu.jpg', '蘑菇街', '美丽女装', '#fa8ac1');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('19', '31', '3', '2', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/baokuan.jpg', '爆品', '今日爆款', '#434343');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('20', '31', '4', '3', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/gaoyong.jpg', '高佣', '好卖好赚', '#ff9900');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('21', '31', '5', '4', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/99.jpg', '9.9包邮', '限时优惠', '#93c47d');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('22', '31', '6', '5', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/pinpai.jpg', '品牌优惠', '知名品牌', '#3d85c6');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('23', '31', '7', '6', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/paihang.jpg', '排行榜', '实时更新', '#9900ff');
INSERT INTO `ims_hcpdd_tuijian` VALUES ('24', '31', '8', '7', 'http://yanshi.suyituike.cn/addons/hc_pdd/template/img/jd.jpg', '京东爆品', '就要省钱', '#ff0000');

-- ----------------------------
-- Table structure for `ims_hcpdd_users`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_users`;
CREATE TABLE `ims_hcpdd_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `head_pic` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `hcpdd_sum` int(11) NOT NULL DEFAULT '0' COMMENT '参与次数',
  `hcpdd_zuida` int(11) NOT NULL DEFAULT '0' COMMENT '参与最大',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '可提现金额',
  `finishmoney` decimal(8,2) NOT NULL COMMENT '已提现金额',
  `waitmoney` decimal(8,2) NOT NULL COMMENT '待审核金额',
  `zhuangtai` int(11) NOT NULL DEFAULT '1',
  `pid` varchar(50) NOT NULL,
  `cmoney` decimal(10,2) NOT NULL COMMENT '提成',
  `cfinishmoney` decimal(10,2) NOT NULL,
  `cwaitmoney` decimal(10,2) NOT NULL,
  `is_daili` int(10) NOT NULL COMMENT '1代理0不是代理',
  `fatherid` int(11) NOT NULL COMMENT '父id',
  `mobile` varchar(255) DEFAULT NULL,
  `treemoney` decimal(10,2) NOT NULL,
  `gid` int(11) DEFAULT NULL COMMENT '蘑菇街渠道id',
  `positionId` int(11) DEFAULT NULL COMMENT '京东推广位',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `KEY` (`uniacid`,`open_id`),
  KEY `fatherid` (`fatherid`),
  KEY `is_daili` (`is_daili`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=2460 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_users
-- ----------------------------
INSERT INTO `ims_hcpdd_users` VALUES ('2457', '31', '1', 'Wuhan', 'China', '2', 'oirOf4lh5rKDqTH6FchjsoD0U1cI', '。。。', 'https://wx.qlogo.cn/mmopen/vi_32/JZ69SwQqoIlYibbbiauVDKVSqE9nf6qIqSRvBDtnNHaBmSrTRXAg5AZfHrP35icIV7EgDgMQgJY6ogPRqTH1I3pXg/132', 'Hubei', '0', '0', '0.00', '0.00', '0.00', '1', '', '0.00', '0.00', '0.00', '0', '0', null, '0.00', null, '1827636576');
INSERT INTO `ims_hcpdd_users` VALUES ('2458', '8', '1', 'Dezhou', 'China', '1', 'undefined', '宗介', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLP01AfwPJrXesHxbNeA60THsAIGRe2h18y7EFnuDfVMrTQNmrsJpEddvSxs1Yiaicdpz4G7XTYNZIQ/132', 'Shandong', '0', '0', '0.00', '0.00', '0.00', '1', '', '0.00', '0.00', '0.00', '0', '0', null, '0.00', null, null);
INSERT INTO `ims_hcpdd_users` VALUES ('2459', '31', '1', 'Jian', 'China', '1', 'undefined', '晓风残月', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJCibK4vibpMQledRrZSPKDFoz33CjsHaG5ibjzOQ93XbHVglhkIowljDicaD0teHDx6NlDbCGsQD0Piaw/132', 'Jiangxi', '0', '0', '0.00', '0.00', '0.00', '1', '', '0.00', '0.00', '0.00', '1', '0', null, '0.00', null, '1859890716');

-- ----------------------------
-- Table structure for `ims_hcpdd_with`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpdd_with`;
CREATE TABLE `ims_hcpdd_with` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `add_time` varchar(255) DEFAULT NULL,
  `pay_time` varchar(255) DEFAULT NULL,
  `partner_trade_no` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `nick_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpdd_with
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_adv`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_adv`;
CREATE TABLE `ims_hcpddson_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `jump` int(11) NOT NULL COMMENT '跳转方式',
  `xcxpath` varchar(255) NOT NULL,
  `xcxappid` varchar(255) NOT NULL,
  `diypic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_adv
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_coupons`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_coupons`;
CREATE TABLE `ims_hcpddson_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `now_price` varchar(255) DEFAULT NULL,
  `coupon_discount` varchar(255) DEFAULT NULL,
  `goods_thumbnail_url` varchar(255) DEFAULT NULL,
  `get_time` varchar(255) DEFAULT NULL,
  `goods_id` varchar(255) NOT NULL,
  `parameter` int(11) NOT NULL,
  `itemUrl` varchar(200) NOT NULL,
  `skuId` varchar(200) NOT NULL,
  `couponUrl` varchar(200) NOT NULL,
  `materialUrl` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=437 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_coupons
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_hblog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_hblog`;
CREATE TABLE `ims_hcpddson_hblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hongbaotime` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0未转发1已转发',
  `s_time` varchar(255) NOT NULL COMMENT '领取红包时间戳',
  `e_time` varchar(255) NOT NULL COMMENT '红包结束时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_hblog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_history`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_history`;
CREATE TABLE `ims_hcpddson_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `sotime` varchar(255) NOT NULL COMMENT '搜索时间',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=996 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_history
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_hongbao`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_hongbao`;
CREATE TABLE `ims_hcpddson_hongbao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `is_open` int(11) DEFAULT NULL,
  `open_bg` varchar(255) DEFAULT NULL,
  `firstmoney` int(11) DEFAULT NULL,
  `zhuanfamoney` int(11) DEFAULT NULL,
  `shareinfo` varchar(255) NOT NULL,
  `sharetitle` varchar(255) NOT NULL,
  `fenxiangtitle` varchar(255) NOT NULL,
  `fenxiangpic` varchar(255) NOT NULL,
  `hb_day` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_hongbao
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_message`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_message`;
CREATE TABLE `ims_hcpddson_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `msgid` varchar(255) DEFAULT NULL,
  `keyword1` varchar(255) DEFAULT NULL,
  `keyword2` varchar(255) DEFAULT NULL,
  `keyword3` varchar(255) DEFAULT NULL,
  `hongbao_msgid` varchar(255) NOT NULL,
  `fenxiao_msgid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_message
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_nav`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_nav`;
CREATE TABLE `ims_hcpddson_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `parentid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cateid` int(10) NOT NULL,
  `icon` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '0',
  `tpl` varchar(50) NOT NULL COMMENT '模板类型',
  `jump` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_nav
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_notice`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_notice`;
CREATE TABLE `ims_hcpddson_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `enabled` tinyint(3) NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_set`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_set`;
CREATE TABLE `ims_hcpddson_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `father_uniacid` int(11) NOT NULL,
  `client_id` varchar(100) DEFAULT NULL COMMENT 'client_id',
  `client_secret` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL COMMENT '联系人',
  `contact_qr` varchar(200) NOT NULL COMMENT '联系二维码',
  `share_icon` varchar(200) NOT NULL COMMENT '分享图标',
  `loginbg` varchar(200) NOT NULL COMMENT '登录页背景图',
  `sohead` varchar(100) NOT NULL COMMENT '超级搜头部图',
  `sobg` varchar(100) NOT NULL COMMENT '超级搜背景图',
  `bg_pic` varchar(200) NOT NULL COMMENT '个人中心头部背景',
  `head_color` varchar(20) NOT NULL,
  `search_color` varchar(20) NOT NULL COMMENT '搜索框颜色',
  `tixianb_color` varchar(20) NOT NULL COMMENT '提现按钮颜色',
  `tixiant_color` varchar(20) NOT NULL COMMENT '提现字体颜色',
  `moneyrate` float NOT NULL DEFAULT '1' COMMENT '用户佣金比例',
  `title` varchar(100) NOT NULL COMMENT '小程序标题',
  `share` varchar(100) NOT NULL DEFAULT '分享赚' COMMENT '分享赚',
  `self` varchar(100) NOT NULL DEFAULT '自省买' COMMENT '自省买',
  `enable` int(10) NOT NULL COMMENT '1直连拼多多0中转',
  `shenhe` int(10) NOT NULL COMMENT '审核状态',
  `is_index` int(10) NOT NULL COMMENT '1显示0不显示',
  `sharecolor` varchar(255) NOT NULL COMMENT '商品详情分享赚按钮',
  `selfcolor` varchar(255) NOT NULL COMMENT '商品详情自省买按钮',
  `huiyuan` varchar(255) NOT NULL DEFAULT '会员',
  `contactway` int(10) NOT NULL DEFAULT '0',
  `indextitle` varchar(255) NOT NULL,
  `indexpic` varchar(255) NOT NULL,
  `pid` varchar(100) NOT NULL,
  `version` varchar(255) NOT NULL,
  `zzappid` varchar(255) NOT NULL,
  `gid` varchar(100) NOT NULL,
  `positionId` varchar(100) NOT NULL,
  `wtype` int(11) NOT NULL,
  `tx_money` float(10,2) NOT NULL,
  `tx_intro` varchar(255) NOT NULL,
  `zeroshare` varchar(255) NOT NULL,
  `zerobuy` varchar(255) NOT NULL,
  `getmobile` int(11) NOT NULL,
  `top` varchar(255) NOT NULL,
  `goodtop` varchar(255) NOT NULL,
  `copy_writer` varchar(255) NOT NULL,
  `copy_headpic` varchar(255) NOT NULL,
  `sptj` varchar(50) NOT NULL,
  `scyx` varchar(50) NOT NULL,
  `xsbf` varchar(50) NOT NULL,
  `is_tree` int(11) NOT NULL,
  `min_treemoney` decimal(10,2) NOT NULL,
  `max_treemoney` decimal(10,2) NOT NULL,
  `min_treetxmoney` decimal(10,2) NOT NULL,
  `tree_pic` varchar(255) NOT NULL,
  `treesharepic` varchar(255) NOT NULL,
  `treesharetitle` varchar(255) NOT NULL,
  `treeadultid` varchar(50) NOT NULL,
  `treewith_pic` varchar(200) NOT NULL,
  `treeinfo` varchar(200) NOT NULL,
  `app_key` varchar(50) NOT NULL,
  `app_secret` varchar(50) NOT NULL,
  `access_token` varchar(50) NOT NULL,
  `mogurate` varchar(10) NOT NULL,
  `mogudailirate` varchar(10) NOT NULL,
  `moguzongjianrate` varchar(10) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `is_mogu` int(11) NOT NULL,
  `tree_pic2` varchar(60) NOT NULL,
  `tuijian_type` int(11) NOT NULL,
  `is_jd` int(11) NOT NULL,
  `unionId` varchar(50) NOT NULL,
  `jdappkey` varchar(50) NOT NULL,
  `jdsecretkey` varchar(50) NOT NULL,
  `siteid` varchar(50) NOT NULL,
  `jdkey` varchar(100) NOT NULL,
  `jdrate` varchar(10) NOT NULL,
  `jddailirate` varchar(10) NOT NULL,
  `jdzongjianrate` varchar(10) NOT NULL,
  `is_kouhong` int(11) NOT NULL,
  `kouhong_pic` varchar(60) NOT NULL,
  `kouhong_sharetitle` varchar(100) NOT NULL,
  `kouhong_sharepic` varchar(60) NOT NULL,
  `kouhong_ids` varchar(200) NOT NULL,
  `kouhong_color` varchar(100) NOT NULL,
  `treeposter` varchar(60) NOT NULL,
  `pddsobg` varchar(100) NOT NULL,
  `jdsobg` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_set
-- ----------------------------
INSERT INTO `ims_hcpddson_set` VALUES ('38', '121212', '31', '', '', null, '', '', '', '', '', '', '', '', '', '', '12', '', '分享赚', '自省买', '0', '0', '0', '', '', '会员', '0', '', '', '', '', '', '', '', '0', '0.00', '', '', '', '0', '', '', '', '', '', '', '', '0', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0', '0', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '');
INSERT INTO `ims_hcpddson_set` VALUES ('39', null, '0', null, '', null, '', '', '', '', '', '', '', '', '', '', '1', '', '分享赚', '自省买', '0', '0', '0', '', '', '会员', '0', '', '', '', '4.0', '', '', '', '0', '0.00', '', '', '', '0', '', '', '', '', '', '', '', '0', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0', '0', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '');
INSERT INTO `ims_hcpddson_set` VALUES ('40', '178', '31', '', '', '', '', '', '', '', '', '', '', '', '', '', '0.8', '', '分享赚', '自省买', '0', '1', '0', '', '', '会员', '0', '', '', '', '', '', '', '', '0', '0.00', '', '', '', '0', '', '', '', '', '', '', '', '0', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0', '0', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for `ims_hcpddson_shenhe`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_shenhe`;
CREATE TABLE `ims_hcpddson_shenhe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `stact` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `time` int(225) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_shenhe
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_shenheset`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_shenheset`;
CREATE TABLE `ims_hcpddson_shenheset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `goodsname1` varchar(255) NOT NULL,
  `goodsname2` varchar(255) NOT NULL,
  `goodsname3` varchar(255) NOT NULL,
  `goodsname4` varchar(255) NOT NULL,
  `goodsname5` varchar(255) NOT NULL,
  `goodsname6` varchar(255) NOT NULL,
  `goodsname7` varchar(255) NOT NULL,
  `goodsname8` varchar(255) NOT NULL,
  `goodsname9` varchar(255) NOT NULL,
  `goodsprice1` varchar(255) NOT NULL,
  `goodsprice2` varchar(255) NOT NULL,
  `goodsprice3` varchar(255) NOT NULL,
  `goodsprice4` varchar(255) NOT NULL,
  `goodsprice5` varchar(255) NOT NULL,
  `goodsprice6` varchar(255) NOT NULL,
  `goodsprice7` varchar(255) NOT NULL,
  `goodsprice8` varchar(255) NOT NULL,
  `goodsprice9` varchar(255) NOT NULL,
  `goodspic1` varchar(255) NOT NULL,
  `goodspic2` varchar(255) NOT NULL,
  `goodspic3` varchar(255) NOT NULL,
  `goodspic4` varchar(255) NOT NULL,
  `goodspic5` varchar(255) NOT NULL,
  `goodspic6` varchar(255) NOT NULL,
  `goodspic7` varchar(255) NOT NULL,
  `goodspic8` varchar(255) NOT NULL,
  `goodspic9` varchar(255) NOT NULL,
  `banner1` varchar(255) NOT NULL,
  `banner2` varchar(255) NOT NULL,
  `banner3` varchar(255) NOT NULL,
  `notice` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_shenheset
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_show`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_show`;
CREATE TABLE `ims_hcpddson_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `show1` varchar(100) DEFAULT NULL,
  `show2` varchar(100) DEFAULT NULL,
  `show3` varchar(100) DEFAULT NULL,
  `show4` varchar(100) DEFAULT NULL,
  `show5` varchar(100) DEFAULT NULL,
  `rexiao1` varchar(100) NOT NULL,
  `rexiao2` varchar(100) NOT NULL,
  `baoyou1` varchar(100) NOT NULL,
  `baoyou2` varchar(100) NOT NULL,
  `youhui1` varchar(100) NOT NULL,
  `youhui2` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_show
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_son`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_son`;
CREATE TABLE `ims_hcpddson_son` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `son_uniacid` int(11) DEFAULT NULL,
  `son_pid` varchar(255) DEFAULT NULL,
  `son_rate` varchar(255) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `finishmoney` decimal(10,2) NOT NULL,
  `waitmoney` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_son
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_theme`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_theme`;
CREATE TABLE `ims_hcpddson_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `goods` varchar(1000) DEFAULT NULL,
  `mainpic` varchar(100) DEFAULT NULL,
  `enabled` int(11) DEFAULT NULL,
  `jump` int(11) NOT NULL DEFAULT '1',
  `zhuti_color` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_theme
-- ----------------------------
INSERT INTO `ims_hcpddson_theme` VALUES ('8', '178', '平多读多多多多', 'images/178/2019/07/qgBDyJ1YJkIiaKGikA5d9B9BeIAjaj.jpeg', '平多读多多多多', 'images/178/2019/07/qgBDyJ1YJkIiaKGikA5d9B9BeIAjaj.jpeg', '1', '0', '');

-- ----------------------------
-- Table structure for `ims_hcpddson_tixian`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_tixian`;
CREATE TABLE `ims_hcpddson_tixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `tel` varchar(20) NOT NULL,
  `truename` varchar(20) NOT NULL,
  `weixin` varchar(20) NOT NULL,
  `payment_time` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `money` decimal(11,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_tixian
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_tuijian`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_tuijian`;
CREATE TABLE `ims_hcpddson_tuijian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `displayorder` varchar(20) DEFAULT NULL,
  `jump` int(11) DEFAULT NULL,
  `toppic` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title2` varchar(255) DEFAULT NULL,
  `titlecolor` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_tuijian
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_users`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_users`;
CREATE TABLE `ims_hcpddson_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `head_pic` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `hcpdd_sum` int(11) NOT NULL DEFAULT '0' COMMENT '参与次数',
  `hcpdd_zuida` int(11) NOT NULL DEFAULT '0' COMMENT '参与最大',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '可提现金额',
  `finishmoney` decimal(8,2) NOT NULL COMMENT '已提现金额',
  `waitmoney` decimal(8,2) NOT NULL COMMENT '待审核金额',
  `cmoney` decimal(10,2) NOT NULL COMMENT '提成',
  `cfinishmoney` decimal(10,2) NOT NULL,
  `cwaitmoney` decimal(10,2) NOT NULL,
  `zhuangtai` int(11) NOT NULL DEFAULT '1',
  `pid` varchar(50) NOT NULL,
  `is_daili` int(10) NOT NULL COMMENT '1代理0不是代理',
  `fatherid` int(11) NOT NULL COMMENT '父id',
  `gid` int(11) DEFAULT NULL,
  `positionId` int(11) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `treemoney` decimal(10,2) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `KEY` (`uniacid`,`open_id`),
  KEY `fatherid` (`fatherid`),
  KEY `is_daili` (`is_daili`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=361 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_users
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcpddson_with`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcpddson_with`;
CREATE TABLE `ims_hcpddson_with` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `add_time` varchar(255) DEFAULT NULL,
  `pay_time` varchar(255) DEFAULT NULL,
  `partner_trade_no` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `nick_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcpddson_with
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_activity`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_activity`;
CREATE TABLE `ims_hcstep_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `step` varchar(255) DEFAULT NULL,
  `entryfee` varchar(255) DEFAULT NULL,
  `displayorder` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_activity
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_activitylog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_activitylog`;
CREATE TABLE `ims_hcstep_activitylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL COMMENT '活动id',
  `timestamp` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `entryfee` varchar(255) DEFAULT NULL,
  `step` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0未达标1已达标，未发奖2已达标，已发奖',
  `jiangjin` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`aid`,`time`,`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=124 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_activitylog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_adv`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_adv`;
CREATE TABLE `ims_hcstep_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `jump` int(11) NOT NULL COMMENT '跳转方式 0 不跳转 1 小程序',
  `xcxpath` varchar(255) NOT NULL,
  `xcxappid` varchar(255) NOT NULL,
  `h5` varchar(2555) NOT NULL,
  `tippic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_uniacid` (`uniacid`) USING BTREE,
  KEY `idx_enabled` (`enabled`) USING BTREE,
  KEY `idx_displayorder` (`displayorder`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_adv
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_awards`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_awards`;
CREATE TABLE `ims_hcstep_awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `goods_name` varchar(255) DEFAULT NULL,
  `main_img` varchar(255) DEFAULT NULL,
  `goods_img` varchar(2555) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `inventory` varchar(255) DEFAULT NULL,
  `express` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1 上架 2 下架',
  `rate` varchar(10) NOT NULL COMMENT '中奖率',
  `awards_type` int(11) NOT NULL DEFAULT '1' COMMENT '1真实商品2步数币3红包',
  `awards_coin` varchar(10) NOT NULL,
  `awards_money` decimal(10,2) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_awards
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_bushulog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_bushulog`;
CREATE TABLE `ims_hcstep_bushulog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT '0',
  `bushu` varchar(255) DEFAULT NULL,
  `money` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `timestamp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`uniacid`,`user_id`,`time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11129 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_bushulog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_comment`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_comment`;
CREATE TABLE `ims_hcstep_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '评论人',
  `dt_id` int(11) DEFAULT NULL COMMENT '评论的哪条动态',
  `content` varchar(1000) DEFAULT NULL COMMENT '评论的内容',
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`uniacid`,`user_id`,`dt_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_dt`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_dt`;
CREATE TABLE `ims_hcstep_dt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` varchar(2555) DEFAULT NULL COMMENT '文字内容',
  `position` varchar(255) NOT NULL,
  `content_img` varchar(2555) DEFAULT NULL,
  `comment` varchar(1000) DEFAULT NULL COMMENT '评论id集合',
  `zan` varchar(11) DEFAULT NULL COMMENT '点赞数',
  `time` varchar(20) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL COMMENT '话题id',
  `status` int(11) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `uniacid` (`uniacid`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_dt
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_follow`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_follow`;
CREATE TABLE `ims_hcstep_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '关注人',
  `follow_id` int(11) DEFAULT NULL COMMENT '被关注人',
  `time` varchar(100) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uniacid` (`uniacid`,`user_id`,`follow_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_follow
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_formid`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_formid`;
CREATE TABLE `ims_hcstep_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `formid` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`,`status`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12640 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_formid
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_fourhblog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_fourhblog`;
CREATE TABLE `ims_hcstep_fourhblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `son_id` int(11) DEFAULT NULL,
  `hbmoney` decimal(10,2) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `daytime` varchar(50) DEFAULT NULL,
  `type` int(11) NOT NULL COMMENT '1大红包2小红包',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0待解锁1待开启2已开启',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`uniacid`,`type`,`status`,`daytime`,`user_id`,`son_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_fourhblog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_goods`;
CREATE TABLE `ims_hcstep_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `goods_name` varchar(255) DEFAULT NULL,
  `main_img` varchar(255) DEFAULT NULL,
  `goods_img` varchar(2555) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `inventory` varchar(255) DEFAULT NULL,
  `express` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1 上架 2 下架',
  `displayorder` int(11) NOT NULL,
  `goodsinfo` varchar(9999) NOT NULL,
  `paytype` int(11) NOT NULL COMMENT '支付方式',
  `price2` decimal(10,2) NOT NULL COMMENT '步数加钱 步数币',
  `rmb` varchar(255) NOT NULL COMMENT '人民币',
  `maxrmb` varchar(255) NOT NULL COMMENT '人民币原价',
  `selltype` int(11) NOT NULL COMMENT '0普通1核销',
  `shop_id` int(11) NOT NULL,
  `minpeople` varchar(20) NOT NULL COMMENT '邀请人数',
  `maxbuy` varchar(20) NOT NULL DEFAULT '0',
  `indexsort_id` int(11) NOT NULL,
  `sort_id` int(11) NOT NULL,
  `is_hongbao` int(11) NOT NULL,
  `maxhongbao` varchar(20) NOT NULL,
  `validity` varchar(20) NOT NULL DEFAULT '0' COMMENT '核销码有效期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_guanzhulog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_guanzhulog`;
CREATE TABLE `ims_hcstep_guanzhulog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `step` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`uniacid`,`time`,`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_guanzhulog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_hbwith`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_hbwith`;
CREATE TABLE `ims_hcstep_hbwith` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `add_time` varchar(255) DEFAULT NULL,
  `pay_time` varchar(255) DEFAULT NULL,
  `partner_trade_no` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `nick_name` varchar(255) NOT NULL,
  `tx_type` int(11) NOT NULL COMMENT '2收款码 其他企业付款',
  `src` varchar(255) NOT NULL COMMENT '收款码地址',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_hbwith
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_hongbao`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_hongbao`;
CREATE TABLE `ims_hcstep_hongbao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `hongbaopic` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `hongbaomoney` varchar(255) NOT NULL,
  `hongbaoname` varchar(255) NOT NULL,
  `hongbaonamecolor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_uniacid` (`uniacid`) USING BTREE,
  KEY `idx_enabled` (`enabled`) USING BTREE,
  KEY `idx_displayorder` (`displayorder`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_hongbao
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_hongbaolog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_hongbaolog`;
CREATE TABLE `ims_hcstep_hongbaolog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `sonid` int(11) DEFAULT NULL,
  `invite_time` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`uniacid`,`user_id`,`sonid`,`invite_time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_hongbaolog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_huodong`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_huodong`;
CREATE TABLE `ims_hcstep_huodong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `displayorder` varchar(20) DEFAULT '' COMMENT '排序',
  `jump` varchar(20) DEFAULT NULL COMMENT '1抽奖2步数挑战3步数商城4小程序5h5',
  `entrypic` varchar(100) DEFAULT NULL,
  `xcxpath` varchar(255) DEFAULT NULL,
  `xcxappid` varchar(255) DEFAULT NULL,
  `h5` varchar(255) DEFAULT NULL,
  `diypic` varchar(255) NOT NULL,
  `step` varchar(50) NOT NULL,
  `ad` varchar(55) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_huodong
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_icon`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_icon`;
CREATE TABLE `ims_hcstep_icon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `jump` int(11) NOT NULL COMMENT '跳转方式 0 运动提醒1汗水日子2其他',
  `xcxpath` varchar(255) NOT NULL,
  `xcxappid` varchar(255) NOT NULL,
  `runpic` varchar(255) NOT NULL,
  `advnamecolor` varchar(255) NOT NULL,
  `h5` varchar(255) NOT NULL,
  `tippic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_uniacid` (`uniacid`) USING BTREE,
  KEY `idx_enabled` (`enabled`) USING BTREE,
  KEY `idx_displayorder` (`displayorder`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_icon
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_invitelog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_invitelog`;
CREATE TABLE `ims_hcstep_invitelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `sonid` int(11) DEFAULT NULL,
  `step` varchar(255) DEFAULT NULL,
  `invite_time` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 未兑换燃力币 1 已兑换',
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`uniacid`,`user_id`,`time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_invitelog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_kefu`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_kefu`;
CREATE TABLE `ims_hcstep_kefu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `kefu_keyword` varchar(255) DEFAULT NULL,
  `kefu_title` varchar(255) DEFAULT NULL,
  `kefu_img` varchar(255) DEFAULT NULL,
  `kefu_gaishu` varchar(255) DEFAULT NULL,
  `kefu_url` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_kefu
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_kouhonglog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_kouhonglog`;
CREATE TABLE `ims_hcstep_kouhonglog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `createtime` varchar(20) DEFAULT NULL,
  `createday` varchar(20) DEFAULT NULL,
  `goods_id` varchar(20) DEFAULT NULL,
  `invite_id` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0挑战失败1挑战成功',
  `cishu` int(20) DEFAULT '0' COMMENT '0挑战零次没挑战直接邀请好友1直接开始挑战2满足条件后挑战第二次',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uniacid` (`uniacid`,`user_id`,`createday`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_kouhonglog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_message`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_message`;
CREATE TABLE `ims_hcstep_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `msgid` varchar(255) DEFAULT NULL,
  `keyword1` varchar(255) DEFAULT NULL,
  `keyword2` varchar(255) DEFAULT NULL,
  `keyword3` varchar(255) DEFAULT NULL,
  `hongbao_msgid` varchar(255) NOT NULL,
  `fahuomsgid` varchar(255) NOT NULL,
  `notice` varchar(255) NOT NULL,
  `rolltime` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `centerhead` varchar(55) NOT NULL,
  `invite_icon` varchar(55) NOT NULL,
  `rule_icon` varchar(55) NOT NULL,
  `qs_icon` varchar(55) NOT NULL,
  `news_icon` varchar(55) NOT NULL,
  `contact_icon` varchar(55) NOT NULL,
  `ka_icon` varchar(55) NOT NULL,
  `set_icon` varchar(55) NOT NULL,
  `dhcolor` varchar(55) NOT NULL,
  `name_color` varchar(55) NOT NULL,
  `id_color` varchar(55) NOT NULL,
  `dhjl_color` varchar(55) NOT NULL,
  `idbg_color` varchar(55) NOT NULL,
  `is_fourhb` int(11) NOT NULL,
  `fourhb_sharetitle` varchar(100) NOT NULL,
  `fourhb_sharepic` varchar(100) NOT NULL,
  `min_bighbmoney` decimal(10,2) NOT NULL,
  `max_bighbmoney` decimal(10,2) NOT NULL,
  `min_smallhbmoney` decimal(10,2) NOT NULL,
  `max_smallhbmoney` decimal(10,2) NOT NULL,
  `min_hbtxmoney` decimal(10,2) NOT NULL,
  `txinfo` varchar(255) NOT NULL,
  `hbtext1` varchar(100) NOT NULL,
  `hbtext2` varchar(100) NOT NULL,
  `txcolor` varchar(50) NOT NULL,
  `txjl_color` varchar(50) NOT NULL,
  `fourhb_mainpic` varchar(60) NOT NULL,
  `daijiesuo` varchar(60) NOT NULL,
  `daikaiqi` varchar(60) NOT NULL,
  `yikaiqi` varchar(60) NOT NULL,
  `hb_icon` varchar(60) NOT NULL,
  `openhbpic` varchar(60) NOT NULL,
  `lotto_type` int(11) NOT NULL DEFAULT '1',
  `fourhb_coin` varchar(10) NOT NULL,
  `is_float` int(11) NOT NULL COMMENT '0不显示1电话2微信',
  `phoneno` varchar(20) NOT NULL,
  `call_icon` varchar(60) NOT NULL,
  `copytext` varchar(100) NOT NULL,
  `copy_icon` varchar(60) NOT NULL,
  `is_tan` int(11) NOT NULL,
  `tan_type` int(11) NOT NULL,
  `tan_goodsid` varchar(20) NOT NULL,
  `tan_pic` varchar(100) NOT NULL,
  `left1` varchar(100) NOT NULL,
  `left1_jump` int(11) NOT NULL,
  `left1_appid` varchar(50) NOT NULL,
  `left1_path` varchar(50) NOT NULL,
  `left2` varchar(100) NOT NULL,
  `left2_jump` int(11) NOT NULL,
  `left2_appid` varchar(50) NOT NULL,
  `left2_path` varchar(50) NOT NULL,
  `right1` varchar(100) NOT NULL,
  `right1_jump` int(11) NOT NULL,
  `right1_appid` varchar(50) NOT NULL,
  `right1_path` varchar(50) NOT NULL,
  `right2` varchar(100) NOT NULL,
  `right2_jump` int(11) NOT NULL,
  `right2_appid` varchar(50) NOT NULL,
  `right2_path` varchar(50) NOT NULL,
  `right3` varchar(100) NOT NULL,
  `right3_jump` int(11) NOT NULL,
  `right3_appid` varchar(50) NOT NULL,
  `right3_path` varchar(50) NOT NULL,
  `is_five` int(11) NOT NULL,
  `icon_position` int(11) NOT NULL,
  `fabu_icon` varchar(60) NOT NULL,
  `kouhong_sharetitle` varchar(100) NOT NULL,
  `kouhong_sharepic` varchar(100) NOT NULL,
  `kouhong_ids` varchar(100) NOT NULL,
  `order_icon` varchar(60) NOT NULL,
  `tx_type` int(11) NOT NULL DEFAULT '1' COMMENT '1企业付款2收款码',
  `client_id` varchar(50) NOT NULL,
  `client_secret` varchar(50) NOT NULL,
  `p_id` varchar(50) NOT NULL,
  `couponprice` varchar(10) NOT NULL,
  `left1_h5` varchar(255) NOT NULL,
  `left2_h5` varchar(255) NOT NULL,
  `right1_h5` varchar(255) NOT NULL,
  `right2_h5` varchar(255) NOT NULL,
  `right3_h5` varchar(255) NOT NULL,
  `is_shipinball` int(11) NOT NULL,
  `shipinad` varchar(100) NOT NULL,
  `shipinstep` varchar(10) NOT NULL,
  `is_indexad` int(11) NOT NULL,
  `indexadid` varchar(100) NOT NULL,
  `is_centerad` int(11) NOT NULL,
  `centeradid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_message
-- ----------------------------
INSERT INTO `ims_hcstep_message` VALUES ('4', '142', null, null, null, null, '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '1', '', '0', '', '', '', '', '0', '0', '', '', '', '0', '', '', '', '0', '', '', '', '0', '', '', '', '0', '', '', '', '0', '', '', '0', '0', '', '1', '', '1', '', '1', '', '', '', '', '', '', '', '', '', '0', '', '', '0', '', '0', '');

-- ----------------------------
-- Table structure for `ims_hcstep_mission`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_mission`;
CREATE TABLE `ims_hcstep_mission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title2` varchar(255) DEFAULT NULL,
  `mission_type` int(11) DEFAULT NULL COMMENT '0邀请好友1跳转小程序2步友圈首次发帖3绑定手机',
  `mission_icon` varchar(255) DEFAULT NULL,
  `step` varchar(20) DEFAULT NULL,
  `appid` varchar(100) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `displayorder` int(11) NOT NULL,
  `ad` varchar(50) NOT NULL COMMENT '视频广告id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_mission
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_missionlog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_missionlog`;
CREATE TABLE `ims_hcstep_missionlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mission_id` int(11) DEFAULT NULL,
  `step` varchar(20) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `daytime` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0完成任务未领取步数1领取步数',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uniacid` (`uniacid`,`user_id`,`mission_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_missionlog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_news`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_news`;
CREATE TABLE `ims_hcstep_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `makenews_uid` int(11) DEFAULT NULL,
  `dt_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1点赞2关注3评论',
  `time` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0未读1已读',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_news
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_orders`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_orders`;
CREATE TABLE `ims_hcstep_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `postalCode` varchar(255) DEFAULT NULL,
  `provinceName` varchar(255) DEFAULT NULL,
  `cityName` varchar(255) DEFAULT NULL,
  `countyName` varchar(255) DEFAULT NULL,
  `detailInfo` varchar(255) DEFAULT NULL,
  `nationalCode` varchar(255) DEFAULT NULL,
  `telNumber` varchar(255) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `time` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0已支付待发货1已发货2未支付',
  `type` int(11) NOT NULL COMMENT '0原价1币加钱2纯币3纯邀请好友10原价核销11币加钱核销12纯币核销',
  `oid` int(11) NOT NULL COMMENT '支付表id',
  `hexiaostatus` int(11) DEFAULT '0' COMMENT '0未核销1已核销',
  `hexiaotime` varchar(255) NOT NULL,
  `express` varchar(255) NOT NULL,
  `fahuotime` varchar(255) NOT NULL,
  `expressname` varchar(255) NOT NULL COMMENT '快递公司名',
  `hexiaoyuan` int(11) NOT NULL COMMENT '核销员id',
  `endtime` varchar(60) NOT NULL COMMENT '核销码到期时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=229 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_orders
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_payment`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_payment`;
CREATE TABLE `ims_hcstep_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `ordersn` varchar(30) DEFAULT '',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品id',
  `paytype` int(11) NOT NULL COMMENT '0原价1步数加钱',
  `fee` decimal(11,2) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `paystatus` tinyint(1) NOT NULL DEFAULT '0',
  `paytime` char(10) NOT NULL,
  `transid` varchar(50) DEFAULT '',
  `createtime` int(10) DEFAULT '0',
  `package` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_payment
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_peoplelog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_peoplelog`;
CREATE TABLE `ims_hcstep_peoplelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `goods_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `son_id` int(11) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_peoplelog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_question`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_question`;
CREATE TABLE `ims_hcstep_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `displayorder` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `enabled` tinyint(3) NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of ims_hcstep_question
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_set`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_set`;
CREATE TABLE `ims_hcstep_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `sharetitle` varchar(255) DEFAULT NULL,
  `sharepic` varchar(255) DEFAULT NULL,
  `coinname` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `sharestep` varchar(255) DEFAULT NULL,
  `boxprice` varchar(255) DEFAULT NULL,
  `rulepic` varchar(255) DEFAULT NULL,
  `headcolor` varchar(255) NOT NULL,
  `xcx` varchar(255) NOT NULL,
  `up` varchar(255) NOT NULL,
  `notice` varchar(500) NOT NULL,
  `shenhe` int(11) NOT NULL,
  `loginpic` varchar(255) NOT NULL,
  `indexbg` varchar(255) NOT NULL,
  `indexbutton` varchar(255) NOT NULL,
  `inviteball` varchar(255) NOT NULL,
  `upball` varchar(255) NOT NULL,
  `zerotip` varchar(255) NOT NULL,
  `poortip` varchar(255) NOT NULL,
  `questionpic` varchar(255) NOT NULL,
  `is_follow` int(11) NOT NULL,
  `followpic` varchar(255) NOT NULL,
  `kefu_title` varchar(255) NOT NULL,
  `kefu_img` varchar(255) NOT NULL,
  `kefu_gaishu` varchar(255) NOT NULL,
  `kefu_url` varchar(255) NOT NULL,
  `kefupic` varchar(255) NOT NULL,
  `guanzhu_step` varchar(255) NOT NULL,
  `followlogo` varchar(255) NOT NULL,
  `maxstep` varchar(255) NOT NULL,
  `sharetext` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `shareinfo` varchar(255) NOT NULL,
  `upinfo` varchar(255) NOT NULL,
  `adunit` varchar(255) NOT NULL,
  `adunit2` varchar(255) NOT NULL,
  `adunit3` varchar(255) NOT NULL,
  `adunit4` varchar(50) NOT NULL,
  `adunit5` varchar(50) NOT NULL,
  `boxpic` varchar(255) NOT NULL,
  `activitypic` varchar(255) NOT NULL,
  `applypic` varchar(255) NOT NULL,
  `rule` varchar(2555) NOT NULL,
  `sweattext` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `comeon` varchar(255) NOT NULL,
  `posterpic` varchar(255) NOT NULL,
  `smalltip` varchar(255) NOT NULL,
  `signsharetext` varchar(255) NOT NULL,
  `signpic` varchar(255) NOT NULL,
  `signsharemoney` varchar(255) NOT NULL,
  `frame` varchar(255) NOT NULL,
  `signicon` varchar(255) NOT NULL,
  `signtext` varchar(255) NOT NULL,
  `smalltipcolor` varchar(255) NOT NULL,
  `sharetextcolor` varchar(255) NOT NULL,
  `shareinfocolor` varchar(255) NOT NULL,
  `signtextcolor` varchar(255) NOT NULL,
  `buttonbg` varchar(255) NOT NULL,
  `balltextcolor` varchar(255) NOT NULL,
  `centercolor` varchar(255) NOT NULL,
  `coinpic` varchar(100) NOT NULL,
  `cointextcolor` varchar(100) NOT NULL,
  `invitetype` int(11) NOT NULL DEFAULT '1',
  `hongbaobg` varchar(100) NOT NULL,
  `longbg` varchar(100) NOT NULL,
  `hongbaotext` varchar(100) NOT NULL,
  `sweatcolor` varchar(20) NOT NULL,
  `updatetip` varchar(100) NOT NULL,
  `updatepic` varchar(55) NOT NULL,
  `updatetipcolor` varchar(10) NOT NULL,
  `goodstop` varchar(55) NOT NULL,
  `adunit6` varchar(50) NOT NULL,
  `posterpic2` varchar(60) NOT NULL,
  `posterpic3` varchar(60) NOT NULL,
  `is_qian` int(11) NOT NULL DEFAULT '1',
  `is_kuang` int(11) NOT NULL DEFAULT '1',
  `fanscolor` varchar(20) NOT NULL,
  `fansicon` varchar(100) NOT NULL,
  `upicon` varchar(100) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`uniacid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_set
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_shipinlog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_shipinlog`;
CREATE TABLE `ims_hcstep_shipinlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `step` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `daytime` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uniacid` (`uniacid`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `daytime` (`daytime`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_shipinlog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_shipinlog2`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_shipinlog2`;
CREATE TABLE `ims_hcstep_shipinlog2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `step` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `daytime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uniacid` (`uniacid`) USING BTREE,
  KEY `daytime` (`daytime`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_shipinlog2
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_shop`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_shop`;
CREATE TABLE `ims_hcstep_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `logo` varchar(255) DEFAULT NULL,
  `topbg` varchar(255) NOT NULL,
  `shopname` varchar(255) NOT NULL,
  `sheng` varchar(255) DEFAULT NULL,
  `shi` varchar(255) DEFAULT NULL,
  `qu` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `starttime` varchar(255) DEFAULT NULL,
  `endtime` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` varchar(500) NOT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `lat` varchar(20) NOT NULL,
  `lng` varchar(20) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_shop
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_sort`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_sort`;
CREATE TABLE `ims_hcstep_sort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `type` int(11) DEFAULT NULL,
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `is_distance` int(11) NOT NULL DEFAULT '0' COMMENT '是否按距离排序',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_uniacid` (`uniacid`) USING BTREE,
  KEY `idx_enabled` (`enabled`) USING BTREE,
  KEY `idx_displayorder` (`displayorder`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_sort
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_topic`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_topic`;
CREATE TABLE `ims_hcstep_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `displayorder` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0不显示1显示',
  `toppic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_topic
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_uplog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_uplog`;
CREATE TABLE `ims_hcstep_uplog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `step` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `day` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`uniacid`,`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_uplog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_users`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_users`;
CREATE TABLE `ims_hcstep_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `head_pic` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `money` decimal(11,4) NOT NULL DEFAULT '0.0000' COMMENT '可提现金额',
  `fatherid` int(11) DEFAULT NULL,
  `black` int(11) NOT NULL DEFAULT '0' COMMENT '0正常1拉黑',
  `is_yy` int(11) NOT NULL DEFAULT '0',
  `signtime` varchar(255) NOT NULL DEFAULT '1' COMMENT '连续签到次数',
  `lasttime` varchar(255) NOT NULL COMMENT '最后签到时间',
  `sharetime` varchar(255) NOT NULL,
  `hongbaofid` int(11) NOT NULL DEFAULT '0',
  `rmb` decimal(10,2) DEFAULT '0.00',
  `tantime` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `paycode` varchar(255) DEFAULT NULL COMMENT '收款码',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `KEY` (`uniacid`,`open_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1374 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_users
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_winlog`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_winlog`;
CREATE TABLE `ims_hcstep_winlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `userName` varchar(255) NOT NULL,
  `postalCode` varchar(255) NOT NULL,
  `provinceName` varchar(255) NOT NULL,
  `cityName` varchar(255) NOT NULL,
  `countyName` varchar(255) NOT NULL,
  `detailInfo` varchar(255) NOT NULL,
  `nationalCode` varchar(255) NOT NULL,
  `telNumber` varchar(255) NOT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `time` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0待发货1已发货',
  `express` varchar(255) NOT NULL,
  `fahuotime` varchar(255) NOT NULL,
  `expressname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`uniacid`,`user_id`,`goods_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_winlog
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_xuni`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_xuni`;
CREATE TABLE `ims_hcstep_xuni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `nick_name` varchar(255) DEFAULT NULL,
  `head_pic` varchar(255) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_hcstep_xuni
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcstep_zan`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcstep_zan`;
CREATE TABLE `ims_hcstep_zan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dt_id` int(11) DEFAULT NULL,
  `target_id` int(11) NOT NULL COMMENT '被点赞人id',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uniacid` (`uniacid`,`user_id`,`dt_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of ims_hcstep_zan
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcsup_banner`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcsup_banner`;
CREATE TABLE `ims_hcsup_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `banner` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1关闭',
  `displayorder` int(11) NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcsup_banner
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcsup_cash`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcsup_cash`;
CREATE TABLE `ims_hcsup_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `transid` varchar(20) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcsup_cash
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcsup_category`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcsup_category`;
CREATE TABLE `ims_hcsup_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `oldid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `weid` int(11) NOT NULL,
  `hcid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcsup_category
-- ----------------------------
INSERT INTO `ims_hcsup_category` VALUES ('1', '0', '抖音', '', '0', '0', '0', '29', '1');
INSERT INTO `ims_hcsup_category` VALUES ('2', '1', '抖音尊享', '', '2043', '0', '0', '29', '46');
INSERT INTO `ims_hcsup_category` VALUES ('3', '1', '抖音粉丝', '/uploads/20180906/32c98198cfff5b0f550786399d042402.png', '2043', '0', '0', '29', '11');
INSERT INTO `ims_hcsup_category` VALUES ('4', '1', '抖音播放', '', '2044', '0', '0', '29', '12');
INSERT INTO `ims_hcsup_category` VALUES ('5', '1', '抖音评论', '', '2041', '0', '0', '29', '13');
INSERT INTO `ims_hcsup_category` VALUES ('6', '1', '抖音双击', '', '2045', '0', '0', '29', '14');
INSERT INTO `ims_hcsup_category` VALUES ('7', '1', '抖音分享', '/uploads/20180906/9870de73c726c65d308fc78c4b4e4836.jpg', '2196', '0', '0', '29', '15');
INSERT INTO `ims_hcsup_category` VALUES ('8', '0', '爱奇艺', '/uploads/20180906/9870de73c726c65d308fc78c4b4e4836.jpg', '5', '0', '0', '29', '5');
INSERT INTO `ims_hcsup_category` VALUES ('9', '5', '爱奇艺会员激活码', '', '1609', '0', '0', '29', '30');
INSERT INTO `ims_hcsup_category` VALUES ('10', '0', '腾讯视频', '', '1', '0', '0', '29', '6');
INSERT INTO `ims_hcsup_category` VALUES ('11', '6', '好莱坞会员激活码', '', '1702', '0', '0', '29', '31');
INSERT INTO `ims_hcsup_category` VALUES ('12', '0', '快手', '', '0', '0', '0', '29', '2');
INSERT INTO `ims_hcsup_category` VALUES ('13', '2', '快手播放', '/uploads/20180907/4fffa0e510d1617f18ef9517ac0acd25.png', '1151', '0', '0', '29', '16');
INSERT INTO `ims_hcsup_category` VALUES ('14', '2', '快手双击', '', '1167', '0', '0', '29', '35');
INSERT INTO `ims_hcsup_category` VALUES ('15', '2', '快手评论', '', '1373', '0', '0', '29', '36');
INSERT INTO `ims_hcsup_category` VALUES ('16', '2', '快手粉丝', '', '1169', '0', '1', '29', '45');
INSERT INTO `ims_hcsup_category` VALUES ('17', '0', '火山', '', '0', '0', '1', '29', '3');
INSERT INTO `ims_hcsup_category` VALUES ('18', '3', '火山粉丝', '', '2442', '0', '1', '29', '44');
INSERT INTO `ims_hcsup_category` VALUES ('19', '0', '全民K歌', '', '0', '0', '0', '29', '4');
INSERT INTO `ims_hcsup_category` VALUES ('20', '4', '全民K歌鲜花 ', '', '1343', '0', '0', '29', '37');
INSERT INTO `ims_hcsup_category` VALUES ('21', '4', '全民K歌播放', '', '1385', '0', '0', '29', '38');
INSERT INTO `ims_hcsup_category` VALUES ('22', '4', '全民K歌粉丝', '', '1344', '0', '0', '29', '39');
INSERT INTO `ims_hcsup_category` VALUES ('23', '4', '全民K歌评论', '', '1481', '0', '0', '29', '40');
INSERT INTO `ims_hcsup_category` VALUES ('24', '0', '乐视会员', '', '0', '0', '0', '29', '19');
INSERT INTO `ims_hcsup_category` VALUES ('25', '19', '乐视会员激活码', '', '1643', '0', '0', '29', '34');
INSERT INTO `ims_hcsup_category` VALUES ('26', '0', '优酷会员', '', '1', '0', '0', '29', '7');
INSERT INTO `ims_hcsup_category` VALUES ('27', '7', '优酷会员激活码', '', '1616', '0', '0', '29', '32');
INSERT INTO `ims_hcsup_category` VALUES ('28', '0', '芒果TV', '', '0', '0', '0', '29', '8');
INSERT INTO `ims_hcsup_category` VALUES ('29', '8', '芒果TV会员激活码', '', '1644', '0', '0', '29', '33');
INSERT INTO `ims_hcsup_category` VALUES ('30', '0', '新浪微博', '', '0', '0', '1', '29', '9');
INSERT INTO `ims_hcsup_category` VALUES ('31', '9', '新浪微博粉丝', '', '1355', '0', '1', '29', '41');
INSERT INTO `ims_hcsup_category` VALUES ('32', '9', '新浪微博点赞', '', '1672', '0', '1', '29', '42');
INSERT INTO `ims_hcsup_category` VALUES ('33', '9', '新浪微博播放', '', '1675', '0', '1', '29', '43');
INSERT INTO `ims_hcsup_category` VALUES ('34', '0', '福利', '', '0', '0', '0', '29', '18');
INSERT INTO `ims_hcsup_category` VALUES ('35', '0', '激活码', '', '0', '0', '0', '29', '10');
INSERT INTO `ims_hcsup_category` VALUES ('36', '10', 'QQ音乐包激活码', '', '2315', '0', '0', '29', '20');
INSERT INTO `ims_hcsup_category` VALUES ('37', '10', 'QQ绿钻激活码', '', '2027', '0', '0', '29', '21');
INSERT INTO `ims_hcsup_category` VALUES ('38', '10', 'QQ体育会员激活码', '', '1823', '0', '0', '29', '22');
INSERT INTO `ims_hcsup_category` VALUES ('39', '10', '滴滴优惠券', '', '2276', '0', '1', '29', '23');
INSERT INTO `ims_hcsup_category` VALUES ('40', '10', '喜马拉雅激活码', '', '2448', '0', '1', '29', '24');
INSERT INTO `ims_hcsup_category` VALUES ('41', '10', '饿了么红包码', '', '2599', '0', '0', '29', '25');
INSERT INTO `ims_hcsup_category` VALUES ('42', '10', '全国移动流量', '', '2600', '0', '0', '29', '26');
INSERT INTO `ims_hcsup_category` VALUES ('43', '10', '红牛红包码', '', '2601', '0', '1', '29', '27');
INSERT INTO `ims_hcsup_category` VALUES ('44', '10', '美团外卖红包码', '', '2572', '0', '0', '29', '17');
INSERT INTO `ims_hcsup_category` VALUES ('45', '10', '百度网盘会员激活码', '', '2615', '0', '1', '29', '28');
INSERT INTO `ims_hcsup_category` VALUES ('46', '10', 'QQ欢乐豆激活码 ', '', '163', '0', '1', '29', '29');
INSERT INTO `ims_hcsup_category` VALUES ('47', '0', '小程序流量主', '', '0', '0', '1', '29', '47');
INSERT INTO `ims_hcsup_category` VALUES ('48', '0', '小红书业务', '', '0', '0', '0', '29', '48');
INSERT INTO `ims_hcsup_category` VALUES ('49', '48', '小红书粉丝', '', '1963', '0', '0', '29', '49');
INSERT INTO `ims_hcsup_category` VALUES ('50', '48', '小红书评论', '', '2780', '0', '0', '29', '51');
INSERT INTO `ims_hcsup_category` VALUES ('51', '48', '小红书收藏', '', '1999', '0', '0', '29', '50');
INSERT INTO `ims_hcsup_category` VALUES ('52', '2', '快手直播人气', '', '2161', '0', '0', '29', '52');
INSERT INTO `ims_hcsup_category` VALUES ('53', '0', '抖音', '', '0', '0', '0', '250', '1');
INSERT INTO `ims_hcsup_category` VALUES ('54', '1', '抖音尊享', '', '2043', '0', '0', '250', '46');
INSERT INTO `ims_hcsup_category` VALUES ('55', '1', '抖音粉丝', '/uploads/20180906/32c98198cfff5b0f550786399d042402.png', '2043', '0', '0', '250', '11');
INSERT INTO `ims_hcsup_category` VALUES ('56', '1', '抖音播放', '', '2044', '0', '0', '250', '12');
INSERT INTO `ims_hcsup_category` VALUES ('57', '1', '抖音评论', '', '2041', '0', '0', '250', '13');
INSERT INTO `ims_hcsup_category` VALUES ('58', '1', '抖音双击', '', '2045', '0', '0', '250', '14');
INSERT INTO `ims_hcsup_category` VALUES ('59', '1', '抖音分享', '/uploads/20180906/9870de73c726c65d308fc78c4b4e4836.jpg', '2196', '0', '0', '250', '15');
INSERT INTO `ims_hcsup_category` VALUES ('60', '0', '爱奇艺', '/uploads/20180906/9870de73c726c65d308fc78c4b4e4836.jpg', '5', '0', '0', '250', '5');
INSERT INTO `ims_hcsup_category` VALUES ('61', '5', '爱奇艺会员激活码', '', '1609', '0', '0', '250', '30');
INSERT INTO `ims_hcsup_category` VALUES ('62', '0', '腾讯视频', '', '1', '0', '0', '250', '6');
INSERT INTO `ims_hcsup_category` VALUES ('63', '6', '好莱坞会员激活码', '', '1702', '0', '0', '250', '31');
INSERT INTO `ims_hcsup_category` VALUES ('64', '0', '小程序流量主', '', '0', '0', '1', '250', '47');
INSERT INTO `ims_hcsup_category` VALUES ('65', '0', '小红书业务', '', '0', '0', '0', '250', '48');
INSERT INTO `ims_hcsup_category` VALUES ('66', '48', '小红书粉丝', '', '1963', '0', '0', '250', '49');
INSERT INTO `ims_hcsup_category` VALUES ('67', '48', '小红书评论', '', '2780', '0', '0', '250', '51');
INSERT INTO `ims_hcsup_category` VALUES ('68', '48', '小红书收藏', '', '1999', '0', '0', '250', '50');
INSERT INTO `ims_hcsup_category` VALUES ('69', '0', '快手', '', '0', '0', '0', '250', '2');
INSERT INTO `ims_hcsup_category` VALUES ('70', '2', '快手播放', '/uploads/20180907/4fffa0e510d1617f18ef9517ac0acd25.png', '1151', '0', '0', '250', '16');
INSERT INTO `ims_hcsup_category` VALUES ('71', '2', '快手直播人气', '', '2161', '0', '0', '250', '52');
INSERT INTO `ims_hcsup_category` VALUES ('72', '2', '快手双击', '', '1167', '0', '0', '250', '35');
INSERT INTO `ims_hcsup_category` VALUES ('73', '2', '快手评论', '', '1373', '0', '0', '250', '36');
INSERT INTO `ims_hcsup_category` VALUES ('74', '2', '快手粉丝', '', '1169', '0', '1', '250', '45');
INSERT INTO `ims_hcsup_category` VALUES ('75', '0', '火山', '', '0', '0', '1', '250', '3');
INSERT INTO `ims_hcsup_category` VALUES ('76', '3', '火山粉丝', '', '2442', '0', '1', '250', '44');
INSERT INTO `ims_hcsup_category` VALUES ('77', '0', '全民K歌', '', '0', '0', '0', '250', '4');
INSERT INTO `ims_hcsup_category` VALUES ('78', '4', '全民K歌鲜花 ', '', '1343', '0', '0', '250', '37');
INSERT INTO `ims_hcsup_category` VALUES ('79', '4', '全民K歌播放', '', '1385', '0', '0', '250', '38');
INSERT INTO `ims_hcsup_category` VALUES ('80', '4', '全民K歌粉丝', '', '1344', '0', '0', '250', '39');
INSERT INTO `ims_hcsup_category` VALUES ('81', '4', '全民K歌评论', '', '1481', '0', '0', '250', '40');
INSERT INTO `ims_hcsup_category` VALUES ('82', '0', '乐视会员', '', '0', '0', '0', '250', '19');
INSERT INTO `ims_hcsup_category` VALUES ('83', '19', '乐视会员激活码', '', '1643', '0', '0', '250', '34');
INSERT INTO `ims_hcsup_category` VALUES ('84', '0', '优酷会员', '', '1', '0', '0', '250', '7');
INSERT INTO `ims_hcsup_category` VALUES ('85', '7', '优酷会员激活码', '', '1616', '0', '0', '250', '32');
INSERT INTO `ims_hcsup_category` VALUES ('86', '0', '芒果TV', '', '0', '0', '0', '250', '8');
INSERT INTO `ims_hcsup_category` VALUES ('87', '8', '芒果TV会员激活码', '', '1644', '0', '0', '250', '33');
INSERT INTO `ims_hcsup_category` VALUES ('88', '0', '新浪微博', '', '0', '0', '1', '250', '9');
INSERT INTO `ims_hcsup_category` VALUES ('89', '9', '新浪微博粉丝', '', '1355', '0', '1', '250', '41');
INSERT INTO `ims_hcsup_category` VALUES ('90', '9', '新浪微博点赞', '', '1672', '0', '1', '250', '42');
INSERT INTO `ims_hcsup_category` VALUES ('91', '9', '新浪微博播放', '', '1675', '0', '1', '250', '43');
INSERT INTO `ims_hcsup_category` VALUES ('92', '0', '福利', '', '0', '0', '1', '250', '18');
INSERT INTO `ims_hcsup_category` VALUES ('93', '0', '激活码', '', '0', '0', '0', '250', '10');
INSERT INTO `ims_hcsup_category` VALUES ('94', '10', 'QQ音乐包激活码', '', '2315', '0', '0', '250', '20');
INSERT INTO `ims_hcsup_category` VALUES ('95', '10', 'QQ绿钻激活码', '', '2027', '0', '0', '250', '21');
INSERT INTO `ims_hcsup_category` VALUES ('96', '10', 'QQ体育会员激活码', '', '1823', '0', '0', '250', '22');
INSERT INTO `ims_hcsup_category` VALUES ('97', '10', '滴滴优惠券', '', '2276', '0', '1', '250', '23');
INSERT INTO `ims_hcsup_category` VALUES ('98', '10', '喜马拉雅激活码', '', '2448', '0', '1', '250', '24');
INSERT INTO `ims_hcsup_category` VALUES ('99', '10', '饿了么红包码', '', '2599', '0', '0', '250', '25');
INSERT INTO `ims_hcsup_category` VALUES ('100', '10', '全国移动流量', '', '2600', '0', '0', '250', '26');
INSERT INTO `ims_hcsup_category` VALUES ('101', '10', '红牛红包码', '', '2601', '0', '1', '250', '27');
INSERT INTO `ims_hcsup_category` VALUES ('102', '10', '美团外卖红包码', '', '2572', '0', '0', '250', '17');
INSERT INTO `ims_hcsup_category` VALUES ('103', '10', '百度网盘会员激活码', '', '2615', '0', '1', '250', '28');
INSERT INTO `ims_hcsup_category` VALUES ('104', '10', 'QQ欢乐豆激活码 ', '', '163', '0', '1', '250', '29');

-- ----------------------------
-- Table structure for `ims_hcsup_commission`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcsup_commission`;
CREATE TABLE `ims_hcsup_commission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `trade_no` varchar(30) NOT NULL,
  `goodsname` varchar(500) NOT NULL,
  `goodsthumb` varchar(500) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rate` int(11) NOT NULL,
  `profit` decimal(10,2) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `sort` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `freeze` tinyint(1) NOT NULL DEFAULT '0',
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcsup_commission
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcsup_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcsup_goods`;
CREATE TABLE `ims_hcsup_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `hcid` int(11) NOT NULL,
  `original_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `categoryname` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `picture` varchar(500) NOT NULL,
  `cateid` tinyint(1) NOT NULL,
  `unit_price` decimal(10,3) NOT NULL,
  `cost_price` decimal(10,3) NOT NULL,
  `describe` varchar(500) NOT NULL,
  `custom` varchar(500) NOT NULL,
  `max_buy` int(11) NOT NULL,
  `params` varchar(500) NOT NULL,
  `sales` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) DEFAULT '0',
  `sort` int(11) NOT NULL,
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `price_type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcsup_goods
-- ----------------------------
INSERT INTO `ims_hcsup_goods` VALUES ('1', '29', '145', '27021', '46', '抖音尊享', '抖音直播权限自动开', '/uploads/20181012/031f5550c8a9b2ad80631e02b52226aa.jpg,/uploads/20190120/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '242.000', '66.000', '', '', '1', '抖音视频ID:video', '196', '1', '1', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('2', '29', '144', '27019', '46', '抖音尊享', '抖音长视频拍摄权限-抖音60秒长视频权限-自动开', '/uploads/20181012/d69f7025338ac789ca87e1832d69f6e1.jpg,/uploads/20190120/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '24.200', '6.600', '系统通知已开通，可在拍摄页面的【更多】里开启', '', '1', '抖音视频ID:video', '344', '1', '1', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('3', '29', '143', '30696', '45', '快手粉丝', '快手粉丝-快手关注-10000粉丝-（掉粉不补）', '/uploads/20180925/d5edf1db2349d03642f6fde431baa01c.jpg,/uploads/20190220/9708fd6e42b8e6ce0875557f90f9f807.jpg', '0', '215.600', '275.000', '', '', '1', '', '126', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('4', '29', '142', '31171', '45', '快手粉丝', '快手粉丝-快手关注-1000粉丝-（掉粉不补）', '/uploads/20180925/ef196676aaf89f75f98f19582b73e86b.jpg,/uploads/20190220/9708fd6e42b8e6ce0875557f90f9f807.jpg', '0', '21.450', '60.170', '', '', '1', '', '315', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('5', '29', '141', '31330', '45', '快手粉丝', '快手真人粉丝-全真人操作-非软件-提高作品热门-100粉丝-自动充', '/uploads/20180925/b282b02aa9fcc4fef3a4d756cd0162e2.jpg,/uploads/20190220/9708fd6e42b8e6ce0875557f90f9f807.jpg', '0', '2.150', '35.200', '', '', '1', '', '297', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('6', '29', '140', '27019', '11', '抖音粉丝', '（极速秒充）抖音粉丝关注-1000粉丝', '/uploads/20190318/d69f7025338ac789ca87e1832d69f6e1.jpg,/uploads/20180929/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '96.800', '57.200', '', '', '1', '抖音视频ID:video', '895', '1', '2', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('7', '29', '139', '27018', '11', '抖音粉丝', '（极速秒充）抖音粉丝关注-500粉丝', '/uploads/20190318/1cbb652acca765b70085a3c387616e0f.jpg,/uploads/20180922/4e416cec37b39344ee662799f2b5f0e7.jpg', '0', '12.100', '28.600', '', '', '1', '抖音视频ID:video', '962', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('8', '29', '138', '27017', '11', '抖音粉丝', '（极速秒充）抖音粉丝关注-100粉丝', '/uploads/20180922/135438398ffeb3d4dc21b6f08ac49645.gif,/uploads/20180922/4e416cec37b39344ee662799f2b5f0e7.jpg', '0', '1.210', '5.720', '', '', '1', '抖音视频ID:video', '1251', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('9', '29', '137', '21531', '33', '芒果TV会员激活码', '官方卡芒果TV会员30天激活码-无限叠加', '/uploads/20180918/127f16c11dfc34faf177548cb3deb355.jpg', '1', '8.250', '7.480', '', '', '1', '', '455', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('10', '29', '136', '27716', '33', '芒果TV会员激活码', '官方卡-芒果TV会员7天激活码', '/uploads/20180917/ba48890ac67a41d6226f90425e4e4da8.jpg', '1', '2.200', '2.200', '【适用平台】: 本产品支持电脑 平板 手机 【观影券】: 会员每个月赠送2张观影券(即买即送) 【充值账号】: 此商品为会员激活卡密，使用前请注册并登陆芒果TV账号 注意！注意！注意！本产品需自行去对应供应商官方网站充值，建议尽快充值。充值前请确定充值账号是否正确，一旦充值成功，是无法更改和退款哦！', '', '1', '', '561', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('11', '29', '135', '27715', '33', '芒果TV会员激活码', '官方卡-芒果TV会员3天激活码充值账号VIP3天激活码--保质期2天-无错卡', '/uploads/20180914/135438398ffeb3d4dc21b6f08ac49645.gif', '1', '0.830', '0.830', '', '', '1', '', '346', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('12', '29', '134', '28966', '32', '优酷会员激活码', '优酷黄金会员12个月激活码', '/uploads/20180917/a0e3f3facc7b78e54e3a81df910024bd.jpg', '1', '121.000', '121.000', '', '', '1', '', '238', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('13', '29', '133', '28965', '32', '优酷会员激活码', '优酷黄金会员3个月激活码', '/uploads/20180917/690cb01de9d67cdd8f638eaf914e5fdf.jpg', '1', '34.650', '34.650', '', '', '1', '', '467', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('14', '29', '132', '29176', '32', '优酷会员激活码', '优酷黄金会员1个月激活码', '/uploads/20180917/1eeaa77f3c45c5a5a4ea4bb39573ef44.jpg', '1', '12.100', '11.220', '', '', '1', '', '152', '1', '2', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('15', '29', '131', '29677', '32', '优酷会员激活码', '优酷黄金会员7天激活码', '/uploads/20180917/2e23e088de611c988a1cb0eb5309d107.jpg', '1', '5.500', '5.470', '', '', '1', '', '246', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('16', '29', '130', '24070', '34', '乐视会员激活码', '官方乐视影视会员30天激活码', '/uploads/20180917/1a2d1559ae22f9b5877417b8e7d55d72.jpg', '1', '5.720', '3.800', '', '', '1', '', '154', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('17', '29', '129', '29326', '31', '好莱坞会员激活码', '非官方卡腾讯好莱坞会员1年激活码充值账号VIP365天激活码卡--无措卡-无限叠加-质保10天', '/uploads/20180917/ee563fc5ab6193f518404fc5eee551c8.jpg', '1', '143.000', '143.000', '', '', '1', '', '569', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('18', '29', '128', '29325', '31', '好莱坞会员激活码', '腾讯好莱坞会员 3个月激活码', '/uploads/20180917/581e843dd4cb50bbd75a437d03da989a.jpg', '1', '42.350', '42.350', '', '', '1', '', '465', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('19', '29', '127', '28035', '31', '好莱坞会员激活码', '官方腾讯好莱坞会员30天激活码', '/uploads/20180917/c45245bec51204c6d1bbb3514fc39ab0.jpg', '1', '12.760', '12.760', '', '', '1', '', '546', '1', '3', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('20', '29', '126', '29374', '31', '好莱坞会员激活码', '官方卡腾讯好莱坞7天 激活码', '/uploads/20180917/1bf33c3370cc3a1944ac2e13fe6ec3c8.jpg', '1', '4.620', '5.170', '', '', '1', '', '644', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('21', '29', '125', '27352', '30', '爱奇艺会员激活码', '官方爱奇艺会员1年激活码当天使用', '/uploads/20180917/b2c216c5dcf6d69970933920a072b778.jpg', '1', '124.300', '124.300', '', '', '1', '', '284', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('22', '29', '124', '27692', '30', '爱奇艺会员激活码', '5折享  爱奇艺会员3个月激活码当天使用', '/uploads/20180917/2e8507d11d3eb8bb8a8d2fc35c4d03e6.jpg', '1', '35.420', '35.420', '', '', '1', '', '685', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('23', '29', '123', '26283', '30', '爱奇艺会员激活码', '官方爱奇艺黄金会员30天激活码', '/uploads/20180917/669b2eb171c3b69e035d54faa1f79bc3.jpg', '1', '11.880', '12.520', '', '', '1', '', '598', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('24', '29', '122', '28595', '30', '爱奇艺会员激活码', '官方爱奇艺黄金会员7天激活码', '/uploads/20180917/ba9e9828a99604013e5deb25fc0af1f5.jpg', '1', '4.620', '4.170', '', '', '1', '', '451', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('25', '29', '121', '26757', '29', 'QQ欢乐豆激活码 ', '新版（苹果）7x24小时极速体验-自动充值---QQ游戏欢乐豆-斗地主欢乐豆-时时更新数量-200万可批可存', '/uploads/20180918/776ed30d74b7438ad66e560c39070b61.jpg', '1', '52.800', '52.800', '', '', '1', '', '348', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('26', '29', '120', '26756', '29', 'QQ欢乐豆激活码 ', '新版（苹果）7x24小时极速体验-自动充值---QQ游戏欢乐豆-斗地主欢乐豆-时时更新数量-100万可批可存', '/uploads/20180918/745c628f71b10c67be3bb8fa3433e762.jpg', '1', '29.150', '29.150', '', '', '1', '', '465', '1', '2', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('27', '29', '119', '25170', '29', 'QQ欢乐豆激活码 ', '新版（安卓-PC）7x24小时极速体验-自动充值---QQ游戏欢乐豆-斗地主欢乐豆-时时更新数量-200万可批可存', '/uploads/20180918/776ed30d74b7438ad66e560c39070b61.jpg', '1', '51.700', '51.700', '', '', '1', '', '568', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('28', '29', '118', '25169', '29', 'QQ欢乐豆激活码 ', '新版（安卓-PC）7x24小时极速体验-自动充值---QQ游戏欢乐豆-斗地主欢乐豆-时时更新数量-100万可批可存', '/uploads/20180918/745c628f71b10c67be3bb8fa3433e762.jpg', '1', '29.150', '29.150', '', '', '1', '', '648', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('29', '29', '117', '29373', '28', '百度网盘会员激活码', '百度网盘超级会员月卡 无限叠加 质保3天', '/uploads/20180919/f16982124fd34cb57696f15bdf72554a.jpg', '1', '19.580', '19.580', '', '', '1', '', '154', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('30', '29', '116', '29372', '28', '百度网盘会员激活码', '百度网盘普通会员月卡 可叠加 质保2天', '/uploads/20180919/1be164f5477b498d8f5eedeed6437725.jpg', '1', '6.380', '6.380', '', '', '1', '', '342', '1', '3', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('31', '29', '115', '29225', '27', '红牛红包码', '红牛 码上有惊喜0.68-1688红包', '/uploads/20180919/5ae2a592b7b271baa7e86e2f8aef362a.jpg', '1', '0.310', '0.310', '', '', '1', '', '126', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('32', '29', '114', '29224', '26', '全国移动流量', '全国移动流量500M  质保3天', '/uploads/20180919/6d5de44763b7dc036d0e63f29f0adb19.jpg', '1', '3.520', '3.520', '', '', '1', '', '468', '1', '2', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('33', '29', '113', '29226', '25', '饿了么红包码', '饿了么随机必中1元 3元 8元现金红包 兑换码 ', '/uploads/20180919/ce79692952cb81a5f4c63892dbaa0635.jpg', '1', '0.460', '0.460', '', '', '1', '', '268', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('34', '29', '112', '29328', '24', '喜马拉雅激活码', '喜马拉雅巅峰会员周卡兑换码', '/uploads/20180919/d81be2b73a38b7ddac348740c8fbae31.jpg', '1', '1.650', '1.650', '', '', '1', '', '344', '1', '3', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('35', '29', '111', '27917', '23', '滴滴优惠券', '滴滴出行券全国通用 滴滴快车15元券优惠券-代金券打折卷-15元以内免费坐车-15以上抵15元-无限叠加充值-质保1天', '/uploads/20180919/fcdb3877bbd8df7b4d21e63948a8e95c.jpg', '1', '12.100', '12.100', '', '', '1', '', '158', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('36', '29', '110', '27918', '23', '滴滴优惠券', '滴滴出行券全国通用 滴滴快车10元券优惠券-代金券打折卷-10元以内免费坐车-10以上抵10元-无限叠加充值-质保1天', '/uploads/20180919/2fa1130b9deb3182cbc3a6824ed5851f.jpg', '1', '8.030', '8.030', '', '', '1', '', '327', '1', '3', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('37', '29', '109', '26271', '22', 'QQ体育会员激活码', '官方卡腾讯体育会员1个月激活码', '/uploads/20180919/348ab8f37b41a1fd715b3a8456e254ed.jpg', '1', '14.850', '15.000', '', '', '1', '', '486', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('38', '29', '108', '28686', '21', 'QQ绿钻激活码', '官方卡腾讯QQ豪华绿钻3个月激活码 保质期1天', '/uploads/20180919/bfa93f0ea6a22abfb6b78b26d1138153.jpg', '1', '28.600', '28.600', '', '', '1', '', '168', '1', '3', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('39', '29', '107', '26067', '21', 'QQ绿钻激活码', '官方卡腾讯QQ豪华绿钻1个月激活码-可叠加充值-保质期1天', '/uploads/20180919/b52e930fb15be693be73a2f5838d1c8e.jpg', '1', '11.000', '11.000', '', '', '1', '', '742', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('40', '29', '106', '28961', '20', 'QQ音乐包激活码', '官方卡qq付费音乐包1个月 ', '/uploads/20180919/65c027e4a4b6397b65fda09e155dc522.jpg', '1', '5.280', '5.280', '', '', '1', '', '684', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('41', '29', '105', '29290', '17', '美团外卖红包码', '官方卡美团外卖红包20元-美团外卖代金券20元激活码-满20元抵扣20元-全场通用-无限制使用-值保7天', '/uploads/20180919/900549df0605413cbcd8cb93d8e08f50.jpg', '1', '17.600', '17.600', '', '', '1', '', '489', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('42', '29', '104', '29289', '17', '美团外卖红包码', '官方美团外卖红包10元代金券10元激活码     满10元抵扣10元', '/uploads/20180919/0029bda508389ac3e494e58eebacc0b9.jpg', '1', '8.800', '8.800', '', '', '1', '', '469', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('43', '29', '103', '29288', '17', '美团外卖红包码', '官方美团外卖红包5元代金券5元激活码     满5元抵扣5元', '/uploads/20180919/ba06e7d71b6e075ca5d0eb735acc970c.jpg', '1', '4.400', '4.400', '', '', '1', '', '568', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('44', '29', '102', '27616', '43', '新浪微博播放', '【微博阅读】新浪微博视频播放量（1000000）播放|安全、稳定、质量、快速', '/uploads/20180914/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '432.300', '432.300', '', '', '1', '', '241', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('45', '29', '101', '27615', '43', '新浪微博播放', '【微博阅读】新浪微博视频播放量（100000）播放|安全、稳定、质量、快速', '/uploads/20180914/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '44.330', '44.330', '', '', '1', '', '459', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('46', '29', '100', '27614', '43', '新浪微博播放', '新浪微博视频播放量（50000）播放-------0-48小时内处理', '/uploads/20180918/42adff3fef0c648d5ba92c2d0cba7d5d.jpg', '0', '22.220', '22.220', '', '', '1', '', '468', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('47', '29', '99', '27613', '43', '新浪微博播放', '新浪微博视频播放量（10000）播放-------0-48小时内处理', '/uploads/20180918/c364a694fe326e7f0f8b26f8a061c0de.jpg', '0', '4.510', '4.510', '', '', '1', '', '468', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('48', '29', '98', '27592', '42', '新浪微博点赞', '新浪微博 点赞（10000）-------0-48小时内处理', '/uploads/20180918/c8a6bc58a9f83001c41fe858db824bce.jpg', '0', '88.550', '88.550', '', '', '1', '微博连接', '124', '1', '3', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('49', '29', '97', '27591', '42', '新浪微博点赞', '新浪微博 点赞（5000）-------0-48小时内处理', '/uploads/20180918/4ebfd866a2e540304965207700f78693.jpg', '0', '44.280', '44.280', '', '', '1', '微博连接', '261', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('50', '29', '96', '27590', '42', '新浪微博点赞', '新浪微博 点赞（1000）-------0-48小时内处理', '/uploads/20180918/60bb57057a4a1b38edc923727c02f3c2.jpg', '0', '8.910', '8.910', '', '', '1', '微博连接', '597', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('51', '29', '95', '27589', '42', '新浪微博点赞', '新浪微博 点赞（500）-------0-48小时内处理', '/uploads/20180918/cddaa711afd3b03276f9ed0dbc2fb98e.jpg', '0', '4.510', '4.510', '', '', '1', '微博连接', '454', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('52', '29', '94', '27588', '42', '新浪微博点赞', '新浪微博 点赞（100）-------0-48小时内处理', '/uploads/20180918/e89dbf862efd60ede7ea6ff32d775845.jpg', '0', '0.890', '0.890', '', '', '1', '微博连接', '646', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('53', '29', '93', '27580', '41', '新浪微博粉丝', '新浪微博 粉丝（50000）-------0-48小时内处理', '/uploads/20180918/0838b347887b75cfd14b2ca25adf6f97.jpg', '0', '663.300', '663.300', '', '', '1', '微博主页连接', '188', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('54', '29', '92', '27579', '41', '新浪微博粉丝', '新浪微博 粉丝（10000）-------0-48小时内处理', '/uploads/20180918/f3f56c8af0f2e0fdbf5a9bc33bbc51c7.jpg', '0', '139.700', '139.700', '', '', '1', '微博主页连接', '111', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('55', '29', '91', '27578', '41', '新浪微博粉丝', '新浪微博 粉丝（1000）-------0-48小时内处理', '/uploads/20180918/8d8f6b4644b7f4f7dd723c053a84ffe9.jpg', '0', '14.410', '14.410', '', '', '1', '微博主页连接', '542', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('56', '29', '90', '27577', '41', '新浪微博粉丝', '新浪微博 粉丝（100）-------0-48小时内处理', '/uploads/20180918/226ed79ac1eeca888b0170ded1725cdd.jpg', '0', '1.490', '1.490', '', '', '1', '微博主页连接', '264', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('57', '29', '89', '27576', '41', '新浪微博粉丝', '【新浪微博】新浪微博初级粉（50000）|安全、稳定、质量、快速|完美售后服务', '/uploads/20180914/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '248.600', '248.600', '', '', '1', '微博主页连接', '168', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('58', '29', '88', '27575', '41', '新浪微博粉丝', '【新浪微博】新浪微博初级粉（10000）|安全、稳定、质量、快速|完美售后服务', '/uploads/20180914/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '49.830', '49.830', '', '', '1', '微博主页连接', '368', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('59', '29', '87', '27574', '41', '新浪微博粉丝', '新浪微博 粉丝（5000）', '/uploads/20180914/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '24.970', '24.970', '', '', '1', '微博主页连接', '392', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('60', '29', '86', '27573', '41', '新浪微博粉丝', '【新浪微博】新浪微博初级粉（1000）|安全、稳定、质量、快速|完美售后服务', '/uploads/20180914/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '5.010', '5.010', '', '', '1', '微博主页连接', '638', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('61', '29', '85', '27389', '40', '全民K歌评论', '全民K歌-代刷评论-快速稳定----100000评论-可倍拍-不会下单看说明', '/uploads/20180914/135438398ffeb3d4dc21b6f08ac49645.gif,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '1.650', '1.650', '', '', '1', '歌曲ID', '687', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('62', '29', '84', '20504', '40', '全民K歌评论', '全民K歌   10000评论-------0-48小时内处理', '/uploads/20180918/1e872fa6e4807e7596ac135760f1b7a5.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '0.440', '0.310', '', '', '1', '歌曲ID', '348', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('63', '29', '83', '20503', '40', '全民K歌评论', '全民K歌   5000评论-------0-48小时内处理', '/uploads/20180918/6d7603b565060bb65053c6b78e2c316d.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '0.220', '0.150', '', '', '1', '歌曲ID', '284', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('64', '29', '82', '20502', '40', '全民K歌评论', '全民K歌    1000评论-------0-48小时内处理', '/uploads/20180918/522f96fe698e02fbc711f383d7de642a.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '0.040', '0.030', '', '', '1', '歌曲ID', '255', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('65', '29', '81', '20501', '40', '全民K歌评论', '全民K歌   100评论-------0-48小时内处理', '/uploads/20180918/bc0ae9077dd490e2ffd88d820beee4a2.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '0.010', '0.010', '', '', '1', '歌曲ID', '152', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('66', '29', '80', '27388', '39', '全民K歌粉丝', '全民K歌   50000粉丝-------0-48小时内处理', '/uploads/20180918/3d1c31170120c09dc19f8ac8a135d667.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '36.300', '36.300', '', '', '1', '歌曲ID', '434', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('67', '29', '79', '20508', '39', '全民K歌粉丝', '全民K歌   10000粉丝-------0-48小时内处理', '/uploads/20180918/e06c9174159214b270c2a4cde4b101fd.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '107.800', '4.290', '', '', '1', '歌曲ID', '648', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('68', '29', '78', '20507', '39', '全民K歌粉丝', '全民K歌   5000粉丝-------0-48小时内处理', '/uploads/20180918/20b8851abf5af6eea321d90af3e0d13d.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '53.900', '2.150', '', '', '1', '歌曲ID', '465', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('69', '29', '77', '20506', '39', '全民K歌粉丝', '全民K歌   1000粉丝-------0-48小时内处理', '/uploads/20180918/8c273397b24a42ba01bfd05b05d44061.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '10.780', '0.430', '', '', '1', '歌曲ID', '266', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('70', '29', '76', '20505', '39', '全民K歌粉丝', '全民K歌   100粉丝-------0-48小时内处理', '/uploads/20180918/c1d90617732b58c81274d1e8bc4eebf6.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '1.080', '0.040', '', '', '1', '歌曲ID', '288', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('71', '29', '75', '20519', '38', '全民K歌播放', '全民K歌-代刷试听-播放-快速稳定----50000播放-可倍拍-不会下单看说明', '/uploads/20180918/17038f0b72dad26a32cc588b68a261f4.jpg', '0', '6.600', '6.600', '', '', '1', '歌曲ID', '777', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('72', '29', '74', '20518', '38', '全民K歌播放', '全民K歌   100000播放-------0-48小时内处理', '/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '3.300', '3.300', '', '', '1', '歌曲ID', '345', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('73', '29', '73', '20517', '38', '全民K歌播放', '全民K歌    10000播放-------0-48小时内处理', '/uploads/20180918/801159701a1b73d865354cc9efac7ff7.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '0.330', '0.090', '', '', '1', '歌曲ID', '268', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('74', '29', '72', '20516', '38', '全民K歌播放', '全民K歌   1000播放-------0-48小时内处理', '/uploads/20180918/b7b1d297d7b47eaa0ded9eab9630113f.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '0.030', '0.330', '', '', '1', '歌曲ID:id', '199', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('75', '29', '71', '27382', '37', '全民K歌鲜花 ', '全民K歌   50000朵鲜花-------0-48小时内处理', '/uploads/20180918/26c3238492caec163ad6157c7821d9d2.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '25.300', '25.300', '', '', '1', '歌曲ID', '626', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('76', '29', '70', '20500', '37', '全民K歌鲜花 ', '全民K歌   10000朵鲜花-------0-48小时内处理', '/uploads/20180918/a9a1770d3a3fb8f1f28e675b034aecf4.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '49.500', '3.850', '', '', '1', '歌曲ID', '649', '0', '2', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('77', '29', '69', '20499', '37', '全民K歌鲜花 ', '全民K歌   5000朵鲜花-------0-48小时内处理', '/uploads/20180918/d20a09d0efb8a6cef0b0b67aabd93678.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '24.750', '1.930', '', '', '1', '歌曲ID', '517', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('78', '29', '68', '20498', '37', '全民K歌鲜花 ', '全民K歌   1000朵鲜花-------0-48小时内处理', '/uploads/20180918/a408c6b15d6deab907fdec3e75fc7693.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '4.950', '0.390', '', '', '1', '歌曲ID', '358', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('79', '29', '67', '20497', '37', '全民K歌鲜花 ', '全民K歌   100朵鲜花-------0-48小时内处理', '/uploads/20180918/87324a678adbc0e9dccb96985142031c.jpg,/uploads/20180918/5f26b52b26a8efbbb34bdb9a33834654.jpg', '0', '0.500', '0.040', '', '', '1', '歌曲ID', '699', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('80', '29', '66', '27124', '36', '快手评论', '快手作品评论666---10000评论-------0-48小时内处理', '/uploads/20180914/f25c185c7afe7ce94275a676710ec80e.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '462.000', '165.000', '', '', '1', '', '202', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('81', '29', '65', '27123', '36', '快手评论', '快手作品评论666---5000评论-------0-48小时内处理', '/uploads/20180914/9a20b2c7d102b84bbe0dcc95ec42e472.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '231.000', '159.500', '', '', '1', '', '243', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('82', '29', '64', '27122', '36', '快手评论', '快手作品评论666---1000评论-------0-48小时内处理', '/uploads/20180914/b8439acf1728261b3346246c92e426e8.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '46.200', '31.900', '', '', '1', '', '799', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('83', '29', '63', '27121', '36', '快手评论', '快手作品评论666---100评论-------0-48小时内处理', '/uploads/20180914/3c62702a73acf80e3ce47722a07f1d19.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '4.620', '3.190', '', '', '1', '', '715', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('84', '29', '62', '27120', '36', '快手评论', '快手作品评论666---50评论-------0-48小时内处理', '/uploads/20180915/7d93c81789f339f4de939626e577d404.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '2.310', '1.600', '', '', '1', '', '674', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('85', '29', '61', '27119', '36', '快手评论', '快手作品评论666---10评论-------0-48小时内处理', '/uploads/20180915/8de44b598d96d6ebd819f309f6f26bfd.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '0.460', '0.320', '', '', '1', '', '289', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('86', '29', '60', '21781', '16', '快手播放', '自动充值：快手播放----100000播放---特价--下单秒刷--请勿乱下链接-看商品说明-日刷1万', '/uploads/20180913/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '4.400', '4.400', '', '', '1', '', '689', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('87', '29', '59', '25808', '16', '快手播放', '快手播放----50000播放-------0-48小时内处理', '/uploads/20180915/af25a710d498d74455dc43784fe78543.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '2.480', '9.900', '', '', '1', '', '534', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('88', '29', '58', '25807', '16', '快手播放', '快手播放----10000播放-------0-48小时内处理', '/uploads/20180915/e0e8f095d3d8481e15e8859085385fd3.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '0.500', '1.980', '', '', '1', '', '284', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('89', '29', '57', '23758', '16', '快手播放', '快手播放----5000播-------0-48小时内处理', '/uploads/20180915/26e0f4776c933e6b5b686b815ceba160.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '0.250', '1.450', '', '', '1', '', '268', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('90', '29', '56', '28822', '14', '抖音双击', '（自动快充）抖音双击-抖音视频点赞-50000双击-日刷5万-支持视频id和链接下单', '/uploads/20180913/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '66.000', '1309.000', '', '', '1', '视频ID:video', '348', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('91', '29', '55', '28821', '14', '抖音双击', '（自动快充）抖音双击-抖音视频点赞-10000双击-日刷5万-支持视频id和链接下单', '/uploads/20180913/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '13.200', '261.800', '', '', '1', '视频ID:video', '555', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('92', '29', '54', '28820', '14', '抖音双击', '（自动快充）抖音双击-抖音视频点赞-5000双击-日刷5万-支持视频id和链接下单', '/uploads/20180913/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '6.600', '130.900', '', '', '1', '视频ID:video', '644', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('93', '29', '53', '28819', '14', '抖音双击', '（自动快充）抖音双击-抖音视频点赞-1000双击-日刷5万-支持视频id和链接下单', '/uploads/20180913/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '1.320', '26.180', '', '', '1', '视频ID:video', '728', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('94', '29', '52', '28818', '14', '抖音双击', '（自动快充）抖音双击-抖音视频点赞-500双击-日刷5万-支持视频id和链接下单', '/uploads/20180913/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '0.660', '13.090', '', '', '1', '视频ID:video', '648', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('95', '29', '51', '28817', '14', '抖音双击', '（自动快充）抖音双击-抖音视频点赞-100双击-作品链接下单------0-48小时内处理', '/uploads/20180913/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '0.130', '2.620', '', '', '1', '视频ID:video', '918', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('96', '29', '50', '26878', '14', '抖音双击', '抖音作品双击--50000双击-------0-48小时内处理', '/uploads/20180915/5792b912987e2297e8a9eee0773e7435.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '550.000', '739.200', '', '', '1', '视频ID:video', '469', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('97', '29', '49', '26877', '14', '抖音双击', '抖音作品双击--10000双击-------0-48小时内处理', '/uploads/20180915/97caad72a3687d5db731dd03980f7347.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '110.000', '147.840', '', '', '1', '视频ID:video', '689', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('98', '29', '48', '28820', '14', '抖音双击', '抖音作品双击--5000双击-------0-48小时内处理', '/uploads/20180915/894c00a3d9ae27d4a197134fd45ba8bd.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '55.000', '130.900', '', '', '1', '视频ID:video', '555', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('99', '29', '47', '28819', '14', '抖音双击', '抖音作品双击--1000双击-------0-48小时内处理', '/uploads/20180915/92969e50a79a1df1ded35394aaac866b.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '11.000', '26.180', '', '', '1', '视频ID:video', '666', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('100', '29', '46', '28818', '14', '抖音双击', '抖音作品双击--500双击-------0-48小时内处理', '/uploads/20180915/60aa699a78d2311d472ef8a02cb334c4.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '5.500', '13.090', '', '', '1', '视频ID:video', '763', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('101', '29', '45', '28817', '14', '抖音双击', '抖音作品双击--100双击-------0-48小时内处理', '/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '1.100', '2.620', '', '', '1', '视频ID:video', '211', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('102', '29', '44', '33317', '15', '抖音分享', '抖音作品分享--50000分享-------0-48小时内处理', '/uploads/20180915/463bab2a12dfe285457e401102207c90.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '16.500', '0.770', '', '', '1', '视频ID:video', '547', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('103', '29', '43', '33314', '15', '抖音分享', '抖音作品分享--10000分享-------0-48小时内处理', '/uploads/20180915/95e69a7662b0831cf4b98593740a2b04.jpg', '0', '3.300', '0.150', '', '', '1', '视频ID:video', '898', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('104', '29', '42', '27461', '15', '抖音分享', '抖音作品分享--5000分享-------0-48小时内处理', '/uploads/20180915/1e974c78ea3de4c5c68612dac3cefad5.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '1.650', '0.330', '', '', '1', '视频ID:video', '615', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('105', '29', '41', '27460', '15', '抖音分享', '抖音作品分享--1000分享-------0-48小时内处理', '/uploads/20180915/704ae512386e1c2a95b40d6ff8ec67ce.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '0.330', '0.070', '', '', '1', '视频ID:video', '355', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('106', '29', '40', '27459', '15', '抖音分享', '抖音作品分享--100分享-------0-48小时内处理', '/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '0.030', '0.010', '', '', '1', '视频ID:video', '358', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('107', '29', '39', '26885', '12', '抖音播放', '（自动充）抖音视频播放-抖音播放-500000播放-日刷百万-支持视频id和链接下单', '/uploads/20180913/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '16.500', '16.500', '', '', '1', '视频ID:video', '478', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('108', '29', '38', '26884', '12', '抖音播放', '（自动充）抖音视频播放-抖音播放-100000播放-日刷百万-支持视频id和链接下单', '/uploads/20180913/135438398ffeb3d4dc21b6f08ac49645.gif', '0', '3.300', '3.300', '', '', '1', '视频ID:video', '1015', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('109', '29', '37', '26883', '12', '抖音播放', '抖音视频播放-50000播放-------0-48小时内处理', '/uploads/20180915/25bbcdf0446dfe7bea23726512f072dd.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '1.650', '0.240', '', '', '1', '视频ID:video', '1357', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('110', '29', '36', '26882', '12', '抖音播放', '抖音视频播放-10000播放-------0-48小时内处理', '/uploads/20180915/d2bb449bc6e4325ccf46174ec592d866.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '0.330', '0.060', '', '', '1', '视频ID:video', '1284', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('111', '29', '35', '26881', '12', '抖音播放', '抖音视频播放-5000播放-------0-48小时内处理', '/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '0.170', '0.020', '', '', '1', '视频ID:video', '1147', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('112', '29', '34', '26880', '12', '抖音播放', '抖音视频播放-1000播放-------0-48小时内处理', '/uploads/20180915/9fcbceeae0d2181fb638633ab920660b.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '0.030', '0.010', '', '', '1', '视频ID:video', '1054', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('113', '29', '33', '25804', '35', '快手双击', '快手双击----50000双击-------0-48小时内处理', '/uploads/20180915/b544fca035de1aa675899a5d96654a24.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '77.000', '13.750', '', '', '1', '作品链接', '258', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('114', '29', '32', '25803', '35', '快手双击', '快手双击----10000双击-------0-48小时内处理', '/uploads/20180915/da83093042d504aa8aa73c851f114260.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '15.400', '3.410', '', '', '1', '作品链接', '456', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('115', '29', '31', '25802', '35', '快手双击', '快手双击----5000双击-------0-48小时内处理', '/uploads/20180915/a07f4937fb90f78461883fbabee31935.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '7.700', '1.710', '', '', '1', '作品链接', '568', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('116', '29', '30', '25801', '35', '快手双击', '快手双击----1000双击-------0-48小时内处理', '/uploads/20180915/2d3793182e6c703878b888db51e71fdc.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '1.540', '0.340', '', '', '1', '作品链接', '757', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('117', '29', '29', '25800', '35', '快手双击', '快手双击----500双击-------0-48小时内处理', '/uploads/20180915/10ed54cceafa7e732f4ca38af3beadd4.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '0.770', '0.170', '', '', '1', '作品链接', '649', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('118', '29', '28', '25799', '35', '快手双击', '快手双击----100双击-------0-48小时内处理', '/uploads/20180915/2672037692ac34486d3742d146916e5e.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '0.150', '0.030', '', '', '1', '作品链接', '859', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('119', '29', '27', '25803', '35', '快手双击', '快手双击----10000次-------0-48小时内处理', '/uploads/20180915/da83093042d504aa8aa73c851f114260.jpg,/uploads/20190220/9708fd6e42b8e6ce0875557f90f9f807.jpg', '0', '13.200', '3.410', '', '', '1', '作品链接', '523', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('120', '29', '26', '25802', '35', '快手双击', '快手双击----5000次-------0-48小时内处理', '/uploads/20180915/a07f4937fb90f78461883fbabee31935.jpg,/uploads/20190220/9708fd6e42b8e6ce0875557f90f9f807.jpg', '0', '6.600', '1.930', '', '', '1', '', '995', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('121', '29', '25', '25801', '35', '快手双击', '快手双击----1000次-------0-48小时内处理', '/uploads/20180915/2d3793182e6c703878b888db51e71fdc.jpg,/uploads/20190220/9708fd6e42b8e6ce0875557f90f9f807.jpg', '0', '1.320', '0.390', '', '', '1', '', '998', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('122', '29', '24', '25799', '35', '快手双击', '快手双击----100次-------0-48小时内处理', '/uploads/20180915/2672037692ac34486d3742d146916e5e.jpg,/uploads/20190220/9708fd6e42b8e6ce0875557f90f9f807.jpg', '0', '0.130', '0.040', '', '', '1', '', '594', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('123', '29', '23', '27235', '11', '抖音粉丝', '（自动充）抖音视频高仿活粉丝-抖音粉丝-50000粉丝-日刷10万-支持抖音主页id链接和视频链接下单', '/uploads/20180914/2fa034b5e5974a695179cde30c07af24.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '286.000', '286.000', '', '', '1', '抖音视频ID:video', '388', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('124', '29', '22', '27234', '11', '抖音粉丝', '（自动充）抖音视频高仿活粉丝-抖音粉丝-10000粉丝-日刷10万-支持抖音主页id链接和视频链接下单', '/uploads/20180914/efea41cab697906a67ace3aa66b65c12.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '57.200', '57.200', '', '', '1', '抖音视频ID:video', '584', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('125', '29', '21', '27233', '11', '抖音粉丝', '（自动充）抖音视频高仿活粉丝-抖音粉丝-5000粉丝-日刷10万-支持抖音主页id链接和视频链接下单', '/uploads/20180914/3124bad2cdb8bb24e7b954ab2bed1b9e.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '28.600', '28.600', '', '', '1', '抖音视频ID:video', '555', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('126', '29', '20', '27232', '11', '抖音粉丝', '（自动充）抖音视频高仿活粉丝-抖音粉丝-1000粉丝-日刷10万-支持抖音主页id链接和视频链接下单', '/uploads/20180914/f791da7cbffd9184f9c6641b996e1d96.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '5.720', '5.720', '', '', '1', '抖音视频ID:video', '791', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('127', '29', '19', '27231', '11', '抖音粉丝', '（自动充）抖音视频高仿活粉丝-抖音粉丝-500粉丝-日刷10万-支持抖音主页id链接和视频链接下单', '/uploads/20180914/73d80c50ee1e7dab3d383b8110f96525.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '2.860', '2.860', '', '', '1', '抖音视频ID:video', '755', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('128', '29', '18', '27230', '11', '抖音粉丝', '（自动充）抖音视频高仿活粉丝-抖音粉丝-100粉丝-日刷10万-支持抖音主页id链接和视频链接下单', '/uploads/20180914/1c7ecfc4b0bc17ef27cc93364e2ea9ab.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '0.570', '0.570', '', '', '1', '抖音视频ID:video', '645', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('129', '29', '17', '27016', '11', '抖音粉丝', '抖音粉丝-抖音视频粉丝-50000粉丝-------0-48小时内处理', '/uploads/20180914/2fa034b5e5974a695179cde30c07af24.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '1127.500', '2200.000', '', '', '1', '抖音视频ID:video', '299', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('130', '29', '16', '27015', '11', '抖音粉丝', '抖音粉丝-抖音视频粉丝-10000粉丝-------0-48小时内处理', '/uploads/20180914/efea41cab697906a67ace3aa66b65c12.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '159.500', '372.900', '', '', '1', '抖音视频ID:video', '498', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('131', '29', '15', '27014', '11', '抖音粉丝', '抖音粉丝-抖音视频粉丝-5000粉丝-------0-48小时内处理', '/uploads/20180914/3124bad2cdb8bb24e7b954ab2bed1b9e.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '79.200', '186.450', '', '', '1', '抖音视频ID:video', '436', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('132', '29', '14', '27013', '11', '抖音粉丝', '抖音粉丝-抖音视频粉丝-1000粉丝-------0-48小时内处理', '/uploads/20180914/f791da7cbffd9184f9c6641b996e1d96.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '15.400', '37.290', '', '', '1', '抖音视频ID:video', '838', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('133', '29', '13', '27012', '11', '抖音粉丝', '抖音粉丝-抖音视频粉丝-500粉丝-------0-48小时内处理', '/uploads/20180914/73d80c50ee1e7dab3d383b8110f96525.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '7.980', '18.650', '', '', '1', '抖音视频ID:video', '825', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('134', '29', '12', '27011', '11', '抖音粉丝', '抖音粉丝-抖音视频粉丝-100粉丝-------0-48小时内处理', '/uploads/20180914/1c7ecfc4b0bc17ef27cc93364e2ea9ab.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '1.600', '3.730', '', '', '1', '抖音视频ID:video', '665', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('135', '29', '11', '26891', '13', '抖音评论', '抖音视频评论--50000评论-------0-48小时内处理', '/uploads/20180914/7ebb89517f05733f1a88b8220c063a11.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '407.000', '407.000', '', '', '1', '抖音视频ID:video', '346', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('136', '29', '10', '26887', '13', '抖音评论', '抖音视频评论--50评论-------0-48小时内处理', '/uploads/20180914/abe09f9a2eed9ca8f6f6e91a8e28af6a.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '81.400', '4.840', '', '', '1', '抖音视频ID:video', '321', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('137', '29', '9', '26886', '13', '抖音评论', '抖音视频评论--10评论-------0-48小时内处理', '/uploads/20180914/904aa22a70a9d32326412c19cbe38eef.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '35.750', '0.970', '', '', '1', '抖音视频ID:video', '526', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('138', '29', '8', '26890', '13', '抖音评论', '抖音视频评论--1000评论-------0-48小时内处理', '/uploads/20180914/d1f4c6461b22b614a73b34ea0d576996.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '7.150', '96.800', '', '', '1', '抖音视频ID:video', '535', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('139', '29', '7', '26889', '13', '抖音评论', '抖音视频评论--500评论-------0-48小时内处理', '/uploads/20180914/ec9bdb7875f346acc41d75dbc435ce91.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '3.580', '48.400', '', '', '1', '抖音视频ID:video', '499', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('140', '29', '6', '26888', '13', '抖音评论', '抖音视频评论--100评论-------0-48小时内处理', '/uploads/20180914/97ebf55977639f99b7b3a03a58ef4a1a.jpg,/uploads/20190516/978eaa052746354f69de404faeb2757a.jpg', '0', '0.720', '9.680', '', '', '1', '抖音视频ID:video', '569', '0', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('141', '29', '5', '999999', '5', '爱奇艺', '官方爱奇艺黄金会员7天激活码', '/uploads/20180917/94e45fac1edc41ad45e05393b8e0d547.jpg', '1', '4.620', '4.180', '', '', '1', '', '215', '1', '1', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('142', '29', '4', '27011', '11', '抖音粉丝', '【自动充值】抖音100粉丝-------0-48小时内处理', '/uploads/20180915/0f58bbdd75222c08e049b4674edf2605.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '0.910', '0.910', '', '', '1', '抖音视频ID:video', '150', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('143', '29', '3', '23757', '16', '快手播放', '快手播放----1000播放-------0-48小时内处理', '/uploads/20180915/81103400ca3ca687cebc762603dee13c.jpg,/uploads/20180917/4a8e0d27fe2d76a764efad2180a4b4ad.jpg', '0', '0.060', '0.290', '11', '222', '1', '', '354', '0', '2', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('144', '29', '2', '27013', '11', '抖音粉丝', '抖音视频粉丝-1000粉丝-------0-48小时内处理', '/uploads/20180915/32c98198cfff5b0f550786399d042402.png,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '4.180', '33.550', '', '', '1', '抖音视频ID:video', '100', '1', '1', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('145', '29', '1', '27011', '11', '抖音粉丝', '抖音视频粉丝-100粉丝-------0-48小时内处理', '/uploads/20180915/0f58bbdd75222c08e049b4674edf2605.jpg,/uploads/20180917/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '0.420', '3.360', '', '', '1', '抖音视频ID:video', '150', '1', '2', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('146', '29', '161', '29444', '52', '快手直播人气', '（24小时自动上人)100人单次-快手直播人气-2小时内掉线重播自动上人', '/uploads/20190129/a23e22d9217d28e3b894c97bd93abb93.jpg,/uploads/20190129/47c10ca0239a6692c5c1c45c87a795e8.jpg', '0', '5.000', '3.190', '', '', '1', '', '632', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('147', '29', '160', '29442', '52', '快手直播人气', '（24小时自动上人)50人单次-快手直播人气-2小时内掉线重播自动上人', '/uploads/20190129/cd01540645a0a99c7d0043c3528836c7.jpg,/uploads/20190129/47c10ca0239a6692c5c1c45c87a795e8.jpg', '0', '3.990', '2.200', '', '', '1', '', '564', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('148', '29', '159', '29481', '52', '快手直播人气', '(24小时自动上人)30人单次-快手直播人气-2小时内掉线重播自动上人', '/uploads/20190129/73f751679238b4c52072b72457d8f8c4.jpg,/uploads/20190129/47c10ca0239a6692c5c1c45c87a795e8.jpg', '0', '2.990', '2.190', '', '', '1', '', '582', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('149', '29', '158', '30778', '18', '福利', '腾讯大王卡新年卡，开卡充值50送120，百款APP免流量', '/uploads/20190128/e0c11921d4419891096d409b7ff7f68d.png', '1', '1.000', '0.010', '', '', '1', '', '5890', '1', '1', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('150', '29', '157', '30778', '18', '福利', '腾讯大王卡', '/uploads/20190128/e0c11921d4419891096d409b7ff7f68d.png', '1', '1.000', '0.010', '', '', '1', '', '5890', '1', '1', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('151', '29', '156', '27011', '11', '抖音粉丝', '抖音100粉丝------1分钱体验------下单快速处理-----1个抖音账户只限1次，多笔订单只充值一次。', '/uploads/20190125/1c7ecfc4b0bc17ef27cc93364e2ea9ab.jpg,/uploads/20190125/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '0.500', '0.500', '', '', '1', '抖音视频ID:video', '750', '1', '1', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('152', '29', '155', '30857', '51', '小红书评论', '小红书评论    100 评论', '/uploads/20190117/7a20c32748fbca4ccd0c28c9e4b0a82e.jpg,/uploads/20190117/717cd1cc110b8b1e00366362936080e0.jpg', '0', '44.330', '44.330', '', '', '1', '任意笔记连接', '110', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('153', '29', '154', '30856', '51', '小红书评论', '小红书评论    20 评论', '/uploads/20190117/27631bc78eb2e7e712a4d327a897a91d.jpg,/uploads/20190117/717cd1cc110b8b1e00366362936080e0.jpg', '0', '8.910', '8.910', '', '', '1', '', '220', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('154', '29', '153', '30855', '51', '小红书评论', '小红书评论    5 评论', '/uploads/20190117/c29e2a25bee2a19cfa28dc417b39683c.jpg,/uploads/20190117/717cd1cc110b8b1e00366362936080e0.jpg', '0', '2.210', '2.210', '', '', '1', '', '143', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('155', '29', '152', '28293', '50', '小红书收藏', '小红书收藏   1000收藏', '/uploads/20190117/b2f98e0dd688d7f0ae0a5357cc5d2248.jpg,/uploads/20190117/717cd1cc110b8b1e00366362936080e0.jpg', '0', '71.500', '71.500', '', '', '1', '', '211', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('156', '29', '151', '28292', '50', '小红书收藏', '小红书收藏   500收藏', '/uploads/20190117/a48cea58a813aee36af12cf6d235a3d9.jpg,/uploads/20190117/717cd1cc110b8b1e00366362936080e0.jpg', '0', '38.500', '38.500', '', '', '1', '', '152', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('157', '29', '150', '28291', '50', '小红书收藏', '小红书收藏   100收藏', '/uploads/20190117/6f780a0341b21862dea457863515b9ba.jpg,/uploads/20190117/717cd1cc110b8b1e00366362936080e0.jpg', '0', '7.700', '7.700', '', '', '1', '', '15', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('158', '29', '149', '28283', '49', '小红书粉丝', '小红书真人 1000粉丝', '/uploads/20190117/6fdbceb03e1df9f02a10a91a8edcf926.jpg,/uploads/20190117/717cd1cc110b8b1e00366362936080e0.jpg', '0', '71.500', '71.500', '', '', '1', '任意笔记连接', '26', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('159', '29', '148', '28282', '49', '小红书粉丝', '小红书真人 500粉丝', '/uploads/20190117/10c496b3d299a1b7e5e31eb3c93cdc46.jpg,/uploads/20190117/717cd1cc110b8b1e00366362936080e0.jpg', '0', '38.500', '38.500', '', '', '1', '任意笔记连接', '265', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('160', '29', '147', '28281', '49', '小红书粉丝', '小红书真人 100粉丝', '/uploads/20190117/65180601a324fd8d52abf3e3608908ad.jpg,/uploads/20190117/717cd1cc110b8b1e00366362936080e0.jpg', '0', '7.700', '0.110', '', '', '1', '任意笔记连接', '152', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('161', '29', '146', '0', '47', '小程序流量主', '【南宫科技】微信小程序流量主包开通，请填写小程序名字，不要关闭搜索。', '/uploads/20190106/837608074eb35ad65c7283a14319ba1e.jpg', '0', '1.100', '1.100', '', '', '10', '0', '16', '1', '0', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('162', '29', '163', '30116', '11', '抖音粉丝', '抖音粉丝-100活人粉丝-部分带作品-上限5000粉丝', '/uploads/20190703/1c7ecfc4b0bc17ef27cc93364e2ea9ab.jpg,/uploads/20190703/d1f84f396b663bfdddcd89898dc03bd5.jpg', '0', '18.480', '18.480', '', '', '1', '抖音视频ID:video', '327', '0', '1', '0', '0', '0');
INSERT INTO `ims_hcsup_goods` VALUES ('163', '29', '162', '30833', '33', '芒果TV会员激活码', '湖南芒果TV视频月卡一个月激活码', '/uploads/20190419/127f16c11dfc34faf177548cb3deb355.jpg', '0', '9.900', '9.900', '', '', '1', '', '356', '1', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `ims_hcsup_nexus`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcsup_nexus`;
CREATE TABLE `ims_hcsup_nexus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pppid` int(11) NOT NULL,
  `ppid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcsup_nexus
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcsup_setting`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcsup_setting`;
CREATE TABLE `ims_hcsup_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `only` varchar(20) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `only` (`only`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcsup_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcsup_upgrade`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcsup_upgrade`;
CREATE TABLE `ims_hcsup_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `trade_no` varchar(20) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `createtime` char(10) NOT NULL,
  `paytime` char(10) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcsup_upgrade
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcsup_users`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcsup_users`;
CREATE TABLE `ims_hcsup_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(200) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) NOT NULL,
  `sessionkey` varchar(50) NOT NULL,
  `unionid` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `createtime` char(10) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  `level` tinyint(1) NOT NULL DEFAULT '1',
  `pid` int(11) NOT NULL,
  `what` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcsup_users
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_banner`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_banner`;
CREATE TABLE `ims_hcxws_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `banner` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1关闭',
  `displayorder` int(11) NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_banner
-- ----------------------------
INSERT INTO `ims_hcxws_banner` VALUES ('1', '122', '测试', '0', 'images/122/2018/12/Mtd4bj4v6G6q07q61dMqq71TmdqzDQ.jpg', '0', '0', '1553949536');

-- ----------------------------
-- Table structure for `ims_hcxws_category`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_category`;
CREATE TABLE `ims_hcxws_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` int(11) NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_category
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_click`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_click`;
CREATE TABLE `ims_hcxws_click` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_click
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_collect`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_collect`;
CREATE TABLE `ims_hcxws_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_collect
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_fans`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_fans`;
CREATE TABLE `ims_hcxws_fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `fans` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_fans
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_flower`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_flower`;
CREATE TABLE `ims_hcxws_flower` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  `addtime` char(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_flower
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_formid`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_formid`;
CREATE TABLE `ims_hcxws_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `formid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_formid
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_goods`;
CREATE TABLE `ims_hcxws_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `cate` varchar(20) DEFAULT NULL COMMENT '分类标签',
  `title` varchar(100) DEFAULT NULL COMMENT '标题、品类、名称、型号',
  `desc` varchar(500) DEFAULT NULL COMMENT '详细介绍',
  `thumbs` varchar(500) DEFAULT NULL COMMENT '图集,号分割',
  `video` varchar(500) DEFAULT NULL COMMENT '视频,号分割',
  `videothumb` varchar(500) NOT NULL,
  `isnew` tinyint(1) DEFAULT '0' COMMENT '1全新',
  `isrec` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(100) NOT NULL,
  `telphone` varchar(15) NOT NULL,
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `price` int(11) DEFAULT '0' COMMENT '起拍价',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `number` int(11) DEFAULT '1' COMMENT '上架数量',
  `sales` int(11) NOT NULL DEFAULT '0',
  `addtime` char(10) DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '1上架',
  `offtype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1自主',
  `ontime` char(10) DEFAULT NULL COMMENT '上架时间',
  `favorate` int(11) DEFAULT '0' COMMENT '赞',
  `collect` int(11) NOT NULL DEFAULT '0',
  `salerid` int(11) DEFAULT NULL,
  `saler` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL,
  `ischeck` tinyint(1) NOT NULL DEFAULT '0',
  `cause` varchar(500) NOT NULL,
  `url` varchar(500) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `uid` (`salerid`),
  KEY `salerid` (`salerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发布商品表\r\n';

-- ----------------------------
-- Records of ims_hcxws_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_nexus`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_nexus`;
CREATE TABLE `ims_hcxws_nexus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_nexus
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_order`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_order`;
CREATE TABLE `ims_hcxws_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `gid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `openid` varchar(30) NOT NULL,
  `title` varchar(200) NOT NULL,
  `trade_no` varchar(18) DEFAULT NULL COMMENT '订单编号',
  `transaction_id` varchar(50) NOT NULL,
  `integral` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0' COMMENT '1已拍下2已付款3已发货4已完成5感谢视频6取消',
  `expresn` varchar(30) DEFAULT NULL COMMENT '快递编号',
  `exprecode` varchar(50) NOT NULL,
  `expretime` char(10) NOT NULL,
  `createtime` char(10) DEFAULT NULL,
  `paytime` char(10) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `mobile` varchar(12) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `isdelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`),
  KEY `uid` (`uid`),
  KEY `trade_no` (`trade_no`),
  KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_order
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_search`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_search`;
CREATE TABLE `ims_hcxws_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `createtime` char(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_search
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_setting`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_setting`;
CREATE TABLE `ims_hcxws_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `only` varchar(20) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `only` (`only`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_setting
-- ----------------------------
INSERT INTO `ims_hcxws_setting` VALUES ('10', '122', 'basic122', 'basic', '{\"title\":\"\\u6d4b\\u8bd5\\u5c0f\\u7a0b\\u5e8f\",\"startup_bg\":\"images\\/122\\/2018\\/12\\/Mtd4bj4v6G6q07q61dMqq71TmdqzDQ.jpg\",\"switch\":\"0\",\"toppic\":\"images\\/122\\/2018\\/12\\/Mtd4bj4v6G6q07q61dMqq71TmdqzDQ.jpg\",\"icon\":\"images\\/122\\/2018\\/12\\/Mtd4bj4v6G6q07q61dMqq71TmdqzDQ.jpg\",\"integral\":\"\\u79ef\\u5206\",\"unit\":\"\\u5206\",\"intdesc\":\"\\u989d\",\"expfee\":\"2\"}');
INSERT INTO `ims_hcxws_setting` VALUES ('11', '122', 'icon122', 'icon', '{\"store\":\"images\\/122\\/2018\\/12\\/Mtd4bj4v6G6q07q61dMqq71TmdqzDQ.jpg\",\"today\":\"images\\/122\\/2018\\/12\\/Mtd4bj4v6G6q07q61dMqq71TmdqzDQ.jpg\",\"own\":\"images\\/122\\/2018\\/12\\/Mtd4bj4v6G6q07q61dMqq71TmdqzDQ.jpg\",\"story\":\"images\\/122\\/2018\\/12\\/Mtd4bj4v6G6q07q61dMqq71TmdqzDQ.jpg\",\"sign\":\"images\\/122\\/2018\\/12\\/Mtd4bj4v6G6q07q61dMqq71TmdqzDQ.jpg\"}');
INSERT INTO `ims_hcxws_setting` VALUES ('12', '122', 'forward122', 'forward', '{\"title\":\"\",\"img\":\"\"}');
INSERT INTO `ims_hcxws_setting` VALUES ('13', '122', 'version122', 'version', '{\"number\":\"\"}');
INSERT INTO `ims_hcxws_setting` VALUES ('14', '122', 'tpl122', 'tpl', '{\"sign\":\"\",\"order\":\"\"}');
INSERT INTO `ims_hcxws_setting` VALUES ('15', '122', 'sign122', 'sign', '{\"first\":\"\",\"next\":\"\",\"rule\":\"\"}');
INSERT INTO `ims_hcxws_setting` VALUES ('16', '122', 'qiniu122', 'qiniu', '{\"accessKey\":\"\",\"secretKey\":\"\",\"bucket\":\"\",\"domain\":\"\",\"pipeline\":\"\"}');
INSERT INTO `ims_hcxws_setting` VALUES ('17', '122', 'adunit122', 'adunit', '');
INSERT INTO `ims_hcxws_setting` VALUES ('18', '122', 'rule122', 'rule', '{\"register\":[\"\\u6ce8\\u518c\\u8d26\\u6237\",0,200,\"+\"],\"info\":[\"\\u5b8c\\u5584\\u8d44\\u6599\",0,30,\"+\"],\"publish\":[\"\\u53d1\\u5e03\\u5b9d\\u8d1d\",0,5,\"+\"],\"first\":[\"\\u9996\\u6b21\\u9001\\u51fa\\u5b9d\\u8d1d\",0,50,\"+\"],\"video\":[\"\\u53d1\\u5e03\\u611f\\u8c22\\u89c6\\u9891\",0,10,\"+\"],\"invite\":[\"\\u9080\\u8bf7\\u65b0\\u7528\\u6237\",0,[20,120],\"+\"]}');

-- ----------------------------
-- Table structure for `ims_hcxws_sign`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_sign`;
CREATE TABLE `ims_hcxws_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `date` char(8) DEFAULT NULL,
  `inte` int(11) DEFAULT NULL,
  `addtime` char(10) NOT NULL,
  `day` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_sign
-- ----------------------------

-- ----------------------------
-- Table structure for `ims_hcxws_users`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_users`;
CREATE TABLE `ims_hcxws_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  `createtime` char(10) DEFAULT NULL,
  `sessionkey` varchar(50) NOT NULL,
  `unionid` varchar(50) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  `fans` int(11) DEFAULT '0' COMMENT '粉丝',
  `follow` int(11) DEFAULT '0' COMMENT '关注',
  `level` tinyint(4) NOT NULL DEFAULT '1',
  `desc` varchar(500) NOT NULL,
  `sign` tinyint(1) NOT NULL DEFAULT '0',
  `store` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_users
-- ----------------------------
INSERT INTO `ims_hcxws_users` VALUES ('1', '122', '0', '', '', 'ovD0V0e97it37020LH_yNOPmw2Qs', '', '0', '', '', '', '0', '1553949430', 'j57X3oanvV/5E5T1VipzoA==', '', '1', '0', '0', '1', '', '0', '0');

-- ----------------------------
-- Table structure for `ims_hcxws_video`
-- ----------------------------
DROP TABLE IF EXISTS `ims_hcxws_video`;
CREATE TABLE `ims_hcxws_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `desc` varchar(1000) NOT NULL,
  `video` varchar(500) NOT NULL,
  `thumb` varchar(500) NOT NULL,
  `createtime` char(10) NOT NULL,
  `times` int(11) NOT NULL DEFAULT '0',
  `collect` int(11) NOT NULL DEFAULT '0',
  `favorate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_hcxws_video
-- ----------------------------
