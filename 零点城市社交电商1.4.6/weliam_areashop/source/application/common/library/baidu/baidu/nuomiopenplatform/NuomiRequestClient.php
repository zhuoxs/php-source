<?php

/**
 * Created by PhpStorm.
 * User: sunyaoyao
 * Date: 2015/9/7
 * Time: 14:26
 */
class NuomiRequestClient
{

    private $nopAppId = 'yrO7h9xWcw';


    public $connectTimeout;
    public $readTimeout;


    //入参默认开启
    public $checkRequest = true;

    /**
     * nop平台
     */
    CONST PLATFROM_NOP = 'nop';

    /**
     * openapi平台
     */
    CONST PLATFROM_OPENAPI = 'openapi';


    /**
     * @desc 传入在上文中已经设置过参数的request实体，然后执行请求
     * @notice1 如果是请求银河的接口，就会域名都会换
     * @param NuomiIntegrationCashierOrderConsumeRequest | NuomiIntegrationCashierGetUserInfoRequest $request
     * @return
     * 入口函数
     */
    public function exec($request)
    {

        /**
         * 第一部分：首先根据request里面的所属的平台来决定相关的参数
         */

        /**
         * 1.从request类中获取的各种参数
         */
        $requestPlatform = $request->getRequestPlatform();
        $req = $request->getApiParams();

        if( $requestPlatform == self::PLATFROM_NOP ){

            //2.组装给nop平台的系统参数
            $sysParams['nop_appid'] = $this->nopAppId;
            $sysParams['nop_method'] = $request->getNopMethod();
            $sysParams['nop_timestamp'] = time();

            //3.计算nop所需要的md5签名
            $sysParams['nop_sign'] = 'nuomiopenplatfomsdk';

            //4.银河的接口
            $requestUrl = $request->getUrlForNop($sysParams);

        }
        else if ( $requestPlatform == self::PLATFROM_OPENAPI ){

            /**
             * @notice1:appKey，每个应用方都不一样，所以不能由配置文件RequestClient类固定
             * @notice2:其他的参数，都是业务方的参数，所以不能由配置文件RequestClient类固定
             * @notice3:私钥，每个应用方也不一样，所以不能由配置文件RequestClient类固定
             */
            $requestUrl = $request->getUrlForOpenApi();

            /**
             * 7.openapi的参数签名的键名是sign,不是rsaSign，这个是不一样的地方
             */
            $req['sign'] = $req['rsaSign'];

            unset( $req['rsaSign'] );
        }


        /**
         * 第二部分：对参数有效性进行检验
         */
        if ($this->checkRequest) {

            try {
                $request->checkRequestParams($req);
            }
            catch (Exception $e) {
                $result['errno'] = $e->getCode();
                $result['errmsg'] = $e->getMessage();
                return $result;
            }
        }

        /**
         * 第三部分：请求相关接口
         */
        $result = $this->call($requestUrl, $req);
        return $result;
    }


    /**
     * @desc 为开放平台计算签名
     * @notice1 这个签名是rsa形式的
     * @param array $assocArr
     * @param $rsaPriKeyStr
     * @return bool|string $sign
     * @throws Exception
     */

    private function generateSignForOpenApi($assocArr,$rsaPriKeyStr){

        $sign = '';
        if (empty($rsaPriKeyStr) || empty($assocArr)) {
            return $sign;
        }

        if (!function_exists('openssl_pkey_get_private') || !function_exists('openssl_sign')) {
            throw new Exception('SYS_ERR_OPENSSL_NOT_SUPPORT');
        }

        $priKey = openssl_pkey_get_private($rsaPriKeyStr);

        if (isset($assocArr['sign'])) {
            unset($assocArr['sign']);
        }

        ksort($assocArr); //按字母升序排序

        $parts = array();
        foreach ($assocArr as $k => $v) {
            $parts[] = $k . '=' . $v;
        }
        $str = implode('&', $parts);
        openssl_sign($str, $sign, $priKey);
        openssl_free_key($priKey);

        return base64_encode($sign);
    }


    /**
     * @param string $url
     * @param array $arrParams
     * @return mixed
     * @throws Exception
     */
    private function call( $url ,$arrParams)
    {
        $postFields = $arrParams;

        /**
         * 第二部分：初始化curl的相关参数
         */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($this->readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
        }

        if ($this->connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }

        curl_setopt($ch, CURLOPT_USERAGENT, "nuomiopenplatfomsdk");

        //https 请求
        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (is_array($postFields) && 0 < count($postFields)) {
            $postBodyString = "";
            $postMultipart = false;
            foreach ($postFields as $k => $v) {
                if ("@" != substr($v, 0, 1))//判断是不是文件上传
                {
                    $postBodyString .= "$k=" . urlencode($v) . "&";
                }
                else//文件上传用multipart/form-data，否则用www-form-urlencoded
                {
                    $postMultipart = true;
                }
            }
            unset($k, $v);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($postMultipart) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            } else {
                $header = array("content-type: application/x-www-form-urlencoded; charset=UTF-8");
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
            }
        }

        $reponse = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new Exception($reponse, $httpStatusCode);
            }
        }
        curl_close($ch);
        return $reponse;
    }
}