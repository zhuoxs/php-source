<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$id = intval($_GPC['id']);

if (empty($from_user)) {
    $this->showMsg('请重新发送关键字进入系统!');
}

if ($id == 0) { //未选队列
    $this->showMsg('请先选择订单!');
} else { //已选队列
    $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id=:id AND from_user=:from_user AND status=0 ORDER BY id DESC LIMIT 1", array(':id' => $id, ':from_user' => $from_user));
    if (empty($order)) {
        $this->showMsg('订单不存在！');
    }
    $store = $this->getStoreById($order['storeid']);

    $coin = floatval($order['totalprice']);
    if ($order['paytype'] == 1 && $order['status'] != -1) {
        if ($order['ispay'] == 1) {
//            $coin = floatval($order['totalprice']);
//            $this->setFansCoin($order['from_user'], $coin, "码上点餐单号{$order['ordersn']}退款");
        }
    }
    if ($order['ispay'] == 1) {
        pdo_update($this->table_order, array('ispay' => 2), array('id' => $id));
    }

    pdo_update($this->table_order, array('status' => -1), array('id' => $id));
    $this->_feiyinSendFreeMessage($id);
    $this->_365SendFreeMessage($id);
    $this->_feieSendFreeMessage($id);
    $this->_yilianyunSendFreeMessage($id);
    $this->_jinyunSendFreeMessage($id);
    $setting = pdo_fetch("select * from " . tablename($this->table_setting) . " where weid =:weid LIMIT 1", array(':weid' => $weid));
    $this->cancelfengniao($order, $store, $setting);
    if (!empty($setting)) {
        //平台提醒
        if ($setting['is_notice'] == 1) {
            if (!empty($setting['tpluser'])) {
                $tousers = explode(',', $setting['tpluser']);
                foreach ($tousers as $key => $value) {
                    $this->sendAdminOrderNotice($id, $value, $setting);
                }
            }
        }

        $storeid = intval($order['storeid']);
        //门店提醒
        $accounts = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND storeid=:storeid AND status=2 ORDER BY id DESC ", array(':weid' => $weid, ':storeid' => $storeid));
        foreach ($accounts as $key => $value) {
            if (!empty($value['from_user'])) {
                $this->sendAdminOrderNotice($id, $value['from_user'], $setting);
            }
        }
    }
    $this->setOrderServiceRead($id);
    $this->showMsg('取消订单成功!', 1);
}
$this->showMsg('操作成功!!!', 1);