<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2017/12/8 0008
 * Time: 17:47
 */
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_pt_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `score` int(11) NOT NULL COMMENT '分数 12345',
  `src` text NOT NULL COMMENT '图片',
  `content` text NOT NULL COMMENT '评论内容',
  `create_time` int(11) NOT NULL COMMENT '评论时间',
  `order_id` int(11) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '用户UId',
  `uniacid` int(11) NOT NULL COMMENT '小程序编号',
  `status` tinyint(1) NOT NULL COMMENT '0 显示 1 隐藏',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_pt_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT '分类id',
  `goods_name` char(200) NOT NULL COMMENT '商品名称',
  `goods_desc` char(200) NOT NULL COMMENT '商品简单描述',
  `sale_count` int(11) NOT NULL COMMENT '销量',
  `cover` text NOT NULL COMMENT '封面',
  `slide_src` text NOT NULL COMMENT '轮播图',
  `video_src` text NOT NULL COMMENT '视频',
  `price` float NOT NULL COMMENT '单买价格',
  `pt_price` float NOT NULL COMMENT '团购价',
  `is_alone_buy` tinyint(1) NOT NULL COMMENT '1 允许单买 2 不允许单买',
  `pt_count` int(11) NOT NULL COMMENT '拼团人数',
  `server_content` char(200) NOT NULL COMMENT '服务内容',
  `count` int(11) NOT NULL COMMENT '商品库存',
  `is_open_sku` tinyint(1) NOT NULL COMMENT '0 不使用规格 1使用规格',
  `content` text NOT NULL COMMENT '商品详情',
  `is_put_away` tinyint(1) NOT NULL COMMENT '1 上架 2下架',
  `goods_qrcode` char(200) NOT NULL COMMENT '商品小程序码',
  `weight` int(11) NOT NULL COMMENT '商品重量',
  `freight` int(11) NOT NULL COMMENT '运费规则',
  `piece_free_shipping` int(11) NOT NULL COMMENT '单品满件包邮',
  `quota_free_shipping` float NOT NULL COMMENT '单品满额包邮',
  `sku` text NOT NULL COMMENT '商品规格',
  `rank` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序唯一id',
  `limit_time` int(11) NOT NULL COMMENT '拼团限时',
  `pt_time` int(11) NOT NULL COMMENT '拼团时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='组团商品表';

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_pt_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` char(100) NOT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `uniacid` int(11) NOT NULL,
  `total_price` float NOT NULL COMMENT '订单总价（含运费）',
  `pra_price` float NOT NULL COMMENT '实际支付金额',
  `express_price` float NOT NULL COMMENT '运费',
  `name` char(50) NOT NULL COMMENT '收货人姓名',
  `phone` char(20) NOT NULL COMMENT '联系电话',
  `address` char(200) NOT NULL COMMENT '收货地址',
  `is_pay` tinyint(1) NOT NULL COMMENT '0 未支付 1 已支付',
  `pay_method` char(20) NOT NULL COMMENT '支付方式',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `is_send` tinyint(1) NOT NULL COMMENT '0 未发货 1已发货',
  `send_time` int(11) NOT NULL COMMENT '发货时间',
  `express` char(50) NOT NULL COMMENT '物流公司',
  `express_no` char(100) NOT NULL COMMENT '物流编号',
  `is_confirm` tinyint(1) NOT NULL COMMENT '0 未收货 1已收货',
  `confirm_time` int(11) NOT NULL COMMENT '收货时间',
  `is_comment` tinyint(1) NOT NULL COMMENT '0未评价 1已评价',
  `apply_delete` tinyint(1) NOT NULL COMMENT '0 未取消 1 申请取消 2已取消',
  `is_group` tinyint(1) NOT NULL COMMENT '1 单买 2 团购',
  `is_success` tinyint(1) NOT NULL COMMENT '是否成团',
  `success_time` int(11) NOT NULL COMMENT '成团时间',
  `limit_time` int(11) NOT NULL COMMENT '拼团限时',
  `create_time` int(11) NOT NULL COMMENT '下单时间',
  `is_header` tinyint(1) NOT NULL COMMENT '0 不是团长 1是团长',
  `relation_id` int(11) NOT NULL COMMENT '团编号',
  `body` char(200) NOT NULL,
  `uniontid` char(100) NOT NULL COMMENT '商户订单号',
  `trans_id` char(100) NOT NULL COMMENT '微信支付交易号',
  `is_delete` tinyint(1) NOT NULL COMMENT '0 正常显示 1虚拟删除',
  `manager_discount` float NOT NULL COMMENT '平台优惠金额',
  `is_recycle` tinyint(1) NOT NULL COMMENT '0 否 1 放入回收站',
  `manager_remark` char(200) NOT NULL COMMENT '商家备注',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='组团商品订单表';

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_pt_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单号',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `num` int(11) NOT NULL COMMENT '数量',
  `price` float NOT NULL COMMENT '价格',
  `sku` text NOT NULL COMMENT '规格',
  `cover` text NOT NULL COMMENT '图片',
  `goods_name` char(200) NOT NULL COMMENT '商品名称',
  `sku_name` char(200) NOT NULL COMMENT '规格名称',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_pt_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '团长uid',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `create_time` int(11) NOT NULL COMMENT '开始时间',
  `end_time` int(11) NOT NULL COMMENT '结束时间',
  `status` tinyint(1) NOT NULL COMMENT '0未支付 1 拼团中 2 拼团成功 3 拼团失败',
  `ptnumber` int(11) NOT NULL COMMENT '拼团人数',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户拼团表';

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_pt_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL COMMENT '规格名称',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_pt_spec_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spec_id` int(11) NOT NULL,
  `spec_value` char(100) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='组团商品规格值表';

CREATE TABLE IF NOT EXISTS `ims_cqkundian_farm_pt_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` char(100) NOT NULL COMMENT '分类名称',
  `status` tinyint(1) NOT NULL COMMENT '0 不显示 1显示',
  `cover` text NOT NULL COMMENT '封面',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `uniacid` int(11) NOT NULL,
  `rank` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

EOF;
pdo_run($sql);