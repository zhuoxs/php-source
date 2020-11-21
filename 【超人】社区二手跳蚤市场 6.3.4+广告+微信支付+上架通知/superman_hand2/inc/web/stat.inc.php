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
$act = in_array($_GPC['act'], array('display', 'open'))?$_GPC['act']:'display';
$title = '数据统计';
if ($act == 'display') {
    $scroll = intval($_GPC['scroll']);
    $st = $_GPC['datelimit']['start'] ? strtotime($_GPC['datelimit']['start']) : strtotime('-30day');
    $et = $_GPC['datelimit']['end'] ? strtotime($_GPC['datelimit']['end']) : strtotime(date('Y-m-d 23:59:59'));
    $starttime = min($st, $et);
    $endtime = max($st, $et);
    $list = superman_hand2_stat($starttime, $endtime);
    if ($_W['isajax']) {
        echo json_encode($list);
        exit;
    }
} else if ($act == 'open') {
    $row = pdo_get('modules_bindings', array(
        'module' => 'superman_hand2',
        'entry' => 'menu',
        'do' => 'stat',
    ));
    if (empty($row)) {
        pdo_insert('modules_bindings', array(
            'module' => 'superman_hand2',
            'entry' => 'menu',
            'title' => '数据统计',
            'do' => 'stat',
        ));
        $eid = pdo_insertid();
    } else {
        $eid = $row['eid'];
    }
    isetcookie('superman_hand2_stat_'.$_W['uniacid'], null, -1);
    itoast('开启成功！', $this->createWebUrl('stat', array(
        'eid' => $eid,
        'version_id' => 0,
    )), 'success');
}
include $this->template($this->web_template_path);

function superman_hand2_stat($starttime, $endtime) {
    global $_W;
    $list = array();
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'daytime >=' => date('Ymd', $starttime),
        'daytime <=' => date('Ymd', $endtime),
    );
    $data = pdo_getall('superman_hand2_stat', $filter, '', 'daytime');
    for ($i = $starttime; $i <= $endtime; $i += (24*3600)) {
        if ($i == $starttime) {          //每日开始时间戳
            $t1 = $i;
        } else {
            $t1 = strtotime(date('Y-m-d 0:0:0', $i));
        }
        //$t2 = strtotime(date('Y-m-d 23:59:59', $i));
        $daytime = date('Ymd', $t1);

        //日期
        $list['label'][] = date('m-d', $t1);

        $list['datasets']['flow1'][] = isset($data[$daytime]['page_view'])?$data[$daytime]['page_view']:0;
        $list['datasets']['flow2'][] = isset($data[$daytime]['dau'])?$data[$daytime]['dau']:0;
        $list['datasets']['flow3'][] = isset($data[$daytime]['item_submit'])?$data[$daytime]['item_submit']:0;
        $list['datasets']['flow4'][] = isset($data[$daytime]['item_trade'])?$data[$daytime]['item_trade']:0;
    }
    return $list;
}