<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2017/12/8 0008
 * Time: 17:47
 */
$sql = <<<EOF

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` char(200) NOT NULL COMMENT '标题',
  `cover` text NOT NULL COMMENT '封面',
  `address` char(200) NOT NULL COMMENT '地址',
  `begin_time` int(11) NOT NULL COMMENT '开始时间',
  `end_time` int(11) NOT NULL COMMENT '结束时间',
  `phone` char(20) NOT NULL COMMENT '联系电话',
  `detail` text NOT NULL COMMENT '详细说明',
  `person_count` int(11) NOT NULL COMMENT '参加人数',
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0/不显示 1显示',
  `longitude` char(50) NOT NULL COMMENT '经度',
  `latitude` char(50) NOT NULL COMMENT '纬度',
  `start_time` int(11) NOT NULL COMMENT '活动开始时间',
  `is_check` tinyint(1) NOT NULL COMMENT '0/不审核 1/审核',
  `count` int(11) NOT NULL COMMENT '总数',
  `add_info` text NOT NULL COMMENT '报名信息',
  `times_enroll` tinyint(1) NOT NULL COMMENT '是否允许多次报名 1 是 0 否',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_active_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` char(50) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL,
  `active_id` int(11) NOT NULL COMMENT '活动id',
  `spec_id` int(11) NOT NULL COMMENT '规格id',
  `total_price` float NOT NULL COMMENT '订单总价',
  `count` int(11) NOT NULL COMMENT '数量',
  `is_pay` tinyint(1) NOT NULL COMMENT '0未支付 1已支付',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `pra_price` float NOT NULL COMMENT '实际支付金额',
  `uniontid` char(100) NOT NULL COMMENT '商户订单号',
  `pay_method` char(30) NOT NULL COMMENT '支付方式',
  `is_recycle` tinyint(4) NOT NULL COMMENT '0/ 1回收站',
  `sign_up` text NOT NULL COMMENT '报名信息',
  `qrcode` text NOT NULL COMMENT '电子票',
  `is_check` tinyint(4) NOT NULL COMMENT '0未审核 1/已通过 2已拒绝 3已参加',
  `apply_delete` tinyint(1) NOT NULL COMMENT '0否 1申请取消 2已取消',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_active_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ikey` char(50) NOT NULL,
  `value` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_active_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `spec_name` char(50) NOT NULL COMMENT '规格名称',
  `price` float NOT NULL COMMENT '价格',
  `spec_desc` char(200) NOT NULL COMMENT '描述',
  `uniacid` int(11) NOT NULL COMMENT '小程序唯一id',
  `active_id` int(11) NOT NULL COMMENT '活动id',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

EOF;
pdo_run($sql);