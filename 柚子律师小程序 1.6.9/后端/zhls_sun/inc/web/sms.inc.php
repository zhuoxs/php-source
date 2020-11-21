<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['appkey']=trim($_GPC['appkey']);
    $data['order_tplid']=trim($_GPC['order_tplid']);
    $data['order_refund_tplid']=trim($_GPC['order_refund_tplid']);
    $data['is_open']=$_GPC['is_open'];
    $data['smstype']=$_GPC['smstype'];
    $data['ytx_apiaccount']=$_GPC['ytx_apiaccount'];
    $data['ytx_apipass']=$_GPC['ytx_apipass'];
    $data['ytx_order']=$_GPC['ytx_order'];
    $data['ytx_orderrefund']=$_GPC['ytx_orderrefund'];

    $data['aly_accesskeyid']=$_GPC['aly_accesskeyid'];
    $data['aly_accesskeysecret']=$_GPC['aly_accesskeysecret'];
    $data['aly_order']=$_GPC['aly_order'];
    $data['aly_orderrefund']=$_GPC['aly_orderrefund'];
    $data['aly_sign']=$_GPC['aly_sign'];

    $data['uniacid']=trim($_W['uniacid']);
    if($_GPC['id']==''){                
        $res=pdo_insert('zhls_sun_sms',$data);
        if($res){
            message('添加成功',$this->createWebUrl('sms',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('zhls_sun_sms', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('sms',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}

include $this->template('web/sms');