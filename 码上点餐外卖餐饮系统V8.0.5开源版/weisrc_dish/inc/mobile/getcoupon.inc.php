<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;

if (empty($from_user)) {
    message('会话已过期，请重新发关键字进入系统...');
}

//优惠券ID
$id = intval($_GPC['couponid']);
$type = intval($_GPC['type']);

//优惠券 1.发放总数2.没人领取数量
$coupon = pdo_fetch("SELECT * FROM " . tablename($this->table_coupon) . " WHERE id=:id LIMIT 1", array(':id' => $id));
if (empty($coupon)) {
    message('优惠券不存在!');
} else {
    //判断优惠券属性  普通券1 营销券2
    if ($coupon['attr_type'] == 2) {
        message('该优惠券属于营销券,不能领取...');
    }
    if (TIMESTAMP < $coupon['starttime']) {
        message('活动时间还未开始,不能领取...');
    }
    if (TIMESTAMP > $coupon['endtime']) {
        message('活动时间已经结束啦,不能领取...');
    }
}

$coupon_usercount = $coupon['usercount'];//每个用户能领取数量 0为不限制
$coupon_totalcount = $coupon['totalcount'];//发放总数量 0为不限制

//用户已领取数量
$user_count = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_sncode) . " WHERE weid = :weid and from_user=:from_user AND couponid=:couponid ORDER
BY id DESC", array(':weid' => $weid, ':from_user' => $from_user, ':couponid' => $id));
//已领取总数量
$total_count = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_sncode) . " WHERE weid = :weid AND couponid=:couponid ORDER BY id DESC", array(':weid' => $weid, ':couponid' => $id));

//发放总数量有限制
if ($coupon_totalcount != 0) {
    if ($total_count >= $coupon_totalcount) {
        message('对不起，优惠券已经发放完了!');
    }
}
if ($coupon_usercount != 0) {
    if ($user_count >= $coupon_usercount) {
        message("每人最多只能兑换{$coupon_usercount}次!");
    }
}

$dcredit = intval($coupon['dcredit']);
$is_credit = 0;
if ($dcredit > 0) {
    load()->model('mc');
    $user = mc_fetch($from_user);
    $credit = intval($user['credit1']); //剩余积分
    if ($credit < $dcredit) {
        message('对不起，您的积分不足，本次兑换需要积分'.$dcredit.'!');
    } else {
        $is_credit = 1;
    }
}

//生成兑换码
$sncode = 'SN' . random(11, 1);
$sncode = $this->getNewSncode($weid, $sncode);

if ($is_credit == 1) {
    load()->func('compat.biz');
    $uid = mc_openid2uid($from_user);
    $fans = fans_search($uid, array("credit1"));
    if (!empty($fans)) {
        $uid = intval($fans['uid']);
        $remark = '点餐兑换积分扣除 领取ID:' . $sncode;
        $log = array();
        $log[0] = $uid;
        $log[1] = $remark;
        mc_credit_update($uid, 'credit1', -$dcredit, $log);
    }
}

//添加兑换码
$data = array(
    'couponid' => $id,
    'sncode' => $sncode,
    'storeid' => $coupon['storeid'],
    'weid' => $weid,
    'from_user' => $from_user,
    'dateline' => TIMESTAMP
);
pdo_insert($this->table_sncode, $data);
message('领取成功！', '', 'success');