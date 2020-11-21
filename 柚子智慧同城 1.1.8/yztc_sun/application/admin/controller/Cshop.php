<?php
namespace app\admin\controller;


class Cshop extends Base
{
    public function shoplist(){
        return view();
    }
    /**
     * 入驻须知
    */
    public function enterrule(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $info['enter_rule'] = \app\model\Config::get_value('enter_rule');
        $this->view->info = $info;
        return view();
    }
    public function saveEnterrule(){
        $info = new \app\model\Config();
        $data = input('post.');
        $list = [];
        $list[] = \app\model\Config::full_id('enter_rule',$data['enter_rule']);
        $ret = $info->allowField(true)->saveAll($list);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
}
