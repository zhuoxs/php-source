<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$item=pdo_get('byjs_sun_mall',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

//获取腾讯地图key
$developkey=pdo_get('byjs_sun_system',array('uniacid'=>$_W['uniacid']),array('developkey'));
$key = $developkey['developkey'];

if(checksubmit('submit')){
    if($_GPC['name']==null) {
        message('请您写店铺名称', '', 'error');
    }elseif($_GPC['address']==null) {
        message('请您写店铺详细地址', '', 'error');
    }
    $data['stutes']=2;
    $data['name']=$_GPC['name'];
    $data['status']=$_GPC['status'];
    $data['uniacid']=$_W['uniacid'];
    $data['address']=$_GPC['address'];
    $data['tel']=$_GPC['tel'];
    $data['account']=$_GPC['account'];
	$data['pwd']=$_GPC['pwd'];
    $data['logo']=$_GPC['logo'];
    $data['lng']=$_GPC['lng'];
  	$data['lat']=$_GPC['lat'];
  	$data['detail']=htmlspecialchars_decode($_GPC['detail']);
    // p($data);
    if($_GPC['id']==''){
        // $reture= pdo_get("byjs_sun_mall" ,array('status'=>1,'uniacid'=>$_W['uniacid']));

        // if($reture){
        //     $datas['status']=2;
        //     $reture= pdo_update("byjs_sun_mall" ,$datas,array('uniacid'=>$_W['uniacid']));
        //     $res=pdo_insert('byjs_sun_mall',$data,array('uniacid'=>$_W['uniacid']));
        // }else{
        //    $res=pdo_insert('byjs_sun_mall',$data,array('uniacid'=>$_W['uniacid']));
        // }
        $res=pdo_insert('byjs_sun_mall',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('malllist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        // if( $data['status']==1){
        //     $reture= pdo_get("byjs_sun_mall" ,array('status'=>1,'uniacid'=>$_W['uniacid']));
        //     if($reture){
        //         $datas['status']=2;
        //         $reture= pdo_update("byjs_sun_mall" ,$datas);
        //         $res = pdo_update('byjs_sun_mall', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        //     }else{
        //         $res = pdo_update('byjs_sun_mall', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        //     }
        // }
        $res = pdo_update('byjs_sun_mall', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('malllist',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}



include $this->template('web/addmall');