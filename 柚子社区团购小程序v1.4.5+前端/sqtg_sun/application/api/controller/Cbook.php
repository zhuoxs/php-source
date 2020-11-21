<?php
namespace app\api\controller;

use app\base\controller\Api;
use think\Db;
use app\model\Userbalancerecord;
use app\model\Task;


class Cbook extends Api
{
    public $memberconf;
    public function __construct()
    {

    }
    //获取下预约订单时订单数据
    public function getBookPlaceOrder(){
        global $_W;
        $user_id=input('request.user_id');
        $gid=input('request.gid');
        $attr_ids=input('request.attr_ids');
        $num=input('request.num');
        $shop_list=Db::name('shop')->where(array('uniacid'=>$_W['uniacid'],'store_id'=>0))->select();
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
        $express_price=0;
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
        if($goods['store_id']==0){
            $list[]=$new_item;
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
                    'express_price'=>0,
                );
            }
        }
        $data=array(
            'express_price'=>0,
            'total_goods_price'=>$price,
            'list'=>$list,
            'shop_list'=>$shop_list,
            'mch_list'=>$new_mch_list,
        );
        success_json($data,array('img_root'=>$_W['attachurl']));

    }
    //下预约订单
    public function setBookOrder(){
        global $_W;
        $user_id=input('request.user_id');
        $gid=input('request.gid');
        $attr_ids=input('request.attr_ids');
        $num=input('request.num');
        $pay_type=input('request.pay_type');
        $user=Db::name('user')->find($user_id);
        $book_name=input('request.book_name');
        $book_phone=input('book_phone');
        $book_time=input('book_time');
        $user_coupon_id=input('request.user_coupon_id')?input('request.user_coupon_id'):0;
        $sincetype=2;
        $shop_id=input('request.shop_id')?input('request.shop_id'):0;
        $formId=input('request.formId')?input('request.formId'):'';
        $remark=input('request.remark');
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
        $distribution=0;//运费
        $total_price=sprintf("%.2f",$price);
        if($user_coupon_id>0){
            if($total_price<$user_coupon['m_price'])
                error_json('优惠券错误');
        }
        if($user_coupon_id>0){
            if($total_price<$user_coupon['m_price'])
                error_json('优惠券错误');
        }
        //订单金额
        $order_amount=sprintf("%.2f",$total_price-$coupon_price);
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
            'pay_type'=>$pay_type,
            'create_time'=>time(),
            'book_name'=>$book_name,
            'book_phone'=>$book_phone,
            'book_time'=>$book_time,
            'remark'=>$remark,
            'prepay_id'=>$formId,
            'shop_id'=>$shop_id,
        );
        Db::name('order')->insert($order);
        $order_id = Db::name('order')->getLastInsID();
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

    }

    //余额付款完成处理
    private function setBalance($param){
        global $_W;
        $remark='订单消费减少￥'.$param['money'];
        $Userbalancerecord=new Userbalancerecord();
        $Userbalancerecord->editBalance($param['user_id'],'-'.$param['money']);
        $Userbalancerecord->addBalanceRecord($param['user_id'],$_W['uniacid'],2,0,'-'.$param['money'],$param['order_id'],'',$remark);
        //修改订单状态
        if($param['order_sign']==1){
            Db::name('order')->update(array('id'=>$param['order_id'],'pay_status'=>1,'pay_time'=>time(),'order_status'=>1));
            //获取订单详情
            $order_detail=Db::name('orderdetail')->where(array('order_id'=>$param['order_id']))->select();
        }else if($param['order_sign']==2){
            Db::name('orderunion')->update(array('id'=>$param['order_id'],'pay_status'=>1,'pay_time'=>time()));
            Db::name('order')->where(array('order_union_id'=>$param['order_id']))->update(array('pay_status'=>1,'pay_time'=>time(),'order_status'=>1));
            $orderunion=Db::name('orderunion')->find($param['order_id']);
            $order_id_list=$orderunion['order_id_list'];
            $order_detail=Db::name('orderdetail')->where("order_id in ($order_id_list)")->select();
        }
        foreach($order_detail as $val){
            $this->setGoodsStock($val['gid'],$val['num'],$val['attr_ids']);
        }

        $goods=array();
        //发送模板消息
        if($param['order_sign']==2){
            $order=Db::name('orderunion')->find($param['order_id']);
            $page="sqtg_sun/pages/public/pages/myorder/myorder?ostatus=2&id=2";
            $goods['gname']='合并订单';
            $goods['num']='';
            $order['orderformid']=$order['order_no'];
            $order['order_amount']=$order['money'];
            $user=Db::name('user')->find($param['user_id']);
            $order['openid']=$user['openid'];
        }else{
            $order=Db::name('order')->find($param['order_id']);
            $page="sqtg_sun/pages/plugin/order/orderlistdet/orderlistdet?id={$order['id']}";
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
        global $_W;
        $_W['uniacid']=$order['uniacid'];
        $TaskModel=new Task();
        $TaskModel->save($task);
        $task_id=$TaskModel->id;
        Db::name('templatecontent')->update(array('id'=>$content_id,'task_id'=>$task_id));
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




}
