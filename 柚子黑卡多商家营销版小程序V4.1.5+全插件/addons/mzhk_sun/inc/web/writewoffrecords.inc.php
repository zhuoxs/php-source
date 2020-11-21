<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$goodstype = array('','普通','砍价','拼团','集卡','抢购','免单','吃探','','','优惠券','裂变券','次卡');
$operationtype = array('平台','商家','快递收货核销','次卡自动核销');

//判断吃探是否存在
if(pdo_tableexists("mzhk_sun_eatvisit_set")){
	$eatvisit = 1;
}
//判断裂变券是否存在
if(pdo_tableexists("mzhk_sun_distribution_fission_set")){
	$fission = 1;
}
//判断次卡是否存在
if(pdo_tableexists("mzhk_sun_subcard_set")){
	$subcard = 1;
}

$where=" WHERE uniacid=".$_W['uniacid']." ";

$lid=isset($_GPC['lid'])?$_GPC['lid']:0;

if($lid>0){
	$where .= " and lid=".$lid." ";
}

if(!empty($_GPC['nametype'])){
    $nametype = $_GPC['nametype'];
    $key_name=$_GPC['key_name'];
    if($nametype=='key_gname'){
        $where.=" and gname LIKE '%$key_name%'";
    }elseif($nametype=='key_bname'){
        $where.=" and bname LIKE '%$key_name%'";        
    }elseif($nametype=='key_ordernum'){
		if($lid>0){
			if($lid==1){ //普通
				$sql="select oid from " . tablename("mzhk_sun_order") ." where uniacid=".$_W['uniacid']." and orderNum='".$key_name."' ";
			}
			if($lid==2){ //砍价
				$sql="select oid from " . tablename("mzhk_sun_kjorder") ." where uniacid=".$_W['uniacid']." and orderNum='".$key_name."' ";
			}
			if($lid==3){ //拼团
				$sql="select id as oid from " . tablename("mzhk_sun_ptgroups") ." where uniacid=".$_W['uniacid']." and groupordernum='".$key_name."' ";
			}
			if($lid==4){ //集卡
				$sql="select id as oid from " . tablename("mzhk_sun_cardorder") ." where uniacid=".$_W['uniacid']." and ordernum='".$key_name."' ";
			}
			if($lid==5){ //抢购
				$sql="select oid from " . tablename("mzhk_sun_qgorder") ." where uniacid=".$_W['uniacid']." and orderNum='".$key_name."' ";
			}
			if($lid==6){ //免单
				$sql="select oid from " . tablename("mzhk_sun_hyorder") ." where uniacid=".$_W['uniacid']." and orderNum='".$key_name."' ";
			}
			if($lid==7){ //吃探
				$sql="select id as oid from " . tablename("mzhk_sun_eatvisit_order") ." where uniacid=".$_W['uniacid']." and id=".$key_name." ";
			}
			if($lid==10){ //优惠券
				$sql="select id as oid from " . tablename("mzhk_sun_user_coupon") ." where uniacid=".$_W['uniacid']." and id=".$key_name." ";
			}
			if($lid==11){ //裂变券
				$sql="select id as oid from " . tablename("mzhk_sun_distribution_fission_order") ." where uniacid=".$_W['uniacid']." and id=".$key_name." ";
			}
			if($lid==12){ //次卡
				$sql="select id as oid  from " . tablename("mzhk_sun_subcard_order") ." where uniacid=".$_W['uniacid']." and ordernum='".$key_name."' ";
			}
		}
		$order2 = pdo_fetch($sql);
		if($order2){
			$where.=" and oid=".$order2['oid']." ";
		}
    }
}

if(!empty($_GPC['time_start_end'])){
    $time_start_end = $_GPC["time_start_end"];
    if($time_start_end){
        $time_start_end_arr = explode(" - ",$time_start_end);
        if($time_start_end_arr){
            $starttime = strtotime($time_start_end_arr[0]);
            $endtime = strtotime($time_start_end_arr[1]);
            $where.=" and addtime >= {$starttime} and addtime <= {$endtime} ";
        }
    }
}


$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select * from " . tablename("mzhk_sun_writewoffrecords") ." ".$where." order by id desc ";
$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_writewoffrecords") . " " .$where." ");

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql);
$pager = pagination($total, $pageindex, $pagesize);

if($list){
	foreach($list as $k=>$v){
		if($v['lid']==1){ //普通
			$sql="select gname,bname,orderNum from " . tablename("mzhk_sun_order") ." where uniacid=".$_W['uniacid']." and oid=".$v['oid']." ";
		}
		if($v['lid']==2){ //砍价
			$sql="select gname,bname,orderNum from " . tablename("mzhk_sun_kjorder") ." where uniacid=".$_W['uniacid']." and oid=".$v['oid']." ";
		}
		if($v['lid']==3){ //拼团
			$sql="select gname,bname,groupordernum as orderNum from " . tablename("mzhk_sun_ptgroups") ." where uniacid=".$_W['uniacid']." and id=".$v['oid']." ";
		}
		if($v['lid']==4){ //集卡
			$sql="select gname,bname,ordernum as orderNum from " . tablename("mzhk_sun_cardorder") ." where uniacid=".$_W['uniacid']." and id=".$v['oid']." ";
		}
		if($v['lid']==5){ //抢购
			$sql="select gname,bname,orderNum from " . tablename("mzhk_sun_qgorder") ." where uniacid=".$_W['uniacid']." and oid=".$v['oid']." ";
		}
		if($v['lid']==6){ //免单
			$sql="select gname,bname,orderNum from " . tablename("mzhk_sun_hyorder") ." where uniacid=".$_W['uniacid']." and oid=".$v['oid']." ";
		}
		if($v['lid']==7){ //吃探
			$sql="select gname,storename as bname,ordernum as orderNum from " . tablename("mzhk_sun_eatvisit_order") ." where uniacid=".$_W['uniacid']." and id=".$v['oid']." ";
		}
		if($v['lid']==10){ //优惠券
			$sql="select c.title as gname,b.bname,c.id as orderNum from " . tablename("mzhk_sun_coupon") ." as c left join ".tablename("mzhk_sun_brand")." as b on b.bid=c.bid where c.uniacid=".$_W['uniacid']." and c.id=".$v['gid']." ";
		}
		if($v['lid']==11){ //裂变券
			$sql="select o.fname as gname,b.bname,o.id as orderNum from " . tablename("mzhk_sun_distribution_fission_order") ." as o left join ".tablename("mzhk_sun_brand")." as b on b.bid=o.bid where o.uniacid=".$_W['uniacid']." and o.id=".$v['oid']." ";
		}
		if($v['lid']==12){ //次卡
			$sql="select gname,bname,ordernum as orderNum from " . tablename("mzhk_sun_subcard_order") ." where uniacid=".$_W['uniacid']." and id=".$v['oid']." ";
		}
		$order = pdo_fetch($sql);
		if($order){
			$list[$k]['orderNum'] = $order['orderNum'];
		}

		//获取用户信息
		if($v['openid']){
			$user = pdo_get('mzhk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),array('name'));
			if($user){
				$list[$k]['uname'] = $user['name'];
			}
		}
		
		
	}
}


include $this->template('web/writewoffrecords');