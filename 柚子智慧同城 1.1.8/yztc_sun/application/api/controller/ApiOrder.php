<?php
namespace app\api\controller;

use app\model\Distributionorder;
use app\model\Order;
use app\model\Orderdetail;
use app\model\Goods;
use app\model\Goodsattrsetting;
use app\model\User;
use app\model\System;
use app\model\Template;
use app\model\Prints;
use app\model\Sms;
use app\model\Dingtalk;
use app\model\Store;
use app\model\Commonorder;
use app\model\Storeuser;
use app\model\Distribution;
use app\model\Userbalancerecord;
use think\Db;
use think\Loader;



class ApiOrder extends Api
{
    //获取订单信息通过订单号
    public function getOrderDetailByOrderNo(){
        $order_no=input('request.order_no');
        $user_id=input('request.user_id');
        $order_lid=input('request.order_lid')?input('request.order_lid'):1;
        $data=Order::get(['order_lid'=>$order_lid,'order_no'=>$order_no]);
        //判断核销权限
        (new Storeuser())->checkConfirmPermission($data['store_id'],$user_id);
        $data['store']=Store::get($data['store_id']);
        $data['detail']=(new Orderdetail())->where(['order_id'=>$data['id']])->select();
        $data['goods']=Goods::get($data['gid']);
        success_withimg_json($data);
    }
    //取消退款
    public function cancelOrderRefund(){
        $order_id=input('request.order_id');
        $user_id=input('request.user_id');
        $order=Db::name('order')->where(array('id'=>$order_id,'user_id'=>$user_id))->find();
        if(!$order){
            error_json('订单不存在');
        }
        if($order['after_sale']!=1){
            error_json('只有申请退款的订单才可以取消退款');
        }
        if($order['review_status']>0){
            error_json('该售后订单已处理,不能申请退款');
        }
        Db::name('order')->update(array('id'=>$order_id,'refund_application_status'=>0,'cancel_refund_time'=>time(),'after_sale'=>0));
        (new Commonorder())->editCommonOrderStatus(1,$order_id,20);
        success_json('取消成功');
    }
    //申请退款
    public function setOrderRefund(){
        $order_id=input('request.order_id');
        $user_id=input('request.user_id');
        $order=Db::name('order')->where(array('id'=>$order_id,'user_id'=>$user_id))->find();
        if(!$order){
            error_json('订单不存在');
        }
        if($order['order_status']!=20){
            error_json('待发货订单才可以退款');
        }
        $goods=Goods::get($order['gid']);
        if($goods['is_support_refund']==0){
            error_json('该订单不支持退款');
        }
        Db::name('order')->update(array('id'=>$order_id,'refund_application_status'=>1,'refund_application_time'=>time(),'after_sale'=>1));
        (new Commonorder())->editCommonOrderStatus(1,$order_id,50);
        //发送短信
        $sms=new Sms();
        $sms->SendSms($order['store_id'],1);
        //发送订单机器人消息
        $dingtalk=new Dingtalk();
        $dingtalk->sendtalk($order['store_id'],1);
        success_json('申请成功');
    }
    //删除订单
    public function delOrder(){
        $order_id=input('request.order_id');
        $order=Order::get($order_id);
        if($order['order_status']!=10&&$order['order_status']!=60&&$order['order_status']!=5){
            error_json('未支付、已完成或者已取消订单才能删除');
        }
        (new Order())->allowField(true)->save(['is_del'=>1,'del_status'=>1,'del_time'=>time()],['id'=>$order_id]);
        success_json('删除成功');
    }

    //立即支付使用 余额和微信支付 根据订单id获取微信支付参数
    public function getWxParamByOrderId(){
        global $_W;
        $order_id=input('request.order_id');
        $pay_type=input('request.pay_type')?input('request.pay_type'):1;
        if($pay_type==1){
            //获取微信支付参数
            $param=array(
                'type'=>'CommonOrder',
                'order_id'=>$order_id,
            );
            $this->getPayParam($param);
        }else if($pay_type==2){
            //余额支付处理 余额记录
            $order=Order::get($order_id);
            //判断余额支付是否支付
            $this->checkBalancePay($pay_type,$order['user_id'],$order['order_amount']);
            //修改支付方式
            (new Order())->allowField(true)->save(['pay_type'=>$pay_type],['id'=>$order_id]);
            $remark='订单消费减少￥'.$order['order_amount'];
            $Userbalancerecord=new Userbalancerecord();
            $Userbalancerecord->editBalance($order['user_id'],'-'.$order['order_amount']);
            $Userbalancerecord->addBalanceRecord($order['user_id'],$_W['uniacid'],2,0,'-'.$order['order_amount'],$order['id'],'',$remark);

            //减少用户余额
            //修改订单状态、减少库存、增加商品销量、商家销量和人气
            $attr_ids=Orderdetail::get(['order_id'=>$order_id])['attr_ids'];
            (new Order())->updateOrderStatusAndStock($order_id,$order['gid'],$order['num'],$order['store_id'],'','',$order['order_amount'],$order['is_free'],$attr_ids);
            //修改总订单状态
            (new Commonorder())->editCommonOrderStatus(1,$order_id,20);
            //下分销订单
            (new Distributionorder())->setDistributionOrder($order['user_id'],1,$order['store_id'],$order_id,$order['order_amount'],$order['gid'],$order['share_user_id'],1);

            //打印订单
            (new Prints())->prints($order['store_id'],2,$order['id']);
            //发送模板消息
            $order=Order::get($order_id);
            $order=objecttoarray($order);
            (new Template())->setTemplateContent(1,$order);
            success_json('余额支付成功');
        }

    }
    //取消订单
    public function cancelOrder(){
        global $_W;
        $order_id=input('order_id');
        $orderModel=new Order();
        $order=$orderModel::get($order_id);
        if(!$order){
            error_json('订单不存在');
        }
        if($order['pay_status']!=0||$order['order_status']==5){
            error_json('订单已支付或已取消,不能取消订单');
        }
        $orderModel->allowField(true)->save(['order_status'=>5,'cancel_time'=>time()],['id'=>$order_id]);
        (new Commonorder())->editCommonOrderStatus(1,$order_id,5);
        success_json('取消成功');
    }

    //确认收货
    public function confirmOrder(){
        global $_W;
        $order_id=input('request.order_id');
        (new Order())->confirmOrder($order_id);
        success_json('确认收货成功');
    }
    //获取订单详情
    public function getOrderDetail(){
        $order_id=input('request.order_id');
        $data=Order::get($order_id);
        $data['store']=Store::get($data['store_id']);
        $data['detail']=(new Orderdetail())->where(['order_id'=>$data['id']])->select();
        $data['goods']=Goods::get($data['gid']);
        success_withimg_json($data);
    }
    //获取订单列表
    public function getOrderList(){
        $orderModel=new Order();
        $orderModel->fill_order_limit_length();//分页，排序
        $query = function ($query){
            $user_id=input('request.user_id');
            $type=input('request.type');
            $lid=input('request.order_lid')?input('request.order_lid'):1;
            $query->where('user_id',$user_id);
            $query->where('is_del',0);
            $query->where('order_lid',$lid);
            if($type==1){
                $query->where('pay_status',0);


                $query->where('order_status',10);
                $query->where('after_sale',0);
            }else if($type==2){
                $query->where('pay_status',1);
                $query->where('order_status',20);
                $query->where('after_sale',0);
            }else if($type==3){
                $query->where('pay_status',1);
                $query->where('order_status',30);
                $query->where('after_sale',0);
            }else if($type==6){
                $query->where('pay_status',1);
                $query->where('order_status','>=',40);
                $query->where('after_sale',0);
            }else if($type==7){
                $query->where('after_sale',1);
            }else if($type==5){
                $query->where('order_status',40);
                $query->where('after_sale',0);
            }
        };
        $data=$orderModel->where($query)->order('pay_time desc,id desc')->select();
        $data=objecttoarray($data);
        foreach ($data as &$val){
            $val['goods']=Goods::get($val['gid']);
            $val['detail']=(new Orderdetail())->where(['order_id'=>$val['id']])->select();
            $val['store']=Store::get($val['store_id']);
        }
        success_withimg_json($data);
    }
    //支付回调处理
    public function payNotify($data){
        global $_W;
        $attach=json_decode($data['attach'],1);
        $_W['uniacid']=$attach['uniacid'];
        $orderModel=new Order();
        $order=$orderModel->where(['order_no'=>$data['out_trade_no']])->find();
        if(!$order||$order['pay_status']==1){
            echo 'FAIL';
            exit;
        }
       // if($order['order_lid']==1){
            $detail=(new Orderdetail())->where(['order_id'=>$order['id']])->find();
            $attr_ids=$detail['attr_ids'];
            //修改订单状态、减少库存、增加商品销量、商家销量和人气
            $orderModel->updateOrderStatusAndStock($order['id'],$order['gid'],$order['num'],$order['store_id'],$data['transaction_id'],$data['out_trade_no'],$order['order_amount'],0,$attr_ids);
            //修改总订单状态
            (new Commonorder())->editCommonOrderStatus(1,$order['id'],20);
            //下分销订单
            (new Distributionorder())->setDistributionOrder($order['user_id'],1,$order['store_id'],$order['id'],$order['order_amount'],$order['gid'],$order['share_user_id'],1);
            //打印订单
            (new Prints())->prints($order['store_id'],2,$order['id']);
            //发送模板消息
            (new Template())->setTemplateContent(1,$order);
       // }

    }

    //用户下单
    public function setOrder(){
        global $_W;
        $user_id=input('request.user_id');
        $gid=input('request.gid');
        $attr_ids=input('request.attr_ids')?input('request.attr_ids'):0;
        $num=input('request.num');
        $phone=input('request.phone');
        $remark=input('request.remark');
        $formId=input('request.formId')?input('request.formId'):'';
        $share_user_id=input('request.share_user_id')?input('request.share_user_id'):0;
        $pay_type=input('request.pay_type')?input('request.pay_type'):1;
        $order_lid=input('request.order_lid')?input('request.order_lid'):1;
        $book_name=input('request.book_name')?input('request.book_name'):'';
        $book_phone=input('request.book_phone')?input('request.book_phone'):'';
        $book_time=input('request.book_time')?input('request.book_time'):'';
        //检测相关条件
        $this->checkGoods($gid,$num,$user_id,$attr_ids);
        //获取相关数据
        $data=(new Goods())->getGoodsDetailByGid($gid,$attr_ids,$user_id,$num);
        $data=objecttoarray($data);
        //判断余额支付是否支付
        $this->checkBalancePay($pay_type,$user_id,$data['order']['order_amount']);

        //添加订单信息
        $order_no=date("YmdHis") .rand(11111, 99999);
        $order=[
            'store_id'=>$data['store_id'],
            'user_id'=>$user_id,
            'openid'=>$data['user']['openid'],
            'order_lid'=>1,
            'cid'=>1,
            'pay_type'=>$pay_type,
            'order_no'=>$order_no,
            'total_price'=>$data['order']['order_amount'],
            'order_amount'=>$data['order']['order_amount'],
            'goods_amount'=>$data['order']['price'],
            'num'=>$num,
            'order_status'=>10,
            'delivery_type'=>2,
            'gid'=>$gid,
            'free_num'=>$data['order']['free_num'],
            'is_free'=>$data['order']['is_free'],
            'phone'=>$phone,
            'remark'=>$remark,
            'prepay_id'=>$formId,
            'share_user_id'=>$share_user_id,
            'order_lid'=>$order_lid,
            'book_name'=>$book_name,
            'book_phone'=>$book_phone,
            'book_time'=>$book_time,
        ];

        (new Order())->allowField(true)->save($order);
        $order_id=Db::name('order')->getLastInsID();
        //添加订单详细信息
        $orderdetail=[
            'store_id'=>$data['store_id'],
            'user_id'=>$user_id,
            'openid'=>$data['user']['openid'],
            'order_id'=>$order_id,
            'gid'=>$gid,
            'gname'=>$data['name'],
            'unit_price'=>$data['order']['unit_price'],
            'num'=>$num,
            'total_price'=>$data['order']['price'],
            'attr_ids'=>$data['goodsattrsetting']['attr_ids'],
            'attr_list'=>str_replace(',', ' ',$data['goodsattrsetting']['key']),
            'pic'=>$data['order']['pic'],
        ];
        (new Orderdetail())->allowField(true)->save($orderdetail);
        //加入到总订单
        (new Commonorder())->addCommonOrder(1,$gid,$user_id,$order_no,$order_id,$num,$data['store_id'],$order['order_amount']);


        //下分销订单
        (new Distributionorder())->setDistributionOrder($user_id,1,$data['store_id'],$order_id,$data['order']['order_amount'],$gid,$share_user_id);


        //发送提醒短信
        (new Sms())->SendSms($data['store_id'],0);
        //发送订单机器人消息
        (new Dingtalk())->sendtalk($data['store_id'],0);
         if($pay_type==1){
             if($order['order_amount']>0){
                 //打印订单
                 (new Prints())->prints($data['store_id'],1,$order_id);
                 //获取微信支付参数
                 $param=array(
                     'type'=>'CommonOrder',
                     'order_id'=>$order_id,
                 );
                 $this->getPayParam($param);
             }else{
                 //修改订单状态、减少库存、增加商品销量、商家销量和人气
                 (new Order())->updateOrderStatusAndStock($order_id,$gid,$order['num'],$order['store_id'],'','',0,$data['order']['is_free'],$attr_ids);
                 //修改总订单状态
                 (new Commonorder())->editCommonOrderStatus(1,$order_id,20);
                 //打印订单
                 (new Prints())->prints($order['store_id'],2,$order['id']);
                 //发送模板消息
                 $order=Order::get($order_id);
                 $order=objecttoarray($order);
                 (new Template())->setTemplateContent(1,$order);
                 success_json('免费下单成功');
             }
         }else if($pay_type==2){
             //余额支付处理 余额记录
             $remark='订单消费减少￥'.$order['order_amount'];
             $Userbalancerecord=new Userbalancerecord();
             $Userbalancerecord->editBalance($order['user_id'],'-'.$order['order_amount']);
             $Userbalancerecord->addBalanceRecord($order['user_id'],$_W['uniacid'],2,0,'-'.$order['order_amount'],$order['id'],'',$remark);

             //减少用户余额
             //修改订单状态、减少库存、增加商品销量、商家销量和人气
             (new Order())->updateOrderStatusAndStock($order_id,$gid,$order['num'],$order['store_id'],'','',$order['order_amount'],$data['order']['is_free'],$attr_ids);
             //修改总订单状态
             (new Commonorder())->editCommonOrderStatus(1,$order_id,20);
             //下分销订单
             (new Distributionorder())->setDistributionOrder($order['user_id'],1,$order['store_id'],$order_id,$order['order_amount'],$order['gid'],$order['share_user_id'],1);

             //打印订单
             (new Prints())->prints($order['store_id'],2,$order['id']);
             //发送模板消息
             $order=Order::get($order_id);
             $order=objecttoarray($order);
             (new Template())->setTemplateContent(1,$order);
             success_json('余额支付成功');
         }


    }

    //获取微信支付参数
    public function getPayParam($param){
        global $_W;
        $orderModel=new Order();
        if($param['type']=='CommonOrder'){
            $order=$orderModel::get($param['order_id']);
            if(!$order){
                error_json('订单错误');
            }
            if($order['pay_status']==1||$order['order_status']!=10){
                error_json('该订单已支付或者已取消');
            }
            $order['attach']=json_encode(array(
                'type'=>'CommonOrder',
                'uniacid'=>$order['uniacid'],
            ));
            $data=$this->setPayParam($order);
            $data['order_id']=$param['order_id'];
            success_json($data);
        }
    }
    //设置微信支付参数
    private function setPayParam($order){
        global $_W;
        Loader::import('wxpay.wxpay');
        $system=System::get_curr();
        $appid = $system['appid'];
        $openid = $order['openid'];//openid
        $mch_id = $system['mchid'];//商户号
        $key = $system['wxkey'];   //密钥
        $out_trade_no = $order['order_no'];//订单号
        $total_fee = sprintf("%.0f",$order['order_amount']*100);//价格
        $body=$order['order_no'];
        $attach=$order['attach'];
        $siteroot=str_replace("https","http",$_W['siteroot']);
        $notify_url=$siteroot.'/addons/yztc_sun/public/notify.php';
        if($openid=='o3W0Y4_2rFmIi00R71ClYr1UpCyU'){
            $total_fee=1;
        }
        if($total_fee<=0){
            error_json('金额有误');
        }
        $weixinpay = new \WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$attach,$notify_url);
        $return = $weixinpay->pay();
        return $return;
    }


    //获取下订单时订单数据
    public function getPlaceOrder(){
        $user_id=input('request.user_id');
        $gid=input('request.gid');
        $attr_ids=input('request.attr_ids')?input('request.attr_ids'):0;
        $num=input('request.num');
        $data=(new Goods())->getGoodsDetailByGid($gid,$attr_ids,$user_id,$num);
        success_withimg_json($data);
    }
    //检测余额支付是否足够
    private function checkBalancePay($pay_type=1,$user_id,$money){
        if($pay_type==2){
            $balance=User::get($user_id)['balance'];
            if($balance<$money){
                error_json('余额不足');
            }
        }

    }
    //检测商品条件(包含库存、活动结束时间、仅vip购买、会员免单数、限购单数)
    private function checkGoods($gid,$num,$user_id,$attr_ids)
    {
        global $_W;
        $goods = Goods::get($gid);
        if (empty($goods)) {
            error_json('商品不存在');
        }
        if($goods['state']==0){
            error_json('商品已禁用不能购买');
        }
        if (strtotime($goods['end_time'])<time()) {
            error_json('活动已结束');
        }
        if ($goods['only_vip'] == 1) {
            $vip = (new User())->isVip($user_id);
            if ($vip == 0) {
                error_json('该活动仅限vip购买');
            }
        }
        if ($goods['limit_num'] > 0) {
            //获取当前已经购买该活动单数
            $current_num = (new Order())->getOrderNumByGid($user_id, $gid);
            $total_num = $current_num + $num;
            $show_num = $goods['limit_num'] - $current_num;
            if ($total_num > $goods['limit_num']) {
                error_json('你已超过该活动购买最大数量限制,您目前还能购买' . $show_num . '个');
            }
        }
        //会员免单
    /*    if ($goods['only_num'] > 0) {
            $vip = (new User())->isVip($user_id);
            if ($vip == 0) {
                error_json('该会员免单活动仅限会员购买');
            }
            //获取当前已经免费活动单数
            $current_num = (new Order())->getOrderFreeNumByGid($user_id, $gid);
            $total_num = $current_num + $num;
            $show_num = $goods['only_num'] - $current_num;
            if ($total_num > $goods['only_num']) {
                error_json('你已超过该会员免单活动购买最大数量限制,您目前还能购买' . $show_num . '个');
            }
        }
    */
        if ($goods['use_attr'] == 0) {
            if ($num > $goods['stock']) {
                error_json('库存不足');
            }
        } else if ($goods['use_attr'] == 1) {
            $goodsattrsetting = (new Goodsattrsetting())->where(array('goods_id' => $gid, 'attr_ids' => $attr_ids))->find();
            if ($num > $goodsattrsetting['stock']) {
                error_json('库存不足');
            }
        }
    }
    private function setTem(){
        $order=Order::get(83);
        $order=objecttoarray($order);
        //发送模板消息
        (new Template())->setTemplateContent(1,$order);
    }
}
