<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_vote_res_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '活动标题',
  `desc` text COMMENT '互动介绍',
  `voting` varchar(255) DEFAULT NULL COMMENT '投票方式',
  `starttime` int(11) DEFAULT NULL COMMENT '活动开始时间',
  `endtime` int(11) DEFAULT NULL COMMENT '活动结束时间',
  `createtime` int(11) DEFAULT NULL COMMENT '活动创建时间',
  `explain` text COMMENT '活动中奖说明',
  `thumb` varchar(255) DEFAULT NULL COMMENT '活动主题图',
  `votedesc` varchar(255) DEFAULT NULL COMMENT '投票区描述',
  `fold` tinyint(3) DEFAULT '0' COMMENT '是否折叠0-禁止 1-折叠',
  `enabled` tinyint(3) DEFAULT NULL COMMENT '是否开启 0-关闭 1-开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('vote_res_activity','id')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('vote_res_activity','uniacid')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('vote_res_activity','title')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '活动标题'");}
if(!pdo_fieldexists('vote_res_activity','desc')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `desc` text COMMENT '互动介绍'");}
if(!pdo_fieldexists('vote_res_activity','voting')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `voting` varchar(255) DEFAULT NULL COMMENT '投票方式'");}
if(!pdo_fieldexists('vote_res_activity','starttime')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `starttime` int(11) DEFAULT NULL COMMENT '活动开始时间'");}
if(!pdo_fieldexists('vote_res_activity','endtime')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `endtime` int(11) DEFAULT NULL COMMENT '活动结束时间'");}
if(!pdo_fieldexists('vote_res_activity','createtime')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `createtime` int(11) DEFAULT NULL COMMENT '活动创建时间'");}
if(!pdo_fieldexists('vote_res_activity','explain')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `explain` text COMMENT '活动中奖说明'");}
if(!pdo_fieldexists('vote_res_activity','thumb')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `thumb` varchar(255) DEFAULT NULL COMMENT '活动主题图'");}
if(!pdo_fieldexists('vote_res_activity','votedesc')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `votedesc` varchar(255) DEFAULT NULL COMMENT '投票区描述'");}
if(!pdo_fieldexists('vote_res_activity','fold')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `fold` tinyint(3) DEFAULT '0' COMMENT '是否折叠0-禁止 1-折叠'");}
if(!pdo_fieldexists('vote_res_activity','enabled')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity')." ADD   `enabled` tinyint(3) DEFAULT NULL COMMENT '是否开启 0-关闭 1-开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_vote_res_activity_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL COMMENT '活动ID',
  `name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `desc` varchar(255) DEFAULT NULL COMMENT '医生描述',
  `thumb` text COMMENT '图片',
  `url` varchar(255) DEFAULT NULL COMMENT '详情链接',
  `enabled` tinyint(3) DEFAULT NULL COMMENT '是否开启 0-关闭 1-开启',
  `createtime` int(11) DEFAULT NULL COMMENT '添加时间',
  `sort` int(11) DEFAULT NULL COMMENT '活动内容排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('vote_res_activity_content','id')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('vote_res_activity_content','uniacid')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('vote_res_activity_content','aid')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD   `aid` int(11) DEFAULT NULL COMMENT '活动ID'");}
if(!pdo_fieldexists('vote_res_activity_content','name')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD   `name` varchar(255) DEFAULT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('vote_res_activity_content','desc')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD   `desc` varchar(255) DEFAULT NULL COMMENT '医生描述'");}
if(!pdo_fieldexists('vote_res_activity_content','thumb')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD   `thumb` text COMMENT '图片'");}
if(!pdo_fieldexists('vote_res_activity_content','url')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD   `url` varchar(255) DEFAULT NULL COMMENT '详情链接'");}
if(!pdo_fieldexists('vote_res_activity_content','enabled')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD   `enabled` tinyint(3) DEFAULT NULL COMMENT '是否开启 0-关闭 1-开启'");}
if(!pdo_fieldexists('vote_res_activity_content','createtime')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD   `createtime` int(11) DEFAULT NULL COMMENT '添加时间'");}
if(!pdo_fieldexists('vote_res_activity_content','sort')) {pdo_query("ALTER TABLE ".tablename('vote_res_activity_content')." ADD   `sort` int(11) DEFAULT NULL COMMENT '活动内容排序'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_vote_res_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL COMMENT '投票用户ID',
  `contentid` int(11) DEFAULT NULL COMMENT '投票内容ID',
  `createtime` int(11) DEFAULT NULL COMMENT '投票时间,注一天一次',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('vote_res_log','id')) {pdo_query("ALTER TABLE ".tablename('vote_res_log')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('vote_res_log','uniacid')) {pdo_query("ALTER TABLE ".tablename('vote_res_log')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('vote_res_log','mid')) {pdo_query("ALTER TABLE ".tablename('vote_res_log')." ADD   `mid` int(11) DEFAULT NULL COMMENT '投票用户ID'");}
if(!pdo_fieldexists('vote_res_log','contentid')) {pdo_query("ALTER TABLE ".tablename('vote_res_log')." ADD   `contentid` int(11) DEFAULT NULL COMMENT '投票内容ID'");}
if(!pdo_fieldexists('vote_res_log','createtime')) {pdo_query("ALTER TABLE ".tablename('vote_res_log')." ADD   `createtime` int(11) DEFAULT NULL COMMENT '投票时间,注一天一次'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_vote_res_lottery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL COMMENT '中奖用户ID',
  `enabled` tinyint(3) DEFAULT NULL COMMENT '中奖状态 -1-无效 0-待确认  1-有效 2-已发送',
  `createtime` int(11) DEFAULT NULL COMMENT '中奖时间',
  `beizhu` text COMMENT '审核备注',
  `vote_res_lottery` int(8) DEFAULT NULL COMMENT '活动ID',
  `activid` int(8) DEFAULT NULL COMMENT '活动ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('vote_res_lottery','id')) {pdo_query("ALTER TABLE ".tablename('vote_res_lottery')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('vote_res_lottery','uniacid')) {pdo_query("ALTER TABLE ".tablename('vote_res_lottery')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('vote_res_lottery','mid')) {pdo_query("ALTER TABLE ".tablename('vote_res_lottery')." ADD   `mid` int(11) DEFAULT NULL COMMENT '中奖用户ID'");}
if(!pdo_fieldexists('vote_res_lottery','enabled')) {pdo_query("ALTER TABLE ".tablename('vote_res_lottery')." ADD   `enabled` tinyint(3) DEFAULT NULL COMMENT '中奖状态 -1-无效 0-待确认  1-有效 2-已发送'");}
if(!pdo_fieldexists('vote_res_lottery','createtime')) {pdo_query("ALTER TABLE ".tablename('vote_res_lottery')." ADD   `createtime` int(11) DEFAULT NULL COMMENT '中奖时间'");}
if(!pdo_fieldexists('vote_res_lottery','beizhu')) {pdo_query("ALTER TABLE ".tablename('vote_res_lottery')." ADD   `beizhu` text COMMENT '审核备注'");}
if(!pdo_fieldexists('vote_res_lottery','vote_res_lottery')) {pdo_query("ALTER TABLE ".tablename('vote_res_lottery')." ADD   `vote_res_lottery` int(8) DEFAULT NULL COMMENT '活动ID'");}
if(!pdo_fieldexists('vote_res_lottery','activid')) {pdo_query("ALTER TABLE ".tablename('vote_res_lottery')." ADD   `activid` int(8) DEFAULT NULL COMMENT '活动ID'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_vote_res_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL COMMENT '用户ID',
  `realname` varchar(255) DEFAULT NULL COMMENT '用户姓名',
  `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称',
  `mobile` varchar(20) DEFAULT NULL COMMENT '用户联系方式',
  `type` tinyint(3) DEFAULT NULL COMMENT '用户类型',
  `createtime` int(11) DEFAULT NULL COMMENT '用户信息完善时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('vote_res_member','id')) {pdo_query("ALTER TABLE ".tablename('vote_res_member')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('vote_res_member','uniacid')) {pdo_query("ALTER TABLE ".tablename('vote_res_member')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('vote_res_member','openid')) {pdo_query("ALTER TABLE ".tablename('vote_res_member')." ADD   `openid` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('vote_res_member','mid')) {pdo_query("ALTER TABLE ".tablename('vote_res_member')." ADD   `mid` int(11) DEFAULT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('vote_res_member','realname')) {pdo_query("ALTER TABLE ".tablename('vote_res_member')." ADD   `realname` varchar(255) DEFAULT NULL COMMENT '用户姓名'");}
if(!pdo_fieldexists('vote_res_member','nickname')) {pdo_query("ALTER TABLE ".tablename('vote_res_member')." ADD   `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称'");}
if(!pdo_fieldexists('vote_res_member','mobile')) {pdo_query("ALTER TABLE ".tablename('vote_res_member')." ADD   `mobile` varchar(20) DEFAULT NULL COMMENT '用户联系方式'");}
if(!pdo_fieldexists('vote_res_member','type')) {pdo_query("ALTER TABLE ".tablename('vote_res_member')." ADD   `type` tinyint(3) DEFAULT NULL COMMENT '用户类型'");}
if(!pdo_fieldexists('vote_res_member','createtime')) {pdo_query("ALTER TABLE ".tablename('vote_res_member')." ADD   `createtime` int(11) DEFAULT NULL COMMENT '用户信息完善时间'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_vote_res_member_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL COMMENT '活动内容排序',
  `typename` varchar(255) DEFAULT NULL COMMENT '用户类型',
  `enabled` tinyint(3) DEFAULT NULL COMMENT '是否启用 0-禁用 1-启用',
  `createtime` int(11) DEFAULT NULL COMMENT '用户类型创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('vote_res_member_type','id')) {pdo_query("ALTER TABLE ".tablename('vote_res_member_type')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('vote_res_member_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('vote_res_member_type')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('vote_res_member_type','sort')) {pdo_query("ALTER TABLE ".tablename('vote_res_member_type')." ADD   `sort` int(11) DEFAULT NULL COMMENT '活动内容排序'");}
if(!pdo_fieldexists('vote_res_member_type','typename')) {pdo_query("ALTER TABLE ".tablename('vote_res_member_type')." ADD   `typename` varchar(255) DEFAULT NULL COMMENT '用户类型'");}
if(!pdo_fieldexists('vote_res_member_type','enabled')) {pdo_query("ALTER TABLE ".tablename('vote_res_member_type')." ADD   `enabled` tinyint(3) DEFAULT NULL COMMENT '是否启用 0-禁用 1-启用'");}
if(!pdo_fieldexists('vote_res_member_type','createtime')) {pdo_query("ALTER TABLE ".tablename('vote_res_member_type')." ADD   `createtime` int(11) DEFAULT NULL COMMENT '用户类型创建时间'");}
