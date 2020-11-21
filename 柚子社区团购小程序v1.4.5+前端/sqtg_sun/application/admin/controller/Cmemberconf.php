<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 16:50
 */
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Memberconf;

class Cmemberconf extends Admin{
    public function member(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('member');
    }
    public function get_memberconf_list(){
        global $_W;
        $model =new Memberconf();

        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $order['level']='asc';
        $list = $model->where($where)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function save(){
        $info = $this->model;
        $id = input('post.id');
        $level=input('post.level');
        if ($id){
            $info = $info->get($id);
            if($info['level']!=$level){
                $mem=new Memberconf();
                $isset=$mem->mfind(['level'=>$level]);
                if($isset){
                    return array(
                        'code'=>1,
                        'msg'=>'等级数需唯一',
                    );
                }
            }
        }else{
            $mem=new Memberconf();
            $isset=$mem->mfind(['level'=>$level]);
            if($isset){
                return array(
                    'code'=>1,
                    'msg'=>'等级数需唯一',
                );
            }
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