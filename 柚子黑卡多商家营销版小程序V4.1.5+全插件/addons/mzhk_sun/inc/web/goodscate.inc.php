<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/goodscate";

if($_GPC['op']=='add'){
    $template = "web/goodscate_add";
}elseif($_GPC['op']=='change'){
    $uptype = $_GPC["uptype"];
    $status = intval($_GPC["status"]);
    $id = intval($_GPC["id"]);
    if($uptype=="show"){
        $data['status']=$status;
        $res = pdo_update('mzhk_sun_goodscate', $data, array('uniacid' => $_W['uniacid'],'id' => $id));
    }
    if($res){
        message('修改成功',$this->createWebUrl('goodscate'),'success');
    }else{
        message('修改失败','','error');
    }
    
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $data['name']=$_GPC['name'];
	$data['cateexplain']=$_GPC['cateexplain'];
    $data['sort']=$_GPC['sort'];
	$data['cateimg']=$_GPC['cateimg'];
	$data['status']=$_GPC['status'];
    $data['time']=time();
	if(empty($data['name'])){
		message('请填写分类名称','','error');
	}
	if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_goodscate',$data);
        if($res){
            message('添加成功',$this->createWebUrl('goodscate'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_goodscate', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('goodscate'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_goodscate',array('uniacid'=>$_W['uniacid'],'id'=>$id));

    $template = "web/goodscate_add";
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_goodscate',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('goodscate'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{

    $where=" WHERE uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("mzhk_sun_goodscate") ." ".$where." order by sort asc,id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_goodscate") . " " .$where." order by sort asc,id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
	if($list){
		foreach($list as $k=>$v){
			if($v['cateimg']){
				$list[$k]['cateimg'] = $_W["attachurl"].$v["cateimg"];
			}
		}
	}
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);