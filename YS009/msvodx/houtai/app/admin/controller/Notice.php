<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 15:59
 */

namespace app\admin\controller;


use think\Db;
use think\Request;

class Notice extends  Admin
{

    /**
     * 后台公告列表获取
     */
    public function index(){
        $list= $this->myDb->name('notice')->order('sort asc')->select();
        $this->assign('list', $list);
      return $this->fetch();


    }

    /**
     *  frs
     *  添加公告
     */
    function add(Request $request){
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $rule =[
                'title|标题'=>'require',
                'content|展示内容'=>'require',
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'content.require'=>'展示内容不能为空',
            ];
            $result=$this->validate($data,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $data['out_time'] = strtotime($data['out_time']);
            //print_r($data);
            $insert=$this->myDb->name('notice')->insert($data);
            return $this->success('添加成功',url('notice/index'));
        }else{
            return $this->fetch('add');
        }

    }
    /**
     *  frs
     *  公告编辑
     */
    function edit(Request $request){
        $id=$this->request->param('id');
        $where['id'] = $id;
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $rule =[
                'title|标题'=>'require',
                'content|展示内容'=>'require',
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'content.require'=>'展示内容不能为空',
            ];
            $result=$this->validate($data,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $data['out_time'] = strtotime($data['out_time']);
            $this->myDb->name('notice')->where($where)->update($data);
            return $this->success('修改成功',url('notice/index'));
        }else{
            $info = $this->myDb->name('notice')->where($where)->find();
            $info['out_time'] = date('Y-m-d H:i:s', $info['out_time']);
            $this->assign('info', $info);
            return $this->fetch();
        }

    }

}