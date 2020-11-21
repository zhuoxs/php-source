<?php
global $_W;
$sql = "
CREATE TABLE IF NOT EXISTS ".tablename('tg_address')." (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `mid` int(11) DEFAULT NULL COMMENT '粉丝ID',
  `openid` varchar(300) NOT NULL COMMENT '唯一标识',
  `cname` varchar(30) NOT NULL COMMENT '收货人名称',
  `tel` varchar(20) NOT NULL COMMENT '手机号',
  `province` varchar(20) NOT NULL COMMENT '省',
  `city` varchar(20) NOT NULL COMMENT '市',
  `county` varchar(20) NOT NULL COMMENT '县(区)',
  `detailed_address` varchar(225) NOT NULL COMMENT '详细地址',
  `uniacid` int(10) NOT NULL COMMENT '公众号id',
  `addtime` varchar(45) NOT NULL COMMENT '最后修改时间',
  `status` int(2) NOT NULL COMMENT '1为默认',
  `type` int(2) NOT NULL COMMENT '1公司，2家庭',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_adv')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `advname` varchar(50) DEFAULT '' COMMENT '幻灯片名称',
  `link` varchar(255) DEFAULT '' COMMENT '幻灯片链接',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '幻灯片图片',
  `displayorder` int(11) DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1显示',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`uniacid`),
  KEY `indx_enabled` (`enabled`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_arealimit')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  `arealimitname` varchar(56) NOT NULL,
  `areas` text NOT NULL,
  `merchantid` int(11) NOT NULL COMMENT '所属商家',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_category')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `thumb` varchar(255) NOT NULL COMMENT '分类图片',
  `parentid` int(10) unsigned DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `isrecommand` int(10) DEFAULT '0',
  `description` varchar(500) DEFAULT NULL COMMENT '分类介绍',
  `displayorder` tinyint(3) unsigned DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_collect')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `openid` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_coupon')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_template_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `cash` varchar(20) NOT NULL,
  `is_at_least` tinyint(3) unsigned NOT NULL,
  `at_least` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `use_time` int(10) unsigned NOT NULL,
  `openid` varchar(100) NOT NULL,
  `uniacid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_coupon_template')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '优惠券名称',
  `value` varchar(50) NOT NULL COMMENT '最小面值',
  `value_to` varchar(50) NOT NULL COMMENT '最大面值',
  `is_random` tinyint(3) unsigned NOT NULL COMMENT '是否随机',
  `is_at_least` tinyint(3) unsigned NOT NULL COMMENT '是否存在最低消费',
  `at_least` varchar(20) NOT NULL COMMENT '最低消费',
  `is_sync_weixin` tinyint(11) unsigned NOT NULL,
  `user_level` tinyint(11) unsigned DEFAULT NULL,
  `quota` tinyint(10) unsigned NOT NULL COMMENT '领取限制',
  `start_time` int(10) unsigned NOT NULL COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL COMMENT '结束时间',
  `fans_tag` int(10) unsigned NOT NULL,
  `expire_notice` tinyint(4) unsigned NOT NULL,
  `is_share` tinyint(3) unsigned NOT NULL,
  `range_type` tinyint(3) unsigned NOT NULL,
  `is_forbid_preference` tinyint(3) unsigned NOT NULL,
  `description` varchar(255) NOT NULL COMMENT '描述',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `enable` tinyint(3) unsigned NOT NULL COMMENT '优惠券状态，1正常',
  `total` int(10) unsigned NOT NULL COMMENT '优惠券总量',
  `quantity_issue` int(10) unsigned NOT NULL,
  `quantity_used` int(10) unsigned NOT NULL COMMENT '已使用数量',
  `uid` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_credit_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(245) NOT NULL,
  `num` varchar(30) NOT NULL,
  `createtime` varchar(145) NOT NULL,
  `transid` varchar(145) NOT NULL,
  `status` int(11) NOT NULL,
  `paytype` int(2) NOT NULL COMMENT '1微信2后台',
  `ordersn` varchar(145) NOT NULL,
  `type` int(2) NOT NULL COMMENT '1积分2余额',
  `remark` varchar(145) NOT NULL,
  `table` tinyint(4) DEFAULT NULL COMMENT '1微擎2tg',
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_delivery_price')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `province` varchar(12) NOT NULL,
  `city` varchar(12) NOT NULL,
  `district` varchar(12) NOT NULL,
  `first_weight` varchar(20) NOT NULL,
  `first_fee` varchar(20) NOT NULL,
  `additional_weight` varchar(20) NOT NULL,
  `additional_fee` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`template_id`),
  KEY `district` (`province`,`city`,`district`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_delivery_template')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `merchantid` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `region` longtext NOT NULL,
  `data` longtext NOT NULL,
  `updatetime` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_dispatch')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `dispatchname` varchar(50) NOT NULL DEFAULT '' COMMENT '配送名称',
  `dispatchtype` int(11) NOT NULL DEFAULT '0' COMMENT '配送方式0快递1自提',
  `displayorder` int(11) DEFAULT '0' COMMENT '排序',
  `firstprice` decimal(10,2) DEFAULT '0.00' COMMENT '默认运费',
  `areas` text COMMENT '快递地区',
  `carriers` text COMMENT '自提地区',
  `enabled` int(11) NOT NULL DEFAULT '0' COMMENT '1启用',
  `merchantid` int(11) DEFAULT NULL COMMENT '商家ID',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_goods')." (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(10) NOT NULL COMMENT '公众号的id',
  `gname` varchar(225) NOT NULL COMMENT '商品名称',
  `fk_typeid` int(10) unsigned DEFAULT NULL COMMENT '一级分类id',
  `gnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  `groupnum` int(10) unsigned NOT NULL COMMENT '最低拼团人数',
  `mprice` decimal(10,2) NOT NULL COMMENT '市场价',
  `gprice` decimal(10,2) NOT NULL COMMENT '团购价',
  `oprice` decimal(10,2) NOT NULL COMMENT '单买价',
  `gdesc` text NOT NULL COMMENT '商品简介',
  `gdetaile` longtext NOT NULL COMMENT '商品图文详情',
  `gimg` varchar(225) NOT NULL COMMENT '首页图片',
  `isshow` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1上架2下架3售罄4回收站',
  `isnew` int(2) DEFAULT NULL COMMENT '1最新上架',
  `ishot` int(2) DEFAULT NULL COMMENT '1火爆',
  `isrecommand` int(2) DEFAULT NULL COMMENT '1推荐',
  `isdiscount` int(2) DEFAULT NULL COMMENT '1优惠',
  `salenum` int(10) unsigned NOT NULL COMMENT '销量',
  `displayorder` int(11) DEFAULT NULL COMMENT '首页排序',
  `credits` int(11) DEFAULT NULL COMMENT '单次购买获得积分',
  `endtime` int(11) NOT NULL COMMENT '团购限时（小时数）',
  `hasoption` int(11) NOT NULL COMMENT '1启用商品规格',
  `yunfei_id` int(11) NOT NULL COMMENT '运费模板ID',
  `is_hexiao` int(2) NOT NULL COMMENT '1支持核销',
  `hexiao_id` varchar(115) NOT NULL COMMENT '核销门店ID集',
  `is_share` int(2) DEFAULT NULL COMMENT '1开启分享',
  `is_discount` int(2) DEFAULT NULL COMMENT '1开启2关闭',
  `merchantid` int(11) NOT NULL COMMENT '商家ID',
  `share_title` varchar(200) NOT NULL COMMENT '分享标题',
  `share_image` varchar(250) NOT NULL COMMENT '分享图片',
  `share_desc` varchar(200) NOT NULL COMMENT '分享简介',
  `group_level` varchar(1000) NOT NULL COMMENT '阶梯团集',
  `group_level_status` int(11) NOT NULL COMMENT '2开启1关闭',
  `one_limit` int(11) DEFAULT NULL COMMENT '单次购买数',
  `many_limit` int(11) DEFAULT NULL COMMENT '单人购买数',
  `firstdiscount` decimal(10,2) DEFAULT NULL COMMENT '团长优惠金额',
  `category_childid` int(11) DEFAULT NULL COMMENT '二级分类子类ID',
  `category_parentid` int(11) DEFAULT NULL COMMENT '二级分类父类ID',
  `createtime` int(10) unsigned NOT NULL COMMENT '最后修改时间',
  `pv` int(11) DEFAULT NULL COMMENT '浏览次数',
  `uv` int(11) DEFAULT NULL COMMENT '浏览人数',
  `unit` varchar(32) DEFAULT NULL COMMENT '单位',
  `goodstab` varchar(32) DEFAULT NULL COMMENT '商品标签',
  `op_one_limit` int(11) DEFAULT NULL COMMENT '单次购买数',
  `first_free` int(11) DEFAULT NULL COMMENT '1开启团长免单',
  `give_coupon_id` int(11) DEFAULT NULL COMMENT '赠送优惠券ID',
  `give_gift_id` int(11) DEFAULT NULL COMMENT '赠送赠品',
  `paysuccess` text,
  `atlas` varchar(445) DEFAULT NULL COMMENT '图集',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_goods_atlas')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `g_id` int(11) NOT NULL COMMENT '商品id',
  `thumb` varchar(145) NOT NULL COMMENT '图片路径',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_goods_option')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '规格详情',
  `thumb` varchar(60) DEFAULT '' COMMENT '规格图片',
  `productprice` decimal(10,2) DEFAULT '0.00' COMMENT '单独购买价',
  `marketprice` decimal(10,2) DEFAULT '0.00' COMMENT '团购价',
  `costprice` decimal(10,2) DEFAULT '0.00' COMMENT '市场价',
  `displayorder` int(11) DEFAULT '0',
  `specs` varchar(445) DEFAULT NULL,
  `stock` varchar(445) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodsid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_goods_param')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `goodsid` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名称',
  `value` text NOT NULL COMMENT '属性值',
  `displayorder` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodsid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_group')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `groupnumber` varchar(115) NOT NULL COMMENT '团编号',
  `goodsid` int(11) NOT NULL COMMENT '商品ID',
  `goodsname` varchar(1024) NOT NULL COMMENT '商品名称',
  `groupstatus` int(11) NOT NULL COMMENT '团状态',
  `neednum` int(11) NOT NULL COMMENT '所需人数',
  `lacknum` int(11) NOT NULL COMMENT '缺少人数',
  `starttime` varchar(225) NOT NULL COMMENT '开团时间',
  `endtime` varchar(225) NOT NULL COMMENT '到期时间',
  `grouptype` int(11) NOT NULL COMMENT '1同2异3普通4单',
  `isshare` int(11) NOT NULL COMMENT '1分享2不分享',
  `merchantid` int(11) NOT NULL COMMENT '商家ID',
  `price` varchar(11) NOT NULL COMMENT '团价格',
  `successtime` varchar(45) DEFAULT NULL COMMENT '团成功时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_helpbuy')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(45) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_member')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '会员id',
  `uniacid` int(10) unsigned NOT NULL COMMENT '公众账号id',
  `openid` varchar(100) NOT NULL COMMENT '微信会员openID',
  `mobile` varchar(45) DEFAULT NULL COMMENT '手机号',
  `realname` varchar(132) DEFAULT NULL COMMENT '真实姓名',
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `address` varchar(132) DEFAULT NULL COMMENT '常用地址',
  `tag` varchar(1000) DEFAULT NULL COMMENT '其他属性集',
  `credit1` decimal(10,2) DEFAULT '0.00' COMMENT '积分',
  `credit2` decimal(10,2) DEFAULT '0.00' COMMENT '余额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_merchant')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(145) NOT NULL,
  `name` varchar(145) NOT NULL COMMENT '商家名称',
  `logo` varchar(225) NOT NULL COMMENT '商家logo',
  `industry` varchar(45) DEFAULT NULL COMMENT '行业',
  `address` varchar(115) DEFAULT NULL COMMENT '商家地址',
  `linkman_name` varchar(145) DEFAULT NULL COMMENT '联系人姓名',
  `linkman_mobile` varchar(145) DEFAULT NULL COMMENT '联系电话',
  `thumb` varchar(255) DEFAULT NULL COMMENT '介绍图片',
  `detail` varchar(1222) DEFAULT NULL COMMENT '简介',
  `salenum` int(11) DEFAULT NULL COMMENT '商家销量',
  `open` int(11) DEFAULT NULL COMMENT '2不分配后台权限',
  `uname` varchar(45) DEFAULT NULL COMMENT '商家帐号',
  `password` varchar(145) DEFAULT NULL COMMENT '商家密码',
  `uid` int(11) DEFAULT NULL COMMENT '商家用户ID',
  `messageopenid` varchar(145) DEFAULT NULL COMMENT '被通知者openid',
  `goodsnum` int(11) DEFAULT NULL COMMENT '商家上传商品数量上限',
  `percent` varchar(111) DEFAULT NULL COMMENT '商家上缴佣金百分比',
  `createtime` varchar(115) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_merchant_account')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `merchantid` int(11) NOT NULL COMMENT '商家ID',
  `uid` int(11) NOT NULL COMMENT '操作员id',
  `amount` decimal(10,2) NOT NULL COMMENT '交易总金额',
  `updatetime` varchar(45) NOT NULL COMMENT '上次结算时间',
  `no_money` decimal(10,2) NOT NULL COMMENT '目前未结算金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_merchant_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `merchantid` int(11) NOT NULL COMMENT '商家id',
  `money` varchar(45) NOT NULL COMMENT '本次结算金额',
  `uid` int(11) NOT NULL COMMENT '操作员id',
  `createtime` varchar(45) NOT NULL COMMENT '结算时间',
  `orderno` varchar(45) NOT NULL COMMENT '',
  `commission` varchar(45) NOT NULL COMMENT '',
  `percent` varchar(45) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_oplog')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `describe` varchar(225) DEFAULT NULL COMMENT '操作描述',
  `view_url` varchar(225) DEFAULT NULL COMMENT '操作界面url',
  `ip` varchar(32) DEFAULT NULL COMMENT 'IP',
  `data` varchar(1024) DEFAULT NULL COMMENT '操作数据',
  `createtime` varchar(32) DEFAULT NULL COMMENT '操作时间',
  `user` varchar(32) DEFAULT NULL COMMENT '操作员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_order')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(45) NOT NULL,
  `openid` varchar(145) NOT NULL,
  `helpbuy_opneid` varchar(145) DEFAULT NULL COMMENT '代付人openid',
  `gnum` int(11) NOT NULL COMMENT '购买数量',
  `ptime` varchar(20) DEFAULT NULL COMMENT '支付成功时间',
  `sendtime` varchar(20) DEFAULT NULL COMMENT '发货时间',
  `gettime` varchar(20) DEFAULT NULL COMMENT '收货时间',
  `orderno` varchar(50) NOT NULL COMMENT '订单编号',
  `price` varchar(45) NOT NULL COMMENT '实际支付金额',
  `goodsprice` varchar(45) NOT NULL COMMENT '商品价格',
  `freight` decimal(10,2) DEFAULT NULL COMMENT '运费',
  `status` int(2) NOT NULL COMMENT '0未支付,1支付，2待发货，3已发货，4已签收，5已取消，6待退款，7已退款，8部分退款',
  `addressid` int(11) NOT NULL COMMENT '地址id',
  `addresstype` int(11) NOT NULL COMMENT '地址类型，1公司2家庭',
  `g_id` int(11) NOT NULL COMMENT '商品id',
  `tuan_id` int(11) NOT NULL COMMENT '团id',
  `credits` int(11) DEFAULT NULL COMMENT '积分',
  `is_usecard` int(11) DEFAULT NULL COMMENT '1优惠过（优惠券，团长优惠）',
  `is_tuan` int(2) NOT NULL COMMENT '是否为团1为团0为单人2多余人退款',
  `pay_price` varchar(45) NOT NULL COMMENT '运费加商品费',
  `pay_type` int(4) DEFAULT NULL COMMENT '支付方式',
  `starttime` varchar(45) NOT NULL COMMENT '开始时间',
  `endtime` int(45) NOT NULL COMMENT '结束时间（小时）',
  `tuan_first` int(11) DEFAULT NULL COMMENT '1团长',
  `express` varchar(50) DEFAULT NULL COMMENT '快递公司名称',
  `expresssn` varchar(50) DEFAULT NULL COMMENT '快递单号',
  `transid` varchar(50) DEFAULT NULL COMMENT '微信订单号',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `optionid` int(11) DEFAULT NULL COMMENT '规格ID',
  `addname` varchar(50) NOT NULL COMMENT '收货人姓名',
  `mobile` varchar(50) NOT NULL COMMENT '收货人电话',
  `address` varchar(300) NOT NULL COMMENT '收货人地址',
  `checkpay` int(2) DEFAULT NULL COMMENT '1该订单号已被支付（代付）',
  `is_hexiao` int(2) DEFAULT NULL COMMENT '1核销0不是核销',
  `hexiaoma` varchar(45) DEFAULT NULL COMMENT '核销码',
  `veropenid` varchar(200) DEFAULT NULL COMMENT '核销人openid',
  `merchantid` int(11) DEFAULT NULL COMMENT '商家id',
  `optionname` varchar(50) DEFAULT NULL COMMENT '规格名称',
  `issettlement` int(3) DEFAULT NULL COMMENT '0未结算订单1已结算',
  `message` varchar(200) DEFAULT NULL COMMENT '代付留言',
  `ordertype` int(3) DEFAULT NULL COMMENT '1为代付订单',
  `othername` varchar(45) DEFAULT NULL COMMENT '代付人姓名',
  `createtime` varchar(45) NOT NULL COMMENT '订单生成时间',
  `successtime` varchar(45) DEFAULT NULL COMMENT '团成功时间',
  `adminremark` text COMMENT '卖家备注',
  `discount_fee` varchar(32) DEFAULT NULL COMMENT '优惠券优惠的钱',
  `first_fee` varchar(32) DEFAULT NULL COMMENT '团长优惠的钱',
  `couponid` int(11) DEFAULT NULL COMMENT '优惠券id',
  `bdeltime` int(11) DEFAULT NULL COMMENT '预约核销时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_order_print')." (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `pid` int(3) NOT NULL,
  `oid` int(10) NOT NULL,
  `foid` varchar(50) NOT NULL,
  `status` int(3) NOT NULL,
  `addtime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_page')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  `html` longtext NOT NULL,
  `click_pv` varchar(10) NOT NULL,
  `click_uv` varchar(10) NOT NULL,
  `enter_pv` varchar(10) NOT NULL,
  `enter_uv` varchar(10) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_print')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  `print_no` varchar(30) NOT NULL,
  `key` varchar(30) NOT NULL,
  `print_nums` int(3) NOT NULL,
  `qrcode_link` varchar(100) NOT NULL,
  `status` int(3) NOT NULL,
  `mode` int(11) NOT NULL,
  `member_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_puv')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(45) NOT NULL,
  `pv` varchar(20) DEFAULT NULL COMMENT '总浏览人次',
  `uv` varchar(50) NOT NULL COMMENT '总浏览人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_puv_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(45) NOT NULL,
  `openid` varchar(145) NOT NULL,
  `goodsid` int(11) NOT NULL COMMENT '商品id',
  `createtime` varchar(120) DEFAULT NULL COMMENT '访问时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_refund_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1手机端2Web端3最后一人退款4部分退款',
  `goodsid` int(11) NOT NULL COMMENT '商品ID',
  `payfee` varchar(100) NOT NULL COMMENT '支付金额',
  `refundfee` varchar(100) NOT NULL COMMENT '退还金额',
  `transid` varchar(115) NOT NULL COMMENT '订单编号',
  `refund_id` varchar(115) NOT NULL COMMENT '微信退款单号',
  `refundername` varchar(100) NOT NULL COMMENT '退款人姓名',
  `refundermobile` varchar(100) NOT NULL COMMENT '退款人电话',
  `goodsname` varchar(100) NOT NULL COMMENT '商品名称',
  `createtime` varchar(45) NOT NULL COMMENT '退款时间',
  `status` int(11) NOT NULL COMMENT '0未成功1成功',
  `orderid` varchar(45) NOT NULL COMMENT '订单id',
  `merchantid` int(11) NOT NULL COMMENT '商家id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_saler')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(255) DEFAULT '',
  `storeid` varchar(225) DEFAULT '' COMMENT '所属门店id集',
  `nickname` varchar(145) NOT NULL COMMENT '昵称',
  `avatar` varchar(225) NOT NULL COMMENT '头像',
  `status` tinyint(3) DEFAULT '0' COMMENT '1启用',
  `merchantid` int(11) NOT NULL COMMENT '商家ID',
  PRIMARY KEY (`id`),
  KEY `idx_storeid` (`storeid`),
  KEY `idx_uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_setting')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `key` varchar(200) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_spec')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `displaytype` tinyint(3) unsigned NOT NULL,
  `content` text NOT NULL,
  `goodsid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_spec_item')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `specid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `show` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`uniacid`),
  KEY `indx_specid` (`specid`),
  KEY `indx_show` (`show`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_store')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `storename` varchar(255) DEFAULT '' COMMENT '店铺名称',
  `address` varchar(255) DEFAULT '' COMMENT '店铺地址',
  `tel` varchar(255) DEFAULT '' COMMENT '电话',
  `lat` varchar(255) DEFAULT '' COMMENT '纬度',
  `lng` varchar(255) DEFAULT '' COMMENT '经度',
  `status` tinyint(3) DEFAULT '0' COMMENT '1启用',
  `merchantid` int(11) NOT NULL COMMENT '商家ID',
  `createtime` varchar(45) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_user_menu')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `extend_title` varchar(50) NOT NULL,
  `extend_url` varchar(255) NOT NULL,
  `extend_icon` varchar(255) NOT NULL,
  `active_urls` text NOT NULL,
  `is_system` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_user_node')." (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `url` varchar(300) NOT NULL,
  `do` varchar(255) NOT NULL,
  `ac` varchar(32) DEFAULT NULL,
  `op` varchar(32) DEFAULT NULL,
  `ac_id` int(11) DEFAULT NULL,
  `do_id` int(6) unsigned NOT NULL,
  `remark` varchar(255) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`do_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_user_role')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `nodes` text NOT NULL COMMENT '权限集',
  `merchantid` int(11) NOT NULL COMMENT '商家ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('tg_nav')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `uniacid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS ".tablename('tg_notice')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `enabled` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS ".tablename('tg_banner')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `uniacid` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS ".tablename('tg_scratch')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL COMMENT '活动名称',
  `starttime` varchar(32) DEFAULT NULL COMMENT '开始时间',
  `endtime` varchar(32) DEFAULT NULL COMMENT '结束时间\n',
  `detail` varchar(145) DEFAULT NULL COMMENT '说明',
  `use_credits` varchar(32) DEFAULT NULL COMMENT '需花费积分',
  `get_credits` varchar(32) DEFAULT NULL COMMENT '得到积分',
  `join_times` int(11) DEFAULT NULL COMMENT '参与次数',
  `winning_rate` varchar(32) DEFAULT NULL COMMENT '中奖率',
  `prize` varchar(1024) DEFAULT NULL COMMENT '奖品',
  `uniacid` int(11) DEFAULT NULL,
  `only_others` int(11) DEFAULT NULL COMMENT '1为只送积分给未中奖人',
  `status` int(11) DEFAULT NULL COMMENT '1开启',
  `alert_logo` varchar(145) DEFAULT NULL COMMENT '弹出的抽奖提示图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS ".tablename('tg_scratch_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(145) NOT NULL COMMENT '参与人openid',
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `type` varchar(45) DEFAULT NULL COMMENT '活动类型',
  `status` int(11) DEFAULT NULL COMMENT '2待领取3已领取',
  `prize` varchar(445) DEFAULT NULL COMMENT '奖品详情',
  `createtime` varchar(145) DEFAULT NULL COMMENT '参与时间',
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS ".tablename('tg_gift')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(145) DEFAULT NULL COMMENT '活动名称',
  `uniacid` int(11) NOT NULL,
  `goodsid` int(11) NOT NULL COMMENT '商品id',
  `starttime` varchar(145) DEFAULT NULL COMMENT '活动开启时间',
  `endtime` varchar(145) DEFAULT NULL COMMENT '活动结束时间',
  `gettime` int(11) DEFAULT NULL COMMENT '有效领取时间',
  `times` int(11) DEFAULT NULL COMMENT '领取次数',
  `sendnum` int(11) DEFAULT NULL COMMENT '赠送数量',
  `getnum` int(11) DEFAULT NULL COMMENT '领取数量',
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS ".tablename('tg_lottery')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(145) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `goodsid` int(11) DEFAULT NULL,
  `starttime` varchar(145) DEFAULT NULL,
  `endtime` varchar(145) DEFAULT NULL,
  `first_num` int(11) DEFAULT NULL,
  `second_num` int(11) DEFAULT NULL,
  `third_num` int(11) DEFAULT NULL,
  `forth_num` int(11) DEFAULT NULL,
  `createtime` varchar(145) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS ".tablename('tg_waittask')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `value` varchar(145) DEFAULT NULL,
  `key` varchar(145) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

insert into ".tablename('tg_user_node')."(`id`,`name`,`url`,`do`,`ac`,`op`,`ac_id`,`do_id`,`remark`,`displayorder`,`level`,`status`) values
  ('97','店铺设置','','store','setting','copyright','96','95','','0','3','2'),
  ('96','店铺设置','','store','setting','','0','95','','0','2','2'),
  ('95','店铺','','store','','','0','0','','0','1','2'),
  ('89','设置商品属性','','goods','goods','setgoodsproperty','84','83','','0','3','2'),
  ('88','批量设置','','goods','goods','batch','84','83','','0','3','2'),
  ('87','上下架/售罄/删除/彻底删除','','goods','goods','single_op','84','83','','0','3','2'),
  ('86','新增/修改商品','','goods','goods','post','84','83','','0','3','2'),
  ('85','商品列表','','goods','goods','display','84','83','','0','3','2'),
  ('84','商品管理','','goods','goods','','0','83','','0','2','2'),
  ('83','商品','','goods','','','0','0','','0','1','2'),
  ('106','退款','','order','fetch','refund','60','48','','0','3','2'),
  ('105','取消发货','','order','fetch','cancelsend','60','48','','0','3','2'),
  ('104','发货','','order','fetch','confirmsend','60','48','','0','3','2'),
  ('103','确认付款','','order','fetch','confrimpay','60','48','','0','3','2'),
  ('102','导出','','order','group','output','98','48','','0','3','2'),
  ('101','后台核销','','order','group','autogroup','98','48','','0','3','2'),
  ('100','团详情','','order','group','group_detail','98','48','','0','3','2'),
  ('99','订单列表','','order','group','all','98','48','','0','3','2'),
  ('98','团管理','','order','group','','0','48','','0','2','2'),
  ('82','订单详情','','order','refund','initsync','80','48','','0','3','2'),
  ('81','订单列表','','order','refund','display','80','48','','0','3','2'),
  ('80','批量退款','','order','refund','','0','48','','0','2','2'),
  ('79','导入订单','','order','import','import','76','48','','0','3','2'),
  ('78','导出订单','','order','import','output','76','48','','0','3','2'),
  ('77','发货列表','','order','import','display','76','48','','0','3','2'),
  ('76','批量发货','','order','import','','0','48','','0','2','2'),
  ('75','删除','','order','delivery','delete','71','48','','0','3','2'),
  ('74','是否启用','','order','delivery','editstatus','71','48','','0','3','2'),
  ('73','新增/编辑','','order','delivery','post','71','48','','0','3','2'),
  ('72','配送列表','','order','delivery','display','71','48','','0','3','2'),
  ('71','运费模板','','order','delivery','','0','48','','0','2','2'),
  ('64','导出','','order','fetch','output','60','48','','0','3','2'),
  ('63','后台核销','','order','fetch','confirm','60','48','','0','3','2'),
  ('62','订单详情','','order','fetch','detail','60','48','','0','3','2'),
  ('61','订单列表','','order','fetch','display','60','48','','0','3','2'),
  ('60','自提订单','','order','fetch','','0','48','','0','2','2'),
  ('59','退款','','order','order','refund','49','48','','0','3','2'),
  ('58','取消发货','','order','order','cancelsend','49','48','','0','3','2'),
  ('57','发货','','order','order','confirmsend','49','48','','0','3','2'),
  ('56','确认付款','','order','order','confrimpay','49','48','','0','3','2'),
  ('55','修改收货地址','','order','order','address','49','48','','0','3','2'),
  ('54','卖家备注','','order','order','remark','49','48','','0','3','2'),
  ('53','导出','','order','order','output','49','48','','0','3','2'),
  ('52','订单详情','','order','order','detail','49','48','','0','3','2'),
  ('51','订单列表','','order','order','received','49','48','','0','3','2'),
  ('50','订单概况','','order','order','summary','49','48','','0','3','2'),
  ('49','订单管理','','order','order','','0','48','','0','2','2'),
  ('48','订单','','order','','','0','0','','0','1','2'),
  ('113','概要统计','','data','home_data','display','112','34','','0','3','2'),
  ('112','概要统计','','data','home_data','','0','34','','0','2','2'),
  ('40','退款日志','','data','refund_log','display','39','34','','0','3','2'),
  ('39','退款日志','','data','refund_log','','0','34','','0','2','2'),
  ('38','订单统计','','data','order_data','display','37','34','','0','3','2'),
  ('37','订单统计','','data','order_data','','0','34','','0','2','2'),
  ('36','商品统计','','data','goods_data','display','35','34','','0','3','2'),
  ('35','商品统计','','data','goods_data','','0','34','','0','2','2'),
  ('34','数据中心','','data','','','0','0','','0','1','2'),
  ('111','插件列表','','application','plugins','list','110','1','','0','3','2'),
  ('110','插件列表','','application','plugins','','0','1','','0','2','2'),
  ('33','选择商品','','application','ladder','ajax','29','1','','0','3','2'),
  ('32','编辑阶梯团','','application','ladder','edit','29','1','','0','3','2'),
  ('31','新建阶梯团','','application','ladder','create','29','1','','0','3','2'),
  ('30','阶梯团列表','','application','ladder','list','29','1','','0','3','2'),
  ('29','阶梯团','','application','ladder','','0','1','','0','2','2'),
  ('17','选择门店','','application','bdelete','selectstore','12','1','','0','3','2'),
  ('16','选择粉丝','','application','bdelete','selectsaler','12','1','','0','3','2'),
  ('15','核销员','','application','bdelete','saler','12','1','','0','3','2'),
  ('14','门店管理','','application','bdelete','store','12','1','','0','3','2'),
  ('13','核销入口','','application','bdelete','hx_entry','12','1','','0','3','2'),
  ('12','核销管理','','application','bdelete','','0','1','','0','2','2'),
  ('1','应用与营销','','application','','','0','0','','0','1','2');
";
pdo_query($sql);
require_once IA_ROOT . "/addons/feng_fightgroups/upgrade.php";
?>