<?php
global $_GPC, $_W;
$weid = $this->_weid;
$from_user = $this->_fromuser;

$title = '微点餐';
$num = intval($_GPC['num']);
if ($num <= 0) {
    message('非法参数');
}
$storeid = intval($_GPC['storeid']);
if (empty($storeid)) {
    message('请先选择门店', $this->createMobileUrl('waprestlist'), true);
}
$mode = intval($_GPC['mode']);
if ($mode == 0) {
    message('请先选择下单模式', $this->createMobileUrl('detail', array('id' => $storeid)));
}
$tablesid = intval($_GPC['tablesid']);
if ($mode == 1) {
    if ($tablesid == 0) {
        message('桌号不存在!', $this->createMobileUrl('detail', array('id' => $storeid)));
    }
}

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'wapselectlist'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode, 'tablesid' => $tablesid), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode, 'tablesid' => $tablesid), true);
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

$intelligent_count = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_intelligent) . " WHERE name=:name AND weid=:weid AND storeid=:storeid", array(':name' => $num, ':weid' => $weid, ':storeid' => $storeid));

//智能菜单id
$intelligentid = intval($_GPC['intelligentid']);
if ($intelligent_count > 1) {
    //随机抽取推荐菜单
    $intelligent = pdo_fetch("SELECT * FROM " . tablename($this->table_intelligent) . " WHERE name=:name AND weid=:weid AND storeid=:storeid AND id<>:id ORDER BY RAND() limit 1", array(':name' => $num, ':weid' => $weid, ':storeid' => $storeid, ':id' => $intelligentid));
} else {
    $intelligent = pdo_fetch("SELECT * FROM " . tablename($this->table_intelligent) . " WHERE name=:name AND weid=:weid AND storeid=:storeid ORDER BY RAND() limit 1", array(':name' => $num, ':weid' => $weid, ':storeid' => $storeid));
}

$iscard = $this->get_sys_card($from_user);
//随机套餐id
$intelligentid = intval($intelligent['id']);

//读取相关产品
$goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE FIND_IN_SET(id, '{$intelligent['content']}') AND weid=:weid AND storeid=:storeid", array(':weid' => $weid, ':storeid' => $storeid));

$total_money = 0;
foreach ($goods as $key => $value) {
    $goods_arr[$value['id']] = array(
        'id' => $value['id'],
        'pcate' => $value['pcate'],
        'title' => $value['title'],
        'thumb' => $value['thumb'],
        'isspecial' => $value['isspecial'],
        'productprice' => $value['productprice'],
        'memberprice' => $value['memberprice'],
        'unitname' => $value['unitname'],
        'marketprice' => $value['marketprice'],
        'subcount' => $value['subcount'],
        'taste' => $value['taste'],
        'description' => $value['description']);
    $goods_tmp[] = $value['pcate'];
    $total_money += floatval($value['marketprice']);
}
$condition = trim(implode(',', $goods_tmp));
//读取类别
$categorys = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid=:weid AND storeid=:storeid AND FIND_IN_SET(id, '{$condition}') ORDER BY displayorder DESC", array(':weid' => $weid, ':storeid' => $storeid));
include $this->template($this->cur_tpl . '/select_list');