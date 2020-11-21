<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {


}elseif ($op=="getmore") {

    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize'])); 
    $userid = intval($_GPC['userid']);

    $list = pdo_fetchall("SELECT e.*,c.name,c.status as cstatus,c.endtime FROM ".tablename($this->table_expense)." e LEFT JOIN ".tablename($this->table_expcate)." c ON e.cateid=c.id WHERE e.userid=:userid AND e.uniacid=:uniacid ORDER BY e.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
            $list[$k]['paytime'] = $v['paytime']==0 ? 0 : date("Y-m-d H:i", $v['paytime']);
        }
    }
    $this->result(0, '', $list); 


}elseif ($op=="delete") {
    $id = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $expense = pdo_get($this->table_expense, array('id'=>$id,'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    if (!empty($id) && empty($expense)) {
        $this->result(1, '支付记录不存在！'); 
    }
    if ($expense['status']==2) {
        $this->result(1, '该支付记录已支付成功，不能做删除操作！');
    }
    pdo_delete($this->table_expense, array('id'=>$id,'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    $this->result(0, '', array()); 

}
?>