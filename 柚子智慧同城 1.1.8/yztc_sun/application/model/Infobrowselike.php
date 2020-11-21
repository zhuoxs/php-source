<?php

namespace app\model;
class Infobrowselike extends Base
{
    //获取我的收藏数量
    public function getMyLikeNum($user_id){
        $num=$this->where(['user_id'=>$user_id,'type'=>2,'collect_status'=>1])->count();
        return $num;
    }
    //增加浏览记录、浏览量和人气
    public function setBrowse($user_id,$info_id){
        $this->allowField(true)->save(['user_id'=>$user_id,'type'=>1,'info_id'=>$info_id]);
        (new Info())->where(['id'=>$info_id])->setInc('pageviews_num',1);
        (new Info())->where(['id'=>$info_id])->setInc('popularity_num',1);
    }
    //统计浏览人数
    public function getBrowseNum($info_id){
        $num=$this->where(['info_id'=>$info_id,'type'=>1])->group('user_id')->count();
        return $num;
    }
    //统计收藏人数
    public function getLikeNum($info_id){
        $num=$this->where(['info_id'=>$info_id,'type'=>2,'collect_status'=>1])->group('user_id')->count();
        return $num;
    }
    //获取帖子是否点赞收藏
    public function getIsLike($user_id,$info_id){
        $data=$this->where(['user_id'=>$user_id,'info_id'=>$info_id,'type'=>2,'collect_status'=>1])->find();
        if($data){
            return 1;
        }else{
            return 0;
        }
    }

    //点赞取消点赞
    public function setLike($user_id,$info_id){
        $data=$this->where(['user_id'=>$user_id,'info_id'=>$info_id,'type'=>2])->find();
        if($data['collect_status']==1){
            //取消点赞(收藏)
            $this->allowField(true)->save(['collect_status'=>2,'cancel_time'=>time()],['id'=>$data['id']]);
        }else{
            //点赞(收藏)
            if($data){
                $this->allowField(true)->save(['collect_status'=>1,'collect_time'=>time()],['id'=>$data['id']]);
            }else{
                //增加人气
                (new Info())->where(['id'=>$info_id])->setInc('popularity_num',1);
                $data=[
                    'user_id'=>$user_id,
                    'info_id'=>$info_id,
                    'type'=>2,
                    'collect_status'=>1,
                    'collect_time'=>time()
                ];
                $this->allowField(true)->save($data);
            }
        }
    }
}
