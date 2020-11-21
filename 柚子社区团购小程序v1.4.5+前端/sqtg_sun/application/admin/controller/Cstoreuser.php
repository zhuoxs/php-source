<?php
namespace app\admin\controller;
use app\base\controller\Admin;
use app\model\Store;
use app\model\Storeuser;

class Cstoreuser extends Admin
{
    //    获取列表页数据
    public function get_list(){
        $key = input('get.key','');

        //条件
        $query = function ($query){
            $query->where('store_id',$_SESSION['admin']['store_id']);
        };

        $model = Storeuser::hasWhere('user',['name'=>['like',"%$key%"]]);

        //分页
        $page = input('request.page')?input('request.page'):1;
        $limit = input('request.limit')?input('request.limit'):10;
        if($page){
            $model->limit($limit)->page($page);
        }

        //排序
        $order = input('request.orderfield');
        if($order){
            $model->order($order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }

        $list = $model->where($query)->with('user')->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function batchadduser(){
        $id = input("post.id");
        $data = [];
        $data['user_id'] = $id;
        $data['store_id'] = $_SESSION['admin']['store_id'];

        $user = \app\model\User::get($id);
        if (!$user->id){
            throw new \ZhyException('不存在该用户，请核对用户id是否正确');
        }
        $storeuser = Storeuser::get(['user_id'=>$id]);
        if ($storeuser->id){
            throw new \ZhyException('该用户已经是核销员，不能再次添加');
        }
        $store = Store::get(['user_id'=>$id]);
        if ($store->id){
            throw new \ZhyException('该用户不能添加为核销员');
        }


        $ret = $this->model->allowField(true)->save($data);
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
}
