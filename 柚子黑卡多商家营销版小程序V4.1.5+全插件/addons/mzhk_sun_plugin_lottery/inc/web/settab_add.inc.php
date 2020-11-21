<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//调用
// include IA_ROOT . '/addons/mzhk_sun_plugin_lottery/inc/func/func.php';
$template = "web/settab_add";
// $typearr = GetPositon();
// $typearr_noinput = GetNoShowinput();
$info=pdo_get('mzhk_sun_plugin_lottery_settab',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
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
        $data['path']='/mzhk_sun/plugin4/ticket/ticketmiannew/ticketmiannew';
    }else if ($_GPC['state']==2){
        $data['path']='/mzhk_sun/plugin4/ticket/newawardindex/newawardindex';
    }else if ($_GPC['state']==3){
        $data['path']='/mzhk_sun/plugin4/ticket/ticketadd/ticketadd';
    }else if ($_GPC['state']==4){
        $data['path']='/mzhk_sun/plugin4/gift/giftindex/giftindex';
    }else if ($_GPC['state']==5){
        $data['path']='/mzhk_sun/plugin4/ticket/ticketmy/ticketmy';
    }
    $data['sort'] = $_GPC['sort'];
    $data['type'] = 1;
    

    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $data['status']=2;
        $res=pdo_insert('mzhk_sun_plugin_lottery_settab',$data);
        if($res){
            message('添加成功',$this->createWebUrl('settab'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_plugin_lottery_settab', $data, array('id' => $_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('settab'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}


include $this->template($template);