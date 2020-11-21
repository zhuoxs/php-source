/*
Navicat MySQL Data Transfer

Source Server         : www_qiannaisi_com
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : www_qiannaisi_com

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-02-17 19:32:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_yzfc_sun_admin
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_admin`;
CREATE TABLE `ims_yzfc_sun_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `psw` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `auth` tinyint(1) DEFAULT '1' COMMENT '1.超级管理员',
  `bid` int(11) DEFAULT '0' COMMENT '分店id',
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `token` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='管理员账号表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_adpic
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_adpic`;
CREATE TABLE `ims_yzfc_sun_adpic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_type` tinyint(1) DEFAULT '0' COMMENT '0.不跳转1.课程2课间3集卡',
  `link_typeid` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `ad_pic` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `title` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='首页弹窗广告';

-- ----------------------------
-- Table structure for ims_yzfc_sun_banner
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_banner`;
CREATE TABLE `ims_yzfc_sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(100) DEFAULT NULL COMMENT '轮播名称',
  `url` varchar(300) DEFAULT NULL COMMENT '轮播链接',
  `lb_imgs` varchar(500) DEFAULT NULL COMMENT '首页轮播图片',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='首页轮播表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_branch
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_branch`;
CREATE TABLE `ims_yzfc_sun_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` varchar(120) CHARACTER SET utf8 DEFAULT NULL COMMENT '图片',
  `name` varchar(100) NOT NULL COMMENT '名称',
  `tel` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `lat` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `lng` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `selftime` datetime DEFAULT NULL COMMENT '存入时间',
  `uniacid` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='分店表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_card
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_card`;
CREATE TABLE `ims_yzfc_sun_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '大标题',
  `title_small` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '小标题',
  `img_cover` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '封面图',
  `img` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '轮播',
  `rule` text COLLATE utf8mb4_bin COMMENT '活动规则',
  `prize_details` text COLLATE utf8mb4_bin COMMENT '奖品详情',
  `drawtimes` int(11) DEFAULT '0' COMMENT '抽奖次数',
  `helptimes` int(11) DEFAULT '0' COMMENT '求助次数',
  `prizenum` int(11) DEFAULT '0' COMMENT '奖品总数',
  `joinnum` int(11) DEFAULT '0' COMMENT '参与数量',
  `joinnum_xn` int(11) DEFAULT '0' COMMENT '虚拟参与数量',
  `winnum` int(11) DEFAULT '0' COMMENT '获奖人数',
  `winnum_xn` int(11) DEFAULT '0' COMMENT '虚拟获奖人数',
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `check_color_one` varchar(20) COLLATE utf8mb4_bin DEFAULT '#f2f2f2' COMMENT '获奖前',
  `check_color_two` varchar(20) COLLATE utf8mb4_bin DEFAULT '#48bcff' COMMENT '获奖后',
  `uniacid` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `prizename` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '奖品名称',
  `prizetype` tinyint(1) DEFAULT '1' COMMENT '1.到店2.物流 3二者都可以',
  `branch` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '参与分店',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='集卡表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_card_font
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_card_font`;
CREATE TABLE `ims_yzfc_sun_card_font` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL COMMENT '集卡id',
  `font` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '图片',
  `chance` int(5) DEFAULT '0' COMMENT '概率',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='集卡图片表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_card_getlog
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_card_getlog`;
CREATE TABLE `ims_yzfc_sun_card_getlog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT NULL COMMENT '文字id',
  `cid` int(11) DEFAULT NULL COMMENT '集卡id',
  `createtime` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='集卡抽奖记录';

-- ----------------------------
-- Table structure for ims_yzfc_sun_card_help
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_card_help`;
CREATE TABLE `ims_yzfc_sun_card_help` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='集卡分享记录表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_card_prizelog
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_card_prizelog`;
CREATE TABLE `ims_yzfc_sun_card_prizelog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1.自取 2快递',
  `username` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '微信名',
  `address` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `headurl` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `tel` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '领奖时的姓名',
  `ordernum` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0.删除订单',
  `sid` int(11) DEFAULT '0',
  `qrcode` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '核销码',
  `isuse` tinyint(1) DEFAULT '0' COMMENT '1.已核销',
  `usetime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '核销时间',
  `logistics` tinyint(1) DEFAULT '1' COMMENT '1.未发货 2.已发货 3.已收货',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='集卡领奖记录表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_find
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_find`;
CREATE TABLE `ims_yzfc_sun_find` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `headurl` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `img` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `content` text COLLATE utf8mb4_bin,
  `readnum` int(11) DEFAULT '0',
  `comnum` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `checks` tinyint(1) DEFAULT '1' COMMENT '1.已审核0.下架',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='发现表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_find_comment
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_find_comment`;
CREATE TABLE `ims_yzfc_sun_find_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `fid` int(11) DEFAULT NULL,
  `content` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `uniacid` int(11) DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `headurl` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='发现评论表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_findclassify
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_findclassify`;
CREATE TABLE `ims_yzfc_sun_findclassify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `sort` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  `imga` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '选中前图标',
  `imgb` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '选中后图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='发现分类表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_hothouse_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_hothouse_set`;
CREATE TABLE `ims_yzfc_sun_hothouse_set` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `img` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `info` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '导语',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='热销楼盘设置';

-- ----------------------------
-- Table structure for ims_yzfc_sun_house
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_house`;
CREATE TABLE `ims_yzfc_sun_house` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `address` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `lng` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `lat` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `sale_status` tinyint(1) DEFAULT '1' COMMENT '1.待售 2.在售 3.售罄',
  `icon` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL COMMENT '均价',
  `img` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '封面图',
  `banner` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `region` int(11) DEFAULT NULL COMMENT '区域',
  `tel` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `area` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '建筑面积',
  `info` text COLLATE utf8mb4_bin COMMENT '基本信息',
  `facilities` text COLLATE utf8mb4_bin COMMENT '周边设施',
  `opentime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '开盘日期',
  `hot` tinyint(1) DEFAULT '0' COMMENT '是否热销 1.是 0.否',
  `hot_sort` int(3) DEFAULT '0' COMMENT '热销排序 升序',
  `status` tinyint(1) DEFAULT '1',
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `rec` tinyint(1) DEFAULT '0' COMMENT '1.推荐到首页',
  `detail` text CHARACTER SET utf8 NOT NULL COMMENT '详情',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='房产表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_house_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_house_order`;
CREATE TABLE `ims_yzfc_sun_house_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `tel` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `room` int(2) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `ordertime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `contact` tinyint(1) DEFAULT '0' COMMENT '1.已联系',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='预约看房表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_housetype
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_housetype`;
CREATE TABLE `ims_yzfc_sun_housetype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hid` int(11) DEFAULT NULL COMMENT '楼盘id',
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `img` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `banner` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `area` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `totalmoney` decimal(10,2) DEFAULT NULL COMMENT '总价',
  `icon` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `info` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `room` int(5) DEFAULT '1' COMMENT '居室',
  `uniacid` int(11) DEFAULT NULL,
  `rec` tinyint(1) DEFAULT '0' COMMENT '1主力户型',
  `sale_status` tinyint(1) DEFAULT '1' COMMENT '1.待售 2.在售 3.售罄',
  `detail` text CHARACTER SET utf8 NOT NULL COMMENT '详情',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='房型表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_logoset
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_logoset`;
CREATE TABLE `ims_yzfc_sun_logoset` (
  `uniacid` int(11) NOT NULL,
  `logo_name_one` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_name_one` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_img_one` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_one` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_a` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '选中图标',
  `logo_name_two` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_name_two` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_img_two` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_two` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_b` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_name_three` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_name_three` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_img_three` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_three` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_c` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_name_four` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_name_four` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_img_four` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_four` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `nav_img_d` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `my_name_one` varchar(10) COLLATE utf8mb4_bin DEFAULT '我的课程',
  `my_img_one` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `my_name_two` varchar(10) COLLATE utf8mb4_bin DEFAULT '约课记录',
  `my_img_two` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `my_name_three` varchar(10) COLLATE utf8mb4_bin DEFAULT '授课老师',
  `my_img_three` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `my_name_four` varchar(10) COLLATE utf8mb4_bin DEFAULT '我的收藏',
  `my_img_four` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `my_name_five` varchar(10) COLLATE utf8mb4_bin DEFAULT '集卡奖品',
  `my_img_five` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `my_name_six` varchar(10) COLLATE utf8mb4_bin DEFAULT '管理入口',
  `my_img_six` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_name_five` varchar(10) COLLATE utf8mb4_bin DEFAULT '预约报名',
  `logo_img_five` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `logo_icon_five` varchar(10) COLLATE utf8mb4_bin DEFAULT '报名有礼',
  `logo_name_six` varchar(10) COLLATE utf8mb4_bin DEFAULT '集卡活动',
  `logo_img_six` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `card_img` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '集卡广告图',
  PRIMARY KEY (`uniacid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='营销功能图标设置表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_msg_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_msg_set`;
CREATE TABLE `ims_yzfc_sun_msg_set` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='短信配置表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_news`;
CREATE TABLE `ims_yzfc_sun_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL COMMENT '分类id',
  `title` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `content` text COLLATE utf8mb4_bin COMMENT '新闻内容',
  `createtime` int(11) DEFAULT NULL,
  `img` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '封面图',
  `uniacid` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `hid` int(11) DEFAULT '0' COMMENT '文中好房',
  `rec` tinyint(1) DEFAULT '0',
  `readnum` int(11) DEFAULT '0' COMMENT '阅读数',
  `author` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '作者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='资讯列表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_news_collect
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_news_collect`;
CREATE TABLE `ims_yzfc_sun_news_collect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='资讯收藏表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_newsclassify
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_newsclassify`;
CREATE TABLE `ims_yzfc_sun_newsclassify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `sort` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='资讯分类表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_question
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_question`;
CREATE TABLE `ims_yzfc_sun_question` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT '0',
  `question` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `answer` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `isshow` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `answertime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='房产问答表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_question_classify
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_question_classify`;
CREATE TABLE `ims_yzfc_sun_question_classify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `imga` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `imgb` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `sort` int(5) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='房产问答分类';

-- ----------------------------
-- Table structure for ims_yzfc_sun_region
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_region`;
CREATE TABLE `ims_yzfc_sun_region` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `sort` int(1) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='区域表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_system
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_system`;
CREATE TABLE `ims_yzfc_sun_system` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
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
  `token` varchar(300) DEFAULT NULL,
  `token_expires_in` int(11) DEFAULT NULL COMMENT 'token的过期时间',
  `sign_template_id` varchar(300) DEFAULT NULL COMMENT '报名成功模板消息',
  `card_template_id` varchar(300) DEFAULT NULL COMMENT '集卡模板id',
  `order_template_id` varchar(300) DEFAULT NULL COMMENT '预约成功模板id',
  `top_color` varchar(50) DEFAULT '#fff' COMMENT '顶部风格颜色',
  `top_font_color` varchar(50) DEFAULT '#000000' COMMENT '顶部字体颜色',
  `foot_color` varchar(50) DEFAULT '#ffffff' COMMENT '底部风格颜色',
  `foot_font_color_one` varchar(50) DEFAULT '#000000' COMMENT '底部文字选中前',
  `foot_font_color_two` varchar(50) DEFAULT '#005aff' COMMENT '底部文字选中后',
  `ht_logo` varchar(200) DEFAULT NULL COMMENT '后台顶部logo',
  `ht_title` varchar(100) DEFAULT NULL COMMENT '后台顶部标题名称',
  `top_title` varchar(50) DEFAULT '首页',
  `wechat_check` tinyint(1) DEFAULT '0' COMMENT '骗审开关 1.开启',
  `map_key` varchar(200) DEFAULT NULL COMMENT '腾讯地图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='系统设置表';

-- ----------------------------
-- Table structure for ims_yzfc_sun_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_user`;
CREATE TABLE `ims_yzfc_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq',
  `openid` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'openid',
  `headurl` varchar(200) DEFAULT NULL COMMENT '头像',
  `time` varchar(20) DEFAULT NULL COMMENT '创建时间',
  `uniacid` int(11) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `user_tel` int(11) DEFAULT NULL,
  `user_address` varchar(200) DEFAULT NULL,
  `isadmin` tinyint(1) DEFAULT '0' COMMENT '1.管理员',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1089 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ims_yzfc_sun_we
-- ----------------------------
DROP TABLE IF EXISTS `ims_yzfc_sun_we`;
CREATE TABLE `ims_yzfc_sun_we` (
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
  `qq` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='关于我们';
