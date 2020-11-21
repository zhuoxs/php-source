<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2
 * Time: 13:45
 */

namespace app\controller;


use think\Db;
use think\Request;

class Poster extends BaseController
{

    /**
     * @param Request $request
     * @return \think\response\View
     * 广告位展示
     */
    public  function index(Request $request){
    $pid=$request->param('pid/d',0);
    $position=Db::name('advertisement_position')->where(['id'=>$pid])->find();
    $advertisement_info=Db::name('advertisement')->where("position_id={$pid} and end_time > unix_timestamp(now())  and status=1")->find();
    if($advertisement_info['target']==1){
        $advertisement_info['target']="target='_blank'";
    }
    $this->assign('position',$position);
    $this->assign('advertisement_info',$advertisement_info);
    config('app_trace',false);
    return view();
    }
}