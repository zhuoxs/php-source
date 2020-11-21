<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {


}elseif ($op=="getmore") {

    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT e.*,c.name,c.status as cstatus,c.endtime FROM ".tablename($this->table_expense)." e LEFT JOIN ".tablename($this->table_expcate)." c ON e.cateid=c.id WHERE e.userid=:userid AND e.uniacid=:uniacid ORDER BY e.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }


}elseif ($op=="delete") {
    $id = intval($_GPC['id']);
    $expense = pdo_get($this->table_expense, array('id'=>$id,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (!empty($id) && empty($expense)) {
        message("支付记录不存在！", referer(), "error");
    }
    if ($expense['status']==2) {
        message("该支付记录已支付成功，不能做删除操作！", referer(), "error");
    }
    pdo_delete($this->table_expense, array('id'=>$id,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    message('支付记录信息删除成功！', referer(), 'success');
}
include $this->template('explog');
?>