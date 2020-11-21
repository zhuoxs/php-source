<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$id = 1;

//p($hairData);die;
//$new = date('Y-m-d H:i:s',time());
////        echo json_encode($new);die;
//$sql="select * from".tablename('yzhd_sun_new_bargain').'where uniacid='.$_W['uniacid'].' and status=1 and endtime>'."'$new'".' and num>0';
//$res=pdo_fetchall($sql);
//p($res);die;
$servies = pdo_getall('yzhd_sun_servies',array('uniacid'=>$_W['uniacid']));
if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('yzhd_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('counp',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}

if($_GPC['op']=='tg'){

    $res=pdo_update('yzhd_sun_new_bargain',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('通过成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhd_sun_new_bargain',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}

//
$info=pdo_get('yzhd_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));


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

//    if($_GPC['gname']==null) {
//        message('请您写完整家务名称', '', 'error');
//    }
//    elseif($_GPC['goods_cost']==null){
//        message('请您写完整家务价格','','error');
//    }
//    elseif($_GPC['goods_price']==null){
//        message('请您写完整家务价格','','error');
//    }
//    elseif($_GPC['starttime']==null){
//        message('请您写砍价时间','','error');
//
//    }elseif($_GPC['endtime']==null){
//        message('请您写砍价时间','','error');
//
//    }elseif($_GPC['content']==null){
//        message('请您完整写完详情','','error');die;
//    }
//    elseif($_GPC['pic']== null){
//        message('请您写上传图片','','error');die;
//    }

    $data['uniacid']=$_W['uniacid'];
    $data['gname']=$_GPC['gname'];
    $data['num']=$_GPC['num'];
    $data['marketprice']=$_GPC['goods_cost'];
    $data['shopprice']=$_GPC['goods_price'];
    $data['status']=1;
    $data['starttime']=$_GPC['starttime'];
    $data['endtime']=$_GPC['endtime'];
    $data['status']=1;

    $data['selftime']=date('Y-m-d H:i:s', time());
    $data['content']=html_entity_decode($_GPC['content']);
    $data['pic'] = $_GPC['pic'];
    $data['sid'] = $_GPC['sid'];
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzhd_sun_new_bargain', $data ,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('bargainlist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('yzhd_sun_new_bargain', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('bargainlist',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/bargain');