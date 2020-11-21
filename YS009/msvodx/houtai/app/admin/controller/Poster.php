<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 15:59
 */

namespace app\admin\controller;


use think\Request;

class Poster extends  Admin
{

    /**
     * 后台广告列表获取
     */
    public function lists(){
        //按添加时间倒序排序查询
        $data_list=$this->myDb->view('advertisement','id,type,content,titles,info,url,position_id,add_time,begin_time,end_time,status,host')
            ->view('advertisement_position','title,width,height','advertisement.position_id=advertisement_position.id')
            ->paginate();
        $pages=$data_list->render();
        $this->assign('data_list',$data_list);
        $this->assign('pages',$pages);
        return $this->fetch();
    }

    public function alimama(){
        $data_list=$this->myDb->name('advertisement_position')->select();
        $this->assign('data_list',$data_list);
        return $this->fetch();
    }


    /**
     * @param Request $request
     * @return mixed|void
     * 广告位修改
     */
    public function edit(Request $request){
        $id=$request->param("id/d",0);
        if($request->isAjax()){
            //收集用户的数据检验
            $data['title']=$request->post('title');
            $data['width']=$request->post('width');
            $data['height']=$request->post('height');

            $rule =[
                'title|广告标题'=>'require',
                'width|广告位宽度'=>'require|float',
                'height|广告位高度'=>'require|float'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'width.require'=>'广告位宽度不能为空',
                'width.float'=>'广告位宽度需要为数字',
                'height.require'=>'广告位高度不能为空',
                'height.float'=>'广告位高度要为数字',
            ];
            $result=$this->validate($data,$rule,$message);

            if($result !== true) {
                return $this->error($result);
            }
            $succ=$this->myDb->name('advertisement_position')->where(['id'=>$id])->update($data);
            return $this->success('添加成功！');
        }
        $data=$this->myDb->name('advertisement_position')->where(['id'=>$id])->find();
        $this->assign('data',$data);
        $this->view->engine->layout(false);
        return $this->fetch();
    }




    public function add(Request $request){
        if($request->isAjax()){
            //收集用户的数据检验
            $data['title']=$request->post('title');
            $data['width']=$request->post('width');
            $data['height']=$request->post('height');

            $rule =[
                'title|广告标题'=>'require',
                'width|广告位宽度'=>'require|float',
                'height|广告位高度'=>'require|float'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'width.require'=>'广告位宽度不能为空',
                'width.float'=>'广告位宽度需要为数字',
                'height.require'=>'广告位高度不能为空',
                'height.float'=>'广告位高度要为数字',
            ];
            $result=$this->validate($data,$rule,$message);

            if($result !== true) {
                return $this->error($result);
            }
            $succ=$this->myDb->name('advertisement_position')->insert($data);
            return $this->success('添加成功！');
        }
        $this->view->engine->layout(false);
        return $this->fetch();
    }
    public function add_poster(Request $request){
        if($request->isAjax()) {
            $data['position_id']=$request->post('position/d');
            $data['titles']=$request->post('titles/s');
            $data['info']=$request->post('info');
            $data['url']=$request->post('url');
            $data['target']=$request->post('target');
            $date=$request->post('date');
            $data['type']=$request->post('type/d');
            $date=explode(' - ',$date);
            $data['begin_time']=strtotime($date[0]);
            $data['end_time']=strtotime($date[1]);
            $data['add_time'] =time();
            if($data['type']==2){
              $data['content']=$request->post('content');
            }else{
                $data['content']=$request->post('code');
            }
            $rule =[
                'position_id|广告位'=>'require',
                'titles|广告标题'=>'require',
                'type|广告类型'=>'require'
            ];
            $message=[
                'titles.require'=>"标题不能为空",
                'position_id.require'=>'请选择广告位',
                'type.require'=>'请选择广告类型',
            ];
            $result=$this->validate($data,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $succ=$this->myDb->name('advertisement')->insert($data);
            return $this->success('添加成功！');

        }
        $data_list=$this->myDb->name('advertisement_position')->select();
        $this->assign('data_list',$data_list);
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    /**
     * 编辑广告
     */
    public function edit_poster(Request $request){
        $id=$request->param('id');
        if($request->isAjax()){
            $data['position_id']=$request->post('position/d');
            $data['titles']=$request->post('titles/s');
            $data['info']=$request->post('info');
            $data['url']=$request->post('url');
            $date=$request->post('date');

            $data['type']=$request->post('type/d');
            $date=explode(' - ',$date);
            $data['begin_time']=strtotime($date[0]);
            $data['end_time']=strtotime($date[1]);

            $data['add_time'] =time();
            if($data['type']==2){
                $data['content']=$request->post('content');
            }else{
                $data['content']=$request->post('code');
            }
            $rule =[
                'position_id|广告位'=>'require',
                'titles|广告标题'=>'require',
                'type|广告类型'=>'require'
            ];
            $message=[
                'titles.require'=>"标题不能为空",
                'position_id.require'=>'请选择广告位',
                'type.require'=>'请选择广告类型',
            ];
            $result=$this->validate($data,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $succ=$this->myDb->name('advertisement')->where(['id'=>$id])->update($data);
            return $this->success('修改成功！');
        }
        $data=$this->myDb->name('advertisement')->where(['id'=>$id])->find();
        $data_list=$this->myDb->name('advertisement_position')->select();
        $this->assign('data',$data);
        $this->assign('data_list',$data_list);
        $this->view->engine->layout(false);
        return $this->fetch();
    }



}