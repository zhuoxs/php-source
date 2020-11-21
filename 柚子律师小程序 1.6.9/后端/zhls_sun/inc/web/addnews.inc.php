<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('zhls_sun_news',array('id'=>$_GPC['id']));
$system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
if($system['many_city']==2){
$city = pdo_fetchall("SELECT DISTINCT cityname FROM " . tablename('zhls_sun_hotcity') . " WHERE uniacid= :weid ORDER BY id DESC", array(':weid' =>$_W['uniacid']), 'id');
}
//var_dump($info);die;
if(checksubmit('submit')){
        $data['title']=$_GPC['title'];
        $data['num']=$_GPC['num'];
        //$data['img']=$_GPC['img'];
        $data['state']=$_GPC['state'];
        $data['type']=$_GPC['type'];
        $data['cityname']=$_GPC['cityname'];
         if(empty($_GPC['cityname'])){
            $data['cityname']=$system['cityname'];
        }
        $data['details']=html_entity_decode($_GPC['details']);
        $data['time']=time();
        $data['uniacid']=$_W['uniacid'];
     if($_GPC['id']==''){  
        $res=pdo_insert('zhls_sun_news',$data);
        if($res){
             message('添加成功！', $this->createWebUrl('news'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{
        $res=pdo_update('zhls_sun_news',$data,array('id'=>$_GPC['id']));
        if($res){
             message('编辑成功！', $this->createWebUrl('news'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}
include $this->template('web/addnews');