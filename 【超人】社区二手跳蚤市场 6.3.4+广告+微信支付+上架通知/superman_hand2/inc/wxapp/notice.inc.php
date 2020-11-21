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
    'detail',
    'formid',  //收集用户formid
))?$_GPC['act']:'detail';
if ($act == 'detail') {
    $id = $_GPC['id'];
    if (empty($id)) {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '', 'error');
    }
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'id' => $id
    );
    $detail = pdo_get('superman_hand2_notice', $filter);
    $detail['content'] = htmlspecialchars_decode($detail['content']);
    $detail['createtime'] = $detail['createtime']?date('Y-m-d H:i:s', $detail['createtime']):'';
    //获取点击量
    pdo_update('superman_hand2_notice', array(
        'count +=' => 1,
    ), array('id' => $id));
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $detail);
} else if ($act == 'formid') {
    $formid = $_GPC['formid'];
    if ($formid == 'the formId is a mock one') {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '', 'error');
    }
    //过滤掉过期数据
    pdo_delete('superman_hand2_member_formid', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'createtime <' => TIMESTAMP - 7*24*3600,
    ));
    //过滤重复formid
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'formid' => $formid,
    );
    $row = pdo_get('superman_hand2_member_formid', $filter);
    if ($row) {
        pdo_delete('superman_hand2_member_formid', array(
            'id' => $row['id'],
        ));
    }
    //添加新的formid
    $data = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'formid' => $formid,
        'createtime ' => TIMESTAMP,
    );
    pdo_insert('superman_hand2_member_formid', $data);
    $new_id = pdo_insertid();
    if (empty($new_id)) {
        SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL);
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
}