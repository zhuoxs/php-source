<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Config;
use app\model\Distribution;
use app\model\User;

class Cdistribution extends Admin
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

        $list = $model->with('user')->where($query)->select();
        $distribution_model = new Distribution();
        foreach ($list as &$item) {
            $item['childs_count'] = $distribution_model->where('parent_id',$item['id'])->count();
        }

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    //    审核通过
    public function batchchecked(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['check_state'=>2,'check_time'=>time()]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'审核失败',
            );
        }
    }

    //    基本设置
    public function setting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $this->view->level = Config::get_value('distribution_level',0);
        $info = [];

        $configs = [
            'distribution_relation'=>0,
            'distribution_apply'=>0,
            'distribution_apply_bgm'=>'',
//协议
            'distribution_apply_agreement'=>'',
            'distribution_apply_title'=>'',
            'distribution_apply_show'=>'',
            //            推广
            'distribution_share_title'=>'',
            'distribution_share_banner'=>'',
            'distribution_share_msg'=>'',
//层级
            'distribution_level'=>0,
            'distribution_self'=>0,
            'distribution_draw_type'=>1,
            'distribution_rate_level1'=>0,
            'distribution_rate_level2'=>0,
            'distribution_rate_level3'=>0,
            'distribution_money_level1'=>0,
            'distribution_money_level2'=>0,
            'distribution_money_level3'=>0,
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
            'distribution_relation'=>0,
            'distribution_apply'=>0,
            'distribution_apply_bgm'=>'',
            //协议
            'distribution_apply_agreement'=>'',
            'distribution_apply_title'=>'',
            'distribution_apply_show'=>'',
//            推广
            'distribution_share_title'=>'',
            'distribution_share_banner'=>'',
            'distribution_share_msg'=>'',
            //层级
            'distribution_level'=>0,
            'distribution_self'=>0,
            'distribution_draw_type'=>1,
            'distribution_rate_level1'=>0,
            'distribution_rate_level2'=>0,
            'distribution_rate_level3'=>0,
            'distribution_money_level1'=>0,
            'distribution_money_level2'=>0,
            'distribution_money_level3'=>0,
        ];

        foreach ($configs as $key => $value) {
            if (in_array($key,['distribution_rate_level1','distribution_rate_level2','distribution_rate_level3','distribution_money_level1','distribution_money_level2','distribution_money_level3'])){
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

    //    推广设置
    public function sharesetting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $configs = [
            'distribution_share_img'=>'',
            'distribution_share_title'=>'',
            'distribution_share_banner'=>'',
            'distribution_share_msg'=>'',
        ];
        foreach ($configs as $key => $value) {
            $info[$key] = Config::get_value($key,$value);
        }

        $this->view->info = $info;
        return view();
    }
    public function sharesetting_save(){
        $info = new Config();

        $data = input('post.');

        $list = [];
        $configs = [
            'distribution_share_title'=>'',
            'distribution_share_msg'=>'',
            'distribution_share_banner'=>'',
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

    //    申请协议设置
    public function applysetting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $configs = [
            'distribution_apply_agreement'=>'',
            'distribution_apply_title'=>'',
            'distribution_apply_show'=>'',
        ];
        foreach ($configs as $key => $value) {
            $info[$key] = Config::get_value($key,$value);
        }

        $this->view->info = $info;
        return view();
    }
    public function applysetting_save(){
        $info = new Config();

        $data = input('post.');

        $list = [];
        $configs = [
            'distribution_apply_agreement'=>'',
            'distribution_apply_title'=>'',
            'distribution_apply_show'=>'',
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

    //    层级设置
    public function levelsetting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $this->view->level = Config::get_value('distribution_level',0);
        $info = [];

        $configs = [
            'distribution_level'=>0,
            'distribution_self'=>0,
            'distribution_draw_type'=>1,
            'distribution_rate_level1'=>0,
            'distribution_rate_level2'=>0,
            'distribution_rate_level3'=>0,
            'distribution_money_level1'=>0,
            'distribution_money_level2'=>0,
            'distribution_money_level3'=>0,
        ];
        foreach ($configs as $key => $value) {
            $info[$key] = Config::get_value($key,$value);
        }

        $this->view->info = $info;
        return view();
    }
    public function levelsetting_save(){
        $info = new Config();

        $data = input('post.');

        $list = [];
        $configs = [
            'distribution_level'=>0,
            'distribution_self'=>0,
            'distribution_draw_type'=>1,
            'distribution_rate_level1'=>0,
            'distribution_rate_level2'=>0,
            'distribution_rate_level3'=>0,
            'distribution_money_level1'=>0,
            'distribution_money_level2'=>0,
            'distribution_money_level3'=>0,
        ];
        foreach ($configs as $key => $value) {
            if (in_array($key,['distribution_rate_level1','distribution_rate_level2','distribution_rate_level3','distribution_money_level1','distribution_money_level2','distribution_money_level3'])){
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
        $this->view->level = Config::get_value('distribution_level',0);
        $info = [];

        $configs = [
            'distribution_withdraw_switch'=>0,
            'distribution_withdraw_type'=>'1',
            'distribution_withdraw_min'=>0,
            'distribution_withdraw_noapplymoney'=>0,
            'distribution_withdraw_wechatrate'=>0,
            'distribution_withdraw_alipayrate'=>0,
            'distribution_withdraw_bankrate'=>0,
            'distribution_withdraw_platformrate'=>0,
            'distribution_withdraw_time'=>0,
        ];
        foreach ($configs as $key => $value) {
            $info[$key] = Config::get_value($key,$value);
        }

        $info['distribution_withdraw_type'] = explode(',',$info['distribution_withdraw_type']);

        $this->view->info = $info;
        return view();
    }
    public function withdrawsetting_save(){
        $info = new Config();

        $data = input('post.');
        $data['distribution_withdraw_type'] = implode(',',json_decode(json_encode( $data['distribution_withdraw_type']),true));


        $list = [];
        $configs = [
            'distribution_withdraw_switch'=>0,
            'distribution_withdraw_type'=>'1',
            'distribution_withdraw_min'=>0,
            'distribution_withdraw_noapplymoney'=>0,
            'distribution_withdraw_wechatrate'=>0,
            'distribution_withdraw_alipayrate'=>0,
            'distribution_withdraw_bankrate'=>0,
            'distribution_withdraw_platformrate'=>0,
            'distribution_withdraw_time'=>0,
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
