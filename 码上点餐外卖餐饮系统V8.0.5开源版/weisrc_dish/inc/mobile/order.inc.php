<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$sid = intval($_GPC['sid']);
$cur_nave = 'order';
$status = 0;

if (!empty($_GPC['status'])) {
    $status = intval($_GPC['status']);
}

$is_permission = false;
$tousers = explode(',', $setting['tpluser']);
if (in_array($from_user, $tousers)) {
    $is_permission = true;
}
if ($is_permission == false) {
    $accounts = pdo_fetchall("SELECT storeid FROM " . tablename($this->table_account) . " WHERE weid = :weid AND from_user=:from_user AND
 status=2 ORDER BY id DESC ", array(':weid' => $this->_weid, ':from_user' => $from_user));
    if ($accounts) {
        $arr = array();
        foreach ($accounts as $key => $val) {
            $arr[] = $val['storeid'];
        }
        $storeids = implode(',', $arr);
        $is_permission = true;
    }
}

$do = 'order';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'order'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array(), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array(), true);
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


if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

$storelist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid=:weid ORDER BY id DESC ", array(':weid' => $weid), 'id');

if ($_GPC['ispay'] == 1) {
    $strwhere = " AND a.status=0 AND a.ispay=1 ";
}

$order_list = pdo_fetchall("SELECT a.* FROM " . tablename($this->table_order) . " AS a LEFT JOIN " . tablename($this->table_stores) . " AS b ON a.storeid=b.id  WHERE a.weid = '{$weid}' AND a.from_user='{$from_user}' {$strwhere}  ORDER BY a.id DESC LIMIT 30");
//数量
$order_total = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . " WHERE status=1 AND from_user='{$from_user}' ORDER BY id DESC");
foreach ($order_list as $key => $value) {
    $order_list[$key]['goods'] = pdo_fetchall("SELECT a.*,b.title FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.weid = '{$weid}' and a.orderid={$value['id']}");

    if ($value['dining_mode'] == 1 || $value['dining_mode'] == 3) {
        $tablesid = intval($value['tables']);
        $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));
        if (!empty($table)) {
            $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $table['tablezonesid']));
//            if (empty($tablezones)) {
//                exit('餐桌类型不存在！');
//            }
            $table_title = $tablezones['title'] . '-' . $table['title'];
            $order_list[$key]['table_title'] = $table_title;

        }
    }
}

include $this->template($this->cur_tpl . '/order');