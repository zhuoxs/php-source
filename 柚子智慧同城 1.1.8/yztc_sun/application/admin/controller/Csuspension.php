<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/29
 * Time: 14:40
 */
namespace app\admin\controller;




use app\model\Suspension;

class Csuspension extends Base{
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        $info = $this->model->get_curr();
        $this->view->info = $info;
        return view('edit');
    }
    public function save(){
        $info = new Suspension();

        $id = input('post.id');
        if ($id){
            $info = $info->get_curr();
            $ret = $info->allowField(true)->save(input('post.'),['id'=>$id]);
        }else{
            $ret = $info->allowField(true)->save(input('post.'));
        }
//        var_dump($info);exit;

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