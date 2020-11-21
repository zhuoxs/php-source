<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 15:27
 */
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Pinclassify;

class Cpinclassify extends Admin{

    public function get_classify_list(){
        global $_W;
        $model =new Pinclassify();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $list = $model->where($where)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function saves(){
        global $_W;
        $info=new Pinclassify();
        $id = input('post.id');
        if ($id){
            $info = $info->get_info($id);
        }
        $data = input('post.');
        $data['uniacid'] = $_W['uniacid'];
        $ret = $info->allowField(true)->save($data);
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
}