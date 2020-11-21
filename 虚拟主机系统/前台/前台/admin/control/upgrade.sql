ALTER TABLE `vhost` DROP INDEX `name` , ADD UNIQUE `name` ( `name` ) ;
alter table vhost_product add column ftp int(11) NOT NULL DEFAULT '1';
alter table vhost_product add column htaccess tinyint(4) DEFAULT '1';
alter table vhost_product add column access tinyint(4) DEFAULT '1';
alter table vhost_product add column log_file tinyint(4) DEFAULT '1';
alter table vhost_product add column max_connect int(11) NOT NULL DEFAULT '0';
alter table vhost_product add column speed_limit INTEGER DEFAULT '0';
ALTER TABLE `users` ADD `uid` TINYINT( 11 ) NOT NULL DEFAULT '0' FIRST ,
ADD INDEX ( `uid` );
ALTER TABLE `nodes` CHANGE `user` `user` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `nodes` CHANGE `win` `win` TINYINT( 4 ) NULL DEFAULT '0';
ALTER TABLE `nodes` CHANGE `type` `type` INT( 11 ) NULL DEFAULT '0';
ALTER TABLE `nodes` CHANGE `user` `user` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE vhost_product ADD COLUMN `view` int( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` ADD `agent_id` INT NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS `agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `agent_price` (
  `agent_id` int(11) NOT NULL,
  `product_type` tinyint(4) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`agent_id`,`product_type`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
alter table vhost_product add column cs tinyint(4) DEFAULT '0';
alter table vhost_product add column envs TEXT;
alter table vhost_product add column cdn tinyint(4) DEFAULT '0';
ALTER TABLE `nodes` ADD `nickname` VARCHAR( 255 ) NOT NULL ;

CREATE TABLE IF NOT EXISTS `mproduct` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) character set utf8 NOT NULL,
  `group_id` int(11) NOT NULL,
  `upid` int(11) NULL,
  `describe` text character set utf8 NULL,
  `price` int(11) NOT NULL,
  `month_flag` tinyint(4) NULL default '0',
  `pause_flag` tinyint(4) NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mproduct_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `describe` text NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mproduct_order` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `client_msg` text,
  `admin_msg` text,
  `admin_mem` text,
  `price` int(11)  NULL,
  `month` int(11)  NULL,
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `status` tinyint(4)  NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `vhost` ADD `flow` BIGINT NOT NULL ;
ALTER TABLE `users` ADD `flow` BIGINT NOT NULL ;
ALTER TABLE `vhost_product` ADD `flow` BIGINT NOT NULL ;
ALTER TABLE `mproduct` ADD `show_price` tinyint(4) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `show_price` tinyint(4) NOT NULL DEFAULT '0';
ALTER TABLE `setting` CHANGE `value` `value` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE  `users` CHANGE  `flow`  `flow` BIGINT( 20 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `users` CHANGE  `uid`  `uid` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `vhost` CHANGE  `flow`  `flow` BIGINT( 20 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `vhost_product` CHANGE  `flow`  `flow` BIGINT( 20 ) NOT NULL DEFAULT  '0',CHANGE  `show_price`  `show_price` TINYINT( 4 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `mproduct` CHANGE  `group_id`  `group_id` INT( 11 ) NOT NULL DEFAULT  '0',
CHANGE  `upid`  `upid` INT( 11 ) NOT NULL DEFAULT  '0',
CHANGE  `price`  `price` INT( 11 ) NOT NULL DEFAULT  '0',
CHANGE  `month_flag`  `month_flag` TINYINT( 4 ) NOT NULL DEFAULT  '0',
CHANGE  `pause_flag`  `pause_flag` TINYINT( 4 ) NOT NULL DEFAULT  '0',
CHANGE  `show_price`  `show_price` TINYINT( 4 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `mproduct` CHANGE  `describe`  `describe` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `vhost` ADD `db_type` VARCHAR( 255 ) NOT NULL default 'mysql';
ALTER TABLE `vhost_product` ADD `db_type` VARCHAR( 255 ) NOT NULL default 'mysql';
ALTER TABLE `vhost_product` ADD `max_subdir` int(11) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `max_worker` int(11) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `max_queue`  int(11) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `log_handle` tinyint(4) NOT NULL default '0';
CREATE TABLE IF NOT EXISTS `operate_log` (
  `admin` varchar(255) NOT NULL,
  `operate` varchar(255) NOT NULL,
  `operate_object` varchar(255) NOT NULL,
  `operate_time` datetime NOT NULL,
  `mem` varchar(255) DEFAULT NULL,
  `mem2` text,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;
CREATE TABLE IF NOT EXISTS `product_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255)  NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `vhost` ADD `try_is` tinyint(4) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `try_on` tinyint(4) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `append_params` varchar(255) DEFAULT NULL;
ALTER TABLE `mproduct_order` CHANGE `status` `status` TINYINT( 4 ) NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS `commodity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mproduct_id` tinyint(4) DEFAULT NULL,
  `commodity_name` varchar(255) NOT NULL,
  `commodity_info` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `add_time` datetime NOT NULL,
  `try_time` datetime DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `money_in` ADD `mem` TEXT NULL AFTER `gwid`;
ALTER TABLE `mproduct` ADD `template` varchar(255) DEFAULT NULL;
ALTER TABLE `mproduct_order` ADD `commodity_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `status`;
ALTER TABLE `mproduct_order` ADD `commodity_name` VARCHAR( 255 ) NULL AFTER `commodity_id`;

CREATE TABLE IF NOT EXISTS `ent_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `randkey` varchar(255) NOT NULL,
  `price` varchar(64) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `add_time` datetime NOT NULL,
  `try_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `randkey` (`randkey`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `setting` (`name` ,`value`)VALUES ('entkey_max_count', '1');
ALTER TABLE `commodity` ADD `username` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `try_time`;
ALTER TABLE `ent_key` ENGINE = InnoDB;


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


ALTER TABLE `nodes` ADD `intranet_host` varchar(255) DEFAULT NULL;
ALTER TABLE `nodes` ADD `userpasswd` varchar(255) DEFAULT NULL;
ALTER TABLE `nodes` ADD `max_count` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `nodes` ADD `create_count` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `nodes` ADD `module`  varchar(255) DEFAULT NULL;

ALTER TABLE `product_group` ADD `group_info` text;
ALTER TABLE `product_group` ADD `call_mode` varchar(128) DEFAULT NULL;
ALTER TABLE `product_group` ADD `pay_cycle` varchar(255) NOT NULL;
ALTER TABLE `product_group` ADD `product_module` varchar(255) DEFAULT NULL;
ALTER TABLE `product_group` ADD `allow_upgrade` tinyint(4) NOT NULL DEFAULT '1';
ALTER TABLE `product_group` ADD `email_module` varchar(255) DEFAULT NULL;
ALTER TABLE `product_group` ADD `entkey_preg` varchar(255) DEFAULT NULL;

ALTER TABLE `operate_log` ADD `log_level` TINYINT( 4 ) NOT NULL DEFAULT '0';
ALTER TABLE `operate_log` CHANGE `admin` `source` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `ent_key` ADD `agent_user` varchar(255) DEFAULT NULL;
ALTER TABLE `ent_key` ADD `expire_time` date DEFAULT NULL;
ALTER TABLE `ent_key` CHANGE `price` `price` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

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
ALTER TABLE `users` ADD `agent_hash` VARCHAR( 255 ) NULL AFTER `agent_id` ;

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


