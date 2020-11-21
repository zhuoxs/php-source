<?php
pdo_query("
CREATE TABLE IF NOT EXISTS `bg_public_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '小程序名称',
  `logo` longtext COMMENT 'logo',
  `tel` varchar(50) DEFAULT NULL COMMENT '电话',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `summary` longtext COMMENT '描述',
  `appid` varchar(255) DEFAULT NULL COMMENT '公众号appid',
  `app_secret` varchar(255) DEFAULT NULL COMMENT '公众号密钥',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '商户号id',
  `mch_key` varchar(255) DEFAULT NULL COMMENT '商户号密钥',
  `cert_pem` longtext COMMENT '微信支付证书cert',
  `key_pem` longtext COMMENT '微信支付证书key',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信公众号配置表';

CREATE TABLE IF NOT EXISTS `bg_public_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '用户微信openid',
  `nickname` varchar(255) DEFAULT NULL COMMENT '微信名称',
  `avatar` longtext COMMENT '头像',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公众号用户表';

CREATE TABLE IF NOT EXISTS `bg_public_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `tpl_id` varchar(255) DEFAULT NULL COMMENT '模板编号',
  `tpl` longtext COMMENT '模板id',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公众号模板消息配置';
");

if(!pdo_fieldexists('bg_user', 'is_mobile')) {
    pdo_query("ALTER TABLE `bg_user` ADD `is_mobile` TINYINT(4) NOT NULL DEFAULT '0' ;");
}
if(!pdo_fieldexists('bg_order_refund', 'refund_address')) {
    pdo_query("ALTER TABLE `bg_order_refund` ADD `refund_address` VARCHAR(655) NULL DEFAULT NULL;");
}
if(!pdo_fieldexists('bg_platform_settings', 'is_token')) {
    pdo_query("ALTER TABLE `bg_platform_settings` ADD `is_token` TINYINT(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('bg_public_user', 'update_time')) {
    pdo_query("ALTER TABLE `bg_public_user` ADD `update_time` INT(11) NULL DEFAULT NULL;");
}
if(!pdo_fieldexists('bg_user', 'official_id')) {
    pdo_query("ALTER TABLE `bg_user` ADD `official_id` INT(11) NULL DEFAULT NULL;");
}
if(!pdo_fieldexists('bg_printer', 'status')) {
    pdo_query("ALTER TABLE `bg_printer` ADD `status` TINYINT(4) NOT NULL DEFAULT '1'");
}
