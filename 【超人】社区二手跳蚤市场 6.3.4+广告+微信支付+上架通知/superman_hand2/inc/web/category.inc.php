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
$title = '分类管理';
if ($act == 'display') {
    if (checksubmit()) {
        if ($_GPC['displayorder']) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                pdo_update('superman_hand2_category', array('displayorder' => $val), array('id' => $id));
            }
            itoast('操作成功！', referer(), 'success');
        }
    }
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    $total = pdo_getcolumn('superman_hand2_category', $filter, 'COUNT(*)');
    $orderby = 'displayorder DESC';
    $list = pdo_getall('superman_hand2_category', $filter, '*', '', $orderby, array($pindex, $pagesize));
    $pager = pagination($total, $pindex, $pagesize);
} else if ($act == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $category = pdo_get('superman_hand2_category', array('id' => $id));
    }
    if (checksubmit()) {
        $title = $_GPC['title'];
        if (empty($title)) {
            itoast('请输入名称！', 'referer', 'error');
        }
        if (empty($_GPC['cover'])) {
            itoast('请选择分类图片！', 'referer', 'error');
        }
        $data = array(
            'title' => $title,
            'cover' => $_GPC['cover'],
            'displayorder' => intval($_GPC['displayorder']),
            'status' => $_GPC['status']?1:0,
        );
        if (empty($category)) {
            $data['uniacid'] = $_W['uniacid'];
            pdo_insert('superman_hand2_category', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                itoast('数据库添加失败！', '', 'error');
            }
        } else {
            $ret = pdo_update('superman_hand2_category', $data, array('id' => $id));
            if ($ret === false) {
                itoast('数据库更新失败！', '', 'error');
            }
        }
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('category').'&version_id='.$_GPC['version_id'];
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $ret = pdo_delete('superman_hand2_category', array('id' => $id));
    if ($ret === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    pdo_update('superman_hand2_item', array('cid' => 0), array('cid' => $id));
    itoast('操作成功！', 'referer', 'success');
}
include $this->template($this->web_template_path);