<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('zhls_sun_ad',array('id'=>$_GPC['id']));
$system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
if($system['many_city']==2){
$city = pdo_fetchall("SELECT DISTINCT cityname FROM " . tablename('zhls_sun_hotcity') . " WHERE uniacid= :weid ORDER BY id DESC", array(':weid' =>$_W['uniacid']), 'id');
}
if(checksubmit('submit')){
         $data['logo']=$_GPC['logo'];
        
        $data['orderby']=$_GPC['orderby'];
        $data['status']=$_GPC['status'];
        $data['title']=$_GPC['title'];
        $data['type']=$_GPC['type'];
        
        $data['cityname']=$_GPC['cityname'];
        if($_GPC['state']==1){
              $data['state']=1;
            $data['src']=$_GPC['src'];
             $data['wb_src']='';
            $data['xcx_name']='';
            $data['appid']='';
        }
         if($_GPC['state']==2){
             $data['state']=2;
           $data['src']='';
             $data['wb_src']=$_GPC['wb_src'];
            $data['xcx_name']='';
            $data['appid']='';
        }
          if($_GPC['state']==3){
            $data['state']=3;
           $data['src']='';
            $data['wb_src']='';
            $data['xcx_name']=$_GPC['xcx_name'];
            $data['appid']=$_GPC['appid'];
        }
         if(empty($_GPC['cityname'])){
            $data['cityname']=$system['cityname'];
        }
      
        $data['uniacid']=$_W['uniacid'];
     if($_GPC['id']==''){  
        $res=pdo_insert('zhls_sun_ad',$data);
        if($res){
             message('添加成功！', $this->createWebUrl('inquiry'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{
        $res=pdo_update('zhls_sun_ad',$data,array('id'=>$_GPC['id']));
        if($res){
             message('编辑成功！', $this->createWebUrl('inquiry'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}
include $this->template('web/addinquiry');