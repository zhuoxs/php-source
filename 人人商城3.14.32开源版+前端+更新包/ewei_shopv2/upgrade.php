<?php
pdo_query("

CREATE TABLE IF NOT EXISTS `ims_ewei_shop_queue`(
	`id` int(11) NOT NULL  auto_increment , 
	`channel` varchar(255) COLLATE utf8_general_ci NOT NULL  , 
	`job` blob NOT NULL  , 
	`pushed_at` int(11) NOT NULL  , 
	`ttr` int(11) NOT NULL  , 
	`delay` int(11) NOT NULL  DEFAULT 0 , 
	`priority` int(11) unsigned NOT NULL  DEFAULT 1024 , 
	`reserved_at` int(11) NULL  , 
	`attempt` int(11) NULL  , 
	`done_at` int(11) NULL  , 
	PRIMARY KEY (`id`) , 
	KEY `channel`(`channel`) , 
	KEY `reserved_at`(`reserved_at`) , 
	KEY `priority`(`priority`) 
) ENGINE=MyISAM DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';


ALTER TABLE `ims_ewei_shop_member_credit_record` 
	ADD COLUMN `presentcredit` decimal(10,2)   NOT NULL DEFAULT 0.00 after `module` ;

");

