<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/specialtopic_add";

if($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $data['title'] = $_GPC['title'];
    $data['content'] = html_entity_decode($_GPC['content']);
    $data['bid'] = intval($_GPC['bid']);
    $data['gid'] = intval($_GPC['gid']);
    $data['seenum'] = intval($_GPC['seenum']);
    $data['likenum'] = intval($_GPC['likenum']);
    $data['addtime'] = time();
    $data['introduction'] = $_GPC['introduction'];
    $data['img'] = $_GPC['img'];
    $data['sort'] = $_GPC['sort'];
	$data['state']=$_GPC['state'];
	$data['video_img']=$_GPC['video_img'];
	$data['video']=$_GPC['video'];
    if(empty($data['title'])){
        message('标题不能为空',$this->createWebUrl('specialtopic',array('op'=>'add')),'error');
    }

    if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_specialtopic',$data);
        if($res){
            message('添加成功',$this->createWebUrl('specialtopic'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_specialtopic', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('specialtopic'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $brand=pdo_getall('mzhk_sun_brand',array('uniacid'=>$_W['uniacid']));
    $info=pdo_get('mzhk_sun_specialtopic',array('uniacid'=>$_W['uniacid'],'id'=>$id));
    $goods=pdo_getall('mzhk_sun_goods',array('uniacid'=>$_W['uniacid'],'bid'=>intval($info["bid"])));

    $template = "web/specialtopic_add";
}elseif($_GPC['op']=='search'){
    $bid=intval($_GPC['bid']);
    $name=$_GPC['name'];
    $where=" WHERE uniacid=".$_W['uniacid'];
    $sql="select gid,gname from " . tablename("mzhk_sun_goods") ." ".$where." and bid = ".$bid." ";
    $list=pdo_fetchall($sql);
    echo json_encode($list);
    exit();
}else{
    $brand=pdo_getall('mzhk_sun_brand',array('uniacid'=>$_W['uniacid']));

}

include $this->template($template);