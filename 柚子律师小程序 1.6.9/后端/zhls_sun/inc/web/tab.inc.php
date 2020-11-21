<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('zhls_sun_tab',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
//        p($_GPC);die;
            $data['index']=$_GPC['index'];
            $data['indeximg']=$_GPC['indeximg'];
            $data['indeximgs']=$_GPC['indeximgs'];
            $data['coupon']=$_GPC['coupon'];
            $data['couponimg']=$_GPC['couponimg'];
            $data['couponimgs']=$_GPC['couponimgs'];
            $data['fans']=$_GPC['fans'];
            $data['fansimg']=$_GPC['fansimg'];
            $data['fansimgs'] = $_GPC['fansimgs'];
            $data['mine']=$_GPC['mine'];
            $data['mineimg']=$_GPC['mineimg'];
            $data['mineimgs']=$_GPC['mineimgs'];
            $data['fontcolor'] = $_GPC['fontcolor'];
            $data['fontcolored'] = $_GPC['fontcolored'];
            $data['uniacid'] = $_W['uniacid'];
//            p($data);die;
        if($_GPC['id']==''){
                $res=pdo_insert('zhls_sun_tab',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('tab',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhls_sun_tab', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('tab',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/tab');