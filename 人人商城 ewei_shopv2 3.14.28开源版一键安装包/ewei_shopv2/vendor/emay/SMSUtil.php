<?php

require_once( dirname(__FILE__) . '/SMSClient.php');

class SMSUtil {

    public $gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';
    public $serialNumber = '';
    public $password = '';
    public $sessionKey = '';
    public $connectTimeOut = 2;
    public $readTimeOut = 10;
    public $proxyhost = false;
    public $proxyport = false;
    public $proxyusername = false;
    public $proxypassword = false;
    public $client = null;

    public function __construct($gwUrl , $serialNumber,$password,$sessionKey,$proxy,$timeout,$response_timeout) {

        $this->gwUrl = $gwUrl;
        $this->serialNumber = $serialNumber;
        $this->password = $password;
        $this->sessionKey = $sessionKey;
        $this->connectTimeOut = $timeout;
        $this->readTimeOut = $response_timeout;
        $this->proxyhost = empty($proxy['proxyhost'])?false:$proxy['proxyhost'];
        $this->proxyport = empty($proxy['$proxyport'])?false:$proxy['proxyport'];
        $this->proxyusername = empty($proxy['proxyusername'])?false:$proxy['proxyusername'];
        $this->proxypassword = empty($proxy['proxypassword'])?false:$proxy['proxypassword'];
        
        $this->client = new SMSClient($this->gwUrl
                , $this->serialNumber
                , $this->password
                , $this->sessionKey
                , $this->proxyhost
                , $this->proxyport
                , $this->proxyusername
                , $this->proxypassword
                , $this->connectTimeOut
                , $this->readTimeOut);
        $this->client->setOutgoingEncoding("UTF-8");
    }

    /**
     * 余额查询
     */
    function getBalance() {
        return $this->client->getBalance();
    }

    function register($eName, $linkMan, $phoneNum, $mobile, $email, $fax, $address, $postcode) {
        return $this->client->registDetailInfo($eName, $linkMan, $phoneNum, $mobile, $email, $fax, $address, $postcode);
    }
    /**
     * 登录
     */
    function login() {
        return $this->client->login();
    }
    /**
     * 注销登录
     */
    function logout() {
        return $this->client->logout();
    }
    /**
     * 短信发送
     */
    function send($mobile = '', $msg = '') {
        $this->client->sendSMS(array($mobile), $msg);
        return $this->chkError();
    }

    /**
     * 接口调用错误查看 用例
     */
    function chkError() {

        $err = $this->client->getError();
        if ($err) {
            return $err;
        }
        return "";
    }

    /**
     * 获取版本号 用例
     */
    function getVersion() {
        return $this->client->getVersion();
    }

    /**
     * 更新密码 用例
     */
    function changePassword($pwd = '') {
        return $this->client->updatePassword($pwd);
    }

}
