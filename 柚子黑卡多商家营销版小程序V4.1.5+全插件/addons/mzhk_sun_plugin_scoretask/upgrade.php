<?php
//升级数据表
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地址';

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','openid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','name')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','phone')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `phone` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','province')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `province` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','city')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `city` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','zip')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `zip` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','address')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `address` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','postalcode')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `postalcode` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','default')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '默认地址'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','lottery')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `lottery` tinyint(4) NOT NULL DEFAULT '0' COMMENT '抽奖收货地址'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_address','edit_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_address')." ADD   `edit_time` int(11) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
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
  `icon_vertical` varchar(255) DEFAULT NULL COMMENT '竖向图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','icon')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `icon` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','show_type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `show_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '首页展示类型 1竖向 2横向'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','url')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','file_path')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `file_path` varchar(255) DEFAULT NULL COMMENT '音频'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','read_num')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','state')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `state` tinyint(4) DEFAULT '0'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','show_index')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `show_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在首页'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','show_task')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `show_task` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示在任务'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','publish_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `publish_time` int(11) DEFAULT NULL COMMENT '发布时间'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','tg_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `tg_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','jj_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `jj_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_article','icon_vertical')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_article')." ADD   `icon_vertical` varchar(255) DEFAULT NULL COMMENT '竖向图标'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_mzhk_sun_plugin_scoretask_bargainrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(60) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `bargain_openid` varchar(60) DEFAULT NULL COMMENT '砍价用户',
  `bargain_score` int(11) DEFAULT NULL COMMENT '砍价积分',
  `add_time` int(11) DEFAULT NULL COMMENT '砍价时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砍价记录';

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_bargainrecord','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_bargainrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_bargainrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_bargainrecord','openid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_bargainrecord','gid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_bargainrecord','bargain_openid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `bargain_openid` varchar(60) DEFAULT NULL COMMENT '砍价用户'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_bargainrecord','bargain_score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `bargain_score` int(11) DEFAULT NULL COMMENT '砍价积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_bargainrecord','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_bargainrecord')." ADD   `add_time` int(11) DEFAULT NULL COMMENT '砍价时间'");}
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='自定义';

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '1 首页banner 2营销案图标 3底部图标'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '标题名称'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','pic')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '图标图片'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','clickago_icon')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `clickago_icon` varchar(200) DEFAULT NULL COMMENT '点击前图标'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','clickafter_icon')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `clickafter_icon` varchar(200) DEFAULT NULL COMMENT '点击后图标'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','url_type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `url_type` tinyint(4) DEFAULT NULL COMMENT '链接类型 1基本 2商品分类'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','url')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `url` varchar(200) DEFAULT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','url_name')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `url_name` varchar(50) DEFAULT NULL COMMENT '链接名称'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','sort')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `sort` tinyint(4) DEFAULT NULL COMMENT '排序 越大越前'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_customize','store_id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_customize')." ADD   `store_id` int(11) DEFAULT NULL");}
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='积分商城商品表';

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','lid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `lid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1积分商品 2抽奖商品'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `title` varchar(200) DEFAULT NULL COMMENT '商品名'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','pic')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `pic` varchar(200) DEFAULT NULL COMMENT '展示图'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','lb_pics')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `lb_pics` text COMMENT '轮播图'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','price')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `price` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '价值'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT '价值总积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','bargain_score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '可砍积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','min_score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `min_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最小积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','max_score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `max_score` int(11) NOT NULL DEFAULT '0' COMMENT '每次砍价最大积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','num')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '库存'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','sale_num')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `sale_num` int(11) NOT NULL DEFAULT '0' COMMENT '已兑换'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','begin_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `begin_time` int(11) DEFAULT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','end_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `end_time` int(11) DEFAULT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','content')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `content` text COMMENT '详情'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_goods','state')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_goods')." ADD   `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1审核通过 2审核失败'");}
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

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','name')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型  1积分商城物品 2积分 3谢谢参与'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','gid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `gid` int(11) NOT NULL DEFAULT '0' COMMENT 'type为1时 使用'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT 'type为2时使用'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','pic')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `pic` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','rate')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `rate` int(11) NOT NULL DEFAULT '0' COMMENT '中奖概率'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','num')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `num` int(11) NOT NULL DEFAULT '0' COMMENT '奖品数量'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','zj_num')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `zj_num` int(11) NOT NULL DEFAULT '0' COMMENT '中奖数量'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_lotteryprize','edit_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_lotteryprize')." ADD   `edit_time` int(11) DEFAULT NULL");}
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','lid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `lid` int(11) NOT NULL DEFAULT '0' COMMENT '1积分商城订单 2抽奖订单'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','openid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','orderformid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `orderformid` varchar(60) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','gid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `gid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','num')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `num` int(11) NOT NULL DEFAULT '1' COMMENT '数量'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','order_score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `order_score` int(11) NOT NULL DEFAULT '0' COMMENT '消费的积分(兑换的积分)'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','bargain_score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `bargain_score` int(11) NOT NULL DEFAULT '0' COMMENT '砍价多少积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','pay_status')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '兑换状态 支付状态 1支付兑换'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','order_status')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未兑换  1已支付(待发货) 3完成'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','pay_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `pay_time` int(11) DEFAULT NULL COMMENT '支付时间'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','wc_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `wc_time` int(11) DEFAULT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','fahuo_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `fahuo_time` int(11) DEFAULT NULL COMMENT '发货时间'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','name')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `name` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','phone')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `phone` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','province')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `province` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','city')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `city` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','zip')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `zip` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','address')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `address` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','postalcode')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `postalcode` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','express_delivery')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `express_delivery` varchar(60) DEFAULT NULL COMMENT '物流公司'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','express_no')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `express_no` varchar(60) DEFAULT NULL COMMENT '物流单号'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','remark')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `remark` varchar(200) DEFAULT NULL COMMENT '备注'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','lottery_type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `lottery_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '奖品类型1积分商品实物 2积分 '");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_order','lotteryprize_id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_order')." ADD   `lotteryprize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id'");}
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='阅读记录';

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_readrecord','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_readrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_readrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_readrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_readrecord','openid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_readrecord')." ADD   `openid` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_readrecord','type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_readrecord')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '类型 1文章阅读记录  2文章马克记录 3邀请阅读记录 4邀请新用户记录'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_readrecord','article_id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_readrecord')." ADD   `article_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_readrecord','date')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_readrecord')." ADD   `date` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_readrecord','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_readrecord')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_readrecord','invited_openid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_readrecord')." ADD   `invited_openid` varchar(60) DEFAULT NULL COMMENT '邀请用户'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_readrecord','is_mark')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_readrecord')." ADD   `is_mark` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1收藏 0取消收藏'");}
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','appid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `appid` varchar(100) NOT NULL COMMENT 'appid'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `appsecret` varchar(200) NOT NULL COMMENT 'appsecret'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','mchid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `mchid` varchar(20) NOT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','url_name')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `url_name` varchar(20) NOT NULL COMMENT '网址名称'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','details')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `details` text NOT NULL COMMENT '关于我们'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `url_logo` varchar(100) NOT NULL COMMENT '网址logo'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `bq_name` varchar(50) NOT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','link_name')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `link_name` varchar(30) NOT NULL COMMENT '网站名称'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `link_logo` varchar(100) NOT NULL COMMENT '网站logo'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','support')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `support` varchar(20) NOT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `bq_logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','fontcolor')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `fontcolor` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','color')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `color` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tz_appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tz_name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','pt_name')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `pt_name` varchar(30) NOT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tz_audit')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tz_audit` int(11) NOT NULL COMMENT '帖子审核1.是 2否'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','sj_audit')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `sj_audit` int(11) NOT NULL COMMENT '商家审核1.是 2否'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','mapkey')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `mapkey` varchar(200) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tel')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','gd_key')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `gd_key` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','hb_sxf')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `hb_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tx_money')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tx_sxf')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tx_sxf` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tx_details')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tx_details` text NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','rz_xuz')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `rz_xuz` text NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','ft_xuz')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `ft_xuz` text NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','fx_money')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `fx_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_hhr')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_hhr` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_hbfl')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_hbfl` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_zx')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_zx` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_car')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_car` int(4) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','pc_xuz')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `pc_xuz` text NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','pc_money')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `pc_money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_sjrz')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_sjrz` int(4) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_pcfw')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_pcfw` int(4) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','total_num')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `total_num` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_goods')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_goods` int(4) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `apiclient_cert` text NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `apiclient_key` text NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_openzx')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_openzx` int(4) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_hyset')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_hyset` int(4) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_tzopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_tzopen` int(4) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_pageopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_pageopen` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','cityname')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `cityname` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_tel')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_tel` int(4) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tx_mode')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tx_mode` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','many_city')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `many_city` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tx_type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tx_type` int(4) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_hbzf')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_hbzf` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','hb_img')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `hb_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tz_num')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tz_num` int(11) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','client_ip')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `client_ip` varchar(30) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','hb_content')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `hb_content` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_vipcardopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_vipcardopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_jkopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_jkopen` int(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','address')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `address` varchar(150) DEFAULT NULL COMMENT '店铺地址'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','sj_ruzhu')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `sj_ruzhu` int(5) DEFAULT NULL COMMENT '0为关闭1为开启'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_kanjiaopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_kanjiaopen` int(4) DEFAULT '0' COMMENT '0关闭1开启'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','bargain_price')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `bargain_price` varchar(10) DEFAULT NULL COMMENT '每次砍价的%'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','sign')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `sign` varchar(12) DEFAULT NULL COMMENT '本店招牌自定义'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','bargain_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `bargain_title` varchar(15) DEFAULT NULL COMMENT '砍价分享标题'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_pintuanopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_pintuanopen` int(4) DEFAULT NULL COMMENT '2为关闭1为开启'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','refund')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `refund` int(4) DEFAULT '1' COMMENT '1为买家申请2为自动退款'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','refund_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `refund_time` int(4) DEFAULT '0' COMMENT '自动退款时间 1为24；2为48；3为72；4为活动结束；5为不退款'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','groups_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `groups_title` varchar(45) DEFAULT NULL COMMENT '拼团分享标题'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','mask')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `mask` int(2) DEFAULT '1' COMMENT '0不显示1显示'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','announcement')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `announcement` varchar(60) DEFAULT NULL COMMENT '首页公告'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','shopmsg_status')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `shopmsg_status` tinyint(1) DEFAULT NULL COMMENT '欢迎语开关'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','shopmsg')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `shopmsg` varchar(60) DEFAULT NULL COMMENT '欢迎语'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','shopmsg2')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `shopmsg2` varchar(60) DEFAULT NULL COMMENT '问题咨询'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','shopmsg_img')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `shopmsg_img` varchar(200) DEFAULT NULL COMMENT '欢迎头像'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_yuyueopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_yuyueopen` int(4) DEFAULT NULL COMMENT '开启预约 1开启 2禁用'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','yuyue_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `yuyue_title` varchar(60) DEFAULT NULL COMMENT '预约分享标题'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_haowuopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_haowuopen` int(4) DEFAULT NULL COMMENT '开启好物'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','haowu_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `haowu_title` varchar(60) DEFAULT NULL COMMENT '好物分享标题'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_couponopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_couponopen` int(4) DEFAULT NULL COMMENT '开启优惠券 1开启 2禁用'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','coupon_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `coupon_title` varchar(60) DEFAULT NULL COMMENT '分享优惠券标题'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','coupon_banner')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `coupon_banner` varchar(200) DEFAULT NULL COMMENT '优惠券banner'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_gywmopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_gywmopen` int(4) DEFAULT NULL COMMENT '开启关于我们'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','gywm_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `gywm_title` varchar(60) DEFAULT NULL COMMENT '分享关于我们标题'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_xianshigouopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_xianshigouopen` int(4) DEFAULT NULL COMMENT '开启限时购 1开启 '");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','xianshigou_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `xianshigou_title` varchar(60) DEFAULT NULL COMMENT '分享限时购标题'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_shareopen')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_shareopen` int(4) DEFAULT NULL COMMENT '开启分享 1开启'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','share_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `share_title` varchar(60) DEFAULT NULL COMMENT '分享分享标题'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','customer_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `customer_time` varchar(30) DEFAULT NULL COMMENT '客服时间'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','provide')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `provide` varchar(255) DEFAULT NULL COMMENT '基础服务'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','shop_banner')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `shop_banner` text COMMENT '商店banner'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','shop_details')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `shop_details` text COMMENT '商店介绍'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','gywm_banner')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `gywm_banner` varchar(200) DEFAULT NULL COMMENT '关于我们banner'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','shopdes')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `shopdes` text COMMENT '商店介绍 详情'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','shopdes_img')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `shopdes_img` text COMMENT '商店介绍图'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','distribution')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `distribution` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','ziti_address')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `ziti_address` varchar(200) DEFAULT NULL COMMENT '商家自提地址'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','ddmd_img')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `ddmd_img` varchar(100) DEFAULT NULL COMMENT '到店买单头像'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','ddmd_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `ddmd_title` varchar(100) DEFAULT NULL COMMENT '到店买单商户名称'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','hx_openid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `hx_openid` text COMMENT '核销人员openid'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','tag')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `tag` varchar(200) DEFAULT NULL COMMENT '店铺标签'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_by')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_by` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否全店包邮'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_xxpf')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_xxpf` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否先行赔付'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_qtwy')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_qtwy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否七天无忧退款退货'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','yuyue_sort')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `yuyue_sort` int(11) NOT NULL DEFAULT '0' COMMENT '预约 首页推荐排序'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','haowu_sort')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `haowu_sort` int(11) NOT NULL DEFAULT '0' COMMENT '好物 首页推荐排序'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','groups_sort')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `groups_sort` int(11) NOT NULL DEFAULT '0' COMMENT '拼团 首页推荐排序'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','bargain_sort')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `bargain_sort` int(11) NOT NULL DEFAULT '0' COMMENT '砍价 首页推荐排序'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','xianshigou_sort')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `xianshigou_sort` int(11) NOT NULL DEFAULT '0' COMMENT '限时购首页推荐 排序'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','share_sort')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `share_sort` int(11) NOT NULL DEFAULT '0' COMMENT '分享首页推荐排序'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','xinpin_sort')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `xinpin_sort` int(11) NOT NULL DEFAULT '0' COMMENT '新品 首页推荐排序'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','index_adv_img')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `index_adv_img` varchar(100) DEFAULT NULL COMMENT '首页广告图'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_adv')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_adv` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启首页广告 1开启'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','share_rule')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `share_rule` text COMMENT '分享金规则'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','groups_rule')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `groups_rule` text COMMENT '拼团规则说明'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','coordinates')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `coordinates` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','longitude')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `longitude` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','latitude')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `latitude` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','index_title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `index_title` varchar(60) DEFAULT NULL COMMENT '首页自定义标题'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','hz_tel')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `hz_tel` varchar(60) DEFAULT NULL COMMENT '首页合作电话'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','jszc_img')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `jszc_img` varchar(200) DEFAULT NULL COMMENT '技术支持头像'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','jszc_tdcp')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `jszc_tdcp` varchar(200) DEFAULT NULL COMMENT '首页技术支持团队出品'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','index_layout')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `index_layout` text COMMENT '首页布局'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_layout')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_layout` tinyint(4) DEFAULT '0' COMMENT '首页布局开关 1开'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_techzhichi')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_techzhichi` tinyint(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','store_open')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `store_open` tinyint(4) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','lottery_score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `lottery_score` int(11) NOT NULL DEFAULT '0' COMMENT '抽奖消费积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','lottery_rule')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `lottery_rule` text COMMENT '抽奖规则'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','aboutus')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `aboutus` text COMMENT '关于我们'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_system','is_show')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_system')." ADD   `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 '");}
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='任务表';

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_task','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_task')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_task','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_task')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_task','type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_task')." ADD   `type` tinyint(4) DEFAULT NULL COMMENT '任务类型 1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖 6马克 7邀请好友'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_task','title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_task')." ADD   `title` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_task','icon')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_task')." ADD   `icon` varchar(250) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_task','task_num')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_task')." ADD   `task_num` int(11) NOT NULL DEFAULT '1' COMMENT '任务数'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_task','score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_task')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT '积分完成一个任务得到积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_task','task_score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_task')." ADD   `task_score` int(11) NOT NULL DEFAULT '0' COMMENT '任务页面显示积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_task','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_task')." ADD   `add_time` int(11) DEFAULT NULL");}
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
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COMMENT='任务积分记录表 ';

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','openid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `openid` varchar(60) DEFAULT NULL COMMENT '用户openid(获得积分的用户)'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1签到 2阅读文章 3邀请好友看文章 4邀请好友砍积分 5积分抽奖(增加) 6马克 7邀请新用户 8兑换积分商品 9积分抽奖(消耗) 10抽奖中奖积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','task_id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `task_id` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','sign')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `sign` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `score` int(11) NOT NULL DEFAULT '0' COMMENT '获得积分'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','date')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `date` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `add_time` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','article_id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `article_id` int(11) DEFAULT NULL COMMENT '文章id 阅读和邀请看文章使用 马克'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','beinvited_openid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `beinvited_openid` varchar(60) DEFAULT NULL COMMENT '被邀请用户openid 邀请看文章使用 、好友砍积分使用、新用户'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','goods_id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `goods_id` int(11) DEFAULT NULL COMMENT '商品id 砍价积分商品使用 '");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskrecord','prize_id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskrecord')." ADD   `prize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id'");}
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='任务积分设置';

");

if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskset','id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskset','uniacid')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskset')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskset','task_id')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskset')." ADD   `task_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskset','task_type')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskset')." ADD   `task_type` tinyint(4) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskset','title')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskset')." ADD   `title` varchar(60) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskset','score')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskset')." ADD   `score` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskset','icon')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskset')." ADD   `icon` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ims_mzhk_sun_plugin_scoretask_taskset','add_time')) {pdo_query("ALTER TABLE ".tablename('ims_mzhk_sun_plugin_scoretask_taskset')." ADD   `add_time` int(11) DEFAULT NULL");}
