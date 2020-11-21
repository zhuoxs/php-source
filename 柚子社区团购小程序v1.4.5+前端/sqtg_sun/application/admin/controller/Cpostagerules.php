<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Ad;
use app\model\District;

class Cpostagerules extends Admin
{
    //    获取列表页数据
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            $query->where('store_id',$_SESSION['admin']['store_id']);
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
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $this->model->type = 1;
        $this->view->info = $this->model;

        $district = new District();
        $province = $district->where('level','province')->field('id,name')->select();
        $city = $district->where('level','city')->field('id,name,parent_id')->select();
        $this->view->province = $province;
        $this->view->city = $city;
        return view('edit');
    }
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        $this->view->info = $info;

        $district = new District();
        $province = $district->where('level','province')->field('id,name')->select();
        $city = $district->where('level','city')->field('id,name,parent_id')->select();
        $this->view->province = $province;
        $this->view->city = $city;
        return view('edit');
    }
    public function copy(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        unset($info->id);
        $this->view->info = $info;

        $district = new District();
        $province = $district->where('level','province')->field('id,name')->select();
        $city = $district->where('level','city')->field('id,name,parent_id')->select();
        $this->view->province = $province;
        $this->view->city = $city;
        return view('edit');
    }
//    数据保存（新增、编辑）
    public function save(){
        $info = $this->model;

        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $data = input('post.');
        if (!$data['store_id']){
            $data['store_id'] = $_SESSION['admin']['store_id'];
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

    public function selectrules(){
        $model = $this->model;
        $model->where('store_id',$_SESSION['admin']['store_id']);
        $model->field("id,name as text");
        $list = $model->select();
        return $list;
    }
}
