<?php
/**
 * User: YangXinlan
 * DateTime: 2019/2/25 11:24
 */
namespace app\admin\controller;

use app\model\Freesheet;
use app\model\Freesheetorder;

class Cfreesheet extends Base
{
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model = $this->model;
        $id = input('get.id');
        $info = $model->get($id);
        $info['pics'] = json_decode($info['pics']);
        $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
        $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
        $info['lottery_time']=date('Y-m-d H:i:s',$info['lottery_time']);
        $info['expire_time']=date('Y-m-d H:i:s',$info['expire_time']);
        $this->view->info = $info;
        return view('edit');
    }
    public function save(){
        $info = $this->model;
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $data=input('post.');
        $data['start_time']=strtotime(input('post.start_time'));
        $data['end_time']=strtotime(input('post.end_time'));
        $data['lottery_time']=strtotime(input('post.lottery_time'));
        $data['expire_time']=strtotime(input('post.expire_time'));
        $data['pics'] = json_encode($data['pics']);
        $data['check_status']=2;
        if($data['expire_time']<$data['lottery_time']){
            return array('code'=>1, 'msg'=>'过期时间需大于开奖时间',);
        }
        if($data['lottery_time']<$data['end_time']){
            return array('code'=>1, 'msg'=>'开奖时间需大于结束时间',);
        }
        if($data['end_time']<$data['start_time']){
            return array('code'=>1, 'msg'=>'结束时间需大于开始时间',);
        }
        $ret = $info->allowField(true)->save($data);
        if($id>0){
            if($info['is_activity']==1){
                $act['name']=$data['name'];
                $act['store_id']=$data['store_id'];
                $act['start_time']=$data['use_starttime'];
                $act['end_time']=$data['end_time'];
                $act['original_price']=0;
                $act['sale_price']=$data['getmoney'];
                $act['vip_price']=0;
                $act['pic']=$data['pic'];
                $act['check_status']=$data['check_status'];
                $act['state']=$data['state'];
                \app\model\Activity::update($act,['type'=>5,'goods_id'=>$id]);
            }
        }

        if($ret){
            return array(
                'code'=>0,
                'data'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    public function get_list(){
        $model = $this->model;
        //条件
        $query = function ($query) {
            //关键字搜索
            $key = input('get.key');
            if ($key) {
                $query->where('name', 'like', "%$key%");
            }
            $cat_id = input('get.cat_id');
            if ($cat_id) {
                $query->where('cat_id', "$cat_id");
            }
            $store_id=input('get.store_id');
            if ($store_id) {
                $query->where('store_id', "$store_id");
            }
            if ($_SESSION['admin']['store_id'] > 0) {
                $query->where('store_id', $_SESSION['admin']['store_id']);
            }
        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->with('store')->where($query)->select();
        foreach ($list as $key =>$value){
            $list[$key]['store_name']=$value['store']['name'];
        }
        return [
            'code' => 0,
            'count' => $model->where($query)->count(),
            'data' => $list,
            'msg' => '',
        ];
    }
    //免单规则设置
    public  function ruleset(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $info['freesheet_rules'] = \app\model\Config::get_value('freesheet_rules',0);

        $this->view->info = $info;
        return view();
    }
    public function saveset(){
        $info = new \app\model\Config();

        $data = input('post.');

        $list = [];

        $list[] = \app\model\Config::full_id('freesheet_rules',$data['freesheet_rules']);

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
    /**
     * 参与列表
    */
    public function joinlist(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $goods_id = input('get.goods_id');
        $this->view->goods_id = $goods_id;
        return view();
    }
    public function get_join_list(){
        $model =new Freesheetorder();
        //条件
        $query = function ($query) {
            //关键字搜索
            $key = input('get.key');
            if ($key) {
                $query->where('order_no', 'like', "%$key%");
            }
            $lottery_status = input('get.lottery_status');
            if ($lottery_status) {
                $query->where('lottery_status', "$lottery_status");
            }
            $goods_id=input('get.goods_id');
            $query->where('goods_id','=',$goods_id);
        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->select();
        foreach ($list as $key =>$value){
            $list[$key]['nickname']=\app\model\User::get($value['user_id'])['nickname'];
        }

        return [
            'code' => 0,
            'count' => $model->where($query)->count(),
            'data' => $list,
            'msg' => '',
        ];
    }
    //TODO:：添加活动列表
    public function btnBatchAddActivity(){
        $ids=input('post.ids');
        $info=new Freesheet();
        $ret =$info->where('id','in',$ids)->update(['is_activity'=>1]);
        $idslist=explode(',',$ids);
        foreach ($idslist as $value){
            $model=new \app\model\Activity();
            $infos=Freesheet::get($value);
            $data['type']=5;
            $data['name']=$infos['name'];
            $data['cat_id']=$infos['cat_id'];
            $data['goods_id']=$value;
            $data['store_id']=$infos['store_id'];
            $data['start_time']=$infos['start_time'];
            $data['end_time']=$infos['end_time'];
            $data['pic']=$infos['pic'];
            $data['check_status']=$infos['check_status'];
            $data['state']=$infos['state'];
            $model->allowField(true)->save($data);
        }
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'添加失败',
            );
        }
    }
    //TODO::删除添加到活动列表
    public function btnBatchDelActivity(){
        $ids = input("post.ids");
        $model=new \app\model\Activity();
        $idslist=explode(',',$ids);
        foreach ($idslist as $value){
            $model->where(['goods_id'=>$value,'type'=>2])->delete();
        }
        $free=new Freesheet();
        $ret =$free->where('id','in',$ids)->update(['is_activity'=>0]);
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
    //TODO::预中奖
    public function PrePrize(){
        $id = input("post.id");
        $model =new Freesheetorder();
        $orderinfo=$model->mfind(['id'=>$id]);
        $pre_num=$model->preprizeNum($orderinfo['goods_id']);
        $goods_info=Freesheet::get($orderinfo['goods_id']);
        if($goods_info['allnum']>$pre_num){
            $ret = $model->where(['id'=>$id])->update(['pre_prize'=>1]);
            if($ret){
                return array('code'=>0,);
            }else{
                return array('code'=>1, 'msg'=>'设置失败',);
            }
        }else{
            return array('code'=>1, 'msg'=>'已达到中奖人数上限',);
        }
    }
    //TODO::取消预中奖
    public function CancelPrePrize(){
        $id = input("post.id");
        $model =new Freesheetorder();
        $ret = $model->where(['id'=>$id])->update(['pre_prize'=>0]);
        if($ret){
            return array('code'=>0,);
        }else{
            return array('code'=>1, 'msg'=>'设置失败',);
        }
    }

    //TODO::开奖
    public function openPrize(){
        $goods_id=input('post.goods_id');
        $freesheet=Freesheet::get(['id'=>$goods_id,'is_del'=>0,'state'=>1,'check_status'=>2]);
        if(($freesheet['lottety_time']<time())&&($freesheet['is_lottery']==0)){

        }else{
            return array('code'=>1, 'msg'=>'当前无法开奖',);
        }
    }
}