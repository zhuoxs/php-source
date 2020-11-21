<?php

require __DIR__ . "/../../plugin/tengxun/qcloud/index.php";

use Qcloud\Sms\SmsSingleSender;
use Qcloud\Sms\SmsMultiSender;
use Qcloud\Sms\SmsVoiceVerifyCodeSender;
use Qcloud\Sms\SmsVoicePromptSender;
use Qcloud\Sms\SmsStatusPuller;
use Qcloud\Sms\SmsMobileStatusPuller;

use Qcloud\Sms\VoiceFileUploader;
use Qcloud\Sms\FileVoiceSender;
use Qcloud\Sms\TtsVoiceSender;


class Qcloud {

    public static  $instance;
    public   $appid = "";
    public   $appkey = "";
    public   $sign = "";
    public static  function Instance(){
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct()
    {
        global  $_W;
        $detail = pdo_get('ox_master_code',[  'uniacid'=>$_W['uniacid']]);
        if($detail){
            $this->appid = $detail['appid'];//'1400195467';
            $this->appkey = $detail['appkey'];//'d876d7b38a1cce94f23bf0206133e9c3';
            $this->sign = $detail['sign'];//'d876d7b38a1cce94f23bf0206133e9c3';
        }else{
            return $this->result(1, '短信还未设置','');
        }

    }

    // 单发短信
    public function oneSend(){
        // 需要发送短信的手机号码
        $phoneNumbers = ["13864984442"];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 322529;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "临沂零象信息科技有限公司"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        try {
            $ssender = new SmsSingleSender($this->appid, $this->appkey);
            $result = $ssender->send(0, "86", $phoneNumbers[0],
                "雇主发布订单了，赶快打开小程序去抢单吧  回T退订", "", "");
            $rsp = json_decode($result);
            echo $result;
        } catch(\Exception $e) {
            echo var_dump($e);
        }
    }

    // 指定模板ID单发短信
    public function tempSend($data,$params=[]){
        // 短信模板ID，需要在短信应用中申请
        global  $_W;
        if(!$this->appid||!$this->appkey||!$this->sign){
            return false;
        }
        $detail = pdo_get('ox_uxuanke_sms_template',[  'uniacid'=>$_W['uniacid'],'is_enable'=>1,'template_code'=>$data['template_code']]);
        if(!$detail){
            return false;
        }
        $templateId = $detail['template_title'];  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = $this->sign ; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`

        $ssender = new SmsSingleSender($this->appid, $this->appkey);
        $result = $ssender->sendWithParam("86", $data['phone'], $templateId,
            $params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
        $rsp = json_decode($result,true);
        $idata['uniacid'] = $_W['uniacid'];
        $idata['send_account'] = $data['phone'];
        $idata['records_type'] = $data['records_type'];
        $idata['notice_content'] = $detail['template_content'];
        $idata['send_status'] = $rsp['result'] == 0 ? 1 : 2;
        $idata['send_message'] = $rsp['errmsg'];
        $idata['create_time'] = time();
        pdo_insert("ox_master_sms_records",$idata);
        if($rsp['result']==0){
            return true;
        }else{
            return false;
        }
    }


    // 群发
    public function groupSend(){
        // 需要发送短信的手机号码
        $phoneNumbers = ["21212313123", "12345678902", "12345678903"];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "腾讯云"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        try {
            $msender = new SmsMultiSender($this->appid, $this->appkey);
            $result = $msender->send(0, "86", $phoneNumbers,
                "【腾讯云】您的验证码是: 5678", "", "");
            $rsp = json_decode($result);
            echo $result;
        } catch(\Exception $e) {
            echo var_dump($e);
        }
    }

    // 指定模板ID群发
    public function tempGroupSend($data,$params=[]){
        global  $_W;
        // 需要发送短信的手机号码
        $phoneNumbers = $data['phone'];
        // 短信模板ID，需要在短信应用中申请
        $detail = pdo_get('ox_master_sms_template',['uniacid'=>$_W['uniacid'],'is_enable'=>1,'template_code'=>$data['template_code']]);
        if(!$detail){
            return false;
        }
        $templateId = $detail['template_title'];
        // $templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = $this->sign ;// NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`

        $msender = new SmsMultiSender($this->appid, $this->appkey);
        $result = $msender->sendWithParam("86", $phoneNumbers,
            $templateId, $params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
        $rsp = json_decode($result,true);
        $idata['uniacid'] = $_W['uniacid'];
        if($data['phone']&&count($data['phone'])>0){
            $idata['send_account'] = implode(',',$data['phone']);
        }else{
            $idata['send_account']='';
        }
        $idata['records_type'] = $data['records_type'];
        $idata['notice_content'] = $detail['template_content'];
        $idata['send_status'] = $rsp['result'] == 0 ? 1 : 2;
        $idata['send_message'] = $rsp['errmsg'];
        $idata['create_time'] = time();
        pdo_insert("ox_master_sms_records",$idata);
        if($rsp['result']==0){
            return true;
        }else{
            return false;
        }


    }

    // 发送语音验证码
    public function vvcSend(){
        // 需要发送短信的手机号码
        $phoneNumbers = ["21212313123", "12345678902", "12345678903"];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "腾讯云"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        try {
            $vvcsender = new SmsVoiceVerifyCodeSender($this->appid, $this->appkey);
            $result = $vvcsender->send("86", $phoneNumbers[0], "5678", 2, "");
            $rsp = json_decode($result);
            echo $result;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
    }



    // 发送语音通知
    public function vpSend(){

        // 需要发送短信的手机号码
        $phoneNumbers = ["21212313123", "12345678902", "12345678903"];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "腾讯云"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        try {
            $vpsender = new SmsVoicePromptSender($this->appid, $this->appkey);
            $result = $vpsender->send("86", $phoneNumbers[0], 2, "5678", "");
            $rsp = json_decode($result);
            echo $result;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
        echo "\n";
    }

    // 拉取短信回执以及回复
    public function sspuller(){

        // 需要发送短信的手机号码
        $phoneNumbers = ["21212313123", "12345678902", "12345678903"];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "腾讯云"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        try {
            $sspuller = new SmsStatusPuller($this->appid, $this->appkey);

            // 拉取短信回执
            $callbackResult = $sspuller->pullCallback(10);
            $callbackRsp = json_decode($callbackResult);
            echo $callbackResult;

            // 拉取回复
            $replyResult = $sspuller->pullReply(10);
            $replyRsp = json_decode($replyResult);
            echo $replyResult;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
    }

    // 拉取单个手机短信状态
    public function mspuller(){

        // 需要发送短信的手机号码
        $phoneNumbers = ["21212313123", "12345678902", "12345678903"];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "腾讯云"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        try {
            $beginTime = 1516670595;  // 开始时间(unix timestamp)
            $endTime = 1516680595;    // 结束时间(unix timestamp)
            $maxNum = 10;             // 单次拉取最大量
            $mspuller = new SmsMobileStatusPuller($this->appid, $this->appkey);

            // 拉取短信回执
            $callbackResult = $mspuller->pullCallback("86", $phoneNumbers[0],
                $beginTime, $endTime, $maxNum);
            $callbackRsp = json_decode($callbackResult);
            echo $callbackResult;
            echo "\n";

            // 拉取回复
            $replyResult = $mspuller->pullReply("86", $phoneNumbers[0],
                $beginTime, $endTime, $maxNum);
            $replyRsp = json_decode($replyResult);
            echo $replyResult;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
    }
    // 上传语音文件
    public function uploader(){

        // 需要发送短信的手机号码
        $phoneNumbers = ["21212313123", "12345678902", "12345678903"];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "腾讯云"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        try {
            $filepath = "path/to/example.mp3";
            $fileContent = file_get_contents($filepath);
            if ($fileContent == false) {
                throw new \Exception("can not read file " . $filepath);
            }

            $contentType = VoiceFileUploader::MP3;
            $uploader = new VoiceFileUploader($this->appid, $this->appkey);
            $result = $uploader->upload($fileContent, $contentType);
            $rsp = json_decode($result);
            echo $result;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
    }
    // 按语音文件fid发送语音通知
    public function fvSend(){

        // 需要发送短信的手机号码
        $phoneNumbers = ["21212313123", "12345678902", "12345678903"];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "腾讯云"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        try {
            $fid = "73844bb649ca38f37e596ec2781ce6a56a2a3a1b.mp3";

            $fvsender = new FileVoiceSender($this->appid, $this->appkey);
            $result = $fvsender->send("86", $phoneNumbers[0], $fid);

            $rsp = json_decode($result);
            echo $result;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
    }
    // 指定模板发送语音通知类
    public function tvSend(){
        // 需要发送短信的手机号码
        $phoneNumbers = ["21212313123", "12345678902", "12345678903"];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "腾讯云"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        try {
            $templateId = 1013;
            $params = ["54321"];

            $tvsender = new TtsVoiceSender($this->appid, $this->appkey);
            $result = $tvsender->send("86", $phoneNumbers[0], $templateId, $params);

            $rsp = json_decode($result);
            echo $result;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
    }

}



