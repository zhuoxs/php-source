<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);
$queueid = intval($_GPC['queueid']);
$sid = intval($_GPC['sid']);

$setting = $this->getSetting();

$store = $this->getStoreById($storeid);
if ($store['screen_mode'] == 2) {
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_queue_setting) . " WHERE weid = :weid AND storeid =:storeid AND :time>starttime AND :time<endtime  ORDER BY id ASC", array(':weid' => $this->_weid, ':storeid' => $storeid, ':time' => date('H:i')));
}

include $this->template($this->cur_tpl . '/queue_form');