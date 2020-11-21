<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$lat = trim($_GPC['lat']);
$lng = trim($_GPC['lng']);

if (empty($from_user)) {
    $this->showMsg('请重新发送关键字进入系统!');
}

pdo_update($this->table_fans, array('lat' => $lat, 'lng' => $lng, 'lasttime' => TIMESTAMP), array('from_user' => $from_user, 'weid' => $weid));
$this->showMsg('success', 1);