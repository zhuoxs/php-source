<?php
namespace app\admin\controller;

use app\base\controller\Admin;


class Cadmin extends Admin
{
    //    获取列表页数据
    public function get_list(){
        global $_W;
        $model = $this->model;

        //条件
        $query = function ($query){
            $query->where('store_id',0);
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
            if ($item['img'] && substr($item['img'],0,4)!= 'http'){
                $item['img'] = $_W['attachurl']. $item['img'];
            }
        }

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    //    数据保存（新增、编辑）
    public function save(){
        $info = $this->model;

        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $data = input('post.');
        if (!$data['password']){
            unset($data['password']);
        }else{
            $data['password'] = md5($data['password']);
        }
        $ret = $info->allowField(true)->save($data);

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
    //    多商户
    public function get_list2(){
        global $_W;
        $model = $this->model;

        //条件
        $query = function ($query){
            $query->where('store_id',['<>',0]);
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $store_id = input('get.store_id');
            if ($store_id){
                $query->where('store_id',$store_id);
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with('store')->where($query)->select();
        foreach ($list as &$item) {
            if ($item['img'] && substr($item['img'],0,4)!= 'http'){
                $item['img'] = $_W['attachurl']. $item['img'];
            }
        }

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    //    多商户列表页
    public function index2()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    //    新增页
    public function add2(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
//        $this->view->info = $this->model;
        return view('edit2');
    }
//    编辑页
    public function edit2(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        $this->view->info = $info;
        return view('edit2');
    }
//    复制编辑页
    public function copy2(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        unset($info->id);
        $this->view->info = $info;
        return view('edit2');
    }
}
