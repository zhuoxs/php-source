<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 15:04
 */

namespace app\api\controller;

use app\model\Ad;
use app\model\Goods;
use app\model\Integralcategory;
use app\model\Integralconf;
use app\model\Integralgoods;
use app\model\Integralorder;
use app\model\Integralrecord;
use app\model\Order;
use app\model\Postagerules;
use app\model\Shop;
use app\model\User;
use think\Db;

class ApiIntegral extends Api{
    /**
     * 我的积分
    */
    public function myInteral(){
        $user_id=input('post.user_id');
        if($user_id>0){
            $user=new User();
            $info['user']=$user->mfind(['id'=>$user_id],'id,now_integral,integral');
            $conf=new Integralconf();
            $info['conf']=$conf->get_curr();
            return_json('success',0,$info);
        }else{
            return_json('user_id不能为空',1);
        }
    }
    /**
     * 我的积分记录
    */
    public function integralRecord(){
        global $_W;
        $user_id=input('post.user_id');
        if($user_id>0){
            $page = input('post.page', 1);
            $length = input('post.length', 10);
            $type=input('post.type',1);
            $where['user_id']=$user_id;
            $where['type']=$type;
            $where['uniacid']=$_W['uniacid'];
            $order['create_time']='desc';
            $rec=new Integralrecord();
            $list=$rec->mlist($where,$order,$page,$length);
            foreach ($list as $key=>$val){
                if($val['type']==1){
                    $good=new Goods();
                }elseif ($val['type']==2){
                    $good=new Integralgoods();
                }
                $goodsinfo=$good->mfind(['id'=>$val['goods_id']],'name');
                $list[$key]['goods_name']=$goodsinfo['name'];
            }
            return_json('success',0,$list);
        }else{
            return_json('user_id不能为空',1);
        }
    }
    /**
     * 积分商品分类
    */
    public function category(){
        global $_W;
        $cate=new Integralcategory();
        $list=$cate->where(['uniacid'=>$_W['uniacid'],'state'=>1])->order(['sort'=>'asc'])->select();
        return_json('success',0,$list);
    }
    /**
     * 商品列表
    */
    public function goodslist(){
        global $_W;
        $goods=new Integralgoods();
        $cat_id=input('post.cat_id');
        if($cat_id>0){
            $where['cat_id']=$cat_id;
        }
        $where['is_del']=1;
        $where['state']=1;
        $where['uniacid']=$_W['uniacid'];
        $order['create_time']='desc';
        $page = input('post.page', 1);
        $length = input('post.length', 10);
        $list=$goods->mlist($where,$order,$page,$length);
        $imgroot['img_root'] = $_W['attachurl'];
        return_json('success',0,$list,$imgroot);
    }
    /**
     * 商品详情
    */
    public function goodsDetails(){
        global $_W;
        $goods=new Integralgoods();
        $where['is_del']=1;
        $where['state']=1;
        $where['id']=input('post.id');
        $info=$goods->mfind($where);
        if($info){
            $info['pics'] = json_decode($info['pics']);
            $imgroot['img_root'] = $_W['attachurl'];
            $order=new Integralorder();
            $info['my_buy_num']=$order->buyNum(input('post.user_id',0),$where['id']);
            return_json('success',0,$info,$imgroot);
        }else{
            return_json('商品不存在',1);
        }
    }
    /**
     * 下单
    */
    public function buy(){
        global $_W;
        $data['user_id']=input('post.user_id');
        if($data['user_id']>0){
            $user=new User();
            $userinfo=$user->mfind(['id'=>$data['user_id']]);
            $data['goods_id']=input('post.goods_id');
            $goods=new Integralgoods();
            $goodsinfo=$goods->mfind(['id'=>$data['goods_id']]);
            $order=new Integralorder();
            //判断购买上限
            $mynum=$order->buyNum($data['user_id'],$data['goods_id']);
            $data['total_num']=input('post.total_num');
//            var_dump($mynum ,$data['total_num']);exit;
            if($goodsinfo['limit_buy']==0 || (intval($mynum+$data['total_num'])<=$goodsinfo['limit_buy'])){
                $data['total_integral']=ceil($data['total_num']*$goodsinfo['intergral']);
                //判断库存、积分够不够
                if($data['total_num']<=$goodsinfo['num']){
                    if($data['total_integral']<=$userinfo['now_integral']){
                        //添加订单记录
                        $data['store_id']=input('post.store_id',0);
                        $data['order_amount']=input('post.order_amount',0);
                        $data['sincetype']=input('post.sincetype',1);
                        $data['distribution']=input('post.distribution',0);
                        $data['name']=input('post.name');
                        $data['phone']=input('post.phone');
                        $data['province']=input('post.province');
                        $data['city']=input('post.city');
                        $data['area']=input('post.area');
                        $data['address']=input('post.address');
                        $data['remark']=input('post.remark');
                        $data['prepay_id']=input('post.prepay_id');
                        $data['dh_time']=time();
                        $data['out_trade_no']=date('YmdHis') . substr('' . time(), -4, 4);
                        $ret = $order->allowField(true)->save($data);
                        if($ret){
                            $oid=$order->id;
                            //减库存、加销量
                            if($goodsinfo['num_type']==1){
                                $goods->actNum($data['goods_id'],$data['total_num']);
                            }
                            //需运费 ---》调支付
                            if($data['distribution']>0){
                                $wx=new Cwx();
                                $attach=json_encode(array('oid'=>$oid,'type'=>'integral','uniacid'=>$_W['uniacid']));
                                $payinfo=$wx->pay($userinfo['openid'],sprintf("%.2f",$data['distribution']),$attach,'积分商城消费');
                                $order->allowField(true)->save(['prepay_id'=>$payinfo['prepay_id']],['id'=>$oid]);
                                return_json('调支付',0,$payinfo,['oid'=>$oid]);
                            }else{
                                //免运费---》下单成功
                                $pay=$order->orderPay($oid);
                                if($pay==1){
                                    return_json('success',0,0);
                                }else{
                                    return_json('下单失败',1);
                                }
                            }
                        }
                    }else{
                        return_json('积分不足无法下单',1);
                    }
                }else{
                    return_json('库存不足',1,$data['total_num'].'---'.$goodsinfo['num']);
                }
            }else{
                return_json('您的兑换次数已达上限',1);
            }
        }else{
            return_json('user_id不能为空',1);
        }
    }
    /**
     * 查询运费
    */
    public function getDistribution(){
        global $_W;
        $goods_id=input('post.goods_id');
        $province=input('post.province');
        $city=input('post.city');
        $area=input('post.area');
        $number=input('post.num');

//        积分商品
        $integralgoods = Integralgoods::get($goods_id);
//        1、没有选择运费规则 : 运费为0
        if (!$integralgoods->postagerules_id){
            $data['distribution']=0;
            success_json($data);
        }

//        运费规则
        $postagerules = Postagerules::get($integralgoods->postagerules_id);
//        2、运费规则被禁用 ： 运费为0
        if (!$postagerules->state){
            $data['distribution']=0;
            success_json($data);
        }

//        运费规则条目
        $postage_items = json_decode($postagerules->detail);

//        注：省、市都没有重复的，区县有重复
//        当前运费只是根据省市来计算，可以先用文本匹配，
//        todo 如果以后要根据区计算运费，需要改为根据 id 匹配运费

//        匹配规则条目
        $item = null;
        foreach ($postage_items as $postage_item) {
            if(strstr($postage_item->detail,$province) !== false){
                $item = $postage_item;
                break;
            }
            if(strstr($postage_item->detail,$city) !== false){
                $item = $postage_item;
                break;
            }
        }
//        3、找不到符合的规则条目 : 运费为0
        if (!$item){
            $data['distribution']=0;
            success_json($data);
        }

        $count = $number;
//        如果以重量计算运费，则在数量上乘以商品重量
        if($postagerules->type == 2){
            $count = $count*$integralgoods->weight;
        }

        $data['distribution'] = $item->first_price;
        if ($count > $item->first_count){
            $data['distribution'] += ceil(($count - $item->first_count)/$item->next_count)*$item->next_price;
        }

        success_json($data);
    }
    /**
     * 查自提门店
    */
    public function getShop(){
        global $_W;
        $shop=new Shop();
        $li=$shop->where(['is_del'=>0,'store_id'=>0,'uniacid'=>$_W['uniacid']])->select();
        $list=json_decode(json_encode($li),true);
        return_json('success',0,$list);
    }
    /**
     * 订单列表
    */
    public function orderList(){
        global $_W;
        $order=new Integralorder();
        $user_id=input('post.user_id');
        if($user_id>0){
            $where['user_id']=$user_id;
            $type=input('post.type',0);
            //订单状态order_status 0未付款 1待发货  2待确认收货 3已完成
            if($type==1){
                $where['order_status']=0;
            }elseif ($type==2){
                $where['order_status']=[['egt',1],['elt',2]];
            }elseif($type==3){
                $where['order_status']=3;
            }
            $where['uniacid']=$_W['uniacid'];
            $where['is_show']=1;
            $sort['dh_time']='desc';
            $page = input('post.page', 1);
            $length = input('post.length', 10);
            $list=$order->mlist($where,$sort,$page,$length);
            foreach ($list as $key=>$value){
                $goods=new Integralgoods();
                $list[$key]['goodsinfo']=$goods->mfind(['id'=>$value['goods_id']]);
            }
            $imgroot['img_root'] = $_W['attachurl'];
            return_json('success',0,$list,$imgroot);
        }else{
            return_json('user_id不能为空',1);
        }
    }
    /**
     * 订单详情
    */
    public function orderDetails(){
        global $_W;
        $order=new Integralorder();
        $oid=input('post.oid');
        $info=$order->mfind(['id'=>$oid]);
        $info['dh_time']=date('Y-m-d H:i:s',$info['dh_time']);
        $goods=new Integralgoods();
        $info['goodsinfo']=$goods->mfind(['id'=>$info['goods_id']]);
        $imgroot['img_root'] = $_W['attachurl'];
        return_json('success',0,$info,$imgroot);
    }
    /**
     * 取消订单
    */
    public function cancelOrder(){
        $oid=input('post.oid');
        $order=new Integralorder();
        $orderinfo=$order->get_orderinfo($oid);
        if($orderinfo['pay_status']==1){
            return_json('订单已支付，无法取消',1);
        }
        $goods_id=input('post.goods_id');
        $goods=new Integralgoods();
        $goodsinfo=$goods->get_info($goods_id);
        if($goodsinfo['num_type']==1){
            //返回库存、销量
            $goods->where('id',$goods_id)->setInc('num',$orderinfo['total_num']);
            $goods->where('id',$goods_id)->setDec('sales_numxn',$orderinfo['total_num']);
            $goods->where('id',$goods_id)->setDec('sales_num',$orderinfo['total_num']);
        }
        $res=$order->where('id',$oid)->delete();
        if($res){
            return_json('取消成功',0);
        }else{
            return_json('取消失败',1);
        }
    }
    /**
     * 确认收货
    */
    public function checkGet(){
        $oid=input('post.oid');
        $order=new Integralorder();
        $orderinfo=$order->get_orderinfo($oid);
        if($orderinfo['order_status']==2){
            $data['order_status']=3;
            $data['queren_time']=time();
            $res=$order->allowField(true)->save($data,['id'=>$oid]);
            if($res){
                return_json('确认收货成功',0);
            }else{
                return_json('失败',1);
            }
        }else{
            return_json('订单还未发货',1);
        }

    }
    /**
     * 删除订单
     */
    public function delOrd(){
        $oid=input('post.oid');
        $order=new Integralorder();
        $orderinfo=$order->get_orderinfo($oid);
        if($orderinfo['order_status']==3){
            $data['is_show']=0;
            $res=$order->allowField(true)->save($data,['id'=>$oid]);
            if($res){
                return_json('删除成功',0);
            }else{
                return_json('删除失败',1);
            }
        }else{
            return_json('订单还未完成，无法删除',1);
        }

    }
    /**
     * 重新调支付
    */
    public function againPay(){
        global $_W;
        $oid=input('post.oid');
        $order=new Integralorder();
        $orderinfo=$order->get_orderinfo($oid);
        $goods_id=input('post.goods_id');
        $goods=new Integralgoods();
        $goodsinfo=$goods->get_info($goods_id);
        $user=new User();
        $userinfo=$user->mfind(['id'=>input('post.user_id')]);
        if($goodsinfo['num_type']==1){
            $wx=new Cwx();
            $attach=json_encode(array('oid'=>$oid,'type'=>'integral','uniacid'=>$_W['uniacid']));
            $payinfo=$wx->pay($userinfo['openid'],sprintf("%.2f",$orderinfo['distribution']),$attach,'积分商城消费');
            $order->allowField(true)->save(['prepay_id'=>$payinfo['prepay_id']],['id'=>$oid]);
            return_json('调支付',0,$payinfo);
        }else{
            //判断库存、积分够不够
            if($orderinfo['total_num']<=$goodsinfo['num']){
                if($orderinfo['total_integral']<=$userinfo['now_integral']){
                    $wx=new Cwx();
                    $attach=json_encode(array('oid'=>$oid,'type'=>'integral'));
                    $payinfo=$wx->pay($userinfo['openid'],sprintf("%.2f",$orderinfo['distribution']),$attach,'积分商城消费');
                    $order->allowField(true)->save(['prepay_id'=>$payinfo['prepay_id']],['id'=>$oid]);
                    return_json('调支付',0,$payinfo,['oid'=>$oid]);
                }else{
                    return_json('积分不足',1);
                }
            }else{
                return_json('库存不足',1);
            }
        }
    }
    /**
     * 零钱支付
    */
    public  function balancePay(){
        $oid=input('post.oid');
        $order=new Integralorder();
        $orderinfo=$order->get_orderinfo($oid);
        $user=new User();
        $userinfo=$user->mfind(['id'=>$orderinfo['user_id']],'balance,now_integral');
        if($orderinfo['order_amount']<=$userinfo['balance']){
            $goods=new Integralgoods();
            $goodsinfo=$goods->get_info($orderinfo['goods_id']);
            if($goodsinfo['num_type']==2){
                if($orderinfo['total_num']>$goodsinfo['num']){
                    return_json('库存不足',1);
                }
                if($orderinfo['total_integral']>$userinfo['now_integral']){
                    return_json('积分不足',1);
                }
            }
            $pay=$order->moneyPay($oid);
            if($pay==1){
                return_json('支付成功',0,0);
            }else{
                return_json('支付失败',1);
            }
        }else{
            return_json('余额不足，无法支付',1);
        }
    }
    /**
     * 积分设置
    */
    public function integralSet(){
        global $_W;
        $conf=new Integralconf();
        $info=$conf->get_curr();
        $info['banner'] = json_decode($info['banner']);
        $imgroot['img_root'] = $_W['attachurl'];
        return_json('success',0,$info,$imgroot);
    }
    /**
     * 积分商城轮播图
    */
    public function bannerPic(){
        global $_W;
        $ad=new Ad();
        $where['state']=1;
        $where['type']=4;
        $where['uniacid']=$_W['uniacid'];
        $banner=$ad->mlist($where,array('index'=>'asc'));
        $imgroot['img_root'] = $_W['attachurl'];
        return_json('success',0,$banner,$imgroot);
    }
}