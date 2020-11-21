<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Leader;
use app\model\Storeleader;

class Cstoreleader extends Admin
{
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $leader_ids = Leader::where('name','like',"%$key%")->column('id');
                $query->whereIn('leader_id',$leader_ids);
            }
            $query->where('store_id',$_SESSION['admin']['store_id']);
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with('leaders')->where($query)->select();

        foreach ($list as &$item) {
            if ($item['leaders'][0]){
                $item = array_merge(json_decode(json_encode($item['leaders'][0]),true),json_decode(json_encode($item),true));
            }
        }

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function batchadd(){
        $ids = input('request.ids');
        $ids = explode(',',$ids);
        $store_id = $_SESSION['admin']['store_id'];

        foreach ($ids as $id) {
            $storeleader = Storeleader::get([
                    'store_id'=>$store_id,
                    'leader_id'=>$id,
                ]);
            if ($storeleader){
                continue;
            }
            $model = new Storeleader();
            $model->save([
                'store_id'=>$store_id,
                'leader_id'=>$id,
            ]);
        }

        return [
            'code'=>0,
            'msg'=>'添加成功',
        ];
    }
}
