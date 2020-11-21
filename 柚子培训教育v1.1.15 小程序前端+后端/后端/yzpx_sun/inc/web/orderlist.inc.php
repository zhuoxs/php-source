<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and username LIKE  '%$op%'";
}
if($_GPC['cid']){
    $where .=" and cid =".$_GPC['cid'];
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzpx_sun_course_order") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzpx_sun_course_order')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
if($info){
    foreach ($info as $key =>$value){
        $classify=pdo_get('yzpx_sun_course',array('id'=>$value['cid']));
        $info[$key]['cname']=$classify['title'];
        $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
        if($value['sid']>0){
            $school=pdo_get('yzpx_sun_school',array('id'=>$value['sid']),array('name'));
            $info[$key]['school']=$school['name'];
        }else{
            $info[$key]['school']='总校';
        }
    }
}

include $this->template('web/orderlist');