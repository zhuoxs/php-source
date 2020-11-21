<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Web_Message extends Web_Base
{
    //小程序
    public function wxapp(){
        global $_W,$_GPC;

        //提现审核通知 'type'=>3
        $info = pdo_get('ox_reclaim_uniform_template',array('uniacid'=>$_W['uniacid'],'type'=>3));
        //接单成功提醒 'type'=>4
        $info2 = pdo_get('ox_reclaim_uniform_template',array('uniacid'=>$_W['uniacid'],'type'=>4));
        //订单完成通知 'type'=>5
        $info3 = pdo_get('ox_reclaim_uniform_template',array('uniacid'=>$_W['uniacid'],'type'=>5));


        if($_W['ispost'])
        {
            if(empty($info)){
                $_GPC['data']['info1']['type']=3;
                $_GPC['data']['info1']['uniacid']=$_W['uniacid'];
                pdo_insert('ox_reclaim_uniform_template',$_GPC['data']['info1']);
            }else{
                $res = pdo_update('ox_reclaim_uniform_template',$_GPC['data']['info1'],array('uniacid'=>$_W['uniacid'],'type'=>3));
            }

            if(empty($info2)){
                $_GPC['data']['info2']['type']=4;
                $_GPC['data']['info2']['uniacid']=$_W['uniacid'];
                pdo_insert('ox_reclaim_uniform_template',$_GPC['data']['info2']);
            }else{
                $res = pdo_update('ox_reclaim_uniform_template',$_GPC['data']['info2'],array('uniacid'=>$_W['uniacid'],'type'=>4));
            }

            if(empty($info3)){
                $_GPC['data']['info3']['type']=5;
                $_GPC['data']['info3']['uniacid']=$_W['uniacid'];
                pdo_insert('ox_reclaim_uniform_template',$_GPC['data']['info3']);
            }else{
                $res = pdo_update('ox_reclaim_uniform_template',$_GPC['data']['info3'],array('uniacid'=>$_W['uniacid'],'type'=>5));
            }

            $this->success('保存成功','message/wxapp');
        }
        include $this->template();
    }

    // 公众号
    public function uniform() {
        global $_W,$_GPC;
        $message1 = pdo_get('ox_reclaim_uniform_template',['uniacid'=>$_W['uniacid'],'type' => 1]);
        $message2 = pdo_get('ox_reclaim_uniform_template',['uniacid'=>$_W['uniacid'],'type' => 2]);
        $result = [
          "message1"=>$message1,
          "message2" => $message2
        ];
        if($_W['ispost']){
            if(empty($message1)){
                $_GPC['data']['message1']['type']=1;
                $_GPC['data']['message1']['uniacid']=$_W['uniacid'];
                pdo_insert('ox_reclaim_uniform_template',$_GPC['data']['message1']);
            }else{
                pdo_update('ox_reclaim_uniform_template',$_GPC['data']['message1'],['uniacid'=>$_W['uniacid'],'type' => 1]);
            }
            if(empty($message2)){
                $_GPC['data']['message2']['type']=2;
                $_GPC['data']['message2']['uniacid']=$_W['uniacid'];
                pdo_insert('ox_reclaim_uniform_template',$_GPC['data']['message2']);
            }else{
                pdo_update('ox_reclaim_uniform_template',$_GPC['data']['message2'],['uniacid'=>$_W['uniacid'],'type' => 2]);
            }
            $this->success('保存成功','message/uniform');
        }
        include $this->template();
    }

}

?>