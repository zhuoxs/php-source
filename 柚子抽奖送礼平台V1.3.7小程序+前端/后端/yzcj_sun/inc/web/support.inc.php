<?php
global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzcj_sun_support',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){

        $data['uniacid']=trim($_W['uniacid']);
        $data['name']=$_GPC['name'];
        $data['phone']=$_GPC['phone'];
        $data['condition']=$_GPC['condition'];
        $data['logo']=$_GPC['logo'];

        if($_GPC['id']==''){                
            $res=pdo_insert('yzcj_sun_support',$data,array('uniacid'=>$_W['uniacid']));
            if($res){
                message('添加成功',$this->createWebUrl('support',array()),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzcj_sun_support', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
            if($res){
                message('编辑成功',$this->createWebUrl('support',array()),'success');
            }else{
                message('编辑失败','','error');
            }
        }
    }
include $this->template('web/support');