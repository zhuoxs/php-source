<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends Page
{
    public function main()
    {
        global $_W;
     echo "";

        error_reporting(0);
        $taobao=json_decode(file_get_contents('php://input'),true);
        if(!empty($taobao)){
            $data = array('uniacid' => $_W['uniacid'], 'subtitle' => $taobao['title'], 'catch_source' => 'taobao',  'title' => $taobao['title'], 'total' => 999, 'marketprice' => 0, 'productprice' => 0,  'createtime' => time(), 'updatetime' => time(),  'status' => 0, 'deleted' => 0, 'newgoods' => 1);
            $data['thumb']=$taobao['img'][0];
            $data['thumb_url'] = serialize($taobao['img']);
            $data['content']=$taobao['detail'];
            $data['marketprice']=floatval($taobao['price'][0]);
            $data['productprice']=floatval($taobao['price'][1]);
            $id= pdo_insert('ewei_shop_goods', $data);
        }

        var_dump(  $id,$data);exit;
    }
}