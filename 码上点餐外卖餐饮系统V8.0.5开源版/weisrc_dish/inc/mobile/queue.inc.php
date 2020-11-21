<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);
$sid = intval($_GPC['sid']);

$setting = $this->getSetting();

$store = $this->getStoreById($storeid);

$user_queue = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " where weid = :weid AND from_user=:from_user AND status=1 AND storeid=:storeid ORDER BY id DESC LIMIT 1 ", array(':weid' => $weid, ':from_user' => $from_user, ':storeid' => $storeid));
if (!empty($user_queue)) {
    $queue_setting = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_setting) . " where id = :id ORDER BY id DESC LIMIT 1 ", array(':id' => $user_queue['queueid']));
    $cur_queue = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " where weid = :weid AND storeid=:storeid AND status=1 AND queueid=:queueid ORDER BY id ASC LIMIT 1 ", array(':weid' => $weid, ':storeid' => $storeid, ':queueid' => $user_queue['queueid']));
    $wait_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_queue_order) . " WHERE status=1 AND storeid=:storeid AND id<:id AND queueid=:queueid ORDER BY id DESC", array(':id' => $user_queue['id'], ':storeid' => $storeid, ':queueid' => $user_queue['queueid']));
}
$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_queue_setting) . " WHERE weid = :weid AND storeid =:storeid AND :time>starttime
AND :time<endtime AND status=1 ORDER BY limit_num ASC", array(':weid' => $this->_weid, ':storeid' => $storeid, ':time' => date('H:i')));
$queue_count = pdo_fetchall("SELECT queueid,COUNT(1) as count FROM " . tablename($this->table_queue_order) . " where storeid=:storeid AND status=1 AND  weid = :weid GROUP BY queueid", array(':weid' => $this->_weid, ':storeid' => $storeid), 'queueid');

include $this->template($this->cur_tpl . '/queue');