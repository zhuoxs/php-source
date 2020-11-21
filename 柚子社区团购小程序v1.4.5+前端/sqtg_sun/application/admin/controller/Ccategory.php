<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Config;

class Ccategory extends Admin
{

//    获取列表页数据
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

        $list = $model->where($query)->select();

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
            'index_hot_switch'=>0,
            'index_today_switch'=>0,
            'index_yesterday_switch'=>0,
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
            'index_hot_switch'=>1,
            'index_today_switch'=>1,
            'index_yesterday_switch'=>1,
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
}
