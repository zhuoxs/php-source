<?php
function activity_tip($openid, $name, $url) {
    global $_W;
    wl_load()->model('setting');
    $setting = setting_get_by_name("message");
    $m_activity = $setting['m_activity'];
    $postdata = array(
        "first" => array(
            "value" => "恭喜您获得抽奖机会,请在活动结束前使用.",
            "color" => "#4a5077"
        ) ,
        "keyword1" => array(
            'value' => "活动：".$name.",请点击前去",
            "color" => "#4a5077"
        ) ,
        "keyword2" => array(
            'value' => "待使用",
            "color" => "#4a5077"
        ) ,
        "keyword3" => array(
            'value' => date("Y-m-d",time()),
            "color" => "#4a5077"
        ) ,
        "remark" => array(
            "value" => '点击领取',
            "color" => "#F92415"
        ) ,
    );
    sendtplnotice($openid, $m_activity, $postdata, $url);
}
function activity_lottery($openid, $level,$a_name,$p_name, $url) {
    global $_W;
    wl_load()->model('setting');
    $setting = setting_get_by_name("message");
    $m_activity = $setting['m_activity_lottery'];
    $postdata = array(
        "first" => array(
            "value" => "恭喜中奖！",
            "color" => "#4a5077"
        ) ,
        "keyword1" => array(
            'value' => $a_name,
            "color" => "#4a5077"
        ) ,
        "keyword2" => array(
            'value' => $p_name,
            "color" => "#4a5077"
        ) ,
        "remark" => array(
            "value" => '点击查看奖品！',
            "color" => "#F92415"
        ) ,
    );
    sendtplnotice($openid, $m_activity, $postdata, $url);
}
function activity_result($openid, $a_name,$p_name, $url) {
    global $_W;
    wl_load()->model('setting');
    $setting = setting_get_by_name("message");
    $m_activity = $setting['m_activity_result'];
    $postdata = array(
        "first" => array(
            "value" => "恭喜您获得了奖品.",
            "color" => "#4a5077"
        ) ,
        "keyword1" => array(
            'value' => $a_name,
            "color" => "#4a5077"
        ) ,
        "keyword2" => array(
            'value' => $p_name,
            "color" => "#4a5077"
        ) ,
        "keyword3" => array(
            'value' => date("Y-m-d",time()),
            "color" => "#4a5077"
        ) ,
        "keyword4" => array(
            'value' => date("Y-m-d",time()),
            "color" => "#4a5077"
        ) ,
        "remark" => array(
            "value" => '感谢您的参与,点击查看参与记录',
            "color" => "#F92415"
        ) ,
    );
    sendtplnotice($openid, $m_activity, $postdata, $url);
}
function daipay_success($openid, $price, $name, $orderno, $goodsname, $time, $message, $url) {
    global $_W;
    wl_load()->model('setting');
    $setting = setting_get_by_name("message");
    $m_daipay = $setting['m_daipay'];
    $postdata = array(
        "first" => array(
            "value" => "代付成功啦.",
            "color" => "#4a5077"
        ) ,
        "keyword1" => array(
            'value' => $orderno,
            "color" => "#4a5077"
        ) ,
        "keyword2" => array(
            'value' => $name,
            "color" => "#4a5077"
        ) ,
        "keyword3" => array(
            'value' => "￥" . $price . "[" . $goodsname . "]",
            "color" => "#4a5077"
        ) ,
        "keyword4" => array(
            'value' => $time,
            "color" => "#4a5077"
        ) ,
        "keyword5" => array(
            'value' => $message,
            "color" => "#4a5077"
        ) ,
        "remark" => array(
            "value" => '点击查看详情',
            "color" => "#4a5077"
        ) ,
    );
    sendtplnotice($openid, $m_daipay, $postdata, $url);
}
function pay_success($openid, $price, $goodsname, $url) {
    global $_W;
    wl_load()->model('setting');
    $setting = setting_get_by_name("message");
    $m_pay = $setting['m_pay'];
    $postdata = array(
        "first" => array(
            "value" => "尊敬的客户您好,您已成功付款.",
            "color" => "#4a5077"
        ) ,
        "orderMoneySum" => array(
            'value' => "￥ " . $price,
            "color" => "#4a5077"
        ) ,
        "orderProductName" => array(
            'value' => $goodsname,
            "color" => "#4a5077"
        ) ,
        "Remark" => array(
            "value" => '',
            "color" => "#4a5077"
        ) ,
    );
    sendtplnotice($openid, $m_pay, $postdata, $url);
}
function group_success($tuan_id, $url) {
    global $_W;
    wl_load()->model('setting');
    $setting = setting_get_by_name("message");
    $m_tuan = $setting['m_tuan'];
    $alltuan = pdo_fetchall("select openid from" . tablename('tg_order') . "where tuan_id = '{$tuan_id}' and status in(1,2,3,4) and mobile<>'虚拟'");
    $tuan_first_order = pdo_fetch("select openid,g_id,tuan_id from" . tablename('tg_order') . "where tuan_first=1 and tuan_id='{$tuan_id}'");
    $profile = pdo_fetch("select nickname from" . tablename('mc_mapping_fans') . "where openid = '{$tuan_first_order['openid']}'");
    $goods = pdo_fetch("select gname from" . tablename('tg_goods') . "where id = '{$tuan_first_order['g_id']}'");
    $postdata = array(
        "first" => array(
            "value" => "恭喜组团成功,您编号为【" . $tuan_first_order['tuan_id'] . "】的团组团成功,请及时关注发货动态.",
            "color" => "#4a5077"
        ) ,
        "Pingou_ProductName" => array(
            'value' => $goods['gname'],
            "color" => "#4a5077"
        ) ,
        "Weixin_ID" => array(
            'value' => $profile['nickname'],
            "color" => "#4a5077"
        ) ,
        "remark" => array(
            "value" => "点击查看",
            "color" => "#4a5077"
        ) ,
    );
    foreach ($alltuan as $num => $all) {
        sendtplnotice($all['openid'], $m_tuan, $postdata, $url);
    }
}
function send_success($orderno, $openid, $express, $expressn, $url) {
    global $_W;
    wl_load()->model('setting');
    $setting = setting_get_by_name("message");
    $m_send = $setting['m_send'];
    $order = pdo_fetch("select g_id from" . tablename('tg_order') . "where orderno = '{$orderno}'");
    $goods = pdo_fetch("select gname from" . tablename('tg_goods') . "where id = {$order['g_id']}");
    $postdata = array(
        "first" => array(
            "value" => "恭喜你的宝贝【" . $goods['gname'] . "】已经发货啦！",
            "color" => "#4a5077"
        ) ,
        "keyword1" => array(
            'value' => $orderno,
            "color" => "#4a5077"
        ) ,
        "keyword2" => array(
            'value' => $express,
            "color" => "#4a5077"
        ) ,
        "keyword3" => array(
            "value" => $expressn,
            "color" => "#4a5077"
        ) ,
        "remark" => array(
            "value" => '祝您生活愉快,欢迎再次光临！',
            "color" => "#4a5077"
        ) ,
    );
    sendtplnotice($openid, $m_send, $postdata, $url);
}
function refund_success($orderno, $openid, $price, $url) {
    global $_W;
    wl_load()->model('setting');
    $setting = setting_get_by_name("message");
    $m_ref = $setting['m_ref'];
    $postdata = array(
        "first" => array(
            "value" => "您订单号为【" . $orderno . "】的订单已成功退款!",
            "color" => "#4a5077"
        ) ,
        "reason" => array(
            'value' => "组团失败,系统已将您的支付金额全数退还.",
            "color" => "#4a5077"
        ) ,
        "refund" => array(
            'value' => "￥" . $price,
            "color" => "#4a5077"
        ) ,
        "remark" => array(
            "value" => "祝您生活愉快,欢迎再次光临!",
            "color" => "#4a5077"
        ) ,
    );
    sendtplnotice($openid, $m_ref, $postdata, $url);
}
function cancelorder($openid, $price, $goodsname, $orderno, $url) {
    global $_W;
    wl_load()->model('setting');
    $setting = setting_get_by_name("message");
    $m_cancle = $setting['m_cancle'];
    $order = pdo_fetch("select * from" . tablename('tg_order') . "where orderno = '{$orderno}' ");
    $postdata = array(
        "first" => array(
            "value" => "您的订单已取消!",
            "color" => "#4a5077"
        ) ,
        "keyword5" => array(
            'value' => "￥" . $price . "[未支付]",
            "color" => "#4a5077"
        ) ,
        "keyword3" => array(
            'value' => $goodsname,
            "color" => "#4a5077"
        ) ,
        "keyword2" => array(
            "value" => $_W['uniaccount']['name'],
            "color" => "#4a5077"
        ) ,
        "keyword1" => array(
            "value" => $orderno,
            "color" => "#4a5077"
        ) ,
        "keyword4" => array(
            "value" => $order['gnum'],
            "color" => "#4a5077"
        ) ,
        "remark" => array(
            "value" => "祝您生活愉快,欢迎再次光临!",
            "color" => "#4a5077"
        ) ,
    );
    sendtplnotice($openid, $m_cancle, $postdata, $url);
}
?>
