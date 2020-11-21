<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 14:01
 */
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Video;

class Cvideo extends Admin{

    public function video(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('video');
    }
    /**
     * 获取视频列表
    */
    public function get_video_list(){
        global $_W;
        $model =new Video();
        //排序、分页
        $model->fill_order_limit();
        $where['state']=1;
        $where['uniacid']=$_W['uniacid'];
        $key=input('get.key');
        if($key){
            $where['title']=['like',"%$key%"];
        }
        $list = $model->where($where)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    /**
     * 新增、编辑
     */
    public function add(){
        return view('edit');
    }
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $video=new Video();
        $id=input('get.id');
        if($id){
            $info =$video->getVideo($id);
            $this->view->info = $info;
        }
        return view('edit');
    }
//    /**
//     * 保存
//    */
//    public function save(){
//
//    }
}
