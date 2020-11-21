<?php
load()->classs('weixin.platform');
class AccModel extends WeiXinPlatform{

    public $curl_timeout = 3000;


    public function __construct($account = []) {
        global $_W, $_GPC;
        $this->account = $account;
        parent::__construct($_W['account']);
    }

    /**
     * @param $scope (snsapi_base|snsapi_userinfo)
     * @return string
     */
    public function getOpenid($scope) {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);

            $url = $this->__CreateOauthUrlForCode($baseUrl, $scope);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            return $this->getOpenidFromMp($code);
        }
    }

    /**
     * @param $scope (snsapi_base|snsapi_userinfo)
     * @return string
     */
    public function getOpenid3($scope) {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);

            $url = $this->__CreateOauthUrlForCode3($baseUrl, $scope);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            return $this->getOpenidFromMp3($code);
        }
    }

    public function getUserInfo($access_token, $openid) {
        return $this->__CreateOauthUrlForUserInfo($access_token, $openid);
    }

    public function getUserInfo3($access_token, $openid) {
        return $this->__CreateOauthUrlForUserInfo3($access_token, $openid);
    }


    /**
     *
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     *
     * @return string openid
     */
    public function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        return $this->_curl($url);
    }

    /**
     *
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     *
     * @return string openid
     */
    public function GetOpenidFromMp3($code)
    {
        return $this->getOauthInfo($code);
    }

    private function _curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }

    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     *
     * @return string 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }



    /**
     *
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     *
     * @return string 返回构造好的url
     */
    private function __CreateOauthUrlForCode($redirectUrl, $scope)
    {
        global $_W;
        $urlObj["appid"] = $_W['account']['key'];
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = $scope;
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    /**
     *
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     *
     * @return string 返回构造好的url
     */
    private function __CreateOauthUrlForCode3($redirectUrl, $scope)
    {
        global $_W;
        $urlObj["appid"] = $_W['account']['key'];
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = $scope;
        $urlObj["state"] = "STATE";
        $urlObj["component_appid"] = $_W['setting']['platform']['appid']."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    /**
     *
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     *
     * @return string 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        global $_W;
        $urlObj["appid"] = $_W['account']['key'];
        $urlObj["secret"] = $_W['account']['secret'];
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }

    /**
     *
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     *
     * @return string 请求的url
     */
    private function __CreateOauthUrlForOpenid3($code)
    {
        global $_W;
        $urlObj["appid"] = $_W['account']['key'];
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $urlObj["component_appid"] = $_W['setting']['platform']['appid'];
        $urlObj["component_access_token"] = $_W['setting']['platform']['token'];
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/component/access_token?".$bizString;
    }

    /**
     * @param $access_token
     * @param $openid
     * @return string
     */
    private function __CreateOauthUrlForUserInfo($access_token, $openid)
    {
        $urlObj["access_token"] = $access_token;
        $urlObj["openid"] = $openid;
        $urlObj["lang"] = 'zh_CN';
        $bizString = $this->ToUrlParams($urlObj);
        $url = "https://api.weixin.qq.com/sns/userinfo?".$bizString;
        return $this->_curl($url);
    }

    /**
     * @param $access_token
     * @param $openid
     * @return string
     */
    private function __CreateOauthUrlForUserInfo3($access_token, $openid)
    {
        $urlObj["access_token"] = $access_token;
        $urlObj["openid"] = $openid;
        $urlObj["lang"] = 'zh_CN';
        $bizString = $this->ToUrlParams($urlObj);
        $url = "https://api.weixin.qq.com/sns/userinfo?".$bizString;
        return $this->_curl($url);
    }
}
