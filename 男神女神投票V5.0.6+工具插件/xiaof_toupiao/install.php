<?php
defined('IN_IA') or exit('Access Denied');

$branch = 'module_version';

$installsql = "CREATE TABLE IF NOT EXISTS " . tablename('xiaof_relation') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rid` int(10) UNSIGNED NOT NULL,
  `uniacid` smallint(6) UNSIGNED NOT NULL,
  `oauth_uniacid` smallint(6) UNSIGNED NOT NULL,
  `openid` char(28) NOT NULL,
  `oauth_openid` char(28) NOT NULL,
  `unionid` char(28) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `credit` decimal(10,2) UNSIGNED NOT NULL,
  `follow` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `joins` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `gps_city` varchar(100) NOT NULL,
  `fans_city` varchar(100) NOT NULL,
  `address` varchar(512) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `oauth_uniacid` (`oauth_uniacid`),
  KEY `oauth_openid` (`oauth_openid`),
  KEY `openid` (`openid`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `groups` tinyint(3) UNSIGNED NOT NULL,
  `verify` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `entryfee` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `locking` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `locking_count` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `openid` varchar(35) NOT NULL,
  `referee` varchar(35) NOT NULL DEFAULT '' COMMENT '推荐人openid',
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `cover` int(10) UNSIGNED NOT NULL,
  `poster` varchar(255) NOT NULL,
  `sound` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `video_poster` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '视频封面',
  `describe` varchar(255) NOT NULL,
  `detail` text,
  `data` mediumtext NOT NULL,
  `click` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `share` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `good` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `realgood` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `videourl` varchar(255) NOT NULL  DEFAULT '' COMMENT '抖音视频链接',
  `originaurl` varchar(255) NOT NULL  DEFAULT '' COMMENT '抖音原始链接',
  `title` varchar(255) NOT NULL  DEFAULT '' COMMENT '抖音视频标题',
  `open` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `double_num` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `double_at` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `locking_at` int(10) UNSIGNED NOT NULL,
  `lng` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '经度',
  `lat` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '纬度',
  `created_at` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `updated_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sid_2` (`sid`,`openid`),
  KEY `phone` (`phone`),
  KEY `sid` (`sid`),
  KEY `verify` (`verify`),
  KEY `groups` (`groups`),
  KEY `locking` (`locking`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_acid') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_doublelog') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `double_num` tinyint(2) UNSIGNED NOT NULL,
  `double_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_draw') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `prizeid` tinyint(3) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `vusername` varchar(50) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `uses` tinyint(1) UNSIGNED NOT NULL DEFAULT '2',
  `attr` tinyint(3) UNSIGNED NOT NULL,
  `credit` smallint(6) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `num` varchar(50) NOT NULL,
  `openid` char(28) NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `bdelete_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `rid` (`rid`),
  KEY `attr` (`attr`),
  KEY `uses` (`uses`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_drawlog') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `uname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `attr` tinyint(3) UNSIGNED NOT NULL,
  `data` varchar(255) NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_redpack') . " (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) unsigned NOT NULL,
  `uniacid` smallint(6) unsigned NOT NULL,
  `openid` char(28) NOT NULL,
  `num` decimal(5,2) unsigned NOT NULL,
  `action` varchar(50) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `openid` (`openid`),
  KEY `uniacid` (`uniacid`),
  KEY `action` (`action`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_giving') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `actions` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `givingid` tinyint(3) UNSIGNED NOT NULL,
  `givingnum` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `giving_name` varchar(20) NOT NULL,
  `num` varchar(20) NOT NULL,
  `buycredit` decimal(10,2) UNSIGNED NOT NULL,
  `leftcredit` decimal(10,2) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `openid` char(28) NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `actual_num` smallint(6) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `data` varchar(1000) NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `day_at` int(8) UNSIGNED NOT NULL,
  `use_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `rid` (`rid`),
  KEY `status` (`status`),
  KEY `pid` (`pid`),
  KEY `day_at` (`day_at`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_log') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `fanid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `num` smallint(6) UNSIGNED NOT NULL DEFAULT '1',
  `openid` char(28) NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `region` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `valid` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `ua` varchar(50) NOT NULL,
  `unique_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid_2` (`pid`,`rid`,`unique_at`),
  KEY `pid` (`pid`),
  KEY `sid_2` (`sid`),
  KEY `ip` (`ip`),
  KEY `unique_at` (`unique_at`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_manage') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `mid` varchar(50) NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `num` smallint(6) UNSIGNED NOT NULL,
  `operation` varchar(20) NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid` (`pid`,`ip`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_order') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `actions` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `uniacid` smallint(6) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `relationid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `openid` char(28) NOT NULL,
  `oauth_acid` smallint(6) UNSIGNED NOT NULL,
  `oauth_openid` char(28) NOT NULL,  
  `tid` varchar(64) NOT NULL,
  `uniontid` varchar(40) NOT NULL,
  `transid` varchar(40) NOT NULL,
  `fee` decimal(10,2) UNSIGNED NOT NULL,
  `credit` decimal(10,2) UNSIGNED NOT NULL,
  `data` varchar(200) NOT NULL,
  `num` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `type` tinyint(1) UNSIGNED NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_at` int(10) UNSIGNED NOT NULL,
  `complete_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tid` (`tid`),
  KEY `uniacid` (`uniacid`,`rid`),
  KEY `sid` (`sid`),
  KEY `status` (`status`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_pic') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `order` int(10) UNSIGNED NOT NULL,
  `is_show` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`,`pid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_rule') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rid` smallint(6) UNSIGNED NOT NULL,
  `uniacid` smallint(6) UNSIGNED NOT NULL,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `action` tinyint(1) UNSIGNED NOT NULL,
  `keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_safe') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) UNSIGNED NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sid` (`sid`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_setting') . " (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uniacid` smallint(6) UNSIGNED NOT NULL,
  `tit` varchar(255) NOT NULL,
  `data` mediumtext NOT NULL,
  `groups` text NOT NULL,
  `unfollow` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '活动状态 0：正常  1：放入回收站',
  `isrun` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '活动状态 0：进行中  1：停止进行',
  `admin` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `detail` mediumtext NOT NULL,
  `bottom` text NOT NULL,
  `click` int(11) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `unfollow` (`unfollow`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_smslog') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  `unique_at` int(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`),
  KEY `ip` (`ip`),
  KEY `day` (`unique_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_verificationuser') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` int(10) UNSIGNED NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` varchar(8) NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_verificationuserlog') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `openid` varchar(28) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `create_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_cache') . " (
  `key` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `expiration` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_icache') . " (
  `id` int(10) UNSIGNED NOT NULL,
  `value` varchar(255) NOT NULL,
  `count` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `expiration` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_share_log') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uniacid` smallint(6) UNSIGNED NOT NULL,
  `sid` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `votes` int(10) UNSIGNED NOT NULL,
  `openid` varchar(28) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `region` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `ua` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `dateline` int(10) UNSIGNED NOT NULL,
  `result` varchar(10) NOT NULL,
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_report_log') . " (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uniacid` smallint(6) UNSIGNED NOT NULL,
  `sid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `dateline` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_plugin_guestbook') . " (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '公众号id',
  `sid` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '活动id',
  `tpid` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '选手id,xiaof_toupiao.id',
  `uid` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '留言人uid',
  `username` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` VARCHAR(30) NOT NULL DEFAULT '' COMMENT '手机',
  `content` TEXT NULL COMMENT '留言内容',
  `status` TINYINT NOT NULL DEFAULT '0' COMMENT '状态0待审1通过2失败',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '时间戳',
  `created_at` int(10) UNSIGNED NOT NULL  DEFAULT '0' COMMENT '日期',
  PRIMARY KEY (`id`),
  INDEX `indx_uniacid` (`uniacid`),
  INDEX `indx_stu` (`sid`, `tpid`, `uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_mobile_ua') . " (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ua` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '手机ua',
  `title` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '手机型号中文名称',
  `status` TINYINT NOT NULL DEFAULT '0' COMMENT '是否启用0:不启用 1:启用',
  `remark` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '备注信息',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS " . tablename('xiaof_toupiao_gift_admin') . " (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '公众号id',
  `uid` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作员uid',
  `sid` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '活动id',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '时间戳',
  PRIMARY KEY (`id`),
  INDEX `indx_uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_run($installsql);

//xiaof_toupiao_mobile_ua表初始化数据
if(pdo_tableexists('xiaof_toupiao_mobile_ua')){
    $list = pdo_get('xiaof_toupiao_mobile_ua');
    if(empty($list)){
        pdo_insert('xiaof_toupiao_mobile_ua', array(
            'ua' => 'MT7-CL00',
            'title' => '华为Mate 7',
            'remark' => '系统初始化',
            'status' => 1,
            'createtime' => TIMESTAMP
        ));
        pdo_insert('xiaof_toupiao_mobile_ua', array(
            'ua' => 'SCL_TL00H',
            'title' => '华为荣耀4A',
            'remark' => '系统初始化',
            'status' => 1,
            'createtime' => TIMESTAMP
        ));
    }
}