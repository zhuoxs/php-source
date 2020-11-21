<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzkm_sun_aboutus',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['us_img']=$_GPC['us_img'];
    $data['us_tel']=$_GPC['us_tel'];
    $data['us_details']=$_GPC['us_details'];
    $data['us_addr']=$_GPC['us_addr'];
    $data['uniacid']=$_W['uniacid'];	
    $raa=pdo_get('yzkm_sun_aboutus',array('uniacid'=>$_W['uniacid']));
if ($raa=='') {
					$res=pdo_insert('yzkm_sun_aboutus',$data);
					if($res){
						message('添加成功',$this->createWebUrl('aboutus',array()),'success');
					}else{
						message('添加失败','','error');
					}	
}else{
        $res = pdo_update('yzkm_sun_aboutus', $data, array('uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('aboutus',array()),'success');
        }else{
            message('编辑失败','','error');
        }
}

    // p($data);die;

}
include $this->template('web/aboutus');