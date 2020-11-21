<?php
namespace app\admin\controller;
use app\model\Printset;

use app\base\controller\Admin;

class Cprints extends Admin
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
        $post['store_id']=$_SESSION['admin']['store_id'];
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
        foreach ($list as &$val){
            $val['type_z']='飞鹅';
        }

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function set(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model=new Printset();
        $info = $model->where(['store_id'=>$_SESSION['admin']['store_id'],'uniacid'=>$_W['uniacid']])->find();
        $info['print_type_z']=explode(',',$info['print_type']);
        $this->view->info = $info;
        return view('set');
    }
    public function save_set(){
        global $_W,$_GPC;
        $info = new Printset();
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $post=input('post.');
        $post['print_type']=implode(',',$post['print_type']);
        $post['store_id']=$_SESSION['admin']['store_id'];
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

    public function select(){
        $model = $this->model;
        $model->field("id,name as text");
        $list = $model->where(['store_id'=>$_SESSION['admin']['store_id']])->select();
        return $list;
    }




}
