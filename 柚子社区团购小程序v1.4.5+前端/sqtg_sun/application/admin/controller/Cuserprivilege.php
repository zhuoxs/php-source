<?php
namespace app\admin\controller;
use app\model\Userprivilege;
use app\base\controller\Admin;

class Cuserprivilege extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save(){
        $info = $this->model;
        $id = input('post.id');
        $post=input('post.');
        if ($id){
            $info = $info->get($id);
        }
        $ret = $info->allowField(true)->save($post);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
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
        $list = $model->where($query)->order('sort asc,id asc')->select();
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }






}
