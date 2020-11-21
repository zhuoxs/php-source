<?php

function xmlToArray($xml) {

    libxml_disable_entity_loader(true);

    $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

    $val = json_decode(json_encode($xmlstring), true);

    return $val;

}



function getUrl(){

    $current_url='http://';

    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on'){

        $current_url='https://';

    }

    $current_url .= $_SERVER['HTTP_HOST'].strstr($_SERVER['REQUEST_URI'], '/addons', true);

    return $current_url;

}



$data = file_get_contents("php://input");  //异步通知的数据

    // file_put_contents(__DIR__."/debug66.txt", getUrl().strstr($_SERVER['REQUEST_URI'], '/addons', true));

$PayData = xmlToArray($data);

// file_put_contents(__DIR__."/debug333.txt", $PayData);

if($PayData['result_code'] == "SUCCESS" && $PayData['return_code'] = "SUCCESS"){

    $out_trade_no = $PayData['out_trade_no'];

    $openid = $PayData['openid'];

    $payprice = floatval(number_format($PayData['total_fee'] / 100,2));

    $attach = explode("|", $PayData['attach']);

    $types = $attach[0];

    $formId = $attach[1];

    $uniacid = $attach[2];
    if($types == 'duo' || $types == "miaosha" || $types == 'forum' || $types == 'mapforum' || $types == 'yuyue' || $types == 'vipgrade' || $types == 'bargain'  ){

        $url = getUrl() . "/app/index.php?i=".$uniacid."&from=wxapp&c=entry&a=wxapp&do=paynotify&m=sudu8_page&flag=1&out_trade_no=".$out_trade_no."&openid=".$openid."&payprice=".$payprice."&types=".$types."&formId=" . $formId;
        file_get_contents($url);
        
    }elseif ($types=="auction") {//拍卖订单
        $url = getUrl() . "/app/index.php?i=".$uniacid."&from=wxapp&c=entry&a=wxapp&do=paynotify&m=sudu8_page_plugin_test1&flag=1&out_trade_no=".$out_trade_no."&openid=".$openid."&payprice=".$payprice."&types=".$types."&formId=" . $formId;

        file_get_contents($url);
    }elseif ($types=="store_cz") {//店内充值订单
        $url = getUrl() . "/app/index.php?i=".$uniacid."&from=wxapp&c=entry&a=wxapp&do=pay_cz&m=sudu8_page&order_id=".$out_trade_no."&openid=".$openid."&money=".$payprice."&gz=" . $formId;

        file_get_contents($url);
    }




    //include __DIR__ . '/payNotify.php';

    //$pn = new payNotify($out_trade_no, $openid, $payprice, $types);

    //$pn->notify();

    echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';

    return;

}
