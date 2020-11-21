<?php
namespace app\admin\controller;
use think\Loader;
use app\model\Distributionset;



class Cdistributionset extends Base
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
        $post['join_module']=implode(',',$post['join_module']);
        $post['withdraw_type']=implode(',',$post['withdraw_type']);
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
        $info=Distributionset::get_curr();
        $this->view->info = $info;
        return view('set');
    }





}
