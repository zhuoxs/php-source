<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('ymmf_sun_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
            $data['uniacid']=$_W['uniacid'];       

            $data['zhoubian']=$_GPC['zhoubian'];
            $data['guonei']=$_GPC['guonei'];
            $data['chujing']=$_GPC['chujing'];
            $data['qianzheng']=$_GPC['qianzheng'];
            $data['zhou_font']=$_GPC['zhou_font'];
            $data['guo_font']=$_GPC['guo_font'];
            $data['chu_font']=$_GPC['chu_font'];
            $data['qian_font']=$_GPC['qian_font'];
            if($_GPC['id']==''){                
                $res=pdo_insert('ymmf_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('indextu',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('ymmf_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('indextu',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/indextu');