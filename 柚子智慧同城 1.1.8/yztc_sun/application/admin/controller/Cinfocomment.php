<?php
namespace app\admin\controller;
use app\model\User;
use app\model\Info;

class Cinfocomment extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save(){
        $info = $this->model;
        $id = input('post.id');
        $post=input('post.');
        if ($id){
            $info = $info->get($id);
        }
        $ret = $info->allowField(true)->save($post);
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
    public function get_list(){
        $model = $this->model;
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('content','like',"%$key%");
            }
            $query->where('is_del',0);
        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->order('id desc')->select();
        foreach ($list as &$val){
            $val['comment_type_z']=$val['comment_type']==1?'评论':'回复';
            $val['name']=User::get($val['user_id'])['nickname'];
            $to_name=User::get($val['to_user_id'])['nickname'];
            $val['to_name']=$to_name?$to_name:'';
            $val['info_content']=Info::get($val['info_id'])['content'];
            $val['check_time_z']=$val['check_time']?date('Y-m-d H:i',$val['check_time']):'';
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    public function delete($is_del=0){
        $ids = input('post.ids');
        $model = $this->model;
        $ret = $model->where('id','in',$ids)->update(['is_del'=>1]);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$ret,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'删除失败',
            );
        }
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
