<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/storeprice";

if($_GPC['op']=='add'){
    $limittype=pdo_getall('yzcyk_sun_storelimit',array('uniacid'=>$_W['uniacid']));

    $template = "web/storeprice_add";
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    // $limittype = $_GPC['limittype'];
    // if(!empty($limittype) || $limittype!=0){
    //     $limittype_array = explode("$$$",$limittype);
    //     $data['lt_name']=$limittype_array[1];
    //     $data['lt_day']=$limittype_array[2];
    //     $data['lt_id']=$limittype_array[0];
    // }
    $data['lt_name']=$_GPC['lt_name'];
    $data['lt_day']=$_GPC['lt_day'];
    $data['money']=$_GPC['money'];
    $data['sort']=$_GPC['sort'];
    if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('yzcyk_sun_storelimit',$data);
        if($res){
            message('添加成功',$this->createWebUrl('storeprice'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzcyk_sun_storelimit', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('storeprice'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('yzcyk_sun_storelimit',array('uniacid'=>$_W['uniacid'],'id'=>$id));
    $template = "web/storeprice_add";
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('yzcyk_sun_storelimit',array('id'=>intval($_GPC['id']),'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('storeprice'), 'success');
        exit;
    }else{
        message('删除失败！','','error');
        exit;
    }
}else{
    $where=" WHERE uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("yzcyk_sun_storelimit") ." ".$where." order by sort asc,id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("yzcyk_sun_storelimit") . " " .$where." order by sort asc,id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);


}

include $this->template($template);