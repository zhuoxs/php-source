<?php 
pdo_query("CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_case` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`weid` int(11),
`cid` int(11)    COMMENT '分类',
`pid` int(11)    COMMENT '排序',
`name` varchar(500)    COMMENT '名字',
`pic` varchar(500)    COMMENT '图片',
`url` varchar(500)    COMMENT '链接',
`info` varchar(500)    COMMENT '简介',
`iscom` int(11)    COMMENT '是否推荐',
`ishot` int(11)    COMMENT '是否热门',
`pv` int(11)    COMMENT '流量数',
`content` text(),
`dateline` int(10)    COMMENT '添加时间',
`status` tinyint(1)  DEFAULT NULL DEFAULT '1'  COMMENT '是否显示前台1显示0不显示',
`detail` varchar(255) NOT NULL   COMMENT '简介',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_classification` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`classificationName` varchar(500)    COMMENT '分类名',
`fatherclass` varchar(11),
`img` varchar(255)    COMMENT '分类图片',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_config` (
`key` varchar(100) NOT NULL   COMMENT '配置名称',
`value` varchar(100)    COMMENT '配置变量',
PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ims_gengkuai_dg_config` (`key`, `value`) VALUES
('template_name', 'webapp');
CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_fatherclass` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`fatherclassName` varchar(500)    COMMENT '父分类名',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ims_gengkuai_dg_fatherclass` (`id`, `fatherclassName`) VALUES
(1, '新闻'),
(2, '产品'),
(3, '案例');
CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_goods` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`weid` int(11),
`cid` int(11)    COMMENT '分类',
`pid` int(11)    COMMENT '排序',
`name` varchar(500)    COMMENT '名字',
`cj` varchar(500)    COMMENT '实用场景',
`dp` varchar(500)    COMMENT '模块搭配',
`iscom` int(11)    COMMENT '是否推荐',
`ishot` int(11)    COMMENT '是否热门',
`pv` int(11)    COMMENT '流量数',
`pic` varchar(500)    COMMENT '图片',
`goodspic` varchar(500)    COMMENT '产品图片',
`info` varchar(500)    COMMENT '简介',
`content` text(),
`dateline` int(10)    COMMENT '添加时间',
`status` tinyint(1)  DEFAULT NULL DEFAULT '1'  COMMENT '是否显示前台1显示0不显示',
`color` varchar(50) NOT NULL   COMMENT '产品背景颜色',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_link` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`weid` int(11),
`cid` int(11)    COMMENT '分类',
`name` varchar(500)    COMMENT '名字',
`url` varchar(500)    COMMENT '链接',
`pic` varchar(500)    COMMENT '图片',
`iscom` int(11)    COMMENT '是否推荐',
`ishot` int(11)    COMMENT '是否热门',
`content` text(),
`dateline` int(10)    COMMENT '添加时间',
`status` tinyint(1)  DEFAULT NULL DEFAULT '1'  COMMENT '是否显示前台1显示0不显示',
`sort` int(10)    COMMENT '排序',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_news` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`weid` int(11),
`cid` int(11)    COMMENT '分类',
`pid` int(11)    COMMENT '排序',
`name` varchar(500)    COMMENT '名字',
`iscom` int(11)    COMMENT '是否推荐',
`ishot` int(11)    COMMENT '是否热门',
`pv` int(11)    COMMENT '流量数',
`pic` varchar(500)    COMMENT '图片',
`info` varchar(500)    COMMENT '简介',
`content` text(),
`dateline` int(10)    COMMENT '添加时间',
`status` tinyint(1)  DEFAULT NULL DEFAULT '1'  COMMENT '是否显示前台1显示0不显示',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_people` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`name` varchar(100)    COMMENT '姓名',
`head_portrait` varchar(500)    COMMENT '头像',
`position` varchar(500)    COMMENT '职位',
`detail` varchar(500)    COMMENT '简介',
`reserve_1` varchar(500)    COMMENT '预留字段1',
`reserve_2` varchar(500)    COMMENT '预留字段2',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_reply` (
`weid` int(11),
`value` text(),
`key` varchar(500),
PRIMARY KEY (``)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_gengkuai_dg_url_setting` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`a` varchar(100) NOT NULL   COMMENT '域名',
`b` varchar(100) NOT NULL   COMMENT '跳转平台id',
`c` varchar(100) NOT NULL   COMMENT '备注',
`d` varchar(100) NOT NULL   COMMENT '预留',
`type` tinyint(1) NOT NULL   COMMENT '设置类型：1：访问地址。2：跳转地址',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'id')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'weid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `weid` int(11);");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `cid` int(11)    COMMENT '分类';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `pid` int(11)    COMMENT '排序';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'name')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `name` varchar(500)    COMMENT '名字';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'pic')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `pic` varchar(500)    COMMENT '图片';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'url')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `url` varchar(500)    COMMENT '链接';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'info')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `info` varchar(500)    COMMENT '简介';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'iscom')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `iscom` int(11)    COMMENT '是否推荐';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'ishot')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `ishot` int(11)    COMMENT '是否热门';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'pv')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `pv` int(11)    COMMENT '流量数';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'content')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `content` text();");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'dateline')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `dateline` int(10)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'status')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `status` tinyint(1)  DEFAULT NULL DEFAULT '1'  COMMENT '是否显示前台1显示0不显示';");
 }
}
if(pdo_tableexists('gengkuai_dg_case')) {
 if(!pdo_fieldexists('gengkuai_dg_case',  'detail')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_case')." ADD `detail` varchar(255) NOT NULL   COMMENT '简介';");
 }
}
if(pdo_tableexists('gengkuai_dg_classification')) {
 if(!pdo_fieldexists('gengkuai_dg_classification',  'id')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_classification')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('gengkuai_dg_classification')) {
 if(!pdo_fieldexists('gengkuai_dg_classification',  'classificationName')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_classification')." ADD `classificationName` varchar(500)    COMMENT '分类名';");
 }
}
if(pdo_tableexists('gengkuai_dg_classification')) {
 if(!pdo_fieldexists('gengkuai_dg_classification',  'fatherclass')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_classification')." ADD `fatherclass` varchar(11);");
 }
}
if(pdo_tableexists('gengkuai_dg_classification')) {
 if(!pdo_fieldexists('gengkuai_dg_classification',  'img')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_classification')." ADD `img` varchar(255)    COMMENT '分类图片';");
 }
}
if(pdo_tableexists('gengkuai_dg_config')) {
 if(!pdo_fieldexists('gengkuai_dg_config',  'key')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_config')." ADD `key` varchar(100) NOT NULL   COMMENT '配置名称';");
 }
}
if(pdo_tableexists('gengkuai_dg_config')) {
 if(!pdo_fieldexists('gengkuai_dg_config',  'value')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_config')." ADD `value` varchar(100)    COMMENT '配置变量';");
 }
}
if(pdo_tableexists('gengkuai_dg_fatherclass')) {
 if(!pdo_fieldexists('gengkuai_dg_fatherclass',  'id')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_fatherclass')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('gengkuai_dg_fatherclass')) {
 if(!pdo_fieldexists('gengkuai_dg_fatherclass',  'fatherclassName')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_fatherclass')." ADD `fatherclassName` varchar(500)    COMMENT '父分类名';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'id')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'weid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `weid` int(11);");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `cid` int(11)    COMMENT '分类';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `pid` int(11)    COMMENT '排序';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'name')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `name` varchar(500)    COMMENT '名字';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'cj')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `cj` varchar(500)    COMMENT '实用场景';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'dp')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `dp` varchar(500)    COMMENT '模块搭配';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'iscom')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `iscom` int(11)    COMMENT '是否推荐';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'ishot')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `ishot` int(11)    COMMENT '是否热门';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'pv')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `pv` int(11)    COMMENT '流量数';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'pic')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `pic` varchar(500)    COMMENT '图片';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'goodspic')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `goodspic` varchar(500)    COMMENT '产品图片';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'info')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `info` varchar(500)    COMMENT '简介';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'content')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `content` text();");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'dateline')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `dateline` int(10)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'status')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `status` tinyint(1)  DEFAULT NULL DEFAULT '1'  COMMENT '是否显示前台1显示0不显示';");
 }
}
if(pdo_tableexists('gengkuai_dg_goods')) {
 if(!pdo_fieldexists('gengkuai_dg_goods',  'color')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_goods')." ADD `color` varchar(50) NOT NULL   COMMENT '产品背景颜色';");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'id')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'weid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `weid` int(11);");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `cid` int(11)    COMMENT '分类';");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'name')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `name` varchar(500)    COMMENT '名字';");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'url')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `url` varchar(500)    COMMENT '链接';");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'pic')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `pic` varchar(500)    COMMENT '图片';");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'iscom')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `iscom` int(11)    COMMENT '是否推荐';");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'ishot')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `ishot` int(11)    COMMENT '是否热门';");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'content')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `content` text();");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'dateline')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `dateline` int(10)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'status')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `status` tinyint(1)  DEFAULT NULL DEFAULT '1'  COMMENT '是否显示前台1显示0不显示';");
 }
}
if(pdo_tableexists('gengkuai_dg_link')) {
 if(!pdo_fieldexists('gengkuai_dg_link',  'sort')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_link')." ADD `sort` int(10)    COMMENT '排序';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'id')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'weid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `weid` int(11);");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `cid` int(11)    COMMENT '分类';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `pid` int(11)    COMMENT '排序';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'name')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `name` varchar(500)    COMMENT '名字';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'iscom')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `iscom` int(11)    COMMENT '是否推荐';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'ishot')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `ishot` int(11)    COMMENT '是否热门';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'pv')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `pv` int(11)    COMMENT '流量数';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'pic')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `pic` varchar(500)    COMMENT '图片';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'info')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `info` varchar(500)    COMMENT '简介';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'content')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `content` text();");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'dateline')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `dateline` int(10)    COMMENT '添加时间';");
 }
}
if(pdo_tableexists('gengkuai_dg_news')) {
 if(!pdo_fieldexists('gengkuai_dg_news',  'status')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_news')." ADD `status` tinyint(1)  DEFAULT NULL DEFAULT '1'  COMMENT '是否显示前台1显示0不显示';");
 }
}
if(pdo_tableexists('gengkuai_dg_people')) {
 if(!pdo_fieldexists('gengkuai_dg_people',  'id')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_people')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('gengkuai_dg_people')) {
 if(!pdo_fieldexists('gengkuai_dg_people',  'name')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_people')." ADD `name` varchar(100)    COMMENT '姓名';");
 }
}
if(pdo_tableexists('gengkuai_dg_people')) {
 if(!pdo_fieldexists('gengkuai_dg_people',  'head_portrait')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_people')." ADD `head_portrait` varchar(500)    COMMENT '头像';");
 }
}
if(pdo_tableexists('gengkuai_dg_people')) {
 if(!pdo_fieldexists('gengkuai_dg_people',  'position')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_people')." ADD `position` varchar(500)    COMMENT '职位';");
 }
}
if(pdo_tableexists('gengkuai_dg_people')) {
 if(!pdo_fieldexists('gengkuai_dg_people',  'detail')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_people')." ADD `detail` varchar(500)    COMMENT '简介';");
 }
}
if(pdo_tableexists('gengkuai_dg_people')) {
 if(!pdo_fieldexists('gengkuai_dg_people',  'reserve_1')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_people')." ADD `reserve_1` varchar(500)    COMMENT '预留字段1';");
 }
}
if(pdo_tableexists('gengkuai_dg_people')) {
 if(!pdo_fieldexists('gengkuai_dg_people',  'reserve_2')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_people')." ADD `reserve_2` varchar(500)    COMMENT '预留字段2';");
 }
}
if(pdo_tableexists('gengkuai_dg_reply')) {
 if(!pdo_fieldexists('gengkuai_dg_reply',  'weid')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_reply')." ADD `weid` int(11);");
 }
}
if(pdo_tableexists('gengkuai_dg_reply')) {
 if(!pdo_fieldexists('gengkuai_dg_reply',  'value')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_reply')." ADD `value` text();");
 }
}
if(pdo_tableexists('gengkuai_dg_reply')) {
 if(!pdo_fieldexists('gengkuai_dg_reply',  'key')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_reply')." ADD `key` varchar(500);");
 }
}
if(pdo_tableexists('gengkuai_dg_url_setting')) {
 if(!pdo_fieldexists('gengkuai_dg_url_setting',  'id')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_url_setting')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('gengkuai_dg_url_setting')) {
 if(!pdo_fieldexists('gengkuai_dg_url_setting',  'a')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_url_setting')." ADD `a` varchar(100) NOT NULL   COMMENT '域名';");
 }
}
if(pdo_tableexists('gengkuai_dg_url_setting')) {
 if(!pdo_fieldexists('gengkuai_dg_url_setting',  'b')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_url_setting')." ADD `b` varchar(100) NOT NULL   COMMENT '跳转平台id';");
 }
}
if(pdo_tableexists('gengkuai_dg_url_setting')) {
 if(!pdo_fieldexists('gengkuai_dg_url_setting',  'c')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_url_setting')." ADD `c` varchar(100) NOT NULL   COMMENT '备注';");
 }
}
if(pdo_tableexists('gengkuai_dg_url_setting')) {
 if(!pdo_fieldexists('gengkuai_dg_url_setting',  'd')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_url_setting')." ADD `d` varchar(100) NOT NULL   COMMENT '预留';");
 }
}
if(pdo_tableexists('gengkuai_dg_url_setting')) {
 if(!pdo_fieldexists('gengkuai_dg_url_setting',  'type')) {
  pdo_query("ALTER TABLE ".tablename('gengkuai_dg_url_setting')." ADD `type` tinyint(1) NOT NULL   COMMENT '设置类型：1：访问地址。2：跳转地址';");
 }
}
