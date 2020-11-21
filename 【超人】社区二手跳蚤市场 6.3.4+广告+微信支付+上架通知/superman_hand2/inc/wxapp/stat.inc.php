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
$act = in_array($_GPC['act'], array('display'))?$_GPC['act']:'display';
if ($act == 'display') {
    //日浏览量
    $row = pdo_get('superman_hand2_stat', array(
        'uniacid' => $_W['uniacid'],
        'daytime' => date('Ymd'),
    ));
    if (empty($row)) {
        pdo_insert('superman_hand2_stat', array(
            'uniacid' => $_W['uniacid'],
            'daytime' => date('Ymd'),
            'page_view' => 1,
            'dau' => 1,
            'item_submit' => 0,
            'item_trade' => 0,
        ));
    } else {
        $data = array(
            'page_view' => $row['page_view'] + 1,
        );
        //日活跃统计
        if ($_GPC['dau']) {
            $data['dau'] = $row['dau'] + 1;
        }
        pdo_update('superman_hand2_stat', $data, array(
            'id' => $row['id'],
        ));
    }
}
SupermanHandUtil::json(SupermanHandErrno::OK);