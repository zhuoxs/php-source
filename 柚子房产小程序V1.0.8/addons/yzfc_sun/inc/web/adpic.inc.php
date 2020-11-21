<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$template = "web/adpic";
if(checksubmit('submit')){
    if($_GPC['title']==null) {
        message('请填写标题', '', 'error');
    }elseif($_GPC['ad_pic']==null){
        message('请上传弹窗广告图', '', 'error');
    }
    $data['title']=$_GPC['title'];
    $data['uniacid']=$_W['uniacid'];
    $data['link_type']=$_GPC['link_type'];
    $data['link_typeid']=$_GPC['link_typeid'];
    $data['sort']=$_GPC['sort'];
    $data['ad_pic']=$_GPC['ad_pic'];
    if($_GPC['id']==''){
        $res=pdo_insert('yzfc_sun_adpic',$data);
        if($res){
            message('添加成功',$this->createWebUrl('adpic_list',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzfc_sun_adpic',$data,array('id'=>$_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('adpic_list',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
if($_GPC['id']){
    $info=pdo_get('yzfc_sun_adpic',array('id'=>$_GPC['id']));
}
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzfc_sun_adpic',array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('adpic_list',array()),'success');
    }else{
        message('操作失败','','error');
    }

}
    if($_GPC['op']=='search'){

        $tid=$_GPC['tid'];
        $name=$_GPC['name'];
        $where=" WHERE uniacid=".$_W['uniacid'];
        if($tid==1){//楼盘
            $sql="select id,name from " . tablename("yzfc_sun_house") ." ".$where." and name like'%".$name."%' ";
        }
        $list=pdo_fetchall($sql);
        echo json_encode($list);
        exit();
    }

include $this->template($template);