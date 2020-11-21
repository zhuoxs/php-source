<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/11/6
 * Time: 9:45
 */
defined("IN_IA") or exit('Access Denied');
require_once ROOT_PATH.'model/animal.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/user.php';
require_once ROOT_PATH.'model/notice.php';
require_once ROOT_PATH_PLAY.'model/animal.php';
class AnimalController{
    protected $uniacid='';
    protected $uid='';
    static $animal='';
    static $common='';
    public function __construct(){
        global $_GPC;
        $this->uniacid=$_GPC['uniacid'];
        $this->uid=$_GPC['uid'];
        self::$animal=new Animal_KundianFarmModel($this->uniacid);
        self::$common=new Common_KundianFarmModel('cqkundian_farm_plugin_play_set');
    }

    //初始化获取牧页面信息
    public function getMyAnimal($get){
        $userModel=new User_KundianFarmModel();
        $userData=$userModel->getUserByUid($this->uid,$this->uniacid);
        $adoptCount=pdo_getall('cqkundian_farm_animal_adopt',['uid'=>$this->uid,'uniacid'=>$this->uniacid,'status in'=>[1,2,4]],'','','create_time desc');
        $adoptSet=self::$common->getSetData(['shed_adopt_count','shed_begin_area'],$this->uniacid);
        if($userData['first_shed_send']==0){
            $userModel->updateUser(['shed_area +='=>$adoptSet['shed_begin_area'],'first_shed_send'=>1],['uid'=>$this->uid,'uniacid'=>$this->uniacid]);
            $userData['shed_area']+=$adoptSet['shed_begin_area'];
        }
        $pageSize=$userData['shed_area'] * $adoptSet['shed_adopt_count'];
        if($pageSize < 1){
            $pageSize=1;
        }

        //判断当前棚面积是否需要升级
        $is_upgrade=false;
        if(count($adoptCount) > $pageSize){
            $is_upgrade=true;
        }
        $animalList=pdo_getall('cqkundian_farm_animal_adopt',['uid'=>$this->uid,'uniacid'=>$this->uniacid,'status in'=>[1,2,3,4]],'','','create_time desc',[1,$pageSize]);
        for ($i=0;$i<count($animalList);$i++){
            $animal=pdo_get('cqkundian_farm_animal',['id'=>$animalList[$i]['aid']]);
            $animalList[$i]['img']=unserialize($animal['sports_src']);
            $animalList[$i]['animal_name']=$animal['animal_name'];
            //更新认养天数
            $day=floor((time()-$animalList[$i]['today_time'])/60/60/24);
            pdo_update('cqkundian_farm_animal_adopt',['adopt_day'=>$day],['id'=>$animalList[$i]['id'],'uniacid'=>$this->uniacid,'status'=>[2,4]]);
            $animalList[$i]['status_txt']=self::$animal->neatAdoptStatus($animalList[$i]['status']);
            //判断当前的进度
            $between=($animalList[$i]['predict_ripe']-$animalList[$i]['create_time'])/60/60/24;
            if($between > 0){
                $between_day=floatval($animalList[$i]['adopt_day']/$between);
            }
            $animalList[$i]['cycle']=round($between);
            $animalList[$i]['process']=round($between_day*100,2);
        }


        //认养状态为 6 表示放入背包
        $depotData=pdo_getall('cqkundian_farm_animal_adopt',['status'=>6,'uniacid'=>$this->uniacid],'','','create_time desc');
        for ($i=0;$i<count($depotData);$i++){
            $animal=pdo_get('cqkundian_farm_animal',['uniacid'=>$this->uniacid,'id'=>$depotData[$i]['aid']]);
            $depotData[$i]['cover']=$animal['animal_src'];
            $depotData[$i]['animal_name']=$animal['animal_name'];
            $depotData[$i]['create_time']=date("Y-m-d",$depotData[$i]['create_time']);
        }
        $request=['animalList'=>$animalList,'userData'=>$userData,'depotData'=>$depotData,'is_upgrade'=>$is_upgrade];
        echo json_encode($request);die;
    }

    /** 获取状态为放入背包的人认养信息*/
    public function getAnimalBagData($get){
        $depotData=pdo_getall('cqkundian_farm_animal_adopt',['status'=>6,'uniacid'=>$this->uniacid],'','','create_time desc');
        for ($i=0;$i<count($depotData);$i++){
            $animal=pdo_get('cqkundian_farm_animal',['uniacid'=>$this->uniacid,'id'=>$depotData[$i]['aid']]);
            $depotData[$i]['cover']=$animal['animal_src'];
            $depotData[$i]['animal_name']=$animal['animal_name'];
            $depotData[$i]['create_time']=date("Y-m-d",$depotData[$i]['create_time']);
        }
        echo json_encode(['depotList'=>$depotData]);die;
    }

    /** 将认养状态为已成熟的认养状态修改为放入背包*/
    public function joinBag($get){
        $res=pdo_update('cqkundian_farm_animal_adopt',['status'=>6],['id'=>$get['adopt_id'],'uniacid'=>$this->uniacid,'uid'=>$this->uid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'已放入背包']) : json_encode(['code'=>-1,'msg'=>'放入背包失败']);die;
    }

    /** 生成棚升级订单*/
    public function createUpgradeShedOrder($get){
        $adoptSet=self::$common->getSetData(['once_upgrade_area','shed_price'],$this->uniacid);
        $totalPrice=$adoptSet['once_upgrade_area']*$adoptSet['shed_price'];
        $insertData=array(
            'order_number'=>self::$common->getUniqueOrderNumber(),
            'uid'=>$this->uid,
            'is_pay'=>0,
            'uniacid'=>$this->uniacid,
            'total_price'=>$totalPrice,
            'upgrade_area'=>$adoptSet['once_upgrade_area'],
            'body'=>'认养棚升级',
            'pay_method'=>'微信支付',
            'create_time'=>time(),
        );

        $animal_play=new Animal_Model($this->uniacid);
        $order_id=$animal_play->insertShedOrder($insertData);
        echo $order_id ? json_encode(['code'=>0,'msg'=>'订单生成成功','order_id'=>$order_id]) : json_encode(['code'=>-1,'msg'=>'订单生成失败']);
        die;
    }

    public function playUpgradePayOrder(){
        global $_GPC, $_W;
        $orderData=pdo_get('cqkundian_farm_plugin_play_shed_upgrade',['id'=>$_GPC['order_id'],'uniacid'=>$this->uniacid]);
        //构造支付参数
        $order = array(
            'tid' => $orderData['order_number'],
            'user' => $_W['openid'],
            'fee' => $orderData['total_price'],
            'title' => $orderData['body'],
        );
        cache_write("kundian_farm_pay_notify_".$_W['openid'],'upgradeShedNotify');
        return $order;
    }

    /** 购买棚成功后执行*/
    public function UpgradeShedNotify(){
        global $_W,$_GPC;
        $order_id=$_GPC['order_id'];
        $animal_play=new Animal_Model($this->uniacid);
        $prepay_id_str=$_GPC['prepay_id'];
        $orderData=$animal_play->getShedOrderById($order_id);
        if($orderData['is_pay']==1){
            $userModel=new User_KundianFarmModel();
            $userModel->updateUser(['shed_area +='=>$orderData['upgrade_area']],['uid'=>$orderData['uid'],'uniacid'=>$this->uniacid]);
            $prepay_id = explode('=', $prepay_id_str);
            //发送模板消息通知
            $commonModel=new Common_KundianFarmModel();
            $notice=new Notice_KundianFarmModel($this->uniacid);
            $notice->isPaySendNotice($orderData,$prepay_id[1],$_W['openid'],$this->uniacid);
            $commonModel->insertFormIdData($prepay_id[1],$orderData['uid'],$_W['opeenid'],2,$this->uniacid);
            echo json_encode(['code'=>0,'msg'=>'success']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'该订单未支付']);die;
    }

    /** 卖出认养*/
    public function saleAdopt($get){
        $adoptData=pdo_get('cqkundian_farm_animal_adopt',['uniacid'=>$this->uniacid,'id'=>$get['adopt_id']]);
        $animalData=pdo_get('cqkundian_farm_animal',['uniacid'=>$this->uniacid,'id'=>$adoptData['aid']]);
        $totalPrice=$adoptData['weight'] * $adoptData['sale_price'];
        $res=pdo_update('cqkundian_farm_animal_adopt',['status'=>8],['uniacid'=>$this->uniacid,'uid'=>$this->uid,'id'=>$get['adopt_id']]);
        if($res){
            $userModel=new User_KundianFarmModel();
            $user_res=$userModel->updateUser(['money +='=>$totalPrice],['uid'=>$this->uid,'uniacid'=>$this->uniacid]);
            $record_res=$userModel->insertRecordMoney($this->uid,$totalPrice,1,'卖出'.$animalData['animal_name'].' '.$adoptData['weight'].'获得',$this->uniacid);
            if($user_res && $record_res){
                echo json_encode(['code'=>0,'msg'=>'卖出成功','totalPrice'=>$totalPrice]);die;
            }
            echo json_encode(['code'=>-1,'msg'=>'信息更新失败']);
        }
        echo json_encode(['code'=>-1,'msg'=>'卖出失败，请稍后重试']);die;
    }
}
