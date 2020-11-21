<?php
$sql = "
CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_setting')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `key` varchar(30) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_wechataddr')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `key` varchar(50) NOT NULL,
  `addressid` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `acid` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_sug')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL COMMENT '公众号id',
  `mid` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_srecord')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_record')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sendmid` int(11) NOT NULL,
  `takemid` int(11) NOT NULL,
  `longitude` varchar(10) DEFAULT NULL,
  `latitude` varchar(10) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sendmid` (`sendmid`),
  KEY `takemid` (`takemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_qrcode')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) DEFAULT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `qrid` int(10) unsigned NOT NULL,
  `model` tinyint(1) NOT NULL,
  `cardsn` varchar(64) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `remark` varchar(50) NOT NULL COMMENT '场景备注',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `qrid` (`qrid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_puvrecord')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_puv')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  `uv` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_member')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员ID',
  `uid` int(11) NOT NULL,
  `invid` int(11) NOT NULL COMMENT '邀请人id',
  `uniacid` int(11) NOT NULL COMMENT '公众号ID',
  `openid` varchar(100) NOT NULL,
  `unionid` varchar(100) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `realname` varchar(50) NOT NULL,
  `credit1` decimal(10,2) NOT NULL,
  `credit2` decimal(10,2) NOT NULL,
  `gender` int(11) NOT NULL,
  `avatar` varchar(300) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `city` varchar(50) NOT NULL COMMENT '市',
  `province` varchar(50) NOT NULL COMMENT '省',
  `plate1` varchar(5) NOT NULL,
  `plate2` varchar(5) NOT NULL,
  `plate_number` varchar(20) NOT NULL COMMENT '车牌号',
  `engine_number` varchar(50) NOT NULL COMMENT '发动机号',
  `frame_number` varchar(50) NOT NULL COMMENT '车架号',
  `brand` varchar(50) NOT NULL COMMENT '品牌',
  `brandimg` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1粉丝2车主',
  `mstatus` int(3) NOT NULL COMMENT '挪车状态0关闭1打开',
  `userstatus` int(2) NOT NULL COMMENT '用户状态（1：正常状态；-1：被拉黑）',
  `ncnumber` varchar(30) NOT NULL COMMENT '挪车卡编号',
  `message` varchar(200) NOT NULL COMMENT '留言',
  `harrystatus` int(11) NOT NULL COMMENT '1开启防骚扰',
  `harrytime1` int(11) NOT NULL,
  `harrytime2` int(11) NOT NULL,
  `acttime` int(11) NOT NULL COMMENT '激活时间',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_apply')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `ordersn` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `area` varchar(32) NOT NULL,
  `address` varchar(100) NOT NULL,
  `status` smallint(2) NOT NULL,
  `express` varchar(32) DEFAULT NULL,
  `expresssn` varchar(32) DEFAULT NULL,
  `sendtime` int(11) DEFAULT NULL,
  `signtime` int(11) DEFAULT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_apirecord')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sendmid` int(11) NOT NULL,
  `sendmobile` varchar(15) DEFAULT NULL,
  `takemid` int(11) NOT NULL,
  `takemobile` varchar(15) DEFAULT NULL,
  `type` smallint(2) NOT NULL,
  `remark` varchar(32) DEFAULT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shifcar_question')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uniacid` int(11) NOT NULL COMMENT '公众号id',
  `title` varchar(64) NOT NULL COMMENT '名称，不能长于20个汉字',
  `answer` text NOT NULL COMMENT '解答内容',
  `categoryid` int(11) NOT NULL COMMENT '分类id',
  `createtime` varchar(32) NOT NULL COMMENT '创建时间',
  `is_show` int(2) NOT NULL COMMENT '是否展示',
  `scan` int(11) NOT NULL COMMENT '浏览量',
  `sort` int(11) NOT NULL COMMENT '排序',
  `is_importent` int(11) NOT NULL COMMENT '是否是重要问题',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='问题解答清单';

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shifcar_category')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动排序',
  `uniacid` int(11) NOT NULL COMMENT '公众号id',
  `name` varchar(32) NOT NULL COMMENT '名称',
  `picture` varchar(64) NOT NULL COMMENT '图标',
  `sort` int(11) NOT NULL COMMENT '排序',
  `is_show` int(2) NOT NULL COMMENT '是否显示',
  `createtime` varchar(32) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='问题分类表';

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_brand')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(50) NOT NULL,
  `imgs` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_class')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brandid` int(11) NOT NULL COMMENT '品牌id',
  `name` varchar(50) NOT NULL COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_address')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL,
  `name` varchar(500) NOT NULL,
  `visible` tinyint(4) unsigned NOT NULL,
  `displayorder` tinyint(11) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `isShow` (`visible`),
  KEY `parentId` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_sclass')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classid` int(11) NOT NULL COMMENT '大类id',
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_query($sql);

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_oplog')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `describe` varchar(225) DEFAULT NULL COMMENT '操作描述',
  `view_url` varchar(225) DEFAULT NULL COMMENT '操作界面url',
  `ip` varchar(32) DEFAULT NULL COMMENT 'IP',
  `data` varchar(1024) DEFAULT NULL COMMENT '操作数据',
  `createtime` varchar(32) DEFAULT NULL COMMENT '操作时间',
  `user` varchar(32) DEFAULT NULL COMMENT '操作员',
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_smstpl')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(32) NOT NULL,
  `smstplid` varchar(32) NOT NULL,
  `data` text NOT NULL,
  `status` smallint(2) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_peccrecord')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `hphm` varchar(32) NOT NULL COMMENT '车牌',
  `address` varchar(100) DEFAULT NULL COMMENT '违章地址',
  `acttime` varchar(50) DEFAULT NULL COMMENT '违章时间',
  `code` int(11) DEFAULT NULL COMMENT '违章代码',
  `status` smallint(2) DEFAULT NULL COMMENT '是否处理,2处理 1未处理 0未知',
  `info` varchar(100) DEFAULT NULL COMMENT '违章内容',
  `fen` int(11) DEFAULT NULL COMMENT '扣分',
  `money` varchar(32) DEFAULT NULL COMMENT '罚款',
  `content` text COMMENT '所有内容',
  `createtime` int(11) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `mid` (`mid`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_waitmessage')." (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `str` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index` (`type`,`uniacid`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_error')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `data` text,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

if(!pdo_fieldexists('weliam_shiftcar_member', 'tasktime')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_member')." ADD `tasktime` int(11) NOT NULL;");
}

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_advertisement')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` int(11) NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

if(!pdo_fieldexists('weliam_shiftcar_apply', 'postage')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_apply')." ADD `postage` DECIMAL(10,2) NOT NULL;");
}

//1.1.8更新字段 
pdo_update('modules',array('subscribes' => 'a:1:{i:0;s:9:"subscribe";}'),array('name' => 'weliam_shiftcar'));

if(!pdo_fieldexists('weliam_shiftcar_advertisement', 'advtype')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_advertisement')." ADD `advtype` int(11) NOT NULL;");
}
if(!pdo_fieldexists('weliam_shiftcar_advertisement', 'cardnumber')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_advertisement')." ADD `cardnumber` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists('weliam_shiftcar_advertisement', 'remark')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_advertisement')." ADD `remark` varchar(100) DEFAULT NULL;");
}

//1.2.3更新字段 
if(!pdo_fieldexists('weliam_shiftcar_advertisement', 'signtime')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_advertisement')." ADD `signtime` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists('weliam_shiftcar_advertisement', 'issettime')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_advertisement')." ADD `issettime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('weliam_shiftcar_qrcode', 'salt')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_qrcode')." ADD `salt` varchar(32) DEFAULT NULL;");
}

//1.2.9更新字段 
if(!pdo_fieldexists('weliam_shiftcar_qrcode', 'sid')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_qrcode')." ADD `sid` int(11) NOT NULL;");
}

//1.3.0更新字段 
if(!pdo_fieldexists('weliam_shiftcar_member', 'limitlinetime')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_member')." ADD `limitlinetime` int(11) NOT NULL;");
}

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_limitlinetpl')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(32) NOT NULL,
  `limitweek` varchar(300) NOT NULL,
  `limitday` varchar(300) NOT NULL,
  `data` text NOT NULL,
  `islimittime` smallint(2) NOT NULL,
  `limittime` varchar(300) NOT NULL,
  `status` smallint(2) NOT NULL,
  `createtime` int(11) NOT NULL,
  `reason` varchar(300) NOT NULL,
  `region` varchar(500) NOT NULL,
  `interval` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('wlmerchant_store_notice')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_mid` (`mid`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

//1.3.2更新字段 
if(!pdo_fieldexists('wlmerchant_store_notice', 'content')) {
  pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD `content` varchar(500) DEFAULT NULL;");
}

//1.3.3更新字段 
if(!pdo_fieldexists('weliam_shiftcar_member', 'hidestatus')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_member')." ADD `hidestatus` int(11) NOT NULL;");
}
if(!pdo_fieldexists('weliam_shiftcar_member', 'hidetime')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_member')." ADD `hidetime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('weliam_shiftcar_member', 'hidelng')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_member')." ADD `hidelng` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists('weliam_shiftcar_member', 'hidelat')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_member')." ADD `hidelat` varchar(50) DEFAULT NULL;");
}
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_hidenotice')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `touser` text,
  `num` int(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

//1.3.4更新字段 
if(!pdo_fieldexists('weliam_shiftcar_record', 'comment')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_record')." ADD `comment` int(11) NOT NULL;");
}
if(!pdo_fieldexists('weliam_shiftcar_limitlinetpl', 'isshare')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_limitlinetpl')." ADD `isshare` int(11) NOT NULL;");
}
if(!pdo_fieldexists('weliam_shiftcar_limitlinetpl', 'shareid')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_limitlinetpl')." ADD `shareid` int(11) NOT NULL;");
}
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_comment')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `reid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

//1.3.5更新字段 
if(!pdo_fieldexists('weliam_shiftcar_limitlinetpl', 'isnumber')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_limitlinetpl')." ADD `isnumber` int(11) NOT NULL;");
}

//1.3.6更新字段 
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_mcrecord')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `times` int(11) NOT NULL,
  `remid` int(11) NOT NULL,
  `remark` varchar(300) DEFAULT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_membercard')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `credit1` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `times` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 ;");

//1.4.6更新字段 
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_bindrecord')." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `phonea` varchar(15) NOT NULL,
  `phoneb` varchar(15) NOT NULL,
  `expiration` int(11) NOT NULL,
  `secretno` varchar(15) NOT NULL,
  `subsid` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uepab` (`uniacid`,`expiration`,`phonea`,`phoneb`),
  KEY `idx_ue` (`uniacid`,`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

//2018.06.28
if(!pdo_fieldexists('weliam_shiftcar_bindrecord', 'type')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_bindrecord')." ADD `type` tinyint(1) NOT NULL;");
}

//2018.08.10
if(!pdo_fieldexists('weliam_shiftcar_qrcode', 'aid')) {
  pdo_query("ALTER TABLE ".tablename('weliam_shiftcar_qrcode')." ADD `aid` int(11) NOT NULL;");
}
pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('weliam_shiftcar_agentusers')." (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  `agentname` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `realname` varchar(32) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `joindate` int(10) unsigned NOT NULL,
  `joinip` varchar(15) NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL,
  `lastip` varchar(15) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");