<?php
namespace app\api\controller;

use app\base\controller\Api;
use app\model\Ad;
use app\model\Config;
use app\model\Distributionrecord;
use app\model\Distributionwithdraw;
use app\model\Order;
use app\model\Ordergoods;
use app\model\User;
use app\model\Distribution;
use app\model\System;
use qcloudcos\Conf;
use think\Db;

class Cdistribution extends Api
{
//    获取分销申请页面配置
//    传入
//        user_id:用户id
    public function getApplySetting(){
        $user_id = input('request.user_id');
        $data = [];
//        平台名称
        $system = System::get_curr();
        $data['pt_name'] = $system['pt_name'];

//        分销商申请协议
        $data['distribution_apply_agreement'] = Config::get_value('distribution_apply_agreement','');
        $data['distribution_apply_title'] = Config::get_value('distribution_apply_title','');
        $data['distribution_apply_show'] = Config::get_value('distribution_apply_show',0);

//        我的分销信息
        $distribution = Distribution::get(['user_id'=>$user_id]);
        $data['distribution'] = $distribution;

//        推荐人
        $parent_name = '总店';
        $parent_id = 0;
//        未注册
        if (!isset($distribution->id)){
            $user = \app\model\User::get(input('request.user_id'));
            if ($user['share_user_id']){
                $share_distribution = Distribution::get(['user_id'=>$user['share_user_id']]);
                if ($share_distribution['name']){
                    $parent_name = $share_distribution['name'];
                    $parent_id = $share_distribution['id'];
                }
            }
        }else if ($distribution->id && $distribution->parent_id){
            //        已经注册 并且存在上级
            $share_distribution = Distribution::get($distribution->parent_id);
            $parent_name = $share_distribution->name;
            $parent_id = $share_distribution->id;
        }
        $data['parent_name'] = $parent_name;
        $data['parent_id'] = $parent_id;

//        轮播图
        $ad = new Ad();
        $ad->fill_order_limit(true,false);
        $data['swipers'] = $ad->isUsed()
            ->where('type',5)->select();

        success_withimg_json($data);

    }

//    申请成为分销商
//    传入
//        name: 姓名
//        tel: 电话
//        parent_id: 上级分销商id
//        user_id: 用户id
//        id: 分销记录id
    public function applyDistribution(){
        $data = input('request.');
        $data['check_state'] = 1;
        $data['fail_reason'] = '';

        $id = input('request.id');
        $distribution_model = $id?Distribution::get($id):new Distribution();

        if(!Config::get_value('distribution_apply',0)){
            $data['check_state'] = 2;
        }

        $distribution_model->allowField(true)->save($data);
        success_json($distribution_model);
    }

//    获取我的分销信息
//    传入
//        user_id: 用户id
    public function getDistributionReport(){
        $user_id = input('request.user_id');
        $data = [];

//        分销商信息
        $distribution = Distribution::get(['user_id'=>$user_id],['user']);

        $user = \app\model\User::get($user_id);
        $share_distribution = Distribution::get(['user_id'=>$user['share_user_id']]);
        $distribution['parent_name'] = $share_distribution->name ?: '总店';

        $data['distribution'] = $distribution;

        $data['withdraw_switch'] = Config::get_value('distribution_withdraw_switch',0);
        $data['apply_bgm'] = Config::get_value('distribution_apply_bgm','');


        success_withimg_json($data);
    }

//    获取团队信息
//    传入
//        user_id:用户id
    public function getTeamInfo(){
        $user_id = input('request.user_id');

        $data = Distribution::get(['user_id'=>$user_id],'user');
        $data['count2'] = Db::name('user')->where('share_user_id',$user_id)->count('*');
        $data['count1'] = Db::name('user')->alias('t1')
            ->join('user t2','t2.id = t1.share_user_id')
            ->where('t2.share_user_id',$data['id'])
            ->count('*');

        $data['count1'] += $data['count2'] +1;
        $data['date'] = date('Y-m-d', strtotime($data['create_time']));

        success_json($data,['distribution_level'=>Config::get_value('distribution_level')]);
    }

//    获取下级分销商
//    传入：
//          user_id:用户id
//          level:层级（1，2，3）
//          page:第几页
//          limit:每页数据量
    public function getChilds(){
        $user_model = new User();
        $user_model->fill_order_limit();
        $list = $user_model->alias('t1')
            ->join('distribution t2','t2.user_id = t1.id and t2.check_state = 2','left')
            ->field('t1.id as user_id,t1.img,t1.create_time,t2.id as dis_id,coalesce(t2.name,t1.name) as name')
            ->where('t1.share_user_id',input('request.user_id',0))
            ->select();

        $level = input('request.level',1);
        $distribution_self = Config::get_value('distribution_self');

        $distribution_draw_type = Config::get_value('distribution_draw_type',1);

        $rate1 = Config::get_value('distribution_rate_level'.$level,0);     //下线非分销商
        $money1 = Config::get_value('distribution_money_level'.$level,0);     //下线非分销商
        $rate2 = $rate1;        //分销商
        $money2 = $money1;        //分销商
        if ($distribution_self){
            $rate2 = Config::get_value('distribution_rate_level'.($level+1),0);
            $money2 = Config::get_value('distribution_money_level'.($level+1),0);
        }

        foreach ($list as &$item) {
            if ($distribution_draw_type == 1){
                if ($item['dis_id']){
                    $item['rate'] = $rate2;
                    $item['money'] = 0;
                }else{
                    $item['rate'] = $rate1;
                    $item['money'] = 0;
                }
            }else{
                if ($item['dis_id']){
                    $item['rate'] = 0;
                    $item['money'] = $money2;
                }else{
                    $item['rate'] = 0;
                    $item['money'] = $money1;
                }
            }

            $item['date'] = date('Y-m-d', strtotime($item['create_time']));
        }

        success_json($list);
    }

    //获取分销订单列表
    public function getOrders(){
        $user_id=input('request.user_id');
        $page=input('request.page',1);
        $limit=input('request.limit',10);
        $state = input('request.state',0);
        $cond = [];
        if ($state){
            $cond=array(
                'Ordergoods.state'=>$state,
            );
        }

        $list = Ordergoods::hasWhere('distributionrecords',['user_id'=>$user_id])
            ->with('distributionrecords,order')
            ->where($cond)
            ->order('id desc')
            ->page($page)->limit($limit)
            ->select();

        success_withimg_json($list);
    }

//    获取我的分销提现信息、平台提现设置
//    传入
//        user_id: 用户id
    public function getWithdrawInfo(){
        $user_id = input('request.user_id');
        $data = [];

//        分销商信息
        $distribution = Distribution::get(['user_id'=>$user_id]);

//        提现设置

        $data['withdraw_type'] = Config::get_value('distribution_withdraw_type','1');
        $data['withdraw_type'] = explode(',',$data['withdraw_type']);

        $data['withdraw_min'] = Config::get_value('distribution_withdraw_min',0);
        $data['withdraw_wechatrate'] = Config::get_value('distribution_withdraw_wechatrate',0);
        $data['withdraw_alipayrate'] = Config::get_value('distribution_withdraw_alipayrate',0);
        $data['withdraw_bankrate'] = Config::get_value('distribution_withdraw_bankrate',0);
        $data['withdraw_platformrate'] = Config::get_value('distribution_withdraw_platformrate',0);
        $data['money'] = $distribution['money'];

        success_withimg_json($data);
    }

//    申请提现
    public function addWithdraw(){
        $data = input("request.");
//        todo 验证
        $distributionwithdraw_model = new Distributionwithdraw();
        $ret = $distributionwithdraw_model->allowField(true)->save($data);
        if ($ret){
            success_json($distributionwithdraw_model['id']);
        }else{
            error_json('提交失败');
        }
    }

//    获取提现列表
//        传入
//            user_id: 用户id
    public function getWithdraws(){
        $query = function ($query){
            $user_id = input("request.user_id",0);
            $query->where('user_id',$user_id);
            $state = input('request.state',0);
            switch ($state){
                case 1://待审核
                    $query->where('check_state',1);
                    break;
                case 2://待打款
                    $query->where('check_state',2)
                        ->where('state',0);
                    break;
                case 3://已打款
                    $query->where('state',1);
                    break;
            }
        };
        $distributionwithdraw_model = new Distributionwithdraw();
        $distributionwithdraw_model->fill_order_limit();
        $list = $distributionwithdraw_model->where($query)->select();
        success_json($list);
    }
}
