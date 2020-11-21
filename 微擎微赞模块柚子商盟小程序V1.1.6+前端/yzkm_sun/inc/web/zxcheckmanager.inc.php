<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where =" WHERE  a.uniacid=".$_W['uniacid'];
// if($_GPC['keywords']){
//   $op=$_GPC['keywords'];
//   $where.=" and a.sele_name LIKE  concat('%', :name,'%') ";  
//   $data[':name']=$op;
// }

// 圈子分类数据获取
$info = pdo_getall('yzkm_sun_post',array('uniacid' => $_W['uniacid']));
// p($list);die;


if(isset($_GPC['keywords'])){
  $where.=" and a.content LIKE  concat('%', :name,'%') ";
  $data[':name']=$_GPC['keywords'];  
// p($_GPC);die;
}
$state=$_GPC['state'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
 // $data[':uniacid']=$_W['uniacid'];
if($type=='all'){   
  
  $sql = "SELECT a.*,b.name,c.city_rong FROM".tablename('yzkm_sun_zx')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id left join ".tablename('yzkm_sun_address')."c on c.user_id=b.id ".$where." ORDER BY id DESC";
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    // $list=pdo_fetchall($select_sql,$data);
        // foreach ($list as $key => $value) {
        //   $list[$key]['img']= explode(',',$value['img']);  
        //  }   
    $total=pdo_fetchcolumn("SELECT count(*) FROM".tablename('yzkm_sun_zx')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id left join ".tablename('yzkm_sun_address')."c on c.user_id=b.id ".$where,$data); 
}else{
    $where.= " and a.state=$state";
  $sql = "SELECT a.*,b.name,c.city_rong FROM".tablename('yzkm_sun_zx')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id left join ".tablename('yzkm_sun_address')."c on c.user_id=b.id ".$where." ORDER BY id DESC";
      $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
      // $list=pdo_fetchall($select_sql,$data);
          // foreach ($list as $key => $value) {
          //   $list[$key]['img']= explode(',',$value['img']);  
          // }      
    $total=pdo_fetchcolumn("SELECT count(*) FROM".tablename('yzkm_sun_zx')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id left join ".tablename('yzkm_sun_address')."c on c.user_id=b.id ".$where,$data); 
}
    $list=pdo_fetchall($select_sql,$data);
          foreach ($list as $key => $value) {
            if($value['img']){
              $list[$key]['img']= explode(',',$value['img']); 
            }
             
          }  
$pager = pagination($total, $pageindex, $pagesize);





if($_GPC['op']=='delete'){

    $res=pdo_delete('yzkm_sun_zx',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('zxcheckmanager'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
  // p(2);
    $res=pdo_update('yzkm_sun_zx',array('state'=>2,'time'=>date('Y-m-d H:i:s')),array('id'=>$_GPC['id']));
    // p($res);die;
    if($res){
         message('通过成功！', $this->createWebUrl('zxcheckmanager'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzkm_sun_zx',array('state'=>3,'time'=>date('Y-m-d H:i:s')),array('id'=>$_GPC['id']));

    // p($res);die;
    if($res){
         message('拒绝成功！', $this->createWebUrl('zxcheckmanager'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/zxcheckmanager');