<?php
/**
 * 懒人源码www.lanrenzhijia.com
 */
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `simg` varchar(255) DEFAULT NULL COMMENT '顶部图片',
  `bimg` varchar(255) DEFAULT NULL COMMENT '奖品图片',
  `prize` varchar(255) DEFAULT NULL COMMENT '奖品名称',
  `share` int(11) DEFAULT NULL COMMENT '分享次数',
  `content` longtext COMMENT '活动规则',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `start_time` varchar(50) DEFAULT NULL COMMENT '开始时间',
  `end_time` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `link` varchar(255) DEFAULT NULL COMMENT '外链接',
  `total` int(11) DEFAULT '0' COMMENT '数量',
  `share_img` varchar(255) DEFAULT NULL COMMENT '分享图片',
  `is_total` int(11) DEFAULT '0' COMMENT '已集齐数量',
  `share_type` int(11) DEFAULT '1' COMMENT '分享类型（1分享2分享点击）',
  `type` int(11) DEFAULT '1' COMMENT '类型（1集卡2刮刮卡）',
  `list` longtext COMMENT '奖品',
  `gua_img` varchar(255) DEFAULT NULL COMMENT '刮刮卡图片',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠活动';

");

if(!pdo_fieldexists('xc_train_active','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_active','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_active','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_active','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '顶部图片'");}
if(!pdo_fieldexists('xc_train_active','bimg')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `bimg` varchar(255) DEFAULT NULL COMMENT '奖品图片'");}
if(!pdo_fieldexists('xc_train_active','prize')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `prize` varchar(255) DEFAULT NULL COMMENT '奖品名称'");}
if(!pdo_fieldexists('xc_train_active','share')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `share` int(11) DEFAULT NULL COMMENT '分享次数'");}
if(!pdo_fieldexists('xc_train_active','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `content` longtext COMMENT '活动规则'");}
if(!pdo_fieldexists('xc_train_active','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_active','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_active','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_active','start_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `start_time` varchar(50) DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('xc_train_active','end_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `end_time` varchar(50) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('xc_train_active','link')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `link` varchar(255) DEFAULT NULL COMMENT '外链接'");}
if(!pdo_fieldexists('xc_train_active','total')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `total` int(11) DEFAULT '0' COMMENT '数量'");}
if(!pdo_fieldexists('xc_train_active','share_img')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `share_img` varchar(255) DEFAULT NULL COMMENT '分享图片'");}
if(!pdo_fieldexists('xc_train_active','is_total')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `is_total` int(11) DEFAULT '0' COMMENT '已集齐数量'");}
if(!pdo_fieldexists('xc_train_active','share_type')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `share_type` int(11) DEFAULT '1' COMMENT '分享类型（1分享2分享点击）'");}
if(!pdo_fieldexists('xc_train_active','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型（1集卡2刮刮卡）'");}
if(!pdo_fieldexists('xc_train_active','list')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `list` longtext COMMENT '奖品'");}
if(!pdo_fieldexists('xc_train_active','gua_img')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   `gua_img` varchar(255) DEFAULT NULL COMMENT '刮刮卡图片'");}
if(!pdo_fieldexists('xc_train_active','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_active')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(50) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号',
  `sex` int(11) DEFAULT '1' COMMENT '性别',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `latitude` decimal(10,7) DEFAULT NULL COMMENT '经度',
  `longitude` decimal(10,7) DEFAULT NULL COMMENT '纬度',
  `content` longtext COMMENT '详情',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`openid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地址';

");

if(!pdo_fieldexists('xc_train_address','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `uniacid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_address','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_address','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('xc_train_address','mobile')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `mobile` varchar(50) DEFAULT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('xc_train_address','sex')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `sex` int(11) DEFAULT '1' COMMENT '性别'");}
if(!pdo_fieldexists('xc_train_address','address')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `address` varchar(255) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('xc_train_address','latitude')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `latitude` decimal(10,7) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('xc_train_address','longitude')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `longitude` decimal(10,7) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('xc_train_address','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `content` longtext COMMENT '详情'");}
if(!pdo_fieldexists('xc_train_address','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_address','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_address','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_address')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '电话',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1审核中1审核通过2失败3失败已阅）',
  `createtime` datetime DEFAULT NULL COMMENT '申请时间',
  `applytime` datetime DEFAULT NULL COMMENT '处理时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`,`applytime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='审核';

");

if(!pdo_fieldexists('xc_train_apply','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_apply')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_apply','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_apply')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_apply','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_apply')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_apply','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_apply')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('xc_train_apply','mobile')) {pdo_query("ALTER TABLE ".tablename('xc_train_apply')." ADD   `mobile` varchar(50) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('xc_train_apply','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_apply')." ADD   `status` int(11) DEFAULT '-1' COMMENT '状态（-1审核中1审核通过2失败3失败已阅）'");}
if(!pdo_fieldexists('xc_train_apply','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_apply')." ADD   `createtime` datetime DEFAULT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('xc_train_apply','applytime')) {pdo_query("ALTER TABLE ".tablename('xc_train_apply')." ADD   `applytime` datetime DEFAULT NULL COMMENT '处理时间'");}
if(!pdo_fieldexists('xc_train_apply','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_apply')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext COMMENT '详情',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT NULL COMMENT '类型（1普通文章2优惠活动文章）',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `btn` varchar(255) DEFAULT NULL COMMENT '按钮文字',
  `link_type` int(11) DEFAULT '1' COMMENT '模式',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章';

");

if(!pdo_fieldexists('xc_train_article','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_article','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_article','title')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_article','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD   `content` longtext COMMENT '详情'");}
if(!pdo_fieldexists('xc_train_article','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_article','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD   `type` int(11) DEFAULT NULL COMMENT '类型（1普通文章2优惠活动文章）'");}
if(!pdo_fieldexists('xc_train_article','link')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD   `link` varchar(255) DEFAULT NULL COMMENT '链接'");}
if(!pdo_fieldexists('xc_train_article','btn')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD   `btn` varchar(255) DEFAULT NULL COMMENT '按钮文字'");}
if(!pdo_fieldexists('xc_train_article','link_type')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD   `link_type` int(11) DEFAULT '1' COMMENT '模式'");}
if(!pdo_fieldexists('xc_train_article','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_article')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_audio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '标题',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格',
  `member` int(11) DEFAULT NULL COMMENT '集数',
  `sold` int(11) DEFAULT '0' COMMENT '销售数',
  `mark` int(11) DEFAULT '0' COMMENT '收藏人数',
  `code` varchar(255) DEFAULT NULL COMMENT '二维码',
  `content` longtext COMMENT '详情',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`cid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='音频';

");

if(!pdo_fieldexists('xc_train_audio','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_audio','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_audio','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('xc_train_audio','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `cid` int(11) DEFAULT NULL COMMENT '分类'");}
if(!pdo_fieldexists('xc_train_audio','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '封面'");}
if(!pdo_fieldexists('xc_train_audio','price')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格'");}
if(!pdo_fieldexists('xc_train_audio','member')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `member` int(11) DEFAULT NULL COMMENT '集数'");}
if(!pdo_fieldexists('xc_train_audio','sold')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `sold` int(11) DEFAULT '0' COMMENT '销售数'");}
if(!pdo_fieldexists('xc_train_audio','mark')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `mark` int(11) DEFAULT '0' COMMENT '收藏人数'");}
if(!pdo_fieldexists('xc_train_audio','code')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `code` varchar(255) DEFAULT NULL COMMENT '二维码'");}
if(!pdo_fieldexists('xc_train_audio','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `content` longtext COMMENT '详情'");}
if(!pdo_fieldexists('xc_train_audio','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_audio','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_audio','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `createtime` datetime DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_audio','share_one')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销'");}
if(!pdo_fieldexists('xc_train_audio','share_two')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销'");}
if(!pdo_fieldexists('xc_train_audio','share_three')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销'");}
if(!pdo_fieldexists('xc_train_audio','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_audio_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `audio` varchar(255) DEFAULT NULL COMMENT '音频',
  `click` int(11) DEFAULT '0' COMMENT '点击数',
  `try` int(11) DEFAULT '-1' COMMENT '试听',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='音频';

");

if(!pdo_fieldexists('xc_train_audio_item','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_audio_item','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_audio_item','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_audio_item','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `pid` int(11) DEFAULT NULL COMMENT '课程id'");}
if(!pdo_fieldexists('xc_train_audio_item','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '封面'");}
if(!pdo_fieldexists('xc_train_audio_item','audio')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `audio` varchar(255) DEFAULT NULL COMMENT '音频'");}
if(!pdo_fieldexists('xc_train_audio_item','click')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `click` int(11) DEFAULT '0' COMMENT '点击数'");}
if(!pdo_fieldexists('xc_train_audio_item','try')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `try` int(11) DEFAULT '-1' COMMENT '试听'");}
if(!pdo_fieldexists('xc_train_audio_item','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_audio_item','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_audio_item','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   `createtime` datetime DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_audio_item','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_audio_item')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `bimg` varchar(255) DEFAULT NULL COMMENT '图片',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='轮播图';

");

if(!pdo_fieldexists('xc_train_banner','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_banner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_banner')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_banner','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_banner')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_banner','bimg')) {pdo_query("ALTER TABLE ".tablename('xc_train_banner')." ADD   `bimg` varchar(255) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('xc_train_banner','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_banner')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_banner','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_banner')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_banner','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_banner')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_banner','link')) {pdo_query("ALTER TABLE ".tablename('xc_train_banner')." ADD   `link` varchar(255) DEFAULT NULL COMMENT '链接'");}
if(!pdo_fieldexists('xc_train_banner','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_banner')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `xkey` varchar(50) DEFAULT NULL COMMENT '关键字',
  `content` longtext COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`xkey`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='配置';

");

if(!pdo_fieldexists('xc_train_config','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_config')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_config','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_config')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_config','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_config')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('xc_train_config','xkey')) {pdo_query("ALTER TABLE ".tablename('xc_train_config')." ADD   `xkey` varchar(50) DEFAULT NULL COMMENT '关键字'");}
if(!pdo_fieldexists('xc_train_config','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_config')." ADD   `content` longtext COMMENT '内容'");}
if(!pdo_fieldexists('xc_train_config','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_config')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '优惠价格',
  `condition` varchar(50) DEFAULT NULL COMMENT '满足条件',
  `times` longtext COMMENT '有效期',
  `total` int(11) DEFAULT '-1' COMMENT '总量',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='优惠券';

");

if(!pdo_fieldexists('xc_train_coupon','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_coupon','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '优惠价格'");}
if(!pdo_fieldexists('xc_train_coupon','condition')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD   `condition` varchar(50) DEFAULT NULL COMMENT '满足条件'");}
if(!pdo_fieldexists('xc_train_coupon','times')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD   `times` longtext COMMENT '有效期'");}
if(!pdo_fieldexists('xc_train_coupon','total')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD   `total` int(11) DEFAULT '-1' COMMENT '总量'");}
if(!pdo_fieldexists('xc_train_coupon','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_coupon','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_coupon','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_coupon','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_coupon')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_cut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `mark` varchar(255) DEFAULT NULL COMMENT '标记',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `is_member` int(11) DEFAULT '0' COMMENT '已有人数',
  `member` int(11) DEFAULT NULL COMMENT '人数',
  `join_member` int(11) DEFAULT '0' COMMENT '参与人数',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `cut_price` decimal(10,2) DEFAULT NULL COMMENT '最低价',
  `max_price` decimal(10,2) DEFAULT NULL COMMENT '砍价区间',
  `min_price` decimal(10,2) DEFAULT NULL COMMENT '砍价区间',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `link` text COMMENT '虚拟人数',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价';

");

if(!pdo_fieldexists('xc_train_cut','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_cut','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_cut','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `pid` int(11) DEFAULT NULL COMMENT '课程id'");}
if(!pdo_fieldexists('xc_train_cut','mark')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `mark` varchar(255) DEFAULT NULL COMMENT '标记'");}
if(!pdo_fieldexists('xc_train_cut','end_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `end_time` datetime DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('xc_train_cut','is_member')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `is_member` int(11) DEFAULT '0' COMMENT '已有人数'");}
if(!pdo_fieldexists('xc_train_cut','member')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `member` int(11) DEFAULT NULL COMMENT '人数'");}
if(!pdo_fieldexists('xc_train_cut','join_member')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `join_member` int(11) DEFAULT '0' COMMENT '参与人数'");}
if(!pdo_fieldexists('xc_train_cut','price')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `price` decimal(10,2) DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('xc_train_cut','cut_price')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `cut_price` decimal(10,2) DEFAULT NULL COMMENT '最低价'");}
if(!pdo_fieldexists('xc_train_cut','max_price')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `max_price` decimal(10,2) DEFAULT NULL COMMENT '砍价区间'");}
if(!pdo_fieldexists('xc_train_cut','min_price')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `min_price` decimal(10,2) DEFAULT NULL COMMENT '砍价区间'");}
if(!pdo_fieldexists('xc_train_cut','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_cut','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_cut','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_cut','link')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   `link` text COMMENT '虚拟人数'");}
if(!pdo_fieldexists('xc_train_cut','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_cut_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL COMMENT '砍去的价格',
  `cut_openid` varchar(50) DEFAULT NULL COMMENT '帮砍的用户id',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`cid`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价记录';

");

if(!pdo_fieldexists('xc_train_cut_log','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_cut_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_cut_log','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_log')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_cut_log','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_log')." ADD   `cid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_cut_log','price')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_log')." ADD   `price` decimal(10,2) DEFAULT NULL COMMENT '砍去的价格'");}
if(!pdo_fieldexists('xc_train_cut_log','cut_openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_log')." ADD   `cut_openid` varchar(50) DEFAULT NULL COMMENT '帮砍的用户id'");}
if(!pdo_fieldexists('xc_train_cut_log','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_log')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_cut_log','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_log')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_cut_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `is_min` int(11) DEFAULT '-1' COMMENT '最低价',
  `status` int(11) DEFAULT '-1' COMMENT '购买状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`is_min`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价订单';

");

if(!pdo_fieldexists('xc_train_cut_order','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_cut_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_cut_order','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_order')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_cut_order','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_order')." ADD   `cid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_cut_order','price')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_order')." ADD   `price` decimal(10,2) DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('xc_train_cut_order','is_min')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_order')." ADD   `is_min` int(11) DEFAULT '-1' COMMENT '最低价'");}
if(!pdo_fieldexists('xc_train_cut_order','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_order')." ADD   `status` int(11) DEFAULT '-1' COMMENT '购买状态'");}
if(!pdo_fieldexists('xc_train_cut_order','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_order')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_cut_order','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_cut_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_discuss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `content` longtext COMMENT '详情',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1课程2视频）',
  `reply_status` int(11) DEFAULT '-1' COMMENT '回复状态',
  `reply_content` longtext COMMENT '回复内容',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论';

");

if(!pdo_fieldexists('xc_train_discuss','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_discuss','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_discuss','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_discuss','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   `pid` int(11) DEFAULT NULL COMMENT '课程id'");}
if(!pdo_fieldexists('xc_train_discuss','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   `content` longtext COMMENT '详情'");}
if(!pdo_fieldexists('xc_train_discuss','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_discuss','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_discuss','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型（1课程2视频）'");}
if(!pdo_fieldexists('xc_train_discuss','reply_status')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   `reply_status` int(11) DEFAULT '-1' COMMENT '回复状态'");}
if(!pdo_fieldexists('xc_train_discuss','reply_content')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   `reply_content` longtext COMMENT '回复内容'");}
if(!pdo_fieldexists('xc_train_discuss','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_discuss')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '团长',
  `service` int(11) DEFAULT NULL COMMENT '产品id',
  `is_member` int(11) DEFAULT '0' COMMENT '已有人数',
  `member` int(11) DEFAULT NULL COMMENT '所需人数',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '开团时间',
  `failtime` datetime DEFAULT NULL COMMENT '结束时间',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1拼团中1拼团成功2已失败）',
  `group` longtext COMMENT '团成员',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`,`failtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购';

");

if(!pdo_fieldexists('xc_train_group','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_group','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_group','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '团长'");}
if(!pdo_fieldexists('xc_train_group','service')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   `service` int(11) DEFAULT NULL COMMENT '产品id'");}
if(!pdo_fieldexists('xc_train_group','is_member')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   `is_member` int(11) DEFAULT '0' COMMENT '已有人数'");}
if(!pdo_fieldexists('xc_train_group','member')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   `member` int(11) DEFAULT NULL COMMENT '所需人数'");}
if(!pdo_fieldexists('xc_train_group','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '开团时间'");}
if(!pdo_fieldexists('xc_train_group','failtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   `failtime` datetime DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('xc_train_group','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   `status` int(11) DEFAULT '-1' COMMENT '状态（-1拼团中1拼团成功2已失败）'");}
if(!pdo_fieldexists('xc_train_group','group')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   `group` longtext COMMENT '团成员'");}
if(!pdo_fieldexists('xc_train_group','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_group')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_group_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `service` int(11) DEFAULT NULL COMMENT '课程id',
  `member_on` int(11) DEFAULT '0' COMMENT '已有人数',
  `member` int(11) DEFAULT '0' COMMENT '人数',
  `group_price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `failtime` datetime DEFAULT NULL COMMENT '失败时间',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1拼团中1成功2失败）',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购课程';

");

if(!pdo_fieldexists('xc_train_group_service','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_group_service','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_group_service','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_group_service','service')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   `service` int(11) DEFAULT NULL COMMENT '课程id'");}
if(!pdo_fieldexists('xc_train_group_service','member_on')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   `member_on` int(11) DEFAULT '0' COMMENT '已有人数'");}
if(!pdo_fieldexists('xc_train_group_service','member')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   `member` int(11) DEFAULT '0' COMMENT '人数'");}
if(!pdo_fieldexists('xc_train_group_service','group_price')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   `group_price` decimal(10,2) DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('xc_train_group_service','failtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   `failtime` datetime DEFAULT NULL COMMENT '失败时间'");}
if(!pdo_fieldexists('xc_train_group_service','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   `status` int(11) DEFAULT '-1' COMMENT '状态（-1拼团中1成功2失败）'");}
if(!pdo_fieldexists('xc_train_group_service','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   `createtime` datetime DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_group_service','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_group_service')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_gua` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `bimg` varchar(255) DEFAULT NULL COMMENT '图片',
  `times` int(11) DEFAULT NULL COMMENT '概率',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='奖品';

");

if(!pdo_fieldexists('xc_train_gua','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_gua')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_gua','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_gua')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_gua','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_gua')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_gua','bimg')) {pdo_query("ALTER TABLE ".tablename('xc_train_gua')." ADD   `bimg` varchar(255) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('xc_train_gua','times')) {pdo_query("ALTER TABLE ".tablename('xc_train_gua')." ADD   `times` int(11) DEFAULT NULL COMMENT '概率'");}
if(!pdo_fieldexists('xc_train_gua','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_gua')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_gua','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_gua')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `pid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '状态',
  `createtime` datetime DEFAULT NULL COMMENT '时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1音频2视频）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='历史';

");

if(!pdo_fieldexists('xc_train_history','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_history')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_history','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_history')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_history','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_history')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_history','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_history')." ADD   `pid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_history','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_history')." ADD   `status` int(11) DEFAULT NULL COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_history','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_history')." ADD   `createtime` datetime DEFAULT NULL COMMENT '时间'");}
if(!pdo_fieldexists('xc_train_history','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_history')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型（1音频2视频）'");}
if(!pdo_fieldexists('xc_train_history','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_history')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `simg` varchar(255) DEFAULT NULL COMMENT '图片',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `click` int(11) DEFAULT '0' COMMENT '浏览量',
  `video` longtext COMMENT '视频',
  `audio` longtext COMMENT '音频',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `content` longtext COMMENT '详情',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='礼包';

");

if(!pdo_fieldexists('xc_train_line','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_line','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_line','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_line','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `cid` int(11) DEFAULT NULL COMMENT '分类'");}
if(!pdo_fieldexists('xc_train_line','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('xc_train_line','price')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格'");}
if(!pdo_fieldexists('xc_train_line','start_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `start_time` datetime DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('xc_train_line','end_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `end_time` datetime DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('xc_train_line','click')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `click` int(11) DEFAULT '0' COMMENT '浏览量'");}
if(!pdo_fieldexists('xc_train_line','video')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `video` longtext COMMENT '视频'");}
if(!pdo_fieldexists('xc_train_line','audio')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `audio` longtext COMMENT '音频'");}
if(!pdo_fieldexists('xc_train_line','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_line','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_line','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `content` longtext COMMENT '详情'");}
if(!pdo_fieldexists('xc_train_line','share_one')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销'");}
if(!pdo_fieldexists('xc_train_line','share_two')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销'");}
if(!pdo_fieldexists('xc_train_line','share_three')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销'");}
if(!pdo_fieldexists('xc_train_line','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   `createtime` datetime DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_line','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_line')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_line_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `line` int(11) DEFAULT NULL COMMENT '礼包id',
  `type` int(11) DEFAULT NULL COMMENT '类型（1视频2音频）',
  `pid` int(11) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`type`,`pid`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购买记录';

");

if(!pdo_fieldexists('xc_train_line_order','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_line_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_line_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_line_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_line_order','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_line_order')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_line_order','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('xc_train_line_order')." ADD   `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('xc_train_line_order','line')) {pdo_query("ALTER TABLE ".tablename('xc_train_line_order')." ADD   `line` int(11) DEFAULT NULL COMMENT '礼包id'");}
if(!pdo_fieldexists('xc_train_line_order','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_line_order')." ADD   `type` int(11) DEFAULT NULL COMMENT '类型（1视频2音频）'");}
if(!pdo_fieldexists('xc_train_line_order','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_line_order')." ADD   `pid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_line_order','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_line_order')." ADD   `createtime` datetime DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_line_order','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_line_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL COMMENT '用户id',
  `plan_date` varchar(50) DEFAULT NULL COMMENT '日期',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志';

");

if(!pdo_fieldexists('xc_train_login_log','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_login_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_login_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_login_log')." ADD   `uniacid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_login_log','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_login_log')." ADD   `openid` varchar(255) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_login_log','plan_date')) {pdo_query("ALTER TABLE ".tablename('xc_train_login_log')." ADD   `plan_date` varchar(50) DEFAULT NULL COMMENT '日期'");}
if(!pdo_fieldexists('xc_train_login_log','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_login_log')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_mall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `title` varchar(255) DEFAULT NULL COMMENT '副标题',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `bimg` longtext,
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `format` longtext COMMENT '多规格',
  `sold` int(11) DEFAULT '0',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `content` longtext COMMENT '详情',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1无2团购3限时抢购）',
  `start_time` varchar(50) DEFAULT NULL COMMENT '开始时间',
  `end_time` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `group_member` int(11) DEFAULT NULL COMMENT '团购人数',
  `group_fail` int(11) DEFAULT NULL COMMENT '团购失败时间',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商城';

");

if(!pdo_fieldexists('xc_train_mall','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_mall','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_mall','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_mall','title')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '副标题'");}
if(!pdo_fieldexists('xc_train_mall','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `cid` int(11) DEFAULT NULL COMMENT '分类'");}
if(!pdo_fieldexists('xc_train_mall','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '封面'");}
if(!pdo_fieldexists('xc_train_mall','bimg')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `bimg` longtext");}
if(!pdo_fieldexists('xc_train_mall','price')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `price` decimal(10,2) DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('xc_train_mall','format')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `format` longtext COMMENT '多规格'");}
if(!pdo_fieldexists('xc_train_mall','sold')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `sold` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('xc_train_mall','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_mall','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_mall','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `content` longtext COMMENT '详情'");}
if(!pdo_fieldexists('xc_train_mall','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_mall','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型（1无2团购3限时抢购）'");}
if(!pdo_fieldexists('xc_train_mall','start_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `start_time` varchar(50) DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('xc_train_mall','end_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `end_time` varchar(50) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('xc_train_mall','group_member')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `group_member` int(11) DEFAULT NULL COMMENT '团购人数'");}
if(!pdo_fieldexists('xc_train_mall','group_fail')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `group_fail` int(11) DEFAULT NULL COMMENT '团购失败时间'");}
if(!pdo_fieldexists('xc_train_mall','share_one')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销'");}
if(!pdo_fieldexists('xc_train_mall','share_two')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销'");}
if(!pdo_fieldexists('xc_train_mall','share_three')) {pdo_query("ALTER TABLE ".tablename('xc_train_mall')." ADD   `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `pid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` datetime DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏';

");

if(!pdo_fieldexists('xc_train_mark','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_mark')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_mark','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_mark')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_mark','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_mark')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_mark','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_mark')." ADD   `pid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_mark','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_mark')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_mark','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_mark')." ADD   `createtime` datetime DEFAULT NULL COMMENT '时间'");}
if(!pdo_fieldexists('xc_train_mark','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_mark')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_moban_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `nickname` varchar(500) DEFAULT NULL COMMENT '呢称',
  `status` int(11) DEFAULT '-1' COMMENT '-1未使用  1已使用',
  `createtime` int(11) DEFAULT NULL COMMENT '发布日期',
  `ident` varchar(50) DEFAULT NULL COMMENT '标识',
  `headimgurl` varchar(500) DEFAULT NULL COMMENT '头像',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='绑定模版消息用户';

");

if(!pdo_fieldexists('xc_train_moban_user','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_moban_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_moban_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_moban_user')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_moban_user','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_moban_user')." ADD   `openid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_moban_user','nickname')) {pdo_query("ALTER TABLE ".tablename('xc_train_moban_user')." ADD   `nickname` varchar(500) DEFAULT NULL COMMENT '呢称'");}
if(!pdo_fieldexists('xc_train_moban_user','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_moban_user')." ADD   `status` int(11) DEFAULT '-1' COMMENT '-1未使用  1已使用'");}
if(!pdo_fieldexists('xc_train_moban_user','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_moban_user')." ADD   `createtime` int(11) DEFAULT NULL COMMENT '发布日期'");}
if(!pdo_fieldexists('xc_train_moban_user','ident')) {pdo_query("ALTER TABLE ".tablename('xc_train_moban_user')." ADD   `ident` varchar(50) DEFAULT NULL COMMENT '标识'");}
if(!pdo_fieldexists('xc_train_moban_user','headimgurl')) {pdo_query("ALTER TABLE ".tablename('xc_train_moban_user')." ADD   `headimgurl` varchar(500) DEFAULT NULL COMMENT '头像'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `simg` varchar(255) DEFAULT NULL COMMENT '图片',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1链接2客服）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自定义导航';

");

if(!pdo_fieldexists('xc_train_nav','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_nav','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_nav','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_nav','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('xc_train_nav','link')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD   `link` varchar(255) DEFAULT NULL COMMENT '链接'");}
if(!pdo_fieldexists('xc_train_nav','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_nav','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_nav','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_nav','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型（1链接2客服）'");}
if(!pdo_fieldexists('xc_train_nav','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_nav')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `short_info` longtext COMMENT '简介',
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `index` int(11) DEFAULT '-1' COMMENT '首页显示',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新闻';

");

if(!pdo_fieldexists('xc_train_news','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_news','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_news','title')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `title` varchar(50) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('xc_train_news','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '封面'");}
if(!pdo_fieldexists('xc_train_news','short_info')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `short_info` longtext COMMENT '简介'");}
if(!pdo_fieldexists('xc_train_news','link')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `link` varchar(255) DEFAULT NULL COMMENT '链接'");}
if(!pdo_fieldexists('xc_train_news','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_news','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_news','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_news','index')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `index` int(11) DEFAULT '-1' COMMENT '首页显示'");}
if(!pdo_fieldexists('xc_train_news','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   `cid` int(11) DEFAULT NULL COMMENT '分类'");}
if(!pdo_fieldexists('xc_train_news','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_news')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `member` int(11) DEFAULT NULL COMMENT '未读条数',
  `type` int(11) DEFAULT NULL COMMENT '类型',
  `content` longtext COMMENT '内容',
  `updatetime` varchar(50) DEFAULT NULL COMMENT '更新时间',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`createtime`,`member`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客服';

");

if(!pdo_fieldexists('xc_train_online','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_online')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_online','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_online')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_online','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_online')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_online','member')) {pdo_query("ALTER TABLE ".tablename('xc_train_online')." ADD   `member` int(11) DEFAULT NULL COMMENT '未读条数'");}
if(!pdo_fieldexists('xc_train_online','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_online')." ADD   `type` int(11) DEFAULT NULL COMMENT '类型'");}
if(!pdo_fieldexists('xc_train_online','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_online')." ADD   `content` longtext COMMENT '内容'");}
if(!pdo_fieldexists('xc_train_online','updatetime')) {pdo_query("ALTER TABLE ".tablename('xc_train_online')." ADD   `updatetime` varchar(50) DEFAULT NULL COMMENT '更新时间'");}
if(!pdo_fieldexists('xc_train_online','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_online')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_online','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_online')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_online_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '发送者用户id',
  `type` int(11) DEFAULT NULL COMMENT '类型1文本2图片',
  `content` longtext COMMENT '内容',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `duty` int(11) DEFAULT '1' COMMENT '身份1客户2客服',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`type`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客服记录';

");

if(!pdo_fieldexists('xc_train_online_log','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_online_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_online_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_online_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_online_log','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_online_log')." ADD   `pid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_online_log','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_online_log')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '发送者用户id'");}
if(!pdo_fieldexists('xc_train_online_log','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_online_log')." ADD   `type` int(11) DEFAULT NULL COMMENT '类型1文本2图片'");}
if(!pdo_fieldexists('xc_train_online_log','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_online_log')." ADD   `content` longtext COMMENT '内容'");}
if(!pdo_fieldexists('xc_train_online_log','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_online_log')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_online_log','duty')) {pdo_query("ALTER TABLE ".tablename('xc_train_online_log')." ADD   `duty` int(11) DEFAULT '1' COMMENT '身份1客户2客服'");}
if(!pdo_fieldexists('xc_train_online_log','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_online_log')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `wx_out_trade_no` varchar(50) DEFAULT NULL COMMENT '微信订单号',
  `pid` int(11) DEFAULT NULL COMMENT '开课id',
  `order_type` int(11) DEFAULT NULL COMMENT '订单类型（1报名2预约）',
  `total` int(11) DEFAULT '0' COMMENT '数量',
  `amount` varchar(50) DEFAULT NULL COMMENT '金额',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '电话',
  `status` int(11) DEFAULT '-1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `form_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `mobile2` varchar(50) DEFAULT NULL COMMENT '备用电话',
  `o_amount` varchar(50) DEFAULT NULL COMMENT '实付金额',
  `coupon_id` int(11) DEFAULT NULL COMMENT '优惠券id',
  `coupon_price` varchar(50) DEFAULT NULL COMMENT '优惠金额',
  `use` int(11) DEFAULT '-1' COMMENT '使用状态',
  `content` longtext COMMENT '备注',
  `store` int(11) DEFAULT NULL COMMENT '校区',
  `can_use` int(11) DEFAULT '1' COMMENT '核销次数',
  `is_use` int(11) DEFAULT '0' COMMENT '已核销次数',
  `use_time` longtext COMMENT '核销时间',
  `cut_status` int(11) DEFAULT '-1' COMMENT '砍价',
  `userinfo` longtext COMMENT '用户信息',
  `format` varchar(255) DEFAULT NULL COMMENT '规格',
  `order_status` int(11) DEFAULT '-1' COMMENT '-1未发货1未收货2完成',
  `tui_status` int(11) DEFAULT '-1' COMMENT '退款状态（-1未退款1退款）',
  `tui_content` longtext COMMENT '退款原因',
  `mall_type` int(11) DEFAULT '1' COMMENT '商城订单类型（1无2团购3限时）',
  `group_id` int(11) DEFAULT NULL COMMENT '团购id',
  `group_status` int(11) DEFAULT '-1' COMMENT '团购状态（-1拼团中1成功2失败）',
  `tui` varchar(255) DEFAULT NULL COMMENT '推荐人',
  `pei_type` int(11) DEFAULT '1' COMMENT '配送方式（1商家配送2自提）',
  `fee` varchar(50) DEFAULT NULL COMMENT '运费',
  `sign` longtext,
  `share_one_openid` varchar(50) DEFAULT NULL COMMENT '一级分销用户',
  `share_one_fee` varchar(50) DEFAULT NULL COMMENT '一级分销佣金',
  `share_two_openid` varchar(50) DEFAULT NULL COMMENT '二级分销用户',
  `share_two_fee` varchar(50) DEFAULT NULL COMMENT '二级分销佣金',
  `share_three_openid` varchar(50) DEFAULT NULL COMMENT '三级分销用户',
  `share_three_fee` varchar(50) DEFAULT NULL COMMENT '三级分销佣金',
  `line_name` varchar(50) DEFAULT NULL COMMENT '礼包名称',
  `line_img` varchar(255) DEFAULT NULL COMMENT '礼包图片',
  `line_data` longtext COMMENT '礼包数据',
  `group_member` int(11) DEFAULT NULL COMMENT '团购人数',
  `group_price` varchar(50) DEFAULT NULL COMMENT '团购价格',
  `group_end` datetime DEFAULT NULL COMMENT '团购结束时间',
  `group_data` longtext COMMENT '团购数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单';

");

if(!pdo_fieldexists('xc_train_order','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_order','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_order','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('xc_train_order','wx_out_trade_no')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `wx_out_trade_no` varchar(50) DEFAULT NULL COMMENT '微信订单号'");}
if(!pdo_fieldexists('xc_train_order','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `pid` int(11) DEFAULT NULL COMMENT '开课id'");}
if(!pdo_fieldexists('xc_train_order','order_type')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `order_type` int(11) DEFAULT NULL COMMENT '订单类型（1报名2预约）'");}
if(!pdo_fieldexists('xc_train_order','total')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `total` int(11) DEFAULT '0' COMMENT '数量'");}
if(!pdo_fieldexists('xc_train_order','amount')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `amount` varchar(50) DEFAULT NULL COMMENT '金额'");}
if(!pdo_fieldexists('xc_train_order','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('xc_train_order','mobile')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `mobile` varchar(50) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('xc_train_order','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `status` int(11) DEFAULT '-1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_order','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_order','form_id')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `form_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_order','title')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_order','mobile2')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `mobile2` varchar(50) DEFAULT NULL COMMENT '备用电话'");}
if(!pdo_fieldexists('xc_train_order','o_amount')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `o_amount` varchar(50) DEFAULT NULL COMMENT '实付金额'");}
if(!pdo_fieldexists('xc_train_order','coupon_id')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `coupon_id` int(11) DEFAULT NULL COMMENT '优惠券id'");}
if(!pdo_fieldexists('xc_train_order','coupon_price')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `coupon_price` varchar(50) DEFAULT NULL COMMENT '优惠金额'");}
if(!pdo_fieldexists('xc_train_order','use')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `use` int(11) DEFAULT '-1' COMMENT '使用状态'");}
if(!pdo_fieldexists('xc_train_order','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `content` longtext COMMENT '备注'");}
if(!pdo_fieldexists('xc_train_order','store')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `store` int(11) DEFAULT NULL COMMENT '校区'");}
if(!pdo_fieldexists('xc_train_order','can_use')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `can_use` int(11) DEFAULT '1' COMMENT '核销次数'");}
if(!pdo_fieldexists('xc_train_order','is_use')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `is_use` int(11) DEFAULT '0' COMMENT '已核销次数'");}
if(!pdo_fieldexists('xc_train_order','use_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `use_time` longtext COMMENT '核销时间'");}
if(!pdo_fieldexists('xc_train_order','cut_status')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `cut_status` int(11) DEFAULT '-1' COMMENT '砍价'");}
if(!pdo_fieldexists('xc_train_order','userinfo')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `userinfo` longtext COMMENT '用户信息'");}
if(!pdo_fieldexists('xc_train_order','format')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `format` varchar(255) DEFAULT NULL COMMENT '规格'");}
if(!pdo_fieldexists('xc_train_order','order_status')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `order_status` int(11) DEFAULT '-1' COMMENT '-1未发货1未收货2完成'");}
if(!pdo_fieldexists('xc_train_order','tui_status')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `tui_status` int(11) DEFAULT '-1' COMMENT '退款状态（-1未退款1退款）'");}
if(!pdo_fieldexists('xc_train_order','tui_content')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `tui_content` longtext COMMENT '退款原因'");}
if(!pdo_fieldexists('xc_train_order','mall_type')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `mall_type` int(11) DEFAULT '1' COMMENT '商城订单类型（1无2团购3限时）'");}
if(!pdo_fieldexists('xc_train_order','group_id')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `group_id` int(11) DEFAULT NULL COMMENT '团购id'");}
if(!pdo_fieldexists('xc_train_order','group_status')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `group_status` int(11) DEFAULT '-1' COMMENT '团购状态（-1拼团中1成功2失败）'");}
if(!pdo_fieldexists('xc_train_order','tui')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `tui` varchar(255) DEFAULT NULL COMMENT '推荐人'");}
if(!pdo_fieldexists('xc_train_order','pei_type')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `pei_type` int(11) DEFAULT '1' COMMENT '配送方式（1商家配送2自提）'");}
if(!pdo_fieldexists('xc_train_order','fee')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `fee` varchar(50) DEFAULT NULL COMMENT '运费'");}
if(!pdo_fieldexists('xc_train_order','sign')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `sign` longtext");}
if(!pdo_fieldexists('xc_train_order','share_one_openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `share_one_openid` varchar(50) DEFAULT NULL COMMENT '一级分销用户'");}
if(!pdo_fieldexists('xc_train_order','share_one_fee')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `share_one_fee` varchar(50) DEFAULT NULL COMMENT '一级分销佣金'");}
if(!pdo_fieldexists('xc_train_order','share_two_openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `share_two_openid` varchar(50) DEFAULT NULL COMMENT '二级分销用户'");}
if(!pdo_fieldexists('xc_train_order','share_two_fee')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `share_two_fee` varchar(50) DEFAULT NULL COMMENT '二级分销佣金'");}
if(!pdo_fieldexists('xc_train_order','share_three_openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `share_three_openid` varchar(50) DEFAULT NULL COMMENT '三级分销用户'");}
if(!pdo_fieldexists('xc_train_order','share_three_fee')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `share_three_fee` varchar(50) DEFAULT NULL COMMENT '三级分销佣金'");}
if(!pdo_fieldexists('xc_train_order','line_name')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `line_name` varchar(50) DEFAULT NULL COMMENT '礼包名称'");}
if(!pdo_fieldexists('xc_train_order','line_img')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `line_img` varchar(255) DEFAULT NULL COMMENT '礼包图片'");}
if(!pdo_fieldexists('xc_train_order','line_data')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `line_data` longtext COMMENT '礼包数据'");}
if(!pdo_fieldexists('xc_train_order','group_member')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `group_member` int(11) DEFAULT NULL COMMENT '团购人数'");}
if(!pdo_fieldexists('xc_train_order','group_price')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `group_price` varchar(50) DEFAULT NULL COMMENT '团购价格'");}
if(!pdo_fieldexists('xc_train_order','group_end')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `group_end` datetime DEFAULT NULL COMMENT '团购结束时间'");}
if(!pdo_fieldexists('xc_train_order','group_data')) {pdo_query("ALTER TABLE ".tablename('xc_train_order')." ADD   `group_data` longtext COMMENT '团购数据'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `cid` int(11) DEFAULT NULL COMMENT '活动id',
  `status` int(11) DEFAULT '-1' COMMENT '状态',
  `use` int(11) DEFAULT '-1' COMMENT '使用状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `opengid` longtext COMMENT '分享的群id',
  `usetime` varchar(50) DEFAULT NULL COMMENT '使用时间',
  `prizetime` varchar(50) DEFAULT NULL COMMENT '获奖时间',
  `prize` varchar(50) DEFAULT NULL COMMENT '奖品',
  `type` int(11) DEFAULT '1',
  `pid` int(11) DEFAULT NULL COMMENT '奖品id',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`use`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='奖品记录';

");

if(!pdo_fieldexists('xc_train_prize','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_prize','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_prize','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_prize','title')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `title` varchar(50) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('xc_train_prize','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `cid` int(11) DEFAULT NULL COMMENT '活动id'");}
if(!pdo_fieldexists('xc_train_prize','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `status` int(11) DEFAULT '-1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_prize','use')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `use` int(11) DEFAULT '-1' COMMENT '使用状态'");}
if(!pdo_fieldexists('xc_train_prize','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_prize','opengid')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `opengid` longtext COMMENT '分享的群id'");}
if(!pdo_fieldexists('xc_train_prize','usetime')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `usetime` varchar(50) DEFAULT NULL COMMENT '使用时间'");}
if(!pdo_fieldexists('xc_train_prize','prizetime')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `prizetime` varchar(50) DEFAULT NULL COMMENT '获奖时间'");}
if(!pdo_fieldexists('xc_train_prize','prize')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `prize` varchar(50) DEFAULT NULL COMMENT '奖品'");}
if(!pdo_fieldexists('xc_train_prize','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `type` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('xc_train_prize','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   `pid` int(11) DEFAULT NULL COMMENT '奖品id'");}
if(!pdo_fieldexists('xc_train_prize','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_prize')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `simg` varchar(255) DEFAULT NULL COMMENT '图标',
  `mobile` varchar(50) DEFAULT NULL COMMENT '电话',
  `address` longtext COMMENT '地址',
  `map` longtext COMMENT '定位',
  `teacher` longtext COMMENT '教师',
  `plan_date` varchar(50) DEFAULT NULL COMMENT '营业时间',
  `content` longtext COMMENT '详情',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `longitude` decimal(10,7) DEFAULT NULL COMMENT '经度',
  `latitude` decimal(10,7) DEFAULT NULL COMMENT '纬度',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分校';

");

if(!pdo_fieldexists('xc_train_school','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_school','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_school','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_school','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '图标'");}
if(!pdo_fieldexists('xc_train_school','mobile')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `mobile` varchar(50) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('xc_train_school','address')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `address` longtext COMMENT '地址'");}
if(!pdo_fieldexists('xc_train_school','map')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `map` longtext COMMENT '定位'");}
if(!pdo_fieldexists('xc_train_school','teacher')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `teacher` longtext COMMENT '教师'");}
if(!pdo_fieldexists('xc_train_school','plan_date')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `plan_date` varchar(50) DEFAULT NULL COMMENT '营业时间'");}
if(!pdo_fieldexists('xc_train_school','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `content` longtext COMMENT '详情'");}
if(!pdo_fieldexists('xc_train_school','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_school','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_school','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_school','longitude')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `longitude` decimal(10,7) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('xc_train_school','latitude')) {pdo_query("ALTER TABLE ".tablename('xc_train_school')." ADD   `latitude` decimal(10,7) DEFAULT NULL COMMENT '纬度'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `bimg` varchar(255) DEFAULT NULL COMMENT '封面',
  `xueqi` varchar(50) DEFAULT NULL COMMENT '学期',
  `keshi` varchar(50) DEFAULT NULL COMMENT '课时',
  `price` varchar(50) DEFAULT NULL COMMENT '学费',
  `content` longtext COMMENT '课程内容',
  `teacher` longtext COMMENT '任课教师',
  `discuss` int(11) DEFAULT '0' COMMENT '评论数',
  `zan` int(11) DEFAULT '0' COMMENT '点赞数',
  `click` int(11) DEFAULT '0' COMMENT '浏览量',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `index` int(11) DEFAULT '-1' COMMENT '首页显示',
  `tui` int(11) DEFAULT '-1' COMMENT '推荐',
  `code` varchar(255) DEFAULT NULL COMMENT '二维码',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`,`index`,`tui`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='列表';

");

if(!pdo_fieldexists('xc_train_service','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_service','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_service','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_service','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `cid` int(11) DEFAULT NULL COMMENT '分类'");}
if(!pdo_fieldexists('xc_train_service','bimg')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `bimg` varchar(255) DEFAULT NULL COMMENT '封面'");}
if(!pdo_fieldexists('xc_train_service','xueqi')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `xueqi` varchar(50) DEFAULT NULL COMMENT '学期'");}
if(!pdo_fieldexists('xc_train_service','keshi')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `keshi` varchar(50) DEFAULT NULL COMMENT '课时'");}
if(!pdo_fieldexists('xc_train_service','price')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `price` varchar(50) DEFAULT NULL COMMENT '学费'");}
if(!pdo_fieldexists('xc_train_service','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `content` longtext COMMENT '课程内容'");}
if(!pdo_fieldexists('xc_train_service','teacher')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `teacher` longtext COMMENT '任课教师'");}
if(!pdo_fieldexists('xc_train_service','discuss')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `discuss` int(11) DEFAULT '0' COMMENT '评论数'");}
if(!pdo_fieldexists('xc_train_service','zan')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `zan` int(11) DEFAULT '0' COMMENT '点赞数'");}
if(!pdo_fieldexists('xc_train_service','click')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `click` int(11) DEFAULT '0' COMMENT '浏览量'");}
if(!pdo_fieldexists('xc_train_service','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_service','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_service','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_service','index')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `index` int(11) DEFAULT '-1' COMMENT '首页显示'");}
if(!pdo_fieldexists('xc_train_service','tui')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `tui` int(11) DEFAULT '-1' COMMENT '推荐'");}
if(!pdo_fieldexists('xc_train_service','code')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `code` varchar(255) DEFAULT NULL COMMENT '二维码'");}
if(!pdo_fieldexists('xc_train_service','share_one')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销'");}
if(!pdo_fieldexists('xc_train_service','share_two')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销'");}
if(!pdo_fieldexists('xc_train_service','share_three')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销'");}
if(!pdo_fieldexists('xc_train_service','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_service')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_service_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1课程2名师）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类';

");

if(!pdo_fieldexists('xc_train_service_class','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_class')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_service_class','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_class')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_service_class','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_class')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_service_class','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_class')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_service_class','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_class')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_service_class','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_class')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_service_class','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_class')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型（1课程2名师）'");}
if(!pdo_fieldexists('xc_train_service_class','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_class')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_service_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL COMMENT '课程',
  `mark` varchar(50) DEFAULT NULL COMMENT '标识',
  `simg` varchar(255) DEFAULT NULL COMMENT '封面',
  `bimg` longtext COMMENT '轮播图',
  `price` varchar(50) DEFAULT NULL COMMENT '原价',
  `format` longtext COMMENT '规格',
  `sold` int(11) DEFAULT '0' COMMENT '已团',
  `group_times` int(11) DEFAULT NULL COMMENT '团购时间',
  `member_on` int(11) DEFAULT '0' COMMENT '已有人数',
  `member` int(11) DEFAULT '0' COMMENT '人数',
  `end_time` datetime DEFAULT NULL COMMENT '截止时间',
  `click` int(11) DEFAULT '0' COMMENT '点击量',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `content` longtext COMMENT '详情',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购';

");

if(!pdo_fieldexists('xc_train_service_group','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_service_group','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_service_group','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `pid` int(11) DEFAULT NULL COMMENT '课程'");}
if(!pdo_fieldexists('xc_train_service_group','mark')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `mark` varchar(50) DEFAULT NULL COMMENT '标识'");}
if(!pdo_fieldexists('xc_train_service_group','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '封面'");}
if(!pdo_fieldexists('xc_train_service_group','bimg')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `bimg` longtext COMMENT '轮播图'");}
if(!pdo_fieldexists('xc_train_service_group','price')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `price` varchar(50) DEFAULT NULL COMMENT '原价'");}
if(!pdo_fieldexists('xc_train_service_group','format')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `format` longtext COMMENT '规格'");}
if(!pdo_fieldexists('xc_train_service_group','sold')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `sold` int(11) DEFAULT '0' COMMENT '已团'");}
if(!pdo_fieldexists('xc_train_service_group','group_times')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `group_times` int(11) DEFAULT NULL COMMENT '团购时间'");}
if(!pdo_fieldexists('xc_train_service_group','member_on')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `member_on` int(11) DEFAULT '0' COMMENT '已有人数'");}
if(!pdo_fieldexists('xc_train_service_group','member')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `member` int(11) DEFAULT '0' COMMENT '人数'");}
if(!pdo_fieldexists('xc_train_service_group','end_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `end_time` datetime DEFAULT NULL COMMENT '截止时间'");}
if(!pdo_fieldexists('xc_train_service_group','click')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `click` int(11) DEFAULT '0' COMMENT '点击量'");}
if(!pdo_fieldexists('xc_train_service_group','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_service_group','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_service_group','content')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `content` longtext COMMENT '详情'");}
if(!pdo_fieldexists('xc_train_service_group','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   `createtime` datetime DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_service_group','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_group')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_service_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `mark` varchar(50) DEFAULT NULL COMMENT '标识',
  `start_time` varchar(50) DEFAULT NULL COMMENT '开课时间',
  `end_time` varchar(50) DEFAULT NULL COMMENT '截止时间',
  `least_member` int(11) DEFAULT NULL COMMENT '最少人数',
  `more_member` int(11) DEFAULT NULL COMMENT '最多人数',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `member` int(11) DEFAULT '0' COMMENT '已有人数',
  `type` int(11) DEFAULT '1' COMMENT '类型',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课程';

");

if(!pdo_fieldexists('xc_train_service_team','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_service_team','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_service_team','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `pid` int(11) DEFAULT NULL COMMENT '课程id'");}
if(!pdo_fieldexists('xc_train_service_team','mark')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `mark` varchar(50) DEFAULT NULL COMMENT '标识'");}
if(!pdo_fieldexists('xc_train_service_team','start_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `start_time` varchar(50) DEFAULT NULL COMMENT '开课时间'");}
if(!pdo_fieldexists('xc_train_service_team','end_time')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `end_time` varchar(50) DEFAULT NULL COMMENT '截止时间'");}
if(!pdo_fieldexists('xc_train_service_team','least_member')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `least_member` int(11) DEFAULT NULL COMMENT '最少人数'");}
if(!pdo_fieldexists('xc_train_service_team','more_member')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `more_member` int(11) DEFAULT NULL COMMENT '最多人数'");}
if(!pdo_fieldexists('xc_train_service_team','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_service_team','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_service_team','member')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `member` int(11) DEFAULT '0' COMMENT '已有人数'");}
if(!pdo_fieldexists('xc_train_service_team','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型'");}
if(!pdo_fieldexists('xc_train_service_team','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_service_team')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_share_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `type` int(11) DEFAULT NULL COMMENT '分销等级',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '佣金',
  `order_amount` decimal(10,2) DEFAULT NULL COMMENT '订单金额',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1待结算1已结算2失效）',
  `share` varchar(50) DEFAULT NULL COMMENT '分销用户id',
  `createtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金订单';

");

if(!pdo_fieldexists('xc_train_share_order','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_share_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_share_order','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_share_order','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('xc_train_share_order','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   `type` int(11) DEFAULT NULL COMMENT '分销等级'");}
if(!pdo_fieldexists('xc_train_share_order','amount')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   `amount` decimal(10,2) DEFAULT NULL COMMENT '佣金'");}
if(!pdo_fieldexists('xc_train_share_order','order_amount')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   `order_amount` decimal(10,2) DEFAULT NULL COMMENT '订单金额'");}
if(!pdo_fieldexists('xc_train_share_order','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   `status` int(11) DEFAULT '-1' COMMENT '状态（-1待结算1已结算2失效）'");}
if(!pdo_fieldexists('xc_train_share_order','share')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   `share` varchar(50) DEFAULT NULL COMMENT '分销用户id'");}
if(!pdo_fieldexists('xc_train_share_order','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   `createtime` datetime DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_share_order','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_order')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_share_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号',
  `type` int(11) DEFAULT NULL COMMENT '提现方式（1微信2支付宝）',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '提现金额',
  `username` varchar(50) DEFAULT NULL COMMENT '账号',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号',
  `code` varchar(255) DEFAULT NULL COMMENT '收款码',
  `status` int(11) DEFAULT '-1' COMMENT '状态（-1待处理1成功2失败）',
  `createtime` datetime DEFAULT NULL COMMENT '申请时间',
  `applytime` datetime DEFAULT NULL COMMENT '处理时间',
  `fee` decimal(10,2) DEFAULT '0.00' COMMENT '手续费',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`type`,`out_trade_no`,`status`,`createtime`,`applytime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销提现';

");

if(!pdo_fieldexists('xc_train_share_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_share_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_share_withdraw','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_share_withdraw','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `out_trade_no` varchar(50) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('xc_train_share_withdraw','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `type` int(11) DEFAULT NULL COMMENT '提现方式（1微信2支付宝）'");}
if(!pdo_fieldexists('xc_train_share_withdraw','amount')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `amount` decimal(10,2) DEFAULT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('xc_train_share_withdraw','username')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `username` varchar(50) DEFAULT NULL COMMENT '账号'");}
if(!pdo_fieldexists('xc_train_share_withdraw','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('xc_train_share_withdraw','mobile')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `mobile` varchar(50) DEFAULT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('xc_train_share_withdraw','code')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `code` varchar(255) DEFAULT NULL COMMENT '收款码'");}
if(!pdo_fieldexists('xc_train_share_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `status` int(11) DEFAULT '-1' COMMENT '状态（-1待处理1成功2失败）'");}
if(!pdo_fieldexists('xc_train_share_withdraw','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `createtime` datetime DEFAULT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('xc_train_share_withdraw','applytime')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `applytime` datetime DEFAULT NULL COMMENT '处理时间'");}
if(!pdo_fieldexists('xc_train_share_withdraw','fee')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   `fee` decimal(10,2) DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('xc_train_share_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_share_withdraw')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名字',
  `simg` varchar(255) DEFAULT NULL COMMENT '头像',
  `task` varchar(255) DEFAULT NULL COMMENT '职称',
  `short_info` longtext COMMENT '简介',
  `pclass` longtext COMMENT '负责课程',
  `students` int(11) DEFAULT '0' COMMENT '学员数',
  `zan` int(11) DEFAULT '0' COMMENT '点赞数',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `content_type` int(11) DEFAULT '1' COMMENT '课程模式',
  `content2` longtext COMMENT '内容2',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='名师';

");

if(!pdo_fieldexists('xc_train_teacher','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_teacher','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_teacher','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名字'");}
if(!pdo_fieldexists('xc_train_teacher','simg')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `simg` varchar(255) DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('xc_train_teacher','task')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `task` varchar(255) DEFAULT NULL COMMENT '职称'");}
if(!pdo_fieldexists('xc_train_teacher','short_info')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `short_info` longtext COMMENT '简介'");}
if(!pdo_fieldexists('xc_train_teacher','pclass')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `pclass` longtext COMMENT '负责课程'");}
if(!pdo_fieldexists('xc_train_teacher','students')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `students` int(11) DEFAULT '0' COMMENT '学员数'");}
if(!pdo_fieldexists('xc_train_teacher','zan')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `zan` int(11) DEFAULT '0' COMMENT '点赞数'");}
if(!pdo_fieldexists('xc_train_teacher','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_teacher','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_teacher','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_teacher','content_type')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `content_type` int(11) DEFAULT '1' COMMENT '课程模式'");}
if(!pdo_fieldexists('xc_train_teacher','content2')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `content2` longtext COMMENT '内容2'");}
if(!pdo_fieldexists('xc_train_teacher','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   `cid` int(11) DEFAULT NULL COMMENT '分类'");}
if(!pdo_fieldexists('xc_train_teacher','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_teacher_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `tid` int(11) DEFAULT NULL COMMENT '名师id',
  `status` int(11) DEFAULT NULL COMMENT '状态（1学员2点赞）',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='名师记录';

");

if(!pdo_fieldexists('xc_train_teacher_log','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_teacher_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_teacher_log','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher_log')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_teacher_log','tid')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher_log')." ADD   `tid` int(11) DEFAULT NULL COMMENT '名师id'");}
if(!pdo_fieldexists('xc_train_teacher_log','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher_log')." ADD   `status` int(11) DEFAULT NULL COMMENT '状态（1学员2点赞）'");}
if(!pdo_fieldexists('xc_train_teacher_log','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher_log')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_teacher_log','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_teacher_log')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL COMMENT '优惠券id',
  `status` int(11) DEFAULT '-1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户优惠券';

");

if(!pdo_fieldexists('xc_train_user_coupon','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_user_coupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_user_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_user_coupon')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_user_coupon','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_user_coupon')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_user_coupon','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_user_coupon')." ADD   `cid` int(11) DEFAULT NULL COMMENT '优惠券id'");}
if(!pdo_fieldexists('xc_train_user_coupon','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_user_coupon')." ADD   `status` int(11) DEFAULT '-1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_user_coupon','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_user_coupon')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_user_coupon','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_user_coupon')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `nick` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `shop` int(11) DEFAULT '-1' COMMENT '管理中心绑定',
  `shop_id` int(11) DEFAULT NULL COMMENT '分校id',
  `share` varchar(50) DEFAULT NULL COMMENT '推荐人',
  `share_fee` decimal(10,2) DEFAULT '0.00' COMMENT '佣金',
  `share_code` varchar(255) DEFAULT NULL COMMENT '分销二维码',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`status`,`createtime`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='用户信息';

");

if(!pdo_fieldexists('xc_train_userinfo','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_userinfo','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_userinfo','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_userinfo','avatar')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `avatar` varchar(255) DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('xc_train_userinfo','nick')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `nick` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_userinfo','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_userinfo','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_userinfo','shop')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `shop` int(11) DEFAULT '-1' COMMENT '管理中心绑定'");}
if(!pdo_fieldexists('xc_train_userinfo','shop_id')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `shop_id` int(11) DEFAULT NULL COMMENT '分校id'");}
if(!pdo_fieldexists('xc_train_userinfo','share')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `share` varchar(50) DEFAULT NULL COMMENT '推荐人'");}
if(!pdo_fieldexists('xc_train_userinfo','share_fee')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `share_fee` decimal(10,2) DEFAULT '0.00' COMMENT '佣金'");}
if(!pdo_fieldexists('xc_train_userinfo','share_code')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   `share_code` varchar(255) DEFAULT NULL COMMENT '分销二维码'");}
if(!pdo_fieldexists('xc_train_userinfo','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_userinfo')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `video` varchar(255) DEFAULT NULL COMMENT '视频',
  `bimg` varchar(255) DEFAULT NULL COMMENT '封面',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `pid` int(11) DEFAULT NULL COMMENT '课程id',
  `cid` int(11) DEFAULT NULL COMMENT '分类',
  `teacher_id` int(11) DEFAULT NULL COMMENT '主讲教师',
  `teacher_name` varchar(50) DEFAULT NULL COMMENT '教师姓名',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型',
  `vid` varchar(50) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL COMMENT '链接',
  `click` int(11) DEFAULT '0' COMMENT '人气',
  `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销',
  `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销',
  `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`pid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='视频';

");

if(!pdo_fieldexists('xc_train_video','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_video','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_video','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_video','video')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `video` varchar(255) DEFAULT NULL COMMENT '视频'");}
if(!pdo_fieldexists('xc_train_video','bimg')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `bimg` varchar(255) DEFAULT NULL COMMENT '封面'");}
if(!pdo_fieldexists('xc_train_video','price')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `price` decimal(10,2) DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('xc_train_video','pid')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `pid` int(11) DEFAULT NULL COMMENT '课程id'");}
if(!pdo_fieldexists('xc_train_video','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `cid` int(11) DEFAULT NULL COMMENT '分类'");}
if(!pdo_fieldexists('xc_train_video','teacher_id')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `teacher_id` int(11) DEFAULT NULL COMMENT '主讲教师'");}
if(!pdo_fieldexists('xc_train_video','teacher_name')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `teacher_name` varchar(50) DEFAULT NULL COMMENT '教师姓名'");}
if(!pdo_fieldexists('xc_train_video','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_video','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_video','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_video','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型'");}
if(!pdo_fieldexists('xc_train_video','vid')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `vid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_video','link')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `link` varchar(255) DEFAULT NULL COMMENT '链接'");}
if(!pdo_fieldexists('xc_train_video','click')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `click` int(11) DEFAULT '0' COMMENT '人气'");}
if(!pdo_fieldexists('xc_train_video','share_one')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `share_one` varchar(50) DEFAULT NULL COMMENT '一级分销'");}
if(!pdo_fieldexists('xc_train_video','share_two')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `share_two` varchar(50) DEFAULT NULL COMMENT '二级分销'");}
if(!pdo_fieldexists('xc_train_video','share_three')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   `share_three` varchar(50) DEFAULT NULL COMMENT '三级分销'");}
if(!pdo_fieldexists('xc_train_video','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_video')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_video_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1视频2音频）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`sort`,`status`,`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='视频分来';

");

if(!pdo_fieldexists('xc_train_video_class','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_video_class')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_video_class','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_video_class')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_video_class','name')) {pdo_query("ALTER TABLE ".tablename('xc_train_video_class')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('xc_train_video_class','sort')) {pdo_query("ALTER TABLE ".tablename('xc_train_video_class')." ADD   `sort` int(11) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('xc_train_video_class','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_video_class')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_video_class','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_video_class')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_video_class','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_video_class')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型（1视频2音频）'");}
if(!pdo_fieldexists('xc_train_video_class','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_video_class')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_xc_train_zan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL COMMENT '课程',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type` int(11) DEFAULT '1' COMMENT '类型（1课程2礼包）',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`cid`,`status`,`createtime`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='点赞记录';

");

if(!pdo_fieldexists('xc_train_zan','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_zan')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('xc_train_zan','uniacid')) {pdo_query("ALTER TABLE ".tablename('xc_train_zan')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('xc_train_zan','openid')) {pdo_query("ALTER TABLE ".tablename('xc_train_zan')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('xc_train_zan','cid')) {pdo_query("ALTER TABLE ".tablename('xc_train_zan')." ADD   `cid` int(11) DEFAULT NULL COMMENT '课程'");}
if(!pdo_fieldexists('xc_train_zan','status')) {pdo_query("ALTER TABLE ".tablename('xc_train_zan')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态'");}
if(!pdo_fieldexists('xc_train_zan','createtime')) {pdo_query("ALTER TABLE ".tablename('xc_train_zan')." ADD   `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'");}
if(!pdo_fieldexists('xc_train_zan','type')) {pdo_query("ALTER TABLE ".tablename('xc_train_zan')." ADD   `type` int(11) DEFAULT '1' COMMENT '类型（1课程2礼包）'");}
if(!pdo_fieldexists('xc_train_zan','id')) {pdo_query("ALTER TABLE ".tablename('xc_train_zan')." ADD   PRIMARY KEY (`id`)");}
