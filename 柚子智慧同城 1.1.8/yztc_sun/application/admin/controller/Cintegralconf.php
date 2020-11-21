<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 10:46
 */
namespace app\admin\controller;



use app\model\Integralconf;

class Cintegralconf extends Base{
    public function conf(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
//        $info['banner'] = json_decode($info['banner']);
        $this->view->info = $info;
        return view('conf');
    }
    public function saves(){
        $info = $this->model;
        $id = input('post.id');
        $data=input('post.');
//        $data['banner']=input('post.banner/a');
//        $data['banner'] = json_encode($data['banner']);
        if ($id){
            $info = $info->get($id);
            $ret = $info->allowField(true)->save($data,['id'=>$id]);
        }else{
            $ret = $info->allowField(true)->save($data);
        }
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