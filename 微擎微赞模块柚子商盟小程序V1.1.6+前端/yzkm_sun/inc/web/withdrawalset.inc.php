<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzkm_sun_system',array('uniacid'=>$_W['uniacid']));

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
            $data['tx_open']=$_GPC['tx_open'];//提现开关
            $data['commission_cost']=$_GPC['commission_cost'];//佣金比率
            $data['tx_mode']=$_GPC['tx_mode'];//提现方式
            $data['tx_type']=$_GPC['tx_type'];//提现支持
            $data['tx_money']=$_GPC['tx_money'];//最低提现金额
            $data['tx_sxf']=$_GPC['tx_sxf'];//提现费率
            $data['uniacid']=$_W['uniacid'];
            $data['tx_details']=html_entity_decode($_GPC['tx_details']);//提现须知
           // var_dump($data);die;
            if($_GPC['id']==''){                
                $res=pdo_insert('yzkm_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('withdrawalset',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzkm_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('withdrawalset',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

include $this->template('web/withdrawalset');