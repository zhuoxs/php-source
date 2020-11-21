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
$act = in_array($_GPC['act'], array('display', 'post', 'delete', 'category'))?$_GPC['act']:'display';
$title = '预约回收';
if ($_W['account']['type'] != ACCOUNT_TYPE_APP_NORMAL) { //非小程序
    itoast('该功能仅支持小程序平台', '', 'error');
}
if ($act == 'display') {
    $page = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    if (!empty($_GPC['mobile'])) {
        $filter['mobile LIKE'] = "%{$_GPC['mobile']}%";
    }
    if (isset($_GPC['status']) && $_GPC['status'] != -1) {
        $filter['status'] = $_GPC['status'];
    }
    $total = pdo_getcolumn('superman_hand2_recycle', $filter, 'COUNT(*)');
    $orderby = 'id DESC';
    $list = pdo_getall('superman_hand2_recycle', $filter, '', '', $orderby, array($page, $pagesize));
    if (!empty($list)) {
        foreach ($list as &$li) {
            $li['form_fields'] = $li['form_fields']?iunserializer($li['form_fields']):array();
        }
        unset($li);
    }
    $pager = pagination($total, $page, $pagesize);
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $ret = pdo_delete('superman_hand2_recycle', array('id' => $id));
    if ($ret === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    itoast('操作成功！', 'referer', 'success');

} else if ($act == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_get('superman_hand2_recycle', array('id' => $id));
    if (empty($item)) {
        itoast('非法请求！', '', 'error');
    }
    $item['form_fields'] = $item['form_fields']?iunserializer($item['form_fields']):array();
    if ($item['form_fields']) {
        foreach ($item['form_fields'] as &$field) {
            if ($field['type'] == 'checkbox' && !is_array($field['value'])) {
                $field['value'] = array($field['value']);
            }
        }
        unset($field);
    }
    if (checksubmit()) {
        $form_fields = _get_form_fields($item['form_fields']);
        $data = array(
            'uniacid' => $_W['uniacid'],
            'contact' => $_GPC['contact'],
            'mobile' => $_GPC['mobile'],
            'province' => $_GPC['province'],
            'city' => $_GPC['city'],
            'district' => $_GPC['address'],
            'address' => $_GPC['address'],
            'status' => $_GPC['status'],
            'form_fields' => $form_fields?iserializer($form_fields):'',
        );
        /*print_r($form_fields);
        print_r($data);
        die;*/
        pdo_update('superman_hand2_recycle', $data, array('id' => $id));
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('recycle', array(
                'act' => 'display',
            )).'&version_id='.$_GPC['version_id'];
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'category') {
    $op = $_GPC['op'];
    if ($op == 'display') {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'pid' => 0,
        );
        $orderby = 'displayorder DESC, id DESC';
        $list = SupermanHandUtil::get_recycle_categorys($filter, '', '', $orderby);
        if (!empty($list)) {
            foreach ($list as &$li) {
                if (!empty($li['children'])) {
                    foreach ($li['children'] as &$ch) {
                        $ch['isPrice'] = floatval($ch['price'])>0?true:false;
                    }
                    unset($ch);
                }
            }
            unset($li);
        }

        //更新排序
        if (checksubmit()) {
            $update_field = array('displayorder');
            foreach ($update_field as $field) {
                if (isset($_GPC[$field])) {
                    foreach ($_GPC[$field] as $id=>$val) {
                        pdo_update('superman_hand2_recycle_category', array($field => $val), array('id' => $id));
                    }
                }
            }
            itoast('更新成功！', '', 'success');
        }
    } else if ($op == 'post') {
        $id = intval($_GPC['id']);
        $pid = intval($_GPC['pid']);
        $item = pdo_get('superman_hand2_recycle_category', array('id' => $id));
        if (checksubmit()) {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'pid' => $pid,
                'title' => $_GPC['title'],
                'cover' => $_GPC['cover'],
                'price' => $_GPC['price'],
                'unit' => $_GPC['unit']?$_GPC['unit']:'公斤',
                'isshow' => $_GPC['isshow'],
            );
            if (!empty($item)) {
                pdo_update('superman_hand2_recycle_category', $data, array('id' => $id));
            } else {
                pdo_insert('superman_hand2_recycle_category', $data);
                $id = pdo_insertid();
            }
            $url = $_W['siteroot'].'web/'.$this->createWebUrl('recycle', array(
                    'act' => 'category',
                    'op' => 'display',
                )).'&version_id='.$_GPC['version_id'];
            itoast('操作成功！', $url, 'success');
        }
    } else if ($op == 'delete') {
        $id = intval($_GPC['id']);
        $item = pdo_get('superman_hand2_recycle_category', array('id' => $id));
        if (empty($item)) {
            itoast('分类不存在或已删除', '', 'error');
        }
        if ($item['pid'] == 0) {
            // 删除子分类
            pdo_delete('superman_hand2_recycle_category', array('pid' => $id));
        }
        pdo_delete('superman_hand2_recycle_category', array('id' => $id));
        itoast('删除成功！', '', 'success');
    }
}
include $this->template($this->web_template_path);

function _get_form_fields(&$form_fields) {
    global $_W, $_GPC;
    if (!empty($_GPC['field'])) {
        foreach ($_GPC['field'] as $k=>$v) {
            if ($form_fields[$k]['type'] == 'checkbox') {
                $form_fields[$k]['value'] = is_array($_GPC['field'][$k])?$_GPC['field'][$k]:array($_GPC['field'][$k]);
            } else {
                $form_fields[$k]['value'] = $_GPC['field'][$k];
            }
        }
    }
    return $form_fields;
}