<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 15:54
 */

namespace app\admin\controller;


use think\Request;

class Drawmoney extends Admin
{

    /**
     * 用户提现列表
     */
    function draw_money_list(){
         $data_list= $this->myDb->view('draw_money_log','id,gold,money,add_time,update_time,status,info,user_id')
             ->view('member','username,tel,nickname,headimgurl,email','draw_money_log.user_id=member.id')
             ->order('add_time','desc')->paginate(20)->each(function($itme,$key){
                 $itme['info']=json_decode($itme['info'],true);
                 return $itme;
             });
         $pages=$data_list->render();
         $this->assign('data_list',$data_list);
         $this->assign('pages',$pages);
         return $this->fetch();
    }
    public function agreen(Request $request){
      if($request->isAjax()){
          $id=$request->get('id');
          if(empty($id)){
              return $this->error('参数错误');
          }
          if($request->get('type')==1){
              //审核通过，更新用户状态
              $this->myDb->name('draw_money_log')->where(['id'=>$id])->update(['status'=>1,'update_time'=>time()]);
              return $this->success('修改成功');
          }elseif ($request->get('type')==2){
              $info=$this->myDb->name('draw_money_log')->where(['id'=>$id])->find();

              $this->myDb->name('draw_money_log')->where(['id'=>$id])->update(['status'=>2,'update_time'=>time()]);

              $result= $this->myDb->name('member')->where(['id'=>$info['user_id']])->setInc('money',$info['gold']); ;
              $gold_log_data = array(
                  'user_id' => $info['user_id'],
                  'gold' => $info['gold'],
                  'module' =>'draw_money',
                  'explain'=>'提现返还',
                  'add_time' => time(),
              );
              $this->myDb->name('gold_log')->insert($gold_log_data);
              return $this->success('修改成功');
          }
      }

    }
}