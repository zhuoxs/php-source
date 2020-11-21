<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/1/14 0014
 * Time: 下午 2:09
 * 信息通知模型
 *
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH."model/common.php";
class Notice_KundianFarmModel{
    public $uniacid='';
    static $common='';
    public function __construct($uniacid){
        $this->uniacid=$uniacid;
        self::$common=new Common_KundianFarmModel();
    }

    /** 当物联网设置状态发生变化时向用户发送模板消息
     * @param $did      设备DID
     * @param $touser   用户openid
     * @param $page     消息打开页面
     * @param $formId   发送消息的formid
     * @param $info     自定义信息
     * @return bool|string
     */
    public function noticeControlChange($did,$touser,$page,$formId,$info){
        $wxData=self::$common->getSetData(['mini_device_template_id'],$this->uniacid);
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $value = array(
            "keyword1"=>["value"=>$did, "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$info, "color"=>"#9b9b9b"],
            "keyword3"=>["value"=>date("Y-m-d H:i:s",time()),"color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($touser,$wxData['mini_device_template_id'],$page,$formId,$value);
        $result =$this->https_curl_json($url,$dd,'json');
        return $result;
    }


    /**
     * 后台管理员用户操作成功后 向用户发送消息通知
     * @param $title
     * @param $info
     * @param $touser
     * @param $page
     * @param $formId
     * @return bool|string
     */
    public function sendServiceInfoToUser($title,$info,$touser,$page,$formId){
        $wxData=self::$common->getSetData(['mini_services_template_id'],$this->uniacid);
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $value = array(
            "keyword1"=>["value"=>$title, "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$info, "color"=>"#9b9b9b"],
            "keyword3"=>["value"=>date("Y-m-d H:i:s",time()), "color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($touser,$wxData['mini_services_template_id'],$page,$formId,$value);
        $result = https_curl_json($url,$dd,'json');
        return $result;
    }

    /** 小程序用户支付成功后发送模板消息通知 */
    public function send_msg_to_user($orderData,$prepay_id,$touser,$uniacid,$page){
        $wxData=self::$common->getSetData(['wx_small_template_id'],$uniacid);
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $value = array(
            "keyword1"=>["value"=>$orderData['body'], "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>date("Y-m-d H:i:s",$orderData['create_time']), "color"=>"#9b9b9b"],
            "keyword3"=>["value"=>$orderData['total_price'], "color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($touser,$wxData['wx_small_template_id'],$page,$prepay_id,$value);
        $result = $this->https_curl_json($url,$dd,'json');
        return $result;
    }

    //支付成功通知信息
    public function isPaySendNotice($orderData,$prepay_id,$openid,$uniacid,$page=''){
        //向用户推送消息
        if(empty($page)){
            $page = '/kundian_farm/pages/shop/orderList/index';
        }
        if($prepay_id){
            $this->send_msg_to_user($orderData,$prepay_id,$openid,$uniacid,$page);
        }
        //给店家推送消息
        $this->sendWxTemplate($orderData,$orderData['body'],1);
        //发送QQ邮件
        $mailSet=self::$common->getSetData(['is_open_QQMail_notice'],$uniacid);
        if($mailSet['is_open_QQMail_notice']==1){
            require_once ROOT_PATH.'vendor/QQMailer.php';
            $mailer = new QQMailer(false,$uniacid);
            $mailRes=$mailer->sendMail($orderData,1);
        }
    }

    /** 订单取消通知 向后台发送订单取消通知*/
    public function cancelOrderNotice($orderData){
        $this->sendWxTemplate($orderData,'订单取消通知',2);
        $mailSet=self::$common->getSetData(['is_open_QQMail_notice'],$this->uniacid);
        if($mailSet['is_open_QQMail_notice']==1){
            require_once ROOT_PATH.'vendor/QQMailer.php';
            $mailer = new QQMailer(false,$this->uniacid);
            $mailRes=$mailer->sendMail($orderData,2);
        }
    }

    /** 向后台管理员发送模板消息通知*/
    public function sendWxTemplate($orderData,$title,$order_type){
        global $_W;
        $wxData = pdo_get('cqkundian_farm_wx_set', array('uniacid' => $this->uniacid));
        $setting = uni_setting($_W['uniacid'], array('payment'));
        $wechat = $setting['payment']['wechat'];
        $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wxapp') . ' WHERE `acid`=:acid';
        $row = pdo_fetch($sql, array(':acid' => $wechat['account']));
        $wx_openid = unserialize($wxData['get_openid']);
        for ($i = 0; $i < count($wx_openid); $i++) {
            $this->sendMerchantInfo($wx_openid[$i], $orderData, $this->uniacid,$title,$order_type,$wxData,$row);
        }
    }

    public function sendMerchantInfo($touser,$orderData,$uniacid,$type,$order_type,$wxData,$row){
        $access_token = $this->get_Wx_accessToken($wxData['wx_appid'],$wxData['wx_secret'],$uniacid);
        if($order_type==1){
            $data=[
                'first'=>['value'=>'您有新的订单',"color"=>"#436EEE"],
                'keyword1'=>["value"=>$orderData['order_number']],
                'keyword2'=>["value"=>$orderData['total_price']],
                'keyword3'=>["value"=>$orderData['body']],
                'remark'=>['value'=>'请尽快处理!点击进入查看详情','color'=>'#436EEE'],
            ];
        }elseif ($order_type==2){
            $data=[
                'first'=>['value'=>'订单取消通知',"color"=>"#436EEE"],
                'keyword1'=>["value"=>$orderData['order_number']],
                'keyword2'=>["value"=>$orderData['total_price']],
                'keyword3'=>["value"=>$orderData['body']],
                'remark'=>['value'=>'请尽快处理!点击进入查看详情','color'=>'#436EEE'],
            ];
        }
        $template = [
            'touser' => $touser,
            'template_id' => $wxData['wx_shop_template_id'],
            'data' => $data,
            "miniprogram"=>[
                "appid"=>$row['key'],
                "pagepath"=>"kundian_farm/pages/user/userCenter/index"
            ]
        ];
        $json_template = json_encode($template);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        $dataRes = $this->http_request($url, urldecode($json_template));
        if ($dataRes->errcode == 0) {
            return true;
        }
        return false;
    }

    /**
     * 该模板消息用户发送后台完成除草、杀虫、施肥等操作后向用户通知
     * @param $orderData    订单信息
     * @param $task_template_id  模板消息id
     * @param $remark       说明 【已完成】
     * @param $touser       用户openid
     * @return mixed
     */
    public function sendTaskCompleteNotice($orderData,$task_template_id,$remark,$touser){
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $value = array(
            "keyword1"=>["value"=>$orderData['body'], "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$remark, "color"=>"#9b9b9b"],
            "keyword3"=>["value"=>date("Y-m-d H:i:s",$orderData['operation_time']), "color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($touser,$task_template_id,'/',$orderData['form_id'],$value);
        $result = $this->https_curl_json($url,$dd,'json');
        return $result;
    }

    /**
     * 认养、种植状态消息推送
     * @param $data
     * @param $uid
     * @param $page
     * @return mixed
     */
    public function sendFarmStatusTemplate($data,$uid,$page){
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $form_id=self::$common->getFormId($uid,$this->uniacid);
        $template_id=self::$common->getSetData(['mini_services_template_id'],$this->uniacid);
        $value = array(
            "keyword1"=>["value"=>$data['body'], "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$data['status'], "color"=>"#9b9b9b"],
            "keyword3"=>["value"=>date("Y-m-d H:i:s",time()), "color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($form_id['openid'],$template_id['mini_services_template_id'],$page,$form_id['formid'],$value);
        $result = $this->https_curl_json($url,$dd,'json');
        self::$common->updateFormId($form_id);
        return $result;
    }

    /** 组合发送模板消息的信息 */
    public function returnParam($touser,$template_id,$page,$formId,$value){
        $dd =[];
        $dd['touser']=$touser;
        $dd['template_id']=$template_id;
        $dd['page']=$page;
        $dd['form_id']=$formId;
        $dd['data']=$value;
        $dd['color']='';
        $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
        return $dd;
    }

    /**
     * 获取微信公众号模板消息Access_token
     * @param $appid
     * @param $secret
     * @param $uniacid
     * @return array|bool|Memcache|mixed|Redis|string
     */
    public function get_Wx_accessToken($appid,$secret,$uniacid){
        if(cache_load('kundian_farm_access_token_wx_time'.$uniacid)>time()){
            return cache_load('kundian_farm_access_token_wx'.$uniacid);
        }else{
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
            $result = $this->http_request($url);
            $res = json_decode($result,true);
            if($res){
                cache_write('kundian_farm_access_token_wx_time'.$uniacid,time()+7000);
                cache_write('kundian_farm_access_token_wx'.$uniacid,$res['access_token']);
                return $res['access_token'];
            }else{
                return 'api return error';
            }
        }
    }

    public function https_curl_json($url,$data,$type){

        if($type=='json'){
            $headers = ["Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache"];
            $data=json_encode($data);
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)){

            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data);

        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
        $output = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }

        curl_close($curl);
        return $output;
    }

    public function http_request($url,$data=array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // POST数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function sendLandMessage($phone,$smstype,$sms_param){
        $condition=[
            'ikey'=>['sms_service_provider','sms_appkey','sms_secret','sms_sign','sms_template_one','sms_template_two','sms_template_three','sms_access_key','sms_access_key_secret'],
            'uniacid'=>$this->uniacid,
        ];
        $list1=pdo_getall('cqkundian_farm_manager_set',$condition);
        $messageSet=[];
        foreach ($list1 as $key => $value) {
            $messageSet[$value['ikey']]=$value['value'];
        }
        if($smstype==1){
            $sms_template=$messageSet['sms_template_one'];
        }
        if($smstype==2){
            $sms_template=$messageSet['sms_template_two'];
        }
        if($smstype==3){
            $sms_template=$messageSet['sms_template_three'];
        }

        $params =[];
        $accessKeyId = $messageSet['sms_access_key'];
        $accessKeySecret = $messageSet['sms_access_key_secret'];
        $params["PhoneNumbers"] = $phone;
        $params["SignName"] = $messageSet['sms_sign'];
        $params["TemplateCode"] =$sms_template;
        $params['TemplateParam'] = $sms_param;
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        include ROOT_PATH.'vendor/aliyun/SignatureHelper.php';
        $helper = new \Aliyun\DySDKLite\SignatureHelper();
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, [
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                ]
            )
        );
        if($content->Message=="OK"){
            return ['err_code'=>0];
        }
        return ['err_code'=>1,'msg'=>$content->Message];
    }

    public function sendMessageToUser($phone,$sms_param){

        $condition=[
            'ikey'=>['sms_service_provider','sms_appkey','sms_secret','sms_sign','sms_template_one','sms_template_two','sms_template_three','sms_access_key','sms_access_key_secret','sms_template_code'],
            'uniacid'=>$this->uniacid,
        ];
        $list1=pdo_getall('cqkundian_farm_manager_set',$condition);
        $messageSet=[];
        foreach ($list1 as $key => $value) {
            $messageSet[$value['ikey']]=$value['value'];
        }
        $params =[];
        $accessKeyId = $messageSet['sms_access_key'];
        $accessKeySecret = $messageSet['sms_access_key_secret'];
        $params["PhoneNumbers"] = $phone;
        $params["SignName"] = $messageSet['sms_sign'];
        $params["TemplateCode"] =$messageSet['sms_template_code'];
        $params['TemplateParam'] = $sms_param;
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        include ROOT_PATH.'vendor/aliyun/SignatureHelper.php';
        $helper = new \Aliyun\DySDKLite\SignatureHelper();
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, [
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                ]
            )
        );
        if($content->Message=="OK"){
            return ['err_code'=>0];
        }
        return ['err_code'=>1,'msg'=>$content->Message];
    }

    /** 拼团模板消息发送  start */
    public function sendPtSuccessMsg($orderData,$uid,$page=''){
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $user=pdo_get('cqkundian_farm_user',['uid'=>$uid]);
        $form_id=self::$common->getFormId($uid,$this->uniacid);
        $template_id=self::$common->getSetData(['pt_success_template_id'],$this->uniacid);
        $value = array(
            "keyword1"=>["value"=>$orderData['goods_name'], "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$orderData['price'], "color"=>"#9b9b9b"],
            "keyword3"=>["value"=>$orderData['ptnumber'], "color"=>"#9b9b9b"],
            "keyword4"=>["value"=>$user['nickname'], "color"=>"#9b9b9b"],
            "keyword5"=>["value"=>date('Y-m-d H:i:s',$orderData['end_time']), "color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($form_id['openid'],$template_id['pt_success_template_id'],$page,$form_id['formid'],$value);
        $result = $this->https_curl_json($url,$dd,'json');
        self::$common->updateFormId($form_id);
        return $result;
    }

    /** 商品发货通知 */
    public function deliveryGoodsMsg($orderData,$uid,$page){
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $form_id=self::$common->getFormId($uid,$this->uniacid);
        $template_id=self::$common->getSetData(['delivery_template_id'],$this->uniacid);
        $value = array(
            "keyword1"=>["value"=>$orderData['body'], "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$orderData['order_number'], "color"=>"#4a4a4a"],
            "keyword3"=>["value"=>$orderData['express'], "color"=>"#9b9b9b"],
            "keyword4"=>["value"=>$orderData['express_no'], "color"=>"#9b9b9b"],
            "keyword5"=>["value"=>date('Y-m-d H:i:s',$orderData['send_time']), "color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($form_id['openid'],$template_id['delivery_template_id'],$page,$form_id['formid'],$value);
        $result = $this->https_curl_json($url,$dd,'json');
        self::$common->updateFormId($form_id);
        return $result;
    }

    /** 订单取消通知*/
    public function cancelOrderMsg($orderData,$uid,$page){
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $form_id=self::$common->getFormId($uid,$this->uniacid);
        $template_id=self::$common->getSetData(['cancel_template_id'],$this->uniacid);
        $value = array(
            "keyword1"=>["value"=>$orderData['order_number'], "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$orderData['body'], "color"=>"#4a4a4a"],
            "keyword3"=>["value"=>$orderData['total_price'], "color"=>"#9b9b9b"],
            "keyword4"=>["value"=>$orderData['reason'], "color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($form_id['openid'],$template_id['cancel_template_id'],$page,$form_id['formid'],$value);
        $result = $this->https_curl_json($url,$dd,'json');
        self::$common->updateFormId($form_id);
        return $result;
    }

    /** 提现成功通知 */
    public function withdrawSuccessMsg($data,$uid,$page){
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $form_id=self::$common->getFormId($uid,$this->uniacid);
        $template_id=self::$common->getSetData(['withdraw_success_template_id'],$this->uniacid);
        $value = array(
            "keyword1"=>["value"=>$data['price'].'元', "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$data['method']==1?'微信钱包' :'支付宝', "color"=>"#4a4a4a"],
            "keyword3"=>["value"=>date("Y-m-d",time()), "color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($form_id['openid'],$template_id['withdraw_success_template_id'],$page,$form_id['formid'],$value);
        $result = $this->https_curl_json($url,$dd,'json');
        self::$common->updateFormId($form_id);
        return $result;
    }

    /** 提现失败通知 */
    public function withdrawFailMsg($data,$uid,$page){
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $form_id=self::$common->getFormId($uid,$this->uniacid);
        $template_id=self::$common->getSetData(['withdraw_fail_template_id'],$this->uniacid);
        $value = array(
            "keyword1"=>["value"=>$data['price'].'元', "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$data['method']==1?'微信钱包' :'支付宝', "color"=>"#4a4a4a"],
            "keyword3"=>["value"=>$data['remark'], "color"=>"#9b9b9b"],
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($form_id['openid'],$template_id['withdraw_fail_template_id'],$page,$form_id['formid'],$value);
        $result = $this->https_curl_json($url,$dd,'json');
        self::$common->updateFormId($form_id);
        return $result;
    }

    /** 活动审核通知 */
    public function activeCheckMsg($data,$uid,$page){
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $form_id=self::$common->getFormId($uid,$this->uniacid);
        $template_id=pdo_get('cqkundian_farm_plugin_active_set',['uniacid'=>$this->uniacid,'ikey'=>'active_template_id']);
        $value = [
            "keyword1"=>["value"=>$data['title'], "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>$data['status'], "color"=>"#4a4a4a"],
            "keyword3"=>["value"=>$data['count'].'人', "color"=>"#9b9b9b"],
            "keyword4"=>["value"=>$data['address'], "color"=>"#9b9b9b"],
            "keyword5"=>["value"=>$data['time'], "color"=>"#9b9b9b"],
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($form_id['openid'],$template_id['value'],$page,$form_id['formid'],$value);
        $result = $this->https_curl_json($url,$dd,'json');
        self::$common->updateFormId($form_id);
        return $result;
    }

    // 商户入驻状态更新通知
    public function storeStatusMsg($data,$uid,$page){
        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $form_id=self::$common->getFormId($uid,$this->uniacid);
        $template_id=self::$common->getSetData(['store_status_template_id'],$this->uniacid);
        if($data['status']==1){
            $status='商家入驻申请已通过';
        }
        if($data['status']==-1){
            $status='商家入驻申请已驳回';
            $remark=$data['check_fail_reason'];
        }
        $value = [
            "keyword1"=>["value"=>$data['name'], "color"=>"#4a4a4a"],
            "keyword2"=>["value"=>date("Y-m-d H:i:s",$data['create_time']), "color"=>"#4a4a4a"],
            "keyword3"=>["value"=>date("Y-m-d H:i:s",time()), "color"=>"#9b9b9b"],
            "keyword4"=>["value"=>$status, "color"=>"#9b9b9b"],
            "keyword5"=>["value"=>$remark, "color"=>"#9b9b9b"],
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $dd=$this->returnParam($form_id['openid'],$template_id['store_status_template_id'],$page,$form_id['formid'],$value);
        $result = $this->https_curl_json($url,$dd,'json');
        $res=json_decode($result);
        if($res->errcode==0){
            self::$common->updateFormId($form_id);
        }

        return $result;
    }
}