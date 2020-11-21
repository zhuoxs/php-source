<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzfc_sun_card_font',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
$cid=$_GPC['cid'];
if (checksubmit('submit')){
    if($_GPC['font']==null){
        message('请上传图片','','error');
    }

    $data['sort']=$_GPC['sort'];
    $data['font']=$_GPC['font'];
    $data['chance']=$_GPC['chance'];
    $data['uniacid']=$_W['uniacid'];
    $data['cid']=$_GPC['cid'];
    if($_GPC['id']==''){
        $where = " Where cid =".$_GPC['cid']." and uniacid =".$_W['uniacid'];
        $total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_card_font") .$where);
        if($total>9){
            message('最多只能十张','','error');
        }
        $res=pdo_insert('yzfc_sun_card_font',$data);
        if($res){
            message('添加成功',$this->createWebUrl('cardfont',array('cid'=>$data['cid'])),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzfc_sun_card_font',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('cardfont',array('cid'=>$data['cid'])),'success');
        }else{
            message('修改失败','','error');
        }
    }

}
include $this->template('web/addcardfont');