<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_active` (
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

");

if(!pdo_fieldexists('yzzc_sun_active','aid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_active')." ADD 
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id'");}
if(!pdo_fieldexists('yzzc_sun_active','pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_active')." ADD   `pic` varchar(110) NOT NULL COMMENT '活动图片'");}
if(!pdo_fieldexists('yzzc_sun_active','title')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_active')." ADD   `title` varchar(50) CHARACTER SET utf8mb4 NOT NULL COMMENT '活动标题'");}
if(!pdo_fieldexists('yzzc_sun_active','content')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_active')." ADD   `content` text CHARACTER SET utf8mb4 NOT NULL COMMENT '活动内容'");}
if(!pdo_fieldexists('yzzc_sun_active','acttime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_active')." ADD   `acttime` varchar(120) NOT NULL COMMENT '活动时间'");}
if(!pdo_fieldexists('yzzc_sun_active','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_active')." ADD   `createtime` varchar(120) NOT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('yzzc_sun_active','details')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_active')." ADD   `details` text CHARACTER SET utf8mb4 NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_active','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_active')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_active','status')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_active')." ADD   `status` tinyint(1) DEFAULT '1' COMMENT '1.显示 2.下架'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_addnews` (
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

if(!pdo_fieldexists('yzzc_sun_addnews','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_addnews')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('yzzc_sun_addnews','title')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_addnews')." ADD   `title` varchar(255) NOT NULL COMMENT '标题，展示用'");}
if(!pdo_fieldexists('yzzc_sun_addnews','left')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_addnews')." ADD   `left` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_addnews','state')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_addnews')." ADD   `state` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1显示，2为关闭'");}
if(!pdo_fieldexists('yzzc_sun_addnews','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_addnews')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_addnews','type')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_addnews')." ADD   `type` int(11) NOT NULL COMMENT '类型'");}
if(!pdo_fieldexists('yzzc_sun_addnews','time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_addnews')." ADD   `time` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_adpic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_type` tinyint(1) DEFAULT '0' COMMENT '0.不跳转1.车型2门店3活动',
  `link_typeid` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `ad_pic` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `title` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='首页弹窗广告';

");

if(!pdo_fieldexists('yzzc_sun_adpic','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_adpic')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_adpic','link_type')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_adpic')." ADD   `link_type` tinyint(1) DEFAULT '0' COMMENT '0.不跳转1.车型2门店3活动'");}
if(!pdo_fieldexists('yzzc_sun_adpic','link_typeid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_adpic')." ADD   `link_typeid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_adpic','sort')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_adpic')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_adpic','ad_pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_adpic')." ADD   `ad_pic` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_adpic','title')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_adpic')." ADD   `title` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_adpic','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_adpic')." ADD   `uniacid` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_allrule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8mb4 NOT NULL COMMENT '使用规则',
  `selftime` datetime DEFAULT NULL COMMENT '存入时间',
  `uniacid` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT '0' COMMENT '1.租车券2.会员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='规则表';

");

if(!pdo_fieldexists('yzzc_sun_allrule','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_allrule')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_allrule','content')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_allrule')." ADD   `content` text CHARACTER SET utf8mb4 NOT NULL COMMENT '使用规则'");}
if(!pdo_fieldexists('yzzc_sun_allrule','selftime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_allrule')." ADD   `selftime` datetime DEFAULT NULL COMMENT '存入时间'");}
if(!pdo_fieldexists('yzzc_sun_allrule','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_allrule')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_allrule','type')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_allrule')." ADD   `type` int(1) DEFAULT '0' COMMENT '1.租车券2.会员'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(100) DEFAULT NULL COMMENT '轮播名称',
  `url` varchar(300) DEFAULT NULL COMMENT '轮播链接',
  `lb_imgs` varchar(500) DEFAULT NULL COMMENT '首页轮播图片',
  `uniacid` int(11) NOT NULL,
  `new_banner` varchar(200) DEFAULT NULL COMMENT '新手指导',
  `rules_banner` varchar(200) DEFAULT NULL COMMENT '服务规则轮播图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='首页轮播表';

");

if(!pdo_fieldexists('yzzc_sun_banner','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_banner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_banner','bname')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_banner')." ADD   `bname` varchar(100) DEFAULT NULL COMMENT '轮播名称'");}
if(!pdo_fieldexists('yzzc_sun_banner','url')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_banner')." ADD   `url` varchar(300) DEFAULT NULL COMMENT '轮播链接'");}
if(!pdo_fieldexists('yzzc_sun_banner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_banner')." ADD   `lb_imgs` varchar(500) DEFAULT NULL COMMENT '首页轮播图片'");}
if(!pdo_fieldexists('yzzc_sun_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_banner')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_banner','new_banner')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_banner')." ADD   `new_banner` varchar(200) DEFAULT NULL COMMENT '新手指导'");}
if(!pdo_fieldexists('yzzc_sun_banner','rules_banner')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_banner')." ADD   `rules_banner` varchar(200) DEFAULT NULL COMMENT '服务规则轮播图'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_branch` (
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COMMENT='门店表';

");

if(!pdo_fieldexists('yzzc_sun_branch','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_branch','name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `name` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '店铺名称'");}
if(!pdo_fieldexists('yzzc_sun_branch','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_branch','province')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `province` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_branch','city')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `city` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_branch','area')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `area` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_branch','address')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `address` varchar(200) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('yzzc_sun_branch','lng')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `lng` varchar(50) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('yzzc_sun_branch','lat')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `lat` varchar(50) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('yzzc_sun_branch','ranges')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `ranges` int(5) DEFAULT '0' COMMENT '送车上门范围 0.不送车上门 '");}
if(!pdo_fieldexists('yzzc_sun_branch','business_hours')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `business_hours` varchar(50) DEFAULT NULL COMMENT '营业时间'");}
if(!pdo_fieldexists('yzzc_sun_branch','service_tel')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `service_tel` varchar(20) DEFAULT NULL COMMENT '服务热线'");}
if(!pdo_fieldexists('yzzc_sun_branch','shop_tel')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `shop_tel` varchar(20) DEFAULT NULL COMMENT '门店电话'");}
if(!pdo_fieldexists('yzzc_sun_branch','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `createtime` varchar(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_branch','status')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `status` varchar(1) DEFAULT '1' COMMENT '1.显示'");}
if(!pdo_fieldexists('yzzc_sun_branch','pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch')." ADD   `pic` varchar(500) DEFAULT NULL COMMENT '门店照片'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_branch_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `auth` tinyint(1) DEFAULT '1' COMMENT '1.超级管理员 2.核销员',
  `uniacid` int(11) DEFAULT NULL,
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='门店管理员表';

");

if(!pdo_fieldexists('yzzc_sun_branch_admin','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch_admin')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_branch_admin','bid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch_admin')." ADD   `bid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_branch_admin','uid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch_admin')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_branch_admin','auth')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch_admin')." ADD   `auth` tinyint(1) DEFAULT '1' COMMENT '1.超级管理员 2.核销员'");}
if(!pdo_fieldexists('yzzc_sun_branch_admin','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch_admin')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_branch_admin','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_branch_admin')." ADD   `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_car` (
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

");

if(!pdo_fieldexists('yzzc_sun_car','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_car','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_car','sid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `sid` int(11) NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('yzzc_sun_car','mileage')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `mileage` int(11) NOT NULL COMMENT '里程'");}
if(!pdo_fieldexists('yzzc_sun_car','name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `name` varchar(50) NOT NULL COMMENT '车辆名称'");}
if(!pdo_fieldexists('yzzc_sun_car','cartype')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `cartype` varchar(50) NOT NULL COMMENT '车辆类型，如轿车、SUV等等'");}
if(!pdo_fieldexists('yzzc_sun_car','carnum')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `carnum` varchar(20) DEFAULT NULL COMMENT '车牌号'");}
if(!pdo_fieldexists('yzzc_sun_car','color')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `color` varchar(10) NOT NULL COMMENT '颜色'");}
if(!pdo_fieldexists('yzzc_sun_car','structure')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `structure` int(1) DEFAULT '1' COMMENT '车身结构 1.两厢 2.三厢'");}
if(!pdo_fieldexists('yzzc_sun_car','grarbox')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `grarbox` int(1) NOT NULL DEFAULT '1' COMMENT '变速箱1.手动2.自动'");}
if(!pdo_fieldexists('yzzc_sun_car','displacement')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `displacement` varchar(10) DEFAULT NULL COMMENT '汽车排量'");}
if(!pdo_fieldexists('yzzc_sun_car','num')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `num` int(2) NOT NULL COMMENT '过户次数'");}
if(!pdo_fieldexists('yzzc_sun_car','pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `pic` varchar(200) NOT NULL COMMENT '封面图'");}
if(!pdo_fieldexists('yzzc_sun_car','imgs')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `imgs` text NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('yzzc_sun_car','phone')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `phone` varchar(20) NOT NULL COMMENT '预约电话'");}
if(!pdo_fieldexists('yzzc_sun_car','content')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `content` text NOT NULL COMMENT '车辆简介'");}
if(!pdo_fieldexists('yzzc_sun_car','money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '首付'");}
if(!pdo_fieldexists('yzzc_sun_car','monthmoney')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `monthmoney` decimal(10,2) DEFAULT '0.00' COMMENT '月供'");}
if(!pdo_fieldexists('yzzc_sun_car','guidemoney')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `guidemoney` decimal(10,2) DEFAULT '0.00' COMMENT '官方指导价'");}
if(!pdo_fieldexists('yzzc_sun_car','carbrand')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `carbrand` int(11) DEFAULT NULL COMMENT '汽车品牌'");}
if(!pdo_fieldexists('yzzc_sun_car','carcity')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `carcity` int(11) DEFAULT NULL COMMENT '所在城市'");}
if(!pdo_fieldexists('yzzc_sun_car','rec')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `rec` tinyint(1) DEFAULT '1' COMMENT '是否推荐到首页 1.推荐 2.不推荐'");}
if(!pdo_fieldexists('yzzc_sun_car','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `createtime` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_car','registrationtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `registrationtime` varchar(50) DEFAULT NULL COMMENT '上牌时间'");}
if(!pdo_fieldexists('yzzc_sun_car','status')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `status` tinyint(1) DEFAULT '1' COMMENT '1.待审核 2.已审核'");}
if(!pdo_fieldexists('yzzc_sun_car','is_del')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `is_del` tinyint(1) DEFAULT '0' COMMENT '1已删除'");}
if(!pdo_fieldexists('yzzc_sun_car','sort')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_car')." ADD   `sort` int(11) DEFAULT '255'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_carbrand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `zimu` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '首字母',
  `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '品牌名称',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

");

if(!pdo_fieldexists('yzzc_sun_carbrand','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_carbrand')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_carbrand','zimu')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_carbrand')." ADD   `zimu` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '首字母'");}
if(!pdo_fieldexists('yzzc_sun_carbrand','name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_carbrand')." ADD   `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '品牌名称'");}
if(!pdo_fieldexists('yzzc_sun_carbrand','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_carbrand')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_carcity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `zimu` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '首字母',
  `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '城市名称',
  `rec` tinyint(2) DEFAULT '2' COMMENT '1热门',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

");

if(!pdo_fieldexists('yzzc_sun_carcity','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_carcity')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_carcity','zimu')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_carcity')." ADD   `zimu` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '首字母'");}
if(!pdo_fieldexists('yzzc_sun_carcity','name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_carcity')." ADD   `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '城市名称'");}
if(!pdo_fieldexists('yzzc_sun_carcity','rec')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_carcity')." ADD   `rec` tinyint(2) DEFAULT '2' COMMENT '1热门'");}
if(!pdo_fieldexists('yzzc_sun_carcity','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_carcity')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_cartype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '分类名称',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

");

if(!pdo_fieldexists('yzzc_sun_cartype','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_cartype')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_cartype','name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_cartype')." ADD   `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('yzzc_sun_cartype','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_cartype')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) DEFAULT NULL,
  `name` varchar(15) DEFAULT NULL,
  `fullname` varchar(20) DEFAULT NULL,
  `pinyin` varchar(25) DEFAULT NULL,
  `lat` varchar(30) DEFAULT NULL,
  `lng` varchar(30) DEFAULT NULL,
  `pcode` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4934 DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yzzc_sun_city','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_city')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_city','code')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_city')." ADD   `code` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_city','name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_city')." ADD   `name` varchar(15) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_city','fullname')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_city')." ADD   `fullname` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_city','pinyin')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_city')." ADD   `pinyin` varchar(25) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_city','lat')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_city')." ADD   `lat` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_city','lng')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_city')." ADD   `lng` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_city','pcode')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_city')." ADD   `pcode` int(11) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_coupon` (
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzzc_sun_coupon','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('yzzc_sun_coupon','title')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `title` varchar(255) NOT NULL COMMENT '优惠券名称，展示用'");}
if(!pdo_fieldexists('yzzc_sun_coupon','type')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `type` tinyint(1) unsigned DEFAULT '1' COMMENT '1.租车券 2.优惠券'");}
if(!pdo_fieldexists('yzzc_sun_coupon','start_time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `start_time` varchar(11) DEFAULT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('yzzc_sun_coupon','end_time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `end_time` varchar(11) DEFAULT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('yzzc_sun_coupon','total')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `total` int(10) unsigned DEFAULT '0' COMMENT '总量 0.不限量发放'");}
if(!pdo_fieldexists('yzzc_sun_coupon','getnum')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `getnum` int(11) DEFAULT '0' COMMENT '已领数量'");}
if(!pdo_fieldexists('yzzc_sun_coupon','score')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `score` int(11) unsigned DEFAULT NULL COMMENT '积分兑换'");}
if(!pdo_fieldexists('yzzc_sun_coupon','status')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `status` tinyint(4) DEFAULT '1' COMMENT '是否首页显示（0:不显示 1:显示）'");}
if(!pdo_fieldexists('yzzc_sun_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_coupon','full')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `full` int(11) DEFAULT NULL COMMENT '满多少'");}
if(!pdo_fieldexists('yzzc_sun_coupon','money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `money` int(11) DEFAULT '0' COMMENT '金额'");}
if(!pdo_fieldexists('yzzc_sun_coupon','limit')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `limit` tinyint(1) DEFAULT '1' COMMENT '领取限制：1不限 2.转发'");}
if(!pdo_fieldexists('yzzc_sun_coupon','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon')." ADD   `createtime` varchar(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_coupon_get` (
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

");

if(!pdo_fieldexists('yzzc_sun_coupon_get','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon_get')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_coupon_get','cid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon_get')." ADD   `cid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_coupon_get','uid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon_get')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_coupon_get','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon_get')." ADD   `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_coupon_get','isuse')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon_get')." ADD   `isuse` tinyint(1) DEFAULT '0' COMMENT '0.未使用 1.已使用'");}
if(!pdo_fieldexists('yzzc_sun_coupon_get','usetime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon_get')." ADD   `usetime` varchar(11) COLLATE utf8mb4_bin DEFAULT '0' COMMENT '使用时间'");}
if(!pdo_fieldexists('yzzc_sun_coupon_get','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon_get')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_coupon_get','type')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_coupon_get')." ADD   `type` int(1) DEFAULT '1' COMMENT '1.租车券2.优惠券'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_goods` (
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

");

if(!pdo_fieldexists('yzzc_sun_goods','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_goods','sid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `sid` int(11) NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('yzzc_sun_goods','name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `name` varchar(50) NOT NULL COMMENT '车辆名称'");}
if(!pdo_fieldexists('yzzc_sun_goods','carnum')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `carnum` varchar(20) DEFAULT NULL COMMENT '车牌号'");}
if(!pdo_fieldexists('yzzc_sun_goods','colour')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `colour` varchar(10) NOT NULL COMMENT '颜色'");}
if(!pdo_fieldexists('yzzc_sun_goods','structure')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `structure` int(1) DEFAULT '1' COMMENT '车身结构 1.两厢 2.三厢'");}
if(!pdo_fieldexists('yzzc_sun_goods','grarbox')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `grarbox` int(1) NOT NULL DEFAULT '1' COMMENT '变速箱1.手动2.自动'");}
if(!pdo_fieldexists('yzzc_sun_goods','displacement')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `displacement` varchar(10) DEFAULT NULL COMMENT '汽车排量'");}
if(!pdo_fieldexists('yzzc_sun_goods','num')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `num` int(2) NOT NULL COMMENT '核载人数'");}
if(!pdo_fieldexists('yzzc_sun_goods','pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `pic` varchar(200) NOT NULL COMMENT '封面图'");}
if(!pdo_fieldexists('yzzc_sun_goods','content')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `content` text NOT NULL COMMENT '车辆简介'");}
if(!pdo_fieldexists('yzzc_sun_goods','moneytype')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `moneytype` tinyint(1) DEFAULT '1' COMMENT '租金类型 1.日租2周租3月租4年租'");}
if(!pdo_fieldexists('yzzc_sun_goods','money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '租金'");}
if(!pdo_fieldexists('yzzc_sun_goods','cartype')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `cartype` int(11) DEFAULT NULL COMMENT '汽车类型'");}
if(!pdo_fieldexists('yzzc_sun_goods','fee')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `fee` decimal(10,2) DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('yzzc_sun_goods','service_fee')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `service_fee` decimal(10,2) DEFAULT '0.00' COMMENT '服务费'");}
if(!pdo_fieldexists('yzzc_sun_goods','zx_service_fee')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `zx_service_fee` decimal(10,2) DEFAULT '0.00' COMMENT '尊享服务费'");}
if(!pdo_fieldexists('yzzc_sun_goods','rec')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `rec` tinyint(1) DEFAULT '1' COMMENT '是否推荐到首页 1.推荐 2.不推荐'");}
if(!pdo_fieldexists('yzzc_sun_goods','hot')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `hot` tinyint(1) DEFAULT '1' COMMENT '1.热门'");}
if(!pdo_fieldexists('yzzc_sun_goods','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `createtime` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_goods','status')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `status` tinyint(1) DEFAULT '1' COMMENT '1.空闲 2.已租 3.下架'");}
if(!pdo_fieldexists('yzzc_sun_goods','act_money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `act_money` decimal(10,2) DEFAULT '0.00' COMMENT '活动价格'");}
if(!pdo_fieldexists('yzzc_sun_goods','is_del')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `is_del` tinyint(1) DEFAULT '0' COMMENT '1已删除'");}
if(!pdo_fieldexists('yzzc_sun_goods','subscribe_duration')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_goods')." ADD   `subscribe_duration` text");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_integral_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `type` int(1) DEFAULT '1' COMMENT '1.签到 2.兑换租车券3.消费得积分4.租车抵现',
  `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='积分明细表';

");

if(!pdo_fieldexists('yzzc_sun_integral_log','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integral_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_integral_log','uid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integral_log')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_integral_log','score')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integral_log')." ADD   `score` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yzzc_sun_integral_log','type')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integral_log')." ADD   `type` int(1) DEFAULT '1' COMMENT '1.签到 2.兑换租车券3.消费得积分4.租车抵现'");}
if(!pdo_fieldexists('yzzc_sun_integral_log','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integral_log')." ADD   `createtime` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_integral_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integral_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_integralset` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='积分设置表';

");

if(!pdo_fieldexists('yzzc_sun_integralset','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integralset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_integralset','sign')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integralset')." ADD   `sign` int(11) DEFAULT '0' COMMENT '签到得积分'");}
if(!pdo_fieldexists('yzzc_sun_integralset','full')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integralset')." ADD   `full` int(11) DEFAULT '0' COMMENT '消费满多少钱'");}
if(!pdo_fieldexists('yzzc_sun_integralset','cost_score')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integralset')." ADD   `cost_score` int(11) DEFAULT '0' COMMENT '消费满多少钱得到积分'");}
if(!pdo_fieldexists('yzzc_sun_integralset','use_money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integralset')." ADD   `use_money` int(11) DEFAULT '0' COMMENT '抵多少现金'");}
if(!pdo_fieldexists('yzzc_sun_integralset','use_score')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integralset')." ADD   `use_score` int(11) DEFAULT '0' COMMENT '多少积分可以抵多少钱'");}
if(!pdo_fieldexists('yzzc_sun_integralset','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integralset')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_integralset','selftime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integralset')." ADD   `selftime` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_integralset','rule')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_integralset')." ADD   `rule` text COMMENT '积分规则'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(10) DEFAULT '0' COMMENT '签到得积分',
  `level_img` varchar(200) DEFAULT '0' COMMENT '消费满多少钱',
  `level_score` int(11) DEFAULT '0' COMMENT '会员积分',
  `level_privileges` tinyint(1) DEFAULT '1' COMMENT '1无特权2免收服务费3延长还车',
  `delay` int(20) DEFAULT '0' COMMENT '延长还车时间',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='会员等级设置表';

");

if(!pdo_fieldexists('yzzc_sun_level','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_level')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_level','level_name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_level')." ADD   `level_name` varchar(10) DEFAULT '0' COMMENT '签到得积分'");}
if(!pdo_fieldexists('yzzc_sun_level','level_img')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_level')." ADD   `level_img` varchar(200) DEFAULT '0' COMMENT '消费满多少钱'");}
if(!pdo_fieldexists('yzzc_sun_level','level_score')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_level')." ADD   `level_score` int(11) DEFAULT '0' COMMENT '会员积分'");}
if(!pdo_fieldexists('yzzc_sun_level','level_privileges')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_level')." ADD   `level_privileges` tinyint(1) DEFAULT '1' COMMENT '1无特权2免收服务费3延长还车'");}
if(!pdo_fieldexists('yzzc_sun_level','delay')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_level')." ADD   `delay` int(20) DEFAULT '0' COMMENT '延长还车时间'");}
if(!pdo_fieldexists('yzzc_sun_level','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_level')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_logoset` (
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

");

if(!pdo_fieldexists('yzzc_sun_logoset','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD 
  `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','logo_name_one')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `logo_name_one` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_name_one')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_name_one` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','logo_img_one')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `logo_img_one` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_img_one')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_img_one` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_img_a')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_img_a` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '选中图标'");}
if(!pdo_fieldexists('yzzc_sun_logoset','logo_name_two')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `logo_name_two` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_name_two')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_name_two` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','logo_img_two')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `logo_img_two` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_img_two')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_img_two` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_img_b')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_img_b` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','logo_name_three')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `logo_name_three` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_name_three')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_name_three` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','logo_img_three')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `logo_img_three` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_img_three')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_img_three` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_img_c')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_img_c` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','logo_name_four')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `logo_name_four` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_name_four')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_name_four` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','logo_img_four')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `logo_img_four` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_img_four')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_img_four` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','nav_img_d')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `nav_img_d` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','doorname')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `doorname` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','doorlottery')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `doorlottery` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','shopname')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `shopname` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_logoset','shoplottery')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_logoset')." ADD   `shoplottery` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member` varchar(20) NOT NULL COMMENT '会员等级',
  `integral` int(11) NOT NULL COMMENT '会员等级积分',
  `states` int(1) NOT NULL DEFAULT '1' COMMENT '状态 1.待审核 2.已通过 3.已拒绝',
  `uniacid` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=REDUNDANT;

");

if(!pdo_fieldexists('yzzc_sun_member','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_member')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_member','member')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_member')." ADD   `member` varchar(20) NOT NULL COMMENT '会员等级'");}
if(!pdo_fieldexists('yzzc_sun_member','integral')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_member')." ADD   `integral` int(11) NOT NULL COMMENT '会员等级积分'");}
if(!pdo_fieldexists('yzzc_sun_member','states')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_member')." ADD   `states` int(1) NOT NULL DEFAULT '1' COMMENT '状态 1.待审核 2.已通过 3.已拒绝'");}
if(!pdo_fieldexists('yzzc_sun_member','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_member')." ADD   `uniacid` int(11) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_msg_set` (
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

");

if(!pdo_fieldexists('yzzc_sun_msg_set','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_msg_set','open')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `open` tinyint(1) DEFAULT '1' COMMENT '1开启 0关闭'");}
if(!pdo_fieldexists('yzzc_sun_msg_set','type')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `type` tinyint(1) DEFAULT '1' COMMENT '1.253 2.大鱼'");}
if(!pdo_fieldexists('yzzc_sun_msg_set','api_account')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `api_account` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_msg_set','api_psw')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `api_psw` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_msg_set','buy_template')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `buy_template` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '购买成功模板'");}
if(!pdo_fieldexists('yzzc_sun_msg_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_msg_set','dayu_signname')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `dayu_signname` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '大鱼-短信签名'");}
if(!pdo_fieldexists('yzzc_sun_msg_set','dayu_templatecode')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `dayu_templatecode` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '大鱼-模板id'");}
if(!pdo_fieldexists('yzzc_sun_msg_set','dayu_accesskey')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `dayu_accesskey` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_msg_set','dayu_accesskeysecret')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_msg_set')." ADD   `dayu_accesskeysecret` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` varchar(120) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL COMMENT '标题1',
  `content` text COMMENT '内容1',
  `selftime` datetime DEFAULT NULL COMMENT '存入时间',
  `uniacid` int(11) DEFAULT NULL,
  `sort` tinyint(1) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='新手指导表';

");

if(!pdo_fieldexists('yzzc_sun_new','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_new')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_new','pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_new')." ADD   `pic` varchar(120) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_new','title')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_new')." ADD   `title` varchar(50) DEFAULT NULL COMMENT '标题1'");}
if(!pdo_fieldexists('yzzc_sun_new','content')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_new')." ADD   `content` text COMMENT '内容1'");}
if(!pdo_fieldexists('yzzc_sun_new','selftime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_new')." ADD   `selftime` datetime DEFAULT NULL COMMENT '存入时间'");}
if(!pdo_fieldexists('yzzc_sun_new','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_new')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_new','sort')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_new')." ADD   `sort` tinyint(1) DEFAULT '0' COMMENT '排序'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_order` (
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

");

if(!pdo_fieldexists('yzzc_sun_order','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_order','cid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `cid` int(11) NOT NULL COMMENT '车辆id'");}
if(!pdo_fieldexists('yzzc_sun_order','gettype')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `gettype` tinyint(1) DEFAULT '1' COMMENT '1门店自取2.送车上门'");}
if(!pdo_fieldexists('yzzc_sun_order','type')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `type` tinyint(1) DEFAULT '1' COMMENT '1.短租订单 2.长租订单'");}
if(!pdo_fieldexists('yzzc_sun_order','typeid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `typeid` int(11) DEFAULT '0' COMMENT '长租订单的类型id'");}
if(!pdo_fieldexists('yzzc_sun_order','start_time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `start_time` varchar(11) DEFAULT NULL COMMENT '取车时间'");}
if(!pdo_fieldexists('yzzc_sun_order','end_time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `end_time` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '还车时间'");}
if(!pdo_fieldexists('yzzc_sun_order','start_shop')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `start_shop` int(11) DEFAULT NULL COMMENT '取车门店id'");}
if(!pdo_fieldexists('yzzc_sun_order','end_shop')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `end_shop` int(11) DEFAULT NULL COMMENT '还车门店id'");}
if(!pdo_fieldexists('yzzc_sun_order','day')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `day` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_order','uid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_order','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `createtime` varchar(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_order','status')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `status` tinyint(1) DEFAULT '1' COMMENT '1待支付 2.已支付 3.已取车4.已取消'");}
if(!pdo_fieldexists('yzzc_sun_order','membertype')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `membertype` tinyint(1) DEFAULT '1' COMMENT '会员类型 1.无特权 2.免服务费 3.延迟还车'");}
if(!pdo_fieldexists('yzzc_sun_order','delay')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `delay` int(3) DEFAULT '0' COMMENT '延迟还车'");}
if(!pdo_fieldexists('yzzc_sun_order','integral_money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `integral_money` varchar(10) DEFAULT '0' COMMENT '积分抵现'");}
if(!pdo_fieldexists('yzzc_sun_order','integral')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `integral` int(10) DEFAULT '0' COMMENT '使用积分'");}
if(!pdo_fieldexists('yzzc_sun_order','money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '单价'");}
if(!pdo_fieldexists('yzzc_sun_order','total_money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `total_money` decimal(10,2) DEFAULT NULL COMMENT '总价'");}
if(!pdo_fieldexists('yzzc_sun_order','prepay_money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `prepay_money` decimal(10,2) DEFAULT '0.00' COMMENT '预付金额'");}
if(!pdo_fieldexists('yzzc_sun_order','fee')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `fee` decimal(10,2) DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('yzzc_sun_order','service_fee')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `service_fee` decimal(10,2) DEFAULT '0.00' COMMENT '服务费'");}
if(!pdo_fieldexists('yzzc_sun_order','zx_service_fee')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `zx_service_fee` decimal(10,2) DEFAULT '0.00' COMMENT '尊享服务费'");}
if(!pdo_fieldexists('yzzc_sun_order','open_zx_service')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `open_zx_service` tinyint(1) DEFAULT '0' COMMENT '0.不使用 1.使用尊享服务'");}
if(!pdo_fieldexists('yzzc_sun_order','coupon_money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `coupon_money` decimal(10,2) DEFAULT '0.00' COMMENT '券金额'");}
if(!pdo_fieldexists('yzzc_sun_order','coupon')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `coupon` int(11) DEFAULT '0' COMMENT '券id'");}
if(!pdo_fieldexists('yzzc_sun_order','ispay')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `ispay` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzzc_sun_order','paytime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `paytime` varchar(11) CHARACTER SET utf8 DEFAULT '0' COMMENT '支付时间'");}
if(!pdo_fieldexists('yzzc_sun_order','isuse')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `isuse` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzzc_sun_order','usetime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `usetime` varchar(11) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_order','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `out_trade_no` varchar(35) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_order','transid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `transid` varchar(35) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_order','ordernum')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `ordernum` varchar(35) DEFAULT NULL COMMENT '订单编号'");}
if(!pdo_fieldexists('yzzc_sun_order','username')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `username` varchar(10) DEFAULT NULL COMMENT '取车姓名'");}
if(!pdo_fieldexists('yzzc_sun_order','tel')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `tel` varchar(20) DEFAULT NULL COMMENT '取车电话'");}
if(!pdo_fieldexists('yzzc_sun_order','prepay_id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `prepay_id` varchar(200) DEFAULT NULL COMMENT '支付成功后的prepay_id'");}
if(!pdo_fieldexists('yzzc_sun_order','active')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `active` tinyint(1) DEFAULT '0' COMMENT '1.活动'");}
if(!pdo_fieldexists('yzzc_sun_order','display')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `display` int(1) DEFAULT '1' COMMENT '0.删除订单'");}
if(!pdo_fieldexists('yzzc_sun_order','return_time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `return_time` varchar(11) DEFAULT NULL COMMENT '还车时间'");}
if(!pdo_fieldexists('yzzc_sun_order','carnum')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `carnum` varchar(20) DEFAULT NULL COMMENT '车牌号'");}
if(!pdo_fieldexists('yzzc_sun_order','istui')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `istui` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('yzzc_sun_order','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order')." ADD   `out_refund_no` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_order_set` (
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

");

if(!pdo_fieldexists('yzzc_sun_order_set','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_order_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_order_set','know')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `know` text COMMENT '取车须知'");}
if(!pdo_fieldexists('yzzc_sun_order_set','rule')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `rule` text COMMENT '订单说明'");}
if(!pdo_fieldexists('yzzc_sun_order_set','long_prepay')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `long_prepay` varchar(11) DEFAULT '0' COMMENT '长租订单预付金额 0.全款'");}
if(!pdo_fieldexists('yzzc_sun_order_set','short_prepay')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `short_prepay` varchar(11) DEFAULT '0' COMMENT '短租订单预付金额'");}
if(!pdo_fieldexists('yzzc_sun_order_set','service_desc')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `service_desc` text COMMENT '基础服务费说明'");}
if(!pdo_fieldexists('yzzc_sun_order_set','zx_service_desc')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `zx_service_desc` text COMMENT '尊享服务费说明'");}
if(!pdo_fieldexists('yzzc_sun_order_set','getcar_desc')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `getcar_desc` text COMMENT '取车证件说明'");}
if(!pdo_fieldexists('yzzc_sun_order_set','tuimoney')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `tuimoney` int(11) DEFAULT '50'");}
if(!pdo_fieldexists('yzzc_sun_order_set','istui')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_order_set')." ADD   `istui` int(11) DEFAULT '5'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_ordertime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `carnum` varchar(20) DEFAULT NULL COMMENT '车牌号',
  `start_time` varchar(11) DEFAULT NULL COMMENT '取车时间',
  `end_time` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '还车时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '0.已完成1待支付 2.已支付 3.已取车4.已取消',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

if(!pdo_fieldexists('yzzc_sun_ordertime','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_ordertime')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_ordertime','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_ordertime')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_ordertime','carnum')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_ordertime')." ADD   `carnum` varchar(20) DEFAULT NULL COMMENT '车牌号'");}
if(!pdo_fieldexists('yzzc_sun_ordertime','start_time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_ordertime')." ADD   `start_time` varchar(11) DEFAULT NULL COMMENT '取车时间'");}
if(!pdo_fieldexists('yzzc_sun_ordertime','end_time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_ordertime')." ADD   `end_time` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '还车时间'");}
if(!pdo_fieldexists('yzzc_sun_ordertime','status')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_ordertime')." ADD   `status` tinyint(1) DEFAULT '1' COMMENT '0.已完成1待支付 2.已支付 3.已取车4.已取消'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` varchar(110) CHARACTER SET utf8 DEFAULT NULL COMMENT '服务规则图片',
  `title` varchar(30) DEFAULT NULL COMMENT '规则名称',
  `content` text COMMENT '规则详情',
  `sort` int(1) DEFAULT '0' COMMENT '排序',
  `selftime` datetime DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='服务规则表';

");

if(!pdo_fieldexists('yzzc_sun_rule','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_rule')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_rule','pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_rule')." ADD   `pic` varchar(110) CHARACTER SET utf8 DEFAULT NULL COMMENT '服务规则图片'");}
if(!pdo_fieldexists('yzzc_sun_rule','title')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_rule')." ADD   `title` varchar(30) DEFAULT NULL COMMENT '规则名称'");}
if(!pdo_fieldexists('yzzc_sun_rule','content')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_rule')." ADD   `content` text COMMENT '规则详情'");}
if(!pdo_fieldexists('yzzc_sun_rule','sort')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_rule')." ADD   `sort` int(1) DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzzc_sun_rule','selftime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_rule')." ADD   `selftime` datetime DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_rule','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_rule')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_signlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT '0' COMMENT '签到得积分',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

");

if(!pdo_fieldexists('yzzc_sun_signlog','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_signlog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_signlog','uid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_signlog')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_signlog','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_signlog')." ADD   `createtime` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_signlog','score')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_signlog')." ADD   `score` int(11) DEFAULT '0' COMMENT '签到得积分'");}
if(!pdo_fieldexists('yzzc_sun_signlog','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_signlog')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_specprice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id',
  `spec` varchar(100) NOT NULL COMMENT '活动时间',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '活动价格',
  `uniacid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzzc_sun_specprice','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_specprice')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id'");}
if(!pdo_fieldexists('yzzc_sun_specprice','spec')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_specprice')." ADD   `spec` varchar(100) NOT NULL COMMENT '活动时间'");}
if(!pdo_fieldexists('yzzc_sun_specprice','price')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_specprice')." ADD   `price` decimal(10,2) DEFAULT '0.00' COMMENT '活动价格'");}
if(!pdo_fieldexists('yzzc_sun_specprice','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_specprice')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_specprice','gid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_specprice')." ADD   `gid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_system` (
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

");

if(!pdo_fieldexists('yzzc_sun_system','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('yzzc_sun_system','appid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `appid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('yzzc_sun_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `appsecret` varchar(200) CHARACTER SET latin1 DEFAULT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('yzzc_sun_system','mchid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `mchid` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('yzzc_sun_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `wxkey` varchar(250) CHARACTER SET latin1 DEFAULT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('yzzc_sun_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','color')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `color` varchar(20) CHARACTER SET latin1 DEFAULT NULL COMMENT '颜色'");}
if(!pdo_fieldexists('yzzc_sun_system','address')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `address` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','sup_logo')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `sup_logo` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '技术支持logo'");}
if(!pdo_fieldexists('yzzc_sun_system','sup_name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `sup_name` varchar(50) DEFAULT NULL COMMENT '技术支持名称'");}
if(!pdo_fieldexists('yzzc_sun_system','sup_tel')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `sup_tel` varchar(20) DEFAULT NULL COMMENT '技术支持电话'");}
if(!pdo_fieldexists('yzzc_sun_system','ad_pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `ad_pic` tinyint(1) DEFAULT '1' COMMENT '1.开启首页弹窗广告图0.关闭'");}
if(!pdo_fieldexists('yzzc_sun_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `client_ip` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `apiclient_key` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `apiclient_cert` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `fontcolor` varchar(100) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','token')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `token` varchar(300) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','token_expires_in')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `token_expires_in` int(11) DEFAULT NULL COMMENT 'token的过期时间'");}
if(!pdo_fieldexists('yzzc_sun_system','order_template_id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `order_template_id` varchar(300) DEFAULT NULL COMMENT '预约成功模板id'");}
if(!pdo_fieldexists('yzzc_sun_system','top_font_color')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `top_font_color` varchar(50) DEFAULT '#000000' COMMENT '顶部字体颜色'");}
if(!pdo_fieldexists('yzzc_sun_system','top_color')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `top_color` varchar(50) DEFAULT '#fff' COMMENT '顶部风格颜色'");}
if(!pdo_fieldexists('yzzc_sun_system','foot_font_color_one')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `foot_font_color_one` varchar(50) DEFAULT '#333' COMMENT '底部文字选中前'");}
if(!pdo_fieldexists('yzzc_sun_system','foot_color')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `foot_color` varchar(50) DEFAULT '#fff' COMMENT '底部风格颜色'");}
if(!pdo_fieldexists('yzzc_sun_system','foot_font_color_two')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `foot_font_color_two` varchar(50) DEFAULT '#ffb62b' COMMENT '底部文字选中后'");}
if(!pdo_fieldexists('yzzc_sun_system','ht_title')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `ht_title` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','ht_logo')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `ht_logo` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','open_fj')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `open_fj` tinyint(1) DEFAULT '1' COMMENT '1.开启附近门店 0.关闭'");}
if(!pdo_fieldexists('yzzc_sun_system','index_haibao_pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `index_haibao_pic` varchar(200) DEFAULT NULL COMMENT '首页生成海报广告图'");}
if(!pdo_fieldexists('yzzc_sun_system','map_key')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `map_key` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','open_ys')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `open_ys` tinyint(1) DEFAULT '1' COMMENT '样式切换'");}
if(!pdo_fieldexists('yzzc_sun_system','is_open_car')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `is_open_car` tinyint(1) DEFAULT '0' COMMENT '二手车开关'");}
if(!pdo_fieldexists('yzzc_sun_system','findtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   `findtime` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_system','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_system')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_taocan` (
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

");

if(!pdo_fieldexists('yzzc_sun_taocan','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_taocan')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id'");}
if(!pdo_fieldexists('yzzc_sun_taocan','type')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_taocan')." ADD   `type` tinyint(1) NOT NULL COMMENT '1.工作日2.周末3.周租4.月租5.年租'");}
if(!pdo_fieldexists('yzzc_sun_taocan','day')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_taocan')." ADD   `day` int(5) NOT NULL COMMENT '天数'");}
if(!pdo_fieldexists('yzzc_sun_taocan','money')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_taocan')." ADD   `money` varchar(10) CHARACTER SET utf8mb4 NOT NULL COMMENT '省多少钱'");}
if(!pdo_fieldexists('yzzc_sun_taocan','createtime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_taocan')." ADD   `createtime` varchar(11) NOT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('yzzc_sun_taocan','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_taocan')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzzc_sun_taocan','status')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_taocan')." ADD   `status` tinyint(1) DEFAULT '1' COMMENT '1.显示 2.下架'");}
if(!pdo_fieldexists('yzzc_sun_taocan','name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_taocan')." ADD   `name` varchar(30) DEFAULT NULL COMMENT '套餐名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_user` (
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

");

if(!pdo_fieldexists('yzzc_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq'");}
if(!pdo_fieldexists('yzzc_sun_user','openid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzzc_sun_user','headimg')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `headimg` varchar(200) DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('yzzc_sun_user','time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `time` varchar(50) DEFAULT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('yzzc_sun_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_user','user_name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `user_name` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_user','user_tel')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `user_tel` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_user','user_address')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `user_address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_user','all_integral')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `all_integral` int(11) DEFAULT '0' COMMENT '总积分'");}
if(!pdo_fieldexists('yzzc_sun_user','now_integral')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `now_integral` int(11) DEFAULT '0' COMMENT '现有积分'");}
if(!pdo_fieldexists('yzzc_sun_user','isadmin')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   `isadmin` tinyint(1) DEFAULT '0' COMMENT '1.管理员'");}
if(!pdo_fieldexists('yzzc_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_user')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_usercity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `time` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

");

if(!pdo_fieldexists('yzzc_sun_usercity','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_usercity')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzzc_sun_usercity','uid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_usercity')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_usercity','city_id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_usercity')." ADD   `city_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_usercity','time')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_usercity')." ADD   `time` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_usercity','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_usercity')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzzc_sun_we` (
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

");

if(!pdo_fieldexists('yzzc_sun_we','id')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关于我们id'");}
if(!pdo_fieldexists('yzzc_sun_we','pic')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD   `pic` varchar(120) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzzc_sun_we','name')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD   `name` varchar(100) NOT NULL COMMENT '第一个标题'");}
if(!pdo_fieldexists('yzzc_sun_we','content')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD   `content` text NOT NULL COMMENT '第一个内容'");}
if(!pdo_fieldexists('yzzc_sun_we','tel')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD   `tel` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_we','address')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD   `address` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_we','lat')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD   `lat` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzzc_sun_we','lng')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD   `lng` varchar(20) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('yzzc_sun_we','selftime')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD   `selftime` datetime DEFAULT NULL COMMENT '存入时间'");}
if(!pdo_fieldexists('yzzc_sun_we','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzzc_sun_we')." ADD   `uniacid` int(11) DEFAULT NULL");}
