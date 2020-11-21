<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('mzhk_sun_yingxiao',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
//        p($_GPC);die;
            $data['yuyue']=$_GPC['yuyue'];
            $data['yyimg']=$_GPC['yyimg'];
            $data['haowu']=$_GPC['haowu'];
            $data['hwimg']=$_GPC['hwimg'];
            $data['youhuiquan']=$_GPC['youhuiquan'];
            $data['yhqimg']=$_GPC['yhqimg'];
            $data['guanyuwomen']=$_GPC['guanyuwomen'];
            $data['gywmimg']=$_GPC['gywmimg'];
            $data['pintuan']=$_GPC['pintuan'];
            $data['ptimg']=$_GPC['ptimg'];
            $data['kanjia']=$_GPC['kanjia'];
            $data['kjimg']=$_GPC['kjimg'];
            $data['xianshigou']=$_GPC['xianshigou'];
            $data['xsgimg']=$_GPC['xsgimg'];
            $data['fenxiang']=$_GPC['fenxiang'];
            $data['fximg']=$_GPC['fximg'];
            $data['uniacid'] = $_W['uniacid'];
            if($_GPC['id']==''){                
                $res=pdo_insert('mzhk_sun_yingxiao',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('icons',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_yingxiao', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('icons',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/icons');