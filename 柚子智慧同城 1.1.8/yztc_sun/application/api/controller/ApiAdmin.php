<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 16:14
 */
namespace app\api\controller;
use app\model\Shop;
use app\model\Shopadmin;

class ApiAdmin extends Api
{
    //TODO::管理员
    public function adminInfo(){
        $user_id=input('post.user_id');
        //判断是否核销员
        $shopadmin=new Shopadmin();
        $isshopadmin=$shopadmin->mfind(['user_id'=>$user_id]);
        if($isshopadmin){
            $isshopadmin['showmodule']=explode(',',$isshopadmin['showmodule']);
            $shops=Shop::get($isshopadmin['sid']);
            success_withimg_json(array('admininfo'=>$isshopadmin,'auth'=>$isshopadmin['auth'],'shopinfo'=>$shops));
        }else{
            return_json('没有权限',-1);
        }

    }
    //TODO::核销员列表
    public function adminList(){
        $shopadmin=new Shopadmin();
        $sid=input('post.sid');
        $list=$shopadmin->where(['sid'=>$sid,'auth'=>2])->with('user')->select();
        success_json($list);
    }
    //TODO::uid查用户信息
    public function getUser(){
        $info=\app\model\User::get(input('post.user_id'));
        if($info){
            success_json($info);
        }else{
            return_json('用户不存在',-1);
        }
    }
    //TODO::新增核销员
    public function addAdmin(){
        $user_id=input('post.user_id');
        $shopadmin=new Shopadmin();
        $isshopadmin=$shopadmin->isAdmin($user_id);
        if($isshopadmin==-1){
            $data['user_id']=$user_id;
            $data['sid']=input('post.sid');
            $data['showmodule']=input('post.showmodule');
            $res=$shopadmin->allowField(true)->save($data);
            if($res){
                return_json();
            }else{
                return_json('新增失败，请稍后重试',-1);
            }
        }else{
            return_json('该用户已经是其他商户的管理员了',-1);
        }
    }
    //TODO::删除核销员
    public function delAdmin(){
        $id=input('post.id');
        $shopadmin=new Shopadmin();
        $res=$shopadmin->where('id',$id)->delete();
        if($res){
            return_json();
        }else{
            return_json('删除核销员，请稍后重试',-1);
        }
    }
}