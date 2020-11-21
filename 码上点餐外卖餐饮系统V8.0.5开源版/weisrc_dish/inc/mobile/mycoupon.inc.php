<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$type = isset($_GPC['type']) ? intval($_GPC['type']) : 1;

if ($type == 1) {
    $strwhere = " AND b.status=0 AND " . TIMESTAMP . "<a.endtime ";
} elseif ($type == 2) {
    $strwhere = " AND b.status=1 ";
} elseif ($type == 3) {
    $strwhere = " AND b.status=0 AND " . TIMESTAMP . ">a.endtime ";
}

$couponlist = pdo_fetchall("SELECT a.*,b.sncode FROM " . tablename($this->table_coupon) . " a INNER JOIN " .
    tablename($this->table_sncode) .
    " b ON a.id = b.couponid
 WHERE a.weid = :weid AND b.from_user=:from_user {$strwhere} ORDER BY b.id DESC
LIMIT 30", array(':weid' => $weid, ':from_user' => $from_user));


foreach ($couponlist as $key => $value) {
    if ($value['goodsids'] > 0) {

        $goods = pdo_fetchall("SELECT * FROM "  . tablename('weisrc_dish_goods') . " WHERE
 weid=:weid AND id in(".$value['goodsids'].")", array(':weid' => $weid));
        if ($goods) {
            $couponlist[$key]['goods'] = $goods;
        }
    }
}

$storelist = pdo_fetchall("SELECT id,title FROM " . tablename($this->table_stores) . " WHERE weid=:weid ORDER BY id DESC ", array(':weid' => $weid), 'id');

include $this->template($this->cur_tpl . '/mycoupon');