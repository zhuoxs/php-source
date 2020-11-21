<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {


} else if ($operation == 'display_table') {
    $keyword = $_GPC['keyword'];

    $condition = ' AND uniacid=:uniacid ';
    $params = array(':uniacid' => $_W['uniacid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;

    if ($keyword != '') {
        // $tmp = json_encode($keyword);
        $tmp = $keyword;
        $tmp = ltrim($tmp, '"');
        $tmp = rtrim($tmp, '"');
        // $tmp = str_replace('\\', '\\\\', $tmp);
        $condition .= ' AND (nicename LIKE :nicename) ';
        $params[':nicename'] = '%'.$tmp.'%';
    }

    $sql = "SELECT * FROM " . tablename('slwl_aicard_users'). ' WHERE 1 '
        . $condition . " ORDER BY addtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    if ($list) {
        foreach ($list as $k => $v) {
            $list[$k]['avatar_url'] = tomedia($v['avatar']);
            $list[$k]['gender_format'] = $v['gender']?($v['gender']=='1'?'男':'女'):'未知';
            $list[$k]['nicename_format'] = json_decode($v['nicename']);

            if ($v['mobile'] == '') {
                $list[$k]['mobile'] = '暂无';
            }
        }
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition, $params);
        // $pager = pagination($total, $pindex, $psize);

    }
    $data_return = array(
        'code' => '0',
        'msg' => '',
        'count' => $total,
        'data' => $list,
    );
    echo json_encode($data_return);
    exit;


} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    if ($_W['ispost']) {
        $data = array(
            'mark' => $_GPC['mark'],
        );
        if ($id) {
            pdo_update('slwl_aicard_users', $data, array('id' => $id));
        }
        iajax(0, '保存成功');
        exit;
    }
    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
    $one = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . " where 1 " . $condition, $params);



} elseif ($operation == 'export') {
    $timestart = date('Y-m-d', time());
    $timeend = date('Y-m-d', time());


} elseif ($operation == 'export_post') {
    $time_start = $_GPC['timestart'];
    $time_end = $_GPC['timeend'];

    if (empty($time_start) || empty($time_end)) {
        message('时间段不能为空');
        exit;
    }

    // 读取记录
    $condition = " AND uniacid=:uniacid AND addtime>=:time_start AND addtime<=:time_end ";
    $params = array(':uniacid' => $_W['uniacid'], ':time_start'=>$time_start, ':time_end'=>$time_end);
    $pindex = 1;
    $psize = 5000;
    $sql = "SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 '
        . $condition . " ORDER BY addtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
    $list = pdo_fetchall($sql, $params);

    if ($list) {
        foreach ($list as $k => $v) {
            $list[$k]['nickname'] = json_decode($v['nicename']);
        }
    }
    // dump($list);exit;

    require_once MODULE_ROOT . "/lib/PHPExcel/PHPExcel.php";
    require_once MODULE_ROOT . "/lib/PHPExcel/ExcelHelper.php";

    //导出Excel
    $xlsName = '客户统计';
    $xlsCell = array(
        array('nickname', '昵称'),
        array('mobile', '手机'),
        array('source_txt', '来源'),
        array('addtime', '时间'),
        array('mark', '备注'),
    );

    $myExcel = new \ExcelHelper();

    // $myExcel->exportExcel($xlsName, $xlsCell, $xlsData);
    $myExcel->exportExcel($xlsName, $xlsCell, $list);

    exit;


} else {
    message('请求方式不存在');
}

include $this->template('web/user_list');

?>