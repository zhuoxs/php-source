<?php
global $_W, $_GPC;
$weid = $this->_weid;
load()->func('tpl');
$action = 'storerank';
$storeid = intval($_GPC['storeid']);
//检查门店
$this->checkStore($storeid);
$title = $this->actions_titles[$action];
$returnid = $this->checkPermission($storeid);
$deleted = intval($_GPC['deleted']);
//当前门店
$cur_store = $this->getStoreById($storeid);
//设置菜单
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);


$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$params    = array();
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
if ($operation == 'display') {

    $list = pdo_fetchall("SELECT from_user,sum(totalprice) as totalprice FROM " . tablename($this->table_order) . " WHERE status=3  AND
storeid=:storeid  GROUP BY from_user,weid having weid = :weid order by totalprice DESC LIMIT ".($pindex - 1) * $psize . ',
' . $psize, array(':weid' => $weid, ':storeid' => $storeid));

    $condition = " weid = :weid AND from_user<>'' AND find_in_set('{$storeid}', storeids) ";
    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " WHERE {$condition} ", array(':weid' => $weid));
    $pager = pagination($total, $pindex, $psize);
    foreach ($list as $key => $value) {
        $cartfans = $this->getFansByOpenid($value['from_user']);
        $list[$key]['fans'] = $cartfans;
    }
}
//include $this->template('memberpayph');
include $this->template('web/storerank');
