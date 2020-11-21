<?php
// +----------------------------------------------------------------------
// | msvodx[TP5内核]
// +----------------------------------------------------------------------
// | Copyright © 2019-QQ97250974
// +----------------------------------------------------------------------
// | 专业二开仿站定制修改,做最专业的视频点播系统
// +----------------------------------------------------------------------
// | Author: cherish ©2018
// +----------------------------------------------------------------------

/**
 * 支付管理控制器
 */

namespace app\admin\controller;

use think\Request;

class PaySetting extends Admin{


    protected function _initialize()
    {
        parent::_initialize();

        $tab_data['menu'] = [
            [
                'title' => '支付设置',
                'url' => 'admin/paySetting/index',
            ],
            [
                'title' => '支付方式管理',
                'url' => 'admin/paySetting/paymentList',
            ],
        ];
        $this->tab_data = $tab_data;
        $this->assign('tab_type', 1);
    }

    //支付设置
    function index(Request $request){
        if($request->isPost()){
            $system_payment_code=$request->post('system_payment_code');
            $this->myDb->name('admin_config')->data(['value'=>$system_payment_code])->where(['name'=>'system_payment_code'])->update();
            return $this->success('保存成功');
        }
        $where=['is_third_payment'=>1];
        $paymentList=$this->myDb->where($where)->name('payment')->select();
        $this->assign('paymentList',$paymentList);

        //当前系统设置的支付方式码
        $paySetting=$this->myDb->name('admin_config')->where("name='system_payment_code'")->find();
        $this->assign('payCode',$paySetting['value']?$paySetting['value']:'');

        //菜单相关设置
        $this->tab_data['current'] = url('admin/paySetting/index');
        $this->assign('tab_data', $this->tab_data);

        return $this->fetch();

    }


    //支付列表
    function paymentList(){
        $paymentList=$this->myDb->name('payment')->select();
        $this->assign('paymentList',$paymentList);

        //menu items
        $this->tab_data['current'] = url('admin/paySetting/paymentList');
        $this->assign('tab_data', $this->tab_data);

        return $this->fetch();
    }

    //支付配置
    function setting(Request $request){
        if($request->isPost()){
            $data=$request->post();
            $payId=$data['id'];
            $config=$paymentInfo=$this->myDb->name('payment')->where("id={$payId}")->find();
            $config=json_decode($config['config'],true);

            foreach ($config as &$item){
                if($item['name']=='min_money' && (float)$request->post('min_money')<0.01) return $this->error('最低支付金额不能小于0.01元！');
                $item['value']=$request->post($item['name']);
            }

            $upRs=$this->myDb->name('payment')->where("id={$payId}")->data(['update_time'=>time(),'config'=>json_encode($config)])->update();

            return $this->success('保存成功！',url('PaySetting/paymentList'));
        }

        $paymentId=$request->param('id/d',0);
        if($paymentId==0) return $this->error('支付方式ID参数不正确!');

        $paymentInfo=$this->myDb->name('payment')->where("id={$paymentId}")->find();
        if(!$paymentInfo) return $this->error('您要配置的支付不存在!');

        $payParams=json_decode($paymentInfo['config'],true);
        $this->assign('payParams',$payParams);
        unset($paymentInfo['config']);
        $this->assign('payBaseInfo',$paymentInfo);

        //menu items
        $this->tab_data['current'] = url('admin/paySetting/setting');
        $this->assign('tab_data', $this->tab_data);

        return $this->fetch();
    }




}