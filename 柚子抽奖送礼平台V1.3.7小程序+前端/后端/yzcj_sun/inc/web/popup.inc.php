<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzcj_sun_ad',array('uniacid' => $_W['uniacid'],'type'=>2));

if(checksubmit('submit')){
        $data['logo']=$_GPC['logo'];
        $data['status']=$_GPC['status'];
        $data['type']=2;
        $data['uniacid']=$_W['uniacid'];
        // $data['xcx_name']=$_GPC['xcx_name'];
        $data['appid']=$_GPC['appid'];
        $data['url']=$_GPC['url'];

    if($_GPC['id']==''){

            $res=pdo_insert('yzcj_sun_ad',$data);
            if($res){
                 message('添加成功！', $this->createWebUrl('popup'), 'success');
            }else{
                 message('添加失败！','','error');
            }

        
    }else{

            $res=pdo_update('yzcj_sun_ad',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
            if($res){
                 message('编辑成功！', $this->createWebUrl('popup'), 'success');
            }else{
                 message('编辑失败！','','error');
            }

    }
}
include $this->template('web/popup');