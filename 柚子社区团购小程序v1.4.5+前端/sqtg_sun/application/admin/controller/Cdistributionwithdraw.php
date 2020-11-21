<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Distributionwithdraw;

class Cdistributionwithdraw extends Admin
{

//    获取列表页数据
    public function get_list(){
        $key = input('get.key','');
        $model = Distributionwithdraw::hasWhere('distribution',['name'=>['like',"%$key%"]]);

        //条件
        $query = function ($query){
            $state = input("request.state",0);
            switch ($state){
                case 1:
                    $query->where('check_state',0);
                    break;
                case 2:
                    $query->where('check_state',1)
                        ->where('state',0);
                    break;
                case 3:
                    $query->where('state',1);
                    break;
                case 4:
                    $query->where('check_state',2);
                    break;
                case 5:
                    $query->where('state',2);
                    break;
            }
        };

        //分页
        $page = input('request.page')?input('request.page'):1;
        $limit = input('request.limit')?input('request.limit'):10;
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

        $list = $model->with('distribution')->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
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
            $ret = Distributionwithdraw::checked($id);
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
            $ret = Distributionwithdraw::checkedfail($id,$fail_reason);
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
            $ret = Distributionwithdraw::take($id);
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
