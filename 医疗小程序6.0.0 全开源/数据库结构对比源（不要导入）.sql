/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-07-30 16:23:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_hyb_yl_address
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_address`;
CREATE TABLE `ims_hyb_yl_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL,
  `name` varchar(500) NOT NULL,
  `visible` tinyint(4) unsigned NOT NULL,
  `displayorder` tinyint(11) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `isShow` (`visible`),
  KEY `parentId` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=990101 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_addresshospitai
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_addresshospitai`;
CREATE TABLE `ims_hyb_yl_addresshospitai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  `par_id` int(11) NOT NULL COMMENT '父类ID',
  `lat` varchar(50) NOT NULL COMMENT '维度',
  `lng` varchar(50) NOT NULL COMMENT '经度',
  `hos_pic` varchar(255) NOT NULL,
  `hos_desc` text NOT NULL,
  `hos_tuijian` int(11) NOT NULL,
  `tijiaotime` int(11) NOT NULL,
  `hos_thumb` varchar(255) NOT NULL,
  `parentid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_adminusersite
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_adminusersite`;
CREATE TABLE `ims_hyb_yl_adminusersite` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `adusername` char(50) NOT NULL COMMENT '会员卡名称',
  `aduserdenqx` int(11) NOT NULL COMMENT '会员期限名称',
  `adusermoney` float(6,2) NOT NULL,
  `aduserzhekou` float(6,2) NOT NULL,
  `times` int(11) NOT NULL,
  `types` char(50) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_bace
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_bace`;
CREATE TABLE `ims_hyb_yl_bace` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `show_title` varchar(255) DEFAULT NULL,
  `show_thumb` longtext COMMENT '首页幻灯片1',
  `zx_thumb` varchar(255) DEFAULT NULL COMMENT '资讯幻灯片1',
  `yy_thumb` varchar(255) DEFAULT NULL COMMENT '医院简介图片',
  `yy_title` varchar(255) DEFAULT NULL COMMENT '医院简介标题',
  `yy_content` longtext COMMENT '医院简介内容',
  `latitude` varchar(255) DEFAULT NULL COMMENT '纬度',
  `longitude` varchar(255) DEFAULT NULL COMMENT '经度',
  `yy_address` varchar(255) DEFAULT NULL,
  `yy_telphone` varchar(255) DEFAULT NULL COMMENT '医院24小时服务电话',
  `bq_name` varchar(50) DEFAULT NULL COMMENT '版权名称',
  `bq_thumb` varchar(255) DEFAULT NULL COMMENT '版权图标',
  `bq_telphone` varchar(50) DEFAULT NULL COMMENT '版权联系电话',
  `tj_thumb` varchar(255) DEFAULT NULL COMMENT '体检中心宣传图',
  `tjl_thumb` varchar(255) DEFAULT NULL COMMENT '体检中心宣传链接图',
  `back_zjthumb` varchar(255) NOT NULL,
  `ztcolor` varchar(255) DEFAULT NULL,
  `blkcolor` varchar(255) DEFAULT NULL,
  `fwsite` longtext,
  `fwtim` int(11) NOT NULL,
  `tztim` int(11) NOT NULL,
  `jstime` int(11) NOT NULL,
  `pstatus` int(11) NOT NULL DEFAULT '0',
  `slide` longtext,
  `txxz` longtext NOT NULL,
  `zdtx` varchar(50) NOT NULL,
  `txsx` varchar(50) NOT NULL,
  `goodslunb` varchar(255) NOT NULL,
  `mberkg` int(11) NOT NULL DEFAULT '0' COMMENT '1开启会员注册0关闭会员注册',
  `zhciheng` varchar(255) NOT NULL,
  `back_thumb` varchar(255) DEFAULT NULL COMMENT '手术快约缩略图',
  `zuozdoc_thumb` varchar(255) DEFAULT NULL COMMENT '坐诊缩略图',
  `dianm_thumb` varchar(255) DEFAULT NULL COMMENT '点名缩略图',
  `baidukey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_baogaoinfo
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_baogaoinfo`;
CREATE TABLE `ims_hyb_yl_baogaoinfo` (
  `bg_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `info` longtext NOT NULL,
  `useropenid` varchar(255) NOT NULL,
  `fuleiid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '报告名称',
  `hzid` int(11) NOT NULL DEFAULT '0',
  `hospital` varchar(255) NOT NULL COMMENT '医院名字',
  `time` varchar(255) NOT NULL,
  `org_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_bingzheng
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_bingzheng`;
CREATE TABLE `ims_hyb_yl_bingzheng` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` longtext,
  `title_content` longtext,
  `keshi` varchar(255) DEFAULT NULL,
  `jibing` varchar(255) DEFAULT NULL,
  `jida` longtext,
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `us_name` varchar(50) DEFAULT NULL,
  `us_jhospital` varchar(50) DEFAULT NULL,
  `us_xhospital` varchar(50) DEFAULT NULL,
  `us_yibao` varchar(50) DEFAULT '0' COMMENT '医保 true：有医保；false没有医保',
  `us_openid` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `uptime` varchar(255) DEFAULT NULL,
  `doctorn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_bingzheng_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_bingzheng_type`;
CREATE TABLE `ims_hyb_yl_bingzheng_type` (
  `t_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_bkchat
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_bkchat`;
CREATE TABLE `ims_hyb_yl_bkchat` (
  `bk_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `tid` int(11) NOT NULL COMMENT '别人的',
  `fid` int(11) NOT NULL COMMENT '我的',
  `countime` int(11) NOT NULL,
  `overtime` int(11) NOT NULL,
  `bkstate` int(11) NOT NULL DEFAULT '0',
  `ttimes` varchar(50) NOT NULL,
  PRIMARY KEY (`bk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_button_daohang
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_button_daohang`;
CREATE TABLE `ims_hyb_yl_button_daohang` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `fw_title` char(255) DEFAULT NULL,
  `fw_title2` varchar(255) NOT NULL,
  `fw_thumb` varchar(255) NOT NULL COMMENT '联系电话图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_category
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_category`;
CREATE TABLE `ims_hyb_yl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目id',
  `uniacid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `icon` varchar(255) NOT NULL,
  `ksdesc` varchar(255) NOT NULL COMMENT '科室介绍',
  `ifkq` int(11) NOT NULL DEFAULT '1' COMMENT '是否开启自定义表单',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_chat_msg
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_chat_msg`;
CREATE TABLE `ims_hyb_yl_chat_msg` (
  `m_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `uniacid` int(10) DEFAULT NULL,
  `f_id` varchar(255) NOT NULL COMMENT '会员ID',
  `f_name` varchar(50) NOT NULL COMMENT '会员名',
  `f_ip` varchar(15) NOT NULL COMMENT '发自IP',
  `t_id` varchar(255) NOT NULL COMMENT '接收会员ID',
  `t_name` varchar(50) NOT NULL COMMENT '接收会员名',
  `t_msg` text NOT NULL COMMENT '消息内容',
  `r_state` tinyint(1) unsigned DEFAULT '2' COMMENT '状态:1为已读,2为未读,默认为2',
  `add_time` int(10) unsigned DEFAULT '0' COMMENT '添加时间',
  `docid` int(11) NOT NULL COMMENT '医生ID',
  `touxiang` varchar(255) NOT NULL,
  `is_img` varchar(255) NOT NULL,
  `endtime` int(11) NOT NULL COMMENT '结束时间',
  `if_over` int(11) NOT NULL DEFAULT '0' COMMENT '0未结束1结束',
  `typetext` int(11) NOT NULL DEFAULT '0' COMMENT '0普通文本；1图片;2图文结合',
  `kfid` int(11) NOT NULL DEFAULT '0' COMMENT '客服id',
  `ifkf` int(11) NOT NULL DEFAULT '0' COMMENT '是否是客服',
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COMMENT='消息表';

-- ----------------------------
-- Table structure for ims_hyb_yl_chat_msg_wz
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_chat_msg_wz`;
CREATE TABLE `ims_hyb_yl_chat_msg_wz` (
  `m_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `uniacid` int(10) DEFAULT NULL,
  `f_id` varchar(255) NOT NULL COMMENT '会员ID',
  `f_name` varchar(50) NOT NULL COMMENT '医生名称',
  `f_ip` varchar(15) NOT NULL,
  `f_ipic` text NOT NULL COMMENT '图片',
  `t_id` varchar(255) NOT NULL COMMENT '接收会员ID',
  `t_name` varchar(50) NOT NULL COMMENT '患者名称',
  `t_msg` text NOT NULL COMMENT '消息内容',
  `r_state` tinyint(1) unsigned DEFAULT '2' COMMENT '状态:1为已读,2为未读,默认为2',
  `add_time` int(10) unsigned DEFAULT '0' COMMENT '添加时间',
  `docid` int(11) NOT NULL COMMENT '医生ID',
  `touxiang` varchar(255) NOT NULL,
  `is_img` varchar(255) NOT NULL,
  `endtime` int(11) NOT NULL COMMENT '结束时间',
  `if_over` int(11) NOT NULL DEFAULT '0' COMMENT '0未结束1结束',
  `typetext` int(11) NOT NULL DEFAULT '0' COMMENT '0普通文本；1图片;2图文结合',
  `kfid` int(11) NOT NULL DEFAULT '0' COMMENT '客服id',
  `ifkf` int(11) NOT NULL DEFAULT '0' COMMENT '是否是客服',
  `firsts` int(11) NOT NULL DEFAULT '0' COMMENT '0首次1多次',
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='消息表';

-- ----------------------------
-- Table structure for ims_hyb_yl_collect
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_collect`;
CREATE TABLE `ims_hyb_yl_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `cerated_time` datetime NOT NULL,
  `cerated_type` int(10) NOT NULL COMMENT '关注的类型  0:专家；1:视频;2:患者点赞；3:咨询点赞;4:患者评论点赞;5:咨询评论点赞',
  `fenzuid` int(11) NOT NULL DEFAULT '0' COMMENT '分组ID',
  `beizhu` char(50) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `ifqianyue` int(11) NOT NULL DEFAULT '1' COMMENT '1签约中；2已同意；3已解约；4已取消;5拒绝',
  `jieyutext` varchar(255) NOT NULL COMMENT '解约原因',
  `change` int(11) NOT NULL COMMENT '是否开启档案',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_csaddress
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_csaddress`;
CREATE TABLE `ims_hyb_yl_csaddress` (
  `diz_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `dz_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`diz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_daohang
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_daohang`;
CREATE TABLE `ims_hyb_yl_daohang` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `thumb` varchar(255) DEFAULT NULL COMMENT '分类图标',
  `content_thumb` varchar(255) DEFAULT NULL COMMENT '分类内容图片',
  `content_title` varchar(255) DEFAULT NULL COMMENT '分类内容标题',
  `content` longtext COMMENT '分类内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_dianzanshare
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_dianzanshare`;
CREATE TABLE `ims_hyb_yl_dianzanshare` (
  `dz_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `types` int(11) NOT NULL DEFAULT '0' COMMENT '0用户端点赞1医生端点赞',
  PRIMARY KEY (`dz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_divms
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_divms`;
CREATE TABLE `ims_hyb_yl_divms` (
  `divid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) NOT NULL,
  `msg` longtext,
  `tims` varchar(255) NOT NULL,
  `doctitle` varchar(255) NOT NULL,
  `keshi` varchar(255) NOT NULL,
  PRIMARY KEY (`divid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_divmsg
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_divmsg`;
CREATE TABLE `ims_hyb_yl_divmsg` (
  `divid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) NOT NULL,
  `msg` longtext,
  `tims` varchar(255) NOT NULL,
  `doctitle` varchar(255) NOT NULL,
  `keshi` varchar(255) NOT NULL,
  PRIMARY KEY (`divid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_docpinglunsite
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_docpinglunsite`;
CREATE TABLE `ims_hyb_yl_docpinglunsite` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `fx_id` int(11) NOT NULL,
  `pl_text` text NOT NULL,
  `useropenid` varchar(255) NOT NULL COMMENT '用户',
  `usertoux` varchar(255) NOT NULL,
  `rtimeDay` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  PRIMARY KEY (`pl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_docquestion
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_docquestion`;
CREATE TABLE `ims_hyb_yl_docquestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `do_openid` varchar(255) DEFAULT NULL,
  `da` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_docshoushu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_docshoushu`;
CREATE TABLE `ims_hyb_yl_docshoushu` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sname` char(50) NOT NULL COMMENT '服务名称',
  `sthumb` text NOT NULL COMMENT '服务轮播图',
  `stype` char(50) NOT NULL,
  `stext` text NOT NULL COMMENT '服务介绍',
  `zid` int(11) DEFAULT NULL COMMENT '专家ID',
  `spic` text COMMENT '服务详情',
  `smoney` float(6,2) NOT NULL,
  `stime` text NOT NULL,
  `tjtime` int(11) NOT NULL,
  `skaig` int(11) NOT NULL DEFAULT '0' COMMENT '0开1关闭',
  `suoltu` varchar(255) NOT NULL COMMENT '缩略图',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_docshouyi
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_docshouyi`;
CREATE TABLE `ims_hyb_yl_docshouyi` (
  `sy_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `z_ids` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0图文资讯；1在线问诊；2预约；3发布问答；4处方;5电话',
  `symoney` float(6,2) NOT NULL,
  `username` char(50) NOT NULL COMMENT '用户名称',
  `funame` char(50) NOT NULL COMMENT '服务名称',
  `times` int(15) NOT NULL COMMENT '时间',
  `year` int(11) NOT NULL,
  PRIMARY KEY (`sy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_dozhuantime
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_dozhuantime`;
CREATE TABLE `ims_hyb_yl_dozhuantime` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL COMMENT '坐诊年',
  `day` varchar(50) NOT NULL COMMENT '上午；下午',
  `endTime` varchar(30) NOT NULL COMMENT '结束时间',
  `startTime` varchar(30) NOT NULL DEFAULT '0000-00-00' COMMENT '开始时间',
  `tijiatime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间 根据时间排序',
  `openid` varchar(255) NOT NULL,
  `pp_id` int(11) NOT NULL COMMENT '专家ID',
  `uniacid` int(11) DEFAULT NULL,
  `yyperson` varchar(50) NOT NULL COMMENT '预约名额',
  `sort_id` int(11) NOT NULL COMMENT '排序ID',
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_duanxin
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_duanxin`;
CREATE TABLE `ims_hyb_yl_duanxin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `key` varchar(50) DEFAULT NULL,
  `scret` varchar(50) DEFAULT NULL,
  `qianming` varchar(50) DEFAULT NULL,
  `moban_id` varchar(50) DEFAULT NULL,
  `templateid` varchar(50) DEFAULT NULL COMMENT '短信通知ID',
  `stadus` int(11) NOT NULL DEFAULT '0',
  `tel` varchar(50) DEFAULT NULL,
  `cfmb` varchar(255) NOT NULL,
  `zztz` varchar(255) NOT NULL COMMENT '转诊通知',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_duhospital
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_duhospital`;
CREATE TABLE `ims_hyb_yl_duhospital` (
  `dq_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `yname` varchar(255) DEFAULT NULL,
  `diz_id` int(11) NOT NULL DEFAULT '0' COMMENT '父类id',
  PRIMARY KEY (`dq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_dyj
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_dyj`;
CREATE TABLE `ims_hyb_yl_dyj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dyj_title` varchar(50) NOT NULL,
  `dyj_id` varchar(50) NOT NULL,
  `dyj_key` varchar(50) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `dyj_title2` varchar(50) NOT NULL,
  `dyj_id2` varchar(50) NOT NULL,
  `dyj_key2` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for ims_hyb_yl_email
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_email`;
CREATE TABLE `ims_hyb_yl_email` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `mailhost` varchar(255) DEFAULT NULL,
  `mailport` varchar(255) DEFAULT NULL,
  `mailhostname` varchar(255) DEFAULT NULL,
  `mailformname` varchar(255) DEFAULT NULL,
  `mailusername` varchar(255) DEFAULT NULL,
  `mailpassword` varchar(255) DEFAULT NULL,
  `mailsend` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_fenxfenl
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_fenxfenl`;
CREATE TABLE `ims_hyb_yl_fenxfenl` (
  `fxid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `fname` char(50) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '0不推荐1推荐',
  `spaixu` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fxid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_formdate
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_formdate`;
CREATE TABLE `ims_hyb_yl_formdate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `displaytype` varchar(3) NOT NULL,
  `content` text NOT NULL,
  `activityid` int(11) NOT NULL DEFAULT '0',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `essential` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fieldstype` varchar(32) NOT NULL,
  `lowStandard` varchar(255) NOT NULL,
  `highStandard` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_fuwu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_fuwu`;
CREATE TABLE `ims_hyb_yl_fuwu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `l_names` varchar(255) DEFAULT NULL COMMENT '服务内容1',
  `fuwu_name` varchar(255) DEFAULT NULL COMMENT '服务名称1',
  `fuwu_money` varchar(255) DEFAULT NULL COMMENT '服务名称1标题',
  `fuwu_thumb` varchar(255) DEFAULT NULL COMMENT '服务名称1图标',
  `webviewurl` varchar(255) DEFAULT NULL,
  `wxappid` varchar(255) DEFAULT NULL,
  `wxname` varchar(255) DEFAULT NULL,
  `check1` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_fuwu_lianjie
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_fuwu_lianjie`;
CREATE TABLE `ims_hyb_yl_fuwu_lianjie` (
  `l_id` int(10) NOT NULL AUTO_INCREMENT,
  `l_name` varchar(255) NOT NULL,
  `l_lianjie` varchar(255) NOT NULL,
  PRIMARY KEY (`l_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_fuwutime
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_fuwutime`;
CREATE TABLE `ims_hyb_yl_fuwutime` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `week` longtext COMMENT '周一',
  `zid` int(11) DEFAULT NULL COMMENT '医生ID',
  `time` varchar(255) DEFAULT NULL,
  `z_room` int(11) DEFAULT NULL COMMENT '科室ID',
  `z_yy_money` varchar(255) DEFAULT NULL COMMENT '价格',
  `syperson` varchar(255) DEFAULT NULL,
  `yyperson` varchar(255) DEFAULT NULL,
  `week1` longtext COMMENT '周二',
  `week2` longtext COMMENT '周三',
  `week3` longtext,
  `week4` longtext,
  `week5` longtext,
  `week6` longtext,
  `sid` int(11) NOT NULL DEFAULT '0' COMMENT '我的服务id',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_fuwuyuyuelist
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_fuwuyuyuelist`;
CREATE TABLE `ims_hyb_yl_fuwuyuyuelist` (
  `fu_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `zid` int(11) NOT NULL,
  `my_id` int(11) NOT NULL,
  `stype` char(50) NOT NULL,
  `tttime` varchar(50) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `week` varchar(255) NOT NULL,
  `z_yy_money` float(6,2) NOT NULL,
  `sid` int(11) NOT NULL,
  `orderid` char(50) NOT NULL,
  `zy_time` varchar(50) NOT NULL,
  `ifover` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_fwlxing
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_fwlxing`;
CREATE TABLE `ims_hyb_yl_fwlxing` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `fwname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_goodsarr
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_goodsarr`;
CREATE TABLE `ims_hyb_yl_goodsarr` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sname` char(50) NOT NULL COMMENT '商品名称',
  `spic` varchar(255) NOT NULL COMMENT '商品轮播图',
  `sthumb` varchar(255) NOT NULL COMMENT '商品缩略图',
  `scontent` text COMMENT '商品详情',
  `snum` int(11) NOT NULL COMMENT '商品总数',
  `syxs` int(11) NOT NULL COMMENT '商品已售',
  `sfuwu` char(50) NOT NULL COMMENT '商品服务',
  `smoney` float(6,2) NOT NULL,
  `sdescribe` varchar(255) NOT NULL COMMENT '商品描述',
  `parameterList` text NOT NULL COMMENT '商品参数',
  `spaixu` int(11) NOT NULL,
  `tuijian` int(11) NOT NULL DEFAULT '0',
  `ifground` int(11) NOT NULL DEFAULT '0' COMMENT '是否上架',
  `sfbtime` int(11) NOT NULL,
  `spfenlei` tinyint(11) NOT NULL COMMENT '商品分类',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_goodsemail
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_goodsemail`;
CREATE TABLE `ims_hyb_yl_goodsemail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `mailhost` varchar(255) DEFAULT NULL,
  `mailport` varchar(255) DEFAULT NULL,
  `mailhostname` varchar(255) DEFAULT NULL,
  `mailformname` varchar(255) DEFAULT NULL,
  `mailusername` varchar(255) DEFAULT NULL,
  `mailpassword` varchar(255) DEFAULT NULL,
  `mailsend` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_goodsfenl
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_goodsfenl`;
CREATE TABLE `ims_hyb_yl_goodsfenl` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `fenlname` char(50) NOT NULL,
  `fenlpic` varchar(255) NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_goodsinfo
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_goodsinfo`;
CREATE TABLE `ims_hyb_yl_goodsinfo` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `qid` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `money` varchar(50) DEFAULT NULL,
  `g_time` varchar(50) DEFAULT NULL,
  `pzid` int(11) NOT NULL COMMENT '医生ID',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_guatime
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_guatime`;
CREATE TABLE `ims_hyb_yl_guatime` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `week` longtext COMMENT '周一',
  `zid` int(11) DEFAULT NULL COMMENT '医生ID',
  `time` varchar(255) DEFAULT NULL,
  `z_room` int(11) DEFAULT NULL COMMENT '科室ID',
  `z_yy_money` varchar(255) DEFAULT NULL COMMENT '价格',
  `syperson` varchar(255) DEFAULT NULL,
  `yyperson` varchar(255) DEFAULT NULL,
  `week1` longtext COMMENT '周二',
  `week2` longtext COMMENT '周三',
  `week3` longtext,
  `week4` longtext,
  `week5` longtext,
  `week6` longtext,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_hjfenl
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_hjfenl`;
CREATE TABLE `ims_hyb_yl_hjfenl` (
  `hj_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `hj_name` varchar(255) NOT NULL DEFAULT '',
  `hj_color` varchar(255) NOT NULL,
  `sord` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_hjiaoerweima
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_hjiaoerweima`;
CREATE TABLE `ims_hyb_yl_hjiaoerweima` (
  `zz_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `zz_hos` int(11) NOT NULL,
  `zz_docname` char(50) NOT NULL,
  `zz_ksname` char(50) NOT NULL,
  `zz_shenbaor` char(50) NOT NULL,
  PRIMARY KEY (`zz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_hjiaosite
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_hjiaosite`;
CREATE TABLE `ims_hyb_yl_hjiaosite` (
  `h_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `h_title` varchar(255) DEFAULT NULL,
  `h_pic` varchar(255) DEFAULT NULL,
  `h_video` varchar(255) DEFAULT NULL,
  `h_type` int(11) NOT NULL DEFAULT '0' COMMENT '0平台1第三方链接',
  `h_admin` char(50) NOT NULL,
  `h_text` text NOT NULL,
  `h_dianzan` int(11) NOT NULL,
  `h_read` int(11) NOT NULL,
  `h_zhuanfa` int(11) NOT NULL,
  `h_tuijian` int(11) NOT NULL DEFAULT '0' COMMENT '1热门',
  `h_flname` int(11) NOT NULL,
  `sfbtime` int(11) NOT NULL,
  `h_leixing` int(11) NOT NULL DEFAULT '0' COMMENT '0平台1个人患教',
  `h_thumb` text NOT NULL,
  `zid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`h_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_huanjiaopingl
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_huanjiaopingl`;
CREATE TABLE `ims_hyb_yl_huanjiaopingl` (
  `hz_pid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `yisid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `name` char(50) NOT NULL,
  `touxiang` varchar(255) NOT NULL,
  `createTime` int(11) NOT NULL,
  `pingtext` text NOT NULL,
  `leixing` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hz_pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_huanzhe
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_huanzhe`;
CREATE TABLE `ims_hyb_yl_huanzhe` (
  `hz_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `hz_name` varchar(50) NOT NULL,
  `hz_thumb` varchar(255) NOT NULL,
  `hz_count` longtext NOT NULL,
  `hz_time` date NOT NULL DEFAULT '0000-00-00',
  `hz_type` varchar(50) NOT NULL DEFAULT '0' COMMENT '患者推荐1推荐；0不推荐',
  `hz_desction` varchar(50) NOT NULL,
  `hz_mp3` varchar(255) NOT NULL,
  `hz_zlks` int(10) DEFAULT NULL COMMENT '科室分类',
  `iflouc` int(10) NOT NULL DEFAULT '0' COMMENT '0第一楼层1第二楼层',
  `dianj` int(11) NOT NULL DEFAULT '0' COMMENT '阅读量',
  `sord` int(11) NOT NULL DEFAULT '0',
  `aliaut` varchar(255) DEFAULT NULL,
  `kiguan` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_hyzhucesite
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_hyzhucesite`;
CREATE TABLE `ims_hyb_yl_hyzhucesite` (
  `hy_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `hy_type` int(11) NOT NULL DEFAULT '0' COMMENT '会员注册开关0关闭1开启',
  PRIMARY KEY (`hy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_hzjcglb
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_hzjcglb`;
CREATE TABLE `ims_hyb_yl_hzjcglb` (
  `jcx_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `jxopenid` varchar(255) NOT NULL,
  `contents` longtext NOT NULL,
  `erjid` int(11) NOT NULL COMMENT '父类ID',
  `duox` int(11) NOT NULL DEFAULT '0',
  `xm_id` int(11) NOT NULL,
  PRIMARY KEY (`jcx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_item
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_item`;
CREATE TABLE `ims_hyb_yl_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `formid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `show` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`uniacid`),
  KEY `indx_formid` (`formid`),
  KEY `indx_show` (`show`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_jbzx
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_jbzx`;
CREATE TABLE `ims_hyb_yl_jbzx` (
  `jbwt_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `wt_content` longtext,
  `wt_age` varchar(50) DEFAULT NULL,
  `wt_sex` varchar(50) DEFAULT NULL,
  `wt_time` varchar(255) DEFAULT NULL,
  `wt_name` varchar(50) DEFAULT NULL,
  `wt_telphone` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `wt_thumb` varchar(255) DEFAULT NULL,
  `wt_hf_zhuanjia` varchar(50) DEFAULT NULL,
  `wt_hf_content` longtext,
  `wt_hf_type` varchar(50) DEFAULT NULL,
  `wt_money` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`jbwt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_jcjg
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_jcjg`;
CREATE TABLE `ims_hyb_yl_jcjg` (
  `jc_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `jc_name` char(50) NOT NULL,
  `jc_parentid` int(11) NOT NULL,
  `jc_jgtype` int(11) NOT NULL DEFAULT '0' COMMENT '0单选1输入框',
  `jc_danwei` varchar(255) NOT NULL COMMENT '单位',
  PRIMARY KEY (`jc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_jdcategory
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_jdcategory`;
CREATE TABLE `ims_hyb_yl_jdcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目id',
  `uniacid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `icon` varchar(255) NOT NULL,
  `ksdesc` varchar(255) NOT NULL COMMENT '科室介绍',
  `ifkq` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启自定义表单',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_jderj
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_jderj`;
CREATE TABLE `ims_hyb_yl_jderj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `formid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `show` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`uniacid`),
  KEY `indx_formid` (`formid`),
  KEY `indx_show` (`show`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_jdxm
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_jdxm`;
CREATE TABLE `ims_hyb_yl_jdxm` (
  `xm_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `p_id` int(11) NOT NULL COMMENT '分类ID',
  `xmname` char(50) NOT NULL,
  `jc_type` int(11) NOT NULL DEFAULT '0',
  `jc_jgtype` int(11) NOT NULL DEFAULT '0' COMMENT '0单选1输入框',
  PRIMARY KEY (`xm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_jfenl
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_jfenl`;
CREATE TABLE `ims_hyb_yl_jfenl` (
  `fl_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `j_name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `j_thumb` varchar(255) DEFAULT NULL COMMENT '分类图标',
  `cont_thumb` varchar(255) DEFAULT NULL COMMENT '分类内容图片',
  `cont_title` varchar(255) DEFAULT NULL COMMENT '分类内容标题',
  `cont` longtext COMMENT '分类内容',
  PRIMARY KEY (`fl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_jiandang
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_jiandang`;
CREATE TABLE `ims_hyb_yl_jiandang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `displaytype` varchar(3) NOT NULL,
  `content` text NOT NULL,
  `activityid` int(11) NOT NULL DEFAULT '0',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `essential` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fieldstype` varchar(32) NOT NULL,
  `lowStandard` varchar(255) NOT NULL,
  `highStandard` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_jiandangbaogaoinfo
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_jiandangbaogaoinfo`;
CREATE TABLE `ims_hyb_yl_jiandangbaogaoinfo` (
  `jd_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `info` longtext NOT NULL,
  `useropenid` varchar(255) NOT NULL,
  `fuleiid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '报告名称',
  `time` varchar(255) NOT NULL,
  `org_pic` longtext NOT NULL,
  `timearr` varchar(50) NOT NULL,
  `hosp` varchar(255) NOT NULL,
  `xctime` varchar(255) NOT NULL,
  `xmname` varchar(255) NOT NULL,
  `jcx_id` int(11) NOT NULL COMMENT 'erID',
  `multsel` int(11) NOT NULL,
  `erjid` int(11) DEFAULT NULL,
  PRIMARY KEY (`jd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_jianybaogao
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_jianybaogao`;
CREATE TABLE `ims_hyb_yl_jianybaogao` (
  `j_id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `thumbarr` varchar(255) DEFAULT NULL,
  `tiyiyuan` varchar(50) DEFAULT NULL,
  `timearr` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `picfengm` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`j_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_keshi
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_keshi`;
CREATE TABLE `ims_hyb_yl_keshi` (
  `k_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `k_name` varchar(255) DEFAULT NULL COMMENT '科室名称',
  PRIMARY KEY (`k_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_keshi_yuyue
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_keshi_yuyue`;
CREATE TABLE `ims_hyb_yl_keshi_yuyue` (
  `ky_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `ky_name` varchar(50) DEFAULT NULL COMMENT '患者名称',
  `ky_openid` varchar(255) DEFAULT NULL COMMENT '患者openid',
  `ky_telphone` varchar(50) DEFAULT NULL COMMENT '患者手机',
  `k_name` varchar(50) DEFAULT NULL COMMENT '科室名称',
  `ky_time` varchar(255) DEFAULT NULL COMMENT '预约时间',
  `ky_yibao` varchar(255) DEFAULT NULL COMMENT '订单号',
  `ky_sex` varchar(50) DEFAULT '1' COMMENT '默认是男 1：男； 0 女',
  `ky_zhenzhuang` longtext COMMENT '专家ID',
  `ky_doctor` varchar(50) NOT NULL COMMENT '就诊医生',
  `ky_hospital` varchar(50) DEFAULT NULL COMMENT '订单二维码',
  `ky_docmoney` varchar(50) NOT NULL DEFAULT '0' COMMENT '医生预约价格',
  `ky_hexiao` int(10) DEFAULT '0' COMMENT '0:未完成；1：已完成',
  PRIMARY KEY (`ky_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_lianmenghuiy
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_lianmenghuiy`;
CREATE TABLE `ims_hyb_yl_lianmenghuiy` (
  `hy_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `hy_title` varchar(255) NOT NULL,
  `hy_thumb` varchar(255) NOT NULL,
  `hy_time` varchar(255) NOT NULL,
  `hosid` int(11) NOT NULL,
  `hy_desc` text NOT NULL,
  `hy_admin` char(50) NOT NULL,
  PRIMARY KEY (`hy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_likaiguan
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_likaiguan`;
CREATE TABLE `ims_hyb_yl_likaiguan` (
  `l_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `liptype` int(11) NOT NULL,
  PRIMARY KEY (`l_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_lingquyouhuiq
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_lingquyouhuiq`;
CREATE TABLE `ims_hyb_yl_lingquyouhuiq` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `yh_id` int(11) NOT NULL COMMENT '优惠券id',
  `types` int(11) NOT NULL DEFAULT '0' COMMENT '0未使用；1已使用',
  `lqtimes` int(11) NOT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_lipei
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_lipei`;
CREATE TABLE `ims_hyb_yl_lipei` (
  `lpid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `cyname` varchar(255) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `date1` varchar(50) DEFAULT NULL,
  `date2` varchar(50) DEFAULT NULL,
  `name_0` varchar(255) DEFAULT NULL,
  `sex` varchar(50) DEFAULT NULL,
  `uerAge` varchar(50) NOT NULL,
  `uerName` varchar(50) NOT NULL,
  `uerPhone` varchar(20) DEFAULT NULL,
  `uerinfor` varchar(255) DEFAULT NULL,
  `userDay` varchar(255) DEFAULT NULL,
  `userHospital` varchar(255) DEFAULT NULL,
  `userMoney` varchar(255) DEFAULT NULL,
  `userTpye` varchar(255) DEFAULT NULL,
  `usershoushu` varchar(255) DEFAULT NULL,
  `userpic` longtext NOT NULL,
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`lpid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_mcoment
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_mcoment`;
CREATE TABLE `ims_hyb_yl_mcoment` (
  `m_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `m_openid` varchar(255) NOT NULL COMMENT '我的openid',
  `m_money` varchar(50) DEFAULT NULL COMMENT '我的付款',
  `kc_id` int(11) DEFAULT NULL COMMENT '课程ID',
  `m_comment` varchar(255) NOT NULL COMMENT '我的评论',
  `t_comment` varchar(255) NOT NULL COMMENT '讲师openid',
  `m_fenshu` int(10) NOT NULL COMMENT '我的评分：1好评；2中；3差',
  `m_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `m_img` varchar(255) DEFAULT NULL COMMENT '我的头像',
  `name` varchar(255) DEFAULT NULL,
  `m_tj` int(10) DEFAULT '0' COMMENT '视频 类型1收费；0免费',
  `m_type` int(10) NOT NULL COMMENT '1：课程；2：咨询；3：患者',
  `dianz` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_myinfors
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_myinfors`;
CREATE TABLE `ims_hyb_yl_myinfors` (
  `my_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '患者ID',
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL COMMENT '我的openid',
  `myage` varchar(50) NOT NULL COMMENT '我的年龄',
  `myphone` varchar(255) NOT NULL COMMENT '我的手机号',
  `myshengfen` varchar(255) NOT NULL COMMENT '我的身份证',
  `myyibao` varchar(255) NOT NULL COMMENT '我的医保',
  `myname` varchar(50) NOT NULL COMMENT '我的名字',
  `mycontent` varchar(255) NOT NULL COMMENT '病情描述',
  `mysex` varchar(255) NOT NULL,
  `mydatype` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`my_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_mymoney
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_mymoney`;
CREATE TABLE `ims_hyb_yl_mymoney` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '专家钱包id',
  `uniacid` int(10) NOT NULL,
  `use_openid` varchar(255) NOT NULL,
  `countmoney` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_myser
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_myser`;
CREATE TABLE `ims_hyb_yl_myser` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `s_names` varchar(255) DEFAULT NULL COMMENT '服务标识',
  `ser_name` varchar(255) DEFAULT NULL COMMENT '服务名称',
  `ser_money` varchar(255) DEFAULT NULL COMMENT '服务名称标题',
  `ser_thumb` varchar(255) DEFAULT NULL COMMENT '服务名称图标',
  `ser_lujing` varchar(255) NOT NULL,
  `ser_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_overquestion
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_overquestion`;
CREATE TABLE `ims_hyb_yl_overquestion` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `zid` int(11) DEFAULT NULL,
  `useropenid` varchar(255) DEFAULT NULL,
  `kid` int(11) DEFAULT NULL,
  `money` float(6,2) NOT NULL,
  `steta` int(11) DEFAULT NULL,
  `qid1` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_parameter
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_parameter`;
CREATE TABLE `ims_hyb_yl_parameter` (
  `p_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `appsecret` varchar(255) DEFAULT NULL,
  `mch_id` varchar(255) DEFAULT NULL,
  `appkey` varchar(255) DEFAULT NULL,
  `keypem` varchar(50) NOT NULL COMMENT 'apiclient_cert.pem',
  `upfile` varchar(50) NOT NULL COMMENT 'apiclient_key.pem',
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_pian
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_pian`;
CREATE TABLE `ims_hyb_yl_pian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `thumb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_pian_daohang
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_pian_daohang`;
CREATE TABLE `ims_hyb_yl_pian_daohang` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `lianjie` varchar(255) DEFAULT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_pinglunsite
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_pinglunsite`;
CREATE TABLE `ims_hyb_yl_pinglunsite` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `adminopenid` varchar(255) NOT NULL COMMENT '作者',
  `a_id` int(11) NOT NULL,
  `pl_text` text NOT NULL,
  `useropenid` varchar(255) NOT NULL COMMENT '用户',
  `types` int(11) NOT NULL COMMENT '0用户端1医生端',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `usertoux` varchar(255) NOT NULL,
  `pl_time` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  `author` int(255) NOT NULL,
  `replyType` char(50) NOT NULL,
  PRIMARY KEY (`pl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_putong
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_putong`;
CREATE TABLE `ims_hyb_yl_putong` (
  `pt_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `pt_name` varchar(255) DEFAULT NULL,
  `pt_sex` varchar(50) DEFAULT NULL,
  `pt_age` varchar(50) DEFAULT NULL,
  `pt_telphone` varchar(50) DEFAULT NULL,
  `pt_shenfenzheng` varchar(50) DEFAULT NULL,
  `pt_thumbs` varchar(255) DEFAULT NULL COMMENT '本人省份证照片',
  PRIMARY KEY (`pt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_qiniu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_qiniu`;
CREATE TABLE `ims_hyb_yl_qiniu` (
  `qn_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `qn_accesskey` longtext,
  `qn_secretkey` longtext,
  `qn_bucket` longtext,
  `qn_queuename` longtext,
  `qn_domain` longtext,
  PRIMARY KEY (`qn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_question
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_question`;
CREATE TABLE `ims_hyb_yl_question` (
  `qid` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `user_openid` varchar(255) NOT NULL COMMENT '用户的openid',
  `fromuser` varchar(255) DEFAULT NULL,
  `savant_openid` varchar(255) NOT NULL COMMENT '医生的openid',
  `question` varchar(255) NOT NULL COMMENT '患者的问题',
  `hd_question` longtext NOT NULL COMMENT '医生回答的问题',
  `user_picture` longtext COMMENT '用户上传的图片',
  `user_payment` float(6,2) NOT NULL COMMENT '用户付款',
  `sj_type` int(10) DEFAULT '0' COMMENT '问题是否公开，1公开，0不公开',
  `p_id` int(10) DEFAULT NULL COMMENT '医生id',
  `q_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `q_username` varchar(50) NOT NULL COMMENT '患者名',
  `q_thumb` varchar(255) NOT NULL COMMENT '患者头像',
  `q_dname` varchar(50) NOT NULL COMMENT '医生名称',
  `q_docthumb` varchar(255) NOT NULL COMMENT '医生头像',
  `q_zhiwei` varchar(50) DEFAULT NULL COMMENT '医生职位',
  `h_pic` int(10) NOT NULL DEFAULT '0' COMMENT '1小程序端；0平台',
  `q_category` int(10) NOT NULL COMMENT '分类ID',
  `q_type` int(11) NOT NULL DEFAULT '1' COMMENT '发布问题类型 0：平台发布；1：微信',
  `erweima` int(11) NOT NULL DEFAULT '1' COMMENT '发布问题类型 0:平台发布;1:微信',
  `if_over` int(11) NOT NULL DEFAULT '0',
  `dianji` int(11) NOT NULL DEFAULT '0',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `usertype` int(11) NOT NULL DEFAULT '0' COMMENT '0用户1医生',
  `gbmoney` float(6,2) NOT NULL,
  `yuedu` int(11) NOT NULL DEFAULT '0' COMMENT '0未答1已答',
  `tiwenlx` int(11) NOT NULL DEFAULT '0' COMMENT '0普通1付费',
  `tw_num` int(11) NOT NULL,
  `dttjtime` int(11) NOT NULL COMMENT '当天提交时间戳',
  PRIMARY KEY (`qid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_recipe
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_recipe`;
CREATE TABLE `ims_hyb_yl_recipe` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `userid` int(11) NOT NULL COMMENT '用户ID',
  `docid` int(11) NOT NULL COMMENT '医生id',
  `content` longtext COMMENT '处方',
  `dmoney` varchar(50) NOT NULL DEFAULT '0',
  `orderarr` varchar(255) NOT NULL COMMENT '订单号',
  `username` varchar(255) NOT NULL,
  `time` varchar(50) DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  `dxtz` int(11) NOT NULL DEFAULT '0' COMMENT '1已通知，0未通知',
  `types` int(11) NOT NULL COMMENT '1,挂号处方；0预约处方',
  `pic` longtext NOT NULL,
  `iftz` int(11) NOT NULL DEFAULT '0',
  `useropenid` varchar(255) NOT NULL COMMENT '患者openid',
  `address` varchar(255) NOT NULL,
  `ifxians` int(11) NOT NULL DEFAULT '0' COMMENT '0不显示1通知后显示处方',
  `cfzhenj` float(6,2) NOT NULL,
  `yjfs` int(11) NOT NULL DEFAULT '0',
  `nummoney` float(6,2) NOT NULL COMMENT '支付金额',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_schoolroom
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_schoolroom`;
CREATE TABLE `ims_hyb_yl_schoolroom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL COMMENT 'uniacid',
  `room_parentid` int(11) NOT NULL COMMENT '父类ID',
  `sroomtitle` varchar(50) NOT NULL COMMENT '课堂标题',
  `room_type` int(10) NOT NULL DEFAULT '0' COMMENT '课堂类型1收费；0免费',
  `room_money` varchar(50) NOT NULL DEFAULT '0' COMMENT '价格',
  `room_per` varchar(50) NOT NULL DEFAULT '0' COMMENT '总名额',
  `room_thumb` varchar(255) NOT NULL COMMENT '课堂缩略图',
  `room_liulan` varchar(255) NOT NULL DEFAULT '0' COMMENT '学习人数',
  `room_tj` int(50) NOT NULL COMMENT '推荐1推荐；0不推荐',
  `room_fl` varchar(50) NOT NULL COMMENT '房间分类',
  `room_video` varchar(255) NOT NULL,
  `room_desc` varchar(255) DEFAULT NULL COMMENT '课程描述',
  `room_teacher` varchar(50) NOT NULL COMMENT '讲师',
  `tea_pic` varchar(255) NOT NULL COMMENT '讲师头像',
  `tea_desc` varchar(255) NOT NULL,
  `demo` varchar(50) DEFAULT NULL COMMENT '视频时长',
  `iflouc` int(10) NOT NULL DEFAULT '0',
  `mp3` varchar(255) NOT NULL,
  `al_video` varchar(255) NOT NULL,
  `mp3m` varchar(255) NOT NULL,
  `spkg` int(11) NOT NULL DEFAULT '0' COMMENT '0阿里视频1自带上传',
  `kaiguan` int(11) NOT NULL DEFAULT '0' COMMENT '0开启视频开关1开启音频',
  `ypkg` int(11) NOT NULL DEFAULT '0' COMMENT '0开启音频开关1开启自带上传',
  `ymoney` varchar(50) NOT NULL DEFAULT '0',
  `sord` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_selfhelp
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_selfhelp`;
CREATE TABLE `ims_hyb_yl_selfhelp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目id',
  `uniacid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `icon` varchar(255) NOT NULL,
  `ksdesc` longtext NOT NULL COMMENT '科室介绍',
  `zname` varchar(255) NOT NULL,
  `zids` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_selfnotes
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_selfnotes`;
CREATE TABLE `ims_hyb_yl_selfnotes` (
  `sl_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL COMMENT '症状ID',
  `number` varchar(11) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_share
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_share`;
CREATE TABLE `ims_hyb_yl_share` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `sharepic` text NOT NULL,
  `contents` varchar(255) NOT NULL,
  `times` int(11) NOT NULL,
  `dianj` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_sharearr
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_sharearr`;
CREATE TABLE `ims_hyb_yl_sharearr` (
  `fx_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sharetitle` char(50) NOT NULL,
  `sharetext` text NOT NULL,
  `sharepic` text NOT NULL,
  `zid` int(11) NOT NULL,
  `dateTime` int(11) NOT NULL,
  `zan` int(11) NOT NULL DEFAULT '0',
  `fxid` int(11) NOT NULL COMMENT '科室ID',
  PRIMARY KEY (`fx_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_sharepl
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_sharepl`;
CREATE TABLE `ims_hyb_yl_sharepl` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `picurl` text NOT NULL,
  `rtimeDay` int(11) NOT NULL,
  `rcontent` text NOT NULL,
  `ruid` int(11) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_sorder
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_sorder`;
CREATE TABLE `ims_hyb_yl_sorder` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `uniacid` int(11) NOT NULL,
  `s_openid` varchar(255) DEFAULT NULL COMMENT '我的openid',
  `s_order` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `s_ormoney` varchar(50) NOT NULL COMMENT '订单价格',
  `s_pid` int(11) DEFAULT NULL COMMENT '课程ID',
  `s_type` int(10) NOT NULL COMMENT '1：收费；0：免费',
  `m_comment` longtext NOT NULL,
  `m_fenshu` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `m_img` varchar(255) DEFAULT NULL,
  `m_time` datetime DEFAULT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_teamment
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_teamment`;
CREATE TABLE `ims_hyb_yl_teamment` (
  `g_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` char(50) NOT NULL,
  `teamtext` text NOT NULL,
  `thumbarr` varchar(255) NOT NULL,
  `t_id` int(11) NOT NULL COMMENT '团队ID',
  `menttypes` int(11) NOT NULL COMMENT '0不置顶1置顶',
  `updateTime` int(11) NOT NULL,
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_tijian_taocan
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_tijian_taocan`;
CREATE TABLE `ims_hyb_yl_tijian_taocan` (
  `tt_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `tt_yiyuan` varchar(50) DEFAULT NULL COMMENT '体检医院名称',
  `tt_name` varchar(255) DEFAULT NULL COMMENT '体检套餐名称',
  `tt_type` varchar(255) DEFAULT NULL COMMENT '体检套餐类别',
  `tt_num` varchar(10) DEFAULT NULL COMMENT '体检套餐项目数',
  `tt_tongzhi` longtext COMMENT '体检套餐须知',
  `tt_money` varchar(50) DEFAULT NULL COMMENT '体检套餐价格',
  PRIMARY KEY (`tt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_tijian_taocan_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_tijian_taocan_type`;
CREATE TABLE `ims_hyb_yl_tijian_taocan_type` (
  `tjt_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT '体检套餐类别名称',
  `type_thumb` varchar(255) DEFAULT NULL COMMENT '体检套餐类别图标',
  `type_shijian` varchar(255) DEFAULT NULL COMMENT '适检人群',
  PRIMARY KEY (`tjt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_tijian_taocan_xiangmu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_tijian_taocan_xiangmu`;
CREATE TABLE `ims_hyb_yl_tijian_taocan_xiangmu` (
  `tm_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `tm_taocanname` varchar(50) DEFAULT NULL COMMENT '体检套餐名称',
  `tm_name` varchar(255) DEFAULT NULL COMMENT '体检套餐项目名称',
  `tm_miaoshu` text COMMENT '体检套餐项目描述',
  PRIMARY KEY (`tm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_tijian_yiyuan
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_tijian_yiyuan`;
CREATE TABLE `ims_hyb_yl_tijian_yiyuan` (
  `ty_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `ty_name` varchar(50) DEFAULT NULL COMMENT '体检医院名称',
  `ty_thumb` varchar(255) DEFAULT NULL COMMENT '体检医院头像/logo',
  `ty_dengji` varchar(50) DEFAULT NULL COMMENT '体检医院等级 ',
  `ty_address` varchar(255) DEFAULT NULL COMMENT '体检医院地址',
  `latitude` varchar(255) DEFAULT NULL COMMENT '纬度',
  `longitude` varchar(255) DEFAULT NULL COMMENT '经度',
  `ifzz` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ty_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_tijian_yuyue
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_tijian_yuyue`;
CREATE TABLE `ims_hyb_yl_tijian_yuyue` (
  `tjyy_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `tjyy_tcname` varchar(50) DEFAULT NULL COMMENT '体检预约套餐',
  `tjyy_yyname` varchar(50) DEFAULT NULL COMMENT '体检预约医院',
  `tiyy_openid` varchar(255) DEFAULT NULL,
  `tjyy_tcnum` int(10) DEFAULT NULL COMMENT '体检套餐项目数',
  `tjyy_name` varchar(50) DEFAULT NULL COMMENT '体检预约者',
  `tjyy_shenfenzheng` varchar(50) DEFAULT NULL COMMENT '体检预约者身份证号',
  `tjyy_telphone` varchar(50) DEFAULT NULL COMMENT '体检预约者手机号',
  `tjyy_tcmoney` varchar(50) DEFAULT NULL COMMENT '体检预约套餐价格',
  `tjyy_time` varchar(50) DEFAULT NULL COMMENT '体检预约时间',
  PRIMARY KEY (`tjyy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_tijianbaogao
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_tijianbaogao`;
CREATE TABLE `ims_hyb_yl_tijianbaogao` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `thumbarr` varchar(255) DEFAULT NULL,
  `tiyiyuan` varchar(50) DEFAULT NULL,
  `timearr` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `picfengm` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_upload_img
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_upload_img`;
CREATE TABLE `ims_hyb_yl_upload_img` (
  `i_id` int(10) NOT NULL AUTO_INCREMENT,
  `i_openid` varchar(255) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `i_type` int(10) NOT NULL COMMENT '0:患者问题；1:图文咨询；2:专家认证',
  `i_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `i_img` longtext,
  `i_doctor` int(11) DEFAULT NULL COMMENT '我咨询的医生',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_userdstimes
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_userdstimes`;
CREATE TABLE `ims_hyb_yl_userdstimes` (
  `ds_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `timearr` varchar(50) NOT NULL,
  `xiangmu` varchar(255) NOT NULL,
  `formid` varchar(255) NOT NULL,
  PRIMARY KEY (`ds_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_usergoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_usergoods`;
CREATE TABLE `ims_hyb_yl_usergoods` (
  `m_oid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) NOT NULL,
  `goodsname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `money` varchar(255) DEFAULT NULL,
  `types` int(11) NOT NULL,
  `ifzhifu` int(11) NOT NULL DEFAULT '0' COMMENT '是否支付：0未支付,1已支付',
  `danh` varchar(255) NOT NULL,
  `timesa` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `telNumber` varchar(50) NOT NULL,
  PRIMARY KEY (`m_oid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_userinfo`;
CREATE TABLE `ims_hyb_yl_userinfo` (
  `u_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `u_name` varchar(255) DEFAULT NULL,
  `u_thumb` varchar(255) DEFAULT NULL,
  `u_type` varchar(255) NOT NULL DEFAULT '0' COMMENT '核销员设置 1是核销员，0不是核销员',
  `u_phone` varchar(255) NOT NULL,
  `form_id` longtext NOT NULL,
  `u_xfmoney` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL DEFAULT '1',
  `adminuserdj` varchar(50) NOT NULL COMMENT '会员等级',
  `adminoptime` int(10) NOT NULL COMMENT '会员开通时间',
  `adminguanbi` int(10) NOT NULL COMMENT '会员到期时间',
  `admintype` int(10) NOT NULL DEFAULT '0' COMMENT '0未开通过；1已开通',
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_userjiaren
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_userjiaren`;
CREATE TABLE `ims_hyb_yl_userjiaren` (
  `j_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) NOT NULL,
  `names` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`j_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_usermedical
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_usermedical`;
CREATE TABLE `ims_hyb_yl_usermedical` (
  `us_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `us_name` varchar(50) DEFAULT NULL COMMENT '患者名称',
  `us_desc` varchar(255) NOT NULL COMMENT '病情描述',
  `us_jhospital` varchar(50) NOT NULL COMMENT '原就诊医院',
  `us_xhospital` varchar(50) NOT NULL COMMENT '现就诊医院',
  `us_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '就诊时间',
  `us_ks` varchar(50) DEFAULT NULL COMMENT 'j就诊科室',
  `us_yb` int(10) NOT NULL DEFAULT '0' COMMENT '医保1：有 0无',
  `us_img` varchar(255) NOT NULL COMMENT '附件上传',
  `us_openid` varchar(255) DEFAULT NULL COMMENT '患者openid',
  PRIMARY KEY (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_usersharepl
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_usersharepl`;
CREATE TABLE `ims_hyb_yl_usersharepl` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `pl_name` varchar(255) NOT NULL,
  `openid` varchar(255) NOT NULL COMMENT '用户openid',
  `pl_time` int(11) NOT NULL,
  `pl_content` text NOT NULL,
  `pl_type` int(11) NOT NULL COMMENT '回复类型1贴主0用户',
  `parentid` int(11) NOT NULL COMMENT '回复ID',
  `a_id` int(11) NOT NULL COMMENT '分享文章Id',
  `pl_pic` text NOT NULL,
  PRIMARY KEY (`pl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_wxapptemp
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_wxapptemp`;
CREATE TABLE `ims_hyb_yl_wxapptemp` (
  `w_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `doctemp` varchar(255) NOT NULL COMMENT '患者咨询信息提醒',
  `kaiguan` int(11) NOT NULL DEFAULT '0',
  `txtempt` varchar(255) NOT NULL,
  `weidbb` varchar(255) NOT NULL,
  `cforder` varchar(255) NOT NULL,
  `paymobel` varchar(255) NOT NULL,
  `kzyytongz` varchar(255) NOT NULL,
  `tixuser` varchar(255) NOT NULL COMMENT '提醒用户',
  `yqtemp` varchar(255) NOT NULL,
  `jujyaoqi` varchar(255) NOT NULL,
  `qiany` varchar(255) NOT NULL,
  PRIMARY KEY (`w_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_yaoqingdoc
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_yaoqingdoc`;
CREATE TABLE `ims_hyb_yl_yaoqingdoc` (
  `yao_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `zid` int(11) NOT NULL,
  `yao_type` int(11) NOT NULL DEFAULT '0' COMMENT '0邀请中；1已同意；2已拒绝',
  `yao_time` int(11) NOT NULL COMMENT '时间',
  `openid` varchar(255) NOT NULL COMMENT '邀请人openID',
  `t_id` int(11) NOT NULL DEFAULT '0' COMMENT '团队ID',
  PRIMARY KEY (`yao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_yishuo
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_yishuo`;
CREATE TABLE `ims_hyb_yl_yishuo` (
  `yisid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `hid` int(11) NOT NULL DEFAULT '0',
  `ystext` text NOT NULL,
  `yspic` text NOT NULL,
  `ystime` int(11) NOT NULL,
  `user` text NOT NULL COMMENT '分享用户',
  `zid` int(11) NOT NULL,
  PRIMARY KEY (`yisid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_yiyuankeshi
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_yiyuankeshi`;
CREATE TABLE `ims_hyb_yl_yiyuankeshi` (
  `nksid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `nksname` char(50) NOT NULL,
  `hosid` int(11) NOT NULL,
  `nksthumb` varchar(255) NOT NULL,
  `nkdesc` varchar(255) NOT NULL,
  PRIMARY KEY (`nksid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_yltx
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_yltx`;
CREATE TABLE `ims_hyb_yl_yltx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_openid` varchar(255) NOT NULL COMMENT '用户openid',
  `tx_type` int(11) NOT NULL COMMENT '提现方式 1,支付宝,2微信,3银联',
  `tx_cost` varchar(50) NOT NULL COMMENT '提现金额',
  `status` int(4) NOT NULL COMMENT '状态 1申请,2通过,3拒绝',
  `uniacid` varchar(50) NOT NULL,
  `cerated_time` int(20) NOT NULL COMMENT '日期',
  `sj_cost` varchar(50) NOT NULL COMMENT '实际金额',
  `account` varchar(30) NOT NULL COMMENT '账户',
  `tx_admin` char(50) NOT NULL,
  `zjid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_youhuiquansite
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_youhuiquansite`;
CREATE TABLE `ims_hyb_yl_youhuiquansite` (
  `yh_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `yh_title` varchar(255) NOT NULL,
  `yh_color` char(50) NOT NULL,
  `yh_moner` float(6,2) NOT NULL,
  `yh_kc` int(11) NOT NULL,
  PRIMARY KEY (`yh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_yzfuwu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_yzfuwu`;
CREATE TABLE `ims_hyb_yl_yzfuwu` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `futj` int(11) NOT NULL,
  `fthumb` varchar(255) NOT NULL,
  `biaoqian` varchar(255) NOT NULL,
  `jieshao` longtext NOT NULL,
  `taocanm` longtext NOT NULL,
  `parid` int(11) NOT NULL COMMENT '父类ID',
  `zmoney` varchar(255) NOT NULL,
  `mor_thumb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_zhifudoc
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_zhifudoc`;
CREATE TABLE `ims_hyb_yl_zhifudoc` (
  `zhi_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `z_yname` varchar(50) DEFAULT NULL,
  `z_pic` varchar(255) DEFAULT NULL,
  `z_tese` varchar(255) NOT NULL,
  `z_docnum` int(11) NOT NULL DEFAULT '0',
  `z_money` float(6,2) NOT NULL,
  `z_parid` int(11) NOT NULL,
  PRIMARY KEY (`zhi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_zhuanjia
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_zhuanjia`;
CREATE TABLE `ims_hyb_yl_zhuanjia` (
  `zid` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `z_name` varchar(255) NOT NULL COMMENT '专家姓名',
  `z_thumb` longtext NOT NULL COMMENT '专家照片',
  `z_room` varchar(255) DEFAULT NULL COMMENT '专家所在科室',
  `z_zhicheng` varchar(255) DEFAULT NULL COMMENT '专家职称',
  `z_zhiwu` varchar(255) DEFAULT NULL COMMENT '专家职务',
  `z_telephone` varchar(255) DEFAULT NULL COMMENT '专家联系方式',
  `z_zhenzhi` longtext COMMENT '专家诊治范围',
  `z_content` longtext COMMENT '专家简介',
  `z_sex` varchar(50) NOT NULL DEFAULT '0' COMMENT '1男；0女',
  `z_age` varchar(50) DEFAULT NULL,
  `z_shenfengzheng` varchar(50) NOT NULL COMMENT '1：坐诊专家；0：科室专家',
  `z_yiyuan` varchar(50) DEFAULT NULL COMMENT '专家所在医院',
  `z_thumbs` varchar(255) DEFAULT NULL COMMENT '专家头像',
  `z_tw_money` float(6,2) NOT NULL DEFAULT '0.00' COMMENT '提问金额',
  `z_zx_money` varchar(50) NOT NULL DEFAULT '0' COMMENT '图文资讯金额',
  `z_yy_money` varchar(50) NOT NULL DEFAULT '0' COMMENT '预约挂号金额',
  `z_yy_type` varchar(50) NOT NULL DEFAULT '0' COMMENT '是否推荐 1：推荐 0不推荐',
  `z_yy_fens` int(50) NOT NULL DEFAULT '0' COMMENT '粉丝',
  `z_yy_sheng` int(10) NOT NULL DEFAULT '0' COMMENT '1审核；0:不审核',
  `sord` int(11) NOT NULL DEFAULT '0',
  `z_lt_money` float(6,2) NOT NULL,
  `futype` int(11) NOT NULL DEFAULT '0' COMMENT '服务开关',
  `lttype` int(11) NOT NULL DEFAULT '0',
  `helpnum` int(11) NOT NULL,
  `url` longtext NOT NULL,
  `d_txmoney` float(6,2) NOT NULL,
  `overmoney` float(6,2) NOT NULL,
  `goby` varchar(255) NOT NULL,
  `ifzz` int(11) NOT NULL DEFAULT '1' COMMENT '1开启；0关闭',
  `scover_time` varchar(50) NOT NULL COMMENT '最近一次结算时间',
  `weweima` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `tindex` int(11) NOT NULL DEFAULT '0',
  `gzstype` int(11) NOT NULL DEFAULT '1' COMMENT '工作室状态1开启；0关闭',
  `gbyuanyin` varchar(255) NOT NULL COMMENT '关闭原因',
  `qianyue` int(11) NOT NULL DEFAULT '0',
  `twzixun` text NOT NULL,
  `dianhuazix` text NOT NULL,
  `zaixian` text NOT NULL,
  `zjshenfenz` varchar(255) NOT NULL,
  `nksname` char(50) NOT NULL,
  `hosid` int(11) NOT NULL COMMENT '医院id',
  `nksid` int(11) NOT NULL COMMENT '医院科室id',
  `zkbianhao` varchar(255) NOT NULL,
  `sfzbianhao` varchar(255) NOT NULL,
  `zgzimgurl1back` varchar(255) NOT NULL,
  `zgzimgurl2back` varchar(255) NOT NULL,
  `zczimgurlback` varchar(255) NOT NULL,
  `sfzimgurl1back` varchar(255) NOT NULL,
  `sfzimgurl2back` varchar(255) NOT NULL,
  `gzzimgurlback` varchar(255) NOT NULL,
  `wzmoney` float(6,2) NOT NULL COMMENT '问诊金额',
  PRIMARY KEY (`zid`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_zhuanjia_yuyue
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_zhuanjia_yuyue`;
CREATE TABLE `ims_hyb_yl_zhuanjia_yuyue` (
  `zy_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `zy_name` varchar(50) NOT NULL COMMENT '患者id',
  `zy_telephone` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `zy_openid` varchar(255) DEFAULT NULL COMMENT '我的OPENID',
  `z_name` varchar(255) DEFAULT NULL COMMENT '专家ID',
  `zy_riqi` varchar(255) DEFAULT NULL COMMENT '星期',
  `zy_time` varchar(255) DEFAULT NULL COMMENT '预约时间',
  `zy_yibao` varchar(255) DEFAULT NULL COMMENT '专家预约的年yea',
  `zy_sex` varchar(50) NOT NULL COMMENT '订单二维码',
  `zy_zhenzhuang` varchar(255) NOT NULL DEFAULT '0' COMMENT '0:待核销；1：已核销2：已取消',
  `zy_type` varchar(255) DEFAULT NULL COMMENT '专家坐诊时间',
  `zy_money` float(6,2) DEFAULT NULL COMMENT '预约价格',
  `ksname` varchar(50) DEFAULT NULL COMMENT '科室名称',
  `states` int(11) NOT NULL DEFAULT '0' COMMENT '3：移除订单',
  `remove` int(11) NOT NULL DEFAULT '1' COMMENT '0:取消预约 1：不取消',
  `paystate` int(11) NOT NULL DEFAULT '1' COMMENT '1已支付',
  PRIMARY KEY (`zy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_zhuanjia_yuyuetime
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_zhuanjia_yuyuetime`;
CREATE TABLE `ims_hyb_yl_zhuanjia_yuyuetime` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `riqi` varchar(50) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_zhuanjiafenzu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_zhuanjiafenzu`;
CREATE TABLE `ims_hyb_yl_zhuanjiafenzu` (
  `fenzuid` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `zid` int(11) NOT NULL,
  `fenzname` char(50) NOT NULL,
  PRIMARY KEY (`fenzuid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_zhuanjteam
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_zhuanjteam`;
CREATE TABLE `ims_hyb_yl_zhuanjteam` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `teamname` char(50) NOT NULL,
  `teamaddress` varchar(255) NOT NULL,
  `teamtype` char(50) NOT NULL COMMENT '0线上1团体',
  `teamtext` text NOT NULL,
  `teampic` varchar(255) NOT NULL,
  `zid` int(11) NOT NULL,
  `ifchuanj` int(11) NOT NULL DEFAULT '0' COMMENT '0创建1未创建',
  `doctorCount` int(11) NOT NULL DEFAULT '0',
  `patientCount` int(11) NOT NULL,
  `cltime` int(11) NOT NULL,
  `iftj` int(11) NOT NULL DEFAULT '0',
  `tderweima` varchar(255) NOT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_zixun
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_zixun`;
CREATE TABLE `ims_hyb_yl_zixun` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `zx_names` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_fu` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `content_thumb` varchar(255) DEFAULT NULL,
  `content` longtext,
  `status` varchar(20) NOT NULL DEFAULT '0',
  `time` varchar(255) DEFAULT NULL,
  `mp3` varchar(255) NOT NULL,
  `iflouc` int(10) NOT NULL DEFAULT '0',
  `sord` int(11) NOT NULL DEFAULT '0',
  `dianj` int(11) NOT NULL DEFAULT '0',
  `aliaut` varchar(255) NOT NULL,
  `kiguan` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_zixun_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_zixun_type`;
CREATE TABLE `ims_hyb_yl_zixun_type` (
  `zx_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `zx_name` varchar(255) DEFAULT NULL,
  `zx_thumb` varchar(255) DEFAULT NULL,
  `zx_type` int(10) DEFAULT '0' COMMENT '是否推荐 1：推荐；0不推荐',
  PRIMARY KEY (`zx_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_yl_zizhuanl
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_yl_zizhuanl`;
CREATE TABLE `ims_hyb_yl_zizhuanl` (
  `hz_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `hz_name` varchar(50) NOT NULL,
  `hz_thumb` varchar(255) NOT NULL,
  `hz_count` longtext NOT NULL,
  `hz_time` date NOT NULL DEFAULT '0000-00-00',
  `hz_type` varchar(50) NOT NULL DEFAULT '0' COMMENT '患者推荐1推荐；0不推荐',
  `hz_desction` varchar(50) NOT NULL,
  `hz_mp3` varchar(255) NOT NULL,
  `hz_zlks` int(10) DEFAULT NULL COMMENT '科室分类',
  `iflouc` int(10) NOT NULL DEFAULT '0',
  `dianj` int(11) NOT NULL DEFAULT '0' COMMENT '阅读量',
  `sord` int(11) NOT NULL DEFAULT '0',
  `aliaut` varchar(255) DEFAULT NULL,
  `kiguan` int(11) NOT NULL DEFAULT '0',
  `parid` int(11) NOT NULL COMMENT '父类ID',
  PRIMARY KEY (`hz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
