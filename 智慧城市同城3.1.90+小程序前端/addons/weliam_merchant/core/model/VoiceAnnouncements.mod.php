<?php
/**
 * Comment: 语音播报收款内容
 * Author: ZZW
 * Date: 2018/12/29
 * Time: 15:21
 */
defined('IN_IA') or exit('Access Denied');

class VoiceAnnouncements{
    static protected $hornID, //云喇叭的id
        $signature,//网关验证信息
        $uid,//用户uid
        $https = 'https://api.gateway.letoiot.com/',//请求的服务器地址
        $price,//播报的接收金额
        $vol,//音量设置
        $manfactorDeviceType,//硬件厂商设备类型
        $pt,//支付类型 0=通用(不播报前缀);1=支付宝;2=微信支付;3=云支付;4=余额支付;5=微信储值;6=微信买单;7=银联刷卡;25=哆啦宝
        $pwd;//用户密码
    /**
     * Comment: 向云喇叭服务器推送要播报的语音信息
     * Author: zzw
     * @param $price    播报的接收金额
     * @param $sid      店铺id
     * @return array
     */
    public static function PushVoiceMessage($price,$sid,$paytype){
        #1、判断当前商户是否开启云喇叭功能
        $info = unserialize(pdo_getcolumn(PDO_NAME."merchantdata",array('id'=>$sid),'cloudspeaker'));
        $paymentType = self::getPayType($paytype);
        if($info['state'] != 1 || empty($info['id']) || empty($info['account']) || empty($info['password']) || $paymentType == 0){
            return false;
        }
        #2、获取基本要使用的信息
        self::$hornID = $info['id'];//喇叭id
        self::$uid    = $info['account'];//喇叭账号id:API_CMKJ0057
        self::$pwd    = $info['password'];//喇叭密码pwd:API_LTCMKJ0057
        self::$vol    = $info['volume'];//音量
        self::$pt     = $paymentType;
        self::$manfactorDeviceType = '03ea00020030';//$info['equipment_type'];
        self::$price  = $price*100;
        self::$signature = self::getSignature();
        #3、判断当前用户的云喇叭是否在线   云喇叭技术说不需要判断喇叭是否在线 所以注释了
        /*$isOnline = self::isOnline();
        if($isOnline['erron'] == 0){
            return $isOnline;//
        }*/
        #4、云喇叭在线  推送收款信息
        $result = self::sendOutInfo();
        return $result;
    }

    /**
     * Comment: 绑定商户与云喇叭
     * Author: zzw
     */
    protected static function shopBind(){
        #1、绑定商户与云喇叭
        $descs = urlencode('商户绑定');//这里请求中不能带有中文 否则报错
        $info = '?id='.self::$hornID.'&m=1&uid='.self::$uid.'&manfactorDeviceType='.self::$manfactorDeviceType.'&descs='.$descs.'&seq='.self::$hornID;
        $url  = self::$https.'speaker/bind.php'.$info;
        $header = array(
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
            'Authorization: '.self::$signature,
        );
        $info = self::curlRequest($url,'',$header);
        if($info['errcode'] == 4){
            return array('erron'=>2,'message'=>'该商户与该云喇叭已绑定');
        }else  if($info['errcode'] == 0){
            return array('erron'=>1,'message'=>'绑定成功');
        }else{
            return array('erron'=>0,'message'=>$info['errmsg']);
        }
    }
    /**
     * Comment: 获取网关签名
     * Author: zzw
     */
    protected static function getSignature(){
        //$signature = Util::getCookie("voiceSignature")[0];
        //if(empty($signature) || !$signature){
            $postData = json_encode(array('app_cust_id'=>self::$uid,'app_cust_pwd'=>self::$pwd));
            $url = self::$https."gateway/api/v2/getSignature";
            $header = array('application/json;charset=utf-8');
            $info = self::curlRequest($url,$postData,$header);
            $signature = $info['data']['signature'];//获取的签名详细内容
            //$time = $info['data']['remainTime'];//剩余的时间 (分钟)
            //Util::setCookie('voiceSignature',array($signature),$time*59);
        //}
        return $signature;
    }
    /**
     * Comment: 判断当前云喇叭是否在线
     * Author: zzw
     */
    protected static function isOnline(){
        $url = self::$https.'speaker/speaker/search-device-online-state';
        $postData = json_encode(array('devNo'=>self::$hornID));
        $header = array(
            'Content-Type: application/json;charset=utf-8',
            'Authorization: '.self::$signature,
        );
        $info = self::curlRequest($url,$postData,$header);
        if($info['code'] == 0){
            if($info['data']['state']){
                //云喇叭在线
                return array('erron'=>1,'message'=>'在线');
            }else{
                //云喇叭未连接服务器
                $bindRes = self::shopBind();
                if($bindRes['erron'] == 1){
                    //绑定成功 再次调用支付
                    $result = self::sendOutInfo();
                    return $result;
                }else if($bindRes['erron'] == 2){
                    return array('erron'=>0,'message'=>'云喇叭出现异常,请联系厂商进行修复');
                }else{
                    return array('erron'=>0,'message'=>'云喇叭未连接服务器');
                }
            }
        }else{
            return array('erron'=>0,'message'=>$info['message']);
        }
    }
    /**
     * Comment: 发送支付推送消息
     * Author: zzw
     * @return array
     */
    protected static function sendOutInfo(){
        $descs = urlencode('支付消息');//这里请求中不能带有中文 否则报错
        $codeInfo = '?id='.self::$hornID. '&uid='.self::$uid.
            '&vol='.self::$vol.'&price='.self::$price.'&pt='.self::$pt.'&seq=666&descs='.$descs;
        $url = self::$https."speaker/add.php".$codeInfo;
        $header = array(
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
            'Authorization: '.self::$signature,
        );
        $info = self::curlRequest($url,'',$header);
        if($info['errcode'] == 0){
            return array('erron'=>1,'message'=>'收款消息推送成功');
        }else{
            return array('erron'=>0,'message'=>$info['errmsg']);
        }
    }
    /**
     * Comment: 通过本网站的付款方式获取云喇叭的付款方式的值
     * Author: zzw
     * @param $paytype  代表本网站的付款方式的值
     * @return int      获取到的云喇叭服务端所代表的付款方式
     */
    protected static function getPayType($paytype){
        //0=通用(不播报前缀);1=支付宝;2=微信支付;3=云支付;4=余额支付;5=微信储值;6=微信买单;7=银联刷卡;25=哆啦宝
        $val = 0;//默认 通用(不播报前缀)  为0暂不进行播报
        switch ($paytype){
            case 3:$val=1;break;//支付宝
            case 2:$val=2;break;//微信支付
            case 5:$val=2;break;//微信支付
            //case 1:$val=3;break;//云支付(暂无当前支付方式)
            case 1:$val=4;break;//余额支付
            //case 1:$val=5;break;//微信储值(暂无当前支付方式)
            //case 1:$val=6;break;//微信买单(暂无当前支付方式)
            //case 1:$val=7;break;//银联刷卡(暂无当前支付方式)
            //case 1:$val=25;break;//哆啦宝(暂无当前支付方式)
        }
        return $val;
    }
    /**
     * Comment: 通过curl进行网络信息抓取
     * Author: zzw
     * @param $url          抓取的url地址
     * @param $postData     请求时带的参数信息
     * @param array $header  请求时对Content-Type的设置(数组格式)
     * @return mixed
     */
    protected static function curlRequest($url,$postData,$header){
        $curl = curl_init();//初始化
        curl_setopt($curl, CURLOPT_URL, $url);//设置抓取的url
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);//设置header信息
        curl_setopt($curl, CURLOPT_HEADER, 1);//设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_POST, 1);//设置post方式提交
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        $data = curl_exec($curl); //执行命令
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);// 获得响应结果里的：header头大小
        $info = substr($data, $headerSize);//通过截取 获取body信息
        curl_close($curl);//关闭URL请求


        return json_decode($info,true);//返回获取的信息数据
    }
}












