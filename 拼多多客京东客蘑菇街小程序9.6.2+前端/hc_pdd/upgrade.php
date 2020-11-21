<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `jump` int(11) NOT NULL DEFAULT '1',
  `xcxpath` varchar(255) NOT NULL,
  `xcxappid` varchar(255) NOT NULL,
  `diypic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_adv','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_adv','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_adv','advname')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `advname` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('hcpdd_adv','link')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `link` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('hcpdd_adv','thumb')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `thumb` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('hcpdd_adv','displayorder')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_adv','enabled')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `enabled` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_adv','jump')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `jump` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('hcpdd_adv','xcxpath')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `xcxpath` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_adv','xcxappid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `xcxappid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_adv','diypic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   `diypic` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_adv','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('hcpdd_adv','idx_uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   KEY `idx_uniacid` (`uniacid`)");}
if(!pdo_fieldexists('hcpdd_adv','idx_enabled')) {pdo_query("ALTER TABLE ".tablename('hcpdd_adv')." ADD   KEY `idx_enabled` (`enabled`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_allorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_sn` varchar(255) DEFAULT NULL,
  `goods_id` int(20) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_thumbnail_url` varchar(255) DEFAULT NULL,
  `goods_quantity` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `order_amount` varchar(255) DEFAULT NULL,
  `order_create_time` varchar(255) DEFAULT NULL,
  `order_settle_time` varchar(255) DEFAULT NULL,
  `order_verify_time` varchar(255) DEFAULT NULL,
  `order_receive_time` varchar(255) DEFAULT NULL,
  `order_pay_time` varchar(255) DEFAULT NULL,
  `promotion_rate` varchar(255) DEFAULT NULL,
  `promotion_amount` varchar(255) DEFAULT NULL,
  `batch_no` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `order_status_desc` varchar(255) DEFAULT NULL,
  `verify_time` varchar(255) DEFAULT NULL,
  `order_group_success_time` varchar(255) DEFAULT NULL,
  `order_modify_at` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `auth_duo_id` varchar(255) DEFAULT NULL,
  `custom_parameters` varchar(255) DEFAULT NULL,
  `p_id` varchar(255) DEFAULT NULL,
  `duo_coupon_amount` varchar(255) NOT NULL,
  `zs_duo_id` varchar(100) NOT NULL,
  `match_channel` varchar(200) NOT NULL,
  `fafang` int(11) DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败',
  `cfafang` int(11) NOT NULL COMMENT '0 没有上级抽佣1 已发放上级佣金',
  `order_id` varchar(100) NOT NULL,
  `commission` varchar(10) NOT NULL,
  `is_daili` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=407 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_allorder','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_allorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_sn')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_sn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','goods_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `goods_id` int(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','goods_name')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `goods_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','goods_thumbnail_url')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `goods_thumbnail_url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','goods_quantity')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `goods_quantity` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','goods_price')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `goods_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_amount')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_amount` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_create_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_create_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_settle_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_settle_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_verify_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_verify_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_receive_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_receive_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_pay_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_pay_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','promotion_rate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `promotion_rate` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','promotion_amount')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `promotion_amount` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','batch_no')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `batch_no` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_status` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_status_desc')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_status_desc` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','verify_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `verify_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_group_success_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_group_success_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','order_modify_at')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_modify_at` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `status` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','type')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','group_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `group_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','auth_duo_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `auth_duo_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','custom_parameters')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `custom_parameters` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','p_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `p_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','duo_coupon_amount')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `duo_coupon_amount` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','zs_duo_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `zs_duo_id` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','match_channel')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `match_channel` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','fafang')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `fafang` int(11) DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败'");}
if(!pdo_fieldexists('hcpdd_allorder','cfafang')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `cfafang` int(11) NOT NULL COMMENT '0 没有上级抽佣1 已发放上级佣金'");}
if(!pdo_fieldexists('hcpdd_allorder','order_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `order_id` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','commission')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `commission` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_allorder','is_daili')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorder')." ADD   `is_daili` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_allorders` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `order_sn` varchar(255) DEFAULT NULL,
  `goods_id` int(20) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_thumbnail_url` varchar(255) DEFAULT NULL,
  `goods_quantity` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `order_amount` varchar(255) DEFAULT NULL,
  `order_create_time` varchar(255) DEFAULT NULL,
  `order_settle_time` varchar(255) DEFAULT NULL,
  `order_verify_time` varchar(255) DEFAULT NULL,
  `order_receive_time` varchar(255) DEFAULT NULL,
  `order_pay_time` varchar(255) DEFAULT NULL,
  `promotion_rate` varchar(255) DEFAULT NULL,
  `promotion_amount` varchar(255) DEFAULT NULL,
  `batch_no` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `order_status_desc` varchar(255) DEFAULT NULL,
  `verify_time` varchar(255) DEFAULT NULL,
  `order_group_success_time` varchar(255) DEFAULT NULL,
  `order_modify_at` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `auth_duo_id` varchar(255) DEFAULT NULL,
  `custom_parameters` varchar(255) DEFAULT NULL,
  `p_id` varchar(255) DEFAULT NULL,
  `duo_coupon_amount` varchar(255) NOT NULL,
  `zs_duo_id` varchar(100) NOT NULL,
  `match_channel` varchar(200) NOT NULL,
  `fafang` int(11) DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败',
  `cfafang` int(11) NOT NULL COMMENT '0 没有上级抽佣1 已发放上级佣金'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_allorders','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD 
  `id` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_sn')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_sn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','goods_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `goods_id` int(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','goods_name')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `goods_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','goods_thumbnail_url')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `goods_thumbnail_url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','goods_quantity')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `goods_quantity` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','goods_price')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `goods_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_amount')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_amount` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_create_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_create_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_settle_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_settle_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_verify_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_verify_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_receive_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_receive_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_pay_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_pay_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','promotion_rate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `promotion_rate` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','promotion_amount')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `promotion_amount` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','batch_no')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `batch_no` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_status` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_status_desc')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_status_desc` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','verify_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `verify_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_group_success_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_group_success_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','order_modify_at')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `order_modify_at` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `status` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','type')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','group_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `group_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','auth_duo_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `auth_duo_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','custom_parameters')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `custom_parameters` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','p_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `p_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','duo_coupon_amount')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `duo_coupon_amount` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','zs_duo_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `zs_duo_id` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','match_channel')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `match_channel` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_allorders','fafang')) {pdo_query("ALTER TABLE ".tablename('hcpdd_allorders')." ADD   `fafang` int(11) DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `copy_img` varchar(255) DEFAULT NULL,
  `copy_type` int(11) DEFAULT '1' COMMENT '1商品推荐2素材营销3新手必发',
  `copy_goodsid` varchar(20) DEFAULT NULL,
  `copy_text` varchar(5500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `createtime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`uniacid`,`copy_type`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_copy','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_copy')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_copy','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_copy')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_copy','copy_img')) {pdo_query("ALTER TABLE ".tablename('hcpdd_copy')." ADD   `copy_img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_copy','copy_type')) {pdo_query("ALTER TABLE ".tablename('hcpdd_copy')." ADD   `copy_type` int(11) DEFAULT '1' COMMENT '1商品推荐2素材营销3新手必发'");}
if(!pdo_fieldexists('hcpdd_copy','copy_goodsid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_copy')." ADD   `copy_goodsid` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_copy','copy_text')) {pdo_query("ALTER TABLE ".tablename('hcpdd_copy')." ADD   `copy_text` varchar(5500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_copy','createtime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_copy')." ADD   `createtime` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_copy','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_copy')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_cset` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invite_agreement` varchar(255) NOT NULL COMMENT '邀请好友规则',
  `tx_details` text NOT NULL COMMENT '佣金提现协议',
  `is_shoufei` int(11) NOT NULL COMMENT '1.收费0.免费',
  `fx_level` int(11) NOT NULL COMMENT '分销层级0.不开启分销1.一级2.二级3.三级',
  `tx_rate` int(11) NOT NULL COMMENT '提现手续费',
  `commission1` varchar(10) NOT NULL COMMENT '一级佣金',
  `commission2` varchar(10) NOT NULL COMMENT '二级佣金',
  `commission3` varchar(10) NOT NULL COMMENT '三级佣金',
  `zongjian_commission1` varchar(10) NOT NULL,
  `zongjian_commission2` varchar(10) NOT NULL,
  `zongjian_commission3` varchar(10) NOT NULL,
  `tx_money` int(11) NOT NULL COMMENT '提现门槛',
  `uniacid` int(11) NOT NULL,
  `dailifei` decimal(10,2) NOT NULL COMMENT '代理费',
  `zongjianfei` decimal(10,2) NOT NULL,
  `agreement` varchar(255) NOT NULL COMMENT '申请代理规则',
  `zongjian_agreement` varchar(255) NOT NULL COMMENT '升级运营总监规则',
  `daili` varchar(255) NOT NULL DEFAULT '代理',
  `yunyingzongjian` varchar(255) NOT NULL DEFAULT '运营总监',
  `yongjin` varchar(255) NOT NULL DEFAULT '佣金',
  `yiji` varchar(255) NOT NULL DEFAULT '一级',
  `erji` varchar(255) NOT NULL DEFAULT '二级',
  `sanji` varchar(255) NOT NULL DEFAULT '三级',
  `invite_title` varchar(255) NOT NULL,
  `invite_pic` varchar(255) NOT NULL,
  `invite_bg` varchar(255) NOT NULL COMMENT '背景',
  `guize_bg` varchar(255) NOT NULL,
  `inviteposter1` varchar(255) NOT NULL,
  `inviteposter2` varchar(255) NOT NULL,
  `inviteposter3` varchar(255) NOT NULL,
  `dailisum` int(11) NOT NULL COMMENT '升级代理人数',
  `zongjiansum` int(11) NOT NULL COMMENT '升级总监人数',
  `shengdaili` varchar(100) NOT NULL,
  `shengzongjian` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_cset','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_cset','invite_agreement')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `invite_agreement` varchar(255) NOT NULL COMMENT '邀请好友规则'");}
if(!pdo_fieldexists('hcpdd_cset','tx_details')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `tx_details` text NOT NULL COMMENT '佣金提现协议'");}
if(!pdo_fieldexists('hcpdd_cset','is_shoufei')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `is_shoufei` int(11) NOT NULL COMMENT '1.收费0.免费'");}
if(!pdo_fieldexists('hcpdd_cset','fx_level')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `fx_level` int(11) NOT NULL COMMENT '分销层级0.不开启分销1.一级2.二级3.三级'");}
if(!pdo_fieldexists('hcpdd_cset','tx_rate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `tx_rate` int(11) NOT NULL COMMENT '提现手续费'");}
if(!pdo_fieldexists('hcpdd_cset','commission1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `commission1` varchar(10) NOT NULL COMMENT '一级佣金'");}
if(!pdo_fieldexists('hcpdd_cset','commission2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `commission2` varchar(10) NOT NULL COMMENT '二级佣金'");}
if(!pdo_fieldexists('hcpdd_cset','commission3')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `commission3` varchar(10) NOT NULL COMMENT '三级佣金'");}
if(!pdo_fieldexists('hcpdd_cset','zongjian_commission1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `zongjian_commission1` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','zongjian_commission2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `zongjian_commission2` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','zongjian_commission3')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `zongjian_commission3` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','tx_money')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `tx_money` int(11) NOT NULL COMMENT '提现门槛'");}
if(!pdo_fieldexists('hcpdd_cset','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','dailifei')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `dailifei` decimal(10,2) NOT NULL COMMENT '代理费'");}
if(!pdo_fieldexists('hcpdd_cset','zongjianfei')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `zongjianfei` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','agreement')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `agreement` varchar(255) NOT NULL COMMENT '申请代理规则'");}
if(!pdo_fieldexists('hcpdd_cset','zongjian_agreement')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `zongjian_agreement` varchar(255) NOT NULL COMMENT '升级运营总监规则'");}
if(!pdo_fieldexists('hcpdd_cset','daili')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `daili` varchar(255) NOT NULL DEFAULT '代理'");}
if(!pdo_fieldexists('hcpdd_cset','yunyingzongjian')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `yunyingzongjian` varchar(255) NOT NULL DEFAULT '运营总监'");}
if(!pdo_fieldexists('hcpdd_cset','yongjin')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `yongjin` varchar(255) NOT NULL DEFAULT '佣金'");}
if(!pdo_fieldexists('hcpdd_cset','yiji')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `yiji` varchar(255) NOT NULL DEFAULT '一级'");}
if(!pdo_fieldexists('hcpdd_cset','erji')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `erji` varchar(255) NOT NULL DEFAULT '二级'");}
if(!pdo_fieldexists('hcpdd_cset','sanji')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `sanji` varchar(255) NOT NULL DEFAULT '三级'");}
if(!pdo_fieldexists('hcpdd_cset','invite_title')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `invite_title` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','invite_pic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `invite_pic` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','invite_bg')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `invite_bg` varchar(255) NOT NULL COMMENT '背景'");}
if(!pdo_fieldexists('hcpdd_cset','guize_bg')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `guize_bg` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','inviteposter1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `inviteposter1` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','inviteposter2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `inviteposter2` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','inviteposter3')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `inviteposter3` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','dailisum')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `dailisum` int(11) NOT NULL COMMENT '升级代理人数'");}
if(!pdo_fieldexists('hcpdd_cset','zongjiansum')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `zongjiansum` int(11) NOT NULL COMMENT '升级总监人数'");}
if(!pdo_fieldexists('hcpdd_cset','shengdaili')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `shengdaili` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_cset','shengzongjian')) {pdo_query("ALTER TABLE ".tablename('hcpdd_cset')." ADD   `shengzongjian` varchar(100) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_ctixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `tel` varchar(20) NOT NULL COMMENT '手机号',
  `truename` varchar(20) NOT NULL COMMENT '姓名',
  `weixin` varchar(20) NOT NULL COMMENT '微信号',
  `payment_time` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `son_uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_ctixian','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_ctixian','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `user_id` int(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_ctixian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_ctixian','open_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `open_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_ctixian','tel')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `tel` varchar(20) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('hcpdd_ctixian','truename')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `truename` varchar(20) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('hcpdd_ctixian','weixin')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `weixin` varchar(20) NOT NULL COMMENT '微信号'");}
if(!pdo_fieldexists('hcpdd_ctixian','payment_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `payment_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_ctixian','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `status` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_ctixian','money')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `money` decimal(11,2) NOT NULL DEFAULT '0.00'");}
if(!pdo_fieldexists('hcpdd_ctixian','son_uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_ctixian')." ADD   `son_uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_finishorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_sn` varchar(255) DEFAULT NULL,
  `goods_id` int(20) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_thumbnail_url` varchar(255) DEFAULT NULL,
  `goods_quantity` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `order_amount` varchar(255) DEFAULT NULL,
  `order_create_time` varchar(255) DEFAULT NULL,
  `order_settle_time` varchar(255) DEFAULT NULL,
  `order_verify_time` varchar(255) DEFAULT NULL,
  `order_receive_time` varchar(255) DEFAULT NULL,
  `order_pay_time` varchar(255) DEFAULT NULL,
  `promotion_rate` varchar(255) DEFAULT NULL,
  `promotion_amount` varchar(255) DEFAULT NULL,
  `batch_no` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `order_status_desc` varchar(255) DEFAULT NULL,
  `verify_time` varchar(255) DEFAULT NULL,
  `order_group_success_time` varchar(255) DEFAULT NULL,
  `order_modify_at` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `auth_duo_id` varchar(255) DEFAULT NULL,
  `custom_parameters` varchar(255) DEFAULT NULL,
  `p_id` varchar(255) DEFAULT NULL,
  `fafang` int(11) DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败',
  `zs_duo_id` varchar(200) NOT NULL,
  `duo_coupon_amount` varchar(200) NOT NULL,
  `match_channel` varchar(200) NOT NULL,
  `cfafang` int(11) NOT NULL COMMENT '0 没有上级抽佣1 已发放上级佣金',
  `order_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`order_sn`,`fafang`)
) ENGINE=MyISAM AUTO_INCREMENT=584 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_finishorders','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_finishorders','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_sn')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_sn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','goods_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `goods_id` int(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','goods_name')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `goods_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','goods_thumbnail_url')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `goods_thumbnail_url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','goods_quantity')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `goods_quantity` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','goods_price')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `goods_price` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_amount')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_amount` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_create_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_create_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_settle_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_settle_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_verify_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_verify_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_receive_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_receive_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_pay_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_pay_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','promotion_rate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `promotion_rate` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','promotion_amount')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `promotion_amount` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','batch_no')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `batch_no` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_status` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_status_desc')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_status_desc` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','verify_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `verify_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_group_success_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_group_success_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','order_modify_at')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_modify_at` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `status` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','type')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','group_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `group_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','auth_duo_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `auth_duo_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','custom_parameters')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `custom_parameters` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','p_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `p_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','fafang')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `fafang` int(11) DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败'");}
if(!pdo_fieldexists('hcpdd_finishorders','zs_duo_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `zs_duo_id` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','duo_coupon_amount')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `duo_coupon_amount` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','match_channel')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `match_channel` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','cfafang')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `cfafang` int(11) NOT NULL COMMENT '0 没有上级抽佣1 已发放上级佣金'");}
if(!pdo_fieldexists('hcpdd_finishorders','order_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   `order_id` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_finishorders','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_finishorders')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `formid` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2954 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_formid','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_formid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_formid','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_formid')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_formid','formid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_formid')." ADD   `formid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_formid','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_formid')." ADD   `status` int(11) NOT NULL DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_hblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hongbaotime` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0未转发1已转发',
  `s_time` varchar(255) NOT NULL COMMENT '领取红包时间戳',
  `e_time` varchar(255) NOT NULL COMMENT '红包结束时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_hblog','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hblog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_hblog','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hblog')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_hblog','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hblog')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_hblog','hongbaotime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hblog')." ADD   `hongbaotime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_hblog','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hblog')." ADD   `status` int(11) NOT NULL COMMENT '0未转发1已转发'");}
if(!pdo_fieldexists('hcpdd_hblog','s_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hblog')." ADD   `s_time` varchar(255) NOT NULL COMMENT '领取红包时间戳'");}
if(!pdo_fieldexists('hcpdd_hblog','e_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hblog')." ADD   `e_time` varchar(255) NOT NULL COMMENT '红包结束时间戳'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `sotime` varchar(255) NOT NULL COMMENT '搜索时间',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7723 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_history','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_history')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_history','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_history')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_history','keyword')) {pdo_query("ALTER TABLE ".tablename('hcpdd_history')." ADD   `keyword` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_history','sotime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_history')." ADD   `sotime` varchar(255) NOT NULL COMMENT '搜索时间'");}
if(!pdo_fieldexists('hcpdd_history','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_history')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_hongbao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `is_open` int(11) DEFAULT NULL,
  `open_bg` varchar(255) DEFAULT NULL,
  `firstmoney` int(11) DEFAULT NULL,
  `zhuanfamoney` int(11) DEFAULT NULL,
  `shareinfo` varchar(255) NOT NULL,
  `sharetitle` varchar(255) NOT NULL,
  `fenxiangtitle` varchar(255) NOT NULL,
  `fenxiangpic` varchar(255) NOT NULL,
  `hb_day` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_hongbao','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_hongbao','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_hongbao','is_open')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `is_open` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_hongbao','open_bg')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `open_bg` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_hongbao','firstmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `firstmoney` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_hongbao','zhuanfamoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `zhuanfamoney` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_hongbao','shareinfo')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `shareinfo` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_hongbao','sharetitle')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `sharetitle` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_hongbao','fenxiangtitle')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `fenxiangtitle` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_hongbao','fenxiangpic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `fenxiangpic` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_hongbao','hb_day')) {pdo_query("ALTER TABLE ".tablename('hcpdd_hongbao')." ADD   `hb_day` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_jdcommission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '佣金获取人id,上级',
  `positionId` varchar(100) DEFAULT NULL COMMENT '推广人京东推广位',
  `level` int(11) DEFAULT NULL COMMENT '1 一级佣金 2 二级佣金 3 三级佣金',
  `orderId` varchar(100) DEFAULT NULL,
  `fee` varchar(10) DEFAULT NULL COMMENT '计佣金额',
  `fx_commission` decimal(10,3) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0预估佣金1可提现佣金2已提现佣金3无效订单',
  `addtime` varchar(255) DEFAULT NULL,
  `goodsname` varchar(255) DEFAULT NULL COMMENT '商品名',
  `fx_rate` varchar(20) DEFAULT NULL,
  `is_daili` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_jdcommission','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_jdcommission','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdcommission','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `user_id` int(11) DEFAULT NULL COMMENT '佣金获取人id,上级'");}
if(!pdo_fieldexists('hcpdd_jdcommission','positionId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `positionId` varchar(100) DEFAULT NULL COMMENT '推广人京东推广位'");}
if(!pdo_fieldexists('hcpdd_jdcommission','level')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `level` int(11) DEFAULT NULL COMMENT '1 一级佣金 2 二级佣金 3 三级佣金'");}
if(!pdo_fieldexists('hcpdd_jdcommission','orderId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `orderId` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdcommission','fee')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `fee` varchar(10) DEFAULT NULL COMMENT '计佣金额'");}
if(!pdo_fieldexists('hcpdd_jdcommission','fx_commission')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `fx_commission` decimal(10,3) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdcommission','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `status` int(11) DEFAULT NULL COMMENT '0预估佣金1可提现佣金2已提现佣金3无效订单'");}
if(!pdo_fieldexists('hcpdd_jdcommission','addtime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `addtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdcommission','goodsname')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `goodsname` varchar(255) DEFAULT NULL COMMENT '商品名'");}
if(!pdo_fieldexists('hcpdd_jdcommission','fx_rate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `fx_rate` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdcommission','is_daili')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdcommission')." ADD   `is_daili` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_jdorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `ext1` varchar(100) DEFAULT NULL,
  `finishTime` varchar(100) DEFAULT NULL,
  `orderEmt` varchar(100) DEFAULT NULL,
  `orderId` varchar(100) NOT NULL,
  `orderTime` varchar(100) DEFAULT NULL,
  `parentId` varchar(100) DEFAULT NULL,
  `payMonth` varchar(100) DEFAULT NULL,
  `plus` varchar(100) DEFAULT NULL,
  `popId` varchar(100) DEFAULT NULL,
  `skuList` varchar(5000) DEFAULT NULL,
  `unionId` varchar(100) DEFAULT NULL,
  `validCode` varchar(100) DEFAULT NULL COMMENT '订单状态',
  `positionId` varchar(100) DEFAULT NULL COMMENT '京东推广位',
  `commission` varchar(10) NOT NULL COMMENT '佣金',
  `is_daili` int(11) NOT NULL,
  `fafang` int(11) NOT NULL DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败',
  PRIMARY KEY (`id`,`orderId`),
  KEY `uniacid` (`uniacid`,`validCode`,`positionId`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_jdorders','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_jdorders','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','ext1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `ext1` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','finishTime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `finishTime` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','orderEmt')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `orderEmt` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','orderId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `orderId` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','orderTime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `orderTime` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','parentId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `parentId` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','payMonth')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `payMonth` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','plus')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `plus` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','popId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `popId` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','skuList')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `skuList` varchar(5000) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','unionId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `unionId` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','validCode')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `validCode` varchar(100) DEFAULT NULL COMMENT '订单状态'");}
if(!pdo_fieldexists('hcpdd_jdorders','positionId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `positionId` varchar(100) DEFAULT NULL COMMENT '京东推广位'");}
if(!pdo_fieldexists('hcpdd_jdorders','commission')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `commission` varchar(10) NOT NULL COMMENT '佣金'");}
if(!pdo_fieldexists('hcpdd_jdorders','is_daili')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `is_daili` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_jdorders','fafang')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   `fafang` int(11) NOT NULL DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败'");}
if(!pdo_fieldexists('hcpdd_jdorders','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_jdorders')." ADD   PRIMARY KEY (`id`,`orderId`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_kouhonglog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `createtime` varchar(20) DEFAULT NULL,
  `createday` varchar(20) DEFAULT NULL,
  `goods_id` varchar(20) DEFAULT NULL,
  `invite_id` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0挑战失败1挑战成功',
  `cishu` int(20) DEFAULT '0' COMMENT '0挑战零次没挑战直接邀请好友1直接开始挑战2满足条件后挑战第二次',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_kouhonglog','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_kouhonglog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_kouhonglog','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_kouhonglog')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_kouhonglog','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_kouhonglog')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_kouhonglog','createtime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_kouhonglog')." ADD   `createtime` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_kouhonglog','createday')) {pdo_query("ALTER TABLE ".tablename('hcpdd_kouhonglog')." ADD   `createday` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_kouhonglog','goods_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_kouhonglog')." ADD   `goods_id` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_kouhonglog','invite_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_kouhonglog')." ADD   `invite_id` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_kouhonglog','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_kouhonglog')." ADD   `status` int(11) DEFAULT '0' COMMENT '0挑战失败1挑战成功'");}
if(!pdo_fieldexists('hcpdd_kouhonglog','cishu')) {pdo_query("ALTER TABLE ".tablename('hcpdd_kouhonglog')." ADD   `cishu` int(20) DEFAULT '0' COMMENT '0挑战零次没挑战直接邀请好友1直接开始挑战2满足条件后挑战第二次'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `msgid` varchar(255) DEFAULT NULL,
  `keyword1` varchar(255) DEFAULT NULL,
  `keyword2` varchar(255) DEFAULT NULL,
  `keyword3` varchar(255) DEFAULT NULL,
  `hongbao_msgid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_message','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_message')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_message','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_message')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_message','msgid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_message')." ADD   `msgid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_message','keyword1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_message')." ADD   `keyword1` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_message','keyword2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_message')." ADD   `keyword2` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_message','keyword3')) {pdo_query("ALTER TABLE ".tablename('hcpdd_message')." ADD   `keyword3` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_message','hongbao_msgid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_message')." ADD   `hongbao_msgid` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_mogucommission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '佣金获取人id,上级',
  `groupId` varchar(100) DEFAULT NULL COMMENT '推广人蘑菇街推广位',
  `level` int(11) DEFAULT NULL COMMENT '1 一级佣金 2 二级佣金 3 三级佣金',
  `orderNo` varchar(100) DEFAULT NULL,
  `fee` varchar(10) DEFAULT NULL COMMENT '计佣金额',
  `fx_commission` decimal(10,3) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0预估佣金1可提现佣金2已提现佣金3无效订单',
  `addtime` varchar(255) DEFAULT NULL,
  `goodsname` varchar(255) DEFAULT NULL COMMENT '商品名',
  `fx_rate` varchar(20) DEFAULT NULL,
  `is_daili` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_mogucommission','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_mogucommission','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_mogucommission','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `user_id` int(11) DEFAULT NULL COMMENT '佣金获取人id,上级'");}
if(!pdo_fieldexists('hcpdd_mogucommission','groupId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `groupId` varchar(100) DEFAULT NULL COMMENT '推广人蘑菇街推广位'");}
if(!pdo_fieldexists('hcpdd_mogucommission','level')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `level` int(11) DEFAULT NULL COMMENT '1 一级佣金 2 二级佣金 3 三级佣金'");}
if(!pdo_fieldexists('hcpdd_mogucommission','orderNo')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `orderNo` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_mogucommission','fee')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `fee` varchar(10) DEFAULT NULL COMMENT '计佣金额'");}
if(!pdo_fieldexists('hcpdd_mogucommission','fx_commission')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `fx_commission` decimal(10,3) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_mogucommission','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `status` int(11) DEFAULT NULL COMMENT '0预估佣金1可提现佣金2已提现佣金3无效订单'");}
if(!pdo_fieldexists('hcpdd_mogucommission','addtime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `addtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_mogucommission','goodsname')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `goodsname` varchar(255) DEFAULT NULL COMMENT '商品名'");}
if(!pdo_fieldexists('hcpdd_mogucommission','fx_rate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `fx_rate` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_mogucommission','is_daili')) {pdo_query("ALTER TABLE ".tablename('hcpdd_mogucommission')." ADD   `is_daili` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_moguorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `orderNo` varchar(20) NOT NULL,
  `sysExpense` varchar(20) DEFAULT NULL,
  `groupId` varchar(20) DEFAULT NULL,
  `orderStatus` varchar(10) DEFAULT NULL,
  `preExpense` varchar(20) DEFAULT NULL,
  `updateTime` varchar(20) DEFAULT NULL,
  `expense` varchar(20) DEFAULT NULL,
  `paymentType` varchar(20) DEFAULT NULL,
  `products` varchar(2000) DEFAULT NULL,
  `feedback` varchar(20) DEFAULT NULL,
  `orderTime` varchar(20) DEFAULT NULL,
  `createdDate` varchar(20) DEFAULT NULL,
  `price` varchar(10) DEFAULT NULL,
  `chargeDate` varchar(20) DEFAULT NULL,
  `paymentStatus` varchar(20) DEFAULT NULL,
  `fafang` int(11) NOT NULL DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败',
  `commission` varchar(10) NOT NULL,
  `is_daili` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `orderNo` (`orderNo`),
  KEY `orderStatus` (`groupId`,`orderStatus`,`paymentStatus`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_moguorders','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_moguorders','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','orderNo')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `orderNo` varchar(20) NOT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','sysExpense')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `sysExpense` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','groupId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `groupId` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','orderStatus')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `orderStatus` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','preExpense')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `preExpense` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','updateTime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `updateTime` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','expense')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `expense` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','paymentType')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `paymentType` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','products')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `products` varchar(2000) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','feedback')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `feedback` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','orderTime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `orderTime` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','createdDate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `createdDate` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','price')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `price` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','chargeDate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `chargeDate` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','paymentStatus')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `paymentStatus` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','fafang')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `fafang` int(11) NOT NULL DEFAULT '0' COMMENT '发放状态：0未发放1已发放2发放失败'");}
if(!pdo_fieldexists('hcpdd_moguorders','commission')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `commission` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','is_daili')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   `is_daili` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_moguorders','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('hcpdd_moguorders','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   UNIQUE KEY `id` (`id`)");}
if(!pdo_fieldexists('hcpdd_moguorders','orderNo')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moguorders')." ADD   UNIQUE KEY `orderNo` (`orderNo`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_moneyrate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `moneyrate` float DEFAULT NULL,
  `daili_moneyrate` float DEFAULT NULL,
  `zongjian_moneyrate` float DEFAULT NULL,
  `edittime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_moneyrate','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moneyrate')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_moneyrate','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moneyrate')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moneyrate','moneyrate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moneyrate')." ADD   `moneyrate` float DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moneyrate','daili_moneyrate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moneyrate')." ADD   `daili_moneyrate` float DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moneyrate','zongjian_moneyrate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moneyrate')." ADD   `zongjian_moneyrate` float DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_moneyrate','edittime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_moneyrate')." ADD   `edittime` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `parentid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cateid` int(10) NOT NULL,
  `icon` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '0',
  `tpl` varchar(50) NOT NULL COMMENT '模板类型',
  `jump` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_nav','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_nav','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `uniacid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_nav','parentid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `parentid` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_nav','name')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_nav','cateid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `cateid` int(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_nav','icon')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `icon` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('hcpdd_nav','url')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `url` varchar(255) DEFAULT ''");}
if(!pdo_fieldexists('hcpdd_nav','displayorder')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `displayorder` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_nav','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `status` tinyint(3) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_nav','tpl')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `tpl` varchar(50) NOT NULL COMMENT '模板类型'");}
if(!pdo_fieldexists('hcpdd_nav','jump')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   `jump` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_nav','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('hcpdd_nav','idx_status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_nav')." ADD   KEY `idx_status` (`status`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `enabled` tinyint(3) NOT NULL,
  `createtime` char(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_notice','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_notice','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_notice','displayorder')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD   `displayorder` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_notice','title')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD   `title` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_notice','thumb')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD   `thumb` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_notice','link')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD   `link` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_notice','content')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD   `content` text NOT NULL");}
if(!pdo_fieldexists('hcpdd_notice','enabled')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD   `enabled` tinyint(3) NOT NULL");}
if(!pdo_fieldexists('hcpdd_notice','createtime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD   `createtime` char(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_notice','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_notice')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `ordersn` varchar(30) DEFAULT '',
  `fid` int(11) DEFAULT NULL COMMENT '0升级代理订单1升级总监订单',
  `fee` decimal(11,2) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `paystatus` tinyint(1) NOT NULL DEFAULT '0',
  `paytime` char(10) NOT NULL,
  `transid` varchar(50) DEFAULT '',
  `createtime` int(10) DEFAULT '0',
  `package` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_orders','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_orders','weid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_orders','uid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `uid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_orders','ordersn')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `ordersn` varchar(30) DEFAULT ''");}
if(!pdo_fieldexists('hcpdd_orders','fid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `fid` int(11) DEFAULT NULL COMMENT '0升级代理订单1升级总监订单'");}
if(!pdo_fieldexists('hcpdd_orders','fee')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `fee` decimal(11,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_orders','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `status` tinyint(1) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_orders','paystatus')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `paystatus` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_orders','paytime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `paytime` char(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_orders','transid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `transid` varchar(50) DEFAULT ''");}
if(!pdo_fieldexists('hcpdd_orders','createtime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `createtime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_orders','package')) {pdo_query("ALTER TABLE ".tablename('hcpdd_orders')." ADD   `package` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_pddcommission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '佣金获取人id,上级',
  `pid` varchar(100) DEFAULT NULL COMMENT '推广人拼多多推广位',
  `level` int(11) DEFAULT NULL COMMENT '1 一级佣金 2 二级佣金 3 三级佣金',
  `order_sn` varchar(100) DEFAULT NULL,
  `fee` varchar(10) DEFAULT NULL COMMENT '计佣金额',
  `fx_commission` decimal(10,3) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0预估佣金1可提现佣金2已提现佣金3无效订单',
  `addtime` varchar(255) DEFAULT NULL,
  `goodsname` varchar(255) DEFAULT NULL COMMENT '商品名',
  `fx_rate` varchar(20) DEFAULT NULL,
  `is_daili` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_pddcommission','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_pddcommission','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_pddcommission','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `user_id` int(11) DEFAULT NULL COMMENT '佣金获取人id,上级'");}
if(!pdo_fieldexists('hcpdd_pddcommission','pid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `pid` varchar(100) DEFAULT NULL COMMENT '推广人拼多多推广位'");}
if(!pdo_fieldexists('hcpdd_pddcommission','level')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `level` int(11) DEFAULT NULL COMMENT '1 一级佣金 2 二级佣金 3 三级佣金'");}
if(!pdo_fieldexists('hcpdd_pddcommission','order_sn')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `order_sn` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_pddcommission','fee')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `fee` varchar(10) DEFAULT NULL COMMENT '计佣金额'");}
if(!pdo_fieldexists('hcpdd_pddcommission','fx_commission')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `fx_commission` decimal(10,3) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_pddcommission','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `status` int(11) DEFAULT NULL COMMENT '0预估佣金1可提现佣金2已提现佣金3无效订单'");}
if(!pdo_fieldexists('hcpdd_pddcommission','addtime')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `addtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_pddcommission','goodsname')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `goodsname` varchar(255) DEFAULT NULL COMMENT '商品名'");}
if(!pdo_fieldexists('hcpdd_pddcommission','fx_rate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `fx_rate` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_pddcommission','is_daili')) {pdo_query("ALTER TABLE ".tablename('hcpdd_pddcommission')." ADD   `is_daili` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `client_id` varchar(100) DEFAULT NULL COMMENT 'client_id',
  `client_secret` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL COMMENT '联系人',
  `contact_qr` varchar(200) NOT NULL COMMENT '联系二维码',
  `share_icon` varchar(200) NOT NULL COMMENT '分享图标',
  `bg_pic` varchar(200) NOT NULL COMMENT '个人中心头部背景',
  `head_color` varchar(20) NOT NULL,
  `search_color` varchar(20) NOT NULL COMMENT '搜索框颜色',
  `tixianb_color` varchar(20) NOT NULL COMMENT '提现按钮颜色',
  `tixiant_color` varchar(20) NOT NULL COMMENT '提现字体颜色',
  `moneyrate` float NOT NULL DEFAULT '1' COMMENT '用户佣金比例',
  `title` varchar(100) NOT NULL,
  `share` varchar(100) NOT NULL,
  `self` varchar(100) NOT NULL,
  `loginbg` varchar(200) NOT NULL,
  `enable` int(11) NOT NULL,
  `shenhe` int(11) NOT NULL,
  `sohead` varchar(200) NOT NULL,
  `sobg` varchar(200) NOT NULL,
  `is_index` int(10) NOT NULL COMMENT '1显示0不显示',
  `zongjian_moneyrate` float NOT NULL DEFAULT '1' COMMENT '总监佣金比',
  `daili_moneyrate` float NOT NULL DEFAULT '1',
  `sharecolor` varchar(255) NOT NULL COMMENT '商品详情分享赚按钮',
  `selfcolor` varchar(255) NOT NULL COMMENT '商品详情自省买按钮',
  `contactway` int(10) NOT NULL DEFAULT '0',
  `huiyuan` varchar(255) NOT NULL DEFAULT '会员',
  `indextitle` varchar(255) NOT NULL,
  `indexpic` varchar(255) NOT NULL,
  `wtype` int(11) NOT NULL DEFAULT '1' COMMENT '1支付宝0企业微信',
  `tx_money` float(10,2) NOT NULL DEFAULT '10.00' COMMENT '提现门槛',
  `tx_intro` varchar(255) NOT NULL COMMENT '提现说明',
  `zzappid` varchar(255) NOT NULL COMMENT '中转小程序appid',
  `zeroshare` varchar(255) NOT NULL,
  `zerobuy` varchar(255) NOT NULL,
  `getmobile` int(11) NOT NULL,
  `version` varchar(255) NOT NULL COMMENT '版本号',
  `top` varchar(255) NOT NULL,
  `goodtop` varchar(255) NOT NULL,
  `copy_writer` varchar(255) NOT NULL,
  `copy_headpic` varchar(255) NOT NULL,
  `sptj` varchar(50) NOT NULL,
  `scyx` varchar(50) NOT NULL,
  `xsbf` varchar(50) NOT NULL,
  `is_tree` int(11) NOT NULL,
  `min_treemoney` decimal(10,2) NOT NULL,
  `max_treemoney` decimal(10,2) NOT NULL,
  `min_treetxmoney` decimal(10,2) NOT NULL,
  `tree_pic` varchar(255) NOT NULL,
  `treesharepic` varchar(255) NOT NULL,
  `treesharetitle` varchar(255) NOT NULL,
  `treeadultid` varchar(255) NOT NULL,
  `treewith_pic` varchar(200) NOT NULL,
  `treeinfo` varchar(200) NOT NULL,
  `app_key` varchar(50) NOT NULL,
  `app_secret` varchar(50) NOT NULL,
  `access_token` varchar(50) NOT NULL,
  `mogurate` varchar(10) NOT NULL,
  `mogudailirate` varchar(10) NOT NULL,
  `moguzongjianrate` varchar(10) NOT NULL,
  `uid` varchar(20) NOT NULL COMMENT '蘑菇街uid',
  `is_mogu` int(11) NOT NULL DEFAULT '0',
  `tree_pic2` varchar(60) NOT NULL,
  `tuijian_type` int(11) NOT NULL,
  `is_jd` int(11) NOT NULL,
  `unionId` varchar(50) NOT NULL,
  `jdappkey` varchar(50) NOT NULL,
  `jdsecretkey` varchar(50) NOT NULL,
  `siteid` varchar(50) NOT NULL,
  `jdkey` varchar(100) NOT NULL,
  `jdrate` varchar(10) NOT NULL,
  `jddailirate` varchar(10) NOT NULL,
  `jdzongjianrate` varchar(10) NOT NULL,
  `is_kouhong` int(11) NOT NULL DEFAULT '1',
  `kouhong_pic` varchar(60) NOT NULL,
  `kouhong_sharetitle` varchar(100) NOT NULL,
  `kouhong_sharepic` varchar(60) NOT NULL,
  `kouhong_ids` varchar(200) NOT NULL,
  `kouhong_color` varchar(100) NOT NULL,
  `pddsobg` varchar(60) NOT NULL,
  `jdsobg` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_set','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_set','client_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `client_id` varchar(100) DEFAULT NULL COMMENT 'client_id'");}
if(!pdo_fieldexists('hcpdd_set','client_secret')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `client_secret` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','contact')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `contact` varchar(20) DEFAULT NULL COMMENT '联系人'");}
if(!pdo_fieldexists('hcpdd_set','contact_qr')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `contact_qr` varchar(200) NOT NULL COMMENT '联系二维码'");}
if(!pdo_fieldexists('hcpdd_set','share_icon')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `share_icon` varchar(200) NOT NULL COMMENT '分享图标'");}
if(!pdo_fieldexists('hcpdd_set','bg_pic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `bg_pic` varchar(200) NOT NULL COMMENT '个人中心头部背景'");}
if(!pdo_fieldexists('hcpdd_set','head_color')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `head_color` varchar(20) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','search_color')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `search_color` varchar(20) NOT NULL COMMENT '搜索框颜色'");}
if(!pdo_fieldexists('hcpdd_set','tixianb_color')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `tixianb_color` varchar(20) NOT NULL COMMENT '提现按钮颜色'");}
if(!pdo_fieldexists('hcpdd_set','tixiant_color')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `tixiant_color` varchar(20) NOT NULL COMMENT '提现字体颜色'");}
if(!pdo_fieldexists('hcpdd_set','moneyrate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `moneyrate` float NOT NULL DEFAULT '1' COMMENT '用户佣金比例'");}
if(!pdo_fieldexists('hcpdd_set','title')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `title` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','share')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `share` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','self')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `self` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','loginbg')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `loginbg` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','enable')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `enable` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','shenhe')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `shenhe` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','sohead')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `sohead` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','sobg')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `sobg` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','is_index')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `is_index` int(10) NOT NULL COMMENT '1显示0不显示'");}
if(!pdo_fieldexists('hcpdd_set','zongjian_moneyrate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `zongjian_moneyrate` float NOT NULL DEFAULT '1' COMMENT '总监佣金比'");}
if(!pdo_fieldexists('hcpdd_set','daili_moneyrate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `daili_moneyrate` float NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('hcpdd_set','sharecolor')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `sharecolor` varchar(255) NOT NULL COMMENT '商品详情分享赚按钮'");}
if(!pdo_fieldexists('hcpdd_set','selfcolor')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `selfcolor` varchar(255) NOT NULL COMMENT '商品详情自省买按钮'");}
if(!pdo_fieldexists('hcpdd_set','contactway')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `contactway` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_set','huiyuan')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `huiyuan` varchar(255) NOT NULL DEFAULT '会员'");}
if(!pdo_fieldexists('hcpdd_set','indextitle')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `indextitle` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','indexpic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `indexpic` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','wtype')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `wtype` int(11) NOT NULL DEFAULT '1' COMMENT '1支付宝0企业微信'");}
if(!pdo_fieldexists('hcpdd_set','tx_money')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `tx_money` float(10,2) NOT NULL DEFAULT '10.00' COMMENT '提现门槛'");}
if(!pdo_fieldexists('hcpdd_set','tx_intro')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `tx_intro` varchar(255) NOT NULL COMMENT '提现说明'");}
if(!pdo_fieldexists('hcpdd_set','zzappid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `zzappid` varchar(255) NOT NULL COMMENT '中转小程序appid'");}
if(!pdo_fieldexists('hcpdd_set','zeroshare')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `zeroshare` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','zerobuy')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `zerobuy` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','getmobile')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `getmobile` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','version')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `version` varchar(255) NOT NULL COMMENT '版本号'");}
if(!pdo_fieldexists('hcpdd_set','top')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `top` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','goodtop')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `goodtop` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','copy_writer')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `copy_writer` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','copy_headpic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `copy_headpic` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','sptj')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `sptj` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','scyx')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `scyx` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','xsbf')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `xsbf` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','is_tree')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `is_tree` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','min_treemoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `min_treemoney` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','max_treemoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `max_treemoney` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','min_treetxmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `min_treetxmoney` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','tree_pic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `tree_pic` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','treesharepic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `treesharepic` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','treesharetitle')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `treesharetitle` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','treeadultid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `treeadultid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','treewith_pic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `treewith_pic` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','treeinfo')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `treeinfo` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','app_key')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `app_key` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','app_secret')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `app_secret` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','access_token')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `access_token` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','mogurate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `mogurate` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','mogudailirate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `mogudailirate` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','moguzongjianrate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `moguzongjianrate` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','uid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `uid` varchar(20) NOT NULL COMMENT '蘑菇街uid'");}
if(!pdo_fieldexists('hcpdd_set','is_mogu')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `is_mogu` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_set','tree_pic2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `tree_pic2` varchar(60) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','tuijian_type')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `tuijian_type` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','is_jd')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `is_jd` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','unionId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `unionId` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','jdappkey')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `jdappkey` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','jdsecretkey')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `jdsecretkey` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','siteid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `siteid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','jdkey')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `jdkey` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','jdrate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `jdrate` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','jddailirate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `jddailirate` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','jdzongjianrate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `jdzongjianrate` varchar(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','is_kouhong')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `is_kouhong` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('hcpdd_set','kouhong_pic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `kouhong_pic` varchar(60) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','kouhong_sharetitle')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `kouhong_sharetitle` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','kouhong_sharepic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `kouhong_sharepic` varchar(60) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','kouhong_ids')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `kouhong_ids` varchar(200) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','kouhong_color')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `kouhong_color` varchar(100) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','pddsobg')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `pddsobg` varchar(60) NOT NULL");}
if(!pdo_fieldexists('hcpdd_set','jdsobg')) {pdo_query("ALTER TABLE ".tablename('hcpdd_set')." ADD   `jdsobg` varchar(60) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_shenhe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `stact` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `time` int(225) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_shenhe','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenhe')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_shenhe','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenhe')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_shenhe','stact')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenhe')." ADD   `stact` int(11) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_shenhe','name')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenhe')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_shenhe','time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenhe')." ADD   `time` int(225) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_shenhe','sort')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenhe')." ADD   `sort` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_shenhe','img')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenhe')." ADD   `img` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_shenhe','content')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenhe')." ADD   `content` text");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_shenheset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `goodsname1` varchar(255) NOT NULL DEFAULT '防滑挂钩家用小衣夹',
  `goodsname2` varchar(255) NOT NULL DEFAULT '多功能魔术伸缩晾衣服撑子',
  `goodsname3` varchar(255) NOT NULL DEFAULT '旅行收纳袋套装',
  `goodsname4` varchar(255) NOT NULL DEFAULT '旅行出差收纳袋4件套',
  `goodsname5` varchar(255) NOT NULL DEFAULT '旅行出差收纳袋4件套',
  `goodsname6` varchar(255) NOT NULL DEFAULT '海澜之家翻领PU皮夹克',
  `goodsname7` varchar(255) NOT NULL DEFAULT '学生港风休闲男士工装衣服',
  `goodsname8` varchar(255) NOT NULL DEFAULT '连衣裙2018秋冬新款',
  `goodsname9` varchar(255) NOT NULL DEFAULT '冬新款韩版修身V领雪纺衫',
  `goodsprice1` varchar(255) NOT NULL DEFAULT '19.9',
  `goodsprice2` varchar(255) NOT NULL DEFAULT '19.8',
  `goodsprice3` varchar(255) NOT NULL DEFAULT '88.8',
  `goodsprice4` varchar(255) NOT NULL DEFAULT '28.0',
  `goodsprice5` varchar(255) NOT NULL DEFAULT '149.0',
  `goodsprice6` varchar(255) NOT NULL DEFAULT '598.0',
  `goodsprice7` varchar(255) NOT NULL DEFAULT '128.0',
  `goodsprice8` varchar(255) NOT NULL DEFAULT '218.0',
  `goodsprice9` varchar(255) NOT NULL DEFAULT '149.0',
  `goodspic1` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n7/jfs/t22591/202/1901797918/139187/aefd9b42/5b6d3200Nefaaa468.jpg',
  `goodspic2` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n7/jfs/t16468/159/2189574984/239282/984fc307/5a97918eN4fdc42ff.jpg',
  `goodspic3` varchar(255) NOT NULL DEFAULT 'https://img10.360buyimg.com/n7/jfs/t19804/96/552338809/399239/366eac09/5afe5b44Ne946460b.jpg',
  `goodspic4` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n7/jfs/t19753/2/1230514607/107872/c01438cf/5ac310e9N78833b0f.jpg',
  `goodspic5` varchar(255) NOT NULL DEFAULT 'https://img11.360buyimg.com/n8/jfs/t26218/256/979754907/566598/c866583f/5bbef96aN5cd4cf7f.jpg',
  `goodspic6` varchar(255) NOT NULL DEFAULT 'https://img12.360buyimg.com/n8/jfs/t25039/362/848582219/364460/f8f9d832/5b7e8e7aN848e7e03.jpg',
  `goodspic7` varchar(255) NOT NULL DEFAULT 'https://img11.360buyimg.com/n8/jfs/t24982/277/1718337506/358352/1a9cc537/5bb9a59cN7388d8dd.jpg',
  `goodspic8` varchar(255) NOT NULL DEFAULT 'https://img10.360buyimg.com/n8/jfs/t1/7666/21/7609/396183/5be3a141E4631c62c/d3c82b7f2ac01055.jpg',
  `goodspic9` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n8/jfs/t1/4982/19/13210/407501/5bd7e9b6Efd5d85d9/133ae50abc56063c.jpg',
  `banner1` varchar(255) NOT NULL DEFAULT 'https://we10.66bbn.com/attachment/images/25/2018/11/Tn6II1stG5IN6NIFn6IwNIPCaasTPf.png',
  `banner2` varchar(255) NOT NULL DEFAULT 'https://we10.66bbn.com/attachment/images/25/2018/11/IA6p6cxGgqaP3l6a5K6aC3cZPcCg3l.png',
  `banner3` varchar(255) NOT NULL DEFAULT 'https://we10.66bbn.com/attachment/images/25/2018/11/E94VF65Elw0ks417zh1d934Ie1w437.png',
  `notice` varchar(255) NOT NULL DEFAULT '本程序商品仅做展示使用，喜欢的商品请到店购买',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_shenheset','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_shenheset','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsname1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsname1` varchar(255) NOT NULL DEFAULT '防滑挂钩家用小衣夹'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsname2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsname2` varchar(255) NOT NULL DEFAULT '多功能魔术伸缩晾衣服撑子'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsname3')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsname3` varchar(255) NOT NULL DEFAULT '旅行收纳袋套装'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsname4')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsname4` varchar(255) NOT NULL DEFAULT '旅行出差收纳袋4件套'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsname5')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsname5` varchar(255) NOT NULL DEFAULT '旅行出差收纳袋4件套'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsname6')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsname6` varchar(255) NOT NULL DEFAULT '海澜之家翻领PU皮夹克'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsname7')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsname7` varchar(255) NOT NULL DEFAULT '学生港风休闲男士工装衣服'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsname8')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsname8` varchar(255) NOT NULL DEFAULT '连衣裙2018秋冬新款'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsname9')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsname9` varchar(255) NOT NULL DEFAULT '冬新款韩版修身V领雪纺衫'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsprice1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsprice1` varchar(255) NOT NULL DEFAULT '19.9'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsprice2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsprice2` varchar(255) NOT NULL DEFAULT '19.8'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsprice3')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsprice3` varchar(255) NOT NULL DEFAULT '88.8'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsprice4')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsprice4` varchar(255) NOT NULL DEFAULT '28.0'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsprice5')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsprice5` varchar(255) NOT NULL DEFAULT '149.0'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsprice6')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsprice6` varchar(255) NOT NULL DEFAULT '598.0'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsprice7')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsprice7` varchar(255) NOT NULL DEFAULT '128.0'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsprice8')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsprice8` varchar(255) NOT NULL DEFAULT '218.0'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodsprice9')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodsprice9` varchar(255) NOT NULL DEFAULT '149.0'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodspic1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodspic1` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n7/jfs/t22591/202/1901797918/139187/aefd9b42/5b6d3200Nefaaa468.jpg'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodspic2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodspic2` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n7/jfs/t16468/159/2189574984/239282/984fc307/5a97918eN4fdc42ff.jpg'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodspic3')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodspic3` varchar(255) NOT NULL DEFAULT 'https://img10.360buyimg.com/n7/jfs/t19804/96/552338809/399239/366eac09/5afe5b44Ne946460b.jpg'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodspic4')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodspic4` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n7/jfs/t19753/2/1230514607/107872/c01438cf/5ac310e9N78833b0f.jpg'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodspic5')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodspic5` varchar(255) NOT NULL DEFAULT 'https://img11.360buyimg.com/n8/jfs/t26218/256/979754907/566598/c866583f/5bbef96aN5cd4cf7f.jpg'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodspic6')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodspic6` varchar(255) NOT NULL DEFAULT 'https://img12.360buyimg.com/n8/jfs/t25039/362/848582219/364460/f8f9d832/5b7e8e7aN848e7e03.jpg'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodspic7')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodspic7` varchar(255) NOT NULL DEFAULT 'https://img11.360buyimg.com/n8/jfs/t24982/277/1718337506/358352/1a9cc537/5bb9a59cN7388d8dd.jpg'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodspic8')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodspic8` varchar(255) NOT NULL DEFAULT 'https://img10.360buyimg.com/n8/jfs/t1/7666/21/7609/396183/5be3a141E4631c62c/d3c82b7f2ac01055.jpg'");}
if(!pdo_fieldexists('hcpdd_shenheset','goodspic9')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `goodspic9` varchar(255) NOT NULL DEFAULT 'https://img13.360buyimg.com/n8/jfs/t1/4982/19/13210/407501/5bd7e9b6Efd5d85d9/133ae50abc56063c.jpg'");}
if(!pdo_fieldexists('hcpdd_shenheset','banner1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `banner1` varchar(255) NOT NULL DEFAULT 'https://we10.66bbn.com/attachment/images/25/2018/11/Tn6II1stG5IN6NIFn6IwNIPCaasTPf.png'");}
if(!pdo_fieldexists('hcpdd_shenheset','banner2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `banner2` varchar(255) NOT NULL DEFAULT 'https://we10.66bbn.com/attachment/images/25/2018/11/IA6p6cxGgqaP3l6a5K6aC3cZPcCg3l.png'");}
if(!pdo_fieldexists('hcpdd_shenheset','banner3')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `banner3` varchar(255) NOT NULL DEFAULT 'https://we10.66bbn.com/attachment/images/25/2018/11/E94VF65Elw0ks417zh1d934Ie1w437.png'");}
if(!pdo_fieldexists('hcpdd_shenheset','notice')) {pdo_query("ALTER TABLE ".tablename('hcpdd_shenheset')." ADD   `notice` varchar(255) NOT NULL DEFAULT '本程序商品仅做展示使用，喜欢的商品请到店购买'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `show1` varchar(100) DEFAULT NULL,
  `show2` varchar(100) DEFAULT NULL,
  `show3` varchar(100) DEFAULT NULL,
  `show4` varchar(100) DEFAULT NULL,
  `show5` varchar(100) DEFAULT NULL,
  `rexiao1` varchar(60) NOT NULL,
  `rexiao2` varchar(60) NOT NULL,
  `baoyou1` varchar(60) NOT NULL,
  `baoyou2` varchar(60) NOT NULL,
  `youhui1` varchar(60) NOT NULL,
  `youhui2` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_show','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_show','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_show','show1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `show1` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_show','show2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `show2` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_show','show3')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `show3` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_show','show4')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `show4` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_show','show5')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `show5` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_show','rexiao1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `rexiao1` varchar(60) NOT NULL");}
if(!pdo_fieldexists('hcpdd_show','rexiao2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `rexiao2` varchar(60) NOT NULL");}
if(!pdo_fieldexists('hcpdd_show','baoyou1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `baoyou1` varchar(60) NOT NULL");}
if(!pdo_fieldexists('hcpdd_show','baoyou2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `baoyou2` varchar(60) NOT NULL");}
if(!pdo_fieldexists('hcpdd_show','youhui1')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `youhui1` varchar(60) NOT NULL");}
if(!pdo_fieldexists('hcpdd_show','youhui2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_show')." ADD   `youhui2` varchar(60) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_son` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `son_uniacid` int(11) DEFAULT NULL,
  `son_pid` varchar(255) DEFAULT NULL,
  `son_rate` varchar(255) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `finishmoney` decimal(10,2) NOT NULL,
  `waitmoney` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_son','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_son')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_son','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_son')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_son','son_uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_son')." ADD   `son_uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_son','son_pid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_son')." ADD   `son_pid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_son','son_rate')) {pdo_query("ALTER TABLE ".tablename('hcpdd_son')." ADD   `son_rate` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_son','money')) {pdo_query("ALTER TABLE ".tablename('hcpdd_son')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_son','finishmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_son')." ADD   `finishmoney` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_son','waitmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_son')." ADD   `waitmoney` decimal(10,2) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `goods` varchar(200) DEFAULT NULL,
  `mainpic` varchar(100) DEFAULT NULL,
  `enabled` int(11) DEFAULT NULL,
  `jump` int(11) NOT NULL DEFAULT '1',
  `zhuti_color` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_theme','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_theme')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_theme','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_theme')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_theme','name')) {pdo_query("ALTER TABLE ".tablename('hcpdd_theme')." ADD   `name` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_theme','banner')) {pdo_query("ALTER TABLE ".tablename('hcpdd_theme')." ADD   `banner` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_theme','goods')) {pdo_query("ALTER TABLE ".tablename('hcpdd_theme')." ADD   `goods` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_theme','mainpic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_theme')." ADD   `mainpic` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_theme','enabled')) {pdo_query("ALTER TABLE ".tablename('hcpdd_theme')." ADD   `enabled` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_theme','jump')) {pdo_query("ALTER TABLE ".tablename('hcpdd_theme')." ADD   `jump` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('hcpdd_theme','zhuti_color')) {pdo_query("ALTER TABLE ".tablename('hcpdd_theme')." ADD   `zhuti_color` varchar(100) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_tixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `tel` varchar(20) NOT NULL COMMENT '手机号',
  `truename` varchar(20) NOT NULL COMMENT '姓名',
  `weixin` varchar(20) NOT NULL COMMENT '微信号',
  `payment_time` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_tixian','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_tixian','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD   `user_id` int(10) NOT NULL");}
if(!pdo_fieldexists('hcpdd_tixian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('hcpdd_tixian','open_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD   `open_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_tixian','tel')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD   `tel` varchar(20) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('hcpdd_tixian','truename')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD   `truename` varchar(20) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('hcpdd_tixian','weixin')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD   `weixin` varchar(20) NOT NULL COMMENT '微信号'");}
if(!pdo_fieldexists('hcpdd_tixian','payment_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD   `payment_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_tixian','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD   `status` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_tixian','money')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tixian')." ADD   `money` decimal(11,2) NOT NULL DEFAULT '0.00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_treelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hbmoney` decimal(10,2) DEFAULT NULL,
  `son_id` int(11) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `hb_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`uniacid`,`user_id`,`son_id`,`hb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_treelog','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treelog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_treelog','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treelog')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treelog','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treelog')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treelog','hbmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treelog')." ADD   `hbmoney` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treelog','son_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treelog')." ADD   `son_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treelog','time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treelog')." ADD   `time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treelog','hb_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treelog')." ADD   `hb_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treelog','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treelog')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_treewith` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `add_time` varchar(255) DEFAULT NULL,
  `pay_time` varchar(255) DEFAULT NULL,
  `partner_trade_no` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `nick_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_treewith','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treewith')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_treewith','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treewith')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treewith','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treewith')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treewith','money')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treewith')." ADD   `money` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treewith','add_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treewith')." ADD   `add_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treewith','pay_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treewith')." ADD   `pay_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treewith','partner_trade_no')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treewith')." ADD   `partner_trade_no` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_treewith','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treewith')." ADD   `status` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_treewith','nick_name')) {pdo_query("ALTER TABLE ".tablename('hcpdd_treewith')." ADD   `nick_name` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_tuijian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `displayorder` varchar(20) DEFAULT NULL,
  `jump` int(11) DEFAULT NULL,
  `toppic` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title2` varchar(255) DEFAULT NULL,
  `titlecolor` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_tuijian','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tuijian')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_tuijian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tuijian')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_tuijian','displayorder')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tuijian')." ADD   `displayorder` varchar(20) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_tuijian','jump')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tuijian')." ADD   `jump` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_tuijian','toppic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tuijian')." ADD   `toppic` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_tuijian','title')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tuijian')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_tuijian','title2')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tuijian')." ADD   `title2` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_tuijian','titlecolor')) {pdo_query("ALTER TABLE ".tablename('hcpdd_tuijian')." ADD   `titlecolor` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `head_pic` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `hcpdd_sum` int(11) NOT NULL DEFAULT '0' COMMENT '参与次数',
  `hcpdd_zuida` int(11) NOT NULL DEFAULT '0' COMMENT '参与最大',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '可提现金额',
  `finishmoney` decimal(8,2) NOT NULL COMMENT '已提现金额',
  `waitmoney` decimal(8,2) NOT NULL COMMENT '待审核金额',
  `zhuangtai` int(11) NOT NULL DEFAULT '1',
  `pid` varchar(50) NOT NULL,
  `cmoney` decimal(10,2) NOT NULL COMMENT '提成',
  `cfinishmoney` decimal(10,2) NOT NULL,
  `cwaitmoney` decimal(10,2) NOT NULL,
  `is_daili` int(10) NOT NULL COMMENT '1代理0不是代理',
  `fatherid` int(11) NOT NULL COMMENT '父id',
  `mobile` varchar(255) DEFAULT NULL,
  `treemoney` decimal(10,2) NOT NULL,
  `gid` int(11) DEFAULT NULL COMMENT '蘑菇街渠道id',
  `positionId` int(11) DEFAULT NULL COMMENT '京东推广位',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `KEY` (`uniacid`,`open_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2589 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_users','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD 
  `user_id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_users','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_users','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `status` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('hcpdd_users','city')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `city` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_users','country')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `country` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_users','gender')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `gender` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_users','open_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `open_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_users','nick_name')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `nick_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_users','head_pic')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `head_pic` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_users','province')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `province` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_users','hcpdd_sum')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `hcpdd_sum` int(11) NOT NULL DEFAULT '0' COMMENT '参与次数'");}
if(!pdo_fieldexists('hcpdd_users','hcpdd_zuida')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `hcpdd_zuida` int(11) NOT NULL DEFAULT '0' COMMENT '参与最大'");}
if(!pdo_fieldexists('hcpdd_users','money')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '可提现金额'");}
if(!pdo_fieldexists('hcpdd_users','finishmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `finishmoney` decimal(8,2) NOT NULL COMMENT '已提现金额'");}
if(!pdo_fieldexists('hcpdd_users','waitmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `waitmoney` decimal(8,2) NOT NULL COMMENT '待审核金额'");}
if(!pdo_fieldexists('hcpdd_users','zhuangtai')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `zhuangtai` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('hcpdd_users','pid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `pid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('hcpdd_users','cmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `cmoney` decimal(10,2) NOT NULL COMMENT '提成'");}
if(!pdo_fieldexists('hcpdd_users','cfinishmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `cfinishmoney` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_users','cwaitmoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `cwaitmoney` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_users','is_daili')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `is_daili` int(10) NOT NULL COMMENT '1代理0不是代理'");}
if(!pdo_fieldexists('hcpdd_users','fatherid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `fatherid` int(11) NOT NULL COMMENT '父id'");}
if(!pdo_fieldexists('hcpdd_users','mobile')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `mobile` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_users','treemoney')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `treemoney` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('hcpdd_users','gid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `gid` int(11) DEFAULT NULL COMMENT '蘑菇街渠道id'");}
if(!pdo_fieldexists('hcpdd_users','positionId')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   `positionId` int(11) DEFAULT NULL COMMENT '京东推广位'");}
if(!pdo_fieldexists('hcpdd_users','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_users')." ADD   PRIMARY KEY (`user_id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcpdd_with` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `add_time` varchar(255) DEFAULT NULL,
  `pay_time` varchar(255) DEFAULT NULL,
  `partner_trade_no` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `nick_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hcpdd_with','id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_with')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hcpdd_with','uniacid')) {pdo_query("ALTER TABLE ".tablename('hcpdd_with')." ADD   `uniacid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_with','user_id')) {pdo_query("ALTER TABLE ".tablename('hcpdd_with')." ADD   `user_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_with','money')) {pdo_query("ALTER TABLE ".tablename('hcpdd_with')." ADD   `money` decimal(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_with','add_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_with')." ADD   `add_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_with','pay_time')) {pdo_query("ALTER TABLE ".tablename('hcpdd_with')." ADD   `pay_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_with','partner_trade_no')) {pdo_query("ALTER TABLE ".tablename('hcpdd_with')." ADD   `partner_trade_no` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hcpdd_with','status')) {pdo_query("ALTER TABLE ".tablename('hcpdd_with')." ADD   `status` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hcpdd_with','nick_name')) {pdo_query("ALTER TABLE ".tablename('hcpdd_with')." ADD   `nick_name` varchar(255) NOT NULL");}
