<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/specialtopic";

if($_GPC['op']=='change'){
    $id = intval($_GPC["id"]);
    $uptype = $_GPC["uptype"];
    $status = intval($_GPC["status"]);
    $where["uniacid"] = $_W['uniacid'];
    $where["id"] = $id;
    if($uptype=="top"){
        $data["istop"] = $status;
    }elseif($uptype=="show"){
        $data["isshow"] = $status;
    }
    if(!$data){
        message('修改失败，参数错误','','error');
    }
    $res = pdo_update('mzhk_sun_specialtopic', $data,$where);
    if($res){
        message('修改成功',$this->createWebUrl('specialtopic'),'success');
    }else{
        message('修改失败','','error');
    }
    
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_specialtopic',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('specialtopic'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{

    $where=" WHERE s.uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select s.*,b.bname,g.gname from " . tablename("mzhk_sun_specialtopic") ." as s left join " . tablename("mzhk_sun_brand") ." as b on b.bid=s.bid left join " . tablename("mzhk_sun_goods") ." as g on g.gid=s.gid ".$where." order by s.id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_specialtopic") . " as s left join " . tablename("mzhk_sun_brand") ." as b on b.bid=s.bid " .$where." order by s.id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);

    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);