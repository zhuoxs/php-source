<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` varchar(1000) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `from_user` varchar(100) NOT NULL DEFAULT '',
  `accountname` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `salt` varchar(10) NOT NULL DEFAULT '',
  `pwd` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pay_account` varchar(200) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态',
  `role` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:店长,2:店员',
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(15) NOT NULL,
  `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_boss` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `cityname` varchar(50) NOT NULL COMMENT '城市名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_account','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_account','weid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('yzcyk_sun_account','storeid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `storeid` varchar(1000) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_account','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `uid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_account','from_user')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `from_user` varchar(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('yzcyk_sun_account','accountname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `accountname` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('yzcyk_sun_account','password')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `password` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('yzcyk_sun_account','salt')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `salt` varchar(10) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('yzcyk_sun_account','pwd')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `pwd` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_account','mobile')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `mobile` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_account','email')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `email` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_account','username')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `username` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_account','pay_account')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `pay_account` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_account','displayorder')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_account','dateline')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_account','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态'");}
if(!pdo_fieldexists('yzcyk_sun_account','role')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `role` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:店长,2:店员'");}
if(!pdo_fieldexists('yzcyk_sun_account','lastvisit')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `lastvisit` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_account','lastip')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `lastip` varchar(15) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_account','areaid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id'");}
if(!pdo_fieldexists('yzcyk_sun_account','is_admin_order')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_account','is_notice_order')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_account','is_notice_queue')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_account','is_notice_service')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_account','is_notice_boss')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `is_notice_boss` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_account','remark')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注'");}
if(!pdo_fieldexists('yzcyk_sun_account','lat')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('yzcyk_sun_account','lng')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
if(!pdo_fieldexists('yzcyk_sun_account','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_account')." ADD   `cityname` varchar(50) NOT NULL COMMENT '城市名称'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_acode` (
  `id` int(11) NOT NULL COMMENT '该id不自动增加',
  `time` varchar(30) NOT NULL COMMENT '时间',
  `code` text NOT NULL COMMENT '码',
  `url` varchar(255) NOT NULL,
  `uncode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_acode','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_acode')." ADD 
  `id` int(11) NOT NULL COMMENT '该id不自动增加'");}
if(!pdo_fieldexists('yzcyk_sun_acode','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_acode')." ADD   `time` varchar(30) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('yzcyk_sun_acode','code')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_acode')." ADD   `code` text NOT NULL COMMENT '码'");}
if(!pdo_fieldexists('yzcyk_sun_acode','url')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_acode')." ADD   `url` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_activationcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `code` varchar(60) DEFAULT NULL,
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '天数',
  `add_time` int(11) DEFAULT NULL,
  `use_time` int(11) DEFAULT NULL,
  `is_use` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_activationcode','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activationcode')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_activationcode','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activationcode')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activationcode','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activationcode')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activationcode','code')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activationcode')." ADD   `code` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activationcode','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activationcode')." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '天数'");}
if(!pdo_fieldexists('yzcyk_sun_activationcode','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activationcode')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activationcode','use_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activationcode')." ADD   `use_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activationcode','is_use')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activationcode')." ADD   `is_use` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1使用'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_active` (
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

if(!pdo_fieldexists('yzcyk_sun_active','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'");}
if(!pdo_fieldexists('yzcyk_sun_active','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('yzcyk_sun_active','subtitle')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `subtitle` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_active','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `title` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_active','createtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `createtime` int(13) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('yzcyk_sun_active','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `content` text NOT NULL COMMENT '文章内容'");}
if(!pdo_fieldexists('yzcyk_sun_active','sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `sort` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_active','antime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `antime` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_active','hits')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `hits` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_active','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `status` tinyint(10) DEFAULT '0' COMMENT '0审核中1审核通过'");}
if(!pdo_fieldexists('yzcyk_sun_active','astime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `astime` timestamp NULL DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_active','thumb')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `thumb` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_active','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `num` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_active','sharenum')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `sharenum` int(11) DEFAULT NULL COMMENT '每天可分享次数'");}
if(!pdo_fieldexists('yzcyk_sun_active','thumb_url')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `thumb_url` text");}
if(!pdo_fieldexists('yzcyk_sun_active','part_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `part_num` varchar(15) DEFAULT '0' COMMENT '参与人数'");}
if(!pdo_fieldexists('yzcyk_sun_active','share_plus')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `share_plus` varchar(15) DEFAULT '1' COMMENT '分享之后可得的次数'");}
if(!pdo_fieldexists('yzcyk_sun_active','new_partnum')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `new_partnum` varchar(15) DEFAULT NULL COMMENT '初始虚拟参与人数'");}
if(!pdo_fieldexists('yzcyk_sun_active','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `user_id` varchar(100) DEFAULT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('yzcyk_sun_active','storeinfo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `storeinfo` varchar(200) DEFAULT NULL COMMENT '店铺信息'");}
if(!pdo_fieldexists('yzcyk_sun_active','showindex')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `showindex` int(11) DEFAULT NULL COMMENT '0不显示1显示'");}
if(!pdo_fieldexists('yzcyk_sun_active','active_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_active')." ADD   `active_num` int(11) DEFAULT NULL COMMENT '活动商品数量'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_activerecord` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id',
  `uid` int(10) DEFAULT NULL,
  `pid` int(10) DEFAULT '0',
  `num` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_activerecord','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activerecord')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'");}
if(!pdo_fieldexists('yzcyk_sun_activerecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activerecord')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('yzcyk_sun_activerecord','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activerecord')." ADD   `uid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activerecord','pid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activerecord')." ADD   `pid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_activerecord','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activerecord')." ADD   `num` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_activerecord','createtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activerecord')." ADD   `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL COMMENT '活动标题',
  `store_id` int(11) DEFAULT NULL COMMENT '商家门店id',
  `category_id` int(11) DEFAULT NULL COMMENT '活动分类',
  `bm_begin_time` int(11) DEFAULT NULL COMMENT '报名开始时间',
  `bm_end_time` int(11) DEFAULT NULL COMMENT '报名结束时间',
  `hdbegintime` varchar(60) DEFAULT NULL,
  `hdendtime` varchar(60) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL COMMENT '展示图',
  `lb_pics` text COMMENT '轮播图',
  `tag` varchar(200) DEFAULT NULL COMMENT '标签',
  `common_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '普通价',
  `qzk_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '车友卡价',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '份数',
  `sale_num` int(11) NOT NULL DEFAULT '0' COMMENT '销售或者领取份数',
  `qzk_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '车友卡专享活动 1',
  `age_limit` varchar(100) DEFAULT NULL COMMENT '年龄限制',
  `remark` varchar(100) DEFAULT NULL COMMENT '温馨提示',
  `info` text COMMENT '活动须知',
  `content` text COMMENT '详情',
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '2通过 3失败',
  `tg_time` int(11) DEFAULT NULL,
  `jj_time` int(11) DEFAULT NULL,
  `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '首页展示',
  `gkfl_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '购卡福利',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='活动表';

");

if(!pdo_fieldexists('yzcyk_sun_activity','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_activity','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activity','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `title` varchar(200) DEFAULT NULL COMMENT '活动标题'");}
if(!pdo_fieldexists('yzcyk_sun_activity','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `store_id` int(11) DEFAULT NULL COMMENT '商家门店id'");}
if(!pdo_fieldexists('yzcyk_sun_activity','category_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `category_id` int(11) DEFAULT NULL COMMENT '活动分类'");}
if(!pdo_fieldexists('yzcyk_sun_activity','bm_begin_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `bm_begin_time` int(11) DEFAULT NULL COMMENT '报名开始时间'");}
if(!pdo_fieldexists('yzcyk_sun_activity','bm_end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `bm_end_time` int(11) DEFAULT NULL COMMENT '报名结束时间'");}
if(!pdo_fieldexists('yzcyk_sun_activity','hdbegintime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `hdbegintime` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activity','hdendtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `hdendtime` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activity','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '展示图'");}
if(!pdo_fieldexists('yzcyk_sun_activity','lb_pics')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `lb_pics` text COMMENT '轮播图'");}
if(!pdo_fieldexists('yzcyk_sun_activity','tag')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `tag` varchar(200) DEFAULT NULL COMMENT '标签'");}
if(!pdo_fieldexists('yzcyk_sun_activity','common_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `common_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '普通价'");}
if(!pdo_fieldexists('yzcyk_sun_activity','qzk_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `qzk_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '车友卡价'");}
if(!pdo_fieldexists('yzcyk_sun_activity','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '份数'");}
if(!pdo_fieldexists('yzcyk_sun_activity','sale_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `sale_num` int(11) NOT NULL DEFAULT '0' COMMENT '销售或者领取份数'");}
if(!pdo_fieldexists('yzcyk_sun_activity','qzk_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `qzk_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '车友卡专享活动 1'");}
if(!pdo_fieldexists('yzcyk_sun_activity','age_limit')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `age_limit` varchar(100) DEFAULT NULL COMMENT '年龄限制'");}
if(!pdo_fieldexists('yzcyk_sun_activity','remark')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `remark` varchar(100) DEFAULT NULL COMMENT '温馨提示'");}
if(!pdo_fieldexists('yzcyk_sun_activity','info')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `info` text COMMENT '活动须知'");}
if(!pdo_fieldexists('yzcyk_sun_activity','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('yzcyk_sun_activity','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activity','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '2通过 3失败'");}
if(!pdo_fieldexists('yzcyk_sun_activity','tg_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `tg_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activity','jj_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `jj_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activity','show_index')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '首页展示'");}
if(!pdo_fieldexists('yzcyk_sun_activity','gkfl_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity')." ADD   `gkfl_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '购卡福利'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_activity_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL COMMENT '名称',
  `icons` varchar(200) DEFAULT NULL COMMENT '图标',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_activity_category','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity_category')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_activity_category','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity_category')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_activity_category','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity_category')." ADD   `title` varchar(60) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('yzcyk_sun_activity_category','icons')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity_category')." ADD   `icons` varchar(200) DEFAULT NULL COMMENT '图标'");}
if(!pdo_fieldexists('yzcyk_sun_activity_category','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_activity_category')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '轮播图标题',
  `logo` varchar(200) NOT NULL COMMENT '图片',
  `status` int(11) NOT NULL COMMENT '1.开启  2.关闭',
  `src` varchar(100) NOT NULL COMMENT '链接',
  `orderby` int(11) NOT NULL COMMENT '排序',
  `xcx_name` varchar(20) NOT NULL,
  `appid` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `type` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `wb_src` varchar(300) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_ad','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_ad','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `title` varchar(50) NOT NULL COMMENT '轮播图标题'");}
if(!pdo_fieldexists('yzcyk_sun_ad','logo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `logo` varchar(200) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzcyk_sun_ad','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `status` int(11) NOT NULL COMMENT '1.开启  2.关闭'");}
if(!pdo_fieldexists('yzcyk_sun_ad','src')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `src` varchar(100) NOT NULL COMMENT '链接'");}
if(!pdo_fieldexists('yzcyk_sun_ad','orderby')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `orderby` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_ad','xcx_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `xcx_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_ad','appid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `appid` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_ad','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzcyk_sun_ad','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `type` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_ad','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_ad','wb_src')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `wb_src` varchar(300) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_ad','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_ad')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consignee` varchar(45) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` text NOT NULL,
  `stree` text NOT NULL,
  `uid` text NOT NULL,
  `isdefault` int(11) NOT NULL DEFAULT '0',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_address','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_address')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_address','consignee')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_address')." ADD   `consignee` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_address','phone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_address')." ADD   `phone` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_address','address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_address')." ADD   `address` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_address','stree')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_address')." ADD   `stree` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_address','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_address')." ADD   `uid` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_address','isdefault')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_address')." ADD   `isdefault` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_address')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1首页公告 2好店公告',
  `title` varchar(100) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `show_index` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='公告管理';

");

if(!pdo_fieldexists('yzcyk_sun_announcement','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_announcement')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_announcement','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_announcement')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_announcement','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_announcement')." ADD   `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1首页公告 2好店公告'");}
if(!pdo_fieldexists('yzcyk_sun_announcement','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_announcement')." ADD   `title` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_announcement','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_announcement')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_announcement','show_index')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_announcement')." ADD   `show_index` tinyint(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(50) NOT NULL COMMENT '区域名称',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_area','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_area')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_area','area_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_area')." ADD   `area_name` varchar(50) NOT NULL COMMENT '区域名称'");}
if(!pdo_fieldexists('yzcyk_sun_area','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_area')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_area','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_area')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_baby` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `sex` varchar(4) DEFAULT '1' COMMENT '1男2女',
  `birth` varchar(20) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  `car_producer` varchar(100) DEFAULT NULL COMMENT '车辆产商',
  `car_level` varchar(100) DEFAULT NULL COMMENT '车辆级别',
  `car_number` varchar(100) DEFAULT NULL COMMENT '车辆号',
  `car_insurance` varchar(20) DEFAULT NULL COMMENT '保险到期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='宝宝表';

");

if(!pdo_fieldexists('yzcyk_sun_baby','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_baby','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baby','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baby','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baby','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `name` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baby','sex')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `sex` varchar(4) DEFAULT '1' COMMENT '1男2女'");}
if(!pdo_fieldexists('yzcyk_sun_baby','birth')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `birth` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baby','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baby','edit_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `edit_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baby','car_producer')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `car_producer` varchar(100) DEFAULT NULL COMMENT '车辆产商'");}
if(!pdo_fieldexists('yzcyk_sun_baby','car_level')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `car_level` varchar(100) DEFAULT NULL COMMENT '车辆级别'");}
if(!pdo_fieldexists('yzcyk_sun_baby','car_number')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `car_number` varchar(100) DEFAULT NULL COMMENT '车辆号'");}
if(!pdo_fieldexists('yzcyk_sun_baby','car_insurance')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baby')." ADD   `car_insurance` varchar(20) DEFAULT NULL COMMENT '保险到期'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bname` varchar(45) NOT NULL,
  `lb_imgs` varchar(500) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `url_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '小程序类型 1基本 2商品分类',
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_banner','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_banner')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_banner','bname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_banner')." ADD   `bname` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_banner','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_banner')." ADD   `lb_imgs` varchar(500) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_banner','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_banner')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_banner','url_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_banner')." ADD   `url_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '小程序类型 1基本 2商品分类'");}
if(!pdo_fieldexists('yzcyk_sun_banner','url')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_banner')." ADD   `url` varchar(100) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_baowen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xml` text,
  `out_trade_no` varchar(60) DEFAULT NULL,
  `transaction_id` varchar(60) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `out_trade_no` (`out_trade_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=614 DEFAULT CHARSET=utf8 COMMENT='支付报文';

");

if(!pdo_fieldexists('yzcyk_sun_baowen','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baowen')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_baowen','xml')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baowen')." ADD   `xml` text");}
if(!pdo_fieldexists('yzcyk_sun_baowen','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baowen')." ADD   `out_trade_no` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baowen','transaction_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baowen')." ADD   `transaction_id` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baowen','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baowen')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_baowen','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_baowen')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_bargain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(100) DEFAULT NULL COMMENT '商品名',
  `marketprice` varchar(45) DEFAULT NULL COMMENT '原价',
  `selftime` varchar(100) DEFAULT NULL COMMENT '发布时间',
  `pic` varchar(200) DEFAULT NULL COMMENT '活动图',
  `details` text COMMENT '商品详情',
  `status` int(11) DEFAULT NULL COMMENT '状态 1为开启2为关闭',
  `uniacid` int(11) DEFAULT NULL,
  `starttime` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `shopprice` varchar(45) DEFAULT NULL COMMENT '最低价',
  `endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `num` int(11) DEFAULT NULL COMMENT '数量',
  `content` text COMMENT '活动详情',
  `showindex` int(2) DEFAULT '0' COMMENT '0为不开启1为开启',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_bargain','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_bargain','gname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `gname` varchar(100) DEFAULT NULL COMMENT '商品名'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','marketprice')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `marketprice` varchar(45) DEFAULT NULL COMMENT '原价'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','selftime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `selftime` varchar(100) DEFAULT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '活动图'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `details` text COMMENT '商品详情'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `status` int(11) DEFAULT NULL COMMENT '状态 1为开启2为关闭'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_bargain','starttime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `starttime` timestamp NULL DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','shopprice')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `shopprice` varchar(45) DEFAULT NULL COMMENT '最低价'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','endtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `num` int(11) DEFAULT NULL COMMENT '数量'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `content` text COMMENT '活动详情'");}
if(!pdo_fieldexists('yzcyk_sun_bargain','showindex')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_bargain')." ADD   `showindex` int(2) DEFAULT '0' COMMENT '0为不开启1为开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `start_place` varchar(100) NOT NULL COMMENT '出发地',
  `end_place` varchar(100) NOT NULL COMMENT '目的地',
  `start_time` varchar(30) NOT NULL COMMENT '出发时间',
  `num` int(4) NOT NULL COMMENT '乘车人数/可乘人数',
  `link_name` varchar(30) NOT NULL COMMENT '联系人',
  `link_tel` varchar(20) NOT NULL COMMENT '联系电话',
  `typename` varchar(30) NOT NULL COMMENT '分类名称',
  `other` varchar(300) NOT NULL COMMENT '补充',
  `time` int(11) NOT NULL COMMENT '发布时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `top_id` int(11) NOT NULL COMMENT '置顶ID',
  `top` int(4) NOT NULL COMMENT '是否置顶,1,是,2否',
  `uniacid` varchar(50) NOT NULL,
  `state` int(4) NOT NULL COMMENT '1待审核,2通过，3拒绝',
  `tj_place` varchar(300) NOT NULL COMMENT '途经地',
  `hw_wet` varchar(10) NOT NULL COMMENT '货物重量',
  `star_lat` varchar(20) NOT NULL COMMENT '出发地维度',
  `star_lng` varchar(20) NOT NULL COMMENT '出发地经度',
  `end_lat` varchar(20) NOT NULL COMMENT '目的地维度',
  `end_lng` varchar(20) NOT NULL COMMENT '目的地经度',
  `is_open` int(4) NOT NULL,
  `start_time2` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼车';

");

if(!pdo_fieldexists('yzcyk_sun_car','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_car','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcyk_sun_car','start_place')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `start_place` varchar(100) NOT NULL COMMENT '出发地'");}
if(!pdo_fieldexists('yzcyk_sun_car','end_place')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `end_place` varchar(100) NOT NULL COMMENT '目的地'");}
if(!pdo_fieldexists('yzcyk_sun_car','start_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `start_time` varchar(30) NOT NULL COMMENT '出发时间'");}
if(!pdo_fieldexists('yzcyk_sun_car','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `num` int(4) NOT NULL COMMENT '乘车人数/可乘人数'");}
if(!pdo_fieldexists('yzcyk_sun_car','link_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `link_name` varchar(30) NOT NULL COMMENT '联系人'");}
if(!pdo_fieldexists('yzcyk_sun_car','link_tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `link_tel` varchar(20) NOT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('yzcyk_sun_car','typename')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `typename` varchar(30) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('yzcyk_sun_car','other')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `other` varchar(300) NOT NULL COMMENT '补充'");}
if(!pdo_fieldexists('yzcyk_sun_car','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `time` int(11) NOT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('yzcyk_sun_car','sh_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('yzcyk_sun_car','top_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `top_id` int(11) NOT NULL COMMENT '置顶ID'");}
if(!pdo_fieldexists('yzcyk_sun_car','top')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `top` int(4) NOT NULL COMMENT '是否置顶,1,是,2否'");}
if(!pdo_fieldexists('yzcyk_sun_car','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_car','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `state` int(4) NOT NULL COMMENT '1待审核,2通过，3拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_car','tj_place')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `tj_place` varchar(300) NOT NULL COMMENT '途经地'");}
if(!pdo_fieldexists('yzcyk_sun_car','hw_wet')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `hw_wet` varchar(10) NOT NULL COMMENT '货物重量'");}
if(!pdo_fieldexists('yzcyk_sun_car','star_lat')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `star_lat` varchar(20) NOT NULL COMMENT '出发地维度'");}
if(!pdo_fieldexists('yzcyk_sun_car','star_lng')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `star_lng` varchar(20) NOT NULL COMMENT '出发地经度'");}
if(!pdo_fieldexists('yzcyk_sun_car','end_lat')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `end_lat` varchar(20) NOT NULL COMMENT '目的地维度'");}
if(!pdo_fieldexists('yzcyk_sun_car','end_lng')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `end_lng` varchar(20) NOT NULL COMMENT '目的地经度'");}
if(!pdo_fieldexists('yzcyk_sun_car','is_open')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `is_open` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_car','start_time2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `start_time2` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_car','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car')." ADD   `cityname` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_car_my_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL COMMENT '标签id',
  `car_id` int(11) NOT NULL COMMENT '拼车ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_car_my_tag','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_my_tag')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_car_my_tag','tag_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_my_tag')." ADD   `tag_id` int(11) NOT NULL COMMENT '标签id'");}
if(!pdo_fieldexists('yzcyk_sun_car_my_tag','car_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_my_tag')." ADD   `car_id` int(11) NOT NULL COMMENT '拼车ID'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_car_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(30) NOT NULL COMMENT '分类名称',
  `tagname` varchar(30) NOT NULL COMMENT '标签名称',
  `uniacid` varchar(11) NOT NULL COMMENT '50',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_car_tag','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_tag')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_car_tag','typename')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_tag')." ADD   `typename` varchar(30) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('yzcyk_sun_car_tag','tagname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_tag')." ADD   `tagname` varchar(30) NOT NULL COMMENT '标签名称'");}
if(!pdo_fieldexists('yzcyk_sun_car_tag','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_tag')." ADD   `uniacid` varchar(11) NOT NULL COMMENT '50'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_car_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月',
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼车置顶';

");

if(!pdo_fieldexists('yzcyk_sun_car_top','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_top')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_car_top','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_top')." ADD   `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月'");}
if(!pdo_fieldexists('yzcyk_sun_car_top','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_top')." ADD   `money` decimal(10,2) NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('yzcyk_sun_car_top','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_top')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_car_top','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_car_top')." ADD   `num` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_carpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(44) NOT NULL COMMENT '拼车id',
  `money` decimal(10,2) NOT NULL COMMENT '钱',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拼车支付记录表';

");

if(!pdo_fieldexists('yzcyk_sun_carpaylog','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_carpaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_carpaylog','car_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_carpaylog')." ADD   `car_id` int(44) NOT NULL COMMENT '拼车id'");}
if(!pdo_fieldexists('yzcyk_sun_carpaylog','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_carpaylog')." ADD   `money` decimal(10,2) NOT NULL COMMENT '钱'");}
if(!pdo_fieldexists('yzcyk_sun_carpaylog','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_carpaylog')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_carpaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_carpaylog')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL COMMENT '帖子id',
  `details` varchar(200) NOT NULL COMMENT '评论详情',
  `time` varchar(20) NOT NULL COMMENT '时间',
  `reply` varchar(200) NOT NULL COMMENT '回复详情',
  `hf_time` varchar(20) NOT NULL COMMENT '回复时间',
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `score` decimal(10,1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_comments','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_comments')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_comments','information_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_comments')." ADD   `information_id` int(11) NOT NULL COMMENT '帖子id'");}
if(!pdo_fieldexists('yzcyk_sun_comments','details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_comments')." ADD   `details` varchar(200) NOT NULL COMMENT '评论详情'");}
if(!pdo_fieldexists('yzcyk_sun_comments','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_comments')." ADD   `time` varchar(20) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('yzcyk_sun_comments','reply')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_comments')." ADD   `reply` varchar(200) NOT NULL COMMENT '回复详情'");}
if(!pdo_fieldexists('yzcyk_sun_comments','hf_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_comments')." ADD   `hf_time` varchar(20) NOT NULL COMMENT '回复时间'");}
if(!pdo_fieldexists('yzcyk_sun_comments','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_comments')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_comments','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_comments')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_comments','score')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_comments')." ADD   `score` decimal(10,1) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_commission_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1.支付宝2.银行卡',
  `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝',
  `time` int(11) NOT NULL COMMENT '申请时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `uniacid` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `account` varchar(100) NOT NULL,
  `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额',
  `sj_cost` decimal(10,2) NOT NULL COMMENT '实际到账金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金提现';

");

if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `type` int(11) NOT NULL COMMENT '1.支付宝2.银行卡'");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `time` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','sh_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','user_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `user_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','account')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `account` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','tx_cost')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('yzcyk_sun_commission_withdrawal','sj_cost')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_commission_withdrawal')." ADD   `sj_cost` decimal(10,2) NOT NULL COMMENT '实际到账金额'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '优惠券名称',
  `store_id` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '优惠券类型 1满减 2折扣 3满送 4体验券',
  `sign` tinyint(1) DEFAULT '1' COMMENT '使用方式 1线上优惠券 2门店优惠券',
  `start_time` int(11) DEFAULT NULL COMMENT '活动开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '活动结束时间',
  `uniacid` int(11) DEFAULT NULL,
  `m_price` int(10) NOT NULL DEFAULT '0' COMMENT '单笔满多少金额',
  `mj_price` int(10) NOT NULL DEFAULT '0' COMMENT '满减金额',
  `expiry_day` int(11) NOT NULL DEFAULT '1' COMMENT '领取后有效天数',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '总量',
  `yl_num` int(11) NOT NULL DEFAULT '0' COMMENT '已领数量',
  `show_index` tinyint(4) DEFAULT NULL COMMENT '是否限时在首页',
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1开启 2关闭',
  `info` text COMMENT '使用说明',
  `remark` text,
  `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '仅车友卡vip可以领取',
  `is_punch` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否打卡奖品 1是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_coupon','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_coupon','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `title` varchar(100) NOT NULL DEFAULT '' COMMENT '优惠券名称'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_coupon','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '优惠券类型 1满减 2折扣 3满送 4体验券'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','sign')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `sign` tinyint(1) DEFAULT '1' COMMENT '使用方式 1线上优惠券 2门店优惠券'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','start_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `start_time` int(11) DEFAULT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `end_time` int(11) DEFAULT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_coupon','m_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `m_price` int(10) NOT NULL DEFAULT '0' COMMENT '单笔满多少金额'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','mj_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `mj_price` int(10) NOT NULL DEFAULT '0' COMMENT '满减金额'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','expiry_day')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `expiry_day` int(11) NOT NULL DEFAULT '1' COMMENT '领取后有效天数'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '总量'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','yl_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `yl_num` int(11) NOT NULL DEFAULT '0' COMMENT '已领数量'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','show_index')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `show_index` tinyint(4) DEFAULT NULL COMMENT '是否限时在首页'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_coupon','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1开启 2关闭'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','info')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `info` text COMMENT '使用说明'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','remark')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `remark` text");}
if(!pdo_fieldexists('yzcyk_sun_coupon','is_vip')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '仅车友卡vip可以领取'");}
if(!pdo_fieldexists('yzcyk_sun_coupon','is_punch')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon')." ADD   `is_punch` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否打卡奖品 1是'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_coupon_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id',
  `pid` int(10) DEFAULT '0',
  `uid` int(10) DEFAULT NULL,
  `cid` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(10) DEFAULT '0',
  `num` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_coupon_order','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon_order')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'");}
if(!pdo_fieldexists('yzcyk_sun_coupon_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon_order')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('yzcyk_sun_coupon_order','pid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon_order')." ADD   `pid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_coupon_order','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon_order')." ADD   `uid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_coupon_order','cid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon_order')." ADD   `cid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_coupon_order','createtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon_order')." ADD   `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('yzcyk_sun_coupon_order','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon_order')." ADD   `status` tinyint(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_coupon_order','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_coupon_order')." ADD   `num` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_customize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2菜单图标 3底部图标 4好店banner 5门店banner',
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='自定义';

");

if(!pdo_fieldexists('yzcyk_sun_customize','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_customize','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_customize','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2菜单图标 3底部图标 4好店banner 5门店banner'");}
if(!pdo_fieldexists('yzcyk_sun_customize','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '标题名称'");}
if(!pdo_fieldexists('yzcyk_sun_customize','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '图标图片'");}
if(!pdo_fieldexists('yzcyk_sun_customize','clickago_icon')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `clickago_icon` varchar(200) DEFAULT NULL COMMENT '点击前图标'");}
if(!pdo_fieldexists('yzcyk_sun_customize','clickafter_icon')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `clickafter_icon` varchar(200) DEFAULT NULL COMMENT '点击后图标'");}
if(!pdo_fieldexists('yzcyk_sun_customize','url_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `url_type` tinyint(4) DEFAULT NULL COMMENT '链接类型 1基本 2商品分类'");}
if(!pdo_fieldexists('yzcyk_sun_customize','url')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `url` varchar(200) DEFAULT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('yzcyk_sun_customize','url_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `url_name` varchar(50) DEFAULT NULL COMMENT '链接名称'");}
if(!pdo_fieldexists('yzcyk_sun_customize','sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `sort` tinyint(4) DEFAULT NULL COMMENT '排序 越大越前'");}
if(!pdo_fieldexists('yzcyk_sun_customize','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_customize','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_customize')." ADD   `store_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_tel` varchar(20) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销申请';

");

if(!pdo_fieldexists('yzcyk_sun_distribution','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_distribution','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_distribution','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution')." ADD   `time` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_distribution','user_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution')." ADD   `user_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_distribution','user_tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution')." ADD   `user_tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_distribution','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution')." ADD   `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_distribution','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_distribution_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ordertype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类别，1车友卡充值，3活动',
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_distribution_order','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','ordertype')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `ordertype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类别，1车友卡充值，3活动'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `order_id` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '3级id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','first_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','second_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','third_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','rebate')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `rebate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自购，0否，1是'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `user_id` int(11) NOT NULL COMMENT '购买用户id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','is_delete')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（用来识别是否计入可提现佣金），0未，1删'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_order')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_distribution_promoter` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `name` varchar(30) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','mobilephone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `mobilephone` varchar(30) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','allcommission')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `allcommission` decimal(10,2) NOT NULL COMMENT '累计佣金'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','canwithdraw')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `canwithdraw` decimal(10,2) NOT NULL COMMENT '可提现佣金'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','referrer_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `referrer_name` varchar(100) NOT NULL COMMENT '推荐人'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','referrer_uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `referrer_uid` int(11) NOT NULL COMMENT '推荐人id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态，0审核中，1通过，2拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','addtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `addtime` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','checktime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `checktime` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','meno')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `meno` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','form_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id，发模板消息'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','freezemoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现冻结的金额'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_promoter','code_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_promoter')." ADD   `code_img` mediumblob NOT NULL COMMENT '小程序码'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_distribution_set` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_distribution_set','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销层级,0不开启，1一级，2二级'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','is_buyself')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `is_buyself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销内购，0关闭，1开启'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','lower_condition')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `lower_condition` tinyint(1) NOT NULL DEFAULT '0' COMMENT '成为下线条件，0首次点击链接'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','share_condition')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `share_condition` tinyint(3) NOT NULL DEFAULT '0' COMMENT '成为分销商条件，0无条件但要审核，1申请审核，2不需要审核'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','autoshare')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `autoshare` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费自动成为分销商'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','withdrawtype')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `withdrawtype` varchar(100) NOT NULL COMMENT '提现方式,1微信支付,2支付宝支付,3银行卡支付,4余额支付'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','minwithdraw')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `minwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','daymaxwithdraw')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `daymaxwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','withdrawnotice')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `withdrawnotice` text NOT NULL COMMENT '用户提现须知'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','tpl_wd_arrival')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `tpl_wd_arrival` varchar(255) NOT NULL COMMENT '提现到账模板消息id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','tpl_wd_fail')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `tpl_wd_fail` varchar(255) NOT NULL COMMENT '提现失败模板消息id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','tpl_share_check')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `tpl_share_check` varchar(255) NOT NULL COMMENT '分销审核模板消息id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','application')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `application` text NOT NULL COMMENT '申请协议'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','applybanner')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `applybanner` varchar(255) NOT NULL COMMENT '申请页面banner'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','checkbanner')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `checkbanner` varchar(255) NOT NULL COMMENT '待审核页面banner'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','commissiontype')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `commissiontype` tinyint(3) NOT NULL DEFAULT '1' COMMENT '分销佣金类型，1百分比，2固定金额'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','firstname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `firstname` varchar(255) NOT NULL COMMENT '一级名称'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','firstmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','secondname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `secondname` varchar(255) NOT NULL COMMENT '二级名称'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','secondmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','withdrawhandingfee')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `withdrawhandingfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','thirdname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `thirdname` varchar(50) NOT NULL COMMENT '第三级名称'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '第三级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','postertoppic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `postertoppic` varchar(255) NOT NULL COMMENT '海报图'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_set','postertoptitle')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_set')." ADD   `postertoptitle` varchar(200) NOT NULL COMMENT '海报标题'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_distribution_withdraw` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','uname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `uname` varchar(255) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','account')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `account` varchar(20) NOT NULL COMMENT '提现账号'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','withdrawaltype')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `withdrawaltype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现方式，1微信，2支付宝，3银行卡，4余额'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现状态，0待打款，1已经打款，2拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `time` int(11) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','mobilephone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `mobilephone` varchar(30) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','realmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','meno')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `meno` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcyk_sun_distribution_withdraw','form_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_distribution_withdraw')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_dynamic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `head_img` varchar(100) DEFAULT NULL COMMENT '头像',
  `title` varchar(60) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `imgs` text COMMENT '图片',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '关联商品id',
  `is_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0未审核 1通过 2拒绝',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_dynamic','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_dynamic','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic','head_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic')." ADD   `head_img` varchar(100) DEFAULT NULL COMMENT '头像'");}
if(!pdo_fieldexists('yzcyk_sun_dynamic','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic')." ADD   `title` varchar(60) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('yzcyk_sun_dynamic','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic')." ADD   `content` text COMMENT '内容'");}
if(!pdo_fieldexists('yzcyk_sun_dynamic','imgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic')." ADD   `imgs` text COMMENT '图片'");}
if(!pdo_fieldexists('yzcyk_sun_dynamic','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '关联商品id'");}
if(!pdo_fieldexists('yzcyk_sun_dynamic','is_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic')." ADD   `is_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0未审核 1通过 2拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_dynamic','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_dynamic_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `dynamic_id` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `headimg` varchar(200) DEFAULT NULL,
  `is_status` tinyint(4) DEFAULT NULL COMMENT '1 收藏 0 取消收藏',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='动态点赞收藏';

");

if(!pdo_fieldexists('yzcyk_sun_dynamic_collection','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_collection')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_collection','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_collection')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_collection','dynamic_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_collection')." ADD   `dynamic_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_collection','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_collection')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_collection','nickname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_collection')." ADD   `nickname` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_collection','headimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_collection')." ADD   `headimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_collection','is_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_collection')." ADD   `is_status` tinyint(4) DEFAULT NULL COMMENT '1 收藏 0 取消收藏'");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_collection','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_collection')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_dynamic_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `dynamic_id` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `content` text,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='动态评论表';

");

if(!pdo_fieldexists('yzcyk_sun_dynamic_comment','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_comment')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_comment','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_comment')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_comment','dynamic_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_comment')." ADD   `dynamic_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_comment','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_comment')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_comment','nickname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_comment')." ADD   `nickname` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_comment','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_comment')." ADD   `content` text");}
if(!pdo_fieldexists('yzcyk_sun_dynamic_comment','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_dynamic_comment')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_earnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `son_id` int(11) NOT NULL COMMENT '下线',
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金收益表';

");

if(!pdo_fieldexists('yzcyk_sun_earnings','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_earnings')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_earnings','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_earnings')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_earnings','son_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_earnings')." ADD   `son_id` int(11) NOT NULL COMMENT '下线'");}
if(!pdo_fieldexists('yzcyk_sun_earnings','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_earnings')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_earnings','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_earnings')." ADD   `time` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_earnings','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_earnings')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_fabuset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(5) DEFAULT NULL COMMENT '选择类型',
  `price` varchar(15) DEFAULT '0',
  `uniacid` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_fabuset','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fabuset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_fabuset','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fabuset')." ADD   `type` int(5) DEFAULT NULL COMMENT '选择类型'");}
if(!pdo_fieldexists('yzcyk_sun_fabuset','price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fabuset')." ADD   `price` varchar(15) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_fabuset','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fabuset')." ADD   `uniacid` varchar(15) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_fx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `zf_user_id` int(11) NOT NULL COMMENT '转发人ID',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `time` int(11) NOT NULL COMMENT '时间戳',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销表';

");

if(!pdo_fieldexists('yzcyk_sun_fx','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fx')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_fx','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fx')." ADD   `user_id` int(11) NOT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('yzcyk_sun_fx','zf_user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fx')." ADD   `zf_user_id` int(11) NOT NULL COMMENT '转发人ID'");}
if(!pdo_fieldexists('yzcyk_sun_fx','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fx')." ADD   `money` decimal(10,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('yzcyk_sun_fx','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fx')." ADD   `time` int(11) NOT NULL COMMENT '时间戳'");}
if(!pdo_fieldexists('yzcyk_sun_fx','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fx')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_fxset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fx_details` text NOT NULL COMMENT '分销商申请协议',
  `tx_details` text NOT NULL COMMENT '佣金提现协议',
  `is_fx` int(11) NOT NULL COMMENT '1.开启分销审核2.不开启',
  `is_ej` int(11) NOT NULL COMMENT '是否开启二级分销1.是2.否',
  `tx_rate` int(11) NOT NULL COMMENT '提现手续费',
  `commission` varchar(10) NOT NULL COMMENT '一级佣金',
  `commission2` varchar(10) NOT NULL COMMENT '二级佣金',
  `tx_money` int(11) NOT NULL COMMENT '提现门槛',
  `img` varchar(100) NOT NULL COMMENT '分销中心图片',
  `img2` varchar(100) NOT NULL COMMENT '申请分销图片',
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '1' COMMENT '1.开启2关闭',
  `instructions` text NOT NULL COMMENT '分销商说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_fxset','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_fxset','fx_details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `fx_details` text NOT NULL COMMENT '分销商申请协议'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','tx_details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `tx_details` text NOT NULL COMMENT '佣金提现协议'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','is_fx')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `is_fx` int(11) NOT NULL COMMENT '1.开启分销审核2.不开启'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','is_ej')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `is_ej` int(11) NOT NULL COMMENT '是否开启二级分销1.是2.否'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','tx_rate')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `tx_rate` int(11) NOT NULL COMMENT '提现手续费'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','commission')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `commission` varchar(10) NOT NULL COMMENT '一级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','commission2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `commission2` varchar(10) NOT NULL COMMENT '二级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','tx_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `tx_money` int(11) NOT NULL COMMENT '提现门槛'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `img` varchar(100) NOT NULL COMMENT '分销中心图片'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','img2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `img2` varchar(100) NOT NULL COMMENT '申请分销图片'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_fxset','is_open')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `is_open` int(11) NOT NULL DEFAULT '1' COMMENT '1.开启2关闭'");}
if(!pdo_fieldexists('yzcyk_sun_fxset','instructions')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxset')." ADD   `instructions` text NOT NULL COMMENT '分销商说明'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_fxuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '一级分销',
  `fx_user` int(11) NOT NULL COMMENT '二级分销',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_fxuser','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxuser')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_fxuser','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxuser')." ADD   `user_id` int(11) NOT NULL COMMENT '一级分销'");}
if(!pdo_fieldexists('yzcyk_sun_fxuser','fx_user')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxuser')." ADD   `fx_user` int(11) NOT NULL COMMENT '二级分销'");}
if(!pdo_fieldexists('yzcyk_sun_fxuser','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_fxuser')." ADD   `time` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_gift` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id',
  `title` varchar(200) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `content` text NOT NULL COMMENT '文章内容',
  `sort` int(10) DEFAULT '0',
  `hits` int(10) DEFAULT '0',
  `status` tinyint(10) DEFAULT '0',
  `thumb` varchar(200) DEFAULT NULL,
  `thumb2` varchar(200) DEFAULT NULL,
  `pid` int(10) DEFAULT '0',
  `rate` mediumint(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_gift','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'");}
if(!pdo_fieldexists('yzcyk_sun_gift','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('yzcyk_sun_gift','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `title` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_gift','createtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('yzcyk_sun_gift','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `content` text NOT NULL COMMENT '文章内容'");}
if(!pdo_fieldexists('yzcyk_sun_gift','sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `sort` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_gift','hits')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `hits` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_gift','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `status` tinyint(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_gift','thumb')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `thumb` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_gift','thumb2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `thumb2` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_gift','pid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `pid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_gift','rate')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift')." ADD   `rate` mediumint(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_gift_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id',
  `pid` int(10) DEFAULT '0',
  `uid` varchar(100) NOT NULL,
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(10) DEFAULT '0',
  `consignee` varchar(45) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `note` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_gift_order','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift_order')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'");}
if(!pdo_fieldexists('yzcyk_sun_gift_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift_order')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('yzcyk_sun_gift_order','pid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift_order')." ADD   `pid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_gift_order','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift_order')." ADD   `uid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_gift_order','createtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift_order')." ADD   `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('yzcyk_sun_gift_order','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift_order')." ADD   `status` tinyint(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_gift_order','consignee')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift_order')." ADD   `consignee` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_gift_order','tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift_order')." ADD   `tel` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_gift_order','note')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_gift_order')." ADD   `note` varchar(150) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `goods_volume` varchar(45) NOT NULL COMMENT '虚拟销量',
  `sales_num` int(11) NOT NULL DEFAULT '0' COMMENT '销量支付完成',
  `spec_id` int(11) NOT NULL COMMENT '主规格ID',
  `lid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商品营销类别 1普通 2预约 3好物 4拼团 5砍价 6限时购 7分享',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `goods_num` int(11) NOT NULL COMMENT '商品数量',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品售价',
  `pintuan_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '拼团价格',
  `kanjia_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价最低价',
  `qianggou_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '抢购价格',
  `share_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分享赚钱 一级佣金',
  `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分享赚钱 二级佣金',
  `kanjia_percent` int(11) NOT NULL DEFAULT '20' COMMENT '砍价百分比幅度 10代表10%',
  `goods_cost` decimal(10,2) NOT NULL,
  `type_id` int(11) NOT NULL,
  `freight` decimal(10,2) NOT NULL COMMENT '运费',
  `delivery` varchar(500) NOT NULL COMMENT '关于发货',
  `quality` int(4) NOT NULL COMMENT '正品1是,0否',
  `free` int(4) NOT NULL COMMENT '包邮1是,0否',
  `all_day` int(4) NOT NULL COMMENT '24小时发货1是,0否',
  `service` int(4) NOT NULL COMMENT '售后服务1是,0否',
  `refund` int(4) NOT NULL COMMENT '极速退款1是,0否',
  `weeks` int(4) NOT NULL COMMENT '7天包邮1是，0否',
  `lb_imgs` varchar(500) NOT NULL COMMENT '轮播图',
  `imgs` varchar(500) NOT NULL COMMENT '商品介绍图',
  `time` int(11) NOT NULL COMMENT '时间',
  `uniacid` varchar(50) NOT NULL,
  `goods_details` text NOT NULL COMMENT '商品详细',
  `state` int(4) NOT NULL DEFAULT '1' COMMENT '1待审核,2通过，3拒绝',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `pintuan_num` int(11) NOT NULL DEFAULT '1' COMMENT '几人成团',
  `sy_num` int(11) NOT NULL COMMENT '剩余数量',
  `is_show` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `spec_name` varchar(45) NOT NULL,
  `spec_value` varchar(200) NOT NULL,
  `spec_names` varchar(45) NOT NULL,
  `spec_values` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '活动开启 1开启 2关闭',
  `title` varchar(200) DEFAULT NULL COMMENT '好物标题',
  `title_dec` varchar(200) DEFAULT NULL COMMENT '好物小标题',
  `haowuimg` varchar(200) DEFAULT NULL COMMENT '好物展示图',
  `pic` varchar(200) DEFAULT NULL COMMENT '活动商品图',
  `haowu_info` text COMMENT '好物介绍',
  `video` text COMMENT '好物视频介绍',
  `show_index` tinyint(1) DEFAULT '0' COMMENT '是否显示在首页',
  `show_recommend` tinyint(1) DEFAULT '0' COMMENT '展示在推荐列表页',
  `show_columns` tinyint(1) DEFAULT '0' COMMENT '展示在专栏列表页',
  `start_time` int(10) DEFAULT NULL COMMENT '活动开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '活动结束时间',
  `pin_hours` int(11) NOT NULL DEFAULT '24' COMMENT '拼团 下单后结束时间 小时',
  `content` text COMMENT '活动说明',
  `is_deliver` tinyint(4) DEFAULT '0' COMMENT '1自动退款',
  `tag` varchar(255) DEFAULT NULL COMMENT '商品标签',
  `related_gid` int(11) DEFAULT NULL COMMENT '关联商品id  好物和分享',
  `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启',
  `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0百分比，1固定金额',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';

");

if(!pdo_fieldexists('yzcyk_sun_goods','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_goods','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','goods_volume')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `goods_volume` varchar(45) NOT NULL COMMENT '虚拟销量'");}
if(!pdo_fieldexists('yzcyk_sun_goods','sales_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `sales_num` int(11) NOT NULL DEFAULT '0' COMMENT '销量支付完成'");}
if(!pdo_fieldexists('yzcyk_sun_goods','spec_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `spec_id` int(11) NOT NULL COMMENT '主规格ID'");}
if(!pdo_fieldexists('yzcyk_sun_goods','lid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `lid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商品营销类别 1普通 2预约 3好物 4拼团 5砍价 6限时购 7分享'");}
if(!pdo_fieldexists('yzcyk_sun_goods','goods_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `goods_name` varchar(100) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('yzcyk_sun_goods','goods_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `goods_num` int(11) NOT NULL COMMENT '商品数量'");}
if(!pdo_fieldexists('yzcyk_sun_goods','goods_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品售价'");}
if(!pdo_fieldexists('yzcyk_sun_goods','pintuan_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `pintuan_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '拼团价格'");}
if(!pdo_fieldexists('yzcyk_sun_goods','kanjia_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `kanjia_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价最低价'");}
if(!pdo_fieldexists('yzcyk_sun_goods','qianggou_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `qianggou_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '抢购价格'");}
if(!pdo_fieldexists('yzcyk_sun_goods','share_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `share_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分享赚钱 一级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_goods','second_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分享赚钱 二级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_goods','kanjia_percent')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `kanjia_percent` int(11) NOT NULL DEFAULT '20' COMMENT '砍价百分比幅度 10代表10%'");}
if(!pdo_fieldexists('yzcyk_sun_goods','goods_cost')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `goods_cost` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','type_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `type_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','freight')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `freight` decimal(10,2) NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('yzcyk_sun_goods','delivery')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `delivery` varchar(500) NOT NULL COMMENT '关于发货'");}
if(!pdo_fieldexists('yzcyk_sun_goods','quality')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `quality` int(4) NOT NULL COMMENT '正品1是,0否'");}
if(!pdo_fieldexists('yzcyk_sun_goods','free')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `free` int(4) NOT NULL COMMENT '包邮1是,0否'");}
if(!pdo_fieldexists('yzcyk_sun_goods','all_day')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `all_day` int(4) NOT NULL COMMENT '24小时发货1是,0否'");}
if(!pdo_fieldexists('yzcyk_sun_goods','service')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `service` int(4) NOT NULL COMMENT '售后服务1是,0否'");}
if(!pdo_fieldexists('yzcyk_sun_goods','refund')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `refund` int(4) NOT NULL COMMENT '极速退款1是,0否'");}
if(!pdo_fieldexists('yzcyk_sun_goods','weeks')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `weeks` int(4) NOT NULL COMMENT '7天包邮1是，0否'");}
if(!pdo_fieldexists('yzcyk_sun_goods','lb_imgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `lb_imgs` varchar(500) NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('yzcyk_sun_goods','imgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `imgs` varchar(500) NOT NULL COMMENT '商品介绍图'");}
if(!pdo_fieldexists('yzcyk_sun_goods','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `time` int(11) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('yzcyk_sun_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','goods_details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `goods_details` text NOT NULL COMMENT '商品详细'");}
if(!pdo_fieldexists('yzcyk_sun_goods','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `state` int(4) NOT NULL DEFAULT '1' COMMENT '1待审核,2通过，3拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_goods','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '库存'");}
if(!pdo_fieldexists('yzcyk_sun_goods','pintuan_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `pintuan_num` int(11) NOT NULL DEFAULT '1' COMMENT '几人成团'");}
if(!pdo_fieldexists('yzcyk_sun_goods','sy_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `sy_num` int(11) NOT NULL COMMENT '剩余数量'");}
if(!pdo_fieldexists('yzcyk_sun_goods','is_show')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `is_show` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','sales')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `sales` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','spec_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `spec_name` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','spec_value')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `spec_value` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','spec_names')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `spec_names` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','spec_values')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `spec_values` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '活动开启 1开启 2关闭'");}
if(!pdo_fieldexists('yzcyk_sun_goods','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `title` varchar(200) DEFAULT NULL COMMENT '好物标题'");}
if(!pdo_fieldexists('yzcyk_sun_goods','title_dec')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `title_dec` varchar(200) DEFAULT NULL COMMENT '好物小标题'");}
if(!pdo_fieldexists('yzcyk_sun_goods','haowuimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `haowuimg` varchar(200) DEFAULT NULL COMMENT '好物展示图'");}
if(!pdo_fieldexists('yzcyk_sun_goods','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '活动商品图'");}
if(!pdo_fieldexists('yzcyk_sun_goods','haowu_info')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `haowu_info` text COMMENT '好物介绍'");}
if(!pdo_fieldexists('yzcyk_sun_goods','video')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `video` text COMMENT '好物视频介绍'");}
if(!pdo_fieldexists('yzcyk_sun_goods','show_index')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `show_index` tinyint(1) DEFAULT '0' COMMENT '是否显示在首页'");}
if(!pdo_fieldexists('yzcyk_sun_goods','show_recommend')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `show_recommend` tinyint(1) DEFAULT '0' COMMENT '展示在推荐列表页'");}
if(!pdo_fieldexists('yzcyk_sun_goods','show_columns')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `show_columns` tinyint(1) DEFAULT '0' COMMENT '展示在专栏列表页'");}
if(!pdo_fieldexists('yzcyk_sun_goods','start_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `start_time` int(10) DEFAULT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('yzcyk_sun_goods','end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `end_time` int(10) DEFAULT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('yzcyk_sun_goods','pin_hours')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `pin_hours` int(11) NOT NULL DEFAULT '24' COMMENT '拼团 下单后结束时间 小时'");}
if(!pdo_fieldexists('yzcyk_sun_goods','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `content` text COMMENT '活动说明'");}
if(!pdo_fieldexists('yzcyk_sun_goods','is_deliver')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `is_deliver` tinyint(4) DEFAULT '0' COMMENT '1自动退款'");}
if(!pdo_fieldexists('yzcyk_sun_goods','tag')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `tag` varchar(255) DEFAULT NULL COMMENT '商品标签'");}
if(!pdo_fieldexists('yzcyk_sun_goods','related_gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `related_gid` int(11) DEFAULT NULL COMMENT '关联商品id  好物和分享'");}
if(!pdo_fieldexists('yzcyk_sun_goods','distribution_open')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `distribution_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不开启单独分销，1开启'");}
if(!pdo_fieldexists('yzcyk_sun_goods','distribution_commissiontype')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `distribution_commissiontype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0百分比，1固定金额'");}
if(!pdo_fieldexists('yzcyk_sun_goods','firstmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_goods','secondmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_goods','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_goods_spec` (
  `spec_value` varchar(45) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spec_name` varchar(100) NOT NULL COMMENT '规格名称',
  `sort` int(4) NOT NULL COMMENT '排序',
  `uniacid` varchar(50) NOT NULL COMMENT '50',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格表';

");

if(!pdo_fieldexists('yzcyk_sun_goods_spec','spec_value')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods_spec')." ADD 
  `spec_value` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_goods_spec','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods_spec')." ADD   `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_goods_spec','spec_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods_spec')." ADD   `spec_name` varchar(100) NOT NULL COMMENT '规格名称'");}
if(!pdo_fieldexists('yzcyk_sun_goods_spec','sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods_spec')." ADD   `sort` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_goods_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_goods_spec')." ADD   `uniacid` varchar(50) NOT NULL COMMENT '50'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(100) DEFAULT NULL COMMENT '商品名',
  `marketprice` decimal(10,2) DEFAULT NULL COMMENT '原价',
  `selftime` varchar(100) DEFAULT NULL COMMENT '发布时间',
  `pic` varchar(200) DEFAULT NULL COMMENT '活动图',
  `details` text COMMENT '商品详情',
  `status` int(11) DEFAULT NULL COMMENT '状态 1为开启2为关闭',
  `uniacid` int(11) DEFAULT NULL,
  `starttime` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `shopprice` decimal(10,2) DEFAULT NULL COMMENT '最低价',
  `endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `num` int(11) DEFAULT '0' COMMENT '数量',
  `pintuan_num` int(11) DEFAULT '0',
  `content` text COMMENT '活动详情',
  `groups_num` int(11) DEFAULT NULL COMMENT '几人成团',
  `is_deliver` int(2) DEFAULT '0' COMMENT '1为自动退款2为否',
  `showindex` tinyint(1) DEFAULT '0' COMMENT '1显示在首页',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_groups','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_groups','gname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `gname` varchar(100) DEFAULT NULL COMMENT '商品名'");}
if(!pdo_fieldexists('yzcyk_sun_groups','marketprice')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `marketprice` decimal(10,2) DEFAULT NULL COMMENT '原价'");}
if(!pdo_fieldexists('yzcyk_sun_groups','selftime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `selftime` varchar(100) DEFAULT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('yzcyk_sun_groups','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '活动图'");}
if(!pdo_fieldexists('yzcyk_sun_groups','details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `details` text COMMENT '商品详情'");}
if(!pdo_fieldexists('yzcyk_sun_groups','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `status` int(11) DEFAULT NULL COMMENT '状态 1为开启2为关闭'");}
if(!pdo_fieldexists('yzcyk_sun_groups','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_groups','starttime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `starttime` timestamp NULL DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('yzcyk_sun_groups','shopprice')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `shopprice` decimal(10,2) DEFAULT NULL COMMENT '最低价'");}
if(!pdo_fieldexists('yzcyk_sun_groups','endtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('yzcyk_sun_groups','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `num` int(11) DEFAULT '0' COMMENT '数量'");}
if(!pdo_fieldexists('yzcyk_sun_groups','pintuan_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `pintuan_num` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_groups','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `content` text COMMENT '活动详情'");}
if(!pdo_fieldexists('yzcyk_sun_groups','groups_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `groups_num` int(11) DEFAULT NULL COMMENT '几人成团'");}
if(!pdo_fieldexists('yzcyk_sun_groups','is_deliver')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `is_deliver` int(2) DEFAULT '0' COMMENT '1为自动退款2为否'");}
if(!pdo_fieldexists('yzcyk_sun_groups','showindex')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_groups')." ADD   `showindex` tinyint(1) DEFAULT '0' COMMENT '1显示在首页'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_hblq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `tz_id` int(11) NOT NULL COMMENT '帖子ID',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `time` int(11) NOT NULL COMMENT '时间戳',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包领取表';

");

if(!pdo_fieldexists('yzcyk_sun_hblq','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hblq')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_hblq','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hblq')." ADD   `user_id` int(11) NOT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('yzcyk_sun_hblq','tz_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hblq')." ADD   `tz_id` int(11) NOT NULL COMMENT '帖子ID'");}
if(!pdo_fieldexists('yzcyk_sun_hblq','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hblq')." ADD   `money` decimal(10,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('yzcyk_sun_hblq','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hblq')." ADD   `time` int(11) NOT NULL COMMENT '时间戳'");}
if(!pdo_fieldexists('yzcyk_sun_hblq','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hblq')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL COMMENT '标题',
  `answer` text NOT NULL COMMENT '回答',
  `sort` int(4) NOT NULL COMMENT '排序',
  `uniacid` varchar(50) NOT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_help','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_help')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_help','question')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_help')." ADD   `question` varchar(200) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('yzcyk_sun_help','answer')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_help')." ADD   `answer` text NOT NULL COMMENT '回答'");}
if(!pdo_fieldexists('yzcyk_sun_help','sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_help')." ADD   `sort` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_help','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_help')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_help','created_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_help')." ADD   `created_time` datetime NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_hotcity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cityname` varchar(50) NOT NULL COMMENT '城市名称',
  `time` int(11) NOT NULL COMMENT '创建时间',
  `uniacid` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_hotcity','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hotcity')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_hotcity','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hotcity')." ADD   `cityname` varchar(50) NOT NULL COMMENT '城市名称'");}
if(!pdo_fieldexists('yzcyk_sun_hotcity','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hotcity')." ADD   `time` int(11) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('yzcyk_sun_hotcity','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hotcity')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_hotcity','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hotcity')." ADD   `user_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_hxstaff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `store_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='核销人员';

");

if(!pdo_fieldexists('yzcyk_sun_hxstaff','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hxstaff')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_hxstaff','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hxstaff')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_hxstaff','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hxstaff')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_hxstaff','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hxstaff')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_hxstaff','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hxstaff')." ADD   `type` tinyint(4) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_hxstaff','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_hxstaff')." ADD   `store_id` int(11) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `details` text NOT NULL COMMENT '内容',
  `img` text NOT NULL COMMENT '图片',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `user_name` varchar(20) NOT NULL COMMENT '联系人',
  `user_tel` varchar(20) NOT NULL COMMENT '电话',
  `hot` int(11) NOT NULL COMMENT '1.热门 2.不热门',
  `top` int(11) NOT NULL COMMENT '1.置顶 2.不置顶',
  `givelike` int(11) NOT NULL COMMENT '点赞数',
  `views` int(11) NOT NULL COMMENT '浏览量',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `type2_id` int(11) NOT NULL COMMENT '分类二id',
  `type_id` int(11) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.待审核 2.通过3拒绝',
  `money` decimal(10,2) NOT NULL,
  `time` int(11) NOT NULL COMMENT '发布时间',
  `sh_time` int(11) NOT NULL,
  `top_type` int(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `hb_money` decimal(10,2) NOT NULL,
  `hb_num` int(11) NOT NULL,
  `hb_type` int(11) NOT NULL,
  `hb_keyword` varchar(20) NOT NULL,
  `hb_random` int(11) NOT NULL,
  `hong` text NOT NULL,
  `store_id` int(11) NOT NULL,
  `del` int(11) NOT NULL DEFAULT '2',
  `user_img2` varchar(100) NOT NULL,
  `dq_time` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `hbfx_num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_information','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_information','details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `details` text NOT NULL COMMENT '内容'");}
if(!pdo_fieldexists('yzcyk_sun_information','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `img` text NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzcyk_sun_information','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcyk_sun_information','user_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `user_name` varchar(20) NOT NULL COMMENT '联系人'");}
if(!pdo_fieldexists('yzcyk_sun_information','user_tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `user_tel` varchar(20) NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('yzcyk_sun_information','hot')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `hot` int(11) NOT NULL COMMENT '1.热门 2.不热门'");}
if(!pdo_fieldexists('yzcyk_sun_information','top')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `top` int(11) NOT NULL COMMENT '1.置顶 2.不置顶'");}
if(!pdo_fieldexists('yzcyk_sun_information','givelike')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `givelike` int(11) NOT NULL COMMENT '点赞数'");}
if(!pdo_fieldexists('yzcyk_sun_information','views')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `views` int(11) NOT NULL COMMENT '浏览量'");}
if(!pdo_fieldexists('yzcyk_sun_information','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzcyk_sun_information','type2_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `type2_id` int(11) NOT NULL COMMENT '分类二id'");}
if(!pdo_fieldexists('yzcyk_sun_information','type_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `type_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `state` int(11) NOT NULL COMMENT '1.待审核 2.通过3拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_information','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `time` int(11) NOT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('yzcyk_sun_information','sh_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `sh_time` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','top_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `top_type` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `address` varchar(500) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','hb_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `hb_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','hb_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `hb_num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','hb_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `hb_type` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','hb_keyword')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `hb_keyword` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','hb_random')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `hb_random` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','hong')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `hong` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','del')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `del` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcyk_sun_information','user_img2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `user_img2` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','dq_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `dq_time` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_information','hbfx_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_information')." ADD   `hbfx_num` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_name` varchar(20) NOT NULL,
  `type2_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_label','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_label')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_label','label_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_label')." ADD   `label_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_label','type2_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_label')." ADD   `type2_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL COMMENT '帖子id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `zx_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_like','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_like')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_like','information_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_like')." ADD   `information_id` int(11) NOT NULL COMMENT '帖子id'");}
if(!pdo_fieldexists('yzcyk_sun_like','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_like')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcyk_sun_like','zx_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_like')." ADD   `zx_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_mercapdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL COMMENT '商家id',
  `store_name` varchar(100) DEFAULT NULL COMMENT '商家名称',
  `mcd_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现方式 1订单收入 2微信提现 3审核失败',
  `openid` varchar(30) DEFAULT NULL COMMENT '订单收入支付的openid|提现给的openid',
  `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少',
  `mcd_memo` text COMMENT '相关详细信息',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '全额 订单收入全额 提现全额',
  `realmoney` decimal(10,2) NOT NULL,
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现支付给平台佣金',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费',
  `order_id` int(11) DEFAULT NULL COMMENT '订单收入id',
  `wd_id` int(11) DEFAULT NULL COMMENT '提现id',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1成功 2失败 提现可能会失败',
  `add_time` int(11) DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_mercapdetails','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `store_id` int(11) DEFAULT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','store_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `store_name` varchar(100) DEFAULT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','mcd_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `mcd_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现方式 1订单收入 2微信提现 3审核失败'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `openid` varchar(30) DEFAULT NULL COMMENT '订单收入支付的openid|提现给的openid'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','sign')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','mcd_memo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `mcd_memo` text COMMENT '相关详细信息'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '全额 订单收入全额 提现全额'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','realmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `realmoney` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','paycommission')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现支付给平台佣金'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `order_id` int(11) DEFAULT NULL COMMENT '订单收入id'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','wd_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `wd_id` int(11) DEFAULT NULL COMMENT '提现id'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1成功 2失败 提现可能会失败'");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_mercapdetails','del_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mercapdetails')." ADD   `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_mylabel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` int(11) NOT NULL,
  `information_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_mylabel','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mylabel')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_mylabel','label_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mylabel')." ADD   `label_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_mylabel','information_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_mylabel')." ADD   `information_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '公告标题',
  `details` text NOT NULL COMMENT '公告详情',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `state` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_news','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_news','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD   `title` varchar(50) NOT NULL COMMENT '公告标题'");}
if(!pdo_fieldexists('yzcyk_sun_news','details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD   `details` text NOT NULL COMMENT '公告详情'");}
if(!pdo_fieldexists('yzcyk_sun_news','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_news','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_news','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD   `time` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_news','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD   `img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_news','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD   `state` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_news','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD   `type` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_news','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_news')." ADD   `cityname` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `orderformid` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `good_total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品金额',
  `good_total_num` int(11) NOT NULL DEFAULT '1' COMMENT '商品数量',
  `activity_id` int(11) DEFAULT NULL COMMENT '活动id',
  `baby_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `sincetype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '配送方式 1上门自提',
  `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `coupon_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券优惠金额',
  `order_lid` tinyint(4) DEFAULT NULL COMMENT '订单类型 1车友卡充值续费 2车友卡免费领取 3活动报名 4活动入驻',
  `qzk_type` tinyint(4) DEFAULT NULL COMMENT '车友卡类型 1年',
  `pay_type` tinyint(4) DEFAULT NULL COMMENT '支付方式 1微信支付  2免费领取',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1支付',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0待付款 1待发货(待使用) 2待确认 3已完成 4退款中 5已退款 6退款拒绝7取消订单',
  `queren_time` int(11) DEFAULT NULL COMMENT '确认时间',
  `add_time` int(11) DEFAULT NULL,
  `prepay_id` varchar(60) DEFAULT NULL COMMENT '统一下单标识',
  `qrcode_path` varchar(100) DEFAULT NULL COMMENT '核销二维码',
  `hx_openid` varchar(60) DEFAULT NULL COMMENT '核销人员openid',
  `hx_time` int(11) DEFAULT NULL COMMENT '核销时间',
  `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 1已删除',
  `cancel_time` int(11) DEFAULT NULL COMMENT '取消时间',
  `del_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `store_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '门店id',
  `storelimit_id` int(11) DEFAULT NULL COMMENT '入驻价格id',
  `parent_id_1` int(11) NOT NULL DEFAULT '0',
  `parent_id_2` int(11) NOT NULL DEFAULT '0',
  `parent_id_3` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COMMENT='订单';

");

if(!pdo_fieldexists('yzcyk_sun_order','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order','orderformid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `orderformid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order','transaction_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `transaction_id` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order','order_amount')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额'");}
if(!pdo_fieldexists('yzcyk_sun_order','good_total_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `good_total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品金额'");}
if(!pdo_fieldexists('yzcyk_sun_order','good_total_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `good_total_num` int(11) NOT NULL DEFAULT '1' COMMENT '商品数量'");}
if(!pdo_fieldexists('yzcyk_sun_order','activity_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `activity_id` int(11) DEFAULT NULL COMMENT '活动id'");}
if(!pdo_fieldexists('yzcyk_sun_order','baby_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `baby_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `name` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order','phone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `phone` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order','sincetype')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `sincetype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '配送方式 1上门自提'");}
if(!pdo_fieldexists('yzcyk_sun_order','distribution')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费'");}
if(!pdo_fieldexists('yzcyk_sun_order','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id'");}
if(!pdo_fieldexists('yzcyk_sun_order','coupon_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `coupon_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券优惠金额'");}
if(!pdo_fieldexists('yzcyk_sun_order','order_lid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `order_lid` tinyint(4) DEFAULT NULL COMMENT '订单类型 1车友卡充值续费 2车友卡免费领取 3活动报名 4活动入驻'");}
if(!pdo_fieldexists('yzcyk_sun_order','qzk_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `qzk_type` tinyint(4) DEFAULT NULL COMMENT '车友卡类型 1年'");}
if(!pdo_fieldexists('yzcyk_sun_order','pay_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `pay_type` tinyint(4) DEFAULT NULL COMMENT '支付方式 1微信支付  2免费领取'");}
if(!pdo_fieldexists('yzcyk_sun_order','pay_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1支付'");}
if(!pdo_fieldexists('yzcyk_sun_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `pay_time` int(11) DEFAULT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('yzcyk_sun_order','order_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0待付款 1待发货(待使用) 2待确认 3已完成 4退款中 5已退款 6退款拒绝7取消订单'");}
if(!pdo_fieldexists('yzcyk_sun_order','queren_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `queren_time` int(11) DEFAULT NULL COMMENT '确认时间'");}
if(!pdo_fieldexists('yzcyk_sun_order','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order','prepay_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `prepay_id` varchar(60) DEFAULT NULL COMMENT '统一下单标识'");}
if(!pdo_fieldexists('yzcyk_sun_order','qrcode_path')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `qrcode_path` varchar(100) DEFAULT NULL COMMENT '核销二维码'");}
if(!pdo_fieldexists('yzcyk_sun_order','hx_openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `hx_openid` varchar(60) DEFAULT NULL COMMENT '核销人员openid'");}
if(!pdo_fieldexists('yzcyk_sun_order','hx_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `hx_time` int(11) DEFAULT NULL COMMENT '核销时间'");}
if(!pdo_fieldexists('yzcyk_sun_order','del_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 1已删除'");}
if(!pdo_fieldexists('yzcyk_sun_order','cancel_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `cancel_time` int(11) DEFAULT NULL COMMENT '取消时间'");}
if(!pdo_fieldexists('yzcyk_sun_order','del_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `del_time` int(11) DEFAULT NULL COMMENT '删除时间'");}
if(!pdo_fieldexists('yzcyk_sun_order','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `store_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '门店id'");}
if(!pdo_fieldexists('yzcyk_sun_order','storelimit_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `storelimit_id` int(11) DEFAULT NULL COMMENT '入驻价格id'");}
if(!pdo_fieldexists('yzcyk_sun_order','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `parent_id_1` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_order','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `parent_id_2` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_order','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order')." ADD   `parent_id_3` int(11) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_order1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` text NOT NULL,
  `store_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `user_name` varchar(20) NOT NULL COMMENT '联系人',
  `address` varchar(200) NOT NULL COMMENT '联系地址',
  `tel` varchar(20) NOT NULL COMMENT '电话',
  `time` int(11) NOT NULL COMMENT '下单时间',
  `pay_time` int(11) NOT NULL,
  `complete_time` int(11) NOT NULL,
  `fh_time` int(11) NOT NULL COMMENT '发货时间',
  `state` int(11) NOT NULL COMMENT '1.待付款 2.待发货3.待确认4.已完成5.退款中6.已退款7.退款拒绝',
  `order_num` varchar(20) NOT NULL COMMENT '订单号',
  `good_id` varchar(45) NOT NULL,
  `good_name` varchar(200) NOT NULL,
  `good_img` varchar(400) NOT NULL,
  `good_money` varchar(100) NOT NULL,
  `out_trade_no` varchar(50) NOT NULL,
  `good_spec` varchar(200) NOT NULL COMMENT '商品规格',
  `del` int(11) NOT NULL COMMENT '用户删除1是  2否 ',
  `del2` int(11) NOT NULL COMMENT '商家删除1.是2.否',
  `uniacid` int(11) NOT NULL,
  `freight` decimal(10,2) NOT NULL,
  `note` varchar(100) NOT NULL,
  `good_num` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

");

if(!pdo_fieldexists('yzcyk_sun_order1','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_order1','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `user_id` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `money` decimal(10,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('yzcyk_sun_order1','user_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `user_name` varchar(20) NOT NULL COMMENT '联系人'");}
if(!pdo_fieldexists('yzcyk_sun_order1','address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `address` varchar(200) NOT NULL COMMENT '联系地址'");}
if(!pdo_fieldexists('yzcyk_sun_order1','tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `tel` varchar(20) NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('yzcyk_sun_order1','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `time` int(11) NOT NULL COMMENT '下单时间'");}
if(!pdo_fieldexists('yzcyk_sun_order1','pay_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `pay_time` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','complete_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `complete_time` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','fh_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `fh_time` int(11) NOT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('yzcyk_sun_order1','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `state` int(11) NOT NULL COMMENT '1.待付款 2.待发货3.待确认4.已完成5.退款中6.已退款7.退款拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_order1','order_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `order_num` varchar(20) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('yzcyk_sun_order1','good_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `good_id` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','good_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `good_name` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','good_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `good_img` varchar(400) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','good_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `good_money` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','out_trade_no')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `out_trade_no` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','good_spec')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `good_spec` varchar(200) NOT NULL COMMENT '商品规格'");}
if(!pdo_fieldexists('yzcyk_sun_order1','del')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `del` int(11) NOT NULL COMMENT '用户删除1是  2否 '");}
if(!pdo_fieldexists('yzcyk_sun_order1','del2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `del2` int(11) NOT NULL COMMENT '商家删除1.是2.否'");}
if(!pdo_fieldexists('yzcyk_sun_order1','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','freight')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `freight` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','note')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `note` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order1','good_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order1')." ADD   `good_num` varchar(45) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_order2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` varchar(60) NOT NULL,
  `cid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '下单方式 0直接下单 1购物车下单',
  `crid` varchar(255) DEFAULT NULL COMMENT '多个商品id',
  `orderformid` varchar(50) DEFAULT NULL COMMENT '订单号',
  `order_lid` tinyint(4) DEFAULT '1' COMMENT '订单类别 1普通订单 2预约订单 3好物 4拼团 5 砍价 6限时购 7分享 8到店买单',
  `pin_buy_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '拼团商品 购买方式  0直接购买 1拼团购买',
  `pin_mch_id` int(11) NOT NULL DEFAULT '0' COMMENT '拼团 0 位拼主 其他值为跟团id (user_groups的id)',
  `pin_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '拼单为拼主的订单id 0为拼主(仅拼单的拼团购买有效)',
  `transaction_id` varchar(50) DEFAULT NULL,
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `good_total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总金额',
  `good_total_num` int(11) NOT NULL DEFAULT '0' COMMENT '商品总数量',
  `sincetype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '配送方式 1送货上门(快递) 2上门自提',
  `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费(快递费)',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `coupon_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券优惠金额',
  `name` varchar(60) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(60) DEFAULT NULL COMMENT '手机',
  `postalcode` varchar(20) DEFAULT NULL COMMENT '邮政编码',
  `province` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `zip` varchar(30) DEFAULT NULL COMMENT '区县',
  `address` varchar(150) DEFAULT NULL COMMENT '地址',
  `ziti_phone` varchar(60) DEFAULT NULL COMMENT '自提电话',
  `yuyue_name` varchar(60) DEFAULT NULL COMMENT 'order_lid为2生效  预约人姓名',
  `yuyue_phone` varchar(30) DEFAULT NULL COMMENT '预约人电话',
  `yuyue_time` varchar(60) DEFAULT NULL COMMENT '预约人时间',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `add_time` int(11) NOT NULL COMMENT '下单时间',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1支付',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0待付款 1待发货 2待确认 3已完成 4退款中 5已退款 6退款拒绝7取消订单',
  `fahuo_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `queren_time` int(11) DEFAULT NULL COMMENT '确认收货时间',
  `cancel_time` int(11) DEFAULT NULL COMMENT '订单取消时间',
  `refund_application_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未申请退款 1已申请退款',
  `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 退款申请失败 |1退款申请成功(退款处理中) |2退款成功|3退款失败',
  `refund_time` int(11) DEFAULT NULL COMMENT '退款时间',
  `tuikuanformid` varchar(50) DEFAULT NULL COMMENT '退款订单号',
  `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 0未删除 1 用户删除 2商家删除',
  `del_time` int(11) DEFAULT NULL COMMENT '订单删除时间',
  `is_pingjia` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评价 1已评价',
  `share_deduction` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分享金抵扣',
  `prepay_id` varchar(60) DEFAULT NULL COMMENT '统一下单标识 消息模板使用',
  `qrcode_path` varchar(100) DEFAULT NULL COMMENT '核销二维码',
  `hx_openid` varchar(60) DEFAULT NULL COMMENT '核销人员openid',
  `hx_time` int(11) DEFAULT NULL COMMENT '核销时间',
  `express_delivery` varchar(60) DEFAULT NULL COMMENT '快递',
  `express_orderformid` varchar(60) DEFAULT NULL COMMENT '快递单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_order2','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_order2','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order2','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `uid` varchar(60) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order2','cid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `cid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '下单方式 0直接下单 1购物车下单'");}
if(!pdo_fieldexists('yzcyk_sun_order2','crid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `crid` varchar(255) DEFAULT NULL COMMENT '多个商品id'");}
if(!pdo_fieldexists('yzcyk_sun_order2','orderformid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `orderformid` varchar(50) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('yzcyk_sun_order2','order_lid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `order_lid` tinyint(4) DEFAULT '1' COMMENT '订单类别 1普通订单 2预约订单 3好物 4拼团 5 砍价 6限时购 7分享 8到店买单'");}
if(!pdo_fieldexists('yzcyk_sun_order2','pin_buy_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `pin_buy_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '拼团商品 购买方式  0直接购买 1拼团购买'");}
if(!pdo_fieldexists('yzcyk_sun_order2','pin_mch_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `pin_mch_id` int(11) NOT NULL DEFAULT '0' COMMENT '拼团 0 位拼主 其他值为跟团id (user_groups的id)'");}
if(!pdo_fieldexists('yzcyk_sun_order2','pin_order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `pin_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '拼单为拼主的订单id 0为拼主(仅拼单的拼团购买有效)'");}
if(!pdo_fieldexists('yzcyk_sun_order2','transaction_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `transaction_id` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order2','order_amount')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额'");}
if(!pdo_fieldexists('yzcyk_sun_order2','good_total_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `good_total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总金额'");}
if(!pdo_fieldexists('yzcyk_sun_order2','good_total_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `good_total_num` int(11) NOT NULL DEFAULT '0' COMMENT '商品总数量'");}
if(!pdo_fieldexists('yzcyk_sun_order2','sincetype')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `sincetype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '配送方式 1送货上门(快递) 2上门自提'");}
if(!pdo_fieldexists('yzcyk_sun_order2','distribution')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费(快递费)'");}
if(!pdo_fieldexists('yzcyk_sun_order2','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id'");}
if(!pdo_fieldexists('yzcyk_sun_order2','coupon_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `coupon_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券优惠金额'");}
if(!pdo_fieldexists('yzcyk_sun_order2','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `name` varchar(60) DEFAULT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('yzcyk_sun_order2','phone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `phone` varchar(60) DEFAULT NULL COMMENT '手机'");}
if(!pdo_fieldexists('yzcyk_sun_order2','postalcode')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `postalcode` varchar(20) DEFAULT NULL COMMENT '邮政编码'");}
if(!pdo_fieldexists('yzcyk_sun_order2','province')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `province` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order2','city')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `city` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order2','zip')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `zip` varchar(30) DEFAULT NULL COMMENT '区县'");}
if(!pdo_fieldexists('yzcyk_sun_order2','address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `address` varchar(150) DEFAULT NULL COMMENT '地址'");}
if(!pdo_fieldexists('yzcyk_sun_order2','ziti_phone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `ziti_phone` varchar(60) DEFAULT NULL COMMENT '自提电话'");}
if(!pdo_fieldexists('yzcyk_sun_order2','yuyue_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `yuyue_name` varchar(60) DEFAULT NULL COMMENT 'order_lid为2生效  预约人姓名'");}
if(!pdo_fieldexists('yzcyk_sun_order2','yuyue_phone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `yuyue_phone` varchar(30) DEFAULT NULL COMMENT '预约人电话'");}
if(!pdo_fieldexists('yzcyk_sun_order2','yuyue_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `yuyue_time` varchar(60) DEFAULT NULL COMMENT '预约人时间'");}
if(!pdo_fieldexists('yzcyk_sun_order2','remark')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `remark` varchar(200) DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('yzcyk_sun_order2','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `add_time` int(11) NOT NULL COMMENT '下单时间'");}
if(!pdo_fieldexists('yzcyk_sun_order2','pay_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `pay_time` int(11) DEFAULT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('yzcyk_sun_order2','pay_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 1支付'");}
if(!pdo_fieldexists('yzcyk_sun_order2','order_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0待付款 1待发货 2待确认 3已完成 4退款中 5已退款 6退款拒绝7取消订单'");}
if(!pdo_fieldexists('yzcyk_sun_order2','fahuo_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `fahuo_time` int(11) DEFAULT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('yzcyk_sun_order2','queren_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `queren_time` int(11) DEFAULT NULL COMMENT '确认收货时间'");}
if(!pdo_fieldexists('yzcyk_sun_order2','cancel_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `cancel_time` int(11) DEFAULT NULL COMMENT '订单取消时间'");}
if(!pdo_fieldexists('yzcyk_sun_order2','refund_application_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `refund_application_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未申请退款 1已申请退款'");}
if(!pdo_fieldexists('yzcyk_sun_order2','refund_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `refund_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 退款申请失败 |1退款申请成功(退款处理中) |2退款成功|3退款失败'");}
if(!pdo_fieldexists('yzcyk_sun_order2','refund_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `refund_time` int(11) DEFAULT NULL COMMENT '退款时间'");}
if(!pdo_fieldexists('yzcyk_sun_order2','tuikuanformid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `tuikuanformid` varchar(50) DEFAULT NULL COMMENT '退款订单号'");}
if(!pdo_fieldexists('yzcyk_sun_order2','del_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态 0未删除 1 用户删除 2商家删除'");}
if(!pdo_fieldexists('yzcyk_sun_order2','del_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `del_time` int(11) DEFAULT NULL COMMENT '订单删除时间'");}
if(!pdo_fieldexists('yzcyk_sun_order2','is_pingjia')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `is_pingjia` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评价 1已评价'");}
if(!pdo_fieldexists('yzcyk_sun_order2','share_deduction')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `share_deduction` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分享金抵扣'");}
if(!pdo_fieldexists('yzcyk_sun_order2','prepay_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `prepay_id` varchar(60) DEFAULT NULL COMMENT '统一下单标识 消息模板使用'");}
if(!pdo_fieldexists('yzcyk_sun_order2','qrcode_path')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `qrcode_path` varchar(100) DEFAULT NULL COMMENT '核销二维码'");}
if(!pdo_fieldexists('yzcyk_sun_order2','hx_openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `hx_openid` varchar(60) DEFAULT NULL COMMENT '核销人员openid'");}
if(!pdo_fieldexists('yzcyk_sun_order2','hx_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `hx_time` int(11) DEFAULT NULL COMMENT '核销时间'");}
if(!pdo_fieldexists('yzcyk_sun_order2','express_delivery')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `express_delivery` varchar(60) DEFAULT NULL COMMENT '快递'");}
if(!pdo_fieldexists('yzcyk_sun_order2','express_orderformid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order2')." ADD   `express_orderformid` varchar(60) DEFAULT NULL COMMENT '快递单号'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `activity_id` int(11) DEFAULT NULL COMMENT '活动id',
  `title` varchar(100) DEFAULT NULL COMMENT '活动名称',
  `common_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '普通价',
  `qzk_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '车友价',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `num` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_order_detail','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','activity_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `activity_id` int(11) DEFAULT NULL COMMENT '活动id'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `title` varchar(100) DEFAULT NULL COMMENT '活动名称'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','common_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `common_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '普通价'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','qzk_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `qzk_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '车友价'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','unit_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','total_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `total_price` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `pic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail')." ADD   `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_order_detail1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `uniacid` int(11) NOT NULL,
  `uid` varchar(60) NOT NULL,
  `gid` int(11) DEFAULT NULL COMMENT '商品id',
  `gname` varchar(60) DEFAULT NULL COMMENT '商品名称',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `combine` varchar(100) DEFAULT NULL COMMENT '规格组合',
  `spec_value` varchar(30) DEFAULT NULL COMMENT '规格1',
  `spec_value1` varchar(30) DEFAULT NULL COMMENT '规格2',
  `pic` varchar(100) DEFAULT NULL COMMENT '图片',
  `add_time` int(11) DEFAULT NULL,
  `is_pingjia` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_order_detail1','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `order_id` int(11) DEFAULT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `uid` varchar(60) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `gid` int(11) DEFAULT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','gname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `gname` varchar(60) DEFAULT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','unit_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','total_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','combine')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `combine` varchar(100) DEFAULT NULL COMMENT '规格组合'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','spec_value')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `spec_value` varchar(30) DEFAULT NULL COMMENT '规格1'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','spec_value1')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `spec_value1` varchar(30) DEFAULT NULL COMMENT '规格2'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `pic` varchar(100) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_order_detail1','is_pingjia')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_order_detail1')." ADD   `is_pingjia` tinyint(4) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_paylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL COMMENT '外键id(商家,帖子,黄页,拼车)',
  `money` decimal(10,2) NOT NULL COMMENT '钱',
  `time` datetime NOT NULL COMMENT '时间',
  `uniacid` varchar(50) NOT NULL COMMENT '50',
  `note` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付记录表';

");

if(!pdo_fieldexists('yzcyk_sun_paylog','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_paylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_paylog','fid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_paylog')." ADD   `fid` int(11) NOT NULL COMMENT '外键id(商家,帖子,黄页,拼车)'");}
if(!pdo_fieldexists('yzcyk_sun_paylog','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_paylog')." ADD   `money` decimal(10,2) NOT NULL COMMENT '钱'");}
if(!pdo_fieldexists('yzcyk_sun_paylog','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_paylog')." ADD   `time` datetime NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('yzcyk_sun_paylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_paylog')." ADD   `uniacid` varchar(50) NOT NULL COMMENT '50'");}
if(!pdo_fieldexists('yzcyk_sun_paylog','note')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_paylog')." ADD   `note` varchar(100) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_pingjia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` varchar(60) DEFAULT NULL,
  `order_id` int(60) DEFAULT NULL,
  `order_detail_id` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `imgs` text,
  `content` text,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单评价';

");

if(!pdo_fieldexists('yzcyk_sun_pingjia','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_pingjia','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_pingjia','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD   `uid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_pingjia','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD   `order_id` int(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_pingjia','order_detail_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD   `order_detail_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_pingjia','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_pingjia','stars')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD   `stars` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_pingjia','imgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD   `imgs` text");}
if(!pdo_fieldexists('yzcyk_sun_pingjia','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD   `content` text");}
if(!pdo_fieldexists('yzcyk_sun_pingjia','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_pingjia')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_platform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `total_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计申请提现金额',
  `total_realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计提现金额',
  `total_paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计平台佣金',
  `total_ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计手续费用',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_platform','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_platform')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_platform','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_platform')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_platform','total_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_platform')." ADD   `total_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计申请提现金额'");}
if(!pdo_fieldexists('yzcyk_sun_platform','total_realmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_platform')." ADD   `total_realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计提现金额'");}
if(!pdo_fieldexists('yzcyk_sun_platform','total_paycommission')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_platform')." ADD   `total_paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计平台佣金'");}
if(!pdo_fieldexists('yzcyk_sun_platform','total_ratesmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_platform')." ADD   `total_ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计手续费用'");}
if(!pdo_fieldexists('yzcyk_sun_platform','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_platform')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_privilege_identifier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `pic` varchar(200) DEFAULT NULL COMMENT '图片',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='特权标识';

");

if(!pdo_fieldexists('yzcyk_sun_privilege_identifier','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_privilege_identifier')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_privilege_identifier','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_privilege_identifier')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_privilege_identifier','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_privilege_identifier')." ADD   `title` varchar(200) DEFAULT NULL COMMENT '标题'");}
if(!pdo_fieldexists('yzcyk_sun_privilege_identifier','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_privilege_identifier')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzcyk_sun_privilege_identifier','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_privilege_identifier')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_punch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL COMMENT '任务标题',
  `pic` varchar(200) DEFAULT NULL COMMENT '展示图标',
  `remark` text COMMENT '任务描述',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务信息表';

");

if(!pdo_fieldexists('yzcyk_sun_punch','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_punch','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch')." ADD   `title` varchar(60) DEFAULT NULL COMMENT '任务标题'");}
if(!pdo_fieldexists('yzcyk_sun_punch','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '展示图标'");}
if(!pdo_fieldexists('yzcyk_sun_punch','remark')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch')." ADD   `remark` text COMMENT '任务描述'");}
if(!pdo_fieldexists('yzcyk_sun_punch','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_punch_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `punch_id` int(11) DEFAULT NULL COMMENT '任务id',
  `task_day_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT '任务天数1 一周 2 15天 3一个月 4 一个季度 5一年',
  `prize_day` int(11) DEFAULT NULL COMMENT '奖品天数',
  `store_id` int(11) NOT NULL DEFAULT '0',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='打卡奖品';

");

if(!pdo_fieldexists('yzcyk_sun_punch_prize','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_prize')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_punch_prize','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_prize')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_prize','punch_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_prize')." ADD   `punch_id` int(11) DEFAULT NULL COMMENT '任务id'");}
if(!pdo_fieldexists('yzcyk_sun_punch_prize','task_day_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_prize')." ADD   `task_day_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT '任务天数1 一周 2 15天 3一个月 4 一个季度 5一年'");}
if(!pdo_fieldexists('yzcyk_sun_punch_prize','prize_day')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_prize')." ADD   `prize_day` int(11) DEFAULT NULL COMMENT '奖品天数'");}
if(!pdo_fieldexists('yzcyk_sun_punch_prize','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_prize')." ADD   `store_id` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_punch_prize','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_prize')." ADD   `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id'");}
if(!pdo_fieldexists('yzcyk_sun_punch_prize','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_prize')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_prize','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_prize')." ADD   `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '启用状态 1启用'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_punch_receive_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `prize_id` int(11) DEFAULT NULL COMMENT '奖品id',
  `day_num` int(11) DEFAULT NULL COMMENT '天数',
  `title` varchar(60) DEFAULT NULL COMMENT '奖品名称',
  `store_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `user_coupon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券领取记录';

");

if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','task_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `task_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','prize_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `prize_id` int(11) DEFAULT NULL COMMENT '奖品id'");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','day_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `day_num` int(11) DEFAULT NULL COMMENT '天数'");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `title` varchar(60) DEFAULT NULL COMMENT '奖品名称'");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `coupon_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_receive_record','user_coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_receive_record')." ADD   `user_coupon_id` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_punch_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL COMMENT '任务id',
  `year` varchar(10) DEFAULT NULL,
  `month` varchar(10) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `punch_date` varchar(20) DEFAULT NULL COMMENT '打卡日期',
  `punch_diary` text COMMENT '打卡日记',
  `punch_pic` text COMMENT '打卡图片',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `user_coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户领取优惠券id',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='打卡记录';

");

if(!pdo_fieldexists('yzcyk_sun_punch_record','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','task_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `task_id` int(11) DEFAULT NULL COMMENT '任务id'");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','year')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `year` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','month')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `month` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','date')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `date` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','punch_date')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `punch_date` varchar(20) DEFAULT NULL COMMENT '打卡日期'");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','punch_diary')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `punch_diary` text COMMENT '打卡日记'");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','punch_pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `punch_pic` text COMMENT '打卡图片'");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id'");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','user_coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `user_coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户领取优惠券id'");}
if(!pdo_fieldexists('yzcyk_sun_punch_record','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_record')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_punch_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `punch_id` int(11) DEFAULT NULL,
  `task_day_id` tinyint(4) DEFAULT NULL COMMENT '任务天数id',
  `baby_id` int(11) DEFAULT NULL COMMENT '宝宝id',
  `title` varchar(60) DEFAULT NULL,
  `content` text COMMENT '目标内容',
  `pic` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `add_time_d` varchar(20) DEFAULT NULL,
  `task_num` int(11) DEFAULT NULL COMMENT '任务天数',
  `wc_num` int(11) NOT NULL DEFAULT '0' COMMENT '完成天数',
  `is_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否完成目标 1完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='打卡任务';

");

if(!pdo_fieldexists('yzcyk_sun_punch_task','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','punch_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `punch_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','task_day_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `task_day_id` tinyint(4) DEFAULT NULL COMMENT '任务天数id'");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','baby_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `baby_id` int(11) DEFAULT NULL COMMENT '宝宝id'");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `title` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `content` text COMMENT '目标内容'");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `pic` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','add_time_d')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `add_time_d` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','task_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `task_num` int(11) DEFAULT NULL COMMENT '任务天数'");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','wc_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `wc_num` int(11) NOT NULL DEFAULT '0' COMMENT '完成天数'");}
if(!pdo_fieldexists('yzcyk_sun_punch_task','is_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_punch_task')." ADD   `is_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否完成目标 1完成'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `background` varchar(200) DEFAULT NULL COMMENT '首页车友卡背景图',
  `weblogo` varchar(200) DEFAULT NULL COMMENT '车友卡logo',
  `kkxf_background` varchar(200) DEFAULT NULL COMMENT '开卡续费背景图',
  `privilege` text COMMENT '特权介绍',
  `rule` text COMMENT '使用须知',
  `old_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '开卡年费',
  `add_time` int(11) DEFAULT NULL,
  `bg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='车友卡配置';

");

if(!pdo_fieldexists('yzcyk_sun_settings','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_settings','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_settings','background')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `background` varchar(200) DEFAULT NULL COMMENT '首页车友卡背景图'");}
if(!pdo_fieldexists('yzcyk_sun_settings','weblogo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `weblogo` varchar(200) DEFAULT NULL COMMENT '车友卡logo'");}
if(!pdo_fieldexists('yzcyk_sun_settings','kkxf_background')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `kkxf_background` varchar(200) DEFAULT NULL COMMENT '开卡续费背景图'");}
if(!pdo_fieldexists('yzcyk_sun_settings','privilege')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `privilege` text COMMENT '特权介绍'");}
if(!pdo_fieldexists('yzcyk_sun_settings','rule')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `rule` text COMMENT '使用须知'");}
if(!pdo_fieldexists('yzcyk_sun_settings','old_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `old_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价'");}
if(!pdo_fieldexists('yzcyk_sun_settings','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '开卡年费'");}
if(!pdo_fieldexists('yzcyk_sun_settings','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_settings','bg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_settings')." ADD   `bg` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL COMMENT '帖子id',
  `gid` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_share','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_share')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_share','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_share')." ADD   `uniacid` int(11) NOT NULL COMMENT '帖子id'");}
if(!pdo_fieldexists('yzcyk_sun_share','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_share')." ADD   `gid` int(11) NOT NULL COMMENT '用户id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_shop_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `combine` varchar(110) NOT NULL,
  `spec_value` varchar(30) NOT NULL DEFAULT '' COMMENT '规格值1',
  `spec_value1` varchar(30) NOT NULL DEFAULT '' COMMENT '规格值2',
  `gname` varchar(55) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `pic` varchar(110) NOT NULL,
  `uid` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_shop_car','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `gid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','combine')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `combine` varchar(110) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','spec_value')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `spec_value` varchar(30) NOT NULL DEFAULT '' COMMENT '规格值1'");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','spec_value1')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `spec_value1` varchar(30) NOT NULL DEFAULT '' COMMENT '规格值2'");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','gname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `gname` varchar(55) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','unit_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价'");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价'");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `pic` varchar(110) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `uid` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_shop_car','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_shop_car')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(100) NOT NULL,
  `tpl_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '2',
  `tid1` varchar(50) NOT NULL,
  `tid2` varchar(50) NOT NULL,
  `tid3` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_sms','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_sms')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_sms','appkey')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_sms')." ADD   `appkey` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_sms','tpl_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_sms')." ADD   `tpl_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_sms','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_sms')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_sms','is_open')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_sms')." ADD   `is_open` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcyk_sun_sms','tid1')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_sms')." ADD   `tid1` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_sms','tid2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_sms')." ADD   `tid2` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_sms','tid3')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_sms')." ADD   `tid3` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_spec_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `spec_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `num` int(11) NOT NULL COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_spec_value','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_spec_value')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_spec_value','goods_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_spec_value')." ADD   `goods_id` int(11) NOT NULL COMMENT '商品ID'");}
if(!pdo_fieldexists('yzcyk_sun_spec_value','spec_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_spec_value')." ADD   `spec_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_spec_value','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_spec_value')." ADD   `money` decimal(10,2) NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('yzcyk_sun_spec_value','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_spec_value')." ADD   `name` varchar(50) NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('yzcyk_sun_spec_value','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_spec_value')." ADD   `num` int(11) NOT NULL COMMENT '数量'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_name` varchar(100) DEFAULT NULL,
  `tel` varchar(60) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败',
  `rz_time` int(11) DEFAULT NULL COMMENT '当前入驻时间',
  `add_time` int(11) DEFAULT NULL,
  `syrq` varchar(100) DEFAULT NULL COMMENT '使用人群',
  `tag` varchar(255) DEFAULT NULL COMMENT '商店标签',
  `coordinates` varchar(20) DEFAULT NULL COMMENT '经纬度',
  `longitude` varchar(20) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(20) DEFAULT NULL COMMENT '纬度',
  `starttime` varchar(20) DEFAULT NULL,
  `endtime` varchar(20) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `content` text COMMENT '详情',
  `pic` varchar(200) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL COMMENT '商家openid',
  `rz_end_time` int(11) DEFAULT NULL COMMENT '当前入驻结束时间',
  `rz_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1已入驻 2过期',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1已支付 支付完才可以审核',
  `storelimit_id` int(11) DEFAULT NULL COMMENT '入驻价格id',
  `edit_time` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商户账户余额',
  `ptcc_rate` float(11,0) NOT NULL DEFAULT '0' COMMENT '平台抽成比例 1代表1%',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_store','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_store','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','store_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `store_name` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `tel` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核成功 3审核失败'");}
if(!pdo_fieldexists('yzcyk_sun_store','rz_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `rz_time` int(11) DEFAULT NULL COMMENT '当前入驻时间'");}
if(!pdo_fieldexists('yzcyk_sun_store','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','syrq')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `syrq` varchar(100) DEFAULT NULL COMMENT '使用人群'");}
if(!pdo_fieldexists('yzcyk_sun_store','tag')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `tag` varchar(255) DEFAULT NULL COMMENT '商店标签'");}
if(!pdo_fieldexists('yzcyk_sun_store','coordinates')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `coordinates` varchar(20) DEFAULT NULL COMMENT '经纬度'");}
if(!pdo_fieldexists('yzcyk_sun_store','longitude')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `longitude` varchar(20) DEFAULT NULL COMMENT '经度'");}
if(!pdo_fieldexists('yzcyk_sun_store','latitude')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `latitude` varchar(20) DEFAULT NULL COMMENT '纬度'");}
if(!pdo_fieldexists('yzcyk_sun_store','starttime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `starttime` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','endtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `endtime` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','category_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `category_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','district_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `district_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('yzcyk_sun_store','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `pic` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `openid` varchar(30) DEFAULT NULL COMMENT '商家openid'");}
if(!pdo_fieldexists('yzcyk_sun_store','rz_end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `rz_end_time` int(11) DEFAULT NULL COMMENT '当前入驻结束时间'");}
if(!pdo_fieldexists('yzcyk_sun_store','rz_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `rz_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1已入驻 2过期'");}
if(!pdo_fieldexists('yzcyk_sun_store','pay_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1已支付 支付完才可以审核'");}
if(!pdo_fieldexists('yzcyk_sun_store','storelimit_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `storelimit_id` int(11) DEFAULT NULL COMMENT '入驻价格id'");}
if(!pdo_fieldexists('yzcyk_sun_store','edit_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `edit_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商户账户余额'");}
if(!pdo_fieldexists('yzcyk_sun_store','ptcc_rate')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store')." ADD   `ptcc_rate` float(11,0) NOT NULL DEFAULT '0' COMMENT '平台抽成比例 1代表1%'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_store1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `store_name` varchar(50) NOT NULL COMMENT '商家名称',
  `address` varchar(200) NOT NULL COMMENT '商家地址',
  `announcement` varchar(100) NOT NULL COMMENT '公告',
  `storetype_id` int(11) NOT NULL COMMENT '主行业分类id',
  `storetype2_id` int(11) NOT NULL COMMENT '商家子分类id',
  `area_id` int(11) NOT NULL COMMENT '区域id',
  `yy_time` varchar(50) NOT NULL COMMENT '营业时间',
  `keyword` varchar(50) NOT NULL COMMENT '关键字',
  `skzf` int(11) NOT NULL COMMENT '1.是 2否(刷卡支付)',
  `wifi` int(11) NOT NULL COMMENT '1.是 2否',
  `mftc` int(11) NOT NULL COMMENT '1.是 2否(免费停车)',
  `jzxy` int(11) NOT NULL COMMENT '1.是 2否(禁止吸烟)',
  `tgbj` int(11) NOT NULL COMMENT '1.是 2否(提供包间)',
  `sfxx` int(11) NOT NULL COMMENT '1.是 2否(沙发休闲)',
  `tel` varchar(20) NOT NULL COMMENT '手机号',
  `logo` varchar(100) NOT NULL,
  `weixin_logo` varchar(100) NOT NULL,
  `ad` text NOT NULL COMMENT '轮播图',
  `state` int(11) NOT NULL COMMENT '1.待审核2通过3拒绝',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `password` varchar(100) NOT NULL COMMENT '核销密码',
  `details` text NOT NULL COMMENT '商家简介',
  `uniacid` int(11) NOT NULL,
  `coordinates` varchar(50) NOT NULL,
  `views` int(11) NOT NULL,
  `score` decimal(10,1) NOT NULL,
  `type` int(11) NOT NULL,
  `sh_time` int(11) NOT NULL,
  `time_over` int(11) NOT NULL,
  `img` text NOT NULL,
  `vr_link` text NOT NULL,
  `num` int(11) NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `wallet` decimal(10,2) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `dq_time` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `fx_num` int(11) NOT NULL,
  `ewm_logo` varchar(100) NOT NULL,
  `is_top` int(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_store1','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_store1','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcyk_sun_store1','store_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `store_name` varchar(50) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('yzcyk_sun_store1','address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `address` varchar(200) NOT NULL COMMENT '商家地址'");}
if(!pdo_fieldexists('yzcyk_sun_store1','announcement')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `announcement` varchar(100) NOT NULL COMMENT '公告'");}
if(!pdo_fieldexists('yzcyk_sun_store1','storetype_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `storetype_id` int(11) NOT NULL COMMENT '主行业分类id'");}
if(!pdo_fieldexists('yzcyk_sun_store1','storetype2_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `storetype2_id` int(11) NOT NULL COMMENT '商家子分类id'");}
if(!pdo_fieldexists('yzcyk_sun_store1','area_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `area_id` int(11) NOT NULL COMMENT '区域id'");}
if(!pdo_fieldexists('yzcyk_sun_store1','yy_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `yy_time` varchar(50) NOT NULL COMMENT '营业时间'");}
if(!pdo_fieldexists('yzcyk_sun_store1','keyword')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `keyword` varchar(50) NOT NULL COMMENT '关键字'");}
if(!pdo_fieldexists('yzcyk_sun_store1','skzf')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `skzf` int(11) NOT NULL COMMENT '1.是 2否(刷卡支付)'");}
if(!pdo_fieldexists('yzcyk_sun_store1','wifi')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `wifi` int(11) NOT NULL COMMENT '1.是 2否'");}
if(!pdo_fieldexists('yzcyk_sun_store1','mftc')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `mftc` int(11) NOT NULL COMMENT '1.是 2否(免费停车)'");}
if(!pdo_fieldexists('yzcyk_sun_store1','jzxy')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `jzxy` int(11) NOT NULL COMMENT '1.是 2否(禁止吸烟)'");}
if(!pdo_fieldexists('yzcyk_sun_store1','tgbj')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `tgbj` int(11) NOT NULL COMMENT '1.是 2否(提供包间)'");}
if(!pdo_fieldexists('yzcyk_sun_store1','sfxx')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `sfxx` int(11) NOT NULL COMMENT '1.是 2否(沙发休闲)'");}
if(!pdo_fieldexists('yzcyk_sun_store1','tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `tel` varchar(20) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('yzcyk_sun_store1','logo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','weixin_logo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `weixin_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','ad')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `ad` text NOT NULL COMMENT '轮播图'");}
if(!pdo_fieldexists('yzcyk_sun_store1','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `state` int(11) NOT NULL COMMENT '1.待审核2通过3拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_store1','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `money` decimal(10,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('yzcyk_sun_store1','password')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `password` varchar(100) NOT NULL COMMENT '核销密码'");}
if(!pdo_fieldexists('yzcyk_sun_store1','details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `details` text NOT NULL COMMENT '商家简介'");}
if(!pdo_fieldexists('yzcyk_sun_store1','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','coordinates')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `coordinates` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','views')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `views` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','score')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `score` decimal(10,1) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `type` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','sh_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `sh_time` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','time_over')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `time_over` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `img` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','vr_link')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `vr_link` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','start_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `start_time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `end_time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','wallet')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `wallet` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','user_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `user_name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','pwd')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `pwd` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','dq_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `dq_time` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','fx_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `fx_num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','ewm_logo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `ewm_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store1','is_top')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store1')." ADD   `is_top` int(4) NOT NULL DEFAULT '2'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_store_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) DEFAULT NULL COMMENT '活动类型',
  `store_name` varchar(45) DEFAULT NULL COMMENT '商家名称',
  `tel` varchar(15) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `dq_time` int(15) DEFAULT NULL COMMENT '入驻期限',
  `time_type` int(11) DEFAULT NULL COMMENT '1为一周，2一个月，3三个月，4半年，5一年',
  `active_type` int(11) DEFAULT NULL COMMENT '1为集卡',
  `state` int(11) DEFAULT '1' COMMENT '1为待审核2为审核通过',
  `uniacid` int(45) DEFAULT NULL,
  `time_over` int(15) DEFAULT NULL COMMENT '1为时间到期2为时间未到期',
  `rz_time` int(15) DEFAULT NULL COMMENT '入驻时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_store_active','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_store_active','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `user_id` varchar(45) DEFAULT NULL COMMENT '活动类型'");}
if(!pdo_fieldexists('yzcyk_sun_store_active','store_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `store_name` varchar(45) DEFAULT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('yzcyk_sun_store_active','tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `tel` varchar(15) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_active','address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `address` varchar(45) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_active','dq_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `dq_time` int(15) DEFAULT NULL COMMENT '入驻期限'");}
if(!pdo_fieldexists('yzcyk_sun_store_active','time_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `time_type` int(11) DEFAULT NULL COMMENT '1为一周，2一个月，3三个月，4半年，5一年'");}
if(!pdo_fieldexists('yzcyk_sun_store_active','active_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `active_type` int(11) DEFAULT NULL COMMENT '1为集卡'");}
if(!pdo_fieldexists('yzcyk_sun_store_active','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `state` int(11) DEFAULT '1' COMMENT '1为待审核2为审核通过'");}
if(!pdo_fieldexists('yzcyk_sun_store_active','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `uniacid` int(45) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_active','time_over')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `time_over` int(15) DEFAULT NULL COMMENT '1为时间到期2为时间未到期'");}
if(!pdo_fieldexists('yzcyk_sun_store_active','rz_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_active')." ADD   `rz_time` int(15) DEFAULT NULL COMMENT '入驻时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_store_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家类别';

");

if(!pdo_fieldexists('yzcyk_sun_store_category','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_category')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_store_category','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_category')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_category','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_category')." ADD   `title` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_category','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_category')." ADD   `state` tinyint(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_store_category','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_category')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_store_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='商圈';

");

if(!pdo_fieldexists('yzcyk_sun_store_district','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_district')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_store_district','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_district')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_district','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_district')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_district','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_district')." ADD   `state` tinyint(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_store_district','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_district')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_store_rz_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `begin_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `storelimit_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='商家入驻记录信息表';

");

if(!pdo_fieldexists('yzcyk_sun_store_rz_record','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_store_rz_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_rz_record','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_rz_record','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_rz_record','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD   `begin_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_rz_record','end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD   `end_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_rz_record','storelimit_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD   `storelimit_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_rz_record','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD   `num` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_rz_record','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD   `order_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_rz_record','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_rz_record')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_store_wallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `note` varchar(20) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1加2减',
  `time` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家钱包明细';

");

if(!pdo_fieldexists('yzcyk_sun_store_wallet','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_wallet')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_store_wallet','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_wallet')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_wallet','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_wallet')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_wallet','note')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_wallet')." ADD   `note` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_store_wallet','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_wallet')." ADD   `type` int(11) NOT NULL COMMENT '1加2减'");}
if(!pdo_fieldexists('yzcyk_sun_store_wallet','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_store_wallet')." ADD   `time` varchar(20) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_storein` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1.一天2.半年3.一年',
  `money` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_storein','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storein')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_storein','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storein')." ADD   `type` int(11) NOT NULL COMMENT '1.一天2.半年3.一年'");}
if(!pdo_fieldexists('yzcyk_sun_storein','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storein')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_storein','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storein')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_storein','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storein')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_storelimit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lt_id` int(11) NOT NULL DEFAULT '0' COMMENT '入驻期限类别id',
  `lt_name` varchar(30) NOT NULL COMMENT '入驻期限类别名称',
  `lt_day` int(5) NOT NULL COMMENT '入驻期限类别天数',
  `uniacid` int(11) NOT NULL COMMENT '应用id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '入驻价格',
  `sort` int(5) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_storelimit','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storelimit')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_storelimit','lt_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storelimit')." ADD   `lt_id` int(11) NOT NULL DEFAULT '0' COMMENT '入驻期限类别id'");}
if(!pdo_fieldexists('yzcyk_sun_storelimit','lt_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storelimit')." ADD   `lt_name` varchar(30) NOT NULL COMMENT '入驻期限类别名称'");}
if(!pdo_fieldexists('yzcyk_sun_storelimit','lt_day')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storelimit')." ADD   `lt_day` int(5) NOT NULL COMMENT '入驻期限类别天数'");}
if(!pdo_fieldexists('yzcyk_sun_storelimit','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storelimit')." ADD   `uniacid` int(11) NOT NULL COMMENT '应用id'");}
if(!pdo_fieldexists('yzcyk_sun_storelimit','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storelimit')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '入驻价格'");}
if(!pdo_fieldexists('yzcyk_sun_storelimit','sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storelimit')." ADD   `sort` int(5) NOT NULL COMMENT '排序'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_storepaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '商家ID',
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家入驻支付记录表';

");

if(!pdo_fieldexists('yzcyk_sun_storepaylog','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storepaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_storepaylog','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storepaylog')." ADD   `store_id` int(11) NOT NULL COMMENT '商家ID'");}
if(!pdo_fieldexists('yzcyk_sun_storepaylog','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storepaylog')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_storepaylog','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storepaylog')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_storepaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storepaylog')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_storetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL COMMENT '分类名称',
  `img` varchar(100) NOT NULL COMMENT '分类图片',
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL COMMENT '排序',
  `money` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_storetype','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_storetype','type_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype')." ADD   `type_name` varchar(20) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('yzcyk_sun_storetype','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype')." ADD   `img` varchar(100) NOT NULL COMMENT '分类图片'");}
if(!pdo_fieldexists('yzcyk_sun_storetype','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_storetype','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_storetype','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_storetype','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_storetype2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `type_id` int(11) NOT NULL COMMENT '主分类id',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_storetype2','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype2')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_storetype2','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype2')." ADD   `name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_storetype2','type_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype2')." ADD   `type_id` int(11) NOT NULL COMMENT '主分类id'");}
if(!pdo_fieldexists('yzcyk_sun_storetype2','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype2')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_storetype2','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype2')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_storetype2','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_storetype2')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_story` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL COMMENT '专辑id',
  `title` varchar(100) DEFAULT NULL COMMENT '标题名称',
  `pic` varchar(200) DEFAULT NULL COMMENT '首页和列表图',
  `pic_bg` varchar(200) DEFAULT NULL COMMENT '详情背景图',
  `pic_open` varchar(200) DEFAULT NULL COMMENT '详情中间图片',
  `file_path` varchar(200) DEFAULT NULL COMMENT '文件路径',
  `add_time` int(11) DEFAULT NULL,
  `is_album` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否属于专辑 1专辑',
  `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1显示在首页',
  `show_st` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1显示在试听',
  `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1车友会员卡专享',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核通过 3审核失败',
  `tg_time` int(11) DEFAULT NULL,
  `jj_time` int(11) DEFAULT NULL,
  `access_num` int(11) NOT NULL DEFAULT '0' COMMENT '访问次数',
  `duration` varchar(30) DEFAULT NULL COMMENT '音频时长',
  `file_link` varchar(250) DEFAULT NULL COMMENT '音频链接',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_story','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_story','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story','category_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `category_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story','album_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `album_id` int(11) DEFAULT NULL COMMENT '专辑id'");}
if(!pdo_fieldexists('yzcyk_sun_story','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `title` varchar(100) DEFAULT NULL COMMENT '标题名称'");}
if(!pdo_fieldexists('yzcyk_sun_story','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '首页和列表图'");}
if(!pdo_fieldexists('yzcyk_sun_story','pic_bg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `pic_bg` varchar(200) DEFAULT NULL COMMENT '详情背景图'");}
if(!pdo_fieldexists('yzcyk_sun_story','pic_open')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `pic_open` varchar(200) DEFAULT NULL COMMENT '详情中间图片'");}
if(!pdo_fieldexists('yzcyk_sun_story','file_path')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `file_path` varchar(200) DEFAULT NULL COMMENT '文件路径'");}
if(!pdo_fieldexists('yzcyk_sun_story','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story','is_album')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `is_album` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否属于专辑 1专辑'");}
if(!pdo_fieldexists('yzcyk_sun_story','show_index')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1显示在首页'");}
if(!pdo_fieldexists('yzcyk_sun_story','show_st')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `show_st` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1显示在试听'");}
if(!pdo_fieldexists('yzcyk_sun_story','is_vip')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1车友会员卡专享'");}
if(!pdo_fieldexists('yzcyk_sun_story','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1未审核 2审核通过 3审核失败'");}
if(!pdo_fieldexists('yzcyk_sun_story','tg_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `tg_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story','jj_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `jj_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story','access_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `access_num` int(11) NOT NULL DEFAULT '0' COMMENT '访问次数'");}
if(!pdo_fieldexists('yzcyk_sun_story','duration')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `duration` varchar(30) DEFAULT NULL COMMENT '音频时长'");}
if(!pdo_fieldexists('yzcyk_sun_story','file_link')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `file_link` varchar(250) DEFAULT NULL COMMENT '音频链接'");}
if(!pdo_fieldexists('yzcyk_sun_story','sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story')." ADD   `sort` int(11) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_story_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL COMMENT '分类id',
  `title` varchar(100) DEFAULT NULL COMMENT '专辑名称',
  `pic` varchar(200) DEFAULT NULL COMMENT '首页展示和列表图',
  `banner` varchar(200) DEFAULT NULL COMMENT '专辑banner',
  `source` varchar(100) DEFAULT NULL,
  `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '显示在首页',
  `show_st` tinyint(4) NOT NULL DEFAULT '0' COMMENT '显示在试听',
  `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1车友会员卡专享',
  `add_time` int(11) DEFAULT NULL,
  `access_num` int(11) NOT NULL DEFAULT '0' COMMENT '访问次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_story_album','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_story_album','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story_album','category_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `category_id` int(11) DEFAULT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('yzcyk_sun_story_album','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `title` varchar(100) DEFAULT NULL COMMENT '专辑名称'");}
if(!pdo_fieldexists('yzcyk_sun_story_album','pic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '首页展示和列表图'");}
if(!pdo_fieldexists('yzcyk_sun_story_album','banner')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `banner` varchar(200) DEFAULT NULL COMMENT '专辑banner'");}
if(!pdo_fieldexists('yzcyk_sun_story_album','source')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `source` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story_album','show_index')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '显示在首页'");}
if(!pdo_fieldexists('yzcyk_sun_story_album','show_st')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `show_st` tinyint(4) NOT NULL DEFAULT '0' COMMENT '显示在试听'");}
if(!pdo_fieldexists('yzcyk_sun_story_album','is_vip')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1车友会员卡专享'");}
if(!pdo_fieldexists('yzcyk_sun_story_album','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story_album','access_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_album')." ADD   `access_num` int(11) NOT NULL DEFAULT '0' COMMENT '访问次数'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_story_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_story_category','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_category')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_story_category','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_category')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story_category','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_category')." ADD   `title` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story_category','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_category')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_story_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `story_id` int(11) DEFAULT NULL COMMENT '收藏故事会id',
  `collect_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '收藏状态 1收藏',
  `add_time` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏表';

");

if(!pdo_fieldexists('yzcyk_sun_story_collection','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_collection')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_story_collection','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_collection')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story_collection','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_collection')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story_collection','story_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_collection')." ADD   `story_id` int(11) DEFAULT NULL COMMENT '收藏故事会id'");}
if(!pdo_fieldexists('yzcyk_sun_story_collection','collect_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_collection')." ADD   `collect_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '收藏状态 1收藏'");}
if(!pdo_fieldexists('yzcyk_sun_story_collection','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_collection')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_story_collection','edit_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_story_collection')." ADD   `edit_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_system` (
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
  `is_techzhichi` tinyint(4) NOT NULL DEFAULT '1' COMMENT '技术支持开关 1开 2关',
  `store_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商家入驻 1开启 0关闭',
  `map_key` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_system','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_system','appid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `appid` varchar(100) NOT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('yzcyk_sun_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `appsecret` varchar(200) NOT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('yzcyk_sun_system','mchid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `mchid` varchar(20) NOT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('yzcyk_sun_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('yzcyk_sun_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','url_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `url_name` varchar(20) NOT NULL COMMENT '网址名称'");}
if(!pdo_fieldexists('yzcyk_sun_system','details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `details` text NOT NULL COMMENT '关于我们'");}
if(!pdo_fieldexists('yzcyk_sun_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `url_logo` varchar(100) NOT NULL COMMENT '网址logo'");}
if(!pdo_fieldexists('yzcyk_sun_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `bq_name` varchar(50) NOT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('yzcyk_sun_system','link_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `link_name` varchar(30) NOT NULL COMMENT '网站名称'");}
if(!pdo_fieldexists('yzcyk_sun_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `link_logo` varchar(100) NOT NULL COMMENT '网站logo'");}
if(!pdo_fieldexists('yzcyk_sun_system','support')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `support` varchar(20) NOT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('yzcyk_sun_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `bq_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `fontcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','color')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `color` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tz_appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tz_name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','pt_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `pt_name` varchar(30) NOT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('yzcyk_sun_system','tz_audit')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tz_audit` int(11) NOT NULL COMMENT '帖子审核1.是 2否'");}
if(!pdo_fieldexists('yzcyk_sun_system','sj_audit')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `sj_audit` int(11) NOT NULL COMMENT '商家审核1.是 2否'");}
if(!pdo_fieldexists('yzcyk_sun_system','mapkey')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `mapkey` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','gd_key')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `gd_key` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','hb_sxf')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `hb_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','tx_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','tx_sxf')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tx_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','tx_details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tx_details` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','rz_xuz')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `rz_xuz` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','ft_xuz')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `ft_xuz` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','fx_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `fx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_hhr')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_hhr` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_hbfl')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_hbfl` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_zx')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_zx` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_car')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_car` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','pc_xuz')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `pc_xuz` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','pc_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `pc_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_sjrz')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_sjrz` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_pcfw')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_pcfw` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','total_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `total_num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_goods')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_goods` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `apiclient_cert` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `apiclient_key` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_openzx')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_openzx` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_hyset')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_hyset` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_tzopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_tzopen` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_pageopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_pageopen` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_tel` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','tx_mode')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tx_mode` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_system','many_city')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `many_city` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcyk_sun_system','tx_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tx_type` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_hbzf')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_hbzf` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_system','hb_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `hb_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','tz_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tz_num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `client_ip` varchar(30) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','hb_content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `hb_content` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','is_vipcardopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_vipcardopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_jkopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_jkopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_system','address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `address` varchar(150) DEFAULT NULL COMMENT '店铺地址'");}
if(!pdo_fieldexists('yzcyk_sun_system','sj_ruzhu')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `sj_ruzhu` int(5) DEFAULT NULL COMMENT '0为关闭1为开启'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_kanjiaopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_kanjiaopen` int(4) DEFAULT '0' COMMENT '0关闭1开启'");}
if(!pdo_fieldexists('yzcyk_sun_system','bargain_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `bargain_price` varchar(10) DEFAULT NULL COMMENT '每次砍价的%'");}
if(!pdo_fieldexists('yzcyk_sun_system','sign')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `sign` varchar(12) DEFAULT NULL COMMENT '本店招牌自定义'");}
if(!pdo_fieldexists('yzcyk_sun_system','bargain_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `bargain_title` varchar(15) DEFAULT NULL COMMENT '砍价分享标题'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_pintuanopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_pintuanopen` int(4) DEFAULT NULL COMMENT '2为关闭1为开启'");}
if(!pdo_fieldexists('yzcyk_sun_system','refund')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `refund` int(4) DEFAULT '1' COMMENT '1为买家申请2为自动退款'");}
if(!pdo_fieldexists('yzcyk_sun_system','refund_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `refund_time` int(4) DEFAULT '0' COMMENT '自动退款时间 1为24；2为48；3为72；4为活动结束；5为不退款'");}
if(!pdo_fieldexists('yzcyk_sun_system','groups_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `groups_title` varchar(45) DEFAULT NULL COMMENT '拼团分享标题'");}
if(!pdo_fieldexists('yzcyk_sun_system','mask')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `mask` int(2) DEFAULT '1' COMMENT '0不显示1显示'");}
if(!pdo_fieldexists('yzcyk_sun_system','announcement')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `announcement` varchar(60) DEFAULT NULL COMMENT '首页公告'");}
if(!pdo_fieldexists('yzcyk_sun_system','shopmsg_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `shopmsg_status` tinyint(1) DEFAULT NULL COMMENT '欢迎语开关'");}
if(!pdo_fieldexists('yzcyk_sun_system','shopmsg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `shopmsg` varchar(60) DEFAULT NULL COMMENT '欢迎语'");}
if(!pdo_fieldexists('yzcyk_sun_system','shopmsg2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `shopmsg2` varchar(60) DEFAULT NULL COMMENT '问题咨询'");}
if(!pdo_fieldexists('yzcyk_sun_system','shopmsg_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `shopmsg_img` varchar(200) DEFAULT NULL COMMENT '欢迎头像'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_yuyueopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_yuyueopen` int(4) DEFAULT NULL COMMENT '开启预约 1开启 2禁用'");}
if(!pdo_fieldexists('yzcyk_sun_system','yuyue_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `yuyue_title` varchar(60) DEFAULT NULL COMMENT '预约分享标题'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_haowuopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_haowuopen` int(4) DEFAULT NULL COMMENT '开启好物'");}
if(!pdo_fieldexists('yzcyk_sun_system','haowu_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `haowu_title` varchar(60) DEFAULT NULL COMMENT '好物分享标题'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_couponopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_couponopen` int(4) DEFAULT NULL COMMENT '开启优惠券 1开启 2禁用'");}
if(!pdo_fieldexists('yzcyk_sun_system','coupon_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `coupon_title` varchar(60) DEFAULT NULL COMMENT '分享优惠券标题'");}
if(!pdo_fieldexists('yzcyk_sun_system','coupon_banner')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `coupon_banner` varchar(200) DEFAULT NULL COMMENT '优惠券banner'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_gywmopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_gywmopen` int(4) DEFAULT NULL COMMENT '开启关于我们'");}
if(!pdo_fieldexists('yzcyk_sun_system','gywm_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `gywm_title` varchar(60) DEFAULT NULL COMMENT '分享关于我们标题'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_xianshigouopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_xianshigouopen` int(4) DEFAULT NULL COMMENT '开启限时购 1开启 '");}
if(!pdo_fieldexists('yzcyk_sun_system','xianshigou_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `xianshigou_title` varchar(60) DEFAULT NULL COMMENT '分享限时购标题'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_shareopen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_shareopen` int(4) DEFAULT NULL COMMENT '开启分享 1开启'");}
if(!pdo_fieldexists('yzcyk_sun_system','share_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `share_title` varchar(60) DEFAULT NULL COMMENT '分享分享标题'");}
if(!pdo_fieldexists('yzcyk_sun_system','customer_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `customer_time` varchar(30) DEFAULT NULL COMMENT '客服时间'");}
if(!pdo_fieldexists('yzcyk_sun_system','provide')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `provide` varchar(255) DEFAULT NULL COMMENT '基础服务'");}
if(!pdo_fieldexists('yzcyk_sun_system','shop_banner')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `shop_banner` text COMMENT '商店banner'");}
if(!pdo_fieldexists('yzcyk_sun_system','shop_details')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `shop_details` text COMMENT '商店介绍'");}
if(!pdo_fieldexists('yzcyk_sun_system','gywm_banner')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `gywm_banner` varchar(200) DEFAULT NULL COMMENT '关于我们banner'");}
if(!pdo_fieldexists('yzcyk_sun_system','shopdes')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `shopdes` text COMMENT '商店介绍 详情'");}
if(!pdo_fieldexists('yzcyk_sun_system','shopdes_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `shopdes_img` text COMMENT '商店介绍图'");}
if(!pdo_fieldexists('yzcyk_sun_system','distribution')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费'");}
if(!pdo_fieldexists('yzcyk_sun_system','ziti_address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `ziti_address` varchar(200) DEFAULT NULL COMMENT '商家自提地址'");}
if(!pdo_fieldexists('yzcyk_sun_system','ddmd_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `ddmd_img` varchar(100) DEFAULT NULL COMMENT '到店买单头像'");}
if(!pdo_fieldexists('yzcyk_sun_system','ddmd_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `ddmd_title` varchar(100) DEFAULT NULL COMMENT '到店买单商户名称'");}
if(!pdo_fieldexists('yzcyk_sun_system','hx_openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `hx_openid` text COMMENT '核销人员openid'");}
if(!pdo_fieldexists('yzcyk_sun_system','tag')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `tag` varchar(200) DEFAULT NULL COMMENT '店铺标签'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_by')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_by` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否全店包邮'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_xxpf')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_xxpf` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否先行赔付'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_qtwy')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_qtwy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否七天无忧退款退货'");}
if(!pdo_fieldexists('yzcyk_sun_system','yuyue_sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `yuyue_sort` int(11) NOT NULL DEFAULT '0' COMMENT '预约 首页推荐排序'");}
if(!pdo_fieldexists('yzcyk_sun_system','haowu_sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `haowu_sort` int(11) NOT NULL DEFAULT '0' COMMENT '好物 首页推荐排序'");}
if(!pdo_fieldexists('yzcyk_sun_system','groups_sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `groups_sort` int(11) NOT NULL DEFAULT '0' COMMENT '拼团 首页推荐排序'");}
if(!pdo_fieldexists('yzcyk_sun_system','bargain_sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `bargain_sort` int(11) NOT NULL DEFAULT '0' COMMENT '砍价 首页推荐排序'");}
if(!pdo_fieldexists('yzcyk_sun_system','xianshigou_sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `xianshigou_sort` int(11) NOT NULL DEFAULT '0' COMMENT '限时购首页推荐 排序'");}
if(!pdo_fieldexists('yzcyk_sun_system','share_sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `share_sort` int(11) NOT NULL DEFAULT '0' COMMENT '分享首页推荐排序'");}
if(!pdo_fieldexists('yzcyk_sun_system','xinpin_sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `xinpin_sort` int(11) NOT NULL DEFAULT '0' COMMENT '新品 首页推荐排序'");}
if(!pdo_fieldexists('yzcyk_sun_system','index_adv_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `index_adv_img` varchar(100) DEFAULT NULL COMMENT '首页广告图'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_adv')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_adv` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启首页广告 1开启'");}
if(!pdo_fieldexists('yzcyk_sun_system','share_rule')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `share_rule` text COMMENT '分享金规则'");}
if(!pdo_fieldexists('yzcyk_sun_system','groups_rule')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `groups_rule` text COMMENT '拼团规则说明'");}
if(!pdo_fieldexists('yzcyk_sun_system','coordinates')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `coordinates` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','longitude')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `longitude` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','latitude')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `latitude` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_system','index_title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `index_title` varchar(60) DEFAULT NULL COMMENT '首页自定义标题'");}
if(!pdo_fieldexists('yzcyk_sun_system','hz_tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `hz_tel` varchar(60) DEFAULT NULL COMMENT '首页合作电话'");}
if(!pdo_fieldexists('yzcyk_sun_system','jszc_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `jszc_img` varchar(200) DEFAULT NULL COMMENT '技术支持头像'");}
if(!pdo_fieldexists('yzcyk_sun_system','jszc_tdcp')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `jszc_tdcp` varchar(200) DEFAULT NULL COMMENT '首页技术支持团队出品'");}
if(!pdo_fieldexists('yzcyk_sun_system','index_layout')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `index_layout` text COMMENT '首页布局'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_layout')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_layout` tinyint(4) DEFAULT '0' COMMENT '首页布局开关 1开'");}
if(!pdo_fieldexists('yzcyk_sun_system','is_techzhichi')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `is_techzhichi` tinyint(4) NOT NULL DEFAULT '1' COMMENT '技术支持开关 1开 2关'");}
if(!pdo_fieldexists('yzcyk_sun_system','store_open')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `store_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商家入驻 1开启 0关闭'");}
if(!pdo_fieldexists('yzcyk_sun_system','map_key')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_system')." ADD   `map_key` varchar(60) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `index` varchar(10) DEFAULT NULL COMMENT '首页文字',
  `indeximg` varchar(200) DEFAULT NULL,
  `indeximgs` varchar(200) DEFAULT NULL COMMENT '首页图标',
  `store` varchar(10) DEFAULT NULL COMMENT '商店',
  `storeimg` varchar(200) DEFAULT NULL,
  `storeimgs` varchar(200) DEFAULT NULL,
  `dynamic` varchar(10) DEFAULT NULL COMMENT '动态',
  `dynamicimg` varchar(200) DEFAULT NULL,
  `dynamicimgs` varchar(200) DEFAULT NULL,
  `dynamic_status` tinyint(1) DEFAULT '0' COMMENT '动态开关',
  `dynamic_banner` varchar(255) DEFAULT NULL COMMENT '动态页banner',
  `dynamic_headimg` varchar(255) DEFAULT NULL COMMENT '动态页店家头像',
  `cart` varchar(10) DEFAULT NULL COMMENT '购物车',
  `cartimg` varchar(200) DEFAULT NULL,
  `cartimgs` varchar(200) DEFAULT NULL,
  `mine` varchar(10) DEFAULT NULL COMMENT '我的',
  `mineimg` varchar(200) DEFAULT NULL,
  `mineimgs` varchar(200) DEFAULT NULL,
  `fontcolor` varchar(10) DEFAULT NULL,
  `fontcolored` varchar(10) DEFAULT NULL COMMENT '点击后字体颜色',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_tab','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_tab','index')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `index` varchar(10) DEFAULT NULL COMMENT '首页文字'");}
if(!pdo_fieldexists('yzcyk_sun_tab','indeximg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `indeximg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','indeximgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `indeximgs` varchar(200) DEFAULT NULL COMMENT '首页图标'");}
if(!pdo_fieldexists('yzcyk_sun_tab','store')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `store` varchar(10) DEFAULT NULL COMMENT '商店'");}
if(!pdo_fieldexists('yzcyk_sun_tab','storeimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `storeimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','storeimgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `storeimgs` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','dynamic')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `dynamic` varchar(10) DEFAULT NULL COMMENT '动态'");}
if(!pdo_fieldexists('yzcyk_sun_tab','dynamicimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `dynamicimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','dynamicimgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `dynamicimgs` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','dynamic_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `dynamic_status` tinyint(1) DEFAULT '0' COMMENT '动态开关'");}
if(!pdo_fieldexists('yzcyk_sun_tab','dynamic_banner')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `dynamic_banner` varchar(255) DEFAULT NULL COMMENT '动态页banner'");}
if(!pdo_fieldexists('yzcyk_sun_tab','dynamic_headimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `dynamic_headimg` varchar(255) DEFAULT NULL COMMENT '动态页店家头像'");}
if(!pdo_fieldexists('yzcyk_sun_tab','cart')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `cart` varchar(10) DEFAULT NULL COMMENT '购物车'");}
if(!pdo_fieldexists('yzcyk_sun_tab','cartimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `cartimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','cartimgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `cartimgs` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','mine')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `mine` varchar(10) DEFAULT NULL COMMENT '我的'");}
if(!pdo_fieldexists('yzcyk_sun_tab','mineimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `mineimg` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','mineimgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `mineimgs` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','fontcolor')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `fontcolor` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tab','fontcolored')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `fontcolored` varchar(10) DEFAULT NULL COMMENT '点击后字体颜色'");}
if(!pdo_fieldexists('yzcyk_sun_tab','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tab')." ADD   `uniacid` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月',
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_top','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_top')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_top','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_top')." ADD   `type` int(11) NOT NULL COMMENT '1.一天2.一周3.一个月'");}
if(!pdo_fieldexists('yzcyk_sun_top','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_top')." ADD   `money` decimal(10,2) NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('yzcyk_sun_top','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_top')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_top','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_top')." ADD   `num` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL COMMENT '分类名称',
  `img` varchar(100) NOT NULL COMMENT '分类图片',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `num` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_type','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_type','type_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type')." ADD   `type_name` varchar(20) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('yzcyk_sun_type','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type')." ADD   `img` varchar(100) NOT NULL COMMENT '分类图片'");}
if(!pdo_fieldexists('yzcyk_sun_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('yzcyk_sun_type','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_type','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_type','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_type2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '分类名称',
  `type_id` int(11) NOT NULL COMMENT '主分类id',
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_type2','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type2')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_type2','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type2')." ADD   `name` varchar(20) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('yzcyk_sun_type2','type_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type2')." ADD   `type_id` int(11) NOT NULL COMMENT '主分类id'");}
if(!pdo_fieldexists('yzcyk_sun_type2','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type2')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_type2','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type2')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_type2','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_type2')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_tzpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tz_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='帖子支付记录表';

");

if(!pdo_fieldexists('yzcyk_sun_tzpaylog','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tzpaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_tzpaylog','tz_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tzpaylog')." ADD   `tz_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tzpaylog','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tzpaylog')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tzpaylog','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tzpaylog')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_tzpaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_tzpaylog')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL COMMENT 'openid',
  `img` varchar(200) NOT NULL COMMENT '头像',
  `time` varchar(20) NOT NULL COMMENT '注册时间',
  `name` varchar(20) NOT NULL COMMENT '昵称',
  `uniacid` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销金额 暂定分销金额',
  `total_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计金额',
  `user_name` varchar(20) NOT NULL,
  `user_tel` varchar(20) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `commission` decimal(10,2) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  `end_time` int(11) DEFAULT NULL COMMENT 'vip车友会员卡过期时间',
  `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1车友vip会员卡',
  `names` varchar(30) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `address_detail` varchar(100) DEFAULT NULL,
  `baby_id` int(11) DEFAULT NULL,
  `parents_id` int(11) DEFAULT '0' COMMENT '上级用户id',
  `parents_name` varchar(255) DEFAULT NULL COMMENT '上级用户昵称',
  `telphone` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=993 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_user','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `openid` varchar(100) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzcyk_sun_user','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `img` varchar(200) NOT NULL COMMENT '头像'");}
if(!pdo_fieldexists('yzcyk_sun_user','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `time` varchar(20) NOT NULL COMMENT '注册时间'");}
if(!pdo_fieldexists('yzcyk_sun_user','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `name` varchar(20) NOT NULL COMMENT '昵称'");}
if(!pdo_fieldexists('yzcyk_sun_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销金额 暂定分销金额'");}
if(!pdo_fieldexists('yzcyk_sun_user','total_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `total_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计金额'");}
if(!pdo_fieldexists('yzcyk_sun_user','user_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `user_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user','user_tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `user_tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user','user_address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `user_address` varchar(200) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user','commission')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `commission` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_user','end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `end_time` int(11) DEFAULT NULL COMMENT 'vip车友会员卡过期时间'");}
if(!pdo_fieldexists('yzcyk_sun_user','is_vip')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `is_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1车友vip会员卡'");}
if(!pdo_fieldexists('yzcyk_sun_user','names')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `names` varchar(30) DEFAULT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('yzcyk_sun_user','phone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `phone` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user','address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `address` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user','address_detail')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `address_detail` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user','baby_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `baby_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user','parents_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `parents_id` int(11) DEFAULT '0' COMMENT '上级用户id'");}
if(!pdo_fieldexists('yzcyk_sun_user','parents_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `parents_name` varchar(255) DEFAULT NULL COMMENT '上级用户昵称'");}
if(!pdo_fieldexists('yzcyk_sun_user','telphone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user')." ADD   `telphone` varchar(60) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` varchar(100) NOT NULL COMMENT 'openid',
  `num` int(11) DEFAULT NULL COMMENT '卡片数量',
  `img` varchar(150) DEFAULT NULL,
  `jikanum` int(11) DEFAULT NULL COMMENT '当前可抽奖次数',
  `active_id` int(11) DEFAULT NULL,
  `kapian_id` int(11) DEFAULT NULL,
  `sharenum` int(11) DEFAULT NULL COMMENT '可分享次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_user_active','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_active')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_active','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_active')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_active','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_active')." ADD   `uid` varchar(100) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('yzcyk_sun_user_active','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_active')." ADD   `num` int(11) DEFAULT NULL COMMENT '卡片数量'");}
if(!pdo_fieldexists('yzcyk_sun_user_active','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_active')." ADD   `img` varchar(150) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_active','jikanum')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_active')." ADD   `jikanum` int(11) DEFAULT NULL COMMENT '当前可抽奖次数'");}
if(!pdo_fieldexists('yzcyk_sun_user_active','active_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_active')." ADD   `active_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_active','kapian_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_active')." ADD   `kapian_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_active','sharenum')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_active')." ADD   `sharenum` int(11) DEFAULT NULL COMMENT '可分享次数'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_bargain` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL COMMENT '用户id',
  `gid` int(11) DEFAULT NULL COMMENT '商品ID',
  `mch_id` int(11) DEFAULT NULL COMMENT '0是砍主，其他则返回砍主的ID',
  `status` int(11) DEFAULT '1' COMMENT '状态 1砍价中 2待付款 3已购买',
  `uniacid` int(11) DEFAULT NULL,
  `price_ago` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '砍价前价格',
  `prices` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '砍价后价格',
  `kanjias` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '个人砍价金额',
  `add_time` int(11) DEFAULT NULL COMMENT '砍价时间',
  `prices_current` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '当前砍价后价格(只对砍主用)',
  `kanjias_current` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '总共砍了多少钱(砍主使用)',
  `lowest_price` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '砍价最低价格(砍主使用)',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_user_bargain','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `openid` varchar(200) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `gid` int(11) DEFAULT NULL COMMENT '商品ID'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','mch_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `mch_id` int(11) DEFAULT NULL COMMENT '0是砍主，其他则返回砍主的ID'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `status` int(11) DEFAULT '1' COMMENT '状态 1砍价中 2待付款 3已购买'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','price_ago')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `price_ago` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '砍价前价格'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','prices')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `prices` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '砍价后价格'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','kanjias')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `kanjias` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '个人砍价金额'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `add_time` int(11) DEFAULT NULL COMMENT '砍价时间'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','prices_current')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `prices_current` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '当前砍价后价格(只对砍主用)'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','kanjias_current')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `kanjias_current` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '总共砍了多少钱(砍主使用)'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','lowest_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `lowest_price` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '砍价最低价格(砍主使用)'");}
if(!pdo_fieldexists('yzcyk_sun_user_bargain','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_bargain')." ADD   `order_id` int(11) DEFAULT NULL COMMENT '订单id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `uid` varchar(60) NOT NULL DEFAULT '' COMMENT '用户',
  `store_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `title` varchar(60) DEFAULT NULL COMMENT '优惠券名称',
  `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1线上优惠券 2门店优惠券',
  `type` tinyint(1) DEFAULT NULL COMMENT '优惠券类型 1满减 2折扣 3满送',
  `m_price` int(10) NOT NULL DEFAULT '0' COMMENT '满多少',
  `mj_price` int(10) NOT NULL DEFAULT '0' COMMENT '减多少',
  `lq_time` int(11) DEFAULT NULL COMMENT '领取时间',
  `end_time` int(11) DEFAULT NULL COMMENT '过期时间',
  `source` tinyint(1) NOT NULL DEFAULT '1' COMMENT '来源 1用户领取 2打卡领取',
  `is_use` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否使用 1使用',
  `use_time` int(11) DEFAULT NULL COMMENT '使用时间',
  `orderformid` varchar(30) DEFAULT NULL COMMENT '优惠券单号',
  `qrcode_path` varchar(100) DEFAULT NULL COMMENT '核销二维码',
  `hx_openid` varchar(60) DEFAULT NULL COMMENT '核销人员openid',
  `hx_time` int(11) DEFAULT NULL COMMENT '核销时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='用户优惠券';

");

if(!pdo_fieldexists('yzcyk_sun_user_coupon','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `uniacid` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `uid` varchar(60) NOT NULL DEFAULT '' COMMENT '用户'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','coupon_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `title` varchar(60) DEFAULT NULL COMMENT '优惠券名称'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','sign')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1线上优惠券 2门店优惠券'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `type` tinyint(1) DEFAULT NULL COMMENT '优惠券类型 1满减 2折扣 3满送'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','m_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `m_price` int(10) NOT NULL DEFAULT '0' COMMENT '满多少'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','mj_price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `mj_price` int(10) NOT NULL DEFAULT '0' COMMENT '减多少'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','lq_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `lq_time` int(11) DEFAULT NULL COMMENT '领取时间'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `end_time` int(11) DEFAULT NULL COMMENT '过期时间'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','source')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `source` tinyint(1) NOT NULL DEFAULT '1' COMMENT '来源 1用户领取 2打卡领取'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','is_use')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `is_use` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否使用 1使用'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','use_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `use_time` int(11) DEFAULT NULL COMMENT '使用时间'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','orderformid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `orderformid` varchar(30) DEFAULT NULL COMMENT '优惠券单号'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','qrcode_path')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `qrcode_path` varchar(100) DEFAULT NULL COMMENT '核销二维码'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','hx_openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `hx_openid` varchar(60) DEFAULT NULL COMMENT '核销人员openid'");}
if(!pdo_fieldexists('yzcyk_sun_user_coupon','hx_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_coupon')." ADD   `hx_time` int(11) DEFAULT NULL COMMENT '核销时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '拼团id',
  `mch_id` int(11) DEFAULT NULL COMMENT '判断是否是团长，团长 0，跟团id',
  `gid` int(11) DEFAULT NULL COMMENT '商品的id',
  `openid` varchar(100) DEFAULT NULL COMMENT '用户的id',
  `order_id` varchar(100) DEFAULT NULL COMMENT '订单的id',
  `addtime` int(11) DEFAULT NULL COMMENT '加入的时间',
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '状态  1 为拼团成功，2为拼团中，3为拼团失败',
  `price` decimal(10,2) DEFAULT NULL COMMENT '拼团价格',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '当前拼团人数',
  `buynum` int(11) NOT NULL DEFAULT '0' COMMENT '总拼团人数',
  `refund_num` int(11) NOT NULL DEFAULT '0' COMMENT '已经申请退款次数',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `xml` text COMMENT '退款返回报文',
  `out_refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_user_groups','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '拼团id'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','mch_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `mch_id` int(11) DEFAULT NULL COMMENT '判断是否是团长，团长 0，跟团id'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `gid` int(11) DEFAULT NULL COMMENT '商品的id'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT '用户的id'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `order_id` varchar(100) DEFAULT NULL COMMENT '订单的id'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','addtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `addtime` int(11) DEFAULT NULL COMMENT '加入的时间'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `status` int(11) DEFAULT NULL COMMENT '状态  1 为拼团成功，2为拼团中，3为拼团失败'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `price` decimal(10,2) DEFAULT NULL COMMENT '拼团价格'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '当前拼团人数'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','buynum')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `buynum` int(11) NOT NULL DEFAULT '0' COMMENT '总拼团人数'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','refund_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `refund_num` int(11) NOT NULL DEFAULT '0' COMMENT '已经申请退款次数'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `end_time` int(11) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','xml')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `xml` text COMMENT '退款返回报文'");}
if(!pdo_fieldexists('yzcyk_sun_user_groups','out_refund_no')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_groups')." ADD   `out_refund_no` varchar(60) DEFAULT NULL COMMENT '退款单号'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_money_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `sign` tinyint(4) DEFAULT NULL COMMENT '1 增加 2减少',
  `type` tinyint(4) DEFAULT NULL COMMENT '1分销增加 2佣金支付抵扣减少',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `title` varchar(100) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `user_share_record_id` int(11) DEFAULT '0' COMMENT '关联分享记录id',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '佣金级别 1一级 2二级',
  `orderformid` varchar(60) DEFAULT NULL COMMENT '关联订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='金额变动记录表';

");

if(!pdo_fieldexists('yzcyk_sun_user_money_record','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','sign')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `sign` tinyint(4) DEFAULT NULL COMMENT '1 增加 2减少'");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '1分销增加 2佣金支付抵扣减少'");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额'");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `title` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','user_share_record_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `user_share_record_id` int(11) DEFAULT '0' COMMENT '关联分享记录id'");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','level')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '佣金级别 1一级 2二级'");}
if(!pdo_fieldexists('yzcyk_sun_user_money_record','orderformid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_money_record')." ADD   `orderformid` varchar(60) DEFAULT NULL COMMENT '关联订单号'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `openid` varchar(60) DEFAULT NULL COMMENT '子级openid',
  `p_openid` varchar(60) DEFAULT NULL COMMENT '父级openid',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分享用户关系表';

");

if(!pdo_fieldexists('yzcyk_sun_user_share','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_share','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id'");}
if(!pdo_fieldexists('yzcyk_sun_user_share','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share')." ADD   `openid` varchar(60) DEFAULT NULL COMMENT '子级openid'");}
if(!pdo_fieldexists('yzcyk_sun_user_share','p_openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share')." ADD   `p_openid` varchar(60) DEFAULT NULL COMMENT '父级openid'");}
if(!pdo_fieldexists('yzcyk_sun_user_share','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_share_access_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `head_img` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分享详情访问记录';

");

if(!pdo_fieldexists('yzcyk_sun_user_share_access_record','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_access_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_share_access_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_access_record')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_access_record','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_access_record')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_access_record','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_access_record')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_access_record','head_img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_access_record')." ADD   `head_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_access_record','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_access_record')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_share_goods_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL COMMENT '分享者openid',
  `acc_openid` varchar(60) DEFAULT NULL COMMENT '访问者openid',
  `gid` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分享商品记录';

");

if(!pdo_fieldexists('yzcyk_sun_user_share_goods_record','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_goods_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_share_goods_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_goods_record')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_goods_record','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_goods_record')." ADD   `openid` varchar(60) DEFAULT NULL COMMENT '分享者openid'");}
if(!pdo_fieldexists('yzcyk_sun_user_share_goods_record','acc_openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_goods_record')." ADD   `acc_openid` varchar(60) DEFAULT NULL COMMENT '访问者openid'");}
if(!pdo_fieldexists('yzcyk_sun_user_share_goods_record','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_goods_record')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_goods_record','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_goods_record')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_share_join` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='判断参加记录信息表';

");

if(!pdo_fieldexists('yzcyk_sun_user_share_join','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_join')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_share_join','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_join')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_join','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_join')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_join','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_join')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_join','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_join')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_share_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `first_openid` varchar(60) DEFAULT NULL,
  `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `second_openid` varchar(60) DEFAULT NULL,
  `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分享记录信息表';

");

if(!pdo_fieldexists('yzcyk_sun_user_share_record','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_share_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_record')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_record','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_record')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_record','gid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_record')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_record','first_openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_record')." ADD   `first_openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_record','first_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_record')." ADD   `first_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_user_share_record','second_openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_record')." ADD   `second_openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_share_record','second_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_record')." ADD   `second_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('yzcyk_sun_user_share_record','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_share_record')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_user_vipcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` text NOT NULL,
  `vipcard_id` int(11) NOT NULL,
  `card_number` varchar(45) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_user_vipcard','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_vipcard')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_user_vipcard','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_vipcard')." ADD   `uid` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_vipcard','vipcard_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_vipcard')." ADD   `vipcard_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_vipcard','card_number')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_vipcard')." ADD   `card_number` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_user_vipcard','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_user_vipcard')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_userformid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='formid表';

");

if(!pdo_fieldexists('yzcyk_sun_userformid','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userformid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_userformid','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userformid')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcyk_sun_userformid','form_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userformid')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id'");}
if(!pdo_fieldexists('yzcyk_sun_userformid','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userformid')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_userformid','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userformid')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_userformid','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userformid')." ADD   `openid` varchar(50) NOT NULL COMMENT 'openid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_userinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id',
  `uid` varchar(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `tel` varchar(60) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(10) DEFAULT '0',
  `nickName` varchar(60) DEFAULT NULL,
  `avatarUrl` varchar(200) DEFAULT NULL,
  `fromuid` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_userinfo','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'");}
if(!pdo_fieldexists('yzcyk_sun_userinfo','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号id'");}
if(!pdo_fieldexists('yzcyk_sun_userinfo','uid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD   `uid` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_userinfo','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD   `name` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_userinfo','tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD   `tel` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_userinfo','createtime')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD   `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'");}
if(!pdo_fieldexists('yzcyk_sun_userinfo','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD   `status` tinyint(10) DEFAULT '0'");}
if(!pdo_fieldexists('yzcyk_sun_userinfo','nickName')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD   `nickName` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_userinfo','avatarUrl')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD   `avatarUrl` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_userinfo','fromuid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_userinfo')." ADD   `fromuid` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_vip_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `begin_time` int(11) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联订单id',
  `add_time` int(11) DEFAULT NULL,
  `activationcode_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联激活码id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='vip记录';

");

if(!pdo_fieldexists('yzcyk_sun_vip_record','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vip_record')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_vip_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vip_record')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_vip_record','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vip_record')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_vip_record','begin_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vip_record')." ADD   `begin_time` int(11) DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('yzcyk_sun_vip_record','end_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vip_record')." ADD   `end_time` int(11) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('yzcyk_sun_vip_record','order_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vip_record')." ADD   `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联订单id'");}
if(!pdo_fieldexists('yzcyk_sun_vip_record','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vip_record')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_vip_record','activationcode_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vip_record')." ADD   `activationcode_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联激活码id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_vipcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `img` varchar(100) NOT NULL,
  `price` varchar(45) NOT NULL,
  `desc` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `discount` varchar(45) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_vipcard','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vipcard')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_vipcard','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vipcard')." ADD   `name` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_vipcard','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vipcard')." ADD   `img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_vipcard','price')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vipcard')." ADD   `price` varchar(45) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_vipcard','desc')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vipcard')." ADD   `desc` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_vipcard','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vipcard')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_vipcard','discount')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_vipcard')." ADD   `discount` varchar(45) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL COMMENT '提现openid',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现全额',
  `wd_type` tinyint(4) DEFAULT NULL COMMENT '提现方式 1微信',
  `wd_account` varchar(100) DEFAULT NULL COMMENT '提现账号',
  `wd_name` varchar(255) DEFAULT NULL COMMENT '提现姓名',
  `wd_phone` varchar(255) DEFAULT NULL COMMENT '提现手机号',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提现状态 1成功 2失败',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额',
  `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `store_name` varchar(100) DEFAULT NULL COMMENT '商家名称',
  `baowen` text COMMENT '提现报文',
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败',
  `is_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0不需要审核 1需要审核',
  `err_code` varchar(50) DEFAULT NULL COMMENT '提现错误码',
  `err_code_des` varchar(200) DEFAULT NULL COMMENT '失败原因',
  `tx_time` int(11) DEFAULT NULL COMMENT '提现时间',
  `request_time` int(11) DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `review_time` int(11) DEFAULT NULL COMMENT '审核时间',
  `return_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '返还状态 1提现失败返还',
  `return_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `openid` varchar(255) DEFAULT NULL COMMENT '提现openid'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现全额'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','wd_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `wd_type` tinyint(4) DEFAULT NULL COMMENT '提现方式 1微信'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','wd_account')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `wd_account` varchar(100) DEFAULT NULL COMMENT '提现账号'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','wd_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `wd_name` varchar(255) DEFAULT NULL COMMENT '提现姓名'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','wd_phone')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `wd_phone` varchar(255) DEFAULT NULL COMMENT '提现手机号'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提现状态 1成功 2失败'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','realmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际提现金额'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','paycommission')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `paycommission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台佣金'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','store_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `store_name` varchar(100) DEFAULT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','baowen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `baowen` text COMMENT '提现报文'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','is_state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `is_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0不需要审核 1需要审核'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','err_code')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `err_code` varchar(50) DEFAULT NULL COMMENT '提现错误码'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','err_code_des')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `err_code_des` varchar(200) DEFAULT NULL COMMENT '失败原因'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','tx_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `tx_time` int(11) DEFAULT NULL COMMENT '提现时间'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','request_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `request_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','del_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `del_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除状态'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','review_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `review_time` int(11) DEFAULT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','return_status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `return_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '返还状态 1提现失败返还'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw','return_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw')." ADD   `return_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_withdraw_baowen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `baowen` text,
  `wd_id` int(11) DEFAULT NULL COMMENT '提现id',
  `add_time` int(11) DEFAULT NULL,
  `request_data` text COMMENT '请求数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_withdraw_baowen','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw_baowen')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_withdraw_baowen','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw_baowen')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdraw_baowen','openid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw_baowen')." ADD   `openid` varchar(30) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdraw_baowen','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw_baowen')." ADD   `store_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdraw_baowen','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw_baowen')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw_baowen','baowen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw_baowen')." ADD   `baowen` text");}
if(!pdo_fieldexists('yzcyk_sun_withdraw_baowen','wd_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw_baowen')." ADD   `wd_id` int(11) DEFAULT NULL COMMENT '提现id'");}
if(!pdo_fieldexists('yzcyk_sun_withdraw_baowen','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw_baowen')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdraw_baowen','request_data')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdraw_baowen')." ADD   `request_data` text COMMENT '请求数据'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_withdrawal` (
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
  `method` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_withdrawal','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `name` varchar(10) NOT NULL COMMENT '真实姓名'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','username')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `username` varchar(100) NOT NULL COMMENT '账号'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `type` int(11) NOT NULL COMMENT '1支付宝 2.微信 3.银行'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `time` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','sh_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `state` int(11) NOT NULL COMMENT '1.待审核 2.通过  3.拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','tx_cost')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','sj_cost')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','method')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `method` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdrawal','store_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawal')." ADD   `store_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_withdrawset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `wd_type` varchar(255) NOT NULL DEFAULT '1' COMMENT '提现方式 1微信提现',
  `min_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额',
  `avoidmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额',
  `is_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现开关 1开 2关',
  `cms_rates` float NOT NULL DEFAULT '0' COMMENT '平台抽成比率',
  `wd_wxrates` float NOT NULL DEFAULT '0' COMMENT '微信提现手续费费率',
  `wd_content` text COMMENT '提现须知',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_withdrawset','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_withdrawset','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('yzcyk_sun_withdrawset','wd_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD   `wd_type` varchar(255) NOT NULL DEFAULT '1' COMMENT '提现方式 1微信提现'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawset','min_money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD   `min_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawset','avoidmoney')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD   `avoidmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免审金额'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawset','is_open')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD   `is_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '提现开关 1开 2关'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawset','cms_rates')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD   `cms_rates` float NOT NULL DEFAULT '0' COMMENT '平台抽成比率'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawset','wd_wxrates')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD   `wd_wxrates` float NOT NULL DEFAULT '0' COMMENT '微信提现手续费费率'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawset','wd_content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD   `wd_content` text COMMENT '提现须知'");}
if(!pdo_fieldexists('yzcyk_sun_withdrawset','add_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_withdrawset')." ADD   `add_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_yellowpaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hy_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `time` datetime NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='黄页支付记录表';

");

if(!pdo_fieldexists('yzcyk_sun_yellowpaylog','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowpaylog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_yellowpaylog','hy_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowpaylog')." ADD   `hy_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowpaylog','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowpaylog')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowpaylog','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowpaylog')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowpaylog','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowpaylog')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_yellowset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL COMMENT '入住天数',
  `money` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='黄页设置表';

");

if(!pdo_fieldexists('yzcyk_sun_yellowset','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_yellowset','days')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowset')." ADD   `days` int(11) NOT NULL COMMENT '入住天数'");}
if(!pdo_fieldexists('yzcyk_sun_yellowset','money')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowset')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowset','num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowset')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowset','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowset')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_yellowstore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `logo` varchar(200) NOT NULL COMMENT 'logo图片',
  `company_name` varchar(100) NOT NULL COMMENT '公司名称',
  `company_address` varchar(200) NOT NULL COMMENT '公司地址',
  `type_id` int(11) NOT NULL COMMENT '二级分类',
  `link_tel` varchar(20) NOT NULL COMMENT '联系电话',
  `sort` int(11) NOT NULL COMMENT '排序',
  `rz_time` int(11) NOT NULL COMMENT '入住时间',
  `sh_time` int(11) NOT NULL COMMENT '审核时间',
  `state` int(4) NOT NULL COMMENT '1待,2通过,3拒绝',
  `rz_type` int(4) NOT NULL COMMENT '入驻类型',
  `time_over` int(4) NOT NULL COMMENT '1到期,2没到期',
  `uniacid` varchar(50) NOT NULL,
  `coordinates` varchar(50) NOT NULL COMMENT '坐标',
  `content` text NOT NULL COMMENT '简介',
  `imgs` varchar(500) NOT NULL COMMENT '多图',
  `views` int(11) NOT NULL,
  `tel2` varchar(20) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `dq_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_yellowstore','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','logo')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `logo` varchar(200) NOT NULL COMMENT 'logo图片'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','company_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `company_name` varchar(100) NOT NULL COMMENT '公司名称'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','company_address')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `company_address` varchar(200) NOT NULL COMMENT '公司地址'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','type_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `type_id` int(11) NOT NULL COMMENT '二级分类'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','link_tel')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `link_tel` varchar(20) NOT NULL COMMENT '联系电话'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `sort` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','rz_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `rz_time` int(11) NOT NULL COMMENT '入住时间'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','sh_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `sh_time` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `state` int(4) NOT NULL COMMENT '1待,2通过,3拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','rz_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `rz_type` int(4) NOT NULL COMMENT '入驻类型'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','time_over')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `time_over` int(4) NOT NULL COMMENT '1到期,2没到期'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','coordinates')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `coordinates` varchar(50) NOT NULL COMMENT '坐标'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `content` text NOT NULL COMMENT '简介'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','imgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `imgs` varchar(500) NOT NULL COMMENT '多图'");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','views')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `views` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','tel2')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `tel2` varchar(20) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yellowstore','dq_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yellowstore')." ADD   `dq_time` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_yingxiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yuyue` varchar(45) DEFAULT NULL COMMENT '预约',
  `yyimg` varchar(150) DEFAULT NULL COMMENT '预约图标',
  `haowu` varchar(45) DEFAULT NULL COMMENT '好物',
  `hwimg` varchar(150) DEFAULT NULL COMMENT '好物图标',
  `youhuiquan` varchar(45) DEFAULT NULL COMMENT '优惠券',
  `yhqimg` varchar(150) DEFAULT NULL COMMENT '优惠券图标',
  `guanyuwomen` varchar(45) DEFAULT NULL COMMENT '关于我们',
  `gywmimg` varchar(150) DEFAULT NULL COMMENT '关于我们图标',
  `pintuan` varchar(45) DEFAULT NULL COMMENT '拼团',
  `ptimg` varchar(150) DEFAULT NULL COMMENT '拼团图标',
  `kanjia` varchar(45) DEFAULT NULL COMMENT '砍价',
  `kjimg` varchar(150) DEFAULT NULL COMMENT '砍价图标',
  `xianshigou` varchar(45) DEFAULT NULL COMMENT '限时购',
  `xsgimg` varchar(150) DEFAULT NULL COMMENT '限时购图标',
  `fenxiang` varchar(45) DEFAULT NULL COMMENT '分享',
  `fximg` varchar(150) DEFAULT NULL COMMENT '分享图标',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_yingxiao','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','yuyue')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `yuyue` varchar(45) DEFAULT NULL COMMENT '预约'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','yyimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `yyimg` varchar(150) DEFAULT NULL COMMENT '预约图标'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','haowu')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `haowu` varchar(45) DEFAULT NULL COMMENT '好物'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','hwimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `hwimg` varchar(150) DEFAULT NULL COMMENT '好物图标'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','youhuiquan')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `youhuiquan` varchar(45) DEFAULT NULL COMMENT '优惠券'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','yhqimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `yhqimg` varchar(150) DEFAULT NULL COMMENT '优惠券图标'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','guanyuwomen')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `guanyuwomen` varchar(45) DEFAULT NULL COMMENT '关于我们'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','gywmimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `gywmimg` varchar(150) DEFAULT NULL COMMENT '关于我们图标'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','pintuan')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `pintuan` varchar(45) DEFAULT NULL COMMENT '拼团'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','ptimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `ptimg` varchar(150) DEFAULT NULL COMMENT '拼团图标'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','kanjia')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `kanjia` varchar(45) DEFAULT NULL COMMENT '砍价'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','kjimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `kjimg` varchar(150) DEFAULT NULL COMMENT '砍价图标'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','xianshigou')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `xianshigou` varchar(45) DEFAULT NULL COMMENT '限时购'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','xsgimg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `xsgimg` varchar(150) DEFAULT NULL COMMENT '限时购图标'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','fenxiang')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `fenxiang` varchar(45) DEFAULT NULL COMMENT '分享'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','fximg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `fximg` varchar(150) DEFAULT NULL COMMENT '分享图标'");}
if(!pdo_fieldexists('yzcyk_sun_yingxiao','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yingxiao')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_yjset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(4) NOT NULL DEFAULT '1' COMMENT '1统一模式,2分开模式',
  `typer` varchar(10) NOT NULL COMMENT '统一比例',
  `sjper` varchar(10) NOT NULL COMMENT '商家比例',
  `hyper` varchar(10) NOT NULL COMMENT '黄页比例',
  `pcper` varchar(10) NOT NULL COMMENT '拼车比例',
  `tzper` varchar(10) NOT NULL COMMENT '帖子比例',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金比例表';

");

if(!pdo_fieldexists('yzcyk_sun_yjset','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_yjset','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjset')." ADD   `type` int(4) NOT NULL DEFAULT '1' COMMENT '1统一模式,2分开模式'");}
if(!pdo_fieldexists('yzcyk_sun_yjset','typer')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjset')." ADD   `typer` varchar(10) NOT NULL COMMENT '统一比例'");}
if(!pdo_fieldexists('yzcyk_sun_yjset','sjper')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjset')." ADD   `sjper` varchar(10) NOT NULL COMMENT '商家比例'");}
if(!pdo_fieldexists('yzcyk_sun_yjset','hyper')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjset')." ADD   `hyper` varchar(10) NOT NULL COMMENT '黄页比例'");}
if(!pdo_fieldexists('yzcyk_sun_yjset','pcper')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjset')." ADD   `pcper` varchar(10) NOT NULL COMMENT '拼车比例'");}
if(!pdo_fieldexists('yzcyk_sun_yjset','tzper')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjset')." ADD   `tzper` varchar(10) NOT NULL COMMENT '帖子比例'");}
if(!pdo_fieldexists('yzcyk_sun_yjset','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjset')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_yjtx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL COMMENT '账号id',
  `tx_type` int(4) NOT NULL COMMENT '提现方式 1,支付宝,2微信,3银联',
  `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额',
  `status` int(4) NOT NULL COMMENT '状态 1申请,2通过,3拒绝',
  `uniacid` varchar(50) NOT NULL,
  `cerated_time` datetime NOT NULL COMMENT '日期',
  `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额',
  `account` varchar(30) NOT NULL COMMENT '账户',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `sx_cost` decimal(10,2) NOT NULL COMMENT '手续费',
  `time` datetime NOT NULL COMMENT '审核时间',
  `is_del` int(4) NOT NULL DEFAULT '1' COMMENT '1正常,2删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_yjtx','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','account_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `account_id` int(11) NOT NULL COMMENT '账号id'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','tx_type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `tx_type` int(4) NOT NULL COMMENT '提现方式 1,支付宝,2微信,3银联'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','tx_cost')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `tx_cost` decimal(10,2) NOT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `status` int(4) NOT NULL COMMENT '状态 1申请,2通过,3拒绝'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','cerated_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `cerated_time` datetime NOT NULL COMMENT '日期'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','sj_cost')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `sj_cost` decimal(10,2) NOT NULL COMMENT '实际金额'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','account')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `account` varchar(30) NOT NULL COMMENT '账户'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `name` varchar(30) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','sx_cost')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `sx_cost` decimal(10,2) NOT NULL COMMENT '手续费'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `time` datetime NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('yzcyk_sun_yjtx','is_del')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_yjtx')." ADD   `is_del` int(4) NOT NULL DEFAULT '1' COMMENT '1正常,2删除'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_zx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT '分类ID',
  `user_id` int(11) NOT NULL COMMENT '发布人ID',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `time` datetime NOT NULL,
  `yd_num` int(11) NOT NULL COMMENT '阅读数量',
  `pl_num` int(11) NOT NULL COMMENT '评论数量',
  `uniacid` varchar(50) NOT NULL,
  `imgs` text NOT NULL COMMENT '图片',
  `state` int(4) NOT NULL DEFAULT '1',
  `sh_time` datetime NOT NULL,
  `type` int(4) NOT NULL,
  `cityname` varchar(50) NOT NULL,
  `jianjie` varchar(50) DEFAULT NULL COMMENT '头条简介',
  `indeximg` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_zx','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_zx','type_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `type_id` int(11) NOT NULL COMMENT '分类ID'");}
if(!pdo_fieldexists('yzcyk_sun_zx','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `user_id` int(11) NOT NULL COMMENT '发布人ID'");}
if(!pdo_fieldexists('yzcyk_sun_zx','title')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `title` varchar(200) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('yzcyk_sun_zx','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `content` text NOT NULL COMMENT '内容'");}
if(!pdo_fieldexists('yzcyk_sun_zx','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx','yd_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `yd_num` int(11) NOT NULL COMMENT '阅读数量'");}
if(!pdo_fieldexists('yzcyk_sun_zx','pl_num')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `pl_num` int(11) NOT NULL COMMENT '评论数量'");}
if(!pdo_fieldexists('yzcyk_sun_zx','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx','imgs')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `imgs` text NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('yzcyk_sun_zx','state')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `state` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('yzcyk_sun_zx','sh_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `sh_time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx','type')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `type` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx','cityname')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx','jianjie')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `jianjie` varchar(50) DEFAULT NULL COMMENT '头条简介'");}
if(!pdo_fieldexists('yzcyk_sun_zx','indeximg')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx')." ADD   `indeximg` varchar(200) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_zx_assess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zx_id` int(4) NOT NULL,
  `score` int(11) NOT NULL,
  `content` text NOT NULL,
  `img` varchar(500) NOT NULL,
  `cerated_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `uniacid` varchar(50) NOT NULL,
  `status` int(4) NOT NULL,
  `reply` text NOT NULL,
  `reply_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_zx_assess','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','zx_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `zx_id` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','score')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `score` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','content')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `content` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','img')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `img` varchar(500) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','cerated_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `cerated_time` datetime NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','status')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `status` int(4) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','reply')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `reply` text NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_assess','reply_time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_assess')." ADD   `reply_time` datetime NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_zx_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL COMMENT '分类名称',
  `icon` varchar(100) NOT NULL COMMENT '图标',
  `sort` int(4) NOT NULL COMMENT '排序',
  `time` datetime NOT NULL COMMENT '时间',
  `uniacid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('yzcyk_sun_zx_type','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_zx_type','type_name')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_type')." ADD   `type_name` varchar(100) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('yzcyk_sun_zx_type','icon')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_type')." ADD   `icon` varchar(100) NOT NULL COMMENT '图标'");}
if(!pdo_fieldexists('yzcyk_sun_zx_type','sort')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_type')." ADD   `sort` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('yzcyk_sun_zx_type','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_type')." ADD   `time` datetime NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('yzcyk_sun_zx_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_type')." ADD   `uniacid` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_yzcyk_sun_zx_zj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zx_id` int(11) NOT NULL COMMENT '资讯ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `uniacid` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资讯足迹';

");

if(!pdo_fieldexists('yzcyk_sun_zx_zj','id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_zj')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('yzcyk_sun_zx_zj','zx_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_zj')." ADD   `zx_id` int(11) NOT NULL COMMENT '资讯ID'");}
if(!pdo_fieldexists('yzcyk_sun_zx_zj','user_id')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_zj')." ADD   `user_id` int(11) NOT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('yzcyk_sun_zx_zj','uniacid')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_zj')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('yzcyk_sun_zx_zj','time')) {pdo_query("ALTER TABLE ".tablename('yzcyk_sun_zx_zj')." ADD   `time` int(11) NOT NULL");}
