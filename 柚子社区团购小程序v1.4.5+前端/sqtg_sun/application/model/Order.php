<?php

namespace app\model;

use think\Db;
use app\base\model\Base;
use think\Hook;
use think\Loader;
use app\model\Delivery;

class Order extends Base
{
    public $order = 'update_time desc';//默认排序
    protected static function init()
    {
        parent::init();

        self::beforeInsert(function ($model){
            $model->order_no = date("YmdHis") .rand(11111, 99999);

            Hook::listen('on_order_add',$model);
        });
        self::beforeUpdate(function ($model){
            $old_info = self::get($model->id);
//            支付
            /*if ($old_info['state'] == 1 && $model['state'] == 2 && $model['pay_state'] == 1){
                Hook::listen('on_order_pay',$model);
                self::afterPay($model);
//            订单完成
            }else*/ if ($old_info['state'] == 4 && $model['state'] == 5){
                Hook::listen('on_order_finish',$model);
//            订单取消
            }else if ($old_info['state'] == 1 && $model['state'] == 6){
                Hook::listen('on_order_cancel',$model);
            }
        });

//        self::afterUpdate(function($model){
//            $pay=false;
//            Hook::listen('on_order_pay_done',$model);
//        });
    }
    static public function afterPay($model){
        Hook::listen('on_order_pay_done',$model);
    }
    public function getOrderRecordNum($user_id){
           global $_W;
           $data=Db::name('order')->field('user_id,order_status,count(id) as record_num')->where(array('uniacid'=>$_W['uniacid'],'user_id'=>$user_id))->group('order_status')->select();
           foreach($data as $val){
               if($val['order_status']==0){
                   $dfk=$val['record_num'];
               }else  if($val['order_status']==1){
                   $dfh=$val['record_num'];
               }else  if($val['order_status']==3){
                   $ywc=$val['record_num'];
               }else  if($val['order_status']==5){
                   $tk=$val['record_num'];
               }
           }
           $dfk=$dfk?$dfk:0;
           $dfh=$dfh?$dfh:0;
           $ywc=$ywc?$ywc:0;
           $tk=$tk?$tk:0;
           return array(
                 'dfk'=>$dfk,
                 'dfh'=>$dfh,
                 'ywc'=>$ywc,
                 'tk'=>$tk
            );
     }
    public function onOrderPay($model){
        $store_ids = Ordergoods::where('order_id',$model->id)
            ->distinct('store_id')
            ->field('store_id')
            ->select();
        foreach ($store_ids as $store_id) {
            $content=$this->getOrderPrintContent($model->id,$store_id->store_id);
            $this->prints($store_id->store_id,2,$content);
        }
    }
    public function adminPrint($order_ids){
        foreach ($order_ids as $order_id) {
            $content=$this->getOrderPrintContent($order_id,$_SESSION['admin']['store_id']);
            $this->prints($_SESSION['admin']['store_id'],2,$content);
        }
    }
    public function ordergoodses()
    {
        return $this->hasMany('Ordergoods','order_id','id');
    }
    public function leader(){
        return $this->hasOne('Leader','id','leader_id')->bind([
            'leader_name'=>'name',
            'leader_community'=>'community',
            'leader_address'=>'address',
            'leader_user_id'=>'user_id',
            'leader_tel'=>'tel',
            'leader_longitude'=>'longitude',
            'leader_latitude'=>'latitude',
        ]);
    }
//    新增订单：新增、生成分佣记录
    public static function insertDb($data){
        Db::name('order')->insert($data);
        $id = Db::name('order')->getLastInsID();

//        //            计算佣金
        $distribution_amount = 0;
        $distribution_level = Config::get_value('distribution_level',0);//佣金层级
        if ($distribution_level){
//              一级id
            $user_id1 = $data['user_id'];
            if (!User::isDistribution($user_id1) || !Config::get_value('distribution_self',0)){
                $user_id1 = User::get($user_id1)['share_user_id'];
            }
            if ($user_id1){
//                    计算一级分佣
                $distribution_rate_level1 = Config::get_value('distribution_rate_level1',0);
                $distribution_amount1 = round($data['goods_total_price'] * $distribution_rate_level1/100,2);
                $distribution_amount += $distribution_amount1;
                if ($distribution_amount1){
                    Orderdistribution::insertDb([
                        'uniacid'=>$data['uniacid'],
                        'order_id'=>$id,
                        'user_id'=>$user_id1,
                        'rate'=>$distribution_rate_level1,
                        'amount'=>$data['goods_total_price'],
                        'money'=>$distribution_amount1,
                    ]);
                }
                if ($distribution_level >= 2){
//                        二级
                    $user_id2 = User::get($user_id1)['share_user_id'];
                    if ($user_id2 && User::isDistribution($user_id2)){
                        $distribution_rate_level2 = Config::get_value('distribution_rate_level2',0);
                        $distribution_amount2 = round($data['goods_total_price'] * $distribution_rate_level2 /100,2);
                        $distribution_amount += $distribution_amount2;
                        if ($distribution_amount2) {
                            Orderdistribution::insertDb([
                                'uniacid'=>$data['uniacid'],
                                'order_id'=>$id,
                                'user_id'=>$user_id2,
                                'rate'=>$distribution_rate_level2,
                                'amount'=>$data['goods_total_price'],
                                'money'=>$distribution_amount2,
                            ]);
                        }
                        if ($distribution_level >= 3) {
                            //三级
                            $user_id3 = User::get($user_id2)['share_user_id'];
                            if ($user_id3 && User::isDistribution($user_id3)) {
                                $distribution_rate_level3 = Config::get_value('distribution_rate_level3', 0);
                                $distribution_amount3 = round($data['goods_total_price'] * $distribution_rate_level3 /100 ,2);
                                $distribution_amount += $distribution_amount3;
                                if ($distribution_amount3) {
                                    Orderdistribution::insertDb([
                                        'uniacid'=>$data['uniacid'],
                                        'order_id'=>$id,
                                        'user_id'=>$user_id3,
                                        'rate'=>$distribution_rate_level3,
                                        'amount'=>$data['goods_total_price'],
                                        'money'=>$distribution_amount3,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
        Db::name('order')->update(['id'=>$id,'distribution_money'=>$distribution_amount]);
        return $id;
    }

    public function orderdistributions()
    {
        return $this->hasMany('Orderdistribution');
    }
    /**
     * @param $store_id  商家id
     * @param $order_amount 实际支付金额
     * @param $type         1普通商品 2拼团 3秒杀
     * @param $user_id      用户id
     * @param $order_id     订单id
     * @param $order_num    订单号
     * @param $num          商品总数量
     */
    //确认收货增加商户余额
    public function confirmAddStoreMoney($store_id,$order_amount,$type,$user_id,$order_id,$order_num,$num){
        global $_W;
        if($store_id>0){
            Db::name('store')->where(array('id'=>$store_id))->setInc('money',$order_amount);
            $store=Db::name('store')->find($store_id);
            //增加商家记录
            $type_arr=array('','普通商品','拼团','秒杀');
            $detail=$type_arr[$type].'订单完成-订单id:'.$order_id.' 订单号:'.$order_num;
            $mercapdetails=array(
                'uniacid'=>$_W['uniacid'],
                'store_id'=>$store_id,
                'store_name'=>$store['name'],
                'mcd_type'=>1,
                'user_id'=>$user_id,
                'sign'=>1,
                'mcd_memo'=>$detail,
                'money'=>$order_amount,
                'order_id'=>$order_id,
                'add_time'=>time(),
                'now_money'=>$store['money'],
            );
            Db::name('mercapdetails')->insert($mercapdetails);
            //增加商家总销量
            Db::name('store')->where(array('id'=>$store_id))->setInc('sale_count',$num);
        }
    }

    public function goodses()
    {
        return $this->hasMany('Ordergoods');
    }
    public function cancel($id){
        $order = Order::get($id);
        $order->state = 6;
        $ret = $order->save();
        return $ret;
    }
    public function userdelete($id){
        $order = Order::get($id);
        $order->is_delete = 1;
        $ret = $order->save();
        return $ret;
    }

    public function onPaycallback($payrecord){
        $this->pay($payrecord['source_id']);
    }

    public function pay($id){
        $order = Order::get($id);
        $order->state = 2;
        $order->pay_state = 1;
        $order->pay_time = time();
        $ret = $order->save();
        
        //将原本的钩子替换成顺序调用 allen 201904
//             'on_order_pay'=>[//支付
//         'app\model\User',
//         'app\model\Goods',
//         'app\model\Ordergoods',
// //        'app\model\Dingtalk',
// //        'app\model\Sms',
//         'app\model\Task',
//         'app\model\Order',
//     ]
        $onOrderPay=[];
        array_push($onOrderPay, new User());
        array_push($onOrderPay, new Goods());
        array_push($onOrderPay, new Ordergoods());
        array_push($onOrderPay, new Dingtalk());
        array_push($onOrderPay, new Sms());
        array_push($onOrderPay, new Task());
        array_push($onOrderPay, new Order());
        foreach($onOrderPay as $pay ){
            $pay->onOrderPay($order);
        }

        return $ret;
    }
    //    订单完成：确认收货、自提单核销
    public function confirm($id){
        $order = Order::get($id);
        $order->state = 5;
        $ret = $order->save();
        return $ret;
    }

    public function onOrdergoodsSend($ordergoods){
        $min_state = Ordergoods::where('order_id',$ordergoods->order_id)
            ->min('state');
        if($min_state == 2){
            $count = Ordergoods::where('order_id',$ordergoods->order_id)
                ->where('state',2)
                ->count();
            if ($count == 1){
                $order = Order::get($ordergoods->order_id);
                $order->state = 3;
                $order->save();
            }
        }
    }
    public function onOrdergoodsReceive($ordergoods){
        $min_state = Ordergoods::where('order_id',$ordergoods->order_id)
            ->min('state');
        if($min_state == 3){
            $count = Ordergoods::where('order_id',$ordergoods->order_id)
                ->where('state',3)
                ->count();
            if ($count == 1){
                $order = Order::get($ordergoods->order_id);
                $order->state = 4;
                $order->save();
            }
        }

    }
    public function onOrdergoodsReceive2($ordergoods){
        $min_state = Ordergoods::where('order_id',$ordergoods->order_id)
            ->min('state');
        if($min_state == 3){
            $count = Ordergoods::where('order_id',$ordergoods->order_id)
                ->where('state',3)
                ->count();
            if ($count == 1){
                $count2 = Ordergoods::where('order_id',$ordergoods->order_id)
                    ->where('state',4)
                    ->count();
                $order = Order::get($ordergoods->order_id);
                $order->state = $count2 ? 4 : 5;
                $order->save();
            }
        }

    }
    public function onOrdergoodsConfirm($ordergoods){
        $min_state = Ordergoods::where('order_id',$ordergoods->order_id)
            ->min('state');
        if($min_state == 4){
            $count = Ordergoods::where('order_id',$ordergoods->order_id)
                ->where('state',4)
                ->count();
            if ($count == 1){
                $order = Order::get($ordergoods->order_id);
                $order->state = 5;
                $order->save();
            }
        }
    }
    public function onOrdergoodsRefund($ordergoods){
        $old = Ordergoods::get($ordergoods['id']);

        $min_state = Ordergoods::where('order_id',$ordergoods->order_id)
            ->min('state');
        if($min_state == $old['state']){
            $count = Ordergoods::where('order_id',$ordergoods->order_id)
                ->where('state',$min_state)
                ->count();
            if ($count == 1){
                $min_state = Ordergoods::where('order_id',$ordergoods->order_id)
                    ->where('id',['<>',$ordergoods['id']])
                    ->min('state');
                $min_state = min($min_state,6);
                $order = Order::get($ordergoods->order_id);
                $order->state = $min_state?:6;
                $order->save();
            }
        }
    }

    //打印
    public function prints($store_id,$print_type,$content){
        $printset= Printset::get(['store_id'=>0]);

        if($store_id==0){
            if(!$printset['prints_id']){
                return false;
            }
            $prints= Prints::get($printset['prints_id']);
            $type=$printset['print_type'];
        }else if($store_id>0){
            if($printset['print_merch']==0){
                return false;
            }
            $printset_mer=Printset::get(['store_id'=>$store_id]);
            if(!$printset_mer){
                return false;
            }
            if($printset_mer['print_merch']==0){
                return false;
            }
            $prints = Prints::get($printset_mer['prints_id']);
            $type = $printset_mer['print_type'];
        }

        if(strpos($type,strval($print_type))!==false){
            $param=array(
                'user'=>$prints['user'],
                'key'=>$prints['ukey'],
                'sn'=>$prints['sn'],
                'content'=>$content,
                'times'=>1,
            );
            $result=$this->setPrint($param);
            return $result;
        }else{
            return false;
        }
    }
    //获取订单打印内容
    public function getOrderPrintContent($order_id,$store_id)
    {
        $system = System::get_curr();
        $orderinfo = '<CB>' . $system['pt_name'] . '</CB><BR>';
        $orderinfo .= '序号    单价    数量    金额<BR>';
        $order = Order::get($order_id,['user','leader']);
        $order_detail = Ordergoods::where('order_id',$order_id)
            ->where('store_id',$store_id)
            ->select();
        $amount = 0;
        $pay_amount = 0;
        $delivery_amount = 0;
        foreach ($order_detail as $key => $val) {
            if(in_array($val['state'],[1,6])){
                continue;
            }
            $orderinfo .= strval($key + 1) . "      " . $val['price'] . "      " . $val['num'] . "      " . $val['amount'] . '<BR>';
            $orderinfo .= $val['goods_name'] . " " . $val['attr_names'] . '<BR>';
            $amount += $val['amount'];
            $pay_amount += $val['pay_amount'];
            $delivery_amount += $val['delivery_fee'];
        }
        //开启运费合并的话 运费使用最大值
        if($order['merge'] == 1){
            $delivery = Delivery::get(function($query)use($order_id,$store_id){
                $query->where(['order_id'=>$order_id]);
                $query->where(['store_id'=>$store_id]);
            });
            $delivery_amount = $delivery['delivery_fee'];
        }
        $orderinfo .= '----------------------------------------------------------------<BR>';
        $orderinfo .= '商品总金额:' . "￥" . $amount . '<BR><BR>';

        $orderinfo .= '用户 姓名:' . $order['user_name'] . '<BR>';
        $orderinfo .= '用户 电话:' . $order['user_tel'] . '<BR><BR>';

        $orderinfo .= '团长 姓名:' . $order['leader_name'] . '<BR>';
        $orderinfo .= '团长 电话:' . $order['leader_tel'] . '<BR>';
        $orderinfo .= '团长 小区:' . $order['leader_community'] . '<BR>';
        $orderinfo .= '团长 地址:' . $order['leader_address'] . '<BR>';

        $orderinfo.= '----------------------------------------------------------------<BR>';
        $pay_amount2 = $pay_amount;
        if ($order['delivery_type'] == 2){
            $orderinfo.= '联 系 人:'."".($order['receive_name']).'<BR>';
            $orderinfo.= '联系电话:'."".($order['receive_tel']).'<BR>';
            $orderinfo.= '地   址:'."".($order['receive_address']).'<BR>';
            $orderinfo.= '配 送 费:'."".($delivery_amount).'<BR>';
            $orderinfo.= '----------------------------------------------------------------<BR>';

            $pay_amount2 =  $pay_amount  + $delivery_amount;
        }

        $orderinfo.= '<C><L><BOLD>'.'合计:'."".$pay_amount2.'</BOLD></L></C><BR>';
        $orderinfo.= '优   惠:'."".($amount-$pay_amount).'<BR>';
        $orderinfo.= '订单编号:'."".$order['order_no'].'<BR>';
        $orderinfo.= '下单时间:'."".$order['create_time'].'<BR>';
        return $orderinfo;
    }
    public function user(){
        return $this->hasOne('User','id','user_id')->bind([
            'user_name'=>'name',
            'user_tel'=>'tel',
            'openid',
        ]);
    }
    //打印
    public function setPrint($param){
        Loader::import('httpclient.HttpClient');
        define('USER', $param['user']);	//*必填*：飞鹅云后台注册账号
        define('UKEY', $param['key']);	//*必填*: 飞鹅云注册账号后生成的UKEY
        define('SN', $param['sn']);	    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
        //以下参数不需要修改
        define('IP','api.feieyun.cn');		//接口IP或域名
        define('PORT',80);					//接口IP端口
        define('PATH','/Api/Open/');		//接口路径
        define('STIME', time());			    //公共参数，请求时间
        define('SIG', sha1(USER.UKEY.STIME));   //公共参数，请求公钥
        $content = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_printMsg',
            'sn'=>SN,
            'content'=>$param['content'],
            'times'=>$param['times']//打印次数
        );
        $client = new \HttpClient(IP,PORT);
        if(!$client->post(PATH,$content)){
            return 'error';
        }
        else{
            //服务器返回的JSON字符串，建议要当做日志记录起来
            return $client->getContent();
        }
    }
}
