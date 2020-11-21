<?php

namespace app\model;
use think\Db;


class Store extends Base
{
    public $unique = array('name');//唯一分组
    //统计商户量
    public function getStoreNum(){
        $data=$this->count();
        return $data;
    }

    public function hotgoodses()
    {
        return $this->hasMany('Goods','store_id','id')
            ->where('state',1)
            ->where('stock',['>',0])
            ->where('is_recommend',1)
            ->where('check_status',2)
            ->field('id,name,pic,price,store_id')
            ->order('update_time','desc')
            ->limit(6);
    }
    public function getEndTimeAttr($value)
    {
        if (!$value){
            return '';
        }
        return date('Y-m-d H:i:s',$value);
    }
    public function setEndTimeAttr($value)
    {
        if (is_int($value)){
            return $value;
        }
        return strtotime($value);
    }
   public function check_version(){
       $config=getSystemConfig()['system'];
       if(StrCode($config['version'],'DECODE')!='advanced'){
           if(StrCode($config['version'],'DECODE')=='free'){
                $this->check_store_num(intval(StrCode($config['store_num'],'DECODE')));
           }else{
               throw new \ZhyException(getErrorConfig('genuine'));
           }
       }
   }

    /**核销完成对商家进行相关操作
     * @param $store_id  商户id
     * @param $money     核销的金额
     * @param $type      1普通商品 2抢购商品 3优惠券
     * @param $order_id  订单id
     * @param $order_no  订单号
     * @param $user_id   订单下单用户
     * @param $num       要核销商品数量
    */
    public function setConfirmAfter($store_id,$money,$type,$order_id,$order_no,$user_id,$num){
        if($money>0) {
            //增加用户累计消费金额
            if($money>0){
                (new User())->where(['id'=>$user_id])->setInc('total_consume',$money);
                //消费金额成为分销商
                (new Distributionpromoter())->setDistributionpromoter(3,$user_id);
            }
            //增加商户余额
            (new Store())->where(['id' => $store_id])->setInc('balance', $money);
            $store = Store::get($store_id);
            if (!$store) {
                error_json('商家不存在');
            }
            //增加商家记录
            $detail = '';
            if ($type == 1) {
                $order=Order::get($order_id);
                if($order['order_lid']==2){
                    $detail .= '预约';
                }else{
                    $detail .= '普通';
                }
            }else if($type == 2) {
                $detail .= '抢购';
            }else if($type==3){
                $detail.='优惠券';
            }else if($type==4){
                $detail.='拼团';
            }
            $detail .= '订单完成-订单id:' . $order_id . ' 订单号:' . $order_no;
            $mercapdetails = [
                'store_id' => $store_id,
                'store_name' => $store['name'],
                'type' => $type,
                'mcd_type' => 1,
                'user_id' => $user_id,
                'sign' => 1,
                'mcd_memo' => $detail,
                'money' => $money,
                'order_id' => $order_id,
                'add_time' => time(),
                'now_money' => $store['balance'],
            ];
            (new Mercapdetails())->allowField(true)->save($mercapdetails);
            //增加商家总销量
            (new Store())->where(['id' => $store_id])->setInc('sale_count', $num);
        }
    }
    //获取数量
    private function check_store_num($num){
        $total_store_num=Db::name('store')->count();
        if($num>0&&$num<=100){
            if($total_store_num>=$num){
                throw new \ZhyException(getErrorConfig('store_num'));
            }
        }else if($num>100){

        }else{
            throw new \ZhyException(getErrorConfig('genuine'));
        }
    }
    //获取商户管理中心统计后台
    public function getStatistics($store_id){
        $today=date("Y-m-d");
        $yesterday=date("Y-m-d",strtotime("-1 day"));
        $month=date('Y-m');
        $today_time=strtotime($today);
        $yesterday_time=strtotime($yesterday);
        $month_time=strtotime($month);
        $order=new Order();
        //普通订单
        //今日订单量
        $today_num_common=$order->where(['create_time'=>['egt',$today_time],'store_id'=>$store_id])->count();
        //昨日订单量
        $yesterday_num_common=$order->where(['create_time'=>[['egt',$yesterday_time],['lt',$today_time]],'store_id'=>$store_id])->count();
        //本月订单量
        $month_num_common=$order->where(['create_time'=>['egt',$month_time],'store_id'=>$store_id])->count();
        //总订单量
        $total_num_common=$order->where(['store_id'=>$store_id])->count();
        //今日核销量
        $today_num_confirm=$order->where(['write_off_time'=>['egt',$today_time],'store_id'=>$store_id])->count();
        //昨日核销量
        $yesterday_num_confirm=$order->where(['write_off_time'=>[['egt',$yesterday_time],['lt',$today_time]],'store_id'=>$store_id])->count();

        //抢购订单
        $panicorder=new Panicorder();
        //今日订单量
        $today_num_panic=$panicorder->where(['create_time'=>['egt',$today_time],'store_id'=>$store_id])->count();
        //昨日订单量
        $yesterday_num_panic=$panicorder->where(['create_time'=>[['egt',$yesterday_time],['lt',$today_time]],'store_id'=>$store_id])->count();
        //本月订单量
        $month_num_panic=$panicorder->where(['create_time'=>['egt',$month_time],'store_id'=>$store_id])->count();
        //总订单量
        $total_num_panic=$panicorder->where(['store_id'=>$store_id])->count();
        //今日核销量
        $today_num_confirm_panic=$panicorder->where(['write_off_time'=>['egt',$today_time],'store_id'=>$store_id])->count();
        //昨日核销量
        $yesterday_num_confirm_panic=$panicorder->where(['write_off_time'=>[['egt',$yesterday_time],['lt',$today_time]],'store_id'=>$store_id])->count();

        //拼团订单
        $pinorder=new Pinorder();
        //今日订单量
        $today_num_pin=$pinorder->where(['create_time'=>['egt',$today_time],'store_id'=>$store_id])->count();
        //昨日订单量
        $yesterday_num_pin=$pinorder->where(['create_time'=>[['egt',$yesterday_time],['lt',$today_time]],'store_id'=>$store_id])->count();
        //本月订单量
        $month_num_pin=$pinorder->where(['create_time'=>['egt',$month_time],'store_id'=>$store_id])->count();
        //总订单量
        $total_num_pin=$pinorder->where(['store_id'=>$store_id])->count();
        //今日核销量
        $today_num_confirm_pin=$pinorder->where(['write_off_time'=>['egt',$today_time],'store_id'=>$store_id])->count();
        //昨日核销量
        $yesterday_num_confirm_pin=$pinorder->where(['write_off_time'=>[['egt',$yesterday_time],['lt',$today_time]],'store_id'=>$store_id])->count();



        //优惠券订单
        $couponget=new Couponget();
        //今日订单量
        $today_num_couponget=$couponget->where(['create_time'=>['egt',$today_time],'store_id'=>$store_id])->count();
        //昨日订单量
        $yesterday_num_couponget=$couponget->where(['create_time'=>[['egt',$yesterday_time],['lt',$today_time]],'store_id'=>$store_id])->count();
        //本月订单量
        $month_num_couponget=$couponget->where(['create_time'=>['egt',$month_time],'store_id'=>$store_id])->count();
        //总订单量
        $total_num_couponget=$couponget->where(['store_id'=>$store_id])->count();
        //今日核销量
        $today_num_confirm_couponget=$couponget->where(['write_off_time'=>['egt',$today_time],'store_id'=>$store_id])->count();
        //昨日核销量
        $yesterday_num_confirm_couponget=$couponget->where(['write_off_time'=>[['egt',$yesterday_time],['lt',$today_time]],'store_id'=>$store_id])->count();

        $data=array(
            'today_num'=>$today_num_common+$today_num_panic+$today_num_couponget+$today_num_pin,
            'yesterday_num'=>$yesterday_num_common+$yesterday_num_panic+$yesterday_num_couponget+$yesterday_num_pin,
            'month_num'=>$month_num_common+$month_num_panic+$month_num_couponget+$month_num_pin,
            'total_num'=>$total_num_common+$total_num_panic+$total_num_couponget+$total_num_pin,
            'today_confirm'=>$today_num_confirm+$today_num_confirm_panic+$today_num_confirm_couponget+$today_num_confirm_pin,
            'yesterday_confirm'=>$yesterday_num_confirm+$yesterday_num_confirm_panic+$yesterday_num_confirm_couponget+$yesterday_num_confirm_pin,
        );
        return $data;
    }




}
