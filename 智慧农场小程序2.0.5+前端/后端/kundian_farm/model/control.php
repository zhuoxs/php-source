<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/12 0012
 * Time: 下午 2:08
 * Desc: 机智云平台物联网控制
 */

defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/common.php';
class Control_KundianFarmModel{
    public $uniacid='';
    public $controlSet=[];
    static $common='';
    public function __construct($uniacid){
        $this->uniacid=$uniacid;
        $common=new Common_KundianFarmModel();
        $filed=['is_open_webthing','webthing_password','webthing_username','webthing_appid','webthing_device_id'];
        $controlSet=$common->getSetData($filed,$this->uniacid);
        $this->controlSet=$controlSet;
        self::$common=$common;
    }

    /** 登录并获取机智云平台token 并存储 */
    public function getYunToken(){
        $url="https://api.gizwits.com/app/login";
        $data=array(
            'username'=>$this->controlSet['webthing_username'],
            'password'=>$this->controlSet['webthing_password'],
            "lang"=>"en",
        );
        $result = json_encode($data);    //将数据转化为json格式
        $headers=["Content-Type: application/json","Accept: application/json","X-Gizwits-Application-Id:d8fa29e480f04baaad84c9006f089eb9"];
        $result1=$this->request_post($url,$result,$headers);
        $result2=json_decode($result1);
        cache_write('kundian_farm_jizhiyun_token'.$this->uniacid,$result2->token);
        cache_write('kundian_farm_jizhiyun_token_time'.$this->uniacid,$result2->expire_at);
        cache_write('kundian_farm_jizhiyun_uid'.$this->uniacid,$result2->uid);
        return $result2->token;
    }

    public function getDeviceList($token){
        $url='https://api.gizwits.com/app/bindings?limit=500&skip=0';
        $headers=array("Content-Type: application/json","Accept: application/json","X-Gizwits-Application-Id:d8fa29e480f04baaad84c9006f089eb9","X-Gizwits-User-token:".$token);
        $result=$this->get_info($url,$headers);
        return json_decode($result);
    }

    /** 获取设备信息并进行组合 返回 水分 温度 光照 二氧化碳信息 */
    public function getControlInfo($did){
        if($did=='' || empty($did)){
            return false;
        }
        //获取当前设备的温度和水分信息
        $didInfo=$this->getDidInfo($did);
        $data['temp']=round($this->getTmpData($didInfo->attr),1);
        $data['watering']=$this->getWatering($didInfo->attr);
        //光照
        $tmp1=$didInfo->attr->timeon2;
        $tmp2=$didInfo->attr->timeoff2;
        //判断当前程序是否存在主设备did
        if(!empty($this->controlSet['webthing_device_id']) || $this->controlSet['webthing_device_id']!='' ) {
             $mainInfo=$this->getDidInfo($this->controlSet['webthing_device_id']);
             //光照
             $tmp1=$mainInfo->attr->timeon2;
             $tmp2=$mainInfo->attr->timeoff2;
        }
        $data['illumination'] = ($tmp1 * 100 + $tmp2) * 0.045;  //光照

        $co2=$this->get_co2($didInfo->attr);
        $data['co2']=round($co2);
        return $data;
    }

    /**
     * 远程控制物联网设置
     * @param $did  //设备DID
     * @param $data //控制操作
     * @return int
     */
    public function controlDid($did,$data){
        $url="https://api.gizwits.com/app/control/".$did;
        if(cache_load('kundian_farm_jizhiyun_token_time'.$this->uniacid) < time()){
            $token=cache_load('kundian_farm_jizhiyun_token'.$this->uniacid);
        }else{
            $token=$this->getYunToken();
        }
        $token=$this->getYunToken();
        $headers=array("Content-Type: application/json","Accept: application/json","X-Gizwits-Application-Id:d8fa29e480f04baaad84c9006f089eb9","X-Gizwits-User-token:".$token);
        $jsonData=json_encode($data);
        $result=$this->request_post($url,$jsonData,$headers);
        $result=json_decode($result);
        if($result->error_message){
            return $result->error_message;
        }
        return count(get_class_methods($result));
    }

    /** 获取设备信息 */
    public function getDidInfo($did){
        $url='https://api.gizwits.com/app/devdata/'.$did.'/latest';
        $headers=array("Content-Type: application/json","Accept: application/json","X-Gizwits-Application-Id:d8fa29e480f04baaad84c9006f089eb9");
        $result=$this->get_info($url,$headers);
        return json_decode($result);
    }

    public function get_d_num($attr,$v){
        if($attr->state1==$v){
            return $attr->state1_set;
        }
        if($attr->state2==$v){
            return $attr->state2_set;
        }
        if($attr->state3==$v){
            return $attr->state3_set;
        }
        if($attr->state4==$v){
            return $attr->state4_set;
        }
        if($attr->state5==$v){
            return $attr->state5_set;
        }
        return '';
    }

    public function get_co2($attr){
        $c=$this->get_d_num($attr,17);
        if(!$c){
            return false;
        }
        $tmp = $c * 3.3 / 1023;
        if ($tmp < 0.4) {
            return 0;
        }
        return round((($tmp - 0.4) * 3125),2);
    }

    /** 计算温度信息 */
    public function getTmpData($attr){
        $t=$this->get_d_num($attr,1);
        if(!$t){
            return false;
        }
        $adc_u=$t * (3.3 / 1023);
        if($adc_u==0){
            return false;
        }
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
            if ($adc_res > $wendu[$i]) {
                $m=$i;
                break;
            }
        }
        $xiaoshu = 1 - ($adc_res - $wendu[$m]) / ($wendu[$m - 1] - $wendu[$m]);
        $xiaoshu = round($xiaoshu, 3);
        $temp = ($m - 41)+$xiaoshu;
        return $temp;
    }

    /** 计算水分含量*/
    function getWatering($attr){
        $water=$this->get_d_num($attr,16);
        if($water > 593 ){
            return 0;
        }
        if($water < 363 ){
            return 100;
        }
        if( $water >= 413 ){
            return (593 - $water) * 0.28;
        }
        return 413 - $water + 50;
    }

    /** POST 请求 */
    public function request_post($url, $param,$headers) {
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书下同
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }

    /** GET 请求*/
    public function get_info($url,$header){
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书下同
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        return $output;
    }

    /** 获取设备绑定列表*/
    public function getBindDevice(){
        $url='https://api.gizwits.com/app/bindings?limit=20&skip=0';
        if(cache_load('kundian_farm_jizhiyun_token_time'.$this->uniacid) < time()){
            $token=cache_load('kundian_farm_jizhiyun_token'.$this->uniacid);
        }else{
            $token=$this->getYunToken();
        }
        $headers=array("Content-Type: application/json","Accept: application/json","X-Gizwits-Application-Id:d8fa29e480f04baaad84c9006f089eb9","X-Gizwits-User-token:".$token);
        $result=$this->get_info($url,$headers);
        return json_decode($result);
    }

    public function watering($lid,$did,$type){
        $deviceData=$this->getControlInfo($did);
        if($type==1){
            $landMine=pdo_get('cqkundian_farm_land_mine',array('uniacid'=>$this->uniacid,'id'=>$lid));
            //判断今天是否已经施过肥了
            if($landMine['fertilization_update'] > strtotime(date("Y-m-d",time()))){
                return ['code'=>3,'msg'=>'今日已经施过肥了！'];
            }
            $data=[
                'attrs'=>['onoff2'=>true],
            ];
            $res=$this->controlDid($did,$data);
            if($res!=0 || $res ){
                return ['code'=>'2','msg'=>$res];
            }
            //更新最后施肥时间
            pdo_update('cqkundian_farm_land_mine',['fertilization_update'=>time()],['uniacid'=>$this->uniacid,'id'=>$lid]);
            $this->insertLandOpeartionRecord(2,$lid,$this->uid,$this->uniacid);
            return ['code'=>'1','msg'=>'已完成施肥了哦!'];
        }elseif ($type==3){
            $data=[
                'attrs'=>['onoff3'=>true,],
            ];
            $res=$this->controlDid($did,$data);
            if($res!=0 || $res ){
                return ['code'=>'2','msg'=>$res];
            }
            pdo_update('cqkundian_farm_land_mine',['insecticide_update'=>time()],['uniacid'=>$this->uniacid,'id'=>$lid]);
            $this->insertLandOpeartionRecord(3,$lid,$this->uid,$this->uniacid);

            return ['code'=>1,'msg'=>'杀虫中'];
        }elseif ($type==4){
            //当前水分是否大于70%
            if($deviceData['watering']>70){
                return ['code'=>3,'msg'=>'当前水分充足！','water'=>$deviceData];
            }
            $data=[
                'attrs'=>['onoff1'=>true,],
            ];
            $res=$this->controlDid($did,$data);
            if($res!=0 || $res ){
                return ['code'=>'2','msg'=>$res];
            }
            //更新最后浇水时间
            pdo_update('cqkundian_farm_land_mine',['watering_update'=>time()],['uniacid'=>$this->uniacid,'id'=>$lid]);
            $this->insertLandOpeartionRecord(1,$lid,$this->uid,$this->uniacid);
            return ['code'=>'1','msg'=>'已完成浇水了哦!'];
        }
    }

    /** 关闭设备 */
    public function closeDevice($close_type,$did){
        if($close_type==3){//杀虫
            $data=[
                'attrs'=>['onoff3'=>0],
            ];
            $msg='杀虫操作已完成';
        }elseif($close_type==4){  //浇水
            $data=array(
                'attrs'=>['onoff1'=>false],
            );
            $msg='浇水操作已完成';
        }elseif ($close_type==1) {  //施肥
            $data=array(
                'attrs'=>['onoff2'=>false,],
            );
            $msg='施肥操作已完成';
        }
        $res=$this->controlDid($did,$data);
        if($res==0){
            return ['code'=>200,'msg'=>$msg];
        }
        return ['code'=>200,'msg'=>$res];
    }

    public function insertLandOpeartionRecord($type,$land_id,$uid,$uniacid){
        $data=array(
            'type'=>$type,
            'land_id'=>$land_id,
            'uniacid'=>$uniacid,
            'create_time'=>time(),
            'uid'=>$uid,
        );
        if($type==1){
            $data['remark']='浇水';
        }elseif($type==2){
            $data['remark']='施肥';
        }elseif($type==3){
            $data['remark']='除草';
        }elseif($type==4){
            $data['remark']='杀虫';
        }
        pdo_insert('cqkundian_farm_land_operation_record',$data);
    }

    public function opeartionRecord($type,$order_id,$uid,$uniacid){
        $data=array(
            'type'=>$type,
            'order_id'=>$order_id,
            'uniacid'=>$uniacid,
            'create_time'=>time(),
            'uid'=>$uid,
        );
        if($type==1){
            $data['remark']='浇水';
        }elseif($type==2){
            $data['remark']='施肥';
        }elseif($type==3){
            $data['remark']='除草';
        }elseif($type==4){
            $data['remark']='杀虫';
        }
        pdo_insert('cqkundian_farm_land_operation_record',$data);
    }


    /** 坤典物联网品台二 begin */
    /**
     * 控制继电器
     * @param $uniacid     小程序唯一id
     * @param $id          继电器唯一ID
     * @param $status      要修改的状态
     * @return mixed       返回值
     */
    public function controlRelays($uniacid,$id,$status){
        $setData=self::$common->getSetData(['yun_domain','yun_username','yun_pwd'],$uniacid);
        $url="http://".$setData['yun_domain']."/wsjc/Device/setRelays.do?RelaysID=".$id."&status=".$status."&userID=".$setData['yun_username']."&userPassword=".$setData['yun_pwd'];
        $result=$this->getInfo($url);
        var_dump($result);die;
        return $result;
    }

    /**
     * curl GET请求
     * @param $url      //请求地址
     * @param $header   //header
     * @return mixed
     */
    public function getInfo($url){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        $tmpInfo = curl_exec($curl);     //返回api的json对象
        //关闭URL请求
        curl_close($curl);
        return $tmpInfo;    //返回json对象
    }

    /**
     * @param $uniacid
     * @return bool|mixed
     */
    public function getRelaysData($uniacid){
        $setData=self::$common->getSetData(['yun_domain','yun_username','yun_pwd'],$uniacid);
        $url="http://".$setData['yun_domain']."/wsjc/Device/getRelays.do?userID=".$setData['yun_username']."&userPassword=".$setData['yun_pwd'];
        $result=$this->getInfo($url);
        $result=json_decode($result);
        return $result ? $result :false;
    }

    /**
     * 获取云平台设备信息
     * @param $uniacid
     * @param $temp_device_id
     * @return array
     */
    public function getYunDeviceInfo($uniacid,$temp_device_id=''){
        $setData=self::$common->getSetData(['yun_domain','yun_username','yun_pwd'],$uniacid);
        $url="http://".$setData['yun_domain']."/wsjc/Device/getDeviceData.do?userID=".$setData['yun_username']."&userPassword=".$setData['yun_pwd'];
        $result=$this->getInfo($url);
        $result=json_decode($result);
        if($temp_device_id) {
            $data = array();
            foreach ($result as $key => $value) {
                if ($value->DevKey == $temp_device_id) {
                    $data = $value;
                }
            }
            return $data ? $data : false;
        }else{
            return $result ? $result :false;
        }
    }

    /** 坤典物联网品台二 end */
}