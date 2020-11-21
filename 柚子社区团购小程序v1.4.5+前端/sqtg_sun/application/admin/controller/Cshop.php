<?php
namespace app\admin\controller;
use app\base\controller\Admin;
use app\model\Shop;

class Cshop extends Admin
{
    public function get_list(){
        global $_W,$_GPC;

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
        foreach ($list as &$item) {
            if ($item['pic']){
                $item['pic'] = $_W['attachurl']. $item['pic'];
            }
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        $info['pics'] = json_decode($info['pics']);
        $this->view->info = $info;
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
        $data['pics'] = json_encode($data['pics']);
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
}
