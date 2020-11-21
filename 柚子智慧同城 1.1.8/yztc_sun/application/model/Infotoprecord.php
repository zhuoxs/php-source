<?php
namespace app\model;
use think\Loader;

class Infotoprecord extends Base
{
    //0元支付
    public function zeroPay($infotoprecord_id){
        $order=$this->find($infotoprecord_id);
        $this->allowField(true)->save(['pay_status'=>1,'pay_time'=>time(),'order_status'=>1],['id'=>$infotoprecord_id]);
        $info=Info::get($order['info_id']);
        $topping_time=$this->get_topping_time($info['topping_time'],$order['day_num']);
        $sort_id=$this->get_sort_id();
        $infoModel=new Info();
        if($order['need_status']==0){
            //不需要审核时 使用置顶功能增加置顶时间
            $this->allowField(true)->save(['use_status'=>1,'check_status'=>2,'order_status'=>2,'check_time'=>time()],['id'=>$order['id']]);
            //修改帖子审核、置顶状态
            $infoModel->allowField(true)->save(['check_status'=>2,'check_time'=>time(),'pay_status'=>1,'topping_time'=>$topping_time,'sort_id'=>$sort_id],['id'=>$order['info_id']]);
        }else{
            //修改帖子支付状态
            $infoModel->allowField(true)->save(['pay_status'=>1],['id'=>$order['info_id']]);
            //当后台审核通过后支付情况
            if($info['check_status']==2){
                $this->allowField(true)->save(['use_status'=>1,'order_status'=>2],['id'=>$order['id']]);
                $infoModel->allowField(true)->save(['check_status'=>2,'check_time'=>time(),'topping_time'=>$topping_time,'sort_id'=>$sort_id],['id'=>$order['info_id']]);
            }
        }

    }
    //置顶支付回调
    public function payNotify($data){
        global $_W;
        $attach=json_decode($data['attach'],1);
        $_W['uniacid']=$attach['uniacid'];
        $order=$this->where(['order_no'=>$data['out_trade_no']])->find();
        if(!$order||$order['pay_status']==1){
            echo 'FAIL';
            exit;
        }
        //对订单进行操作
        //修改订单状态
        $this->allowField(true)->save(['pay_status'=>1,'pay_time'=>time(),'order_status'=>1,'transaction_id'=>$data['transaction_id'],'out_trade_no'=>$data['out_trade_no']],['id'=>$order['id']]);
        //获取帖子状态
        $info=Info::get($order['info_id']);
        $infoModel=new Info();
        if($info['posting_fee']>0){
            $infoModel->allowField(true)->save(['is_show'=>1,'pay_status_posting'=>1],['id'=>$order['info_id']]);
        }
        if($info['top_id']>0){
            $topping_time=$this->get_topping_time($info['topping_time'],$order['day_num']);
            $sort_id=$this->get_sort_id();
            if($order['need_status']==0){
                //不需要审核时 使用置顶功能增加置顶时间
                $this->allowField(true)->save(['use_status'=>1,'check_status'=>2,'order_status'=>2,'check_time'=>time()],['id'=>$order['id']]);
                //修改帖子审核、置顶状态
                $infoModel->allowField(true)->save(['check_status'=>2,'check_time'=>time(),'pay_status'=>1,'topping_time'=>$topping_time,'sort_id'=>$sort_id],['id'=>$order['info_id']]);
            }else{
                //修改帖子支付状态
                $infoModel->allowField(true)->save(['pay_status'=>1],['id'=>$order['info_id']]);
                //当后台审核通过后支付情况
                if($info['check_status']==2){
                    $this->allowField(true)->save(['use_status'=>1,'order_status'=>2],['id'=>$order['id']]);
                    $infoModel->allowField(true)->save(['check_status'=>2,'check_time'=>time(),'topping_time'=>$topping_time,'sort_id'=>$sort_id],['id'=>$order['info_id']]);
                }
            }
        }



    }
    /**获取置顶结束时间
     * @param $topping_time 原来帖子置顶时间
     * @param $day_num      订单置顶天数
     * @return float|int|mixed
     */
    public function get_topping_time($topping_time,$day_num){
        if($day_num==0){
            return false;
        }
        $end_time = max(time(),intval($topping_time)?:0);
        $end_time += $day_num*24*60*60;
        return $end_time;
    }
    //获取置顶排序sort_id
    public function get_sort_id(){
        $infosort=Infosort::get(['type'=>1]);
        if(!$infosort){
            (new Infosort())->allowField(true)->save(['type'=>1,'sort'=>1]);
            return 1;
        }else{
            (new Infosort())->allowField(true)->save(['sort'=>intval($infosort['sort'])+1],['id'=>$infosort['id']]);
            return intval($infosort['sort'])+1;
        }
    }



}
