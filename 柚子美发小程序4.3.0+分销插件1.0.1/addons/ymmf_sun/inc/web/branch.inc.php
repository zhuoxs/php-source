<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('ymmf_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
//获取腾讯地图key
$developkey=pdo_get('ymmf_sun_system',array('uniacid'=>$_W['uniacid']),array('qqkey'));
$key = $developkey['qqkey'];

$op = $_GPC["op"];
if($op=="search"){
    $name=$_GPC['name'];
    $where=" WHERE uniacid=".$_W['uniacid'];
    $sql="select openid,name as uname,img,id from " . tablename("ymmf_sun_user") ." ".$where." and name like'%".$name."%' ";
    $list=pdo_fetchall($sql);
    echo json_encode($list);
    exit();
}

//获取微信号
$userlist=pdo_get('ymmf_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$item['bind_uid']),array("name"));
$item["uname"] = $userlist["name"];

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
    $data['logo']=$_GPC['logo'];
    $data['phone']=$_GPC['phone'];
    $data['lng']=$_GPC['lng'];
    $data['lat']=$_GPC['lat'];
    $data['user']=$_GPC['user'];
    $data['key']=$_GPC['key'];
    $data['sn']=$_GPC['sn'];
    $data["bind_uid"] = $_GPC["bind_uid"];

    if($_GPC['id']==''){
        if($data['status']==1){
            $datas['status']=2;
            $reture= pdo_update("ymmf_sun_branch" ,$datas,array('uniacid'=>$_W['uniacid']));
            $res=pdo_insert('ymmf_sun_branch',$data,array('uniacid'=>$_W['uniacid']));
        }else{
           $res=pdo_insert('ymmf_sun_branch',$data,array('uniacid'=>$_W['uniacid']));
        }
        if($res){
            message('添加成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        if($data['status']==1){
            $datas['status']=2;
            $reture= pdo_update("ymmf_sun_branch" ,$datas,array('uniacid'=>$_W['uniacid']));
            $res = pdo_update('ymmf_sun_branch', $data, array('id' => $_GPC['id']));
        }else{
            $res = pdo_update('ymmf_sun_branch', $data, array('id' => $_GPC['id']));
        }

        if($res){
            message('编辑成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/branch');