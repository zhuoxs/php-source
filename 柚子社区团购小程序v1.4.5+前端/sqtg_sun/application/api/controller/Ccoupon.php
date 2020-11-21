<?php
namespace app\api\controller;
use app\base\controller\Api;
use app\model\Coupon;
use app\model\Usercoupon;
use think\Db;

class Ccoupon extends Api
{
    //获取优惠券列表
    public function getAvailableCoupons(){
         $user_id = input('request.user_id',0);
         $page = input('request.page',1);
         $limit = input('request.limit',6);

         //条件
         $query = function ($query){
             $time = time();

             $query->where('t1.state = 1');
             $query->where('t1.left_num > 0');
             $query->where('t2.id is null');
             $query->where("t1.begin_time <= $time and t1.end_time > $time");
         };

         $list = Coupon::where('t1.state = 1')->alias('t1')
             ->join('usercoupon t2','t2.coupon_id = t1.id and t2.user_id ='.$user_id,'left')
             ->where($query)
             ->field('t1.id,t1.name,t1.money,t1.use_money,date(FROM_UNIXTIME(t1.begin_time)) as begin_date,date(FROM_UNIXTIME(t1.end_time)) as end_date')
             ->page($page)
             ->limit($limit)
             ->select();

         success_json($list);
    }

     //获取我的优惠券列表
    public function getMyCoupons(){
        //条件
        $query = function ($query){
            $user_id = input('request.user_id');
            if ($user_id){
                $query->where('user_id',$user_id);
            }

            $state = input('request.state',1);
            switch ($state){
                case 1:
                    $query->where('end_time > '.time());
                    $query->where('state',1);
                    break;
                case 2:
                    $query->where('state',$state);
                    break;
                case 3:
                    $query->where('end_time <= '.time());
                    $query->where('state',1);
                    break;
            }
        };

        $usercoupon_model = new Usercoupon();
        $usercoupon_model->fill_order_limit();

        $list = $usercoupon_model->where($query)
            ->field('id,name,money,use_money,state,date(FROM_UNIXTIME(create_time)) as begin_date,date(FROM_UNIXTIME(end_time)) as end_date')
            ->select();



        success_json($list);
    }

    //领取优惠券
    public function receiveCoupon(){
        $user_id = input('request.user_id');
        $coupon_ids = input('request.coupon_ids');
        $coupon_ids = explode(',',$coupon_ids);
        $num = 0;

        foreach ($coupon_ids as $coupon_id) {
            $coupon = Coupon::get($coupon_id);
            if (!$coupon){
                continue;
            }

            $usercoupon = Usercoupon::get(['coupon_id'=>$coupon_id,'user_id'=>$user_id]);
            if (!!$usercoupon){
                continue;
            }

            $model = new Usercoupon();
            try{
                $ret = $model->allowField(true)->save([
                    'user_id' => $user_id,
                    'coupon_id' => $coupon_id,
                    'end_time' => min($coupon->getData('end_time'),time()+($coupon['days']*24*60*60)),
                    'state' => 1,
                    'name' => $coupon['name'],
                    'info' => $coupon['info'],
                    'money' => $coupon['money'],
                    'use_money' => $coupon['use_money'],
                ]);

                if ($ret){
                    $num++;
                }
            }catch (\Exception $e){
                echo json_encode($e);
                exit;
            }

        }

        if ($num){
            success_json("成功领取{$num}张优惠券");
        }else{
            error_json('优惠券已领完');
        }

    }

}
