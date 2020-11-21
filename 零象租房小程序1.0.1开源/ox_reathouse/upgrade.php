<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_banner` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(10) DEFAULT NULL COMMENT '小程序id',
  `img` varchar(100) DEFAULT NULL COMMENT '图片地址',
  `url` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  `type` tinyint(4) DEFAULT NULL COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1，正常，0，下架',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

");

if(!pdo_fieldexists('ox_reathouse_banner','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_banner')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reathouse_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_banner')." ADD   `uniacid` int(10) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_banner','img')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_banner')." ADD   `img` varchar(100) DEFAULT NULL COMMENT '图片地址'");}
if(!pdo_fieldexists('ox_reathouse_banner','url')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_banner')." ADD   `url` varchar(255) DEFAULT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('ox_reathouse_banner','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_banner')." ADD   `sort` int(10) DEFAULT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ox_reathouse_banner','type')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_banner')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '类型'");}
if(!pdo_fieldexists('ox_reathouse_banner','status')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_banner')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1，正常，0，下架'");}
if(!pdo_fieldexists('ox_reathouse_banner','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_banner')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_facility` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '设施名称',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标地址',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='设施表';

");

if(!pdo_fieldexists('ox_reathouse_facility','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_facility')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reathouse_facility','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_facility')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_facility','name')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_facility')." ADD   `name` varchar(255) NOT NULL DEFAULT '' COMMENT '设施名称'");}
if(!pdo_fieldexists('ox_reathouse_facility','icon')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_facility')." ADD   `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标地址'");}
if(!pdo_fieldexists('ox_reathouse_facility','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_facility')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_fav` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `hid` int(11) NOT NULL COMMENT '房屋id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='收藏表';

");

if(!pdo_fieldexists('ox_reathouse_fav','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_fav')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reathouse_fav','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_fav')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_fav','hid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_fav')." ADD   `hid` int(11) NOT NULL COMMENT '房屋id'");}
if(!pdo_fieldexists('ox_reathouse_fav','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_fav')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ox_reathouse_fav','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_fav')." ADD   `create_time` int(11) NOT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_house_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `name` varchar(255) DEFAULT NULL COMMENT '小区名称',
  `type_id` int(11) NOT NULL COMMENT '出租类型id 1整租 2合租 3民宿',
  `img_id` varchar(128) DEFAULT '' COMMENT '房屋图片id英文状态下,隔开',
  `facility_id` varchar(128) DEFAULT NULL COMMENT '房屋设施id英文状态下,隔开',
  `tag_id` varchar(128) DEFAULT NULL COMMENT '标签id英文状态下,隔开',
  `renovation` tinyint(4) DEFAULT '1' COMMENT '装修状态id 默认0精装 1简装 2毛坯',
  `floor1` tinyint(4) DEFAULT '1' COMMENT '楼层在第几层',
  `floor2` tinyint(4) DEFAULT NULL COMMENT '楼层 共多少层',
  `oriented_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '朝向id 默认0东 1南 2西 3北 4南北 5东西 6东南 7东北8西南 9西北',
  `house_type_shi` tinyint(4) DEFAULT NULL COMMENT '户型几室',
  `house_type_wei` tinyint(4) DEFAULT NULL COMMENT '户型几卫',
  `house_type_ting` tinyint(4) DEFAULT NULL COMMENT '户型几厅',
  `area` varchar(50) NOT NULL DEFAULT '' COMMENT '面积',
  `yafu_fu` tinyint(4) DEFAULT '1' COMMENT '押付方式 付几个月',
  `yafu_ya` tinyint(4) DEFAULT '1' COMMENT '押付方式 押几个月',
  `price` decimal(10,2) NOT NULL COMMENT '价格',
  `active_price` decimal(20,2) DEFAULT NULL COMMENT '活动价格',
  `address` varchar(255) DEFAULT '' COMMENT '地址',
  `desc` text COMMENT '房屋描述',
  `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(11) NOT NULL DEFAULT '2' COMMENT '状态 1，正常 0，已下架 2未发布完成（后台不显示）',
  `uid` int(11) DEFAULT NULL COMMENT '发布者id',
  `mapx` varchar(50) DEFAULT NULL,
  `mapy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ox_reathouse_house_info','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reathouse_house_info','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_house_info','name')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '小区名称'");}
if(!pdo_fieldexists('ox_reathouse_house_info','type_id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `type_id` int(11) NOT NULL COMMENT '出租类型id 1整租 2合租 3民宿'");}
if(!pdo_fieldexists('ox_reathouse_house_info','img_id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `img_id` varchar(128) DEFAULT '' COMMENT '房屋图片id英文状态下,隔开'");}
if(!pdo_fieldexists('ox_reathouse_house_info','facility_id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `facility_id` varchar(128) DEFAULT NULL COMMENT '房屋设施id英文状态下,隔开'");}
if(!pdo_fieldexists('ox_reathouse_house_info','tag_id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `tag_id` varchar(128) DEFAULT NULL COMMENT '标签id英文状态下,隔开'");}
if(!pdo_fieldexists('ox_reathouse_house_info','renovation')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `renovation` tinyint(4) DEFAULT '1' COMMENT '装修状态id 默认0精装 1简装 2毛坯'");}
if(!pdo_fieldexists('ox_reathouse_house_info','floor1')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `floor1` tinyint(4) DEFAULT '1' COMMENT '楼层在第几层'");}
if(!pdo_fieldexists('ox_reathouse_house_info','floor2')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `floor2` tinyint(4) DEFAULT NULL COMMENT '楼层 共多少层'");}
if(!pdo_fieldexists('ox_reathouse_house_info','oriented_id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `oriented_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '朝向id 默认0东 1南 2西 3北 4南北 5东西 6东南 7东北8西南 9西北'");}
if(!pdo_fieldexists('ox_reathouse_house_info','house_type_shi')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `house_type_shi` tinyint(4) DEFAULT NULL COMMENT '户型几室'");}
if(!pdo_fieldexists('ox_reathouse_house_info','house_type_wei')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `house_type_wei` tinyint(4) DEFAULT NULL COMMENT '户型几卫'");}
if(!pdo_fieldexists('ox_reathouse_house_info','house_type_ting')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `house_type_ting` tinyint(4) DEFAULT NULL COMMENT '户型几厅'");}
if(!pdo_fieldexists('ox_reathouse_house_info','area')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `area` varchar(50) NOT NULL DEFAULT '' COMMENT '面积'");}
if(!pdo_fieldexists('ox_reathouse_house_info','yafu_fu')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `yafu_fu` tinyint(4) DEFAULT '1' COMMENT '押付方式 付几个月'");}
if(!pdo_fieldexists('ox_reathouse_house_info','yafu_ya')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `yafu_ya` tinyint(4) DEFAULT '1' COMMENT '押付方式 押几个月'");}
if(!pdo_fieldexists('ox_reathouse_house_info','price')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `price` decimal(10,2) NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('ox_reathouse_house_info','active_price')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `active_price` decimal(20,2) DEFAULT NULL COMMENT '活动价格'");}
if(!pdo_fieldexists('ox_reathouse_house_info','address')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `address` varchar(255) DEFAULT '' COMMENT '地址'");}
if(!pdo_fieldexists('ox_reathouse_house_info','desc')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `desc` text COMMENT '房屋描述'");}
if(!pdo_fieldexists('ox_reathouse_house_info','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reathouse_house_info','update_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `update_time` int(11) unsigned DEFAULT NULL COMMENT '更新时间'");}
if(!pdo_fieldexists('ox_reathouse_house_info','status')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `status` tinyint(11) NOT NULL DEFAULT '2' COMMENT '状态 1，正常 0，已下架 2未发布完成（后台不显示）'");}
if(!pdo_fieldexists('ox_reathouse_house_info','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `uid` int(11) DEFAULT NULL COMMENT '发布者id'");}
if(!pdo_fieldexists('ox_reathouse_house_info','mapx')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `mapx` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reathouse_house_info','mapy')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_house_info')." ADD   `mapy` varchar(50) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_img` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `house_id` int(11) NOT NULL COMMENT '房屋id',
  `url` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ox_reathouse_img','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_img')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reathouse_img','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_img')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_img','house_id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_img')." ADD   `house_id` int(11) NOT NULL COMMENT '房屋id'");}
if(!pdo_fieldexists('ox_reathouse_img','url')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_img')." ADD   `url` varchar(255) DEFAULT NULL COMMENT '图片路径'");}
if(!pdo_fieldexists('ox_reathouse_img','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_img')." ADD   `sort` int(10) DEFAULT NULL COMMENT '排序'");}
if(!pdo_fieldexists('ox_reathouse_img','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_img')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `title` varchar(100) DEFAULT NULL COMMENT '小程序标题',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `logo` varchar(255) DEFAULT NULL COMMENT 'logo',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ox_reathouse_info','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_info')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reathouse_info','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_info')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_info','title')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_info')." ADD   `title` varchar(100) DEFAULT NULL COMMENT '小程序标题'");}
if(!pdo_fieldexists('ox_reathouse_info','phone')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_info')." ADD   `phone` varchar(20) DEFAULT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('ox_reathouse_info','logo')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_info')." ADD   `logo` varchar(255) DEFAULT NULL COMMENT 'logo'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `uid` int(11) DEFAULT NULL COMMENT '微擎用户表uid',
  `nickname` varchar(125) DEFAULT NULL COMMENT '用户名称',
  `avatar` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `openid` varchar(40) DEFAULT NULL COMMENT 'openid',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态:0=无效 1=有效',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号预留字段',
  `is_publish` tinyint(4) DEFAULT '0' COMMENT '是否可以发布房源 0不可发布 1可发布',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ox_reathouse_member','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reathouse_member','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_member','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD   `uid` int(11) DEFAULT NULL COMMENT '微擎用户表uid'");}
if(!pdo_fieldexists('ox_reathouse_member','nickname')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD   `nickname` varchar(125) DEFAULT NULL COMMENT '用户名称'");}
if(!pdo_fieldexists('ox_reathouse_member','avatar')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD   `avatar` varchar(255) DEFAULT NULL COMMENT '用户头像'");}
if(!pdo_fieldexists('ox_reathouse_member','openid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD   `openid` varchar(40) DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('ox_reathouse_member','status')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD   `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态:0=无效 1=有效'");}
if(!pdo_fieldexists('ox_reathouse_member','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('ox_reathouse_member','phone')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD   `phone` varchar(20) DEFAULT NULL COMMENT '手机号预留字段'");}
if(!pdo_fieldexists('ox_reathouse_member','is_publish')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_member')." ADD   `is_publish` tinyint(4) DEFAULT '0' COMMENT '是否可以发布房源 0不可发布 1可发布'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_reath_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `name` varchar(125) NOT NULL DEFAULT '' COMMENT '类型名称',
  `href` varchar(255) DEFAULT NULL COMMENT '跳转链接',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1 正常 0 下架',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标地址',
  `content` text COMMENT '文本',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ox_reathouse_reath_type','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_reath_type')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reathouse_reath_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_reath_type')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_reath_type','name')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_reath_type')." ADD   `name` varchar(125) NOT NULL DEFAULT '' COMMENT '类型名称'");}
if(!pdo_fieldexists('ox_reathouse_reath_type','href')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_reath_type')." ADD   `href` varchar(255) DEFAULT NULL COMMENT '跳转链接'");}
if(!pdo_fieldexists('ox_reathouse_reath_type','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_reath_type')." ADD   `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('ox_reathouse_reath_type','status')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_reath_type')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1 正常 0 下架'");}
if(!pdo_fieldexists('ox_reathouse_reath_type','icon')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_reath_type')." ADD   `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标地址'");}
if(!pdo_fieldexists('ox_reathouse_reath_type','content')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_reath_type')." ADD   `content` text COMMENT '文本'");}
if(!pdo_fieldexists('ox_reathouse_reath_type','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_reath_type')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_suggest` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `uniacid` int(10) DEFAULT NULL COMMENT '小程序id',
  `content` text COMMENT '反馈内容',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='意见反馈';

");

if(!pdo_fieldexists('ox_reathouse_suggest','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_suggest')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reathouse_suggest','uid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_suggest')." ADD   `uid` int(10) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ox_reathouse_suggest','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_suggest')." ADD   `uniacid` int(10) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_suggest','content')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_suggest')." ADD   `content` text COMMENT '反馈内容'");}
if(!pdo_fieldexists('ox_reathouse_suggest','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_suggest')." ADD   `create_time` int(10) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `name` varchar(255) DEFAULT NULL COMMENT '标签名称',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");

if(!pdo_fieldexists('ox_reathouse_tag','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_tag')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'");}
if(!pdo_fieldexists('ox_reathouse_tag','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_tag')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('ox_reathouse_tag','name')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_tag')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '标签名称'");}
if(!pdo_fieldexists('ox_reathouse_tag','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_tag')." ADD   `create_time` int(11) DEFAULT NULL COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ox_reathouse_view` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL COMMENT '标题',
  `content` text,
  `sort` tinyint(4) DEFAULT NULL COMMENT ' 排序',
  `type` tinyint(4) DEFAULT NULL COMMENT ' 1 关于我们 2 操作指南',
  `create_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ox_reathouse_view','id')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_view')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ox_reathouse_view','uniacid')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_view')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('ox_reathouse_view','title')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_view')." ADD   `title` varchar(20) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('ox_reathouse_view','content')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_view')." ADD   `content` text");}
if(!pdo_fieldexists('ox_reathouse_view','sort')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_view')." ADD   `sort` tinyint(4) DEFAULT NULL COMMENT ' 排序'");}
if(!pdo_fieldexists('ox_reathouse_view','type')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_view')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT ' 1 关于我们 2 操作指南'");}
if(!pdo_fieldexists('ox_reathouse_view','create_time')) {pdo_query("ALTER TABLE ".tablename('ox_reathouse_view')." ADD   `create_time` int(10) DEFAULT NULL");}
