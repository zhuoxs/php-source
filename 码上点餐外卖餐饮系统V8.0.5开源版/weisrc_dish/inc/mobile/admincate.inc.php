<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$storeid = intval($_GPC['storeid']);

$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'admincate'; //method
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
    $accounts = pdo_fetchall("SELECT storeid FROM " . tablename($this->table_account) . " WHERE weid = :weid AND from_user=:from_user AND
 status=2 AND is_admin_order=1 ORDER BY id DESC ", array(':weid' => $this->_weid, ':from_user' => $from_user));
    if ($accounts) {
        $arr = array();
        foreach ($accounts as $key => $val) {
            $arr[] = $val['storeid'];
        }
        $storeids = implode(',', $arr);
        $is_permission = true;
    }
}
if ($is_permission == false) {
    message('对不起，您没有该功能的操作权限!');
}

if ($op == 'display') {
    $strwhere = " where weid=:weid AND storeid=:storeid ";

    $restlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " {$strwhere} ORDER BY displayorder DESC, id DESC ", array(':weid' => $weid, ':storeid' => $storeid));
    include $this->template($this->cur_tpl . '/admincate');
} else if ($op == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_category) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，数据不存在或是已经删除！', '', 'error');
        }
    } else {
        $item = array(
            'displayorder' => 0,
            'is_meal' => 1,
            'is_delivery' => 1,
            'is_snack' => 1,
            'is_reservation' => 1,
            'is_discount'=>0
        );
    }

//    if (!empty($_W['token']) && $_W['token'] == $_GPC['token']) {
    if (checksubmit('submit')) {
        if (empty($_GPC['title'])) {
            message('请输入分类名称！');
        }

        $data = array(
            'weid' => $weid,
            'storeid' => $_GPC['storeid'],
            'name' => $_GPC['title'],
            'displayorder' => intval($_GPC['displayorder']),
            'is_meal' => intval($_GPC['is_meal']),
            'is_delivery' => intval($_GPC['is_delivery']),
            'is_snack' => intval($_GPC['is_snack']),
            'is_reservation' => intval($_GPC['is_reservation']),
            'parentid' => 0,
        );

        if (empty($data['storeid'])) {
            message('非法参数');
        }

        if (!empty($id)) {
            pdo_update($this->table_category, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_category, $data);
            $id = pdo_insertid();
        }

        $url = $this->createMobileUrl('admincate', array('op' => 'display', 'storeid' => $storeid), true);
        message('操作成功！', $url, 'success');
    }
    include $this->template($this->cur_tpl . '/admincate_post');
}

