<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_xiaof_toupiao_plugin_rank` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `sid` smallint(6) unsigned NOT NULL,
  `data` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists("xiaof_toupiao_plugin_rank", "id")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiao_plugin_rank")." ADD   `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("xiaof_toupiao_plugin_rank", "sid")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiao_plugin_rank")." ADD   `sid` smallint(6) unsigned NOT NULL;");
}
if(!pdo_fieldexists("xiaof_toupiao_plugin_rank", "data")) {
 pdo_query("ALTER TABLE ".tablename("xiaof_toupiao_plugin_rank")." ADD   `data` mediumtext NOT NULL;");
}

 ?>