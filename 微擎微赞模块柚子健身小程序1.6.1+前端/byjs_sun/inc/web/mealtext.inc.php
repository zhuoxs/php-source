<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

$list = pdo_get('byjs_sun_mealtext',array('uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
    
    if($_GPC['color']){
        $data['color']=$_GPC['color'];
    }else{
        $data['color']="#000000";
    }
    if($_GPC['lunch']){
        $data['lunch']=$_GPC['lunch'];
    }else{
        $data['lunch']="10";
    }
    if($_GPC['dinner']){
        $data['dinner']=$_GPC['dinner'];
    }else{
        $data['dinner']="16";
    }
    $data['uniacid'] = $_W['uniacid'];
    $data['text']=htmlspecialchars_decode($_GPC['text']);
    if($_GPC['id']){
	
        $res=pdo_update('byjs_sun_mealtext',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){

            message('编辑成功',$this->createWebUrl('mealtext',array()),'success');

        }else{

            message('编辑失败','','error');

        }
    }else{
      	
        
        // $data['logo'] = $_GPC['logo'];
        
        // $data['text1']=htmlspecialchars_decode($_GPC['text1']);
        $res = pdo_insert('byjs_sun_mealtext',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('mealtext',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/mealtext');