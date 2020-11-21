<?php
namespace app\model;

use app\base\model\Base;

class Memberconf extends Base{
    /**
     * 查看我的会员等级
    */
    public function getMylevel($user_id){
        $user=new User();
        $userinfo=$user->mfind(['id'=>$user_id],'total_consume');
        $level=$this->mylevel($userinfo['total_consume']);
        return $level;
    }
    function mylevel($money){
        global $_W;
        $data=$this->where(['uniacid'=>$_W['uniacid']])->order(['money'=>'asc'])->select();
        $res=json_decode(json_encode($data),true);
        $arr=array();
        foreach ($res as  $val){
            array_push($arr,$val['money']);
        }
        $level=0;
        foreach ($arr as $key => $value) {
            if ($money > $value) {
                $level++;
            }
        }
//        var_dump($level);exit;
        if($level>0){
            $mylevel=$res[$level-1];
        }else{
            $mylevel=0;
        }
        return $mylevel;
    }
}