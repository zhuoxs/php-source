<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24
 * Time: 11:11
 */
namespace app\admin\controller;

use app\base\controller\Admin;

class Csuggest extends Admin
{
    //    获取列表页数据
    public function get_list()
    {
        $model = $this->model;

        //条件
        $query = function ($query) {
            //关键字搜索
            $key = input('get.key');
            if ($key) {
                $query->where('content', 'like', "%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->with('user')->select();

        return [
            'code' => 0,
            'count' => $model->where($query)->count(),
            'data' => $list,
            'msg' => '',
        ];
    }
}