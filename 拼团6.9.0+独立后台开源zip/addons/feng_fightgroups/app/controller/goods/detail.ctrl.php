<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * goods.ctrl
 * 商品详情控制器
 */
 defined('IN_IA') or exit('Access Denied');
 session_start();
 $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
 if($op =='display'){
	$pagetitle = !empty($config['tginfo']['sname']) ? '商品详情 - '.$config['tginfo']['sname'] : '商品详情';
	wl_load()->model('member');
	wl_load()->model('setting');
	$id = $_GPC['id'];
	  
	if(empty($id))wl_message("商品信息出错！");
	puv($_W['openid'],$id); //浏览记录
	if(!empty($_GPC['id'])) $_SESSION['goodsid'] = $_GPC['id'];
	$_SESSION['tuan_id'] = isset($_GPC['tuan_id']) ? intval($_GPC['tuan_id']) : $_SESSION['tuan_id'];
	$goods = model_goods::getSingleGoods($id,'*');//商品
	$goods['allsalenum'] = $goods['falsenum']+$goods['salenum'];
	
	$goods['successgroup'] = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('tg_group')." WHERE goodsid = {$goods['id']} AND groupstatus = 2");
	$goods['inggroup'] = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('tg_group')." WHERE goodsid = {$goods['id']} AND groupstatus = 3");
	//设置
	$set = tgsetting_read('tginfo');
	$set2 = tgsetting_read('base');
	$distance = $set2['distance'];
	//分享
	$config['share']['share_title'] = !empty($goods['share_title']) ? $goods['share_title'] : $goods['gname'];
	$config['share']['share_desc'] = !empty($goods['share_desc']) ? $goods['share_desc'] : $config['share']['share_desc'];
	$config['share']['share_image'] = !empty($goods['share_image']) ? $goods['share_image'] : $goods['gimg'];
	$config['share']['share_url'] = app_url('goods/detail', array('id'=>$goods['id'],'mid'=>$_W['fans']['uid']));
	
	//评论
	
	$comment = model_goods::getSingleGoodsComment($goods['id']);
	$where =array();
	$where['commentid'] = $comment['id'];
	$where['status'] = 2;
	$commentData = Util::getNumData('*', 'tg_discuss', $where,'id desc',0,3,1);
	foreach($commentData[0] as $key => &$v){
		if($v['createtime']=='虚拟'){
			$member = unserialize($v['openid']);
			$v['avatar'] = tomedia($member[0]);
			$v['nickname'] = $member[1];
			$v['createtime'] = date('Y-m-d H:s:i',$member[2]);
		}else{
			$member = Util::getSingelData('*', 'tg_member', array('openid'=>$v['openid']));
			$v['avatar'] = tomedia($member['avatar']);
			$v['nickname'] = $member['nickname'];
			$v['createtime'] = date('Y-m-d H:s:i',$v['createtime']);
		}
		if($v['star'] == 0){
			$v['star'] = 5;
		}
		for ($j=0; $j < $v['star'] ; $j++) { 
			$v['sstar'][$j] = $j;
		}
	}
	$wlfcom = $commentData[0];
	
	if($goods['sharegroupnum']){
		$sharegroupnum = $goods['sharegroupnum'];
	}else {
		$sharegroupnum = 5;
	}
	//猜你喜欢
	$likegoods = pdo_fetchall("SELECT * FROM ".tablename('tg_goods')."WHERE uniacid = {$_W['uniacid']} AND g_type = 1 AND category_parentid = {$goods['category_parentid']} AND isshow = 1 AND id != {$goods['id']} ORDER BY RAND() LIMIT 2");
	if(empty($likegoods[0])){
		$likegoods = pdo_fetchall("SELECT * FROM ".tablename('tg_goods')."WHERE  uniacid = {$_W['uniacid']} AND g_type = 1 AND isshow = 1 AND id != {$goods['id']} ORDER BY RAND() LIMIT 2");
		$likegood1 = $likegoods[0];
		$likegood2 = $likegoods[1];
	}else {
		$likegood1 = $likegoods[0];
		if(empty($likegoods[1])){
			$likegoods2 = pdo_fetchall("SELECT * FROM ".tablename('tg_goods')."WHERE uniacid = {$_W['uniacid']} AND g_type = 1 AND isshow = 1 AND id != {$likegood1['id']} AND id != {$goods['id']} ORDER BY RAND() LIMIT 1");
			$likegood2 = $likegoods2[0];
		}else {
			$likegood2 = $likegoods[1];
		}
	}
	// 分享团数据
	if ($config['base']['sharestatus'] != 2) { 
		$groupData=model_group::getNumGroup('*', array('goodsid'=>$id,'groupstatus'=>3,'!=lacknum'=>'neednum'), 'lacknum asc', 0,$sharegroupnum, 1);
		
		$thistuan = $groupData[0];
		if (!empty($thistuan)) {
			foreach ($thistuan as $key => $value) {
				$tuan_first_order = pdo_fetch("select openid from".tablename('tg_order')."where tuan_id='{$value['groupnumber']}' and tuan_first=1");
				$userinfo= mc_fansinfo($tuan_first_order['openid']);
				$thistuan[$key]['avatar'] = $userinfo['avatar'];
				$thistuan[$key]['nickname'] = $userinfo['nickname'];
				$thistuan[$key]['sytime'] = $value['endtime']-time();
			}
		}
	}
	
	if(empty($goods['unit']))$goods['unit'] = '件';
	if($goods['group_level_status']==2){ //阶梯团
		$param_level = unserialize($goods['group_level']);
		for($i=0;$i<count($param_level)-1;$i++){
			for($j=0;$j<count($param_level)-$i-1;$j++){
				if($param_level[$j]['groupnum']<$param_level[$j+1]['groupnum']){
					$temp=$param_level[$j]; 
					$param_level[$j] = $param_level[$j+1];
					$param_level[$j+1]= $temp;
				}
			}
		}
		if($param_level)$num= round(((100-count($param_level)*2)/count($param_level)));
		$goods['p'] = $param_level[0]['groupprice'];
	}
	
	$timesData = model_order::getMemberOrderNumWithGoods($_W['openid'], $id); /*判断购买次数*/
	$times=$times[2];
	if($goods['merchantid'])$merchant=model_merchant::getSingleMerchant($goods['merchantid'], '*', array('id'=>$goods['merchantid']));//商家
	$specsData = model_goods::getSingleGoodsOption($id); // 规格
	$options = $specsData[2];
	$specs = $specsData[3];
	
	$marketing = model_goods::getMarketing($id); //获取营销参数
		
	if($marketing[0]){ //满减
		foreach($marketing[0] as $value){
			$m1String[] = "满".$value['enough']."减".$value['give'];
		}
	}
	if($marketing[1]['ednum'])$m2String[] = "满".$marketing[1]['ednum'].$goods['unit']."包邮"; //包邮
	if($marketing[1]['edmoney'])$m2String[] = "满".$marketing[1]['edmoney']."元包邮";
	
	if($marketing[2]['deduct']) $m3String[] = "可积分抵扣";  //抵扣
	if($marketing[2]['dispatchnodeduct'] == 1) $m3String[] = "可余额抵扣";
	
	if($marketing[3]){ //赠品
		foreach($marketing[3] as $value){
			$m4String[] = $value['name'];
		}
	}
	
	if($goods['atlas'])$advs = $goods['atlas']; //图集
	$params = $goods['params']; // 自定义属性
	
	if($goods['hexiao_id']){
		foreach($goods['hexiao_id'] as$key=>$value){ //门店信息
			$stores[$key] =  pdo_fetch("select * from".tablename('tg_store')."where id ='{$value}' and uniacid='{$_W['uniacid']}'");
			$stores[$key]['storehours'] = unserialize($stores[$key]['storehours']);
		}
	}else {
		$stores = pdo_getall('tg_store',array('uniacid' => $_W['uniacid'],'merchantid'=>$goods['merchantid']),array('id','storename','storehours','address','lat','lng','tel'));
		foreach($stores as$key=>&$sto){
			$sto['name'] = $sto['storename'];
			$sto['storehours'] = unserialize($sto['storehours']);
		}
	}
	
	if(empty($_SESSION['tuan_id']) && $goods['share_group'] == 1 && empty($goods['forcegroup'])){
		$share_group_flag = 1;
	}
	
	if($goods['is_hexiao']==3 || $goods['g_type']==3){  //抽奖商品
		$lottery=pdo_fetch("select * from".tablename("tg_lottery")."where uniacid={$_W['uniacid']} and fk_goodsid={$id}");
	
		if($lottery['one_limit']==2){
			$ifbuy = pdo_fetch("select tuan_id from".tablename("tg_order")."where lotteryid={$lottery['id']} and status in(1,2,3,4,6,7) and openid = '{$_W['openid']}'");
			$ga = app_url('order/group')."&tuan_id=".$ifbuy['tuan_id'];
		}
		if($goods['hexiao_id']){
			foreach($goods['hexiao_id'] as$key=>$value){ //门店信息
				$stores[$key] =  pdo_fetch("select * from".tablename('tg_store')."where id ='{$value}' and uniacid='{$_W['uniacid']}'");
				$stores[$key]['storehours'] = unserialize($stores[$key]['storehours']);
			}
		}else {
			$stores = pdo_getall('tg_store',array('uniacid' => $_W['uniacid'],'merchantid'=>$goods['merchantid']),array('id','storename','storehours','address','lat','lng','tel'));
			foreach($stores as$key=>&$sto){
				$sto['name'] = $sto['storename'];
				$sto['storehours'] = unserialize($sto['storehours']);
			}
		}	
		include wl_template('goods/lottery_detail');exit;
	}
	
	//拼团有礼
	if($goods['give_coupon_id']){
		$goods['give_coupon_name'] = pdo_getcolumn('tg_coupon_template',array('id'=>$goods['give_coupon_id']),'name');
	}
	if($goods['give_gift_id']){
		$goods['give_gift_name'] = pdo_getcolumn('tg_goods',array('id'=>$goods['give_gift_id']),'gname');
	}
	
	$tag = unserialize($goods['params'][0]['tagcontent']);
	foreach ($tag as $key => &$ta) {
		$ta['data_img'] = tomedia($ta['data_img']);
	}
	include wl_template('goods/goods_detail');
 }

if($op =='ajax'){
	$nowtime = time();
	$goodsid = $_GPC['goodsid'];
	if($_GPC['neednum']){
		$naerbygroup = pdo_fetchall("SELECT groupnumber FROM ".tablename('tg_group')."WHERE uniacid = {$_W['uniacid']} and endtime > {$nowtime} and goodsid = {$goodsid} and neednum = {$_GPC['neednum']} and groupstatus = 3 and neednum != lacknum ORDER BY endtime ASC");
	}else {
		$naerbygroup = pdo_fetchall("SELECT groupnumber FROM ".tablename('tg_group')."WHERE uniacid = {$_W['uniacid']} and endtime > {$nowtime} and goodsid = {$goodsid} and groupstatus = 3  and neednum != lacknum  ORDER BY endtime ASC");
	}
	$groupid = 0;
	foreach ($naerbygroup as $key => $v) {
		$ifgroupid = $v['groupnumber'];
		$res = pdo_get('tg_order',array('uniacid' => $_W['uniacid'],'openid' => $_W['openid'],'tuan_id' => $ifgroupid),array('id'));
		if(empty($res)){
			$groupid = 1;
			break;
		}
	}
	die(json_encode($groupid));
}
if($op =='grouplist'){
	$nowtime = time();
	$goodsid = $_GPC['id'];
	if($_GPC['groupnum']){
		$naerbygroup = pdo_fetchall("SELECT * FROM ".tablename('tg_group')."WHERE uniacid = {$_W['uniacid']} and endtime > {$nowtime} and goodsid = {$goodsid} and neednum = {$_GPC['groupnum']} and groupstatus = 3  and neednum != lacknum  ORDER BY endtime ASC");
	}else {
		$naerbygroup = pdo_fetchall("SELECT * FROM ".tablename('tg_group')."WHERE uniacid = {$_W['uniacid']} and endtime > {$nowtime} and goodsid = {$goodsid} and groupstatus = 3   and neednum != lacknum  ORDER BY endtime ASC");
	}
	foreach ($naerbygroup as $key => $v) {
		$ifgroupid = $v['groupnumber'];
		$res = pdo_get('tg_order',array('uniacid' => $_W['uniacid'],'openid' => $_W['openid'],'tuan_id' => $ifgroupid),array('id'));
		if(empty($res)){
			$tuan_first_order = pdo_fetch("select openid from".tablename('tg_order')."where tuan_id='{$v['groupnumber']}' and tuan_first=1");
			$userinfo= mc_fansinfo($tuan_first_order['openid']);
			$v['avatar'] = $userinfo['avatar'];
			$v['nickname'] = $userinfo['nickname'];
			$v['sytime'] = $v['endtime']-time();
			$nearbygroup[] = $v;
		}
	}
	//wl_debug($nearbygroup);
	include wl_template('goods/goods_grouplist');
}
if($op =='getstore'){
	$gid = $_GPC['gid'];
	$lng = $_GPC['lng'];
	$lat = $_GPC['lat'];
	$ids = pdo_getcolumn('tg_goods',array('id' => $gid),'hexiao_id');
	$ids = unserialize($ids);
	foreach($ids as $k => $v){
		$stores[$k] =  pdo_fetch("select * from".tablename('tg_store')."where id ='{$v}' and uniacid='{$_W['uniacid']}'");
		$stores[$k]['storehours'] = unserialize($stores[$k]['storehours']);
	}
	foreach ($stores as $k => &$store) {
		$radLat1 = @deg2rad($store['lat']); //deg2rad()函数将角度转换为弧度
        $radLat2 = @deg2rad($lat);
        $radLng1 = @deg2rad($store['lng']);
        $radLng2 = @deg2rad($lng);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $store['distance'] = 2 * asin(sqrt(pow(sin($a / 2) , 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2) , 2))) * 6378.137 * 1000;
	}
	for($i=0;$i<count($stores)-1;$i++){
		for($j=0;$j<count($stores)-1-$i;$j++){
			if($stores[$j]['distance']>$stores[$j+1]['distance']){
				$temp = $stores[$j+1];
				$stores[$j+1] = $stores[$j];
				$stores[$j] = $temp;
			}
		}
	}
	foreach ($stores as $key => $value) {
		if($value['distance'] > 1000){
			$stores[$key]['distance'] = (floor(($value['distance']/1000)*10)/10)."km";
		}else{
			$stores[$key]['distance'] = round($value['distance'])."m";
		}
	}
	die(json_encode($stores));
	
}
