<?php
global $_W, $_GPC;
$weid = $this->_weid;
load()->func('tpl');
$action = 'memberpayph';
$GLOBALS['frames'] = $this->getMainMenu();
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$params    = array();
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
if ($operation == 'display') {
    $commoncondition = " a.weid = '{$_W['uniacid']}' and a.totalprice > 0 ";
    if (!empty($_GPC['realname'])) {
        $commoncondition .= " AND (b.realname LIKE '%{$_GPC['realname']}%' or b.mobile LIKE '%{$_GPC['realname']}%' )";
    }
    $paytime = intval($_GPC['paytime']);
    if ($paytime != 0) {
        if ($paytime == 1) {
            $time = strtotime('-1 month');
            $condition .= " AND a.paytime > {$time} ";
        } else if ($paytime == 2) {
            $stime = strtotime('-1 month');
            $etime = strtotime('-3 month');
            $condition .= " AND a.paytime < {$stime} AND a.paytime > {$etime} ";
        } else if ($paytime == 3) {
            $stime = strtotime('-3 month');
            $etime = strtotime('-6 month');
            $condition .= " AND a.paytime < {$stime} AND a.paytime > {$etime} ";
        } else if ($paytime == 4) {
            $stime = strtotime('-6 month');
            $etime = strtotime('-12 month');
            $condition .= " AND a.paytime < {$stime} AND a.paytime > {$etime} ";
        }
    }

//    $orderby = !isset($_GPC['orderby']) ? 'totalprice' : (empty($_GPC['orderby']) ? 'totalprice' : 'totalcount');
    $orderby = "totalcount";
    if (isset($_GPC['orderby'])) {
        if ($_GPC['orderby'] == 1) {
            $orderby = "totalprice";
        }
    }

    if ($_GPC['out_put'] == 'output') {
        $list =  pdo_fetchall("SELECT a.nickname,a.totalprice,a.totalcount,a.headimgurl,b.groupid,b.birthyear,b.mobile,b.realname FROM " . tablename($this->table_fans) . " a INNER JOIN " . tablename('mc_members') ." b ON a.uid=b.uid WHERE $commoncondition  ORDER BY {$orderby} desc "); 
        $i = 0;
        foreach ($list as $key => $value) {
            $arr[$i]['nickname'] = $value['nickname'];
            $arr[$i]['realname'] = $value['realname'];
            $arr[$i]['mobile'] = $value['mobile'];
            $arr[$i]['totalprice'] = $value['totalprice'];          
            $arr[$i]['totalcount'] = $value['totalcount'];
            $i++;
        }

        $this->exportexcel($arr, array('昵称',  '姓名',  '手机号',  '消费金额',  '订单数'), time());
        exit();
    }   
    $list = pdo_fetchall("SELECT a.nickname,a.totalprice,a.totalcount,a.paytime,a.headimgurl,b.groupid,b.birthyear,b.mobile,b.realname FROM " . tablename($this->table_fans) . " a INNER JOIN " . tablename('mc_members') ." b ON a.uid=b.uid WHERE $commoncondition  ORDER BY {$orderby} desc LIMIT ".($pindex - 1) * $psize . ',' . $psize,$params);

    $sql = "SELECT count(1) FROM "  . tablename($this->table_fans) . " a INNER JOIN " . tablename('mc_members') ." b ON a.uid=b.uid WHERE $commoncondition ";
    $total = pdo_fetchcolumn($sql);
    $pager = pagination($total, $pindex, $psize);
}
//include $this->template('memberpayph');
include $this->template('web/memberpayph');
