<?php
global $_GPC, $_W;
$weid = $this->_weid;
$couponid = intval($_GPC['couponid']);
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$action = 'coupon';
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$url = $this->createWebUrl($action);
$title = $this->actions_titles[$action];

$coupon = pdo_fetch("SELECT * FROM " . tablename($this->table_coupon) . " WHERE weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $couponid));


$pindex = max(1, intval($_GPC['page']));
$psize = 15;
$where = "WHERE a.weid = '{$weid}' and a.couponid = {$couponid}";

$list = pdo_fetchall("SELECT a.*,b.nickname as nickname,b.headimgurl  FROM " . tablename($this->table_sncode) . " a INNER JOIN " .
    tablename
    ($this->table_fans) . " b ON a.from_user=b.from_user {$where} order by a.id
 desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");

if (!empty($list)) {
    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_sncode) . " a INNER JOIN " . tablename($this->table_fans) . " b ON a.from_user=b.from_user {$where} order by a.id desc");
    $pager = pagination($total, $pindex, $psize);
}
include $this->template('web/sncodelist');