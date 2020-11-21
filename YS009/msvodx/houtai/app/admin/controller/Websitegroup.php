<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/16
 * Time: 16:53
 */

namespace app\admin\controller;

use think\Request;

/***
 * Class Zdnet
 * @package app\admin\controller
 * 站群管理
 */
class Websitegroup extends Admin
{
/**
 * 站群列表
 */
        public function netlist(){
            $netlist=$this->myDb->name('website_group_setting')->select();
            $this->assign('netlist',$netlist);
            return view();
        }

    /**
     * 添加站群
     */
        public function add_website(Request $request){

            if($request->isAjax()){
                $data['domain']=$request->post('domain/s','');
                $data['site_title']=$request->post('site_title/s','');
                $data['logo_url']=$request->post('logo_url/s','');
                $data['site_logo_mobile']=$request->post('site_logo_mobile/s','');
                $data['site_description']=$request->post('site_description/s','');
                $data['site_keywords']=$request->post('site_keywords/s','');
				$data['add_time']= time();
				$data['site_statis']=$request->post('site_statis/s','');
                $data['friend_link']=$request->post('friend_link/s','');
				$data['site_icp']=$request->post('site_icp/s','');
                $this->myDb->name('website_group_setting')->insert($data);
                return $this->success('添加成功');
            }
            $this->view->engine->layout(false);
            return $this->fetch();
        }

    /**
     * 编辑站群
     */
    public function edit_website(Request $request){
        $id=$request->param('id/d',0);
        if($request->isAjax()){
            $data['domain']=$request->post('domain/s','');
            $data['site_title']=$request->post('site_title/s','');
            $data['logo_url']=$request->post('logo_url/s','');
            $data['site_logo_mobile']=$request->post('site_logo_mobile/s','');
            $data['site_description']=$request->post('site_description/s','');
            $data['site_keywords']=$request->post('site_keywords/s','');
			$data['add_time']= time();
			$data['site_statis']=$request->post('site_statis/s','');
            $data['friend_link']=$request->post('friend_link/s','');
			$data['site_icp']=$request->post('site_icp/s','');
            $this->myDb->name('website_group_setting')->where(['id'=>$id])->update($data);
            return $this->success('修改成功');
        }
        $info=$this->myDb->name('website_group_setting')->where(['id'=>$id])->find();
        $this->assign('info',$info);
        $this->view->engine->layout(false);
        return $this->fetch();
    }


}