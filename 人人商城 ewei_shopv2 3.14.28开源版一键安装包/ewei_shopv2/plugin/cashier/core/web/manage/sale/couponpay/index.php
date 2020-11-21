<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Index_EweiShopV2Page extends CashierWebPage {

    public function main()
    {
        global $_W, $_GPC;
        if ($_W['ispost']){
            $data = $_GPC['data'];

            $data['time']['start'] = strtotime($_GPC['time']['start']);
            $data['time']['end'] = strtotime($_GPC['time']['end']);
            $data['discount'] = floatval($data['discount']);
            $data['goodsids'] = trim($_GPC['goodsids']);

            $data['time1']['start'] = strtotime($_GPC['time1']['start']);
            $data['time1']['end'] = strtotime($_GPC['time1']['end']);
            $data['discount1'] = floatval($data['discount1']);
            $data['goodsids1'] = trim($_GPC['goodsids1']);

            $data['time2']['start'] = strtotime($_GPC['time2']['start']);
            $data['time2']['end'] = strtotime($_GPC['time2']['end']);
            $data['discount2'] = floatval($data['discount2']);
            $data['goodsids2'] = trim($_GPC['goodsids2']);

            $this->updateUserSet(array('couponpay'=>$data));
            show_json(1,array('url'=>cashierUrl('sale/couponpay', array('tab'=>str_replace("#tab_","",$_GPC['tab'])))));
        }
        $item = $this->getUserSet('couponpay');
        $goods = array();
        if (!empty($item['goodsids'])){
            $goods = pdo_fetchall('select id,title,thumb from '.tablename('ewei_shop_goods')." where id in ({$item['goodsids']}) and cashier=1 and deleted=0 and uniacid={$_W['uniacid']}");
        }
        $goods1 = array();
        if (!empty($item['goodsids1'])){
            $goods1 = pdo_fetchall('select id,title,thumb from '.tablename('ewei_shop_goods')." where id in ({$item['goodsids']}) and cashier=1 and deleted=0 and uniacid={$_W['uniacid']}");
        }
        $goods2 = array();
        if (!empty($item['goodsids2'])){
            $goods2 = pdo_fetchall('select id,title,thumb from '.tablename('ewei_shop_goods')." where id in ({$item['goodsids']}) and cashier=1 and deleted=0 and uniacid={$_W['uniacid']}");
        }
        include $this->template();
    }

    protected function intdata($data)
    {
        $array = array();
        foreach ($data as $key=>$val){
            $array[] = intval($val);
        }
        return $array;
    }
}