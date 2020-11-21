<?php
global $_GPC, $_W;
$action = 'start';
$GLOBALS['frames'] = $this->getNaveMenu($_COOKIE['cityname'], $action);
 $type=pdo_getall('zhls_sun_zx_type',array('uniacid'=>$_W['uniacid']));
$info=pdo_get('zhls_sun_zx',array('id'=>$_GPC['id']));
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
        $data['type_id']=$_GPC['type_id'];
        $data['title']=$_GPC['title'];
        $data['content']=html_entity_decode($_GPC['content']);
        $data['time']=date('Y-m-d H:i:s');
        $data['uniacid']=$_W['uniacid'];
        $data['state']=2;
        $data['cityname']=$_COOKIE["cityname"];
        $data['yd_num']=$_GPC['yd_num'];
       if($_GPC['imgs']){
            $data['imgs']=implode(",",$_GPC['imgs']);
        }else{
            $data['imgs']='';
        }
     if($_GPC['id']==''){  
        $data['type']=2;
         $data['pl_num']=0;
       
        $res=pdo_insert('zhls_sun_zx',$data);
        if($res){
             message('添加成功！', $this->createWebUrl2('dlinzx'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{
     
        $res=pdo_update('zhls_sun_zx',$data,array('id'=>$_GPC['id']));
        if($res){
             message('编辑成功！', $this->createWebUrl2('dlinzx'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}
include $this->template('web/dlinaddzx');