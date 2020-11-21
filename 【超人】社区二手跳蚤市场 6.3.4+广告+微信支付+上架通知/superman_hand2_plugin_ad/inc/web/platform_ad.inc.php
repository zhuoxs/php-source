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
    'delete'
))?$_GPC['act']:'display';
$title = '物品广告';
if ($act == 'display') {
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'item_type' => 1,
    );
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $total = pdo_getcolumn('superman_hand2_item', $filter, 'COUNT(*)');
    if ($total) {
        $orderby = 'createtime DESC';
        $list = pdo_getall('superman_hand2_item', $filter, '*', '', $orderby, array($pindex, $pagesize));
        if ($list) {
            foreach ($list as &$li) {
                $li['album'] = $li['album']?iunserializer($li['album']):array();
                $li['pay_position'] = abs($li['pay_position']);
            }
            unset($li);
        }
        $pager = pagination($total, $pindex, $pagesize);
    }
} else if ($act == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_get('superman_hand2_item', array('id' => $id));
    if ($item) {
        $item['album'] = $item['album']?iunserializer($item['album']):array();
        $area_points = $item['area_points']?iunserializer($item['area_points']):array();
        $location = array(
            'lng' => $item['lng'],
            'lat' => $item['lat'],
        );
    }
    $all_links = SupermanHand2PluginAdUtil::get_links($_W['account']['type']);
    if (checksubmit()) {
        //检查位置是否被占用
        $pay_position = $_GPC['pay_position'];
        if ($pay_position > 0) {
            $row = pdo_get('superman_hand2_item', array(
                'uniacid' => $_W['uniacid'],
                'displayorder' => $pay_position
            ));
            //排除自身
            if ($row && $row['id'] != $item['id']) {
                itoast('序号'.$pay_position.'已被占用，请重新输入！', '', 'error');
            }
        }
        $album = array($_GPC['album']);
        $location = $_GPC['location'];
        $data = array(
            'title' => $_GPC['title'],
            'description' => $_GPC['description'],
            'album' => $album != ''?iserializer($album):'',
            'avatar' => $_GPC['avatar'],
            'status' => $_GPC['status'],
            'appid' => $_GPC['appid'],
            'url' => $_GPC['url'],
            'lat' => $location['lat'],
            'lng' => $location['lng'],
            'pay_position' => $pay_position,
            'area_points' => $_GPC['area_points']?iserializer(json_decode(base64_decode($_GPC['area_points']), true)):'',
        );
        if (!empty($location['lat']) && !empty($location['lng'])) {
            $transition = SupermanHand2PluginAdUtil::location_transition($data['lat'], $data['lng']);
            if ($transition) {
                $data['province'] = $transition['province'];
                $data['city'] = $transition['city'];
            }
        }
        if (!empty($item)) {
            $data['updatetime'] = TIMESTAMP;
            $ret = pdo_update('superman_hand2_item', $data, array('id' => $item['id']));
            if ($ret === false) {
                itoast('数据库更新失败！', '', 'error');
            }
        } else {
            $data['uniacid'] = $_W['uniacid'];
            $data['item_type'] = 1;
            $data['createtime'] = TIMESTAMP;
            pdo_insert('superman_hand2_item', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                itoast('数据库更新失败！', '', 'error');
            }
        }
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('platform_ad').'&version_id='.$_GPC['version_id'];
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $ret = pdo_delete('superman_hand2_item', array('id' => $id));
    if ($ret === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    itoast('删除成功！', 'referer', 'success');
}
include $this->template('web/platform_ad/index');
