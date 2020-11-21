<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$template = "web/popbanner";

if($_GPC['op']=='add'){
    $template = "web/popbanner_add";
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
//    $pop_title = $_GPC['pop_title'];
    $pop_urltype = $_GPC['pop_urltype'];
    $pop_urltxt = $_GPC['pop_urltxt'];
    $pop_img = $_GPC['pop_img'];
//    $sort = $_GPC['sort'];
//    if(empty($pop_title)){
//        message('弹窗标题不能为空',$this->createWebUrl('popbanner',array('op'=>'add')),'error');
//    }
    if(empty($pop_img)){
        message('弹窗图不能为空',$this->createWebUrl('popbanner',array('op'=>'add')),'error');
    }

    $data['pop_title']=$pop_title;
    $data['pop_urltype']=$pop_urltype;
    $data['pop_urltxt']=$pop_urltxt;
    $data['pop_img']=$pop_img;
    $data['sort']=intval($_GPC['sort']);
    
    if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('chbl_sun_popbanner',$data);
        if($res){
            message('添加成功',$this->createWebUrl('popbanner'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('chbl_sun_popbanner', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('popbanner'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('chbl_sun_popbanner',array('uniacid'=>$_W['uniacid'],'id'=>$id));

    $template = "web/popbanner_add";
}elseif($_GPC['op']=='change'){

    $data['is_open_pop']=intval($_GPC['is_open_pop']);
    $res = pdo_update('chbl_sun_system', $data, array('uniacid' => $_W['uniacid']));
    if($res){
        message('修改成功',$this->createWebUrl('popbanner'),'success');
    }else{
        message('修改失败','','error');
    }
    
}elseif($_GPC['op']=='search'){
    $tid=$_GPC['tid'];
    $name=$_GPC['name'];
    //echo json_encode("select id, gname from " . tablename("chbl_sun_bargain") ." ".$where." and gname like'%".$name."%' ");exit;
//    p($name);
    $where=" WHERE uniacid=".$_W['uniacid'];
    if($tid==2){//砍价
        $sql="select id, gname from " . tablename("chbl_sun_bargain") ." ".$where." and gname like'%".$name."%' ";
    }
    elseif($tid==3){//集卡
        $sql="select id,title as gname from " . tablename("chbl_sun_active") ." ".$where." and title like'%".$name."%' ";
    }
    elseif($tid==4){//拼团
        $sql="select id,gname from " . tablename("chbl_sun_groups") ." ".$where." and gname like'%".$name."%' ";
    }
    elseif($tid==5){//普通
        $sql="select id,goods_name as gname from " . tablename("chbl_sun_goods") ." ".$where." and goods_name like'%".$name."%' ";
    }
    elseif($tid==6){//店铺
        $sql="select id,store_name as gname from " . tablename("chbl_sun_store_active") ." ".$where." and  store_name like'%".$name."%' ";
    }
    $list=pdo_fetchall($sql);
    echo json_encode($list);
    exit();
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('chbl_sun_popbanner',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('popbanner'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{
    $sinfo=pdo_get('chbl_sun_system',array('uniacid'=>$_W['uniacid']));

    $where=" WHERE uniacid=".$_W['uniacid'];
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("chbl_sun_popbanner") ." ".$where." order by id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("chbl_sun_popbanner") . " " .$where." order by id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $typearr = array(
        "1"=>"不需要链接",
        "2"=>"砍价商品",
        "3"=>"集卡商品",
        "4"=>"拼团商品",
        "5"=>"普通商品",
        "6"=>"商家店铺",

    );
    $pager = pagination($total, $pageindex, $pagesize);
}

include $this->template($template);