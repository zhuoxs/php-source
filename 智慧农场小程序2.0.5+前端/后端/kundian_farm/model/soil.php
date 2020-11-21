<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/6/13 0013
 * Time: 下午 12:00
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/user.php';
require_once ROOT_PATH.'model/control.php';
class Soil_KundianFarmModel{
    protected $uniacid='';
    static $user='';
    static $control='';
    public function __construct($uniacid=''){
        if($uniacid){
            $this->uniacid=$uniacid;
        }
        self::$user=new User_KundianFarmModel();
        self::$control=new Control_KundianFarmModel($this->uniacid);
    }

    public function checkWebThing($land,$setData){
        if(!empty($setData)){
            //获取物联网设备信息
            $land['landDeviceInfo']=false;
            if($setData['is_open_webthing']==1) {
                if ($land['device_id'] != 0 && $land['device_id'] != '') {
                    $device_id = pdo_get('cqkundian_farm_device',['uniacid' => $this->uniacid, 'id' => $land['device_id']], ['did']);
                    $land['landDeviceInfo'] = self::$control->getControlInfo($device_id['did']);
                }
            }elseif ($setData['is_open_webthing']==2){
                if($land['yun_device_id']){

                    $land['yun_device_id']=unserialize($land['yun_device_id']);
                    $land['landDeviceInfo']['temp']=self::$control->getYunDeviceInfo($this->uniacid,$land['yun_device_id']['temp_device_id']);
                    $land['landDeviceInfo']['co2']=self::$control->getYunDeviceInfo($this->uniacid,$land['yun_device_id']['co2_device_id']);
                    $land['landDeviceInfo']['light']=self::$control->getYunDeviceInfo($this->uniacid,$land['yun_device_id']['light_device_id']);
                }
            }
        }
        return $land;
    }

    //整理配送周期信息
    public function arrangeCycle($land_id){
        $cycle=pdo_getall(TABLE_PRE.'land_delivery_cycle',['land_id'=>$land_id,'uniacid'=>$this->uniacid]);
        $day=[];
        $alias=[];
        foreach ($cycle as $k => $v ){
            $day[]=$v['day'];
            $alias[]=$v['alias'];
        }
        return ['day'=>$day,'alias'=>$alias];
    }

    //种植状态信息跟踪
    public function addSeedStatus($txt,$plant_id,$src=''){
        $insertData=array(
            'txt'=>$txt,
            'plant_id'=>$plant_id,
            'uniacid'=>$this->uniacid,
            'create_time'=>time(),
            'src'=>$src,
        );
        return pdo_insert(TABLE_PRE.'send_status',$insertData);
    }
}