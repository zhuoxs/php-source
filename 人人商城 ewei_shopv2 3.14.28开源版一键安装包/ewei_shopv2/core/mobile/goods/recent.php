<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Recent_EweiShopV2Page extends MobilePage {

    function main() {
        global $_W, $_GPC;

        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);

        $sql = "select distinct og.openid from "
            .tablename('ewei_shop_order_goods')
            ." as og left join "
            .tablename('ewei_shop_order')
            ." as o on og.orderid=o.id "
            ." where og.uniacid={$uniacid} and og.goodsid={$id} and o.status>0 order by og.id desc limit 8";

        $count_sql = "select count(distinct og.openid) as count from "
            .tablename('ewei_shop_order_goods')
            ." as og left join "
            .tablename('ewei_shop_order')
            ." as o on og.orderid=o.id "
            ." where og.uniacid={$uniacid} and og.goodsid={$id} and o.status>0";

        $openids = pdo_fetchall($sql);

        $count = pdo_fetch($count_sql);

        $ret = array();

        foreach($openids as $key => $value){
            $temp = m('member')->getMember($value['openid']);
            $ret[] = array('headimg'=>$temp['avatar_wechat']);
        }
        echo json_encode(array(
            'status' => 1,
            'msg' => $ret,
            'count' => $count['count'],
        ));
    }
}
