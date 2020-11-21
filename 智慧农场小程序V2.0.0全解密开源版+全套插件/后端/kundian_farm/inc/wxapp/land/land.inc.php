<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/11/23
 * Time: 9:13
 */
defined("IN_IA") or exit('Access Denied');
require_once ROOT_PATH .'model/land.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/user.php';
require_once ROOT_PATH.'model/order.php';
require_once ROOT_PATH.'model/public.php';
require_once ROOT_PATH.'model/notice.php';
class landController{
    protected $uniacid='';
    protected $uid='';
    static $land='';
    static $common='';
    static $user='';
    static $order='';
    static $notice='';
    public function __construct(){
        global $_W,$_GPC;
        $this->uniacid=$_GPC['uniacid'];
        $this->uid=$_GPC['uid'];
        self::$land=new Land_KundianFarmModel('',$this->uniacid);
        self::$common=new Common_KundianFarmModel();
        self::$user=new User_KundianFarmModel();
        self::$order=new Order_KundianFarmModel($this->uniacid);
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
    }

    /** 获取土地列表信息 */
    public function getLandList(){
        $public=new Public_KundianFarmModel('cqkundian_farm_land_type',$this->uniacid);
        $landType=$public->getTableList([],'','','rank asc');
        $landData=self::$land->getLandAndSpec(['type_id'=>$landType[0]['id']],0,10);
        $request=[
            'landType'=>$landType,
            'landData'=>$landData,
        ];
        echo json_encode($request);die;
    }

    /** 根据土地分类获取土地信息 */
    public function getLandByType($request){
        $page=$request['page'] ? $request['page'] : 0;
        $return['landData']=self::$land->getLandAndSpec(['type_id'=>$request['type_id']],$page,10);
        echo json_encode($return);die;
    }

    /** 获取土地购买详情页面信息 */
    public function getLandDetail($request){
        global $_W;
        $setData=self::$common->getSetData(['is_open_webthing','webthing_device_id'],$this->uniacid);
        $return=self::$land->getLandDetail($request['lid'],$setData);
        $return['icon']=array(
            'co2'=>$_W['siteroot'].'addons/kundian_farm/resource/image/co2.png',
            'humidity'=>$_W['siteroot'].'addons/kundian_farm/resource/image/humidity.png',
            'Illumination'=>$_W['siteroot'].'addons/kundian_farm/resource/image/Illumination.png',
            'temperature'=>$_W['siteroot'].'addons/kundian_farm/resource/image/temperature.png',
            'selectLand1'=>$_W['siteroot'].'addons/kundian_farm/resource/image/selectLand1.png',
            'hsdSelelct'=>$_W['siteroot'].'addons/kundian_farm/resource/image/hsdSelelct.png',
        );
        $return['landLimit']=$return['landDataLimit'][0];
        echo json_encode($return);die;
    }

    /** 购买土地下订单时 获取土地详细信息 */
    public function getPayLand($get){
        global $_W;
        $selectLand=json_decode($_POST['selectLand']);
        $request=self::$land->calculateLandPrice($selectLand,$get['lid']);
        //规则
        $request['farmRule']=self::$common->getSetData(['farm_rule'],$this->uniacid);
        //查看用户是否有优惠券
        $userCoupon=self::$user->jugdeUserCoupon($get['uid'],$request['total_price'],$this->uniacid,4);
        $request['couponCount']=$userCoupon['couponCount'];

        //用户信息
        $request['user']=pdo_get('cqkundian_farm_user',['uid'=>$get['uid'],'uniacid'=>$this->uniacid],['truename','phone']);
        $request['icon']=[
            'selectIcon'=>$_W['siteroot'].'addons/kundian_farm/resource/image/selectIcon.png',
            'lifeIcon'=>$_W['siteroot'].'addons/kundian_farm/resource/image/lifeIcon.png',
        ];
        echo json_encode($request);die;
    }

    /** 生成土地租赁订单 */
    public function insertLandOrder($get){
        $selectLand=json_decode(htmlspecialchars_decode($get['selectLand']));
        $landSpec=pdo_get('cqkundian_farm_land_spec',['uniacid'=>$this->uniacid,'id'=>$selectLand[0]->id]);
        if($landSpec['status']!=0){
            echo json_encode(['code'=>-1,'土地已被租出！']);die;
        }
        $order_id=self::$order->updateLandOrder($get);
        if($order_id){
            echo json_encode(['code'=>0,'msg'=>'订单生成成功','order_id'=>$order_id]);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'订单生成失败']);die;
    }

    /** 生成支付订单信息 */
    public function getLandPayOrder(){
        global $_GPC, $_W;
        $public=new Public_KundianFarmModel('cqkundian_farm_land_order',$this->uniacid);
        $orderData=$public->getTableById($_GPC['orderid']);
        //构造支付参数
        $order = array(
            'tid' => $orderData['order_number'],
            'user' => $_W['openid'],
            'fee' => $orderData['total_price'],
            'title' => '土地租赁',
        );
        cache_write("kundian_farm_pay_notify_".$_W['openid'],5);
        return $order;
    }

    /***
     * 支付回调信息
     * @param $order_id
     * @param $log
     * @return bool
     */
    public function landNotify($order_id,$log){
        load()->func('logging');
        $public=new Public_KundianFarmModel('cqkundian_farm_land_order',$log['uniacid']);
        $update_save=array(
            'status'=>1,
            'pra_price'=>$log['fee'],
            'pay_time'=>time(),
            'pay_method'=>'微信支付',
            'uniontid' =>$log['uniontid'],
        );
        $orderData=pdo_get('cqkundian_farm_land_order',['order_number'=>$order_id,'uniacid'=>$log['uniacid']]);
        pdo_begin();
        if($orderData['is_price']==1){
            self::$common->saleSendPrice($orderData,$log['uniacid'],4);
            $update_save['is_price']=2;
        }
        $res=$public->updateTable($update_save,['order_number'=>$order_id,'uniacid'=>$log['uniacid']]);

        //更新我的土地信息
        $insertRes=self::$land->insertBuyMineLand($orderData);
        $res2=self::$user->insertScoreRecord($orderData,$orderData['uid'],$log['uniacid'],1);

        if($res && $insertRes && $res2){
            //发送模板消息
            self::$notice->isPaySendNotice($orderData,'',$log['user'],$log['uniacid']);
            pdo_commit();
            return true;
        }
        pdo_rollback();
        return false;
    }

    /** 土地租赁成功后发送模板消息推送 */
    public function sendMsg($get){
        global $_W;
        $orderData=pdo_get('cqkundian_farm_land_order',['id'=>$get['order_id'],'uniacid'=>$this->uniacid]);
        if($orderData['status']==1) {
            $prepay_id = explode('=', $get['prepay_id']);
            self::$notice->isPaySendNotice($orderData,$prepay_id[1],$_W['openid'],$this->uniacid);
            self::$common->insertFormIdData($prepay_id[1],$orderData['uid'],$_W['openid'],2,$this->uniacid);
            echo json_encode(['code' => 1]);die;
        }
        echo json_encode(['code' => 2]);
        die;
    }

    //获取我的土地列表
    public function getMineLand($get){
        $condition['uid']=$get['uid'];
        if($get['current']==2){
            $condition['status']=0;
        }elseif ($get['current']==3){
            $condition['status']=1;
        }elseif($get['current']==4){
            $condition['status']=2;
        }
        $page=$get['page'] ? intval($get['page'])+1 : $get['page'] ;
        $request['landData']=self::$land->getUserLandList($condition,$page,10);
        echo json_encode($request);die;
    }

    //获取我的土地信息详细列表
    public function getMineLandDetail($get){
        global $_W;
        $farmSetData=self::$common->getSetData(['is_open_webthing'],$this->uniacid);
        $request=self::$land->getMineLandDetail($get,['id'=>$get['lid'],'uniacid'=>$this->uniacid,'uid'=>$this->uid],true,$farmSetData);
        $icon=array(
            'Weed'=>$_W['siteroot'].'addons/kundian_farm/resource/image/Weed.png',
            'watering'=>$_W['siteroot'].'addons/kundian_farm/resource/image/watering.png',
            'Insecticide'=>$_W['siteroot'].'addons/kundian_farm/resource/image/Insecticide.png',
            'fertilizer'=>$_W['siteroot'].'addons/kundian_farm/resource/image/fertilizer.png',
        );
        $request['icon']=$icon;
        echo json_encode($request);die;
    }

    public function getScanLand($get){
        $request=self::$land->getMineLandDetail($get,['id'=>$get['lid'],'uniacid'=>$this->uniacid]);
        $request['orderData']=pdo_get('cqkundian_farm_land_order',['id'=>$request['mineLand']['order_id'],'uniacid'=>$this->uniacid]);
        $request['user']=pdo_get('cqkundian_farm_user',['uid'=>$request['mineLand']['uid'],'uniacid'=>$this->uniacid]);
        echo json_encode($request);die;
    }

    //获取种子列表信息
    public function getSeedList($get){
        $public=new Public_KundianFarmModel('cqkundian_farm_land_mine',$this->uniacid);
        $landData=$public->getTableById($get['lid']);
        $data=self::$land->getLandDetail($landData['lid']);
        for ($i=0;$i<count($data['seedData']);$i++){
            $data['seedData'][$i]['selectCount']=0;
        }
        echo json_encode(['seedList'=>$data['seedData']]);die;
    }

    /** 获取种子信息信息 */
    public function getSendDetail($get){
        $public=new Public_KundianFarmModel('cqkundian_farm_send',$this->uniacid);
        $sendDetail=$public->getTableById($get['sid']);
        $sendDetail['send_slide']=unserialize($sendDetail['send_slide']);
        echo json_encode(['sendDetail'=>$sendDetail]);die;
    }

    //生成种子支付订单
    public function addSeedOrder($get){
        $order_id=self::$order->updateSeedOrder($get);
        if($order_id){
            echo json_encode(['code'=>0,'msg'=>'订单生成成功','order_id'=>$order_id]);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'订单生成失败']);die;
    }

    /** 生成种子支付订单信息*/
    public function getSeedPayOrder(){
        global $_GPC, $_W;
        $public=new Public_KundianFarmModel('cqkundian_farm_send_order',$this->uniacid);
        $orderData=$public->getTableById($_GPC['orderid']);
        //构造支付参数
        $order = array(
            'tid' => $orderData['order_number'],
            'user' => $_W['openid'],
            'fee' => $orderData['total_price'],
            'title' => '土地租赁',
        );
        cache_write("kundian_farm_pay_notify_".$_W['openid'],6);
        return $order;
    }

    public function seedNotify($order_id,$log){
        $public=new Public_KundianFarmModel('cqkundian_farm_send_order',$log['uniacid']);
        $update_save=array(
            'status'=>1,
            'pra_price'=>$log['fee'],
            'pay_time'=>time(),
            'pay_method'=>'微信支付',
            'uniontid' =>$log['uniontid'],
        );
        $orderData=pdo_get('cqkundian_farm_send_order',['order_number'=>$order_id,'uniacid'=>$log['uniacid']]);
        pdo_begin();
        if($orderData['is_price']==1){
            self::$common->saleSendPrice($orderData,$log['uniacid'],4);
            $update_save['is_price']=2;
        }
        $res=$public->updateTable($update_save,['order_number'=>$order_id,'uniacid'=>$log['uniacid']]);
        self::$land->updateSend($orderData, $log['uniacid']);
        $res1=self::$user->insertScoreRecord($orderData,$orderData['uid'],$log['uniacid'],1);
        if($res && $res1){
            pdo_commit();
            return true;
        }
        pdo_rollback();
        return false;
    }

    public function notifySeed(){
        global $_W,$_GPC;
        $orderData=pdo_get('cqkundian_farm_send_order',array('id'=>$_GPC['order_id'],'uniacid'=>$this->uniacid));
        if($orderData['status']==1) {
            $prepay_id = explode('=', $_GPC['prepay_id']);
            self::$notice->isPaySendNotice($orderData,$prepay_id[1],$_W['openid'],$this->uniacid);
            self::$common->insertFormIdData($prepay_id[1],$orderData['uid'],$_W['openid'],2,$this->uniacid);
            echo json_encode(array('code' => 1));die;
        }
        echo json_encode(array('code' => 2));
        die;
    }


    //获取种子状态跟踪信息
    public function getSeedStatusList($get){
        global $_W;
        if(!empty($get['formid'])){
            self::$common->insertFormIdData($get['formid'],$this->uid,$_W['openid'],1,$this->uniacid);
        }
        if(empty($get['lid']) || $get['lid']=='undefined'){
            echo json_encode(['landStatus'=>[]]);die;
        }
        $landStatus=self::$land->getSeedStatus(['seed_id'=>$get['seed_id'],'lid'=>$get['lid'],'uniacid'=>$this->uniacid]);
        echo json_encode(['landStatus'=>$landStatus]);die;
    }

    //立即摘取
    public function gainSeed($get){
        global $_W;
        if(!empty($get['formid'])){
            self::$common->insertFormIdData($get['formid'],$this->uid,$_W['openid'],1,$this->uniacid);
        }
        $public=new Public_KundianFarmModel('cqkundian_farm_send_mine',$this->uniacid);
        //更新状态为收获中
        pdo_begin();
        $res=$public->updateTable(['status'=>5],['id'=>$get['seed_id'],'uniacid'=>$this->uniacid]);
        $res1=self::$land->addSeedBag($get);
        if($res && $res1){
            pdo_commit();
            echo json_encode(['code'=>0,'msg'=>'操作成功,请等待管理员进行摘取~']);die;
        }
        pdo_rollback();
        echo json_encode(['code'=>-1,'msg'=>'操作失败']);die;
    }

    //获取背包中的信息
    public function getSeeBagList($get){
        global $_W;
        if($get['formid']) {
            self::$common->insertFormIdData($get['formid'],$this->uid,$_W['openid'],1,$this->uniacid);
        }
        $public=new Public_KundianFarmModel('cqkundian_farm_seed_bag',$this->uniacid);
        $bagList=$public->getTableList(['uid'=>$this->uid,'status'=>0]);
        echo json_encode(['bagList'=>$bagList]);die;
    }

    //生成种植配送订单
    public function addSeedSendOrder(){
        global $_W,$_GPC;
        if($_GPC['formid']){
            self::$common->insertFormIdData($_GPC['formid'],$this->uid,$_W['openid'],1,$this->uniacid);
        }
        $name=$_GPC['name'];
        $address=$_GPC['address'];
        $phone=$_GPC['phone'];
        $selectBag=json_decode($_POST['selectBag']);
        $seedData=self::$land->getSeedMine(['id'=>$selectBag->seed_id,'uniacid'=>$this->uniacid],false);
        $farmSetData=self::$common->getSetData(['seed_send_price'],$this->uniacid);
        $insertData=array(
            'order_number'=>rand(100,999).time().rand(100,999),
            'uid'=>$this->uid,
            'status'=>0,
            'create_time'=>time(),
            'name'=>$name,
            'address'=>$address,
            'phone'=>$phone,
            'uniacid'=>$this->uniacid,
            'send_price'=>$farmSetData['seed_send_price'],
            'total_price'=>$farmSetData['seed_send_price'],    //只需要支付运费
            'order_type'=>4,
            'body'=>$selectBag->send_name.'摘取',
            'send_method'=>$_GPC['recovery_method']==1 ? 0 : 1,
        );

        if($_GPC['recovery_method']==2){
            require_once ROOT_PATH.'model/goods.php';
            $goods=new Goods_KundianFarmModel('','');
            $offline_qrocde=$goods->getGoodsQrcode('/kundian_farm/pages/shop/verify/index?order_number='.$insertData['order_number'],$this->uniacid);
            $insertData['offline_qrocde']=$offline_qrocde;
        }

        $order_res=pdo_insert('cqkundian_farm_shop_order',$insertData);
        $order_id=pdo_insertid();
        $insertDetail=array(
            'goods_id'=>$selectBag->seed_id,
            'order_id'=>$order_id,
            'goods_name'=>$selectBag->seed_name,
            'cover'=>$selectBag->cover,
            'price'=>$selectBag->sale_price,
            'count'=>$selectBag->weight,
            'uniacid'=>$this->uniacid,
            'spec_id'=>$seedData['lid'],
        );
        $detail_res=pdo_insert('cqkundian_farm_shop_order_detail',$insertDetail);
        if($order_res && $detail_res){
            if($_GPC['recovery_method']==2){
                self::$land->updateSeedMine(['status'=>6],['id' => $selectBag->seed_id, 'uniacid' => $this->uniacid]);
                pdo_update('cqkundian_farm_seed_bag',['status'=>1],['id'=>$selectBag->id,'uniacid'=>$this->uniacid]);
                self::$land->insertSeedStatus('种子配送下单成功啦~,请到店自提哦~',$seedData['lid'],$selectBag->seed_id,$this->uniacid);
            }
            echo json_encode(array('code'=>1,'order_id'=>$order_id));die;
        }else{
            echo json_encode(array('code'=>2));die;
        }
    }

    //配送订单回调成功后执行
    public function notifySeedSend(){
        global $_W,$_GPC;
        $order_id=$_GPC['order_id'];
        $prepay_id_str=$_GPC['prepay_id'];
        $orderData=pdo_get('cqkundian_farm_shop_order',array('id'=>$order_id,'uniacid'=>$this->uniacid));
        $selectBag=json_decode($_POST['selectBag']);
        if($orderData['status']==1) {
            //修改状态为待配送
            self::$land->updateSeedMine(['status'=>6],['id' => $selectBag->seed_id, 'uniacid' => $this->uniacid]);
            pdo_update('cqkundian_farm_seed_bag',['status'=>1],['id'=>$selectBag->id,'uniacid'=>$this->uniacid]);
            $seedData=self::$land->getSeedMine(['id'=>$selectBag->seed_id,'uniacid'=>$this->uniacid],false);
            self::$land->insertSeedStatus('种子配送下单成功啦~，请耐心等待发货~',$seedData['lid'],$selectBag->seed_id,$this->uniacid);
            $prepay_id = explode('=', $prepay_id_str);
            self::$common->insertFormIdData($prepay_id[1],$orderData['uid'],$_W['openid'],2,$this->uniacid);
            self::$notice->isPaySendNotice($orderData,$prepay_id[1],$_W['openid'],$this->uniacid);
            echo json_encode(array('code' => 1));
            die;
        }else{
            echo json_encode(array('code' => 2));
            die;
        }
    }


    //卖出种植
    public function saleSeed($get){
        global $_W;
        if(!empty($get['formid'])){
            self::$common->insertFormIdData($get['formid'],$this->uid,$_W['openid'],1,$this->uniacid);
        }
        $selectBag=json_decode($_POST['selectBag']);
        $weight=$get['weight'];
        if($weight > $selectBag->weight){
            echo json_encode(['code'=>-1,'msg'=>'填写重量超过'.$selectBag->weight.' kg']);die;
        }
        $requset=self::$land->saleSeed($selectBag,$weight);
        echo json_encode($requset);die;
    }
}

