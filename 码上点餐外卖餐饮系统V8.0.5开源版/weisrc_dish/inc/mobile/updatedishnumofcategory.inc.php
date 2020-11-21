<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;

$storeid = intval($_GPC['storeid']); //门店id
$dishid = intval($_GPC['dishid']); //商品id
$optionid = $_GPC['optionid']; //商品id
$total = intval($_GPC['o2uNum']); //更新数量
$optype = trim($_GPC['optype']);

if (empty($from_user)) {
    $this->showTip('会话已过期，请重新发送关键字!', 1);
}

$store = $this->getStoreById($storeid);

if ($this->getstoretimestatus($store) == 0) {
    $this->showTip('商家休息中,暂不接单', 1);
}

//查询商品是否存在
$goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" => $dishid));
if (empty($goods)) {
    $this->showTip('没有相关商品', 1);
}
$nowtime = mktime(0, 0, 0);
if ($goods['lasttime'] <= $nowtime) {
    pdo_query("UPDATE " . tablename($this->table_goods) . " SET today_counts=0,lasttime=:time WHERE id=:id", array(':id' => $dishid, ':time' => TIMESTAMP));
}
if (empty($optionid)) {
    $cart = pdo_fetch("SELECT * FROM " . tablename($this->table_cart) . " WHERE goodsid=:goodsid AND weid=:weid AND storeid=:storeid AND
from_user=:from_user", array(':goodsid' => $dishid, ':weid' => $weid, ':storeid' => $storeid, ':from_user' => $from_user));
} else {
    //查询购物车有没该商品
    $cart = pdo_fetch("SELECT * FROM " . tablename($this->table_cart) . " WHERE goodsid=:goodsid AND weid=:weid AND storeid=:storeid AND
from_user=:from_user AND optionid=:optionid ", array(':goodsid' => $dishid, ':weid' => $weid, ':storeid' => $storeid, ':from_user' => $from_user, ':optionid' => $optionid));
}


if ($goods['counts'] == 0) {
    $this->showTip('该商品已售完', 1);
}
if ($goods['counts'] > 0) {
    $count = $goods['counts'] - $goods['today_counts'];
    if ($count <= 0) {
        $this->showTip('该商品已售完', 1);
    }
    if (!empty($cart)) {
        if ($cart['total'] < $total) {
            if ($total > $count) {
                $this->showTip('该商品已没库存', 1);
            }
        }
    } else {
        if ($total > $count) {
            $this->showTip('该商品已没库存', 1);
        }
    }
}

$iscard = $this->get_sys_card($from_user);
$price = floatval($goods['marketprice']);
if ($iscard == 1 && !empty($goods['memberprice'])) {
    $price = floatval($goods['memberprice']);
}

$optionid  = trim($_GPC['optionid']);
$optionids = explode('_',$optionid);
$optionprice = 0;
$optionname = '';

if (count($optionids) > 0) {
    $options = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_goods_option") . "  WHERE id IN ('" . implode("','", $optionids) . "') ORDER BY type
DESC;");
    $is_first = 0;
    $type = 0;
    foreach ($options as $key => $val) {
        if ($type != 0) { //开始循环了
            if ($type != $val['type']) { //
                $is_first = 0;
                $optionname .= '|';
            }
        }
        $type = $val['type'];
        $optionprice = $optionprice + $val['price'];
        if ($is_first == 0) {
            $optionname .= $val['title'];
        } else {
            $optionname .= '+' . $val['title'];
        }

        $is_first++;
    }
}

$price = $price + floatval($optionprice);

$startcount = intval($goods['startcount']);
$endcount = intval($goods['endcount']);

if (empty($cart)) {
    //不存在的话增加商品点击量
    pdo_query("UPDATE " . tablename($this->table_goods) . " SET subcount=subcount+1 WHERE id=:id", array(':id' => $dishid));
    $addtotal = 1;
    if ($startcount > 1) {
        $addtotal = $startcount;
    }

    if ($optype == 'add') {
        if ($total > $startcount) {
            $addtotal = $total;
        } else {
            $addtotal = $startcount;
        }
    }

    $tablesid = intval($_GPC['tableid']);

    //添加进购物车
    $data = array(
        'weid' => $weid,
        'tableid' => $tablesid,
        'storeid' => $goods['storeid'],
        'goodsid' => $goods['id'],
        'optionid' => $optionid,
        'optionname' => $optionname,
        'goodstype' => $goods['pcate'],
        'price' => $price,
        'packvalue' => $goods['packvalue'],
        'from_user' => $from_user,
        'dateline' => TIMESTAMP,
        'total' => $addtotal
    );
    pdo_insert($this->table_cart, $data);
} else {
    if ($optype == 'add') {
        $total = intval($cart['total']) + $total;
        if ($startcount > $total) {
            $total = $startcount;
        }
    }

    if ($total > 0) { //有数量
        if ($cart['total'] > 0 ) {
//            $this->showTip('该商品已没库存' . $total, 1);
            if ($startcount > 1 && $total < $startcount) {
                $total = 0;
                $goodscount = 0;
            }
        } else {
            if ($startcount > 1 && $total < $startcount) {
                $total = $startcount;
            }
        }
    }

    if ($endcount > 0) {
        if ($total > $endcount) {
            $this->showTip('最多购买' . $endcount . '份', 1);
        }
    }

    if ($total == 0) {
        pdo_delete('weisrc_dish_cart', array('id' => $cart['id']));
    } else {
        //更新商品在购物车中的数量
        pdo_update($this->table_cart, array('total' => $total, 'dateline' => TIMESTAMP), array('id' => $cart['id']));
    }
}

$totalcount = 0;
$totalprice = 0;
$goodscount = 0;

$cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND from_user=:from_user AND weid=:weid", array(':storeid' => $storeid, ':from_user' => $from_user, ':weid' => $weid));

$cart_html = '<ul>';
foreach ($cart as $key => $value) {
    $goods_t = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id = :id LIMIT 1 ", array(':id' => $value['goodsid']));
    if (!$this->getmodules()) {$value['price'] = floatval($value['price']);}
    $cart[$key]['goodstitle'] = $goods_t['title'];
    $totalcount = $totalcount + $value['total'];
    $totalprice = $totalprice + $value['total'] * $value['price'];

    if ($value['goodsid'] == $dishid) {
        $goodscount = $goodscount + intval($value['total']);
    }

    if ($value['total'] > 0) {
        $optionname = '';
        if (!empty($value['optionname'])) {
            $optionname = '[' . $value['optionname'] . ']';
        }

        $cart_html .= '<li dishid="'.$value['goodsid'].'" optionid="'.$value['optionid'].'">';
        $cart_html .= '<div class="cart-item-name">'.$goods_t['title'] . $optionname . '</div>';
        $cart_html .= '<div class="cart-item-price">¥<font>'.$value['price'].'</font></div>';
        $cart_html .= '<div class="cart-item-num">';
        $cart_html .= '<i class="cart-item-add"></i>';
        $cart_html .= '<span>'.$value['total'].'</span>';
        $cart_html .= '<i class="cart-item-jj"></i>';
        $cart_html .= '</div>';
        $cart_html .= '</li>';
    }
}
$cart_html .= '</ul>';
$result['totalprice'] = $totalprice;
$result['totalcount'] = $totalcount;
$result['goodscount'] = $goodscount;
$result['cart'] = $cart_html;
$result['code'] = 0;
message($result, '', 'ajax');