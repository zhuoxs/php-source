<?php
namespace app\admin\controller;
use app\base\controller\Admin;
use app\model\Seckillgoodsattr;

class Cseckillgoodsattrgroup extends Admin
{
    public function delete(){
        $ids = input('post.ids');
        $ret = $this->model->destroy($ids);
        $attr_model = new Seckillgoodsattr();
        $ss = $attr_model->where('seckillgoodsattrgroup_id',$ids)->delete();
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
}
