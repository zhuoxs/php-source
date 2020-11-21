<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
			$data['f_activity'] = $_GPC['f_activity'];
			$data['f_activity_logo'] = $_GPC['f_activity_logo'];
			$data['e_favourable'] = $_GPC['e_favourable'];
			$data['e_favourable_logo'] = $_GPC['e_favourable_logo'];
			$data['e_num'] = $_GPC['e_num'];
            $data['f_num'] = $_GPC['f_num'];
            $data['uniacid']=$_W['uniacid'];       

            if($_GPC['id']==''){                
                $res=pdo_insert('yzhd_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzhd_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/settings');
