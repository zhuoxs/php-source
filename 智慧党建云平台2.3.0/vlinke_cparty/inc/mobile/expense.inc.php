<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $cateid = intval($_GPC['cateid']);
    $expcate = pdo_get($this->table_expcate, array('id'=>$cateid,'uniacid'=>$_W['uniacid']));
    if (empty($expcate)) {
        message("党费类目不存在！", referer(), "error");
    }
    if ($expcate['endtime']<time()) {
        message("已过了党费类目交费截止时间！", referer(), "error");
    }

    $expense = pdo_get($this->table_expense, array('cateid'=>$cateid,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (empty($expense) && $expcate['status']==3) {
        message("该党费类目为指定名单内的党员交费，你不在交费名单之列！", referer(), "error");
    }elseif (empty($expense)) {
        $expense = array(
            'uniacid'    => $_W['uniacid'],
            'cateid'     => $cateid,
            'userid'     => $user['id'],
            'paynumber'  => date("YmdHis").rand_str(6,1),
            'paymoney'   => $expcate['status']==2?$expcate['catemoney']:0.00,
            'paytime'    => 0,
            'remark'     => trim($_GPC['remark']),
            'status'     => 1,
            'createtime' => time()
            );
        pdo_insert($this->table_expense, $expense);
        $expense['id'] = pdo_insertid();
    }

    $branch = $this->getBranch($user['branchid']);
    $blevelarr = array(1=>"党支部",2=>"党总支",3=>"党委",4=>"单位");

}elseif ($op=="post") {
    $id = intval($_GPC['id']);
    $expense = pdo_get($this->table_expense, array('id'=>$id,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (empty($expense)) {
        message("支付记录不存在！", referer(), "error");
    }
    if ($expense['status']==2) {
        message("该支付记录已支付成功，请不要重复支付！", referer(), "error");
    }

    $expcate = pdo_get($this->table_expcate, array('id'=>$expense['cateid'],'uniacid'=>$_W['uniacid']));
    if (empty($expcate)) {
        message("记录对应的党费类目不存在！", referer(), "error");
    }
    if ($expcate['endtime']<time()) {
        message("已过了该记录党费类目交费截止时间！", referer(), "error");
    }

    $paymoney = $expense['paymoney'];
    $data['remark'] = trim($_GPC['remark']);
    if ($expcate['status'] == 1) {
        $paymoney = floatval($_GPC['paymoney']);
        $data['paymoney'] = $paymoney;
    }
    if ($paymoney <= 0) {
        message("支付金额要大于0元！", referer(), "error");
    }
    $data['paynumber'] = date("YmdHis").rand_str(6,1);
    pdo_update($this->table_expense, $data, array('id'=>$id));

    $params = array(
        'tid'     => $data['paynumber'], 
        'ordersn' => $data['paynumber'],
        'title'   => $expcate['name'],
        'fee'     => $paymoney,
        );
    $this->pay($params);
    die;

}
include $this->template('expense');
?>