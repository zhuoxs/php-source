<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('ims_byjs_sun_card',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
if (checksubmit('submit')){
    if($_GPC['font']==null){
        message('请输入文字','','error');
    }

    $data['logo']=$_GPC['logo'];
    $data['font']=$_GPC['font'];
    $data['chance']=$_GPC['chance'];
    $data['uniacid']=$_W['uniacid'];

  
    if($_GPC['id']==''){

        $res=pdo_insert('ims_byjs_sun_card',$data);
        if($res){
            message('添加成功',$this->createWebUrl('cardlist','','success'));
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('ims_byjs_sun_card',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('修改成功',$this->createWebUrl('cardlist','','success'));
        }else{
            message('修改失败','','error');
        }
    }

}
include $this->template('web/addcard');