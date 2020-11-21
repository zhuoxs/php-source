<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$id = intval($_GPC['id']);

$item = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC", array(':weid' => $weid, ':id' => $id));

$collection = pdo_fetch("SELECT * FROM " . tablename($this->table_collection) . " where weid = :weid AND storeid=:storeid AND from_user=:from_user LIMIT 1", array(':weid' => $weid, ':storeid' => $id, ':from_user' => $from_user));

$data = array(
    'weid' => $weid,
    'storeid' => $id,
    'from_user' => $from_user,
    'dateline' => TIMESTAMP
);

$status = 0;
if (empty($collection)) {
    pdo_insert($this->table_collection, $data);
    $status = 1;
} else {
    pdo_delete($this->table_collection, array('id' => $collection['id']));
}

$result = array('status' => $status);
echo json_encode($result);