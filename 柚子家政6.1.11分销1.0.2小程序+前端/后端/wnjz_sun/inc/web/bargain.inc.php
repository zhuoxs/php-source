<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

// 获取分店数据
$branch = pdo_getall('wnjz_sun_branch',array('uniacid'=>$_W['uniacid']));
$servies = pdo_getall('wnjz_sun_servies',array('uniacid'=>$_W['uniacid']));
if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('wnjz_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('counp',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}

if($_GPC['op']=='tg'){

    $res=pdo_update('wnjz_sun_new_bargain',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('通过成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('wnjz_sun_new_bargain',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}

//
$info=pdo_get('wnjz_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));


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
    // p($_GPC);die;


    $data['uniacid']=$_W['uniacid'];
    $data['gname']=$_GPC['gname'];
    $data['build_id']=$_GPC['build_id'];
    $data['num']=$_GPC['num'];
    $data['marketprice']=$_GPC['goods_cost'];
    $data['shopprice']=$_GPC['goods_price'];
    $data['status']=1;
    $data['starttime']=$_GPC['starttime'];
    $data['endtime']=$_GPC['endtime'];
	$data['canrefund']=$_GPC['canrefund'];
    $data['status']=1;

    $data['selftime']=date('Y-m-d H:i:s', time());
    $data['content']=html_entity_decode($_GPC['content']);
    $data['pic'] = $_GPC['pic'];
    $data['sid'] = $_GPC['sid'];
    if(empty($_GPC['id'])){
        $res = pdo_insert('wnjz_sun_new_bargain', $data ,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('bargainlist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('wnjz_sun_new_bargain', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('bargainlist',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/bargain');