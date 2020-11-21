<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('ymktv_sun_business_account',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')) {
        $account = pdo_get('ymktv_sun_business_account',array('uniacid' => $_W['uniacid']));

        $data['account'] = $_GPC['account'];
        $data['password'] = $_GPC['password'];
        $data['uniacid'] = $_W['uniacid'];

        $servies = pdo_get('ymktv_sun_servies',array('uniacid'=>$_W['uniacid'],'login'=>$_GPC['account']));
        $branchhead = pdo_get('ymktv_sun_branchhead',array('uniacid'=>$_W['uniacid'],'account'=>$_GPC['account']));

        if($account){
            if($branchhead || $servies){
                message('该账号已存在！');
            }else{
                $res = pdo_update('ymktv_sun_business_account',$data,array('uniacid'=>$_W['uniacid']));
            }

        }else{
            if($branchhead || $servies){
                message('该账号已存在！');
            }else{
                $res = pdo_insert('ymktv_sun_business_account',$data);
            }
        }
        if ($res){
            message('编辑成功',$this->createWebUrl('addaccount'),array(),'success');
        }else{
            message('编辑失败','','error');
        }
    }
include $this->template('web/addaccount');