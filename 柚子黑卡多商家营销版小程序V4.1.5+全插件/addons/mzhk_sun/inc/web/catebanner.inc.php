<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/catebanner";
$typearr = GetPositon();

//获取分类
$goodscate=pdo_getall('mzhk_sun_goodscate',array('uniacid'=>$_W['uniacid'],'status'=>1));

if($_GPC['op']=='add'){
	$typearr = GetPositon();
    $template = "web/catebanner_add";
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $data['name']=$_GPC['name'];
    $data['sort']=$_GPC['sort'];
	$data['cateid']=$_GPC['cateid'];
	$data['img']=$_GPC['img'];
	$data['link']=$_GPC['link'];
	$data['pop_urltxt']=$_GPC['pop_urltxt'];
	$data['status']=$_GPC['status'];
    $data['time']=time();

	if(empty($data['name'])){
		message('请填写分类轮播图名称','','error');
	}
	if(empty($data['cateid'])){
		message('请选择所属分类','','error');
	}
	if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_catebanner',$data);
        if($res){
            message('添加成功',$this->createWebUrl('catebanner'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_catebanner', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('catebanner'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_catebanner',array('uniacid'=>$_W['uniacid'],'id'=>$id));

    $template = "web/catebanner_add";
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_catebanner',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('catebanner'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{

    $where=" WHERE c.uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select c.*,g.name as catename from " . tablename("mzhk_sun_catebanner") ." as c left join " . tablename("mzhk_sun_goodscate") ." as g on c.cateid=g.id ".$where." order by c.sort asc,c.id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_catebanner") . " as c " .$where." order by c.sort asc,c.id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);