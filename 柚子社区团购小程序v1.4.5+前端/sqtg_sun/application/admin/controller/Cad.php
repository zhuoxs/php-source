<?php
namespace app\admin\controller;

use app\base\controller\Admin;

class Cad extends Admin
{
    public function get_list(){
        global $_W,$_GPC;

        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('title','like',"%$key%");
            }
            $type = input('get.type');
            if ($type){
                $query->where('type','=',"$type");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->select();
        foreach ($list as &$item) {
            $item['pic'] = $_W['attachurl']. $item['pic'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
}
