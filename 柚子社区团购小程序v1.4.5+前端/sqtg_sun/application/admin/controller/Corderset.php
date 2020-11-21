<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\System;

class Corderset extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }
    public function set(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model=new System();
        $system= $model->where(['uniacid'=>$_W['uniacid']])->find();
        $info=unserialize($system['showorderset']);
        if($system){
            $info['id']=$system['id'];
        }
        $this->view->info = $info;
        return view('set');
    }

    public function save(){
        $info = new System();
        $id = input('post.id');
        $post=input('post.');
        $post['showorderset']=serialize($post['formdata']);
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

}
