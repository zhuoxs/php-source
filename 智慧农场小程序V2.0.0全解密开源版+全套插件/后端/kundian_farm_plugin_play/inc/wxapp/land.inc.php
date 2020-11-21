<?php
/**
 * author:坤典科技
 * User: zyl
 * Date: 2018/11/3
 * Time: 12:37
 */
defined("IN_IA") or exit("Access Denied");
require_once ROOT_PATH.'model/user.php';
require_once ROOT_PATH.'model/land.php';
require_once ROOT_PATH_PLAY.'model/land.php';
require_once ROOT_PATH.'model/live.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH_PLAY.'model/friend.php';
require_once ROOT_PATH.'model/public.php';
require_once ROOT_PATH.'model/notice.php';

class LandController{
    protected $uniacid='';
    protected $uid='';

    static $farmLand='';
    static $playLand='';
    static $common='';
    static $user='';
    static $notice='';
    public function __construct(){
        global $_GPC;
        $this->uniacid=$_GPC['uniacid'];
        $this->uid=$_GPC['uid'];
        self::$farmLand=new Land_KundianFarmModel('',$_GPC['uniacid']);
        self::$playLand=new Land_Model($this->uniacid);
        self::$common=new Common_KundianFarmModel('cqkundian_farm_plugin_play_set');
        self::$user=new User_KundianFarmModel();
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
    }

    //游戏首页初始化获取数据
    public function getHomeData($get){
        global $_W;
        $friendModel=new Friend_Model($this->uniacid);
        $userData=pdo_get('cqkundian_farm_user',['uniacid'=>$this->uniacid,'uid'=>$this->uid]);
        $myLand=self::$farmLand->getUserLandList(['uid'=>$this->uid,'a.status <'=>2],0,9);
        $currentCount=count($myLand);
        for ($i=0;$i<9;$i++){
            if($i<$currentCount) {
                $myLand[$i]['land_name']=$myLand[$i]['land_name'].'('.$myLand[$i]['land_num'].')';
                $myLand[$i]['begin_time'] = $myLand[$i]['create_time'];
                $myLand[$i]['end_time'] =  $myLand[$i]['exprie_time'];
                $landStatus = self::$playLand->getLandStatus($myLand[$i]);
                $myLand[$i]['process'] = $landStatus['process'];
                $myLand[$i]['crops'] = $landStatus['sendName'];
                $myLand[$i]['stealist'] = $friendModel->getStealList(['plant_id'=>$myLand[$i]['id'],'uniacid'=>$this->uniacid,'visit_type'=>1,'uid'=>$this->uid]);
                $myLand[$i]['steal'] = false;
                $myLand[$i]['animation'] = false;
                if($myLand[$i]['process']==3){
                    $myLand[$i]['animation'] = true;
                }
                $myLand[$i]['is_land_buy']=1;
            }else{
                $myLand[$i]=[
                    'is_land_buy'=>0,
                    'steal'=>false,
                    'stealist'=>[],
                    'crops'=>[],
                ];
            }
        }

        //获取配置信息
        $field=['first_time_gold_count','visit_friend_gold_count','farm_explain','animal_explain','farm_name','animal_name',
            'farm_share_title','is_open_recovery','gold_scale_money','is_open_animal','is_open_look_friend','is_open_share_friend',
            'is_open_ground','once_upgrade_area','shed_price','shed_adopt_count'];
        $playSet=self::$common->getSetData($field,$this->uniacid);
        $playSet['jinbiMusic']=$_W['siteroot'].'addons/kundian_farm_plugin_play/resource/static/sabi.mp3';

        //获取仓库中的信息
        $depotData=self::$playLand->getBagList($this->uid);
        $request=array(
            'userData'=>$userData,
            'allLand'=>$myLand,
            'playSet'=>$playSet,
            'none_land'=> empty($myLand) ? true : false,
            'depotData'=>$depotData,
            'openid'=>$_W,
        );
        echo json_encode($request);die;
    }

    //改变种植的状态 摘取已成熟的种子 并放入背包
    public function pickSeed($get){
        $result=self::$playLand->gainSeedAll($get);
        echo $result ? json_encode(['code'=>0,'msg'=>'摘取成功']) :json_encode(['code'=>-1,'msg'=>'摘取失败']);die;
    }

    //获取某块土地可种植的种子
    public function getLandSeed($get){
        $public=new Public_KundianFarmModel('cqkundian_farm_land',$this->uniacid);
        $landData=$public->getTableById($get['land_id']);
        $seed_id=explode(',',$landData['seed']);
        $seedsList=pdo_getall('cqkundian_farm_send',['id in'=>$seed_id,'uniacid'=>$this->uniacid]);
        for ($i=0;$i<count($seedsList);$i++){
            $seedsList[$i]['num']=0;
        }
        echo json_encode(['seedsList'=>$seedsList]);die;
    }

    //土地施肥、除草、捉虫生成订单
    public function operationLand($get){
        $opera_type=$get['operatype'];
        $land_name=$get['land_name'];
        $playSet=self::$common->getSetData(['land_shifei','land_chucao','land_zhuochong'],$this->uniacid);
        $insertData=array(
            'order_number'=>self::$common->getUniqueOrderNumber(),
            'uid'=>$this->uid,
            'adopt_id'=>$get['adopt_id'],
            'is_pay'=>0,
            'create_time'=>time(),
            'is_operation'=>0,
            'operation_type'=>$opera_type,
            'uniacid'=>$this->uniacid,
        );

        $seedData=self::$farmLand->getSeedMine(['lid'=>$get['adopt_id'],'uniacid'=>$this->uniacid,'status'=>1]);
        $area_count=0;
        foreach ($seedData as $key => $value){
            $area_count+=$value['count'];
        }
        if($area_count <= 0){
            echo json_encode(['code'=>-1,'msg'=>'当前土地没有种植中的作物哦~']);die;
        }
        $insertData['area']=$area_count;
        if($opera_type==1){
            $insertData['total_price']=$playSet['land_shifei']*$area_count;
            $insertData['body']=$land_name.'施肥';
        }elseif ($opera_type==2){
            $insertData['total_price']=$playSet['land_chucao']*$area_count;
            $insertData['body']=$land_name.'除草';
        }elseif ($opera_type==3){
            $insertData['total_price']=$playSet['land_zhuochong']*$area_count;
            $insertData['body']=$land_name.'捉虫';
        }

        $order_id=self::$playLand->insertOperation($insertData);
        if($order_id){
            echo json_encode(['code'=>0,'msg'=>'订单生成成功','order_id'=>$order_id]);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'订单生成失败']);die;
    }

    public function getOperationPayOrder(){
        global $_GPC, $_W;
        $orderData=pdo_get('cqkundian_farm_plugin_play_land_opeartion',['id'=>$_GPC['order_id'],'uniacid'=>$this->uniacid]);
        //构造支付参数
        $order = array(
            'tid' => $orderData['order_number'],
            'user' => $_W['openid'],
            'fee' => $orderData['total_price'],
            'title' => $orderData['body'],
        );
        cache_write("kundian_farm_pay_notify_".$_W['openid'],'operationNotify');
        return $order;
    }

    /** 土地施肥除草捉虫操作支付回调 */
    public function operationNotify($log){
        $update_save=[
            'is_pay'=>1,
            'pra_price'=>$log['fee'],
            'pay_time'=>time(),
            'uniontid'=>$log['uniontid'],
        ];
        return pdo_update('cqkundian_farm_plugin_play_land_opeartion',$update_save,['order_number'=>$log['tid'],'uniacid'=>$log['uniacid']]);
    }

    /** 棚升级支付完成后操作 */
    public function upgradeShedNotify($log){
        $update_save=array(
            'is_pay'=>1,
            'pra_price'=>$log['fee'],
            'pay_time'=>time(),
            'uniontid'=>$log['uniontid'],
        );
        load()->func('logging');
        logging_run('棚升级回调');
        logging_run($update_save);
        pdo_update('cqkundian_farm_plugin_play_shed_upgrade',$update_save,['order_number'=>$log['tid'],'uniacid'=>$log['uniacid']]);
    }

    /**土地施肥、除草、捉虫订单支付成功操作*/
    public function operation_notify($get){
        $prepay_id = explode('=', $get['prepay_id']);
        $orderData=self::$playLand->selectOperationData($get['order_id']);
        if($orderData['is_pay']==1) {
            self::$playLand->updateOperation(['form_id'=>$prepay_id[1]],$get['order_id']);
            self::$notice->isPaySendNotice($orderData,'','',$this->uniacid,'');
            echo json_encode(['code'=>0,'msg'=>'订单信息更新成功']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'订单信息更新失败']);die;
    }

    /**卖出全部*/
    public function saleAll($get){
        $saleData=json_decode(htmlspecialchars_decode($get['saleData']));
        if($get['form_id']){
            $user=self::$user->getUserByUid($saleData->uid,$this->uniacid);
            self::$common->insertFormIdData($get['form_id'],$saleData->uid,$user['openid'],1,$this->uniacid);
        }

        pdo_begin();
        //全部售出时  1、修改背包中的状态，2更新用户的金额
        $res=pdo_update('cqkundian_farm_seed_bag',['status'=>2],['id'=>$saleData->id]);
        $salePrice=$saleData->weight*$saleData->sale_price;
        $update_user_res=self::$user->updateUser(['money +='=>$salePrice],['uniacid'=>$this->uniacid,'uid'=>$saleData->uid]);
        $recordRes=self::$user->insertRecordMoney($saleData->uid,$salePrice,1,'卖出'.$saleData->seed_name.' '.$saleData->weight.'kg获得'.$salePrice.'元',$this->uniacid);
        if($res && $update_user_res && $recordRes){
            pdo_commit();
            echo json_encode(['code'=>0,'msg'=>'卖出成功']);die;
        }
        pdo_rollback();
        echo json_encode(['code'=>-1,'msg'=>'卖出失败！']);
    }

    /**部分卖出*/
    public function salePart($get){
        $saleData=json_decode(htmlspecialchars_decode($get['saleData']));
        $weight=$get['weight'];
        if($get['form_id']){
            $user=self::$user->getUserByUid($saleData->uid,$this->uniacid);
            self::$common->insertFormIdData($get['form_id'],$saleData->uid,$user['openid'],1,$this->uniacid);
        }
        //部分售出时 1、修改背包中的重量 2 更新用户金额
        if($weight > $saleData->weight){
            echo json_encode(['code'=>-1,'msg'=>'重量不足~']);die;
        }
        $requset=self::$farmLand->saleSeed($saleData,$weight);
        echo json_encode($requset);
    }

    /** 获取背包信息*/
    public function getSeedBagData(){
        $depotData=self::$playLand->getBagList($this->uid);
        echo json_encode(['depotData'=>$depotData]);die;
    }

    /** 首次进入获得金币*/
    public function getCoin($get){
        $gold_count=$get['first_time_gold_count'];
        if(!$this->uid){
            echo json_encode(['code'=>-1,'msg'=>'请先授权登录']);die;
        }
        $res=self::$user->updateUser(['money +='=>$gold_count,'first_send_money'=>1],['uid'=>$this->uid,'uniacid'=>$this->uniacid]);
        if($res){
            $result=self::$user->insertRecordMoney($this->uid,$gold_count,1,'新用户首次进入获得'.$gold_count.'金币',$this->uniacid);
            echo $result ? json_encode(['code'=>0,'msg'=>'金币数量更新成功']) :json_encode(['code'=>-1,'msg'=>'金币记录失败']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'金币数量更新失败']);die;
    }
}
