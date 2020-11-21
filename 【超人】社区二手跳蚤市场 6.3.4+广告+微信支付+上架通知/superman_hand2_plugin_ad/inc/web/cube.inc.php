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
$title = '橱窗广告';
if ($act == 'display') {
    $orderby = 'displayorder DESC, createtime DESC';
    $list = pdo_getall('superman_hand2_cube_ad', array('uniacid' => $_W['uniacid']), '*', '', $orderby);
    if ($list) {
        foreach ($list as &$li) {
            if ($li['thumb']) {
                $li['thumb'] = tomedia($li['thumb']);
            }
        }
        unset($li);
    }
    //更新排序
    if (checksubmit()) {
        if ($_GPC['displayorder']) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                pdo_update('superman_hand2_cube_ad', array('displayorder' => $val), array('id' => $id));
            }
            itoast('操作成功！', referer(), 'success');
        }
    }
} else if ($act == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_get('superman_hand2_cube_ad', array('id' => $id));
    if (!empty($item)) {
        $item['show_time'] = array(
            'start' => $item['starttime'],
            'end' => $item['endtime'] ? $item['endtime']:date('Y-m-d H:i:s', TIMESTAMP),
        );
    } else {
        $item['show_time'] = array(
            'start' => date('Y-m-d H:i:s'),
            'end' => date('Y-m-d H:i:s', strtotime('+1 day')),
        );
    }
    $all_links = SupermanHand2PluginAdUtil::get_links($_W['account']['type'], '', 1);
    if (checksubmit()) {
        $show_time = $_GPC['show_time'];
        $data = array(
            'displayorder' => $_GPC['displayorder'],
            'title' => $_GPC['title'],
            'appid' => $_GPC['appid'],
            'url' => $_GPC['url'],
            'thumb' => $_GPC['thumb'],
            'starttime' => $show_time['start'],
            'endtime' => $_GPC['show_limit'] == 'on' ? 0 : $show_time['end'],
        );
        if ($id) {
            $ret = pdo_update('superman_hand2_cube_ad', $data, array('id' => $item['id']));
            if ($ret === false) {
                itoast('数据库更新失败！', '', 'error');
            }
        } else {
            $data['uniacid'] = $_W['uniacid'];
            $data['createtime'] = TIMESTAMP;
            pdo_insert('superman_hand2_cube_ad', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                itoast('数据库添加失败！', '', 'error');
            }
        }
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('cube').'&version_id='.$_GPC['version_id'];
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $ret = pdo_delete('superman_hand2_cube_ad', array('id' => $id));
    if ($ret === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    itoast('删除成功！', 'referer', 'success');
}
include $this->template('web/cube/index');
