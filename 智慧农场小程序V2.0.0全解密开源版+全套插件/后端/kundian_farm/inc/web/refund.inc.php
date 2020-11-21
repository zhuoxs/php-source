<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27 0027
 * Time: 17:46
 */
defined("IN_IA") or exit("Access denied");
global $_W,$_GPC;
$uniacid=$_W['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] :'index';


/**
 * 生成退款订单
 * @param $tid  订单号
 * @param $module   模块名称
 * @param $fee  退款金额
 * @param $reason   退款原因
 * @return array|bool
 */
function refund_create_order1($tid,$module,$fee='',$reason=''){
    global $_W;
    $order_can_refund=refund_order_can_refund($module,$tid);
    if(is_error($order_can_refund)){
        return $order_can_refund;
    }
    $module_info=module_fetch($module);
    $moduleid=empty($module_info['mid']) ? '000000' :sprintf('%06d',$module_info['mid']);
    $refund_uniontid=date('YmdHis').$moduleid.random(8,1);
    $paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'tid' => $tid, 'module' => $module));
    $refund = array (
        'uniacid' => $_W['uniacid'],
        'uniontid' => $paylog['uniontid'],
        'fee' => empty($fee) ? $paylog['card_fee'] : $fee,
        'status' => 0,
        'refund_uniontid' => $refund_uniontid,
        'reason' => $reason
    );
    pdo_insert('core_refundlog', $refund);
    return pdo_insertid();
}

/**
 * 判断改模快下的订单是否支持退款
 * @param $module
 * @param $tid
 * @return array|bool
 */
function refund_order_can_refund($module, $tid) {
    global $_W;
    $paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'tid' => $tid, 'module' => $module));
    if (empty($paylog)) {
        return error(1, '订单不存在');
    }
    if ($paylog['status'] != 1) {
        return error(1, '此订单还未支付成功不可退款');
    }
    $refund_amount = pdo_getcolumn('core_refundlog', array('uniacid' => $_W['uniacid'], 'status' => 1, 'uniontid' => $paylog['uniontid']), 'SUM(fee)');
    if ($refund_amount >= $paylog['card_fee']) {
        return error(1, '订单已退款成功');
    }
    return true;
}

function refund($refund_id){
    global $_W;
    $refundlog = pdo_get('core_refundlog', array('id' => $refund_id));
//    $paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'uniontid' => $refundlog['uniontid']));
    $response = reufnd_wechat_build($refund_id);
    if (is_error($response)) {
        pdo_update('core_refundlog', array('status' => '-1'), array('id' => $refund_id));
        return $response;
    } else {
        return $response;
    }
}
function reufnd_wechat_build($refund_id) {
    global $_W;
    $setting = uni_setting_load('payment', $_W['uniacid']);
    $refund_setting = $setting['payment']['wechat_refund'];
    if ($refund_setting['switch'] != 1) {
        return error(1, '未开启微信退款功能！');
    }
    if (empty($refund_setting['key']) || empty($refund_setting['cert'])) {
        return error(1, '缺少微信证书！');
    }

    $refundlog = pdo_get('core_refundlog', array('id' => $refund_id));
    $paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'uniontid' => $refundlog['uniontid']));
    $account = uni_fetch($_W['uniacid']);
    $refund_param = array(
        'appid' => $account['key'],
        'mch_id' => $setting['payment']['wechat']['mchid'],
        'out_trade_no' => $refundlog['uniontid'],
        'out_refund_no' => $refundlog['refund_uniontid'],
        'total_fee' => $paylog['card_fee'] * 100,
        'refund_fee' => $refundlog['fee'] * 100,
        'nonce_str' => random(8),
        'op_user_id' => $setting['payment']['wechat']['mchid']
    );
    $refund_param['sign'] =getSign($refund_param,$setting['payment']['wechat']['signkey']);

    $xmldata = arrayToXml($refund_param);

    $xmlresult = postXmlSSLCurl($xmldata,'https://api.mch.weixin.qq.com/secapi/pay/refund');

    $result =xmlToArray($xmlresult);
    return $result;
}

function postXmlSSLCurl($xml,$url,$second=30)
{
    global $_W;
    $ch = curl_init();
    //超时时间
    curl_setopt($ch,CURLOPT_TIMEOUT,$second);
    //这里设置代理，如果有的话
    //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
    //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
    //设置header
    curl_setopt($ch,CURLOPT_HEADER,FALSE);
    //要求结果为字符串且输出到屏幕上
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
    //设置证书
    //使用证书：cert 与 key 分别属于两个.pem文件
    //默认格式为PEM，可以注释
    curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
    curl_setopt($ch,CURLOPT_SSLCERT,ATTACHMENT_ROOT.'/kundian_farm/'.$_W['uniacid'].'/apiclient_cert.pem');
    //默认格式为PEM，可以注释
    curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
    curl_setopt($ch,CURLOPT_SSLKEY, ATTACHMENT_ROOT.'/kundian_farm/'.$_W['uniacid'].'/apiclient_key.pem');
    //post提交方式
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
    $data = curl_exec($ch);
    //返回结果
    if($data){
        curl_close($ch);
        return $data;
    }
    else {
        $error = curl_errno($ch);
        echo "curl出错，错误码:$error"."<br>";
        curl_close($ch);
        return false;
    }
}

function createNoncestr($length = 32 ){
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str ="";
    for ( $i = 0; $i < $length; $i++ ) {
        $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
    }
    return $str;
}
/*
  * 对要发送到微信统一下单接口的数据进行签名
  */
function getSign($Obj,$key){
    foreach ($Obj as $k => $v){
        $Parameters[$k] = $v;
    }
    //签名步骤一：按字典序排序参数
    ksort($Parameters);

    $String =formatBizQueryParaMap($Parameters, false);

    //签名步骤二：在string后加入KEY
    $String = $String.'&key='.$key;
    //签名步骤三：MD5加密
    $String = md5($String);
    //签名步骤四：所有字符转为大写
    $result_ = strtoupper($String);
    return $result_;
}
function xmlToArray($xml){
    $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array_data;
}
function arrayToXml($arr){
    $xml = "<xml>";
    foreach ($arr as $key=>$val)
    {
        if (is_numeric($val)){
            $xml.="<".$key.">".$val."</".$key.">";
        }else{
            $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
    }
    $xml.="</xml>";
    return $xml;
}
function formatBizQueryParaMap($paraMap, $urlencode)
{
    $buff = "";
    ksort($paraMap);
    foreach ($paraMap as $k => $v)
    {
        if($urlencode)
        {
            $v = urlencode($v);
        }
        //$buff .= strtolower($k) . "=" . $v . "&";
        $buff .= $k . "=" . $v . "&";
    }
    $reqPar='';
    if (strlen($buff) > 0)
    {
        $reqPar = substr($buff, 0, strlen($buff)-1);
    }
    return $reqPar;
}

?>