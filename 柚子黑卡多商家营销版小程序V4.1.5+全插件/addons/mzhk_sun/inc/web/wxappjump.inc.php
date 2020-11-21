<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/wxappjump";
$position = array("不在固定位置使用","首页浮标");

if($_GPC['op']=='add'){
    $template = "web/wxappjump_add";
    
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $data['title']=$_GPC['title'];
    $data['pic']=$_GPC['pic'];
    $data['appid']=$_GPC['appid'];
    $data['path']=$_GPC['path'];
    $data['position']=intval($_GPC['position']);
    $data['sort']=intval($_GPC['sort']);
    $data['addtime']=time();
    if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_wxappjump',$data);
        if($res){
            message('添加成功',$this->createWebUrl('wxappjump'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_wxappjump', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('wxappjump'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_wxappjump',array('uniacid'=>$_W['uniacid'],'id'=>$id));

    $template = "web/wxappjump_add";
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_wxappjump',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('wxappjump'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{

    $where=" WHERE uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("mzhk_sun_wxappjump") ." ".$where." order by position asc,sort asc,id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_wxappjump") . " " .$where." order by position asc,sort asc,id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);