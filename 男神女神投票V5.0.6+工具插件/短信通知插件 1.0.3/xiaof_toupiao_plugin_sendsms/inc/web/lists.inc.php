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
//活动区域
$where = " WHERE 1=1 AND uniacid='".$_W['uniacid']."' AND PID=0 AND isshow=1";
$sql = 'SELECT * FROM ' . tablename('xiaof_toupiao_area') ." {$where} {$orderby}";
$pcids = pdo_fetchall($sql);
if ($_GPC['act'] == 'getcate') {
    $cid = intval($_GPC['cid']);
    if (!$cid) {
        exit;
    }
    $orderby = 'ORDER BY displayorder DESC';
    $where = " WHERE 1=1 AND uniacid='".$_W['uniacid']."' AND pid='".$cid."' AND isshow=1";
    $sql = 'SELECT * FROM ' . tablename('xiaof_toupiao_area') ." {$where} {$orderby}";
    $childs = pdo_fetchall($sql);
    echo json_encode($childs);
    exit;
}
$act = in_array($_GPC['act'], array(
    'display',
))?$_GPC['act']:'display';
$title = '报名列表';
if ($act == 'display') {
    //实时获取活动分组
    if ($_GPC['load_data'] == 'groups' && $_GPC['sid'] > 0) {
        $sid = intval($_GPC['sid']);
        $setting = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = {$sid}");
        if ($setting) {
            $groups = iunserializer($setting['groups']);
            if ($groups) {
                $html = '<option value="">全部</option>';
                foreach ($groups as $key => $group) {
                    $html .= "<option value='{$key}'>{$group['name']}</option>";
                }
            }
            die(json_encode($html));
        }
    }

    //批量发送
    if (checksubmit('batch_submit')) {
        $tmpl_id = $_GPC['tmpl_id'];
        $base = $this->module['config']['base'];
        $tmpl = $this->module['config']['tmpl'];
        if (!$base['alidayu']['switch']) {
            $url = murl('module/manage-account/setting', array('m' => 'xiaof_toupiao_plugin_sendsms', 'version_id' => $_GPC['version_id']));
            itoast('未开启或者未配置短信服务通知参数！', $url, 'warning');
        }
        $itemids = $_GPC['itemids'];
        if (empty($itemids)) {
            itoast('未选择选手', referer(), 'error');
        }
        $success_count = 0;
        $fail_count = 0;
        foreach ($itemids as $itemid) {
            $row = pdo_get('xiaof_toupiao', array('id' => $itemid));
            if (empty($row)) {
                $fail_count += 1;
                continue;
            }
            $activity = pdo_get('xiaof_toupiao_setting', array('id' => $row['sid']), array('tit', 'groups', 'data'));
            $activity['groups'] = $activity['groups'] ? iunserializer($activity['groups']) : array();
            $activity['data'] = $activity['data'] ? iunserializer($activity['data']) : array();
            $template = array(
                'id' => $tmpl[$tmpl_id]['id'],
                'name' => $row['name'],
                'title' => $activity['tit'],
                'group' => $activity['groups'][$row['groups']]['name'],
                'uid' => $row['uid'],
                'date' => date('Y-m-d H:i:s', $row['created_at']),
                'votetime' => $activity['data']['start'],
            );
            if ($tmpl[$tmpl_id]['variable']) {
                $template['params'] = "{";
                $var_arr = explode('@', $tmpl[$tmpl_id]['variable']);
                foreach ($var_arr as $va) {
                    $template['params'] .= "\"{$va}\":\"{$template[$va]}\",";
                }
                $template['params'] .= "}";
            }
            $ret = Sms::init('alidayu_new', $base['alidayu'])->send($row['phone'], '', $template);
            if ($ret !== true) {
                $fail_count += 1;
                continue;
            }
            $success_count += 1;
        }
        itoast("已发送完毕！成功{$success_count}条，失败{$fail_count}条", referer(), 'success');
    }

   /* $where =' WHERE `uniacid` ='.$_W['uniacid'];
    if (!empty($_GPC['actname'])) {
        $where .=" AND `tit` like '%".$_GPC['actname']."%'";
    }

    if(!empty($_GPC['pcid'])){
        $where .=' AND `pcid` ='.$_GPC['pcid'];
    }

    $setting2 = pdo_fetchall("SELECT * FROM " . tablename("xiaof_toupiao_setting") . $where);
    $sids2 = array();
    foreach ($setting2 as $v) {
        $sids2[] = intval($v['id']);
    }*/


    //筛选条件
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 50;
    if(!empty($this->module['config']['base']['pagesize'])){
        $pagesize = $this->module['config']['base']['pagesize'];
    }
    $start = ($pindex - 1) * $pagesize;
    $params = array();
    $condition = ' WHERE 1=1';

    if (!empty($_GPC['actname']) || !empty($_GPC['pcid'])) {
        $wheres = " WHERE `uniacid`=".$_W['uniacid'];
        if(!empty($_GPC['actname'])){
            $wheres .= " AND `tit` like '%".$_GPC['actname']."%'";
        }
        if(!empty($_GPC['pcid'])){
            $wheres .= " AND `pcid`=".$_GPC['pcid'];
            $condit =" WHERE 1=1 AND uniacid='".$_W['uniacid']."' AND `isshow`=1 AND `pid`=".$_GPC['pcid'];
            $sql = 'SELECT * FROM ' . tablename('xiaof_toupiao_area') ." {$condit} {$orderby}";
            $cids = pdo_fetchall($sql);
        }
        if(!empty($_GPC['cid'])){
            $wheres .= " AND `cid`=".$_GPC['cid'];
        }

        $setting = pdo_fetchall("SELECT * FROM " . tablename("xiaof_toupiao_setting") . $wheres);
        if(!empty($setting)){
            $sids = array();
            foreach ($setting as $v) {
                $sids[] = $v['id'];
            }
            $condition .= " AND `sid` in ('" . implode("','", $sids) . "')";
        }
    }

    if (!empty($_GPC['sid'])) {
        $condition .= ' AND `sid`=:sid';
        $params[':sid'] = intval($_GPC['sid']);
        $setting = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = {$_GPC['sid']}");
        if ($setting) {
            $groups = iunserializer($setting['groups']);
        }
    }
    if (!empty($_GPC['groups'])) {
        $condition .= ' AND `groups`=:groups';
        $params[':groups'] = intval($_GPC['groups']);
    }

    if (!empty($_GPC['key'])) {
        $condition .= ' AND (`uid`=:uid OR `name` like :name) ';
        $params[':uid'] = intval($_GPC['key']);
        $params[':name'] = "%" . $_GPC['key'] . "%";
    }
    if (!empty($_GPC['verify']) && $_GPC['verify'] == 3) {
        $condition .= ' AND `locking`=:locking';
        $params[':locking'] = 1;
    } else if (!empty($_GPC['verify']) or $_GPC['verify'] === '0') {
        $condition .= ' AND `verify`=:verify';
        $params[':verify'] = intval($_GPC['verify']);
    }
    //活动列表
    $act_list = pdo_getall('xiaof_toupiao_setting', array(
        'uniacid' => $_W['uniacid'],
    ), '', '', ' ORDER BY `created_at` DESC');
    $sql = "SELECT COUNT(*) FROM " . tablename('xiaof_toupiao');
    $total = pdo_fetchcolumn($sql.$condition, $params);
    if ($total) {
        $sql = "SELECT * FROM " . tablename('xiaof_toupiao');
        $condition .= ' ORDER BY created_at DESC';
        $condition .= $pagesize > 0 ? " LIMIT {$start},{$pagesize}":'';
        $list = pdo_fetchall($sql.$condition, $params);
        if ($list) {
            foreach ($list as &$li) {
                $li['created_at'] = date('Y-m-d H:i:s', $li['created_at']);
            }
            unset($li);
        }
        $pager = pagination($total, $pindex, $pagesize);
    }

    //全部发送
    if (checksubmit('all_submit')) {
        $tmpl_id = $_GPC['tmpl_id'];
        $base = $this->module['config']['base'];
        $tmpl = $this->module['config']['tmpl'];
        if (!$base['alidayu']['switch']) {
            $url = murl('module/manage-account/setting', array('m' => 'xiaof_toupiao_plugin_sendsms', 'version_id' => $_GPC['version_id']));
            itoast('未开启或者未配置短信服务通知参数！', $url, 'warning');
        }
        $success_count = 0;
        $fail_count = 0;
        foreach ($list as $val) {
            if (empty($val)) {
                $fail_count += 1;
                continue;
            }
            $activity = pdo_get('xiaof_toupiao_setting', array('id' => $val['sid']), array('tit', 'groups', 'data'));
            $activity['groups'] = $activity['groups'] ? iunserializer($activity['groups']) : array();
            $activity['data'] = $activity['data'] ? iunserializer($activity['data']) : array();
            $template = array(
                'id' => $tmpl[$tmpl_id]['id'],
                'name' => $val['name'],
                'title' => $activity['tit'],
                'group' => $activity['groups'][$val['groups']]['name'],
                'uid' => $val['uid'],
                'date' => $val['created_at'],
                'votetime' =>$activity['data']['start'],
            );
            if ($tmpl[$tmpl_id]['variable']) {
                $template['params'] = "{";
                $var_arr = explode('@', $tmpl[$tmpl_id]['variable']);
                foreach ($var_arr as $va) {
                    $template['params'] .= "\"{$va}\":\"{$template[$va]}\",";
                }
                $template['params'] .= "}";
            }
            $ret = Sms::init('alidayu_new', $base['alidayu'])->send($val['phone'], '', $template);
            if ($ret !== true) {
                $fail_count += 1;
                continue;
            }
            $success_count += 1;
        }
        itoast("已发送完毕！成功{$success_count}条，失败{$fail_count}条", referer(), 'success');
    }
}
include $this->template('web/lists');
