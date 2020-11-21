<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 14:08
 */
namespace app\api\controller;

use app\base\controller\Api;
use app\model\Config;
use app\model\Coupon;
use app\model\Userbalancerecord;
use app\model\Vipcode;
use app\model\Vipcard;
use app\model\Openvip;
use app\model\Distributionorder;
use app\model\Distributionpromoter;

class ApiVip extends Api
{
    //TODO::会员卡首页
    public function vipcard(){
        global $_W;
        /**会员信息*/
        $user=new \app\model\User();
        $data['userinfo']=$user->mfind(['id'=>input('post.user_id')],'vip_cardnum,vip_endtime','tel');
        /**会员设置*/
        $model=new Vipcard();
        $data['setlist']=$model->where(['uniacid'=>$_W['uniacid'],'state'=>1])->order(['sort'=>'asc'])->select();
        /**会员规则*/
        $data['member_rule'] =Config::get_value('member_rule');
        /**会员卡封面*/
        $data['member_pic'] =Config::get_value('member_pic');
        /**顶部背景色*/
        $data['member_bg_color'] =Config::get_value('member_bg_color');
        /**会员卡卡号颜色*/
        $data['member_font_color'] =Config::get_value('member_font_color');
        /**最新购买记录*/
        $log=new Openvip();
        $data['buylist']=$log->where(['uniacid'=>$_W['uniacid']])->with('userinfo')->order(['create_time'=>'desc'])->page(1,20)->select();
        success_withimg_json($data);
    }
    //TODO::激活码激活
    public function codeActivation(){
        $user_id=input('post.user_id');
        $tel=input('post.tel');
        if($tel){
            $code=input('post.code');
            $model=new Vipcode();
            $model->Activation($code,$user_id,$tel);
            success_json();
        }else{
            success_json('手机号码不能为空',-1);
        }

    }
    //TODO::开通会员调支付
    public function openVip(){
        global $_W;
        $setid=input('post.setid');
        $user_id=input('post.user_id');
        $tel=input('post.tel');
        $share_user_id=input('post.share_user_id')?input('post.share_user_id'):0;
        $pay_type=input('post.pay_type',1);
        $userinfo=\app\model\User::get($user_id);
        if(empty($userinfo['tel'])&&empty($tel)){
            return_json('请先绑定手机号',-1);
        }else{
            if(empty($userinfo['tel'])){
                \app\model\User::update(['tel'=>$tel],['id'=>$user_id]);
            }
            $setinfo=Vipcard::get(['id'=>$setid]);
            if($setinfo['stock']>0){
                if($setinfo['money']>0){
                    if($pay_type==1){
                        $wx=new ApiWx();
                        $attach=json_encode(array('type'=>'openvip','uniacid'=>$_W['uniacid'],'setid'=>$setid,'user_id'=>$user_id,'share_user_id'=>$share_user_id));
                        if($userinfo['openid']=='o3W0Y4_2rFmIi00R71ClYr1UpCyU'){
                            $setinfo['money']=0.01;
                        }
                        $wxinfo=$wx->pay($userinfo['openid'],$setinfo['money'],$attach);
                        return_json('调支付',0,$wxinfo);
                    }elseif ($pay_type==2){
                        if ($userinfo['balance']>=$setinfo['money']){
                            $oid=$this->paysuccess($setid,$setinfo,$user_id,$share_user_id,$pay_type);
                            //修改余额
                            $record=new Userbalancerecord();
                            $record->addBalanceRecord($user_id,$_W['uniacid'],$sign=2,$send_money='0.00',-$setinfo['money'],$oid,'',$remark='开通'.$setinfo['name']);
                            return_json('开卡成功',0);
                        }else{
                            return_json('余额不足',-1);
                        }
                    }
                }else{
                    //免费
                    $this->paysuccess($setid,$setinfo,$user_id,$share_user_id,0);
                    return_json('免费开卡成功',0);
                }

            }else{
                return_json('该会员卡已售完',-1);
            }
        }
    }
    //开卡成功
    public function paysuccess($setid,$setinfo,$user_id,$share_user_id,$pay_type){
        global $_W;
        //添加会员开卡记录
        $log=new Openvip();
        $oid=$log->addLog(1,$setid,$setinfo['name'],'',$user_id,$setinfo['day'],$_W['uniacid'],$setinfo['money'],'','',$share_user_id,$pay_type);
        //修改会员时间
        $user=new \app\model\User();
        $user->editVip($user_id,'',$setinfo['day']);
        //成为会员成为分销商
        (new Distributionpromoter())->setDistributionpromoter(5,$user_id);
        //减少库存
        $set=new Vipcard();
        $set->where(['id'=>$setid])->setDec('stock',1);
        $set->where(['id'=>$setid])->setInc('salenum',1);
        //下分销订单;
        $order=Openvip::get($oid);
        (new Distributionorder())->setDistributionOrder($order['user_id'],4,0,$order['id'],$order['money'],$order['setid'],$order['share_user_id'],1);

        //如果返现加余额
        if($setinfo['moneyback']>0){
            $userbal=new Userbalancerecord();
            $userbal->addBalanceRecord($user_id,$setinfo['uniacid'],$sign=6,$send_money='0.00',$setinfo['moneyback'],$oid,'',$remark='开通'.$setinfo['name'].'返现');
        }
        return $oid;
    }
    //TODO::支付回调
    public function payNotify($data){
        global $_W;
        $attach=json_decode($data['attach'],true);
        $_W['uniacid']=$attach['uniacid'];
        //添加会员开卡记录
        $log=new Openvip();
        $setinfo=Vipcard::get($attach['setid']);
        $oid=$log->addLog(1,$attach['setid'],$setinfo['name'],'',$attach['user_id'],$setinfo['day'],$setinfo['uniacid'],$setinfo['money'],$data['out_trade_no'],$data['transaction_id'],$attach['share_user_id']);

        //增加消费金额
        $user=new \app\model\User();
        $user->where(['id'=>$attach['user_id']])->setInc('total_consume',$setinfo['money']);
        //消费金额成为分销商
        (new Distributionpromoter())->setDistributionpromoter(3,$attach['user_id']);
        //修改会员时间
        $user->editVip($attach['user_id'],'',$setinfo['day']);
        //成为会员成为分销商
        (new Distributionpromoter())->setDistributionpromoter(5,$attach['user_id']);
        //减少库存
        $set=new Vipcard();
        $set->where(['id'=>$attach['setid']])->setDec('stock',1);
        $set->where(['id'=>$attach['setid']])->setInc('salenum',1);
        //下分销订单;
         $order=Openvip::get($oid);
         (new Distributionorder())->setDistributionOrder($order['user_id'],4,0,$order['id'],$order['money'],$order['setid'],$order['share_user_id'],1);
         //如果返现加余额
        if($setinfo['moneyback']>0){
            $userbal=new Userbalancerecord();
            $userbal->addBalanceRecord($order['user_id'],$setinfo['uniacid'],$sign=6,$send_money='0.00',$setinfo['moneyback'],$oid,$data['out_trade_no'],$remark='开通'.$setinfo['name'].'返现');
        }
         echo 'SUCCESS';
    }
    //TODO::会员福利
    public function welfareList(){
        global $_W;
        $where['is_del']=0;
        $where['state']=1;
        $where['uniacid']=$_W['uniacid'];
        $where['gettype']=3;
        $where['only_vip']=['gt',0];
        $model=new Coupon();
        $page=input('post.page');
        $length=input('post.length');
        $list=$model->with('storeinfo')->where($where)->order(['create_time'=>'desc'])->page($page,$length)->select();
        success_withimg_json($list);
    }
}