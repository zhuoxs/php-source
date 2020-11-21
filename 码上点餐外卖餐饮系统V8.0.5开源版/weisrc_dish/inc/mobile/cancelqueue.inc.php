<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);

$user_queue = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " where weid = :weid AND from_user=:from_user AND status=1 AND storeid=:storeid ORDER BY id DESC LIMIT 1 ", array(':weid' => $weid, ':from_user' => $from_user, ':storeid' => $storeid));

$resultid = pdo_update($this->table_queue_order, array('status' => -1), array('id' => $user_queue['id']));
if ($resultid > 0) {
    if ($this->_accountlevel == 4) {
        $this->sendQueueNotice($user_queue['id'], 3);
    }
}
message('取消排号成功.', $this->createMobileurl('queue', array('storeid' => $storeid), true));