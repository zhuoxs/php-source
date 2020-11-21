<?php 
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
if ($op == 'list') {
	/*测试抽奖*/
		if($_GPC['ceshi']){
			set_time_limit(0); //解除超时限制	
			queue::queueMain();
//			wl_debug($r);
		}
	$todo = !empty($_GPC['todo']) ? $_GPC['todo'] : 'display';
	
	if($todo == 'display'){
		$_W['page']['title'] = '应用和营销  - 抽奖团列表';
		$condition = " uniacid={$_W['uniacid']} ";
		$keywordtype = $_GPC['keywordtype'];
		$keyword = $_GPC['keyword'];
		$timetype = $_GPC['timetype'];
		$time = $_GPC['time'];	
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}
		if (!empty($_GPC['time'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']) ;
			if(empty($timetype)){
				$condition .= " AND  createtime >= '{$starttime}' AND  createtime <= '{$endtime}' ";
			}else{
				switch($timetype){
					case 1:$condition .= " AND  starttime >= '{$starttime}' AND  starttime <= '{$endtime}' ";break;
					case 2:$condition .= " AND  endtime >= '{$starttime}' AND  endtime <= '{$endtime}' ";break;
					default:;
				}
			}
		}
		if (!empty($keyword)) {
			if(!empty($keywordtype)){
				switch($keywordtype){
					case 1:$condition .= " AND  gname LIKE '%{$keyword}%' ";break;
					case 2:$condition .= " AND  fk_goodsid = '{$keyword}' ";break;
					default:;
				}
			}else{
				$condition .=" AND gname = '无查询结果' ";
			}
		}
		$status = empty($_GPC['status']) ? '1' : $_GPC['status'];
		if(!empty($_GPC['status'])){
			$condition .=" and status={$status} ";
		}else{
			$condition .=" and status=1 ";
		}
		$lottery = pdo_fetchall("select * from".tablename('tg_lottery')."where  $condition order by endtime desc");
		foreach($lottery as$k=>&$v){	
			$v['prize'] = unserialize($v['prize']);
		}
		$all1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_lottery') . " WHERE uniacid='{$_W['uniacid']}' and status=1 ");
		$all2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_lottery') . " WHERE uniacid='{$_W['uniacid']}' and status=2 ");
		$all3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_lottery') . " WHERE uniacid='{$_W['uniacid']}' and status=3 ");
		$all4 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_lottery') . " WHERE uniacid='{$_W['uniacid']}' and status=4 ");
		include wl_template('application/lottery/lottery_list');exit;
	}
	if ($todo == 'ajax') {
		$id = $_GPC['id'];
		$goods = model_goods::getSingleGoods($id, '*');
		die(json_encode($goods));
	}
	if ($todo == 'selectgoods') {
//		$con     = "uniacid='{$_W['uniacid']}' and isshow in(1,2,3) and (prize = 0 or prize is null) and hasoption!=1 and g_type=3";
		$con     = "uniacid='{$_W['uniacid']}' and isshow in(1,2,3) and (prize = 0 or prize is null)  and g_type=3";
		
		$keyword = $_GPC['keyword'];
		if ($keyword != '') {
			$con .= " and gname LIKE '%{$keyword}%' ";
		}
		$ds = pdo_fetchall("select id,gimg,gname,gprice,groupnum from" . tablename('tg_goods') . "where $con ");
		foreach($ds as $k=>&$v){
			$v['gimg'] = tomedia($v['gimg']);
		}
		include wl_template('application/lottery/select_goods');
		exit;
	}
	/*本次抽奖团详情*/
	if ($todo == 'detail') {
		/*复制活动*/
		if($_GPC['copy']){
			$lottery_id = $_GPC['lottery_id'];
			$lottery = pdo_fetch("select * from".tablename('tg_lottery')."where uniacid=:uniacid and id=:id  ",array(':uniacid'=>$_W['uniacid'],':id'=>$lottery_id));
			unset($lottery['id']);
			unset($lottery['starttime']);
			unset($lottery['endtime']);
			unset($lottery['fk_goodsid']);
			unset($lottery['gname']);
			unset($lottery['gimg']);
			unset($lottery['dostatus']);
			$lottery['status']=2;
			pdo_insert("tg_lottery",$lottery);
			message("复制成功",web_url('application/lottery/list'));exit;
		}
		//删除活动
		if($_GPC['delete']){
			$lottery_id = $_GPC['lottery_id'];
			$lottery = pdo_fetch("select fk_goodsid from".tablename('tg_lottery')."where uniacid=:uniacid and id=:id  ",array(':uniacid'=>$_W['uniacid'],':id'=>$lottery_id));
			pdo_delete("tg_lottery",array('id'=>$lottery_id));
			pdo_update('tg_goods',array('prize'=>0),array('id'=>$lottery['fk_goodsid']));
			message("删除成功",web_url('application/lottery/list',array('status'=>3)));exit;
		}
		$type = !empty($_GPC['type']) ? $_GPC['type']: 'group' ;
		$lottery_id = $_GPC['lottery_id'];
		$lottery = pdo_fetch("select id,gname,gimg,endtime,status,num,num2,num3,prize,dostatus from".tablename('tg_lottery')."where uniacid=:uniacid and id=:id  ",array(':uniacid'=>$_W['uniacid'],':id'=>$lottery_id));
		$prize = unserialize($lottery['prize']);
		$alltuan = pdo_fetchall("select neednum,lacknum,groupnumber from" . tablename('tg_group') . "where  uniacid='{$_W['uniacid']}' AND lacknum <>neednum   and lottery_id = {$lottery_id}");
		$all = count($alltuan);
		$orders = 0;
		foreach ($alltuan as $key => $value) {
			$orders += $value['neednum']-$value['lacknum'];
		}
		if($type == 'group'){
			//更新团状态
			$groupstatus = $_GPC['groupstatus'];
			$will_die = $_GPC['will_die'];
			$pindex = max(1, intval($_GPC['page']));
			$psize = 10;
			$allgoods = pdo_fetchall("select gname from".tablename('tg_goods')."where uniacid=:uniacid and isshow=:isshow  ",array(':uniacid'=>$_W['uniacid'],':isshow'=>1));
			$condition = "uniacid = {$_W['uniacid']} and lottery_id={$lottery_id}  ";
			
			$alltuan = pdo_fetchall("select * from" . tablename('tg_group') . "where $condition AND lacknum <> neednum order by id desc " . "LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			$total = pdo_fetchcolumn("select COUNT(id) from" . tablename('tg_group') . "where $condition AND lacknum <>neednum order by id desc ");
			$pager = pagination($total, $pindex, $psize);
		}
		if($type == 'order'){
			$pindex = max(1, intval($_GPC['page']));
			$psize = 10;
			$con = '';
			if($_GPC['keyword']){
				$con .= " AND (addname LIKE '%{$_GPC['keyword']}%' or  mobile LIKE '%{$_GPC['keyword']}%')";
			}
			$list = pdo_fetchall("select optionname,openid,is_hexiao,orderno,createtime,address,addname,mobile,status,pay_price,lottery_status,id from".tablename('tg_order')."where status in(1,2,3,4,6,7,10) and lottery_status in(-1,1,2,3,4,5,6,7) and lotteryid={$lottery_id} $con  order by id desc " . "LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			$total = pdo_fetchcolumn("select COUNT(id) from" . tablename('tg_order') . "where status in(1,2,3,4,6,7,10) and lotteryid={$lottery_id} ");
			$pager = pagination($total, $pindex, $psize);	
			foreach($list as$key=>&$value){
				$value['member'] = pdo_fetch("select avatar from".tablename('tg_member')."where openid='{$value['openid']}'");
			}	
			if($_GPC['setone']){
				$id = $_GPC['id'];
				$lottery_status = $_GPC['lottery_status'];
				if($id){
					pdo_update("tg_order",array('lottery_status'=>$lottery_status),array('id'=>$id));
					die(json_encode(array('errno'=>1)));
				}
			}
		}
		if($type == 'process'){
			$lottery_status = !empty($_GPC['lottery_status'])?$_GPC['lottery_status']:2;
			$lottery_staadd = $lottery_status+3;
			$lottery_sta = " lottery_status in(".$lottery_status.",".$lottery_staadd.")";
			$list = pdo_fetchall("select is_hexiao,orderno,createtime,address,addname,mobile,status,pay_price,lottery_status,id,openid from".tablename('tg_order')."where status in(1,2,3,4,6,7)  and lotteryid={$lottery_id} and  {$lottery_sta}  order by id desc ");
			foreach($list as$key=>&$value){
				$value['member'] = pdo_fetch("select avatar from".tablename('tg_member')."where openid='{$value['openid']}'");
			}	
		}
		include wl_template('application/lottery/lottery_list');exit;
	}
}

if ($op == 'group') {
	$todo = !empty($_GPC['todo']) ? $_GPC['todo'] : 'group_detail';
	if($todo=='group_detail'){
		$groupnumber = intval($_GPC['groupnumber']);
		$thistuan = pdo_fetch("select * from" . tablename('tg_group') . "where groupnumber = '{$groupnumber}' and uniacid='{$_W['uniacid']}'");
		$lottery_id = $thistuan['lottery_id'];
		$goods = pdo_fetch("select * from".tablename('tg_lottery')."where uniacid={$_W['uniacid']} and id={$lottery_id}");
		$orders = pdo_fetchall("SELECT * FROM " . tablename('tg_order') . " WHERE tuan_id = '{$groupnumber}' and uniacid='{$_W['uniacid']}' ORDER BY createtime desc");
		foreach($orders as$key=>&$value){
			$value['member'] = pdo_fetch("select avatar from".tablename('tg_member')."where openid='{$value['openid']}'");
		}	
	}
	include wl_template('application/lottery/lottery_groups');
}

if($op == 'create'){
	$time = time();
	if(empty($starttime)){
		$starttime = time();
		$endtime =  time() + 7*24*3600;
	}
	$sql = "select * from".tablename('tg_coupon_template')."  WHERE uniacid = {$_W['uniacid']} and   `start_time` < '{$time}' AND `end_time` > '{$time}'";
	$tg_coupon_templates = pdo_fetchall($sql,$params);
	$lotteryid = $_GPC['id'];
	if($lotteryid){
		$goods = pdo_fetch("select * from".tablename('tg_lottery')."where uniacid={$_W['uniacid']} and id={$lotteryid}");
		$prize = unserialize($goods['prize']);
		$endtime = $goods['endtime'];
		$starttime = $goods['starttime'];
		$piclist = unserialize($goods['imgs']);
	}
	if (checksubmit('submit')) {
		$goods = $_GPC['goods'];
		if(!is_numeric($goods['num']) || $goods['num']<1) message("商品奖品错误");
		if($goods['fk_goodsid']){
			$thisgoods = pdo_fetch("select is_hexiao from".tablename("tg_goods")."where id = {$goods['fk_goodsid']}");
			if($thisgoods['prize']!=1){
				pdo_update("tg_goods",array('prize'=>1,'isshow'=>1),array('id'=>$goods['fk_goodsid']));
			}
		}
		$goods['gdesc'] = htmlspecialchars_decode($goods['gdesc']);
		$time = $_GPC['time'];
		$self = $_GPC['self'];
		$first = $_GPC['first'];
		$second = $_GPC['second'];
		$prize = array(
			'self'=>$self,
			'first' =>$first,
			'second'=>$second
		);
		$prize = serialize($prize);
		$goods['prize'] = $prize;
		$goods['starttime'] = strtotime($time['start']);
		$goods['endtime'] = strtotime($time['end']);
		if($goods['starttime']>time()){
			$goods['status'] = 2;//未开始
		}
		if($goods['starttime']<time() && $goods['endtime']>time()){
			$goods['status'] = 1;//进行中
		}
		if($goods['starttime']<time() && $goods['endtime']<time()){
			$goods['status'] = 3;//已结束
		}
		$goods['uniacid'] = $_W['uniacid'];
		$goods['createtime'] = time();
		
		if (empty($lotteryid)) {
			pdo_insert('tg_lottery',$goods);
			message('创建成功', web_url('application/lottery/list'), 'success');exit;
		} else {
			pdo_update('tg_lottery',$goods, array('id' => $lotteryid));
			message('更新成功', web_url('application/lottery/list'), 'success');exit;
			
		}
	}
	include wl_template('application/lottery/lottery_edit');exit;
}

if ($op == 'cover') {
	load()->model('reply');
	$url = app_url('goods/lottery');
	$name = '抽奖团入口';
	
	$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => TG_NAME . $name . '入口设置'));
	
	if (!empty($rule)) {
		$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
		$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
	}
	
	if (checksubmit('submit')) {
		$data = (is_array($_GPC['cover']) ? $_GPC['cover'] : array());
	
		if (empty($data['keyword'])) {
			message('请输入关键词!');
		}
		$keyword1 = keyExist($data['keyword']);
		if (!empty($keyword1)) {
			if ($keyword1['name'] != (TG_NAME . $name . '入口设置')) {
				message('关键字已存在!');
			}
		}
		if (!empty($rule)) {
			pdo_delete('rule', array('id' => $rule['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('rule_keyword', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('cover_reply', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
		}
	
		$rule_data = array('uniacid' => $_W['uniacid'], 'name' => TG_NAME . $name . '入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => intval($data['status']));
		pdo_insert('rule', $rule_data);
		$rid = pdo_insertid();
		
		$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => intval($data['status']));
		pdo_insert('rule_keyword', $keyword_data);
		
		$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => TG_NAME, 'title' => trim($data['title']), 'description' => trim($data['desc']), 'thumb' => $data['thumb'], 'url' => $url);
		pdo_insert('cover_reply', $cover_data);
		message('保存成功！');
	}
	
	$cover = array('rule' => $rule, 'cover' => $cover, 'keyword' => $keyword, 'url' => $url,'name' => $name);
	
	include wl_template('store/cover');
}
if ($op == 'page'){
	wl_load()->model('setting');
	$page1 = tgsetting_read('lotery_page1');
	$page2 = tgsetting_read('lotery_page2');
//	wl_debug($page1);
	$page1Data = $_GPC['page1'];
	$page2Data = $_GPC['page2'];
	if (checksubmit('submit')) {
		tgsetting_save($page1Data,'lotery_page1');
		tgsetting_save($page2Data,'lotery_page2');
		message('保存成功！');
	}
	include wl_template('application/lottery/page');
}
