<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Config;
use app\model\System;

class Cstore extends Admin
{
//    获取列表页数据
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name|tel','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->order('create_time desc')->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function setting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $info['goods_insert_check'] = Config::get_value('goods_insert_check',0);
        $info['goods_update_check'] = Config::get_value('goods_update_check',0);
        $info['mstore_switch'] = Config::get_value('mstore_switch',0);
        $info['mstore_apply_detail'] = Config::get_value('mstore_apply_detail','');
        $info['mstore_apply_bgm'] = Config::get_value('mstore_apply_bgm','');

        $this->view->info = $info;
        return view();
    }
    public function setting_save(){
        $info = new Config();

        $data = input('post.');

        $list = [];

        $list[] = Config::full_id('goods_insert_check',$data['goods_insert_check']);
        $list[] = Config::full_id('goods_update_check',$data['goods_update_check']);
        $list[] = Config::full_id('mstore_switch',$data['mstore_switch']);
        $list[] = Config::full_id('mstore_apply_detail',$data['mstore_apply_detail']);
        $list[] = Config::full_id('mstore_apply_bgm',$data['mstore_apply_bgm']);

        $ret = $info->allowField(true)->saveAll($list);

        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    //    数据保存（新增、编辑）
    public function save(){
        $info = $this->model;

        $data = input('post.');

        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }

        if($_SESSION['admin']['store_id']){
            $data['check_state'] = 1;
            $data['fail_reason'] = '';
        }

        $ret = $info->allowField(true)->save($data);

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
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        $this->view->info = $info;

        $this->view->system = System::get_curr();
        return view('edit');
    }
}
