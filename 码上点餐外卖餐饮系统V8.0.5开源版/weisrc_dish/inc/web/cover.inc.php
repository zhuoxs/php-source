<?php
defined('IN_IA') or exit('Access Denied');
load()->model('reply');
load()->model('module');

global $_GPC, $_W;
$weid = $this->_weid;
$GLOBALS['frames'] = $this->getMainMenu();

$do = $_GPC['op'];
$dos = array('mymemberlist','index','order','usercenter','waprestList','adminorder','savewineform','deliveryorder', 'adscreen');
if (!in_array($do, $dos)) {
    message('参数错误');
}
$entrys = array(
    'index' => array(
        'title' => '首页',
        'do' => 'index',
        'module' => 'weisrc_dish',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'index', 'm' => 'weisrc_dish')),
        'url_show' => murl('entry', array('m' => 'weisrc_dish', 'do' => 'index'), true, true)
    ),
    'waprestList' => array(
        'title' => '门店列表',
        'do' => 'waprestList',
        'module' => 'weisrc_dish',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'waprestList', 'm' => 'weisrc_dish')),
        'url_show' => murl('entry', array('m' => 'weisrc_dish', 'do' => 'waprestList'), true, true)
    ),
    'order' => array(
        'title' => '我的订单',
        'do' => 'order',
        'module' => 'weisrc_dish',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'order', 'm' => 'weisrc_dish')),
        'url_show' => murl('entry', array('m' => 'weisrc_dish', 'do' => 'order'), true, true)
    ),
    'usercenter' => array(
        'title' => '用户中心',
        'do' => 'usercenter',
        'module' => 'weisrc_dish',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'usercenter', 'm' => 'weisrc_dish')),
        'url_show' => murl('entry', array('m' => 'weisrc_dish', 'do' => 'usercenter'), true, true)
    ),
    'mymemberlist' => array(
        'title' => '我邀请的好友',
        'do' => 'mymemberlist',
        'module' => 'weisrc_dish',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'mymemberlist', 'm' => 'weisrc_dish')),
        'url_show' => murl('entry', array('m' => 'weisrc_dish', 'do' => 'mymemberlist'), true, true)
    ),
    'adminorder' => array(
        'title' => '商家订单管理',
        'do' => 'adminorder',
        'module' => 'weisrc_dish',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'adminorder', 'm' => 'weisrc_dish')),
        'url_show' => murl('entry', array('m' => 'weisrc_dish', 'do' => 'adminorder'), true, true)
    ),
    'deliveryorder' => array(
        'title' => '配送订单管理',
        'do' => 'adminorder',
        'module' => 'weisrc_dish',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'deliveryorder', 'm' => 'weisrc_dish')),
        'url_show' => murl('entry', array('m' => 'weisrc_dish', 'do' => 'deliveryorder'), true, true)
    ),
    'savewineform' => array(
        'title' => '酒水寄存',
        'do' => 'savewineform',
        'module' => 'weisrc_dish',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'savewineform', 'm' => 'weisrc_dish')),
        'url_show' => murl('entry', array('m' => 'weisrc_dish', 'do' => 'savewineform'), true, true)
    ),
    'adscreen' => array(
        'title' => '全屏广告',
        'do' => 'adscreen',
        'module' => 'weisrc_dish',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'adscreen', 'm' => 'weisrc_dish')),
        'url_show' => murl('entry', array('m' => 'weisrc_dish', 'do' => 'adscreen'), true, true)
    )
);
$entry = $entrys[$do];
$sql = "SELECT * FROM " . tablename('cover_reply') . ' WHERE `module` = :module AND `do` = :do AND uniacid = :uniacid AND multiid = :multiid';
$pars = array();
$pars[':module'] = 'weisrc_dish';
$pars[':do'] = $do;
$pars[':uniacid'] = $_W['uniacid'];
$pars[':multiid'] = 0;
$cover = pdo_fetch($sql, $pars);

if(!empty($cover)) {
    $cover['saved'] = true;
    if(!empty($cover['thumb'])) {
        $cover['src'] = tomedia($cover['thumb']);
    }
    $cover['url_show'] = $entry['url_show'];
    $reply = reply_single($cover['rid']);
    $entry['title'] = $cover['title'];
} else {
    $cover['title'] = $entry['title'];
    $cover['url_show'] = $entry['url_show'];
}

if(empty($reply)) {
    $reply = array();
}

if (checksubmit('submit')) {
    if(trim($_GPC['keywords']) == '') {
        message('必须输入触发关键字.');
    }
    $rule = array(
        'uniacid' => $_W['uniacid'],
        'name' => $entry['title'],
        'module' => 'cover',
        'status' => 1,
    );
    if(!empty($_GPC['istop'])) {
        $rule['displayorder'] = 255;
    } else {
        $rule['displayorder'] = range_limit($_GPC['displayorder'], 0, 254);
    }
    if (!empty($reply)) {
        $rid = $reply['id'];
        $result = pdo_update('rule', $rule, array('id' => $rid));
    } else {
        $result = pdo_insert('rule', $rule);
        $rid = pdo_insertid();
    }

    if (!empty($rid)) {
        $sql = 'DELETE FROM '. tablename('rule_keyword') . ' WHERE `rid`=:rid AND `uniacid`=:uniacid';
        $pars = array();
        $pars[':rid'] = $rid;
        $pars[':uniacid'] = $_W['uniacid'];
        pdo_query($sql, $pars);

        $rowtpl = array(
            'rid' => $rid,
            'uniacid' => $_W['uniacid'],
            'module' => 'cover',
            'status' => 1,
            'displayorder' => $rule['displayorder'],
            'type' => 1,
            'content' => $_GPC['keywords']
        );
        pdo_insert('rule_keyword', $rowtpl);

        $entry = array(
            'uniacid' => $_W['uniacid'],
            'multiid' => 0,
            'rid' => $rid,
            'title' => $_GPC['title'],
            'description' => $_GPC['description'],
            'thumb' => $_GPC['thumb'],
            'url' => $entry['url'],
            'do' => $entry['do'],
            'module' => $entry['module'],
        );
        if (empty($cover['id'])) {
            pdo_insert('cover_reply', $entry);
        } else {
            pdo_update('cover_reply', $entry, array('id' => $cover['id']));
        }
        message('封面保存成功!！', 'refresh', 'success');
    } else {
        message('封面保存失败, 请联系网站管理员！');
    }
}
include $this->template('web/cover');