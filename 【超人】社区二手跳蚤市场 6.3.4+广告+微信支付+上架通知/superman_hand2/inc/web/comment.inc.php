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
$title = '留言管理';
if ($act == 'display') {
    //搜索
    $name = trim($_GPC['nickname']);
    $item_title = trim($_GPC['title']);
    $message = trim($_GPC['content']);
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    if (!empty($name)) {
        $users = pdo_getall('mc_members', array('nickname LIKE' => "%{$name}%"));
        if (!empty($users)) {
            $arr = array();
            foreach ($users as $li) {
                $arr[] = $li['uid'];
            }
            $filter['uid'] = $arr;
        }
    }
    if (!empty($item_title)) {
        $items = pdo_getall('superman_hand2_item', array('uniacid' => $_W['uniacid'], 'title LIKE' => "%{$item_title}%"));
        if (!empty($items)) {
            $arr = array();
            foreach ($items as $li) {
                $arr[] = $li['id'];
            }
            $filter['item_id'] = $arr;
        }
    }
    if (!empty($message)) {
        $filter['message LIKE'] = "%{$message}%";
    }
    $status = in_array($_GPC['status'], array('0', '1', '2', 'all'))?$_GPC['status']:'all';
    if ($status != 'all') {
        $filter['status'] = $status;
    }
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $total = pdo_getcolumn('superman_hand2_comment', $filter, 'COUNT(*)');
    $orderby = 'createtime DESC';
    $list = pdo_getall('superman_hand2_comment', $filter, '*', '', $orderby, array($pindex, $pagesize));
    $pager = pagination($total, $pindex, $pagesize);
    if ($list) {
        foreach ($list as &$li) {
            SupermanHandModel::superman_hand2_comment($li);
        }
        unset($li);
    }
    if (checksubmit('batch_submit')) {
        if (empty($_GPC['itemids'])) {
            itoast('未选择条目', referer(), 'error');
        }
        $itemids = $_GPC['itemids'];
        $batch_operate = $_GPC['batch_submit'];
        foreach ($itemids as $itemid) {
            if ($batch_operate == '批量审核通过') {
                $ret = pdo_update('superman_hand2_comment', array('status' => 1), array('id' => $itemid));
                if ($ret === false) {
                    itoast('数据库更新失败！', '', 'error');
                }
            } else {
                $ret = pdo_delete('superman_hand2_comment', array('id' => $itemid));
                if ($ret === false) {
                    itoast('数据库删除失败！', '', 'error');
                }
            }
        }
        $url = $this->createWebUrl('comment');
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'post') {
    $id = $_GPC['id'];
    $status = $_GPC['status'];
    if (!empty($id) && !empty($status)) {
        $data = array(
            'status' => $status
        );
        $ret = pdo_update('superman_hand2_comment', $data, array('uniacid' => $_W['uniacid'], 'id' => $id));
        if ($ret === false) {
            itoast('数据库更新失败！', '', 'error');
        }
        $url = $this->createWebUrl('comment');
        itoast('操作成功！', $url, 'success');
    }
    if (!empty($id)) {
        $detail = pdo_get('superman_hand2_comment', array('id' => $id));
        $item = pdo_get('superman_hand2_item', array('id' => $detail['item_id'], 'uniacid' => $_W['uniacid']));
        $detail['item_title'] = $item['title'];
    }
    if (checksubmit()) {
        $data = array(
            'status' => intval($_GPC['status']),
        );
        $ret = pdo_update('superman_hand2_comment', $data, array('id' => $id));
        if ($ret === false) {
            itoast('数据库更新失败！', '', 'error');
        }
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('comment').'&version_id='.$_GPC['version_id'];
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $ret = pdo_delete('superman_hand2_comment', array('id' => $id));
    if ($ret === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    itoast('操作成功！', 'referer', 'success');
}
include $this->template($this->web_template_path);