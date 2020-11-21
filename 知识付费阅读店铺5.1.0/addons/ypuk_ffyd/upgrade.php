<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` varchar(50) DEFAULT 'text',
  `price` float(10,2) DEFAULT '0.00',
  `catid` int(10) NOT NULL,
  `thumb` text,
  `recommend` int(1) DEFAULT '0',
  `intro` varchar(1000) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  `viewnum` int(10) DEFAULT '0',
  `favnum` int(10) DEFAULT '0',
  `viewnum_min` int(10) NOT NULL DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `sort` int(3) DEFAULT '999',
  `copytext` text NOT NULL,
  `distribution_commission` varchar(100) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_article','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_article','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `weid` int(11) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_article','title')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `title` varchar(200) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_article','type')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `type` varchar(50) DEFAULT 'text'");}
if(!pdo_fieldexists('ypuk_ffyd_article','price')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `price` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('ypuk_ffyd_article','catid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `catid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_article','thumb')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `thumb` text");}
if(!pdo_fieldexists('ypuk_ffyd_article','recommend')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `recommend` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_article','intro')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `intro` varchar(1000) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_article','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `createtime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_article','viewnum')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `viewnum` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_article','favnum')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `favnum` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_article','viewnum_min')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `viewnum_min` int(10) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_article','status')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `status` int(1) DEFAULT '1'");}
if(!pdo_fieldexists('ypuk_ffyd_article','sort')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `sort` int(3) DEFAULT '999'");}
if(!pdo_fieldexists('ypuk_ffyd_article','copytext')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `copytext` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_article','distribution_commission')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_article')." ADD   `distribution_commission` varchar(100) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_audio_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `audio` text NOT NULL,
  `preview_audio` text NOT NULL,
  `text` text NOT NULL,
  `audiotime` varchar(50) DEFAULT '00.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_audio_content','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_audio_content')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_audio_content','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_audio_content')." ADD   `weid` int(11) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_audio_content','articleid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_audio_content')." ADD   `articleid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_audio_content','audio')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_audio_content')." ADD   `audio` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_audio_content','preview_audio')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_audio_content')." ADD   `preview_audio` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_audio_content','text')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_audio_content')." ADD   `text` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_audio_content','audiotime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_audio_content')." ADD   `audiotime` varchar(50) DEFAULT '00.00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目id',
  `weid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_category','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_category')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_category','parentid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_category')." ADD   `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目id'");}
if(!pdo_fieldexists('ypuk_ffyd_category','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_category')." ADD   `weid` int(11) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_category','name')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_category')." ADD   `name` varchar(30) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_category','icon')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_category')." ADD   `icon` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_category','enabled')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_category')." ADD   `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `articleid` int(10) NOT NULL,
  `content` text NOT NULL,
  `createtime` varchar(100) NOT NULL,
  `status` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_comment','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_comment')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_comment','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_comment')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_comment','uid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_comment')." ADD   `uid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_comment','articleid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_comment')." ADD   `articleid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_comment','content')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_comment')." ADD   `content` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_comment','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_comment')." ADD   `createtime` varchar(100) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_comment','status')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_comment')." ADD   `status` int(1) DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_distribution_userbind` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `createtime` int(10) DEFAULT '0',
  `weid` int(10) NOT NULL,
  `topuid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_distribution_userbind','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_distribution_userbind')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_distribution_userbind','uid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_distribution_userbind')." ADD   `uid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_distribution_userbind','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_distribution_userbind')." ADD   `createtime` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_distribution_userbind','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_distribution_userbind')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_distribution_userbind','topuid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_distribution_userbind')." ADD   `topuid` int(10) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_favlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_favlog','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_favlog')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_favlog','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_favlog')." ADD   `weid` int(11) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_favlog','articleid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_favlog')." ADD   `articleid` int(11) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_favlog','uid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_favlog')." ADD   `uid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_formid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `openid` varchar(200) DEFAULT NULL,
  `formid` varchar(255) NOT NULL,
  `aid` varchar(50) NOT NULL,
  `createtime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_formid','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_formid')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_formid','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_formid')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_formid','openid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_formid')." ADD   `openid` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_formid','formid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_formid')." ADD   `formid` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_formid','aid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_formid')." ADD   `aid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_formid','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_formid')." ADD   `createtime` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `intro` text NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `price` float(10,2) DEFAULT '0.00',
  `status` int(1) DEFAULT '1',
  `buynum` int(10) DEFAULT '0',
  `buynum_min` int(10) DEFAULT '0',
  `recommend` int(1) DEFAULT '0',
  `createtime` varchar(255) NOT NULL,
  `distribution_commission` varchar(100) DEFAULT '0',
  `sort` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_package','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_package','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package','title')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `title` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package','intro')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `intro` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package','thumb')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package','content')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `content` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package','price')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `price` float(10,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('ypuk_ffyd_package','status')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `status` int(1) DEFAULT '1'");}
if(!pdo_fieldexists('ypuk_ffyd_package','buynum')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `buynum` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_package','buynum_min')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `buynum_min` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_package','recommend')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `recommend` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_package','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `createtime` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package','distribution_commission')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `distribution_commission` varchar(100) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_package','sort')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package')." ADD   `sort` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_package_bind` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `articleid` int(10) NOT NULL,
  `sort` int(3) DEFAULT '999',
  `createtime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_package_bind','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_bind')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_package_bind','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_bind')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_bind','pid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_bind')." ADD   `pid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_bind','articleid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_bind')." ADD   `articleid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_bind','sort')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_bind')." ADD   `sort` int(3) DEFAULT '999'");}
if(!pdo_fieldexists('ypuk_ffyd_package_bind','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_bind')." ADD   `createtime` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_package_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `codeaccount` varchar(255) NOT NULL,
  `codepwd` varchar(255) NOT NULL,
  `createtime` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT '0未使用 1已使用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_package_code','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_code')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_package_code','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_code')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_code','pid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_code')." ADD   `pid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_code','codeaccount')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_code')." ADD   `codeaccount` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_code','codepwd')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_code')." ADD   `codepwd` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_code','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_code')." ADD   `createtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_code','status')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_code')." ADD   `status` int(1) DEFAULT '0' COMMENT '0未使用 1已使用'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_package_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `weid` int(10) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_package_record','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_record')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_package_record','pid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_record')." ADD   `pid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_record','uid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_record')." ADD   `uid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_record','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_record')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_record','price')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_record')." ADD   `price` float(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_package_record','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_package_record')." ADD   `createtime` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_pdf_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `pdffile` varchar(260) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_pdf_content','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_pdf_content')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_pdf_content','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_pdf_content')." ADD   `weid` int(11) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_pdf_content','articleid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_pdf_content')." ADD   `articleid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_pdf_content','pdffile')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_pdf_content')." ADD   `pdffile` varchar(260) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_pic_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `piclist` text NOT NULL,
  `preview_number` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_pic_content','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_pic_content')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_pic_content','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_pic_content')." ADD   `weid` int(11) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_pic_content','articleid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_pic_content')." ADD   `articleid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_pic_content','piclist')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_pic_content')." ADD   `piclist` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_pic_content','preview_number')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_pic_content')." ADD   `preview_number` int(3) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `articleid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `weid` int(10) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_record','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_record')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_record','articleid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_record')." ADD   `articleid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_record','uid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_record')." ADD   `uid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_record','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_record')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_record','price')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_record')." ADD   `price` float(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_record','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_record')." ADD   `createtime` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `rooturl` varchar(200) DEFAULT NULL,
  `openkefu` int(1) DEFAULT '0',
  `kefutype` int(1) DEFAULT '0',
  `navtype` int(1) DEFAULT '1',
  `kefuqr` varchar(255) NOT NULL,
  `success_template_id` varchar(255) NOT NULL,
  `swiper` text NOT NULL,
  `index_new_text` varchar(255) NOT NULL,
  `index_view_text` varchar(255) NOT NULL,
  `opendistribution` int(1) DEFAULT '0',
  `user_withdraw_open` int(1) DEFAULT '0',
  `user_withdraw_charge` varchar(100) DEFAULT '0.006',
  `user_withdraw_type` int(1) DEFAULT '0',
  `help_examine_open` int(1) DEFAULT '0',
  `help_examine_index` text NOT NULL,
  `help_examine_package` text NOT NULL,
  `help_examine_my` text NOT NULL,
  `openposter` int(1) DEFAULT '0' COMMENT '0关闭 1开启',
  `poster_bg` text NOT NULL,
  `open_package_activation` int(1) DEFAULT '0' COMMENT '0关闭 1开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_setting','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_setting','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','rooturl')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `rooturl` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','openkefu')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `openkefu` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_setting','kefutype')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `kefutype` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_setting','navtype')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `navtype` int(1) DEFAULT '1'");}
if(!pdo_fieldexists('ypuk_ffyd_setting','kefuqr')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `kefuqr` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','success_template_id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `success_template_id` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','swiper')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `swiper` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','index_new_text')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `index_new_text` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','index_view_text')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `index_view_text` varchar(255) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','opendistribution')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `opendistribution` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_setting','user_withdraw_open')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `user_withdraw_open` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_setting','user_withdraw_charge')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `user_withdraw_charge` varchar(100) DEFAULT '0.006'");}
if(!pdo_fieldexists('ypuk_ffyd_setting','user_withdraw_type')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `user_withdraw_type` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_setting','help_examine_open')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `help_examine_open` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_setting','help_examine_index')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `help_examine_index` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','help_examine_package')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `help_examine_package` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','help_examine_my')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `help_examine_my` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','openposter')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `openposter` int(1) DEFAULT '0' COMMENT '0关闭 1开启'");}
if(!pdo_fieldexists('ypuk_ffyd_setting','poster_bg')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `poster_bg` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_setting','open_package_activation')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_setting')." ADD   `open_package_activation` int(1) DEFAULT '0' COMMENT '0关闭 1开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_text_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `text` text NOT NULL,
  `preview_text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_text_content','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_text_content')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_text_content','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_text_content')." ADD   `weid` int(11) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_text_content','articleid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_text_content')." ADD   `articleid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_text_content','text')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_text_content')." ADD   `text` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_text_content','preview_text')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_text_content')." ADD   `preview_text` text NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_userwithdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `weid` int(10) NOT NULL,
  `status` int(1) DEFAULT '0',
  `charged_price` float(10,2) DEFAULT NULL,
  `withdraw_price` float(10,2) DEFAULT NULL,
  `allprice` float(10,2) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_userwithdraw','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_userwithdraw')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_userwithdraw','uid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_userwithdraw')." ADD   `uid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_userwithdraw','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_userwithdraw')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_userwithdraw','status')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_userwithdraw')." ADD   `status` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_userwithdraw','charged_price')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_userwithdraw')." ADD   `charged_price` float(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_userwithdraw','withdraw_price')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_userwithdraw')." ADD   `withdraw_price` float(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_userwithdraw','allprice')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_userwithdraw')." ADD   `allprice` float(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_userwithdraw','createtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_userwithdraw')." ADD   `createtime` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_video_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `articleid` int(10) NOT NULL,
  `video` text NOT NULL,
  `videotype` int(1) DEFAULT '0',
  `videopic` varchar(260) NOT NULL,
  `text` text NOT NULL,
  `preview_time` int(10) NOT NULL DEFAULT '6',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_video_content','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_video_content')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_video_content','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_video_content')." ADD   `weid` int(11) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_video_content','articleid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_video_content')." ADD   `articleid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_video_content','video')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_video_content')." ADD   `video` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_video_content','videotype')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_video_content')." ADD   `videotype` int(1) DEFAULT '0'");}
if(!pdo_fieldexists('ypuk_ffyd_video_content','videopic')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_video_content')." ADD   `videopic` varchar(260) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_video_content','text')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_video_content')." ADD   `text` text NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_video_content','preview_time')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_video_content')." ADD   `preview_time` int(10) NOT NULL DEFAULT '6'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_vip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `vipid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `endtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_vip','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vip')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_vip','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vip')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_vip','vipid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vip')." ADD   `vipid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_vip','uid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vip')." ADD   `uid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_vip','price')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vip')." ADD   `price` float(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_vip','endtime')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vip')." ADD   `endtime` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_ypuk_ffyd_vipgroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `type` int(2) DEFAULT '1',
  `discount` varchar(10) DEFAULT '1',
  `validity` int(10) NOT NULL,
  `distribution_commission` varchar(100) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('ypuk_ffyd_vipgroup','id')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vipgroup')." ADD 
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('ypuk_ffyd_vipgroup','weid')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vipgroup')." ADD   `weid` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_vipgroup','price')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vipgroup')." ADD   `price` float(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_vipgroup','name')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vipgroup')." ADD   `name` varchar(200) DEFAULT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_vipgroup','type')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vipgroup')." ADD   `type` int(2) DEFAULT '1'");}
if(!pdo_fieldexists('ypuk_ffyd_vipgroup','discount')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vipgroup')." ADD   `discount` varchar(10) DEFAULT '1'");}
if(!pdo_fieldexists('ypuk_ffyd_vipgroup','validity')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vipgroup')." ADD   `validity` int(10) NOT NULL");}
if(!pdo_fieldexists('ypuk_ffyd_vipgroup','distribution_commission')) {pdo_query("ALTER TABLE ".tablename('ypuk_ffyd_vipgroup')." ADD   `distribution_commission` varchar(100) DEFAULT '0'");}
