<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$tablesid = intval($_GPC['tablesid']);
$title = '全部商品';
$mode = intval($_GPC['mode']);
$append = intval($_GPC['append']);
$sid = intval($_GPC['sid']);
$setting = $this->getSetting();

$cateid = intval($_GPC['cateid']);

$storeid = intval($_GPC['storeid']);
if ($storeid == 0) {
    $storeid = $this->getStoreID();
}
if (empty($storeid)) {
    message('请先选择门店', $this->createMobileUrl('waprestlist'));
}
if ($mode == 0) {
    message('请先选择下单模式', $this->createMobileUrl('detail', array('id' => $storeid)));
}

$agentid = intval($_GPC['agentid']);
$agentid2 = 0;
$agentid3 = 0;


if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'waplist'; //method
    $host = $this->getOAuthHost();
    if ($mode == 1) {
        $authurl = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode, 'tablesid' => $tablesid, 'append' => $append, 'agentid' => $agentid), true) . '&authkey=1';
        $url = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode, 'tablesid' => $tablesid, 'append' => $append, 'agentid' => $agentid), true);
    } else {
        $authurl = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode, 'agentid' => $agentid), true) . '&authkey=1';
        $url = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode, 'agentid' => $agentid), true);
    }
    if (isset($_COOKIE[$this->_auth2_openid])) {
        $from_user = $_COOKIE[$this->_auth2_openid];
        $nickname = $_COOKIE[$this->_auth2_nickname];
        $headimgurl = $_COOKIE[$this->_auth2_headimgurl];
    } else {
        if (isset($_GPC['code'])) {
            $userinfo = $this->oauth2($authurl);
            if (!empty($userinfo)) {
                $from_user = $userinfo["openid"];
                $nickname = $userinfo["nickname"];
                $headimgurl = $userinfo["headimgurl"];
            } else {
                message('授权失败!');
            }
        } else {
            if (!empty($this->_appsecret)) {
                $this->getCode($url);
            }
        }
    }
} else {
    load()->model('mc');
    if (empty($_W['fans']['nickname'])) {
        mc_oauth_userinfo();
    }
    $from_user = $_W['fans']['openid'];
    $nickname = $_W['fans']['nickname'];
    $headimgurl = $_W['fans']['tag']['avatar'];
}


$fans = $this->getFansByOpenid($from_user);
if ($agentid != 0) {
    $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $agentid, ':weid' => $weid));
    $agent = $this->getFansById($agentid);
    if ($setting['commission_mode'] == 2) { //代理商模式
        if ($agent['is_commission'] != 2) {//用户不是代理商重新查找
            $agent = $this->getFansById($agent['agentid']);
            $agentid = intval($agent['id']);
        }
    }

    if (!empty($agent['agentid'])) {
        $agentid2 = intval($agent['agentid']);
        $agent2 = $this->getFansById($agentid2);
        if (!empty($agent2['agentid'])) {
            $agentid3 = intval($agent2['agentid']);
        }
    }
}

if ($this->_accountlevel == 4) {
    if (empty($fans) && !empty($nickname)) {
        $insert = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'nickname' => $nickname,
            'headimgurl' => $headimgurl,
            'agentid' => $agentid,
            'agentid2' => $agentid2,
            'agentid3' => $agentid3,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_fans, $insert);
    }
} else {
    if (empty($fans) && !empty($from_user)) {
        $insert = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'agentid' => $agentid,
            'agentid2' => $agentid2,
            'agentid3' => $agentid3,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_fans, $insert);
    }
}
$fans = $this->getFansByOpenid($from_user);

$follow_url = $setting['follow_url'];
if (empty($from_user)) {
    if (!empty($setting['follow_url'])) {
        header("location:$follow_url");
    }
}

$sub = 0;
if ($this->_accountlevel == 4) {
    $userinfo = $this->getUserInfo($from_user);
    if ($userinfo['subscribe'] == 1) {
        $sub = 1;
    }
} else {
    if ($_W['fans']['follow'] == 1) {
        $sub = 1;
    }
}

if ($sub == 0) {
    if ($setting['isneedfollow'] == 1) {
        if (!empty($follow_url)) {
            header("location:$follow_url");
        } else {
            message("请先关注公众号！");
        }
    }
}
$store = $this->getStoreById($storeid);

if ($store['is_card'] == 1) {
    $iscard = $this->get_store_card($storeid, $from_user);
} else {
    $iscard = $this->get_sys_card($from_user);
}

if ($mode == 1) {
    $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));
    if (empty($table)) {
        exit('餐桌不存在！');
    } else {
        $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $table['tablezonesid']));
        if (empty($tablezones)) {
            exit('餐桌类型不存在！');
        }
        $table_title = $tablezones['title'] . '-' . $table['title'];
        pdo_update($this->table_tables, array('status' => 1), array('id' => $tablesid));
        pdo_insert($this->table_tables_order, array('from_user' => $from_user, 'weid' => $weid, 'tablesid' => $tablesid, 'storeid' => $storeid, 'dateline' => TIMESTAMP));
    }
}

if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}


if ($store['is_check_user'] == 1) {
    $checkuser = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_checkuser") . " WHERE storeid = :storeid AND from_user=:from_user", array(':storeid' => $storeid, ':from_user' => $from_user));
    $is_check = 0;
    if ($checkuser) {
        if ($checkuser['is_check'] == 1) {
            $is_check = 1;
        }
    }
    if ($is_check == 0) {
        message('您好，本店只支持内部人员使用!');
    }
}

$collection = pdo_fetch("SELECT * FROM " . tablename($this->table_collection) . " where weid = :weid AND storeid=:storeid AND from_user=:from_user LIMIT 1", array(':weid' => $weid, ':storeid' => $storeid, ':from_user' => $from_user));

$isrest = 0;//营业中
if ($mode != 3 && $mode != 5) {
    if ($this->getstoretimestatus($store) == 0) { //休息中
        $isrest = 1;
    }
}
if ($store['is_show'] != 1) {
    message('门店暂停营业中,暂不接单!');
}
if ($mode == 1) { //店内
    if ($store['is_meal'] == 0) {
        message('商家已经关闭店内点餐模式，您暂时不能使用!');
    }
}
if ($mode == 2) { //外卖
    if ($store['is_delivery'] == 0) {
        message('商家已经关闭外卖功能，您暂时不能使用!');
    }
}
if ($mode == 4) {
    if ($store['is_snack'] == 0) {
        message('商家已经关闭快餐功能，您暂时不能使用!');
    }
}
if ($mode == 3) {
    if ($store['is_reservation'] == 0) {
        message('商家已经关闭预定功能，您暂时不能使用!');
    }
}

$pindex = max(1, intval($_GPC['page']));
$psize = 20;
$condition = '';

if ($mode == 1 || $mode == 5) {
    $condition .= " AND is_meal=1 ";
} elseif ($mode == 2) {
    $condition .= " AND is_delivery=1 ";
} elseif ($mode == 3) {
    $condition .= " AND is_reservation=1 ";
} elseif ($mode == 4) {
    $condition .= " AND is_snack=1 ";
}
if ($cateid != 0) {
    $condition .= " AND id={$cateid} ";
}

$children = array();
$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid = :weid AND storeid=:storeid {$condition} ORDER BY
displayorder DESC,id DESC", array(':weid' => $weid, ':storeid' => $storeid));

$intelligentid = intval($_GPC['intelligentid']);
$intelligent = pdo_fetch("SELECT * FROM " . tablename($this->table_intelligent) . " WHERE weid=:weid AND storeid=:storeid AND id=:id
ORDER BY id DESC limit 1", array(':weid' => $weid, ':storeid' => $storeid, ':id' => $intelligentid));

if ($intelligent) {
    //读取相关产品
    $goodsstrs = iunserializer($intelligent['content']);
    $goodsids = array();
    $goodscount = array();
    foreach ($goodsstrs as $key => $value) {
        $goodsids[] = $value['id'];
        $goodscount[$value['id']] = $value['count'];
    }

    $goodsidsstr = implode(',', $goodsids);
    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE FIND_IN_SET(id, '{$goodsidsstr}') AND weid=:weid AND storeid=:storeid", array(':weid' => $weid, ':storeid' => $storeid));
    $goodslist[]['goods'] = $goods;
    pdo_delete('weisrc_dish_cart', array('weid' => $weid, 'from_user' => $from_user, 'storeid' => $storeid));
    foreach ($goods as $key => $item) {
        $price = $item['marketprice'];
        if ($iscard == 1 && !empty($item['memberprice'])) {
            $price = $item['memberprice'];
        }
        //添加进购物车
        $data = array(
            'weid' => $weid,
            'storeid' => $item['storeid'],
            'goodsid' => $item['id'],
            'goodstype' => $item['pcate'],
            'price' => $price,
            'packvalue' => $item['packvalue'],
            'from_user' => $from_user,
            'total' => $goodscount[$item['id']],
        );
        pdo_insert($this->table_cart, $data);

    }
} else {
    $cid = intval($category[0]['id']);
    $week = date("w");
    $goodslist = array();
    foreach ($category as $key => $value) {
        $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid = '{$weid}' AND  storeid={$storeid} AND status = '1'
AND deleted=0 AND pcate=:pcate AND find_in_set(" . $week . ",week) ORDER BY displayorder DESC, subcount DESC, id DESC ", array(':pcate' => $value['id']));
        foreach ($goods as $k => $v) {
            if ($v['istime'] == 1) {
                if ($v['begindate'] > TIMESTAMP || TIMESTAMP > $v['enddate']) {
                    unset($goods[$k]);
                }
                $goodsstate = $this->check_hourtime($v['begintime'], $v['endtime']);
                if ($goodsstate == 0) {
                    unset($goods[$k]);
                }
            }
        }
        if ($goods) {
            $goodslist[$value['id']]['goods'] = $goods;
        } else {
            unset($category[$key]);
        }
    }
}

$catecount = count($category);
$cateheight = (($catecount + 1) * 62) + 200;

$dish_arr = $this->getDishCountInCart($storeid);
$cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND from_user=:from_user AND weid=:weid", array(':storeid' => $storeid, ':from_user' => $from_user, ':weid' => $weid));
$totalcount = 0;
$totalprice = 0;
foreach ($cart as $key => $value) {
    $goods_t = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id = :id LIMIT 1 ", array(':id' => $value['goodsid']));
    $cart[$key]['goodstitle'] = $goods_t['title'];
    $totalcount = $totalcount + $value['total'];
    $totalprice = $totalprice + $value['total'] * $value['price'];
}

$jump_url = $this->createMobileurl('wapmenu', array('from_user' => $from_user, 'storeid' => $storeid, 'mode' =>
    $mode, 'sid' => $sid), true);
$limitprice = 0;
$is_add_order = 0;
if ($mode == 1) {
    if ($append == 0) {
        $limitprice = floatval($tablezones['limit_price']);
    }
    $jump_url = $this->createMobileurl('wapmenu', array('from_user' => $from_user, 'storeid' => $storeid, 'mode' => $mode, 'tablesid' => $tablesid, 'append' => $append, 'orderid' => intval($_GPC['orderid']), 'sid' => $sid), true);

    $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid=:weid AND from_user=:from_user AND dining_mode=1 AND
status<>3 AND status<>-1 ORDER BY id DESC LIMIT 1", array(':from_user' => $from_user, ':weid' => $weid));
//    $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid=:weid AND dining_mode=1 AND
//status<>3 AND status<>-1 AND tables=:tables ORDER BY id DESC LIMIT 1", array(':weid' => $weid, ':tables' => $tablesid));
    if ($order) {
        if ($store['is_add_order'] == 1) {
            $is_add_order = 1;
        }
    }
    if ($append == 0) {
        if ($order) {
//            $order_url = $this->createMobileurl('orderdetail', array('orderid' => $order['id']), true);
//            header("location:$order_url");
        }
    }
} elseif ($mode == 2) {
    $limitprice = floatval($store['sendingprice']);
} elseif ($mode == 3) {
    $rtype = 2;
    $timeid = intval($_GPC['timeid']);
    $select_date = trim($_GPC['selectdate']);
    $time = pdo_fetch("SELECT * FROM " . tablename($this->table_reservation) . " WHERE weid = :weid AND storeid =:storeid AND id=:id ORDER BY id LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':id' => $timeid));
    if (!empty($time)) {
        $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE weid = :weid AND storeid =:storeid AND id=:id ORDER BY id LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':id' => $time['tablezonesid']));
        $limitprice = floatval($tablezones['limit_price']);
    }
    $jump_url = $this->createMobileUrl('reservationdetail', array('storeid' => $storeid, 'mode' => 3, 'selectdate' => $select_date, 'timeid' => $timeid, 'rtype' => 2, 'sid' => $sid), true);
} elseif ($mode == 5) {//排队
    $jump_url = $this->createMobileurl('queue', array('from_user' => $from_user, 'storeid' => $storeid, 'sid' => $sid), true);
}

$is_not_exists = 0;
//if (!$this->getmodules()) {
//    $is_not_exists = 1;
//}

//智能点餐
$intelligents = pdo_fetchall("SELECT 1 FROM " . tablename($this->table_intelligent) . " WHERE weid=:weid AND storeid=:storeid GROUP BY name ORDER by name", array(':weid' => $weid, ':storeid' => $storeid));

$share_title = !empty($setting['share_title']) ? str_replace("#username#", $nickname, $setting['share_title']) : "您的朋友{$nickname}邀请您来吃饭";
$share_desc = !empty($setting['share_desc']) ? str_replace("#username#", $nickname, $setting['share_desc']) : "最新潮玩法，快来试试！";
$share_image = !empty($setting['share_image']) ? tomedia($setting['share_image']) : tomedia("../addons/weisrc_dish/icon.jpg");
$share_url = $host . 'app/' . $this->createMobileUrl('waplist', array('storeid' => $storeid, 'mode' => $mode, 'tablesid' => $tablesid, 'agentid' => $fans['id'], 'sid' => $sid), true);

$ispop = 0;
if ($setting['tiptype'] == 1) { //关注后隐藏
    if ($sub == 0) {
        $ispop = 1;
    }
} else if ($setting['tiptype'] == 2) {
    $ispop = 1;
}

if ($store['btn_coupon_type'] == 1 && $store['btn_coupon_id']) {
    $coupon = pdo_fetch("SELECT * FROM " . tablename($this->table_coupon) . " WHERE id=:id LIMIT 1", array(':id' => $store['btn_coupon_id']));
    $is_coupon_show = 1;
    if (empty($coupon)) {
        $is_coupon_show = 0;
    } else {
        if (TIMESTAMP < $coupon['starttime']) {
            $is_coupon_show = 0;
        }
        if (TIMESTAMP > $coupon['endtime']) {
            $is_coupon_show = 0;
        }
    }
}

$follow_title = !empty($setting['follow_title']) ? $setting['follow_title'] : "立即关注";
$follow_desc = !empty($setting['follow_desc']) ? $setting['follow_desc'] : "欢迎关注智慧点餐点击马上加入,
助力品牌推广 ";
$follow_image = !empty($setting['follow_logo']) ? tomedia($setting['follow_logo']) : tomedia("../addons/weisrc_dish/icon.jpg");
$tipqrcode = tomedia($setting['tipqrcode']);
$tipbtn = intval($setting['tipbtn']);
$follow_url = $setting['follow_url'];

if ($cateid != 0 || $intelligent) { //有分类或者活动
    include $this->template($this->cur_tpl . '/list_2');
} else {
    include $this->template($this->cur_tpl . '/list_1');
}
