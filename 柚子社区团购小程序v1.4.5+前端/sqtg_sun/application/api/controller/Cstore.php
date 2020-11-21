<?php
namespace app\api\controller;

use app\model\Accessrecord;
use app\model\Config;
use app\model\Mercapdetails;
use app\model\Pingoods;
use app\model\Store;
use app\model\Order;
use app\base\controller\Api;
use app\model\Withdrawset;
use app\model\Ad;
use app\model\Pinorder;

class Cstore extends Api
{
//    商户入驻申请
    public function applyStore(){
        $data = input('request.');
        $data['check_state'] = 1;
        $data['fail_reason'] = '';

        $id = input('request.id');
        $store_model = $id?Store::get($id):new Store();

        $store_model->allowField(true)->save($data);
        success_json($store_model);
    }
//    获取我的商家
    public function getMyStore(){
        $user_id = input('request.user_id');
        $store = Store::get(['user_id'=>$user_id]);

        if ($store){
            $time1 = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
            $time2 = strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
            $store['today_sum'] = Mercapdetails::where('store_id',$store['id'])
                ->where('create_time',['>=',$time1])->where('mcd_type',1)
                ->sum('money');
            $query = function($query)use($time1,$time2){
                $query->where('create_time','>=',$time2)->where('create_time','<',$time1)->where('mcd_type',1);
            };
            $store['yesterday_sum'] = Mercapdetails::where('store_id',$store['id'])
                ->where($query)
                ->sum('money');
            $store['total_sum'] = Mercapdetails::where('store_id',$store['id'])->where('mcd_type',1)
//                ->where('create_time',['>=',$time1])
                ->sum('money');
            $wd_set = Withdrawset::get_curr();
            $store['withdraw_switch'] = $wd_set?($wd_set['is_open']?:0):0;
        }

        $detail = Config::get_value('mstore_apply_detail');
        $bgm = Config::get_value('mstore_apply_bgm');
//        轮播图
        $swipers = Ad::where('state',1)
            ->where('type',3)->order('index')
            ->select();

        success_withimg_json($store,['apply_detail'=>$detail,'apply_bgm'=>$bgm,'swipers'=>$swipers]);
    }
    //    获取商户详情
    public function getStore(){
        $id=input('request.id');
        $data = Store::get($id);
        success_withimg_json($data);
    }
//    获取商户报表
    public function getStoreReport(){
        $ret = [];
        $store_id = input('request.store_id');
        $store_data = Store::get($store_id);
        if (!$store_id){
            $store_data = [
                'id'=>$store_id,
                'name'=>'平台',
            ];
        }
        $ret['storeinfo'] = $store_data;

        $begin_today = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
        $begin_yesterday=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳

        $order_model = new Order();
        $accessrecord_model = new Accessrecord();

//        今日订单
        $todayOrderCount = $order_model->where('store_id',$store_id)
            ->where('order_status',3)
            ->where('pay_time',['>=',$begin_today])
            ->count();
        $todayOrderCount2 = Pinorder::where('store_id',$store_id)
            ->where('order_status',5)
            ->where('pay_time',['>=',$begin_today])
            ->count();

//        今日收入
        $todayAmountSum = $order_model->where('store_id',$store_id)
            ->where('order_status',3)
            ->where('pay_time',['>=',$begin_today])
            ->sum('goods_total_price');
        $todayAmountSum2= Pinorder::where('store_id',$store_id)
            ->where('order_status',5)
            ->where('pay_time',['>=',$begin_today])
            ->sum('order_amount');

//        昨日收入
        $yesterdayAmountSum = $order_model->where('store_id',$store_id)
            ->where('order_status',3)
            ->where('pay_time',[['>=',$begin_yesterday],['<',$begin_today]])
            ->sum('goods_total_price');
        $yesterdayAmountSum2 = Pinorder::where('store_id',$store_id)
            ->where('order_status',5)
            ->where('pay_time',[['>=',$begin_yesterday],['<',$begin_today]])
            ->sum('order_amount');
//        累计收入
        $amountSum = $order_model->where('store_id',$store_id)
            ->where('order_status',3)
            ->sum('goods_total_price');
        $amountSum2 = Pinorder::where('store_id',$store_id)
            ->where('order_status',5)
            ->sum('order_amount');

//        今日访问量
        $todayAccessCount = $accessrecord_model->where('store_id',$store_id)
            ->where('create_time',['>=',$begin_today])
            ->count();

        $ret['report'] = [
            'todayOrderCount'=>$todayOrderCount+$todayOrderCount2,
            'todayAmountSum'=>$todayAmountSum+$todayAmountSum2,
            'todayAccessCount'=>$todayAccessCount,
            'yesterdayAmountSum'=>$yesterdayAmountSum+$yesterdayAmountSum2,
            'amountSum'=>$amountSum,
            'money'=>$store_data['money'],
        ];

        success_withimg_json($ret);
    }
//    获取商户订单
    public function getStoreOrders(){
        //条件
        $query = function ($query){
            $query->where('store_id',input('request.store_id'));
            $state = input("request.state");
            if ($state){
                $query->where('order_status',$state)
                    ->where('pay_status',1);
            }
        };

//        查询数据
        $order_model = new Order();
        $order_model->fill_order_limit();//分页，排序
        $list = $order_model->where($query)->with('orderdetails')->order('create_time','desc')->select();
        $count = $order_model->where($query)->count();

        success_withimg_json($list,['count'=>$count]);
    }

    public function details(Mercapdetails $mercapdetails){
        $store_id = input("request.store_id");

        $type = input('request.type');
        $query=function($query)use($type){
            $store_id =input('request.store_id');
            $query->where('store_id',$store_id);

            $query->where('type',$type);
        };
        $with= [
            1=>['ordergoods','order'],
            2=>['pinorder','goods']
        ];
        $mercapdetails->fill_order_limit();
        $list = $mercapdetails->with($with[$type])->where($query)->order('create_time','desc')->select();
        success_json($list,['count'=>$mercapdetails->where($query)->count()]);
    }
}
