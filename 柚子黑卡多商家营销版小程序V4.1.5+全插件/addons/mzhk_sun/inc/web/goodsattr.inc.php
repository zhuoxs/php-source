<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/goodsattr";
// var_dump($_GPC['op']);
if($_GPC['op']=='add'){
    $template = "web/goodsattr_add";
}elseif($_GPC['op']=='change'){
    $uptype = $_GPC["uptype"];
    $status = intval($_GPC["status"]);
    $id = intval($_GPC["id"]);
    if($uptype=="show"){
        $data['status']=$status;
        $res = pdo_update('mzhk_sun_goodsattr', $data, array('uniacid' => $_W['uniacid'],'id' => $id));
    }
    if($res){
        message('修改成功',$this->createWebUrl('goodsattr'),'success');
    }else{
        message('修改失败','','error');
    }
    
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $data['name']=$_GPC['name'];
	// $data['status']=$_GPC['status'];
    // $data['time']=time();
	if(empty($data['name'])){
		message('请填写规格名称','','error');
	}
    if(empty($_GPC['value'])){
        message('请填写规格可选值','','error');
    }
    if($_GPC['value']){
        $value=explode(PHP_EOL,$_GPC['value']);
        $value=array_filter($value);
    }
    // var_dump($data);
    // var_dump($_GPC['value']);
    // var_dump($value);
    // die;
	if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_goodsattr',$data);
        $attrid=pdo_insertid();
        if($res){
            foreach ($value as $k => $v) {
                $data1['attrid']=$attrid;
                $data1['value']=$v;
                $data1['uniacid']=$_W['uniacid'];
                pdo_insert('mzhk_sun_goodsattr_value',$data1);
            }
            message('添加成功',$this->createWebUrl('goodsattr'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        // $res = pdo_update('mzhk_sun_goodsattr', $data, array('id' => $id));
        $attrvalue=pdo_get('mzhk_sun_goodsattr_value',array('uniacid'=>$_W['uniacid'],'attrid'=>$id),array('count(id) as count'));

        $result=pdo_delete('mzhk_sun_goodsattr_value',array('uniacid'=>$_W['uniacid'],'attrid'=>$id));
        foreach ($value as $k => $v) {
            if($v){
                $data1['attrid']=$id;
                $data1['value']=$v;
                $data1['uniacid']=$_W['uniacid'];
                pdo_insert('mzhk_sun_goodsattr_value',$data1);
            }
            
        }
        if($res||$result){
            message('修改成功',$this->createWebUrl('goodsattr'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_goodsattr',array('uniacid'=>$_W['uniacid'],'id'=>$id));
    $value=pdo_getall('mzhk_sun_goodsattr_value',array('uniacid'=>$_W['uniacid'],'attrid'=>$id));
    if($value){
        $value  = array_column($value,'value');
        // var_dump($value);
        $value  = count($value)>1?implode(PHP_EOL,$value):$value[0];
    }
    else{
        $value = '';
    }
    $info['value']=$value;

    $template = "web/goodsattr_add";
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_goodsattr',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('goodsattr'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{

    $where=" WHERE uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("mzhk_sun_goodsattr") ." ".$where." order by id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_goodsattr") . " " .$where." order by id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
	if($list){
		foreach($list as $k=>$v){
            

			$value = pdo_getall('mzhk_sun_goodsattr_value',array('uniacid'=>$_W['uniacid'],'attrid'=>$v['id']));

            $list[$k]['value']=$value;
		}

	}

    $pager = pagination($total, $pageindex, $pagesize);

}


include $this->template($template);