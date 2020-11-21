<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Dingtalk;
use think\Loader;



class Cdingtalk extends Admin
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

    public function set(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model=new Dingtalk();
        $info = $model->where(['store_id'=>$_SESSION['admin']['store_id'],'uniacid'=>$_W['uniacid']])->find();
        $this->view->info = $info;
        return view('set');
    }





}
