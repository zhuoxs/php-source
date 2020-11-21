<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 13:58
 */
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Integralcategory;
use app\model\Integralgoods;

class Cintegral extends Admin{
    /**
     * 分类列表
     */
    public function category(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('category');
    }
    public function get_category_list(){
        global $_W;
        $model =new Integralcategory();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $order['create_time']='asc';
        $list = $model->where($where)->order($order)->select();
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
    public function editcategory(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model =new Integralcategory();
        $id=input('get.id');
        if($id){
            $info =$model->get_info($id);
            $this->view->info=$info;
        }
        return view('editcategory');
    }
    public function savecategory(){
        global $_W;
        $info=new Integralcategory();
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
    /**
     * 删除
    */
    public function deletecategory(){
        $ids = input('post.ids');
        $model=new Integralcategory();
        $ret = $model->destroy($ids);
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