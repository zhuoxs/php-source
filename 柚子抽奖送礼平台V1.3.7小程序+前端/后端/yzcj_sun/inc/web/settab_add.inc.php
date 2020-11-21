<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//调用
// include IA_ROOT . '/addons/yzcj_sun/inc/func/func.php';
$template = "web/settab_add";
// $typearr = GetPositon();
// $typearr_noinput = GetNoShowinput();
$info=pdo_get('yzcj_sun_settab',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
// var_dump($info);
if($info['state']==4){
    $array=explode('=',$info['path']);
    $info['tiaoid']=$array[1];
    // var_dump($info['tiaoid']);
}
    
if(checksubmit('submit')){
    // $id=intval($_GPC['id']);
    $data['name'] = $_GPC['name'];
    $data['img'] = $_GPC['img'];
    $data['imgs'] = $_GPC['imgs'];
    $data['state'] = $_GPC['state'];
    if($_GPC['state']==1){
        $data['path']='/yzcj_sun/pages/ticket/ticketmiannew/ticketmiannew';
    }else if ($_GPC['state']==2){
        $data['path']='/yzcj_sun/pages/ticket/newawardindex/newawardindex';
    }else if ($_GPC['state']==3){
        $data['path']='/yzcj_sun/pages/ticket/ticketadd/ticketadd';
    }else if ($_GPC['state']==4){
        $data['path']='/yzcj_sun/pages/gift/giftindex/giftindex';
    }else if ($_GPC['state']==5){
        $data['path']='/yzcj_sun/pages/ticket/ticketmy/ticketmy';
    }
    $data['sort'] = $_GPC['sort'];
    $data['type'] = 1;
    

    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $data['status']=2;
        $res=pdo_insert('yzcj_sun_settab',$data);
        if($res){
            message('添加成功',$this->createWebUrl('settab'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzcj_sun_settab', $data, array('id' => $_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('settab'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}


include $this->template($template);