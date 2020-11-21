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
$act = in_array($_GPC['act'], array(
    'display',
    'post',
    'delete',
))?$_GPC['act']:'display';
$title = '付费位置';
$credit_title = SupermanHand2PluginAdUtil::get_credit_titles();
if ($act == 'display') {
    //实时控制状态开关
    if (in_array($_GPC['op'], array('insert', 'delete')) && $_GPC['id'] > 0) {
        $id = $_GPC['id'];
        if ($id <= 0) {
            echo '非法请求';
            exit;
        }
        if ($_GPC['op'] == 'insert') {
            pdo_update('superman_hand2_pay_position', array('status' => 1), array('id' => $id));
            itoast('操作成功！', referer(), 'success');
        } else if ($_GPC['op'] == 'delete') {
            pdo_update('superman_hand2_pay_position', array('status' => 0), array('id' => $id));
            itoast('操作成功！', referer(), 'success');
        }
    }
    //更新排序
    if (checksubmit()) {
        if ($_GPC['displayorder']) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                pdo_update('superman_hand2_pay_position', array('displayorder' => $val), array('id' => $id));
            }
            itoast('操作成功！', referer(), 'success');
        }
    }
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $total = pdo_getcolumn('superman_hand2_pay_position', $filter, 'COUNT(*)');
    if ($total) {
        $orderby = 'displayorder DESC, createtime DESC';
        $list = pdo_getall('superman_hand2_pay_position', $filter, '*', '', $orderby, array($pindex, $pagesize));
        $pager = pagination($total, $pindex, $pagesize);
        if ($list) {
            foreach ($list as &$li) {
                $li['fields'] = $li['fields']?unserialize($li['fields']):array();
                $li['area'] = implode('', explode(',', $li['area']));
            }
            unset($li);
        }
    }
} else if ($act == 'post') {
    //加载表单模板
    if (isset($_GPC['load']) && $_GPC['load'] == 'fields') {
        include $this->template("web/{$do}/fields-new");
        exit();
    }
    $id = intval($_GPC['id']);
    $item = pdo_get('superman_hand2_pay_position', array('id' => $id));
    if ($item) {
        $item['fields'] = $item['fields']?iunserializer($item['fields']):array();
        $item['area'] = explode(',', $item['area']);
    }
    if (checksubmit()) {
        if (empty($_GPC['area']['district'])) {
            itoast('请选择完整的置顶地区！', '', 'success');
        }
        $data = array(
            'status' => intval($_GPC['status']),
            'displayorder' => intval($_GPC['displayorder']),
            'area' => implode(',', $_GPC['area']),
        );
        $paytype = $_GPC['paytype'];
        if ($paytype['credit'] == 'on' && $paytype['wechat'] == 'on') {
            $data['paytype'] = 0;
        } else {
            $data['paytype'] = $paytype['credit'] == 'on' ? 1 : 2;
        }
        //自定义表单参数
        if (!empty($_GPC['fields'])) {
            $fields = array();
            foreach ($_GPC['fields']['position'] as $key => $value) {
                $arr = array(
                    'position' => $value,
                    'price' => $_GPC['fields']['price'][$key],
                    'credit' => $_GPC['fields']['credit'][$key],
                );
                $fields[] = $arr;
            }
            $data['fields'] = iserializer($fields);
        }
        //设置位置排序
        if (!empty($item)) {
            $ret = pdo_update('superman_hand2_pay_position', $data, array('id' => $item['id']));
            if ($ret === false) {
                itoast('数据库更新失败！', '', 'error');
            }
        } else {
            $ps = pdo_get('superman_hand2_pay_position', array(
                'uniacid' => $_W['uniacid'],
                'displayorder' => intval($_GPC['displayorder'])
            ));
            if (!empty($ps)) {
                if (empty($new_id)) {
                    itoast('序号填写重复，请重新填写！', '', 'error');
                }
            }
            $data['uniacid'] = $_W['uniacid'];
            $data['createtime'] = TIMESTAMP;
            pdo_insert('superman_hand2_pay_position', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                itoast('数据库插入失败！', '', 'error');
            }
        }
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('pay_position').'&version_id='.$_GPC['version_id'];
        itoast('操作成功！', $url, 'success');
    }

} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $ret = pdo_delete('superman_hand2_pay_position', array('id' => $id));
    if ($ret === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    itoast('删除成功！', 'referer', 'success');
}
include $this->template('web/pay_position/index');
