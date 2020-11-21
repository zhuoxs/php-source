<?php
namespace app\api\controller;

use app\base\controller\Api;
use app\model\Collection;

class Ccollection extends Api
{
//    获取收藏列表
    public function getCollections(){
        global $_W;
        $model = new Collection();
        $key = input('request.key');
        $type = input('request.type',1);
        if ($type == 1){
            if($key){
                $model = Collection::hasWhere('goods',['name'=>['like',"%$key%"]]);
            }
            $model->with('goods');
        }else if ($type == 2){
            if($key){
                $model = Collection::hasWhere('store',['name'=>['like',"%$key%"]]);
            }
            $model->with('store');
        }else if ($type == 3){
            if($key){
                $model = Collection::hasWhere('topic',['like'=>['like',"%$key%"]]);
            }
            $model->with('topic');
        }

        //条件
        $query = function ($query){
            $type = input('request.type',1);
            if ($type){
                $query->where('type',$type);
            }
            $user_id = input('request.user_id');
            if ($user_id){
                $query->where('user_id',$user_id);
            }
            //收藏状态
            $query->where('collect_state',1);
        };

        //分页
        $page = input('request.page',1);
        $limit = input('request.limit')?:10;
        if($page){
            $model->limit($limit)->page($page);
        }

        $list = $model->where($query)->select();

        success_json($list,['img_root'=>$_W['attachurl'],'count'=>$model->where($query)->count()]);
    }
//    添加收藏
    public function addCollection(){
        $data = array();

        $data['user_id'] = input('request.user_id');
        $data['goods_id'] = input('request.goods_id',0);
        $data['store_id'] = input('request.store_id',0);
        $data['topic_id'] = input('request.topic_id',0);
        if ($data['goods_id']){
            $data['type'] = 1;
        }
        if ($data['store_id']){
            $data['type'] = 2;
        }
        if ($data['topic_id']){
            $data['type'] = 3;
        }

        $collection = new Collection();
        $ret = $collection->allowField(true)->save($data);
        if (!$ret){
            error_json('收藏失败');
        }
        success_json($collection->id);
    }
//    取消收藏
    public function cancelCollection(){
        $id = input('request.id');
        $ret = Collection::cancel($id);
        if (!$ret){
            error_json('取消收藏失败');
        }
        success_json($id);
    }
}
