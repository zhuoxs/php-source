<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
        if($_GPC['tx_sxf']<0 || $_GPC['tx_sxf']>=100){
            message('提现费率仅能设置在0-100之间！');
        }
        if($_GPC['commission_cost']<0 || $_GPC['commission_cost']>=100){
            message('佣金比例仅能设置在0-100之间！');
        }
        if($_GPC['tx_money']<0){
            message('最低提现金额不得小于0元！');
        }
            $data['tx_open']=$_GPC['tx_open'];
            $data['tx_sxf']=$_GPC['tx_sxf'];
            $data['tx_money']=$_GPC['tx_money'];
            $data['uniacid']=$_W['uniacid'];
            $data['tx_details']=html_entity_decode($_GPC['tx_details']);
            $data['tx_mode']=$_GPC['tx_mode'];
            $data['tx_type']=$_GPC['tx_type'];
           // var_dump($data);die;
            if($_GPC['id']==''){                
                $res=pdo_insert('zhls_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('txsz',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhls_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('txsz',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

include $this->template('web/txsz');