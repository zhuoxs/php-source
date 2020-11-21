<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/27
 * Time: 16:07
 */
namespace app\api\controller;

use app\model\Coupon;
use app\model\Couponget;
use app\model\Store;

class ApiCoupon extends Api
{
    //TODO::优惠券列表
    public function couponList(){
        global $_W;
        $type=input('post.type',0);
        $sort=input('post.sort','desc');
        $lng=input('post.lng',0);
        $lat=input('post.lat',0);
        $page=input('post.page',1);
        $length=input('post.length',10);
        if($type==1){
            $filed='c.id,c.pic,c.indexpic,c.name,s.name as storename,c.full,s.end_time,c.is_recommend,c.is_del,c.state,c.uniacid';
            $order['c.read_num_virtual']=$sort;
        }elseif ($type==2){
            $filed='c.id,c.pic,c.indexpic,c.name,s.name as storename,c.full,s.end_time,c.is_recommend,c.is_del,c.state,c.uniacid,s.end_time';
            $order['c.create_time']=$sort;
        }elseif($type==3){
            $filed="c.id,c.pic,c.indexpic,c.name,s.name as storename,c.full,s.end_time,c.is_recommend,c.is_del,c.state,c.uniacid,s.end_time,( 6371 * acos (    
                cos ( radians(" . $lat . ") )    
                * cos( radians( c.lat ) )    
                * cos( radians( c.lng ) - radians(" . $lng . ") )    
                + sin ( radians(" . $lat . ") )    
                * sin( radians( c.lat ) )    )    
                ) AS distance";
            $order['distance']=$sort;
        }else{
            $filed='c.id,c.pic,c.indexpic,c.name,s.name as storename,c.full,s.end_time,c.is_recommend,c.is_del,c.state,c.uniacid,s.end_time';
        }
        $model=new Coupon();
        $hot=input('post.hot',0);
        if($hot>0){
            $where['c.is_recommend']=1;
        }
        $where['c.is_del']=0;
        $where['c.state']=1;
        $where['c.uniacid']=$_W['uniacid'];
        $where['s.end_time']=['gt',time()];
        $list=$model->alias('c')->join('store s','c.store_id=s.id')->field($filed)->where($where)->order($order)->page($page,$length)->select();

//        $list=$model->with('storeinfo')->where($where)->field($filed)->order($order)->page($page,$length)->select();
        success_withimg_json($list);
    }
    //TODO::优惠券详情
    public function couponDetails(){
        $model=new Coupon();
        $order_no=input('post.order_no');
        if($order_no){
            $ordinfo=Couponget::get(['order_no'=>$order_no]);
            $id=$ordinfo['cid'];
        }else{
            $id=input('post.id');
        }

        //新增浏览量
        $model->where('id',$id)->setInc('read_num',1);
        $model->where('id',$id)->setInc('read_num_virtual',1);
        $info=$model->with('storeinfo')->where(['id'=>$id,'is_del'=>0,'state'=>1])->find();
        if($info){
            if(strtotime($info['storeinfo']['end_time'])<time()){
                return_json('商家已过期',-1);
            }
            $get=new Couponget();
            $user_id=input('post.user_id');
            $info['count']=$get->where(['cid'=>$id,'user_id'=>$user_id])->field('id')->count();
            success_withimg_json($info);
        }else{
            return_json('优惠券不存在',-1);
        }

    }
    //TODO::领优惠券
    public function getCoupon(){
        $user_id=input('post.user_id');
        $cid=input('post.cid');
        $couponinfo=Coupon::get($cid);
        $model=new Coupon();
        $get=new Couponget();
        //会员
        if($couponinfo['only_vip']==1){
            $user=new \app\model\User();
            $isvip=$user->isVip($user_id);
            if($isvip==0){
                return_json('请先开通会员',-1);
            }
        }
        //限领
        if($couponinfo['limit_num']>0){
            $count=$get->where(['cid'=>$cid,'user_id'=>$user_id])->field('id')->count();
            if($couponinfo['limit_num']<=$count){
                return_json('已达到领取上限',-1);
            }
        }
        //库存
        if($couponinfo['num']<1){
            return_json('优惠券已领完',-1);
        }
        //1.付费领取 2.转发领取 3.免费领取
        if($couponinfo['gettype']==1){
            //调支付
            $wx=new ApiWx();
            $attach=json_encode(array('type'=>'coupon','uniacid'=>$couponinfo['uniacid'],'cid'=>$cid,'user_id'=>$user_id));
            $userinfo=\app\model\User::get($user_id);
            $wxinfo=$wx->pay($userinfo['openid'],$couponinfo['getmoney'],$attach);
            return_json('调支付',0,$wxinfo);
        }elseif ($couponinfo['gettype']==2){
            $help_uid=input('post.help_uid',0);
            if(($help_uid>0)&&($help_uid!=$user_id)){
                //只能帮领一次
                $ishelp=$get->where(['user_id'=>$user_id,'help_uid'=>$help_uid,'cid'=>$cid])->find();
                if($ishelp){
                    return_json('只能帮领一次哦',-1);
                }
                $get->getCoupon($couponinfo,$user_id,$cid,$help_uid,2,0);
                return_json('帮领成功');
            }else{
                return_json('请先转发才能领取哦',-1);
            }
        }elseif ($couponinfo['gettype']==3){
            $get=new Couponget();
            $get->getCoupon($couponinfo,$user_id,$cid,$help_uid=0,3,0);
            return_json('领取成功');
        }
    }
    //TODO::我的优惠券
    public function myCoupon(){
        $user_id=input('post.user_id');
        $model=new Couponget();
        $where['user_id']=$user_id;
        $page=input('post.page');
        $length=input('post.length');
        $type=input('post.type');
        switch ($type){
            case 0:
                $where['end_time']=['gt',time()];
                break;
            case 1:
                $where['write_off_status']=0;
                $where['end_time']=['gt',time()];
                break;
            case 2:
                $where['write_off_status']=2;
                break;
            case 3:
                $where['end_time']=['lt',time()];
                break;
            default:
                $where['end_time']=['gt',time()];
                break;

        }
        $list=$model->with('couponinfo')->with('storeinfo')->where($where)->order(['create_time'=>'asc'])->page($page,$length)->select();
        success_withimg_json($list);
    }
    //TODO::订单详情
    public function Orderinfo(){
        $id=input('post.id');
        $model=new Couponget();
        $info=$model->with('couponinfo')->with('storeinfo')->where(['id'=>$id])->find();
        success_withimg_json($info);
    }
}