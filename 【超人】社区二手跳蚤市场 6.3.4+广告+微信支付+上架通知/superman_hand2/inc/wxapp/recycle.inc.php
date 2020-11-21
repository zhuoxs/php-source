<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$act = in_array($_GPC['act'], array('category', 'form', 'post', 'list', 'detail'))?$_GPC['act']:'display';
if (!$this->module['config']['recycle']['open']) {
    SupermanHandUtil::json(SupermanHandErrno::SYSTEM_ERROR, '未开启预约回收功能');
}
if ($act == 'category') {
    $result = array();
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'pid' => 0,
        'isshow' => 1,
    );
    $orderby = 'displayorder DESC, id DESC';
    $list = SupermanHandUtil::get_recycle_categorys($filter, '', '', $orderby);
    if (!empty($list)) {
        foreach ($list as $li) {
            $item = array(
                'id' => $li['id'],
                'title' => $li['title'],
            );
            if (isset($li['children'])) {
                $children = array();
                foreach ($li['children'] as $a) {
                    $children[] = array(
                        'id' => $a['id'],
                        'title' => $a['title'],
                        'price' => $a['price'],
                        'isPrice' => floatval($a['price'])>0?true:false,
                        'unit' => $a['unit'],
                        'cover' => tomedia($a['cover']),
                    );
                }
                $item['children'] = $children;
            }
            $result['categorys'][] = $item;
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'form') {
    $result = array();
    $form_fields = $this->module['config']['recycle']['form_fields'];
    $region = $this->module['config']['recycle']['region'];
    $region = $region?array($region['province'], $region['city'], $region['district']):array();
    $result['form_fields'] = $form_fields?iunserializer($form_fields):array();
    $result['region'] = $region;
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'post') {
    $contact = $_GPC['contact'];
    if ($contact == '') {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '请输入联系人');
    }
    $mobile = $_GPC['mobile'];
    if ($mobile == '') {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '请输入手机号');
    }
    $province = $_GPC['province'];
    $city = $_GPC['city'];
    $district = $_GPC['district'];
    if ($province.$city.$district == '') {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '请选择地区');
    }
    $address = $_GPC['address'];
    if ($address == '') {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '请输入详细地址');
    }
    //自定义表单
    $fields = array();
    $field_value = base64_decode($_GPC['fields']);
    $fields_value = json_decode(urldecode($field_value), true);
    if (!empty($fields_value)) {
        foreach ($this->module['config']['recycle']['form_fields'] as $key => $val) {
            if ($val['required'] == 1) { //判断是否必填
                if (!isset($fields_value[$key])
                    || $fields_value[$key] == ''
                    || $fields_value[$key] == array()) {
                    SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '请输入'.$val['title']);
                }
            }
            if (empty($fields_value[$key])) {
                continue;
            }
            if (strpos($fields_value[$key], ',') !== false) {
                $fields_value[$key] = explode(',', $fields_value[$key]);
            }
            if ($val['type'] == 'checkbox' && !is_array($fields_value[$key])) {
                $fields_value[$key] = array($fields_value[$key]);
            }
            $fields[$key] = array(
                'title' => $val['title'],
                'type' => $val['type'],
                'required' => $val['required'],
                'value' => $fields_value[$key],
                'extra' => $val['extra'],
            );
        }
    }
    //--end
    $data = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'contact' => $contact,
        'mobile' => $mobile,
        'province' => $province,
        'city' => $city,
        'district' => $district,
        'address' => $address,
        'form_fields' => $fields?iserializer($fields):'',
        'dateline' => TIMESTAMP,
    );
    $ret = pdo_insert('superman_hand2_recycle', $data);
    if ($ret === false) {
        WeUtility::logging('fatal', 'insert failed: '.var_export(pdo_delete(false), true));
        SupermanHandUtil::json(SupermanHandErrno::SYSTEM_ERROR);
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
} else if ($act == 'list') {
    $result = array();
    $page = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    );
    $orderby = 'id DESC';
    $result['list'] = pdo_getall('superman_hand2_recycle', $filter, '', '', $orderby, array($page, $pagesize));
    if (!empty($result['list'])) {
        foreach ($result['list'] as &$li) {
            $li['form_fields'] = $li['form_fields']?iunserializer($li['form_fields']):array();
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'detail') {
    $result = array();
    $id = intval($_GPC['id']);
    $filter = array(
        'id' => $id,
        'uid' => $_W['member']['uid'],
    );
    $detail = pdo_get('superman_hand2_recycle', $filter);
    if (empty($detail)) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '记录不存在或已删除');
    }
    $detail['form_fields'] = $detail['form_fields']?iunserializer($detail['form_fields']):array();
    $result['detail'] = $detail;
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
}
