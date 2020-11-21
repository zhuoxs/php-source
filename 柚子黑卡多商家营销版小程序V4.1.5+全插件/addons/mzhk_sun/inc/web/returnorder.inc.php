<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$type = $_GPC['type'] ? $_GPC['type'] : 0;

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

if($type==1){ //优惠券
	$sql ="select * from ".tablename('mzhk_sun_user_coupon')." where uniacid=".$_W['uniacid']." and returnsign=1 order by id desc limit ".($pageindex - 1) * $pagesize.",".$pagesize;
	
	$total=pdo_fetchcolumn("select  count(*) as wname from ".tablename('mzhk_sun_user_coupon')." where uniacid=".$_W['uniacid']." and returnsign=1 order by id desc");
}elseif($type==2){ //普通商品
	$sql ="select * from ".tablename('mzhk_sun_order')." where uniacid=".$_W['uniacid']." and returnsign=1 order by oid desc limit ".($pageindex - 1) * $pagesize.",".$pagesize;
	$total=pdo_fetchcolumn("select count(*) as wname from ".tablename('mzhk_sun_order')." where uniacid=".$_W['uniacid']." and returnsign=1 order by oid desc");
}else{ //余额
	$sql ="select money,viplogid,vipid,openid from ".tablename('mzhk_sun_rechargelogo')." where uniacid=".$_W['uniacid']." and returnsign=1 order by id desc limit ".($pageindex - 1) * $pagesize.",".$pagesize;
	$total=pdo_fetchcolumn("select count(*) as wname from ".tablename('mzhk_sun_rechargelogo')." where uniacid=".$_W['uniacid']." and returnsign=1 order by id desc");
}

$list = pdo_fetchall($sql);

$pager = pagination($total, $pageindex, $pagesize);

if($list){
	foreach($list as $k=>$v){
		//获取购买会员时间
		$viplog = pdo_get('mzhk_sun_vippaylog',array('uniacid'=>$_W['uniacid'],'id'=>$v['viplogid']),array('addtime'));
		
		//获取会员名称
		$vipinfo = pdo_get('mzhk_sun_vip',array('uniacid'=>$_W['uniacid'],'id'=>$v['vipid']),array('title'));
		
		$list[$k]['buyviptime'] = date("Y-m-d H:i:s",$viplog['addtime']);
		$list[$k]['vipname'] = $vipinfo['title'];
		
		if($type>0){
			//获取商家名称、图片
			if($type==1){
				$coupon = pdo_get('mzhk_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$v['cid']),array('bid','img','title'));
				$brand = pdo_get('mzhk_sun_brand',array('uniacid'=>$_W['uniacid'],'bid'=>$coupon['bid']),array('bname'));
				$list[$k]['bname'] = $brand['bname'];
				$list[$k]['img'] = $_W['attachurl'].$coupon['img'];
				$list[$k]['gname'] = $coupon['title'];
			}else{
				$brand = pdo_get('mzhk_sun_brand',array('uniacid'=>$_W['uniacid'],'bid'=>$v['bid']),array('bname'));
				$list[$k]['bname'] = $brand['bname'];
				$list[$k]['img'] = $_W['attachurl'].$v['goodsimg'];
			}
		}
	}
}

include $this->template('web/returnorder');