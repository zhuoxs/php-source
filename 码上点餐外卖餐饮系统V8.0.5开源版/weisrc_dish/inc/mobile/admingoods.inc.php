<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$storeid = intval($_GPC['storeid']);
$cid = intval($_GPC['cid']);

$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'admingoods'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'op' => $op), true) .
        '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'op' => $op), true);
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

$store = $this->getStoreById($storeid);
if (empty($store)) {
    message('门店不存在!');
}

$fans = $this->getFansByOpenid($from_user);
if (empty($fans)) {
    $this->addFans($nickname, $headimgurl);
} else {
    $this->updateFans($nickname, $headimgurl, $fans['id']);
}
$fans = $this->getFansByOpenid($from_user);
if ($fans['status'] == 0) {
    die('系统调试中！');
}

if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

$is_permission = false;
$is_all = false;
$tousers = explode(',', $setting['tpluser']);
if (in_array($from_user, $tousers)) {
    $is_all = true;
    $is_permission = true;
}
if ($is_permission == false) {
    $adminschool = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND
    from_user=:from_user AND status=2 AND role=3 ORDER BY id DESC LIMIT 1;", array(':weid' => $this->_weid, ':from_user' => $from_user));
    if ($adminschool) { //校区管理员
        $schoolid = intval($adminschool['schoolid']);
        if ($schoolid > 0 && $schoolid == $store['schoolid']) {
            $is_permission = true;
        } else {
            message('对不起，您没有相关的操作权限!!!!');
        }
    } else {
        $accounts = pdo_fetchall("SELECT storeid FROM " . tablename($this->table_account) . " WHERE weid = :weid AND from_user=:from_user AND
 status=2 AND is_admin_order=1 ORDER BY id DESC ", array(':weid' => $this->_weid, ':from_user' => $from_user));
        if ($accounts) {
            $arr = array();
            foreach ($accounts as $key => $val) {
                $arr[] = $val['storeid'];
                $storeid = $val['storeid'];
            }
            $storeids = implode(',', $arr);
            $is_permission = true;

        }
    }
}
if ($is_permission == false) {
    message('对不起，您没有该功能的操作权限!');
}

if ($op == 'display') {
    $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid = :weid And storeid=:storeid ORDER BY parentid ASC, displayorder DESC", array(':weid' => $weid, ':storeid' => $storeid), 'id');

    $strwhere = " where weid=:weid AND deleted=0 AND storeid=:storeid ";
    if (!empty($_GPC['keyword'])) {
        $strwhere .= " AND title LIKE '%{$_GPC['keyword']}%'";
    }
    if ($cid > 0) {
        $strwhere .= " AND pcate = '{$cid}'";
    }

    $restlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " {$strwhere} ORDER BY displayorder DESC, id DESC ", array(':weid' => $weid, ':storeid' => $storeid));
    include $this->template($this->cur_tpl . '/admingoods');
} else if ($op == 'setstatus') {
    $id = intval($_GPC['id']);
    $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" => $id));
    pdo_update($this->table_goods, array('status' => 1 - intval($goods['status'])), array('id' => $id));
    $jump_url = $this->createMobileUrl('admingoods', array('storeid' => $storeid, 'cid' => $cid), true);
    header("location:$jump_url");
} else if ($op == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，商品不存在或是已经删除！', '', 'error');
        } else {
            if (!empty($item['week'])) {
                $weeks = explode(',', $item['week']);
            }
        }

        $optionlist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_goods_option') . " WHERE goodsid=:goodsid order by id", array(':goodsid' => $id));
    }

    $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid = :weid And storeid=:storeid ORDER BY parentid ASC, displayorder DESC", array(':weid' => $weid, ':storeid' => $storeid), 'id');
    if (!empty($category)) {
        $children = '';
        foreach ($category as $key => $cate) {
            if (!empty($cate['parentid'])) {
                $children[$cate['parentid']][$cate['id']] = array($cate['id'], $cate['name']);
            }
        }
    }

    if (checksubmit('submit')) {
        $data = array(
            'weid' => intval($weid),
            'storeid' => $storeid,
            'title' => trim($_GPC['title']),
            'labelid' => 0,
            'pcate' => intval($_GPC['pcate']),
            'ccate' => intval($_GPC['ccate']),
            'week' => '1,2,3,4,5,6,0',
            'unitname' => trim($_GPC['unitname']),
            'description' => trim($_GPC['description']),
            'content' => trim($_GPC['content']),
            'sales' => intval($_GPC['sales']),
            'isoptions' => intval($_GPC['isoptions']),
            'displayorder' => intval($_GPC['displayorder']),
            'marketprice' => floatval($_GPC['marketprice']),
            'memberprice' => !empty($_GPC['memberprice']) ? floatval($_GPC['memberprice']) : '',
            'productprice' => !empty($_GPC['productprice']) ? floatval($_GPC['productprice']) : '',
            'packvalue' => floatval($_GPC['packvalue']),
            'dateline' => TIMESTAMP,
            'startcount' => intval($_GPC['startcount']),
        );

        if (!empty($_FILES['thumb']['name'])) {
            $data['thumb'] = $this->uploadImg('thumb');
        }

        if ($data['startcount'] < 1) {
            message('起售份数不能小于1!');
        }

        if (empty($data['title'])) {
            message('请输入商品名称！');
        }
        if (empty($data['pcate'])) {
            message('请选择商品分类！');
        }

        if (empty($id)) {
            pdo_insert($this->table_goods, $data);
            $id = pdo_insertid();
        } else {
            unset($data['dateline']);
            pdo_update($this->table_goods, $data, array('id' => $id));
        }

        //增加
        if (is_array($_GPC['optiontitle'])) {
            foreach ($_GPC['optiontitle'] as $nid => $val) {
                $optiontitle = trim($_GPC['optiontitle'][$nid]);
                $optionprice = floatval($_GPC['optionprice'][$nid]);
                $optionstart = trim($_GPC['optionstart'][$nid]);
                $optiondisplayorder = intval($_GPC['optiondisplayorder'][$nid]);

                if (empty($optiontitle)) {
                    continue;
                }
                $data = array(
                    'goodsid' => $id,
                    'start' => $optionstart,
                    'title' => $optiontitle,
                    'price' => $optionprice,
                    'displayorder' => $optiondisplayorder
                );
                pdo_insert('weisrc_dish_goods_option', $data);
                $did = pdo_insertid();
                $optionids[] = $did;
            }
        }
        $optionids = implode(',', array_unique($optionids));
        if (!empty($optionids)) {
            pdo_query('delete from ' . tablename('weisrc_dish_goods_option') . " where goodsid = :goodsid and id not in ({$optionids})", array(':goodsid' => $id));
        }

        $url = $this->createMobileUrl('admingoods', array('op' => 'display', 'storeid' => $storeid, 'cid' => $cid), true);
        message('操作成功！', $url, 'success');
    }
    include $this->template($this->cur_tpl . '/admingoods_post');
}

