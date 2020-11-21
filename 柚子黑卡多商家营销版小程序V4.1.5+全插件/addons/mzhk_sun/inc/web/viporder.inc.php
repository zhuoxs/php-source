<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

global $_W, $_GPC;
$template = "web/viporder";

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('mzhk_sun_vippaylog',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('vipcode',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}else{
    //获取VIP列表
    $viplist=pdo_getall('mzhk_sun_vip',array('uniacid'=>$_W['uniacid']));

    $where=" WHERE  v.uniacid=:uniacid ";
    $data[':uniacid']=$_W['uniacid'];

    if(!empty($_GPC['vipid'])){
        $vipid = intval($_GPC['vipid']);
        $where.=" and v.vipid = ".$vipid."  ";
    }

    if(!empty($_GPC['activetype'])){
        $activetype = intval($_GPC['activetype']);
        if($activetype==1){
            $where.=" and v.activetype = 1  ";
        }elseif($activetype==2){
            $where.=" and v.activetype = 0 ";
        }
    }

    if(!empty($_GPC['time_start_end'])){
        $time_start_end = $_GPC["time_start_end"];
        $time_start_end_arr = explode(" - ",$time_start_end);
        if($time_start_end_arr){
            $starttime = strtotime($time_start_end_arr[0]);
            $endtime = strtotime($time_start_end_arr[1]);
            $where.=" and v.addtime >= {$starttime} and v.addtime <= {$endtime} ";
        }
    }

    //$sql_money = "select sum(vv.price) as money,sum(v.money) as realmoney from " . tablename("mzhk_sun_vippaylog") ." as v left join " . tablename("mzhk_sun_user") ." as u on u.openid=v.openid left join ". tablename("mzhk_sun_vip") ." as vv on vv.id = v.vipid {$where} order by v.id desc";
	$sql_money = "select sum(vv.price) as money,sum(v.money) as realmoney from " . tablename("mzhk_sun_vippaylog") ." as v left join ". tablename("mzhk_sun_vip") ." as vv on vv.id = v.vipid {$where} order by v.id desc";
    $allmoney_arr = pdo_fetch($sql_money,$data);
    $allmoney = $allmoney_arr["money"];

    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    //$sql="select v.id,v.viptitle,v.vc_code,v.addtime,u.name,v.openid,v.activetype,vv.price,v.money,v.vipday from " . tablename("mzhk_sun_vippaylog") ." as v left join " . tablename("mzhk_sun_user") ." as u on u.openid=v.openid left join ". tablename("mzhk_sun_vip") ." as vv on vv.id = v.vipid {$where} order by v.id desc ";
    //$total=pdo_fetchcolumn("select count(v.id) as wname from " . tablename("mzhk_sun_vippaylog") . " as v left join " . tablename("mzhk_sun_user") ." as u on u.openid=v.openid {$where} order by v.id desc ",$data);
	//$sql="select v.id,v.viptitle,v.vc_code,v.addtime,(select u.name from ".tablename('mzhk_sun_user')." as u where u.openid=v.openid limit 1) as uname,v.openid,v.activetype,vv.price,v.money,v.vipday from " . tablename("mzhk_sun_vippaylog") ." as v left join ". tablename("mzhk_sun_vip") ." as vv on vv.id = v.vipid {$where} order by v.id desc ";
	$sql="select v.id,v.viptitle,v.vc_code,v.addtime,(select u.name from ".tablename('mzhk_sun_user')." as u where u.openid=v.openid limit 1) as uname,v.openid,v.activetype,v.money,v.vipday from " . tablename("mzhk_sun_vippaylog") ." as v {$where} order by v.id desc ";
    $total=pdo_fetchcolumn("select count(v.id) as wname from " . tablename("mzhk_sun_vippaylog") . " as v {$where} order by v.id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);