<?php
namespace app\api\controller;
use app\model\Goods;
use app\model\Integralorder;
use app\model\Leader;
use app\model\Ordergoods;
use app\model\Pinorder;
use app\model\System;
use app\model\User;
use think\Db;
use think\Exception;
use think\Loader;
use app\model\Memberconf;
use app\model\Order;
use app\model\Userbalancerecord;
use app\model\Task;
use app\model\Config;
use app\model\Sms;
use app\model\Dingtalk;
use app\base\controller\Api;
use app\model\Delivery;
use app\model\Payrecord;

class Corder extends Api
{
    public $memberconf;
    public function __construct()
    {
        $this->memberconf=new Memberconf();
    }
    //获取下订单时订单数据
     public function getPlaceOrder(){
         global $_W;
         $type=input('request.type');
         $user_id=input('request.user_id');
         $gid=input('request.gid');
         $attr_ids=input('request.attr_ids');
         $num=input('request.num');
         $cart_ids=input('request.cart_ids');
         $sincetype=input('request.sincetype')?input('request.sincetype'):1;
         $memberconf=$this->memberconf->getMylevel($user_id);
        // $str='[{"name":"福建1","first_count":"1","first_price":"2","next_count":"3","next_price":"4","detail":"山东省,天津市,邯郸市,承德市","ids":",1351,21,85,166,","LAY_TABLE_INDEX":0,"LAY_CHECKED":false},{"name":"福建2","first_count":"1","first_price":"3","next_count":"3","next_price":"10","detail":"福建省,河南省,合肥市,芜湖市,马鞍山市,淮北市,铜陵市,安庆市,黄山市,滁州市,阜阳市,宿州市,六安市,亳州市,池州市,宣城市","ids":",1144,1506,1023,1033,1058,1065,1070,1075,1086,1094,1103,1112,1118,1126,1131,1136,","LAY_TABLE_INDEX":1,"LAY_CHECKED":true}]';
        // $str=json_decode($str,1);
         $address['province']=input('request.province');
         $address['city']=input('request.city');
         $shop_list=Db::name('shop')->where(array('uniacid'=>$_W['uniacid'],'store_id'=>0))->select();
         if($type==1){
             $goods=Db::name('goods')->where(array('id'=>$gid))->find();
             $pic=$goods['pic'];
             if($goods['use_attr']==0){
                 $unit_price=$goods['price'];
                 $price=$unit_price*$num;
                 $attr_list='';
                 $max_num=$goods['stock'];
             }else if($goods['use_attr']==1){
                 $goodsattrsetting=Db::name('goodsattrsetting')->where(array('goods_id'=>$gid,'attr_ids'=>$attr_ids))->find();
                 if(!$goodsattrsetting)
                     error_json('商品不存在');
                 $pic=$goodsattrsetting['pic']?$goodsattrsetting['pic']:$pic;
                 $unit_price=$goodsattrsetting['price'];
                 $price=$unit_price*$num;
                 $attr_list= str_replace(',', ' ',$goodsattrsetting['key']);
                 $max_num=$goodsattrsetting['stock'];
             }
             $express_price=$this->getExpressPrice($gid,$num,$address,$attr_ids,$sincetype);
             $discount=$memberconf['discount']?$memberconf['discount']:0;
             $discoun_price=0;
             $new_item = array(
                 'goods_id' => $gid,
                 'store_id'=>$goods['store_id'],
                 'goods_name' => $goods['name'],
                 'pic' =>$pic,
                 'num' => $num,
                 'attr_list'=>$attr_list,
                 'unit_price'=>$unit_price,
                 'price'=>$price,
                 'max_num' => $max_num,
                 'disabled' => ($max_num > $num) ? true : false,
             );
             $express_price_zy=0;
             $express_price_other=0;
             if($goods['store_id']==0){
                 $discoun_price=sprintf("%.2f",$price*$discount/10);
                 $list[]=$new_item;
                 $express_price_zy=$express_price;
             }else{
                 if (!is_array($mch_list['mch_id_'.$goods['store_id']]))
                     $mch_list['mch_id_'.$goods['store_id']] = [];
                 $mch_list['mch_id_'.$goods['store_id']][]=$new_item;
                 $price=0;
                 $express_price_other=$express_price;
             }
             $new_mch_list = [];
             foreach ($mch_list as $i => $item) {
                 $mch=Db::name('store')->find($item[0]['store_id']);
                 $mch_shop_list=Db::name('shop')->where(array('uniacid'=>$_W['uniacid'],'store_id'=>$mch['id']))->select();
                 if ($mch) {
                     $new_mch_list[]=array(
                         'id'=>$mch['id'],
                         'name'=>$mch['name'],
                         'list'=>$item,
                         'mch_shop_list'=>$mch_shop_list,
                         'express_price'=>$express_price_other,
                     );
                 }
             }

             $data=array(
                 'express_price'=>$express_price_zy,
                 'total_goods_price'=>$price,
                 'discount'=>$discount,
                 'discoun_price'=>$discoun_price,
                 'list'=>$list,
                 'shop_list'=>$shop_list,
                 'mch_list'=>$new_mch_list,
             );
             success_json($data,array('img_root'=>$_W['attachurl']));
         }else if($type==2){
             $cart=Db::name('cart')->where("id in($cart_ids)")->select();
             $total_goods_price=0;
             foreach($cart as $val){
                 $goods=Db::name('goods')->where(array('id'=>$val['goods_id'],'state'=>1))->find();
                 if(!$goods)
                     continue;
                 $pic=$goods['pic'];
                 $attr_ids='';
                 if($goods['use_attr']==0){
                     $unit_price=$goods['price'];
                     $price=$unit_price*$val['num'];
                     $attr_list='';
                     $max_num=$goods['stock'];
                     $weight=$goods['weight']*$val['num'];
                 }else if($goods['use_attr']==1){
                     $goodsattrsetting=Db::name('goodsattrsetting')->where(array('goods_id'=>$val['goods_id'],'attr_ids'=>$val['attr_ids']))->find();
                     if(!$goodsattrsetting)
                         continue;
                     $pic=$goodsattrsetting['pic']?$goodsattrsetting['pic']:$pic;
                     $unit_price=$goodsattrsetting['price'];
                     $price=$unit_price*$val['num'];
                     $attr_list= str_replace(',', ' ',$goodsattrsetting['key']);
                     $attr_ids=$goodsattrsetting['attr_ids'];
                     $max_num=$goodsattrsetting['stock'];
                     $weight=$goodsattrsetting['weight']*$val['num'];
                 }
                 $new_item = array(
                     'cart_id' => $val['id'],
                     'goods_id' => $val['goods_id'],
                     'store_id'=>$val['store_id'],
                     'goods_name' => $goods['name'],
                     'pic' =>$pic,
                     'num' => $val['num'],
                     'attr_list'=>$attr_list,
                     'unit_price'=>$unit_price,
                     'price'=>$price,
                     'max_num' => $max_num,
                     'disabled' => ($max_num > $val['num']) ? true : false,
                     'attr_ids'=>$attr_ids,
                     'postagerules_id'=>$goods['postagerules_id']?$goods['postagerules_id']:0,
                     'weight'=>$weight,
                 );
                 if($val['store_id']==0){
                     $total_goods_price+=$price;
                     $list[]=$new_item;
                 }else{
                     if (!is_array($mch_list['mch_id_'.$val['store_id']]))
                         $mch_list['mch_id_'.$val['store_id']] = [];
                     $mch_list['mch_id_'.$val['store_id']][]=$new_item;
                 }
             }
             $express_price=$this->getExpressPriceMore($list,$address,$sincetype);
             $new_mch_list = [];
             foreach ($mch_list as $i => $item) {
                 $mch=Db::name('store')->find($item[0]['store_id']);
                 $mch_shop_list=Db::name('shop')->where(array('uniacid'=>$_W['uniacid'],'store_id'=>$mch['id']))->select();
                 $mch_express_price=$this->getExpressPriceMore($item,$address,$sincetype);
                 if ($mch) {
                     $new_mch_list[]=array(
                         'id'=>$mch['id'],
                         'name'=>$mch['name'],
                         'list'=>$item,
                         'mch_shop_list'=>$mch_shop_list,
                         'express_price'=>$mch_express_price,
                     );
                 }
             }
             $discount=$memberconf['discount']?$memberconf['discount']:0;
             $discoun_price=sprintf("%.2f",$total_goods_price*$discount/10);
             $data=array(
                 'express_price'=>$express_price,
                 'total_goods_price'=>$total_goods_price,
                 'discount'=>$discount,
                 'discoun_price'=>$discoun_price,
                 'list'=>$list,
                 'shop_list'=>$shop_list,
                 'mch_list'=>$new_mch_list,
             );
             success_json($data,array('img_root'=>$_W['attachurl']));
         }

     }

     //下订单
    public function setOrder(){
        global $_W;
        $type=input('request.type');
        $user_id=input('request.user_id');
        $gid=input('request.gid');
        $attr_ids=input('request.attr_ids');
        $num=input('request.num');
        $pay_type=input('request.pay_type');
        $user=Db::name('user')->find($user_id);
        $name=input('request.name');
        $phone=input('request.phone');
        $province=input('request.province');
        $city=input('request.city');
        $zip=input('request.zip');
        $address=input('request.address');
        $postalcode=input('request.postalcode');
        $user_coupon_id=input('request.user_coupon_id')?input('request.user_coupon_id'):0;
        $cart_id_list=input('request.cart_id_list')?input('request.cart_id_list'):0;
        $remark=input('request.remark');
        $mch_list=input('request.mch_list');
        $sincetype=input('request.sincetype')?input('request.sincetype'):1;
        $shop_id=input('request.shop_id')?input('request.shop_id'):0;
        $memberconf=$this->memberconf->getMylevel($user_id);
        $formId=input('request.formId')?input('request.formId'):'';
        $order_ids=array();
        $sms=new Sms();
        $dingtalk=new Dingtalk();
        if($user_coupon_id>0){
            $cond=array(
                'uniacid'=>$_W['uniacid'],
                'user_id'=>$user_id,
                'id'=>$user_coupon_id,
                'is_use'=>0,
                'end_time'=>array('egt',time()),
            );
            $user_coupon=Db::name('usercoupon')->where($cond)->find();
            if(!$user_coupon){
                error_json('优惠券不存在');
            }
        }
        $coupon_price=$user_coupon['mj_price']?$user_coupon['mj_price']:0;//优惠券优惠金额
        if($type==1){
            $goods=Db::name('goods')->where(array('id'=>$gid))->find();
            $pic=$goods['pic'];
            if($goods['use_attr']==0){
                $unit_price=$goods['price'];
                $price=$unit_price*$num;
                $attr_list='';
                $max_num=$goods['stock'];
            }else if($goods['use_attr']==1){
                $goodsattrsetting=Db::name('goodsattrsetting')->where(array('goods_id'=>$gid,'attr_ids'=>$attr_ids))->find();
                if(!$goodsattrsetting)
                    error_json('商品不存在');
                $pic=$goodsattrsetting['pic']?$goodsattrsetting['pic']:$pic;
                $unit_price=$goodsattrsetting['price'];
                $price=$unit_price*$num;
                $attr_list= str_replace(',', ' ',$goodsattrsetting['key']);
                $max_num=$goodsattrsetting['stock'];
            }
            $discount=$memberconf['discount']?$memberconf['discount']:0;//折扣
            $discoun_price=0;
            if($goods['store_id']==0){
                $discoun_price=sprintf("%.2f",$price*$discount/10);//商品折扣后金额
            }
          //  $distribution=0;//运费
            $distribution=$this->getExpressPrice($gid,$num,array('province'=>$province,'city'=>$city),$attr_ids,$sincetype);
            //订单总费用
            if($discoun_price>0.01){
                $total_price=sprintf("%.2f",$discoun_price+$distribution);
            }else{
                $total_price=sprintf("%.2f",$price+$distribution);
            }
            if($user_coupon_id>0){
                if($total_price<$user_coupon['m_price'])
                    error_json('优惠券错误');
            }

            //订单金额
            $order_amount=sprintf("%.2f",$total_price-$coupon_price);
            if($goods['store_id']>0){
                $mch_list=json_decode($mch_list,1);
                $shop_id=$mch_list[0]['shop_id'];
            }
            //订单数据
            $order=array(
                'uniacid'=>$_W['uniacid'],
                'store_id'=>$goods['store_id'],
                'user_id'=>$user_id,
                'openid'=>$user['openid'],
                'order_lid'=>$goods['lid'],
                'orderformid'=>date("YmdHis") .rand(11111, 99999),
                'total_price'=>$total_price,
                'order_amount'=>$order_amount,
                'goods_total_price'=>$price,
                'goods_total_num'=>$num,
                'sincetype'=>$sincetype,
                'distribution'=>$distribution,
                'user_coupon_id'=>$user_coupon_id,
                'coupon_price'=>$coupon_price,
                'discount'=>$discount,
                'discount_total_goods_price'=>$discoun_price,
                'pay_type'=>$pay_type,
                'create_time'=>time(),
                'name'=>$name,
                'phone'=>$phone,
                'province'=>$province,
                'city'=>$city,
                'zip'=>$zip,
                'address'=>$address,
                'postalcode'=>$postalcode,
                'remark'=>$remark,
                'prepay_id'=>$formId,
                'shop_id'=>$shop_id,
            );
            $order_id = Order::insertDb($order);
            $order_ids[]=$order_id;
            //修改优惠券状态
            if($user_coupon_id>0){
                Db::name('usercoupon')->update(array('id'=>$user_coupon_id,'is_use'=>1,'use_time'=>time()));
            }
            //订单详情
            $detail=array(
                'uniacid'=>$_W['uniacid'],
                'store_id'=>$goods['store_id'],
                'order_id'=>$order_id,
                'user_id'=>$user_id,
                'openid'=>$user['openid'],
                'gid'=>$gid,
                'gname'=>$goods['name'],
                'unit_price'=>$unit_price,
                'num'=>$num,
                'total_price'=>$price,
                'attr_ids'=>$attr_ids,
                'attr_list'=>$attr_list,
                'pic'=>$pic,
                'create_time'=>time(),
            );
            Db::name('orderdetail')->insert($detail);
            //打印小票
            $content=$this->getOrderPrintContent($order_id);
            $this->prints($goods['store_id'],1,$content);
            //发送短信
            $sms->SendSms($goods['store_id'],0);
            //发送订单机器人消息
            $dingtalk->sendtalk($goods['store_id'],0);
        }else if($type==2){
            //自营购物车
            $cart=Db::name('cart')->where("id in($cart_id_list)")->select();
            $goods_total_price=0;
            $num=0;
           // $distribution=0;//运费
            //自营商家购物车处理后信息
            $cart_list=array();
            foreach($cart as $val){
                $goods=Db::name('goods')->where(array('id'=>$val['goods_id'],'state'=>1))->find();
                if(!$goods)
                    continue;
                $pic=$goods['pic'];
                $attr_ids='';
                if($goods['use_attr']==0){
                    $unit_price=$goods['price'];
                    $price=$unit_price*$val['num'];
                    $attr_list='';
                    $max_num=$goods['stock'];
                    $weight=$goods['weight']*$val['num'];
                }else if($goods['use_attr']==1){
                    $goodsattrsetting=Db::name('goodsattrsetting')->where(array('goods_id'=>$val['goods_id'],'attr_ids'=>$val['attr_ids']))->find();
                    if(!$goodsattrsetting)
                        continue;
                    $pic=$goodsattrsetting['pic']?$goodsattrsetting['pic']:$pic;
                    $unit_price=$goodsattrsetting['price'];
                    $price=$unit_price*$val['num'];
                    $attr_ids=$goodsattrsetting['attr_ids'];
                    $attr_list= str_replace(',', ' ',$goodsattrsetting['key']);
                    $max_num=$goodsattrsetting['stock'];
                    $weight=$goodsattrsetting['weight']*$val['num'];
                }
                $num+=$val['num'];//商品总数量
                $goods_total_price+=$price;//商品总价
                $cart_zy=array(
                    'cart_id'=>$val['id'],
                    'store_id'=>$val['store_id'],
                    'gid'=>$val['goods_id'],
                    'gname'=>$goods['name'],
                    'unit_price'=>$unit_price,
                    'num'=>$val['num'],
                    'total_price'=>$price,
                    'attr_ids'=>$val['attr_ids'],
                    'attr_list'=>$attr_list,
                    'pic'=>$pic,
                    'attr_ids'=>$attr_ids,
                    'postagerules_id'=>$goods['postagerules_id']?$goods['postagerules_id']:0,
                    'weight'=>$weight,
                );
                $cart_list[]=$cart_zy;
            }
            $distribution=$this->getExpressPriceMore($cart_list,array('province'=>$province,'city'=>$city),$sincetype);
            $discount=$memberconf['discount']?$memberconf['discount']:0;//折扣
            $discoun_price=sprintf("%.2f",$goods_total_price*$discount/10);//商品折扣后金额
            //订单总费用
            if($discoun_price>0.01){
                $total_price=sprintf("%.2f",$discoun_price+$distribution);
            }else{
                $total_price=sprintf("%.2f",$goods_total_price+$distribution);
            }
            if($user_coupon_id>0){
                if($total_price<$user_coupon['m_price'])
                    error_json('优惠券错误');
            }
            //订单金额
            $order_amount=sprintf("%.2f",$total_price-$coupon_price);
            if($cart){
                //订单数据
                $order=array(
                    'uniacid'=>$_W['uniacid'],
                    'store_id'=>0,
                    'user_id'=>$user_id,
                    'openid'=>$user['openid'],
                    'order_lid'=>1,
                    'orderformid'=>date("YmdHis") .rand(11111, 99999),
                    'total_price'=>$total_price,
                    'order_amount'=>$order_amount,
                    'goods_total_price'=>$goods_total_price,
                    'goods_total_num'=>$num,
                    'sincetype'=>$sincetype,
                    'distribution'=>$distribution,
                    'user_coupon_id'=>$user_coupon_id,
                    'coupon_price'=>$coupon_price,
                    'discount'=>$discount,
                    'discount_total_goods_price'=>$discoun_price,
                    'pay_type'=>$pay_type,
                    'create_time'=>time(),
                    'name'=>$name,
                    'phone'=>$phone,
                    'province'=>$province,
                    'city'=>$city,
                    'zip'=>$zip,
                    'address'=>$address,
                    'postalcode'=>$postalcode,
                    'remark'=>$remark,
                    'prepay_id'=>$formId,
                    'shop_id'=>$shop_id,
                );
                $order_id = Order::insertDb($order);
                //打印小票
                $content=$this->getOrderPrintContent($order_id);
                $this->prints(0,1,$content);

                //发送短信
                $sms->SendSms(0,0);
                //发送订单机器人消息
                $dingtalk->sendtalk(0,0);

                $order_ids[]=$order_id;
                //修改优惠券状态
                if($user_coupon_id>0){
                    Db::name('usercoupon')->update(array('id'=>$user_coupon_id,'is_use'=>1,'use_time'=>time()));
                }
                //订单详情
                foreach($cart_list as $v){
                    $detail=array(
                        'uniacid'=>$_W['uniacid'],
                        'store_id'=>$v['store_id'],
                        'order_id'=>$order_id,
                        'user_id'=>$user_id,
                        'openid'=>$user['openid'],
                        'gid'=>$v['gid'],
                        'gname'=>$v['gname'],
                        'unit_price'=>$v['unit_price'],
                        'num'=>$v['num'],
                        'total_price'=>$v['total_price'],
                        'attr_ids'=>$v['attr_ids'],
                        'attr_list'=>$v['attr_list'],
                        'pic'=>$v['pic'],
                        'create_time'=>time(),
                    );
                    Db::name('orderdetail')->insert($detail);
                    //删除购物车
                    Db::name('cart')->delete($v['cart_id']);
                }
            }
            //商家信息
            $mch_list=json_decode($mch_list,1);
            foreach ($mch_list as $val){
                //商家购物车
                $cart_ids=implode(',',$val['cart_id_list']);
                $cart=Db::name('cart')->where("id in($cart_ids)")->select();
                $goods_total_price=0;
                $num=0;
                $distribution=0;//运费
                //商家购物车处理后信息
                $cart_list=array();
                $attr_ids='';
                foreach ($cart as $v) {
                    $goods=Db::name('goods')->where(array('id'=>$v['goods_id'],'state'=>1))->find();
                    if(!$goods)
                        continue;
                    $pic=$goods['pic'];
                    if($goods['use_attr']==0){
                        $unit_price=$goods['price'];
                        $price=$unit_price*$v['num'];
                        $attr_list='';
                        $max_num=$goods['stock'];
                        $weight=$goods['weight']*$v['num'];
                    }else if($goods['use_attr']==1){
                        $goodsattrsetting=Db::name('goodsattrsetting')->where(array('goods_id'=>$v['goods_id'],'attr_ids'=>$v['attr_ids']))->find();
                        if(!$goodsattrsetting)
                            continue;
                        $pic=$goodsattrsetting['pic']?$goodsattrsetting['pic']:$pic;
                        $unit_price=$goodsattrsetting['price'];
                        $price=$unit_price*$v['num'];
                        $attr_ids=$goodsattrsetting['attr_ids'];
                        $attr_list= str_replace(',', ' ',$goodsattrsetting['key']);
                        $max_num=$goodsattrsetting['stock'];
                        $weight=$goodsattrsetting['weight']*$val['num'];
                    }
                    $num+=$v['num'];//商品总数量
                    $goods_total_price+=$price;//商品总价
                    $cart_zy=array(
                        'cart_id'=>$v['id'],
                        'store_id'=>$val['store_id'],
                        'gid'=>$v['goods_id'],
                        'gname'=>$goods['name'],
                        'unit_price'=>$unit_price,
                        'num'=>$v['num'],
                        'total_price'=>$price,
                        'attr_ids'=>$v['attr_ids'],
                        'attr_list'=>$attr_list,
                        'pic'=>$pic,
                        'attr_ids'=>$attr_ids,
                        'postagerules_id'=>$goods['postagerules_id']?$goods['postagerules_id']:0,
                        'weight'=>$weight,
                    );
                    $cart_list[]=$cart_zy;
                }
                $distribution=$this->getExpressPriceMore($cart_list,array('province'=>$province,'city'=>$city),$sincetype);
                $discount=$memberconf['discount']?$memberconf['discount']:0;//折扣
               // $discoun_price=sprintf("%.2f",$goods_total_price*$discount/10);//商品折扣后金额
                $discoun_price=0;
                //订单总费用
                if($discoun_price>0.01){
                    $total_price=sprintf("%.2f",$discoun_price+$distribution);
                }else{
                    $total_price=sprintf("%.2f",$goods_total_price+$distribution);
                }
                //订单金额
                $order_amount=$total_price;
                if($cart){
                    //订单数据
                    $order=array(
                        'uniacid'=>$_W['uniacid'],
                        'store_id'=>$val['store_id'],
                        'user_id'=>$user_id,
                        'openid'=>$user['openid'],
                        'order_lid'=>1,
                        'orderformid'=>date("YmdHis") .rand(11111, 99999),
                        'total_price'=>$total_price,
                        'order_amount'=>$order_amount,
                        'goods_total_price'=>$goods_total_price,
                        'goods_total_num'=>$num,
                        'distribution'=>$distribution,
                        'discount'=>$discount,
                        'discount_total_goods_price'=>$discoun_price,
                        'pay_type'=>$pay_type,
                        'create_time'=>time(),
                        'name'=>$name,
                        'phone'=>$phone,
                        'province'=>$province,
                        'city'=>$city,
                        'zip'=>$zip,
                        'address'=>$address,
                        'postalcode'=>$postalcode,
                        'remark'=>$val['remark'],
                        'sincetype'=>$val['sincetype'],
                        'shop_id'=>$val['shop_id'],
                    );
                    $order_id = Order::insertDb($order);
                    //打印小票
                    $content=$this->getOrderPrintContent($order_id);
                    $this->prints($val['store_id'],1,$content);

                    //发送短信
                    $sms->SendSms($val['store_id'],0);
                    //发送订单机器人消息
                    $dingtalk->sendtalk($val['store_id'],0);
                    $order_ids[]=$order_id;
                }
                //订单详情
                foreach($cart_list as $v1){
                    $detail=array(
                        'uniacid'=>$_W['uniacid'],
                        'store_id'=>$v1['store_id'],
                        'order_id'=>$order_id,
                        'user_id'=>$user_id,
                        'openid'=>$user['openid'],
                        'gid'=>$v1['gid'],
                        'gname'=>$v1['gname'],
                        'unit_price'=>$v1['unit_price'],
                        'num'=>$v1['num'],
                        'total_price'=>$v1['total_price'],
                        'attr_ids'=>$v1['attr_ids'],
                        'attr_list'=>$v1['attr_list'],
                        'pic'=>$v1['pic'],
                        'create_time'=>time(),
                    );
                    Db::name('orderdetail')->insert($detail);
                    //删除购物车
                    Db::name('cart')->delete($v1['cart_id']);
                }
            }
        }

        //还没确定上线
        if (!isset($info->share_user_id) || ! $user['share_user_id']){
            if (Config::get_value('distribution_relation') == 1){
                Db::name('user')->update(['id'=>$user['id'],'share_user_id'=>$user['last_share_user_id']]);
            }
        }

        $order_num=count($order_ids);
        if($order_num==1){
            if($pay_type==1){
                $return=array(
                    'pay_type'=>1,
                    'order_id'=>'1-'.$order_id,
                );
                success_json($return);
            }else if($pay_type==2){
                $order=Db::name('order')->find($order_id);
                if($user['balance']<$order['order_amount']){
                    error_json('余额不足');
                }
                //余额支付
                $param=array(
                    'uniacid'=>$_W['uniacid'],
                    'user_id'=>$user_id,
                    'money'=>$order['order_amount'],
                    'order_sign'=>1,
                    'order_id'=>$order_id,

                );
                $this->setBalance($param);
                $return=array(
                    'pay_type'=>2,
                    'msg'=>'余额付款成功',
                );
                success_json($return);
            }

        }else if($order_num>1){
            //增加合并订单
            //合并订单中支付金额
            $order_ids=implode(',',$order_ids);
            $union_money=Db::name('order')->where("id in($order_ids)")->sum('order_amount');
            $order_union=array(
                'uniacid'=>$_W['uniacid'],
                'user_id'=>$user_id,
                'order_no'=>date("YmdHis") .rand(11111, 99999),
                'order_id_list'=>$order_ids,
                'money'=>sprintf("%.2f",$union_money),
                'create_time'=>time(),
                'prepay_id'=>$formId,
            );
            Db::name('orderunion')->insert($order_union);
            $order_id = Db::name('orderunion')->getLastInsID();
            //保存合并订单id
            Db::name('order')->where("id in($order_ids)")->update(array('order_union_id'=>$order_id));
            if($pay_type==1){
                $return=array(
                    'pay_type'=>1,
                    'order_id'=>'2-'.$order_id,
                );
                success_json($return);
            }else if($pay_type==2){
                if($user['balance']<$union_money){
                    error_json('余额不足');
                }
                //余额支付
                $param=array(
                    'uniacid'=>$_W['uniacid'],
                    'user_id'=>$user_id,
                    'money'=>sprintf("%.2f",$union_money),
                    'order_sign'=>2,
                    'order_id'=>$order_id,
                );
                $this->setBalance($param);
                $return=array(
                    'pay_type'=>2,
                    'msg'=>'余额付款成功',
                );
                success_json($return);
            }
        }
    }
    //余额付款完成处理
    private function setBalance($param){
        global $_W;
        //减少用户余额
     /*   Db::name('user')->where(array('id'=>$param['user_id']))->setDec('balance',$param['money']);
        //增加余额变动记录
        $userbalancerecord=array(
            'uniacid'=>$param['uniacid'],
            'user_id'=>$param['user_id'],
            'sign'=>2,
            'type'=>3,
            'money'=>$param['money'],
            'title'=>'订单消费减少$'.$param['money'],
            'create_time'=>time(),
            'order_sign'=>$param['order_sign'],
            'order_id'=>$param['order_id'],
        );*/
        $remark='订单消费减少￥'.$param['money'];
        $Userbalancerecord=new Userbalancerecord();
        $Userbalancerecord->editBalance($param['user_id'],'-'.$param['money']);
        $Userbalancerecord->addBalanceRecord($param['user_id'],$_W['uniacid'],2,0,'-'.$param['money'],$param['order_id'],'',$remark);
      //  Db::name('userbalancerecord')->insert($userbalancerecord);
        //修改订单状态
        if($param['order_sign']==1){
            Db::name('order')->update(array('id'=>$param['order_id'],'pay_status'=>1,'pay_time'=>time(),'order_status'=>1));
            //获取订单详情
            $order_detail=Db::name('orderdetail')->where(array('order_id'=>$param['order_id']))->select();
            $content=$this->getOrderPrintContent($param['order_id']);
            //打印小票
            $order_print=Db::name('order')->find($param['order_id']);
            $result=$this->prints($order_print['store_id'],2,$content);
        }else if($param['order_sign']==2){
            Db::name('orderunion')->update(array('id'=>$param['order_id'],'pay_status'=>1,'pay_time'=>time()));
            Db::name('order')->where(array('order_union_id'=>$param['order_id']))->update(array('pay_status'=>1,'pay_time'=>time(),'order_status'=>1));
            $orderunion=Db::name('orderunion')->find($param['order_id']);
            $order_id_list=$orderunion['order_id_list'];
            $order_detail=Db::name('orderdetail')->where("order_id in ($order_id_list)")->select();
            $order_print=Db::name('order')->field('id,store_id')->where(array('order_union_id'=>$param['order_id']))->select();
            foreach($order_print as $val1){
                //打印小票
                $content=$this->getOrderPrintContent($val1['id']);
                $this->prints($val1['store_id'],2,$content);
            }
        }
        foreach($order_detail as $val){
            $this->setGoodsStock($val['gid'],$val['num'],$val['attr_ids']);
        }

        $user=Db::name('user')->find($param['user_id']);
        $goods=array();
        //发送模板消息
        if($param['order_sign']==2){
            $order=Db::name('orderunion')->find($param['order_id']);
            $page="sqtg_sun/pages/public/pages/myorder/myorder?ostatus=2&id=2";
            $goods['gname']='合并订单';
            $goods['num']='';
            $order['orderformid']=$order['order_no'];
            $order['order_amount']=$order['money'];
            $order['openid']=$user['openid'];
        }else{
            $order=Db::name('order')->find($param['order_id']);
            $page="sqtg_sun/pages/hqs/pages/orderdetail/orderdetail?id={$order['id']}";
            $goods=$this->getGnameandNum($order['id']);
        }

        $data1=array(
            'keyword1'=>array('value'=>$order['orderformid'],'color'=>'173177'),
            'keyword2'=>array('value'=>$goods['gname'],'color'=>'173177'),
            'keyword3'=>array('value'=>$goods['num'],'color'=>'173177'),
            'keyword4'=>array('value'=>$order['order_amount'],'color'=>'173177'),
            'keyword5'=>array('value'=>date('Y-m-d H:i'),'color'=>'173177'),
        );

        $this->setTemplateContentAndTask($order,'tid1',$page,$order['prepay_id'],$data1);

        //还没确定上线
        if (!isset($info->share_user_id) || ! $user['share_user_id']){
            if (Config::get_value('distribution_relation') == 2){
                Db::name('user')->update(['id'=>$user['id'],'share_user_id'=>$user['last_share_user_id']]);
            }
        }
    }

    //单个商品库存减少 销量增加
    private function setGoodsStock($gid,$num,$attr_ids){
        $goods=Db::name('goods')->find($gid);
        if($goods['use_attr']==1){
            Db::name('goods')->where(array('id'=>$gid))->setInc('sales_num',$num);
            Db::name('goodsattrsetting')->where(array('goods_id'=>$gid,'attr_ids'=>$attr_ids))->setDec('stock',$num);
            Db::name('goods')->where(array('id'=>$gid))->setDec('stock',$num);
        }else{
            Db::name('goods')->where(array('id'=>$gid))->setDec('stock',$num);
            Db::name('goods')->where(array('id'=>$gid))->setInc('sales_num',$num);
        }
    }
    //获取微信支付参数
    public function getPayParam(){
        global $_W;
        $order_id=input('request.order_id');
        $order_id=explode('-',$order_id);
        if($order_id[0]==1){
            $order=Db::name('order')->find($order_id[1]);
            if(!$order){
                error_json('订单错误');
            }
            if($order['pay_status']==1){
               error_json('该订单已支付');
            }
            $attach=array(
                'type'=>'CommonOrder',
                'uniacid'=>$order['uniacid'],
            );
            $order['attach']=json_encode($attach);
            $data=$this->setPayParam($order);
            Db::name('order')->update(array('id'=>$order['id'],'prepay_id'=>$data['prepay_id']));
            success_json($data);
        }else if($order_id[0]==2){
            $orderunion=Db::name('orderunion')->find($order_id[1]);
            $user=Db::name('user')->find($orderunion['user_id']);
            if(!$orderunion){
                error_json('订单错误');
            }
            if($orderunion['pay_status']==1){
                error_json('该订单已支付');
            }
            $attach=array(
                'type'=>'MergeOrder',
                'uniacid'=>$orderunion['uniacid'],
            );
            $order['attach']=json_encode($attach);
            $order['openid']=$user['openid'];
            $order['orderformid']=$orderunion['order_no'];
            $order['order_amount']=$orderunion['money'];
            $data=$this->setPayParam($order);
            Db::name('orderunion')->update(array('id'=>$order_id[1],'prepay_id'=>$data['prepay_id']));
            success_json($data);
        }else{
            error_json('订单错误');
        }
    }
    //设置微信支付参数
    private function setPayParam($order){
        global $_W;
        Loader::import('wxpay.wxpay');
        $system=Db::name('system')->where(array('uniacid'=>$_W['uniacid']))->find();
        $appid = $system['appid'];
        $openid = $order['openid'];//openid
        $mch_id = $system['mchid'];//商户号
        $key = $system['wxkey'];   //密钥
        $out_trade_no = $order['orderformid'];//订单号
        $total_fee = intval($order['order_amount']*100);//价格
        $body=$order['orderformid'];
        $attach=$order['attach'];
        $siteroot=str_replace("https","http",$_W['siteroot']);
        $notify_url=$siteroot.'/addons/sqtg_sun/public/notify.php';
        if($openid=='o3W0Y4_2rFmIi00R71ClYr1UpCyU'||$openid=='o3W0Y430RAOkltn2mJVqaUK9w6q8'||$openid=='o3W0Y4xbxds5g0-bbf9qFzulgp6Q'){
            //$total_fee=1;
        }
        if($total_fee<=0){
           error_json('金额有误');
        }
        $weixinpay = new \WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$attach,$notify_url);
        $return = $weixinpay->pay();
        return $return;
    }
    //回调方法
    public function wxpay(){
        $xml = file_get_contents('php://input');
        $obj = isimplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $data = json_decode(json_encode($obj), true);
        //增加报文记录
        $baowen=array();
        $baowen['xml']=$xml;
        $baowen['out_trade_no']=$data['out_trade_no'];
        $baowen['transaction_id']=$data['transaction_id'];
        $baowen['add_time']=time();
        Db::name('baowen')->insert($baowen);
        if($this->checksign($data)){
            $this->setPayResult($data);
        }else{
            echo 'FAIL';
        }
    }
    //回调处理订单
    private function setPayResult($data){
        $attach=json_decode($data['attach'],true);
        if($attach['type']=='CommonOrder'){
            $this->setCommonOrder($data);
        }else if($attach['type']=='MergeOrder'){
            $this->setMergeOrder($data);
        }else if($attach['type']=='recharge'){
            $rec=new Crecharge();
            $rec->payNotify($data);
        }else if($attach['type']=='storerecharge'){
            $rec=new Cstore();
            $rec->payNotify($data);
        }else if($attach['type']=='seckillorder'){
            $rec=new Cseckill();
            $rec->payNotify($data);
        }else if($attach['type']=='integral'){
            $int=new Integralorder();
            $int->notify($data);
        }else if($attach['type']=='pinbuy'){
            $pin=new Pinorder();
           $pin->notify($data);
        }else if($attach['type']=='pinjoinbuy'){
            //拼团参团
            $pin=new Pinorder();
            $pin->joinNotify($data);
        }
    }
    //处理合并订单
    private function setMergeOrder($data){
        $attach=json_decode($data['attach'],1);
        $uniacid=$attach['uniacid'];
        $orderunion=Db::name('orderunion')->where(array('uniacid'=>$uniacid,'order_no'=>$data['out_trade_no']))->find();
        if(empty($orderunion)||$orderunion['pay_status']==1){
            echo 'FAIL';
            exit;
        }
        //修改合并订单状态
        Db::name('orderunion')->where(array('id'=>$orderunion['id']))->update(array('pay_status'=>1,'pay_time'=>time(),'transaction_id'=>$data['out_trade_no']));
        //修改订单状态
        $order_ids=$orderunion['order_id_list'];
        Db::name('order')->where("id in($order_ids)")->update(array('pay_status'=>1,'pay_type'=>1,'pay_time'=>time(),'order_status'=>1));
        //获取订单详情修改库存
        $order_detail=Db::name('orderdetail')->where("order_id in($order_ids)")->select();
        foreach($order_detail as $val){
            $this->setGoodsStock($val['gid'],$val['num'],$val['attr_ids']);
        }
        //打印小票
        $order_print=Db::name('order')->field('id,store_id')->where(array('order_union_id'=>$orderunion['id']))->select();
        foreach($order_print as $val1) {
            $content=$this->getOrderPrintContent($val1['id']);
            $this->prints($val1['store_id'],2,$content);
        }
        //发送合并订单模板消息
        $order=$orderunion;
        $page="sqtg_sun/pages/public/pages/myorder/myorder?ostatus=2&id=2";
        $goods['gname']='合并订单';
        $goods['num']='';
        $user=Db::name('user')->find($orderunion['user_id']);
        $order['openid']=$user['openid'];
        $order['orderformid']=$order['order_no'];
        $order['order_amount']=$order['money'];
        $data1=array(
            'keyword1'=>array('value'=>$order['orderformid'],'color'=>'173177'),
            'keyword2'=>array('value'=>$goods['gname'],'color'=>'173177'),
            'keyword3'=>array('value'=>$goods['num'],'color'=>'173177'),
            'keyword4'=>array('value'=>$order['order_amount'],'color'=>'173177'),
            'keyword5'=>array('value'=>date('Y-m-d H:i'),'color'=>'173177'),
        );
        $this->setTemplateContentAndTask($order,'tid1',$page,$order['prepay_id'],$data1);
    }
    //处理普通订单
    private function setCommonOrder($data){
        $attach=json_decode($data['attach'],1);
        $uniacid=$attach['uniacid'];
        $order=Db::name('order')->where(array('uniacid'=>$uniacid,'orderformid'=>$data['out_trade_no']))->find();
        if(empty($order)||$order['pay_status']==1){
            echo 'FAIL';
            exit;
        }
        //打印小票
        $content=$this->getOrderPrintContent($order['id']);
        $this->prints($order['store_id'],2,$content);
        if($order['order_lid']==1||$order['order_lid']==2){
            //修改订单状态
            Db::name('order')->where(array('id'=>$order['id']))->update(array('pay_status' => 1,'pay_type'=>1, 'pay_time' => time(),'order_status'=>1,'transaction_id'=>$data['transaction_id']));
           //获取详情 修改库存状态
            $order_detail=Db::name('orderdetail')->where(array('order_id'=>$order['id']))->select();
            foreach($order_detail as $val){
                $this->setGoodsStock($val['gid'],$val['num'],$val['attr_ids']);
            }
        }
        //发送模板消息
        if($order['order_lid']==1){
            $page="sqtg_sun/pages/hqs/pages/orderdetail/orderdetail?id={$order['id']}";
        }else if($order['order_lid']==2){
            $page="sqtg_sun/pages/plugin/order/orderlistdet/orderlistdet?id={$order['id']}";
        }
        $goods=$this->getGnameandNum($order['id']);
        $data1=array(
            'keyword1'=>array('value'=>$order['orderformid'],'color'=>'173177'),
            'keyword2'=>array('value'=>$goods['gname'],'color'=>'173177'),
            'keyword3'=>array('value'=>$goods['num'],'color'=>'173177'),
            'keyword4'=>array('value'=>$order['order_amount'],'color'=>'173177'),
            'keyword5'=>array('value'=>date('Y-m-d H:i'),'color'=>'173177'),
        );
        $this->setTemplateContentAndTask($order,'tid1',$page,$order['prepay_id'],$data1);

//        todo 这个还没测试
        //还没确定上线
        $user = Db::name('user')->find(['id'=>$order['user_id']]);
        if (!isset($info->share_user_id) || ! $user['share_user_id']){
            if (Config::get_value('distribution_relation') == 2){
                Db::name('user')->update(['id'=>$user['id'],'share_user_id'=>$user['last_share_user_id']]);
            }
        }

        echo 'SUCCESS';
    }
    private function getGnameandNum($order_id){
        $orderdetail=Db::name('orderdetail')->where(array('order_id'=>$order_id))->select();
        $gname='';
        $num='';
        foreach($orderdetail as $val){
            $gname.=$val['gname'].' '.$val['attr_list'].'|';
            $num.=$val['num'].'|';
        }
        $data=array(
            'gname'=>$gname,
            'num'=>$num,
        );
        return $data;
    }
    //增加模板消息数据和任务
    private function setTemplateContentAndTask($order,$tid,$page,$form_id,$data){
        $template=Db::name('template')->where(array('uniacid'=>$order['uniacid']))->find();
        $content=array(
            'uniacid'=>$order['uniacid'],
            'touser'=>$order['openid'],
            'template_id'=>$template[$tid],
            'page'=>$page,
            'form_id'=>$form_id,
            'data'=>json_encode($data),
            'create_time'=>time(),
        );
        Db::name('templatecontent')->insert($content);
        $content_id=Db::name('templatecontent')->getLastInsID();
        $task=array(
            'uniacid'=>$order['uniacid'],
            'type'=>'template',
            'state'=>0,
            'level'=>1,
            'value'=>$content_id,
            'create_time'=>time(),
        );
    //   Db::name('task')->insert($task);
   //    $task_id=Db::name('task')->getLastInsID();
        global $_W;
        $_W['uniacid']=$order['uniacid'];
        $TaskModel=new Task();
        $TaskModel->save($task);
        $task_id=$TaskModel->id;
        Db::name('templatecontent')->update(array('id'=>$content_id,'task_id'=>$task_id));
    }



    //签名验证
    private function checksign($data){

        $get=$data;
        $string1 = '';
        ksort($get);
        foreach($get as $k => $v) {
            if($v != '' && $k != 'sign') {
                $string1 .= "{$k}={$v}&";
            }
        }
     //   $uniacid=explode('-',$data['attach']);
        $attach=json_decode($data['attach'],true);
        $system=Db::name('system')->where(array('uniacid'=>$attach['uniacid']))->find();
        $wxkey=$system['wxkey'];
        $sign = strtoupper(md5($string1 . "key=$wxkey"));
        if($sign==$get['sign']){
            return true;
        }else{
            return false;
        }
    }
    //获取订单列表
    public function getOrder2(){
        global $_W;
        $user_id=input('request.user_id');
        $type=input('request.type');
        $page=input('request.page')?input('request.page'):1;
        $limit=input('request.limit')?input('request.limit'):6;
        $lid=input('request.lid')?input('request.lid'):1;
        $cond=array(
            'uniacid'=>$_W['uniacid'],
            'user_id'=>$user_id,
            'del_status'=>0,
            'order_lid'=>$lid,
        );
        $cond1=array();
        if($type==1){
           $cond1=array(
              'pay_status'=>0,
               'order_status'=>0,
           );
        }else if($type==2){
            $cond1=array(
                'pay_status'=>1,
                'order_status'=>1,
            );
        }else if($type==3){
            $cond1=array(
                'pay_status'=>1,
                'order_status'=>2,
            );
        }else if($type==6){
            $cond1=array(
                'pay_status'=>1,
                'order_status'=>3,
            );
        }else if($type==7){
            $cond1=array(
                'pay_status'=>1,
                'order_status'=>5,
            );
        }
        $cond=array_merge($cond,$cond1);
        $order=Db::name('order')->where($cond)->order('id desc')->page($page)->limit($limit)->select();
        foreach ($order as &$val){
            if($val['store_id']==0){
                $val['store_name']='平台自营';
            }else{
                $store=Db::name('store')->find($val['store_id']);
                $val['store_name']=$store['name'];
            }
            $val['detail']=Db::name('orderdetail')->where(array('uniacid'=>$_W['uniacid'],'order_id'=>$val['id']))->select();
            $val['create_time_date']=date('Y-m-d',$val['create_time']);
            $val['create_time_date1']=date('Y-m-d H:i',$val['create_time']);
            $val['pay_time_date']=date('Y-m-d',$val['pay_time']);
            $val['pay_time_date1']=date('Y-m-d H:i',$val['pay_time']);
            $val['pay_order_id']=$val['pay_type']==1?'1-'.$val['id']:'2-'.$val['id'];
        }
        success_json($order,array('img_root'=>$_W['attachurl']));
    }
    //取消订单
    public function cancelOrder2(){
        global $_W;
        $order_id=input('order_id');
        $user_id=input('user_id');
        $order=Db::name('order')->where(array('uniacid'=>$_W['uniacid'],'id'=>$order_id,'user_id'=>$user_id))->find();
        if(!$order){
            error_json('订单不存在');
        }
        if($order['pay_status']!=0||$order['order_status']==4){
            error_json('订单已支付或已取消,不能取消订单');
        }
        Db::name('order')->update(array('id'=>$order_id,'order_status'=>4,'cancel_time'=>time()));
        success_json('取消成功');
    }
    //删除订单
    public function delOrder(){
        global $_W;
        $order_id=input('order_id');
        $user_id=input('user_id');
        $order=Db::name('order')->where(array('uniacid'=>$_W['uniacid'],'id'=>$order_id,'user_id'=>$user_id))->find();
        if(!$order){
            error_json('订单不存在');
        }
        if($order['order_status']!=3&&$order['order_status']!=4){
            error_json('订单不能删除,完成订单才可以删除');
        }
        if($order['del_status']==1){
            error_json('订单已经删除,不能重复删除');
        }
        Db::name('order')->update(array('id'=>$order_id,'del_status'=>1,'del_time'=>time()));
        success_json('删除成功');
    }
    //订单列表余额支付
    public function setBalancePay(){
        global $_W;
        $formId=input('request.formId');
        $user_id=input('request.user_id');
        $pay_order_id=input('request.pay_order_id');
        $order=explode('-',$pay_order_id);
        if($order[0]==1){
           // error_json('支付方式错误');
        }
        Db::name('order')->update(array('id'=>$order[1],'pay_type'=>2));
        $order=Db::name('order')->where(array('id'=>$order[1],'user_id'=>$user_id))->find();
        if($order['pay_status']==1){
            error_json('订单已支付');  
        }
        if($order['pay_type']!=2){
            error_json('订单错误');
        }
        $user=Db::name('user')->find($user_id);
        if($user['balance']<$order['order_amount']){
            error_json('余额不足');
        }
        //余额支付
        $param=array(
            'uniacid'=>$_W['uniacid'],
            'user_id'=>$user_id,
            'money'=>$order['order_amount'],
            'order_sign'=>1,
            'order_id'=>$order['id'],
        );
        $this->setBalance($param);
        $return=array(
            'pay_type'=>2,
            'msg'=>'余额付款成功',
        );
        success_json($return);

    }
    //订单详情
    public function getOrderDetail(){
        global $_W;
        $order_id=input('request.order_id');
        $order=Db::name('order')->find($order_id);
        $order['detail']=Db::name('orderdetail')->where(array('order_id'=>$order['id']))->select();
        $order['create_time_d1']=date('Y-m-d H:i',$order['create_time']);
        $order['create_time_d2']=date('Y-m-d',$order['create_time']);
        $order['pay_time_d1']=$order['pay_time']?date('Y-m-d H:i',$order['pay_time']):'';
        $order['pay_time_d2']=$order['pay_time']?date('Y-m-d',$order['pay_time']):'';
        $order['pay_order_id']=$order['pay_type']==1?'1-'.$order['id']:'2-'.$order['id'];
        if($order['sincetype']==2){
            $order['shop']=Db::name('shop')->find($order['shop_id']);
        }
        if($order['store_id']>0){
            $order['store']=Db::name('store')->find($order['store_id']);
        }
        if($order['order_status']==5){
            $orderrefund=Db::name('orderrefund')->where(array('order_id'=>$order_id))->order('id desc')->find();
            $refund=array(
                'refund_application_time'=>date('Y-m-d H:i',$order['refund_application_time']),
                'review_status'=>$order['review_status'],
                'review_time'=>$order['review_time']?date('Y-m-d H:i',$order['review_time']):'',
                'refund_status'=>$order['refund_status'],
                'refund_price'=>$orderrefund['refund_price'],
                'review_reason'=>$order['review_reason'],
                'refund_time'=>$order['refund_time']?date('Y-m-d H:i',$order['refund_time']):'',
                'order_refund_no'=>$orderrefund['order_refund_no'],
                'err_code_dec'=>$orderrefund['err_code_dec'],
            );
            $order['refund']=$refund;
        }

        success_json($order,array('img_root'=>$_W['attachurl']));
    }
    //确认收货
    public function confirmOrder(){
        global $_W;
        $order_id=input('request.order_id');
        $order=Db::name('order')->find($order_id);
        if($order['pay_status']!=1||$order['order_status']!=2){
            error_json('订单状态错误,不能确认收货');
        }
        $ret = Order::confirm($order_id);
        if ($ret){
            $content=$this->getOrderPrintContent($order_id);
            $this->prints($order['store_id'],3,$content);
            success_json('确认收货成功');
        }else{
            error_json('订单确认失败');
        }
//        Db::name('order')->update(array('id'=>$order_id,'order_status'=>3,'confirm_time'=>time()));
//        $Integralrecord=new Integralrecord();
//        $score=$Integralrecord->getScore($order['order_amount']);
//        if($score>0) {
//            $Integralrecord->scoreAct($order['user_id'], 1, $score, $order['id']);
//        }
//        Db::name('user')->where(array('id'=>$order['user_id']))->setInc('total_consume',$order['order_amount']);
//        //商户增加金额
//        if($order['store_id']!=0){
//            //增加商户余额
//            Db::name('store')->where(array('id'=>$order['store_id']))->setInc('money',$order['order_amount']);
//            $store=Db::name('store')->find($order['store_id']);
//            //增加商家记录
//            $detail='订单完成-订单id:'.$order['id'].' 订单号:'.$order['orderformid'];
//            $mercapdetails=array(
//                'uniacid'=>$order['uniacid'],
//                'store_id'=>$order['store_id'],
//                'store_name'=>$store['name'],
//                'mcd_type'=>1,
//                'openid'=>$order['openid'],
//                'user_id'=>$order['user_id'],
//                'sign'=>1,
//                'mcd_memo'=>$detail,
//                'money'=>$order['order_amount'],
//                'order_id'=>$order['id'],
//                'add_time'=>time(),
//                'now_money'=>$store['money'],
//            );
//            Db::name('mercapdetails')->insert($mercapdetails);
//            //增加商家总销量
//            Db::name('store')->where(array('id'=>$order['store_id']))->setInc('sale_count',$order['goods_total_num']);
//        }
        success_json('确认收货成功');
    }
//    自提订单核销
    public function confirmOrder2(){
        global $_W;
        $order_id=input('request.order_id');
        $order=Db::name('order')->find($order_id);
        if ($order['store_id'] != input('request.store_id')){
            error_json('该订单不属于您的商店，不能核销');
        }
        if($order['pay_status']!=1||$order['order_status']!=1){
            error_json('订单状态错误,不能核销');
        }
        $ret = Order::confirm($order_id);
        if ($ret){
            success_json('确认收货成功');
        }else{
            error_json('订单确认失败');
        }
//        Db::name('order')->update(array('id'=>$order_id,'order_status'=>3,'confirm_time'=>time()));
//        $Integralrecord=new Integralrecord();
//        $score=$Integralrecord->getScore($order['order_amount']);
//        if($score>0) {
//            $Integralrecord->scoreAct($order['user_id'], 1, $score, $order['id']);
//        }
//        Db::name('user')->where(array('id'=>$order['user_id']))->setInc('total_consume',$order['order_amount']);
//        //商户增加金额
//        if($order['store_id']!=0){
//            //增加商户余额
//            Db::name('store')->where(array('id'=>$order['store_id']))->setInc('money',$order['order_amount']);
//            $store=Db::name('store')->find($order['store_id']);
//            //增加商家记录
//            $detail='订单完成-订单id:'.$order['id'].' 订单号:'.$order['orderformid'];
//            $mercapdetails=array(
//                'uniacid'=>$order['uniacid'],
//                'store_id'=>$order['store_id'],
//                'store_name'=>$store['name'],
//                'mcd_type'=>1,
//                'openid'=>$order['openid'],
//                'user_id'=>$order['user_id'],
//                'sign'=>1,
//                'mcd_memo'=>$detail,
//                'money'=>$order['order_amount'],
//                'order_id'=>$order['id'],
//                'add_time'=>time(),
//                'now_money'=>$store['money'],
//            );
//            Db::name('mercapdetails')->insert($mercapdetails);
//            //增加商家总销量
//            Db::name('store')->where(array('id'=>$order['store_id']))->setInc('sale_count',$order['goods_total_num']);
//        }
//        success_json('核销成功');
    }
    //申请退款
    public function setOrderRefund(){
        $order_id=input('request.order_id');
        $user_id=input('request.user_id');
        $order=Db::name('order')->where(array('id'=>$order_id,'user_id'=>$user_id))->find();
        if(!$order){
            error_json('订单不存在');
        }
        if($order['order_status']!=1){
            error_json('待发货订单才可以退款');
        }
        Db::name('order')->update(array('id'=>$order_id,'order_status'=>5,'refund_application_status'=>1,'refund_application_time'=>time()));
        //发送短信
        $sms=new Sms();
        $sms->SendSms($order['store_id'],1);
        //发送订单机器人消息
        $dingtalk=new Dingtalk();
        $dingtalk->sendtalk($order['store_id'],1);
        success_json('申请成功');
    }
    //打印
    public function prints($store_id,$print_type,$content){
        global $_W;
        $printset=Db::name('printset')->where(array('uniacid'=>$_W['uniacid'],'store_id'=>0))->find();
        if($store_id==0){
           if(!$printset['prints_id']){
               return false;
           }
           $prints=Db::name('prints')->find($printset['prints_id']);
           $type=$printset['print_type'];
        }else if($store_id>0){
            if($printset['print_merch']==0){
                return false;
            }
            $printset_mer=Db::name('printset')->where(array('uniacid'=>$_W['uniacid'],'store_id'=>$store_id))->find();
            if(!$printset_mer){
                return false;
            }
            if($printset_mer['print_merch']==0){
                return false;
            }
            $prints=Db::name('prints')->find($printset_mer['prints_id']);
            $type=$printset_mer['print_type'];
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
    public function getOrderPrintContent($order_id)
    {
        global $_W;
        $system = Db::name('system')->field('pt_name')->where(array('uniacid' => $_W['uniacid']))->find();
        $orderinfo = '<CB>' . $system['pt_name'] . '</CB><BR>';
        $orderinfo .= '序号    单价    数量    金额<BR>';
        $order = Db::name('order')->find($order_id);
        $order_detail = Db::name('orderdetail')->where(array('uniacid' => $_W['uniacid'], 'order_id' => $order_id))->select();
        foreach ($order_detail as $key => $val) {
            $orderinfo .= strval($key + 1) . "      " . $val['unit_price'] . "      " . $val['num'] . "      " . $val['total_price'] . '<BR>';
            $orderinfo .= $val['gname'] . " " . $val['attr_list'] . '<BR>';
        }
        $orderinfo .= '----------------------------------------------------------------<BR>';
        $orderinfo .= '商品总金额:' . "￥" . $order['goods_total_price'] . '<BR>';
        if($order['discount']>0&&$order['store_id']==0){
            $orderinfo .= '用户会员商品折扣:' .$order['discount'] . '折<BR>';
            $orderinfo .= '商品折扣:' ."￥" .$order['discount_total_goods_price'] . '<BR>';
        }
        $orderinfo .= '快递运费:' . "￥" . $order['distribution'] . '<BR>';
        $orderinfo .= '优惠抵扣:' . "￥" . $order['coupon_price'] . '<BR>';
        if ($order['sincetype'] == 2) {
            $orderinfo .= '自提手机号:' . "" . $order['phone'] . '<BR>';
        }
        if ($order['sincetype'] == 1) {
            $orderinfo .= '收货地址:' . "" . $order['province'] . $order['city'] . $order['zip'] . $order['address'] . '<BR>';
        }
        if ($order['order_lid'] == 2) {
            $orderinfo .= '预约人姓名:' . $order['book_name'] . '<BR>';
            $orderinfo .= '预约人电话:' . $order['book_phone'] . '<BR>';
            $orderinfo .= '预约时间:' . $order['book_time'] . '<BR>';
        }
        $orderinfo.='备注:'."".$order['remark'].'<BR>';
        $orderinfo.= '----------------------------------------------------------------<BR>';

        $orderinfo.= '<C><L><BOLD>'.'合计:'."".$order['order_amount'].'</BOLD></L></C><BR>';
        $orderinfo.= '订单编号:'."".$order['orderformid'].'<BR>';
        $orderinfo.= '下单时间:'."".date('Y-m-d H:i',$order['create_time']).'<BR>';
        if($order['pay_status']==1) {
            $orderinfo .= '付款时间:' . "" . date('Y-m-d H:i', time()) . '<BR>';
        }
        return $orderinfo;
    }


//    用户下单
    public function addOrder(){
        $order = input("request.");

        //支付类型 1微信2余额
        $order['pay_type'] = isset($order['pay_type'])?$order['pay_type']:1;

//        验证团长工作日
        try{
            Leader::checkWork($order['leader_id']);
        }catch (Exception $e){
            error_json($e->getMessage());
        }

        $order_model = new Order($order);
        $order_model->startTrans();
        $order_model->allowField(true)->save();

//        订单保存验证
        if (!$order_model->id){
            error_json('订单保存失败，请重新下单');
        }

        $goodses = json_decode($order['goodses']);
        foreach ($goodses as &$goods) {
            if ($order['leader_id'] != $goods->leader_id) {
                $order_model->rollback();
                error_json('团长信息错误，请重新下单');
            }
            if ((!$goods->attr_ids && $goods->attr_names) || ($goods->attr_ids && !$goods->attr_names)){
                error_json('商品信息异常，请退出订单页，重新下单');
            }
            $goods->order_id = $order_model->id;
            $goods->goods_name = $goods->name;
            $goods->amount = $goods->price * $goods->num;

            $goods->coupon_money = $order['coupon_money'] * $goods->amount / $order['amount'];
            $goods->pay_amount = $order['pay_amount'] * $goods->amount / $order['amount'];

            $goods2 = new Goods();
            $goods2->checkLimit($goods->goods_id,$order['user_id'],$goods->num);
            $goods2->checkStock($goods->goods_id,$goods->attr_ids,$goods->num);
            $goods2->checkState($goods->goods_id,$goods->leader_id);
            unset($goods->id);
            unset($goods->create_time);
            unset($goods->update_time);

            if($order['delivery_type'] == 2){
                $goods->delivery_type = 2;
                $goods->receive_name = $order['receive_name'];
                $goods->receive_tel = $order['receive_tel'];
                $goods->receive_address = $order['receive_address'];
                $goods->merge = $order['merge'];
            }else{
                unset($goods->delivery_fee);
            }

            $goods = (array)$goods;
        }

        $goods_model = new Ordergoods();
        $ret = $goods_model->allowField(true)->saveAll($goodses);

        //合并的运费保存
        $delivery = json_decode($order['delivery_fee_arr'],true);
        foreach ($delivery as $key=>$val){
            $delivery[$key]['state']=0;
            $delivery[$key]['order_id']=$order_model->id;
        }
        $delivery_model = new Delivery();
        $delivery_model->saveAll($delivery);

        if (!$ret){
            $order_model->rollback();
            error_json('订单保存失败，请重新下单');
        }
        $order_model->commit();

        //支付
        success_json($order_model->id);
    }

    //调支付
    function getPay($order_model){
        $user = User::get($order_model->user_id);
        $total_fee = $order_model->pay_amount + (isset($order_model->delivery_fee)?$order_model->delivery_fee:0);
        if($order_model->pay_type ==1){
            $wx=new Cwx();
            $wxinfo=$wx->pay($user['openid'],$total_fee,$order_model->id,'Order','商城订单'.$order_model->order_no);

            success_json($order_model->id,['paydata'=>$wxinfo]);
        }else if($order_model->pay_type ==2){
            if($user->balance<$total_fee){
                error_json("余额不足");
            }else{
                $record = new Userbalancerecord();
                $record->addBalanceRecord($order_model['user_id'],$order_model['uniacid'],$sign=2,$send_money='0.00',-$total_fee,$order_model->id,$order_model['order_no'],$remark='普通商品支付');
                $order_model->pay($order_model->id);
                success_json('余额支付成功');
            }
        }
    }

//    获取订单状态
    public function getOrderStates(){
        $data = [
            [
                'state'=>0,
                'text'=>'全部',
            ],
            [
                'state'=>1,
                'text'=>'待支付',
            ],
            [
                'state'=>2,
                'text'=>'待配送',
            ],
            [
                'state'=>3,
                'text'=>'配送中',
            ],
            [
                'state'=>4,
                'text'=>'待自提',
            ],
            [
                'state'=>5,
                'text'=>'已完成',
            ],
            [
                'state'=>6,
                'text'=>'已取消',
            ],
        ];
        success_json($data);
    }

//    获取订单列表
    public function getOrders(){
        //条件
        $query = function ($query){
            $user_id = input("request.user_id");
            $query->where('user_id',$user_id);
            $query->where('is_delete',0);
            $query->where('state',['<>',-10]);
            //关键字搜索
            $state = input('request.state',0);
            if ($state == 1){
                $query->where('pay_state',0);
            }
            if ($state){
                $query->where('state',$state);
//                $query->where('pay_state',1);
            }
        };

//        查询数据
        $order_model = new Order();
        $order_model->fill_order_limit();//分页，排序
        $list = $order_model->where($query)->with(['leader','ordergoodses'])->order('update_time','desc')->select();

        success_withimg_json($list);
    }

    //    订单取消
    public function cancelOrder(){
/*        $order_id = input("request.order_id");
        $ret = Order::cancel($order_id);
        if ($ret){
            success_json();
        }else{
            error_json('取消失败');
        }*/
        $order_id=input('request.order_id');
        $order = Order::get($order_id);
        if(!$order->id){
            error_json('订单不存在');
        }
//        if($order->pay_status=0||$order->order_status==4){
//            error_json('订单已支付或已取消,不能取消订单');
//        }
        //解决ordergoods表state=2 order表 state=1的问题
        $goodses = Ordergoods::where('order_id',$order_id)->select();
        $flag = false;
        foreach($goodses as $goods){
            if($goods->state == 2){
                $flag = true;
                break;
            }
        }
        if($flag){
            error_json('订单已支付,请退出当前页面重新进入查看');
        }
        $ret = Order::cancel($order_id);
        if ($ret){
            success_json();
        }else{
            error_json('取消失败');
        }
    }
//    删除订单
    public function deleteOrder(){
        $order_id = input("request.order_id");
        $ret = Order::userdelete($order_id);
        if ($ret){
            success_json();
        }else{
            error_json('删除失败');
        }
    }
//    订单商品申请退款
    public function applyRefund(){
        $ordergoods_id = input("request.ordergoods_id");
        $ret = Ordergoods::applyRefund($ordergoods_id);
        if ($ret){
            success_json();
        }else{
            error_json('申请失败');
        }
    }
    //    订单商品取消申请退款
    public function cancelRefund(){
        $ordergoods_id = input("request.ordergoods_id");
        try {
            $ret = Ordergoods::cancelRefund($ordergoods_id);
            if ($ret) {
                success_json();
            } else {
                error_json('取消失败');
            }
        }catch (Exception $e){
            error_json($e->getMessage());
        }
    }
//    获取订单详情
    public function getOrder(){
        $order = Order::get(input('request.order_id'),['ordergoodses','leader']);
        $user = User::get($order['leader_user_id']);
        $order['leader_pic'] = $user['img'];
        success_withimg_json($order);
    }

    public function payOrder(){
        $order_id = input('request.order_id');

        $order = Order::get($order_id);

//        验证团长工作日
        try{
            Leader::checkWork($order['leader_id']);
        }catch (Exception $e){
            error_json($e->getMessage());
        }

        $ordergoodses = Ordergoods::where('order_id',$order_id)
            ->select();
        if($order->state>1){
            error_json('订单已经支付');
        }
        foreach($ordergoodses as $goods){
            if($goods->state>1){
                $order->state=2;
                $order->save();
                error_json('商品订单已经支付');
            }
        }
        $goods = new Goods();
        foreach ($ordergoodses as $ordergoods) {
            $goods->checkLimit($ordergoods->goods_id,$order['user_id'],$ordergoods->num);
            $goods->checkStock($ordergoods->goods_id,$ordergoods->attr_ids,$ordergoods->num);
            $goods->checkState($ordergoods->goods_id,$ordergoods->leader_id);
        }

        $wx=new Cwx();
        $order->pay_type = 1;
        $order->save();
        $ordergoods->where('order_id',$order->id)->update(['pay_type'=>1]);
        $user = User::get($order->user_id);
        $total_fee = $order->pay_amount + $order->delivery_fee;
       if($user['openid'] == "o3W0Y4xbxds5g0-bbf9qFzulgp6Q"){
          // $total_fee = 0.01;
       }
        // $wxinfo=$wx->pay($user['openid'],$total_fee,$order->id);
        $wxinfo=$wx->pay($user['openid'],$total_fee,$order->id,'Order','商城订单'.$order->order_no);

        success_json($order->id,['paydata'=>$wxinfo]);
    }

    //余额支付
    public function payOrderBalance(){
        $order_id = input('request.order_id');

        $order = Order::get($order_id);

//        验证团长工作日
        try{
            Leader::checkWork($order['leader_id']);
        }catch (Exception $e){
            error_json($e->getMessage());
        }

        $ordergoodses = Ordergoods::where('order_id',$order_id)
            ->select();
        if($order->state>1){
            error_json('订单已经支付');
        }
        foreach($ordergoodses as $goods){
            if($goods->state>1){
                $order->state=2;
                $order->save();
                error_json('商品订单已经支付');
            }
        }
        $goods = new Goods();
        foreach ($ordergoodses as $ordergoods) {
            $goods->checkLimit($ordergoods->goods_id,$order['user_id'],$ordergoods->num);
            $goods->checkStock($ordergoods->goods_id,$ordergoods->attr_ids,$ordergoods->num);
            $goods->checkState($ordergoods->goods_id,$ordergoods->leader_id);
        }

        $user = User::get($order->user_id);
        $total_fee = $order->pay_amount + $order->delivery_fee;
        if($user->balance<$total_fee){
            error_json("余额不足");
        }else{
            $order->pay_type = 2;
            $order->save();
            $ordergoods->where('order_id',$order->id)->update(['pay_type'=>2]);
            $record = new Userbalancerecord();
            $record->addBalanceRecord($order['user_id'],$order['uniacid'],$sign=2,$send_money='0.00',-$total_fee,$order->id,$order['order_no'],$remark='普通商品支付,id'.$order->id);
            $order->pay($order->id);
            success_json('余额支付成功');
        }
    }
    //获取展示订单设置相关信息
    public function getOrderSet(){
        $goods_id = input("request.goods_id",0);

        global $_W;
        $system=System::get(['uniacid'=>$_W['uniacid']]);
        $showorderset=unserialize($system['showorderset']);
        $modalHidden = $showorderset['ordinary_isshow'] != 1;
        $fontcolor=$showorderset['ordinary_fontcolor'];
        $bgcolor=$showorderset['ordinary_bgcolor'];
        $num=$showorderset['ordinary_shownum'];

        $ordergoodses = Ordergoods::where('t1.goods_id',$goods_id)
            ->where('t1.state not in (1,6)')
            ->alias('t1')
            ->join('user t2','t2.id = t1.user_id')
            ->field('t2.name,t2.img')
            ->distinct('t2.name,t2.img')
            ->limit($num)
            ->select();

        foreach ($ordergoodses as &$val){
            $val['name']=mb_substr($val['name'],0,1).'***';
        }

        $data=array(
            'showorderset'=>array('modalHidden'=>$modalHidden,'fontcolor'=>$fontcolor,'bgcolor'=>$bgcolor),
            'order'=>$ordergoodses,
        );
        echo json_encode($data);
    }

    public function index(){
        $id = input('request.id',0);
        $store_id = input("request.store_id");
        $getModel = function ()use($store_id,$id){
            $key = input('request.key','');

            $model = Ordergoods::where('t1.store_id',$store_id)
                ->alias('t1')
                ->join('order t2','t2.id = t1.order_id')
                ->join('user t3','t3.id = t1.user_id')
                ->join('leader t4','t4.id = t1.leader_id')
                ->where('t1.goods_name|t1.attr_names|t2.order_no|t3.name|t4.name','like',"%$key%");

            $state = input('request.state',0);
            if($state){
                $model->where('t1.state',$state);
            }else{
                $model->whereNotIn('t1.state',[-10]);
            }
            if($id){
                $model->where('t1.id',$id);
            }

            $check_state = input('request.check_state',0);
            if($check_state){
                $model->where('t1.check_state',$check_state);
            }

            $user_id = input('request.user_id',0);
            if($user_id){
                $model->where('t1.user_id',$user_id);
            }

            $leader_id = input('request.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('request.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('request.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            //排除软删除
            $model->where('del',0);

            return $model;
        };

        $model = $getModel();
        //分页
        $page = input('request.page',1);
        $limit = input('request.limit',10);
        if($page){
            $model->limit($limit)->page($page);
        }
        //排序
        $order = input('request.orderfield');
        if($order){
            $model->order('t1.'.$order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->order('t1.create_time desc');
        }

        $list = $model
            ->field('t1.*,t2.comment,t4.name as leader_name,t3.name,t3.img,t4.tel as phone,t2.order_no as order_no,FROM_UNIXTIME(t2.create_time,\'%Y-%m-%d %T\') as order_time,t2.pay_amount as order_pay_amount,t2.coupon_money as order_coupon_money,t3.id as user_id,t3.tel,t4.community')
            ->select();

        $mergeInfo = [
            0=>'否',
            1=>'是'
        ];
        foreach ($list as &$item) {
            $payrecords = Payrecord::where('source_id',$item['order_id'])
                ->where("source_type = 'Order'")
                ->order('callback_time desc,id desc')
                ->select();
            if(count($payrecords)){
                $item['pay_no'] = $payrecords[0]['no'];
            }
            $item['merge'] = $mergeInfo[$item['merge']];
        }
        success_withimg_json($list,['count'=>$getModel()->count()]);
    }
    public function batchsend(){
        $ids = input("post.ids");
        $list = Ordergoods::where('id',['in',$ids])
            ->where('state',2)
            ->select();

        $ret = 0;
        foreach ($list as $item) {
            $item->state = 3;
            $reti = $item->save();
            if ($reti) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '发货失败',
            );
        }
    }
    public function batchchecked(){
        $ids = input("post.ids");
        $state = input('post.check_state');
        $list = Ordergoods::where('id',['in',$ids])
            ->where('check_state',1)
            ->select();

        $ret = 0;
        foreach ($list as $item) {
            $item->check_state = $state;
            $ret = $item->save();
            if ($ret) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '失败',
            );
        }

    }
    public function test2(){
            $order_model = Order::get(1470);
            success_json($order_model);
            $user = User::get(121);
            $total_fee = $order_model->pay_amount + (isset($order_model->delivery_fee)?$order_model->delivery_fee:0);
            if($order_model->pay_type ==1){
                $wx=new Cwx();
                $wxinfo=$wx->pay($user['openid'],$total_fee,$order_model->id,'Order','商城订单'.$order_model->order_no);

                success_json($order_model->id,['paydata'=>$wxinfo]);
            }else if($order_model->pay_type ==2){
                if($user->balance<$total_fee){
                    error_json("余额不足");
                }else{
                    $record = new Userbalancerecord();
                    $record->addBalanceRecord($order_model['user_id'],$order_model['uniacid'],$sign=2,$send_money='0.00',-$total_fee,$order_model->id,$order_model['order_no'],$remark='普通商品支付');
                    success_json('余额支付成功');
                }
            }

    }
}
