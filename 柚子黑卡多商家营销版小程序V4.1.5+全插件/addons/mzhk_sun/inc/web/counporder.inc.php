<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$where = " WHERE u.uniacid=".$_W['uniacid'];
if(!empty($_GPC['keywords'])){
    $keywords=$_GPC['keywords'];
    $where.=" and c.title LIKE  '%$keywords%'";
}
if(!empty($_GPC['isUsed'])){
    $isUsed=$_GPC['isUsed'];
    $isUsed = $isUsed==2?0:$isUsed;
    $where.=" and u.isUsed LIKE  '%$isUsed%'";
    $isUsed = $isUsed==0?2:$isUsed;
}
if(!empty($_GPC['nametype'])){
    $nametype = $_GPC['nametype'];
    $key_name=$_GPC['key_name'];
    if($nametype=='key_bname'){
        $where.=" and b.bname LIKE '%$key_name%'";        
    }elseif($nametype=='key_uname'){
        $where.=" and us.name LIKE '%$key_name%'";        
    }
}

if(!empty($_GPC['timetype'])){
    $timetype = $_GPC["timetype"];
    $time_start_end = $_GPC["time_start_end"];
    if($time_start_end){
        $time_start_end_arr = explode(" - ",$time_start_end);
        if($time_start_end_arr){
            $starttime = strtotime($time_start_end_arr[0]);
            $endtime = strtotime($time_start_end_arr[1]);
            if($timetype=="key_createTime"){
                $where.=" and createTime >= {$starttime} and createTime <= {$endtime} ";
            }elseif($timetype=="key_useTime"){
                $where.=" and useTime >= {$starttime} and useTime <= {$endtime} ";
            }elseif($timetype=="key_limitTime"){
                $where.=" and limitTime >= {$starttime} and limitTime <= {$endtime} ";
            }
        }
    }
}

$status=$_GPC['status'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
// $data[':uniacid']=$_W['uniacid'];
if($type=='all'){
}else{
    $where.= " and status =$status";
}
//$sql = "select u.*,c.title,b.bname,us.name from ".tablename('mzhk_sun_user_coupon')." as u left join ".tablename('mzhk_sun_coupon')." as c on u.cid=c.id left join ".tablename('mzhk_sun_brand')." as b on b.bid=c.bid left join ".tablename('mzhk_sun_user')." as us on us.openid=u.uid ".$where;

$sql = "select u.*,c.title,c.currentprice,b.bname,(select us.name from ".tablename('mzhk_sun_user')." as us where us.openid=u.uid limit 1) as name from ".tablename('mzhk_sun_user_coupon')." as u left join ".tablename('mzhk_sun_coupon')." as c on u.cid=c.id left join ".tablename('mzhk_sun_brand')." as b on b.bid=c.bid ".$where;

//$total=pdo_fetchcolumn("select count(*) as wname from ".tablename('mzhk_sun_user_coupon')." as u left join ".tablename('mzhk_sun_coupon')." as c on u.cid=c.id left join ".tablename('mzhk_sun_brand')." as b on b.bid=c.bid left join ".tablename('mzhk_sun_user')." as us on us.openid=u.uid ".$where,$data);
$total=pdo_fetchcolumn("select count(*) as wname from ".tablename('mzhk_sun_user_coupon')." as u left join ".tablename('mzhk_sun_coupon')." as c on u.cid=c.id left join ".tablename('mzhk_sun_brand')." as b on b.bid=c.bid ".$where,$data);
$select_sql =$sql." order by id desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$lits=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_user_coupon',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('counporder'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
include $this->template('web/counporder');