/*
Navicat MySQL Data Transfer

Source Server         : www_qiannaisi_com
Source Server Version : 50642
Source Host           : 47.92.195.86:3306
Source Database       : www_qiannaisi_com

Target Server Type    : MYSQL
Target Server Version : 50642
File Encoding         : 65001

Date: 2019-01-20 17:21:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_yzkm_sun_aboutus
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_aboutus`;
CREATE TABLE `ims_yzkm_sun_aboutus` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关于我们表id',
  `us_tel` decimal(11,0) DEFAULT NULL,
  `us_details` text,
  `us_addr` varchar(100) DEFAULT NULL,
  `us_img` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_addnews
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_addnews`;
CREATE TABLE `ims_yzkm_sun_addnews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '公告表',
  `title` varchar(255) NOT NULL COMMENT '标题，展示用',
  `left` int(10) unsigned NOT NULL,
  `state` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1显示，2为关闭',
  `uniacid` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '类型',
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_address
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_address`;
CREATE TABLE `ims_yzkm_sun_address` (
  `adid` int(11) NOT NULL AUTO_INCREMENT COMMENT '地址表',
  `name` varchar(45) NOT NULL COMMENT '收货人',
  `telNumber` varchar(30) NOT NULL,
  `countyName` varchar(100) NOT NULL COMMENT '地址',
  `detailInfo` varchar(100) NOT NULL,
  `isdefault` varchar(11) DEFAULT '0',
  `oprnid` varchar(55) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `cityName` varchar(100) NOT NULL,
  `provinceName` varchar(100) NOT NULL,
  `city_rong` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '2' COMMENT '1 默认地址  2 普通地址',
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`adid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_area
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_area`;
CREATE TABLE `ims_yzkm_sun_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_background
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_background`;
CREATE TABLE `ims_yzkm_sun_background` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '前端商家页面头部背景图 id',
  `background` varchar(255) DEFAULT NULL COMMENT '前端商家页面头部背景图',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_banner`;
CREATE TABLE `ims_yzkm_sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '轮播图',
  `bname` varchar(200) CHARACTER SET utf8 NOT NULL,
  `url` varchar(300) NOT NULL COMMENT '文章图片',
  `lb_imgs` varchar(500) NOT NULL COMMENT '文章那个内容',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
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
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for ims_yzkm_sun_browse
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_browse`;
CREATE TABLE `ims_yzkm_sun_browse` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '浏览量列表',
  `zx_id` int(11) DEFAULT NULL COMMENT '圈子id',
  `openid` varchar(50) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=236 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_collect
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_collect`;
CREATE TABLE `ims_yzkm_sun_collect` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT '收藏表',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `store_id` int(11) DEFAULT NULL COMMENT '商家id',
  `state` int(11) DEFAULT '0' COMMENT '收藏状态  0取消收藏 （未收藏）1添加收藏（已收藏）',
  `uniacid` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_collect_qz
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_collect_qz`;
CREATE TABLE `ims_yzkm_sun_collect_qz` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户评论表（用户与用户之间的）',
  `fabu_zx_id` int(11) DEFAULT NULL COMMENT '发布用户id',
  `pinl_user_id` varchar(30) DEFAULT NULL COMMENT '评论用户id',
  `uniacid` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT '0' COMMENT '0 未收藏 1 已收藏',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_comment_yh
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_comment_yh`;
CREATE TABLE `ims_yzkm_sun_comment_yh` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '圈子评论表（用户评价用户）',
  `fabu_zx_id` varchar(50) DEFAULT NULL COMMENT '发布用户',
  `pl_user_openid` varchar(50) DEFAULT NULL COMMENT '评论用户',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '用户评论时间',
  `uniacid` int(11) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL COMMENT '用户评论内容',
  PRIMARY KEY (`id`),
  KEY `fabu_zx_id` (`fabu_zx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_yzkm_sun_comments
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_comments`;
CREATE TABLE `ims_yzkm_sun_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家评论表（用户评论商家）',
  `store_id` int(11) NOT NULL COMMENT '商家id',
  `userId` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `store_name` varchar(20) DEFAULT NULL COMMENT '商家名字',
  `details` text COMMENT '评论内容',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '评论时间',
  `reply` text COMMENT '回复内容',
  `hf_time` datetime DEFAULT NULL,
  `zx_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_coupon`;
CREATE TABLE `ims_yzkm_sun_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '优惠券',
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '优惠券名称，展示用',
  `type` tinyint(3) unsigned DEFAULT NULL COMMENT '优惠券类型（1:折扣 2:代金）',
  `astime` timestamp NULL DEFAULT NULL COMMENT '活动开始时间',
  `antime` timestamp NULL DEFAULT NULL COMMENT '活动结束时间',
  `expiryDate` int(10) unsigned DEFAULT NULL COMMENT '领取后，使用有效期',
  `allowance` int(10) unsigned DEFAULT NULL COMMENT '余量',
  `total` int(10) unsigned DEFAULT NULL COMMENT '总量',
  `val` int(25) DEFAULT NULL COMMENT '功能',
  `exchange` tinyint(3) unsigned DEFAULT NULL COMMENT '积分兑换',
  `scene` tinyint(4) unsigned DEFAULT NULL COMMENT '场景（1:充值赠送，2:买单赠送）',
  `showIndex` tinyint(4) DEFAULT NULL COMMENT '是否首页显示（0:不显示 1:显示）',
  `uniacid` int(11) DEFAULT NULL,
  `vab` int(11) DEFAULT NULL COMMENT '满减',
  `state` int(11) DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_custom
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_custom`;
CREATE TABLE `ims_yzkm_sun_custom` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '前端商家首页自定义部分',
  `tb_name` varchar(20) DEFAULT NULL COMMENT '首页名称',
  `pic_one` varchar(255) DEFAULT NULL,
  `pic_tow` varchar(255) DEFAULT NULL,
  `pic_three` varchar(255) DEFAULT NULL,
  `pic_four` varchar(255) DEFAULT NULL,
  `pic_five` varchar(255) DEFAULT NULL,
  `db_name1` varchar(20) DEFAULT NULL,
  `db_name2` varchar(20) DEFAULT NULL,
  `db_name3` varchar(20) DEFAULT NULL,
  `db_name4` varchar(20) DEFAULT NULL,
  `db_name5` varchar(20) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL COMMENT '字体颜色',
  `fontcolor` varchar(20) DEFAULT NULL COMMENT '商店头部背景颜色',
  `uniacid` int(20) DEFAULT NULL,
  `pic_one1` varchar(255) DEFAULT NULL,
  `pic_tow1` varchar(255) DEFAULT NULL,
  `pic_three1` varchar(255) DEFAULT NULL,
  `pic_four1` varchar(255) DEFAULT NULL,
  `pic_five1` varchar(255) DEFAULT NULL,
  `key` int(11) DEFAULT '0' COMMENT '1隐藏发布按钮  0显示发布按钮',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_customcard
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_customcard`;
CREATE TABLE `ims_yzkm_sun_customcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '首页会员卡自定义表 id',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_duration
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_duration`;
CREATE TABLE `ims_yzkm_sun_duration` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '入驻期限id',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `money` decimal(20,2) DEFAULT NULL,
  `duration` int(20) DEFAULT NULL COMMENT '入驻期限名称',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_goods`;
CREATE TABLE `ims_yzkm_sun_goods` (
  `gid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品表',
  `cid` int(11) DEFAULT NULL COMMENT '商品类型(和selecttype表关联)',
  `sid` int(11) NOT NULL COMMENT '商家id',
  `uniacid` int(11) DEFAULT NULL,
  `gname` varchar(45) CHARACTER SET gbk NOT NULL COMMENT '商品名称',
  `marketprice` decimal(10,2) DEFAULT NULL COMMENT '商品原价',
  `shopprice` decimal(10,2) NOT NULL COMMENT '商品售价',
  `selftime` datetime NOT NULL COMMENT '加入时间',
  `pic` varchar(200) CHARACTER SET gbk NOT NULL COMMENT '封面图',
  `probably` text CHARACTER SET gbk NOT NULL COMMENT '商品简介',
  `status` int(11) DEFAULT '1' COMMENT '1 未通过 2已通过商品状态 3已拒绝',
  `content` text CHARACTER SET gbk NOT NULL COMMENT '商品详情',
  `freight` varchar(11) DEFAULT '0' COMMENT '运费',
  `inventory` int(11) DEFAULT '0' COMMENT '库存',
  `salesvolume` int(11) DEFAULT '0' COMMENT '销量',
  `specifications_id` int(11) DEFAULT NULL COMMENT '商品规格ID',
  `yhnc_name` varchar(32) DEFAULT NULL COMMENT '用户下单时的昵称',
  `yhdz_addr` varchar(255) DEFAULT NULL COMMENT '用户下单时的地址',
  `messages` varchar(255) DEFAULT NULL COMMENT '买家留言',
  `banner` text,
  PRIMARY KEY (`gid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='点击 ';

-- ----------------------------
-- Table structure for ims_yzkm_sun_goodsdetails
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_goodsdetails`;
CREATE TABLE `ims_yzkm_sun_goodsdetails` (
  `id` int(11) NOT NULL DEFAULT '0',
  `images` text NOT NULL COMMENT '商品详情表',
  `intro` text,
  `service` text,
  `gid` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_goodslist
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_goodslist`;
CREATE TABLE `ims_yzkm_sun_goodslist` (
  `glid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品列表',
  `glnumber` text NOT NULL,
  `inventory` varchar(45) NOT NULL,
  `combine` text NOT NULL,
  `goodsId` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`glid`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_in
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_in`;
CREATE TABLE `ims_yzkm_sun_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  `state` varchar(11) DEFAULT NULL,
  `num` varchar(11) DEFAULT NULL,
  `money` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_kanjia
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_kanjia`;
CREATE TABLE `ims_yzkm_sun_kanjia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL,
  `kid` int(11) DEFAULT NULL,
  `mch_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `kanjia` decimal(11,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_kanjia_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_kanjia_banner`;
CREATE TABLE `ims_yzkm_sun_kanjia_banner` (
  `id` int(11) unsigned NOT NULL COMMENT '用户id',
  `name` varchar(200) DEFAULT NULL COMMENT '商品id',
  `url` varchar(500) DEFAULT NULL COMMENT '商品数量',
  `img` varchar(500) DEFAULT NULL COMMENT '商品规格',
  `name1` varchar(200) DEFAULT NULL COMMENT '商品名称',
  `name2` varchar(200) DEFAULT NULL,
  `name3` varchar(200) DEFAULT NULL,
  `url1` varchar(300) DEFAULT NULL,
  `url2` varchar(300) DEFAULT NULL,
  `url3` varchar(300) DEFAULT NULL,
  `img1` varchar(500) DEFAULT NULL,
  `img2` varchar(500) DEFAULT NULL,
  `img3` varchar(500) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_member
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_member`;
CREATE TABLE `ims_yzkm_sun_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '首页会员卡id',
  `img` varchar(255) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `name_card` varchar(100) DEFAULT NULL COMMENT '会员卡名字',
  `uniacid` int(11) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL COMMENT '会员卡号码',
  `discount` varchar(11) DEFAULT NULL COMMENT '会员折扣',
  `day_yxq` varchar(10) DEFAULT NULL COMMENT '有效期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_notice
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_notice`;
CREATE TABLE `ims_yzkm_sun_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家入驻须知表 id',
  `notice` text,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_order`;
CREATE TABLE `ims_yzkm_sun_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `orderNumber` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `phone` varchar(100) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL COMMENT '下单金额',
  `state` varchar(255) DEFAULT '2' COMMENT '1 取消订单，2未支付，3已支付/待发货，4已发货，5交易成功',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '下单时间',
  `userId` int(11) DEFAULT NULL COMMENT '用户id',
  `userName` varchar(20) DEFAULT NULL COMMENT '用户名字',
  `goodsId` int(11) DEFAULT NULL COMMENT '订单id',
  `addr` varchar(100) DEFAULT NULL COMMENT '地址',
  `uniacid` int(11) DEFAULT NULL,
  `guige` varchar(100) DEFAULT NULL COMMENT '订单规格',
  `buynum` int(11) DEFAULT NULL COMMENT '购买数量',
  `message` varchar(100) DEFAULT NULL COMMENT 's留言',
  `buy_type` int(2) DEFAULT NULL COMMENT '0快递1到店取货',
  `pay_time` int(11) DEFAULT NULL COMMENT '付款时间',
  `comfirm_time` int(11) DEFAULT NULL COMMENT '确认收货时间',
  `user_del` int(2) DEFAULT '1' COMMENT '1未删除2已删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_orderlist
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_orderlist`;
CREATE TABLE `ims_yzkm_sun_orderlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `num` int(12) NOT NULL COMMENT '数量',
  `gid` int(11) DEFAULT NULL COMMENT '商品id',
  `isPay` tinyint(3) unsigned DEFAULT '0' COMMENT '是否已付款（0:未付款 1:付款）',
  `cid` int(10) DEFAULT NULL COMMENT '使用使用优惠券（0:未使用 int 用户优惠券ID）',
  `payType` tinyint(4) unsigned DEFAULT '0' COMMENT '支付类型（0:微信支付 1:余额支付 2:在线充值）',
  `createTime` timestamp NULL DEFAULT NULL,
  `present_coupon` int(10) unsigned DEFAULT NULL COMMENT '支付赠送优惠券',
  `present_integral` int(10) unsigned DEFAULT NULL COMMENT '支付赠送积分',
  `present_balance` int(11) DEFAULT NULL COMMENT '支付赠送余额',
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL COMMENT '订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_popbanner
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_popbanner`;
CREATE TABLE `ims_yzkm_sun_popbanner` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pop_title` varchar(50) NOT NULL COMMENT '弹窗名称',
  `pop_urltype` tinyint(2) NOT NULL DEFAULT '1' COMMENT '弹窗链接类别',
  `pop_urltxt` int(11) NOT NULL COMMENT '相关 id',
  `pop_img` varchar(200) NOT NULL COMMENT '弹窗图',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_post
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_post`;
CREATE TABLE `ims_yzkm_sun_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `post_name` varchar(20) DEFAULT NULL COMMENT '帖子类别名称',
  `post_img` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '1' COMMENT '1 启用（）2禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_praise
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_praise`;
CREATE TABLE `ims_yzkm_sun_praise` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '点赞表',
  `uniacid` int(11) DEFAULT NULL,
  `zx_id` int(11) DEFAULT NULL COMMENT '圈子id',
  `openid` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_releaseneeds
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_releaseneeds`;
CREATE TABLE `ims_yzkm_sun_releaseneeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '发布须知表',
  `uniacid` int(11) DEFAULT NULL,
  `releaseneeds` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_selected
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_selected`;
CREATE TABLE `ims_yzkm_sun_selected` (
  `seid` int(11) NOT NULL AUTO_INCREMENT,
  `sele_name` varchar(255) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `video` text,
  `content` text,
  `detele` int(11) DEFAULT '1',
  `prob` text,
  `time` varchar(100) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `ac_id` int(11) DEFAULT NULL,
  `news` int(11) DEFAULT NULL,
  `selected` int(11) DEFAULT NULL,
  `index` int(11) DEFAULT NULL,
  PRIMARY KEY (`seid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_selectedtype
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_selectedtype`;
CREATE TABLE `ims_yzkm_sun_selectedtype` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT '行业类型表(商家分类表)',
  `tname` varchar(45) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sort` int(11) DEFAULT '1',
  `img` varchar(500) DEFAULT NULL,
  `type` varchar(20) DEFAULT '1' COMMENT '1 启用（）2禁用',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_setting
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_setting`;
CREATE TABLE `ims_yzkm_sun_setting` (
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
-- Table structure for ims_yzkm_sun_sms
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_sms`;
CREATE TABLE `ims_yzkm_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '模板消息 模板编号表id',
  `uniacid` int(11) DEFAULT NULL,
  `template_order` varchar(50) DEFAULT NULL COMMENT '订单模板消息  模板编号',
  `template_withdrawal` varchar(50) DEFAULT NULL COMMENT '商家入驻模板消息   模板编号',
  `template_member` varchar(50) DEFAULT NULL COMMENT '会员卡模板消息   模板编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_specifications
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_specifications`;
CREATE TABLE `ims_yzkm_sun_specifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品规格ID',
  `uniacid` int(11) DEFAULT NULL,
  `gg_name` varchar(20) DEFAULT NULL COMMENT '规格名',
  `gg_class` varchar(255) DEFAULT NULL COMMENT '规格类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_store
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_store`;
CREATE TABLE `ims_yzkm_sun_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL COMMENT '返回的入驻天数',
  `user_id` int(11) DEFAULT NULL,
  `store_name` varchar(32) DEFAULT NULL,
  `storetype_id` varchar(20) NOT NULL COMMENT '行业分类',
  `phone` decimal(32,0) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL COMMENT '商家详情图片',
  `banner` varchar(2000) DEFAULT NULL COMMENT '商家轮播图',
  `status` varchar(11) DEFAULT '1' COMMENT '1 待审核  2 已通过  3 已拒绝',
  `addr` varchar(255) DEFAULT NULL,
  `coordinate` varchar(30) DEFAULT NULL COMMENT '坐标',
  `logo` varchar(255) NOT NULL COMMENT '商家logo',
  `ewm_logo` varchar(255) DEFAULT NULL COMMENT '商家二维码',
  `weixin_logo` varchar(255) DEFAULT NULL COMMENT '老板微信',
  `start_time` varchar(20) DEFAULT NULL COMMENT '开业时间',
  `end_time` varchar(20) DEFAULT NULL COMMENT '关门时间',
  `keyword` varchar(255) DEFAULT NULL COMMENT '关键字',
  `views` int(20) DEFAULT '0' COMMENT '人气数',
  `skzf` varchar(255) DEFAULT '0' COMMENT ' 0 为选择 1选中 刷卡支付',
  `wifi` varchar(20) DEFAULT '0' COMMENT ' 0 为选择 1选中 wifi',
  `mftc` varchar(20) DEFAULT '0' COMMENT ' 0 为选择 1选中 免费停车',
  `jzxy` varchar(20) DEFAULT '0' COMMENT ' 0 为选择 1选中 禁止吸烟',
  `tgbj` varchar(20) DEFAULT '0' COMMENT ' 0 为选择 1选中 提供包间',
  `sfxx` varchar(20) DEFAULT '0' COMMENT ' 0 为选择 1选中 沙发休闲',
  `details` varchar(255) DEFAULT NULL COMMENT '商家简介',
  `vr_link` varchar(255) DEFAULT NULL COMMENT '小程序设置的域名',
  `open_time` datetime DEFAULT NULL,
  `over_time` datetime DEFAULT NULL,
  `city` varchar(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `ad` varchar(255) DEFAULT NULL COMMENT '轮播图',
  `num` varchar(20) DEFAULT NULL,
  `money` varchar(30) DEFAULT NULL,
  `is_top` varchar(30) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `pwd` varchar(30) DEFAULT NULL,
  `averagePrice` int(11) DEFAULT NULL COMMENT '平均价格',
  `score` int(11) DEFAULT '0' COMMENT '商家评分',
  `collect` int(11) DEFAULT NULL,
  `day_rz` int(11) DEFAULT NULL COMMENT '入驻期限关联id',
  `time_ss` decimal(10,2) DEFAULT '0.00' COMMENT '商家余额',
  `balance` decimal(10,2) DEFAULT '0.00' COMMENT '商家余额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_storetype
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_storetype`;
CREATE TABLE `ims_yzkm_sun_storetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `num` varchar(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_system`;
CREATE TABLE `ims_yzkm_sun_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cheatTrial` int(11) DEFAULT '2' COMMENT '1开启骗审页面 2关闭骗审页面',
  `is_zx_sh` int(11) DEFAULT '1' COMMENT '1 隐藏前端发布按钮  2 显示前端发布按钮   废弃',
  `is_zx` varchar(100) DEFAULT NULL COMMENT '1状态开启 2状态关闭  判断是否需要通过审核才能发布  或者可以直接发布',
  `sj_audit` int(11) DEFAULT NULL COMMENT '商家审核1.是 2否',
  `tz_audit` int(11) DEFAULT NULL COMMENT '帖子审核1.是 2否',
  `pt_name` varchar(100) DEFAULT NULL COMMENT '首页头部名称',
  `is_open_pop` int(2) DEFAULT '0' COMMENT '1开 0关  首页弹窗开启关闭状态',
  `appid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appid',
  `appsecret` varchar(200) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appsecret',
  `mchid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户号',
  `wxkey` varchar(250) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户秘钥',
  `uniacid` int(11) DEFAULT NULL,
  `url_name` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '网址名称',
  `details` text COMMENT '关于我们',
  `url_logo` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '网址logo',
  `bq_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL COMMENT '版权名称',
  `link_name` varchar(30) DEFAULT NULL COMMENT '网站名称',
  `link_logo` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '网站logo',
  `support` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '技术支持',
  `support_font` varchar(45) DEFAULT NULL COMMENT '计数支持 文字',
  `support_tel` varchar(20) DEFAULT NULL COMMENT '计数支持 电话',
  `support_logo` varchar(255) DEFAULT NULL COMMENT '计数支持 图片',
  `bq_logo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `color` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '商家字体颜色  1白色 2黑色',
  `color_val` varchar(10) DEFAULT '2' COMMENT '商家字体颜色 所对应的值 1白色 默认黑色',
  `tz_appid` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `tz_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `cityname` varchar(20) DEFAULT NULL,
  `mail` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `client_ip` varchar(100) DEFAULT NULL,
  `apiclient_key` varchar(100) DEFAULT NULL,
  `apiclient_cert` varchar(100) DEFAULT NULL,
  `fontcolor` varchar(100) DEFAULT NULL,
  `timeStamp` datetime DEFAULT NULL,
  `nonce_str` varchar(100) DEFAULT NULL,
  `tx_open` int(11) DEFAULT NULL COMMENT '提现开关',
  `commission_cost` varchar(11) DEFAULT NULL COMMENT '佣金比率',
  `tx_mode` int(11) DEFAULT NULL COMMENT '提现方式  手动 自动',
  `tx_type` int(11) DEFAULT NULL COMMENT '提现支持  微信 支付宝  银联',
  `tx_money` decimal(10,2) DEFAULT NULL COMMENT '最低提现金额',
  `tx_sxf` varchar(11) DEFAULT NULL COMMENT '提现费率',
  `tx_details` varchar(255) DEFAULT NULL COMMENT '提现须知',
  `qqkey` varchar(50) NOT NULL DEFAULT '0' COMMENT '腾讯地图key',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_user`;
CREATE TABLE `ims_yzkm_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `openid` varchar(100) DEFAULT NULL COMMENT 'openid',
  `img` varchar(200) DEFAULT NULL COMMENT '头像',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登录时间',
  `uniacid` int(11) DEFAULT NULL,
  `money` decimal(11,2) DEFAULT '0.00',
  `commission` decimal(11,0) DEFAULT NULL,
  `state` int(4) DEFAULT '1' COMMENT '1普通会员 2办卡会员',
  `attention` varchar(255) DEFAULT NULL,
  `fans` varchar(255) DEFAULT NULL,
  `collection` varchar(255) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `addrId` int(11) DEFAULT NULL,
  `member_statu` int(11) DEFAULT '1' COMMENT '会员状态  1是普通用户 2 会员',
  `day_ts` varchar(10) DEFAULT NULL COMMENT '买卡天数',
  `user_tel` varchar(11) DEFAULT NULL,
  `user_addr` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=851 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_user_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_user_coupon`;
CREATE TABLE `ims_yzkm_sun_user_coupon` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_user_vipcard
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_user_vipcard`;
CREATE TABLE `ims_yzkm_sun_user_vipcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员列表 id',
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '会员的用户id',
  `user_openid` varchar(30) DEFAULT NULL COMMENT '会员 openid',
  `card_number` varchar(30) DEFAULT NULL COMMENT '会员 卡号',
  `buy_time` datetime DEFAULT NULL COMMENT '购买时间',
  `dq_time` datetime DEFAULT NULL COMMENT '到期时间',
  `status` int(11) DEFAULT '0' COMMENT '会员卡状态 0 使用中 1 已到期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_vip
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_vip`;
CREATE TABLE `ims_yzkm_sun_vip` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员卡 表',
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '会员卡状态 1已开启 2未开启',
  `title` varchar(30) DEFAULT NULL COMMENT '会员卡类型名称',
  `price` decimal(10,2) DEFAULT NULL COMMENT '会员卡价格',
  `day` varchar(11) DEFAULT NULL COMMENT '会员卡有效期',
  `time` datetime DEFAULT NULL COMMENT '发布时间',
  `prefix` varchar(20) DEFAULT NULL COMMENT '激活码前缀',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_vipcard
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_vipcard`;
CREATE TABLE `ims_yzkm_sun_vipcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员卡 id',
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL COMMENT '会员卡名称',
  `price` int(11) DEFAULT '1' COMMENT '会员卡开启关闭状态  1开启 2关闭',
  `discount` varchar(11) DEFAULT NULL COMMENT '会员卡折扣',
  `img` varchar(255) DEFAULT NULL COMMENT '会员卡图片',
  `desc` text COMMENT '会员卡规则',
  `card_number` varchar(30) DEFAULT NULL COMMENT '会员卡  卡号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_vipcode
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_vipcode`;
CREATE TABLE `ims_yzkm_sun_vipcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL COMMENT '会员卡激活码表',
  `vipid` int(11) DEFAULT NULL COMMENT '会员卡id',
  `vc_code` varchar(30) DEFAULT NULL COMMENT '会员卡 激活码',
  `vc_starttime` datetime DEFAULT NULL COMMENT '会员卡激活时间',
  `vc_endtime` datetime DEFAULT NULL COMMENT '会员卡结束激活时间',
  `vc_isuse` int(11) DEFAULT '1' COMMENT '激活码使用状态 1未使用  2 使用中',
  `openid` varchar(30) DEFAULT '0' COMMENT '使用者的 openid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_withdrawal
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_withdrawal`;
CREATE TABLE `ims_yzkm_sun_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `putmoney` decimal(10,2) DEFAULT NULL COMMENT '提现金额',
  `actual_money` decimal(10,2) DEFAULT NULL COMMENT '实际金额',
  `username` varchar(20) DEFAULT NULL COMMENT '提现时自己输入的名字  暂时无用',
  `accountnumber` varchar(20) DEFAULT NULL COMMENT '提现时用户自己输入的 微信号   暂时无用',
  `openid` varchar(20) DEFAULT NULL COMMENT '提现需要',
  `user_id` int(10) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL COMMENT '申请提现时间',
  `time1` datetime DEFAULT NULL COMMENT '提现时间',
  `status` int(11) DEFAULT '1' COMMENT '提现状态  1待审核 2 已通过 3 已拒绝',
  `type` int(11) DEFAULT '2' COMMENT '提现方式  1支付宝 2 微信 3 银联',
  `template_order` varchar(50) DEFAULT NULL COMMENT '订单模板消息  模板编号',
  `template_withdrawal` varchar(50) DEFAULT NULL COMMENT '商家入驻模板消息   模板编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_zx
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_zx`;
CREATE TABLE `ims_yzkm_sun_zx` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户文章发布表',
  `uniacid` int(11) DEFAULT NULL COMMENT '圈子（文章）发布表',
  `userId` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sele_name` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL COMMENT '用户当前位置',
  `content` text COMMENT '发布内容',
  `img` varchar(255) DEFAULT NULL COMMENT '发布图片',
  `tel` varchar(20) DEFAULT NULL COMMENT '发布人联系方式',
  `longitude` varchar(30) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(30) DEFAULT NULL COMMENT '纬度',
  `browse` int(11) DEFAULT '0' COMMENT '浏览量',
  `praise` int(11) DEFAULT '0' COMMENT '点赞数量',
  `number` int(11) DEFAULT '0' COMMENT '评论数量',
  `state` int(11) DEFAULT '1' COMMENT '1待审核 2审核已通过   3审核未通过',
  `dele_sta` int(11) DEFAULT '1' COMMENT '1 未删除状态  2已删除状态',
  `time_ss` varchar(30) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL COMMENT '帖子类别id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_yzkm_sun_zx_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzkm_sun_zx_type`;
CREATE TABLE `ims_yzkm_sun_zx_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章类型表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
