<?php
global $_GPC, $_W;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$level = intval($_GPC['level']) == 0 ? 1 : intval($_GPC['level']);

if (empty($from_user)) {
    echo json_encode(0);
}

$agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $from_user, ':weid' => $weid));

if ($agent) {
    $total_price = pdo_fetchcolumn("SELECT sum(price) AS totalprice FROM " . tablename($this->table_commission) . " WHERE weid =
:weid AND agentid=:agentid AND status=1 ", array(':weid' => $weid, ':agentid' => $agent['id']));
    $total_price = floatval($total_price);
    $total_mymember_count = pdo_fetchcolumn("SELECT COUNT(1) AS count FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND agentid=:agentid", array(':weid' => $weid, ':agentid' => $agent['id']));
    $total_mymember_count = intval($total_mymember_count);

    $pindex = max(1, intval($_GPC['page']));
    $psize = 6;

    $condition = " agentid=:agentid ";
    if ($level == 2) {
        $condition = " agentid2=:agentid ";
    }
    if ($level == 3) {
        $condition = " agentid3=:agentid ";
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . "  WHERE {$condition} ORDER
            BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':agentid' => $agent['id']));
    foreach ($list as $key => $value) {
        $mymember_count = pdo_fetchcolumn("SELECT COUNT(1) AS count FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND agentid=:agentid", array(':weid' => $weid, ':agentid' => $value['id']));
        $pay_price = pdo_fetchcolumn("SELECT sum(totalprice) AS totalprice FROM " . tablename($this->table_order) . " WHERE ispay=1 AND status=3 AND weid =
:weid AND from_user=:from_user ", array(':weid' => $weid, ':from_user' => $value['from_user']));
        $pay_price = floatval($pay_price);
        $list[$key]['payprice'] = $pay_price;
        $list[$key]['mymembercount'] = $mymember_count;
    }

    $result_str = '';
    foreach ($list as $key => $value) {
        $result_str .= '<div class="order-item section ng-scope">';
        $result_str .= '<div class="list-item">';
        $result_str .= '<table class="am-table"><tr>';
        $result_str .= '<td style="width: 25%">';
        $img = tomedia($value['headimgurl']);
        $result_str .= '<img src="' . $img . '" class="am-circle" width="80px" style="border-radius:1000px;"></td>';
        $result_str .= '<td style="color: #666;padding-left: 10px;">';
        $nickname = $value['nickname'];
        $result_str .= '<span>昵称: ' . $nickname . '</span><br>';
        $dateline = date('Y/m/d', $value['dateline']);
        $result_str .= '<span>时间: ' . $dateline . '</span><br>';
        $payprice = $value['payprice'];
        $result_str .= '<span>总消费额: ' . $payprice . '</span><br>';
        $mymembercount = $value['mymembercount'];
        $result_str .= '<span>下级数量: ' . $mymembercount . '</span>';
        $result_str .= '</td></tr></table></div></div>';
    }

    if ($result_str == '') {
        echo json_encode(0);
    } else {
        echo json_encode($result_str);
    }
} else {
    echo json_encode(0);
}