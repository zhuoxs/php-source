<?php
load()->model('module');


function create_withdraw($param) {
    global $_W;



    load()->model('payment');


    $setting = uni_setting($_W['uniacid']);
    $wxpay = $setting['payment']['wechat'];
    if (intval($wxpay['switch']) == 3) {
        $oauth_account = uni_setting($wxpay['service'], array('payment'));
        $oauth_acid = pdo_getcolumn('uni_account', array('uniacid' => $wxpay['service']), 'default_acid');
        $oauth_appid = pdo_getcolumn('account_wechats', array('acid' => $oauth_acid), 'key');
        $wxpay_settting = array(
            'appid' => $oauth_appid,
            'mch_id' => $oauth_account['payment']['wechat_facilitator']['mchid'],
            'sub_mch_id' => $wxpay['sub_mch_id'],
            'signkey' => $wxpay['signkey'],
        );

    } else {
        $wxpay_settting = array(
            'appid' => $_W['account']['key'],
            'mch_id' => $wxpay['mchid'],
            'signkey' => $wxpay['signkey'],
        );
    }



    $withdraw_param = array(
        'mch_appid' => $wxpay_settting['appid'],
        'mchid' => $wxpay_settting['mch_id'],
        'nonce_str' => random(32),
        'partner_trade_no' => $param['orderno'],
        'openid' => $param['openid'],
        'check_name' => 'NO_CHECK',
        'amount' => $param['amount'] * 100,
        'desc' => $param['desc'],
        'spbill_create_ip' => $_SERVER['SERVER_ADDR']
    );


    $data=array_filter($withdraw_param);
    ksort($withdraw_param);
    $str='';
    foreach($withdraw_param as $k=>$v) {
        $str.=$k.'='.$v.'&';
    }
    $str.='key='.$wxpay_settting['signkey'];
    $withdraw_param['sign']=md5($str);


    $xml=arraytoxml($withdraw_param);


    /*
 $string1 = '';
 foreach($withdraw_param as $key => $v) {
     if (empty($v)) {
         continue;
     }
     $string1 .= "{$key}={$v}&";
 }
    $string1 .= "key={$wxpay_settting['signkey']}";
    $withdraw_param['sign'] = strtoupper(md5($string1));*/

    /*
     if (is_error($response)) {
         //pdo_update('core_refundlog', array('status' => '-1'), array('id' => $refund_id));
         return $response;
     } else {
         pdo_update('ypuk_ffyd_withdrawlog', array('status' => '1'), array('id' =>  $param['withdrawlog_id']));
         return $response;
     }
    */
    $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
    $res=curl($xml,$url,$_W['acid']);
    $return=xmltoarray($res);
    if($return['return_code'] == 'SUCCESS' && $return['result_code'] == 'SUCCESS'){
            pdo_update('ypuk_ffyd_userwithdraw', array('status' => '1'), array('id' =>  $param['withdrawlog_id']));
    }else{

        message('同意提现失败，错误提示【'.$return['return_msg'].'】',referer());
    }

}






function unicode() {
    $str = uniqid(mt_rand(),1);
    $str=sha1($str);
    return md5($str);
}
function arraytoxml($data){
    $str='<xml>';
    foreach($data as $k=>$v) {
        $str.='<'.$k.'>'.$v.'</'.$k.'>';
    }
    $str.='</xml>';
    return $str;
}
function xmltoarray($xml) {
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    $val = json_decode(json_encode($xmlstring),true);
    return $val;
}
function curl($param="",$url,$weid) {

    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init();                                      //初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);           // 增加 HTTP Header（头）里的字段
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch,CURLOPT_SSLCERT,ATTACHMENT_ROOT.'/ypuk_ffyd/cert_'.$weid.'/apiclient_cert.pem'); //这个是证书的位置
    curl_setopt($ch,CURLOPT_SSLKEY,ATTACHMENT_ROOT.'/ypuk_ffyd/cert_'.$weid.'/apiclient_key.pem'); //这个也是证书的位置
    $data = curl_exec($ch);                                 //运行curl
    curl_close($ch);
    return $data;
}