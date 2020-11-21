<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 14:08
 */
namespace app\api\controller;


use app\model\Config;
use app\model\Coupon;
use app\model\User;
use app\model\Vipcode;
use app\model\Vipcard;
use app\model\Openvip;
use app\model\Distributionorder;
use app\model\Distributionpromoter;
use app\model\Userprivilege;

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
        $data['userprivilege']=(new Userprivilege())->where(['state'=>1])->order('sort asc,id desc')->select();
        success_withimg_json($data);
    }
    //TODO::激活码激活
    public function codeActivation(){
        $user_id=input('post.user_id');
        $tel=input('post.tel');
        (new User())->check_version();
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
        $userinfo=\app\model\User::get($user_id);
        (new User())->check_version();
        if(empty($userinfo['tel'])&&empty($tel)){
            return_json('请先绑定手机号',-1);
        }else{
            if(empty($userinfo['tel'])){
                \app\model\User::update(['tel'=>$tel],['id'=>$user_id]);
            }
            $setinfo=Vipcard::get(['id'=>$setid]);
            if($setinfo['stock']>0){
                if($setinfo['money']>0){
                    $wx=new ApiWx();
                    $attach=json_encode(array('type'=>'openvip','uniacid'=>$_W['uniacid'],'setid'=>$setid,'user_id'=>$user_id,'share_user_id'=>$share_user_id));
                    if($userinfo['openid']=='o3W0Y4_2rFmIi00R71ClYr1UpCyU'){
                        $setinfo['money']=0.01;
                    }
                    $wxinfo=$wx->pay($userinfo['openid'],$setinfo['money'],$attach);
                    return_json('调支付',0,$wxinfo);
                }else{
                    //免费
                    //添加会员开卡记录
                    $log=new Openvip();
                    $log->addLog(1,$setid,$setinfo['name'],'',$user_id,$setinfo['day'],$_W['uniacid'],0,'','',$share_user_id);
                    //修改会员时间
                    $user=new \app\model\User();
                    $user->editVip($user_id,'',$setinfo['day']);
                    //成为会员成为分销商
                    (new Distributionpromoter())->setDistributionpromoter(5,$user_id);
                    //减少库存
                    $set=new Vipcard();
                    $set->where(['id'=>$setid])->setDec('stock',1);
                    $set->where(['id'=>$setid])->setInc('salenum',1);
                    return_json('免费开卡成功',0);
                }

            }else{
                return_json('该会员卡已售完',-1);
            }
        }
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
         echo 'SUCCESS';
    }
    //TODO::会员福利
    public function welfareList(){
        global $_W;
        $where['is_del']=0;
        $where['state']=1;
        $where['uniacid']=$_W['uniacid'];
        $where['gettype']=3;
        $where['only_vip']=1;
        $model=new Coupon();
        $page=input('post.page');
        $length=input('post.length');
        $list=$model->with('storeinfo')->where($where)->order(['create_time'=>'desc'])->page($page,$length)->select();
        success_withimg_json($list);
    }
}