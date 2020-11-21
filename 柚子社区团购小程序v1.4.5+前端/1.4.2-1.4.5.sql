ALTER TABLE `ims_sqtg_sun_goods` ADD COLUMN `style_pic`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '(封面图2)' AFTER `video`;

ALTER TABLE `ims_sqtg_sun_order` ADD COLUMN `pay_type`  int(1) NOT NULL DEFAULT 1 AFTER `comment`;

ALTER TABLE `ims_sqtg_sun_ordergoods` ADD COLUMN `pay_type`  int(1) NOT NULL DEFAULT 1 AFTER `del`;

CREATE TABLE `ims_sqtg_sun_recharge` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`uniacid`  int(11) NULL DEFAULT NULL ,
`recharge_lowest`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '最低充值金额' ,
`details`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '充值活动' ,
`create_time`  int(11) NULL DEFAULT NULL ,
`state`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '1启用' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Compact
;

CREATE TABLE `ims_sqtg_sun_rechargerecord` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`user_id`  int(11) NULL DEFAULT NULL ,
`money`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '充值总金额（含赠送）' ,
`send_money`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '赠送金额' ,
`out_trade_no`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号' ,
`transaction_id`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付号' ,
`create_time`  int(11) NULL DEFAULT NULL COMMENT '支付时间' ,
`update_time`  int(11) NULL DEFAULT NULL COMMENT '到账时间' ,
`uniacid`  int(11) NULL DEFAULT NULL ,
`prepay_id`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`state`  int(1) NULL DEFAULT 0 ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Compact
;

ALTER TABLE `ims_sqtg_sun_user` ADD COLUMN `balance`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '用户充值余额' AFTER `vip_endtime`;

CREATE TABLE `ims_sqtg_sun_userbalancerecord` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`uniacid`  int(11) NULL DEFAULT NULL ,
`user_id`  int(11) NULL DEFAULT NULL ,
`store_id`  int(11) NOT NULL DEFAULT 0 ,
`sign`  tinyint(4) NULL DEFAULT NULL COMMENT ' 1.充值 2.支付 3.退款 4.后台操作 5.商户入驻费用 6.开卡返现' ,
`remark`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注：商品名称、充值内容之类' ,
`money`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '总金额（充值含赠送）' ,
`send_money`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '充值赠送的金额' ,
`now_balance`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '当前余额' ,
`title`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称' ,
`create_time`  int(11) NULL DEFAULT NULL ,
`order_id`  int(60) NULL DEFAULT NULL COMMENT '订单id' ,
`order_num`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号' ,
`order_sign`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '订单标识 1普通订单 2合并订单' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Compact
;

