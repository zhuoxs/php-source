<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
 $item=pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['tid1']=trim($_GPC['tid1']);
            $data['tid2']=trim($_GPC['tid2']);
             $data['tid3']=trim($_GPC['tid3']);
            $data['uniacid']=trim($_W['uniacid']);
            if($_GPC['id']==''){                
                $res=pdo_insert('zhls_sun_sms',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('template',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhls_sun_sms', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('template',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/template');