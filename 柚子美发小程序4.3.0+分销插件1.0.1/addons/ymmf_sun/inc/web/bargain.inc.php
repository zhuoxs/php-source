<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$id = 1;

//p($hairData);die;
// 获取门店
$build = pdo_getall('ymmf_sun_branch',array('uniacid'=>$_W['uniacid']));
// 获取技师
$hairData = pdo_getall('ymmf_sun_hairers',array('uniacid'=>$_W['uniacid']));
if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('ymmf_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('bargainlist',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}

if($_GPC['op']=='tg'){

    $res=pdo_update('ymmf_sun_new_bargain',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('通过成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('ymmf_sun_new_bargain',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}

//
$info=pdo_get('ymmf_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

if($info['build_id']){
    $build_id = explode(',',$info['build_id']);
}

if($info['hair_id']){
    $hair_id = explode(',',$info['hair_id']);
    $hair_ids = [];
    foreach ($build_id as $k=>$v){
        foreach ($hair_id as $kk=>$vv){
            if($k==$kk){
                $hair_ids[$v]=$vv;
            }
        }
    }
}

if($info['zs_imgs']){
    if(strpos($info['zs_imgs'],',')){
        $zs_imgs= explode(',',$info['zs_imgs']);
    }else{
        $zs_imgs=array(
            0=>$info['zs_imgs']
        );
    }
}
if($info['lb_imgs']){
    if(strpos($info['lb_imgs'],',')){
        $lb_imgs= explode(',',$info['lb_imgs']);
    }else{
        $lb_imgs=array(
            0=>$info['lb_imgs']
        );
    }
}

if(checksubmit('submit')){
//     p($_GPC);die;
    $data['uniacid']=$_W['uniacid'];
    $data['gname']=$_GPC['gname'];
    $data['num']=$_GPC['num'];
    $data['marketprice']=$_GPC['marketprice'];
    $data['shopprice']=$_GPC['shopprice'];
    $data['status']=2;
    $data['starttime']=$_GPC['starttime'];
    $data['endtime']=$_GPC['endtime'];

    $data['selftime']=time();
    $data['content']=html_entity_decode($_GPC['content']);
    $data['pic'] = $_GPC['pic'];
	$data['hbpic'] = $_GPC['hbpic'];

    $data['hair_id'] = implode(',',$_GPC['hair_id']);
    $data['build_id'] = implode(',',$_GPC['build_id']);

    if(empty($_GPC['id'])){
        $res = pdo_insert('ymmf_sun_new_bargain', $data ,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('bargainlist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['status']);
        $res = pdo_update('ymmf_sun_new_bargain', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('bargainlist',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/bargain');