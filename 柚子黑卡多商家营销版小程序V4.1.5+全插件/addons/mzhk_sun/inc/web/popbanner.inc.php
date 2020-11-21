<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$template = "web/popbanner";
$typearr = GetPositon();
$typearr_noinput = GetNoShowinput();

if($_GPC['op']=='add'){
    $typearr = GetPositon();
    $template = "web/popbanner_add";
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $pop_title = $_GPC['pop_title'];
    $pop_urltype = $_GPC['pop_urltype'];
    $pop_urltxt = $_GPC['pop_urltxt'];
    $pop_img = $_GPC['pop_img'];
    $sort = $_GPC['sort'];
    if(empty($pop_title)){
        message('弹窗标题不能为空',$this->createWebUrl('popbanner',array('op'=>'add')),'error');
    }
    if(empty($pop_img)){
        message('弹窗图不能为空',$this->createWebUrl('popbanner',array('op'=>'add')),'error');
    }

    $data['pop_title']=$pop_title;
    $data['pop_urltype']=$pop_urltype;
    $data['pop_urltxt']=$pop_urltxt;
    $data['pop_img']=$pop_img;
    $data['sort']=intval($_GPC['sort']);
    $data['position']=1;//1弹窗，2首页轮播（默认主题），3砍价列表，4集卡列表，5抢购列表，6拼团列表，7免单列表，8营销图标，9底部导航，10广告1（主题2），10广告2（主题2）
    
    if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_popbanner',$data);
        if($res){
            message('添加成功',$this->createWebUrl('popbanner'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_popbanner', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('popbanner'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_popbanner',array('uniacid'=>$_W['uniacid'],'id'=>$id));

    $template = "web/popbanner_add";
}elseif($_GPC['op']=='change'){
    $uptype = $_GPC["uptype"];
    $status = intval($_GPC["status"]);
    $id = intval($_GPC["id"]);
    if($uptype=="show"){
        $data['isshow']=$status;
        $res = pdo_update('mzhk_sun_popbanner', $data, array('uniacid' => $_W['uniacid'],'id' => $id));
    }else{
        $data['is_open_pop']=intval($_GPC['is_open_pop']);
        $res = pdo_update('mzhk_sun_system', $data, array('uniacid' => $_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('popbanner'),'success');
    }else{
        message('修改失败','','error');
    }
    
}elseif($_GPC['op']=='search'){
    $tid=$_GPC['tid'];
    $name=$_GPC['name'];
    $list = SearchProductLikename($name,$tid);
    echo json_encode($list);
    exit();
}elseif($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_popbanner',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('popbanner'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{
    $sinfo=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));

    $where=" WHERE uniacid=".$_W['uniacid']." and position=1";
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("mzhk_sun_popbanner") ." ".$where." order by id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_popbanner") . " " .$where." order by id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    
    $pager = pagination($total, $pageindex, $pagesize);
}

include $this->template($template);