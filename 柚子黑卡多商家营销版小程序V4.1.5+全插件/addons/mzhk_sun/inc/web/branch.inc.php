<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('mzhk_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
if(checksubmit('submit')){
    if($_GPC['name']==null) {
        message('请您写店铺名称', '', 'error');
    }elseif($_GPC['address']==null) {
        message('请您写店铺详细地址', '', 'error');
    }

    $data['stutes']=$_GPC['states'];
     $data['name']=$_GPC['name'];
     $data['status']=$_GPC['status'];
    $data['uniacid']=$_W['uniacid'];
    $data['address']=$_GPC['address'];

    if($_GPC['id']==''){
        $reture= pdo_get("mzhk_sun_branch" ,array('status'=>1,'uniacid'=>$_W['uniacid']));

        if($reture){
            $datas['status']=2;
            $reture= pdo_update("mzhk_sun_branch" ,$datas,array('uniacid'=>$_W['uniacid']));
            $res=pdo_insert('mzhk_sun_branch',$data,array('uniacid'=>$_W['uniacid']));
        }else{
           $res=pdo_insert('mzhk_sun_branch',$data,array('uniacid'=>$_W['uniacid']));
        }
        if($res){
            message('添加成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        if( $data['status']==1){
            $reture= pdo_get("mzhk_sun_branch" ,array('status'=>1,'uniacid'=>$_W['uniacid']));
            if($reture){
                $datas['status']=2;
                $reture= pdo_update("mzhk_sun_branch" ,$datas);
                $res = pdo_update('mzhk_sun_branch', $data, array('id' => $_GPC['id']));
            }else{
                $res = pdo_update('mzhk_sun_branch', $data, array('id' => $_GPC['id']));
            }
        }

        if($res){
            message('编辑成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/branch');