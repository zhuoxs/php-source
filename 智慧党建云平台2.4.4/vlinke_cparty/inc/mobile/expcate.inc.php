<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

    
}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;

    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_expcate)." WHERE endtime>:endtime AND uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':endtime'=>time(),':uniacid'=>$_W['uniacid']), "id");
    if (empty($list)) {
        exit("NOTHAVE");
    }

    $cateidarr = array_keys($list);
    $expense = pdo_getall($this->table_expense, array('cateid'=>$cateidarr,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']), "", "cateid");

    foreach ($list as $k => $v) {
        $item = $expense[$v['id']];
        switch ($v['status']) {
            case 1:
            case 2:
                $list[$k]['paystatus'] = (!empty($item) && $item['status']==2)?"我已交费 ￥".$item['paymoney']." 元":"待我交费";
                break;
            case 3:
                if (empty($item)) {
                    unset($list[$k]);
                }else{
                    if ($item['status']==1) {
                        $list[$k]['paystatus'] = "待我交费";
                    }elseif ($item['status']==2) {
                        $list[$k]['paystatus'] = "我已交费 ￥".$item['paymoney']." 元";
                    }
                }
                break;
        }
    }
    if (empty($list)) {
        exit("NOTHAVE");
    }

}
include $this->template('expcate');
?>