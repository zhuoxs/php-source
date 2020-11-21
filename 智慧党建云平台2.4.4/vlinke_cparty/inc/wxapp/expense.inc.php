<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {
    $cateid = intval($_GPC['cateid']);
    $expcate = pdo_get($this->table_expcate, array('id'=>$cateid,'uniacid'=>$_W['uniacid']));
    if (empty($expcate)) {
        $this->result(1, '党费类目不存在！');
    }
    if ($expcate['endtime']<time()) {
        $this->result(1, '已过了党费类目交费截止时间！');
    }
    $userid = intval($_GPC['userid']);
    $expense = pdo_get($this->table_expense, array('cateid'=>$cateid,'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    if (empty($expense) && $expcate['status']==3) {
        $this->result(1, '该党费类目为指定名单内的党员交费，你不在交费名单之列！');
    }elseif (empty($expense)) {
        $expense = array(
            'uniacid'    => $_W['uniacid'],
            'cateid'     => $cateid,
            'userid'     => $userid,
            'paynumber'  => date("YmdHis").rand_str(6,1),
            'paymoney'   => $expcate['status']==2?$expcate['catemoney']:0.00,
            'paytime'    => 0,
            'remark'     => "",
            'status'     => 1,
            'createtime' => time()
            );
        pdo_insert($this->table_expense, $expense);
        $expense['id'] = pdo_insertid();
    }

    $branchid = intval($_GPC['branchid']);
    $branch = pdo_get($this->table_branch, array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    $blevelarr = array(1=>"党支部",2=>"党总支",3=>"党委",4=>"单位");
    $branch['blevelstr'] = $blevelarr[$branch['blevel']];

    $expcate['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($expcate['details']));
    $expcate['endtime'] = date("Y-m-d H:i", $expcate['endtime']);
    
    $expense['paytime'] = date("Y-m-d H:i", $expense['paytime']);

    $this->result(0, '', array(
        'expcate' => $expcate,
        'expense' => $expense,
        'branch' => $branch
        ));


}elseif ($op=="post") {

    $id = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $expense = pdo_get($this->table_expense, array('id'=>$id,'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    if (empty($expense)) {
        $this->result(1, '支付记录不存在！');
    }
    if ($expense['status']==2) {
        $this->result(1, '该支付记录已支付成功，请不要重复支付！');
    }

    $expcate = pdo_get($this->table_expcate, array('id'=>$expense['cateid'],'uniacid'=>$_W['uniacid']));
    if (empty($expcate)) {
        $this->result(1, '记录对应的党费类目不存在！');
    }
    if ($expcate['endtime']<time()) {
        $this->result(1, '已过了该记录党费类目交费截止时间！');
    }

    $paymoney = $expense['paymoney'];
    $data['remark'] = trim($_GPC['remark']);
    if ($expcate['status'] == 1) {
        $paymoney = floatval($_GPC['paymoney']);
        $data['paymoney'] = $paymoney;
    }
    if ($paymoney <= 0) {
        $this->result(1, '支付金额要大于0.00元！');
    }
    $data['paynumber'] = date("YmdHis").rand_str(6,1);
    pdo_update($this->table_expense, $data, array('id'=>$id));

    $params = array(
        'tid'   => $data['paynumber'], 
        'user'  => $_W['openid'],
        'fee'   => floatval($paymoney),
        'title' => $expcate['name']
        );
    $pay_params = $this->pay($params);
    if (is_error($pay_params)) {
        $this->result(1, '支付失败，信息提示：'.$pay_params['message']);
    }
    $this->result(0, '', $pay_params);
}
?>