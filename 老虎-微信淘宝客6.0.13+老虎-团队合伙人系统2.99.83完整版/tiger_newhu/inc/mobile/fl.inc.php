<?php
//http://cs.tigertaoke.com/app/index.php?i=14&c=entry&do=appdh&m=tiger_newhu
global $_W, $_GPC;

$weid=$_W['uniacid'];
$dh = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_fztype") . " WHERE  weid='{$weid}'");
exit(json_encode($dh)); 
?>