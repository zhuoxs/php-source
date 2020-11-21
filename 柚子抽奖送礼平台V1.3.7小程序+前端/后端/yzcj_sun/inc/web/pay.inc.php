<?php

defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$certfile = IA_ROOT . "/addons/yzcj_sun/cert/" . 'apiclient_cert_' .$_W['uniacid'] . '.pem';
$keyfile = IA_ROOT . "/addons//yzcj_sun/cert/" . 'apiclient_key_' . $_W['uniacid'] . '.pem';
    
    $item=pdo_get('yzcj_sun_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){

            $data['mchid']=trim($_GPC['mchid']);
            $data['wxkey']=trim($_GPC['wxkey']);
            $data['apiclient_cert']=$_GPC['apiclient_cert'];
            $data['apiclient_key']=$_GPC['apiclient_key'];
            $data['client_ip']=$_GPC['client_ip'];
            $data['uniacid']=trim($_W['uniacid']);

            if($_GPC['id']==''){                
                $res=pdo_insert('yzcj_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('pay',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzcj_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('pay',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/pay');