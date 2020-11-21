<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$orderNum= $_GPC['orderNum'];
$order=pdo_get('mzhk_sun_deliveryorder',array('uniacid'=>$_W['uniacid'],'orderNum'=>$orderNum));

$where = " WHERE  uniacid=".$_W['uniacid']." and orderNum = ".$orderNum;


    $key_name=$_GPC['key_name'];
if($key_name){

    $where.=" and gname LIKE '%$key_name%'";        
}


$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$sql = "select * from ".tablename('mzhk_sun_deliveryorderdetail').$where;
// var_dump($sql);
$select_sql =$sql." order by id desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$lits=pdo_fetchall($select_sql);
foreach ($lits as $key => $value) {
    $money += $value['price']*$value['num'];
    if($value['vipprice']!=''){
        $vipmoney += $value['vipprice']*$value['num'];
    }else{
        $vipmoney += $value['price']*$value['num'];
    }
}
if($money==$order['money']){
    $state = 1;

}
if($vipmoney==$order['money']){
    $state = 2;
}
// var_dump($money);
// var_dump($vipmoney);
// var_dump($order['money']);

$total=pdo_fetchcolumn("select count(*) as wname from ".tablename('mzhk_sun_deliveryorder').$where,$data);
$pager = pagination($total, $pageindex, $pagesize);





include $this->template('web/psdetail');