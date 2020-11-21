<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('fyly_sun_contract',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['content']=htmlspecialchars_decode($_GPC['content']);
            $data['uniacid']=$_W['uniacid'];
            if($_GPC['id']==''){                
                $res=pdo_insert('fyly_sun_contract',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('contract',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('fyly_sun_contract', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('contract',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/contract');