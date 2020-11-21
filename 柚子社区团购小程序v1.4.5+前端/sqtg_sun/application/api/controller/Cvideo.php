<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 15:20
 */
namespace app\api\controller;

use app\base\controller\Api;
use app\model\Video;

class Cvideo extends Api{
    /**
     * 视频列表
    */
    public function videoList(){
        global $_W;
        $video=new Video();
        $where['state']=1;
        $order['sort']='asc';
        $page = input('post.page', 0);
        $length = input('post.length', 10);
        $list=$video->mlist($where,$order,$page,$length);
        $imgroot['img_root'] = $_W['attachurl'];
        return_json('success',0,$list,$imgroot);
    }
    /**
     * 视频详情
    */
    public function videoDetails(){
        global $_W;
        $video=new Video();
        $where['state']=1;
        $where['id']=input('post.id');
        $info=$video->mfind($where);
        if($info){
            $imgroot['img_root'] = $_W['attachurl'];
            return_json('success',0,$info,$imgroot);
        }else{
            return_json('视频不存在',1);
        }
    }
}