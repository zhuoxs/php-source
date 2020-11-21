<?php
global $_GPC, $_W;
        $fans=mc_oauth_userinfo();
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        $orderno = $_GPC['orderno'];
        $orderid = $_GPC['orderid'];
        $order = pdo_fetch("SELECT orderno FROM " . tablename($this->modulename."_order") . " WHERE id = '{$orderid}' ");
        $result = $this->dealpayresult($order['orderno'],$_GPC);
        die(json_encode($result));
?>