<?php
/**
 * 【超人】超级商城模块，阿里大于（新）短信接口
 *
 * @author 超人
 * @url http://bbs.we7.cc/thread-13060-1-1.html
 */
class XiaofSms_alidayu_new extends Xiaofsendsms {
    public function __construct() {
        parent::__construct();
        if (defined('SUPERMAN_DEVELOPMENT')) {
            $this->debug = true;
        }
    }
    public function send($mobile, $message, $template = array(), $check_total = false, $extra = array()) {
        if (!preg_match(SUPERMAN_REGULAR_MOBILE, $mobile)) {
            WeUtility::logging('fatal', '[XiaofSms_alidayu_new::send] failed, mobile('.$mobile.') invalid');
            return false;
        }
        include_once MODULE_ROOT.'class/smsapi/alidayu_new/aliyun-php-sdk-core/Config.php';
        include_once MODULE_ROOT.'class/smsapi/alidayu_new/Dysmsapi/Request/V20170525/SendSmsRequest.php';
        //include_once MODULE_ROOT.'/class/smsapi/alidayu_new/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';
        //此处需要替换成自己的AK信息
        $accessKeyId = $this->account['app_key'];
        $accessKeySecret = $this->account['app_secret'];
        //短信API产品名
        $product = $this->account['product']?$this->account['product']:'Dysmsapi';
        //短信API产品域名
        $domain = $this->account['domain']?$this->account['domain']:'dysmsapi.aliyuncs.com';
        //暂时不支持多Region
        $region = $this->account['region']?$this->account['region']:'cn-hangzhou';

        //初始化访问的acsCleint
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
        $acsClient= new DefaultAcsClient($profile);

        $request = new Dysmsapi\Request\V20170525\SendSmsRequest;
        //必填-短信接收号码
        $request->setPhoneNumbers($mobile);
        //必填-短信签名
        $request->setSignName($this->account['signature']);
        //必填-短信模板Code
        $request->setTemplateCode($template['id']);
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)
        //$request->setTemplateParam("{\"code\":\"{$template['code']}\",\"product\":\"阿里大于\"}");
        $request->setTemplateParam($template['params']);
        //选填-发送短信流水号
        //$request->setOutId("1234");

        //发起访问请求
        $acsResponse = $acsClient->getAcsResponse($request);

        $code = strtolower($acsResponse->Code);
        if ($code == 'ok') {
            if ($this->debug) {
                WeUtility::logging('trace', "[XiaofSms_alidayu_new::send] success, mobile={$mobile}, template_id={$template['id']}, signature={$this->account['signature']}");
            }
            return true;
        } else {
            WeUtility::logging('fatal', "[XiaofSms_alidayu_new::send] failed, account=".var_export($this->account, true).', response='.var_export($acsResponse, true).', template='.var_export($template, true));
            return $acsResponse->Code.', '.$acsResponse->Message;
        }
    }
    public function balance() {
        return -1;
    }
}