<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    
}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));  

    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_expcate)." WHERE endtime>:endtime AND uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':endtime'=>time(),':uniacid'=>$_W['uniacid']));

    $userid = intval($_GPC['userid']);
    if (!empty($list)) {

        $cateidarr = array_column($list,"id");
        $expense = pdo_getall($this->table_expense, array('cateid'=>$cateidarr,'userid'=>$userid,'uniacid'=>$_W['uniacid']), "", "cateid");

        foreach ($list as $k => $v) {
            $list[$k]['endtime'] = date("Y-m-d H:i", $v['endtime']);
            $item = $expense[$v['id']];

            $list[$k]['paystatus'] = 1;
            $list[$k]['paystatusstr'] = "待我交费";

            switch ($v['status']) {
                case 1:
                case 2:
                    if (!empty($item) && $item['status']==2) {
                        $list[$k]['paystatus'] = 2;
                        $list[$k]['paystatusstr'] = "我已交费 ￥".$item['paymoney']." 元";
                    }else{
                        $list[$k]['paystatus'] = 1;
                        $list[$k]['paystatusstr'] = "待我交费";
                    }
                    break;
                case 3:
                    if (empty($item)) {
                        unset($list[$k]);
                    }elseif($item['status']==1){
                        $list[$k]['paystatus'] = 1;
                        $list[$k]['paystatusstr'] = "待我交费";
                    }elseif($item['status']==2){
                        $list[$k]['paystatus'] = 2;
                        $list[$k]['paystatusstr'] = "我已交费 ￥".$item['paymoney']." 元";
                    }
                    break;
                default:
                    break;
            }
        }
    }

    $this->result(0, '', array_values($list));
}
?>