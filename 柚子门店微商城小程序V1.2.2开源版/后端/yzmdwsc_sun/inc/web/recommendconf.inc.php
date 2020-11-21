<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzmdwsc_sun_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
     		 $data['uniacid']=trim($_W['uniacid']);
             $data['yuyue_name']=trim($_GPC['yuyue_name']);
             $data['haowu_name']=trim($_GPC['haowu_name']);
             $data['groups_name']=trim($_GPC['groups_name']);
             $data['bargain_name']=trim($_GPC['bargain_name']);
             $data['xianshigou_name']=trim($_GPC['xianshigou_name']);
             $data['share_name']=trim($_GPC['share_name']);
             $data['xinpin_name']=trim($_GPC['xinpin_name']);
       
            if($_GPC['id']==''){                
                $res=pdo_insert('yzmdwsc_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('recommendconf',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzmdwsc_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('recommendconf',array()),'success');
                }else{
                    message('编辑失败','','error');
                }  
            }
        }
    include $this->template('web/recommendconf');