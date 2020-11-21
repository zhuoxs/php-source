<?php
namespace app\admin\controller;

use app\base\controller\Admin;

class Crobot extends Admin
{
    //    获取列表页数据
    public function get_list(){
        global $_W;

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

        foreach ($list as &$item) {
            $item['img'] = $_W['attachurl'].$item['img'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
}
