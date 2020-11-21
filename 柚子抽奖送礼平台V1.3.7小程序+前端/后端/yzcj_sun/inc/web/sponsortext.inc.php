<?php
global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

   $list = pdo_get('yzcj_sun_sponsortext',array('uniacid'=>$_W['uniacid']));
        if(checksubmit('submit')){
           
            $data['content']=$_GPC['content'];
            $data['uniacid']=$_W['uniacid'];
            // p($_GPC['id']);die;
            if($_GPC['id']==''){
                $res=pdo_insert('yzcj_sun_sponsortext',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('sponsortext',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzcj_sun_sponsortext', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('sponsortext',array()),'success');
                }else{
                message('编辑失败','','error');
                }
            }
        }

include $this->template('web/sponsortext');