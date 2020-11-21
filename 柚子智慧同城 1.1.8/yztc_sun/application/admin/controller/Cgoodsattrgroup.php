<?php
namespace app\admin\controller;

use app\model\Goodsattr;

class Cgoodsattrgroup extends Base
{
    public function delete(){
        $ids = input('post.ids');
        $ret = $this->model->destroy($ids);
        $attr_model = new Goodsattr();
        $ss = $attr_model->where('goodsattrgroup_id',$ids)->delete();
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

    public function save(){
        $info = $this->model;
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $ret = $info->allowField(true)->save(input('post.'));
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
