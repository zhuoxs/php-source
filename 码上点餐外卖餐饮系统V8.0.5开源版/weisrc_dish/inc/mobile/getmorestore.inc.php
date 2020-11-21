<?php
global $_GPC, $_W;
$weid = $this->_weid;
$lat = $_COOKIE[$this->_lat];
$lng = $_COOKIE[$this->_lng];

$areaid = intval($_GPC['areaid']);
$typeid = intval($_GPC['typeid']);
$sortid = intval($_GPC['sortid']);
$sid = intval($_GPC['sid']);

if ($sortid == 0) {
//    $sortid = 2;
}

$strwhere = " where weid = :weid and is_show=1 AND is_list=1 AND deleted=0 ";

if ($areaid != 0) {
    $strwhere .= "  AND areaid={$areaid} ";
}

if ($typeid != 0) {
    $strwhere .= " AND typeid={$typeid} ";
}
if ($sid > 0) {
    $strwhere .= " AND schoolid={$sid} ";
}

$pindex = max(1, intval($_GPC['page']));
$psize = $this->more_store_psize;
$limit = " LIMIT " . ($pindex - 1) * $psize . ',' . $psize;

if ($sortid == 1) {
    $list = pdo_fetchall("SELECT *,(lat-:lat) * (lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename($this->table_stores) . " {$strwhere
} ORDER BY is_rest DESC,displayorder DESC, id DESC " . $limit, array(':weid' => $weid, ':lat' => $lat, ':lng' => $lng));
} else if ($sortid == 2 && !empty($lat)) {
    $list = pdo_fetchall("SELECT *,(lat-:lat)*(lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename($this->table_stores) . " {$strwhere
} ORDER BY dist, displayorder DESC,id DESC " . $limit, array(':weid' => $weid, ':lat' => $lat, ':lng' => $lng));
} else {
//    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " {$strwhere} ORDER BY displayorder DESC, id DESC" . $limit, array(':weid' => $weid));
    $list = pdo_fetchall("SELECT *,(lat-:lat)*(lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename($this->table_stores) . " {$strwhere} ORDER BY displayorder DESC,dist,id DESC " . $limit, array(':weid' => $weid, ':lat' => $lat, ':lng' => $lng));
}

if (!empty($list)) {
    foreach ($list as $key => $value) {
//        $good_count = pdo_fetchcolumn("SELECT sum(sales) FROM " . tablename($this->table_goods) . " WHERE storeid=:id ", array(':id' => $value['id']));
        $list[$key]['sales'] = intval($good_count);
        $newlimitprice = '';
        $oldlimitprice = '';
        if ($value['is_newlimitprice'] == 1) {
            $couponlist = pdo_fetchall("select * from " . tablename($this->table_coupon) . " WHERE storeid=:storeid AND :time<endtime AND type=3 ORDER BY gmoney desc,id DESC LIMIT 10", array(':storeid' => $value['id'], ':time' => TIMESTAMP));
            foreach ($couponlist as $key2 => $value2) {
                $newlimitprice .= $value2['title'] . ';';
            }
            $list[$key]['newlimitprice'] = $newlimitprice;
        }
        if ($value['is_oldlimitprice'] == 1) {
            $couponlist = pdo_fetchall("select * from " . tablename($this->table_coupon) . " WHERE storeid=:storeid AND :time<endtime AND type=4 ORDER BY gmoney
desc,id DESC LIMIT 10", array(':storeid' => $value['id'], ':time' => TIMESTAMP));
            foreach ($couponlist as $key3 => $value3) {
                $oldlimitprice .= $value3['title'] . ';';
            }
            $list[$key]['oldlimitprice'] = $oldlimitprice;
        }
    }
}

$result_str = '';
foreach ($list as $key => $value) {
    if ($value['default_jump'] == 1) {
        $url = $this->createMobileUrl('detail', array('id' => $value['id'], 'sid' => $sid), true);
    } elseif ($value['default_jump'] == 2) {
        $url = $this->createMobileUrl('waplist', array('storeid' => $value['id'], 'mode' => 2, 'sid' => $sid), true);
    } elseif ($value['default_jump'] == 3) {
        $url = $this->createMobileUrl('waplist', array('storeid' => $value['id'], 'mode' => 4, 'sid' => $sid), true);
    } elseif ($value['default_jump'] == 4) {
        $url = $this->createMobileUrl('queue', array('storeid' => $value['id'], 'sid' => $sid), true);
    } elseif ($value['default_jump'] == 5) {
        $url = $this->createMobileUrl('reservationIndex', array('storeid' => $value['id'], 'mode' => 3, 'sid' => $sid), true);
    } elseif ($value['default_jump'] == 6) {
        $url = $value['default_jump_url'];
    }
    $logo = tomedia($value['logo']);
    $defaultlogo = tomedia('./addons/weisrc_dish/icon.jpg');

    $result_str .= '<section class="item" onclick="location.href=\'' . $url . '\'">';
    $result_str .= '<div class="left-wrap">';
    $result_str .= '<img class="logo" src="' . $logo . '" onerror="this.src=\'' . $defaultlogo . '\'">';

    if ($this->getstoretimestatus($value) == 0) {
        $result_str .= '<span class="status-tip" style="background-color: rgb(192, 192, 192);"> 商家休息 </span>';
    }
    $result_str .= '</div>';
    $result_str .= '<div class="right-wrap">';
    $result_str .= '<section class="line">';
    $premium = '';
    if ($value['is_brand'] == 1) {
        $premium = '<span class="premium">'.$value['brandname'].'</span>';
    }

    $result_str .= '<h3 class="shopname">' . $premium. $value['title'] . '</h3>';
    $result_str .= '<div class="support-wrap">';
    if ($value['is_meal'] == 1) {
        $result_str .= '<div class="activity-wrap nowrap">';
        $result_str .= '<i class="activity-icon icononly" style="color: rgb(153, 153, 153); border-color: rgb(221, 221, 221);"> 店 </i>';
        $result_str .= '</div>';
        $result_str .= '<div class="tag label-red ng-scope"></div>';
    }
    if ($value['is_delivery'] == 1) {
        $result_str .= '<div class="activity-wrap nowrap">';
        $result_str .= '<i class="activity-icon icononly" style="color: rgb(153, 153, 153); border-color: rgb(221, 221, 221);"> 外 </i>';
        $result_str .= '</div>';
    }
    $result_str .= '</div>';
    $result_str .= '</section>';
    $result_str .= '<section class="line">';
    $result_str .= '<div class="rate-wrap">';
    $result_str .= '<span>';
    for ($i = 0; $i < $value['level']; $i++) {
        $result_str .= '<i class="i-star i-star-gold"></i>';
    }
    $result_str .= '</span>';
    if ($value['sales'] > 0) {
        $result_str .= '<span>已售' . $value['sales'] . '份</span>';
    }
    $result_str .= '</div>';
    if ($value['is_delivery']==1) {
        $tip = "准时达";
    } else {
        $tip = "商家联盟";
    }

    $result_str .= '<div class="delivery-wrap">';
    $result_str .= '<span class="icon-delivery">'.$tip.'</span>';
    $result_str .= '</div>';
    $result_str .= '</section>';
    $result_str .= '<section class="line">';
    $result_str .= '<div class="moneylimit">';

    if ($value['is_delivery'] == 1) {


        if (!empty($value['sendingprice'])) {
            $result_str .= '<span>¥' . $value['sendingprice'] . '起送</span>';
        }
        if ($value['dispatchprice'] > 0) {
            $result_str .= '<span>配送费约¥' . $value['dispatchprice'] . '</span>';
        } else {
            $result_str .= '<span>免配送费</span>';
        }
        if ($value['freeprice'] != 0.00) {
            $result_str .= '<span>满' . intval($value['freeprice']) . '免配送费</span>';
        }
    } else {

        $result_str .= '<span>' . $value['address'] . '</span>';

    }

    $result_str .= '</div>';
    $result_str .= '<div class="timedistance-wrap">';
    $result_str .= '<span class="distance-wrap">' . $this->getDistance($value['lat'], $value['lng'], $lat, $lng) . 'km</span>';
    $result_str .= '</div>';
    $result_str .= '</section>';

    if (!empty($value['newlimitprice'])) {
        $result_str .= '<section class="line"><div>';
        $result_str .= '<i class="icon-bg1">新</i><span class="info">' . $value['newlimitprice'] . '</span>';
        $result_str .= '</div>';
        $result_str .= '</section>';
    }
    if (!empty($value['oldlimitprice'])) {
        $result_str .= '<section class="line"><div>';
        $result_str .= '<i class="icon-bg2">减</i><span class="info">' . $value['oldlimitprice'] . '</span>';
        $result_str .= '</div>';
        $result_str .= '</section>';
    }
    $result_str .= '</div>';
    $result_str .= '</section>';
}

if ($result_str == '') {
    echo json_encode(0);
} else {
    echo json_encode($result_str);
}
