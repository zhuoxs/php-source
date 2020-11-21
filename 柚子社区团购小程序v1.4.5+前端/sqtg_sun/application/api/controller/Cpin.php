<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/31
 * Time: 10:40
 */
namespace app\api\controller;

use app\base\controller\Api;
use app\model\Ad;
use app\model\Comment;
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
use app\model\Leader;
use app\model\System;
use app\model\Task;
use app\model\Userbalancerecord;
use app\model\Storeleader;
use app\model\Leaderpingoods;
class Cpin extends Api{
    //TODO::轮播图
    public function banner(){
        global $_W;
        $ad=new Ad();
        $list=$ad->where(['type'=>6,'state'=>1,'uniacid'=>$_W['uniacid']])->order('index')->select();
        success_withimg_json($list);
    }
    //TODO::分类列表
    public function classifyList(){
        global $_W;
        $class=new Pinclassify();
        $list=$class->where(['uniacid'=>$_W['uniacid'],'is_del'=>0,'state'=>1])->order(['sort'=>'asc'])->select();
        success_json($list);
    }
    //TODO::商品列表
    public function goodsList(){
        global $_W;
        $cat_id=input('post.cid');
        $key = input('post.key');
        $leader_id = input('post.leader_id');
        if($cat_id>0){
            $where['cid']=$cat_id;
        }
        if($key){
            $where['name']=['like',"%$key%"];
        }
        $is_hot=input('post.is_hot',0);
        if($is_hot>0){
            $where['is_hot']=1;
        }
        $store_id=input('post.store_id',0);
        if($store_id>0){
            $where['store_id']=$store_id;
        }
        $where['is_del']=0;
        $where['state']=1;
        $where['check_state']=2;
        $where['uniacid']=$_W['uniacid'];
        $where['end_time']=['>=',time()];
        $where['start_time']=['<=',time()];
//        $order['create_time']='desc';
        $order['sort']="ASC";
        $page = input('post.page', 1);
        $length = input('post.length', 10);

        //获得团长的商品
        $store_ids = Storeleader::where('leader_id',$leader_id)->column('store_id');
        if (count($store_ids)) {
            $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch', 0);
            $goodses = Leaderpingoods::where('leader_id', $leader_id)->column('goods_id');
            $query = function ($query) use ($where, $goodses, $leader_choosegoods_switch,$store_ids) {
                $query->where($where);
                $query->whereIn('store_id',$store_ids);
                $query->where(function ($q) use ($goodses, $leader_choosegoods_switch) {
                    if ($leader_choosegoods_switch) {
                        $q->where('id', 'in', $goodses)->whereOr('mandatory', 1);
                    }
                });
            };
            $goods=new Pingoods();
            $list=$goods->mlist($query,$order,$page,$length);
        }

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
        $leader_id = input('post.leader_id');
        $goods_id=input('post.goods_id');
        $user_id=input('post.user_id');
        $heads_id=input('post.heads_id');
        $goods=new Pingoods();
        $info=$goods->mfind(['id'=>$goods_id,'is_del'=>0,'state'=>1,'check_state'=>2]);
        //判断是否使用全局配送费
        $delivery_switch  =  $info['delivery_fee_type'];
        if($delivery_switch == 0){
            $global_delievery_fee = Config::get_value('global_delivery_fee',0);
            $info['delivery_fee'] = $global_delievery_fee;
        }
        if($info){
            $info['pics']=json_decode($info['pics'],true);
            $info['img_details']=json_decode($info['img_details'],true);
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
            //已经开团信息
//            $info['group_info']=Pinheads::with(['pinorder'=>function($query)use($goods_id){
//                $query->where('goods_id',$goods_id);
//            },'user'])->where('status',1)
//            ->where('expire_time','>',time())
//            ->limit(5)
//            ->order('id desc')
//            ->select();
            $pinorders = Pinorder::where('goods_id',$goods_id)
                ->where('is_del',0)
                ->where('is_head',1)
                ->where('leader_id',$leader_id)
                ->where('order_status',1)->select();
            $oids = [];
            foreach ($pinorders  as $pinorder ){
                array_push($oids,$pinorder->id);
            }
//            $info['group_info'] = Pinheads::with(['pinorder','user'])
//                ->where('oid','in',$oids)
//                ->order('id desc')
//                ->limit(3)
//                ->select();
//            foreach($info['group_info'] as $key =>$pinheads){
//                //已经拼了多少人
//                $count = Pinorder::where('heads_id',$pinheads->id)->count();
//                //还差多少人
//                $info['group_info'][$key]['less'] = $pinheads->groupnum - $count;
//            }
            $group_info = Pinheads::with(['pinorder', 'user'])
                ->where('oid', 'in', $oids)
                ->where('expire_time','>',time())
                ->order('id desc')
                ->limit(3)
                ->select();
            foreach ($group_info as $key => $pinheads) {
                //已经拼了多少人
                $count = Pinorder::where('heads_id', $pinheads->id)
                    ->where('is_del',0)
                    ->count();
                //还差多少人
                $pinheads['less'] = $pinheads->groupnum - $count;
                if($group_info[$key]['less']){
                    $info['group_info'][]= $pinheads;
                }
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
        $attr_ids=input('request.attr_ids');
        $ordertype=input('post.ordertype',1); //1.开团 2.单独购
        if($ordertype==2){
            if($goods_info['is_alonepay']==0){
                return_json('该商品不支持单独购买',-1);
            }
        }
        $this->goodsCheck($goods_info,$user_id,$num,$attr_ids);

        //添加订单
        $data['goods_id']=$goods_id;
        $data['user_id']=$user_id;
        $data['num']=$num;
        $data['leader_id']=input('post.leader_id');
        $data['attr_ids']=$attr_ids;
        $data['attr_list']=input('post.attr_list');
        $data['store_id']=input('post.store_id',0);
        $data['shop_id']=input('post.shop_id',0);
        $data['order_amount']=input('post.order_amount',0);
        $data['sincetype']=input('post.sincetype',1);
        $data['distribution']=input('post.distribution',0);
        $data['coupon_money']=input('post.coupon_money',0);
        $data['money']=input('post.money',0);
        $data['name']=input('post.name');
        $data['phone']=input('post.phone');
        $data['province']=input('post.province');
        $data['city']=input('post.city');
        $data['area']=input('post.area');
        $data['address']=input('post.address');
        $data['remark']=input('post.remark');
        $data['prepay_id']=input('post.prepay_id');
        $data['order_num']=date('YmdHis') . substr('' . time(), -4, 4);
        $data['is_head']=1;
        $expire_time=$goods_info['pay_time']*60+time();//支付过期时间
        $data['expire_time']=$expire_time;
        //商品活动时间限制
        if($goods_info->end_time<$expire_time){
            $expire_time=$goods_info->end_time;
        }
        $ord=new Pinorder();
        $ret= $ord->allowField(true)->save($data);
        if($ret){
            $oid=$ord->id;
            //减库存、加销量
            $goods->actNum($goods_id,$num,$attr_ids);
            //添加团长信息
            if($ordertype==1){
                $lad['groupnum']=input('post.groupnum');
                $lad['groupmoney']=input('post.groupmoney');
                $lad['user_id']=input('post.user_id');
                $lad['ladder_id']=input('post.ladder_id');
                $lad['oid']=$oid;
                $lad['expire_time'] = $expire_time;
                $heads=new Pinheads();
                $heads->allowField(true)->save($lad);
                $heads_id=$heads->id;
                //新增开团数
//                $goods->where(['id'=>$goods_id])->setInc('group_num');
//                $goods->where(['id'=>$goods_id])->setInc('group_xnnum');
            }else{
                $heads_id=0;
            }
            //付款倒计时
            $ord->timingTask(1,$oid);
//            $ord->allowField(true)->save(['heads_id'=>$heads_id],['id'=>$oid]);
            $ord=$ord->get($oid);
            $ord->allowField(true)->save(['heads_id'=>$heads_id]);
            return_json('调支付',0,['oid'=>$oid,'heads_id'=>$heads_id]);
        }

    }

    //TODO::下单条件判断
    public function goodsCheck($goodsinfo,$user_id,$num,$attr_ids=''){
        //判断是否上架且未删除且审核通过
        if(($goodsinfo['state']==1)&&($goodsinfo['is_del']==0)&&($goodsinfo['check_state']==2)){
            //活动时间
            if(($goodsinfo['start_time']<time() )&&($goodsinfo['end_time']>time())){
                //购买数量
                if(($goodsinfo['limit_num']==0)||(($goodsinfo['limit_num']>0)&&($goodsinfo['limit_num']>=$num))){
                    //购买次数
                    $ord=new Pinorder();
                    $buynum=$ord->buyNum($goodsinfo['id'],$user_id);
//                    var_dump($goodsinfo['limit_times'],$buynum);exit;
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
                                $this->ajaxError('库存不足');
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
    //TODO:;查运费
    public function getDistribution(){
        $province=input('post.province');
        $city=input('post.city');
        $postagerules_id=input('post.postagerules_id');
        $weight=input('post.weight');
        $number=input('post.num');
        $api=new Index();
        $data=$api-> getDistribution($province,$city,$postagerules_id,$weight,$number);
        success_json($data);
    }
    //TODO::参团页面
    public function joinPage(){
        $heads_id=input('post.heads_id');
        $goods_id=input('post.goods_id');
        $user_id=input('post.user_id');
        $leader_id = input('request.leader_id',0);
        $headinfo=Pinheads::get($heads_id);
        //商品信息
        $data['goodsinfo']=Pingoods::get($goods_id);

        //判断社区团长有没有该商品
        //1.是否强制上架
        $goods = Pingoods::where('id',$goods_id)->find();
        if ($leader_id){
            $leader_has_goods = true;
//                判断商家选择团长
            $storeleader_count = Storeleader::where('leader_id',$leader_id)
                ->where('store_id',$goods->store_id)
                ->count();
            if (!$storeleader_count){
                $leader_has_goods = false;
            }

//                判断团长主动选择开关
            $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch',0);

//                判断团长选择商品
            $leadergoods_count = Leaderpingoods::where('leader_id',$leader_id)
                ->where('goods_id',$goods_id)
                ->count();
            //商品是强制上架时不考虑
            if (!$leadergoods_count && !$goods['mandatory'] && $leader_choosegoods_switch){
                $leader_has_goods = false;
            }

            if(!$leader_has_goods){
                return_json('您当前团长没有该商品',-2);
            }
        }else{
            return_json('没有选择团长',-2);
        }



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

//        //如果时效时间大于团结束时间，以团结束时间
        $head = Pinheads::get($heads_id);
        if($expire_time > $head->expire_time){
            $expire_time = $head->expire_time;
        }
        $data['expire_time']=$expire_time;
        $data['leader_id']=input('post.leader_id');

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
                $isord=$ord->mfind(['user_id'=>$user_id,'heads_id'=>$heads_id]);
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
    //TODO::余额支付
    public function balancePay(){
        $oid=input('post.oid');
        $orderinfo=Pinorder::get($oid);
        $type=input('post.buytype',1); //1.单购 2.团长 3.参团
        //获得团长的商品
        $store_ids = Storeleader::where('leader_id',$orderinfo->leader_id)->column('store_id');
        if (count($store_ids)) {
            $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch', 0);
            $goodses = Leaderpingoods::where('leader_id', $orderinfo->leader_id)->column('goods_id');
            $query = function ($query) use ($goodses, $leader_choosegoods_switch,$store_ids,$orderinfo) {
//                    $query->where($where);
                $query->whereIn('store_id',$store_ids);
                $query->where('id',$orderinfo['goods_id']);
                $query->where(function ($q) use ($goodses, $leader_choosegoods_switch) {
                    if ($leader_choosegoods_switch) {
                        $q->where('id', 'in', $goodses)->whereOr('mandatory', 1);
                    }
                });
            };
            $goods=new Pingoods();
            $list=$goods->mlist($query);
            if(!count($list)){
                return_json('商品不存在',-1);
            }
        }else{
            return_json('商户商品不存在',-1);
        }
        if($orderinfo['is_pay']==0){
            $user=new \app\model\User();
            $userinfo=$user->mfind(['id'=>$orderinfo['user_id']],'balance');
            if($orderinfo['order_amount']<=$userinfo['balance']){
                if($type==1){
                    $log['order_status']=2;
                }else{
                    $log['order_status']=1;
                }

                $log['is_pay']=1;
                $log['pay_type']=2;
                $log['pay_time']=time();
                $ord=new Pinorder();
                $res=$ord->where(['id'=>$oid])->update($log);
                if($res){
                    //扣余额
                    $balance=new Userbalancerecord();
//                    $balance->editBalance($orderinfo['user_id'],-$orderinfo['order_amount']);
                    //加余额记录
                    $balance->addBalanceRecord($orderinfo['user_id'],$orderinfo['uniacid'],6,$send_money='0.00',-$orderinfo['order_amount'],$orderinfo['id'],$orderinfo['order_num'],'拼团消费');

                    if($type==2){
                        //团长---》开团成功
                        if($orderinfo['heads_id']>0){
                            $goodsinfo=Pingoods::get(['id'=>$orderinfo['goods_id']]);
                            $exper=$goodsinfo['group_time']*60*60+time();
                            if($orderinfo['heads_id']>0){
                                $head=new Pinheads();
                                $head->save(['status'=>1,'expire_time'=>$exper],['id'=>$orderinfo['heads_id']]);
                                //添加成团倒计时任务
                                $ord->timingTask(2,$oid);
                                //新增开团数
                                $goodsinfo->setInc('group_num');
                                $goodsinfo->setInc('group_xnnum');
                            }
                        }
                    }elseif ($type==3){
                        //团员---》 达到拼团人数
                        $heads=new Pinheads();
                        $heads->checkNum($orderinfo['heads_id'],$oid);
                    }
                    //删除支付任务
                    $task=new Task();
                    $task->where(['type'=>'pinpay','value'=>$oid])->delete();
                    return_json('支付成功');
                }else{
                    return_json('支付失败，请稍后重试',-1);
                }
            }else{
                return_json('余额不足，无法支付',-1);
            }
        }else{
            return_json('订单已支付',1);
        }

    }
    //TODO::订单详情
    public function orderDetails(){
        $oid=input('post.oid');
        $ord=new Pinorder();
        $data['info']=$ord->mfind(['id'=>$oid]);
        $data['leader']=Leader::get($data['info']['leader_id']);
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
        $ord=new Pinorder();
        $leader_id = input('post.leader_id');
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0]);
        $goods = Pingoods::get($orderinfo['goods_id']);
        if($orderinfo){
            $type=input('post.buytype',1); //1.单购 2.团长 3.参团
            $wx=new Cwx();
            if(($orderinfo['expire_time']-3)<time()||$goods->end_time<time()||$goods->start_time>time() ){
                return_json('商品未在售',-1);
            }
            if($goods->state==0){
                return_json('商品被禁用',-1);
            }
            //判断团长是否有该商品
/*            $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch',0);
            $store_ids = Storeleader::where('leader_id',$leader_id)->column('store_id');
            if (count($store_ids)) {
                $goods_ids = Leaderpingoods::where('leader_id', $leader_id)->column('goods_id');

                $count = Pingoods::where('state', 1)
                    ->where('end_time', '>', time())
                    ->where('start_time', '<=', time())
                    ->whereIn('store_id', $store_ids)
                    ->where(function ($query) use ($goods_ids) {
                        $query->whereIn('id', $goods_ids)->whereOr('mandatory', 1);
                    })
                    ->where('is_del', 0)
                    ->where('id',$orderinfo['goods_id'])
                    ->count();
                if(!$count){
                    return_json('商品不存在',-1);
                }
            }*/
            //获得团长的商品
            $store_ids = Storeleader::where('leader_id',$leader_id)->column('store_id');
            if (count($store_ids)) {
                $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch', 0);
                $goodses = Leaderpingoods::where('leader_id', $leader_id)->column('goods_id');
                $query = function ($query) use ($goodses, $leader_choosegoods_switch,$store_ids,$orderinfo) {
//                    $query->where($where);
                    $query->whereIn('store_id',$store_ids);
                    $query->where('id',$orderinfo['goods_id']);
                    $query->where(function ($q) use ($goodses, $leader_choosegoods_switch) {
                        if ($leader_choosegoods_switch) {
                            $q->where('id', 'in', $goodses)->whereOr('mandatory', 1);
                        }
                    });
                };
                $goods=new Pingoods();
                $list=$goods->mlist($query);
                if(!count($list)){
                    return_json('商品不存在',-1);
                }
            }else{
                return_json('商户商品不存在',-1);
            }

            //调支付
            if($type==3){
                $attach=json_encode(array('oid'=>$oid,'type'=>'pinjoinbuy','uniacid'=>$_W['uniacid']));
                $type = 'pinjoinbuy';
            }else{
                $attach=json_encode(array('oid'=>$oid,'type'=>'pinbuy','uniacid'=>$_W['uniacid'],'heads_id'=>$orderinfo['heads_id']));
                $type = 'pinbuy';
            }
            $userinfo=\app\model\User::get(['id'=>$orderinfo['user_id']]);
//            $payinfo=$wx->pay($userinfo['openid'],sprintf("%.2f",$orderinfo['order_amount']),$attach,'拼团消费');

//            测试金额
            if($userinfo['openid'] == 'o3W0Y4xbxds5g0-bbf9qFzulgp6Q'){
                // $orderinfo['order_amount'] = 0.01;
            }
            //$wxinfo=$wx->pay($user['openid'],$total_fee,$order->id,'Order','商城订单'.$order->order_no);
            $payinfo = $wx->pay($userinfo['openid'],sprintf("%.2f",$orderinfo['order_amount']),$oid,$type,'拼团消费');
            //$ord->allowField(true)->save(['prepay_id'=>$payinfo['prepay_id']],['id'=>$oid]);
            $ord = Pinorder::get($oid);
            $ord->prepay_id = $payinfo['prepay_id'];
            $ord->save();
            return_json('调支付',0,$payinfo,['oid'=>$oid,'heads_id'=>$orderinfo['heads_id']]);
        }else{
            return_json('订单不存在',-1);
        }

    }
    /**
     * 订单列表
    */
/*    public function orderList(){
        global $_W;

        $ordertype=input('post.ordertype',1);
        if($ordertype==1){
            $user_id=input('post.user_id',0);
            $where['user_id']=$user_id;
        }else{
            $store_id=input('post.store_id',0);
            $where['store_id']=$store_id;
        }

        $page=input('post.page');
        $length=input('post.length');
        $type=input('post.type',0);  //0全部 1.待付款 2.待成团 3.进行中 4.待评价 5.退款
        $ord=new Pinorder();
        $where['uniacid']=$_W['uniacid'];
        $where['is_del']=0;
        $where['is_show']=1;
        switch ($type){
            case 1 :
                $where['order_status']=0;
                break;
            case 2 :
                $where['order_status']=1;
                break;
            case 3 :
                $where['order_status']=[['egt',2],['elt',3]];
                break;
            case 4 :
                $where['order_status']=4;
                break ;
            case 5 :
                $where['order_status']=[['egt',6],['elt',7]];
                break;
        }
        $list= $ord ->mlist($where,array('create_time'=>'desc'),$page,$length);
        foreach ($list as $key =>$value){
            $list[$key]['goodsinfo']=Pingoods::get($value['goods_id']);
        }
        success_withimg_json($list);
    }*/
    public function orderList() {
        global $_W;

        $ordertype = input('post.ordertype', 1);
        if ($ordertype == 1) {
            $user_id = input('post.user_id', 0);
            $where['user_id'] = $user_id;
        } else {
            $store_id = input('post.store_id', 0);
            $where['store_id'] = $store_id;
        }

        $page = input('post.page');
        $length = input('post.length');
        $type=input('post.type',0);  //0全部 1.待付款 2.待成团 3.待配送 4配送中 5.待自提 6已完成 7已经取消
        $ord = new Pinorder();
        $where['uniacid'] = $_W['uniacid'];
        $where['is_del'] = 0;
        $where['is_show'] = 1;
        switch ($type) {
            case 1 :
                $where['order_status'] = 0;
                break;
            case 2 :
                $where['order_status'] = 1;
                break;
            case 3 :
                $where['order_status'] = 2;
                break;
            case 4 :
                $where['order_status'] = 3;
                break;
            case 5 :
                $where['order_status'] = 4;
                break;
            case 6 :
                $where['order_status'] = 5;
                break;
            case 7 :
                $where['order_status'] = [['egt',6],['elt',7]];
                $where['is_del'] = [['egt',0],['elt',1]];
                break;
        }
//        $list = $ord->mlist($where, array('create_time' => 'desc'), $page, $length);
        $list = $ord->where($where)->order(array('create_time' => 'desc'))->limit(($page-1)*$length.','.$length)->select();
        foreach ($list as $key => $value) {
            $list[$key]['goodsinfo'] = Pingoods::get($value['goods_id']);
            $list[$key]['leader']=Leader::get($value['leader_id']);
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
//                $ord->save(['is_del'=>1],['id'=>$oid]);
                $ord=Pinorder::get($oid);
                $ord->save(['is_del'=>1]);
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
        $where=[];
        $where=['id'=>$oid,'is_del'=>0,'is_pay'=>1];
        $query = function($query){
            $query->where('order_status',3);
            $query->whereOr('order_status',4);
        };
//        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0,'is_pay'=>1,'order_status'=>3]);
        $orderinfo=$ord->where($query)->where($where)->find();
        if($orderinfo){
            if($orderinfo['user_id']==$user_id){
                //$res=$ord->save(['order_status'=>5,'use_time'=>time(),'use_num'=>$orderinfo['num']],['id'=>$oid]);
                $ord = Pinorder::get($oid);
                $res=$ord->save(['order_status'=>5,'use_time'=>time(),'use_num'=>$orderinfo['num']]);
                if($res){
                    if($orderinfo['store_id']>0){
                        $order=new \app\model\Order();
                        //$order->confirmAddStoreMoney($orderinfo['store_id'],$orderinfo['order_amount'],2,$orderinfo['user_id'],$oid,$orderinfo['order_num'],$orderinfo['num']);
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
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0,'is_pay'=>1,'order_status'=>2,'sincetype'=>2]);
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
    /**
     * 发布评论
    */
    public function addComment(){
        $data['order_id']=input('post.order_id');
        $order=new Pinorder();
        $orderinfo=$order->mfind(['id'=>$data['order_id']]);
        if($orderinfo['order_status']==5 && !$orderinfo['is_comment']){
                $data['goods_id']=$orderinfo['goods_id'];
                $data['user_id']=input('post.user_id');
                $data['stars']=input('post.stars');
                $data['content']=input('post.content');
                $data['type']=2;
                $img=input('post.imgs');
                if($img){
                    $imgs=explode(',',$img);
                    $data['imgs']=  json_encode($imgs);
                }
                $com=new Comment();
                $res=$com->allowField(true)->save($data);
                if($res){
                    $order->allowField(true)->save(['finish_time'=>time()],['id' => $data['order_id']]);
                    return_json('评价成功',0);
                }else{
                    return_json('评价失败',-1);
                }
        }else{
            return_json('当前订单无法评价',-1);
        }
    }
    /**
     * 通过订单号获取订单详情
    */
    public function ordernumFind(){
        $order_num=input('post.order_num');
        $data['info']=Pinorder::get(['order_num'=>$order_num]);
        if($data['info']['is_del']==0){
            $data['goodsinfo']=Pingoods::get($data['info']['goods_id']);
            if($data['info']['heads_id']>0){
                $data['headsinfo']=Pinheads::get($data['info']['heads_id']);
            }
            success_withimg_json($data);
        }else{
            return_json('订单不存在',-1);
        }
    }
    public function test(){
        $pin=new Pinorder();
//        $a=$pin->openOverdue(176);
//        $ref=new Pinrefund();
//        $a=$ref->refund(61);
//        var_dump($a);exit;
        $data['attach']=json_encode(array('oid'=>224,'heads_id'=>186));
        $data['out_trade_no']=224;
        $data['transaction_id']=224;
        $a=$pin->joinNotify($data);
        var_dump($a);exit;

    }
    public function getGroup(){
        $goods_id = input('post.goods_id');
        $leader_id = input('post.leader_id');
        $page = input('post.page',0);
        $limit = input('post.limit',5);
        $pinorders = Pinorder::where('goods_id',$goods_id)
            ->where('is_del',0)
            ->where('is_head',1)
            ->where('leader_id',$leader_id)
            ->where('order_status',1)->select();
        $oids = [];
        foreach ($pinorders  as $pinorder ){
            array_push($oids,$pinorder->id);
        }

        $list =  Pinheads::with(['pinorder','user'])
            ->where('oid','in',$oids)
            ->where('expire_time','>',time())
            ->page($page)
            ->limit($limit)
            ->select();
        $list2=[];
        foreach($list as $key =>$pinheads){
            //已经拼了多少人
            $count = Pinorder::where('heads_id',$pinheads->id)
                ->where('is_del',0)
                ->count();
            //还差多少人
            $list[$key]['less'] = $pinheads->groupnum - $count;
            if($list[$key]['less']){

                $list2[]=$list[$key];
            }
        }
        success_withimg_json($list2);
    }
    function test2(){
        $pinorder = \app\model\Order::get(1046);
        dump($pinorder);
        $pinorder->save(['state'=>2]);
        $pinorder->save(['state'=>1]);
    }

    public function getGouporder(){
        $header_id = input('header_id',0);
        if(!$header_id){
            $where['id']=input('order_id',0);
        }else{
            $where['header_id']=$header_id;
        }
        $orders = Pinorder::with(['user','goodsinfo'])->where($where)->select();
        success_withimg_json($orders);
    }

    /**
     * 已经付款取消订单
     */
    public function cancleOrder(Pingoods $pin) {
        $oid = input('post.oid');
        $user_id = input('post.user_id');
        $orderinfo=Pinorder::where(['id'=>$oid])->find();
        $headsinfo=Pinheads::where(['id'=>$orderinfo['heads_id']])->find();

        //拼团成功 不许取消
        if($headsinfo['status']==0){
            error_json('未开团');
        }elseif($headsinfo['status']==3 || $headsinfo['status']==2 ){
            error_json('拼团无法取消');
        }

        //是不是团长
        if($user_id == $headsinfo->user_id ){

            $headsinfo->save(['status'=>3],['id'=>$headsinfo['id']]);
            //退款、返库存、减销量
//            $orderinfo=Pinorder::where(['id'=>$oid])->find();
//            $pin=new Pingoods();
//            $pin->updateNum($orderinfo['goods_id'],$orderinfo['num'],$orderinfo['attr_ids']);
            //减少开团数量
            $pin->where('id',$orderinfo['goods_id'])->setDec('group_num');
            $pin->where('id',$orderinfo['goods_id'])->setDec('group_xnnum');
            //获取所有已支付订单列表
            $paylist=Pinorder::where(['heads_id'=>$orderinfo['heads_id'],'is_del'=>0,'is_pay'=>1])->select();
            foreach ($paylist as $key =>$value){
                $pin->updateNum($value['goods_id'],$value['num'],$value['attr_ids']);
                $value->is_del=1;
                $value->save();
                $refund=new Pinrefund();
                $refund->refund($value->id);
            }
            success_json('取消成功');
        }else{
            $value = Pinorder::get($oid);
            $pin->updateNum($value['goods_id'],$value['num'],$value['attr_ids']);
            $value->is_del=1;
            $value->save();
            $refund=new Pinrefund();
            $refund->refund($value->id);
            success_json('取消成功');
        }
    }
    public function taskrefund(){
        $taskList = Task::where(function ($query) {
            $query->where('type', 'pinopen');
            $query->whereOr('type', 'pinpay');
        })->where('level', 1)
            ->where('state', 0)//待执行
//            ->where('execute_time', ['<=', time()])
//            ->where('execute_times', ['<=', 5])
            ->select();

        if (count($taskList)) {
            foreach ($taskList as $task) {

                $ret = false;
                try {
                    switch ($task->type) {
                        case "pinpay";
                            $pin = new Pinorder();
                            $ret = $pin->payOverdue($task->value);
                            break;
                        case "pinopen";
                            $pin = new Pinorder();
                            $ret = $pin->openOverdue($task->value);
                            break;
                    }
                } catch (\Exception $e) {
                    $memo = [
                        'msg' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ];
                    $task->memo = json_encode($memo);
                    $ret = false;
                }
                $task->execute_times = $task->execute_times + 1;
                $task->execute_time = time() + ($task->execute_times * $task->execute_times * 10);
                $task->save();
                if ($ret === true) {
                    $task->state = 1;
                    $task->save();
                }
            }
        }
    }
    public function pingoodsIndex(Pingoods $pinGoods){
        $store_id = input("post.store_id");
        $check_state = input("post.check_state",0);
        $pinGoods->fill_order_limit();
        $query = function($query)use($store_id,$check_state){
            if($check_state){
                $query->where('check_state',$check_state);
            }
            $query->where('store_id',$store_id);
        };
        $list = $pinGoods->where($query)->select();
        success_withimg_json($list,[
            'count'=>$pinGoods->where($query)->field("id,name")->count()
        ]);
    }

    /**
     * 数据保存（新增、编辑）
     */
    public function save(Pingoods $info){
        $id = input('post.id');
        if ($id) {
            $info = $info->get($id);
        }

        $data = input('post.');
        $data['check_state']=2;
        $store_id = isset($data['store_id'])?$data['store_id']:$info['store_id'];
        if($store_id>0){
            $conf_add=\app\model\Config::get_value('pin_add_check');
            $conf_update=\app\model\Config::get_value('pin_update_check');
            if(($conf_add['pin_add_check']==1)&&(!$id)){
                $data['check_state']=1;
            }elseif (($conf_update['pin_update_check']==1)&&($id)){
                $data['check_state']=1;
            }else{
                $data['check_state']=2;
            }
        }
        $data['start_time']=strtotime(input('post.start_time'));
        $data['end_time']=strtotime(input('post.end_time'));
        $data['pics'] = json_encode(explode(',',$data['pics']));
        $data['img_details'] = json_encode(explode(',',$data['img_details']));
        $ret = $info->allowField(true)->save($data);
        if($ret){
            success_json($info->id);
        }else{
            error_json("保存失败");
        }
    }

    public function storeOrderList(Pinorder $pinorder){
        $store_id = input("post.store_id");
        $id = input("post.id");
        $order_staus = input('state',-1);
        $query = function($query)use($store_id,$id,$order_staus){
            if($id){
                $query->where('id',$id);
            }
            $query->where('store_id',$store_id);
            if($order_staus!=-1){
                $query->where('order_status',$order_staus);
            }
        };
        $pinorder->fill_order_limit();
        $list = $pinorder->with(['goods','leader','user'])->where($query)->select();
        success_withimg_json($list);
    }

    public function pingoods(Pingoods $pinGoods){
        $id = input("post.pingoods_id");
        $store_id = input("post.store_id",0);
        $query=function($query)use($store_id,$id){
            if($store_id){
                $query->where('store_id',$store_id);
            }
            $query->where('id',$id);
        };
        $list = $pinGoods->where($query)->find();
        $list['pics'] = json_decode($list['pics']);
        success_withimg_json($list);
    }
    public function batchsend(){
        $oid=input('post.ids');
        $flag = false;
        if($oid){
            $order=new Pinorder();
            $orderinfos=$order->mlist(['id'=>['in',$oid],'is_del'=>0]);
            foreach($orderinfos as $orderinfo){
                if($orderinfo['order_status']==2){
                    if($orderinfo['sincetype']==1){
                        $data['order_status']=3;
                    }else{
                        $data['order_status']=3;
                        $data['use_time']=time();
                    }
                    $data['send_time']=time();
                    $order = $order->get($orderinfo['id']);
                    $res=$order->save($data);
                    file_put_contents('sql',$order->getLastSql().PHP_EOL,FILE_APPEND);
                    if($res){
                        $flag = true;
                        if($orderinfo['sincetype']==2){
                            if($orderinfo['store_id']>0){
                                $order=new \app\model\Order();
                            }
                        }
                    }
                }
            }
            if($flag){
                return array(
                    "code"=>0
                );
            }
        }else{
            return array(
                "code"=>1,
                "msg"=>"未点选订单"
            );
        }
    }
}