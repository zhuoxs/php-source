<?php
/**
 * Created by PhpStorm.
 * User: 资源邦源码网
 * Date: 2017/12/8 0008
 * Time: 17:47
 */
$sql = <<<EOF

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_play_friend` (
  `id` int(11) NOT NULL COMMENT 'id' AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `friend_uid` int(11) NOT NULL COMMENT '好友uid',
  `create_time` int(11) NOT NULL COMMENT '成为好友时间',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_play_land_opeartion` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_number` char(50) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `adopt_id` int(11) NOT NULL COMMENT '认养id',
  `is_pay` tinyint(1) NOT NULL COMMENT '0 未支付 1已支付',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `total_price` float NOT NULL COMMENT '订单总价',
  `pra_price` float NOT NULL COMMENT '实际支付金额',
  `is_operation` tinyint(1) NOT NULL COMMENT '0 未操作 1已操作 2已退款',
  `operation_type` tinyint(1) NOT NULL COMMENT '1 施肥 2除草 3 捉虫',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `body` char(200) NOT NULL COMMENT '说明',
  `form_id` char(200) NOT NULL COMMENT '模板消息推送formid',
  `uniontid` char(200) NOT NULL,
  `operation_time` int(11) NOT NULL COMMENT '操作时间',
  `area` int(11) NOT NULL COMMENT '操作面积',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_play_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ikey` char(200) NOT NULL,
  `value` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_play_visit` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `visit_uid` int(11) NOT NULL COMMENT '来拜访用户uid',
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL COMMENT '时间',
  `operation` tinyint(4) NOT NULL COMMENT '1加 2减',
  `body` char(200) NOT NULL COMMENT '说明',
  `gold` int(11) NOT NULL COMMENT '操作金币数量',
  `visit_type` tinyint(1) NOT NULL COMMENT '0/拜访 1偷取',
  `plant_id` int(11) NOT NULL COMMENT '种植id',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_play_shed_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_number` char(50) NOT NULL COMMENT '升级订单编号',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `is_pay` tinyint(1) NOT NULL COMMENT '0未支付 1已支付',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `uniacid` int(11) NOT NULL COMMENT '小程序唯一id',
  `total_price` float NOT NULL COMMENT '总价',
  `pra_price` float NOT NULL COMMENT '实际支付金额',
  `upgrade_area` float NOT NULL COMMENT '升级面积',
  `body` char(200) NOT NULL COMMENT '说明',
  `pay_method` char(200) NOT NULL COMMENT '支付方式',
  `uniontid` char(100) NOT NULL COMMENT '商户订单号',
  `create_time` int(11) NOT NULL COMMENT '订单创建时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


ALTER TABLE `ims_cqkundian_farm_animal` ADD `sports_src` TEXT NOT NULL;
ALTER TABLE `ims_cqkundian_farm_user` ADD `shed_area` FLOAT NOT NULL;
ALTER TABLE `ims_cqkundian_farm_user` ADD `first_shed_send` tinyint(1) NOT NULL;
ALTER TABLE `ims_cqkundian_farm_user` ADD `first_send_money` tinyint(1) NOT NULL;

EOF;
pdo_run($sql);