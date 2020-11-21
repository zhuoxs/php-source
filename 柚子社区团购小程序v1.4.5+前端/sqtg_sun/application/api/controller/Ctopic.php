<?php
namespace app\api\controller;

use app\base\controller\Api;
use app\model\Collection;
use app\model\Topic;

class Ctopic extends Api
{
//    获取话题详情，
//    传入：
//        id:话题id
    public function getTopic(){
        $id = input('request.id');
        $user_id = input('request.user_id');
        $topic = Topic::get($id);
        $topic->inc('see_count');
        $topic->allowField(true)->save();

        $collection = Collection::get([
            'user_id'=>$user_id,
            'topic_id' =>$id,
            'collect_state'=>1,
        ]);
        $topic->collection_id = $collection->id?:0;

        success_withimg_json($topic);
    }
//    获取话题列表
    public function getTopics(){
        $topic_model = new Topic();
        $topic_model->fill_order_limit();//分页，排序
        $list = $topic_model->select();
        $count = $topic_model->count();
        success_withimg_json($list,['count'=>$count]);
    }
}
