<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];

//---------搜索开始-------------

//----------------审核状态--------------

//-------------名字搜索--------------
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" AND title LIKE concat('%',:name,'%')";
    $data[':name']=$op;
    $where = $where;

}


//-------------------搜索结束------------
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;


$sql="SELECT * FROM ".tablename('byjs_sun_goodsarticle').$where." ORDER BY top DESC,top_time DESC";
//print_r($sql);die;
$total=pdo_fetchcolumn("select count(*) from " .tablename('byjs_sun_goodsarticle').$where,$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);

$id = $list[0]['goods_id'];

$goods_name = pdo_getcolumn('byjs_sun_goods',array('id'=>$id),'goods_name');
//print_r($goods_name);
$list[0]['goods_name'] = $goods_name;
//print_r($list);die;
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('byjs_sun_goodsarticle',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('goodsarticle'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
//if($_GPC['op']=='tg'){
//    $rst=pdo_get('byjs_sun_goodsarticle',array('id'=>$_GPC['id']));
//    $time='';
//    if($rst['time_type']==1){
//        $time=24*60*60*7;
//
//    }
//    if($rst['time_type']==2){
//        $time=24*30*60*60;
//
//    }
//    if($rst['time_type']==3){
//        $time=24*91*60*60;
//
//    }
//    if($rst['time_type']==4){
//        $time=24*182*60*60;
//
//    }
//    if($rst['time_type']==5){
//        $time=24*365*60*60;
//
//    }
//
//    $res=pdo_update('byjs_sun_goodsarticle',array('course_status'=>2),array('id'=>$_GPC['id']));
//
//    if($res){
//        message('通过成功！', $this->createWebUrl('course'), 'success');
//    }else{
//        message('通过失败！','','error');
//    }
//}
//if($_GPC['op']=='jj'){
//    $res=pdo_update('byjs_sun_goodsarticle',array('course_status'=>3),array('id'=>$_GPC['id']));
//    if($res){
//        message('拒绝成功！', $this->createWebUrl('course'), 'success');
//    }else{
//        message('拒绝失败！','','error');
//    }
//}
include $this->template('web/goodsarticle');