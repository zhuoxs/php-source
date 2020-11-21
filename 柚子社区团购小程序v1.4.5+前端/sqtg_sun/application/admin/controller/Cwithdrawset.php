<?php
namespace app\admin\controller;
use app\base\controller\Admin;
class Cwithdrawset extends Admin
{
    public function config(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $this->view->info = $info;
        return view('config');
    }
    public function save(){
        $info = $this->model;

        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }

        $ret = $info->allowField(true)->save(input('post.'));
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
