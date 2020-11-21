<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzpx_sun_card_font',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
$cid=$_GPC['cid'];
if (checksubmit('submit')){
    if($_GPC['font']==null){
        message('请输入文字','','error');
    }

    $data['sort']=$_GPC['sort'];
    $data['font']=$_GPC['font'];
    $data['chance']=$_GPC['chance'];
    $data['uniacid']=$_W['uniacid'];
    $data['cid']=$_GPC['cid'];
    if($_GPC['id']==''){

        $res=pdo_insert('yzpx_sun_card_font',$data);
        if($res){
            message('添加成功',$this->createWebUrl('cardfont',array('cid'=>$data['cid'])),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzpx_sun_card_font',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('cardfont',array('cid'=>$data['cid'])),'success');
        }else{
            message('修改失败','','error');
        }
    }

}
include $this->template('web/addcardfont');