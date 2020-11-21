<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/3/15 0015
 * Time: 上午 9:41
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/goods.php';
require_once ROOT_PATH.'model/user.php';
class Notify_KundianFarmModel{
    static $user='';
    public function __construct(){
        self::$user=new User_KundianFarmModel();
    }
    /** 积分商城运费支付 回调 */
    public function integralNotify($log){
        $order_id=$log['tid'];
        $update_save=[
            'status'=>1,      //已支付
            'pra_price'=>$log['fee'],
            'pay_method'=>'微信支付',
            'uniontid' => $log['uniontid'],
            'pay_time'=>time(),
        ];
        pdo_update('cqkundian_farm_integral_order',$update_save,['order_number'=>$order_id,'uniacid'=>$log['uniacid']]);
    }

    /** 种植摘取运费支付 */
    public function SeedSendNotify($log){
        $order_id=$log['tid'];
        //更新订单支付状态
        $update_save=[
            'status'=>1,
            'pra_price'=>$log['fee'],
            'pay_time'=>time(),
            'pay_method'=>'微信支付',
            'uniontid' => $log['uniontid'],
        ];
        $res=pdo_update('cqkundian_farm_shop_order',$update_save,['order_number'=>$order_id,'uniacid'=>$log['uniacid']]);
    }

    /** 组团商成支付 */
    public function groupNotify($log){
        load()->func('logging');
        logging_run('组团测试支付');
        require_once ROOT_PATH.'inc/wxapp/group.inc.php';
        $group=new GroupController();
        $group->groupPay($log['tid'],$log);
    }

    /** 购买种子支付 */
    public function buySeedNotify($log){
        require_once ROOT_PATH.'inc/wxapp/land.inc.php';
        $land=new LandController();
        $res = $land->seedNotify($log['tid'],$log);
    }

    /** 购买土地 */
    public function buyLandNotify($log){
        require_once ROOT_PATH.'inc/wxapp/land.inc.php';
        logging_run('土地租赁支付');
        $land=new LandController();
        $res = $land->landNotify($log['tid'],$log);
    }
    public function buySoilNotify($log){
        require_once ROOT_PATH.'inc/wxapp/soil.inc.php';
        logging_run('土地租赁支付');
        $soil=new SoilController();
        $res = $soil->soilNotify($log['tid'],$log);
    }

    /** 商城支付*/
    public function shopNotify($log){
        require_once ROOT_PATH.'inc/wxapp/shop.inc.php';
        $shop=new ShopController();
        $shop->shopNotify($log['tid'],$log);
    }

    /** 认养*/
    public function buyAnimalNotify($log){
        require_once ROOT_PATH.'inc/wxapp/animal.inc.php';
        $animal=new AnimalController();
        $animal->animalNotify($log['tid'],$log);
    }

    /** 土地施肥、浇水、除草、杀虫 */
    public function operationNotify($log){
        $update_save=[
            'is_pay'=>1,
            'pra_price'=>$log['fee'],
            'pay_time'=>time(),
            'uniontid'=>$log['uniontid'],
        ];
        return pdo_update('cqkundian_farm_plugin_play_land_opeartion',$update_save,['order_number'=>$log['tid'],'uniacid'=>$log['uniacid']]);
    }

    /** 多商户收费入驻 */
    public function storeApplyNotify($log){
        $set=pdo_get('cqkundian_farm_set',['uniacid'=>$log['uniacid'],'ikey'=>'is_check_store']);
        $update_save=[
            'is_pay'=>1,
            'pay_time'=>time(),
            'status'=>$set['value']==1 ? 1 : 0,
            'uniontid'=>$log['uniontid'],
        ];
        return pdo_update('kd_farm_store',$update_save,['order_number'=>$log['tid'],'uniacid'=>$log['uniacid']]);
    }

}