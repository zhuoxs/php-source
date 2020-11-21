<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 17:25
 */
namespace app\admin\controller;

use app\model\Coupon;
use app\model\Couponget;
use app\model\Store;

class Ccoupon extends Base
{
    public function coupon(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $modelName=ucwords(strtolower(input('modelName'))); ;
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $id = input('get.id');
        $info = $model->get($id);
        $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
        $info['use_starttime']=date('Y-m-d H:i:s',$info['use_starttime']);
        $this->view->info = $info;
//        var_dump($modelName);exit;
        if($modelName){
            $page='add'.strtolower($modelName);
//            var_dump($page);exit;
            return view($page);
        }else{
            return view('edit');
        }
    }
    public function save(){
        $info = $this->model;
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $data=input('post.');
        $data['end_time']=strtotime(input('post.end_time'));
        $data['use_starttime']=strtotime(input('post.use_starttime'));
        $storeinfo=Store::get($data['store_id']);
        $data['lng']=$storeinfo['lng'];
        $data['lat']=$storeinfo['lat'];
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
                \app\model\Activity::update($act,['type'=>3,'goods_id'=>$id]);
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
    public function get_coupon_list(){
        $model = $this->model;
        //条件
        $query = function ($query){
            //关键字搜索
            if($_SESSION['admin']['store_id']>0){
                $query->where('store_id',$_SESSION['admin']['store_id']);
            }
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $store_id=input('get.store_id');
            if($store_id>0){
                $query->where('store_id','=',$store_id);
            }
        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->select();
        foreach ($list as $key =>$value){
            $list[$key]['end_time']=date('Y-m-d H:i:s',$value['end_time']);
            $list[$key]['use_starttime']=date('Y-m-d H:i:s',$value['use_starttime']);
            $list[$key]['sname']=Store::get($value['store_id'])['name'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    //TODO:：添加活动列表
    public function btnBatchAddActivity(){
        $ids=input('post.ids');
        $info=new Coupon();
        $ret =$info->where('id','in',$ids)->update(['is_activity'=>1]);
        $idslist=explode(',',$ids);
        foreach ($idslist as $value){
            $model=new \app\model\Activity();
            $coupon=Coupon::get($value);
            $data['type']=3;
            $data['name']=$coupon['name'];
            $data['cat_id']=0;
            $data['goods_id']=$value;
            $data['store_id']=$coupon['store_id'];
            $data['start_time']=$coupon['use_starttime'];
            $data['end_time']=$coupon['end_time'];
            $data['original_price']=0;
            $data['sale_price']=$coupon['getmoney'];
            $data['vip_price']=0;
            $data['pic']=$coupon['pic'];
            $data['check_status']=$coupon['check_status'];
            $data['state']=$coupon['state'];
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
    //删除添加到活动列表
    public function btnBatchDelActivity(){
        $ids = input("post.ids");
        $model=new \app\model\Activity();
        $idslist=explode(',',$ids);
        foreach ($idslist as $value){
            $model->where(['goods_id'=>$value,'type'=>3])->delete();
        }
        $coupon=new Coupon();
        $ret =$coupon->where('id','in',$ids)->update(['is_activity'=>0]);
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
    //查看领取记录
    public function getlist(){
        $cid=input('cid');
        $this->view->cid = $cid;
        return view();
    }
    public function get_getcoupon_list(){
//        var_dump(input());exit;
        $model = new Couponget();
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('order_no','like',"%$key%");
            }
            $cid=input('get.cid');
            if($cid>0){
                $query->where('cid','=',$cid);
            }
            $isuse=input('get.isuse');
            if($isuse==1){
                $query->where('write_off_status','=',0);
            }
            if($isuse==2){
                $query->where('write_off_status','=',2);
            }
        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->select();
        foreach ($list as $key =>$value){
            $list[$key]['end_time']=date('Y-m-d H:i:s',$value['end_time']);
            $list[$key]['write_off_time']=$value['write_off_time']?date('Y-m-d H:i:s',$value['write_off_time']):'未使用';
            $userinfo=\app\model\User::get($value['user_id']);
            $list[$key]['nickname']=$userinfo['nickname'];
            if($value['help_uid']>0){
                $list[$key]['help_nickname']=\app\model\User::get($value['help_uid'])['nickname'];
            }
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
}
