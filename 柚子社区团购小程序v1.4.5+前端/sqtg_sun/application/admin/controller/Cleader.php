<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Config;
use app\model\Ordergoods;
use app\model\Storeleader;
use app\model\System;

class Cleader extends Admin
{
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with('user')->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function get_list2(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }

            $leader_ids = Storeleader::where('store_id',$_SESSION['admin']['store_id'])
                ->column('leader_id');
            $query->whereNotIn('id',$leader_ids);

            $query->where('check_state',2);
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with('user')->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    public function choose3(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_list3(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $query->where('check_state',2);

            $leader_ids = Ordergoods::where('t1.store_id',$_SESSION['admin']['store_id'])
                ->alias('t1')
                ->join('Goods t2','t1.goods_id = t2.id')
                ->where('t2.end_time <= '.time().' or t2.state = 0')
                ->where('t1.state',2)
                ->column('t1.leader_id');

            $query->where('id',['in',$leader_ids]);
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with('user')->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    //    团长设置
    public function setting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $configs = [
            'leader_replace'=>'团长',
            'leader_draw_type'=>1,
            'leader_draw_rate'=>0,
            'leader_draw_money'=>0,
            'leader_choosegoods_switch'=>0,
            'leader_apply_detail'=>'',
            'leader_apply_bgm'=>'',
        ];
        foreach ($configs as $key => $value) {
            $info[$key] = Config::get_value($key,$value);
        }

        $this->view->info = $info;
        return view();
    }
    public function setting_save(){
        $info = new Config();

        $data = input('post.');

        $list = [];
        $configs = [
            'leader_replace'=>'团长',
            'leader_draw_type'=>1,
            'leader_draw_rate'=>0,
            'leader_draw_money'=>0,
            'leader_choosegoods_switch'=>0,
            'leader_apply_detail'=>'',
            'leader_apply_bgm'=>'',
        ];
        foreach ($configs as $key => $value) {
            if (in_array($key,['leader_draw_rate','leader_draw_money'])){
                $list[] = Config::full_id($key,sprintf("%.2f",$data[$key]),$value);
            }else{
                $list[] = Config::full_id($key,$data[$key],$value);
            }
        }

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
    //    提现设置
    public function withdrawsetting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $configs = [
            'leader_withdraw_switch'=>0,
            'leader_withdraw_type'=>'1',
            'leader_withdraw_min'=>0,
            'leader_withdraw_noapplymoney'=>0,
            'leader_withdraw_wechatrate'=>0,
            'leader_withdraw_alipayrate'=>0,
            'leader_withdraw_bankrate'=>0,
            'leader_withdraw_platformrate'=>0,
            'leader_withdraw_time'=>0,
        ];
        foreach ($configs as $key => $value) {
            $info[$key] = Config::get_value($key,$value);
        }

        $info['leader_withdraw_type'] = explode(',',$info['leader_withdraw_type']);
        $this->view->info = $info;
        return view();
    }
    public function withdrawsetting_save(){
        $info = new Config();

        $data = input('post.');
        $data['leader_withdraw_type'] = implode(',',json_decode(json_encode( $data['leader_withdraw_type']),true));

        $list = [];
        $configs = [
            'leader_withdraw_switch'=>0,
            'leader_withdraw_type'=>'1',
            'leader_withdraw_min'=>0,
            'leader_withdraw_noapplymoney'=>0,
            'leader_withdraw_wechatrate'=>0,
            'leader_withdraw_alipayrate'=>0,
            'leader_withdraw_bankrate'=>0,
            'leader_withdraw_platformrate'=>0,
            'leader_withdraw_time'=>0,
        ];
        foreach ($configs as $key => $value) {
            $list[] = Config::full_id($key,$data[$key],$value);
        }

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
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        $info['workday'] = explode(',',$info['workday']);
        $this->view->info = $info;

        $this->view->system = System::get_curr();
        return view('edit');
    }
    //    数据保存（新增、编辑）
    public function save(){
        $info = $this->model;

        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $data = input('post.');
        $data['workday'] = implode(',',json_decode(json_encode( $data['workday']),true));
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
    //    获取列表信息，用于前端 select2 请求
    public function select(){
        $model = $this->model;
        $model->field("id,name as text")
            ->where('check_state',2);
        $list = $model->select();
        return $list;
    }
}
