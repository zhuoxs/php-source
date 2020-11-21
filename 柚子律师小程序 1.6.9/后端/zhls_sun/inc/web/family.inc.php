<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('zhls_sun_family',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
        if(!$_GPC['logo']){
            message('请上传企业logo!');
        }
            $data['logo'] = $_GPC['logo'];
            $data['details']=html_entity_decode($_GPC['details']);
            $data['uniacid']=$_W['uniacid'];       
            $data['name'] =  $_GPC['name'];
            $data['phone'] =  $_GPC['phone'];

            if($_GPC['id']==''){                
                $res=pdo_insert('zhls_sun_family',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('family',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhls_sun_family', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('family',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/family');