<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);
$queueid = intval($_GPC['queueid']);
$usermobile = trim($_GPC['usermobile']);
$usercount = trim($_GPC['usercount']);

if (empty($from_user)) {
    $this->showMsg('请重新发送关键字进入系统!');
}
if (empty($storeid)) {
    $this->showMsg('请先选择门店!');
}
if (empty($usermobile)) {
    $this->showMsg('请输入手机号码!');
}
if (empty($usercount)) {
    $this->showMsg('请输入用户数量!');
}
$store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC LIMIT 1", array(':weid' => $weid, ':id' => $storeid));

$num = 'C001';
$config = $this->module['config']['weisrc_dish'];
if ($queueid == 0) { //未选队列
    if ($store['screen_mode'] == 2) {
        $this->showMsg('请先选择队列!');
    }

    $queueSetting = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_setting) . " WHERE weid = :weid AND storeid =:storeid AND :time>starttime
AND :time<endtime AND :usercount<=limit_num AND status=1 ORDER BY limit_num ASC LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':time' => date('H:i'), ':usercount' => $usercount));

    if (empty($queueSetting)) {
        $this->showMsg('没有符合您人数的队列!');
    }

    $exists_queue = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " WHERE queueid=:queueid AND from_user=:from_user AND status=1 ORDER BY id DESC LIMIT 1", array(':queueid' => $queueSetting['id'], ':from_user' => $from_user));
    if (!empty($exists_queue)) {
        $this->showMsg('您已经在排队中！');
    }

    $queueOrder = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " WHERE weid = :weid AND storeid =:storeid AND queueid=:queueid ORDER BY id DESC LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':queueid' => $queueSetting['id']));

    if (empty($queueOrder)) {
        $num = $queueSetting['prefix'] . '001';
    } else {
        $num = intval(findNum($queueOrder['num']));
        $num++;
        if ($num > 998) {
            $num = 1;
        }
        $num = $queueSetting['prefix'] . str_pad($num, 3, "0", STR_PAD_LEFT);
    }
    $queueid = $queueSetting['id'];
} else { //已选队列
    if (empty($store['screen_mode']) || $store['screen_mode'] == 1) {
        $this->showMsg('请先选择队列!');
    }
    $queueSetting = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_setting) . " WHERE weid = :weid AND storeid =:storeid AND :time>starttime AND :time<endtime AND id=:id AND :usercount<=limit_num LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':time' => date('H:i'), ':id' => $queueid, ':usercount' => $usercount));

    if (empty($queueSetting)) {
        $this->showMsg('没有符合您人数的队列!');
    }

    $exists_queue = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " WHERE queueid=:queueid AND from_user=:from_user AND status=1 ORDER BY id DESC LIMIT 1", array(':queueid' => $queueSetting['id'], ':from_user' => $from_user));
    if (!empty($exists_queue)) {
        $this->showMsg('您已经在排队中！');
    }

    $queueOrder = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " WHERE weid = :weid AND storeid =:storeid AND queueid=:queueid ORDER BY id DESC LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':queueid' => $queueSetting['id']));

    if (empty($queueOrder)) {
        $num = $queueSetting['prefix'] . '001';
    } else {
        $num = intval(findNum($queueOrder['num']));
        $num++;
        $num = $queueSetting['prefix'] . str_pad($num, 3, "0", STR_PAD_LEFT);
    }
}

$data = array(
    'weid' => $weid,
    'from_user' => $from_user,
    'storeid' => $storeid,
    'queueid' => $queueid,
    'num' => $num,
    'mobile' => $usermobile,
    'usercount' => $usercount,
    'isnotify' => 0,
    'status' => 1, //状态
    'dateline' => TIMESTAMP
);

pdo_insert($this->table_queue_order, $data);
$oid = pdo_insertid();
if ($oid > 0) {
    if ($this->_accountlevel == 4) {
        $this->sendQueueNotice($oid);
        $setting = $this->getSetting();
        if (!empty($setting)) {
            $accounts = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND storeid=:storeid AND status=2 AND is_notice_queue=1 ORDER BY id DESC ", array(':weid' => $this->_weid, ':storeid' => $storeid));
            foreach ($accounts as $key => $value) {
                if (!empty($value['from_user'])) {
                    $this->sendAdminQueueNotice($oid, $value['from_user'], $setting);
                }
            }
        }
    }
}
$this->showMsg('操作成功!', 1);