<?php
namespace app\admin\controller;
use app\model\Dingtalk;
use app\model\System;
use think\Loader;
use app\base\controller\Admin;


class Cwelfaregroup extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save(){
        $info = new System();
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

    public function set(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model=new System();
        $info = $model->where(['uniacid'=>$_W['uniacid']])->find();
        $this->view->info = $info;
        return view('set');
    }





}
