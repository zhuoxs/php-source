<?php
/**
 * 本破解程序由资源邦提供
 * 资源邦www.wazyb.com
 * QQ:993424780  承接网站建设、公众号搭建、小程序建设、企业网站
 */
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_ad` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_ad','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_ad','title')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `title` text COMMENT '广告标题'");}
if(!pdo_fieldexists('yzcj_sun_ad','logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `logo` varchar(100) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzcj_sun_ad','url')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `url` varchar(100) DEFAULT NULL COMMENT '外部链接'");}
if(!pdo_fieldexists('yzcj_sun_ad','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `status` tinyint(1) DEFAULT NULL COMMENT '状态'");}
if(!pdo_fieldexists('yzcj_sun_ad','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `time` varchar(50) DEFAULT NULL COMMENT '时间'");}
if(!pdo_fieldexists('yzcj_sun_ad','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '模块名'");}
if(!pdo_fieldexists('yzcj_sun_ad','type')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `type` int(11) DEFAULT NULL COMMENT '类型'");}
if(!pdo_fieldexists('yzcj_sun_ad','state')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `state` int(11) DEFAULT NULL COMMENT '跳转路径选择'");}
if(!pdo_fieldexists('yzcj_sun_ad','src')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `src` varchar(100) DEFAULT NULL COMMENT '内部链接'");}
if(!pdo_fieldexists('yzcj_sun_ad','xcx_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `xcx_name` varchar(20) DEFAULT NULL COMMENT '关联小程序'");}
if(!pdo_fieldexists('yzcj_sun_ad','appid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_ad')." ADD   `appid` varchar(100) DEFAULT NULL COMMENT '关联小程序appid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_addnews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) NOT NULL COMMENT '标题，展示用',
  `left` int(10) unsigned NOT NULL,
  `state` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1显示，2为关闭',
  `uniacid` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '类型',
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_addnews','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_addnews')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('yzcj_sun_addnews','title')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_addnews')." ADD   `title` varchar(255) NOT NULL COMMENT '标题，展示用'");}
if(!pdo_fieldexists('yzcj_sun_addnews','left')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_addnews')." ADD   `left` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_addnews','state')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_addnews')." ADD   `state` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1显示，2为关闭'");}
if(!pdo_fieldexists('yzcj_sun_addnews','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_addnews')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_addnews','type')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_addnews')." ADD   `type` int(11) NOT NULL COMMENT '类型'");}
if(!pdo_fieldexists('yzcj_sun_addnews','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_addnews')." ADD   `time` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_address` (
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

");

if(!pdo_fieldexists('yzcj_sun_address','adid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD 
  `adid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_address','name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `name` varchar(45) NOT NULL COMMENT '收货人'");}
if(!pdo_fieldexists('yzcj_sun_address','telNumber')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `telNumber` varchar(30) NOT NULL COMMENT '收件人号码'");}
if(!pdo_fieldexists('yzcj_sun_address','countyName')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `countyName` varchar(100) NOT NULL COMMENT '区'");}
if(!pdo_fieldexists('yzcj_sun_address','detailAddr')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `detailAddr` varchar(100) NOT NULL COMMENT '详细地址'");}
if(!pdo_fieldexists('yzcj_sun_address','isDefault')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `isDefault` varchar(11) DEFAULT '0'");}
if(!pdo_fieldexists('yzcj_sun_address','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `uid` varchar(55) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_address','provinceName')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `provinceName` varchar(100) NOT NULL COMMENT '省'");}
if(!pdo_fieldexists('yzcj_sun_address','cityName')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `cityName` varchar(100) NOT NULL COMMENT '市'");}
if(!pdo_fieldexists('yzcj_sun_address','postalCode')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `postalCode` int(11) DEFAULT NULL COMMENT '邮政编码'");}
if(!pdo_fieldexists('yzcj_sun_address','detailInfo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `detailInfo` varchar(100) DEFAULT NULL COMMENT '详细情况'");}
if(!pdo_fieldexists('yzcj_sun_address','oid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_address')." ADD   `oid` int(11) DEFAULT NULL COMMENT '关联订单'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_audit','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_audit')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_audit','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_audit')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_audit','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_audit')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) DEFAULT NULL,
  `money` decimal(11,2) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '状态，是否处理，0未处理',
  `wx` varchar(50) DEFAULT NULL COMMENT '微信号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_balance','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_balance')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_balance','openid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_balance')." ADD   `openid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_balance','money')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_balance')." ADD   `money` decimal(11,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_balance','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_balance')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_balance','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_balance')." ADD   `time` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_balance','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_balance')." ADD   `status` int(11) DEFAULT '0' COMMENT '状态，是否处理，0未处理'");}
if(!pdo_fieldexists('yzcj_sun_balance','wx')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_balance')." ADD   `wx` varchar(50) DEFAULT NULL COMMENT '微信号'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_banner` (
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
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

");

if(!pdo_fieldexists('yzcj_sun_banner','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_banner','bname')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `bname` varchar(200) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','url')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `url` varchar(300) NOT NULL COMMENT '文章图片'");}
if(!pdo_fieldexists('yzcj_sun_banner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `lb_imgs` varchar(500) NOT NULL COMMENT '文章那个内容'");}
if(!pdo_fieldexists('yzcj_sun_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','bname1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `bname1` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','bname2')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `bname2` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','bname3')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `bname3` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','lb_imgs1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `lb_imgs1` varchar(500) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','lb_imgs2')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `lb_imgs2` varchar(500) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','lb_imgs3')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `lb_imgs3` varchar(500) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','url1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `url1` varchar(300) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','url2')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `url2` varchar(300) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_banner','url3')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_banner')." ADD   `url3` varchar(300) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_circle` (
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
  CONSTRAINT `ims_yzcj_sun_circle_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ims_yzcj_sun_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_circle','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_circle','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_circle','content')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `content` text COMMENT '文章内容'");}
if(!pdo_fieldexists('yzcj_sun_circle','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发布时间'");}
if(!pdo_fieldexists('yzcj_sun_circle','img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `img` text COMMENT '图片'");}
if(!pdo_fieldexists('yzcj_sun_circle','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_circle','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_circle','type')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `type` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_circle','uname')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `uname` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_circle','uphone')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `uphone` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_circle','addr')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `addr` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_circle','longitude')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `longitude` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_circle','latitude')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   `latitude` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_circle','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('yzcj_sun_circle','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_circle')." ADD   KEY `uid` (`uid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `invuid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_code','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_code')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_code','oid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_code')." ADD   `oid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_code','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_code')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_code','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_code')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_code','invuid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_code')." ADD   `invuid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_code','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_code')." ADD   `gid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(200) DEFAULT NULL COMMENT '评论内容',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cid` int(11) DEFAULT NULL COMMENT '所评论的文章ID',
  `uid` int(11) DEFAULT NULL COMMENT '评论用户',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `uid` (`uid`),
  CONSTRAINT `ims_yzcj_sun_content_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `ims_yzcj_sun_circle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ims_yzcj_sun_content_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `ims_yzcj_sun_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_content','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_content','content')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD   `content` varchar(200) DEFAULT NULL COMMENT '评论内容'");}
if(!pdo_fieldexists('yzcj_sun_content','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD   `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");}
if(!pdo_fieldexists('yzcj_sun_content','cid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD   `cid` int(11) DEFAULT NULL COMMENT '所评论的文章ID'");}
if(!pdo_fieldexists('yzcj_sun_content','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD   `uid` int(11) DEFAULT NULL COMMENT '评论用户'");}
if(!pdo_fieldexists('yzcj_sun_content','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_content','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('yzcj_sun_content','cid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD   KEY `cid` (`cid`)");}
if(!pdo_fieldexists('yzcj_sun_content','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD   KEY `uid` (`uid`)");}
if(!pdo_fieldexists('yzcj_sun_content','ims_yzcj_sun_content_ibfk_1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_content')." ADD   CONSTRAINT `ims_yzcj_sun_content_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `ims_yzcj_sun_circle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_daily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  CONSTRAINT `ims_yzcj_sun_daily_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `ims_yzcj_sun_gifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_daily','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_daily')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_daily','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_daily')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_daily','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_daily')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_daily','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_daily')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('yzcj_sun_daily','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_daily')." ADD   KEY `gid` (`gid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_gifts` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_gifts','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_gifts','gname')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `gname` varchar(50) DEFAULT NULL COMMENT '礼物名'");}
if(!pdo_fieldexists('yzcj_sun_gifts','lottery')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `lottery` varchar(200) DEFAULT NULL COMMENT '简介'");}
if(!pdo_fieldexists('yzcj_sun_gifts','price')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `price` decimal(11,2) DEFAULT NULL COMMENT '价钱'");}
if(!pdo_fieldexists('yzcj_sun_gifts','content')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('yzcj_sun_gifts','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_gifts','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");}
if(!pdo_fieldexists('yzcj_sun_gifts','type')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `type` int(11) DEFAULT NULL COMMENT '类型'");}
if(!pdo_fieldexists('yzcj_sun_gifts','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `status` int(11) DEFAULT NULL COMMENT '状态'");}
if(!pdo_fieldexists('yzcj_sun_gifts','pic')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `pic` text COMMENT '图片'");}
if(!pdo_fieldexists('yzcj_sun_gifts','sid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `sid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yzcj_sun_gifts','count')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_gifts')." ADD   `count` int(11) DEFAULT NULL COMMENT '库存'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_giftsbanner` (
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
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

");

if(!pdo_fieldexists('yzcj_sun_giftsbanner','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','bname')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `bname` varchar(200) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','url')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `url` varchar(300) NOT NULL COMMENT '文章图片'");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `lb_imgs` varchar(500) NOT NULL COMMENT '文章那个内容'");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','bname1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `bname1` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','bname2')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `bname2` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','bname3')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `bname3` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','lb_imgs1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `lb_imgs1` varchar(500) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','lb_imgs2')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `lb_imgs2` varchar(500) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','lb_imgs3')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `lb_imgs3` varchar(500) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','url1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `url1` varchar(300) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','url2')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `url2` varchar(300) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_giftsbanner','url3')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_giftsbanner')." ADD   `url3` varchar(300) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_goods` (
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
  PRIMARY KEY (`gid`),
  KEY `giftId` (`giftId`),
  CONSTRAINT `ims_yzcj_sun_goods_ibfk_1` FOREIGN KEY (`giftId`) REFERENCES `ims_yzcj_sun_gifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='点击 ';

");

if(!pdo_fieldexists('yzcj_sun_goods','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD 
  `gid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_goods','gname')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `gname` text CHARACTER SET gbk COMMENT '抽奖名称/红包金额'");}
if(!pdo_fieldexists('yzcj_sun_goods','count')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `count` varchar(45) CHARACTER SET gbk DEFAULT NULL COMMENT '数量'");}
if(!pdo_fieldexists('yzcj_sun_goods','selftime')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `selftime` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '加入时间'");}
if(!pdo_fieldexists('yzcj_sun_goods','pic')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `pic` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '封面图'");}
if(!pdo_fieldexists('yzcj_sun_goods','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `uid` int(11) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcj_sun_goods','sid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `sid` int(11) DEFAULT NULL COMMENT '赞助商id'");}
if(!pdo_fieldexists('yzcj_sun_goods','cid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `cid` int(11) DEFAULT NULL COMMENT '抽奖类型'");}
if(!pdo_fieldexists('yzcj_sun_goods','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `status` int(11) DEFAULT '2' COMMENT '抽奖状态'");}
if(!pdo_fieldexists('yzcj_sun_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_goods','condition')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `condition` int(11) DEFAULT NULL COMMENT '开奖条件，0为按时间，1按人数，2手动，3现场'");}
if(!pdo_fieldexists('yzcj_sun_goods','accurate')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `accurate` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '开奖条件，填写准确时间，人数'");}
if(!pdo_fieldexists('yzcj_sun_goods','endtime')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `endtime` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('yzcj_sun_goods','lottery')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `lottery` text");}
if(!pdo_fieldexists('yzcj_sun_goods','zuid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `zuid` int(11) DEFAULT NULL COMMENT '指定人中奖ID'");}
if(!pdo_fieldexists('yzcj_sun_goods','giftId')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `giftId` int(11) DEFAULT NULL COMMENT '关联礼物ID'");}
if(!pdo_fieldexists('yzcj_sun_goods','code_img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `code_img` mediumblob COMMENT '小程序码二进制'");}
if(!pdo_fieldexists('yzcj_sun_goods','img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `img` text");}
if(!pdo_fieldexists('yzcj_sun_goods','paidprice')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `paidprice` decimal(11,2) DEFAULT NULL COMMENT '付费抽奖费用'");}
if(!pdo_fieldexists('yzcj_sun_goods','password')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `password` varchar(50) DEFAULT NULL COMMENT '参与口令'");}
if(!pdo_fieldexists('yzcj_sun_goods','group')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `group` int(11) DEFAULT NULL COMMENT '组团抽奖人数'");}
if(!pdo_fieldexists('yzcj_sun_goods','codenum')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `codenum` int(11) DEFAULT NULL COMMENT '抽奖码总数'");}
if(!pdo_fieldexists('yzcj_sun_goods','codemost')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `codemost` int(11) DEFAULT NULL COMMENT '每人可获取最多数量'");}
if(!pdo_fieldexists('yzcj_sun_goods','codecount')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `codecount` int(11) DEFAULT NULL COMMENT '须分享几次获取一个抽奖码'");}
if(!pdo_fieldexists('yzcj_sun_goods','codeway')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `codeway` int(2) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_goods','onename')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `onename` varchar(50) DEFAULT NULL COMMENT '一等奖名称'");}
if(!pdo_fieldexists('yzcj_sun_goods','onenum')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `onenum` int(11) DEFAULT NULL COMMENT '一等奖数量'");}
if(!pdo_fieldexists('yzcj_sun_goods','twoname')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `twoname` varchar(50) DEFAULT NULL COMMENT '二等奖名称'");}
if(!pdo_fieldexists('yzcj_sun_goods','twonum')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `twonum` int(11) DEFAULT NULL COMMENT '二等奖数量'");}
if(!pdo_fieldexists('yzcj_sun_goods','threename')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `threename` varchar(50) DEFAULT NULL COMMENT '三等奖名称'");}
if(!pdo_fieldexists('yzcj_sun_goods','threenum')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `threenum` int(11) DEFAULT NULL COMMENT '三等奖数量'");}
if(!pdo_fieldexists('yzcj_sun_goods','state')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `state` int(2) DEFAULT NULL COMMENT '高级抽奖类型，1为付费，2为口令，3为组团，4为抽奖码'");}
if(!pdo_fieldexists('yzcj_sun_goods','one')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   `one` int(2) DEFAULT NULL COMMENT '1为开启一二三等奖，2为不开启'");}
if(!pdo_fieldexists('yzcj_sun_goods','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   PRIMARY KEY (`gid`)");}
if(!pdo_fieldexists('yzcj_sun_goods','giftId')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goods')." ADD   KEY `giftId` (`giftId`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_goodsdaily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  CONSTRAINT `ims_yzcj_sun_goodsdaily_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `ims_yzcj_sun_goods` (`gid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_goodsdaily','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goodsdaily')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_goodsdaily','sort')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goodsdaily')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_goodsdaily','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goodsdaily')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_goodsdaily','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goodsdaily')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_goodsdaily','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goodsdaily')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('yzcj_sun_goodsdaily','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goodsdaily')." ADD   KEY `gid` (`gid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_goodspi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_goodspi','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goodspi')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_goodspi','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goodspi')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_goodspi','name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_goodspi')." ADD   `name` varchar(50) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `invuid` int(11) DEFAULT NULL COMMENT '团长ID',
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_group','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_group')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_group','oid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_group')." ADD   `oid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_group','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_group')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_group','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_group')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_group','invuid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_group')." ADD   `invuid` int(11) DEFAULT NULL COMMENT '团长ID'");}
if(!pdo_fieldexists('yzcj_sun_group','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_group')." ADD   `gid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `answer` varchar(200) DEFAULT NULL COMMENT '回答',
  `uniacid` int(11) DEFAULT NULL COMMENT '模块名',
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_help','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_help')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_help','title')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_help')." ADD   `title` varchar(50) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('yzcj_sun_help','answer')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_help')." ADD   `answer` varchar(200) DEFAULT NULL COMMENT '回答'");}
if(!pdo_fieldexists('yzcj_sun_help','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_help')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '模块名'");}
if(!pdo_fieldexists('yzcj_sun_help','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_help')." ADD   `time` varchar(50) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(11) DEFAULT NULL COMMENT '期限',
  `money` varchar(50) DEFAULT NULL COMMENT '价格',
  `uniacid` int(11) DEFAULT NULL COMMENT '模块名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_in','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_in')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_in','day')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_in')." ADD   `day` int(11) DEFAULT NULL COMMENT '期限'");}
if(!pdo_fieldexists('yzcj_sun_in','money')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_in')." ADD   `money` varchar(50) DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('yzcj_sun_in','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_in')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '模块名'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `recharge` decimal(50,2) DEFAULT NULL,
  `youhui` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_money','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_money')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_money','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_money')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_money','recharge')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_money')." ADD   `recharge` decimal(50,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_money','youhui')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_money')." ADD   `youhui` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_money','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_money')." ADD   `status` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_order` (
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_order','oid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD 
  `oid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_order','orderNum')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `orderNum` varchar(50) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('yzcj_sun_order','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `status` varchar(255) DEFAULT '1' COMMENT '1 待开奖，2中奖，3没有中奖'");}
if(!pdo_fieldexists('yzcj_sun_order','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `time` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_order','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `uid` int(11) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcj_sun_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_order','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_order','adid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `adid` int(100) DEFAULT NULL COMMENT '地址表id'");}
if(!pdo_fieldexists('yzcj_sun_order','state')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `state` int(11) DEFAULT '1' COMMENT '是否已转赠'");}
if(!pdo_fieldexists('yzcj_sun_order','type')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `type` int(11) DEFAULT NULL COMMENT '1为付费，2为口令，3为组团，4为抽奖码'");}
if(!pdo_fieldexists('yzcj_sun_order','one')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_order')." ADD   `one` int(2) DEFAULT NULL COMMENT '0非，1为一等奖，2为二等奖，3为三等奖'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_praise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL COMMENT '点赞文章的ID',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `uid` (`uid`),
  CONSTRAINT `ims_yzcj_sun_praise_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ims_yzcj_sun_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ims_yzcj_sun_praise_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `ims_yzcj_sun_circle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_praise','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_praise')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_praise','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_praise')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_praise','cid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_praise')." ADD   `cid` int(11) DEFAULT NULL COMMENT '点赞文章的ID'");}
if(!pdo_fieldexists('yzcj_sun_praise','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_praise')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_praise','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_praise')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('yzcj_sun_praise','cid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_praise')." ADD   KEY `cid` (`cid`)");}
if(!pdo_fieldexists('yzcj_sun_praise','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_praise')." ADD   KEY `uid` (`uid`)");}
if(!pdo_fieldexists('yzcj_sun_praise','ims_yzcj_sun_praise_ibfk_1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_praise')." ADD   CONSTRAINT `ims_yzcj_sun_praise_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ims_yzcj_sun_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_selectedtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tname` varchar(45) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `img` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_selectedtype','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_selectedtype')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_selectedtype','tname')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_selectedtype')." ADD   `tname` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_selectedtype','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_selectedtype')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_selectedtype','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_selectedtype')." ADD   `time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_selectedtype','img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_selectedtype')." ADD   `img` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_settab` (
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

");

if(!pdo_fieldexists('yzcj_sun_settab','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_settab','name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD   `name` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_settab','img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD   `img` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_settab','path')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD   `path` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_settab','sort')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_settab','imgs')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD   `imgs` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_settab','type')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD   `type` int(11) DEFAULT NULL COMMENT '2底部，1首页'");}
if(!pdo_fieldexists('yzcj_sun_settab','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_settab','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_settab','state')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_settab')." ADD   `state` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_setting` (
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

");

if(!pdo_fieldexists('yzcj_sun_setting','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_setting','weid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','appid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `appid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','appsecret')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `appsecret` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','mch_id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `mch_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','key')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `key` varchar(512) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','store_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `store_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','recharge_btn')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `recharge_btn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','recharge_img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `recharge_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','register_img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `register_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','is_sms')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `is_sms` tinyint(3) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('yzcj_sun_setting','sms_info')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `sms_info` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_setting','is_printer')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `is_printer` tinyint(3) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('yzcj_sun_setting','copyright')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_setting')." ADD   `copyright` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_sms` (
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

");

if(!pdo_fieldexists('yzcj_sun_sms','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sms')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_sms','appkey')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sms')." ADD   `appkey` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_sms','tpl_id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sms')." ADD   `tpl_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_sms','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sms')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_sms','is_open')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sms')." ADD   `is_open` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcj_sun_sms','tid1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sms')." ADD   `tid1` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_sms','tid2')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sms')." ADD   `tid2` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_sms','tid3')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sms')." ADD   `tid3` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_sms','qitui')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sms')." ADD   `qitui` text NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_sponsorship` (
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

");

if(!pdo_fieldexists('yzcj_sun_sponsorship','sid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD 
  `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT '赞助商id'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','sname')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `sname` text COMMENT '赞助商名'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','synopsis')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `synopsis` text COMMENT '简介'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','content')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','address')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `address` text COMMENT '地址'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','phone')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `phone` text");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','wx')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `wx` text COMMENT '联系人微信号'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `logo` varchar(200) DEFAULT NULL COMMENT 'LOGO'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','ewm_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `ewm_logo` varchar(200) DEFAULT NULL COMMENT '二维码'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `time` varchar(200) DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','day')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `day` int(11) DEFAULT NULL COMMENT '天数'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','endtime')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `endtime` varchar(200) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `status` tinyint(1) DEFAULT NULL COMMENT '状态'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','uid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `uid` int(11) DEFAULT NULL COMMENT '关联用户ID'");}
if(!pdo_fieldexists('yzcj_sun_sponsorship','pwd')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsorship')." ADD   `pwd` varchar(50) DEFAULT NULL COMMENT '后台登录密码'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_sponsortext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_sponsortext','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsortext')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_sponsortext','content')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsortext')." ADD   `content` text");}
if(!pdo_fieldexists('yzcj_sun_sponsortext','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_sponsortext')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '团队名称',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `logo` varchar(255) DEFAULT NULL COMMENT 'LOGO',
  `uniacid` int(11) DEFAULT NULL,
  `condition` int(11) DEFAULT NULL COMMENT '联系方式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_support','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_support')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_support','name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_support')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '团队名称'");}
if(!pdo_fieldexists('yzcj_sun_support','phone')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_support')." ADD   `phone` varchar(20) DEFAULT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('yzcj_sun_support','logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_support')." ADD   `logo` varchar(255) DEFAULT NULL COMMENT 'LOGO'");}
if(!pdo_fieldexists('yzcj_sun_support','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_support')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_support','condition')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_support')." ADD   `condition` int(11) DEFAULT NULL COMMENT '联系方式'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_system` (
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

");

if(!pdo_fieldexists('yzcj_sun_system','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_system','appid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `appid` varchar(100) NOT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('yzcj_sun_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `appsecret` varchar(200) NOT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('yzcj_sun_system','mchid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `mchid` varchar(20) NOT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('yzcj_sun_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('yzcj_sun_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','url_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `url_name` varchar(20) NOT NULL COMMENT '网址名称'");}
if(!pdo_fieldexists('yzcj_sun_system','details')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `details` text NOT NULL COMMENT '关于我们'");}
if(!pdo_fieldexists('yzcj_sun_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `url_logo` varchar(100) NOT NULL COMMENT '网址logo'");}
if(!pdo_fieldexists('yzcj_sun_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `bq_name` varchar(50) NOT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('yzcj_sun_system','link_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `link_name` varchar(30) NOT NULL COMMENT '网站名称'");}
if(!pdo_fieldexists('yzcj_sun_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `link_logo` varchar(100) NOT NULL COMMENT '网站logo'");}
if(!pdo_fieldexists('yzcj_sun_system','support')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `support` varchar(20) NOT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('yzcj_sun_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `bq_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `fontcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','color')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `color` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tz_appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tz_name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','pt_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `pt_name` varchar(30) NOT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('yzcj_sun_system','tz_audit')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tz_audit` int(11) NOT NULL DEFAULT '0' COMMENT '红包手续费'");}
if(!pdo_fieldexists('yzcj_sun_system','sj_audit')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `sj_audit` int(11) NOT NULL COMMENT '商家审核0.是 1否'");}
if(!pdo_fieldexists('yzcj_sun_system','mapkey')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `mapkey` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','tel')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','gd_key')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `gd_key` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','hb_sxf')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `hb_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','tx_money')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','tx_sxf')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tx_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','tx_details')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tx_details` text NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','rz_xuz')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `rz_xuz` text NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','ft_xuz')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `ft_xuz` text NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','fx_money')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `fx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','is_hhr')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_hhr` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcj_sun_system','is_hbfl')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_hbfl` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcj_sun_system','is_zx')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_zx` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcj_sun_system','is_car')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_car` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','pc_xuz')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `pc_xuz` text NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','pc_money')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `pc_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','is_sjrz')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_sjrz` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcj_sun_system','is_pcfw')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_pcfw` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','total_num')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `total_num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','is_goods')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_goods` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `apiclient_cert` text NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `apiclient_key` text NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','is_openzx')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_openzx` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','is_hyset')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_hyset` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','is_tzopen')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_tzopen` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','is_pageopen')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_pageopen` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','is_tel')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_tel` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','tx_mode')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tx_mode` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcj_sun_system','many_city')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `many_city` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcj_sun_system','tx_type')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tx_type` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcj_sun_system','is_hbzf')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_hbzf` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcj_sun_system','hb_img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `hb_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','tz_num')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `tz_num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `client_ip` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','hb_content')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `hb_content` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','is_vipcardopen')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_vipcardopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcj_sun_system','is_jkopen')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_jkopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcj_sun_system','address')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `address` varchar(150) DEFAULT NULL COMMENT '店铺地址'");}
if(!pdo_fieldexists('yzcj_sun_system','sj_ruzhu')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `sj_ruzhu` int(5) DEFAULT NULL COMMENT '0为关闭1为开启'");}
if(!pdo_fieldexists('yzcj_sun_system','is_kanjiaopen')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_kanjiaopen` int(4) DEFAULT '0' COMMENT '0关闭1开启'");}
if(!pdo_fieldexists('yzcj_sun_system','bargain_price')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `bargain_price` varchar(10) DEFAULT NULL COMMENT '每次砍价的%'");}
if(!pdo_fieldexists('yzcj_sun_system','sign')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `sign` varchar(12) DEFAULT NULL COMMENT '本店招牌自定义'");}
if(!pdo_fieldexists('yzcj_sun_system','bargain_title')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `bargain_title` varchar(15) DEFAULT NULL COMMENT '砍价分享标题'");}
if(!pdo_fieldexists('yzcj_sun_system','is_pintuanopen')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_pintuanopen` int(4) DEFAULT NULL COMMENT '2为关闭1为开启'");}
if(!pdo_fieldexists('yzcj_sun_system','refund')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `refund` int(4) DEFAULT '1' COMMENT '1为买家申请2为自动退款'");}
if(!pdo_fieldexists('yzcj_sun_system','refund_time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `refund_time` int(4) DEFAULT '0' COMMENT '自动退款时间 1为24；2为48；3为72；4为活动结束；5为不退款'");}
if(!pdo_fieldexists('yzcj_sun_system','groups_title')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `groups_title` varchar(45) DEFAULT NULL COMMENT '拼团分享标题'");}
if(!pdo_fieldexists('yzcj_sun_system','mask')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `mask` int(2) DEFAULT '1' COMMENT '0不显示1显示'");}
if(!pdo_fieldexists('yzcj_sun_system','is_couponopen')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_couponopen` int(4) DEFAULT '2' COMMENT '1为开启2为关闭'");}
if(!pdo_fieldexists('yzcj_sun_system','support_font')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `support_font` varchar(25) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','support_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `support_logo` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','support_tel')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `support_tel` varchar(40) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','psopen')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `psopen` int(2) DEFAULT '0'");}
if(!pdo_fieldexists('yzcj_sun_system','is_open_pop')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `is_open_pop` int(2) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','version')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `version` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','auto_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `auto_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','manu_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `manu_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','gift_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `gift_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','auto_logo1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `auto_logo1` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','manu_logo1')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `manu_logo1` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','cj_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `cj_name` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','dt_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `dt_name` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','cj_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `cj_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','cjzt')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `cjzt` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','dt_logo')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `dt_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','discount')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `discount` decimal(11,2) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_system','paidprice')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `paidprice` decimal(11,2) DEFAULT NULL COMMENT '付费抽奖价格'");}
if(!pdo_fieldexists('yzcj_sun_system','passwordprice')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `passwordprice` decimal(11,2) DEFAULT NULL COMMENT '口令抽奖价格'");}
if(!pdo_fieldexists('yzcj_sun_system','growpprice')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `growpprice` decimal(11,2) DEFAULT NULL COMMENT '组团抽奖价格'");}
if(!pdo_fieldexists('yzcj_sun_system','codeprice')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `codeprice` decimal(11,2) DEFAULT NULL COMMENT '抽奖码价格'");}
if(!pdo_fieldexists('yzcj_sun_system','oneprice')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `oneprice` decimal(11,2) DEFAULT NULL COMMENT '抽奖码价格'");}
if(!pdo_fieldexists('yzcj_sun_system','senior')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `senior` int(2) DEFAULT NULL COMMENT '高级抽奖开关'");}
if(!pdo_fieldexists('yzcj_sun_system','instructions')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_system')." ADD   `instructions` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_type` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_type','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_type','type')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD   `type` varchar(50) DEFAULT NULL COMMENT '类型'");}
if(!pdo_fieldexists('yzcj_sun_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_type','status')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_type','url')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD   `url` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_type','img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD   `img` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_type','url2')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD   `url2` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_type','img2')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD   `img2` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_type','url3')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD   `url3` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_type','img3')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_type')." ADD   `img3` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcj_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('yzcj_sun_user','openid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzcj_sun_user','img')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `img` varchar(200) DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('yzcj_sun_user','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `time` datetime DEFAULT NULL COMMENT '登录时间'");}
if(!pdo_fieldexists('yzcj_sun_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_user','money')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `money` decimal(11,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('yzcj_sun_user','user_name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `user_name` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_user','user_tel')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `user_tel` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_user','user_address')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `user_address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_user','commission')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `commission` decimal(11,0) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_user','state')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `state` int(4) DEFAULT '1'");}
if(!pdo_fieldexists('yzcj_sun_user','attention')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `attention` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_user','fans')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `fans` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_user','collection')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `collection` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_user','name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   `name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcj_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_user')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  `gid` int(11) DEFAULT NULL COMMENT '关联的项目id',
  `state` int(11) DEFAULT NULL COMMENT '发起用户为1，参与用户为2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='formid表';

");

if(!pdo_fieldexists('yzcj_sun_userformid','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_userformid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_userformid','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_userformid')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcj_sun_userformid','form_id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_userformid')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id'");}
if(!pdo_fieldexists('yzcj_sun_userformid','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_userformid')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_userformid','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_userformid')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcj_sun_userformid','openid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_userformid')." ADD   `openid` varchar(50) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzcj_sun_userformid','gid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_userformid')." ADD   `gid` int(11) DEFAULT NULL COMMENT '关联的项目id'");}
if(!pdo_fieldexists('yzcj_sun_userformid','state')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_userformid')." ADD   `state` int(11) DEFAULT NULL COMMENT '发起用户为1，参与用户为2'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcj_sun_withdrawal` (
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

");

if(!pdo_fieldexists('yzcj_sun_withdrawal','id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','name')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `name` varchar(10) NOT NULL COMMENT '真实姓名'");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','username')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `username` varchar(100) NOT NULL COMMENT '账号'");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','type')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `type` int(11) NOT NULL COMMENT '1支付宝 2.微信 3.银行'");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `time` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','sh_time')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','state')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `state` int(11) NOT NULL COMMENT '1.待审核 2.通过  3.拒绝'");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','tx_cost')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','sj_cost')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额'");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcj_sun_withdrawal','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcj_sun_withdrawal')." ADD   `uniacid` int(11) NOT NULL");}
