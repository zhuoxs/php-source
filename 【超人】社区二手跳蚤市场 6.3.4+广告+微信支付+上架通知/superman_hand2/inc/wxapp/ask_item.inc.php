<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = $_GPC['do'];
$act = in_array($_GPC['act'], array(
    'display',  //求购页
    'post',     //提交
    'delete',
))?$_GPC['act']:'display';
if ($act == 'display') {
    $item = pdo_get('superman_hand2_ask_item', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    ));
    $notice_config = $this->plugin_module['plugin_notice']['module']['config'];
    $result = array(
        'item' => $item,
        'rule' => $notice_config['base']['rule']?htmlspecialchars_decode($notice_config['base']['rule']):'',
        'distance' => $notice_config['distance']['value'],
    );
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'post') {
    //检查是否求购过
    $id = intval($_GPC['id']);
    $count = pdo_count('superman_hand2_ask_item', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    ));
    if ($count > 0 && empty($id)) {
        upermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '您已求购过商品');
    }
    $data = array(
        'title' => $_GPC['title'],
        'uid' => $_W['member']['uid'],
        'lng' => $_GPC['lng'],
        'lat' => $_GPC['lat'],
        'address' => $_GPC['address'],
        'distance' => $_GPC['distance'],
        'send_tmpl' => 0,
    );
    //转换坐标
    $location = SupermanHandUtil::location_transition($data['lat'], $data['lng'], $this->module['config']['base']['lbs_key']);
    if ($location) {
        $data['province'] =  $location['province'];
        $data['city'] =  $location['city'];
    }
    if ($id) {
        $ret = pdo_update('superman_hand2_ask_item', $data, array(
            'uniacid' => $_W['uniacid'],
            'id' => $id,
        ));
        if ($ret === false) {
            SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL);
        }
    } else {
        $data['uniacid'] = $_W['uniacid'];
        $data['dateline'] = TIMESTAMP;
        $ret = pdo_insert('superman_hand2_ask_item', $data);
        $newid = pdo_insertid();
        if (empty($newid)) {
            SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL);
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    $ret = pdo_delete('superman_hand2_ask_item', array(
        'uniacid' => $_W['uniacid'],
        'id' => $id,
    ));
    if ($ret === false) {
        SupermanHandUtil::json(SupermanHandErrno::DELETE_FAIL);
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
}