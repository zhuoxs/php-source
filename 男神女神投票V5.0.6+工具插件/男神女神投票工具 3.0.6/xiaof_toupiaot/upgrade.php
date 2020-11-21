<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_xiaof_toupiaot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `acid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `openlog` int(11) NOT NULL DEFAULT '1',
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `data` varchar(255) NOT NULL,
  `vnum` int(10) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '0',
  `complete` int(11) NOT NULL,
  `goodnum` int(11) NOT NULL,
  `clicknum` int(11) NOT NULL,
  `sharenum` int(11) NOT NULL,
  `addr` varchar(36) NOT NULL,
  `fans` varchar(30) NOT NULL DEFAULT '0',
  `starttime` int(10) NOT NULL,
  `stoptime` int(10) NOT NULL,
  `sleeptime` varchar(255) NOT NULL,
  `updated_at` int(10) NOT NULL,
  `goodtime` int(10) NOT NULL,
  `sharetime` int(10) NOT NULL,
  `clicktime` int(10) NOT NULL,
  `created_at` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
";
pdo_run($sql);
if(!pdo_fieldexists("xiaof_toupiaot", "id")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "acid")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `acid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "sid")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `sid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "type")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `type` tinyint(3) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("xiaof_toupiaot", "openlog")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `openlog` int(11) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("xiaof_toupiaot", "pid")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `pid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "uid")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "data")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `data` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "vnum")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `vnum` int(10) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("xiaof_toupiaot", "status")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `status` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("xiaof_toupiaot", "complete")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `complete` int(11) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "goodnum")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `goodnum` int(11) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "clicknum")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `clicknum` int(11) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "sharenum")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `sharenum` int(11) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "addr")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `addr` varchar(36) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "fans")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `fans` varchar(30) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("xiaof_toupiaot", "starttime")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `starttime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "stoptime")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `stoptime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "sleeptime")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `sleeptime` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "updated_at")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `updated_at` int(10) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "goodtime")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `goodtime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "sharetime")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `sharetime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "clicktime")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `clicktime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiaot", "created_at")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiaot")." ADD   `created_at` int(10) NOT NULL;");
}

 ?>