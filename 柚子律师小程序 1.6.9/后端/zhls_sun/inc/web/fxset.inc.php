<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_fxset',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['tx_rate']=$_GPC['tx_rate'];
            $data['is_fx']=$_GPC['is_fx'];
            $data['is_open']=$_GPC['is_open'];
            $data['is_ej']=$_GPC['is_ej'];
            $data['tx_money']=$_GPC['tx_money'];
            $data['commission2']=$_GPC['commission2'];
            $data['commission']=$_GPC['commission'];
            $data['img']=$_GPC['img'];
            $data['img2']=$_GPC['img2'];
            $data['uniacid']=$_W['uniacid'];
            $data['tx_details']=html_entity_decode($_GPC['tx_details']);
            $data['fx_details']=html_entity_decode($_GPC['fx_details']);
            $data['instructions']=html_entity_decode($_GPC['instructions']);
            if($_GPC['id']==''){                
                $res=pdo_insert('zhls_sun_fxset',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('fxset',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhls_sun_fxset', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('fxset',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/fxset');