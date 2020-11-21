<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/vipicons";

if($_GPC['op']=='add'){
    $template = "web/addvipicons";
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $data['benefit_name']=$_GPC['benefit_name'];
	$data['benefit_img']=$_GPC['benefit_img'];
	$data['sort']=$_GPC['sort'];
    $data['status']=$_GPC['status'];
	$data['addtime']=time();
	if(empty($data['benefit_name'])){
		message('请填写名称','','error');
	}
	if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_benefit',$data);
        if($res){
            message('添加成功',$this->createWebUrl('vipicons'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_benefit', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('vipicons'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_benefit',array('uniacid'=>$_W['uniacid'],'id'=>$id));

    $template = "web/addvipicons";
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_benefit',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('vipicons'), 'success');
    }else{
        message('删除失败！','','error');
    }
}elseif($_GPC['op']=='changestatus'){
	$id=intval($_GPC['id']);
    if($_GPC['status']==1){
		$res = pdo_update('mzhk_sun_benefit', array('status'=>0), array('id' => $id));
	}else{
		$res = pdo_update('mzhk_sun_benefit', array('status'=>1), array('id' => $id));
	}
    if($res){
        message('修改成功！', $this->createWebUrl('vipicons'), 'success');
    }else{
        message('修改失败！','','error');
    }
}else{

    $where=" WHERE uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("mzhk_sun_benefit") ." ".$where." order by sort asc,id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_benefit") . " " .$where." order by sort asc,id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);