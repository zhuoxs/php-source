<?php
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");

require_once(__DIR__ . "/../../plugin/unipush/" . 'IGt.Push.php');
require_once(__DIR__ . "/../../plugin/unipush/" . 'igetui/IGt.AppMessage.php');
require_once(__DIR__ . "/../../plugin/unipush/" . 'igetui/IGt.TagMessage.php');
require_once(__DIR__ . "/../../plugin/unipush/" . 'igetui/IGt.APNPayload.php');
require_once(__DIR__ . "/../../plugin/unipush/" . 'igetui/template/IGt.BaseTemplate.php');
require_once(__DIR__ . "/../../plugin/unipush/" . 'IGt.Batch.php');
require_once(__DIR__ . "/../../plugin/unipush/" . 'igetui/utils/AppConditions.php');
require_once(__DIR__ . "/../../plugin/unipush/" . 'igetui/template/notify/IGt.Notify.php');
require_once(__DIR__ . "/../../plugin/unipush/" . 'igetui/IGt.MultiMedia.php');
require_once(__DIR__ . "/../../plugin/unipush/" . 'payload/VOIPPayload.php');

define('APPKEY','n5o2iw1STz8Vkv6w6kHoS1');
define('APPID','eynG9GLnxJ9h1c5QWYmMhA');
define('MASTERSECRET','F1Kk3NavtH8DlrRChUk8G5');
define('HOST','http://sdk.open.api.igexin.com/apiex.htm');
define('CID','');
define('DT','');
define('CID1','');
define('DT1','');
define('groupName','');

define('PN','');
define('Badge','+1');
define("TASKID","OSA-0731_RGyUZj0gYEAC51o1EgbTz8");
define("ALIAS","ALIAS");


class Unipush {

    public static  $instance;
    public   $appid = "";
    public   $appkey = "";
    public   $mastersecret = "";
    public   $appsecret = "";
    public   $host = "http://sdk.open.api.igexin.com/apiex.htm";
    public static  function Instance(){
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct()
    {
        global  $_W;
        $detail = pdo_get('ox_master_unipush',[  'uniacid'=>$_W['uniacid']]);
        if($detail){
            $this->appid = $detail['appid'];//'1400195467';
            $this->appkey = $detail['appkey'];//'d876d7b38a1cce94f23bf0206133e9c3';
            $this->mastersecret = $detail['mastersecret'];//'d876d7b38a1cce94f23bf0206133e9c3';
            $this->appsecret = $detail['appsecret'];//'d876d7b38a1cce94f23bf0206133e9c3';
        }else{
            return $this->result(1, '推送还未配置','');
        }

    }

    function bindAlias($params) {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret =$igt->bindAlias(APPID,$params['name'],$params['cid']);
        return $ret;
    }
    function queryCidByAlias($alias) {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret =$igt->queryClientId($this->appid,$alias);
        return $ret;
    }

    function queryAliasByCID($cid) {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret =$igt->queryAlias($this->appid,$cid);
        return $ret;
    }
    function unbindAlias($alias,$cid) {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret =$igt->unBindAlias($this->appid,$alias,$cid);
        return $ret;
    }
    function unbindAliasAll($alias) {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret =$igt->unBindAliasAll($this->appid,$alias);
        return $ret;
    }

    function getPersonaTagsDemo() {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret = $igt->getPersonaTags($this->appid);
        return $ret;
    }
    function getUserCountByTagsDemo($tagList) {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        //$tagList = array("English","龙卷风");
        $ret = $igt->getUserCountByTags($this->appid, $tagList);
        return $ret;
    }

    function getScheduleTaskDemo($taskid){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret = $igt->getScheduleTask($taskid,$this->appid);
        return $ret;
    }
    function delScheduleTaskDemo($taskid){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret = $igt->delScheduleTask($taskid,$this->appid);
        return $ret;
    }
    function getPushResultByGroupNameDemo($groupNmae){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret = $igt->getPushResultByGroupName($this->appid,$groupNmae);
        return $ret;
    }
    function getLast24HoursOnlineUserStatisticsDemo(){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret = $igt->getLast24HoursOnlineUserStatistics($this->appid);
        return $ret;
    }
    function restoreCidListFromBlkDemo($cidList){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
       // $cidList=array(CID,"");
        $ret = $igt->restoreCidListFromBlk($this->appid,$cidList);
        return $ret;
    }
    function addCidListToBlkDemo($cidList){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        //$cidList=array(CID,"");
        $ret = $igt->addCidListToBlk($this->appid,$cidList);
        return $ret;
    }
    function setBadgeForCIDDemo($cidList){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        //$cidList=array(CID,CID1);
        $ret = $igt->setBadgeForCID(Badge,$this->appid,$cidList);
        return $ret;
    }
    function setBadgeForDeviceTokenDemo($cidList){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        //$cidList=array(DT,DT1);
        $ret = $igt->setBadgeForDeviceToken(Badge,$this->appid,$cidList);
        return $ret;
    }

//bindCidPnDemo();
    function bindCidPnDemo(){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $params = array();
        $params[CID] = md5(PN);
        $ret = $igt->bindCidPn($this->appid,$params);
        return $ret;
    }
//unbindCidPnDemo();
    function unbindCidPnDemo($cids){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        //$cids=array(CID,"");
        $ret = $igt->unbindCidPn($this->appid,$cids);
        return $ret;
    }
    function queryCidPnDemo($cidList){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        //$cidList=array(CID);
        $ret = $igt->queryCidPn($this->appid,$cidList);
        return $ret;
    }
    function stopSendSmsDemo($taskid){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $ret = $igt->stopSendSms($this->appid,$taskid);
        return $ret;
    }


    function getPushMessageResultDemo(){

//    putenv("gexin_default_domainurl=http://183.129.161.174:8006/apiex.htm");

        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);

//    $ret = $igt->getPushResult("OSA-0522_QZ7nHpBlxF6vrxGaLb1FA3");
//    var_dump($ret);

//    $ret = $igt->queryAppUserDataByDate(APPID,"20140807");
//    var_dump($ret);

        $ret = $igt->queryAppPushDataByDate($this->appid,"20180724");
        return $ret;
    }

//用户状态查询
    function getUserStatus($cid) {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $rep = $igt->getClientIdStatus($this->appid,$cid);
        return $rep;
    }

//推送任务停止
    function stoptask(){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $rep = $igt->stop("OSA-0801_F3TKsUx10wAzfyPsq8zKY2");
        return $rep;
    }

//通过服务端设置ClientId的标签
    function setTag(){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $tagList = array('','中文','English');
        $rep = $igt->setClientTag($this->appid,CID,$tagList);
        return $rep;
    }

    function getUserTags($cid) {
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $rep = $igt->getUserTags($this->appid,$cid);
        return $rep;
    }

//服务端推送接口，支持三个接口推送
//1.PushMessageToSingle接口：支持对单个用户进行推送
//2.PushMessageToList接口：支持对多个用户进行推送，建议为50个用户
//3.pushMessageToApp接口：对单个应用下的所有用户进行推送，可根据省份，标签，机型过滤推送
//
//单推接口案例
    function pushMessageToSingle(){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        //var_dump($igt);die;

        //消息模版：
        // 1.TransmissionTemplate:透传功能模板
        // 2.LinkTemplate:通知打开链接功能模板
        // 3.NotificationTemplate：通知透传功能模板
        // 4.NotyPopLoadTemplate：通知弹框下载功能模板

//    	$template = IGtNotyPopLoadTemplateDemo();
//    	$template = IGtLinkTemplateDemo();
//    	$template = IGtNotificationTemplateDemo();
       // $template = $this->IGtTransmissionTemplateDemo();
        $template = $this->IGtNotificationTemplateDemo();
        //$template = $this->SmsDemo();
        //var_dump($template);die;
        //个推信息体
        $message = new IGtSingleMessage();

        $message->set_isOffline(true);//是否离线
        $message->set_offlineExpireTime(3600*12*1000);//离线时间
        $message->set_data($template);//设置推送消息类型
//	$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
        //接收方
        $target = new IGtTarget();
        $target->set_appId($this->appid);
        $target->set_clientId('230ffaebe5a4bc912d6ccc61c7646076');
//    $target->set_alias(ALIAS);


        try {
            $rep = $igt->pushMessageToSingle($message, $target);
            var_dump($rep);
            echo ("<br><br>");

        }catch(RequestException $e){
            $requstId =$e->getRequestId();
            $rep = $igt->pushMessageToSingle($message, $target,$requstId);
            var_dump($rep);
            echo ("<br><br>");
        }

    }

    function SmsDemo(){
        $template =  new IGtTransmissionTemplate();
        $template->set_appId($this->appid);//应用appid
        $template->set_appkey($this->appkey);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent("测试离线ddd");//透传内容
        //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息

        $smsMessage = new SmsMessage();
        $smsContent = array();
        $smsContent["code1"] = "1234";
        $smsContent["time"] = "5";
        $smsMessage->setSmsContent($smsContent);
        $smsMessage->setSmsTemplateId("1a0ad952756f4c679ca67f008bf37b5e");
        $smsMessage->setOfflineSendtime(1000);
        $template->setSmsInfo($smsMessage);


        return $template;
    }
    function pushMessageToSingleBatch()
    {
        putenv("gexin_pushSingleBatch_needAsync=false");

        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $batch = new IGtBatch($this->appkey, $igt);
        $batch->setApiUrl($this->host);
        //$igt->connect();
        //消息模版：
        // 1.TransmissionTemplate:透传功能模板
        // 2.LinkTemplate:通知打开链接功能模板
        // 3.NotificationTemplate：通知透传功能模板
        // 4.NotyPopLoadTemplate：通知弹框下载功能模板

        //$template = IGtNotyPopLoadTemplateDemo();
        $templateLink = IGtLinkTemplateDemo();
        $templateNoti = IGtNotificationTemplateDemo();
        //$template = IGtTransmissionTemplateDemo();

        //个推信息体
        $messageLink = new IGtSingleMessage();
        $messageLink->set_isOffline(true);//是否离线
        $messageLink->set_offlineExpireTime(12 * 1000 * 3600);//离线时间
        $messageLink->set_data($templateLink);//设置推送消息类型
        //$messageLink->set_PushNetWorkType(1);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送

        $targetLink = new IGtTarget();
        $targetLink->set_appId($this->appid);
        $targetLink->set_clientId(CID);
        $batch->add($messageLink, $targetLink);

        //个推信息体
        $messageNoti = new IGtSingleMessage();
        $messageNoti->set_isOffline(true);//是否离线
        $messageNoti->set_offlineExpireTime(12 * 1000 * 3600);//离线时间
        $messageNoti->set_data($templateNoti);//设置推送消息类型
        //$messageNoti->set_PushNetWorkType(1);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送

        $targetNoti = new IGtTarget();
        $targetNoti->set_appId($this->appid);
        $targetNoti->set_clientId(CID2);
        $batch->add($messageNoti, $targetNoti);
        try {

            $rep = $batch->submit();
            var_dump($rep);
            echo("<br><br>");
        }catch(Exception $e){
            $rep=$batch->retry();
            var_dump($rep);
            echo ("<br><br>");
        }
    }

//多推接口案例
    function pushMessageToList($cids = ['230ffaebe5a4bc912d6ccc61c7646076'])
    {
        putenv("gexin_pushList_needDetails=true");
        putenv("gexin_pushList_needAsync=true");

        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        //消息模版：
        // 1.TransmissionTemplate:透传功能模板
        // 2.LinkTemplate:通知打开链接功能模板
        // 3.NotificationTemplate：通知透传功能模板
        // 4.NotyPopLoadTemplate：通知弹框下载功能模板


        //$template = IGtNotyPopLoadTemplateDemo();
        //$template = IGtLinkTemplateDemo();
        //$template = IGtNotificationTemplateDemo();
        $template = $this->IGtNotificationTemplateDemo();
        //var_dump($template);die;
        //个推信息体
        $message = new IGtListMessage();
        $message->set_isOffline(true);//是否离线
        $message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间
        $message->set_data($template);//设置推送消息类型
//    $message->set_PushNetWorkType(1);	//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
//    $contentId = $igt->getContentId($message);
        $contentId = $igt->getContentId($message,"toList任务别名功能");	//根据TaskId设置组名，支持下划线，中文，英文，数字

        //接收方1
        $targetList = [];
        foreach ($cids as $v) {
            $target1 = new IGtTarget();
            $target1->set_appId($this->appid);
            $target1->set_clientId($v);
            $targetList[] = $target1;
        }
       // var_dump($targetList);die;
        $rep = $igt->pushMessageToList($contentId, $targetList);
       // var_dump($rep);die;
        return $rep;

    }

//群推接口案例
    function pushMessageToApp(){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        // $template = $this->IGtLinkTemplateDemo();
        $template = $this->IGtNotificationTemplateDemo();
        //个推信息体
        //基于应用消息体
        $message = new IGtAppMessage();
        $message->set_isOffline(true);
        $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
        $message->set_data($template);
//    $message->setPushTime("201808011537");
        $appIdList=array($this->appid);
     //   $phoneTypeList=array('ANDROID');
       // $provinceList=array('浙江');
     //   $tagList=array('中文');
        $age = array("0000", "0010");


        $cdt = new AppConditions();
       // $cdt->addCondition(AppConditions::PHONE_TYPE, $phoneTypeList);
       // $cdt->addCondition(AppConditions::REGION, $provinceList);
        //$cdt->addCondition(AppConditions::TAG, $tagList);
//    $cdt->addCondition("age", $age);

        $message->set_appIdList($appIdList);
        $message->set_conditions($cdt);

        $rep = $igt->pushMessageToApp($message);

        var_dump($rep);
        echo ("<br><br>");
    }

//所有推送接口均支持四个消息模板，依次为通知弹框下载模板，通知链接模板，通知透传模板，透传模板
//注：IOS离线推送需通过APN进行转发，需填写pushInfo字段，目前仅不支持通知弹框下载功能

    function IGtNotyPopLoadTemplateDemo(){
        $template =  new IGtNotyPopLoadTemplate();

        $template ->set_appId($this->appid);//应用appid
        $template ->set_appkey($this->appkey);//应用appkey
        //通知栏
        $template ->set_notyTitle("个推");//通知栏标题
        $template ->set_notyContent("个推最新版点击下载");//通知栏内容
        $template ->set_notyIcon("");//通知栏logo
        $template ->set_isBelled(true);//是否响铃
        $template ->set_isVibrationed(true);//是否震动
        $template ->set_isCleared(true);//通知栏是否可清除
        //弹框
        $template ->set_popTitle("弹框标题");//弹框标题
        $template ->set_popContent("弹框内容");//弹框内容
        $template ->set_popImage("");//弹框图片
        $template ->set_popButton1("下载");//左键
        $template ->set_popButton2("取消");//右键
        //下载
        $template ->set_loadIcon("");//弹框图片
        $template ->set_loadTitle("地震速报下载");
        $template ->set_loadUrl("http://dizhensubao.igexin.com/dl/com.ceic.apk");
        $template ->set_isAutoInstall(false);
        $template ->set_isActived(true);
        //$template->set_notifyStyle(0);
        //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息

        return $template;
    }

    function IGtLinkTemplateDemo(){
        $template =  new IGtLinkTemplate();
        $template ->set_appId($this->appid);//应用appid
        $template ->set_appkey($this->appkey);//应用appkey
        $template ->set_title("请输入通知标题1");//通知栏标题
        $template ->set_text("请输入通知内容");//通知栏内容
        $template ->set_logo("");//通知栏logo
        $template ->set_isRing(true);//是否响铃
        $template ->set_isVibrate(true);//是否震动
        $template ->set_isClearable(true);//通知栏是否可清除
        $template ->set_url("http://www.igetui.com/");//打开连接地址
        //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
        return $template;
    }

    /**
     * 测试成功
     * @return IGtNotificationTemplate
     */
    function IGtNotificationTemplateDemo(){
        $template =  new IGtNotificationTemplate();
        $template->set_appId($this->appid);//应用appid
        $template->set_appkey($this->appkey);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent("测试离线");//透传内容
        $template->set_title("为ertetrret为");//通知栏标题
        $template->set_text("有师傅最新版点击下载");//通知栏内容
        $template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo
        $template->set_isRing(true);//是否响铃
        $template->set_isVibrate(true);//是否震动
        $template->set_isClearable(true);//通知栏是否可清除
        //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
        return $template;
    }

    function IGtTransmissionTemplateDemo(){
        $template =  new IGtTransmissionTemplate();
        $template->set_appId($this->appid);//应用appid
        $template->set_appkey($this->appkey);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent("测试离线ddd");//透传内容
        //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
        //APN简单推送
        $apn = new IGtAPNPayload();
        $alertmsg=new SimpleAlertMsg();
        $alertmsg->alertMsg="abcdefg3";
        $apn->alertMsg=$alertmsg;
        $apn->badge=2;
        $apn->sound="";
        $apn->add_customMsg("payload","payload");
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);

        //VOIP推送
//    $voip = new VOIPPayload();
//    $voip->setVoIPPayload("新浪");
//    $template->set_apnInfo($voip);


        //第三方厂商推送透传消息带通知处理
//    $notify = new IGtNotify();
////    $notify -> set_payload("透传测试内容");
//    $notify -> set_title("透传通知标题");
//    $notify -> set_content("透传通知内容");
//    $notify->set_url("https://www.baidu.com");
//    $notify->set_type(NotifyInfo_Type::_url);
//    $template -> set3rdNotifyInfo($notify);

        //APN高级推送
        $apn = new IGtAPNPayload();
        $alertmsg=new DictionaryAlertMsg();
        $alertmsg->body="body";
        $alertmsg->actionLocKey="ActionLockey";
        $alertmsg->locKey="LocKey";
        $alertmsg->locArgs=array("locargs");
        $alertmsg->launchImage="launchimage";
//        IOS8.2 支持
        $alertmsg->title="Title";
        $alertmsg->titleLocKey="TitleLocKey";
        $alertmsg->titleLocArgs=array("TitleLocArg");

        $apn->alertMsg=$alertmsg;
        $apn->badge=7;
        $apn->sound="";
        $apn->add_customMsg("payload","payload");
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
//
////    IOS多媒体消息处理
        $media = new IGtMultiMedia();
        $media -> set_url("http://docs.getui.com/start/img/pushapp_android.png");
        $media -> set_onlywifi(false);
        $media -> set_type(MediaType::pic);
        $medias = array();
        $medias[] = $media;
        $apn->set_multiMedias($medias);
        $template->set_apnInfo($apn);
        return $template;
    }

//多标签推送接口案例
    function pushMessageByTag(){
        $igt = new IGeTui($this->host, $this->appkey, $this->mastersecret);
        $template = IGtLinkTemplateDemo();
        //个推信息体
        //基于应用消息体
        $message = new IGtTagMessage();
        $message->set_isOffline(true);
        $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
        $message->set_data($template);

        $appIdList=array($this->appid);

        $message->set_tag("中文");
        $message->set_appIdList($appIdList);

        $rep = $igt->pushTagMessage($message);

        var_dump($rep);
        echo ("<br><br>");
    }

    function IGtTransmissionTemplateFunction(){
        $template =  new IGtTransmissionTemplate();
        $template->set_appId('qmLGUim5KR76RY5us9og16');//应用appid
        $template->set_appkey('3qxvCArI7iAGFf4ZEyzqu8');//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent('12345677');//透传内容

        return $template;
    }

}



