<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_cyl_video_sessions` (
  `sid` char(32) NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `uid` varchar(25) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `time` varchar(15) NOT NULL,
  `video_url` text NOT NULL,
  `share` int(3) NOT NULL,
  `yvideo_url` text NOT NULL,
  `type` varchar(25) NOT NULL,
  `index` int(2) NOT NULL,
  `video_id` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `thumb` varchar(1000) NOT NULL,
  `link` varchar(1000) NOT NULL,
  `end_time` varchar(15) NOT NULL,
  `sort` int(5) NOT NULL,
  `second` int(3) NOT NULL,
  `status` int(2) NOT NULL,
  `type` varchar(25) NOT NULL DEFAULT 'dumiao',
  `insert` int(3) NOT NULL,
  `title` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(10) NOT NULL,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `url` varchar(1000) NOT NULL,
  `is_vip` int(2) NOT NULL,
  `is_nav` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_collection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(5) NOT NULL,
  `d_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `uid` varchar(25) NOT NULL,
  `time` varchar(15) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_forum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `time` varchar(15) NOT NULL,
  `video_url` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_hdp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(1000) NOT NULL,
  `link` varchar(1000) NOT NULL,
  `out_link` varchar(1000) NOT NULL,
  `type` varchar(15) NOT NULL,
  `sort` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(5) NOT NULL,
  `d_id` int(11) NOT NULL,
  `jishu` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `uid` varchar(25) NOT NULL,
  `time` varchar(15) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(25) NOT NULL,
  `card_id` varchar(25) NOT NULL,
  `num` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_keyword_id` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(1000) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `pwd` varchar(25) NOT NULL,
  `card_id` varchar(25) NOT NULL,
  `day` int(11) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_manage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(25) NOT NULL,
  `thumb` varchar(1000) NOT NULL,
  `year` varchar(25) NOT NULL,
  `star` varchar(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `actor` varchar(25) NOT NULL,
  `video_url` text NOT NULL,
  `desc` text NOT NULL,
  `time` varchar(25) NOT NULL,
  `screen` varchar(25) NOT NULL,
  `cid` int(3) NOT NULL,
  `pid` int(3) NOT NULL,
  `click` int(5) NOT NULL,
  `display` int(2) NOT NULL,
  `sort` int(5) NOT NULL,
  `out_link` varchar(1000) NOT NULL,
  `keyword` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `rid` int(10) NOT NULL,
  `is_charge` int(3) NOT NULL,
  `charge` decimal(10,2) NOT NULL,
  `is_proved` int(3) NOT NULL,
  `proved` decimal(10,2) NOT NULL,
  `resources` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `uid` varchar(25) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `avatar` varchar(1000) NOT NULL,
  `end_time` varchar(15) NOT NULL,
  `is_pay` int(2) NOT NULL,
  `time` varchar(15) NOT NULL,
  `old_time` varchar(15) NOT NULL,
  `ip` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_message` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `video_id` varchar(50) NOT NULL,
  `uniacid` int(20) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `old_id` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `huifu` text NOT NULL,
  `time` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(5) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `uid` varchar(25) NOT NULL,
  `status` int(2) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `time` varchar(15) NOT NULL,
  `tid` varchar(255) NOT NULL,
  `day` int(5) NOT NULL,
  `desc` varchar(25) NOT NULL,
  `video_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_vip_video_share` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(1000) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `time` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists("cyl_video_sessions", "sid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_video_sessions")." ADD   `sid` char(32) NOT NULL;");
}
if(!pdo_fieldexists("cyl_video_sessions", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_video_sessions")." ADD   `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists("cyl_video_sessions", "uid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_video_sessions")." ADD   `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `uniacid` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "title")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `title` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "uid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `uid` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "openid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `openid` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `time` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "video_url")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `video_url` text NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "share")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `share` int(3) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "yvideo_url")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `yvideo_url` text NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "type")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `type` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "index")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `index` int(2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "video_id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   `video_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `uniacid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "thumb")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `thumb` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "link")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `link` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `end_time` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "sort")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `sort` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "second")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `second` int(3) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "status")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `status` int(2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "type")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `type` varchar(25) NOT NULL DEFAULT 'dumiao';");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "insert")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `insert` int(3) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "title")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   `title` varchar(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_ad", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_ad")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_category", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_category", "parentid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   `parentid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_category", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("cyl_vip_video_category", "name")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   `name` varchar(20) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_category", "status")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   `status` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("cyl_vip_video_category", "displayorder")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("cyl_vip_video_category", "url")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   `url` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_category", "is_vip")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   `is_vip` int(2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_category", "is_nav")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   `is_nav` int(2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_category", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_category")." ADD   KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists("cyl_vip_video_collection", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_collection")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_collection", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_collection")." ADD   `uniacid` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_collection", "d_id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_collection")." ADD   `d_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_collection", "title")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_collection")." ADD   `title` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_collection", "uid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_collection")." ADD   `uid` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_collection", "time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_collection")." ADD   `time` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_collection", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_collection")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_forum", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_forum")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_forum", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_forum")." ADD   `uniacid` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_forum", "title")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_forum")." ADD   `title` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_forum", "openid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_forum")." ADD   `openid` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_forum", "time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_forum")." ADD   `time` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_forum", "video_url")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_forum")." ADD   `video_url` text NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_forum", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_forum")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_hdp", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_hdp")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_hdp", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_hdp")." ADD   `uniacid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_hdp", "title")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_hdp")." ADD   `title` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_hdp", "thumb")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_hdp")." ADD   `thumb` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_hdp", "link")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_hdp")." ADD   `link` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_hdp", "out_link")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_hdp")." ADD   `out_link` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_hdp", "type")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_hdp")." ADD   `type` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_hdp", "sort")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_hdp")." ADD   `sort` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_hdp", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_hdp")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_history", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_history")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_history", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_history")." ADD   `uniacid` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_history", "d_id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_history")." ADD   `d_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_history", "jishu")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_history")." ADD   `jishu` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_history", "title")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_history")." ADD   `title` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_history", "uid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_history")." ADD   `uid` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_history", "time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_history")." ADD   `time` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_history", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_history")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_keyword", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword", "title")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword")." ADD   `title` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword", "card_id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword")." ADD   `card_id` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword", "num")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword")." ADD   `num` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword", "day")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword")." ADD   `day` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_keyword_id", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword_id")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword_id", "openid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword_id")." ADD   `openid` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword_id", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword_id")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword_id", "pwd")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword_id")." ADD   `pwd` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword_id", "card_id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword_id")." ADD   `card_id` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword_id", "day")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword_id")." ADD   `day` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword_id", "status")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword_id")." ADD   `status` int(2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_keyword_id", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_keyword_id")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "title")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `title` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "thumb")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `thumb` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "year")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `year` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "star")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `star` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "type")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `type` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "actor")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `actor` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "video_url")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `video_url` text NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "desc")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `desc` text NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `time` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "screen")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `screen` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "cid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `cid` int(3) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "pid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `pid` int(3) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "click")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `click` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "display")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `display` int(2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "sort")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `sort` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "out_link")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `out_link` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "keyword")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `keyword` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "password")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `password` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "rid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `rid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "is_charge")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `is_charge` int(3) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "charge")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `charge` decimal(10,2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "is_proved")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `is_proved` int(3) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "proved")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `proved` decimal(10,2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "resources")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   `resources` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_manage", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_manage")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_member", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `uniacid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "phone")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `phone` varchar(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "password")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `password` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "openid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `openid` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "uid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `uid` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `nickname` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `avatar` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "end_time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `end_time` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "is_pay")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `is_pay` int(2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `time` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "old_time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `old_time` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "ip")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   `ip` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_member", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_member")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_message", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_message")." ADD   `id` int(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_message", "video_id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_message")." ADD   `video_id` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_message", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_message")." ADD   `uniacid` int(20) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_message", "openid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_message")." ADD   `openid` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_message", "old_id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_message")." ADD   `old_id` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_message", "content")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_message")." ADD   `content` text NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_message", "huifu")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_message")." ADD   `huifu` text NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_message", "time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_message")." ADD   `time` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_message", "status")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_message")." ADD   `status` int(2) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("cyl_vip_video_order", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `uniacid` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "openid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `openid` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "uid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `uid` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "status")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `status` int(2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "fee")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `fee` decimal(10,2) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `time` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "tid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `tid` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "day")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `day` int(5) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "desc")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `desc` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "video_id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   `video_id` int(10) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_order", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_order")." ADD   UNIQUE KEY `id` (`id`);");
}
if(!pdo_fieldexists("cyl_vip_video_share", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_share")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("cyl_vip_video_share", "openid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_share")." ADD   `openid` varchar(1000) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_share", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_share")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_share", "uid")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_share")." ADD   `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_share", "time")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_share")." ADD   `time` varchar(25) NOT NULL;");
}
if(!pdo_fieldexists("cyl_vip_video_share", "id")) {
 pdo_query("ALTER TABLE ".tablename("cyl_vip_video_share")." ADD   UNIQUE KEY `id` (`id`);");
}

 ?>