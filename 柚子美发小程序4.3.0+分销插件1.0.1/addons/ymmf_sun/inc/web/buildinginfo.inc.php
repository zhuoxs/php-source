<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type = isset($_GPC['type'])?$_GPC['type']:'all';

$build_id = $_GPC['build_id'];
// 分店名称
$b_name = pdo_getcolumn('ymmf_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$build_id),'name');
// 获取不属于该分店的数据
$NotbuildData = pdo_getall('ymmf_sun_buildhair',array('uniacid'=>$_W['uniacid'],'build_id !='=>$build_id));
// 获取当前分店的数据
$buildData = pdo_getall('ymmf_sun_buildhair',array('uniacid'=>$_W['uniacid'],'build_id'=>$build_id),'','','hair_id DESC');

$ids = array();
foreach ($NotbuildData as $k=>$v){
    $ids[$k] = $v['hair_id'];
}
// 获取所有的技师数据
if($ids){
    $hairers = pdo_getall('ymmf_sun_hairers',array('uniacid'=>$_W['uniacid'],'state'=>1,'id !='=>$ids),'','','id DESC');
}else{
    $hairers = pdo_getall('ymmf_sun_hairers',array('uniacid'=>$_W['uniacid'],'state'=>1),'','','id DESC');
}

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
    $data['lng']=$_GPC['lng'];
    $data['lat']=$_GPC['lat'];

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
include $this->template('web/buildinginfo');