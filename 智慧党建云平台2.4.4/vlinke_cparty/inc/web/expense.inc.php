<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$op = $operation = $_GPC['op']?$_GPC['op']:'display';

load()->func('tpl');
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = ' WHERE e.uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND e.status=:status ";
        $par[':status'] = $status;
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND e.userid=:userid ";
        $par[':userid'] = $userid;
    }
    $cateid = intval($_GPC['cateid']);
    $cate = array();
    if ($cateid!=0) {
        $con .= " AND e.cateid=:cateid ";
        $par[':cateid'] = $cateid;
        $cate = pdo_get($this->table_expcate, array('id'=>$cateid,'uniacid'=>$_W['uniacid']));
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }
    $list = pdo_fetchall("SELECT e.*,u.nickname,u.realname,u.mobile,u.headpic,c.name,c.status as cstatus FROM ".tablename($this->table_expense)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id LEFT JOIN ".tablename($this->table_expcate)." c ON e.cateid=c.id ".$con." ORDER BY e.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetch("SELECT count(e.id) as tol, sum(e.paymoney) as paymoneytol FROM ".tablename($this->table_expense)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id LEFT JOIN ".tablename($this->table_expcate)." c ON e.cateid=c.id ".$con ,$par);
    $pager = pagination($total['tol'], $pindex, $psize);

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT e.*,u.openid,u.nickname,u.realname,u.mobile,c.name FROM ".tablename($this->table_expense)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id LEFT JOIN ".tablename($this->table_expcate)." c ON e.cateid=c.id ".$con." ORDER BY e.id DESC ", $par);
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['openid']     = $v['openid'];
            $data[$k]['nickname']   = $v['nickname'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['name']       = $v['name'];
            $data[$k]['paymoney']   = $v['paymoney'];
            $data[$k]['remark']     = str_replace(",", "，", $v['remark']);
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
        }
        $arrhead = array("ID","OpenID","昵称","姓名","手机号","党费类目","金额","备注","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }

} elseif ($op=='setpaymoney') {
    $ret = array('status'=>"error",'msg'=>"error",'paymoney'=>0.00);
    $id = intval($_GPC['id']);
    $expense = pdo_get($this->table_expense,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($expense)) {
        $ret['msg'] = "要修改的党费记录不存在或已被删除！";
        exit(json_encode($ret));
    }
    $ret['paymoney'] = $expense['paymoney'];
    if ($expense['status']==2) {
        $ret['msg'] = "党费记录处于已支付状态，不能修改！";
        exit(json_encode($ret));
    }
    $paymoney = round(floatval($_GPC['paymoney']),2);
    if ($paymoney<=0) {
        $ret['msg'] = "交费金额不能小于0！";
        exit(json_encode($ret));
    }
    pdo_update($this->table_expense, array('paymoney'=>$paymoney), array('id'=>$id));
    $ret['status'] = "success";
    $ret['msg'] = "success";
    $ret['paymoney'] = $paymoney;
    exit(json_encode($ret));

} elseif ($op=='delete') {
    $id = intval($_GPC['id']);
    $expense = pdo_fetch("SELECT * FROM ".tablename($this->table_expense)." WHERE id=:id AND uniacid=:uniacid ",array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($expense)) {
        message('要删除的党费记录不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_expense, array('id' => $id));
    message('党费记录信息删除成功！', referer(), 'success');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_expense)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");
}
include $this->template('expense');

?>