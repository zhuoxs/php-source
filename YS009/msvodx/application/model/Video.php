<?php
namespace app\model;

use think\Model;

class Video extends Model {
    protected $pk='id';
    #protected $updateTime='update_time';
    #protected $createTime='add_time';


    public static function addVideo($videoInfo){
        $baseInfo=[
            'title'=>'暂无标题',
            'download_url'=>'',
            'add_time'=>time(),
            'update_time'=>time(),
            'play_time'=>'00:00:00',
            'thumbnail'=>'',
            'user_id'=>0,
            'class'=>2,//视频分类，从配置信息中获取
            'status'=>1,//视频状态，从配置信息中获取
            'gold'=>2,//观看金币数，从配置信息中获取
            'is_check'=>1,
        ];





    }

}