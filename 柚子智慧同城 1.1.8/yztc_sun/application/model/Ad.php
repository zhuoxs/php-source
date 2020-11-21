<?php

namespace app\model;


class Ad extends Base
{
    /**
     * 轮播图
     * $type：1、首页轮播图，2、活动首页轮播图
    */
    public function getBanner($type=1){
        global $_W;
        $list=$this->where(['uniacid'=>$_W['uniacid'],'type'=>$type])->order(['sort'=>'asc'])->select();
        return $list;
    }
}
