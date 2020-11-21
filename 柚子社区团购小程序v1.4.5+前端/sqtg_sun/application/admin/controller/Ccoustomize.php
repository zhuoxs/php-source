<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Customize;

class Ccoustomize extends Admin
{
    /**
     * 菜单图标自定义列表
     */
    public function navicon(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        return view('navicon');
    }
    /**
     * 新增、编辑
     */
    public function editnav(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        $cus=new Customize();
        $id=input('get.id');
        if($id){
            $info =$cus->getMenu($id);
            $this->view->info = $info;
        }
        $this->view->linkurl =$this->getWxAppUrl();
        return view('editnav');
    }
    /**
     * 底部导航列表
    */
    public function get_navicon_list(){
        global $_W;
        $model =new Customize();

        //排序、分页
        $model->fill_order_limit();
        $where['type']=3;
        $where['uniacid']=$_W['uniacid'];
        $list = $model->where($where)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function save(){
        $info = new Customize();

        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
//        var_dump($info);exit;
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
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $cus=new Customize();
        $info = $cus->get($id);
        $this->view->info = $info;
        $this->view->linkurl =$this->getWxAppUrl();
        return view('editnav');
    }
    /**
     * 删除
     */
    public function delete(){
        $ids = input('post.ids');
        $cus=new Customize();
        $ret = $cus->destroy($ids);
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
    /**
     * 菜单图标自定义列表
     */
    public function menuicon(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('menuicon');
    }
    /**
     * 新增、编辑
     */
    public function addmenuicon(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $cus=new Customize();
        $id=input('get.id');
        if($id){
            $info =$cus->getMenu($id);
            $this->view->info = $info;
        }
        $this->view->linkurl =$this->getWxAppUrl();
        return view('addmenuicon');
    }
    public function savemenuicon(){
        global $_W;
        $info=new Customize();
        $id = input('post.id');
        if ($id){
            $info = $info->getMenu($id);
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
    public function get_menuicon_list(){
        global $_W;
        $model =new Customize();

        //排序、分页
        $model->fill_order_limit();
        //条件
//        $query = function ($query){
//            //关键字搜索
////            $key = input('get.key');
////            if ($key){
////                $query->where('name','like',"%$key%")->whereOr('control','like',"%$key%")->whereOr('action','like',"%$key%");
////            }
//            $query->where('type',2);
//
//        };

        $where['type']=2;
        $where['uniacid']=$_W['uniacid'];
        $list = $model->where($where)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
}