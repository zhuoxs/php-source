<?php
namespace app\admin\controller;

use app\model\Config;

class Cstorecategory extends Base
{
    public function get_list(){
        global $_W,$_GPC;

        $model = $this->model;

        //条件
        $query = function ($query){
            if(pdo_fieldexists('yztc_sun_storecategory', 'is_del')){
                $query->where('is_del',0);
            }
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
    public function setting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $info['goods_insert_check'] = Config::get_value('goods_insert_check',0);
        $info['goods_update_check'] = Config::get_value('goods_update_check',0);
        $info['mstore_switch'] = Config::get_value('mstore_switch',0);

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

    public function selectrules(){
        $model = $this->model;
       // $model->where('store_id',$_SESSION['admin']['store_id']);
        $model->where(['is_del'=>0])->field("id,name as text")->order('sort desc');
        $list = $model->select();
        return $list;
    }



}
