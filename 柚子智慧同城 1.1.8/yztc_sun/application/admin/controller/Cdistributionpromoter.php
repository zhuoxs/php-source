<?php
namespace app\admin\controller;

use app\model\Distributionpromoter;

use app\model\User;
use think\Db;

class Cdistributionpromoter extends Base
{
    public function get_list(){
        global $_W,$_GPC;
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
        foreach ($list as &$val){
            $user=User::get($val['user_id']);
            $val['nickname']=$user['nickname'];
            $val['pic']=$user['avatar'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    public function batchchecked(){
        $ids = input("post.ids");
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['check_status'=>2,'check_time'=>time()]);
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


}
