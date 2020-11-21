<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Memberconf;
use app\model\Userbalancerecord;
use app\model\Vipcard;

class Cuser extends Admin
{
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function outCSV(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $ids = input('get.ids');
            if($ids){
                $query->where('id','in',$ids);
            }
        };

        $list = $model->where($query)
            ->field('name,tel')
            ->select();

        $this->toCSV('用户表'.date('ymdhis').'.csv',['用户','电话'],json_decode(json_encode($list),true));
    }
    public function getList(){
        $model = $this->model;
        $list = $model->field('id,name')->select();
        $users = [];
        foreach($list as $i=>$v)
        $users ['u-'+$list[$i]['id']] = $list[$i];
        success_json($users);
    }
    /**
     * 会员卡设置
     */
    public function vipcard(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_vipcard_list(){
        $model = new Vipcard();
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->select();
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function editbalance(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id=input('get.id');
        $info = \app\model\User::get(['id'=>$id]);
        $this->view->info = $info;
        return view('editbalance');
    }
    public function savebalance(){
        global $_W,$_GPC;
        $bal=new Userbalancerecord();
        $id = input('post.id');
        $type=input('post.type');
        $money=input('post.money');
        if($id>0&&$money>0){
            if($type==2){
                $money=-$money;
            }
            $bal->addBalanceRecord($id,$_W['uniacid'],4,$send_money='0.00',$money,'','',$remark='后台修改操作');
            return array(
                'code'=>0,
                'data'=>1
            );
        }
    }
}
