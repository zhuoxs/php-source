<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6
 * Time: 13:58
 */

namespace app\admin\controller;


use app\model\Coupon;
use app\model\Couponget;
use app\model\Customize;
use app\model\System;

class Ccoustomize extends Base
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
        $this->view->infourl=$this->getInfoAppUrl();
        $this->view->storeurl=$this->getStoreAppUrl();
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
        $data=input('post.');
        if($data['link_type']==4){
            $data['url']=$data['url1'];
        }else if($data['link_type']==5){
            $data['url']=$data['url2'];
        }
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
        $this->view->infourl=$this->getInfoAppUrl();
        $this->view->storeurl=$this->getStoreAppUrl();
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
        $this->view->infourl=$this->getInfoAppUrl();
        $this->view->storeurl=$this->getStoreAppUrl();
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
        if($data['link_type']==4){
            $data['url']=$data['url1'];
        }else if($data['link_type']==5){
            $data['url']=$data['url2'];
        }
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

    //    启用
    public function batchenable(){
        $ids = input("post.ids");
        $model = new Customize();
        $ret = $model->allowField(true)->save(['state'=>1],['id'=>$ids]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'启用失败',
            );
        }
    }

    public function batchunenable(){
        $ids = input("post.ids");
        $model = new Customize();
        $ret = $model->allowField(true)->save(['state'=>0],['id'=>$ids]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'禁用失败',
            );
        }
    }
}