<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
defined('IN_IA') or exit('Access Denied');
$tablenames = array();
$sql = "SHOW TABLES";
$list = pdo_fetchall($sql);
if (!empty($list)) {
    foreach ($list as $k=>$v) {
        $arr = array_values($v);
        $tablename = $arr[0];
        if (strpos($tablename, $module_name) !== false) {
            $tablenames[] = $tablename;
        }
    }
}
if (!empty($tablenames)) {
    foreach ($tablenames as $t) {
        $sql = "DROP TABLE IF EXISTS ".tablename($t);
        pdo_query($sql);
    }
}