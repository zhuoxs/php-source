<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){           
    $data['tz_audit']=$_GPC['tz_audit'];
      $data['hb_sxf']=$_GPC['hb_sxf'];   
       $data['hb_img']=$_GPC['hb_img']; 
        $data['tz_num']=$_GPC['tz_num'];  
        $data['ft_xuz']=$_GPC['ft_xuz']; 
         $data['hb_content']=$_GPC['hb_content'];    
    $data['uniacid']=$_W['uniacid'];    
    if($_GPC['id']==''){                
        $res=pdo_insert('zhls_sun_system',$data);
        if($res){
            message('添加成功',$this->createWebUrl('tzcheck',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('zhls_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('tzcheck',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/tzcheck');