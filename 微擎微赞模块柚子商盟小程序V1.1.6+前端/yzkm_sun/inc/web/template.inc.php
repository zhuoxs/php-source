<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
 $item=pdo_get('yzkm_sun_sms',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){

        if(empty($_GPC['template_order'] )){
            message('订单模板编号不能为空','','error');
        }
        if(empty($_GPC['template_withdrawal'] )){
            message('商家入驻模板编号不能为空','','error');
        }
        if(empty($_GPC['template_member'] )){
            message('会员卡板编号不能为空','','error');
        }

            $data['template_order']=trim($_GPC['template_order']);
            $data['template_withdrawal']=trim($_GPC['template_withdrawal']);
            $data['template_member']=trim($_GPC['template_member']);
             // $data['tid3']=trim($_GPC['tid3']);
            $data['uniacid']=trim($_W['uniacid']);
            if($_GPC['id']==''){                
                $res=pdo_insert('yzkm_sun_sms',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('template',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzkm_sun_sms', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('template',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/template');