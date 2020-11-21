<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/8 0008
 * Time: 17:47
 */
$sql = <<<EOF

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_funding_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` char(50) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '用户',
  `pid` int(11) NOT NULL COMMENT '项目id',
  `spec_id` int(11) NOT NULL COMMENT '项目档位',
  `total_price` float NOT NULL COMMENT '订单总价',
  `pra_price` float NOT NULL COMMENT '实际支付金额',
  `create_time` int(11) NOT NULL COMMENT '下单时间',
  `pay_time` int(11) NOT NULL COMMENT '实际支付时间',
  `is_pay` tinyint(1) NOT NULL COMMENT '0/未支付 1/已支付',
  `is_send` tinyint(1) NOT NULL COMMENT '0 未发货 1已发货',
  `send_time` int(11) NOT NULL COMMENT '发货时间',
  `is_confirm` tinyint(1) NOT NULL COMMENT '0 未收货 1已收货',
  `confirm_time` int(11) NOT NULL COMMENT '收货时间',
  `apply_delete` tinyint(1) NOT NULL COMMENT '0 否 1申请取消 2/已取消',
  `remark` char(200) NOT NULL,
  `uniontid` char(200) NOT NULL COMMENT '商户订单号',
  `address` text NOT NULL COMMENT '收货信息',
  `pay_method` char(50) NOT NULL COMMENT '支付方式',
  `send_number` char(50) NOT NULL COMMENT '快递单号',
  `express_company` char(50) NOT NULL COMMENT '快递公司',
  `uniacid` int(11) NOT NULL COMMENT '小程序唯一id',
  `count` int(11) NOT NULL,
  `body` char(200) NOT NULL,
  `is_recycle` tinyint(1) NOT NULL COMMENT '0 否 1/回收站',
  `manager_remark` char(200) NOT NULL,
  `return_type` tinyint(1) NOT NULL COMMENT '1/项目投资 2众筹原物',
  `is_return` tinyint(1) NOT NULL COMMENT '0/未分红 1/已分红',
  `return_time` int(11) NOT NULL COMMENT '分红时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_funding_progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `content` text NOT NULL,
  `src` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `pro_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_funding_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `project_name` char(50) NOT NULL COMMENT '项目名称',
  `cover` text NOT NULL COMMENT '封面',
  `live_id` int(11) NOT NULL COMMENT '监控id',
  `target_money` float NOT NULL COMMENT '目标金额',
  `fund_money` float NOT NULL COMMENT '已筹金额',
  `fund_person_count` int(11) NOT NULL COMMENT '支持人数',
  `project_username` char(50) NOT NULL COMMENT '项目发起人',
  `begin_time` int(11) NOT NULL COMMENT '发起时间',
  `end_time` int(11) NOT NULL COMMENT '结束时间',
  `profit_send_time` int(11) NOT NULL COMMENT '收益发放时间',
  `project_detail` text NOT NULL COMMENT '图文详情',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `project_desc` text NOT NULL COMMENT '简单描述',
  `rank` int(11) NOT NULL,
  `is_hot` tinyint(1) NOT NULL COMMENT '0/否 1/热',
  `return_percent` float NOT NULL COMMENT '预计分红百分比',
  `is_return` tinyint(4) NOT NULL COMMENT '0/未分红 1/已分红',
  `fund_fictitious_money` float NOT NULL COMMENT '虚拟已筹金额',
  `fictitious_person` int(11) NOT NULL COMMENT '支持人数',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_funding_project_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(11) NOT NULL COMMENT '项目id',
  `price` float NOT NULL COMMENT '价格',
  `spec_desc` char(200) NOT NULL COMMENT '描述',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_plugin_funding_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ikey` char(50) NOT NULL,
  `value` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

EOF;
pdo_run($sql);