<?php
/**
 * User: YangXinlan
 * DateTime: 2019/2/15 10:49
 */
namespace app\api\controller;


use app\model\Ad;
use app\model\Comment;
use app\model\Commonorder;
use app\model\Config;
use app\model\Pinclassify;
use app\model\Pingoods;
use app\model\Pingoodsattrgroup;
use app\model\Pingoodsattrsetting;
use app\model\Pinheads;
use app\model\Pinladder;
use app\model\Pinorder;
use app\model\Pinrefund;
use app\model\Store;
use app\model\System;
use app\model\Task;
use app\model\User;
use app\model\Userbalancerecord;
use app\model\Distributionorder;
use Think\Db;

class ApiPin extends Api{

    //TODO::商品列表
    public function goodsList(){
        global $_W;
        $cat_id=input('post.cat_id');
        if($cat_id>0){
            $where['p.cat_id']=$cat_id;
        }
        $is_recommend=input('post.is_recommend',0);
        if($is_recommend>0){
            $where['p.is_recommend']=1;
        }
        $store_id=input('post.store_id',0);
        if($store_id>0){
            $where['p.store_id']=$store_id;
        }
        $type=input('post.type');//1.进行中 2.已结束
        if($type==1){
            $where['p.end_time']=['gt',time()];
        }elseif ($type==2){
            $where['p.end_time']=['lt',time()];
        }
        $where['p.is_del']=0;
        $where['p.state']=1;
        $where['p.check_status']=2;
        $where['p.uniacid']=$_W['uniacid'];
        $where['s.end_time']=['gt',time()];
        $order['p.create_time']='desc';
        $page = input('post.page', 1);
        $length = input('post.length', 10);
        $goods=new Pingoods();
        $filed="p.name,p.vip_price,p.id,p.pic,p.original_price,p.start_time,p.end_time,p.sales_num_virtual,p.is_recommend,
                p.state,p.is_del,p.uniacid,s.name as storename,p.need_num,p.pin_price,s.end_time";
        $list=$goods->alias('p')->join('store s','p.store_id=s.id')->field($filed)->where($where)->order(['p.sort'=>'asc','p.create_time'=>'desc'])->page($page,$length)->select();
//        $list=$goods->with('store')->where($where)->order(['sort'=>'asc','create_time'=>'desc'])->page($page,$length)->select();
        success_withimg_json($list);
    }
    //TODO::拼团规则
    public function getRules(){
        $conf=new Config();
        $info=$conf->get_value('pin_rules');
        success_json($info);
    }
    //TODO::商品详情
    public function goodsDetails(){
        $goods_id=input('post.goods_id');
        $user_id=input('post.user_id');
        $heads_id=input('post.heads_id');
        $goods=new Pingoods();
        $info=$goods->mfind(['id'=>$goods_id,'is_del'=>0,'state'=>1,'check_status'=>2]);
        if($info){
            $info['pics']=json_decode($info['pics'],true);
            //多规格
            if($info['use_attr']==1){
                $group=new Pingoodsattrgroup();
                $info['attr_group_list']=$group->getAttrGroupList($goods_id);
            }
            //阶梯团
            if($info['is_ladder']==1){
                $ladder=new Pinladder();
                $info['ladder_info']=$ladder->getLadderList($goods_id);
            }
            //商家信息
            if($info['store_id']>0){
                $info['store_info']=Store::get(['id'=>$info['store_id']]);
            }
            //已买数量
            $ord=new Pinorder();
            $info['my_buy_num']=$ord->buyNum($goods_id,$user_id);
            //团信息
            if($heads_id>0){
                $info['heads_info']=Pinheads::get($heads_id);
            }
            success_withimg_json($info);
        }else{
            return_json('商品不存在',1);
        }
    }
    //TODO:;获取已选规格信息
    public function getAttrInfo(){
        $setting=new Pingoodsattrsetting();
        $goods_id=input('post.goods_id');
        $attr_ids=input('post.attr_ids');
        $data=$setting->getGoodsAttrInfo($goods_id,$attr_ids);
        success_withimg_json($data);
    }
    //TODO::下订单
    public function getBuy(){
        global $_W;
        $goods_id=input('post.goods_id');
        $user_id=input('post.user_id');
        $goods=new Pingoods();
        $goods_info=Pingoods::get(['id'=>$goods_id]);
        $num=input('post.num');
        $attr_ids=input('post.attr_ids');
        $share_user_id=input('post.share_user_id')?input('post.share_user_id'):0;
        $pay_type=input('request.pay_type')?input('request.pay_type'):1;
        $isvip=\app\model\User::isVip($user_id);
        $this->goodsCheck($goods_info,$user_id,$num,$attr_ids);
        /**参团*/
        $heads_id=input('post.heads_id',0);
        if($heads_id>0){
            //判断参团条件
            $this->joinCheck($heads_id,$user_id);
            $data['heads_id']=$heads_id;
        }

        $ordertype=input('post.ordertype',1); //1.开团 2.单独购
        /**多规格*/  /**单独购*/
        $use_attr=input('post.use_attr');
        if($use_attr==1){
            //TODO::多规格
            $attr_ids=input('post.attr_ids');
            $attr=new Pingoodsattrsetting();
            $attrinfo=$attr->getGoodsAttrInfo($goods_id,$attr_ids);
            if(intval($attrinfo['stock']-$num)<0){
                return_json('来晚了，抢光了哦');
            }
            //多规格价钱
            if($ordertype==2){
                //多规格单购
                if($isvip==1){
                    $money=$attrinfo['alonepay_vip_price'];
                }else{
                    $money=$attrinfo['price'];
                }
            }else{
                if($isvip==1){
                    $money=$attrinfo['vip_price'];
                }else{
                    $money=$attrinfo['pin_price'];
                }
            }

        }else{
            //TODO::单规格
            if(intval($goods_info['stock']-$num)<0){
                return_json('来晚了，抢光了');
            }
            //单规格价钱
            if($ordertype==2){
                if($goods_info['is_alonepay']==0){
                    return_json('该商品不支持单独购买',-1);
                }
                if($isvip==1){
                    $money=$goods_info['alonepay_vip_price'];
                }else{
                    $money=$goods_info['price'];
                }
            }else{
                if($isvip==1){
                    $money=$goods_info['vip_price'];
                }else{
                    $money=$goods_info['pin_price'];
                }
            }
        }
        //开启阶梯购的价钱
        if($goods_info['is_ladder']==1){
            $ladder_id=input('post.ladder_id');
            $ladderinfo=Pinladder::get($ladder_id);
            if($ladderinfo){
                if($isvip==1){
                    $money=$ladderinfo['vip_groupmoney'];
                }else{
                    $money=$ladderinfo['groupmoney'];
                }
            }
        }

        $order_amount= sprintf("%.2f",$money*$num);
        $is_head=input('post.is_head');
        $coupon_money=0;
        if($is_head==1&& ($goods_info['is_group_coupon']==1)){
            if($goods_info['coupon_money']>0){
                $coupon_money=$goods_info['coupon_money'];
            }
            if($goods_info['coupon_discount']>0){
                $coupon_money=$order_amount*(1-($goods_info['coupon_discount']/10));
            }
        }
        $order_amount=sprintf("%.2f",$order_amount-$coupon_money);


        //添加订单
        $data['goods_id']=$goods_id;
        $data['user_id']=$user_id;
        $data['num']=$num;
        $data['attr_ids']=$attr_ids;
        $data['attr_list']=input('post.attr_list');
        $data['store_id']=$goods_info['store_id'];
        $data['order_amount']=$order_amount;
        $data['sincetype']=input('post.sincetype',1);
        $data['distribution']=input('post.distribution',0);
        $data['coupon_money']=$coupon_money;
        $data['money']=$money;
//        $data['money']=input('post.money',0);
        $data['name']=input('post.name');
        $data['phone']=input('post.phone');
        $data['remark']=input('post.remark');
        $data['prepay_id']=input('post.prepay_id');
        $data['order_no']=date('YmdHis') . substr('' . time(), -4, 4);
        $data['is_head']=$is_head;
        $expire_time=$goods_info['pay_time']*60+time();//支付过期时间
        $data['expire_time']=$expire_time;
        $data['share_user_id']=$share_user_id;
        $data['pay_type']= $pay_type;



        $ord=new Pinorder();
        $ret= $ord->allowField(true)->save($data);

        if($ret){
            $oid=$ord->id;

            //下分销订单
            $order=Pinorder::get($oid);
            (new Distributionorder())->setDistributionOrder($order['user_id'],3,$order['store_id'],$oid,$order['order_amount'],$order['goods_id'],$share_user_id);

            //添加公共订单
            $common=new Commonorder();
            $common->addCommonOrder(4,$goods_id,$user_id, $data['order_no'],$oid,$num,$data['store_id'],$order_amount,$order_status=10);
            //减库存、加销量
            $goods->actNum($goods_id,$num,$attr_ids);
            //添加团长信息
            if($ordertype==1){
                $lad['groupnum']=input('post.groupnum');
                $lad['groupmoney']=$money;
                $lad['user_id']=input('post.user_id');
                $lad['ladder_id']=input('post.ladder_id');
                $lad['oid']=$oid;
                $heads=new Pinheads();
                $heads->allowField(true)->save($lad);
                $heads_id=$heads->id;
                //新增开团数
                $goods->where(['id'=>$goods_id])->setInc('group_num');
            }elseif($ordertype==2){
                $heads_id=0;
            }
            $ord->allowField(true)->save(['heads_id'=>$heads_id],['id'=>$oid]);

            //0元
            if($order_amount<=0){
                if($is_head==1){
                    $join=0;
                }else{
                    if($heads_id>0){
                        $join=1;
                    }else{
                        $join=2;
                    }
                }
                $ord->freePay($oid,$join);
                return_json('免费购买成功',0,['oid'=>$oid,'heads_id'=>$heads_id,'money'=>$order_amount]);
            }else{
                //付款倒计时
                $ord->timingTask(1,$oid);
                return_json('调支付',0,['oid'=>$oid,'heads_id'=>$heads_id,'money'=>$order_amount]);
            }



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

    //TODO::下单条件判断
    public function goodsCheck($goodsinfo,$user_id,$num,$attr_ids=''){
        //判断是否上架且未删除且审核通过
        if(($goodsinfo['state']==1)&&($goodsinfo['is_del']==0)&&($goodsinfo['check_status']==2)){
            //活动时间
            if(($goodsinfo['start_time']<time() )&&($goodsinfo['end_time']>time())){
                //购买数量
                if(($goodsinfo['limit_num']==0)||(($goodsinfo['limit_num']>0)&&($goodsinfo['limit_num']>=$num))){
                    //购买次数
                    $ord=new Pinorder();
                    $buynum=$ord->buyNum($goodsinfo['id'],$user_id);
                    if(($goodsinfo['limit_times']!=0)&&($goodsinfo['limit_times']<=$buynum)){
                        return_json('达到限购次数了'.$goodsinfo['limit_times'],-1);
                    }else{
                        if($goodsinfo['use_attr']==0){
                            if($num>$goodsinfo['stock']){
                                return_json('库存不足',-1);
                            }else{
                                return true ;
                            }
                        }else if($goodsinfo['use_attr']==1){
                            $setting=new Pingoodsattrsetting();
                            $goodsattrsetting=$setting->mfind(['goods_id'=>$goodsinfo['id'],'attr_ids'=>$attr_ids]);
                            if($num>$goodsattrsetting['stock']){
                                return_json('库存不足',-1);
                            }else{
                                return true;
                            }
                        }
                    }
                }else{
                    return_json('超过单次购买的数量了',-1);
                }
            }else{
                return_json('不在拼团时间内',-1);
            }
        }else{
            return_json('商品不存在',-1);
        }
    }
    //TODO::参团页面
    public function joinPage(){
        $heads_id=input('post.heads_id');
        $goods_id=input('post.goods_id');
        $user_id=input('post.user_id');
        $headinfo=Pinheads::get($heads_id);
        //商品信息
        $data['goodsinfo']=Pingoods::get($goods_id);
        if( ($data['goodsinfo']['state']==1) &&  ($data['goodsinfo']['is_del']==0) ){
            if($headinfo['expire_time']>time()){
                $data['headinfo']=$headinfo;
                //已参团人的头像
                $ord=new Pinorder();
                $data['group']=$ord->grouplist($heads_id);
                $data['groupnum']=$ord->allNum($heads_id);
                $data['grouppaynum']=$ord->allpayNum($heads_id);
                //我是否参团
                $data['isjoin']=0;
                $isorder=$ord->mfind(['user_id'=>$user_id,'heads_id'=>$heads_id,'is_del'=>0]);
                if($isorder){
                    $data['isjoin']=$isorder['id'];
                }
                success_withimg_json($data);
            }else{
                return_json('该团过期',-1);
            }
        }else{
            return_json('商品不存在',-1);
        }


    }
    //TODO::参团
    public function joinGroup(){
        global $_W;
        $goods_id=input('post.goods_id');
        $user_id=input('post.user_id');
        $goods=new Pingoods();
        $goods_info=Pingoods::get(['id'=>$goods_id]);
        $num=input('post.num');
        $attr_ids=input('request.attr_ids');
        $heads_id=input('post.heads_id');
        //判断参团条件
        $this->joinCheck($heads_id,$user_id);
        //判断商品条件
        $this->goodsCheck($goods_info,$user_id,$num,$attr_ids);
        $ord=new Pinorder();
        //添加订单
        $data['goods_id']=$goods_id;
        $data['user_id']=$user_id;
        $data['num']=$num;
        $data['attr_ids']=$attr_ids;
        $data['attr_list']=input('post.attr_list');
        $data['store_id']=input('post.store_id',0);
        $data['shop_id']=input('post.shop_id',0);
        $data['order_amount']=input('post.order_amount',0);
        $data['sincetype']=input('post.sincetype',1);
        $data['distribution']=input('post.distribution',0);
        $data['money']=input('post.money',0);
        $data['coupon_money']=input('post.coupon_money',0);
        $data['name']=input('post.name');
        $data['phone']=input('post.phone');
        $data['province']=input('post.province');
        $data['city']=input('post.city');
        $data['area']=input('post.area');
        $data['address']=input('post.address');
        $data['remark']=input('post.remark');
        $data['prepay_id']=input('post.prepay_id');
        $data['order_num']=date('YmdHis') . substr('' . time(), -4, 4);
        $data['heads_id']=$heads_id;
        $expire_time=$goods_info['pay_time']*60+time();//支付过期时间
        $data['expire_time']=$expire_time;

        $ret= $ord->allowField(true)->save($data);
        if($ret){
            $oid=$ord->id;
            //减库存、加销量
            $goods->actNum($goods_id,$num,$attr_ids);
            //付款倒计时
            $ord->timingTask(1,$oid);
            return_json('调支付',0,['oid'=>$oid,'heads_id'=>$heads_id]);
        }

    }
    //TODO::判断参团条件
    public function joinCheck($heads_id,$user_id){
        $ord=new Pinorder();
        $head=new Pinheads();
        $heads_info=$head->mfind(['id'=>$heads_id]);
        if(($heads_info['expire_time']-5)>time()&&($heads_info['status']==1)){
            //团人数
            $nownum=$ord->allNum($heads_id);
            if($heads_info['groupnum']>$nownum){
                $ord=new Pinorder();
                $isord=$ord->mfind(['user_id'=>$user_id,'heads_id'=>$heads_id,'is_del'=>0]);
                if ($isord){
                    return_json('请勿重复参团哦',-1);
                }else{
                    return true;
                }
            }else{
                return_json('本团已满人',-1);
            }
        }else{
            return_json('当前团不可参与',-1);
        }
    }

    //TODO::订单详情
    public function orderDetails(){
        $oid=input('post.oid');
        $ord=new Pinorder();
        $order_no=input('post.order_no');
        if($oid>0){
            $data['info']=$ord->mfind(['id'=>$oid,'is_del'=>0]);
        }
        if($order_no>0){
            $data['info']=$ord->mfind(['order_no'=>$order_no,'is_del'=>0]);
        }
        $data['storeinfo']=Store::get( $data['info']['store_id']);
        if($data['info']){
            $data['goodsinfo']=Pingoods::get($data['info']['goods_id']);
            if($data['info']['heads_id']>0){
                $data['headsinfo']=Pinheads::get($data['info']['heads_id']);
            }
            success_withimg_json($data);
        }else{
            return_json('订单失效',1);
        }

    }
    //TODO::重新调支付
    public function againPay(){
        global $_W;
        $oid=input('post.oid');
        $pay_type=input('pay_type')?input('pay_type'):1;
        $prepay_id=input('post.prepay_id');
        $ord=new Pinorder();
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0]);
        if($orderinfo){
            $type=input('post.buytype',1); //1.单购 2.团长 3.参团
            $wx=new ApiWx();
            if(($orderinfo['expire_time']-3)<time()){
                return_json('订单已过期',-1);
            }
            if($pay_type==1){
                //调支付
                if($type==3){
                    $attach=json_encode(array('oid'=>$oid,'type'=>'pinjoinbuy','uniacid'=>$_W['uniacid']));
                }else{
                    $attach=json_encode(array('oid'=>$oid,'type'=>'pinbuy','uniacid'=>$_W['uniacid'],'heads_id'=>$orderinfo['heads_id']));
                }
                $userinfo=\app\model\User::get(['id'=>$orderinfo['user_id']]);
                $payinfo=$wx->pay($userinfo['openid'],sprintf("%.2f",$orderinfo['order_amount']),$attach,'拼团消费');
                $ord->allowField(true)->save(['prepay_id'=>$prepay_id],['id'=>$oid]);
                return_json('调支付',0,$payinfo,['oid'=>$oid,'heads_id'=>$orderinfo['heads_id']]);
            }else if($pay_type==2){
                //判断余额支付是否支付
                $this->checkBalancePay($pay_type,$orderinfo['user_id'],$orderinfo['order_amount']);
                $ord->allowField(true)->save(['prepay_id'=>$prepay_id,'pay_type'=>$pay_type],['id'=>$oid]);
                //余额支付处理 余额记录
                $remark='订单消费减少￥'.$orderinfo['order_amount'];
                $Userbalancerecord=new Userbalancerecord();
                $Userbalancerecord->editBalance($orderinfo['user_id'],'-'.$orderinfo['order_amount']);
                $Userbalancerecord->addBalanceRecord($orderinfo['user_id'],$_W['uniacid'],2,0,'-'.$orderinfo['order_amount'],$oid,'',$remark);
                if($type==3){
                    $log['order_status']=20;
                    $log['is_pay']=1;
                    $log['pay_type']=2;
                    $log['pay_time']=time();
                    $ord->allowField(true)->save($log,['id'=>$oid]);
                    //下分销订单
                    $order=$ord::get($oid);
                    (new Distributionorder())->setDistributionOrder($order['user_id'],3,$order['store_id'],$order['id'],$order['order_amount'],$order['goods_id'],$order['share_user_id'],1);
                    //判断人数 ，是否拼团成功
                    $heads=new Pinheads();
                    $orderinfo=Db::name('pinorder')->where(['id'=>$oid])->find();
                    $heads->checkNum($orderinfo['heads_id'],$oid);
                    //删除任务
                    $task=new Task();
                    $task->where(['type'=>'pinpay','value'=>$oid])->delete();
                }else{
                    //修改订单信息
                    if($orderinfo['heads_id']>0){
                        $log['order_status']=20;
                    }else{
                        $log['order_status']=25;
                    }
                    $log['is_pay']=1;
                    $log['pay_type']=2;
                    $log['pay_time']=time();
                    $ord->allowField(true)->save($log,['id'=>$oid]);
                    //下分销订单
                    $order=$ord::get($oid);
                    (new Distributionorder())->setDistributionOrder($order['user_id'],3,$order['store_id'],$order['id'],$order['order_amount'],$order['goods_id'],$order['share_user_id'],1);
                    //修改团长信息
                    //删除支付任务
                    $task=new Task();
                    $taskdata=$task->where(['type'=>'pinpay','value'=>$oid])->find();
                    if($taskdata){
                        $task->where(['type'=>'pinpay','value'=>$oid])->delete();
                    }
                    if($orderinfo['is_head']>0){
                        $goodsinfo=Pingoods::get(['id'=>$orderinfo['goods_id']]);
                        $exper=$goodsinfo['group_time']*60*60+time();
                        if($orderinfo['heads_id']>0){
                            $head=new Pinheads();
                            $head->save(['status'=>1,'expire_time'=>$exper],['id'=>$orderinfo['heads_id']]);
                            //添加成团倒计时任务
                            $task=array(
                                'uniacid'=>$orderinfo['uniacid'],
                                'type'=>'pinopen',
                                'state'=>0,
                                'level'=>1,
                                'value'=>$oid,
                                'create_time'=>time(),
                                'execute_time'=>$exper-5,
                                'execute_times'=>1
                            );
                            Db::name('task')->insert($task);
                        }
                    }
                }
                return_json('余额支付成功',0,array(),['oid'=>$oid]);

            }

        }else{
            return_json('订单不存在',-1);
        }

    }
    /**
     * 订单列表
     */
    public function orderList(){
        global $_W;

        $user_id=input('post.user_id',0);
        $where['user_id']=$user_id;
        $page=input('post.page');
        $length=input('post.length');
        $type=input('post.type',0);  //0全部 1.待付款 2.待成团 3.已成团 4.待评价 5.已完成 6.售后
        $ord=new Pinorder();
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
                $where['order_status']=25;
                $where['after_sale']=0;
                break;
            case 4 :
                $where['order_status']=40;
                $where['after_sale']=0;
                break ;
            case 5 :
                $where['order_status']=60;
                break;
            case 6 :
                $where['after_sale']=['gt',0];
                break;
        }
        $list= $ord ->mlist($where,array('create_time'=>'desc'),$page,$length);
        foreach ($list as $key =>$value){
            $list[$key]['goodsinfo']=Pingoods::get($value['goods_id']);
            $list[$key]['storeinfo']=Store::get($value['store_id']);
        }
        success_withimg_json($list);
    }
    /**
     * 取消订单
     */
    public function cancleOrd(){
        $oid=input('post.oid');
        $user_id=input('post.user_id');
        $ord=new Pinorder();
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0]);
        if(($orderinfo['is_pay']==0)&&($orderinfo['is_del']==0)){
            if($orderinfo['user_id']==$user_id){
                $goods=new Pingoods();
                //加库存 、减销量
                $goods->updateNum($orderinfo['goods_id'],$orderinfo['num'],$orderinfo['attr_ids']);
                //删订单
                $ord->save(['is_del'=>1],['id'=>$oid]);
                //删公共订单
                $common=new Commonorder();
                $common->where(['type'=>4,'order_id'=>$oid])->delete();
                //删除支付任务
                $task=new Task();
                $task->where(['type'=>'pinpay','value'=>$oid])->delete();
                return_json('取消成功');
            }else{
                return_json('当前账号与下单账号不一致',-1);
            }
        }else{
            return_json('订单无法取消',-1);
        }
    }
    /**
     *  确认收货
     */
    public function confirmOrd(){
        $oid=input('post.oid');
        $user_id=input('post.user_id');
        $ord=new Pinorder();
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0,'is_pay'=>1,'order_status'=>3]);
        if($orderinfo){
            if($orderinfo['user_id']==$user_id){
                $res=$ord->save(['order_status'=>4,'use_time'=>time(),'use_num'=>$orderinfo['num']],['id'=>$oid]);
                if($res){
                    if($orderinfo['store_id']>0){
                        $order=new \app\model\Order();
                        $order->confirmAddStoreMoney($orderinfo['store_id'],$orderinfo['order_amount'],2,$orderinfo['user_id'],$oid,$orderinfo['order_num'],$orderinfo['num']);
                    }
                    return_json('确认收货成功');
                }else{
                    return_json('请稍后重试',-1);
                }
            }else{
                return_json('当前账号与下单账号不一致',-1);
            }
        }else{
            return_json('请核实物流状态',-1);
        }
    }
    /**
     *  核销
     */
    public function useOrd(){
        $oid=input('post.oid');
        $user_id=input('post.user_id');
        $store_id=input('post.store_id');
        $ord=new Pinorder();
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0,'is_pay'=>1,'order_status'=>25]);
//        var_dump($oid,$orderinfo);exit;
        if($orderinfo){
            if($orderinfo['store_id']==$store_id){
                if($orderinfo['user_id']==$user_id){
                    $res=$ord->save(['order_status'=>4,'use_time'=>time(),'use_num'=>$orderinfo['num']],['id'=>$oid]);
                    if($res){
                        if($orderinfo['store_id']>0){
                            $order=new \app\model\Order();
                            $order->confirmAddStoreMoney($store_id,$orderinfo['order_amount'],2,$orderinfo['user_id'],$oid,$orderinfo['order_num'],$orderinfo['num']);
                        }

                        return_json('确认收货成功');
                    }else{
                        return_json('请稍后重试',-1);
                    }
                }else{
                    return_json('当前账号与下单账号不一致',-1);
                }
            }else{
                return_json('不是当前商户订单',-1);
            }

        }else{
            return_json('当前订单无法核销',-1);
        }
    }

    //TODO::评论
    public function addComment(){
        $data['order_id']=input('post.order_id');
        $order=new Pinorder();
        $orderinfo=$order->mfind(['id'=>$data['order_id']]);
        if($orderinfo['order_status']==40){
            $data['goods_id']=$orderinfo['goods_id'];
            $data['user_id']=input('post.user_id');
            $data['stars']=input('post.stars');
            $data['content']=input('post.content');
            $data['anonymous']=input('post.anonymous');
            $data['type']=4;
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
                $comord->editCommonOrderStatus(4,$data['order_id'],60);
                return_json('评价成功',0);
            }else{
                return_json('评价失败',-1);
            }
        }else{
            return_json('当前订单无法评价',-1);
        }
    }
    //TODO::申请售后
    public function afterSale(){
        $oid=input('post.oid');
        $orderinfo=Pinorder::get($oid);
        $pininfo=Pingoods::get($orderinfo['goods_id']);
        $user_id=input('post.user_id');
        if($pininfo['is_support_refund']==1){
            if($orderinfo['after_sale']>0){
                return_json('请勿重复申请',-1);
            }
            if($orderinfo['order_status']==25&&$orderinfo['refund_status']!=4){
                //添加退款订单
                $data=array();
                $data['store_id']=$orderinfo['store_id'];
                $data['user_id']=$user_id;
                $data['order_id']=$orderinfo['id'];
                $data['heads_id']=$orderinfo['heads_id'];
                $data['refund_no']=date('Ymd',time()).rand(100000,999999);
                $data['refund_price']=$orderinfo['order_amount'];
                $data['refund_type']=$orderinfo['pay_type'];
                $model=new Pinrefund();
                $model->allowField(true)->save($data);
                //修改订单状态
                Pinorder::update(['after_sale'=>1,'refund_status'=>1,'refund_no'=>$data['refund_no']],['id'=>$oid]);
                //修改公共订单 50申请售后 51 已退款 52 退款失败 53 拒绝退款
                $comord=new Commonorder();
                $comord->editCommonOrderStatus(4,$oid,50);
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
        $orderinfo=Pinorder::get($oid);
        if($orderinfo['after_sale']==1){
            Pinorder::update(['after_sale'=>0,'refund_status'=>0,'refund_no'=>''],['id'=>$oid]);
            //修改公共订单50申请售后 51 已退款 52 退款失败 53 拒绝退款
            $comord=new Commonorder();
            $comord->editCommonOrderStatus(4,$oid,$orderinfo['order_status']);
            //删除退款订单
            $model=new Pinrefund();
            $model->where(['order_id'=>$oid])->delete();
            return_json();
        }else{
            return_json('无法取消申请',-1);
        }
    }
}