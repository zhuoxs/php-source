<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('yzcyk_sun_system',array('uniacid'=>$_W['uniacid']));

    if(checksubmit('submit')){
            $data['uniacid']=$_W['uniacid'];
            $data['hz_tel']=$_GPC['hz_tel'];  
            $data['jszc_img']=$_GPC['jszc_img'];  
            $data['jszc_tdcp']=$_GPC['jszc_tdcp'];
            $data['is_techzhichi']=$_GPC['is_techzhichi'];
            if($_GPC['id']==''){                
                $res=pdo_insert('yzcyk_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('techzhichi',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzcyk_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('techzhichi',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
      }
include $this->template('web/techzhichi'); 