<?php
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->_weid;
$action = 'fans';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $condition = '';
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND ordersn LIKE '%{$_GPC['keyword']}%'";
    }
    if (isset($_GPC['status']) && $_GPC['status'] != '') {
        $condition .= " AND status={$_GPC['status']} ";
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_commission) . " WHERE weid = :weid {$condition} ORDER BY id DESC " . $limit, array(':weid' => $weid));
    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_commission) . " WHERE weid = :weid {$condition} ", array(':weid' => $weid));

    foreach ($list as $key => $value) {
        if ($value['agentid'] > 0) {
            $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user = :from_user AND weid=:weid", array(':from_user' => $value['from_user'], ':weid' => $this->_weid));
            $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id = :id", array(':id' => $value['agentid']));
            if ($fans) {
                $list[$key]['headimgurl'] = $fans['headimgurl'];
                $list[$key]['nickname'] = $fans['nickname'];
                $list[$key]['fansid'] = $fans['id'];
            }
            if ($agent) {
                $list[$key]['agentheadimgurl'] = $agent['headimgurl'];
                $list[$key]['agentnickname'] = $agent['nickname'];
            }
        }
    }
    $pager = pagination($total, $pindex, $psize);
} else if ($operation == 'post') {

} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_commission) . " WHERE id = :id AND weid=:weid", array(':id' => $id, ':weid' => $weid));
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('commission', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }
    if ($item['status'] == 0) {
        pdo_delete($this->table_commission, array('id' => $id, 'weid' => $weid));
        message('删除成功！', $this->createWebUrl('commission', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'setstatus') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_commission) . " WHERE id = :id AND weid=:weid", array(':id' => $id, ':weid' => $weid));
    if ($item['status'] == 0) {
        $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id = :id", array(':id' => $item['agentid']));

        if ($agent) {
            pdo_query("UPDATE " . tablename($this->table_commission) . " SET status = :status WHERE id=:id AND weid=:weid", array(':status' => 1, ':id' => $id, ':weid' => $this->_weid));
//            $this->setFansCoin($agent['from_user'], $item['price'], "单号{$item['ordersn']}佣金奖励");
            if ($item['level']==1) {
                $level = "一级";
            }
            if ($item['level']==2) {
                $level = "二级";
            }

            $this->updateFansCommission($agent['from_user'], 'commission_price', $item['price'], "单号{$item['ordersn']}{$level}佣金奖励");
            message('操作成功！', $this->createWebUrl('commission', array('op' => 'display', 'storeid' => $storeid)), 'success');
        }
        message('上级不存在！');
    } else {
        message('记录已经结算！');
    }
}
include $this->template('web/commission');