<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);

$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_queue_setting) . " WHERE weid = :weid AND storeid =:storeid AND :time>starttime
AND :time<endtime AND status=1 ORDER BY limit_num ASC ", array(':weid' => $this->_weid, ':storeid' => $storeid, ':time' => date('H:i')));
$queue_count = pdo_fetchall("SELECT queueid,COUNT(1) as count FROM " . tablename($this->table_queue_order) . " where storeid=:storeid AND status=1 AND  weid = :weid GROUP BY queueid", array(':weid' => $this->_weid, ':storeid' => $storeid), 'queueid');

$result = array(
    'list' => array()
);

$index = 0;
foreach ($list AS $key => $value) {
    $current = 0;
    if (!empty($queue_count[$value['id']]['count'])) {
        $current = $queue_count[$value['id']]['count'];
    }

    $user_queue = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " where weid = :weid AND status=1 AND storeid=:storeid AND queueid=:queueid ORDER BY id ASC LIMIT 1 ", array(':weid' => $weid, ':storeid' => $storeid, ':queueid' => $value['id']));

    $result['list'][] = array(
        'before' => 0,
        'type' => $value['title'],
        'current' => empty($user_queue['num']) ? 0 : $user_queue['num'],
        'type_name' => $value['title']
    );
    $index++;
}
echo json_encode($result);