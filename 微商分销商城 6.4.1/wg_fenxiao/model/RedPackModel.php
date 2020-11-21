<?php

class RedPackModel extends BaseModel
{
    protected $table = 'wg_fenxiao_hongbao';

    public $accounts;

    /*
    public function sendRedPack($ordersn, $openid, $settings, $p, $amount, $weid, $billno) {
        $db_data['err_code'] = 'SUCCESS';
        $db_data['err_code_des'] = '发送成功，领取红包';
        $db_data['return_msg'] = serialize([
            'total_amount' => $amount,
            'send_listid'  => '100000000020150520314766074200'
        ]);
        return $db_data;
        global $_W;
        if (!empty($weid)) {
            $_W['uniacid'] = $weid;
            load()->model('account');
            $accounts = uni_accounts($weid);
            $_W['account']['key'] = $accounts[$weid]['key'];
            $_W['account']['name'] = $accounts[$weid]['name'];
        }
        $payment = uni_setting($_W['uniacid'], array(
            'payment'
        ));
        $paysets = $payment['payment']['wechat'];
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';

        $pars = array();
        //随机字符串
        $pars['nonce_str']    = random(32);
        //商户订单号，想改ordersn+随机字符串
        $pars['mch_billno']   = $billno;
        $pars['mch_id']       = $paysets['mchid']; //商户号
        $pars['wxappid']      = $_W['account']['key'];
        $pars['send_name']    = $_W['account']['name']; //商户名称
        $pars['re_openid']    = $openid; //接受用户
        $pars['total_amount'] = $amount;
        $pars['total_num']    = 1;
        //红包祝福
        $pars['wishing']   = $ordersn . '的' . $p . '级红包。' . $settings['hongbaozhufu'];
        $pars['client_ip'] = $settings['honbaoip']; //来自配置文件
        $pars['act_name']  = $settings['act_name']; //来自配置文件
        $pars['remark']    = $settings['remark']; //来自配置文件
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1.= "{$k}={$v}&";
        }
        //商户秘钥
        $string1.= "key={$paysets['apikey']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CAINFO']  = $settings['rootca'];
        $extras['SSLCERT'] = $settings['apiclient_cert'];
        $extras['SSLKEY']  = $settings['apiclient_key'];
        $response          = $this->http_request($url, $xml, $extras, 'post');
        $responseObj       = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        $aMsg = (array)$responseObj;
        if (isset($aMsg['err_code'])) {
            $db_data['err_code'] = $aMsg['err_code'];
            $db_data['err_code_des'] = $aMsg['err_code_des'];
        } else {
            $db_data['err_code'] = 'SUCCESS';
            $db_data['err_code_des'] = '发送成功，领取红包';
        }['config']
        $db_data['return_msg'] = serialize($aMsg);

        return $db_data;
    }
    */


    public function sendRedPackNew($openid, $settings, $amount, $weid, $billno) {
//        $db_data['err_code'] = 'SUCCESS';
//        $db_data['err_code_des'] = '发送成功，领取红包';
//        $db_data['return_msg'] = serialize([
//            'total_amount' => $amount,
//            'send_listid'  => '100000000020150520314766074200'
//        ]);
//        return $db_data;
        global $_W;
        if (!empty($weid)) {
            $_W['uniacid'] = $weid;
            load()->model('account');
            $accounts = uni_accounts($weid);
            $_W['account']['key'] = $accounts[$weid]['key'];
            $_W['account']['name'] = $accounts[$weid]['name'];
        }
        $payment = uni_setting($_W['uniacid'], array(
            'payment'
        ));
        $paysets = $payment['payment']['wechat'];
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';

        $pars = array();
        //随机字符串
        $pars['nonce_str']    = random(32);
        //商户订单号，想改ordersn+随机字符串
        $pars['mch_billno']   = $billno;
        $pars['mch_id']       = $paysets['mchid']; //商户号
        $pars['wxappid']      = $_W['account']['key'];
        $pars['send_name']    = $_W['account']['name']; //商户名称
        $pars['re_openid']    = $openid; //接受用户
        $pars['total_amount'] = $amount;
        $pars['total_num']    = 1;
        //红包祝福
        $pars['wishing']   = $settings['config']['hongbaozhufu'];
        $pars['client_ip'] = $settings['config']['honbaoip']; //来自配置文件
        $pars['act_name']  = $settings['config']['act_name']; //来自配置文件
        $pars['remark']    = $settings['config']['remark']; //来自配置文件
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1.= "{$k}={$v}&";
        }
        //商户秘钥
        $string1.= "key={$paysets['apikey']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CAINFO']  = $settings['config']['rootca'];
        $extras['SSLCERT'] = $settings['config']['apiclient_cert'];
        $extras['SSLKEY']  = $settings['config']['apiclient_key'];
        $response          = $this->http_request($url, $xml, $extras, 'post');
        $responseObj       = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        $aMsg = (array)$responseObj;
        if (isset($aMsg['err_code']) || !$response) {
            $db_data['err_code'] = $aMsg['err_code'];
            $db_data['err_code_des'] = $aMsg['err_code_des'];
        } else {
            $db_data['err_code'] = 'SUCCESS';
            $db_data['err_code_des'] = '发送成功，领取红包';
        }
        $db_data['return_msg'] = serialize($aMsg);

        return $db_data;
    }


    protected function http_request($url, $fields, $params, $method = 'get', $second = 30) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (isset($params)) {
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, $params['SSLCERT']);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, $params['SSLKEY']);
            curl_setopt($ch, CURLOPT_CAINFO, 'PEM');
            curl_setopt($ch, CURLOPT_CAINFO, $params['CAINFO']);
        }
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}