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
    'delete',
))?$_GPC['act']:'display';
$title = '订阅物品';
if ($act == 'display') {
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $total = pdo_getcolumn('superman_hand2_ask_item', $filter, 'COUNT(*)');
    if ($total) {
        $list = pdo_getall('superman_hand2_ask_item', $filter, '*', '', '', array($pindex, $pagesize));
        if ($list) {
            foreach ($list as &$li) {
                $li['member'] = pdo_get('mc_members', array(
                    'uid' => $li['uid'],
                ), array('nickname', 'avatar'));
                $li['dateline'] = date('Y-m-d H:i:s', $li['dateline']);
            }
            unset($li);
        }
        $pager = pagination($total, $pindex, $pagesize);
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    $ret = pdo_delete('superman_hand2_ask_item', array(
        'uniacid' => $_W['uniacid'],
        'id' => $id,
    ));
    if ($ret === false) {
        itoast('删除失败，请稍后重试！', '', 'error');
    }
    itoast('删除成功！', '', 'success');
}
include $this->template('web/ask_item/index');
