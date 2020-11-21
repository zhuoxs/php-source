<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('chbl_sun_yingxiao',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
//        p($_GPC);die;
            $data['toutiao']=$_GPC['toutiao'];
            $data['ttimg']=$_GPC['ttimg'];
            $data['pintuan']=$_GPC['pintuan'];
            $data['ptimg']=$_GPC['ptimg'];
            $data['jika']=$_GPC['jika'];
            $data['jkimg']=$_GPC['jkimg'];
            $data['kanjia']=$_GPC['kanjia'];
            $data['kjimg']=$_GPC['kjimg'];
            $data['uniacid'] = $_W['uniacid'];
            if($_GPC['id']==''){                
                $res=pdo_insert('chbl_sun_yingxiao',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('icons',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('chbl_sun_yingxiao', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('icons',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/icons');