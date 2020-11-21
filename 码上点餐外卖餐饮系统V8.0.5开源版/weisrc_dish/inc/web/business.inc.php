<?php
global $_W, $_GPC, $code;
$action = 'business';
$weid = $this->_weid;

$returnid = $this->checkPermission();

$setting = $this->getSetting();
$is_contain_delivery = intval($setting['is_contain_delivery']);

$action = 'business';
$title = '提现设置';
$url = $this->createWebUrl($action, array('op' => 'display'));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$GLOBALS['frames'] = $this->getMainMenu();
if ($operation == 'display') {
    $shoptypeid = intval($_GPC['shoptypeid']);
    $areaid = intval($_GPC['areaid']);
    $keyword = trim($_GPC['keyword']);

    if (checksubmit('submit')) { //排序
        if (is_array($_GPC['displayorder'])) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                $data = array('displayorder' => intval($_GPC['displayorder'][$id]));
                pdo_update($this->table_stores, $data, array('id' => $id));
            }
        }
        message('操作成功!', $url);
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $where = "WHERE weid = {$weid} AND deleted=0 ";

    if (!empty($keyword)) {
        $where .= " AND title LIKE '%{$keyword}%'";
    }
    if ($returnid != 0) {
        $where .= " AND id={$returnid} ";
    }

    $types = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid = :weid ORDER BY id DESC, displayorder DESC", array(':weid' => $weid), 'id');

    $storeslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " {$where} order by displayorder desc,id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");

    foreach($storeslist as $key => $value) {
        $storeid = intval($value['id']);
        $order_totalprice = $this->getStoreOrderTotalPrice($storeid, $is_contain_delivery);
        //已申请
        $totalprice1 = $this->getStoreOutTotalPrice($storeid);
        //未申请
        $totalprice2 = $this->getStoreGetTotalPrice($storeid);

        $totalprice = $order_totalprice - $totalprice1 - $totalprice2;
        $totalprice = sprintf('%.2f', $totalprice);

        $storeslist[$key]['totalprice'] = $totalprice;
    }

    if (!empty($storeslist)) {
        $total = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_stores) . " $where");
        $pager = pagination($total, $pindex, $psize);
    }
} elseif ($operation == 'post') {
    load()->func('tpl');
    $id = intval($_GPC['id']);
    $store = pdo_fetch("select * from " . tablename($this->table_stores) . " where id=:id and weid =:weid", array(':id' => $id, ':weid' => $weid));
    if (checksubmit('submit')) {
        $data = array(
            'is_default_rate' => 2,
            'getcash_price' => intval($_GPC['getcash_price']),
            'fee_rate' => floatval($_GPC['fee_rate']),
            'fee_min' => intval($_GPC['fee_min']),
            'fee_max' => intval($_GPC['fee_max']),
        );

        if (!empty($id)) {
            pdo_update($this->table_stores, $data, array('id' => $id, 'weid' => $weid));
        }
        message('操作成功!', $url);
    }
} elseif ($operation == 'adminbusinesslog') {
    load()->func('tpl');

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

    if (isset($_GPC['status']) && $_GPC['status']!='') {
        $strwhere .= " AND status = :status ";
        $paras[':status'] = intval($_GPC['status']);
    }
    if (isset($_GPC['business_type']) && $_GPC['business_type'] != '') {
        $strwhere .= " AND business_type = :business_type ";
        $paras[':business_type'] = intval($_GPC['business_type']);
    }
    $stores = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid=:weid ORDER BY id DESC", array(':weid' => $weid), 'id');
    if ($_GPC['out_put'] == 'output') {
        $sql = "select * from " . tablename($this->table_businesslog)
            . " WHERE $strwhere ORDER BY status DESC, dateline DESC ";
        $list = pdo_fetchall($sql, $paras);
        $status_arr = array(
            '0' => array('css' => 'default', 'name' => '待处理'),
            '1' => array('css' => 'success', 'name' => '已提现'),
            '-1' => array('css' => 'danger', 'name' => '提现失败'),
        );

        $businesstype_arr = array(
            '1' => array('css' => 'danger', 'name' => '微信'),
            '2' => array('css' => 'info', 'name' => '支付宝'),
        );

        $i = 0;
        foreach ($list as $key => $value) {
            $arr[$i]['id'] = $value['id'];
            $arr[$i]['status'] = $status_arr[$value['status']]['name'];
            $arr[$i]['dateline'] = date('Y-m-d H:i:s', $value['dateline']);
            $arr[$i]['price'] = $value['price'];
            $arr[$i]['charges'] = $value['charges'];
            $arr[$i]['successprice'] = $value['successprice'];
            $arr[$i]['business_type'] = $businesstype_arr[$value['business_type']]['name'];

            if ($value['business_type'] == 1) {
                $arr[$i]['business_name'] = $stores[$value['storeid']]['business_wechat'];
            } else if ($value['business_type'] == 2) {
                $arr[$i]['business_name'] = $stores[$value['storeid']]['business_alipay'];
            } else {
                $arr[$i]['business_name'] = $stores[$value['storeid']]['business_wechat'];
            }
            $arr[$i]['business_username'] = $stores[$value['storeid']]['business_username'];
            $arr[$i]['store'] = $stores[$value['storeid']]['title'];
            $arr[$i]['trade_no'] = "'" . $value['trade_no'];
            $arr[$i]['payment_no'] = "'" . $value['payment_no'];
            $arr[$i]['result'] = $value['result'];
            $i++;
        }

        $this->exportexcel($arr, array('编号', '提现状态', '申请时间', '提现金额', '手续费', '到账金额', '账号类型', '收款账号', '真实姓名', '所属门店', '商户订单号', '微信订单号', '交易信息'), time());
        exit();
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_businesslog) . " WHERE {$strwhere} ORDER BY id DESC LIMIT
" . ($pindex - 1) * $psize . ",{$psize}" , $paras);

    if (!empty($list)) {
        $total_price = pdo_fetchcolumn("SELECT sum(price) FROM " . tablename($this->table_businesslog) . " WHERE weid=:weid AND status=1 ", array(':weid' => $this->_weid));
        $total_charges = pdo_fetchcolumn("SELECT sum(charges) FROM " . tablename($this->table_businesslog) . " WHERE weid=:weid AND status=1 ", array(':weid' => $this->_weid));

        $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_businesslog) . " WHERE {$strwhere}
        ", $paras);
        $pager = pagination($total, $pindex, $psize);
    }
} elseif ($operation == 'setstatus') {
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        $id = intval($_GPC['id']);

        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_businesslog) . " WHERE weid =:weid AND id=:id ORDER BY id DESC LIMIT 1", array(':weid' => $weid, ':id' => $id));
        if (!empty($item) && $item['status']==0) {
            $storeid = $item['storeid'];
            $userstore = $this->getStoreById($storeid);
            if ($item['business_type']== 1) { //微信账号
                if (empty($userstore['business_openid'])) {
                    message('提现账号没有设置对应的微信粉丝，不能提现！');
                }
                if (empty($userstore['business_username'])) {
                    message('提现账号对应的姓名没填写，不能提现！');
                }
                $price = floatval($item['successprice']);
                if ($price < 1) {
                    message('提现金额最少要1元！');
                }

                $result = $this->sendMoney($userstore['business_openid'], $price, $userstore['business_username']);
                if ($result['result_code'] == 'SUCCESS') {
                    $data = array(
                        'status' => 1,
                        'handletime' => TIMESTAMP,
                        'trade_no' => $result['trade_no'],
                        'payment_no' => $result['payment_no'],
                    );
                    pdo_update($this->table_businesslog, $data, array('id' => $id, 'weid' => $weid));
                    message('提现成功！', $this->createWebUrl('business', array('op' => 'adminbusinesslog')), 'success');
                } else {
                    pdo_update($this->table_businesslog, array('status' => -1, 'handletime' => TIMESTAMP, 'result' => $result['msg']), array('id' => $id, 'weid' => $weid));
                    message('提现失败！' . $result['err_code'], $this->createWebUrl('business', array('op' => 'adminbusinesslog')), 'success');
                }
            } else {
                pdo_update($this->table_businesslog, array('status' => 1, 'handletime' => TIMESTAMP), array('id' => $id, 'weid' => $weid));
                message('操作成功！', $this->createWebUrl('business', array('op' => 'adminbusinesslog')), 'success');
            }
        }
    }
} elseif ($operation == 'delete') {
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        $id = intval($_GPC['id']);
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_businesslog) . " WHERE weid =:weid AND id=:id ORDER BY id DESC LIMIT 1", array(':weid' => $weid, ':id' => $id));
        if ($item['status'] == 0) {
            pdo_delete($this->table_businesslog, array('weid' => $weid, 'id' => $id));
            message('操作成功！', $this->createWebUrl('business', array('op' => 'adminbusinesslog')), 'success');
        }
    } else {
        message('您没有相关的操作权限！');
    }
}

include $this->template('web/business');