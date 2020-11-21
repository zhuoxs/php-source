<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0',
  `title` varchar(250) DEFAULT '0',
  `pic` varchar(250) DEFAULT '0',
  `url` varchar(250) DEFAULT '0',
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_ad','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_ad')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_ad','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_ad')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_ad','type')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_ad')." ADD   `type` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_ad','title')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_ad')." ADD   `title` varchar(250) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_ad','pic')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_ad')." ADD   `pic` varchar(250) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_ad','url')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_ad')." ADD   `url` varchar(250) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_ad','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_ad')." ADD   `createtime` int(10) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_dlshuju` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `uid` int(11) DEFAULT '0' COMMENT '用户ID',
  `tb1` int(11) DEFAULT '0' COMMENT '本人-今天已付款订单数',
  `tb2` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数',
  `tb3` int(11) DEFAULT '0' COMMENT '本人-昨天已付款订单',
  `tb4` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数',
  `tb5` int(11) DEFAULT '0' COMMENT '本人-本月已付款订单数',
  `tb6` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数',
  `tb7` int(11) DEFAULT '0' COMMENT '本人-上月已结算订单数',
  `tb8` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数',
  `tb9` int(11) DEFAULT '0' COMMENT '本人-上月已付款订单数',
  `tb10` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数',
  `tb11` int(11) DEFAULT '0' COMMENT '二级-今天已付款订单数',
  `tb12` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数',
  `tb13` int(11) DEFAULT '0' COMMENT '二级-昨天已付款订单',
  `tb14` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数',
  `tb15` int(11) DEFAULT '0' COMMENT '二级-本月已付款订单数',
  `tb16` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数',
  `tb17` int(11) DEFAULT '0' COMMENT '二级-上月已结算订单数',
  `tb18` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数',
  `tb19` int(11) DEFAULT '0' COMMENT '二级-上月已付款订单数',
  `tb20` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数',
  `tb21` int(11) DEFAULT '0' COMMENT '三级-今天已付款订单数',
  `tb22` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数',
  `tb23` int(11) DEFAULT '0' COMMENT '三级-昨天已付款订单',
  `tb24` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数',
  `tb25` int(11) DEFAULT '0' COMMENT '三级-本月已付款订单数',
  `tb26` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数',
  `tb27` int(11) DEFAULT '0' COMMENT '三级-上月已结算订单数',
  `tb28` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数',
  `tb29` int(11) DEFAULT '0' COMMENT '三级-上月已付款订单数',
  `tb30` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数',
  `pdd1` int(11) DEFAULT '0' COMMENT '本人-今天已付款订单数',
  `pdd2` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数',
  `pdd3` int(11) DEFAULT '0' COMMENT '本人-昨天已付款订单',
  `pdd4` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数',
  `pdd5` int(11) DEFAULT '0' COMMENT '本人-本月已付款订单数',
  `pdd6` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数',
  `pdd7` int(11) DEFAULT '0' COMMENT '本人-上月已结算订单数',
  `pdd8` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数',
  `pdd9` int(11) DEFAULT '0' COMMENT '本人-上月已付款订单数',
  `pdd10` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数',
  `pdd11` int(11) DEFAULT '0' COMMENT '二级-今天已付款订单数',
  `pdd12` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数',
  `pdd13` int(11) DEFAULT '0' COMMENT '二级-昨天已付款订单',
  `pdd14` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数',
  `pdd15` int(11) DEFAULT '0' COMMENT '二级-本月已付款订单数',
  `pdd16` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数',
  `pdd17` int(11) DEFAULT '0' COMMENT '二级-上月已结算订单数',
  `pdd18` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数',
  `pdd19` int(11) DEFAULT '0' COMMENT '二级-上月已付款订单数',
  `pdd20` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数',
  `pdd21` int(11) DEFAULT '0' COMMENT '三级-今天已付款订单数',
  `pdd22` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数',
  `pdd23` int(11) DEFAULT '0' COMMENT '三级-昨天已付款订单',
  `pdd24` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数',
  `pdd25` int(11) DEFAULT '0' COMMENT '三级-本月已付款订单数',
  `pdd26` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数',
  `pdd27` int(11) DEFAULT '0' COMMENT '三级-上月已结算订单数',
  `pdd28` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数',
  `pdd29` int(11) DEFAULT '0' COMMENT '三级-上月已付款订单数',
  `pdd30` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数',
  `jd1` int(11) DEFAULT '0' COMMENT '本人-今天已付款订单数',
  `jd2` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数',
  `jd3` int(11) DEFAULT '0' COMMENT '本人-昨天已付款订单',
  `jd4` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数',
  `jd5` int(11) DEFAULT '0' COMMENT '本人-本月已付款订单数',
  `jd6` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数',
  `jd7` int(11) DEFAULT '0' COMMENT '本人-上月已结算订单数',
  `jd8` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数',
  `jd9` int(11) DEFAULT '0' COMMENT '本人-上月已付款订单数',
  `jd10` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数',
  `jd11` int(11) DEFAULT '0' COMMENT '二级-今天已付款订单数',
  `jd12` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数',
  `jd13` int(11) DEFAULT '0' COMMENT '二级-昨天已付款订单',
  `jd14` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数',
  `jd15` int(11) DEFAULT '0' COMMENT '二级-本月已付款订单数',
  `jd16` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数',
  `jd17` int(11) DEFAULT '0' COMMENT '二级-上月已结算订单数',
  `jd18` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数',
  `jd19` int(11) DEFAULT '0' COMMENT '二级-上月已付款订单数',
  `jd20` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数',
  `jd21` int(11) DEFAULT '0' COMMENT '三级-今天已付款订单数',
  `jd22` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数',
  `jd23` int(11) DEFAULT '0' COMMENT '三级-昨天已付款订单',
  `jd24` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数',
  `jd25` int(11) DEFAULT '0' COMMENT '三级-本月已付款订单数',
  `jd26` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数',
  `jd27` int(11) DEFAULT '0' COMMENT '三级-上月已结算订单数',
  `jd28` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数',
  `jd29` int(11) DEFAULT '0' COMMENT '三级-上月已付款订单数',
  `jd30` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `tb31` int(10) DEFAULT '0' COMMENT '本人-本月已结算订单数',
  `tb32` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已结算预估佣金数',
  `tb33` int(10) DEFAULT '0' COMMENT '二级-本月已结算订单数',
  `tb34` decimal(10,2) DEFAULT '0.00' COMMENT '二级-本月已结算预估佣金数',
  `tb35` int(10) DEFAULT '0' COMMENT '三级-本月已结算订单数',
  `tb36` decimal(10,2) DEFAULT '0.00' COMMENT '三级-本月已结算预估佣金数',
  `pdd31` int(10) DEFAULT '0' COMMENT '本人-本月已结算订单数',
  `pdd32` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已结算预估佣金数',
  `pdd33` int(10) DEFAULT '0' COMMENT '三级级-本月已结算订单数',
  `pdd34` decimal(10,2) DEFAULT '0.00' COMMENT '三级级-本月已结算预估佣金数',
  `pdd35` int(10) DEFAULT '0' COMMENT '三级级-本月已结算订单数',
  `pdd36` decimal(10,2) DEFAULT '0.00' COMMENT '三级级-本月已结算预估佣金数',
  `jd31` int(10) DEFAULT '0' COMMENT '本人-本月已结算订单数',
  `jd32` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已结算预估佣金数',
  `jd33` int(10) DEFAULT '0' COMMENT '三级级-本月已结算订单数',
  `jd34` decimal(10,2) DEFAULT '0.00' COMMENT '三级级-本月已结算预估佣金数',
  `jd35` int(10) DEFAULT '0' COMMENT '三级级-本月已结算订单数',
  `jd36` decimal(10,2) DEFAULT '0.00' COMMENT '三级级-本月已结算预估佣金数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_w` (`uid`,`weid`),
  KEY `weid` (`weid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_dlshuju','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','uid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `uid` int(11) DEFAULT '0' COMMENT '用户ID'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb1` int(11) DEFAULT '0' COMMENT '本人-今天已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb2` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb3` int(11) DEFAULT '0' COMMENT '本人-昨天已付款订单'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb4')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb4` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb5')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb5` int(11) DEFAULT '0' COMMENT '本人-本月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb6')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb6` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb7')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb7` int(11) DEFAULT '0' COMMENT '本人-上月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb8')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb8` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb9')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb9` int(11) DEFAULT '0' COMMENT '本人-上月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb10')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb10` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb11')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb11` int(11) DEFAULT '0' COMMENT '二级-今天已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb12')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb12` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb13')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb13` int(11) DEFAULT '0' COMMENT '二级-昨天已付款订单'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb14')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb14` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb15')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb15` int(11) DEFAULT '0' COMMENT '二级-本月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb16')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb16` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb17')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb17` int(11) DEFAULT '0' COMMENT '二级-上月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb18')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb18` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb19')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb19` int(11) DEFAULT '0' COMMENT '二级-上月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb20')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb20` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb21')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb21` int(11) DEFAULT '0' COMMENT '三级-今天已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb22')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb22` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb23')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb23` int(11) DEFAULT '0' COMMENT '三级-昨天已付款订单'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb24')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb24` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb25')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb25` int(11) DEFAULT '0' COMMENT '三级-本月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb26')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb26` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb27')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb27` int(11) DEFAULT '0' COMMENT '三级-上月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb28')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb28` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb29')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb29` int(11) DEFAULT '0' COMMENT '三级-上月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb30')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb30` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd1` int(11) DEFAULT '0' COMMENT '本人-今天已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd2` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd3` int(11) DEFAULT '0' COMMENT '本人-昨天已付款订单'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd4')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd4` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd5')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd5` int(11) DEFAULT '0' COMMENT '本人-本月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd6')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd6` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd7')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd7` int(11) DEFAULT '0' COMMENT '本人-上月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd8')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd8` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd9')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd9` int(11) DEFAULT '0' COMMENT '本人-上月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd10')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd10` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd11')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd11` int(11) DEFAULT '0' COMMENT '二级-今天已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd12')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd12` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd13')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd13` int(11) DEFAULT '0' COMMENT '二级-昨天已付款订单'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd14')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd14` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd15')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd15` int(11) DEFAULT '0' COMMENT '二级-本月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd16')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd16` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd17')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd17` int(11) DEFAULT '0' COMMENT '二级-上月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd18')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd18` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd19')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd19` int(11) DEFAULT '0' COMMENT '二级-上月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd20')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd20` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd21')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd21` int(11) DEFAULT '0' COMMENT '三级-今天已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd22')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd22` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd23')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd23` int(11) DEFAULT '0' COMMENT '三级-昨天已付款订单'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd24')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd24` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd25')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd25` int(11) DEFAULT '0' COMMENT '三级-本月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd26')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd26` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd27')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd27` int(11) DEFAULT '0' COMMENT '三级-上月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd28')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd28` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd29')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd29` int(11) DEFAULT '0' COMMENT '三级-上月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd30')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd30` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd1` int(11) DEFAULT '0' COMMENT '本人-今天已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd2` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd3` int(11) DEFAULT '0' COMMENT '本人-昨天已付款订单'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd4')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd4` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd5')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd5` int(11) DEFAULT '0' COMMENT '本人-本月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd6')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd6` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd7')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd7` int(11) DEFAULT '0' COMMENT '本人-上月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd8')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd8` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd9')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd9` int(11) DEFAULT '0' COMMENT '本人-上月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd10')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd10` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd11')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd11` int(11) DEFAULT '0' COMMENT '二级-今天已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd12')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd12` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd13')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd13` int(11) DEFAULT '0' COMMENT '二级-昨天已付款订单'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd14')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd14` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd15')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd15` int(11) DEFAULT '0' COMMENT '二级-本月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd16')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd16` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd17')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd17` int(11) DEFAULT '0' COMMENT '二级-上月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd18')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd18` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd19')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd19` int(11) DEFAULT '0' COMMENT '二级-上月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd20')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd20` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd21')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd21` int(11) DEFAULT '0' COMMENT '三级-今天已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd22')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd22` decimal(10,2) DEFAULT '0.00' COMMENT '本人-今天已付款佣预估金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd23')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd23` int(11) DEFAULT '0' COMMENT '三级-昨天已付款订单'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd24')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd24` decimal(10,2) DEFAULT '0.00' COMMENT '本人-昨天已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd25')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd25` int(11) DEFAULT '0' COMMENT '三级-本月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd26')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd26` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd27')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd27` int(11) DEFAULT '0' COMMENT '三级-上月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd28')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd28` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd29')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd29` int(11) DEFAULT '0' COMMENT '三级-上月已付款订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd30')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd30` decimal(10,2) DEFAULT '0.00' COMMENT '本人-上月已付款预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb31')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb31` int(10) DEFAULT '0' COMMENT '本人-本月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb32')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb32` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb33')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb33` int(10) DEFAULT '0' COMMENT '二级-本月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb34')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb34` decimal(10,2) DEFAULT '0.00' COMMENT '二级-本月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb35')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb35` int(10) DEFAULT '0' COMMENT '三级-本月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','tb36')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `tb36` decimal(10,2) DEFAULT '0.00' COMMENT '三级-本月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd31')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd31` int(10) DEFAULT '0' COMMENT '本人-本月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd32')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd32` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd33')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd33` int(10) DEFAULT '0' COMMENT '三级级-本月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd34')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd34` decimal(10,2) DEFAULT '0.00' COMMENT '三级级-本月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd35')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd35` int(10) DEFAULT '0' COMMENT '三级级-本月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','pdd36')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `pdd36` decimal(10,2) DEFAULT '0.00' COMMENT '三级级-本月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd31')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd31` int(10) DEFAULT '0' COMMENT '本人-本月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd32')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd32` decimal(10,2) DEFAULT '0.00' COMMENT '本人-本月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd33')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd33` int(10) DEFAULT '0' COMMENT '三级级-本月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd34')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd34` decimal(10,2) DEFAULT '0.00' COMMENT '三级级-本月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd35')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd35` int(10) DEFAULT '0' COMMENT '三级级-本月已结算订单数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','jd36')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   `jd36` decimal(10,2) DEFAULT '0.00' COMMENT '三级级-本月已结算预估佣金数'");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','u_w')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   UNIQUE KEY `u_w` (`uid`,`weid`)");}
if(!pdo_fieldexists('tiger_wxdaili_dlshuju','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_dlshuju')." ADD   KEY `weid` (`weid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_jdpid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `px` int(11) DEFAULT '0',
  `type` int(1) DEFAULT '0' COMMENT '状态1 已分配 ',
  `nickname` varchar(200) DEFAULT NULL COMMENT '分配昵称',
  `uid` varchar(50) DEFAULT NULL COMMENT '分配会员ID',
  `pid` varchar(250) DEFAULT NULL COMMENT '淘客PID',
  `tgwname` varchar(100) DEFAULT NULL COMMENT '推广位名称',
  `fptime` varchar(50) DEFAULT NULL COMMENT '分配时间',
  `createtime` varchar(50) DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`),
  KEY `pid` (`pid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_jdpid','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','px')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   `px` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','type')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   `type` int(1) DEFAULT '0' COMMENT '状态1 已分配 '");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','nickname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   `nickname` varchar(200) DEFAULT NULL COMMENT '分配昵称'");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','uid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   `uid` varchar(50) DEFAULT NULL COMMENT '分配会员ID'");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','pid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   `pid` varchar(250) DEFAULT NULL COMMENT '淘客PID'");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','tgwname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   `tgwname` varchar(100) DEFAULT NULL COMMENT '推广位名称'");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','fptime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   `fptime` varchar(50) DEFAULT NULL COMMENT '分配时间'");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   `createtime` varchar(50) DEFAULT NULL COMMENT '生成时间'");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   KEY `weid` (`weid`)");}
if(!pdo_fieldexists('tiger_wxdaili_jdpid','pid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_jdpid')." ADD   KEY `pid` (`pid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `ddtype` int(2) DEFAULT '0' COMMENT '订单类型，代理订单0',
  `memberid` int(11) unsigned DEFAULT NULL COMMENT 'member用户ID',
  `usernames` varchar(50) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `tel` varchar(200) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL COMMENT '自有OPENID',
  `city` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `goods_id` int(10) unsigned DEFAULT NULL,
  `orderno` varchar(50) DEFAULT NULL COMMENT '订单号',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,4) DEFAULT '0.0000',
  `level1` decimal(10,4) DEFAULT '0.0000',
  `level2` decimal(10,4) DEFAULT '0.0000',
  `level3` decimal(10,4) DEFAULT '0.0000',
  `state` int(2) DEFAULT '0' COMMENT '状态',
  `paytime` int(10) unsigned DEFAULT '0',
  `txtime` int(10) unsigned DEFAULT '0' COMMENT '提现时间',
  `paystate` int(2) DEFAULT '0' COMMENT '支付状态 0 已支付1',
  `txtype` int(2) DEFAULT '0' COMMENT '未提现 0 已提现1 审核中2',
  `msg` varchar(200) DEFAULT NULL COMMENT '如：小虎的会员费奖励',
  `cengji` int(2) unsigned DEFAULT NULL COMMENT '层级 自购 0  一级 1 二级2 三级3',
  `kuaidi` varchar(200) DEFAULT NULL,
  `ffqdtype` int(2) DEFAULT '0',
  `tzday` int(10) DEFAULT '0' COMMENT '团长支付天数',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`),
  KEY `openid` (`openid`),
  KEY `orderno` (`orderno`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_order','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_order','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `weid` int(10) unsigned NOT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','ddtype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `ddtype` int(2) DEFAULT '0' COMMENT '订单类型，代理订单0'");}
if(!pdo_fieldexists('tiger_wxdaili_order','memberid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `memberid` int(11) unsigned DEFAULT NULL COMMENT 'member用户ID'");}
if(!pdo_fieldexists('tiger_wxdaili_order','usernames')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `usernames` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','nickname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `nickname` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','avatar')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `avatar` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','tel')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `tel` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','openid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `openid` varchar(50) DEFAULT NULL COMMENT '自有OPENID'");}
if(!pdo_fieldexists('tiger_wxdaili_order','city')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `city` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','address')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `address` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','province')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `province` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','country')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `country` varchar(100) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','goods_id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `goods_id` int(10) unsigned DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','orderno')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `orderno` varchar(50) DEFAULT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('tiger_wxdaili_order','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `createtime` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_order','price')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `price` decimal(10,4) DEFAULT '0.0000'");}
if(!pdo_fieldexists('tiger_wxdaili_order','level1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `level1` decimal(10,4) DEFAULT '0.0000'");}
if(!pdo_fieldexists('tiger_wxdaili_order','level2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `level2` decimal(10,4) DEFAULT '0.0000'");}
if(!pdo_fieldexists('tiger_wxdaili_order','level3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `level3` decimal(10,4) DEFAULT '0.0000'");}
if(!pdo_fieldexists('tiger_wxdaili_order','state')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `state` int(2) DEFAULT '0' COMMENT '状态'");}
if(!pdo_fieldexists('tiger_wxdaili_order','paytime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `paytime` int(10) unsigned DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_order','txtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `txtime` int(10) unsigned DEFAULT '0' COMMENT '提现时间'");}
if(!pdo_fieldexists('tiger_wxdaili_order','paystate')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `paystate` int(2) DEFAULT '0' COMMENT '支付状态 0 已支付1'");}
if(!pdo_fieldexists('tiger_wxdaili_order','txtype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `txtype` int(2) DEFAULT '0' COMMENT '未提现 0 已提现1 审核中2'");}
if(!pdo_fieldexists('tiger_wxdaili_order','msg')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `msg` varchar(200) DEFAULT NULL COMMENT '如：小虎的会员费奖励'");}
if(!pdo_fieldexists('tiger_wxdaili_order','cengji')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `cengji` int(2) unsigned DEFAULT NULL COMMENT '层级 自购 0  一级 1 二级2 三级3'");}
if(!pdo_fieldexists('tiger_wxdaili_order','kuaidi')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `kuaidi` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_order','ffqdtype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `ffqdtype` int(2) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_order','tzday')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   `tzday` int(10) DEFAULT '0' COMMENT '团长支付天数'");}
if(!pdo_fieldexists('tiger_wxdaili_order','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('tiger_wxdaili_order','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   KEY `weid` (`weid`)");}
if(!pdo_fieldexists('tiger_wxdaili_order','openid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_order')." ADD   KEY `openid` (`openid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_pddpid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `px` int(11) DEFAULT '0',
  `type` int(1) DEFAULT '0' COMMENT '状态1 已分配 ',
  `nickname` varchar(200) DEFAULT NULL COMMENT '分配昵称',
  `uid` varchar(50) DEFAULT NULL COMMENT '分配会员ID',
  `pid` varchar(250) DEFAULT NULL COMMENT '淘客PID',
  `tgwname` varchar(100) DEFAULT NULL COMMENT '推广位名称',
  `fptime` varchar(50) DEFAULT NULL COMMENT '分配时间',
  `createtime` varchar(50) DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`),
  KEY `pid` (`pid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=200 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_pddpid','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','px')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   `px` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','type')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   `type` int(1) DEFAULT '0' COMMENT '状态1 已分配 '");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','nickname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   `nickname` varchar(200) DEFAULT NULL COMMENT '分配昵称'");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','uid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   `uid` varchar(50) DEFAULT NULL COMMENT '分配会员ID'");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','pid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   `pid` varchar(250) DEFAULT NULL COMMENT '淘客PID'");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','tgwname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   `tgwname` varchar(100) DEFAULT NULL COMMENT '推广位名称'");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','fptime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   `fptime` varchar(50) DEFAULT NULL COMMENT '分配时间'");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   `createtime` varchar(50) DEFAULT NULL COMMENT '生成时间'");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   KEY `weid` (`weid`)");}
if(!pdo_fieldexists('tiger_wxdaili_pddpid','pid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_pddpid')." ADD   KEY `pid` (`pid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_qun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `px` int(11) DEFAULT '0',
  `type` int(1) DEFAULT '0' COMMENT '状态1 开始',
  `title` varchar(200) DEFAULT NULL COMMENT '群名称',
  `keyw` varchar(200) DEFAULT NULL COMMENT '关键词',
  `picurl` varchar(250) DEFAULT NULL COMMENT '二维码',
  `xzrs` varchar(200) DEFAULT NULL COMMENT '上线人数',
  `qtype` varchar(200) DEFAULT NULL COMMENT '群类型 1微信群 QQ群2',
  `createtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`),
  KEY `keyw` (`keyw`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_qun','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_qun','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_qun','px')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   `px` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_qun','type')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   `type` int(1) DEFAULT '0' COMMENT '状态1 开始'");}
if(!pdo_fieldexists('tiger_wxdaili_qun','title')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   `title` varchar(200) DEFAULT NULL COMMENT '群名称'");}
if(!pdo_fieldexists('tiger_wxdaili_qun','keyw')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   `keyw` varchar(200) DEFAULT NULL COMMENT '关键词'");}
if(!pdo_fieldexists('tiger_wxdaili_qun','picurl')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   `picurl` varchar(250) DEFAULT NULL COMMENT '二维码'");}
if(!pdo_fieldexists('tiger_wxdaili_qun','xzrs')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   `xzrs` varchar(200) DEFAULT NULL COMMENT '上线人数'");}
if(!pdo_fieldexists('tiger_wxdaili_qun','qtype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   `qtype` varchar(200) DEFAULT NULL COMMENT '群类型 1微信群 QQ群2'");}
if(!pdo_fieldexists('tiger_wxdaili_qun','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   `createtime` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_qun','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('tiger_wxdaili_qun','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qun')." ADD   KEY `weid` (`weid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_qunmember` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `quntitle` varchar(200) DEFAULT '0',
  `qunid` int(11) DEFAULT '0' COMMENT '所属群ID',
  `openid` varchar(50) DEFAULT '0',
  `nickname` varchar(200) DEFAULT NULL COMMENT '群名称',
  `avatar` varchar(200) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `sex` varchar(50) DEFAULT NULL,
  `createtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`),
  KEY `qunid` (`qunid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_qunmember','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','quntitle')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `quntitle` varchar(200) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','qunid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `qunid` int(11) DEFAULT '0' COMMENT '所属群ID'");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','openid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `openid` varchar(50) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','nickname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `nickname` varchar(200) DEFAULT NULL COMMENT '群名称'");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','avatar')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `avatar` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','province')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `province` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','city')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `city` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','sex')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `sex` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   `createtime` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('tiger_wxdaili_qunmember','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_qunmember')." ADD   KEY `weid` (`weid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `dltype` int(11) DEFAULT '3' COMMENT '1 级 2级 3级',
  `dlname1` varchar(100) DEFAULT NULL COMMENT '一级名称',
  `dlname2` varchar(100) DEFAULT NULL COMMENT '二级名称',
  `dlname3` varchar(100) DEFAULT NULL COMMENT '三级名称',
  `dlbl1` int(11) DEFAULT NULL COMMENT '一级-自己产生佣金比率',
  `dlbl1t2` int(11) DEFAULT NULL COMMENT '一级-提取二级佣金比率',
  `dlbl1t3` int(11) DEFAULT NULL COMMENT '一级-提取三级佣金比率',
  `dlbl2` int(11) DEFAULT NULL COMMENT '二级-自己产生佣金比率',
  `dlbl2t3` int(11) DEFAULT NULL COMMENT '二级-提取三级佣金比率',
  `dlbl3` int(11) DEFAULT NULL COMMENT '三级-自己产生佣金比率',
  `dlfftype` int(11) DEFAULT '0' COMMENT '0不开启 1开启',
  `dlffprice` varchar(100) DEFAULT NULL COMMENT '付费金额',
  `fxtype` int(11) DEFAULT '0' COMMENT '0抽成模式 1普通分销',
  `ddtype` int(11) DEFAULT '0' COMMENT '0全显示 1显示一部分',
  `seartype` int(11) DEFAULT '0' COMMENT '超级搜0显示 1不显示',
  `dlzbtype` int(11) DEFAULT '0' COMMENT '直播 1显示',
  `fzname` varchar(100) DEFAULT NULL COMMENT '分站名称',
  `level1` varchar(50) DEFAULT NULL COMMENT '代理付费一级奖励',
  `level2` varchar(50) DEFAULT NULL COMMENT '代理付费二级奖励',
  `level3` varchar(50) DEFAULT NULL COMMENT '代理付费三级奖励',
  `glevel1` varchar(50) DEFAULT NULL COMMENT '代理付费固定一级奖励',
  `glevel2` varchar(50) DEFAULT NULL COMMENT '代理付费固定二级奖励',
  `glevel3` varchar(50) DEFAULT NULL COMMENT '代理付费固定三级奖励',
  `dlkcbl` varchar(30) DEFAULT NULL COMMENT '扣除佣金',
  `dlyjfltype` int(3) DEFAULT '0' COMMENT '提交订单是示开启返二级 0 不开启 1开启',
  `dlfxtype` int(11) DEFAULT '0' COMMENT '代理商是否支持提交订单反现 0 支持 1 不支持',
  `zfmsg0` varchar(1000) DEFAULT NULL COMMENT '支付提醒',
  `zfmsg1` varchar(1000) DEFAULT NULL COMMENT '一级支付提醒',
  `zfmsg2` varchar(1000) DEFAULT NULL COMMENT '二级支付提醒',
  `zfmsg3` varchar(1000) DEFAULT NULL COMMENT '三级支付提醒',
  `tztype` int(11) DEFAULT '0' COMMENT '1开启',
  PRIMARY KEY (`id`),
  KEY `idx_weid` (`weid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_set','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_set','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dltype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dltype` int(11) DEFAULT '3' COMMENT '1 级 2级 3级'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlname1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlname1` varchar(100) DEFAULT NULL COMMENT '一级名称'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlname2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlname2` varchar(100) DEFAULT NULL COMMENT '二级名称'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlname3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlname3` varchar(100) DEFAULT NULL COMMENT '三级名称'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlbl1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlbl1` int(11) DEFAULT NULL COMMENT '一级-自己产生佣金比率'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlbl1t2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlbl1t2` int(11) DEFAULT NULL COMMENT '一级-提取二级佣金比率'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlbl1t3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlbl1t3` int(11) DEFAULT NULL COMMENT '一级-提取三级佣金比率'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlbl2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlbl2` int(11) DEFAULT NULL COMMENT '二级-自己产生佣金比率'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlbl2t3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlbl2t3` int(11) DEFAULT NULL COMMENT '二级-提取三级佣金比率'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlbl3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlbl3` int(11) DEFAULT NULL COMMENT '三级-自己产生佣金比率'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlfftype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlfftype` int(11) DEFAULT '0' COMMENT '0不开启 1开启'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlffprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlffprice` varchar(100) DEFAULT NULL COMMENT '付费金额'");}
if(!pdo_fieldexists('tiger_wxdaili_set','fxtype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `fxtype` int(11) DEFAULT '0' COMMENT '0抽成模式 1普通分销'");}
if(!pdo_fieldexists('tiger_wxdaili_set','ddtype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `ddtype` int(11) DEFAULT '0' COMMENT '0全显示 1显示一部分'");}
if(!pdo_fieldexists('tiger_wxdaili_set','seartype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `seartype` int(11) DEFAULT '0' COMMENT '超级搜0显示 1不显示'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlzbtype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlzbtype` int(11) DEFAULT '0' COMMENT '直播 1显示'");}
if(!pdo_fieldexists('tiger_wxdaili_set','fzname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `fzname` varchar(100) DEFAULT NULL COMMENT '分站名称'");}
if(!pdo_fieldexists('tiger_wxdaili_set','level1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `level1` varchar(50) DEFAULT NULL COMMENT '代理付费一级奖励'");}
if(!pdo_fieldexists('tiger_wxdaili_set','level2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `level2` varchar(50) DEFAULT NULL COMMENT '代理付费二级奖励'");}
if(!pdo_fieldexists('tiger_wxdaili_set','level3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `level3` varchar(50) DEFAULT NULL COMMENT '代理付费三级奖励'");}
if(!pdo_fieldexists('tiger_wxdaili_set','glevel1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `glevel1` varchar(50) DEFAULT NULL COMMENT '代理付费固定一级奖励'");}
if(!pdo_fieldexists('tiger_wxdaili_set','glevel2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `glevel2` varchar(50) DEFAULT NULL COMMENT '代理付费固定二级奖励'");}
if(!pdo_fieldexists('tiger_wxdaili_set','glevel3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `glevel3` varchar(50) DEFAULT NULL COMMENT '代理付费固定三级奖励'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlkcbl')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlkcbl` varchar(30) DEFAULT NULL COMMENT '扣除佣金'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlyjfltype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlyjfltype` int(3) DEFAULT '0' COMMENT '提交订单是示开启返二级 0 不开启 1开启'");}
if(!pdo_fieldexists('tiger_wxdaili_set','dlfxtype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `dlfxtype` int(11) DEFAULT '0' COMMENT '代理商是否支持提交订单反现 0 支持 1 不支持'");}
if(!pdo_fieldexists('tiger_wxdaili_set','zfmsg0')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `zfmsg0` varchar(1000) DEFAULT NULL COMMENT '支付提醒'");}
if(!pdo_fieldexists('tiger_wxdaili_set','zfmsg1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `zfmsg1` varchar(1000) DEFAULT NULL COMMENT '一级支付提醒'");}
if(!pdo_fieldexists('tiger_wxdaili_set','zfmsg2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `zfmsg2` varchar(1000) DEFAULT NULL COMMENT '二级支付提醒'");}
if(!pdo_fieldexists('tiger_wxdaili_set','zfmsg3')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `zfmsg3` varchar(1000) DEFAULT NULL COMMENT '三级支付提醒'");}
if(!pdo_fieldexists('tiger_wxdaili_set','tztype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   `tztype` int(11) DEFAULT '0' COMMENT '1开启'");}
if(!pdo_fieldexists('tiger_wxdaili_set','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_set')." ADD   PRIMARY KEY (`id`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_tkpid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `px` int(11) DEFAULT '0',
  `type` int(1) DEFAULT '0' COMMENT '状态1 已分配 ',
  `nickname` varchar(200) DEFAULT NULL COMMENT '分配昵称',
  `uid` varchar(50) DEFAULT NULL COMMENT '分配会员ID',
  `pid` varchar(250) DEFAULT NULL COMMENT '淘客PID',
  `tgwname` varchar(100) DEFAULT NULL COMMENT '推广位名称',
  `fptime` varchar(50) DEFAULT NULL COMMENT '分配时间',
  `createtime` varchar(50) DEFAULT NULL COMMENT '生成时间',
  `tbuid` varchar(20) DEFAULT '0' COMMENT '淘宝ID',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`),
  KEY `pid` (`pid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=193 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_tkpid','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','px')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `px` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','type')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `type` int(1) DEFAULT '0' COMMENT '状态1 已分配 '");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','nickname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `nickname` varchar(200) DEFAULT NULL COMMENT '分配昵称'");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','uid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `uid` varchar(50) DEFAULT NULL COMMENT '分配会员ID'");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','pid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `pid` varchar(250) DEFAULT NULL COMMENT '淘客PID'");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','tgwname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `tgwname` varchar(100) DEFAULT NULL COMMENT '推广位名称'");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','fptime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `fptime` varchar(50) DEFAULT NULL COMMENT '分配时间'");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `createtime` varchar(50) DEFAULT NULL COMMENT '生成时间'");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','tbuid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   `tbuid` varchar(20) DEFAULT '0' COMMENT '淘宝ID'");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   KEY `weid` (`weid`)");}
if(!pdo_fieldexists('tiger_wxdaili_tkpid','pid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tkpid')." ADD   KEY `pid` (`pid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_txlog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL COMMENT '微信用户昵称',
  `openid` varchar(255) DEFAULT NULL COMMENT '微信用户openid',
  `avatar` varchar(255) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL COMMENT '打款时间',
  `credit1` int(11) DEFAULT NULL COMMENT '消耗积分',
  `credit2` varchar(100) DEFAULT NULL COMMENT '金额，分为单位',
  `zfbuid` varchar(100) DEFAULT NULL COMMENT '支付宝帐号',
  `dmch_billno` varchar(50) DEFAULT NULL COMMENT '生成的商户订单号',
  `sh` tinyint(1) DEFAULT '0' COMMENT '是否打款成功 0未审核 1已审核',
  `dresult` varchar(255) DEFAULT NULL COMMENT '失败提示',
  `createtime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_txlog','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `weid` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','nickname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `nickname` varchar(255) DEFAULT NULL COMMENT '微信用户昵称'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','openid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `openid` varchar(255) DEFAULT NULL COMMENT '微信用户openid'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','avatar')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `avatar` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','addtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `addtime` int(11) DEFAULT NULL COMMENT '打款时间'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','credit1')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `credit1` int(11) DEFAULT NULL COMMENT '消耗积分'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','credit2')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `credit2` varchar(100) DEFAULT NULL COMMENT '金额，分为单位'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','zfbuid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `zfbuid` varchar(100) DEFAULT NULL COMMENT '支付宝帐号'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','dmch_billno')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `dmch_billno` varchar(50) DEFAULT NULL COMMENT '生成的商户订单号'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','sh')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `sh` tinyint(1) DEFAULT '0' COMMENT '是否打款成功 0未审核 1已审核'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','dresult')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `dresult` varchar(255) DEFAULT NULL COMMENT '失败提示'");}
if(!pdo_fieldexists('tiger_wxdaili_txlog','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_txlog')." ADD   `createtime` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_tzyjlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0' COMMENT 'share表用户ID',
  `month` int(11) DEFAULT '0' COMMENT '结算月份 201701',
  `nickname` varchar(100) DEFAULT NULL COMMENT '粉丝昵称',
  `openid` varchar(100) DEFAULT NULL COMMENT '粉丝OPENID',
  `msg` varchar(100) DEFAULT NULL COMMENT '如：数据更新时间：2017-3-21',
  `tbbyfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '本月付款',
  `tbsyjsprice` decimal(10,2) DEFAULT '0.00' COMMENT '上月结算',
  `tbjrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '今日付款',
  `tbzrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '昨日付款',
  `pddbyfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '本月付款',
  `pddsyjsprice` decimal(10,2) DEFAULT '0.00' COMMENT '上月结算',
  `pddjrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '今日付款',
  `pddzrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '昨日付款',
  `jdbyfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '本月付款',
  `jdsyjsprice` decimal(10,2) DEFAULT '0.00' COMMENT '上月结算',
  `jdjrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '今日付款',
  `jdzrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '昨日付款',
  `createtime` int(14) NOT NULL,
  `jstype` int(2) DEFAULT '0' COMMENT '1已经结算',
  `jstime` int(10) DEFAULT '0' COMMENT '结算时间',
  `tbjsrmb` decimal(10,2) DEFAULT '0.00' COMMENT '淘宝结算金额',
  `pddjsrmb` decimal(10,2) DEFAULT '0.00' COMMENT '拼多多结算金额',
  `jdjsrmb` decimal(10,2) DEFAULT '0.00' COMMENT '京东结算金额',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_month` (`uid`,`month`),
  KEY `weid` (`weid`),
  KEY `uid` (`uid`),
  KEY `month` (`month`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','type')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `type` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','uid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `uid` int(11) DEFAULT '0' COMMENT 'share表用户ID'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','month')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `month` int(11) DEFAULT '0' COMMENT '结算月份 201701'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','nickname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `nickname` varchar(100) DEFAULT NULL COMMENT '粉丝昵称'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','openid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT '粉丝OPENID'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','msg')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `msg` varchar(100) DEFAULT NULL COMMENT '如：数据更新时间：2017-3-21'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','tbbyfkprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `tbbyfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '本月付款'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','tbsyjsprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `tbsyjsprice` decimal(10,2) DEFAULT '0.00' COMMENT '上月结算'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','tbjrfkprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `tbjrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '今日付款'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','tbzrfkprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `tbzrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '昨日付款'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','pddbyfkprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `pddbyfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '本月付款'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','pddsyjsprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `pddsyjsprice` decimal(10,2) DEFAULT '0.00' COMMENT '上月结算'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','pddjrfkprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `pddjrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '今日付款'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','pddzrfkprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `pddzrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '昨日付款'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','jdbyfkprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `jdbyfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '本月付款'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','jdsyjsprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `jdsyjsprice` decimal(10,2) DEFAULT '0.00' COMMENT '上月结算'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','jdjrfkprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `jdjrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '今日付款'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','jdzrfkprice')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `jdzrfkprice` decimal(10,2) DEFAULT '0.00' COMMENT '昨日付款'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `createtime` int(14) NOT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','jstype')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `jstype` int(2) DEFAULT '0' COMMENT '1已经结算'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','jstime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `jstime` int(10) DEFAULT '0' COMMENT '结算时间'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','tbjsrmb')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `tbjsrmb` decimal(10,2) DEFAULT '0.00' COMMENT '淘宝结算金额'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','pddjsrmb')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `pddjsrmb` decimal(10,2) DEFAULT '0.00' COMMENT '拼多多结算金额'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','jdjsrmb')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   `jdjsrmb` decimal(10,2) DEFAULT '0.00' COMMENT '京东结算金额'");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','uid_month')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   UNIQUE KEY `uid_month` (`uid`,`month`)");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   KEY `weid` (`weid`)");}
if(!pdo_fieldexists('tiger_wxdaili_tzyjlog','uid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_tzyjlog')." ADD   KEY `uid` (`uid`)");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_tiger_wxdaili_yjlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0' COMMENT 'share表ID',
  `month` varchar(20) DEFAULT NULL COMMENT '结算月份',
  `memberid` int(11) unsigned DEFAULT NULL COMMENT 'member用户ID',
  `nickname` varchar(100) DEFAULT NULL COMMENT '粉丝昵称',
  `openid` varchar(100) DEFAULT NULL COMMENT '粉丝OPENID',
  `msg` varchar(100) DEFAULT NULL COMMENT '如：2017年2月份佣金，自动结算时间：2017-3-21',
  `price` varchar(20) DEFAULT NULL COMMENT '提现佣金余额',
  `createtime` int(14) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid_createtime` (`openid`,`createtime`),
  KEY `weid` (`weid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('tiger_wxdaili_yjlog','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','weid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `weid` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','type')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `type` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','uid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `uid` int(11) DEFAULT '0' COMMENT 'share表ID'");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','month')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `month` varchar(20) DEFAULT NULL COMMENT '结算月份'");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','memberid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `memberid` int(11) unsigned DEFAULT NULL COMMENT 'member用户ID'");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','nickname')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `nickname` varchar(100) DEFAULT NULL COMMENT '粉丝昵称'");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','openid')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `openid` varchar(100) DEFAULT NULL COMMENT '粉丝OPENID'");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','msg')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `msg` varchar(100) DEFAULT NULL COMMENT '如：2017年2月份佣金，自动结算时间：2017-3-21'");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','price')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `price` varchar(20) DEFAULT NULL COMMENT '提现佣金余额'");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   `createtime` int(14) NOT NULL");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','id')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   PRIMARY KEY (`id`)");}
if(!pdo_fieldexists('tiger_wxdaili_yjlog','openid_createtime')) {pdo_query("ALTER TABLE ".tablename('tiger_wxdaili_yjlog')." ADD   UNIQUE KEY `openid_createtime` (`openid`,`createtime`)");}
