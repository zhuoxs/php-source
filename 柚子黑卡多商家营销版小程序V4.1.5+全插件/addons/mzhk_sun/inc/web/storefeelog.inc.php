<?php
global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE p.uniacid=".$_W['uniacid'];

$type=isset($_GPC['type'])?$_GPC['type']:'all';
$data[':uniacid']=$_W['uniacid'];

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="SELECT p.id,b.bname,b.lt_day,p.out_trade_no,p.price,p.paytime,p.status FROM ".tablename('mzhk_sun_brandpaylog')." as p left join ".tablename('mzhk_sun_brand')." as b on b.bid=p.bid ".$where." order by p.id desc ";
//echo $sql;
$total=pdo_fetchcolumn("SELECT  count(p.id) as wname FROM".tablename('mzhk_sun_brandpaylog')." as p left join ".tablename('mzhk_sun_brand')." as b on b.bid=p.bid ".$where." order by p.id desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);

foreach($list as $k => $v){
    $list[$k]["paytime"] = $v["paytime"]>0?date("Y-m-d",$v["paytime"]):'';
}

$pager = pagination($total, $pageindex, $pagesize);

if($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_brandpaylog',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

    if($res){
        message('删除成功！', $this->createWebUrl('storefeelog'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
include $this->template('web/storefeelog');