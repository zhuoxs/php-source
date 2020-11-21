<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymktv_sun_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_tel` varchar(20) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销申请';

");

if(!pdo_fieldexists('ymktv_sun_distribution','id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymktv_sun_distribution','user_id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('ymktv_sun_distribution','time')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution')." ADD   `time` int(11) NOT NULL");}
if(!pdo_fieldexists('ymktv_sun_distribution','user_name')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution')." ADD   `user_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymktv_sun_distribution','user_tel')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution')." ADD   `user_tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('ymktv_sun_distribution','state')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution')." ADD   `state` int(11) NOT NULL COMMENT '1.审核中2.通过3.拒绝'");}
if(!pdo_fieldexists('ymktv_sun_distribution','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymktv_sun_distribution_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ordertype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类别，1普通，2砍价，3拼团，4抢购，5预约',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `parent_id_1` int(11) NOT NULL COMMENT '一级id',
  `parent_id_2` int(11) NOT NULL COMMENT '二级id',
  `parent_id_3` int(11) NOT NULL COMMENT '3级id',
  `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金',
  `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金',
  `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金',
  `rebate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自购，0否，1是',
  `user_id` int(11) NOT NULL COMMENT '购买用户id',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（用来识别是否计入可提现佣金），0未，1删',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymktv_sun_distribution_order','id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','ordertype')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `ordertype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类别，1普通，2砍价，3拼团，4抢购，5预约'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','order_id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `order_id` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','parent_id_1')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `parent_id_1` int(11) NOT NULL COMMENT '一级id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','parent_id_2')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `parent_id_2` int(11) NOT NULL COMMENT '二级id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','parent_id_3')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `parent_id_3` int(11) NOT NULL COMMENT '3级id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','first_price')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级佣金'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','second_price')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级佣金'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','third_price')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `third_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级佣金'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','rebate')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `rebate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自购，0否，1是'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','user_id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `user_id` int(11) NOT NULL COMMENT '购买用户id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','is_delete')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（用来识别是否计入可提现佣金），0未，1删'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','openid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('ymktv_sun_distribution_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_order')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymktv_sun_distribution_promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `mobilephone` varchar(30) NOT NULL COMMENT '手机号',
  `allcommission` decimal(10,2) NOT NULL COMMENT '累计佣金',
  `canwithdraw` decimal(10,2) NOT NULL COMMENT '可提现佣金',
  `referrer_name` varchar(100) NOT NULL COMMENT '推荐人',
  `referrer_uid` int(11) NOT NULL COMMENT '推荐人id',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态，0审核中，1通过，2拒绝',
  `addtime` int(11) NOT NULL COMMENT '申请时间',
  `checktime` int(11) NOT NULL COMMENT '审核时间',
  `meno` text NOT NULL COMMENT '备注',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id，发模板消息',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现冻结的金额',
  `allratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `code_img` mediumblob NOT NULL COMMENT '小程序码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=383 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymktv_sun_distribution_promoter','id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','openid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','name')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `name` varchar(30) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','mobilephone')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `mobilephone` varchar(30) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','allcommission')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `allcommission` decimal(10,2) NOT NULL COMMENT '累计佣金'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','canwithdraw')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `canwithdraw` decimal(10,2) NOT NULL COMMENT '可提现佣金'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','referrer_name')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `referrer_name` varchar(100) NOT NULL COMMENT '推荐人'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','referrer_uid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `referrer_uid` int(11) NOT NULL COMMENT '推荐人id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','status')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态，0审核中，1通过，2拒绝'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','addtime')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `addtime` int(11) NOT NULL COMMENT '申请时间'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','checktime')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `checktime` int(11) NOT NULL COMMENT '审核时间'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','meno')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `meno` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','form_id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id，发模板消息'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','freezemoney')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `freezemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现冻结的金额'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','allratesmoney')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `allratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','uid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_promoter','code_img')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_promoter')." ADD   `code_img` mediumblob NOT NULL COMMENT '小程序码'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymktv_sun_distribution_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销层级,0不开启，1一级，2二级',
  `is_buyself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销内购，0关闭，1开启',
  `lower_condition` tinyint(1) NOT NULL DEFAULT '0' COMMENT '成为下线条件，0首次点击链接',
  `share_condition` tinyint(3) NOT NULL DEFAULT '0' COMMENT '成为分销商条件，0无条件但要审核，1申请审核，2不需要审核',
  `autoshare` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费自动成为分销商',
  `withdrawtype` varchar(100) NOT NULL COMMENT '提现方式,1微信支付,2支付宝支付,3银行卡支付,4余额支付',
  `minwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度',
  `daymaxwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限',
  `withdrawnotice` text NOT NULL COMMENT '用户提现须知',
  `tpl_wd_arrival` varchar(255) NOT NULL COMMENT '提现到账模板消息id',
  `tpl_wd_fail` varchar(255) NOT NULL COMMENT '提现失败模板消息id',
  `tpl_share_check` varchar(255) NOT NULL COMMENT '分销审核模板消息id',
  `application` text NOT NULL COMMENT '申请协议',
  `applybanner` varchar(255) NOT NULL COMMENT '申请页面banner',
  `checkbanner` varchar(255) NOT NULL COMMENT '待审核页面banner',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `commissiontype` tinyint(3) NOT NULL DEFAULT '1' COMMENT '分销佣金类型，1百分比，2固定金额',
  `firstname` varchar(255) NOT NULL COMMENT '一级名称',
  `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额',
  `secondname` varchar(255) NOT NULL COMMENT '二级名称',
  `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额',
  `withdrawhandingfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费',
  `thirdname` varchar(50) NOT NULL COMMENT '第三级名称',
  `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '第三级佣金',
  `postertoppic` varchar(255) NOT NULL COMMENT '海报图',
  `postertoptitle` varchar(200) NOT NULL COMMENT '海报标题',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymktv_sun_distribution_set','id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','status')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销层级,0不开启，1一级，2二级'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','is_buyself')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `is_buyself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销内购，0关闭，1开启'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','lower_condition')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `lower_condition` tinyint(1) NOT NULL DEFAULT '0' COMMENT '成为下线条件，0首次点击链接'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','share_condition')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `share_condition` tinyint(3) NOT NULL DEFAULT '0' COMMENT '成为分销商条件，0无条件但要审核，1申请审核，2不需要审核'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','autoshare')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `autoshare` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费自动成为分销商'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','withdrawtype')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `withdrawtype` varchar(100) NOT NULL COMMENT '提现方式,1微信支付,2支付宝支付,3银行卡支付,4余额支付'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','minwithdraw')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `minwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最少提现额度'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','daymaxwithdraw')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `daymaxwithdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '每日提现上限'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','withdrawnotice')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `withdrawnotice` text NOT NULL COMMENT '用户提现须知'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','tpl_wd_arrival')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `tpl_wd_arrival` varchar(255) NOT NULL COMMENT '提现到账模板消息id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','tpl_wd_fail')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `tpl_wd_fail` varchar(255) NOT NULL COMMENT '提现失败模板消息id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','tpl_share_check')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `tpl_share_check` varchar(255) NOT NULL COMMENT '分销审核模板消息id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','application')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `application` text NOT NULL COMMENT '申请协议'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','applybanner')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `applybanner` varchar(255) NOT NULL COMMENT '申请页面banner'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','checkbanner')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `checkbanner` varchar(255) NOT NULL COMMENT '待审核页面banner'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','commissiontype')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `commissiontype` tinyint(3) NOT NULL DEFAULT '1' COMMENT '分销佣金类型，1百分比，2固定金额'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','firstname')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `firstname` varchar(255) NOT NULL COMMENT '一级名称'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','firstmoney')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `firstmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级金额'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','secondname')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `secondname` varchar(255) NOT NULL COMMENT '二级名称'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','secondmoney')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `secondmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级金额'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','withdrawhandingfee')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `withdrawhandingfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现手续费'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','thirdname')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `thirdname` varchar(50) NOT NULL COMMENT '第三级名称'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','thirdmoney')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `thirdmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '第三级佣金'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','postertoppic')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `postertoppic` varchar(255) NOT NULL COMMENT '海报图'");}
if(!pdo_fieldexists('ymktv_sun_distribution_set','postertoptitle')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_set')." ADD   `postertoptitle` varchar(200) NOT NULL COMMENT '海报标题'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ymktv_sun_distribution_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `uname` varchar(255) NOT NULL COMMENT '姓名',
  `account` varchar(20) NOT NULL COMMENT '提现账号',
  `withdrawaltype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现方式，1微信，2支付宝，3银行卡，4余额',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现状态，0待打款，1已经打款，2拒绝',
  `time` int(11) NOT NULL COMMENT '时间',
  `mobilephone` varchar(30) NOT NULL COMMENT '手机号',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额',
  `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `meno` text NOT NULL COMMENT '备注',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT 'form_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','openid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `openid` varchar(255) NOT NULL COMMENT 'openid'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','uniacid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `uniacid` int(11) NOT NULL COMMENT 'uniacid'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','uname')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `uname` varchar(255) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','account')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `account` varchar(20) NOT NULL COMMENT '提现账号'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','withdrawaltype')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `withdrawaltype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现方式，1微信，2支付宝，3银行卡，4余额'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','status')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现状态，0待打款，1已经打款，2拒绝'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','time')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `time` int(11) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','mobilephone')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `mobilephone` varchar(30) NOT NULL COMMENT '手机号'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','money')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','realmoney')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `realmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','ratesmoney')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `ratesmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','meno')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `meno` text NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','uid')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `uid` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('ymktv_sun_distribution_withdraw','form_id')) {pdo_query("ALTER TABLE ".tablename('ymktv_sun_distribution_withdraw')." ADD   `form_id` varchar(50) NOT NULL COMMENT 'form_id'");}
