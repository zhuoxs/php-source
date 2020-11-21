<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update('cyl_vip_video_category', array('displayorder' => $displayorder), array('id' => $id, 'uniacid' => $_W['uniacid']));
        }
        message('分类排序更新成功！', $this->createWebUrl('category', array('op' => 'display')), 'success');
    }
    $children = array();
     $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid']), 'id');
    foreach ($category as $index => $row) {
        if (!empty($row['parentid'])) {
            $children[$row['parentid']][] = $row;
            unset($category[$index]);
        }
    }
    include $this->template('category');
} elseif ($operation == 'post') {
    $parentid = intval($_GPC['parentid']);
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $category = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_category') . " WHERE id = :id AND uniacid = :weid", array(':id' => $id, ':weid' => $_W['uniacid']));
    } else {
        $category = array(
            'displayorder' => 0, 
        );
    }
    if (!empty($parentid)) {
        $parent = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_category') . " WHERE id = :id ", array(':id' => $parentid));
        if (empty($parent)) {
            message('抱歉，上级分类不存在或是已经被删除！', $this->createWebUrl('post'), 'error');
        }
    }
    if (checksubmit('submit')) {
        if (empty($_GPC['catename'])) {
            message('抱歉，请输入分类名称！');
        }
        $data = array(
            'uniacid' => $_W['uniacid'],
            'name' => $_GPC['catename'],                    
            'url' => $_GPC['url'],                  
            'is_vip' => $_GPC['is_vip'],                    
            'is_nav' => $_GPC['is_nav'],                    
            'status' => $_GPC['status'],                    
            'displayorder' => intval($_GPC['displayorder']),
            'parentid' => intval($parentid),
        );
        if (!empty($id)) {
            unset($data['parentid']);
            pdo_update('cyl_vip_video_category', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
            load()->func('file');
            file_delete($_GPC['thumb_old']);
        } else {
            pdo_insert('cyl_vip_video_category', $data);
            $id = pdo_insertid();
        }
        message('更新分类成功！', $this->createWebUrl('category', array('op' => 'display')), 'success');
    }
    include $this->template('category');
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);      
    $category = pdo_fetch("SELECT id, parentid FROM " . tablename('cyl_vip_video_category') . " WHERE id = :id ",array(':id'=>$id));
    if (empty($category)) {
        message('抱歉，分类不存在或是已经被删除！', $this->createWebUrl('category', array('op' => 'display')), 'error');
    }
    pdo_delete('cyl_vip_video_category', array('id' => $id, 'parentid' => $id), 'OR');
    message('分类删除成功！', $this->createWebUrl('category', array('op' => 'display')), 'success');
}