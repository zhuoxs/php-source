<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $type=pdo_getall('yzkm_sun_selectedtype',array('uniacid'=>$_W['uniacid']));
$system=pdo_get('yzkm_sun_system',array('uniacid'=>$_W['uniacid']));
$info=pdo_get('yzkm_sun_zx',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
//var_dump($info);die;
if($info['imgs']){
            if(strpos($info['imgs'],',')){
            $imgs= explode(',',$info['imgs']);
        }else{
            $imgs=array(
                0=>$info['imgs']
                );
        }
        }
if(checksubmit('submit')){

    if($_GPC['title']==null) {
        message('请您写标题', '', 'error');
    }
    elseif($_GPC['prob']==null){
        message('请您写完整信息','','error');
    }elseif($_GPC['content']==null){
        message('请您完整写完详情','','error');die;
    }
    elseif($_GPC['lb_imgs']==null){
        message('请您写上传图片','','error');die;
    }
        $data['ac_id']=$_GPC['tid'];
        $data['sele_name']=$_GPC['title'];
        $data['content']=html_entity_decode($_GPC['content']);
        // $data['time']=date('Y-m-d H:i:s');
        $data['uniacid']=$_W['uniacid'];
        $data['detele']=$_GPC['detele'];
        $data['selected']=$_GPC['selected'];
        $data['news']=0;
        $data['prob']=$_GPC['prob'];
        $data['index']=0;
        $data['video']=$_GPC['video'];
        $data['logo']=$_GPC['lb_imgs'];

         if($_GPC['id']==''){

        $res=pdo_insert('yzkm_sun_zx',$data,array('uniacid'=>$_W['uniacid']));

        if($res){
             message('添加成功！', $this->createWebUrl('zx'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{

        $res=pdo_update('yzkm_sun_zx',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
             message('编辑成功！', $this->createWebUrl('zx'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}
include $this->template('web/addzx');