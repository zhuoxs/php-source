<?php
global $_W, $_GPC;
$weid = $this->_weid;

$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_businesslog) . " WHERE weid =:weid AND status=0 ORDER BY id DESC LIMIT 50", array(':weid' => $weid));
foreach ($list as $key => $item) {
    $storeid = $item['storeid'];
    $userstore = $this->getStoreById($storeid);
    if ($item['business_type']== 1) { //微信账号
        if (empty($userstore['business_openid'])) {
            continue;
        }
        if (empty($userstore['business_username'])) {
            continue;
        }
        $price = floatval($item['successprice']);
        if ($price < 1) {
            continue;
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
        } else {
            pdo_update($this->table_businesslog, array('status' => -1, 'handletime' => TIMESTAMP, 'result' => $result['msg']), array('id' => $id, 'weid' => $weid));
        }
        file_put_contents(IA_ROOT . "/addons/weisrc_dish/business.log", var_export($returnresult, true) .
            PHP_EOL, FILE_APPEND);
    }
}
