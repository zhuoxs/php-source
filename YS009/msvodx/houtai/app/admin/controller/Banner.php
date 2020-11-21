<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 11:16
 */


namespace app\admin\controller;


use think\Db;
use think\Request;

class Banner extends Admin
{
    /**
     *  frs
     *  banner列表
     */
    function index(){
        $list= $this->myDb->name('banner')->order('sort asc')->field('id,name,images_url,url,sort,status,info')->select();
        $this->assign('list', $list);
      return $this->fetch();
    }

    /**
     *  frs
     *  添加banner
     */
    function add(Request $request){
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $rule =[
                'name|标题'=>'require',
                'images_url|图片'=>'require',
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'images_url.require'=>'图片不能为空',
            ];
            $result=$this->validate($data,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $insert=$this->myDb->name('banner')->insert($data);
            return $this->success('添加成功',url('banner/index'));
        }else{
            return $this->fetch('add');
        }

    }
    /**
     *  frs
     *  banner编辑
     */
    function edit(Request $request){
        $id=$this->request->param('id');
        $where['id'] = $id;
        if ($this->request->isPost()) {
            $data = $request->post();
            $rule =[
                'name|标题'=>'require',
                'images_url|图片'=>'require',
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'images_url.require'=>'图片不能为空',
            ];
            $result=$this->validate($data,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $this->myDb->name('banner')->where($where)->update($data);
            return $this->success('修改成功',url('banner/index'));
        }else{
            $info = $this->myDb->name('banner')->where($where)->find();
            $this->assign('info', $info);
            return $this->fetch();
        }

    }

}