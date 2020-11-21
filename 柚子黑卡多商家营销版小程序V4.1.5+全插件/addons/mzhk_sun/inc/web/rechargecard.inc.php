<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/rechargecard";

if($_GPC['op']=='add'){
    $template = "web/rechargecard";
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $data['title']=$_GPC['title'];
    $data['money']=$_GPC['money'];
    $data['lessmoney']=$_GPC['lessmoney'];
    $data['sort']=$_GPC['sort'];
    $data['addtime']=time();
    if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_rechargecard',$data);
        if($res){
            message('添加成功',$this->createWebUrl('rechargecard'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_rechargecard', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('rechargecard'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_rechargecard',array('uniacid'=>$_W['uniacid'],'id'=>$id));

    $template = "web/rechargecard";
}elseif($_GPC['op']=='set'){
    $item=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));

    $template = "web/rechargecard";
}elseif($_GPC['op']=='setsave'){
    $data['isopen_recharge']=intval($_GPC['isopen_recharge']);
    $data['isany_money_recharge']=intval($_GPC['isany_money_recharge']);
    
    if($_GPC['id']==''){  
        $data['uniacid']=$_W['uniacid'];                  
        $res=pdo_insert('mzhk_sun_system',$data);
        if($res){
            message('添加成功',$this->createWebUrl('rechargecard',array('op'=>'set')),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('rechargecard',array('op'=>'set')),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_rechargecard',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('rechargecard'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{

    $where=" WHERE uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("mzhk_sun_rechargecard") ." ".$where." order by sort asc,id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_rechargecard") . " " .$where." order by sort asc,id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);