<?php
/**
 * User: YangXinlan
 * DateTime: 2019/2/26 9:32
 */
namespace app\api\controller;


use app\model\Freesheet;
use app\model\Freesheetcode;
use app\model\Freesheetorder;
use app\model\Store;

class ApiFreesheet extends Api
{
    //TODO::免单列表
    public function FreeSheetList(){
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
        $model=new Freesheet();
        $filed="p.name,p.allnum,p.id,p.pic,p.start_time,p.end_time as md_end_time ,p.is_recommend,
                p.state,p.is_del,p.uniacid,s.name as storename,s.end_time,p.only_vip,p.lottery_time";
        $list=$model->alias('p')->join('store s','p.store_id=s.id')->field($filed)->where($where)->order(['p.sort'=>'asc','p.create_time'=>'desc'])->page($page,$length)->select();
        success_withimg_json($list);
    }

    //TODO::免单详情
    public function freeSheetInfo(){
        $id=input('post.id');
        $model=new Freesheet();
        $info=$model->with('store')->where(['state'=>1,'is_del'=>0,'check_status'=>2,'id'=>$id])->find();
        if($info){
            $info['pics']=json_decode($info['pics'],true);
            $user_id=input('post.user_id');
            $orderinfo=Freesheetorder::get(['user_id'=>$user_id,'goods_id'=>$id]);
            if($orderinfo){
                $info['is_join']=$orderinfo['id'];
            }else{
                $info['is_join']=0;
            }
            success_withimg_json($info);
        }else{
            return_json('商品不存在',-1);
        }
    }
    //TODO::抽奖规则
    public function ruleset(){
        $info['freesheet_rules'] = \app\model\Config::get_value('freesheet_rules',0);
        success_withimg_json($info);
    }
    //TODO::抽奖
    public function lottery(){
        global $_W;
        $goods_id=input('post.goods_id');
        $user_id=input('post.user_id');
        $model=new Freesheet();
        $info=$model->where(['state'=>1,'is_del'=>0,'check_status'=>2,'id'=>$goods_id])->find();
        if($info){
            $model->checkJoin($goods_id,$user_id,$info);
            $ord=new Freesheetorder();
            $data['user_id']=$user_id;
            $data['goods_id']=$goods_id;
            $data['store_id']=$info['store_id'];
            $data['order_no']=date('YmdHis') . substr('' . time(), -4, 4);;
            $data['uniacid']=$_W['uniacid'];
            $data['tel']=input('post.tel');
            $data['remark']=input('post.remark');
            $ord->allowField(true)->save($data);
            $oid=$ord->id;
            $code=new Freesheetcode();
            $lottery_code=$code->addCode($oid,$user_id,$goods_id);
            return_json('参与成功',0,array('lottery_code'=>$lottery_code,'oid'=>$oid));
        }else{
            return_json('商品不存在',-1);
        }
    }
    //TODO::帮忙抽奖
    public  function helpLottery(){
        $help_uid=input('post.help_uid',0);
        if($help_uid>0){
            $oid=input('post.oid');
            $orderinfo=Freesheetorder::get($oid);
            if($orderinfo){
                $user_id=$orderinfo['user_id'];
                $goods_id=$orderinfo['goods_id'];
                $model=new Freesheet();
                $info=Freesheet::get($orderinfo['goods_id']);
                $model->checkJoin($goods_id,$user_id,$info,$help_uid);
                $code=new Freesheetcode();
                $lottery_code=$code->addCode($oid,$user_id,$goods_id,$help_uid);
                return_json('成功帮助好友增加一次抽奖机会！',0,array('lottery_code'=>$lottery_code,'oid'=>$oid));
            }else{
                return_json('好友未参加抽奖',-1);
            }
        }else{
            return_json('help_uid不能为0',-1);
        }
    }
    //TODO::订单详情
    public function orderInfo(){
        $oid=input('post.oid');
        $ord=new Freesheetorder();
        $order_no=input('post.order_no');
        if($oid>0){
            $data['info']=$ord->mfind(['id'=>$oid,'is_del'=>0]);
        }
        if($order_no>0){
            $data['info']=$ord->mfind(['order_no'=>$order_no,'is_del'=>0]);
        }
        $data['storeinfo']=Store::get( $data['info']['store_id']);
        if($data['info']){
            $data['goodsinfo']=Freesheet::get($data['info']['goods_id']);
            $code=new Freesheetcode();
            $data['helplist']=$code->where(['order_id'=>$data['info']['id']])->select();
            success_withimg_json($data);
        }else{
            return_json('订单失效',1);
        }
    }
    //TODO::订单列表
    public function orderList(){
        global $_W;
        $user_id=input('post.user_id',0);
        $where['user_id']=$user_id;
        $page=input('post.page');
        $length=input('post.length');
        $lottery_status=input('post.lottery_status',0);
        if($lottery_status<3){
            $where['lottery_status']=$lottery_status;
        }else{
            $where['lottery_status']=2;
            $where['write_off_status']=1;
        }

        $ord=new Freesheetorder();
        $where['uniacid']=$_W['uniacid'];
        $where['is_del']=0;
        $list= $ord ->mlist($where,array('create_time'=>'desc'),$page,$length);
        foreach ($list as $key =>$value){
            $list[$key]['goodsinfo']=Freesheet::get($value['goods_id']);
            $list[$key]['storeinfo']=Store::get($value['store_id']);
        }
        success_withimg_json($list);
    }
    //TODO::删除订单
    public function delOrd(){
        $oid=input('post.oid');
        $user_id=input('post.user_id');
        $ord=new Freesheetorder();
        $orderinfo=$ord->mfind(['id'=>$oid,'is_del'=>0,'lottery_status'=>2,'wirite_off_status'=>1]);
        if($orderinfo){
            if($orderinfo['user_id']==$user_id){
                $res=$ord->save(['is_del'=>1],['id'=>$oid]);
                if($res){
                    return_json('删除成功');
                }else{
                    return_json('请稍后重试',-1);
                }
            }else{
                return_json('当前账号与下单账号不一致',-1);
            }
        }else{
            return_json('当前订单无法删除',-1);
        }
    }

}