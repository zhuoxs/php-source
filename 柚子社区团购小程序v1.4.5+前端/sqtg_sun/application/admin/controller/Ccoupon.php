<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Config;
use app\model\Coupon;
use app\model\Usercoupon;
use think\Exception;
use app\model\User;
class Ccoupon extends Admin
{
//    复制编辑页
    public function copy(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        $info->left_num = $info->num;
        unset($info->id);
        $this->view->info = $info;
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
        $user_ids = $data['user_ids'];
        if (count($user_ids)){
            $data['left_num'] = count($user_ids);
        }
        if ($data['all']){
            $user = new User();
            $user_ids = $user->column('id');
            if($data['left_num']<count($user_ids)){
                return array(
                    'code'=>1,
                    'msg'=>'发放数量大于剩余数量',
                );
            }
        }
        $info->startTrans();
        $ret = $info->allowField(true)->save($data);
        if (count($user_ids)){
            $user_count = 0;
            foreach ($user_ids as $user_id) {
                $coupon = $info;

                $usercoupon = Usercoupon::get(['coupon_id'=>$coupon->id,'user_id'=>$user_id]);
                if (!!$usercoupon){
                    continue;
                }

                $model = new Usercoupon();
                $ret1 = $model->allowField(true)->save([
                    'user_id' => $user_id,
                    'coupon_id' => $coupon->id,
                    'end_time' => min($coupon->getData('end_time'),time()+($coupon['days']*24*60*60)),
                    'state' => 1,
                    'name' => $coupon['name'],
                    'info' => $coupon['info'],
                    'money' => $coupon['money'],
                    'use_money' => $coupon['use_money'],
                ]);
                if ($ret1){
                    $user_count ++;
                }
            }
            if ($user_count != count($user_ids)){
                $info->allowField(true)->save(['left_num'=>0]);
            }
        }

        if($ret){
            $info->commit();
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            $info->rollback();
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    public function setting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $configs = [
            'coupon_index_switch'=>0,
            'coupon_window_switch'=>0,
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
            'coupon_index_switch'=>0,
            'coupon_window_switch'=>0,
        ];
        foreach ($configs as $key => $value) {
            $list[] = Config::full_id($key,$data[$key],$value);
        }

        $ret = $info->allowField(true)->saveAll($list);

        if($ret!==false){
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
