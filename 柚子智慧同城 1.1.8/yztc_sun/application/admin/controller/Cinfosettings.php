<?php
namespace app\admin\controller;
use app\model\Infosettings;



class Cinfosettings extends Base
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
    public function set(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = Infosettings::get_curr();
        $this->view->info = $info;
        return view('set');
    }
    public function save_set(){
        global $_W,$_GPC;
        $info = new Infosettings();
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $post=input('post.');
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
