<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('yzhyk_sun_tab',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['index']=$_GPC['index'];
            $data['indeximg']=$_GPC['indeximg'];
            $data['indeximgs']=$_GPC['indeximgs'];
            $data['store']=$_GPC['store'];
            $data['storeimg']=$_GPC['storeimg'];
            $data['storeimgs']=$_GPC['storeimgs'];
            $data['dynamic']=$_GPC['dynamic'];
            $data['dynamicimg']=$_GPC['dynamicimg'];
            $data['dynamicimgs'] = $_GPC['dynamicimgs'];
            $data['dynamic_status']=$_GPC['dynamic_status'];
            $data['cart']=$_GPC['cart'];
            $data['cartimg']=$_GPC['cartimg'];
            $data['cartimgs'] = $_GPC['cartimgs'];
            $data['mine']=$_GPC['mine'];
            $data['mineimg']=$_GPC['mineimg'];
            $data['mineimgs']=$_GPC['mineimgs'];
            $data['fontcolor'] = $_GPC['fontcolor'];
            $data['fontcolored'] = $_GPC['fontcolored'];
            $data['uniacid'] = $_W['uniacid'];
        if($_GPC['id']==''){
                $res=pdo_insert('yzhyk_sun_tab',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('tab',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzhyk_sun_tab', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('tab',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/tab');