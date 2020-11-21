<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);

$config = $this->module['config']['weisrc_dish'];
$url = $_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&storeid=' . $storeid . '&do=queue&m=weisrc_dish';
$store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC LIMIT 1", array(':weid' => $weid, ':id' => $storeid));

include $this->template('queue_screen');