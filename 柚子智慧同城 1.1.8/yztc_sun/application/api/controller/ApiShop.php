<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 14:35
 */

namespace app\api\controller;

use app\model\Ordercar;
use app\model\Orderchartered;
use app\model\Shop;
use app\model\Shopbalance;

class ApiShop extends Api
{
    //TODO::入驻须知
    public function enterRule()
    {
        $info['enter_rule'] = \app\model\Config::get_value('enter_rule');
        $user_id=input('post.user_id');
        $shop=new Shop();
        $info['shopinfo']=$shop->mfind(['user_id'=>$user_id,'is_del'=>0]);
        success_withimg_json($info);
    }

    //TODO::商户入驻
    public function shopEnter()
    {
        $data['user_id'] = input('post.user_id');
        $shop = new Shop();
        $isenter = $shop->mfind(['user_id' => $data['user_id'], 'is_del' => 0]);
        if ($isenter&&($isenter['check_status']<3)) {
            return_json('您已入驻过了', -1);
        } else {
            $data['name'] = input('post.name');
            $data['tel'] = input('post.tel');
            $data['address'] = input('post.address');
            $data['lng'] = input('post.lng');
            $data['lat'] = input('post.lat');
            $data['check_status'] = 1;
            $data['fail_reason'] = '';
            $data['pic'] = input('post.pic');
            $img=input('post.pics');
            if($img){
                $imgs=explode(',',$img);
                $data['pics']=  json_encode($imgs);
            }
            $data['night_fee'] = input('post.night_fee');
            $data['fee'] = input('post.fee');
            $data['close_is_send'] = input('post.close_is_send');
            $data['range'] = input('post.range');
            $data['business_range'] = input('post.business_range');
            if (input('post.id')>0){
                $data['id'] = input('post.id');
                $shop = $shop->get($data['id']);
            }
            $res=$shop->allowField(true)->save($data);
            if($res){
                return_json();
            }else{
                return_json('入驻失败，请稍后重试',-1);
            }
        }
    }
    //TODO::财务管理
    public function shopFinance(){
        $sid=input('post.sid');
        //租车订单统计
        $car=new Ordercar();
        $cardata['all']=$car->where(['sid'=>$sid])->field('id')->count();
        $cardata['status1']=$car->where(['sid'=>$sid,'order_status'=>1])->field('id')->count();
        $cardata['status2']=$car->where(['sid'=>$sid,'order_status'=>2])->field('id')->count();
        $cardata['status3']=$car->where(['sid'=>$sid,'order_status'=>3])->field('id')->count();
        $cardata['status4']=$car->where(['sid'=>$sid,'order_status'=>4])->field('id')->count();
        $cardata['status5']=$car->where(['sid'=>$sid,'order_status'=>5])->field('id')->count();
        $cardata['status6']=$car->where(['sid'=>$sid,'order_status'=>6])->field('id')->count();
        //包车订单统计
        $chartered=new Orderchartered();
        $chartereddata['all']=$chartered->where(['sid'=>$sid])->field('id')->count();
        $chartereddata['status1']=$chartered->where(['sid'=>$sid,'order_status'=>1])->field('id')->count();
        $chartereddata['status2']=$chartered->where(['sid'=>$sid,'order_status'=>2])->field('id')->count();
        $chartereddata['status3']=$chartered->where(['sid'=>$sid,'order_status'=>3])->field('id')->count();
        $chartereddata['status4']=$chartered->where(['sid'=>$sid,'order_status'=>4])->field('id')->count();
        //财务统计
        $day = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
//        $time1=strtotime(date("Y-m-d",strtotime("+1 day")));//获取明天凌晨的时间戳
        $time2=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
        $time3=strtotime(date("Y-m"));//当月
//        $time4=strtotime(date("Y-m-d",strtotime("-7 day")));//获取7天前凌晨的时间戳
//        $time5=strtotime(date("Y-m-d",strtotime("-30 day")));//获取30天前凌晨的时间戳
        $time6=strtotime(date('Y-m-d', strtotime(date('Y-m-01') . ' -1 month'))) ; // 上月第一天
        $time7= strtotime(date('Y-m-d', strtotime(date('Y-m-01') . ' -1 day'))); // 上月最后一天
        $income[]='';
        $where['type']=['gt',1];
        $shopbalance=new Shopbalance();
        $today['create_time']=['gt',$day];//今天
        $income['today']=sprintf("%.2f",$shopbalance->where($where)->where($today)->sum('money'));
        $yes['create_time']=[['egt',$time2],['lt',$day]];//昨天
        $income['yesterday']=sprintf("%.2f",$shopbalance->where($where)->where($yes)->sum('money'));
        $month['create_time']=['gt',$time3];//本月
        $income['month']=sprintf("%.2f",$shopbalance->where($where)->where($month)->sum('money'));
        $yesm['create_time']=[['egt',$time6],['lt',$time7]];//上月
        $income['lastmonth']=sprintf("%.2f",$shopbalance->where($where)->where($yesm)->sum('money'));

        $data['cardate']=$cardata;
        $data['chartereddata']=$chartereddata;
        $data['income']=$income;
        success_withimg_json($data);
    }

}
