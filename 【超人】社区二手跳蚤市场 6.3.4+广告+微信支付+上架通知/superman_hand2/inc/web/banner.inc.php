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
$act = in_array($_GPC['act'], array('display', 'post', 'delete'))?$_GPC['act']:'display';
$title = '轮播图管理';
if ($act == 'display') {
    //实时控制状态开关
    if (in_array($_GPC['op'], array('insert', 'delete')) && $_GPC['id'] > 0) {
        $id = $_GPC['id'];
        if ($id <= 0) {
            echo '非法请求';
            exit;
        }
        if ($_GPC['op'] == 'insert') {
            $ret = pdo_update('superman_hand2_banner', array('is_default' => 1), array('id' => $id));
            if ($ret === false) {
                echo 'fail';
            } else {
                echo 'success';
            }
            exit;
        } else if ($_GPC['op'] == 'delete') {
            $ret = pdo_update('superman_hand2_banner', array('is_default' => 0), array('id' => $id));
            if ($ret === false) {
                echo 'fail';
            } else {
                echo 'success';
            }
            exit;
        }
    }
    if (checksubmit()) {
        if ($_GPC['displayorder']) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                pdo_update('superman_hand2_banner', array('displayorder' => $val), array('id' => $id));
            }
            itoast('操作成功！', referer(), 'success');
        }
    }
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'position' => 1
    );
    $total = pdo_getcolumn('superman_hand2_banner', $filter, 'COUNT(*)');
    $orderby = 'displayorder DESC';
    $list = pdo_getall('superman_hand2_banner', $filter, '*', '', $orderby);
    if ($list) {
        foreach ($list as &$row) {
            $row['starttime'] = $row['starttime']?date('Y-m-d H:i:s', $row['starttime']):'';
            $row['endtime'] = $row['endtime']?date('Y-m-d H:i:s', $row['endtime']):'';
        }
        unset($row);
    }
    $pager = pagination($total, $pindex, $pagesize);
    $current_time = date('Y-m-d H:i:s', TIMESTAMP);
} else if ($act == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $banner = pdo_get('superman_hand2_banner', array('id' => $id));
        $banner['thumb'] = tomedia($banner['thumb']);
        $area_points = $banner['area_points'] ? iunserializer($banner['area_points']) : array();
        $exprietime = array(
            'start' => $banner['starttime'] ? date('Y-m-d H:i:s', $banner['starttime']) : date('Y-m-d H:i:s'),
            'end' => $banner['endtime'] ? date('Y-m-d H:i:s', $banner['endtime']) : date('Y-m-d H:i:s', strtotime('+1 week')),
        );
    }
    if (!empty($_GPC['load_url'])) {
        $all_links = SupermanHandUtil::get_links($_W['account']['type']);
        if (!$this->plugin_module['plugin_notice']['module']
            || $this->plugin_module['plugin_notice']['module']['is_delete']) {
            array_splice($all_links, 6, 1);
        }
        echo json_encode($all_links);
        exit;
    }
    if (checksubmit()) {
        if (empty($_GPC['thumb'])) {
            itoast('请选择图片！', 'referer', 'error');
        }
        $data = array(
            'thumb' => $_GPC['thumb'],
            'appid' => $_GPC['appid'],
            'url' => $_GPC['url'],
            'is_default' => $_GPC['is_default'],
            'position' => 1,
            'area_points' => $_GPC['area_points']?iserializer(json_decode(base64_decode($_GPC['area_points']), true)):'',
            'displayorder' => intval($_GPC['displayorder']),
            'starttime' => strtotime($_GPC['exprietime']['start']),
            'endtime' => strtotime($_GPC['exprietime']['end']),
        );
        if (empty($banner)) {
            $data['uniacid'] = $_W['uniacid'];
            pdo_insert('superman_hand2_banner', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                itoast('数据库添加失败！', '', 'error');
            }
        } else {
            $ret = pdo_update('superman_hand2_banner', $data, array('id' => $id));
            if ($ret === false) {
                itoast('数据库更新失败！', '', 'error');
            }
        }
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('banner').'&version_id='.$_GPC['version_id'];
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $ret = pdo_delete('superman_hand2_banner', array('id' => $id));
    if ($ret === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    itoast('操作成功！', 'referer', 'success');
}
include $this->template($this->web_template_path);