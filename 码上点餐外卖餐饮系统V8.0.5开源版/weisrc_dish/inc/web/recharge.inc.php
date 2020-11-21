<?php
global $_W, $_GPC;
load()->func('tpl');
$weid = $_W['uniacid'];
$action = 'recharge';
$title = $this->actions_titles[$action];

//$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);
$GLOBALS['frames'] = $this->getMainMenu();

$url = $this->createWebUrl($action, array('storeid' => $storeid));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    if (checksubmit('submit')) { //排序
        if (is_array($_GPC['displayorder'])) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                $data = array('displayorder' => intval($_GPC['displayorder'][$id]));
                pdo_update($this->table_recharge, $data, array('id' => $id));
            }
        }
        message('操作成功!', $url);
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $where = "WHERE weid = {$weid} ";

    $recharges = pdo_fetchall("SELECT * FROM " . tablename($this->table_recharge) . " {$where} order by displayorder desc,id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
    if (!empty($recharges)) {
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_recharge) . " $where");
        $pager = pagination($total, $pindex, $psize);
    }

} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $reply = pdo_fetch("select * from " . tablename($this->table_recharge) . " where id = :id AND weid=:weid
            LIMIT 1", array(':id' => $id, ':weid' => $weid));

    if (!empty($reply)) {
        $starttime = date('Y-m-d H:i', $reply['starttime']);
        $endtime = date('Y-m-d H:i', $reply['endtime']);
    } else {
        $starttime = date('Y-m-d H:i');
        $endtime = date('Y-m-d H:i', TIMESTAMP + 86400 * 30);
    }

    if (checksubmit('submit')) {
        $data = array(
            'weid' => intval($_W['uniacid']),
            'title' => trim($_GPC['title']),
            'recharge_value' => floatval($_GPC['recharge_value']),
            'give_value' => floatval($_GPC['give_value']),
            'total' => intval($_GPC['total']),
            'content' => trim($_GPC['content']),
            'starttime' => strtotime($_GPC['datelimit']['start']),
            'endtime' => strtotime($_GPC['datelimit']['end']),
            'displayorder' => intval($_GPC['displayorder']),
            'dateline' => TIMESTAMP,
        );

        if (istrlen($data['title']) == 0) {
            message('没有输入标题.', '', 'error');
        }
        if (istrlen($data['title']) > 30) {
            message('标题不能多于30个字。', '', 'error');
        }

        if ($data['count'] < 0) {
            message('优惠券张数不能小于于0.', '', 'error');
        }
        if ($data['count'] > 10000) {
            message('优惠券张数不能大于10000.', '', 'error');
        }
        if ($data['count'] < 0) {
            message('优惠券总张数不能小于于0.', '', 'error');
        }

        if (!empty($reply)) {
            unset($data['dateline']);
            pdo_update($this->table_recharge, $data, array('id' => $id, 'weid' => $_W['uniacid']));
        } else {
            pdo_insert($this->table_recharge, $data);
        }
        message('操作成功!', $url);
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    if ($id > 0) {
        pdo_delete($this->table_recharge, array('id' => $id, 'weid' => $_W['uniacid']));
    }
    message('操作成功!', $url);
} else if ($operation == 'record') {
    $rechargeid = intval($_GPC['rechargeid']);

    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $where = "WHERE weid = {$weid} AND rechargeid={$rechargeid} ";

    $recharges = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_recharge_record") . " {$where} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");

    foreach ($recharges as $key => $value) {
        $user = $this->getFansByOpenid($value['from_user']);
        if ($user) {
            $recharges[$key]['headimgurl'] = $user['headimgurl'];
            $recharges[$key]['nickname'] = $user['nickname'];
            $recharges[$key]['username'] = $user['username'];
        }
    }

    if (!empty($recharges)) {
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("weisrc_dish_recharge_record") . " $where");
        $pager = pagination($total, $pindex, $psize);
    }
}

include $this->template('web/recharge');