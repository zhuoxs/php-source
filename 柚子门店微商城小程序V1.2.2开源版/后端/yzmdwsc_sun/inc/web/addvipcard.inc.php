<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzmdwsc_sun_vipcard',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['name']=$_GPC['name'];
            $data['price']=$_GPC['price'];
            $data['discount']=$_GPC['discount'];
            $data['img']=$_GPC['img'];
            $data['desc']=$_GPC['desc'];
            $data['uniacid']=$_W['uniacid'];       
            if($_GPC['id']==''){                
                $res=pdo_insert('yzmdwsc_sun_vipcard',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('viplist',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzmdwsc_sun_vipcard', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('viplist',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/addvipcard');