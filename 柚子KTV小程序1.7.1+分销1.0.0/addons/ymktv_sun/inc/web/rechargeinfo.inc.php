<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('ymktv_sun_inary_money',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
if(checksubmit('submit')){           
    $data['status']=$_GPC['status'];
      $data['recharge']=$_GPC['recharge'];
       $data['youhui']=$_GPC['youhui'];
      $data['uniacid']=$_W['uniacid'];
       if($_GPC['recharge']<$_GPC['youhui']){
           message('充值的金额不能小于优惠的哦','','error');
       }
    if($_GPC['id']==''){                
        $res=pdo_insert('ymktv_sun_inary_money',$data);
        if($res){
            message('添加成功',$this->createWebUrl('recharge',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('ymktv_sun_inary_money', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('recharge',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/rechargeinfo');