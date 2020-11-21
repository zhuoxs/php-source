<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyWeChat\Payment\Security;

use EasyWeChat\Payment\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author overtrue <i@overtrue.me>
 */
class Client extends BaseClient
{
    /**
     * @return mixed
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getPublicKey()
    {
        $params = [
            'sign_type' => 'MD5',
        ];
        return $this->safeRequest('https://fraud.mch.weixin.qq.com/risk/getpublickey', $params);
    }
//    public function httpsPost($data,$ssl = false,$url = 'https://fraud.mch.weixin.qq.com/risk/getpublickey')
//    {
//        $ch = curl_init ();
//        curl_setopt ( $ch, CURLOPT_URL, $url );
//        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
//        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
//        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
//        if($ssl) {
//            curl_setopt ( $ch,CURLOPT_SSLCERT,'/www/wwwroot/devwe7.weliam.cn/addons/weliam_areashop/web/uploads/1/file/2019/06/apiclient_cert.pem');
//            curl_setopt ( $ch,CURLOPT_SSLKEY,'/www/wwwroot/devwe7.weliam.cn/addons/weliam_areashop/web/uploads/1/file/2019/06/apiclient_key.pem');
//        }
//        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
//        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
//        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
//        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
//        $result = curl_exec($ch);
//        if (curl_errno($ch)) {
//            return 'Errno: '.curl_error($ch);
//        }
//        curl_close($ch);
//        return $this->xmlToArray($result);
//    }
//    private function xmlToArray($xml)
//    {
//        //禁止引用外部xml实体
//        libxml_disable_entity_loader(true);
//        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
//        $val = json_decode(json_encode($xmlstring),true);
//        return $val;
//    }

}
