<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_acbanner` (
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

");

if(!pdo_fieldexists('mzhk_sun_acbanner','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_acbanner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `lb_imgs` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_acbanner','lb_imgs1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `lb_imgs1` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_acbanner','lb_imgs2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `lb_imgs2` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_acbanner','lb_imgs3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `lb_imgs3` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_acbanner','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_acbanner','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `bname` varchar(110) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_acbanner','bname1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `bname1` varchar(110) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_acbanner','bname2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `bname2` varchar(110) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_acbanner','bname3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `bname3` varchar(110) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_acbanner','lb_imgs4')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `lb_imgs4` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '免单banner图'");}
if(!pdo_fieldexists('mzhk_sun_acbanner','bname4')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acbanner')." ADD   `bname4` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '免单banner名'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_acode` (
  `id` int(11) NOT NULL COMMENT '该id不自动增加',
  `time` varchar(30) NOT NULL COMMENT '时间',
  `code` text NOT NULL COMMENT '码',
  `url` varchar(255) NOT NULL,
  `uncode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_acode','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acode')." ADD 
  `id` int(11) NOT NULL COMMENT '该id不自动增加'");}
if(!pdo_fieldexists('mzhk_sun_acode','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acode')." ADD   `time` varchar(30) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('mzhk_sun_acode','code')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acode')." ADD   `code` text NOT NULL COMMENT '码'");}
if(!pdo_fieldexists('mzhk_sun_acode','url')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_acode')." ADD   `url` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_active` (
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

");

if(!pdo_fieldexists('mzhk_sun_active','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'");}
if(!pdo_fieldexists('mzhk_sun_active','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('mzhk_sun_active','subtitle')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `subtitle` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_active','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `title` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_active','createtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `createtime` int(13) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('mzhk_sun_active','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `content` text NOT NULL COMMENT '文章内容'");}
if(!pdo_fieldexists('mzhk_sun_active','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `sort` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_active','antime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `antime` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_active','hits')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `hits` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_active','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `status` tinyint(10) DEFAULT '0' COMMENT '0审核中1审核通过'");}
if(!pdo_fieldexists('mzhk_sun_active','astime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `astime` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_active','thumb')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `thumb` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_active','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `num` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_active','sharenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `sharenum` int(11) DEFAULT NULL COMMENT '每天可分享次数'");}
if(!pdo_fieldexists('mzhk_sun_active','thumb_url')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `thumb_url` text");}
if(!pdo_fieldexists('mzhk_sun_active','part_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `part_num` varchar(15) DEFAULT '0' COMMENT '参与人数'");}
if(!pdo_fieldexists('mzhk_sun_active','share_plus')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `share_plus` varchar(15) DEFAULT '1' COMMENT '分享之后可得的次数'");}
if(!pdo_fieldexists('mzhk_sun_active','new_partnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `new_partnum` varchar(15) DEFAULT NULL COMMENT '初始虚拟参与人数'");}
if(!pdo_fieldexists('mzhk_sun_active','user_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `user_id` varchar(100) DEFAULT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('mzhk_sun_active','storeinfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `storeinfo` varchar(200) DEFAULT NULL COMMENT '店铺信息'");}
if(!pdo_fieldexists('mzhk_sun_active','showindex')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `showindex` int(11) DEFAULT NULL COMMENT '0不显示1显示'");}
if(!pdo_fieldexists('mzhk_sun_active','active_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_active')." ADD   `active_num` int(11) DEFAULT NULL COMMENT '活动商品数量'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_area` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sort` int(10) NOT NULL COMMENT '排序',
  `name` varchar(50) NOT NULL COMMENT '商圈名称',
  `status` tinyint(10) NOT NULL DEFAULT '0' COMMENT '显示状态 0 不显示 1 显示',
  `time` varchar(100) NOT NULL COMMENT '添加时间',
  `uniacid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_area','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_area')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_area','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_area')." ADD   `sort` int(10) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_area','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_area')." ADD   `name` varchar(50) NOT NULL COMMENT '商圈名称'");}
if(!pdo_fieldexists('mzhk_sun_area','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_area')." ADD   `status` tinyint(10) NOT NULL DEFAULT '0' COMMENT '显示状态 0 不显示 1 显示'");}
if(!pdo_fieldexists('mzhk_sun_area','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_area')." ADD   `time` varchar(100) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_area','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_area')." ADD   `uniacid` int(10) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_banner` (
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

");

if(!pdo_fieldexists('mzhk_sun_banner','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_banner','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `bname` varchar(200) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','url')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `url` varchar(300) CHARACTER SET utf8 NOT NULL COMMENT 'banner名字'");}
if(!pdo_fieldexists('mzhk_sun_banner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `lb_imgs` varchar(500) CHARACTER SET utf8 NOT NULL COMMENT 'banner图片'");}
if(!pdo_fieldexists('mzhk_sun_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','bname1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `bname1` varchar(200) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','bname2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `bname2` varchar(200) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','bname3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `bname3` varchar(200) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','lb_imgs1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `lb_imgs1` varchar(500) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','lb_imgs2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `lb_imgs2` varchar(500) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','lb_imgs3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `lb_imgs3` varchar(500) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','url1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `url1` varchar(300) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','url2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `url2` varchar(300) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_banner','url3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_banner')." ADD   `url3` varchar(300) CHARACTER SET utf8 NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_benefit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `benefit_name` varchar(50) NOT NULL COMMENT '权益名称',
  `benefit_img` varchar(100) NOT NULL COMMENT '权益图标',
  `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态 0 隐藏 1 显示',
  `addtime` varchar(100) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_benefit','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_benefit')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_benefit','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_benefit')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_benefit','benefit_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_benefit')." ADD   `benefit_name` varchar(50) NOT NULL COMMENT '权益名称'");}
if(!pdo_fieldexists('mzhk_sun_benefit','benefit_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_benefit')." ADD   `benefit_img` varchar(100) NOT NULL COMMENT '权益图标'");}
if(!pdo_fieldexists('mzhk_sun_benefit','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_benefit')." ADD   `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_benefit','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_benefit')." ADD   `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态 0 隐藏 1 显示'");}
if(!pdo_fieldexists('mzhk_sun_benefit','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_benefit')." ADD   `addtime` varchar(100) NOT NULL COMMENT '添加时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_brand` (
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
  `is_counp` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商家单独开启优惠券：1开启，2不开启',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_brand','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD 
  `bid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_brand','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `bname` varchar(120) NOT NULL COMMENT '品牌名称'");}
if(!pdo_fieldexists('mzhk_sun_brand','logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `logo` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_brand','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `content` text COMMENT '品牌描述'");}
if(!pdo_fieldexists('mzhk_sun_brand','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_brand','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_brand','phone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `phone` varchar(100) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('mzhk_sun_brand','address')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `address` varchar(255) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_brand','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_brand','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `type` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_brand','feature')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `feature` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_brand','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_brand','deliveryfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `deliveryfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费'");}
if(!pdo_fieldexists('mzhk_sun_brand','deliverytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `deliverytime` varchar(20) NOT NULL COMMENT '配送时间'");}
if(!pdo_fieldexists('mzhk_sun_brand','deliveryaway')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `deliveryaway` float NOT NULL DEFAULT '0' COMMENT '配送距离'");}
if(!pdo_fieldexists('mzhk_sun_brand','in_openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `in_openid` varchar(255) NOT NULL COMMENT '入驻时提交信息的微信openid'");}
if(!pdo_fieldexists('mzhk_sun_brand','bind_openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `bind_openid` varchar(255) DEFAULT NULL COMMENT '绑定的openid'");}
if(!pdo_fieldexists('mzhk_sun_brand','loginname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `loginname` varchar(50) DEFAULT NULL COMMENT '登陆名'");}
if(!pdo_fieldexists('mzhk_sun_brand','loginpassword')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `loginpassword` varchar(50) DEFAULT NULL COMMENT '登陆密码'");}
if(!pdo_fieldexists('mzhk_sun_brand','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `uname` varchar(50) NOT NULL COMMENT '联系人'");}
if(!pdo_fieldexists('mzhk_sun_brand','starttime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `starttime` varchar(30) DEFAULT NULL COMMENT '营业时间，开始'");}
if(!pdo_fieldexists('mzhk_sun_brand','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `endtime` varchar(30) DEFAULT NULL COMMENT '营业时间，结束'");}
if(!pdo_fieldexists('mzhk_sun_brand','coordinates')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `coordinates` varchar(50) DEFAULT NULL COMMENT '经纬度'");}
if(!pdo_fieldexists('mzhk_sun_brand','longitude')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `longitude` varchar(50) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('mzhk_sun_brand','latitude')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `latitude` varchar(50) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('mzhk_sun_brand','lt_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `lt_id` int(11) NOT NULL DEFAULT '0' COMMENT '入驻周期id'");}
if(!pdo_fieldexists('mzhk_sun_brand','lt_day')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `lt_day` int(11) NOT NULL DEFAULT '0' COMMENT '入驻周期时间'");}
if(!pdo_fieldexists('mzhk_sun_brand','settleintime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `settleintime` int(11) NOT NULL DEFAULT '0' COMMENT '入驻开始时间，用于缴费'");}
if(!pdo_fieldexists('mzhk_sun_brand','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `paytime` int(11) NOT NULL DEFAULT '0' COMMENT '入驻缴费完成时间'");}
if(!pdo_fieldexists('mzhk_sun_brand','facility')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `facility` varchar(50) NOT NULL DEFAULT '0' COMMENT '设施id，用，号分隔'");}
if(!pdo_fieldexists('mzhk_sun_brand','store_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `store_id` int(11) NOT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('mzhk_sun_brand','store_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `store_name` varchar(100) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('mzhk_sun_brand','totalamount')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `totalamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额'");}
if(!pdo_fieldexists('mzhk_sun_brand','frozenamount')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `frozenamount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额'");}
if(!pdo_fieldexists('mzhk_sun_brand','commission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `commission` float NOT NULL DEFAULT '0' COMMENT '佣金比例'");}
if(!pdo_fieldexists('mzhk_sun_brand','memdiscount')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `memdiscount` float NOT NULL DEFAULT '0' COMMENT '会员折扣，线下付款'");}
if(!pdo_fieldexists('mzhk_sun_brand','istop')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶'");}
if(!pdo_fieldexists('mzhk_sun_brand','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_brand','enable_printer')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `enable_printer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0关闭，1开启打印机'");}
if(!pdo_fieldexists('mzhk_sun_brand','backups_printer')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `backups_printer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否打印2份 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_brand','printer_user')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `printer_user` varchar(255) NOT NULL COMMENT '飞蛾打印机账号'");}
if(!pdo_fieldexists('mzhk_sun_brand','printer_ukey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `printer_ukey` varchar(255) NOT NULL COMMENT '飞蛾打印机ukey'");}
if(!pdo_fieldexists('mzhk_sun_brand','printer_sn')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `printer_sn` varchar(255) NOT NULL COMMENT '飞蛾打印机编码'");}
if(!pdo_fieldexists('mzhk_sun_brand','aid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `aid` int(10) NOT NULL COMMENT '商圈id'");}
if(!pdo_fieldexists('mzhk_sun_brand','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_brand','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_brand','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
if(!pdo_fieldexists('mzhk_sun_brand','codeimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `codeimg` varchar(100) NOT NULL COMMENT '小程序码'");}
if(!pdo_fieldexists('mzhk_sun_brand','codeimgsrc')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `codeimgsrc` varchar(200) NOT NULL COMMENT '小程序码路劲'");}
if(!pdo_fieldexists('mzhk_sun_brand','brand_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `brand_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关闭商家 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_brand','time_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `time_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否营业时间内经营 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_brand','open_payment')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `open_payment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用线下付 0 关闭 1启用'");}
if(!pdo_fieldexists('mzhk_sun_brand','cimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `cimg` varchar(255) DEFAULT NULL COMMENT '商家详情导航图'");}
if(!pdo_fieldexists('mzhk_sun_brand','is_delivery')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `is_delivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送 0 关闭 1启用'");}
if(!pdo_fieldexists('mzhk_sun_brand','delivery_start')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `delivery_start` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '起配费'");}
if(!pdo_fieldexists('mzhk_sun_brand','delivery_free')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `delivery_free` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免配费'");}
if(!pdo_fieldexists('mzhk_sun_brand','delivery_price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `delivery_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费'");}
if(!pdo_fieldexists('mzhk_sun_brand','delivery_distance')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `delivery_distance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送范围'");}
if(!pdo_fieldexists('mzhk_sun_brand','group')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `group` text COMMENT '配送设置'");}
if(!pdo_fieldexists('mzhk_sun_brand','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `sub_mch_id` varchar(200) NOT NULL COMMENT '商家子账户'");}
if(!pdo_fieldexists('mzhk_sun_brand','is_counp')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brand')." ADD   `is_counp` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商家单独开启优惠券：1开启，2不开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_brandpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未完成支付，1已经支付',
  `paytime` int(11) NOT NULL COMMENT '支付时间',
  `out_trade_no` varchar(50) NOT NULL COMMENT '外部订单号',
  `openid` varchar(200) NOT NULL COMMENT '支付的openid',
  `uniacid` int(11) NOT NULL COMMENT '应用id',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_brandpaylog','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brandpaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_brandpaylog','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brandpaylog')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_brandpaylog','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brandpaylog')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未完成支付，1已经支付'");}
if(!pdo_fieldexists('mzhk_sun_brandpaylog','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brandpaylog')." ADD   `paytime` int(11) NOT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('mzhk_sun_brandpaylog','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brandpaylog')." ADD   `out_trade_no` varchar(50) NOT NULL COMMENT '外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_brandpaylog','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brandpaylog')." ADD   `openid` varchar(200) NOT NULL COMMENT '支付的openid'");}
if(!pdo_fieldexists('mzhk_sun_brandpaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brandpaylog')." ADD   `uniacid` int(11) NOT NULL COMMENT '应用id'");}
if(!pdo_fieldexists('mzhk_sun_brandpaylog','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_brandpaylog')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cardcollect` (
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

");

if(!pdo_fieldexists('mzhk_sun_cardcollect','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cardcollect','card_str_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD   `card_str_id` text NOT NULL COMMENT '收集的卡片id列表'");}
if(!pdo_fieldexists('mzhk_sun_cardcollect','card_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD   `card_img` varchar(200) NOT NULL COMMENT '卡片图'");}
if(!pdo_fieldexists('mzhk_sun_cardcollect','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD   `openid` varchar(200) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_cardcollect','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD   `gid` int(11) NOT NULL COMMENT '活动id'");}
if(!pdo_fieldexists('mzhk_sun_cardcollect','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD   `addtime` int(11) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_cardcollect','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_cardcollect','allnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD   `allnum` int(11) NOT NULL DEFAULT '0' COMMENT '总次数'");}
if(!pdo_fieldexists('mzhk_sun_cardcollect','usednum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD   `usednum` int(11) NOT NULL DEFAULT '0' COMMENT '已使用次数'");}
if(!pdo_fieldexists('mzhk_sun_cardcollect','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardcollect')." ADD   `endtime` int(11) NOT NULL COMMENT '活动结束时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cardorder` (
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

");

if(!pdo_fieldexists('mzhk_sun_cardorder','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cardorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `openid` varchar(200) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `gid` int(11) NOT NULL COMMENT '集卡活动id'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `addtime` int(11) NOT NULL COMMENT '集成时间'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','ordernum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `ordernum` varchar(50) NOT NULL COMMENT '编号'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','detailinfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `detailinfo` varchar(100) NOT NULL COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','telnumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `telnumber` varchar(30) NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0未发货，1已发货，2已领取'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','countyname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `countyname` varchar(20) NOT NULL COMMENT '区域'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','provincename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `provincename` varchar(20) NOT NULL COMMENT '省份'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `name` varchar(30) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','cityname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `cityname` varchar(20) NOT NULL COMMENT '城市'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','shiptime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `shiptime` int(11) NOT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `endtime` int(11) NOT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `gname` varchar(200) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','sincetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `sincetype` varchar(100) NOT NULL DEFAULT '0' COMMENT '发货类型'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `time` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_cardorder','uremark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `uremark` varchar(100) NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','isrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','goodsimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `goodsimg` varchar(200) NOT NULL COMMENT '商品图'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `bname` int(11) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '数量'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','deliveryfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `deliveryfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `out_trade_no` varchar(100) NOT NULL COMMENT '外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','shipnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `shipnum` varchar(50) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','shipname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `shipname` varchar(50) NOT NULL COMMENT '快递名称'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `finishtime` int(11) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `expirationtime` int(11) NOT NULL COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_cardorder','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardorder')." ADD   `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cardshare` (
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

");

if(!pdo_fieldexists('mzhk_sun_cardshare','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardshare')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cardshare','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardshare')." ADD   `addtime` int(11) NOT NULL COMMENT '分享时间'");}
if(!pdo_fieldexists('mzhk_sun_cardshare','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardshare')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1成功，0失败'");}
if(!pdo_fieldexists('mzhk_sun_cardshare','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardshare')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_cardshare','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardshare')." ADD   `gid` int(11) NOT NULL COMMENT 'gid'");}
if(!pdo_fieldexists('mzhk_sun_cardshare','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardshare')." ADD   `openid` varchar(200) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_cardshare','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardshare')." ADD   `num` int(11) NOT NULL COMMENT '当天分享次数'");}
if(!pdo_fieldexists('mzhk_sun_cardshare','click_user_str')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cardshare')." ADD   `click_user_str` text NOT NULL COMMENT '点击人，用英文逗号隔开'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_catebanner` (
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

");

if(!pdo_fieldexists('mzhk_sun_catebanner','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_catebanner','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_catebanner','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD   `name` varchar(100) NOT NULL COMMENT '分类轮播图名称'");}
if(!pdo_fieldexists('mzhk_sun_catebanner','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD   `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_catebanner','cateid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD   `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '所属栏目id'");}
if(!pdo_fieldexists('mzhk_sun_catebanner','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD   `img` varchar(100) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('mzhk_sun_catebanner','link')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD   `link` int(11) NOT NULL DEFAULT '0' COMMENT '链接'");}
if(!pdo_fieldexists('mzhk_sun_catebanner','pop_urltxt')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD   `pop_urltxt` int(11) NOT NULL DEFAULT '0' COMMENT '相关 id'");}
if(!pdo_fieldexists('mzhk_sun_catebanner','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态 0 隐藏 1 显示'");}
if(!pdo_fieldexists('mzhk_sun_catebanner','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_catebanner')." ADD   `time` varchar(50) NOT NULL DEFAULT '0' COMMENT '添加时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_circle` (
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

");

if(!pdo_fieldexists('mzhk_sun_circle','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_circle','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `openid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_circle','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_circle','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `content` text NOT NULL COMMENT '圈子内容'");}
if(!pdo_fieldexists('mzhk_sun_circle','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `img` text NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('mzhk_sun_circle','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `addtime` int(11) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_circle','commentnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `commentnum` int(11) NOT NULL COMMENT '评论数'");}
if(!pdo_fieldexists('mzhk_sun_circle','likenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `likenum` int(11) NOT NULL COMMENT '点赞数'");}
if(!pdo_fieldexists('mzhk_sun_circle','isshow')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示'");}
if(!pdo_fieldexists('mzhk_sun_circle','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_circle','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `oid` int(11) NOT NULL DEFAULT '0' COMMENT '评论关联订单id'");}
if(!pdo_fieldexists('mzhk_sun_circle','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '评论关联商品id'");}
if(!pdo_fieldexists('mzhk_sun_circle','star')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `star` int(11) NOT NULL DEFAULT '0' COMMENT '评论星级'");}
if(!pdo_fieldexists('mzhk_sun_circle','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '首页推荐 0 不推荐 1 推荐'");}
if(!pdo_fieldexists('mzhk_sun_circle','isdeshow')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `isdeshow` int(11) NOT NULL DEFAULT '1' COMMENT '是否详情页显示 0 不显示 1 显示'");}
if(!pdo_fieldexists('mzhk_sun_circle','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circle')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_circlecomment` (
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_circlecomment','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlecomment')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_circlecomment','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlecomment')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_circlecomment','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlecomment')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_circlecomment','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlecomment')." ADD   `cid` int(11) NOT NULL COMMENT '圈子id'");}
if(!pdo_fieldexists('mzhk_sun_circlecomment','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlecomment')." ADD   `content` text NOT NULL COMMENT '评论内容'");}
if(!pdo_fieldexists('mzhk_sun_circlecomment','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlecomment')." ADD   `uname` varchar(255) NOT NULL COMMENT '评论人姓名'");}
if(!pdo_fieldexists('mzhk_sun_circlecomment','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlecomment')." ADD   `uid` int(11) NOT NULL COMMENT '评论人id'");}
if(!pdo_fieldexists('mzhk_sun_circlecomment','uimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlecomment')." ADD   `uimg` varchar(255) NOT NULL COMMENT '评论人头像'");}
if(!pdo_fieldexists('mzhk_sun_circlecomment','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlecomment')." ADD   `addtime` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_circlelike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'uid',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `cid` int(11) NOT NULL COMMENT '圈子id',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uimg` varchar(255) NOT NULL COMMENT '用户头像',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_circlelike','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlelike')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_circlelike','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlelike')." ADD   `uid` int(11) NOT NULL COMMENT 'uid'");}
if(!pdo_fieldexists('mzhk_sun_circlelike','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlelike')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_circlelike','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlelike')." ADD   `cid` int(11) NOT NULL COMMENT '圈子id'");}
if(!pdo_fieldexists('mzhk_sun_circlelike','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlelike')." ADD   `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");}
if(!pdo_fieldexists('mzhk_sun_circlelike','uimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlelike')." ADD   `uimg` varchar(255) NOT NULL COMMENT '用户头像'");}
if(!pdo_fieldexists('mzhk_sun_circlelike','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_circlelike')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_city` (
  `id` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL COMMENT '用户openid',
  `province` varchar(50) NOT NULL COMMENT '省',
  `city` varchar(50) NOT NULL COMMENT '市',
  `district` varchar(50) NOT NULL COMMENT '县',
  `uniacid` int(11) NOT NULL,
  `lat` varchar(255) NOT NULL COMMENT '纬度',
  `lng` varchar(255) NOT NULL COMMENT '经度'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_city','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_city')." ADD 
  `id` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_city','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_city')." ADD   `openid` varchar(100) NOT NULL COMMENT '用户openid'");}
if(!pdo_fieldexists('mzhk_sun_city','province')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_city')." ADD   `province` varchar(50) NOT NULL COMMENT '省'");}
if(!pdo_fieldexists('mzhk_sun_city','city')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_city')." ADD   `city` varchar(50) NOT NULL COMMENT '市'");}
if(!pdo_fieldexists('mzhk_sun_city','district')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_city')." ADD   `district` varchar(50) NOT NULL COMMENT '县'");}
if(!pdo_fieldexists('mzhk_sun_city','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_city')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_city','lat')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_city')." ADD   `lat` varchar(255) NOT NULL COMMENT '纬度'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cloud_detailed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `shopname` varchar(100) NOT NULL COMMENT '�Ƶ�����',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƶ�id',
  `mcd_type` int(11) NOT NULL DEFAULT '0' COMMENT '���ͣ�1�Ƶ궩�����룬2���֣�3�����Ƶ���פ',
  `mcd_memo` varchar(200) NOT NULL COMMENT '��������Ⱦ�����Ϣ',
  `addtime` varchar(100) NOT NULL COMMENT 'ʱ��',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���ֵ�ʱ��֧����Ӷ��',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '״̬��1�ɹ���2���ɹ�',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '����id',
  `wd_id` int(11) NOT NULL DEFAULT '0' COMMENT '����id',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������',
  `out_trade_no` varchar(100) NOT NULL COMMENT '�ⲿ������',
  `is_store_submac` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ʹ���̼����̻����տ0δ���ã�1����',
  `sub_mch_id` varchar(100) NOT NULL COMMENT '���̻���id',
  `pshopid` int(11) NOT NULL DEFAULT '0' COMMENT '������פ�Ƶ�id',
  `sign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '���� 0�Ӻ� 1����',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_cloud_detailed','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','shopname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `shopname` varchar(100) NOT NULL COMMENT '�Ƶ�����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','shopid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƶ�id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','mcd_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `mcd_type` int(11) NOT NULL DEFAULT '0' COMMENT '���ͣ�1�Ƶ궩�����룬2���֣�3�����Ƶ���פ'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','mcd_memo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `mcd_memo` varchar(200) NOT NULL COMMENT '��������Ⱦ�����Ϣ'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `addtime` varchar(100) NOT NULL COMMENT 'ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','paycommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���ֵ�ʱ��֧����Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `status` int(11) NOT NULL DEFAULT '1' COMMENT '״̬��1�ɹ���2���ɹ�'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','order_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '����id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','wd_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `wd_id` int(11) NOT NULL DEFAULT '0' COMMENT '����id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `out_trade_no` varchar(100) NOT NULL COMMENT '�ⲿ������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `is_store_submac` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ʹ���̼����̻����տ0δ���ã�1����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `sub_mch_id` varchar(100) NOT NULL COMMENT '���̻���id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','pshopid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `pshopid` int(11) NOT NULL DEFAULT '0' COMMENT '������פ�Ƶ�id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_detailed','sign')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_detailed')." ADD   `sign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '���� 0�Ӻ� 1����'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cloud_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '������Ʒid',
  `lid` int(11) NOT NULL DEFAULT '0' COMMENT '������Ʒ����  1��ͨ 2���� 3ƴ�� 5���� 12�ο�',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƶ�id',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '״̬ 0�ϼ� 1�¼�',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_cloud_goods','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cloud_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_goods')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_cloud_goods','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_goods')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '������Ʒid'");}
if(!pdo_fieldexists('mzhk_sun_cloud_goods','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_goods')." ADD   `lid` int(11) NOT NULL DEFAULT '0' COMMENT '������Ʒ����  1��ͨ 2���� 3ƴ�� 5���� 12�ο�'");}
if(!pdo_fieldexists('mzhk_sun_cloud_goods','shopid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_goods')." ADD   `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƶ�id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_goods','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_goods')." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '״̬ 0�ϼ� 1�¼�'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cloud_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `ordertype` int(11) NOT NULL DEFAULT '1' COMMENT '��Ʒ���� 1��ͨ 2���� 3ƴ�� 5���� 12�ο�',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '����id',
  `rebate` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ��ڹ� 0�� 1��',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '������id',
  `is_delete` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ɾ��������ʶ���Ƿ���������Ӷ�𣩣�0δ��1ɾ',
  `openid` varchar(100) NOT NULL COMMENT '�û�openid',
  `cloudprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�Ƶ�Ӷ��',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�����Ƶ�',
  `addtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `dtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_cloud_order','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','ordertype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `ordertype` int(11) NOT NULL DEFAULT '1' COMMENT '��Ʒ���� 1��ͨ 2���� 3ƴ�� 5���� 12�ο�'");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','order_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '����id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','rebate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `rebate` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ��ڹ� 0�� 1��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','user_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '������id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','is_delete')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `is_delete` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ɾ��������ʶ���Ƿ���������Ӷ�𣩣�0δ��1ɾ'");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `openid` varchar(100) NOT NULL COMMENT '�û�openid'");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','cloudprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `cloudprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�Ƶ�Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','shopid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�����Ƶ�'");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `addtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_order','dtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_order')." ADD   `dtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cloud_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `cloud_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�����Ƶ� 0�ر� 1����',
  `toexamine_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '������� 0�ر� 1���',
  `cloud_proportion` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�Ƶ�Ӷ��ռ��',
  `settled_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��פģʽ 0���� 1����',
  `settled_days` int(11) NOT NULL DEFAULT '1' COMMENT '��פ����',
  `settled_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��פ���',
  `invite_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '������פӶ������ 0�ٷֱ� 1�̶����',
  `invite_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����Ӷ��',
  `apply_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�������� 0�ǻ�Ա 1��Ա',
  `internal_purchase` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƶ��ڹ� 0�ر� 1����',
  `apply_banner` varchar(100) NOT NULL COMMENT '����ҳ�涥��ͼ',
  `apply_agreement` text NOT NULL COMMENT '����Э��',
  `withdraw_type` varchar(50) NOT NULL DEFAULT '1' COMMENT '���ַ�ʽ��1΢��֧�� 2֧����֧�� 3���п�֧�� 4���֧��',
  `min_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�������ֶ��',
  `day_maxwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'ÿ����������',
  `withdraw_handingfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����������',
  `withdraw_notes` text NOT NULL COMMENT '�û�������֪',
  `poster_title` varchar(100) NOT NULL COMMENT '��������',
  `poster_img` varchar(100) NOT NULL COMMENT '����ͼƬ',
  `toindex_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '��ҳ������ʾ 0���� 1��ʾ',
  `cloud_name` varchar(50) NOT NULL COMMENT '�Ƶ������Զ���',
  `cloud_shopowner` varchar(50) NOT NULL COMMENT '�곤�����Զ���',
  `poster_bimg` varchar(100) NOT NULL COMMENT '��������ͼƬ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_cloud_set','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','cloud_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `cloud_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�����Ƶ� 0�ر� 1����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','toexamine_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `toexamine_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '������� 0�ر� 1���'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','cloud_proportion')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `cloud_proportion` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�Ƶ�Ӷ��ռ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','settled_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `settled_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��פģʽ 0���� 1����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','settled_days')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `settled_days` int(11) NOT NULL DEFAULT '1' COMMENT '��פ����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','settled_money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `settled_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��פ���'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','invite_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `invite_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '������פӶ������ 0�ٷֱ� 1�̶����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','invite_money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `invite_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','apply_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `apply_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�������� 0�ǻ�Ա 1��Ա'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','internal_purchase')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `internal_purchase` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƶ��ڹ� 0�ر� 1����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','apply_banner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `apply_banner` varchar(100) NOT NULL COMMENT '����ҳ�涥��ͼ'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','apply_agreement')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `apply_agreement` text NOT NULL COMMENT '����Э��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','withdraw_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `withdraw_type` varchar(50) NOT NULL DEFAULT '1' COMMENT '���ַ�ʽ��1΢��֧�� 2֧����֧�� 3���п�֧�� 4���֧��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','min_withdraw')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `min_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�������ֶ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','day_maxwithdraw')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `day_maxwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'ÿ����������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','withdraw_handingfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `withdraw_handingfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','withdraw_notes')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `withdraw_notes` text NOT NULL COMMENT '�û�������֪'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','poster_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `poster_title` varchar(100) NOT NULL COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','poster_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `poster_img` varchar(100) NOT NULL COMMENT '����ͼƬ'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','toindex_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `toindex_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '��ҳ������ʾ 0���� 1��ʾ'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','cloud_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `cloud_name` varchar(50) NOT NULL COMMENT '�Ƶ������Զ���'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','cloud_shopowner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `cloud_shopowner` varchar(50) NOT NULL COMMENT '�곤�����Զ���'");}
if(!pdo_fieldexists('mzhk_sun_cloud_set','poster_bimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_set')." ADD   `poster_bimg` varchar(100) NOT NULL COMMENT '��������ͼƬ'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cloud_shopkeeper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL COMMENT '�û�openid',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '�û�id',
  `uname` varchar(50) NOT NULL COMMENT '�û�����',
  `allcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�ۼ�Ӷ��',
  `canwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������Ӷ��',
  `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���ֶ���Ľ��',
  `welcoming` varchar(200) NOT NULL COMMENT '��ӭ��',
  `shopname` varchar(100) NOT NULL COMMENT '��������',
  `mobilephone` varchar(50) NOT NULL COMMENT '�ֻ���',
  `settledintyspe` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��פ���� 0���� 1����',
  `addtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `effectivetime` varchar(100) NOT NULL COMMENT '��פ��Чʱ��',
  `shopcontacts` varchar(200) NOT NULL COMMENT '���̼��',
  `shopbanner` varchar(200) NOT NULL COMMENT '�����ֲ�ͼ',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '״̬��0����У�1ͨ����2�ܾ�',
  `checktime` varchar(100) NOT NULL COMMENT '���ʱ��',
  `uimg` varchar(200) NOT NULL COMMENT '�û�ͷ��',
  `referrer_shopname` varchar(100) NOT NULL COMMENT '�Ƽ���������',
  `referrer_shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƽ�����id',
  `contacts` varchar(50) NOT NULL COMMENT '��ϵ��',
  `out_trade_no` varchar(100) NOT NULL COMMENT '֧���ⲿ������',
  `settledinmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��פ���',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `openid` varchar(100) NOT NULL COMMENT '�û�openid'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `uid` int(11) NOT NULL DEFAULT '0' COMMENT '�û�id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `uname` varchar(50) NOT NULL COMMENT '�û�����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','allcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `allcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�ۼ�Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','canwithdraw')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `canwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','freezemoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���ֶ���Ľ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','welcoming')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `welcoming` varchar(200) NOT NULL COMMENT '��ӭ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','shopname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `shopname` varchar(100) NOT NULL COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','mobilephone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `mobilephone` varchar(50) NOT NULL COMMENT '�ֻ���'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','settledintyspe')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `settledintyspe` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��פ���� 0���� 1����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `addtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','effectivetime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `effectivetime` varchar(100) NOT NULL COMMENT '��פ��Чʱ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','shopcontacts')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `shopcontacts` varchar(200) NOT NULL COMMENT '���̼��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','shopbanner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `shopbanner` varchar(200) NOT NULL COMMENT '�����ֲ�ͼ'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '״̬��0����У�1ͨ����2�ܾ�'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','checktime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `checktime` varchar(100) NOT NULL COMMENT '���ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','uimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `uimg` varchar(200) NOT NULL COMMENT '�û�ͷ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','referrer_shopname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `referrer_shopname` varchar(100) NOT NULL COMMENT '�Ƽ���������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','referrer_shopid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `referrer_shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƽ�����id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','contacts')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `contacts` varchar(50) NOT NULL COMMENT '��ϵ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `out_trade_no` varchar(100) NOT NULL COMMENT '֧���ⲿ������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_shopkeeper','settledinmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_shopkeeper')." ADD   `settledinmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��פ���'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cloud_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL COMMENT '����',
  `account` varchar(100) NOT NULL COMMENT '�����˺�',
  `withdrawaltype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '���ַ�ʽ��1΢�ţ�2֧������3���п���4���',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '����״̬��0����1�Ѿ���2�ܾ�',
  `time` varchar(100) NOT NULL COMMENT 'ʱ��',
  `mobilephone` varchar(100) NOT NULL COMMENT '�ֻ���',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���ֽ��',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'ʵ�ʽ��',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������',
  `meno` varchar(100) NOT NULL COMMENT '��ע',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '�û�id',
  `form_id` varchar(100) NOT NULL COMMENT 'form_id',
  `bankname` varchar(100) NOT NULL COMMENT '��������',
  `fbankname` varchar(100) NOT NULL COMMENT '֧������',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƶ�id',
  `shopname` varchar(100) NOT NULL COMMENT '�Ƶ�����',
  `openid` varchar(100) NOT NULL COMMENT '�û�openid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `uname` varchar(100) NOT NULL COMMENT '����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','account')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `account` varchar(100) NOT NULL COMMENT '�����˺�'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','withdrawaltype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `withdrawaltype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '���ַ�ʽ��1΢�ţ�2֧������3���п���4���'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '����״̬��0����1�Ѿ���2�ܾ�'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `time` varchar(100) NOT NULL COMMENT 'ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','mobilephone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `mobilephone` varchar(100) NOT NULL COMMENT '�ֻ���'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���ֽ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','realmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'ʵ�ʽ��'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','meno')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `meno` varchar(100) NOT NULL COMMENT '��ע'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `uid` int(11) NOT NULL DEFAULT '0' COMMENT '�û�id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','form_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `form_id` varchar(100) NOT NULL COMMENT 'form_id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','bankname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `bankname` varchar(100) NOT NULL COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','fbankname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `fbankname` varchar(100) NOT NULL COMMENT '֧������'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','shopid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƶ�id'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','shopname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `shopname` varchar(100) NOT NULL COMMENT '�Ƶ�����'");}
if(!pdo_fieldexists('mzhk_sun_cloud_withdraw','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cloud_withdraw')." ADD   `openid` varchar(100) NOT NULL COMMENT '�û�openid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_coupon` (
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
  `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金占比',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_coupon','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('mzhk_sun_coupon','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `title` varchar(255) NOT NULL COMMENT '优惠券名称，展示用'");}
if(!pdo_fieldexists('mzhk_sun_coupon','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `type` tinyint(3) unsigned DEFAULT NULL COMMENT '优惠券类型（1:折扣 2:满减 3;赠送）'");}
if(!pdo_fieldexists('mzhk_sun_coupon','astime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `astime` timestamp NULL DEFAULT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('mzhk_sun_coupon','antime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `antime` timestamp NULL DEFAULT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('mzhk_sun_coupon','expiryDate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `expiryDate` int(10) unsigned DEFAULT NULL COMMENT '领取后，使用有效期'");}
if(!pdo_fieldexists('mzhk_sun_coupon','allowance')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `allowance` int(10) unsigned DEFAULT NULL COMMENT '余量'");}
if(!pdo_fieldexists('mzhk_sun_coupon','total')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `total` int(10) unsigned DEFAULT NULL COMMENT '总量'");}
if(!pdo_fieldexists('mzhk_sun_coupon','val')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `val` int(25) DEFAULT NULL COMMENT '功能'");}
if(!pdo_fieldexists('mzhk_sun_coupon','showIndex')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `showIndex` tinyint(4) DEFAULT NULL COMMENT '是否首页显示（0:不显示 1:显示）'");}
if(!pdo_fieldexists('mzhk_sun_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_coupon','vab')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `vab` int(11) DEFAULT NULL COMMENT '满减'");}
if(!pdo_fieldexists('mzhk_sun_coupon','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `state` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_coupon','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `bid` varchar(50) DEFAULT NULL COMMENT '商店id'");}
if(!pdo_fieldexists('mzhk_sun_coupon','remarks')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `remarks` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_coupon','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `money` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_coupon','mj')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `mj` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_coupon','md')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `md` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_coupon','is_counp')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `is_counp` int(11) DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_coupon','isvip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `isvip` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否会员领取，1会员，0非会员'");}
if(!pdo_fieldexists('mzhk_sun_coupon','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `content` text NOT NULL COMMENT '优惠券详情'");}
if(!pdo_fieldexists('mzhk_sun_coupon','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `img` varchar(200) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('mzhk_sun_coupon','isdelete')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `isdelete` int(11) NOT NULL DEFAULT '0' COMMENT '是否删除，软删除'");}
if(!pdo_fieldexists('mzhk_sun_coupon','originalprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价'");}
if(!pdo_fieldexists('mzhk_sun_coupon','currentprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `currentprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现价'");}
if(!pdo_fieldexists('mzhk_sun_coupon','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `cid` int(11) NOT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('mzhk_sun_coupon','money_rate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `money_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认支付金额比例'");}
if(!pdo_fieldexists('mzhk_sun_coupon','score_rate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `score_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认兑换积分比例'");}
if(!pdo_fieldexists('mzhk_sun_coupon','distribution_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启'");}
if(!pdo_fieldexists('mzhk_sun_coupon','distribution_commissiontype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1百分比，2固定金额'");}
if(!pdo_fieldexists('mzhk_sun_coupon','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('mzhk_sun_coupon','secondmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('mzhk_sun_coupon','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
if(!pdo_fieldexists('mzhk_sun_coupon','img_details')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `img_details` varchar(400) NOT NULL COMMENT '商家发布商品详情图'");}
if(!pdo_fieldexists('mzhk_sun_coupon','brelease')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `brelease` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否商家发布商品 0 不是 1 是'");}
if(!pdo_fieldexists('mzhk_sun_coupon','selftime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `selftime` varchar(200) DEFAULT NULL COMMENT '加入时间'");}
if(!pdo_fieldexists('mzhk_sun_coupon','totalcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_coupon')." ADD   `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金占比'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_couponcate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `catename` varchar(255) NOT NULL COMMENT '分类名称',
  `sort` int(5) NOT NULL COMMENT '排序',
  `cateimg` varchar(255) NOT NULL COMMENT '分类图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_couponcate','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_couponcate')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_couponcate','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_couponcate')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_couponcate','catename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_couponcate')." ADD   `catename` varchar(255) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('mzhk_sun_couponcate','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_couponcate')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_couponcate','cateimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_couponcate')." ADD   `cateimg` varchar(255) NOT NULL COMMENT '分类图'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cuthelp` (
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
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_cuthelp','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cuthelp','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD   `openid` varchar(200) NOT NULL COMMENT '帮砍人openid'");}
if(!pdo_fieldexists('mzhk_sun_cuthelp','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD   `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_cuthelp','username')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD   `username` varchar(100) NOT NULL COMMENT '帮砍人名称'");}
if(!pdo_fieldexists('mzhk_sun_cuthelp','cs_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD   `cs_id` int(11) NOT NULL DEFAULT '0' COMMENT '砍主id'");}
if(!pdo_fieldexists('mzhk_sun_cuthelp','isself')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD   `isself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0帮砍，1自砍'");}
if(!pdo_fieldexists('mzhk_sun_cuthelp','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD   `gid` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_cuthelp','nowprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD   `nowprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前价格'");}
if(!pdo_fieldexists('mzhk_sun_cuthelp','cutprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD   `cutprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍掉价格'");}
if(!pdo_fieldexists('mzhk_sun_cuthelp','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cuthelp')." ADD   `addtime` int(11) NOT NULL COMMENT '时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_cutself` (
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
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_cutself','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_cutself','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `openid` varchar(200) NOT NULL COMMENT '砍价openid'");}
if(!pdo_fieldexists('mzhk_sun_cutself','username')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `username` varchar(50) NOT NULL COMMENT '砍价用户名'");}
if(!pdo_fieldexists('mzhk_sun_cutself','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_cutself','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_cutself','shopprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `shopprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价'");}
if(!pdo_fieldexists('mzhk_sun_cutself','nowprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `nowprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前价格'");}
if(!pdo_fieldexists('mzhk_sun_cutself','lavenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `lavenum` int(11) NOT NULL COMMENT '剩余人数'");}
if(!pdo_fieldexists('mzhk_sun_cutself','allnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `allnum` int(11) NOT NULL DEFAULT '0' COMMENT '总次数'");}
if(!pdo_fieldexists('mzhk_sun_cutself','lowprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `lowprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低价格'");}
if(!pdo_fieldexists('mzhk_sun_cutself','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `addtime` int(11) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('mzhk_sun_cutself','is_buy')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_cutself')." ADD   `is_buy` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否已经下单，0未下单，1已经下单'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_deliveryorder` (
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

");

if(!pdo_fieldexists('mzhk_sun_deliveryorder','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD 
  `oid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','orderNum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `orderNum` varchar(50) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','detailInfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','telNumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `telNumber` varchar(100) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '总价'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `status` varchar(255) DEFAULT '2' COMMENT '1 取消订单，2待支付，3待配送，4配送中，5已完成'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `openid` varchar(150) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','countyName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `countyName` varchar(150) DEFAULT NULL COMMENT '区域'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','provinceName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `provinceName` varchar(150) DEFAULT NULL COMMENT '省份'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `name` varchar(100) DEFAULT NULL COMMENT '名字'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `addtime` varchar(100) DEFAULT NULL COMMENT '加入的时间'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','cityName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `cityName` varchar(100) DEFAULT NULL COMMENT '城市'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','uremark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `uremark` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','sincetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `sincetype` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `paytime` int(11) NOT NULL COMMENT '付款时间'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `out_trade_no` varchar(100) NOT NULL COMMENT '外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','ordertype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `ordertype` tinyint(1) NOT NULL COMMENT '类型，待用'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','deliveryfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `deliveryfee` decimal(10,2) NOT NULL COMMENT '配送费'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `bname` varchar(100) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','isrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','shipnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `shipnum` varchar(50) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','shipname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `shipname` varchar(50) NOT NULL COMMENT '快递名称'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','shiptime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `shiptime` int(11) NOT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `finishtime` int(11) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `expirationtime` int(11) NOT NULL COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','rmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','source')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','fbid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','returnsign')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `returnsign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买会员赠送标识 0 非赠送 1 赠送'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','viplogid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `viplogid` int(11) NOT NULL DEFAULT '0' COMMENT '会员订单id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorder','vipid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorder')." ADD   `vipid` int(11) NOT NULL DEFAULT '0' COMMENT '会员id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_deliveryorderdetail` (
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
  `spec` int(11) NOT NULL DEFAULT '0' COMMENT '规格ID',
  `specdetail` varchar(50) NOT NULL DEFAULT '0' COMMENT '所选规格详细',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','orderNum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `orderNum` varchar(50) NOT NULL COMMENT '购物车订单号'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `gid` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `pic` varchar(100) NOT NULL COMMENT '商品图片'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `gname` varchar(100) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `num` int(11) NOT NULL COMMENT '件数'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `price` decimal(10,2) NOT NULL COMMENT '商品单价'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','vipprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `vipprice` decimal(10,2) NOT NULL COMMENT '商品会员价'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `lid` int(1) NOT NULL COMMENT '商品类型，1普通，5抢购'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','spec')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `spec` int(11) NOT NULL DEFAULT '0' COMMENT '规格ID'");}
if(!pdo_fieldexists('mzhk_sun_deliveryorderdetail','specdetail')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_deliveryorderdetail')." ADD   `specdetail` varchar(50) NOT NULL DEFAULT '0' COMMENT '所选规格详细'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_distribution_fission_goods` (
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

");

if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `uniacid` int(10) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','fission_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `fission_name` varchar(200) NOT NULL COMMENT '活动名称'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `bid` int(10) NOT NULL COMMENT '所属商家'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','start_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `start_time` varchar(100) NOT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','end_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `end_time` varchar(100) NOT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','writeoff_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `writeoff_time` varchar(100) NOT NULL COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','explain_use')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `explain_use` varchar(200) NOT NULL COMMENT '使用说明'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','explain_discount')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `explain_discount` varchar(200) NOT NULL COMMENT '使用优惠说明'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','explain_activation')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `explain_activation` varchar(200) NOT NULL COMMENT '激活优惠说明'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','rec_index')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `rec_index` int(11) NOT NULL DEFAULT '0' COMMENT '是否推荐到首页 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','is_upper')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `is_upper` int(11) NOT NULL DEFAULT '0' COMMENT '是否上架 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `pic` varchar(200) NOT NULL COMMENT '缩略图'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `content` text NOT NULL COMMENT '活动详情'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_goods','nums_activation')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_goods')." ADD   `nums_activation` int(11) NOT NULL DEFAULT '5' COMMENT '激活人数'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_distribution_fission_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT '推荐订单id',
  `openid` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '推荐人id',
  `addtime` varchar(100) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_distribution_fission_help','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_help')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_help','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_help')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_help','order_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_help')." ADD   `order_id` int(11) NOT NULL COMMENT '推荐订单id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_help','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_help')." ADD   `openid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_help','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_help')." ADD   `uid` int(11) NOT NULL COMMENT '推荐人id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_help','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_help')." ADD   `addtime` varchar(100) NOT NULL COMMENT '添加时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_distribution_fission_order` (
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
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','fname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `fname` varchar(200) NOT NULL COMMENT '列表券名称'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','stime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `stime` varchar(100) NOT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','etime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `etime` varchar(100) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','wtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `wtime` varchar(100) NOT NULL COMMENT '核销时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','explain')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `explain` varchar(200) NOT NULL COMMENT '使用说明'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','discount')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `discount` varchar(200) NOT NULL COMMENT '优惠说明'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','fid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `fid` int(11) NOT NULL COMMENT '裂变券id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `bid` int(11) NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `openid` varchar(100) NOT NULL COMMENT '用户openid'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','is_activation')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `is_activation` int(11) NOT NULL DEFAULT '0' COMMENT '是否激活 0 未激活  1 已激活'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','atime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `atime` varchar(100) NOT NULL DEFAULT '0' COMMENT '激活时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `addtime` varchar(100) NOT NULL COMMENT '领取时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','give_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `give_num` int(11) NOT NULL DEFAULT '5' COMMENT '可赠送数'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','wfstatus')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `wfstatus` int(11) NOT NULL DEFAULT '0' COMMENT '核销状态 0 未核销 1 已核销'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','wftime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `wftime` varchar(100) NOT NULL COMMENT '核销时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_order','wfcode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_order')." ADD   `wfcode` varchar(100) CHARACTER SET utf8mb4 NOT NULL COMMENT '核销码'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_distribution_fission_set` (
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

");

if(!pdo_fieldexists('mzhk_sun_distribution_fission_set','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_set')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_set')." ADD   `uniacid` int(10) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_set','open_fission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_set')." ADD   `open_fission` int(10) NOT NULL DEFAULT '0' COMMENT '是否开启裂变券 0 不开启 1 开启'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_set','list_banner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_set')." ADD   `list_banner` varchar(100) NOT NULL COMMENT '列表banner图'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_set','icon_user')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_set')." ADD   `icon_user` varchar(100) NOT NULL COMMENT '可使用图标'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_set','icon_activation')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_set')." ADD   `icon_activation` varchar(100) NOT NULL COMMENT '待激活图标'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_set','icon_give')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_set')." ADD   `icon_give` varchar(100) NOT NULL COMMENT '可赠送图标'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_set','detailbanner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_set')." ADD   `detailbanner` varchar(100) NOT NULL COMMENT '详情顶部背景图'");}
if(!pdo_fieldexists('mzhk_sun_distribution_fission_set','index_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_fission_set')." ADD   `index_name` varchar(50) NOT NULL COMMENT '首页展示名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_distribution_order` (
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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_distribution_order','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','ordertype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `ordertype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类别，1普通，2砍价，3拼团，4抢购，5预约'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','order_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `order_id` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '3级id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','first_price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','second_price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','third_price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','rebate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `rebate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自购，0否，1是'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','user_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `user_id` int(11) NOT NULL COMMENT '购买用户id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','is_delete')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（用来识别是否计入可提现佣金），0未，1删'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_distribution_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_order')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_distribution_promoter` (
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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_distribution_promoter','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `name` varchar(30) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','mobilephone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `mobilephone` varchar(30) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','allcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `allcommission` decimal(10,2) NOT NULL COMMENT '累计佣金'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','canwithdraw')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `canwithdraw` decimal(10,2) NOT NULL COMMENT '可提现佣金'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','referrer_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `referrer_name` varchar(100) NOT NULL COMMENT '推荐人'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','referrer_uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `referrer_uid` int(11) NOT NULL COMMENT '推荐人id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态，0审核中，1通过，2拒绝'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `addtime` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','checktime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `checktime` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','meno')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `meno` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','form_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id，发模板消息'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','freezemoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现冻结的金额'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','code_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `code_img` mediumblob NOT NULL COMMENT '小程序码'");}
if(!pdo_fieldexists('mzhk_sun_distribution_promoter','invitation_code')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_promoter')." ADD   `invitation_code` varchar(20) NOT NULL COMMENT '邀请码'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_distribution_set` (
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
  `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金',
  `distribution_proportion` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金占比',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_distribution_set','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销层级,0不开启，1一级，2二级'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','is_buyself')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `is_buyself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销内购，0关闭，1开启'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','lower_condition')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `lower_condition` tinyint(1) NOT NULL DEFAULT '0' COMMENT '成为下线条件，0首次点击链接'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','share_condition')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `share_condition` tinyint(3) NOT NULL DEFAULT '0' COMMENT '成为分销商条件，0无条件但要审核，1申请审核，2不需要审核'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','autoshare')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `autoshare` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费自动成为分销商'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','withdrawtype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `withdrawtype` varchar(100) NOT NULL COMMENT '提现方式,1微信支付,2支付宝支付,3银行卡支付,4余额支付'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','minwithdraw')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `minwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','daymaxwithdraw')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `daymaxwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','withdrawnotice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `withdrawnotice` text NOT NULL COMMENT '用户提现须知'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','tpl_wd_arrival')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `tpl_wd_arrival` varchar(255) NOT NULL COMMENT '提现到账模板消息id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','tpl_wd_fail')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `tpl_wd_fail` varchar(255) NOT NULL COMMENT '提现失败模板消息id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','tpl_share_check')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `tpl_share_check` varchar(255) NOT NULL COMMENT '分销审核模板消息id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','application')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `application` text NOT NULL COMMENT '申请协议'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','applybanner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `applybanner` varchar(255) NOT NULL COMMENT '申请页面banner'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','checkbanner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `checkbanner` varchar(255) NOT NULL COMMENT '待审核页面banner'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','commissiontype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `commissiontype` tinyint(3) NOT NULL DEFAULT '1' COMMENT '分销佣金类型，1百分比，2固定金额'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','firstname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `firstname` varchar(255) NOT NULL COMMENT '一级名称'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','secondname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `secondname` varchar(255) NOT NULL COMMENT '二级名称'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','secondmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','withdrawhandingfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `withdrawhandingfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','thirdname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `thirdname` varchar(50) NOT NULL COMMENT '第三级名称'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '第三级佣金'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','postertoppic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `postertoppic` varchar(255) NOT NULL COMMENT '海报图'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','postertoptitle')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `postertoptitle` varchar(200) NOT NULL COMMENT '海报标题'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','is_offline')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `is_offline` tinyint(1) NOT NULL DEFAULT '0' COMMENT '线下付是否开启分销，0关闭，1开启'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','dsource')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `dsource` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销佣金来源 0 平台 1 商家'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','hbtourl')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `hbtourl` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销海报跳转，0分销中心，1首页'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','commission_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金'");}
if(!pdo_fieldexists('mzhk_sun_distribution_set','distribution_proportion')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_set')." ADD   `distribution_proportion` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金占比'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_distribution_withdraw` (
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

");

if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `uname` varchar(255) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','account')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `account` varchar(20) NOT NULL COMMENT '提现账号'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','withdrawaltype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `withdrawaltype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现方式，1微信，2支付宝，3银行卡，4余额'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现状态，0待打款，1已经打款，2拒绝'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `time` int(11) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','mobilephone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `mobilephone` varchar(30) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','realmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','meno')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `meno` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','form_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','bankname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `bankname` varchar(100) NOT NULL COMMENT '银行名称'");}
if(!pdo_fieldexists('mzhk_sun_distribution_withdraw','fbankname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_distribution_withdraw')." ADD   `fbankname` varchar(100) NOT NULL COMMENT '支行名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_district` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `citycode` varchar(255) NOT NULL,
  `adcode` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL COMMENT '经度',
  `lat` varchar(255) NOT NULL COMMENT '纬度',
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='全国省市';

");

if(!pdo_fieldexists('mzhk_sun_district','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_district')." ADD 
  `id` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_district','parent_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_district')." ADD   `parent_id` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_district','citycode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_district')." ADD   `citycode` varchar(255) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_district','adcode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_district')." ADD   `adcode` varchar(255) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_district','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_district')." ADD   `name` varchar(255) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_district','lng')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_district')." ADD   `lng` varchar(255) NOT NULL COMMENT '经度'");}
if(!pdo_fieldexists('mzhk_sun_district','lat')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_district')." ADD   `lat` varchar(255) NOT NULL COMMENT '纬度'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_eatvisit_goods` (
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

");

if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `gname` varchar(255) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','shopprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `shopprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','thumbnail')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `thumbnail` varchar(200) NOT NULL COMMENT '缩略图'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','tid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `tid` int(11) NOT NULL DEFAULT '2' COMMENT '首页推荐，1推荐，2不推荐'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商品状态，1审核，2通过，3删除'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `content` text NOT NULL COMMENT '商品详情'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `bid` int(11) NOT NULL COMMENT '店铺id'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `num` int(11) NOT NULL COMMENT '库存'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','allnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `allnum` int(11) NOT NULL COMMENT '总数量，不纳入加减的'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','astime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `astime` varchar(30) NOT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','antime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `antime` varchar(30) NOT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','initialdraws')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `initialdraws` int(11) NOT NULL DEFAULT '0' COMMENT '初始抽奖次数'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','shareaddnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `shareaddnum` int(11) NOT NULL DEFAULT '0' COMMENT '分享获取次数'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','sharetitle')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `sharetitle` varchar(255) NOT NULL COMMENT '分销标题'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','shareimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `shareimg` varchar(255) NOT NULL COMMENT '分享图'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','storename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `storename` varchar(255) NOT NULL COMMENT '店铺名'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','is_vip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `is_vip` int(11) NOT NULL DEFAULT '0' COMMENT '是否会员使用，0不是，1是'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','buynum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `buynum` int(11) NOT NULL COMMENT '购买数参与数'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','viewnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `viewnum` int(11) NOT NULL COMMENT '查看人数'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','sharenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `sharenum` int(11) NOT NULL COMMENT '分享次数'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','limitnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `limitnum` int(11) NOT NULL COMMENT '限购'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','isshelf')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `isshelf` tinyint(1) NOT NULL COMMENT '是否上架，0下架，1上架'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `expirationtime` varchar(30) NOT NULL COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','firstprize')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `firstprize` varchar(255) NOT NULL COMMENT '一等奖内容'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','secondprize')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `secondprize` varchar(255) NOT NULL COMMENT '二等奖内容'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','thirdprize')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `thirdprize` varchar(255) NOT NULL COMMENT '三等奖内容'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','fourthprize')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `fourthprize` varchar(255) NOT NULL COMMENT '四等奖内容'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','grandprize')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `grandprize` varchar(255) NOT NULL COMMENT '特等奖内容'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','currentprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `currentprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现价'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','firstprobability')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `firstprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一等奖概率'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','secondprobability')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `secondprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二等奖概率'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','thirdprobability')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `thirdprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三等奖概率'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','fourthprobability')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `fourthprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '四等奖概率'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','grandprobability')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `grandprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '特等奖概率'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','virtualnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `virtualnum` int(11) NOT NULL COMMENT '虚拟领取数'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','firstnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `firstnum` int(11) NOT NULL COMMENT '一等奖数量'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','secondnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `secondnum` int(11) NOT NULL COMMENT '二等奖数量'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','thirdnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `thirdnum` int(11) NOT NULL COMMENT '三等奖数量'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','fourthnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `fourthnum` int(11) NOT NULL COMMENT '四等奖数量'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','grandnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `grandnum` int(11) NOT NULL COMMENT '特等奖数量'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','index_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `index_img` varchar(255) NOT NULL COMMENT '首页图'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','usenotice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `usenotice` text NOT NULL COMMENT '使用须知'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','notwonprize')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `notwonprize` varchar(255) NOT NULL COMMENT '未中奖提示名'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','notwonprobability')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `notwonprobability` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '未中奖概率'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_goods','posterimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_goods')." ADD   `posterimg` varchar(255) NOT NULL COMMENT '海报图'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_eatvisit_lotteryrecord` (
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD   `uid` int(11) NOT NULL COMMENT 'uid'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD   `openid` varchar(200) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD   `gid` int(11) NOT NULL COMMENT '吃探商品id'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','prize')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD   `prize` text NOT NULL COMMENT '奖品'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','allnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD   `allnum` int(11) NOT NULL COMMENT '可抽奖次数'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','usenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD   `usenum` int(11) NOT NULL COMMENT '已使用次数'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','click_user')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD   `click_user` text NOT NULL COMMENT '点击用户id'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_lotteryrecord','awardid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_lotteryrecord')." ADD   `awardid` tinytext NOT NULL COMMENT '保存中奖key'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_eatvisit_order` (
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_eatvisit_order','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `gid` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','storeid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `storeid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `gname` varchar(255) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','storename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `storename` varchar(255) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','award')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `award` tinyint(2) NOT NULL DEFAULT '5' COMMENT '奖项，0特等奖，1一等奖，2二等奖，3三等奖，4四等奖，5未等奖'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','prize')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `prize` varchar(255) NOT NULL COMMENT '奖品'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','ordernum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `ordernum` varchar(200) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','writeoffcode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `writeoffcode` varchar(200) NOT NULL COMMENT '核销码'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，1未使用，2已经使用'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `uid` int(11) NOT NULL COMMENT 'uid'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `addtime` varchar(30) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `finishtime` varchar(30) NOT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_order','gimages')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_order')." ADD   `gimages` varchar(255) NOT NULL COMMENT '商品图'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_eatvisit_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `pic` varchar(255) NOT NULL COMMENT '轮播图',
  `tpl_winnotice` varchar(255) NOT NULL COMMENT '中奖通知模板消息',
  `tpl_newnotice` varchar(255) NOT NULL COMMENT '新品通知模板消息',
  `navname` varchar(50) NOT NULL COMMENT '顶部名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_eatvisit_set','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_set','isopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_set')." ADD   `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_set')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_set','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_set')." ADD   `pic` varchar(255) NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_set','tpl_winnotice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_set')." ADD   `tpl_winnotice` varchar(255) NOT NULL COMMENT '中奖通知模板消息'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_set','tpl_newnotice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_set')." ADD   `tpl_newnotice` varchar(255) NOT NULL COMMENT '新品通知模板消息'");}
if(!pdo_fieldexists('mzhk_sun_eatvisit_set','navname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_eatvisit_set')." ADD   `navname` varchar(50) NOT NULL COMMENT '顶部名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_evaluate` (
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

");

if(!pdo_fieldexists('mzhk_sun_evaluate','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_evaluate')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_evaluate','username')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_evaluate')." ADD   `username` varchar(10) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_evaluate','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_evaluate')." ADD   `time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_evaluate','image')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_evaluate')." ADD   `image` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_evaluate','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_evaluate')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_evaluate','xingxing')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_evaluate')." ADD   `xingxing` varchar(7) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_evaluate','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_evaluate')." ADD   `content` text");}
if(!pdo_fieldexists('mzhk_sun_evaluate','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_evaluate')." ADD   `gid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_gift` (
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

");

if(!pdo_fieldexists('mzhk_sun_gift','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'");}
if(!pdo_fieldexists('mzhk_sun_gift','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('mzhk_sun_gift','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD   `title` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_gift','createtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD   `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('mzhk_sun_gift','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD   `content` text NOT NULL COMMENT '文章内容'");}
if(!pdo_fieldexists('mzhk_sun_gift','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD   `sort` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_gift','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD   `pic` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_gift','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD   `gid` int(11) DEFAULT '0' COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_gift','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD   `gname` varchar(200) DEFAULT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_gift','probability')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_gift')." ADD   `probability` float NOT NULL DEFAULT '0' COMMENT '概率'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_goods` (
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
  `is_spec` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用多规格',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COMMENT='商品 ';

");

if(!pdo_fieldexists('mzhk_sun_goods','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD 
  `gid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_goods','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `gname` text NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_goods','kjprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `kjprice` decimal(10,2) DEFAULT NULL COMMENT '砍价的价格'");}
if(!pdo_fieldexists('mzhk_sun_goods','shopprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `shopprice` decimal(10,2) DEFAULT NULL COMMENT '原价'");}
if(!pdo_fieldexists('mzhk_sun_goods','selftime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `selftime` varchar(200) DEFAULT NULL COMMENT '加入时间'");}
if(!pdo_fieldexists('mzhk_sun_goods','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '封面图'");}
if(!pdo_fieldexists('mzhk_sun_goods','probably')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `probably` text COMMENT '备注'");}
if(!pdo_fieldexists('mzhk_sun_goods','tid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `tid` int(11) DEFAULT NULL COMMENT '商品是否推荐，1推荐，2不推荐'");}
if(!pdo_fieldexists('mzhk_sun_goods','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `status` int(11) DEFAULT NULL COMMENT '商品状态，1为审核，2审核通过，3删除'");}
if(!pdo_fieldexists('mzhk_sun_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_goods','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `content` text COMMENT '商品详情'");}
if(!pdo_fieldexists('mzhk_sun_goods','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `lid` int(11) DEFAULT NULL COMMENT '商品类别id 1.为普通，2位砍价，3位拼团，4为集卡，5是抢购'");}
if(!pdo_fieldexists('mzhk_sun_goods','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `bid` int(11) DEFAULT NULL COMMENT '店铺id'");}
if(!pdo_fieldexists('mzhk_sun_goods','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_goods','ptprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `ptprice` decimal(10,2) DEFAULT NULL COMMENT '拼团价格'");}
if(!pdo_fieldexists('mzhk_sun_goods','astime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `astime` varchar(30) DEFAULT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('mzhk_sun_goods','antime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `antime` varchar(30) DEFAULT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('mzhk_sun_goods','ptnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `ptnum` int(11) DEFAULT NULL COMMENT '拼团活动人数量'");}
if(!pdo_fieldexists('mzhk_sun_goods','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `lb_imgs` varchar(400) DEFAULT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('mzhk_sun_goods','qgprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `qgprice` decimal(10,2) DEFAULT NULL COMMENT '抢购'");}
if(!pdo_fieldexists('mzhk_sun_goods','charnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `charnum` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_goods','charaddnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `charaddnum` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_goods','biaoti')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `biaoti` varchar(300) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_goods','kjbfb')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `kjbfb` float NOT NULL DEFAULT '20' COMMENT '砍价百分比'");}
if(!pdo_fieldexists('mzhk_sun_goods','is_ptopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `is_ptopen` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_goods','is_kjopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `is_kjopen` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_goods','is_jkopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `is_jkopen` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_goods','is_qgopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `is_qgopen` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_goods','is_hyopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `is_hyopen` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_goods','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `bname` varchar(50) NOT NULL COMMENT '店铺名称'");}
if(!pdo_fieldexists('mzhk_sun_goods','initialtimes')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `initialtimes` int(11) NOT NULL COMMENT '初始抽奖次数'");}
if(!pdo_fieldexists('mzhk_sun_goods','is_vip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `is_vip` tinyint(1) NOT NULL COMMENT '是否会员，0非会员，1会员'");}
if(!pdo_fieldexists('mzhk_sun_goods','buynum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `buynum` int(11) NOT NULL COMMENT '已购买数量'");}
if(!pdo_fieldexists('mzhk_sun_goods','viewnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `viewnum` int(11) NOT NULL COMMENT '查看人数'");}
if(!pdo_fieldexists('mzhk_sun_goods','sharenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sharenum` int(11) NOT NULL COMMENT '分享次数'");}
if(!pdo_fieldexists('mzhk_sun_goods','cutnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `cutnum` int(11) NOT NULL COMMENT '可参与砍价人数'");}
if(!pdo_fieldexists('mzhk_sun_goods','ship_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `ship_type` varchar(10) NOT NULL DEFAULT '1' COMMENT '配送方式，1到店消费，2送货上门，3快递'");}
if(!pdo_fieldexists('mzhk_sun_goods','ship_delivery_fee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `ship_delivery_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '送货上门-配送费'");}
if(!pdo_fieldexists('mzhk_sun_goods','ship_delivery_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `ship_delivery_time` varchar(30) NOT NULL COMMENT '送货上门-配送时间'");}
if(!pdo_fieldexists('mzhk_sun_goods','ship_delivery_way')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `ship_delivery_way` float NOT NULL DEFAULT '1' COMMENT '送货上门-配送距离'");}
if(!pdo_fieldexists('mzhk_sun_goods','ship_express_fee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `ship_express_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递-快递费'");}
if(!pdo_fieldexists('mzhk_sun_goods','limitnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `limitnum` int(11) NOT NULL DEFAULT '0' COMMENT '限购数量'");}
if(!pdo_fieldexists('mzhk_sun_goods','isshelf')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `isshelf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否上架，0下架，1上架'");}
if(!pdo_fieldexists('mzhk_sun_goods','limittime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `limittime` float NOT NULL DEFAULT '0' COMMENT '参团时限'");}
if(!pdo_fieldexists('mzhk_sun_goods','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sort` int(5) NOT NULL DEFAULT '255' COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_goods','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `expirationtime` int(11) NOT NULL DEFAULT '0' COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_goods','stocktype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `stocktype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0下单减库存，1付款减库存'");}
if(!pdo_fieldexists('mzhk_sun_goods','lotterytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `lotterytime` int(11) NOT NULL COMMENT '开奖时间'");}
if(!pdo_fieldexists('mzhk_sun_goods','winway')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `winway` tinyint(2) NOT NULL DEFAULT '0' COMMENT '开奖方式，0自动，1手动'");}
if(!pdo_fieldexists('mzhk_sun_goods','islottery')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `islottery` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否已经开奖，0否，1是'");}
if(!pdo_fieldexists('mzhk_sun_goods','lotterytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `lotterytype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '开奖条件，0按时间，1按人数'");}
if(!pdo_fieldexists('mzhk_sun_goods','lotterynum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `lotterynum` int(11) NOT NULL COMMENT '开奖人数'");}
if(!pdo_fieldexists('mzhk_sun_goods','index_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `index_img` varchar(255) DEFAULT NULL COMMENT '首页展示图'");}
if(!pdo_fieldexists('mzhk_sun_goods','code_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `code_img` mediumblob NOT NULL COMMENT '小程序码'");}
if(!pdo_fieldexists('mzhk_sun_goods','vipprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `vipprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员价格'");}
if(!pdo_fieldexists('mzhk_sun_goods','mustlowprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `mustlowprice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '砍价，0不用砍到底价，1必须砍到低价才能购买'");}
if(!pdo_fieldexists('mzhk_sun_goods','canrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `canrefund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0可以退款，1不能退款'");}
if(!pdo_fieldexists('mzhk_sun_goods','distribution_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启'");}
if(!pdo_fieldexists('mzhk_sun_goods','distribution_commissiontype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1百分比，2固定金额'");}
if(!pdo_fieldexists('mzhk_sun_goods','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('mzhk_sun_goods','secondmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('mzhk_sun_goods','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
if(!pdo_fieldexists('mzhk_sun_goods','cateid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `cateid` int(10) DEFAULT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('mzhk_sun_goods','index3_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `index3_img` varchar(255) DEFAULT NULL COMMENT '风格3首页展示图'");}
if(!pdo_fieldexists('mzhk_sun_goods','money_rate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `money_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认支付金额比例'");}
if(!pdo_fieldexists('mzhk_sun_goods','score_rate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `score_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认兑换积分比例'");}
if(!pdo_fieldexists('mzhk_sun_goods','kjsection_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `kjsection_open` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启砍价区间 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_goods','sctionpnum1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sctionpnum1` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间1人数范围'");}
if(!pdo_fieldexists('mzhk_sun_goods','sctionpnum11')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sctionpnum11` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间1人数范围'");}
if(!pdo_fieldexists('mzhk_sun_goods','sctionpnum2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sctionpnum2` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间2人数范围'");}
if(!pdo_fieldexists('mzhk_sun_goods','sctionpnum22')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sctionpnum22` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间2人数范围'");}
if(!pdo_fieldexists('mzhk_sun_goods','sctionpnum3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sctionpnum3` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间3人数范围'");}
if(!pdo_fieldexists('mzhk_sun_goods','sctionpnum33')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sctionpnum33` int(11) NOT NULL DEFAULT '0' COMMENT '砍价区间3人数范围'");}
if(!pdo_fieldexists('mzhk_sun_goods','sctionmoney1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sctionmoney1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价区间1砍价价格'");}
if(!pdo_fieldexists('mzhk_sun_goods','sctionmoney2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sctionmoney2` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价区间2砍价价格'");}
if(!pdo_fieldexists('mzhk_sun_goods','sctionmoney3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `sctionmoney3` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价区间3砍价价格'");}
if(!pdo_fieldexists('mzhk_sun_goods','open_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `open_num` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启每日砍价次数 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_goods','day_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `day_num` int(11) NOT NULL DEFAULT '0' COMMENT '每日砍价次数'");}
if(!pdo_fieldexists('mzhk_sun_goods','open_friend')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `open_friend` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启每日帮同一好友砍价次数 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_goods','friend_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `friend_num` int(11) NOT NULL DEFAULT '0' COMMENT '帮同一好友砍价次数'");}
if(!pdo_fieldexists('mzhk_sun_goods','isjoin')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `isjoin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否参与返利 0 不参与 1 参与'");}
if(!pdo_fieldexists('mzhk_sun_goods','rebate_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `rebate_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启商家返利 0否 1是'");}
if(!pdo_fieldexists('mzhk_sun_goods','rebatetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `rebatetype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '返利类型 1百分比 2固定金额'");}
if(!pdo_fieldexists('mzhk_sun_goods','rebatemoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `rebatemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返利金额'");}
if(!pdo_fieldexists('mzhk_sun_goods','ordernum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `ordernum` int(11) NOT NULL DEFAULT '0' COMMENT '多少单后开始返利'");}
if(!pdo_fieldexists('mzhk_sun_goods','ptshopprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `ptshopprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '普通商品原价'");}
if(!pdo_fieldexists('mzhk_sun_goods','fseenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `fseenum` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟查看人数'");}
if(!pdo_fieldexists('mzhk_sun_goods','fsharenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `fsharenum` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟分享人数'");}
if(!pdo_fieldexists('mzhk_sun_goods','fjoinnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `fjoinnum` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟参与人数'");}
if(!pdo_fieldexists('mzhk_sun_goods','recdetail')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `recdetail` int(11) NOT NULL DEFAULT '0' COMMENT '商品是否推荐到详情页，0不推荐，1推荐'");}
if(!pdo_fieldexists('mzhk_sun_goods','img_details')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `img_details` varchar(400) NOT NULL COMMENT '商家发布商品详情图'");}
if(!pdo_fieldexists('mzhk_sun_goods','brelease')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `brelease` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否商家发布商品 0 不是 1 是'");}
if(!pdo_fieldexists('mzhk_sun_goods','iscj')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `iscj` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否绑定抽奖 0 不是 1 是'");}
if(!pdo_fieldexists('mzhk_sun_goods','cjid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `cjid` int(11) NOT NULL COMMENT '抽奖ID'");}
if(!pdo_fieldexists('mzhk_sun_goods','is_delivery')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `is_delivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送 0 关闭 1启用'");}
if(!pdo_fieldexists('mzhk_sun_goods','is_delivery_limit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `is_delivery_limit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送限购 0 关闭 1启用'");}
if(!pdo_fieldexists('mzhk_sun_goods','delivery_limit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `delivery_limit` int(11) NOT NULL DEFAULT '0' COMMENT '配送限购数量'");}
if(!pdo_fieldexists('mzhk_sun_goods','zid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `zid` int(11) DEFAULT '0' COMMENT '挚能云商品id'");}
if(!pdo_fieldexists('mzhk_sun_goods','recvipbuy')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `recvipbuy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐到会员购买页 0不推荐 1推荐'");}
if(!pdo_fieldexists('mzhk_sun_goods','media_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `media_id` varchar(100) NOT NULL COMMENT '小程序卡片媒体id'");}
if(!pdo_fieldexists('mzhk_sun_goods','media_id_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `media_id_time` varchar(30) DEFAULT NULL COMMENT '小程序上传临时媒体图时间'");}
if(!pdo_fieldexists('mzhk_sun_goods','wechat_media_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `wechat_media_img` varchar(255) DEFAULT NULL COMMENT '小程序卡片需要的图'");}
if(!pdo_fieldexists('mzhk_sun_goods','reccloud')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `reccloud` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐到云店 0不推荐 1推荐'");}
if(!pdo_fieldexists('mzhk_sun_goods','totalcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金占比'");}
if(!pdo_fieldexists('mzhk_sun_goods','is_spec')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goods')." ADD   `is_spec` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用多规格'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_goodsattr` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL COMMENT '标识id',
  `name` varchar(50) DEFAULT NULL COMMENT '规格名',
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品自定义规格';

");

if(!pdo_fieldexists('mzhk_sun_goodsattr','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_goodsattr','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr')." ADD   `uniacid` int(11) unsigned NOT NULL COMMENT '标识id'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '规格名'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr')." ADD   `status` tinyint(1) DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_goodsattr_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL COMMENT '标识id',
  `attrid` int(11) DEFAULT NULL COMMENT '属性编号',
  `value` varchar(100) DEFAULT NULL COMMENT '属性值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品自定义规格值';

");

if(!pdo_fieldexists('mzhk_sun_goodsattr_value','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_value')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_value','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_value')." ADD   `uniacid` int(11) unsigned NOT NULL COMMENT '标识id'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_value','attrid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_value')." ADD   `attrid` int(11) DEFAULT NULL COMMENT '属性编号'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_value','value')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_value')." ADD   `value` varchar(100) DEFAULT NULL COMMENT '属性值'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_goodsattr_valuedetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL COMMENT '标识id',
  `gid` int(11) DEFAULT NULL COMMENT '所属商品id',
  `num` int(11) DEFAULT NULL COMMENT '库存',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格',
  `time` varchar(20) DEFAULT NULL COMMENT '时间',
  `name` varchar(255) DEFAULT NULL COMMENT '规格对应的中文名字',
  `attr_value_ids` varchar(255) DEFAULT NULL COMMENT '属性值id字符串',
  `properties_name_json` varchar(255) DEFAULT NULL COMMENT 'json',
  `vipprice` decimal(10,2) DEFAULT '0.00' COMMENT '会员价',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品各规格库存';

");

if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD   `uniacid` int(11) unsigned NOT NULL COMMENT '标识id'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD   `gid` int(11) DEFAULT NULL COMMENT '所属商品id'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD   `num` int(11) DEFAULT NULL COMMENT '库存'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD   `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD   `time` varchar(20) DEFAULT NULL COMMENT '时间'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '规格对应的中文名字'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','attr_value_ids')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD   `attr_value_ids` varchar(255) DEFAULT NULL COMMENT '属性值id字符串'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','properties_name_json')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD   `properties_name_json` varchar(255) DEFAULT NULL COMMENT 'json'");}
if(!pdo_fieldexists('mzhk_sun_goodsattr_valuedetail','vipprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodsattr_valuedetail')." ADD   `vipprice` decimal(10,2) DEFAULT '0.00' COMMENT '会员价'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_goodscate` (
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

");

if(!pdo_fieldexists('mzhk_sun_goodscate','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodscate')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_goodscate','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodscate')." ADD   `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_goodscate','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodscate')." ADD   `name` varchar(50) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('mzhk_sun_goodscate','cateexplain')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodscate')." ADD   `cateexplain` varchar(100) NOT NULL COMMENT '分类说明'");}
if(!pdo_fieldexists('mzhk_sun_goodscate','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodscate')." ADD   `status` int(10) NOT NULL DEFAULT '0' COMMENT '状态 0 不显示  1 显示'");}
if(!pdo_fieldexists('mzhk_sun_goodscate','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodscate')." ADD   `time` varchar(100) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_goodscate','cateimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodscate')." ADD   `cateimg` varchar(100) NOT NULL COMMENT '分类图片'");}
if(!pdo_fieldexists('mzhk_sun_goodscate','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_goodscate')." ADD   `uniacid` int(10) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_hyorder` (
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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_hyorder','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD 
  `oid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_hyorder','orderNum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `orderNum` varchar(50) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','detailInfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','telNumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `telNumber` varchar(100) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '总价'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `status` varchar(255) DEFAULT '0' COMMENT '1 取消订单，2待支付，3已支付，4待收货，5已完成'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `openid` varchar(150) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_hyorder','countyName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `countyName` varchar(150) DEFAULT NULL COMMENT '区域'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','provinceName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `provinceName` varchar(150) DEFAULT NULL COMMENT '省份'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `name` varchar(100) DEFAULT NULL COMMENT '名字'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `addtime` varchar(100) DEFAULT NULL COMMENT '加入的时间'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','cityName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `cityName` varchar(100) DEFAULT NULL COMMENT '城市'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','uremark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `uremark` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_hyorder','sincetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `sincetype` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_hyorder','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_hyorder','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `paytime` int(11) NOT NULL COMMENT '付款时间'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `gid` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `gname` varchar(100) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `num` int(11) NOT NULL COMMENT '件数'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `out_trade_no` varchar(100) NOT NULL COMMENT '外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','ordertype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `ordertype` tinyint(1) NOT NULL COMMENT '类型，待用'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','deliveryfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','goodsimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `goodsimg` varchar(200) NOT NULL COMMENT '商品图'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `bname` varchar(100) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','isrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','shipnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `shipnum` varchar(50) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','shipname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `shipname` varchar(50) NOT NULL COMMENT '快递名称'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','shiptime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `shiptime` int(11) NOT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `finishtime` int(11) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `expirationtime` int(11) NOT NULL DEFAULT '0' COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','islottery')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `islottery` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0未开奖，1中奖，2未中奖'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','lottery_code')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `lottery_code` varchar(100) NOT NULL COMMENT '抽奖码'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','click_openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   `click_openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '分享点击者openid'");}
if(!pdo_fieldexists('mzhk_sun_hyorder','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_hyorder')." ADD   PRIMARY KEY (`oid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_kanjia` (
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

");

if(!pdo_fieldexists('mzhk_sun_kanjia','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_kanjia','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `openid` varchar(200) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_kanjia','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `gid` int(11) DEFAULT NULL COMMENT '砍价商品id'");}
if(!pdo_fieldexists('mzhk_sun_kanjia','mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `mch_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_kanjia','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_kanjia','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `price` decimal(10,0) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_kanjia','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_kanjia','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_kanjia','kanjia')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `kanjia` decimal(11,0) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_kanjia','price1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `price1` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_kanjia','kanjia1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kanjia')." ADD   `kanjia1` decimal(10,2) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_kjorder` (
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
  `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金',
  `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金',
  `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金',
  `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '云店佣金',
  `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价格',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_kjorder','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD 
  `oid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_kjorder','orderNum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `orderNum` varchar(50) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','detailInfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','telNumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `telNumber` varchar(100) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '总价'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `status` tinyint(2) DEFAULT '2' COMMENT '1 取消订单，2待支付，3待发货，4已支付，5已完成'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `openid` varchar(150) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_kjorder','countyName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `countyName` varchar(150) DEFAULT NULL COMMENT '区域'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','provinceName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `provinceName` varchar(150) DEFAULT NULL COMMENT '省份'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `name` varchar(100) DEFAULT NULL COMMENT '名字'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `addtime` int(11) DEFAULT '0' COMMENT '加入的时间'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','cityName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `cityName` varchar(100) DEFAULT NULL COMMENT '城市'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','uremark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `uremark` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_kjorder','sincetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `sincetype` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_kjorder','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_kjorder','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `paytime` int(11) NOT NULL COMMENT '付款时间'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `gname` varchar(200) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '购买数量'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `out_trade_no` varchar(200) DEFAULT NULL COMMENT '外部订单id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','ordertype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `ordertype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型，0普通，1抢购，2拼团，3砍价'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','deliveryfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','goodsimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `goodsimg` varchar(200) NOT NULL COMMENT '商品图'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `bname` varchar(100) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','isrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','shipnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `shipnum` varchar(50) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','shipname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `shipname` varchar(50) NOT NULL COMMENT '快递名称'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','shiptime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `shiptime` int(11) NOT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `finishtime` int(11) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `expirationtime` int(11) NOT NULL COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','rmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','source')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','fbid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','ispackage')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0非套餐，1套餐'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','packageid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `packageid` int(11) NOT NULL COMMENT '套餐ID'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','packageoid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `packageoid` int(11) NOT NULL COMMENT '套餐订单ID'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','commission_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','totalcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','fxmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','csmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '云店佣金'");}
if(!pdo_fieldexists('mzhk_sun_kjorder','goodsprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_kjorder')." ADD   `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价格'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_member_brand` (
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

");

if(!pdo_fieldexists('mzhk_sun_member_brand','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_brand')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_member_brand','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_brand')." ADD   `bid` int(11) NOT NULL COMMENT '商家ID'");}
if(!pdo_fieldexists('mzhk_sun_member_brand','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_brand')." ADD   `bname` varchar(50) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_member_brand','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_brand')." ADD   `img` varchar(100) NOT NULL COMMENT '商家主图'");}
if(!pdo_fieldexists('mzhk_sun_member_brand','tid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_brand')." ADD   `tid` int(11) NOT NULL COMMENT '分类ID'");}
if(!pdo_fieldexists('mzhk_sun_member_brand','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_brand')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1审核，2通过，3删除'");}
if(!pdo_fieldexists('mzhk_sun_member_brand','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_brand')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_member_brand','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_brand')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_member_goods` (
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

");

if(!pdo_fieldexists('mzhk_sun_member_goods','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_member_goods','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `name` varchar(255) NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `price` decimal(11,2) NOT NULL COMMENT '价值'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `img` varchar(200) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1审核，2通过，3删除'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','allcancel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `allcancel` int(11) NOT NULL COMMENT '总核销限制次数'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','yearcancel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `yearcancel` int(11) NOT NULL COMMENT '每人每年核销限制次数'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','daycancel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `daycancel` int(11) NOT NULL COMMENT '每人每天核销限制次数'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `content` text NOT NULL COMMENT '商品详情'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `bid` int(11) NOT NULL COMMENT '店铺id'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `bname` varchar(50) NOT NULL COMMENT '店铺名'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','starttime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `starttime` varchar(20) NOT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `endtime` varchar(20) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_member_goods','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_goods')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_member_num` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `phone` varchar(20) NOT NULL COMMENT '会员电话',
  `time` varchar(20) NOT NULL COMMENT '发送时间',
  `num` int(11) NOT NULL COMMENT '验证码',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_member_num','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_num')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_member_num','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_num')." ADD   `uid` int(11) NOT NULL COMMENT '会员ID'");}
if(!pdo_fieldexists('mzhk_sun_member_num','phone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_num')." ADD   `phone` varchar(20) NOT NULL COMMENT '会员电话'");}
if(!pdo_fieldexists('mzhk_sun_member_num','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_num')." ADD   `time` varchar(20) NOT NULL COMMENT '发送时间'");}
if(!pdo_fieldexists('mzhk_sun_member_num','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_num')." ADD   `num` int(11) NOT NULL COMMENT '验证码'");}
if(!pdo_fieldexists('mzhk_sun_member_num','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_num')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_member_order` (
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

");

if(!pdo_fieldexists('mzhk_sun_member_order','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id'");}
if(!pdo_fieldexists('mzhk_sun_member_order','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD   `gid` int(11) NOT NULL COMMENT '权益id'");}
if(!pdo_fieldexists('mzhk_sun_member_order','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_member_order','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD   `gname` varchar(255) NOT NULL COMMENT '权益名称'");}
if(!pdo_fieldexists('mzhk_sun_member_order','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD   `bname` varchar(255) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_member_order','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD   `uname` varchar(255) NOT NULL COMMENT '用户名称'");}
if(!pdo_fieldexists('mzhk_sun_member_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_member_order','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD   `time` varchar(20) NOT NULL COMMENT '核销时间'");}
if(!pdo_fieldexists('mzhk_sun_member_order','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD   `uid` int(11) NOT NULL COMMENT 'uid'");}
if(!pdo_fieldexists('mzhk_sun_member_order','ische')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_order')." ADD   `ische` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为未撤销，0为已撤销'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_member_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `phone` varchar(20) NOT NULL COMMENT '会员电话',
  `name` varchar(20) NOT NULL COMMENT '会员名字',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_member_record','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_member_record','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_record')." ADD   `uid` int(11) NOT NULL COMMENT '会员ID'");}
if(!pdo_fieldexists('mzhk_sun_member_record','phone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_record')." ADD   `phone` varchar(20) NOT NULL COMMENT '会员电话'");}
if(!pdo_fieldexists('mzhk_sun_member_record','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_record')." ADD   `name` varchar(20) NOT NULL COMMENT '会员名字'");}
if(!pdo_fieldexists('mzhk_sun_member_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_record')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_member_set` (
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

");

if(!pdo_fieldexists('mzhk_sun_member_set','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_member_set','isopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_set')." ADD   `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启'");}
if(!pdo_fieldexists('mzhk_sun_member_set','ismsg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_set')." ADD   `ismsg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启'");}
if(!pdo_fieldexists('mzhk_sun_member_set','isname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_set')." ADD   `isname` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启'");}
if(!pdo_fieldexists('mzhk_sun_member_set','isrecord')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_set')." ADD   `isrecord` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启'");}
if(!pdo_fieldexists('mzhk_sun_member_set','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_set')." ADD   `time` int(11) NOT NULL DEFAULT '20' COMMENT 'time'");}
if(!pdo_fieldexists('mzhk_sun_member_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_set')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_member_set','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_set')." ADD   `pic` varchar(255) NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('mzhk_sun_member_set','navname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_set')." ADD   `navname` varchar(50) NOT NULL DEFAULT '会员权益' COMMENT '顶部名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_member_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '商品名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1审核，2通过，3删除',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `sort` int(5) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_member_type','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_member_type','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_type')." ADD   `name` varchar(255) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_member_type','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_type')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1审核，2通过，3删除'");}
if(!pdo_fieldexists('mzhk_sun_member_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_type')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_member_type','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_member_type')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_mercapdetails` (
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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_mercapdetails','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `bname` varchar(100) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','mcd_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `mcd_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型，1订单收入，2提现，3线下收款（线下收入直接打进商家账号，这里只是一个记录）'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','mcd_memo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `mcd_memo` text NOT NULL COMMENT '订单收入等具体信息'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `addtime` int(11) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','paycommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现的时候，支付的佣金'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `uniacid` int(11) NOT NULL COMMENT '11'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态，1成功，2不成功'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','order_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','wd_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `wd_id` int(11) NOT NULL DEFAULT '0' COMMENT '提现id'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `out_trade_no` varchar(255) NOT NULL COMMENT '外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `openid` varchar(255) NOT NULL COMMENT '线下付款人openid'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_mercapdetails','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_mercapdetails')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_order` (
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
  `specdetail` varchar(50) NOT NULL DEFAULT '0' COMMENT '所选规格详细',
  `spec` int(11) NOT NULL DEFAULT '0' COMMENT '所选规格',
  `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价格',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_order','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD 
  `oid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_order','orderNum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `orderNum` varchar(50) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('mzhk_sun_order','detailInfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_order','telNumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `telNumber` varchar(100) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('mzhk_sun_order','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '总价'");}
if(!pdo_fieldexists('mzhk_sun_order','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `status` varchar(255) DEFAULT '2' COMMENT '1 取消订单，2待支付，3待发货，4已支付，5已完成'");}
if(!pdo_fieldexists('mzhk_sun_order','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `openid` varchar(150) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_order','countyName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `countyName` varchar(150) DEFAULT NULL COMMENT '区域'");}
if(!pdo_fieldexists('mzhk_sun_order','provinceName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `provinceName` varchar(150) DEFAULT NULL COMMENT '省份'");}
if(!pdo_fieldexists('mzhk_sun_order','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `name` varchar(100) DEFAULT NULL COMMENT '名字'");}
if(!pdo_fieldexists('mzhk_sun_order','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `addtime` varchar(100) DEFAULT NULL COMMENT '加入的时间'");}
if(!pdo_fieldexists('mzhk_sun_order','cityName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `cityName` varchar(100) DEFAULT NULL COMMENT '城市'");}
if(!pdo_fieldexists('mzhk_sun_order','uremark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `uremark` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_order','sincetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `sincetype` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_order','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_order','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `paytime` int(11) NOT NULL COMMENT '付款时间'");}
if(!pdo_fieldexists('mzhk_sun_order','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `gid` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_order','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `gname` varchar(100) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_order','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `num` int(11) NOT NULL COMMENT '件数'");}
if(!pdo_fieldexists('mzhk_sun_order','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `out_trade_no` varchar(100) NOT NULL COMMENT '外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_order','ordertype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `ordertype` tinyint(1) NOT NULL COMMENT '类型，待用'");}
if(!pdo_fieldexists('mzhk_sun_order','deliveryfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('mzhk_sun_order','goodsimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `goodsimg` varchar(200) NOT NULL COMMENT '商品图'");}
if(!pdo_fieldexists('mzhk_sun_order','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_order','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `bname` varchar(100) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_order','isrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款'");}
if(!pdo_fieldexists('mzhk_sun_order','shipnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `shipnum` varchar(50) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('mzhk_sun_order','shipname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `shipname` varchar(50) NOT NULL COMMENT '快递名称'");}
if(!pdo_fieldexists('mzhk_sun_order','shiptime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `shiptime` int(11) NOT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('mzhk_sun_order','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `finishtime` int(11) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_order','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号'");}
if(!pdo_fieldexists('mzhk_sun_order','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `expirationtime` int(11) NOT NULL COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_order','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付'");}
if(!pdo_fieldexists('mzhk_sun_order','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_order','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_order','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
if(!pdo_fieldexists('mzhk_sun_order','haswrittenoffnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `haswrittenoffnum` int(11) NOT NULL COMMENT '已核销数'");}
if(!pdo_fieldexists('mzhk_sun_order','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用'");}
if(!pdo_fieldexists('mzhk_sun_order','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id'");}
if(!pdo_fieldexists('mzhk_sun_order','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id'");}
if(!pdo_fieldexists('mzhk_sun_order','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额'");}
if(!pdo_fieldexists('mzhk_sun_order','rmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额'");}
if(!pdo_fieldexists('mzhk_sun_order','source')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台'");}
if(!pdo_fieldexists('mzhk_sun_order','fbid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id'");}
if(!pdo_fieldexists('mzhk_sun_order','ispackage')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0非套餐，1套餐'");}
if(!pdo_fieldexists('mzhk_sun_order','packageoid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `packageoid` int(11) NOT NULL COMMENT '套餐订单ID'");}
if(!pdo_fieldexists('mzhk_sun_order','packageid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `packageid` int(11) NOT NULL COMMENT '套餐ID'");}
if(!pdo_fieldexists('mzhk_sun_order','returnsign')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `returnsign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买会员赠送标识 0 非赠送 1 赠送'");}
if(!pdo_fieldexists('mzhk_sun_order','viplogid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `viplogid` int(11) NOT NULL DEFAULT '0' COMMENT '会员订单id'");}
if(!pdo_fieldexists('mzhk_sun_order','vipid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `vipid` int(11) NOT NULL DEFAULT '0' COMMENT '会员id'");}
if(!pdo_fieldexists('mzhk_sun_order','commission_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金'");}
if(!pdo_fieldexists('mzhk_sun_order','totalcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金'");}
if(!pdo_fieldexists('mzhk_sun_order','fxmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金'");}
if(!pdo_fieldexists('mzhk_sun_order','csmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '云店佣金'");}
if(!pdo_fieldexists('mzhk_sun_order','specdetail')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `specdetail` varchar(50) NOT NULL DEFAULT '0' COMMENT '所选规格详细'");}
if(!pdo_fieldexists('mzhk_sun_order','spec')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `spec` int(11) NOT NULL DEFAULT '0' COMMENT '所选规格'");}
if(!pdo_fieldexists('mzhk_sun_order','goodsprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_order')." ADD   `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价格'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_package_goods` (
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

");

if(!pdo_fieldexists('mzhk_sun_package_goods','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_package_goods','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `name` varchar(255) NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','showprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `showprice` decimal(11,2) NOT NULL COMMENT '价值'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `price` decimal(11,2) NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `pic` text NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `img` varchar(200) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','poster')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `poster` varchar(200) NOT NULL COMMENT '海报图'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1显示，2隐藏'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','limit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `limit` int(11) NOT NULL COMMENT '限购'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','limitnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `limitnum` int(11) NOT NULL COMMENT '库存'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','starttime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `starttime` varchar(20) NOT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `endtime` varchar(20) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `type` int(11) NOT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','is_vip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `is_vip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否会员，1是，0不是'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','stocktype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `stocktype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0下单减库存，1付款减库存'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','vipprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `vipprice` decimal(11,2) NOT NULL COMMENT '会员价格'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','ship_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `ship_type` varchar(10) NOT NULL DEFAULT '1' COMMENT '配送方式，1到店消费，2送货上门，3快递'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','ship_delivery_fee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `ship_delivery_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '送货上门-配送费'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','ship_delivery_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `ship_delivery_time` varchar(30) NOT NULL COMMENT '送货上门-配送时间'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','ship_delivery_way')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `ship_delivery_way` float NOT NULL DEFAULT '1' COMMENT '送货上门-配送距离'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','ship_express_fee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `ship_express_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递-快递费'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `content` text NOT NULL COMMENT '套餐详情'");}
if(!pdo_fieldexists('mzhk_sun_package_goods','detail')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goods')." ADD   `detail` text NOT NULL COMMENT '购买须知'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_package_goodstwo` (
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

");

if(!pdo_fieldexists('mzhk_sun_package_goodstwo','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_package_goodstwo','pid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD   `pid` int(11) NOT NULL COMMENT '套餐包ID'");}
if(!pdo_fieldexists('mzhk_sun_package_goodstwo','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD   `gid` int(11) NOT NULL COMMENT '商品ID'");}
if(!pdo_fieldexists('mzhk_sun_package_goodstwo','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD   `lid` int(11) NOT NULL COMMENT '1普通，2砍价，3拼团，5抢购'");}
if(!pdo_fieldexists('mzhk_sun_package_goodstwo','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD   `gname` varchar(20) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_package_goodstwo','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD   `price` decimal(11,2) NOT NULL COMMENT '核销价格'");}
if(!pdo_fieldexists('mzhk_sun_package_goodstwo','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD   `img` varchar(200) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('mzhk_sun_package_goodstwo','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1显示，2隐藏'");}
if(!pdo_fieldexists('mzhk_sun_package_goodstwo','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_package_goodstwo','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_goodstwo')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_package_order` (
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

");

if(!pdo_fieldexists('mzhk_sun_package_order','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id'");}
if(!pdo_fieldexists('mzhk_sun_package_order','ordernum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `ordernum` varchar(100) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('mzhk_sun_package_order','pid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `pid` int(11) NOT NULL COMMENT '套餐包id'");}
if(!pdo_fieldexists('mzhk_sun_package_order','pname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `pname` varchar(255) NOT NULL COMMENT '套餐包名称'");}
if(!pdo_fieldexists('mzhk_sun_package_order','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `price` decimal(11,2) NOT NULL COMMENT '支付价钱'");}
if(!pdo_fieldexists('mzhk_sun_package_order','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `uname` varchar(255) NOT NULL COMMENT '用户名称'");}
if(!pdo_fieldexists('mzhk_sun_package_order','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `paytype` varchar(20) NOT NULL COMMENT '支付方式 1 微信支付 2 余额支付'");}
if(!pdo_fieldexists('mzhk_sun_package_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_package_order','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `addtime` varchar(20) NOT NULL COMMENT '下单时间'");}
if(!pdo_fieldexists('mzhk_sun_package_order','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `paytime` varchar(20) NOT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('mzhk_sun_package_order','canceltime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `canceltime` varchar(20) NOT NULL COMMENT '核销时间'");}
if(!pdo_fieldexists('mzhk_sun_package_order','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `uid` int(11) NOT NULL COMMENT 'uid'");}
if(!pdo_fieldexists('mzhk_sun_package_order','telNumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `telNumber` varchar(20) NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('mzhk_sun_package_order','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，0已取消，1未支付，2已支付，3待收货，4已完成'");}
if(!pdo_fieldexists('mzhk_sun_package_order','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `out_trade_no` varchar(100) NOT NULL COMMENT '支付外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_package_order','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `out_refund_no` varchar(100) NOT NULL COMMENT '退款外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_package_order','isrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `isrefund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款，3拒绝退款'");}
if(!pdo_fieldexists('mzhk_sun_package_order','cityname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `cityname` varchar(20) NOT NULL COMMENT '城市'");}
if(!pdo_fieldexists('mzhk_sun_package_order','countyname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `countyname` varchar(20) NOT NULL COMMENT '区域'");}
if(!pdo_fieldexists('mzhk_sun_package_order','provincename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `provincename` varchar(20) NOT NULL COMMENT '省份'");}
if(!pdo_fieldexists('mzhk_sun_package_order','detailinfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `detailinfo` varchar(100) NOT NULL COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_package_order','uremark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `uremark` varchar(100) NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('mzhk_sun_package_order','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `name` varchar(20) NOT NULL COMMENT '用户名'");}
if(!pdo_fieldexists('mzhk_sun_package_order','sincetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_order')." ADD   `sincetype` varchar(100) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_package_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `navname` varchar(50) NOT NULL DEFAULT '套餐包' COMMENT '顶部名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_package_set','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_package_set','isopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_set')." ADD   `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启，0不开启，1开启'");}
if(!pdo_fieldexists('mzhk_sun_package_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_set')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_package_set','navname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_set')." ADD   `navname` varchar(50) NOT NULL DEFAULT '套餐包' COMMENT '顶部名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_package_type` (
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

");

if(!pdo_fieldexists('mzhk_sun_package_type','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_package_type','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD   `name` varchar(50) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('mzhk_sun_package_type','twoname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD   `twoname` varchar(50) NOT NULL COMMENT '分类简介'");}
if(!pdo_fieldexists('mzhk_sun_package_type','color')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD   `color` varchar(50) NOT NULL COMMENT '背景颜色'");}
if(!pdo_fieldexists('mzhk_sun_package_type','font_color')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD   `font_color` varchar(50) NOT NULL COMMENT '字体颜色'");}
if(!pdo_fieldexists('mzhk_sun_package_type','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD   `img` varchar(255) NOT NULL COMMENT '缩略图'");}
if(!pdo_fieldexists('mzhk_sun_package_type','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD   `pic` text NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('mzhk_sun_package_type','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1显示，2隐藏'");}
if(!pdo_fieldexists('mzhk_sun_package_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_package_type','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_package_type')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_ad` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `title` text COMMENT '广告标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `logo` varchar(100) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','url')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `url` varchar(100) DEFAULT NULL COMMENT '外部链接'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `status` tinyint(1) DEFAULT NULL COMMENT '状态'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `time` varchar(50) DEFAULT NULL COMMENT '时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '模块名'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `type` int(11) DEFAULT NULL COMMENT '类型'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `state` int(11) DEFAULT NULL COMMENT '跳转路径选择'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','src')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `src` varchar(100) DEFAULT NULL COMMENT '内部链接'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','xcx_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `xcx_name` varchar(20) DEFAULT NULL COMMENT '关联小程序'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_ad','appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_ad')." ADD   `appid` varchar(100) DEFAULT NULL COMMENT '关联小程序appid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_addnews` (
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

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_addnews','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_addnews')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_addnews','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_addnews')." ADD   `title` varchar(255) NOT NULL COMMENT '标题，展示用'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_addnews','left')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_addnews')." ADD   `left` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_addnews','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_addnews')." ADD   `state` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1显示，2为关闭'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_addnews','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_addnews')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_addnews','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_addnews')." ADD   `type` int(11) NOT NULL COMMENT '类型'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_addnews','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_addnews')." ADD   `time` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_address` (
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

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','adid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD 
  `adid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `name` varchar(45) NOT NULL COMMENT '收货人'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','telNumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `telNumber` varchar(30) NOT NULL COMMENT '收件人号码'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','countyName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `countyName` varchar(100) NOT NULL COMMENT '区'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','detailAddr')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `detailAddr` varchar(100) NOT NULL COMMENT '详细地址'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','isDefault')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `isDefault` varchar(11) DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `uid` varchar(55) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','provinceName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `provinceName` varchar(100) NOT NULL COMMENT '省'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','cityName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `cityName` varchar(100) NOT NULL COMMENT '市'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','postalCode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `postalCode` int(11) DEFAULT NULL COMMENT '邮政编码'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','detailInfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `detailInfo` varchar(100) DEFAULT NULL COMMENT '详细情况'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_address','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_address')." ADD   `oid` int(11) DEFAULT NULL COMMENT '关联订单'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_audit','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_audit')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_audit','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_audit')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_audit','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_audit')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_balance` (
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

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_balance','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_balance')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_balance','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_balance')." ADD   `openid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_balance','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_balance')." ADD   `money` decimal(11,2) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_balance','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_balance')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_balance','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_balance')." ADD   `time` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_balance','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_balance')." ADD   `status` int(11) DEFAULT '0' COMMENT '状态，是否处理，0未处理'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_balance','wx')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_balance')." ADD   `wx` varchar(50) DEFAULT NULL COMMENT '微信号'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_banner` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `bname` varchar(200) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','url')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `url` varchar(300) NOT NULL COMMENT '文章图片'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `lb_imgs` varchar(500) NOT NULL COMMENT '文章那个内容'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','bname1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `bname1` varchar(200) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','bname2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `bname2` varchar(200) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','bname3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `bname3` varchar(200) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','lb_imgs1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `lb_imgs1` varchar(500) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','lb_imgs2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `lb_imgs2` varchar(500) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','lb_imgs3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `lb_imgs3` varchar(500) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','url1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `url1` varchar(300) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','url2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `url2` varchar(300) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_banner','url3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_banner')." ADD   `url3` varchar(300) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_circle` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `content` text COMMENT '文章内容'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发布时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `img` text COMMENT '图片'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `type` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `uname` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','uphone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `uphone` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','addr')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `addr` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','longitude')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `longitude` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','latitude')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   `latitude` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_circle','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_circle')." ADD   KEY `uid` (`uid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `invuid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_code','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_code')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_code','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_code')." ADD   `oid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_code','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_code')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_code','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_code')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_code','invuid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_code')." ADD   `invuid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_code','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_code')." ADD   `gid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_content` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD   `content` varchar(200) DEFAULT NULL COMMENT '评论内容'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD   `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD   `cid` int(11) DEFAULT NULL COMMENT '所评论的文章ID'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD   `uid` int(11) DEFAULT NULL COMMENT '评论用户'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD   KEY `cid` (`cid`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD   KEY `uid` (`uid`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_content','ims_mzhk_sun_plugin_lottery_content_ibfk_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_content')." ADD   CONSTRAINT `ims_mzhk_sun_plugin_lottery_content_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `ims_mzhk_sun_plugin_lottery_circle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_daily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_daily_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `ims_mzhk_sun_plugin_lottery_gifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_daily','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_daily')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_daily','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_daily')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_daily','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_daily')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_daily','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_daily')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_daily','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_daily')." ADD   KEY `gid` (`gid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_gifts` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `gname` varchar(50) DEFAULT NULL COMMENT '礼物名'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','lottery')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `lottery` varchar(200) DEFAULT NULL COMMENT '简介'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `price` decimal(11,2) DEFAULT NULL COMMENT '价钱'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `type` int(11) DEFAULT NULL COMMENT '类型'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `status` int(11) DEFAULT NULL COMMENT '状态'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `pic` text COMMENT '图片'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','sid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `sid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_gifts','count')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_gifts')." ADD   `count` int(11) DEFAULT NULL COMMENT '库存'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_giftsbanner` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `bname` varchar(200) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','url')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `url` varchar(300) NOT NULL COMMENT '文章图片'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `lb_imgs` varchar(500) NOT NULL COMMENT '文章那个内容'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','bname1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `bname1` varchar(200) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','bname2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `bname2` varchar(200) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','bname3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `bname3` varchar(200) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','lb_imgs1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `lb_imgs1` varchar(500) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','lb_imgs2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `lb_imgs2` varchar(500) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','lb_imgs3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `lb_imgs3` varchar(500) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','url1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `url1` varchar(300) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','url2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `url2` varchar(300) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_giftsbanner','url3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_giftsbanner')." ADD   `url3` varchar(300) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_goods` (
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='点击 ';

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD 
  `gid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `gname` text CHARACTER SET gbk COMMENT '抽奖名称/红包金额'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','count')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `count` varchar(45) CHARACTER SET gbk DEFAULT NULL COMMENT '数量'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','selftime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `selftime` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '加入时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `pic` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '封面图'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `uid` int(11) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','sid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `sid` int(11) DEFAULT NULL COMMENT '赞助商id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `cid` int(11) DEFAULT NULL COMMENT '抽奖类型'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `status` int(11) DEFAULT '2' COMMENT '抽奖状态'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','condition')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `condition` int(11) DEFAULT NULL COMMENT '开奖条件，0为按时间，1按人数，2手动，3现场'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','accurate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `accurate` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '开奖条件，填写准确时间，人数'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `endtime` varchar(200) CHARACTER SET gbk DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','lottery')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `lottery` text");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','zuid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `zuid` int(11) DEFAULT NULL COMMENT '指定人中奖ID'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','giftId')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `giftId` int(11) DEFAULT NULL COMMENT '关联礼物ID'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','code_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `code_img` mediumblob COMMENT '小程序码二进制'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `img` text");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','paidprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `paidprice` decimal(11,2) DEFAULT NULL COMMENT '付费抽奖费用'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','password')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `password` varchar(50) DEFAULT NULL COMMENT '参与口令'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','group')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `group` int(11) DEFAULT NULL COMMENT '组团抽奖人数'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','codenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `codenum` int(11) DEFAULT NULL COMMENT '抽奖码总数'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','codemost')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `codemost` int(11) DEFAULT NULL COMMENT '每人可获取最多数量'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','codecount')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `codecount` int(11) DEFAULT NULL COMMENT '须分享几次获取一个抽奖码'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','codeway')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `codeway` int(2) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','onename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `onename` varchar(50) DEFAULT NULL COMMENT '一等奖名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','onenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `onenum` int(11) DEFAULT NULL COMMENT '一等奖数量'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','twoname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `twoname` varchar(50) DEFAULT NULL COMMENT '二等奖名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','twonum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `twonum` int(11) DEFAULT NULL COMMENT '二等奖数量'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','threename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `threename` varchar(50) DEFAULT NULL COMMENT '三等奖名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','threenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `threenum` int(11) DEFAULT NULL COMMENT '三等奖数量'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `state` int(2) DEFAULT NULL COMMENT '高级抽奖类型，1为付费，2为口令，3为组团，4为抽奖码'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','one')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `one` int(2) DEFAULT NULL COMMENT '1为开启一二三等奖，2为不开启'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','isbuy')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `isbuy` int(2) DEFAULT '2' COMMENT '1购买商品后才可抽奖，2为皆可'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','isshow')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `isshow` int(2) DEFAULT '0' COMMENT '1展示，2不展示'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','showbrand')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   `showbrand` varchar(200) DEFAULT NULL COMMENT '商家ID'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   PRIMARY KEY (`gid`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goods','giftId')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goods')." ADD   KEY `giftId` (`giftId`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_goodsdaily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  CONSTRAINT `ims_mzhk_sun_plugin_lottery_goodsdaily_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `ims_mzhk_sun_plugin_lottery_goods` (`gid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodsdaily','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodsdaily')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodsdaily','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodsdaily')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodsdaily','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodsdaily')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodsdaily','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodsdaily')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodsdaily','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodsdaily')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodsdaily','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodsdaily')." ADD   KEY `gid` (`gid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_goodslottery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `gid` int(11) NOT NULL COMMENT '黑卡商品ID',
  `ggid` int(11) NOT NULL COMMENT '黑卡大抽奖商品ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodslottery','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodslottery')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodslottery','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodslottery')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodslottery','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodslottery')." ADD   `gid` int(11) NOT NULL COMMENT '黑卡商品ID'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodslottery','ggid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodslottery')." ADD   `ggid` int(11) NOT NULL COMMENT '黑卡大抽奖商品ID'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_goodspi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodspi','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodspi')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodspi','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodspi')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_goodspi','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_goodspi')." ADD   `name` varchar(50) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `invuid` int(11) DEFAULT NULL COMMENT '团长ID',
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_group','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_group')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_group','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_group')." ADD   `oid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_group','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_group')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_group','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_group')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_group','invuid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_group')." ADD   `invuid` int(11) DEFAULT NULL COMMENT '团长ID'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_group','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_group')." ADD   `gid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `answer` varchar(200) DEFAULT NULL COMMENT '回答',
  `uniacid` int(11) DEFAULT NULL COMMENT '模块名',
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_help','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_help')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_help','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_help')." ADD   `title` varchar(50) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_help','answer')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_help')." ADD   `answer` varchar(200) DEFAULT NULL COMMENT '回答'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_help','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_help')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '模块名'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_help','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_help')." ADD   `time` varchar(50) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(11) DEFAULT NULL COMMENT '期限',
  `money` varchar(50) DEFAULT NULL COMMENT '价格',
  `uniacid` int(11) DEFAULT NULL COMMENT '模块名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_in','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_in')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_in','day')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_in')." ADD   `day` int(11) DEFAULT NULL COMMENT '期限'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_in','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_in')." ADD   `money` varchar(50) DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_in','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_in')." ADD   `uniacid` int(11) DEFAULT NULL COMMENT '模块名'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `recharge` decimal(50,2) DEFAULT NULL,
  `youhui` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_money','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_money')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_money','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_money')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_money','recharge')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_money')." ADD   `recharge` decimal(50,2) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_money','youhui')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_money')." ADD   `youhui` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_money','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_money')." ADD   `status` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_order` (
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD 
  `oid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','orderNum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `orderNum` varchar(50) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `status` varchar(255) DEFAULT '1' COMMENT '1 待开奖，2中奖，3没有中奖'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `time` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `uid` int(11) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','adid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `adid` int(100) DEFAULT NULL COMMENT '地址表id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `state` int(11) DEFAULT '1' COMMENT '是否已转赠'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `type` int(11) DEFAULT NULL COMMENT '1为付费，2为口令，3为组团，4为抽奖码'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_order','one')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_order')." ADD   `one` int(2) DEFAULT NULL COMMENT '0非，1为一等奖，2为二等奖，3为三等奖'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_praise` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_praise','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_praise')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_praise','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_praise')." ADD   `uid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_praise','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_praise')." ADD   `cid` int(11) DEFAULT NULL COMMENT '点赞文章的ID'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_praise','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_praise')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_praise','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_praise')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_praise','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_praise')." ADD   KEY `cid` (`cid`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_praise','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_praise')." ADD   KEY `uid` (`uid`)");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_praise','ims_mzhk_sun_plugin_lottery_praise_ibfk_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_praise')." ADD   CONSTRAINT `ims_mzhk_sun_plugin_lottery_praise_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ims_mzhk_sun_plugin_lottery_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_selectedtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tname` varchar(45) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `img` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_selectedtype','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_selectedtype')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_selectedtype','tname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_selectedtype')." ADD   `tname` varchar(45) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_selectedtype','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_selectedtype')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_selectedtype','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_selectedtype')." ADD   `time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_selectedtype','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_selectedtype')." ADD   `img` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_settab` (
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

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD   `name` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD   `img` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','path')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD   `path` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','imgs')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD   `imgs` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD   `type` int(11) DEFAULT NULL COMMENT '2底部，1首页'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_settab','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_settab')." ADD   `state` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_setting` (
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

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','weid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `appid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','appsecret')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `appsecret` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `mch_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','key')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `key` varchar(512) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','store_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `store_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','recharge_btn')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `recharge_btn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','recharge_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `recharge_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','register_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `register_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','is_sms')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `is_sms` tinyint(3) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','sms_info')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `sms_info` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','is_printer')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `is_printer` tinyint(3) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_setting','copyright')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_setting')." ADD   `copyright` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_sms` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sms','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sms')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sms','appkey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sms')." ADD   `appkey` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sms','tpl_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sms')." ADD   `tpl_id` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sms','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sms')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sms','is_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sms')." ADD   `is_open` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sms','tid1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sms')." ADD   `tid1` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sms','tid2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sms')." ADD   `tid2` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sms','tid3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sms')." ADD   `tid3` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sms','qitui')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sms')." ADD   `qitui` text NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_sponsorship` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','sid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD 
  `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT '赞助商id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','sname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `sname` text COMMENT '赞助商名'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','synopsis')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `synopsis` text COMMENT '简介'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','address')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `address` text COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','phone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `phone` text");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','wx')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `wx` text COMMENT '联系人微信号'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `logo` varchar(200) DEFAULT NULL COMMENT 'LOGO'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','ewm_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `ewm_logo` varchar(200) DEFAULT NULL COMMENT '二维码'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `time` varchar(200) DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','day')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `day` int(11) DEFAULT NULL COMMENT '天数'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `endtime` varchar(200) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `status` tinyint(1) DEFAULT NULL COMMENT '状态'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `uid` int(11) DEFAULT NULL COMMENT '关联用户ID'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsorship','pwd')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsorship')." ADD   `pwd` varchar(50) DEFAULT NULL COMMENT '后台登录密码'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_sponsortext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsortext','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsortext')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsortext','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsortext')." ADD   `content` text");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_sponsortext','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_sponsortext')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '团队名称',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `logo` varchar(255) DEFAULT NULL COMMENT 'LOGO',
  `uniacid` int(11) DEFAULT NULL,
  `condition` int(11) DEFAULT NULL COMMENT '联系方式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_support','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_support')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_support','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_support')." ADD   `name` varchar(50) DEFAULT NULL COMMENT '团队名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_support','phone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_support')." ADD   `phone` varchar(20) DEFAULT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_support','logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_support')." ADD   `logo` varchar(255) DEFAULT NULL COMMENT 'LOGO'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_support','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_support')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_support','condition')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_support')." ADD   `condition` int(11) DEFAULT NULL COMMENT '联系方式'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_system` (
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

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `appid` varchar(100) NOT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `appsecret` varchar(200) NOT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','mchid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `mchid` varchar(20) NOT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','url_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `url_name` varchar(20) NOT NULL COMMENT '网址名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','details')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `details` text NOT NULL COMMENT '关于我们'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `url_logo` varchar(100) NOT NULL COMMENT '网址logo'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `bq_name` varchar(50) NOT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','link_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `link_name` varchar(30) NOT NULL COMMENT '网站名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `link_logo` varchar(100) NOT NULL COMMENT '网站logo'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','support')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `support` varchar(20) NOT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `bq_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `fontcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','color')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `color` varchar(20) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tz_appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tz_name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','pt_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `pt_name` varchar(30) NOT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tz_audit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tz_audit` int(11) NOT NULL DEFAULT '0' COMMENT '红包手续费'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','sj_audit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `sj_audit` int(11) NOT NULL COMMENT '商家审核0.是 1否'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','mapkey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `mapkey` varchar(200) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','gd_key')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `gd_key` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','hb_sxf')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `hb_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tx_money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tx_sxf')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tx_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tx_details')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tx_details` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','rz_xuz')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `rz_xuz` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','ft_xuz')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `ft_xuz` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','fx_money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `fx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_hhr')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_hhr` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_hbfl')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_hbfl` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_zx')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_zx` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_car')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_car` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','pc_xuz')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `pc_xuz` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','pc_money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `pc_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_sjrz')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_sjrz` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_pcfw')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_pcfw` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','total_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `total_num` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_goods')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_goods` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `apiclient_cert` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `apiclient_key` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_openzx')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_openzx` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_hyset')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_hyset` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_tzopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_tzopen` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_pageopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_pageopen` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','cityname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_tel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_tel` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tx_mode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tx_mode` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','many_city')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `many_city` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tx_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tx_type` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_hbzf')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_hbzf` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','hb_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `hb_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','tz_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `tz_num` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `client_ip` varchar(30) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','hb_content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `hb_content` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_vipcardopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_vipcardopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_jkopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_jkopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','address')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `address` varchar(150) DEFAULT NULL COMMENT '店铺地址'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','sj_ruzhu')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `sj_ruzhu` int(5) DEFAULT NULL COMMENT '0为关闭1为开启'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_kanjiaopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_kanjiaopen` int(4) DEFAULT '0' COMMENT '0关闭1开启'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','bargain_price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `bargain_price` varchar(10) DEFAULT NULL COMMENT '每次砍价的%'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','sign')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `sign` varchar(12) DEFAULT NULL COMMENT '本店招牌自定义'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','bargain_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `bargain_title` varchar(15) DEFAULT NULL COMMENT '砍价分享标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_pintuanopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_pintuanopen` int(4) DEFAULT NULL COMMENT '2为关闭1为开启'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','refund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `refund` int(4) DEFAULT '1' COMMENT '1为买家申请2为自动退款'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','refund_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `refund_time` int(4) DEFAULT '0' COMMENT '自动退款时间 1为24；2为48；3为72；4为活动结束；5为不退款'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','groups_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `groups_title` varchar(45) DEFAULT NULL COMMENT '拼团分享标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','mask')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `mask` int(2) DEFAULT '1' COMMENT '0不显示1显示'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_couponopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_couponopen` int(4) DEFAULT '2' COMMENT '1为开启2为关闭'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','support_font')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `support_font` varchar(25) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','support_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `support_logo` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','support_tel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `support_tel` varchar(40) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','psopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `psopen` int(2) DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','is_open_pop')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `is_open_pop` int(2) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','version')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `version` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','auto_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `auto_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','manu_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `manu_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','gift_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `gift_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','auto_logo1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `auto_logo1` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','manu_logo1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `manu_logo1` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','cj_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `cj_name` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','dt_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `dt_name` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','cj_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `cj_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','cjzt')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `cjzt` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','dt_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `dt_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','discount')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `discount` decimal(11,2) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','paidprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `paidprice` decimal(11,2) DEFAULT NULL COMMENT '付费抽奖价格'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','passwordprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `passwordprice` decimal(11,2) DEFAULT NULL COMMENT '口令抽奖价格'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','growpprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `growpprice` decimal(11,2) DEFAULT NULL COMMENT '组团抽奖价格'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','codeprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `codeprice` decimal(11,2) DEFAULT NULL COMMENT '抽奖码价格'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','oneprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `oneprice` decimal(11,2) DEFAULT NULL COMMENT '抽奖码价格'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','senior')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `senior` int(2) DEFAULT NULL COMMENT '高级抽奖开关'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_system','instructions')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_system')." ADD   `instructions` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_type` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD   `type` varchar(50) DEFAULT NULL COMMENT '类型'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','url')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD   `url` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD   `img` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','url2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD   `url2` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','img2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD   `img2` varchar(500) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','url3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD   `url3` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_type','img3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_type')." ADD   `img3` varchar(500) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_user` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `img` varchar(200) DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `time` datetime DEFAULT NULL COMMENT '登录时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `money` decimal(11,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','user_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `user_name` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','user_tel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `user_tel` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','user_address')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `user_address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','commission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `commission` decimal(11,0) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `state` int(4) DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','attention')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `attention` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','fans')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `fans` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','collection')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `collection` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   `name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_user','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_user')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  `gid` int(11) DEFAULT NULL COMMENT '关联的项目id',
  `state` int(11) DEFAULT NULL COMMENT '发起用户为1，参与用户为2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='formid表';

");

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_userformid','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_userformid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_userformid','user_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_userformid')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_userformid','form_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_userformid')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_userformid','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_userformid')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_userformid','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_userformid')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_userformid','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_userformid')." ADD   `openid` varchar(50) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_userformid','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_userformid')." ADD   `gid` int(11) DEFAULT NULL COMMENT '关联的项目id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_userformid','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_userformid')." ADD   `state` int(11) DEFAULT NULL COMMENT '发起用户为1，参与用户为2'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_lottery_withdrawal` (
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

if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `name` varchar(10) NOT NULL COMMENT '真实姓名'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','username')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `username` varchar(100) NOT NULL COMMENT '账号'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `type` int(11) NOT NULL COMMENT '1支付宝 2.微信 3.银行'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `time` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','sh_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `state` int(11) NOT NULL COMMENT '1.待审核 2.通过  3.拒绝'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','tx_cost')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','sj_cost')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','user_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_plugin_lottery_withdrawal','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_lottery_withdrawal')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_address` (
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='地址';

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','phone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `phone` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','province')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `province` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','city')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `city` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','zip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `zip` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','address')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','postalcode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `postalcode` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','default')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '默认地址'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','lottery')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `lottery` tinyint(4) NOT NULL DEFAULT '0' COMMENT '抽奖收货地址'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_address','edit_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_address')." ADD   `edit_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_article` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','icon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `icon` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','icon_vertical')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `icon_vertical` varchar(255) DEFAULT NULL COMMENT '竖向图标'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','show_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `show_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '首页展示类型 1竖向 2横向'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','url')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','file_path')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `file_path` varchar(255) DEFAULT NULL COMMENT '音频'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','read_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `state` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','show_index')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在首页'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','show_task')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `show_task` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在任务'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','publish_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `publish_time` int(11) DEFAULT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','tg_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `tg_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_article','jj_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_article')." ADD   `jj_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_bargainrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `bargain_openid` varchar(60) DEFAULT NULL COMMENT '砍价用户',
  `bargain_score` int(11) DEFAULT NULL COMMENT '砍价积分',
  `add_time` int(11) DEFAULT NULL COMMENT '砍价时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='砍价记录';

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_bargainrecord','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_bargainrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_bargainrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_bargainrecord','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_bargainrecord','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_bargainrecord','bargain_openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `bargain_openid` varchar(60) DEFAULT NULL COMMENT '砍价用户'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_bargainrecord','bargain_score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `bargain_score` int(11) DEFAULT NULL COMMENT '砍价积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_bargainrecord','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `add_time` int(11) DEFAULT NULL COMMENT '砍价时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_customize` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2营销案图标 3底部图标'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '标题名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '图标图片'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','clickago_icon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `clickago_icon` varchar(200) DEFAULT NULL COMMENT '点击前图标'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','clickafter_icon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `clickafter_icon` varchar(200) DEFAULT NULL COMMENT '点击后图标'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','url_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `url_type` tinyint(4) DEFAULT NULL COMMENT '链接类型 1基本 2商品分类'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','url')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `url` varchar(200) DEFAULT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','url_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `url_name` varchar(50) DEFAULT NULL COMMENT '链接名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `sort` tinyint(4) DEFAULT NULL COMMENT '排序 越大越前'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_customize','store_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_customize')." ADD   `store_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_goods` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `lid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1积分商品 2抽奖商品'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `title` varchar(200) DEFAULT NULL COMMENT '商品名'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '展示图'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','lb_pics')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `lb_pics` text COMMENT '轮播图'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `price` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '价值'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT '价值总积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','bargain_score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '可砍积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','min_score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `min_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最小积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','max_score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `max_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最大积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '库存'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','sale_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `sale_num` int(11) NOT NULL DEFAULT '0' COMMENT '已兑换'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','begin_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `begin_time` int(11) DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','end_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `end_time` int(11) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_goods','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_goods')." ADD   `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_lotteryprize` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型  1积分商城物品 2积分 3谢谢参与'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT 'type为1时 使用'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT 'type为2时使用'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `pic` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','rate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `rate` int(11) NOT NULL DEFAULT '0' COMMENT '中奖概率'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '奖品数量'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','zj_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `zj_num` int(11) NOT NULL DEFAULT '0' COMMENT '中奖数量'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_lotteryprize','edit_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `edit_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_order` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `lid` int(11) NOT NULL DEFAULT '0' COMMENT '1积分商城订单 2抽奖订单'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','orderformid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `orderformid` varchar(60) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '数量'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','order_score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `order_score` int(11) NOT NULL DEFAULT '0' COMMENT '消费的积分(兑换的积分)'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','bargain_score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '砍价多少积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','pay_status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '兑换状态 支付状态 1支付兑换'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','order_status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未兑换  1已支付(待发货) 3完成'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `pay_time` int(11) DEFAULT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','wc_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `wc_time` int(11) DEFAULT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','fahuo_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `fahuo_time` int(11) DEFAULT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','phone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `phone` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','province')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `province` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','city')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `city` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','zip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `zip` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','address')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `address` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','postalcode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `postalcode` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','express_delivery')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `express_delivery` varchar(60) DEFAULT NULL COMMENT '物流公司'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','express_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `express_no` varchar(60) DEFAULT NULL COMMENT '物流单号'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','remark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `remark` varchar(200) DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','lottery_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `lottery_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型1积分商品实物 2积分 '");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_order','lotteryprize_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_order')." ADD   `lotteryprize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_readrecord` (
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='阅读记录';

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_readrecord','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_readrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_readrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_readrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_readrecord','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_readrecord')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_readrecord','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_readrecord')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '类型 1文章阅读记录  2文章马克记录 3邀请阅读记录 4邀请新用户记录'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_readrecord','article_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_readrecord')." ADD   `article_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_readrecord','date')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_readrecord')." ADD   `date` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_readrecord','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_readrecord')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_readrecord','invited_openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_readrecord')." ADD   `invited_openid` varchar(60) DEFAULT NULL COMMENT '邀请用户'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_readrecord','is_mark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_readrecord')." ADD   `is_mark` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1收藏 0取消收藏'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_system` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `appid` varchar(100) NOT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `appsecret` varchar(200) NOT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','mchid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `mchid` varchar(20) NOT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','url_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `url_name` varchar(20) NOT NULL COMMENT '网址名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','details')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `details` text NOT NULL COMMENT '关于我们'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `url_logo` varchar(100) NOT NULL COMMENT '网址logo'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `bq_name` varchar(50) NOT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','link_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `link_name` varchar(30) NOT NULL COMMENT '网站名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `link_logo` varchar(100) NOT NULL COMMENT '网站logo'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','support')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `support` varchar(20) NOT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `bq_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `fontcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','color')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `color` varchar(20) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tz_appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tz_name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','pt_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `pt_name` varchar(30) NOT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tz_audit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tz_audit` int(11) NOT NULL COMMENT '帖子审核1.是 2否'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','sj_audit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `sj_audit` int(11) NOT NULL COMMENT '商家审核1.是 2否'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','mapkey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `mapkey` varchar(200) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','gd_key')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `gd_key` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','hb_sxf')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `hb_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tx_money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tx_sxf')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tx_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tx_details')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tx_details` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','rz_xuz')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `rz_xuz` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','ft_xuz')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `ft_xuz` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','fx_money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `fx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_hhr')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_hhr` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_hbfl')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_hbfl` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_zx')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_zx` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_car')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_car` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','pc_xuz')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `pc_xuz` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','pc_money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `pc_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_sjrz')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_sjrz` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_pcfw')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_pcfw` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','total_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `total_num` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_goods')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_goods` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `apiclient_cert` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `apiclient_key` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_openzx')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_openzx` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_hyset')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_hyset` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_tzopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_tzopen` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_pageopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_pageopen` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','cityname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_tel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_tel` int(4) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tx_mode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tx_mode` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','many_city')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `many_city` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tx_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tx_type` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_hbzf')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_hbzf` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','hb_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `hb_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tz_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tz_num` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `client_ip` varchar(30) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','hb_content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `hb_content` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_vipcardopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_vipcardopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_jkopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_jkopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','address')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `address` varchar(150) DEFAULT NULL COMMENT '店铺地址'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','sj_ruzhu')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `sj_ruzhu` int(5) DEFAULT NULL COMMENT '0为关闭1为开启'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_kanjiaopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_kanjiaopen` int(4) DEFAULT '0' COMMENT '0关闭1开启'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','bargain_price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `bargain_price` varchar(10) DEFAULT NULL COMMENT '每次砍价的%'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','sign')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `sign` varchar(12) DEFAULT NULL COMMENT '本店招牌自定义'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','bargain_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `bargain_title` varchar(15) DEFAULT NULL COMMENT '砍价分享标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_pintuanopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_pintuanopen` int(4) DEFAULT NULL COMMENT '2为关闭1为开启'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','refund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `refund` int(4) DEFAULT '1' COMMENT '1为买家申请2为自动退款'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','refund_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `refund_time` int(4) DEFAULT '0' COMMENT '自动退款时间 1为24；2为48；3为72；4为活动结束；5为不退款'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','groups_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `groups_title` varchar(45) DEFAULT NULL COMMENT '拼团分享标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','mask')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `mask` int(2) DEFAULT '1' COMMENT '0不显示1显示'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','announcement')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `announcement` varchar(60) DEFAULT NULL COMMENT '首页公告'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','shopmsg_status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `shopmsg_status` tinyint(1) DEFAULT NULL COMMENT '欢迎语开关'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','shopmsg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `shopmsg` varchar(60) DEFAULT NULL COMMENT '欢迎语'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','shopmsg2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `shopmsg2` varchar(60) DEFAULT NULL COMMENT '问题咨询'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','shopmsg_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `shopmsg_img` varchar(200) DEFAULT NULL COMMENT '欢迎头像'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_yuyueopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_yuyueopen` int(4) DEFAULT NULL COMMENT '开启预约 1开启 2禁用'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','yuyue_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `yuyue_title` varchar(60) DEFAULT NULL COMMENT '预约分享标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_haowuopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_haowuopen` int(4) DEFAULT NULL COMMENT '开启好物'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','haowu_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `haowu_title` varchar(60) DEFAULT NULL COMMENT '好物分享标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_couponopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_couponopen` int(4) DEFAULT NULL COMMENT '开启优惠券 1开启 2禁用'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','coupon_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `coupon_title` varchar(60) DEFAULT NULL COMMENT '分享优惠券标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','coupon_banner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `coupon_banner` varchar(200) DEFAULT NULL COMMENT '优惠券banner'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_gywmopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_gywmopen` int(4) DEFAULT NULL COMMENT '开启关于我们'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','gywm_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `gywm_title` varchar(60) DEFAULT NULL COMMENT '分享关于我们标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_xianshigouopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_xianshigouopen` int(4) DEFAULT NULL COMMENT '开启限时购 1开启 '");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','xianshigou_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `xianshigou_title` varchar(60) DEFAULT NULL COMMENT '分享限时购标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_shareopen')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_shareopen` int(4) DEFAULT NULL COMMENT '开启分享 1开启'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','share_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `share_title` varchar(60) DEFAULT NULL COMMENT '分享分享标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','customer_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `customer_time` varchar(30) DEFAULT NULL COMMENT '客服时间'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','provide')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `provide` varchar(255) DEFAULT NULL COMMENT '基础服务'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','shop_banner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `shop_banner` text COMMENT '商店banner'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','shop_details')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `shop_details` text COMMENT '商店介绍'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','gywm_banner')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `gywm_banner` varchar(200) DEFAULT NULL COMMENT '关于我们banner'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','shopdes')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `shopdes` text COMMENT '商店介绍 详情'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','shopdes_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `shopdes_img` text COMMENT '商店介绍图'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','distribution')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','ziti_address')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `ziti_address` varchar(200) DEFAULT NULL COMMENT '商家自提地址'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','ddmd_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `ddmd_img` varchar(100) DEFAULT NULL COMMENT '到店买单头像'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','ddmd_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `ddmd_title` varchar(100) DEFAULT NULL COMMENT '到店买单商户名称'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','hx_openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `hx_openid` text COMMENT '核销人员openid'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','tag')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `tag` varchar(200) DEFAULT NULL COMMENT '店铺标签'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_by')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_by` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否全店包邮'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_xxpf')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_xxpf` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否先行赔付'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_qtwy')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_qtwy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否七天无忧退款退货'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','yuyue_sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `yuyue_sort` int(11) NOT NULL DEFAULT '0' COMMENT '预约 首页推荐排序'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','haowu_sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `haowu_sort` int(11) NOT NULL DEFAULT '0' COMMENT '好物 首页推荐排序'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','groups_sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `groups_sort` int(11) NOT NULL DEFAULT '0' COMMENT '拼团 首页推荐排序'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','bargain_sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `bargain_sort` int(11) NOT NULL DEFAULT '0' COMMENT '砍价 首页推荐排序'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','xianshigou_sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `xianshigou_sort` int(11) NOT NULL DEFAULT '0' COMMENT '限时购首页推荐 排序'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','share_sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `share_sort` int(11) NOT NULL DEFAULT '0' COMMENT '分享首页推荐排序'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','xinpin_sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `xinpin_sort` int(11) NOT NULL DEFAULT '0' COMMENT '新品 首页推荐排序'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','index_adv_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `index_adv_img` varchar(100) DEFAULT NULL COMMENT '首页广告图'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_adv')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_adv` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启首页广告 1开启'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','share_rule')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `share_rule` text COMMENT '分享金规则'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','groups_rule')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `groups_rule` text COMMENT '拼团规则说明'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','coordinates')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `coordinates` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','longitude')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `longitude` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','latitude')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `latitude` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','index_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `index_title` varchar(60) DEFAULT NULL COMMENT '首页自定义标题'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','hz_tel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `hz_tel` varchar(60) DEFAULT NULL COMMENT '首页合作电话'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','jszc_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `jszc_img` varchar(200) DEFAULT NULL COMMENT '技术支持头像'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','jszc_tdcp')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `jszc_tdcp` varchar(200) DEFAULT NULL COMMENT '首页技术支持团队出品'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','index_layout')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `index_layout` text COMMENT '首页布局'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_layout')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_layout` tinyint(4) DEFAULT '0' COMMENT '首页布局开关 1开'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_techzhichi')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_techzhichi` tinyint(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','store_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `store_open` tinyint(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','lottery_score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `lottery_score` int(11) NOT NULL DEFAULT '0' COMMENT '抽奖消费积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','lottery_rule')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `lottery_rule` text COMMENT '抽奖规则'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','aboutus')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `aboutus` text COMMENT '关于我们'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_system','is_show')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_system')." ADD   `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 '");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_task` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_task','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_task')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_task','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_task')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_task','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_task')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '任务类型 1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖 6马克 7邀请好友'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_task','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_task')." ADD   `title` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_task','icon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_task')." ADD   `icon` varchar(250) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_task','task_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_task')." ADD   `task_num` int(11) NOT NULL DEFAULT '1' COMMENT '任务数'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_task','score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_task')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT '积分完成一个任务得到积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_task','task_score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_task')." ADD   `task_score` int(11) NOT NULL DEFAULT '0' COMMENT '任务页面显示积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_task','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_task')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_taskrecord` (
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
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COMMENT='任务积分记录表 ';

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `openid` varchar(60) DEFAULT NULL COMMENT '用户openid(获得积分的用户)'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖(增加) 6马克 7邀请新用户 8兑换积分商品 9积分抽奖(消耗) 10抽奖中奖积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','task_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `task_id` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','sign')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT '获得积分'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','date')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `date` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','article_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `article_id` int(11) DEFAULT NULL COMMENT '文章id 阅读和邀请看文章使用 马克'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','beinvited_openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `beinvited_openid` varchar(60) DEFAULT NULL COMMENT '被邀请用户openid 邀请看文章使用 、好友砍积分使用、新用户'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','goods_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `goods_id` int(11) DEFAULT NULL COMMENT '商品id 砍价积分商品使用 '");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskrecord','prize_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." ADD   `prize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_taskset` (
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

");

if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskset','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskset','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskset')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskset','task_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskset')." ADD   `task_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskset','task_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskset')." ADD   `task_type` tinyint(4) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskset','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskset')." ADD   `title` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskset','score')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskset')." ADD   `score` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskset','icon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskset')." ADD   `icon` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_plugin_scoretask_taskset','add_time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_plugin_scoretask_taskset')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_popbanner` (
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

");

if(!pdo_fieldexists('mzhk_sun_popbanner','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','pop_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `pop_title` varchar(50) NOT NULL COMMENT '弹窗名称'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','pop_urltype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `pop_urltype` tinyint(2) NOT NULL DEFAULT '1' COMMENT '弹窗链接类别'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','pop_urltxt')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `pop_urltxt` int(11) NOT NULL COMMENT '相关 id'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','pop_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `pop_img` varchar(200) NOT NULL COMMENT '弹窗图'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `sort` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','position')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `position` int(5) NOT NULL DEFAULT '1' COMMENT '1弹窗，2首页轮播（默认主题），3砍价列表，4集卡列表，5抢购列表，6拼团列表，7免单列表，8营销图标，9底部导航，10广告1（主题2），10广告2（主题2）'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','unselectimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `unselectimg` varchar(255) DEFAULT NULL COMMENT '未选中图标'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','isshow')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1显示，0不显示'");}
if(!pdo_fieldexists('mzhk_sun_popbanner','vice_pop_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_popbanner')." ADD   `vice_pop_title` varchar(100) NOT NULL COMMENT '副标题，用于主题4'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_ptgroups` (
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
  `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金',
  `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金',
  `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金',
  `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '云店佣金',
  `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价格',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_ptgroups','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','groupordernum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `groupordernum` varchar(50) NOT NULL COMMENT '团单号，非订单号'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','detailinfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `detailinfo` varchar(200) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','telnumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `telnumber` varchar(100) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '总价'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `status` tinyint(2) DEFAULT '2' COMMENT '1 取消订单，2待支付，3已支付，4待发货，5已完成'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `openid` varchar(150) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','countyname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `countyname` varchar(150) DEFAULT NULL COMMENT '区域'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','provincename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `provincename` varchar(150) DEFAULT NULL COMMENT '省份'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `name` varchar(100) DEFAULT NULL COMMENT '名字'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `addtime` int(11) DEFAULT NULL COMMENT '加入的时间'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','cityname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `cityname` varchar(100) DEFAULT NULL COMMENT '城市'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','uremark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `uremark` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','sincetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `sincetype` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `paytime` int(11) DEFAULT '0' COMMENT '付款时间'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `gid` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `gname` varchar(200) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','is_lead')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `is_lead` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否团长，1是，0不是'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','order_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `order_id` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','shiptime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `shiptime` int(11) NOT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `out_trade_no` varchar(100) DEFAULT NULL COMMENT '外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型，0拼团，1单独购买'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `endtime` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '数量为1'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','deliveryfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','isrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `isrefund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','goodsimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `goodsimg` varchar(200) NOT NULL COMMENT '商品图'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `bname` varchar(100) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','shipnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `shipnum` varchar(50) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','shipname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `shipname` varchar(50) NOT NULL COMMENT '快递名称'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `finishtime` int(11) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `expirationtime` int(11) NOT NULL COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','rmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','source')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','fbid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','ispackage')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0非套餐，1套餐'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','packageoid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `packageoid` int(11) NOT NULL COMMENT '套餐订单ID'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','packageid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `packageid` int(11) NOT NULL COMMENT '套餐ID'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','commission_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','totalcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','fxmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','csmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '云店佣金'");}
if(!pdo_fieldexists('mzhk_sun_ptgroups','goodsprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptgroups')." ADD   `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价格'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_ptorders` (
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
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_ptorders','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '拼团id'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `gid` int(11) DEFAULT NULL COMMENT '商品的id'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT '团长用户的id'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `addtime` int(11) DEFAULT NULL COMMENT '生成时间'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_ptorders','is_ok')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `is_ok` tinyint(2) DEFAULT '0' COMMENT '是否成功拼团，1成功，0未成功，2取消关闭'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `money` decimal(10,2) DEFAULT '0.00' COMMENT '拼团价格'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','buynum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `buynum` int(11) NOT NULL DEFAULT '0' COMMENT '拼团人数，实际购买人数'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','ordernum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `ordernum` varchar(100) NOT NULL COMMENT '拼团总单号'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `gname` varchar(200) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','peoplenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `peoplenum` int(11) NOT NULL DEFAULT '0' COMMENT '参与该团人数，包括未付款'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','groupuser_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `groupuser_id` varchar(100) DEFAULT NULL COMMENT '成功参与拼团会员id'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','groupuser_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `groupuser_img` text COMMENT '成功参与拼团会员头像'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `endtime` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间'");}
if(!pdo_fieldexists('mzhk_sun_ptorders','neednum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_ptorders')." ADD   `neednum` int(11) NOT NULL DEFAULT '0' COMMENT '需要人数'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_qgformid` (
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

");

if(!pdo_fieldexists('mzhk_sun_qgformid','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgformid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_qgformid','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgformid')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgformid','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgformid')." ADD   `gid` int(11) NOT NULL COMMENT '开抢提醒商品id'");}
if(!pdo_fieldexists('mzhk_sun_qgformid','formId')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgformid')." ADD   `formId` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgformid','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgformid')." ADD   `openid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgformid','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgformid')." ADD   `addtime` varchar(100) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_qgformid','open_tips')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgformid')." ADD   `open_tips` int(11) NOT NULL DEFAULT '0' COMMENT '开启抢购提醒 0 不开启 1 已开启'");}
if(!pdo_fieldexists('mzhk_sun_qgformid','istips')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgformid')." ADD   `istips` int(11) NOT NULL DEFAULT '0' COMMENT '是否已提醒 0 未提醒 1 已提醒'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_qgorder` (
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
  `specdetail` varchar(50) NOT NULL DEFAULT '0' COMMENT '所选规格详细',
  `spec` int(11) NOT NULL DEFAULT '0' COMMENT '所选规格',
  `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金',
  `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金',
  `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金',
  `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '云店佣金',
  `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价格',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_qgorder','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD 
  `oid` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_qgorder','orderNum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `orderNum` varchar(50) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','detailInfo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `detailInfo` varchar(200) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','telNumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `telNumber` varchar(100) DEFAULT NULL COMMENT '电话'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `money` decimal(10,2) DEFAULT NULL COMMENT '总价'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `status` tinyint(2) DEFAULT '2' COMMENT '1 取消订单，2待支付，3待发货，4已支付，5已完成'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `openid` varchar(150) DEFAULT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorder','countyName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `countyName` varchar(150) DEFAULT NULL COMMENT '区域'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','provinceName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `provinceName` varchar(150) DEFAULT NULL COMMENT '省份'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `name` varchar(100) DEFAULT NULL COMMENT '名字'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `addtime` int(11) DEFAULT '0' COMMENT '加入的时间'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','cityName')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `cityName` varchar(100) DEFAULT NULL COMMENT '城市'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','uremark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `uremark` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorder','sincetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `sincetype` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorder','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `time` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorder','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `paytime` int(11) NOT NULL COMMENT '付款时间'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `gname` varchar(200) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '购买数量'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `out_trade_no` varchar(200) DEFAULT NULL COMMENT '外部订单id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','ordertype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `ordertype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型，0普通，1抢购，2拼团，3砍价'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','deliveryfee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `deliveryfee` decimal(10,2) NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','goodsimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `goodsimg` varchar(200) NOT NULL COMMENT '商品图'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `bname` varchar(200) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','isrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `isrefund` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0正常，1申请退款，2已退款'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','shipname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `shipname` varchar(50) NOT NULL COMMENT '快递名称'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','shipnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `shipnum` varchar(50) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','shiptime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `shiptime` int(11) NOT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `finishtime` int(11) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `out_refund_no` varchar(100) NOT NULL COMMENT '退款单号'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `expirationtime` int(11) NOT NULL COMMENT '核销过期时间'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `paytype` tinyint(5) NOT NULL DEFAULT '1' COMMENT '1微信支付，2余额支付'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','haswrittenoffnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `haswrittenoffnum` int(11) NOT NULL COMMENT '已核销数'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `rid` int(11) NOT NULL DEFAULT '0' COMMENT '红包id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','rmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','source')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '红包金额来源 0 正常支付 1 商家 2 平台'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','fbid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '联盟红包来源商家id'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','ispackage')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0非套餐，1套餐'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','packageoid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `packageoid` int(11) NOT NULL COMMENT '套餐订单ID'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','packageid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `packageid` int(11) NOT NULL COMMENT '套餐ID'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','specdetail')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `specdetail` varchar(50) NOT NULL DEFAULT '0' COMMENT '所选规格详细'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','spec')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `spec` int(11) NOT NULL DEFAULT '0' COMMENT '所选规格'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','commission_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','totalcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','fxmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','csmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '云店佣金'");}
if(!pdo_fieldexists('mzhk_sun_qgorder','goodsprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorder')." ADD   `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品销售价格'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_qgorderlist` (
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

");

if(!pdo_fieldexists('mzhk_sun_qgorderlist','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorderlist')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_qgorderlist','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorderlist')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorderlist','order_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorderlist')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorderlist','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorderlist')." ADD   `openid` varbinary(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorderlist','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorderlist')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorderlist','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorderlist')." ADD   `price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorderlist','createTime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorderlist')." ADD   `createTime` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_qgorderlist','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_qgorderlist')." ADD   `gid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_rebate` (
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

");

if(!pdo_fieldexists('mzhk_sun_rebate','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rebate')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_rebate','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rebate')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_rebate','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rebate')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额'");}
if(!pdo_fieldexists('mzhk_sun_rebate','rebatetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rebate')." ADD   `rebatetype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '返利形式 1 百分比 2 固定金额'");}
if(!pdo_fieldexists('mzhk_sun_rebate','rebatemoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rebate')." ADD   `rebatemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返利金额'");}
if(!pdo_fieldexists('mzhk_sun_rebate','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rebate')." ADD   `type` int(11) NOT NULL DEFAULT '0' COMMENT '订单类型 1普通 2砍价 3拼团 5抢购'");}
if(!pdo_fieldexists('mzhk_sun_rebate','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rebate')." ADD   `oid` int(11) NOT NULL DEFAULT '0' COMMENT '订单id'");}
if(!pdo_fieldexists('mzhk_sun_rebate','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rebate')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_rebate','isdelete')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rebate')." ADD   `isdelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否结算 0 否 1 结算'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_rechargecard` (
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

");

if(!pdo_fieldexists('mzhk_sun_rechargecard','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargecard')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_rechargecard','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargecard')." ADD   `title` varchar(255) NOT NULL COMMENT '给个标题好查看'");}
if(!pdo_fieldexists('mzhk_sun_rechargecard','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargecard')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额'");}
if(!pdo_fieldexists('mzhk_sun_rechargecard','lessmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargecard')." ADD   `lessmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额'");}
if(!pdo_fieldexists('mzhk_sun_rechargecard','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargecard')." ADD   `addtime` int(11) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_rechargecard','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargecard')." ADD   `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0不启用，1启用'");}
if(!pdo_fieldexists('mzhk_sun_rechargecard','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargecard')." ADD   `sort` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_rechargecard','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargecard')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_rechargelogo` (
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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_rechargelogo','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','rc_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `rc_id` int(11) NOT NULL COMMENT '充值卡id'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `uniacid` int(11) NOT NULL COMMENT '应用id'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','addmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `addmoney` decimal(10,2) NOT NULL COMMENT '充值卡赠送的金额'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `addtime` int(11) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','rtype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `rtype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0普通充值，1充值卡，2购买会员，3订单付款，4订单退款,5分销提现，6购买优惠券'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `out_trade_no` varchar(200) NOT NULL COMMENT '外部订单号'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','memo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `memo` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','order_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `order_id` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','returnsign')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `returnsign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买会员赠送标识 0 非赠送 1 赠送'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','viplogid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `viplogid` int(11) NOT NULL DEFAULT '0' COMMENT '会员订单id'");}
if(!pdo_fieldexists('mzhk_sun_rechargelogo','vipid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_rechargelogo')." ADD   `vipid` int(11) NOT NULL DEFAULT '0' COMMENT '会员id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_redpacket_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `rname` varchar(100) NOT NULL COMMENT '�������',
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������',
  `allowmoney` int(11) NOT NULL DEFAULT '0' COMMENT '������Ǯ����',
  `snum` int(11) NOT NULL DEFAULT '0' COMMENT '��������',
  `gnum` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��ȡ���� 0 ֻ����ȡ1�� 1 ÿ�տ���ȡ',
  `rec` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ǰʹ�� 0 �� 1 ��',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��Чʱ�� 0 ������Ч 1 ��ȡ���������Ч',
  `rday` int(11) NOT NULL DEFAULT '1' COMMENT '��ȡ��Ч����',
  `application` tinyint(1) NOT NULL DEFAULT '1' COMMENT '���÷�Χ 1 ͨ�� 2 ������Ʒ 3 �����̼�',
  `sort` int(11) NOT NULL DEFAULT '255' COMMENT '����',
  `addtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '������� 1 ���º�� 2ÿ�պ�� 3�������',
  `sharenum` int(11) NOT NULL DEFAULT '1' COMMENT '���������������',
  `goodsapplication` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�ѱ������Ʒ 0 ������Ʒ�����ѱ� 1 ָ����Ʒ�����ѱ�',
  `umoneytype` int(11) NOT NULL DEFAULT '0' COMMENT '���˺���������� 0 �ٷֱ� 1 �̶����',
  `unionmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���˺���������',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺�������̼�',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_redpacket_goods','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','rname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `rname` varchar(100) NOT NULL COMMENT '�������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','rmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','allowmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `allowmoney` int(11) NOT NULL DEFAULT '0' COMMENT '������Ǯ����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','snum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `snum` int(11) NOT NULL DEFAULT '0' COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','gnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `gnum` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��ȡ���� 0 ֻ����ȡ1�� 1 ÿ�տ���ȡ'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','rec')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `rec` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ǰʹ�� 0 �� 1 ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��Чʱ�� 0 ������Ч 1 ��ȡ���������Ч'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','rday')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `rday` int(11) NOT NULL DEFAULT '1' COMMENT '��ȡ��Ч����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','application')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `application` tinyint(1) NOT NULL DEFAULT '1' COMMENT '���÷�Χ 1 ͨ�� 2 ������Ʒ 3 �����̼�'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `sort` int(11) NOT NULL DEFAULT '255' COMMENT '����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `addtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '������� 1 ���º�� 2ÿ�պ�� 3�������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','sharenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `sharenum` int(11) NOT NULL DEFAULT '1' COMMENT '���������������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','goodsapplication')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `goodsapplication` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�ѱ������Ʒ 0 ������Ʒ�����ѱ� 1 ָ����Ʒ�����ѱ�'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','umoneytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `umoneytype` int(11) NOT NULL DEFAULT '0' COMMENT '���˺���������� 0 �ٷֱ� 1 �̶����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','unionmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `unionmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���˺���������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_goods','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_goods')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺�������̼�'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_redpacket_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `application` int(11) NOT NULL COMMENT '���÷�Χ 0 ͨ�� 1������Ʒ 2  �����̼�',
  `rid` int(11) NOT NULL COMMENT '���id',
  `gid` int(11) NOT NULL COMMENT '������Ʒid',
  `lid` int(50) NOT NULL DEFAULT '0' COMMENT '������Ʒ���ͣ�0���� 12�ο�',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_redpacket_relation','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation','application')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation')." ADD   `application` int(11) NOT NULL COMMENT '���÷�Χ 0 ͨ�� 1������Ʒ 2  �����̼�'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation')." ADD   `rid` int(11) NOT NULL COMMENT '���id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation')." ADD   `gid` int(11) NOT NULL COMMENT '������Ʒid'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation')." ADD   `lid` int(50) NOT NULL DEFAULT '0' COMMENT '������Ʒ���ͣ�0���� 12�ο�'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_redpacket_relation2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `goodsapplication` int(11) NOT NULL COMMENT '�����ѱ���Ʒ��0������Ʒ�����ѱ� 1 ָ����Ʒ�����ѱ�',
  `rid` int(11) NOT NULL COMMENT '���id',
  `gid` int(11) NOT NULL COMMENT '��Ʒid',
  `lid` int(50) NOT NULL DEFAULT '0' COMMENT '������Ʒ���ͣ�0���� 12�ο�',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_redpacket_relation2','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation2')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation2','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation2')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation2','goodsapplication')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation2')." ADD   `goodsapplication` int(11) NOT NULL COMMENT '�����ѱ���Ʒ��0������Ʒ�����ѱ� 1 ָ����Ʒ�����ѱ�'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation2','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation2')." ADD   `rid` int(11) NOT NULL COMMENT '���id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation2','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation2')." ADD   `gid` int(11) NOT NULL COMMENT '��Ʒid'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation2','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation2')." ADD   `lid` int(50) NOT NULL DEFAULT '0' COMMENT '������Ʒ���ͣ�0���� 12�ο�'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_redpacket_relation3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '�����б�id',
  `rid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺��id',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '�����̼�id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_redpacket_relation3','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation3')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation3','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation3')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation3','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation3')." ADD   `uid` int(11) NOT NULL DEFAULT '0' COMMENT '�����б�id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation3','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation3')." ADD   `rid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺��id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_relation3','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_relation3')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '�����̼�id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_redpacket_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `open_redpacket` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ������ 0 �� 1 ��',
  `explain` varchar(100) NOT NULL COMMENT '���˵��',
  `open_redpacket1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ������º�� 0 ������ 1 ����',
  `open_redpacket2` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ���ÿ�պ�� 0 ������ 1 ����',
  `open_redpacket3` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ���������� 0 ������ 1 ����',
  `open_redpacket4` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ������˺�� 0 ������ 1 ����',
  `explain1` text NOT NULL COMMENT '���º�������',
  `explain2` text NOT NULL COMMENT 'ÿ�պ�������',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��������Դ 0 �̼� 1 ƽ̨',
  `usource` tinyint(1) NOT NULL DEFAULT '0' COMMENT '���˺�������Դ 0 �̼� 1 ƽ̨',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_redpacket_set','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','open_redpacket')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `open_redpacket` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ������ 0 �� 1 ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','explain')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `explain` varchar(100) NOT NULL COMMENT '���˵��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','open_redpacket1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `open_redpacket1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ������º�� 0 ������ 1 ����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','open_redpacket2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `open_redpacket2` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ���ÿ�պ�� 0 ������ 1 ����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','open_redpacket3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `open_redpacket3` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ���������� 0 ������ 1 ����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','open_redpacket4')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `open_redpacket4` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ������˺�� 0 ������ 1 ����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','explain1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `explain1` text NOT NULL COMMENT '���º�������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','explain2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `explain2` text NOT NULL COMMENT 'ÿ�պ�������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','source')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��������Դ 0 �̼� 1 ƽ̨'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_set','usource')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_set')." ADD   `usource` tinyint(1) NOT NULL DEFAULT '0' COMMENT '���˺�������Դ 0 �̼� 1 ƽ̨'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_redpacket_union` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL COMMENT '��������',
  `ustime` varchar(50) NOT NULL COMMENT '���ʼʱ��',
  `uetime` varchar(50) NOT NULL COMMENT '�����ʱ��',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '״̬ 0 ���� 1 ��ʾ',
  `sort` int(11) DEFAULT '255' COMMENT '����',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_redpacket_union','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_union')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_redpacket_union','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_union')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_redpacket_union','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_union')." ADD   `uname` varchar(100) NOT NULL COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_union','ustime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_union')." ADD   `ustime` varchar(50) NOT NULL COMMENT '���ʼʱ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_union','uetime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_union')." ADD   `uetime` varchar(50) NOT NULL COMMENT '�����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_union','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_union')." ADD   `status` int(11) NOT NULL DEFAULT '0' COMMENT '״̬ 0 ���� 1 ��ʾ'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_union','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_union')." ADD   `sort` int(11) DEFAULT '255' COMMENT '����'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_redpacket_urelation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL COMMENT '�û�id',
  `uid` int(11) NOT NULL COMMENT '������id',
  `rid` int(11) NOT NULL COMMENT '���id',
  `addtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `gnum` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0ֻ����ȡһ�� 1ÿ�տ���ȡ',
  `oid` int(11) NOT NULL DEFAULT '0' COMMENT '���������������id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_redpacket_urelation','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_urelation')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_redpacket_urelation','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_urelation')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_redpacket_urelation','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_urelation')." ADD   `openid` varchar(100) NOT NULL COMMENT '�û�id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_urelation','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_urelation')." ADD   `uid` int(11) NOT NULL COMMENT '������id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_urelation','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_urelation')." ADD   `rid` int(11) NOT NULL COMMENT '���id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_urelation','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_urelation')." ADD   `addtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_urelation','gnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_urelation')." ADD   `gnum` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0ֻ����ȡһ�� 1ÿ�տ���ȡ'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_urelation','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_urelation')." ADD   `oid` int(11) NOT NULL DEFAULT '0' COMMENT '���������������id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_redpacket_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `rname` varchar(100) NOT NULL COMMENT '�������',
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������',
  `addtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `overtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `allowmoney` int(11) NOT NULL DEFAULT '0' COMMENT '������Ǯ����',
  `gnum` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0������ȡһ�� 1ÿ�տ���ȡ',
  `rid` int(11) NOT NULL DEFAULT '0' COMMENT '���id',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺���̼�id',
  `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺����ȡ��Դ�̼�id',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '�������:1���º�� 2 ÿ�պ�� 3�������',
  `isuse` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ʹ�� 0 δʹ�� 1 ��ʹ��',
  `usetime` varchar(100) NOT NULL COMMENT 'ʹ��ʱ��',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '�û�id',
  `oid` int(11) NOT NULL DEFAULT '0' COMMENT '���������������id',
  `lid` int(11) NOT NULL DEFAULT '0' COMMENT '�������� 1��ͨ 2���� 3ƴ�� 5����',
  `orid` int(11) NOT NULL DEFAULT '0' COMMENT 'ʹ�ú���Ķ���id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '����Ƿ���� 0 ���� 1 ������',
  `umoneytype` int(11) NOT NULL DEFAULT '0' COMMENT '���˺���������� 0 �ٷֱ� 1 �̶����',
  `unionmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���˺���������',
  `unid` int(11) NOT NULL DEFAULT '0' COMMENT '����id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_redpacket_user','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','rname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `rname` varchar(100) NOT NULL COMMENT '�������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','rmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `addtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','overtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `overtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','allowmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `allowmoney` int(11) NOT NULL DEFAULT '0' COMMENT '������Ǯ����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','gnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `gnum` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0������ȡһ�� 1ÿ�տ���ȡ'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `rid` int(11) NOT NULL DEFAULT '0' COMMENT '���id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺���̼�id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','fbid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺����ȡ��Դ�̼�id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '�������:1���º�� 2 ÿ�պ�� 3�������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','isuse')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `isuse` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ʹ�� 0 δʹ�� 1 ��ʹ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','usetime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `usetime` varchar(100) NOT NULL COMMENT 'ʹ��ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `uid` int(11) NOT NULL DEFAULT '0' COMMENT '�û�id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `oid` int(11) NOT NULL DEFAULT '0' COMMENT '���������������id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `lid` int(11) NOT NULL DEFAULT '0' COMMENT '�������� 1��ͨ 2���� 3ƴ�� 5����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','orid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `orid` int(11) NOT NULL DEFAULT '0' COMMENT 'ʹ�ú���Ķ���id'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '����Ƿ���� 0 ���� 1 ������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','umoneytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `umoneytype` int(11) NOT NULL DEFAULT '0' COMMENT '���˺���������� 0 �ٷֱ� 1 �̶����'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','unionmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `unionmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���˺���������'");}
if(!pdo_fieldexists('mzhk_sun_redpacket_user','unid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_redpacket_user')." ADD   `unid` int(11) NOT NULL DEFAULT '0' COMMENT '����id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_sms` (
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

");

if(!pdo_fieldexists('mzhk_sun_sms','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_sms','appkey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `appkey` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_sms','tpl_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `tpl_id` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_sms','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_sms','is_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `is_open` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('mzhk_sun_sms','tid1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `tid1` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_sms','tid2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `tid2` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_sms','tid3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `tid3` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_sms','order_tplid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `order_tplid` int(11) NOT NULL COMMENT '聚合-订单提醒id'");}
if(!pdo_fieldexists('mzhk_sun_sms','order_refund_tplid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `order_refund_tplid` int(11) NOT NULL COMMENT '聚合-订单退款提醒id'");}
if(!pdo_fieldexists('mzhk_sun_sms','smstype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `smstype` tinyint(2) NOT NULL DEFAULT '1' COMMENT '短信类型，1为253，2为聚合'");}
if(!pdo_fieldexists('mzhk_sun_sms','ytx_apiaccount')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `ytx_apiaccount` varchar(50) NOT NULL COMMENT '253短信账号'");}
if(!pdo_fieldexists('mzhk_sun_sms','ytx_apipass')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `ytx_apipass` varchar(50) NOT NULL COMMENT '253短信密码'");}
if(!pdo_fieldexists('mzhk_sun_sms','ytx_apiurl')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `ytx_apiurl` varchar(50) NOT NULL COMMENT '253短信地址'");}
if(!pdo_fieldexists('mzhk_sun_sms','ytx_order')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `ytx_order` varchar(255) NOT NULL COMMENT '云通信订单消息提醒'");}
if(!pdo_fieldexists('mzhk_sun_sms','ytx_orderrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `ytx_orderrefund` varchar(255) NOT NULL COMMENT '云通信退款订单消息提醒'");}
if(!pdo_fieldexists('mzhk_sun_sms','tid4')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `tid4` varchar(50) DEFAULT NULL COMMENT '开奖模板'");}
if(!pdo_fieldexists('mzhk_sun_sms','aly_accesskeyid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `aly_accesskeyid` varchar(255) NOT NULL COMMENT '阿里大鱼 accessKeyId'");}
if(!pdo_fieldexists('mzhk_sun_sms','aly_accesskeysecret')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `aly_accesskeysecret` varchar(255) NOT NULL COMMENT '阿里大鱼 AccessKeySecret'");}
if(!pdo_fieldexists('mzhk_sun_sms','aly_order')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `aly_order` varchar(255) NOT NULL COMMENT '阿里大鱼 订单模板'");}
if(!pdo_fieldexists('mzhk_sun_sms','aly_orderrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `aly_orderrefund` varchar(255) NOT NULL COMMENT '阿里大鱼 退款模板'");}
if(!pdo_fieldexists('mzhk_sun_sms','aly_sign')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `aly_sign` varchar(100) NOT NULL COMMENT '签名'");}
if(!pdo_fieldexists('mzhk_sun_sms','jh_code')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `jh_code` varchar(100) NOT NULL COMMENT '聚合短信验证'");}
if(!pdo_fieldexists('mzhk_sun_sms','dy_code')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `dy_code` varchar(100) NOT NULL COMMENT '大鱼短信验证'");}
if(!pdo_fieldexists('mzhk_sun_sms','xiaoshentui')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `xiaoshentui` varchar(255) NOT NULL COMMENT '小神推'");}
if(!pdo_fieldexists('mzhk_sun_sms','qitui')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `qitui` text NOT NULL COMMENT '奇推信息'");}
if(!pdo_fieldexists('mzhk_sun_sms','tid5')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_sms')." ADD   `tid5` varchar(50) DEFAULT NULL COMMENT '开抢提醒'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_specialtopic` (
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

");

if(!pdo_fieldexists('mzhk_sun_specialtopic','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `title` varchar(255) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `content` text NOT NULL COMMENT '内容'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','seenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `seenum` int(11) NOT NULL COMMENT '查看数量'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','commentnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `commentnum` int(11) NOT NULL COMMENT '评论数量'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `addtime` int(11) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','introduction')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `introduction` varchar(255) NOT NULL COMMENT '简介'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','likenum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `likenum` int(11) NOT NULL COMMENT '点赞数'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `sort` int(5) NOT NULL DEFAULT '255' COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','istop')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶，0不置顶，1置顶'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `img` varchar(255) NOT NULL COMMENT '缩略图片'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `gid` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `bid` int(11) NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','isshow')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1显示，0不显示'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','state')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `state` int(11) NOT NULL DEFAULT '1' COMMENT '列表显示 图片为1，视频为2'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','video_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `video_img` varchar(100) NOT NULL COMMENT '视频封面图'");}
if(!pdo_fieldexists('mzhk_sun_specialtopic','video')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_specialtopic')." ADD   `video` varchar(200) NOT NULL COMMENT '列表视频'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_stlike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `addtime` int(11) NOT NULL COMMENT '点赞时间',
  `stid` int(11) NOT NULL COMMENT '专题id',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_stlike','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_stlike')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_stlike','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_stlike')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_stlike','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_stlike')." ADD   `addtime` int(11) NOT NULL COMMENT '点赞时间'");}
if(!pdo_fieldexists('mzhk_sun_stlike','stid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_stlike')." ADD   `stid` int(11) NOT NULL COMMENT '专题id'");}
if(!pdo_fieldexists('mzhk_sun_stlike','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_stlike')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_storecate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL COMMENT '店铺分类名称',
  `store_img` varchar(200) NOT NULL COMMENT '店铺分类图',
  `sort` int(5) NOT NULL COMMENT '排序',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_storecate','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storecate')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_storecate','store_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storecate')." ADD   `store_name` varchar(255) NOT NULL COMMENT '店铺分类名称'");}
if(!pdo_fieldexists('mzhk_sun_storecate','store_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storecate')." ADD   `store_img` varchar(200) NOT NULL COMMENT '店铺分类图'");}
if(!pdo_fieldexists('mzhk_sun_storecate','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storecate')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_storecate','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storecate')." ADD   `addtime` int(11) NOT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('mzhk_sun_storecate','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storecate')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_storefacility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(50) NOT NULL COMMENT '设施名称',
  `selectedimg` varchar(200) NOT NULL COMMENT '选中图',
  `unselectedimg` varchar(200) NOT NULL COMMENT '未选中图',
  `sort` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_storefacility','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storefacility')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_storefacility','facilityname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storefacility')." ADD   `facilityname` varchar(50) NOT NULL COMMENT '设施名称'");}
if(!pdo_fieldexists('mzhk_sun_storefacility','selectedimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storefacility')." ADD   `selectedimg` varchar(200) NOT NULL COMMENT '选中图'");}
if(!pdo_fieldexists('mzhk_sun_storefacility','unselectedimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storefacility')." ADD   `unselectedimg` varchar(200) NOT NULL COMMENT '未选中图'");}
if(!pdo_fieldexists('mzhk_sun_storefacility','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storefacility')." ADD   `sort` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_storefacility','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storefacility')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_storelimit` (
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_storelimit','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_storelimit','lt_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `lt_id` int(11) NOT NULL DEFAULT '0' COMMENT '入驻期限类别id'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','lt_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `lt_name` varchar(30) NOT NULL COMMENT '入驻期限类别名称'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','lt_day')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `lt_day` int(5) NOT NULL COMMENT '入驻期限类别天数'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `uniacid` int(11) NOT NULL COMMENT '应用id'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '入驻价格'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','distribution_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','distribution_commissiontype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1百分比，2固定金额'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','secondmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('mzhk_sun_storelimit','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimit')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_storelimittype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lt_name` varchar(50) NOT NULL COMMENT '期限名',
  `lt_day` int(5) NOT NULL COMMENT '期限天数',
  `uniacid` int(11) NOT NULL COMMENT '应用id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_storelimittype','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimittype')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_storelimittype','lt_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimittype')." ADD   `lt_name` varchar(50) NOT NULL COMMENT '期限名'");}
if(!pdo_fieldexists('mzhk_sun_storelimittype','lt_day')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimittype')." ADD   `lt_day` int(5) NOT NULL COMMENT '期限天数'");}
if(!pdo_fieldexists('mzhk_sun_storelimittype','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_storelimittype')." ADD   `uniacid` int(11) NOT NULL COMMENT '应用id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_subcard_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `gname` varchar(100) NOT NULL COMMENT '�ο�����',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '�����̼�',
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '��������',
  `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'ԭ��',
  `subcardprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�ּ�',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '���',
  `virtualnum` int(11) NOT NULL DEFAULT '0' COMMENT '��������',
  `stocktype` int(11) NOT NULL DEFAULT '0' COMMENT '��������ʽ 0 �µ������ 1 ��������',
  `canrefund` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ�����˿� 0 ���˿� 1 �����˿�',
  `limitnum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ���޹���',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '��ҳ�Ƽ� 0 ���Ƽ� 1 �Ƽ�',
  `is_vip` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ��Ա��Ʒ 0 ���� 1 ��',
  `vipprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ա�۸�',
  `astime` varchar(100) NOT NULL COMMENT '��ʼʱ��',
  `antime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `expirationtime` varchar(100) NOT NULL COMMENT '��������ʱ��',
  `sort` int(11) NOT NULL DEFAULT '255' COMMENT '����',
  `index_img` varchar(100) NOT NULL COMMENT '��ҳ���1�ͻ�Ƽ�չʾͼ',
  `pic` varchar(100) NOT NULL COMMENT '��ҳ���2�����Ʒ�б�ҳ���̼�����ҳչʾͼ',
  `index3_img` varchar(100) NOT NULL COMMENT '��ҳ���3չʾͼ',
  `content` text NOT NULL COMMENT '��������',
  `daynum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ�տɺ�����',
  `monthnum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ�¿ɺ�����',
  `minnum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ�����ٺ�����',
  `maxnum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ����������',
  `months` int(11) NOT NULL DEFAULT '0' COMMENT '�Զ���������',
  `writenums` int(11) NOT NULL DEFAULT '0' COMMENT '�Զ���������',
  `firstwnums` int(11) NOT NULL DEFAULT '0' COMMENT '�״οɺ�����',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '״̬ 0 ���� 1 ��ʾ',
  `addtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `lb_imgs` varchar(200) NOT NULL COMMENT '�����ֲ�ͼ',
  `buynum` int(11) NOT NULL DEFAULT '0' COMMENT '������Ʒ��',
  `pnums` int(11) NOT NULL DEFAULT '0' COMMENT '��Ʒ˵����Ŀ',
  `pname` varchar(50) NOT NULL COMMENT '��Ʒ˵������',
  `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0����������������1����',
  `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1�ٷֱȣ�2�̶����',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'һ��Ӷ��',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����Ӷ��',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����Ӷ��',
  `gcateid` int(11) NOT NULL DEFAULT '0' COMMENT '�������id',
  `lid` int(11) NOT NULL DEFAULT '12' COMMENT '��Ʒ����',
  `reccloud` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ��Ƽ����Ƶ� 0���Ƽ� 1�Ƽ�',
  `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ӷ��',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_subcard_goods','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `gname` varchar(100) NOT NULL COMMENT '�ο�����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '�����̼�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','cateid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','originalprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'ԭ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','subcardprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `subcardprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�ּ�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '���'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','virtualnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `virtualnum` int(11) NOT NULL DEFAULT '0' COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','stocktype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `stocktype` int(11) NOT NULL DEFAULT '0' COMMENT '��������ʽ 0 �µ������ 1 ��������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','canrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `canrefund` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ�����˿� 0 ���˿� 1 �����˿�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','limitnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `limitnum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ���޹���'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','tid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `tid` int(11) NOT NULL DEFAULT '0' COMMENT '��ҳ�Ƽ� 0 ���Ƽ� 1 �Ƽ�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','is_vip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `is_vip` int(11) NOT NULL DEFAULT '0' COMMENT '�Ƿ��Ա��Ʒ 0 ���� 1 ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','vipprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `vipprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ա�۸�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','astime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `astime` varchar(100) NOT NULL COMMENT '��ʼʱ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','antime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `antime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `expirationtime` varchar(100) NOT NULL COMMENT '��������ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `sort` int(11) NOT NULL DEFAULT '255' COMMENT '����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','index_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `index_img` varchar(100) NOT NULL COMMENT '��ҳ���1�ͻ�Ƽ�չʾͼ'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `pic` varchar(100) NOT NULL COMMENT '��ҳ���2�����Ʒ�б�ҳ���̼�����ҳչʾͼ'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','index3_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `index3_img` varchar(100) NOT NULL COMMENT '��ҳ���3չʾͼ'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `content` text NOT NULL COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','daynum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `daynum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ�տɺ�����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','monthnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `monthnum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ�¿ɺ�����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','minnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `minnum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ�����ٺ�����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','maxnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `maxnum` int(11) NOT NULL DEFAULT '0' COMMENT 'ÿ����������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','months')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `months` int(11) NOT NULL DEFAULT '0' COMMENT '�Զ���������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','writenums')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `writenums` int(11) NOT NULL DEFAULT '0' COMMENT '�Զ���������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','firstwnums')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `firstwnums` int(11) NOT NULL DEFAULT '0' COMMENT '�״οɺ�����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `status` int(11) NOT NULL DEFAULT '1' COMMENT '״̬ 0 ���� 1 ��ʾ'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `addtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `lb_imgs` varchar(200) NOT NULL COMMENT '�����ֲ�ͼ'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','buynum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `buynum` int(11) NOT NULL DEFAULT '0' COMMENT '������Ʒ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','pnums')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `pnums` int(11) NOT NULL DEFAULT '0' COMMENT '��Ʒ˵����Ŀ'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','pname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `pname` varchar(50) NOT NULL COMMENT '��Ʒ˵������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','distribution_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0����������������1����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','distribution_commissiontype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1�ٷֱȣ�2�̶����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'һ��Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','secondmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','gcateid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `gcateid` int(11) NOT NULL DEFAULT '0' COMMENT '�������id'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `lid` int(11) NOT NULL DEFAULT '12' COMMENT '��Ʒ����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','reccloud')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `reccloud` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ��Ƽ����Ƶ� 0���Ƽ� 1�Ƽ�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_goods','totalcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_goods')." ADD   `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ӷ��'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_subcard_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `ordernum` varchar(100) NOT NULL COMMENT '������',
  `telnumber` varchar(50) NOT NULL COMMENT '�û��绰',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�������',
  `status` int(11) NOT NULL DEFAULT '2' COMMENT '1 ȡ��������2��֧����3��������4��֧����5�����',
  `openid` varchar(100) NOT NULL COMMENT '�û�openid',
  `addtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '��Ʒid',
  `gname` varchar(200) NOT NULL COMMENT '��Ʒ����',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '��������',
  `goodsimg` varchar(100) NOT NULL COMMENT '��Ʒ����ͼ',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '�����̼�id',
  `expirationtime` varchar(100) NOT NULL COMMENT '��������ʱ��',
  `paytype` varchar(100) NOT NULL COMMENT '֧����ʽ 1 ΢��֧�� 2 ���֧��',
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '��������id',
  `paytime` varchar(100) NOT NULL COMMENT '����ʱ��',
  `out_trade_no` varchar(100) NOT NULL COMMENT '֧���ⲿ������',
  `out_refund_no` varchar(100) NOT NULL COMMENT '�˿��ⲿ������',
  `isrefund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0������1�����˿2���˿3�ܾ��˿�',
  `haswrittenoffnum` int(11) NOT NULL DEFAULT '0' COMMENT '�Ѻ�����',
  `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ʹ���̼����̻����տ0δ���ã�1����',
  `sub_mch_id` varchar(255) NOT NULL COMMENT '���̻���id',
  `subcardprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ʒ�۸�',
  `vipprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ա�۸�',
  `pnums` int(11) NOT NULL DEFAULT '0' COMMENT '��Ʒ˵����Ŀ',
  `finishtime` varchar(100) NOT NULL COMMENT '���ʱ��',
  `bname` varchar(100) NOT NULL COMMENT '�̼�����',
  `uremark` varchar(100) NOT NULL COMMENT '��ע',
  `parent_id_1` int(11) NOT NULL COMMENT 'һ��id',
  `parent_id_2` int(11) NOT NULL COMMENT '����id',
  `parent_id_3` int(11) NOT NULL COMMENT '����id',
  `rid` int(11) NOT NULL DEFAULT '0' COMMENT '���id',
  `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'ʹ�ú�����',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��������Դ 0 ����֧�� 1 �̼� 2 ƽ̨',
  `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺����Դ�̼�id',
  `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0���ײͣ�1�ײ�',
  `packageoid` int(11) NOT NULL COMMENT '�ײͶ���ID',
  `packageid` int(11) NOT NULL COMMENT '�ײ�ID',
  `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Ӷ������ 0ʹ�ö������ 1��Ӷ��',
  `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ӷ��',
  `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����Ӷ��',
  `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�Ƶ�Ӷ��',
  `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ʒ���ۼ۸�',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_subcard_order','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','ordernum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `ordernum` varchar(100) NOT NULL COMMENT '������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','telnumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `telnumber` varchar(50) NOT NULL COMMENT '�û��绰'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `status` int(11) NOT NULL DEFAULT '2' COMMENT '1 ȡ��������2��֧����3��������4��֧����5�����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `openid` varchar(100) NOT NULL COMMENT '�û�openid'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `addtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '��Ʒid'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `gname` varchar(200) NOT NULL COMMENT '��Ʒ����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','goodsimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `goodsimg` varchar(100) NOT NULL COMMENT '��Ʒ����ͼ'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '�����̼�id'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','expirationtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `expirationtime` varchar(100) NOT NULL COMMENT '��������ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `paytype` varchar(100) NOT NULL COMMENT '֧����ʽ 1 ΢��֧�� 2 ���֧��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','cateid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '��������id'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `paytime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `out_trade_no` varchar(100) NOT NULL COMMENT '֧���ⲿ������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `out_refund_no` varchar(100) NOT NULL COMMENT '�˿��ⲿ������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','isrefund')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `isrefund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0������1�����˿2���˿3�ܾ��˿�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','haswrittenoffnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `haswrittenoffnum` int(11) NOT NULL DEFAULT '0' COMMENT '�Ѻ�����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ʹ���̼����̻����տ0δ���ã�1����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `sub_mch_id` varchar(255) NOT NULL COMMENT '���̻���id'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','subcardprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `subcardprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ʒ�۸�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','vipprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `vipprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ա�۸�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','pnums')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `pnums` int(11) NOT NULL DEFAULT '0' COMMENT '��Ʒ˵����Ŀ'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `finishtime` varchar(100) NOT NULL COMMENT '���ʱ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `bname` varchar(100) NOT NULL COMMENT '�̼�����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','uremark')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `uremark` varchar(100) NOT NULL COMMENT '��ע'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `parent_id_1` int(11) NOT NULL COMMENT 'һ��id'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '����id'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '����id'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','rid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `rid` int(11) NOT NULL DEFAULT '0' COMMENT '���id'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','rmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `rmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'ʹ�ú�����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','source')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��������Դ 0 ����֧�� 1 �̼� 2 ƽ̨'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','fbid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `fbid` int(11) NOT NULL DEFAULT '0' COMMENT '���˺����Դ�̼�id'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','ispackage')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `ispackage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0���ײͣ�1�ײ�'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','packageoid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `packageoid` int(11) NOT NULL COMMENT '�ײͶ���ID'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','packageid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `packageid` int(11) NOT NULL COMMENT '�ײ�ID'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','commission_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Ӷ������ 0ʹ�ö������ 1��Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','totalcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','fxmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '����Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','csmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `csmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '�Ƶ�Ӷ��'");}
if(!pdo_fieldexists('mzhk_sun_subcard_order','goodsprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_order')." ADD   `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��Ʒ���ۼ۸�'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_subcard_scate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `scatename` varchar(100) NOT NULL COMMENT '��������',
  `sort` int(11) NOT NULL DEFAULT '255' COMMENT '����',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '״̬ 0 ���� 1 ��ʾ',
  `addtime` varchar(100) NOT NULL COMMENT '����ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_subcard_scate','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_scate')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_subcard_scate','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_scate')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_subcard_scate','scatename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_scate')." ADD   `scatename` varchar(100) NOT NULL COMMENT '��������'");}
if(!pdo_fieldexists('mzhk_sun_subcard_scate','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_scate')." ADD   `sort` int(11) NOT NULL DEFAULT '255' COMMENT '����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_scate','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_scate')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '״̬ 0 ���� 1 ��ʾ'");}
if(!pdo_fieldexists('mzhk_sun_subcard_scate','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_scate')." ADD   `addtime` varchar(100) NOT NULL COMMENT '����ʱ��'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_subcard_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `opensubcard` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ����ο���� 0 ������ 1 ����',
  `listimgs` text NOT NULL COMMENT '�ο��б��ֲ�ͼ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_subcard_set','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_subcard_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_set')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_subcard_set','opensubcard')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_set')." ADD   `opensubcard` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ����ο���� 0 ������ 1 ����'");}
if(!pdo_fieldexists('mzhk_sun_subcard_set','listimgs')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_subcard_set')." ADD   `listimgs` text NOT NULL COMMENT '�ο��б��ֲ�ͼ'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_system` (
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
  `myrztext` varchar(50) NOT NULL COMMENT '云店入驻文字',
  `mygltext` varchar(50) NOT NULL COMMENT '云店入驻文字',
  `mycdtext` varchar(50) NOT NULL COMMENT '云店入驻文字',
  `myrzicon` varchar(100) NOT NULL COMMENT '云店入驻图标',
  `myglicon` varchar(50) NOT NULL COMMENT '云店入驻文字',
  `mycdicon` varchar(50) NOT NULL COMMENT '云店入驻文字',
  `is_counp` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商家单独开启优惠券：1开启，2不开启',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_system','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('mzhk_sun_system','appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `appid` varchar(100) DEFAULT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('mzhk_sun_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `appsecret` varchar(200) DEFAULT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('mzhk_sun_system','mchid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mchid` varchar(100) DEFAULT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('mzhk_sun_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `wxkey` varchar(250) DEFAULT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('mzhk_sun_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','url_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `url_name` varchar(20) DEFAULT NULL COMMENT '网址名称'");}
if(!pdo_fieldexists('mzhk_sun_system','details')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `details` text COMMENT '关于我们'");}
if(!pdo_fieldexists('mzhk_sun_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `url_logo` varchar(100) DEFAULT NULL COMMENT '网址logo'");}
if(!pdo_fieldexists('mzhk_sun_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `bq_name` varchar(50) DEFAULT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('mzhk_sun_system','link_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `link_name` varchar(30) DEFAULT NULL COMMENT '网站名称'");}
if(!pdo_fieldexists('mzhk_sun_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `link_logo` varchar(100) DEFAULT NULL COMMENT '网站logo'");}
if(!pdo_fieldexists('mzhk_sun_system','support')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `support` varchar(20) DEFAULT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('mzhk_sun_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `bq_logo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','color')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `color` varchar(20) DEFAULT NULL COMMENT '颜色'");}
if(!pdo_fieldexists('mzhk_sun_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `tz_appid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `tz_name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','pt_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `pt_name` varchar(100) DEFAULT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('mzhk_sun_system','tz_audit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `tz_audit` int(11) DEFAULT NULL COMMENT '帖子审核1.是 2否'");}
if(!pdo_fieldexists('mzhk_sun_system','sj_audit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `sj_audit` int(11) DEFAULT NULL COMMENT '商家审核1.是 2否'");}
if(!pdo_fieldexists('mzhk_sun_system','cityname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `cityname` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','mail')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mail` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','address')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','tel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `tel` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `pic` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `client_ip` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `apiclient_key` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `apiclient_cert` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `fontcolor` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','ptnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `ptnum` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','hk_logo')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `hk_logo` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','hk_tubiao')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `hk_tubiao` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_system','store_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `store_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1开启，0关闭，默认开启'");}
if(!pdo_fieldexists('mzhk_sun_system','store_in_notice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `store_in_notice` text NOT NULL COMMENT '商家入驻须知'");}
if(!pdo_fieldexists('mzhk_sun_system','tech_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `tech_title` varchar(50) NOT NULL COMMENT '技术支持名称'");}
if(!pdo_fieldexists('mzhk_sun_system','tech_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `tech_img` varchar(100) NOT NULL COMMENT '技术支持logo'");}
if(!pdo_fieldexists('mzhk_sun_system','tech_phone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `tech_phone` varchar(50) NOT NULL COMMENT '技术支持电话'");}
if(!pdo_fieldexists('mzhk_sun_system','is_show_tech')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `is_show_tech` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不显示，1显示'");}
if(!pdo_fieldexists('mzhk_sun_system','is_open_pop')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `is_open_pop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0关闭首页弹窗，1开启首页弹窗'");}
if(!pdo_fieldexists('mzhk_sun_system','hk_bgimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `hk_bgimg` varchar(100) DEFAULT NULL COMMENT '黑卡背景图'");}
if(!pdo_fieldexists('mzhk_sun_system','hk_namecolor')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `hk_namecolor` varchar(20) DEFAULT NULL COMMENT '黑卡名称颜色'");}
if(!pdo_fieldexists('mzhk_sun_system','showcheck')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `showcheck` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1过审页面，0正常页面'");}
if(!pdo_fieldexists('mzhk_sun_system','wxappletscode')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `wxappletscode` varchar(200) NOT NULL COMMENT '小程序码'");}
if(!pdo_fieldexists('mzhk_sun_system','tab_navdata')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `tab_navdata` text NOT NULL COMMENT '底部菜单数据'");}
if(!pdo_fieldexists('mzhk_sun_system','hk_userrules')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `hk_userrules` text NOT NULL COMMENT '黑卡会员规则'");}
if(!pdo_fieldexists('mzhk_sun_system','version')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `version` varchar(30) NOT NULL COMMENT '小程序版本号'");}
if(!pdo_fieldexists('mzhk_sun_system','wg_title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `wg_title` varchar(255) DEFAULT NULL COMMENT '福利群标题'");}
if(!pdo_fieldexists('mzhk_sun_system','wg_directions')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `wg_directions` varchar(255) DEFAULT NULL COMMENT '福利群说明'");}
if(!pdo_fieldexists('mzhk_sun_system','wg_img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `wg_img` varchar(255) DEFAULT NULL COMMENT '福利群图标'");}
if(!pdo_fieldexists('mzhk_sun_system','wg_keyword')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `wg_keyword` varchar(255) DEFAULT NULL COMMENT '福利群加群关键字'");}
if(!pdo_fieldexists('mzhk_sun_system','showgw')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `showgw` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否显示，0不显示，1显示'");}
if(!pdo_fieldexists('mzhk_sun_system','wg_addicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `wg_addicon` varchar(255) DEFAULT NULL COMMENT '福利群加群关键字'");}
if(!pdo_fieldexists('mzhk_sun_system','is_open_circle')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `is_open_circle` tinyint(1) NOT NULL DEFAULT '0' COMMENT '圈子0不审核，1审核'");}
if(!pdo_fieldexists('mzhk_sun_system','hometheme')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `hometheme` tinyint(5) NOT NULL DEFAULT '0' COMMENT '首页主题'");}
if(!pdo_fieldexists('mzhk_sun_system','is_homeshow_circle')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `is_homeshow_circle` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否在首页显示，1显示，0不显示'");}
if(!pdo_fieldexists('mzhk_sun_system','offlinefee')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `offlinefee` float NOT NULL DEFAULT '0' COMMENT '线下付款手续费'");}
if(!pdo_fieldexists('mzhk_sun_system','home_circle_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `home_circle_name` varchar(255) NOT NULL DEFAULT '晒单啦' COMMENT '风格2首页显示晒单内容'");}
if(!pdo_fieldexists('mzhk_sun_system','store_in_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `store_in_name` varchar(255) NOT NULL DEFAULT '商家入驻' COMMENT '商家入驻名'");}
if(!pdo_fieldexists('mzhk_sun_system','hk_mytitle')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `hk_mytitle` varchar(255) NOT NULL COMMENT '我的页面黑卡营销标题（我的页面风格2）'");}
if(!pdo_fieldexists('mzhk_sun_system','hk_mybgimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `hk_mybgimg` varchar(255) NOT NULL COMMENT '我的页面黑卡背景图（我的页面风格2）'");}
if(!pdo_fieldexists('mzhk_sun_system','mytheme')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mytheme` tinyint(5) NOT NULL DEFAULT '0' COMMENT '我的页面主题设置'");}
if(!pdo_fieldexists('mzhk_sun_system','loginimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `loginimg` varchar(255) NOT NULL COMMENT '商家后台登陆logo'");}
if(!pdo_fieldexists('mzhk_sun_system','isopen_recharge')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `isopen_recharge` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0关闭，1开启'");}
if(!pdo_fieldexists('mzhk_sun_system','isany_money_recharge')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `isany_money_recharge` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0关闭，1开启'");}
if(!pdo_fieldexists('mzhk_sun_system','showorderset')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `showorderset` text NOT NULL COMMENT '展示订单设置'");}
if(!pdo_fieldexists('mzhk_sun_system','openblackcard')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `openblackcard` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启黑卡，1开启，0不开启'");}
if(!pdo_fieldexists('mzhk_sun_system','developkey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `developkey` varchar(100) NOT NULL COMMENT '腾讯地图key'");}
if(!pdo_fieldexists('mzhk_sun_system','openaddress')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `openaddress` int(10) NOT NULL DEFAULT '0' COMMENT '是否开启区域 0 否  1 是'");}
if(!pdo_fieldexists('mzhk_sun_system','opencity')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `opencity` int(10) NOT NULL DEFAULT '0' COMMENT '是否定位到市 0 否  1 是'");}
if(!pdo_fieldexists('mzhk_sun_system','opentel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `opentel` int(10) NOT NULL DEFAULT '0' COMMENT '是否开启手机号码授权 0 否  1 是'");}
if(!pdo_fieldexists('mzhk_sun_system','code_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `code_type` int(11) NOT NULL DEFAULT '0' COMMENT '获取抽奖码方式 0 不开启 1 分享点击获取 2 分享购买获取'");}
if(!pdo_fieldexists('mzhk_sun_system','open_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `open_num` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启每日砍价次数 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_system','day_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `day_num` int(11) NOT NULL DEFAULT '0' COMMENT '每日砍价次数'");}
if(!pdo_fieldexists('mzhk_sun_system','open_friend')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `open_friend` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启每日帮同一好友砍价次数 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_system','friend_num')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `friend_num` int(11) NOT NULL DEFAULT '0' COMMENT '帮同一好友砍价次数'");}
if(!pdo_fieldexists('mzhk_sun_system','money_rate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `money_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认支付金额比例'");}
if(!pdo_fieldexists('mzhk_sun_system','score_rate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `score_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认兑换积分比例'");}
if(!pdo_fieldexists('mzhk_sun_system','goodspicbg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `goodspicbg` varchar(100) NOT NULL COMMENT '商品海报背景图'");}
if(!pdo_fieldexists('mzhk_sun_system','buyvipset')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `buyvipset` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启微信支付到余额 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_system','isbusiness')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `isbusiness` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示工商信息 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_system','license')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `license` text NOT NULL COMMENT '营业执照'");}
if(!pdo_fieldexists('mzhk_sun_system','icplicense')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `icplicense` text NOT NULL COMMENT 'ICP许可证'");}
if(!pdo_fieldexists('mzhk_sun_system','agreement')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `agreement` text NOT NULL COMMENT '服务协议'");}
if(!pdo_fieldexists('mzhk_sun_system','policy')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `policy` text NOT NULL COMMENT '隐私政策'");}
if(!pdo_fieldexists('mzhk_sun_system','wxcode_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `wxcode_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商家收款启用小程序码 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_system','allow_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `allow_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许商家自己开启关店和打烊'");}
if(!pdo_fieldexists('mzhk_sun_system','firstorder_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `firstorder_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启首购减 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_system','firstorder')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `firstorder` tinyint(1) NOT NULL DEFAULT '1' COMMENT '首购减类型 1 百分比 2 固定金额'");}
if(!pdo_fieldexists('mzhk_sun_system','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首购减金额'");}
if(!pdo_fieldexists('mzhk_sun_system','rebate_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `rebate_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启商家返利 0否 1是'");}
if(!pdo_fieldexists('mzhk_sun_system','rebatetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `rebatetype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '返利类型 1百分比 2固定金额'");}
if(!pdo_fieldexists('mzhk_sun_system','rebatemoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `rebatemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返利金额'");}
if(!pdo_fieldexists('mzhk_sun_system','ordernum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `ordernum` int(11) NOT NULL DEFAULT '0' COMMENT '多少单后开始返利'");}
if(!pdo_fieldexists('mzhk_sun_system','grebate_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `grebate_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商品参与返利 0 部分商品 1 全部商品'");}
if(!pdo_fieldexists('mzhk_sun_system','open_payment')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `open_payment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用线下付 0 关闭 1启用'");}
if(!pdo_fieldexists('mzhk_sun_system','myicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myicon` varchar(100) NOT NULL COMMENT '普通订单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mypticon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mypticon` varchar(100) NOT NULL COMMENT '我的拼团图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mykjicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mykjicon` varchar(100) NOT NULL COMMENT '砍价订单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myjkicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myjkicon` varchar(100) NOT NULL COMMENT '集卡订单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myqgicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myqgicon` varchar(100) NOT NULL COMMENT '抢购订单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mymdicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mymdicon` varchar(100) NOT NULL COMMENT '我的免单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myyhqicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myyhqicon` varchar(100) NOT NULL COMMENT '我的优惠券图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mycticon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycticon` varchar(100) NOT NULL COMMENT '我的吃探图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myfxicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myfxicon` varchar(100) NOT NULL COMMENT '分销中心图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myjficon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myjficon` varchar(100) NOT NULL COMMENT '积分任务图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mylbqicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mylbqicon` varchar(100) NOT NULL COMMENT '裂变券图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myhbicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myhbicon` varchar(100) NOT NULL COMMENT '福袋图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myckicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myckicon` varchar(100) NOT NULL COMMENT '次卡图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myckicon2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myckicon2` varchar(100) NOT NULL COMMENT '次卡订单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myqyicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myqyicon` varchar(100) NOT NULL COMMENT '权益图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myqyicon2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myqyicon2` varchar(100) NOT NULL COMMENT '权益订单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mytcicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mytcicon` varchar(100) NOT NULL COMMENT '套餐图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mytcicon2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mytcicon2` varchar(100) NOT NULL COMMENT '套餐订单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mycjicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycjicon` varchar(100) NOT NULL COMMENT '抽奖图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mycjicon2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycjicon2` varchar(100) NOT NULL COMMENT '抽奖订单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','mypsicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mypsicon` varchar(100) NOT NULL COMMENT '配送订单图标'");}
if(!pdo_fieldexists('mzhk_sun_system','subheading')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `subheading` varchar(100) NOT NULL COMMENT '主题4首页副标题'");}
if(!pdo_fieldexists('mzhk_sun_system','topbg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `topbg` varchar(20) NOT NULL COMMENT '主题4顶部背景色'");}
if(!pdo_fieldexists('mzhk_sun_system','mytext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mytext` varchar(50) NOT NULL COMMENT '普通订单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mypttext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mypttext` varchar(50) NOT NULL COMMENT '我的拼团文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mykjtext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mykjtext` varchar(50) NOT NULL COMMENT '砍价订单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','myjktext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myjktext` varchar(50) NOT NULL COMMENT '集卡订单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','myqgtext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myqgtext` varchar(50) NOT NULL COMMENT '抢购订单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mymdtext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mymdtext` varchar(50) NOT NULL COMMENT '我的免单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','myyhqtext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myyhqtext` varchar(50) NOT NULL COMMENT '我的优惠券文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mycttext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycttext` varchar(50) NOT NULL COMMENT '我的吃探文字'");}
if(!pdo_fieldexists('mzhk_sun_system','myfxtext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myfxtext` varchar(50) NOT NULL COMMENT '分销中心文字'");}
if(!pdo_fieldexists('mzhk_sun_system','myjftext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myjftext` varchar(50) NOT NULL COMMENT '积分任务文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mylbqtext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mylbqtext` varchar(50) NOT NULL COMMENT '裂变券文字'");}
if(!pdo_fieldexists('mzhk_sun_system','myhbtext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myhbtext` varchar(50) NOT NULL COMMENT '福袋文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mycktext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycktext` varchar(50) NOT NULL COMMENT '次卡文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mycktext2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycktext2` varchar(50) NOT NULL COMMENT '次卡订单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','myqytext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myqytext` varchar(50) NOT NULL COMMENT '权益文字'");}
if(!pdo_fieldexists('mzhk_sun_system','myqytext2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myqytext2` varchar(50) NOT NULL COMMENT '权益订单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mytctext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mytctext` varchar(50) NOT NULL COMMENT '套餐文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mytctext2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mytctext2` varchar(50) NOT NULL COMMENT '套餐订单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mycjtext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycjtext` varchar(50) NOT NULL COMMENT '抽奖文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mycjtext2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycjtext2` varchar(50) NOT NULL COMMENT '抽奖订单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mypstext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mypstext` varchar(50) NOT NULL COMMENT '配送订单文字'");}
if(!pdo_fieldexists('mzhk_sun_system','openvirtual')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `openvirtual` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启虚拟数 0 不开启 1 开启'");}
if(!pdo_fieldexists('mzhk_sun_system','snum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `snum` int(11) NOT NULL DEFAULT '0' COMMENT '满多少星级显示'");}
if(!pdo_fieldexists('mzhk_sun_system','hk_mytopimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `hk_mytopimg` varchar(255) NOT NULL COMMENT '我的页面顶部背景图（我的页面风格2）'");}
if(!pdo_fieldexists('mzhk_sun_system','opennotice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `opennotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '主题3专题标题显示，1开启，0不开启'");}
if(!pdo_fieldexists('mzhk_sun_system','opennotime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `opennotime` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示时间未开始商品 0 关闭 1 开启'");}
if(!pdo_fieldexists('mzhk_sun_system','ispnumber')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `ispnumber` tinyint(1) NOT NULL DEFAULT '0' COMMENT '海报小程序码是否使用公众号二维码 0否，1是'");}
if(!pdo_fieldexists('mzhk_sun_system','opensearch')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `opensearch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '主题4首页是否显示搜索栏'");}
if(!pdo_fieldexists('mzhk_sun_system','openrelease')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `openrelease` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许商家自己发布商品 0 不允许 1 允许'");}
if(!pdo_fieldexists('mzhk_sun_system','openexamine')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `openexamine` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商家自己发布商品是否需要审核 0 不审核 1 审核'");}
if(!pdo_fieldexists('mzhk_sun_system','is_show_tel')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `is_show_tel` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示技术支持电话'");}
if(!pdo_fieldexists('mzhk_sun_system','writeofftype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `writeofftype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '核销时间类型 0 固定 1 动态'");}
if(!pdo_fieldexists('mzhk_sun_system','myzsicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myzsicon` varchar(100) NOT NULL COMMENT '我的赠送图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myzstext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myzstext` varchar(50) NOT NULL COMMENT '我的赠送文字'");}
if(!pdo_fieldexists('mzhk_sun_system','is_delivery')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `is_delivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用配送 0 关闭 1启用'");}
if(!pdo_fieldexists('mzhk_sun_system','cappid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `cappid` varchar(100) NOT NULL COMMENT '挚能云appid'");}
if(!pdo_fieldexists('mzhk_sun_system','cappsecret')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `cappsecret` varchar(100) NOT NULL COMMENT '挚能云appsecret'");}
if(!pdo_fieldexists('mzhk_sun_system','vipbcolor')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `vipbcolor` varchar(50) NOT NULL COMMENT '购买会员页顶部背景色'");}
if(!pdo_fieldexists('mzhk_sun_system','vip_bimg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `vip_bimg` varchar(100) NOT NULL COMMENT '购买会员页顶部背景图'");}
if(!pdo_fieldexists('mzhk_sun_system','opennavtype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `opennavtype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '首页顶部导航显示 0单行 1多行'");}
if(!pdo_fieldexists('mzhk_sun_system','catetopbg')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `catetopbg` varchar(50) NOT NULL COMMENT '分类页颜色'");}
if(!pdo_fieldexists('mzhk_sun_system','server_appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `server_appid` varchar(255) NOT NULL COMMENT '微信分配的公众账号ID'");}
if(!pdo_fieldexists('mzhk_sun_system','server_sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `server_sub_mch_id` varchar(100) NOT NULL COMMENT '微信支付分配的子商户号'");}
if(!pdo_fieldexists('mzhk_sun_system','is_open_server')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `is_open_server` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启服务商角色，1开启，0不开启'");}
if(!pdo_fieldexists('mzhk_sun_system','is_open_server_submch')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `is_open_server_submch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '启用商家子商户号，0不启用，1启用'");}
if(!pdo_fieldexists('mzhk_sun_system','server_apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `server_apiclient_cert` varchar(200) NOT NULL COMMENT '服务商证书'");}
if(!pdo_fieldexists('mzhk_sun_system','server_apiclient_key')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `server_apiclient_key` varchar(200) NOT NULL COMMENT '服务商证书key'");}
if(!pdo_fieldexists('mzhk_sun_system','server_mchid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `server_mchid` varchar(100) NOT NULL COMMENT '服务商商户号'");}
if(!pdo_fieldexists('mzhk_sun_system','server_wxkey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `server_wxkey` varchar(255) NOT NULL COMMENT '服务商商户秘钥'");}
if(!pdo_fieldexists('mzhk_sun_system','myrztext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myrztext` varchar(50) NOT NULL COMMENT '云店入驻文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mygltext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mygltext` varchar(50) NOT NULL COMMENT '云店入驻文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mycdtext')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycdtext` varchar(50) NOT NULL COMMENT '云店入驻文字'");}
if(!pdo_fieldexists('mzhk_sun_system','myrzicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myrzicon` varchar(100) NOT NULL COMMENT '云店入驻图标'");}
if(!pdo_fieldexists('mzhk_sun_system','myglicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `myglicon` varchar(50) NOT NULL COMMENT '云店入驻文字'");}
if(!pdo_fieldexists('mzhk_sun_system','mycdicon')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `mycdicon` varchar(50) NOT NULL COMMENT '云店入驻文字'");}
if(!pdo_fieldexists('mzhk_sun_system','is_counp')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   `is_counp` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商家单独开启优惠券：1开启，2不开启'");}
if(!pdo_fieldexists('mzhk_sun_system','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_system')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_tbbanner` (
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

");

if(!pdo_fieldexists('mzhk_sun_tbbanner','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `lb_imgs` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','lb_imgs1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `lb_imgs1` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','lb_imgs2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `lb_imgs2` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','lb_imgs3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `lb_imgs3` varchar(200) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `bname` varchar(110) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','bname1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `bname1` varchar(110) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','bname2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `bname2` varchar(110) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','bname3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `bname3` varchar(110) CHARACTER SET utf8 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','lb_imgs4')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `lb_imgs4` varchar(200) CHARACTER SET utf8 NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_tbbanner','bname4')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_tbbanner')." ADD   `bname4` varchar(110) CHARACTER SET utf8 NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_user` (
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
  `shopid` int(11) DEFAULT '0' COMMENT '云店推荐id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM AUTO_INCREMENT=972 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'iq'");}
if(!pdo_fieldexists('mzhk_sun_user','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_user','img')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `img` varchar(200) DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('mzhk_sun_user','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `time` varchar(50) DEFAULT NULL COMMENT '登录时间'");}
if(!pdo_fieldexists('mzhk_sun_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_user','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `money` decimal(11,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('mzhk_sun_user','name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `name` varchar(101) CHARACTER SET utf8mb4 DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_user','uname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `uname` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_user','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `addtime` varchar(50) DEFAULT NULL COMMENT '会员的添加的时间'");}
if(!pdo_fieldexists('mzhk_sun_user','viptype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `viptype` int(11) DEFAULT '0' COMMENT '会员登记'");}
if(!pdo_fieldexists('mzhk_sun_user','endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `endtime` varchar(50) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('mzhk_sun_user','telphone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `telphone` varchar(20) NOT NULL COMMENT '手机号码'");}
if(!pdo_fieldexists('mzhk_sun_user','parents_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `parents_id` int(11) NOT NULL COMMENT '上级id'");}
if(!pdo_fieldexists('mzhk_sun_user','parents_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `parents_name` varchar(255) NOT NULL COMMENT '上级名称'");}
if(!pdo_fieldexists('mzhk_sun_user','isvisit')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `isvisit` int(11) DEFAULT '0' COMMENT '是否拉黑 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_user','isnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `isnum` int(11) DEFAULT '0' COMMENT '是否验证 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_user','isuname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `isuname` int(11) DEFAULT '0' COMMENT '是否验证姓名 0 否 1 是'");}
if(!pdo_fieldexists('mzhk_sun_user','spare_parents_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `spare_parents_id` int(11) NOT NULL COMMENT '备用上级id'");}
if(!pdo_fieldexists('mzhk_sun_user','spare_parents_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `spare_parents_name` varchar(255) NOT NULL COMMENT '备用上级用户名'");}
if(!pdo_fieldexists('mzhk_sun_user','integral')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `integral` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('mzhk_sun_user','shopid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   `shopid` int(11) DEFAULT '0' COMMENT '云店推荐id'");}
if(!pdo_fieldexists('mzhk_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('mzhk_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user')." ADD   UNIQUE KEY `id` (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_user_coupon` (
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
  `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金',
  `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金',
  `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_user_coupon','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `uid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `cid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','vab')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `vab` int(11) DEFAULT NULL COMMENT '优惠券名称，展示用'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `type` tinyint(3) unsigned DEFAULT NULL COMMENT '优惠券类型（1:折扣 2:代金券）'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','val')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `val` int(11) DEFAULT NULL COMMENT '功能'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','createTime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `createTime` varchar(50) DEFAULT NULL COMMENT '领取时间'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','limitTime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `limitTime` varchar(50) DEFAULT NULL COMMENT '使用截止时间'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','isUsed')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `isUsed` tinyint(3) DEFAULT '0' COMMENT '是否使用'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','useTime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `useTime` varchar(50) DEFAULT '0' COMMENT '使用时间'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','from')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `from` int(11) DEFAULT NULL COMMENT '优惠券来源（0:用户领取 1:充值赠送 2:支付赠送）'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `out_trade_no` varchar(255) NOT NULL COMMENT '外部订单id'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','ispay')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `ispay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支付'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','paytype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `paytype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0免费，1微信，2余额'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','paytime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `paytime` int(11) NOT NULL COMMENT '付款时间'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','fromuser')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `fromuser` varchar(255) NOT NULL COMMENT '从哪来'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','firstuser')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `firstuser` varchar(255) NOT NULL COMMENT '第一个拥有优惠券的人'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','is_store_submac')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `is_store_submac` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用商家子商户号收款，0未启用，1启用'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','sub_mch_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `sub_mch_id` varchar(255) DEFAULT NULL COMMENT '子商户号id'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','returnsign')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `returnsign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买会员赠送标识 0 非赠送 1 赠送'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','viplogid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `viplogid` int(11) NOT NULL DEFAULT '0' COMMENT '会员订单id'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','vipid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `vipid` int(11) NOT NULL DEFAULT '0' COMMENT '会员id'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','commission_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `commission_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '佣金类型 0使用订单金额 1总佣金'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','totalcommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `totalcommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金'");}
if(!pdo_fieldexists('mzhk_sun_user_coupon','fxmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_user_coupon')." ADD   `fxmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='formid表';

");

if(!pdo_fieldexists('mzhk_sun_userformid','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_userformid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_userformid','user_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_userformid')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('mzhk_sun_userformid','form_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_userformid')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id'");}
if(!pdo_fieldexists('mzhk_sun_userformid','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_userformid')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_userformid','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_userformid')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_userformid','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_userformid')." ADD   `openid` varchar(50) NOT NULL COMMENT 'openid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_vcate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `vcatename` varchar(50) NOT NULL COMMENT '虚拟分类名称',
  `addtime` varchar(100) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_vcate','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vcate')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_vcate','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vcate')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_vcate','vcatename')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vcate')." ADD   `vcatename` varchar(50) NOT NULL COMMENT '虚拟分类名称'");}
if(!pdo_fieldexists('mzhk_sun_vcate','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vcate')." ADD   `addtime` varchar(100) NOT NULL COMMENT '添加时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_vip` (
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

");

if(!pdo_fieldexists('mzhk_sun_vip','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_vip','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `uniacid` int(11) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_vip','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '标题，展示用'");}
if(!pdo_fieldexists('mzhk_sun_vip','day')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `day` int(10) unsigned DEFAULT NULL COMMENT '时间'");}
if(!pdo_fieldexists('mzhk_sun_vip','price')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `price` decimal(10,2) unsigned DEFAULT NULL COMMENT '价格'");}
if(!pdo_fieldexists('mzhk_sun_vip','jihuoma')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `jihuoma` varchar(30) DEFAULT '0' COMMENT '激活码'");}
if(!pdo_fieldexists('mzhk_sun_vip','time')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_vip','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `status` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_vip','prefix')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `prefix` varchar(50) NOT NULL COMMENT '前缀'");}
if(!pdo_fieldexists('mzhk_sun_vip','distribution_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启'");}
if(!pdo_fieldexists('mzhk_sun_vip','distribution_commissiontype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1百分比，2固定金额'");}
if(!pdo_fieldexists('mzhk_sun_vip','firstmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('mzhk_sun_vip','secondmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('mzhk_sun_vip','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
if(!pdo_fieldexists('mzhk_sun_vip','money_rate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `money_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认支付金额比例'");}
if(!pdo_fieldexists('mzhk_sun_vip','score_rate')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `score_rate` int(11) NOT NULL DEFAULT '0' COMMENT '默认兑换积分比例'");}
if(!pdo_fieldexists('mzhk_sun_vip','buyvipset')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `buyvipset` int(11) NOT NULL DEFAULT '0' COMMENT '购买会员福利 0 不开启 1 返还到余额 2 赠送优惠券 3 赠送普通商品'");}
if(!pdo_fieldexists('mzhk_sun_vip','cid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `cid` int(11) NOT NULL DEFAULT '0' COMMENT '赠送优惠券id'");}
if(!pdo_fieldexists('mzhk_sun_vip','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '赠送普通商品id'");}
if(!pdo_fieldexists('mzhk_sun_vip','returnmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vip')." ADD   `returnmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返还金额'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_vipcode` (
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
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_vipcode','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_vipcode','vipid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `vipid` int(11) NOT NULL COMMENT 'vip种类id'");}
if(!pdo_fieldexists('mzhk_sun_vipcode','vc_code')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `vc_code` varchar(100) NOT NULL COMMENT 'vip激活码'");}
if(!pdo_fieldexists('mzhk_sun_vipcode','vc_isuse')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `vc_isuse` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未使用，1已使用'");}
if(!pdo_fieldexists('mzhk_sun_vipcode','vc_starttime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `vc_starttime` datetime NOT NULL COMMENT '使用开始时间'");}
if(!pdo_fieldexists('mzhk_sun_vipcode','vc_endtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `vc_endtime` datetime NOT NULL COMMENT '过期时间'");}
if(!pdo_fieldexists('mzhk_sun_vipcode','uid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `uid` int(11) NOT NULL COMMENT '激活的用户id'");}
if(!pdo_fieldexists('mzhk_sun_vipcode','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_vipcode','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_vipcode','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员卡价格'");}
if(!pdo_fieldexists('mzhk_sun_vipcode','viptitle')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `viptitle` varchar(100) NOT NULL COMMENT 'vip名称'");}
if(!pdo_fieldexists('mzhk_sun_vipcode','vipday')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vipcode')." ADD   `vipday` int(11) NOT NULL COMMENT '激活天数'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_vippaylog` (
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
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_vippaylog','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','vipid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `vipid` int(11) NOT NULL COMMENT '激活码类别id'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','viptitle')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `viptitle` varchar(50) NOT NULL COMMENT 'vip类别名称'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `uniacid` int(11) NOT NULL COMMENT '标识id'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','activetype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `activetype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '激活类别，0激活码激活，1线上购买激活'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','vc_code')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `vc_code` varchar(100) NOT NULL COMMENT '激活码'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '激活时间'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `openid` varchar(200) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员卡价格'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','vipday')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `vipday` int(11) NOT NULL COMMENT 'vip天数'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('mzhk_sun_vippaylog','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_vippaylog')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '三级id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_virtualdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `usernum` int(11) NOT NULL DEFAULT '0' COMMENT '用户数',
  `goodsnum` int(11) NOT NULL DEFAULT '0' COMMENT '订单数',
  `vtime` varchar(100) NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_virtualdata','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_virtualdata')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_virtualdata','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_virtualdata')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_virtualdata','cateid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_virtualdata')." ADD   `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id'");}
if(!pdo_fieldexists('mzhk_sun_virtualdata','goodsprice')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_virtualdata')." ADD   `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格'");}
if(!pdo_fieldexists('mzhk_sun_virtualdata','usernum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_virtualdata')." ADD   `usernum` int(11) NOT NULL DEFAULT '0' COMMENT '用户数'");}
if(!pdo_fieldexists('mzhk_sun_virtualdata','goodsnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_virtualdata')." ADD   `goodsnum` int(11) NOT NULL DEFAULT '0' COMMENT '订单数'");}
if(!pdo_fieldexists('mzhk_sun_virtualdata','vtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_virtualdata')." ADD   `vtime` varchar(100) NOT NULL COMMENT '时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_wechat_menus` (
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

");

if(!pdo_fieldexists('mzhk_sun_wechat_menus','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `uniacid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','menuid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `menuid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `type` tinyint(3) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `title` varchar(30) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','sex')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `sex` tinyint(3) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','group_id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `group_id` int(10) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','client_platform_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `client_platform_type` tinyint(3) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','area')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `area` varchar(50) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','data')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `data` text NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `status` tinyint(3) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','createtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `createtime` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','isdeleted')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   `isdeleted` tinyint(3) unsigned NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('mzhk_sun_wechat_menus','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_menus')." ADD   KEY `uniacid` (`uniacid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_wechat_set` (
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

");

if(!pdo_fieldexists('mzhk_sun_wechat_set','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_wechat_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_set')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_wechat_set','wechat_appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_set')." ADD   `wechat_appid` varchar(100) NOT NULL COMMENT '公众号appid'");}
if(!pdo_fieldexists('mzhk_sun_wechat_set','wechat_appsecret')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_set')." ADD   `wechat_appsecret` varchar(255) NOT NULL COMMENT '公众号appsecret'");}
if(!pdo_fieldexists('mzhk_sun_wechat_set','wechat_token')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_set')." ADD   `wechat_token` varchar(255) NOT NULL COMMENT '令牌(Token)'");}
if(!pdo_fieldexists('mzhk_sun_wechat_set','wechat_aeskey')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_set')." ADD   `wechat_aeskey` varchar(255) NOT NULL COMMENT 'EncodingAESKey'");}
if(!pdo_fieldexists('mzhk_sun_wechat_set','is_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_set')." ADD   `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1开启，0关闭'");}
if(!pdo_fieldexists('mzhk_sun_wechat_set','backcontent')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wechat_set')." ADD   `backcontent` varchar(255) NOT NULL COMMENT '公众号回复的内容，前面部分'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_withdraw` (
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_withdraw','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `openid` varchar(200) NOT NULL COMMENT '提现用户oppenid'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `money` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','wd_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `wd_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '提现方式，1微信，2支付宝，3银行账号'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','wd_account')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `wd_account` varchar(100) NOT NULL COMMENT '提现账号'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','wd_name')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `wd_name` varchar(50) NOT NULL COMMENT '提现名字'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','wd_phone')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `wd_phone` varchar(50) NOT NULL COMMENT '提现联系方式'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0审核中，1通过审核，2拒绝提现，3自动打款'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','realmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','paycommission')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '需要支付佣金'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `bname` varchar(100) NOT NULL COMMENT '提现商家名称'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','wd_bankname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `wd_bankname` varchar(100) NOT NULL COMMENT '提现银行名称'");}
if(!pdo_fieldexists('mzhk_sun_withdraw','wd_fbankname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdraw')." ADD   `wd_fbankname` varchar(100) NOT NULL COMMENT '提现分行名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_withdrawset` (
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

");

if(!pdo_fieldexists('mzhk_sun_withdrawset','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','wd_type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `wd_type` varchar(50) NOT NULL DEFAULT '1' COMMENT '（1,2,3）提现方式，1微信支付，2支付宝，3银行打款'");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','min_money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `min_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额'");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','avoidmoney')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `avoidmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额，可直接提现金额'");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','wd_content')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `wd_content` text NOT NULL COMMENT '提现须知'");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','cms_rates')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `cms_rates` float NOT NULL DEFAULT '0' COMMENT '平台佣金比率'");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','is_open')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '提现开关，2关，1开'");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','wd_wxrates')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `wd_wxrates` float NOT NULL DEFAULT '0' COMMENT '微信提现手续费'");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','wd_alipayrates')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `wd_alipayrates` float NOT NULL DEFAULT '0' COMMENT '支付宝提现手续费'");}
if(!pdo_fieldexists('mzhk_sun_withdrawset','wd_bankrates')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_withdrawset')." ADD   `wd_bankrates` float NOT NULL DEFAULT '0' COMMENT '银行卡提现手续费'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_write` (
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

");

if(!pdo_fieldexists('mzhk_sun_write','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_write')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_write','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_write')." ADD   `oid` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('mzhk_sun_write','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_write')." ADD   `bid` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('mzhk_sun_write','finishtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_write')." ADD   `finishtime` varchar(50) NOT NULL DEFAULT '0' COMMENT '核销时间'");}
if(!pdo_fieldexists('mzhk_sun_write','money')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_write')." ADD   `money` varchar(50) NOT NULL DEFAULT '0' COMMENT '核销金额'");}
if(!pdo_fieldexists('mzhk_sun_write','haswrittenoffnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_write')." ADD   `haswrittenoffnum` int(11) NOT NULL DEFAULT '0' COMMENT '核销数'");}
if(!pdo_fieldexists('mzhk_sun_write','ordertype')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_write')." ADD   `ordertype` int(11) NOT NULL DEFAULT '0' COMMENT '订单类型 0 普通订单 1 抢购订单'");}
if(!pdo_fieldexists('mzhk_sun_write','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_write')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_writewoffrecords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL COMMENT '核销人openid',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '核销商品id',
  `goodsnum` int(11) NOT NULL DEFAULT '0' COMMENT '核销商品数',
  `oid` int(11) NOT NULL DEFAULT '0' COMMENT '核销订单id',
  `addtime` varchar(100) NOT NULL COMMENT '核销时间',
  `lid` int(11) NOT NULL DEFAULT '0' COMMENT '核销商品类型：1普通，2砍，3拼团，4集卡，5抢购，6免单，7吃探，10优惠券，11裂变券，12次卡',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '所属商家',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作人员类型：0平台，1商家，2快递核销，3次卡自动核销',
  `gname` varchar(100) NOT NULL COMMENT '商品名称',
  `bname` varchar(100) NOT NULL COMMENT '商家名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_writewoffrecords','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `openid` varchar(100) NOT NULL COMMENT '核销人openid'");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','gid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '核销商品id'");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','goodsnum')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `goodsnum` int(11) NOT NULL DEFAULT '0' COMMENT '核销商品数'");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','oid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `oid` int(11) NOT NULL DEFAULT '0' COMMENT '核销订单id'");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `addtime` varchar(100) NOT NULL COMMENT '核销时间'");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','lid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `lid` int(11) NOT NULL DEFAULT '0' COMMENT '核销商品类型：1普通，2砍，3拼团，4集卡，5抢购，6免单，7吃探，10优惠券，11裂变券，12次卡'");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `bid` int(11) NOT NULL DEFAULT '0' COMMENT '所属商家'");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','type')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作人员类型：0平台，1商家，2快递核销，3次卡自动核销'");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','gname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `gname` varchar(100) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('mzhk_sun_writewoffrecords','bname')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_writewoffrecords')." ADD   `bname` varchar(100) NOT NULL COMMENT '商家名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_wxappjump` (
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

");

if(!pdo_fieldexists('mzhk_sun_wxappjump','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wxappjump')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_wxappjump','title')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wxappjump')." ADD   `title` varchar(100) NOT NULL COMMENT '跳转的小程序名'");}
if(!pdo_fieldexists('mzhk_sun_wxappjump','pic')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wxappjump')." ADD   `pic` varchar(255) NOT NULL COMMENT '小程序图标'");}
if(!pdo_fieldexists('mzhk_sun_wxappjump','appid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wxappjump')." ADD   `appid` varchar(100) NOT NULL COMMENT '小程序appid'");}
if(!pdo_fieldexists('mzhk_sun_wxappjump','path')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wxappjump')." ADD   `path` varchar(255) NOT NULL COMMENT '跳转到的小程序页面'");}
if(!pdo_fieldexists('mzhk_sun_wxappjump','position')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wxappjump')." ADD   `position` tinyint(3) NOT NULL COMMENT '当前小程序点击位置'");}
if(!pdo_fieldexists('mzhk_sun_wxappjump','sort')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wxappjump')." ADD   `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序'");}
if(!pdo_fieldexists('mzhk_sun_wxappjump','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wxappjump')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('mzhk_sun_wxappjump','addtime')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_wxappjump')." ADD   `addtime` int(11) NOT NULL COMMENT '增加时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_youhui` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('mzhk_sun_youhui','id')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_youhui')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('mzhk_sun_youhui','bid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_youhui')." ADD   `bid` int(11) NOT NULL");}
if(!pdo_fieldexists('mzhk_sun_youhui','uniacid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_youhui')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_youhui','openid')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_youhui')." ADD   `openid` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('mzhk_sun_youhui','status')) {pdo_query("ALTER TABLE ".tablename('mzhk_sun_youhui')." ADD   `status` int(11) DEFAULT '1'");}
