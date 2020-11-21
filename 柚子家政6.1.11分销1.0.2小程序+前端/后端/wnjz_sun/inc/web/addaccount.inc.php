<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('wnjz_sun_business_account',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')) {
        $account = pdo_get('wnjz_sun_business_account',array('uniacid' => $_W['uniacid'],'account' => $_GPC['account']));

        $data['account'] = $_GPC['account'];
        $data['password'] = $_GPC['password'];
        $data['uniacid'] = $_W['uniacid'];
        if($_GPC['id']){
           $res = pdo_update('wnjz_sun_business_account',$data,array('id'=>$_GPC['id']));
        }else{
            if ($account){
                message('添加失败,此账户已经存在',$this->createWebUrl('addaccount'),'error');
            }
            $res = pdo_insert('wnjz_sun_business_account',$data);
        }
        if ($res){
            message('操作成功',$this->createWebUrl('addaccount'),'success');
        }else{
            message('操作失败',$this->createWebUrl('addaccount'),'error');
        }
    }
include $this->template('web/addaccount');