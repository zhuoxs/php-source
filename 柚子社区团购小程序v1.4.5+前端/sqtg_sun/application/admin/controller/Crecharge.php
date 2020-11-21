<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 14:23
 */
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Config;
use app\model\Recharge;
use app\model\Rechargerecord;
use app\model\User;
use app\model\Userbalancerecord;

class Crecharge extends Admin{
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $this->view->info = $this->model->get_curr();
        return view('edit');
    }

    public function record(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('record');
    }
    public function get_record_list(){
        global $_W;
        $model =new Rechargerecord();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $where['state'] = 1;
        $key=input('get.key');
        if($key){
            $where['out_trade_no']=['like',"%$key%"];
        }
        $list = $model->where($where)->select();
        foreach ($list as $key =>$value){
            $user=new User();
            $userinfo=$user->mfind(['id'=>$value['user_id']],'name');
            $list[$key]['nickname']=$userinfo['name'];
            $list[$key]['recmoney']=sprintf("%.2f",$value['money']-$value['send_money']);
        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    /**
     * 用户余额记录
    */
    public function balancelist(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('balancelist');
    }
    public function get_balance_list(){
        global $_W;
        $model =new Userbalancerecord();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $key=input('get.key');
        if($key){
            $where['user_id']=['like',"%$key%"];
        }
        $list = $model->where($where)->order('id desc')->select();
        foreach ($list as $key =>$value){
            $user=new User();
            $userinfo=$user->mfind(['id'=>$value['user_id']],'name');
            $list[$key]['nickname']=$userinfo['name'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
}