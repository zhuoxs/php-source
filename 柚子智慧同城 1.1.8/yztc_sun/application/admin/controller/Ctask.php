<?php
namespace app\admin\controller;


use app\model\Config;

class Ctask extends Base
{
//    获取列表页数据
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('type|memo|value','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->order('id desc')->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
//    列表页
    public function index()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $config = Config::get(['key'=>'autotask','uniacid'=>$_W['uniacid']]);
        if(!$config){
            $config = new Config();
            $config->key = 'autotask';
            $config->value = 0;
            $config->save();
        }
        $this->view->taskconfig = $config;
        return view();
    }
//    开启自动执行任务
    public function starttask(){
//        调用任务执行事件
        startTask();
        return array(
            'code'=>0,
        );
    }
//    关闭自动执行任务
    public function closetask(){
        global $_W;
        $config = Config::get(['key'=>'autotask','uniacid'=>$_W['uniacid']]);
        if(!$config){
            $config = new Config();
            $config->key = 'autotask';
        }
        $config->value = 0;
        $ret = $config->save();
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'关闭失败',
            );
        }
    }
}
