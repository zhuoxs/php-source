<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzqzk_sun_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
     		 $data['uniacid']=trim($_W['uniacid']);
             $data['yuyue_sort']=trim($_GPC['yuyue_sort']);
             $data['haowu_sort']=trim($_GPC['haowu_sort']);
             $data['groups_sort']=trim($_GPC['groups_sort']);
             $data['bargain_sort']=trim($_GPC['bargain_sort']);
             $data['xianshigou_sort']=trim($_GPC['xianshigou_sort']);
             $data['share_sort']=trim($_GPC['share_sort']);
             $data['xinpin_sort']=trim($_GPC['xinpin_sort']);
       
            if($_GPC['id']==''){                
                $res=pdo_insert('yzqzk_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('showindex',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzqzk_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('showindex',array()),'success');
                }else{
                    message('编辑失败','','error');
                }  
            }
        }
    include $this->template('web/showindex');