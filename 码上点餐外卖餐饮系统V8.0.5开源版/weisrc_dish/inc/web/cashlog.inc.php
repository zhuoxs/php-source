<?php
global $_W, $_GPC, $code;
$action = 'business';
$weid = $this->_weid;

$returnid = $this->checkPermission();

$setting = $this->getSetting();
$action = 'cashlog';
$title = '佣金提现管理';
$url = $this->createWebUrl($action, array('op' => 'display'));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$GLOBALS['frames'] = $this->getMainMenu();
if ($operation == 'display') {
    load()->func('tpl');
    $logtype = intval($_GPC['logtype']) == 0?1:intval($_GPC['logtype']);
    $strwhere = " weid = '{$_W['uniacid']}' ";
    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']) + 86399;
        $strwhere .= " AND dateline >= :starttime AND dateline <= :endtime ";
        $paras[':starttime'] = $starttime;
        $paras[':endtime'] = $endtime;
    }

    if (empty($starttime) || empty($endtime)) {
        $starttime = strtotime('-1 month');
        $endtime = time();
    }

    $strwhere .= " AND logtype = :logtype ";
    $paras[':logtype'] = $logtype;

    if (isset($_GPC['status']) && $_GPC['status'] != '') {
        $strwhere .= " AND status = :status ";
        $paras[':status'] = intval($_GPC['status']);
    }
    if (isset($_GPC['type']) && $_GPC['type'] != '') {
        $strwhere .= " AND type = :type ";
        $paras[':type'] = intval($_GPC['type']);
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $list = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_cashlog") . " WHERE {$strwhere} ORDER BY id DESC LIMIT
" . ($pindex - 1) * $psize . ",{$psize}", $paras);

    if (!empty($list)) {
        foreach ($list as $key => $value) {
            $user = $this->getFansByOpenid($value['from_user']);
            if ($user) {
                $list[$key]['headimgurl'] = $user['headimgurl'];
                $list[$key]['nickname'] = $user['nickname'];
                $list[$key]['username'] = $user['username'];
            }
        }

        $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename("weisrc_dish_cashlog") . " WHERE {$strwhere}
        ", $paras);
        $pager = pagination($total, $pindex, $psize);
    }
} elseif ($operation == 'setstatus') {
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        $id = intval($_GPC['id']);

        $item = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_cashlog') . " WHERE weid =:weid AND id=:id ORDER BY id DESC LIMIT 1", array(':weid' => $weid, ':id' => $id));
        if (!empty($item) && $item['stauts'] == 0) {
            $type = intval($item['type']);
            $from_user = $item['from_user'];
            $totalprice = $item['successprice'];
            $user = $this->getFansByOpenid($item['from_user']);
            if (empty($user)) {
                message('粉丝不存在！');
            }

            $issuccess = 0;
            if ($type == 1) { //微信支付提现
                $result = $this->sendMoney($from_user, $totalprice, '');
                if ($result['result_code'] == 'SUCCESS') {
                    $issuccess = 1;
                }
            } else if ($type == 2) { //余额提现
                $this->setFansCoin($from_user, $totalprice, "推广佣金提现");
                $issuccess = 1;
            } else if ($type == 3) { //现金提现
                $issuccess = 1;
            } else {
                message('未知提现类型！', $this->createWebUrl('cashlog', array('op' => 'display', 'logtype' => $_GPC['logtype'])), 'error');
            }

            if ($issuccess == 1) {
                $data = array(
                    'status' => 1,
                    'handletime' => TIMESTAMP,
                    'trade_no' => $result['trade_no'],
                    'payment_no' => $result['payment_no']
                );
                pdo_update('weisrc_dish_cashlog', $data, array('id' => $id, 'weid' => $weid));
                message('提现成功！', $this->createWebUrl('cashlog', array('op' => 'display', 'logtype' => $_GPC['logtype'])), 'success');
            } else {
                pdo_update('weisrc_dish_cashlog', array('status' => -1, 'handletime' => TIMESTAMP, 'remark' => $result['msg']), array('id' => $id, 'weid' => $weid));
                message('提现失败！' . $result['err_code'], $this->createWebUrl('cashlog', array('op' => 'display', 'logtype' => $_GPC['logtype'])), 'error');
            }

        }
    }
}

include $this->template('web/cashlog');