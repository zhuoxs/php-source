<?php
$tablename = trim(tablename('mzhk_sun'),"`");
$sql="
DROP TABLE IF EXISTS `{$tablename}_subcard_set`;
DROP TABLE IF EXISTS `{$tablename}_subcard_goods`;
DROP TABLE IF EXISTS `{$tablename}_subcard_order`;
DROP TABLE IF EXISTS `{$tablename}_subcard_subcard_scate`;
";
pdo_run($sql);


?>