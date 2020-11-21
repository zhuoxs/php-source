<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_act` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `start` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'end',
  `name` varchar(100) DEFAULT NULL COMMENT '商家名称',
  `content` mediumtext COMMENT '规则',
  `thumb` varchar(255) DEFAULT NULL COMMENT '积分图标',
  `area` varchar(1500) DEFAULT NULL COMMENT '区域限制',
  `free` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '免费赠送积分',
  `maxtimes` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最多能赠送人数',
  `min` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最小值',
  `max` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最大值',
  `creditname` varchar(22) DEFAULT NULL COMMENT '别名',
  `arealimit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '区域限制 0不限制 1限制',
  `sendtype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0快递发货 1上店自提',
  `isform` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0关闭表单 1开启表单',
  `shopaddress` varchar(255) DEFAULT NULL COMMENT '门店地址',
  `shoptel` varchar(20) DEFAULT NULL COMMENT '门店电话',
  `joined` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '参与人数',
  `gametime` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '游戏周期 0 1天 1永久',
  `maxchange` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '最多兑换次数',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0正常 1下架',
  `isshare` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0关闭 1开启',
  `sharetitle` varchar(255) DEFAULT NULL,
  `sharedesc` varchar(255) DEFAULT NULL,
  `shareimg` varchar(255) DEFAULT NULL,
  `isrank` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0显示 1不显示',
  `isminus` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0取关后不减积分 1减积分',
  `isverifyh` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0直接发红包 1审核后再发',
  `przieslider` varchar(3000) DEFAULT NULL COMMENT '兑换奖品页面轮播图',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0关闭链接消息',
  `linkleast` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发链接消息的最小值',
  `linkmess` varchar(3000) DEFAULT NULL COMMENT '消息内容',
  `linklink` varchar(500) DEFAULT NULL COMMENT '链接',
  `islinkmess` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不发，1发',
  `helparr` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0已全部活动计算 1以当前活动计算',
  `prizelim` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不限制兑奖 1限制兑奖时间',
  `prizestart` int(11) unsigned NOT NULL DEFAULT '0',
  `prizeend` int(11) unsigned NOT NULL DEFAULT '0',
  `indextype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `prizerule` text,
  `jftype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0自带积分 1微擎积分',
  PRIMARY KEY (`id`),
  KEY `index` (`uniacid`),
  KEY `start` (`start`),
  KEY `end` (`end`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `actid` int(11) unsigned NOT NULL DEFAULT '0',
  `authopenid` varchar(64) DEFAULT NULL,
  `openid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index` (`uniacid`,`actid`,`authopenid`,`openid`),
  KEY `uniacid` (`uniacid`),
  KEY `actid` (`actid`),
  KEY `authopenid` (`authopenid`),
  KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(33) DEFAULT NULL,
  `tel` varchar(22) DEFAULT NULL,
  `actid` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(64) DEFAULT NULL,
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `index` (`uniacid`,`name`,`openid`,`actid`),
  KEY `openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_geted` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id',
  `openid` varchar(64) DEFAULT NULL,
  `prizeid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '奖品id',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '兑换时间',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '红包，积分，余额数值',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0已兑换  1已领取',
  `miscredit` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '扣除积分',
  `getname` varchar(100) DEFAULT NULL,
  `gettel` varchar(20) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `expressname` varchar(44) DEFAULT NULL,
  `expressnumber` varchar(44) DEFAULT NULL,
  `issend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未发发奖消息 1已发',
  `code` varchar(20) DEFAULT NULL COMMENT '兑奖编码',
  `waitpay` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0已支付  1未支付',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `index` (`uniacid`,`actid`,`openid`,`prizeid`,`code`),
  KEY `actid` (`actid`),
  KEY `openid` (`openid`),
  KEY `prizeid` (`prizeid`)
) ENGINE=InnoDB AUTO_INCREMENT=4145 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_helplist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `helper` varchar(64) DEFAULT NULL COMMENT '赠送积分者',
  `helped` varchar(64) DEFAULT NULL COMMENT '被赠送者',
  `time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `credit` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '赠送的积分',
  `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id',
  `isminus` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未减 1已减',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `index` (`uniacid`,`helper`,`helped`,`actid`),
  KEY `helper` (`helper`),
  KEY `helped` (`helped`),
  KEY `actid` (`actid`)
) ENGINE=InnoDB AUTO_INCREMENT=105478 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_invite` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `unionid` varchar(64) DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0进行中 1已发奖',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `endtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '有效期结束时间',
  `actid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `unionid` (`unionid`),
  KEY `endtime` (`endtime`),
  KEY `actid` (`actid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_key` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `word` varchar(120) DEFAULT NULL,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `actid` int(11) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1主页入口 2我的奖品 3生成海报',
  `title` varchar(255) DEFAULT NULL,
  `thumb` varchar(300) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `index` (`uniacid`,`pid`,`actid`,`word`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_poster` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `params` mediumtext,
  `bgimg` varchar(300) DEFAULT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1海报 2主页页面 3奖品页面',
  `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `index` (`uniacid`,`actid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_prize` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL COMMENT '奖品名称',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0红包 1积分 2余额 3其他',
  `min` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '奖励最小值',
  `max` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '奖励最大值',
  `stock` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `need` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '兑换需要积分',
  `isminus` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不扣积分 1扣积分',
  `maxchange` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '每人最多兑换数量',
  `pic` varchar(255) DEFAULT NULL COMMENT '奖品图片',
  `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应的活动id',
  `isdetail` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不加详情 1加详情',
  `detail` mediumtext,
  `number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '越大越前',
  `tips` varchar(555) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index` (`uniacid`,`actid`,`stock`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_qrcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(64) DEFAULT NULL,
  `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id',
  `qrcodeid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'qrcode表里的id',
  `sence` varchar(64) DEFAULT NULL,
  `expire` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `index` (`uniacid`,`openid`,`actid`,`qrcodeid`,`sence`),
  KEY `openid` (`openid`),
  KEY `actid` (`actid`),
  KEY `qrcodeid` (`qrcodeid`),
  KEY `sence` (`sence`)
) ENGINE=InnoDB AUTO_INCREMENT=13178 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(64) DEFAULT NULL,
  `nickname` varchar(32) DEFAULT NULL,
  `headimgurl` varchar(350) DEFAULT NULL,
  `logintime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `credit` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0正常 1黑名单',
  `code` varchar(30) DEFAULT NULL COMMENT '邀请码',
  `authopenid` varchar(64) DEFAULT NULL,
  `isstart` varchar(255) DEFAULT NULL COMMENT '0 未开始 1已开始',
  `issendlink` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未发link，1已发',
  `unionid` varchar(64) DEFAULT NULL COMMENT '链接',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `index` (`uniacid`,`openid`,`code`,`actid`),
  KEY `status` (`status`),
  KEY `openid` (`openid`),
  KEY `actid` (`actid`),
  KEY `code` (`code`),
  KEY `isstart` (`isstart`),
  KEY `unionid` (`unionid`)
) ENGINE=InnoDB AUTO_INCREMENT=24124 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_zofui_posterhelp_uu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
";
pdo_run($sql);
if(!pdo_fieldexists("zofui_posterhelp_act", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "start")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `start` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "end")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `end` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'end';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "name")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `name` varchar(100) DEFAULT NULL COMMENT '商家名称';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "content")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `content` mediumtext COMMENT '规则';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "thumb")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `thumb` varchar(255) DEFAULT NULL COMMENT '积分图标';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "area")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `area` varchar(1500) DEFAULT NULL COMMENT '区域限制';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "free")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `free` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '免费赠送积分';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "maxtimes")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `maxtimes` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最多能赠送人数';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "min")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `min` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最小值';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "max")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `max` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最大值';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "creditname")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `creditname` varchar(22) DEFAULT NULL COMMENT '别名';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "arealimit")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `arealimit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '区域限制 0不限制 1限制';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "sendtype")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `sendtype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0快递发货 1上店自提';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "isform")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `isform` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0关闭表单 1开启表单';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "shopaddress")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `shopaddress` varchar(255) DEFAULT NULL COMMENT '门店地址';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "shoptel")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `shoptel` varchar(20) DEFAULT NULL COMMENT '门店电话';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "joined")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `joined` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '参与人数';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "gametime")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `gametime` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '游戏周期 0 1天 1永久';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "maxchange")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `maxchange` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '最多兑换次数';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "status")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0正常 1下架';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "isshare")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `isshare` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0关闭 1开启';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "sharetitle")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `sharetitle` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "sharedesc")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `sharedesc` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "shareimg")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `shareimg` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "isrank")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `isrank` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0显示 1不显示';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "isminus")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `isminus` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0取关后不减积分 1减积分';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "isverifyh")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `isverifyh` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0直接发红包 1审核后再发';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "przieslider")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `przieslider` varchar(3000) DEFAULT NULL COMMENT '兑换奖品页面轮播图';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "islink")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `islink` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0关闭链接消息';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "linkleast")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `linkleast` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发链接消息的最小值';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "linkmess")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `linkmess` varchar(3000) DEFAULT NULL COMMENT '消息内容';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "linklink")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `linklink` varchar(500) DEFAULT NULL COMMENT '链接';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "islinkmess")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `islinkmess` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不发，1发';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "helparr")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `helparr` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0已全部活动计算 1以当前活动计算';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "prizelim")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `prizelim` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不限制兑奖 1限制兑奖时间';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "prizestart")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `prizestart` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "prizeend")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `prizeend` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "indextype")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `indextype` tinyint(1) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "prizerule")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `prizerule` text;");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "jftype")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   `jftype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0自带积分 1微擎积分';");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   KEY `index` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "start")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   KEY `start` (`start`);");
}
if(!pdo_fieldexists("zofui_posterhelp_act", "end")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_act")." ADD   KEY `end` (`end`);");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "authopenid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   `authopenid` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   `openid` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   KEY `index` (`uniacid`,`actid`,`authopenid`,`openid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   KEY `actid` (`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "authopenid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   KEY `authopenid` (`authopenid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_auth", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_auth")." ADD   KEY `openid` (`openid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "name")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   `name` varchar(33) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "tel")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   `tel` varchar(22) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   `openid` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   KEY `index` (`uniacid`,`name`,`openid`,`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_form", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_form")." ADD   KEY `openid` (`openid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `openid` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "prizeid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `prizeid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '奖品id';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '兑换时间';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "fee")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '红包，积分，余额数值';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "status")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0已兑换  1已领取';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "miscredit")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `miscredit` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '扣除积分';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "getname")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `getname` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "gettel")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `gettel` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "address")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `address` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "expressname")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `expressname` varchar(44) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "expressnumber")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `expressnumber` varchar(44) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "issend")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `issend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未发发奖消息 1已发';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "code")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `code` varchar(20) DEFAULT NULL COMMENT '兑奖编码';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "waitpay")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   `waitpay` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0已支付  1未支付';");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   KEY `index` (`uniacid`,`actid`,`openid`,`prizeid`,`code`);");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   KEY `actid` (`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   KEY `openid` (`openid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_geted", "prizeid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_geted")." ADD   KEY `prizeid` (`prizeid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "helper")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   `helper` varchar(64) DEFAULT NULL COMMENT '赠送积分者';");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "helped")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   `helped` varchar(64) DEFAULT NULL COMMENT '被赠送者';");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "time")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   `time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '时间';");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "credit")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   `credit` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '赠送的积分';");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id';");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "isminus")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   `isminus` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未减 1已减';");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   KEY `index` (`uniacid`,`helper`,`helped`,`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "helper")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   KEY `helper` (`helper`);");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "helped")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   KEY `helped` (`helped`);");
}
if(!pdo_fieldexists("zofui_posterhelp_helplist", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_helplist")." ADD   KEY `actid` (`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "unionid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   `unionid` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "status")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0进行中 1已发奖';");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "uid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   `uid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "endtime")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   `endtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '有效期结束时间';");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "unionid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   KEY `unionid` (`unionid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "endtime")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   KEY `endtime` (`endtime`);");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   KEY `actid` (`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_invite", "uid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_invite")." ADD   KEY `uid` (`uid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "word")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   `word` varchar(120) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "pid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '规则id';");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "type")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1主页入口 2我的奖品 3生成海报';");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "title")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   `title` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "thumb")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   `thumb` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "desc")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   `desc` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_key", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_key")." ADD   KEY `index` (`uniacid`,`pid`,`actid`,`word`);");
}
if(!pdo_fieldexists("zofui_posterhelp_poster", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_poster")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_poster", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_poster")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_poster", "params")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_poster")." ADD   `params` mediumtext;");
}
if(!pdo_fieldexists("zofui_posterhelp_poster", "bgimg")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_poster")." ADD   `bgimg` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_poster", "type")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_poster")." ADD   `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1海报 2主页页面 3奖品页面';");
}
if(!pdo_fieldexists("zofui_posterhelp_poster", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_poster")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id';");
}
if(!pdo_fieldexists("zofui_posterhelp_poster", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_poster")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_poster", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_poster")." ADD   KEY `index` (`uniacid`,`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "name")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `name` varchar(255) DEFAULT NULL COMMENT '奖品名称';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "type")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0红包 1积分 2余额 3其他';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "min")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `min` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '奖励最小值';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "max")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `max` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '奖励最大值';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "stock")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `stock` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '库存';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "need")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `need` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '兑换需要积分';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "isminus")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `isminus` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不扣积分 1扣积分';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "maxchange")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `maxchange` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '每人最多兑换数量';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "pic")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `pic` varchar(255) DEFAULT NULL COMMENT '奖品图片';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应的活动id';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "isdetail")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `isdetail` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不加详情 1加详情';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "detail")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `detail` mediumtext;");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "number")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '越大越前';");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "tips")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   `tips` varchar(555) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_prize", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_prize")." ADD   KEY `index` (`uniacid`,`actid`,`stock`);");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   `openid` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id';");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "qrcodeid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   `qrcodeid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'qrcode表里的id';");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "sence")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   `sence` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "expire")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   `expire` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间';");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   KEY `index` (`uniacid`,`openid`,`actid`,`qrcodeid`,`sence`);");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   KEY `openid` (`openid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   KEY `actid` (`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "qrcodeid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   KEY `qrcodeid` (`qrcodeid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_qrcode", "sence")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_qrcode")." ADD   KEY `sence` (`sence`);");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `openid` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `nickname` varchar(32) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "headimgurl")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `headimgurl` varchar(350) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "logintime")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `logintime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间';");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "credit")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `credit` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分';");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `actid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动id';");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "status")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0正常 1黑名单';");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "code")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `code` varchar(30) DEFAULT NULL COMMENT '邀请码';");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "authopenid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `authopenid` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "isstart")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `isstart` varchar(255) DEFAULT NULL COMMENT '0 未开始 1已开始';");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "issendlink")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `issendlink` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未发link，1已发';");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "unionid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   `unionid` varchar(64) DEFAULT NULL COMMENT '链接';");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "index")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   KEY `index` (`uniacid`,`openid`,`code`,`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "status")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   KEY `status` (`status`);");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   KEY `openid` (`openid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "actid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   KEY `actid` (`actid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "code")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   KEY `code` (`code`);");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "isstart")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   KEY `isstart` (`isstart`);");
}
if(!pdo_fieldexists("zofui_posterhelp_user", "unionid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_user")." ADD   KEY `unionid` (`unionid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_uu", "id")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_uu")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("zofui_posterhelp_uu", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_uu")." ADD   `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("zofui_posterhelp_uu", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_uu")." ADD   `openid` varchar(64) DEFAULT NULL;");
}
if(!pdo_fieldexists("zofui_posterhelp_uu", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_uu")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("zofui_posterhelp_uu", "openid")) {
 pdo_query("ALTER TABLE ".tablename("zofui_posterhelp_uu")." ADD   KEY `openid` (`openid`);");
}

 ?>