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
$title = '公告管理';
if ($act == 'display') {
    if (checksubmit()) {
        if ($_GPC['displayorder']) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                pdo_update('superman_hand2_notice', array('displayorder' => $val), array('id' => $id));
            }
            itoast('操作成功！', referer(), 'success');
        }
    }
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $orderby = 'displayorder DESC';
    $sort = in_array($_GPC['sort'], array('ASC', 'DESC'))?$_GPC['sort']:'';
    if (!empty($sort)){
        $orderby = "count {$sort}, displayorder DESC";
    }
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    $total = pdo_getcolumn('superman_hand2_notice', $filter, 'COUNT(*)');
    $list = pdo_getall('superman_hand2_notice', $filter, '*', '', $orderby, array($pindex, $pagesize));
    if ($list) {
        foreach ($list as &$li) {
            SupermanHandModel::superman_hand2_notice($li);
        }
        unset($li);
    }
    $current_time = date('Y-m-d H:i:s', TIMESTAMP);
    $pager = pagination($total, $pindex, $pagesize);
} else if ($act == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $notice = pdo_get('superman_hand2_notice', array('id' => $id));
        SupermanHandModel::superman_hand2_notice($notice);
        $area_points = $notice['area_points'] ? iunserializer($notice['area_points']) : array();
        $exprietime = array(
            'start' => $notice['starttime'] ? $notice['starttime'] : date('Y-m-d H:i:s'),
            'end' => $notice['endtime'] ? $notice['endtime'] : date('Y-m-d H:i:s', strtotime('+1 week')),
        );
    }
    if (checksubmit()) {
        $title = $_GPC['title'];
        if (empty($title)) {
            itoast('请输入名称！', 'referer', 'error');
        }
        if (empty($_GPC['content'])) {
            itoast('请输入内容！', 'referer', 'error');
        }
        $data = array(
            'title' => $title,
            'content' => $_GPC['content'],
            'displayorder' => intval($_GPC['displayorder']),
            'status' => $_GPC['status']?1:0,
            'starttime' => strtotime($_GPC['exprietime']['start']),
            'endtime' => strtotime($_GPC['exprietime']['end']),
            'title_color' => $_GPC['title_color'],
            'area_points' => $_GPC['area_points']?iserializer(json_decode(base64_decode($_GPC['area_points']), true)):''
        );
        //显示位置
        if (!empty($_GPC['position'])) {
            $data['position'] = implode(',', $_GPC['position']);
        }
        if (empty($notice)) {
            $data['uniacid'] = $_W['uniacid'];
            pdo_insert('superman_hand2_notice', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                itoast('数据库添加失败！', '', 'error');
            }
        } else {
            $ret = pdo_update('superman_hand2_notice', $data, array('id' => $id));
            if ($ret === false) {
                itoast('数据库更新失败！', '', 'error');
            }
        }
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('notice').'&version_id='.$_GPC['version_id'];
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $ret = pdo_delete('superman_hand2_notice', array('id' => $id));
    if ($ret === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    itoast('操作成功！', 'referer', 'success');
}
include $this->template($this->web_template_path);