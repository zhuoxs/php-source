<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/3
 * Time: 14:43
 */
namespace app\api\controller;





use app\model\Comment;
use app\model\Commonorder;
use app\model\Panic;
use app\model\Panicattrgroup;
use app\model\Panicattrsetting;
use app\model\Panicladder;
use app\model\Panicorder;
use app\model\Panicrefund;
use app\model\Store;
use think\cache\Driver;
use think\cache\driver\Redis;
use app\model\User;
use app\model\Userbalancerecord;
use think\Db;

class ApiPanic extends Api
{
    public function test(){
//        $redis = new Redis();
//        $redis->handler()->hMset('abc',array('a'=>1));
//        $redis->hMset('abc',array('a'=>1));
//        var_dump( $redis->handler()->hMget('abc',array('a'=>1)));exit;

//        $redis->set(',redistest,',"测试redis1");
//        echo $redis->get(',redistest,');

//      $redis->clear('key');
//        $new =new Panic;
//        $a=$new->getInfo(1,$redis);
        $ladder=new Panicladder();
        $a=$ladder->useLadder(15,6);
        var_dump($a);

    }
    //TODO::首页抢购
    public function indexPanicList(){
        global $_W;
        $model=new Panic();
        $where['p.state']=1;
        $where['p.is_del']=0;
        $where['p.is_recommend']=1;
        $where['p.uniacid']=$_W['uniacid'];
        $where['p.end_time']=['gt',time()];
        $where['s.end_time']=['gt',time()];
        $page=input('post.page',1);
        $length=input('post.length',4);
        $lng=input('post.lng',0);
        $lat=input('post.lat',0);
        $filed="p.name,p.vip_price,p.id,p.indexpic,p.original_price,p.start_time,p.end_time,p.sales_num_virtual,p.is_recommend,
                p.state,p.is_del,p.uniacid,s.name as storename,p.panic_price,s.end_time,( 6371 * acos (    
                cos ( radians(" . $lat . ") )    
                * cos( radians( s.lat ) )    
                * cos( radians( s.lng ) - radians(" . $lng . ") )    
                + sin ( radians(" . $lat . ") )    
                * sin( radians( s.lat ) )    )    
                ) AS distance";
        $order['distance']='asc';
        $order['id']='desc';
        $list=$model->alias('p')->join('store s','p.store_id=s.id')->field($filed)->where($where)->order($order)->page($page,$length)->select();
        success_withimg_json($list);
    }
    //TODO::抢购列表
    public function panicList(){
        global $_W;
        $cid=input('post.cid',0);
        $type=input('post.type');//1.进行中 2.已结束
        if($type==1){
            $where['p.end_time']=['gt',time()];
        }elseif ($type==2){
            $where['p.end_time']=['lt',time()];
        }
        if($cid>0){
            $where['p.cat_id']=$cid;
        }
        $where['p.state']=1;
        $where['p.is_del']=0;
        $where['p.uniacid']=$_W['uniacid'];
        $hot=input('post.hot',0);
        if($hot>0){
            $where['p.is_recommend']=1;
        }
        $where['s.end_time']=['gt',time()];
        $page=input('post.page');
        $length=input('post.length');
        $model=new Panic();
        $filed="p.name,p.vip_price,p.id,p.pic,p.original_price,p.start_time,p.end_time,p.sales_num_virtual,p.is_recommend,
                p.state,p.is_del,p.uniacid,s.name as storename,p.panic_price,s.end_time";
        $list=$model->alias('p')->join('store s','p.store_id=s.id')->field($filed)->where($where)->order(['p.sort'=>'asc','p.create_time'=>'desc'])->page($page,$length)->select();
//        $list=$model->with('store')->where($where)->order(['sort'=>'asc','create_time'=>'desc'])->page($page,$length)->select();
        success_withimg_json($list);
    }
    //TODO::抢购详情
    public function panicDetails(){
        $pid=input('post.pid');
        $user_id=input('post.user_id');
        $model=new Panic();
        $info=$model->where(['id'=>$pid,'is_del'=>0,'state'=>1,'check_status'=>2])->find();
        if($info){
            $redis=new Redis();
            $model->addReadnum($pid);
            $info['pics']=json_decode($info['pics'],true);
            //多规格
            if($info['use_attr']==1){
                $group=new Panicattrgroup();
                $info['attr_group_list']=$group->getAttrGroupList($pid);
            }
            //商家信息
            $info['store_info']=Store::get(['id'=>$info['store_id']]);
            if(strtotime($info['store_info']['end_time'])<time()){
                return_json('商家已过期',-1);
            }
            //我已购买的份数
            $info['mybuytimes']=$redis->get('panicbuytimes'.$pid.'uid'.$user_id);
            //已免单次数
            $info['myfreetimes']=$redis->get('panicfreetimes'.$pid.'uid'.$user_id);
            $ord=new Panicorder();
            $info['oldoid']=$ord->noPay($user_id,$pid);
            //阶梯团
            if($info['is_ladder']==1){
                $lad=new Panicladder();
                $info['ladder_list']=$lad->where(['goods_id'=>$pid])->order(['panic_num'=>'asc'])->select();

            }
            success_withimg_json($info);

        }else{
            return_json('商品不存在',1);
        }
    }
    //TODO:;获取已选规格信息
    public function getAttrInfo(){
        $setting=new Panicattrsetting();
        $pid=input('post.pid');
        $attr_ids=input('post.attr_ids');
        $data=$setting->getGoodsAttrInfo($pid,$attr_ids);
        success_withimg_json($data);
    }
    //TODO:：下订单
    public function buy(){
        $pid=input('post.pid');
        $user_id=input('post.user_id');
        $num=input('post.num');
        $order_amount=input('post.order_amount');
//        $money=input('post.money');
        $prepay_id=input('post.prepay_id');
        $remark=input('post.remark');
        $phone=input('post.phone');
        $share_user_id=input('post.share_user_id')?input('post.share_user_id'):0;
        $pay_type=input('request.pay_type')?input('request.pay_type'):1;
        //未使用未支付订单
        $ord=new Panicorder();
        $oldoid=$ord->noPay($user_id,$pid);
        if($oldoid>0){
            return_json('您有未支付的订单，请先前往支付',-1,['oid'=>$oldoid]);
        }
        $model=new Panic();
        $panicinfo=$model->getInfo($pid);
        //判断时间
        if($panicinfo['start_time']>time()){
            return_json('抢购还未开始',-1);
        }
        if($panicinfo['end_time']<time()){
            return_json('来晚了，抢购已结束',-1);
        }



        $redis=new Redis();
        //限购
        if($panicinfo['limit_num']>0){
            $mybuytimes=$redis->get('panicbuytimes'.$pid.'uid'.$user_id);
            if($mybuytimes>=$panicinfo['limit_num']){
                return_json('您购买次数达到限购数量啦',-1);
            }
        }
        //判断是否会员
        $isvip=\app\model\User::isVip($user_id);
        //判断库存
        $use_attr=input('post.use_attr');
        $attr_list=input('post.attr_list');
        if($use_attr==1){
            $attr_ids=input('post.attr_ids');
            $attr=new Panicattrsetting();
            //多规格
            $attrinfo=$attr->getAttrInfo($pid,$attr_ids,$redis);
            if(intval($attrinfo['stock']-$num)<0){
                return_json('来晚了，抢光了哦');
            }
            //多规格价钱
            if($isvip==1){
                $money=$attrinfo['vip_price'];
            }else{
                $money=$attrinfo['panic_price'];
            }
        }else{
            if(intval($panicinfo['stock']-$num)<0){
                return_json('来晚了，抢光了');
            }
            //单规格价钱
            if($isvip==1){
                $money=$panicinfo['vip_price'];
            }else{
                $money=$panicinfo['panic_price'];
            }
        }
        //开启阶梯购的价钱
        if($panicinfo['is_ladder']==1){
            $ladder=new Panicladder();
            $ladderinfo=$ladder->useLadder($pid,intval($panicinfo['sales_num']+$panicinfo['sales_num_virtual']));
//            var_dump($ladderinfo);exit;
            if($ladderinfo){
                //最多可购买数量
                $lastnum=intval(($ladderinfo['panic_num']-intval($panicinfo['sales_num']+$panicinfo['sales_num_virtual'])));
//                var_dump($ladderinfo['panic_num'],$panicinfo['sales_num']+$panicinfo['sales_num_virtual']);exit;
                if($num>$lastnum){
                    return_json('当前价位最多只能买'.$lastnum.$panicinfo['unit'],-1);
                }
                if($isvip==1){
                    $money=$ladderinfo['vip_price'];
                }else{
                    $money=$ladderinfo['panic_price'];
                }
            }
        }
        $is_free=0;
        if($isvip==1){
            //会员免单
            if($panicinfo['vip_free']==1){
                //已免单次数
                $myfreetimes=$redis->get('panicfreetimes'.$pid.'uid'.$user_id);
                if($myfreetimes<$panicinfo['free_num']){
                    $money=0;
                    $is_free=1;
                }
            }
        }
        //总价
        $order_amount= sprintf("%.2f",$money*$num);
        //判断余额支付是否支付
        $this->checkBalancePay($pay_type,$user_id,$order_amount);
        //添加订单
        $oid=$model-> addOrder($panicinfo,$user_id,$pid,$redis,$num,$remark,$phone,$use_attr,$attr_ids,$attr_list,$order_amount,$money,$isvip,$is_free,$share_user_id,$pay_type);
        //0元就改状态、付钱调支付
        if($pay_type==1){
            if($order_amount>0){
                $datap['prepay_id']=$prepay_id;
                Panicorder::update($datap,['id'=>$oid]);
                //倒计时
                $ord->timingTask($oid);
                //调支付
                $wx=new ApiWx();
                $attach=json_encode(array('type'=>'panic','uniacid'=>$panicinfo['uniacid'],'pid'=>$pid,'oid'=>$oid));
                $userinfo=\app\model\User::get($user_id);
                $wxinfo=$wx->pay($userinfo['openid'],$order_amount,$attach);
                return_json('调支付',0,$wxinfo,['oid'=>$oid]);
            }else{
                $ord->editStatus($oid,$pid,$prepay_id);
                return_json('免单成功',0,array(),['oid'=>$oid]);
            }
        }else if($pay_type==2){
            global $_W;
            //余额支付处理 余额记录
            $remark='订单消费减少￥'.$order_amount;
            $Userbalancerecord=new Userbalancerecord();
            $Userbalancerecord->editBalance($user_id,'-'.$order_amount);
            $Userbalancerecord->addBalanceRecord($user_id,$_W['uniacid'],2,0,'-'.$order_amount,$oid,'',$remark);

            $ord->editStatus($oid,$pid,$prepay_id,'','',2);
            return_json('余额支付成功',0,array(),['oid'=>$oid]);
        }

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

    //TODO::订单详情
    public function orderInfo(){
        $order_no=input('post.order_no',0);
        $oid=input('post.oid',0);
        $model=new Panicorder();
        if($order_no>0){
            $info=$model->with('store')->with('panic')->where(['order_no'=>$order_no,'is_del'=>0])->find();
        }
        if($oid>0){
            $info=$model->with('store')->with('panic')->where(['id'=>$oid,'is_del'=>0])->find();
        }

        if($info){
            success_withimg_json($info);
        }else{
            return_json('订单不存在');
        }
    }
    //TODO::重调支付
    public function payAgain(){
        global $_W;
        $oid=input('post.oid');
        $pay_type=input('request.pay_type')?input('request.pay_type'):1;
        $ord=new Panicorder();
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0]);
        if($orderinfo){
            $model=new Panic();
            $panicinfo=$model->getInfo($orderinfo['pid']);
            //判断时间
            if($panicinfo['end_time']<time()){
                return_json('来晚了，抢购已结束',-1);
            }
            //判断过期
            if($orderinfo['expire_time']<time()){
                //清过期
                $ord->cancelOrder($oid);
                return_json('该订单已过期，请重新下单',-1);
            }
            if($pay_type==1){
                //调支付
                $wx=new ApiWx();
                $attach=json_encode(array('type'=>'panic','uniacid'=>$panicinfo['uniacid'],'pid'=>$orderinfo['pid'],'oid'=>$oid));
                $userinfo=\app\model\User::get($orderinfo['user_id']);
                $wxinfo=$wx->pay($userinfo['openid'],$orderinfo['order_amount'],$attach);
                return_json('调支付',0,$wxinfo);
            }else if($pay_type==2){
                $this->checkBalancePay($pay_type,$orderinfo['user_id'],$orderinfo['order_amount']);
                //余额支付处理 余额记录
                $remark='订单消费减少￥'.$orderinfo['order_amount'];
                $Userbalancerecord=new Userbalancerecord();
                $Userbalancerecord->editBalance($orderinfo['user_id'],'-'.$orderinfo['order_amount']);
                $Userbalancerecord->addBalanceRecord($orderinfo['user_id'],$_W['uniacid'],2,0,'-'.$orderinfo['order_amount'],$oid,'',$remark);
                $ord->editStatus($oid,$orderinfo['pid'],$orderinfo['prepay_id'],'','',2);
                return_json('余额支付成功',0,array(),['oid'=>$oid]);
            }

        }else{
            return_json('订单不存在',-1);
        }
    }
    //TODO::取消订单
    public function cancelOrder(){
        $oid=input('post.oid');
        $ord=new Panicorder();
        $user_id=input('post.user_id');
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0,'is_pay'=>0]);
        if($orderinfo){
            if($user_id==$orderinfo['user_id']){
                $ord->cancelOrder($oid);
                return_json();
            }else{
                return_json('当前用户与下单用户不一致',-1);
            }
        }else{
            return_json('该订单无法取消',-1);
        }
    }
    //TODO::删除订单
    public function delOrder(){
        $oid=input('post.oid');
        $ord=new Panicorder();
        $user_id=input('post.user_id');
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0,'order_status'=>60]);
        if($orderinfo){
            if($user_id==$orderinfo['user_id']){
               Panicorder::update(['is_show'=>0],['id'=>$oid]);
                return_json();
            }else{
                return_json('当前用户与下单用户不一致',-1);
            }
        }else{
            return_json('订单未完成无法删除',-1);
        }
    }
    //TODO::评论
    public function addComment(){
        $data['order_id']=input('post.order_id');
        $order=new Panicorder();
        $orderinfo=$order->mfind(['id'=>$data['order_id']]);
        if($orderinfo['order_status']==40){
            $data['goods_id']=$orderinfo['pid'];
            $data['user_id']=input('post.user_id');
            $data['stars']=input('post.stars');
            $data['content']=input('post.content');
            $data['anonymous']=input('post.anonymous');
            $data['type']=2;
            $img=input('post.imgs');
            if($img){
                $imgs=explode(',',$img);
                $data['imgs']=  json_encode($imgs);
            }
            $com=new Comment();
            $res=$com->allowField(true)->save($data);
            if($res){
                $order->allowField(true)->save(['order_status'=>60,'finish_time'=>time()],['id' => $data['order_id']]);
                //修改公共订单
                $comord=new Commonorder();
                $comord->editCommonOrderStatus(2,$data['order_id'],60);
                return_json('评价成功',0);
            }else{
                return_json('评价失败',-1);
            }
        }else{
            return_json('当前订单无法评价',-1);
        }
    }
    //TODO::订单列表
    public function orderList(){
        global $_W;
        $user_id=input('post.user_id',0);
        $where['user_id']=$user_id;
        $page=input('post.page');
        $length=input('post.length');
        $type=input('post.type',0);  //0全部 1.待支付 2.已支付 3.待评价 4.已完成 5.售后/退款
        $ord=new Panicorder();
        $where['uniacid']=$_W['uniacid'];
        $where['is_del']=0;
        $where['is_show']=1;
        switch ($type){
            case 1 :
                $where['order_status']=10;
                $where['after_sale']=0;
                break;
            case 2 :
                $where['order_status']=20;
                $where['after_sale']=0;
                break;
            case 3 :
                $where['order_status']=40;
                $where['after_sale']=0;
                break;
            case 4 :
                $where['order_status']=60;
                $where['after_sale']=0;
                break ;
            case 5 :
                $where['after_sale']=['gt',0];
                break;
        }
        $list= $ord ->with('store')->with('panic')->where($where)->order(['create_time'=>'desc'])->page($page,$length)->select();
        success_withimg_json($list);
    }
    //TODO::申请售后
    public function afterSale(){
        $oid=input('post.oid');
        $orderinfo=Panicorder::get($oid);
        $panicinfo=Panic::get($orderinfo['pid']);
        $user_id=input('post.user_id');
        if($panicinfo['is_support_refund']==1){
            if($orderinfo['after_sale']>0){
                return_json('请勿重复申请',-1);
            }
            if($orderinfo['order_status']==20&&$orderinfo['refund_status']!=4){
                //添加退款订单
                $data=array();
                $data['store_id']=$orderinfo['store_id'];
                $data['user_id']=$user_id;
                $data['order_id']=$orderinfo['id'];
                $data['refund_no']=date('Ymd',time()).rand(100000,999999);
                $data['refund_price']=$orderinfo['order_amount'];
                $data['refund_type']=$orderinfo['pay_type'];
                $model=new Panicrefund();
                $model->allowField(true)->save($data);
                //修改订单状态
                Panicorder::update(['after_sale'=>1,'refund_status'=>1,'refund_no'=>$data['refund_no']],['id'=>$oid]);
                //修改公共订单 50申请售后 51 已退款 52 退款失败 53 拒绝退款
                $comord=new Commonorder();
                $comord->editCommonOrderStatus(2,$oid,50);
                return_json();
            }else{
                return_json('当前状态无法申请售后',-1);
            }
        }else{
            return_json('当前商品不支持退款',-1);
        }
    }
    //TODO::取消申请售后
    public function cancelAfterSale(){
        $oid=input('post.oid');
        $orderinfo=Panicorder::get($oid);
        if($orderinfo['after_sale']==1){
            Panicorder::update(['after_sale'=>0,'refund_status'=>0,'refund_no'=>''],['id'=>$oid]);
            //修改公共订单50申请售后 51 已退款 52 退款失败 53 拒绝退款
            $comord=new Commonorder();
            $comord->editCommonOrderStatus(2,$oid,$orderinfo['order_status']);
            //删除退款订单
            $model=new Panicrefund();
            $model->where(['order_id'=>$oid])->delete();
            return_json();
        }else{
            return_json('无法取消申请',-1);
        }
    }
}