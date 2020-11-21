<?php
global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/storetime";

if($_GPC['op']=='add'){
    $template = "web/storetime_add";
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $data['lt_name']=$_GPC['lt_name'];
    $data['lt_day']=$_GPC['lt_day'];
    if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_storelimittype',$data);
        if($res){
            message('添加成功',$this->createWebUrl('storetime'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_storelimittype', $data, array('id' => $id));
        //顺便修改入驻价格里面的相应数据
        $res_type = pdo_update('mzhk_sun_storelimit', $data, array('lt_id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('storetime'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    //$data['uniacid']=$_W['uniacid'];
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_storelimittype',array('uniacid'=>$_W['uniacid'],'id'=>$id));

    $template = "web/storetime_add";
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_storelimittype',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('storetime'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{
    $where=" WHERE uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("mzhk_sun_storelimittype") ." ".$where." order by id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_storelimittype") . " " .$where." order by id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);


}

include $this->template($template);