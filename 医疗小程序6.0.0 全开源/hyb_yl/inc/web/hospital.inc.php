<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if(empty($_GPC['pid'])){
  $par_id =$_GPC['hospital']['childid'];
  $type =1;
}else{
  $par_id = $_GPC['pid'];
}
if ($op == 'display') {
   //查询当前地址下的所有医院
  if(empty($par_id)){
     $res = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_addresshospitai")."where uniacid=:uniacid and parentid=0 order by id desc ",array(":uniacid"=>$_W['uniacid']));
  }else{
    $res = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_addresshospitai")."where uniacid=:uniacid and par_id='{$par_id}' and parentid=0 order by id desc ",array(":uniacid"=>$_W['uniacid']));
  }
	
    
}
if ($op == 'post') {
  $subcatess = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_address'));
        $parentpfxm = array();  
        $childrenpfxm = array();  
        if (!empty($subcatess)) {  
          $childrenpfxm = '';  
          foreach ($subcatess as $cidpfxm => $catepfxm) {  
            if (!empty($catepfxm['pid'])) {  
              $childrenpfxm[$catepfxm['pid']][] = $catepfxm;  
            } else {  
              $parentpfxm[$catepfxm['id']] = $catepfxm;  
            }  
          }
        } 


  $id=$_GPC['id'];
  
  $get=pdo_fetch("SELECT a.name as aname,b.name as bname,a.*,b.* FROM".tablename('hyb_yl_addresshospitai')."as a left join".tablename('hyb_yl_address')."as b on b.id =a.par_id  where a.uniacid='{$uniacid}' and a.id='{$id}'");

  $data=array(
	 'uniacid'=>$uniacid,
	 'name'=>$_GPC['name'],
   'hos_pic'=>$_GPC['hos_pic'],
	 'par_id'=>$par_id,
	 'lat'=>$_GPC['map']['lat'],
	 'lng'=>$_GPC['map']['lng'],
   'hos_desc' =>$_GPC['hos_desc'],
   'hos_tuijian'=>$_GPC['hos_tuijian'],
   'tijiaotime' =>strtotime("now"),
   'hos_thumb' =>$_GPC['hos_thumb']
  	);
  if(checksubmit('tijiao')){
  	
	if($_GPC['map']['lat']==""&&$_GPC['map']['lng']==""){
       message("经纬度不能为空!",$this->createWebUrl("hospital",array("op"=>"post",'pid'=>$par_id)),"error");
	}
    if(!empty($id)){
        pdo_update("hyb_yl_addresshospitai",$data,array('uniacid'=>$uniacid,'id'=>$id));
        if($type ==1){
           message("更新成功!",$this->createWebUrl("hospital",array("op"=>"display")),"success");
        }else{
           message("更新成功!",$this->createWebUrl("hospital",array("op"=>"display",'pid'=>$par_id)),"success");
        }
        
        
    }else{
    	
    	pdo_insert("hyb_yl_addresshospitai",$data);
        message("添加成功!",$this->createWebUrl("hospital",array("op"=>"display",'pid'=>$par_id)),"success");
    }
  }

}

  if($op == 'delete'){
       $id =$_GPC['id'];
       pdo_delete("hyb_yl_addresshospitai",array('id'=>$id,'uniacid'=>$uniacid));
       message("删除成功!",$this->createWebUrl("hospital",array("op"=>"display",'pid'=>$par_id)),"success");
  }
include $this->template('hospital/hospital');