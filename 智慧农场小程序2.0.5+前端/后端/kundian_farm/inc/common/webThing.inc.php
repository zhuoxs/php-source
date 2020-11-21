<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 9:46
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/common.php';
function getDeiveInfo($web_did,$uniacid,$farmSet=[]){
    $deviceData=getDevice($web_did,$uniacid);
    $state1_set=$deviceData->attr->state1_set;    //温度
    $state3_set=$deviceData->attr->state3_set;    //水分
    $data['temp']=round(getTmpData($state1_set),1);
    $data['watering']=getWatering($state3_set);
    if(empty($farmSet)) {
        $farmSet = getCommonSet($uniacid, array('webthing_device_id'));
    }
    if($farmSet['webthing_device_id']){
        $mainDevice=getDevice($farmSet['webthing_device_id'],$uniacid);
        //光照
        $tmp1=$mainDevice->attr->timeon2;
        $tmp2=$mainDevice->attr->timeoff2;
        $data['illumination'] = ($tmp1 * 100 + $tmp2) * 0.045;

        //二氧化碳
        $state2_set=$mainDevice->attr->state2_set;
        $tmp = $state2_set * 3.3 / 1023;
        if ($tmp < 0.4) {
            $co2 = 0;
        }else {
            $co2 = ($tmp - 0.4) * 3125;
        }
        $data['co2']=round($co2);
    }else{
        //光照
        $tmp1=$deviceData->attr->timeon2;
        $tmp2=$deviceData->attr->timeoff2;
        $data['illumination'] = ($tmp1 * 100 + $tmp2) * 0.045;

        //二氧化碳
        $state2_set=$deviceData->attr->state2_set;
        $tmp = $state2_set * 3.3 / 1023;
        if ($tmp < 0.4) {
            $co2 = 0;
        }else {
            $co2 = ($tmp - 0.4) * 3125;
        }
        $data['co2']=round($co2);
    }
    return $data;
}

/**
 * 远程控制设备
 * @param $web_did      //设备号
 * @param $data         //要控制的操作
 * @param $uniacid      //小程序唯一标识
 * @return int
 */
function controlDevice($web_did,$data,$uniacid){
    $url="https://api.gizwits.com/app/control/".$web_did;
    //获取小程序的配置信息
    $filed=array('is_open_webthing','webthing_password','webthing_username','webthing_appid');
    $farmSet=getCommonSet($uniacid,$filed);
    //获取token
    if(cache_load('kundian_farm_jizhiyun_token_time'.$uniacid) > time()){
        $token=cache_load('kundian_farm_jizhiyun_token'.$uniacid);
    }else{
        $token=getYunToken($farmSet['webthing_username'],$farmSet['webthing_password'],$farmSet['webthing_appid'],$uniacid);
    }
    $headers=array("Content-Type: application/json","Accept: application/json","X-Gizwits-Application-Id:".$farmSet['webthing_appid'],"X-Gizwits-User-token:".$token);
    $jsonData=json_encode($data);
    $result=request_post($url,$jsonData,$headers);
    $res=count(get_class_methods(json_decode($result)));
    return $res;
}

/**
 * 获取机智云token
 * @param $username     //用户名
 * @param $password     //密码
 * @param $appid        //appid
 * @param $uniacid      //小程序低
 * @return mixed
 */
function getYunToken($username,$password,$appid,$uniacid){
    $url="https://api.gizwits.com/app/login";
    $data=array(
        'username'=>$username,
        'password'=>$password,
        "lang"=>"en",
    );
    $result = json_encode($data);    //将数据转化为json格式
    $headers=array("Content-Type: application/json","Accept: application/json","X-Gizwits-Application-Id:$appid");
    $result1=request_post($url,$result,$headers);
    $result2=json_decode($result1);
    cache_write('kundian_farm_jizhiyun_token'.$uniacid,$result2->token);
    cache_write('kundian_farm_jizhiyun_token_time'.$uniacid,$result2->expire_at);
    cache_write('kundian_farm_jizhiyun_uid'.$uniacid,$result2->uid);
    return $result2->token;
}

/**
 * 获取设备信息
 * @param $web_did  //设备号
 * @param $uniacid  //小程序唯一标识
 * @return mixed
 */
function getDevice($web_did,$uniacid){
    $url='https://api.gizwits.com/app/devdata/'.$web_did.'/latest';
    //获取小程序的配置信息
    $common=new Common_KundianFarmModel();
    $filed=array('is_open_webthing','webthing_password','webthing_username','webthing_appid');
    $farmSet=$common->getSetData($filed,$uniacid);
    $headers=array("Content-Type: application/json","Accept: application/json","X-Gizwits-Application-Id:".$farmSet['webthing_appid']);
    $result=get_info($url,$headers);
    $result1=json_decode($result);
    return $result1;
}

/**
 * 获取温度信息
 * @param $temperature
 * @return int
 */
function getTmpData($temperature){
    $adc_u=$temperature * (3.3 / 1023);
    if($adc_u!=0){
        $adc_res=(10000 * (3.3 - $adc_u))/$adc_u;
        $wendu=array(336600, 315000, 295000, 276400, 259000, 242800, 227800, 213800, 200600, 188400, 177000, 166400, 156600, 147200, 138500, 130400, 122900, 115800, 109100, 102900, 97120, 91660, 86540, 81720, 77220, 72980, 69000, 65260, 61760, 58460, 55240, 52420, 49660, 47080, 44640, 42340, 40160, 38120, 36200, 34380, 32660, 31040, 29500, 28060, 26680, 25400, 24180, 23020, 21920, 20880, //0
            19900, 18970, 18290, 17260, 16460, 15710, 15000, 14320, 13680, 13070, //1
            12490, 11940, 11420, 10920, 10450, 10000, 9574, 9166, 8778, 8480, //2
            8058, 7724, 7404, 7098, 6808, 6532, 6268, 6015, 5776, 5546, //3
            5326, 5118, 4918, 4726, 4544, 4368, 4202, 4042, 3888, 3742, //4
            3602, 3468, 3340, 3216, 3098, 2986, 2878, 2774, 2674, 2580, //5
            2488, 2400, 2316, 2234, 2158, 2082, 2012, 1942, 1876, 1813, //6
            1751, 1693, 1637, 1582, 1530, 1480, 1432, 1385, 1341, 1298, //7
            1256, 1216, 1178, 1141, 1105, 1071, 1038, 1006, 975, 945, //8
            916, 888, 862, 836, 811, 787, 764, 741, 720, 699, //9
            679, 659, 640, 622, 605, 588, 571, 555, 540, 525, //10
            510, 496, 483, 470, 457, 445, 433, 421, 410, 399, //11
            389, 379, 369, 359, 350, 341, 332, 324, 316, 308, //12
            300, 293, 285, 278, 272, 265, 258, 252, 246, 240, //13
            234, 229, 223, 218, 213, 208, 203, 198, 194, 189, 185
        );
        $m=0;
        for ($i = 0; $i < 191; $i++){
            {
                if ($adc_res > $wendu[$i]) {
                    $m=$i;
                    break;
                }
            }
        }
        $xiaoshu = 1 - ($adc_res - $wendu[$m]) / ($wendu[$m - 1] - $wendu[$m]);
        $xiaoshu = round($xiaoshu, 3);
        $temp = ($m - 41)+$xiaoshu;
        return $temp;
    }else{
        return  false;
    }
}

/**
 * 获取水分信息
 * @param $water
 * @return int
 */
function getWatering($water){
    if ($water > 593){
        return 0;
    }else if($water < 363){
        return 100;
    }else if($water >= 413){
        return (593 - $water) * 0.28;
    }else{
        return 413 - $water + 50;
    }
}


/**
 * curl POST请求
 * @param $url          //请求地址
 * @param $param        //参数
 * @param $headers      //header
 * @return bool|mixed
 */
function request_post($url, $param,$headers) {
    if (empty($url) || empty($param)) {
        return false;
    }
    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    return $data;
}

/**
 * curl GET请求
 * @param $url      //请求地址
 * @param $header   //header
 * @return mixed
 */
function get_info($url,$header){
    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //执行并获取HTML文档内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}
