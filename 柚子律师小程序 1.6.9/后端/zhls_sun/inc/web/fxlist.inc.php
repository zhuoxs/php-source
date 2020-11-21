<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();



$pageindex = max(1, intval($_GPC['page']));

$pagesize=10;

$where=' WHERE  uniacid=:uniacid';

$data[':uniacid']=$_W['uniacid'];

if(checksubmit('submit')){

    $op=$_GPC['keywords'];

    $where.=" and (user_tel LIKE  concat('%', :name,'%') || user_name LIKE  concat('%', :name,'%'))";    

    $data[':name']=$op;

} 

  $sql="SELECT * FROM ".tablename('zhls_sun_distribution') .  "  ". $where." ORDER BY id DESC";

  $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhls_sun_distribution') .  "".$where." ORDER BY id DESC",$data);



$list=pdo_fetchall( $sql,$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageindex, $pagesize);



$operation=$_GPC['op'];

if($operation=='adopt'){//审核通过

    $id=$_GPC['id'];

    $res=pdo_update('zhls_sun_distribution',array('state'=>2),array('id'=>$id));  

    if($res){

        message('审核成功',$this->createWebUrl('fxlist',array()),'success');

    }else{

        message('审核失败','','error');

    }

}

if($operation=='reject'){

     $id=$_GPC['id'];

    $res=pdo_update('zhls_sun_distribution',array('state'=>3),array('id'=>$id));

     if($res){

        message('拒绝成功',$this->createWebUrl('fxlist',array()),'success');

    }else{

        message('拒绝失败','','error');

    }

}

if($operation=='delete'){

     $id=$_GPC['id'];

     $res=pdo_delete('zhls_sun_distribution',array('id'=>$id));

     if($res){

        message('删除成功',$this->createWebUrl('fxlist',array()),'success');

    }else{

        message('删除失败','','error');

    }



}



include $this->template('web/fxlist');