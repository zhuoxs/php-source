<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Leader;
use app\model\Leaderwithdraw;

class Cleaderwithdraw extends Admin
{

//    获取列表页数据
    public function get_list(){
        $getModel = function (){
            $model = $this->model;
            $model->alias('t1')
                ->join('leader t2','t2.id = t1.leader_id');

            $key = input('get.key','');
            if ($key){
                $model->where('t2.name','like',"%$key%");
            }

            $state = input("request.state",0);
            switch ($state){
                case 1:
                    $model->where('t1.check_state',0);
                    break;
                case 2:
                    $model->where('t1.check_state',1)
                        ->where('t1.state',0);
                    break;
                case 3:
                    $model->where('t1.state',1);
                    break;
                case 4:
                    $model->where('t1.check_state',2);
                    break;
                case 5:
                    $model->where('state',2);
                    break;
            }

            return $model;
        };

        $model = $getModel();

        //分页
        $page = input('request.page',1);
        $limit = input('request.limit',10);
        if($page){
            $model->limit($limit)->page($page);
        }

        //排序
        $order = input('request.orderfield');
        if($order){
            $model->order($order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->order('create_time desc');
        }

        $list = $model->field('t1.*,t2.name as leader_name')->select();

        return [
            'code'=>0,
            'count'=>$getModel()->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

//    审核通过
    public function batchchecked(){
        $ids = input("request.ids");
        $ids = explode(',',$ids);
        $count = 0;
        foreach ($ids as $id) {
            $ret = Leaderwithdraw::checked($id);
            if ($ret['code']){
                return $ret;
            }else if($ret){
                return array(
                    'code'=>0,
                );
            }else{
                return array(
                    'code'=>1,
                    'msg'=>$ret['msg']?:'审核失败',
                );
            }
            if ($ret){
                $count++;
            }
        }

        if($count>0){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'审核失败',
            );
        }
    }
//    打回
    public function batchcheckedfail(){
        $ids = input("post.ids");
        $fail_reason = input("post.fail_reason");
        $ids = explode(',',$ids);
        $count = 0;
        foreach ($ids as $id) {
            $ret = Leaderwithdraw::checkedfail($id,$fail_reason);
            if ($ret){
                $count++;
            }
        }
        if($count>0){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'打回失败',
            );
        }
    }
//    批量打款
    public function batchtake(){
        $ids = input("request.ids");
        $ids = explode(',',$ids);
        $count = 0;
        foreach ($ids as $id) {
            $ret = Leaderwithdraw::take($id);
            if ($ret['code']){
                return $ret;
            }else if($ret){
                return array(
                    'code'=>0,
                );
            }else{
                return array(
                    'code'=>1,
                    'msg'=>$ret['msg']?:'打款失败',
                );
            }
            if ($ret){
                $count++;
            }
        }

        if($count>0){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'打款失败',
            );
        }
    }
}
