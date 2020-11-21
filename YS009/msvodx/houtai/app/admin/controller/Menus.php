<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/24
 * Time: 10:23
 */

namespace app\admin\controller;




use think\Db;
use think\Request;

class Menus extends Admin
{

    public function add (Request $request){
        $menu=$this->myDb->name("menu");
        $class=$this->myDb->name("class");
        $pid=$request->param('id/d',0);
        if($request->isPost()) {

            $menus['name'] = $request->post('name');
            $menus['pid'] = $request->post('pid');
            $menus['type'] = $request->post('type');
            $menus['status'] = $request->post('status');

            if ($menus['type'] == 1) {
                $menus['url'] = $request->post('url');
            } else {
                $class_id = $request->post('class');
                $base_class = ['video','images','novel'];
                if (!in_array($class_id, $base_class)) {
                    $result = $class->where(['id' => $class_id])->field('id,type')->find();
                    if ($result) {
                        $menus['url'] = json_encode(['cid' => $class_id, 'type' => $result['type']]);
                    }
                }else{
                    $menus['url'] = json_encode(['cid' => $class_id]);
                }
            }

                $res = $menu->insert($menus);
                if ($res) {
                    return $this->success('添加成功', url('manager'));
                } else {
                    return $this->error('添加失败', url());
                }

        }
        $classlist=$class->where(['status'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['status'=>1,'pid'=>$v['id']])->select();
        }

        $fclass=$menu->where(['pid'=>0])->order('sort','desc')->select();
        $this->assign('pid',$pid);
        $this->assign('classlist',$classlist);
        $this->assign('fclass',$fclass);
        return $this->fetch();
    }
     public  function manager(Request $request){
         $menu=$this->myDb->name("menu");
         $classlist=$menu->where(['pid'=>0])->order('sort','asc')->select();
         foreach ($classlist as $k=>$v){
             $classlist[$k]['childs']=$menu->where(['pid'=>$v['id']])->select();
         }
        $this->assign('classlist',$classlist);
        return $this->fetch();
     }
     public function edit(Request $request){
         $menu=$this->myDb->name("menu");
         $class=$this->myDb->name("class");
         $id=$request->param('id');
         if(empty($id)){
            return $this->error('非法请求！',url('manager'));
         }
         $result_data =$menu->where(['id'=>$id])->find();
         if($result_data['type']==2){
             if(!empty($result_data['url'])) {
                 $cid = json_decode($result_data['url']);
                 $result_data['url'] = $cid->cid;
             }
         }

         if(empty($result_data)){
             return $this->error('请求菜单不存在！',url('manager'));
         }
         if($request->isAjax()){
             $menus['name']=$request->post('name');
             $menus['pid']=$request->post('pid');
             $menus['type']=$request->post('type');
             $menus['status']=$request->post('status');
             if($menus['type']==1){
                 $menus['url']=$request->post('url');
             }else{
                 $class_id = $request->post('class');
                 $base_class = ['video','images','novel'];
                 if (!in_array($class_id, $base_class)) {
                     $result = $class->where(['id' => $class_id])->field('id,type')->find();
                     if ($result) {
                         $menus['url'] = json_encode(['cid' => $class_id, 'type' => $result['type']]);
                     }
                 }else{
                     $menus['url'] = json_encode(['cid' => $class_id]);
                 }
             }
             $res=$menu->where(['id'=>$id])->update($menus);
             if($res){
                 return $this->success('编辑成功',url('manager'));
             }else{
                 return $this->error('编辑失败');
             }
         }
         $classlist=$class->where(['status'=>1,'pid'=>0])->select();
         foreach ($classlist as $k=>$v){
             $classlist[$k]['childs']=$class->where(['status'=>1,'pid'=>$v['id']])->select();
         }
         $fclass=$menu->where(['pid'=>0])->order('sort','desc')->select();
         $this->assign('result_data',$result_data);
         $this->assign('classlist',$classlist);
         $this->assign('fclass',$fclass);
         return $this->fetch();
     }


}