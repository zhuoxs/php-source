-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 12 月 09 日 22:08
-- 服务器版本: 5.0.77
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `kangle`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `last_login` datetime default NULL,
  `last_ip` varchar(255) default NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `agent`
--

CREATE TABLE IF NOT EXISTS `agent` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `agent_price`
--

CREATE TABLE IF NOT EXISTS `agent_price` (
  `agent_id` int(11) NOT NULL,
  `product_type` tinyint(4) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY  (`agent_id`,`product_type`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `flow_day`
--

CREATE TABLE IF NOT EXISTS `flow_day` (
  `name` varchar(32) NOT NULL,
  `t` char(8) NOT NULL,
  `flow` bigint(20) NOT NULL,
  PRIMARY KEY  (`name`,`t`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `flow_hour`
--

CREATE TABLE IF NOT EXISTS `flow_hour` (
  `name` varchar(32) NOT NULL,
  `t` char(10) NOT NULL,
  `flow` bigint(20) NOT NULL,
  PRIMARY KEY  (`name`,`t`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `flow_month`
--

CREATE TABLE IF NOT EXISTS `flow_month` (
  `name` varchar(32) NOT NULL,
  `t` char(6) NOT NULL,
  `flow` int(11) NOT NULL,
  PRIMARY KEY  (`name`,`t`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- 表的结构 `money_in`
--

CREATE TABLE IF NOT EXISTS `money_in` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `money` int(11) NOT NULL default '0',
  `start_time` datetime NOT NULL,
  `end_time` datetime default NULL,
  `gw` tinyint(4) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  `gwid` varchar(255) default NULL,
  `mem` TEXT default NULL,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `money_out`
--

CREATE TABLE IF NOT EXISTS `money_out` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `money` int(11) NOT NULL,
  `add_time` datetime NOT NULL,
  `mem` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mproduct`
--

CREATE TABLE IF NOT EXISTS `mproduct` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `group_id` int(11) NOT NULL default '0',
  `upid` int(11) NOT NULL default '0',
  `describe` text,
  `price` int(11) NOT NULL default '0',
  `month_flag` tinyint(4) NOT NULL default '0',
  `pause_flag` tinyint(4) NOT NULL default '0',
  `show_price` tinyint(4) NOT NULL default '0',
  `template` varchar(255) DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='非自动产品';

-- --------------------------------------------------------

--
-- 表的结构 `mproduct_group`
--

CREATE TABLE IF NOT EXISTS `mproduct_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `describe` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mproduct_order`
--

CREATE TABLE IF NOT EXISTS `mproduct_order` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `client_msg` text ,
  `admin_msg` text ,
  `admin_mem` text ,
  `price` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL default 0,
  `commodity_id` int(11) NOT NULL default 0,
  `commodity_name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `add_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `module` varchar(255) NOT NULL,
  `name` varchar(32) NOT NULL,
  `host` varchar(64) NOT NULL,
  `port` int(11) NOT NULL,
  `user` varchar(32) default NULL,
  `userpasswd` varchar(255) DEFAULT NULL,
  `max_count` int(11) NOT NULL DEFAULT '0',
  `create_count` int(11) NOT NULL DEFAULT '0',
  `passwd` varchar(32) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `intranet_host` varchar(255) default NULL,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `add_time` datetime NOT NULL,
  `status` int(11) NOT NULL default '0',
  `admin` varchar(32) default NULL,
  `reply` text,
  `reply_time` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL default '0',
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `email` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `money` int(11) NOT NULL default '0',
  `id` varchar(255) default NULL,
  `regtime` datetime NOT NULL,
  `agent_id` int(11) NOT NULL default '0',
  `agent_hash` varchar(255) DEFAULT NULL,
  `flow` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`username`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `vhost`
--

CREATE TABLE IF NOT EXISTS `vhost` (
  `name` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `doc_root` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL auto_increment,
  `gid` varchar(32) NOT NULL default '1100',
  `templete` varchar(255) NOT NULL,
  `subtemplete` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  `node` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `flow` bigint(20) NOT NULL default '0',
  `db_type` varchar(255) NOT NULL default 'mysql',
  `try_is` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `name` (`name`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `vhost_product`
--

CREATE TABLE IF NOT EXISTS `vhost_product` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `describe` text,
  `templete` varchar(32) NOT NULL,
  `web_quota` bigint(11) NOT NULL,
  `db_quota` bigint(20) NOT NULL default '0',
  `price` int(11) NOT NULL,
  `pause_flag` tinyint(4) default '0',
  `node` varchar(32) NOT NULL,
  `try_flag` tinyint(4) default '0',
  `month_flag` tinyint(4) default '0',
  `subdir_flag` tinyint(4) NOT NULL default '0',
  `subdir` varchar(255) NOT NULL default '/',
  `subtemplete` varchar(255) default NULL,
  `domain` int(11) NOT NULL default '-1',
  `upid` int(11) NOT NULL default '0',
  `ftp` int(11) NOT NULL default '1',
  `htaccess` tinyint(4) default '1',
  `access` tinyint(4) default '1',
  `log_file` tinyint(4) default '1',
  `max_connect` int(11) NOT NULL default '0',
  `speed_limit` int(11) default '0',
  `view` int(11) NOT NULL default '0',
  `cs` tinyint(4) default '0',
  `envs` text,
  `cdn` tinyint(4) default '0',
  `flow` bigint(20) NOT NULL default '0',
  `show_price` tinyint(4) NOT NULL default '0',
  `db_type` varchar(255) NOT NULL default 'mysql',
  `max_subdir` int(11) NOT NULL default '0',
  `max_worker` int(11) NOT NULL default '0',
  `max_queue` int(11) NOT NULL default '0',
  `log_handle` tinyint(4) NOT NULL default '0',
  `try_on` tinyint(4) NOT NULL default '0',
  `append_params` varchar(255) DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `vhost_webapp`
--

CREATE TABLE IF NOT EXISTS `vhost_webapp` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  `install_time` datetime default NULL,
  `appid` varchar(16) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `dir` varchar(32) NOT NULL,
  `phy_dir` varchar(255) NOT NULL,
  `appname` varchar(64) default NULL,
  `appver` varchar(16) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`user`,`appid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `operate_log`
--

CREATE TABLE IF NOT EXISTS `operate_log` (
  `source` varchar(255) NOT NULL,
  `log_level` tinyint(4) NOT NULL DEFAULT '0',
  `operate` varchar(255) NOT NULL,
  `operate_object` varchar(255) NOT NULL,
  `operate_time` datetime NOT NULL,
  `mem` varchar(255) DEFAULT NULL,
  `mem2` text,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- 表的结构 `product_group`
--

CREATE TABLE IF NOT EXISTS `product_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255)  NOT NULL,
  `group_info` text,
  `call_mode` varchar(128) DEFAULT NULL,
  `pay_cycle` varchar(255) NOT NULL,
  `product_module` varchar(255) DEFAULT NULL,
  `allow_upgrade` tinyint(4) NOT NULL DEFAULT '1',
  `entkey_preg` varchar(255) DEFAULT NULL,
  `email_module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- 表的结构 `commodity`
--

CREATE TABLE IF NOT EXISTS `commodity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mproduct_id` tinyint(4) DEFAULT NULL,
  `commodity_name` varchar(255) NOT NULL,
  `commodity_info` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `add_time` datetime NOT NULL,
  `try_time` datetime DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `ent_key`
--

CREATE TABLE IF NOT EXISTS `ent_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `randkey` varchar(255) NOT NULL,
  `price` varchar(64) NOT NULL,
  `agent_user` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `add_time` datetime NOT NULL,
  `try_time` datetime DEFAULT NULL,
  `expire_time` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `randkey` (`randkey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `setting` (`name` ,`value`)VALUES ('entkey_max_count', '1');
--
-- 表的结构 `hosting`
--

CREATE TABLE IF NOT EXISTS `hosting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `passwd_type` varchar(128) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `nodename` varchar(255) DEFAULT NULL,
  `module` varchar(255) NOT NULL,
  `module_type` varchar(255) NOT NULL DEFAULT 'servers',
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `try_is` tinyint(4) NOT NULL DEFAULT '0',
  `lastcrontime` datetime DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `configoption1` varchar(255) DEFAULT NULL,
  `configoption2` varchar(255) DEFAULT NULL,
  `configoption3` varchar(255) DEFAULT NULL,
  `configoption4` varchar(255) DEFAULT NULL,
  `configoption5` varchar(255) DEFAULT NULL,
  `configoption6` varchar(255) DEFAULT NULL,
  `configoption7` varchar(255) DEFAULT NULL,
  `configoption8` varchar(255) DEFAULT NULL,
  `configoption9` varchar(255) DEFAULT NULL,
  `configoption10` varchar(255) DEFAULT NULL,
  `configoption11` varchar(255) DEFAULT NULL,
  `configoption12` varchar(255) DEFAULT NULL,
  `configoption13` varchar(255) DEFAULT NULL,
  `configoption14` varchar(255) DEFAULT NULL,
  `configoption15` varchar(255) DEFAULT NULL,
  `configoption16` varchar(255) DEFAULT NULL,
  `configoption17` varchar(255) DEFAULT NULL,
  `configoption18` varchar(255) DEFAULT NULL,
  `configoption19` varchar(255) DEFAULT NULL,
  `configoption20` varchar(255) DEFAULT NULL,
  `configoption21` varchar(255) DEFAULT NULL,
  `configoption22` varchar(255) DEFAULT NULL,
  `configoption23` varchar(255) DEFAULT NULL,
  `configoption24` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `nproducts`
--

CREATE TABLE IF NOT EXISTS `nproducts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `try_flag` tinyint(4) NOT NULL DEFAULT '0',
  `configoption1` varchar(255) DEFAULT NULL,
  `configoption2` varchar(255) DEFAULT NULL,
  `configoption3` varchar(255) DEFAULT NULL,
  `configoption4` varchar(255) DEFAULT NULL,
  `configoption5` varchar(255) DEFAULT NULL,
  `configoption6` varchar(255) DEFAULT NULL,
  `configoption7` varchar(255) DEFAULT NULL,
  `configoption8` varchar(255) DEFAULT NULL,
  `configoption9` varchar(255) DEFAULT NULL,
  `configoption10` varchar(255) DEFAULT NULL,
  `configoption11` varchar(255) DEFAULT NULL,
  `configoption12` varchar(255) DEFAULT NULL,
  `configoption13` varchar(255) DEFAULT NULL,
  `configoption14` varchar(255) DEFAULT NULL,
  `configoption15` varchar(255) DEFAULT NULL,
  `configoption16` varchar(255) DEFAULT NULL,
  `configoption17` varchar(255) DEFAULT NULL,
  `configoption18` varchar(255) DEFAULT NULL,
  `configoption19` varchar(255) DEFAULT NULL,
  `configoption20` varchar(255) DEFAULT NULL,
  `configoption21` varchar(255) DEFAULT NULL,
  `configoption22` varchar(255) DEFAULT NULL,
  `configoption23` varchar(255) DEFAULT NULL,
  `configoption24` varchar(255) DEFAULT NULL,
  `describe` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- 表的结构 `servers`
--


CREATE TABLE IF NOT EXISTS `servers` (
   `group_id` int(11) NOT NULL,
  `nodename` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  UNIQUE KEY `group_id` (`group_id`,`nodename`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- 表的结构 `mailcron`
--

CREATE TABLE IF NOT EXISTS `mailcron` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(64) NOT NULL,
  `hostingname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `add_time` datetime NOT NULL,
  `try_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `domainextension`
--

CREATE TABLE IF NOT EXISTS `domainextension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extension` varchar(255) NOT NULL,
  `dnsmanagement` varchar(255) NOT NULL,
  `emailforwarding` varchar(255) NOT NULL,
  `idprotection` varchar(255) NOT NULL,
  `eppcode` varchar(255) NOT NULL,
  `autoreg` varchar(255) NOT NULL,
  `order` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `extension` (`extension`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- 表的结构 `domainprice`
--

CREATE TABLE IF NOT EXISTS `domainprice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domainextensionid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `oneyear` int(11) NOT NULL DEFAULT '0',
  `twoyear` int(11) NOT NULL DEFAULT '0',
  `threeyear` int(11) NOT NULL DEFAULT '0',
  `fouryear` int(11) NOT NULL DEFAULT '0',
  `fiveyear` int(11) NOT NULL DEFAULT '0',
  `sixyear` int(11) NOT NULL DEFAULT '0',
  `sevenyear` int(11) NOT NULL DEFAULT '0',
  `eightyear` int(11) NOT NULL DEFAULT '0',
  `nineyear` int(11) NOT NULL DEFAULT '0',
  `tenyear` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `domainextensionid` (`domainextensionid`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `registrar` varchar(255) NOT NULL,
  `add_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `registrars`
--

CREATE TABLE IF NOT EXISTS `registrars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrar` varchar(255) NOT NULL,
  `setting` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- 表的结构 `article`
--
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(64) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `createtime` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `articletype` (
  `name` varchar(32) NOT NULL,
  `value` varchar(32) NOT NULL,
  `level` tinyint(4) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `setting` (`name`, `value`) VALUES ('no_admin_old_product', '1');
INSERT INTO `setting` (`name`, `value`) VALUES ('no_user_old_product', '1');

