<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where =" WHERE  a.uniacid=".$_W['uniacid'];

// if(!empty($_GPC['keywords'])){
//     $where.=" and a.sele_name LIKE  concat('%', :name,'%') ";
//     $data[':name']=$_GPC['keywords'];   
// }
    
if(isset($_GPC['keywords'])){
  $where.=" and a.sele_name LIKE  concat('%', :name,'%') ";
  $data[':name']=$_GPC['keywords'];  

}

// 参数
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

// 查询语句
$sql = "SELECT a.*,b.name as user_name FROM".tablename('yzkm_sun_zx')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id ".$where." ORDER BY id DESC"; 
// 总条数
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzkm_sun_zx')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id ".$where,$data);
// p($total);die;
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);
// p($_GPC);die;



	// $total=pdo_fetchcolumn("select count(*) from ".tablename('yzkm_sun_zx')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id ".$where." ORDER BY id DESC",$data);
	$pager = pagination($total, $pageindex, $pagesize);
	// 	$list=pdo_fetchall($sql,$data);
if($_GPC['op']=='delete'){
// p($_GPC['id']);die;
	$res=pdo_delete('yzkm_sun_zx',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('zx'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
// if($_GPC['state']){
// 	$data['state']=$_GPC['state'];
// 	$res=pdo_update('yzkm_sun_zx',$data,array('seid'=>$_GPC['seid']));
// 	if($res){
// 		 message('编辑成功！', $this->createWebUrl('zx'), 'success');
// 		}else{
// 			  message('编辑失败！','','error');
// 		}
// }

include $this->template('web/zx');